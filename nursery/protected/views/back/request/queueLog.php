<?php
$this->breadcrumbs=array(
	'Очередь'=>array("request/admin"),
	'Заявления'=>isset(Yii::app()->user->returnUrl) ? Yii::app()->user->returnUrl : array('index'),
	$model->id=>array('request/update', 'id'=>$model->id),
	'История изменения номера очереди'
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

<h1>История изменения номера очереди заявления #<?php echo $model->id; ?></h1>
<?php $this->widget('zii.widgets.grid.CGridView', array(
    'dataProvider'=>$dataProvider,
    'ajaxUpdate'=>true,
	'template'=>'{summary} {pager} {items} {pager}',
    'summaryText'=>'Записи: {start} - {end} из {count}.',
    'columns'=>array(
        array(
            'name'=>'queue_number',
            'type'=>'raw',
            'value'=>'$data->getQueueNumber()',
        ),
        array(
        	'name'=>'create_time',
        	'type'=>'raw',
        	'value'=> '$data->getCreateTime()'
		),
		array(
			'name'=>'type',
			'type'=>'raw',
			'value'=>'$data->getTypeName()'
		),
    ),
)); ?>
