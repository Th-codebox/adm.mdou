<?php
$this->breadcrumbs=array_merge(
	$photoObject->getAdminNavigation($this->getObjectParameters()),
	$model->getAdminNavigation($this->getParameters()),
	array("Создание фотографии")
);

?>

<h1>Добавление фотографии к '<?php echo $photoObject->getName();?>'</h1>

<?php echo $this->renderPartial('_form', array(
	'model'=>$model,
	'photoObject' => $photoObject,
)); ?>