<style type="text/css">
    .fl {float:left;}
    .fnav {width: 590px;}
    .fnav div {padding: 10px 0;text-align: center;width:195px;background:#E9E9E9;}
    .fnav .current {background:#f24024;color:#fff}
    .refund_detail table{width: 80%; margin: auto;}
    .refund_detail table td{padding: 10px 0;}
</style>
<div class="separator" style="height:10px;"></div>

<div class="fl">
    <div class="fnav">
        <div class="fl <?php if ($model->status == 1 || $model->status == 2) echo 'current'; ?>">1 申请退款</div>
        <div class="fl <?php if ($model->status == 3 || $model->status == 4) echo 'current'; ?>">2 卖家同意退款</div>
        <div class="fl <?php if ($model->status == 6) echo 'current'; ?>">3 退款成功，退款到储购宝</div>
    </div>
    <div class="separator" style="height:10px;"></div>
    <div class="refund_detail">
        <table>
            <tr>
                <td width="100">退款编号: </td>
                <td><?php echo $model->refund_sn; ?></td>
            </tr>
            <tr>
                <td>申请时间:</td>
                <td><?php echo date('Y-m-d H:i:s', $model->created); ?></td>
            </tr>
            <tr>
                <td>退款成功时间:</td>
                <td><?php if ($model->process_time != 0) echo date('Y-m-d H:i:s', $model->process_time); ?></td>
            </tr>
            <tr>
                <td>退款类型:</td>
                <td><?php echo $model->typeOptions(); ?></td>
            </tr>
            <tr>
                <td>退款状态:</td>
                <td><?php echo $model->statusOptions(); ?></td>
            </tr>
            <tr>
                <td>退货数量:</td>
                <td><?php echo $model->quantity; ?></td>
            </tr>
            <tr>
                <td>退款金额:</td>
                <td><?php echo $model->money; ?></td>
            </tr>
            <tr>
                <td>退款原因:</td>
                <td><?php echo $model->desc; ?></td>
            </tr>
            <tr>
                <td colspan="2">
                    <script type="text/javascript">
                        var updateStatus = function(status) {
                            var url = "<?php echo $this->createUrl('update') . '?sn=' . $model->refund_sn; ?>";
                            window.location = url + '&status=' + status;
                        }
                    </script>
                    <?php
                    switch ($model->status)
                    {
                        case 1:
                            echo CHtml::button('同意退款申请', array('onclick' => "updateStatus(3)", 'class' => 'btn btn-red'));
                            echo CHtml::button('驳回退款申请', array('onclick' => "updateStatus(2)", 'class' => 'btn btn-grey'));
                            break;
                        case 3:
                            echo CHtml::link('确定退款', $this->createUrl('update', array('sn' => $model->refund_sn, 'status' => 6)), array('target' => "_blank", 'class' => 'btn btn-red'));
                            echo '<p class="text-primary">确定退款后, 退款金额将打到对方帐户</p>';
                            break;
                        case 4:
                            echo CHtml::link('已收到货, 确定退款', $this->createUrl('update', array('sn' => $model->refund_sn, 'status' => 6)), array('target' => "_blank", 'class' => 'btn btn-red'));
                            echo '<p class="text-primary">确定退款后, 退款金额将打到对方帐户</p>';
                            break;
                    }
                    ?>
                </td>
            </tr>
        </table>
    </div>
</div>
<div class="fl order_info" style="width:250px;border:1px solid #ddd;">
    <h4 style="text-align:center;background: #E2E2E2;margin-top:0;padding: 8px 0;">退款的商品信息</h4>
    <div style="padding:10px;">
        <div class="separator" style="height:65px;">
            <img src="<?php echo $model->OrderItem->pic; ?>" align="left" width="60" />
<?php echo $model->OrderItem->title; ?>
        </div>
        <div class="separator" style="height:25px;">
            &nbsp;卖家：<?php echo $model->store_id; ?>
        </div>
        <div class="separator" style="height:25px;">
            &nbsp;单价：<?php echo $model->OrderItem->price; ?>
        </div>
        <div class="separator" style="height:25px;">
            &nbsp;数量：<?php echo $model->OrderItem->quantity; ?>
        </div>
        <div class="separator" style="height:25px;">
            &nbsp;小计：<?php echo $model->OrderItem->total; ?>
        </div>
    </div>    
    <h4 style="text-align:center;background: #E2E2E2;margin-top:0;padding: 8px 0;">订单信息</h4>
    <div style="padding:10px;">
        <div class="separator" style="height:25px;">
            &nbsp;订单编号：<?php echo $model->Order->sn; ?>
        </div>
        <div class="separator" style="height:25px;">
            &nbsp;买家：<?php echo $model->Order->sn; ?>
        </div>
        <div class="separator" style="height:25px;">
            &nbsp;运费：<?php echo $model->Order->ship_fee; ?>
        </div>
        <div class="separator" style="height:25px;">
            &nbsp;总计：<?php echo $model->Order->amount; ?>
        </div>
        <div class="separator" style="height:25px;">
            &nbsp;成交时间：<?php echo date('Y-m-d H:i:s', $model->Order->created); ?>
        </div>
    </div>
</div>