<?php $this->widget('zii.widgets.grid.CGridView', array(
    'dataProvider'=>$dataProvider,
    'ajaxUpdate'=>false,
	'afterAjaxUpdate'=>'function(id, data) {$.fn.setPreviewLinksHandler(id, data); $("#viewdialog").dialog("open");}',
	'template'=>'{summary} {pager} {items} {pager}',
    'summaryText'=>'Заявления: {start} - {end} из {count}.',
    'emptyText'=>'<b>Не найдены заявления, удовлетворяющие указанным условиям</b>',
    'columns'=>array(
        array(
            'name'=>'id',
        ),
        array(
            'name'=>'queue_number',
            'type'=>'raw',
            'value'=>'CHtml::link(CHtml::image(Yii::app()->request->baseUrl."/images/backend/clock.png"), array("request/queueLog", "id"=>$data->id), array("title"=>"История изменения номера очереди"))."&nbsp;".$data->queue_number'
        ),
        array(
        	'name'=>'reg_number',
        ),
        array(
        	'name'=>'filing_date',
        	'type'=>'raw',
        	'value'=> '$data->getFilingDate()."<br/>".($data->is_internet ? "интернет" : "лично")'
        ),
        array(
            'name'=>'full_name',
            'type'=>'raw',
			'value'=>'CHtml::link(CHtml::image(Yii::app()->request->baseUrl."/images/backend/page_white_magnify.png"), array("request/view", "id"=>$data->id, "ajax"=>"preview"), array("title"=>"Просмотр заявления", "name"=>"previewLink"))."&nbsp;".$data->getFullName()'
        ),
        array(
        	'name'=>'birth_date',
        	'type'=>'raw',
        	'value'=> '$data->getBirthDate()."&nbsp;(".$data->getAgeYears().")"'
        ),
        array(
			'name'=>'address',
			'type'=>'raw',
			'value'=>'CHtml::link(CHtml::encode($data->getAddress()), "http://maps.yandex.ru/?text=".$data->getMapAddress(), array("target"=>"_blank"))'
        ),
        array(
        	'name'=>'nurseries',
        	'value'=>'$data->getNurseries()',
        ),
        array(
        	'name'=>'privileges',
        	'type'=> 'raw',
        	'value'=>'$data->has_privilege ? CHtml::link($data->getPrivileges(), "#", array("onclick"=>"return false; ", "title"=>$data->getPrivilegeList())) : "нет"',
        ),
        array(
			'name'=>'status',
            'type'=>'raw',
            'value'=>'$data->getStatusName().($data->is_archive ? " (в архиве)" : "")'
        ),
        array(
        	'name'=>'update_time',
        	'type'=>'raw',
        	'value'=>'$data->getUpdateTime()',
        ),
		array(
			'header'=>'',
			'headerHtmlOptions'=>array('style'=>'width: 50px;'),
			'type'=>'raw',
			'value'=>'CHtml::link(CHtml::image(Yii::app()->request->baseUrl."/images/backend/page_white_edit.png"), array("request/update", "id"=>$data->id), array("title"=>"Редактировать параметры заявления"))."&nbsp;".CHtml::link(CHtml::image(Yii::app()->request->baseUrl."/images/backend/page_white_gear.png"), array("request/operation", "id"=>$data->id), array("title"=>"Операции"))',
		),
    ),
)); ?>

