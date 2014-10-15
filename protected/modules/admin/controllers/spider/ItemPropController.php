<?php

class ItemPropController extends AdminController {

    public function init()
    {
        parent::init();
    }

    public function actionIndex()
    {
        $cid = $this->request->getQuery('cid');
        if (!$cid)
            die('cid 不对');

        $this->go($cid);
    }

    public function actionAll()
    {
        $this->flashStart();

        $this->flashOut('开始下载下20个类目');

        $condition = array('condition' => 'is_parent=0 AND is_down=0', 'limit' => 10);
        $cats = ItemCats::model()->findAll($condition);

        if (!$cats)
            die('全部下载完成');

        echo '<script>
				window.setTimeout(relocat, 300000);
				function relocat(){
				window.location.href=window.location.href;
				}
			 </script>';

        foreach ($cats as $v)
        {
            $this->go($v->cid);
            $v->is_down = 1;
            if (!$v->update())
            {
                echo $v->cid . $v->name;
                die('error');
            }
            $this->flashOut($v->cid . $v->name);
            sleep(2);
        }

        sleep(2);
        echo '<script>
				window.location.href=window.location.href;
			 </script>';
        die;
        //$this->actionAll();
    }

    function go($cid, $parent_pid = NULL)
    {
        //参数数组
        $paramArr = array(
            'method' => 'taobao.itemprops.get', //API名称
            'timestamp' => date('Y-m-d H:i:s'),
            'format' => 'json', //返回格式,本demo仅支持xml
            'app_key' => Yii::app()->taobao->config['appKey'], //Appkey			
            'v' => '2.0', //API版本号		   
            'sign_method' => 'md5', //签名方式	
            'fields' => 'pid,parent_pid,parent_vid,cid,name,is_key_prop,is_sale_prop,is_color_prop,is_enum_prop,is_input_prop,is_item_prop,child_path,must,multi,prop_values,status,sort_order', //返回字段
            'cid' => $cid, //商品所属分类id
            'type' => 1,
                // 'parent_pid' => '8648185'
        );

        if ($parent_pid !== NULL)
            $paramArr['parent_pid'] = $parent_pid;

        $sign = Yii::app()->taobao->createSign($paramArr, Yii::app()->taobao->config['appSecret']); //生成签名

        $paramArr['sign'] = $sign;

        $key = 'p2_' . md5(implode(',', $paramArr));
        $output = Yii::app()->cache->get($key);

        if ($output === FALSE)
        {
            $output = Yii::app()->curl->get(Yii::app()->taobao->config['apiUrl'], $paramArr);
            Yii::app()->cache->set($key, $output, 3600 * 100);
        }

        $data = json_decode($output);
        //print_r($data);die;
        $this->saveProps($data, $cid);

        //解析Xml数据
        //	$result = getXmlData($result);   
    }

