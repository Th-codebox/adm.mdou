<?php

/**
 * This is the model class for table "{{document_type}}".
 *
 * The followings are the available columns in table '{{document_type}}':
 * @property integer $id
 * @property string $name
 * @property string $description
 * @property string $create_time
 * @property integer $create_user_id
 * @property string $update_time
 * @property integer $update_user_id
 *
 * The followings are the available model relations:
 */
class DocumentType extends NurseryActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return DocumentType the static model class
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
		return '{{document_type}}';
	}

	public function behaviors(){
		return array(
			'ActiveRecordLogableBehavior'=>'application.components.behaviors.ActiveRecordLogableBehavior',
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
			array('name', 'length', 'max'=>500),
			array('type', 'numerical', 'integerOnly'=>true),
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
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'name' => 'Название',
			'type' => 'Тип объекта',
			'description' => 'Описание',
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
	 * Возвращает список типов для типа документа
	 */
	public static function getTypeOptions()
	{
		return array(
			0 => 'Все',
			1 => 'Льготы',
			2 => 'Специализации',
		);
	}
	
	public function getTypeName()
	{
		$options = DocumentType::getTypeOptions();
		if (isset($options[$this->type]))
			return $options[$this->type];
		else
			throw CHttpException(404, 'Тип не найден');
	}
}