<?php $this->pageTitle=Yii::app()->name; ?>

<h1>Заполнение заявления</h1>
<div class="bar">&nbsp;</div>
<h3>
Шаг 1: данные о ребёнке<br>
Шаг 2: данные о заявителе<br>
Шаг 3: контактная информация<br>
Шаг 4: дополнительная информация<br>
Шаг 5: информация о льготах<br>
<b>Шаг 6: предпочитаемые МДОУ</b><br>
</h3>
<div class="bar">&nbsp;</div>
Выберите предпочитаемые МДОУ из списка (не более трех):<br /><br />
<?php $form = $this->beginWidget('CActiveForm', array(
	'id'=>'request-form',
	'enableAjaxValidation'=>false,
	'action' => Yii::app()->request->baseUrl."/site/request",
	'htmlOptions'=> array('enctype' =>'multipart/form-data', 'onSubmit'=>'return SubmitForm();'),
)); ?>

<input type=hidden name=step value="6" />
<input type=hidden name=fromform value="6" />
<input type=hidden name=id value="<?php echo $model->id; ?>" />

<?php $this->renderPartial("_nurseries_list", array("model" => $model, "form" => $form)); ?><br/><br/>

<table border=0 cellpadding=0 cellspacing=0 width="100%">
<tr><td colspan="2"><div class="bar">&nbsp;</div></td></tr>
<tr>
<td align="left" valign="bottom" colspan="2"  style="vertical-align:bottom;">
	<a href="<?php echo Yii::app()->request->baseUrl; ?>/site/request?step=5&returnback=1&id=<?php echo $model->id; ?>">
	<img src="<?php echo Yii::app()->request->baseUrl; ?>/images/front/back.gif" align="absmiddle" style="border:0px;">
	</a>
</td>
<td align="right" valign="bottom"  style="vertical-align:bottom;">
	<INPUT TYPE="image" SRC="<?php echo Yii::app()->request->baseUrl; ?>/images/front/more2.gif" ALIGN="absmiddle">
</td>
</tr>
</table>

<?php $this->endWidget(); ?>