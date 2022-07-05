<h1>Статистика</h1><br/>

<TABLE border="0" CELLPADDING=2 CELLSPACING=0 width="100%">
<TR>
<TD valign="top">

<table border="0" class="stat" cellspacing="0" cellpadding="0" width="100%" bgcolor="#ffffff">
<tr><th colspan=2 class="st">Количество принятых заявлений<br/> за прошедшие 12 месяцев</th></tr>
<tr><td class="st">Всего</td><td class="st_num"><?php echo $model->countAcceptedRequests() + $model->countAcceptedPrivilegedRequests(); ?></td></tr>
<tr><td class="st">По льготе</td><td class="st_num"><?php echo $model->countAcceptedPrivilegedRequests(); ?></td></tr>
<tr><td class="st">По району проживания</td><td class="st_num">&nbsp;</td></tr>
<?php foreach ($model->countAcceptedRequestsByMicrodistrict() as $mdname => $mvalue): ?>
<tr><td class="st2"><?php echo $mdname; ?></td><td class="st"><?php echo $mvalue ?></td></tr>
<?php endforeach; ?>
</table>

</td>
<td><IMG SRC="images/spacer.gif" WIDTH="10" HEIGHT="1" ALT=""></td>
<TD  valign="top">

<table border="0" class="stat" cellspacing="0" cellpadding="0" width="100%" bgcolor="#ffffff">
<tr><th colspan=2 class="st">Количество состоящих на учете<br/>&nbsp;</th></tr>
<tr><td class="st">Всего</td><td class="st_num"><?php echo $model->countTotalChildren(); ?></td></tr>
<tr><td class="st">По льготе</td><td class="st_num"><?php echo $model->countOutOfQueueChildren() + $model->countPrivilegedChildren(); ?></td></tr>
<tr><td class="st">По году рождения</td><td class="st_num">&nbsp;</td></tr>
<?php foreach ($model->countChildrenByYear() as $year => $value): ?>
<tr><td class="st2"><?php echo ($year == 0) ? "Не указан" : $year; ?></td><td class="st"><?php echo $value ?></td>
<?php endforeach; ?>

<tr><td class="st">По району проживания</td><td class="st_num">&nbsp;</td></tr>
<?php foreach ($model->countChildrenByMicrodistrict() as $mdname => $mvalue): ?>
<tr><td class="st2"><?php echo $mdname; ?></td><td class="st"><?php echo $mvalue ?></td></tr>
<?php endforeach; ?>
</table>

</td>
<td><IMG SRC="images/spacer.gif" WIDTH="10" HEIGHT="1" ALT=""></td>
<TD valign="top">

<table border="0" class="stat" cellspacing="0" cellpadding="0" width="100%" bgcolor="#ffffff">
<tr><th colspan=2 class="st">Количество выданных направлений<br/> за прошедшие 12 месяцев</th></tr>
<tr><td class="st">Всего</td><td class="st_num"><?php echo $model->countIssuedDirections(); ?></td></tr>
<tr><td class="st">По льготе</td><td class="st_num"><?php echo $model->countIssuedOutOfQueueDirections() + $model->countIssuedPrivilegedDirections(); ?></td></tr>
<tr><td class="st">По году рождения</td><td class="st_num">&nbsp;</td></tr>
<?php foreach ($model->countIssuedDirectionsByYear() as $year => $value): ?></tr>
<tr><td class="st2"><?php echo ($year == 0) ? "Не указан" : $year; ?></td><td class="st"><?php echo $value ?></td>
<?php endforeach; ?>
<tr><td class="st">По району проживания</td><td class="st_num">&nbsp;</td></tr>
<?php foreach ($model->countIssuedDirectionsByMicrodistrict() as $mdname => $mvalue): ?>
<tr><td class="st2"><?php echo $mdname; ?></td><td class="st"><?php echo $mvalue ?></td>
<?php endforeach; ?>
</table>

</td></tr>
</table>
