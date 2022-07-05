<?php
$this->breadcrumbs=array(
	'Справочники'=>array('site/references'),
	'Микрорайоны'=>array('index'),
	'Добавление',
);

$this->menu=array(
	array('label'=>'List Microdistrict', 'url'=>array('index')),
	array('label'=>'Manage Microdistrict', 'url'=>array('admin')),
);
?>

<h1>Добавление микрорайона</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>