<?php
$this->breadcrumbs=array(
	'Справочники'=>array('site/references'),
	'Типы возрастных групп'=>array('index'),
	'Редактирование',
);

$this->menu=array(
	array('label'=>'List GroupType', 'url'=>array('index')),
	array('label'=>'Create GroupType', 'url'=>array('create')),
	array('label'=>'View GroupType', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage GroupType', 'url'=>array('admin')),
);
?>

<h1>Редактирование типа возрастной группы ID <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>