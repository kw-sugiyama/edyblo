<?
/******************************************************************************
<< 不動産ブログ　Ver.1.O.0 >>
	Name: cp_upd.php
	Version: 1.0.0
	Function: ブログ基本情報 登録／修正／削除
	Author: Click inc
	Date of creation: 2007/02
	History of modification:

	Copyright (C)2007 Click, inc. All Rights Reserverd.
******************************************************************************/

/*----------------------------------------------------------
  必要ファイル呼び出し
----------------------------------------------------------*/
require_once ( "../ini_sets_2.php" );
require_once ( "../html_delete.php" );
require_once ( SYS_PATH."dbif/dbcom_DBconnectClass.php" );
require_once ( SYS_PATH."dbif/basedb_CampainClass.php" );
require_once ( SYS_PATH."dbif/basedb_ClientClass.php" );
require_once ( SYS_PATH."dbif/viewdb_BuildClass.php" );
require_once ( SYS_PATH."dbif/viewdb_ClientClass.php" );
require_once ( SYS_PATH."common/base_common.php" );
require_once ( SYS_PATH."common/sys_common.php" );
include_once ( SYS_PATH."common/error.class.php" );
require_once ( SYS_PATH."common/ImageControl.class.php" );
require_once ( SYS_PATH."configs/param_file.conf" );
require_once ( SYS_PATH."configs/param_room.conf" );
require_once ( SYS_PATH."configs/param_base.conf" );


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
	if(!is_array($val)){
		$val = stripslashes(htmlspecialchars($val));
		$athComment .= "<INPUT type=\"hidden\" name=\"{$key}\" value=\"{$val}\">\n";
	}else{
		FOREACH( $val as $key2 => $val2 ){
			$val2 = stripslashes(htmlspecialchars($val2));
			$athComment .= "<INPUT type=\"hidden\" name=\"{$key[$key2]}\" value=\"{$val2}\">\n";
		}
	}
}


// 営業開始・終了時間

if($_POST["cp_start_y"]!="" && $_POST["cp_start_m"]!="" && $_POST["cp_start_d"]!=""){
	$_POST["cp_start"] = $_POST["cp_start_y"]."-".$_POST["cp_start_m"]."-".$_POST["cp_start_d"];
}else if($_POST["cp_start_y"]=="" && $_POST["cp_start_m"]=="" && $_POST["cp_start_d"]==""){
	$_POST["cp_start"] = "DEL";
}
if($_POST["cp_end_y"]!="" && $_POST["cp_end_m"]!="" && $_POST["cp_end_d"]!=""){
	$_POST["cp_end"] = $_POST["cp_end_y"]."-".$_POST["cp_end_m"]."-".$_POST["cp_end_d"];
}else if($_POST["cp_end_y"]=="" && $_POST["cp_end_m"]=="" && $_POST["cp_end_d"]==""){
	$_POST["cp_end"] = "DEL";
}
if($_POST["cp_camstart_y"]!="" && $_POST["cp_camstart_m"]!="" && $_POST["cp_camstart_d"]!=""){
	$_POST["cp_camstart"] = $_POST["cp_camstart_y"]."-".$_POST["cp_camstart_m"]."-".$_POST["cp_camstart_d"];
}else if($_POST["cp_camstart_y"]=="" && $_POST["cp_camstart_m"]=="" && $_POST["cp_camstart_d"]==""){
	$_POST["cp_camstart"] = "DEL";
}
if($_POST["cp_camend_y"]!="" && $_POST["cp_camend_m"]!="" && $_POST["cp_camend_d"]!=""){
	$_POST["cp_camend"] = $_POST["cp_camend_y"]."-".$_POST["cp_camend_m"]."-".$_POST["cp_camend_d"];
}else if($_POST["cp_camend_y"]=="" && $_POST["cp_camend_m"]=="" && $_POST["cp_camend_d"]==""){
	$_POST["cp_camend"] = "DEL";
}


// 対象学年
$cp_age = 0;
$agecnt = count($_POST['cp_age']);
if($agecnt!=0){
	foreach($_POST['cp_age'] as $key => $val){
		$cp_age += $val;
	}
}

