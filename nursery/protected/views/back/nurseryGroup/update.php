<?php
$this->breadcrumbs=array(
	'МДОУ'=>array('nursery/index'),
	'Возрастные группы'=>array('index'),
	'Редактирование',
);

$this->menu=array(
	array('label'=>'List NurseryGroup', 'url'=>array('index')),
	array('label'=>'Create NurseryGroup', 'url'=>array('create')),
	array('label'=>'View NurseryGroup', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage NurseryGroup', 'url'=>array('admin')),
);
?>

<h1>Редактирование возрастной группы МДОУ ID <?php echo $model->nursery->id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>