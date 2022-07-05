<?php
$this->breadcrumbs=array(
	'Пользователи',
);

$this->menu=array(
	array('label'=>'Create User', 'url'=>array('create')),
	array('label'=>'Manage User', 'url'=>array('admin')),
);
?>

<h1>Пользователи</h1>
<?php if(Yii::app()->user->hasFlash('useroperation')): ?>
	<div class="flash_info">
		<b><?php echo Yii::app()->user->getFlash('useroperation'); ?></b><br/><br/>
	</div>
<?php endif; ?>

<?php echo CHtml::link('Новый пользователь', array('user/create'));?>
<?php $this->widget('zii.widgets.grid.CGridView', array(
    'dataProvider'=>$dataProvider,
    'ajaxUpdate'=>false,
	'template'=>'{summary} {pager} {items} {pager}',
    'summaryText'=>'Пользователи: {start} - {end} из {count}.',
    'columns'=>array(
        array(
            'name'=>'id',
        ),
        array(
            'name'=>'username',
        ),
        array(
            'name'=>'name',
        ),
        array(
            'name'=>'Роли',
            'type'=>'raw',
            'value'=>'$data->getRoleNames()'
        ),        
        array(
        	'name'=>'last_login_time',
        ),
        array(
        	'name'=>'create_time'
        ),
        array(
        	'name'=>'',
        	'type'=>'raw',
            'value'=>'CHtml::link("сменить пароль", array("user/newPassword", "id"=>$data->id))'
        ),
		array(
			'class'=>'CButtonColumn',
			'deleteConfirmation'=>'Вы уверены, что хотите удалить пользователя?',
			'template'=>'{update} {delete}',
		),
    ),
)); ?>
