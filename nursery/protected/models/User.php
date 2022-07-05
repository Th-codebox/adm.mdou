<?php

/**
 * This is the model class for table "{{user}}".
 *
 * The followings are the available columns in table '{{user}}':
 * @property integer $id
 * @property string $username
 * @property string $password
 * @property string $name
 * @property string $last_login_time
 * @property string $create_time
 * @property integer $create_user_id
 * @property string $update_time
 * @property integer $update_user_id
 *
 * The followings are the available model relations:
 */
class User extends NurseryActiveRecord
{
	public $password_repeat;
	public $password_unencrypted;
		
	/**
	 * Returns the static model of the specified AR class.
	 * @return User the static model class
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
		return '{{user}}';
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
			array('username', 'required', 'on'=>'insert,update'),
			array('username', 'unique'),
			array('username', 'length', 'max'=>256),
			array('password,password_repeat', 'required', 'on'=>'insert,newPassword'),
			array('password', 'length', 'min'=>5),
			array('password', 'length', 'max'=>256),
			array('password', 'compare', 'on'=>'insert,newPassword'),
			array('password', 'safe', 'on'=>'update'),
			array('password_repeat', 'safe'),
			array('name', 'safe'),
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
			'username' => 'Логин',
			'password' => 'Пароль',
			'password_repeat' => 'Подтверждение пароля',
			'name' => 'Имя пользователя',
			'last_login_time' => 'Время последнего входа',
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

	public function encryptPassword()
	{
		$this->password = $this->encrypt($this->password);
		$this->password_repeat = $this->encrypt($this->password_repeat);
	}
	
	public function encrypt($value)
	{
		return md5($value);	
	}

	public function generatePassword()
	{
		$this->password = mt_rand(100, 999).mt_rand(100, 999).mt_rand(100, 999);
		$pwd = $this->password;
		$this->password_repeat = $pwd;
	}
	
	public function associateUserToRole($role, $userId)
	{
		$sql = "INSERT INTO tbl_user_role (user_id, role) VALUES (:userId, :role)";
		$command = Yii::app()->db->createCommand($sql);
		$command->bindValue(":userId", $userId, PDO::PARAM_INT);
		$command->bindValue(":role", $role, PDO::PARAM_STR);
		return $command->execute();
	}

	/**
		* removes an association between the project, the user and the user's role within the project
	*/
	public function removeUserFromRole($role, $userId)
	{
		$sql = "DELETE FROM tbl_user_role WHERE user_id=:userId AND role=:role";
		$command = Yii::app()->db->createCommand($sql);
		$command	->bindValue(":userId", $userId, PDO::PARAM_INT);
		$command->bindValue(":role", $role, PDO::PARAM_STR);
		return $command->execute();
	}
	
	public function isUserInRole($role)
	{
		$sql = "SELECT role FROM tbl_user_role WHERE user_id=:userId AND role=:role";
		$command = Yii::app()->db->createCommand($sql);
		$command->bindValue(":userId", Yii::app()->user->getId(), PDO::PARAM_INT);
		$command->bindValue(":role", $role, PDO::PARAM_STR);
		return $command->execute()==1 ? true : false;
	}
	
	/**
	* Returns an array of available roles in which a user can be placed when being added to a project
	*/
	public static function getUserRoleOptions()
	{
		return CHtml::listData(Yii::app()->authManager->getRoles(), 'name', 'description');
	}
	
	public function getRoles()
	{
		if (!$this->isNewRecord)
			return CHtml::listData(Yii::app()->authManager->getRoles($this->id), 'name', 'description');
		else
			return array();
	}
	
	public function saveRoles($roles)
	{
		foreach (Yii::app()->authManager->getAuthItems(2, $this->id) as $item) {
			Yii::app()->authManager->revoke($item->name, $this->id);
		}
		foreach ($roles as $roleId)
			if (!Yii::app()->authManager->isAssigned($roleId, $this->id))
				Yii::app()->authManager->assign($roleId, $this->id);
	}
	
	public function getRoleNames()
	{
		$roles = Yii::app()->authManager->getRoles($this->id);
		$text = "";
		foreach ($roles as $role)
			$text .= $role->description."<br>";
		
		return $text;
	}
	
	protected function beforeDelete()
	{
		$id = $this->id;
		// clear all role data
/*		$sql = "DELETE FROM tbl_user_role WHERE user_id=:userId";
		$command = Yii::app()->db->createCommand($sql);
		$command	->bindValue(":userId", $id, PDO::PARAM_INT);
		$command->execute();*/
		parent::beforeDelete();
		return true;
	}
}
