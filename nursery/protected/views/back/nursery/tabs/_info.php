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

<div class="row">
	<?php echo $form->labelEx($model,'short_name'); ?>
	<?php echo $form->textField($model,'short_name',array('size'=>60,'maxlength'=>255)); ?>
	<?php echo $form->error($model,'short_name'); ?>
</div>

<div class="row">
	<?php echo $form->labelEx($model,'short_number'); ?>
	<?php echo $form->textField($model,'short_number'); ?>
	<?php echo $form->error($model,'short_number'); ?>
</div>

<div class="row">
	<?php echo $form->labelEx($model,'phone'); ?>
	<?php echo $form->textField($model,'phone',array('size'=>60,'maxlength'=>100)); ?>
	<?php echo $form->error($model,'phone'); ?>
</div>
