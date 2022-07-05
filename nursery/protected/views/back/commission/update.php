<?php
$this->breadcrumbs=array(
	'Справочники'=>array('site/references'),
	'Комиссия'=>array('index'),
	'Редактирование',
);

$this->menu=array(
	array('label'=>'List Commission', 'url'=>array('index')),
	array('label'=>'Create Commission', 'url'=>array('create')),
	array('label'=>'View Commission', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage Commission', 'url'=>array('admin')),
);
?>

<h1>Редактирование члена комиссии ID <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>