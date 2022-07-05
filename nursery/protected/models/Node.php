<?php

/**
 * This is the model class for table "{{node}}".
 *
 * The followings are the available columns in table '{{node}}':
 * @property integer $id
 * @property integer $parent_id
 * @property string $name
 * @property string $description
 * @property string $text
 * @property string $type
 * @property string $url
 * @property integer $is_new_window
 * @property integer $is_show_front
 * @property integer $is_show_children
 * @property integer $photo_id
 * @property integer $priority
 * @property integer $status_id
 * @property string $create_time
 * @property integer $create_user_id
 * @property string $update_time
 * @property integer $update_user_id
 *
 * The followings are the available model relations:
 */
class Node extends NurseryActiveRecord
{
	 public static $ROOT_ID = 1;
	/**
	 * Returns the static model of the specified AR class.
	 * @return Node the static model class
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
		return '{{node}}';
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
			array('parent_id, is_new_window, is_show_front, is_show_children, photo_id, priority, status_id, create_user_id, update_user_id', 'numerical', 'integerOnly'=>true),
			array('name, url', 'length', 'max'=>255),
			array('type', 'length', 'max'=>7),
			array('text, description, create_time, update_time', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, name, description, text, type, url, is_new_window, is_show_front, is_show_children, photo_id, priority, status_id, create_time, create_user_id, update_time, update_user_id', 'safe', 'on'=>'search'),
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
			'children' => array(
				self::HAS_MANY, 'Node', 'parent_id',
				'order'=>'priority'
			),
			'parent'=>array(
				self::BELONGS_TO, 'Node', 'parent_id',
				'select' => 'name'
			),
			'files' => array(
				self::MANY_MANY, 'File', 'tbl_file_node(node_id, file_id)',
			),
			'photos' => array(
				self::MANY_MANY, 'Photo', 'tbl_photo_node(node_id, photo_id)',
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
			'parent_id' => 'Родительский раздел',
			'name' => 'Название',
			'description' => 'Описание',
			'text' => 'Текст',
			'type' => 'Тип',
			'url' => '',
			'is_new_window' => 'Открывать в новом окне',
			'is_show_front' => 'Показывать раздел в главном меню',
			'is_show_children' => 'Выводить подразделы принудительно',
			'photo_id' => 'Изображение',
			'priority' => 'Приоритет',
			'status_id' => 'Статус',
			'create_time' => 'Дата создания',
			'create_user_id' => 'Автор',
			'update_time' => 'Дата изменения',
			'update_user_id' => 'Автор изменения',
		);
	}
	
	public function getName()
	{
		return $this->name;
	}
	
	public function getDesc()
	{
		$desc = "";
		if ($this->description != "") {
			$desc = $this->description;
			$desc = preg_replace('/<p.*?>/i', '', $desc);
			$desc = preg_replace('/<\/p.*?>/i', '', $desc);
			$desc = preg_replace('/<br*?$>/i', '', $desc);
		}

		return $desc;
	}

	public function getText()
	{
		$text = ($this->text !== "") ? $this->text : $this->description;
		
		$text = preg_replace('/<img(.*?)>/', '<img${1} style="border:1px solid #c8c5be; margin: 0px 5px 5px 5px;">', $text);
		$text = preg_replace('/<a(.*?)><img(.*?)>/i', '<a${1} rel="lightbox"><img${2}>', $text);
		$text = preg_replace('/<table(.*?border="1".*?)>/i', '<table${1} class="content">', $text);
		
		return $text;
	}

	public function getShowExpandedChildren()
	{
		if ($this->is_show_children || $this->getText() == "")
			return true;
		else
			return false;
	}
	
	public function getStatus()
	{
		return $status_id;
	}

	/*
	 * Returns a node url for Front part
	 */
	public function getFrontUrl($params)
	{
		if ($this->type == 'url')
			return CHtml::link($this->getName(), $this->linkPath,
				array_merge($params, array('target'=>'_blank')));
		else if ($this->type == 'link')
			return CHtml::link($this->getName(), Yii::app()->request->baseUrl."/".$this->url, $params);
		else
			return CHtml::link($this->getName(), array('site/section', 'id'=>$this->id),
				$params);
	}
	public function getFrontLink()
	{
		if ($this->type == 'url')return $this->linkPath;
		else if ($this->type == 'link') return Yii::app()->request->baseUrl."/".$this->url;
		else return Yii::app()->request->baseUrl.'/site/section?id='.$this->id;
	}
	

