<?php $this->pageTitle=Yii::app()->name; ?>

<h1>Моя очередь</h1>

<?php if ($user->is_applicant): ?>
	<h3>Здравствуйте, <?php echo $user->name; ?>!</h3> <br/>
	Регистрационный номер заявления: <?php echo $user->username; ?><br/>
	Номер Вашего заявления в очереди: <span class="num"><?php echo $request->getQueueNumber(); ?></span>.<br/>
	<br/>
	<b>Журнал операций по предоставлению муниципальной услуги в электронном виде:</b> <br/><br/>
	<table cellpadding='0' cellspacing='1' border='0'>
	<tr><th class="st">Дата</th><th class="st">Операция</th><th class="st">Статус</th><th class="st">Основание</th><th class="st">Комментарий</th></tr>
	<?php $num = 0; ?>
	<?php foreach ($request->operations as $operationLog): ?>
		<?php $operation = $operationLog->operation; ?>
		<tr>
			<td style="width:70px;" class="st3"><?php echo $operationLog->create_time; ?></td>
			<td class="st"><?php echo $operation->getAction(); ?></td>
			<td class="st3"><?php echo $operation->is_change_status ? Request::getStatusNameStatic($operationLog->new_status) : "&nbsp;" ?></td>
			<td class="st3"><?php echo $operation->hasReason() && isset($operationLog->reason) ? $operationLog->reason->name : "&nbsp;";?></td>
			<td class="st3"><?php echo $operationLog->getComment();?></td>
		</tr>
	<?php endforeach; ?>
	</table>
	<br/><br/>
	<?php if (isset($saved) && $saved == "yes"):?><b>Изменение информации прошло успешно.</b><?php endif; ?>
	<br/><br/>
	Вы можете поменять контактные данные Вашего заявления и список желаемых МДОУ.<br/><br/>
	<?php $form = $this->beginWidget('CActiveForm', array(
		'id'=>'request-form',
		'enableAjaxValidation'=>false,
		'htmlOptions'=> array('enctype' =>'multipart/form-data', 'onSubmit'=>'return SubmitForm();'),
	)); ?>
	
	<input type=hidden name="fromform" value="yes" />
	
	<?php echo $form->errorSummary($request); ?>
	
	<?php $this->renderPartial("_address", array('form' => $form, 'model' => $request)); ?><br/><br/>
	<?php $this->renderPartial("_nurseries_list", array("model" => $request, "form" => $form)); ?><br/><br/>

	<div class="row buttons">
		<INPUT style="float:right;" TYPE="image" SRC="<?php echo Yii::app()->request->baseUrl; ?>/images/front/save.gif" ALIGN="absmiddle">
	</div>

	<?php $this->endWidget(); ?>
	

<?php else: ?>
	Доброго времени суток, <?php echo $user->name; ?>.<br/>
	Вы не являетесь заявителем (а значит скорее всего являетесь администратором). 
	Для выполнения своих задач воспользуйтесь соответствующим модулем системы.
<?php endif; ?>
