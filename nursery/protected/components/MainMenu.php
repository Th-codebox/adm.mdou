<?php

/**
 * MainMenu widget
 *
 * @author vlasov
 */
class MainMenu extends CWidget {
	public $frontpage = 0;
	
	public function run() {
        $mainMenu = Node::model()->findAll(array(
			'condition'=>'parent_id=:parent_id and status_id=1 and is_show_front=1',
			'params'=>array('parent_id'=>Node::$ROOT_ID),
			'order'=>'priority ASC',
		));
		
		$node = null;
		//$nodeId = $_GET['id'];
		//$controller = Yii::app()->controller->id;
        //$action = Yii::app()->controller->action->id;

		//if ($controller == "site" && $action == "news") {
		//	$newsNode = News::getNode();
		//	$nodeId = $newsNode->id;
		//}
		$month = Util::getRussianMonthName(date("n"));
		$today = date("j ").$month.date("  Y");
		
		if ($this->frontpage)
		{
	        $this->render('mainMenu_front', array(
    	    	'menu'=>$mainMenu, 
        		'node'=>$node)
	        );
	    }
	    else
	    {
	    	$this->render('mainMenu', array(
    	    	'menu'=>$mainMenu, 
        		'node'=>$node,
        		'today'=>$today)
	        );
	    }
    }
}
?>
