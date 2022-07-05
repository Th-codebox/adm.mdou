<?php
$this->breadcrumbs=array(
	'МДОУ'=>isset(Yii::app()->user->returnUrl) ? Yii::app()->user->returnUrl : array('index'),
	'Добавление',
);

$this->menu=array(
	array('label'=>'List Nursery', 'url'=>array('index')),
	array('label'=>'Manage Nursery', 'url'=>array('admin')),
);
?>

<h1>Добавление МДОУ</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>