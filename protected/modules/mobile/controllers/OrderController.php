<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of OrderController
 *
 * @author Fighter
 */
class OrderController extends BaseController {

    public $must_login = TRUE;

    function init() {
        parent::init();
        $this->data['statusOptions'] = $list = array(
            0 => '异常订单',
            1 => '未付款',
            2 => '已付款，未发货',
            3 => '已发货',
            4 => '交易完成',
            5 => '交易关闭',
            6 => '退款中',
            7 => '定金已付'
        );
    }

    public function actionIndex() {
        $this->layout = 'bootstrap';
        $this->template = '/orders/list';
        $this->actionList();
    }

    public function actionPersonal() {

        $this->layout = 'bootstrap';
        $this->template = '/orders/personal';
        $this->actionList();
    }

    public function actionListRefund() {
        $this->template = 'listRefund';
        $model = new Order('search');

        $orders = $model->findAll('store_id=:store_id AND is_pay=1 AND status = 6', array(':store_id' => Yii::app()->user->getId()));

        $this->data['orders'] = $orders;
    }

    public function actionDetail() {
        //echo 1;exit;
        //    print_r($_REQUEST);exit;
        $id = Yii::app()->user->getId();
        $sn = $this->request->getQuery('sn');
        $order = Order::model()->findByAttributes(array('sn' => $sn, 'user_id' => Yii::app()->user->getId()));

        if ($order) {
            $addres = new AddressBook();
            $addres_user = $addres->find("user_id=$id and `default`=1");
            $orderShip = OrderShip::model()->findByAttributes(array('order_id' => $order->order_id));
            // print_r($orderShip);exit;
            $this->data['orderShip'] = $orderShip;
            $this->data['order'] = $order;
            $this->data['addres'] = $addres_user;
            $this->layout = 'bootstrap';
            $this->template = '/orders/detail';
        } else {
            parent::renderError('订单不存在', '');
        }
    }

    public function actionRemove($sn) {
        $sn = $this->request->getQuery('sn');
        $order = Order::model()->findByAttributes(array('sn' => $sn, 'user_id' => Yii::app()->user->getId()));
        if ($order) {
            $order->user_del = 1;
            $order->update();
        }
        $this->request->redirect($this->createUrl('index'));
    }

    public function actionDelete($id) {
        $sn = $this->request->getQuery('sn');
        $order = Order::model()->findByAttributes(array('sn' => $sn, 'user_id' => Yii::app()->user->getId()));
        if ($order) {
            $order->user_del = 1;
            $order->update();
        }
        $this->request->redirect($this->createUrl('index'));
    }

    public function actionPay() {
     //   echo 1;exit;
        $sn = $this->request->getQuery('sn');
        $order = Order::model()->findByAttributes(array('sn' => $sn, 'user_id' => Yii::app()->user->getId()));

        if ($order && $order->is_pay == 0) {
          //  echo 1;exit;
            $items = $order->OrderItem;
            $ext = count($items) > 1 ? '...等多件' : '';
            $arr = array(
                'seller' => (int) $order->store_id, //商家帐户
                'outer_sn' => (string) $order->sn, //订单号
                'title' => (string) $items[0]['title'] . $ext, //订单说明/标题
                'total' => (float) $order->amount, //支付总额
                'item_total' => (float) $order->item_total, //商品总额
                'express_fee' => (string) $order->ship_fee,
                'address' => (string) $order->receiver_address,
                'order_time' => (int) $order->created,
                'order_url' => (string) Yii::app()->createAbsoluteUrl('member/order/detail', array('sn' => $order->sn)),
            );
            Yii::app()->CGB->setOrder($arr);
            Yii::app()->CGB->setMarket($this->market);
            Yii::app()->CGB->checkout();
        }
        die;
    }

