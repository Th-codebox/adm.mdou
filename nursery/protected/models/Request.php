<?php

/**
 * This is the model class for table "{{request}}".
 *
 * The followings are the available columns in table '{{request}}':
 * @property integer $id
 * @property integer $user_id
 * @property string $code
 * @property string $filing_date
 * @property string $surname
 * @property string $name
 * @property string $patronymic
 * @property string $birth_date
 * @property string $document_series
 * @property string $document_number
 * @property string $document_date
 * @property string $address_other
 * @property integer $town_id
 * @property integer $microdistrict_id
 * @property integer $street_id
 * @property string $house
 * @property string $building
 * @property string $flat
 * @property string $phone
 * @property string $email
 * @property integer $reg_number
 * @property integer $queue_number
 * @property integer $has_privilege
 * @property integer $status
 * @property string $create_time
 * @property integer $create_user_id
 * @property string $update_time
 * @property integer $update_user_id
 *
 * The followings are the available model relations:
 */
class Request extends NurseryActiveRecord
{
	/*
	 * Заявление не заполнено
	*/
	const STATUS_NOTCOMPLETED = 0;
	/*
	 * Заявление не обработано
	 */
	const STATUS_UNPROCESSED = 1;
	/*
	 * Заявление принято к рассмотрению
	 */
	const STATUS_ACCEPTED = 2;
	/*
	 * Отказано в постановке на учет
	 */
	const STATUS_DENIED = 3;
	/*
	 * Заявление отклонено
	 */
	const STATUS_REJECTED = 4;
	/*
	 * Заявление изменено // не используется
	 */
//	const STATUS_MODIFIED = 5;
	/*
	 * Заявление активно
	 */
	const STATUS_ACTIVE = 6;
	/*
	 * Заявление снято с учета
	 */
	const STATUS_DEREGISTERED = 7;
	/*
	 * Предоставлено место в МДОУ
	 */
	const STATUS_GRANTED = 8;
	/*
	 * Зачислен
	 */
	const STATUS_ENROLLED = 9;
	/*
	 * Не удалось уведомить
	 */
	const STATUS_ABSENT = 10;
	/*
	 * Не явился
	 */
	const STATUS_NONAPPEARED = 11;
	/*
	 *  Рассмотрение закончено
	 */
	const STATUS_FINISHED = 12;
	
	/*
	 *  Общая очередь
	 */
	const QUEUE_ALL = 0;
	
	/*
	 *  Льготная очередь
	 */
	const QUEUE_PRIVILEGE = 1;
	
	/*
	 *  Без очереди
	 */
	const QUEUE_OUT_OF_QUEUE = 2;
	
	/*
	 * Номер очереди отозван
	 */
	const QUEUE_NUMBER_NONE = -1;
	
	/*
	 * Заявление находится в блоке самых верхних заявлений
	 */
	const QUEUE_NUMBER_TOP = 0;

	/*
	 * Какое имя должно быть у файла с копией свидетельства о рождении
	*/
	const BIRTH_DOCUMENT_NAME = "Копия свидетельства о рождении";
	
	public $verify_code;
	public $agreement;
	
	private $_oldQueueNumber;

