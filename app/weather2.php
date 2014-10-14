<?php
   /*        $word="你好";
              $key = '330102425';
            $keyfrom = 'qiyunkj';
            $url = 'http://fanyi.youdao.com/openapi.do?keyfrom=' . $keyfrom . '&key=' . $key . '&type=data&doctype=json&version=1.1&q=' . urlencode($word); //有道翻译API

            $fanyiJson = file_get_contents($url); //获取url数据,返回Json数据

            $fanyiArr = json_decode($fanyiJson, true); //json 转换成 数组
			print_r($fanyiArr);exit;
			*/

//echo 1;exit;

//http://api.map.baidu.com/telematics/v3/weather?location=".urlencode($cityName)."=json&ak=A33216daeb5fee2f4bebb59b97a6aed8
 //http://api.map.baidu.com/telematics/v3/weather?location=".urlencode($cityName)."&output=json&ak=ECe3698802b9bf4457f0e01b544eb6aa

 $aa="深圳";
 //http://api.map.baidu.com/telematics/v3/weather?location=%E5%A4%A9%E6%B4%A5&output=json&ak=A33216daeb5fee2f4bebb59b97a6aed8
 //http://api.map.baidu.com/telematics/v3/weather?location=深圳=json&ak=A33216daeb5fee2f4bebb59b97a6aed8
 //$aaa=
 //print_r($aaa);exit;
 
 
   $url = "http://api.map.baidu.com/telematics/v3/weather?location=".urlencode($aa)."&output=json&ak=5E1603123b57fa2a6873a557af98a1ba";
  $aaq=file_get_contents($url);
  //echo $url;exit;
//echo $aaq;
  $re=array();
 $arr = json_decode($aaq, true); 
 foreach($arr['results'][0]['weather_data'] as $v){
            //  array_push($re,$v);
			    $re[]=$v;
 
 }
 print_r($re);
 
 
 exit;
 function getWeatherInfo($cityName)
{
    if ($cityName == "" || (strstr($cityName, "+"))){
        return "发送天气+城市，例如'天气深圳'";
    }
    $url = "http://api.map.baidu.com/telematics/v3/weather?location=".urlencode($cityName)."&output=json&ak=5E1603123b57fa2a6873a557af98a1ba";
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

    $output = curl_exec($ch);
		//print_r($output);exit;
    curl_close($ch);
    $result = json_decode($output, true);
    if ($result["error"] != 0){
        return $result["status"];
    }
    $curHour = (int)date('H',time());
    $weather = $result["results"][0];
    $weatherArray[] = array("Title" =>$weather['currentCity']."天气预报", "Description" =>"", "PicUrl" =>"", "Url" =>"");
    for ($i = 0; $i < count($weather["weather_data"]); $i++) {
        $weatherArray[] = array("Title"=>
            $weather["weather_data"][$i]["date"]."\n".
            $weather["weather_data"][$i]["weather"]." ".
            $weather["weather_data"][$i]["wind"]." ".
            $weather["weather_data"][$i]["temperature"],
        "Description"=>"", 
        "PicUrl"=>(($curHour >= 6) && ($curHour < 18))?$weather["weather_data"][$i]["dayPictureUrl"]:$weather["weather_data"][$i]["nightPictureUrl"], "Url"=>"");
    }
    return $weatherArray;
}


?>