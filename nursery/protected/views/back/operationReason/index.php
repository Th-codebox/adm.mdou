<?php
$this->breadcrumbs=array(
	'Справочники'=>array('site/references'),
	'Причины выполнения операций',
);

$this->menu=array(
	array('label'=>'Create OperationReason', 'url'=>array('create')),
	array('label'=>'Manage OperationReason', 'url'=>array('admin')),
);
?>

<h1>Справочник причин выполнения операций</h1>
<?php echo CHtml::link('Добавить причину', array('operationReason/create')); ?>
<?php $this->widget('zii.widgets.grid.CGridView', array(
    'dataProvider'=>$dataProvider,
	'summaryText'=>'',
    'columns'=>array(
        array(
            'name'=>'id',
        ),
        array(
            'name'=>'name',
            'type'=>'raw',
            'value'=>'CHtml::link(CHtml::image(Yii::app()->request->baseUrl."/images/backend/page_white_edit.png"), array("operationReason/update", "id"=>$data->id))."&nbsp;".$data->getName()'
        ),
        array(
            'name'=>'operations',
            'type'=>'raw',
            'value'=>'$data->getOperationNames()',
        ),
		array(
			'class'=>'CButtonColumn',
			'deleteConfirmation'=>'Вы уверены, что хотите удалить элемент справочника?',
			'template'=>'{delete}',
		),
    ),
)); ?>
