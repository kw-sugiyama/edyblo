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
require_once ( SYS_PATH."dbif/basedb_SchoolClass.php" );
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
if($_POST['sc_layout1']==1){
	$sc_layout1 = 1;
}else if($_POST['sc_layout2']==1){
	$sc_layout1 = 2;
}else if($_POST['sc_layout3']==1){
	$sc_layout1 = 3;
}else if($_POST['sc_layout4']==1){
	$sc_layout1 = 4;
}

if($_POST['sc_layout1']==2){
	$sc_layout2 = 1;
}else if($_POST['sc_layout2']==2){
	$sc_layout2 = 2;
}else if($_POST['sc_layout3']==2){
	$sc_layout2 = 3;
}else if($_POST['sc_layout4']==2){
	$sc_layout2 = 4;
}

if($_POST['sc_layout1']==3){
	$sc_layout3 = 1;
}else if($_POST['sc_layout2']==3){
	$sc_layout3 = 2;
}else if($_POST['sc_layout3']==3){
	$sc_layout3 = 3;
}else if($_POST['sc_layout4']==3){
	$sc_layout3 = 4;
}

if($_POST['sc_layout1']==4){
	$sc_layout4 = 1;
}else if($_POST['sc_layout2']==4){
	$sc_layout4 = 2;
}else if($_POST['sc_layout3']==4){
	$sc_layout4 = 3;
}else if($_POST['sc_layout4']==4){
	$sc_layout4 = 4;
}

if($_POST['sc_layout5']==1){
	$sc_layout5 = 1;
}else if($_POST['sc_layout6']==1){
	$sc_layout5 = 2;
}else if($_POST['sc_layout7']==1){
	$sc_layout5 = 3;
}else if($_POST['sc_layout8']==1){
	$sc_layout5 = 4;
}


if($_POST['sc_layout5']==2){
	$sc_layout6 = 1;
}else if($_POST['sc_layout6']==2){
	$sc_layout6 = 2;
}else if($_POST['sc_layout7']==2){
	$sc_layout6 = 3;
}else if($_POST['sc_layout8']==2){
	$sc_layout6 = 4;
}

if($_POST['sc_layout5']==3){
	$sc_layout7 = 1;
}else if($_POST['sc_layout6']==3){
	$sc_layout7 = 2;
}else if($_POST['sc_layout7']==3){
	$sc_layout7 = 3;
}else if($_POST['sc_layout8']==3){
	$sc_layout7 = 4;
}

if($_POST['sc_layout5']==4){
	$sc_layout8 = 1;
}else if($_POST['sc_layout6']==4){
	$sc_layout8 = 2;
}else if($_POST['sc_layout7']==4){
	$sc_layout8 = 3;
}else if($_POST['sc_layout8']==4){
	$sc_layout8 = 4;
}

$obj_new = new basedb_SchoolClassTblAccess;
$obj_new->conn = $obj_conn->conn;
$obj_new->blogdat[0]["sc_id"] = $_POST["sc_id"];
$obj_new->blogdat[0]["sc_clid"] = $_SESSION["_cl_id"];
$obj_new->blogdat[0]["sc_layout1"] = $sc_layout1;
$obj_new->blogdat[0]["sc_layout2"] = $sc_layout2;
$obj_new->blogdat[0]["sc_layout3"] = $sc_layout3;
$obj_new->blogdat[0]["sc_layout4"] = $sc_layout4;
$obj_new->blogdat[0]["sc_layout5"] = $sc_layout5;
$obj_new->blogdat[0]["sc_layout6"] = $sc_layout6;
$obj_new->blogdat[0]["sc_layout7"] = $sc_layout7;
$obj_new->blogdat[0]["sc_layout8"] = $sc_layout8;
//$obj_new->blogdat[0]["sc_layout9"] = $_POST["sc_layout9"];
$obj_new->blogdat[0]["sc_upddate"] = $_POST["sc_upddate"];
$suc = $obj_new->basedb_TopSchool();
if( $suc == -1 ){
	$arrOther["ath_comment"] = "";
	$arrOther["ath_comment"] = "<INPUT TYPE=\"hidden\" NAME=\"stpos\" VALUE=\"{$_POST['stpos']}\">";
	$arrOther["ath_comment"] .= "<input type=\"hidden\" name=\"cg_type\" value=\"{$_POST['cg_type']}\" />";
	$arrOther["ath_comment"] .= $athComment;
	$obj_error->ViewErrMessage( "INS_ERROR" , "ALL" , "layout_main.php" , $arrOther );
	exit;
}
if( $suc == 2 ){
	$arrOther["ath_comment"] = "";
	$arrOther["ath_comment"] = "<INPUT TYPE=\"hidden\" NAME=\"stpos\" VALUE=\"{$_POST['stpos']}\">";
	$arrOther["ath_comment"] .= "<input type=\"hidden\" name=\"cg_type\" value=\"{$_POST['cg_type']}\" />";
	$arrOther["ath_comment"] .= $athComment;
	$obj_error->ViewErrMessage( "DISP_NO" , "ALL" , "layout_main.php" , $arrOther );
	exit;
}
if( $suc == 10 ){
	$arrOther["ath_comment"] = "";
	$arrOther["ath_comment"] = "<INPUT TYPE=\"hidden\" NAME=\"stpos\" VALUE=\"{$_POST['stpos']}\">";
	$arrOther["ath_comment"] .= "<input type=\"hidden\" name=\"cg_type\" value=\"{$_POST['cg_type']}\" />";
	$arrOther["ath_comment"] .= $athComment;
	$obj_error->ViewErrMessage( "CATE_TOP_FLG" , "ALL" , "layout_main.php" , $arrOther );
	exit;
}
$message = "ＴＯＰ画面レイアウト情報を修正しました。";


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
      <form name="form1" action="layout_main.php" method="POST"> 
        <input type="submit" value=" 戻 る " class="btn" />
        <input type="hidden" name="cg_type" value="<?=$_POST['cg_type']?>" />
      </form>
    </div>
  </body>
</html>
