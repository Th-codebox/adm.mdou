Список похожих заявлений
<table cellpadding='3' cellspacing='4' border='1' class='border_table'>
<tr><th>ID</th><th>Регистрационный номер</th><th>Номер в очереди</th><th>ФИО</th><th>Дата рождения</th><th>Св-во о рождении</th><th>Адрес</th><th>МДОУ</th></tr>
<?php foreach ($model->getSimilarRequests() as $similar): ?>
<tr>
	<td><?php echo $similar->id; ?></td>
	<td><?php echo $similar->reg_number; ?></td>
	<td><?php echo $similar->queue_number; ?></td>
	<td><?php echo $similar->getFullName(); ?></td>
	<td><?php echo $similar->getBirthDate(); ?></td>
	<td><?php echo $similar->getBirthDocument(); ?></td>
	<td><?php echo $similar->getAddress(); ?></td>
	<td><?php echo $similar->getNurseries(); ?></td>
</tr>
<?php endforeach; ?>
</table>
