<?php

class SpiderController extends SellerController {

    function actionIndex()
    {
        $url = $this->request->getQuery('taourl');
        $arr = parse_url($url);
        parse_str($arr['query'], $param);

        if (isset($param['id']))
        {
            $this->actionItem();
        }
        else
            $this->actionShop();
    }

    public function actionShop()
    {
        Yii::import('application.extensions.taobao.TBao');
        $tb = new TBao;
        
        $url = $this->request->getQuery('taourl');
        $arr = parse_url($url);
        $md5 = md5($arr['host']);

        $items = Yii::app()->cache->get($md5);
        if (!$items)
        {
            $items = $tb->getNumIds($url);
            Yii::app()->cache->get($md5, $items);
        }
        
        $count = count($items);
        $c = 0;
        $iids = array();
        $outs = array('27359712353','15452418747','22081235256','23445852408','35383879421','17191998572','37438998073','15113815052');
        while (count($items) > 0)
        {
            $num_iid = array_shift($items);
            $num_iid = $num_iid['num_iid'];
            if (in_array($num_iid, $outs))
            {
                continue;
            }
            $model = Item::model()->findByAttributes(array('num_iid' => $num_iid, 'market_id' => $this->store->market_id));
            if ($model)
            {
               // echo $num_iid.'__'.$model->item_id, '已下载过---------------', $model->title.'<br />';
            }
            else
            {
                $iids[] = $num_iid;
                if (count($iids) > 19)
                {
                    $data = $tb->getItemList($iids);
                    
                    if (isset($data['msg']))
                    {
                        echo $data['msg'].'<br />';
                        foreach ($iids as $num_iid)
                        {
                            $item = $tb->getItem($num_iid);
                            if (isset($item['msg']))
                            {
                                die($item['msg']);
                            }
                            list($ret, $id, $msg) = $this->addItem($num_iid, $item);
                            echo $msg.' -- '.$id.' -- '.$item['title'] . "<br />/......<br />\n";
                            ob_flush();
                            flush();
                            sleep(1);
                        }
                        die($item['msg']);
                    }

                    foreach ($data as $i => $item)
                    {
                        list($ret, $id, $msg) = $this->addItem($item['num_iid'], $item);
                        echo $i.' '.$msg.' -- '.$id.' -- '.$item['title'] . "<br />/......<br />\n";
                        ob_flush();
                        flush();
                        sleep(1);
                    }
                    $iids = array();
                }
            }
        }
        echo '<b style="color:red">下载完成</b>';
        die;
    }

    public function actionItem()
    {
        Yii::import('application.extensions.taobao.TBao');
        $tb = new TBao;
        
        $url = $this->request->getQuery('taourl');
        $arr = parse_url($url);
        parse_str($arr['query'], $param);
        $num_iid = $param['id'];
        
        $model = Item::model()->findByAttributes(array('num_iid' => $num_iid, 'market_id' => $this->store->market_id));
        if ($model)
        {
            echo $num_iid.'__'.$model->item_id, '已下载过', $model->title.'<br />';
        }
        
        $item = $tb->getItem($num_iid);
        
        if (isset($item['msg']))
        {
            die($item['msg']);
        }
        
        list($ret, $id, $msg) = $this->addItem($num_iid, $item);
        echo $msg.' -- '.$id.' -- '.$item['title'] . "<br />\n......<br />\n";
    }

    public function addItem($id = 0, $item = NULL)
    {
        if (isset($item['second_kill']))
        {
            return array(false, $id, '秒杀商品: ' . $item['title'], '');
        }
        if ( ! $item['props_name']) $item['props_name'] = '';
        if ( ! $item['property_alias']) $item['property_alias'] = '';
        if ( ! isset($item['skus']['sku'])) $item['skus']['sku'] = array();
        if ( ! isset($item['prop_imgs']['prop_img'])) $item['prop_imgs']['prop_img'] = array();
        
        list($item['props'], $item['sku_map'], $item['skus'], $item['prop_imgs'], $item['spec']) = $this->buildProps($item['props_name'], $item['property_alias'], $item['skus']['sku'], $item['prop_imgs']['prop_img'], $item['cid']);
        
        //print_r($item);die;
        if (is_array($item))
        {
            $state = $item['location']['state'];
            $city = $item['location']['city'];
            $state = Area::model()->find("parent_id = 100000 AND name like '{$state}%'");
            $city = Area::model()->find("parent_id = {$state[area_id]} AND name like '{$city}%'");

            $attributes = array(
                'num_iid'   => $id,
                'market_id' => $this->store->market_id,
                'cid'      => $item['cid'],
                'outer_id' => $item['outer_id'],
                'store_id' => Yii::app()->user->getId(),
                'title'    => $item['title'],
                'nick'     => $item['nick'],
                'num'      => $item['num'],
                'price'    => $item['price'],
                'props'    => json_encode($item['props']),
                'sku_map'  => json_encode($item['sku_map']),
                'prop_imgs' => json_encode($item['prop_imgs']),
                'pic_url'   => $item['pic_url'],
                'desc'      => $item['desc'],
                'list_time' => strtotime($item['list_time']),
                'delist_time' => strtotime($item['delist_time']),
                'express_fee' => $item['express_fee'],
                'post_fee'    => $item['post_fee'],
                'ems_fee'     => $item['ems_fee'],
                'freight_payer' => $item['freight_payer'] == 'seller' ? 1 : 0,
                'is_show'       => $item['approve_status'] == 'onsale' ? 1 : 0,
                'is_showcase'   => 0,
                'create_time'   => time(),
                'state'         => $state->area_id,
                'city'          => $city->area_id,
                'item_weight'   => (float)$item['item_weight'],
                'item_size'     => (float)$item['item_size'],
                'sold_quantity' => (int)$item['sold_quantity'],
                'ItemSku'       => $item['skus'],
                'ItemSpec'      => $item['spec'],
            );

            $imgs = array();
            if (isset($item['item_imgs']['item_img']['url']))
            {
                $imgs[] = $item['item_imgs']['item_img'];
            }
            else
            {
                foreach ($item['item_imgs']['item_img'] as $v)
                {
                    $imgs[] = array('url' => $v['url'], 'position' => (int) $v['position']);
                }
            }


            $attributes['ItemImgs'] = $imgs;
            $model = new Item;
            $model->attributes = $attributes;
            if (!$model->save())
            {
                return array(false, $id, '存取错误');
            }

            return array(true, $id.'__'.$model->item_id, 'OK', $item['title']);
        }
        return array(false, $id, 'api 查询不到数据<br />', '');
    }

