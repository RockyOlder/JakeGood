<style type="text/css">
    .order_list {min-width: 700px;margin-top: 10px;}    
    .order_list table>thead>tr>th {text-align: center;}

</style>
<div class="row">
    <div class="col-lg-12 order_list">
        <table class="table table-hover table-striped table-bordered table-advanced tablesorter">
            <thead>
                <tr>
                    <th>退款编号</th>
                    <th>订单/商品</th>
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