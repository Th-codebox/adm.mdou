<?php
$this->breadcrumbs=array_merge(
	$photoObject->getAdminNavigation($this->getObjectParameters()),
	$model->getAdminNavigation($this->getParameters())
);

?>

<h1>Редактирование фотографии '<?php echo $model->getName(); ?>'</h1>

<?php echo $this->renderPartial('_form', array(
	'model'=>$model,
	'photoObject' => $photoObject,
)); ?>