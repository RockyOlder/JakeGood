<?php

class Market extends IActiveRecord {

    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return 'markets';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that 
        // will receive user inputs. 
        return array(
            array('name, cid, state, city', 'required'),
            array('logo', 'file', 'types' => 'jpg, gif, png', 'allowEmpty' => true),
            array('name', 'length', 'max' => 10),
            array('address', 'length', 'max' => 200),
            array('zipcode', 'length', 'max' => 6),
            array('introduction ', 'length', 'max' => 500),
            array('created', 'safe'),
        );
    }

    public function relations()
    {
        return array(
            'Store'   => array(self::HAS_MANY, 'Store', 'store_id'),
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
        $state = Area::model()->findByPk($this->state)->name;
        $city = Area::model()->findByPk($this->city)->name;
        $this->area = $state . $city;
        $this->updated = time();
        return parent::beforeSave();
    }

    public function getAreas()
    {
        return Area::model()->getAreas($this->state, $this->city);
    }
    
}
