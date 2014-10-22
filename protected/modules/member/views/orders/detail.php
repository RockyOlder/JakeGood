<style>
    .order_info {width:280px; float:left;font:12px/1.5 Tahoma,Helvetica,Arial,sans-serif}
    .order_info ul {padding: 5px;}
    .order_info ul li label {width:60px; padding: 5px 0; display:block;float: left;}
    .order_info ul li div {width:210px;min-height: 20px; padding: 5px 0; display:block;float: left;}
    .order_status {width: 420px; min-height: 250px; float:left; border-left: 1px solid #ddd;}
    .order_status h3{display: block; height:35px; line-height: 35px; padding-left: 40px; margin: 20px; background:url(/themes/mt/img/sys-icons-48-new.vef6d2bc0.png) no-repeat -7px -35px;}
    table.table>thead>tr>th {text-align: center; font-weight: 100;}
</style>

<div style="border: 1px solid #ddd;">
    <div class="order_info">
        <div style="padding:5px; background-color: #F3F3F3;border-bottom: 1px solid #DDD;">
            <h3>订单信息</h3>
        </div>
        <ul>
            <li>
                <label>买家留言: </label>
                <div><?php echo $order['memo'] ?> </div>
            </li>
            <li>
                <label>订单编号: </label>
                <div><?php echo $order['sn'] ?></div>
            </li>
            <li>
                <label>成交时间: </label>
                <div><?php echo date('Y-m-d H:i:s', $order['created']) ?></div>
            </li>
            <li>
                <label>付款时间: </label>
                <div><?php echo date('Y-m-d H:i:s', $order['pay_time']) ?></div>
            </li>
        </ul>
        <div class="clear"></div>
    </div>
    <div class="order_status">
        <h3>订单状态: <?php echo $statusOptions[$order['status']]; ?></h3>

        <div style="text-align:center">
            <?php 
            if ($order->is_pay == 0)
            {
                echo CHtml::link('付款', $this->createUrl('orders/pay', array('sn' => $order->sn)), array('class' => 'btn-hot', 'target' => '_blank'));
            }
            elseif ($order->status == 2)
            {
                echo CHtml::link('确认收货', $this->createUrl('orders/confirm', array('sn' => $order->sn)), array('class' => 'btn-hot btn-mini', 'target' => '_blank'));
                echo CHtml::link('申请退款', $this->createUrl('refund/order', array('sn' => $order->sn)), array('class' => 'btn-hot', 'target' => '_blank'));
            }
            elseif ($order->status == 3)
            {
                echo CHtml::link('确认收货', $this->createUrl('orders/confirm', array('sn' => $order->sn)), array('class' => 'btn-hot', 'target' => '_blank'));
            }
            ?>
            
            <?php if ($orderShip) : ?>
                <div style="width:488px;height:300px;">
                    <div style="margin:10px 0 5px 10px;text-align:left;">
                        <span>快递公司: <?php echo $orderShip->type; ?></span>
                        <span style="margin-left:20px">快递单号: <?php echo $orderShip->ship_sn; ?></span>
                    </div>
                    <div style="width:492px;height:250px;overflow: hidden;">
                    <iframe  style="width:535px;height:360px;border:0;margin:-20px 0 0 -8px;" src="<?php echo Kuaidi::init($orderShip->type_code, $orderShip->ship_sn)->query() ?>"></iframe>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>
    <div class="clear"></div>
</div>

<div class="clearboth" style="height:20px;"></div>
<div>
    <table class="table">
        <thead>
            <tr>
                <th width="55">图片</th>
                <th>商品</th>
                <th>单价</th>
                <th>数量</th>
                <th>运费</th>
                <th>小计</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($order['OrderItem'] as $k => $item): ?>
                <tr>
                    <td>
                        <a href="<?php echo $this->createUrl('/item/detail', array('item_id' => $item->item_id)); ?>" target="_blank">
                            <img src="<?php echo $item->pic; ?>" width="50" height="50"/>
                        </a>
                    </td>
                    <td>
                        <a href="<?php echo $this->createUrl('/item/detail', array('item_id' => $item->item_id)); ?>" target="_blank"><?php echo $item->title; ?></a>
                        <div><?php echo $item->props_name; ?></div>
                    </td>
                    <td><?php echo $item->price; ?></td>
                    <td><?php echo $item->quantity; ?></td>
                    <td><?php echo $item->ship_fee; ?></td>
                    <td><?php echo $item->total; ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<div style="height:20px;text-align: right;">
    <h6>总运费: <span class="price"><?php echo $order['ship_fee']; ?></span> 元</h6>
    <h5 class="">总金额: <span class="price"><?php echo $order['amount']; ?></span> 元</h5>
</div>
