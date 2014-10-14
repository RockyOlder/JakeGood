<?php
require_once 'db_class.php';

$strData =$_POST['data'];

$sql ="select sname from test15 where sname='{$strData}'";

$db = new Page();
$resData = $db->query($sql);
$intData = $db->getRows($resData);

 if($intData){
	
	echo 1;
	
}else{
	
	echo 2;
}





?>