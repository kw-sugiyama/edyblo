<?
$ua = $_SERVER['HTTP_USER_AGENT'];
if (!(ereg("Windows",$ua) && ereg("MSIE",$ua)) || ereg("MSIE 7",$ua)) {
	echo '<?xml version="1.0" encoding="EUC-JP"?>'."\n";
}

?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="ja" lang="ja">
<head>
<meta http-equiv="X-UA-Compatible" content="IE=EmulateIE7" />	
	<meta http-equiv="Content-Type" content="text/html; charset=EUC-JP" />
	<meta name="author" content="<?=htmlspecialchars($obj_login->clientdat[0]['cl_jname'])?> <?=htmlspecialchars($obj_login->clientdat[0]['cl_kname'])?>" />
	<meta name="Description" content="<?=htmlspecialchars($obj_diary->diarydat[0]['dr_title'])?> | <?=htmlspecialchars($obj_login->clientdat[0]['sc_introduce'])?>" />
	<meta name="Keywords" content="<?=htmlspecialchars($obj_login->clientdat[0]['sc_keywd'])?>" />

	<link href="<?=$param_css_path?><?=$obj_login->clientdat[0]['sc_clr']?>/style_import.css" rel="stylesheet" type="text/css" media="screen" />
	<link href="<?=$param_css_path?><?=$obj_login->clientdat[0]['sc_clr']?>/print.css" rel="stylesheet" type="text/css" media="print" />
	<link href="<?=SITE_PATH?>share/css/common_css/advertisement.css" rel="stylesheet" type="text/css" media="screen" />
	<?=$alternate_tag?>

	<script language="JavaScript" type="text/javascript" src="./share/js/highslide.js"></script>
	<script language="JavaScript" type="text/javascript" src="./share/js/highslide_config.js"></script>

	<title><?=htmlspecialchars($obj_diary->diarydat[0]['dr_title'])?>｜<?=htmlspecialchars($obj_login->clientdat[0]['cl_jname'])?> <?=htmlspecialchars($obj_login->clientdat[0]['cl_kname'])?></title>
<?=$param_meta_robots?>
</head>
<body>

	<div id="container"><!--container start-->
		<div id="wrappertop"><!--wrappertop start -->
		
			<?php require_once( SYS_PATH."templates/header.tpl" ); ?>
			
			<div id="main"><!--main start-->
				
				<?php require_once( SYS_PATH."templates/left.tpl" ); ?>
				
					<div id="mainright"><!--mainright start-->
						<p class="topicpath"><a href="<?=_BLOG_SITE_URL_BASE?>">TOP</a><span class="spacefortopicpath">&#8250;</span><a href="<?=_BLOG_SITE_URL_BASE?>diary-list/p-0/dr-<?=$obj_category1->categorydat[0]['cg_id']?>/"><?=htmlspecialchars($obj_category1->categorydat[0]['cg_stitle'])?></a><span class="spacefortopicpath">&#8250;</span><?=htmlspecialchars($obj_diary->diarydat[0]['dr_title'])?></p>

						<?=$view_blog?>
						<?=$tc_box?>
						
						<div class="box"><!--box start-->
							<table>
								<tr>
									<td>
										<p class="siryoseikyu center2"><a href="javascript:void(0)" onclick="document.req.submit(); return false">&nbsp;</a></p>
									</td>
									<td>
										<p class="otoiawase center2"><a href="javascript:void(0)" onclick="document.inquire.submit(); return false">&nbsp;</a></p>
									</td>
								</tr>
							</table>
						</div><!--box end-->
						
						<?php require_once( SYS_PATH."templates/box.tpl" ); ?>

					</div><!--mainright end-->    
				</div><br class="clear" /><!--main end-->    
			</div><!--wrappertop end -->

			<?php require_once( SYS_PATH."templates/footer.tpl" ); ?>
</body>
</html>
