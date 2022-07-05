<div class="row">
	<?php echo $form->labelEx($model,'town_id'); ?>
	<?php echo CHtml::dropDownList('town_id', $model->town_id != 0 ? $model->town_id : 1,
		CHtml::listData(Town::model()->findAll(array('order'=>'name ASC')),
		'id', 'name'), array('prompt'=>'Другой'));?>
	<?php echo $form->error($model,'town_id'); ?>
</div>

<div class="row">
	<?php echo $form->labelEx($model,'microdistrict_id'); ?>
	<?php echo $form->dropDownList($model, 'microdistrict_id',
		CHtml::listData(Microdistrict::model()->findAll(array(
			'order'=>'name ASC')),
		'id', 'name'),
		array(
			'prompt'=>'Выберите микрорайон',
			'ajax'=>array(
				'type'=>'POST', //request type
				'url'=>CController::createUrl('microdistrict/ajaxStreets'), //url to call.
				//Style: CController::createUrl('currentController/methodToCall')
				'update'=>'#Nursery_street_id', //selector to update
				'data'=>array('microdistrict_id'=>'js:this.value'),
				//'data'=>'js:javascript statement'
				//leave out the data key to pass all form values through
			)
		));?>
	<?php echo $form->error($model,'microdistrict_id'); ?>
</div>

<div class="row">
	<?php echo $form->labelEx($model,'street_id'); ?>
	<?php echo $form->dropDownList($model, 'street_id',
		CHtml::listData(Street::model()->findAll(array('order'=>'name ASC')),
		'id', 'Name'), array('prompt'=>'Выберите улицу'));?>
	<?php echo $form->error($model,'street_id'); ?>
</div>

<div class="row">
	<?php echo $form->labelEx($model,'house'); ?>
	<?php echo $form->textField($model,'house',array('size'=>10,'maxlength'=>10)); ?>
	<?php echo $form->error($model,'house'); ?>
</div>

<div class="row">
	<?php echo $form->labelEx($model,'building'); ?>
	<?php echo $form->textField($model,'building',array('size'=>10,'maxlength'=>10)); ?>
	<?php echo $form->error($model,'building'); ?>
</div>