    public function actionList() {

        $filter = $this->request->getQuery('filter');
        $criteria = new CDbCriteria;
        $criteria->addCondition('t.market_id = ' . $this->market->getPrimaryKey());
        $criteria->addCondition('user_id = ' . Yii::app()->user->getId());
        $criteria->addCondition('user_del = 0');

        if ($filter) {
            if ($filter['item'] != '') {
                $criteria->join = 'LEFT JOIN order_item ON order_item.order_id = t.order_id ';
                $criteria->addCondition("order_item.title like '%" . $filter['item'] . "%'");
                $criteria->group = 't.order_id';
            }
            if ($filter['startTime'] != '') {
                $criteria->addCondition('created >= ' . strtotime($filter['startTime']));
            }
            if ($filter['endTime'] != '') {
                $criteria->addCondition('created <= ' . strtotime($filter['endTime']));
            }
            if ($filter['orderSn'] != '') {
                $criteria->addCondition('sn like ' . $filter['orderSn']);
            }
            if ($filter['orderStatus'] > 0) {
                $criteria->addCondition('status =' . (int) $filter['orderStatus']);
            }
            if ($filter['commentStatus'] != '') {
                $criteria->addCondition('comment_status = ' . (int) $filter['commentStatus']);
            }
        }
        $criteria->order = 'order_id desc';
        $model = new Order('search');
     
        $count = $model->count($criteria);
     //  print_r($count);exit;
        $pages = new CPagination($count);
        $pages->pageSize = 10;
        $pages->applyLimit($criteria);

        $orders = $model->findAll($criteria);

        foreach ($orders as $k => $order) {
            if ($order->status == 1) {
                $onestarts[] = $order->status;
            } elseif ($order->status == 3) {
                $threestarts[] = $order->status;
            } elseif ($order->status == 6) {
                $sixstarts[] = $order->status;
            }
        }
        $this->data['filter'] = $filter;
        $this->data['total'] = count($orders);
        $this->data['payment'] = count($threestarts);
        $this->data['sixstarts'] = count($sixstarts);
        $this->data['notpaying'] = count($onestarts);
        $this->data['orders'] = $orders;
        $this->data['pages'] = $pages;
    }

    public function actionConfirm() {
        $this->layout = 'bootstrap';
        $this->template = '/confirm_order';
        $from = $this->request->getPost('from'); //来自详情页立即购买
   //print_r($cart);exit;
        $this->data['hidden_nav'] = true;
        if ($from == 'detail') {
            list($items, $sub_total, $amount, $ships) = $this->buildItem();

            $this->data['items'] = $items;
            $this->data['sub_total'] = $sub_total;
            $this->data['ships'] = $ships;
            $this->data['amount'] = sprintf("%.2f", $amount);
        } else {
            $buy_items = $this->request->getPost('items');
            if (!$buy_items) {
                return parent::renderError('没有要结算的商品');
            }
            $cart = ShoppingCart::model()->findByAttributes(array('user_id' => Yii::app()->user->getId(), 'market_id' => $this->market->market_id));
         
            $items = json_decode($cart->items);
            $confirm_items = array();
            $amount = 0;
            foreach ($buy_items as $store_id => $v) {
                $ship_data = array('express' => 0, 'ems' => 0, 'post' => 0);
                $sub_total = 0;
                $confirm_items[$store_id] = (object) array();
                foreach ($v as $sku_id => $t) {
                    $cart_item = $items->$store_id->$sku_id;
                    $item = Item::model()->findByPk($cart_item->item_id);

                    $ship_data['express'] += $item->express_fee;
                    $ship_data['ems'] += $item->ems_fee;
                    $ship_data['post'] += $item->post_fee;

                    $cart_item->total = sprintf("%.2f", $items->$store_id->$sku_id->price * $items->$store_id->$sku_id->quantity);
                    $sub_total += $cart_item->total;
                    $confirm_items[$store_id]->$sku_id = $cart_item;
                }

                $amount += $sub_total + $ship_data['express'];
                $this->data['sub_total'][$store_id] = sprintf("%.2f", $sub_total + $ship_data['express']);

                $ship_data['express'] = sprintf("%.2f", $ship_data['express']);
                $ship_data['ems'] = sprintf("%.2f", $ship_data['ems']);
                $ship_data['post'] = sprintf("%.2f", $ship_data['post']);
                $this->data['ships'][$store_id]['data'] = $ship_data;
                $this->data['ships'][$store_id]['options']['express'] = '快递 ' . $ship_data['express'] . '元';
                $this->data['ships'][$store_id]['options']['ems'] = 'EMS  ' . $ship_data['ems'] . '元';
                $this->data['ships'][$store_id]['options']['post'] = '平邮 ' . $ship_data['post'] . '元';
            }

            $this->data['amount'] = sprintf("%.2f", $amount);
            $this->data['items'] = $confirm_items;
        }

        $addresses = AddressBook::model()->findAll('user_id = :user_id', array(':user_id' => Yii::app()->user->getId()));
        $this->data['addresses'] = $addresses;
    }

