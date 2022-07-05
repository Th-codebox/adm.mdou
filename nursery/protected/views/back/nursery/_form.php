
<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'nursery-form',
	'enableAjaxValidation'=>false,
	'htmlOptions'=> array('enctype' =>'multipart/form-data', 'onSubmit'=>'return SubmitForm();'),
)); ?>

<?php if (!$model->isNewRecord): ?>
	<?php $this->renderPartial('_summaryform', array('form'=>$form, 'model'=>$model)); ?>
<?php endif; ?>

<p class="note">Поля, отмеченные <span class="required">*</span>, обязательны для заполнения.</p>


<?php echo $form->errorSummary($model); ?>

<?php $this->widget('zii.widgets.jui.CJuiTabs', array(
	'theme'=>'cupertino',
	'themeUrl'=>Yii::app()->request->baseUrl.'/css/jui',
	'cssFile'=>'jquery-ui.css',
	'tabs'=>array(
		'Основная информация'=>array('content' => $this->renderPartial('tabs/_info', array('form'=>$form, 'model'=>$model), true, false), 'id'=>'tab1'),
		'Адрес'=>array('content' => $this->renderPartial('tabs/_address', array('form'=>$form, 'model'=>$model), true, false), 'id'=>'tab2'),
		'Руководство'=>array('content' => $this->renderPartial('tabs/_head', array('form'=>$form, 'model'=>$model), true, false), 'id'=>'tab3'),
		'Места'=>array('content' => $this->renderPartial('tabs/_room', array('form'=>$form, 'model'=>$model), true, false), 'id'=>'tab4'),
		'Специализации'=>array('content' => $this->renderPartial('tabs/_diseases', array('form'=>$form, 'model'=>$model), true, false), 'id'=>'tab5'),
	),
		// additional options
//		'options'=>array(
//			'collapsible'=>true,
//		),
	'htmlOptions'=>array(
		'id'=>'tabs'
	),
));	?>

<div class="row buttons">
	<?php echo CHtml::submitButton($model->isNewRecord ? 'Создать' : 'Сохранить'); ?>
</div>

<?php $this->endWidget(); ?>

</div><!-- form -->

<script language="JavaScript" type="text/javascript">
<!--

    function AddItem(refCode)
    {
    	var list = document.getElementById(refCode + 'List');
    	var related = document.getElementById('Nursery_' + refCode + 's');
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
    	var items = document.getElementById('Nursery_' + refCode + 's');
		items.options[items.selectedIndex] = null;
    }
    
    function SubmitForm()
    {
       	var related = document.getElementById('Nursery_diseases');
    	for (var i = 0; i < related.length; i++)
    		related.options[i].selected = true;

    	return true;
    }

//-->
</script>
<noscript><p><b>Javascript must be enabled to use this form.</b></p></noscript>
