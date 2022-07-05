<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'photo-form',
	'enableAjaxValidation'=>false,
	'method'=>'post',
	'htmlOptions' =>array('enctype'=>'multipart/form-data'),
)); ?>

	<p class="note">Поля, отмеченные <span class="required">*</span>, являются обязательными.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'name'); ?>
		<?php echo $form->textField($model,'name',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'name'); ?>
	</div>

	<?php if (Yii::app()->controller->action->id == "update"): ?>
		<div class="row">
			<table border="0">
				<tr><td><?php echo $model->getHttpPath();?><br/></td></tr>
				<tr><td><?php echo $model->getThumbImage();?></td></tr>
			</table>
		</div>
	<?php else: ?>
		<div class="row">
			<?php echo $model->image;?>
			<?php echo $form->labelEx($model, 'image');?>
			<?php echo $form->fileField($model, 'image');?>
			<?php echo $form->error($model,'image'); ?>
		</div>
	<?php endif;?>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Создать' : 'Сохранить'); ?>
	</div>

	<?php echo CHtml::hiddenField("object", $photoObject->getFileObjectType());?>
	<?php echo CHtml::hiddenField("object_id", $photoObject->id);?>
	
	<?php
		foreach ($this->getParameters() as $key=>$value)
			echo CHtml::hiddenField($key, $value);
	?>

<?php $this->endWidget(); ?>

</div><!-- form -->