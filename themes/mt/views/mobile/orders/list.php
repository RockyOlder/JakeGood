<!DOCTYPE HTML>
<html lang="zh-CN">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0;">
        <title>订单列表</title>
        <meta name="apple-mobile-web-app-capable" content="yes">
        <meta name="apple-mobile-web-app-status-bar-style" content="black">
        <meta name="format-detection" content="telephone=no">
        <link rel="stylesheet" href="/themes/mt/mobile/css/order_list.css" />
    </head>
    <body>
        <?php
        $fOrderStatus = $statusOptions;
        $fOrderKey = array_keys($statusOptions);
        $fOrderStatus[0] = '全部';
        $fCommStatus = array('' => '全部', 0 => '未评', 1 => '已评');
        ?>
        <div class="wx_wrap">

            <div class="my_nav">
                <ul id="nav">
                    <li class="cur" no="1" ><a href="<?php echo Yii::app()->createUrl('/mobile/order', array('filter[orderStatus]' => $fOrderKey[0])); ?>"><?php echo $fOrderStatus[0]; ?></a></li>
                    <li no="2" class=""><a href="<?php echo Yii::app()->createUrl('/mobile/order', array('filter[orderStatus]' => $fOrderKey[1])); ?>"><?php echo $fOrderStatus[1]; ?></a></li>
                    <li no="3" class=""><a href="<?php echo Yii::app()->createUrl('/mobile/order', array('filter[orderStatus]' => $fOrderKey[3])); ?>"><?php echo $fOrderStatus[3]; ?></a></li>
                </ul>
            </div>
            <div class="my_order_wrap">
                <!--  height:100%;width:240px;overflow:scroll  -->
                <div id="cont" class="my_order_inner" style=" height:100%;overflow:scroll;">

                    <!-- S 所有订单 -->
                    <div class="my_order">
                        <div id="cont1">
                            <?php foreach ($orders as $k => $order) : ?>
                                <?php $countItems = count($order->OrderItem); ?>

                                <div class="order">
                                    <div class="order_head">
                                        <p><span>订单编号：</span><em class="co_red"> <?php echo $order->sn; ?></em></p>
                                        <p><span>成交时间：</span><em class="co_red"> <?php echo date('Y-m-d H:i:s', $order->created); ?></em></p>
                                        <p><span>商<i></i>品：</span><em class="co_red"> <?php echo $countItems; ?>件</em></p>
                                        <p><span>状<i></i>态：</span><em class="co_red"><?php echo $statusOptions[$order->status]; ?></em></p>
                                        <p><span>总<i></i>价：</span><em class="co_red"><?php echo $order->amount; ?></em></p> 
                                        <?php
                                        if ($order->is_pay == 0) {
                                            echo CHtml::link('去支付', $this->createUrl('orders/pay', array('sn' => $order->sn)), array('class' => 'oh_btn toPay', 'target' => '_blank'));
                                        } elseif ($order->status == 2) {
                                            echo CHtml::link('确认收货', $this->createUrl('orders/confirm', array('sn' => $order->sn)), array('class' => 'oh_btn toPay', 'target' => '_blank'));
                                            echo CHtml::link('申请退款', $this->createUrl('refund/order', array('sn' => $order->sn)), array('class' => 'btn-hot btn-mini', 'target' => '_blank'));
                                        } elseif ($order->status == 3) {
                                            echo CHtml::link('确认收货', $this->createUrl('orders/confirm', array('sn' => $order->sn)), array('class' => 'oh_btn toPay', 'target' => '_blank'));
                                        }
                                        ?>
                                    </div>
                                    <?php foreach ($order->OrderItem as $itemk => $item) : ?>	
                                        <div class="order_item">
                                            <a class="oi_content" page="1">
                                                <img width="50" height="50" src="<?php echo $item->pic; ?>" class="image">
                                                <p><?php echo $item->title; ?></p>
                                                <p><span class="count"><?php echo $item->quantity; ?>件</span><span class="price"></span></p>
                                            </a> 
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                            <?php endforeach; ?>
                            <?php
                            if (!$orders) {
                                echo "<br />&nbsp;&nbsp;暂无数据";
                            }
                            ?>
                        </div>
                        <div class="wx_ending">已经没有更多订单了！</div>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>