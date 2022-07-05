<?php

class NurseryController extends BackEndController
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column1';

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		if (!Yii::app()->user->checkAccess('createNursery'))
			throw new CHttpException(403,'Недостаточно прав для выполнения операции');

		$model=new Nursery;
		$model->head = new NurseryHead;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Nursery']))
		{
			$model->attributes=$_POST['Nursery'];
			$model->diseases = isset($_POST['Nursery']['diseases']) ? $_POST['Nursery']['diseases'] : array();

			$model->head->attributes=$_POST['NurseryHead'];

			if($model->save()) {
				$model->head->nursery_id = $model->id;
				$model->head->save();
			
				$this->redirect(isset(Yii::app()->user->returnUrl) ? Yii::app()->user->returnUrl : array('index'));
			}
//				$this->redirect(array('view','id'=>$model->id));
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
		if (!Yii::app()->user->checkAccess('updateNursery'))
			throw new CHttpException(403,'Недостаточно прав для выполнения операции');

		$model=$this->loadModel($id);

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Nursery']))
		{
			$model->attributes=$_POST['Nursery'];
			$model->diseases = isset($_POST['Nursery']['diseases']) ? $_POST['Nursery']['diseases'] : array();
			
			$head = $model->head;
			$head->attributes=$_POST['NurseryHead'];
			
			if($model->save()) {
				$head->save();

				$this->redirect(isset(Yii::app()->user->returnUrl) ? Yii::app()->user->returnUrl : array('index'));
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
		if(Yii::app()->request->isPostRequest && Yii::app()->user->checkAccess('deleteNursery'))
		{
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
		if (!Yii::app()->user->checkAccess('readNursery'))
			throw new CHttpException(403,'Недостаточно прав для выполнения операции');

		Yii::app()->user->setReturnUrl(Yii::app()->request->url);

		$criteria = new CDbCriteria;
		//$criteria->alias = "nursery";
		
		if (isset($_GET['Nursery_microdistrict']) && $_GET['Nursery_microdistrict']) 
		{
			$criteria->addCondition('microdistrict_id=:microdistrict_id');
			$criteria->params[':microdistrict_id'] = $_GET['Nursery_microdistrict'];
		}

		$disease = isset($_GET['Nursery_disease']) ? $_GET['Nursery_disease'] : "";
		if (isset($disease) && $disease) {
			$criteria->join = "LEFT JOIN tbl_nursery_disease_assignment ON t.id=tbl_nursery_disease_assignment.nursery_id";
			$criteria->addCondition('tbl_nursery_disease_assignment.disease_id=:disease_id');
			$criteria->params[':disease_id'] = $disease;
		}

		$words = isset($_GET['Nursery_words']) ? $_GET['Nursery_words'] : "";
		if (isset($words) && $words) {
			$criteria->addCondition('t.name like :words');
			$criteria->params[':words'] = '%'.$words.'%';
		}

		$dataProvider=new CActiveDataProvider('Nursery', array(
			'criteria'=>$criteria,
			'sort'=>array(
				'defaultOrder'=>'short_number, name ASC, id ASC'
			),
			'pagination'=>array(
				'pageSize'=> isset($_GET['Nursery_pageSize']) ? $_GET['Nursery_pageSize'] : 50,
			),
		));
		
		$microdistricts = CHtml::listData(Microdistrict::model()->findAll(array(
				'order'=>'name ASC'
			)), 
			'id', 'name'
		);

		$diseases = CHtml::listData(Disease::model()->findAll(array(
				'order'=>'name ASC'
			)), 
			'id', 'name'
		);

		$this->render('index',array(
			'dataProvider'=>$dataProvider,
			'microdistricts'=>$microdistricts,
			'diseases'=>$diseases,
		));
	}
	
	/**
	 * Возвращает список МДОУ с указанными через AJAX параметрами
	 */
	public function actionAjaxNurseries()
	{
		if (!Yii::app()->user->checkAccess('accessBackend'))
			throw new CHttpException(403,'Недостаточно прав для выполнения операции');

		$diseaseId = isset($_POST['disease_id']) ? $_POST['disease_id'] : 0;
		$microdistrictId = isset($_POST['microdistrict_id']) ? $_POST['microdistrict_id'] : 0;
		
		$data = array();
		
		if ($diseaseId == 0 && $microdistrictId == 0) {
			$data = Nursery::model()->findAll(array(
				'order' => 'short_number ASC',
			));
		}
		else {
            $criteria = new CDbCriteria;
            
            if ($microdistrictId != 0) {
				$criteria->addCondition('microdistrict_id=:microdistrict_id');
				$criteria->params[':microdistrict_id'] = $microdistrictId;
			}
			if ($diseaseId != 0) {
				$criteria->join = "LEFT JOIN tbl_nursery_disease_assignment ON t.id=tbl_nursery_disease_assignment.nursery_id";
				$criteria->addCondition('tbl_nursery_disease_assignment.disease_id=:disease_id');
				$criteria->params[':disease_id'] = $diseaseId;
			}
			$criteria->order = "short_number ASC";

            $data = Nursery::model()->findAll($criteria);
		}

		$data=CHtml::listData($data, 'id', 'Name');

		echo CHtml::tag('option',
		   array('value'=>0),CHtml::encode('Выберите МДОУ'), true);

		foreach($data as $value=>$name)
		{
			echo CHtml::tag('option',
			   array('value'=>$value),CHtml::encode($name), true);
		}
	}


	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer the ID of the model to be loaded
	 */
	public function loadModel($id)
	{
		$model=Nursery::model()->findByPk((int)$id);
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
		if(isset($_POST['ajax']) && $_POST['ajax']==='nursery-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}

	/**
	 * Возвращает список подходящих по возрасту групп со свободными местами для заданного садика через AJAX
	 */
	public function actionAjaxSuitableGroups()
	{
		if (!Yii::app()->user->checkAccess('accessBackend'))
			throw new CHttpException(403,'Недостаточно прав для выполнения операции');

		$web = $_POST;
		$nurseryId = isset($web['nursery_id']) ? $web['nursery_id'] : 0;
		$ageMonths = isset($web['age']) ? $web['age'] : 0; // возраст ребенка в месяцах
		$diseaseId = isset($web['disease_id']) ? $web['disease_id'] : 0;
		
		$groups = array();
		
		if ($nurseryId > 0 && $ageMonths > 0) {
			$where = "age_months_from <= :age AND age_months_to >= :age";
			if ($diseaseId > 0)
				$where .= " AND disease_id=:disease_id";
			else
				$where .= " AND disease_id=0";
			$groups = NurseryGroup::model()->findAllBySql(
				"SELECT * FROM {{nursery_group}} WHERE nursery_id=:nursery_id AND free_places > 0 AND group_id IN "
				." (SELECT id FROM {{group_type}} where $where)",
				array(':nursery_id'=> $nurseryId, ':age'=>$ageMonths, ':disease_id'=>$diseaseId)
			);
		}

		$data=CHtml::listData($groups, 'id', 'NameWithFreePlaces');

		echo CHtml::tag('option',
		   array('value'=>0),CHtml::encode('Выберите группу'), true);

		foreach($data as $value=>$name)
		{
			echo CHtml::tag('option',
			   array('value'=>$value),CHtml::encode($name), true);
		}
	}

}