	/**
	 * Returns the static model of the specified AR class.
	 * @return Request the static model class
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
		return '{{request}}';
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
			array('reg_number', 'required', 'message' => "Пункт {attribute} не должен быть пустым"),
			array('town_id, microdistrict_id, street_id, reg_number, queue_number, has_privilege, out_of_queue, is_email_confirm, status', 'numerical', 'integerOnly'=>true),
			array('code, document_series, document_number, house, building', 'length', 'max'=>10),
			array('surname, name, patronymic, email', 'length', 'max'=>50),
			array('email','email', 'message' => "Адрес электронной почты в поле E-mail не является правильным E-mail адресом."),
			//array('full_name', 'length', 'max'=>'255'),
			array('street_id, address_other, house', 'validateAddress'),
			array('agreement', 'validateAgreement', 'on' => 'clientCreate'),
			array('is_email_confirm', 'validateEmail'),
			array('phone', 'length', 'max'=>255),
			array('name, surname, patronymic, birth_date, document_series, document_number, document_date', 'required', 'message' => "Пункт \"{attribute}\" не должен быть пустым"),
			array('birth_date', 'validateBirthDate', 'on' => 'clientCreate'),
			array('address_other', 'length', 'max'=>255),
			array('flat', 'length', 'max'=>10),
			array('birth_date, document_date', 'type', 'type' => 'date', 'dateFormat' => 'yyyy-MM-dd', 'message' => "Пункт \"{attribute}\" не является датой в формате ГГГГ-ММ-ДД.", 'on' => 'clientCreate'),
			array('birth_date, document_date', 'notMoreThanToday', 'on' => 'clientCreate'),
			array('filing_date, register_date, birth_date, document_date', 'safe'),
//			array('nurseries', 'safe'),
			array('agreement', 'safe'),
			array('privileges', 'safe'),
			array('disease_id', 'safe'),
			array('comment', 'safe'),
			array('is_archive, is_restore', 'safe'),
			array('user', 'safe'),
			array('verify_code', 'captcha', 'on'=>'clientCreate', 'allowEmpty' => !extension_loaded('gd'), 'captchaAction'=>'site/captcha'),
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
			'microdistrict' => array(self::BELONGS_TO, 'Microdistrict', 'microdistrict_id'),
			'street' => array(self::BELONGS_TO, 'Street', 'street_id'),
			'applicant' => array(self::HAS_ONE, 'Person', 'request_id', 'condition'=>'is_applicant=1'),
			'user' => array(self::BELONGS_TO, 'User', 'user_id', 'condition'=>'is_applicant=1'),
			'nurseries' => array(self::MANY_MANY, 'Nursery', 
				'{{request_nursery_assignment}}(request_id, nursery_id)', // FIXME!!! Bad to rely on DBMS returning orders, but does not know how to do it properly :-(
				'order'=>'priority'
			),
			'privileges' => array(self::MANY_MANY, 'Privilege',
				'{{privilege_document}}(request_id, privilege_id)'
			),
			'persons' => array(
				self::HAS_MANY, 'Person', 'request_id',
				'order'=>'id'
			),
			'privilegeDocuments' => array(
				self::HAS_MANY, 'PrivilegeDocument', 'request_id',
				'order'=>'id'
			),
			'operations' => array(
				self::HAS_MANY, 'OperationLog', 'request_id',
				'order'=>'create_time ASC'
			),
			'disease' => array(self::BELONGS_TO, 'Disease', 'disease_id'),
			'files' => array(self::MANY_MANY, 'File', 
				'{{request_file_assignment}}(request_id, file_id)',
			),
			'directions' => array(
				self::HAS_MANY, 'RequestNurseryDirection', 'request_id',
				'order'=>'create_time ASC'
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
			'user_id' => 'Пользователь',
			'disease_id' => 'Специализация',
			'code' => 'Код в старой системе',
			'filing_date' => 'Дата заполнения',
			'register_date' => 'Дата регистрации',
			'surname' => 'Фамилия',
			'name' => 'Имя',
			'patronymic' => 'Отчество',
			'full_name' => 'ФИО',
			'birth_date' => 'Дата рождения',
			'document_series' => 'Серия свидетельства о рождении',
			'document_number' => 'Номер свидетельства о рождении',
			'document_date' => 'Дата выдачи свидетельства о рождении',
			'address_other' => 'Адрес',
			'town_id' => 'Населенный пункт',
			'microdistrict_id' => 'Микрорайон',
			'street_id' => 'Улица',
			'house' => 'Дом',
			'building' => 'Корпус',
			'flat' => 'Квартира',
			'phone' => 'Доп. телефон',
			'email' => 'E-mail',
			'is_email_confirm' => 'Высылать подтверждения по e-mail',
			'is_internet' => 'Подано через интернет',
			'reg_number' => 'Номер',
			'queue_number' => 'Очередь',
			'has_privilege' => 'Льготная очередь',
			'out_of_queue' => 'Вне очереди',
            'status' => 'Статус',
            'is_archive' => 'Помещено в архив',
            'is_restore' => 'Возвращено из архива',
            'comment' => 'Комментарий',
			'create_time' => 'Дата создания',
			'create_user_id' => 'Пользователь, подавший заявление',
			'update_time' => 'Последнее изменение',
			'update_user_id' => 'Пользователь, внесший изменения',
			'address' => 'Адрес',
			'nurseries' => 'МДОУ',
			'privileges' => 'Льготы',
		);
	}

	/*
	 * Возвращает ФИО ребенка
	 */
	public function getFullName()
	{
		$res = $this->name;
		if (mb_strlen($this->patronymic, 'UTF-8') > 1)
			$res .= " ".$this->patronymic;
		if (mb_strlen($this->surname) > 1)
			$res = $this->surname." ".$res;

		return $res;
	}

	/*
	 * Возвращает адрес ребенка
	 */
	public function getAddress()
	{
		$address = $this->address_other;

		if (!isset($address) || $address == "") {
			$parts = array();
			if (isset($this->street))
				array_push($parts, $this->street->getName());
			if ($this->house != "") {
				array_push($parts, "д. ".$this->house);
				if ($this->building != "")
					array_push($parts, "корп. ".$this->building);
				if ($this->flat != "")
					array_push($parts, "кв. ".$this->flat);
			}
			$address = join(", ", $parts);
		}

		return $address;
	}

	/*
	 * Возвращает полный адрес ребенка
	 */
	public function getFullAddress()
	{
		$address = $this->address_other;

		if (!isset($address) || $address == "") {
			$parts = array();
			if (isset($this->town))
				array_push($parts, $this->town->getName());
			if (isset($this->microdistrict))
				array_push($parts, 'р-н '.$this->microdistrict->getName());

			$address = join(", ", $parts);
			$address .= ", ".$this->getAddress();
		}
		
		return $address;	
	}

