<?php
$this->breadcrumbs=array(
	'Справочники'=>array('site/references'),
	'Специализации'=>array('index'),
	'Добавление',
);

$this->menu=array(
	array('label'=>'List Disease', 'url'=>array('index')),
	array('label'=>'Manage Disease', 'url'=>array('admin')),
);
?>

<h1>Добавление специализации</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>