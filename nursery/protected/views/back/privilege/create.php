<?php
$this->breadcrumbs=array(
	'Справочники'=>array('site/references'),
	'Льготы'=>array('index'),
	'Добавление',
);

$this->menu=array(
	array('label'=>'List Privilege', 'url'=>array('index')),
	array('label'=>'Manage Privilege', 'url'=>array('admin')),
);
?>

<h1>Добавление льготы</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>