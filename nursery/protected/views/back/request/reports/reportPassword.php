<html>

<head>
<meta http-equiv=Content-Type content="text/html; charset=utf-8">
<title>УВЕДОМЛЕНИЕ</title>
</head>

<body>

<div>
<blockquote>
<p align=center><b>УВЕДОМЛЕНИЕ<br>
о смене пароля</b></p>

<p align=center>&nbsp;</p>

<p align="justify"><i><?php echo $model->applicant->getFullName(); ?></i> уведомляется
в том, что у заявления на имя: <i><?php echo $model->getFullName(); ?></i>, дата рождения: <i><?php echo $model->getBirthDate(); ?></i> 
сменился пароль.</p>

<p align="justify">Идентификатор доступа: <i><?php echo $model->reg_number; ?></i></p>

<?php if ($password != ""):?>
	<p align="justify">Новый пароль: <i><?php echo $password; ?></i></p>
<?php endif; ?>

<table width="90%">
<tr>
<td>Член Комиссии, осуществляющий регистрацию</td>
<td align="left" nowrap>_______________ / <i><?php echo Yii::app()->user->getName(); ?></i></td>
</tr>
</table>


<p align="justify">«<i><?php echo date("d"); ?>» <?php echo Util::getRussianMonthName(date("m")); ?> <?php echo date("Y"); ?> г.</i></p>

<p align="justify">
Подробную информацию по вопросам приема заявлений, постановки на учет и зачисления детей в образовательные учреждения, 
реализующие основную общеобразовательную программу дошкольного образования, Вы можете получить на сайте 
<a href="http://mdou.petrozavodsk-mo.ru">http://mdou.petrozavodsk-mo.ru</a>
</p>

</blockquote>
</div>

</body>

</html>
