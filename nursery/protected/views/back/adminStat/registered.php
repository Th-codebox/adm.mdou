<?php
$this->breadcrumbs=array(
	'Статистика'=>array('index'),
	'Количество принятых заявлений'
);?>
<h1>Количество принятых заявлений</h1>

<div>
	<?php echo CHtml::beginForm(array('adminStat/registeredRequests'), 'GET'); ?>
	<b>Дата </b>
	с 
	<?php $this->widget('zii.widgets.jui.CJuiDatePicker', array(
		'name'=>'Stat_dateFrom',
		'language'=>'ru',
		'value' => isset($_GET['Stat_dateFrom']) ? $_GET['Stat_dateFrom'] : '',
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
//			'readonly'=>'readonly'
		),
	));?>
	по 
	<?php $this->widget('zii.widgets.jui.CJuiDatePicker', array(
		'name'=>'Stat_dateTo',
		'language'=>'ru',
		'value' => isset($_GET['Stat_dateTo']) ? $_GET['Stat_dateTo'] : '',
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
//			'readonly'=>'readonly'
		),
	));?>
	<input type="submit" value="Применить">
	<?php echo CHtml::endForm(); ?>
	<br/><br/>
</div>

<table border="1" width="50%" class="border_table">

<tr>
	<td colspan="2">Всего</td>
	<td><?php echo $stat->getTotalRegisteredCount(); ?></td>
</tr>

<tr>
	<td colspan="2">Через интернет</td>
	<td><?php echo $stat->getInternetRegisteredCount(); ?></td>
</tr>
<tr>
	<td colspan="2">По льготе (вне очереди)</td>
	<td><?php echo $stat->getRegisteredCountOutOfQueue(); ?></td>
</tr>
<tr>
	<td colspan="2">По льготе (первоочередное)</td>
	<td><?php echo $stat->getRegisteredCountPrivilege(); ?></td>
</tr>
<tr>
	<td colspan="2">Всего (по льготе)</td>
	<td><?php echo $stat->getTotalRegisteredCountPrivilege(); ?></td>
</tr>

<tr><td colspan="3">По году рождения</td></tr>

<?php foreach ($stat->getRegisteredCountByYears() as $row): ?>
<tr>
	<td></td>
	<td><?php echo $row['year']; ?></td>
	<td><?php echo $row['cnt']; ?></td>
</tr>
<?php endforeach; ?>

<tr><td colspan="3">По району проживания</td></tr>

<?php foreach ($stat->getRegisteredCountByMicrodistricts() as $row): ?>
<tr>
	<td></td>
	<td><?php echo $row['microdistrict']; ?></td>
	<td><?php echo $row['cnt']; ?></td>
</tr>
<?php endforeach; ?>

</table>
