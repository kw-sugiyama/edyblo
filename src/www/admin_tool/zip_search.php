<?
/******************************************************************************
<< 不動産ブログ　Ver.1.O.0 >>
	Name: zip_search.php
	Version: 1.0.0
	Function: 郵便番号から住所検索
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
require_once ( SYS_PATH."dbif/dbcom_DBconnectMstClass.php" );
require_once ( SYS_PATH."dbif/basedb_AdminClass.php" );
require_once ( SYS_PATH."dbif/mstdb_ZipcodeClass.php" );
require_once ( SYS_PATH."common/base_common.php" );
require_once ( SYS_PATH."common/sys_common.php" );
require_once ( SYS_PATH."common/error.class.php" );


/*----------------------------------------------------------
  セッション登録開始
----------------------------------------------------------*/
session_start();


/*----------------------------------------------------------
  ＤＢ接続
----------------------------------------------------------*/
require_once( SYS_PATH."common/db_connect.php" );
require_once( SYS_PATH."common/db_connect_mst.php" );


/*----------------------------------------------------------
  ログイン情報チェック
----------------------------------------------------------*/
require_once("./login_chk.php");


/*--------------------------------------------------------
  値チェック
	@$_GET["fn"]  ... 値を入れ込みたいフォーム名
	@$_GET["zip"] ... 郵便番号値(例:370-0861)
	@$_GET["pc"]  ... 県コードを入れるフォーム要素名
	@$_GET["ad1"] ... 県名を入れるフォーム要素名
	@$_GET["adc"] ... 住所コードを入れるフォーム要素名
	@$_GET["ad2"] ... 市区郡名を入れるフォーム要素名
	@$_GET["ad3"] ... 町名を入れるフォーム要素名
--------------------------------------------------------*/
IF( $_GET["fn"] == "" || $_GET["zip"] == "" || $_GET["pc"] == "" || $_GET["ad1"] == "" || $_GET["adc"] == "" || $_GET["ad2"] == "" || $_GET["ad3"] == "" ){
	echo "値が不足しています。";
	exit;
}
IF( ereg( "^[0-9]{3}-[0-9]{4}$" , $_GET["zip"] === false ) ){
	echo "郵便番号が正しくありません。";
	exit;
}


/*--------------------------------------------------------
  郵便番号検索
--------------------------------------------------------*/
$obj_zip = new mstdb_ZipcodeClassTblAccess;
$obj_zip->conn = $obj_conn_mst->conn;
$obj_zip->jyoken["zp_zip"] = $_GET["zip"];
list( $ret , $cnt ) = $obj_zip->mstdb_GetZipcode( 1 , -1 );
IF( $ret == "-1" ){
	$syserr_msg = "システムエラーが発生しました。";
	echo $syserr_msg;
	exit;
}
//IF( $cnt != 1 ){
//	header("Content-Type:text/html;charset=EUC-JP");
//	echo "マスタ情報にエラーが発生しました。";
//	exit;
//}
$form_name = $_GET['fn'];
$zp_prefcd = $obj_zip->zipdat[0]["zp_prefcd"];
$zp_pref = $obj_zip->zipdat[0]["zp_pref"];
$zp_citycd = $obj_zip->zipdat[0]["zp_citycd"];
$zp_city = $obj_zip->zipdat[0]["zp_city"];
$zp_add = $obj_zip->zipdat[0]["zp_add"];

/*----------------------------------------------------------
  ＤＢ切断
----------------------------------------------------------*/
require_once( SYS_PATH."common/db_close_mst.php" );
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
    <SCRIPT language="javascript">
    	<!--
    	function SetZipAddress(){
    		
    		window.opener.document.<?=$form_name?>.<?=$_GET["pc"]?>.value = "<?=$zp_prefcd?>";
    		window.opener.document.<?=$form_name?>.<?=$_GET["ad1"]?>.value = "<?=$zp_pref?>";
    		window.opener.document.<?=$form_name?>.<?=$_GET["adc"]?>.value = "<?=$zp_citycd?>";
    		window.opener.document.<?=$form_name?>.<?=$_GET["ad2"]?>.value = "<?=$zp_city?>";
    		window.opener.document.<?=$form_name?>.<?=$_GET["ad3"]?>.value = "<?=$zp_add?>";
    		
    		window.close();
    	}
    	-->
    </SCRIPT>
    <NOSCRIPT><META http-equiv="Refresh" content="1;URL=./jserror.html"></NOSCRIPT>
  </HEAD>
  <BODY onLoad="SetZipAddress()">
    Weit .......
  </BODY>
</HTML>
