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
require_once ( SYS_PATH."dbif/basedb_AdmissionClass.php" );
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
	// 各種画像チェック
 	if( filesize($_FILES["as_img"]["tmp_name"]) > (1024*1024*2) ){
		$arrOther["ath_comment"] = "<INPUT TYPE=\"hidden\" NAME=\"as_clid\" VALUE=\"{$_POST['as_clid']}\">";
		$arrOther["ath_comment"] .= "<input type=\"hidden\" name=\"cg_id\" value=\"{$_POST['as_cgid']}\" />";
		$arrOther["ath_comment"] .= $athComment;
		$obj_error->ViewErrMessage( "FILE_SIZE" , "ALL" , "admission_main.php" , $arrOther );
		exit;
	}
	IF( is_uploaded_file( $_FILES["as_img"]["tmp_name"] ) ){
		$imageInfo = @getimagesize( $_FILES["as_img"]["tmp_name"] );
		IF( @getimagesize( $_FILES["as_img"]["tmp_name"] ) === FALSE || ( $imageInfo[2] != 1 && $imageInfo[2] != 2 ) ){
			$arrOther["ath_comment"] = "<INPUT TYPE=\"hidden\" NAME=\"as_clid\" VALUE=\"{$_POST['as_clid']}\">";
			$arrOther["ath_comment"] .= "<input type=\"hidden\" name=\"cg_id\" value=\"{$_POST['as_cgid']}\" />";
			$arrOther["ath_comment"] .= $athComment;
			$obj_error->ViewErrMessage( "NOT_IMG" , "ALL" , "admission_main.php" , $arrOther );
			exit;
		}
		$kakuLayout = split("\.",$_FILES["as_img"]["name"]);
		$admission_img_org = "admission_".$_SESSION['_cl_id']."_".$_POST["as_id"].".".$kakuLayout[1];
	}

	if($_POST['as_cgid'] == "----")$_POST['as_cgid'] = "";

	$obj_new = new basedb_AdmissionClassTblAccess;
	$obj_new->conn = $obj_conn->conn;
	$obj_new->admissiondat[0]["as_id"] = $_POST["as_id"];
	$obj_new->admissiondat[0]["as_stat"] = $_POST["as_stat"];
	$obj_new->admissiondat[0]["as_clid"] = $_POST["as_clid"];
	$obj_new->admissiondat[0]["as_cgid"] = $_POST["as_cgid"];
	$obj_new->admissiondat[0]["as_title"] = $_POST["as_title"];
	IF( is_uploaded_file($_FILES["as_img"]["tmp_name"]) ){
		$obj_new->admissiondat[0]["as_imgorg"] = $_FILES["as_img"]["name"];
		$obj_new->admissiondat[0]["as_img"] = $admission_img_org;
	}
	$obj_new->admissiondat[0]["as_contents"] = $_POST["as_contents"];
	$obj_new->admissiondat[0]["as_dispno"] = $_POST["as_dispno"];
	$obj_new->admissiondat[0]["as_adminid"] = $_POST["as_adminid"];
	$obj_new->admissiondat[0]["as_insdate"] = $_POST["as_insdate"];
	$obj_new->admissiondat[0]["as_upddate"] = $_POST["as_upddate"];
	$obj_new->admissiondat[0]["as_deldate"] = $_POST["as_deldate"];
	$suc = $obj_new->basedb_InsAdmission();
	if( $suc == -1 ){
		$arrOther["ath_comment"] = "";
		$arrOther["ath_comment"] = "<INPUT TYPE=\"hidden\" NAME=\"stpos\" VALUE=\"{$_POST['stpos']}\">";
		$arrOther["ath_comment"] .= "<input type=\"hidden\" name=\"cg_type\" value=\"{$_POST['cg_type']}\" />";
		$arrOther["ath_comment"] .= "<input type=\"hidden\" name=\"cg_id\" value=\"{$_POST['as_cgid']}\" />";
		$arrOther["ath_comment"] .= $athComment;
		$obj_error->ViewErrMessage( "INS_ERROR" , "ALL" , "admission_main.php" , $arrOther );
		exit;
	}
	if( $suc == 2 ){
		$arrOther["ath_comment"] = "";
		$arrOther["ath_comment"] = "<INPUT TYPE=\"hidden\" NAME=\"stpos\" VALUE=\"{$_POST['stpos']}\">";
		$arrOther["ath_comment"] .= "<input type=\"hidden\" name=\"cg_type\" value=\"{$_POST['cg_type']}\" />";
		$arrOther["ath_comment"] .= "<input type=\"hidden\" name=\"cg_id\" value=\"{$_POST['as_cgid']}\" />";
		$arrOther["ath_comment"] .= $athComment;
		$obj_error->ViewErrMessage( "DISP_NO" , "ALL" , "admission_main.php" , $arrOther );
		exit;
	}
	if( $suc == 10 ){
		$arrOther["ath_comment"] = "";
		$arrOther["ath_comment"] = "<INPUT TYPE=\"hidden\" NAME=\"stpos\" VALUE=\"{$_POST['stpos']}\">";
		$arrOther["ath_comment"] .= "<input type=\"hidden\" name=\"cg_type\" value=\"{$_POST['cg_type']}\" />";
		$arrOther["ath_comment"] .= "<input type=\"hidden\" name=\"cg_id\" value=\"{$_POST['as_cgid']}\" />";
		$arrOther["ath_comment"] .= $athComment;
		$obj_error->ViewErrMessage( "CATE_TOP_FLG" , "ALL" , "admission_main.php" , $arrOther );
		exit;
	}
	// 画像保存・削除処理
	IF( is_uploaded_file( $_FILES["as_img"]["tmp_name"] ) ){
		// 一度画像を削除==>再度コピー
		IF( file_exists($param_admission_img_path.$_POST['as_img_lastupd'] ) && $_POST['as_img_lastupd'] != "" ){
			unlink( $param_admission_img_path.$_POST['as_img_lastupd'] );
		}
		// 同じ名前で、UPLOADされたデータをコピー
		IF( is_uploaded_file($_FILES["as_img"]["tmp_name"]) && $obj_new->admissiondat[0]["as_img"] != "" ){
			move_uploaded_file( $_FILES["as_img"]["tmp_name"] , $param_admission_img_path.$obj_new->admissiondat[0]["as_img"] );
			chmod( $param_admission_img_path.$obj_new->admissiondat[0]["as_img"] , 0755 );
		}

		$obj_layout_new = new ImageControl;
		$obj_layout_new->max_w = 500;
		$obj_layout_new->max_h = 500;
		$obj_layout_new->origin_dir = $param_admission_img_path;
		$obj_layout_new->origin_img = $obj_new->admissiondat[0]["as_img"];
		$obj_layout_new->gd_ver = 2;
		list($resize_admission_new,$imageType) = $obj_layout_new->ImageResizeSave();
		if($resize_layout_new == -1){
			$arrOther["ath_comment"] = "<INPUT TYPE=\"hidden\" NAME=\"as_clid\" VALUE=\"{$_POST['as_clid']}\">";
			$arrOther["ath_comment"] .= "<input type=\"hidden\" name=\"cg_id\" value=\"{$_POST['as_cgid']}\" />";
			$arrOther["ath_comment"] .= $athComment;
			$obj_error->ViewErrMessage( "SYSTEM" , "ALL" , "blog_mnt.php" , $arrOther  );
			exit;
		}
		$obj_layout_save_new = new ImageControl;
		$obj_layout_save_new->origin_dir = $param_admission_img_path;
		$obj_layout_save_new->origin_img = $obj_new->admissiondat[0]["as_img"];
		$obj_layout_save_new->imageResource = $resize_admission_new;
		$layout_suc_new = $obj_layout_save_new->ImageSave($imageType);
		if($layout_suc_new == -1){
				$arrOther["ath_comment"] = "<INPUT TYPE=\"hidden\" NAME=\"as_clid\" VALUE=\"{$_POST['as_clid']}\">";
				$arrOther["ath_comment"] .= "<input type=\"hidden\" name=\"cg_id\" value=\"{$_POST['as_cgid']}\" />";
				$arrOther["ath_comment"] .= $athComment;
                        	$obj_error->ViewErrMessage( "SYSTEM" , "ALL" , "blog_mnt.php" , $arrOther  );
                       		exit;
		}
	}
	$message = "記事を登録しました。";

}else if( $_POST['mode'] == "EDIT" ){

	// ロゴ画像
	if( filesize($_FILES["as_img"]["tmp_name"]) > (1024*1024*2) ){
		$arrOther["ath_comment"] = "<INPUT TYPE=\"hidden\" NAME=\"as_clid\" VALUE=\"{$_POST['as_clid']}\">";
		$arrOther["ath_comment"] .= "<input type=\"hidden\" name=\"cg_id\" value=\"{$_POST['as_cgid']}\" />";
		$arrOther["ath_comment"] .= $athComment;
		$obj_error->ViewErrMessage( "FILE_SIZE" , "ALL" , "room_mnt.php" , $arrOther );
		exit;
	}
	IF( is_uploaded_file( $_FILES["as_img"]["tmp_name"] ) ){
		$imageInfo = @getimagesize( $_FILES["as_img"]["tmp_name"] );
		IF( @getimagesize( $_FILES["as_img"]["tmp_name"] ) === FALSE || ( $imageInfo[2] != 1 && $imageInfo[2] != 2 ) ){
			$arrOther["ath_comment"] = "<INPUT TYPE=\"hidden\" NAME=\"as_clid\" VALUE=\"{$_POST['as_clid']}\">";
		$arrOther["ath_comment"] .= "<input type=\"hidden\" name=\"cg_id\" value=\"{$_POST['as_cgid']}\" />";
			$arrOther["ath_comment"] = "";
			$arrOther["ath_comment"] = "<INPUT TYPE=\"hidden\" NAME=\"stpos\" VALUE=\"{$_POST['stpos']}\">";
			$arrOther["ath_comment"] .= "<input type=\"hidden\" name=\"cg_type\" value=\"{$_POST['cg_type']}\" />";
			$arrOther["ath_comment"] .= "<input type=\"hidden\" name=\"cg_id\" value=\"{$_POST['as_cgid']}\" />";
			$arrOther["ath_comment"] .= $athComment;
                	$obj_error->ViewErrMessage( "NOT_IMG" , "ALL" , "room_mnt.php" , $arrOther );
                        exit;
		}
		$kakuLayout = split("\.",$_FILES["as_img"]["name"]);
		$admission_img_org = "admission_".$_SESSION['_cl_id']."_".$_POST["as_id"].".".$kakuLayout[1];
	}

	if($_POST['as_cgid'] == "----")$_POST['as_cgid'] = "";

	$obj_upd = new basedb_AdmissionClassTblAccess;
	$obj_upd->conn = $obj_conn->conn;
	$obj_upd->admissiondat[0]["as_id"] = $_POST["as_id"];
	$obj_upd->admissiondat[0]["as_stat"] = $_POST["as_stat"];
	$obj_upd->admissiondat[0]["as_clid"] = $_POST["as_clid"];
	$obj_upd->admissiondat[0]["as_cgid"] = $_POST["as_cgid"];
	$obj_upd->admissiondat[0]["as_title"] = $_POST["as_title"];
	IF( is_uploaded_file($_FILES["as_img"]["tmp_name"]) ){
		$obj_upd->admissiondat[0]["as_imgorg"] = $_FILES["as_img"]["name"];
		$obj_upd->admissiondat[0]["as_img"] = $admission_img_org;
	}
	$obj_upd->admissiondat[0]["as_img_del_chk"] = $_POST["as_img_del_chk"];
	$obj_upd->admissiondat[0]["as_contents"] = $_POST["as_contents"];
	$obj_upd->admissiondat[0]["as_dispno"] = $_POST["as_dispno"];
	$obj_upd->admissiondat[0]["as_adminid"] = $_POST["as_adminid"];
	$obj_upd->admissiondat[0]["as_insdate"] = $_POST["as_insdate"];
	$obj_upd->admissiondat[0]["as_upddate"] = $_POST["as_upddate"];
	$obj_upd->admissiondat[0]["as_deldate"] = $_POST["as_deldate"];
	$suc = $obj_upd->basedb_UpdAdmission();
	if( $suc == -1 ){
		$arrOther["ath_comment"] = "";
		$arrOther["ath_comment"] = "<INPUT TYPE=\"hidden\" NAME=\"stpos\" VALUE=\"{$_POST['stpos']}\">";
		$arrOther["ath_comment"] .= "<input type=\"hidden\" name=\"cg_type\" value=\"{$_POST['cg_type']}\" />";
		$arrOther["ath_comment"] .= "<input type=\"hidden\" name=\"cg_id\" value=\"{$_POST['as_cgid']}\" />";
		$arrOther["ath_comment"] .= $athComment;
		$obj_error->ViewErrMessage( "INS_ERROR" , "ALL" , "admission_main.php" , $arrOther );
		exit;
	}
	if( $suc == 2 ){
		$arrOther["ath_comment"] = "";
		$arrOther["ath_comment"] = "<INPUT TYPE=\"hidden\" NAME=\"stpos\" VALUE=\"{$_POST['stpos']}\">";
		$arrOther["ath_comment"] .= "<input type=\"hidden\" name=\"cg_type\" value=\"{$_POST['cg_type']}\" />";
		$arrOther["ath_comment"] .= "<input type=\"hidden\" name=\"cg_id\" value=\"{$_POST['as_cgid']}\" />";
		$arrOther["ath_comment"] .= $athComment;
		$obj_error->ViewErrMessage( "DISP_NO" , "ALL" , "admission_main.php" , $arrOther );
		exit;
	}
	if( $suc == 10 ){
		$arrOther["ath_comment"] = "";
		$arrOther["ath_comment"] = "<INPUT TYPE=\"hidden\" NAME=\"stpos\" VALUE=\"{$_POST['stpos']}\">";
		$arrOther["ath_comment"] .= "<input type=\"hidden\" name=\"cg_type\" value=\"{$_POST['cg_type']}\" />";
		$arrOther["ath_comment"] .= "<input type=\"hidden\" name=\"cg_id\" value=\"{$_POST['as_cgid']}\" />";
		$arrOther["ath_comment"] .= $athComment;
		$obj_error->ViewErrMessage( "CATE_TOP_FLG" , "ALL" , "admission_main.php" , $arrOther );
		exit;
	}
	$message = "記事を登録しました。";
	IF($_POST['as_img_del_chk']==1){
		IF( file_exists($param_admission_img_path.$_POST['as_img_lastupd'] ) && $_POST['as_img_lastupd'] != "" ){
			unlink( $param_admission_img_path.$_POST['as_img_lastupd'] );
		}
	}
	// 画像保存・削除処理
	IF( is_uploaded_file( $_FILES["as_img"]["tmp_name"] ) ){
		// 一度画像を削除==>再度コピー
		IF( file_exists($param_admission_img_path.$_POST['as_img_lastupd'] ) && $_POST['as_img_lastupd'] != "" ){
			unlink( $param_admission_img_path.$_POST['as_img_lastupd'] );
		}
		// 同じ名前で、UPLOADされたデータをコピー
		IF( is_uploaded_file($_FILES["as_img"]["tmp_name"]) && $obj_upd->admissiondat[0]["as_img"] != "" ){
			move_uploaded_file( $_FILES["as_img"]["tmp_name"] , $param_admission_img_path.$admission_img_org );
			chmod( $param_admission_img_path.$admission_img_org , 0755 );
		}

		$obj_layout_rev = new ImageControl;
		$obj_layout_rev->max_w = 500;
		$obj_layout_rev->max_h = 500;
		$obj_layout_rev->origin_dir = $param_admission_img_path;
		$obj_layout_rev->origin_img = $admission_img_org;
		$obj_layout_rev->gd_ver = 2;
		list($resize_layout_rev,$imageType) = $obj_layout_rev->ImageResizeSave();
		if($resize_layout_rev == -1){
				$arrOther["ath_comment"] = "";
				$arrOther["ath_comment"] = "<INPUT TYPE=\"hidden\" NAME=\"stpos\" VALUE=\"{$_POST['stpos']}\">";
				$arrOther["ath_comment"] .= "<input type=\"hidden\" name=\"cg_type\" value=\"{$_POST['cg_type']}\" />";
				$arrOther["ath_comment"] .= "<input type=\"hidden\" name=\"cg_id\" value=\"{$_POST['as_cgid']}\" />";
                        	$obj_error->ViewErrMessage( "SYSTEM" , "ALL" , "blog_mnt.php" , $arrOther  );
                       		exit;
		}

		$obj_layout_save_rev = new ImageControl;
		$obj_layout_save_rev->origin_dir = $param_admission_img_path;
		$obj_layout_save_rev->origin_img = $admission_img_org;
		$obj_layout_save_rev->imageResource = $resize_layout_rev;
		$layout_suc_rev = $obj_layout_save_rev->ImageSave($imageType);
		if($layout_suc_rev == -1){
				$arrOther["ath_comment"] = "";
				$arrOther["ath_comment"] = "<INPUT TYPE=\"hidden\" NAME=\"stpos\" VALUE=\"{$_POST['stpos']}\">";
				$arrOther["ath_comment"] .= "<input type=\"hidden\" name=\"cg_type\" value=\"{$_POST['cg_type']}\" />";
				$arrOther["ath_comment"] .= "<input type=\"hidden\" name=\"cg_id\" value=\"{$_POST['as_cgid']}\" />";
				$arrOther["ath_comment"] .= $athComment;
                        	$obj_error->ViewErrMessage( "SYSTEM" , "ALL" , "blog_mnt.php" , $arrOther  );
                       		exit;
		}
	}



}else if( $_POST['mode'] == "DEL" ){
	$obj_del = new basedb_AdmissionClassTblAccess;
	$obj_del->conn = $obj_conn->conn;
	$obj_del->admissiondat[0]["as_id"] = $_POST["as_id"];
	$obj_del->admissiondat[0]["as_upddate"] = $_POST["as_upddate"];
	$suc = $obj_del->basedb_DelAdmission(0);
	if( $suc != 0 ){
		$arrOther["ath_comment"] = "<INPUT TYPE=\"hidden\" NAME=\"as_clid\" VALUE=\"{$_POST['as_clid']}\">";
		$obj_error->ViewErrMessage( "DEL_ERROR" , "ALL" , "admission_main.php" , $arrOther );
		exit;
	}
	IF( $suc == "0" ){
		// 画像を削除
		IF( file_exists($param_admission_img_path.$_POST['as_img_lastupd'] ) && $_POST["as_img_lastupd"] != "" ){
			unlink( $param_admission_img_path.$_POST['as_img_lastupd'] );
		}
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
      <form name="form1" action="admission_main.php" method="POST"> 
        <input type="submit" value=" 戻 る " class="btn" />
        <input type="hidden" name="cg_type" value="<?=$_POST['cg_type']?>" />
        <input type="hidden" name="cg_id" value="<?=$_POST['as_cgid']?>" />
      </form>
    </div>
  </body>
</html>
