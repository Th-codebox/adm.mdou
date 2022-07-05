<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'commission-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Поля, помеченные <span class="required">*</span>, являются обязательными.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'surname'); ?>
		<?php echo $form->textField($model,'surname',array('size'=>60,'maxlength'=>100)); ?>
		<?php echo $form->error($model,'surname'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'name'); ?>
		<?php echo $form->textField($model,'name',array('size'=>50,'maxlength'=>50)); ?>
		<?php echo $form->error($model,'name'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'patronymic'); ?>
		<?php echo $form->textField($model,'patronymic',array('size'=>50,'maxlength'=>50)); ?>
		<?php echo $form->error($model,'patronymic'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'name_dative'); ?>
		<?php echo $form->textField($model,'name_dative',array('size'=>60,'maxlength'=>100)); ?>
		<?php echo $form->error($model,'name_dative'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'post'); ?>
		<?php echo $form->textField($model,'post',array('size'=>60,'maxlength'=>100)); ?>
		<?php echo $form->error($model,'post'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'phone'); ?>
		<?php echo $form->textField($model,'phone',array('size'=>60,'maxlength'=>100)); ?>
		<?php echo $form->error($model,'phone'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'is_head'); ?>
		<?php echo $form->checkBox($model,'is_head',array('size'=>60,'maxlength'=>100)); ?>
		<div style="font-size:11px;">Председателем комиссии может быть только один человек</div>
		<?php echo $form->error($model,'is_head'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'is_active'); ?>
		<?php echo $form->checkBox($model,'is_active',array('size'=>60,'maxlength'=>100)); ?>
		<?php echo $form->error($model,'is_active'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Создать' : 'Сохранить'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->