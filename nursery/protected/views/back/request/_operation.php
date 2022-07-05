<table border="1" class="border_table">
<tr><th>Операция</th><th>Новый статус</th><th>Причина</th><th>Комментарий</th><th>Описание</th><th>&nbsp;</th></tr>
<?php foreach ($model->getAvailableOperations() as $operation): ?>
	<?php if ($operation->id == Operation::OPERATION_RESTORE && !$model->is_archive) continue; ?>
	<tr>
		<?php $form=$this->beginWidget('CActiveForm', array(
			'id'=>'operation-form-'.$operation->id,
			'enableAjaxValidation'=>false,
			'action'=>array('request/operation', 'id'=>$model->id, 'operationId'=>$operation->id)
		)); ?>
		<td>
			<strong><?php echo $operation->getName(); ?></strong>
			<?php echo CHtml::link(CHtml::image(Yii::app()->request->baseUrl."/images/backend/help.png"), "javascript:void(0)", array(
				'onClick'=>'document.getElementById("desc_'.$operation->id.'").style.display = document.getElementById("desc_'.$operation->id.'").style.display == "none" ? "block" : "none"; return false;'
			)); ?>
			<div id="desc_<?php echo $operation->id; //"?>" style="display: none;">
				<i><?php echo $operation->description; ?></i>
			</div>
		</td>
		<td><?php echo $operation->is_change_status ? Request::getStatusNameStatic($operation->getNewStatus()) : $model->getStatusName(); ?></td>
		<td>
			<?php if ($operation->hasReason()): ?>
				<?php echo CHtml::dropDownList("OperationLog[reason_id]", 0, CHtml::listData($operation->reasons, "id", "Name"), 
					array('prompt'=>'укажите причину', 'style'=>'width: 210px;'));
				?>
			<?php else: ?>
				<?php if ($operation->id == Operation::OPERATION_GRANT_PLACE): ?>
					<div<?php if ($model->queue_number > 300): ?> style="color: red"<?php endif; ?> >
					Номер в очереди: <b><?php echo $model->getQueueNumber(); ?></b></div>
					<?php echo CHtml::dropDownList("OperationLog[granted_nursery_id]", 0, CHtml::listData($model->getSuitableNurseries(), "id", "Name"), 
						array(
							'prompt'=>'Выберите МДОУ', 
							'style'=>'width: 210px;',
							'ajax'=>array(
								'type'=>'POST', //request type
								'url'=>CController::createUrl('nursery/ajaxSuitableGroups'), //url to call.
								//Style: CController::createUrl('currentController/methodToCall')
								'update'=>'#OperationLog_granted_group_id', //selector to update
								'data'=>array('nursery_id'=>'js:this.value', 'age'=>$model->getAgeMonths(), 'disease_id'=>$model->disease_id),
							)
					));	?>
					<br/><br/>
					<?php echo CHtml::dropDownList("OperationLog[granted_group_id]", 0, array(), 
						array('prompt'=>'Выберите группу', 'style'=>'width: 210px;'));
					?>
				 <?php else: ?>
				 	&nbsp;
				<?php endif; ?>
			 <?php endif; ?>
		</td>
		<td>
			<?php if ($operation->is_comment_required) echo "<b>Требуется комментарий</b>";?>
			<?php echo CHtml::textArea('OperationLog[comment]', '', array('rows'=>5, 'cols'=>25)); ?>
		</td>
		<td><?php echo $operation->description; ?></td>
		<td><?php echo CHtml::submitButton('Применить', array(
				'onClick'=>'return confirm("Вы уверены, что хотите выполнить данную операцию?")',
			)); ?>
		</td>
		<?php $this->endWidget(); ?>
	</tr>
<?php endforeach; ?>
</table>
