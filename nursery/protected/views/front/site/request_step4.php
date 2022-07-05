<?php $this->pageTitle=Yii::app()->name; ?>

<h1>Заполнение заявления</h1>
<div class="bar">&nbsp;</div>
<h3>
Шаг 1: данные о ребёнке<br>
Шаг 2: данные о заявителе<br>
Шаг 3: контактная информация<br>
<b>Шаг 4: дополнительная информация</b><br>
Шаг 5: информация о льготах<br>
Шаг 6: предпочитаемые МДОУ<br>
</h3>
<br>
<b>
На данном этапе заполнения заявления Вы можете указать информацию о другом родителе (законном представителе).
</b>
<br>

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'parents-form',
	'action' => Yii::app()->request->baseUrl."/site/request",
	'enableAjaxValidation'=>false,
)); ?>

<input type=hidden name=step value="4" />
<input type=hidden name=fromform value="4" />
<input type=hidden name=id value="<?php echo $model->id; ?>" />

<?php if ($form->errorSummary($mother)): ?>
<br/>
<div class="our_error">
<b><?php echo $form->errorSummary($mother); ?></b>
</div>
<br/>
<?php endif; ?>

<?php if (!$model->isApplicantMother()) : ?>
<input name="motherinfochecked" type=checkbox id="motherinfocheckbox" <?php if (isset($motherinfochecked) && $motherinfochecked == "on") echo "CHECKED"; ?> onClick="ToggleDiv('motherinfo');" />Заполнить информацию о матери<br><br/>
<div id="motherinfo">

Пункты, отмеченные <b>*</b>, являются обязательными для заполнения.
<table border=0 cellpadding=6 cellspacing=0 class="zvl_border">
<tr>
	<td colspan="2" bgcolor="#d6d4d2" class="zvl">
		Сведения о родителе или законном представителе
	</td>
</tr>
<tr>
	<td align="right" class="zvl2">
	<?php echo $form->labelEx($mother,'[mother]surname'); ?>
	</td>
	<td class="zvl2">
	<?php echo $form->textField($mother,'[mother]surname',array('size'=>50,'maxlength'=>50)); ?>
	</td>
</tr>
<tr>
	<td align="right" class="zvl2">
	<?php echo $form->labelEx($mother,'[mother]name'); ?>
	</td>
	<td class="zvl2">
	<?php echo $form->textField($mother,'[mother]name',array('size'=>50,'maxlength'=>50)); ?>
	</td>
</tr>
<tr>
	<td align="right" class="zvl2">
	<?php echo $form->labelEx($mother,'[mother]patronymic'); ?>
	</td>
	<td class="zvl2">
	<?php echo $form->textField($mother,'[mother]patronymic',array('size'=>50,'maxlength'=>50)); ?>
	</td>
</tr>
<tr>
	<td align="right" class="zvl2">
	<?php echo $form->labelEx($mother,'[mother]work_place'); ?>
	</td>
	<td class="zvl2">
	<?php echo $form->textField($mother,'[mother]work_place',array('size'=>50,'maxlength'=>100)); ?>
	</td>
</tr>
<tr>
	<td align="right" class="zvl2">
	<?php echo $form->labelEx($mother,'[mother]work_post'); ?>
	</td>
	<td class="zvl2">
	<?php echo $form->textField($mother,'[mother]work_post',array('size'=>50,'maxlength'=>50)); ?>
	</td>
</tr>
<tr>
	<td align="right" class="zvl2">
	<?php echo $form->labelEx($mother,'[mother]phone'); ?>
	</td>
	<td class="zvl2">
	<?php echo $form->textField($mother,'[mother]phone',array('size'=>50,'maxlength'=>50)); ?>
	</td>
</tr>
<tr><td class="zvl2">&nbsp;</td><td class="zvl2">&nbsp;</td></tr>
</table>

</div>
<?php endif; ?>
<br><br>

<?php if ($form->errorSummary($father)): ?>
<br/>
<div class="our_error">
<b><?php echo $form->errorSummary($father); ?></b>
</div>
<br/>
<?php endif; ?>

