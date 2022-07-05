<table cellpadding='3' cellspacing='4' border='1' class='border_table'>
<tr>
	<th>#</th>
	<th>МДОУ</th>
	<th>Группа</th>
	<th>Номер</th>
	<th>Дата</th>
</tr>
<?php $num = 0; ?>
<?php foreach ($model->directions as $direction): ?>
	<tr>
		<td><?php echo ++$num; ?></td>
		<td><?php echo $direction->getNurseryName(); ?></td>
		<td><?php echo $direction->getGroupName(); ?></td>
		<td><?php echo $direction->getNumber(); ?></td>
		<td><?php echo $direction->getCreateTime(); ?></td>
		</td>
	</tr>
<?php endforeach; ?>
</table>
