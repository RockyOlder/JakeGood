<style type="text/css">
    .score {width:200px; height: 10px; border:1px solid #bbb;}
    .score div{height: 10px;background: #ccc;}

    .table.table-striped>thead>tr>th {text-align: center;}
    .progress {margin: 0}
    .table .price {color:#ee5238;font: bold 12px/12px arial,sans-serif;}
</style>
<div class="row">
    <div class="col-lg-12">
        <table class="table table-hover table-striped table-bordered table-advanced tablesorter">
            <thead>
                <tr>
                    <th width="250">宝贝信息</th>
                    <th width="">评价内容</th>
                    <th width="100" align="center">评分</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($rates as $v) : ?>
                    <tr>
                        <td>
                            <a href="<?php echo $this->createUrl('/item/detail', array('item_id' => $v->item_id)); ?>" target="_blank"><?php echo $v->item_title; ?></a>
                            <br />
                            <em class="price">¥<?php echo $v->item_price; ?></em>
                            <span style="color:#888"><?php echo $v->item_props; ?></span>
                        </td>
                        <td>
                            <?php echo $v->content; ?><br />
                            <span style="color:#888">[<?php echo date('Y-m-d H:i:s', $v->created); ?>]</span>
                        </td>
                        <td align="center">
                            <div class="common-rating" style="text-align:left;">
                                <span class="rate-stars" style="width:<?php echo 20*$v->star; ?>%"></span>
                            </div>
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
              
        <div class="paginator-wrapper">
            <?php
            $this->widget('ILinkPager', array(
                'pages' => $pages,
                'htmlOptions' => array('class' => 'paginator paginator--notri paginator--large'),
                'header' => '',
                'prevPageLabel' => '上一页',
                'nextPageLabel' => '下一页',
                'selectedPageCssClass' => 'current',
                'skin' => false,
                'cssFile' => false,
            ))
            ?>
        </div>
    </div>    
</div>