	/*
	 * Возвращает адрес для картографических систем (полный, без указания номера квартиры)
	 */
	public function getMapAddress()
	{
		$address = $this->address_other;

		if (!isset($address) || $address == "") {
			$parts = array();
			if (isset($this->town))
				array_push($parts, $this->town->getName());
			if (isset($this->microdistrict))
				array_push($parts, $this->microdistrict->getName());
			if (isset($this->street))
				array_push($parts, $this->street->getName());
			if ($this->house != "") {
				array_push($parts, "д. ".$this->house);
				if ($this->building != "")
					array_push($parts, "корп. ".$this->house);
			}

			$address = join(", ", $parts);
		}

		return $address;
	}

	/*
	 *  Возвращает строку со списком желаемых для поступления МДОУ
	 */
	public function getNurseries()
	{
		$list = array();
		foreach ($this->nurseries as $nursery) {
			array_push($list, $nursery->getShortName());
		}
		$result = join(", ", $list);

		return $result;
	}

	/*
	 * Возвращает наличие льгот
	 */
	public function getPrivileges()
	{
/*		$list = array();
		foreach ($this->privileges as $privilege)
			array_push($list, $privilege->getName());
		$result = join("; ", $list);*/
        $result = $this->has_privilege > 0 ? "да" : "нет";
        if ($this->has_privilege == 0 && count($this->privileges) > 0)
            $result .= " / ".count($this->privileges);
        
		return $result;
	}

	/*
	 * Возвращает список льгот
	 */
	public function getPrivilegeList()
	{
		$result = "";
		$list = array();
		foreach ($this->privileges as $privilege)
			array_push($list, $privilege->getName());
		$result = join("; ", $list);
        
		return $result;
	}

	/*
	 * Возвращает дату рождения
	 */
	public function getBirthDate()
	{
		return date("d.m.Y", CDateTimeParser::parse($this->birth_date, "yyyy-MM-dd"));
	}
	
	public function getFilingDate()
	{
		return date("d.m.Y", CDateTimeParser::parse($this->filing_date, "yyyy-MM-dd"));
	}

	public function getRegisterDate()
	{
		return isset($this->register_date) ? date("d.m.Y", CDateTimeParser::parse($this->register_date, "yyyy-MM-dd hh:mm:ss")) : "нет";
	}
	
	public function getEmail()
	{
		return isset($this->email) ? $this->email : "";
	}
	
	public function getIsInternet()
	{
		return $this->is_internet ? "да" : "нет";
	}
	
	public function getCreateTime()
	{
		return $this->create_time;
	}

	public function getUpdateTime()
	{
		return date("d.m.Y H:i:s", CDateTimeParser::parse($this->update_time, "yyyy-MM-dd hh:mm:ss"));
	}
	
	public function getPrivilegeInfo()
	{
		if ($this->out_of_queue)
			return "вне очереди";
		return $this->has_privilege ? "да" : "нет";
	}
	
	public function getCreateUser()
	{
		$user = User::model()->findByPk($this->create_user_id);
		if (isset($user))
			return $user->getName();
		else
			return "";
	}	

	public function getUpdateUser()
	{
		$user = User::model()->findByPk($this->update_user_id);
		if (isset($user))
			return $user->getName();
		else
			return "";
	}	


	/*
	 * Возвращает список статусов
	 */
	public static function getStatusOptions()
	{
		return array(
			self::STATUS_NOTCOMPLETED => 'Не заполнено',
			self::STATUS_UNPROCESSED => 'Не обработано',
			self::STATUS_ACCEPTED => 'Принято к рассмотрению',
			self::STATUS_DENIED => 'Отказано в постановке',
			self::STATUS_REJECTED => 'Отклонено',
//			self::STATUS_MODIFIED => 'Изменено',
			self::STATUS_ACTIVE => 'Активно',
			self::STATUS_DEREGISTERED => 'Снято с учета',
			self::STATUS_GRANTED => 'Предложено место',
			self::STATUS_ENROLLED => 'Зачислен',
			self::STATUS_ABSENT => 'Не удалось уведомить',
			self::STATUS_NONAPPEARED => 'Не явился',
			self::STATUS_FINISHED => 'Рассмотрение закончено',
		);
	}

	/*
	 * Возвращает список статусов для пользователей 
	 */
	public static function getStatusOptionsClient()
	{
		return array(
			self::STATUS_UNPROCESSED => 'Не обработано',
			self::STATUS_ACCEPTED => 'Принято к рассмотрению',
			self::STATUS_DENIED => 'Отказано в постановке',
			self::STATUS_REJECTED => 'Отклонено',
			self::STATUS_ACTIVE => 'Активно',
			self::STATUS_DEREGISTERED => 'Снято с учета',
			self::STATUS_GRANTED => 'Предложено место',
			self::STATUS_ENROLLED => 'Зачислен',
			self::STATUS_ABSENT => 'Не удалось уведомить',
			self::STATUS_NONAPPEARED => 'Не явился',
			self::STATUS_FINISHED => 'Рассмотрение закончено',
		);
	}

