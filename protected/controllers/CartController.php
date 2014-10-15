<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of CartController
 *
 * @author Fighter
 */
class CartController extends BaseController {

    function init()
    {
        parent::init();
    }

    public function actionIndex()
    {
     //   echo 2;exit;
        $this->must_login = TRUE;
        $this->template = '/cart';

        $cart = ShoppingCart::model()->findByAttributes(array('user_id' => Yii::app()->user->getId(), 'market_id' => $this->market->market_id));

        $items = (array) json_decode($cart->items);

        $this->data['hidden_nav'] = true;
        $this->data['items'] = $items;
        //  print_r($this->data);exit;
    }

    public function actionAdd()
    {
        if (Yii::app()->user->getIsGuest())
        {
            die(json_encode(array('ret' => 3001, 'msg' => 'fail')));
        }

        $item_id = $this->request->getQuery('item_id');
        $sku_id = $this->request->getQuery('sku_id');
        $quantity = $this->request->getQuery('quantity');
        $item = Item::model()->findByPk($item_id);
        $cart = ShoppingCart::model()->findByAttributes(array('user_id' => Yii::app()->user->getId(), 'market_id' => $this->market->market_id));
        if (!$cart)
        {
            $cart = new ShoppingCart ();
            $cart->user_id = Yii::app()->user->getId();
            $cart->market_id = $this->market->market_id;
        }

        $items = json_decode($cart->items, TRUE);

        if ($sku_id > 0)
        {
            $sku = ItemSku::model()->findByPk($sku_id);
            $prop_imgs = json_decode($item->prop_imgs);
            if (!isset($items[$item->store_id][$sku_id]))
            {
                $pic = $item->pic_url;
                preg_match_all('/(\d+):(\d+)/', $sku->props, $matches, PREG_SET_ORDER);
                foreach ($matches as $v)
                {
                    if (isset($prop_imgs->$v[1]->$v[2]))
                    {
                        $pic = $prop_imgs->$v[1]->$v[2];
                    }
                }
                $items[$item->store_id][$sku_id] = array(
                    'item_id' => $item_id,
                    'sku_id' => $sku_id,
                    'price' => $sku->price,
                    'quantity' => ($quantity > $sku->stock ? $sku->stock : $quantity),
                    'title' => $item->title,
                    'pic' => $pic,
                    'props' => $sku->props_name
                );
            }
            else
            {
                $items[$item->store_id][$sku_id]['quantity'] += $quantity;
            }
        }
        else
        {
            if (!isset($items[$item->store_id][-$item_id]))
            {
                $items[$item->store_id][-$item_id] = array(
                    'item_id' => $item_id,
                    'sku_id' => 0,
                    'price' => $item->price,
                    'quantity' => ($quantity > $item->num ? $item->num : $quantity),
                    'title' => $item->title,
                    'pic' => $item->pic_url,
                    'props' => ''
                );
            }
            else
            {
                $items[$item->store_id][-$item_id]['quantity'] += $quantity;
            }
        }
        $count = 0;
        $data_items = array();
        foreach ($items as $v)
        {
            $count += count($v);
            if (count($data_items) < 5)
            {
                foreach ($v as $item)
                {
                    $item['store_id'] = $store_id;
                    if (count($data_items) < 5)
                        $data_items[] = (object) $item;
                }
            }
        }
        $cart_items = $this->renderPartial("/widget/cart_items", array('items' => $data_items), TRUE);

        $cart->items = json_encode($items);
        $cart->updated = time();
        if ($count > 50)
        {
            die(json_encode(array('ret' => 2, 'msg' => '购物车已满，请结算或删除一些商品后继续添加', 'count' => $count, 'cart' => $cart)));
        }
        if (!$cart->save())
        {
            die(json_encode(array('ret' => 1, 'msg' => 'fail', 'count' => $count, 'items' => $cart_items)));
        }
        else
        {
            die(json_encode(array('ret' => 0, 'msg' => 'ok', 'count' => $count, 'items' => $cart_items)));
        }
    }

    public function actionUpdate()
    {
        $store_id = $this->request->getQuery('store_id');
        $sku_id = $this->request->getQuery('sku_id');
        $quantity = $this->request->getQuery('quantity');
        $cart = ShoppingCart::model()->findByAttributes(array('user_id' => Yii::app()->user->getId(), 'market_id' => $this->market->market_id));

        $items = json_decode($cart->items);
        $stock_over = false;
        if (isset($items->$store_id->$sku_id))
        {
            if ($sku_id > 0)
            {
                $sku = ItemSku::model()->findByPk($sku_id);

                if ($quantity > $sku->stock)
                {
                    $quantity = $sku->stock;
                    $stock_over = true;
                }
            }
            $items->$store_id->$sku_id->quantity = $quantity;
            $cart->items = json_encode($items);
            $cart->updated = time();

            if (!$cart->save())
            {
                die(json_encode(array('ret' => 1, 'msg' => 'fail', 'quantity' => $quantity, 'price' => $items->$store_id->$sku_id->price)));
            }
            else
            {
                die(json_encode(array('ret' => 0, 'msg' => 'ok', 'quantity' => $quantity, 'price' => $items->$store_id->$sku_id->price)));
            }
        }
        die(json_encode(array('ret' => 2, 'msg' => '商品已移出购物车')));
    }

    public function actionDelete()
    {
        $store_id = $this->request->getQuery('store_id');
        $sku_id = $this->request->getQuery('sku_id');

        $cart = ShoppingCart::model()->findByAttributes(array('user_id' => Yii::app()->user->getId(), 'market_id' => $this->market->market_id));

        $items = json_decode($cart->items);
        if (isset($items->$store_id->$sku_id))
        {
            unset($items->$store_id->$sku_id);

            if (count((array) $items->$store_id) == 0)
            {
                unset($items->$store_id);
            }
        }

        $count = 0;
        $data_items = array();
        foreach ($items as $store_id => $v)
        {
            $count += count($v);
            if (count($data_items) < 5)
            {
                foreach ($v as $item)
                {
                    if (count($data_items) < 5)
                        $data_items[] = (object) $item;
                }
            }
        }
        $cart_items = $this->renderPartial("/widget/cart_items", array('items' => $data_items), TRUE);
        $cart->items = json_encode($items);
        $cart->updated = time();

        if (!$cart->save())
        {
            die(json_encode(array('ret' => 1, 'msg' => 'fail', 'count' => $count, 'items' => $cart_items)));
        }
        else
        {
            die(json_encode(array('ret' => 0, 'msg' => 'ok', 'count' => $count, 'items' => $cart_items)));
        }
    }

}
