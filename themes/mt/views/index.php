<!doctype html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title><?php echo $this->title; ?></title>
        <link rel="stylesheet" type="text/css" href="/themes/mt/css/cate-nav.v3da0d80d.css" />
        <link rel="stylesheet" type="text/css" href="/themes/mt/css/holy-reco.v1bdfdede.css" />
        <script src="/assets/plugins/jquery.min.js"></script>
        <script src="/themes/mt/js/ui.js"></script>
        <script src="/themes/mt/js/common.js"></script>
        <script src="/themes/mt/js/navleft.js"></script>
        <script src="/themes/mt/js/rg__focus.js"></script>
    </head>
    <body class="pg-floor pg-deal pg-deal-default pg-deal-detail pg-buy pg-cart">
        <?php $this->renderPartial("/layouts/header", $this->data); ?>

        <div id="bdw" class="bdw">
            <div class="site-wrapper cf">
            <?php 
                $this->renderPartial("/site/index_header", $this->data); 
                $this->renderPartial("/site/index_floors", $this->data); 
            ?>
            </div>
        </div>
        
        <?php $this->renderPartial("/layouts/footer", $this->data); ?>
    </body>
</html>