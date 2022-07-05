<?php
$this->breadcrumbs=array(
	'Справочники'=>array('site/references'),
	'Причины выполнения операций'=>array('index'),
	'Добавление',
);

$this->menu=array(
	array('label'=>'List OperationReason', 'url'=>array('index')),
	array('label'=>'Manage OperationReason', 'url'=>array('admin')),
);
?>

<h1>Добавление причины выполнения операции</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>