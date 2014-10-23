
          <?php  $id = Yii::app()->user->getId(); ?>     
   <div class="navbar navbar-inverse navbar-fixed-top" role="navigation">
            <a href="/m" class="home float-left" style="left:0;right:auto;"></a>
            <div class="money_bag text-center">
                <span class="title"><?php echo Yii::app()->name; ?></span>
            </div>
            <a href="#" class="btn-search" onclick="$('#J_bar1').toggle()"></a>
        </div>
        <div id="J_bar1" class="hd_bar fixed in">
            <form id="searchForm" class="hd_search_frm hd_search_frm_focus" action="<?php echo $this->createUrl('item/list'); ?>" method="GET">
                <input type="search" name="q" placeholder="请输入你想找的商品" autocomplete="off" id="keyWord" class="hd_search_txt hd_search_txt_null">
            </form>
            <div class="hd_me">
                <a class="WX_search_btn_blue" id="searchBtn" href="javascript:" onclick="$('#searchForm').submit();">搜索</a>
            </div>
        </div>
        <div class="wx_wrap">

            <div class="" id="searchResBlock">
                <div id="filterBlock" class="sf_layer_wrap">
                    <div class="sf_layer">
                        <div class="sf_layer_title">
                            <div class="left">
                                <input type="button" value="取消" id="filterCBtn" class="sf_btn_gray">
                                <input type="button" value="&nbsp;" id="filterBBtn" class="s_back_btn hide">
                            </div>
                            <div class="tit">筛选</div>
                            <div class="right">
                                <input type="button" value="确认" id="filterSureBtn" class="sf_btn_primary">
                            </div>
                        </div>
                        <div id="filterSelBlock" class="sf_layer_sub_title hide">
                            <strong>已选择：</strong><span class="words_10" id="filterSelTips" style="max-width: 1130px;"></span>
                        </div>
                    </div>
                </div>    

                <div id="sortBlock" class="mod_fixed_wrapper mod_filter_fixed in">  <!-- mod_filter_fixed -->
                    <div class="mod_filter">
                        <div class="mod_filter_inner">
                            <a sort-type="default" class="no_icon select" cg="0-2-1" href="<?php echo $sort_url['default']; ?>">默认</a>
                            <a mark="1" sort-type="price" class="" cg="0-2-2" href="<?php echo $sort_url['price']; ?>">价格<i cg="0-2-2" class="icon_sort"></i></a>  <!-- filter_desc -->
                            <a sort-type="sale" class="state_switch" cg="0-2-4" href="<?php echo $sort_url['sale']; ?>">销量<i cg="0-2-4" class="icon_sort_single"></i></a>
                            <a sort-type="comment" class="state_switch" cg="0-2-5" href="<?php echo $sort_url['time']; ?>">新品<i cg="0-2-5" class="icon_sort_single"></i></a>
                           <a sort-type="listmode" class="switch" cg="0-2-7" href="javascript:"><i cg="0-2-7" class="icon_switch"></i></a>  <!-- switch_list -->
                        </div>
                    </div>
                </div>

                <!-- 一栏/两栏 切换 mod_itemlist_small/mod_itemgrid -->
                <div id="product_list_wrapper" class="mod_itemlist_small">
                    <?php foreach ($items as $k => $item): ?>
                        <div class="hproduct">
                            <a href="javascript:"> 
                                <p class="cover">
                                    <a href="<?php echo $this->createUrl('item/detail', array('item_id' => $item->item_id)); ?>">
                                        <img src="<?php echo $item->pic_url; ?>" >
                                    </a>
                                </p> 
                                <a href="<?php echo $this->createUrl('item/detail', array('item_id' => $item->item_id)); ?>" >
                                    <p class="fn"><?php echo $item->title; ?><font class="skcolor_ljg"><?php echo $item->name; ?></font></p> 
                                </a>
                                <p class="prices">
                                    <strong><em>¥<?php echo $item->price; ?></em></strong>
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
                <div style=" height: 30px;"></div>

            </div>
            <div class="wx_nav">
                <a class="nav_index on" href="<?php echo Yii::app()->createUrl('/m/obj/index'); ?>">购物</a>
                <a class="nav_search" href="<?php echo Yii::app()->createUrl('/m/item/list',array('p' => 1)); ?>">搜索</a>
                <a class="nav_shopcart" href="<?php if (!empty($id)){echo Yii::app()->createUrl('/m/cart');}else{echo Yii::app()->createUrl('/m/login');} ?>">购物车</a>
                <a class="nav_me" href="<?php if (!empty($id)){echo Yii::app()->createUrl('/m/order/personal');}else{echo Yii::app()->createUrl('/m/login');} ?>">个人中心</a>
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
            });
        </script>