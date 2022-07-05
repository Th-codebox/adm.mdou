<?php echo CHtml::beginForm(array('street/index'), 'GET'); ?>
<table border="0" width="100%" cellpadding="5">
<tr>
	<td width="50%">
		<b>Тип улицы</b><br/>
		<?php echo CHtml::dropDownList("Street_type", isset($_GET['Street_type']) ? $_GET['Street_type'] : 0, $types, array( 'prompt' => 'Любой'));?>
	</td>
	<td width="50%">
		<b>Район</b><br/>
		<?php echo CHtml::dropDownList("Street_microdistrict", isset($_GET['Street_microdistrict']) ? $_GET['Street_microdistrict'] : 0,
			$microdistricts, array( 'prompt' => 'Любой'));?>
	</td>
</tr>
<tr>
	<td width="50%">
		<b>Ключевые слова</b><br/>
		<?php echo CHtml::textField("Street_words", isset($_GET['Street_words']) ? $_GET['Street_words'] : "", array('size'=>40));?>
	</td>
	<td width="50%">
		<b>Количество записей на странице</b><br/>
		<?php echo CHtml::dropDownList("Street_pageSize", (isset($_GET['Street_pageSize']) ? $_GET['Street_pageSize'] : '25'),
			array('10'=>'10', '25'=>'25', '50'=>'50'));?>
	</td>	
</tr>
<tr>
	<td colspan="2"><input type="submit" value="Применить"></td>
</tr>
</table>
<?php echo CHtml::endForm(); ?>
