<?
$ua = $_SERVER['HTTP_USER_AGENT'];
if (!(ereg("Windows",$ua) && ereg("MSIE",$ua)) || ereg("MSIE 7",$ua)) {
	echo '<?xml version="1.0" encoding="Shift_JIS"?>'."\n";
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="ja" lang="ja">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=Shift_JIS" />
	<meta name="author"      content="<?=mb_convert_encoding(htmlspecialchars($obj_login->clientdat[0]['cl_jname']),"SJIS","EUC-JP")?> <?=mb_convert_encoding(htmlspecialchars($obj_login->clientdat[0]['cl_kname']),"SJIS","EUC-JP")?>" />
	<meta name="Description" content="<?=mb_convert_encoding(htmlspecialchars($obj_login->clientdat[0]['sc_introduce']),"SJIS","EUC-JP")?>" />
	<meta name="Keywords"    content="<?=mb_convert_encoding(htmlspecialchars($obj_login->clientdat[0]['sc_keywd']),"SJIS","EUC-JP")?>" />
	<title>資料請求内容の確認｜<?=mb_convert_encoding(htmlspecialchars($obj_login->clientdat[0]['cl_jname']),"SJIS","EUC-JP")?> <?=mb_convert_encoding(htmlspecialchars($obj_login->clientdat[0]['cl_kname']),"SJIS","EUC-JP")?></title>
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
<table bgcolor="#FF9999" width="100%" ><tr><td><font size="<?=FONT_SIZE?>">
<?=mb_convert_encoding(htmlspecialchars($obj_login->clientdat[0]['cl_jname']),"SJIS","EUC-JP")?> <?=mb_convert_encoding(htmlspecialchars($obj_login->clientdat[0]['cl_kname']),"SJIS","EUC-JP")?>への資料請求</td></tr></table>
<font size="<?=FONT_SIZE?>">資料請求内容の確認
</div>
<?=mb_convert_encoding($confirm_form,"SJIS","EUC-JP")?>
<font size="1">
<?=mb_convert_encoding($question_box,"SJIS","EUC-JP")?>
<Table Border="0" width="100%">
<Tr>
<Td width="50%" align="center">
<?=mb_convert_encoding($hidden1,"SJIS","EUC-JP")?>
</Td>
<Td width="50%" align="center">
<?=mb_convert_encoding($hidden2,"SJIS","EUC-JP")?>
</Td>
</Tr>
<Tr>
</Tr>
</Table>
<?=mb_convert_encoding($button2,"SJIS","EUC-JP")?>
<br />
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
