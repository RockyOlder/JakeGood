<?php
class SpiderController extends SellerController {

    private $appKey = '30867601';
    private $appSecret = '8a714afa86dc4cbd898a4a19a587583d';

    function actionIndex()
    {
        
    }

    public function actionIds()
    {
        $city = ('深圳');
	$sign = $this->createSign(array('city' => $city));
        $url  = 'http://api.dianping.com/v1/deal/get_all_id_list?appkey=30867601&sign='.$sign.'&city='. urlencode($city);
        
        $body = file_get_contents($url);
        $json = json_decode($body, TRUE);
        $sql = 'INSERT INTO dp_items (iid) VALUES ';
        $sqls = array();
        $count = count($json['id_list']);

        foreach ($json['id_list'] as $i => $v)
        {
            if ($i > 0 && ($i % 1000 == 0 || $i + 1 == $count))
            {
                $sql .= "('{$v}'),";
                echo substr($sql, 0, -1) . ';';
                $sql = 'INSERT INTO dp_items (iid) VALUES ';
            }
            else
            {
                $sql .= "('{$v}'),";
            }
        }
    }

    public function getDeals($ids = '')
    {
	$sign = $this->createSign(array('deal_ids' => $ids));

        $url = 'http://api.dianping.com/v1/deal/get_batch_deals_by_id?';
        $query = http_build_query(array('appkey' => $this->appKey, 'sign' => $sign, 'deal_ids' => $ids));
        $body = file_get_contents($url . $query);
        $data = json_decode($body, TRUE);
        
        return $data;
    }
	
    public function actionItems()
    {
        $items = DpItems::model()->findAll(array('condition' => 'status=0', 'limit' => 40));
        if (!$items)
        {
            die('采集完成');
        }
        $ids = array();
        foreach ($items as $item)
        {
            $ids[] = $item->iid;
            $item->status = 1;
            $item->update();
        }
        $data = $this->getDeals(implode(',', $ids));
        if (count($data) > 0 )
        {
            echo '<meta http-equiv="refresh" content="3">';
        }
        else
        {
            echo '<meta http-equiv="refresh" content="5">';
            var_dump($data);
            die;
        }
        
        foreach ($data['deals'] as $item)
        {
            list($ret, $id, $status, $title) = $this->addItem($item);
            echo $id . $title . "<br />\n";
            @ob_flush();
            @flush();
        }
    }
	
    public function getShops($ids = '')
    {
	$sign = $this->createSign(array('business_ids' => $ids));

        $url = 'http://api.dianping.com/v1/business/get_batch_businesses_by_id?';
        $query = http_build_query(array('appkey' => $this->appKey, 'sign' => $sign, 'business_ids' => $ids));
        
        $body = file_get_contents($url . $query);
        
        $data = json_decode($body, TRUE);
        return $data;
    }
    public function actionShops()
    {
        $shops = Shop::model()->findAll(array('condition' => 'region=0', 'limit' => 40, 'order' => 'id asc'));
        if (!$shops)
        {
            die('采集完成');
        }
        $ids = array();
        foreach ($shops as $shop)
        {
            $ids[] = ($shop->id-8)/2;
        }
        $data = $this->getShops(implode(',', $ids));
        if (count($data) > 0)
        {
            echo '<meta http-equiv="refresh" content="3">';
        }
        else
        {
            var_dump($data);
            die;
        }
        
        foreach ($data['businesses'] as $v)
        {
            $shopId = $v['business_id']*2+8;
            $model = Shop::model()->findByPk($shopId);
            
            $model->district = 2;
            $model->region = 2;
                        
            $district = Area::model()->find('parent_id = :parent_id AND name like :name', array(':parent_id' => $model->city, 'name' => $v['regions'][0]));
            if ($district)
            {
                $model->district = $district->area_id;
            }
            if ($district && isset($v['regions'][1]))
            {
                $region = Area::model()->find('parent_id = :parent_id AND name like :name', array(':parent_id' => $district->area_id, 'name' => $v['regions'][1]));
                $model->region = $region->area_id;
            }
            if ( ! ($model->region > 0))
            {
                $model->region = 2;
            }
            $model->tel   = $v['telephone'];
            $model->photo = $v['photo_url'];
            if ( ! $model->save())
            {
                print_r($model->errors);
                echo '<font color="red">'. $v['name'].$shopId . "更新失败</font><br />\n";
            }
            else
            {
                echo $v['name'].$shopId . "更新成功<br />\n";
            }
            
            @ob_flush();
            @flush();
        }
    }

