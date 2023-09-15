<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd"> 
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=EUC-JP" />
		<meta name="author" content="<?=htmlspecialchars($obj_login->clientdat[0]['cl_jname'])?> 
		<?=htmlspecialchars($obj_login->clientdat[0]['cl_kname'])?>" />
		<meta name="Description" content="<?=htmlspecialchars($obj_login->clientdat[0]['sc_introduce'])?>" />
		<meta name="Keywords" content="<?=htmlspecialchars($obj_login->clientdat[0]['sc_keywd'])?>" />
		<title>
			<?=htmlspecialchars($obj_login->clientdat[0]['sc_toptitle'])?>｜<?=htmlspecialchars($obj_login->clientdat[0]['cl_jname'])?> <?=htmlspecialchars($obj_login->clientdat[0]['cl_kname'])?></title>
			
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
<!--トップタイトル：<?=$sc_top_title?><br>塾名：<?=$sc_cl_jname?><br>-->
<A name=top></A>
</table>
<table bgcolor="#C5BE97" width="100%"><tr><td>
<font size="1"> 
<?=$titletable?>
</td></tr></table>
<!--<font size="<?=FONT_SIZE?>"><a href="<?=_BLOG_SITE_URL_BASE?>">TOP</a><span>&#8250;</span> <?=$school_box_title?>-->
<font size="1"> 
地図
<hr color="#948B54">
<font size="<?=FONT_SIZE?>">
<?=$arrHeaderView["blog_cl_logo"]?>
<br />
<?=$arrHeaderView["buck_pagetop"]?>
<?=$map_html?>
<?=$view_img_html?>
<!--<?=$view_img_html?>-->
<hr color="#92D050" size="1">
<font size="<?=FONT_SIZE?>">
<?=$school_list?>
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
</font>
</font>
</body>
</html>
