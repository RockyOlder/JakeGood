
<!DOCTYPE HTML>
<html lang="zh-CN">
    <head>
        <meta charset="utf-8">
        <title><?php echo Yii::app()->name; ?></title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0"  />
        <meta name="apple-mobile-web-app-capable" content="yes">
        <meta name="apple-mobile-web-app-status-bar-style" content="black">
        <meta name="format-detection" content="telephone=no">
        <meta http-equiv="x-dns-prefetch-control" content="on" />
        <link href="<?php echo Yii::app()->theme->baseUrl; ?>/bootstrap/css/bootstrap.min.css" rel="stylesheet">
        <!-- Bootstrap theme -->
        <link href="<?php echo Yii::app()->theme->baseUrl; ?>/bootstrap/css/bootstrap-theme.min.css" rel="stylesheet">
        <link href="<?php echo Yii::app()->theme->baseUrl; ?>/m/css/theme.css" rel="stylesheet">
        <link rel="stylesheet" href="/themes/mt/mobile/css/order_list.css" />
        <script type="text/javascript" src="/themes/mt/js/jquery-1.11.1.min.js"></script>
     
    </head>
    <body>

        <div id="bdw" class="bdw">
            <?php echo $content; ?>
        </div>
        <script src="/assets/plugins/jquery.v2.1.1.js"></script>
        <script src="/themes/mt/js/mobile.js"></script>
           <script src="/themes/mt/js/common.js"></script>
        <script src="<?php echo Yii::app()->theme->baseUrl; ?>/bootstrap/js/bootstrap.min.js"></script>

    </body>
</html>