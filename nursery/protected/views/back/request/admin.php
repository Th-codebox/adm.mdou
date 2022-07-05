<?php
$this->breadcrumbs=array(
	'Очередь'
);

$this->menu=array(
	array('label'=>'List Request', 'url'=>array('index')),
	array('label'=>'Manage Request', 'url'=>array('admin')),
);
?>

<h1>Управление очередью</h1>

<div class="row" style="background-color: #C9E0ED; margin-bottom: 10px; width: 20%">
<strong>Всего заявлений:</strong> <?php echo Request::getTotalQueueNumber(); ?><br/>
<strong>Необработанных:</strong> <?php echo Request::getTotalNewNumber(); ?><br/>
<strong>Принятых к рассмотрению:</strong> <?php echo Request::getTotalAcceptedNumber(); ?><br/>
<strong>В архиве:</strong> <?php echo Request::getTotalArchiveNumber(); ?><br/>
<strong>Незаполненных:</strong> <?php echo Request::getTotalNotCompletedNumber(); ?><br/>
</div>

<hr>
<?php echo CHtml::link('Новое заявление', array('request/create'));?><br/><br/>

<?php if(Yii::app()->user->hasFlash('queue')): ?>
	<div class="flash_info">
		<b><?php echo Yii::app()->user->getFlash('queue'); ?></b><br/><br/>
	</div>
<?php endif; ?>

<div class="row" style="margin-bottom: 10px;">
<?php echo CHtml::link("Пересчитать очередь", array("request/renumberQueue"), array(
	'onClick' => 'return confirm("Вы уверены, что хотите пересчитать очередь?")'
)); ?>

</div>
<hr>
<div class="row">
	<ul>
		<li>Единая очередь 
			(
			<?php echo CHtml::link("все", array("request/index", "Request_sort"=>"queue_number", )); ?>
			| 
			<?php echo CHtml::link("активные", array("request/index", "Request_sort"=>"queue_number", "Request_status"=>Request::STATUS_ACTIVE, )); ?>
			|
			<?php echo CHtml::link("все в обратном порядке", array("request/index", "Request_sort"=>"queue_number.desc", )); ?>
			|
			<?php echo CHtml::link("активные в обратном порядке", array("request/index", "Request_sort"=>"queue_number.desc", "Request_status"=>Request::STATUS_ACTIVE, )); ?>
			)
		</li>
		<li>Льготная очередь
			(
			<?php echo CHtml::link("все", array("request/index", "Request_sort"=>"queue_number", "Request_queueType"=>Request::QUEUE_PRIVILEGE, )); ?>
			|
			<?php echo CHtml::link("активные", array("request/index", "Request_sort"=>"queue_number", "Request_status"=>Request::STATUS_ACTIVE, "Request_queueType"=>Request::QUEUE_PRIVILEGE,)); ?>
			|
			<?php echo CHtml::link("все в обратном порядке", array("request/index", "Request_sort"=>"queue_number.desc", "Request_queueType"=>Request::QUEUE_PRIVILEGE, )); ?>
			|
			<?php echo CHtml::link("активные в обратном порядке", array("request/index", "Request_sort"=>"queue_number.desc", "Request_status"=>Request::STATUS_ACTIVE, "Request_queueType"=>Request::QUEUE_PRIVILEGE,)); ?>
			)
		</li>
		<li>Вне очереди
			(
			<?php echo CHtml::link("все", array("request/index", "Request_sort"=>"queue_number", "Request_queueType"=>Request::QUEUE_OUT_OF_QUEUE, )); ?>
			|
			<?php echo CHtml::link("активные", array("request/index", "Request_sort"=>"queue_number", "Request_status"=>Request::STATUS_ACTIVE, "Request_queueType"=>Request::QUEUE_OUT_OF_QUEUE,)); ?>
			|
			<?php echo CHtml::link("все в обратном порядке", array("request/index", "Request_sort"=>"queue_number.desc", "Request_queueType"=>Request::QUEUE_OUT_OF_QUEUE, )); ?>
			|
			<?php echo CHtml::link("активные в обратном порядке", array("request/index", "Request_sort"=>"queue_number.desc", "Request_status"=>Request::STATUS_ACTIVE, "Request_queueType"=>Request::QUEUE_OUT_OF_QUEUE,)); ?>
			)
		</li>
	</ul>

	<ul>
		<li>Необработанные заявления
			(
			<?php echo CHtml::link("по возрастанию номера", array("request/index", "Request_sort"=>"id", "Request_status"=>Request::STATUS_UNPROCESSED, "Request_sort"=>"id.asc")); ?>
			|
			<?php echo CHtml::link("по убыванию номера", array("request/index", "Request_sort"=>"id", "Request_status"=>Request::STATUS_UNPROCESSED, "Request_sort"=>"id.desc")); ?>
			)
		</li>
	</ul>

	<ul>
		<li>Все заявления не в архиве
			(
			<?php echo CHtml::link("по возрастанию номера", array("request/index", "Request_sort"=>"id.asc")); ?>
			|
			<?php echo CHtml::link("по убыванию номера", array("request/index", "Request_sort"=>"id.desc")); ?>
			)
		</li>
	</ul>
	
	<ul>
		<li>Все заявления в архиве
			(
			<?php echo CHtml::link("по возрастанию номера", array("request/index", "Request_sort"=>"id.asc", "Request_archive"=>'yes')); ?>
			|
			<?php echo CHtml::link("по убыванию номера", array("request/index", "Request_sort"=>"id.desc", "Request_archive"=>'yes')); ?>
			)
		</li>
	</ul>
