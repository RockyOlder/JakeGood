       <?php
        $fOrderStatus = $statusOptions;
        $fOrderKey = array_keys($statusOptions);
        ?>
        <div class="wx_wrap">

            <div class="my_head">
                <a class="my_user">
                    <div class="image">
                        <img width="50" height="50" src="/themes/mt/mobile/images/head_portrait.jpg">
                    </div>
                    <p class="name"><span id="user-name"class="user-info"></span></p>
                </a>
            </div>
            <div class="my_menu">
                <ul>
                    <li class="tiao">
                        <a href="<?php echo $this->createUrl('/m/order/index'); ?>" class="menu_1"><span><?php echo $total; ?></span>全部订单</a>
                    </li>
                    <li class="tiao">
                        <a href="<?php echo Yii::app()->createUrl('/m/order', array('filter[orderStatus]' => $fOrderKey[1])); ?>" class="menu_2"><span><?php if ($notpaying>0){echo $notpaying;} ?></span>待付款</a>
                    </li>
                    <li class="tiao">
                        <a href="<?php echo Yii::app()->createUrl('/m/order', array('filter[orderStatus]' => $fOrderKey[3])); ?>" class="menu_3"><span><?php if ($payment>0){echo $payment;} ?></span>配送中</a>
                    </li>
                    <li class="tiao">
                        <a href="<?php echo Yii::app()->createUrl('/m/order', array('filter[orderStatus]' => $fOrderKey[6])); ?>" class="menu_4"><span><?php if ($sixstarts>0){echo $sixstarts;} ?></span>退换货</a>
                    </li>
                </ul>
            </div>

            <ul class="my_list">
                <li class="tiao">
                    <a href="<?php echo Yii::app()->createUrl('/m/cart'); ?>">我的购物车<em id="cartNum"></em><span></span></a>
                </li>
                <li class="tiao">
                    <a href="<?php echo Yii::app()->createUrl('/m/wishlist'); ?>">我的收藏</a>
                </li>
                <li style="display: none">
                    <a href="javascript:;">我关注的品牌</a>
                </li>
                <li class="hr"></li>
                <li class="tiao">
                    <a href="<?php echo Yii::app()->createUrl('/m/address/index'); ?>">收货地址管理</a>
                </li>
                <li class="tiao"
                    <a href="javascript:;">帮助中心</a>
                </li>
            </ul>
            <div class="my_links">
                <a href="#" class="link_online" style="display: none">在线客服</a> 
                <a href="tel:13888888888" class="link_tel">致电客服</a>
            </div>
        </div>
        <script type="text/javascript" src="/themes/mt/js/jquery-1.11.1.min.js"></script>
        <script type="text/javascript">
            $(function() {
                $(document).ready(function () {
                    $.getJSON('/m/site/activity', {}, function (res) {
                        if (res.logged == 1)
                        {
                            $('.user-info').html(res.userinfo);
                        }
                    });
                });
            });
        </script>
