<?php
$this->breadcrumbs=array(
	'Справочники'=>array('site/references'),
	'Типы возрастных групп'=>array('index'),
	'Добавление',
);

$this->menu=array(
	array('label'=>'List GroupType', 'url'=>array('index')),
	array('label'=>'Manage GroupType', 'url'=>array('admin')),
);
?>

<h1>Создание типа возрастной группы</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>