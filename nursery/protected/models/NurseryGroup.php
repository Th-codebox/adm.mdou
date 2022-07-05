<?php

/**
 * This is the model class for table "{{nursery_group}}".
 *
 * The followings are the available columns in table '{{nursery_group}}':
 * @property integer $id
 * @property integer $nursery_id
 * @property integer $group_id
 * @property integer $free_places
 * @property integer $total_places
 * @property string $create_time
 * @property integer $create_user_id
 * @property string $update_time
 * @property integer $update_user_id
 *
 * The followings are the available model relations:
 */
class NurseryGroup extends NurseryActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return NurseryGroup the static model class
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
		return '{{nursery_group}}';
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
			array('nursery_id, group_id, name', 'required'),
			array('nursery_id, group_id, free_places, total_places', 'numerical', 'integerOnly'=>true),
			array('name', 'length', 'max'=>255),
			array('disease_id', 'safe'),
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
			'nursery' => array(
				self::BELONGS_TO, 'Nursery', 'nursery_id',
			),
			'group' => array(
				self::BELONGS_TO, 'GroupType', 'group_id',
			),
			'disease' => array(
				self::BELONGS_TO, 'Disease', 'disease_id',
			),			
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'nursery_id' => 'МДОУ',
			'group_id' => 'Группа',
			'disease_id' => 'Специализация',
			'name'=>'Название',
			'free_places' => 'Свободных мест',
			'total_places' => 'Всего мест',
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
	
	public function getNameWithFreePlaces()
	{
		$name = $this->getName();
		if (isset($this->disease))
			$name .= ", ".$this->disease->getName();
		return $name." (".$this->free_places." / ".$this->total_places." мест)";
	}

}
