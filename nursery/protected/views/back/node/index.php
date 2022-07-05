<?php
$this->breadcrumbs= $node->getAdminNavigation();

?>

<table border="0" width="100%" valign="top">
<tr>
    <td width="35%" valign="top">
    	<div id="tree" style="vertical-align: top;">
		<?php $this->widget('CTreeView',
			array(
				'data' => $tree,
				'htmlOptions' => array('style'=>'vertical-align:top;'),
				'persist' => 'location',
				'collapsed'=>true,
		));	?>
		</div>
    </td>
    <td width="1%" valign="top"><hr style="height: 600px; width:1px;"></td>
    <td valign="top">
	<h2>Содержимое раздела "<?php echo $node->getName(); ?>"</h2>
	<?php echo CHtml::link('Добавить подраздел', array('node/create', 'parent_id'=>$node->id)); ?>
	| Упорядочить разделы по
	(<?php echo CHtml::link('алфавиту', array('node/setOrderAlphabet', 'id'=>$node->id),
		array('onClick'=>'return confirm("Вы уверены, что хотите изменить порядок разделов?");')); ?>
	/ <?php echo CHtml::link('id', array('node/setOrderId', 'id'=>$node->id),
		array('onClick'=>'return confirm("Вы уверены, что хотите изменить порядок разделов?");')); ?>)

	<?php $this->widget('zii.widgets.grid.CGridView', array(
		'dataProvider'=>$childrenDataProvider,
		'summaryText'=>'',
		'emptyText'=>'Не найдено ни одного раздела',
		'enableSorting'=>false,
		'enablePagination'=>false,
		'columns'=>array(
			array(
				'type'=>'html',
				'value'=>'CHtml::link(CHtml::image(Yii::app()->request->baseUrl."/images/backend/up.gif"), array("node/up", "id"=>$data->id))."&nbsp;".CHtml::link(CHtml::image(Yii::app()->request->baseUrl."/images/backend/down.gif"), array("node/down", "id"=>$data->id))',
				'htmlOptions'=>array('width'=>'30px'),
			),
			array(
				'header'=>'Название подраздела',
				'type'=>'html',
				'value'=>'CHtml::image(Yii::app()->request->baseUrl."/images/backend/folder.gif")."&nbsp;".CHtml::link(CHtml::encode($data->getName()), array("node/index", "id"=>$data->id))',
			),
			array(
				'header'=>'Приоритет',
				'type'=>'raw',
				'value'=>'$data->priority',
			),
			array(
				'type'=>'image',
				'value'=>'"images/backend/".($data->status_id==0?"notactive":"active").".gif"',
			),
			array(
				'header'=>'<img src="images/backend/image.gif" border="0">',
				'type'=>'raw',
				'value'=>'CHtml::link(count($data->photos), Yii::app()->controller->createUrl("photo/index",array("object"=>"node", "object_id"=>$data->id)))',
			),
			array(
				'header'=>'<img src="images/backend/file.gif" border="0">',
				'type'=>'raw',
				'value'=>'CHtml::link(count($data->files), Yii::app()->controller->createUrl("file/index",array("object"=>"node", "object_id"=>$data->id)))',
			),
			array(
				'class'=>'CButtonColumn',
				'deleteConfirmation'=>'Вы уверены, что хотите удалить подраздел?',
				'updateButtonImageUrl'=>Yii::app()->request->baseUrl.'/images/backend/page_white_edit.png',
				'deleteButtonImageUrl'=>Yii::app()->request->baseUrl.'/images/backend/page_white_delete.png',
				'template'=>'{update} {delete}',
			),
		),
	)); ?>
	<hr style="height:1px;">
	<?php echo CHtml::link(CHtml::image(Yii::app()->request->baseUrl.'/images/backend/page_white_edit.png'), array("node/update", "id"=>$node->id));?>&nbsp;&nbsp;
	<a href="<?php echo Yii::app()->controller->createUrl("photo/index",array("object"=>"node", "object_id"=>$node->id)); ?>"><img src="images/backend/image.gif" border="0" /></a>
	
	<br/><br/>

	<?php if ($node->getDesc() && !$node->getText()) echo $node->getDesc(); ?>
	<?php if ($node->getText()) echo $node->getText(); ?>
    </td>
</tr>
</table>