<?php
	header("Content-Type: text/xml;charset=utf-8");
	//�����������Ҫ��������
	header("Cache-Control: no-cache");

//����   �û���ѡ���ʡ������
$province=$_POST['province'];
   
  // file_put_contents("C:/Users/Administrator/Desktop/web����/chesi.log",$province."\r\n",FILE_APPEND); 
   //�����ݿ�ȥ��ѯʡ����Щ����()
	$provinceName=$_post['sheng'];
	
	//׼������xml��ʽ�Ľ��..
$info="";
if ($username=='shuige'){
	$info='{"res":"����","rdd":"����","rqq":"����"}';//ע�⣬���������Ƿ��ظ������ҳ��
}
else{
$info='{"res":"����","rdd":"�ڰ�","rqq":"ȥˢ"}';//ע�⣬���������Ƿ��ظ������ҳ��
}
echo $info;




?>