<?php


class ItemCatsController extends AdminController
{
	public function init()
	{
		$this->pageTitle = '下载淘宝类目';
		parent::init();
	}

	public function actionIndex()
	{
		$parent_cid = (string) $this->request->getQuery('parent_cid', '0');

		$this->data['item_cats']  = $this->loadingData($parent_cid);
		$this->data['parent_cid'] = $parent_cid; 

		$this->template = '/spider/item_cats';
		
		//解析Xml数据
	//	$result = getXmlData($result);   
	}

	public function actionImport()
	{
		$cidList = $this->request->getPost('cids');
		$rootCats = $this->loadingData('0');
		
		foreach ($cidList as $cid)
		{
			$this->save($rootCats[$cid]);
			if ($rootCats[$cid]->is_parent) $this->fetchImport($cid);
			echo $rootCats[$cid]->name.'----导入完成<br />';
			ob_flush();
			flush();
			sleep(2);
		}
	}

	function fetchImport($cid)
	{
		$data = $this->loadingData($cid);
		
		foreach ($data as $v)
		{
			echo $v->name.'<br />';
			$this->save($v);
			
			if ($v->is_parent) $this->fetchImport($v->cid);
			ob_flush();
			flush();
		}
	}
	function save($v)
	{
		$model = new ItemCats;
		$itemCat = ItemCats::model()->findByPk($v->cid);
		if ($itemCat)
		{
			$itemCat->attributes = array(
										'cid' => $v->cid,
										'parent_cid' => $v->parent_cid,
										'is_parent' => $v->is_parent,
										'name' => $v->name,
										'sort_order' => $v->sort_order,
										'status' => ($v->status == 'normal' ? 1 : 0),
									);
			$itemCat->save();
		}
		else
		{
			$attributes = array(
					'cid' => $v->cid,
					'parent_cid' => $v->parent_cid,
					'is_parent' => $v->is_parent,
					'name' => $v->name,
					'sort_order' => $v->sort_order,
					'status' => ($v->status == 'normal' ? 1 : 0),
				);
			Yii::app()->db->createCommand()->insert($model->tableName(), $attributes);
		}
	}
	function loadingData($parent_cid = '0')
	{
	    //参数数组
		$param = array(
				'method' => 'taobao.itemcats.get',  //API名称
			 'timestamp' => date('Y-m-d H:i:s'),			
				'format' => 'json',  //返回格式,本demo仅支持xml
			   'app_key' => Yii::app()->taobao->config['appKey'],  //Appkey			
					 'v' => '2.0',   //API版本号		   
			'sign_method'=> 'md5', //签名方式	
				'fields' => 'cid,parent_cid,name,is_parent,status,sort_order',  //返回字段
			'parent_cid' => $parent_cid,         //商品所属分类id
		);
		
		$param['sign'] = Yii::app()->taobao->createSign($param, Yii::app()->taobao->config['appSecret']);	//生成签名

		$item_cats = Yii::app()->cache->get(md5('taobao.itemcats.get.'.$parent_cid));
		

		if ($item_cats === FALSE || isset($_GET['nocache']))
		{
			$item_cats = Yii::app()->curl->get(Yii::app()->taobao->config['apiUrl'], $param);
			Yii::app()->cache->set(md5('taobao.itemcats.get.'.$parent_cid), $item_cats, 600);
		}
		$item_cats = json_decode($item_cats);
		$data = array();
		if (isset($item_cats->itemcats_get_response->item_cats->item_cat))
		{
			foreach ($item_cats->itemcats_get_response->item_cats->item_cat as $v)
			{
				$data[$v->cid] = $v;
			}
		}
		
		return $data;
	}
   
}