<style>
    .order_info {width:280px; float:left;font:12px/1.5 Tahoma,Helvetica,Arial,sans-serif}
    .order_info ul {padding: 5px;}
    .order_info ul li label {width:60px; padding: 5px 0; display:block;float: left;}
    .order_info ul li div {width:210px;min-height: 20px; padding: 5px 0; display:block;float: left;}
    .order_status {width: 495px; min-height: 250px; float:left; border-left: 1px solid #ddd;font:12px/1.5 Tahoma,Helvetica,Arial,sans-serif}
    table.table>thead>tr>th {text-align: center; font-weight: 100;}

    .fl {float:left;}
    .fnav {width: 100%;}
    .fnav div {padding: 10px 0;text-align: center;width:33.3%;background:#E9E9E9;}
    .fnav .current {background:#f24024;color:#fff}
    .refund_detail table{width: 80%; margin: auto;}
    .refund_detail table td{padding: 10px 0;}
</style>
<div class="separator" style="height:10px;"></div>

<div class="">
    <div class="fnav">
        <div class="fl current" >1 申请退款</div>
        <div class="fl">2 卖家同意退款</div>
        <div class="fl">3 退款成功，退款到储购宝</div>
    </div>
</div>
<div style="border: 1px solid #ddd;">
    <div class="order_info">
        <div style="padding:5px; background-color: #F3F3F3;border-bottom: 1px solid #DDD;">
            <h3>订单信息</h3>
        </div>
        <ul>
            <li>
                <label>收货地址: </label>
                <div>
                    <?php echo $order['receiver_name'] . ', &nbsp;&nbsp;' . $order['receiver_address'] . ', ' . $order['receiver_zip'] ?>
                    <br />
                    <?php echo $order['receiver_mobile'] . ', ' . $order['receiver_phone'] ?>
                </div>
            </li>
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
        <div style="text-align:center">
            <div style="padding:5px; background-color: #F3F3F3;border-bottom: 1px solid #DDD;">
                <h3>填写退款表单</h3>
            </div>
            <div class="refund_detail">
                <form method="POST">
                    <input type="hidden" name="sn" value="<?php echo $order->sn; ?>" />
                    <input type="hidden" name="type" value="1" />
                    <table>
                        <tr>
                            <td width="100">退款原因:</td>
                            <td align="left">
                                <textarea name="desc" style="height: 60px; width: 250px;"></textarea>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2">
                                <button class="btn-hot">提交</button>
                            </td>
                        </tr>
                    </table>
                </form>
            </div>
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

<div style="height:20px;text-align: right;">
    <h6>总运费: <span class="price"><?php echo $order['ship_fee']; ?></span> 元</h6>
    <h5 class="">总金额: <span class="price"><?php echo $order['amount']; ?></span> 元</h5>
</div>
