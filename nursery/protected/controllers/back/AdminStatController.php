<?php

class AdminStatController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column1';
	
	public function actionActiveRequests()
	{
		$stat = new AdminStat;
		
		if (!Yii::app()->user->checkAccess('readRequest'))
			throw new CHttpException(403,'Недостаточно прав для выполнения операции');

		$this->render('requests', array('stat'=>$stat));
	}

	public function actionRegisteredRequests()
	{
		$stat = new AdminStat;
		
		if (!Yii::app()->user->checkAccess('readRequest'))
			throw new CHttpException(403,'Недостаточно прав для выполнения операции');

		$this->render('registered', array('stat'=>$stat));
	}

	public function actionIssuedDirections()
	{
		$stat = new AdminStat;
		
		if (!Yii::app()->user->checkAccess('readRequest'))
			throw new CHttpException(403,'Недостаточно прав для выполнения операции');

		$this->render('directions', array('stat'=>$stat));
	}


	public function actionFreePlaces()
	{
		$stat = new AdminStat;
		
		if (!Yii::app()->user->checkAccess('readRequest'))
			throw new CHttpException(403,'Недостаточно прав для выполнения операции');
			
		$groups = GroupType::model()->findAll(
			array('condition'=>'is_different_ages=0', 'order'=>'age_months_from, name')
		);

		$this->render('places', array('stat'=>$stat, 'groups'=>$groups));
	}

	public function actionExcludedRequests()
	{
		$stat = new AdminStat;

		if (!Yii::app()->user->checkAccess('readRequest'))
			throw new CHttpException(403,'Недостаточно прав для выполнения операции');

		$this->render('excluded', array('stat'=>$stat));
	}

	public function actionIndex()
	{
		if (!Yii::app()->user->checkAccess('readRequest'))
			throw new CHttpException(403,'Недостаточно прав для выполнения операции');

		$this->render('index');
	}

}