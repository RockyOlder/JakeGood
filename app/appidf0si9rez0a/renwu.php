<?php 
/*
 思路
 连接数据库
 查询商品表得到商名称/库存/还有价格
 
 得到数组后
 循环打印tr
 */

$dbname = 'hSLmJHmOzzTlUJOTawWC';
/*填入数据库连接信息*/
$host = 'sqld.duapp.com';
$port = 4050;
$user = 'LNGcZBwRTchp4wSmCDIrGBNY';//用户名(api key)
$pwd = 'y29RaXChUx9mpm3XToBKiCGTMYWksN9O';//密码(secret key)
 /*以上信息都可以在数据库详情页查找到*/
 
/*接着调用mysql_connect()连接服务器*/
$conn = @mysql_connect("{$host}:{$port}",$user,$pwd,true);
if(!$conn) {
    die("Connect Server Failed: " . mysql_error());
}
/*连接成功后立即调用mysql_select_db()选中需要连接的数据库*/
if(!mysql_select_db($dbname,$conn)) {
    die("Select Database Failed: " . mysql_error($conn));
}

$sql='select goods_name,cat_id,goods_number,shop_price from goods';
$rs=mysql_query($sql,$conn);

$list = array();
while ($row= mysql_fetch_assoc($rs)){
	$list[]=$row;
}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>aaa </title>

</head>

<body>
<h1>我也会做报价单</h1>
   <table border="1">
      <tr>
        <td>商品名称</td>
        <td>商品栏目</td>
        <td>商品库存</td>
        <td>商品价格</td>
      </tr>
        <?php foreach ($list as $v){?>
      <tr>
        <td><?php echo $v['goods_name'];?></td>
        <td><?php echo $v['cat_id'];?></td>
        <td><?php echo $v['goods_number'];?></td>
        <td><?php echo $v['shop_price'];?></td>
      </tr>
      <?php }?>
   </table>
</body>
</html>

