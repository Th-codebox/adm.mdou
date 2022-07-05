<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'group-type-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Поля, помеченные <span class="required">*</span>, являются обязательными.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'name'); ?>
		<?php echo $form->textField($model,'name',array('size'=>60,'maxlength'=>256)); ?>
		<?php echo $form->error($model,'name'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'age_months_from'); ?>
		<?php echo $form->dropDownList($model,"age_months_from", GroupType::model()->getAgeOptions(), array('prompt'=>'укажите возраст')); ?>
		<?php echo $form->error($model,'age_months_from'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'age_months_to'); ?>
		<?php echo $form->dropDownList($model,"age_months_to", GroupType::model()->getAgeOptions(), array('prompt'=>'укажите возраст')); ?>
		<?php echo $form->error($model,'age_months_to'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'is_different_ages'); ?>
		<?php echo $form->checkBox($model,'is_different_ages'); ?>
		<?php echo $form->error($model,'is_different_ages'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Создать' : 'Сохранить'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->