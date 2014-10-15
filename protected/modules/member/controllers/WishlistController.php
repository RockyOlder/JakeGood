<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of WishlistController
 *
 * @author Fighter
 */
class WishlistController extends BaseController {

    function init()
    {
        parent::init();
    }

    public function actionIndex()
    {
        $this->must_login = TRUE;
        $this->template = 'index';

        $list = Wishlist::model()->findAllByAttributes(array('user_id' => Yii::app()->user->getId(), 'market_id' => $this->market->market_id));

        $this->data['list'] = $list;
    }

    public function actionAdd()
    {
        if (Yii::app()->user->getIsGuest())
        {
            die(json_encode(array('ret' => 3001, 'msg' => 'fail')));
        }

        $item_id = $this->request->getQuery('item_id');
        $model = Wishlist::model()->findByAttributes(array('user_id' => Yii::app()->user->getId(), 'item_id' => $item_id));
        if ( ! $model)
        {
            $item = Item::model()->findByPk($item_id);
            if ($item)
            {
                $counter = ItemCounter::model()->findByPk($item_id);
                $counter->collect += 1;
                    
                $model = new Wishlist();
                $model->market_id = $this->market->market_id;
                $model->user_id   = Yii::app()->user->getId();
                $model->item_id   = $item_id;
                $model->title     = $item->title;
                $model->created   = time();
                if ($model->save() && $counter->save())
                {
                    die(json_encode(array('ret' => 0, 'msg' => 'ok')));
                }
            }
            die(json_encode(array('ret' => -1, 'msg' => 'fail')));
        }
        else
        {
            die(json_encode(array('ret' => 0, 'msg' => 'ok')));
        }
        
    }
    
    public function actionDelete()
    {
        $id = $this->request->getQuery('id');
        $model = Wishlist::model()->findByAttributes(array('user_id' => Yii::app()->user->getId(), 'id' => $id));
        if ($model)
        {
            $model->delete();
        }
        $this->request->redirect($this->createUrl('index'));
    }
}