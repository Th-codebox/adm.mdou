<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'nursery-group-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Поля, помеченные <span class="required">*</span>, являются обязательными.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'group_id'); ?>
		<?php echo $form->dropDownList($model,'group_id', CHtml::listData(GroupType::model()->findAll(), 'id', 'name')); ?>
		<?php echo CHtml::button('Скопировать в название', array('onClick'=>'document.getElementById("NurseryGroup_name").value=document.getElementById("NurseryGroup_group_id").options[document.getElementById("NurseryGroup_group_id").selectedIndex].text')); ?>
		<?php echo $form->error($model,'group_id'); ?>
	</div>
	
	<div class="row">
		<?php echo $form->labelEx($model,'name'); ?>
		<?php echo $form->textField($model,'name', array('style'=>'width: 300px;')); ?>
		<?php echo $form->error($model,'name'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'disease_id'); ?>
		<?php echo $form->dropDownList($model,'disease_id', CHtml::listData(Disease::model()->findAll(array(
				'order'=>'name ASC'
			)), 'id', 'name'), 
			array('empty'=>array(0=>'Нет'))
		); ?>
		<?php echo $form->error($model,'disease_id'); ?>
	</div>
	

	<div class="row">
		<?php echo $form->labelEx($model,'free_places'); ?>
		<?php echo $form->textField($model,'free_places'); ?>
		<?php echo $form->error($model,'free_places'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'total_places'); ?>
		<?php echo $form->textField($model,'total_places'); ?>
		<?php echo $form->error($model,'total_places'); ?>
	</div>
	
	<div class="row">
		<?php echo $form->hiddenField($model,'nursery_id'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Создать' : 'Сохранить'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->