    public function actionSave() {
      //  echo 1;exit;
        $orders = $this->insertOrder();
        if ($orders !== FALSE) {
            foreach ($orders as $order) {
                $id = $order->sn;
            }
            $this->request->redirect($this->createUrl('detail', array('sn' => $id)));
        }
        die;
    }

    function insertOrder() {
        $addr_id = $this->request->getPost('address');
        $items = $this->request->getPost('items');
        $memos = $this->request->getPost('memo');
        $ships = $this->request->getPost('ship');
    //  print_r($items);exit;
        $address = AddressBook::model()->findByPk($addr_id);

        $orders = array();
        $transaction = Yii::app()->db->beginTransaction();
        try {
            $cart = ShoppingCart::model()->findByAttributes(array('user_id' => Yii::app()->user->getId(), 'market_id' => $this->market->market_id));
            $cart->items = (array) json_decode($cart->items);

            $orderTime = time();
            foreach ($items as $store_id => $v) {
                $order = new Order();

                $order->user_id = Yii::app()->user->getId();
                $order->market_id = $this->market->market_id;
                $order->store_id = $store_id;
                $order->status = 1;
                $order->is_pay = 0;
                $order->ship_type = $ships[$store_id];
                $order->memo = $memos[$store_id];
                $order->created = $orderTime;

                $order->receiver_name = $address->name;
                $order->receiver_country = $address->country;
                $order->receiver_state = $address->state;
                $order->receiver_city = $address->city;
                $order->receiver_district = $address->district;
                $order->receiver_address = $address->area . ' ' . $address->address;
                $order->receiver_zip = $address->zipcode;
                $order->receiver_mobile = $address->mobile;
                $order->receiver_phone = $address->phone;

                $orderItems = array();
                $ship_type = $order->ship_type . '_fee';
                $ship_fee = 0;
                $amount = 0;
                $item_total = 0;
                foreach ($v as $sku_id => $quantity) {
                    //如果购物车里有该商品则提出来
                    //删除购物车的商品
                    if (isset($cart->items->$store_id->$sku_id)) {
                        //   echo 1;exit;
                        $cart_item = $cart->items->$store_id->$sku_id;
                        unset($cart->items->$store_id->$sku_id);
                    }

                    $price = 0;
                    if ($sku_id > 0) {
                        //echo 2;exit;
                        $sku = ItemSku::model()->findByPk($sku_id);
                        $item_id = $sku->item_id;
                        $sku->stock -= $quantity;
                        $sku->update();
                        $price = $sku->price;
                        $item = Item::model()->findByPk($item_id);
                    } else {
                        //  echo 3;exit;
                        $item_id = -$sku_id;
                        $item = Item::model()->findByPk($item_id);
                        $price = $item->price;
                    }
                    $ship_fee += ($item->$ship_type * $quantity);
                    $sub_total = $quantity * $price;
                    $item_total += $sub_total;
                    $orderItems[] = array(
                        'item_id' => $item_id,
                        'title' => $item->title,
                        'pic' => $item->pic_url,
                        'props_name' => $cart_item->props,
                        'price' => $price,
                        'ship_fee' => $item->$ship_type * $quantity,
                        'quantity' => $quantity,
                        'total' => $sub_total + ($item->$ship_type * $quantity),
                        'created' => time()
                    );
                    $item->num -= $quantity;
                    $item->update();


                    $counter = ItemCounter::model()->findByPk($item_id);
                    $counter->sale += $quantity;
                    $counter->save();
                }
                $order->item_total = $item_total;
                $order->ship_fee = $ship_fee;
                $order->amount = $item_total + $ship_fee;
                $order->OrderItem = $orderItems;
                $order->sn = '123';
                if ($order->save()) {
                    //     echo 4;exit;
                    $orders[] = $order;
                } else {
                    print_r($order->errors);
                    $transaction->rollback();
                }
            }
            //清空购物车
            if (isset($cart->items)) {
                unset($cart->items);
            }
            $cart->items = json_encode($cart->items);
            $cart->update();
            $transaction->commit();
            return $orders;
        } catch (Exception $e) {
            print_r($e);
            $transaction->rollback();
            return false;
        }
    }

