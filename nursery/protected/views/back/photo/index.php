<?php
$this->breadcrumbs=array_merge(
	$photoObject->getAdminNavigation($this->getObjectParameters()),
	array('Фотографии')
);

?>

<h1>Список фотографий для '<?php echo $photoObject->getName();?>'</h1>
<?php echo CHtml::link('Добавить фотографию',
		array('photo/create', 'object'=>$photoObject->getFileObjectType(), 'object_id'=>$photoObject->id));
?>

<?php $this->widget('zii.widgets.grid.CGridView', array(
    'dataProvider'=>$dataProvider,
	'summaryText'=>'',
    'columns'=>array(
		array(
			'name'=>'Изображение',
			'type'=>'raw',
			'value'=>'CHtml::link($data->getThumbImage(), $data->getHttpPath(), array("rel"=>"lightbox", "title"=>$data->getName()))',
			'htmlOptions'=>array('width'=>'120px;'),
		),
        array(
            'name'=>'name',
            'type'=>'raw',
            'value'=>'"<b>".CHtml::encode($data->getName())."</b><br/>".$data->getHttpPath()." (".$data->getFileSize().")"'
        ),
        array(
            'name'=>'mime_type',
            'type'=>'raw',
            'value'=>'$data->getMimeType()'
        ),
		array(
			'name'=>'width',
			'filter'=>false,
			'value' => '$data->width',
		),
		array(
			'name'=>'height',
			'filter'=>false,
			'value' => '$data->height',
		),
        array(
			'class'=>'CButtonColumn',
			'deleteConfirmation'=>'Вы уверены, что хотите удалить фотографию?',
			'template'=>'{update} {delete}',
			'updateButtonUrl'=>'Yii::app()->controller->createUrl("photo/update", array_merge(array("id"=>$data->id, "object"=>"'.$photoObject->getFileObjectType().'", "object_id"=>"'.$photoObject->id.'"), $_GET))',
			'deleteButtonUrl'=>'Yii::app()->controller->createUrl("photo/delete", array_merge(array("id"=>$data->id, "object"=>"'.$photoObject->getFileObjectType().'", "object_id"=>"'.$photoObject->id.'"), $_GET))',
        ),
    ),
)); ?>
