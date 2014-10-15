
<a href="<?php echo $this->createUrl('add', $_GET); ?>" class="btn">Add</a>
 <div class="title"><h5><?php echo $title?></h5></div>
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
                            'htmlOptions' => array('class' => ''),
                            'hiddenPageCssClass' => 'disabled',
                            'selectedPageCssClass' => 'active',
                            ),
                'columns'=> $columns,
                'afterAjaxUpdate' => 'AfterLoadGridView'
            )); 
        ?>
        