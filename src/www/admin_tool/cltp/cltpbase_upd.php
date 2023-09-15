<?
/******************************************************************************
<< 不動産ブログ　Ver.1.O.0 >>
	Name: cltpbase_upd.php
	Version: 1.0.0
	Function: 基本情報 登録／修正／削除
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
require_once ( SYS_PATH."dbif/basedb_CltpbaseClass.php" );
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
$athComment = "";
$athComment .= "<INPUT TYPE=\"hidden\" NAME=\"error_mode\" VALUE=\"on\">";
FOREACH( $_POST as $key => $val ){
	$val = htmlspecialchars( stripslashes( $val ) );
        $athComment .= "<INPUT type=\"hidden\" name=\"{$key}\" value=\"{$val}\">\n";
}


$obj_rev = new basedb_CltpbaseClassTblAccess;
$obj_rev->conn = $obj_conn->conn;
$obj_rev->cltpbasedat[0]["cltpbase_id"]               = $_POST["cltpbase_id"];
$obj_rev->cltpbasedat[0]["cltpbase_cl_id"]            = 1;
$obj_rev->cltpbasedat[0]["cltpbase_topic_title_1"]    = $_POST["cltpbase_topic_title_1"];
$obj_rev->cltpbasedat[0]["cltpbase_topic_contents_1"] = $_POST["cltpbase_topic_contents_1"];
$obj_rev->cltpbasedat[0]["cltpbase_topic_link_1"]     = $_POST["cltpbase_topic_link_1"];
$obj_rev->cltpbasedat[0]["cltpbase_topic_title_2"]    = $_POST["cltpbase_topic_title_2"];
$obj_rev->cltpbasedat[0]["cltpbase_topic_contents_2"] = $_POST["cltpbase_topic_contents_2"];
$obj_rev->cltpbasedat[0]["cltpbase_topic_link_2"]     = $_POST["cltpbase_topic_link_2"];
$obj_rev->cltpbasedat[0]["cltpbase_topic_title_3"]    = $_POST["cltpbase_topic_title_3"];
$obj_rev->cltpbasedat[0]["cltpbase_topic_contents_3"] = $_POST["cltpbase_topic_contents_3"];
$obj_rev->cltpbasedat[0]["cltpbase_topic_link_3"]     = $_POST["cltpbase_topic_link_3"];
$obj_rev->cltpbasedat[0]["cltpbase_html"]             = $_POST["cltpbase_html"];
$obj_rev->cltpbasedat[0]["cltpbase_upd_date"]         = $_POST["cltpbase_upd_date"];
$suc = $obj_rev->basedb_UpdCltpbase();


echo $obj_rev->php_error;
//exit;

if( $suc == -1 ){
echo("#6#error#");
	$arrOther["ath_comment"] = "";
	$arrOther["ath_comment"] = "<INPUT TYPE=\"hidden\" NAME=\"stpos\" VALUE=\"{$_POST['stpos']}\">";
	$arrOther["ath_comment"] .= $athComment;
	$obj_error->ViewErrMessage( "UPD_ERROR" , "ALL" , "cltpbase_mnt.php" , $arrOther );
	exit;
}
$message = "基本情報を修正しました。";


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
    <TITLE>不動産ブログ - 記事修正</title>
    <META http-equiv="Content-Type" content="text/html;charset=EUC-JP" />
    <META http-equiv="Content-Style-Type" content="text/css" />
    <META http-equiv="Content-Script-Type" content="text/javascript" />
    <LINK rel="stylesheet" href="../share/css/cltpcontents.css" type="text/css" />
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
      <form name="form1" action="cltpbase_main.php" method="POST"> 
        <input type="submit" value=" 戻 る " class="btn" />
      </form>
    </div>
  </body>
</html>
