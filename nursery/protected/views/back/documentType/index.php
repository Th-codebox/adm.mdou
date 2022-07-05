<?php
$this->breadcrumbs=array(
	'Справочники'=>array('site/references'),
	'Типы документов',
);

$this->menu=array(
	array('label'=>'Create DocumentType', 'url'=>array('create')),
	array('label'=>'Manage DocumentType', 'url'=>array('admin')),
);
?>

<h1>Справочник типов документов</h1>

<?php echo CHtml::link('Добавить тип документа', array('documentType/create')); ?>
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
            'value'=>'CHtml::link(CHtml::image(Yii::app()->request->baseUrl."/images/backend/page_white_edit.png"), array("documentType/update", "id"=>$data->id))."&nbsp;".$data->getName()'
        ),
        array(
        	'name'=>'type',
        	'type'=>'raw',
        	'value'=>'$data->getTypeName()',
        ),
		array(
			'class'=>'CButtonColumn',
			'deleteConfirmation'=>'Вы уверены, что хотите удалить элемент справочника?',
			'template'=>'{delete}',
		),
    ),
)); ?>
