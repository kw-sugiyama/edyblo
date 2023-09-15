<?
$ua = $_SERVER['HTTP_USER_AGENT'];
if (!(ereg("Windows",$ua) && ereg("MSIE",$ua)) || ereg("MSIE 7",$ua)) {
	echo '<?xml version="1.0" encoding="Shift_JIS"?>'."\n";
}
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="ja" lang="ja">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=Shift_JIS" />
	<meta name="author"      content="<?=mb_convert_encoding(htmlspecialchars($obj_login->clientdat[0]['cl_jname']),"SJIS","EUC-JP")?> <?=mb_convert_encoding(htmlspecialchars($obj_login->clientdat[0]['cl_kname']),"SJIS","EUC-JP")?>" />
	<meta name="Description" content="<?=mb_convert_encoding(htmlspecialchars($obj_login->clientdat[0]['sc_introduce']),"SJIS","EUC-JP")?>" />
	<meta name="Keywords"    content="<?=mb_convert_encoding(htmlspecialchars($obj_login->clientdat[0]['sc_keywd']),"SJIS","EUC-JP")?>" />
	<title>お問い合わせ｜<?=mb_convert_encoding(htmlspecialchars($obj_login->clientdat[0]['cl_jname']),"SJIS","EUC-JP")?> <?=mb_convert_encoding(htmlspecialchars($obj_login->clientdat[0]['cl_kname']),"SJIS","EUC-JP")?></title>
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
<table bgcolor="#FF9999" width="100%" ><tr><td><font size="<?=FONT_SIZE?>">
<?=mb_convert_encoding(htmlspecialchars($obj_login->clientdat[0]['cl_jname']),"SJIS","EUC-JP")?> <?=mb_convert_encoding(htmlspecialchars($obj_login->clientdat[0]['cl_kname']),"SJIS","EUC-JP")?>へのお問い合わせ</td></tr></table>
<font size="<?=FONT_SIZE?>">
<form method="post" action="<?=_BLOG_SITE_URL_BASE?>inq-confirm/" name="client" accept-charset="shift-jis">
<input type="hidden" name="mailtype" value="INQUIRY" /><font size="<?=FONT_SIZE?>"><font color="red">※</font>は入力必須項目となります。
<?=mb_convert_encoding($errmsg,"SJIS","EUC-JP")?>
<?=mb_convert_encoding($inquiry_checkbox,"SJIS","EUC-JP")?>
<?=mb_convert_encoding($request_msg,"SJIS","EUC-JP")?>
<?=mb_convert_encoding($inquiry_form1,"SJIS","EUC-JP")?>
<center>
<?=mb_convert_encoding($privacy,"SJIS","EUC-JP")?>
<?=mb_convert_encoding($button1,"SJIS","EUC-JP")?>
</center>
<hr color="#FF9999">
<font size="<?=FONT_SIZE?>">
<?=mb_convert_encoding($boxmobileB,"SJIS","EUC-JP")?>
<hr color="#FFC000">
<font size="<?=FONT_SIZE?>">
<?=mb_convert_encoding($boxmobile,"SJIS","EUC-JP")?>
<hr color="#92D050" size="1">
<font size="<?=FONT_SIZE?>">
<?=mb_convert_encoding($boxmobile2,"SJIS","EUC-JP")?>
</body>
</html>

