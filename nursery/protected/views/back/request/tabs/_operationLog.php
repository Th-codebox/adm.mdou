<table cellpadding='3' cellspacing='4' border='1' class='border_table'>
<tr>
	<th>№</th>
	<th>Операция</th>
	<th>Предыдущий статус</th>
	<th>Новый статус</th>
	<th>Причина</th>
	<th>Комментарий</th>
	<th>Дополнительно</th>
	<th>Дата</th>
	<th>Пользователь</th>
</tr>
<?php $num = 0; ?>
<?php foreach ($model->operations as $operationLog): ?>
	<?php $operation = $operationLog->operation; ?>
	<tr>
		<td><?php echo ++$num; ?></td>
		<td><?php echo $operation->action; ?></td>
		<td><?php echo $operation->is_change_status ? Request::getStatusNameStatic($operationLog->old_status) : "&nbsp;"; ?></td>
		<td><?php echo $operation->is_change_status ? Request::getStatusNameStatic($operationLog->new_status) : "&nbsp;" ?></td>
		<td><?php echo $operation->hasReason() && isset($operationLog->reason) ? $operationLog->reason->name : "&nbsp;";?></td>
		<td><?php echo $operationLog->getComment();?></td>
		<td><?php echo $operationLog->getPrintFormLink(); ?></td>
		<td><?php echo $operationLog->create_time; ?></td>
		<td><?php echo $operationLog->getUserName(); ?></td>
	</tr>
<?php endforeach; ?>
</table>


<script language="JavaScript" type="text/javascript">
	function PopupCenter(pageURL, title, w, h) {
		var left = (screen.width/2)-(w/2);
		var top = (screen.height/2)-(h/2);
		var targetWin = window.open (pageURL, title, 'toolbar=no, location=no, directories=no, status=no, menubar=yes, scrollbars=no, resizable=no, copyhistory=no, width='+w+', height='+h+', top='+top+', left='+left);
	}
</script>