</div>

<hr>

<?php $this->widget('zii.widgets.grid.CGridView', array(
    'dataProvider'=>$dataProvider,
    'ajaxUpdate'=>false,
	'template'=>'<h2>Последние изменения</h2>{summary} {items}',
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
        	'value'=> '$data->getBirthDate()."<br/>".$data->getAgeYears()'
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
        	'value'=>'$data->getPrivileges()',
        ),
        array(
			'name'=>'status',
            'type'=>'raw',
            'value'=>'$data->getStatusName().($data->is_archive ? " (в архиве)" : "")'
        ),
        array(
        	'name'=>'Последняя операция',
        	'type'=>'raw',
        	'value'=>'$data->getLastOperation()'
        ),
        array(
        	'name'=>'update_time',
        	'type'=>'raw',
        	'value'=>'$data->getUpdateTime()',
        ),
		array(
			'name'=>'правка',
			'type'=>'raw',
			'value'=>'$data->getUpdateUser()'
		),
		array(
			'header'=>'',
			'headerHtmlOptions'=>array('style'=>'width: 50px;'),
			'type'=>'raw',
			'value'=>'CHtml::link(CHtml::image(Yii::app()->request->baseUrl."/images/backend/page_white_edit.png"), array("request/update", "id"=>$data->id), array("title"=>"Редактировать параметры заявления"))."&nbsp;".CHtml::link(CHtml::image(Yii::app()->request->baseUrl."/images/backend/page_white_gear.png"), array("request/operation", "id"=>$data->id), array("title"=>"Операции"))',
		),

    ),
)); ?>

<?php
	Yii::app()->clientScript->registerScriptFile(Yii::app()->request->baseUrl.'/js/previewlinks.js', CClientScript::POS_HEAD);
?>

<?php $this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id'=>'viewdialog',
    'theme'=>'cupertino',
	'themeUrl'=>Yii::app()->request->baseUrl.'/css/jui',
    // additional javascript options for the dialog plugin
    'options'=>array(
        'title'=>'Просмотр заявления',
        'autoOpen'=>false,
        'draggable'=>true,
        'resizable'=>true,
		'closeOnEscape' => true,
        'modal'=>true,
//		'show'=>'blind',
//		'hide'=>'blind',
		'width'=>'1000px',
		'height'=>'auto',
		'top'=>'50',
		'position'=>'top',
//		'buttons' => array(
//			'Ok'=>'js:function(){alert("ok")}',
//			'Cancel'=>'js:function(){alert("cancel")}',
//		),
    ),
));?>

<div id="preview"></div>

<?php $this->endWidget('zii.widgets.jui.CJuiDialog');?>
