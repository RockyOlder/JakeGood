<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of AdContent
 *
 * @author Fighter
 */
class AdContent extends IActiveRecord {

    public function tableName()
    {
        return 'ad_contents';
    }

    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

}
