<?php

/**
 * This is the model class for table "{{active_record_log}}".
 *
 * The followings are the available columns in table '{{active_record_log}}':
 * @property integer $id
 * @property string $description
 * @property string $action
 * @property string $model
 * @property integer $model_id
 * @property string $field
 * @property string $create_time
 * @property integer $create_user_id
 *
 * The followings are the available model relations:
 */
class ActiveRecordLog extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return ActiveRecordLog the static model class
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
		return '{{active_record_log}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('description, action, model, model_id, create_time, create_user_id', 'required'),
			array('model_id, create_user_id', 'numerical', 'integerOnly'=>true),
			array('description', 'length', 'max'=>255),
			array('action', 'length', 'max'=>20),
			array('model, field', 'length', 'max'=>45),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, description, action, model, model_id, field, create_time, create_user_id', 'safe', 'on'=>'search'),
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
			'user' => array(
				self::BELONGS_TO, 'User', 'create_user_id',
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
			'description' => 'Описание',
			'action' => 'Действие',
			'model' => 'Объект',
			'model_id' => 'Id объекта',
			'field' => 'Поле',
			'create_time' => 'Дата операции',
			'create_user_id' => 'Id пользователя',
			'user' => 'Пользователь',
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
		$criteria->compare('description',$this->description,true);
		$criteria->compare('action',$this->action,true);
		$criteria->compare('model',$this->model,true);
		$criteria->compare('model_id',$this->model_id);
		$criteria->compare('field',$this->field,true);
		$criteria->compare('create_time',$this->create_time,true);
		$criteria->compare('create_user_id',$this->create_user_id);

		return new CActiveDataProvider(get_class($this), array(
			'criteria'=>$criteria,
		));
	}
}