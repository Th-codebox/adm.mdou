<?php
$this->breadcrumbs=array(
	'Nurseries'=>array('index'),
	$model->name,
);

$this->menu=array(
	array('label'=>'List Nursery', 'url'=>array('index')),
	array('label'=>'Create Nursery', 'url'=>array('create')),
	array('label'=>'Update Nursery', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete Nursery', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Nursery', 'url'=>array('admin')),
);
?>

<h1>View Nursery #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'code',
		'name',
		'short_name',
		'town_id',
		'microdistrict_id',
		'street_id',
		'house',
		'building',
		'phone',
		'place_number',
		'create_time',
		'create_user_id',
		'update_time',
		'update_user_id',
	),
)); ?>
