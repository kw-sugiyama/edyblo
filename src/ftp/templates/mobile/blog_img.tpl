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
<?=htmlspecialchars($obj_diary->diarydat[0]['dr_title'])?>｜<?=htmlspecialchars($obj_login->clientdat[0]['cl_jname'])?> <?=htmlspecialchars($obj_login->clientdat[0]['cl_kname'])?></title>
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
<a name="top"></a>
<body>

<table bgcolor="#BBBBBB" width="100%"><tr><td> <font size="<?=FONT_SIZE?>"><?=htmlspecialchars($obj_login->clientdat[0][cl_kname])?> </td></tr></table>
<font size="<?=FONT_SIZE?>">
<?=$view_blog?>
<hr>
<?=$tc_box?>
<a href="<?=_BLOG_SITE_URL_BASE?>blogd-
<?=$obj_diary->diarydat[0]['dr_id']?>/">
自己紹介</a>

<?=$scholl_form?>
<hr>
<?=$boxmobileB?>
<?
$link='
□<a href="
'._BLOG_SITE_URL_BASE.'diary-list/p-1/dr-'.$obj_category1->categorydat[0]['cg_id'].'/">
'.htmlspecialchars($obj_category1->categorydat[0]['cg_stitle']).'
</a>';
echo $link;
?>
<?=$boxmobile?>
<?=$boxmobile2?>
<?//$tc_box?>
<br /><!--main end-->
<table bgcolor="#BBBBBB" width="100%"><tr><td></td></tr></table>
</body>
</html>
