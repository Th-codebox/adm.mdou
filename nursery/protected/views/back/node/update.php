<?php
$this->breadcrumbs=array_merge(
	$model->getAdminNavigation(),
	array("Редактирование раздела")
);

$this->menu=array(
	array('label'=>'List Node', 'url'=>array('index')),
	array('label'=>'Create Node', 'url'=>array('create')),
	array('label'=>'View Node', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage Node', 'url'=>array('admin')),
);
?>

<h1>Редактирование раздела <?php echo $model->getName(); ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>

