<?
/******************************************************************************
<< 不動産ブログ　Ver.1.O.0 >>
	Name: cltpcontents_upd.php
	Version: 1.0.0
	Function: 記事情報 登録／修正／削除
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
require_once ( SYS_PATH."dbif/basedb_CltpcontentsClass.php" );
require_once ( SYS_PATH."dbif/basedb_ClientClass.php" );
require_once ( SYS_PATH."common/base_common.php" );
require_once ( SYS_PATH."common/sys_common.php" );
include_once ( SYS_PATH."common/error.class.php" );
require_once ( SYS_PATH."common/ImageControl.class.php" );
require_once ( SYS_PATH."configs/param_file.conf" );


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


$_POST["cltpcontents_date"] = $_POST["cltpcontents_date_year"]."-".$_POST["cltpcontents_date_month"]."-".$_POST["cltpcontents_date_day"]." 00:00:00";


switch( $_POST["mode"] ){
	case 'NEW':

		// 画像1〜4サイズチェック
		for ($ix=1; $ix<=4; $ix++){
			if( filesize($_FILES["cltpcontents_img_{$ix}"]["tmp_name"]) > (1024*1024*2) ){
				$arrOther['ath_comment'] .= $athComment;
				$obj_error->ViewErrMessage( "FILE_SIZE" , "ALL" , "cltpcontents_mnt.php" , $arrOther );
				exit;
			}
		}

		// 画像1〜4アップロードチェック 
		for ($ix=1; $ix<=4; $ix++){
			IF( is_uploaded_file( $_FILES["cltpcontents_img_{$ix}"]["tmp_name"] ) ){
				$imageInfo = @getimagesize( $_FILES["cltpcontents_img_{$ix}"]["tmp_name"] );
				IF( @getimagesize( $_FILES["cltpcontents_img_{$ix}"]["tmp_name"] ) === FALSE || ( $imageInfo[2] != 1 && $imageInfo[2] != 2 ) ){
					$arrOther['ath_comment'] .= $athComment;
					$obj_error->ViewErrMessage( "NOT_IMG" , "ALL" , "cltpcontents_mnt.php" , $arrOther );
					exit;
				}
				// ファイル名設定
				switch ($ix){
					case 1:
						$kaku1 = split("\.",$_FILES["cltpcontents_img_{$ix}"]["name"]);
						$cltpcontents_img_org_1 = $kaku1[0].".".$kaku1[1];
						$cltpcontents_img_1 = "cltpcontents_/_{$ix}.".$kaku1[1];
					break;
					case 2:
						$kaku2 = split("\.",$_FILES["cltpcontents_img_{$ix}"]["name"]);
						$cltpcontents_img_org_2 = $kaku2[0].".".$kaku2[1];
						$cltpcontents_img_2 = "cltpcontents_/_{$ix}.".$kaku2[1];
					break;
					case 3:
						$kaku3 = split("\.",$_FILES["cltpcontents_img_{$ix}"]["name"]);
						$cltpcontents_img_org_3 = $kaku3[0].".".$kaku3[1];
						$cltpcontents_img_3 = "cltpcontents_/_{$ix}.".$kaku3[1];
					break;
					case 4:
						$kaku4 = split("\.",$_FILES["cltpcontents_img_{$ix}"]["name"]);
						$cltpcontents_img_org_4 = $kaku4[0].".".$kaku4[1];
						$cltpcontents_img_4 = "cltpcontents_/_{$ix}.".$kaku4[1];
					break;
				}
			}
		}

		$obj_new = new basedb_CltpcontentsClassTblAccess;
		$obj_new->conn = $obj_conn->conn;
		$obj_new->cltpcontentsdat[0]["cltpcontents_cate_id"] = $_POST["cltpcontents_cate_id"];
		$obj_new->cltpcontentsdat[0]["cltpcontents_stat"] = $_POST["cltpcontents_stat"];
		$obj_new->cltpcontentsdat[0]["cltpcontents_date"] = $_POST["cltpcontents_date"];
		$obj_new->cltpcontentsdat[0]["cltpcontents_title"] = $_POST["cltpcontents_title"];
		$obj_new->cltpcontentsdat[0]["cltpcontents_contents"] = $_POST["cltpcontents_contents"];
		IF( is_uploaded_file($_FILES["cltpcontents_img_1"]["tmp_name"]) ){
			$obj_new->cltpcontentsdat[0]["cltpcontents_img_org_1"] = $cltpcontents_img_org_1;
			$obj_new->cltpcontentsdat[0]["cltpcontents_img_1"] = $cltpcontents_img_1;
		}
		IF( is_uploaded_file($_FILES["cltpcontents_img_2"]["tmp_name"]) ){
			$obj_new->cltpcontentsdat[0]["cltpcontents_img_org_2"] = $cltpcontents_img_org_2;
			$obj_new->cltpcontentsdat[0]["cltpcontents_img_2"] = $cltpcontents_img_2;
		}
		IF( is_uploaded_file($_FILES["cltpcontents_img_3"]["tmp_name"]) ){
			$obj_new->cltpcontentsdat[0]["cltpcontents_img_org_3"] = $cltpcontents_img_org_3;
			$obj_new->cltpcontentsdat[0]["cltpcontents_img_3"] = $cltpcontents_img_3;
		}
		IF( is_uploaded_file($_FILES["cltpcontents_img_4"]["tmp_name"]) ){
			$obj_new->cltpcontentsdat[0]["cltpcontents_img_org_4"] = $cltpcontents_img_org_4;
			$obj_new->cltpcontentsdat[0]["cltpcontents_img_4"] = $cltpcontents_img_4;
		}
		$suc = $obj_new->basedb_InsCltpcontents();
		if( $suc == -1 ){
echo("#3#error#");
			$arrOther["ath_comment"] = "";
			$arrOther["ath_comment"] = "<INPUT TYPE=\"hidden\" NAME=\"stpos\" VALUE=\"{$_POST['stpos']}\">";
			$arrOther["ath_comment"] .= $athComment;
			$obj_error->ViewErrMessage( "INS_ERROR" , "ALL" , "cltpcontents_mnt.php" , $arrOther );
			exit;
		}
		if( $suc == 2 ){
echo("#4#error#");
			$arrOther["ath_comment"] = "";
			$arrOther["ath_comment"] = "<INPUT TYPE=\"hidden\" NAME=\"stpos\" VALUE=\"{$_POST['stpos']}\">";
			$arrOther["ath_comment"] .= $athComment;
			$obj_error->ViewErrMessage( "DISP_NO" , "ALL" , "cltpcontents_mnt.php" , $arrOther );
			exit;
		}
		if( $suc == 10 ){
echo("#5#error#");
			$arrOther["ath_comment"] = "";
			$arrOther["ath_comment"] = "<INPUT TYPE=\"hidden\" NAME=\"stpos\" VALUE=\"{$_POST['stpos']}\">";
			$arrOther["ath_comment"] .= $athComment;
			$obj_error->ViewErrMessage( "CATE_TOP_FLG" , "ALL" , "cltpcontents_mnt.php" , $arrOther );
			exit;
		}

		IF( $suc == "0" ){
			// 画像1〜4保存・削除処理
			for ($ix=1; $ix<=4; $ix++){
				// 画像パス、ファイル名を設定
				switch ($ix) {
					case 1:
						$img_path	= $param_cltpcontents_img_1_absolutepath;
						$img_filenm	= $_POST["cltpcontents_img_1_lastupd"];
						$img_tmp_name	= $_FILES["cltpcontents_img_1"]["tmp_name"];
						$field_name	= "cltpcontents_img_1";
					break;
					case 2:
						$img_path	= $param_cltpcontents_img_2_absolutepath;
						$img_filenm	= $_POST["cltpcontents_img_2_lastupd"];
						$img_tmp_name	= $_FILES["cltpcontents_img_2"]["tmp_name"];
						$field_name	= "cltpcontents_img_2";
					break;
					case 3:
						$img_path	= $param_cltpcontents_img_3_absolutepath;
						$img_filenm	= $_POST["cltpcontents_img_3_lastupd"];
						$img_tmp_name	= $_FILES["cltpcontents_img_3"]["tmp_name"];
						$field_name	= "cltpcontents_img_3";
					break;
					case 4:
						$img_path	= $param_cltpcontents_img_4_absolutepath;
						$img_filenm	= $_POST["cltpcontents_img_4_lastupd"];
						$img_tmp_name	= $_FILES["cltpcontents_img_4"]["tmp_name"];
						$field_name	= "cltpcontents_img_4";
					break;
				}
				IF( is_uploaded_file( $img_tmp_name ) ){
					// 一度画像を削除==>再度コピー
					IF( file_exists( $img_path.$img_filenm ) && $img_filenm != "" ){
						unlink( $img_path.$img_filenm );
					}
					// 同じ名前で、UPLOADされたデータをコピー
					IF( is_uploaded_file($img_tmp_name) && $obj_new->cltpcontentsdat[0][$field_name] != "" ){
						move_uploaded_file( $img_tmp_name , $img_path.$obj_new->cltpcontentsdat[0][$field_name] );
						chmod( $img_path.$obj_new->cltpcontentsdat[0][$field_name] , 0755 );
					}

					$obj_cltpcontents_new = new ImageControl;
					$obj_cltpcontents_new->max_w = 550;
					$obj_cltpcontents_new->max_h = 550;
					$obj_cltpcontents_new->origin_dir = $img_path;
					$obj_cltpcontents_new->origin_img = $obj_new->cltpcontentsdat[0][$field_name];
					$obj_cltpcontents_new->gd_ver = 1;
					list($resize_cltpcontents_new,$imageType) = $obj_cltpcontents_new->ImageResizeSave();
					if($resize_cltpcontents_new == -1){
						$obj_error->ViewErrMessage( "SYSTEM" , "ALL" , "cltpcontents_mnt.php" , $arrOther  );
						exit;
					}

					$obj_other_save_new = new ImageControl;
					$obj_other_save_new->origin_dir = $img_path;
					$obj_other_save_new->origin_img = $obj_new->cltpcontentsdat[0][$field_name];
					$obj_other_save_new->imageResource = $resize_cltpcontents_new;
					$cltpcontents_suc_new = $obj_other_save_new->ImageSave($imageType);
					if($cltpcontents_suc_new == -1){
						$obj_error->ViewErrMessage( "SYSTEM" , "ALL" , "cltpcontents_mnt.php" , $arrOther  );
						exit;
					}
				}
			}
		}
		$message = "記事を登録しました。";
		break;
		
		
	case 'EDIT':
		
		// 画像1〜4サイズチェック
		for ($ix=1; $ix<=4; $ix++){
			if( filesize($_FILES["cltpcontents_img_{$ix}"]["tmp_name"]) > (1024*1024*2) ){
				$arrOther['ath_comment'] .= $athComment;
				$obj_error->ViewErrMessage( "FILE_SIZE" , "ALL" , "cltpcontents_mnt.php" , $arrOther );
				exit;
			}
		}

		// 画像1〜4アップロードチェック 
		for ($ix=1; $ix<=4; $ix++){
			IF( is_uploaded_file( $_FILES["cltpcontents_img_{$ix}"]["tmp_name"] ) ){
				$imageInfo = @getimagesize( $_FILES["cltpcontents_img_{$ix}"]["tmp_name"] );
				IF( @getimagesize( $_FILES["cltpcontents_img_{$ix}"]["tmp_name"] ) === FALSE || ( $imageInfo[2] != 1 && $imageInfo[2] != 2 ) ){
					$arrOther['ath_comment'] .= $athComment;
					$obj_error->ViewErrMessage( "NOT_IMG" , "ALL" , "cltpcontents_mnt.php" , $arrOther );
					exit;
				}
				// ファイル名設定
				switch ($ix){
					case 1:
						$kaku1 = split("\.",$_FILES["cltpcontents_img_{$ix}"]["name"]);
						$cltpcontents_img_org_1 = $kaku1[0].".".$kaku1[1];
						$cltpcontents_img_1 = "cltpcontents_".$_POST["cltpcontents_id"]."_{$ix}.".$kaku1[1];
					break;
					case 2:
						$kaku2 = split("\.",$_FILES["cltpcontents_img_{$ix}"]["name"]);
						$cltpcontents_img_org_2 = $kaku2[0].".".$kaku2[1];
						$cltpcontents_img_2 = "cltpcontents_".$_POST["cltpcontents_id"]."_{$ix}.".$kaku2[1];
					break;
					case 3:
						$kaku3 = split("\.",$_FILES["cltpcontents_img_{$ix}"]["name"]);
						$cltpcontents_img_org_3 = $kaku3[0].".".$kaku3[1];
						$cltpcontents_img_3 = "cltpcontents_".$_POST["cltpcontents_id"]."_{$ix}.".$kaku3[1];
					break;
					case 4:
						$kaku4 = split("\.",$_FILES["cltpcontents_img_{$ix}"]["name"]);
						$cltpcontents_img_org_4 = $kaku4[0].".".$kaku4[1];
						$cltpcontents_img_4 = "cltpcontents_".$_POST["cltpcontents_id"]."_{$ix}.".$kaku4[1];
					break;
				}
			}
		}

		$obj_rev = new basedb_CltpcontentsClassTblAccess;
		$obj_rev->conn = $obj_conn->conn;
		$obj_rev->cltpcontentsdat[0]["cltpcontents_id"] = $_POST["cltpcontents_id"];
		$obj_rev->cltpcontentsdat[0]["cltpcontents_cate_id"] = $_POST["cltpcontents_cate_id"];
		$obj_rev->cltpcontentsdat[0]["cltpcontents_stat"] = $_POST["cltpcontents_stat"];
		$obj_rev->cltpcontentsdat[0]["cltpcontents_date"] = $_POST["cltpcontents_date"];
		$obj_rev->cltpcontentsdat[0]["cltpcontents_title"] = $_POST["cltpcontents_title"];
		$obj_rev->cltpcontentsdat[0]["cltpcontents_contents"] = $_POST["cltpcontents_contents"];
		$obj_rev->cltpcontentsdat[0]["cltpcontents_upd_date"] = $_POST["cltpcontents_upd_date"];
		$obj_rev->cltpcontentsdat[0]["cltpcontents_img_1_del_chk"] = $_POST["cltpcontents_img_1_del_chk"];
		IF( is_uploaded_file($_FILES["cltpcontents_img_1"]["tmp_name"]) ){
			$obj_rev->cltpcontentsdat[0]["cltpcontents_img_org_1"] = $cltpcontents_img_org_1;
			$obj_rev->cltpcontentsdat[0]["cltpcontents_img_1"] = $cltpcontents_img_1;
		}
		$obj_rev->cltpcontentsdat[0]["cltpcontents_img_2_del_chk"] = $_POST["cltpcontents_img_2_del_chk"];
		IF( is_uploaded_file($_FILES["cltpcontents_img_2"]["tmp_name"]) ){
			$obj_rev->cltpcontentsdat[0]["cltpcontents_img_org_2"] = $cltpcontents_img_org_2;
			$obj_rev->cltpcontentsdat[0]["cltpcontents_img_2"] = $cltpcontents_img_2;
		}
		$obj_rev->cltpcontentsdat[0]["cltpcontents_img_3_del_chk"] = $_POST["cltpcontents_img_3_del_chk"];
		IF( is_uploaded_file($_FILES["cltpcontents_img_3"]["tmp_name"]) ){
			$obj_rev->cltpcontentsdat[0]["cltpcontents_img_org_3"] = $cltpcontents_img_org_3;
			$obj_rev->cltpcontentsdat[0]["cltpcontents_img_3"] = $cltpcontents_img_3;
		}
		$obj_rev->cltpcontentsdat[0]["cltpcontents_img_4_del_chk"] = $_POST["cltpcontents_img_4_del_chk"];
		IF( is_uploaded_file($_FILES["cltpcontents_img_4"]["tmp_name"]) ){
			$obj_rev->cltpcontentsdat[0]["cltpcontents_img_org_4"] = $cltpcontents_img_org_4;
			$obj_rev->cltpcontentsdat[0]["cltpcontents_img_4"] = $cltpcontents_img_4;
		}
		$suc = $obj_rev->basedb_UpdCltpcontents();
		if( $suc == -1 ){
echo("#6#error#");
			$arrOther["ath_comment"] = "";
			$arrOther["ath_comment"] = "<INPUT TYPE=\"hidden\" NAME=\"stpos\" VALUE=\"{$_POST['stpos']}\">";
			$arrOther["ath_comment"] .= $athComment;
			$obj_error->ViewErrMessage( "UPD_ERROR" , "ALL" , "cltpcontents_mnt.php" , $arrOther );
			exit;
		}
		if( $suc == 1 ){
echo("#7#error#");
			$arrOther["ath_comment"] = "";
			$arrOther["ath_comment"] = "<INPUT TYPE=\"hidden\" NAME=\"stpos\" VALUE=\"{$_POST['stpos']}\">";
			$obj_error->ViewErrMessage( "DOUBLE_UPD" , "ALL" , "cltpcontents_main.php" , $arrOther );
			exit;
		}
		if( $suc == 2 ){
echo("#8#error#");
			$arrOther["ath_comment"] = "";
			$arrOther["ath_comment"] = "<INPUT TYPE=\"hidden\" NAME=\"stpos\" VALUE=\"{$_POST['stpos']}\">";
			$arrOther["ath_comment"] .= $athComment;
			$obj_error->ViewErrMessage( "DISP_NO" , "ALL" , "cltpcontents_mnt.php" , $arrOther );
			exit;
		}
		if( $suc == 10 ){
echo("#9#error#");
			$arrOther["ath_comment"] = "";
			$arrOther["ath_comment"] = "<INPUT TYPE=\"hidden\" NAME=\"stpos\" VALUE=\"{$_POST['stpos']}\">";
			$arrOther["ath_comment"] .= $athComment;
			$obj_error->ViewErrMessage( "CATE_TOP_FLG" , "ALL" , "cltpcontents_mnt.php" , $arrOther );
			exit;
		}

		IF( $suc == "0" ){
			// 画像保存・削除処理
			for ($ix=1; $ix<=4; $ix++){
				// 画像パス、ファイル名を設定
				switch ($ix) {
					case 1:
						$img_del_chk	= "cltpcontents_img_1_del_chk";
						$img_path	= $param_cltpcontents_img_1_absolutepath;
						$img_filenm	= $_POST["cltpcontents_img_1_lastupd"];
						$img_tmp_name	= $_FILES["cltpcontents_img_1"]["tmp_name"];
						$field_name	= "cltpcontents_img_1";
						$cltpcontents_img	= $cltpcontents_img_1;
					break;
					case 2:
						$img_del_chk	= "cltpcontents_img_2_del_chk";
						$img_path	= $param_cltpcontents_img_2_absolutepath;
						$img_filenm	= $_POST["cltpcontents_img_2_lastupd"];
						$img_tmp_name	= $_FILES["cltpcontents_img_2"]["tmp_name"];
						$field_name	= "cltpcontents_img_2";
						$cltpcontents_img	= $cltpcontents_img_2;
					break;
					case 3:
						$img_del_chk	= "cltpcontents_img_3_del_chk";
						$img_path	= $param_cltpcontents_img_3_absolutepath;
						$img_filenm	= $_POST["cltpcontents_img_3_lastupd"];
						$img_tmp_name	= $_FILES["cltpcontents_img_3"]["tmp_name"];
						$field_name	= "cltpcontents_img_3";
						$cltpcontents_img	= $cltpcontents_img_3;
					break;
					case 4:
						$img_del_chk	= "cltpcontents_img_4_del_chk";
						$img_path	= $param_cltpcontents_img_4_absolutepath;
						$img_filenm	= $_POST["cltpcontents_img_4_lastupd"];
						$img_tmp_name	= $_FILES["cltpcontents_img_4"]["tmp_name"];
						$field_name	= "cltpcontents_img_4";
						$cltpcontents_img	= $cltpcontents_img_4;
					break;
				}

				// 削除チェック時画像削除
				IF($_POST[$img_del_chk]==1){
					IF( file_exists( $img_path.$img_filenm ) && $img_filenm != "" ){
						unlink( $img_path.$img_filenm );
					}
				}

				IF( is_uploaded_file( $img_tmp_name ) ){
					// 一度画像を削除==>再度コピー
					IF( file_exists( $img_path.$img_filenm ) && $img_filenm != "" ){
						unlink( $img_path.$img_filenm );
					}
					// 同じ名前で、UPLOADされたデータをコピー
					IF( is_uploaded_file($img_tmp_name) && $obj_rev->cltpcontentsdat[0][$field_name] != "" ){
						move_uploaded_file( $img_tmp_name , $img_path.$cltpcontents_img );
						chmod( $img_path.$cltpcontents_img , 0755 );
					}

					$obj_cltpcontents_new = new ImageControl;
					$obj_cltpcontents_new->max_w = 550;
					$obj_cltpcontents_new->max_h = 550;
					$obj_cltpcontents_new->origin_dir = $img_path;
					$obj_cltpcontents_new->origin_img = $obj_rev->cltpcontentsdat[0][$field_name];
					$obj_cltpcontents_new->gd_ver = 1;
					list($resize_cltpcontents_new,$imageType) = $obj_cltpcontents_new->ImageResizeSave();					
					if($resize_cltpcontents_new == -1){
						$obj_error->ViewErrMessage( "SYSTEM" , "ALL" , "cltpcontents_mnt.php" , $arrOther  );
						exit;
					}

					$obj_other_save_new = new ImageControl;
					$obj_other_save_new->origin_dir = $img_path;
					$obj_other_save_new->origin_img = $obj_rev->cltpcontentsdat[0][$field_name];
					$obj_other_save_new->imageResource = $resize_cltpcontents_new;
					$cltpcontents_suc_new = $obj_other_save_new->ImageSave($imageType);
					if($cltpcontents_suc_new == -1){
						$obj_error->ViewErrMessage( "SYSTEM" , "ALL" , "cltpcontents_mnt.php" , $arrOther  );
						exit;
					}
				}
			}
		}

		$message = "記事情報を修正しました。";
		break;
		
		
	case 'DEL':
		$obj_del = new basedb_CltpcontentsClassTblAccess;
		$obj_del->conn = $obj_conn->conn;
		$obj_del->cltpcontentsdat[0]["cltpcontents_id"] = $_POST["cltpcontents_id"];
		$obj_del->cltpcontentsdat[0]["cltpcontents_upd_date"] = $_POST["cltpcontents_upd_date"];
		$suc = $obj_del->basedb_DelCltpcontents(0);
		if( $suc != 0 ){
echo("#10#error#");
			$arrOther["ath_comment"] = "";
			$arrOther["ath_comment"] = "<INPUT TYPE=\"hidden\" NAME=\"stpos\" VALUE=\"{$_POST['stpos']}\">";
			$obj_error->ViewErrMessage( "DEL_ERROR" , "ALL" , "cltpcontents_main.php" , $arrOther );
			exit;
		}
		IF( $suc == "0" ){
			// 画像保存・削除処理
			for ($ix=1; $ix<=4; $ix++){
				// 画像パス、ファイル名を設定
				switch ($ix) {
					case 1:
						$img_path	= $param_cltpcontents_img_1_absolutepath;
						$img_filenm	= $_POST["cltpcontents_img_1_lastupd"];
					break;
					case 2:
						$img_path	= $param_cltpcontents_img_2_absolutepath;
						$img_filenm	= $_POST["cltpcontents_img_2_lastupd"];
					break;
					case 3:
						$img_path	= $param_cltpcontents_img_3_absolutepath;
						$img_filenm	= $_POST["cltpcontents_img_3_lastupd"];
					break;
					case 4:
						$img_path	= $param_cltpcontents_img_4_absolutepath;
						$img_filenm	= $_POST["cltpcontents_img_4_lastupd"];
					break;
				}

				// 画像を削除
				IF( file_exists( $img_path.$img_filenm ) && $img_filenm != ""){
					unlink( $img_path.$img_filenm );
				}
			}
		}
		$message = "指定された記事情報を削除しました。";
		break;

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
    <TITLE>不動産ブログ - 記事登録･修正･削除</title>
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
      <form name="form1" action="cltpcontents_main.php" method="POST"> 
            <input type="hidden" name="stpos" value="<?=$_POST["stpos"]?>" />
            <input type="hidden" name="sea_cltpcate_id" value="<?=$_POST["sea_cltpcate_id"]?>" />
            <input type="hidden" name="sea_cltpcontents_date_s_y" value="<?=$_POST["sea_cltpcontents_date_s_y"]?>" />
            <input type="hidden" name="sea_cltpcontents_date_s_m" value="<?=$_POST["sea_cltpcontents_date_s_m"]?>" />
            <input type="hidden" name="sea_cltpcontents_date_s_d" value="<?=$_POST["sea_cltpcontents_date_s_d"]?>" />
            <input type="hidden" name="sea_cltpcontents_date_e_y" value="<?=$_POST["sea_cltpcontents_date_e_y"]?>" />
            <input type="hidden" name="sea_cltpcontents_date_e_m" value="<?=$_POST["sea_cltpcontents_date_e_m"]?>" />
            <input type="hidden" name="sea_cltpcontents_date_e_d" value="<?=$_POST["sea_cltpcontents_date_e_d"]?>" />
            <input type="hidden" name="search_flg" value="<?=$_POST["search_flg"]?>" />
        <input type="submit" value=" 戻 る " class="btn" />
      </form>
    </div>
  </body>
</html>