    function createSign($param = array())
    {
        ksort($param);
        $str = $this->appKey;
        foreach ($param as $k => $v)
        {
            $str .= $k . $v;
        }
        $str .= $this->appSecret;
        $sign = sha1($str);
        return strtoupper($sign);
    }

    public function addItem($item = NULL, $id = 0)
    {
        //print_r($item);die;
        if (is_array($item))
        {

            if (count($item['regions']) > 1)
            {
                $name = '【' . count($item['regions']) . '店通用】' . $item['title'];
            }
            elseif (count($item['regions']) == 1)
            {
                $name = '【' . $item['regions'][0] . '】' . $item['title'];
            }
            else
            {
                $name = $item['title'];
            }
            $city = $item['city'];
            $area = Area::model()->find("name like '{$city}市'");
			
            $attributes = array(
                'outer_id'      => $item['deal_id'],
                'market_id'     => $this->store->market_id,
                'store_id'      => $this->store->store_id,
                'name'          => $name,
                'title'         => $item['description'],
                'num'           => 10000,
                'price'         => $item['current_price'],
                'orig_price'    => $item['list_price'],
                'pic_url'       => $item['image_url'],
                'desc'          => '',
                'list_time'     => strtotime($item['publish_date']),
                'expiry_date'   => $item['purchase_deadline'],
                'is_show'       => 1,
                'is_showcase'   => 0,
                'create_time'   => time(),
                'state'         => $state->parent_id,
                'city'          => $city->area_id,
                'regions'       => implode(',', $item['regions']),
                'commission'    => $item['commission_ratio'],
                'notice'        => $item['notice'],
                'tips'          => $item['restrictions']['special_tips'],
            );

            foreach ($item['categories'] as $cid)
            {
                $cat = ItemCats::model()->find('name like :cat', array(':cat' => $cid));
                if ($cat)
                {
                    if ($cat->is_parent == 1)
                    {
                        $attributes['parent_cid'] = $cat->cid;
                    }
                    else
                    {
                        $attributes['cid'] = $cat->cid;
                        if (count($item['categories'] == 1))
                        {
                            $attributes['parent_cid'] = $cat->parent_cid;
                        }
                    }
                }
            }
            $imgs = array();
            foreach ($item['more_image_urls'] as $i => $v)
            {
                $imgs[] = array('url' => $v, 'position' => $i);
            }

            $attributes['ItemImgs'] = $imgs;
            $model = new Item;
            $model->attributes = $attributes;
            if (!$model->save())
            {
		print_r($model->errors);
                return array(false, $id, '存取错误', '');
            }
            else
            {
                foreach ($item['businesses'] as $shop)
                {
                    $this->createShop($shop, $attributes['parent_cid']);
                    $itemShop = new ItemShop();
                    $itemShop->item_id = $model->item_id;
                    $itemShop->shop_id = $shop['id']*2+8;
                    $itemShop->save();
                }
            }

            return array(true, $item['deal_id'].'__'.$model->item_id, 'OK', $model->name.'--'.$model->title);
        }
        return array(false, $id, 'api 查询不到数据<br />', '');
    }
    
    function createShop($shop, $cid)
    {
        $shopId    = $shop['id']*2+8;
        $model = Shop::model()->findByAttributes(array('id' => $shopId));
        
        if ( ! $model)
        {
            $model = new Shop();
            $model->id = $shopId;
            $model->market_id = $this->store->market_id;
            $model->store_id = $this->store->store_id;
            $model->cid       = $cid;
            $model->name      = $shop['name'];
            $model->state     = $this->store->state;
            $model->city      = $this->store->city;
            $model->district  = $this->store->district;
            $model->region    = 0;
            $model->address   = $shop['address'];
            $model->tel       = '';
            $model->hours     = '';
            $model->latitude  = $shop['latitude'];
            $model->longitude = $shop['longitude'];
            $model->created   = time();
            $model->closed    = 0;
            $model->username  = $shopId;
            $model->password  = md5('111111');
            $model->status = 1;
            
            if ( ! $model->save())
            {
                print_r($model->errors);
            }
        }
    }
}
