<?php

class TaobaoFunc extends CComponent {

	public $config = array();
	public function init()
	{

	}
	//签名函数 
	public function createSign ($paramArr, $appSecret)
	{
		
	    $sign = $appSecret; 
	    ksort($paramArr); 
	    foreach ($paramArr as $key => $val)
	    { 
	       if ($key !='' && $val !='') 
	       { 
	           $sign .= $key.$val; 
	       } 
	    }
	    
	    $sign = strtoupper(md5($sign.$appSecret));
	    return $sign; 
	}

	//组参函数 
	public function createStrParam ($paramArr) 
	{ 
	    $strParam = ''; 
	    foreach ($paramArr as $key => $val) 
	    { 
	       if ($key != '' && $val !='') 
	       { 
	           $strParam .= $key.'='.urlencode($val).'&'; 
	       } 
	    } 
	    return $strParam; 
	} 

	//解析xml函数
	public function getXmlData ($strXml) 
	{
		$pos = strpos($strXml, 'xml');
		if ($pos) 
		{
			$xmlCode=simplexml_load_string($strXml,'SimpleXMLElement', LIBXML_NOCDATA);
			$arrayCode=self::get_object_vars_final($xmlCode);
			return $arrayCode ;
		} 
		else 
		{
			return '';
		}
	}
	
	private function get_object_vars_final($obj)
	{
		if(is_object($obj))
		{
			$obj=get_object_vars($obj);
		}
		if(is_array($obj))
		{
			foreach ($obj as $key=>$value)
			{
				$obj[$key]=self::get_object_vars_final($value);
			}
		}
		return $obj;
	}
}