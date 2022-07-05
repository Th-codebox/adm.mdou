<?php
$this->breadcrumbs=array(
	'Справочники'=>array('site/references'),
	'Типы документов'=>array('index'),
	'Добавление',
);

$this->menu=array(
	array('label'=>'List DocumentType', 'url'=>array('index')),
	array('label'=>'Manage DocumentType', 'url'=>array('admin')),
);
?>

<h1>Добавление типа документа</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>