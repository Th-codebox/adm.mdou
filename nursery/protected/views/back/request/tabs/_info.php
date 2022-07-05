<div id="duplicateRequest"></div>

<div class="row">
	<?php echo $form->labelEx($model,'surname'); ?>
	<?php echo $form->textField($model,'surname',array('size'=>50,'maxlength'=>50)); ?>
	<?php echo $form->error($model,'surname'); ?>
</div>

<div class="row">
	<?php echo $form->labelEx($model,'name'); ?>
	<?php echo $form->textField($model,'name',array('size'=>50,'maxlength'=>50)); ?>
	<?php echo $form->error($model,'name'); ?>
</div>

<div class="row">
	<?php echo $form->labelEx($model,'patronymic'); ?>
	<?php echo $form->textField($model,'patronymic',array('size'=>50,'maxlength'=>50)); ?>
	<?php echo $form->error($model,'patronymic'); ?>
</div>

<div class="row">
	<?php echo $form->labelEx($model,'birth_date'); ?>
	<?php $this->widget('zii.widgets.jui.CJuiDatePicker', array(
    	'model'=>$model,
    	'attribute'=>'birth_date',
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
    	),
    	'htmlOptions'=>array(
    		'style'=>'height:20px;',
			'readonly'=>'readonly'
		),
	));?>
	<?php echo $form->error($model,'birth_date'); ?>
</div>

<div class="row">
	<?php echo $form->labelEx($model,'document_series'); ?>
	<?php echo $form->textField($model,'document_series',array('size'=>10,'maxlength'=>10)); ?>
	<?php echo CHtml::dropDownList('series', '1', array(1=>'I-ГИ', 2=>'I-БД', 3=>'IV-БД'));?>
	<?php echo CHtml::button('Выбрать', array('onClick'=>'document.getElementById("Request_document_series").value=document.getElementById("series").options[document.getElementById("series").selectedIndex].text')); ?>
	<div style="font-size:11px;">Например: I-ГИ или IV-БД</div>
	<?php echo $form->error($model,'document_series'); ?>
</div>

<div class="row">
	<?php echo $form->labelEx($model,'document_number'); ?>
	<?php echo $form->textField($model,'document_number',array(
		'size'=>10,
		'maxlength'=>10, 
		)); ?>

	<?php echo $form->error($model,'document_number'); ?>
</div>

<?php if (count($model->files) > 0): ?>
	<b>Прицепленные файлы</b><br/>
	<div class="row">
		<?php foreach ($model->files as $file):?>
			<?php if ($file->extension == "exe" || $file->extension == "EXE") continue; ?>
			<?php echo CHtml::link(
				CHtml::image(Yii::app()->request->baseUrl."/images/front/appicons/".$file->getFileTypeImage().".png", "", array(
					"width"=>16, "height"=>16, "align"=>"absmiddle", "alt"=>"", "style"=>"margin: 7px 2px 2px 0px;"))."&nbsp;".
				($file->getName() !== "" ? $file->getName() : "файл")." (*.".$file->extension.", ".$file->getSize().")", 
				$file->getHttpPath(), array('target'=>'_blank'));
			?>
		<?php endforeach; ?>
	</div>
	<br/>
<?php endif; ?>

<div class="row">
	<?php echo $form->labelEx($model,'document_date'); ?>
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
			'constrainInput' => 'false',
        	'dateFormat' => 'yy-mm-dd',
			'maxDate' => "+0d"
    	),
    	'htmlOptions'=>array(
    		'style'=>'height:20px;',
			'readonly'=>'readonly'
		),
	));?>
	<?php echo $form->error($model,'document_date'); ?>
</div>

<div class="row">
	<?php echo $form->labelEx($model,'comment'); ?>
	<?php echo $form->textArea($model, 'comment', array('rows'=>'5', 'cols'=>'50')); ?>
	<?php echo $form->error($model,'comment'); ?>
</div>

<script language="JavaScript" type="text/javascript">
<!--
	$('#Request_birth_document').bind('change', findDuplicate);
	
	$('#Request_document_number').bind('keyup', findDuplicate);

	function findDuplicate() {
		$.ajax({
			type: 'POST',
			url: '?r=request/ajaxFindDuplicate&id=<?php echo !$model->isNewRecord ? $model->id : 0;?>',
			data:jQuery(this).parents("form").serialize(),
			success: function(data) {
				$("#duplicateRequest").html(data);
			}
		})
		return false;
	}

-->
</script>
