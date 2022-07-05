<?php
$this->breadcrumbs=array(
	'Очередь'=>array("request/admin"),
	'Заявления'=>isset(Yii::app()->user->returnUrl) ? Yii::app()->user->returnUrl : array('index'),
	$model->id=>array('request/update', 'id'=>$model->id),
	'Доступные операции'
);

$this->menu=array(
	array('label'=>'List Request', 'url'=>array('index')),
	array('label'=>'Create Request', 'url'=>array('create')),
	array('label'=>'Update Request', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete Request', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Request', 'url'=>array('admin')),
);
?>

<?php if (!$model->isNewRecord): ?>
	<?php $this->renderPartial('_summaryform', array('model'=>$model)); ?>
	<hr>
<?php endif; ?>

<h1>Список доступных операций для заявления #<?php echo $model->id; ?></h1>
<?php if(Yii::app()->user->hasFlash('requestoperation')): ?>
	<div class="flash_info">
		<b><?php echo Yii::app()->user->getFlash('requestoperation'); ?></b><br/><br/>
	</div>
	<br/><br/>
<?php endif; ?>

<?php echo CHtml::errorSummary($model, 'Необходимо исправить следующие ошибки:'); ?>
<?php $this->renderPartial('_operation', array('model'=>$model));?>

<hr>

<h2>История операций</h2>
<?php $this->renderPartial('tabs/_operationLog', array('model'=>$model)); ?>