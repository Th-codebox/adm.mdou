<ul>
<li><?php echo CHtml::ajaxLink('Получить новый пароль заявителя', 
	array("request/generateUserPassword", "id"=>$model->id,),
	array(
		'type'=>'POST',
		'update'=>'#passwordDiv',
	),
	array(
		'id'=>'generatePassword',
		'confirm'=>'Вы уверены, что хотите сгенерировать новый пароль?'
	)
);?>

<div id="passwordDiv">
</div>
</li>

<!--<li><?php echo CHtml::link("Сформировать форму заявления", "javascript:void(0)", array(
	'onClick'=>	"PopupCenter('?r=request/reportApplicationForm&id=".$model->id."', 'Заявление', 1024, 768)"
)); ?></li>
</ul>-->

<li><?php echo CHtml::link("Сформировать форму заявления", "?r=request/reportApplicationForm&id=".$model->id, array(
	'target'=>'_blank',
)); ?></li>
</ul>

<script>
	function PopupCenter(pageURL, title, w, h) {
		var left = (screen.width/2)-(w/2);
		var top = (screen.height/2)-(h/2);
		var targetWin = window.open (pageURL, title, 'toolbar=no, location=no, directories=no, status=no, menubar=yes, scrollbars=no, resizable=no, copyhistory=no, width='+w+', height='+h+', top='+top+', left='+left);
	}
</script>
