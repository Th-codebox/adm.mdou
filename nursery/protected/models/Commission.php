<?php

/**
 * This is the model class for table "{{commission}}".
 *
 * The followings are the available columns in table '{{commission}}':
 * @property integer $id
 * @property string $full_name
 * @property string $surname
 * @property string $name
 * @property string $patronymic
 * @property string $post
 * @property string $phone
 * @property integer $is_head
 * @property string $create_time
 * @property integer $create_user_id
 * @property string $update_time
 * @property integer $update_user_id
 *
 * The followings are the available model relations:
 */
class Commission extends NurseryActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return Commission the static model class
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
		return '{{commission}}';
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
			array('surname, name, patronymic, post', 'required'),
			array('is_head, is_active', 'numerical', 'integerOnly'=>true),
			array('full_name', 'length', 'max'=>255),
			array('surname, name_dative, post, phone', 'length', 'max'=>100),
			array('name, patronymic', 'length', 'max'=>50),
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
			'full_name' => 'ФИО',
			'surname' => 'Фамилия',
			'name' => 'Имя',
			'patronymic' => 'Отчество',
			'name_dative'=>'ФИО в дательном падеже',
			'post' => 'Должность',
			'phone' => 'Телефон',
			'is_head' => 'Является председателем',
			'is_active' => 'Выводить при формировании документов',
			'create_time' => 'Create Time',
			'create_user_id' => 'Create User',
			'update_time' => 'Update Time',
			'update_user_id' => 'Update User',
		);
	}

	public function getShortName()
	{
		$res = "";
		if (isset($this->surname) && strlen($this->surname) > 1)
			$res .= $this->surname;
		if (isset($this->name) && strlen($this->name) > 1)
			$res .= " ".mb_substr($this->name, 0, 1, 'UTF-8').".";
		if (isset($this->patronymic) && strlen($this->patronymic) > 1)
			$res .= " ".mb_substr($this->patronymic, 0, 1, 'UTF-8').".";
		
		return $res;
	}
	
	public function getFullName()
	{
		return $this->full_name;
	}
	
	protected function beforeSave()
	{
		if (mb_strlen($this->surname, 'UTF-8') < 2)
			$this->full_name = $this->name." ".$this->patronymic;
		else
			$this->full_name = $this->surname." ".$this->name." ".$this->patronymic;
			
		if ($this->is_head) {
			$id = $this->id;
			$command = Yii::app()->db->createCommand("UPDATE tbl_commission SET is_head='0' WHERE id<>:id");
			$command->bindParam(":id", $id);
			$command->execute();
		}

		return parent::beforeSave();
	}
	
	/*
	 * Возвращает председателя комиссии
	 */
	public static function getHead()
	{
		$head = Commission::model()->find(array('condition'=>'is_head=1'));
		if (!isset($head))
			throw new CHttpException(500, 'В комиссии отсутствует председатель');
		return $head;
	}

	/*
	 * Возвращает список членов комиссии без председателя
	 */
	public static function getMembers()
	{
		$members = Commission::model()->findAll(array('condition'=>'is_head=0 and is_active=1', 'order'=>'full_name'));
		if (count($members) == 0)
			throw new CHttpException(500, 'В составе комиссии нет ни одного члена');
		return $members;
	}

}
