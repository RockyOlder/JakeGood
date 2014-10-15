<?php


class StoreRate extends IActiveRecord
{
    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return '{{store_rate}}';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        return array();
    }


    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return ItemImg the static model class
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