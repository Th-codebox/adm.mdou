<?php $this->beginContent('application.views.back.layouts.empty'); ?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
</head>
<body>
<h1>Список фотографий для '<?php echo $photoObject->getName();?>'</h1>

<table width="100%" border="0">
<?php foreach ($rows as $row):?>
	<tr>
		<?php foreach ($row as $photo): ?>
		<td width="25%" valign="top">
			<table border="0">
				<tr><td><a href="" onClick="ClickImg('<?php echo $photo->getHttpPath();?>', '<?php echo htmlspecialchars($photo->getName());?>', '<?php echo $photo->getHttpPath();?>');"><?php echo $photo->getThumbImage(); ?></a></td></tr>
				<tr><td><?php echo $photo->getName();?></td></tr>
			</table>
		</td>
		<?php endforeach;?>
	</tr>
<?php endforeach; ?>
</table>

<script language="JavaScript" type="text/javascript">
<!--
    function ClickImg(path, palt) {
		window.opener.document.getElementById('txtUrl').value = path;
		window.opener.document.getElementById('txtLnkUrl').value = path;
		window.opener.document.getElementById('txtAlt').value = palt;
		window.opener.document.getElementById('txtWidth').value = 150;
		window.opener.document.getElementById('txtBorder').value = '0';
		window.opener.document.getElementById('cmbLnkTarget').options[1].selected = true;
		window.opener.UpdatePreview();
		window.document.close();
		window.close();

		return false;
    }
//-->
</script>
<noscript><p><b>Javascript must be enabled to use this form.</b></p></noscript>
</body>
</html>
<?php $this->endContent(); ?>