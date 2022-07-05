<?php
$this->breadcrumbs=array(
	'Журнал операций',
);

$this->menu=array(
	array('label'=>'Create ActiveRecordLog', 'url'=>array('create')),
	array('label'=>'Manage ActiveRecordLog', 'url'=>array('admin')),
);
?>

<h1>Журнал операций</h1>

<?php $this->renderPartial('_filter', array());
?>

<?php $this->widget('zii.widgets.grid.CGridView', array(
    'dataProvider'=>$dataProvider,
    'ajaxUpdate'=>false,
	'template'=>'{summary} {pager} {items} {pager}',
    'summaryText'=>'Операции: {start} - {end} из {count}.',
    'columns'=>array(
        array(
            'name'=>'id',
        ),
        array(
            'name'=>'action',
        ),
        array(
            'name'=>'model',
            'type'=>'raw',
            'value'=>'$data->model."[".$data->model_id."]"'
        ),
        array(
        	'name'=>'field',
        ),
        array(
        	'name'=>'user',
        	'type'=>'raw',
        	'value'=>'$data->user->username'
        ),
        array(
        	'name'=>'create_time',
        ),
        array(
			'name'=>'description'
        ),
    ),
)); ?>
