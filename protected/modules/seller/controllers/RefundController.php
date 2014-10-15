<?php

class RefundController extends SellerController {

    public $title = '退款管理';
    /**
     * Displays a particular model.
     * @param integer $id the ID of the model to be displayed
     */
    public function actionDetail()
    {
        $this->template = 'detail';

        $refund_sn = $this->request->getQuery('sn');
        $order_sn  = $this->request->getQuery('order_sn');
        $status = $this->request->getQuery('status');

        $model = new Refund();
        if ($refund_sn)
        {
            $model = $model->find('store_id=:store_id AND refund_sn=:refund_sn', array(':store_id' => Yii::app()->user->getId(), ':refund_sn' => $refund_sn));
        }
        elseif ($order_sn)
        {
            $model = $model->find('store_id=:store_id AND order_sn=:order_sn', array(':store_id' => Yii::app()->user->getId(), ':order_sn' => $order_sn));
        }

        $this->data['model'] = $model;
    }
    
    /**
     * Displays a particular model.
     * @param integer $id the ID of the model to be displayed
     */
    public function actionUpdate()
    {
        $refund_sn = $this->request->getQuery('sn');
        $status = $this->request->getQuery('status');

        $model = new Refund();
        $model = $model->find('store_id=:store_id AND refund_sn=:refund_sn', array(':store_id' => Yii::app()->user->getId(), ':refund_sn' => $refund_sn));

        if ($status && $status == 6)
        {
            $order = Order::model()->findByPk($model->order_id);
            Yii::app()->CGB->refund($order->sn, $order->pay_sn);
            return TRUE;
        }
        elseif ($status && $status > 1 && $status < 7)
        {
            $model->status = $status;
            if ($model->save())
            {
                $this->redirect($this->createUrl('detail', array('sn' => $refund_sn)));
            }
        }
        else
        {
            $this->redirect($this->createUrl('detail', array('sn' => $refund_sn)));
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

        $criteria->addCondition('store_id = ' . Yii::app()->user->getId());

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
