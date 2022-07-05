<?php
$this->breadcrumbs=array(
	'Справочники'=>array('site/references'),
	'Типы документов'=>array('index'),
	'Редактирование',
);

$this->menu=array(
	array('label'=>'List DocumentType', 'url'=>array('index')),
	array('label'=>'Create DocumentType', 'url'=>array('create')),
	array('label'=>'View DocumentType', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage DocumentType', 'url'=>array('admin')),
);
?>

<h1>Редактирование типа документа ID <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>