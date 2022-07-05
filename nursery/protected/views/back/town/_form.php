<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'town-form',
	'enableAjaxValidation'=>false,
)); ?>

<p class="note">Поля, отмеченные <span class="required">*</span>, обязательны для заполнения.</p>

<?php echo $form->errorSummary($model); ?>

<div class="row">
	<?php echo $form->labelEx($model,'code'); ?>
	<?php echo $form->textField($model,'code',array('size'=>10,'maxlength'=>10)); ?>
	<?php echo $form->error($model,'code'); ?>
</div>

<div class="row">
	<?php echo $form->labelEx($model,'name'); ?>
	<?php echo $form->textField($model,'name',array('size'=>60,'maxlength'=>255)); ?>
	<?php echo $form->error($model,'name'); ?>
</div>

<div class="row buttons">
	<?php echo CHtml::submitButton($model->isNewRecord ? 'Создать' : 'Сохранить'); ?>
</div>

<?php $this->endWidget(); ?>

</div><!-- form -->