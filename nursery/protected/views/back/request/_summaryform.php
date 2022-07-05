<table cellpadding='3' cellspacing='4' border='1' class='border_table'>
<tr><th>Регистрационный номер</th><th>Номер в очереди</th><th>Дата заполнения</th><th>ФИО</th><th>Дата рождения</th><th>Св-во</th><th>Адрес</th><th>МДОУ</th><th>Льготы</th><th>Текущий статус</th></tr>
<tr>
	<td><?php echo $model->reg_number; ?></td>
	<td><?php echo $model->queue_number; ?></td>
	<td><?php echo $model->getFilingDate()."<br/>".($model->is_internet ? "интернет" : "лично"); ?></td>
	<td><?php echo $model->getFullName(); ?></td>
	<td><?php echo $model->getBirthDate()."&nbsp;(".$model->getAgeYears().")"; ?></td>
	<td><?php echo $model->document_series." №&nbsp;".$model->document_number; ?></td>
	<td><?php echo $model->getAddress(); ?></td>
	<td><?php echo $model->getNurseries(); ?></td>
	<td><?php echo $model->getPrivilegeInfo(); ?></td>
	<td><?php echo $model->getStatusName().($model->is_archive ? " (в архиве)" : ""); ?></td>
</tr>
<?php if ($model->has_privilege): ?>
<tr><td colspan="10"><b>Льготы: </b><?php echo $model->getPrivilegeList(); ?></td></tr>
<?php endif; ?>
</table>
