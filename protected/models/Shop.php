<?php

class Shop extends IActiveRecord {

    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return 'shops';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that 
        // will receive user inputs. 
        return array(
            array('market_id, store_id, state, city, district, region, name', 'required'),
            array('username', 'length', 'min'=>4, 'max'=>20),
            array('username', 'unique'),
            array('id', 'safe'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations()
    {
        return array(
            'OrderCode' => array(self::HAS_MANY, 'OrderCode', 'shop_id'),
            'Store' => array(self::BELONGS_TO, 'Store', 'store_id'),
            'ItemShop' => array(self::BELONGS_TO, 'ItemShop', 'id'),   
        );
    }
    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return ItemImg the static model class
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    public function beforeSave()
    {
        $this->created = time();
        return parent::beforeSave();
    }

    public function getAreas()
    {
        return Area::model()->getAreas($this->state, $this->city, $this->district);
    }

}
