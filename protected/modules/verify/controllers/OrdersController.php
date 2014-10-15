<?php

class OrdersController extends VerifyController {

    public $title = '交易管理';
    
    public function init()
    {
        parent::init();
        $this->data['statusOptions'] = Order::statusOptions();
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

        $criteria->addCondition('t.store_id = ' . Yii::app()->user->getId());

        if ($filter)
        {
            /*
            if ($filter['item'] != '')
            {
                $criteria->join = 'LEFT JOIN order_item ON order_item.order_id = t.order_id ';
                $criteria->addCondition("order_item.title like '%" . $filter['item'] . "%'");
                $criteria->group = 't.order_id';
            }
             * 
             */
            if ($filter['buyer'] != '')
            {
                $user = User::model()->find("username like :username", array(':username' => $filter['buyer'] . '%'));
                if ($user)
                    $criteria->addCondition('user_id = ' . $user->user_id);
                else
                    $criteria->addCondition('user_id = -1');
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
    public function actionVerify()
    {
        $this->template = 'verify';
        $this->title = '验证结果';

        $code = $this->request->getQuery('code');
        $code = str_replace(' ', '', $code);
        $model = OrderCode::model()->findByAttributes(array('store_id' => $this->store->getPrimaryKey(), 'code' => $code));
        
        if ($model)
        {
            if ($model->status == 1)
            {
                $mess .= '消费时间: '. date('Y-m-d H:i:s', $model->check_time) .'<br />';
                $mess .= '消费店址: '. $model->Shop->address;
                return parent::renderError('该验证码已经消费过', $mess);
            }
            $order = $model->Order;
            $item  = OrderItem::model()->findByAttributes(array('order_id' => $model->order_id, 'item_id' => $model->item_id));
        }
        else
        {
            return parent::renderError('订单不存在', '验证码错误，找不到相关的订单');
        }
        $this->data['order'] = $order;
        $this->data['item']  = $item;
        $this->data['model'] = $model;
    }

    /**
     * Lists all models.
     */
    public function actionConfirm()
    {
        $code = $this->request->getQuery('code');
        $code = str_replace(' ', '', $code);
        $model = OrderCode::model()->findByAttributes(array('store_id' => $this->store->getPrimaryKey(), 'code' => $code));
        
        if ($model)
        {
            $model->status  = 1;
            $model->shop_id = 1;
            $model->check_time = time();
            $model->update();
            
            $order = $model->Order;
            $order->status = 4;
            $order->update();
            $this->request->redirect($this->createUrl('detail', array('sn' => $order->sn, 'suc' => 'true')));
        }
        else
        {
            return parent::renderError('订单不存在', '验证码错误，找不到相关的订单');
        }
    }

    /**
     * 
     * @param integer $id the ID of the model to be displayed
     */
    public function actionDetail()
    {
        $this->template = 'detail';
        $this->title = '订单查看';
        $sn = $this->request->getQuery('sn');
        $order = Order::model()->findByAttributes(array('sn' => $sn));
       
        $orderShip = OrderShip::model()->findByAttributes(array('order_id' => $order->order_id));
        $this->data['orderShip'] = $orderShip;
        $this->data['order'] = $order;
    }

}
