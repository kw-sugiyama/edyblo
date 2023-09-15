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
require_once ( SYS_PATH."dbif/basedb_CamarticleClass.php" );
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
 	if( filesize($_FILES["ca_img"]["tmp_name"]) > (1024*1024*2) ){
		$arrOther["ath_comment"] = "";
		$arrOther["ath_comment"] = "<input type=\"hidden\" name=\"cg_id\" value=\"{$_POST['cg_id']}\" />";
		$arrOther["ath_comment"] .= "<input type=\"hidden\" name=\"cg_type\" value=\"{$_POST['cg_type']}\" />";
		$arrOther["ath_comment"] .= "<input type=\"hidden\" name=\"cp_id\" value=\"{$_POST['ca_cpid']}\" />";
		$arrOther["ath_comment"] .= $athComment;
		$obj_error->ViewErrMessage( "FILE_SIZE" , "ALL" , "camarticle_mnt.php" , $arrOther );
		exit;
	}
	IF( is_uploaded_file( $_FILES["ca_img"]["tmp_name"] ) ){
		$imageInfo = @getimagesize( $_FILES["ca_img"]["tmp_name"] );
		IF( @getimagesize( $_FILES["ca_img"]["tmp_name"] ) === FALSE || ( $imageInfo[2] != 1 && $imageInfo[2] != 2 ) ){
		$arrOther["ath_comment"] = "";
		$arrOther["ath_comment"] = "<input type=\"hidden\" name=\"cg_id\" value=\"{$_POST['cg_id']}\" />";
		$arrOther["ath_comment"] .= "<input type=\"hidden\" name=\"cg_type\" value=\"{$_POST['cg_type']}\" />";
		$arrOther["ath_comment"] .= "<input type=\"hidden\" name=\"cp_id\" value=\"{$_POST['ca_cpid']}\" />";
		$arrOther["ath_comment"] .= $athComment;
			$obj_error->ViewErrMessage( "NOT_IMG" , "ALL" , "camarticle_mnt.php" , $arrOther );
			exit;
		}
		$kakuLayout = split("\.",$_FILES["ca_img"]["name"]);
		$camarticle_img_org = "camarticle_".$_SESSION['_cl_id']."_".$_POST["ca_id"].".".$kakuLayout[1];
	}

	if($_POST['ca_cateid'] == "----")$_POST['ca_cateid'] = "";

	$obj_new = new basedb_CamarticleClassTblAccess;
	$obj_new->conn = $obj_conn->conn;
	$obj_new->camarticledat[0]["ca_id"] = $_POST["ca_id"];
	$obj_new->camarticledat[0]["ca_stat"] = $_POST["ca_stat"];
	$obj_new->camarticledat[0]["ca_cpid"] = $_POST["cg_id"];
	$obj_new->camarticledat[0]["ca_cateid"] = $_POST["ca_cateid"];
	$obj_new->camarticledat[0]["ca_title"] = $_POST["ca_title"];
	IF( is_uploaded_file($_FILES["ca_img"]["tmp_name"]) ){
		$obj_new->camarticledat[0]["ca_imgorg"] = $_FILES["ca_img"]["name"];
		$obj_new->camarticledat[0]["ca_img"] = $camarticle_img_org;
	}
	$obj_new->camarticledat[0]["ca_contents"] = $_POST["ca_contents"];
	$obj_new->camarticledat[0]["ca_dispno"] = $_POST["ca_dispno"];
	$obj_new->camarticledat[0]["ca_adminid"] = $_POST["ca_adminid"];
	$obj_new->camarticledat[0]["ca_insdate"] = $_POST["ca_insdate"];
	$obj_new->camarticledat[0]["ca_upddate"] = $_POST["ca_upddate"];
	$obj_new->camarticledat[0]["ca_deldate"] = $_POST["ca_deldate"];
	$suc = $obj_new->basedb_InsCamarticle();
	if( $suc == -1 ){
		$arrOther["ath_comment"] = "";
		$arrOther["ath_comment"] = "<input type=\"hidden\" name=\"cg_id\" value=\"{$_POST['cg_id']}\" />";
		$arrOther["ath_comment"] .= "<input type=\"hidden\" name=\"cg_type\" value=\"{$_POST['cg_type']}\" />";
		$arrOther["ath_comment"] .= "<input type=\"hidden\" name=\"cp_id\" value=\"{$_POST['ca_cpid']}\" />";
		$arrOther["ath_comment"] .= $athComment;
		$obj_error->ViewErrMessage( "INS_ERROR" , "ALL" , "camarticle_mnt.php" , $arrOther );
		exit;
	}
	if( $suc == 2 ){
		$arrOther["ath_comment"] = "";
		$arrOther["ath_comment"] = "<input type=\"hidden\" name=\"cg_id\" value=\"{$_POST['cg_id']}\" />";
		$arrOther["ath_comment"] .= "<input type=\"hidden\" name=\"cg_type\" value=\"{$_POST['cg_type']}\" />";
		$arrOther["ath_comment"] .= "<input type=\"hidden\" name=\"cp_id\" value=\"{$_POST['ca_cpid']}\" />";
		$arrOther["ath_comment"] .= $athComment;
		$obj_error->ViewErrMessage( "DISP_NO" , "ALL" , "camarticle_mnt.php" , $arrOther );
		exit;
	}
	if( $suc == 10 ){
		$arrOther["ath_comment"] = "";
		$arrOther["ath_comment"] = "<input type=\"hidden\" name=\"cg_id\" value=\"{$_POST['cg_id']}\" />";
		$arrOther["ath_comment"] .= "<input type=\"hidden\" name=\"cg_type\" value=\"{$_POST['cg_type']}\" />";
		$arrOther["ath_comment"] .= "<input type=\"hidden\" name=\"cp_id\" value=\"{$_POST['ca_cpid']}\" />";
		$arrOther["ath_comment"] .= $athComment;
		$obj_error->ViewErrMessage( "CATE_TOP_FLG" , "ALL" , "camarticle_mnt.php" , $arrOther );
		exit;
	}
	// 画像保存・削除処理
	IF( is_uploaded_file( $_FILES["ca_img"]["tmp_name"] ) ){
		// 一度画像を削除==>再度コピー
		IF( file_exists($param_camarticle_img_path.$_POST['ca_img_lastupd'] ) && $_POST['ca_img_lastupd'] != "" ){
			unlink( $param_camarticle_img_path.$_POST['ca_img_lastupd'] );
		}
		// 同じ名前で、UPLOADされたデータをコピー
		IF( is_uploaded_file($_FILES["ca_img"]["tmp_name"]) && $obj_new->camarticledat[0]["ca_img"] != "" ){
			move_uploaded_file( $_FILES["ca_img"]["tmp_name"] , $param_camarticle_img_path.$obj_new->camarticledat[0]["ca_img"] );
			chmod( $param_camarticle_img_path.$obj_new->camarticledat[0]["ca_img"] , 0755 );
		}

		$obj_layout_new = new ImageControl;
		$obj_layout_new->max_w = 500;
		$obj_layout_new->max_h = 500;
		$obj_layout_new->origin_dir = $param_camarticle_img_path;
		$obj_layout_new->origin_img = $obj_new->camarticledat[0]["ca_img"];
		$obj_layout_new->gd_ver = 2;
		list($resize_camarticle_new,$imageType) = $obj_layout_new->ImageResizeSave();
		if($resize_layout_new == -1){
			$obj_error->ViewErrMessage( "SYSTEM" , "ALL" , "blog_mnt.php" , $arrOther  );
			exit;
		}
		$obj_layout_save_new = new ImageControl;
		$obj_layout_save_new->origin_dir = $param_camarticle_img_path;
		$obj_layout_save_new->origin_img = $obj_new->camarticledat[0]["ca_img"];
		$obj_layout_save_new->imageResource = $resize_camarticle_new;
		$layout_suc_new = $obj_layout_save_new->ImageSave($imageType);
		if($layout_suc_new == -1){
                        	$obj_error->ViewErrMessage( "SYSTEM" , "ALL" , "blog_mnt.php" , $arrOther  );
                       		exit;
		}
	}
	$message = "記事情報を登録しました。";

}else if( $_POST['mode'] == "EDIT" ){

	// ロゴ画像
	if( filesize($_FILES["ca_img"]["tmp_name"]) > (1024*1024*2) ){
		$arrOther["ath_comment"] = "";
		$arrOther["ath_comment"] = "<input type=\"hidden\" name=\"cg_id\" value=\"{$_POST['cg_id']}\" />";
		$arrOther["ath_comment"] .= "<input type=\"hidden\" name=\"cg_type\" value=\"{$_POST['cg_type']}\" />";
		$arrOther["ath_comment"] .= "<input type=\"hidden\" name=\"cp_id\" value=\"{$_POST['ca_cpid']}\" />";
		$arrOther["ath_comment"] .= $athComment;
		$obj_error->ViewErrMessage( "FILE_SIZE" , "ALL" , "room_mnt.php" , $arrOther );
		exit;
	}
	IF( is_uploaded_file( $_FILES["ca_img"]["tmp_name"] ) ){
		$imageInfo = @getimagesize( $_FILES["ca_img"]["tmp_name"] );
		IF( @getimagesize( $_FILES["ca_img"]["tmp_name"] ) === FALSE || ( $imageInfo[2] != 1 && $imageInfo[2] != 2 ) ){
		$arrOther["ath_comment"] = "";
		$arrOther["ath_comment"] = "<input type=\"hidden\" name=\"cg_id\" value=\"{$_POST['cg_id']}\" />";
		$arrOther["ath_comment"] .= "<input type=\"hidden\" name=\"cg_type\" value=\"{$_POST['cg_type']}\" />";
		$arrOther["ath_comment"] .= "<input type=\"hidden\" name=\"cp_id\" value=\"{$_POST['ca_cpid']}\" />";
		$arrOther["ath_comment"] .= $athComment;
                	$obj_error->ViewErrMessage( "NOT_IMG" , "ALL" , "room_mnt.php" , $arrOther );
                        exit;
		}
		$kakuLayout = split("\.",$_FILES["ca_img"]["name"]);
		$camarticle_img_org = "camarticle_".$_SESSION['_cl_id']."_".$_POST["ca_id"].".".$kakuLayout[1];
	}

	if($_POST['ca_cateid'] == "----")$_POST['ca_cateid'] = "";

	$obj_upd = new basedb_CamarticleClassTblAccess;
	$obj_upd->conn = $obj_conn->conn;
	$obj_upd->camarticledat[0]["ca_id"] = $_POST["ca_id"];
	$obj_upd->camarticledat[0]["ca_stat"] = $_POST["ca_stat"];
	$obj_upd->camarticledat[0]["ca_cpid"] = $_POST["cg_id"];
	$obj_upd->camarticledat[0]["ca_cateid"] = $_POST["ca_cateid"];
	$obj_upd->camarticledat[0]["ca_title"] = $_POST["ca_title"];
	IF( is_uploaded_file($_FILES["ca_img"]["tmp_name"]) ){
		$obj_upd->camarticledat[0]["ca_imgorg"] = $_FILES["ca_img"]["name"];
		$obj_upd->camarticledat[0]["ca_img"] = $camarticle_img_org;
	}
	$obj_upd->camarticledat[0]["ca_img_del_chk"] = $_POST["ca_img_del_chk"];
	$obj_upd->camarticledat[0]["ca_contents"] = $_POST["ca_contents"];
	$obj_upd->camarticledat[0]["ca_dispno"] = $_POST["ca_dispno"];
	$obj_upd->camarticledat[0]["ca_adminid"] = $_POST["ca_adminid"];
	$obj_upd->camarticledat[0]["ca_insdate"] = $_POST["ca_insdate"];
	$obj_upd->camarticledat[0]["ca_upddate"] = $_POST["ca_upddate"];
	$obj_upd->camarticledat[0]["ca_deldate"] = $_POST["ca_deldate"];
	$suc = $obj_upd->basedb_UpdCamarticle();
	if( $suc == -1 ){
		$arrOther["ath_comment"] = "";
		$arrOther["ath_comment"] = "<input type=\"hidden\" name=\"cg_id\" value=\"{$_POST['cg_id']}\" />";
		$arrOther["ath_comment"] .= "<input type=\"hidden\" name=\"cg_type\" value=\"{$_POST['cg_type']}\" />";
		$arrOther["ath_comment"] .= "<input type=\"hidden\" name=\"cp_id\" value=\"{$_POST['ca_cpid']}\" />";
		$arrOther["ath_comment"] .= $athComment;
		$obj_error->ViewErrMessage( "INS_ERROR" , "ALL" , "camarticle_mnt.php" , $arrOther );
		exit;
	}
	if( $suc == 2 ){
		$arrOther["ath_comment"] = "";
		$arrOther["ath_comment"] = "<input type=\"hidden\" name=\"cg_id\" value=\"{$_POST['cg_id']}\" />";
		$arrOther["ath_comment"] .= "<input type=\"hidden\" name=\"cg_type\" value=\"{$_POST['cg_type']}\" />";
		$arrOther["ath_comment"] .= "<input type=\"hidden\" name=\"cp_id\" value=\"{$_POST['ca_cpid']}\" />";
		$arrOther["ath_comment"] .= $athComment;
		$obj_error->ViewErrMessage( "DISP_NO" , "ALL" , "camarticle_mnt.php" , $arrOther );
		exit;
	}
	if( $suc == 10 ){
		$arrOther["ath_comment"] = "";
		$arrOther["ath_comment"] = "<input type=\"hidden\" name=\"cg_id\" value=\"{$_POST['cg_id']}\" />";
		$arrOther["ath_comment"] .= "<input type=\"hidden\" name=\"cg_type\" value=\"{$_POST['cg_type']}\" />";
		$arrOther["ath_comment"] .= "<input type=\"hidden\" name=\"cp_id\" value=\"{$_POST['ca_cpid']}\" />";
		$arrOther["ath_comment"] .= $athComment;
		$obj_error->ViewErrMessage( "CATE_TOP_FLG" , "ALL" , "camarticle_mnt.php" , $arrOther );
		exit;
	}
	$message = "記事情報を修正しました。";
	IF($_POST['ca_img_del_chk']==1){
		IF( file_exists($param_camarticle_img_path.$_POST['ca_img_lastupd'] ) && $_POST['ca_img_lastupd'] != "" ){
			unlink( $param_camarticle_img_path.$_POST['ca_img_lastupd'] );
		}
	}
	// 画像保存・削除処理
	IF( is_uploaded_file( $_FILES["ca_img"]["tmp_name"] ) ){
		// 一度画像を削除==>再度コピー
		IF( file_exists($param_camarticle_img_path.$_POST['ca_img_lastupd'] ) && $_POST['ca_img_lastupd'] != "" ){
			unlink( $param_camarticle_img_path.$_POST['ca_img_lastupd'] );
		}
		// 同じ名前で、UPLOADされたデータをコピー
		IF( is_uploaded_file($_FILES["ca_img"]["tmp_name"]) && $obj_upd->camarticledat[0]["ca_img"] != "" ){
			move_uploaded_file( $_FILES["ca_img"]["tmp_name"] , $param_camarticle_img_path.$camarticle_img_org );
			chmod( $param_camarticle_img_path.$camarticle_img_org , 0755 );
		}

		$obj_layout_rev = new ImageControl;
		$obj_layout_rev->max_w = 500;
		$obj_layout_rev->max_h = 500;
		$obj_layout_rev->origin_dir = $param_camarticle_img_path;
		$obj_layout_rev->origin_img = $camarticle_img_org;
		$obj_layout_rev->gd_ver = 2;
		list($resize_layout_rev,$imageType) = $obj_layout_rev->ImageResizeSave();
		if($resize_layout_rev == -1){
                        	$obj_error->ViewErrMessage( "SYSTEM" , "ALL" , "blog_mnt.php" , $arrOther  );
                       		exit;
		}

		$obj_layout_save_rev = new ImageControl;
		$obj_layout_save_rev->origin_dir = $param_camarticle_img_path;
		$obj_layout_save_rev->origin_img = $camarticle_img_org;
		$obj_layout_save_rev->imageResource = $resize_layout_rev;
		$layout_suc_rev = $obj_layout_save_rev->ImageSave($imageType);
		if($layout_suc_rev == -1){
                        	$obj_error->ViewErrMessage( "SYSTEM" , "ALL" , "blog_mnt.php" , $arrOther  );
                       		exit;
		}
	}



}else if( $_POST['mode'] == "DEL" ){
	$obj_del = new basedb_CamarticleClassTblAccess;
	$obj_del->conn = $obj_conn->conn;
	$obj_del->camarticledat[0]["ca_id"] = $_POST["ca_id"];
	$obj_del->camarticledat[0]["ca_upddate"] = $_POST["ca_upddate"];
	$suc = $obj_del->basedb_DelCamarticle(0);
	if( $suc != 0 ){
		$arrOther["ath_comment"] = "";
		$arrOther["ath_comment"] = "<input type=\"hidden\" name=\"cg_id\" value=\"{$_POST['cg_id']}\" />";
		$arrOther["ath_comment"] .= "<input type=\"hidden\" name=\"cg_type\" value=\"{$_POST['cg_type']}\" />";
		$arrOther["ath_comment"] .= "<input type=\"hidden\" name=\"cp_id\" value=\"{$_POST['ca_cpid']}\" />";
		$arrOther["ath_comment"] .= $athComment;
		$obj_error->ViewErrMessage( "DEL_ERROR" , "ALL" , "camarticle_mnt.php" , $arrOther );
		exit;
	}
	IF( $suc == "0" ){
		// 画像を削除
		IF( file_exists($param_camarticle_img_path.$_POST['ca_img_lastupd'] ) && $_POST["ca_img_lastupd"] != "" ){
			unlink( $param_camarticle_img_path.$_POST['ca_img_lastupd'] );
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
      <form name="form1" action="camarticle_mnt.php" method="POST"> 
        <input type="submit" value=" 戻 る " class="btn" />
        <input type="hidden" name="cg_id" value="<?=$_POST['cg_id']?>" />
        <input type="hidden" name="cg_type" value="<?=$_POST['cg_type']?>" />
        <input type="hidden" name="cp_id" value="<?=$_POST['ca_cpid']?>" />
      </form>
    </div>
  </body>
</html>
