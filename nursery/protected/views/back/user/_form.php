<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'user-form',
	'enableAjaxValidation'=>false,
	'htmlOptions'=> array('enctype' =>'multipart/form-data', 'onSubmit'=>'return SubmitForm();'),
)); ?>

<p class="note">Поля, помеченные <span class="required">*</span>, являются обязательными.</p>

<?php echo $form->errorSummary($model); ?>

<div class="row">
	<?php echo $form->labelEx($model,'username'); ?>
	<?php echo $form->textField($model,'username',array('size'=>60,'maxlength'=>256)); ?>
	<?php echo $form->error($model,'username'); ?>
</div>

<?php if ($model->isNewRecord): ?>
	<div class="row">
		<?php echo $form->labelEx($model,'password'); ?>
		<?php echo $form->passwordField($model,'password',array('size'=>60,'maxlength'=>256)); ?>
		<?php echo $form->error($model,'password'); ?>
	</div>
	
	<div class="row">
		<?php echo $form->label($model,'password_repeat'); ?>
		<?php echo $form->passwordField($model,'password_repeat',array('size'=>60,'maxlength'=>256)); ?>
		<?php echo $form->error($model,'password_repeat'); ?>
	</div>
<?php endif; ?>

<div class="row">
	<?php echo $form->labelEx($model,'name'); ?>
	<?php echo $form->textField($model,'name',array('size'=>60,'maxlength'=>256)); ?>
	<?php echo $form->error($model,'name'); ?>
</div>
	
<div class="row">
	<?php $this->renderPartial('_roles', array('form'=>$form, 'model'=>$model)); ?>
</div>
	
<div class="row buttons">
	<?php echo CHtml::submitButton($model->isNewRecord ? 'Создать' : 'Сохранить'); ?>
</div>

<?php $this->endWidget(); ?>

</div><!-- form -->

<script language="JavaScript" type="text/javascript">
<!--

    function AddItem(refCode)
    {
    	var list = document.getElementById('roleList');
    	var related = document.getElementById('roles');
    	var item = list.options[list.selectedIndex];
    	var index = -1;
    	for (var i = 0; i < related.length; i++)
    		if (related.options[i].value == item.value) {
    			index = i;
    			break;
    		}
    	if (index >= 0)
    		alert('Выбранный элемент уже содержится в списке выбранных');
		else {
			related.options[related.length] = new Option(item.text, item.value);
    	}
    }

    function DeleteItem(refCode)
    {
    	var items = document.getElementById('roles');
		items.options[items.selectedIndex] = null;
    }
    
    function SubmitForm()
    {
       	var related = document.getElementById('roles');
    	for (var i = 0; i < related.length; i++)
    		related.options[i].selected = true;

    	return true;
    }

//-->
</script>
<noscript><p><b>Javascript must be enabled to use this form.</b></p></noscript>
