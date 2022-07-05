<?php echo CHtml::beginForm(array('nursery/index'), 'GET'); ?>
<table border="0" width="100%" cellpadding="5">
<tr>
	<td width="50%">
		<b>Район</b><br/>
		<?php echo CHtml::dropDownList("Nursery_microdistrict", isset($_GET['Nursery_microdistrict']) ? $_GET['Nursery_microdistrict'] : "", 
			$microdistricts, array( 'prompt' => 'Любой'));?>
	</td>
	<td width="50%">
		<b>Специализация</b><br/>
		<?php echo CHtml::dropDownList("Nursery_disease", isset($_GET['Nursery_disease']) ? $_GET['Nursery_disease'] : "", 
			$diseases, array( 'prompt' => 'Любая'));?>
	</td>
</tr>
<tr>
	<td width="50%">
		<b>Ключевые слова</b><br/>
		<?php echo CHtml::textField("Nursery_words", (isset($_GET['Nursery_words']) ? $_GET['Nursery_words'] : ""), 
			array('size'=>40));?>
	</td>
	<td width="50%">
		<b>Количество записей на странице</b><br/>
		<?php echo CHtml::dropDownList("Nursery_pageSize", (isset($_GET['Nursery_pageSize']) ? $_GET['Nursery_pageSize'] : '50'),
			array('10'=>'10', '25'=>'25', '50'=>'50', '100'=>'100'));?>
	</td>	
</tr>
<tr>
	<td colspan="2"><input type="submit" value="Применить"></td>
</tr>
</table>
<?php echo CHtml::endForm(); ?>
