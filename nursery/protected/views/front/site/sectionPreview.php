<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="Content-Language" content="ru" />

<title><?php echo CHtml::encode($this->pageTitle); ?></title>

<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/site.css" />
</head>
<body bgcolor="#FFFFFF" style="margin: 0;">
<!-- ImageReady Slices (top.psd) -->

<table border="0" width="727" align="center">
<tr>
	<td>&nbsp;</td>
	<td>
		<?php if ($node->id != Node::$ROOT_ID):?>
		<h1><?php echo $node->name; ?></h1>
		<?php endif; ?>

		<div class="text">
			<?php echo $node->getText(); ?>
			<p>&nbsp;</p>
		</div>

		<?php if ($files):?>
			<div class="bar"></div>
			<img src="<?php echo Yii::app()->request->baseUrl; ?>/images/front/point.gif" width="10" height="7" alt=""/>&nbsp; <b>Файлы для скачивания</b><br>
			<?php foreach ($files as $file):?>
				<img src="<?php echo Yii::app()->request->baseUrl; ?>/images/front/appicons/<?php echo $file->getFileTypeImage(); ?>.png" width="16" height="16" align="absmiddle" alt="" style="margin: 7px 2px 2px 0px;"/>&nbsp; <a href="<?php echo $file->getHttpPath();?>" target="_blank"><?php echo $file->getName();?></a> (*.<?php echo $file->extension;?>, <?php echo $file->getSize();?>)
				<br/><br/>
			<?php endforeach;?>
		<?php endif;?>

		<?php if ($node->getText() != "" || $files):?>
			<div class="bar"></div>
		<?php endif; ?>

	</td>
</tr>
</table>

</body>
</html>