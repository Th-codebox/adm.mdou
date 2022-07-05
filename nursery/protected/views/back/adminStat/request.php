<?php
$this->breadcrumbs=array(
	'Статистика'=>array('index'),
	'Количество состоящих на учете детей'
);?>
<h1>Количество состоящих на учете детей</h1>

<!--
<div>
	<?php echo CHtml::beginForm(array('adminStat/request'), 'GET'); ?>
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
-->

<table border="1" width="50%" class="border_table">

<tr>
<td colspan="2">Всего</td><td><?php echo $stat->getTotalRequestCount(); ?></td>
</tr>

<tr><td colspan="3">По возрастным группам</td></tr>
<tr>
	<td rowspan="9">&nbsp;</td>
	<td>от 0 до 1 года</td>
	<td><?php echo $stat->getRequestCountByAge(0, 12); ?></td>
</tr>
<tr>
	<td>от 0 до 1.5 лет</td>
	<td><?php echo $stat->getRequestCountByAge(0, 18); ?></td>
</tr>
<tr>
	<td>от 1 года до 1.5 лет</td>
	<td><?php echo $stat->getRequestCountByAge(12, 18); ?></td>
</tr>
<tr>
	<td>от 1 года до 2 лет</td>
	<td><?php echo $stat->getRequestCountByAge(12, 24); ?></td>
</tr>
<tr>
	<td>от 2 до 3 лет</td>
	<td><?php echo $stat->getRequestCountByAge(24, 36); ?></td>
</tr>
<tr>
	<td>от 3 до 4 лет</td>
	<td><?php echo $stat->getRequestCountByAge(36, 48); ?></td>
</tr>
<tr>
	<td>от 4 до 5 лет</td>
	<td><?php echo $stat->getRequestCountByAge(48, 60); ?></td>
</tr>
<tr>
	<td>от 5 до 6 лет</td>
	<td><?php echo $stat->getRequestCountByAge(60, 72); ?></td>
</tr>
<tr>
	<td>старше 6 лет</td>
	<td><?php echo $stat->getRequestCountByAge(72, 150); ?></td>
</tr>
<tr>
	<td colspan="2">По льготе (вне очереди)</td>
	<td><?php echo $stat->getRequestCountOutOfQueue(); ?></td>
</tr>
<tr>
	<td colspan="2">По льготе (первоочередное)</td>
	<td><?php echo $stat->getRequestCountPrivilege(); ?></td>
</tr>
<tr>
	<td colspan="2">Всего (по льготе)</td>
	<td><?php echo $stat->getTotalRequestCountPrivilege(); ?></td>
</tr>

<tr><td colspan="3">По году рождения</td></tr>

<?php foreach ($stat->getRequestCountByYears() as $row): ?>
<tr>
	<td></td>
	<td><?php echo $row['year']; ?></td>
	<td><?php echo $row['cnt']; ?></td>
</tr>
<?php endforeach; ?>

<tr><td colspan="3">По району проживания</td></tr>

<?php foreach ($stat->getRequestCountByMicrodistricts() as $row): ?>
<tr>
	<td></td>
	<td><?php echo $row['microdistrict']; ?></td>
	<td><?php echo $row['cnt']; ?></td>
</tr>
<?php endforeach; ?>

</table>
