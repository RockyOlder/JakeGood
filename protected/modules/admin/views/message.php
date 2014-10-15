<?php $this->renderPartial('/_include/header', array('title' => $title));?>

<div>
	<?php echo $content ?>
</div>
<button type="button" class="btn" onclick="window.location='<?php echo $this->createUrl('list'); ?>'">返回</button>

<?php $this->renderPartial('/_include/footer');?>