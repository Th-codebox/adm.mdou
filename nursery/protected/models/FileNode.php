<?php

/**
 * This is the model class for table "{{file_node}}".
 */
class FileNode extends CActiveRecord
{
	/**
	 * The followings are the available columns in table '{{file_node}}':
	 * @var integer $fileId
	 * @var integer $nodeId
	 * @var integer $priority
	 */

	/**
	 * Returns the static model of the specified AR class.
	 * @return FileNode the static model class
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
		return '{{file_node}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('file_id, node_id', 'required'),
			array('file_id, node_id, priority', 'numerical', 'integerOnly'=>true),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('file_id, node_id, priority', 'safe', 'on'=>'search'),
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
			'nodes' => array(
				self::BELONGS_TO, 'Node', 'node_id'
			),
			'files' => array(
				self::BELONGS_TO, 'File', 'file_id'
			),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'file_id' => 'File',
			'node_id' => 'Node',
			'priority' => 'Priority',
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

		$criteria->compare('file_id',$this->file_id);

		$criteria->compare('node_id',$this->node_id);

		$criteria->compare('priority',$this->priority);

		return new CActiveDataProvider(get_class($this), array(
			'criteria'=>$criteria,
		));
	}
}