<?php
$this->breadcrumbs=array(
	$model->getAdminNavigation(),
	"Создание раздела"
);

$this->menu=array(
	array('label'=>'List Node', 'url'=>array('index')),
	array('label'=>'Manage Node', 'url'=>array('admin')),
);
?>

<h1>Создание раздела</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>