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
require_once ( SYS_PATH."dbif/basedb_LeftmenuClass.php" );
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
print_r($_POST);

if( $_POST['mode'] == "NEW" ){

	$obj_new = new basedb_LeftmenuClassTblAccess;
	$obj_new->conn = $obj_conn->conn;
	$obj_new->leftmenudat[0]["lm_clid"] = $_SESSION["_cl_id"];
	$obj_new->leftmenudat[0]["lm_stat"] = $_POST["lm_stat"];
	$obj_new->leftmenudat[0]["lm_type"] = $_POST["lm_type"];
	$obj_new->leftmenudat[0]["lm_title"] = $_POST["lm_title"];
	$obj_new->leftmenudat[0]["lm_dispno"] = $_POST["lm_dispno"];
	$obj_new->leftmenudat[0]["lm_adminid"] = $_POST["lm_adminid"];
	$obj_new->leftmenudat[0]["lm_insdate"] = $_POST["lm_insdate"];
	$obj_new->leftmenudat[0]["lm_upddate"] = $_POST["lm_upddate"];
	$obj_new->leftmenudat[0]["lm_deldate"] = $_POST["lm_deldate"];
	$suc = $obj_new->basedb_InsLeftmenu();
	if($layout_suc_new == -1){
		$obj_error->ViewErrMessage( "SYSTEM" , "ALL" , "blog_mnt.php" , $arrOther  );
		exit;
	}
	$message = "カテゴリを登録しました。";


}else if( $_POST['mode'] == "EDIT" ){

	// ロゴ画像
	if( filesize($_FILES["lm_img"]["tmp_name"]) > (1024*1024*2) ){
		$arrOther["ath_comment"] = "<INPUT TYPE=\"hidden\" NAME=\"lm_csid\" VALUE=\"{$_POST['lm_csid']}\">";
		$arrOther["ath_comment"] .= $athComment;
		$obj_error->ViewErrMessage( "FILE_SIZE" , "ALL" , "room_mnt.php" , $arrOther );
		exit;
	}
	IF( is_uploaded_file( $_FILES["lm_img"]["tmp_name"] ) ){
		$imageInfo = @getimagesize( $_FILES["lm_img"]["tmp_name"] );
		IF( @getimagesize( $_FILES["lm_img"]["tmp_name"] ) === FALSE || ( $imageInfo[2] != 1 && $imageInfo[2] != 2 ) ){
			$arrOther["ath_comment"] = "<INPUT TYPE=\"hidden\" NAME=\"lm_csid\" VALUE=\"{$_POST['lm_csid']}\">";
			$arrOther["ath_comment"] .= $athComment;
                	$obj_error->ViewErrMessage( "NOT_IMG" , "ALL" , "room_mnt.php" , $arrOther );
                        exit;
		}
		$kakuLayout = split("\.",$_FILES["lm_img"]["name"]);
		$leftmenu_img_org = "leftmenu_".$_SESSION['_cl_id']."_".$_POST["lm_id"].".".$kakuLayout[1];
	}

	if($_POST['lm_cateid'] == "----")$_POST['lm_cateid'] = "";

	$obj_upd = new basedb_LeftmenuClassTblAccess;
	$obj_upd->conn = $obj_conn->conn;
	$obj_upd->leftmenudat[0]["lm_id"] = $_POST["lm_id"];
	$obj_upd->leftmenudat[0]["lm_clid"] = $_SESSION["_cl_id"];
	$obj_upd->leftmenudat[0]["lm_stat"] = $_POST["lm_stat"];
	$obj_upd->leftmenudat[0]["lm_type"] = $_POST["lm_type"];
	$obj_upd->leftmenudat[0]["lm_title"] = $_POST["lm_title"];
	$obj_upd->leftmenudat[0]["lm_dispno"] = $_POST["lm_dispno"];
	$obj_upd->leftmenudat[0]["lm_adminid"] = $_POST["lm_adminid"];
	$obj_upd->leftmenudat[0]["lm_insdate"] = $_POST["lm_insdate"];
	$obj_upd->leftmenudat[0]["lm_upddate"] = $_POST["lm_upddate"];
	$obj_upd->leftmenudat[0]["lm_deldate"] = $_POST["lm_deldate"];
	$suc = $obj_upd->basedb_UpdLeftmenu();
	if( $suc == -1 ){
		$arrOther["ath_comment"] = "";
		$arrOther["ath_comment"] = "<INPUT TYPE=\"hidden\" NAME=\"stpos\" VALUE=\"{$_POST['stpos']}\">";
		$arrOther["ath_comment"] .= "<input type=\"hidden\" name=\"cg_type\" value=\"{$_POST['cg_type']}\" />";
		$arrOther["ath_comment"] .= $athComment;
		$obj_error->ViewErrMessage( "INS_ERROR" , "ALL" , "leftmenu_main.php" , $arrOther );
		exit;
	}
	$message = "カテゴリを登録しました。";


}else if( $_POST['mode'] == "DEL" ){

	$obj_del = new basedb_LeftmenuClassTblAccess;
	$obj_del->conn = $obj_conn->conn;
	$obj_del->leftmenudat[0]["lm_id"] = $_POST["lm_id"];
	$obj_del->leftmenudat[0]["lm_upddate"] = $_POST["lm_upddate"];
	$suc = $obj_del->basedb_DelLeftmenu(0);
	if( $suc != 0 ){
		$arrOther["ath_comment"] = "<INPUT TYPE=\"hidden\" NAME=\"lm_csid\" VALUE=\"{$_POST['lm_csid']}\">";
		$obj_error->ViewErrMessage( "DEL_ERROR" , "ALL" , "leftmenu_main.php" , $arrOther );
		exit;
	}
	IF( $suc == "0" ){
		// 画像を削除
		IF( file_exists($param_leftmenu_img_path.$_POST['lm_img_lastupd'] ) && $_POST["lm_img_lastupd"] != "" ){
			unlink( $param_leftmenu_img_path.$_POST['lm_img_lastupd'] );
		}
	}
	$message = "指定された部屋情報を削除しました。";
	
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
    <TITLE>不動産ブログ - カテゴリ登録･修正･削除</title>
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
      <form name="form1" action="leftmenu_main.php" method="POST"> 
        <input type="submit" value=" 戻 る " class="btn" />
        <input type="hidden" name="cg_id" value="<?=$_POST['cg_id']?>" />
        <input type="hidden" name="cs_id" value="<?=$_POST['cs_id']?>" />
        <input type="hidden" name="cg_type" value="<?=$_POST['cg_type']?>" />
        <input type="hidden" name="cp_id" value="<?=$_POST['lm_csid']?>" />
      </form>
    </div>
  </body>
</html>
