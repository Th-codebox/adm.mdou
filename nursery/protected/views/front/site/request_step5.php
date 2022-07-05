<?php $this->pageTitle=Yii::app()->name; ?>

<h1>Заполнение заявления</h1>
<div class="bar">&nbsp;</div>
<h3>
Шаг 1: данные о ребёнке<br>
Шаг 2: данные о заявителе<br>
Шаг 3: контактная информация<br>
Шаг 4: дополнительная информация<br>
<b>Шаг 5: информация о льготах</b><br>
Шаг 6: предпочитаемые МДОУ<br>
</h3>
<br>
<b>
Родителям (законным представителям) необходимо указать документ, подтверждающий право, предусмотренное законодательством Российской Федерации,
  на внеочередное и первоочередное предоставление места ребенку в детском саду.
</b>
<br><br>

<div class="bar">&nbsp;</div>
<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'request-form',
	'enableAjaxValidation'=>false,
	'method'=>'post',
	'action' => Yii::app()->request->baseUrl."/site/request",
	'htmlOptions' =>array('enctype'=>'multipart/form-data'),
)); ?>


<input type=hidden name=step value="5" />
<input type=hidden name=fromform value="5" />
<input type=hidden name=id value="<?php echo $model->id; ?>" />
<input type=hidden id="addprivilege" name="addprivilege" value="no" />
<br/>

<?php if ($form->errorSummary($model)): ?>
<b><div class="our_error"></b>
<?php echo $form->errorSummary($model); ?>
</div>
<?php endif; ?>
<br/>

<div id="divprivilegedocs">
<table border=0 cellpadding=3 cellspacing=0>
<?php for($i = 0; $i < 2; $i++): ?>
	<tr><td>
	<?php 
		if (isset($model->privilegeDocuments[$i]) && $model->privilegeDocuments[$i]) $pdoc = $model->privilegeDocuments[$i]; 
		else $pdoc = new PrivilegeDocument;
	?>
	<?php if ($i == 0):?>
	<input name="privilege0infochecked" type=checkbox id="privilege0infocheckbox" 
		<?php if (isset($privilege0infochecked) && $privilege0infochecked == "on") echo "CHECKED"; ?> onClick="Privilege0Checked();" />Добавить льготу<br/><br/>
	<?php endif; ?>
	<div id="privilege<?php echo $i; ?>info">
	<?php if ($form->errorSummary($pdoc)): ?>
	<div class="our_error">
	<b><?php echo $form->errorSummary($pdoc); ?></b>
	</div>
	<?php endif; ?>
	
	Пункты, отмеченные <b>*</b>, являются обязательными для заполнения.
	<input type=hidden name="PrivilegeDocument[<?php echo $i; ?>][id]" value="<?php echo $pdoc->id; ?>" />
	<table border=0 cellpadding=3 cellspacing=0 class="zvl_border">
	<tr>
		<td colspan="2" bgcolor="#d6d4d2" class="zvl">
			Документ, подтверждающий право на льготу
		</td>
	</tr>
	<tr>
		<td align="right" class="zvl2">
		<?php echo CHtml::label('Вид льготы:', 'document'); ?>
		</td>
		<td class="zvl2">
		<?php echo $form->dropDownList($pdoc, "[$i]privilege_id", 
					CHtml::listData(Privilege::model()->findAllByAttributes(array('is_active' => 1), array('order'=>'id ASC')),
					'id', 'name'),
					array(
						'ajax'=>array(
							'type'=>'POST', //request type
							'url'=>CController::createUrl('privilege/ajaxDocumentTypes'), //url to call.
							'update'=>'#PrivilegeDocument_'.$i.'_document_type_id', //selector to update
							'data'=>array('privilege_id'=>'js:this.value'),
						),
						'prompt'=>'Выберите вид льготы'
					));?>
		</td>
	</tr>
	<tr>
		<td align="right" class="zvl2">
			<?php echo $form->labelEx($pdoc,"[$i]document_type_id"); ?>
		</td>
		<td class="zvl2">
			<?php echo $form->dropDownList($pdoc,"[$i]document_type_id", 
			CHtml::listData(DocumentType::model()->findAll(array(
				'order'=>'id'
			)), 'id', 'name'),
			array('prompt'=>'Другой', 'style'=>'width: 600px;')
		); ?>
		</td>
	</tr>
	<tr>
		<td align="right" class="zvl2">
		<?php echo $form->labelEx($pdoc,"[$i]name"); ?>
		</td>
		<td class="zvl2">
		<?php echo $form->textField($pdoc,"[$i]name",array('size'=>50,'maxlength'=>255)); ?>
		</td>
	</tr>
	<tr>
		<td align="right" class="zvl2">
		<?php echo $form->labelEx($pdoc, "[$i]issue_date"); ?>
		</td>
		<td class="zvl2">
		<?php $this->widget('zii.widgets.jui.CJuiDatePicker', array(
			'model'=>$pdoc,
			'name'=>"PrivilegeDocument[$i][issue_date]",
			'attribute'=>"issue_date",
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
		<td valign="top" align="right" class="zvl2">
		Электронная копия документа:
		</td>
		<td class="zvl2">
		<input type=file name=File_<?php echo $i; ?>[]>
		</td>
	</tr>
	</table><br/><br/>
	<?php if ($i == 0):?>
	<input name="privilege1infochecked" type=checkbox id="privilege1infocheckbox" 
		<?php if (isset($privilege1infochecked) && $privilege1infochecked == "on") echo "CHECKED"; ?> onClick="ToggleDiv('privilege1info');" />Добавить вторую льготу<br/><br/>
	<?php endif; ?>
	</div>
	</td></tr>
<?php endfor; ?>
</table>
</div>

<br/><br/>
<table border=0 cellpadding=0 cellspacing=0 width="100%">
<tr><td colspan="2"><div class="bar">&nbsp;</div></td></tr>
<tr>
<td align="left" valign="bottom" style="vertical-align:bottom;">
	<a href="<?php echo Yii::app()->request->baseUrl; ?>/site/request?step=4&returnback=1&id=<?php echo $model->id; ?>">
	<img src="<?php echo Yii::app()->request->baseUrl; ?>/images/front/back.gif" align="absmiddle" style="border:0px;">
	</a>
</td>
<td align="right" valign="bottom"  style="vertical-align:bottom;">
	<INPUT TYPE="image" SRC="<?php echo Yii::app()->request->baseUrl; ?>/images/front/more2.gif" ALIGN="absmiddle">
</td>
</tr>
</table>

<?php $this->endWidget(); ?>

<script type="text/javascript" language="javascript">
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

ToggleDiv('privilege0info');
ToggleDiv('privilege1info');

function Privilege0Checked()
{
	ToggleDiv('privilege0info');
	var cb = document.getElementById("privilege1infocheckbox");
	cb.checked = false;
	ToggleDiv('privilege1info');
}

</script>