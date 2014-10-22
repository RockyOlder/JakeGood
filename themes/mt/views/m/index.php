      
<?php  $id = Yii::app()->user->getId(); ?>
<div class="row">
    <div class="widget-index-catg">
        <div class="wrap wrap8 clearfix">
            <a class="item item1" href="<?php echo $this->createUrl('item/list', array('cid' => 1)); ?>" mon="element=326">
                <div class="img meishi"></div>
                <div class="text">美食</div>
            </a>
            <a class="item item2" href="<?php echo $this->createUrl('item/list', array('cid' => 4)); ?>" mon="element=345">
                <div class="img dianying"></div>
                <div class="text">娱乐</div>
                <div class="img-icon" style="background-image: url(http://hiphotos.baidu.com/tuangou/pic/item/d019d2bf6c81800a2c9de931b23533fa828b4751.jpg);"></div>
            </a>
            <a class="item item3" href="<?php echo $this->createUrl('item/list', array('cid' => 2)); ?>" mon="element=642">
                <div class="img jiudian"></div>
                <div class="text">酒店</div>
            </a>
            <a class="item item4" href="<?php echo $this->createUrl('item/list', array('cid' => 173)); ?>" mon="element=341">
                <div class="img ktv"></div>
                <div class="text">KTV</div>
            </a>
            <a class="item item5" href="<?php echo $this->createUrl('item/list', array('cid' => 153)); ?>" mon="element=364">
                <div class="img huoguo"></div>
                <div class="text">火锅</div>
            </a>
            <a class="item item6" href="<?php echo $this->createUrl('item/list', array('cid' => 159)); ?>" mon="element=392">
                <div class="img zizhucan"></div>
                <div class="text">自助餐</div>
            </a>
            <a class="item item7" href="<?php echo $this->createUrl('item/list', array('cid' => 7)); ?>" mon="element=330">
                <div class="img gouwu"></div>
                <div class="text">购物</div>
            </a>
            <a class="item item8" href="<?php echo $this->createUrl('item/cats', array('cid' => 1)); ?>" mon="element=0">
                <div class="img quanbufenlei"></div>
                <div class="text">全部分类</div>
            </a>
        </div>
    </div>
    <div class="col-lg-12" style="height: 40px;line-height: 40px;">
        新上架
    </div>
    <div class="home-items">
        <table class="table table-condensed item-list">
            <?php
            $itemModel = new ItemSearch();
            list($items, $count) = $itemModel->search(array('cid' => 1, 'page' => 1, 'limit' => 10, 'sort' => 'time-desc'));
            ?>
            <?php foreach ($items as $k => $item): ?>
                <?php $url = $this->createUrl('item/detail', array('item_id' => $item->item_id)); ?>
                <tr class="hproduct">
                    <td>
                        <a href="<?php echo $url; ?>" style="display: block;">
                            <img alt="<?php echo $item->title; ?>" src="<?php echo $item->pic_url; ?>" class="img-thumbnail">
                        </a>
                    </td>
                    <td>
                        <a href="<?php echo $url; ?>">
                            <div class="item-name" style=""><?php echo $item->name; ?></div>
                            <div class="item-title" style=""><?php echo $item->title; ?></div>
                        </a>
                        <div class="item-info">
                            <span class="symbol">¥</span>
                            <span class="price"><?php echo $item->price; ?></span>
                            <del class="o-price">¥<?php echo $item->orig_price; ?></del>
                            <span class="distance">已售 <?php echo (int) $item->Counter->sale; ?></span>
                        </div>
                    </td>
                </tr>
            <?php endforeach; ?>
        </table>
        <div style="height: 15px;"></div>
        <div class="wx_nav">
        <a class="nav_index on" href="<?php echo Yii::app()->createUrl('/m/obj/ceshi'); ?>">购物</a>
        <a class="nav_search" href="<?php echo Yii::app()->createUrl('/m/item/list',array('p' => 1)); ?>">搜索</a>
        <a class="nav_shopcart" href="<?php if (!empty($id)){echo Yii::app()->createUrl('/m/cart');}else{echo Yii::app()->createUrl('/m/login');} ?>">购物车</a>
        <a class="nav_me" href="<?php if (!empty($id)){echo Yii::app()->createUrl('/m/order/personal');}else{echo Yii::app()->createUrl('/m/login');} ?>">个人中心</a>
    </div>
    </div>
</div>