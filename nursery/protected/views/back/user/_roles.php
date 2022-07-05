<table border="0" width="100%">
<tr><th>Выбранные роли</th><th>&nbsp;</th><th width="100%">Список ролей</th></tr>
<tr>
	<td>
		<?php echo CHtml::dropDownList('roles[]', '', $model->getRoles(), array('size' => 3, 'style' => 'width: 300px;', 'multiple'=>'multiple', 'id'=>'roles'));?>
		<br/>
	</td>
	<td valign="middle">
		<?php echo CHtml::button('>>>', array('onClick' => 'DeleteItem();'))?>
		<br/><br/>
		<?php echo CHtml::button('<<<', array('onClick' => 'AddItem();'))?>
	</td>

	<td><?php echo CHtml::dropDownList('roleList', '0', User::getUserRoleOptions(), array('size' => 10, 'style' => 'width: 300px;'));?></td>
</tr>
</table>

