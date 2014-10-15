<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Notify
 *
 * @author Fighter
 */
class NotifyController extends BaseController {
    
    public $must_login = TRUE;
            
    function init()
    {
        parent::init();
    }
    
    function actionPay()
    {
        $this->template = '/notifyPay';
        $time = $this->request->getQuery('timesmap');
        $orders = Order::model()->findAllByAttributes(array('created' => $time));
        $this->data['orders'] = $orders;
    }
}