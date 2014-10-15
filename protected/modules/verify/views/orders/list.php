<style type="text/css">
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
    .table>thead>tr>th, .table>tbody>tr>th, .table>tfoot>tr>th, .table>thead>tr>td, .table>tbody>tr>td, .table>tfoot>tr>td {vertical-align: middle;}
</style>
<div class="row">
    <div class="">
        <?php
        $fOrderStatus = $statusOptions;
        $fOrderStatus[0] = '全部';
        $fCommStatus = array('' => '全部', 0 => '未评', 1 => '已评');
        ?>
        <form method="get">
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
                <div class="col-md-2">
                    <div id="table_id_filter" class="dataTables_filter">
                        <label>
                            <div class="input-group input-group-sm mbs">
                                <span class="input-group-btn">
                                    <button type="button" class="btn btn-default btn-outlined">商品名称 </button>
                                </span>
                                <?php echo CHtml::textField('filter[item]', $filter['item'], array('class' => 'form-control input-sm')); ?>
                            </div>
                        </label>
                    </div>
                </div>
            </div>          
            <div class="col-lg-12">
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
                <div class="col-md-2">
                    <button type="submit"  class="btn btn-success dropdown-toggle">查 询</button>
                </div>
            </div>
        </form>
    </div>
    <div class="col-lg-12">
        <div class="clearfix" style="height:5px">&nbsp;</div>
        <div class="">
            <ul class="nav nav-tabs ul-edit responsive hidden-xs hidden-sm">
            </ul>
        </div>
    </div>

    <div class="col-lg-12 order_list">
        <table class="table table-hover table-striped table-bordered table-advanced tablesorter">
            <thead>
                <tr>
                    <th colspan="2">宝贝</th>
                    <th width="50">数量</th>
                    <th width="50">状态</th>
                    <th width="50">操作</th>
                </tr>
            </thead>
            <?php foreach ($orders as $k => $order) : ?>
                <tbody class="order">
                    <?php if ($k >= 0): ?>
                    <tr class="sep_row"><td colspan="5" style="padding: 3px"></td></tr>
                    <?php endif; ?>
                    <tr class="order_hd">
                        <td colspan="5">
                            <div class="col-lg-2" style="margin-right:20px">订单编号: <?php echo $order->sn; ?></div>
                            <div class="col-lg-2">成交时间: <?php echo date('Y-m-d H:i:s', $order->created); ?></div>
                        </td>
                    </tr>
                    <?php $countItems = count($order->OrderItem); ?>
                    <?php foreach ($order->OrderItem as $itemk => $item) : ?>	
                        <tr class="order_item">
                            <td class="pic">
                                <a href="#"><img src="<?php echo $item->pic; ?>" /></a>
                            </td>
                            <td class="item">
                                <a href="#"><?php echo $item->title; ?></a>
                            </td>
                            <td class="num"><?php echo $item->quantity; ?></td>
                            <?php if ($itemk == 0) : ?>
                            <td class="trade_status" rowspan="<?php echo $countItems; ?>">
                                <p style="color:blue"><?php echo $statusOptions[$order->status]; ?></p>
                            </td>
                            <td rowspan="<?php echo $countItems; ?>">
                                <a href="<?php echo $this->createUrl('orders/detail', array('sn' => $order->sn)); ?>">详情</a>
                            </td>
                            <?php endif; ?>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            <?php endforeach; ?>
        </table>
        <?php
        if (!$orders)
        {
            echo "<br />&nbsp;&nbsp;暂无数据";
        }
        ?>
        
        <div class="col-md-10">
            <div class="dataTables_paginate paging_simple_numbers" id="table_id_paginate">
                <style>
                    .pagination {margin: 0;}
                    .pagination .selected a{color: #FFFFFF;background: #dc6767;z-index: 2;cursor: default;}
                </style>
                <?php      
                    $this->widget('CLinkPager', array(
                        'pages' => $pages,
                        'header' => '',
                        'nextPageLabel' => '>',
                        'lastPageLabel' => '>>',
                        'skin' => false,
                        'cssFile' => false,
                        'htmlOptions' => array('class' => 'pagination')
                    ))
                    ?>
            </div>
        </div>    
    </div>
</div>