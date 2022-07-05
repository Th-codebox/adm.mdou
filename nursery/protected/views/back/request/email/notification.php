<html>

<head>
	<meta http-equiv=Content-Type content="text/html; charset=utf-8">
	<title><?php echo $title; ?></title>
</head>

<body>

<h2>Информационная система «Дошкольник»</h2>

<p>Регистрационный номер: <?php echo $model->reg_number; ?></p>
<p>Номер в очереди: <?php echo $model->queue_number; ?></p>
<p>
	<?php echo date("d"); ?> <?php echo Util::getRussianMonthName(date("n")); ?> <?php echo date("Y"); ?> г. 
	выполнена операция: <b><?php echo $operation->getAction(); ?></b>
</p>

<?php if ($log->hasReason()): ?>
<p>Основание: <?php echo $log->getReason(); ?></p>
<?php endif; ?>

<p align="justify">
Подробную информацию по вопросам приема заявлений, постановки на учет и зачисления детей в образовательные учреждения, 
реализующие основную общеобразовательную программу дошкольного образования, Вы можете получить на сайте 
<a href="http://mdou.petrozavodsk-mo.ru">http://mdou.petrozavodsk-mo.ru</a>
</p>
</body>
</html>