	/*
	 * Возвращает список типов очереди
	 */
	public function getQueueOptions()
	{
		return array(
			self::QUEUE_ALL => 'Общая',
			self::QUEUE_PRIVILEGE => 'Льготная',
			self::QUEUE_OUT_OF_QUEUE => 'Вне очереди',
		);
	}
	
	/*
	 * Возвращает информацию о свидетельстве о рождении
	 */
	public function getBirthDocument()
	{
		$doc = "№ ".$this->document_number;
		if (mb_strlen($this->document_series, 'UTF-8') > 1)
			$doc = $this->document_series." ".$doc;
		if (isset($this->document_date) && $this->document_date !== '0000-00-00')
			$doc .= ", выдано ".date("d.m.Y", CDateTimeParser::parse($this->document_date, "yyyy-MM-dd"));
		
		return $doc;
	}


	/*
	 * Возвращает наименование типа представитя
	 */
	public function getStatusName()
	{
		$options = $this->getStatusOptions();
		if (isset($options[$this->status]))
			return $options[$this->status];
		else {
			throw CHttpException(404, 'Статус не найден');
		}
    }

	/*
	 * Возвращает наименование типа представитя
	 */
	public static function getStatusNameStatic($status)
	{
		$options = Request::getStatusOptions();
		if (isset($options[$status]))
			return $options[$status];
		else
			throw CHttpException(404, 'Статус не найден');
    }

    public function getAvailableOperations()
    {
        $operations = Operation::model()->findAllBySql(
			"SELECT * FROM {{operation}} WHERE id IN "
			." (SELECT operation_id FROM {{operation_status_assignment}} WHERE status_id=:statusId)"
			." OR is_from_all_statuses='1' ORDER BY priority ASC",
            array(
                ':statusId'=>$this->status,
            ));

        return $operations;
    }
    
    public function generateRegNumber()
    {
//    	if ($this->reg_number === 0)
			$this->reg_number = (100000 + $this->id)."".mt_rand(100, 999);
    }

	protected function beforeSave()
	{
/*		if ($this->isNewRecord) {
			$this->reg_number = 0;
			$maxQueueNumber = $this->getDbConnection()->createCommand("SELECT MAX(`queue_number`) FROM {$this->tableName()}")->queryScalar();
			$this->queue_number = $maxQueueNumber + 1;
			$this->is_internet = 0;
			$this->status = Request::STATUS_UNPROCESSED;
			$this->filing_date = new CDbExpression('NOW()');
		}*/
		$this->full_name = $this->surname." ".$this->name." ".$this->patronymic;
		if (isset($this->user) && isset($this->applicant))
		{
			$this->user->name = $this->applicant->full_name;
			$this->user->save();
		}
		return parent::beforeSave();
	}
	
	protected function afterSave()
	{
/*		if ($this->isNewRecord) {
			print "afterSave: new record<br>";
			if (!$this->generateRegNumber())
				return false;
			$this->saveAttributes(array('reg_number' => $this->reg_number));
		} */
		
		return parent::afterSave();
	}
	
	/*
		Проверяет, есть ли информация о матери у заявления
	*/
	public function haveMotherInfo()
	{
		for ($i = 0; $i < count($this->persons); $i++)
		{
			if ($this->persons[$i]->applicant_type_id == Person::TYPE_MOTHER)
			{
				return true;
			}
		}
		return false;
	}
	
	/*
		Проверяет, есть ли информация об отце у заявления
	*/
	public function haveFatherInfo()
	{
		for ($i = 0; $i < count($this->persons); $i++)
		{
			if ($this->persons[$i]->applicant_type_id == Person::TYPE_FATHER)
			{
				return true;
			}
		}
		return false;
	}
	
	/**
	 *  Сохраняет МДОУ, выбранные у данного заявления
	 */
	public function saveNurseries()
	{
		$command = $this->dbConnection->createCommand("DELETE FROM tbl_request_nursery_assignment WHERE request_id=:id");
		$id = $this->id;
		$command->bindParam(':id', $id);
		$command->execute();
		
		foreach ($this->nurseries as $i=>$nid) 
		{
			$this->dbConnection->createCommand("INSERT INTO tbl_request_nursery_assignment (request_id, nursery_id, priority) VALUES ({$this->id},{$nid},{$i})")->execute();
		}
	}
	
