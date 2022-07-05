<?php

class PhotoController extends BackEndController
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

		$model=new Photo;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);
		$model->photoObject = $this->getPhotoObject();

		if(isset($_POST['Photo']))
		{
			$model->attributes=$_POST['Photo'];

			$model->thumb = new File;
			$model->image = new File;
			$this->fillFileFields($model);

			$file = CUploadedFile::getInstance($model,'image');

			$model->thumb->file = $file;
			$model->thumb->fillAsImage($model->photoObject, 'thumb');
			$thumb = Yii::app()->image->load($file->tempName);
			if ($thumb->width > 105)
				$thumb->resize(105, 0)->quality(75);
			$thumb->save($model->thumb->getFullPath());
			$thumbSavedImage = Yii::app()->image->load($model->thumb->getFullPath());
			$model->thumb_width = $thumbSavedImage->width;
			$model->thumb_height = $thumbSavedImage->height;
			$model->thumb->save();

			$model->image->file = $file;
			$model->image->fillAsImage($model->photoObject, 'image');
			$image = Yii::app()->image->load($file->tempName);
			if ($image->width > 800)
				$image->resize(800, 0)->quality(75);
			$image->save($model->image->getFullPath());
			$imageSavedImage = Yii::app()->image->load($model->image->getFullPath());
			$model->width = $imageSavedImage->width;
			$model->height = $imageSavedImage->height;
			$model->image->save();

			if(!empty($model->image->file)) {
				$model->file_id = $model->image->id;
				$model->thumb_file_id = $model->thumb->id;
				if ($model->save())
				$this->redirect(array_merge(
					array(
						'photo/index',
						'object'=>$model->photoObject->getFileObjectType(),
						'object_id'=>$model->photoObject->id,
					),
					$this->getParameters()
				));
			}
		}

		$this->render('create',array(
			'model'=>$model,
			'photoObject'=>$model->photoObject,
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
		
		$photoObject = $this->getPhotoObject();
		if(isset($_POST['Photo']))
		{
//			$model->attributes=$_POST['Photo'];
			$model->name = $_POST['Photo']['name'];
			$image = $model->image();
			$image->name = $model->name;
			$thumb = $model->thumb();
			$thumb->name = $model->name;
			if($model->save() && $image->save() && $thumb->save())
				$this->redirect(array_merge(
					array(
						'photo/index',
						'object'=>$photoObject->getFileObjectType(),
						'object_id'=>$photoObject->id,
					),
					$this->getParameters()
				));
		}

		$this->render('update',array(
			'model'=>$model,
			'photoObject'=>$photoObject,
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
			// we only allow deletion via POST request
			//	$this->loadModel()->delete();
			$model = $this->loadModel();
			
			$model->delete();
			
			$photoObject = $this->getPhotoObject();

			// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
			if(!isset($_GET['ajax']))
				$this->redirect(array(
					'photo/index',
					'object'=>$photoObject->getFileObjectType(),
					'object_id'=>$photoObject->id,
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

		Photo::enableLightBox();
		
		$photoObject = $this->getPhotoObject();

		$photos = $photoObject->getRelated('photos', false, array());
		$dataProvider = new CActiveDataProvider('photo', array());
		$dataProvider->setData($photos);

		$this->render('index',array(
			'dataProvider'=>$dataProvider,
			'photoObject'=>$photoObject,
		));
	}

	public function actionBrowse()
	{
		if (!Yii::app()->user->checkAccess('readSite'))
			throw new CHttpException(403,'Недостаточно прав для выполнения операции');

		$photoObject = $this->getPhotoObject();

		$photos = $photoObject->getRelated('photos', false, array());

		$indexRow = 0;
		$indexCol = 0;
		$rows = array();
		$cols = array();
		foreach ($photos as $photo)
		{
			$cols[$indexCol] = $photo;
			$indexCol++;
			if ($indexCol % 4 == 0) {
				$rows[$indexRow] = $cols;
				$indexCol = 0;
				$cols = array();
				$indexRow++;
			}
		}
		if ($indexCol > 0) {
			$rows[$indexRow] = $cols;
		}

		$mode = isset($_GET['mode']) ? $_GET['mode'] : "";
		$this->renderPartial('browse',array(
			'mode'=> $mode,
			'rows'=>$rows,
			'photoObject'=> $photoObject,
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
				$this->_model=Photo::model()->findbyPk($_GET['id']);
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
			(preg_match("/^Photo_.+$/", $key) || preg_match("/^$objectName\_.+$/i", $key)
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


	private function getPhotoObject()
	{
		if (isset($_GET['object']) && isset($_GET['object_id']))
		{
			$photoObjectName = $_GET['object'];
			$photoObjectId = $_GET['object_id'];
			if ($photoObjectName == "node")
				return Node::model()->findByPk($photoObjectId);
		}
		return null;
	}

	private function fillFileFields($photo)
	{
		$photo->thumb->name = $photo->name;
		$photo->thumb->status = $photo->status;
		$photo->thumb->is_image = 1;

		$photo->image->name = $photo->name;
		$photo->image->status = $photo->status;
		$photo->image->is_image = 1;
	}

	/**
	 * Performs the AJAX validation.
	 * @param CModel the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='photo-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}

}
