<?php
$this->breadcrumbs=array(
	'Справочники'=>array('site/references'),
	'Населенные пункты'=>array('index'),
	'Добавление',
);

$this->menu=array(
	array('label'=>'List Town', 'url'=>array('index')),
	array('label'=>'Manage Town', 'url'=>array('admin')),
);
?>

<h1>Добавление населенного пункта</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>