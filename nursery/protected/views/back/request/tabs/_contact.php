<div class="row">
	<?php echo $form->labelEx($model,'is_internet'); ?>
	<?php echo $model->is_internet ? "да" : "нет"; ?>
	<?php echo $form->error($model,'is_internet'); ?>
</div>

<div class="row">
	<?php echo $form->labelEx($model,'phone'); ?>
	<?php echo $form->textField($model,'phone',array('size'=>50,'maxlength'=>50)); ?>
	<?php echo $form->error($model,'phone'); ?>
</div>

<div class="row">
	<?php echo $form->labelEx($model,'is_email_confirm'); ?>
	<?php echo $form->checkBox($model,'is_email_confirm',array('size'=>50,'maxlength'=>50)); ?>
	<?php echo $form->error($model,'is_email_confirm'); ?>

	<?php echo $form->labelEx($model,'email'); ?>
	<?php echo $form->textField($model,'email',array('size'=>50,'maxlength'=>50)); ?>
	<?php echo $form->error($model,'email'); ?>
</div>