SWITCH( $_POST["mode"] ){
	case "NEW":
		// 画像1
                if( filesize($_FILES["cp_img1"]["tmp_name"]) > (1024*1024*2) ){
			$arrOther['ath_comment'] .= $athComment;
                        $obj_error->ViewErrMessage( "FILE_SIZE" , "ALL" , "campain_mnt.php" , $arrOther );
                        exit;
                }
                if( filesize($_FILES["cp_img2"]["tmp_name"]) > (1024*1024*2) ){
			$arrOther['ath_comment'] .= $athComment;
                        $obj_error->ViewErrMessage( "FILE_SIZE" , "ALL" , "campain_mnt.php" , $arrOther );
                        exit;
                }
                if( filesize($_FILES["cp_img3"]["tmp_name"]) > (1024*1024*2) ){
			$arrOther['ath_comment'] .= $athComment;
                        $obj_error->ViewErrMessage( "FILE_SIZE" , "ALL" , "campain_mnt.php" , $arrOther );
                        exit;
                }
                if( filesize($_FILES["cp_img4"]["tmp_name"]) > (1024*1024*2) ){
			$arrOther['ath_comment'] .= $athComment;
                        $obj_error->ViewErrMessage( "FILE_SIZE" , "ALL" , "campain_mnt.php" , $arrOther );
                        exit;
                }
//                if( filesize($_FILES["cp_bkgdimg"]["tmp_name"]) > (1024*1024*2) ){
//			$arrOther['ath_comment'] .= $athComment;
//                        $obj_error->ViewErrMessage( "FILE_SIZE" , "ALL" , "campain_mnt.php" , $arrOther );
//                        exit;
//                }
		IF( is_uploaded_file( $_FILES["cp_img1"]["tmp_name"] ) ){
			$imageInfo = @getimagesize( $_FILES["cp_img1"]["tmp_name"] );
			IF( @getimagesize( $_FILES["cp_img1"]["tmp_name"] ) === FALSE || ( $imageInfo[2] != 1 && $imageInfo[2] != 2 ) ){
				$arrOther['ath_comment'] .= $athComment;
                        	$obj_error->ViewErrMessage( "NOT_IMG" , "ALL" , "campain_mnt.php" , $arrOther );
                        	exit;
			}
		$kaku1 = split("\.",$_FILES["cp_img1"]["name"]);
		$cp_imgorg1 = $kaku1[0].".".$kaku1[1];
		$cp_img1 = "campain_".$_SESSION["_cl_id"]."_/_1.".$kaku1[1];
		}

		// 画像2
		IF( is_uploaded_file( $_FILES["cp_img2"]["tmp_name"] ) ){
			$imageInfo = @getimagesize( $_FILES["cp_img2"]["tmp_name"] );
			IF( @getimagesize( $_FILES["cp_img2"]["tmp_name"] ) === FALSE || ( $imageInfo[2] != 1 && $imageInfo[2] != 2 ) ){
				$arrOther['ath_comment'] .= $athComment;
                        	$obj_error->ViewErrMessage( "NOT_IMG" , "ALL" , "campain_mnt.php" , $arrOther );
                        	exit;
			}
		$kaku2 = split("\.",$_FILES["cp_img2"]["name"]);
		$cp_imgorg2 = $kaku2[0].".".$kaku2[1];
		$cp_img2 = "campain_".$_SESSION["_cl_id"]."_/_2.".$kaku2[1];
		}

		// 画像3
		IF( is_uploaded_file( $_FILES["cp_img3"]["tmp_name"] ) ){
			$imageInfo = @getimagesize( $_FILES["cp_img3"]["tmp_name"] );
			IF( @getimagesize( $_FILES["cp_img3"]["tmp_name"] ) === FALSE || ( $imageInfo[2] != 1 && $imageInfo[2] != 2 ) ){
				$arrOther['ath_comment'] .= $athComment;
                        	$obj_error->ViewErrMessage( "NOT_IMG" , "ALL" , "campain_mnt.php" , $arrOther );
                        	exit;
			}
		$kaku3 = split("\.",$_FILES["cp_img3"]["name"]);
		$cp_imgorg3 = $kaku3[0].".".$kaku3[1];
		$cp_img3 = "campain_".$_SESSION["_cl_id"]."_/_3.".$kaku3[1];
		}

		// 画像4
		IF( is_uploaded_file( $_FILES["cp_img4"]["tmp_name"] ) ){
			$imageInfo = @getimagesize( $_FILES["cp_img4"]["tmp_name"] );
			IF( @getimagesize( $_FILES["cp_img4"]["tmp_name"] ) === FALSE || ( $imageInfo[2] != 1 && $imageInfo[2] != 2 ) ){
				$arrOther['ath_comment'] .= $athComment;
                        	$obj_error->ViewErrMessage( "NOT_IMG" , "ALL" , "campain_mnt.php" , $arrOther );
                        	exit;
			}
		$kaku4 = split("\.",$_FILES["cp_img4"]["name"]);
		$cp_imgorg4 = $kaku4[0].".".$kaku4[1];
		$cp_img4 = "campain_".$_SESSION["_cl_id"]."_/_4.".$kaku4[1];
		}

		// 画像5
//		IF( is_uploaded_file( $_FILES["cp_bkgdimg"]["tmp_name"] ) ){
//			$imageInfo = @getimagesize( $_FILES["cp_bkgdimg"]["tmp_name"] );
//			IF( @getimagesize( $_FILES["cp_bkgdimg"]["tmp_name"] ) === FALSE || ( $imageInfo[2] != 1 && $imageInfo[2] != 2 ) ){
//				$arrOther['ath_comment'] .= $athComment;
//                        	$obj_error->ViewErrMessage( "NOT_IMG" , "ALL" , "campain_mnt.php" , $arrOther );
//                        	exit;
//			}
//		$kaku5 = split("\.",$_FILES["cp_bkgdimg"]["name"]);
//		$cp_bkgdimgorg = $kaku5[0].".".$kaku5[1];
//		$cp_bkgdimg = "campain_".$_SESSION["_cl_id"]."_/_5.".$kaku5[1];
//		}

		$obj_new = new basedb_CampainClassTblAccess;
		$obj_new->conn = $obj_conn->conn;


		$obj_new->campaindat[0]["cp_id"] = $_POST["cp_id"];
		$obj_new->campaindat[0]["cp_clid"] = $_SESSION["_cl_id"];

		$obj_new->campaindat[0]["cp_stat"] = $_POST["cp_stat"];
		$obj_new->campaindat[0]["cp_flg"] = $_POST["cp_flg"];
		$obj_new->campaindat[0]["cp_topflg"] = $_POST["cp_topflg"];
		$obj_new->campaindat[0]["cp_tcid"] = $_POST["cp_tcid"];
		$obj_new->campaindat[0]["cp_tccomment"] = $_POST["cp_tccomment"];
		$obj_new->campaindat[0]["cp_start"] = $_POST["cp_start"];
		$obj_new->campaindat[0]["cp_end"] = $_POST["cp_end"];
		$obj_new->campaindat[0]["cp_camstart"] = $_POST["cp_camstart"];
		$obj_new->campaindat[0]["cp_camend"] = $_POST["cp_camend"];
		$obj_new->campaindat[0]["cp_cgid"] = $_POST["cp_cgid"];
		$obj_new->campaindat[0]["cp_title"] = $_POST["cp_title"];
		$obj_new->campaindat[0]["cp_subtitle"] = $_POST["cp_subtitle"];
		$obj_new->campaindat[0]["cp_linktext"] = $_POST["cp_linktext"];
		$obj_new->campaindat[0]["cp_btntext"] = $_POST["cp_btntext"];
		$obj_new->campaindat[0]["cp_contents"] = $_POST["cp_contents"];
		$obj_new->campaindat[0]["cp_age"] = $cp_age;
		$obj_new->campaindat[0]["cp_img1_del_chk"] = $_POST["cp_img1_del_chk"];
		IF( is_uploaded_file($_FILES["cp_img1"]["tmp_name"]) ){
			$obj_new->campaindat[0]["cp_imgorg1"] = $cp_imgorg1;
			$obj_new->campaindat[0]["cp_img1"] = $cp_img1;
		}
		$obj_new->campaindat[0]["cp_img2_del_chk"] = $_POST["cp_img2_del_chk"];
		IF( is_uploaded_file($_FILES["cp_img2"]["tmp_name"]) ){
			$obj_new->campaindat[0]["cp_imgorg2"] = $cp_imgorg2;
			$obj_new->campaindat[0]["cp_img2"] = $cp_img2;
		}
		$obj_new->campaindat[0]["cp_img3_del_chk"] = $_POST["cp_img3_del_chk"];
		IF( is_uploaded_file($_FILES["cp_img3"]["tmp_name"]) ){
			$obj_new->campaindat[0]["cp_imgorg3"] = $cp_imgorg3;
			$obj_new->campaindat[0]["cp_img3"] = $cp_img3;
		}
		$obj_new->campaindat[0]["cp_img4_del_chk"] = $_POST["cp_img4_del_chk"];
		IF( is_uploaded_file($_FILES["cp_img4"]["tmp_name"]) ){
			$obj_new->campaindat[0]["cp_imgorg4"] = $cp_imgorg4;
			$obj_new->campaindat[0]["cp_img4"] = $cp_img4;
		}
		$obj_new->campaindat[0]["cp_bkgdimg"] = $_POST["cp_bkgdimg"];
//		$obj_new->campaindat[0]["cp_bkgdimg_del_chk"] = $_POST["cp_bkgdimg_del_chk"];
//		IF( is_uploaded_file($_FILES["cp_bkgdimg"]["tmp_name"]) ){
//			$obj_new->campaindat[0]["cp_bkgdimgorg"] = $cp_bkgdimgorg;
//			$obj_new->campaindat[0]["cp_bkgdimg"] = $cp_bkgdimg;
//		}

		$obj_new->campaindat[0]["cp_adminid"] = NULL;
		$suc = $obj_new->basedb_InsCampain();
		IF( $suc == "0" ){


			// 画像保存・削除処理
			IF( is_uploaded_file( $_FILES["cp_img1"]["tmp_name"] ) ){
				// 一度画像を削除==>再度コピー
				IF( file_exists( $param_cp_img1_path.$_POST['cp_img1_lastupd'] ) && $_POST['cp_img1_lastupd'] != "" ){
					unlink( $param_cp_img1_path.$_POST['cp_img1_lastupd'] );
				}
				// 同じ名前で、UPLOADされたデータをコピー
				IF( is_uploaded_file($_FILES["cp_img1"]["tmp_name"]) && $obj_new->campaindat[0]["cp_img1"] != "" ){
					move_uploaded_file( $_FILES["cp_img1"]["tmp_name"] , $param_cp_img1_path.$obj_new->campaindat[0]["cp_img1"] );
					chmod( $param_cp_img1_path.$obj_new->campaindat[0]["cp_img1"] , 0755 );
				}

				$obj_cp_1_new = new ImageControl;
				$obj_cp_1_new->max_w = 580;
				$obj_cp_1_new->max_h = 580;
				$obj_cp_1_new->origin_dir = $param_cp_img1_path;
				$obj_cp_1_new->origin_img = $obj_new->campaindat[0]["cp_img1"];
				$obj_cp_1_new->gd_ver = 1;
				list($resize_cp_1_new,$imageType) = $obj_cp_1_new->ImageResizeSave();
				if($resize_cp_1_new == -1){
	                        	$obj_error->ViewErrMessage( "SYSTEM" , "ALL" , "blog_mnt.php" , $arrOther  );
	                       		exit;
				}

				$obj_other_1_save_new = new ImageControl;
				$obj_other_1_save_new->origin_dir = $param_cp_img1_path;
				$obj_other_1_save_new->origin_img = $obj_new->campaindat[0]["cp_img1"];
				$obj_other_1_save_new->imageResource = $resize_cp_1_new;
				$cp_1_suc_new = $obj_other_1_save_new->ImageSave($imageType);
				if($cp_1_suc_new == -1){
	                        	$obj_error->ViewErrMessage( "SYSTEM" , "ALL" , "blog_mnt.php" , $arrOther  );
	                       		exit;
				}
			}
			
			IF( is_uploaded_file( $_FILES["cp_img2"]["tmp_name"] ) ){
				// 一度画像を削除==>再度コピー
				IF( file_exists( $param_cp_img2_path.$_POST['cp_img2_lastupd'] ) && $_POST['cp_img2_lastupd'] != "" ){
					unlink( $param_cp_img2_path.$_POST['cp_img2_lastupd'] );
				}
				// 同じ名前で、UPLOADされたデータをコピー
				IF( is_uploaded_file($_FILES["cp_img2"]["tmp_name"]) && $obj_new->campaindat[0]["cp_img2"] != "" ){
					move_uploaded_file( $_FILES["cp_img2"]["tmp_name"] , $param_cp_img2_path.$obj_new->campaindat[0]["cp_img2"] );
					chmod( $param_cp_img2_path.$obj_new->campaindat[0]["cp_img2"] , 0755 );
				}

				$obj_cp_2_new = new ImageControl;
				$obj_cp_2_new->max_w = 580;
				$obj_cp_2_new->max_h = 580;
				$obj_cp_2_new->origin_dir = $param_cp_img2_path;
				$obj_cp_2_new->origin_img = $obj_new->campaindat[0]["cp_img2"];
				$obj_cp_2_new->gd_ver = 1;
				list($resize_cp_2_new,$imageType) = $obj_cp_2_new->ImageResizeSave();
				if($resize_cp_2_new == -1){
	                        	$obj_error->ViewErrMessage( "SYSTEM" , "ALL" , "blog_mnt.php" , $arrOther  );
	                       		exit;
				}

				$obj_other_2_save_new = new ImageControl;
				$obj_other_2_save_new->origin_dir = $param_cp_img2_path;
				$obj_other_2_save_new->origin_img = $obj_new->campaindat[0]["cp_img1"];
				$obj_other_2_save_new->imageResource = $resize_cp_2_new;
				$cp_2_suc_new = $obj_other_2_save_new->ImageSave($imageType);
				if($cp_2_suc_new == -1){
	                        	$obj_error->ViewErrMessage( "SYSTEM" , "ALL" , "blog_mnt.php" , $arrOther  );
	                       		exit;
				}
			}
			
			IF( is_uploaded_file( $_FILES["cp_img3"]["tmp_name"] ) ){
				// 一度画像を削除==>再度コピー
				IF( file_exists( $param_cp_img3_path.$_POST['cp_img3_lastupd'] ) && $_POST['cp_img3_lastupd'] != "" ){
					unlink( $param_cp_img3_path.$_POST['cp_img3_lastupd'] );
				}
				// 同じ名前で、UPLOADされたデータをコピー
				IF( is_uploaded_file($_FILES["cp_img3"]["tmp_name"]) && $obj_new->campaindat[0]["cp_img3"] != "" ){
					move_uploaded_file( $_FILES["cp_img3"]["tmp_name"] , $param_cp_img3_path.$obj_new->campaindat[0]["cp_img3"]);
					chmod( $param_cp_img3_path.$obj_new->campaindat[0]["cp_img3"] , 0755 );
				}

				$obj_cp_3_new = new ImageControl;
				$obj_cp_3_new->max_w = 580;
				$obj_cp_3_new->max_h = 580;
				$obj_cp_3_new->origin_dir = $param_cp_img3_path;
				$obj_cp_3_new->origin_img = $obj_new->campaindat[0]["cp_img3"];
				$obj_cp_3_new->gd_ver = 1;
				list($resize_cp_3_new,$imageType) = $obj_cp_3_new->ImageResizeSave();
				if($resize_cp_3_new == -1){
	                        	$obj_error->ViewErrMessage( "SYSTEM" , "ALL" , "blog_mnt.php" , $arrOther  );
	                       		exit;
				}

				$obj_other_3_save_new = new ImageControl;
				$obj_other_3_save_new->origin_dir = $param_cp_img3_path;
				$obj_other_3_save_new->origin_img = $obj_new->campaindat[0]["cp_img3"];
				$obj_other_3_save_new->imageResource = $resize_cp_3_new;
				$cp_3_suc_new = $obj_other_3_save_new->ImageSave($imageType);
				if($cp_3_suc_new == -1){
	                        	$obj_error->ViewErrMessage( "SYSTEM" , "ALL" , "blog_mnt.php" , $arrOther  );
	                       		exit;
				}
			}

			IF( is_uploaded_file( $_FILES["cp_img4"]["tmp_name"] ) ){
				// 一度画像を削除==>再度コピー
				IF( file_exists( $param_cp_img4_path.$_POST['cp_img4_lastupd'] ) && $_POST['cp_img4_lastupd'] != "" ){
					unlink( $param_cp_img4_path.$_POST['cp_img4_lastupd'] );
				}
				// 同じ名前で、UPLOADされたデータをコピー
				IF( is_uploaded_file($_FILES["cp_img4"]["tmp_name"]) && $obj_new->campaindat[0]["cp_img4"] != "" ){
					move_uploaded_file( $_FILES["cp_img4"]["tmp_name"] , $param_cp_img4_path.$obj_new->campaindat[0]["cp_img4"]);
					chmod( $param_cp_img4_path.$obj_new->campaindat[0]["cp_img4"] , 0755 );
				}

				$obj_cp_4_new = new ImageControl;
				$obj_cp_4_new->max_w = 580;
				$obj_cp_4_new->max_h = 580;
				$obj_cp_4_new->origin_dir = $param_cp_img4_path;
				$obj_cp_4_new->origin_img = $obj_new->campaindat[0]["cp_img4"];
				$obj_cp_4_new->gd_ver = 1;
				list($resize_cp_4_new,$imageType) = $obj_cp_4_new->ImageResizeSave();
				if($resize_cp_4_new == -1){
	                        	$obj_error->ViewErrMessage( "SYSTEM" , "ALL" , "blog_mnt.php" , $arrOther  );
	                       		exit;
				}

				$obj_other_4_save_new = new ImageControl;
				$obj_other_4_save_new->origin_dir = $param_cp_img4_path;
				$obj_other_4_save_new->origin_img = $obj_new->campaindat[0]["cp_img4"];
				$obj_other_4_save_new->imageResource = $resize_cp_4_new;
				$cp_4_suc_new = $obj_other_4_save_new->ImageSave($imageType);
				if($cp_4_suc_new == -1){
	                        	$obj_error->ViewErrMessage( "SYSTEM" , "ALL" , "blog_mnt.php" , $arrOther  );
	                       		exit;
				}
			}

//			IF( is_uploaded_file( $_FILES["cp_bkgdimg"]["tmp_name"] ) ){
				// 一度画像を削除==>再度コピー
//				IF( file_exists( $param_cp_bkgdimg_path.$_POST['cp_bkgdimg_lastupd'] ) && $_POST['cp_bkgdimg_lastupd'] != "" ){
//					unlink( $param_cp_bkgdimg_path.$_POST['cp_bkgdimg_lastupd'] );
//				}
				// 同じ名前で、UPLOADされたデータをコピー
//				IF( is_uploaded_file($_FILES["cp_bkgdimg"]["tmp_name"]) && $obj_new->campaindat[0]["cp_bkgdimg"] != "" ){
//					move_uploaded_file( $_FILES["cp_bkgdimg"]["tmp_name"] , $param_cp_bkgdimg_path.$obj_new->campaindat[0]["cp_bkgdimg"]);
//					chmod( $param_cp_bkgdimg_path.$obj_new->campaindat[0]["cp_bkgdimg"] , 0755 );
//				}
//
//				$obj_cp_5_new = new ImageControl;
//				$obj_cp_5_new->max_w = 300;
//				$obj_cp_5_new->max_h = 300;
//				$obj_cp_5_new->origin_dir = $param_cp_bkgdimg_path;
//				$obj_cp_5_new->origin_img = $obj_new->campaindat[0]["cp_bkgdimg"];
//				$obj_cp_5_new->gd_ver = 1;
//				list($resize_cp_5_new,$imageType) = $obj_cp_5_new->ImageResizeSave();
//				if($resize_cp_5_new == -1){
//	                        	$obj_error->ViewErrMessage( "SYSTEM" , "ALL" , "blog_mnt.php" , $arrOther  );
//	                       		exit;
//				}
//
//				$obj_other_5_save_new = new ImageControl;
//				$obj_other_5_save_new->origin_dir = $param_cp_bkgdimg_path;
//				$obj_other_5_save_new->origin_img = $obj_new->campaindat[0]["cp_bkgdimg"];
//				$obj_other_5_save_new->imageResource = $resize_cp_5_new;
//				$cp_5_suc_new = $obj_other_5_save_new->ImageSave($imageType);
//				if($cp_5_suc_new == -1){
//	                        	$obj_error->ViewErrMessage( "SYSTEM" , "ALL" , "blog_mnt.php" , $arrOther  );
//	                       		exit;
//				}
//			}

		}
		if( $suc == -1 ){
                        $arrOther["ath_comment"] = "<INPUT TYPE=\"hidden\" NAME=\"stpos\" VALUE=\"{$_POST['stpos']}\">";
			$arrOther['ath_comment'] .= $athComment;
                        $obj_error->ViewErrMessage( "INS_ERROR" , "ALL" , "campain_mnt.php" , $arrOther );
                        exit;
		}
		$message = "見出し記事を登録しました。";
		break;

	case "EDIT":
		// 画像1
                if( filesize($_FILES["cp_img1"]["tmp_name"]) > (1024*1024*2) ){
			$arrOther['ath_comment'] .= $athComment;
                        $obj_error->ViewErrMessage( "FILE_SIZE" , "ALL" , "campain_mnt.php" , $arrOther );
                        exit;
                }
                if( filesize($_FILES["cp_img2"]["tmp_name"]) > (1024*1024*2) ){
			$arrOther['ath_comment'] .= $athComment;
                        $obj_error->ViewErrMessage( "FILE_SIZE" , "ALL" , "campain_mnt.php" , $arrOther );
                        exit;
                }
                if( filesize($_FILES["cp_img3"]["tmp_name"]) > (1024*1024*2) ){
			$arrOther['ath_comment'] .= $athComment;
                        $obj_error->ViewErrMessage( "FILE_SIZE" , "ALL" , "campain_mnt.php" , $arrOther );
                        exit;
                }
                if( filesize($_FILES["cp_img4"]["tmp_name"]) > (1024*1024*2) ){
			$arrOther['ath_comment'] .= $athComment;
                        $obj_error->ViewErrMessage( "FILE_SIZE" , "ALL" , "campain_mnt.php" , $arrOther );
                        exit;
                }
//                if( filesize($_FILES["cp_bkgdimg"]["tmp_name"]) > (1024*1024*2) ){
//			$arrOther['ath_comment'] .= $athComment;
//                        $obj_error->ViewErrMessage( "FILE_SIZE" , "ALL" , "campain_mnt.php" , $arrOther );
//                        exit;
//                }

		// 画像1
		IF( is_uploaded_file( $_FILES["cp_img1"]["tmp_name"] ) ){
			$imageInfo = @getimagesize( $_FILES["cp_img1"]["tmp_name"] );
			IF( @getimagesize( $_FILES["cp_img1"]["tmp_name"] ) === FALSE || ( $imageInfo[2] != 1 && $imageInfo[2] != 2 ) ){
				$arrOther['ath_comment'] .= $athComment;
                        	$obj_error->ViewErrMessage( "NOT_IMG" , "ALL" , "campain_mnt.php" , $arrOther );
                        	exit;
			}
			$kaku1 = split("\.",$_FILES["cp_img1"]["name"]);
			$cp_imgorg1 = $kaku1[0].".".$kaku1[1];
			$cp_img1 = "campain_".$_SESSION["_cl_id"]."_".$_POST['cp_id']."_1.".$kaku1[1];
		}

		// 画像2
		IF( is_uploaded_file( $_FILES["cp_img2"]["tmp_name"] ) ){
			$imageInfo = @getimagesize( $_FILES["cp_img2"]["tmp_name"] );
			IF( @getimagesize( $_FILES["cp_img2"]["tmp_name"] ) === FALSE || ( $imageInfo[2] != 1 && $imageInfo[2] != 2 ) ){
				$arrOther['ath_comment'] .= $athComment;
                        	$obj_error->ViewErrMessage( "NOT_IMG" , "ALL" , "campain_mnt.php" , $arrOther );
                        	exit;
			}
			$kaku2 = split("\.",$_FILES["cp_img2"]["name"]);
			$cp_imgorg2 = $kaku2[0].".".$kaku2[1];
			$cp_img2 = "campain_".$_SESSION["_cl_id"]."_".$_POST["cp_id"]."_2.".$kaku2[1];
		}

		// 画像3
		IF( is_uploaded_file( $_FILES["cp_img3"]["tmp_name"] ) ){
			$imageInfo = @getimagesize( $_FILES["cp_img3"]["tmp_name"] );
			IF( @getimagesize( $_FILES["cp_img3"]["tmp_name"] ) === FALSE || ( $imageInfo[2] != 1 && $imageInfo[2] != 2 ) ){
				$arrOther['ath_comment'] .= $athComment;
                        	$obj_error->ViewErrMessage( "NOT_IMG" , "ALL" , "campain_mnt.php" , $arrOther );
                        	exit;
			}
			$kaku3 = split("\.",$_FILES["cp_img3"]["name"]);
			$cp_imgorg3 = $kaku3[0].".".$kaku3[1];
			$cp_img3 = "campain_".$_SESSION["_cl_id"]."_".$_POST["cp_id"]."_3.".$kaku3[1];
		}

		// 画像4
		IF( is_uploaded_file( $_FILES["cp_img4"]["tmp_name"] ) ){
			$imageInfo = @getimagesize( $_FILES["cp_img4"]["tmp_name"] );
			IF( @getimagesize( $_FILES["cp_img4"]["tmp_name"] ) === FALSE || ( $imageInfo[2] != 1 && $imageInfo[2] != 2 ) ){
				$arrOther['ath_comment'] .= $athComment;
                        	$obj_error->ViewErrMessage( "NOT_IMG" , "ALL" , "campain_mnt.php" , $arrOther );
                        	exit;
			}
			$kaku4 = split("\.",$_FILES["cp_img4"]["name"]);
			$cp_imgorg4 = $kaku4[0].".".$kaku4[1];
			$cp_img4 = "campain_".$_SESSION["_cl_id"]."_".$_POST["cp_id"]."_4.".$kaku4[1];
		}

		// 画像5
//		IF( is_uploaded_file( $_FILES["cp_bkgdimg"]["tmp_name"] ) ){
//			$imageInfo = @getimagesize( $_FILES["cp_bkgdimg"]["tmp_name"] );
//			IF( @getimagesize( $_FILES["cp_bkgdimg"]["tmp_name"] ) === FALSE || ( $imageInfo[2] != 1 && $imageInfo[2] != 2 ) ){
//				$arrOther['ath_comment'] .= $athComment;
//                        	$obj_error->ViewErrMessage( "NOT_IMG" , "ALL" , "campain_mnt.php" , $arrOther );
//                        	exit;
//			}
//			$kaku5 = split("\.",$_FILES["cp_bkgdimg"]["name"]);
//			$cp_bkgdimgorg = $kaku5[0].".".$kaku5[1];
//			$cp_bkgdimg = "campain_".$_SESSION["_cl_id"]."_".$_POST["cp_id"]."_5.".$kaku5[1];
//		}

		$obj_rev = new basedb_CampainClassTblAccess;
		$obj_rev->conn = $obj_conn->conn;
		$obj_rev->campaindat[0]["cp_id"] = $_POST["cp_id"];
		$obj_rev->campaindat[0]["cp_clid"] = $_SESSION["_cl_id"];

		$obj_rev->campaindat[0]["cp_stat"] = $_POST["cp_stat"];
		$obj_rev->campaindat[0]["cp_flg"] = $_POST["cp_flg"];
		$obj_rev->campaindat[0]["cp_topflg"] = $_POST["cp_topflg"];
		$obj_rev->campaindat[0]["cp_tcid"] = $_POST["cp_tcid"];
		$obj_rev->campaindat[0]["cp_tccomment"] = $_POST["cp_tccomment"];
		$obj_rev->campaindat[0]["cp_start"] = $_POST["cp_start"];
		$obj_rev->campaindat[0]["cp_end"] = $_POST["cp_end"];
		$obj_rev->campaindat[0]["cp_camstart"] = $_POST["cp_camstart"];
		$obj_rev->campaindat[0]["cp_camend"] = $_POST["cp_camend"];
		$obj_rev->campaindat[0]["cp_cgid"] = $_POST["cp_cgid"];
		$obj_rev->campaindat[0]["cp_title"] = $_POST["cp_title"];
		$obj_rev->campaindat[0]["cp_subtitle"] = $_POST["cp_subtitle"];
		$obj_rev->campaindat[0]["cp_linktext"] = $_POST["cp_linktext"];
		$obj_rev->campaindat[0]["cp_btntext"] = $_POST["cp_btntext"];
		$obj_rev->campaindat[0]["cp_contents"] = $_POST["cp_contents"];
		$obj_rev->campaindat[0]["cp_age"] = $cp_age;
		$obj_rev->campaindat[0]["cp_img1_del_chk"] = $_POST["cp_img1_del_chk"];
		IF( is_uploaded_file($_FILES["cp_img1"]["tmp_name"]) ){
			$obj_rev->campaindat[0]["cp_imgorg1"] = $cp_imgorg1;
			$obj_rev->campaindat[0]["cp_img1"] = $cp_img1;
		}
		$obj_rev->campaindat[0]["cp_img2_del_chk"] = $_POST["cp_img2_del_chk"];
		IF( is_uploaded_file($_FILES["cp_img2"]["tmp_name"]) ){
			$obj_rev->campaindat[0]["cp_imgorg2"] = $cp_imgorg2;
			$obj_rev->campaindat[0]["cp_img2"] = $cp_img2;
		}
		$obj_rev->campaindat[0]["cp_img3_del_chk"] = $_POST["cp_img3_del_chk"];
		IF( is_uploaded_file($_FILES["cp_img3"]["tmp_name"]) ){
			$obj_rev->campaindat[0]["cp_imgorg3"] = $cp_imgorg3;
			$obj_rev->campaindat[0]["cp_img3"] = $cp_img3;
		}
		$obj_rev->campaindat[0]["cp_img4_del_chk"] = $_POST["cp_img4_del_chk"];
		IF( is_uploaded_file($_FILES["cp_img4"]["tmp_name"]) ){
			$obj_rev->campaindat[0]["cp_imgorg4"] = $cp_imgorg4;
			$obj_rev->campaindat[0]["cp_img4"] = $cp_img4;
		}
//		$obj_rev->campaindat[0]["cp_bkgdimg_del_chk"] = $_POST["cp_bkgdimg_del_chk"];
//		IF( is_uploaded_file($_FILES["cp_bkgdimg"]["tmp_name"]) ){
//			$obj_rev->campaindat[0]["cp_bkgdimgorg"] = $cp_bkgdimgorg;
//		}
		$obj_rev->campaindat[0]["cp_bkgdimg"] = $_POST["cp_bkgdimg"];

		$obj_rev->campaindat[0]["cp_adminid"] = NULL;
		$obj_rev->campaindat[0]["cp_upddate"] = $_POST["cp_upddate"];
		$suc = $obj_rev->basedb_UpdCampain();
		IF( $suc == "0" ){
			IF($_POST['cp_img1_del_chk']==1){
				IF( file_exists( $param_cp_img1_path.$_POST['cp_img1_lastupd'] ) && $_POST['cp_img1_lastupd'] != "" ){
					unlink( $param_cp_img1_path.$_POST['cp_img1_lastupd'] );
				}
			}
			IF($_POST['cp_img2_del_chk']==1){
				IF( file_exists( $param_cp_img2_path.$_POST['cp_img2_lastupd'] ) && $_POST['cp_img2_lastupd'] != "" ){
					unlink( $param_cp_img2_path.$_POST['cp_img2_lastupd'] );
				}
			}
			IF($_POST['cp_img3_del_chk']==1){
				IF( file_exists( $param_cp_img3_path.$_POST['cp_img3_lastupd'] ) && $_POST['cp_img3_lastupd'] != "" ){
					unlink( $param_cp_img3_path.$_POST['cp_img3_lastupd'] );
				}
			}
			IF($_POST['cp_img4_del_chk']==1){
				IF( file_exists( $param_cp_img4_path.$_POST['cp_img4_lastupd'] ) && $_POST['cp_img4_lastupd'] != "" ){
					unlink( $param_cp_img4_path.$_POST['cp_img4_lastupd'] );
				}
			}
//			IF($_POST['cp_bkgdimg_del_chk']==1){
//				IF( file_exists( $param_cp_bkgdimg_path.$_POST['cp_bkgdimg_lastupd'] ) && $_POST['cp_bkgdimg_lastupd'] != "" ){
//					unlink( $param_cp_bkgdimg_path.$_POST['cp_bkgdimg_lastupd'] );
//				}
//			}
			// 画像保存・削除処理
			IF( is_uploaded_file( $_FILES["cp_img1"]["tmp_name"] ) ){
				// 一度画像を削除==>再度コピー
				IF( file_exists( $param_cp_img1_path.$_POST['cp_img1_lastupd'] ) && $_POST['cp_img1_lastupd'] != "" ){
					unlink( $param_cp_img1_path.$_POST['cp_img1_lastupd'] );
				}
				// 同じ名前で、UPLOADされたデータをコピー
				IF( is_uploaded_file($_FILES["cp_img1"]["tmp_name"]) && $obj_rev->campaindat[0]["cp_img1"] != "" ){
					move_uploaded_file( $_FILES["cp_img1"]["tmp_name"] , $param_cp_img1_path.$cp_img1 );
					chmod( $param_cp_img1_path.$cp_img1 , 0755 );
				}

				$obj_cp_1_rev = new ImageControl;
				$obj_cp_1_rev->max_w = 580;
				$obj_cp_1_rev->max_h = 580;
				$obj_cp_1_rev->origin_dir = $param_cp_img1_path;
				$obj_cp_1_rev->origin_img = $cp_img1;
				$obj_cp_1_rev->gd_ver = 1;
				list($resize_cp_1_rev,$imageType) = $obj_cp_1_rev->ImageResizeSave();
				if($resize_cp_1_rev == -1){
	                        	$obj_error->ViewErrMessage( "SYSTEM" , "ALL" , "blog_mnt.php" , $arrOther  );
	                       		exit;
				}

				$obj_cp_1_save_rev = new ImageControl;
				$obj_cp_1_save_rev->origin_dir = $param_cp_img1_path;
				$obj_cp_1_save_rev->origin_img = $cp_img1;
				$obj_cp_1_save_rev->imageResource = $resize_cp_1_rev;
				$cp_1_suc_rev = $obj_cp_1_save_rev->ImageSave($imageType);
				if($cp_1_suc_rev == -1){
	                        	$obj_error->ViewErrMessage( "SYSTEM" , "ALL" , "blog_mnt.php" , $arrOther  );
	                       		exit;
				}
			}
			
			IF( is_uploaded_file( $_FILES["cp_img2"]["tmp_name"] ) ){
				// 一度画像を削除==>再度コピー
				IF( file_exists( $param_cp_img2_path.$_POST['cp_img2_lastupd'] ) && $_POST['cp_img2_lastupd'] != "" ){
					unlink( $param_cp_img2_path.$_POST['cp_img2_lastupd'] );
				}
				// 同じ名前で、UPLOADされたデータをコピー
				IF( is_uploaded_file($_FILES["cp_img2"]["tmp_name"]) && $obj_rev->campaindat[0]["cp_img2"] != "" ){
					move_uploaded_file( $_FILES["cp_img2"]["tmp_name"] , $param_cp_img2_path.$cp_img2 );
					chmod( $param_cp_img2_path.$cp_img2 , 0755 );
				}

				$obj_cp_2_rev = new ImageControl;
				$obj_cp_2_rev->max_w = 580;
				$obj_cp_2_rev->max_h = 580;
				$obj_cp_2_rev->origin_dir = $param_cp_img2_path;
				$obj_cp_2_rev->origin_img = $cp_img2;
				$obj_cp_2_rev->gd_ver = 1;
				list($resize_cp_2_rev,$imageType) = $obj_cp_2_rev->ImageResizeSave();
				if($resize_cp_2_rev == -1){
	                        	$obj_error->ViewErrMessage( "SYSTEM" , "ALL" , "blog_mnt.php" , $arrOther  );
	                       		exit;
				}

				$obj_cp_2_save_rev = new ImageControl;
				$obj_cp_2_save_rev->origin_dir = $param_cp_img2_path;
				$obj_cp_2_save_rev->origin_img = $cp_img2;
				$obj_cp_2_save_rev->imageResource = $resize_cp_2_rev;
				$cp_2_suc_rev = $obj_cp_2_save_rev->ImageSave($imageType);
				if($cp_2_suc_rev == -1){
	                        	$obj_error->ViewErrMessage( "SYSTEM" , "ALL" , "blog_mnt.php" , $arrOther  );
	                       		exit;
				}
			}
			
			IF( is_uploaded_file( $_FILES["cp_img3"]["tmp_name"] ) ){
				// 一度画像を削除==>再度コピー
				IF( file_exists( $param_cp_img3_path.$_POST['cp_img3_lastupd'] ) && $_POST['cp_img3_lastupd'] != "" ){
					unlink( $param_cp_img3_path.$_POST['cp_img3_lastupd'] );
				}
				// 同じ名前で、UPLOADされたデータをコピー
				IF( is_uploaded_file($_FILES["cp_img3"]["tmp_name"]) && $obj_rev->campaindat[0]["cp_img3"] != "" ){
					move_uploaded_file( $_FILES["cp_img3"]["tmp_name"] , $param_cp_img3_path.$cp_img3);
					chmod( $param_cp_img3_path.$cp_img3 , 0755 );
				}

				$obj_cp_3_rev = new ImageControl;
				$obj_cp_3_rev->max_w = 580;
				$obj_cp_3_rev->max_h = 580;
				$obj_cp_3_rev->origin_dir = $param_cp_img3_path;
				$obj_cp_3_rev->origin_img = $cp_img3;
				$obj_cp_3_rev->gd_ver = 1;
				list($resize_cp_3_rev,$imageType) = $obj_cp_3_rev->ImageResizeSave();
				if($resize_cp_3_rev == -1){
	                        	$obj_error->ViewErrMessage( "SYSTEM" , "ALL" , "blog_mnt.php" , $arrOther  );
	                       		exit;
				}

				$obj_cp_3_save_rev = new ImageControl;
				$obj_cp_3_save_rev->origin_dir = $param_cp_img3_path;
				$obj_cp_3_save_rev->origin_img = $cp_img3;
				$obj_cp_3_save_rev->imageResource = $resize_cp_3_rev;
				$cp_3_suc_rev = $obj_cp_3_save_rev->ImageSave($imageType);
				if($cp_3_suc_rev == -1){
	                        	$obj_error->ViewErrMessage( "SYSTEM" , "ALL" , "blog_mnt.php" , $arrOther  );
	                       		exit;
				}
			}

			IF( is_uploaded_file( $_FILES["cp_img4"]["tmp_name"] ) ){
				// 一度画像を削除==>再度コピー
				IF( file_exists( $param_cp_img4_path.$_POST['cp_img4_lastupd'] ) && $_POST['cp_img4_lastupd'] != "" ){
					unlink( $param_cp_img4_path.$_POST['cp_img4_lastupd'] );
				}
				// 同じ名前で、UPLOADされたデータをコピー
				IF( is_uploaded_file($_FILES["cp_img4"]["tmp_name"]) && $obj_rev->campaindat[0]["cp_img4"] != "" ){
					move_uploaded_file( $_FILES["cp_img4"]["tmp_name"] , $param_cp_img4_path.$cp_img4);
					chmod( $param_cp_img4_path.$cp_img4 , 0755 );
				}

				$obj_cp_4_rev = new ImageControl;
				$obj_cp_4_rev->max_w = 580;
				$obj_cp_4_rev->max_h = 580;
				$obj_cp_4_rev->origin_dir = $param_cp_img4_path;
				$obj_cp_4_rev->origin_img = $cp_img4;
				$obj_cp_4_rev->gd_ver = 1;
				list($resize_cp_4_rev,$imageType) = $obj_cp_4_rev->ImageResizeSave();
				if($resize_cp_4_rev == -1){
	                        	$obj_error->ViewErrMessage( "SYSTEM" , "ALL" , "blog_mnt.php" , $arrOther  );
	                       		exit;
				}

				$obj_cp_4_save_rev = new ImageControl;
				$obj_cp_4_save_rev->origin_dir = $param_cp_img4_path;
				$obj_cp_4_save_rev->origin_img = $cp_img4;
				$obj_cp_4_save_rev->imageResource = $resize_cp_4_rev;
				$cp_4_suc_rev = $obj_cp_4_save_rev->ImageSave($imageType);
				if($cp_4_suc_rev == -1){
	                        	$obj_error->ViewErrMessage( "SYSTEM" , "ALL" , "blog_mnt.php" , $arrOther  );
	                       		exit;
				}
			}

//			IF( is_uploaded_file( $_FILES["cp_bkgdimg"]["tmp_name"] ) ){
				// 一度画像を削除==>再度コピー
//				IF( file_exists( $param_cp_bkgdimg_path.$_POST['cp_bkgdimg_lastupd'] ) && $_POST['cp_bkgdimg_lastupd'] != "" ){
//					unlink( $param_cp_bkgdimg_path.$_POST['cp_bkgdimg_lastupd'] );
//				}
				// 同じ名前で、UPLOADされたデータをコピー
//				IF( is_uploaded_file($_FILES["cp_bkgdimg"]["tmp_name"]) && $obj_rev->campaindat[0]["cp_bkgdimg"] != "" ){
//					move_uploaded_file( $_FILES["cp_bkgdimg"]["tmp_name"] , $param_cp_bkgdimg_path.$cp_bkgdimg);
//					chmod( $param_cp_bkgdimg_path.$cp_bkgdimg , 0755 );
//				}

//				$obj_cp_5_rev = new ImageControl;
//				$obj_cp_5_rev->max_w = 300;
//				$obj_cp_5_rev->max_h = 300;
//				$obj_cp_5_rev->origin_dir = $param_cp_bkgdimg_path;
//				$obj_cp_5_rev->origin_img = $cp_bkgdimg;
//				$obj_cp_5_rev->gd_ver = 1;
//				list($resize_cp_5_rev,$imageType) = $obj_cp_5_rev->ImageResizeSave();
//				if($resize_cp_5_rev == -1){
//	                        	$obj_error->ViewErrMessage( "SYSTEM" , "ALL" , "blog_mnt.php" , $arrOther  );
//	                       		exit;
//				}

//				$obj_cp_5_save_rev = new ImageControl;
//				$obj_cp_5_save_rev->origin_dir = $param_cp_bkgdimg_path;
//				$obj_cp_5_save_rev->origin_img = $cp_bkgdimg;
//				$obj_cp_5_save_rev->imageResource = $resize_cp_5_rev;
//				$cp_5_suc_rev = $obj_cp_5_save_rev->ImageSave($imageType);
//				if($cp_5_suc_rev == -1){
//	                        	$obj_error->ViewErrMessage( "SYSTEM" , "ALL" , "blog_mnt.php" , $arrOther  );
//	                       		exit;
//				}
//			}

		}
		switch( $suc ){
			case "-1":
				$arrOther['ath_comment'] .= $athComment;
                        	$arrOther["ath_comment"] = "<INPUT TYPE=\"hidden\" NAME=\"stpos\" VALUE=\"{$_POST['stpos']}\">";
                        	$obj_error->ViewErrMessage( "UPD_ERROR" , "ALL" , "campain_mnt.php" , $arrOther );
                        	exit;
			case "1":
                        	$arrOther["ath_comment"] = "<INPUT TYPE=\"hidden\" NAME=\"stpos\" VALUE=\"{$_POST['stpos']}\">";
                        	$obj_error->ViewErrMessage( "DOUBLE_UPD" , "ALL" , "campain_main.php" , $arrOther );
                        	exit;
		}
		$message = "見出し記事を修正しました。";
		break;

	case 'DEL':
		$obj_del = new basedb_CampainClassTblAccess;
		$obj_del->conn = $obj_conn->conn;
		$obj_del->campaindat[0]["cp_id"] = $_POST["cp_id"];
		$obj_del->campaindat[0]["cp_upddate"] = $_POST["cp_upddate"];
		$suc = $obj_del->basedb_DelCampain(0);
		if( $suc == -1 ){
                        $arrOther["ath_comment"] = "<INPUT TYPE=\"hidden\" NAME=\"stpos\" VALUE=\"{$_POST['stpos']}\">";
                        $obj_error->ViewErrMessage( "DEL_ERROR" , "ALL" , "campain_main.php" , $arrOther );
                        exit;
		}
		IF( $suc == "0" ){
			// 画像を削除
			IF( file_exists( $param_cp_img1_path.$_POST['cp_img1_lastupd'] ) && $_POST['cp_img1_lastupd'] != ""){
				unlink( $param_cp_img1_path.$_POST['cp_img1_lastupd'] );
			}
			IF( file_exists( $param_cp_img2_path.$_POST['cp_img2_lastupd'] ) && $_POST['cp_img2_lastupd'] != ""){
				unlink( $param_cp_img2_path.$_POST['cp_img2_lastupd'] );
			}
			IF( file_exists( $param_cp_img3_path.$_POST['cp_img3_lastupd'] ) && $_POST['cp_img3_lastupd'] != ""){
				unlink( $param_cp_img3_path.$_POST['cp_img3_lastupd'] );
			}
			IF( file_exists( $param_cp_img4_path.$_POST['cp_img4_lastupd'] ) && $_POST['cp_img4_lastupd'] != ""){
				unlink( $param_cp_img4_path.$_POST['cp_img4_lastupd'] );
			}
//			IF( file_exists( $param_cp_bkgdimg_path.$_POST['cp_bkgdimg_lastupd'] ) && $_POST['cp_bkgdimg_lastupd'] != ""){
//				unlink( $param_cp_bkgdimg_path.$_POST['cp_bkgdimg_lastupd'] );
//			}
		}
		$message = "指定された見出し記事を削除しました。";
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
    <TITLE>塾ブログ - クライアント管理ツール</title>
    <META http-equiv="Content-Type" content="text/html;charset=EUC-JP" />
    <META http-equiv="Content-Style-Type" content="text/css" />
    <META http-equiv="Content-Script-Type" content="text/javascript" />
    <LINK rel="stylesheet" href="../share/css/campain.css" type="text/css" />
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
      <form name="form1" action="campain_main.php" method="POST"> 
        <INPUT type="hidden" name="stpos" value="<?=$_POST['stpos']?>" />
        <input type="submit" value=" 戻 る " class="btn" />
      </form>
    </div>
  </body>
</html>
