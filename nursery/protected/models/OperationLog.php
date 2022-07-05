<?php

/**
 * This is the model class for table "{{operation_log}}".
 *
 * The followings are the available columns in table '{{operation_log}}':
 * @property integer $id
 * @property integer $operation_id
 * @property integer $request_id
 * @property integer $old_status
 * @property integer $new_status
 * @property string $create_time
 * @property integer $create_user_id
 * @property string $comment
 *
 * The followings are the available model relations:
 */
class OperationLog extends NurseryActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return OperationLog the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{operation_log}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('operation_id, request_id, old_status, new_status', 'required'),
			array('operation_id, request_id, old_status, new_status', 'numerical', 'integerOnly'=>true),
			array('comment','length','max'=>1000),
			array('direction_id, reason_id, granted_nursery_id, granted_group_id, temporary_password','safe'),
//			array('reason_id', 'validateReason'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			'operation' => array(self::BELONGS_TO, 'Operation', 'operation_id'),
			'reason' => array(self::BELONGS_TO, 'OperationReason', 'reason_id'),
			'user' => array(self::BELONGS_TO, 'User', 'create_user_id'),
			'direction' => array(self::BELONGS_TO, 'RequestNurseryDirection', 'direction_id'),
			'request' => array(self::BELONGS_TO, 'Request', 'request_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'operation_id' => 'Операция',
			'request_id' => 'Заявление',
			'old_status' => 'Предыдущий статус',
			'new_status' => 'Новый статус',
			'comment' => 'Комментарий',
			'reason_id' => 'Причина',
			'direction_id' => 'Направление',
			'temporary_password' => 'Пароль',
			'create_time' => 'Create Time',
			'create_user_id' => 'Create User',
			'update_time' => 'Update Time',
			'update_user_id' => 'Update User',
		);
	}
	
	public function hasDirection()
	{
		return isset($this->direction);
	}
	
	
	/*
	 * Возвращает ссылку на печатный документ, соответствующий данной операции
	 */
	public function getPrintFormLink()
	{
		if ($this->operation_id == Operation::OPERATION_REGISTER)
			return CHtml::link("Заявление", array('request/reportApplicationForm', 'id'=>$this->request_id),
				array('target'=>'_blank')
			);

		if ($this->operation_id == Operation::OPERATION_ENROLL)
			return CHtml::link("Направление", array('request/reportDirectionForm', 'id'=>$this->request_id, 'directionId'=>$this->direction_id),
				array('target'=>'_blank')
			);
			
		if ($this->operation_id == Operation::OPERATION_ENQUEUE)
			return CHtml::link("Уведомление", array('request/reportNotificationForm', 'id'=>$this->request_id),
				array('target'=>'_blank')
			);

		if ($this->operation_id == Operation::OPERATION_CHANGE_PASSWORD) {
			if ($this->temporary_password !== "")
				return CHtml::link("Пароль", array('request/reportPasswordForm', 'id'=>$this->request_id),
					array('target'=>'_blank')
				);
		}

		return "&nbsp;";
	}
	
	/*
	 * Возвращает комментарий к операции
	 */
	public function getComment()
	{
		$comment = $this->comment;
		if ($this->operation_id == Operation::OPERATION_GRANT_PLACE) {
			$nursery = Nursery::model()->findByPk($this->granted_nursery_id);
			$group = NurseryGroup::model()->findByPk($this->granted_group_id);
			if (empty($nursery) || empty($group)) $comment = "";
			else $comment = $nursery->getName().", группа: ".$group->getName()."<br>".$comment;
		}
		return $comment != "" ? $comment : '&nbsp;';
	}
	
	public function getReason()
	{
		if (isset($this->reason))
			return $this->reason->getName();
		else
			return "";			
	}
	
	public function hasReason()
	{
		return isset($this->reason);
	}
	
	public function hasComment()
	{
		return $this->getComment() != "";
	}
	
	public function getUserName()
	{
		if (isset($this->user))
			return $this->user->getName();
		else
			return "";	
	}
	
	/*
	 * Обнуление временных паролей
	 */
	public static function resetTemporaryPasswords()
	{
		$command = Yii::app()->db->createCommand(
			"UPDATE tbl_operation_log SET temporary_password='' WHERE temporary_password <> '' AND create_time < DATE_SUB(NOW(), INTERVAL 1 HOUR)");
		$command->execute();
	}
	
	public function getEmailSubject()
	{
		switch ($this->operation->id) {
			case Operation::OPERATION_REGISTER :
				return 'Уведомление о регистрации заявления на постановку ребенка в очередь';
			case Operation::OPERATION_DENY :
				return 'Уведомление об отказе в постановке на учет';
			case Operation::OPERATION_REJECT :
				return 'Уведомление об отклонении заявления';
			case Operation::OPERATION_ENQUEUE :
				return 'Уведомление о постановке на учет';
			case Operation::OPERATION_DEREGISTER :
				return 'Уведомление о снятии с учета';
			case Operation::OPERATION_GRANT_PLACE :
				return 'Уведомление о предложении места в МДОУ';
			case Operation::OPERATION_CANCEL_PLACE :
				return 'Уведомление об отмене предложенного места';
			case Operation::OPERATION_ANNUL_PLACE :
				return 'Уведомление об аннулировании предложенного места';
			case Operation::OPERATION_ENROLL :
				return 'Уведомление о зачислении';
			case Operation::OPERATION_ANNUL_ENROLLMENT :
				return 'Уведомление об аннулировании зачисления';
			case Operation::OPERATION_CHANGE_PASSWORD :
				return 'Уведомление о смене пароля';
			case Operation::OPERATION_RESTORE :
				return 'Уведомление о возвращении заявления из архива';
		}
		
		return '';
	}
	
	public function sendEmailNotification()
	{
		// отправка уведомления по почте
		if ($this->request->is_email_confirm && $this->request->email != '') {
			$file = 'application.views.back.request.email.notification';
			if ($file != "") {
				$html = Yii::app()->Controller->renderPartial($file, array(
					'model'=>$this->request,
					'operation'=>$this->operation, 
					'log'=>$this,
					'title'=>$this->getEmailSubject()
				), true);
				if (!Util::sendEmail($this->request->email, $this->getEmailSubject(), $html))
					throw new CException('Произошла ошибка при отправке уведомления по электронной почте по адресу: '.$this->request->email);
			}
		}
	}
	
	/*
	 * Освобождение места в группе
	 */
	public function returnPlace()
	{
		try {
			$request = $this->request;
		
			// отменить предоставление места или аннулировать предоставление места или аннулировать зачисление
			$operationGrantLog = OperationLog::model()->find(array(
				'condition'=>'request_id=:request_id and operation_id=:operation_id',
				'params'=>array(':request_id'=>$request->id, ':operation_id'=>Operation::OPERATION_GRANT_PLACE),
			));
			if (isset($operationGrantLog)) {
				$group = NurseryGroup::model()->findByPk($operationGrantLog->granted_group_id);
				if (isset($group)) {
//					if ($group->free_places < $group->total_places) {
					$group->free_places++;
					$group->save(false, array('free_places'));
//					}
//					else
//						$request->addError("", "В выбранной группе количество свободных мест равно общему количеству мест");
				}
				else {
					$request->addError("", "Не найдена группа, указанная в предшествующей операции предоставления места");
					return false;
				}
			}
			else {
				$request->addError("", "Не найдена предшествующая операция предоставления места");
				return false;
			}
		}
		
		catch (Exception $e) {
			return false;
		}		
		
		return true;

	}

	/*
	 * Операция регистрации заявления в системе
	 */
	public function performOperationRegister()
	{
		try {
			$request = $this->request;
		
			$request->register_date = new CDbExpression('NOW()');
			$request->status = Request::STATUS_ACCEPTED;

		}
		catch (Exception $e) {
			return false;
		}		
		
		return true;
	}
	
	/*
	 * Операция отказа в постановке на учет (необработанное заявление)
	 */
	public function performOperationDeny()
	{
		try {
			$request = $this->request;
		
			$request->status = Request::STATUS_DENIED;
			$request->queue_number = Request::QUEUE_NUMBER_NONE;
			$request->is_archive = 1;
		}
		catch (Exception $e) {
			return false;
		}		
		
		return true;
	}

	/*
	 * Операция отклонить (принятое к рассмотрению заявление)
	 */
	public function performOperationReject()
	{
		try {
			$request = $this->request;
		
			$request->status = Request::STATUS_REJECTED;
			$request->queue_number = Request::QUEUE_NUMBER_NONE;
			$request->is_archive = 1;
		}
		catch (Exception $e) {
			return false;
		}		
		
		return true;
	}
	
	/*
	 * Операция постановки на учет (активное заявление)
	 */
	public function performOperationEnqueue()
	{
		try {
			$request = $this->request;
		
			$request->status = Request::STATUS_ACTIVE;
			if (!$request->is_internet && !$request->is_restore) {	// если подано не через интернет и не является восстановленным из архива
				$this->temporary_password = $request->changePassword();  // генерим пароль
			}
		}
		catch (Exception $e) {
			return false;
		}		
		
		return true;
	}
	
	/*
	 * Операция снятия с очереди (активное заявление)
	 */
	public function performOperationDeregister()
	{
		try {
			$request = $this->request;
		
			$request->status = Request::STATUS_DEREGISTERED;
			$request->queue_number = Request::QUEUE_NUMBER_NONE;
			$request->is_archive = 1;
		}
		catch (Exception $e) {
			return false;
		}		
		
		return true;
	}
	
	/*
	 * Операция предоставления места (активному заявлению)
	 */ 
	public function performOperationGrantPlace()
	{
		try {
			$request = $this->request;
			
			$nursery = Nursery::model()->findByPk($this->granted_nursery_id);
			$group = NurseryGroup::model()->findByPk($this->granted_group_id);
			
			$request->status = Request::STATUS_GRANTED;

			if (isset($nursery) && isset($group)) {	// если выбраны МДОУ и группа, уменьшаем количество свободных мест
				if ($group->free_places > 0) {
					$group->free_places--;
					$group->save(false, array('free_places'));
				}
				else {
					$request->addError("", "В выбранной группе нет свободных мест");
					return false;
				}
			}
			else {
				$request->addError("", "Для данной операции необходимо указать МДОУ и группу");
				return false;
			}
		}
		catch (Exception $e) {
			return false;
		}		

		return true;
	}
	
	/*
	 * Операция отмены предоставления места (статус: предоставлено место в МДОУ)
	 */
	public function performOperationCancelPlace()
	{
		try {
			$request = $this->request;
		
			$request->status = Request::STATUS_ACTIVE;
			
			if (!$this->returnPlace())
				return false;
		}
		catch (Exception $e) {
			return false;
		}		
		
		return true;
	}

	/*
	 * Операция аннулирования предоставления места (статус: предоставлено место в МДОУ)
	 */
	public function performOperationAnnulPlace()
	{
		try {
			$request = $this->request;
		
			$request->status = Request::STATUS_ABSENT;
			$request->queue_number = Request::QUEUE_NUMBER_TOP;
			$request->is_archive = 1;
			
			if (!$this->returnPlace())
				return false;
		}
		catch (Exception $e) {
			return false;
		}		
		
		return true;
	}
	
	/*
	 * Операция зачисление в МДОУ (статус: предоставлено место)
	 */
	public function performOperationEnroll()
	{
		try {
			$request = $this->request;
			
			$request->status = Request::STATUS_ENROLLED;
			$request->queue_number = Request::QUEUE_NUMBER_TOP;
			
			$request->is_archive = 1;
			
			$operationGrantLog = OperationLog::model()->find(array(
				'condition'=>'request_id=:request_id and operation_id=:operation_id',
				'params'=>array(':request_id'=>$request->id, ':operation_id'=>Operation::OPERATION_GRANT_PLACE),
			));
			if (isset($operationGrantLog)) {
				$direction = new RequestNurseryDirection;
				$direction->request_id = $request->id;
				$direction->nursery_id = $operationGrantLog->granted_nursery_id;
				$direction->group_id = $operationGrantLog->granted_group_id;
							
				$direction->generateNewRegNumber();
				if ($direction->save()) {
					$this->direction_id = $direction->id;
							
					$nursery = Nursery::model()->findByPk($operationGrantLog->granted_nursery_id);
					$group = NurseryGroup::model()->findByPk($operationGrantLog->granted_group_id);
				}
				else {
					$request->addError("", "Произошла ошибка при создании направления");
					return false;
				}
			}
			else {
				$request->addError("", "Не найдена предшествующая операция предоставления места");
				return false;
			}

		}
		catch (Exception $e) {
			return false;
		}
		
		return true;	
	}

	/*
	 * Операция аннулирования зачисления (статус: зачислен)
	 */
	public function performOperationAnnulEnrollment()
	{
		try {
			$request = $this->request;
		
			$request->status = Request::STATUS_NONAPPEARED;
			$request->queue_number = Request::QUEUE_NUMBER_TOP;
			
			if (!$this->returnPlace())
				return false;
		}
		catch (Exception $e) {
			return false;
		}		
		
		return true;
	}	

	/*
	 * Операция восстановления из архива
	 */
	public function performOperationRestore()
	{
		try {
			$request = $this->request;
			
			if (!$request->is_archive)
				return false;
		
			if ($request->queue_number == Request::QUEUE_NUMBER_TOP) { // если номер очереди = 0
				$request->status = Request::STATUS_ACTIVE;	// статус активно
			}
			else if ($request->queue_number == Request::QUEUE_NUMBER_NONE) {	// иначе, если -1
				$request->status = Request::STATUS_ACCEPTED;// статус принято к рассмотрению
				$request->generateNewQueueNumber();
				$request->logQueueNumber(QueueLog::TYPE_RESTORE);
			}
			else {
				$request->addError('', 'Некорректный номер очереди у заявления в архиве');
				return false;
			}
			
			$request->is_archive = 0;
			$request->is_restore = 1;
		}
		catch (Exception $e) {
			return false;
		}		
		
		return true;
	}
	
	public function performOperationChangePassword()
	{
		try {
			$request = $this->request;
			$this->temporary_password = $request->changePassword();
		}
		catch (Exception $e) {
			return false;
		}		
		
		return true;
	}
	
	/*
	 * Выполняет операцию
	 */
	public function performOperation()
	{
		switch ($this->operation->id) {
			case Operation::OPERATION_REGISTER :
				return $this->performOperationRegister();
			case Operation::OPERATION_DENY :
				return $this->performOperationDeny();
			case Operation::OPERATION_REJECT :
				return $this->performOperationReject();
			case Operation::OPERATION_ENQUEUE :
				return $this->performOperationEnqueue();
			case Operation::OPERATION_DEREGISTER :
				return $this->performOperationDeregister();
			case Operation::OPERATION_GRANT_PLACE :
				return $this->performOperationGrantPlace();
			case Operation::OPERATION_CANCEL_PLACE :
				return $this->performOperationCancelPlace();
			case Operation::OPERATION_ANNUL_PLACE :
				return $this->performOperationAnnulPlace();
			case Operation::OPERATION_ENROLL :
				return $this->performOperationEnroll();
			case Operation::OPERATION_ANNUL_ENROLLMENT :
				return $this->performOperationAnnulEnrollment();
			case Operation::OPERATION_CHANGE_PASSWORD :
				return $this->performOperationChangePassword();
			case Operation::OPERATION_RESTORE :
				return $this->performOperationRestore();
			case Operation::OPERATION_APPLY :
				return $this->performOperationApply();
			case Operation::OPERATION_CLEAR_PERSONAL_DATA :
				return $this->performOperationClearPersonalData();
			case Operation::OPERATION_ARCHIVE :
				return $this->performOperationArchive();
		}
		
		return false;
	}
	
	/*
	 * Проверка на наличие комментария
	 */
	public function checkComment()
	{
		if ((!isset($this->comment) || strlen($this->comment) == 0) && $this->operation->is_comment_required)
			return false;
		else
			return true;
	}
	
	/*
	 * Проверка на наличие причины выполнения операции
	 */
	public function checkReason()
	{
		if ((!isset($this->reason_id) || $this->reason_id == '') && $this->operation->hasReason())
			return false;
		else
			return true;	
	}
	
	/*
	 * Статическая функция выполнения операции
	 */
	public static function applyOperation($request, $operation, $attributes)
	{
		if (!isset($request))
			throw new CHttpException(404, 'Не определено заявление для операции');

		if (!$operation->canApply($request)) {
			$request->addError('', 'Данная операция не может быть применена к указанному заявлению');
			return false;
		}
		
		$log = new OperationLog();
		
		$log->request = $request;
		$log->operation = $operation;
		
		$log->operation_id = $operation->id;
		$log->request_id = $request->id;
		$log->old_status = $request->status; // присваиваем предыдущий статус
//		$logRecord->granted_nursery_id = isset($attributes['nursery_id']) ? $attributes['nursery_id'] : 0;
//		$logRecord->granted_group_id = isset($attributes['group_id']) ? $attributes['group_id'] : 0;
		$log->attributes = $_POST['OperationLog'];
		
		if (!$log->checkComment()) {
			$request->addError("", "Для данной операции необходимо указать комментарий");
			return false;
		}

		if (!$log->checkReason()) {
			$request->addError("", "Для данной операции необходимо указать причину");
			return false;
		}
		
		$ok = true;
		// Start the transaction
		$transaction = Yii::app()->db->beginTransaction();
		try {
			if ($log->performOperation()) {
				$log->queue_number = $request->queue_number;	// присваиваем номер очереди
				$log->new_status = $request->status;			// присваиваем новый статус
				
				if ($log->save() && $request->save(false)) {
					// empty block 
				}
				else
					$ok = false;				
			}
			else
				$ok = false;
				
			if ($ok && $operation->id == Operation::OPERATION_ENQUEUE)
				$request->resetPrivateData();

			if ($ok) {
				$transaction->commit();
				$log->sendEmailNotification();
			}
			else {
				$transaction->rollBack();
				$ok = false;
			}
		}
		catch (Exception $e) { // в случае ошибки при выполнении запроса выбрасывается исключение
			$transaction->rollBack();
			$request->addError('', 'Произошла ошибка во время выполнения операции');
			$ok = false;
		}
		
		return $ok;
	}
}
