
<a href="<?php echo $this->createUrl('add', $_GET); ?>" class="btn btn-success"><i class="fa fa-plus"></i> 新增</a>
<?php if (isset($returnUrl)): ?>
<a href="<?php echo $returnUrl; ?>" class="btn btn-info"><i class="fa fa-reply"></i> 返回</a>
<?php endif; ?>

<!-- Dynamic table -->
<?php
    $this->widget('zii.widgets.grid.CGridView', array(
        'id' => 'datalist',
        'dataProvider' => $this->search(),
        'filter' => $filter,
        'pagerCssClass' => 'dataTables_paginate paging_bootstrap pagination',
        'template'  => "{items}\n{summary}\n{pager}",
        'summaryText'=>'<font color=#0066A4>显示{start}-{end}条.共{count}条记录,当前第{page}页</font>',
        'summaryCssClass' => 'dataTables_info',
        'pager' => array(
                    'class'=>'CLinkPager',
                    'nextPageLabel'=>'下一页',
                    'prevPageLabel'=>'上一页',
                    'header'=>'',
                    'htmlOptions' => array('class' => 'pagination'),
                    'hiddenPageCssClass' => 'disabled',
                    'selectedPageCssClass' => 'active',
                    ),
        'columns'=> $columns,
        //'afterAjaxUpdate' => 'AfterLoadGridView'
    )); 
?>

<script>
    
    $('.toggle').click(function () {
            var toggleObj, cur_img;
            cur_img = $(this).children('img').attr('src');
            toggleObj = $(this);
            $.fancybox({
              href: $(this).attr('href'),
              type: 'ajax',
              afterLoad: function(current) {        
                tick  = "/assets/admin/images/icons/color/tick.png";
                cross = "/assets/admin/images/icons/color/cross.png";          
                if(cur_img == tick) {
                  toggleObj.find('img').attr('src', cross)
                }
                else{
                  toggleObj.find('img').attr('src', tick)
                }
              }
            });
            return false;
    });
    
</script>