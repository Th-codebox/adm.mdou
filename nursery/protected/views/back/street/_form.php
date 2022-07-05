<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'street-form',
	'enableAjaxValidation'=>false,
	'htmlOptions'=> array('onSubmit'=>'return SubmitForm();'),
)); ?>

<p class="note">Поля, отмеченные <span class="required">*</span>, обязательны для заполнения.</p>

<?php echo $form->errorSummary($model); ?>

<div class="row">
	<?php echo $form->labelEx($model,'code'); ?>
	<?php echo $form->textField($model,'code',array('size'=>10,'maxlength'=>10)); ?>
	<?php echo $form->error($model,'code'); ?>
</div>

<div class="row">
	<?php echo $form->labelEx($model,'street_type_id'); ?>
	<?php echo $form->dropDownList($model, 'street_type_id',
		CHtml::listData(StreetType::model()->findAll(array('order'=>'name ASC')),
		'id', 'Name'), array('prompt'=>'Выберите тип улицы'));?>
	<?php echo $form->error($model,'street_type_id'); ?>
</div>

<div class="row">
	<?php echo $form->labelEx($model,'name'); ?>
	<?php echo $form->textField($model,'name',array('size'=>60,'maxlength'=>255)); ?>
	<?php echo $form->error($model,'name'); ?>
</div>

<div class="row">
	<table border="0" width="100%">
	<tr><th>Выбранные микрорайоны</th><th>&nbsp;</th><th width="100%">Список микрорайонов</th></tr>
	<tr>
		<td>
			<?php echo $form->dropDownList($model, 'microdistricts', CHtml::listData($model->microdistricts, 'id', 'name'),
				array('size' => 3, 'style' => 'width: 300px;', 'multiple'=>'multiple'));?>
			<br/>
		</td>
		<td valign="middle">
			<?php echo CHtml::button('>>>', array('onClick' => 'DeleteItem();'))?>
			<br/><br/>
			<?php echo CHtml::button('<<<', array('onClick' => 'AddItem();'))?>
		</td>

		<td><?php echo CHtml::dropDownList('microdistrictList', '0', 
			CHtml::listData(Microdistrict::model()->findAll(array('order'=>'name ASC')),
				'id', 'name'), array('size' => 10, 'style' => 'width: 300px;'));?></td>
	</tr>
	</table>
</div>

<div class="row buttons">
	<?php echo CHtml::submitButton($model->isNewRecord ? 'Создать' : 'Сохранить'); ?>
</div>

<?php $this->endWidget(); ?>

</div><!-- form -->

<script language="JavaScript" type="text/javascript">
<!--

    function AddItem()
    {
    	var list = document.getElementById('microdistrictList');
    	var related = document.getElementById('Street_microdistricts');
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

    function DeleteItem()
    {
    	var items = document.getElementById('Street_microdistricts');
		items.options[items.selectedIndex] = null;
    }
    
    function SubmitForm()
    {
       	var related = document.getElementById('Street_microdistricts');
    	for (var i = 0; i < related.length; i++)
    		related.options[i].selected = true;

    	return true;
    }

//-->
</script>
<noscript><p><b>Javascript must be enabled to use this form.</b></p></noscript>
