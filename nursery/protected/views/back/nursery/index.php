<?php
$this->breadcrumbs=array(
	'МДОУ',
);

$this->menu=array(
	array('label'=>'Create Nursery', 'url'=>array('create')),
	array('label'=>'Manage Nursery', 'url'=>array('admin')),
);
?>

<h1>Справочник МДОУ</h1>
<?php $this->renderPartial('_filter', array(
	'microdistricts'=>$microdistricts ,
	'diseases'=>$diseases,
));?>

<?php echo CHtml::link('Добавить МДОУ', array('nursery/create')); ?>
<?php $this->widget('zii.widgets.grid.CGridView', array(
    'dataProvider'=>$dataProvider,
    'ajaxUpdate'=>false,
	'template'=>'{summary} {pager} {items} {pager}',
    'summaryText'=>'МДОУ: {start} - {end} из {count}.',
    'columns'=>array(
        array(
            'name'=>'id',
        ),
        array(
            'name'=>'short_name',
        ),
        array(
            'name'=>'name',
            'type'=>'raw',
            'value'=>'CHtml::link(CHtml::image(Yii::app()->request->baseUrl."/images/backend/page_white_edit.png"), array("nursery/update", "id"=>$data->id))."&nbsp;".$data->getName()'
        ),
        array(
            'name'=>'microdistrict_id',
            'type'=>'raw',
            'value'=>'isset($data->microdistrict) ? $data->microdistrict->getName() : ""'
        ),
        array(
            'name'=>'address',
            'type'=>'raw',
			'value'=>'CHtml::link(CHtml::encode($data->getAddress()), "http://maps.yandex.ru/?text=Петрозаводск, ".$data->getAddress(), array("target"=>"_blank"))'
        ),
        array(
            'name'=>'head',
            'type'=>'raw',
            'value'=>'(!empty($data->head)) ? $data->head->getName(): ""'
        ),
        array(
            'name'=>'phone',
            'type'=>'raw',
            'value'=>'$data->phone'
        ),
        array(
            'name'=>'place_number',
            'type'=>'raw',
            'value'=>'$data->place_number',
        ),
        array(
            'name'=>'groups',
            'type'=>'raw',
            'value'=>'CHtml::link(count($data->groups), array("nurseryGroup/index", "nid"=>$data->id))',
        ),
        array(
            'name'=>'diseases',
            'type'=>'raw',
            'value'=>'CHtml::link(count($data->diseases), "?r=nursery/update&id=".$data->id."#tab5")',
        ),
    ),
)); ?>
