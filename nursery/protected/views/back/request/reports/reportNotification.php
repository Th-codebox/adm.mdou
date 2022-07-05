<html>

<head>
<meta http-equiv=Content-Type content="text/html; charset=utf-8">
<title>УВЕДОМЛЕНИЕ о постановке на учет (регистрации) ребенка</title>

</head>

<body>

<div>

<p align=center>&nbsp;</p>

<p align=center><b>УВЕДОМЛЕНИЕ<br>о постановке на учет (регистрации) ребенка</b></p>
<blockquote>

<p align="justify"><i><?php echo $model->applicant->getFullName(); ?></i> уведомляется в том, что 
<i><?php echo $model->getFullName(); ?></i>, дата рождения: <i><?php echo $model->getBirthDate(); ?></i>
<br>
зарегистрирован(а) в базе данных об очередности по устройству детей в
МДОУ (в единой городской очереди по устройству детей в МДОУ)
дата регистрации: <i><?php echo $model->getRegisterDate(); ?></i>, 
регистрационный № <i><?php echo $model->reg_number; ?></i>,
номер очереди <i><?php echo $model->getQueueNumber(); ?></i>.</p>

<p align="justify">Для отслеживания продвижения очереди родители (законные представители) могут пользоваться
Интернет-сайтом mdou.petrozavodsk-mo.ru или явиться лично в часы приема членами Комиссии.</p>

<p align="justify">Идентификатор доступа: <i><?php echo $model->reg_number; ?></i></p>

<?php if (!$model->is_internet): ?>
	<?php if ($password != ""):?>
		<p align="justify">Пароль: <i><?php echo $password; ?></i></p>
	<?php endif; ?>
<?php else: ?>
	<p>Пароль был сообщен при подаче заявления через интернет.</p>
<?php endif; ?>

<table width="85%">
<tr>
<td>Член Комиссии, осуществляющий регистрацию</td>
<td align="left">_________________ / <i><?php echo Yii::app()->user->getName(); ?></i></p>
</tr>
</table>

<p align="justify">«<i><?php echo date("d"); ?>» <?php echo Util::getRussianMonthName(date("n")); ?> <?php echo date("Y"); ?> г.</i></font></p>

</blockquote>
</div>

</body>

</html>