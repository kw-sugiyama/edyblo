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
require_once ( SYS_PATH."dbif/basedb_QaClass.php" );
require_once ( SYS_PATH."dbif/basedb_SchoolClass.php" );
require_once ( SYS_PATH."dbif/basedb_ClientClass.php" );
require_once ( SYS_PATH."common/base_common.php" );
require_once ( SYS_PATH."common/sys_common.php" );
require_once ( SYS_PATH."common/form_common.php" );
include_once ( SYS_PATH."common/error.class.php" );
include_once ( SYS_PATH."common/ImageControl.class.php" );
include_once ( SYS_PATH."configs/param_file.conf" );


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
if( $_POST['mode'] == "NEW" ){

	if($_POST['qa_cgid'] == "----")$_POST['qa_cgid'] = "";

	$obj_new = new basedb_QaClassTblAccess;
	$obj_new->conn = $obj_conn->conn;
	$obj_new->qadat[0]["qa_id"] = $_POST["qa_id"];
	$obj_new->qadat[0]["qa_stat"] = $_POST["qa_stat"];
	$obj_new->qadat[0]["qa_clid"] = $_POST["qa_clid"];
	$obj_new->qadat[0]["qa_cgid"] = $_POST["qa_cgid"];
	$obj_new->qadat[0]["qa_question"] = $_POST["qa_question"];
	$obj_new->qadat[0]["qa_answer"] = $_POST["qa_answer"];
	$obj_new->qadat[0]["qa_dispno"] = $_POST["qa_dispno"];
	$obj_new->qadat[0]["qa_adminid"] = $_POST["qa_adminid"];
	$obj_new->qadat[0]["qa_insdate"] = $_POST["qa_insdate"];
	$obj_new->qadat[0]["qa_upddate"] = $_POST["qa_upddate"];
	$obj_new->qadat[0]["qa_deldate"] = $_POST["qa_deldate"];
	$suc = $obj_new->basedb_InsQa();
	if( $suc == -1 ){
		$arrOther["ath_comment"] = "";
		$arrOther["ath_comment"] = "<INPUT TYPE=\"hidden\" NAME=\"stpos\" VALUE=\"{$_POST['stpos']}\">";
		$arrOther["ath_comment"] .= "<input type=\"hidden\" name=\"cg_type\" value=\"{$_POST['cg_type']}\" />";
		$arrOther["ath_comment"] .= "<input type=\"hidden\" name=\"cg_id\" value=\"{$_POST['qa_cgid']}\" />";
		$arrOther["ath_comment"] .= $athComment;
		$obj_error->ViewErrMessage( "INS_ERROR" , "ALL" , "qa_main.php" , $arrOther );
		exit;
	}
	if( $suc == 2 ){
		$arrOther["ath_comment"] = "";
		$arrOther["ath_comment"] = "<INPUT TYPE=\"hidden\" NAME=\"stpos\" VALUE=\"{$_POST['stpos']}\">";
		$arrOther["ath_comment"] .= "<input type=\"hidden\" name=\"cg_type\" value=\"{$_POST['cg_type']}\" />";
		$arrOther["ath_comment"] .= "<input type=\"hidden\" name=\"cg_id\" value=\"{$_POST['qa_cgid']}\" />";
		$arrOther["ath_comment"] .= $athComment;
		$obj_error->ViewErrMessage( "DISP_NO" , "ALL" , "qa_main.php" , $arrOther );
		exit;
	}
	if( $suc == 10 ){
		$arrOther["ath_comment"] = "";
		$arrOther["ath_comment"] = "<INPUT TYPE=\"hidden\" NAME=\"stpos\" VALUE=\"{$_POST['stpos']}\">";
		$arrOther["ath_comment"] .= "<input type=\"hidden\" name=\"cg_type\" value=\"{$_POST['cg_type']}\" />";
		$arrOther["ath_comment"] .= "<input type=\"hidden\" name=\"cg_id\" value=\"{$_POST['qa_cgid']}\" />";
		$arrOther["ath_comment"] .= $athComment;
		$obj_error->ViewErrMessage( "CATE_TOP_FLG" , "ALL" , "qa_main.php" , $arrOther );
		exit;
	}
	$message = "記事を登録しました。";

}else if( $_POST['mode'] == "EDIT" ){

	if($_POST['qa_cgid'] == "----")$_POST['qa_cgid'] = "";

	$obj_upd = new basedb_QaClassTblAccess;
	$obj_upd->conn = $obj_conn->conn;
	$obj_upd->qadat[0]["qa_id"] = $_POST["qa_id"];
	$obj_upd->qadat[0]["qa_stat"] = $_POST["qa_stat"];
	$obj_upd->qadat[0]["qa_clid"] = $_POST["qa_clid"];
	$obj_upd->qadat[0]["qa_cgid"] = $_POST["qa_cgid"];
	$obj_upd->qadat[0]["qa_question"] = $_POST["qa_question"];
	$obj_upd->qadat[0]["qa_answer"] = $_POST["qa_answer"];
	$obj_upd->qadat[0]["qa_dispno"] = $_POST["qa_dispno"];
	$obj_upd->qadat[0]["qa_adminid"] = $_POST["qa_adminid"];
	$obj_upd->qadat[0]["qa_insdate"] = $_POST["qa_insdate"];
	$obj_upd->qadat[0]["qa_upddate"] = $_POST["qa_upddate"];
	$obj_upd->qadat[0]["qa_deldate"] = $_POST["qa_deldate"];
	$suc = $obj_upd->basedb_UpdQa();
	if( $suc == -1 ){
		$arrOther["ath_comment"] = "";
		$arrOther["ath_comment"] = "<INPUT TYPE=\"hidden\" NAME=\"stpos\" VALUE=\"{$_POST['stpos']}\">";
		$arrOther["ath_comment"] .= "<input type=\"hidden\" name=\"cg_type\" value=\"{$_POST['cg_type']}\" />";
		$arrOther["ath_comment"] .= "<input type=\"hidden\" name=\"cg_id\" value=\"{$_POST['qa_cgid']}\" />";
		$arrOther["ath_comment"] .= $athComment;
		$obj_error->ViewErrMessage( "INS_ERROR" , "ALL" , "qa_main.php" , $arrOther );
		exit;
	}
	if( $suc == 2 ){
		$arrOther["ath_comment"] = "";
		$arrOther["ath_comment"] = "<INPUT TYPE=\"hidden\" NAME=\"stpos\" VALUE=\"{$_POST['stpos']}\">";
		$arrOther["ath_comment"] .= "<input type=\"hidden\" name=\"cg_type\" value=\"{$_POST['cg_type']}\" />";
		$arrOther["ath_comment"] .= "<input type=\"hidden\" name=\"cg_id\" value=\"{$_POST['qa_cgid']}\" />";
		$arrOther["ath_comment"] .= $athComment;
		$obj_error->ViewErrMessage( "DISP_NO" , "ALL" , "qa_main.php" , $arrOther );
		exit;
	}
	if( $suc == 10 ){
		$arrOther["ath_comment"] = "";
		$arrOther["ath_comment"] = "<INPUT TYPE=\"hidden\" NAME=\"stpos\" VALUE=\"{$_POST['stpos']}\">";
		$arrOther["ath_comment"] .= "<input type=\"hidden\" name=\"cg_type\" value=\"{$_POST['cg_type']}\" />";
		$arrOther["ath_comment"] .= "<input type=\"hidden\" name=\"cg_id\" value=\"{$_POST['qa_cgid']}\" />";
		$arrOther["ath_comment"] .= $athComment;
		$obj_error->ViewErrMessage( "CATE_TOP_FLG" , "ALL" , "qa_main.php" , $arrOther );
		exit;
	}
	$message = "記事を登録しました。";
	IF($_POST['qa_img_del_chk']==1){
		IF( file_exists($param_qa_img_path.$_POST['qa_img_lastupd'] ) && $_POST['qa_img_lastupd'] != "" ){
			unlink( $param_qa_img_path.$_POST['qa_img_lastupd'] );
		}
	}



}else if( $_POST['mode'] == "DEL" ){
	$obj_del = new basedb_QaClassTblAccess;
	$obj_del->conn = $obj_conn->conn;
	$obj_del->qadat[0]["qa_id"] = $_POST["qa_id"];
	$obj_del->qadat[0]["qa_upddate"] = $_POST["qa_upddate"];
	$suc = $obj_del->basedb_DelQa(0);
	if( $suc != 0 ){
		$arrOther["ath_comment"] = "<INPUT TYPE=\"hidden\" NAME=\"qa_clid\" VALUE=\"{$_POST['qa_clid']}\">";
		$arrOther["ath_comment"] .= "<input type=\"hidden\" name=\"cg_id\" value=\"{$_POST['qa_cgid']}\" />";
		$obj_error->ViewErrMessage( "DEL_ERROR" , "ALL" , "qa_main.php" , $arrOther );
		exit;
	}
	$message = "指定された記事情報を削除しました。";
	
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
      <form name="form1" action="qa_main.php" method="POST"> 
        <input type="submit" value=" 戻 る " class="btn" />
        <input type="hidden" name="cg_type" value="<?=$_POST['cg_type']?>" />
        <input type="hidden" name="cg_id" value="<?=$_POST['qa_cgid']?>" />
      </form>
    </div>
  </body>
</html>
