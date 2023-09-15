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
require_once ( SYS_PATH."configs/param_kodawari.conf" );


/*----------------------------------------------------------
  ＤＢ接続
----------------------------------------------------------*/
require_once( SYS_PATH."common/db_connect.php" );
require_once( SYS_PATH."common/db_connect_mst.php" );


/*--------------------------------------------------------
  郵便番号検索
--------------------------------------------------------*/
$_GET["address_select"] = urldecode($_GET["address_select"]);
$_GET["address_select"] = mb_convert_encoding($_GET["address_select"],"EUC-JP","UTF-8");

$obj_zip = new mstdb_ZipcodeClassTblAccess;
$obj_zip->conn = $obj_conn_mst->conn;
$obj_zip->jyoken["address_select"] = $_GET["address_select"];
list( $ret , $cnt ) = $obj_zip->mstdb_GetZipcode( 1 , -1 );
IF( $ret == "-1" ){
	echo $syserr_msg;
	exit;
}
IF( $ret != "0" ){
	echo "指定された郵便番号はマスタに登録されておりません。";
	exit;
}


/*--------------------------------------------------------
  県
--------------------------------------------------------*/
reset( $param_search_pref );
asort( $param_search_pref["disp_no"] );
$build_pref_value = "";
FOREACH( $param_search_pref["disp_no"] as $key => $val ){
	$selected = "";
	IF( $param_search_pref['id'][$key] == $obj_zip->zipdat[0]["zp_prefcd"] ) $selected = " selected";
	$param_search_pref['id'][$key] = mb_convert_encoding($param_search_pref['id'][$key],"UTF-8","EUC-JP");
	$param_search_pref['val2'][$key] = mb_convert_encoding($param_search_pref['val2'][$key],"UTF-8","EUC-JP");
	$build_pref_value .= "<OPTION value=\"{$param_search_pref['val2'][$key]}\"{$selected}>{$param_search_pref['val2'][$key]}</OPTION>\n";
}


/*------------------------------------------------------------
  DB切断
------------------------------------------------------------*/
require_once( SYS_PATH."common/db_close.php" );


/*------------------------------------------------------------
  文字コード変換
------------------------------------------------------------*/
$obj_zip->zipdat[0]["zp_zip"] = mb_convert_encoding($obj_zip->zipdat[0]["zp_zip"],"UTF-8","EUC-JP");
$zip = split("-",$obj_zip->zipdat[0]["zp_zip"]);
$obj_zip->zipdat[0]["zp_prefcd"] = mb_convert_encoding($obj_zip->zipdat[0]["zp_prefcd"],"UTF-8","EUC-JP");
$obj_zip->zipdat[0]["zp_pref"] = mb_convert_encoding($obj_zip->zipdat[0]["zp_pref"],"UTF-8","EUC-JP");
$obj_zip->zipdat[0]["zp_citycd"] = mb_convert_encoding($obj_zip->zipdat[0]["zp_citycd"],"UTF-8","EUC-JP");
$obj_zip->zipdat[0]["zp_city"] = mb_convert_encoding($obj_zip->zipdat[0]["zp_city"],"UTF-8","EUC-JP");
$obj_zip->zipdat[0]["zp_add"] = mb_convert_encoding($obj_zip->zipdat[0]["zp_add"],"UTF-8","EUC-JP");


/*------------------------------------------------------------
  表示値生成
------------------------------------------------------------*/
$arrViewList["mnt_address"] .= "	      <table class=\"zip\" style=\"width:400px\"><tr>\n";
$arrViewList["mnt_address"] .= "	      <td class=\"zip\" align=\"right\" width=\"60px\">〒</td><td class=\"zip\"><input id=\"i4\" type=\"text\" name=\"cl_zip1\" value=\"{$zip[0]}\" style=\"width:40px\" maxlength=\"3\" onFocus='Text(\"i4\", 1)' onBlur='Text(\"i4\", 2)' />\n";
$arrViewList["mnt_address"] .= "	      -<input id=\"i11\" type=\"text\" name=\"cl_zip2\" value=\"{$zip[1]}\" style=\"width:50px\" maxlength=\"4\" onFocus='Text(\"i11\", 1)' onBlur='Text(\"i11\", 2)' />\n";
$arrViewList["mnt_address"] .= "	      <input type=\"button\" value=\"住所取得\" style=\"width:80px\" onclick=\"return zipSearch()\"></td>\n";
$arrViewList["mnt_address"] .= "	      </tr><tr>\n";
$arrViewList["mnt_address"] .= "              <td class=\"zip\" align=\"right\" width=\"60px\">都道府県</td><td class=\"zip\">\n";
$arrViewList["mnt_address"] .= "              <select name=\"cl_pref\">\n";
$arrViewList["mnt_address"] .= $build_pref_value;
$arrViewList["mnt_address"] .= "	      </select>\n";
$arrViewList["mnt_address"] .= "	      </tr><tr>\n";
$arrViewList["mnt_address"] .= "              <td class=\"zip\" align=\"right\" width=\"60px\">市区町村</td><td class=\"zip\"><input type=\"text\" name=\"cl_city\" value=\"{$obj_zip->zipdat[0]["zp_city"]}\" maxlength=\"80\" style=\"width:150px\" readonly /></td>\n";
$arrViewList["mnt_address"] .= "	      </tr><tr>\n";
$arrViewList["mnt_address"] .= "              <td class=\"zip\" align=\"right\" width=\"60px\">番地</td><td class=\"zip\"><input id=\"i14\" type=\"text\" name=\"cl_add\" value=\"{$obj_zip->zipdat[0]["zp_add"]}\" maxlength=\"80\" style=\"width:150px\" onFocus='Text(\"i14\", 1)' onBlur='Text(\"i14\", 2)' /><em>(例：南青山1-16-2)</em><td>\n";
$arrViewList["mnt_address"] .= "	      </tr><tr>\n";
$arrViewList["mnt_address"] .= "              <td class=\"zip\" align=\"right\" width=\"60px\">建物名</td><td class=\"zip\"><input id=\"i15\" type=\"text\" name=\"cl_estate\" value=\"\" maxlength=\"80\" style=\"width:150px\" onFocus='Text(\"i15\", 1)' onBlur='Text(\"i15\", 2)' /><em>(例：SASAKIビル3F)</em></td>\n";
$arrViewList["mnt_address"] .= "	      <input type=\"hidden\" name=\"cl_prefcd\" value=\"{$obj_zip->zipdat[0]["zp_prefcd"]}\">\n";
$arrViewList["mnt_address"] .= "	      <input type=\"hidden\" name=\"cl_citycd\" value=\"{$obj_zip->zipdat[0]["zp_citycd"]}\">\n";
$arrViewList["mnt_address"] .= "	      </tr></table>\n";


$arrViewList["mnt_address"] = mb_convert_encoding($arrViewList["mnt_address"],"EUC-JP","UTF-8");

/*------------------------------------------------------------
  住所フォーム表示
------------------------------------------------------------*/
print($arrViewList["mnt_address"]);


?>