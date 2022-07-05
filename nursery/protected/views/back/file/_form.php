<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'file-form',
	'enableAjaxValidation'=>false,
	'method'=>'post',
	'htmlOptions' =>array('enctype'=>'multipart/form-data' ),
)); ?>

	<p class="note">Поля, отмеченные <span class="required">*</span>, являются обязательными.</p>

	<?php echo $form->errorSummary($model); ?>

	<?php if (isset($model->http_path)): ?>
		<div class="row">
			<?php echo $model->http_path;?>
		</div>
	<?php else: ?>
		<div class="row">
			<?php echo $form->labelEx($model, 'file');?>
			<?php echo $form->fileField($model, 'file');?>
			<?php echo $form->error($model,'file'); ?>
		</div>
	<?php endif;?>

	<div class="row">
		<?php echo $form->labelEx($model,'name'); ?>
		<?php echo $form->textField($model,'name',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'name'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'status'); ?>
		<?php echo $form->dropDownList($model, 'status', array(
		    '0' => 'неактивный', '1' => 'активный')
		);?>
		<?php echo $form->error($model,'status'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Создать' : 'Сохранить'); ?>
	</div>

	<?php echo CHtml::hiddenField("object", $fileObject->getFileObjectType());?>
	<?php echo CHtml::hiddenField("object_id", $fileObject->id);?>

	<?php
		foreach ($this->getParameters() as $key=>$value)
			echo CHtml::hiddenField($key, $value);
	?>

<?php $this->endWidget(); ?>

</div><!-- form -->