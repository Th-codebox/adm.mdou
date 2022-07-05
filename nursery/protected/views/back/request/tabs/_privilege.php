<div class="row" id="privilege_tab">
	<?php echo $form->labelEx($model,'has_privilege'); ?>
	<?php echo $form->checkBox($model,'has_privilege', array(
		'onClick'=>'var ok = confirm("Вы уверены, что хотите изменить значение?"); if (ok && !this.checked) document.getElementById("Request_out_of_queue").checked = false; return ok;'
	)); ?>
	<?php echo $form->error($model,'has_privilege'); ?>

	<?php echo $form->labelEx($model,'out_of_queue'); ?>
	<?php echo $form->checkBox($model,'out_of_queue', array(
		'onClick'=>'var ok = confirm("Вы уверены, что хотите изменить значение?"); if (ok && this.checked) document.getElementById("Request_has_privilege").checked = true; return ok;'
	)); ?>
	<?php echo $form->error($model,'out_of_queue'); ?>

	<div id="chosen_privileges"></div>
	<?php echo CHtml::hiddenField('privileges', '');?>
</div>

<?php echo CHtml::ajaxLink('Добавить', 
	array("request/createPrivilegeDocument", "id"=>$model->id),
	array(
		'type'=>'POST',
		'update'=>'#privilegeDialog',
		'complete'=>'function(){$("#privilegeDialog").dialog("open");}',
	),
	array(
		'id'=>'privilegeLinkAdd',
		'onClick'=>'$("#privilegeDialog").dialog("option", "title", "Добавление льготы"); return false;'
	)
);?>

<div id="privilegeList">
<?php $this->renderPartial('tabs/_privilegelist', array('form'=>$form, 'model'=>$model)); ?>
</div>

<div class="row" id="privilegeDialog"></div>

<script language="JavaScript" type="text/javascript">
<!--
	var privilegeDescriptions = new Array();

	<?php foreach (Privilege::model()->findAll() as $privilege): ?>
	privilegeDescriptions[<?php echo $privilege->id; ?>] = <?php echo json_encode(CHtml::encode($privilege->description)); ?>;
	<?php endforeach; ?>
	
	$(function(){
		$("#privilegeDialog").dialog({
			autoOpen: false,
			modal: true,
			width: '1000px',
			height: 'auto',
		});

	});

	function LoadPrivileges()
	{
		$.ajax({
			type: 'GET',
			url: '?r=request/privilegeList&id=<?php echo $model->id; ?>',
			success: function(data) {
				$("#privilegeList").html(data);
			}
		})
	}
	

//-->
</script>
<noscript><p><b>Javascript must be enabled to use this form.</b></p></noscript>