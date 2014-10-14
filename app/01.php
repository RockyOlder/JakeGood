<?php    
//header('Content-Type:text/html;charset=utf-8');


                 $keyword='翻译香蕉';
				
                    $fanyi = mb_substr($keyword, 0, 2, 'UTF-8');//翻译
                    $word = str_replace($fanyi, '', $keyword);//你好
					// echo $word;exit;
                    $key = '330102425';
                    $keyfrom = 'qiyunkj';
                    $url = 'http://fanyi.youdao.com/openapi.do?keyfrom='.$keyfrom.'&key='.$key.'&type=data&doctype=json&version=1.1&q=' . urlencode($word);//有道翻译API
                 
                    $fanyiJson = file_get_contents($url);//获取url数据,返回Json数据
                   
                    $fanyiArr = json_decode($fanyiJson, true);//json 转换成 数组
			print_r($fanyiArr);
					
?>