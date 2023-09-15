<?
$ua = $_SERVER['HTTP_USER_AGENT'];
if (!(ereg("Windows",$ua) && ereg("MSIE",$ua)) || ereg("MSIE 7",$ua)) {
echo '<?xml version="1.0" encoding="EUC-JP"?>'."\n";
}
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="ja" lang="ja">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=EUC-JP" />
		<meta name="author"      content="<?=htmlspecialchars($obj_login->clientdat[0]['cl_jname'])?> <?=htmlspecialchars($obj_login->clientdat[0]['cl_kname'])?>" />
		<meta name="Description" content="<?=htmlspecialchars($obj_login->clientdat[0]['sc_introduce'])?>" />
		<meta name="Keywords"    content="<?=htmlspecialchars($obj_campaign->campaindat[$key1]['cp_contents'])?>" />
		<title>
<?echo $obj_camarticle->camarticledat[0][4];?>｜<?=htmlspecialchars($obj_login->clientdat[0]['cl_jname'])?> <?=htmlspecialchars($obj_login->clientdat[0]['cl_kname'])?></title>
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
<font size="<?=FONT_SIZE?>">
<a name="top"></a>
<table bgcolor="#B8CCE4" width="100%"><tr><td> <font size="<?=FONT_SIZE?>"> 
<?=$titletable?>
</td></tr></table>
<br>
<?=$text1title?>
<hr color="#538ED5">
<br>
<font size="<?=FONT_SIZE?>">
<?=$img_path?>
<?=$text1?>
<?=$text2?>
<hr color="#DDD9C3">
<?=$scholl_form?>
<hr color="#DDD9C3">
<font size="<?=FONT_SIZE?>">
<?=$boxmobileB?>
<hr color="#FFC000">
<font size="<?=FONT_SIZE?>">
<img src="../share/images/kirakira.gif">

<!--<a href="<?=_BLOG_SITE_URL_BASE?>campain-list/p-1/cp-<?=$obj_category1->categorydat[0]['cg_id']?>/">
-->
<font size="<?=FONT_SIZE?>"><a href="<?=_BLOG_SITE_URL_BASE?>campaign-detail-<?=$title?>/">
<font color="#666666"><?=htmlspecialchars($texttitle)?>に戻る
</a></font>
<font size="<?=FONT_SIZE?>">
<?=$boxmobile?>
<hr color="#92D050" size="1">
<font size="<?=FONT_SIZE?>">
<?=$boxmobile2?>
</form>
</body>
</html>

