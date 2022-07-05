<?php
$this->breadcrumbs=array(
	'Справочники'=>array('site/references'),
	'Улицы'=>array('index'),
	'Редактирование',
);

$this->menu=array(
	array('label'=>'List Street', 'url'=>array('index')),
	array('label'=>'Create Street', 'url'=>array('create')),
	array('label'=>'View Street', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage Street', 'url'=>array('admin')),
);
?>

<h1>Редактирование улицы ID <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>