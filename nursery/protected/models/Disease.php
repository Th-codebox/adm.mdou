<?php

/**
 * This is the model class for table "{{disease}}".
 *
 * The followings are the available columns in table '{{disease}}':
 * @property integer $id
 * @property string $name
 * @property string $create_time
 * @property integer $create_user_id
 * @property string $update_time
 * @property integer $update_user_id
 *
 * The followings are the available model relations:
 */
class Disease extends NurseryActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return Disease the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{disease}}';
	}

	public function behaviors(){
		return array(
			'ActiveRecordLogableBehavior'=>'application.components.behaviors.ActiveRecordLogableBehavior',
			'CAdvancedArBehavior' => 'application.extensions.CAdvancedArBehavior',
		);
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('name', 'required'),
			array('name', 'length', 'max'=>255),
			array('documents', 'safe'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			'nurseries' => array(self::MANY_MANY, 'Nursery', '{{nursery_disease_assignment}}(disease_id, nursery_id)'),
			'documents' => array(self::MANY_MANY, 'DocumentType', '{{disease_document_assignment}}(disease_id, document_id)'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'name' => 'Name',
			'description'=>'Описание',
			'documents'=>'Документы',
			'create_time' => 'Create Time',
			'create_user_id' => 'Create User',
			'update_time' => 'Update Time',
			'update_user_id' => 'Update User',
		);
	}

	public function getName()
	{
		return $this->name;
	}

	/*
	 *  Возвращает строку со списком документов, необходимых для специализации
	 */
	public function getDocuments()
	{
		$list = array();
		foreach ($this->documents as $doc) {
			array_push($list, $doc->getName());
		}
		$result = join(", ", $list);

		return $result;
	}

}
