
<link rel="stylesheet" type="text/css" href="/themes/mt/css/cart.v9a94b40a.css">
<link rel="stylesheet" type="text/css" href="/themes/mt/css/table-section.vfa4da119.css">
<link rel="stylesheet" type="text/css" href="/themes/mt/css/deal.v80160138.css">

<style>
    .orders {margin: 0 auto; width: 300px;margin-top:50px;}
</style>

<div class="pg-buy pg-cart">
    <div id="bdw" class="bdw pg-buy pg-cart">
        <div id="bd" class="cf">
            <div id="content">
                <div class="orders">
                    <h3>以下订单支付完成！</h3>
                    <ul style="line-height: 25px;margin:10px;">
                        <?php 
                            foreach ($orders as $order)
                            {
                                echo '<li>订单号: '.$order->sn;
                            }
                            ?>
                    </ul>
                    <a href="/member/orders">查看我的订单</a>
                </div>
            </div>
        </div>
    </div>
</div>