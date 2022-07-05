<?php

class ActiveRecordLogController extends BackEndController
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column1';

	/**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionView($id)
	{
		if (!Yii::app()->user->checkAccess('readLog'))
			throw new CHttpException(403,'Недостаточно прав для выполнения операции');

		$this->render('view',array(
			'model'=>$this->loadModel($id),
		));
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		if (!Yii::app()->user->checkAccess('readLog'))
			throw new CHttpException(403,'Недостаточно прав для выполнения операции');
			
		$criteria = new CDbCriteria;

		$modelType = isset($_GET['ActiveRecordLog_modelType']) ? $_GET['ActiveRecordLog_modelType'] : "";
		if (strlen($modelType) > 0) {
			$criteria->addCondition('model=:modelType');
			$criteria->params[':modelType'] = $modelType;
			
			$modelId = isset($_GET['ActiveRecordLog_modelId']) ? $_GET['ActiveRecordLog_modelId'] : "";
			if (strlen($modelId) > 0) {
				$criteria->addCondition('model_id = :modelId');
				$criteria->params[':modelId'] = $modelId;
			}
		}		
		
		// applying dates
		$dateFrom = isset($_GET['ActiveRecordLog_dateFrom']) ? $_GET['ActiveRecordLog_dateFrom'] : "";
		$dateTo = isset($_GET['ActiveRecordLog_dateTo']) ? $_GET['ActiveRecordLog_dateTo'] : "";
		if (strlen($dateFrom) > 0 && strlen($dateTo) > 0) {
//			$criteria->addCondition('date(create_time) >= '.$dateFrom);
//			$criteria->addCondition('date(create_time) <= '.$dateTo);

			$criteria->addCondition('date(create_time) >= :dateFrom');
			$criteria->addCondition('date(create_time) <= :dateTo');

			$criteria->params[':dateFrom'] = $dateFrom;
			$criteria->params[':dateTo'] = $dateTo;
		}
		else if (strlen($dateFrom) > 0 && strlen($dateTo) == 0) {
			$criteria->addCondition('date(create_time) >= :dateFrom');
			$criteria->params[':dateFrom'] = $dateFrom;
		}
		
// --------------
		$dataProvider=new CActiveDataProvider('ActiveRecordLog', array(
			'criteria'=>$criteria,
		    'sort'=>array(
			    'defaultOrder'=>'id DESC',
		    ),
			'pagination'=>array(
				'pageSize'=> isset($_GET['ActiveRecordLog_pageSize']) ? $_GET['ActiveRecordLog_pageSize'] : 50,
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
		if (!Yii::app()->user->checkAccess('readLog'))
			throw new CHttpException(403,'Недостаточно прав для выполнения операции');

		$model=new ActiveRecordLog('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['ActiveRecordLog']))
			$model->attributes=$_GET['ActiveRecordLog'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer the ID of the model to be loaded
	 */
	public function loadModel($id)
	{
		$model=ActiveRecordLog::model()->findByPk((int)$id);
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
		if(isset($_POST['ajax']) && $_POST['ajax']==='active-record-log-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
