<?php

/**
 * This is the model class for table "{{photo}}".
 */
class Photo extends CActiveRecord
{
	/**
	 * The followings are the available columns in table '{{photo}}':
	 * @var integer $id
	 * @var string $nameRus
	 * @var string $nameEng
	 * @var integer $fileId
	 * @var integer $width
	 * @var integer $height
	 * @var integer $thumbFileId
	 * @var integer $thumbWidth
	 * @var integer $thumbHeight
	 * @var integer $isGallery
	 * @var integer $status
	 * @var string $created
	 * @var string $modified
	 */

	public $image;	// File
	public $thumb;	// File
	public $photoObject;

	/**
	 * Returns the static model of the specified AR class.
	 * @return Photo the static model class
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
		return '{{photo}}';
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
			array('image', 'required', 'on'=>'create'),
			array('file_id, width, height, thumb_file_id, thumb_width, thumb_height, 
				status',	'numerical', 'integerOnly'=>true),
			array('created, modified', 'safe'),
			array('modified','default',
			    'value'=>new CDbExpression('NOW()'),
			    'setOnEmpty'=>false,'on'=>'update'),
			array('created, modified', 'default',
			    'value'=>new CDbExpression('NOW()'),
			    'setOnEmpty'=>false,'on'=>'insert'),
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
			'image' => array(
				self::BELONGS_TO, 'File', 'file_id'
			),
			'thumb' => array(
				self::BELONGS_TO, 'File', 'thumb_file_id'
			),
			'nodes'=>array(
				self::MANY_MANY, 'Node', 'tbl_photo_node(photo_id, node_id)'
			),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'Id',
			'name'=> 'Название',
			'image' => 'Файл изображения',
			'file_id' => 'Файл изображения',
			'width' => 'Ширина',
			'height' => 'Высота',
			'thumb_file_id' => 'Файл миниатюры',
			'thumb_width' => 'Ширина миниатюры',
			'thumb_height' => 'Высота миниатюры',
			'status' => 'Статус',
			'created' => 'Дата создания',
			'modified' => 'Дата изменения',
		);
	}

	public function getName()
	{
		return htmlspecialchars($this->name);
	}

	public function getNameWithDimensions()
	{
		return htmlspecialchars($this->name)
			." (".$this->width." x ".$this->height.")";
	}

	public function getHttpPath()
	{
		$file = File::model()->findByPk($this->file_id);
		return $file->getHttpPath();
	}

	public function getThumbHttpPath()
	{
		$file = File::model()->findByPk($this->thumb_file_id);
		return $file->getHttpPath();
	}
	
	public function getMimeType()
	{
		$file = File::model()->findByPk($this->file_id);
		return $file->mime_type;
	}
	
	public function getFileSize()
	{
		$file = File::model()->findByPk($this->file_id);
		return $file->getSize();
	}

	public function getThumbImage($params = null)
	{
		if (!isset($params))
			$params = array(
				'style'=>'border:1px solid #c8c5be; margin: 0px 10px 5px 0px;',
				'align'=>'left',
			);
		$params = array_merge($params, array(
			'width'=>$this->thumb_width,
			'height'=>$this->thumb_height,
		));
		$file = File::model()->findByPk($this->thumb_file_id);
		return CHtml::image($file->getHttpPath(), $this->getName(), $params);
	}

	public function getImage($params = null)
	{
		if (!isset($params))
			$params = array(
				'style'=>'border:1px solid #c8c5be; margin: 0px 10px 5px 0px;',
				'align'=>'left',
			);
		$params = array_merge($params, array(
			'width'=>$this->width,
			'height'=>$this->height,
		));
		$file = File::model()->findByPk($this->file_id);
		return CHtml::image($file->getHttpPath(), $this->getName(), $params);
	}

	public function getImageLink($isTextImage = false)
	{
		$params = array();
		if ($isTextImage)
			$params = array(
				'style'=>'border:1px solid #c8c5be; margin: 0px 10px 5px 0px;',
				'align'=>'left',
			);

		$SIZE = 150;
		$file = File::model()->findByPk($this->file_id);
		if ($this->width > $this->height) {
			$params = array_merge($params, array('width'=>min($this->width, $SIZE)));
		}
		else {
			$params = array_merge($params, array('height'=>min($this->height, $SIZE)));
		}

		$image = CHtml::image($file->getHttpPath(), $this->getName(), $params);

		return CHtml::link($image, $this->getHttpPath(), array(
			'rel'=>'lightbox', 'title'=>$this->getName())
		);
	}

	public function getAdminNavigation($params = array())
	{
		$navigation = array("Фотографии"=>array_merge(array("photo/index"), $params));
		if (!$this->isNewRecord)
			$navigation = array_merge($navigation, array(
				$this->getName()=>array_merge(array("photo/update", "id"=>$this->id), $params)
			));
		return $navigation;
	}

	protected function afterSave()
	{
		if ($this->isNewRecord) {
			if ($this->photoObject->getFileObjectType() == "node") {
				$photoNode = new PhotoNode();
				$photoNode->photo_id = $this->id;
				$photoNode->node_id = $this->photoObject->id;
				$photoNode->save();
			}
		}
	}
	
	protected function beforeDelete()
	{
		if ($this->image()->delete() && $this->thumb()->delete()) {
			PhotoNode::model()->deleteAll('photo_id='.$this->id);
			return parent::afterDelete();
		}
		else
			return false;
	}

	public static function enableLightBox()
	{
		$cs = Yii::app()->clientScript;
		//подключаем jquery, которая идет в комплекте с фреймворком
		$cs->registerCoreScript('jquery');
		//подключаем lightbox
		$cs->registerScriptFile(Yii::app()->request->baseUrl.'/js/lightbox/js/jquery.lightbox-0.5.min.js', CClientScript::POS_END);
		$cs->registerScriptFile(Yii::app()->request->baseUrl.'/js/init_lightbox.js' ,CClientScript::POS_END);
		$cs->registerCssFile(Yii::app()->request->baseUrl.'/js/lightbox/css/jquery.lightbox-0.5.css');
	}

}
