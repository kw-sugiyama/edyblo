<?
/******************************************************************************
<< 不動産ブログ　Ver.1.0.0 >>
    Name: top.php
    Version: 1.0.0
    Function: 画面上部ロゴ
    Author: Click inc
    Date of creation: 2007/02
    History of modification:

    Copyright (C)2007 Click, inc. All Rights Reserverd.
******************************************************************************/

/*----------------------------------------------------------
  必要ファイル呼び出し
----------------------------------------------------------*/
require_once ( "./ini_sets_1.php" );
require_once ( SYS_PATH."dbif/dbcom_DBconnectClass.php" );
require_once ( SYS_PATH."dbif/basedb_ClientClass.php" );
require_once ( SYS_PATH."common/error.class.php" );
require_once ( SYS_PATH."common/sys_common.php" );


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
<HTML>
  <HEAD>
    <TITLE>不動産ブログ - クライアント管理ツール</TITLE>
    <META http-equiv="Content-Type" content="text/html;charset=EUC-JP" />
    <META http-equiv="Content-Style-Type" content="text/css" />
    <META http-equiv="Content-Script-Type" content="text/javascript" />
    <LINK rel="stylesheet" href="./share/css/bottom.css" type="text/css" />
    <NOSCRIPT><META http-equiv="Refresh" content="1;URL=./jserror.html"></NOSCRIPT>
  </HEAD>
  <BODY leftmargin="0" marginwidth="0" topmargin="0" marginheight="0">
    <DIV id="bottom"></DIV>
    <DIV id="bottom_msg">
      2014 Noang All Rights Reserved.
    </DIV>
  </BODY>
</HTML>
