<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'privilege-form',
	'enableAjaxValidation'=>false,
	'action'=>array($model->isNewRecord ? 'request/createPrivilegeDocument&id='.$model->request_id : 'request/updatePrivilegeDocument&id='.$model->request_id.'&privilegeDocumentId='.$model->id)
)); ?>

<?php echo $form->errorSummary($model, 'Необходимо исправить следующие ошибки:'); ?>

<table width="100%">
<tr>
	<td colspan="2">
		<?php echo $form->labelEx($model,'privilege_id'); ?><br/>
		<?php echo $form->dropDownList($model,"privilege_id", 
			CHtml::listData(Privilege::model()->findAll(array('order'=>'id')), 'id', 'name'), array(
				'onChange' => 'document.getElementById("privilegeDescription").innerHTML = privilegeDescriptions[this.value];'
			)
		); ?>
		<?php echo $form->error($model,'privilege_id'); ?>
	</td>
</tr>
<tr>
	<td colspan="2">
		<?php echo $form->labelEx($model,'document_type_id'); ?><br/>
		<?php echo $form->dropDownList($model,"document_type_id", 
			CHtml::listData(DocumentType::model()->findAll(array(
				'order'=>'id'
			)), 'id', 'name'),
			array('prompt'=>'Другой', 'style'=>'width: 600px;')
		); ?>
		<?php echo $form->error($model,'document_type_id'); ?>
	</td>
</tr>
<tr>
	<td>
		<?php echo $form->labelEx($model,'name'); ?><br/>
		<?php echo $form->textField($model,"name"); ?>
		<?php echo $form->error($model,'name'); ?>
	</td>
	<td>
		<?php echo $form->labelEx($model,'issue_date'); ?><br/>
		<?php echo $form->textField($model,'issue_date'); ?>
		<?php echo $form->error($model,'issue_date'); ?>
	</td>
</tr>
</table>

<input type="submit" value="Отправить">
<?php $this->endWidget(); ?>

<div id="privilegeDescription"></div>

<script language="JavaScript" type="text/javascript">
<!--
	$('#privilege-form').live('submit', function(){
		$.ajax({
			type: 'POST',
			url: document.getElementById('privilege-form').action,
			data: $(this).serialize(),
			success: function(data) {
				if (data == "ok") {
					$("#privilegeDialog").dialog("close");
					LoadPrivileges();
				}
				else
					$("#privilegeDialog").html(data);
			}
		})
		return false;
	});
	
	$(function() {
		$.datepicker.setDefaults(
			$.extend($.datepicker.regional["ru"])
		);

		$("#PrivilegeDocument_issue_date").datepicker({
			showAnim : 'fold',
        	changeMonth : true,
        	changeYear : true,
        	showButtonPanel : true,
        	constrainInput : true,
        	dateFormat : "yy-mm-dd",
			maxDate : "+0d"
		});//собственно вызов нашего календаря
		
		$("#PrivilegeDocument_privilege_id").live('change', function(){
			$.ajax({
				type : 'POST', //request type
				url : '?r=privilege/ajaxDocumentTypes', //url to call.
				data : 'privilege_id=' + document.getElementById("PrivilegeDocument_privilege_id").value,
				success : function(data){
					$("#PrivilegeDocument_document_type_id").html(data);
					document.getElementById("privilegeDescription").innerHTML = privilegeDescriptions[document.getElementById("PrivilegeDocument_privilege_id").value];
				}
			})
		});
		$.ajax({
			type : 'POST', //request type
			url : '?r=privilege/ajaxDocumentTypes', //url to call.
			data : 'privilege_id=' + document.getElementById("PrivilegeDocument_privilege_id").value + '&document_type_id=' + document.getElementById("PrivilegeDocument_document_type_id").value,
			success : function(data){
				$("#PrivilegeDocument_document_type_id").html(data);
				document.getElementById("privilegeDescription").innerHTML = privilegeDescriptions[document.getElementById("PrivilegeDocument_privilege_id").value];
			}
		});
	});

</script>
