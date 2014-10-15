<?php
class SpiderController extends SellerController {

	private $appKey = '30867601';
	private $appSecret = '8a714afa86dc4cbd898a4a19a587583d';
    function actionIndex()
    {
    }

    public function actionIds()
    {
        $url  = 'http://api.dianping.com/v1/deal/get_all_id_list?appkey=30867601&sign=F10E928000A3EADE56B40DBDE7D89526639A49E3&city=%E4%BD%9B%E5%B1%B1';
		$body = file_get_contents($url);
		$json = json_decode($body, TRUE);
		$sql  = 'INSERT INTO dp_items (iid) VALUES ';
		$sqls = array();
		$count = count($json['id_list']);
		
		foreach ($json['id_list'] as $i => $v) {
			if ($i > 0 && ($i % 1000 == 0 || $i+1 == $count))
			{
				$sql .= "('{$v}'),";
				echo substr($sql, 0, -1).';';
				$sql  = 'INSERT INTO dp_items (iid) VALUES ';
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
        $body = file_get_contents($url.$query);
		$data = json_decode($body, TRUE);
		return $data;
    }
	
    public function actionItems()
    {
		$items = DpItems::model()->findAll(array('condition' => 'status=0', 'limit' => 40));
		
		$ids = array();
		foreach ($items as $item)
		{
			$ids[] = $item->iid;
			$item->status = 1;
			$item->update();
		}
		$data = $this->getDeals(implode(',', $ids));
		if (count($data) > 0)
		{
			echo '<meta http-equiv="refresh" content="3">';
		}
		else
		{
			var_dump($data);
		}
		foreach ($data['deals'] as $item)
		{
			list($ret, $id, $status, $title) = $this->addItem($item);
			echo $id.$title."<br />\n";
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
			$str .= $k.$v;
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
				$name = '【'.count($item['regions']).'店通用】'.$item['title'];
			}
			elseif (count($item['regions']) == 1)
			{
				$name = '【'.$item['regions'][0].'】'.$item['title'];
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
                'desc'          => $item['details'],
                'list_time'     => strtotime($item['publish_date']),
                'expiry_date'   => strtotime($item['purchase_deadline']),
                'is_show'       => 1,
                'is_showcase'   => 0,
                'create_time'   => time(),
                'state'         => $state->parent_id,
                'city'          => $city->area_id,
                'regions'          => implode(',', $item['regions']),
                'commission_ratio' => $item['commission_ratio'],
                'notice'           => $item['notice'],
                'tips'             => $item['restrictions']['special_tips'],
            );

			foreach ($item['categories'] as $cid)
			{
				$cat  = ItemCats::model()->find('name like :cat', array(':cat' => $cid));
				if ($cat)
				{
					if ($cat->is_parent == 1)
					{
						$attributes['parent_cid'] = $cat->cid;
					}
					else
					{
						$attributes['cid'] = $cat->cid;
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

            return array(true, $item['deal_id'].'__'.$model->item_id, 'OK', $model->name.'--'.$model->title);
        }
        return array(false, $id, 'api 查询不到数据<br />', '');
    }

    function csv_to_array($csv)
	{
		$len = strlen($csv);


		$table = array();
		$cur_row = array();
		$cur_val = "";
		$state = "first item";


		for ($i = 0; $i < $len; $i++)
		{
			//sleep(1000);
			$ch = substr($csv,$i,1);
			if ($state == "first item")
			{
				if ($ch == '"') $state = "we're quoted hea";
				elseif ($ch == ",") //empty
				{
					$cur_row[] = ""; //done with first one
					$cur_val = "";
					$state = "first item";
				}
				elseif ($ch == "\n")
				{
					$cur_row[] = $cur_val;
					$table[] = $cur_row;
					$cur_row = array();
					$cur_val = "";
					$state = "first item";
				}
				elseif ($ch == "\r") $state = "wait for a line feed, if so close out row!";
				else
				{
					$cur_val .= $ch;
					$state = "gather not quote";
				}
				
			}

			elseif ($state == "we're quoted hea")
			{
				if ($ch == '"') $state = "potential end quote found";
				else $cur_val .= $ch;
			}
			elseif ($state == "potential end quote found")
			{
				if ($ch == '"')
				{
					$cur_val .= '"';
					$state = "we're quoted hea";
				}
				elseif ($ch == ',')
				{
					$cur_row[] = $cur_val;
					$cur_val = "";
					$state = "first item";
				}
				elseif ($ch == "\n")
				{
					$cur_row[] = $cur_val;
					$table[] = $cur_row;
					$cur_row = array();
					$cur_val = "";
					$state = "first item";
				}
				elseif ($ch == "\r") $state = "wait for a line feed, if so close out row!";
				else
				{
					$cur_val .= $ch;
					$state = "we're quoted hea";
				}

			}
			elseif ($state == "wait for a line feed, if so close out row!")
			{
				if ($ch == "\n")
				{
					$cur_row[] = $cur_val;
					$cur_val = "";
					$table[] = $cur_row;
					$cur_row = array();
					$state = "first item";

				}
				else
				{
					$cur_row[] = $cur_val;
					$table[] = $cur_row;
					$cur_row = array();
					$cur_val = $ch;
					$state = "gather not quote";
				}	
			}

			elseif ($state == "gather not quote")
			{
				if ($ch == ",")
				{
					$cur_row[] = $cur_val;
					$cur_val = "";
					$state = "first item";
					
				}
				elseif ($ch == "\n")
				{
					$cur_row[] = $cur_val;
					$table[] = $cur_row;
					$cur_row = array();
					$cur_val = "";
					$state = "first item";
				}
				elseif ($ch == "\r") $state = "wait for a line feed, if so close out row!";
				else $cur_val .= $ch;
			}

		}

		return $table;
	}
}
