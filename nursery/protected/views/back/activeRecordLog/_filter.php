<?php echo CHtml::beginForm(array('activeRecordLog/index'), 'GET'); ?>

<table border="0" cellpadding="5">
<tr><td colspan="3"><br/><br/></td></tr>
<tr>
	<td colspan="2" valign="top">
		<b>Дата операции</b><br />
		с 
		<?php $this->widget('zii.widgets.jui.CJuiDatePicker', array(
			'name'=>'ActiveRecordLog_dateFrom',
			'language'=>'ru',
			'value' => isset($_GET['ActiveRecordLog_dateFrom']) ? $_GET['ActiveRecordLog_dateFrom'] : '',
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
			'name'=>'ActiveRecordLog_dateTo',
			'language'=>'ru',
			'value' => isset($_GET['ActiveRecordLog_dateTo']) ? $_GET['ActiveRecordLog_dateTo'] : '',
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
		<b>Тип объекта </b>
		<?php echo CHtml::dropDownList("ActiveRecordLog_modelType", (isset($_GET['ActiveRecordLog_modelType']) ? $_GET['ActiveRecordLog_modelType'] : ''),
			array(
				''=>'',
				'Request'=>'Заявление',
				'User'=>'Пользователь',
				'Nursery'=>'МДОУ',
				'Node'=>'Раздел сайта',
				'RequestNurseryDirection'=>'Направление',
				
			));?>
		<br/>
		<?php echo CHtml::textField("ActiveRecordLog_modelId", (isset($_GET['ActiveRecordLog_modelId']) ? $_GET['ActiveRecordLog_modelId'] : ""), 
			array('size'=>40));?>
	</td>
	<td>
		<b>Количество записей на странице</b><br/>
		<?php echo CHtml::dropDownList("ActiveRecordLog_pageSize", (isset($_GET['ActiveRecordLog_pageSize']) ? $_GET['ActiveRecordLog_pageSize'] : '50'),
			array('0'=>'10', '25'=>'25', '50'=>'50'));?>
	</td>
</tr>

<tr><td colspan="3"><br/><br/></td></tr>
<tr>
	<td colspan="2"><input type="submit" value="Применить"></td>
</tr>
</table>
<?php echo CHtml::endForm(); ?>
