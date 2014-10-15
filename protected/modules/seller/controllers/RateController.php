<?php

class RateController extends SellerController {

    public $title = '评价';
    
    public function init()
    {
        parent::init();
    }

    public function actionIndex()
    {
        $this->template = 'index';

        $criteria = new CDbCriteria;
        $criteria->addCondition('store_id=' . Yii::app()->user->getId());

        $count = ItemRate::model()->count($criteria);
        $pages = new CPagination($count);
        $pages->pageSize = 15;
        $pages->applyLimit($criteria);

        $rates = ItemRate::model()->findAll($criteria);
        $score = StoreRate::model()->findByPk(Yii::app()->user->getId());

        $this->data['rates'] = $rates;
        $this->data['pages'] = $pages;
        $this->data['storeRate'] = $score;
    }

}
