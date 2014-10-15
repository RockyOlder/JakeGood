<?php

/**
 * 
 *
 */
class SiteController extends BaseController
{
    
    /**
     * 转前台登录
     */
    public function actionIndex()
    {
        $this->layout = FALSE;
        $this->template = '/index';
        
        $item = new ItemSearch();
        
        //手机
        $cid = 1512;
        $params  = array('cid' => $cid, 'page' => $page, 'limit' => 8); //商品检索参数        
        //类目
        $cat = ItemCats::model()->findByPk($cid);
        $this->data['sub_cats'] = ItemCats::model()->findAll('parent_cid='.$cid.' AND status=1');
        //商品检索
        list($items[], $counts[]) = $item->search($params);
        
        //KTV
        $cid = 50019081;
        $params  = array('cid' => $cid, 'page' => $page, 'limit' => 8); //商品检索参数        
        //类目
        $cat = ItemCats::model()->findByPk($cid);
        $this->data['sub_cats'] = ItemCats::model()->findAll('parent_cid='.$cid.' AND status=1');        
        //商品检索
        list($items[], $count[]) = $item->search($params);
        
        //电影
        $cid = 50019077;
        $params  = array('cid' => $cid, 'page' => $page, 'limit' => 8); //商品检索参数        
        //类目
        $cat = ItemCats::model()->findByPk($cid);
        $this->data['sub_cats'] = ItemCats::model()->findAll('parent_cid='.$cid.' AND status=1');        
        //商品检索
        list($items[], $count[]) = $item->search($params);
        
        $this->data['items'] = $items;
        $this->data['counts'] = $count;        
    }

    
    public function actionActivity()
    {
        $data = array();
        if ( ! Yii::app()->user->getIsGuest())
        {
            $data['logged'] = 1;
            $data['username'] = Yii::app()->user->getName();
            $data['userinfo'] = $this->renderPartial("/widget/userinfo", NULL, TRUE);
        }
        
        $cart = ShoppingCart::model()->findByAttributes(array('user_id' => Yii::app()->user->getId(), 'market_id' => $this->market->market_id));
        $items = (array) json_decode($cart->items);
        $data['cart']['count'] = 0;
        
        $data_items = array();
        foreach ($items as $v)
        {
            $data['cart']['count'] += count((array)$v);
            if (count($data_items) < 5)
            {
                foreach ($v as $item)
                {
                    if (count($data_items) < 5) $data_items[] = $item;
                }
            }
        }
        //print_r($data_items);die;
        $data['cart']['items'] = $this->renderPartial("/widget/cart_items", array('items' => $data_items), TRUE);
        die(json_encode($data));
    }
}
