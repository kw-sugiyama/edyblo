<?
/******************************************************************************
<< 不動産ブログ　Ver.1.O.0 >>
	Name: cs_upd.php
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
require_once ( SYS_PATH."dbif/basedb_CourseClass.php" );
require_once ( SYS_PATH."dbif/basedb_ClientClass.php" );
require_once ( SYS_PATH."dbif/basedb_DiaryClass.php" );
require_once ( SYS_PATH."dbif/viewdb_CourseClass.php" );
require_once ( SYS_PATH."dbif/viewdb_ClientClass.php" );
require_once ( SYS_PATH."dbif/viewdb_DiaryClass.php" );
require_once ( SYS_PATH."common/base_common.php" );
require_once ( SYS_PATH."common/sys_common.php" );
include_once ( SYS_PATH."common/error.class.php" );
require_once ( SYS_PATH."common/ImageControl.class.php" );
require_once ( SYS_PATH."configs/param_file.conf" );
require_once ( SYS_PATH."configs/param_room.conf" );
require_once ( SYS_PATH."configs/param_base.conf" );

// (&,<,>,",')をエスケープ 20090915 html_deleteでタグを除去してから
function fn_escape_rss($str) {
	require ( "../ini_sets_2.php" );
	require ( SYS_PATH."configs/param_base.conf" );
	
	$buf_str = $str;
	FOREACH( $rss_replace_moto as $key_moto => $val_moto ){
		$val_moto = mb_convert_encoding($val_moto,"UTF-8","EUC-JP");
		$val_saki = mb_convert_encoding($rss_replace_saki[$key_moto],"UTF-8","EUC-JP");
		$buf_str = str_replace($val_moto,$val_saki, html_delete($buf_str) );
	}

	return $buf_str;

}

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
if($_POST["cs_start_h"]!="" && $_POST["cs_start_m"]!=""){
	$_POST["cs_start"] = $_POST["cs_start_h"].":".$_POST["cs_start_m"];
}else{
	$_POST["cs_start"] = "";
}
if($_POST["cs_end_h"]!="" && $_POST["cs_end_m"]!=""){
	$_POST["cs_end"] = $_POST["cs_end_h"].":".$_POST["cs_end_m"];
}else{
	$_POST["cs_end"] = "";
}


// 対象学年
$cs_age = 0;
$agecnt = count($_POST['cs_age']);
if($agecnt!=0){
	foreach($_POST['cs_age'] as $key => $val){
		$cs_age += $val;
	}
}


// 指導形態
$cs_classform = 0;
$classformcnt = count($_POST['cs_classform']);
if($classformcnt!=0){
	foreach($_POST['cs_classform'] as $key => $val){
		$cs_classform += $val;
	}
}


// レベル
$cs_level = 0;
$levelcnt = count($_POST['cs_level']);
if($levelcnt!=0){
	foreach($_POST['cs_level'] as $key => $val){
		$cs_level += $val;
	}
}

// 目的
$cs_purpose = 0;
$purposecnt = count($_POST['cs_purpose']);
if($purposecnt!=0){
	foreach($_POST['cs_purpose'] as $key => $val){
		$cs_purpose += $val;
	}
}

SWITCH( $_POST["mode"] ){
	case "NEW":
		// 画像1
                if( filesize($_FILES["cs_img1"]["tmp_name"]) > (1024*1024*2) ){
			$arrOther['ath_comment'] .= $athComment;
                        $obj_error->ViewErrMessage( "FILE_SIZE" , "ALL" , "course_mnt.php" , $arrOther );
                        exit;
                }
                if( filesize($_FILES["cs_img2"]["tmp_name"]) > (1024*1024*2) ){
			$arrOther['ath_comment'] .= $athComment;
                        $obj_error->ViewErrMessage( "FILE_SIZE" , "ALL" , "course_mnt.php" , $arrOther );
                        exit;
                }
                if( filesize($_FILES["cs_img3"]["tmp_name"]) > (1024*1024*2) ){
			$arrOther['ath_comment'] .= $athComment;
                        $obj_error->ViewErrMessage( "FILE_SIZE" , "ALL" , "course_mnt.php" , $arrOther );
                        exit;
                }
                if( filesize($_FILES["cs_img4"]["tmp_name"]) > (1024*1024*2) ){
			$arrOther['ath_comment'] .= $athComment;
                        $obj_error->ViewErrMessage( "FILE_SIZE" , "ALL" , "course_mnt.php" , $arrOther );
                        exit;
                }
                if( filesize($_FILES["cs_img5"]["tmp_name"]) > (1024*1024*2) ){
			$arrOther['ath_comment'] .= $athComment;
                        $obj_error->ViewErrMessage( "FILE_SIZE" , "ALL" , "course_mnt.php" , $arrOther );
                        exit;
                }
		IF( is_uploaded_file( $_FILES["cs_img1"]["tmp_name"] ) ){
			$imageInfo = @getimagesize( $_FILES["cs_img1"]["tmp_name"] );
			IF( @getimagesize( $_FILES["cs_img1"]["tmp_name"] ) === FALSE || ( $imageInfo[2] != 1 && $imageInfo[2] != 2 ) ){
				$arrOther['ath_comment'] .= $athComment;
                        	$obj_error->ViewErrMessage( "NOT_IMG" , "ALL" , "course_mnt.php" , $arrOther );
                        	exit;
			}
		$kaku1 = split("\.",$_FILES["cs_img1"]["name"]);
		$cs_imgorg1 = $kaku1[0].".".$kaku1[1];
		$cs_img1 = "course_".$_SESSION["_cl_id"]."_/_1.".$kaku1[1];
		}

		// 画像2
		IF( is_uploaded_file( $_FILES["cs_img2"]["tmp_name"] ) ){
			$imageInfo = @getimagesize( $_FILES["cs_img2"]["tmp_name"] );
			IF( @getimagesize( $_FILES["cs_img2"]["tmp_name"] ) === FALSE || ( $imageInfo[2] != 1 && $imageInfo[2] != 2 ) ){
				$arrOther['ath_comment'] .= $athComment;
                        	$obj_error->ViewErrMessage( "NOT_IMG" , "ALL" , "course_mnt.php" , $arrOther );
                        	exit;
			}
		$kaku2 = split("\.",$_FILES["cs_img2"]["name"]);
		$cs_imgorg2 = $kaku2[0].".".$kaku2[1];
		$cs_img2 = "course_".$_SESSION["_cl_id"]."_/_2.".$kaku2[1];
		}

		// 画像3
		IF( is_uploaded_file( $_FILES["cs_img3"]["tmp_name"] ) ){
			$imageInfo = @getimagesize( $_FILES["cs_img3"]["tmp_name"] );
			IF( @getimagesize( $_FILES["cs_img3"]["tmp_name"] ) === FALSE || ( $imageInfo[2] != 1 && $imageInfo[2] != 2 ) ){
				$arrOther['ath_comment'] .= $athComment;
                        	$obj_error->ViewErrMessage( "NOT_IMG" , "ALL" , "course_mnt.php" , $arrOther );
                        	exit;
			}
		$kaku3 = split("\.",$_FILES["cs_img3"]["name"]);
		$cs_imgorg3 = $kaku3[0].".".$kaku3[1];
		$cs_img3 = "course_".$_SESSION["_cl_id"]."_/_3.".$kaku3[1];
		}

		// 画像4
		IF( is_uploaded_file( $_FILES["cs_img4"]["tmp_name"] ) ){
			$imageInfo = @getimagesize( $_FILES["cs_img4"]["tmp_name"] );
			IF( @getimagesize( $_FILES["cs_img4"]["tmp_name"] ) === FALSE || ( $imageInfo[2] != 1 && $imageInfo[2] != 2 ) ){
				$arrOther['ath_comment'] .= $athComment;
                        	$obj_error->ViewErrMessage( "NOT_IMG" , "ALL" , "course_mnt.php" , $arrOther );
                        	exit;
			}
		$kaku4 = split("\.",$_FILES["cs_img4"]["name"]);
		$cs_imgorg4 = $kaku4[0].".".$kaku4[1];
		$cs_img4 = "course_".$_SESSION["_cl_id"]."_/_4.".$kaku4[1];
		}

		// 画像5
		IF( is_uploaded_file( $_FILES["cs_img5"]["tmp_name"] ) ){
			$imageInfo = @getimagesize( $_FILES["cs_img5"]["tmp_name"] );
			IF( @getimagesize( $_FILES["cs_img5"]["tmp_name"] ) === FALSE || ( $imageInfo[2] != 1 && $imageInfo[2] != 2 ) ){
				$arrOther['ath_comment'] .= $athComment;
                        	$obj_error->ViewErrMessage( "NOT_IMG" , "ALL" , "course_mnt.php" , $arrOther );
                        	exit;
			}
		$kaku5 = split("\.",$_FILES["cs_img5"]["name"]);
		$cs_imgorg5 = $kaku5[0].".".$kaku5[1];
		$cs_img5 = "course_".$_SESSION["_cl_id"]."_/_5.".$kaku5[1];
		}

		$obj_new = new basedb_CourseClassTblAccess;
		$obj_new->conn = $obj_conn->conn;
		$obj_new->coursedat[0]["cs_id"] = $_POST["cs_id"];
		$obj_new->coursedat[0]["cs_clid"] = $_SESSION["_cl_id"];
		$obj_new->coursedat[0]["cs_stat"] = $_POST["cs_stat"];
		$obj_new->coursedat[0]["cs_cgid"] = $_POST["cs_cgid"];
		$obj_new->coursedat[0]["cs_title"] = $_POST["cs_title"];

		$obj_new->coursedat[0]["cs_jtitle"] = $_POST["cs_jtitle"];

		$obj_new->coursedat[0]["cs_tccomment"] = $_POST["cs_tccomment"];
		$obj_new->coursedat[0]["cs_start"] = $_POST["cs_start"];
		$obj_new->coursedat[0]["cs_end"] = $_POST["cs_end"];
		$obj_new->coursedat[0]["cs_week"] = $_POST["cs_week"];

		$obj_new->coursedat[0]["cs_organize"] = $_POST["cs_organize"];
		$obj_new->coursedat[0]["cs_price"] = $_POST["cs_price"];
		$obj_new->coursedat[0]["cs_entrance"] = $_POST["cs_entrance"];
		$obj_new->coursedat[0]["cs_shisetsu"] = $_POST["cs_shisetsu"];
		$obj_new->coursedat[0]["cs_textfee"] = $_POST["cs_textfee"];
		$obj_new->coursedat[0]["cs_monthlyfee"] = $_POST["cs_monthlyfee"];
		$obj_new->coursedat[0]["cs_age"] = $cs_age;
		$obj_new->coursedat[0]["cs_level"] = $cs_level;
		$obj_new->coursedat[0]["cs_purpose"] = $cs_purpose;
		$obj_new->coursedat[0]["cs_subject"] = $_POST["cs_subject"];
		$obj_new->coursedat[0]["cs_pr"] = $_POST["cs_pr"];
		$obj_new->coursedat[0]["cs_tcid"] = $_POST["cs_tcid"];
		$obj_new->coursedat[0]["cs_tcflg"] = $_POST["cs_tcflg"];

		IF( is_uploaded_file($_FILES["cs_img1"]["tmp_name"]) ){
			$obj_new->coursedat[0]["cs_imgorg1"] = $cs_imgorg1;
			$obj_new->coursedat[0]["cs_img1"] = $cs_img1;
		}
		IF( is_uploaded_file($_FILES["cs_img2"]["tmp_name"]) ){
			$obj_new->coursedat[0]["cs_imgorg2"] = $cs_imgorg2;
			$obj_new->coursedat[0]["cs_img2"] = $cs_img2;
		}
		IF( is_uploaded_file($_FILES["cs_img3"]["tmp_name"]) ){
			$obj_new->coursedat[0]["cs_imgorg3"] = $cs_imgorg3;
			$obj_new->coursedat[0]["cs_img3"] = $cs_img3;
		}
		IF( is_uploaded_file($_FILES["cs_img4"]["tmp_name"]) ){
			$obj_new->coursedat[0]["cs_imgorg4"] = $cs_imgorg4;
			$obj_new->coursedat[0]["cs_img4"] = $cs_img4;
		}
		IF( is_uploaded_file($_FILES["cs_img5"]["tmp_name"]) ){
			$obj_new->coursedat[0]["cs_imgorg5"] = $cs_imgorg5;
			$obj_new->coursedat[0]["cs_img5"] = $cs_img5;
		}
		IF( $_POST['cs_map'] != "" ){
			$obj_new->coursedat[0]["cs_map"] = $_POST['cs_map'];
		}
		$obj_new->coursedat[0]["cs_ido"] = $_POST['cs_ido'];
		$obj_new->coursedat[0]["cs_keido"] = $_POST['cs_keido'];
		$obj_new->coursedat[0]["cs_zoom"] = $_POST['cs_zoom'];
		$obj_new->coursedat[0]["cs_topflg"] = $_POST['cs_topflg'];
		$obj_new->coursedat[0]["cs_classform"] = $cs_classform;
		$obj_new->coursedat[0]["cs_adminid"] = NULL;
		$obj_new->coursedat[0]["cs_upddate"] = $_POST["cs_upddate"];
		$suc = $obj_new->basedb_InsCourse();
		IF( $suc == "0" ){


			// 画像保存・削除処理
			IF( is_uploaded_file( $_FILES["cs_img1"]["tmp_name"] ) ){
				// 一度画像を削除==>再度コピー
				IF( file_exists( $param_cs_img1_path.$_POST['cs_img1_lastupd'] ) && $_POST['cs_img1_lastupd'] != "" ){
					unlink( $param_cs_img1_path.$_POST['cs_img1_lastupd'] );
				}
				// 同じ名前で、UPLOADされたデータをコピー
				IF( is_uploaded_file($_FILES["cs_img1"]["tmp_name"]) && $obj_new->coursedat[0]["cs_img1"] != "" ){
					move_uploaded_file( $_FILES["cs_img1"]["tmp_name"] , $param_cs_img1_path.$obj_new->coursedat[0]["cs_img1"] );
					chmod( $param_cs_img1_path.$obj_new->coursedat[0]["cs_img1"] , 0755 );
				}

				$obj_cs_1_new = new ImageControl;
				$obj_cs_1_new->max_w = 580;
				$obj_cs_1_new->max_h = 580;
				$obj_cs_1_new->origin_dir = $param_cs_img1_path;
				$obj_cs_1_new->origin_img = $obj_new->coursedat[0]["cs_img1"];
				$obj_cs_1_new->gd_ver = 1;
				list($resize_cs_1_new,$imageType) = $obj_cs_1_new->ImageResizeSave();
				if($resize_cs_1_new == -1){
	                        	$obj_error->ViewErrMessage( "SYSTEM" , "ALL" , "blog_mnt.php" , $arrOther  );
	                       		exit;
				}

				$obj_other_1_save_new = new ImageControl;
				$obj_other_1_save_new->origin_dir = $param_cs_img1_path;
				$obj_other_1_save_new->origin_img = $obj_new->coursedat[0]["cs_img1"];
				$obj_other_1_save_new->imageResource = $resize_cs_1_new;
				$cs_1_suc_new = $obj_other_1_save_new->ImageSave($imageType);
				if($cs_1_suc_new == -1){
	                        	$obj_error->ViewErrMessage( "SYSTEM" , "ALL" , "blog_mnt.php" , $arrOther  );
	                       		exit;
				}
			}
			
			IF( is_uploaded_file( $_FILES["cs_img2"]["tmp_name"] ) ){
				// 一度画像を削除==>再度コピー
				IF( file_exists( $param_cs_img2_path.$_POST['cs_img2_lastupd'] ) && $_POST['cs_img2_lastupd'] != "" ){
					unlink( $param_cs_img2_path.$_POST['cs_img2_lastupd'] );
				}
				// 同じ名前で、UPLOADされたデータをコピー
				IF( is_uploaded_file($_FILES["cs_img2"]["tmp_name"]) && $obj_new->coursedat[0]["cs_img2"] != "" ){
					move_uploaded_file( $_FILES["cs_img2"]["tmp_name"] , $param_cs_img2_path.$obj_new->coursedat[0]["cs_img2"] );
					chmod( $param_cs_img2_path.$obj_new->coursedat[0]["cs_img2"] , 0755 );
				}

				$obj_cs_2_new = new ImageControl;
				$obj_cs_2_new->max_w = 580;
				$obj_cs_2_new->max_h = 580;
				$obj_cs_2_new->origin_dir = $param_cs_img2_path;
				$obj_cs_2_new->origin_img = $obj_new->coursedat[0]["cs_img2"];
				$obj_cs_2_new->gd_ver = 1;
				list($resize_cs_2_new,$imageType) = $obj_cs_2_new->ImageResizeSave();
				if($resize_cs_2_new == -1){
	                        	$obj_error->ViewErrMessage( "SYSTEM" , "ALL" , "blog_mnt.php" , $arrOther  );
	                       		exit;
				}

				$obj_other_2_save_new = new ImageControl;
				$obj_other_2_save_new->origin_dir = $param_cs_img2_path;
				$obj_other_2_save_new->origin_img = $obj_new->coursedat[0]["cs_img1"];
				$obj_other_2_save_new->imageResource = $resize_cs_2_new;
				$cs_2_suc_new = $obj_other_2_save_new->ImageSave($imageType);
				if($cs_2_suc_new == -1){
	                        	$obj_error->ViewErrMessage( "SYSTEM" , "ALL" , "blog_mnt.php" , $arrOther  );
	                       		exit;
				}
			}
			
			IF( is_uploaded_file( $_FILES["cs_img3"]["tmp_name"] ) ){
				// 一度画像を削除==>再度コピー
				IF( file_exists( $param_cs_img3_path.$_POST['cs_img3_lastupd'] ) && $_POST['cs_img3_lastupd'] != "" ){
					unlink( $param_cs_img3_path.$_POST['cs_img3_lastupd'] );
				}
				// 同じ名前で、UPLOADされたデータをコピー
				IF( is_uploaded_file($_FILES["cs_img3"]["tmp_name"]) && $obj_new->coursedat[0]["cs_img3"] != "" ){
					move_uploaded_file( $_FILES["cs_img3"]["tmp_name"] , $param_cs_img3_path.$obj_new->coursedat[0]["cs_img3"]);
					chmod( $param_cs_img3_path.$obj_new->coursedat[0]["cs_img3"] , 0755 );
				}

				$obj_cs_3_new = new ImageControl;
				$obj_cs_3_new->max_w = 580;
				$obj_cs_3_new->max_h = 580;
				$obj_cs_3_new->origin_dir = $param_cs_img3_path;
				$obj_cs_3_new->origin_img = $obj_new->coursedat[0]["cs_img3"];
				$obj_cs_3_new->gd_ver = 1;
				list($resize_cs_3_new,$imageType) = $obj_cs_3_new->ImageResizeSave();
				if($resize_cs_3_new == -1){
	                        	$obj_error->ViewErrMessage( "SYSTEM" , "ALL" , "blog_mnt.php" , $arrOther  );
	                       		exit;
				}

				$obj_other_3_save_new = new ImageControl;
				$obj_other_3_save_new->origin_dir = $param_cs_img3_path;
				$obj_other_3_save_new->origin_img = $obj_new->coursedat[0]["cs_img3"];
				$obj_other_3_save_new->imageResource = $resize_cs_3_new;
				$cs_3_suc_new = $obj_other_3_save_new->ImageSave($imageType);
				if($cs_3_suc_new == -1){
	                        	$obj_error->ViewErrMessage( "SYSTEM" , "ALL" , "blog_mnt.php" , $arrOther  );
	                       		exit;
				}
			}

			IF( is_uploaded_file( $_FILES["cs_img4"]["tmp_name"] ) ){
				// 一度画像を削除==>再度コピー
				IF( file_exists( $param_cs_img4_path.$_POST['cs_img4_lastupd'] ) && $_POST['cs_img4_lastupd'] != "" ){
					unlink( $param_cs_img4_path.$_POST['cs_img4_lastupd'] );
				}
				// 同じ名前で、UPLOADされたデータをコピー
				IF( is_uploaded_file($_FILES["cs_img4"]["tmp_name"]) && $obj_new->coursedat[0]["cs_img4"] != "" ){
					move_uploaded_file( $_FILES["cs_img4"]["tmp_name"] , $param_cs_img4_path.$obj_new->coursedat[0]["cs_img4"]);
					chmod( $param_cs_img4_path.$obj_new->coursedat[0]["cs_img4"] , 0755 );
				}

				$obj_cs_4_new = new ImageControl;
				$obj_cs_4_new->max_w = 580;
				$obj_cs_4_new->max_h = 580;
				$obj_cs_4_new->origin_dir = $param_cs_img4_path;
				$obj_cs_4_new->origin_img = $obj_new->coursedat[0]["cs_img4"];
				$obj_cs_4_new->gd_ver = 1;
				list($resize_cs_4_new,$imageType) = $obj_cs_4_new->ImageResizeSave();
				if($resize_cs_4_new == -1){
	                        	$obj_error->ViewErrMessage( "SYSTEM" , "ALL" , "blog_mnt.php" , $arrOther  );
	                       		exit;
				}

				$obj_other_4_save_new = new ImageControl;
				$obj_other_4_save_new->origin_dir = $param_cs_img4_path;
				$obj_other_4_save_new->origin_img = $obj_new->coursedat[0]["cs_img4"];
				$obj_other_4_save_new->imageResource = $resize_cs_4_new;
				$cs_4_suc_new = $obj_other_4_save_new->ImageSave($imageType);
				if($cs_4_suc_new == -1){
	                        	$obj_error->ViewErrMessage( "SYSTEM" , "ALL" , "blog_mnt.php" , $arrOther  );
	                       		exit;
				}
			}

			IF( is_uploaded_file( $_FILES["cs_img5"]["tmp_name"] ) ){
				// 一度画像を削除==>再度コピー
				IF( file_exists( $param_cs_img5_path.$_POST['cs_img5_lastupd'] ) && $_POST['cs_img5_lastupd'] != "" ){
					unlink( $param_cs_img5_path.$_POST['cs_img5_lastupd'] );
				}
				// 同じ名前で、UPLOADされたデータをコピー
				IF( is_uploaded_file($_FILES["cs_img5"]["tmp_name"]) && $obj_new->coursedat[0]["cs_img5"] != "" ){
					move_uploaded_file( $_FILES["cs_img5"]["tmp_name"] , $param_cs_img5_path.$obj_new->coursedat[0]["cs_img5"]);
					chmod( $param_cs_img5_path.$obj_new->coursedat[0]["cs_img5"] , 0755 );
				}

				$obj_cs_5_new = new ImageControl;
				$obj_cs_5_new->max_w = 580;
				$obj_cs_5_new->max_h = 580;
				$obj_cs_5_new->origin_dir = $param_cs_img5_path;
				$obj_cs_5_new->origin_img = $obj_new->coursedat[0]["cs_img5"];
				$obj_cs_5_new->gd_ver = 1;
				list($resize_cs_5_new,$imageType) = $obj_cs_5_new->ImageResizeSave();
				if($resize_cs_5_new == -1){
	                        	$obj_error->ViewErrMessage( "SYSTEM" , "ALL" , "blog_mnt.php" , $arrOther  );
	                       		exit;
				}

				$obj_other_5_save_new = new ImageControl;
				$obj_other_5_save_new->origin_dir = $param_cs_img5_path;
				$obj_other_5_save_new->origin_img = $obj_new->coursedat[0]["cs_img5"];
				$obj_other_5_save_new->imageResource = $resize_cs_5_new;
				$cs_5_suc_new = $obj_other_5_save_new->ImageSave($imageType);
				if($cs_5_suc_new == -1){
	                        	$obj_error->ViewErrMessage( "SYSTEM" , "ALL" , "blog_mnt.php" , $arrOther  );
	                       		exit;
				}
			}

		}
		if( $suc == -1 ){
                        $arrOther["ath_comment"] = "<INPUT TYPE=\"hidden\" NAME=\"stpos\" VALUE=\"{$_POST['stpos']}\">";
			$arrOther['ath_comment'] .= $athComment;
                        $obj_error->ViewErrMessage( "INS_ERROR" , "ALL" , "course_mnt.php" , $arrOther );
                        exit;
		}
		$message = "見出し記事を登録しました。";
		break;

	case "EDIT":
		// 画像1
                if( filesize($_FILES["cs_img1"]["tmp_name"]) > (1024*1024*2) ){
			$arrOther['ath_comment'] .= $athComment;
                        $obj_error->ViewErrMessage( "FILE_SIZE" , "ALL" , "course_mnt.php" , $arrOther );
                        exit;
                }
                if( filesize($_FILES["cs_img2"]["tmp_name"]) > (1024*1024*2) ){
			$arrOther['ath_comment'] .= $athComment;
                        $obj_error->ViewErrMessage( "FILE_SIZE" , "ALL" , "course_mnt.php" , $arrOther );
                        exit;
                }
                if( filesize($_FILES["cs_img3"]["tmp_name"]) > (1024*1024*2) ){
			$arrOther['ath_comment'] .= $athComment;
                        $obj_error->ViewErrMessage( "FILE_SIZE" , "ALL" , "course_mnt.php" , $arrOther );
                        exit;
                }
                if( filesize($_FILES["cs_img4"]["tmp_name"]) > (1024*1024*2) ){
			$arrOther['ath_comment'] .= $athComment;
                        $obj_error->ViewErrMessage( "FILE_SIZE" , "ALL" , "course_mnt.php" , $arrOther );
                        exit;
                }
                if( filesize($_FILES["cs_img5"]["tmp_name"]) > (1024*1024*2) ){
			$arrOther['ath_comment'] .= $athComment;
                        $obj_error->ViewErrMessage( "FILE_SIZE" , "ALL" , "course_mnt.php" , $arrOther );
                        exit;
                }

		// 画像1
		IF( is_uploaded_file( $_FILES["cs_img1"]["tmp_name"] ) ){
			$imageInfo = @getimagesize( $_FILES["cs_img1"]["tmp_name"] );
			IF( @getimagesize( $_FILES["cs_img1"]["tmp_name"] ) === FALSE || ( $imageInfo[2] != 1 && $imageInfo[2] != 2 ) ){
				$arrOther['ath_comment'] .= $athComment;
                        	$obj_error->ViewErrMessage( "NOT_IMG" , "ALL" , "course_mnt.php" , $arrOther );
                        	exit;
			}
			$kaku1 = split("\.",$_FILES["cs_img1"]["name"]);
			$cs_imgorg1 = $kaku1[0].".".$kaku1[1];
			$cs_img1 = "course_".$_SESSION["_cl_id"]."_".$_POST['cs_id']."_1.".$kaku1[1];
		}

		// 画像2
		IF( is_uploaded_file( $_FILES["cs_img2"]["tmp_name"] ) ){
			$imageInfo = @getimagesize( $_FILES["cs_img2"]["tmp_name"] );
			IF( @getimagesize( $_FILES["cs_img2"]["tmp_name"] ) === FALSE || ( $imageInfo[2] != 1 && $imageInfo[2] != 2 ) ){
				$arrOther['ath_comment'] .= $athComment;
                        	$obj_error->ViewErrMessage( "NOT_IMG" , "ALL" , "course_mnt.php" , $arrOther );
                        	exit;
			}
			$kaku2 = split("\.",$_FILES["cs_img2"]["name"]);
			$cs_imgorg2 = $kaku2[0].".".$kaku2[1];
			$cs_img2 = "course_".$_SESSION["_cl_id"]."_".$_POST["cs_id"]."_2.".$kaku2[1];
		}

		// 画像3
		IF( is_uploaded_file( $_FILES["cs_img3"]["tmp_name"] ) ){
			$imageInfo = @getimagesize( $_FILES["cs_img3"]["tmp_name"] );
			IF( @getimagesize( $_FILES["cs_img3"]["tmp_name"] ) === FALSE || ( $imageInfo[2] != 1 && $imageInfo[2] != 2 ) ){
				$arrOther['ath_comment'] .= $athComment;
                        	$obj_error->ViewErrMessage( "NOT_IMG" , "ALL" , "course_mnt.php" , $arrOther );
                        	exit;
			}
			$kaku3 = split("\.",$_FILES["cs_img3"]["name"]);
			$cs_imgorg3 = $kaku3[0].".".$kaku3[1];
			$cs_img3 = "course_".$_SESSION["_cl_id"]."_".$_POST["cs_id"]."_3.".$kaku3[1];
		}

		// 画像4
		IF( is_uploaded_file( $_FILES["cs_img4"]["tmp_name"] ) ){
			$imageInfo = @getimagesize( $_FILES["cs_img4"]["tmp_name"] );
			IF( @getimagesize( $_FILES["cs_img4"]["tmp_name"] ) === FALSE || ( $imageInfo[2] != 1 && $imageInfo[2] != 2 ) ){
				$arrOther['ath_comment'] .= $athComment;
                        	$obj_error->ViewErrMessage( "NOT_IMG" , "ALL" , "course_mnt.php" , $arrOther );
                        	exit;
			}
			$kaku4 = split("\.",$_FILES["cs_img4"]["name"]);
			$cs_imgorg4 = $kaku4[0].".".$kaku4[1];
			$cs_img4 = "course_".$_SESSION["_cl_id"]."_".$_POST["cs_id"]."_4.".$kaku4[1];
		}

		// 画像5
		IF( is_uploaded_file( $_FILES["cs_img5"]["tmp_name"] ) ){
			$imageInfo = @getimagesize( $_FILES["cs_img5"]["tmp_name"] );
			IF( @getimagesize( $_FILES["cs_img5"]["tmp_name"] ) === FALSE || ( $imageInfo[2] != 1 && $imageInfo[2] != 2 ) ){
				$arrOther['ath_comment'] .= $athComment;
                        	$obj_error->ViewErrMessage( "NOT_IMG" , "ALL" , "course_mnt.php" , $arrOther );
                        	exit;
			}
			$kaku5 = split("\.",$_FILES["cs_img5"]["name"]);
			$cs_imgorg5 = $kaku5[0].".".$kaku5[1];
			$cs_img5 = "course_".$_SESSION["_cl_id"]."_".$_POST["cs_id"]."_5.".$kaku5[1];
		}

		$obj_rev = new basedb_CourseClassTblAccess;
		$obj_rev->conn = $obj_conn->conn;
		$obj_rev->coursedat[0]["cs_id"] = $_POST["cs_id"];
		$obj_rev->coursedat[0]["cs_clid"] = $_SESSION["_cl_id"];
		$obj_rev->coursedat[0]["cs_stat"] = $_POST["cs_stat"];
		$obj_rev->coursedat[0]["cs_cgid"] = $_POST["cs_cgid"];
		$obj_rev->coursedat[0]["cs_title"] = $_POST["cs_title"];

		$obj_rev->coursedat[0]["cs_jtitle"] = $_POST["cs_jtitle"];

		$obj_rev->coursedat[0]["cs_tccomment"] = $_POST["cs_tccomment"];
		$obj_rev->coursedat[0]["cs_start"] = $_POST["cs_start"];
		$obj_rev->coursedat[0]["cs_end"] = $_POST["cs_end"];
		$obj_rev->coursedat[0]["cs_week"] = $_POST["cs_week"];

		$obj_rev->coursedat[0]["cs_organize"] = $_POST["cs_organize"];
		$obj_rev->coursedat[0]["cs_price"] = $_POST["cs_price"];
		$obj_rev->coursedat[0]["cs_entrance"] = $_POST["cs_entrance"];
		$obj_rev->coursedat[0]["cs_shisetsu"] = $_POST["cs_shisetsu"];
		$obj_rev->coursedat[0]["cs_textfee"] = $_POST["cs_textfee"];
		$obj_rev->coursedat[0]["cs_monthlyfee"] = $_POST["cs_monthlyfee"];
		$obj_rev->coursedat[0]["cs_age"] = $cs_age;
		$obj_rev->coursedat[0]["cs_level"] = $cs_level;
		$obj_rev->coursedat[0]["cs_purpose"] = $cs_purpose;
		$obj_rev->coursedat[0]["cs_subject"] = $_POST["cs_subject"];
		$obj_rev->coursedat[0]["cs_pr"] = $_POST["cs_pr"];
		$obj_rev->coursedat[0]["cs_tcid"] = $_POST["cs_tcid"];
		$obj_rev->coursedat[0]["cs_tcflg"] = $_POST["cs_tcflg"];

		$obj_rev->coursedat[0]["cs_img1_del_chk"] = $_POST["cs_img1_del_chk"];
		IF( is_uploaded_file($_FILES["cs_img1"]["tmp_name"]) ){
			$obj_rev->coursedat[0]["cs_imgorg1"] = $cs_imgorg1;
			$obj_rev->coursedat[0]["cs_img1"] = $cs_img1;
		}
		$obj_rev->coursedat[0]["cs_img2_del_chk"] = $_POST["cs_img2_del_chk"];
		IF( is_uploaded_file($_FILES["cs_img2"]["tmp_name"]) ){
			$obj_rev->coursedat[0]["cs_imgorg2"] = $cs_imgorg2;
			$obj_rev->coursedat[0]["cs_img2"] = $cs_img2;
		}
		$obj_rev->coursedat[0]["cs_img3_del_chk"] = $_POST["cs_img3_del_chk"];
		IF( is_uploaded_file($_FILES["cs_img3"]["tmp_name"]) ){
			$obj_rev->coursedat[0]["cs_imgorg3"] = $cs_imgorg3;
			$obj_rev->coursedat[0]["cs_img3"] = $cs_img3;
		}
		$obj_rev->coursedat[0]["cs_img4_del_chk"] = $_POST["cs_img4_del_chk"];
		IF( is_uploaded_file($_FILES["cs_img4"]["tmp_name"]) ){
			$obj_rev->coursedat[0]["cs_imgorg4"] = $cs_imgorg4;
			$obj_rev->coursedat[0]["cs_img4"] = $cs_img4;
		}
		$obj_rev->coursedat[0]["cs_img5_del_chk"] = $_POST["cs_img5_del_chk"];
		IF( is_uploaded_file($_FILES["cs_img5"]["tmp_name"]) ){
			$obj_rev->coursedat[0]["cs_imgorg5"] = $cs_imgorg5;
			$obj_rev->coursedat[0]["cs_img5"] = $cs_img5;
		}
		$obj_rev->coursedat[0]["cs_dispno"] =  $_POST['cs_dispno'];
		$obj_rev->coursedat[0]["cs_topflg"] =  $_POST['cs_topflg'];
		$obj_rev->coursedat[0]["cs_classform"] =  $cs_classform;
		$obj_rev->coursedat[0]["cs_adminid"] = NULL;
		$obj_rev->coursedat[0]["cs_upddate"] = $_POST["cs_upddate"];
		$suc = $obj_rev->basedb_UpdCourse();
		IF( $suc == "0" ){
			IF($_POST['cs_img1_del_chk']==1){
				IF( file_exists( $param_cs_img1_path.$_POST['cs_img1_lastupd'] ) && $_POST['cs_img1_lastupd'] != "" ){
					unlink( $param_cs_img1_path.$_POST['cs_img1_lastupd'] );
				}
			}
			IF($_POST['cs_img2_del_chk']==1){
				IF( file_exists( $param_cs_img2_path.$_POST['cs_img2_lastupd'] ) && $_POST['cs_img2_lastupd'] != "" ){
					unlink( $param_cs_img2_path.$_POST['cs_img2_lastupd'] );
				}
			}
			IF($_POST['cs_img3_del_chk']==1){
				IF( file_exists( $param_cs_img3_path.$_POST['cs_img3_lastupd'] ) && $_POST['cs_img3_lastupd'] != "" ){
					unlink( $param_cs_img3_path.$_POST['cs_img3_lastupd'] );
				}
			}
			IF($_POST['cs_img4_del_chk']==1){
				IF( file_exists( $param_cs_img4_path.$_POST['cs_img4_lastupd'] ) && $_POST['cs_img4_lastupd'] != "" ){
					unlink( $param_cs_img4_path.$_POST['cs_img4_lastupd'] );
				}
			}
			IF($_POST['cs_img5_del_chk']==1){
				IF( file_exists( $param_cs_img5_path.$_POST['cs_img5_lastupd'] ) && $_POST['cs_img5_lastupd'] != "" ){
					unlink( $param_cs_img5_path.$_POST['cs_img5_lastupd'] );
				}
			}
			// 画像保存・削除処理
			IF( is_uploaded_file( $_FILES["cs_img1"]["tmp_name"] ) ){
				// 一度画像を削除==>再度コピー
				IF( file_exists( $param_cs_img1_path.$_POST['cs_img1_lastupd'] ) && $_POST['cs_img1_lastupd'] != "" ){
					unlink( $param_cs_img1_path.$_POST['cs_img1_lastupd'] );
				}
				// 同じ名前で、UPLOADされたデータをコピー
				IF( is_uploaded_file($_FILES["cs_img1"]["tmp_name"]) && $obj_rev->coursedat[0]["cs_img1"] != "" ){
					move_uploaded_file( $_FILES["cs_img1"]["tmp_name"] , $param_cs_img1_path.$cs_img1 );
					chmod( $param_cs_img1_path.$cs_img1 , 0755 );
				}

				$obj_cs_1_rev = new ImageControl;
				$obj_cs_1_rev->max_w = 580;
				$obj_cs_1_rev->max_h = 580;
				$obj_cs_1_rev->origin_dir = $param_cs_img1_path;
				$obj_cs_1_rev->origin_img = $cs_img1;
				$obj_cs_1_rev->gd_ver = 1;
				list($resize_cs_1_rev,$imageType) = $obj_cs_1_rev->ImageResizeSave();
				if($resize_cs_1_rev == -1){
	                        	$obj_error->ViewErrMessage( "SYSTEM" , "ALL" , "blog_mnt.php" , $arrOther  );
	                       		exit;
				}

				$obj_cs_1_save_rev = new ImageControl;
				$obj_cs_1_save_rev->origin_dir = $param_cs_img1_path;
				$obj_cs_1_save_rev->origin_img = $cs_img1;
				$obj_cs_1_save_rev->imageResource = $resize_cs_1_rev;
				$cs_1_suc_rev = $obj_cs_1_save_rev->ImageSave($imageType);
				if($cs_1_suc_rev == -1){
	                        	$obj_error->ViewErrMessage( "SYSTEM" , "ALL" , "blog_mnt.php" , $arrOther  );
	                       		exit;
				}
			}
			
			IF( is_uploaded_file( $_FILES["cs_img2"]["tmp_name"] ) ){
				// 一度画像を削除==>再度コピー
				IF( file_exists( $param_cs_img2_path.$_POST['cs_img2_lastupd'] ) && $_POST['cs_img2_lastupd'] != "" ){
					unlink( $param_cs_img2_path.$_POST['cs_img2_lastupd'] );
				}
				// 同じ名前で、UPLOADされたデータをコピー
				IF( is_uploaded_file($_FILES["cs_img2"]["tmp_name"]) && $obj_rev->coursedat[0]["cs_img2"] != "" ){
					move_uploaded_file( $_FILES["cs_img2"]["tmp_name"] , $param_cs_img2_path.$cs_img2 );
					chmod( $param_cs_img2_path.$cs_img2 , 0755 );
				}

				$obj_cs_2_rev = new ImageControl;
				$obj_cs_2_rev->max_w = 580;
				$obj_cs_2_rev->max_h = 580;
				$obj_cs_2_rev->origin_dir = $param_cs_img2_path;
				$obj_cs_2_rev->origin_img = $cs_img2;
				$obj_cs_2_rev->gd_ver = 1;
				list($resize_cs_2_rev,$imageType) = $obj_cs_2_rev->ImageResizeSave();
				if($resize_cs_2_rev == -1){
	                        	$obj_error->ViewErrMessage( "SYSTEM" , "ALL" , "blog_mnt.php" , $arrOther  );
	                       		exit;
				}

				$obj_cs_2_save_rev = new ImageControl;
				$obj_cs_2_save_rev->origin_dir = $param_cs_img2_path;
				$obj_cs_2_save_rev->origin_img = $cs_img2;
				$obj_cs_2_save_rev->imageResource = $resize_cs_2_rev;
				$cs_2_suc_rev = $obj_cs_2_save_rev->ImageSave($imageType);
				if($cs_2_suc_rev == -1){
	                        	$obj_error->ViewErrMessage( "SYSTEM" , "ALL" , "blog_mnt.php" , $arrOther  );
	                       		exit;
				}
			}
			
			IF( is_uploaded_file( $_FILES["cs_img3"]["tmp_name"] ) ){
				// 一度画像を削除==>再度コピー
				IF( file_exists( $param_cs_img3_path.$_POST['cs_img3_lastupd'] ) && $_POST['cs_img3_lastupd'] != "" ){
					unlink( $param_cs_img3_path.$_POST['cs_img3_lastupd'] );
				}
				// 同じ名前で、UPLOADされたデータをコピー
				IF( is_uploaded_file($_FILES["cs_img3"]["tmp_name"]) && $obj_rev->coursedat[0]["cs_img3"] != "" ){
					move_uploaded_file( $_FILES["cs_img3"]["tmp_name"] , $param_cs_img3_path.$cs_img3);
					chmod( $param_cs_img3_path.$cs_img3 , 0755 );
				}

				$obj_cs_3_rev = new ImageControl;
				$obj_cs_3_rev->max_w = 580;
				$obj_cs_3_rev->max_h = 580;
				$obj_cs_3_rev->origin_dir = $param_cs_img3_path;
				$obj_cs_3_rev->origin_img = $cs_img3;
				$obj_cs_3_rev->gd_ver = 1;
				list($resize_cs_3_rev,$imageType) = $obj_cs_3_rev->ImageResizeSave();
				if($resize_cs_3_rev == -1){
	                        	$obj_error->ViewErrMessage( "SYSTEM" , "ALL" , "blog_mnt.php" , $arrOther  );
	                       		exit;
				}

				$obj_cs_3_save_rev = new ImageControl;
				$obj_cs_3_save_rev->origin_dir = $param_cs_img3_path;
				$obj_cs_3_save_rev->origin_img = $cs_img3;
				$obj_cs_3_save_rev->imageResource = $resize_cs_3_rev;
				$cs_3_suc_rev = $obj_cs_3_save_rev->ImageSave($imageType);
				if($cs_3_suc_rev == -1){
	                        	$obj_error->ViewErrMessage( "SYSTEM" , "ALL" , "blog_mnt.php" , $arrOther  );
	                       		exit;
				}
			}

			IF( is_uploaded_file( $_FILES["cs_img4"]["tmp_name"] ) ){
				// 一度画像を削除==>再度コピー
				IF( file_exists( $param_cs_img4_path.$_POST['cs_img4_lastupd'] ) && $_POST['cs_img4_lastupd'] != "" ){
					unlink( $param_cs_img4_path.$_POST['cs_img4_lastupd'] );
				}
				// 同じ名前で、UPLOADされたデータをコピー
				IF( is_uploaded_file($_FILES["cs_img4"]["tmp_name"]) && $obj_rev->coursedat[0]["cs_img4"] != "" ){
					move_uploaded_file( $_FILES["cs_img4"]["tmp_name"] , $param_cs_img4_path.$cs_img4);
					chmod( $param_cs_img4_path.$cs_img4 , 0755 );
				}

				$obj_cs_4_rev = new ImageControl;
				$obj_cs_4_rev->max_w = 580;
				$obj_cs_4_rev->max_h = 580;
				$obj_cs_4_rev->origin_dir = $param_cs_img4_path;
				$obj_cs_4_rev->origin_img = $cs_img4;
				$obj_cs_4_rev->gd_ver = 1;
				list($resize_cs_4_rev,$imageType) = $obj_cs_4_rev->ImageResizeSave();
				if($resize_cs_4_rev == -1){
	                        	$obj_error->ViewErrMessage( "SYSTEM" , "ALL" , "blog_mnt.php" , $arrOther  );
	                       		exit;
				}

				$obj_cs_4_save_rev = new ImageControl;
				$obj_cs_4_save_rev->origin_dir = $param_cs_img4_path;
				$obj_cs_4_save_rev->origin_img = $cs_img4;
				$obj_cs_4_save_rev->imageResource = $resize_cs_4_rev;
				$cs_4_suc_rev = $obj_cs_4_save_rev->ImageSave($imageType);
				if($cs_4_suc_rev == -1){
	                        	$obj_error->ViewErrMessage( "SYSTEM" , "ALL" , "blog_mnt.php" , $arrOther  );
	                       		exit;
				}
			}

			IF( is_uploaded_file( $_FILES["cs_img5"]["tmp_name"] ) ){
				// 一度画像を削除==>再度コピー
				IF( file_exists( $param_cs_img5_path.$_POST['cs_img5_lastupd'] ) && $_POST['cs_img5_lastupd'] != "" ){
					unlink( $param_cs_img5_path.$_POST['cs_img5_lastupd'] );
				}
				// 同じ名前で、UPLOADされたデータをコピー
				IF( is_uploaded_file($_FILES["cs_img5"]["tmp_name"]) && $obj_rev->coursedat[0]["cs_img5"] != "" ){
					move_uploaded_file( $_FILES["cs_img5"]["tmp_name"] , $param_cs_img5_path.$cs_img5);
					chmod( $param_cs_img5_path.$cs_img5 , 0755 );
				}

				$obj_cs_5_rev = new ImageControl;
				$obj_cs_5_rev->max_w = 580;
				$obj_cs_5_rev->max_h = 580;
				$obj_cs_5_rev->origin_dir = $param_cs_img5_path;
				$obj_cs_5_rev->origin_img = $cs_img5;
				$obj_cs_5_rev->gd_ver = 1;
				list($resize_cs_5_rev,$imageType) = $obj_cs_5_rev->ImageResizeSave();
				if($resize_cs_5_rev == -1){
	                        	$obj_error->ViewErrMessage( "SYSTEM" , "ALL" , "blog_mnt.php" , $arrOther  );
	                       		exit;
				}

				$obj_cs_5_save_rev = new ImageControl;
				$obj_cs_5_save_rev->origin_dir = $param_cs_img5_path;
				$obj_cs_5_save_rev->origin_img = $cs_img5;
				$obj_cs_5_save_rev->imageResource = $resize_cs_5_rev;
				$cs_5_suc_rev = $obj_cs_5_save_rev->ImageSave($imageType);
				if($cs_5_suc_rev == -1){
	                        	$obj_error->ViewErrMessage( "SYSTEM" , "ALL" , "blog_mnt.php" , $arrOther  );
	                       		exit;
				}
			}

		}
		switch( $suc ){
			case "-1":
				$arrOther['ath_comment'] .= $athComment;
                        	$arrOther["ath_comment"] = "<INPUT TYPE=\"hidden\" NAME=\"stpos\" VALUE=\"{$_POST['stpos']}\">";
                        	$obj_error->ViewErrMessage( "UPD_ERROR" , "ALL" , "course_mnt.php" , $arrOther );
                        	exit;
			case "1":
                        	$arrOther["ath_comment"] = "<INPUT TYPE=\"hidden\" NAME=\"stpos\" VALUE=\"{$_POST['stpos']}\">";
                        	$obj_error->ViewErrMessage( "DOUBLE_UPD" , "ALL" , "course_main.php" , $arrOther );
                        	exit;
		}
		$message = "見出し記事を修正しました。";
		break;

	case 'DEL':
		$obj_del = new basedb_CourseClassTblAccess;
		$obj_del->conn = $obj_conn->conn;
		$obj_del->coursedat[0]["cs_id"] = $_POST["cs_id"];
		$obj_del->coursedat[0]["cs_upddate"] = $_POST["cs_upddate"];
		$suc = $obj_del->basedb_DelCourse(0);
		if( $suc == -1 ){
                        $arrOther["ath_comment"] = "<INPUT TYPE=\"hidden\" NAME=\"stpos\" VALUE=\"{$_POST['stpos']}\">";
                        $obj_error->ViewErrMessage( "DEL_ERROR" , "ALL" , "course_main.php" , $arrOther );
                        exit;
		}
		IF( $suc == "0" ){
			// 画像を削除
			IF( file_exists( $param_cs_img1_path.$_POST['cs_img1_lastupd'] ) && $_POST['cs_img1_lastupd'] != ""){
				unlink( $param_cs_img1_path.$_POST['cs_img1_lastupd'] );
			}
			IF( file_exists( $param_cs_img2_path.$_POST['cs_img2_lastupd'] ) && $_POST['cs_img2_lastupd'] != ""){
				unlink( $param_cs_img2_path.$_POST['cs_img2_lastupd'] );
			}
			IF( file_exists( $param_cs_img3_path.$_POST['cs_img3_lastupd'] ) && $_POST['cs_img3_lastupd'] != ""){
				unlink( $param_cs_img3_path.$_POST['cs_img3_lastupd'] );
			}
			IF( file_exists( $param_cs_img4_path.$_POST['cs_img4_lastupd'] ) && $_POST['cs_img4_lastupd'] != ""){
				unlink( $param_cs_img4_path.$_POST['cs_img4_lastupd'] );
			}
			IF( file_exists( $param_cs_img5_path.$_POST['cs_img5_lastupd'] ) && $_POST['cs_img5_lastupd'] != ""){
				unlink( $param_cs_img5_path.$_POST['cs_img5_lastupd'] );
			}
		}
		$message = "指定された見出し記事を削除しました。";
		break;

}


//---------------------------
//会社・ブログ基本情報抽出
$obj_cl_blog = new viewdb_ClientClassTblAccess;
$obj_cl_blog->conn = $obj_conn->conn;
$obj_cl_blog->jyoken["cl_deldate"] = 1;
$obj_cl_blog->jyoken["sc_deldate"] = 1;
$obj_cl_blog->jyoken["cl_id"] = $_SESSION['_cl_id'];
list( $rssCnt , $rssTotal ) = $obj_cl_blog->viewdb_GetClient ( 1 , -1 );
if($rssCnt == -1){
	$obj_error->ViewErrMessage( "SYSTEM" , "ALL" , "blog_mnt.php" , $arrOther  );
	exit;
}

if( $obj_cl_blog->clientdat[0]["cl_dokuji_flg"] == 1 && $obj_cl_blog->clientdat[0]["cl_dokuji_domain"] != "" )
	// 独自ドメインの場合
	define( '_RSSBLOG_SITE_URL_BASE' , $obj_cl_blog->clientdat[0]["cl_dokuji_domain"] );
else
	define( '_RSSBLOG_SITE_URL_BASE' , _BLOG_SITE_URL_BASE.$obj_cl_blog->clientdat[0]['cl_urlcd']."/" );

//---------------------------
//スタッフ日記ＲＳＳ生成

//建物+部屋情報抽出
$obj_rss_dr_blog = new basedb_CourseClassTblAccess;
$obj_rss_dr_blog->conn = $obj_conn->conn;
$obj_rss_dr_blog->jyoken["cs_deldate"] = 1;
$obj_rss_dr_blog->jyoken["cs_clid"] = $_SESSION['_cl_id'];
$obj_rss_dr_blog->sort["cs_upddate"] = 2;				// 並び順 - 部屋情報最終更新日時で降順
list( $rssDiaryBlogCnt , $rssDiaryBlogTotal ) = $obj_rss_dr_blog->basedb_GetCourse ( 1 , -1 );
if($rssDiaryBlogCnt == -1){
	$obj_error->ViewErrMessage( "SYSTEM" , "ALL" , "blog_mnt.php" , $arrOther  );
	exit;
}

//各アイテム（スタッフ日記情報）XMLタグ生成
$rssDiaryItemValue = "";
$sitemapDiaryItemValue = "";
for($rssX=0;$rssX<$rssDiaryBlogCnt;$rssX++){
	// timestamp形をRFC822形式へ変更
	$bufDate1 = explode( "." , $obj_rss_dr_blog->coursedat[$rssX]["cs_upddate"] );	// マイクロ秒を切り捨てる
	$bufDate2 = explode( " " , $bufDate1[0] );			// 日付と時間を分ける
	$bufDate3_1 = explode( "-" , $bufDate2[0] );			// 年月日を分ける
	$bufDate3_2 = explode( ":" , $bufDate2[1] );			// 時分秒を分ける
	$bufTimeUnix = mktime( $bufDate3_2[0] , $bufDate3_2[1] , $bufDate3_2[2] , $bufDate3_1[1] , $bufDate3_1[2] , $bufDate3_1[0] );
	$strSemiUpdate = date( "r" , $bufTimeUnix );
	$cs_pr = str_replace( "\n" , "" , $obj_rss_dr_blog->coursedat[$rssX]['cs_pr'] );
	$sc_introduce = str_replace( "\n" , "" , $obj_cl_blog->clientdat[0]['sc_introduce'] );
	$cs_start = split(":",$obj_rss_dr_blog->coursedat[$rssX]['cs_start']);
	$cs_end = split(":",$obj_rss_dr_blog->coursedat[$rssX]['cs_end']);

	$rssDiaryItemValue .= "    <item>\n";
	$rssDiaryItemValue .= "      <title>".fn_escape_rss($obj_rss_dr_blog->coursedat[$rssX]['cs_title']."　".ltrim($cs_start[0],"0").":".$cs_start[2]."開始".ltrim($cs_end[0],"0").":".$cs_end[1]."終了　".$obj_rss_dr_blog->coursedat[$rssX]['cs_week'])."</title>\n";
	$rssDiaryItemValue .= "      <link>"._RSSBLOG_SITE_URL_BASE."course-detail-".$obj_rss_dr_blog->coursedat[$rssX]['cs_id']."/</link>\n";
	$rssDiaryItemValue .= "      <guid>"._RSSBLOG_SITE_URL_BASE."course-detail-".$obj_rss_dr_blog->coursedat[$rssX]['cs_id']."/</guid>\n";
	$rssDiaryItemValue .= "      <description>".fn_escape_rss($cs_pr)."</description>\n";
	$rssDiaryItemValue .= "      <pubDate>".$strSemiUpdate."</pubDate>\n";
	$rssDiaryItemValue .= "    </item>\n";

	$sitemapDiaryItemValue .= "    <url>\n";
	$sitemapDiaryItemValue .= "    <loc>"._RSSBLOG_SITE_URL_BASE."course-detail-".$obj_rss_dr_blog->coursedat[$rssX]['cs_id']."/</loc>\n";
	$sitemapDiaryItemValue .= "    <priority>1.0</priority>\n";
	$sitemapDiaryItemValue .= "    <changefreq>always</changefreq>\n";
	$sitemapDiaryItemValue .= "    <lastmod>".$strSemiUpdate."</lastmod>\n";
	$sitemapDiaryItemValue .= "    </url>\n";
}

//RSSファイル生成
//$rssDiaryItemValue = preg_replace('/(.*)〜(.*)/','\1~\2',$rssDiaryItemValue);
$diaryRssTmp = fopen(RSS_BLOG_PATH."rss_course_".$_SESSION['_cl_id'].".tmp","w");
if($diaryRssTmp===flase)exit("ファイルオープン失敗");
flock($diaryRssTmp,LOCK_EX);
$rssDiaryValue = "<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n";
$rssDiaryValue .= "<?xml-stylesheet type=\"text/css\" href=\"rss.css\"?>\n";
$rssDiaryValue .= "<rss version=\"2.0\">\n";
$rssDiaryValue .= "  <channel>\n";
$rssDiaryValue .= "    <title>".fn_escape_rss($obj_cl_blog->clientdat[0]['sc_toptitle'])."</title>\n";
$rssDiaryValue .= "    <link>"._RSSBLOG_SITE_URL_BASE."</link>\n";
$rssDiaryValue .= "    <copyright>".fn_escape_rss($obj_cl_blog->clientdat[0]['cl_jname'].$obj_cl_blog->clientdat[0]['cl_kname'])."</copyright>\n";
$rssDiaryValue .= "    <description>".fn_escape_rss($sc_introduce)."</description>\n";
$rssDiaryValue .= $rssDiaryItemValue;
$rssDiaryValue .= "  </channel>\n";
$rssDiaryValue .= "</rss>\n";
$rssDiaryValue = html_delete($rssDiaryValue);

$diarySitemapTmp = fopen(RSS_BLOG_PATH."sitemap_course_".$_SESSION['_cl_id'].".tmp","w");
if($diarySitemapTmp===flase)exit("ファイルオープン失敗");
flock($diarySitemapTmp,LOCK_EX);
$sitemapDiaryValue = "<?xml version=\"1.0\" encoding=\"UTF-8\" ?>\n";
$sitemapDiaryValue .= "<urlset xmlns=\"http://www.google.com/schemas/sitemap/0.84\">\n";
$sitemapDiaryValue .= $sitemapDiaryItemValue;
$sitemapDiaryValue .= "</urlset>\n";

asort( $rss );
$countrss = count($rss);
FOREACH( $rss as $key => $val ){
	$rssDiaryValue = str_replace($val,"",$rssDiaryValue);
}

$rssDiaryValue = mb_convert_encoding($rssDiaryValue,"UTF-8","EUC-JP");
fputs($diaryRssTmp,$rssDiaryValue);
flock($diaryRssTmp,LOCK_UN);
fclose($diaryRssTmp);
$cpCourseRss = copy(RSS_BLOG_PATH."rss_course_".$_SESSION['_cl_id'].".tmp", RSS_BLOG_PATH."rss_course_".$_SESSION['_cl_id'].".xml");
//$rnCourseRss = rename(RSS_BLOG_PATH."rss_course_".$_SESSION['_cl_id'].".tmp", RSS_BLOG_PATH."rss_course_".$_SESSION['_cl_id'].".xml");
if($cpCourseRss===flase)exit("ファイルコピー失敗");

$exCourseRss = file_exists(RSS_BLOG_PATH."rss_course_".$_SESSION['_cl_id'].".xml");
if($exCourseRss !== FALSE){
	$dlCourseRss = unlink(RSS_BLOG_PATH."rss_course_".$_SESSION['_cl_id'].".tmp");
	if($dlCourseRss===flase)exit("ファイル削除失敗");
}

$sitemapDiaryValue = mb_convert_encoding($sitemapDiaryValue,"UTF-8","EUC-JP");
fputs($diarySitemapTmp,$sitemapDiaryValue);
flock($diarySitemapTmp,LOCK_UN);
fclose($diarySitemapTmp);
$cpCourseSitemap = copy(RSS_BLOG_PATH."sitemap_course_".$_SESSION['_cl_id'].".tmp", RSS_BLOG_PATH."sitemap_course_".$_SESSION['_cl_id'].".xml");
//$rnCourseRss = rename(RSS_BLOG_PATH."sitemap_course_".$_SESSION['_cl_id'].".tmp", RSS_BLOG_PATH."sitemap_course_".$_SESSION['_cl_id'].".xml");
if($cpCourseSitemap===flase)exit("ファイルコピー失敗");

$exCourseSitemap = file_exists(RSS_BLOG_PATH."sitemap_course_".$_SESSION['_cl_id'].".xml");
if($exCourseSitemap !== FALSE){
	$dlCourseSitemap = unlink(RSS_BLOG_PATH."sitemap_course_".$_SESSION['_cl_id'].".tmp");
	if($dlCourseSitemap===flase)exit("ファイル削除失敗");
}

//---------------------------
//建物ＲＳＳ生成

//建物+部屋情報抽出
$obj_rev_rss = new viewdb_DiaryClassTblAccess;
$obj_rev_rss->conn = $obj_conn->conn;
$obj_rev_rss->jyoken["dr_deldate"] = 1;
$obj_rev_rss->jyoken["dr_stat"] = 1;				// 部屋状態が「空き」のもの
$obj_rev_rss->jyoken["dr_clid"] = $_SESSION['_cl_id'];
$obj_rev_rss->sort["dr_upddate"] = 2;				// 並び順 - 部屋情報最終更新日時で降順
list( $rssCnt , $rssTotal ) = $obj_rev_rss->viewdb_GetDiary ( 1 , -1 );
if($rssCnt == -1){
	$obj_error->ViewErrMessage( "SYSTEM" , "ALL" , "blog_mnt.php" , $arrOther  );
	exit;
}



//各アイテム（物件情報）XMLタグ生成
$rssCourseItemValue = "";
$rssDiaryItemValue = html_delete($rssDiaryItemValue);
$rssCourseItemValue .= $rssDiaryItemValue;

$sitemapCourseItemValue = "";
$sitemapDiaryItemValue = html_delete($sitemapDiaryItemValue);
$sitemapCourseItemValue .= $sitemapDiaryItemValue;
for($rssX=0;$rssX<$rssCnt;$rssX++){
	// timestamp形をRFC822形式へ変更
	$bufDate1 = explode( "." , $obj_rev_rss->diarydat[$rssX]["dr_upddate"] );	// マイクロ秒を切り捨てる
	$bufDate2 = explode( " " , $bufDate1[0] );			// 日付と時間を分ける
	$bufDate3_1 = explode( "-" , $bufDate2[0] );			// 年月日を分ける
	$bufDate3_2 = explode( ":" , $bufDate2[1] );			// 時分秒を分ける
	$bufTimeUnix = mktime( $bufDate3_2[0] , $bufDate3_2[1] , $bufDate3_2[2] , $bufDate3_1[1] , $bufDate3_1[2] , $bufDate3_1[0] );
	$strSemiUpdate = date( "r" , $bufTimeUnix );
	$cs_start = split(":",$obj_rev_rss->diarydat[$rssX]['cs_start']);
	$cs_end = split(":",$obj_rev_rss->diarydat[$rssX]['cs_end']);
	$dr_contents = str_replace( "\n" , "" , $obj_rev_rss->diarydat[$rssX]['dr_contents'] );
	$sc_introduce = str_replace( "\n" , "" , $obj_cl_blog->clientdat[0]['sc_introduce'] );

	$rssCourseItemValue .= "    <item>\n";
	$rssCourseItemValue .= "      <title>";
	$rssCourseItemValue .= fn_escape_rss($obj_rev_rss->diarydat[$rssX]['dr_title'])."</title>\n";

	$rssCourseItemValue .= "      <link>"._RSSBLOG_SITE_URL_BASE."diary-detail-".$obj_rev_rss->diarydat[$rssX]['dr_id']."/</link>\n";
//	$rssRoomUpdDate = substr($obj_rev_rss->coursedat[$rssX]['room_upd_date'],"20","7");
	$rssCourseItemValue .= "      <guid>"._RSSBLOG_SITE_URL_BASE."diary-detail-".$obj_rev_rss->diarydat[$rssX]['dr_id']."/</guid>\n";
	$rssCourseItemValue .= "      <description>".fn_escape_rss($dr_contents)."</description>\n";
	$rssCourseItemValue .= "      <pubDate>".$strSemiUpdate."</pubDate>\n";
	$rssCourseItemValue .= "    </item>\n";

	$sitemapCourseItemValue .= "    <url>\n";
	$sitemapCourseItemValue .= "    <loc>"._RSSBLOG_SITE_URL_BASE."diary-detail-".$obj_rev_rss->diarydat[$rssX]['dr_id']."/</loc>\n";
	$sitemapCourseItemValue .= "    <priority>1.0</priority>\n";
	$sitemapCourseItemValue .= "    <changefreq>always</changefreq>\n";
	$sitemapCourseItemValue .= "    <lastmod>".$strSemiUpdate."</lastmod>\n";
	$sitemapCourseItemValue .= "    </url>\n";
}

//RSSファイル生成
$courseRssTmp = fopen(RSS_BLOG_PATH."rss_".$_SESSION['_cl_id'].".tmp","w");
if($courseRssTmp===flase)exit("ファイルオープン失敗");
flock($courseRssTmp,LOCK_EX);
$rssCourseValue = "<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n";
$rssCourseValue .= "<?xml-stylesheet type=\"text/css\" href=\"rss.css\"?>\n";
$rssCourseValue .= "<rss version=\"2.0\">\n";
$rssCourseValue .= "  <channel>\n";
$rssCourseValue .= "    <title>".fn_escape_rss($obj_cl_blog->clientdat[0]['sc_toptitle'])."</title>\n";
$rssCourseValue .= "    <link>"._RSSBLOG_SITE_URL_BASE."</link>\n";
$rssCourseValue .= "    <copyright>".fn_escape_rss($obj_cl_blog->clientdat[0]['cl_jname'].$obj_cl_blog->clientdat[0]['cl_kname'])."</copyright>\n";
$rssCourseValue .= "    <description>".fn_escape_rss($sc_introduce)."</description>\n";
$rssCourseValue .= $rssCourseItemValue;
$rssCourseValue .= "  </channel>\n";
$rssCourseValue .= "</rss>\n";
$rssCourseValue = html_delete($rssCourseValue);

$courseSitemapTmp = fopen(RSS_BLOG_PATH."sitemap_".$_SESSION['_cl_id'].".tmp","w");
if($courseSitemapTmp===flase)exit("ファイルオープン失敗");
flock($courseSitemapTmp,LOCK_EX);
$sitemapCourseValue = "<?xml version=\"1.0\" encoding=\"UTF-8\" ?>\n";
$sitemapCourseValue .= "<urlset xmlns=\"http://www.google.com/schemas/sitemap/0.84\">\n";
$sitemapCourseValue .= $sitemapCourseItemValue;
$sitemapCourseValue .= "</urlset>\n";


asort( $rss );
$countrss = count($rss);
FOREACH( $rss as $key => $val ){
	$rssCourseValue = mb_ereg_replace($val,"",$rssCourseValue);
}


$rssCourseValue = mb_convert_encoding($rssCourseValue,"UTF-8","EUC-JP");
fputs($courseRssTmp,$rssCourseValue);
flock($courseRssTmp,LOCK_UN);
fclose($courseRssTmp);
$cpCourseRss = copy(RSS_BLOG_PATH."rss_".$_SESSION['_cl_id'].".tmp", RSS_BLOG_PATH."rss_".$_SESSION['_cl_id'].".xml");
//$rnCourseRss = rename(RSS_BLOG_PATH."rss_".$_SESSION['_cl_id'].".tmp", RSS_BLOG_PATH."rss_".$_SESSION['_cl_id'].".xml");
if($cpCourseRss===flase)exit("ファイルコピー失敗");

$exCourseRss = file_exists(RSS_BLOG_PATH."rss_".$_SESSION['_cl_id'].".xml");
if($exCourseRss !== FALSE){
	$dlCourseRss = unlink(RSS_BLOG_PATH."rss_".$_SESSION['_cl_id'].".tmp");
	if($dlCourseRss===flase)exit("ファイル削除失敗");
}

$sitemapCourseValue = mb_convert_encoding($sitemapCourseValue,"UTF-8","EUC-JP");
fputs($courseSitemapTmp,$sitemapCourseValue);
flock($courseSitemapTmp,LOCK_UN);
fclose($courseSitemapTmp);
$cpCourseSitemap = copy(RSS_BLOG_PATH."sitemap_".$_SESSION['_cl_id'].".tmp", RSS_BLOG_PATH."sitemap_".$_SESSION['_cl_id'].".xml");
//$rnCourseRss = rename(RSS_BLOG_PATH."sitemap_".$_SESSION['_cl_id'].".tmp", RSS_BLOG_PATH."sitemap_".$_SESSION['_cl_id'].".xml");
if($cpCourseSitemap===flase)exit("ファイルコピー失敗");

$exCourseSitemaps = file_exists(RSS_BLOG_PATH."sitemap_".$_SESSION['_cl_id'].".xml");
if($exCourseSitemaps !== FALSE){
	$dlCourseSitemap = unlink(RSS_BLOG_PATH."sitemap_".$_SESSION['_cl_id'].".tmp");
	if($dlCourseSitemap===flase)exit("ファイル削除失敗");
}


//---------------------------
//スタッフ日記ＲＳＳ生成


//建物+部屋情報抽出
$obj_rss_dr_blog = new viewdb_CourseClassTblAccess;
$obj_rss_dr_blog->conn = $obj_conn->conn;
$obj_rss_dr_blog->jyoken["cs_deldate"] = 1;
$obj_rss_dr_blog->sort["cs_upddate"] = 1;				// 並び順 - 部屋情報最終更新日時で降順
list( $rssDiaryBlogCnt , $rssDiaryBlogTotal ) = $obj_rss_dr_blog->viewdb_GetCourse ( 1 , 100 );
if($rssDiaryBlogCnt == -1){
	$obj_error->ViewErrMessage( "SYSTEM" , "ALL" , "blog_mnt.php" , $arrOther  );
	exit;
}

//各アイテム（スタッフ日記情報）XMLタグ生成
$rssDiaryItemValue = "";
$sitemapDiaryItemValue = "";
for($rssX=0;$rssX<$rssDiaryBlogCnt;$rssX++){
//	$obj_rss_dr_blogURLcode = new viewdb_ClientClassTblAccess;
//	$obj_rss_dr_blogURLcode->conn = $obj_conn->conn;
//	$obj_rss_dr_blogURLcode->jyoken["cl_id"] = $obj_rss_dr_blog->diarydat[$rssX]["dr_clid"];
//	list( $rssUcCnt , $rssUcTotal ) = $obj_rss_dr_blogURLcode->viewdb_GetClient ( 1 , -1 );

	// timestamp形をRFC822形式へ変更
	$bufDate1 = explode( "." , $obj_rss_dr_blog->coursedat[$rssX]["cs_upddate"] );	// マイクロ秒を切り捨てる
	$bufDate2 = explode( " " , $bufDate1[0] );			// 日付と時間を分ける
	$bufDate3_1 = explode( "-" , $bufDate2[0] );			// 年月日を分ける
	$bufDate3_2 = explode( ":" , $bufDate2[1] );			// 時分秒を分ける
	$bufTimeUnix = mktime( $bufDate3_2[0] , $bufDate3_2[1] , $bufDate3_2[2] , $bufDate3_1[1] , $bufDate3_1[2] , $bufDate3_1[0] );
	$strSemiUpdate = date( "r" , $bufTimeUnix );
	$cs_start = split(":",$obj_rss_dr_blog->coursedat[$rssX]['cs_start']);
	$cs_end = split(":",$obj_rss_dr_blog->coursedat[$rssX]['cs_end']);
	$cs_pr = str_replace( "\n" , "" , $obj_rss_dr_blog->coursedat[$rssX]['cs_pr'] );

	$rssDiaryItemValue .= "    <item>\n";
	$rssDiaryItemValue .= "      <title>".fn_escape_rss($obj_rss_dr_blog->coursedat[$rssX]['cs_title']."　".ltrim($cs_start[0],"0").":".$cs_start[2]."開始".ltrim($cs_end[0],"0").":".$cs_end[1]."終了　".$obj_rss_dr_blog->coursedat[$rssX]['cs_week'])."</title>\n";
	if( $obj_rss_dr_blog->coursedat[$rssX]["cl_dokuji_flg"] == 1 && $obj_rss_dr_blog->coursedat[$rssX]["cl_dokuji_domain"] != "" ) {
		// 独自ドメインの場合
		$rssDiaryItemValue .= "      <link>".$obj_rss_dr_blog->coursedat[$rssX]["cl_dokuji_domain"]."course-detail-".$obj_rss_dr_blog->coursedat[$rssX]['cs_id']."/</link>\n";
		$rssDiaryItemValue .= "      <guid>".$obj_rss_dr_blog->coursedat[$rssX]["cl_dokuji_domain"]."course-detail-".$obj_rss_dr_blog->coursedat[$rssX]['cs_id']."/</guid>\n";
	} else {
		$rssDiaryItemValue .= "      <link>"._BLOG_SITE_URL_BASE.$obj_rss_dr_blog->coursedat[$rssX]["cl_urlcd"]."/course-detail-".$obj_rss_dr_blog->coursedat[$rssX]['cs_id']."/</link>\n";
		$rssDiaryItemValue .= "      <guid>"._BLOG_SITE_URL_BASE.$obj_rss_dr_blog->coursedat[$rssX]["cl_urlcd"]."/course-detail-".$obj_rss_dr_blog->coursedat[$rssX]['cs_id']."/</guid>\n";
	}
	$rssDiaryItemValue .= "      <description>".fn_escape_rss($cs_pr)."</description>\n";
	$rssDiaryItemValue .= "      <pubDate>".$strSemiUpdate."</pubDate>\n";
	$rssDiaryItemValue .= "    </item>\n";

	$sitemapDiaryItemValue .= "    <url>\n";
	if( $obj_rss_dr_blog->coursedat[$rssX]["cl_dokuji_flg"] == 1 && $obj_rss_dr_blog->coursedat[$rssX]["cl_dokuji_domain"] != "" ) {
		// 独自ドメインの場合
		$sitemapDiaryItemValue .= "    <loc>".$obj_rss_dr_blog->coursedat[$rssX]["cl_dokuji_domain"]."course-detail-".$obj_rss_dr_blog->coursedat[$rssX]['cs_id']."/</loc>\n";
	} else {
		$sitemapDiaryItemValue .= "    <loc>"._BLOG_SITE_URL_BASE.$obj_rss_dr_blog->coursedat[$rssX]["cl_urlcd"]."/course-detail-".$obj_rss_dr_blog->coursedat[$rssX]['cs_id']."/</loc>\n";
	}
	$sitemapDiaryItemValue .= "    <priority>1.0</priority>\n";
	$sitemapDiaryItemValue .= "    <changefreq>always</changefreq>\n";
	$sitemapDiaryItemValue .= "    <lastmod>".$strSemiUpdate."</lastmod>\n";
	$sitemapDiaryItemValue .= "    </url>\n";
}

//RSSファイル生成
//$rssDiaryItemValue = preg_replace('/(.*)〜(.*)/','\1~\2',$rssDiaryItemValue);
$diaryRssTmp = fopen(RSS_PORTAL_PATH."rss_course.tmp","w");
if($diaryRssTmp===false)exit("ファイルオープン失敗");
flock($diaryRssTmp,LOCK_EX);
$rssDiaryValue = "<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n";
$rssDiaryValue .= "<?xml-stylesheet type=\"text/css\" href=\"rss.css\"?>\n";
$rssDiaryValue .= "<rss version=\"2.0\">\n";
$rssDiaryValue .= "  <channel>\n";
$rssDiaryValue .= "    <title>塾や教室の検索ならEdyblo[エディブロ]全国の教室がじっくり探せる塾・教室情報検索サイト！</title>\n";
$rssDiaryValue .= "    <link>"._BLOG_SITE_URL_BASE."</link>\n";
$rssDiaryValue .= "    <copyright>powered by SLASH</copyright>\n";
$rssDiaryValue .= "    <description></description>\n";
$rssDiaryValue .= $rssDiaryItemValue;
$rssDiaryValue .= "  </channel>\n";
$rssDiaryValue .= "</rss>\n";
$rssDiaryValue = html_delete($rssDiaryValue);

$diarySitemapTmp = fopen(RSS_PORTAL_PATH."sitemap_course.tmp","w");
if($diarySitemapTmp===false)exit("ファイルオープン失敗");
flock($diarySitemapTmp,LOCK_EX);
$sitemapDiaryValue = "<?xml version=\"1.0\" encoding=\"UTF-8\" ?>\n";
$sitemapDiaryValue .= "<urlset xmlns=\"http://www.google.com/schemas/sitemap/0.84\">\n";
$sitemapDiaryValue .= $sitemapDiaryItemValue;
$sitemapDiaryValue .= "</urlset>\n";

asort( $rss );
$countrss = count($rss);
FOREACH( $rss as $key => $val ){
	$rssDiaryValue = mb_ereg_replace($val,"",$rssDiaryValue);
}

$rssDiaryValue = mb_convert_encoding($rssDiaryValue,"UTF-8","EUC-JP");
fputs($diaryRssTmp,$rssDiaryValue);
flock($diaryRssTmp,LOCK_UN);
fclose($diaryRssTmp);
$cpCourseRss = copy(RSS_PORTAL_PATH."rss_course.tmp", RSS_PORTAL_PATH."rss_course.xml");
//$rnCourseRss = rename(RSS_PORTAL_PATH."rss_course.tmp", RSS_PORTAL_PATH."rss_course.xml");
if($cpCourseRss===false)exit("ファイルコピー失敗");

$exCourseRss = file_exists(RSS_PORTAL_PATH."rss_course.xml");
if($exCourseRss !== FALSE){
	$dlCourseRss = unlink(RSS_PORTAL_PATH."rss_course.tmp");
	if($dlCourseRss===false)exit("ファイル削除失敗");
}

$sitemapDiaryValue = mb_convert_encoding($sitemapDiaryValue,"UTF-8","EUC-JP");
fputs($diarySitemapTmp,$sitemapDiaryValue);
flock($diarySitemapTmp,LOCK_UN);
fclose($diarySitemapTmp);
$cpCoursePSitemap = copy(RSS_PORTAL_PATH."sitemap_course.tmp", RSS_PORTAL_PATH."sitemap_course.xml");
//$rnCourseRss = rename(RSS_PORTAL_PATH."sitemap_course.tmp", RSS_PORTAL_PATH."sitemap_course.xml");
if($cpCoursePSitemap===false)exit("ファイルコピー失敗");

$exCoursePSitemap = file_exists(RSS_PORTAL_PATH."sitemap_course.xml");
if($exCoursePSitemap !== FALSE){
	$dlCoursePSitemap = unlink(RSS_PORTAL_PATH."sitemap_course.tmp");
	if($dlCoursePSitemap===false)exit("ファイル削除失敗");
}


//---------------------------
//建物ＲＳＳ生成

//建物+部屋情報抽出
$obj_rss_buidP = new viewdb_DiaryClassTblAccess;
$obj_rss_buidP->conn = $obj_conn->conn;
$obj_rss_buidP->jyoken["dr_deldate"] = 1;
$obj_rss_buidP->jyoken["dr_stat"] = 1;				// 部屋状態が「空き」のもの
$obj_rss_buidP->sort["cs_upddate"] = 2;				// 並び順 - 部屋情報最終更新日時で降順
list( $rssCnt , $rssTotal ) = $obj_rss_buidP->viewdb_GetDiary ( 1 , 100 );
if($obj_rss_buidP == -1){
	$obj_error->ViewErrMessage( "SYSTEM" , "ALL" , "blog_mnt.php" , $arrOther  );
	exit;
}

//各アイテム（物件情報）XMLタグ生成
$rssCourseItemValue = "";
$rssCourseItemValue .= $rssDiaryItemValue;

$sitemapCourseItemValue = "";
$sitemapCourseItemValue .= $sitemapDiaryItemValue;
for($rssX=0;$rssX<$rssCnt;$rssX++){
//	$obj_rss_buidPURLcode = new viewdb_ClientClassTblAccess;
//	$obj_rss_buidPURLcode->conn = $obj_conn->conn;
//	$obj_rss_buidPURLcode->jyoken["cl_id"] = $obj_rss_buidP->coursedat[$rssX]["cs_cl_id"];
//	list( $rssUcCnt , $rssUcTotal ) = $obj_rss_buidPURLcode->viewdb_GetClient ( 1 , -1 );

	// timestamp形をRFC822形式へ変更
	$bufDate1 = explode( "." , $obj_rss_buidP->diarydat[$rssX]["dr_upddate"] );	// マイクロ秒を切り捨てる
	$bufDate2 = explode( " " , $bufDate1[0] );			// 日付と時間を分ける
	$bufDate3_1 = explode( "-" , $bufDate2[0] );			// 年月日を分ける
	$bufDate3_2 = explode( ":" , $bufDate2[1] );			// 時分秒を分ける
	$bufTimeUnix = mktime( $bufDate3_2[0] , $bufDate3_2[1] , $bufDate3_2[2] , $bufDate3_1[1] , $bufDate3_1[2] , $bufDate3_1[0] );
	$strSemiUpdate = date( "r" , $bufTimeUnix );
	$dr_contents = str_replace( "\n" , "" , $obj_rss_buidP->diarydat[$rssX]['dr_contents'] );

	$rssCourseItemValue .= "    <item>\n";
	$rssCourseItemValue .= "      <title>";
	$rssCourseItemValue .= fn_escape_rss($obj_rss_buidP->diarydat[$rssX]['dr_title'])."</title>\n";
	if( $obj_rss_buidP->diarydat[$rssX]["cl_dokuji_flg"] == 1 && $obj_rss_buidP->diarydat[$rssX]["cl_dokuji_domain"] != "" ) {
		// 独自ドメインの場合
		$rssCourseItemValue .= "      <link>".$obj_rss_buidP->diarydat[$rssX]["cl_dokuji_domain"]."blog-".$obj_rss_buidP->diarydat[$rssX]['dr_id']."/</link>\n";
		$rssCourseItemValue .= "      <guid>".$obj_rss_buidP->diarydat[$rssX]["cl_dokuji_domain"]."blog-".$obj_rss_buidP->diarydat[$rssX]['dr_id']."/</guid>\n";
	} else {
		$rssCourseItemValue .= "      <link>"._BLOG_SITE_URL_BASE.$obj_rss_buidP->diarydat[$rssX]["cl_urlcd"]."/blog-".$obj_rss_buidP->diarydat[$rssX]['dr_id']."/</link>\n";
		$rssCourseItemValue .= "      <guid>"._BLOG_SITE_URL_BASE.$obj_rss_buidP->diarydat[$rssX]["cl_urlcd"]."/blog-".$obj_rss_buidP->diarydat[$rssX]['dr_id']."/</guid>\n";
	}
	$rssCourseItemValue .= "      <description>".fn_escape_rss($dr_contents)."</description>\n";
	$rssCourseItemValue .= "      <pubDate>".$strSemiUpdate."</pubDate>\n";
	$rssCourseItemValue .= "    </item>\n";

	$sitemapCourseItemValue .= "    <url>\n";
	if( $obj_rss_buidP->diarydat[$rssX]["cl_dokuji_flg"] == 1 && $obj_rss_buidP->diarydat[$rssX]["cl_dokuji_domain"] != "" ) {
		// 独自ドメインの場合
		$sitemapCourseItemValue .= "    <loc>".$obj_rss_buidP->diarydat[$rssX]["cl_dokuji_domain"]."blog-".$obj_rss_buidP->diarydat[$rssX]['dr_id']."/</loc>\n";
	} else {
		$sitemapCourseItemValue .= "    <loc>"._BLOG_SITE_URL_BASE.$obj_rss_buidP->diarydat[$rssX]["cl_urlcd"]."/blog-".$obj_rss_buidP->diarydat[$rssX]['dr_id']."/</loc>\n";
	}
	$sitemapCourseItemValue .= "    <priority>1.0</priority>\n";
	$sitemapCourseItemValue .= "    <changefreq>always</changefreq>\n";
	$sitemapCourseItemValue .= "    <lastmod>".$strSemiUpdate."</lastmod>\n";
	$sitemapCourseItemValue .= "    </url>\n";
}

//RSSファイル生成
$coursePRssTmp = fopen(RSS_PORTAL_PATH."rss.tmp","w");
if($coursePRssTmp===flase)exit("ファイルオープン失敗");
flock($coursePRssTmp,LOCK_EX);
$rssCourseValue = "<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n";
$rssCourseValue .= "<?xml-stylesheet type=\"text/css\" href=\"rss.css\"?>\n";
$rssCourseValue .= "<rss version=\"2.0\">\n";
$rssCourseValue .= "  <channel>\n";
$rssCourseValue .= "    <title>塾や教室の検索ならEdyblo[エディブロ]全国の教室がじっくり探せる塾・教室情報検索サイト！</title>\n";
$rssCourseValue .= "    <link>"._BLOG_SITE_URL_BASE."</link>\n";
$rssCourseValue .= "    <copyright>powered by SLASH</copyright>\n";
$rssCourseValue .= "    <description></description>\n";
$rssCourseValue .= $rssCourseItemValue;
$rssCourseValue .= "  </channel>\n";
$rssCourseValue .= "</rss>\n";

$coursePSitemapTmp = fopen(RSS_PORTAL_PATH."sitemap.tmp","w");
if($coursePSitemapTmp===flase)exit("ファイルオープン失敗");
flock($coursePSitemapTmp,LOCK_EX);
$sitemapCourseValue = "<?xml version=\"1.0\" encoding=\"UTF-8\" ?>\n";
$sitemapCourseValue .= "<urlset xmlns=\"http://www.google.com/schemas/sitemap/0.84\">\n";
$sitemapCourseValue .= $sitemapCourseItemValue;
$sitemapCourseValue .= "</urlset>\n";

asort( $rss );
$countrss = count($rss);
FOREACH( $rss as $key => $val ){
	$rssCourseValue = mb_ereg_replace($val,"",$rssCourseValue);
}

$rssCourseValue = mb_convert_encoding($rssCourseValue,"UTF-8","EUC-JP");
fputs($coursePRssTmp,$rssCourseValue);
flock($coursePRssTmp,LOCK_UN);
fclose($coursePRssTmp);
$cpCourseRss = copy(RSS_PORTAL_PATH."rss.tmp", RSS_PORTAL_PATH."rss.xml");
if($cpCourseRss===false)exit("ファイルコピー失敗");

$exCourseRss = file_exists(RSS_PORTAL_PATH."rss.xml");
if($exCourseRss !== FALSE){
	$dlCourseRss = unlink(RSS_PORTAL_PATH."rss.tmp");
	if($dlCourseRss===flase)exit("ファイル削除失敗");
}

$sitemapCourseValue = mb_convert_encoding($sitemapCourseValue,"UTF-8","EUC-JP");
fputs($coursePSitemapTmp,$sitemapCourseValue);
flock($coursePSitemapTmp,LOCK_UN);
fclose($coursePSitemapTmp);
$cpBuilSitemap = copy(RSS_PORTAL_PATH."sitemap.tmp", RSS_PORTAL_PATH."sitemap.xml");
if($cpBuilSitemap===false)exit("ファイルコピー失敗");

$exCourseSitemap = file_exists(RSS_PORTAL_PATH."sitemap.xml");
if($exCourseSitemap !== FALSE){
	$dlCourseSitemap = unlink(RSS_PORTAL_PATH."sitemap.tmp");
	if($dlCourseSitemap===flase)exit("ファイル削除失敗");
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
    <LINK rel="stylesheet" href="../share/css/course.css" type="text/css" />
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
      <form name="form1" action="course_main.php" method="POST"> 
        <INPUT type="hidden" name="stpos" value="<?=$_POST['stpos']?>" />
        <input type="submit" value=" 戻 る " class="btn" />
      </form>
    </div>
  </body>
</html>
