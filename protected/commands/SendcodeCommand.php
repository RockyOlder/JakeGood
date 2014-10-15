<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ExcuteCommand
 *
 * @author Fighter
 */
class SendcodeCommand extends CConsoleCommand {

    public $defaultAction = 'main'; //默认action
	
    protected function beforeAction($action, $params)
    {
        return true;
    }

    /**
     * 	后台执行
     */
    public function actionMain($id)
    {
        exec("php /home/www/htdocs/O2O/yiic sendcode run --id={$id} > /dev/null &");
    }

    public function actionRun($id)
    {
        $order = Order::model()->findByPk($id);
	
        $codes = array();
        if ($order->status == 2)
        {
            $items = $order->OrderItem;

            foreach ($items as $item)
            {
                $codeModel = new OrderCode();
                $attributes = array(
                        'order_id' => $order->getPrimaryKey(),
                        'item_id'  => $item->item_id,
                        'store_id' => $order->store_id,
                        'user_id'  => $order->user_id,
                        'mobile'   => $order->User->username,
                    );
                list($ret, $mobile, $code) = $codeModel->append($attributes);
                if ($ret)
                {
                    $code = chunk_split($code, 4, ' ');
                    $message = '您的密码: '.$code. ' 。';
                    $codes[] = array('mobile' => $mobile, 'message' => $message);
                    $order->status = 3;
                    $order->update();
                }
            }
        }
        
        foreach ($codes as $v)
        {
            $smsRet = SMS::instance()->send($v['mobile'], $v['message']);
        }
    }

}
