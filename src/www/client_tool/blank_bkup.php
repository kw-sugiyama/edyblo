<?
/******************************************************************************
<< 不動産ブログ　Ver.1.0.0 >>
    Name: blank.php
    Version: 1.0.0
    Function: 空白画面
    Author: Click inc
    Date of creation: 2007/02
    History of modification:

    Copyright (C)2005 Click, inc. All Rights Reserverd.
******************************************************************************/

/*----------------------------------------------------------
  必要ファイル呼び出し
----------------------------------------------------------*/
require_once ( "./ini_sets_1.php" );
require_once ( SYS_PATH."dbif/dbcom_DBconnectClass.php" );
require_once ( SYS_PATH."dbif/basedb_ClientClass.php" );
require_once ( SYS_PATH."common/base_common.php" );
require_once ( SYS_PATH."common/sys_common.php" );
require_once ( SYS_PATH."common/error.class.php" );


/*----------------------------------------------------------
  セッション開始
----------------------------------------------------------*/
session_start();


/*----------------------------------------------------------
        エラークラス - インスタンス
----------------------------------------------------------*/
$obj_error = new DispErrMessage();


/*----------------------------------------------------------
  ＤＢ接続
----------------------------------------------------------*/
require_once( SYS_PATH."common/db_connect.php" );


/*----------------------------------------------------------
  ログイン情報チェック
----------------------------------------------------------*/
require_once("./login_chk.php");


/*----------------------------------------------------------
  ＤＢ切断
----------------------------------------------------------*/
require_once( SYS_PATH."common/db_close.php" );


/*----------------------------------------------------------
  ＨＴＭＬ生成
----------------------------------------------------------*/
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<HTML>
<HEAD>
<META http-equiv="Content-Type" content="text/html; charset=EUC-JP">
<META name="GENERATOR" content="IBM WebSphere Studio Homepage Builder Version 9.0.0.0 for Windows">
<META http-equiv="Content-Style-Type" content="text/css">
<TITLE></TITLE>
<style type="text/css">
<!--
.style1 {font-size: 12px}
-->
</style>
</HEAD>
<BODY>
<TABLE>
  <TBODY>
    <TR>
      <TD width="576" height="545" valign="top">
      <P><IMG src="share/images/bar_nes.gif" width="600" height="25" border="0"></P>
      <IFRAME src="news.html" name="news" width="600" height="231">
この部分はインラインフレームを使用しています。</IFRAME>
      <P><IMG src="share/images/bar_maintenance.gif" width="600" height="25" border="0"></P>
<P>
  <iframe src="maintenance.html" name="maintenance" width="600" height="236"> この部分はインラインフレームを使用しています。 </iframe>
</P></TD>
      <TD width="172" height="545" valign="top" align="center"><iframe src="http://rcm-jp.amazon.co.jp/e/cm?t=tsbar-22&o=9&p=14&l=st1&mode=books-jp&search=%E4%B8%8D%E5%8B%95%E7%94%A3&fc1=000000&lt1=&lc1=3366FF&bg1=FFFFFF&f=ifr" marginwidth="0" marginheight="0" width="160" height="600" border="0" frameborder="0" style="border:none;" scrolling="no"></iframe></TD>
    </TR>
  </TBODY>
</TABLE>
</BODY>
</HTML>