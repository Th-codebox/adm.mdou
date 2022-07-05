<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'operation-reason-form',
	'enableAjaxValidation'=>false,
	'htmlOptions'=> array('enctype' =>'multipart/form-data', 'onSubmit'=>'return SubmitForm();'),
)); ?>

<p class="note">Поля, помеченные <span class="required">*</span>, являются обязательными.</p>

<?php echo $form->errorSummary($model); ?>

<div class="row">
	<?php echo $form->labelEx($model,'name'); ?>
	<?php echo $form->textField($model,'name',array('size'=>60,'maxlength'=>255)); ?>
	<?php echo $form->error($model,'name'); ?>
</div>
	
<?php $this->renderPartial('_operations', array('form'=>$form, 'model'=>$model)); ?>

<div class="row buttons">
	<?php echo CHtml::submitButton($model->isNewRecord ? 'Создать' : 'Сохранить'); ?>
</div>

<?php $this->endWidget(); ?>

</div><!-- form -->

<script language="JavaScript" type="text/javascript">
<!--

    function AddItem()
    {
    	var list = document.getElementById('operationList');
    	var related = document.getElementById('OperationReason_operations');
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
    	var items = document.getElementById('OperationReason_operations');
		items.options[items.selectedIndex] = null;
    }
    
    function SubmitForm()
    {
       	var related = document.getElementById('OperationReason_operations');
    	for (var i = 0; i < related.length; i++)
    		related.options[i].selected = true;

    	return true;
    }

//-->
</script>
<noscript><p><b>Javascript must be enabled to use this form.</b></p></noscript>
