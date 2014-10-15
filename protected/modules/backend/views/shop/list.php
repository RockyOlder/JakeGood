<style>
    .items {width:100%;}
    .itemimg {text-align:center;}
    .itemimg img{width:70px; height:70px;border:1px solid #ddd}

    .summary {float:left;}
    .pager {float:right;}
</style>
<div class="col-lg-12 order_list">
    <div style="margin-bottom:10px;">
        <a href="<?php echo $this->createUrl('shop/add', $_GET) ?>" class="btn btn-success dropdown-toggle"><i class="icon-plus"></i> 新增</a>
     </div>
    <form action="<?php echo $this->createUrl('bulk'); ?>" id="item-form" method="POST" enctype="multipart/form-data">
        <table class="table table-hover table-striped table-bordered table-advanced tablesorter">
            <thead>
                <tr> 
                    <th>店名</th>
                    <th>经营类目</th>
                    <th>区</th>
                    <th>商圈</th>
                    <th>电话</th>
                    <th>操作</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($list as $v) : ?>	
                    <tr class="order_item">  
                        <td><?php echo $v->name; ?></td>
                        <td><?php echo $v->cid; ?></td>
                        <td><?php echo $v->district; ?></td>
                        <td><?php echo $v->region; ?></td>
                        <td><?php echo $v->tel; ?></td>
                        <td>
                            <a href="<?php echo $this->createUrl('update', array('id' => $item->item_id)); ?>" class="btn btn-default btn-xs"><i class="fa fa-edit"></i>编辑</a>
                            <a href="<?php echo $this->createUrl('delete', array('id' => $item->item_id)); ?>" class="btn btn-danger btn-xs" onclick="if (confirm('确定删除?')) {
                                        return true
                                    } else {
                                        return false;
                                    }"><i class="fa fa-trash-o"></i>删除</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <div class="col-md-6">
            <div class="dataTables_paginate paging_simple_numbers" id="table_id_paginate">
                <style>
                    .pagination {margin: 0;}
                    .pagination .selected a{color: #FFFFFF;background: #dc6767;z-index: 2;cursor: default;}
                </style>
                <?php
                    $this->widget('CLinkPager', array(
                        'pages' => $pages,
                        'header' => '',
                        'skin' => false,
                        'cssFile' => false,
                        'htmlOptions' => array('class' => 'pagination')
                    ))
                    ?>
            </div>
        </div>        
        <div class="col-md-12" style="height: 100px;"></div>
    </form>
</div>

