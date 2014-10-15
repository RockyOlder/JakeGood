<!--BEGIN SIDEBAR MENU-->
<nav id="sidebar" role="navigation" class="navbar-default navbar-static-side">
    <div class="sidebar-collapse menu-scroll">
        <ul id="side-menu" class="nav">
            <li class="user-panel">
                <div class="thumb">
                    <img src="<?php echo $this->store->logo; ?>"
                         alt="" class="img-circle" />
                </div>
                <div class="info" style="margin-top: 10px">
                    <p>
                    </p>
                    <ul class="list-inline list-unstyled">
                        <li>
                            <a href="http://i.anarry.com" data-hover="tooltip" title="打开通行证" target="_blank">
                                <i class="fa fa-user">
                                </i>
                            </a>
                        </li>
                        <li>
                            <a href="<?php echo $this->createUrl('store/admin'); ?>" data-hover="tooltip" title="设置">
                                <i class="fa fa-cog">
                                </i>
                            </a>
                        </li>
                        <li>
                            <a href="/logout" data-hover="tooltip" title="登出">
                                <i class="fa fa-sign-out">
                                </i>
                            </a>
                        </li>
                    </ul>
                </div>
                <div class="clearfix">
                </div>
            </li>
            <li>
                <a href="/seller">
                    <i class="fa fa-tachometer fa-fw">
                        <div class="icon-bg bg-orange">
                        </div>
                    </i>
                    <span class="menu-title">
                        商家主页
                    </span>
                </a>
            </li>
            <li <?php echo in_array(get_class($this), array('OrderController', 'RefundController', 'RateController')) ? 'class="active"' : ''; ?>>
                <a href="#">
                    <i class="fa fa-money fa-fw">
                        <div class="icon-bg bg-pink"></div>
                    </i>
                    <span class="menu-title">
                        交易管理
                    </span>
                </a>
                <ul class="nav nav-second-level collapse in">
                    <li <?php echo $this->request->getPathInfo() == 'seller/order/list' ? 'class="active"' : ''; ?>>
                        <a href="<?php echo $this->createUrl('order/list'); ?>">
                            <i class="fa fa-shopping-cart"></i>
                            <span class="submenu-title">
                                已卖出的宝贝
                            </span>
                        </a>
                    </li>
                    <li <?php echo $this->request->getPathInfo() == 'seller/order/listNew' ? 'class="active"' : ''; ?>>
                        <a href="<?php echo $this->createUrl('order/listNew'); ?>">
                            <i class="fa fa-outdent"></i>
                            <span class="submenu-title">
                                发货
                            </span>
                        </a>
                    </li>
                    <li <?php echo $this->request->getPathInfo() == 'seller/rate/index' ? 'class="active"' : ''; ?>>
                        <a href="<?php echo $this->createUrl('rate/index'); ?>">
                            <i class="fa fa-star"></i>
                            <span class="submenu-title">
                                评价管理
                            </span>
                        </a>
                    </li>
                    <li <?php echo $this->request->getPathInfo() == 'seller/refund/list' ? 'class="active"' : ''; ?>>
                        <a href="<?php echo $this->createUrl('refund/list'); ?>">
                            <i class="fa fa-sort-amount-desc"></i>
                            <span class="submenu-title">
                                退款管理
                            </span>
                        </a>
                    </li>
                </ul>
            </li>
            <li <?php echo in_array(get_class($this), array('ItemController')) ? 'class="active"' : ''; ?>>
                <a href="#">
                    <i class="fa fa-inbox fa-fw">
                        <div class="icon-bg bg-pink"></div>
                    </i>
                    <span class="menu-title">
                        团购管理
                    </span>
                </a>
                <ul class="nav nav-second-level collapse in">
                    <li <?php echo $this->request->getPathInfo() == 'seller/item/create' ? 'class="active"' : ''; ?>>
                        <a href="<?php echo $this->createUrl('item/create'); ?>">
                            <i class="fa fa-plus-square"></i>
                            <span class="submenu-title">
                                发布团购
                            </span>
                        </a>
                    </li>
                    <li <?php echo $this->request->getPathInfo() == 'seller/item/onSale' ? 'class="active"' : ''; ?>>
                        <a href="<?php echo $this->createUrl('item/onSale'); ?>">
                            <i class="fa fa-signal"></i>
                            <span class="submenu-title">
                                进行中的团购
                            </span>
                        </a>
                    </li>
                    <li <?php echo $this->request->getPathInfo() == 'seller/item/stock' ? 'class="active"' : ''; ?>>
                        <a href="<?php echo $this->createUrl('item/stock'); ?>">
                            <i class="fa fa-tasks"></i>
                            <span class="submenu-title">
                                结束的团购
                            </span>
                        </a>
                    </li>
                </ul>
            </li>
            <li <?php echo in_array(get_class($this), array('StoreController')) ? 'class="active"' : ''; ?>>
                <a href="#">
                    <i class="fa fa-globe fa-fw">
                        <div class="icon-bg bg-pink"></div>
                    </i>
                    <span class="menu-title">
                        商家管理
                    </span>
                </a>
                <ul class="nav nav-second-level collapse in">
                    <li <?php echo in_array(get_class($this), array('ShopController')) ? 'class="active"' : ''; ?>>
                        <a href="<?php echo $this->createUrl('shop/list'); ?>">
                            <i class="fa fa-anchor"></i>
                            <span class="submenu-title">
                                商家管理
                            </span>
                        </a>
                    </li>
                </ul>
            </li>
            <li <?php echo in_array(get_class($this), array('AddressBookController', 'VisitsController')) ? 'class="active"' : ''; ?>>
                <a href="#">
                    <i class="fa fa-inbox fa-fw">
                        <div class="icon-bg bg-pink"></div>
                    </i>
                    <span class="menu-title">
                        其他
                    </span>
                </a>
                <ul class="nav nav-second-level collapse in">
                    <li <?php echo $this->request->getPathInfo() == 'seller/addressBook/index' ? 'class="active"' : ''; ?>>
                        <a href="<?php echo $this->createUrl('addressBook/index'); ?>">
                            <i class="fa fa-book"></i>
                            <span class="submenu-title">
                                地址库
                            </span>
                        </a>
                    </li>
                    <li <?php echo $this->request->getPathInfo() == 'seller/visits/statistics' ? 'class="active"' : ''; ?>>
                        <a href="<?php echo $this->createUrl('visits/statistics'); ?>">
                            <i class="fa fa-puzzle-piece"></i>
                            <span class="submenu-title">
                                数据中心
                            </span>
                        </a>
                    </li>
                </ul>
            </li>
        </ul>
    </div>
</nav>
<!--END SIDEBAR MENU-->