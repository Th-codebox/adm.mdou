<?php
$this->breadcrumbs=array(
	'МДОУ'=>array('nursery/index'),
	'Возрастные группы',
);

$this->menu=array(
	array('label'=>'Create NurseryGroup', 'url'=>array('create')),
	array('label'=>'Manage NurseryGroup', 'url'=>array('admin')),
);
?>

<h1>Возрастные группы для <?php echo $this->getNursery()->getName(); ?></h1>

<?php echo CHtml::link('Добавить возрастную группу', array('nurseryGroup/create', 'nid'=>$this->getNursery()->id)); ?>
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
            'value'=>'CHtml::link(CHtml::image(Yii::app()->request->baseUrl."/images/backend/page_white_edit.png"), array("nurseryGroup/update", "id"=>$data->id, "nid"=>$data->nursery_id))."&nbsp;".$data->getName()'
        ),
        array(
        	'name'=>'group_id',
        	'type'=>'raw',
        	'value'=>'$data->group->getName()'        
        ),
        array(
        	'name'=>'disease_id',
        	'type'=>'raw',
        	'value'=>'isset($data->disease) ? $data->disease->getName() : "&nbsp;";',
        ),
        array(
        	'name'=>'free_places',
        ),
        array(
        	'name'=>'total_places',
        ),
		array(
			'class'=>'CButtonColumn',
			'deleteConfirmation'=>'Вы уверены, что хотите удалить элемент справочника?',
			'template'=>'{delete}',
		),
    ),
)); ?>
