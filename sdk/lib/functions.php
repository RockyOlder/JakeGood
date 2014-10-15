<?php

	
	//签名函数 
	function createSign ($paramArr, $appSecret)
	{
		
	    $sign = $appSecret; 
	    ksort($paramArr); 

	    foreach ($paramArr as $key => $val)
		{ 
			if (is_array($val))
			{
				foreach ($val as $k => $items)
				{
					ksort($items); 
					foreach ($items as $k2 => $item)
					{
						if ($k2 != '' && $item != '')
	     				{
							 $sign .= $k.$k2.$item; 
						}
					}
				}
			}
			elseif ($key != '' && $val !='')
			{
				 $sign .= $key.$val; 
			}
		}
	    $sign = strtoupper(md5($sign.$appSecret));
	    return $sign; 
	}

	//组参函数 
	function createStrParam ($paramArr)
	{ 
		$strParam = ''; 
		foreach ($paramArr as $key => $val)
		{ 
			if (is_array($val))
			{
				foreach ($val as $k => $items)
				{
					foreach ($items as $k2 => $item)
					{
						if ($k2 != '' && $item !='')
						{
							$strParam .= $key.'['.$k.']['.$k2.']='.urlencode($item).'&'; 
						}
					}
				}
			}
			elseif ($key != '' && $val !='')
			{
				$strParam .= $key.'='.urlencode($val).'&'; 
			} 
		}  
		return $strParam; 
	}

	//解析xml函数
	function getXmlData ($strXml)
	{
		$pos = strpos($strXml, 'xml');
		if ($pos)
		{
			$xmlCode   = simplexml_load_string($strXml,'SimpleXMLElement', LIBXML_NOCDATA);
			$arrayCode = get_object_vars_final($xmlCode);
			return $arrayCode ;
		}
		else
		{
			return '';
		}
	}
?>