<?php

class CGB extends CComponent {

    public $apiUrl = 'http://cgb.anarry.com/api/trans';  //正式环境提交URL
    public $appKey = 'xxxxx'; //填写自己申请的AppKey
    public $appSecret = 'xxxxxxxxxxxxxxxxx'; //填写自己申请的$appSecret
    public $returnUrl = '';
    public $orders;
    public $market;

    public function init() 
    {
        $this->returnUrl = Yii::app()->createAbsoluteUrl('/notify/pay');
    }
    
    function setMarket($market)
    {
        $this->market    = $market;
        $this->appKey    = $market->app_key;
        $this->appSecret = $market->app_secret;        
    }
    /**
     * $order 
     *  array(
            'seller'      => '18107558557', //商家帐户
            'outer_sn'    => '131205NBF3B3'.time(), //订单号
            'title'	      => '1号店订单，只为更好的生活', //订单说明/标题
            'total'       => 123, //支付总额
            'item_total'  => 123, //商品总额
            'express_fee' => 10,
            'address'     => '广东省深圳市宝安区龙华镇龙胜新村C区205',
            'order_time'  => 1394769395,
            'order_url'   => 'http://www.xxx.com/order?id=xxxxx',
         )
     * @param type $order
     */
    function setOrder($order = array())
    {
        $order['appKey'] = $this->appKey;
        $this->orders[] = $order;
    }

    /**
     * 支付
     */
    function checkout()
    {
        include_once('functions.php');
        
        $timestamp = $this->orders[0]['order_time'];
        $sign  = createSign($this->orders, $this->appSecret, $timestamp);
        $token = Yii::app()->user->getState('token');
        $returnUrl = $this->returnUrl.'?timestamp='. $timestamp;
        $query = buildQuery($this->orders, (string)$this->appKey, $sign);
        $query .= '&' . http_build_query(array('return_url' => $returnUrl, 'token' => $token, 'timestamp' => $timestamp));
        Yii::app()->request->redirect($this->apiUrl.'/new?'.$query);        
    }

    /**
     * 确认收货
     */
    function confirm($orderSn, $cgbSn)
    {
        $token = Yii::app()->user->getState('token');
        $returnUrl = Yii::app()->createAbsoluteUrl('/member/orders/detail', array('sn' => $orderSn));
        $query = http_build_query(array('return_url' => $returnUrl, 'sn' =>$cgbSn, 'token' => $token, 'timestamp' => $timestamp));
        Yii::app()->request->redirect($this->apiUrl.'/confirm?'.$query);
    }

    /**
     * 退款
     */
    function refund($orderSn, $cgbSn)
    {
        $token = Yii::app()->user->getState('token');
        $returnUrl = Yii::app()->createAbsoluteUrl('/member/orders/detail', array('sn' => $orderSn));
        $query = http_build_query(array('return_url' => $returnUrl, 'sn' =>$cgbSn, 'token' => $token, 'timestamp' => $timestamp));
        Yii::app()->request->redirect($this->apiUrl.'/refund?'.$query);
    }
}

?>