<?
$ua = $_SERVER['HTTP_USER_AGENT'];
if (!(ereg("Windows",$ua) && ereg("MSIE",$ua)) || ereg("MSIE 7",$ua)) {
	echo '<?xml version="1.0" encoding="EUC-JP"?>'."\n";
}
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="ja" lang="ja">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=EUC-JP" />
	<meta name="author" content="<?=htmlspecialchars($obj_login->clientdat[0]['cl_jname'])?> <?=htmlspecialchars($obj_login->clientdat[0]['cl_kname'])?>" />
	<meta name="Description" content="<?=htmlspecialchars($obj_login->clientdat[0]['sc_introduce'])?>" />
	<meta name="Keywords" content="<?=htmlspecialchars($obj_login->clientdat[0]['sc_keywd'])?>" />
	<title>�ץ饤�Х����ݥꥷ��|<?=htmlspecialchars($obj_login->clientdat[0]['cl_jname'])?> <?=htmlspecialchars($obj_login->clientdat[0]['cl_kname'])?></title>
	<style>
	<!--
	.default {color: #666666;}
	a:link{color:#666666;}
	a:visited{color:#999999;}
	a:hover{color:#FFFFFF;background-color:#666666;}
	-->
	</style>
<?=$param_meta_robots?>
</head>
<body>
<font color="#663300">
<A name=top></A>
	<!--<p class="topicpath"><a href="<?=_BLOG_SITE_URL_BASE?>">TOP</a><span class="spacefortopicpath">&#8250;</span>�ץ饤�Х����ݥꥷ��</p>-->
	<div class="box"><!--box start-->
<table bgcolor="#FFC000" width="100%"><tr><td> <font size="<?=FONT_SIZE?>"> 
<font color="#663300">
<?=$titletable?>
</td></tr></table>
<font size="<?=FONT_SIZE?>">
<br>
�ץ饤�Х����ݥꥷ��
<font size="<?=FONT_SIZE?>">
<?=$privacy_policy?>
<font size="<?=FONT_SIZE?>">
<hr color="#DDD9C3">
<?=$scholl_form?>
<hr color="#DDD9C3">
<font size="<?=FONT_SIZE?>">
<?=$boxmobileB?>
<hr color="#FFC000">
<font size="<?=FONT_SIZE?>">
<?=$boxmobile?>
<hr color="#92D050" size="1">
<font size="<?=FONT_SIZE?>">
<?=$boxmobile2?>
</body>
</html>