    function buildItem() {
        $item_id = $this->request->getPost('item_id');
        $sku_id = $this->request->getPost('sku_id');
        $quantity = $this->request->getPost('quantity');
        $items = array();
        $item = Item::model()->findByPk($item_id);

        if ($sku_id > 0) {
            $sku = ItemSku::model()->findByPk($sku_id);
            $prop_imgs = json_decode($item->prop_imgs);

            $pic = $item->pic_url;
            preg_match_all('/(\d+):(\d+)/', $sku->props, $matches, PREG_SET_ORDER);
            foreach ($matches as $v) {
                if (isset($prop_imgs->$v[1]->$v[2])) {
                    $pic = $prop_imgs->$v[1]->$v[2];
                }
            }
            $quantity = ($quantity > $sku->stock ? $sku->stock : $quantity);
            $items[$item->store_id][$sku_id] = (object) array(
                        'item_id' => $item_id,
                        'sku_id' => $sku_id,
                        'price' => $sku->price,
                        'quantity' => $quantity,
                        'total' => sprintf("%.2f", $sku->price * $quantity),
                        'title' => $item->title,
                        'pic' => $pic,
                        'props' => $sku->props_name
            );

            $sub_total[$item->store_id] = sprintf("%.2f", $sku->price * $quantity);
        } else {
            $quantity = ($quantity > $item->num ? $item->num : $quantity);
            $items[$item->store_id][-$item_id] = (object) array(
                        'item_id' => $item_id,
                        'sku_id' => 0,
                        'price' => $item->price,
                        'quantity' => $quantity,
                        'total' => sprintf("%.2f", $item->price * $quantity),
                        'title' => $item->title,
                        'pic' => $item->pic_url,
                        'props' => ''
            );
            $sub_total[$item->store_id] = sprintf("%.2f", $item->price * $quantity);
        }

        $amount = $sub_total[$item->store_id] + $item->express_fee;

        $ships[$item->store_id]['data']['express'] = $item->express_fee;
        $ships[$item->store_id]['data']['ems'] = $item->ems_fee;
        $ships[$item->store_id]['data']['post'] = $item->post_fee;
        $ships[$item->store_id]['options']['express'] = '快递 ' . $item->express_fee . '元';
        $ships[$item->store_id]['options']['ems'] = 'EMS  ' . $item->ems_fee . '元';
        $ships[$item->store_id]['options']['post'] = '平邮 ' . $item->post_fee . '元';

        return array($items, $sub_total, $amount, $ships);
    }

}
