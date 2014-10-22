<?php

/**
 * Description of DetailController
 *
 * @author Fighter
 */
class ItemController extends BaseController {

    public $template = NULL;

    function init()
    {
        parent::init();
    }

    public function actionDetail()
    {
        $this->template = '/detail';
        
        $item_id = $this->request->getQuery('item_id');
        $model = Item::model()->findByPk($item_id);
		if (!$model)
		{
			return parent::renderError('商品不存在，或已下架！');
		}
        $this->title = $model->title . '-' . $this->title;
        $item_sku = array();        
        $this->data['item_sku'] = json_encode($item_sku);        
        $this->data['item'] = $model;
    }

    public function actionList()
    {
        $this->layout = FALSE;
        $this->template = '/list';
        $cid     = $this->request->getQuery('cid');
        $region  = $this->request->getQuery('region');
        $ppath   = $this->request->getQuery('ppath');   //属性检索
        $keyword = $this->request->getQuery('q');
        $page    = $this->request->getQuery('page', 1);
        $limit   = $this->request->getQuery('display');
        $sort    = $this->request->getQuery('sort');
        
        $params  = array('cid' => $cid, 'page' => $page); //商品检索参数
        $urlParam = array('cid' => $cid, 'region' => $region, 'q' => $keyword, 'ppath' => $ppath);
        
        if ( ! $limit)
        {
            $params['limit'] = $limit = 20;
        }
        else
        {
            $params['limit'] = $urlParam['display'] = $limit;
        }
        if ($sort)
        {
            $params['sort'] = $urlParam['sort'] = $sort;
        }
        if ($keyword)
        {
            $params['keyword'] = $urlParam['q'] = $keyword;
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
        //筛选条件
        $cat = ItemCats::model()->findByPk($cid);
        $catParam = $urlParam;
        unset($catParam['ppath']);
        
        if ($cat->parent_cid > 0)
        {
            $cats = ItemCats::model()->findAll('parent_cid='.$cat->parent_cid); 
            //$cats = ItemCats::model()->findByPk('parent_cid='.$cat->parent_cid); 
            $catParam['cid'] = $cat->parent_cid;
            $selected = ($cat->parent_cid == $cid ? 1 : 0);
        }
        elseif ($cat->parent_cid == 0 AND $cat->cid > 0)
        {
            $cats = ItemCats::model()->findAll('parent_cid='.$cat->cid);
            $selected = ($cat->cid == $cid ? 1 : 0);
        }
        if (!$cats)
        {
            $cats = ItemCats::model()->findAll('parent_cid=0');
            unset($catParam['cid']);
            $selected = (!$cid ? 1 : 0);
        }
        $catParam = array_filter($catParam);
        $filters = array();
        $filters['cats']['name'] = '分类';
        $filters['cats']['values'][0]['name'] = '全部';
        $filters['cats']['values'][0]['url']  = $this->createUrl('item/list', $catParam);
        $filters['cats']['values'][0]['selected'] = $selected==1 ? true : false;
        foreach ($cats as $v)
        {
            $catParam['cid'] = $v->cid;
            $filters['cats']['values'][] = array(
                'name' => $v->name,
                'url'  => $this->createUrl('item/list', $catParam),
                'selected' => ($v->cid == $cat->cid ? true : false),
            );
        }
        
        if ($region)
        {
            $area = Area::model()->findByPk($region);
        }
        else
        {
            $area = new Area();
        }
        
        $aParam = $urlParam;
        unset($aParam['region']);
        $aParam = array_filter($aParam);
        
        $regions = ANLMarket::getRegions($this->market->city);
        $filters['regions']['name'] = '区域';
        $filters['regions']['values'][0]['name'] = '全部';
        $filters['regions']['values'][0]['url']  = $this->createUrl('item/list', $aParam);
        $filters['regions']['values'][0]['selected'] = (! $region) ? true : false;
        foreach ($regions as $v)
        {
            $aParam['region'] = $v->area_id;
            
            $filters['regions']['values'][] = array(
                'name' => $v->name,
                'url'  => $this->createUrl('item/list', $aParam),
                'selected' => ($v->area_id == ($area->parent_id == $this->market->city ? $area->area_id : $area->parent_id) ? true : false),
            );
        }
        
        if ($region)
        {
            $aParam = $urlParam;
            $aParam = array_filter($aParam);
            if ($area->parent_id != $this->market->city)
            {
                $regions = ANLMarket::getRegions($area->parent_id);
                $aParam['region'] = $area->parent_id;
            }
            else
            {
                $regions = ANLMarket::getRegions($area->area_id);
                $aParam['region'] = $area->area_id;
            }
            
            $filters['regions2']['name'] = '商圈';
            $filters['regions2']['values'][0]['name'] = '全部';
            $filters['regions2']['values'][0]['url']  = $this->createUrl('item/list', $aParam);
            $filters['regions2']['values'][0]['selected'] = ($area->parent_id == $this->market->city) ? true : false;
            foreach ($regions as $v)
            {
                $aParam['region'] = $v->area_id;
                
                $filters['regions2']['values'][] = array(
                    'name' => $v->name,
                    'url'  => $this->createUrl('item/list', $aParam),
                    'selected' => ($v->area_id == $area->area_id ? true : false),
                );
            }
        }
        $filters += ANLMarket::getProps($cid, $prop_param, $urlParam);
        //$filters += $this->getProps($cid, $prop_param, $urlParam);
        $this->data['filters'] = $filters;
        
        //排序URL
        $sort_param = $_GET;
        $sort_param['sort'] = '';
        $this->data['sort_url']['default'] = $this->createUrl('item/list', $sort_param);
        
        $sort_param = $_GET;
        $sort_param['sort'] = 'sale-desc';
        $this->data['sort_url']['sale'] = $this->createUrl('item/list', $sort_param);
        
        $sort_param['sort'] = 'price-asc';
        $this->data['sort_url']['price'] = $this->createUrl('item/list', $sort_param);
        
        $sort_param['sort'] = 'rating-desc';
        $this->data['sort_url']['rating'] = $this->createUrl('item/list', $sort_param);
        
        $sort_param['sort'] = 'time-desc';
        $this->data['sort_url']['time'] = $this->createUrl('item/list', $sort_param);
        
        $sort_param['sort'] = 'collect-desc';
        $this->data['sort_url']['collect'] = $this->createUrl('item/list', $sort_param);
        
        $sort_param['sort'] = 'uv-desc';
        $this->data['sort_url']['uv'] = $this->createUrl('item/list', $sort_param);
        
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

    function queryDingPing($oid)
    {
            if ( ! $oid || strpos($oid, '-') === FALSE) return '';
            list($city, $id) = explode('-', $oid);
            //error_reporting(0);
            $url = "http://t.dianping.com/deal/".$id;
            $body = Tools::curl($url);

            $body = str_replace("lazy-src-load", "src", $body);

            $doc = new DOMDocument();
            $meta = '<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>'; 
            @$doc->loadHTML($meta.$body);

            /* make a result array ... */
            $result = array();

            /* go through all nodes which have class="baby" ... */
            $dom = new DOMXPath( $doc );
            $html = '';
            foreach( $dom->query( '//*[@id="J_tabcont"]' )  as $element )
            {
                    /* just push it into the result ... */
                    $html = $doc->saveHTML( $element );
            }
            return $html;
    }
}
