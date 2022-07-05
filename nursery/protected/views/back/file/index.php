<?php
$this->breadcrumbs=array_merge(
	$fileObject->getAdminNavigation($this->getObjectParameters()),
	array('Файлы')
);

?>

<h1>Список файлов для '<?php echo $fileObject->getName();?>'</h1>
<?php echo CHtml::link('Добавить файл',
		array('file/create', 'object'=>$fileObject->getFileObjectType(), 'object_id'=>$fileObject->id));
?>

<?php $this->widget('zii.widgets.grid.CGridView', array(
    'dataProvider'=>$dataProvider,
	'summaryText'=>'',
    'columns'=>array(
        array(
            'name'=>'name',
            'type'=>'raw',
            'value'=>'CHtml::link(CHtml::encode($data->getName()), $data->http_path)."<br/>".$data->http_path'
        ),
        array(
            'name'=>'mimeType',
            'type'=>'raw',
            'value'=>'$data->mime_type'
        ),
		array(
			'name'=>'extension',
			'filter'=>false,
			'value' => '$data->extension',
		),
        array(
            'name'=>'size',
            'filter'=>false,
			'value'=>'$data->getSize()',
        ),
        array(
			'class'=>'CButtonColumn',
			'deleteConfirmation'=>'Вы уверены, что хотите удалить файл?',
			'template'=>'{update} {delete}',
			'updateButtonUrl'=>'Yii::app()->controller->createUrl("file/update", array_merge(array("id"=>$data->id, "object"=>"'.$fileObject->getFileObjectType().'", "object_id"=>"'.$fileObject->id.'"), $_GET))',
			'deleteButtonUrl'=>'Yii::app()->controller->createUrl("file/delete", array_merge(array("id"=>$data->id, "object"=>"'.$fileObject->getFileObjectType().'", "object_id"=>"'.$fileObject->id.'"), $_GET))',
        ),
    ),
)); ?>
