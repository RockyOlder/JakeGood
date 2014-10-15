<!doctype html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title><?php echo $this->title; ?></title>
        <link rel="stylesheet" type="text/css" href="/themes/mt/css/cate-nav.v3da0d80d.css" />
        <link rel="stylesheet" type="text/css" href="/themes/mt/css/base.vaece46dd.css">
        <link rel="stylesheet" type="text/css" href="/themes/mt/css/common.v4cd3d070.css">
        <link rel="stylesheet" type="text/css" href="/themes/mt/css/table-section.vfa4da119.css">
        <link rel="stylesheet" type="text/css" href="/themes/mt/css/order.v8faf7efe.css">
        <link rel="stylesheet" type="text/css" href="/themes/mt/css/order-list.vb368002e.css">
        <link rel="stylesheet" type="text/css" href="/themes/mt/css/order-nav.v06a870bb.css">
        <script src="/assets/plugins/jquery.min.js"></script>
        <script src="/themes/mt/js/ui.js"></script>
        <script src="/themes/mt/js/common.js"></script>
        <script src="/themes/mt/js/cart.js"></script>

        <style>            
            /*---------------------Default Form Style--------------------------------*/
            .block_form {margin:0px auto 0px;}
            .block_form p {padding-bottom:0px;}
            .block_form .col_1 {width:378px; float:left;}
            .block_form .col_2 {width:332px; float:right;}
            .block_form .label {float:left;width:100px;height:29px; text-align: right; margin-left:20px; padding-right: 10px;}
            .block_form .label p {font-size:12px; color:#676767; line-height:29px;}
            .block_form .label span {color:#e50303;font-size: 12px;}
            .block_form .tips {height:29px; line-height:29px;float:left;}
            .block_form #img-area{margin-left: 20px;}
            .block_form #img-area .img-item{margin: 10px;}

            #content .block_form .field {width:550px;height:29px;float:left;border: 0;padding: 0}
            .block_form .field label {width:auto;height:29px; line-height:29px; float:left;}
            .block_form .field label.error {color:#e94b4b;}
            .block_form .field input {float:left;width:241px; height:14px; line-height:14px; margin-left:0; padding:5px; display:block; border:1px solid #e6e6e6; font-size:12px; color:#676767;}
            .block_form .field select {float:left; height:24px; line-height:24px; margin-right:5px; display:block; border:1px solid #e6e6e6; font-size:12px; color:#676767;}
            .block_form .field input.error {border:1px solid #e94b4b;}
            .block_form .field select.error {border:1px solid #e94b4b;color:#676767;}
            .block_form .select {
                min-width:80px;
                height:27px;
                margin-right:10px;
                float:left;
                position:relative;

                background:url(images/bg_custom_select_1.gif) no-repeat right 5px #ffffff;
                border:1px solid #e6e6e6;

                -moz-border-radius:2px;
                -webkit-border-radius:2px;
                border-radius:2px;

                behavior:url(js/PIE.htc);

                cursor:pointer;
            }
            .block_form .select select {min-width:80px; padding-top:9px; display:block; position:absolute; left:0px; top:0px; font-family:Arial, Helvetica, sans-serif; font-size:12px; color:#676767; cursor:pointer; z-index:2;}
            .block_form .select span {min-width:30px; height:27px; line-height:27px; display:block; overflow:hidden; position:absolute; left:10px; top:0px; font-size:12px; color:#676767; white-space:nowrap; cursor:pointer; z-index:1;}

            .block_form .textarea {width:auto;float:left;}
            .block_form .textarea textarea {width:400px; margin-left:0; padding:5px; border:1px solid #e6e6e6; font-size:12px; color:#676767;}
            .block_form .textarea textarea.error {border:1px solid #e94b4b;}

            .block_form .info_text {padding-bottom:19px; font-size:12px; color:#969696; line-height:normal; text-align:center;}
            .block_form .info_text a {font-size:12px; color:#969696; text-decoration:underline;}
            .block_form .info_text a:hover {text-decoration:none;}
            .block_form .general_button {margin-bottom:-2px; padding-left:8px; padding-right:8px;}

            #content .general_info_box {
                padding:14px 44px 15px 18px;
                position:relative;

                -moz-border-radius:3px;
                -webkit-border-radius:3px;
                border-radius:3px;

                behavior:url(layout/plugins/PIE.htc);
            }
            .general_info_box p {padding-bottom:0px; line-height:18px;}
            .general_info_box .close {width:16px; height:16px; display:block; position:absolute; right:14px; top:16px; background-repeat:no-repeat; background-position:4px 4px;}

            #content .general_info_box.error {background-color:#ffeded; border:1px solid #f7cbcb;height: auto;}
            #content .general_info_box.error p {color:#e94b4b;}
            #content .general_info_box.error a {color:#e94b4b;}
        </style>
    </head>
    <body class="has-order-nav">
        <?php $this->renderPartial("/layouts/header", $this->data); ?>
        <div id="bdw" class="bdw">
            <div id="bd" class="cf">
                <div class="showdiv">
                    <?php $this->renderPartial("/layouts/left_nav", $this->data); ?>
                </div>

                <div id="content" class="coupons-box">
                    <div class="mainbox mine">
                        <?php echo $content; ?>
                    </div>
                </div>
            </div>
        </div>
        <footer class="site-info-w">
            <div class="site-info">

                <div class="copyright">
                    <p>&copy;<span>2014</span><a href="#">阿那里商城</a> anarry.com <a href="#" target="_blank">京ICP证100001号</a> 京公网安备1000001号<a href="#" target="_blank"> 电子公告服务规则</a></p>
                </div>
                <ul class="cert cf">
                    <li class="cert__item"><a class="sp-ft sp-ft--record" title="备案信息" href="#" target="_blank">备案信息</a></li>
                    <li class="cert__item"><a class="sp-ft sp-ft--alipay" title="支付宝特约商家" href="javascript:void(0)">支付宝特约商家</a></li>
                    <li class="cert__item"><a class="sp-ft sp-ft--tenpay" href="#" title="财付通诚信商家" target="_blank" >财付通诚信商家</a></li>
                    <li class="cert__item"><a class="sp-ft sp-ft--knet"  href="javascript:void(0)" title="可信网站认证">可信网站</a></li>
                    <li class="cert__item"><a class="sp-ft sp-ft--12315" href="javascript:void(0)" title="12315消费争议">12315消费争议</a></li>
                </ul>    
            </div>
        </footer>


        <div class="new-index-triffle-w" style="bottom: 20px; right: 10px;">
            <a target="_blank" class="new-index-triffle lift-nav lift-nav--feedback " href="#"><i></i><span>意见反馈<span></span></span></a>
        </div>
        <div class="new-index-triffle-w" style="bottom: 62px; right: 10px;">
            <a class="J-lift-help new-index-triffle lift-nav lift-nav--help" href="javascript:void(0)"><i></i><span>帮助中心<span></span></span></a>
        </div>
        <div class="new-index-triffle-w" style="bottom: 104px; right: 10px;">
            <a class="J-go-top lift-nav new-index-triffle" href="#"><i></i><span>回到顶部</span></a>
        </div>
    </body>
</html>
