<?php
$this->breadcrumbs=array(
	'Справочники'=>array('site/references'),
	'Специализации'=>array('index'),
	'Редактирование'
);

$this->menu=array(
	array('label'=>'List Disease', 'url'=>array('index')),
	array('label'=>'Create Disease', 'url'=>array('create')),
	array('label'=>'View Disease', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage Disease', 'url'=>array('admin')),
);
?>

<h1>Редактирование специализации ID <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>