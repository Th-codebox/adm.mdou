<?php

class RequestController extends BackEndController
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column1';

	/**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionView($id)
	{
		if (!Yii::app()->user->checkAccess('readRequest'))
			throw new CHttpException(403,'Недостаточно прав для выполнения операции');

		if (isset($_GET['ajax'])) {
			$this->renderPartial('_viewdetails',array(
				'model'=>$this->loadModel($id),
			));
		}
		else {
			$this->render('view',array(
				'model'=>$this->loadModel($id),
			));
		}
	}

	/**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionAdmin()
	{
		if (!Yii::app()->user->checkAccess('readRequest'))
			throw new CHttpException(403,'Недостаточно прав для выполнения операции');

		Yii::app()->user->setReturnUrl(Yii::app()->request->url);

		$dataProvider=new CActiveDataProvider('Request', array(
			'criteria'=>array(
				'condition'=>'status<>:status',
				'params'=>array(':status'=>Request::STATUS_NOTCOMPLETED),
				'limit'=>10,
			),
			'sort'=>array(
				'defaultOrder'=>'update_time DESC'
//				'defaultOrder'=>'queue_number ASC'
			),
		));

		$this->render('admin', array(
			'dataProvider'=>$dataProvider
		));
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		if (!Yii::app()->user->checkAccess('createRequest'))
			throw new CHttpException(403,'Недостаточно прав для выполнения операции');

		$model=new Request;
		$model->applicant = new Person;

		$model->status = Request::STATUS_UNPROCESSED;

		// Uncomment the following line if AJAX validation is needed
		//$this->performAjaxValidation($model);

		$model->applicant->setScenario('requester');
		
		if(isset($_POST['Request']))
		{
			$model->attributes=$_POST['Request'];
			$model->reg_number = 0;
			$model->generateNewQueueNumber();
			$model->is_internet = 0;
			$model->filing_date = new CDbExpression('NOW()');
			
			// создаем заявителя
			$model->applicant->is_applicant = 1;
			$model->applicant->attributes = $_POST['Person'];

			// Вставка нового заявления в БД
			$attr = array('surname', 'name', 'patronymic', 'birth_date', 'document_series', 'document_number', 'document_date');
			if($model->validate($attr) && $model->applicant->validate()) {
				$model->surname = Util::ucfirst($model->surname);
				$model->name = Util::ucfirst($model->name);
				$model->patronymic = Util::ucfirst($model->patronymic);
				
				$model->insert();
				// генерим рег. номер
				$model->generateRegNumber();
//				$model->saveAttributes(array('reg_number' => $model->reg_number));
				$model->logQueueNumber(QueueLog::TYPE_ENQUEUE);	// запоминаем номер очереди
				
				$model->applicant->request_id = $model->id;
				$model->applicant->save();
				
				// создаем юзера для данного заявления
				$user = new User;
				$user->username = $model->reg_number;
				$user->password = $model->reg_number;
				$user->password_repeat = $model->reg_number;
				$user->name = '';
				$user->create_user_id = Yii::app()->user->id;
				$user->save();

				$model->user_id = $user->id;
				
				// Выполняем операцию подачи заявления
				$operation = Operation::model()->findByPk(Operation::OPERATION_APPLY);
				$newStatus = $operation->getNewStatus();
				$logRecord = new OperationLog();
				$logRecord->operation_id = $operation->id;
				$logRecord->request_id = $model->id;
				$logRecord->old_status = Request::STATUS_NOTCOMPLETED;
				$logRecord->new_status = $newStatus;
				$logRecord->queue_number = $model->queue_number;
				$logRecord->save();
				
				$model->status = $newStatus;
				
				$model->saveAttributes(array('user_id', 'reg_number', 'status'));
								
				Yii::app()->user->setFlash("requestupdate", "Добавлено новое заявление");
				$this->redirect("?r=request/update&id=".$model->id."#tab2");
			}
		}

		$this->render('create',array(
			'model'=>$model,
           ));
	}

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($id)
	{
		if (!Yii::app()->user->checkAccess('updateRequest'))
			throw new CHttpException(403,'Недостаточно прав для выполнения операции');

		$returnUrl = isset(Yii::app()->user->returnUrl) ? Yii::app()->user->returnUrl : array('admin');

		$model=$this->loadModel($id);
		
		if (!isset($model->applicant)) {
			$model->applicant = new Person;
			$model->applicant->request_id = $model->id;
			$model->applicant->is_applicant = 1;
			$model->applicant->save(false);
		}
		
		// Uncomment the following line if AJAX validation is needed
		//$this->performAjaxValidation($model);

        if(isset($_POST['Request']))
		{
			$model->attributes=$_POST['Request'];
			
			if($model->applicant->validate() && $model->validate()) {
				if (!isset($model->user)) {
					// создаем юзера для данного заявления
					$user = new User;
					$user->username = $model->reg_number;
					$user->password = $model->reg_number;
					$user->password_repeat = $model->reg_number;
					$user->create_user_id = Yii::app()->user->id;
					$user->insert();

					$model->user_id = $user->id;
					$model->user = $user;
				}
				$model->user->name = $model->applicant->full_name;
				$model->user->save();

				if ($model->status == Request::STATUS_UNPROCESSED && !$model->is_internet) {
					// Выполняем операцию регистрации
					$operation = Operation::model()->findByPk(Operation::OPERATION_REGISTER);
					$newStatus = $operation->getNewStatus();
					$logRecord = new OperationLog();
					$logRecord->operation_id = $operation->id;
					$logRecord->request_id = $model->id;
					$logRecord->old_status = $model->status;
					$logRecord->new_status = $newStatus;
					$logRecord->queue_number = $model->queue_number;
					$logRecord->save();

					$model->register_date = new CDbExpression('NOW()');
					$model->status = $newStatus;
					
					$logRecord->sendEmailNotification();
					
					$returnUrl = array("request/operation", "id"=>$model->id);
				}

				$model->save(false);
				
				$nurseries = isset($_POST['Request']['nurseries']) ? $_POST['Request']['nurseries'] : array();
				$cnt = 0;
				$ok = 1;
				foreach ($nurseries as $nid) {
					if (Nursery::model()->findByPk($nid) === null)
						$ok = 0;
					$cnt++;
				}
				if ($ok == 1 && $cnt <= 3) {
					$model->nurseries = $nurseries;
					$model->saveNurseries();
				}

				Yii::app()->user->setFlash("requestupdate", "Параметры заявления изменены");
				Yii::app()->user->setFlash("requestoperation", "Параметры заявления изменены");

				$this->redirect(array("request/operation", "id"=>$model->id));

//				$this->redirect(array('index'));
			}
		}		

		$this->render('update',array(
			'model'=>$model,
        ));
	}

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'index' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDelete($id)
	{
		if(Yii::app()->request->isPostRequest && Yii::app()->user->checkAccess('deleteRequest'))
		{
/*			foreach (Request::model()->findAll(array('condition'=>'status=0')) as $request)
				if ($request->status == Request::STATUS_NOTCOMPLETED)
					$request->delete();*/
			// we only allow deletion via POST request
