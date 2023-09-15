<?
/******************************************************************************
<< 不動産ブログ　Ver.1.O.0 >>
	Name: category_upd.php
	Version: 1.0.0
	Function: カテゴリ情報 登録／修正／削除
	Author: Click inc
	Date of creation: 2007/02
	History of modification:

	Copyright (C)2007 Click, inc. All Rights Reserverd.
******************************************************************************/

/*----------------------------------------------------------
  必要ファイル呼び出し
----------------------------------------------------------*/
require_once ( "../ini_sets_2.php" );
require_once ( SYS_PATH."dbif/dbcom_DBconnectClass.php" );
require_once ( SYS_PATH."dbif/basedb_AdminClass.php" );
require_once ( SYS_PATH."dbif/basedb_CategoryClass.php" );
require_once ( SYS_PATH."dbif/basedb_MenuClass.php" );
require_once ( SYS_PATH."dbif/basedb_ClientClass.php" );
require_once ( SYS_PATH."common/base_common.php" );
require_once ( SYS_PATH."common/sys_common.php" );
include_once ( SYS_PATH."common/error.class.php" );


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
require_once("../login_chk.php");


/*---------------------------------------------------------
	処理部分
---------------------------------------------------------*/
$obj_new = new basedb_MenuClassTblAccess;
$obj_new->conn = $obj_conn->conn;
$obj_new->menudat[0]["mn_id"] = $_POST["mn_id"];
$obj_new->menudat[0]["mn_upddate"] = $_POST["mn_upddate"];
$obj_new->menudat[0]["mn_clid"] = $_SESSION["_cl_id"];
$obj_new->menudat[0]["mn_lstat"] = $_POST["mn_lstat"];
$obj_new->menudat[0]["mn_lname"] = $_POST["mn_lname"];
$obj_new->menudat[0]["mn_ldispno"] = $_POST["mn_ldispno"];
$obj_new->menudat[0]["mn_hstat"] = $_POST["mn_hstat"];
$obj_new->menudat[0]["mn_hdispno"] = $_POST["mn_hdispno"];
$obj_new->menudat[0]["mn_hname"] = $_POST["mn_hname"];
$obj_new->menudat[0]["mn_hurl"] = $_POST["mn_hurl"];
$obj_new->menudat[0]["mn_adminid"] = $_POST["mn_adminid"];
$suc = $obj_new->basedb_UpdMenu();
if( $suc == -1 ){
	$arrOther["ath_comment"] = "";
	$arrOther["ath_comment"] = "<INPUT TYPE=\"hidden\" NAME=\"stpos\" VALUE=\"{$_POST['stpos']}\">";
	$arrOther["ath_comment"] .= "<input type=\"hidden\" name=\"cg_type\" value=\"{$_POST['cg_type']}\" />";
	$arrOther["ath_comment"] .= $athComment;
	$obj_error->ViewErrMessage( "INS_ERROR" , "ALL" , "menu_main.php" , $arrOther );
	exit;
}
if( $suc == 2 ){
	$arrOther["ath_comment"] = "";
	$arrOther["ath_comment"] = "<INPUT TYPE=\"hidden\" NAME=\"stpos\" VALUE=\"{$_POST['stpos']}\">";
	$arrOther["ath_comment"] .= "<input type=\"hidden\" name=\"cg_type\" value=\"{$_POST['cg_type']}\" />";
	$arrOther["ath_comment"] .= $athComment;
	$obj_error->ViewErrMessage( "DISP_NO" , "ALL" , "menu_main.php" , $arrOther );
	exit;
}
if( $suc == 10 ){
	$arrOther["ath_comment"] = "";
	$arrOther["ath_comment"] = "<INPUT TYPE=\"hidden\" NAME=\"stpos\" VALUE=\"{$_POST['stpos']}\">";
	$arrOther["ath_comment"] .= "<input type=\"hidden\" name=\"cg_type\" value=\"{$_POST['cg_type']}\" />";
	$arrOther["ath_comment"] .= $athComment;
	$obj_error->ViewErrMessage( "CATE_TOP_FLG" , "ALL" , "menu_main.php" , $arrOther );
	exit;
}
$message = "カテゴリを登録しました。";


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
    <TITLE>塾ブログ - カテゴリ登録･修正･削除</title>
    <META http-equiv="Content-Type" content="text/html;charset=EUC-JP" />
    <META http-equiv="Content-Style-Type" content="text/css" />
    <META http-equiv="Content-Script-Type" content="text/javascript" />
    <LINK rel="stylesheet" href="../share/css/category.css" type="text/css" />
    <NOSCRIPT><META http-equiv="Refresh" content="1;URL=../jserror.html"></NOSCRIPT>
  </HEAD>
  <BODY>
    <div align="center">
      <input type="hidden" name="stpos" value="1">
      <table width="400" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td align="center">
            <br /><br /><br /><br /><br />
            <font size="3" color="#FF6600"><?=$message?></font>
            <br /><br /><br />
          </td>
        </tr>
      </table>
      <form name="form1" action="menu_main.php" method="POST"> 
        <input type="submit" value=" 戻 る " class="btn" />
        <input type="hidden" name="cg_type" value="<?=$_POST['cg_type']?>" />
      </form>
    </div>
  </body>
</html>
