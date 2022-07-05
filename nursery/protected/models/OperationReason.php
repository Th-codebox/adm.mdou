<?php

/**
 * This is the model class for table "{{operation_reason}}".
 *
 * The followings are the available columns in table '{{operation_reason}}':
 * @property integer $id
 * @property string $name
 * @property string $create_time
 * @property integer $create_user_id
 * @property string $update_time
 * @property integer $update_user_id
 *
 * The followings are the available model relations:
 */
class OperationReason extends NurseryActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return OperationReason the static model class
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
		return '{{operation_reason}}';
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
			array('name', 'length', 'max'=>255),
			array('operations', 'safe'),
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
			'operations' => array(self::MANY_MANY, 'Operation',
				'{{operation_reason_assignment}}(reason_id, operation_id)'
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
			'operations' => 'Операции',
			'name' => 'Название',
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
	
	public function getOperationNames()
	{
		$text = "";
		foreach ($this->operations as $operation)
			$text .= $operation->getName()."<br>";
		
		return $text;
	}
}
