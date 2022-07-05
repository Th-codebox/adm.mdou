<?php
$this->breadcrumbs=array(
	'Очередь'=>array("request/admin"),
	'Заявления'=>isset(Yii::app()->user->returnUrl) ? Yii::app()->user->returnUrl : array('index'),
	'Новое заявление',
);

$this->menu=array(
	array('label'=>'List Request', 'url'=>array('index')),
	array('label'=>'Manage Request', 'url'=>array('admin')),
);
?>

<h1>Новое заявление</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>