<?php
$this->breadcrumbs=array(
	'Справочники'=>array('site/references'),
	'Типы возрастных групп',
);

$this->menu=array(
	array('label'=>'Create GroupType', 'url'=>array('create')),
	array('label'=>'Manage GroupType', 'url'=>array('admin')),
);
?>

<h1>Справочник типов возрастных групп</h1>
<?php echo CHtml::link('Добавить тип группы', array('groupType/create')); ?>
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
            'value'=>'CHtml::link(CHtml::image(Yii::app()->request->baseUrl."/images/backend/page_white_edit.png"), array("groupType/update", "id"=>$data->id))."&nbsp;".$data->getName()'
        ),
        array(
            'name'=>'age_months_from',
            'type'=>'raw',
            'value'=>'$data->getAgeFrom()'
        ),
        array(
            'name'=>'age_months_to',
            'type'=>'raw',
            'value'=>'$data->getAgeTo()'
        ),
		array(
			'class'=>'CButtonColumn',
			'deleteConfirmation'=>'Вы уверены, что хотите удалить элемент справочника?',
			'template'=>'{delete}',
		),
    ),
)); ?>
