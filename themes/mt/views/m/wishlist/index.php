    
    <body style="padding-top:45px;">
        <?php $id = Yii::app()->user->getId(); ?>
        <!--  overflow: auto; -->
        <div class="navbar navbar-inverse navbar-fixed-top" role="navigation">
            <a class="arrow-wrap float-left" href="javascript:history.back()" mon="element=back">
                <span class="arrow-left"></span>
            </a>
            <div class="money_bag text-center">
                <span class="title"><?php echo Yii::app()->name; ?></span>
            </div>
            <a href="/m" class="home" mon="element=home"></a>
        </div>
        <div style="width: 100%; height: 100%;" id="content">
            <div id="c_wg.jdshopcart_showList" style="height: 100%; position: relative;">
                <div class="wx_wrap">
                    <div class="address_bar">
                        <a href="javascript:;" onclick="location.href='#wg.addrctrl.view=show&amp;maxlevel=3'"> 
                            <strong>当前页：</strong>
                            <span id="addrNameTxt">我的收藏</span> 
                            <i class="icon"></i>
                        </a>
                    </div>
                    <form action="/m/order/confirm" method="post" id="J-cart-form" class="common-form" enctype="multipart/form-data">
                        <div style="position: absolute; width: 100%; height: 100%;" id="listContent">
                            <div style="padding-bottom: 64px;" id="list">          

                                <div class="cart_goods cart_goods_group" id="180499115" attr-suit="mz">    
                                    <?php foreach ($list as $v): ?>
                                        <div class="item" id="1076647191"  attr-tag="checkItem" attr-sku="1076647191">
                                                            
                                         
                                            <img width="80" height="80" class="image" alt="" src="<?php echo $v->Item->pic_url; ?>">
                                            <div class="content" attr-tag="linkcontent" attr-href="">                 
                                            
                                                <p class="name">   <a href="<?php echo $this->createUrl('/item/detail', array('item_id' => $v->Item->item_id)); ?>" target="_blank"><?php echo $v->title; ?></p></a>  </div>      
                                      <a class="btn btn-danger" href="<?php echo $this->createUrl('/m/wishlist/delete', array('id' => $v->id)); ?>" >删除</a>
                                        </div>   
                                    <?php endforeach; ?>
                                </div>
                            </div>
                        </div>
                </div>
            </div>
        </div>
        <div class="wx_nav">
            <a class="nav_index on" href="<?php echo Yii::app()->createUrl('/m/obj/index'); ?>">购物</a>
            <a class="nav_search" href="<?php echo Yii::app()->createUrl('/m/item/list', array('p' => 1)); ?>">搜索</a>
            <a class="nav_shopcart" href="<?php
                                    if (!empty($id)) {
                                        echo Yii::app()->createUrl('/m/cart');
                                    } else {
                                        echo Yii::app()->createUrl('/m/login');
                                    }
                                    ?>">购物车</a>
            <a class="nav_me" href="<?php
               if (!empty($id)) {
                   echo Yii::app()->createUrl('/m/order/personal');
               } else {
                   echo Yii::app()->createUrl('/m/login');
               }
               ?>">个人中心</a>
        </div>
        <!--
        <div id="mainViewFoot">
            <div id="checkAllBtn" attr-tag="checkMain" name="checkgroup" class="pay_bar selected"> 
             
                <a id="shopCartConfirm" class="btn_pay" name="buy" href="<?php //echo Yii::app()->createUrl('/mobile/order/personal');    ?>">返回</a>
            </div>
        </form>  

        <a class="btn_top btn_top_active " style="display:none; border-style: none;" id="goTop" href="javascript:;">返回顶部</a>
    </div>
        -->
        <script>
            caculShop();
        </script>
    </body>
</html>