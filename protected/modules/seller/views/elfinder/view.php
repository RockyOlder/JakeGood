<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta name="language" content="en"/>
    <title><?php echo CHtml::encode($this->pageTitle); ?></title>
    <?php Yii::app()->getClientScript(); ?>
	<script type="text/javascript" src="<?php echo $this->baseUrl; ?>/assets/plugins/jquery.migrate.js"></script>
	<style type="text/css">
		body{padding: 0;margin: 0}
	</style>
</head>
<body>
<?php
$this->widget('ext.elFinder.ElFinderWidget', array(
        'connectorRoute' => 'seller/elfinder/connector',
    )
);
?>
</body>
</html>