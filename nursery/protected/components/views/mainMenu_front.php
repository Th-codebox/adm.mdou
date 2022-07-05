<TABLE WIDTH="100%" BORDER=0 CELLPADDING=0 CELLSPACING=0>
<TR VALIGN="middle" ALIGN="center">
<TD ALIGN="left"><IMG SRC="<?php echo Yii::app()->request->baseUrl; ?>/images/front/menu_border.gif" WIDTH="1" HEIGHT="27" ALT=""></TD>

<?php $showDelimiter = false; ?>
<?php foreach ($menu as $menuNode): ?>
	<?php if ($showDelimiter && $menuNode->name !== "Информируем"): ?>
<!--		<TD><IMG SRC="<?php echo Yii::app()->request->baseUrl; ?>/images/front/menu_marker.gif" WIDTH="4" HEIGHT="7" ALT=""></TD>-->
	<?php endif; ?>
	<?php if ($menuNode->name === "Информируем"): ?>
		<?php $showDelimiter = false; ?>
		<TD BACKGROUND="<?php echo Yii::app()->request->baseUrl; ?>/images/front/bg_menu3.gif">
	<?php else: ?>
		<?php $showDelimiter = true; ?>
		<TD>
	<?php endif; ?>
	&nbsp;<?php echo $menuNode->getFrontUrl(array('class' => "menu")); ?>&nbsp;</TD>
<?php endforeach; ?>
</TR>
</TABLE>
