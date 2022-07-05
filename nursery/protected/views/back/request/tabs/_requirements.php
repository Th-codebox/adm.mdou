<div class="row">
	<?php echo $form->labelEx($model,'disease_id'); ?>
	<?php echo $form->dropDownList($model, 'disease_id',
		CHtml::listData(Disease::model()->findAll(array('order'=>'name ASC')),
		'id', 'Name'), array('prompt'=>''));?>
	<?php echo $form->error($model,'disease_id'); ?>
</div>

<?php // the link that may open the dialog
	echo CHtml::link('Добавить МДОУ', '#', array(
   		'onclick'=>'$("#requirementdialog").dialog("open"); return false;',
	));
?>

<div class="row" id="nursery_tab">
	<div id="nursery_div"></div>
	<div id="nursery_hidden" style="display: none;"></div>
</div>

<script language="JavaScript" type="text/javascript">
<!--
	var nurseries = new Array();
	var nurseries_all = new Array();
    
    function BuildNurseryTable(html)
    {
    	html = "";

		for (var i in nurseries) {
			nid = nurseries[i];
    		var item = nurseries_all[nid];
    	    html += "<tr><td>" + nid + "</td><td>" + item.name + "</td><td>" + item.address + "</td>";
    	    
    	    html += "<td><a href='javascript:void(0);' title='Удалить' onClick='RemoveNursery(" + nid + "); return false;'><img src='<?php echo Yii::app()->request->baseUrl;?>/images/backend/page_white_delete.png' border='0'></a></td></tr>";
    	}
		var table = "";
		if (html.length > 0) {
			table += "<table cellpadding='3' cellspacing='4' border='1' class='border_table'>";
			table += "<tr><th>ID</th><th>МДОУ</th><th>Адрес</th><th>&nbsp;</th></tr>";
			table += html + "</table>";
		}
    	
		var obj = document.getElementById('nursery_div');
		obj.innerHTML = table;
    }

    function AddNursery()
    {
    	var nid = document.getElementById('Requirement_nursery_id').value;
    	for (var i in nurseries) {
    		id = nurseries[i];
    		if (nid == id) {
    			alert('Выбранный МДОУ уже присутствует в списке');
    			return;
    		}
    	}
		nurseries.push(nid);
		BuildNurseryTable();
    }
    
    function RemoveNursery(nid)
    {
    	if (confirm('Вы уверены, что хотите удалить МДОУ из списка?')) {
			for (var i in nurseries) {
    			var id = nurseries[i];
    			if (nid == id) {
    				nurseries.splice(i, 1);
    				BuildNurseryTable();
    				return;    				
    			}
    		}
    	}
    }

	<?php if (count($model->nurseries) > 0): ?>
		<?php foreach ($model->nurseries as $nursery): ?>
			nurseries.push(<?php echo $nursery->id; ?>);
		<?php endforeach; ?>
	<?php endif; ?>

	<?php foreach(Nursery::model()->findAll() as $nursery): ?>
		    var item = new Array();
		    item.name = '<?php echo $nursery->getName(); ?>';
		    item.address = '<?php echo $nursery->getAddress(); ?>';
		    item.short_number = '<?php echo $nursery->short_number; ?>';
		    nurseries_all[<?php echo $nursery->id; ?>] = item;
	<?php endforeach; ?>

	BuildNurseryTable();	//'
	
//-->
</script>
<noscript><p><b>Javascript must be enabled to use this form.</b></p></noscript>

<?php $this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id'=>'requirementdialog',
    'theme'=>'cupertino',
	'themeUrl'=>Yii::app()->request->baseUrl.'/css/jui',
    // additional javascript options for the dialog plugin
    'options'=>array(
        'title'=>'Добавление МДОУ',
        'autoOpen'=>false,
        'draggable'=>true,
        'resizable'=>true,
		'closeOnEscape' => true,
        'modal'=>true,
		'show'=>'slide',
		'hide'=>'slide',
		'width'=>'auto',
		'buttons' => array(
			'Добавить'=>'js:function(){AddNursery()}',
			'Закрыть'=>'js:function(){ $(this).dialog("close"); }',
		),
    ),
));?>

<div class="row">
	<?php echo CHtml::label('Специализация', 'Requirement_disease_id'); ?><br/>
	<?php echo CHtml::dropDownList('Requirement_disease_id', 0,
		CHtml::listData(Disease::model()->findAll(array('order'=>'name ASC')), 'id', 'name'),
		array(
			'prompt'=>'Не выбрана',
			'ajax'=>array(
				'type'=>'POST', //request type
				'url'=>CController::createUrl('nursery/ajaxNurseries'), //url to call.
				//Style: CController::createUrl('currentController/methodToCall')
				'update'=>'#Requirement_nursery_id', //selector to update
				'data'=>array('disease_id'=>'js:this.value', 'microdistrict_id'=>'js:document.getElementById("Requirement_microdistrict_id").value'),
				//leave out the data key to pass all form values through
			)
		));?>
		<br/><br/>
</div>

<div class="row">
	<?php echo CHtml::label('Район', 'Requirement_microdistrict_id'); ?><br/>
	<?php echo CHtml::dropDownList('Requirement_microdistrict_id', 0,
		CHtml::listData(Microdistrict::model()->findAll(array('order'=>'name ASC')), 'id', 'name'),
		array(
			'prompt'=>'Любой',
			'ajax'=>array(
				'type'=>'POST', //request type
				'url'=>CController::createUrl('nursery/ajaxNurseries'), //url to call.
				//Style: CController::createUrl('currentController/methodToCall')
				'update'=>'#Requirement_nursery_id', //selector to update
				'data'=>array('microdistrict_id'=>'js:this.value', 'disease_id'=>'js:document.getElementById("Requirement_disease_id").value'),
				//leave out the data key to pass all form values through
			)
		));?>
		<br/><br/>
</div>

<div class="row">
	<?php echo CHtml::label('Список МДОУ', 'nurseries'); ?><br/>
	<?php echo CHtml::dropDownList('Requirement_nursery_id', '0', 
		CHtml::listData(Nursery::model()->findAll(array('order'=>'short_number ASC')),
			'id', 'name'));?><br/><br/>
</div>

<?php $this->endWidget('zii.widgets.jui.CJuiDialog'); ?>
