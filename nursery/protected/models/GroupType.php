<?php

/**
 * This is the model class for table "{{group_type}}".
 *
 * The followings are the available columns in table '{{group_type}}':
 * @property integer $id
 * @property string $name
 * @property integer $age_months_from
 * @property integer $age_months_to
 * @property integer $is_different_ages
 * @property string $create_time
 * @property integer $create_user_id
 * @property string $update_time
 * @property integer $update_user_id
 *
 * The followings are the available model relations:
 */
class GroupType extends NurseryActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return GroupType the static model class
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
		return '{{group_type}}';
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
			array('name, age_months_from, age_months_to', 'required'),
			array('age_months_from, age_months_to, is_different_ages', 'numerical', 'integerOnly'=>true),
			array('name', 'length', 'max'=>256),
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
			'age_months_from' => 'Возраст от',
			'age_months_to' => 'Возраст до',
			'is_different_ages' => 'Разновозрастная группа',
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
	 * Возвращает список возрастов
	 */
	public function getAgeOptions()
	{
		return array(
			2 => '2 месяца',
			6 => '6 месяцев',
			12 => '1 год',
			18 => '1.5 года',
			24 => '2 года',
			36 => '3 года',
			48 => '4 года',
			60 => '5 лет',
			72 => '6 лет',
			84 => '7 лет',
		);
	}
	
	public function getAgeFrom()
	{
		$ages = $this->getAgeOptions();
		return $ages[$this->age_months_from];	
	}
	
	public function getAgeTo()
	{
		$ages = $this->getAgeOptions();
		return $ages[$this->age_months_to];
	}

}