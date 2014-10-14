<?php

define("TOKEN", "wxfanyi");
$wechatObj = new wechatCallbackapiTest();
$wechatObj->weixin_run(); //执行接收器方法

class wechatCallbackapiTest {

    private $fromUsername;
    private $toUsername;
    private $times;
    private $keyword;
    private $postStr;
    private $msgType;

    public function weixin_run() {
        $this->responseMsg();
        $textTpl = "<xml>
                    <ToUserName><![CDATA[%s]]></ToUserName>
                    <FromUserName><![CDATA[%s]]></FromUserName>
                    <CreateTime>%s</CreateTime>
                    <MsgType><![CDATA[%s]]></MsgType>
                    <Content><![CDATA[%s]]></Content>
                    <FuncFlag>0</FuncFlag>
                    </xml>";
        //获取事件类型
        // $this->msgType = 'text';	 
        //关注时回复
        if ($this->postStr->Event == 'subscribe') {
            $this->msgType = 'text';
            $contentStr = "欢迎来到嘉爷的微信平台\n1、目前有翻译功能\n例如：翻译你好\n温馨提示翻译两字要带上\n也可以翻译英文哦。\n2、查询全国的天气预报\n例如：天气深圳";
            $resultStr = sprintf($textTpl, $this->fromUsername, $this->toUsername, $this->times, $this->msgType, $contentStr);
            echo $resultStr;
            exit;
        }
        //关键词回复
        if ($this->keyword == '帅哥') {
            $this->msgType = 'text';
            $contentStr = "嘉爷当然帅~~";
            $resultStr = sprintf($textTpl, $this->fromUsername, $this->toUsername, $this->times, $this->msgType, $contentStr);
            echo $resultStr;
            exit;
        }
        if (mb_substr($this->keyword, 0, 2, 'UTF-8') == '天气') {
            $tianqi = mb_substr($this->keyword, 0, 2, 'UTF-8'); 
            $word = str_replace($tianqi, '', $this->keyword); 
            $url = "http://api.map.baidu.com/telematics/v3/weather?location=" . urlencode($word) . "&output=json&ak=5E1603123b57fa2a6873a557af98a1ba";
            $weather = file_get_contents($url);
            $weather_json = json_decode($weather, true);
            $resle=array();
            foreach($weather_json['results'][0]['weather_data'] as $values){
                $resle[]=$values;
            }
            $arr[] = array($resle[0]['date']."、".$resle[0]['weather']."  ".$resle[0]['temperature'],'',"http://pic.weather.com.cn/images/cn/photo/2014/10/03/F815DA0675F0470C8BDCC5134064AB34.jpg");
            $arr[] = array($resle[1]['date']."、".$resle[1]['weather']."  ".$resle[1]['temperature'],'',$resle[1]['dayPictureUrl']);
            $arr[] = array($resle[2]['date']."、".$resle[2]['weather']."  ".$resle[2]['temperature'],'',$resle[2]['nightPictureUrl']);
            $arr[] = array($resle[3]['date']."、".$resle[3]['weather']."  ".$resle[3]['temperature'],'',$resle[3]['nightPictureUrl']);
            $this->fun_xml("news", $arr, array(4, 0));
        }

        if (mb_substr($this->keyword, 0, 2, 'UTF-8') == '翻译') {
            $fanyi = mb_substr($this->keyword, 0, 2, 'UTF-8'); 
            $word = str_replace($fanyi, '', $this->keyword); 
            $key = '330102425';
            $keyfrom = 'qiyunkj';
            $url = 'http://fanyi.youdao.com/openapi.do?keyfrom=' . $keyfrom . '&key=' . $key . '&type=data&doctype=json&version=1.1&q=' . urlencode($word); //有道翻译API

            $fanyiJson = file_get_contents($url); //获取url数据,返回Json数据

            $fanyiArr = json_decode($fanyiJson, true); //json 转换成 数组

            $contentStr = "【查询】\n" . $fanyiArr['query'] . "\n【翻译】\n" . $fanyiArr['translation'][0]; //拼接返回给用户的字符串
            //扩展翻译
            if (isset($fanyiArr['web'])) {
                $extension = "\n【扩展翻译】";

                $arr = $fanyiArr['web'][0]['value'];
                $n = 1;
                foreach ($arr as $v) {
                    $extension .= "\n" . $n . '、' . $v;
                    $n++;
                }
            } else {
                $extension = '';
            }
            $this->msgType = 'text';
            $contentStr .= $extension; //拼接扩展查询
            $resultStr = sprintf($textTpl, $this->fromUsername, $this->toUsername, $this->times, $this->msgType, $contentStr);
            echo $resultStr;
            //  $this->fun_xml("text", $contentStr);
        }
    }

    public function valid() {
        $echoStr = $_GET["echostr"];

        //valid signature , option
        if ($this->checkSignature()) {
            echo $echoStr;
            exit;
        }
    }

    public function responseMsg() {
        $posobj = $GLOBALS["HTTP_RAW_POST_DATA"];
        if (!empty($posobj)) {
            $this->postStr = simplexml_load_string($posobj, 'SimpleXMLElement', LIBXML_NOCDATA);
            $this->fromUsername = $this->postStr->FromUserName;
            $this->toUsername = $this->postStr->ToUserName;
            $this->keyword = trim($this->postStr->Content);
            $this->times = time();
        } else {
            echo "this a file for weixin API!";
            exit;
        }
    }

//微信封装类,
//type: text 文本类型, news 图文类型
//text,array(内容),array(ID)
//news,array(array(标题,介绍,图片,超链接),...小于10条),array(条数,ID)

    private function fun_xml($type, $value_arr, $o_arr = array(0)) {
        //=================xml header============
        $con = "<xml>
<ToUserName><![CDATA[{$this->fromUsername}]]></ToUserName>
<FromUserName><![CDATA[{$this->toUsername}]]></FromUserName>
<CreateTime>{$this->times}</CreateTime>
<MsgType><![CDATA[{$type}]]></MsgType>";

        //=================type content============
        switch ($type) {

            case "text" :
                $con.="<Content><![CDATA[{$value_arr[0]}]]></Content>
<FuncFlag>{$o_arr}</FuncFlag>";
                break;

            case "news" :
                $con.="<ArticleCount>{$o_arr[0]}</ArticleCount>
<Articles>";
                foreach ($value_arr as $id => $v) {
                    if ($id >= $o_arr[0])
                        break; else
                        null; //判断数组数不超过设置数
                    $con.="<item>
<Title><![CDATA[{$v[0]}]]></Title> 
<Description><![CDATA[{$v[1]}]]></Description>
<PicUrl><![CDATA[{$v[2]}]]></PicUrl>
<Url><![CDATA[{$v[3]}]]></Url>
</item>";
                }
                $con.="</Articles>
<FuncFlag>{$o_arr[1]}</FuncFlag>";
                break;
        } //end switch
//=================end return============
        echo $con . "</xml>";
    }

    private function checkSignature() {
        $signature = $_GET["signature"];
        $timestamp = $_GET["timestamp"];
        $nonce = $_GET["nonce"];

        $token = TOKEN;
        $tmpArr = array($token, $timestamp, $nonce);
        sort($tmpArr);
        $tmpStr = implode($tmpArr);
        $tmpStr = sha1($tmpStr);

        if ($tmpStr == $signature) {
            return true;
        } else {
            return false;
        }
    }

}

?>