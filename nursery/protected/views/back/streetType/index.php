<?php
$this->breadcrumbs=array(
	'Справочники'=>array('site/references'),
	'Типы улиц',
);

$this->menu=array(
	array('label'=>'Create StreetType', 'url'=>array('create')),
	array('label'=>'Manage StreetType', 'url'=>array('admin')),
);
?>

<h1>Справочник типов улиц</h1>
<?php echo CHtml::link('Добавить тип улицы', array('street/create')); ?>
<?php $this->widget('zii.widgets.grid.CGridView', array(
    'dataProvider'=>$dataProvider,
	'summaryText'=>'',
    'columns'=>array(
        array(
            'name'=>'id',
        ),
        array(
            'name'=>'code',
        ),
        array(
            'name'=>'name',
            'type'=>'raw',
            'value'=>'CHtml::link(CHtml::image(Yii::app()->request->baseUrl."/images/backend/page_white_edit.png"), array("streetType/update", "id"=>$data->id))."&nbsp;".$data->getName()'
        ),
        array(
            'name'=>'short_name',
        ),
		array(
			'class'=>'CButtonColumn',
			'deleteConfirmation'=>'Вы уверены, что хотите удалить элемент справочника?',
			'template'=>'{delete}',
		),
    ),
)); ?>
