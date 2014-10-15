<!--BEGIN SIDEBAR MENU-->
<nav id="sidebar" role="navigation" class="navbar-default navbar-static-side">
    <div class="sidebar-collapse menu-scroll">
        <ul id="side-menu" class="nav">
            <li class="user-panel">
                <div class="thumb">
                    <img src="<?php echo $this->store->logo; ?>" alt="" class="img-circle" />
                </div>
                <div class="info" style="margin-top: 10px"><?php echo $this->store->name; ?></div>
                <div class="clearfix"></div>
            </li>
            <li>
                <a href="/verify">
                    <i class="fa fa-tachometer fa-fw">
                        <div class="icon-bg bg-orange">
                        </div>
                    </i>
                    <span class="menu-title">
                        主页
                    </span>
                </a>
            </li>
            <li <?php echo in_array(get_class($this), array('OrdersController')) ? 'class="active"' : ''; ?>>
                <a href="<?php echo $this->createUrl('/verify/orders'); ?>">
                    <i class="fa fa-money fa-fw">
                        <div class="icon-bg bg-pink"></div>
                    </i>
                    <span class="menu-title">
                        交易管理
                    </span>
                </a>
            </li>
            <li <?php echo in_array(get_class($this), array('VisitsController')) ? 'class="active"' : ''; ?>>
                <a href="<?php echo $this->createUrl('/verify/visits/statistics'); ?>">
                    <i class="fa fa-inbox fa-fw">
                        <div class="icon-bg bg-pink"></div>
                    </i>
                    <span class="menu-title">
                        数据中心
                    </span>
                </a>
            </li>
        </ul>
        <?php if (get_class($this) != 'DefaultController'): ?>
            <div class="portlet box portlet-pink">
                <div class="portlet-header">
                    <div class="caption text-uppercase">验证订单</div>
                </div>
                <div class="portlet-body">
                    <form name="form2" id="form2" action='<?php echo $this->createUrl('orders/verify'); ?>#top-store' method="get" class="form-horizontal form-separated form-validate">
                        <div class="input-group">
                            <input type="number" name="code" id="verify_code" minlength="12" maxlength="12" placeholder="请输入12位验证码" class="form-control required number"/>
                            <span class="input-group-btn">
                                <button class="btn btn-pink"> 查 询 </button>
                            </span>
                        </div>
                        <em for="verify_code" class="invalid"></em>
                    </form>
                </div>
            </div>
        <?php endif; ?>
    </div>
</nav>
<!--END SIDEBAR MENU-->