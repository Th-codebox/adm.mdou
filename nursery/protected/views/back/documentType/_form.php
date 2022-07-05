<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'document-type-form',
	'enableAjaxValidation'=>false,
)); ?>

<p class="note">Поля, отмеченные <span class="required">*</span>, обязательны для заполнения.</p>

<?php echo $form->errorSummary($model); ?>

<div class="row">
	<?php echo $form->labelEx($model,'name'); ?>
	<?php echo $form->textField($model,'name',array('size'=>60,'maxlength'=>500)); ?>
	<?php echo $form->error($model,'name'); ?>
</div>

<div class="row">
	<?php echo $form->labelEx($model,'description'); ?>
	<?php echo $form->textArea($model,'description',array('rows'=>6, 'cols'=>50)); ?>
	<?php echo $form->error($model,'description'); ?>
</div>

<div class="row">
	<?php echo $form->labelEx($model,'type'); ?>
	<?php echo $form->dropDownList($model, 'type',
		DocumentType::model()->getTypeOptions());?>
	<?php echo $form->error($model,'street_id'); ?>
</div>

<div class="row buttons">
	<?php echo CHtml::submitButton($model->isNewRecord ? 'Создать' : 'Сохранить'); ?>
</div>

<?php $this->endWidget(); ?>

</div><!-- form -->