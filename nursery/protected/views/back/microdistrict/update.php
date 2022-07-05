<?php
$this->breadcrumbs=array(
	'Справочники'=>array('site/references'),
	'Микрорайоны'=>array('index'),
	'Редактирование',
);

$this->menu=array(
	array('label'=>'List Microdistrict', 'url'=>array('index')),
	array('label'=>'Create Microdistrict', 'url'=>array('create')),
	array('label'=>'View Microdistrict', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage Microdistrict', 'url'=>array('admin')),
);
?>

<h1>Редактирование микрорайона ID <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>