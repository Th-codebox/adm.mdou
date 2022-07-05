<table cellpadding='3' cellspacing='4' border='1' class='border_table'>
<tr><th>ID</th><th>Льгота</th><th>Вне очереди</th><th>Тип документа</th><th>Документ</th><th>Дата выдачи</th><th>Файлы</th><th>&nbsp;</th><th>&nbsp;</th></tr>
<?php foreach ($model->privilegeDocuments as $item): ?>
<tr>
	<td><?php echo $item->id; ?></td>
	<td><?php echo $item->privilege->getName(); ?></td>
	<td><?php echo $item->privilege->out_of_queue ? "да" : "нет"; ?></td>
	<td><?php echo $item->getDocumentName(); ?></td>
	<td><?php echo $item->name; ?></td>
	<td><?php echo $item->issue_date; ?></td>
	<td>
		<?php foreach ($item->files as $file):?>
			<?php if ($file->extension == "exe" || $file->extension == "EXE") continue; ?>
			<?php echo CHtml::link(
				CHtml::image(Yii::app()->request->baseUrl."/images/front/appicons/".$file->getFileTypeImage().".png", "", array(
					"width"=>16, "height"=>16, "align"=>"absmiddle", "alt"=>"", "style"=>"margin: 7px 2px 2px 0px;"))."&nbsp;".
				($file->getName() !== "" ? $file->getName() : "файл")." (*.".$file->extension.", ".$file->getSize().")", 
				$file->getHttpPath(), array('target'=>'_blank')); 
			?>
		<?php endforeach; ?>
	</td>
	<td>
		<?php echo CHtml::link(CHtml::image(Yii::app()->request->baseUrl.'/images/backend/page_white_edit.png', 'Редактировать', array('border'=>0)), 
			'javascript:void(0)', array('id'=>'privilegeLink'.$item->id, 'title'=>'Редактировать')); ?>
		<script>
			jQuery('body').delegate('#privilegeLink<?php echo $item->id; ?>','click',function(){jQuery.ajax({'type':'POST','complete':function(){$("#privilegeDialog").dialog("open");},'url':'?r=request/updatePrivilegeDocument&id=<?php echo $item->request_id; ?>&privilegeDocumentId=<?php echo $item->id; ?>','cache':false,'data':jQuery(this).parents("form").serialize(),'success':function(html){jQuery("#privilegeDialog").html(html)}});return false;}); 
		</script>
	</td>
	<td>
		<?php echo CHtml::link(CHtml::image(Yii::app()->request->baseUrl.'/images/backend/page_white_delete.png', 'Удалить', array('border'=>0)), 
			'javascript:void(0)', array('id'=>'privilegeDeleteLink'.$item->id, 'title'=>'Удалить')); ?>
		<script>
			jQuery('body').delegate('#privilegeDeleteLink<?php echo $item->id; ?>','click',function(){if (confirm('Вы уверены, что хотите удалить льготу?'))jQuery.ajax({'type':'POST','url':'?r=request/deletePrivilegeDocument&id=<?php echo $item->request_id; ?>&privilegeDocumentId=<?php echo $item->id; ?>','cache':false,'success':function(){LoadPrivileges();}});return false;}); 
		</script>
	</td>
</tr>
<?php endforeach; ?>
</table>
