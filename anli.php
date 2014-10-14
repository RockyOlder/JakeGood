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
//验证用户名是否存在
function checkName(){
	var xmlhttp=getXmlHttpobject();
	//怎么判断创建OK
	if(xmlhttp){
		//var url="/ajax/anli2.php?username="+$("username").value;
		//var url="/ajax/anli2.pgp";
			//这是是要发送的数据
			//var data="username="+$('username').value;
		//第三个参数表示 true 表示使用异步机制,false表示不使用异步
		xmlhttp.open("post","anli2.php",true);
		//指定回调函数
		xmlhttp.setRequestHeader("Content-Type","application/x-www-form-urlencoded;charset=utf-8");
	    //xmlhttp.send("data="+value);
		//回调函数，状态改变的事件触发器，也就是把结果放到指定的地方去
		xmlhttp.onreadystatechange = chuli; 
		//真的发送请求,如果是get请求则填入 null即可
		//如果是post请求，则填入实际的数据
		xmlhttp.send("username="+$('username').value);
	}
	}
//回调函数
function chuli(){

//window.alert("处理函数被调用");
	//判断发送给后台的地址正确与否

         if(xmlhttp.readyState==4){//后台服务器已处理完


         	//$strData = xmlhttp.responseText;
          	//window.alert("服务器56465"+xmlhttp.responseText);
          	
        // $('myres').value=xmlhttp.responseText;
        	 //window.alert(xmlhttp.responseXML);
               var mes=xmlhttp.responseXML.getElementsByTagName("mes");
               //取出mes 节点值
               //window.alert(mes.length);
               //mes[0]->表示取出第一个mes节点
               //mes[0].childNodes[0]->表示第一个mes节点的第一个子节点
               var mes_val=mes[0].childNodes[0].nodeValue;
              // window.alert(mes_val);
               $('myres').value=mes_val;
         }
}
function $(id){
	return document.getElementById(id);
}
</script>
</head>

<body>
<form action="???" method="post">
用户名：<input type="text" name="username1" onkeyup="" id="username"/>
<input type="button" onclick="checkName();" value="验证用户名">
<input style="border-width:0;color:red" type="text" id="myres">
<br/>
用户密码：<input type="password" name="password" /><br/>
地址邮箱<input type="text" name="email" /><br/>
<input type="submit" value="用户注册">
</form>
<form action="???" method="post">
用户名：<input type="text" name="username2"/>
<br/>
用户密码：<input type="password" name="password" /><br/>
地址邮箱<input type="text" name="email" /><br/>
<input type="submit" value="用户注册">
</form>
</body>
</html>
