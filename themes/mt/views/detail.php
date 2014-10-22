
<link rel="stylesheet" type="text/css" href="/themes/mt/css/cate-nav.v8aeee1b4.css">
<link rel="stylesheet" type="text/css" href="/themes/mt/css/deal.v80160138.css">
<!--详情内容-->
<link rel="stylesheet" type="text/css" href="/themes/mt/css/side.v1f71ae5a.css">
<!--右侧最近浏览-->
<link rel="stylesheet" type="text/css" href="/themes/mt/css/qrcode.v3a71112c.css">
<!--右侧扫一扫-->
<link rel="stylesheet" type="text/css" href="/themes/mt/css/ratelist.vf90b4cdd.css">
<!--评论列表-->
<link rel="stylesheet" type="text/css" href="/themes/mt/css/side-deals.vcf443bab.css">

<script src="/themes/mt/js/list.js"></script>
<script src="/themes/mt/js/deal.js"></script>
<script type="text/javascript" src="/assets/js/baidu.map.api.js?v=2.0&ak=4lgYDZ9MWQMbTvjX5R5M5pZG"></script>
<style>
    .detail {overflow-x: hidden;}
    .detail img {max-width: 748px;overflow-x: hidden;}
</style>
<script>
    var skus = <?php echo $item_sku; ?>;
    var item = <?php echo json_encode(array('item_id' => $item->item_id, 'sku_id' => 0, 'quantity' => 1));?>
</script>

