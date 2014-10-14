<?php

/*
	分享者：简约
		QQ：524828673

	分享内容：开发模式
		1、微信url、token对接
		2、关键词回复
		3、关注时回复

	前期准备：
		1、微信公众号，注册地址：https://mp.weixin.qq.com/
		2、空间，域名，FTP上传工具
		3、懂PHP语言，懂得看微信官方文档（你就可以入门了）本人也是刚入门 ^_^

	微信公众号 与 个人微信号 的区别：
		我发现有很多人，把微信公众号和个人微信号混为一谈，完全不知道微信公众号是个甚么东西。据我了解如下：
		1、微信公众号只能够在PC端登录，只能被关注；
		   而个人微信号只能在手机端登录，可关注微信公众号

	公众号的区别：
		1、微信公众号分为：订阅号、服务号
		2、订阅号：每天可群发一条消息，仅有基础接口（如：接收用户消息、向用户回复消息...）
		   服务号：每月可群发一条消息，拥有高级接口（如：自定义菜单...）

	文档地址：
	http://mp.weixin.qq.com/wiki/index.php?title=%E9%AA%8C%E8%AF%81%E6%B6%88%E6%81%AF%E7%9C%9F%E5%AE%9E%E6%80%A7
*/

define('TOKEN', 'gongyiphp');

$wx = new weixin();

if($_GET['echostr']){
	$wx->valid();
}else{
	$wx->responseMsg();
}


class weixin{
	//回复用户消息
	public function responseMsg(){
		$postStr = $GLOBALS["HTTP_RAW_POST_DATA"];

		if (!empty($postStr)){

			$postObj = simplexml_load_string($postStr, 'SimpleXMLElement', LIBXML_NOCDATA);
			//simplexml_load_string() 函数把 XML 字符串载入对象中

			$fromUsername = $postObj->FromUserName;//用户openid

			$toUsername = $postObj->ToUserName; //公众号id

			$keyword = trim($postObj->Content); //用户发送的消息内容

			$textTpl = "<xml>
						<ToUserName><![CDATA[%s]]></ToUserName>
						<FromUserName><![CDATA[%s]]></FromUserName>
						<CreateTime>%s</CreateTime>
						<MsgType><![CDATA[%s]]></MsgType>
						<Content><![CDATA[%s]]></Content>
						<FuncFlag>0</FuncFlag>
						</xml>";



			//获取事件类型
			$MsgType = $postObj->MsgType;

			//关注时回复
			if($MsgType == 'event'){
				if($postObj->Event == 'subscribe'){
					$msgtype = 'text';
					$contentStr = "这个是关注事件，欢迎关注，公益PHP\n官网：http://www.zixue.it";
					$resultStr = sprintf($textTpl, $fromUsername, $toUsername, time(), $msgtype, $contentStr);
					echo $resultStr;
					exit;
				}
			}

			//关键词回复
			if($keyword == '你好'){
				$msgtype = 'text';
				$contentStr = "你好我好大家好";
				$resultStr = sprintf($textTpl, $fromUsername, $toUsername, time(), $msgtype, $contentStr);
				echo $resultStr;
				exit;
			}else{
				$msgtype = 'text';
				$contentStr = "这个不是关键词回复的内容";
				$resultStr = sprintf($textTpl, $fromUsername, $toUsername, time(), $msgtype, $contentStr);
				echo $resultStr;
				exit;
			}


		}

	}

	public function valid()
    {
        $echoStr = $_GET["echostr"];

        //valid signature , option
        if($this->checkSignature()){
        	echo $echoStr;
        	exit;
        }
    }

    /*
		视频中以下 注释： 1 2 3 错了！
		注释已修改
	*/
	private function checkSignature()
	{
        $signature = $_GET["signature"];
        $timestamp = $_GET["timestamp"];
        $nonce = $_GET["nonce"];	
        		
		$token = TOKEN;
		$tmpArr = array($token, $timestamp, $nonce);
		sort($tmpArr);					//1. 将token、timestamp、nonce三个参数进行字典序排序
		$tmpStr = implode( $tmpArr );	
		$tmpStr = sha1( $tmpStr );		//2. 将三个参数字符串拼接成一个字符串进行sha1加密
		
		if( $tmpStr == $signature ){//3. 开发者获得加密后的字符串可与signature对比，标识该请求来源于微信
			return true;
		}else{
			return false;
		}
	}

	


}

?>




