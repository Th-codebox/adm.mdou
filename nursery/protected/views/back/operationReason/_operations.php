<table border="0" width="100%">
<tr><th>Выбранные операции</th><th>&nbsp;</th><th width="100%">Список операций</th></tr>
<tr>
	<td>
		<?php echo $form->dropDownList($model, 'operations', CHtml::listData($model->operations, 'id', 'name'),
			array('size' => 3, 'style' => 'width: 300px;', 'multiple'=>'multiple'));?>
		<br/>
	</td>
	<td valign="middle">
		<?php echo CHtml::button('>>>', array('onClick' => 'DeleteItem();'))?>
		<br/><br/>
		<?php echo CHtml::button('<<<', array('onClick' => 'AddItem();'))?>
	</td>

	<td><?php echo CHtml::dropDownList('operationList', '0', 
		CHtml::listData(Operation::model()->findAll(array('order'=>'name ASC')),
			'id', 'name'), array('size' => 10, 'style' => 'width: 300px;'));?></td>
</tr>
</table>
