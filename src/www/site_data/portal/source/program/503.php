<?php
$maintenance_time = "����������";

header ('HTTP/1.0 503 Service Temporarily Unavailable');
header("Content-type: text/html; charset=EUC-JP");

print '<?xml version="1.0" encoding="UTF-8"?>'."\n";
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="ja" xml:lang="ja" dir="ltr">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />

<title>�������ޥ��ƥʥ���Ǥ�</title>
<meta http-equiv="Content-Script-Type" content="text/javascript" />
<meta http-equiv="Content-Style-Type" content="text/css" />
<meta name="robots" content="INDEX,FOLLOW" />
<meta name="Description" content="" />
<meta name="Keywords" content="" />
<style>
body{
	text-align : center ;
	font-family: "MS P�����å�","�ҥ饮�γѥ� Pro W3","Hiragino Kaku Gothic Pro",sans-serif;
}
div{
	width : 500px;
	margin : 100px 0 0 0 ;
	border: solid 2px #777777;
	background-color: #F0F0F0;
}
h2{
	width : 450px ;
	margin : 20px auto;
	padding-left:30px;
	font-size : 22px ;
	font-weight : bold ;
	text-align : left ;
}
p.msg{
	width : 450px ;
	margin : 20px auto;
	padding-left:30px;
	font-size : 14px ;
	line-height : 150% ;
	text-align : left ;
}
p.footer{
	width : 450px ;
	margin : 20px auto 0px;
	padding-left:30px;
	font-size : 14px ;
	line-height : 150% ;
	text-align : right ;
}
span.time{
	font-size : 15px ;
	font-weight : bold ;
}
</style>
</head>
<body>
<div>
<h2>�������ޥ��ƥʥ���Ǥ�</h2>
<p class="msg">�����Ǥ򤪤����������ޤ����������Ϥ򤪴ꤤ�������ޤ���</p>
<p class="msg">�����ӥ�������ϡ�<span class="time"><?=$maintenance_time?></span> ����ͽ�ꤷ�Ƥ���ޤ���</p>
<p class="footer"><span class="time"><?=date('Y/m/d')?></span></p>
</div>
</body>
</html>