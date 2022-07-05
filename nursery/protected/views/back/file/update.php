<?php
$this->breadcrumbs=array_merge(
	$fileObject->getAdminNavigation($this->getObjectParameters()),
	$model->getAdminNavigation($this->getParameters())
);

?>

<h1>Редактирование файла '<?php echo $model->getName(); ?>'</h1>

<?php echo $this->renderPartial('_form', array(
	'model'=>$model,
	'fileObject'=>$fileObject,
));
?>