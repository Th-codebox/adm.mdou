<?php echo CHtml::ajaxLink('Добавить', 
	array("request/createParent", "id"=>$model->id),
	array(
		'type'=>'POST',
		'update'=>'#parentDialog',
		'complete'=>'function(){$("#parentDialog").dialog("open");}',
	),
	array(
		'id'=>'parentLinkAdd',
		'onClick'=>'$("#parentDialog").dialog("option", "title", "Добавление родителя / представителя"); return false;'
	)
);?>

<div id="parentList">
<?php $this->renderPartial('tabs/_parentlist', array('form'=>$form, 'model'=>$model)); ?>
</div>

<div class="row" id="parentDialog"></div>

<script language="JavaScript" type="text/javascript">
<!--
	$(function(){
		$("#parentDialog").dialog({
			autoOpen: false,
			modal: true,
			width: '1000px',
			height: 'auto',
		});
	});

	function LoadParents()
	{
		$.ajax({
			type: 'GET',
			url: '?r=request/parentList&id=<?php echo $model->id; ?>',
			success: function(data) {
				$("#parentList").html(data);
			}
		})
	}
//-->
</script>
<noscript><p><b>Javascript must be enabled to use this form.</b></p></noscript>
