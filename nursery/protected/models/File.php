<?php

/**
 * This is the model class for table "{{file}}".
 */
class File extends CActiveRecord
{
	/**
	 * The followings are the available columns in table '{{file}}':
	 * @var integer $id
	 * @var string $nameRus
	 * @var string $nameEng
	 * @var string $mimeType
	 * @var integer $size
	 * @var string $extension
	 * @var string $path
	 * @var string $httpPath
	 * @var string $originalName
	 * @var integer $isImage
	 * @var integer $status
	 * @var string $created
	 * @var string $modified
	 */

	public $file;
	private $fileObject;

	/**
	 * Returns the static model of the specified AR class.
	 * @return File the static model class
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
		return '{{file}}';
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
			array('file', 'required', 'on'=>'create'),
			array('size, is_image, status', 'numerical', 'integerOnly'=>true),
			array('name, path, http_path, original_name', 'length', 'max'=>255),
			array('mime_type', 'length', 'max'=>50),
			array('extension', 'length', 'max'=>10),
			array('file, created, modified', 'safe'),
			array('file', 'file', 'types' => 'jpg, gif, png, bmp, doc, pdf', 'on' => 'clientUpload'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, name, mime_type, size, extension, path, http_path, original_name, status, created, modified', 'safe', 'on'=>'search'),
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
			'nodes'=>array(
				self::MANY_MANY, 'Node', 'tbl_file_node(file_id, node_id)'
			),
			'photo'=>array(
				self::HAS_ONE, 'Photo', 'file_id'
			),
			'thumb'=>array(
				self::HAS_ONE, 'Photo', 'thumb_file_id'
			),

/*			'nodes'=>array(
				self::HAS_MANY, 'FileNode', 'fileId'
			),*/
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'Id',
			'name' => 'Название файла',
			'file' => 'Файл',
			'mime_type' => 'MIME-тип файла',
			'size' => 'Размер файла',
			'extension' => 'Расширение файла',
			'path' => 'Путь к файлу на сервере',
			'http_path' => 'Http-путь к файлу',
			'original_name' => 'Оригинальное название файла',
			'status' => 'Статус',
			'created' => 'Дата создания',
			'modified' => 'Дата редактирования',
		);
	}

	public function getName()
	{
		return $this->name;
	}

	public function getSize()
	{
		return File::formatBytes($this->size);
	}
	
	public function getFullPath()
	{
		return Yii::app()->params['fileFolderPath'].$this->path;
	}

	public function getHttpPath()
	{
		return Yii::app()->params['fileHttpPath'].$this->path;
	}

	public function createPath($fileCode)
	{
		$path = Yii::app()->params['fileFolderPath'];
		$path .= $this->fileObject->getFileObjectType();
		
		if (!file_exists($path))
			mkdir($path, 0777);
		$path .= '/'.$this->fileObject->id;
		if (!file_exists($path))
			mkdir($path, 0777);
		$path .= '/';
		$num = 1;
		while (file_exists($path.$fileCode.'_'.$num.'.'.$this->file->extensionName))
			$num++;

		$this->path = $this->fileObject->getFileObjectType()
			.'/'.$this->fileObject->id.'/'.$fileCode.'_'.$num.'.'.$this->file->extensionName;
//		$this->path = $path.'file_'.$num.'.'.$this->file->extensionName;
		$this->http_path = Yii::app()->params['fileHttpPath'].$this->fileObject->getFileObjectType()
			.'/'.$this->fileObject->id.'/file_'.$num.'.'.$this->file->extensionName;
		
	}

	public function fill($fileObject)
	{
		$this->mime_type = $this->file->type;
		$this->size = $this->file->size;
		$this->original_name = $this->file->tempName;
		$this->extension = $this->file->extensionName;
		$this->is_image = 0;
		$this->fileObject = $fileObject;

		$this->createPath('file');
	}

	public function fillAsImage($fileObject, $fileCode)
	{
		$this->mime_type = $this->file->type;
		$this->size = $this->file->size;
		$this->original_name = $this->file->tempName;
		$this->extension = $this->file->extensionName;
		$this->is_image = 1;
		$this->fileObject = $fileObject;

		$this->createPath($fileCode);
	}

	public function getFileTypeImage()
	{
		$imgFile = "file";
		$ext = $this->extension;
		if ($ext == "doc" || $ext == "docx")
			$imgFile = "doc";
		if ($ext == "xls")
			$imgFile = "xls";
		if ($ext == "pdf")
			$imgFile = "pdf";
		if ($ext == "ppt")
			$imgFile = "ppt";
		if ($ext == "zip")
			$imgFile = "zip";
		if ($ext == "rar")
			$imgFile = "rar";
		if ($ext == "txt")
			$imgFile = "txt";
		if ($ext == "jpg" || $ext == "jpeg" || $ext == "gif" || $ext == "png"
			|| $ext == "bmp")
			$imgFile = "jpg";
		if ($ext == "wav" || $ext == "mp3")
			$imgFile = "wav";
		if ($ext == "avi" || $ext == "mpg" || $ext == "mpeg")
			$imgFile = "avi";

		return $imgFile;
	}

	public function getAdminNavigation($params = array())
	{
		$navigation = array("Файлы"=>array_merge(array("file/index"), $params));
		if (!$this->isNewRecord)
			$navigation = array_merge($navigation, array(
				$this->getName()=>array_merge(array("file/update", "id"=>$this->id), $params)
			));
		return $navigation;
	}

	protected function afterSave()
	{
		if (!$this->is_image && $this->isNewRecord) {
			if ($this->fileObject->getFileObjectType() == "node") {
				$fileNode = new FileNode();
				$fileNode->file_id = $this->id;
				$fileNode->node_id = $this->fileObject->id;
				$fileNode->save();
			}
		}
	}

	private function formatBytes($bytes, $precision = 2)
	{
		$units = array('B', 'KB', 'MB', 'GB', 'TB');

		$bytes = max($bytes, 0);
		$pow = floor(($bytes ? log($bytes) : 0) / log(1024));
		$pow = min($pow, count($units) - 1);

		$bytes /= pow(1024, $pow);

		return round($bytes, $precision) . ' ' . $units[$pow];
	}
	
	protected function beforeDelete()
	{
		if (file_exists($this->getFullPath()))
			if (!unlink($this->getFullPath()))
				return false;
		FileNode::model()->deleteAll('file_id='.$this->id);
				
		parent::beforeDelete();
		
		return true;
	}
}
