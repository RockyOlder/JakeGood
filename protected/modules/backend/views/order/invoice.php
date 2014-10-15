<!DOCTYPE html>
<html lang="en">
    <head>
        <title>
            <?php echo $this->store->name; ?>
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

        <link href="/assets/plugins/jquery-pagination/style.css" rel="stylesheet" type="text/css"/>

        <link rel="stylesheet" href="/assets/style.css" type="text/css" />

        <style type="text/css" media="print">
            .btn_print {display:none;}
        </style>
    </head>
    <body>
        <div>
            <div id="">
                <!--BEGIN PAGE WRAPPER-->
                <div id="">
                    <!--BEGIN CONTENT-->
                    <div class="page-content">
                        <div id="invoice-page" class="row">
                            <div style="width:980px;">
                                <div class="col-lg-12 btn_print text-right" style="margin:0 0 20px 0;">
                                    <button type="submit" class="btn btn-success mrm" onclick="print()">
                                        <i class="fa fa-print">
                                        </i>
                                        &nbsp; 打印
                                    </button>
                                </div>
                                <div class="panel">
                                    <div class="panel-body">
                                        <div class="invoice-title">
                                            <h2>
                                                订单
                                            </h2>
                                            <p class="mbn text-left">
                                                订单号# <?php echo $order->sn; ?>
                                            </p>
                                            <p class="text-left">
                                                日期：<?php echo date('Y-m-d', $order->created); ?>
                                            </p>
                                        </div>
                                        <div class="pull-left">
                                            <h2 class="text-green logo">
                                                <?php echo $this->store->name; ?>
                                            </h2>
                                            <address class="mbn">
                                                <?php echo $this->store->address; ?>
                                                <br>
                                                <?php echo $this->store->area; ?>
                                                ,
                                                <?php echo $this->store->zipcode; ?>
                                                <br>
                                                <abbr title="联系电话">
                                                    电话:
                                                </abbr>
                                                <?php echo $this->store->phone; ?>
                                                <br>
                                                <br>
                                                <?php //echo $this->store->domain; ?>
                                            </address>
                                        </div>
                                        <div class="clearfix">
                                        </div>
                                        <hr>
                                        <div class="row">
                                            <div class="col-lg-10">
                                                <address>
                                                    <strong>
                                                        送货地址:
                                                    </strong>
                                                    <br>
                                                    <?php echo $order['receiver_name'] ?>
                                                    <br>
                                                    <?php echo $order['receiver_address'] . ', ' . $order['receiver_zip'] ?>
                                                    <br>
                                                    <?php echo $order['receiver_mobile'] . ', ' . $order['receiver_phone']; ?>
                                                </address>
                                            </div>
                                        </div>
                                        <hr>
                                        <div class="table-responsive">
                                            <table class="table table-condensed">
                                                <thead>
                                                    <tr>
                                                        <th>商品</th>
                                                        <th>单价</th>
                                                        <th>数量</th>
                                                        <th>运费</th>
                                                        <th>小计</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php foreach ($order['OrderItem'] as $k => $item): ?>
                                                        <tr>
                                                            <td>
                                                                <div><?php echo $item->title; ?></div>
                                                                <div><?php echo $item->props_name; ?></div>
                                                            </td>
                                                            <td><?php echo $item->price; ?></td>
                                                            <td><?php echo $item->quantity; ?></td>
                                                            <td><?php echo $item->ship_fee; ?></td>
                                                            <td><?php echo $item->total; ?></td>
                                                        </tr>
                                                    <?php endforeach; ?>
                                                </tbody>
                                                <tr>
                                                    <td class="no-line text-right" colspan="5">
                                                            <strong class="text-green mtn">
                                                              总运费 ￥<?php echo $order['ship_fee']; ?>
                                                            </strong>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="no-line text-right" colspan="5">
                                                        <h4 class="text-green mtn">
                                                            <strong>
                                                              总金额 ￥<?php echo $order['amount']; ?>
                                                            </strong>
                                                        </h4>
                                                    </td>
                                                </tr>
                                            </table>
                                        </div>
                                        <hr class="mbm">
                                        <p>
                                            <?php echo $order['memo']; ?>
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--END CONTENT-->
                </div>

                <!--END PAGE WRAPPER-->
            </div>
        </div>
    </body>
</html>
<!-- Localized -->