<?php if (!$model->isApplicantFather()) : ?>
<input name="fatherinfochecked" type=checkbox id="fatherinfocheckbox" <?php if (isset($fatherinfochecked) && $fatherinfochecked == "on") echo "CHECKED"; ?> onClick="ToggleDiv('fatherinfo');" />Заполнить информацию об отце<br><br/>
<div id="fatherinfo">
Пункты, отмеченные <b>*</b>, являются обязательными для заполнения.
<table border=0 cellpadding=6 cellspacing=0 class="zvl_border">
<tr>
	<td colspan="2" bgcolor="#d6d4d2" class="zvl">
		Сведения о родителе или законном представителе
	</td>
</tr>
<tr>
	<td align="right" class="zvl2">
	<?php echo $form->labelEx($father,'[father]surname'); ?>
	</td>
	<td class="zvl2">
	<?php echo $form->textField($father,'[father]surname',array('size'=>50,'maxlength'=>50)); ?>
	</td>
</tr>
<tr>
	<td align="right" class="zvl2">
	<?php echo $form->labelEx($father,'[father]name'); ?>
	</td>
	<td class="zvl2">
	<?php echo $form->textField($father,'[father]name',array('size'=>50,'maxlength'=>50)); ?>
	</td>
</tr>
<tr>
	<td align="right" class="zvl2">
	<?php echo $form->labelEx($father,'[father]patronymic'); ?>
	</td>
	<td class="zvl2">
	<?php echo $form->textField($father,'[father]patronymic',array('size'=>50,'maxlength'=>50)); ?>
	</td>
</tr>
<tr>
	<td align="right" class="zvl2">
	<?php echo $form->labelEx($father,'[father]work_place'); ?>
	</td>
	<td class="zvl2">
	<?php echo $form->textField($father,'[father]work_place',array('size'=>50,'maxlength'=>100)); ?>
	</td>
</tr>
<tr>
	<td align="right" class="zvl2">
	<?php echo $form->labelEx($father,'[father]work_post'); ?>
	</td>
	<td class="zvl2">
	<?php echo $form->textField($father,'[father]work_post',array('size'=>50,'maxlength'=>50)); ?>
	</td>
</tr>
<tr>
	<td align="right" class="zvl2">
	<?php echo $form->labelEx($father,'[father]phone'); ?>
	</td>
	<td class="zvl2">
	<?php echo $form->textField($father,'[father]phone',array('size'=>50,'maxlength'=>50)); ?>
	</td>
</tr>
<tr><td class="zvl2">&nbsp;</td><td class="zvl2">&nbsp;</td></tr>
</table>

</div>
<?php endif; ?>
<br/><br/>

<table border=0 cellpadding=0 cellspacing=0 width="100%">
<tr><td colspan="2"><div class="bar">&nbsp;</div></td></tr>
<tr>
<td align="left" valign="bottom" style="vertical-align:bottom;">
	<a href="<?php echo Yii::app()->request->baseUrl; ?>/site/request?step=3&returnback=1&id=<?php echo $model->id; ?>">
	<img src="<?php echo Yii::app()->request->baseUrl; ?>/images/front/back.gif" align="absmiddle" style="border:0px;">
	</a>
</td>
<td align="right" valign="bottom"  style="vertical-align:bottom;">
	<INPUT TYPE="image" SRC="<?php echo Yii::app()->request->baseUrl; ?>/images/front/more2.gif" ALIGN="absmiddle">
</td>
</tr>
</table>

<?php $this->endWidget(); ?>

<script type="text/javascript">
function ToggleDiv(name)
{
	var cb = document.getElementById(name + "checkbox");
	if (cb == null) return;
	if (cb.checked)
	{
		document.getElementById(name).style.display = "inline";
	}
	else
	{
		document.getElementById(name).style.display = "none";
	}
}

ToggleDiv('motherinfo');
ToggleDiv('fatherinfo');

</script>