    function saveProps($data, $cid)
    {
        $data = (array) $data->itemprops_get_response;
        if (empty($data))
            return FALSE;

        foreach ($data['item_props']->item_prop as $i => $v)
        {
            $type = (!$v->parent_vid ? 'ig' : 'up');
            $props = Props::model()->findByPk($v->pid);

            if (!$props)
            {
                $props = $this->saveProp($v);
            }
            if ($props->parent_pid == 0 && $v->parent_pid > 0)
            {
                $props->parent_pid = $v->parent_pid;
                $props->update();
            }

            $itemProp = ItemProp::model()->findByAttributes(array('pid' => $v->pid, 'cid' => $cid));
            if (!$itemProp)
            {
                $itemProp = $this->saveItemProp($v, $cid);
            }


            $pcat = PropCats::model()->findByAttributes(array('pid' => $v->pid, 'cid' => $cid));
            if (!$pcat)
            {
                $propCats = new PropCats;
                $propCats->pid = $v->pid;
                $propCats->cid = $cid;
                $propCats->alias = $v->name;
                $propCats->sort_order = $i;
                $propCats->save();
            }
            if (isset($v->prop_values))
            {
                $pvals = ''; //for table prop_values
                $ivals = ''; //for table item_prop_value
                foreach ($v->prop_values->prop_value as $sort => $pv)
                {
                    if (isset($pv->is_parent))
                    {
                        $type = 'is_parent';
                        //$this->go($cid, $v->pid);
                    }
                    $is_parent = intval($pv->is_parent);
                    $parent_vid = intval($v->parent_vid);

                    $vname = mysql_escape_string($pv->name);
                    $pvals .= "({$pv->vid}, {$is_parent}, {$parent_vid}, '{$vname}', '{$sort}', 1),";
                    $ivals .= "({$pv->vid}, {$v->pid}, {$cid}, {$is_parent}, {$parent_vid}, '{$vname}', '{$sort}', 1),";
                }

                $pvals = substr($pvals, 0, -1);
                $ivals = substr($ivals, 0, -1);

                $pvssql = 'INSERT ignore INTO prop_values 
							(vid, is_parent, parent_vid, name, sort_order, status) values ';
                $pvssql2 = 'INSERT INTO prop_values 
							(vid, is_parent, parent_vid, name, sort_order, status) values ';
                $ipvssql = 'INSERT ignore INTO item_prop_value 
							(vid, pid, cid, is_parent, parent_vid, name, sort_order, status) values ';

                if ($type == 'up' || $type == 'is_parent')
                {
                    $pvssql2 .= $pvals . ' ON duplicate KEY UPDATE vid = vid';
                    Yii::app()->db->createCommand($pvssql2)->execute();
                }
                else
                {
                    $pvssql .= $pvals;
                    Yii::app()->db->createCommand($pvssql)->execute();
                }

                $ipvssql .= $ivals;
                Yii::app()->db->createCommand($ipvssql)->execute();
            }
        }
    }

    public function saveProp($v)
    {
        $Prop = new Props;
        $Prop->pid = $v->pid;
        $Prop->parent_pid = $v->parent_pid;
        $Prop->name = $v->name;
        $Prop->status = $v->status == 'normal' ? 1 : 0;
        $Prop->sort_order = $v->sort_order;
        $Prop->save();
        if ($Prop->errors)
        {
            print_r($Prop->errors);
            die('func saveProp');
        }
        return $Prop;
    }

    public function saveItemProp($v, $cid)
    {
        $type = 1;
        if ((int) $v->is_enum_prop == 1)
            $type = 2;
        if ((int) $v->is_key_prop == 1)
            $type = 1;
        if ((int) $v->multi == 1)
            $type = 3;

        $itemProp = new ItemProp;
        $itemProp->cid = $cid;
        $itemProp->type = $type;
        $itemProp->pid = $v->pid;
        $itemProp->parent_pid = $v->parent_pid;
        $itemProp->name = $v->name;
        $itemProp->is_key_prop = (int) $v->is_key_prop;
        $itemProp->is_sale_prop = (int) $v->is_sale_prop;
        $itemProp->is_color_prop = (int) $v->is_color_prop;
        $itemProp->is_enum_prop = (int) $v->is_enum_prop;
        $itemProp->is_input_prop = (int) $v->is_input_prop;
        $itemProp->must = (int) $v->must;
        $itemProp->multi = (int) $v->multi;
        $itemProp->status = $v->status == 'normal' ? 1 : 0;
        $itemProp->sort_order = $v->sort_order;
        $itemProp->save();
        if ($itemProp->errors)
        {
            print_r($itemProp->errors);
            die('func saveItemProp');
        }
        return $itemProp;
    }

    public $action_time;

    function flashStart()
    {
        ob_end_clean(); //清除输出缓存并且关闭缓存
        echo '<pre>';
        echo 'S---' . date('H:i:s') . '-------------start------------------<br>' . "\n"; //输出大于4k字节
    }

    function flashEnd()
    {
        echo '<br>' . time() . '---------end----------总耗时(秒)：' . (time() - $this->action_time) . '<br />' . "\n";
    }

    function flashOut($str)
    {
        echo '<pre>';
        echo $str . "\n";
        echo 'O---' . date('H:i:s') . '-------------start------------------<br>' . "\n"; //输出大于4k字节
        ob_flush();
        flush();
    }

}
