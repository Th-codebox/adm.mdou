<?php
$this->breadcrumbs=array(
	'Справочники'=>array('site/references'),
	'Типы улиц'=>array('index'),
	'Добавление',
);

$this->menu=array(
	array('label'=>'List StreetType', 'url'=>array('index')),
	array('label'=>'Manage StreetType', 'url'=>array('admin')),
);
?>

<h1>Добавление типа улиц</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>