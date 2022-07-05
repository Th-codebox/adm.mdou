<DIV CLASS="stats">
	<TABLE WIDTH="225" BORDER=0 CELLPADDING=0 CELLSPACING=0>
	<TR VALIGN="center"><TD><IMG SRC="<?php echo Yii::app()->request->baseUrl; ?>/images/front/decor_stats.gif" WIDTH="21" HEIGHT="8" ALT="" BORDER="0"></TD>
	<TD ALIGN="center" WIDTH="100%"><H3>Статистика</H3></TD>
	<TD><IMG SRC="<?php echo Yii::app()->request->baseUrl; ?>/images/front/decor_stats.gif" WIDTH="21" HEIGHT="8" ALT="" BORDER="0"></TD>
	</TR>
</TABLE><BR>

<B>За прошедшие 12 месяцев:</B><BR>
<ul class="st">
<li>количество принятых заявлений - <BIG><?php echo $totalreqs; ?></BIG></li>
<li>количество выданных направлений - <BIG><?php echo $totaldirs; ?></BIG></li>
</ul>
<DIV ALIGN="right"><A HREF="<?php echo Yii::app()->request->baseUrl; ?>/site/statistics">Полная статистика</A></DIV>
</DIV>
