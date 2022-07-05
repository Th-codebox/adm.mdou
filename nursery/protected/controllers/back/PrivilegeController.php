<?php

class PrivilegeController extends BackEndController
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

		$model=new Privilege;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Privilege']))
		{
			$model->attributes=$_POST['Privilege'];
			$model->documents = isset($_POST['Privilege']['documents']) ? $_POST['Privilege']['documents'] : array();

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
		if (!Yii::app()->user->checkAccess('updateNursery'))
			throw new CHttpException(403,'Недостаточно прав для выполнения операции');

		$model=$this->loadModel($id);

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Privilege']))
		{
			$model->attributes=$_POST['Privilege'];
			$model->documents = isset($_POST['Privilege']['documents']) ? $_POST['Privilege']['documents'] : array();
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
		if (!Yii::app()->user->checkAccess('deleteNursery'))
			throw new CHttpException(403,'Недостаточно прав для выполнения операции');

		if(Yii::app()->request->isPostRequest)
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
		if (!Yii::app()->user->checkAccess('readNursery'))
			throw new CHttpException(403,'Недостаточно прав для выполнения операции');

		Yii::app()->user->setReturnUrl(Yii::app()->request->url);
		
		$dataProvider=new CActiveDataProvider('Privilege', array(
			'sort'=>array(
				'defaultOrder'=>'id ASC'
			),
			'pagination'=>array(
				'pageSize'=> 25,
			),
		));
		
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new Privilege('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Privilege']))
			$model->attributes=$_GET['Privilege'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}
	
	/**
	 * Возвращает список документов, относящихся к выбранной льготе через AJAX
	 */
	public function actionAjaxDocumentTypes()
	{
		if (!Yii::app()->user->checkAccess('accessBackend'))
			throw new CHttpException(403,'Недостаточно прав для выполнения операции');

		$web = $_POST;
		$privilegeId = isset($web['privilege_id']) ? $web['privilege_id'] : 0;
		$docTypeId = isset($web['document_type_id']) ? $web['document_type_id'] : 0;
		
		$data = array();
		
		if ($privilegeId == 0) {
			$data = DocumentType::model()->findAll(array(
				'order' => 'name ASC',
			));
		}
		else {
            $criteria = new CDbCriteria;

			$criteria->join = "LEFT JOIN tbl_privilege_document_assignment ON t.id=tbl_privilege_document_assignment.document_id";
			$criteria->addCondition('tbl_privilege_document_assignment.privilege_id=:privilege_id');
			$criteria->params[':privilege_id'] = $privilegeId;

			$criteria->order = "name ASC";

            $data = DocumentType::model()->findAll($criteria);
		}

		$data=CHtml::listData($data, 'id', 'Name');

		echo CHtml::tag('option',
		   array('value'=>0),CHtml::encode('Другой'), true);

		foreach($data as $value=>$name)
		{
			echo CHtml::tag('option',
			   array('value'=>$value, 'selected'=>$value == $docTypeId ? true: false),CHtml::encode($name), true);
		}
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer the ID of the model to be loaded
	 */
	public function loadModel($id)
	{
		$model=Privilege::model()->findByPk((int)$id);
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
		if(isset($_POST['ajax']) && $_POST['ajax']==='privilege-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
