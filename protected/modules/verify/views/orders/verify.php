<style>
    .order_status {padding:10px 0 8px ; margin: 5px;}
    .order_status h3{display: block; height:35px; line-height: 35px; padding-left: 45px; margin: 0; background:url(/assets/img/sys-icons-48.png) no-repeat 0px -72px;}    
</style>

<?php if ($order->status == 3): ?>
<div class="col-lg-12 order_status alert alert-info">
    <h3 class="text-green" style="background-position:0px -1px"> 
        <span>可以消费</span>              
    </h3>
</div>
<?php else: ?>
<div class="col-lg-12 order_status alert alert-danger">
    <h3 class="text-primary" style="background-position:0px -72px">不可用</h3>        
</div>
<?php endif; ?>
<div class="col-lg-6">
    <div class="portlet box portlet-grey">
        <div class="portlet-header">
            <div class="caption">
                订单信息
            </div>
        </div>
        <div class="portlet-body">
            <ul class="thumb-xxlarge media-overflow">
                <li class="media">
                    <div class="media-thumb media-left">
                        <a href="javascript:void(0);" class="img-shadow">
                            <img src="<?php echo $item->pic; ?>" class="media-object thumb">
                        </a>
                    </div>
                    <div class="media-body">
                        <h4 class="media-heading">
                            <a href="javascript:void(0);">
                                <?php echo $item->title; ?>
                            </a>
                        </h4>
                        <ul class="data">
                            <li>
                                数量: x <?php echo $item->quantity; ?>
                            </li>
                            <li>
                                订单编号: <?php echo $order['sn'] ?>
                            </li>
                            <li>
                                付款时间: <?php echo date('Y-m-d H:i:s', $order['pay_time']) ?>
                            </li>
                            <li>
                                买家留言: <?php echo $order['memo'] ?> 
                            </li>
                        </ul>
                    </div>
                </li>
            </ul>
        </div>
    </div>
</div>
<?php if ($order->status == 3): ?>
<div class="col-lg-12" style="margin-bottom:5px;">
    <a href="<?php echo $this->createUrl('confirm', array('code' => $model->code)); ?>" class="btn btn-primary">
        <i class="fa fa-tags"></i> 确认使用
    </a> 
</div>
<?php endif; ?>
