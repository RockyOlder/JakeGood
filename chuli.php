<?php
	header("Content-Type: text/xml;charset=utf-8");
	//告诉浏览器不要缓存数据
	header("Cache-Control: no-cache");

//接受   用户的选择的省的名字
$province=$_POST['province'];
   
  // file_put_contents("C:/Users/Administrator/Desktop/web开发/chesi.log",$province."\r\n",FILE_APPEND); 
   //到数据库去查询省有哪些城市()
	$provinceName=$_post['sheng'];
	
	//准备返回xml格式的结果..
$info="";
if ($username=='shuige'){
	$info='{"res":"数据","rdd":"汉子","rqq":"妹子"}';//注意，这里数据是返回给请求的页面
}
else{
$info='{"res":"尼玛","rdd":"挖吧","rqq":"去刷"}';//注意，这里数据是返回给请求的页面
}
echo $info;




?>