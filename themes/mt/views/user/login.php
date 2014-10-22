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
<!--<link rel="stylesheet" type="text/css" href="css/calendar.vf2b02623.css">-->
<!---->
<!--<link rel="stylesheet" type="text/css" href="css/deallist.va74827b7.css">-->
<!---->
<link rel="stylesheet" type="text/css" href="/themes/mt/css/deal.v80160138.css">
<!--详情内容-->
<link rel="stylesheet" type="text/css" href="/themes/mt/css/side.v1f71ae5a.css">
<!--右侧最近浏览-->
<link rel="stylesheet" type="text/css" href="/themes/mt/css/qrcode.v3a71112c.css">
<!--右侧扫一扫-->
<link rel="stylesheet" type="text/css" href="/themes/mt/css/ratelist.vf90b4cdd.css">
<!--评论列表-->
<link rel="stylesheet" type="text/css" href="/themes/mt/css/side-deals.vcf443bab.css">
<style>
    .ilogin{z-index:999;width:280px;height:330px;background:rgba(255,255,255,.8);position: absolute;top:30px; right:30px;}
    .ilogin iframe{border:0;}
</style>

<div id="bdw" class="bdw">
    <div id="bd" class="cf" style="width:1010px;position: relative;">
        <div>
            <div><img src="/themes/mt/img/login_bg.jpg" width="100%" height="500"/></div>
            <div class="ilogin">
                <?php 
                    $forward = $this->request->getUrlReferrer();
                    $goto = urlencode(Yii::app()->createAbsoluteUrl('user/login?forward='.urlencode($forward))); 
                ?>
                <iframe src="<?php echo 'http://i.anarry.com/login/fast?goto=' . $goto . (isset($_GET['logout']) ? '&logout=true' : ''); ?>" style="width:100%;height:100%;" scrolling="no"></iframe>
            </div>
            <div style="clear:both;"></div>

        </div>
    </div>
</div>