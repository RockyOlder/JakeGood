<!DOCTYPE HTML>
<html lang="zh-CN">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0"  />
        <title>分类列表</title>
        <meta name="apple-mobile-web-app-capable" content="yes">
        <meta name="apple-mobile-web-app-status-bar-style" content="black">
        <meta name="format-detection" content="telephone=no">
        <meta http-equiv="x-dns-prefetch-control" content="on" />
        <link rel="stylesheet" href="/themes/mt/mobile/css/classifylist.css" />
        <link rel="stylesheet" type="text/css" href="/themes/mt/css/cate-nav.list.css" />

        <link rel="stylesheet" type="text/css" href="/themes/mt/css/filter.v5a2c3389.css">
        <!--热门标签样式-->
        <link rel="stylesheet" type="text/css" href="/themes/mt/css/deallist.v307fd83e.css">
        <!--左侧图片列表样式-->
        <link rel="stylesheet" type="text/css" href="/themes/mt/css/side.v1f71ae5a.css">
        <style>
            .pg-floor .site-mast__site-nav-w .site-mast__site-nav .site-mast__site-nav-inner nav{width:980px}
            .image{ text-align: center;}
        </style>
        <script src="/assets/plugins/jquery.min.js"></script>
        <script src="/themes/mt/js/ui.js"></script>
        <script src="/themes/mt/js/common.js"></script>
        <script src="/themes/mt/js/navleft.js"></script>
        <script src="/themes/mt/js/list.js"></script>
    </head>

    <body>
        <div class="WX_search">
            <form action="###" class="WX_search_frm" onsubmit="return false;">
                <input type="search" class="WX_search_txt" ptag="37110.50.1" id="topSearchTxt" placeholder="搜索京东全部商品">
                <a class="WX_search_clear" href="javascript:;" id="topSearchClear" style="display: none;">x</a>
            </form>
            <div class="WX_me">
                <div>
                    <a href="javascript:" id="topSearchbtn" class="WX_search_btn_blue" style="display:none;">搜索</a>
                    <a href="javascript:" id="topSearchCbtn" class="WX_search_btn" style="display:none">取消</a>
                </div>
            </div>
        </div>
        <div class="wx_wrap" style="height: 779px;">

            <div id="yScroll1" style="overflow: hidden; position:fixed; top: 45px; left: 0px; width: 76px; height: 779px; background-color: rgb(243, 243, 243);">
                <?php foreach (ItemCats::model()->findAll('parent_cid=0 AND status=1') as $cat): ?>
                    <?php $url = ($cat->cid > 0 ? Yii::app()->createUrl('/mobile/obj/list', array('cid' => $cat->cid)) : $cat->url); ?>
                    <ul class="category1" id="allcontent" style="border-bottom-style: none; transition: 1200ms cubic-bezier(0.1, 0.57, 0.1, 1); -webkit-transition: 1200ms cubic-bezier(0.1, 0.57, 0.1, 1); transform: translate(0px, 0px) translateZ(0px);">
                        <li keywordid="628" ptag="37110.52.3" class="cur"><a class="nav-level1__label" href="#<?php echo 'Right'.$cat->cid; ?>"><?php echo $cat->name; ?></a></li>
                    </ul>
                <?php endforeach; ?>
            </div>
            <div id="yScroll2" style="overflow: hidden; position: absolute; top: 45px; left: 76px;">
                <div style="transition: 0ms cubic-bezier(0.1, 0.57, 0.1, 1); -webkit-transition: 0ms cubic-bezier(0.1, 0.57, 0.1, 1); transform: translate(0px, 0px) translateZ(0px);">
                    
                        <?php if (empty($cid)): foreach (ItemCats::model()->findAll('parent_cid=0 AND status=1') as $cat): ?>             
                                <dl class="category2" id="category2">

                                    <dt id="<?php echo 'Right'.$cat->cid; ?>" class="content-title"><?php echo $cat->name; ?></dt>

                                    <dd id="areaC_628_18588" >
                                        <?php foreach (ItemCats::model()->findAll('parent_cid=' . $cat->cid) as $subCat): ?>
                                            <?php $url = ($subCat->cid > 0 ? Yii::app()->createUrl('/mobile/obj/list', array('cid' => $subCat->cid)) : $subCat->url); ?>
                                            <a  style=" text-align: center; "href="<?php echo $url; ?>" target=""><span style=" margin-top: 23px;"class="tit"><?php echo $subCat->name; ?></span></a>
                                        <?php endforeach; ?> 
                                    </dd> 
                                </dl>
                            <?php endforeach;
                        endif
                        ?>
                        <?php if (!empty($cid)): ?>      
                            <div id="content" class="mall cf J-mall">
                                <?php foreach ($items as $k => $item): ?>
                                    <div class="deal-tile <?php echo $k % 4 != 0 ? 'deal-tile--even' : ''; ?>">
                                        <a href="<?php echo $this->createUrl('item/detail', array('item_id' => $item->item_id)); ?>" class="deal-tile__cover" target="_blank">
                                            <img width="220" height="220" class="J-webp" alt="<?php echo $item->title; ?>" src="<?php echo $item->pic_url; ?>" />
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
                        <?php endif ?>
                    
                    </dl>
                </div>
            </div>
        </div>

        <div class="wx_nav">
            <a href="#" class="nav_index">购物</a>
            <a href="#" class="nav_search on">搜索</a>
            <a href="#" class="nav_shopcart">购物车</a>
            <a href="#" class="nav_me">个人中心</a>
        </div>
        <script type="text/javascript" src="js/jquery-1.11.1.min.js"></script>
        <script type="text/javascript">
            $(function(){
                $('#yScroll2').css('width',$(window).width()-76+'px');
                $(window).resize(function(){
                    $('#yScroll2').css('width',$(window).width()-76+'px');
                });
            })
        </script>
    </body>
</html>