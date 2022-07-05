<?php

/**
 * This is the model class for table "{{nursery}}".
 *
 * The followings are the available columns in table '{{nursery}}':
 * @property integer $id
 * @property string $code
 * @property string $name
 * @property string $short_name
 * @property integer $town_id
 * @property integer $microdistrict_id
 * @property integer $street_id
 * @property string $house
 * @property string $building
 * @property string $phone
 * @property integer $place_number
 * @property string $create_time
 * @property integer $create_user_id
 * @property string $update_time
 * @property integer $update_user_id
 *
 * The followings are the available model relations:
 */
class Nursery extends NurseryActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return Nursery the static model class
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
		return '{{nursery}}';
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
			array('name, short_name, short_number, town_id, microdistrict_id, street_id, house', 'required'),
			array('short_number, town_id, microdistrict_id, street_id, place_number', 'numerical', 'integerOnly'=>true),
			array('code, house, building', 'length', 'max'=>10),
			array('name, short_name', 'length', 'max'=>255),
			array('phone', 'length', 'max'=>100),
			array('diseases', 'safe'),
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
			'town' => array(
				self::BELONGS_TO, 'Town', 'town_id',
			),
			'microdistrict' => array(
				self::BELONGS_TO, 'Microdistrict', 'microdistrict_id',
			),
			'street' => array(
				self::BELONGS_TO, 'Street', 'street_id',
			),
			'head' => array(
				self::HAS_ONE, 'NurseryHead', 'nursery_id',
			),
			'diseases' => array(
				self::MANY_MANY, 'Disease', '{{nursery_disease_assignment}}(nursery_id, disease_id)',
			),
			'groups' => array(
				self::HAS_MANY, 'NurseryGroup', 'nursery_id',
				'order'=>'id ASC'
			),

//			'groups' => array(
//				self::MANY_MANY, 'NurseryGroup', '{{nursery_group}}(nursery_id, group_id)',
//			),

//			'requests' => array(
//				self::STAT, 'Request', '{{request_nursery_assignment}}(request_id, nursery_id)',
//				'select'=>'COUNT(request_id)'
//			),

		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'code' => 'Код',
			'name' => 'Название',
			'short_name' => 'Сокращение',
			'short_number'=> 'Порядковый номер',
			'town_id' => 'Населенный пункт',
			'microdistrict_id' => 'Микрорайон',
			'street_id' => 'Улица',
			'house' => 'Дом',
			'building' => 'Корпус',
			'phone' => 'Телефон',
			'place_number' => 'Количество мест',
			'create_time' => 'Create Time',
			'create_user_id' => 'Create User',
			'update_time' => 'Update Time',
			'update_user_id' => 'Update User',
            'address' => 'Адрес',
            'head' => 'Руководитель',
            'diseases' => 'Специализации',
            'requests' => 'Заявления',
            'groups' => 'Группы',
		);
	}

	/*
	 * Возвращает название МДОУ
	 */
	public function getName()
	{
		return $this->name;
	}

	/*
	 * Возвращает сокращенное название МДОУ
	 */
	public function getShortName()
	{
		return $this->short_name;
	}
	
	/*
	 * Возвращает адрес МДОУ
	 */
	public function getAddress()
	{
		if (isset($this->street) && $this->street->id != 0)
			return $this->street->getName().", ".($this->house != "" ? $this->house : "");
		else
			return "";
	}

	/**
	 *  Сохраняет специализации, соответствующие данному МДОУ
	 */
	public function saveDiseases($diseases)
	{
		$nurseryId = $this->id;
		if (!$this->isNewRecord) {
			$command = $this->dbConnection->createCommand("DELETE FROM tbl_nursery_disease_assignment WHERE nursery_id=:nursery_id");
			$command->bindParam(':nursery_id', $nurseryId);
			$command->execute();
		}

		foreach ($diseases as $id) {
			$command = $this->dbConnection->createCommand("INSERT INTO tbl_nursery_disease_assignment (nursery_id, disease_id) VALUES (:nursery_id,:disease_id)");
			$command->bindParam(':nursery_id', $nurseryId);
			$command->bindParam(':disease_id', $id);
			$command->execute();
		}
	}
	
	public function getPhone()
	{
		if (!isset($this->phone)) return "";
		if (mb_strlen($this->phone) != 6) return $this->phone;
		return $this->phone[0].$this->phone[1]."-".$this->phone[2].$this->phone[3]."-".$this->phone[4].$this->phone[5];
	}
}
