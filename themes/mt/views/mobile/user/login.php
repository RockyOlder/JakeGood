
<!DOCTYPE HTML>
<html lang="zh-CN">
    <head>
        <meta charset="utf-8">
        <title>登陆</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0"  />
        <meta name="apple-mobile-web-app-capable" content="yes">
        <meta name="apple-mobile-web-app-status-bar-style" content="black">
        <meta name="format-detection" content="telephone=no">
        <meta http-equiv="x-dns-prefetch-control" content="on" />
        <link rel="stylesheet" type="text/css" href="/themes/mt/mobile/css/index.css" />
        <script src="/themes/mt/js/list.js"></script>
        <script src="/themes/mt/js/deal.js"></script>
        <link rel="stylesheet" type="text/css" href="/themes/mt/css/common.v4cd3d070.css">
        <!--顶部-->
        <link rel="stylesheet" type="text/css" href="/themes/mt/css/base.vaece46dd.css">
        <!--框架结构-->
        <link rel="stylesheet" type="text/css" href="/themes/mt/css/search-box.v3ea75c23.css">
        <!--搜索栏-->
        <link rel="stylesheet" type="text/css" href="/themes/mt/css/cate-nav.v8aeee1b4.css">
        <!--弹出菜单导航-->
        <style>
            .ilogin{z-index:999;width:300px;height:380px;background:rgba(255,255,255,.8);position: absolute;top:30px; right:30px;}
            .ilogin iframe{border:0;}
        </style>
    </head>
    <body>
        <div class="ilogin">
            <?php
            $forward = $this->request->getUrlReferrer();
            $goto = urlencode(Yii::app()->createAbsoluteUrl('user/login?forward=' . urlencode($forward)));
            //   print_r($goto);exit;
            ?>
            <iframe src="<?php echo 'http://i.anarry.com/login/fast?goto=' . $goto . (isset($_GET['logout']) ? '&logout=true' : ''); ?>" style="width:100%;height:100%;" scrolling="no"></iframe>
        </div>

        <div class="wx_wrap">
            <div id="brandDiv">

            </div>
        </div>

    </div>

</div>
<div class="wx_nav">
    <a class="nav_index on" href="#">购物</a>
    <a class="nav_search" href="#">搜索</a>
    <a class="nav_shopcart" href="#">购物车</a>
    <a class="nav_me" href="#">个人中心</a>
</div>
</body>
</html>
