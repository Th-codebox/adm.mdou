<?php

/**
 * This is the model class for table "{{privilege_document}}".
 *
 * The followings are the available columns in table '{{privilege_document}}':
 * @property integer $id
 * @property string $name
 * @property integer $request_id
 * @property integer $privilege_id
 * @property string $issue_date
 * @property string $create_time
 * @property integer $create_user_id
 * @property string $update_time
 * @property integer $update_user_id
 *
 * The followings are the available model relations:
 */
class PrivilegeDocument extends NurseryActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return PrivilegeDocument the static model class
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
		return '{{privilege_document}}';
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
			array('name, request_id, privilege_id, issue_date', 'required', 'message' => "Пункт {attribute} не должен быть пустым"),
			array('issue_date', 'type', 'type' => 'date', 'dateFormat' => 'yyyy-MM-dd', 'message' => "Пункт \"{attribute}\" не является датой в формате ГГГГ-ММ-ДД."),
			array('issue_date', 'notMoreThanToday'),
			array('request_id, privilege_id', 'numerical', 'integerOnly'=>true),
			array('name', 'length', 'max'=>255),
			array('document_type_id', 'safe'),
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
			'privilege' => array(self::BELONGS_TO, 'Privilege', 'privilege_id'),
			'files' => array(self::MANY_MANY, 'File',
				'{{privilege_document_file_assignment}}(privilege_document_id, file_id)'
			),
			'documentType' => array(self::BELONGS_TO, 'DocumentType', 'document_type_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'name' => 'Номер документа',
			'request_id' => 'Заявление',
			'privilege_id' => 'Льгота',
			'document_type_id'=>'Тип документа',
			'issue_date' => 'Дата выдачи',
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
		$criteria->compare('name',$this->name,true);
		$criteria->compare('request_id',$this->request_id);
		$criteria->compare('privilege_id',$this->privilege_id);
		$criteria->compare('issue_date',$this->issue_date,true);
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
		return $this->name;
	}
	
	public function getIssueDate()
	{
		return date("d.m.Y", CDateTimeParser::parse($this->issue_date, "yyyy-MM-dd"));
	}
	
	protected function afterSave()
	{
		$pdid = $this->id;
		// clear all existing files for this privilege document
		$cmd = Yii::app()->db->createCommand("SELECT privilege_document_id, file_id FROM tbl_privilege_document_file_assignment WHERE privilege_document_id=:id");
		$cmd->bindParam(":id", $pdid);
		$fileids = $cmd->queryColumn();
		foreach ($fileids as $fid)
		{
			$curfile = File::model()->findByPk($fid);
			$curfile->delete();
		}
		// store new files
		foreach ($this->files as $file)
		{
			$file->createPath('file');
			$file->file->saveAs($file->getFullPath());
			$file->save(false);
			$id = $this->id;
			// clear all existing privileges for our request
			$command = Yii::app()->db->createCommand("INSERT INTO tbl_privilege_document_file_assignment (privilege_document_id, file_id) VALUES (:pdid, :fid)");
			$command->bindParam(":pdid", $id);
			$fid = $file->id;
			$command->bindParam(":fid", $fid);
			$command->execute();
		}
	}
	
	public function getFileObjectType()
	{
		return "privilege_document";
	}
	
	public function deleteFiles()
	{
		// cascade delete all related files
		foreach ($this->files as $file)
		{
			$file->delete();
		}
		// delete file-pdoc assignment also
		$command = Yii::app()->db->createCommand("DELETE FROM tbl_privilege_document_file_assignment WHERE privilege_document_id=:id");
		$id = $this->id;
		$command->bindParam(":id", $id);
		$command->execute();	
	}
	
	protected function beforeDelete()
	{
		$this->deleteFiles();
		
		parent::beforeDelete();
		return true;
	}
	
	public function getDocumentName()
	{
		return isset($this->documentType) ? $this->documentType->getName() : "Другой";
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
}
