<?php

class ItemCounter extends IActiveRecord
{
    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return 'item_counter';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('item_id', 'required'),
            array('item_id, sale, rating, collect, pv, uv', 'safe'),
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
            'Item' => array(self::BELONGS_TO, 'Item', 'item_id'),
        );
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return Sku the static model class
     */
    public static function model($className=__CLASS__)
    {
        return parent::model($className);
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
    
}
