<?php
$this->breadcrumbs=array(
	'Справочники'=>array('site/references'),
	'Типы улиц'=>array('index'),
	'Редактирование',
);

$this->menu=array(
	array('label'=>'List StreetType', 'url'=>array('index')),
	array('label'=>'Create StreetType', 'url'=>array('create')),
	array('label'=>'View StreetType', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage StreetType', 'url'=>array('admin')),
);
?>

<h1>Редактирование типа улиц ID <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>