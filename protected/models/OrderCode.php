<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of OrderCode
 *
 * @author Fighter
 */
class OrderCode extends IActiveRecord {

    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return OrderItem the static model class
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return 'order_codes';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('order_id, item_id, store_id, user_id, mobile, code', 'required'),
            array('created, send_time, status, shop_time, check_time', 'safe'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations()
    {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'Order' => array(self::BELONGS_TO, 'Order', 'order_id'),
            'Shop' => array(self::BELONGS_TO, 'Shop', 'shop_id'),
        );
    }

    public function append($attributes)
    {
        $code = mt_rand(1, 8).substr(time(), -4).substr(microtime(),2, 5).sprintf('%02d',rand(0,99));
        
        $attributes['code'] = $code;
        $attributes['created'] = time();
        $attributes['status']  = 0;
        $this->attributes = $attributes;
        if ($this->save())
        {
            return array(TRUE, $attributes['mobile'], $code);
        }
        else
        {
            return array(FALSE, $attributes['mobile'], $this->getErrors());
        }
    }
}