<?php

class DiseaseController extends BackEndController
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
	
		$model=new Disease;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Disease']))
		{
			$model->attributes=$_POST['Disease'];
			$model->documents = isset($_POST['Disease']['documents']) ? $_POST['Disease']['documents'] : array();
			if($model->save())
				$this->redirect(isset(Yii::app()->user->returnUrl) ? Yii::app()->user->returnUrl : array('index'));
//				$this->redirect(array('index'));
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

		if(isset($_POST['Disease']))
		{
			$model->attributes=$_POST['Disease'];
			$model->documents = isset($_POST['Disease']['documents']) ? $_POST['Disease']['documents'] : array();
			if($model->save())
				$this->redirect(isset(Yii::app()->user->returnUrl) ? Yii::app()->user->returnUrl : array('index'));
//				$this->redirect(array('index'));
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
		if (!Yii::app()->user->checkAccess('readReference'))
			throw new CHttpException(403,'Недостаточно прав для выполнения операции');

		Yii::app()->user->setReturnUrl(Yii::app()->request->url);
		
		$dataProvider=new CActiveDataProvider('Disease');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}
	
	/**
	 * Возвращает список МДОУ с указанной специализацией
	 */
	public function actionAjaxNurseries()
	{
		if (!Yii::app()->user->checkAccess('accessBackend'))
			throw new CHttpException(403,'Недостаточно прав для выполнения операции');

		$diseaseId = isset($_POST['disease_id']) ? $_POST['disease_id'] : 0;
		
		$data = array();
		
		if ($diseaseId == 0) {
			$data = Nursery::model()->findAll(array(
				'order' => 'short_number ASC',
			));
		}
		else {
			$disease = $this->loadModel($diseaseId);
			$data = $disease->nurseries;
/*            $criteria = new CDbCriteria;
			$criteria->addCondition('_id=:microdistrict_id');
			$criteria->params[':microdistrict_id'] = $microdistrictId;;

			$criteria->order = "short_number ASC";

            $data = Nursery::model()->findAll($criteria);*/
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
		$model=Disease::model()->findByPk((int)$id);
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
		if(isset($_POST['ajax']) && $_POST['ajax']==='disease-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
