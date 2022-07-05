<table>
<tr><th>ID</th><th>ФИО</th><th>Место работы</th><th>Должность</th><th>Телефон</th></tr>
<?php foreach ($request->persons as $person): ?>
<tr>
	<td><?php echo $person->id;?></td>
	<td><?php echo $person->getFullName();?></td>
	<td><?php echo $person->work_place;?></td>
	<td><?php echo $person->work_post;?></td>
	<td><?php echo $person->phone;?></td>
</tr>
<?php endforeach; ?>
</table>