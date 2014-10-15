<!doctype html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title><?php echo $this->title; ?></title>
        <link rel="stylesheet" type="text/css" href="/themes/mt/css/cate-nav.v3da0d80d.css" />
        <link rel="stylesheet" type="text/css" href="/themes/mt/css/base.vaece46dd.css">
        <link rel="stylesheet" type="text/css" href="/themes/mt/css/common.v4cd3d070.css">
        <link rel="stylesheet" type="text/css" href="/themes/mt/css/search-box.v3ea75c23.css">
        <link rel="stylesheet" type="text/css" href="/themes/mt/css/buy.vfabb6a6b.css">
        
        <script src="/assets/plugins/jquery.min.js"></script>
        <script src="/themes/mt/js/ui.js"></script>
        <script src="/themes/mt/js/common.js"></script>
      
      
    </head>
    <body class="pg-floor pg-deal pg-deal-default pg-deal-detail pg-buy pg-cart">
        <?php //$this->renderPartial("/layouts/header", $this->data); ?>

        <div id="bdw" class="bdw">
            <?php echo $content; ?>
        </div>
        
        <?php //$this->renderPartial("/layouts/footer", $this->data); ?>
    </body>
</html>