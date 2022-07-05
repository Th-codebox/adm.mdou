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
    <TD WIDTH="40%" BACKGROUND="<?php echo Yii::app()->request->baseUrl; ?>/images/front/bg_top.gif"><IMG SRC="<?php echo Yii::app()->request->baseUrl; ?>/images/front/spacer.gif" WIDTH="1" HEIGHT="356" ALT=""></TD>
    <TD WIDTH="20%">
      <TABLE WIDTH="983" BORDER=0 CELLPADDING=0 CELLSPACING=0>
  	<TR VALIGN="TOP">
          <TD WIDTH="609" BACKGROUND="<?php echo Yii::app()->request->baseUrl; ?>/images/front/bg_top.gif">
      	    <TABLE WIDTH="100%" BORDER=0 CELLPADDING=0 CELLSPACING=0>
  	      <TR VALIGN="bottom">
		<TD><A HREF="http://portal.petrozavodsk-mo.ru" target="_blank"><IMG SRC="<?php echo Yii::app()->request->baseUrl; ?>/images/front/banner_ptz.gif" WIDTH="190" HEIGHT="67" ALT="" BORDER="0"></A></TD>
		<TD><IMG SRC="<?php echo Yii::app()->request->baseUrl; ?>/images/front/banner_border.gif" WIDTH="1" HEIGHT="103" ALT="" BORDER="0"></TD>
		<TD WIDTH="100%"><A HREF="https://priemnaya.petrozavodsk-mo.ru" target="_blank"><IMG SRC="<?php echo Yii::app()->request->baseUrl; ?>/images/front/banner_priem.gif" WIDTH="308" HEIGHT="67" ALT="" BORDER="0"></A></TD>
	      </TR>
	   </TABLE>
	   <TABLE WIDTH="100%" BORDER=0 CELLPADDING=0 CELLSPACING=0>
	      <TR><TD><IMG SRC="<?php echo Yii::app()->request->baseUrl; ?>/images/front/spacer.gif" WIDTH="1" HEIGHT="42" ALT=""><BR>
		  <A HREF="<?php echo Yii::app()->request->baseUrl; ?>"><IMG SRC="<?php echo Yii::app()->request->baseUrl; ?>/images/front/title.gif" WIDTH="500" HEIGHT="86" ALT="" BORDER="0"></A><BR>
		  <IMG SRC="<?php echo Yii::app()->request->baseUrl; ?>/images/front/spacer.gif" WIDTH="1" HEIGHT="55" ALT=""></TD>
	      </TR>
<!--меню -->
  	      <TR VALIGN="TOP">
		<TD BACKGROUND="<?php echo Yii::app()->request->baseUrl; ?>/images/front/bg_menu.gif">	
	    <?php $this->widget('application.components.MainMenu', array(
													'frontpage' => 1,
													)); ?>
			</TD>
	      </TR>
  	      <TR VALIGN="TOP">
	    	<TD VALIGN="bottom" ALIGN="right">&nbsp;</TD>
	      </TR>
	    </TABLE>
	  </TD>
          <TD WIDTH="374"><IMG SRC="<?php echo Yii::app()->request->baseUrl; ?>/images/front/top_image.jpg" WIDTH="374" HEIGHT="356" ALT=""></TD>
	</TR>
      </TABLE>
    </TD>
    <TD WIDTH="40%" BACKGROUND="<?php echo Yii::app()->request->baseUrl; ?>/images/front/bg_top.gif">&nbsp;</TD>
  </TR>
</TABLE>
<!--конец шапки -->

<DIV ALIGN="CENTER">
  <TABLE WIDTH="983" BORDER=0 CELLPADDING=0 CELLSPACING=0 style="text-align:left">
    <TR VALIGN="TOP">

