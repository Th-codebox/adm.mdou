<?php
$this->breadcrumbs=array(
	'МДОУ'=>isset(Yii::app()->user->returnUrl) ? Yii::app()->user->returnUrl : array('index'),
	'Редактирование',
);

$this->menu=array(
	array('label'=>'List Nursery', 'url'=>array('index')),
	array('label'=>'Create Nursery', 'url'=>array('create')),
	array('label'=>'View Nursery', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage Nursery', 'url'=>array('admin')),
);
?>

<h1>Редактирование МДОУ</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>