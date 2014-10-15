<style>
    .order_info {padding: 0; font:12px/1.5 Tahoma,Helvetica,Arial,sans-serif}
    .order_info table td {padding: 5px;}
    .order_status {min-height: 200px; border-left: 1px solid #ddd;}
    .order_status h3{display: block; height:35px; line-height: 35px; padding-left: 40px; margin: 20px; background:url(/assets/img/sys-icons-48.png) no-repeat -7px -35px;}
    
</style>
<div class="col-lg-12">
    
    <div style="border: 1px solid #ddd;padding: 0;">
        
        <a href="<?php echo $this->createUrl('invoice', array('sn' => $order->sn)); ?>" class="btn btn-success mrm" target="_blank" style="position:absolute;right:10px;z-index: 99">
            <i class="fa fa-print"></i>&nbsp;打印
        </a>
        
        <div class="order_info col-lg-4">
            <div style="padding:5px; background-color: #F3F3F3;border-bottom: 1px solid #DDD;">
                <h3 style="margin:0">订单信息</h3>
            </div>
            <table>
                <tr>
                    <td width="80">收货地址: </td>
                    <td>
                        <?php echo $order['receiver_name'] . ', &nbsp;&nbsp;' . $order['receiver_address'] . ', ' . $order['receiver_zip'] ?>
                        <br />
                        <?php echo $order['receiver_mobile'] . ', ' . $order['receiver_phone']; ?>
                    </td>
                </tr>
                <tr>
                    <td>买家留言: </td>
                    <td>
                        <?php echo $order['memo'] ?> 
                    </td>
                </tr>
                <tr>
                    <td>订单编号: </td>
                    <td>
                        <?php echo $order['sn'] ?>
                    </td>
                </tr>
                <tr>
                    <td>成交时间: </td>
                    <td>
                        <?php echo date('Y-m-d H:i:s', $order['created']) ?>
                    </td>
                </tr>
                <tr>
                    <td>付款时间: </td>
                    <td>
                        <?php echo date('Y-m-d H:i:s', $order['pay_time']) ?>
                    </td>
                </tr>
            </table>
        </div>
        <div class="order_status col-lg-8">
            <h3>订单状态: <?php echo $statusOptions[$order['status']]; ?></h3>
            
            <div style="padding-left:35px;">
                <?php 
                if ($order->status == 2)
                {
                    echo CHtml::link('发货', $this->createUrl('shipping', array('sn' => $order->sn)), array('class' => 'btn btn-orange'));
                }
                elseif ($order->status == 6)
                {
                    echo CHtml::link('处理退款', $this->createUrl('refund/detail', array('order_sn' => $order->sn)), array('class' => 'btn btn-primary', 'target' => '_blank'));
                }
                ?>
                
                <?php if ($orderShip) : ?>
                    <div style="width:100%;height:380px">
                        <div style="margin:10px 0 5px 10px;">
                            <b>快递公司: <?php echo $orderShip->type; ?></b>
                            <b style="margin-left:20px">快递单号: <?php echo $orderShip->ship_sn; ?></b>
                        </div>
                        <div style="width:520px;height:250px;overflow: hidden;">
                        <iframe  style="width:535px;height:360px;border:0;margin:-20px 0 0 -8px;" src="<?php echo Kuaidi::init($orderShip->type_code, $orderShip->ship_sn)->query() ?>"></iframe>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
            
        </div>
        <div style="clear:both;"></div>
    </div>
</div>

<div class="col-lg-12" style="margin-top:20px;">
    <table class="table table-hover table-bordered">
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
                        <a href="<?php echo $this->createUrl('/item/detail', array('item_id' => $item->item_id)); ?>">
                            <img src="<?php echo $item->pic; ?>" width="50" height="50"/>
                        </a>
                    </td>
                    <td>
                        <a href="<?php echo $this->createUrl('/item/detail', array('item_id' => $item->item_id)); ?>"><?php echo $item->title; ?></a>
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

<div class="col-lg-12" style="margin-top:20px;text-align: right;">
    <h4 class="text-orange">总快递费: <?php echo $order['ship_fee']; ?></h4>
    <h3 class="text-orange">总金额: <span class="price"><?php echo $order['amount']; ?></span> 元</h3>
</div>