	/*
		Сохраняет информацию о льготах заявления
	*/
	public function savePrivilegeDocuments()
	{
		$id = $this->id;
		// clear all existing privileges for our request
		$pdocs = $this->dbConnection->createCommand("SELECT id FROM tbl_privilege_document WHERE request_id={$this->id}")->queryColumn();
		foreach ($pdocs as $pdid)
		{
			PrivilegeDocument::model()->findByPk($pdid)->delete();
		}
		// store all pdocs in database
		foreach ($this->privilegeDocuments as $pdoc)
		{
			$pdoc->request_id = $id;
			if (!$pdoc->save()) return false;
		}
		return true;
	}
	/*
		Каскадно удаляет все зависимости (уж больно много их скопилось)
	*/
	protected function beforeDelete()
	{
		$id = $this->id;
		
		foreach ($this->privilegeDocuments as $pdoc)
		{
			$pdoc->delete();
		}
		foreach ($this->persons as $person)
		{
			$person->delete();
		}

		// delete nursery assignments
		$command = Yii::app()->db->createCommand("DELETE FROM tbl_request_nursery_assignment WHERE request_id=:id");
		$command->bindParam(":id", $id);
		$command->execute();

		// delete user
		$user = $this->user;
		if (isset($user))
		{
			$user->delete();
		}
		// delete all related files
		$ids = array();
		foreach ($this->files as $file)
		{
			array_push($ids, $file->id);
		}
		$command = Yii::app()->db->createCommand("DELETE FROM tbl_request_file_assignment WHERE request_id=:id");
		$command->bindParam(":id", $id);
		$command->execute();
		foreach ($ids as $fid)
		{
			File::model()->findByPk($fid)->delete();
		}
		// delete log of operations
		$command = Yii::app()->db->createCommand("DELETE FROM tbl_operation_log WHERE request_id=:id");
		$command->bindParam(":id", $id);
		$command->execute();
		// delete log of queue
		$command = Yii::app()->db->createCommand("DELETE FROM tbl_queue_log WHERE request_id=:id");
		$command->bindParam(":id", $id);
		$command->execute();
		// delete nursery directions
		$command = Yii::app()->db->createCommand("DELETE FROM tbl_request_nursery_direction WHERE request_id=:id");
		$command->bindParam(":id", $id);
		$command->execute();
		
		parent::beforeDelete();
		return true;
	}
	
	public function getSimilarRequests()
	{
		$criteria = new CDbCriteria;
		$criteria->addCondition('id <> :id');
		$criteria->params[':id'] = $this->id;
		
		$condition = 'name=:name AND surname=:surname OR birth_date=:birthDate ';
		if (isset($this->document_number) && ($this->document_number !== "")) {
			$condition .= ' OR document_number=:documentNumber';
			$criteria->params[':documentNumber'] = $this->document_number;
		}
		$criteria->addCondition($condition);
		$criteria->params[':name'] = $this->name;
		$criteria->params[':surname'] = $this->surname;
		$criteria->params[':birthDate'] = $this->birth_date;
		
		$requests = Request::model()->findAll($criteria);
		
		return $requests;
	}
	
	public function validateAddress($att, $params)
	{
		$town = isset($this->town_id) ? $this->town_id : -1;
		if ($town == "") $town = -1;
		if ($att == 'street_id')
		{
			if ((!isset($this->street_id) || ($this->street_id == "")) && $town == 1) 
			{
				$this->addError($att, 'Пункт Улица не должен быть пустым');
				return false;
			}
			return true;
		}
		if ($att == 'house')
		{
			if ((!isset($this->house) || ($this->house == "")) && $town == 1) 
			{
				$this->addError($att, 'Пункт Дом не должен быть пустым');
				return false;
			}
			return true;
		}
		if ($att == 'address_other')
		{
			if ((!isset($this->address_other) || ($this->address_other == "")) && $town != 1) 
			{
				$this->addError($att, 'Пункт Адрес не должен быть пустым');
				return false;
			}
			return true;
		}
	}
	
	/*
	 * Возвращает возраст ребенка в годах
	 */
	public function getAgeYears()
	{
		date_default_timezone_set('Europe/Moscow');
		$dob = new DateTime($this->birth_date);
		$age = 0;
		$now = new DateTime(date("Y-m-d"));
		while( $dob->add( new DateInterval('P1Y') ) < $now )
			$age++;
			
		if ($age > 10)
			return "-";
		
		if ($age == 0)
			$age .= "&nbsp;лет";
		else if ($age == 1)
			$age .= "&nbsp;год";
		else if ($age < 5)
			$age .= "&nbsp;года";
		else
			$age .= "&nbsp;лет";
	
		return $age;
	}

	/*
	 * Возвращает возраст ребенка в месяцах
	 */
	public function getAgeMonths()
	{
//			"SELECT FLOOR(12 * datediff(now(), birth_date) / 365.4 ) FROM {$this->tableName()} WHERE id=$this->id"
		return $this->getDbConnection()->createCommand(
			"SELECT PERIOD_DIFF(date_format(now(), '%Y%m'), date_format(birth_date, '%Y%m')) FROM {$this->tableName()} WHERE id=$this->id"
		)->queryScalar();
	}

	public function createUser()
	{
		$user = new User;
		$user->is_applicant = 1;
		$user->username = $this->reg_number;
		$user->generatePassword();
		$user->password_unencrypted = $user->password;
		$user->encryptPassword();
		$user->name = $this->applicant->full_name;
		if (!$this->replaceUser($user)) return false;
		return true;
	}

