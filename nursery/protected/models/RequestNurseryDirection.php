<?php

/**
 * This is the model class for table "{{request_nursery_direction}}".
 *
 * The followings are the available columns in table '{{request_nursery_direction}}':
 * @property integer $id
 * @property integer $request_id
 * @property integer $nursery_id
 * @property integer $reg_number
 * @property string $create_time
 * @property integer $create_user_id
 * @property string $update_time
 * @property integer $update_user_id
 *
 * The followings are the available model relations:
 */
class RequestNurseryDirection extends NurseryActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return RequestNurseryDirection the static model class
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
		return '{{request_nursery_direction}}';
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
			array('request_id, nursery_id, reg_number', 'required'),
			array('request_id, nursery_id, reg_number', 'numerical', 'integerOnly'=>true),
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
			'nursery' => array(self::BELONGS_TO, 'Nursery', 'nursery_id'),
			'group' => array(self::BELONGS_TO, 'NurseryGroup', 'group_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'request_id' => 'Заявление',
			'nursery_id' => 'МДОУ',
			'reg_number' => 'Номер',
			'create_time' => 'Create Time',
			'create_user_id' => 'Create User',
			'update_time' => 'Update Time',
			'update_user_id' => 'Update User',
		);
	}
	
	/*
	 * Получение нового номера для направления (следующего за максимальным в текушем году)
	 */
	public function generateNewRegNumber()
	{
		$maxRegNumber = $this->getDbConnection()->createCommand(
			"SELECT MAX(`reg_number`) FROM {$this->tableName()} WHERE YEAR(create_time)=YEAR(NOW())"
		)->queryScalar();
		$this->reg_number = $maxRegNumber + 1;
	}
	
	public function getName()
	{
		return $this->name;
	}

	public function getNumber()
	{
		return $this->reg_number ? $this->reg_number : 0;
	}
	
	public function getCreateTime()
	{
		return date("d.m.Y H:i:s", CDateTimeParser::parse($this->create_time, "yyyy-MM-dd hh:mm:ss"));
	}
	
	public function getNurseryName()
	{
		if (isset($this->nursery))
			return $this->nursery->getName();
		else
			return "";
	}
	
	public function getGroupName()
	{
		if (isset($this->group))
			return $this->nursery->getName();
		else
			return "";
	
	}

}
