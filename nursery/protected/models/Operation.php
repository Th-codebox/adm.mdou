<?php

/**
 * This is the model class for table "{{operation}}".
 *
 * The followings are the available columns in table '{{operation}}':
 * @property integer $id
 * @property string $name
 * @property string $description
 * @property integer $new_request_status
 * @property integer $is_change_status
 * @property string $create_time
 * @property integer $create_user_id
 * @property string $update_time
 * @property integer $update_user_id
 *
 * The followings are the available model relations:
 */
class Operation extends NurseryActiveRecord
{
	/*
	 * Зарегистрировать
	 */
	const OPERATION_REGISTER = 1;
	/*
	 * Отказать в постановке на учет
	 */
	const OPERATION_DENY = 2;
	/*
	 * Отклонить
	 */
	const OPERATION_REJECT = 3;
	/*
	 * Поставить в очередь
	 */
	const OPERATION_ENQUEUE = 4;
	/*
	 * Снять с учета
	 */
	const OPERATION_DEREGISTER = 5;
	/*
	 * Предложить место
	 */
	const OPERATION_GRANT_PLACE = 6;
	/*
	 * Отменить предложение места
	 */
	const OPERATION_CANCEL_PLACE = 7;
	/*
	 * Аннулировать предоставление места
	 */
	const OPERATION_ANNUL_PLACE = 8;
	/*
	 * Зачислить
	 */
	const OPERATION_ENROLL = 9;
	/*
	 * Аннулировать зачисление
	 */
	const OPERATION_ANNUL_ENROLLMENT = 10;
	/*
	 * Изменить пароль
	 */
	const OPERATION_CHANGE_PASSWORD = 11;
	/*
	 * Восстановить из архива
	 */
	const OPERATION_RESTORE = 12;
	/*
	 * Подать заявление
	 */
	const OPERATION_APPLY = 13;
	/*
	 * Удалить персональные данные
	 */
	const OPERATION_CLEAR_PERSONAL_DATA = 14;
	/*
	 * Архивировать
	 */
	const OPERATION_ARCHIVE = 15;
	
	
	/**
	 * Returns the static model of the specified AR class.
	 * @return Operation the static model class
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
		return '{{operation}}';
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
			array('description', 'required'),
			array('new_request_status, is_change_status', 'numerical', 'integerOnly'=>true),
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
			'reasons' => array(self::MANY_MANY, 'OperationReason',
				'{{operation_reason_assignment}}(operation_id, reason_id)'
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
			'action' => 'Действие',
			'description' => 'Описание',
			'new_request_status' => 'Новый статус',
			'is_change_status' => 'Меняется статус',
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
    
    public function getAction()
    {
    	return $this->action;
    }

    public function getNewStatus()
    {
        return $this->new_request_status;
    }
    
	/*
	 * Возвращает список операций
	 */
	public static function getOperations()
	{
		$operations = Operation::model()->findAll(array("order"=>"id"));
		$result = array();
		foreach ($operations as $operation)
			$result[$operation->id] = $operation->getName();
		
		return $result;
	}
	
	/*
	 * Проверяет, нужно ли выбирать причину из справочника
	 */
	public function hasReason()
	{
		return count($this->reasons) > 0 ? true : false;
	}
	
	/*
	 * Вывод печатной формы
	 */
	public function printForm($fileName, $html)
	{
		header('Cache-Control: no-cache, must-revalidate'); // HTTP/1.1
		header('Expires: Sat, 26 Jul 1997 05:00:00 GMT'); // Date in the past
		header('Content-Disposition: attachment; filename='.$fileName.'.doc');
		header('Content-type: application/msword');
		print $html;
	}
	
	/*
	 * Проверяет, можно ли применить операцию к выбранному заявлению
	 */
	public function canApply($request)
	{
		if (!isset($request))
			return false;
			
		if ($this->id == Operation::OPERATION_CHANGE_PASSWORD)
			return true;
		
		if ($this->id == Operation::OPERATION_RESTORE) {
			return $request->is_archive ? true : false;
		}
			
		$operationId = $this->id;
		$statusId = $request->status;
		$sql = "SELECT COUNT(*) FROM {{operation_status_assignment}} WHERE operation_id=:operationId and status_id=:statusId";
		$command = $this->getDbConnection()->createCommand($sql);
		$command->bindParam(':operationId', $operationId);
		$command->bindParam(':statusId', $statusId);

		$cnt = $command->queryScalar();

		return $cnt > 0 ? true : false;
	}

}
