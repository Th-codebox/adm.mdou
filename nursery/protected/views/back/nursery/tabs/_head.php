<?php echo $form->errorSummary($model->head); ?>

<div class="row">
	<?php echo $form->labelEx($model->head,'surname'); ?>
	<?php echo $form->textField($model->head,'surname',array('size'=>30,'maxlength'=>30)); ?>
	<?php echo $form->error($model->head,'surname'); ?>
</div>

<div class="row">
	<?php echo $form->labelEx($model->head,'name'); ?>
	<?php echo $form->textField($model->head,'name',array('size'=>30,'maxlength'=>30)); ?>
	<?php echo $form->error($model->head,'name'); ?>
</div>

<div class="row">
	<?php echo $form->labelEx($model->head,'patronymic'); ?>
	<?php echo $form->textField($model->head,'patronymic',array('size'=>30,'maxlength'=>30)); ?>
	<?php echo $form->error($model->head,'patronymic'); ?>
</div>

<div class="row">
	<?php echo $form->labelEx($model->head,'name_dative'); ?>
	<?php echo $form->textField($model->head,'name_dative',array('size'=>60,'maxlength'=>60)); ?>
	<?php echo $form->error($model->head,'name_dative'); ?>
</div>

<div class="row">
	<?php echo $form->labelEx($model->head,'post'); ?>
	<?php echo $form->textField($model->head,'post',array('size'=>50,'maxlength'=>50)); ?>
	<?php echo $form->error($model->head,'post'); ?>
</div>

<div class="row">
	<?php echo $form->labelEx($model->head,'post_dative'); ?>
	<?php echo $form->textField($model->head,'post_dative',array('size'=>50,'maxlength'=>50)); ?>
	<?php echo $form->error($model->head,'post_dative'); ?>
</div>

