<style type="text/css">
    .order_list {min-width: 1000px;margin-top: 10px;}    
    .order_list table>thead>tr>th {text-align: center;}
    
</style>
<div class="row">

    <script type="text/javascript">
        $(document).ready(function() {
            var dpconfig = {
                changeMonth: true,
                changeYear: true,
                dateFormat: 'yy-mm-dd',
                yearRange: "2012:<?php echo date('Y') ?>",
                monthNamesShort: ['1', '2', '3', '4', '5', '6', '7', '8', '9', '10', '11', '12'],
                dayNamesMin: ['日', '一', '二', '三', '四', '五', '六'],
            };
            $("input.datepiker").datepicker(dpconfig);
        });
    </script>

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
                                <button type="button" class="btn btn-default btn-outlined">买家昵称 </button>
                            </span>
                            <?php echo CHtml::textField('filter[buyer]', $filter['buyer'], array('class' => 'form-control input-sm')); ?>
                        </div>
                    </label>
                </div>
            </div>
            <div class="col-md-3">
                <div id="table_id_filter" class="dataTables_filter">
                    <label>
                        <div class="input-group input-group-sm mbs">
                            <span class="input-group-btn">
                                <button type="button" class="btn btn-default btn-outlined">退款申请时间 </button>
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
                <div id="table_id_filter" class="dataTables_filter">
                    <label>
                        <div class="input-group input-group-sm mbs">
                            <span class="input-group-btn">
                                <button type="button" class="btn btn-default btn-outlined">退款编号 </button>
                            </span>
                            <?php echo CHtml::textField('filter[refundSn]', $filter['refundSn'], array('class' => 'form-control input-sm')); ?>
                        </div>
                    </label>
                </div>
            </div>
            <div class="col-md-2">
                <div id="table_id_filter" class="dataTables_filter">
                    <label>
                        <div class="input-group input-group-sm mbs">
                            <span class="input-group-btn">
                                <button type="button" class="btn btn-default btn-outlined">退款状态 </button>
                            </span>
                            <?php
                            $statusOptions[0] = '全部';
                            $statusOptions += $model->statusOptions();
                            ?>
                            <?php echo CHtml::dropDownList('filter[orderStatus]', $filter['orderStatus'], $statusOptions, array('class' => 'form-control input-sm')); ?>
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

    <div class="col-lg-12 order_list">
        <table class="table table-hover table-striped table-bordered table-advanced tablesorter">
            <thead>
                <tr>
                    <th>退款编号</th>
                    <th>订单编号/商品名称</th>
                    <th>买家</th>
                    <th>交易金额</th>
                    <th>退款金额</th>
                    <th>退款状态</th>
                    <th>操作</th>
                </tr>
            </thead>
            <tbody class="order">
                <?php foreach ($refunds as $v) : ?>
                    <tr>
                        <td align="center"><?php echo $v->refund_sn; ?></td>
                        <td>
                            <?php echo $v->order_sn; ?><br />
                            <?php echo $v->OrderItem->title; ?>
                        </td>
                        <td align="center"><?php echo User::model()->findByPk($v->user_id)->username; ?></td>
                        <td align="center"><?php echo $v->OrderItem->total; ?></td>
                        <td align="center"><?php echo $v->money; ?></td>
                        <td>
                            <?php
                            if ($v->status == 1 || $v->status == 4)
                            {
                                echo '<font color="red">';
                            }
                            echo $v->statusOptions();
                            if ($v->status == 1 || $v->status == 4)
                            {
                                echo '</font>';
                            }
                            ?>
                        </td>
                        <td align="center">
                            <a href="<?php echo $this->createUrl('refund/detail', array('sn' => $v->refund_sn)); ?>">详情</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <?php
        if (!$refunds)
        {
            echo "暂无数据";
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