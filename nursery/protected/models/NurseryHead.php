<?php

/**
 * This is the model class for table "{{nursery_head}}".
 *
 * The followings are the available columns in table '{{nursery_head}}':
 * @property integer $id
 * @property integer $nursery_id
 * @property string $surname
 * @property string $name
 * @property string $patronymic
 * @property string $name_dative
 * @property string $post
 * @property string $post_dative
 * @property string $create_time
 * @property integer $create_user_id
 * @property string $update_time
 * @property integer $update_user_id
 *
 * The followings are the available model relations:
 */
class NurseryHead extends NurseryActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return NurseryHead the static model class
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
		return '{{nursery_head}}';
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
			array('nursery_id', 'numerical', 'integerOnly'=>true),
			array('surname, name, patronymic', 'length', 'max'=>30),
			array('name_dative', 'length', 'max'=>60),
			array('post, post_dative', 'length', 'max'=>50),
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
			'surname' => 'Фамилия',
			'name' => 'Имя',
			'patronymic' => 'Отчество',
			'name_dative' => 'Дательный падеж ФИО',
			'post' => 'Должность',
			'post_dative' => 'Дательный падеж должности',
			'create_time' => 'Create Time',
			'create_user_id' => 'Create User',
			'update_time' => 'Update Time',
			'update_user_id' => 'Update User',
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
		$criteria->compare('surname',$this->surname,true);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('patronymic',$this->patronymic,true);
		$criteria->compare('name_dative',$this->name_dative,true);
		$criteria->compare('post',$this->post,true);
		$criteria->compare('post_dative',$this->post_dative,true);
		$criteria->compare('create_time',$this->create_time,true);
		$criteria->compare('create_user_id',$this->create_user_id);
		$criteria->compare('update_time',$this->update_time,true);
		$criteria->compare('update_user_id',$this->update_user_id);

		return new CActiveDataProvider(get_class($this), array(
			'criteria'=>$criteria,
		));
	}
	
	public function getName()
	{
		return $this->surname." ".$this->name." ".$this->patronymic;	
	}
}
