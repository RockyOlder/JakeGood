
<!DOCTYPE HTML>
<html lang="zh-CN">
    <head>
        <meta charset="utf-8">
        <title>商品列表</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0"  />
        <meta name="apple-mobile-web-app-capable" content="yes">
        <meta name="apple-mobile-web-app-status-bar-style" content="black">
        <meta name="format-detection" content="telephone=no">
        <meta http-equiv="x-dns-prefetch-control" content="on" />
        <link rel="stylesheet" type="text/css" href="/themes/mt/mobile/css/product_list.css" />
        <link rel="stylesheet" type="text/css" href="/themes/mt/css/cate-nav.list.css" />
        <style type="text/css">
            .paginator--large .next a{width:60px;padding:5px 16px 5px 10px;margin-left: 130px; background:white url(/themes/mt/img/sp-header-new.v580abde4.png) no-repeat -38px -111px}
            .paginator--large .previous a{width:60px;padding:5px 10px 5px 16px;margin-left: -10px;background:white url(/themes/mt/img/sp-header-new.v580abde4.png) no-repeat 0 -111px}    
            #filterBtn{ border-style: none;}
        </style>

        <!--热门标签样式-->

        <!--左侧图片列表样式-->

    </head>
    <body>
        <div id="J_bar1" class="hd_bar fixed in">
            <form id="searchForm" class="hd_search_frm hd_search_frm_focus" action="/mobile/item/list">
                <input type="search" placeholder="搜索京东全部商品" autocomplete="off" id="keyWord" class="hd_search_txt hd_search_txt_null" name="q">
                <a id="searchClearBtn" href="javascript:;" class="hd_search_clear">x</a>
            </form>
            <div class="hd_me">
                <a class="WX_search_btn_blue hide" id="searchBtn" href="javascript:">搜索</a>
                <a class="hd_search_btn hide" id="cancelBtn" href="javascript:">取消</a>
              <!--  <input type="submit" cg="0-1-5" class="hd_search_btn" id="filterBtn" value="筛选"> -->
                	<a cg="0-1-5" class="hd_search_btn" id="filterBtn" href="javascript:">筛选</a>
            </div>
        </div>
        <div class="wx_wrap">

            <div class="" id="searchResBlock">
                <div id="filterBlock" class="sf_layer_wrap">
                </div>    

                <div id="sortBlock" class="mod_fixed_wrapper mod_filter_fixed in">  <!-- mod_filter_fixed -->
                    <div class="mod_filter">
                        <div class="mod_filter_inner">
                            <a sort-type="default" class="no_icon select" cg="0-2-1" href="<?php echo $sort_url['default']; ?>">默认</a>
                            <a mark="1" sort-type="price" class="" cg="0-2-2" href="<?php echo $sort_url['price']; ?>">价格<i cg="0-2-2" class="icon_sort"></i></a>  <!-- filter_desc -->
                            <a sort-type="sale" class="state_switch" cg="0-2-4" href="<?php echo $sort_url['sale']; ?>">销量<i cg="0-2-4" class="icon_sort_single"></i></a>
                            <a sort-type="comment" class="state_switch" cg="0-2-5" href="<?php echo $sort_url['rating']; ?>">人气<i cg="0-2-5" class="icon_sort_single"></i></a>
                            <a sort-type="listmode" class="switch" cg="0-2-7" href="javascript:"><i cg="0-2-7" class="icon_switch"></i></a>  <!-- switch_list -->
                        </div>
                    </div>
                </div>

                <div id="brandAdv" class="mod_itemlist_small mod_search_rec hide"></div>

             <!--       <div id="sNull01" class="s_null hide">
                    <h5>抱歉，没有找到符合条件的商品。</h5>
                </div>

                <div id="sNull02" class="s_null hide">
                    <h5>抱歉，没有找到符合条件的商品。</h5>
                    <p>我们为您去除了筛选条件，得到以下搜索结果。</p>
                </div>

            <div id="sFound" class="s_found">
                    <p class="found_tip_2">
                        找到相关商品 <span id="totResult">3187</span> 件。<span id="addName" class="location">配送至：北京</span>
                    </p>
                </div>-->

                <div id="loadingLogo2" class="wx_loading2 hide">
                    <i class="wx_loading_icon"></i>
                </div>

                <!-- 一栏/两栏 切换 mod_itemlist_small/mod_itemgrid -->
                <div id="product_list_wrapper" class="mod_itemlist_small">
                    <?php foreach ($items as $k => $item): ?>
                        <div class="hproduct">
                            <a href="javascript:"> 
                                <p class="cover">
                                    <a href="<?php echo $this->createUrl('/mobile/obj/detail', array('item_id' => $item->item_id)); ?>">
                                        <img src="<?php echo $item->pic_url; ?>" >
                                    </a>
                                </p> 
                                <a href="<?php echo $this->createUrl('/mobile/obj/detail', array('item_id' => $item->item_id)); ?>" >
                                    <p class="fn"><?php echo $item->title; ?><font class="skcolor_ljg"><?php echo $item->name; ?></font></p> 
                                </a>
                                <p class="prices">
                                    <strong><em>¥<?php echo $item->price; ?></em></strong>
                                </p> 
                                <p class="sku">
                                    <span class="comment_num"><span><?php echo intval($item->rating); ?></span>人评价</span>
                                    <span class="comment_rate">好评率96%</span>
                                    <span class="stock hide">已售<?php echo $item->sale; ?></span>
                                </p> 
                            </a>
                        </div>
                    <?php endforeach; ?>
                    <div class="paginator-wrapper">
                        <?php
                        $this->widget('ILinkPager', array(
                            'currentPage' => $page - 1,
                            'itemCount' => $count,
                            'pageSize' => $limit,
                            'maxButtonCount' => '',
                            'htmlOptions' => array('class' => 'paginator paginator--notri paginator--large', 'id' => 'items-id'),
                            'header' => '',
                            'prevPageLabel' => '上一页',
                            'nextPageLabel' => '下一页',
                            'selectedPageCssClass' => 'current',
                            'cssFile' => '',
                        ))
                        ?>
                    </div>
                </div>

            </div>
        </div>
        <script type="text/javascript" src="/themes/mt/js/jquery-1.11.1.min.js"></script>
        <script type="text/javascript">
            $(function(){
                $('#sortBlock .switch').bind('click',function(){
                    if($('#product_list_wrapper').hasClass('mod_itemlist_small')){
                        $('#product_list_wrapper').removeClass('mod_itemlist_small').addClass('mod_itemgrid');
                    }else{
                        $('#product_list_wrapper').removeClass('mod_itemgrid').addClass('mod_itemlist_small');
                    }
                });
                $('#filterBtn').click(function(){
                    $('form').submit();
                })
                
                
            });
        </script>
    </body>
</html>