<?php
$this->breadcrumbs=array_merge(
	$fileObject->getAdminNavigation($this->getObjectParameters()),
	$model->getAdminNavigation($this->getParameters()),
	array("Создание файла")
);

?>

<h1>Создание файла для '<?php echo $fileObject->getName();?>'</h1>

<?php echo $this->renderPartial('_form', array(
	'model'=>$model,
	'fileObject'=>$fileObject
));
?>