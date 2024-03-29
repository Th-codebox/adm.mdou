<?php

class OperationReasonController extends BackEndController
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

		$model=new OperationReason;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['OperationReason']))
		{
			$model->attributes=$_POST['OperationReason'];
			$model->operations = isset($_POST['OperationReason']['operations']) ? $_POST['OperationReason']['operations'] : array();

			if($model->save()) {
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

		if(isset($_POST['OperationReason']))
		{
			$model->attributes=$_POST['OperationReason'];
			$model->operations = isset($_POST['OperationReason']['operations']) ? $_POST['OperationReason']['operations'] : array();

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
		if(Yii::app()->request->isPostRequest && Yii::app()->user->checkAccess('deleteNursery'))
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
		if (!Yii::app()->user->checkAccess('readNursery'))
			throw new CHttpException(403,'Недостаточно прав для выполнения операции');

		Yii::app()->user->setReturnUrl(Yii::app()->request->url);
		
		$dataProvider=new CActiveDataProvider('OperationReason');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer the ID of the model to be loaded
	 */
	public function loadModel($id)
	{
		$model=OperationReason::model()->findByPk((int)$id);
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
		if(isset($_POST['ajax']) && $_POST['ajax']==='operation-reason-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
