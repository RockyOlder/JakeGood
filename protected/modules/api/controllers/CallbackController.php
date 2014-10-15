<?php

class CallbackController extends ApiController {

    public function init()
    {
        parent::init();
        $this->auth();
    }

    private function auth()
    {
        $user = $_SERVER["PHP_AUTH_USER"];
        $pw = $_SERVER["PHP_AUTH_PW"];

        if ($user == "callbackuser" && $pw == 'a1sdf5as3df1a3sd')
        {
            return TRUE;
        }
        else
        {
            die('auth fail');
        }
    }

    public function actionCgb()
    {
        $cgb_sn    = $this->request->getQuery('cgb_sn');
        $outer_sn  = $this->request->getQuery('outer_sn');
        $status    = $this->request->getQuery('status');
        $pay_money = $this->request->getQuery('pay_money');
        $pay_time  = $this->request->getQuery('pay_time');
        switch ($status)
        {
            case 'pay':
                $order = Order::model()->findByAttributes(array('sn' => $outer_sn, 'is_pay' => 0));
                if ($order)
                {
                    $order->is_pay = 1;
                    $order->status = 2;
                    $order->pay_fee = $pay_money;
                    $order->pay_sn = $cgb_sn;
                    $order->pay_time = $pay_time;
                    $order->updated = time();
                    $order->update();
                    $this->sendSmsCode($order->getPrimaryKey());
                }
                break;
                
            case 'complete':

                $order = Order::model()->findByAttributes(array('sn' => $outer_sn));
                if ($order)
                {
                    $order->status = 4;
                    $order->updated = time();
                    $order->update();
                }
                break;
                
            case 'refund':

                $order = Order::model()->findByAttributes(array('sn' => $outer_sn));
                if ($order)
                {
                    $refund = Refund::model()->findByAttributes(array('order_id' => $order->order_id));
                    $refund->status = 6;
                    $refund->process_time =  time();
                    $refund->update();
                    
                    $order->status = 5;
                    $order->refund_status = 6;
                    $order->updated = time();
                    $order->update();
                }
        }
        die('ok');
    }

    function sendSmsCode($orderId)
    {
        pclose(popen("php /home/www/htdocs/O2O/yiic sendcode main --id={$orderId}", 'r'));
    }
}
