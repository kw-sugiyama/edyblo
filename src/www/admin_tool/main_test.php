<?
/******************************************************************************
<< 不動産ブログ　Ver.1.0.0 >>
	Name: main.php
	Version: 1.0.0
	Function: メイン画面フレーム定義
	Author: Click inc
	Date of creation: 2007/02
	History of modification:

	Copyright (C)2006 Click, inc. All Rights Reserverd.
******************************************************************************/

/*----------------------------------------------------------
  必要ファイル呼び出し
----------------------------------------------------------*/
require_once ( "./ini_sets_1.php" );
require_once ( SYS_PATH."dbif/dbcom_DBcntlClass.php");
require_once ( SYS_PATH."dbif/dbcom_DBconnectClass.php" );
require_once ( SYS_PATH."dbif/basedb_AdminClass.php" );
require_once ( SYS_PATH."common/error.class.php" );


/*----------------------------------------------------------
  エラークラス - インスタンス
----------------------------------------------------------*/
$obj_error = new DispErrMessage();


/*----------------------------------------------------------
  セッション登録開始
----------------------------------------------------------*/
session_start();


/*----------------------------------------------------------
  ＤＢ接続
----------------------------------------------------------*/
require_once( SYS_PATH."common/db_connect.php" );

/*----------------------------------------------------------
	セッション情報登録
---------------------------------------------------------*/
$_SESSION['ad_id'] = addslashes( $obj->admindat[0]["ad_id"] );
$_SESSION['ad_logincd'] = $obj->admindat[0]["ad_logincd"];
$_SESSION['ad_passcd'] = $obj->admindat[0]["ad_passcd"];
$_SESSION['ad_auth'] = addslashes( $obj->admindat[0]["ad_auth"]);

require_once( SYS_PATH."php/disp_main_test.php" );

/*----------------------------------------------------------
  ＤＢ切断
----------------------------------------------------------*/
require_once( SYS_PATH."common/db_close.php" );


/*-------------------------------------------------------------
    ＨＴＭＬ表示
-------------------------------------------------------------*/
require_once( SYS_PATH."templates/main_test.tpl" );

?>
