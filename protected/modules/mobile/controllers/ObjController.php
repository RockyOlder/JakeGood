<?php

/**
 * 
 *
 */
class ObjController extends MobileController {

    /**
     * 转前台登录
     */
    public function actionIndex() {
        $id = Yii::app()->user->getId();
        $this->layout = FALSE;
        $this->template = '/index';
        $this->data['id'] = $id;
    }

    public function actionCeshi() {
        //echo 1;exit;
        $this->layout = FALSE;
        $this->template = '/top_nav';
    }
    public function actionList() {

        $this->layout = FALSE;
        $this->template = '/orders/list';
        $cid = $this->request->getQuery('cid');
        //print_r($cid);exit;
        $ppath = $this->request->getQuery('ppath');   //属性检索
        $keyword = $this->request->getQuery('q');
        $page = $this->request->getQuery('page', 1);
        $limit = $this->request->getQuery('display');
        $sort = $this->request->getQuery('sort');

        $params = array('cid' => $cid, 'page' => $page); //商品检索参数
        $url_param = array('cid' => $cid);

        if (!$limit) {
            $params['limit'] = $limit = 20;
        } else {
            $params['limit'] = $url_param['display'] = $limit;
        }
        if ($sort) {
            $params['sort'] = $url_param['sort'] = $sort;
        }
        if ($keyword) {
            $params['keyword'] = $url_param['q'] = $keyword;
        }
        //属性
        $prop_param = array();
        if (strpos($ppath, ':') !== FALSE) {
            $pps = explode(';', $ppath);
            foreach ($pps as $v) {
                list($pid, $vid) = explode(':', $v);
                $prop_param[$pid] = $vid;
            }
            $params['spec'] = $prop_param;
        }
        //筛选条件
        $cat = ItemCats::model()->findByPk($cid);
        $catParam = $url_param;
        if ($cat->parent_cid > 0) {
            $cats = ItemCats::model()->findAll('parent_cid=' . $cat->parent_cid);
            //$cats = ItemCats::model()->findByPk('parent_cid='.$cat->parent_cid); 
            $catParam['cid'] = $cat->parent_cid;
            $selected = ($cat->parent_cid == $cid ? 1 : 0);
        } elseif ($cat->parent_cid == 0 AND $cat->cid > 0) {
            $cats = ItemCats::model()->findAll('parent_cid=' . $cat->cid);
            $selected = ($cat->cid == $cid ? 1 : 0);
        }
        if (!$cats) {
            $cats = ItemCats::model()->findAll('parent_cid=0');
            unset($catParam['cid']);
            $selected = (!$cid ? 1 : 0);
        }
        $filters = array();
        $filters['cats']['name'] = '分类';
        $filters['cats']['values'][0]['name'] = '全部';
        $filters['cats']['values'][0]['url'] = $this->createUrl('item/list', $catParam);
        $filters['cats']['values'][0]['selected'] = $selected == 1 ? true : false;
        foreach ($cats as $v) {
            $filters['cats']['values'][] = array(
                'name' => $v->name,
                'url' => $this->createUrl('item/list', array('cid' => $v->cid)),
                'selected' => ($v->cid == $cat->cid ? true : false),
            );
        }
        $filters += $this->getProps($cid, $prop_param, $url_param);
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
        //   print_r($count);exit;
        $this->title = $cat->name . ' - ' . $this->title;
        $this->data['items'] = $items;
        $this->data['count'] = $count;

        $this->data['cid'] = $cid;
        $this->data['cat'] = $cat;
        $this->data['keyword'] = $keyword;
        $this->data['page'] = $page;
        $this->data['limit'] = $limit;
        $this->data['sort'] = $sort;
        //   print_r($this->data['items']);exit;
    }

    public function getProps($cid, $prop_param, $url_param) {
        if (!$cid)
            return array();

        $condition = array('condition' => "t.cid = :cid AND t.parent_pid=0 AND is_key_prop = 1", 'order' => 't.sort_order asc');
        $condition['params'] = array(':cid' => $cid);
        $props = ItemProp::model()->findAll($condition);
        $data = array();

        foreach ($props as $k => $prop) {
            $pid = $prop->pid;
            //获得属性值
            $condition = array('condition' => "cid = :cid AND pid=:pid", 'params' => array(':cid' => $cid, ':pid' => $pid), 'order' => 'sort_order asc');
            $values = ItemPropValue::model()->findAll($condition);

            //把该组的去掉防止同组重复
            $ppath = array();
            $my_prop = $prop_param;
            unset($my_prop[$pid]);
            foreach ($my_prop as $p => $v) {
                $ppath[] = $p . ':' . $v;
            }

            //重组属性数据
            $data[$k]['name'] = $prop->name;
            $data[$k]['values'][0]['name'] = '全部';
            $data[$k]['values'][0]['url'] = $this->createUrl('item/list', array_merge($url_param, array('ppath' => implode(';', $ppath))));
            $data[$k]['values'][0]['selected'] = !isset($prop_param[$pid]) ? true : false;
            foreach ($values as $i => $value) {
                $i += 1;
                $vid = $value->vid;
                $pathdata = array_merge_recursive($ppath, array($pid . ':' . $vid));

                $data[$k]['values'][$i]['name'] = $value->name;
                $data[$k]['values'][$i]['url'] = $this->createUrl('item/list', array_merge($url_param, array('ppath' => implode(';', $pathdata))));
                $data[$k]['values'][$i]['selected'] = (isset($prop_param[$pid]) && $prop_param[$pid] == $vid ? true : false);
            }
        }

        return $data;
    }

    public function actionDetail() {
        //echo 1;exit;
        $this->template = '/detail';
        $item_id = $this->request->getQuery('item_id');
        // print_r($_REQUEST);exit;
        $model = Item::model()->findByPk($item_id);
        if (!$model) {
            return parent::renderError('商品不存在，或已下架！');
        }
        $this->title = $model->title . '-' . $this->title;
        $item_sku = array();
        $this->data['item_sku'] = json_encode($item_sku);
        $this->data['item'] = $model;
        // print_r($this->data['item']);exit;
    }

    function queryDingPing($oid) {
        if (!$oid || strpos($oid, '-') === FALSE)
            return '';
        list($city, $id) = explode('-', $oid);
        //error_reporting(0);
        // print_r($id);exit;
        $url = "http://t.dianping.com/deal/" . $id;
        $body = Tools::curl($url);

        $body = str_replace("lazy-src-load", "src", $body);

        $doc = new DOMDocument();
        $meta = '<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>';
        @$doc->loadHTML($meta . $body);

        /* make a result array ... */
        $result = array();

        /* go through all nodes which have class="baby" ... */
        $dom = new DOMXPath($doc);
        $html = '';
        foreach ($dom->query('//*[@id="J_tabcont"]') as $element) {
            /* just push it into the result ... */
            $html = $doc->saveHTML($element);
        }
        return $html;
    }

}
