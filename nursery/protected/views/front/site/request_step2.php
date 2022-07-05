<?php $this->pageTitle=Yii::app()->name; ?>

<h1>Заполнение заявления</h1>
<div class="bar">&nbsp;</div>
<h3>
Шаг 1: данные о ребёнке<br>
<b>Шаг 2: данные о заявителе</b><br>
Шаг 3: контактная информация<br>
Шаг 4: дополнительная информация<br>
Шаг 5: информация о льготах<br>
Шаг 6: предпочитаемые МДОУ<br>
</h3>

<br>
<b>Документы, удостоверяющие личность заявителя, должны соответствовать требованиям законодательства Российской Федерации.
Заявителем может быть один из родителей (законных представителей) ребенка.
</b>
<br><br>
<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'request-form',
	'action' => Yii::app()->request->baseUrl."/site/request",
	'enableAjaxValidation'=>false,
)); ?>

<input type=hidden name=step value="2" />
<input type=hidden name=fromform value="2" />
<input type=hidden name=id value="<?php echo $model->id; ?>" />

<?php if ($form->errorSummary($requester)): ?>
<br/>
<div class="our_error">
<b><?php echo $form->errorSummary($requester); ?></b>
</div>
<?php endif; ?>
<br/>

Пункты, отмеченные <b>*</b>, являются обязательными для заполнения.
<table border=0 cellpadding=3 cellspacing=0 class="zvl_border">
<tr>
	<td colspan="2" bgcolor="#d6d4d2" class="zvl">
		Данные о заявителе
	</td>
</tr>

<tr>
	<td align="right" class="zvl2">
	<?php echo $form->labelEx($requester,'surname'); ?>
	</td>
	<td class="zvl2">
	<?php echo $form->textField($requester,'surname',array('size'=>50,'maxlength'=>50)); ?>
	</td>
</tr>
<tr>
	<td align="right" class="zvl2">
	<?php echo $form->labelEx($requester,'name'); ?>
	</td>
	<td class="zvl2">
	<?php echo $form->textField($requester,'name',array('size'=>50,'maxlength'=>50)); ?>
	</td>
</tr>
<tr>
	<td align="right" class="zvl2">
	<?php echo $form->labelEx($requester,'patronymic'); ?>
	</td>
	<td class="zvl2">
	<?php echo $form->textField($requester,'patronymic',array('size'=>50,'maxlength'=>50)); ?>
	</td>
</tr>
<tr>
	<td align="right" class="zvl2">
	<?php echo $form->labelEx($requester,'work_place'); ?>
	</td>
	<td class="zvl2">
	<?php echo $form->textField($requester,'work_place',array('size'=>50,'maxlength'=>100)); ?>
	</td>
</tr>
<tr>
	<td align="right" class="zvl2">
	<?php echo $form->labelEx($requester,'work_post'); ?>
	</td>
	<td class="zvl2">
	<?php echo $form->textField($requester,'work_post',array('size'=>50,'maxlength'=>50)); ?>
	</td>
</tr>
<tr>
	<td align="right" class="zvl2">
	<?php echo $form->labelEx($requester,'passport_series'); ?>
	</td>
	<td class="zvl2">
	<?php echo $form->textField($requester,'passport_series',array('size'=>10,'maxlength'=>10)); ?>
	</td>
</tr>
<tr>
	<td align="right" class="zvl2">
	<?php echo $form->labelEx($requester,'passport_number'); ?>
	</td>
	<td class="zvl2">
	<?php echo $form->textField($requester,'passport_number',array('size'=>20,'maxlength'=>20)); ?>
	</td>
</tr>
<tr>
	<td align="right" class="zvl2">
	<?php echo $form->labelEx($requester,'passport_issue_data'); ?>
	</td>
	<td class="zvl2">
	<?php echo $form->textField($requester,'passport_issue_data',array('size'=>50,'maxlength'=>255)); ?>
	</td>
</tr>
<tr>
	<td align="right" class="zvl2">
	<?php echo $form->labelEx($requester,'passport_issue_date'); ?>
	</td>
	<td class="zvl2">
	<?php $this->widget('zii.widgets.jui.CJuiDatePicker', array(
	'model'=>$requester,
	'attribute'=>'passport_issue_date',
    	'language'=>'ru',
    	// additional javascript options for the date picker plugin
    	'options'=>array(
        	'showAnim'=>'fold',
        	'changeMonth' => 'true',
        	'changeYear' => 'true',
        	'showButtonPanel' => 'true',
        	'constrainInput' => 'true',
        	'dateFormat' => 'yy-mm-dd',
        	'maxDate' => "+0d",
        	'yearRange'=>'1930:+0'
    	),
    	'htmlOptions'=>array(
    		'style'=>'height:20px;',
			//'readonly'=>'readonly'
		),
	));?>
	</td>
</tr>

<tr>
	<td align="right" class="zvl2">
	<?php echo $form->labelEx($requester,'phone'); ?>
	</td>
	<td class="zvl2">
	<?php echo $form->textField($requester,'phone',array('size'=>50,'maxlength'=>50)); ?>
	</td>
</tr>
<tr>
	<td align="right" class="zvl2">
	<?php echo $form->labelEx($requester,'applicant_type_id'); ?>
	</td>
	<td class="zvl2">
	<?php echo $form->dropDownList($requester, 'applicant_type_id', Person::model()->getTypeOptions()); ?>
	</td>
</tr>
<tr><td class="zvl2">&nbsp;</td><td class="zvl2">&nbsp;</td></tr>
</table>
<br><br>

<table cellpadding="0" cellspacing=0  width="100% border="0" >

<tr><td colspan="2"><div class="bar">&nbsp;</div></td></tr>

<tr>
<td align="left" valign="bottom"  style="vertical-align:bottom;">
	<a href="<?php echo Yii::app()->request->baseUrl; ?>/site/request?step=1&returnback=1&id=<?php echo $model->id; ?>">
	<img src="<?php echo Yii::app()->request->baseUrl; ?>/images/front/back.gif" align="absmiddle" style="border:0px;">
	</a>
</td>
<td align="right" valign="bottom" style="vertical-align:bottom;">
	<INPUT TYPE="image" SRC="<?php echo Yii::app()->request->baseUrl; ?>/images/front/more2.gif" ALIGN="absmiddle">
</td>
</tr>

</table>
<?php $this->endWidget(); ?>