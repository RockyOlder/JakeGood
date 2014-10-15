<?php //echo 3;exit;          ?>
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
        <link rel="stylesheet" type="text/css" href="/themes/mt/css/cart.v9a94b40a.css">
        <link rel="stylesheet" type="text/css" href="/themes/mt/css/table-section.vfa4da119.css">
        <link rel="stylesheet" type="text/css" href="/themes/mt/css/deal.v80160138.css">
        <script src="/themes/mt/js/mobile.js"></script>
    </head>
    <style type="text/css">
        .shop_delete{ float: right; margin-top: 27px; }.btn_pay{ border-style: none;cursor:pointer;}
    </style>
    <body>
        <!--  overflow: auto; -->
        <div style="width: 100%;  height: 100%;
             " id="content">
            <div id="c_wg.jdshopcart_showList" style="height: 100%; position: relative;">
                <form action="/mobile/order/save" method="post" id="J-cart-form" class="common-form" enctype="multipart/form-data">
                    <div class="wx_wrap">
                        <?php foreach ($items as $store_id => $v): ?>
                            <div class="address_bar">
                                <a href="javascript:;" onclick="location.href='#wg.addrctrl.view=show&amp;maxlevel=3'"> 
                                  
                                    <span id="addrNameTxt">商家：<?php echo Store::model()->findByPk($store_id)->name; ?></span> 
                                    <i class="icon"></i>
                                </a>
                            </div>
                            <div style="position: absolute; width: 100%; height: 682px;" id="listContent">
                                <div style="padding-bottom: 64px;" id="list">          

                                    <div class="cart_goods cart_goods_group" id="180499115" attr-suit="mz">    
                                        <?php foreach ($v as $sku_id => $item): ?>
                                            <input type="hidden" name="items[<?php echo $store_id; ?>][<?php echo $sku_id; ?>]" value="<?php echo $item->quantity; ?>" class="J-choose" />
                                            <div class="item<?php echo $sku_id; ?>" id="1076647191" name="items[<?php echo $store_id; ?>][<?php echo $sku_id; ?>]" attr-tag="checkItem" attr-sku="1076647191">
                                                <i class="icon_select"></i>                      

                                                <img width="80" height="80" class="image" alt="" src="<?php echo $item->pic; ?>">

                                                <div class="content" attr-tag="linkcontent" attr-href="">                 
                                                    <p class="name"><?php echo $item->title; ?></p>    
                                                    <div style=" color: red;">
                                                        ¥<span class="J-total"id="<?php echo 'item_' . $store_id . '_' . $sku_id . '_total'; ?>"><?php echo sprintf("%.2f", $item->price * $item->quantity); ?>                                    
                                                        </span><br/>    
                                                    </div>
                                                    <div class="deal-component-quantity">
                                                        数量：
                                                        <?php echo $item->quantity; ?>

                                                    </div>                   
                                                </div>      
                                            </div>  

                                        <?php endforeach; ?>
                                    <?php endforeach; ?>

                                    <div class="foot">             
                                        <p>应付：<span class="price_attr-suit-totalprice"></span></p>         
                                    </div>    
                                </div>
                            </div>
                        </div>
                    </div>
            </div>
        </div>



        <div id="mainViewFoot">
            <p id="outofstockTip" style="display: none;" class="cart_alert">部分商品在所选地区缺货，请取消勾选后结算</p>
            <div id="checkAllBtn" attr-tag="checkMain" name="checkgroup" class="pay_bar selected"> 
                <i class="icon_select"></i>
                <span class="amount">已选<strong class="amount__num" id="J-cart-amount">1</strong>件商品</span>
                <strong>应付总额</strong>：<span class="inline-block money">¥<strong id="J-cart-total"></strong></span>
                <input type="submit" id="shopCartConfirm" class="btn_pay" name="buy" value="提交订单"></a>
            </div>
        </form>
        <a class="btn_top btn_top_active " style="display:none;" id="goTop" href="javascript:;">返回顶部</a>
    </div>
    <script>
        caculShop();
    </script>
</body>
</html>