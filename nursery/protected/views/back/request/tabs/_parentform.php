<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'parent-form',
	'enableAjaxValidation'=>false,
	'action'=>array($model->isNewRecord ? 'request/createParent&id='.$model->request_id : 'request/updateParent&id='.$model->request_id.'&parentId='.$model->id)
)); ?>

<p class="note">Поля, отмеченные <span class="required">*</span>, обязательны для заполнения.</p>
	
<?php echo $form->errorSummary($model, 'Необходимо исправить следующие ошибки:'); ?>

<table width="100%">
<tr>
	<td colspan="3">
		<?php echo $form->labelEx($model,'applicant_type_id'); ?><br/>
		<?php echo $form->dropDownList($model,"applicant_type_id", Person::model()->getTypeOptions()); ?>
		<?php echo $form->error($model,'applicant_type_id'); ?>
	</td>
</tr>
<tr>
	<td>
		<?php echo $form->labelEx($model,'surname'); ?><br/>
		<?php echo $form->textField($model,"surname"); ?>
		<?php echo $form->error($model,'surname'); ?>
	</td>
	<td>
		<?php echo $form->labelEx($model,'name'); ?><br/>
		<?php echo $form->textField($model,"name"); ?>
		<?php echo $form->error($model,'name'); ?>
	</td>
	<td>
		<?php echo $form->labelEx($model,'patronymic'); ?><br/>
		<?php echo $form->textField($model,"patronymic"); ?>
		<?php echo $form->error($model,'patronymic'); ?>			
	</td>
</tr>
<tr>
	<td>
		<?php echo $form->labelEx($model,'passport_series'); ?><br/>
		<?php echo $form->textField($model,"passport_series"); ?>
		<?php echo $form->error($model,'passport_series'); ?>
	</td>
	<td colspan=2>
		<?php echo $form->labelEx($model,'passport_number'); ?><br/>
		<?php echo $form->textField($model,"passport_number"); ?>
		<?php echo $form->error($model,'passport_number'); ?>
	</td>
<tr>
	<td>
		<?php echo $form->labelEx($model,'passport_issue_date'); ?><br/>
		<?php echo $form->textField($model,'passport_issue_date'); ?>
		<?php echo $form->error($model,'passport_issue_date'); ?>
	</td>
	<td colspan=2>
		<?php echo $form->labelEx($model,'passport_issue_data'); ?><br/>
		<?php echo $form->textField($model,"passport_issue_data"); ?>
		<?php echo $form->error($model,'passport_issue_data'); ?>
	</td>
</tr>
<tr>
	<td>
		<?php echo $form->labelEx($model,'phone'); ?><br/>
		<?php echo $form->textField($model,"phone"); ?>
		<?php echo $form->error($model,'phone'); ?>
	</td>
	<td>
		<?php echo $form->labelEx($model,'work_place'); ?><br/>
		<?php echo $form->textField($model,"work_place"); ?>
		<?php echo $form->error($model,'work_place'); ?>
	</td>
	<td>
		<?php echo $form->labelEx($model,'work_post'); ?><br/>
		<?php echo $form->textField($model,"work_post"); ?>
		<?php echo $form->error($model,'work_post'); ?>
	</td>
</tr>
</table>

<input type="submit" value="Отправить">
<?php $this->endWidget(); ?>

<script language="JavaScript" type="text/javascript">
<!--
	$('#parent-form').live('submit', function(){
		$.ajax({
			type: 'POST',
			url: document.getElementById('parent-form').action,
			data: $(this).serialize(),
			success: function(data) {
				if (data == "ok") {
					$("#parentDialog").dialog("close");
					$.ajax({
						type: 'GET',
						url: '?r=request/parentList&id=<?php echo $model->request_id; ?>',
						success: function(data2) {
							document.getElementById("parentList").innerHTML = data2;
						}
					})
				}
				else
					$("#parentDialog").html(data);
			}
		})
		return false
	})
	$(function() {
		$.datepicker.setDefaults(
			$.extend($.datepicker.regional["ru"])
		);

		$("#Person_passport_issue_date").datepicker({
			showAnim : 'fold',
        	changeMonth : true,
        	changeYear : true,
        	showButtonPanel : true,
        	constrainInput : true,
        	dateFormat : "yy-mm-dd",
			maxDate : "+0d"
		});//собственно вызов нашего календаря
//		$("#ui-datepicker-div").css("z-index", 1000000); //задаем z-index
	});
</script>
