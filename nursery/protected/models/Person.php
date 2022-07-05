<?php

/**
 * This is the model class for table "{{person}}".
 *
 * The followings are the available columns in table '{{person}}':
 * @property integer $id
 * @property integer $request_id
 * @property string $full_name
 * @property string $surname
 * @property string $name
 * @property string $patronymic
 * @property string $work_place
 * @property string $work_post
 * @property string $phone
 * @property integer $applicant_type_id
 * @property string $create_time
 * @property integer $create_user_id
 * @property string $update_time
 * @property integer $update_user_id
 *
 * The followings are the available model relations:
 */
class Person extends NurseryActiveRecord
{
	const TYPE_MOTHER = 1;
	const TYPE_FATHER = 2;
	const TYPE_REPRESENTATIVE = 3;

	/**
	 * Returns the static model of the specified AR class.
	 * @return Person the static model class
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
		return '{{person}}';
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
			array('request_id, is_applicant, applicant_type_id', 'numerical', 'integerOnly'=>true),
			array('surname, name, patronymic, work_post', 'length', 'max'=>50),
			array('phone', 'length', 'max'=>255),
			array('surname, name, patronymic, phone', 'required', 'message' => "Пункт \"{attribute}\" не должен быть пустым"),
			array('passport_issue_date', 'type', 'type' => 'date', 'dateFormat' => 'yyyy-MM-dd', 'message' => "Пункт \"{attribute}\" не является датой в формате ГГГГ-ММ-ДД.", 'on' => 'requester'),
			array('passport_issue_date', 'notMoreThanToday', 'on' => 'requester'),
			array('passport_number', 'required', 'on' => 'requester', 'message' => "Пункт \"{attribute}\" не должен быть пустым"),
			array('passport_issue_data, passport_issue_date, passport_series', 'required', 'on' => 'requester', 'message' => "Пункт \"{attribute}\" не должен быть пустым"),
			array('work_place', 'length', 'max'=>100),
			array('passport_issue_data', 'length', 'max'=>255),
			array('passport_series', 'length', 'max'=>10),
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
			'request_id' => 'Номер заявления',
			'full_name' => 'ФИО',
			'surname' => 'Фамилия',
			'name' => 'Имя',
			'patronymic' => 'Отчество',
			'work_place' => 'Место работы',
			'work_post' => 'Должность',
			'phone' => 'Телефон',
			'applicant_type_id' => 'Кем приходится ребенку',
			'create_time' => 'Create Time',
			'create_user_id' => 'Create User',
			'update_time' => 'Update Time',
			'update_user_id' => 'Update User',
			'passport_series' => 'Серия паспорта',
			'passport_number' => 'Номер паспорта',
			'passport_issue_date' => 'Дата выдачи паспорта',
			'passport_issue_data' => 'Кем выдан паспорт',
		);
	}

	/*
	 * Возвращает ФИО человека
	 */
	public function getFullName()
	{
		return $this->full_name;
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
	
	public function getPassportIssueDate()
	{
		$date = $this->passport_issue_date;
		if ($date != "0000-00-00")
			return date("d.m.Y", CDateTimeParser::parse($this->passport_issue_date, "yyyy-MM-dd"));
		else
			return "";
	}
	
	/*
	 * Возвращает место работы и должность
	 */
	public function getWork()
	{
		$work = $this->work_place;
		if ($this->work_post != "")
			$work .= "(".$this->work_post.")";
		
		return $work;
	}
	
	/*
	 * Возвращает список типов представителей
	 */
	public function getTypeOptions()
	{
		return array(
			self::TYPE_MOTHER => 'Мать',
			self::TYPE_FATHER => 'Отец',
			self::TYPE_REPRESENTATIVE => 'Законный представитель',
		);
	}

	/*
	 * Возвращает наименование типа представитя
	 */
	public function getTypeName()
	{
		$options = $this->getTypeOptions();
		if (isset($options[$this->applicant_type_id]))
			return $options[$this->applicant_type_id];
		else
			return "Неизвестно";
//			throw new CHttpException(404, 'Тип представителя не найден');
	}
	
	protected function beforeSave()
	{
		$this->surname = Util::ucfirst($this->surname);
		$this->name = Util::ucfirst($this->name);
		$this->patronymic = Util::ucfirst($this->patronymic);

		if (mb_strlen($this->surname, 'UTF-8') < 2)
			$this->full_name = $this->name." ".$this->patronymic;
		else
			$this->full_name = $this->surname." ".$this->name." ".$this->patronymic;

		return parent::beforeSave();
	}
	
	public function getPassportInfo()
	{
		if ($this->is_applicant) {
			$series = $this->passport_series;
			$number = $this->passport_number;
			$data = $this->passport_issue_data;
			$date = $this->getPassportIssueDate();
			$result = "";
			if ($number == "")
				return "";
			if ($series != "")
				$result .= $series." ".$number;
			else
				$result = $number;
			if ($data !=  "") {
				$result .= " выдан ".$data;
				if ($date != "")
					$result .= ", ".$date;
			}
			
			return $result;
				
//			return $this->passport_series." ".$this->passport_number." выдан ".$this->passport_issue_data." ".$this->getPassportIssueDate();
		}
		
		return "нет";
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
	 * Удаление данных о паспорте заявителя
	 */
	public function resetPrivateData()
	{
		$this->passport_series = '';
		$this->passport_number = '';
		$this->passport_issue_date = '';
		$this->passport_issue_data = '';
		
		$this->save(false);
	}
}
