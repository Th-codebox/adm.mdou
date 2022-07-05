<?php $this->pageTitle=Yii::app()->name; ?>

<h1>Заполнение заявления</h1>
<div class="bar">&nbsp;</div>
<h3>
Шаг 1: данные о ребёнке<br>
Шаг 2: данные о заявителе<br>
<b>Шаг 3: контактная информация</b><br>
Шаг 4: дополнительная информация<br>
Шаг 5: информация о льготах<br>
Шаг 6: предпочитаемые МДОУ<br>
</h3>

<br>
<b>
Для упрощения взаимодействия в процессе предоставления места в МДОУ укажите дополнительную контактную информацию (адрес проживания заявителя,
дополнительный телефон для связи, адрес электронной почты).
</b>
<br><br>

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'request-form',
	'action' => Yii::app()->request->baseUrl."/site/request",
	'enableAjaxValidation'=>false,
)); ?>

<input type=hidden name=step value="3" />
<input type=hidden name=fromform value="3" />
<input type=hidden name=id value="<?php echo $model->id; ?>" />
<br/>

<?php if ($form->errorSummary($model)): ?>
<div class="our_error">
<b><?php echo $form->errorSummary($model); ?></b>
</div>
<?php endif; ?>
<br/>

Пункты, отмеченные <b>*</b>, являются обязательными для заполнения.
<?php $this->renderPartial("_address", array('form' => $form, 'model' => $model)); ?><br/><br/>

<table border=0 cellpadding=0 cellspacing=0 width="100%">
<tr><td colspan="2"><div class="bar">&nbsp;</div></td></tr>
<tr>
<td align="left" valign="bottom"style="vertical-align:bottom;">
	<a href="<?php echo Yii::app()->request->baseUrl; ?>/site/request?step=2&returnback=1&id=<?php echo $model->id; ?>">
	<img src="<?php echo Yii::app()->request->baseUrl; ?>/images/front/back.gif" align="absmiddle" style="border:0px;">
	</a>
</td>
<td align="right" valign="bottom"  style="vertical-align:bottom;">
	<INPUT TYPE="image" SRC="<?php echo Yii::app()->request->baseUrl; ?>/images/front/more2.gif" ALIGN="absmiddle">
</td>
</tr>
</table>

<?php $this->endWidget(); ?>