<!--левая колонка -->
	<TD WIDTH="243">
	 <span class="warn">
	В настоящее время Система "Дошкольник" работает в режиме <br>опытно-промышленной эксплуатации,<br> который обеспечивает полную функциональность.
	</span>
	<br><br>
	
	<IMG SRC="<?php echo Yii::app()->request->baseUrl; ?>/images/front/ico_zajav.gif" WIDTH="58" HEIGHT="56" ALT="" BORDER="0" ALIGN="left">
	<A HREF="<?php echo Yii::app()->request->baseUrl; ?>/site/request" CLASS="left">Заполнить заявление</A><BR>
	<SPAN CLASS="left">для постановки на очередь в один из детских садов  города</SPAN>

	<?php $this->widget('application.components.QueueStatus'); ?>
	<?php $this->widget('application.components.StatisticsWidget'); ?>
	<?php $this->widget('application.components.ContactInfo'); ?>
	
      </TD>
      <TD WIDTH="64"><IMG SRC="<?php echo Yii::app()->request->baseUrl; ?>/images/front/spacer.gif" WIDTH="64" HEIGHT="1" ALT=""></TD>

<!--правая колонка -->
      <TD WIDTH="676">
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
	  <TD NOWRAP BACKGROUND="<?php echo Yii::app()->request->baseUrl; ?>/images/front/bg_bottom2.gif" WIDTH="50%" CLASS="design" VALIGN="middle">
<!--- COUNTERS ::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::--->
<!-- Yandex.Metrika informer -->
<a href="http://metrika.yandex.ru/stat/?id=9760612&amp;from=informer"
target="_blank" rel="nofollow"><img src="//bs.yandex.ru/informer/9760612/3_1_FFFFFFFF_EFEFEFFF_0_pageviews"
style="width:88px; height:31px; border:0;" alt="Яндекс.Метрика" title="Яндекс.Метрика: данные за сегодня (просмотры, визиты и уникальные посетители)" onclick="try{Ya.Metrika.informer({i:this,id:9760612,type:0,lang:'ru'});return false}catch(e){}"/></a>
<!-- /Yandex.Metrika informer -->

<!-- Yandex.Metrika counter -->
<div style="display:none;"><script type="text/javascript">
(function(w, c) {
    (w[c] = w[c] || []).push(function() {
        try {
            w.yaCounter9760612 = new Ya.Metrika({id:9760612, enableAll: true});
        }
        catch(e) { }
    });
})(window, "yandex_metrika_callbacks");
</script></div>
<script src="//mc.yandex.ru/metrika/watch.js" type="text/javascript" defer="defer"></script>
<noscript><div><img src="//mc.yandex.ru/watch/9760612" style="position:absolute; left:-9999px;" alt="" /></div></noscript>
<!-- /Yandex.Metrika counter -->
<!-- begin of Top100 code -->

<script id="top100Counter" type="text/javascript" src="https://scounter.rambler.ru/top100.jcn?2550761"></script>
<noscript>
<a href="http://top100.rambler.ru/navi/2550761/">
<img src="https://scounter.rambler.ru/top100.cnt?2550761" alt="Rambler's Top100" border="0" />
</a>

</noscript>
<!-- end of Top100 code -->
<!--- COUNTERS ::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::--->   

</TD>
          <TD BACKGROUND="<?php echo Yii::app()->request->baseUrl; ?>/images/front/bg_bottom2.gif"><IMG SRC="<?php echo Yii::app()->request->baseUrl; ?>/images/front/spacer.gif" WIDTH="1" HEIGHT="88" ALT=""></TD>
	  <TD NOWRAP BACKGROUND="<?php echo Yii::app()->request->baseUrl; ?>/images/front/bg_bottom2.gif" WIDTH="50%" CLASS="copyright">
	  <span class="design">Создание сайта: <a href="http://www.karelia.ru/WWWGroup" style="color:#FFFFFF;">WebLab PetrSU</a></span><br/><br/>
	  &copy; Администрация Петрозаводского городского округа,  2010<BR><BR>

</TD>
	</TR>
      </TABLE>
    </TD>
    <TD WIDTH="40%" BACKGROUND="<?php echo Yii::app()->request->baseUrl; ?>/images/front/bg_bottom1.gif">&nbsp;</TD>
  </TR>
</TABLE></body>
</html>