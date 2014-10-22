<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ItemSearch
 *
 * @author Fighter
 */
class ItemSearch extends Item{
    
    public $sale;
    public $rating;
    public $collect;
    /**
     * 
     * @param array $args (cid=>1, keyword=>'', attr=>'', store_id=>1, sort=>'', limit=>10, page=1)
     * @return \Item
     */
    public function search(array $args)
    {
        $limit = 20;
        $page  = 1;
        extract($args);
        
        $market_id = Yii::app()->controller->market->market_id;
        
        $condition = 't.market_id = '.$market_id . ' AND t.is_show = 1';
        $params    = array();
        if ($cid)
        {
            $condition .= ' AND (t.cid = :cid OR t.parent_cid = :cid)';
            $params[':cid'] = $cid;
        }
        if (isset($keyword) && ! empty($keyword))
        {
            $condition .= " AND (t.title like :keyword OR t.name like :keyword)";
            $params[':keyword'] = '%'.$keyword.'%';
        }
        
        $select = 'c.sale, c.rating, c.collect, ';
        $join   = ' LEFT JOIN item_counter c ON c.item_id = t.item_id';
        $order  = '';
        //排序
        if (isset($sort) && ! empty($sort))
        {
            list($column, $sort) = explode('-', $sort);
            if ($sort && ($sort == 'desc' || $sort == 'asc'))
            {
                switch ($column)
                {
                    //外表排序
                    case 'sale':  //销量
                    case 'rating'://评价
                        $order = "c.{$column} {$sort}";
                        break;
                    case 'time':
                        $order = "t.create_time {$sort}";
                        break;
                    case 'price':
                        $order = "t.{$column} {$sort}";
                        break;
                }
                
            }
            
        }
        
        //属性检索条件
	$having = '';
        if (isset($spec))
        {
            $join .= ' LEFT JOIN item_spec spec ON spec.item_id = t.item_id';
            if (count($spec) == 1)
            {
                foreach ($spec as $pid => $vid)
                {
                    $condition .= ' AND spec.pid='.(int)$pid.' AND spec.vid='.(int)$vid;
                }
            }
            else
            {
                $pids = array_keys($spec);
                $vids = array_values($spec);
                $condition .= ' AND spec.pid in (:pids) AND spec.vid in (:vids)';
                $params[':pids'] = $pids;
                $params[':vids'] = $vids;
                $having = 'count(t.item_id) = '.count($pids);
            }
        }
        $select .= 't.*';
        
        $rs = $this->findAll(array('select' => $select, 
                                   'join'   => $join,
                                   'condition' => $condition, 
                                   'params' => $params,
                                   'order'  => $order, 
                                   'limit'  => $limit, 
                                   'group'  => 't.item_id',
                                   'having' => $having,
                                   'offset' => ($page-1)*$limit
                                ));
        
        $count = $this->count(array('join' => $join, 'condition' => $condition, 'params' => $params));
        return array($rs, $count);
    }
}
