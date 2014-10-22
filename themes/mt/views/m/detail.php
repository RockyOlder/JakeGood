        <script>
            var skus = <?php echo $item_sku; ?>;
            var item = <?php echo json_encode(array('item_id' => $item->item_id, 'sku_id' => 0, 'quantity' => 1)); ?>
        </script>
    <?php  $id = Yii::app()->user->getId(); ?>
        <div class="navbar navbar-inverse navbar-fixed-top" role="navigation">
            <a class="arrow-wrap float-left" href="javascript:history.back()" mon="element=back">
                <span class="arrow-left"></span>
            </a>
            <div class="money_bag text-center">
                <span class="title"><?php echo Yii::app()->name; ?></span>
            </div>
            <a href="/m" class="home" mon="element=home"></a>
        </div>
        <form action="<?php if (!empty($id)){echo Yii::app()->createUrl('/m/order/confirm');}else{echo Yii::app()->createUrl('/m/login');} ?>" method="POST" id="form_cart">
        <div id="loopImgDiv" class="mod_slider">
            <div class="inner">
                <ul id="loopImgUl" class="pic_list" style="left: 0px;">
                           <li><img src=" <?php echo $item->pic_url; ?>"></li>
                </ul>
            </div>
        </div>

        <div class="buy_area">
            <div style="display: none" id="testtt"></div>
            <div class="fn_wrap">
                <h1 id="itemName" class="fn"> <?php echo $item->name; ?></h1>
            </div>

            <div class="price_wrap">
                <span id="priceTitle" class="tit">单价：</span>
                <span id="priceSale" class="price" price="¥498.00" p="498.00"><?php echo $item->price; ?></span>
                <del class="old_price"><em style="display: none" id="priceMarket"></em></del>
                <span class="col_right">
                </span>
            </div>

            <div class="detail_promote detail_sendto">
                <div class="tit">详情：</div>
                <div id="addrArea" class="promote_tag">

                    <div class="time"><span id="postNotice1"><?php echo $item->title; ?></span></div>
                </div>
                <i id="postIco" class="icon_promote"></i>
            </div>

            <div id="promoteDiv" style="display: none;" class="detail_promote detail_promote_tag">
                <div class="tit">促销：</div>
                <div id="promote" class="promote_tag"></div>
                <i class="icon_promote"></i>
            </div>
             
                        <div id="skuNum" class="sku sku_num">
                            
                              <span class="centent-phone">数量： &nbsp;&nbsp;</span>
                            
                            <div class="num_wrap">
                                
                                <span id="minus" class="minus minus_disabled"></span>
                                <input type="tel" value="1" id="buyNum" class="num" name="quantity">
                                <span id="plus" class="plus"></span>
                              
                            </div>
                        </div>
                </div>
            </div>

            <div style="display:none" id="skuNotice" class="sku_tip">
                <span id="skuTitle2"></span>
            </div>

            <div id="serviveArea" class="service_wrap">
                <div id="shopInfoP" class="hd">
                    <h3>服务</h3>
                    <div id="shopInfo" class="txt">
                        <a class="anytime-money-back item" title="未消费，随时退款" href="#" target="_blank">
                            随时退
                        </a>
                        <a class="expiring-money-back item" title="过期未消费，无条件退款" href="#" target="_blank">
                            过期退
                        </a>
                        <a class="real-comment item" title="真实消费后的用户评价" href="javascript:void 0" target="_blank">
                            真实评价
                        </a></div>
                </div>
                <div style="" id="outService" class="ft">
                    <div class="tip">
                        <strong>温馨提示：</strong><span id="outServiceNote">本商品不能使用东券&nbsp;</span>
                    </div>
                </div>
            </div>
        </div>

        <div class="mod_tab_gap" id="detailBaseLine"></div>
        <div class="mod_tab_wrap">
            <div id="detailTab" class="mod_tab">
                <span no="1" class="cur" style=" font-size: 20px;">商品介绍</span>
            </div>
        </div>
        <!--  height:auto!important; -->
        <div id="detail" class="detail_info_wrap" style="height:auto!important;">
            <div id="detailCont" class="detail_list" style="">
                <!-- 商品介绍 -->
                <div style="position:relative;" id="detail1" class="detail_item p_desc">
                    <div id="appdlCon"></div>
                    <div class="detail_pc" id="commDesc">
                        <div class="content_tpl"> 
                            <div class="formwork"> 
                                <div class="formwork_img"> 
                                    <?php
                                    if ($this->beginCache($item->item_id, array('duration' => 3600))) {

                                        echo $this->queryDingPing($item->outer_id);
                                        $this->endCache();
                                    }
                                    ?>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- 商品参数 -->

                <!-- 评论 -->
            </div>
        </div>
        <input type="hidden" name="item_id" value="<?php echo $item->item_id; ?>" />
        <input type="hidden" name="sku_id" id="sku_id" value="0" />
        <input type="hidden" name="from" value="detail" />
        <!-- btn_wrap_nocart  onclick="addToCart(item)"   -->
        <div id="btnTools" class="btn_wrap btn_wrap_fixed">
            <a id="fav" href="javascript:;" class="btn_fav" isSelected="false" onclick="addCollection(<?php echo $item->item_id; ?>)"><i></i></a>
            <div class="btn_col"><!--  onclick="addToCart(item)" -->
                <a id="addCart2" href="javascript:;" class="btn btn_cart"  >加入购物车</a>
                <a id="buyBtn2" href="javascript:;" class="btn btn_buy">立即购买</a>
            </div>
        </form>
            <!-- onclick="addCarts(item)"  -->
            <a href="#" class="cart_wrap"id="cat_if" >
                <i id="cartNum" class="i_cart"></i>
                <span class="cart"></span>
                <span id="popone" class="add_num"></span>
                <i id="tishi" style="display:none;width: 16px; height: 16px; background: url(/themes/mt/mobile/images/red_cart.png) no-repeat scroll 0% 0% transparent; position: absolute; left: 32px; top: 0px; text-align: center; line-height: 16px; color: #fff;font-size: 10px;">0</i>
            </a>
        </div>
    </div> <!--part1 end-->
