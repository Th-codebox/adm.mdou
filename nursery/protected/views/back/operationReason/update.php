<?php
$this->breadcrumbs=array(
	'Справочники'=>array('site/references'),
	'Причины выполнения операций'=>array('index'),
	'Редактирование',
);

$this->menu=array(
	array('label'=>'List OperationReason', 'url'=>array('index')),
	array('label'=>'Create OperationReason', 'url'=>array('create')),
	array('label'=>'View OperationReason', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage OperationReason', 'url'=>array('admin')),
);
?>

<h1>Редактирование причины выполнения операции ID <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>