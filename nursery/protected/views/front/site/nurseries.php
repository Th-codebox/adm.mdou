<?php $this->pageTitle=Yii::app()->name; ?>

<H1>Детские сады</H1>

<?php
	$ndata = $nurseries->data;
	$cnt = count($ndata);
	$rows = (int)($cnt / 3);
	if ($cnt % 3 != 0) $rows++;
?>

<?php if ($pagination->pageCount > 1): ?>
<div align="right">
	<?php $this->widget('CLinkPager', array(
		'pages'=>$pagination,
		'maxButtonCount'=>10,
		'cssFile'=>Yii::app()->request->baseUrl.'/css/pager.css',
	));?>
</div>
<div class="bar"></div>
<?php endif;?>


<table border=0 cellpadding=0 cellspacing=0 width="100%;">
<?php for ($i = 0; $i < $rows; $i++): ?>
<tr>
	<?php for ($j = 0; $j < 3; $j++): ?>
	<td class="ds">
		<?php if ($i * 3 + $j < $cnt): ?>
			<?php $nursery = $ndata[$i * 3 + $j]; ?>
			<b><span class="ds_name2">Детский сад: <?php echo $nursery->short_name; ?></span></b><br />
			<?php echo $nursery->name; ?><br/>
			Адрес: <?php echo $nursery->microdistrict->name; ?>,
			<?php echo CHtml::link(CHtml::encode($nursery->getAddress()), "http://maps.yandex.ru/?text=Петрозаводск, ".$nursery->getAddress(), array("target"=>"_blank")); ?><br />
			Директор: <?php echo $nursery->head->surname." ".$nursery->head->name." ".$nursery->head->patronymic; ?><br/>
			<?php // Количество мест: <span class="num"><  echo $nursery->place_number; ></span><br/>  ?>
			Телефон для справок: <b><?php echo $nursery->getPhone(); ?></b><br/>
		<?php endif; ?>
	</td>
	<?php endfor; ?>
</tr>
<?php endfor; ?>
</table>
<br/>

<?php if ($pagination->pageCount > 1): ?>
<div align="right">
	<?php $this->widget('CLinkPager', array(
		'pages'=>$pagination,
		'maxButtonCount'=>10,
		'cssFile'=>Yii::app()->request->baseUrl.'/css/pager.css',
	));?>
</div>
<div class="bar"></div>
<?php endif;?>
