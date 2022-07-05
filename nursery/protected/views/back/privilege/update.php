<?php
$this->breadcrumbs=array(
	'Справочники'=>array('site/references'),
	'Льготы'=>array('index'),
	'Редактирование',
);

$this->menu=array(
	array('label'=>'List Privilege', 'url'=>array('index')),
	array('label'=>'Create Privilege', 'url'=>array('create')),
	array('label'=>'View Privilege', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage Privilege', 'url'=>array('admin')),
);
?>

<h1>Редактирование льготы ID <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>