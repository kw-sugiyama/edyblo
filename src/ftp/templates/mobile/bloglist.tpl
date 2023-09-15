<?
$ua = $_SERVER['HTTP_USER_AGENT'];
if (!(ereg("Windows",$ua) && ereg("MSIE",$ua)) || ereg("MSIE 7",$ua)) {
		  echo '<?xml version="1.0" encoding="EUC-JP"?>'."\n";
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="ja" lang="ja">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=EUC-JP" />
	<meta name="author" content="<?=htmlspecialchars($obj_login->clientdat[0]['cl_jname'])?> <?=htmlspecialchars($obj_login->clientdat[0]['cl_kname'])?>" />
	<meta name="Description" content="<?=htmlspecialchars($obj_login->clientdat[0]['sc_introduce'])?>" />
	<meta name="Keywords" content="<?=htmlspecialchars($obj_login->clientdat[0]['sc_keywd'])?>" />
<title>
<?=htmlspecialchars($obj_category->categorydat[0]['cg_stitle'])?>
 一覧
｜
<?=htmlspecialchars($obj_login->clientdat[0]['cl_jname'])?> 
<?=htmlspecialchars($obj_login->clientdat[0]['cl_kname'])?></title>
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
<font size="<?=FONT_SIZE?>"><a name="top"></a>
<table bgcolor="#FFC000" width="100%"><tr><td> <font size="<?=FONT_SIZE?>"> 
<?=$titletable?>
</td></tr></table>
<?=htmlspecialchars($obj_category->categorydat[0]['cg_stitle'])?>
 一覧
<!--
<a href="<?=_BLOG_SITE_URL_BASE?>"><font size="<?=FONT_SIZE?>">TOP</a><span>&#8250;</span><?=$obj_category->categorydat[0]['cg_stitle']?></p>
<br>-->

<hr color="#FF6600">
<font size="<?=FONT_SIZE?>">
<?=$case_number?>
<hr color="#FF6600">
<font size="<?=FONT_SIZE?>">
<?=$blog_listtitle?>
<?=$blog_list?>
<div align="left">
<font size="<?=FONT_SIZE?>">

<TABLE border="0" Width="100%">
<font size="1">
<?=$strViewPageMove_list?>
</TABLE>

<TABLE border="0" Width="100%">
<tr>
<td Width="50%" align="center"><br />
<font size="1">
<?=$strViewPageMove_before?> 
</td>
<td Width="50%" align="center">
<font size="1">
<?=$strViewPageMove_after?>
</td>
</tr>
</TABLE>
<font size="<?=FONT_SIZE?>">
<hr color="#FF6600">
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