	public function replaceUser($user)
	{
		$olduser = $this->user;
		if (isset($olduser->id)) 
		{
			$olduser::model()->deleteByPk($olduser->id);
		}
		if (!$user->save()) 
		{
			return false;
		}
		Yii::app()->authManager->assign("applicant", $user->id);
		$this->user_id = $user->id;
		if (!$this->save(false, array('user_id'))) return false;
		$this->user = $user;
		return true;
	}
	
	/*
	 * Смена пароля у заявителя
	 */ 
	public function changePassword()
	{
		if (!isset($this->user))
			$this->createUser();
		$this->user->generatePassword();
		$password = $this->user->password;
		$this->user->encryptPassword();
		$this->user->save(false);
		
		return $password;
	}

	public static function getTotalQueueNumber()
	{
		$model = Request::model();
		return $model->getDbConnection()->createCommand(
			"SELECT count(*) FROM {$model->tableName()} WHERE status<>"
			.Request::STATUS_NOTCOMPLETED." and status<>".Request::STATUS_FINISHED)->queryScalar();
	}

	public static function getTotalAcceptedNumber()
	{
		$model = Request::model();
		return $model->getDbConnection()->createCommand(
			"SELECT count(*) FROM {$model->tableName()} WHERE status="
			.Request::STATUS_ACCEPTED)->queryScalar();
	}

	public static function getTotalNewNumber()
	{
		$model = Request::model();
		return $model->getDbConnection()->createCommand(
			"SELECT count(*) FROM {$model->tableName()} WHERE status="
			.Request::STATUS_UNPROCESSED)->queryScalar();
	}

	public static function getTotalArchiveNumber()
	{
		$model = Request::model();
		return $model->getDbConnection()->createCommand("SELECT count(*) FROM {$model->tableName()} WHERE is_archive='1'")->queryScalar();
	}
	
	public static function getTotalNotCompletedNumber()
	{
		$model = Request::model();
		return $model->getDbConnection()->createCommand(
			"SELECT count(*) FROM {$model->tableName()} WHERE status=".Request::STATUS_NOTCOMPLETED
		)->queryScalar();
	}

	
	public function getFileObjectType()
	{
		return "request";
	}
	
	public function getBirthDocumentFile()
	{
		$allfiles = $this->files;
		foreach ($allfiles as $file)
		{
			if ($file->name = Request::BIRTH_DOCUMENT_NAME)
			{
				return $file;
			}
		}
		return null;
	}
	
	public function saveBirthDocument($newfile)
	{
		$id = $this->id;
		$oldfile = $this->getBirthDocumentFile();
		if ($oldfile != null)
		{
			// delete link between old file and this request
			$command = Yii::app()->db->createCommand("DELETE FROM tbl_request_file_assignment WHERE request_id=:id AND file_id=:fid");
			$command->bindParam(":id", $id);
			$command->bindParam(":fid", $fid);
			$command->execute();
			// delete old file itself
			$oldfile->delete();
		}
		$newfile->name = Request::BIRTH_DOCUMENT_NAME;
		$newfile->save();
		$newfile->file->saveAs($newfile->getFullPath());
		$fid = $newfile->id;
		$command = Yii::app()->db->createCommand("INSERT INTO tbl_request_file_assignment (request_id, file_id) VALUES (:id, :fid)");
		$command->bindParam(":id", $id);
		$command->bindParam(":fid", $fid);
		$command->execute();
	}
	
	/*
	 * Получение нового номера в очереди (следующего за текущим максимальным)
	 */
	public function generateNewQueueNumber()
	{
		$maxQueueNumber = $this->getDbConnection()->createCommand(
			"SELECT MAX(`queue_number`) FROM {$this->tableName()} WHERE is_archive=0"
		)->queryScalar();
		$this->queue_number = $maxQueueNumber + 1;
	}
	
	public function logQueueNumber($queueLogType)
	{
		if ($this->isNewRecord)
			throw new CHttpException(404, 'Ошибка при записи информации об  изменении статуса');
		$queueLog = new QueueLog;
		$queueLog->request_id = $this->id;
		$queueLog->queue_number = $this->queue_number;
		$queueLog->type = $queueLogType;
		$queueLog->save();
	}
	
	public static function getProcessedQueueNumber($queueNumber)
	{
		if ($queueNumber == Request::QUEUE_NUMBER_NONE)
			return "отозван";
		else if ($queueNumber == Request::QUEUE_NUMBER_TOP)
			return "отозван";
		else
			return $queueNumber;
	}
	
	public function getQueueNumber()
	{
		return Request::getProcessedQueueNumber($this->queue_number);
	}
	
