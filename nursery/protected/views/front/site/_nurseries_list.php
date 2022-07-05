<br>
<table border=0 cellpadding=3 cellspacing=0>
<tr>
<td>
Выберите специализацию (только при наличии показаний)
<?php echo $form->dropDownList($model, 'disease_id',
	CHtml::listData(Disease::model()->findAll(array('order'=>'name ASC')), 'id', 'name'),
	array(
		'prompt'=>'',
		'ajax'=>array(
			'type'=>'POST', //request type
			'url'=>CController::createUrl('site/ajaxNurseries'), //url to call.
			//Style: CController::createUrl('currentController/methodToCall')
			'update'=>'#nurseryList', //selector to update
			'data'=>array('disease_id'=>'js:this.value', 'microdistrict_id'=>'js:document.getElementById("microdistrictList").value'),
			//leave out the data key to pass all form values through
		)
));?>
</td>
<td>
</td>
<td>
Выберите микрорайон
<?php echo CHtml::dropDownList('microdistrictList', 0, 
CHtml::listData(Microdistrict::model()->findAll(array(
	'order'=>'name ASC')),
	'id', 'name'),
	array(
		'prompt'=>'Любой',
		'ajax'=>array(
			'type'=>'POST', //request type
			'url'=>CController::createUrl('site/ajaxNurseries'), //url to call.
			//Style: CController::createUrl('currentController/methodToCall')
			'update'=>'#nurseryList', //selector to update
			'data'=>array('microdistrict_id'=>'js:this.value', 'disease_id'=>'js:document.getElementById("Request_disease_id").value'),
			//'data'=>'js:javascript statement' 
			//leave out the data key to pass all form values through
		)
));?>
</td>
</tr>
<tr>
<td colspan=3>&nbsp;</td>
</tr>
<tr>
<td>
	<b>Выбранные МДОУ</b><br/><br/>
	<?php echo $form->dropDownList($model, 'nurseries', CHtml::listData($model->nurseries, 'id', 'name'),
		array('size' => 10, 'style' => 'width: 300px;', 'multiple'=>'multiple'));?>
	<br/>
</td>
<td valign="middle">
	<img src="<?php echo Yii::app()->request->baseUrl; ?>/images/front/minus.gif" onClick="DeleteNursery();">
	<br/><br/>
	<img src="<?php echo Yii::app()->request->baseUrl; ?>/images/front/add.gif" onClick="AddNursery();">
</td>
<td>
	<b>Список МДОУ</b><br/><br/>
	<?php echo CHtml::dropDownList('nurseryList', '0', 
		CHtml::listData(Nursery::model()->findAll(array('order'=>'short_number ASC')),
			'id', 'name'), array('size' => 10, 'style' => 'width: 300px;'));?>
</td>
</tr>
</table>

<script language="JavaScript" type="text/javascript">
<!--

    function AddNursery()
    {
    	var list = document.getElementById('nurseryList');
    	var related = document.getElementById('Request_nurseries');
		var cnt = 0;
       	for (var i = 0; i < related.length; i++)
       		cnt++;
       	if (cnt >= 3) {
       		alert('Нельзя выбирать больше трех МДОУ');
       		return;
       	}
    	var item = list.options[list.selectedIndex];
    	var index = -1;
    	for (var i = 0; i < related.length; i++)
    		if (related.options[i].value == item.value) {
    			index = i;
    			break;
    		}
    	if (index >= 0)
    		alert('Элемент уже содержится в списке выбранных');
		else {
			related.options[related.length] = new Option(item.text, item.value);
    	}
    }

    function DeleteNursery()
    {
    	var items = document.getElementById('Request_nurseries');
		items.options[items.selectedIndex] = null;
    }
    
    function SubmitForm()
    {
       	var related = document.getElementById('Request_nurseries');
    	for (var i = 0; i < related.length; i++)
    		related.options[i].selected = true;

    	return true;
    }

//-->
</script>
