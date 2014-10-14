<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<script type="text/javascript">
var xmlhttp;

	function getXmlHttpobject(){	

		if (window.XMLHttpRequest)
		  {// code for IE7+, Firefox, Chrome, Opera, Safari
			xmlhttp=new XMLHttpRequest();
		  }
		else
		  {// code for IE6, IE5
			xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
		  }
		  return xmlhttp;
	}
	function getCities(){
		xmlhttp=getXmlHttpobject();
		if(xmlhttp){
               var url="/ajax/chuli.php";//post
              // var data="province="+$('sheng').value;
               xmlhttp.open("post",url,true);
               xmlhttp.setRequestHeader("Content-Type","application/x-www-form-urlencoded;charset=utf-8");
               xmlhttp.onreadystatechange =chuli; 
               xmlhttp.send("province="+$('sheng').value);
               
		}
}
	function chuli(){
	
           if(xmlhttp.readyState==4){
                 //取出服务器回送的数据
                //window.alert(xmlhttp.responseXML);
          // var 
           //cities=xmlhttp.responseXML.getElementsByTagName('city');
               //取出mes 节点值
              // window.alert(cities);
          
          var mes=xmlhttp.responseText;

              // window.alert(mes)
          var mes_obj=eval("("+mes+")");
         // window.alert(mes_obj)
        
          $('city').appendChild=mes_obj.res;
          
          
          
          
          
          
                   //$('city').length=0;
                 //for(var i=0;i<cities.length;i++){
                    // var city_name=cities[i].childNode[0].nodevalue;
                     //window.alert(city_name)
                     //var myoption = document.createElement("option");
                     //myoption.value=city_name;
                     //myoption.innerText=city_name;
                     //$('city').appendChild(myoption);
           }


	}
	function $(id){
		return document.getElementById(id);
	}
</script>
</head>
<body>
<select id="sheng" onchange="getCities();">
<option value="">---省---</option>
<option value="zhejiang">浙江</option>
<option value="jiangsu">江苏</option>
</select>
<select>
<option value="city">--城市--</option>
</select>
<select id="county">
<option value="">--县城--</option>

</select>
</body>

</html>