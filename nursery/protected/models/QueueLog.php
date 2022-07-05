<?php

/**
 * This is the model class for table "{{queue_log}}".
 *
 * The followings are the available columns in table '{{queue_log}}':
 * @property integer $id
 * @property integer $request_id
 * @property integer $queue_number
 * @property string $create_time
 *
 * The followings are the available model relations:
 */
class QueueLog extends CActiveRecord
{
	/*
	 * Направление в МДОУ
	 */
	const TYPE_DIRECTION = 0;
	/*
	 * Постановка в очередь
	 */
	const TYPE_ENQUEUE = 1;
	/*
	 * Перерегистрация
	 */
	const TYPE_REREGISTER = 2;
	/*
	 * Снятие с очереди
	 */
	const TYPE_REMOVE = 3;
	/*
	 * Возвращение из архива
	 */
	const TYPE_RESTORE = 4;

//	private $_oldQueueNumber;
	/**
	 * Returns the static model of the specified AR class.
	 * @return QueueLog the static model class
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
		return '{{queue_log}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('request_id, queue_number', 'required'),
			array('request_id, queue_number, type', 'numerical', 'integerOnly'=>true),
//			array('create_time', 'safe'),
			array('create_time','default',
				'value'=>new CDbExpression('NOW()'),
				'setOnEmpty'=>false,'on'=>'insert'
			),
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
			'request_id' => 'Заявление',
			'queue_number' => 'Номер в очереди',
			'type' => 'Тип действия',
			'create_time' => 'Дата изменения',
		);
	}
	
	/*
	 * Возвращает дату изменения номера
	 */
	public function getCreateTime()
	{
		return date("d.m.Y H:i:s", CDateTimeParser::parse($this->create_time, "yyyy-MM-dd HH:mm:ss"));
	}
	
	/*
	 * Возвращает корректный номер в очереди
	 */
	public function getQueueNumber()
	{
		return Request::getProcessedQueueNumber($this->queue_number);
	}
	
	/*
	 * Возвращает список типов действий
	 */
	public function getTypeOptions()
	{
		return array(
			self::TYPE_DIRECTION => 'Выдано направление в МДОУ',
			self::TYPE_ENQUEUE => 'Постановка в очередь',
			self::TYPE_REREGISTER => 'Пересчет очереди',
			self::TYPE_REMOVE => 'Снятие с очереди',
			self::TYPE_RESTORE => 'Возвращение из архива'
		);
	}
	
	/*
	 * Возвращает наименование типа действия
	 */
	public function getTypeName()
	{
		$options = $this->getTypeOptions();
		if (isset($options[$this->type]))
			return $options[$this->type];
		else {
			return '-';
//			throw CHttpException(404, 'Тип действия не найден');
		}
    }

}
