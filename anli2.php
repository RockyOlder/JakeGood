<?php
//告诉浏览器不要缓存数据
header("Content-Type: text/xml;charset=utf-8");
//header("Cache-Control: no-cache");
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
if ($username=='shuige'){
	echo "<res><mes>用户名不可以用，对不起</mes></res>";//注意，这里数据是返回给请求的页面
}
else{
		echo "<res><mes>用户名可以用</mes></res>";
}
?>
