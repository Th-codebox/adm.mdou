<?php
$this->breadcrumbs=array(
	'Очередь'=>array("request/admin"),
	'Заявления'=>isset(Yii::app()->user->returnUrl) ? Yii::app()->user->returnUrl : array('index'),
	'Редактирование заявления'
);

$this->menu=array(
	array('label'=>'List Request', 'url'=>array('index')),
	array('label'=>'Create Request', 'url'=>array('create')),
	array('label'=>'View Request', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage Request', 'url'=>array('admin')),
);
?>

<h1>Редактирование заявления ID <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>