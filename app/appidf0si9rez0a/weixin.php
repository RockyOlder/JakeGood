<?php
/** 
  * 微信API 有道翻译查询
  *
  * 今天视频很晚才录了，上班小累，所以视频讲的有点长，见谅！！
  */

//define your token
define("TOKEN", "wxfanyi");
$weixin = new weixin();

if(isset($_GET['echostr'])){
    $weixin->valid();
}else{
    $weixin->responseMsg();
}

class weixin
{
	public function valid()
    {
        $echoStr = $_GET["echostr"];

        //valid signature , option
        if($this->checkSignature()){
        	echo $echoStr;
        	exit;
        }
    }

    public function responseMsg()
    {
		//get post data, May be due to the different environments
		$postStr = $GLOBALS["HTTP_RAW_POST_DATA"];

      	//extract post data
		if (!empty($postStr)){
                
              	$postObj = simplexml_load_string($postStr, 'SimpleXMLElement', LIBXML_NOCDATA);
                $fromUsername = $postObj->FromUserName;//用户openid
                $toUsername = $postObj->ToUserName;//微信公众号id
                $keyword = trim($postObj->Content);//用户发送的信息
                $time = time();//用户发送信息的时间戳
                $textTpl = "<xml>
							<ToUserName><![CDATA[%s]]></ToUserName>
							<FromUserName><![CDATA[%s]]></FromUserName>
							<CreateTime>%s</CreateTime>
							<MsgType><![CDATA[%s]]></MsgType>
							<Content><![CDATA[%s]]></Content>
							<FuncFlag>0</FuncFlag>
							</xml>";  

				//例如： 翻译你好
                
                if(mb_substr($keyword, 0, 2, 'UTF-8') == '翻译')
                {
                    $fanyi = mb_substr($keyword, 0, 2, 'UTF-8');//翻译
                    $word = str_replace($fanyi, '', $keyword);//你好
                    $key = '330102425';
                    $keyfrom = 'qiyunkj';
                    $url = 'http://fanyi.youdao.com/openapi.do?keyfrom='.$keyfrom.'&key='.$key.'&type=data&doctype=json&version=1.1&q=' . urlencode($word);//有道翻译API
                    
                    $fanyiJson = file_get_contents($url);//获取url数据,返回Json数据
                    
                    $fanyiArr = json_decode($fanyiJson, true);//json 转换成 数组
                	
                    $contentStr = "【查询】\n" . $fanyiArr['query'] . "\n【翻译】\n" . $fanyiArr['translation'][0];//拼接返回给用户的字符串
                    
                    //扩展翻译
                    if(isset($fanyiArr['web'])){
                        $extension = "\n【扩展翻译】";
                        
                        $arr = $fanyiArr['web'][0]['value'];
                        $n = 1;
                        foreach($arr as $v){
                            $extension .= "\n" . $n . '、' . $v;
                            $n++;
                        }

                    }else{
                        $extension = '';
                    }

                    $contentStr .= $extension;//拼接扩展查询

                    $msgType = "text";

                	$resultStr = sprintf($textTpl, $fromUsername, $toUsername, $time, $msgType, $contentStr);

                	echo $resultStr;
                }else{
                	echo "Input something...";
                }

        }else {
        	echo "";
        	exit;
        }
    }
		
	private function checkSignature()
	{
        $signature = $_GET["signature"];
        $timestamp = $_GET["timestamp"];
        $nonce = $_GET["nonce"];	
        		
		$token = TOKEN;
		$tmpArr = array($token, $timestamp, $nonce);
		sort($tmpArr, SORT_STRING);//1. 将token、timestamp、nonce三个参数进行字典序排序
		$tmpStr = implode( $tmpArr );
		$tmpStr = sha1( $tmpStr );//2. 将三个参数字符串拼接成一个字符串进行sha1加密
		
		if( $tmpStr == $signature ){//3. 开发者获得加密后的字符串可与signature对比，标识该请求来源于微信
			return true;
		}else{
			return false;
		}
	}
}

?>