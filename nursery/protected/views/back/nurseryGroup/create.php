<?php
$this->breadcrumbs=array(
	'МДОУ'=>array('nursery/index'),
	'Возрастные группы'=>array('index', 'nid'=>$model->nursery->id),
	'Добавление',
);

$this->menu=array(
	array('label'=>'List NurseryGroup', 'url'=>array('index')),
	array('label'=>'Manage NurseryGroup', 'url'=>array('admin')),
);
?>

<h1>Добавление возрастной группы</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>