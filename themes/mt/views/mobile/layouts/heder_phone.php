<!DOCTYPE HTML>
<html lang="zh-CN">
    <head>
        <meta charset="utf-8">
        <title>主页</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0"  />
        <meta name="apple-mobile-web-app-capable" content="yes">
        <meta name="apple-mobile-web-app-status-bar-style" content="black">
        <meta name="format-detection" content="telephone=no">
        <meta http-equiv="x-dns-prefetch-control" content="on" />
        <link rel="stylesheet" type="text/css" href="/themes/mt/mobile/css/index.css" />
    </head>
    <body>
        <div class="WX_search WX_search_promote">
            <div class="WX_bar_cate">
                <a href="<?php echo Yii::app()->createUrl('/mobile/obj/ceshi'); ?>"></a>
            </div>
            <form action="/mobile/item/list" class="WX_search_frm" name="searchForm" method="get">

                <input type="search" autocomplete="off" id="topSearchTxt" ptag="37080.5.2" placeholder="请输入商品名称" class="WX_search_txt" name="q">
                <a style="display:none;" id="topSearchClear" href="javascript:;" class="WX_search_clear">x</a>

                <div class="WX_me">
                    <input type="submit" class="WX_search_btn_blue" id="topSearchbtn" hidefocus="true" value="搜&nbsp;&nbsp;索"  data-mod="sr">

                    <a style="display:none;" class="WX_search_btn" id="topSearchCbtn" href="javascript:">取消</a>
                </div>
        </div>
    </form>	
    <div class="wx_wrap">
        <div id="brandDiv">
            <div id="nowDiv">

                <div id="nowList">

                    <div class="mall_item">
                        <a class="mall_item_content" href="#">
                            <img onload="" src="http://img2.paipaiimg.com/e249fa5c/adau-54257C02-000000010000000784C400000008F55E.1.min.1.jpg" class="image">
                            <span class="timer">剩2天</span>
                            <span class="tag">300减20 500减50</span>
                        </a>
                        <div class="mall_item_title">
                            <p>时尚腕表节-出游记</p>
                            <div><em>1折起</em></div>
                        </div>
                    </div>

                    <div class="mall_item">
                        <a class="mall_item_content" href="#">
                            <img class="image" src="http://img6.paipaiimg.com/boss-22156A4C-2014092722156A4C5420DC6E000012AC.1.min.1.jpg" loaded="19">
                            <span class="timer">剩2天</span>
                            <span class="tag">全场满589减20</span>
                        </a>
                        <div class="mall_item_title">
                            <p>筱姿秋冬新品上市</p>
                            <div><em>4折起</em><span brandid="100471">收藏</span></div>
                        </div>
                    </div>

                    <div class="mall_item">
                        <a class="mall_item_content" href="#">
                            <img class="image" src="http://img5.paipaiimg.com/boss-2EC78934-201409272EC78934541A92AD000012AC.1.min.1.jpg" loaded="18">
                            <span class="timer">剩2天</span>
                            <span class="tag">全场满499减50</span>
                        </a>
                        <div class="mall_item_title">
                            <p>尚古主义秋装特卖</p>
                            <div><em>1折起</em><span brandid="100530">收藏</span></div>
                        </div>
                    </div>
                </div>
            </div>	
            <div style="display: none" id="previewDiv">
                <p class="mall_title_large"><span>明日预告</span></p>
                <div id="previewList">
                </div>
            </div>
        </div>			
    </div>
    <div class="wx_nav">
        <a class="nav_index on" href="<?php echo Yii::app()->createUrl('/mobile/obj/ceshi'); ?>">购物</a>
        <a class="nav_search" href="#">搜索</a>
        <a class="nav_shopcart" href="<?php if (!empty($id)){echo Yii::app()->createUrl('/mobile/cart');}else{echo Yii::app()->createUrl('/mobile/login');} ?>">购物车</a>
        <a class="nav_me" href="<?php if (!empty($id)){echo Yii::app()->createUrl('/mobile/order/personal');}else{echo Yii::app()->createUrl('/mobile/login');} ?>">个人中心</a>
    </div>
</body>
</html>