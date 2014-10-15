<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of AdPosition
 *
 * @author Fighter
 */
class AdPosition extends IActiveRecord {
 
    public function tableName()
    {
        return 'ad_position';
    }

    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

}
