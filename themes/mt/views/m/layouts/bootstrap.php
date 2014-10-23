<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="">
        <meta name="author" content="">
        <title><?php echo Yii::app()->name; ?></title>

        <!-- Bootstrap core CSS -->
        <link href="<?php echo Yii::app()->theme->baseUrl; ?>/bootstrap/css/bootstrap.min.css" rel="stylesheet">
        <!-- Bootstrap theme -->
        <link href="<?php echo Yii::app()->theme->baseUrl; ?>/bootstrap/css/bootstrap-theme.min.css" rel="stylesheet">
        <link href="<?php echo Yii::app()->theme->baseUrl; ?>/m/css/theme.css" rel="stylesheet">
        <link rel="stylesheet" href="/themes/mt/mobile/css/shopcart.css" />
        <link rel="stylesheet" href="/themes/mt/mobile/css/product_detail.css" />
        <link rel="stylesheet" type="text/css" href="/themes/mt/mobile/css/navigation.css" />
        <link rel="stylesheet" href="/themes/mt/mobile/css/personal_center.css" />
        <link rel="stylesheet" type="text/css" href="/themes/mt/mobile/css/order_detail.css" />
        <link rel="stylesheet" href="/themes/mt/mobile/css/order_list.css" />
        <link rel="stylesheet" type="text/css" href="/themes/mt/mobile/css/product_list.css" />
        <link rel="stylesheet" href="/themes/mt/mobile/css/shopcart.css" />

        <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!--[if lt IE 9]>
          <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
          <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
        <![endif]-->
    </head>
    <body role="document" style="padding-top:45px;">
        <div class="navbar navbar-inverse navbar-fixed-top" role="navigation">
            <a class="arrow-wrap float-left" href="javascript:history.back()" mon="element=back">
                <span class="arrow-left"></span>
            </a>
            <div class="money_bag text-center">
                <span class="title"><?php echo Yii::app()->name; ?></span>
            </div>
            <a href="/m" class="home" mon="element=home"></a>
        </div>
        <div class="container" role="main">
            <?php echo $content; ?>
        </div> <!-- /container -->
        <!-- Bootstrap core JavaScript
        ================================================== -->
        <!-- Placed at the end of the document so the pages load faster -->
        <script src="/assets/plugins/jquery.v2.1.1.js"></script>
        <script src="/themes/mt/js/mobile.js"></script>
        <script src="<?php echo Yii::app()->theme->baseUrl; ?>/bootstrap/js/bootstrap.min.js"></script>

    </body>
</html>
