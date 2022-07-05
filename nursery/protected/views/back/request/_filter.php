<!--<div align="right"><?php echo CHtml::link("Скрыть фильтры", array("request/index")); ?></div>-->
<?php echo CHtml::beginForm(array('request/index'), 'GET'); ?>
<table border="0" cellpadding="5">
<tr>
	<td>
		<b>Тип очереди</b><br/>
		<?php echo CHtml::dropDownList("Request_queueType", (isset($_GET['Request_queueType']) ? $_GET['Request_queueType'] : '0'),
			Request::model()->getQueueOptions(), array('style'=>'width: 200px;'));?>
	</td>
	<td>
		<b>Возраст</b><br/>
		<?php echo CHtml::dropDownList("Request_age", (isset($_GET['Request_age']) ? $_GET['Request_age'] : ''),
			Util::getAgeOptions(), array( 'prompt' => ''));?>
	</td>
	<td>
		<b>Район</b><br/>
		<?php echo CHtml::dropDownList('Request_microdistrict', (isset($_GET['Request_microdistrict']) ? $_GET['Request_microdistrict'] : ""),
			$microdistricts,
			array(
				'style'=>'width: 200px;',
				'empty'=>array(''=>'', '0'=>'Другой адрес'),
				'ajax'=>array(
					'type'=>'POST', //request type
					'url'=>CController::createUrl('microdistrict/ajaxStreets'), //url to call.
					//Style: CController::createUrl('currentController/methodToCall')
					'update'=>'#Request_street', //selector to update
					'data'=>array('microdistrict_id'=>'js:this.value', 'is_empty'=>1),
					//leave out the data key to pass all form values through
				)
			));?>
	</td>

</tr>
<tr>
	<td>
		<b>Статус заявления</b><br/>
		<?php echo CHtml::dropDownList("Request_status", (isset($_GET['Request_status']) ? $_GET['Request_status'] : '50'),
			Request::getStatusOptionsClient(), array('prompt' => '', 'style'=>'width: 200px;'));?>
	</td>
	
	<td>
		<b>Льгота</b><br/>
		<?php echo CHtml::dropDownList("Request_privilege", (isset($_GET['Request_privilege']) ? $_GET['Request_privilege'] : 0),
			$privileges, array( 'prompt' => '', 'style'=>'width: 200px;'));?>
	</td>
	<td>
		<b>Улица</b><br/>
		<?php echo CHtml::dropDownList("Request_street", (isset($_GET['Request_street']) ? $_GET['Request_street'] : 0),
			$streets, array( 'prompt' => '', 'style'=>'width: 200px;'));?>
	</td>
</tr>
<tr>
	<td>
		<b>Архив</b><br/>
		<?php echo CHtml::dropDownList("Request_archive", (isset($_GET['Request_archive']) ? $_GET['Request_archive'] : 'not'),
			array('not'=>'', 'yes'=>'В архиве', 'all'=>'Все')); ?>
	</td>
	<td>
		<b>Специализация</b><br/>
		<?php echo CHtml::dropDownList("Request_disease", (isset($_GET['Request_disease']) ? $_GET['Request_disease'] : '0'),
			$diseases, array('prompt' => '', 'style'=>'width: 200px;'));?>
	</td>
	<td>
		<b>Желаемое МДОУ</b><br/>
		<?php echo CHtml::dropDownList("Request_nursery", (isset($_GET['Request_nursery']) ? $_GET['Request_nursery'] : 0),
			$nurseries, array( 'prompt' => '', 'style'=>'width: 200px;'));?>
	</td>
</tr>

<tr><td colspan="3"><br/><br/></td></tr>
<tr>
	<td colspan="3">
		<b>Дата </b>
		<?php echo CHtml::dropDownList("Request_dateType", (isset($_GET['Request_dateType']) ? $_GET['Request_dateType'] : 'birth_date'),
			array(''=>'', 'birth_date'=>'рождения', 'filing_date'=>'заполнения', 'register_date'=>'регистрации'));?>
		<br/>
		с 
		<?php $this->widget('zii.widgets.jui.CJuiDatePicker', array(
			'name'=>'Request_dateFrom',
			'language'=>'ru',
			'value' => isset($_GET['Request_dateFrom']) ? $_GET['Request_dateFrom'] : '',
			// additional javascript options for the date picker plugin
			'options'=>array(
				'showAnim'=>'fold',
				'changeMonth' => 'true',
				'changeYear' => 'true',
				'showButtonPanel' => 'true',
				'constrainInput' => 'false',
        		'dateFormat' => 'yy-mm-dd',
				'maxDate' => "+0d"
    		),
    		'htmlOptions'=>array(
    			'style'=>'height:20px;',
//				'readonly'=>'readonly'
			),
		));?>
		по 
		<?php $this->widget('zii.widgets.jui.CJuiDatePicker', array(
			'name'=>'Request_dateTo',
			'language'=>'ru',
			'value' => isset($_GET['Request_dateTo']) ? $_GET['Request_dateTo'] : '',
			// additional javascript options for the date picker plugin
			'options'=>array(
				'showAnim'=>'fold',
				'changeMonth' => 'true',
				'changeYear' => 'true',
				'showButtonPanel' => 'true',
				'constrainInput' => 'false',
        		'dateFormat' => 'yy-mm-dd',
				'maxDate' => "+0d"
    		),
    		'htmlOptions'=>array(
    			'style'=>'height:20px;',
//				'readonly'=>'readonly'
			),
		));?>

	</td>
</tr>
<tr><td colspan="3"><br/><br/></td></tr>
<tr>
	<td>
		<b>Ключевое слово </b>
		<?php echo CHtml::dropDownList("Request_wordsType", (isset($_GET['Request_wordsType']) ? $_GET['Request_wordsType'] : 'full_name'),
			array(
				'full_name'=>'ФИО', 
				'document'=>'№ св-ва о рождении', 
				'surname'=>'Фамилия', 
				'address'=>'Другой адрес', 
				'id'=>'ID', 
				'code'=>'Код в старой системе',
				'queue_number'=>'Номер в очереди',
			));?>
		<br/>
		<?php echo CHtml::textField("Request_words", (isset($_GET['Request_words']) ? $_GET['Request_words'] : ""), 
			array('size'=>40));?>
	</td>
	<td>
		<b>Количество записей на странице</b><br/>
		<?php echo CHtml::dropDownList("Request_pageSize", (isset($_GET['Request_pageSize']) ? $_GET['Request_pageSize'] : '50'),
			array('0'=>'10', '25'=>'25', '50'=>'50'));?>
	</td>
	<td>
		<b>Способ подачи заявления</b><br/>
		<?php echo CHtml::dropDownList("Request_apply", (isset($_GET['Request_apply']) ? $_GET['Request_apply'] : ''),
			array(''=>'', 'personally'=>'лично', 'internet'=>'интернет'));?>
	</td>
</tr>

<tr><td colspan="3"><br/><br/></td></tr>
<tr>
	<td colspan="2"><input type="submit" value="Применить"></td>
</tr>
</table>
<?php echo CHtml::hiddenField('Request_sort', isset($_GET['Request_sort']) ? $_GET['Request_sort'] : ""); ?>
<?php echo CHtml::endForm(); ?>
