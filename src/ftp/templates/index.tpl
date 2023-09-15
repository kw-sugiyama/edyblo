<?
$ua = $_SERVER['HTTP_USER_AGENT'];
if (!(ereg("Windows",$ua) && ereg("MSIE",$ua)) || ereg("MSIE 7",$ua)) {
	echo '<?xml version="1.0" encoding="EUC-JP"?>'."\n";
}

?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="ja" lang="ja">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=EUC-JP" />
	<meta http-equiv="Content-Style-Type" content="text/css" />
	<meta http-equiv="Content-Script-Type" content="text/javascript" />
	
	<meta name="author" content="<?=htmlspecialchars($obj_login->clientdat[0]['cl_jname'])?> <?=htmlspecialchars($obj_login->clientdat[0]['cl_kname'])?>" />
	<meta name="Description" content="<?=htmlspecialchars($obj_login->clientdat[0]['sc_introduce'])?>" />
	<meta name="Keywords" content="<?=htmlspecialchars($obj_login->clientdat[0]['sc_keywd'])?>" />

<?php if (!empty($arrMetaHeader['google_search_console_key'])) echo $arrMetaHeader['google_search_console_key']; ?>

	<link href="<?=$param_css_path?><?=$obj_login->clientdat[0]['sc_clr']?>/style_import.css" rel="stylesheet" type="text/css" media="screen" />
	<link href="<?=$param_css_path?><?=$obj_login->clientdat[0]['sc_clr']?>/print.css" rel="stylesheet" type="text/css" media="print" />
	<link href="<?=SITE_PATH?>share/css/common_css/campaign.css" rel="stylesheet" type="text/css" media="screen" />
	<link href="<?=SITE_PATH?>share/css/common_css/advertisement.css" rel="stylesheet" type="text/css" media="screen" />
	<?=$alternate_tag?>
	
	<title><?=htmlspecialchars($obj_login->clientdat[0][sc_topwindowtitle])?>��<?=htmlspecialchars($obj_login->clientdat[0]['cl_jname'])?> <?=htmlspecialchars($obj_login->clientdat[0]['cl_kname'])?></title>
<?=$param_meta_robots?>
</head>

<body>
	<div id="container"><!--container start-->
		<div id="wrappertop"><!--wrappertop start -->
			<?php require_once( SYS_PATH."templates/header.tpl" ); ?>
			<div id="main"><!--main start-->
				<?php require_once( SYS_PATH."templates/left.tpl" ); ?>
				<div id="mainright"><!--mainright start-->
<?php if ($obj_login->clientdat[0]['sc_thtml'] != "") { ?>
				<!-- �ե꡼��� -->
				<div class="box free_box"><!--box free_box start-->
					<div><?php print (nl2br(html_replace($obj_login->clientdat[0]['sc_thtml']))); ?></div>
				</div><!--box free_box end-->
<?php } // if ?>
					<?=$index_list?>
				<?php require_once( SYS_PATH."templates/box.tpl" ); ?>
			</div><!--mainright end-->    
		</div><br class="clear" /><!--main end-->    
	</div><!--wrappertop end -->
	<?php require_once( SYS_PATH."templates/footer.tpl" ); ?>
</body>
</html>

