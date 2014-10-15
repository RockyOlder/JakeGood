<?php

class RateController extends MemberController {

    public $title = '评价';
    
    public function init()
    {
        parent::init();
    }

    public function actionIndex()
    {
        $this->template = 'index';

        $criteria = new CDbCriteria;
        $criteria->addCondition('user_id=' . Yii::app()->user->getId());
        $criteria->order = 'id desc';

        $count = ItemRate::model()->count($criteria);
        $pages = new CPagination($count);
        $pages->pageSize = 10;
        $pages->applyLimit($criteria);

        $rates = ItemRate::model()->findAll($criteria);
        
        $this->data['rates'] = $rates;
        $this->data['pages'] = $pages;
    }

    public function actionNew()
    {
        $this->template = 'new';

        $filter = $this->request->getQuery('filter');

        $criteria = new CDbCriteria;

        $criteria->addCondition('t.market_id = ' . $this->market->getPrimaryKey());
        $criteria->addCondition('user_id = '.Yii::app()->user->getId());
        $criteria->addCondition('user_del = 0');
        $criteria->addCondition('status = 4');
        $criteria->addCondition('comment_status = 0');
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

    public function actionAdd()
    {
        $this->template = 'add';

        $sn = $this->request->getQuery('sn');
        $order = Order::model()->findByAttributes(array('sn' => $sn, 'status' => 4, 'comment_status' => 0, 'user_id' => Yii::app()->user->getId()));
        
        if ($order)
        {
            $this->data['order'] = $order;
        }
        else
        {
            parent::renderError('该订单现在不允许评价', '');
        }
    }

    public function actionSave()
    {
        $data  = $this->request->getPost('data');
        $sn    = $this->request->getPost('sn');
        $order = Order::model()->findByAttributes(array('sn' => $sn, 'status' => 4, 'comment_status' => 0, 'user_id' => Yii::app()->user->getId()));
        if (!$order)
        {
            parent::renderError('该订单现在不允许评价', '');
        }
        
        $items = $order->OrderItem;
        
        foreach ($items as $item)
        {
            if (isset($data[$item->getPrimaryKey()]))
            {
                $star    = $data[$item->getPrimaryKey()]['star'];
                $content = $data[$item->getPrimaryKey()]['content'];
                $model = new ItemRate();
                $model->order_item_id    = $item->order_item_id;
                $model->order_id   = $order->getPrimaryKey();
                $model->item_id    = $item->item_id;
                $model->user_id    = Yii::app()->user->getId();
                $model->store_id   = $order->store_id;
                $model->item_title = $item->title;
                $model->item_price = $item->price;
                $model->item_props = $item->props_name;
                $model->star       = $star;
                $model->content    = $content;
                $model->created    = time();
                $model->save();
                
                $counter = ItemCounter::model()->findByPk($item->item_id);
                if ($star > 3)
                {
                    $counter->rating += 1;
                    $counter->save();
                }
                $store   = StoreRate::model()->findByPk($order->store_id);
                if ($star > 0 and $star < 6)
                {
                    $col = 'star'.$star;
                    $store->$col += 1;
                    $store->count += 1;
                    $store->save();
                }
            }
        }
        $order->comment_status = 1;
        $order->save();
        $this->request->redirect('/member/rate/suc?sn='.$sn);
    }
    
    public function actionSuc()
    {
        $sn    = $this->request->getQuery('sn');
        parent::renderMessage('评价完成', '订单：'.$sn.' 评价完成 ', $this->createUrl('new'));
    }
}
