<?php

class OrdersController extends MemberController {

    public $title = '交易管理';
    
    public function init()
    {
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

    /**
     * Lists all models.
     */
    public function actionIndex()
    {
        $this->actionList();
    }

    /**
     * Lists all models.
     */
    public function actionList()
    {
        $this->template = 'list';

        $filter = $this->request->getQuery('filter');

        $criteria = new CDbCriteria;

        $criteria->addCondition('t.market_id = ' . $this->market->getPrimaryKey());
        $criteria->addCondition('user_id = '.Yii::app()->user->getId());
        $criteria->addCondition('user_del = 0');

        if ($filter)
        {
            if ($filter['item'] != '')
            {
                $criteria->join = 'LEFT JOIN order_item ON order_item.order_id = t.order_id ';
                $criteria->addCondition("order_item.title like '%" . $filter['item'] . "%'");
                $criteria->group = 't.order_id';
            }
            if ($filter['startTime'] != '')
            {
                $criteria->addCondition('created >= ' . strtotime($filter['startTime']));
            }
            if ($filter['endTime'] != '')
            {
                $criteria->addCondition('created <= ' . strtotime($filter['endTime']));
            }
            if ($filter['orderSn'] != '')
            {
                $criteria->addCondition('sn like ' . $filter['orderSn']);
            }
            if ($filter['orderStatus'] > 0)
            {
                $criteria->addCondition('status =' . (int) $filter['orderStatus']);
            }
            if ($filter['commentStatus'] != '')
            {
                $criteria->addCondition('comment_status = ' . (int) $filter['commentStatus']);
            }
        }
        $criteria->order = 'order_id desc';
        $model = new Order('search');

        $count = $model->count($criteria);
        $pages = new CPagination($count);
        $pages->pageSize = 10;
        $pages->applyLimit($criteria);

        $orders = $model->findAll($criteria);

        $this->data['filter'] = $filter;
        $this->data['orders'] = $orders;
        $this->data['pages'] = $pages;
    }

    /**
     * Lists all models.
     */
    public function actionListRefund()
    {
        $this->template = 'listRefund';
        $model = new Order('search');

        $orders = $model->findAll('store_id=:store_id AND is_pay=1 AND status = 6', array(':store_id' => Yii::app()->user->getId()));

        $this->data['orders'] = $orders;
    }

    /**
     * Displays a particular model.
     * @param integer $id the ID of the model to be displayed
     */
    public function actionDetail()
    {
        $sn = $this->request->getQuery('sn');
        $order = Order::model()->findByAttributes(array('sn' => $sn, 'user_id' => Yii::app()->user->getId()));
        
        if ($order)
        {
            $orderShip = OrderShip::model()->findByAttributes(array('order_id' => $order->order_id));
            $this->data['orderShip'] = $orderShip;
            $this->data['order'] = $order;
            $this->template = 'detail';
        }
        else
        {
            parent::renderError('订单不存在', '');
        }
    }

    /**
     * Deletes a particular model.
     * If deletion is successful, the browser will be redirected to the 'admin' page.
     * @param integer $id the ID of the model to be deleted
     */
    public function actionRemove($sn)
    {
        $sn = $this->request->getQuery('sn');
        $order = Order::model()->findByAttributes(array('sn' => $sn, 'user_id' => Yii::app()->user->getId()));
        if ($order)
        {
            $order->user_del = 1;
            $order->update();
        }
        $this->request->redirect($this->createUrl('index'));
    }

    /**
     * Deletes a particular model.
     * If deletion is successful, the browser will be redirected to the 'admin' page.
     * @param integer $id the ID of the model to be deleted
     */
    public function actionDelete($id)
    {
        $sn = $this->request->getQuery('sn');
        $order = Order::model()->findByAttributes(array('sn' => $sn, 'user_id' => Yii::app()->user->getId()));
        if ($order)
        {
            $order->user_del = 1;
            $order->update();
        }
        $this->request->redirect($this->createUrl('index'));
    }

    
    public function actionPay()
    {
        $sn = $this->request->getQuery('sn');
        $order = Order::model()->findByAttributes(array('sn' => $sn, 'user_id' => Yii::app()->user->getId()));
        
        if ($order && $order->is_pay == 0)
        {
            $items = $order->OrderItem;
            $ext = count($items) > 1 ? '...等多件' : '';
            $arr = array(
                'seller'      => (int)    $order->store_id, //商家帐户
                'outer_sn'    => (string) $order->sn, //订单号
                'title'	      => (string) $items[0]['title'] . $ext, //订单说明/标题
                'total'       => (float)  $order->amount, //支付总额
                'item_total'  => (float)  $order->item_total, //商品总额
                'express_fee' => (string) $order->ship_fee,
                'address'     => (string) $order->receiver_address,
                'order_time'  => (int)    $order->created,
                'order_url'   => (string) Yii::app()->createAbsoluteUrl('member/order/detail', array('sn' => $order->sn)),
            );
            Yii::app()->CGB->setOrder($arr);
            Yii::app()->CGB->setMarket($this->market);
            Yii::app()->CGB->checkout();
        }
        die;
    }
    
    public function actionConfirm()
    {
        $sn = $this->request->getQuery('sn');
        $order = Order::model()->findByAttributes(array('sn' => $sn, 'user_id' => Yii::app()->user->getId()));
        
        if ($order && $order->is_pay == 1)
        {
            Yii::app()->CGB->confirm($order->sn, $order->pay_sn);
        }
        else
        {
            die('非法打开！');
        }
    }
}
