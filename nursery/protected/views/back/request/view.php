<?php
$this->breadcrumbs=array(
	'Requests'=>array('index'),
	$model->name,
);

$this->menu=array(
	array('label'=>'List Request', 'url'=>array('index')),
	array('label'=>'Create Request', 'url'=>array('create')),
	array('label'=>'Update Request', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete Request', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Request', 'url'=>array('admin')),
);
?>

<h1>Просмотр заявления #<?php echo $model->id; ?></h1>
<?php $this->renderPartial('_viewdetails', array('model'=>$model));?>