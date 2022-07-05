<html>

<head>
	<meta http-equiv=Content-Type content="text/html; charset=utf-8">
	<title>Направление в МДОУ</title>
</head>

<body>

<p>&nbsp;</p>

<p align=center><b>НАПРАВЛЕНИЕ</b></p>

<p>&nbsp;</p>

<table width="95%" cellpadding="3" cellspacing="4">
<tr>
	<td>от «<i><?php echo date("d"); ?>» <?php echo Util::getRussianMonthName(date("n")); ?> <?php echo date("Y"); ?> г.</i></td>
	<td>&nbsp;</td>
	<td align="right">№ <i><?php echo $direction->getNumber(); ?></i></td>
</tr>

<tr>
	<td colspan="3">Администрация Петрозаводского городского округа направляет в <i><?php echo $direction->nursery->getName(); ?></i></td>
</tr>

<tr>
	<td colspan="3">
		Адрес и телефон МДОУ: 
		<i><?php echo $direction->nursery->getAddress(); ?><?php echo $direction->nursery->phone !== "" ? ", тел. ".$direction->nursery->phone : ""; ?></i></td>
</tr>

<tr>
	<td colspan="3">ФИО руководителя: <i><?php echo $direction->nursery->head->getName(); ?></i></td>
</tr>

<tr>
	<td colspan="3">Фамилия, имя, отчество ребенка: <i><?php echo $model->getFullName(); ?></i></td>
</tr>

<tr>
	<td colspan="3">Год, число, месяц рождения ребенка: <i><?php echo $model->getBirthDate(); ?></i></td>
</tr>

<tr>
	<td colspan="3">Номер в очереди: <i><?php echo $model->queue_number; ?></i></td>
</tr>

<tr>
	<td colspan="3">Домашний адрес: <i><?php echo $model->getAddress().", тел. ".$model->applicant->phone; ?></i></td>
</tr>

<tr>
	<td colspan="3">Направление действительно в течение 14 дней со дня его выдачи.</td>
</tr>

<tr><td colspan="3">&nbsp;</td></tr>

<tr valign="top">
	<td>Председатель Комиссии</td>
	<td align="center">_____________________________<br>(подпись)</td>
	<td><i><?php echo Commission::getHead()->getShortName(); ?></i></td>
</tr>

<?php $index = 0; ?>
<?php foreach (Commission::getMembers() as $member): ?>
<tr valign="top">
	<td><?php echo $index == 0 ? "Члены комиссии" : "&nbsp;";?></td>
	<td align="center">_____________________________<br>(подпись)</td>
	<td><i><?php echo $member->getShortName(); ?></i></td>
</tr>
<?php endforeach; ?>

</table>

</body>

</html>
