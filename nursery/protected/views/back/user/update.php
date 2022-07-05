<?php
$this->breadcrumbs=array(
	'Пользователи'=>isset(Yii::app()->user->returnUrl) ? Yii::app()->user->returnUrl : array('index'),
	'Редактирование',
);

$this->menu=array(
	array('label'=>'List User', 'url'=>array('index')),
	array('label'=>'Create User', 'url'=>array('create')),
	array('label'=>'View User', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage User', 'url'=>array('admin')),
);
?>

<h1>Редактирование пользователя ID <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>