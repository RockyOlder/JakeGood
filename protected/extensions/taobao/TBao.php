<?php

class TBao {

    public $apiUrl = 'http://gw.api.taobao.com/router/rest?';  //正式环境提交URL
    public $sessionUrl = 'http://container.api.taobao.com/container?appkey='; //正式环境获取SessionKey
    public $appKey     = '23016638'; //填写自己申请的AppKey
    public $appSecret  = '70ac1e683a7adf4593b5a8dc19b0c4fb  '; //填写自己申请的$appSecret

    /*
    public $appKey     = '21815112'; //填写自己申请的AppKey
    public $appSecret  = '4337917bee026a905cf4a0d99db6a86c'; //填写自己申请的$appSecret
    public $appKey     = '21808257'; //填写自己申请的AppKey
    public $appSecret  = '06110d7cb24c8203323983e2b353c041'; //填写自己申请的$appSecret
    public $appKey     = '21747462'; //填写自己申请的AppKey
    public $appSecret  = 'efeaa4c4ecc51cffa64fb0444ada2e7d'; //填写自己申请的$appSecret  
    public $appKey     = '21808224'; //填写自己申请的AppKey
    public $appSecret  = '78918d70813da18ac6a19af939c985d6'; //填写自己申请的$appSecret	
    public $appKey     = '21610927'; //填写自己申请的AppKey
    public $appSecret  = 'e8c369cf5a2a20cb4c29e44726c863cd'; //填写自己申请的$appSecret
    public $appKey     = '23015373'; //填写自己申请的AppKey
    public $appSecret  = 'def391ffd2aeb3859bff2c70fedec11c'; //填写自己申请的$appSecret
    public $appKey     = '23015337'; //填写自己申请的AppKey
    public $appSecret  = '09077b47cbe1de06fb293f51b07f67ce'; //填写自己申请的$appSecret
    public $appKey     = '23015453'; //填写自己申请的AppKey
    public $appSecret  = '56bc7729d3801272fd677263a52d19ed'; //填写自己申请的$appSecret
    public $appKey     = '23015452'; //填写自己申请的AppKey
    public $appSecret  = '408edc95f8626e260d5d05e65e49b868'; //填写自己申请的$appSecret
     */

    function TBao()
    {
        
    }

    function getNumIds($shopUrl = '', $page = 1)
    {
        include_once('lib/functions.php');
        
        $au = parse_url($shopUrl);
        $domain = $au['host'];
        if ($domain != '')
        {
            $url = "http://{$domain}/search.htm?spm=a1z10.3.w4011-3242269567.106.yiAle5&mid=w-3242269567-0&search=y&pageNo={$page}&tsearch=y#anchor";
            
            $md5 = md5($url);
            $body = Yii::app()->cache->get($md5);
            if ( ! $body)
            {
                while (($body = @vita_get_url_content($url, TRUE)) === FALSE && $cnt < 3)
                {
                    $cnt++;
                }
                
                Yii::app()->cache->set($md5, $body);
            }
            if (strpos($domain, 'tmall.com') !== FALSE)
            {
                preg_match_all('/"ui-page-s-len">(.*?)<\/b>(.*?)class="pagination"/is', $body, $matches);
                list($p, $pages) = explode('/', $matches[1][0]);
                $body = $matches[2][0];
                $pattern = '/data\-id="(?<num_iid>.*)">/iU';
            }
            else
            {
                preg_match_all('/class="page\-info">(.*?)<\/span>(.*?)class="pagination"/is', $body, $matches);
                list($p, $pages) = explode('/', $matches[1][0]);
                $body = $matches[2][0];
                $pattern = '/data\-id="(?<num_iid>.*)">/iU';
            }

            preg_match_all($pattern, $body, $items, PREG_SET_ORDER);
            
            $countItems = $pages * count($items);
            $page_size = count($items);
            if ($pages > $page)
            {
                $items = array_merge_recursive($items, $this->getNumIds($shopUrl, $page + 1));
            }
            
            return $items;
        }
        return array();
    }

