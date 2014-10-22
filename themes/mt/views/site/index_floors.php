
<div class="J-hub elevator-wrapper"  style="top: 1114px;" >
    <ul class="elevator">
        <li class="elevator__floor meishi">
            <a class="link">
                <i class="link__icon"></i>
                <span>美食</span>
            </a>
        </li>
        <li class="elevator__floor xiuxianyule">
            <a class="link">
                <i class="link__icon"></i>
                <span>娱乐</span>
            </a>
        </li>
<!--        <li class="elevator__floor dianying">
            <a class="link">
                <i class="link__icon"></i>
                <span>电影</span>
            </a>
        </li>-->
        <li class="elevator__floor jiudian">
            <a class="link">
                <i class="link__icon"></i>
                <span>酒店</span>
            </a>
        </li>
        <li class="elevator__floor shenghuo">
            <a class="link">
                <i class="link__icon"></i>
                <span>生活</span>
            </a>
        </li>
        <li class="elevator__floor wanggou">
            <a class="link">
                <i class="link__icon"></i>
                <span>购物</span>
            </a>
        </li>
        <li class="elevator__floor jiankangliren">
            <a class="link">
                <i class="link__icon"></i>
                <span>丽人</span>
            </a>
        </li>
        <li class="elevator__floor lvyou elevator__floor--last">
            <a class="link">
                <i class="link__icon"></i>
                <span>旅游</span>
            </a>
        </li>
    </ul>
</div>    


<div class="floors cf">

    <div class="mall mall--3cols J-mall J-hub" >
        
        <?php foreach (ANLMarket::getCats($this->market->market_id, 0, 2) as $cat): ?>
        <?php   $url = ($cat->cid > 0 ? Yii::app()->createUrl('/item/list', array('cid' => $cat->cid)) : $cat->url); ?>
        <div class="category-floor">
            <div class="category-floor__head">
                <ul class="sub-categories">
                    <?php $i = 0; ?>
                    <?php foreach ($cat->subs as $subCat): ?>
                    <?php if ($i++ > 5) break; ?>
                    <?php   $url2 = ($subCat->cid > 0 ? Yii::app()->createUrl('/item/list', array('cid' => $subCat->cid)) : $subCat->url); ?>
                    <li class="sub-categories__cell">
                            <a href="<?php echo $url2; ?>" class="link"><?php echo $subCat->name; ?></a>
                    </li>
                    <?php endforeach; ?>
                    <li class="sub-categories__cell sub-categories__cell--all"><a target="_blank" href="<?php echo $url; ?>" class="link">全部<span class="arrow"></span></a></li>
                </ul>
                <h2>
                    <a class="" href="<?php echo $url; ?>" target="_blank" style="font-size: 18px;color:#F32085;"><?php echo $cat->name; ?></a>
                </h2>
            </div>
            <div class="category-floor__body cf">
                <?php 
                    $itemModel = new ItemSearch(); 
                    list($items, $count) = $itemModel->search(array('cid' => $cat->cid, 'page' => 1, 'limit' => 9, 'sort' => 'time-desc'));
                ?>
                <?php foreach ($items as $k => $item): ?>
                    <div class="deal-tile <?php echo ($k+1) % 3 == 0 ? 'deal-tile--even' : '';  ?>">
                        <a href="<?php echo $this->createUrl('/item/detail', array('item_id' => $item->item_id)); ?>" class="deal-tile__cover" target="_blank">
                            <img width="" height="193" class="J-webp" alt="<?php echo $item->title; ?>" src="<?php echo $item->pic_url; ?>" />
                        </a>
                        <h3 class="deal-tile__title">
                            <a href="<?php echo $this->createUrl('/item/detail', array('item_id' => $item->item_id)); ?>" class="w-link" title="<?php echo $item->title; ?>" target="_blank">
                                <span class="xtitle"><?php echo $item->name; ?></span>
                                <span class="short-title"><?php echo $item->title; ?></span>
                            </a>
                        </h3>
                        <p class="deal-tile__detail">
                            <span class="price">
                                ¥<strong><?php echo $item->price; ?></strong>
                            </span>
                        </p>
                        <div class="deal-tile__extra">
                            <p class="extra-inner">
                                <span class="sales">
                                    已售
                                    <strong class="num">
                                        <?php echo $item->sale; ?>
                                    </strong>
                                </span>
                                <span class="rate-info rate-info--noreviews">
                                    <?php echo intval($item->rating); ?> 人评价
                                </span>
                            </p>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
            <div class="category-floor__foot">
                <a href="<?php echo $url; ?>" target="_blank" class="link"><span>点击查看更多<i class="link__icon"></i></span></a>
            </div>
        </div>
        <?php endforeach; ?>

    </div>        
</div>
