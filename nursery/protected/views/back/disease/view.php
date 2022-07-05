<?php
$this->breadcrumbs=array(
	'Diseases'=>array('index'),
	$model->name,
);

$this->menu=array(
	array('label'=>'List Disease', 'url'=>array('index')),
	array('label'=>'Create Disease', 'url'=>array('create')),
	array('label'=>'Update Disease', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete Disease', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Disease', 'url'=>array('admin')),
);
?>

<h1>View Disease #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'name',
		'create_time',
		'create_user_id',
		'update_time',
		'update_user_id',
	),
)); ?>
