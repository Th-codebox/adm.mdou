<TABLE WIDTH="983" BORDER=0 CELLPADDING=0 CELLSPACING=0>
<TR VALIGN="middle" ALIGN="center">
	  <TD ALIGN="left" BACKGROUND="images/bg_menu_sh.gif"><IMG SRC="images/menu_border.gif" WIDTH="1" HEIGHT="27" ALT=""></TD>

<?php $showDelimiter = false; ?>
<?php foreach ($menu as $menuNode): ?>
	<?php if ($showDelimiter && $menuNode->name !== "Информируем"): ?>
<!--	 	<TD BACKGROUND="<?php echo Yii::app()->request->baseUrl; ?>/images/front/bg_menu_sh.gif"><IMG SRC="<?php echo Yii::app()->request->baseUrl; ?>/images/front/menu_marker.gif" WIDTH="4" HEIGHT="7" ALT=""></TD>-->
	<?php endif; ?>
	<?php if ($menuNode->name === "Информируем"): ?>
		<?php $showDelimiter = false; ?>
		<TD BACKGROUND="<?php echo Yii::app()->request->baseUrl; ?>/images/front/bg_menu3.gif">
	<?php else: ?>
		<?php $showDelimiter = true; ?>
		<TD BACKGROUND="<?php echo Yii::app()->request->baseUrl; ?>/images/front/bg_menu_sh.gif">
	<?php endif; ?>
	&nbsp;<?php echo $menuNode->getFrontUrl(array('class' => "menu")); ?>&nbsp;</TD>
<?php endforeach; ?>

<TD ALIGN="right" BACKGROUND="<?php echo Yii::app()->request->baseUrl; ?>/images/front/bg_menu_sh.gif"><IMG SRC="<?php echo Yii::app()->request->baseUrl; ?>/images/front/corner_menu.gif" WIDTH="24" HEIGHT="27" ALT=""></TD>
<TD><IMG SRC="<?php echo Yii::app()->request->baseUrl; ?>/images/front/spacer.gif" WIDTH="100" HEIGHT="1" ALT=""></TD>
<TD><IMG SRC="<?php echo Yii::app()->request->baseUrl; ?>/images/front/today_border1.gif" WIDTH="2" HEIGHT="27" ALT=""></TD>
<TD BACKGROUND="<?php echo Yii::app()->request->baseUrl; ?>/images/front/bg_today.gif" CLASS="today">&nbsp;&nbsp;Сегодня:&nbsp;<?php echo $today; ?>&nbsp;&nbsp;</TD>
<TD><IMG SRC="<?php echo Yii::app()->request->baseUrl; ?>/images/front/today_border2.gif" WIDTH="2" HEIGHT="27" ALT=""></TD>
</TR>
</TABLE>
