<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ShoppingCart
 * property items array('store_id' => array(array(item_id, sku_id, price, quantity, title)))
 * @author Fighter
 */
class ShoppingCart extends IActiveRecord{
    //put your code here
    
    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return AddressResult the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return '{{shopping_carts}}';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('user_id, market_id', 'required'),
            array('items, updated', 'safe')
        );
    }
    function findByPk($pk, $condition = '', $params = array())
    {
        $model = parent::findByPk($pk, $condition, $params);
        if ( ! $model)
        {
            $model = new self();
            $model->primaryKey = $pk;
        }
        return $model;
    }
    function findByAttributes($attributes, $condition = '', $params = array())
    {
        $model = parent::findByAttributes($attributes, $condition, $params);
        if ( ! $model)
        {
            $model = new self();
            $model->user_id = $attributes['user_id'];
            $model->market_id = $attributes['market_id'];
            $model->items = json_encode(array());
            $model->save();
        }
        return $model;
    }
}
