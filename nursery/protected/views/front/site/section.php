<?php $this->pageTitle=Yii::app()->name; ?>

<?php if ($node->id != Node::$ROOT_ID):?>
<h1><?php echo $node->name; ?></h1>
<?php endif; ?>

<?php if (count($node->children) > 0 && $node->is_show_children):?>
	<?php foreach ($node->children as $child): ?>
		<?php if (!$child->status_id) continue;?>
		<br/><br/>
		<?php echo $child->getFrontUrl(array('class'=>'sTitle')); ?>
			<?php if ($child->getDesc() != ""):?>
				<br/><span class="ann"><?php echo $child->getDesc();?></span>
			<?php endif;?>
		<?php if (count($child->children) > 0 && $node->getShowExpandedChildren()):?>
		<ul class="list">
			<?php foreach ($child->children as $childNext): ?>
				<?php if (!$childNext->status_id) continue; ?>
				<li><?php echo $childNext->getFrontUrl(array('class'=>'sTitle_2')); ?>
					<?php if ($childNext->getDesc() != ""):?>
						<br/><span class="ann"><?php echo $childNext->getDesc();?></span>
					<?php endif;?>
				</li>
			<?php endforeach; ?>
		</ul>
		<?php endif; ?>
	<?php endforeach; ?>
		
<?php endif; ?>
		

<?php if( $node->getText()):?>
<DIV class="text">

<?php echo $node->getText(); ?>
</div>

<?php if ($files):?>
	<div class="bar"></div>
	<img src="<?php echo Yii::app()->request->baseUrl; ?>/images/front/point.gif" width="10" height="7" alt=""/>&nbsp; <b>Файлы для скачивания</b><br>
	<?php foreach ($files as $file):?>
		<img src="<?php echo Yii::app()->request->baseUrl; ?>/images/front/appicons/<?php echo $file->getFileTypeImage(); ?>.png" width="16" height="16" align="absmiddle" alt="" style="margin: 7px 2px 2px 0px;"/>&nbsp; <a href="<?php echo $file->getHttpPath();?>" target="_blank"><?php echo $file->getName();?></a> (*.<?php echo $file->extension;?>, <?php echo $file->getSize();?>)
		<br/><br/>
	<?php endforeach;?>
<?php endif;?>

<DIV class="for_print">
	  <a href="?preview=on&id=<?php echo $node->id; ?>" target="_blank">
	  	    <IMG SRC="<?php echo Yii::app()->request->baseUrl; ?>/images/front/print.gif" WIDTH="16" HEIGHT="16" ALT="" BORDER="0" ALIGN="absmiddle">&nbsp;&nbsp;Версия для печати</a>
</DIV>
<?php endif; ?>