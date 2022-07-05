<table cellpadding='3' cellspacing='4' border='1' class='border_table'>
<tr><th>ID</th><th>ФИО</th><th>Тип</th><th>Место работы (учебы)</th><th>Должность</th><th>Телефон</th><th>Паспортные данные</th><th>&nbsp;</th><th>&nbsp;</th></tr>
<?php foreach ($model->persons as $item): ?>
<tr>
	<td><?php echo $item->id; ?></td>
	<td><?php echo $item->getFullName(); if ($item->is_applicant) echo " (заявитель)"?></td>
	<td><?php echo $item->getTypeName(); ?></td>
	<td><?php echo $item->work_place; ?></td>
	<td><?php echo $item->work_post; ?></td>
	<td><?php echo $item->phone; ?></td>
	<td><?php echo $item->getPassportInfo(); ?></td>
	<td>
		<?php echo CHtml::link(CHtml::image(Yii::app()->request->baseUrl.'/images/backend/page_white_edit.png', 'Редактировать', array('border'=>0)), 
			'javascript:void(0)', array('id'=>'parentLink'.$item->id, 'title'=>'Редактировать данные')); ?>
		<script>
			jQuery('body').delegate('#parentLink<?php echo $item->id; ?>','click',function(){jQuery.ajax({'type':'POST','complete':function(){$("#parentDialog").dialog("open");},'url':'?r=request/updateParent&id=<?php echo $model->id; ?>&parentId=<?php echo $item->id; ?>','cache':false,'data':jQuery(this).parents("form").serialize(),'success':function(html){jQuery("#parentDialog").html(html)}});return false;}); 
		</script>
	</td>
	<td>
		<?php if ($item->is_applicant): ?>
			&nbsp;		
		<?php else: ?>
			<?php echo CHtml::link(CHtml::image(Yii::app()->request->baseUrl.'/images/backend/page_white_delete.png', 'Удалить', array('border'=>0, )), 
				'javascript:void(0)', array('id'=>'parentDeleteLink'.$item->id, 'title'=>'Удалить')); ?>
			<script>
				jQuery('body').delegate('#parentDeleteLink<?php echo $item->id; ?>','click',function(){
					if (confirm('Вы уверены, что хотите удалить запись?'))
						jQuery.ajax({
							'type':'POST',
							'url':'?r=request/deleteParent&id=<?php echo $item->request_id; ?>&parentId=<?php echo $item->id; ?>',
							'cache':false,
							'success':function(){LoadParents();}
						});
					return false;
				}); 
			</script>
		<?php endif; ?>
	</td>
</tr>
<?php endforeach; ?>
</table>
