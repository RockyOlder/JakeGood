<?php

/**
 * Description of ListController
 *
 * @author Fighter
 */
class ListController extends BaseController
{
    public $template = NULL;
    
    function init()
    {
        parent::init();
    }
    public function actionIndex()
    {
     //   print_r($count);exit;
        $this->layout = FALSE;
        $this->template = '/list';
   //     
        $cid     = $this->request->getQuery('cid');
        $ppath   = $this->request->getQuery('ppath');   //属性检索
        $keyword = $this->request->getQuery('q');
        $page    = $this->request->getQuery('page', 1);
        $limit   = $this->request->getQuery('display');
        $sort    = $this->request->getQuery('sort');
    //    print_r($limit);exit;
        $params  = array('cid' => $cid, 'page' => $page); //商品检索参数
        $url_param = array('cid' => $cid);
        
        if ( ! $limit)
        {
            $params['limit'] = $limit = 20;
        }
        else
        {
            $params['limit'] = $url_param['display'] = $limit;
        }
        if ($sort)
        {
            $params['sort'] = $url_param['sort'] = $sort;
        }
        if ($keyword)
        {
            $params['keyword'] = $url_param['q'] = $keyword;
        }
        
        //属性
        $prop_param = array();
        if (strpos($ppath, ':') !== FALSE)
        {
            $pps = explode(';', $ppath);
            foreach ($pps as $v)
            {
                list($pid, $vid) = explode(':', $v);
                $prop_param[$pid] = $vid;
            }
            $params['spec'] = $prop_param;
        }
        //类目
        $cat = ItemCats::model()->findByPk($cid);
        if ($cat->is_parent == 1)
        {
            $this->data['sub_cats'] = ItemCats::model()->findAll('parent_cid='.$cid.' AND status=1');
        }
        else
        {
            $this->data['props'] = $this->getProps($cid, $prop_param, $url_param);
        }
        //排序URL
        $sort_param = $_GET;
        $sort_param['sort'] = '';
        $this->data['sort_url']['default'] = $this->createUrl('list/index', $sort_param);
        
        $sort_param = $_GET;
        $sort_param['sort'] = 'sale-desc';
        $this->data['sort_url']['sale'] = $this->createUrl('list/index', $sort_param);
        
        $sort_param['sort'] = 'price-asc';
        $this->data['sort_url']['price'] = $this->createUrl('list/index', $sort_param);
        
        $sort_param['sort'] = 'rating-desc';
        $this->data['sort_url']['rating'] = $this->createUrl('list/index', $sort_param);
        
        $sort_param['sort'] = 'time-desc';
        $this->data['sort_url']['time'] = $this->createUrl('list/index', $sort_param);
        
        $sort_param['sort'] = 'collect-desc';
        $this->data['sort_url']['collect'] = $this->createUrl('list/index', $sort_param);
        
        $sort_param['sort'] = 'uv-desc';
        $this->data['sort_url']['uv'] = $this->createUrl('list/index', $sort_param);
        
        //商品检索
        $item = new ItemSearch();
        list($items, $count) = $item->search($params);
        
        
        $this->title = $cat->name.' - '.  $this->title;
        $this->data['items'] = $items;
        $this->data['count'] = $count;
        
        $this->data['cid']     = $cid;
        $this->data['cat']     = $cat;
        $this->data['keyword'] = $keyword;
        $this->data['page']    = $page;
        $this->data['limit']   = $limit;
        $this->data['sort']    = $sort;
    }

    /**
     * 获取类目搜索属性
     * @param type $cid
     * @return type
     */
    public function getProps($cid, $prop_param, $url_param)
    {
        if ( ! $cid) return array();
        
        $condition = array('condition' => "t.cid = {$cid} AND t.parent_pid=0 AND is_key_prop = 1", 'order' => 't.sort_order asc');
        $props = ItemProp::model()->findAll($condition);
        $data = array();
        
        foreach ($props as $k => $prop)
        {
            $pid     = $prop->pid;
            //获得属性值
            $condition = array('condition' => "cid = {$cid} AND pid={$pid}", 'order' => 'sort_order asc');            
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
            $data[$k] = (object) $prop->getAttributes();
            $data[$k]->values[0] = (object) array('name' => '全部', 'selected' => ! isset($prop_param[$pid]) ? TRUE : FALSE, 'url' => $this->createUrl('list/index', $url_param));
            foreach ($values as $i => $value)
            {
                $i += 1;
                $vid = $value->vid;
                $pathdata = array_merge_recursive($ppath, array($pid.':'.$vid));
                
                $data[$k]->values[$i] =  (object) $value->getAttributes();
                $data[$k]->values[$i]->selected = (isset($prop_param[$pid]) && $prop_param[$pid] == $vid ? TRUE : FALSE);
                $data[$k]->values[$i]->url = $this->createUrl('list/index', array_merge($url_param, array('ppath' => implode(';', $pathdata))));
            }
        }
        
        return $data;
    }
}
