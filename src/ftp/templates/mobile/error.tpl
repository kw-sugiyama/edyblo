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
    <meta http-equiv="Content-Style-Type" content="text/css" />
    <meta name="Keywords" content="<?=$arrMetaHeader["keyword"]?>" />
    <meta name="Description" content="<?=$arrMetaHeader["description"]?>" />
    <meta http-equiv="Pragma" content="no-cache" />
    <title><?=$arrMetaHeader["title"]?> | <?=$arrMetaHeader["title_corp"]?></title>
    <link href="./share/css/<?=_SITE_LAYOUT?>/common.css" rel="stylesheet" type="text/css" />
    <link href="./share/css/<?=_SITE_LAYOUT?>/home.css" rel="stylesheet" type="text/css" />
    <link href="<?=SITE_PATH?>share/css/common_css/advertisement.css" rel="stylesheet" type="text/css" media="screen" />

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
    <div id="container">

<?php require_once( SYS_PATH."templates/header.tpl" ); ?>

      <div id="wrapper">
        <div id="tc_box">
          <div id="tc_right">
            <div id="formmail-general">
              <!--<form name="error_back" method="<?=$_arrOther["next_pass"]?>" action="<?=$_buffGoto?>" target="_self">-->
              <form name="error_back" method="<?=$_arrOther["next_pass"]?>" action="./" target="_self">
              <strong class="red"><?=$buffViewString?></strong>
              <p><?=$_arrOther["ath_comment"]?></p>
              <P>&nbsp;</P>
              <p><INPUT type="submit" value="戻る" /></p>
              </form>
            </div><!-- formmail-general -->
          </div><!-- tc_right -->
          <div id="tc_left">


          </div><!-- tc_left -->
        </div><!-- tc_box -->
      </div><!-- wrapper -->

  </body>
</html>
