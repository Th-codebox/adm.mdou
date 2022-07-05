<?php $this->pageTitle=Yii::app()->name; ?>

<h1>Заполнение заявления</h1>
<div class="bar">&nbsp;</div>
<h3>
<b>Шаг 1: данные о ребёнке</b><br>
Шаг 2: данные о заявителе<br>
Шаг 3: контактная информация<br>
Шаг 4: дополнительная информация<br>
Шаг 5: информация о льготах<br>
Шаг 6: предпочитаемые МДОУ<br>
</h3>
<br>
<b>Уважаемые родители (законные представители)! <br>Перед заполнением заявления внимательно ознакомьтесь с <a target="_blank" href="<?php echo Yii::app()->request->baseUrl; ?>/site/section?id=4">правилами постановки ребенка на учет</a></b>.
<br>

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'request-form',
	'enableAjaxValidation'=>false,
	'method'=>'post',
	'action' => Yii::app()->request->baseUrl."/site/request",
	'htmlOptions' =>array('enctype'=>'multipart/form-data'),
)); ?>

<?php
	//date format is set from i18n defaults, override it here
	$js = "jQuery.datepicker.regional['ru'].dateFormat = 'dd.mm.yyyy';";
	Yii::app()->getClientScript()->registerScript('setDateFormat', $js);
?>

<input type=hidden name=step value="1" />
<input type=hidden name=fromform value="1" />
<input type=hidden name=id value="<?php echo $model->id; ?>" />
<br/>

<?php if ($form->errorSummary($model)): ?>
<div class="our_error">
<b><?php echo $form->errorSummary($model); ?></b>
</div>
<?php endif; ?>
<br/>

Пункты, отмеченные <b>*</b>, являются обязательными для заполнения.
<table border="0" cellpadding="3" cellspacing="0" class="zvl_border">
<tr>
	<td colspan="2" bgcolor="#d6d4d2" class="zvl">
		Данные о ребёнке
	</td>
</tr>
<tr>
	<td align="right" class="zvl2">
	<?php echo $form->labelEx($model,'surname'); ?>
	</td>
	<td class="zvl2">
	<?php echo $form->textField($model,'surname',array('size'=>50,'maxlength'=>50)); ?>
	</td>
</tr>
<tr>
	<td align="right" class="zvl2">
	<?php echo $form->labelEx($model,'name'); ?>
	</td>
	<td class="zvl2">
	<?php echo $form->textField($model,'name',array('size'=>50,'maxlength'=>50)); ?>
	</td>
</tr>

<tr>
	<td align="right" class="zvl2">
	<?php echo $form->labelEx($model,'patronymic'); ?>
	</td>
	<td class="zvl2">
	<?php echo $form->textField($model,'patronymic',array('size'=>50,'maxlength'=>50)); ?>
	</td>
</tr>

<tr>
	<td align="right" class="zvl2">
	<?php echo $form->labelEx($model,'birth_date'); ?>
	</td>
	<td class="zvl2">
	<?php $this->widget('zii.widgets.jui.CJuiDatePicker', array(
	'model'=>$model,
	'attribute'=>'birth_date',
    	'language'=>'ru',
    	// additional javascript options for the date picker plugin
    	'options'=>array(
        	'showAnim'=>'fold',
        	'changeMonth' => 'true',
        	'changeYear' => 'true',
        	'showButtonPanel' => 'false',
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
	<?php echo $form->labelEx($model,'document_series'); ?>
	</td>
	<td class="zvl2">
	<?php echo $form->textField($model,'document_series',array('size'=>10,'maxlength'=>10)); ?>
	</td>
</tr>

<tr>
	<td align="right" class="zvl2">
	<?php echo $form->labelEx($model,'document_number'); ?>
	</td>
	<td class="zvl2">
	<?php echo $form->textField($model,'document_number',array('size'=>10,'maxlength'=>10)); ?>
	</td>
</tr>

<tr>
	<td align="right" class="zvl2">
	<?php echo $form->labelEx($model,'document_date'); ?>
	</td>
	<td class="zvl2">
	<?php $this->widget('zii.widgets.jui.CJuiDatePicker', array(
	'model'=>$model,
	'attribute'=>'document_date',
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
	Электронная копия свидетельства о рождении:
	</td>
	<td class="zvl2">
	<input type=file name="birth_document" />
	</td>
</tr>
<tr><td class="zvl2">&nbsp;</td><td class="zvl2">&nbsp;</td></tr>
</table>
<br><br>

<table cellpadding="0" cellspacing=0  width="100% border="0" >

<tr><td colspan="2"><div class="bar">&nbsp;</div></td></tr>

<tr><td colspan="2">
<p align="justify">
Настоящим даю свое согласие Администрации Петрозаводского 
городского округа (находится по адресу: 185910, Республика Карелия, г. Петрозаводск, 
пр. Ленина, 2) на обработку (сбор, систематизацию, хранение, уточнение, использование) 
на бумажном и электронном носителях с обеспечением конфиденциальности моих
персональных данных и персональных данных моего ребенка, сообщаемых мною в
настоящем заявлении и содержащихся в прилагаемых к данному заявлению документах
(копиях документов), в целях осуществления учета моего ребенка (детей) в единой
городской очереди по устройству детей в МДОУ на период до зачисления моего
ребенка (детей) в МДОУ (иное образовательное учреждение) или до отзыва мною
своего заявления и данного согласия.</p>
<h1><?php echo $form->checkBox($model,'agreement'); ?> Подтверждаю</h1>
</td></tr>

<tr><td colspan="2"><div class="bar">&nbsp;</div></td></tr>
<tr>
<td colspan="2">

<table border=0 cellpadding=5 cellspacing=0>
<tr><td>
<?php $this->widget('CCaptcha', array('captchaAction' => 'site/captcha', 'buttonLabel'=>'', 'imageOptions'=>array('style'=>'border:1px solid #2040a0;'))); ?>
</td><td><a id="yt0" href="#">[Обновить картинку]</a></td><tr>
<tr><td>
<br/>
Введите, пожалуйста, буквы,<br/>
которые Вы видите на картинке.
</td><td>
<?php echo $form->textField($model, 'verify_code'); ?>
</td>
</tr>
</table>

</td>
</tr>
<tr><td></td>
<td align="right" valign="bottom" style="vertical-align:text-bottom; float:bottom;">
	<INPUT TYPE="image" SRC="<?php echo Yii::app()->request->baseUrl; ?>/images/front/more2.gif" ALIGN="absmiddle">
</td>
</tr>

</table>

<?php $this->endWidget(); ?>