	/**
	 * Пересчет очереди
	 */
	public function renumberQueue()
	{
		if (!Yii::app()->user->checkAccess('updateRequest'))
			throw new CHttpException(403,'Недостаточно прав для выполнения операции');
			
		$this->removeNotCompleted();
		OperationLog::model()->resetTemporaryPasswords();
		
		$index = 0;
		$changedCount = 0;
		$reader = $this->dbConnection->createCommand(
			"SELECT id, queue_number, full_name FROM {{request}} WHERE queue_number > 0 and is_archive=0 ORDER BY queue_number ASC"
//			"SELECT id, queue_number FROM {{request}} ORDER BY queue_number ASC"
		)->query();
		$reader->bindColumn(1, $id);
		$reader->bindColumn(2, $number);		
//		$reader->bindColumn(3, $name);
		while ($reader->read() !== false) {
/*			// вставка на правильное место в очереди в случае технических ошибок
			if ($id == 11490 || $id == 11562)
				continue;*/	

			$index++;
			if ($index == $number)
				continue;
			if ($index > $number) {
				throw new CException('Ошибка при пересчете очереди');
			}
			
			$changedCount++;
			$command = Yii::app()->db->createCommand("UPDATE tbl_request SET queue_number=:number WHERE id=:id");
			$command->bindParam(":id", $id);
			$command->bindParam(":number", $index);
			$command->execute();
			
			$queueLogType = QueueLog::TYPE_REREGISTER;
			$command = Yii::app()->db->createCommand(
				"INSERT INTO tbl_queue_log (request_id, queue_number, type, create_time) VALUES (:id, :number, :type, NOW())"
			);
			$command->bindParam(":id", $id);
			$command->bindParam(":number", $index);
			$command->bindParam(":type", $queueLogType);
			$command->execute();

/*			// вставка на правильное место в очереди в случае технических ошибок
			if ($number == 4626) {
				$tid = 11490;
				$changedCount++;
				$index++;
				$command = Yii::app()->db->createCommand("UPDATE tbl_request SET queue_number=:number WHERE id=:id");
				$command->bindParam(":id", $tid);
				$command->bindParam(":number", $index);
				$command->execute();

				$queueLogType = QueueLog::TYPE_REREGISTER;
				$command = Yii::app()->db->createCommand(
					"INSERT INTO tbl_queue_log (request_id, queue_number, type, create_time) VALUES (:id, :number, :type, NOW())"
				);
				$command->bindParam(":id", $tid);
				$command->bindParam(":number", $index);
				$command->bindParam(":type", $queueLogType);
				$command->execute();

			}
			if ($number == 7502) {
				$tid = 11562;
				$changedCount++;
				$index++;
				$command = Yii::app()->db->createCommand("UPDATE tbl_request SET queue_number=:number WHERE id=:id");
				$command->bindParam(":id", $tid);
				$command->bindParam(":number", $index);
				$command->execute();

				$queueLogType = QueueLog::TYPE_REREGISTER;
				$command = Yii::app()->db->createCommand(
					"INSERT INTO tbl_queue_log (request_id, queue_number, type, create_time) VALUES (:id, :number, :type, NOW())"
				);
				$command->bindParam(":id", $tid);
				$command->bindParam(":number", $index);
				$command->bindParam(":type", $queueLogType);
				$command->execute();

			}
			*/
		}

		return $changedCount;
	}
	
	public function removeNotCompleted()
	{
		if (!Yii::app()->user->checkAccess('updateRequest'))
			throw new CHttpException(403,'Недостаточно прав для выполнения операции');

		$requests = Request::model()->findAllBySql(
			"select * from tbl_request where status=:statusId and create_time < DATE_SUB(NOW(), INTERVAL 2 HOUR)",
            array(
                ':statusId'=>Request::STATUS_NOTCOMPLETED,
            ));
		foreach ($requests as $request)
			$request->delete();
	}
	
	public function validateAgreement($att, $params)
	{
		if ($this->agreement == 1) return true;
		else
		{
			$this->addError($att, 'Для подачи заявления в электронном виде необходимо согласие на обработку персональных данных. В противном случае Вам необходимо обратиться лично в <a style="color:#FFFFFF" target="_blank" href="'.Yii::app()->request->baseUrl.'/site/section/9">комиссию по комплектованию МДОУ</a>.');
			return false;
		}
	}
	
	public function validateEmail($att, $params)
	{
		if ($this->is_email_confirm == 0) return true;
		else
		{
			if (!$this->email)
			{
				$this->addError($att, 'Для получения уведомлений по e-mail необходимо указать адрес электронной почты');
				return false;
			}
			return true;
		}
	}

	/*
	 * Создание нового направления 
	 */
	public function createNurseryDirection($nursery)
	{
		$direction = new RequestNurseryDirection;
		$direction->request_id = $this->id;
		$direction->nursery_id = $nursery->id;
		$direction->save();
	}
	
	/*
	 * Возвращает последнюю операцию
	 */
	public function getLastOperation()
	{
		$record = OperationLog::model()->find(array(
			'condition'=>'request_id=:request_id',
			'params'=>array('request_id'=>$this->id),
			'order'=>'create_time DESC'
		));
		return isset($record) ? $record->operation->getAction() : "Правка";
	}

