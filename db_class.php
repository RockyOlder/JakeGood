<?php
class Page{
	   private $host='127.0.0.1';
	   private $name='root';
	   private $pw='885';
	   private $db_name='use cookbook';
	   private $conn;
	public function __construct(){
		$this->conn=mysql_connect($this->host,$this->name,$this->pw);
		 mysql_query($this->db_name,$this->conn);
		mysql_query("set names utf8");
	}
	public function query($sql){
		return mysql_query($sql,$this->conn);
	}
	public function setChar($char){
		$sql  = 'set names'.$char;
		$this->query($sql);
	}
	
	public function getAll($sql){
		$list=array();
		
			while ($row=mysql_fetch_assoc($sql)){
				$list[]=$row;
			
		}
		return $list;
	}
	public function getRows($resData){
		
		$intData = mysql_num_rows($resData);
		return $intData;
	}
}
$mysql = new Page();

$sql='select * from goods';

$page=new Page();
print_r($page);

?>
