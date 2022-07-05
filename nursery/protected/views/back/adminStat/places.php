<?php
$this->breadcrumbs=array(
	'Статистика'=>array('index'),
	'Количество освободившихся мест в МДОУ'
);?>
<h1>Количество освободившихся мест в МДОУ</h1>

<h2>По возрастным группам</h2>

<table border="1" width="50%" class="border_table">
<tr><th>Возрастная группа</th><th>Количество мест</th></tr>

<?php foreach ($stat->getPlaceCountByAge() as $row): ?>
<tr>
	<td><?php echo $row['age']; ?></td>
	<td><?php echo $row['cnt']; ?></td>
</tr>
<?php endforeach; ?>

</table>

<h2>По МДОУ</h2>
<table border="1" width="50%" class="border_table">
<tr><th>МДОУ</th><th>Количество мест</th></tr>

<?php foreach ($stat->getPlaceCountByNursery() as $row): ?>

<tr>
	<td><?php echo $row['nursery']; ?></td>
	<td><?php echo $row['cnt']; ?></td>
</tr>
<?php endforeach; ?>

</table>

<h2>По МДОУ и возрастным группам</h2>
<table border="1" width="50%" class="border_table">
<tr>
	<th>МДОУ</th>
	<?php foreach ($groups as $group): ?>
		<th><?php echo $group->getName(); ?></th>
	<?php endforeach; ?>
</tr>

<?php foreach (Nursery::model()->findAll(array('order'=>'short_number')) as $nursery): ?>
<tr>
	<td><?php echo $nursery->short_name; ?></td>
	<?php foreach ($groups as $group): ?>
		<td><?php echo $stat->getPlaceCountByNurseryAge($nursery, $group); ?>
	<?php endforeach; ?>
</tr>
<?php endforeach; ?>

</table>

