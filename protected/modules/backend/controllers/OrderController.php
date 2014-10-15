<?php

class OrderController extends SellerController {

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
            if ($filter['item'] != '')
            {
                $criteria->join = 'LEFT JOIN order_item ON order_item.order_id = t.order_id ';
                $criteria->addCondition("order_item.title like '%" . $filter['item'] . "%'");
                $criteria->group = 't.order_id';
            }
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
    public function actionListShip()
    {
        $this->template = 'listShip';
        $this->title = '发货';
        $model = new Order('search');


        $filter = $this->request->getQuery('filter');

        $criteria = new CDbCriteria;

        $criteria->addCondition('store_id=:store_id AND is_pay=1 AND status = 3');
        $criteria->params = array(':store_id' => Yii::app()->user->getId());
        if ($filter)
        {
            if ($filter['receiverName'] != '')
            {
                $criteria->addCondition("receiver_name like '" . $filter['receiverName'] . "'");
            }
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
        }

        $model = new Order('search');
        $model->setDbCriteria($criteria);

        $orders = $model->findAll();

        $this->data['filter'] = $filter;
        $this->data['orders'] = $orders;
    }

    /**
     * Lists all models.
     */
    public function actionListNew()
    {
        $this->template = 'listNew';
        $this->title = '发货';
        $model = new Order('search');


        $filter = $this->request->getQuery('filter');

        $criteria = new CDbCriteria;

        $criteria->addCondition('store_id=:store_id AND is_pay=1 AND status = 2');
        $criteria->params = array(':store_id' => Yii::app()->user->getId());
        if ($filter)
        {
            if ($filter['receiverName'] != '')
            {
                $criteria->addCondition("receiver_name like '" . $filter['receiverName'] . "'");
            }
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
        }

        $model = new Order('search');
        $model->setDbCriteria($criteria);

        $orders = $model->findAll();

        $this->data['filter'] = $filter;
        $this->data['orders'] = $orders;
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

    /**
     * Invoice
     */
    public function actionInvoice()
    {
        $this->layout = false;
        $this->template = 'invoice';
        $sn = $this->request->getQuery('sn');
        $order = Order::model()->findByAttributes(array('sn' => $sn));
        
        $orderShip = OrderShip::model()->findByAttributes(array('order_id' => $order->order_id));
        $this->data['orderShip'] = $orderShip;
        $this->data['order'] = $order;
    }

    /**
     * Updates a particular model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id the ID of the model to be updated
     */
    public function actionUpdate($id)
    {
        $model = $this->loadModel($id);

        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        if (isset($_POST['Order']))
        {
            $model->attributes = $_POST['Order'];
            $model->total_fee = $model->ship_fee + $model->pay_fee;
            $model->updated = time();

            if ($model->save())
                $this->redirect(array('view', 'id' => $model->order_id));
        }

        $this->render('update', array(
            'model' => $model,
        ));
    }

    /**
     * Deletes a particular model.
     * If deletion is successful, the browser will be redirected to the 'admin' page.
     * @param integer $id the ID of the model to be deleted
     */
    public function actionDelete($id)
    {
        if (Yii::app()->request->isPostRequest)
        {
            // we only allow deletion via POST request
            $this->loadModel($id)->delete();

            // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
            if (!isset($_GET['ajax']))
                $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
        }
        else
            throw new CHttpException(400, 'Invalid request. Please do not repeat this request again.');
    }

    public function actionShipping()
    {
        $this->template = 'shipping';
        $this->title = '发货';
        
        $sn = $this->request->getQuery('sn');
        $order = Order::model()->find('sn=:sn AND status = 2 AND store_id = :user_id', array(':sn' => $sn, ':user_id' => Yii::app()->user->getId()));

        if (!$order)
        {
            throw new CHttpException('', '该订单不用发货！');
        }
        else
        {
            //地址薄
            $addresses = AddressBook::model()->findAll('user_id = :user_id', array(':user_id' => Yii::app()->user->getId()));
            $this->data['addresses'] = $addresses;
            $this->data['model'] = new AddressBook();
            
            //快递
            $shipTypes = ShippingType::model()->findAll();
            $this->data['shippingTypes'] = CHtml::listData($shipTypes, 'code', 'name');
            $this->data['shippingTypes'][''] = '其它';

            //订单
            $this->data['order'] = $order;
            $addrData = $this->request->getPost('AddressBook');
            $receiver = $this->request->getPost('receiver');
            $shipData = $this->request->getPost('OrderShip');

            //处理POST 提交
            if ($shipData['sn'] != '')
            {
                $orderShip = new OrderShip('create');

                $area = Area::model()->findAllByAttributes(array('area_id' => array($addrData['state'], $addrData['city'], $addrData['district'])));
                $area = CHtml::listData($area, 'area_id', 'name');

                $address = $addrData['name'] . ', ' . implode('', $area) . ' ' . $addrData['address'] . ', ' . $addrData['phone'];
                $attrs = array(
                    'order_id' => $order->order_id,
                    'ship_sn' => $shipData['sn'],
                    'type' => $this->data['shippingTypes'][$shipData['type']],
                    'type_code' => $shipData['type_code'],
                    'status' => 1,
                    'shipping_address' => $address,
                    'receiver_address' => $receiver['name'].', '.$receiver['address']. ', '.$receiver['phone'],
                    'created' => time(),
                    'updated' => time(),
                );
                $orderShip->_attributes = $attrs;
                if ($orderShip->save())
                {
                    $order->status = 3;
                    $order->update();
                    $this->redirect($this->createUrl('order/detail', array('sn' => $sn)));
                }
                else
                {
                    throw new CHttpException('', '系统错误，发货失败');
                }
            }
        }
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer the ID of the model to be loaded
     */
    public function loadModel($id)
    {
        $model = Order::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param CModel the model to be validated
     */
    protected function performAjaxValidation($model)
    {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'order-form')
        {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

}