//			$this->loadModel($id)->delete();

			// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
			if(!isset($_GET['ajax']))
				$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
		}
		else
			throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		if (!Yii::app()->user->checkAccess('readRequest'))
			throw new CHttpException(403,'Недостаточно прав для выполнения операции');

		Yii::app()->user->setReturnUrl(Yii::app()->request->url);
		
		$criteria = new CDbCriteria;
		
		$street = isset($_GET['Request_street']) ? $_GET['Request_street'] : "";
		if (isset($street) && strlen($street) > 0) {
			if ($street != "0") {
				$criteria->addCondition('street_id=:street_id');
				$criteria->params[':street_id'] = $street;
			}
		}
		$microdistrict = isset($_GET['Request_microdistrict']) ? $_GET['Request_microdistrict'] : "";
		if (isset($microdistrict) && strlen($microdistrict) > 0) {
			if ($microdistrict != "0") {
				$criteria->addCondition('microdistrict_id=:microdistrict_id');
				$criteria->params[':microdistrict_id'] = $microdistrict;
			}
			else
				$criteria->addCondition('address_other<>""');
		}
		
		$status = isset($_GET['Request_status']) ? $_GET['Request_status'] : "";
		if (isset($status) && $status !== "") {
			$criteria->addCondition('status=:status');
			$criteria->params[':status'] = $status;
		}
		else {
//			$criteria->addCondition('status<>:status and queue_number >= 0');
			$criteria->addCondition('status<>:status');
			$criteria->params[':status'] = Request::STATUS_NOTCOMPLETED;
		}
		
		$queueType = isset($_GET['Request_queueType']) ? $_GET['Request_queueType'] : "";
		if (isset($queueType) && $queueType != Request::QUEUE_ALL) {
			if ($queueType == Request::QUEUE_PRIVILEGE) {
				$criteria->addCondition('has_privilege>0 and out_of_queue=0');
			}
			else if ($queueType == Request::QUEUE_OUT_OF_QUEUE)
				$criteria->addCondition('out_of_queue>0');
		}
		
		$disease = isset($_GET['Request_disease']) ? $_GET['Request_disease'] : "";
		if (isset($disease) && strlen($disease) > 0) {
			$criteria->addCondition('disease_id=:disease');
			$criteria->params[':disease'] = $disease;
		}
		
		$nursery = isset($_GET['Request_nursery']) ? $_GET['Request_nursery'] : "";
		if (isset($nursery) && strlen($nursery) > 0) {
			$criteria->join .= "LEFT JOIN tbl_request_nursery_assignment ON t.id=tbl_request_nursery_assignment.request_id ";
			$criteria->addCondition('tbl_request_nursery_assignment.nursery_id=:nursery_id');
			$criteria->params[':nursery_id'] = $nursery;
		}

		$privilege = isset($_GET['Request_privilege']) ? $_GET['Request_privilege'] : "";
		if (isset($privilege) && strlen($privilege) > 0) {
			$criteria->join .= "LEFT JOIN tbl_privilege_document ON t.id=tbl_privilege_document.request_id ";
			$criteria->addCondition('tbl_privilege_document.privilege_id=:privilege_id');
			$criteria->params[':privilege_id'] = $privilege;
		}

		$wordsType = isset($_GET['Request_wordsType']) ? $_GET['Request_wordsType'] : "";
		$words = isset($_GET['Request_words']) ? $_GET['Request_words'] : "";
		if (strlen($words) > 0) {
			if ($wordsType == 'full_name' ) {
				$criteria->addCondition('t.full_name like :words');
				$criteria->params[':words'] = '%'.$words.'%';
			}
			else if ($wordsType == 'document') {
				$criteria->addCondition('t.document_number=:words');
				$criteria->params[':words'] = $words;
			}
			else if ($wordsType == 'surname') {
				$criteria->addCondition('t.surname like :words');
				$criteria->params[':words'] = '%'.$words.'%';
			}
			else if ($wordsType == 'address') {
				$criteria->addCondition('t.address_other like :words');
				$criteria->params[':words'] = '%'.$words.'%';
			}
			else if ($wordsType == 'id') {
				$criteria->addCondition('t.id = :words');
				$criteria->params[':words'] = $words;
			}
			else if ($wordsType == 'code') {
				$criteria->addCondition('t.code = :words');
				$criteria->params[':words'] = $words;
			}
			else if ($wordsType == 'queue_number') {
				$criteria->addCondition('t.queue_number = :words');
				$criteria->params[':words'] = $words;
			}
		}
		
		$age = isset($_GET['Request_age']) ? $_GET['Request_age'] : "";
		if (isset($age) && strlen($age) > 0) {
			$ageTo = $age < 8 ? $age + 1 : $age + 100;
			$criteria->addBetweenCondition('FLOOR((TO_DAYS(NOW())- TO_DAYS(t.birth_date)) / 365.25)', $age, $ageTo - 0.001);
		}
		
		$archive = isset($_GET['Request_archive']) ? $_GET['Request_archive'] : "not";
		if ($archive != "all") {
			$criteria->addCondition('is_archive=:archive');
			$criteria->params[':archive'] = ($archive == 'yes') ? 1 : 0;
		}

		$apply = isset($_GET['Request_apply']) ? $_GET['Request_apply'] : "";
		if ($apply != "") {
			$criteria->addCondition('is_internet=:is_internet');
			$criteria->params[':is_internet'] = ($apply == "internet" ? 1 : 0);
		}
		
		// applying dates
		$dateType = isset($_GET['Request_dateType']) ? $_GET['Request_dateType'] : "";
		$dateFrom = isset($_GET['Request_dateFrom']) ? $_GET['Request_dateFrom'] : "";
		$dateTo = isset($_GET['Request_dateTo']) ? $_GET['Request_dateTo'] : "";
		if (strlen($dateType) > 0 && strlen($dateFrom) > 0 && strlen($dateTo) > 0) {
			if ($dateType == 'birth_date' ) {
				$criteria->addCondition('t.birth_date >= :dateFrom');
				$criteria->addCondition('t.birth_date <= :dateTo');
			}
			else if ($dateType == 'filing_date') {
				$criteria->addCondition('t.filing_date >= :dateFrom');
				$criteria->addCondition('t.filing_date <= :dateTo');
			}
			else if ($dateType == 'register_date') {
				$criteria->addCondition('t.register_date >= :dateFrom');
				$criteria->addCondition('t.register_date <= :dateTo');
			}
			$criteria->params[':dateFrom'] = $dateFrom;
			$criteria->params[':dateTo'] = $dateTo;
		}
		else if (strlen($dateType) > 0 && strlen($dateFrom) > 0 && strlen($dateTo) == 0) {
			if ($dateType == 'birth_date' )
				$criteria->addCondition('t.birth_date = :dateFrom');
			else if ($dateType == 'filing_date')
				$criteria->addCondition('t.filing_date = :dateFrom');
			else if ($dateType == 'register_date')
				$criteria->addCondition('t.register_date = :dateFrom');
			$criteria->params[':dateFrom'] = $dateFrom;
		}
		
		$dataProvider=new CActiveDataProvider('Request', array(
			'criteria'=>$criteria,
			'sort'=>array(
				'defaultOrder'=>'id DESC'
//				'defaultOrder'=>'queue_number ASC'
			),
			'pagination'=>array(
				'pageSize'=> isset($_GET['Request_pageSize']) ? $_GET['Request_pageSize'] : 50,
			),
		));
		