    function getItem($num_iid = 0)
    {
        include_once('lib/functions.php');

        if ($num_iid == 0)
        {
            echo "商品ID不能正确，不能为空或者0";
            exit;
        }

        $data = Yii::app()->cache->get($num_iid);
        if ($data)
        {
            return $data;
        }

        //	if ( ! is_dir($root_path.'image/data/'.$num_iid))
        //		mkdir($root_path.'image/data/'.$num_iid, 0777);

        /* 获取淘宝商品详情 Start */

        //参数数组
        $paramArr = array(
            /* API系统级输入参数 Start */

            'method' => 'taobao.item.get', //API名称
            'timestamp' => date('Y-m-d H:i:s'),
            'format' => 'xml', //返回格式,本demo仅支持xml
            'app_key' => $this->appKey, //Appkey			
            'v' => '2.0', //API版本号		   
            'sign_method' => 'md5', //签名方式
            'partner_id' => 'top-apitools',
            /* API系统级参数 End */

            /* API应用级输入参数 Start */
            'fields' => 'detail_url,num_iid,title,nick,type,cid,seller_cids,props,props_name,'
                        . 'input_pids,input_str,desc,pic_url,num,valid_thru,score,list_time,'
                        . 'delist_time,stuff_status,location,price,post_fee,express_fee,ems_fee,has_discount,freight_payer,'
                        . 'has_invoice,has_warranty,has_showcase,modified,increment,approve_status,postage_id,'
                        . 'product_id,auction_point,property_alias,item_img,prop_img,sku,video,outer_id,is_virtual,'
                        . 'item_weight,item_size,second_kill,sold_quantity', //返回字段
            //sku fields
           // 'fields' => 'sku_id,iid,num_iid,properties,quantity,price,created,modified,properties_name,sku_spec_id', 
            'num_iid' => $num_iid, //Num_iid

                /* API应用级输入参数 End */
        );

        $sign = createSign($paramArr, trim($this->appSecret)); //生成签名

        $strParam = createStrParam($paramArr); //组织参数		
        $strParam .= 'sign=' . $sign . '&app_key=' . $this->appKey;
        $apiUrl = $this->apiUrl . $strParam; //构造Url
        //连接超时自动重试
        $cnt = 0;
        while ($cnt < 3 && ($result = @vita_get_url_content($apiUrl)) === FALSE)
        {
            $cnt++;
        }

        $data = getXmlData($result); //解析Xml数据
        
        if (isset($data['item']))
        {
            Yii::app()->cache->set($num_iid, $data['item']);
            return $data['item'];
        }
        return $data;
    }

    function getItemList($num_iids = array())
    {
        include_once('lib/functions.php');

        if (count($num_iids) == 0)
        {
            echo "商品ID不能正确，不能为空或者0";
            exit;
        }
        $num_iids = implode(',', $num_iids);
        $data = Yii::app()->cache->get(md5($num_iids));
        if ($data)
        {
            return $data;
        }
        
        //	if ( ! is_dir($root_path.'image/data/'.$num_iid))
        //		mkdir($root_path.'image/data/'.$num_iid, 0777);

        /* 获取淘宝商品详情 Start */

        //参数数组
        $paramArr = array(
            /* API系统级输入参数 Start */

            'method' => 'taobao.items.list.get', //API名称
            'timestamp' => date('Y-m-d H:i:s'),
            'format' => 'xml', //返回格式,本demo仅支持xml
            'app_key' => $this->appKey, //Appkey			
            'v' => '2.0', //API版本号		   
            'sign_method' => 'md5', //签名方式
            'partner_id' => 'top-apitools',
            /* API系统级参数 End */

            /* API应用级输入参数 Start */
            'fields' => 'detail_url,num_iid,title,nick,type,cid,seller_cids,props,props_name,'
                        . 'input_pids,input_str,desc,pic_url,num,valid_thru,score,list_time,'
                        . 'delist_time,stuff_status,location,price,post_fee,express_fee,ems_fee,has_discount,freight_payer,'
                        . 'has_invoice,has_warranty,has_showcase,modified,increment,approve_status,postage_id,'
                        . 'product_id,auction_point,property_alias,item_img,prop_img,sku,video,outer_id,is_virtual,'
                        . 'item_weight,item_size,second_kill,sold_quantity', //返回字段
            //sku fields
           // 'fields' => 'sku_id,iid,num_iid,properties,quantity,price,created,modified,properties_name,sku_spec_id', 
            'num_iids' => $num_iids, //Num_iid

                /* API应用级输入参数 End */
        );

        $sign = createSign($paramArr, trim($this->appSecret)); //生成签名

        $strParam = createStrParam($paramArr); //组织参数		
        $strParam .= 'sign=' . $sign . '&app_key=' . $this->appKey;
        $apiUrl = $this->apiUrl . $strParam; //构造Url
        //连接超时自动重试
        $cnt = 0;
        while ($cnt < 3 && ($result = @vita_get_url_content($apiUrl)) === FALSE)
        {
            $cnt++;
        }
        $data = getXmlData($result); //解析Xml数据
        
        if (isset($data['items']['item']))
        {
            Yii::app()->cache->set(md5($num_iids), $data['items']['item']);
            return $data['items']['item'];
        }
        return $data;
    }

}
