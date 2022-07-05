<?php
$this->breadcrumbs=array(
	'Статистика',
);?>

<h1>Статистика</h1>

<div>
	<ul>
		<li><?php echo CHtml::link("Количество состоящих на учете детей", array("adminStat/activeRequests")); ?><br/><br/></li>
		<li><?php echo CHtml::link("Количество принятых заявлений", array("adminStat/registeredRequests")); ?><br/><br/></li>
		<li><?php echo CHtml::link("Количество освободившихся мест в МДОУ", array("adminStat/freePlaces")); ?><br/><br/></li>
		<li><?php echo CHtml::link("Количество выданных направлений", array("adminStat/issuedDirections")); ?><br/><br/></li>
		<li><?php echo CHtml::link("Количество детей, выбывших из очереди", array("adminStat/excludedRequests")); ?><br/><br/></li>
	</ul>
</div>