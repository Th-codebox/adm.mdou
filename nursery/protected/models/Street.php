<?php

/**
 * This is the model class for table "{{street}}".
 *
 * The followings are the available columns in table '{{street}}':
 * @property integer $id
 * @property string $code
 * @property string $name
 * @property integer $street_type_id
 * @property string $create_time
 * @property integer $create_user_id
 * @property string $update_time
 * @property integer $update_user_id
 *
 * The followings are the available model relations:
 */
class Street extends NurseryActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return Street the static model class
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
		return '{{street}}';
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
			array('street_type_id', 'numerical', 'integerOnly'=>true),
			array('code', 'length', 'max'=>10),
			array('name', 'length', 'max'=>255),
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
			'microdistricts' => array(self::MANY_MANY, 'Microdistrict', '{{microdistrict_street_assignment}}(street_id, microdistrict_id)'),
			'type' => array(self::BELONGS_TO, 'StreetType', 'street_type_id'),
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
			'street_type_id' => 'Тип улицы',
			'create_time' => 'Create Time',
			'create_user_id' => 'Create User',
			'update_time' => 'Update Time',
			'update_user_id' => 'Update User',
            'microdistrict' => 'Микрорайон',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('code',$this->code,true);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('street_type_id',$this->street_type_id);
		$criteria->compare('create_time',$this->create_time,true);
		$criteria->compare('create_user_id',$this->create_user_id);
		$criteria->compare('update_time',$this->update_time,true);
		$criteria->compare('update_user_id',$this->update_user_id);

		return new CActiveDataProvider(get_class($this), array(
			'criteria'=>$criteria,
		));
	}

	/*
	 * Возвращает название улицы с полным наименованием типа улицы
	 */
	public function getFullName()
	{
		return $this->name." ".mb_strtolower($this->type->getName(), 'UTF-8');
	}

	/*
	 * Возвращает название улицы
	 */
	public function getName()
	{
		return $this->type->getShortName()." ".$this->name;
	}

	/*
	 * Возвращает название улицы с типом улицы в конце
	 */
	public function getNameReversed()
	{
		return $this->name." ".$this->type->getShortName();
	}
	
	/*
	 * Возвращает список микрорайонов, к которым относится улица
	 */
	public function getMicrodistricts()
	{
		$list = array();
		foreach ($this->microdistricts as $microdistrict)
			array_push($list, $microdistrict->getName());
		$result = join(", ", $list);
		
		return $result;
	}


}