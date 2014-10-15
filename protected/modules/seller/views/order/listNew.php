<style type="text/css">
    .order_list {min-width: 1000px;}    
    .order_list table>thead>tr>th {text-align: center;}
    .order_list .order {}
    .order_list .order_hd {background: #F3F3F3;}
    .order_list .order_hd td{ border: 1px solid #B4D5FF;border-color: #E6E6E6 #E6E6E6 #eee;}
    .order_list .order_item td{padding:5px;  text-align: center; border-bottom: 1px solid #E6E6E6;}
    .order_list .order_item td.pic{width:80px; border-right:0;}
    .order_list .order_item td.pic img{height:80px;}
    .order_list .order_item td.item{text-align: left; border-right:0;}
    .order_list .order_item td.price{border-right:0;}
    .order_list .order_item td.num{border-right: 1px solid #eee;}
    .order_list .order_item td.trouble{border-right: 1px solid #eee;}
    .order_list .order_item td.trade_status{border-right: 1px solid #eee;}
    .order_list .order_item td.order_price{border-right: 1px solid #eee;}
    .order_list .order_item td.remark{}
    .order_list .order_item td.contact{border-right: 1px solid #eee;border-bottom: 1px solid #D4E7FF;}
</style>
<script type="text/javascript">
    $(document).ready(function() {
        var dpconfig = {
            dateFormat: 'yy-mm-dd',
            yearRange: "2012:<?php echo date('Y') ?>",
            monthNamesShort: ['1', '2', '3', '4', '5', '6', '7', '8', '9', '10', '11', '12'],
            dayNamesMin: ['日', '一', '二', '三', '四', '五', '六'],
        };
        $("input.datepiker").datepicker(dpconfig);
    });
</script>
<div class="row">    
    <?php
    $fOrderStatus = $statusOptions;
    $fOrderStatus[0] = '';
    $fCommStatus = array('' => '', 0 => '未评', 1 => '已评');
    ?>
    <form method="get">            
        <div class="col-lg-12">
            <div class="col-md-2">
                <div id="table_id_filter" class="dataTables_filter">
                    <label>
                        <div class="input-group input-group-sm mbs">
                            <span class="input-group-btn">
                                <button type="button" class="btn btn-default btn-outlined">收件人名称 </button>
                            </span>
                            <?php echo CHtml::textField('filter[receiverName]', $filter['receiverName'], array('class' => 'form-control input-sm')); ?>
                        </div>
                    </label>
                </div>
            </div>
            <div class="col-md-2">
                <div id="table_id_filter" class="dataTables_filter">
                    <label>
                        <div class="input-group input-group-sm mbs">
                            <span class="input-group-btn">
                                <button type="button" class="btn btn-default btn-outlined">买家昵称 </button>
                            </span>
                            <?php echo CHtml::textField('filter[buyer]', $filter['buyer'], array('class' => 'form-control input-sm')); ?>
                        </div>
                    </label>
                </div>
            </div>
        </div>
        <div class="col-lg-12">
            <div class="col-md-2">
                <div id="table_id_filter" class="dataTables_filter">
                    <label>
                        <div class="input-group input-group-sm mbs">
                            <span class="input-group-btn">
                                <button type="button" class="btn btn-default btn-outlined">订单编号 </button>
                            </span>
                            <?php echo CHtml::textField('filter[orderSn]', $filter['orderSn'], array('class' => 'form-control input-sm')); ?>
                        </div>
                    </label>
                </div>
            </div>
            <div class="col-md-3">
                <div id="table_id_filter" class="dataTables_filter">
                    <label>
                        <div class="input-group input-group-sm mbs">
                            <span class="input-group-btn">
                                <button type="button" class="btn btn-default btn-outlined">成交时间 </button>
                            </span>
                            <div style="width:40%;float:left;margin-right:5px;">
                                <?php echo CHtml::textField('filter[startTime]', $filter['startTime'], array('size' => 12, 'class' => "datepiker form-control input-sm")); ?> 
                            </div>
                            <div style="width:40%;float:left;margin-left:5px;">
                                <?php echo CHtml::textField('filter[endTime]', $filter['endTime'], array('size' => 12, 'class' => "datepiker form-control input-sm")); ?>
                            </div>
                        </div>
                    </label>
                </div>
            </div>
        </div>  
        <div class="col-lg-12">
            <div class="col-md-2">
                <button type="submit"  class="btn btn-success dropdown-toggle">查 询</button>
            </div>
        </div>
    </form>

    <div class="col-lg-12">
        <div class="clearfix" style="height:5px">&nbsp;</div>
        <div class="">
            <ul class="nav nav-tabs ul-edit responsive hidden-xs hidden-sm">
                <li class="<?php if ($this->action->id == 'listNew') echo 'active'; ?>">
                    <a href="<?php echo $this->createUrl('listNew'); ?>">等待发货的订单</a>
                <li class="<?php if ($this->action->id == 'listNew') echo 'listShip'; ?>">
                    <a href="<?php echo $this->createUrl('listShip'); ?>">已发货的订单</a>
            </ul>
        </div>
    </div>

    <div class="col-lg-12 order_list">
        <table class="table table-hover table-striped table-bordered table-advanced tablesorter">
            <thead>
                <tr>
                    <th colspan="2">宝贝</th>
                    <th>单价(元)</th>
                    <th>数量</th>
                    <th>买家</th>
                    <th>实收款</th>
                    <th>收货地址</th>
                    <th></th>
                </tr>
            </thead>
            <?php foreach ($orders as $order) : ?>
                <tbody class="order">
                    <tr class="sep_row"><td colspan="9"></td></tr>
                    <tr class="order_hd">
                        <td colspan="9">
                            <div class="col-lg-2" style="margin-right:20px">订单编号: <?php echo $order->sn; ?></div>
                            <div class="col-lg-2">成交时间: <?php echo date('Y-m-d H:i:s', $order->created); ?></div>
                        </td>
                    </tr>
                    <?php $countItems = count($order->OrderItem); ?>
                    <?php foreach ($order->OrderItem as $itemk => $item) : ?>	
                        <tr class="order_item">
                            <td class="pic" width="50">
                                <a href="#"><img src="<?php echo $item->pic; ?>" /></a>
                            </td>
                            <td class="item">
                                <a href="#"><?php echo $item->title; ?></a>
                                <div><?php echo $item->props_name; ?></div>
                            </td>
                            <td class="price"><?php echo $item->price; ?></td>
                            <td class="num"><?php echo $item->quantity; ?></td>
                            <?php if ($itemk == 0) : ?>
                                <td class="contact" rowspan="<?php echo $countItems; ?>"><?php echo $order->User->nickname; ?></td>
                                <td class="order_price" rowspan="<?php echo $countItems; ?>"><?php echo $order->pay_fee; ?></td>
                                <td class="address " rowspan="<?php echo $countItems; ?>" style="text-align:left">
                                    <div><?php echo $order->receiver_state . $order->receiver_city . $order->receiver_district . $order->receiver_address ?></div>
                                    <div>收货人：<?php echo $order->receiver_name ?></div>
                                    <div>电话：<?php echo $order->receiver_mobile . '&nbsp;&nbsp;' . $order->receiver_phone; ?></div>
                                </td>
                                <td rowspan="<?php echo $countItems; ?>">
                                    <?php if ($order->status == 2 && $order->is_pay == 1): ?>
                                        <a href="<?php echo $this->createUrl('shipping', array('sn' => $order->sn)); ?>" target="_blank"><input type="button" class="btn btn-orange" value="发货" /></a>
                                        <a href="<?php echo $this->createUrl('invoice', array('sn' => $order->sn)); ?>" class="btn btn-success mrm" target="_blank">
                                            <i class="fa fa-print"></i>&nbsp;打印
                                        </a>
                                    <?php endif; ?>
                                </td>
                            <?php endif; ?>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            <?php endforeach; ?>
        </table>
    </div>
</div>