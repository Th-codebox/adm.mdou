<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="language" content="en" />

	<LINK REL="stylesheet" TYPE="text/css" HREF="<?php echo Yii::app()->request->baseUrl; ?>/css/site.css">

	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/js/lightbox/jquery.lightbox-0.5.css" />
	<title>Система "Дошкольник"</title>
</head>

<BODY BGCOLOR="#FFFFFF" TEXT="#436475" LINK="#379DCA" VLINK="#379DCA" ALINK="#000000" TOPMARGIN=0 LEFTMARGIN=0 MARGINWIDTH=0 MARGINHEIGHT=0 style="margin:0px;">

<TABLE WIDTH="100%" BORDER=0 CELLPADDING=0 CELLSPACING=0>
  <TR VALIGN="TOP">
    <TD WIDTH="40%" BACKGROUND="<?php echo Yii::app()->request->baseUrl; ?>/images/front/bg_top_sh.gif"><IMG SRC="<?php echo Yii::app()->request->baseUrl; ?>/images/front/spacer.gif" WIDTH="1" HEIGHT="184" ALT=""></TD>
    <TD WIDTH="20%" BACKGROUND="<?php echo Yii::app()->request->baseUrl; ?>/images/front/bg_top_sh.gif">
      <TABLE WIDTH="983" BORDER=0 CELLPADDING=0 CELLSPACING=0>
  	<TR VALIGN="bottom">
	  <TD><A HREF="<?php echo Yii::app()->request->baseUrl; ?>/"><IMG SRC="<?php echo Yii::app()->request->baseUrl; ?>/images/front/title2.gif" WIDTH="393" HEIGHT="71" ALT="" BORDER="0"></A></TD>
	  <TD WIDTH="40%" ALIGN="center"><IMG SRC="<?php echo Yii::app()->request->baseUrl; ?>/images/front/banner_border.gif" WIDTH="1" HEIGHT="103" ALT="" BORDER="0"></TD>
	  <TD><A HREF="http://portal.petrozavodsk-mo.ru" target="_blank"><IMG SRC="<?php echo Yii::app()->request->baseUrl; ?>/images/front/banner_ptz.gif" WIDTH="190" HEIGHT="67" ALT="" BORDER="0"></A></TD>
	  <TD WIDTH="40%" ALIGN="center"><IMG SRC="<?php echo Yii::app()->request->baseUrl; ?>/images/front/banner_border.gif" WIDTH="1" HEIGHT="103" ALT="" BORDER="0"></TD>
	  <TD WIDTH="100%"><A HREF="https://priemnaya.petrozavodsk-mo.ru" target="_blank"><IMG SRC="<?php echo Yii::app()->request->baseUrl; ?>/images/front/banner_priem.gif" WIDTH="308" HEIGHT="67" ALT="" BORDER="0"></A></TD>
	</TR>
      </TABLE>
      <IMG SRC="<?php echo Yii::app()->request->baseUrl; ?>/images/front/spacer.gif" WIDTH="1" HEIGHT="54" ALT="">
<!-- menu -->
			<?php $this->widget('application.components.MainMenu', array(
													'frontpage' => 0,
													)); ?>
<!-- end of menu -->
    </TD>
    <TD WIDTH="40%" BACKGROUND="<?php echo Yii::app()->request->baseUrl; ?>/images/front/bg_top_sh.gif"><IMG SRC="<?php echo Yii::app()->request->baseUrl; ?>/images/front/spacer.gif" WIDTH="1" HEIGHT="184" ALT=""></TD>
  </TR>
</TABLE>
<!--конец шапки -->

<DIV ALIGN="CENTER">
  <TABLE WIDTH="983" BORDER=0 CELLPADDING=0 CELLSPACING=0 style="text-align:left">
    <TR VALIGN="TOP">
<!--правая колонка -->
      <TD WIDTH="983">
      <br/>
      	<?php echo $content; ?>
      </TD>
    </TR>
  </TABLE>
</DIV>

<!--подвал -->
<TABLE WIDTH="100%" BORDER=0 CELLPADDING=0 CELLSPACING=0>
  <TR VALIGN="TOP">
    <TD WIDTH="40%" BACKGROUND="<?php echo Yii::app()->request->baseUrl; ?>/images/front/bg_bottom1.gif"><IMG SRC="<?php echo Yii::app()->request->baseUrl; ?>/images/front/spacer.gif" WIDTH="1" HEIGHT="88" ALT=""></TD>
    <TD WIDTH="20%">
      <TABLE WIDTH="983" BORDER=0 CELLPADDING=0 CELLSPACING=0>
  	<TR VALIGN="bottom">
	  <TD NOWRAP BACKGROUND="<?php echo Yii::app()->request->baseUrl; ?>/images/front/bg_bottom2.gif" WIDTH="50%" CLASS="design">Создание сайта: <a href="http://www.karelia.ru/WWWGroup" style="color:#FFFFFF;">WebLab PetrSU</a><BR><BR></TD>
          <TD BACKGROUND="<?php echo Yii::app()->request->baseUrl; ?>/images/front/bg_bottom2.gif"><IMG SRC="<?php echo Yii::app()->request->baseUrl; ?>/images/front/spacer.gif" WIDTH="1" HEIGHT="88" ALT=""></TD>
	  <TD NOWRAP BACKGROUND="<?php echo Yii::app()->request->baseUrl; ?>/images/front/bg_bottom2.gif" WIDTH="50%" CLASS="copyright">&copy; Администрация Петрозаводского городского округа,  2010-2011<BR><BR></TD>
	</TR>
      </TABLE>
    </TD>
    <TD WIDTH="40%" BACKGROUND="<?php echo Yii::app()->request->baseUrl; ?>/images/front/bg_bottom1.gif">&nbsp;</TD>
  </TR>
</TABLE>
</body>
</html>