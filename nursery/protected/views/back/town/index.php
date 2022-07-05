<?php
$this->breadcrumbs=array(
	'Справочники'=>array('site/references'),
	'Населенные пункты',
);

$this->menu=array(
	array('label'=>'Create Town', 'url'=>array('create')),
	array('label'=>'Manage Town', 'url'=>array('admin')),
);
?>

<h1>Справочник населенных пунктов</h1>

<?php echo CHtml::link('Добавить населенный пункт', array('town/create')); ?>
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
            'value'=>'CHtml::link(CHtml::image(Yii::app()->request->baseUrl."/images/backend/page_white_edit.png"), array("town/update", "id"=>$data->id))."&nbsp;".$data->getName()'
        ),
		array(
			'class'=>'CButtonColumn',
			'deleteConfirmation'=>'Вы уверены, что хотите удалить элемент справочника?',
			'updateButtonImageUrl'=>Yii::app()->request->baseUrl.'/images/backend/page_white_edit.png',
			'template'=>'{update} {delete}',
		),
    ),
)); ?>
