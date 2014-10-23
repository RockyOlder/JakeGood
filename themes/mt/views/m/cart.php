<style type="text/css">
    .name{margin-top: 5px;}
    .deal-component-quantity button{float: right;}
</style>
<div class="navbar navbar-inverse navbar-fixed-top" role="navigation">
            <a class="arrow-wrap float-left" href="javascript:history.back()" mon="element=back">
                <span class="arrow-left"></span>
            </a>
            <div class="money_bag text-center">
                <span class="title"><?php echo Yii::app()->name; ?></span>
            </div>
            <a href="/m" class="home" mon="element=home"></a>
        </div>
        <!--  overflow: auto; -->
        <div style="width: 100%; height: 100%;" id="content">
            <div id="c_wg.jdshopcart_showList" style="height: 100%; position: relative;">
                <div class="wx_wrap">
                    <?php foreach ($items as $store_id => $v): ?>
                        <div class="address_bar">
                            <a href="javascript:;" onclick="location.href='#wg.addrctrl.view=show&amp;maxlevel=3'"> 
                                <strong>配送至：</strong>
                                <span id="addrNameTxt">商家：<?php echo Store::model()->findByPk($store_id)->name; ?></span> 
                                <i class="icon"></i>
                            </a>
                        </div>
                        <form action="/m/order/confirm" method="post" id="J-cart-form" class="common-form" enctype="multipart/form-data">
                            <div style="position: absolute; width: 100%; height: 682px;" id="listContent">
                                <div style="padding-bottom: 64px;" id="list">          

                                    <div class="cart_goods cart_goods_group" id="180499115" attr-suit="mz">    
                                        <?php foreach ($v as $sku_id => $item): ?>
                                       
                                            <div class="item<?php echo $sku_id; ?>" id="1076647191" name="items[<?php echo $store_id; ?>][<?php echo $sku_id; ?>]" attr-tag="checkItem" attr-sku="1076647191">                   
                                                <input type="hidden" name="items[<?php echo $store_id; ?>][<?php echo $sku_id; ?>]" value="1" class="J-cart-item J-choose J-choose<?php echo $store_id; ?>" />
                                                <img width="80" height="80" class="image" alt="" src="<?php echo $item->pic; ?>">
                                                <div class="content" attr-tag="linkcontent" attr-href="">                 
                                                    <p class="name"><?php echo $item->title; ?></p>    
                                                    <div style=" color: red;">
                                                        ¥<span class="J-total"id="<?php echo 'item_' . $store_id . '_' . $sku_id . '_total'; ?>"><?php echo sprintf("%.2f", $item->price * $item->quantity); ?>                                    
                                                        </span><br/>    
                                                    </div>
                                                         <div class="deal-component-quantity">
                                                  数量：
                                                        <input type="text" id="<?php echo 'item_' . $store_id . '_' . $sku_id . '_quantity'; ?>" name="quantity[]" value="<?php echo $item->quantity; ?>" class="f-text J-quantity J-cart-quantity" maxlength="4" onBlur="shopNumber(<?php echo $store_id; ?>, <?php echo $sku_id; ?>)">
                                                        <button type="button" class="btn btn-default" onclick="deleteItem(<?php echo $store_id; ?>, <?php echo $sku_id; ?>)">删除</button>
                                                         </div>
                                                </div>      
                                            </div>   
                                        <?php endforeach; ?>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                        </div>
                        <div class="shopcart_none" style="display: none;" id="emptyContent">
                            <i class="icon"></i>
                            <p class="title">您的购物车内还没有商品！</p>
                            <div class="mod_btns">
                                <a class="mod_btn" href="">个人中心</a>
                                <a id="rego" class="mod_btn" href="">立即逛逛</a>
                            </div>
                        </div>
                </div>
            </div>
        </div>
        <div id="mainViewFoot">
            <div id="checkAllBtn" attr-tag="checkMain" name="checkgroup" class="pay_bar selected"> 
                <span class="amount">已选<strong class="amount__num" id="J-cart-amount">1</strong>件商品</span>
                <strong>应付总额</strong>：<span class="inline-block money">¥<strong id="J-cart-total"></strong></span>
                <input type="submit" id="shopCartConfirm" class="btn btn-danger" name="buy" value="结算"></a>
            </div>
        </form>  

        <a class="btn_top btn_top_active " style="display:none; border-style: none;" id="goTop" href="javascript:;">返回顶部</a>
    </div>
        <script>
            caculateTotal();
        </script>