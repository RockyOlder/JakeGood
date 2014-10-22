<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of AnlItem
 *
 * @author Fighter
 */
class ANLMarket {
    
    /**
     * 根据parent_cid 取得相关分类
     * @param int $parentCid 上级cid
     * @param int $subs 获取子类级数
     * @return array cats
     */
    public static function getCats($marketId, $parentCid = 0, $subs = 0)
    {
        $cats = MarketCats::model()->queryCats($marketId, $parentCid, $subs);        
        return $cats;
    }
    
    /**
     * 根据cid 取得上级相关分类
     * @param int $parentCid 上级cid
     * @return array cats
     */
    public static function getParentCats($marketId, $cid = 0)
    {
        $cats = ItemCats::model()->queryParents($cid);        
        krsort($cats);
        return $cats;
    }
    
    /**
     * 获取类目属性
     * @param type $cid
     * @param type $prop_param
     * @param type $url_param
     * @return type
     */
    public static function getProps($cid, $prop_param, $url_param)
    {
        if ( ! $cid) return array();
        
        $condition = array('condition' => "t.cid = :cid AND t.parent_pid=0 AND is_key_prop = 1", 'order' => 't.sort_order asc');
        $condition['params'] = array(':cid' => $cid);
        $props = ItemProp::model()->findAll($condition);
        $data = array();
        
        foreach ($props as $k => $prop)
        {
            $pid     = $prop->pid;
            //获得属性值
            $condition = array('condition' => "cid = :cid AND pid=:pid", 'params' => array(':cid' => $cid, ':pid' => $pid), 'order' => 'sort_order asc');
            $values = ItemPropValue::model()->findAll($condition);
            
            //把该组的去掉防止同组重复
            $ppath   = array();
            $my_prop = $prop_param;
            unset($my_prop[$pid]);
            foreach ($my_prop as $p => $v)
            {
                $ppath[] = $p.':'.$v;
            }
            
            //重组属性数据
            $data[$k]['name'] = $prop->name;
            $data[$k]['values'][0]['name'] = '全部';
            $data[$k]['values'][0]['url']  = Yii::app()->createUrl('item/list', array_merge($url_param, array('ppath' => implode(';', $ppath))));
            $data[$k]['values'][0]['selected'] = ! isset($prop_param[$pid]) ? true : false;
            foreach ($values as $i => $value)
            {
                $i += 1;
                $vid = $value->vid;
                $pathdata = array_merge_recursive($ppath, array($pid.':'.$vid));
                
                $data[$k]['values'][$i]['name'] = $value->name;
                $data[$k]['values'][$i]['url']  = Yii::app()->createUrl('item/list', array_merge($url_param, array('ppath' => implode(';', $pathdata))));
                $data[$k]['values'][$i]['selected'] = (isset($prop_param[$pid]) && $prop_param[$pid] == $vid ? true : false);
            }
        }
        
        return $data;
    }
    /**
     * 根据条件查询商品列表
     * @param array $args
     * @return array Items
     */
    public static function getItems(array $args)
    {
        $item = new Item();
        
        return $item;
    }
    
    /**
     * 根据item_id list 查找items
     * @param array $ids
     * @return array Items
     */
    public static function getItemByIds(array $ids)
    {
        $item = new Item();
        
        return $item;
    }
    
    /**
     * 根据item_id 取得商品详情
     * @param type $itemId
     * @return \Item
     */
    public static function getItem($itemId)
    {
        $item = new Item();
        
        return $item;        
    }
    
    
    public static function getShopsByItem($itemId)
    {
        $models = ItemShop::model()->findAll('item_id=:id', array(':id' => $itemId));
        $ids = array();
        foreach ($models as $v)
        {
            $ids[] = $v->shop_id;
        }
        
        $shops = Shop::model()->findAllByAttributes(array('id' => $ids));
        return $shops;
    }
    
    public static function getPopCats($marketId)
    {
        $models = MarketCats::model()->findAllByAttributes(array('market_id' => $marketId, 'recommend' => 1));
        
        foreach ($models as $k => $v)
        {
            $models[$k]->url = Yii::app()->createUrl('item/list', array('cid' => $v->cid));
        }
        self::getHots($marketId, 'region');
        return $models;
    }
    
    public static function getRegions($parentId)
    {
        $models = Area::model()->findAllByAttributes(array('parent_id' => $parentId));
        
        $data = array();
        foreach ($models as $k => $v)
        {
            $a = $v->attributes;
            $a['url'] = Yii::app()->createUrl('item/list', array('region' => $v->area_id));
            $data[$k] = (object) $a;
        }
        
        return $data;
    }
    
    public static function getHots($marketId, $type = '')
    {
        $data = array();
        if ($type != '')
        {
            $model = MarketHots::model()->findByAttributes(array('market_id' => $marketId, 'type' => $type));
            
            if ($model)
            {
                $regions = Area::model()->findAll('area_id in ('.$model->content.')');
                foreach ($regions as $k => $v)
                {
                    $a = $v->attributes;
                    $a['url'] = Yii::app()->createUrl('item/list', array('region' => $v->area_id));
                    $data[$k] = (object) $a;
                }
            }
        }
        else
        {
            $hosts = MarketHots::model()->findByAttributes(array('market_id' => $marketId, 'type' => $type));
        }
        
        return $data;
    }
}
