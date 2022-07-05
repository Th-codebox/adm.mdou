<?php
$this->breadcrumbs=array(
	'Справочники'=>array('site/references'),
	'Льготы',
);

$this->menu=array(
	array('label'=>'Create Privilege', 'url'=>array('create')),
	array('label'=>'Manage Privilege', 'url'=>array('admin')),
);
?>

<h1>Список льгот</h1>

<?php $this->widget('zii.widgets.grid.CGridView', array(
    'dataProvider'=>$dataProvider,
	'template'=>'{summary}<table width="100%"><tr><td>'.CHtml::link('Добавить льготу', array('privilege/create')).'</td><td>{pager}</td></tr></table> {items} {pager}',
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
            'value'=>'CHtml::link(CHtml::image(Yii::app()->request->baseUrl."/images/backend/page_white_edit.png"), array("privilege/update", "id"=>$data->id))."&nbsp;".$data->getName()'
        ),
        array(
        	'name'=>'description',
        	'type'=>'raw',
        	'value'=>'$data->getShortDescription()'
        ),
        array(
        	'name'=>'documents',
        	'type'=>'raw',
        	'value'=>'$data->getDocuments()'
        ),
        array(
        	'name'=>'out_of_queue',
        	'type'=>'raw',
        	'value'=>'$data->out_of_queue ? "да" : "нет"'
        ),
        array(
        	'name'=>'is_active',
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
