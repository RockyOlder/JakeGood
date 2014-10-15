<?php //print_r($orders);exit; ?>
<!DOCTYPE HTML>
<html lang="zh-CN">
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0;">
		<title>个人中心</title>
		<meta name="apple-mobile-web-app-capable" content="yes">
		<meta name="apple-mobile-web-app-status-bar-style" content="black">
		<meta name="format-detection" content="telephone=no">
		<link rel="stylesheet" href="/themes/mt/mobile/css/personal_center.css" />
	</head>
	<body>
		<div class="wx_wrap">
		
			<div class="my_head">
                <a class="my_user">
                    <div class="image">
                        <img width="50" height="50" src="images/head_portrait.jpg">
                    </div>
                    <p class="name"><span class="tag">微信账号</span><span class="text">Coolbaby（93674327）</span></p>
                    <p class="des">请完善京东帐号，获得更好服务</p>
                </a>
            </div>
			
			<div class="my_menu">
				<ul>
					<li class="tiao">
						<a href="<?php echo $this->createUrl('/mobile/order/index'); ?>" class="menu_1">全部订单</a>
					</li>
					<li class="tiao">
						<a href="javascript:;" class="menu_2"><span><?php echo $total;  ?></span>待付款</a>
					</li>
					<li class="tiao">
						<a href="javascript:;" class="menu_3"><span></span>配送中</a>
					</li>
					<li class="tiao">
						<a href="javascript:;" class="menu_4">退换货</a>
					</li>
				</ul>
			</div>
	
			<ul class="my_list">
				<li class="tiao">
					<a href="javascript:;">我的京东券<em></em><span></span></a>
				</li>
				<li class="hr"></li>
				<li class="tiao">
					<a href="<?php echo Yii::app()->createUrl('/mobile/cart');  ?>">我的购物车<em id="cartNum"></em><span></span></a>
				</li>
				<li class="tiao">
					<a href="javascript:;">我的收藏</a>
				</li>
				<li style="display: none">
					<a href="javascript:;">我关注的品牌</a>
				</li>
				<li class="tiao">
					<a href="javascript:;">我的浏览记录</a>
				</li>
				<li class="tiao">
					<a href="javascript:;">我的预约商品</a>
				</li>
				<li class="hr"></li>
				<li class="tiao">
					<a href="javascript:;">收货地址管理</a>
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
	</body>
</html>