<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of MarketCats
 *
 * @author Fighter
 */
class MarketCats extends IActiveRecord {

    public $subs = array();
    public $recommends = array();
    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return 'market_cats';
    }
    
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }
    
    public static function queryCats($marketId, $parentId = 0, $subs = 9)
    {
        $models = self::model()->_queryCats($marketId, $parentId, $subs);
        
        $cats = ItemCats::model()->queryCats(0, $subs);
        if ($models)
        {
            foreach ($models as $cid => $cat)
            {
                
                if ($cid > 0 && isset($cats[$cid]))
                {
                    if ($cat->status == 0)
                    {
                        unset($cats[$cid]);
                        continue;
                    }
                    
                    $cats[$cid]->name = $cat->name;
                    $cats[$cid]->css  = $cat->css;
                    
                    foreach ($cat->subs as $subCid => $sub)
                    {
                        if ($sub->status == 0)
                        {
                            unset($cats[$cid]->subs[$subCid]);
                            continue;
                        }
                        $cats[$cid]->subs[$subCid]->name = $sub->name;
                        $cats[$cid]->subs[$subCid]->css  = $sub->css;
                        if ($sub->recommend == 1)
                        {
                            $cats[$cid]->recommends[] = $sub;
                        }
                    }
                }
                else
                {
                    $cats[] = $cat;
                }
            }
        }
        
        return $cats;
    }
    
    public function _queryCats($marketId, $parentId = 0, $subs = 9)
    {
        $criteria = new CDbCriteria;
        $criteria->condition = 'market_id=:market_id AND parent_id=:parent_id AND status=1';
        $criteria->params = array(':market_id' => $marketId, ':parent_id' => $parentId);
        $criteria->order = 'sort_order asc';
        
        $models = $this->findAll($criteria);
        
        $cats = array();
        if ($models)
        {
            foreach ($models as $k => $cat)
            {
                        
                if ($subs > 0)
                {
                    $sub = self::_queryCats($marketId, $cat->id, $subs-1);
                    $cat->subs = $sub;
                }
                $cat->cid > 0 ? $cats[$cat->cid] = $cat : $cats[-$k] = $cat;
            }
        }
        return $cats;
    }
}