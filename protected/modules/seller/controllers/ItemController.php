<?php

class ItemController extends CurdController {

    public $title = '商品管理';
    public $model = 'Item';
    
    public function init()
    {
        parent::init();
    }

    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
    public function actionCreate()
    {
        $this->title = '发布新商品';
        $model = new Item();
        if (isset($_POST['Item']))
        {
            $this->handlePostData($_POST['Item']['cid']);
            $_POST['Item']['ItemCounter'][] = array();
            $model->attributes = $_POST['Item'];
            if ($model->save())
            {
                $this->redirect(array('update', 'id' => $model->item_id));
            }
            else
            {
                print_r($model->errors);
            }
        }
        else
        {
            $model->cid = $this->request->getQuery('cid');
            $this->template = 'form';
            $this->data['model'] = $model;

            $cats = ItemCats::model()->queryListData($this->store->cid);
            $this->data['cats'] = $cats;
            
            $this->data['shops'] = array();
        }
    }

    /**
     * Updates a particular model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id the ID of the model to be updated
     */
    public function actionUpdate($id)
    {
        $this->title = '商品修改';
        $this->template = 'form';

        $model = $this->loadModel($id);
        if (isset($_POST['Item']))
        {
            $this->handlePostData($_POST['Item']['cid']);
            
            $model->attributes = $_POST['Item'];
            
            ItemSpec::model()->deleteAll('item_id=:item_id', array(':item_id' => $id));
            if ($model->save())
            {
                $this->redirect(array('update', 'id' => $model->item_id));
            }
            else
            {
                print_r($model->errors);die;
            }
        }

        $cats = ItemCats::model()->queryListData($this->store->cid);
        $this->data['cats'] = $cats;
        $this->data['shops'] = array();
        $this->data['model'] = $model;
    }

    /**
     * Deletes a particular model.
     * If deletion is successful, the browser will be redirected to the 'admin' page.
     * @param integer $id the ID of the model to be deleted
     * @throws CHttpException
     */
    public function actionDelete($id)
    {
        if (Yii::app()->request->isPostRequest)
        {
            // we only allow deletion via POST request
            $model = $this->loadModel($id);
            $images = ItemImg::model()->findAllByAttributes(array('item_id' => $id));
            foreach ($images as $k => $v)
            {
                $img = $v['url'];
                // we only allow deletion via POST request
                ItemImg::model()->deleteAllByAttributes(array('item_id' => $id));
                @unlink(dirname(Yii::app()->basePath) . '/upload/item/image/' . $img);
            }
            $model->delete();

            // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
            if (!isset($_GET['ajax']))
                $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
        }
        else
            throw new CHttpException(400, 'Invalid request. Please do not repeat this request again.');
    }

    /**
     * Manages all models.
     */
    public function actionOnsale()
    {
        $this->template = 'onsale';
        $this->title = '在售商品';
        
        $page  = $this->request->getQuery('page', 1)-1;
        $limit = 10;
        $model = new Item('search');
        $criteria['condition'] = 'market_id=' . $this->store->market_id . ' AND store_id=' . Yii::app()->user->getId() . ' AND is_show=1';
        $criteria['limit'] = $limit;
        $criteria['offset'] = $page*$limit;
        $items = $model->findAll($criteria);
        
        $count = $model->count('market_id=' . $this->store->market_id . ' AND store_id=' . Yii::app()->user->getId() . ' AND is_show=1');
        
        $pages = new CPagination($count);
        $pages->setPageSize($limit);
        $pages->setCurrentPage($page);
        
        $this->data['model'] = $model;
        $this->data['items'] = $items;
        $this->data['pages'] = $pages;
    }

