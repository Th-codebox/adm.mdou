<div>
<?php $labels = $model->attributeLabels();?>
<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'code',
		'reg_number',
		array(
			'label' => $labels['full_name'],
			'value' => $model->getFullName(),
		),
		array(
			'label' => $labels['status'],
			'value' => $model->getStatusName().($model->is_archive ? " (в архиве)" : ""),
		),
		array(
			'label' => $labels['is_internet'],
			'value' => $model->getIsInternet(),
		),
		array(
			'label' => 'Номер в очереди',
			'value' => $model->getQueueNumber(),
		),
		array(
			'label' => $labels['filing_date'],
        	'value'=> $model->getFilingDate(),
		),
		array(
			'label' => $labels['register_date'],
        	'value'=> $model->getRegisterDate(),
		),
		array(
			'label' => $labels['birth_date'],
        	'value'=> $model->getBirthDate(),
		),
		array(
			'label' => 'Свидетельство о рождении',
			'value' => $model->getBirthDocument(),
		),
		array(
			'label' => $labels['address'],
			'value' => $model->getFullAddress(),
		),
		'phone',
		'email',
		array(
			'label' => $labels['out_of_queue'],
			'value' => $model->out_of_queue > 0 ? "да" : "нет",	
		),
		array(
			'label' => $labels['has_privilege'],
			'value' => $model->has_privilege > 0 ? "есть" : "нет",	
		),
		array(
			'label' => 'Список льгот',
			'value' => $model->getPrivilegeList(),
		),
		array(
			'label' => 'Список указанных МДОУ',
			'value' => $model->getNurseries(),
		),
		array(
			'label' => 'Родители / законные представители',
			'type' => 'html',
			'value' => $this->renderPartial('_person', array('request'=>$model), true)
		),
		array(
			'label' => $labels['create_time'],
        	'value'=> date("d.m.Y H:i:s", CDateTimeParser::parse($model->create_time, "yyyy-MM-dd HH:mm:ss")),
        ),
		array(
			'label' => $labels['update_time'],
        	'value'=> date("d.m.Y H:i:s", CDateTimeParser::parse($model->update_time, "yyyy-MM-dd HH:mm:ss")),
        ),
        'comment'
	),
)); ?>
</div>