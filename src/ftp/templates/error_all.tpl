<?
$ua = $_SERVER['HTTP_USER_AGENT'];
if (!(ereg("Windows",$ua) && ereg("MSIE",$ua)) || ereg("MSIE 7",$ua)) {
	echo '<?xml version="1.0" encoding="EUC-JP"?>'."\n";
}
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="ja" lang="ja">
  <head>
    <title>塾タウン - エラー</title>
    <meta http-equiv="Content-Type" content="text/html; charset=EUC-JP" />
    <style type="text/css">
    <!--
      A{ color: black}
      A:hover { color: red }
    //-->
    </style>
<?=$param_meta_robots?>
  </head>
  <body>
    <div align="center">
      <table width="500" border="0" cellspacing="0" cellpadding="0">
        <tr>
         <td>
            <br />
            <br />
            <div align="center">
<?php
$buttonString = "戻る";
if ( $_buffGoto == "#" ) {
	$action_url = "http://jukutown.com/";
} else {
	$action_url = $_buffGoto;
}
if ( $buffViewString == "エラーが発生しました。<br />TOPへお戻り下さい。" ) {
	$viewMassege = "アクセスしたページが存在しないかエラーが発生いたしました。<br />下記の“戻る”ボタンより“TOPページ”にお戻り下さい。";
	$buttonString = "戻る";
} else {
	$viewMassege = $buffViewString;
	$buttonString = "戻る";
}

?>
              <form name="error_back" method="post" action="<?=$action_url?>" target="_self">
                <p><font size="3" color="#FF6600"><?=$viewMassege?></font></p>
                <p><font size="3" color="#FF6600"><?=$_arrOther["ath_comment"]?></font></p>
                <p></p>
                <input type="submit" value="<?=$buttonString?>" />
              </form>
            </div>
          </td>
        </tr>
      </table>
    </div>
<?php require_once( SYS_PATH."templates/analytics.tpl" ); ?>
  </body>
</html>
