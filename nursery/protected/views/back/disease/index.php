<?php
$this->breadcrumbs=array(
	'Справочники'=>array('site/references'),
	'Специализации',
);

$this->menu=array(
	array('label'=>'Create Disease', 'url'=>array('create')),
	array('label'=>'Manage Disease', 'url'=>array('admin')),
);
?>

<h1>Справочник специализаций</h1>

<?php echo CHtml::link('Добавить специализацию', array('disease/create')); ?>
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
            'value'=>'CHtml::link(CHtml::image(Yii::app()->request->baseUrl."/images/backend/page_white_edit.png"), array("disease/update", "id"=>$data->id))."&nbsp;".$data->getName()'
        ),
        array(
        	'name'=>'documents',
        	'type'=>'raw',
        	'value'=>'$data->getDocuments()'
        ),
		array(
			'class'=>'CButtonColumn',
			'deleteConfirmation'=>'Вы уверены, что хотите удалить элемент справочника?',
			'template'=>'{delete}',
		),
    ),
)); ?>
