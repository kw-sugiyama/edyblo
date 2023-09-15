<?
$ua = $_SERVER['HTTP_USER_AGENT'];
if (!(ereg("Windows",$ua) && ereg("MSIE",$ua)) || ereg("MSIE 7",$ua)) {
 '<?xml version="1.0" encoding="EUC-JP"?>'."\n";
}
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="ja" lang="ja">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=EUC-JP" />
<meta name="author"      content="<?=htmlspecialchars($obj_login->clientdat[0]['cl_jname'])?> <?=htmlspecialchars($obj_login->clientdat[0]['cl_kname'])?>" />
<meta name="Description" content="<?=htmlspecialchars($obj_login->clientdat[0]['sc_introduce'])?>" />
<meta name="Keywords"    content="<?=htmlspecialchars($obj_campaign->campaindat[$key1]['cp_contents'])?>" />
<title><?=htmlspecialchars($obj_campaign->campaindat[0]['cp_title'])?>｜<?=htmlspecialchars($obj_login->clientdat[0]['cl_jname'])?> <?=htmlspecialchars($obj_login->clientdat[0]['cl_kname'])?></title>
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
<table bgcolor="#B8CCE4" width="100%"><tr><td> <font size="<?=FONT_SIZE?>"> 
<?=$titletable?>
</td></tr></table>
<p>
<font size="<?=FONT_SIZE?>">
<!--
<a href="<?=_BLOG_SITE_URL_BASE?>">TOP</a><span>&#8250;</span><a href="<?=_BLOG_SITE_URL_BASE?>campain-list/p-0/cp-<?=$obj_category1->categorydat[0]['cg_id']?>/"><?=$obj_category1->categorydat[0]['cg_stitle']?></a><span>&#8250;</span><?=$obj_campaign->campaindat[0]['cp_title']?></p>-->
<font size="<?=FONT_SIZE?>">
<?=$campaign_listA?>
<hr color="#538ED5">
<?=$campaign_listB?>
<?=$campaign_list?>
<hr color="#DDD9C3">
</a>
<?=$scholl_form?>
<hr color="#DDD9C3">
<font size="<?=FONT_SIZE?>">
<?=$boxmobileB?>
<hr color="#FFC000">
<img src="../share/images/kirakira.gif">
<a href="<?=_BLOG_SITE_URL_BASE?>campain-list/p-1/cp-<?=htmlspecialchars($obj_category1->categorydat[0]['cg_id'])?>/">
<font color="#666666">
<font size="<?=FONT_SIZE?>">
<?=htmlspecialchars($obj_category1->categorydat[0]['cg_stitle'])?>
 一覧に戻る
</a>
<?=$boxmobile?>
<hr color="#92D050" size="1">
<font size="<?=FONT_SIZE?>">
<?=$boxmobile2?>
</body>
</html>