    /**
     * Manages all models.
     */
    public function actionStock()
    {
        $this->template = 'stock';
        $this->title = '下架的商品';

        $page  = $this->request->getQuery('page', 1)-1;
        $limit = 10;
        $model = new Item('search');
        $criteria['condition'] = 'market_id=' . $this->store->market_id . ' AND store_id=' . Yii::app()->user->getId() . ' AND is_show=0';
        $criteria['limit'] = $limit;
        $criteria['offset'] = $page*$limit;
        $items = $model->findAll($criteria);
        
        $count = $model->count('market_id=' . $this->store->market_id . ' AND store_id=' . Yii::app()->user->getId() . ' AND is_show=0');
        
        $pages = new CPagination($count);
        $pages->setPageSize($limit);
        $pages->setCurrentPage($page);
        
        $this->data['model'] = $model;
        $this->data['items'] = $items;
        $this->data['pages'] = $pages;
    }
//批量操作
    public function actionBulk()
    {
        $ids = $_POST['items_id'];
        $referer = $this->request->getPost('referer', 'onsale');

        $count = count($ids);
        if ($count == 0)
        {
            echo '<script>alert("请至少选择1个项目.")</script>';
            echo '<script type="text/javascript">setTimeout(\'location.href="' . Yii::app()->createUrl('/seller/item/onsale') . '"\',10);</script>';
            die;
        }
        elseif ($count > 0 && NULL == $_POST['act'])
        {
            echo '<script>alert("请选择操作类型.")</script>';
            echo '<script type="text/javascript">setTimeout(\'location.href="' . Yii::app()->createUrl('/seller/item/onsale') . '"\',10);</script>';
            die;
        }
        else
        {
            if ('is_show' == $_POST['act'])
            { //批量上架
                if ($count == 1)
                {
                    Item::model()->updateByPk($ids, array("is_show" => 1));
                    echo '<script type="text/javascript">setTimeout(\'location.href="' . Yii::app()->createUrl('/seller/item/' . $referer) . '"\',10);</script>';
                    die;
                }
                else
                {
                    $id = implode(',', $ids);
                    $criteria = new CDbCriteria(array(
                        'condition' => 'item_id in (' . $id . ')'
                    ));
                    Item::model()->updateAll(array("is_show" => 1), $criteria);
                    echo '<script type="text/javascript">setTimeout(\'location.href="' . Yii::app()->createUrl('/seller/item/' . $referer) . '"\',10);</script>';
                    die;
                }
            }
            elseif ('un_show' == $_POST['act'])
            { //批量下架
                if ($count == 1)
                {
                    Item::model()->updateByPk($ids, array("is_show" => 0));
                    echo '<script type="text/javascript">setTimeout(\'location.href="' . Yii::app()->createUrl('/seller/item/' . $referer) . '"\',10);</script>';
                    die;
                }
                else
                {
                    $id = implode(',', $ids);
                    $criteria = new CDbCriteria(array(
                        'condition' => 'item_id in (' . $id . ')'
                    ));
                    Item::model()->updateAll(array("is_show" => 0), $criteria);
                    echo '<script type="text/javascript">setTimeout(\'location.href="' . Yii::app()->createUrl('/seller/item/' . $referer) . '"\',10);</script>';
                    die;
                }
            }
            elseif ('delete' == $_POST['act'])
            { //批量删除
                if ($count == 1)
                {
                    $item = Item::model()->findByPk($ids);
                    $images = ItemImg::model()->findAllByAttributes(array('item_id' => $item->item_id));

                    foreach ($images as $k => $v)
                    {
                        $img = $v['url'];
                        // we only allow deletion via POST request
                        @unlink(dirname(Yii::app()->basePath) . '/upload/item/image/' . $img);
                    }

                    ItemImg::model()->deleteAllByAttributes(array('item_id' => $item->item_id));
                    Item::model()->deleteByPk($ids);
                    echo '<script>alert("删除成功.")</script>';
                    echo '<script type="text/javascript">setTimeout(\'location.href="' . Yii::app()->createUrl('/seller/item/' . $referer) . '"\',10);</script>';
                    die;
                }
                else
                {
                    $item = Item::model()->findAllByPk($ids);
                    foreach ($item as $i)
                    {
                        $images = ItemImg::model()->findAllByAttributes(array('item_id' => $i->item_id));
                        foreach ($images as $k => $v)
                        {
                            $img = $v['url'];                            
                            ItemImg::model()->deleteAllByAttributes(array('item_id' => $i->item_id));
                            @unlink(dirname(Yii::app()->basePath) . '/upload/item/image/' . $img);
                        }
                    }
                    Item::model()->deleteAllByAttributes(array('item_id' => $ids));
                    echo '<script>alert("删除成功.")</script>';
                    echo '<script type="text/javascript">setTimeout(\'location.href="' . Yii::app()->createUrl('/seller/item/' . $referer) . '"\',10);</script>';
                    die;
                }
            }
        }
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer the ID of the model to be loaded
     * @return CActiveRecord
     * @throws CHttpException
     */
    public function loadModel($id)
    {
        $model = Item::model()->with(array('ItemImgs' => array('order' => 'position ASC')))->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    public function actionGetItemSpec()
    {
        $skus = $_POST['Item']['skus'];
        foreach ($skus as $key => $value)
        {
            $sku[] = $_POST['Item']['skus'][$key];
        }
        $options = CJavaScript::encode($sku);

        echo json_encode($sku);
    }

    /**
     * format post props value
     */
    protected function handlePostData($cid)
    {
        $item_props = array();

        if (isset($_POST['ItemProp']) && is_array($_POST['ItemProp']))
        {
            $item_props = $_POST['ItemProp'];
            unset($_POST['ItemProp']);
        }
        
        $name = '';
        if (isset($_POST['shops']))
        {
            foreach ($_POST['shops'] as $shop_id)
            {
                $_POST['Item']['ItemShop'][] = array('shop_id' => $shop_id);
            }
            $count = count($_POST['shops']);
            if ($count == 1)
            {
                $shop = Shop::model()->findByPk($_POST['shops'][0]);
                $name = "【{$shop->name}店】";
            }
            else
            {
                $name = "【{$count}店通用】";
            }
        }
        $_POST['Item']['name'] = $name.$this->store->name;
        
        //处理属性数据
        list($_POST['Item']['props'], $_POST['Item']['ItemSpec']) = $this->handleItemProps($item_props, $cid);
        
        if (isset($_POST['ItemImg']['url']) && isset($_POST['ItemImg']['item_img_id']) && is_array($_POST['ItemImg']['url']) && is_array($_POST['ItemImg']['item_img_id']))
        {
            $pics = $_POST['ItemImg']['url'];
            $ids = $_POST['ItemImg']['item_img_id'];
            if ($count = count($pics) === count($ids))
            {
                $itemImgs = array();
                for ($i = 0, $count = count($pics); $i < $count; $i++)
                {
                    $itemImgs[] = array(
                        'item_img_id' => $ids[$i],
                        'url' => $pics[$i],
                        'position' => $i,
                    );
                }
                unset($_POST['ItemImg']);
                $_POST['Item']['ItemImgs'] = $itemImgs;
                $_POST['Item']['pic_url'] = $itemImgs[0]['url'];
            }
        }
        
        if (isset($_POST['expirytype']))
        {
            switch ($_POST['expirytype'])
            {
                case '1':
                    $_POST['Item']['expiry_date'] = $_POST['expirydate_start'] . '-' . $_POST['expirydate_end'];
                    break;
                case '2':
                    $_POST['Item']['expiry_date'] = $_POST['expirydate'];
                    break;
                case '3':
                    $_POST['Item']['expiry_date'] = $_POST['expiryday'];
                    break;
            }
            $_POST['Item']['locality_life'] = 1;
        }
        
        
        $_POST['Item']['market_id'] = $this->store->market_id;
        $_POST['Item']['store_id'] = Yii::app()->user->getId();        
    }

    /**
     * format item prop data to json format from post
     * @param $item_props
     * @return array
     */
    protected function handleItemProps($item_props, $cid)
    {
        $props = array();
        $spec = array();
        
        foreach ($item_props as $pid => $vid)
        {
            $itemProp = ItemProp::model()->findByAttributes(array('pid' => $pid, 'cid' => $cid));
            
            $props[$pid] = array('pid' => $pid, 'name' => $itemProp->name);
            if (is_array($vid))
            {
                foreach ($vid as $v)
                {
                    $propValue = ItemPropValue::model()->findByAttributes(array('vid' => $v, 'pid' => $pid, 'cid' => $cid));
                    
                    if ($propValue !== NULL)
                    {
                        $props[$pid]['values'][$v] = $propValue->name;
                        if ($itemProp->is_key_prop == 1)
                        {
                            $spec[] = array('cid' => $cid, 'pid' => $pid, 'vid' => $v, 'pname' => $itemProp->name, 'vname' => $propValue->name, 'input' => '');
                        }
                    }
                }
            }
            else
            {
                $propValue = ItemPropValue::model()->findByAttributes(array('vid' => $vid, 'pid' => $pid, 'cid' => $cid));

                if ( ! $propValue)
                {
                    if ($itemProp->is_input_prop == 1)
                    {
                        $props[$pid]['values'][] = $vid;
                    }
                }
                else
                {
                    $props[$pid]['values'][$vid] = $propValue->name;
                    if ($itemProp->is_key_prop == 1)
                    {
                        $spec[] = array('cid' => $cid, 'pid' => $pid, 'vid' => $vid, 'pname' => $itemProp->name, 'vname' => $propValue->name);
                    }
                }
            }
        }
        return array(json_encode($props), $spec);
    }

    public function actionItemProps()
    {
        $cid = $this->request->getQuery('cid');
        $itemId = $this->request->getQuery('item_id');
        $condition = array('condition' => "t.cid = {$cid} AND t.parent_pid=0", 'order' => 't.sort_order asc');
        $props = ItemProp::model()->findAll($condition);
        $base_props = array();
        $sale_props = array();
        foreach ($props as $v)
        {
            $condition = array('condition' => "cid = {$cid} AND pid={$v->pid}", 'order' => 'sort_order asc');
            $v->itemPropValues = ItemPropValue::model()->findAll($condition);
            if ($v->is_sale_prop == 0)
                $base_props[] = $v;
            else
                $sale_props[] = $v;
        }
        
        $item = Item::model()->findByPk($itemId);
        $data['item'] = $item;
        $data['base_props'] = $base_props;
        $data['sale_props'] = $sale_props;
        $this->renderPartial('_form_prop', $data, false, true);
    }
    public function actionGetShops()
    {
        $parentId = $this->request->getQuery('parent_id', 0);
        $itemId   = $this->request->getQuery('item_id', 0);
        
        $item  = $this->data['model']->findByPk($itemId);
        if (!$item) $item = $this->data['model'];
        
        $codition = 'store_id='.$this->store->store_id;
        $models = Shop::model()->findAll(array('condition' => $codition, 'order' => 'name asc'));
        
        $itemShops = $item->ItemShop;
        $shops = array();
        foreach ($itemShops as $v)
        {
            $shops[] = $v->shop_id;
        }
        echo CHtml::checkBoxList('shops', $shops, CHtml::listData($models, 'id', 'name'), array('separator' => '', 'template' => '<span class="col-md-3">{input} {label}</span>'));

        die;
    }
}