	/*
		Проверяет, есть ли заявитель
	*/
	public function hasApplicant()
	{
		for ($i = 0; $i < count($this->persons); $i++)
		{
			if ($this->persons[$i]->is_applicant)
			{
				return true;
			}
		}
		return false;
	}
	
	/*
		Возвращает информацию о заявителе
	*/
	public function getApplicant()
	{
		for ($i = 0; $i < count($this->persons); $i++)
		{
			if ($this->persons[$i]->is_applicant)
			{
				return $this->persons[$i];
			}
		}
		return null;
	}
	
	/*
	 * Возвращает список садиков, подходящих по возрасту
	 */
	public function getSuitableNurseries()
	{
		$ageMonths = $this->getAgeMonths();
		
/*		$reader = $this->dbConnection->createCommand(
			"SELECT g.nursery_id"
			." FROM {{nursery_group}} g, {{group_type}} gt"
			." WHERE gt.age_months_from <= : AND gt.age_months_to >=15 AND gt.id = g.group_id"

//			"SELECT id, queue_number, full_name FROM {{request}} WHERE queue_number > 0 ORDER BY queue_number ASC"
//			"SELECT id, queue_number FROM {{request}} ORDER BY queue_number ASC"
		)->query();
		$reader->bindColumn(1, $nId);
		$nurseries = array();
		while ($reader->read() !== false) {
			array_push($nurseries, $nId);
		}*/
		
		$where = "gt.age_months_from <= :age AND gt.age_months_to >= :age AND gt.id = g.group_id AND g.free_places > 0";
		$where .= " AND g.disease_id=:disease_id";
		$nurseries = Nursery::model()->findAllBySql(
			"SELECT * from {{nursery}} WHERE id in "
			." (SELECT g.nursery_id"
			." FROM {{nursery_group}} g, {{group_type}} gt"
			." WHERE $where)",
			array(':age'=>$ageMonths, 'disease_id'=>$this->disease_id ? $this->disease_id : 0)
		);
		
		return $nurseries;
	}
	
	public function validateBirthDate($att, $params)
	{
		if ($this->birth_date > $this->document_date)
		{
			$this->addError($att, 'Дата рождения должна быть раньше даты выдачи свидетельства о рождении');
			return false;
		}
		return true;
	}
	
	public function isApplicantMother()
	{
		$app = $this->getApplicant();
		if ($app == null) return false;
		if ($app->applicant_type_id == Person::TYPE_MOTHER) return true;
		else return false;
	}
	
	public function isApplicantFather()
	{
		$app = $this->getApplicant();
		if ($app == null) return false;
		if ($app->applicant_type_id == Person::TYPE_FATHER) return true;
		else return false;
	}
	
	/*
		Возвращает информацию о матери
	*/
	public function getMother()
	{
		for ($i = 0; $i < count($this->persons); $i++)
		{
			if ($this->persons[$i]->applicant_type_id == Person::TYPE_MOTHER)
			{
				return $this->persons[$i];
			}
		}
		return null;
	}
	
	/*
		Возвращает информацию об отце
	*/
	public function getFather()
	{
		for ($i = 0; $i < count($this->persons); $i++)
		{
			if ($this->persons[$i]->applicant_type_id == Person::TYPE_FATHER)
			{
				return $this->persons[$i];
			}
		}
		return null;
	}
	
	public function deleteApplyOperations()
	{
		$oper = Operation::model()->findByPk(Operation::OPERATION_APPLY);
		if (!$oper) return;
		$command = Yii::app()->db->createCommand("DELETE FROM tbl_operation_log WHERE request_id=:id AND operation_id=:opid");
		$id = $this->id;
		$command->bindParam(":id", $id);
		$opid = $oper->id;
		$command->bindParam(":opid", $opid);
		$command->execute();
	}
	
	public function deleteMother()
	{
		$mother = $this->getMother();
		if ($mother)
		{
			if ($mother->is_applicant) return; 
			$mother->delete();
		}
	}
	
	public function deleteFather()
	{
		$father = $this->getFather();
		if ($father)
		{
			if ($father->is_applicant) return; 
			$father->delete();
		}
	}
	
	public function notMoreThanToday($att, $params)
	{
		$today = date("Y-m-d");
		if ($this->attributes[$att] > $today)
		{
			$this->addError($att, $this->getAttributeLabel($att)." не может быть позже сегодняшней даты.");
			return false;
		}
		return true;
	}
	
	/*
	 * Удаление персональных данных заявителя и прицепленных файлов после постановки на учет
	 */
	public function resetPrivateData()
	{
		$applicant = $this->applicant;
		$applicant->resetPrivateData();
		
		foreach ($this->privilegeDocuments as $pdoc) {
			$pdoc->deleteFiles();
		}

		foreach ($this->files as $file) {
			$file->delete();
		}
	}
}
