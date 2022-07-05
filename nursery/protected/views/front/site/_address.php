<table border=0 cellspacing=0 cellpadding=3 class="zvl_border">
<tr>
	<td colspan="2" bgcolor="#d6d4d2" class="zvl">
		Контактная информация
	</td>
</tr>
<tr>
	<td align="right" class="zvl2">
	<?php echo $form->labelEx($model,'town_id'); ?>
	</td>
	<td class="zvl2">
	<?php echo $form->dropDownList($model, 'town_id',
		CHtml::listData(Town::model()->findAll(array('order'=>'name ASC')),
		'id', 'name'), array('prompt'=>'Другой', 'onChange'=>'OnTownChanged();', 'id'=>'townslist'));?>
	</td>
</tr>
<tr>
	<td align="right" class="zvl2">
	<div id="otheraddress1">
	<?php echo $form->labelEx($model,'address_other'); ?>
	</div>
	</td>
	<td class="zvl2">
	<div id="otheraddress2">
	<?php echo $form->textField($model,'address_other',array('size'=>60,'maxlength'=>255)); ?>
	</div>
	</td>
</tr>
<tr>
	<td align="right" class="zvl2">
	<div id="baseaddress1">
	<?php echo $form->labelEx($model,'microdistrict_id'); ?> *
	</div>
	</td>
	<td class="zvl2">
	<div id="baseaddress2">
	<?php echo $form->dropDownList($model, 'microdistrict_id',
		CHtml::listData(Microdistrict::model()->findAll(array(
			'order'=>'name ASC')),
		'id', 'name'),
		array(
			'prompt'=>'Выберите микрорайон',
			'ajax'=>array(
				'type'=>'POST', //request type
				'url'=>CController::createUrl('microdistrict/ajaxStreets'), //url to call.
				//Style: CController::createUrl('currentController/methodToCall')
				'update'=>'#Request_street_id', //selector to update
				'data'=>array('microdistrict_id'=>'js:this.value'),
				//'data'=>'js:javascript statement' 
				//leave out the data key to pass all form values through
			)
		));?>
	</div>
	</td>
</tr>
<tr>
	<td align="right" class="zvl2">
	<div id="baseaddress3">
	<?php echo $form->labelEx($model,'street_id'); ?> *
	</div>
	</td>
	<td class="zvl2">
	<div id="baseaddress4">
	<?php echo $form->dropDownList($model, 'street_id',
		CHtml::listData(Street::model()->findAll(array('order'=>'name ASC')),
		'id', 'Name'), array('prompt'=>'Выберите улицу'));?>
	</div>
	</td>
</tr>
<tr>
	<td align="right" class="zvl2">
	<div id="baseaddress5">
	<?php echo $form->labelEx($model,'house'); ?> *
	</div>
	</td>
	<td class="zvl2">
	<div id="baseaddress6">
	<?php echo $form->textField($model,'house',array('size'=>10,'maxlength'=>10)); ?>
	</div>
	</td>
</tr>
<tr>
	<td align="right" class="zvl2">
	<div id="baseaddress7">
	<?php echo $form->labelEx($model,'building'); ?>
	</div>
	</td>
	<td class="zvl2">
	<div id="baseaddress8">
	<?php echo $form->textField($model,'building',array('size'=>10,'maxlength'=>10)); ?>
	</div>
	</td>
</tr>
<tr>
	<td align="right" class="zvl2">
	<div id="baseaddress9">
	<?php echo $form->labelEx($model,'flat'); ?>
	</div>
	</td>
	<td class="zvl2">
	<div id="baseaddress10">
	<?php echo $form->textField($model,'flat',array('size'=>5,'maxlength'=>5)); ?>
	</div>
	</td>
</tr>
</div>
<tr>
	<td align="right" class="zvl2">
	<?php echo $form->labelEx($model,'phone'); ?>
	</td>
	<td class="zvl2">
	<?php echo $form->textField($model,'phone',array('size'=>60,'maxlength'=>255)); ?>
	</td>
</tr>
<tr>
	<td align="right" class="zvl2">
	<?php echo $form->labelEx($model,'email'); ?>
	</td>
	<td class="zvl2">
	<?php echo $form->textField($model,'email',array('size'=>60,'maxlength'=>255)); ?>
	</td>
</tr>
<tr><td class="zvl2">&nbsp;</td><td class="zvl2">&nbsp;</td></tr>
<tr>
<td colspan="2" class="zvl2">
<?php echo $form->checkBox($model, 'is_email_confirm'); ?>Я хочу получать уведомления о ходе обработки заявления по электронной почте.
</td>
</tr>
<tr><td class="zvl2">&nbsp;</td><td class="zvl2">&nbsp;</td></tr>
</table>

<script type="text/javascript">

function OnTownChanged()
{
	var list = document.getElementById("townslist");
	if (list.value == "1")
	{
		document.getElementById("otheraddress1").style.display = "none";
		document.getElementById("otheraddress2").style.display = "none";
		document.getElementById("baseaddress1").style.display = "inline";
		document.getElementById("baseaddress2").style.display = "inline";
		document.getElementById("baseaddress3").style.display = "inline";
		document.getElementById("baseaddress4").style.display = "inline";
		document.getElementById("baseaddress5").style.display = "inline";
		document.getElementById("baseaddress6").style.display = "inline";
		document.getElementById("baseaddress7").style.display = "inline";
		document.getElementById("baseaddress8").style.display = "inline";
		document.getElementById("baseaddress9").style.display = "inline";
		document.getElementById("baseaddress10").style.display = "inline";
	}
	else
	{
		document.getElementById("otheraddress1").style.display = "inline";
		document.getElementById("otheraddress2").style.display = "inline";
		document.getElementById("baseaddress1").style.display = "none";
		document.getElementById("baseaddress2").style.display = "none";
		document.getElementById("baseaddress3").style.display = "none";
		document.getElementById("baseaddress4").style.display = "none";
		document.getElementById("baseaddress5").style.display = "none";
		document.getElementById("baseaddress6").style.display = "none";
		document.getElementById("baseaddress7").style.display = "none";
		document.getElementById("baseaddress8").style.display = "none";
		document.getElementById("baseaddress9").style.display = "none";
		document.getElementById("baseaddress10").style.display = "none";
	}
}

OnTownChanged();
</script>