<?php
$this->breadcrumbs=array(
	'Очередь'=>array("request/admin"),
);

$this->menu=array(
	array('label'=>'Create Request', 'url'=>array('create')),
	array('label'=>'Manage Request', 'url'=>array('admin')),
);
?>

<h1>Заявления</h1>
<?php if(Yii::app()->user->hasFlash('requestupdate')): ?>
	<div class="flash_info">
		<b><?php echo Yii::app()->user->getFlash('requestupdate'); ?></b><br/><br/>
	</div>
<?php endif; ?>

<?php //if (array_key_exists('filter', $_GET)):?>
	<?php $this->renderPartial('_filter', array(
		'streets'=>$streets,
		'microdistricts'=>$microdistricts,
		'nurseries'=>$nurseries,
		'privileges'=>$privileges,
		'diseases'=>$diseases,
	));?>
<?php /*else: ?>
	<div align="right"><?php echo CHtml::link("Показать фильтры", array("/request/index&filter=true")); ?></div>
<?php endif; */?>

<?php //echo CHtml::link('Добавить заявление', array('request/create')); ?>
<?php
	Yii::app()->clientScript->registerScriptFile(Yii::app()->request->baseUrl.'/js/previewlinks.js', CClientScript::POS_HEAD);
	
	$this->renderPartial('_indexgrid', array('dataProvider'=>$dataProvider));
?>

<?php $this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id'=>'viewdialog',
    'theme'=>'cupertino',
	'themeUrl'=>Yii::app()->request->baseUrl.'/css/jui',
    // additional javascript options for the dialog plugin
    'options'=>array(
        'title'=>'Просмотр заявления',
        'autoOpen'=>false,
        'draggable'=>true,
        'resizable'=>true,
		'closeOnEscape' => true,
        'modal'=>true,
//		'show'=>'blind',
//		'hide'=>'blind',
		'width'=>'1000px',
		'height'=>'auto',
		'top'=>'50',
		'position'=>'top',
//		'buttons' => array(
//			'Ok'=>'js:function(){alert("ok")}',
//			'Cancel'=>'js:function(){alert("cancel")}',
//		),
    ),
));?>

<div id="preview"></div>

<?php $this->endWidget('zii.widgets.jui.CJuiDialog');?>
