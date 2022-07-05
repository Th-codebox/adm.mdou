<?php
$this->breadcrumbs=array(
	'Microdistricts'=>array('index'),
	$model->name,
);

$this->menu=array(
	array('label'=>'List Microdistrict', 'url'=>array('index')),
	array('label'=>'Create Microdistrict', 'url'=>array('create')),
	array('label'=>'Update Microdistrict', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete Microdistrict', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Microdistrict', 'url'=>array('admin')),
);
?>

<h1>View Microdistrict #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'code',
		'name',
		'create_time',
		'create_user_id',
		'update_time',
		'update_user_id',
	),
)); ?>
