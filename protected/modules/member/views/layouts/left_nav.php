
<div class="component-order-nav">
    <div class="side-nav J-order-nav">
        <div class="J-side-nav__user side-nav__user cf">
            <a href="#" title="上传头像" class="J-user item user"><img src="http://i.anarry.com/avatar?u=<?php echo Yii::app()->user->getName(); ?>" width="30" height="30"></a>


            <div class="item info">
                <div class="info__name"><?php echo Yii::app()->user->getName(); ?></div>
                <div><a target="_blank" href="#">会员</a></div>
                <div class="op cf">
                    <a href="#" class="security J-security-status uix-tooltip"></a>
                    <a href="#" class="phone uix-tooltip"></a>
                    <a href="#" class="setting uix-tooltip"></a>
                </div>
            </div>

        </div>

        <dl class="side-nav__list">
            <dt class="first-item"><strong>我的订单</strong></dt>
            <dd>
                <ul class="item-list">
                    <li class="<?php echo get_class($this) == 'OrdersController' ? 'current' : ''; ?>"><a href="<?php echo $this->createUrl('orders/index'); ?>">已买到商品</a></li>
                    <li class="<?php echo get_class($this) == 'WishlistController' ? 'current' : ''; ?>"><a href="<?php echo $this->createUrl('wishlist/index'); ?>">我的收藏</a></li>
                </ul>
            </dd>
            <dt><strong>我的评价</strong></dt>
            <dd>
                <ul class="item-list">
                    <li class="<?php echo $this->request->getPathInfo() == 'member/rate/new' ? 'current' : ''; ?>"><a href="<?php echo $this->createUrl('rate/new'); ?>">待评价</a></li>
                    <li class="<?php echo $this->request->getPathInfo() == 'member/rate/index' ? 'current' : ''; ?>"><a href="<?php echo $this->createUrl('rate/index'); ?>">已评价</a></li>
                </ul>
            </dd>
            <dt><strong>退款维权</strong></dt>
            <dd>
                <ul class="item-list">
                    <li class="<?php echo get_class($this) == 'RefundController' ? 'current' : ''; ?>"><a href="<?php echo $this->createUrl('refund/list'); ?>">我的退款</a></li>
                </ul>
            </dd>
            <dt><strong>我的账户</strong></dt>
            <dd class="last">
                <ul class="item-list">
                    <li class="<?php echo get_class($this) == 'AddressController' ? 'current' : ''; ?>"><a href="<?php echo $this->createUrl('address/index'); ?>">收货地址</a></li>
                    <!--<li><a href="#">我的积分</a></li>
                    <li><a href="#">我的余额</a></li>
                    <li><a href="#">账户设置</a></li>
                    <li><a href="#">安全中心</a></li>
                    -->
                </ul>
            </dd>
        </dl>
    </div>
    <div class="opinfo">
        <div class="uix-tooltip-tip uix-tooltip-tip--above" style="position: absolute; top: 14px;  visibility: hidden;">
            <div class="inner">
                <span class="tool-title">安全等级<span class="warn">低</span></span>
                <a target="_blank" href="#">提升等级</a>
            </div>
            <div class="indication-arrow indication-arrow--down invisible"></div>
            <div class="indication-arrow indication-arrow--down visible"></div>
        </div>


        <div class="uix-tooltip-tip uix-tooltip-tip--above" style="position: absolute; top: 14px; left: 45px; visibility: hidden;">
            <div class="inner"><span class="tool-title"><?php echo Yii::app()->user->getName(); ?></span>
            </div>
            <div class="indication-arrow indication-arrow--down invisible"></div>
            <div class="indication-arrow indication-arrow--down visible"></div>
        </div>

        <div class="uix-tooltip-tip uix-tooltip-tip--above" style="position: absolute; top: 14px; left: 80px; visibility: hidden;">
            <div class="inner">
                <span class="tool-title"></span><a target="_blank" href="#">编辑资料</a></div>
            <div class="indication-arrow indication-arrow--down invisible"></div>
            <div class="indication-arrow indication-arrow--down visible"></div>
        </div>
    </div>
</div>