/*		$microdistricts = array_merge(CHtml::listData(Microdistrict::$other, 'id', 'name'), CHtml::listData(Microdistrict::model()->findAll(array(
				'order'=>'name ASC'
			)),
			'id', 'name'
		));*/
		$microdistricts = CHtml::listData(Microdistrict::model()->findAll(array(
				'order'=>'name ASC'
			)),
			'id', 'name'
		);
		
		if (isset($microdistrict) && $microdistrict != "") {
			$streetCriteria = new CDbCriteria;
			$streetCriteria->alias = "street";
			$streetCriteria->join =
				"LEFT JOIN tbl_microdistrict_street_assignment ON street.id=tbl_microdistrict_street_assignment.street_id";
			$streetCriteria->addCondition('tbl_microdistrict_street_assignment.microdistrict_id=:microdistrict_id');
			$streetCriteria->params[':microdistrict_id'] = $microdistrict;

			$streetCriteria->order = "name ASC";

			$streets = CHtml::listData(Street::model()->findAll(
					$streetCriteria
				),
				'id', 'NameReversed' // Name - вызов функции getName();
			);
		}
		else {
			$streets = CHtml::listData(Street::model()->findAll(array(
					'order' => 'name',
				)),
				'id', 'NameReversed' // Name - вызов функции getName();
			);
		}
		
		$nurseries = CHtml::listData(Nursery::model()->findAll(array(
				'order'=>'short_number ASC, name ASC'
			)), 
			'id', 'name'
		);

		$privileges = CHtml::listData(Privilege::model()->findAll(array(
				'order'=>'id ASC'
			)),
			'id', 'name'
		);

		$diseases = CHtml::listData(Disease::model()->findAll(array(
				'order'=>'name ASC'
			)),
			'id', 'name'
		);

		if (isset($_GET['ajax'])) {
			$this->renderPartial('_indexgrid',array(
				'dataProvider'=>$dataProvider,
				'microdistricts'=>$microdistricts,
				'streets'=>$streets,
				'nurseries'=>$nurseries,
				'privileges'=>$privileges,
				'diseases'=>$diseases
			));
		}
		else {
			$this->render('index',array(
				'dataProvider'=>$dataProvider,
				'microdistricts'=>$microdistricts,
				'streets'=>$streets,
				'nurseries'=>$nurseries,
				'privileges'=>$privileges,
				'diseases'=>$diseases
			));
		}
	}
	
	/**
	 * Перечень доступных операций.
	 */
	public function actionOperation($id)
	{
		if (!Yii::app()->user->checkAccess('updateRequest'))
			throw new CHttpException(403,'Недостаточно прав для выполнения операции');

		$model = $this->loadModel($id);
		
		if (isset($_GET['operationId'])) {
			$operationId = $_GET['operationId'];
			$operation = Operation::model()->findByPk($operationId);
			if (isset($operation) && isset($_POST['OperationLog'])) {
//				$log = new OperationLog();
				if (OperationLog::applyOperation($model, $operation, $_POST['OperationLog'])) {
					Yii::app()->user->setFlash("requestoperation", "Операция '".$operation->getName()."' выполнена успешно");

					$this->redirect(array('operation', "id"=>$model->id));
				}
				
/*
				// нужна проверка на возможность проведения операции
				$newStatus = $operation->getNewStatus();
				$logRecord = new OperationLog();
				$logRecord->operation_id = $operationId;
				$logRecord->request_id = $id;
				$logRecord->old_status = $model->status;
				$logRecord->new_status = $newStatus;
				$logRecord->granted_nursery_id = 0;
				$logRecord->granted_group_id = 0;
				$logRecord->attributes = $_POST['OperationLog'];
				
				if (($logRecord->comment == null || strlen($logRecord->comment) == 0) && $operation->is_comment_required) {
					$model->addError("", "Для данной операции необходимо указать комментарий");
				}
				else if ((!isset($logRecord->reason_id) || $logRecord->reason_id == '') && $operation->hasReason()) {
					$model->addError("", "Для данной операции необходимо указать причину");
				}
				else if ($logRecord->validate()) {
					if ($operation->id == Operation::OPERATION_REGISTER) {	// регистрация
						$model->register_date = new CDbExpression('NOW()');
						
						if (!$model->is_internet && !$model->is_restore)	// если подано не через интернет и не является восстановленным из архива
							$logRecord->temporary_password = $model->changePassword();  // генерим пароль

						if ($model->is_email_confirm && $model->email != '') {
							Util::sendEmail($model->email, 'Уведомление о регистрации заявления на постановку ребенка в очередь', 
								$this->renderPartial('email/registerNotification', array('model'=>$model), true)
							);
						}
					}
					
					if ($operation->id == Operation::OPERATION_ENQUEUE) {	// предоставить место
						if ($model->is_email_confirm && $model->email != '') {
							Util::sendEmail($model->email, 'Уведомление о постановке ребенка в очередь', 
								$this->renderPartial('email/enqueueNotification', array('model'=>$model), true)
							);
						}					
					}

					if ($operation->id == Operation::OPERATION_GRANT_PLACE) {	// предоставить место
						$nursery = Nursery::model()->findByPk($logRecord->granted_nursery_id);
						$group = NurseryGroup::model()->findByPk($logRecord->granted_group_id);

						if (isset($nursery) && isset($group)) {	// если выбраны МДОУ и группа, уменьшаем количество свободных мест
							if ($group->free_places > 0) {
								$group->free_places--;
								$group->save(false, array('free_places'));
								
								if ($model->is_email_confirm && $model->email != '') {
									Util::sendEmail($model->email, 'Уведомление о предоставлении места ребенку в МДОУ', 
										$this->renderPartial('email/placeNotification', array(
											'model'=>$model,
											'nursery'=>$nursery,
											'group'=>$group,
										), true)
									);
								}
							}
							else
								$model->addError("", "В выбранной группе нет свободных мест");
						}
						else
							$model->addError("", "Для данной операции необходимо указать МДОУ и группу");
					}
					if ($operation->id == Operation::OPERATION_CANCEL_PLACE || $operation->id == Operation::OPERATION_ANNUL_PLACE
						|| $operation->id == Operation::OPERATION_ANNUL_ENROLLMENT) {
						// отменить предоставление места или аннулировать предоставление места или аннулировать зачисление
						$operationGrantLog = OperationLog::model()->find(array(
							'condition'=>'request_id=:request_id and operation_id=:operation_id',
							'params'=>array(':request_id'=>$model->id, ':operation_id'=>Operation::OPERATION_GRANT_PLACE),
							'order'=>'id DESC'
						));
						if (isset($operationGrantLog)) {
							$group = NurseryGroup::model()->findByPk($operationGrantLog->granted_group_id);
							if (isset($group)) {
//								if ($group->free_places < $group->total_places) {
									$group->free_places++;
									$group->save(false, array('free_places'));
//								}
//								else
//									$model->addError("", "В выбранной группе количество свободных мест равно общему количеству мест");
							}
							else
								$model->addError("", "Не найдена группа, указанная в предшествующей операции предоставления места");
						}
						else
							$model->addError("", "Не найдена предшествующая операция предоставления места");
					}
					
					if ($operation->id == Operation::OPERATION_CHANGE_PASSWORD) { // сменить пароль
						$logRecord->temporary_password = $model->changePassword();

						if ($model->is_email_confirm && $model->email != '') {
							Util::sendEmail($model->email, 'Уведомление о смене пароля для заявления на постановку ребенка в очередь', 
								$this->renderPartial('email/passwordNotification', array('model'=>$model), true)
							);
						}
					}

					if ($operation->id == Operation::OPERATION_ENROLL) {	// зачислить
						$operationGrantLog = OperationLog::model()->find(array(
							'condition'=>'request_id=:request_id and operation_id=:operation_id',
							'params'=>array(':request_id'=>$model->id, ':operation_id'=>Operation::OPERATION_GRANT_PLACE),
							'order'=>'id DESC'
						));
						if (isset($operationGrantLog)) {
							$direction = new RequestNurseryDirection;
							$direction->request_id = $model->id;
							$direction->nursery_id = $operationGrantLog->granted_nursery_id;
							$direction->group_id = $operationGrantLog->granted_group_id;
							
							$direction->generateNewRegNumber();
							if ($direction->save()) {
								$logRecord->direction_id = $direction->id;
								
								$nursery = Nursery::model()->findByPk($operationGrantLog->granted_nursery_id);
								$group = NurseryGroup::model()->findByPk($operationGrantLog->granted_group_id);
								
								if ($model->is_email_confirm && $model->email != '') {
									Util::sendEmail($model->email, 'Уведомление о зачислении ребенка в МДОУ', 
										$this->renderPartial('email/enrollNotification', array(
											'model'=>$model,
											'nursery'=>$nursery,
											'group'=>$group,
										), true)
									);
								}								
							}
							else {
								$model->addError("", "Произошла ошибка при создании направления");
							}
						}
						else {
							$model->addError("", "Не найдена предшествующая операция предоставления места");
						}
					}
					
					if ($operation->id == Operation::OPERATION_RESTORE) {	// вернуть из архива
						if ($model->queue_number == Request::QUEUE_NUMBER_NONE)	// если -1, то вернуть в статус Активно
							$model->status = Request::STATUS_ACCEPTED;
						else
							$model->status = Request::STATUS_ACTIVE;

						$model->is_restore = 1;
					}
					
					if ($operation->is_remove_from_queue) {	// удаление из очереди и помещение в архив
						$newQueueNumber = $operation->queue_number_remove;	// присвоим номер в очереди, указанный для данной операции
						if ($model->queue_number != $newQueueNumber) {
							$model->queue_number = $newQueueNumber;
							$model->logQueueNumber(QueueLog::TYPE_REMOVE);
						}
						$model->is_archive = 1;
					}
					else {
						$model->is_archive = 0;
				
						if ($model->queue_number == Request::QUEUE_NUMBER_NONE) {
							$model->generateNewQueueNumber();
							if ($operation->id == Operation::OPERATION_RESTORE)
								$model->logQueueNumber(QueueLog::TYPE_RESTORE);
							else
								$model->logQueueNumber(QueueLog::TYPE_ENQUEUE);
						}
					}
					
					if (!$model->hasErrors()) {
						if ($operation->is_change_status) // операция предусматривает смену статуса
							$model->status = $newStatus;
					
						$logRecord->queue_number = $model->queue_number;
					
						if ($logRecord->save())
							$model->save(false);	// !!! может, стоит убрать false?
						else
							$model->addError("", "Произошла ошибка при выполнении операции");
					}
					if (!$model->hasErrors())
						$this->redirect(array('operation', "id"=>$model->id));
			    }*/
			}
		}
		
		$this->render('operation',array(
			'model'=>$model,
		));
	}
	
	/**
	 * Lists all models.
	 */
	public function actionQueueLog($id)
	{
		$model=$this->loadModel($id);
		if (!Yii::app()->user->checkAccess('readRequest'))
			throw new CHttpException(403,'Недостаточно прав для выполнения операции');

		$criteria = new CDbCriteria;
		
		$dataProvider=new CActiveDataProvider('QueueLog', array(
			'criteria'=>array(
				'condition'=>'request_id=:request_id',
				'params'=>array(':request_id'=>$model->id)
			),
			'sort'=>array(
				'defaultOrder'=>'create_time DESC'
			),
			'pagination'=>array(
				'pageSize'=> 50,
			),
		));
		
		if (isset($_GET['ajax'])) {
			$this->renderPartial('queueLog',array(
				'dataProvider'=>$dataProvider,
				'model'=>$model
			));
		}
		else {
			$this->render('queueLog',array(
				'dataProvider'=>$dataProvider,
				'model'=>$model
			));
		}
	}
	
	/**
	 * Вывод списка родителей / представителей
	 * @param integer $id the ID of the request
	 */
	public function actionParentList($id)
	{
		if (!Yii::app()->user->checkAccess('updateRequest'))
			throw new CHttpException(403,'Недостаточно прав для выполнения операции');

		$this->renderPartial('tabs/_parentlist',array(
			'model'=>$this->loadModel($id),
		));
	}
	
	/**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionParentForm($id)
	{
		if (!Yii::app()->user->checkAccess('updateRequest'))
			throw new CHttpException(403,'Недостаточно прав для выполнения операции');

		if (isset($_GET['id'])) {
			if (isset($_GET['parentId']) && $_GET['parentId'])
				$person = Person::model()->findByPk($_GET['parentId']);
			else {
				$person = new Person;
				$person->request_id = $_GET['id'];
			}
			if (isset($_POST['Person'])) {
				$person->attributes = $_POST['Person'];
				if ($person->save()) {
					print "ok";
					Yii::app()->end();
				}
			}
			
			$this->renderPartial('tabs/_parentform',array(
				'model'=>$person
			));
		}
		else
			throw new CHttpException(404,'The requested page does not exist.');

/*		if (isset($_GET['ajax'])) {
			$person = new Person;
			if (isset($_GET['parentId'])) {
				$person = Person::model()->findByPk($_GET['parentId']);
			}
			$this->renderPartial('tabs/_parentform',array(
				'model'=>$person
			));
		}*/
	}
	
	/**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionCreateParent($id)
	{
		if (!Yii::app()->user->checkAccess('updateRequest'))
			throw new CHttpException(403,'Недостаточно прав для выполнения операции');

		if (isset($_GET['id'])) {
			$person = new Person;
			$person->request_id = $_GET['id'];
			if (isset($_POST['Person'])) {
				$person->attributes = $_POST['Person'];
				if ($person->save()) {
					print "ok";
					Yii::app()->end();
				}
			}
			
			$this->renderPartial('tabs/_parentform',array(
				'model'=>$person
			), false, true);
		}
		else
			throw new CHttpException(404,'The requested page does not exist.');
	}

	/**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionUpdateParent($id)
	{
		if (!Yii::app()->user->checkAccess('updateRequest'))
			throw new CHttpException(403,'Недостаточно прав для выполнения операции');

		if (isset($_GET['id'])) {
			if (isset($_GET['parentId']) && $_GET['parentId'] !== 0) {
				$person = Person::model()->findByPk($_GET['parentId']);
				if (isset($_POST['Person'])) {
					$person->attributes = $_POST['Person'];
					if ($person->save()) {
						print "ok";
						Yii::app()->end();
					}
				}
				$this->renderPartial('tabs/_parentform',array(
					'model'=>$person,
				), false, true);
			}			
		}
		else
			throw new CHttpException(404,'The requested page does not exist.');
	}
	
	/**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionDeleteParent($id)
	{
		if (!Yii::app()->user->checkAccess('updateRequest'))
			throw new CHttpException(403,'Недостаточно прав для выполнения операции');

		if (isset($_GET['parentId']) && $_GET['parentId'] !== 0) {
			$person = Person::model()->findByPk($_GET['parentId']);
			if (isset($person))
				$person->delete();
			print "ok";
			Yii::app()->end();
		}
		else
			throw new CHttpException(404,'The requested page does not exist.');
	}



	/**
	 * Вывод списка льгот
	 * @param integer $id the ID of the request
	 */
	public function actionPrivilegeList($id)
	{
		if (!Yii::app()->user->checkAccess('updateRequest'))
			throw new CHttpException(403,'Недостаточно прав для выполнения операции');

		$this->renderPartial('tabs/_privilegelist',array(
			'model'=>$this->loadModel($id),
		));
	}
	
	/**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionCreatePrivilegeDocument($id)
	{
		if (!Yii::app()->user->checkAccess('updateRequest'))
			throw new CHttpException(403,'Недостаточно прав для выполнения операции');


		if (isset($_GET['id'])) {
			$model = $this->loadModel($id);
			$privilegeDocument = new PrivilegeDocument;
			$privilegeDocument->request_id = $_GET['id'];
			if (isset($_POST['PrivilegeDocument'])) {
				$privilegeDocument->attributes = $_POST['PrivilegeDocument'];
				if ($privilegeDocument->save()) {
//					if ($privilegeDocument->privilege->out_of_queue)
//						$model->out_of_queue++;

//					$model->has_privilege++;
//					$model->save(false);
					print "ok";
					Yii::app()->end();
				}
			}
			
			$this->renderPartial('tabs/_privilegeform',array(
				'model'=>$privilegeDocument
			), false, true);
		}
		else
			throw new CHttpException(404,'The requested page does not exist.');
	}

	/**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionUpdatePrivilegeDocument($id)
	{
		if (!Yii::app()->user->checkAccess('updateRequest'))
			throw new CHttpException(403,'Недостаточно прав для выполнения операции');

		if (isset($_GET['id'])) {
			$model = $this->loadModel($id);
			if (isset($_GET['privilegeDocumentId']) && $_GET['privilegeDocumentId'] !== 0) {
				$privilegeDocument = PrivilegeDocument::model()->findByPk($_GET['privilegeDocumentId']);
//				if ($privilegeDocument->privilege->out_of_queue)
//					$model->out_of_queue--;

				if (isset($_POST['PrivilegeDocument'])) {
					$privilegeDocument->attributes = $_POST['PrivilegeDocument'];
					if ($privilegeDocument->save()) {
//						if ($privilegeDocument->privilege->out_of_queue)
//							$model->out_of_queue--;
						$model->save(false);

						print "ok";
						Yii::app()->end();
					}
				}
				$this->renderPartial('tabs/_privilegeform',array(
					'model'=>$privilegeDocument,
				), false, true);
			}
			
		}
		else
			throw new CHttpException(404,'The requested page does not exist.');
	}

	/**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionDeletePrivilegeDocument($id)
	{
		if (!Yii::app()->user->checkAccess('updateRequest'))
			throw new CHttpException(403,'Недостаточно прав для выполнения операции');

		$model = $this->loadModel($id);
		if (isset($_GET['privilegeDocumentId']) && $_GET['privilegeDocumentId'] !== 0) {
			$privilegeDocument = PrivilegeDocument::model()->findByPk($_GET['privilegeDocumentId']);
//			if ($privilegeDocument->privilege->out_of_queue)
//				$model->out_of_queue--;
			if ($privilegeDocument->delete()) {
//				$model->has_privilege--;
				$model->save(false);
				print "ok";
				Yii::app()->end();
			}
		}
		else
			throw new CHttpException(404,'The requested page does not exist.');
	}


	/**
	 */
	public function actionRenumberQueue()
	{
		if (!Yii::app()->user->checkAccess('updateRequest'))
			throw new CHttpException(403,'Недостаточно прав для выполнения операции');
			
		$cnt = Request::model()->renumberQueue();
		if ($cnt >= 0) {
			Yii::app()->user->setFlash("queue", "Очередь пересчитана. Количество заявлений с измененными номерами: ".$cnt);			
			$this->redirect(array('request/admin'));
		}
		else
			print "Произошли ошибки во время пересчета очереди";
	}
	
	/**
	 */
