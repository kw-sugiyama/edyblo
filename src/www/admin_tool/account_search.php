<?
/******************************************************************************
<< 不動産ブログ　Ver.1.O.0 >>
	Name: account_search.php
	Version: 1.0.0
	Function: ＵＲＬ用コードの重複確認
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
require_once ( SYS_PATH."dbif/basedb_AdminClass.php" );
require_once ( SYS_PATH."dbif/basedb_ClientClass.php" );
require_once ( SYS_PATH."common/error.class.php" );
require_once ( SYS_PATH."common/sys_common.php" );


/*----------------------------------------------------------
  セッション登録開始
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


/*--------------------------------------------------------
  値チェック
--------------------------------------------------------*/
IF( ereg( "^[a-z0-9_]+$" , $_GET["ac"] ) === false ){
	echo "URL用コードが正しくありません。";
	exit;
}
IF( $_GET["ci"] != "" ){
	IF( ereg( "^[0-9]+$" , $_GET["ci"] ) === false ){
		echo "クライアントコードが正しくありません。";
		exit;
	}
}


/*--------------------------------------------------------
  指定URLコード既存ありチェック
--------------------------------------------------------*/
$obj_cl = new basedb_ClientClassTblAccess;
$obj_cl->conn = $obj_conn->conn;
$obj_cl->jyoken["cl_urlcd"] = $_GET["ac"];
$obj_cl->jyoken["cl_deldate"] = 1;
IF( $_GET["ci"] != "" ){
	$obj_cl->jyoken["cl_id_not"] = $_GET["ci"];
}
list( $cnt , $total ) = $obj_cl->basedb_GetClient( 1 , -1 );
IF( $cnt == "-1" ){
	echo "システムエラーが発生しました。管理者に連絡して下さい。";
	exit;
}

IF( $cnt >= 1 ){
	$viewComment = "このURL用コードは既に登録されています。";
}ELSE{
	$viewComment = "このURL用コードは登録可能です。";
}


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
    <TITLE>不動産ブログ - アカウント管理ツール</TITLE>
    <META http-equiv="Content-Type" content="text/html;charset=EUC-JP" />
    <META http-equiv="Content-Style-Type" content="text/css" />
    <META http-equiv="Content-Script-Type" content="text/javascript" />
    <NOSCRIPT><META http-equiv="Refresh" content="1;URL=./jserror.html"></NOSCRIPT>
  </HEAD>
  <BODY width="200" height="100">
    <CENTER>
      <?=$viewComment?>
      <br />
      <INPUT type="button" value="閉じる" onClick="window.close();" />
    </CENTER>
  </BODY>
</HTML>
