<?php

class BackEndController extends CController
{
	public $layout='//layouts/column1';
    public $menu=array();
    public $breadcrumbs=array();
 
/*    public function filters()
    {
        return array(
            'accessControl',
        );
    }
 
    public function accessRules()
    {
        return array(
            array('allow',
                'users'=>array('*'),
                'actions'=>array('login'),
            ),
            array('allow',
                'users'=>array('@'),
            ),
            array('deny',
                'users'=>array('*'),
            ),
        );
    }*/
    
	protected function beforeAction($action) {
		if (!Yii::app()->user->checkAccess('accessBackend') && $this->id.'/'.$action->id !== 'site/login') {
			if (!Yii::app()->user->isGuest)
				Yii::app()->user->logout();
			Yii::app()->user->loginRequired();
		}
		
		return true;
	}
}
