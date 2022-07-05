<?php

/**
 * This is the model class for table "{{privilege}}".
 *
 * The followings are the available columns in table '{{privilege}}':
 * @property integer $id
 * @property string $name
 * @property string $code
 * @property integer $out_of_queue
 * @property string $create_time
 * @property integer $create_user_id
 * @property string $update_time
 * @property integer $update_user_id
 *
 * The followings are the available model relations:
 */
class Privilege extends NurseryActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return Privilege the static model class
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
		return '{{privilege}}';
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
			array('out_of_queue, is_active', 'numerical', 'integerOnly'=>true),
			array('name', 'required'),
			array('name', 'length', 'max'=>100),
			array('description', 'length', 'max'=>5000),
			array('code', 'length', 'max'=>10),
			array('documents', 'safe'),
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
			'documents' => array(
				self::MANY_MANY, 'DocumentType', '{{privilege_document_assignment}}(privilege_id, document_id)',
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
			'name' => 'Название',
			'description'=>'Описание',
			'documents'=>'Документы',
			'code' => 'Код в старой системе',
			'out_of_queue' => 'Вне очереди',
			'is_active'=>'Показывать на сайте',
			'create_time' => 'Create Time',
			'create_user_id' => 'Create User',
			'update_time' => 'Update Time',
			'update_user_id' => 'Update User',
		);
	}

	/*
	 * Возвращает наименование
	 */
	public function getName()
	{
		return $this->name;
	}
	
	public function getShortDescription()
	{
		$desc = isset($this->description) ? $this->description : "";
		if (mb_strlen($this->description, 'UTF-8') > 500)
			return substr($desc, 0, 500)."...";
		else
			return $desc;			
	}
	
	/*
	 *  Возвращает строку со списком документов, необходимых для получения льготы
	 */
	public function getDocuments()
	{
		$list = array();
		foreach ($this->documents as $doc) {
			array_push($list, $doc->getName());
		}
		$result = join(", ", $list);

		return $result;
	}


}