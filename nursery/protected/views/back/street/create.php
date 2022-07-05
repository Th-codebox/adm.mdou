<?php
$this->breadcrumbs=array(
	'Справочники'=>array('site/references'),
	'Улицы'=>array('index'),
	'Добавление',
);

$this->menu=array(
	array('label'=>'List Street', 'url'=>array('index')),
	array('label'=>'Manage Street', 'url'=>array('admin')),
);
?>

<h1>Добавление улицы</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>