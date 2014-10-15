<?php

class PropCats extends IActiveRecord
{
    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return 'item_prop_cats';
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return item cats the static model class
     */
    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }

}