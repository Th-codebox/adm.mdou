<?php
$this->breadcrumbs=array(
	'Справочники'=>array('site/references'),
	'Микрорайоны',
);

$this->menu=array(
	array('label'=>'Create Microdistrict', 'url'=>array('create')),
	array('label'=>'Manage Microdistrict', 'url'=>array('admin')),
);
?>

<h1>Справочник микрорайонов</h1>
<?php echo CHtml::link('Добавить микрорайон', array('microdistrict/create')); ?>
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
			'value'=>'CHtml::link(CHtml::image(Yii::app()->request->baseUrl."/images/backend/page_white_edit.png"), array("microdistrict/update", "id"=>$data->id))."&nbsp;".CHtml::link(CHtml::encode($data->getName()), "http://maps.yandex.ru/?text=Петрозаводск, район ".$data->getName(), array("target"=>"_blank"))'
        ),
        array(
            'name'=>'town_id',
            'type'=>'raw',
            'value'=>'isset($data->town) ? $data->town->getName() : ""',
        ),
        array(
        	'name'=>'streets',
        	'type'=>'raw',
        	'value'=>'CHtml::link(count($data->streets), array("street/index", "Street_microdistrict"=>$data->id))',
        ),
		array(
			'class'=>'CButtonColumn',
			'deleteConfirmation'=>'Вы уверены, что хотите удалить элемент справочника?',
			'template'=>'{delete}',
		),
    ),
)); ?>