    function buildProps($props_name, $property_alias, $skus, $prop_imgs, $cid=0)
    {
        $alias = array();
        $props = array();
        $sku_map = array();
        $item_sku = array();
        $item_propimgs = array();
        $item_spec = array();
        
        //基本属性
        if ($props_name != '')
        {
            $props_name = explode(';', $props_name);
            foreach ($props_name as $v)
            {
                list($pid, $vid, $pname, $vname) = explode(':', $v);
                
                $values = array($vid => $vname);
                if (isset($props[$pid]))
                {
                    $values += $props[$pid]['values'];
                }
                
                $item_spec[] = array(
                    'cid' => $cid,
                    'pid' => $pid,
                    'vid' => $vid,
                    'pname' => $pname,
                    'vname' => $vname,
                );
                
                $props[$pid] = array(
                    'pid'    => $pid,
                    'name'   => $pname,
                    'values' => $values
                );
            }
        }
        //input alias
        if ($property_alias != '')
        {
            $property_alias = explode(';', $property_alias);
            foreach ($property_alias as $v)
            {
                list($pid, $vid, $vname) = explode(':', $v);
                $props[$pid]['values'][$vid] = $vname;
            }
        }
        //sku
        if (isset($skus[0]))
        {
            //避免重复附值，sku map数组
            $props_name = explode(';', $skus[0]['properties_name']);
            foreach ($props_name as $v)
            {
                list($pid, $vid, $pname, $vname) = explode(':', $v);
                $sku_map[$pid] = $props[$pid];
                $sku_map[$pid]['values'] = array_reverse($sku_map[$pid]['values'], TRUE);//array_reverse 倒序， values 从前面的数组获取
            }
            
            //组合item skus
            foreach ($skus as $k => $v)
            {
                $prop_name  = array();
                $props_name = explode(';', $v['properties_name']);
                foreach ($props_name as $prop)
                {
                    list($pid, $vid, $pname, $vname) = explode(':', $prop);
                    $prop_name[] = $pname.':'.$props[$pid]['values'][$vid]; //因为taobao的sku name非自定义的
                }
                
                $item_sku[] = array(
                    'props'      => $v['properties'],
                    'props_name' => implode(';', $prop_name),
                    'stock'      => $v['quantity'],
                    'price'      => $v['price'],
                    'outer_id'   => '',
                    'status'     => 1
                );
            }
        }
        elseif ( !empty ($skus))    
        {
            /*单个sku时*/
            
            $prop_name  = array();
            $props_name = explode(';', $skus['properties_name']);
            foreach ($props_name as $v)
            {
                list($pid, $vid, $pname, $vname) = explode(':', $v);

                $sku_map[$pid] = $props[$pid];
                $sku_map[$pid]['values'] = array_reverse($sku_map[$pid]['values'], TRUE);
                
                $prop_name[] = $pname.':'.$props[$pid]['values'][$vid];
            }
            
            $item_sku[] = array(
                'props'      => $skus['properties'],
                'props_name' => implode(';', $prop_name),
                'stock'      => $skus['quantity'],
                'price'      => $skus['price'],
                'outer_id'   => '',
                'status'     => 1
            );
        }
        
        //属性图片
        if (isset($prop_imgs[0]))
        {
            //组合item skus
            foreach ($prop_imgs as $k => $v)
            {
                list($pid, $vid) = explode(':', $v['properties']);
                $item_propimgs[$pid][$vid] = $v['url'];
            }
        }
        elseif ( !empty ($prop_imgs))    
        {
            /*单个sku时*/
            list($pid, $vid) = explode(':', $prop_imgs['properties']);
            $item_propimgs[$pid][$vid] = $prop_imgs['url'];
        }
        
        return array($props, $sku_map, $item_sku, $item_propimgs, $item_spec);
    }
}
