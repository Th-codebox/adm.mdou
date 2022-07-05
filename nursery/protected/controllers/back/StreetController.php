<?php

class StreetController extends BackEndController
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
		if (!Yii::app()->user->checkAccess('createReference'))
			throw new CHttpException(403,'Недостаточно прав для выполнения операции');

		$model=new Street;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Street']))
		{
			$model->attributes=$_POST['Street'];
			$model->microdistricts = isset($_POST['Street']['microdistricts']) ? $_POST['Street']['microdistricts'] : array();
			
			if($model->save())
				$this->redirect(isset(Yii::app()->user->returnUrl) ? Yii::app()->user->returnUrl : array('index'));
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
		if (!Yii::app()->user->checkAccess('updateReference'))
			throw new CHttpException(403,'Недостаточно прав для выполнения операции');

		$model=$this->loadModel($id);

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Street']))
		{
			$model->attributes=$_POST['Street'];
			$model->microdistricts = isset($_POST['Street']['microdistricts']) ? $_POST['Street']['microdistricts'] : array();
			
			if($model->save())
				$this->redirect(isset(Yii::app()->user->returnUrl) ? Yii::app()->user->returnUrl : array('index'));
//				$this->redirect(array('view','id'=>$model->id));
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
		if(Yii::app()->request->isPostRequest && Yii::app()->user->checkAccess('deleteReference'))
		{
			// we only allow deletion via POST request
			$this->loadModel($id)->delete();

			// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
			if(!isset($_GET['ajax']))
				$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('index'));
		}
		else
			throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		if (!Yii::app()->user->checkAccess('readReference'))
			throw new CHttpException(403,'Недостаточно прав для выполнения операции');

		Yii::app()->user->setReturnUrl(Yii::app()->request->url);
		
		$criteria = new CDbCriteria;
		$criteria->alias = "street";
			
		$type = isset($_GET['Street_type']) ? $_GET['Street_type'] : "";
		if ($type != "") {
			$criteria->addCondition('street_type_id=:type_id');
			$criteria->params[':type_id'] = $type;
		}
		$microdistrict = isset($_GET['Street_microdistrict']) ? $_GET['Street_microdistrict']: "";
		if ($microdistrict != "") {
			$criteria->join = "LEFT JOIN tbl_microdistrict_street_assignment ON street.id=tbl_microdistrict_street_assignment.street_id";
			$criteria->addCondition('tbl_microdistrict_street_assignment.microdistrict_id=:microdistrict_id');
			$criteria->params[':microdistrict_id'] = $microdistrict;
		}

		$words = isset($_GET['Street_words']) ? $_GET['Street_words'] : "";
		if ($words != "") {
			$criteria->addCondition('name like :words');
			$criteria->params[':words'] = '%'.$words.'%';
		}

		$dataProvider=new CActiveDataProvider('Street', array(
			'criteria'=>$criteria,
			'sort'=>array(
				'defaultOrder'=>'name ASC, id ASC'
			),
			'pagination'=>array(
				'pageSize'=> isset($_GET['Street_pageSize']) ? $_GET['Street_pageSize'] : 50,
			),
		));
		
		$types = CHtml::listData(StreetType::model()->findAll(array(
				'order'=>'name ASC'
			)), 
			'id', 'name'
		);
		$microdistricts = CHtml::listData(Microdistrict::model()->findAll(array(
				'order'=>'name ASC'
			)), 
			'id', 'name'
		);


		$this->render('index',array(
			'dataProvider'=>$dataProvider,
			'types'=>$types,
			'microdistricts'=>$microdistricts,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer the ID of the model to be loaded
	 */
	public function loadModel($id)
	{
		$model=Street::model()->findByPk((int)$id);
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
		if(isset($_POST['ajax']) && $_POST['ajax']==='street-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
