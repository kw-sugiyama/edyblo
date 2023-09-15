<?
$ua = $_SERVER['HTTP_USER_AGENT'];
if (!(ereg("Windows",$ua) && ereg("MSIE",$ua)) || ereg("MSIE 7",$ua)) {
echo '<?xml version="1.0" encoding="EUC-JP"?>'."\n";
}

$url = _BLOG_SITE_URL_BASE.'inq_end/';
header("Location: $url");
exit;
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="ja" lang="ja">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=EUC-JP" />
<meta name="author"      content="<?=htmlspecialchars($obj_login->clientdat[0]['cl_jname'])?> <?=htmlspecialchars($obj_login->clientdat[0]['cl_kname'])?>" />
<meta name="Description" content="<?=htmlspecialchars($obj_login->clientdat[0]['sc_introduce'])?>" />
<meta name="Keywords"    content="<?=htmlspecialchars($obj_login->clientdat[0]['sc_keywd'])?>" />
<title><?=htmlspecialchars($html_title)?>送信完了｜<?=htmlspecialchars($obj_login->clientdat[0]['cl_jname'])?> <?=htmlspecialchars($obj_login->clientdat[0]['cl_kname'])?></title>

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
</body>
</html>

