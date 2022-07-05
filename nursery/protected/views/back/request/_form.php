<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'request-form',
	'enableAjaxValidation'=>false,
	'htmlOptions'=> array('onSubmit'=>'SubmitForm(); return true;'),
)); ?>

<?php
	//date format is set from i18n defaults, override it here
	//$js = "jQuery.datepicker.regional['ru'].dateFormat = 'dd.mm.yyyy';";
	$js = "jQuery.datepicker.setDefaults(jQuery.datepicker.regional['ru']);";
	Yii::app()->getClientScript()->registerScript('setDateFormat', $js);
?>

	<?php if (!$model->isNewRecord): ?>
		<?php $this->renderPartial('_summaryform', array('form'=>$form, 'model'=>$model)); ?>
	<?php endif; ?>
	
	<p class="note">Поля, отмеченные <span class="required">*</span>, обязательны для заполнения.</p>
	
	<?php echo $form->errorSummary($model, 'Необходимо исправить следующие ошибки в данных заявления:'); ?>
	<?php //if (!$model->isNewRecord) 
		if (isset($model->applicant))
			echo $form->errorSummary($model->applicant, 'Необходимо исправить следующие ошибки в данных заявителя:');
	?>

	<?php
		$tabs = array(
			'Ребенок'=>array('content' => $this->renderPartial('tabs/_info', array('form'=>$form, 'model'=>$model), true, false), 'id'=>'tab1'),
		);
		if ($model->isNewRecord) {
			$tabs = array_merge($tabs, array(
				'Заявитель'=>array('content' => $this->renderPartial('tabs/_applicant', array('form'=>$form, 'model'=>$model), true, false), 'id'=>'tab2'),
			));
		}
		else {
			$tabs = array_merge($tabs, array(
				'Адрес'=>array('content' => $this->renderPartial('tabs/_place', array('form'=>$form, 'model'=>$model), true, false), 'id'=>'tab3'),
				'Контакты'=>array('content' => $this->renderPartial('tabs/_contact', array('form'=>$form, 'model'=>$model), true, false), 'id'=>'tab4'),
				'Льготы'=>array('content' => $this->renderPartial('tabs/_privilege', array('form'=>$form, 'model'=>$model), true, true), 'id'=>'tab5'),
				'Родители'=>array('content' => $this->renderPartial('tabs/_parents', array('form'=>$form, 'model'=>$model), true, false), 'id'=>'tab6'),
				'Требования'=>array('content' => $this->renderPartial('tabs/_requirements', array('form'=>$form, 'model'=>$model), true, false), 'id'=>'tab7'),
				'Направления'=>array('content' => $this->renderPartial('tabs/_directionList', array('form'=>$form, 'model'=>$model), true, false), 'id'=>'tab8'),
				'Похожие'=>array('content' => $this->renderPartial('tabs/_similar', array('form'=>$form, 'model'=>$model), true, false), 'id'=>'tab9'),
//				'Дополнительно'=>array('content' => $this->renderPartial('tabs/_print', array('form'=>$form, 'model'=>$model), true, false), 'id'=>'tab10'),
			));
		}
	?>

	<?php $this->widget('zii.widgets.jui.CJuiTabs', array(
		'theme'=>'cupertino',
		'themeUrl'=>Yii::app()->request->baseUrl.'/css/jui',
		'cssFile'=>'jquery-ui.css',
		'tabs'=>$tabs,
		// additional options
//		'options'=>array(
//			'collapsible'=>true,
//		),
		'htmlOptions'=>array(
			'id'=>'tabs'
		),
	));	?>
	
	<div class="row buttons">
		<?php if ($model->isNewRecord): ?>
			<?php echo CHtml::submitButton('Сохранить'); ?>
		<?php else: ?>
			<?php echo CHtml::submitButton($model->status == (Request::STATUS_UNPROCESSED && !$model->is_internet) ? 'Зарегистрировать' : 'Сохранить'); ?>
		<?php endif; ?>
	</div>

<?php $this->endWidget(); ?>
</div><!-- form -->

<script language="JavaScript" type="text/javascript">
<!--
	function SubmitForm()
	{
		var html = "";
		for (var i in nurseries) {
			var nid = nurseries[i];
			html += '<input type="hidden" name="Request[nurseries][]" value="' + nid + '"/>';
		}
		
		document.getElementById("nursery_hidden").innerHTML = html;
	}
	
//-->
</script>
<noscript><p><b>Javascript must be enabled to use this form.</b></p></noscript>
