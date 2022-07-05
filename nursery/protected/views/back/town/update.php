<?php
$this->breadcrumbs=array(
	'Справочники'=>array('site/references'),
	'Населенные пункты'=>array('index'),
	'Редактирование',
);

$this->menu=array(
	array('label'=>'List Town', 'url'=>array('index')),
	array('label'=>'Create Town', 'url'=>array('create')),
	array('label'=>'View Town', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage Town', 'url'=>array('admin')),
);
?>

<h1>Редактирование населенного пункта ID <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>