<!DOCTYPE HTML>
<html lang="zh-CN">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0;">
        <title>购物车</title>
        <meta name="apple-mobile-web-app-capable" content="yes">
        <meta name="apple-mobile-web-app-status-bar-style" content="black">
        <meta name="format-detection" content="telephone=no">
        <link rel="stylesheet" href="/themes/mt/mobile/css/shopcart.css" />
        <link rel="stylesheet" type="text/css" href="/themes/mt/mobile/css/index.css" />
        <script src="/themes/mt/js/mobile.js"></script>
    </head>
    <style type="text/css">
        .shop_delete{          
            background: #e4393c;
            font-size: 14px;
            float: right;
            color: white;
            height: 40px;
            width: 80px;
            text-align: center;
            line-height: 40px;
        }.deal-component-quantity{ margin-top: 5px;}.f-text J-quantity J-cart-quantity{ border-left:1px; border-right:1px;}
        
    </style>
    <body>
        <?php  $id = Yii::app()->user->getId(); ?>
        <!--  overflow: auto; -->
        <div style="width: 100%; height: 100%;" id="content">
            <div id="c_wg.jdshopcart_showList" style="height: 100%; position: relative;">
                <div class="wx_wrap">
                    <div class="address_bar">
                        <a href="javascript:;" onclick="location.href='#wg.addrctrl.view=show&amp;maxlevel=3'"> 
                            <strong>当前页：</strong>
                            <span id="addrNameTxt">我的收藏</span> 
                            <i class="icon"></i>
                        </a>
                    </div>
                    <form action="/mobile/order/confirm" method="post" id="J-cart-form" class="common-form" enctype="multipart/form-data">
                        <div style="position: absolute; width: 100%; height: 100%;" id="listContent">
                            <div style="padding-bottom: 64px;" id="list">          

                                <div class="cart_goods cart_goods_group" id="180499115" attr-suit="mz">    
                                    <?php foreach ($list as $v): ?>
                                        <div class="item" id="1076647191"  attr-tag="checkItem" attr-sku="1076647191">
                                            <i class="icon_select"></i>                      
                                            <a class="shop_delete" href="<?php echo $this->createUrl('/mobile/wishlist/delete', array('id' => $v->id)); ?>" >删除</a>
                                            <img width="80" height="80" class="image" alt="" src="<?php echo $v->Item->pic_url; ?>">
                                            <div class="content" attr-tag="linkcontent" attr-href="">                 
                                                <p class="name">   <a href="<?php echo $this->createUrl('/item/detail', array('item_id' => $v->Item->item_id)); ?>" target="_blank"><?php echo $v->title; ?></p></a>                     </div>      
                                        </div>   
                                    <?php endforeach; ?>
                                </div>
                            </div>
                        </div>
                </div>
            </div>
        </div>
        <div class="wx_nav">
            <a class="nav_index on" href="<?php echo Yii::app()->createUrl('/mobile/obj/ceshi'); ?>">购物</a>
           <a class="nav_search" href="<?php echo Yii::app()->createUrl('/mobile/item/list',array('p' => 1)); ?>">搜索</a>
            <a class="nav_shopcart" href="<?php if (!empty($id)) {
                                        echo Yii::app()->createUrl('/mobile/cart');
                                    } else {
                                        echo Yii::app()->createUrl('/mobile/login');
                                    } ?>">购物车</a>
            <a class="nav_me" href="<?php if (!empty($id)) {
                                        echo Yii::app()->createUrl('/mobile/order/personal');
                                    } else {
                                        echo Yii::app()->createUrl('/mobile/login');
                                    } ?>">个人中心</a>
        </div>
        <!--
        <div id="mainViewFoot">
            <div id="checkAllBtn" attr-tag="checkMain" name="checkgroup" class="pay_bar selected"> 
             
                <a id="shopCartConfirm" class="btn_pay" name="buy" href="<?php //echo Yii::app()->createUrl('/mobile/order/personal');  ?>">返回</a>
            </div>
        </form>  

        <a class="btn_top btn_top_active " style="display:none; border-style: none;" id="goTop" href="javascript:;">返回顶部</a>
    </div>
        -->
        <script>
            caculShop();
        </script>
    </body>
</html>