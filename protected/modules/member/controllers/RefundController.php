<?php

class RefundController extends MemberController {

    public $title = '退款管理';
    /**
     * Displays a particular model.
     * @param integer $id the ID of the model to be displayed
     */
    public function actionDetail()
    {
        $this->template = 'detail';

        $refund_sn = $this->request->getQuery('sn');
        $status = (int) $this->request->getQuery('status');
        

        $model = new Refund();
        $model = $model->find('user_id=:user_id AND refund_sn=:refund_sn', array(':user_id' => Yii::app()->user->getId(), ':refund_sn' => $refund_sn));
        $order = Order::model()->findByPk($model->order_id);

        if ($status && ($status == 1 || $status == 4 || $status == 5))
        {
            if ($status == 5)
            {
                $order->status = 2;
                $order->refund_status = 0;
                $order->updated = time();
                $order->update();
            }
            $model->status = $status;
            if ($model->update())
            {
                $this->redirect($this->createUrl('detail', array('sn' => $refund_sn)));
            }
        }
        
        $this->data['order'] = $order;
        $this->data['model'] = $model;
    }

    /**
     * 整单退款
     */
    public function actionOrder()
    {
        $this->template = 'order';

        $sn = $this->request->getParam('sn');
        $order = Order::model()->findByAttributes(array('sn' => $sn));
        if ($order && $order->is_pay == 1 && $order->status == 2)
        {
            if (isset($_POST['sn']))
            {
                $type = $this->request->getPost('type');
                $desc = $this->request->getPost('desc');
                
                $model = new Refund();
                
                $model->refund_sn = date('Ymd').substr(time(),-5).sprintf('%02d',rand(0,99));
                $model->order_sn  = $sn;
                $model->type      = $type;
                $model->order_id  = $order->order_id;
                $model->order_item_id = 0;
                $model->quantity = 0;
                $model->money    = $order->amount;
                $model->desc     = $desc;
                $model->store_id = $order->store_id;
                $model->user_id  = Yii::app()->user->getId();
                $model->status   = 1;
                $model->created  = time();
                
                $order->status = 6;
                $order->refund_status = 1;
                $order->updated = time();
                if ($model->save() && $order->update())
                {
                    $this->redirect($this->createUrl('detail', array('sn' => $model->refund_sn)));
                }

            }
            $this->data['order'] = $order;
        }
        else
        {
            parent::renderError('错误打开', '订单不存在，或该订单不可以申请退款');
        }
    }
    
    /**
     * Manages all models.
     */
    public function actionList()
    {
        $this->template = 'list';

        $filter = $this->request->getQuery('filter');

        $criteria = new CDbCriteria;

        $criteria->addCondition('user_id = ' . Yii::app()->user->getId());

        if ($filter)
        {
            if ($filter['buyer'] != '')
            {
                $user = User::model()->find("username like :username", array(':username' => $filter['buyer'] . '%'));
                if ($user)
                    $criteria->addCondition('user_id = ' . $user->id);
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
                $criteria->addCondition('order_sn like ' . $filter['orderSn']);
            }
            if ($filter['refundSn'] != '')
            {
                $criteria->addCondition('refund_sn like ' . $filter['refundSn']);
            }
            if ($filter['orderStatus'] > 0)
            {
                $criteria->addCondition('status =' . (int) $filter['orderStatus']);
            }
        }
        $criteria->order = 'refund_id desc';
        $model = new Refund('search');

        $count = $model->count($criteria);
        $pages = new CPagination($count);
        $pages->pageSize = 10;
        $pages->applyLimit($criteria);

        $data = $model->findAll($criteria);

        $this->data['model'] = $model;
        $this->data['filter'] = $filter;
        $this->data['refunds'] = $data;
        $this->data['pages'] = $pages;
    }

}
