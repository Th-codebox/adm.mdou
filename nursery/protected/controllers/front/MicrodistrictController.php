<?php

class MicrodistrictController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column1';

	/**
	 * @return array action filters
	 */
	public function filters()
	{
		return array(
			'accessControl', // perform access control for CRUD operations
		);
	}

	/**
	 * Specifies the access control rules.
	 * This method is used by the 'accessControl' filter.
	 * @return array access control rules
	 */
	public function accessRules()
	{
		return array(
			array('allow',
				'actions'=>array('ajaxStreets'),
				'users'=>array('*'), // all users
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}

	/**
	 * Возвращает список улиц, относящихся к выбранному микрорайону через AJAX
	 */
	public function actionAjaxStreets()
	{
		$microdistrictId = isset($_POST['microdistrict_id']) ? $_POST['microdistrict_id'] : 0;

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

		$data=CHtml::listData($data, 'id', 'Name');

		echo CHtml::tag('option',
		   array('value'=>0),CHtml::encode('Выберите улицу'), true);

		foreach($data as $value=>$name)
		{
			echo CHtml::tag('option',
			   array('value'=>$value),CHtml::encode($name), true);
		}
	}
}
