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
require_once ( SYS_PATH."dbif/basedb_ClientClass.php" );
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
IF( ereg( "^[0-9]{3}-[0-9]{4}$" , $_GET["zip"] ) === false ){
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
	echo $syserr_msg;
	exit;
}
IF( $cnt != 1 ){
	echo "指定された郵便番号はマスタに登録されておりません。";
	exit;
}
$form_name = $_GET['fn'];
$pref = $obj_zip->zipdat[0]["zp_pref"];
$prefcd = $obj_zip->zipdat[0]["zp_prefcd"];
$city = $obj_zip->zipdat[0]["zp_city"];
$citycd = $obj_zip->zipdat[0]["zp_citycd"];
$add = $obj_zip->zipdat[0]["zp_add"];

//print_r($obj_zip->zipdat);


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
		var cnt = <?=$pref_cd?>-1;
		window.opener.document.<?=$form_name?>.pref.value = "<?=$pref?>";
    		window.opener.document.<?=$form_name?>.city.value = "<?=$city?>";
    		window.opener.document.<?=$form_name?>.add.value = "<?=$add?>";
    		
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
