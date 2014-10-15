<style>
    .items {width:100%;}
    .itemimg {text-align:center;}
    .itemimg img{width:70px; height:70px;border:1px solid #ddd}

    .summary {float:left;}
    .pager {float:right;}
</style>
<div class="col-lg-12 order_list">
    <form action="<?php echo $this->createUrl('bulk'); ?>" id="item-form" method="POST" enctype="multipart/form-data">
        <table class="table table-hover table-striped table-bordered table-advanced tablesorter">
            <thead>
                <tr> 
                    <th width="3%">
                        <input type="checkbox" class="checkall" />
                    </th>
                    <th colspan="2">商品</th>
                    <th>单价</th>
                    <th>数量</th>
                    <th width="120">更新时间</th>
                    <th width="120"></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($items as $item) : ?>	
                    <tr class="order_item">           
                        <td>
                            <input type="checkbox" name="items_id[]" value="<?php echo $item->item_id; ?>" />
                        </td>
                        <td class="pic" width="80">
                            <img src="<?php echo $item->pic_url; ?>" height="60" width="60"/>
                        </td>
                        <td class="title" style="position:relative">
                            <a href="<?php echo $this->createUrl('/detail/index', array('item_id' => $item->item_id)); ?>" target="_blank">
                                <b class="text-orange"><?php echo $item->name; ?></b><br />
                                <?php echo $item->title; ?>
                            </a>
                            <div style="position:absolute;bottom:10px;">
                                <?php if ($item->is_showcase == 1): ?>
                                <span class="label label-sm label-pink "><i class="fa fa-thumbs-o-up"></i> 已推荐</span>
                                <?php endif; ?>
                            </div>
                        </td>
                        <td class="price"><?php echo $item->price; ?></td>
                        <td class="num"><?php echo $item->num; ?></td>
                        <td class="date"><?php echo date('Y-m-d', $item->update_time); ?></td>
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
            <div class="control-group bulk">
                <input type="hidden" id="act" name="act" value="un_show" />
                <button type="submit" onclick="$('#act').val(this.value)" value="un_show" class="btn btn-primary btn-sm">下架</button>    
            </div>        
        </div>
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

