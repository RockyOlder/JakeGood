<?php
require_once 'db_class.php';
$post=$_POST['data'];
$sql="select sname from test15 where sname='{$post}'";
$li= new Page();

$qq=$li->query($sql);
$inData=$li->getRows($qq);

if ($inData){
	echo 1;
}
else{
	echo 2;
}











?>