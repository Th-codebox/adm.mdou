<?php
$this->breadcrumbs=array(
	'Справочники'=>array('site/references'),
	'Комиссия'=>array('index'),
	'Добавление',
);

$this->menu=array(
	array('label'=>'List Commission', 'url'=>array('index')),
	array('label'=>'Manage Commission', 'url'=>array('admin')),
);
?>

<h1>Добавление члена комиссии</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>