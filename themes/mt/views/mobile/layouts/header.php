
<header class="site-mast">
    <div class="site-mast__user-nav-w">
        <div class="site-mast__user-nav cf">

            <ul class="basic-info">
                <li class="user-info cf">
                    <a class="user-info__login" href="/login">登录</a>
                    <a class="user-info__signup" href="//i.anarry.com/reg" target="_blank">注册</a>
                </li>
                <li class="dropdown dropdown--msg J-my-msg-w" style="display:none;">
                    <a id="J-my-msg"  class="dropdown__toggle" href="#">
                        <i class="vertical-bar vertical-bar--left"></i>
                        <span class="J-title">消息</span>
                        <i class="tri tri--dropdown"></i>
                        <i class="vertical-bar"></i>
                    </a>
                </li>
                <!--
                <li class="mobile-info__item dropdown dropdown--open-app dropdown-menu--app">
                    <a class="dropdown__toggle" href="javascript:void(0);">
                        <i class="icon-mobile"></i>手机商城<i class="tri tri--dropdown"></i>
                    </a>
                    <div class="dropdown-menu dropdown-menu--app">
                        <a class="app-block" href="#" target="_blank">
                            <span class="app-block__title">免费下载手机版</span>
                            <span class="app-block__content"></span>
                            <i class="app-block__arrow"></i>
                        </a>
                    </div>
                </li>
                -->
            </ul>
            <ul class="site-mast__user-w">
                <li class="dropdown dropdown--cart" >
                    <a class="dropdown__toggle" href="/cart">
                        <i class="icon icon-cart"></i>
                        <span>购物车<em class="badge" ><strong class="cart-count">0</strong>件</em></span>
                        <i class="tri tri--dropdown"></i>
                        <i class="vertical-bar"></i>
                    </a>
                    <div class="dropdown-menu dropdown-menu--deal dropdown-menu--cart">
                        <ul class="list-wrapper">
                        </ul>
                        <p class="check-my-cart"><a href="/cart" class="btn btn-hot btn-small">查看我的购物车</a></p>
                    </div>
                </li>
                <li class="user-orders">
                    <a href="<?php echo $this->createUrl('/member/orders'); ?>" target="">我的订单</a>
                </li>
                <li class="dropdown dropdown--account">
                    <a class="dropdown__toggle" href="<?php echo $this->createUrl('/member/orders'); ?>">
                        <span>用户中心</span>
                        <i class="tri tri--dropdown"></i>
                        <i class="vertical-bar"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-menu--text dropdown-menu--account account-menu" >
                        <li><a class="dropdown-menu__item first" href="<?php echo $this->createUrl('/member/orders'); ?>">我的订单</a></li>
                        <li><a class="dropdown-menu__item" href="<?php echo $this->createUrl('/member/rate'); ?>">我的评价</a></li>
                        <li><a class="dropdown-menu__item" href="<?php echo $this->createUrl('/member/wishlist'); ?>">我的收藏</a></li>
                        <li><a class="dropdown-menu__item" href="<?php echo $this->createUrl('/member/refund/list'); ?>">退/换货</a></li>
                        <li><a class="dropdown-menu__item" href="<?php echo $this->createUrl('/member/address/index'); ?>">收货地址</a></li>
                    </ul>

                </li>
                <!--
                <li class="dropdown dropdown--merchant">
                    <a class="dropdown__toggle dropdown__toggle--merchant" href="javascript:void(0)">
                        <span>我是商家</span>
                        <i class="tri tri--dropdown"></i>
                        <i class="vertical-bar"></i>
                    </a>
                    <div class="dropdown-menu dropdown-menu--text dropdown-menu--merchant">
                        <ul>
                            <li><a class="dropdown-menu__item" href="#">商家中心</a></li>
                            <li><a class="dropdown-menu__item" href="#">我想合作</a></li>
                            <li><a class="dropdown-menu__item" href="#">商家营销平台</a></li>
                        </ul>
                    </div>
                </li>
                -->
                <li class="user-orders">
                    <a  href="<?php echo $this->createUrl('/help'); ?>" >帮助中心</a>
                </li>
                <li class="dropdown dropdown--more dropdown--last">
                    <a class="dropdown__toggle dropdown__toggle--my-more" href="javascript:void(0)">
                        <span>更多</span>
                        <i class="tri tri--dropdown"></i>
                    </a>
                    <div class="dropdown-menu dropdown-menu--text dropdown-menu--more">
                        <ul>
                            <li><a id="J-subscribe" class="subscribe dropdown-menu__item" href="#"><span></span>邮件订阅</a></li>
                            <li><a class="fav dropdown-menu__item" id="J-favorite" href="javascript:void(0);">收藏商品</a></li>
                            <li class="last"> <a class="refer dropdown-menu__item" href="#" target="_blank" >邀请好友</a></li>
                        </ul>
                    </div>
                </li>
            </ul>        
        </div>
    </div>
    <div class="site-mast__branding cf">
        <a href="/" style="float:left;display:block;width:200px;height:70px;margin-top:25px;"><img src="/themes/mt/img/logo.png" /></a>
        <div class="city-info">
			<h2><a class="city-info__name" href="/"><?php echo $this->market->city_name; ?></a></h2>
			<a class="city-info__toggle" href="#">切换城市</a>
		</div>
		<div class="component-search-box"><div class="J-search-box search-box ">
                <form action="/item/list" class="search-box__form J-search-form" name="searchForm" method="get">
                    <div class="search-box__tabs-container">
                        <span class="tri"></span>
                        <ul class="J-search-box__tabs search-box__tabs">
                            <li class="search-box__tab J-search-box__tab--deal search-box__tab--current">商品</li>
                            <!--<li class="search-box__tab J-search-box__tab--shops">商家</li>-->
                        </ul>
                    </div>
                    <input tabindex="1" type="text" name="q" autocomplete="off" class="s-text search-box__input J-search-box__input" value="" placeholder="请输入商品名称">
                    <input type="submit" class="s-submit search-box__button" hidefocus="true" value="搜&nbsp;&nbsp;索"  data-mod="sr">
                </form>
                <ul class="search-suggest J-search-suggest" style="display:none;">
                </ul>
                <div class="smart-query-panel" style="display:none">
                    <div class="smart-query-content"></div>
                </div>

            </div>
        </div>
        <div class="site-commitment pngfix">
            <a class="commitment-item commitment-item--retire" href="#" target="_blank"></a>
            <a class="commitment-item commitment-item--free" href="#" target="_blank"></a>
        </div>    
    </div>
    <?php
    if (!isset($this->data['hidden_nav']))
        $this->renderPartial("/layouts/top_nav");
    ?>
</header>