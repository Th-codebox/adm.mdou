<?php
$this->breadcrumbs=array(
	'Пользователи'=>isset(Yii::app()->user->returnUrl) ? Yii::app()->user->returnUrl : array('index'),
	'Добавление',
);

$this->menu=array(
	array('label'=>'List User', 'url'=>array('index')),
	array('label'=>'Manage User', 'url'=>array('admin')),
);
?>

<h1>Добавление пользователя</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>