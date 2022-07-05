<?php

/**
 * This is the model class for table "{{microdistrict}}".
 *
 * The followings are the available columns in table '{{microdistrict}}':
 * @property integer $id
 * @property integer $town_id
 * @property string $code
 * @property string $name
 * @property string $create_time
 * @property integer $create_user_id
 * @property string $update_time
 * @property integer $update_user_id
 *
 * The followings are the available model relations:
 */
class Microdistrict extends NurseryActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return Microdistrict the static model class
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
		return '{{microdistrict}}';
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
			array('code, town_id', 'required'),
			array('code', 'length', 'max'=>10),
			array('name', 'length', 'max'=>255),
			array('town_id', 'safe'),
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
			'town' => array(self::BELONGS_TO, 'Town', 'town_id'),
			'streets' => array(
				self::MANY_MANY, 'Street', '{{microdistrict_street_assignment}}(microdistrict_id, street_id)',
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
			'town_id' => 'Город',
			'code' => 'Код',
			'name' => 'Название',
			'streets' => 'Улицы',
			'create_time' => 'Дата создания',
			'create_user_id' => 'Автор',
			'update_time' => 'Дата изменения',
			'update_user_id' => 'Автор исправления',
		);
	}

	public function getName()
	{
		return $this->name;
	}
}