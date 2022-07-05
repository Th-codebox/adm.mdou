<DIV CLASS="queue">
<A HREF="<?php echo Yii::app()->request->baseUrl; ?>/site/status">Моя очередь</A><BR><BR>
<?php if (Yii::app()->user->isGuest || !isset($user)): ?>
	Для просмотра информации о состоянии заявления, введите, пожалуйста, регистрационный номер заявления и пароль<br/><br/>
	
	<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'login-form',
	'enableAjaxValidation'=>false,
	'action'=>Yii::app()->request->baseUrl.'/site/login',
	)); ?>
	<table border=0 cellpadding=1 cellspacing=0>
	<tr>
	<td><?php echo $form->textField($model, 'username', array('size' => 12, 'value'=>"Номер", 'onClick'=>'js:this.value="";')); ?></td>
	<td><?php echo $form->passwordField($model, 'password', array('size' => 12, 'value'=>"Пароль", 'onClick'=>'js:this.value="";')); ?></td>
	<td><INPUT TYPE="image" SRC="<?php echo Yii::app()->request->baseUrl; ?>/images/front/login.gif" ALIGN="absmiddle" style="border:0px"></td>
	</tr>
	</table><br/>
	<?php $this->endWidget(); ?>
<?php else : ?>
	<?php if ($user->is_applicant): ?>
		Регистрационный номер: <?php echo $request->reg_number; ?><br/>
		Номер в очереди: <?php echo $request->getQueueNumber(); ?><br/>
	<?php else: ?>
		Доброго времени суток, <?php echo $user->name; ?>!<br/>
	<?php endif; ?>
	<a href="<?php echo Yii::app()->request->baseUrl; ?>/site/logout">Выход из системы</a>
	<br/><br/>
<?php endif; ?>

</DIV>
