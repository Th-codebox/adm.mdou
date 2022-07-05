<?php $this->pageTitle=Yii::app()->name . ' - Вход в систему';
$this->breadcrumbs=array(
	'Login',
);
?>
	<div class="queue_p">
	<b>Для просмотра информации о состоянии заявления, введите, пожалуйста, регистрационный номер заявления и пароль</b><BR><br>
	
	<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'login-form',
	'enableAjaxValidation'=>true,
	)); ?>
	
	<?php echo $form->errorSummary($model); ?>
		<?php echo $form->textField($model, 'username', array('size' => 27, 'value' => "Регистрационный номер", 'onClick'=>'js:this.value="";')); ?>
		<?php echo $form->passwordField($model, 'password', array('size' => 18, 'value' => "Пароль", 'onClick'=>'js:this.value="";')); ?>
		<INPUT TYPE="image" SRC="<?php echo Yii::app()->request->baseUrl; ?>/images/front/login.gif" ALIGN="absmiddle">
	<?php $this->endWidget(); ?>
	</div>
