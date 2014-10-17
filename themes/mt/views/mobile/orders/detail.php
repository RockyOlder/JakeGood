
<!DOCTYPE HTML>
<html lang="zh-CN">
    <head>
        <meta charset="utf-8">
        <title>订单详情</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0"  />
        <meta name="apple-mobile-web-app-capable" content="yes">
        <meta name="apple-mobile-web-app-status-bar-style" content="black">
        <meta name="format-detection" content="telephone=no">
        <meta http-equiv="x-dns-prefetch-control" content="on" />
        <link rel="stylesheet" type="text/css" href="/themes/mt/mobile/css/order_detail.css" />
    </head>
    <body>
        <div class="wx_wrap" id="detailCon">
            <div class="state  state_pay  state_0">   
                <div class="state_info"> 
                    <div class="state_txt"> 
                        <p class="state_tit">您的订单<b class="">已生成</b>！</p> 
                        <p class="state_detail">请尽快支付。</p> 
                        <div class="state_detail_list"> 
                            <p class="state_detail">
                                <span>订单状态：<em class="co_blue"><?php echo $statusOptions[$order['status']]; ?></em></span>
                            </p> 
                            <p class="state_detail">
                                <span>订单编号：<?php echo $order['sn'] ?></span>
                            </p> 
                        </div> 
                    </div> 
                </div> 
            </div>    
            <div class="mod_btns">  
                <?php
                if ($order->status == 2) {
                    echo CHtml::link('确认收货', $this->createUrl('/mobile/orders/confirm', array('sn' => $order->sn)), array('class' => 'mod_btn bg_1'));
                    echo CHtml::link('申请退款', $this->createUrl('refund/order', array('sn' => $order->sn)), array('class' => 'mod_btn bg_1'));
                } elseif ($order->status == 3) {
                    echo CHtml::link('确认收货', $this->createUrl('/mobile/orders/confirm', array('sn' => $order->sn)), array('class' => 'mod_btn bg_1'));
                } else if ($order->is_pay == 0) {
                    echo CHtml::link('付款', $this->createUrl('/mobile/order/pay', array('sn' => $order->sn)), array('class' => 'mod_btn bg_1'));
                }
                ?>
                <a class="mod_btn bg_2 " href="<?php echo $this->createUrl('/mobile/order/remove', array('sn' => $order->sn)); ?>">申请取消订单</a>    
            </div>  
            <div class="address">  
               	<div class="address_row"> 
                    <div class="address_tit">总&nbsp;&nbsp;&nbsp;&nbsp;额：</div> 
                    <div class="address_cnt"> 
                        <span class="address_price">¥<?php echo $order['amount']; ?></span>
                    </div> 
                </div>   
                <div class="address_row"> 
                    <div class="address_tit">收货地址：</div> 
                    <div class="address_cnt"><?php echo $addres->area . $addres->address; ?></div> 
                </div>   
                <div class="address_row"> 
                    <div class="address_tit">收&nbsp;货&nbsp;人：</div> 
                    <div class="address_cnt"><?php echo $addres->name; ?></div> 
                </div>   
            </div>
            <div class="goods"> 
                <div class="goods_hd"> 
                    <h3>商品信息</h3> 
                    <?php $countItems = count($order->OrderItem); ?>
                    <span class="goods_count">共<?php echo $countItems; ?>件</span> 
                </div> 
                <?php foreach ($order['OrderItem'] as $k => $item): ?>

                    <div class="goods_bd">  
                        <div class="goods_item">  
                            <div class="goods_img">
                                <a href="<?php echo $this->createUrl('/mobile/item/detail', array('item_id' => $item->item_id)); ?>">
                                    <img src="<?php echo $item->pic; ?>" loaded="1">
                                </a>
                            </div> 
                            <div class="goods_name">
                                <a href="<?php echo $this->createUrl('/mobile/item/detail', array('item_id' => $item->item_id)); ?>"><?php echo $item->title; ?> </a>
                            </div> 
                            <div class="goods_detail">                  
                                <span class="goods_price">¥<?php echo $item->price; ?></span>                                  
                                <span class="goods_num"><?php echo $item->quantity; ?>件</span> 
                            </div>   
                        </div>  
                    </div>  
                <?php endforeach; ?>
                <div class="goods_ft">  
                    <ul class="fitting_list">  
                    </ul> 
                    <ul class="promo_list">  
                    </ul> 
                    <ul class="promo_info">   
                    </ul> 
                    <p class="total">
                        <span class="tit">实付：</span>
                        <span class="price"><strong>¥<?php echo $order['amount']; ?></strong></span>
                    </p> 
                </div> 
            </div>      
        </div>

    </body>
</html>