/*	public function actionGenerateUserPassword($id)
	{
		if (!Yii::app()->user->checkAccess('updateRequest'))
			throw new CHttpException(403,'Недостаточно прав для выполнения операции');

		$model = $this->loadModel($id);
		if (isset($model)) {
			if (!isset($model->user))
				throw new CHttpException(404,'Не найден пользователь для заявления');

			$model->user->generatePassword();
			$password = $model->user->password;
			$model->user->encryptPassword();
			$model->user->save(false);

			$logRecord = new OperationLog();
			$logRecord->operation_id = Operation::OPERATION_CHANGE_PASSWORD;
			$logRecord->request_id = $model->id;
			$logRecord->old_status = $model->status;
			$logRecord->new_status = $model->status;
			$logRecord->comment = '';
			if (!$logRecord->save())
				throw new CHttpException(404, 'Произошла ошибка в процессе записи операции');

			$html = $this->renderPartial('reports/reportPassword', array(
				'model'=>$model,
				'password'=>$password
			), false);
			Operation::printForm('Password_'.$model->id, $html);
		}
		else {
			throw new CHttpException(404,'Заявление с данным ID не найдено');
		}		
	}*/

	/**
	 *  Вывод формы заявления для постановки в очередь
	 */
	public function actionReportApplicationForm($id)
	{
		if (!Yii::app()->user->checkAccess('readRequest'))
			throw new CHttpException(403,'Недостаточно прав для выполнения операции');

		$model = $this->loadModel($id);
		
		$html = $this->renderPartial('reports/reportRequest',array(
			'model'=>$model,
		), false);
		Operation::printForm('Application_'.$model->id, $html);
	}

	/**
	 *  Вывод уведомления об изменении пароля
	 */
	public function actionReportPasswordForm($id)
	{
		if (!Yii::app()->user->checkAccess('readRequest'))
			throw new CHttpException(403,'Недостаточно прав для выполнения операции');

		$model = $this->loadModel($id);
		
		$logRecord = OperationLog::model()->find(array(
			'condition'=>'temporary_password <> ""',
			'order'=>'create_time DESC'
		));
		if (!isset($logRecord))
			throw new CHttpException(404,'Не найдена информация об измененном пароле');
		
		$html = $this->renderPartial('reports/reportPassword', array(
			'model'=>$model,
			'password'=>$logRecord->temporary_password
		), false);
		Operation::printForm('Password_'.$model->id, $html);
	}

	/**
	 *  Вывод уведомления о постановке в очередь
	 */
	public function actionReportNotificationForm($id)
	{
		if (!Yii::app()->user->checkAccess('readRequest'))
			throw new CHttpException(403,'Недостаточно прав для выполнения операции');

		$model = $this->loadModel($id);
		
		$logRecord = OperationLog::model()->find(array(
			'condition'=>'request_id=:request_id and temporary_password <> ""',
			'order'=>'create_time DESC',
			'params'=>array('request_id'=>$model->id),
		));
		
		$html = $this->renderPartial('reports/reportNotification',array(
			'model'=>$model,
			'password'=>isset($logRecord) ? $logRecord->temporary_password : ""
		), false);
		Operation::printForm('Notification_'.$model->id, $html);
	}

	/**
	 *  Вывод формы направления в МДОУ
	 */
	public function actionReportDirectionForm($id)
	{
		if (!Yii::app()->user->checkAccess('readRequest'))
			throw new CHttpException(403,'Недостаточно прав для выполнения операции');

		$model = $this->loadModel($id);
		
		if (!isset($_GET['directionId']))
			throw new CHttpException(404, 'Не найдено направление с указанным ID');
		
		$direction = RequestNurseryDirection::model()->findByPk($_GET['directionId']);
		
		$html = $this->renderPartial('reports/reportDirection',array(
			'model'=>$model,
			'direction'=>$direction
		), false);
		Operation::printForm('Direction_'.$model->id, $html);
	}
	
	/**
	 * Проверяет, нет ли уже ребенка с таким св-вом о рождении через AJAX
	 */
	public function actionAjaxFindDuplicate()
	{
		if (!Yii::app()->user->checkAccess('accessBackend'))
			throw new CHttpException(403,'Недостаточно прав для выполнения операции');

		$id = isset($_GET['id']) ? $_GET['id'] : '0';
		$web = $_POST;
		if (!isset($web['Request'])) {
			print "";
			return;
		}

		$documentNumber = isset($web['Request']['document_number']) ? $web['Request']['document_number'] : '';
		$birthDate = isset($web['Request']['birth_date']) ? $web['Request']['birth_date'] : '';
		$surname = isset($web['Request']['surname']) ? $web['Request']['surname'] : '';
		$name = isset($web['Request']['name']) ? $web['Request']['name'] : '';

		$ok = false;
		$criteria = new CDbCriteria;
		$criteria->addCondition('id<>:id');
		$criteria->params[':id'] = $id;

		if ($birthDate != "") {
			$ok = true;
			$criteria->addCondition('birth_date=:date');
			$criteria->params[':date'] = $birthDate;
		}
		if ($surname != "") {
			$criteria->addCondition('surname=:surname');
			$criteria->params[':surname'] = $surname;
		}
		if ($name != "") {
			$criteria->addCondition('name=:name');
			$criteria->params[':name'] = $name;
		}
		if ($documentNumber != "") {
			$ok = true;
			$criteria->addCondition('document_number=:number');
			$criteria->params[':number'] = $documentNumber;
		}

		$text = "";
		if ($ok) {
			$request = Request::model()->find($criteria);
			if (isset($request))
				$text = "<b>Предупреждение!</b><br/> В системе есть ребенок с совпадающими данными: <b>".$request->getFullName()."</b><br>св-во о рождении: ".$request->getBirthDocument()
				."<br>дата рождения: <b>".$request->getBirthDate()."</b>";
		}
		
		print $text;
	}


	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer the ID of the model to be loaded
	 */
	public function loadModel($id)
	{
		$model=Request::model()->findByPk((int)$id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param CModel the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='request-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
