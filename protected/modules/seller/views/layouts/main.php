<!DOCTYPE html>
<html lang="en">
    <head>
        <script src="/assets/skin/fourteen/js/jquery-1.10.2.min.js"></script>
        <title>
            阿那里商家后台
        </title>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="cache-control" content="no-cache">
        <meta http-equiv="expires" content="Thu, 19 Nov 1900 08:52:00 GMT">
        <link rel="shortcut icon" href="/assets/skin/fourteen/images/icons/favicon.ico">
        <link rel="apple-touch-icon" href="/assets/skin/fourteen/images/icons/favicon.png">
        <link rel="apple-touch-icon" sizes="72x72" href="/assets/skin/fourteen/images/icons/favicon-72x72.png">
        <link rel="apple-touch-icon" sizes="114x114" href="/assets/skin/fourteen/images/icons/favicon-114x114.png">
        <!--Loading bootstrap css-->
        <link type="text/css" rel="stylesheet" href="/assets/skin/fourteen/vendors/jquery-ui-1.10.4.custom/css/ui-lightness/jquery-ui-1.10.4.custom.min.css">
        <link type="text/css" rel="stylesheet" href="/assets/skin/fourteen/vendors/font-awesome/css/font-awesome.min.css">
        <link type="text/css" rel="stylesheet" href="/assets/skin/fourteen/vendors/bootstrap/css/bootstrap.min.css">
        <!--LOADING STYLESHEET FOR PAGE-->
        <link type="text/css" rel="stylesheet" href="/assets/skin/fourteen/vendors/intro.js/introjs.css">
        <link type="text/css" rel="stylesheet" href="/assets/skin/fourteen/vendors/calendar/zabuto_calendar.min.css">
        <link type="text/css" rel="stylesheet" href="/assets/skin/fourteen/vendors/sco.message/sco.message.css">
        <link type="text/css" rel="stylesheet" href="/assets/skin/fourteen/vendors/intro.js/introjs.css">
        <!--Loading style vendors-->
        <link type="text/css" rel="stylesheet" href="/assets/skin/fourteen/vendors/animate.css/animate.css">
        <link type="text/css" rel="stylesheet" href="/assets/skin/fourteen/vendors/jquery-pace/pace.css">
        <link type="text/css" rel="stylesheet" href="/assets/skin/fourteen/vendors/iCheck/skins/all.css">
        <link type="text/css" rel="stylesheet" href="/assets/skin/fourteen/vendors/jquery-notific8/jquery.notific8.min.css">
        <!--LOADING STYLESHEET FOR PAGE-->
        <link type="text/css" rel="stylesheet" href="/assets/skin/fourteen/vendors/bootstrap-progressbar/css/bootstrap-progressbar-3.1.1.min.css">
        <!--Loading style-->
        <link type="text/css" rel="stylesheet" href="/assets/skin/fourteen/vendors/lightbox/css/lightbox.css">
        <link type="text/css" rel="stylesheet" href="/assets/skin/fourteen/css/themes/style1/pink-blue.css" />
        <link type="text/css" rel="stylesheet" href="/assets/skin/fourteen/css/style-responsive.css">

        <script type="text/javascript" src="/assets/plugins/fancybox/source/jquery.fancybox.js"></script>
        <link rel="stylesheet" type="text/css" href="/assets/plugins/fancybox/source/jquery.fancybox.css" media="screen" />

        <script src="/assets/skin/fourteen/js/jquery-migrate-1.2.1.min.js"></script>
        <script src="/assets/skin/fourteen/js/jquery-ui.js"></script>

        <!-- jquery paginate -->
        <script src="/assets/plugins/jquery-pagination/jquery-pagination.js" type="text/javascript"></script>
        <link href="/assets/plugins/jquery-pagination/style.css" rel="stylesheet" type="text/css"/>

        <!-- jquery lazyload -->
        <script type="text/javascript" src="/assets/plugins/jquery-lazyload/jquery.lazyload.min.js"></script>

        <link rel="stylesheet" href="/assets/style.css" type="text/css" />

        <style type="text/css">
            .chat-inner .avt, .avatar{width: 30px;
                                      height: 30px;
                                      border-radius: 50%;
                                      margin: 5px 5px 0px 0px;
                                      vertical-align: -9px;
            }
            #chat-form #chat-box ul.chat-box-body {height: auto;}
        </style>
        <script type="text/javascript">
            $(document).ready(function() {
                $("img.lazy").lazyload();
                var dpconfig = {
                    dateFormat: 'yy-mm-dd',
                    yearRange: "2012:<?php echo date('Y') ?>",
                    monthNamesShort: ['1', '2', '3', '4', '5', '6', '7', '8', '9', '10', '11', '12'],
                    dayNamesMin: ['日', '一', '二', '三', '四', '五', '六'],
                };
                $("input.datepiker").datepicker(dpconfig);
            });
            
        </script>

    </head>
    <body>
        <div>
            <!--BEGIN BACK TO TOP-->
            <a id="totop" href="#">
                <i class="fa fa-angle-up">
                </i>
            </a>
            <!--END BACK TO TOP-->
            <!--BEGIN TOPBAR-->
            <div id="header-topbar-option-demo" class="page-header-topbar">
                <nav id="topbar" role="navigation" style="margin-bottom: 0; z-index: 2;"
                     class="navbar navbar-default navbar-static-top">
                    <div class="navbar-header">
                        <button type="button" data-toggle="collapse" data-target=".sidebar-collapse"
                                class="navbar-toggle">
                            <span class="sr-only">
                                Toggle navigation
                            </span>
                            <span class="icon-bar">
                            </span>
                            <span class="icon-bar">
                            </span>
                            <span class="icon-bar">
                            </span>
                        </button>
                        <a id="logo" href="javascript:;" class="navbar-brand">
                            <span class="fa fa-rocket">
                            </span>
                            <span class="logo-text">
                                阿那里
                            </span>
                            <span style="display: none" class="logo-text-icon">
                                ANA
                            </span>
                        </a>
                    </div>
                    <div class="topbar-main">
                        <a id="menu-toggle" href="#" class="hidden-xs">
                            <i class="fa fa-bars">
                            </i>
                        </a>
                        <form id="topbar-search" action="#" method="GET" class="hidden-xs">
                            <div class="input-group">
                                <input type="text" placeholder="Search..." class="form-control" />
                                <span class="input-group-btn">
                                    <a href="javascript:;" class="btn submit">
                                        <i class="fa fa-search">
                                        </i>
                                    </a>
                                </span>
                            </div>
                        </form>
                        <ul class="nav navbar navbar-top-links navbar-right mbn">
                            <li class="dropdown">
                                <a data-hover="dropdown" href="#" class="dropdown-toggle">
                                    <i class="fa fa-bell fa-fw">
                                    </i>
                                    <span class="badge badge-green"></span>
                                </a>
                                <ul class="dropdown-menu dropdown-alerts">
                                    <li>
                                        <p>
                                            最新提醒
                                        </p>
                                    </li>
                                    <li>
                                        <div class="dropdown-slimscroll">
                                            <ul>
                                                <li>
                                                    <a href="#">
                                                        <span class="label label-blue">
                                                            <i class="fa fa-comment">
                                                            </i>
                                                        </span>
                                                        New Comment
                                                        <span class="pull-right text-muted small">
                                                            4 mins ago
                                                        </span>
                                                    </a>
                                                </li>
                                            </ul>
                                        </div>
                                    </li>
                                    <li class="last">
                                        <a href="/remind" class="text-right">
                                            查看所有提醒
                                        </a>
                                    </li>
                                </ul>
                            </li>

                            <li class="dropdown topbar-user">
                                <a data-hover="dropdown" href="#" class="dropdown-toggle">
                                    <img src="http://i.anarry.com/avatar?u=<?php echo Yii::app()->user->getName(); ?>"class="img-responsive img-circle" />
                                    <span class="hidden-xs">
                                        <?php echo Yii::app()->user->getName(); ?>
                                    </span>
                                    <span class="caret">
                                    </span>
                                </a>
                                <ul class="dropdown-menu dropdown-user pull-right">
                                    <li>
                                        <a href="http://i.anarry.com" target="_blank">
                                            <i class="fa fa-user">
                                            </i>
                                            我的通行证
                                        </a>
                                    </li>
                                    <li>
                                        <a href="/seller/login/logout">
                                            <i class="fa fa-key">
                                            </i>
                                            登出
                                        </a>
                                    </li>
                                </ul>
                            </li>
                        </ul>
                    </div>
                </nav>
            </div>
            <!--END TOPBAR-->
            <div id="wrapper">
                <!--BEGIN SIDEBAR MENU-->
                <?php $this->renderPartial("/layouts/menu") ?>
                <!--END SIDEBAR MENU-->
                <!--BEGIN PAGE WRAPPER-->
                <div id="page-wrapper">
                    <!--BEGIN TITLE & BREADCRUMB PAGE-->
                    <div id="title-breadcrumb-option-demo" class="page-title-breadcrumb">
                        <div class="page-header pull-left">
                            <div class="page-title"><?php echo isset($this->title) ? $this->title : ''; ?></div>
                        </div>
                        <ol class="breadcrumb page-breadcrumb pull-right">
                            <?php if ($breadcrumbs) : ?>
                                <li><i class="fa fa-laptop"></i>&nbsp;&nbsp;
                                    <?php foreach ($breadcrumbs as $k => $v) : ?>
                                    <li><?php
                                        if (is_string($k))
                                            echo CHtml::link($v, $k);
                                        else
                                            echo $v;
                                        ?>
                                        <i class="fa fa-angle-right"></i>&nbsp;&nbsp;
                                    <?php endforeach; ?>
                                <?php endif; ?>
                        </ol>
                        <div class="clearfix">
                        </div>
                    </div>
                    <!--END TITLE & BREADCRUMB PAGE-->
                    <!--BEGIN CONTENT-->
                    <div class="page-content">
                        <?php echo $content; ?>
                    </div>
                    <!--END CONTENT-->
                </div>

                <!--END PAGE WRAPPER-->
            </div>
        </div>
        <!--loading bootstrap js-->
        <script src="/assets/skin/fourteen/vendors/bootstrap/js/bootstrap.min.js">
        </script>
        <script src="/assets/skin/fourteen/vendors/bootstrap-hover-dropdown/bootstrap-hover-dropdown.js">
        </script>
        <script src="/assets/skin/fourteen/js/html5shiv.js">
        </script>
        <script src="/assets/skin/fourteen/js/respond.min.js">
        </script>
        <script src="/assets/skin/fourteen/vendors/metisMenu/jquery.metisMenu.js">
        </script>
        <script src="/assets/skin/fourteen/vendors/slimScroll/jquery.slimscroll.js">
        </script>
        <script src="/assets/skin/fourteen/vendors/jquery-cookie/jquery.cookie.js">
        </script>
        <script src="/assets/skin/fourteen/vendors/iCheck/icheck.min.js">
        </script>
        <script src="/assets/skin/fourteen/vendors/iCheck/custom.min.js">
        </script>
        <script src="/assets/skin/fourteen/vendors/jquery-notific8/jquery.notific8.min.js">
        </script>
        <script src="/assets/skin/fourteen/vendors/jquery-highcharts/highcharts.js">
        </script>
        <script src="/assets/skin/fourteen/js/jquery.menu.js">
        </script>
        <script src="/assets/skin/fourteen/vendors/jquery-pace/pace.min.js">
        </script>
        <script src="/assets/skin/fourteen/vendors/holder/holder.js">
        </script>
        <script src="/assets/skin/fourteen/vendors/responsive-tabs/responsive-tabs.js">
        </script>
        <!--CORE JAVASCRIPT-->
        <script src="/assets/skin/fourteen/js/main.js">
        </script>
        <!--LOADING SCRIPTS FOR PAGE-->
        <script src="/assets/skin/fourteen/vendors/intro.js/intro.js">
        </script>
        <script src="/assets/skin/fourteen/vendors/flot-chart/jquery.flot.js">
        </script>
        <script src="/assets/skin/fourteen/vendors/flot-chart/jquery.flot.categories.js">
        </script>
        <script src="/assets/skin/fourteen/vendors/flot-chart/jquery.flot.pie.js">
        </script>
        <script src="/assets/skin/fourteen/vendors/flot-chart/jquery.flot.tooltip.js">
        </script>
        <script src="/assets/skin/fourteen/vendors/flot-chart/jquery.flot.resize.js">
        </script>
        <script src="/assets/skin/fourteen/vendors/flot-chart/jquery.flot.fillbetween.js">
        </script>
        <script src="/assets/skin/fourteen/vendors/flot-chart/jquery.flot.stack.js">
        </script>
        <script src="/assets/skin/fourteen/vendors/flot-chart/jquery.flot.spline.js">
        </script>
        <script src="/assets/skin/fourteen/vendors/calendar/zabuto_calendar.min.js">
        </script>
        <script src="/assets/skin/fourteen/vendors/sco.message/sco.message.js">
        </script>
        <script src="/assets/skin/fourteen/vendors/intro.js/intro.js">
        </script>
        <!--LOADING SCRIPTS FOR PAGE-->
        <script src="/assets/skin/fourteen/vendors/mixitup/src/jquery.mixitup.js">
        </script>
        <script src="/assets/skin/fourteen/vendors/lightbox/js/lightbox.min.js">
        </script>
        <script src="/assets/skin/fourteen/js/page-gallery.js"></script>        
        <script src="/assets/skin/fourteen/vendors/jquery-validate/jquery.validate.min.js"></script>
        <script src="/assets/skin/fourteen/vendors/jquery-validate/localization/messages_zh.js"></script>
        <script src="/assets/skin/fourteen/js/form-validation.js"></script>

    </body>

</html>
<!-- Localized -->