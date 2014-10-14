<?php
//告诉浏览器不要缓存数据
//header("Content-Type: text/html;charset=utf-8");
//header("Cahe-Control: no-cache");
//接受数据
$username=$_POST['username'];
//$username=$_GET['username'];
//echo "服务器返回的是 ".$username;
/*if ($username=='shuige'){
	echo '很帅';//注意，这里数据是返回给请求的页面
}
else{
	echo '非常帅';
}
*/
//这里 $info 是一个json数据格式的字符串
$info="";
if ($username=='shuige'){
	$info='{"res":"该用户不可以用"}';//注意，这里数据是返回给请求的页面
}
else{
$info='{"res":"用户可以用"}';
}
echo $info;
?>
