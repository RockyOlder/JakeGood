<!doctype html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title><?php echo $this->title; ?></title>
        <link rel="stylesheet" type="text/css" href="/themes/mt/css/cate-nav.list.css" />
		
        <link rel="stylesheet" type="text/css" href="/themes/mt/css/filter.v5a2c3389.css">
        <!--热门标签样式-->
        <link rel="stylesheet" type="text/css" href="/themes/mt/css/deallist.v307fd83e.css">
        <!--左侧图片列表样式-->
        <link rel="stylesheet" type="text/css" href="/themes/mt/css/side.v1f71ae5a.css">
		<style>
			.pg-floor .site-mast__site-nav-w .site-mast__site-nav .site-mast__site-nav-inner nav{width:980px}
		</style>
        <script src="/assets/plugins/jquery.min.js"></script>
        <script src="/themes/mt/js/ui.js"></script>
        <script src="/themes/mt/js/common.js"></script>
        <script src="/themes/mt/js/navleft.js"></script>
        <script src="/themes/mt/js/list.js"></script>
    </head>
    <body class="pg-floor pg-deal pg-deal-default pg-deal-detail pg-buy pg-cart">
        <?php $this->renderPartial("/layouts/header", $this->data); ?>

        <div id="bdw" class="bdw">
            <div id="bd" class="cf">
                <div id="filter">
                    <?php $this->renderPartial('/list/filter', array('cid' => $cid, 'cat' => $cat, 'filters' => $filters, 'sort_url' => $sort_url, 'sort' => $sort)); ?>
                </div>

                <div id="content" class="mall cf J-mall">
                    <?php foreach ($items as $k => $item): ?>
                        <div class="deal-tile <?php echo $k % 3 != 0 ? 'deal-tile--even' : ''; ?>">
                            <a href="<?php echo $this->createUrl('item/detail', array('item_id' => $item->item_id)); ?>" class="deal-tile__cover" target="_blank">
                                <img  height="190px" class="J-webp" alt="<?php echo $item->title; ?>" src="<?php echo $item->pic_url; ?>" />
                            </a>
                            <h3 class="deal-tile__title">
                                <a href="<?php echo $this->createUrl('item/detail', array('item_id' => $item->item_id)); ?>" class="w-link" title="<?php echo $item->title; ?>" target="_blank">
                                    <span class="xtitle"><?php echo $item->name; ?></span>
                                    <span class="short-title">
                                        <?php echo $item->title; ?>
                                    </span>
                                </a>
                            </h3>
                            <p class="deal-tile__detail">
                                <span class="price">
                                    ¥
                                    <strong><?php echo $item->price; ?></strong>
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


                    <div class="paginator-wrapper">
                        <?php
                        $this->widget('ILinkPager', array(
                            'currentPage' => $page - 1,
                            'itemCount' => $count,
                            'pageSize' => $limit,
                            'htmlOptions' => array('class' => 'paginator paginator--notri paginator--large'),
                            'header' => '',
                            'prevPageLabel' => '上一页',
                            'nextPageLabel' => '下一页',
                            'selectedPageCssClass' => 'current',
                            'cssFile' => '',
                        ))
                        ?>
                    </div>
                </div>


                <div class="site-sidebar" id="sidebar" style="display:none;">
                    <div class="side-extension top-reco-deals log-mod-viewed">
                        <h3>
                            热卖推荐
                        </h3>
                        <div class="side-extension__item">
                            <div class="deal-tile deal-tile--reco">
                                <a class="deal-tile__cover" href="item/detail?item_id=245" target="_blank" title="小米移动电源10400mAh毫安 ">
                                    <img class="" width="220" height="220" src="http://img04.taobaocdn.com/bao/uploaded/i4/TB1mcnoFFXXXXa.XFXXXXXXXXXX_!!0-item_pic.jpg_220x220.jpg">
                                    <span class="deal-rank">
                                        1
                                    </span>
                                </a>
                                <h4 class="deal-tile__title">
                                    <a class="w-link" href="item/detail?item_id=245" target="_blank" title="小米移动电源10400mAh毫安 ">
                                        <span class="short-title">
                                            小米移动电源10400mAh毫安 
                                        </span>
                                    </a>
                                </h4>
                                <p class="deal-tile__detail">
                                    <span class="price num">
                                        ¥<strong>79</strong>
                                    </span>
                                    <span>
                                        热销1531件
                                    </span>
                                </p>
                            </div>
                        </div>
                        <div class="side-extension__item">
                            <div class="deal-tile deal-tile--reco">
                                <a class="deal-tile__cover" href="item/detail?item_id=779" target="_blank" title="小米4手机 电信版">
                                    <img class="" width="220" height="220" src="http://img01.taobaocdn.com/bao/uploaded/i1/TB1Dvk9FVXXXXbVXVXXXXXXXXXX_!!0-item_pic.jpg_220x220.jpg">
                                    <span class="deal-rank">
                                        2
                                    </span>
                                </a>
                                <h4 class="deal-tile__title">
                                    <a class="w-link" href="item/detail?item_id=779" target="_blank" title="小米4手机 电信版">
                                        <span class="short-title">
                                            小米4手机 电信版
                                        </span>
                                    </a>
                                </h4>
                                <p class="deal-tile__detail">
                                    <span class="price num">
                                        ¥<strong>2469.00</strong>
                                    </span>
                                    <span>
                                        热销831件
                                    </span>
                                </p>
                            </div>
                        </div>
                        <div class="side-extension__item">
                            <div class="deal-tile deal-tile--reco">
                                <a class="deal-tile__cover" href="item/detail?item_id=255" target="_blank" title="Dell/戴尔 灵越 i5笔记本电脑">
                                    <img class="" width="220" height="220" src="http://img03.taobaocdn.com/bao/uploaded/i3/TB1P3SjGXXXXXckXXXXXXXXXXXX_!!0-item_pic.jpg_220x220.jpg">
                                    <span class="deal-rank">
                                        3
                                    </span>
                                </a>
                                <h4 class="deal-tile__title">
                                    <a class="w-link" href="item/detail?item_id=255" target="_blank" title="Dell/戴尔 灵越 i5笔记本电脑">
                                        <span class="short-title">
                                            Dell/戴尔 灵越 i5笔记本电脑
                                        </span>
                                    </a>
                                </h4>
                                <p class="deal-tile__detail">
                                    <span class="price num">
                                        ¥<strong>5499.00</strong>
                                    </span>
                                    <span>
                                        热销531件
                                    </span>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- bd end -->
        </div>

        <?php $this->renderPartial("/layouts/footer", $this->data); ?>
    </body>
</html>