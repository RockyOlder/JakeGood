<?php
	include('lib/functions.php');

	$appSecret = 'AFA34324SFA324SFASF';
	$apiUrl = 'http://yiipay.com/api/WebScr';
	$order = array(
				'seller'      => '13724240109', //商家帐户
				'outer_sn'	  => '131205NBF3E7', //订单号
				'title'	  	  => '1号店订单，只为更好的生活(131205NBF3E7)', //订单说明/标题
				'return_url'  => 'http://www.xxx.com/order_detail',
				'total'       => 100.01, //支付总额
				'item_total'  => 90.01, //商品总额
				'express_fee' => 10,
				'address'	  => '广东省深圳市宝安区龙华镇龙胜新村C区205',
				'order_time'  => time(),
				'items'  => array(
								array(
									'item_id' => '11',
									'title'	=> 'IPhone 5s',
									'pic_url'	=> 'http://www.xxx.com/images/aasfdasdf.png',
									'options' =>  '男 XL',
									'price' => 11,
									'quantity' => 3,
									'sub_total' => 22,
								),
							),
			);

	$sign  = createSign($order, $appSecret);
	$param = createStrParam($order);
	header('Location: '.$apiUrl.'?'.$param.'&sign='.$sign);
?>