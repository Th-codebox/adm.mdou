<table border="0" width="100%">
<tr><th>Выбранные специализации</th><th>&nbsp;</th><th width="100%">Список специализаций</th></tr>
<tr>
	<td>
		<?php echo $form->dropDownList($model, 'diseases', CHtml::listData($model->diseases, 'id', 'name'),
			array('size' => 3, 'style' => 'width: 300px;', 'multiple'=>'multiple'));?>
		<br/>
	</td>
	<td valign="middle">
		<?php echo CHtml::button('>>>', array('onClick' => 'DeleteItem("disease");'))?>
		<br/><br/>
		<?php echo CHtml::button('<<<', array('onClick' => 'AddItem("disease");'))?>
	</td>

	<td><?php echo CHtml::dropDownList('diseaseList', '0', 
		CHtml::listData(Disease::model()->findAll(array('order'=>'name ASC')),
			'id', 'name'), array('size' => 10, 'style' => 'width: 300px;'));?></td>
</tr>
</table>
