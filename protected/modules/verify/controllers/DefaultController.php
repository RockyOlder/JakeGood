<?php

class DefaultController extends VerifyController {

    public $title = '店铺主页';
    public function actionIndex()
    {
        $store_id = Yii::app()->user->getId();
        $data['waitShip'] = Order::model()->countByAttributes(array('store_id' => $store_id, 'is_pay' => 1, 'status' => 2));
        $data['waitPay'] = Order::model()->countByAttributes(array('store_id' => $store_id, 'is_pay' => 0, 'status' => 1));
        $data['stockItems'] = Item::model()->countByAttributes(array('store_id' => $store_id, 'is_show' => 0));
        $data['onSaleItems'] = Item::model()->countByAttributes(array('store_id' => $store_id, 'is_show' => 1));
        $data['showcaseItems'] = Item::model()->countByAttributes(array('store_id' => $store_id, 'is_showcase' => 1));
        $data['store'] = $this->store;

        $this->data = $data;

        $this->template = 'index';
    }

}
