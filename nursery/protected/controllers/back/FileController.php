<?php

class FileController extends BackEndController
{
	/**
	 * @var string the default layout for the views. Defaults to 'column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='column1';

	/**
	 * @var CActiveRecord the currently loaded data model instance.
	 */
	private $_model;

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		if (!Yii::app()->user->checkAccess('createSite'))
			throw new CHttpException(403,'Недостаточно прав для выполнения операции');

		$model=new File;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		$fileObject = $this->getFileObject();
		if (!isset($fileObject))
			throw new CHttpException(400,'Не определен материал для файла');

		if(isset($_POST['File']))
		{
			$model->attributes = $_POST['File'];
			$model->file = CUploadedFile::getInstance($model,'file');
			$model->fill($fileObject);
			if(!empty($model->file)) {
				$model->file->saveAs($model->getFullPath());
				if ($model->save())
					$this->redirect(array(
						'file/index',
						'object'=>$fileObject->getFileObjectType(),
						'object_id'=>$fileObject->id,
					));
				else
					unlink($model->path);
			}
		}

		$this->render('create',array(
			'model'=>$model,
			'fileObject'=>$fileObject,
		));
	}

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionUpdate()
	{
		if (!Yii::app()->user->checkAccess('updateSite'))
			throw new CHttpException(403,'Недостаточно прав для выполнения операции');

		$model=$this->loadModel();

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		$fileObject = $this->getFileObject();
		if (!isset($fileObject))
			throw new CHttpException(400,'Не определен материал для файла');

		if(isset($_POST['File']))
		{
			$model->attributes=$_POST['File'];
			if($model->save())
				$this->redirect(array(
					'file/index',
					'object'=>$fileObject->getFileObjectType(),
					'object_id'=>$fileObject->id,
				));
		}

		$this->render('update',array(
			'model'=>$model,
			'fileObject'=>$fileObject,
		));
	}

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'index' page.
	 */
	public function actionDelete()
	{
		if(Yii::app()->request->isPostRequest && Yii::app()->user->checkAccess('deleteSite'))
		{
			$fileObject = $this->getFileObject();
			if (!isset($fileObject))
				throw new CHttpException(400,'Не определен материал для файла');

			// we only allow deletion via POST request
			$this->loadModel()->delete();

			// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
			if(!isset($_GET['ajax']))
				$this->redirect(array(
					'file/index',
					'object'=>$fileObject->getFileObjectType(),
					'object_id'=>$fileObject->id,
				));
		}
		else
			throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		if (!Yii::app()->user->checkAccess('readSite'))
			throw new CHttpException(403,'Недостаточно прав для выполнения операции');

		$fileObject = $this->getFileObject();

		$files = $fileObject->getRelated('files', false, array());
/*		if ($fileObject->getFileObjectType() == 'node')
		{
			$node = Node::model()->findByPk($object->id);

		}
		else if ($fileObject->getFileObjectType() == 'news')
		{
			$news = News::model()->findByPk($object->id);
			$files = $news->getRelated('files', false, array());
		}*/
		$dataProvider = new CActiveDataProvider('file', array());
		$dataProvider->setData($files);

		$this->render('index',array(
			'dataProvider'=>$dataProvider,
			'fileObject'=>$fileObject,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 */
	public function loadModel()
	{
		if($this->_model===null)
		{
			if(isset($_GET['id']))
				$this->_model=File::model()->findbyPk($_GET['id']);
			if($this->_model===null)
				throw new CHttpException(404,'The requested page does not exist.');
		}
		return $this->_model;
	}
	
	public function getObjectParameters()
	{
		$objectName = $_GET['object'];
		$webParams = $_GET;
		$params = array();
		foreach ($webParams as $key=>$value) {
			if (isset($_GET[$key]) && $_GET[$key] != "" && preg_match("/^$objectName\_.+$/i", $key)) {
				$params[$key] = $_GET[$key];
			}
		}

		return $params;
	}

	public function getParameters()
	{
		$objectName = $_GET['object'];
		$webParams = $_GET;
		$params = array();
		foreach ($webParams as $key=>$value) {
			if (isset($_GET[$key]) && $_GET[$key] != "" &&
			(preg_match("/^File_.+$/", $key) || preg_match("/^$objectName\_.+$/i", $key)
				|| preg_match("/^object.*$/", $key)))
				$params[$key] = $_GET[$key];
		}

		return $params;
	}

	public function getParametersAsString()
	{
		$params = getParameters();
		$result = array();
		foreach ($params as $key=>$value) {
			array_push($result, $key.'='.$value);
		}

		return implode("&", $result);
	}


	private function getFileObject()
	{
		if (isset($_GET['object']) && isset($_GET['object_id']))
		{
			$fileObjectName = $_GET['object'];
			$fileObjectId = $_GET['object_id'];
			if ($fileObjectName == "node")
				return Node::model()->findByPk($fileObjectId);
		}
		return null;
	}

	/**
	 * Performs the AJAX validation.
	 * @param CModel the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='file-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}

}
