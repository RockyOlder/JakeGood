<?php
	$api_path = str_replace(array('search_product\index.php', 'search_product/index.php'), '', __FILE__);
	include_once($api_path.'config.php');
	include_once($api_path.'lib/tools.php');
	include_once($api_path.'lib/page.Class.php');
	
	header("Content-Type:text/html;charset=UTF-8");
//	include_once($api_path.'check_auth.php');
	/* Build By fhalipay */
	
	$domain      = empty($_REQUEST['domain'])    ? '' : $_REQUEST['domain'];
	$nickname    = empty($_REQUEST['nickname'])  ? '' : $_REQUEST['nickname'];
	$orderType   = empty($_REQUEST['orderType']) ? '' : $_REQUEST['orderType'];
	$category_id   = empty($_REQUEST['category_id']) ? '' : $_REQUEST['category_id'];
	$page   = empty($_REQUEST['page']) ? 1 : intval($_REQUEST['page']);
	
	$domain = str_replace('http://', '', $domain);
	$domain = str_replace('/', '', $domain);
	
	if ($domain != '')
	{
		$url = "http://{$domain}/search.htm?pageNo={$page}&search=y&orderType={$orderType}&tsearch=y";
		
		$body = Tools::curl($url);
		
		
		
		if (strpos($domain, 'tmall.com') !== FALSE)
		{
			//分页开始截取
			$body = substr($body, strpos($body, '<b class="ui-page-s-len">'));
			//items 结束
			$body = substr($body, 0, strpos($body, 'id="ft"'));
			
			//取出总页数	// <b class="ui-page-s-len">1/2</b>
			$pages = strip_tags(substr($body, 0, strpos($body, '</b>')));
			$total_page = substr(strrchr($pages, "/"), 1);
			$pattern = '/data\-id="(?<num_iid>.*)">[\s\S]*<img alt="(?<title>.*)" data\-ks\-lazyload="(?<img>.*)" [^>]*>[\s\S]*<span class="c\-price">(?<price>.*)<\/span>/iU';
		}
		else
		{
			//分页开始截取
			$body = substr($body, strpos($body, '<div class="pagination pagination-mini">'));
			
			//items 结束
			$body = substr($body, 0, strpos($body, 'id="ft"'));
			
			//取出总页数	// <b class="ui-page-s-len">1/2</b>
			$pages = strip_tags(substr($body, 0, strpos($body, '</span>')));
			$total_page = substr(strrchr($pages, "/"), 1);
			
			$pattern = '/data\-id="(?<num_iid>.*)">[\s\S]*<img alt="(?<title>.*)"  data\-ks\-lazyload="(?<img>.*)" [^>]*>[\s\S]*<span class="c\-price">(?<price>.*)<\/span>/iU';
		}
		
		preg_match_all($pattern, $body, $matchs, PREG_SET_ORDER);
		
		$TaobaoItems = $matchs;
		$Total_results = $total_page * count($matchs);
		$page_size = count($matchs);
	}
	include_once('search.php');
	include_once('items.php');
?>