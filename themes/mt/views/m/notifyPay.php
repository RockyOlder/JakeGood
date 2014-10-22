
<div class="row text-center">
        <h3>订单支付完成！</h3>
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