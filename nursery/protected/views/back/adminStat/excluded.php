<?php
$this->breadcrumbs=array(
	'Статистика'=>array('index'),
	'Количество детей, выбывших из очереди'
);?>
<h1>Количество детей, выбывших из очереди</h1>

<table border="1" width="50%" class="border_table">
<tr><th>Причина</th><th>Количество</th></tr>

<?php foreach ($stat->getExcludedRequestCountByReason() as $row): ?>

<tr>
	<td><?php echo $row['reason']; ?></td>
	<td><?php echo $row['cnt']; ?></td>
</tr>
<?php endforeach; ?>

</table>
