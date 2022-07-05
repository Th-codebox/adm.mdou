<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'node-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Поля, помеченные <span class="required">*</span>, должны быть заполнены.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'name'); ?>
		<?php echo $form->textField($model,'name',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'name'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'description'); ?>
		<!--php echo $form->textArea($model,'description',array('rows'=>6, 'cols'=>50)); -->
		<?php $this->widget('application.extensions.fckeditor.FCKEditorWidget',array(
			'model'     =>  $model,
			'attribute' => 'description',
			'height'    => '350px',
			'width'     => '800px',
			'toolbarSet'=> 'Basic',
			'fckeditor' =>  dirname(Yii::app()->basePath).'/js/editor/fckeditor.php',
			'fckBasePath' => Yii::app()->baseUrl.'/js/editor/')
		); ?>
		
		<?php echo $form->error($model,'description'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'text'); ?>
		<?php $this->widget('application.extensions.fckeditor.FCKEditorWidget',array(
			'model'     =>  $model,
			'attribute' => 'text',
			'height'    => '350px',
			'width'     => '800px',
			'toolbarSet'=> 'Basic',
			'fckeditor' =>  dirname(Yii::app()->basePath).'/js/editor/fckeditor.php',
			'fckBasePath' => Yii::app()->baseUrl.'/js/editor/')
		); ?>
		
		<!--php echo $form->textArea($model,'text',array('rows'=>6, 'cols'=>50)); -->
		<?php echo $form->error($model,'text'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'type'); ?>
		<?php echo $form->dropDownList($model, 'type', array(
		    'section' => 'обычный раздел',
		    'url' => 'ссылка на ресурс в интернете',
		    'link' => 'ссылка на раздел сайта')
		);?>
		<?php echo $form->textField($model,'url',array('size'=>20,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'type'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'is_new_window'); ?>
		<?php echo $form->checkBox($model,'is_new_window'); ?>
		<?php echo $form->error($model,'is_new_window'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'is_show_front'); ?>
		<?php echo $form->checkBox($model,'is_show_front'); ?>
		<?php echo $form->error($model,'is_show_front'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'is_show_children'); ?>
		<?php echo $form->checkBox($model,'is_show_children'); ?>
		<?php echo $form->error($model,'is_show_children'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'status_id'); ?>
		<?php echo $form->dropDownList($model, 'status_id', array(
		    '0' => 'неактивный', '1' => 'активный')
		);?>
		<?php echo $form->error($model,'status_id'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Создать' : 'Сохранить'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->
<script language="JavaScript" type="text/javascript">
<!--

    function FCKeditor_OnComplete( editorInstance )
    {
		editorInstance.Config['ImageBrowserURL'] = '/backend.php?r=photo/browse&object=node&object_id=<?php echo $model->id; ?>';
    }

	function ShowTree()
	{
		var treeDiv = document.getElementById('treeDiv');
		treeDiv.style.display = 'block';
	}

	function SetParentId(id, name)
	{
		var parentId = document.getElementById('Node_parentId');
		parentId.value = id;
		var parentName = document.getElementById('parentName');
		parentName.innerHTML = name;
		var treeDiv = document.getElementById('treeDiv');
		treeDiv.style.display = 'none';
	}

//-->
</script>
<noscript><p><b>Javascript must be enabled to use this form.</b></p></noscript>