	public function getOpenedNodes()
	{
		$path = array();

		$node = $this;
		while (gettype($node) === 'object' && $node->id > 0) {
			$path[$node->id] = 1;
			if ($node->id == Node::$ROOT_ID)
				break;
			$node = Node::model()->findByPk($node->parent_id);
		}
		return $path;
	}

	public function setPriority()
	{
	    $criteria = new CDbCriteria();
	    $criteria->condition = "parent_id=:parent_id";
	    $criteria->params = array(':parent_id'=>$this->parent_id);
	    $criteria->order = "priority DESC";
	    $criteria->limit = 1;
	    $maxPriorityNode = Node::model()->find($criteria);

	    $this->priority = ($maxPriorityNode) ? $maxPriorityNode->priority + 1 : 1;
	}

	/*
	 * Returns all nodes as a tree
	 */
	public static function buildTree($id, $collapsed = false, $openedNodes = array())
	{
	    $nodes = Node::model()->findAll(
			array(
				'condition' => 'parent_id=:parent_id',
				'params' => array(':parent_id'=>$id),
				'order' => 'priority',
			)
	    );

	    $treeLevel = array();
	    foreach ($nodes as $node)
	    {
			$text = CHtml::link($node->getName(), array("node/index", "id"=>$node->id));

			if (isset($_GET['id']) && $_GET['id'] == $node->id)
				$text = "<strong>".$text."</strong>";
			$children = Node::model()->buildTree($node->id, $collapsed, $openedNodes);
			$params = array(
				'text' => $text,
				'children' => $children,
			);
			if ($collapsed)
				$params['expanded'] = false;
			if (isset($openedNodes[$node->id])) {
				$params['expanded'] = true;
			}
			array_push($treeLevel, $params);
	    }

	    return $treeLevel;
	}

	public static function getFormTree($root, $curId)
	{
	    $nodes = Node::model()->findAll(
			array(
				'condition' => 'parent_id=:parent_id and type="section" and id <> :curId',
				'params' => array(':parent_id'=>$root, ':curId'=> $curId),
				'order' => 'priority',
			)
	    );

	    $treeLevel = array();
	    foreach ($nodes as $node)
	    {
			$text = CHtml::link($node->getName(), 'javascript:void(0);', array(
				'onClick'=>'SetParentId('.$node->id.', "'.$node->getName().'")'));

			$children = Node::model()->getFormTree($node->id, $curId);
			$params = array(
				'text' => $text,
				'children' => $children,
			);
			array_push($treeLevel, $params);
	    }

	    return $treeLevel;
	}

	public static function decreaseSiblingsPriorities($parent_id, $priority)
	{
		$nodes = Node::model()->findAll(array(
			'condition' => 'parent_id=:parent_id and priority > :priority',
			'params' => array(
				':parent_id'=> $parent_id,
				':priority' => $priority,
			)
		));
		foreach ($nodes as $node) {
			$node->priority -= 1;
			$node->save();
		}
	}

	public static function getNavigation($nodeId)
	{
		$result = array();
		$node = Node::model()->findbyPk($nodeId);
		while (true)
		{
			array_unshift($result, $node->getFrontUrl(null));
			$node = Node::model()->findbyPk($node->parent_id);
			if ($node->id == Node::$ROOT_ID)
				break;
		}

		return $result;
	}

	public function getAdminNavigation($params = array())
	{
		$navigation = array();
		$id = $this->id;
		if ($this->isNewRecord)
			$id = $this->parent_id;
		$node = Node::model()->findbyPk($id);
		while ($node->id != Node::$ROOT_ID)
		{
			$navigation = array_merge(array($node->getName() => array_merge(array("node/index", "id"=>$node->id), $params)), $navigation);
			$node = Node::model()->findbyPk($node->parent_id);
		}
		$navigation = array_merge(array("Сайт"=>array_merge(array("node/index"), $params)),
			$navigation);

		return $navigation;
	}

	/*
	 * Set priorities of the subnodes in the current node
	 */
	public function setOrder($order = "alphabet")
	{
		$nodes = Node::model()->findAll(array(
			'condition'=>'parent_id=:parent_id',
			'params'=>array(':parent_id'=>$this->id),
			'order'=> ($order == "id" ? "id" : "name")." ASC",
		));

		$priority = 0;
		foreach ($nodes as $node) {
			$priority++;
			$node->priority = $priority;
			$node->save();
		}
	}
	
	public function getFileObjectType()
	{
		return "node";
	}

}
