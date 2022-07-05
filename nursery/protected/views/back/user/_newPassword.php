<?php
$this->breadcrumbs=array(
	'Users'=>array('index'),
	$model->name,
	'Смена пароля'
);
?>

<h1>Смена пароля для пользователя <?php echo $model->id; ?></h1>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'user-form',
	'enableAjaxValidation'=>true,
)); ?>

	<p class="note">Поля, помеченные <span class="required">*</span>, являются обязательными.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'password'); ?>
		<?php echo $form->passwordField($model,'password',array('size'=>60,'maxlength'=>256, 'value'=>'')); ?>
		<?php echo $form->error($model,'password'); ?>
	</div>
	
	<div class="row">
		<?php echo $form->label($model,'password_repeat'); ?>
		<?php echo $form->passwordField($model,'password_repeat',array('size'=>60,'maxlength'=>256, 'value'=>'')); ?>
		<?php echo $form->error($model,'password_repeat'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Сохранить'); ?>
	</div>

	<?php //echo CHtml::hiddenField("backUrl", isset($_GET['backUrl']) ? $_GET['backUrl'] : "");?>
<?php $this->endWidget(); ?>

</div><!-- form -->
