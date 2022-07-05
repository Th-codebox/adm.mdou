<div class="row">
	<?php echo $form->labelEx($model,'town_id'); ?>
	<?php echo $form->dropDownList($model, 'town_id',
		CHtml::listData(Town::model()->findAll(array('order'=>'name ASC')),
		'id', 'name'), array('prompt'=>'Другой', 'onChange'=>'ChangeTown();'));?>
	<?php echo $form->error($model,'town_id'); ?>
</div>

<div class="row" id="addressotherdiv" style="display: none;">
	<label for="Request_address_other" class="required">Другой адрес <span class="required">*</span></label>
	<?php echo $form->textField($model,'address_other',array('size'=>60,'maxlength'=>255)); ?>
	<?php echo $form->error($model,'address_other'); ?>
</div>

<div id="addressdiv">
	<div class="row">
		<label for="Request_microdistrict_id" class="required">Микрорайон <span class="required">*</span></label>
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
					//leave out the data key to pass all form values through
				)
			));?>
		<?php echo $form->error($model,'microdistrict_id'); ?>
	</div>

	<div class="row">
		<label for="Request_street_id" class="required">Улица <span class="required">*</span></label>
		<?php echo $form->dropDownList($model, 'street_id',
			CHtml::listData(Street::model()->findAll(array('order'=>'name ASC')),
			'id', 'NameReversed'), array('prompt'=>'Выберите улицу'));?>
		<?php echo $form->error($model,'street_id'); ?>
	</div>

	<div class="row">
		<label for="Request_house" class="required">Дом <span class="required">*</span></label>
		<?php echo $form->textField($model,'house',array('size'=>10,'maxlength'=>10)); ?>
		<?php echo $form->error($model,'house'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'building'); ?>
		<?php echo $form->textField($model,'building',array('size'=>10,'maxlength'=>10)); ?>
		<?php echo $form->error($model,'building'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'flat'); ?>
		<?php echo $form->textField($model,'flat',array('size'=>5,'maxlength'=>5)); ?>
		<?php echo $form->error($model,'flat'); ?>
	</div>
</div>

<script language="JavaScript" type="text/javascript">
<!--
	function ChangeTown()
	{
		var list = document.getElementById("Request_town_id");
		if (list.value == "1") {
			document.getElementById('addressdiv').style.display = 'block';
			document.getElementById('addressotherdiv').style.display = 'none';
		}
		else {
			document.getElementById('addressdiv').style.display = 'none';
			document.getElementById('addressotherdiv').style.display = 'block';
		}
	}

	ChangeTown();
//-->
</script>
<noscript><p><b>Javascript must be enabled to use this form.</b></p></noscript>
