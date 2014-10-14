<?php
class Db{
	
	private $host="localhost";
    private $name="root";
    private $pw="885";
    private $dbName="db_ku";
    private $linkData;
	//DB类  看需求  1 连接数据库  2 一个执行SQL方法  3 提取结果集的方法  4 统计结果集行数的方法
	
	public function __construct(){
		
		$this->linkData = mysql_connect($this->host,$this->name,$this->pw) or die("错误是".mysql_error());
		mysql_select_db($this->dbName);
		mysql_query("set names utf8");
		
	}
	
	
	public function query($strData){
		
		if(!empty($strData)){
			$mixData = mysql_query($strData);
			return $mixData;
		}
	}
	
	
	public function getData($resData){
		
		$intData = $this->getRows($resData);
		
		if($intData){
		
			while($arrData = mysql_fetch_assoc($resData)){
				
				$arrData1[] = $arrData;
				
			}
			
			unset($resData);
			
			return $arrData1;
		
		}else{
			
			die("结果集没数据");
		}
	}
	
	public function getRows($resData){
		
		$intData = mysql_num_rows($resData);
		return $intData;
	}
	
	
	public function __destruct(){
		
		mysql_close($this->linkData);
	}
	
}