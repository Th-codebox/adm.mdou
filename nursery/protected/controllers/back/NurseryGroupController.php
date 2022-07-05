<?php

class NurseryGroupController extends BackEndController
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column1';

	/**
	 * @var МДОУ для данной группы.
	 */
	private $_nursery = null;

	/**
	 * @return array action filters
	 */
	public function filters()
	{
		return array(
			'nurseryContext + create index', // check to ensure valid nursery context
		);
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		if (!Yii::app()->user->checkAccess('createNursery'))
			throw new CHttpException(403,'Недостаточно прав для выполнения операции');

		$model=new NurseryGroup;
		$model->nursery_id = $this->_nursery->id;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['NurseryGroup']))
		{
			$model->attributes=$_POST['NurseryGroup'];
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

		if(isset($_POST['NurseryGroup']))
		{
			$model->attributes=$_POST['NurseryGroup'];
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
		
		$dataProvider=new CActiveDataProvider('NurseryGroup', array(
			'criteria' => array(
				'condition'=>'nursery_id=:nursery_id',
				'params'=>array('nursery_id'=>$this->nursery->id),
			),
			'pagination'=>array(
				'pageSize'=> 25,
			),
		));
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
			'params'=>array(':nurseryId'=>$this->_nursery->id),
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer the ID of the model to be loaded
	 */
	public function loadModel($id)
	{
		$model=NurseryGroup::model()->findByPk((int)$id);
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
		if(isset($_POST['ajax']) && $_POST['ajax']==='nursery-group-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}

	/**
	 * Загрузка объекта МДОУ для данной группы
	 * @nursery_id the primary identifier of the associated Nursery
	 * @return object the Nursery data model based on the primary key
	*/
	protected function loadNursery($nursery_id) {
		//if the nursery property is null, create it based on input id
		if($this->_nursery===null)
		{
			$this->_nursery=Nursery::model()->findbyPk($nursery_id);
			if($this->_nursery===null)
			{
				throw new CHttpException(404,'Не найден МДОУ для взрастной группы.');
			}
	
		}
		return $this->_nursery;
	}

	/**
	 * In-class defined filter method, configured for use in the above filters() method
	 * It is called before the actionCreate() action method is run in order to ensure a proper nursery context
	*/
	public function filterNurseryContext($filterChain)
	{
		//set the nursery identifier based on either the GET or POST input
		//request variables, since we allow both types for our actions
		$nurseryId = null;
		if(isset($_GET['nid']))
			$nurseryId = $_GET['nid'];
		else if(isset($_POST['nid']))
			$nurseryId = $_POST['nid'];
		$this->loadNursery($nurseryId);
		//complete the running of other filters and execute the requested action
		$filterChain->run();
	}
	
	/**
	 * Returns the nursery model instance to which this group belongs
	*/
	public function getNursery()
	{
		return $this->_nursery;
	}

}
