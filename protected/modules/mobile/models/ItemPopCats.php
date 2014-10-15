<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ItemPopCats
 *
 * @author Fighter
 */
class ItemPopCats extends IActiveRecord {

    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return 'item_pop_cats';
    }
    
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }
}
