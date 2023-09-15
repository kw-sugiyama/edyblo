<?


/******************************************************************************
<< 不動産ブログ　Ver.1.O.0 >>
	Name: dr_upd.php
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
require_once ( SYS_PATH."dbif/basedb_DiaryClass.php" );
require_once ( SYS_PATH."dbif/basedb_ClientClass.php" );
require_once ( SYS_PATH."dbif/basedb_CourseClass.php" );
require_once ( SYS_PATH."dbif/viewdb_DiaryClass.php" );
require_once ( SYS_PATH."dbif/viewdb_BuildClass.php" );
require_once ( SYS_PATH."dbif/viewdb_ClientClass.php" );
require_once ( SYS_PATH."dbif/viewdb_CourseClass.php" );
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
	$val = stripslashes(htmlspecialchars($val));
        $athComment .= "<INPUT type=\"hidden\" name=\"{$key}\" value=\"{$val}\">\n";
}

SWITCH( $_POST["mode"] ){
	case "NEW":
		// 画像1
                if( filesize($_FILES["dr_img1"]["tmp_name"]) > (1024*1024*2) ){
			$arrOther['ath_comment'] .= $athComment;
                        $obj_error->ViewErrMessage( "FILE_SIZE" , "ALL" , "diary_mnt.php" , $arrOther );
                        exit;
                }
                if( filesize($_FILES["dr_img2"]["tmp_name"]) > (1024*1024*2) ){
			$arrOther['ath_comment'] .= $athComment;
                        $obj_error->ViewErrMessage( "FILE_SIZE" , "ALL" , "diary_mnt.php" , $arrOther );
                        exit;
                }
                if( filesize($_FILES["dr_img3"]["tmp_name"]) > (1024*1024*2) ){
			$arrOther['ath_comment'] .= $athComment;
                        $obj_error->ViewErrMessage( "FILE_SIZE" , "ALL" , "diary_mnt.php" , $arrOther );
                        exit;
                }
                if( filesize($_FILES["dr_img4"]["tmp_name"]) > (1024*1024*2) ){
			$arrOther['ath_comment'] .= $athComment;
                        $obj_error->ViewErrMessage( "FILE_SIZE" , "ALL" , "diary_mnt.php" , $arrOther );
                        exit;
                }
		// 画像1
		IF( is_uploaded_file( $_FILES["dr_img1"]["tmp_name"] ) ){
			$imageInfo = @getimagesize( $_FILES["dr_img1"]["tmp_name"] );
			IF( @getimagesize( $_FILES["dr_img1"]["tmp_name"] ) === FALSE || ( $imageInfo[2] != 1 && $imageInfo[2] != 2 ) ){
				$arrOther['ath_comment'] .= $athComment;
                        	$obj_error->ViewErrMessage( "NOT_IMG" , "ALL" , "diary_mnt.php" , $arrOther );
                        	exit;
			}
		$kaku1 = split("\.",$_FILES["dr_img1"]["name"]);
		$dr_imgorg1 = $kaku1[0].".".$kaku1[1];
		$dr_img1 = "diary_".$_SESSION["_cl_id"]."_/_1.".$kaku1[1];
		}

		// 画像2
		IF( is_uploaded_file( $_FILES["dr_img2"]["tmp_name"] ) ){
			$imageInfo = @getimagesize( $_FILES["dr_img2"]["tmp_name"] );
			IF( @getimagesize( $_FILES["dr_img2"]["tmp_name"] ) === FALSE || ( $imageInfo[2] != 1 && $imageInfo[2] != 2 ) ){
				$arrOther['ath_comment'] .= $athComment;
                        	$obj_error->ViewErrMessage( "NOT_IMG" , "ALL" , "diary_mnt.php" , $arrOther );
                        	exit;
			}
		$kaku2 = split("\.",$_FILES["dr_img2"]["name"]);
		$dr_imgorg2 = $kaku2[0].".".$kaku2[1];
		$dr_img2 = "diary_".$_SESSION["_cl_id"]."_/_2.".$kaku2[1];
		}

		// 画像3
		IF( is_uploaded_file( $_FILES["dr_img3"]["tmp_name"] ) ){
			$imageInfo = @getimagesize( $_FILES["dr_img3"]["tmp_name"] );
			IF( @getimagesize( $_FILES["dr_img3"]["tmp_name"] ) === FALSE || ( $imageInfo[2] != 1 && $imageInfo[2] != 2 ) ){
				$arrOther['ath_comment'] .= $athComment;
                        	$obj_error->ViewErrMessage( "NOT_IMG" , "ALL" , "diary_mnt.php" , $arrOther );
                        	exit;
			}
		$kaku3 = split("\.",$_FILES["dr_img3"]["name"]);
		$dr_imgorg3 = $kaku3[0].".".$kaku3[1];
		$dr_img3 = "diary_".$_SESSION["_cl_id"]."_/_3.".$kaku3[1];
		}

		// 画像4
		IF( is_uploaded_file( $_FILES["dr_img4"]["tmp_name"] ) ){
			$imageInfo = @getimagesize( $_FILES["dr_img4"]["tmp_name"] );
			IF( @getimagesize( $_FILES["dr_img4"]["tmp_name"] ) === FALSE || ( $imageInfo[2] != 1 && $imageInfo[2] != 2 ) ){
				$arrOther['ath_comment'] .= $athComment;
                        	$obj_error->ViewErrMessage( "NOT_IMG" , "ALL" , "diary_mnt.php" , $arrOther );
                        	exit;
			}
		$kaku4 = split("\.",$_FILES["dr_img4"]["name"]);
		$dr_imgorg4 = $kaku4[0].".".$kaku4[1];
		$dr_img4 = "diary_".$_SESSION["_cl_id"]."_/_4.".$kaku4[1];
		}

		$obj_new = new basedb_DiaryClassTblAccess;
		$obj_new->conn = $obj_conn->conn;
		$obj_new->diarydat[0]["dr_clid"] = $_SESSION["_cl_id"];
		$obj_new->diarydat[0]["dr_cgid"] = $_POST["dr_cgid"];
		$obj_new->diarydat[0]["dr_tcid"] = $_POST["dr_tcid"];
		$obj_new->diarydat[0]["dr_title"] = $_POST["dr_title"];
		$obj_new->diarydat[0]["dr_contents"] = $_POST["dr_contents"];
		IF( is_uploaded_file($_FILES["dr_img1"]["tmp_name"]) ){
			$obj_new->diarydat[0]["dr_imgorg1"] = $dr_imgorg1;
			$obj_new->diarydat[0]["dr_img1"] = $dr_img1;
		}
		IF( is_uploaded_file($_FILES["dr_img2"]["tmp_name"]) ){
			$obj_new->diarydat[0]["dr_imgorg2"] = $dr_imgorg2;
			$obj_new->diarydat[0]["dr_img2"] = $dr_img2;
		}
		IF( is_uploaded_file($_FILES["dr_img3"]["tmp_name"]) ){
			$obj_new->diarydat[0]["dr_imgorg3"] = $dr_imgorg3;
			$obj_new->diarydat[0]["dr_img3"] = $dr_img3;
		}
		IF( is_uploaded_file($_FILES["dr_img4"]["tmp_name"]) ){
			$obj_new->diarydat[0]["dr_imgorg4"] = $dr_imgorg4;
			$obj_new->diarydat[0]["dr_img4"] = $dr_img4;
		}
		IF( $_POST['dr_map'] != "" ){
			$obj_new->diarydat[0]["dr_map"] = $_POST['dr_map'];
		}
		$obj_new->diarydat[0]["dr_ido"] = $_POST['dr_ido'];
		$obj_new->diarydat[0]["dr_keido"] = $_POST['dr_keido'];
		$obj_new->diarydat[0]["dr_zoom"] = $_POST['dr_zoom'];
		$obj_new->diarydat[0]["dr_adminid"] = NULL;
		$obj_new->diarydat[0]["dr_upddate"] = $_POST["dr_upddate"];
		$suc = $obj_new->basedb_InsDiary();
		IF( $suc == "0" ){


			// 画像保存・削除処理
			IF( is_uploaded_file( $_FILES["dr_img1"]["tmp_name"] ) ){
				// 一度画像を削除==>再度コピー
				IF( file_exists( $param_dr_img1_path.$_POST['dr_img1_lastupd'] ) && $_POST['dr_img1_lastupd'] != "" ){
					unlink( $param_dr_img1_path.$_POST['dr_img1_lastupd'] );
				}
				// 同じ名前で、UPLOADされたデータをコピー
				IF( is_uploaded_file($_FILES["dr_img1"]["tmp_name"]) && $obj_new->diarydat[0]["dr_img1"] != "" ){
					move_uploaded_file( $_FILES["dr_img1"]["tmp_name"] , $param_dr_img1_path.$obj_new->diarydat[0]["dr_img1"] );
					chmod( $param_dr_img1_path.$obj_new->diarydat[0]["dr_img1"] , 0755 );
				}

				$obj_dr_1_new = new ImageControl;
				$obj_dr_1_new->max_w = 580;
				$obj_dr_1_new->max_h = 580;
				$obj_dr_1_new->origin_dir = $param_dr_img1_path;
				$obj_dr_1_new->origin_img = $obj_new->diarydat[0]["dr_img1"];
				$obj_dr_1_new->gd_ver = 1;
				list($resize_dr_1_new,$imageType) = $obj_dr_1_new->ImageResizeSave();
				if($resize_dr_1_new == -1){
	                        	$obj_error->ViewErrMessage( "SYSTEM" , "ALL" , "blog_mnt.php" , $arrOther  );
	                       		exit;
				}

				$obj_other_1_save_new = new ImageControl;
				$obj_other_1_save_new->origin_dir = $param_dr_img1_path;
				$obj_other_1_save_new->origin_img = $obj_new->diarydat[0]["dr_img1"];
				$obj_other_1_save_new->imageResource = $resize_dr_1_new;
				$dr_1_suc_new = $obj_other_1_save_new->ImageSave($imageType);
				if($dr_1_suc_new == -1){
	                        	$obj_error->ViewErrMessage( "SYSTEM" , "ALL" , "blog_mnt.php" , $arrOther  );
	                       		exit;
				}
			}
			
			IF( is_uploaded_file( $_FILES["dr_img2"]["tmp_name"] ) ){
				// 一度画像を削除==>再度コピー
				IF( file_exists( $param_dr_img2_path.$_POST['dr_img2_lastupd'] ) && $_POST['dr_img2_lastupd'] != "" ){
					unlink( $param_dr_img2_path.$_POST['dr_img2_lastupd'] );
				}
				// 同じ名前で、UPLOADされたデータをコピー
				IF( is_uploaded_file($_FILES["dr_img2"]["tmp_name"]) && $obj_new->diarydat[0]["dr_img2"] != "" ){
					move_uploaded_file( $_FILES["dr_img2"]["tmp_name"] , $param_dr_img2_path.$obj_new->diarydat[0]["dr_img2"] );
					chmod( $param_dr_img2_path.$obj_new->diarydat[0]["dr_img2"] , 0755 );
				}

				$obj_dr_2_new = new ImageControl;
				$obj_dr_2_new->max_w = 580;
				$obj_dr_2_new->max_h = 580;
				$obj_dr_2_new->origin_dir = $param_dr_img2_path;
				$obj_dr_2_new->origin_img = $obj_new->diarydat[0]["dr_img2"];
				$obj_dr_2_new->gd_ver = 1;
				list($resize_dr_2_new,$imageType) = $obj_dr_2_new->ImageResizeSave();
				if($resize_dr_2_new == -1){
	                        	$obj_error->ViewErrMessage( "SYSTEM" , "ALL" , "blog_mnt.php" , $arrOther  );
	                       		exit;
				}

				$obj_other_2_save_new = new ImageControl;
				$obj_other_2_save_new->origin_dir = $param_dr_img2_path;
				$obj_other_2_save_new->origin_img = $obj_new->diarydat[0]["dr_img2"];
				$obj_other_2_save_new->imageResource = $resize_dr_2_new;
				$dr_2_suc_new = $obj_other_2_save_new->ImageSave($imageType);
				if($dr_2_suc_new == -1){
	                        	$obj_error->ViewErrMessage( "SYSTEM" , "ALL" , "blog_mnt.php" , $arrOther  );
	                       		exit;
				}
			}
			
			IF( is_uploaded_file( $_FILES["dr_img3"]["tmp_name"] ) ){
				// 一度画像を削除==>再度コピー
				IF( file_exists( $param_dr_img3_path.$_POST['dr_img3_lastupd'] ) && $_POST['dr_img3_lastupd'] != "" ){
					unlink( $param_dr_img3_path.$_POST['dr_img3_lastupd'] );
				}
				// 同じ名前で、UPLOADされたデータをコピー
				IF( is_uploaded_file($_FILES["dr_img3"]["tmp_name"]) && $obj_new->diarydat[0]["dr_img3"] != "" ){
					move_uploaded_file( $_FILES["dr_img3"]["tmp_name"] , $param_dr_img3_path.$obj_new->diarydat[0]["dr_img3"]);
					chmod( $param_dr_img3_path.$obj_new->diarydat[0]["dr_img3"] , 0755 );
				}

				$obj_dr_3_new = new ImageControl;
				$obj_dr_3_new->max_w = 580;
				$obj_dr_3_new->max_h = 580;
				$obj_dr_3_new->origin_dir = $param_dr_img3_path;
				$obj_dr_3_new->origin_img = $obj_new->diarydat[0]["dr_img3"];
				$obj_dr_3_new->gd_ver = 1;
				list($resize_dr_3_new,$imageType) = $obj_dr_3_new->ImageResizeSave();
				if($resize_dr_3_new == -1){
	                        	$obj_error->ViewErrMessage( "SYSTEM" , "ALL" , "blog_mnt.php" , $arrOther  );
	                       		exit;
				}

				$obj_other_3_save_new = new ImageControl;
				$obj_other_3_save_new->origin_dir = $param_dr_img3_path;
				$obj_other_3_save_new->origin_img = $obj_new->diarydat[0]["dr_img3"];
				$obj_other_3_save_new->imageResource = $resize_dr_3_new;
				$dr_3_suc_new = $obj_other_3_save_new->ImageSave($imageType);
				if($dr_3_suc_new == -1){
	                        	$obj_error->ViewErrMessage( "SYSTEM" , "ALL" , "blog_mnt.php" , $arrOther  );
	                       		exit;
				}
			}

			IF( is_uploaded_file( $_FILES["dr_img4"]["tmp_name"] ) ){
				// 一度画像を削除==>再度コピー
				IF( file_exists( $param_dr_img4_path.$_POST['dr_img4_lastupd'] ) && $_POST['dr_img4_lastupd'] != "" ){
					unlink( $param_dr_img4_path.$_POST['dr_img4_lastupd'] );
				}
				// 同じ名前で、UPLOADされたデータをコピー
				IF( is_uploaded_file($_FILES["dr_img4"]["tmp_name"]) && $obj_new->diarydat[0]["dr_img4"] != "" ){
					move_uploaded_file( $_FILES["dr_img4"]["tmp_name"] , $param_dr_img4_path.$obj_new->diarydat[0]["dr_img4"]);
					chmod( $param_dr_img4_path.$obj_new->diarydat[0]["dr_img4"] , 0755 );
				}

				$obj_dr_4_new = new ImageControl;
				$obj_dr_4_new->max_w = 580;
				$obj_dr_4_new->max_h = 580;
				$obj_dr_4_new->origin_dir = $param_dr_img4_path;
				$obj_dr_4_new->origin_img = $obj_new->diarydat[0]["dr_img4"];
				$obj_dr_4_new->gd_ver = 1;
				list($resize_dr_4_new,$imageType) = $obj_dr_4_new->ImageResizeSave();
				if($resize_dr_4_new == -1){
	                        	$obj_error->ViewErrMessage( "SYSTEM" , "ALL" , "blog_mnt.php" , $arrOther  );
	                       		exit;
				}

				$obj_other_4_save_new = new ImageControl;
				$obj_other_4_save_new->origin_dir = $param_dr_img4_path;
				$obj_other_4_save_new->origin_img = $obj_new->diarydat[0]["dr_img4"];
				$obj_other_4_save_new->imageResource = $resize_dr_4_new;
				$dr_4_suc_new = $obj_other_4_save_new->ImageSave($imageType);
				if($dr_4_suc_new == -1){
	                        	$obj_error->ViewErrMessage( "SYSTEM" , "ALL" , "blog_mnt.php" , $arrOther  );
	                       		exit;
				}
			}

		}
		if( $suc == -1 ){
                        $arrOther["ath_comment"] = "<INPUT TYPE=\"hidden\" NAME=\"stpos\" VALUE=\"{$_POST['stpos']}\">";
			$arrOther['ath_comment'] .= $athComment;
                        $obj_error->ViewErrMessage( "INS_ERROR" , "ALL" , "diary_mnt.php" , $arrOther );
                        exit;
		}
		$message = "記事を登録しました。";
		break;

	case "EDIT":
		// 画像1
                if( filesize($_FILES["dr_img1"]["tmp_name"]) > (1024*1024*2) ){
			$arrOther['ath_comment'] .= $athComment;
                        $obj_error->ViewErrMessage( "FILE_SIZE" , "ALL" , "diary_mnt.php" , $arrOther );
                        exit;
                }
                if( filesize($_FILES["dr_img2"]["tmp_name"]) > (1024*1024*2) ){
			$arrOther['ath_comment'] .= $athComment;
                        $obj_error->ViewErrMessage( "FILE_SIZE" , "ALL" , "diary_mnt.php" , $arrOther );
                        exit;
                }
                if( filesize($_FILES["dr_img3"]["tmp_name"]) > (1024*1024*2) ){
			$arrOther['ath_comment'] .= $athComment;
                        $obj_error->ViewErrMessage( "FILE_SIZE" , "ALL" , "diary_mnt.php" , $arrOther );
                        exit;
                }
                if( filesize($_FILES["dr_img4"]["tmp_name"]) > (1024*1024*2) ){
			$arrOther['ath_comment'] .= $athComment;
                        $obj_error->ViewErrMessage( "FILE_SIZE" , "ALL" , "diary_mnt.php" , $arrOther );
                        exit;
                }
		IF( is_uploaded_file( $_FILES["dr_img1"]["tmp_name"] ) ){
			$imageInfo = @getimagesize( $_FILES["dr_img1"]["tmp_name"] );
			IF( @getimagesize( $_FILES["dr_img1"]["tmp_name"] ) === FALSE || ( $imageInfo[2] != 1 && $imageInfo[2] != 2 ) ){
				$arrOther['ath_comment'] .= $athComment;
                        	$obj_error->ViewErrMessage( "NOT_IMG" , "ALL" , "diary_mnt.php" , $arrOther );
                        	exit;
			}
			$kaku1 = split("\.",$_FILES["dr_img1"]["name"]);
			$dr_imgorg1 = $kaku1[0].".".$kaku1[1];
			$dr_img1 = "diary_".$_SESSION["_cl_id"]."_".$_POST['dr_id']."_1.".$kaku1[1];
		}

		// 画像2
		IF( is_uploaded_file( $_FILES["dr_img2"]["tmp_name"] ) ){
			$imageInfo = @getimagesize( $_FILES["dr_img2"]["tmp_name"] );
			IF( @getimagesize( $_FILES["dr_img2"]["tmp_name"] ) === FALSE || ( $imageInfo[2] != 1 && $imageInfo[2] != 2 ) ){
				$arrOther['ath_comment'] .= $athComment;
                        	$obj_error->ViewErrMessage( "NOT_IMG" , "ALL" , "diary_mnt.php" , $arrOther );
                        	exit;
			}
			$kaku2 = split("\.",$_FILES["dr_img2"]["name"]);
			$dr_imgorg2 = $kaku2[0].".".$kaku2[1];
			$dr_img2 = "diary_".$_SESSION["_cl_id"]."_".$_POST["dr_id"]."_2.".$kaku2[1];
		}

		// 画像3
		IF( is_uploaded_file( $_FILES["dr_img3"]["tmp_name"] ) ){
			$imageInfo = @getimagesize( $_FILES["dr_img3"]["tmp_name"] );
			IF( @getimagesize( $_FILES["dr_img3"]["tmp_name"] ) === FALSE || ( $imageInfo[2] != 1 && $imageInfo[2] != 2 ) ){
				$arrOther['ath_comment'] .= $athComment;
                        	$obj_error->ViewErrMessage( "NOT_IMG" , "ALL" , "diary_mnt.php" , $arrOther );
                        	exit;
			}
			$kaku3 = split("\.",$_FILES["dr_img3"]["name"]);
			$dr_imgorg3 = $kaku3[0].".".$kaku3[1];
			$dr_img3 = "diary_".$_SESSION["_cl_id"]."_".$_POST["dr_id"]."_3.".$kaku3[1];
		}

		// 画像4
		IF( is_uploaded_file( $_FILES["dr_img4"]["tmp_name"] ) ){
			$imageInfo = @getimagesize( $_FILES["dr_img4"]["tmp_name"] );
			IF( @getimagesize( $_FILES["dr_img4"]["tmp_name"] ) === FALSE || ( $imageInfo[2] != 1 && $imageInfo[2] != 2 ) ){
				$arrOther['ath_comment'] .= $athComment;
                        	$obj_error->ViewErrMessage( "NOT_IMG" , "ALL" , "diary_mnt.php" , $arrOther );
                        	exit;
			}
			$kaku4 = split("\.",$_FILES["dr_img4"]["name"]);
			$dr_imgorg4 = $kaku4[0].".".$kaku4[1];
			$dr_img4 = "diary_".$_SESSION["_cl_id"]."_".$_POST["dr_id"]."_4.".$kaku4[1];
		}
		$obj_rev = new basedb_DiaryClassTblAccess;
		$obj_rev->conn = $obj_conn->conn;
		$obj_rev->diarydat[0]["dr_id"] = $_POST["dr_id"];
		$obj_rev->diarydat[0]["dr_clid"] = $_SESSION["_cl_id"];
		$obj_rev->diarydat[0]["dr_cgid"] = $_POST["dr_cgid"];
		$obj_rev->diarydat[0]["dr_tcid"] = $_POST["dr_tcid"];
		$obj_rev->diarydat[0]["dr_title"] = $_POST["dr_title"];
		$obj_rev->diarydat[0]["dr_contents"] = $_POST["dr_contents"];
		$obj_rev->diarydat[0]["dr_img1_del_chk"] = $_POST["dr_img1_del_chk"];
		IF( is_uploaded_file($_FILES["dr_img1"]["tmp_name"]) ){
			$obj_rev->diarydat[0]["dr_imgorg1"] = $dr_imgorg1;
			$obj_rev->diarydat[0]["dr_img1"] = $dr_img1;
		}
		$obj_rev->diarydat[0]["dr_img2_del_chk"] = $_POST["dr_img2_del_chk"];
		IF( is_uploaded_file($_FILES["dr_img2"]["tmp_name"]) ){
			$obj_rev->diarydat[0]["dr_imgorg2"] = $dr_imgorg2;
			$obj_rev->diarydat[0]["dr_img2"] = $dr_img2;
		}
		$obj_rev->diarydat[0]["dr_img3_del_chk"] = $_POST["dr_img3_del_chk"];
		IF( is_uploaded_file($_FILES["dr_img3"]["tmp_name"]) ){
			$obj_rev->diarydat[0]["dr_imgorg3"] = $dr_imgorg3;
			$obj_rev->diarydat[0]["dr_img3"] = $dr_img3;
		}
		$obj_rev->diarydat[0]["dr_img4_del_chk"] = $_POST["dr_img4_del_chk"];
		IF( is_uploaded_file($_FILES["dr_img4"]["tmp_name"]) ){
			$obj_rev->diarydat[0]["dr_imgorg4"] = $dr_imgorg4;
			$obj_rev->diarydat[0]["dr_img4"] = $dr_img4;
		}
		$obj_rev->diarydat[0]["dr_ido"] =  $_POST['dr_ido'];
		$obj_rev->diarydat[0]["dr_keido"] =  $_POST['dr_keido'];
		$obj_rev->diarydat[0]["dr_zoom"] =  $_POST['dr_zoom'];
		$obj_rev->diarydat[0]["dr_adminid"] = NULL;
		$obj_rev->diarydat[0]["dr_upddate"] = $_POST["dr_upddate"];
		$suc = $obj_rev->basedb_UpdDiary();
		IF( $suc == "0" ){
			IF($_POST['dr_img1_del_chk']==1){
				IF( file_exists( $param_dr_img1_path.$_POST['dr_img1_lastupd'] ) && $_POST['dr_img1_lastupd'] != "" ){
					unlink( $param_dr_img1_path.$_POST['dr_img1_lastupd'] );
				}
			}
			IF($_POST['dr_img2_del_chk']==1){
				IF( file_exists( $param_dr_img2_path.$_POST['dr_img2_lastupd'] ) && $_POST['dr_img2_lastupd'] != "" ){
					unlink( $param_dr_img2_path.$_POST['dr_img2_lastupd'] );
				}
			}
			IF($_POST['dr_img3_del_chk']==1){
				IF( file_exists( $param_dr_img3_path.$_POST['dr_img3_lastupd'] ) && $_POST['dr_img3_lastupd'] != "" ){
					unlink( $param_dr_img3_path.$_POST['dr_img3_lastupd'] );
				}
			}
			IF($_POST['dr_img4_del_chk']==1){
				IF( file_exists( $param_dr_img4_path.$_POST['dr_img4_lastupd'] ) && $_POST['dr_img4_lastupd'] != "" ){
					unlink( $param_dr_img4_path.$_POST['dr_img4_lastupd'] );
				}
			}
			// 画像保存・削除処理
			IF( is_uploaded_file( $_FILES["dr_img1"]["tmp_name"] ) ){
				// 一度画像を削除==>再度コピー
				IF( file_exists( $param_dr_img1_path.$_POST['dr_img1_lastupd'] ) && $_POST['dr_img1_lastupd'] != "" ){
					unlink( $param_dr_img1_path.$_POST['dr_img1_lastupd'] );
				}
				// 同じ名前で、UPLOADされたデータをコピー
				IF( is_uploaded_file($_FILES["dr_img1"]["tmp_name"]) && $obj_rev->diarydat[0]["dr_img1"] != "" ){
					move_uploaded_file( $_FILES["dr_img1"]["tmp_name"] , $param_dr_img1_path.$dr_img1 );
					chmod( $param_dr_img1_path.$dr_img1 , 0755 );
				}

				$obj_dr_1_rev = new ImageControl;
				$obj_dr_1_rev->max_w = 580;
				$obj_dr_1_rev->max_h = 580;
				$obj_dr_1_rev->origin_dir = $param_dr_img1_path;
				$obj_dr_1_rev->origin_img = $dr_img1;
				$obj_dr_1_rev->gd_ver = 1;
				list($resize_dr_1_rev,$imageType) = $obj_dr_1_rev->ImageResizeSave();
				if($resize_dr_1_rev == -1){
	                        	$obj_error->ViewErrMessage( "SYSTEM" , "ALL" , "blog_mnt.php" , $arrOther  );
	                       		exit;
				}

				$obj_dr_1_save_rev = new ImageControl;
				$obj_dr_1_save_rev->origin_dir = $param_dr_img1_path;
				$obj_dr_1_save_rev->origin_img = $dr_img1;
				$obj_dr_1_save_rev->imageResource = $resize_dr_1_rev;
				$dr_1_suc_rev = $obj_dr_1_save_rev->ImageSave($imageType);
				if($dr_1_suc_rev == -1){
	                        	$obj_error->ViewErrMessage( "SYSTEM" , "ALL" , "blog_mnt.php" , $arrOther  );
	                       		exit;
				}
			}
			
			IF( is_uploaded_file( $_FILES["dr_img2"]["tmp_name"] ) ){
				// 一度画像を削除==>再度コピー
				IF( file_exists( $param_dr_img2_path.$_POST['dr_img2_lastupd'] ) && $_POST['dr_img2_lastupd'] != "" ){
					unlink( $param_dr_img2_path.$_POST['dr_img2_lastupd'] );
				}
				// 同じ名前で、UPLOADされたデータをコピー
				IF( is_uploaded_file($_FILES["dr_img2"]["tmp_name"]) && $obj_rev->diarydat[0]["dr_img2"] != "" ){
					move_uploaded_file( $_FILES["dr_img2"]["tmp_name"] , $param_dr_img2_path.$dr_img2 );
					chmod( $param_dr_img2_path.$dr_img2 , 0755 );
				}

				$obj_dr_2_rev = new ImageControl;
				$obj_dr_2_rev->max_w = 580;
				$obj_dr_2_rev->max_h = 580;
				$obj_dr_2_rev->origin_dir = $param_dr_img2_path;
				$obj_dr_2_rev->origin_img = $dr_img2;
				$obj_dr_2_rev->gd_ver = 1;
				list($resize_dr_2_rev,$imageType) = $obj_dr_2_rev->ImageResizeSave();
				if($resize_dr_2_rev == -1){
	                        	$obj_error->ViewErrMessage( "SYSTEM" , "ALL" , "blog_mnt.php" , $arrOther  );
	                       		exit;
				}

				$obj_dr_2_save_rev = new ImageControl;
				$obj_dr_2_save_rev->origin_dir = $param_dr_img2_path;
				$obj_dr_2_save_rev->origin_img = $dr_img2;
				$obj_dr_2_save_rev->imageResource = $resize_dr_2_rev;
				$dr_2_suc_rev = $obj_dr_2_save_rev->ImageSave($imageType);
				if($dr_2_suc_rev == -1){
	                        	$obj_error->ViewErrMessage( "SYSTEM" , "ALL" , "blog_mnt.php" , $arrOther  );
	                       		exit;
				}
			}
			
			IF( is_uploaded_file( $_FILES["dr_img3"]["tmp_name"] ) ){
				// 一度画像を削除==>再度コピー
				IF( file_exists( $param_dr_img3_path.$_POST['dr_img3_lastupd'] ) && $_POST['dr_img3_lastupd'] != "" ){
					unlink( $param_dr_img3_path.$_POST['dr_img3_lastupd'] );
				}
				// 同じ名前で、UPLOADされたデータをコピー
				IF( is_uploaded_file($_FILES["dr_img3"]["tmp_name"]) && $obj_rev->diarydat[0]["dr_img3"] != "" ){
					move_uploaded_file( $_FILES["dr_img3"]["tmp_name"] , $param_dr_img3_path.$dr_img3);
					chmod( $param_dr_img3_path.$dr_img3 , 0755 );
				}

				$obj_dr_3_rev = new ImageControl;
				$obj_dr_3_rev->max_w = 580;
				$obj_dr_3_rev->max_h = 580;
				$obj_dr_3_rev->origin_dir = $param_dr_img3_path;
				$obj_dr_3_rev->origin_img = $dr_img3;
				$obj_dr_3_rev->gd_ver = 1;
				list($resize_dr_3_rev,$imageType) = $obj_dr_3_rev->ImageResizeSave();
				if($resize_dr_3_rev == -1){
	                        	$obj_error->ViewErrMessage( "SYSTEM" , "ALL" , "blog_mnt.php" , $arrOther  );
	                       		exit;
				}

				$obj_dr_3_save_rev = new ImageControl;
				$obj_dr_3_save_rev->origin_dir = $param_dr_img3_path;
				$obj_dr_3_save_rev->origin_img = $dr_img3;
				$obj_dr_3_save_rev->imageResource = $resize_dr_3_rev;
				$dr_3_suc_rev = $obj_dr_3_save_rev->ImageSave($imageType);
				if($dr_3_suc_rev == -1){
	                        	$obj_error->ViewErrMessage( "SYSTEM" , "ALL" , "blog_mnt.php" , $arrOther  );
	                       		exit;
				}
			}

			IF( is_uploaded_file( $_FILES["dr_img4"]["tmp_name"] ) ){
				// 一度画像を削除==>再度コピー
				IF( file_exists( $param_dr_img4_path.$_POST['dr_img4_lastupd'] ) && $_POST['dr_img4_lastupd'] != "" ){
					unlink( $param_dr_img4_path.$_POST['dr_img4_lastupd'] );
				}
				// 同じ名前で、UPLOADされたデータをコピー
				IF( is_uploaded_file($_FILES["dr_img4"]["tmp_name"]) && $obj_rev->diarydat[0]["dr_img4"] != "" ){
					move_uploaded_file( $_FILES["dr_img4"]["tmp_name"] , $param_dr_img4_path.$dr_img4);
					chmod( $param_dr_img4_path.$dr_img4 , 0755 );
				}

				$obj_dr_4_rev = new ImageControl;
				$obj_dr_4_rev->max_w = 580;
				$obj_dr_4_rev->max_h = 580;
				$obj_dr_4_rev->origin_dir = $param_dr_img4_path;
				$obj_dr_4_rev->origin_img = $dr_img4;
				$obj_dr_4_rev->gd_ver = 1;
				list($resize_dr_4_rev,$imageType) = $obj_dr_4_rev->ImageResizeSave();
				if($resize_dr_4_rev == -1){
	                        	$obj_error->ViewErrMessage( "SYSTEM" , "ALL" , "blog_mnt.php" , $arrOther  );
	                       		exit;
				}

				$obj_dr_4_save_rev = new ImageControl;
				$obj_dr_4_save_rev->origin_dir = $param_dr_img4_path;
				$obj_dr_4_save_rev->origin_img = $dr_img4;
				$obj_dr_4_save_rev->imageResource = $resize_dr_4_rev;
				$dr_4_suc_rev = $obj_dr_4_save_rev->ImageSave($imageType);
				if($dr_4_suc_rev == -1){
	                        	$obj_error->ViewErrMessage( "SYSTEM" , "ALL" , "blog_mnt.php" , $arrOther  );
	                       		exit;
				}
			}

		}
		switch( $suc ){
			case "-1":
				$arrOther['ath_comment'] .= $athComment;
                        	$arrOther["ath_comment"] = "<INPUT TYPE=\"hidden\" NAME=\"stpos\" VALUE=\"{$_POST['stpos']}\">";
                        	$obj_error->ViewErrMessage( "UPD_ERROR" , "ALL" , "diary_mnt.php" , $arrOther );
                        	exit;
			case "1":
                        	$arrOther["ath_comment"] = "<INPUT TYPE=\"hidden\" NAME=\"stpos\" VALUE=\"{$_POST['stpos']}\">";
                        	$obj_error->ViewErrMessage( "DOUBLE_UPD" , "ALL" , "diary_main.php" , $arrOther );
                        	exit;
		}
		$message = "記事を修正しました。";
		break;

	case 'DEL':
		$obj_del = new basedb_DiaryClassTblAccess;
		$obj_del->conn = $obj_conn->conn;
		$obj_del->diarydat[0]["dr_id"] = $_POST["dr_id"];
		$obj_del->diarydat[0]["dr_upddate"] = $_POST["dr_upddate"];
		$suc = $obj_del->basedb_DelDiary(0);
		if( $suc == -1 ){
                        $arrOther["ath_comment"] = "<INPUT TYPE=\"hidden\" NAME=\"stpos\" VALUE=\"{$_POST['stpos']}\">";
                        $obj_error->ViewErrMessage( "DEL_ERROR" , "ALL" , "diary_main.php" , $arrOther );
                        exit;
		}
		IF( $suc == "0" ){
			// 画像を削除
			IF( file_exists( $param_dr_img1_path.$_POST['dr_img1_lastupd'] ) && $_POST['dr_img1_lastupd'] != ""){
				unlink( $param_dr_img1_path.$_POST['dr_img1_lastupd'] );
			}
			IF( file_exists( $param_dr_img2_path.$_POST['dr_img2_lastupd'] ) && $_POST['dr_img2_lastupd'] != ""){
				unlink( $param_dr_img2_path.$_POST['dr_img2_lastupd'] );
			}
			IF( file_exists( $param_dr_img3_path.$_POST['dr_img3_lastupd'] ) && $_POST['dr_img3_lastupd'] != ""){
				unlink( $param_dr_img3_path.$_POST['dr_img3_lastupd'] );
			}
			IF( file_exists( $param_dr_img4_path.$_POST['dr_img4_lastupd'] ) && $_POST['dr_img4_lastupd'] != ""){
				unlink( $param_dr_img4_path.$_POST['dr_img4_lastupd'] );
			}
		}
		$message = "指定された記事を削除しました。";
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

if( $obj_cl_blog->clientdat[0]["cl_dokuji_flg"] == 1 && $obj_cl_blog->clientdat[0]["cl_dokuji_domain"] != "" )
	// 独自ドメインの場合
	define( '_RSSBLOG_SITE_URL_BASE' , $obj_cl_blog->clientdat[0]["cl_dokuji_domain"] );
else
	define( '_RSSBLOG_SITE_URL_BASE' , _BLOG_SITE_URL_BASE.$obj_cl_blog->clientdat[0]['cl_urlcd']."/" );

//---------------------------
//スタッフ日記ＲＳＳ生成

//建物+部屋情報抽出
$obj_rss_dr_blog = new basedb_DiaryClassTblAccess;
$obj_rss_dr_blog->conn = $obj_conn->conn;
$obj_rss_dr_blog->jyoken["dr_deldate"] = 1;
$obj_rss_dr_blog->jyoken["dr_clid"] = $_SESSION['_cl_id'];
$obj_rss_dr_blog->sort["dr_upddate"] = 2;				// 並び順 - 部屋情報最終更新日時で降順
list( $rssDiaryBlogCnt , $rssDiaryBlogTotal ) = $obj_rss_dr_blog->basedb_GetDiary ( 1 , -1 );

//各アイテム（スタッフ日記情報）XMLタグ生成
$rssDiaryItemValue = "";
$sitemapDiaryItemValue = "";
for($rssX=0;$rssX<$rssDiaryBlogCnt;$rssX++){
	// timestamp形をRFC822形式へ変更
	$bufDate1 = explode( "." , $obj_rss_dr_blog->diarydat[$rssX]["dr_upddate"] );	// マイクロ秒を切り捨てる
	$bufDate2 = explode( " " , $bufDate1[0] );			// 日付と時間を分ける
	$bufDate3_1 = explode( "-" , $bufDate2[0] );			// 年月日を分ける
	$bufDate3_2 = explode( ":" , $bufDate2[1] );			// 時分秒を分ける
	$bufTimeUnix = mktime( $bufDate3_2[0] , $bufDate3_2[1] , $bufDate3_2[2] , $bufDate3_1[1] , $bufDate3_1[2] , $bufDate3_1[0] );
	$strSemiUpdate = date( "r" , $bufTimeUnix );
	$dr_contents = mb_ereg_replace( "\n" , "" , $obj_rss_dr_blog->diarydat[$rssX]['dr_contents'] );
	$sc_introduce = mb_ereg_replace( "\n" , "" , $obj_cl_blog->clientdat[0]['sc_introduce'] );

	$rssDiaryItemValue .= "    <item>\n";
	$rssDiaryItemValue .= "      <title>".fn_escape_rss($obj_rss_dr_blog->diarydat[$rssX]['dr_title'])."</title>\n";
	$rssDiaryItemValue .= "      <link>"._RSSBLOG_SITE_URL_BASE."blog-".$obj_rss_dr_blog->diarydat[$rssX]['dr_id']."/</link>\n";
	$rssDiaryItemValue .= "      <guid>"._RSSBLOG_SITE_URL_BASE."blog-".$obj_rss_dr_blog->diarydat[$rssX]['dr_id']."/</guid>\n";
	$rssDiaryItemValue .= "      <description>".fn_escape_rss($dr_contents)."</description>\n";
	$rssDiaryItemValue .= "      <pubDate>".$strSemiUpdate."</pubDate>\n";
	$rssDiaryItemValue .= "    </item>\n";

	$sitemapDiaryItemValue .= "    <url>\n";
	$sitemapDiaryItemValue .= "    <loc>"._RSSBLOG_SITE_URL_BASE."blog-".$obj_rss_dr_blog->diarydat[$rssX]['dr_id']."/</loc>\n";
	$sitemapDiaryItemValue .= "    <priority>1.0</priority>\n";
	$sitemapDiaryItemValue .= "    <changefreq>always</changefreq>\n";
	$sitemapDiaryItemValue .= "    <lastmod>".$strSemiUpdate."</lastmod>\n";
	$sitemapDiaryItemValue .= "    </url>\n";
}

//RSSファイル生成
//$rssDiaryItemValue = preg_replace('/(.*)〜(.*)/','\1~\2',$rssDiaryItemValue);
$diaryRssTmp = fopen(RSS_BLOG_PATH."rss_diary_".$_SESSION['_cl_id'].".tmp","w");
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

$diarySitemapTmp = fopen(RSS_BLOG_PATH."sitemap_diary_".$_SESSION['_cl_id'].".tmp","w");
if($diarySitemapTmp===flase)exit("ファイルオープン失敗");
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
$cpBuildRss = copy(RSS_BLOG_PATH."rss_diary_".$_SESSION['_cl_id'].".tmp", RSS_BLOG_PATH."rss_diary_".$_SESSION['_cl_id'].".xml");
//$rnBuildRss = rename(RSS_BLOG_PATH."rss_diary_".$_SESSION['_cl_id'].".tmp", RSS_BLOG_PATH."rss_diary_".$_SESSION['_cl_id'].".xml");
if($cpBuildRss===flase)exit("ファイルコピー失敗");

$exBuildRss = file_exists(RSS_BLOG_PATH."rss_diary_".$_SESSION['_cl_id'].".xml");
if($exBuildRss !== FALSE){
	$dlBuildRss = unlink(RSS_BLOG_PATH."rss_diary_".$_SESSION['_cl_id'].".tmp");
	if($dlBuildRss===flase)exit("ファイル削除失敗");
}

$sitemapDiaryValue = mb_convert_encoding($sitemapDiaryValue,"UTF-8","EUC-JP");
fputs($diarySitemapTmp,$sitemapDiaryValue);
flock($diarySitemapTmp,LOCK_UN);
fclose($diarySitemapTmp);
$cpBuildSitemap = copy(RSS_BLOG_PATH."sitemap_diary_".$_SESSION['_cl_id'].".tmp", RSS_BLOG_PATH."sitemap_diary_".$_SESSION['_cl_id'].".xml");
//$rnBuildRss = rename(RSS_BLOG_PATH."sitemap_diary_".$_SESSION['_cl_id'].".tmp", RSS_BLOG_PATH."sitemap_diary_".$_SESSION['_cl_id'].".xml");
if($cpBuildSitemap===flase)exit("ファイルコピー失敗");

$exBuildSitemap = file_exists(RSS_BLOG_PATH."sitemap_diary_".$_SESSION['_cl_id'].".xml");
if($exBuildSitemap !== FALSE){
	$dlBuildSitemap = unlink(RSS_BLOG_PATH."sitemap_diary_".$_SESSION['_cl_id'].".tmp");
	if($dlBuildSitemap===flase)exit("ファイル削除失敗");
}

//---------------------------
//建物ＲＳＳ生成

//建物+部屋情報抽出
$obj_rev_rss = new viewdb_CourseClassTblAccess;
$obj_rev_rss->conn = $obj_conn->conn;
$obj_rev_rss->jyoken["cs_deldate"] = 1;
$obj_rev_rss->jyoken["cs_stat"] = 1;				// 部屋状態が「空き」のもの
$obj_rev_rss->jyoken["cs_clid"] = $_SESSION['_cl_id'];
$obj_rev_rss->sort["cs_upddate"] = 2;				// 並び順 - 部屋情報最終更新日時で降順
list( $rssCnt , $rssTotal ) = $obj_rev_rss->viewdb_GetCourse ( 1 , -1 );



//各アイテム（物件情報）XMLタグ生成
$rssBuildItemValue = "";
$rssDiaryItemValue = html_delete($rssDiaryItemValue);
$rssBuildItemValue .= $rssDiaryItemValue;

$sitemapBuildItemValue = "";
$sitemapDiaryItemValue = html_delete($sitemapDiaryItemValue);
$sitemapBuildItemValue .= $sitemapDiaryItemValue;
for($rssX=0;$rssX<$rssCnt;$rssX++){
	// timestamp形をRFC822形式へ変更
	$bufDate1 = explode( "." , $obj_rev_rss->coursedat[$rssX]["cs_upddate"] );	// マイクロ秒を切り捨てる
	$bufDate2 = explode( " " , $bufDate1[0] );			// 日付と時間を分ける
	$bufDate3_1 = explode( "-" , $bufDate2[0] );			// 年月日を分ける
	$bufDate3_2 = explode( ":" , $bufDate2[1] );			// 時分秒を分ける
	$bufTimeUnix = mktime( $bufDate3_2[0] , $bufDate3_2[1] , $bufDate3_2[2] , $bufDate3_1[1] , $bufDate3_1[2] , $bufDate3_1[0] );
	$strSemiUpdate = date( "r" , $bufTimeUnix );
	$cs_pr = mb_ereg_replace( "\n" , "" , $obj_rev_rss->coursedat[$rssX]['cs_pr'] );
	$sc_introduce = mb_ereg_replace( "\n" , "" , $obj_cl_blog->clientdat[0]['sc_introduce'] );
	$cs_start = split(":",$obj_rev_rss->coursedat[$rssX]['cs_start']);
	$cs_end = split(":",$obj_rev_rss->coursedat[$rssX]['cs_end']);

	$rssBuildItemValue .= "    <item>\n";
	$rssBuildItemValue .= "      <title>";
	$rssBuildItemValue .= fn_escape_rss($obj_rev_rss->coursedat[$rssX]['cs_title']."　".ltrim($cs_start[0],"0").":".$cs_start[2]."開始".ltrim($cs_end[0],"0").":".$cs_end[1]."終了　".$obj_rev_rss->coursedat[$rssX]['cs_week'])."</title>\n";
	$rssBuildItemValue .= "      <link>"._RSSBLOG_SITE_URL_BASE."course-detail-".$obj_rev_rss->coursedat[$rssX]['cs_id']."/</link>\n";
	$rssBuildItemValue .= "      <guid>"._RSSBLOG_SITE_URL_BASE."course-detail-".$obj_rev_rss->coursedat[$rssX]['cs_id']."/</guid>\n";
	$rssBuildItemValue .= "      <description>".fn_escape_rss($cs_pr)."</description>\n";
	$rssBuildItemValue .= "      <pubDate>".$strSemiUpdate."</pubDate>\n";
	$rssBuildItemValue .= "    </item>\n";

	$sitemapBuildItemValue .= "    <url>\n";
	$sitemapBuildItemValue .= "    <loc>"._RSSBLOG_SITE_URL_BASE."course-detail-".$obj_rev_rss->coursedat[$rssX]['cs_id']."/</loc>\n";
	$sitemapBuildItemValue .= "    <priority>1.0</priority>\n";
	$sitemapBuildItemValue .= "    <changefreq>always</changefreq>\n";
	$sitemapBuildItemValue .= "    <lastmod>".$strSemiUpdate."</lastmod>\n";
	$sitemapBuildItemValue .= "    </url>\n";
}

//RSSファイル生成
$buildRssTmp = fopen(RSS_BLOG_PATH."rss_".$_SESSION['_cl_id'].".tmp","w");
if($buildRssTmp===flase)exit("ファイルオープン失敗");
flock($buildRssTmp,LOCK_EX);
$rssBuildValue = "<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n";
$rssBuildValue .= "<?xml-stylesheet type=\"text/css\" href=\"rss.css\"?>\n";
$rssBuildValue .= "<rss version=\"2.0\">\n";
$rssBuildValue .= "  <channel>\n";
$rssBuildValue .= "    <title>".fn_escape_rss($obj_cl_blog->clientdat[0]['sc_toptitle'])."</title>\n";
$rssBuildValue .= "    <link>"._RSSBLOG_SITE_URL_BASE."</link>\n";
$rssBuildValue .= "    <copyright>".fn_escape_rss($obj_cl_blog->clientdat[0]['cl_jname'].$obj_cl_blog->clientdat[0]['cl_kname'])."</copyright>\n";
$rssBuildValue .= "    <description>".fn_escape_rss($sc_introduce)."</description>\n";
$rssBuildValue .= $rssBuildItemValue;
$rssBuildValue .= "  </channel>\n";
$rssBuildValue .= "</rss>\n";

$buildSitemapTmp = fopen(RSS_BLOG_PATH."sitemap_".$_SESSION['_cl_id'].".tmp","w");
if($buildSitemapTmp===flase)exit("ファイルオープン失敗");
flock($buildSitemapTmp,LOCK_EX);
$sitemapBuildValue = "<?xml version=\"1.0\" encoding=\"UTF-8\" ?>\n";
$sitemapBuildValue .= "<urlset xmlns=\"http://www.google.com/schemas/sitemap/0.84\">\n";
$sitemapBuildValue .= $sitemapBuildItemValue;
$sitemapBuildValue .= "</urlset>\n";

asort( $rss );
$countrss = count($rss);
FOREACH( $rss as $key => $val ){
	$rssBuildValue = mb_ereg_replace($val,"",$rssBuildValue);
}

$rssBuildValue = mb_convert_encoding($rssBuildValue,"UTF-8","EUC-JP");
fputs($buildRssTmp,$rssBuildValue);
flock($buildRssTmp,LOCK_UN);
fclose($buildRssTmp);
$cpBuildRss = copy(RSS_BLOG_PATH."rss_".$_SESSION['_cl_id'].".tmp", RSS_BLOG_PATH."rss_".$_SESSION['_cl_id'].".xml");
//$rnBuildRss = rename(RSS_BLOG_PATH."rss_".$_SESSION['_cl_id'].".tmp", RSS_BLOG_PATH."rss_".$_SESSION['_cl_id'].".xml");
if($cpBuildRss===flase)exit("ファイルコピー失敗");

$exBuildRss = file_exists(RSS_BLOG_PATH."rss_".$_SESSION['_cl_id'].".xml");
if($exBuildRss !== FALSE){
	$dlBuildRss = unlink(RSS_BLOG_PATH."rss_".$_SESSION['_cl_id'].".tmp");
	if($dlBuildRss===flase)exit("ファイル削除失敗");
}

$sitemapBuildValue = mb_convert_encoding($sitemapBuildValue,"UTF-8","EUC-JP");
fputs($buildSitemapTmp,$sitemapBuildValue);
flock($buildSitemapTmp,LOCK_UN);
fclose($buildSitemapTmp);
$cpBuildSitemap = copy(RSS_BLOG_PATH."sitemap_".$_SESSION['_cl_id'].".tmp", RSS_BLOG_PATH."sitemap_".$_SESSION['_cl_id'].".xml");
//$rnBuildRss = rename(RSS_BLOG_PATH."sitemap_".$_SESSION['_cl_id'].".tmp", RSS_BLOG_PATH."sitemap_".$_SESSION['_cl_id'].".xml");
if($cpBuildSitemap===flase)exit("ファイルコピー失敗");

$exBuildSitemaps = file_exists(RSS_BLOG_PATH."sitemap_".$_SESSION['_cl_id'].".xml");
if($exBuildSitemaps !== FALSE){
	$dlBuildSitemap = unlink(RSS_BLOG_PATH."sitemap_".$_SESSION['_cl_id'].".tmp");
	if($dlBuildSitemap===flase)exit("ファイル削除失敗");
}


//---------------------------
//スタッフ日記ＲＳＳ生成


//建物+部屋情報抽出
$obj_rss_dr_blog = new viewdb_DiaryClassTblAccess;
$obj_rss_dr_blog->conn = $obj_conn->conn;
$obj_rss_dr_blog->jyoken["dr_deldate"] = 1;
$obj_rss_dr_blog->sort["dr_upddate"] = 2;				// 並び順 - 部屋情報最終更新日時で降順
list( $rssDiaryBlogCnt , $rssDiaryBlogTotal ) = $obj_rss_dr_blog->viewdb_GetDiary ( 1 , 100 );

//各アイテム（スタッフ日記情報）XMLタグ生成
$rssDiaryItemValue = "";
$sitemapDiaryItemValue = "";
for($rssX=0;$rssX<$rssDiaryBlogCnt;$rssX++){
//	$obj_rss_dr_blogURLcode = new viewdb_ClientClassTblAccess;
//	$obj_rss_dr_blogURLcode->conn = $obj_conn->conn;
//	$obj_rss_dr_blogURLcode->jyoken["cl_id"] = $obj_rss_dr_blog->diarydat[$rssX]["dr_clid"];
//	list( $rssUcCnt , $rssUcTotal ) = $obj_rss_dr_blogURLcode->viewdb_GetClient ( 1 , -1 );

	// timestamp形をRFC822形式へ変更
	$bufDate1 = explode( "." , $obj_rss_dr_blog->diarydat[$rssX]["dr_upddate"] );	// マイクロ秒を切り捨てる
	$bufDate2 = explode( " " , $bufDate1[0] );			// 日付と時間を分ける
	$bufDate3_1 = explode( "-" , $bufDate2[0] );			// 年月日を分ける
	$bufDate3_2 = explode( ":" , $bufDate2[1] );			// 時分秒を分ける
	$bufTimeUnix = mktime( $bufDate3_2[0] , $bufDate3_2[1] , $bufDate3_2[2] , $bufDate3_1[1] , $bufDate3_1[2] , $bufDate3_1[0] );
	$strSemiUpdate = date( "r" , $bufTimeUnix );
	$dr_contents = mb_ereg_replace( "\n" , "" , $obj_rss_dr_blog->diarydat[$rssX]['dr_contents'] );
	$sc_introduce = mb_ereg_replace( "\n" , "" , $obj_cl_blog->clientdat[0]['sc_introduce'] );

	$rssDiaryItemValue .= "    <item>\n";
	$rssDiaryItemValue .= "      <title>".fn_escape_rss($obj_rss_dr_blog->diarydat[$rssX]['dr_title'])."</title>\n";
	if( $obj_rss_dr_blog->diarydat[$rssX]["cl_dokuji_flg"] == 1 && $obj_rss_dr_blog->diarydat[$rssX]["cl_dokuji_domain"] != "" ) {
		// 独自ドメインの場合
		$rssDiaryItemValue .= "      <link>".$obj_rss_dr_blog->diarydat[$rssX]["cl_dokuji_domain"]."blog-".$obj_rss_dr_blog->diarydat[$rssX]['dr_id']."/</link>\n";
		$rssDiaryItemValue .= "      <guid>".$obj_rss_dr_blog->diarydat[$rssX]["cl_dokuji_domain"]."blog-".$obj_rss_dr_blog->diarydat[$rssX]['dr_id']."/</guid>\n";
	} else {
		$rssDiaryItemValue .= "      <link>"._BLOG_SITE_URL_BASE.$obj_rss_dr_blog->diarydat[$rssX]['cl_urlcd']."/blog-".$obj_rss_dr_blog->diarydat[$rssX]['dr_id']."/</link>\n";
		$rssDiaryItemValue .= "      <guid>"._BLOG_SITE_URL_BASE.$obj_rss_dr_blog->diarydat[$rssX]['cl_urlcd']."/blog-".$obj_rss_dr_blog->diarydat[$rssX]['dr_id']."/</guid>\n";
	}
	$rssDiaryItemValue .= "      <description>".fn_escape_rss($dr_contents)."</description>\n";
	$rssDiaryItemValue .= "      <pubDate>".$strSemiUpdate."</pubDate>\n";
	$rssDiaryItemValue .= "    </item>\n";

	$sitemapDiaryItemValue .= "    <url>\n";
	if( $obj_rss_dr_blog->diarydat[$rssX]["cl_dokuji_flg"] == 1 && $obj_rss_dr_blog->diarydat[$rssX]["cl_dokuji_domain"] != "" ) {
		// 独自ドメインの場合
		$sitemapDiaryItemValue .= "    <loc>".$obj_rss_dr_blog->diarydat[$rssX]["cl_dokuji_domain"]."blog-".$obj_rss_dr_blog->diarydat[$rssX]['dr_id']."/</loc>\n";
	} else {
		$sitemapDiaryItemValue .= "    <loc>"._BLOG_SITE_URL_BASE.$obj_rss_dr_blog->diarydat[$rssX]['cl_urlcd']."/blog-".$obj_rss_dr_blog->diarydat[$rssX]['dr_id']."/</loc>\n";
	}
	$sitemapDiaryItemValue .= "    <priority>1.0</priority>\n";
	$sitemapDiaryItemValue .= "    <changefreq>always</changefreq>\n";
	$sitemapDiaryItemValue .= "    <lastmod>".$strSemiUpdate."</lastmod>\n";
	$sitemapDiaryItemValue .= "    </url>\n";
}

//RSSファイル生成
//$rssDiaryItemValue = preg_replace('/(.*)〜(.*)/','\1~\2',$rssDiaryItemValue);
$diaryRssTmp = fopen(RSS_PORTAL_PATH."rss_diary.tmp","w");
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

$diarySitemapTmp = fopen(RSS_PORTAL_PATH."sitemap_diary.tmp","w");
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
$cpBuildRss = copy(RSS_PORTAL_PATH."rss_diary.tmp", RSS_PORTAL_PATH."rss_diary.xml");
//$rnBuildRss = rename(RSS_PORTAL_PATH."rss_diary.tmp", RSS_PORTAL_PATH."rss_diary.xml");
if($cpBuildRss===false)exit("ファイルコピー失敗");

$exBuildRss = file_exists(RSS_PORTAL_PATH."rss_diary.xml");
if($exBuildRss !== FALSE){
	$dlBuildRss = unlink(RSS_PORTAL_PATH."rss_diary.tmp");
	if($dlBuildRss===false)exit("ファイル削除失敗");
}

$sitemapDiaryValue = mb_convert_encoding($sitemapDiaryValue,"UTF-8","EUC-JP");
fputs($diarySitemapTmp,$sitemapDiaryValue);
flock($diarySitemapTmp,LOCK_UN);
fclose($diarySitemapTmp);
$cpBuildPSitemap = copy(RSS_PORTAL_PATH."sitemap_diary.tmp", RSS_PORTAL_PATH."sitemap_diary.xml");
//$rnBuildRss = rename(RSS_PORTAL_PATH."sitemap_diary.tmp", RSS_PORTAL_PATH."sitemap_diary.xml");
if($cpBuildPSitemap===false)exit("ファイルコピー失敗");

$exBuildPSitemap = file_exists(RSS_PORTAL_PATH."sitemap_diary.xml");
if($exBuildPSitemap !== FALSE){
	$dlBuildPSitemap = unlink(RSS_PORTAL_PATH."sitemap_diary.tmp");
	if($dlBuildPSitemap===false)exit("ファイル削除失敗");
}


//---------------------------
//建物ＲＳＳ生成

//建物+部屋情報抽出
$obj_rss_buidP = new viewdb_CourseClassTblAccess;
$obj_rss_buidP->conn = $obj_conn->conn;
$obj_rss_buidP->jyoken["cs_deldate"] = 1;
$obj_rss_buidP->jyoken["cs_stat"] = 1;				// 部屋状態が「空き」のもの
$obj_rss_buidP->sort["cs_upddate"] = 1;				// 並び順 - 部屋情報最終更新日時で降順
list( $rssCnt , $rssTotal ) = $obj_rss_buidP->viewdb_GetCourse ( 1 , 100 );

//各アイテム（物件情報）XMLタグ生成
$rssBuildItemValue = "";
$rssBuildItemValue .= $rssDiaryItemValue;

$sitemapBuildItemValue = "";
$sitemapBuildItemValue .= $sitemapDiaryItemValue;
for($rssX=0;$rssX<$rssCnt;$rssX++){
//	$obj_rss_buidPURLcode = new viewdb_ClientClassTblAccess;
//	$obj_rss_buidPURLcode->conn = $obj_conn->conn;
//	$obj_rss_buidPURLcode->jyoken["cl_id"] = $obj_rss_buidP->coursedat[$rssX]["build_cl_id"];
//	list( $rssUcCnt , $rssUcTotal ) = $obj_rss_buidPURLcode->viewdb_GetClient ( 1 , -1 );

	// timestamp形をRFC822形式へ変更
	$bufDate1 = explode( "." , $obj_rss_buidP->coursedat[$rssX]["cs_upddate"] );	// マイクロ秒を切り捨てる
	$bufDate2 = explode( " " , $bufDate1[0] );			// 日付と時間を分ける
	$bufDate3_1 = explode( "-" , $bufDate2[0] );			// 年月日を分ける
	$bufDate3_2 = explode( ":" , $bufDate2[1] );			// 時分秒を分ける
	$bufTimeUnix = mktime( $bufDate3_2[0] , $bufDate3_2[1] , $bufDate3_2[2] , $bufDate3_1[1] , $bufDate3_1[2] , $bufDate3_1[0] );
	$strSemiUpdate = date( "r" , $bufTimeUnix );
	$cs_start = split(":",$obj_rss_buidP->coursedat[$rssX]['cs_start']);
	$cs_end = split(":",$obj_rss_buidP->coursedat[$rssX]['cs_end']);
	$cs_pr = mb_ereg_replace( "\n" , "" , $obj_rss_buidP->coursedat[$rssX]['cs_pr'] );
	$sc_introduce = mb_ereg_replace( "\n" , "" , $obj_cl_blog->clientdat[0]['sc_introduce'] );

	$rssBuildItemValue .= "    <item>\n";
	$rssBuildItemValue .= "      <title>";
	$rssBuildItemValue .= fn_escape_rss($obj_rss_buidP->coursedat[$rssX]['cs_title']."　".ltrim($cs_start[0],"0").":".$cs_start[2]."開始".ltrim($cs_end[0],"0").":".$cs_end[1]."終了　".$obj_rss_buidP->coursedat[$rssX]['cs_week'])."</title>\n";
	if( $obj_rss_buidP->coursedat[$rssX]["cl_dokuji_flg"] == 1 && $obj_rss_buidP->coursedat[$rssX]["cl_dokuji_domain"] != "" ) {
		// 独自ドメインの場合
		$rssBuildItemValue .= "      <link>".$obj_rss_buidP->coursedat[$rssX]["cl_dokuji_domain"]."course-detail-".$obj_rss_buidP->coursedat[$rssX]['cs_id']."/</link>\n";
		$rssBuildItemValue .= "      <guid>".$obj_rss_buidP->coursedat[$rssX]["cl_dokuji_domain"]."course-detail-".$obj_rss_buidP->coursedat[$rssX]['cs_id']."/</guid>\n";
	} else {
		$rssBuildItemValue .= "      <link>"._BLOG_SITE_URL_BASE.$obj_rss_buidP->coursedat[$rssX]["cl_urlcd"]."/course-detail-".$obj_rss_buidP->coursedat[$rssX]['cs_id']."/</link>\n";
		$rssBuildItemValue .= "      <guid>"._BLOG_SITE_URL_BASE.$obj_rss_buidP->coursedat[$rssX]["cl_urlcd"]."/course-detail-".$obj_rss_buidP->coursedat[$rssX]['cs_id']."/</guid>\n";
	}
	$rssBuildItemValue .= "      <description>".fn_escape_rss($cs_pr) ."</description>\n";
	$rssBuildItemValue .= "      <pubDate>".$strSemiUpdate."</pubDate>\n";
	$rssBuildItemValue .= "    </item>\n";

	$sitemapBuildItemValue .= "    <url>\n";
	if( $obj_rss_buidP->coursedat[$rssX]["cl_dokuji_flg"] == 1 && $obj_rss_buidP->coursedat[$rssX]["cl_dokuji_domain"] != "" ) {
		// 独自ドメインの場合
		$sitemapBuildItemValue .= "    <loc>".$obj_rss_buidP->coursedat[$rssX]["cl_dokuji_domain"]."course-detail-".$obj_rss_buidP->coursedat[$rssX]['cs_id']."/</loc>\n";
	} else {
		$sitemapBuildItemValue .= "    <loc>"._BLOG_SITE_URL_BASE.$obj_rss_buidP->coursedat[$rssX]["cl_urlcd"]."/course-detail-".$obj_rss_buidP->coursedat[$rssX]['cs_id']."/</loc>\n";
	}
	$sitemapBuildItemValue .= "    <priority>1.0</priority>\n";
	$sitemapBuildItemValue .= "    <changefreq>always</changefreq>\n";
	$sitemapBuildItemValue .= "    <lastmod>".$strSemiUpdate."</lastmod>\n";
	$sitemapBuildItemValue .= "    </url>\n";
}

//RSSファイル生成
$buildPRssTmp = fopen(RSS_PORTAL_PATH."rss.tmp","w");
if($buildPRssTmp===flase)exit("ファイルオープン失敗");
flock($buildPRssTmp,LOCK_EX);
$rssBuildValue = "<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n";
$rssBuildValue .= "<?xml-stylesheet type=\"text/css\" href=\"rss.css\"?>\n";
$rssBuildValue .= "<rss version=\"2.0\">\n";
$rssBuildValue .= "  <channel>\n";
$rssBuildValue .= "    <title>塾や教室の検索ならEdyblo[エディブロ]全国の教室がじっくり探せる塾・教室情報検索サイト！</title>\n";
$rssBuildValue .= "    <link>"._BLOG_SITE_URL_BASE."</link>\n";
$rssBuildValue .= "    <copyright>powered by SLASH</copyright>\n";
$rssBuildValue .= "    <description></description>\n";
$rssBuildValue .= $rssBuildItemValue;
$rssBuildValue .= "  </channel>\n";
$rssBuildValue .= "</rss>\n";

$buildPSitemapTmp = fopen(RSS_PORTAL_PATH."sitemap.tmp","w");
if($buildPSitemapTmp===flase)exit("ファイルオープン失敗");
flock($buildPSitemapTmp,LOCK_EX);
$sitemapBuildValue = "<?xml version=\"1.0\" encoding=\"UTF-8\" ?>\n";
$sitemapBuildValue .= "<urlset xmlns=\"http://www.google.com/schemas/sitemap/0.84\">\n";
$sitemapBuildValue .= $sitemapBuildItemValue;
$sitemapBuildValue .= "</urlset>\n";

asort( $rss );
$countrss = count($rss);
FOREACH( $rss as $key => $val ){
	$rssBuildValue = mb_ereg_replace($val,"",$rssBuildValue);
}

$rssBuildValue = mb_convert_encoding($rssBuildValue,"UTF-8","EUC-JP");
fputs($buildPRssTmp,$rssBuildValue);
flock($buildPRssTmp,LOCK_UN);
fclose($buildPRssTmp);
$cpBuildRss = copy(RSS_PORTAL_PATH."rss.tmp", RSS_PORTAL_PATH."rss.xml");
if($cpBuildRss===false)exit("ファイルコピー失敗");

$exBuildRss = file_exists(RSS_PORTAL_PATH."rss.xml");
if($exBuildRss !== FALSE){
	$dlBuildRss = unlink(RSS_PORTAL_PATH."rss.tmp");
	if($dlBuildRss===flase)exit("ファイル削除失敗");
}

$sitemapBuildValue = mb_convert_encoding($sitemapBuildValue,"UTF-8","EUC-JP");
fputs($buildPSitemapTmp,$sitemapBuildValue);
flock($buildPSitemapTmp,LOCK_UN);
fclose($buildPSitemapTmp);
$cpBuilSitemap = copy(RSS_PORTAL_PATH."sitemap.tmp", RSS_PORTAL_PATH."sitemap.xml");
if($cpBuilSitemap===false)exit("ファイルコピー失敗");

$exBuildSitemap = file_exists(RSS_PORTAL_PATH."sitemap.xml");
if($exBuildSitemap !== FALSE){
	$dlBuildSitemap = unlink(RSS_PORTAL_PATH."sitemap.tmp");
	if($dlBuildSitemap===flase)exit("ファイル削除失敗");
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
    <LINK rel="stylesheet" href="../share/css/diary.css" type="text/css" />
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
      <form name="form1" action="diary_main.php" method="POST"> 
        <INPUT type="hidden" name="stpos" value="<?=$_POST['stpos']?>" />
        <input type="submit" value=" 戻 る " class="btn" />
      </form>
    </div>
  </body>
</html>
