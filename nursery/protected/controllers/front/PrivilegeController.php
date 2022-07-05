<?php

class PrivilegeController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column1';

	/**
	 * Возвращает список документов, относящихся к выбранной льготе через AJAX
	 */
	public function actionAjaxDocumentTypes()
	{
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
	
	public function accessRules()
	{
		return array(
			array('allow',
				'actions'=>array('ajaxDocumentTypes'),
				'users'=>array('*'), // all users
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}
	
	public function filters()
	{
		return array(
			'accessControl', // perform access control for CRUD operations
		);
	}

}
