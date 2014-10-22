<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ItemShop
 *
 * @author Fighter
 */
class ItemShop extends IActiveRecord{
    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return 'item_shops';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        return array(
            array('shop_id', 'required'),
        );
    }
    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }
    
    public function relations()
    {
        return array(
            'Item' => array(self::BELONGS_TO, 'Item', 'item_id'),            
            'Shop' => array(self::HAS_MANY, 'Shop', 'shop_id'),
        );
    }
}
