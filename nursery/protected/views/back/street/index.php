<?php
$this->breadcrumbs=array(
	'Справочники'=>array('site/references'),
	'Улицы',
);

$this->menu=array(
	array('label'=>'Create Street', 'url'=>array('create')),
	array('label'=>'Manage Street', 'url'=>array('admin')),
);
?>

<h1>Справочник улиц</h1>
<?php $this->renderPartial('_filter', array(
	'types'=>$types,
	'microdistricts'=>$microdistricts,
));?>

<?php $this->widget('zii.widgets.grid.CGridView', array(
    'dataProvider'=>$dataProvider,
	'template'=>'{summary}<table width="100%"><tr><td>'.CHtml::link('Добавить улицу', array('street/create')).'</td><td>{pager}</td></tr></table> {items} {pager}',
    'columns'=>array(
        array(
            'name'=>'id',
        ),
        array(
            'name'=>'code',
        ),
        array(
            'name'=>'ext_code',
        ),
        array(
            'name'=>'name',
            'type'=>'raw',
            'value'=>'CHtml::link(CHtml::image(Yii::app()->request->baseUrl."/images/backend/page_white_edit.png"), array("street/update", "id"=>$data->id))."&nbsp;".CHtml::link(CHtml::encode($data->getName()), "http://maps.yandex.ru/?text=Петрозаводск, ".$data->getName(), array("target"=>"_blank"))'
        ),
        array(
        	'name'=>'microdistrict',
        	'type'=>'raw',
        	'value'=>'$data->getMicrodistricts()'
        ),
		array(
			'class'=>'CButtonColumn',
			'deleteConfirmation'=>'Вы уверены, что хотите удалить элемент справочника?',
			'template'=>'{delete}',
		),
    ),
)); ?>
