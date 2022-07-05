<?php

class MicrodistrictController extends BackEndController
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

		$model=new Microdistrict;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Microdistrict']))
		{
			$model->attributes=$_POST['Microdistrict'];
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

		if(isset($_POST['Microdistrict']))
		{
			$model->attributes=$_POST['Microdistrict'];
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
		
		$dataProvider=new CActiveDataProvider('Microdistrict', array(
		    'sort'=>array(
			    'defaultOrder'=>'name ASC',
		    ),
			'pagination'=>array(
				'pageSize'=> 50,
			)
		));
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Возвращает список улиц, относящихся к выбранному микрорайону через AJAX
	 */
	public function actionAjaxStreets()
	{
		if (!Yii::app()->user->checkAccess('accessBackend'))
			throw new CHttpException(403,'Недостаточно прав для выполнения операции');

		$microdistrictId = isset($_POST['microdistrict_id']) ? $_POST['microdistrict_id'] : 0;
		$prompt = isset($_POST['is_empty']) ? "" : "Выберите улицу";

		$data = array();
		
		if ($microdistrictId == 0) {
			$data = Street::model()->findAll(array(
				'order' => 'name ASC',			
			));
		}
		else {
            $streetCriteria = new CDbCriteria;
            $streetCriteria->alias = "street";
            $streetCriteria->join =
                "LEFT JOIN tbl_microdistrict_street_assignment ON street.id=tbl_microdistrict_street_assignment.street_id";
            $streetCriteria->addCondition('tbl_microdistrict_street_assignment.microdistrict_id=:microdistrict_id');
            $streetCriteria->params[':microdistrict_id'] = $microdistrictId;

            $streetCriteria->order = "name ASC";

            $data = Street::model()->findAll($streetCriteria);
		}

		$data=CHtml::listData($data, 'id', 'NameReversed');

		echo CHtml::tag('option',
			array('value'=>''),CHtml::encode($prompt), true);

		foreach($data as $value=>$name)
		{
			echo CHtml::tag('option',
			   array('value'=>$value),CHtml::encode($name), true);
		}
	}

	/**
	 * Возвращает список МДОУ, относящихся к выбранному микрорайону через AJAX
	 */
	public function actionAjaxNurseries()
	{
		if (!Yii::app()->user->checkAccess('accessBackend'))
			throw new CHttpException(403,'Недостаточно прав для выполнения операции');

		$microdistrictId = isset($_POST['microdistrict_id']) ? $_POST['microdistrict_id'] : 0;
		
		$data = array();
		
		if ($microdistrictId == 0) {
			$data = Nursery::model()->findAll(array(
				'order' => 'short_number ASC',
			));
		}
		else {
            $criteria = new CDbCriteria;
			$criteria->addCondition('microdistrict_id=:microdistrict_id');
			$criteria->params[':microdistrict_id'] = $microdistrictId;;

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
		$model=Microdistrict::model()->findByPk((int)$id);
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
		if(isset($_POST['ajax']) && $_POST['ajax']==='microdistrict-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
