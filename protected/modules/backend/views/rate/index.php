<style type="text/css">
    .score {width:200px; height: 10px; border:1px solid #bbb;}
    .score div{height: 10px;background: #ccc;}

    table.table-striped>thead>tr>th {text-align: center;}
    .progress {margin: 0}
</style>
<div class="row">
    <div class="col-lg-12">
        <?php if ($storeRate && $storeRate->count > 0) : ?>
            <table class="table">
                <tbody>
                    <?php for ($i=1; $i<6; $i++) : ?>
                    <?php $col = 'star'.$i; ?>
                    <tr>
                        <td width="50"><?php echo $i; ?> 星:</td>
                        <td width="280">
                            <?php $num = sprintf('%.2f', $storeRate->$col / $storeRate->count); ?>
                            <div class="progress">
                                    <div role="progressbar" aria-valuetransitiongoal="<?php echo $num * 100+3; ?>" class="progress-bar"></div>
                            </div>
                        </td>
                        <td><b style="color:red"><?php echo $storeRate->$col; ?></b></td>
                    </tr>
                    <?php endfor; ?>
                </tbody>
            </table>
        <?php endif; ?>
    </div>

    <div class="col-lg-12">
        <table class="table table-hover table-striped table-bordered table-advanced tablesorter">
            <thead>
                <tr>
                    <th width="10%">评分</th>
                    <th width="50%">评价内容</th>
                    <th width="15%">评价人</th>
                    <th width="25%">宝贝信息</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($rates as $v) : ?>
                    <tr>
                        <td style="color:red;text-align:center"><?php echo $v->star; ?> 星</td>
                        <td>
                            <?php echo $v->content; ?><br />
                            <span style="color:#888">[<?php echo date('Y-m-d H:i:s', $v->created); ?>]</span>
                        </td>
                        <td align="center"><?php echo User::model()->findByPk($v->user_id)->username; ?></td>
                        <td>
                            <a href="<?php echo $this->createUrl('/item/detail', array('item_id' => $v->item_id)); ?>" target="_blank"><?php echo $v->item_title; ?></a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <?php
        if (!$rates)
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

<script src="/assets/skin/fourteen/vendors/bootstrap-progressbar/bootstrap-progressbar.min.js"></script>
<script src="/assets/skin/fourteen/js/ui-progressbars.js"></script>