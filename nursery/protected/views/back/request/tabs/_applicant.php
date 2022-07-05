<?php if (isset($model->applicant)): ?>
<div class="row">
	<div class="row">
		<?php echo $form->labelEx($model->applicant,'applicant_type_id'); ?>
		<?php echo $form->dropDownList($model->applicant,"applicant_type_id", Person::model()->getTypeOptions()); ?>
		<?php echo $form->error($model->applicant,'applicant_type_id'); ?>
	</div>

	<table width="100%" border="0">
	<tr>
		<td>
			<?php echo $form->labelEx($model->applicant,'surname'); ?>
			<?php echo $form->textField($model->applicant,"surname"); ?>
			<?php echo $form->error($model->applicant,'surname'); ?>
		</td>
		<td>
			<?php echo $form->labelEx($model->applicant,'name'); ?>
			<?php echo $form->textField($model->applicant,"name"); ?>
			<?php echo $form->error($model->applicant,'name'); ?>
		</td>
		<td>
			<?php echo $form->labelEx($model->applicant,'patronymic'); ?>
			<?php echo $form->textField($model->applicant,"patronymic"); ?>
			<?php echo $form->error($model->applicant,'patronymic'); ?>			
		</td>
		<td>
			<?php echo $form->labelEx($model->applicant,'phone'); ?>
			<?php echo $form->textField($model->applicant,"phone"); ?>
			<?php echo $form->error($model->applicant,'phone'); ?>
		</td>
	</tr>
	
	<tr>
		<td>
			<?php echo $form->labelEx($model->applicant,'passport_series'); ?><br/>
			<?php echo $form->textField($model->applicant,"passport_series"); ?>
			<?php echo $form->error($model->applicant,'passport_series'); ?>
		</td>
		<td>
			<?php echo $form->labelEx($model->applicant,'passport_number'); ?><br/>
			<?php echo $form->textField($model->applicant,"passport_number"); ?>
			<?php echo $form->error($model->applicant,'passport_number'); ?>
		</td>
		<td>
			<?php echo $form->labelEx($model->applicant,'passport_issue_date'); ?>
			<?php $this->widget('zii.widgets.jui.CJuiDatePicker', array(
    			'model'=>$model->applicant,
				'attribute'=>'passport_issue_date',
				'language'=>'ru',
				// additional javascript options for the date picker plugin
				'options'=>array(
					'showAnim'=>'fold',
					'changeMonth' => 'true',
					'changeYear' => 'true',
					'showButtonPanel' => 'true',
					'constrainInput' => 'false',
        			'dateFormat' => 'yy-mm-dd',
					'maxDate' => "+0d"
    			),
    		'htmlOptions'=>array(
    			'style'=>'height:20px;',
				'readonly'=>'readonly'
			),
			));?>
			<?php echo $form->error($model,'passport_issue_date'); ?>
		</td>
		<td>
			<?php echo $form->labelEx($model->applicant,'passport_issue_data'); ?><br/>
			<?php echo $form->textField($model->applicant,"passport_issue_data"); ?>
			<?php echo $form->error($model->applicant,'passport_issue_data'); ?>
		</td>
	</tr>
	<tr>
		<td>
			<?php echo $form->labelEx($model->applicant,'work_place'); ?>
			<?php echo $form->textField($model->applicant,"work_place"); ?>
			<?php echo $form->error($model->applicant,'work_place'); ?>
		</td>
		<td colspan="3">
			<?php echo $form->labelEx($model->applicant,'work_post'); ?>
			<?php echo $form->textField($model->applicant,"work_post"); ?>
			<?php echo $form->error($model->applicant,'work_post'); ?>
		</td>
	</tr>
	</table>
</div>
<?php else: ?>
Не найден заявитель
<?php endif; ?>