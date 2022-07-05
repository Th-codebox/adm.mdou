<table cellpadding='3' cellspacing='4' border='1' class='border_table'>
<tr><th>ID</th><th>Название</th><th>Сокращение</th><th>Руководитель</th><th>Адрес</th><th>Телефон</th></tr>
<tr>
	<td><?php echo $model->id; ?></td>
	<td><?php echo $model->getName(); ?></td>
	<td><?php echo $model->short_name; ?></td>
	<td><?php echo $model->head->getName(); ?></td>
	<td><?php echo $model->getAddress(); ?></td>
	<td><?php echo $model->phone; ?></td>
</tr>
</table>
