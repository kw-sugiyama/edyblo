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
<title>
<?=$teacher?>
｜<?=htmlspecialchars($obj_login->clientdat[0]['cl_jname'])?> <?=htmlspecialchars($obj_login->clientdat[0]['cl_kname'])?></title>
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
<a name="top"></a>
<table bgcolor="#FFC000" width="100%"><tr><td> <font size="1"> 
<?=$titletable?>
</td></tr></table>
<font size="<?=FONT_SIZE?>">
<?$obj_teacher->teacherdat[0]['tc_name']?>
<?=$teacher?>
<hr color="#FF6600">
<?=$img_path?>
<br>
<?=$tc_comment?>
<hr color="#DDD9C3">
<?=$scholl_form?>
<hr color="#DDD9C3">
<?=$boxmobileB?>
<hr color="#FFC000">
<img src="../share/images/kirakira.gif">
<a href="<?=_BLOG_SITE_URL_BASE?>blog-<?=$obj_diary->diarydat[0]['dr_id']?>/"><font size="1" color="#666666"><?=$obj_diary->diarydat[0]['dr_title']?>
 に戻る</font>
</a><span>
<?=$boxmobile?>
<hr color="#92D050" size="1">
<?=$boxmobile2?>
<?//$tc_box?>
<br /><!--main end
<table bgcolor="#BBBBBB" width="100%"><tr><td></td></tr></table>
-->
</font>
</font>
</body>
</html>