<div id="bdw" class="bdw">
    <div id="bd" class="cf">
        <div class="bread-nav">
            <a href="#">首页</a>
            <span>&raquo;</span>
            <?php echo $item->title; ?>
        </div>
        <div class="deal-component-container">
            <div class="deal-component-headline">
                <div class="sans-serif">
                    <h1 class="deal-component-title">
                        <?php echo $item->name; ?>
                    </h1>
                </div>
                <div class="deal-component-description"><?php echo $item->title; ?></div>
            </div>
            <div class="deal-component-detail cf">
                <div class="deal-component-left">
                    <div class="deal-component-images">
                        <div class="simple-gallery">
                            <div class="deal-component-cover">
                                <img class="focus-view" src="<?php echo $item->pic_url; ?>" alt="<?php echo $item->title; ?>" width="460" />
                            </div>
                            <div class="candidates">
                                <!--这里的IMG必须要连写-->
                                <?php foreach ($item->ItemImgs as $k => $img): ?>
                                    <img class="lazy-img J-lazy-img <?php echo $k == 0 ? 'first-image active' : '' ?>" src="<?php echo $img->url; ?>" width="78" height="78">
                                <?php endforeach; ?>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="deal-component-info J-deal-component-info J-hub" style="width:500px;">
                    <div class="deal-component-price cf">
                        <h2 class="deal-component-price-current sans-serif orange">
                            ¥<strong id="item_price"><?php echo $item->price; ?></strong>
                        </h2>
                        <span class="deal-component-price-pricetag orange"><?php echo round($item->price/($item->orig_price/10), 1); ?>折</span>
                        <del class="item">¥ <?php echo $item->orig_price; ?></del>
                    </div>
                    <div class="deal-component-rating ccf">
                        <span class="item">
                            <span class="">
                                已售
                                <span class="deal-component-rating-sold-count orange">
                                    <strong><?php echo $item->Counter->sale; ?></strong>
                                </span>
                            </span>
                        </span>
                        <span class="item">
                            <a href="#anchor-reviews" class="look-normal">
                                <div class="rate-status">
                                </div>
                            </a>
                        </span>
                    </div>
                    <style>
                        /*说明：该段CSS为后期修改（添加颜色和套餐）时添加，在套程序的时候可以自行根据文件目录放到指定位置，并在样式序列的最后进行引用 o(∩_∩)o  */
                        .deal-component-quantity-warning a{ border:1px solid #CCC; padding:3px; min-width: 30px; height: 30px; text-align: center; color:#666;display: inline-block;vertical-align: bottom;margin-bottom: 3px;}
                    </style>
                    <?php  $sku_map   = (array) json_decode($item->sku_map); ?>
                    <?php  $prop_imgs = json_decode($item->prop_imgs); ?>
                    <?php foreach ($sku_map as $pid => $v): ?>
                    <div class="deal-component-quantity">
                        <span class="deal-component-detail-leading"><?php echo $v->name; ?></span>
                        <span class="deal-component-quantity-warning">
                            <?php foreach ($v->values as $vid => $vname): ?>
                            <a data-prop="<?php echo $pid.':'.$vid; ?>" title="<?php echo $vname; ?>">
                                    <?php echo isset($prop_imgs->$pid->$vid) ? "<img src='{$prop_imgs->$pid->$vid}_32x32.jpg' width='30' height='30' />" : '<span>'.$vname.'</span>'; ?></a>
                            <?php endforeach; ?>
                        </span>
                    </div>
                    <?php endforeach; ?>
                    <!--如果要增加属性，复制本段代码即可(end)-->
                    <form action="/order/confirm" method="POST">
                        <input type="hidden" name="item_id" value="<?php echo $item->item_id; ?>" />
                        <input type="hidden" name="sku_id" id="sku_id" value="0" />
                        <input type="hidden" name="from" value="detail" />
                        <div class="deal-component-quantity">
                            <span class="deal-component-detail-leading">
                                数量
                            </span>
                            <button type="button" id="buy_count_jian">−</button><input type="text" name="quantity" class="J-cart-quantity" value="1" maxlength="9" id="buy_count"><button class="item" type="button" id="buy_count_jia">+</button>
                            
                        </div>
                        <div class="deal-component-purchase-button">
                            <input type="submit" class="J-mini-cart-buy mini-cart-buy basic-deal data-mod-enabled" value="抢购">
                            <a class="J-add-mini-cart mini-cart-button mini-cart-add" href="javascript:;" onclick="addToCart(item)">
                                加入购物车
                            </a>
                            <a class="small-btn deal-component-add-favorite J-component-add-favorite item" onclick="addWishlist(<?php echo $item->item_id; ?>)">
                                收藏 <b class='J-fav-count'><?php echo $item->Counter->collect; ?></b> 
                            </a>
                            <a class="small-btn share-tip J-component-share-tip-dialog">分享到</a>
                        </div>
                    </form>
                    <div class="deal-component-commitments">
                        <span class="deal-component-detail-leading">
                            服务承诺
                        </span>
                        <a class="anytime-money-back item" title="未消费，随时退款" href="#" target="_blank">
                            随时退
                        </a>
                        <a class="expiring-money-back item" title="过期未消费，无条件退款" href="#" target="_blank">
                            过期退
                        </a>
                        <a class="real-comment item" title="真实消费后的用户评价" href="javascript:void 0" target="_blank">
                            真实评价
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <div id="content" class="deal-content J-deal-content">
            <div>
                <div id="J-content-navbar" class="flat-content-navbar">
                    <ul class="cf">
                        <li class="content-navbar__item--current">
                            <a class="tab-item" href="javascript:;">
                                门店信息
                            </a>
                        </li>
                        <li>
                            <a class="tab-item" href="javascript:;">
                                商品描述
                            </a>
                        </li>
                    </ul>
                    <div id="J-nav-buy" class="buy-group" style="display:none;">
                        <a class="J-buy buy" href="#">
                            抢购
                        </a>
                        <a class="J-add-cart cart" href="#">
                            加入购物车
                        </a>
                    </div>
                </div>
            </div>
            <div id="deal-stuff" style="width:750px;">
                <div class="mainbox cf">
                    <div class="main">
                        <div class="blk detail" style="width:750px;">
                            <div class="deal-term">
                                <h2 class="content-title" id="anchor-purchaseinfo">门店信息
                                    </h2>
                                <div class="J-poi-wrapper poi-wrapper cf" style="height:360px;">
                                 <div id="allmap" style="width:50%;height:350px;float:left;"></div>
                                 <div class="item-shop-list biz-wrapper J-biz-wrapper biz-wrapper-nobottom inited" style="float:left;width:50%;height:350px;overflow: auto;">
                                 <?php  foreach (ANLMarket::getShopsByItem($item->item_id) as $i => $shop): ?>
                                     <div class="biz-info <?php echo $i == 0 ? 'biz-info--open biz-info--first' : ''; ?>">
                                         <h5 class="biz-info__title">
                                            <a href="javascript:;" class="poi-link view-map" data-lat="<?php echo $shop->latitude; ?>" data-lng="<?php echo $shop->longitude?>" data-title="<?php echo $shop->name; ?>" data-addrs="<?php echo $shop->address?>"><?php echo $shop->name; ?></a><i class="down-arrow"></i>
                                        </h5>
                                         <div class="biz-info__content" id="yui_3_16_0_1_1413006156435_1767">
                                            <div class="biz-item field-group" title="<?php echo $shop->address; ?>"><label class="title-label">地址：</label><?php echo $shop->address; ?></div>
                                            <div class="biz-item link-item">
                                                <a class="view-map" style="color:#E4393C;" href="javascript:void(0)" data-lat="<?php echo $shop->latitude; ?>" data-lng="<?php echo $shop->longitude?>" data-title="<?php echo $shop->name; ?>" data-addrs="<?php echo $shop->address?>">查看地图</a>
                                            </div>
                                            <div class="biz-item"><span class="title-label">电话：</span><?php echo $shop->tel; ?></div>

                                        </div>
                                     </div>
                                 <?php endforeach; ?>
                                 </div>
                                 
                                   <script type="text/javascript">
                                       function loadMap(lat, lng, title, address)
                                       {
                                           // 百度地图API功能
                                            var map = new BMap.Map("allmap");
                                            var point = new BMap.Point(lng, lat);
                                            var marker = new BMap.Marker(point);  // 创建标注
                                            map.addOverlay(marker);              // 将标注添加到地图中
                                            map.centerAndZoom(point, 15);
                                            var opts = {
                                              width : 200,     // 信息窗口宽度
                                              //height: 100,     // 信息窗口高度
                                              title : '<b style="color:#E4393C;">'+title+'</b>' , // 信息窗口标题
                                              enableMessage:false,//设置允许信息窗发送短息

                                            }
                                            var infoWindow = new BMap.InfoWindow(address, opts);  // 创建信息窗口对象 
                                            map.openInfoWindow(infoWindow,point);
                                            marker.addEventListener("click", function(){          
                                                map.openInfoWindow(infoWindow,point); //开启信息窗口
                                            });
                                       }
                                       $(document).ready(function () {
                                           $('.view-map').click( function () {
                                               var info = $(this).data();
                                               loadMap(info.lat, info.lng, info.title, info.addrs);
                                           });
                                           info = $('.biz-info--open .biz-info__title .view-map').data();
                                           loadMap(info.lat, info.lng, info.title, info.addrs);
                                       });
                                   </script>
                            
                                </div>
                            </div>
                        </div>
                        <div class="blk detail" style="width:750px;">
                            <div class="deal-term">
                                <h2 class="content-title" id="business-info">
                                    商品描述
                                </h2>
                                <div id="side-business" class="J-poi-wrapper poi-wrapper cf">
                                    
                                    <?php
                                        if (trim($item->desc) != '')
                                        {
                                            echo $item->desc;
                                        }
                                        elseif ($this->beginCache($item->outer_id, array('duration' => 3600*24)))
                                        {
                                            
                                            $desc = $this->queryDingPing($item->outer_id);
                                            $item->desc = $desc;
                                            $item->save();
                                            echo $desc;
                                            $this->endCache();
                                        }
                                        
                                    ?>
                                    
                                    <style>
                                        .dptg-intro .detail-table{border-collapse:collapse;border-spacing:0;margin-bottom:18px;border:1px solid #e2e2e2;color:#333}.dptg-intro .detail-table thead th{color:#333;background-color:#f2f2f2;font-size:12px;height:26px;line-height:26px;text-align:center;border-bottom:1px solid #e2e2e2}.dptg-intro .detail-table td{border:1px solid #e2e2e2;padding:0 10px;font-size:14px;line-height:26px;word-break:break-all}.dptg-intro .detail-table td.tc{text-align:center}.dptg-intro .detail-table .total td{border:0 none;background-color:#f2f2f2;line-height:26px}
                                        #tab_show_5, #tab_show_20{display:none;}
                                    </style>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div id="sidebar">
            <div id="J-side-topic" class="side-box side-box--topic">
                <div class="side-topic-buttons">
                    <a href="javascript:void 0" class="side-box--topic--previous">
                        &lt;
                    </a>
                    <a href="javascript:void 0" class="side-box--topic--next">
                        &gt;
                    </a>
                </div>
                <h3 class="side-box__title">
                    热门专题
                </h3>
                <div class="detail">
                    <ul class="J-side-topic-list">
                        <li class="topic-item-w curr">
                            <a class="topic-item topic-794" href="#" target="_blank" title="超级星期二">
                                <img class="lazy-img J-lazy-img topic-item__img" alt="超级星期二" src="/themes/mt/img/__47471077__4587861.png"
                                     width="238" height="140" />
                            </a>
                        </li>
                        <li class="topic-item-w">
                            <a class="topic-item topic-794" href="#" target="_blank" title="超级星期二">
                                <img class="lazy-img J-lazy-img topic-item__img" alt="超级星期二" src="/themes/mt/img/__49268621__1560463.png"
                                     width="238" height="140" />
                            </a>
                        </li>
                        <li class="topic-item-w">
                            <a class="topic-item topic-794" href="#" target="_blank" title="超级星期二">
                                <img class="lazy-img J-lazy-img topic-item__img" alt="超级星期二" src="/themes/mt/img/__48416931__4843453.jpg"
                                     width="238" height="140" />
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="side-single J-side-deallist-wrapper" id="yui_3_12_0_1_1406788294431_757">
                <div class="component-side-deals mt-component--booted" id="yui_3_12_0_1_1406788294431_759">
                    <div class="inner-blk ">
                        <h3>
                            其他用户还看了
                        </h3>
                        <ul id="yui_3_12_0_1_1406788294431_891" class="log-mod-viewed">
                            <li class="deal">
                                <a href="#" target="_blank" class="pic">
                                    <img class="" src="/themes/mt/img/__44446873__1618456.jpg" width="188px" >
                                </a>
                                <h4>
                                    <a href="#" target="_blank" title="【东门】50岚：饮品4选1，美味不停歇">
                                        【东门】50岚：饮品4选1，美味不停歇
                                    </a>
                                </h4>
                                <p class="info">
                                    <strong class="price">
                                        ¥6.8
                                    </strong>
                                    门店价
                                    <del>
                                        <span>
                                            ¥
                                        </span>
                                        10
                                    </del>
                                    <span class="total">
                                        已售
                                        <span>
                                            242
                                        </span>
                                    </span>
                                </p>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <div id="J-favorite-dialog" class="favorite-dialog">
            <div class="favorite-dialog__container">
                <i class="close favorite-dialog__close">
                </i>
                <div class="favorite-dialog__header">
                    <i class="favorite-dialog__success">
                    </i>
                    <span class="favorite-dialog__title">
                        收藏成功！
                    </span>
                </div>
                <a class="favorite-dialog__content" href="/collections/" target="_blank">
                    去我的收藏看看&raquo;
                </a>
            </div>
            <div class="favorite-dialog__mask">
            </div>
        </div>
    </div>
    <!-- bd end -->
</div>
<!-- bdw end -->