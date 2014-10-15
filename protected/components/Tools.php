<?php

class Tools {

	/**
	 * get client ip address
	 * @return
	 * IP address string
	 */
	public static function get_ip()
	{
	    if (getenv('HTTP_CLIENT_IP'))
	    {
        	$ip = getenv('HTTP_CLIENT_IP');
        }
        elseif (getenv('HTTP_X_FORWARDED_FOR'))
        {
        	$ip = getenv('HTTP_X_FORWARDED_FOR');
        }
        elseif (getenv('HTTP_X_FORWARDED'))
        {
        	$ip = getenv('HTTP_X_FORWARDED');
        }
        elseif (getenv('HTTP_FORWARDED_FOR'))
        {
        	$ip = getenv('HTTP_FORWARDED_FOR');
        }
        elseif (getenv('HTTP_FORWARDED'))
        {
        	$ip = getenv('HTTP_FORWARDED');
        }
        elseif(PHP_SAPI == 'cli')
        {
        	$ip = "202.96.134.133";
        }
        else
        {
        	$ip = $_SERVER['REMOTE_ADDR'];
        }
        return $ip;
	}
	/**
	 *
	 * @param  $data
	 * XML Data String
	 * @return SimpleXMLElement
	 */
	public static function parse_xml($data)
	{
		return simplexml_load_string($data,'SimpleXMLElement', LIBXML_NOCDATA);
	}
	/**
	 * convert an object to xml format
	 * @param  $array
	 * @param  $root
	 * @param  $cdata
	 * @param  $item
	 */
	public static function array2xml($array,$root = "root",$cdata=array(),$item = 'item')
	{
		if(empty($array))
		{
			return false;
		}
		
		$dom = new DOMDocument('1.0', 'UTF-8');
		$item = $dom->createElement($root); 
		$dom->appendChild($item);
		
		$xml =  self::array_2xml($array, $dom, $item);
		
		return $xml;
	}
	/**
	 * iterate for to_xml
	 * @param  $source
	 * @param  $cdata
	 * @param  $item
	 */
	private static function array_2xml($arr, $dom=0, $item=0, $cdata = array(), $element = 'item')
	{
		foreach ($arr as $key => $val)
		{
			$itemx = $dom->createElement(is_string($key) ? $key : $element);
			$item->appendChild($itemx);
			if (!is_array($val) && ! is_object($val))
			{
				if(in_array($key, $cdata)) $val = "<![CDATA[".$val."]]>";
				$text = $dom->createTextNode($val);
				$itemx->appendChild($text);
			}
			else
			{
				self::array_2xml($val, $dom, $itemx, $cdata, $element);
			}
		}
		return $dom->saveXML();
	}
	/**
	 *
	 * Object to Array
	 * @param  $object
	 * @return
	 * ArrayObject
	 */
	public static function object2array($object)
	{
		return @json_decode(@json_encode($object),1);
	}
	/**
	 * CURL Data collector which is a simulation browser
	 *
	 */
	public static function curl($url,$param = array(),$lifetime = 3600, $referer = NULL, $ua = NULL)
	{
		
		$body = "";
		
		//curl传入的参数优先级最高
		$param = array_merge($_GET,$param);

		$url_array = parse_url($url);
		
		if(isset($url_array['query']))
		{
			parse_str($url_array['query'],$url_param);

			//$url_param优先级最低
			$param = array_merge($url_param,$param);
		}
		
		$key = $url.implode('-',$param);
		
		$url_array['query'] = http_build_query($param);
		
		$url = self::unparse_url($url_array);
		
		$ua == NULL && $ua = self::_gen_ua();
		
		if(isset($_GET['nocache']) || ! $body)
		{
			$ip = self::get_ip();
			$headers['CLIENT-IP'] = $ip;
			$headers['X-FORWARDED-FOR'] = $ip;
			$headers['REMOTE_ADDR'] = $ip;
			
			$header_arr = array();
			foreach( $headers as $n => $v ) 
			{
				$header_arr[] = $n .':' . $v;
			}
			$ch = curl_init();
			curl_setopt($ch, CURLOPT_URL, $url);
			curl_setopt($ch, CURLOPT_HTTPHEADER , $header_arr );
			curl_setopt($ch, CURLOPT_REFERER, $referer);
			curl_setopt($ch,CURLOPT_USERAGENT,$ua);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 3);
			curl_setopt($ch, CURLOPT_ENCODING, '');
		//	curl_setopt($ch, CURLOPT_TIMEOUT, 3);
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
			curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
			curl_setopt($ch, CURLOPT_FOLLOWLOCATION,1);
			$body = curl_exec($ch);	
			curl_close ($ch);
		}

