<?php
$this->breadcrumbs=array(
	'Справочники'=>array('site/references'),
	'Комиссия',
);

$this->menu=array(
	array('label'=>'Create Commission', 'url'=>array('create')),
	array('label'=>'Manage Commission', 'url'=>array('admin')),
);
?>

<h1>Члены комиссии</h1>

<?php echo CHtml::link('Добавить члена комиссии', array('commission/create')); ?>
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
            'value'=>'CHtml::link(CHtml::image(Yii::app()->request->baseUrl."/images/backend/page_white_edit.png"), array("commission/update", "id"=>$data->id))."&nbsp;".$data->getFullName()
				.($data->is_head ? " (председатель)" : "")'
        ),
        array(
        	'name'=>'post',
        	'type'=>'raw',
        	'value'=>'$data->post',
        ),
        array(
        	'name'=>'phone'
        ),
		array(
			'type'=>'image',
			'value'=>'"images/backend/".($data->is_active==0?"notactive":"active").".gif"',
		),
		array(
			'class'=>'CButtonColumn',
			'deleteConfirmation'=>'Вы уверены, что хотите удалить элемент справочника?',
			'template'=>'{delete}',
		),
    ),
)); ?>
