<?
$ua = $_SERVER['HTTP_USER_AGENT'];
if (!(ereg("Windows",$ua) && ereg("MSIE",$ua)) || ereg("MSIE 7",$ua)) {
echo '<?xml version="1.0" encoding="EUC-JP"?>'."\n";
}
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="ja" lang="ja">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=EUC-JP" />
		<meta http-equiv="Content-Script-Type" content="text/javascript" />
		<meta name="author" content="<?=htmlspecialchars($obj_login->clientdat[0]['cl_jname'])?> <?=htmlspecialchars($obj_login->clientdat[0]['cl_kname'])?>" />
		<meta name="Description" content="<?=htmlspecialchars($obj_login->clientdat[0]['sc_introduce'])?>" />
		<meta name="Keywords" content="<?=htmlspecialchars($obj_login->clientdat[0]['sc_keywd'])?>" />
		<meta http-equiv="Content-Type" content="application/xhtml+xml; charset=shift-JIS" />
		<title>
<?=htmlspecialchars($obj_login->clientdat[0][sc_topwindowtitle])?>｜<?=htmlspecialchars($obj_login->clientdat[0]['cl_jname'])?> <?=htmlspecialchars($obj_login->clientdat[0]['cl_kname'])?></title>
<style>
</style>
<?=$param_meta_robots?>
</head>
<body>
<font color="#663300">
<font size="<?=FONT_SIZE?>">
<center>
<?=$sc_logo?>
</center>
<A name=top></A>
<?//=htmlspecialchars($obj_login->clientdat[0][cl_jname])?>
<font size="1">
<!--サブタイトル--><!--
<table bgcolor="#FFC000" width="100%"><tr><td> 
<?=htmlspecialchars($obj_login->clientdat[0]['sc_topsubtitle'])?>
</td></tr></table>-->
	<table bgcolor="#FFC000" width="100%"><tr><td><marquee loop="-1">
<?=htmlspecialchars($obj_login->clientdat[0]['sc_topsubtitle'])?>
</marquee></td></tr></table>
<center><b>
<font size="1">
<?=htmlspecialchars($obj_login->clientdat[0]['cl_jname'])?> <?=htmlspecialchars($obj_login->clientdat[0]['cl_kname'])?>
</center></b>
<hr color="#DDD9C3">
<?=$scholl_form?>
<hr color="#DDD9C3">
<?=$index_listI?>
<?=$index_listC?>
<hr color="#92D050" size="1">
<?=$school_list?>
<hr color="#92D050" size="1">
<?=$leftmenu_listibento?>
<?=$leftmenu_lista?>
<?=$leftmenu_listo?>
<hr color="#DDD9C3">
<font size="<?=FONT_SIZE?>">
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
</font>
</body>
</html>