		return  $body;
	}

	/**
	 * revert parse_url
	 * @param  $parsed_url
	 */
	private static function unparse_url($parsed_url) 
	{ 
		$scheme   = isset($parsed_url['scheme']) ? $parsed_url['scheme'] . '://' : '';
		$host     = isset($parsed_url['host']) ? $parsed_url['host'] : '';
		$port     = isset($parsed_url['port']) ? ':' . $parsed_url['port'] : '';
		$user     = isset($parsed_url['user']) ? $parsed_url['user'] : '';
		$pass     = isset($parsed_url['pass']) ? ':' . $parsed_url['pass']  : '';
		$pass     = ($user || $pass) ? "$pass@" : '';
		$path     = isset($parsed_url['path']) ? $parsed_url['path'] : '';
		$query    = isset($parsed_url['query']) ? '?' . $parsed_url['query'] : '';
		$fragment = isset($parsed_url['fragment']) ? '#' . $parsed_url['fragment'] : '';
		return "$scheme$user$pass$host$port$path$query$fragment";
	}
	/**
	 * Generate a random ua string
	 * @return string
	 * UA String
	 */
	private static function _gen_ua()
	{
		$ua[] = "Mozilla/5.0 (Windows NT 5.1) AppleWebKit/535.11 (KHTML, like Gecko) Chrome/17.0.963.79 Safari/535.11";
		$ua[] = "Mozilla/5.0 (Windows; U; Windows NT 5.1; zh-CN; rv:1.9.2.19) Gecko/20110707 Firefox/3.6.19";
		$ua[] = "Mozilla/5.0 (Windows NT 6.1) AppleWebKit/535.19 (KHTML, like Gecko) Chrome/18.0.1025.168 Safari/535.19";
		$ua[] = "Mozilla/4.0 (compatible; MSIE 8.0; Windows NT 6.1; Trident/4.0; SLCC2; .NET CLR 2.0.50727; .NET CLR 3.5.30729; .NET CLR 3.0.30729; InfoPath.3; .NET4.0C; Tablet PC 2.0)";
		$ua[] = "Mozilla/4.0 (compatible; MSIE 7.0; Windows NT 6.1; Trident/4.0; SLCC2; .NET CLR 2.0.50727; .NET CLR 3.5.30729; .NET CLR 3.0.30729; InfoPath.3; .NET4.0C; Tablet PC 2.0; SE 2.X MetaSr 1.0)";
		$rand = count($ua)-1;
		return $ua[rand(0,$rand)]	;
	}



	public static function pinyin($_String, $_Code='gb2312',$isFirstCode=false)
	{
		$_DataKey = "a|ai|an|ang|ao|ba|bai|ban|bang|bao|bei|ben|beng|bi|bian|biao|bie|bin|bing|bo|bu|ca|cai|can|cang|cao|ce|ceng|cha".
					"|chai|chan|chang|chao|che|chen|cheng|chi|chong|chou|chu|chuai|chuan|chuang|chui|chun|chuo|ci|cong|cou|cu|".
					"cuan|cui|cun|cuo|da|dai|dan|dang|dao|de|deng|di|dian|diao|die|ding|diu|dong|dou|du|duan|dui|dun|duo|e|en|er".
					"|fa|fan|fang|fei|fen|feng|fo|fou|fu|ga|gai|gan|gang|gao|ge|gei|gen|geng|gong|gou|gu|gua|guai|guan|guang|gui".
					"|gun|guo|ha|hai|han|hang|hao|he|hei|hen|heng|hong|hou|hu|hua|huai|huan|huang|hui|hun|huo|ji|jia|jian|jiang".
					"|jiao|jie|jin|jing|jiong|jiu|ju|juan|jue|jun|ka|kai|kan|kang|kao|ke|ken|keng|kong|kou|ku|kua|kuai|kuan|kuang".
					"|kui|kun|kuo|la|lai|lan|lang|lao|le|lei|leng|li|lia|lian|liang|liao|lie|lin|ling|liu|long|lou|lu|lv|luan|lue".
					"|lun|luo|ma|mai|man|mang|mao|me|mei|men|meng|mi|mian|miao|mie|min|ming|miu|mo|mou|mu|na|nai|nan|nang|nao|ne".
					"|nei|nen|neng|ni|nian|niang|niao|nie|nin|ning|niu|nong|nu|nv|nuan|nue|nuo|o|ou|pa|pai|pan|pang|pao|pei|pen".
					"|peng|pi|pian|piao|pie|pin|ping|po|pu|qi|qia|qian|qiang|qiao|qie|qin|qing|qiong|qiu|qu|quan|que|qun|ran|rang".
					"|rao|re|ren|reng|ri|rong|rou|ru|ruan|rui|run|ruo|sa|sai|san|sang|sao|se|sen|seng|sha|shai|shan|shang|shao|".
					"she|shen|sheng|shi|shou|shu|shua|shuai|shuan|shuang|shui|shun|shuo|si|song|sou|su|suan|sui|sun|suo|ta|tai|".
					"tan|tang|tao|te|teng|ti|tian|tiao|tie|ting|tong|tou|tu|tuan|tui|tun|tuo|wa|wai|wan|wang|wei|wen|weng|wo|wu".
					"|xi|xia|xian|xiang|xiao|xie|xin|xing|xiong|xiu|xu|xuan|xue|xun|ya|yan|yang|yao|ye|yi|yin|ying|yo|yong|you".
					"|yu|yuan|yue|yun|za|zai|zan|zang|zao|ze|zei|zen|zeng|zha|zhai|zhan|zhang|zhao|zhe|zhen|zheng|zhi|zhong|".
					"zhou|zhu|zhua|zhuai|zhuan|zhuang|zhui|zhun|zhuo|zi|zong|zou|zu|zuan|zui|zun|zuo";

					$_DataValue = "-20319|-20317|-20304|-20295|-20292|-20283|-20265|-20257|-20242|-20230|-20051|-20036|-20032|-20026|-20002|-19990".
					"|-19986|-19982|-19976|-19805|-19784|-19775|-19774|-19763|-19756|-19751|-19746|-19741|-19739|-19728|-19725".
					"|-19715|-19540|-19531|-19525|-19515|-19500|-19484|-19479|-19467|-19289|-19288|-19281|-19275|-19270|-19263".
					"|-19261|-19249|-19243|-19242|-19238|-19235|-19227|-19224|-19218|-19212|-19038|-19023|-19018|-19006|-19003".
					"|-18996|-18977|-18961|-18952|-18783|-18774|-18773|-18763|-18756|-18741|-18735|-18731|-18722|-18710|-18697".
					"|-18696|-18526|-18518|-18501|-18490|-18478|-18463|-18448|-18447|-18446|-18239|-18237|-18231|-18220|-18211".
					"|-18201|-18184|-18183|-18181|-18012|-17997|-17988|-17970|-17964|-17961|-17950|-17947|-17931|-17928|-17922".
					"|-17759|-17752|-17733|-17730|-17721|-17703|-17701|-17697|-17692|-17683|-17676|-17496|-17487|-17482|-17468".
					"|-17454|-17433|-17427|-17417|-17202|-17185|-16983|-16970|-16942|-16915|-16733|-16708|-16706|-16689|-16664".
					"|-16657|-16647|-16474|-16470|-16465|-16459|-16452|-16448|-16433|-16429|-16427|-16423|-16419|-16412|-16407".
					"|-16403|-16401|-16393|-16220|-16216|-16212|-16205|-16202|-16187|-16180|-16171|-16169|-16158|-16155|-15959".
					"|-15958|-15944|-15933|-15920|-15915|-15903|-15889|-15878|-15707|-15701|-15681|-15667|-15661|-15659|-15652".
					"|-15640|-15631|-15625|-15454|-15448|-15436|-15435|-15419|-15416|-15408|-15394|-15385|-15377|-15375|-15369".
					"|-15363|-15362|-15183|-15180|-15165|-15158|-15153|-15150|-15149|-15144|-15143|-15141|-15140|-15139|-15128".
					"|-15121|-15119|-15117|-15110|-15109|-14941|-14937|-14933|-14930|-14929|-14928|-14926|-14922|-14921|-14914".
					"|-14908|-14902|-14894|-14889|-14882|-14873|-14871|-14857|-14678|-14674|-14670|-14668|-14663|-14654|-14645".
					"|-14630|-14594|-14429|-14407|-14399|-14384|-14379|-14368|-14355|-14353|-14345|-14170|-14159|-14151|-14149".
					"|-14145|-14140|-14137|-14135|-14125|-14123|-14122|-14112|-14109|-14099|-14097|-14094|-14092|-14090|-14087".
					"|-14083|-13917|-13914|-13910|-13907|-13906|-13905|-13896|-13894|-13878|-13870|-13859|-13847|-13831|-13658".
					"|-13611|-13601|-13406|-13404|-13400|-13398|-13395|-13391|-13387|-13383|-13367|-13359|-13356|-13343|-13340".
					"|-13329|-13326|-13318|-13147|-13138|-13120|-13107|-13096|-13095|-13091|-13076|-13068|-13063|-13060|-12888".
					"|-12875|-12871|-12860|-12858|-12852|-12849|-12838|-12831|-12829|-12812|-12802|-12607|-12597|-12594|-12585".
					"|-12556|-12359|-12346|-12320|-12300|-12120|-12099|-12089|-12074|-12067|-12058|-12039|-11867|-11861|-11847".
					"|-11831|-11798|-11781|-11604|-11589|-11536|-11358|-11340|-11339|-11324|-11303|-11097|-11077|-11067|-11055".
					"|-11052|-11045|-11041|-11038|-11024|-11020|-11019|-11018|-11014|-10838|-10832|-10815|-10800|-10790|-10780".
					"|-10764|-10587|-10544|-10533|-10519|-10331|-10329|-10328|-10322|-10315|-10309|-10307|-10296|-10281|-10274".
					"|-10270|-10262|-10260|-10256|-10254";

		$_TDataKey = explode('|', $_DataKey);
		$_TDataValue = explode('|', $_DataValue);

		$_Data = array_combine($_TDataKey, $_TDataValue);
		arsort($_Data);
		reset($_Data);

		if($_Code != 'gb2312') $_String = Tools::_U2_Utf8_Gb($_String);

		$_Res = '';
		for($i=0; $i<strlen($_String); $i++)
		{
			$_P = ord(substr($_String, $i, 1));
			if($_P>160) { $_Q = ord(substr($_String, ++$i, 1)); $_P = $_P*256 + $_Q - 65536; }
			if ( ! $isFirstCode)
			{
				$_Res .= Tools::_Pinyin($_P, $_Data);
			}
			else
			{
				$str = Tools::_Pinyin($_P, $_Data);
				$_Res .= substr($str, 0, 1);
			}
		}

		return preg_replace("/[^a-z0-9A-Z]/", '', $_Res);
	}




	private static function _Pinyin($_Num, $_Data)
	{
		if ($_Num>0 && $_Num<160 ) return chr($_Num);
		elseif($_Num<-20319 || $_Num>-10247) return '';
		else
		{
			foreach($_Data as $k=>$v)
			{
				if($v<=$_Num) break; 
			}
			return $k;
		}
	}



	private static function _U2_Utf8_Gb($_C)
	{
		$_String = '';
		if($_C < 0x80) $_String .= $_C;
		elseif($_C < 0x800)
		{
		$_String .= chr(0xC0 | $_C>>6);
		$_String .= chr(0x80 | $_C & 0x3F);
		}elseif($_C < 0x10000){
		$_String .= chr(0xE0 | $_C>>12);
		$_String .= chr(0x80 | $_C>>6 & 0x3F);
		$_String .= chr(0x80 | $_C & 0x3F);
		} elseif($_C < 0x200000) {
		$_String .= chr(0xF0 | $_C>>18);
		$_String .= chr(0x80 | $_C>>12 & 0x3F);
		$_String .= chr(0x80 | $_C>>6 & 0x3F);
		$_String .= chr(0x80 | $_C & 0x3F);
		}
		return iconv('UTF-8', 'GB2312//IGNORE', $_String);
	}



	private static function _Array_Combine($_Arr1, $_Arr2)
	{
		for($i=0; $i<count($_Arr1); $i++) $_Res[$_Arr1[$i]] = $_Arr2[$i];
		return $_Res;
	}
	
	/**
	 * 强制下载文件
	 * @param Array $arr
	 * @return string
	 */
	public static function force_download($file_path,$filename=NULL)
	{

		$filename || $filename  = substr(strrchr($file_path, '/'), 1); 
		// $ext = substr(strrchr($filename, '.'), 1); 
		header('Content-Type: application/octet-stream');
		header('Content-Description: File Transfer');
		header('Content-Disposition: attachment; filename=' . $filename);
		header('Pragma: public');
        header('Content-Type: application/octet-stream');
        header('Content-Length: ' . filesize($file_path));
        ob_clean();
        flush();
        readfile($file_path);
        exit;
	}

	public static function hashPassword($password)
	{
		return hash_hmac('sha1', $password, 'alina$epay');
	}
	public static function hashPayPassword($password)
	{
		return hash_hmac('sha1', $password, 'pay@alina');
	}
}