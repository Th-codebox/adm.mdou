<?php

class UserController extends BackEndController
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column1';

	/**
	 * @return array action filters
	 */
/*	public function filters()
	{
		return array(
			'accessControl', // perform access control for CRUD operations
		);
	}*/

	/**
	 * Specifies the access control rules.
	 * This method is used by the 'accessControl' filter.
	 * @return array access control rules
	 */
/*	public function accessRules()
	{
		return array(
			array('allow',  // allow all users to perform 'index' and 'view' actions
				'actions'=>array('index','view'),
				'users'=>array('*'),
			),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('create','update','newPassword'),
				'users'=>array('@'),
			),
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array('admin','delete'),
				'users'=>array('admin'),
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}*/

	/**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionView($id)
	{
		$this->render('view',array(
			'model'=>$this->loadModel($id),
		));
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		if (!Yii::app()->user->checkAccess('createUser'))
			throw new CHttpException(403,'Недостаточно прав для выполнения операции');
			
		$model=new User;
		
		$model->is_applicant = 0;

		// Uncomment the following line if AJAX validation is needed
		$this->performAjaxValidation($model);

		if(isset($_POST['User']))
		{
			$model->attributes=$_POST['User'];
			
			$roles = isset($_POST['roles']) ? $_POST['roles'] : array();
			
			if($model->validate()) {
				$model->encryptPassword();
				if ($model->save()) {
					$model->saveRoles($roles);
					
					Yii::app()->user->setFlash("useroperation", "Создан новый пользователь");
					$this->redirect(isset(Yii::app()->user->returnUrl) ? Yii::app()->user->returnUrl : array('index'));
				}
			}
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
		if (!Yii::app()->user->checkAccess('updateUser'))
			throw new CHttpException(403,'Недостаточно прав для выполнения операции');

		$model=$this->loadModel($id);
		
		$model->setScenario('update');

		// Uncomment the following line if AJAX validation is needed
		$this->performAjaxValidation($model);

		if(isset($_POST['User']))
		{
			$model->attributes=$_POST['User'];
			
			$roles = isset($_POST['roles']) ? $_POST['roles'] : array();

			if($model->save()) {
				$model->saveRoles($roles);

				Yii::app()->user->setFlash("useroperation", "Данные пользователя успешно изменены");
				$this->redirect(isset(Yii::app()->user->returnUrl) ? Yii::app()->user->returnUrl : array('index'));
			}
//				$this->redirect(array('index'));
		}

		$this->render('update',array(
			'model'=>$model,
		));
	}

	/**
	 *  Создание нового пароля
	 */
	public function actionNewPassword($id)
	{
		if (!Yii::app()->user->checkAccess('updateUser'))
			throw new CHttpException(403,'Недостаточно прав для выполнения операции');

		$model=$this->loadModel($id);
		
		$model->setScenario('newPassword');
		// Uncomment the following line if AJAX validation is needed
		$this->performAjaxValidation($model);
		
		if(isset($_POST['User']))
		{
			$model->attributes = $_POST['User'];

			if ($model->validate()) {
				$model->encryptPassword();
				if ($model->save()) {
					Yii::app()->user->setFlash("useroperation", "Создан новый пароль");
					$this->redirect(isset(Yii::app()->user->returnUrl) ? Yii::app()->user->returnUrl : array('index'));
				}
			}
//				if (isset($_POST['backUrl']))
//					$this->redirect($_POST['backUrl']);
//				else
//					$this->redirect(array('index'));
		}
		
		$this->render('_newPassword',array(
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
		if(Yii::app()->request->isPostRequest && Yii::app()->user->checkAccess('deleteUser'))
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
		if (!Yii::app()->user->checkAccess('readUser'))
			throw new CHttpException(403,'Недостаточно прав для выполнения операции');

		Yii::app()->user->setReturnUrl(Yii::app()->request->url);

		$dataProvider=new CActiveDataProvider('User', array(
			'criteria'=>array(
				'condition'=>'is_applicant=0',
		    ),
		));
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
		$model=User::model()->findByPk((int)$id);
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
		if(isset($_POST['ajax']) && $_POST['ajax']==='user-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
