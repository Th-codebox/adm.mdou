<html>

<head>
	<meta http-equiv=Content-Type content="text/html; charset=utf-8">
	<title>Форма заявления</title>
</head>

<body>

<div>
<blockquote>
<p align="right">&nbsp;</p>

<p align="right">Председателю Комиссии <br><i><?php echo Commission::getHead()->name_dative;?></i></p>

<p align="right">
от <i><?php echo $model->applicant->getFullName(); ?></i>,
<br>проживающего(ей) по адресу: 
<br><i><?php echo $model->getAddress(); ?></i>
<br>телефон: 
<br><i><?php echo $model->applicant->phone; ?></i>
<br>паспорт:
<br><i><?php echo $model->applicant->getPassportInfo(); ?></i>
<br>адрес электронной почты (по желанию заявителя):
<br><i><?php echo $model->getEmail(); ?></i>
<br>Информация о льготах:
<br>
<i>
<?php foreach ($model->privilegeDocuments as $item): ?>
	<?php echo $item->privilege->getName(); ?>, документ: <?php echo $item->getName(); ?>, выдан <?php echo $item->getIssueDate(); ?><br/>
<?php endforeach; ?>
</i>
</p>

<p align=center>ЗАЯВЛЕНИЕ</p>

<p align="justify">Прошу поставить на учет моего (мою) сына (дочь) <br>
<i><?php echo $model->getFullName(); ?>, <?php echo $model->getBirthDate(); ?> г. рождения, св-во о рождении <?php echo $model->getBirthDocument(); ?>, 
адрес: <?php echo $model->getAddress(); ?></i><br>
в базе данных об очередности по устройству детей в МДОУ (в единой городской очереди по устройству детей в МДОУ).</p>

<p>Предполагаемые МДОУ:
<i><?php echo $model->getNurseries(); ?></i>
</p>

<p align="justify">В случае изменения места жительства и контактных телефонов обязуюсь своевременно проинформировать Комиссию 
по комплектованию муниципальных дошкольных образовательных учреждений Петрозаводского городского округа.</p>

<p align="justify">Настоящим даю свое согласие Администрации Петрозаводского 
городского округа (находится по адресу: 185910, Республика Карелия, г. Петрозаводск, 
пр. Ленина, 2) на обработку (сбор, систематизацию, хранение, уточнение, использование) 
на бумажном и электронном носителях с обеспечением конфиденциальности моих
персональных данных и персональных данных моего ребенка, сообщаемых мною в
настоящем заявлении и содержащихся в прилагаемых к данному заявлению документах
(копиях документов), в целях осуществления учета моего ребенка (детей) в единой
городской очереди по устройству детей в МДОУ на период до зачисления моего
ребенка (детей) в МДОУ (иное образовательное учреждение) или до отзыва мною
своего заявления и данного согласия.</p>

<p align="left"><i>«<?php echo date("d"); ?>» <?php echo Util::getRussianMonthName(date("n")); ?> <?php echo date("Y"); ?></i> г.</p> <p align="right"><u>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</u> / <i><?php echo $model->applicant->getShortName(); ?></i></p>

<blockquote>
</div>

</body>

</html>
