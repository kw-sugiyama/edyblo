<?
/******************************************************************************
<< 不動産ブログ　Ver.1.O.0 >>
	Name: room_upd.php
	Version: 1.0.0
	Function: 建物情報 登録／修正／削除
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
require_once ( SYS_PATH."dbif/basedb_AdminClass.php" );
require_once ( SYS_PATH."dbif/basedb_RoomClass.php" );
require_once ( SYS_PATH."dbif/basedb_ClientClass.php" );
require_once ( SYS_PATH."dbif/basedb_DiaryClass.php" );
require_once ( SYS_PATH."dbif/viewdb_BuildClass.php" );
require_once ( SYS_PATH."dbif/viewdb_ClientClass.php" );
require_once ( SYS_PATH."common/base_common.php" );
require_once ( SYS_PATH."common/sys_common.php" );
include_once ( SYS_PATH."common/error.class.php" );
require_once ( SYS_PATH."common/ImageControl.class.php" );
require_once ( SYS_PATH."common/common_ping.php" );
require_once ( SYS_PATH."configs/param_file.conf" );
require_once ( SYS_PATH."configs/param_room.conf" );
require_once ( SYS_PATH."configs/param_ping.conf" );


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
$_POST['room_cate_id'] = "/".$_POST['room_cate_id_1']."/".$_POST['room_cate_id_2']."/".$_POST['room_cate_id_3']."/".$_POST['room_cate_id_4']."/".$_POST['room_cate_id_5']."/";


if( count( $_POST['room_equip'] ) != 0){
	$equip_cnt = 0;
	FOREACH( $_POST['room_equip'] as $key => $val ){
		if($equip_cnt == 0)$_POST['room_equip_value'] .= "/";
		$_POST['room_equip_value'] .= $_POST['room_equip'][$key]."/";
		$equip_cnt++;
	}
}


$athComment = "";
$athComment .= "<INPUT TYPE=\"hidden\" NAME=\"error_mode\" VALUE=\"on\">";
FOREACH( $_POST as $key => $val ){
	if($key != "room_equip" )$val = stripslashes(htmlspecialchars($val));
        $athComment .= "<INPUT type=\"hidden\" name=\"{$key}\" value=\"{$val}\">\n";
}


asort( $param_room_floor["disp_no"] );
$madori_value = "";
FOREACH( $param_room_floor["disp_no"] as $key => $val ){
	$selected = "";
	if($param_room_floor['id'][$key] == $_POST['room_madori'])$room_madori = $param_room_floor['val'][$key];
}


asort( $param_room_trade["disp_no"] );
$trade_value = "";
FOREACH( $param_room_trade["disp_no"] as $key => $val ){
	$selected = "";
	if($param_room_trade['id'][$key] == $_POST['room_trade'])$room_trade = $param_room_trade['val'][$key];
}


asort( $param_room_face["disp_no"] );
$face_value = "";
FOREACH( $param_room_face["disp_no"] as $key => $val ){
	$selected = "";
	if($param_room_face['id'][$key] == $_POST['room_face'])$room_face = $param_room_face['val'][$key];
}


asort( $param_room_equip["disp_no"] );
$equip_value = "";
$iX = 0;
FOREACH( $param_room_equip["disp_no"] as $key => $val ){
	$iX++;
	$checked = "";
	$jX = "";
	$check_id = "";
	if($param_room_equip['val'][$key] == "その他")$check_id = "id=\"other\" onclick=\"selectOther()\"";
	for($jX==0;$jX<count($_POST['room_equip']);$jX++){
		if($param_room_equip['id'][$key] == $_POST['room_equip'][$jX])$room_equip .= $param_room_equip['val'][$key]."/";
	}
}


asort( $param_room_siki["disp_no"] );
$siki_value = "";
FOREACH( $param_room_siki["disp_no"] as $key => $val ){
	$selected = "";
	if($param_room_siki['id'][$key] == $_POST['room_siki'])$room_siki = $param_room_siki['val'][$key];
}


asort( $param_room_rei["disp_no"] );
$rei_value = "";
FOREACH( $param_room_rei["disp_no"] as $key => $val ){
	$selected = "";
	if($param_room_rei['id'][$key] == $_POST['room_rei'])$room_rei = $param_room_rei['val'][$key];
}



switch( $_POST["mode"] ){
	case 'NEW':

		// 各種画像チェック
                if( filesize($_FILES["room_layout_img"]["tmp_name"]) > (1024*1024*2) ){
			$arrOther["ath_comment"] = "<INPUT TYPE=\"hidden\" NAME=\"room_build_id\" VALUE=\"{$_POST['room_build_id']}\">";
			$arrOther["ath_comment"] .= $athComment;
                	$obj_error->ViewErrMessage( "FILE_SIZE" , "ALL" , "room_mnt.php" , $arrOther );
                        exit;
                }
                if( filesize($_FILES["room_other_img_1"]["tmp_name"]) > (1024*1024*2) ){
			$arrOther["ath_comment"] = "<INPUT TYPE=\"hidden\" NAME=\"room_build_id\" VALUE=\"{$_POST['room_build_id']}\">";
			$arrOther["ath_comment"] .= $athComment;
                        $obj_error->ViewErrMessage( "FILE_SIZE" , "ALL" , "room_mnt.php" , $arrOther );
                        exit;
                }
                if( filesize($_FILES["room_other_img_2"]["tmp_name"]) > (1024*1024*2) ){
			$arrOther["ath_comment"] = "<INPUT TYPE=\"hidden\" NAME=\"room_build_id\" VALUE=\"{$_POST['room_build_id']}\">";
			$arrOther["ath_comment"] .= $athComment;
                        $obj_error->ViewErrMessage( "FILE_SIZE" , "ALL" , "room_mnt.php" , $arrOther );
                        exit;
                }
                if( filesize($_FILES["room_other_img_3"]["tmp_name"]) > (1024*1024*2) ){
			$arrOther["ath_comment"] = "<INPUT TYPE=\"hidden\" NAME=\"room_build_id\" VALUE=\"{$_POST['room_build_id']}\">";
			$arrOther["ath_comment"] .= $athComment;
                        $obj_error->ViewErrMessage( "FILE_SIZE" , "ALL" , "room_mnt.php" , $arrOther );
                        exit;
                }
                if( filesize($_FILES["room_other_img_4"]["tmp_name"]) > (1024*1024*2) ){
			$arrOther["ath_comment"] = "<INPUT TYPE=\"hidden\" NAME=\"room_build_id\" VALUE=\"{$_POST['room_build_id']}\">";
			$arrOther["ath_comment"] .= $athComment;
                        $obj_error->ViewErrMessage( "FILE_SIZE" , "ALL" , "room_mnt.php" , $arrOther );
                        exit;
                }
		IF( is_uploaded_file( $_FILES["room_layout_img"]["tmp_name"] ) ){
			$imageInfo = @getimagesize( $_FILES["room_layout_img"]["tmp_name"] );
			IF( @getimagesize( $_FILES["room_layout_img"]["tmp_name"] ) === FALSE || ( $imageInfo[2] != 1 && $imageInfo[2] != 2 ) ){
				$arrOther["ath_comment"] = "<INPUT TYPE=\"hidden\" NAME=\"room_build_id\" VALUE=\"{$_POST['room_build_id']}\">";
				$arrOther["ath_comment"] .= $athComment;
                        	$obj_error->ViewErrMessage( "NOT_IMG" , "ALL" , "room_mnt.php" , $arrOther );
                        	exit;
			}
			$kakuLayout = split("\.",$_FILES["room_layout_img"]["name"]);
			$layout_img_org = "layout_".$_SESSION['_cl_id']."_/.".$kakuLayout[1];
		}
		IF( is_uploaded_file( $_FILES["room_other_img_1"]["tmp_name"] ) ){
			$imageInfo = @getimagesize( $_FILES["room_other_img_1"]["tmp_name"] );
			IF( @getimagesize( $_FILES["room_other_img_1"]["tmp_name"] ) === FALSE || ( $imageInfo[2] != 1 && $imageInfo[2] != 2 ) ){
				$arrOther["ath_comment"] = "<INPUT TYPE=\"hidden\" NAME=\"room_build_id\" VALUE=\"{$_POST['room_build_id']}\">";
				$arrOther["ath_comment"] .= $athComment;
                        	$obj_error->ViewErrMessage( "NOT_IMG" , "ALL" , "room_mnt.php" , $arrOther );
                        	exit;
			}
			$kakuOther1 = split("\.",$_FILES["room_other_img_1"]["name"]);
			$room_other_img_org1 = "room_".$_SESSION['_cl_id']."_/_1.".$kakuOther1[1];
		}
		IF( is_uploaded_file( $_FILES["room_other_img_2"]["tmp_name"] ) ){
			$imageInfo = @getimagesize( $_FILES["room_other_img_2"]["tmp_name"] );
			IF( @getimagesize( $_FILES["room_other_img_2"]["tmp_name"] ) === FALSE || ( $imageInfo[2] != 1 && $imageInfo[2] != 2 ) ){
				$arrOther["ath_comment"] = "<INPUT TYPE=\"hidden\" NAME=\"room_build_id\" VALUE=\"{$_POST['room_build_id']}\">";
				$arrOther["ath_comment"] .= $athComment;
                        	$obj_error->ViewErrMessage( "NOT_IMG" , "ALL" , "room_mnt.php" , $arrOther );
                        	exit;
			}
			$kakuOther2 = split("\.",$_FILES["room_other_img_2"]["name"]);
			$room_other_img_org2 = "room_".$_SESSION['_cl_id']."_/_2.".$kakuOther2[1];
		}
		IF( is_uploaded_file( $_FILES["room_other_img_3"]["tmp_name"] ) ){
			$imageInfo = @getimagesize( $_FILES["room_other_img_3"]["tmp_name"] );
			IF( @getimagesize( $_FILES["room_other_img_3"]["tmp_name"] ) === FALSE || ( $imageInfo[2] != 1 && $imageInfo[2] != 2 ) ){
				$arrOther["ath_comment"] = "<INPUT TYPE=\"hidden\" NAME=\"room_build_id\" VALUE=\"{$_POST['room_build_id']}\">";
				$arrOther["ath_comment"] .= $athComment;
                        	$obj_error->ViewErrMessage( "NOT_IMG" , "ALL" , "room_mnt.php" , $arrOther );
                        	exit;
			}
			$kakuOther3 = split("\.",$_FILES["room_other_img_3"]["name"]);
			$room_other_img_org3 = "room_".$_SESSION['_cl_id']."_/_3.".$kakuOther3[1];
		}
		IF( is_uploaded_file( $_FILES["room_other_img_4"]["tmp_name"] ) ){
			$imageInfo = @getimagesize( $_FILES["room_other_img_4"]["tmp_name"] );
			IF( @getimagesize( $_FILES["room_other_img_4"]["tmp_name"] ) === FALSE || ( $imageInfo[2] != 1 && $imageInfo[2] != 2 ) ){
				$arrOther["ath_comment"] = "<INPUT TYPE=\"hidden\" NAME=\"room_build_id\" VALUE=\"{$_POST['room_build_id']}\">";
				$arrOther["ath_comment"] .= $athComment;
                        	$obj_error->ViewErrMessage( "NOT_IMG" , "ALL" , "room_mnt.php" , $arrOther );
                        	exit;
			}
			$kakuOther4 = split("\.",$_FILES["room_other_img_4"]["name"]);
			$room_other_img_org4 = "room_".$_SESSION['_cl_id']."_/_4.".$kakuOther4[1];
		}
		
		
		// DBIFへ入れ込み
		$obj_new = new basedb_RoomClassTblAccess;
		$obj_new->conn = $obj_conn->conn;
		$obj_new->roomdat[0]["room_build_id"] = $_POST["room_build_id"];
		$obj_new->roomdat[0]["room_cate_id"] = $_POST['room_cate_id'];
		$obj_new->roomdat[0]["room_code"] = $_POST["room_code"];
		$obj_new->roomdat[0]["room_madori"] = $_POST["room_madori"];
		$obj_new->roomdat[0]["room_madori_detail"] = $_POST["room_madori_detail"];
		$obj_new->roomdat[0]["room_price"] = $_POST["room_price"];
		$obj_new->roomdat[0]["room_cntrl_price"] = $_POST["room_cntrl_price"];
		$obj_new->roomdat[0]["room_siki"] = $_POST["room_siki"];
		$obj_new->roomdat[0]["room_rei"] = $_POST["room_rei"];
		$obj_new->roomdat[0]["room_syou"] = $_POST["room_syou"];
		$obj_new->roomdat[0]["room_sikibiki"] = $_POST["room_sikibiki"];
		$obj_new->roomdat[0]["room_sec_price"] = $_POST["room_sec_price"];
		$obj_new->roomdat[0]["room_contract"] = $_POST["room_contract"];
		$obj_new->roomdat[0]["room_upd_price"] = $_POST["room_upd_price"];
		$obj_new->roomdat[0]["room_upd_year"] = $_POST["room_upd_year"];
		$obj_new->roomdat[0]["room_area"] = $_POST["room_area"];
		$obj_new->roomdat[0]["room_floor"] = $_POST["room_floor"];
		$obj_new->roomdat[0]["room_face"] = $_POST["room_face"];
		IF( is_uploaded_file($_FILES["room_layout_img"]["tmp_name"]) ){
			$obj_new->roomdat[0]["room_layout_img_org"] = $_FILES["room_layout_img"]["name"];
			$obj_new->roomdat[0]["room_layout_img"] = $layout_img_org;
		}
		$obj_new->roomdat[0]["room_other_img_1_del_chk"] = $_POST["room_other_img_1_del_chk"];
		IF( is_uploaded_file($_FILES["room_other_img_1"]["tmp_name"]) ){
			$obj_new->roomdat[0]["room_other_img_org_1"] = $_FILES["room_other_img_1"]["name"];
			$obj_new->roomdat[0]["room_other_img_1"] = $room_other_img_org1;
		}
		$obj_new->roomdat[0]["room_other_img_2_del_chk"] = $_POST["room_other_img_2_del_chk"];
		IF( is_uploaded_file($_FILES["room_other_img_2"]["tmp_name"]) ){
			$obj_new->roomdat[0]["room_other_img_org_2"] = $_FILES["room_other_img_2"]["name"];
			$obj_new->roomdat[0]["room_other_img_2"] = $room_other_img_org2;
		}
		$obj_new->roomdat[0]["room_other_img_3_del_chk"] = $_POST["room_other_img_3_del_chk"];
		IF( is_uploaded_file($_FILES["room_other_img_3"]["tmp_name"]) ){
			$obj_new->roomdat[0]["room_other_img_org_3"] = $_FILES["room_other_img_3"]["name"];
			$obj_new->roomdat[0]["room_other_img_3"] = $room_other_img_org3;
		}
		$obj_new->roomdat[0]["room_other_img_4_del_chk"] = $_POST["room_other_img_4_del_chk"];
		IF( is_uploaded_file($_FILES["room_other_img_4"]["tmp_name"]) ){
			$obj_new->roomdat[0]["room_other_img_org_4"] = $_FILES["room_other_img_4"]["name"];
			$obj_new->roomdat[0]["room_other_img_4"] = $room_other_img_org4;
		}
		$obj_new->roomdat[0]["room_equip"] = $_POST['room_equip_value'];
		$obj_new->roomdat[0]["room_equip_other"] = $_POST["room_equip_other"];
		$obj_new->roomdat[0]["room_move_date"] = $_POST["room_move_date"];
		$obj_new->roomdat[0]["room_now_move"] = $_POST["room_now_move"];
		$obj_new->roomdat[0]["room_trade"] = $_POST["room_trade"];
		$obj_new->roomdat[0]["room_pr"] = $_POST["room_pr"];
		$obj_new->roomdat[0]["room_vacant"] = $_POST["room_vacant"];
		$obj_new->roomdat[0]["room_biko_1"] = $_POST["room_code"]."/".$room_madori."/".$_POST["room_madori_detail"]."/".$_POST["room_price"]."円/".$_POST["room_cntrl_price"]."円/".$room_siki."ヶ月/".$room_rei."ヶ月/".$_POST["room_syou"]."円/".$_POST["room_sikibiki"]."円/".$_POST["room_sec_price"]."円/".$_POST["room_contract"]."年/".$_POST["room_upd_price"]."円/".$_POST["room_area"]."��/".$_POST["room_floor"]."階/".$room_face."向き/".$room_equip."/".$_POST["room_equip_other"]."/".$room_now_move."/".$room_trade."/".$_POST["room_pr"];
		$obj_new->roomdat[0]["room_biko_2"] = $_POST["p_pub_flg"];
		$obj_new->roomdat[0]["room_biko_3"] = $_POST["room_flg"];
		$obj_new->roomdat[0]["room_biko_4"] = $_POST["room_biko_4"];
		$obj_new->roomdat[0]["room_biko_5"] = $_POST["room_biko_5"];
		if($_POST["room_start_year"] == "" || $_POST["room_start_month"] == "" || $_POST["room_start_day"] == ""){
			$obj_new->roomdat[0]["room_start_date"] = "";
		}else{
			$obj_new->roomdat[0]["room_start_date"] = $_POST["room_start_year"]."-".$_POST["room_start_month"]."-".$_POST["room_start_day"]." 00:00:00";
		}
		if($_POST["room_end_year"] == "" || $_POST["room_end_month"] == "" || $_POST["room_end_day"] == ""){
			$obj_new->roomdat[0]["room_end_date"] = "";
		}else{
			$obj_new->roomdat[0]["room_end_date"] = $_POST["room_end_year"]."-".$_POST["room_end_month"]."-".$_POST["room_end_day"]." 00:00:00";
		}
		$obj_new->roomdat[0]["room_disp_no"] = 1;
		$obj_new->roomdat[0]["room_siki_unit"] = $_POST["room_siki_unit"];
		$obj_new->roomdat[0]["room_rei_unit"] = $_POST["room_rei_unit"];
		$obj_new->roomdat[0]["room_syou_unit"] = $_POST["room_syou_unit"];
		$obj_new->roomdat[0]["room_sikibiki_unit"] = $_POST["room_sikibiki_unit"];
		$obj_new->roomdat[0]["room_sec_price_unit"] = $_POST["room_sec_price_unit"];
		$obj_new->roomdat[0]["room_upd_price_unit"] = $_POST["room_upd_price_unit"];
		$obj_new->roomdat[0]["room_cntrl_price_unit"] = $_POST["room_cntrl_price_unit"];
		$obj_new->roomdat[0]["room_other_price"] = $_POST["room_other_price"];
		$obj_new->roomdat[0]["room_admin_id"] = NULL;
		$suc = $obj_new->basedb_InsRoom();
		IF( $suc == "0" ){
			// 画像保存・削除処理
			IF( is_uploaded_file( $_FILES["room_layout_img"]["tmp_name"] ) ){
				// 一度画像を削除==>再度コピー
				IF( file_exists($param_room_layout_path.$_POST['room_layout_lastupd'] ) && $_POST['room_layout_lastupd'] != "" ){
					unlink( $param_room_layout_path.$_POST['room_layout_lastupd'] );
				}
				// 同じ名前で、UPLOADされたデータをコピー
				IF( is_uploaded_file($_FILES["room_layout_img"]["tmp_name"]) && $obj_new->roomdat[0]["room_layout_img"] != "" ){
					move_uploaded_file( $_FILES["room_layout_img"]["tmp_name"] , $param_room_layout_path.$obj_new->roomdat[0]["room_layout_img"] );
					chmod( $param_room_layout_path.$obj_new->roomdat[0]["room_layout_img"] , 0755 );
				}

				$obj_layout_new = new ImageControl;
				$obj_layout_new->max_w = 500;
				$obj_layout_new->max_h = 500;
				$obj_layout_new->origin_dir = $param_room_layout_path;
				$obj_layout_new->origin_img = $obj_new->roomdat[0]["room_layout_img"];
				$obj_layout_new->gd_ver = 1;
				list($resize_layout_new,$imageType) = $obj_layout_new->ImageResizeSave();
				if($resize_layout_new == -1){
	                        	$obj_error->ViewErrMessage( "SYSTEM" , "ALL" , "blog_mnt.php" , $arrOther  );
	                       		exit;
				}

				$obj_layout_save_new = new ImageControl;
				$obj_layout_save_new->origin_dir = $param_room_layout_path;
				$obj_layout_save_new->origin_img = $obj_new->roomdat[0]["room_layout_img"];
				$obj_layout_save_new->imageResource = $resize_layout_new;
				$layout_suc_new = $obj_layout_save_new->ImageSave($imageType);
				if($layout_suc_new == -1){
	                        	$obj_error->ViewErrMessage( "SYSTEM" , "ALL" , "blog_mnt.php" , $arrOther  );
	                       		exit;
				}
			}
			IF( is_uploaded_file( $_FILES["room_other_img_1"]["tmp_name"] ) ){
				// 一度画像を削除==>再度コピー
				IF( file_exists($$param_room_other_img_1_path.$_POST['room_other_1_lastupd'] ) && $_POST['room_other_1_lastupd'] != "" ){
					unlink( $$param_room_other_img_1_path.$_POST['room_other_1_lastupd'] );
				}
				// 同じ名前で、UPLOADされたデータをコピー
				IF( is_uploaded_file($_FILES["room_other_img_1"]["tmp_name"]) && $obj_new->roomdat[0]["room_other_img_1"] != "" ){
					move_uploaded_file( $_FILES["room_other_img_1"]["tmp_name"] , $param_room_other_img_1_path.$obj_new->roomdat[0]["room_other_img_1"] );
					chmod( $param_room_other_img_1_path.$obj_new->roomdat[0]["room_other_img_1"] , 0755 );
				}

				$obj_other_1_new = new ImageControl;
				$obj_other_1_new->max_w = 300;
				$obj_other_1_new->max_h = 300;
				$obj_other_1_new->origin_dir = $param_room_other_img_1_path;
				$obj_other_1_new->origin_img = $obj_new->roomdat[0]["room_other_img_1"];
				$obj_other_1_new->gd_ver = 1;
				list($resize_other_1,$imageType) = $obj_other_1_new->ImageResizeSave();
				if($resize_other_1 == -1){
	                        	$obj_error->ViewErrMessage( "SYSTEM" , "ALL" , "blog_mnt.php" , $arrOther  );
	                       		exit;
				}

				$obj_other_1_save_new = new ImageControl;
				$obj_other_1_save_new->origin_dir = $param_room_other_img_1_path;
				$obj_other_1_save_new->origin_img = $obj_new->roomdat[0]["room_other_img_1"];
				$obj_other_1_save_new->imageResource = $resize_other_1;
				$other_1_suc = $obj_other_1_save_new->ImageSave($imageType);
				if($other_1_suc == -1){
	                        	$obj_error->ViewErrMessage( "SYSTEM" , "ALL" , "blog_mnt.php" , $arrOther  );
	                       		exit;
				}
			}
			IF( is_uploaded_file( $_FILES["room_other_img_2"]["tmp_name"] ) ){
				// 一度画像を削除==>再度コピー
				IF( file_exists($param_room_other_img_2_path.$_POST['room_other_2_lastupd'] ) && $_POST['room_other_2_lastupd'] != "" ){
					unlink( $param_room_other_img_2_path.$_POST['room_other_2_lastupd'] );
				}
				// 同じ名前で、UPLOADされたデータをコピー
				IF( is_uploaded_file($_FILES["room_other_img_2"]["tmp_name"]) && $obj_new->roomdat[0]["room_other_img_2"] != "" ){
					move_uploaded_file( $_FILES["room_other_img_2"]["tmp_name"] , $param_room_other_img_2_path.$obj_new->roomdat[0]["room_other_img_2"] );
					chmod( $param_room_other_img_2_path.$obj_new->roomdat[0]["room_other_img_2"] , 0755 );
				}

				$obj_other_2_new = new ImageControl;
				$obj_other_2_new->max_w = 300;
				$obj_other_2_new->max_h = 300;
				$obj_other_2_new->origin_dir = $param_room_other_img_2_path;
				$obj_other_2_new->origin_img = $obj_new->roomdat[0]["room_other_img_2"];
				$obj_other_2_new->gd_ver = 1;
				list($resize_other_2,$imageType) = $obj_other_2_new->ImageResizeSave();
				if($resize_other_2 == -1){
	                        	$obj_error->ViewErrMessage( "SYSTEM" , "ALL" , "blog_mnt.php" , $arrOther  );
	                       		exit;
				}

				$obj_other_2_save_new = new ImageControl;
				$obj_other_2_save_new->origin_dir = $param_room_other_img_2_path;
				$obj_other_2_save_new->origin_img = $obj_new->roomdat[0]["room_other_img_2"];
				$obj_other_2_save_new->imageResource = $resize_other_2;
				$other_2_suc = $obj_other_2_save_new->ImageSave($imageType);
				if($other_2_suc == -1){
	                        	$obj_error->ViewErrMessage( "SYSTEM" , "ALL" , "blog_mnt.php" , $arrOther  );
	                       		exit;
				}
			}
			IF( is_uploaded_file( $_FILES["room_other_img_3"]["tmp_name"] ) ){
				// 一度画像を削除==>再度コピー
				IF( file_exists($param_room_other_img_3_path.$_POST['room_other_3_lastupd'] ) && $_POST['room_other_3_lastupd'] != "" ){
					unlink( $param_room_other_img_3_path.$_POST['room_other_3_lastupd'] );
				}
				// 同じ名前で、UPLOADされたデータをコピー
				IF( is_uploaded_file($_FILES["room_other_img_3"]["tmp_name"]) && $obj_new->roomdat[0]["room_other_img_3"] != "" ){
					move_uploaded_file( $_FILES["room_other_img_3"]["tmp_name"] , $param_room_other_img_3_path.$obj_new->roomdat[0]["room_other_img_3"] );
					chmod( $param_room_other_img_3_path.$obj_new->roomdat[0]["room_other_img_3"] , 0755 );
				}

				$obj_other_3_new = new ImageControl;
				$obj_other_3_new->max_w = 300;
				$obj_other_3_new->max_h = 300;
				$obj_other_3_new->origin_dir = $param_room_other_img_3_path;
				$obj_other_3_new->origin_img = $obj_new->roomdat[0]["room_other_img_3"];
				$obj_other_3_new->gd_ver = 1;
				list($resize_other_3,$imageType) = $obj_other_3_new->ImageResizeSave();
				if($resize_other_3 == -1){
	                        	$obj_error->ViewErrMessage( "SYSTEM" , "ALL" , "blog_mnt.php" , $arrOther  );
	                       		exit;
				}

				$obj_other_3_save_new = new ImageControl;
				$obj_other_3_save_new->origin_dir = $param_room_other_img_3_path;
				$obj_other_3_save_new->origin_img = $obj_new->roomdat[0]["room_other_img_3"];
				$obj_other_3_save_new->imageResource = $resize_other_3;
				$other_3_suc = $obj_other_3_save_new->ImageSave($imageType);
				if($other_3_suc == -1){
	                        	$obj_error->ViewErrMessage( "SYSTEM" , "ALL" , "blog_mnt.php" , $arrOther  );
	                       		exit;
				}
			}
			IF( is_uploaded_file( $_FILES["room_other_img_4"]["tmp_name"] ) ){
				// 一度画像を削除==>再度コピー
				IF( file_exists($param_room_other_img_4_path.$_POST['room_other_4_lastupd'] ) && $_POST['room_other_4_lastupd'] != "" ){
					unlink( $param_room_other_img_4_path.$_POST['room_other_4_lastupd'] );
				}
				// 同じ名前で、UPLOADされたデータをコピー
				IF( is_uploaded_file($_FILES["room_other_img_4"]["tmp_name"]) && $obj_new->roomdat[0]["room_other_img_4"] != "" ){
					move_uploaded_file( $_FILES["room_other_img_4"]["tmp_name"] , $param_room_other_img_4_path.$obj_new->roomdat[0]["room_other_img_4"] );
					chmod( $param_room_other_img_4_path.$obj_new->roomdat[0]["room_other_img_4"] , 0755 );
				}

				$obj_other_4_new = new ImageControl;
				$obj_other_4_new->max_w = 300;
				$obj_other_4_new->max_h = 300;
				$obj_other_4_new->origin_dir = $param_room_other_img_4_path;
				$obj_other_4_new->origin_img = $obj_new->roomdat[0]["room_other_img_4"];
				$obj_other_4_new->gd_ver = 1;
				list($resize_other_4,$imageType) = $obj_other_4_new->ImageResizeSave();
				if($resize_other_4 == -1){
	                        	$obj_error->ViewErrMessage( "SYSTEM" , "ALL" , "blog_mnt.php" , $arrOther  );
	                       		exit;
				}

				$obj_other_4_save_new = new ImageControl;
				$obj_other_4_save_new->origin_dir = $param_room_other_img_4_path;
				$obj_other_4_save_new->origin_img = $obj_new->roomdat[0]["room_other_img_4"];
				$obj_other_4_save_new->imageResource = $resize_other_4;
				$other_4_suc = $obj_other_4_save_new->ImageSave($imageType);
				if($other_4_suc == -1){
	                        	$obj_error->ViewErrMessage( "SYSTEM" , "ALL" , "blog_mnt.php" , $arrOther  );
	                       		exit;
				}
			}
		}
		if( $suc == -1 ){
			$arrOther["ath_comment"] = "<INPUT TYPE=\"hidden\" NAME=\"room_build_id\" VALUE=\"{$_POST['room_build_id']}\">";
			$arrOther["ath_comment"] .= "<INPUT TYPE=\"hidden\" NAME=\"room_stpos\" VALUE=\"{$_POST['room_stpos']}\">";
			$arrOther["ath_comment"] .= "<INPUT TYPE=\"hidden\" NAME=\"stpos\" VALUE=\"{$_POST['stpos']}\">";
			$arrOther["ath_comment"] .= $athComment;
			$obj_error->ViewErrMessage( "INS_ERROR" , "ALL" , "room_mnt.php" , $arrOther );
                        exit;
		}
		if( $suc == 2 ){
			$arrOther["ath_comment"] = "<INPUT TYPE=\"hidden\" NAME=\"room_build_id\" VALUE=\"{$_POST['room_build_id']}\">";
			$arrOther["ath_comment"] .= "<INPUT TYPE=\"hidden\" NAME=\"room_stpos\" VALUE=\"{$_POST['room_stpos']}\">";
			$arrOther["ath_comment"] .= "<INPUT TYPE=\"hidden\" NAME=\"stpos\" VALUE=\"{$_POST['stpos']}\">";
			$arrOther["ath_comment"] .= $athComment;
			$obj_error->ViewErrMessage( "DISP_NO" , "ALL" , "room_mnt.php" , $arrOther );
                        exit;
                }
		$message = "部屋情報を登録しました。";
		break;
		
		
	case 'EDIT':
		// ロゴ画像
                if( filesize($_FILES["room_layout_img"]["tmp_name"]) > (1024*1024*2) ){
			$arrOther["ath_comment"] = "<INPUT TYPE=\"hidden\" NAME=\"room_build_id\" VALUE=\"{$_POST['room_build_id']}\">";
			$arrOther["ath_comment"] .= $athComment;
                	$obj_error->ViewErrMessage( "FILE_SIZE" , "ALL" , "room_mnt.php" , $arrOther );
                        exit;
                }
                if( filesize($_FILES["room_other_img_1"]["tmp_name"]) > (1024*1024*2) ){
			$arrOther["ath_comment"] = "<INPUT TYPE=\"hidden\" NAME=\"room_build_id\" VALUE=\"{$_POST['room_build_id']}\">";
			$arrOther["ath_comment"] .= $athComment;
                        $obj_error->ViewErrMessage( "FILE_SIZE" , "ALL" , "room_mnt.php" , $arrOther );
                        exit;
                }
                if( filesize($_FILES["room_other_img_2"]["tmp_name"]) > (1024*1024*2) ){
			$arrOther["ath_comment"] = "<INPUT TYPE=\"hidden\" NAME=\"room_build_id\" VALUE=\"{$_POST['room_build_id']}\">";
			$arrOther["ath_comment"] .= $athComment;
                        $obj_error->ViewErrMessage( "FILE_SIZE" , "ALL" , "room_mnt.php" , $arrOther );
                        exit;
                }
                if( filesize($_FILES["room_other_img_3"]["tmp_name"]) > (1024*1024*2) ){
			$arrOther["ath_comment"] = "<INPUT TYPE=\"hidden\" NAME=\"room_build_id\" VALUE=\"{$_POST['room_build_id']}\">";
			$arrOther["ath_comment"] .= $athComment;
                        $obj_error->ViewErrMessage( "FILE_SIZE" , "ALL" , "room_mnt.php" , $arrOther );
                        exit;
                }
                if( filesize($_FILES["room_other_img_4"]["tmp_name"]) > (1024*1024*2) ){
			$arrOther["ath_comment"] = "<INPUT TYPE=\"hidden\" NAME=\"room_build_id\" VALUE=\"{$_POST['room_build_id']}\">";
			$arrOther["ath_comment"] .= $athComment;
                        $obj_error->ViewErrMessage( "FILE_SIZE" , "ALL" , "room_mnt.php" , $arrOther );
                        exit;
                }
		IF( is_uploaded_file( $_FILES["room_layout_img"]["tmp_name"] ) ){
			$imageInfo = @getimagesize( $_FILES["room_layout_img"]["tmp_name"] );
			IF( @getimagesize( $_FILES["room_layout_img"]["tmp_name"] ) === FALSE || ( $imageInfo[2] != 1 && $imageInfo[2] != 2 ) ){
				$arrOther["ath_comment"] = "<INPUT TYPE=\"hidden\" NAME=\"room_build_id\" VALUE=\"{$_POST['room_build_id']}\">";
				$arrOther["ath_comment"] .= $athComment;
	                	$obj_error->ViewErrMessage( "NOT_IMG" , "ALL" , "room_mnt.php" , $arrOther );
	                        exit;
			}
			$kakuLayout = split("\.",$_FILES["room_layout_img"]["name"]);
			$layout_img_org = "layout_".$_SESSION['_cl_id']."_".$_POST["room_id"].".".$kakuLayout[1];
		}
		IF( is_uploaded_file( $_FILES["room_other_img_1"]["tmp_name"] ) ){
			$imageInfo = @getimagesize( $_FILES["room_other_img_1"]["tmp_name"] );
			IF( @getimagesize( $_FILES["room_other_img_1"]["tmp_name"] ) === FALSE || ( $imageInfo[2] != 1 && $imageInfo[2] != 2 ) ){
				$arrOther["ath_comment"] = "<INPUT TYPE=\"hidden\" NAME=\"room_build_id\" VALUE=\"{$_POST['room_build_id']}\">";
				$arrOther["ath_comment"] .= $athComment;
	                	$obj_error->ViewErrMessage( "NOT_IMG" , "ALL" , "room_mnt.php" , $arrOther );
	                        exit;
			}
			$kakuOther1 = split("\.",$_FILES["room_other_img_1"]["name"]);
			$room_other_img_org1 = "room_".$_SESSION['_cl_id']."_".$_POST["room_id"]."_1.".$kakuOther1[1];
		}
		IF( is_uploaded_file( $_FILES["room_other_img_2"]["tmp_name"] ) ){
			$imageInfo = @getimagesize( $_FILES["room_other_img_2"]["tmp_name"] );
			IF( @getimagesize( $_FILES["room_other_img_2"]["tmp_name"] ) === FALSE || ( $imageInfo[2] != 1 && $imageInfo[2] != 2 ) ){
				$arrOther["ath_comment"] = "<INPUT TYPE=\"hidden\" NAME=\"room_build_id\" VALUE=\"{$_POST['room_build_id']}\">";
				$arrOther["ath_comment"] .= $athComment;
	                	$obj_error->ViewErrMessage( "NOT_IMG" , "ALL" , "room_mnt.php" , $arrOther );
	                        exit;
			}
			$kakuOther2 = split("\.",$_FILES["room_other_img_2"]["name"]);
			$room_other_img_org2 = "room_".$_SESSION['_cl_id']."_".$_POST["room_id"]."_2.".$kakuOther2[1];
		}
		IF( is_uploaded_file( $_FILES["room_other_img_3"]["tmp_name"] ) ){
			$imageInfo = @getimagesize( $_FILES["room_other_img_3"]["tmp_name"] );
			IF( @getimagesize( $_FILES["room_other_img_3"]["tmp_name"] ) === FALSE || ( $imageInfo[2] != 1 && $imageInfo[2] != 2 ) ){
				$arrOther["ath_comment"] = "<INPUT TYPE=\"hidden\" NAME=\"room_build_id\" VALUE=\"{$_POST['room_build_id']}\">";
				$arrOther["ath_comment"] .= $athComment;
	                	$obj_error->ViewErrMessage( "NOT_IMG" , "ALL" , "room_mnt.php" , $arrOther );
	                        exit;
			}
			$kakuOther3 = split("\.",$_FILES["room_other_img_3"]["name"]);
			$room_other_img_org3 = "room_".$_SESSION['_cl_id']."_".$_POST["room_id"]."_3.".$kakuOther3[1];
		}
		IF( is_uploaded_file( $_FILES["room_other_img_4"]["tmp_name"] ) ){
			$imageInfo = @getimagesize( $_FILES["room_other_img_4"]["tmp_name"] );
			IF( @getimagesize( $_FILES["room_other_img_4"]["tmp_name"] ) === FALSE || ( $imageInfo[2] != 1 && $imageInfo[2] != 2 ) ){
				$arrOther["ath_comment"] = "<INPUT TYPE=\"hidden\" NAME=\"room_build_id\" VALUE=\"{$_POST['room_build_id']}\">";
				$arrOther["ath_comment"] .= $athComment;
	                	$obj_error->ViewErrMessage( "NOT_IMG" , "ALL" , "room_mnt.php" , $arrOther );
	                        exit;
			}
			$kakuOther4 = split("\.",$_FILES["room_other_img_4"]["name"]);
			$room_other_img_org4 = "room_".$_SESSION['_cl_id']."_".$_POST["room_id"]."_4.".$kakuOther4[1];
		}


		$obj_rev = new basedb_RoomClassTblAccess;
		$obj_rev->conn = $obj_conn->conn;
		$obj_rev->roomdat[0]["room_id"] = $_POST["room_id"];
		$obj_rev->roomdat[0]["room_build_id"] = $_POST["room_build_id"];
		$obj_rev->roomdat[0]["room_cate_id"] = $_POST["room_cate_id"];
		$obj_rev->roomdat[0]["room_code"] = $_POST["room_code"];
		$obj_rev->roomdat[0]["room_madori"] = $_POST["room_madori"];
		$obj_rev->roomdat[0]["room_madori_detail"] = $_POST["room_madori_detail"];
		$obj_rev->roomdat[0]["room_price"] = $_POST["room_price"];
		$obj_rev->roomdat[0]["room_cntrl_price"] = $_POST["room_cntrl_price"];
		$obj_rev->roomdat[0]["room_siki"] = $_POST["room_siki"];
		$obj_rev->roomdat[0]["room_rei"] = $_POST["room_rei"];
		$obj_rev->roomdat[0]["room_syou"] = $_POST["room_syou"];
		$obj_rev->roomdat[0]["room_sikibiki"] = $_POST["room_sikibiki"];
		$obj_rev->roomdat[0]["room_sec_price"] = $_POST["room_sec_price"];
		$obj_rev->roomdat[0]["room_contract"] = $_POST["room_contract"];
		$obj_rev->roomdat[0]["room_upd_price"] = $_POST["room_upd_price"];
		$obj_rev->roomdat[0]["room_upd_year"] = $_POST["room_upd_year"];
		$obj_rev->roomdat[0]["room_area"] = $_POST["room_area"];
		$obj_rev->roomdat[0]["room_floor"] = $_POST["room_floor"];
		$obj_rev->roomdat[0]["room_face"] = $_POST["room_face"];
		IF( is_uploaded_file($_FILES["room_layout_img"]["tmp_name"]) ){
			$obj_rev->roomdat[0]["room_layout_img_org"] = $_FILES["room_layout_img"]["name"];
			$obj_rev->roomdat[0]["room_layout_img"] = $layout_img_org;
		}
		$obj_rev->roomdat[0]["room_other_img_1_del_chk"] = $_POST["room_other_img_1_del_chk"];
		IF( is_uploaded_file($_FILES["room_other_img_1"]["tmp_name"]) ){
			$obj_rev->roomdat[0]["room_other_img_org_1"] = $_FILES["room_other_img_1"]["name"];
			$obj_rev->roomdat[0]["room_other_img_1"] = $room_other_img_org1;
		}
		$obj_rev->roomdat[0]["room_other_img_2_del_chk"] = $_POST["room_other_img_2_del_chk"];
		IF( is_uploaded_file($_FILES["room_other_img_2"]["tmp_name"]) ){
			$obj_rev->roomdat[0]["room_other_img_org_2"] = $_FILES["room_other_img_2"]["name"];
			$obj_rev->roomdat[0]["room_other_img_2"] = $room_other_img_org2;
		}
		$obj_rev->roomdat[0]["room_other_img_3_del_chk"] = $_POST["room_other_img_3_del_chk"];
		IF( is_uploaded_file($_FILES["room_other_img_3"]["tmp_name"]) ){
			$obj_rev->roomdat[0]["room_other_img_org_3"] = $_FILES["room_other_img_3"]["name"];
			$obj_rev->roomdat[0]["room_other_img_3"] = $room_other_img_org3;
		}
		$obj_rev->roomdat[0]["room_other_img_4_del_chk"] = $_POST["room_other_img_4_del_chk"];
		IF( is_uploaded_file($_FILES["room_other_img_4"]["tmp_name"]) ){
			$obj_rev->roomdat[0]["room_other_img_org_4"] = $_FILES["room_other_img_4"]["name"];
			$obj_rev->roomdat[0]["room_other_img_4"] = $room_other_img_org4;
		}
		$obj_rev->roomdat[0]["room_equip"] = $_POST["room_equip_value"];
		$obj_rev->roomdat[0]["room_equip_other"] = $_POST["room_equip_other"];
		$obj_rev->roomdat[0]["room_move_date"] = $_POST["room_move_date"];
		$obj_rev->roomdat[0]["room_now_move"] = $_POST["room_now_move"];
		$obj_rev->roomdat[0]["room_trade"] = $_POST["room_trade"];
		$obj_rev->roomdat[0]["room_pr"] = $_POST["room_pr"];
		$obj_rev->roomdat[0]["room_vacant"] = $_POST["room_vacant"];
		$obj_rev->roomdat[0]["room_biko_1"] = $_POST["room_code"]."/".$room_madori."/".$_POST["room_madori_detail"]."/".$_POST["room_price"]."円/".$_POST["room_cntrl_price"]."円/".$room_siki."ヶ月/".$room_rei."ヶ月/".$_POST["room_syou"]."円/".$_POST["room_sikibiki"]."円/".$_POST["room_sec_price"]."円/".$_POST["room_contract"]."年/".$_POST["room_upd_price"]."円/".$_POST["room_area"]."��/".$_POST["room_floor"]."階/".$room_face."向き/".$room_equip."/".$_POST["room_equip_other"]."/".$room_now_move."/".$room_trade."/".$_POST["room_pr"];
		$obj_rev->roomdat[0]["room_biko_2"] = $_POST["p_pub_flg"];
		$obj_rev->roomdat[0]["room_biko_3"] = $_POST["room_flg"];
		$obj_rev->roomdat[0]["room_biko_4"] = $_POST["room_biko_4"];
		$obj_rev->roomdat[0]["room_biko_5"] = $_POST["room_biko_5"];
		if($_POST["room_start_year"] == "" || $_POST["room_start_month"] == "" || $_POST["room_start_day"] == ""){
			$obj_rev->roomdat[0]["room_start_date"] = "";
		}else{
			$obj_rev->roomdat[0]["room_start_date"] = $_POST["room_start_year"]."-".$_POST["room_start_month"]."-".$_POST["room_start_day"]." 00:00:00";
		}
		if($_POST["room_end_year"] == "" || $_POST["room_end_month"] == "" || $_POST["room_end_day"] == ""){
			$obj_rev->roomdat[0]["room_end_date"] = "";
		}else{
			$obj_rev->roomdat[0]["room_end_date"] = $_POST["room_end_year"]."-".$_POST["room_end_month"]."-".$_POST["room_end_day"]." 00:00:00";
		}
		$obj_rev->roomdat[0]["room_disp_no"] = 1;
		$obj_rev->roomdat[0]["room_siki_unit"] = $_POST["room_siki_unit"];
		$obj_rev->roomdat[0]["room_rei_unit"] = $_POST["room_rei_unit"];
		$obj_rev->roomdat[0]["room_syou_unit"] = $_POST["room_syou_unit"];
		$obj_rev->roomdat[0]["room_sikibiki_unit"] = $_POST["room_sikibiki_unit"];
		$obj_rev->roomdat[0]["room_sec_price_unit"] = $_POST["room_sec_price_unit"];
		$obj_rev->roomdat[0]["room_upd_price_unit"] = $_POST["room_upd_price_unit"];
		$obj_rev->roomdat[0]["room_cntrl_price_unit"] = $_POST["room_cntrl_price_unit"];
		$obj_rev->roomdat[0]["room_other_price"] = $_POST["room_other_price"];
		$obj_rev->roomdat[0]["room_admin_id"] = NULL;
		$obj_rev->roomdat[0]["room_upd_date"] = $_POST["room_upd_date"];
		$suc = $obj_rev->basedb_UpdRoom();
		IF( $suc == "0" ){
$testfilesize = filesize($param_room_layout_path);
			IF($_POST['room_other_img_1_del_chk']==1){
				IF( file_exists($$param_room_other_img_1_path.$_POST['room_other_1_lastupd'] ) && $_POST['room_other_1_lastupd'] != "" ){
					unlink( $$param_room_other_img_1_path.$_POST['room_other_1_lastupd'] );
				}
			}
			IF($_POST['room_other_img_2_del_chk']==1){
				IF( file_exists($param_room_other_img_2_path.$_POST['room_other_2_lastupd'] ) && $_POST['room_other_2_lastupd'] != "" ){
					unlink( $param_room_other_img_2_path.$_POST['room_other_2_lastupd'] );
				}
			}
			IF($_POST['room_other_img_3_del_chk']==1){
				IF( file_exists($param_room_other_img_3_path.$_POST['room_other_3_lastupd'] ) && $_POST['room_other_3_lastupd'] != "" ){
					unlink( $param_room_other_img_3_path.$_POST['room_other_3_lastupd'] );
				}
			}
			IF($_POST['room_other_img_4_del_chk']==1){
				IF( file_exists($param_room_other_img_4_path.$_POST['room_other_4_lastupd'] ) && $_POST['room_other_4_lastupd'] != "" ){
					unlink( $param_room_other_img_4_path.$_POST['room_other_4_lastupd'] );
				}
			}
			// 画像保存・削除処理
			IF( is_uploaded_file( $_FILES["room_layout_img"]["tmp_name"] ) ){
				// 一度画像を削除==>再度コピー
				IF( file_exists($param_room_layout_path.$_POST['room_layout_lastupd'] ) && $_POST['room_layout_lastupd'] != "" ){
					unlink( $param_room_layout_path.$_POST['room_layout_lastupd'] );
				}
				// 同じ名前で、UPLOADされたデータをコピー
				IF( is_uploaded_file($_FILES["room_layout_img"]["tmp_name"]) && $obj_rev->roomdat[0]["room_layout_img"] != "" ){
					move_uploaded_file( $_FILES["room_layout_img"]["tmp_name"] , $param_room_layout_path.$layout_img_org );
					chmod( $param_room_layout_path.$layout_img_org , 0755 );
				}

				$obj_layout_rev = new ImageControl;
				$obj_layout_rev->max_w = 500;
				$obj_layout_rev->max_h = 500;
				$obj_layout_rev->origin_dir = $param_room_layout_path;
				$obj_layout_rev->origin_img = $layout_img_org;
				$obj_layout_rev->gd_ver = 1;
				list($resize_layout_rev,$imageType) = $obj_layout_rev->ImageResizeSave();
				if($resize_layout_rev == -1){
	                        	$obj_error->ViewErrMessage( "SYSTEM" , "ALL" , "blog_mnt.php" , $arrOther  );
	                       		exit;
				}

				$obj_layout_save_rev = new ImageControl;
				$obj_layout_save_rev->origin_dir = $param_room_layout_path;
				$obj_layout_save_rev->origin_img = $layout_img_org;
				$obj_layout_save_rev->imageResource = $resize_layout_rev;
				$layout_suc_rev = $obj_layout_save_rev->ImageSave($imageType);
				if($layout_suc_rev == -1){
	                        	$obj_error->ViewErrMessage( "SYSTEM" , "ALL" , "blog_mnt.php" , $arrOther  );
	                       		exit;
				}
			}
			IF( is_uploaded_file( $_FILES["room_other_img_1"]["tmp_name"] ) ){
				// 一度画像を削除==>再度コピー
				IF( file_exists($$param_room_other_img_1_path.$_POST['room_other_1_lastupd'] ) && $_POST['room_other_1_lastupd'] != "" ){
					unlink( $$param_room_other_img_1_path.$_POST['room_other_1_lastupd'] );
				}
				// 同じ名前で、UPLOADされたデータをコピー
				IF( is_uploaded_file($_FILES["room_other_img_1"]["tmp_name"]) && $obj_rev->roomdat[0]["room_other_img_1"] != "" ){
					move_uploaded_file( $_FILES["room_other_img_1"]["tmp_name"] , $param_room_other_img_1_path.$room_other_img_org1 );
					chmod( $param_room_other_img_1_path.$room_other_img_org1 , 0755 );
				}

				$obj_other_1_rev = new ImageControl;
				$obj_other_1_rev->max_w = 300;
				$obj_other_1_rev->max_h = 300;
				$obj_other_1_rev->origin_dir = $param_room_other_img_1_path;
				$obj_other_1_rev->origin_img = $room_other_img_org1;
				$obj_other_1_rev->gd_ver = 1;
				list($resize_other_1_rev,$imageType) = $obj_other_1_rev->ImageResizeSave();
				if($resize_other_1_rev == -1){
	                        	$obj_error->ViewErrMessage( "SYSTEM" , "ALL" , "blog_mnt.php" , $arrOther  );
	                       		exit;
				}

				$obj_other_1_save_rev = new ImageControl;
				$obj_other_1_save_rev->origin_dir = $param_room_other_img_1_path;
				$obj_other_1_save_rev->origin_img = $room_other_img_org1;
				$obj_other_1_save_rev->imageResource = $resize_other_1_rev;
				$other_1_suc_rev = $obj_other_1_save_rev->ImageSave($imageType);
				if($other_1_suc_rev == -1){
	                        	$obj_error->ViewErrMessage( "SYSTEM" , "ALL" , "blog_mnt.php" , $arrOther  );
	                       		exit;
				}
			}
			IF( is_uploaded_file( $_FILES["room_other_img_2"]["tmp_name"] ) ){
				// 一度画像を削除==>再度コピー
				IF( file_exists($param_room_other_img_2_path.$_POST['room_other_2_lastupd'] ) && $_POST['room_other_2_lastupd'] != "" ){
					unlink( $param_room_other_img_2_path.$_POST['room_other_2_lastupd'] );
				}
				// 同じ名前で、UPLOADされたデータをコピー
				IF( is_uploaded_file($_FILES["room_other_img_2"]["tmp_name"]) && $obj_rev->roomdat[0]["room_other_img_2"] != "" ){
					move_uploaded_file( $_FILES["room_other_img_2"]["tmp_name"] , $param_room_other_img_2_path.$room_other_img_org2 );
					chmod( $param_room_other_img_2_path.$room_other_img_org2 , 0755 );
				}

				$obj_other_2_rev = new ImageControl;
				$obj_other_2_rev->max_w = 300;
				$obj_other_2_rev->max_h = 300;
				$obj_other_2_rev->origin_dir = $param_room_other_img_2_path;
				$obj_other_2_rev->origin_img = $room_other_img_org2;
				$obj_other_2_rev->gd_ver = 1;
				list($resize_other_2_rev,$imageType) = $obj_other_2_rev->ImageResizeSave();
				if($resize_other_2_rev == -1){
	                        	$obj_error->ViewErrMessage( "SYSTEM" , "ALL" , "blog_mnt.php" , $arrOther  );
	                       		exit;
				}

				$obj_other_2_save_rev = new ImageControl;
				$obj_other_2_save_rev->origin_dir = $param_room_other_img_2_path;
				$obj_other_2_save_rev->origin_img = $room_other_img_org2;
				$obj_other_2_save_rev->imageResource = $resize_other_2_rev;
				$other_2_suc_rev = $obj_other_2_save_rev->ImageSave($imageType);
				if($other_2_suc_rev == -1){
	                        	$obj_error->ViewErrMessage( "SYSTEM" , "ALL" , "blog_mnt.php" , $arrOther  );
	                       		exit;
				}
			}
			IF( is_uploaded_file( $_FILES["room_other_img_3"]["tmp_name"] ) ){
				// 一度画像を削除==>再度コピー
				IF( file_exists($param_room_other_img_3_path.$_POST['room_other_3_lastupd'] ) && $_POST['room_other_3_lastupd'] != "" ){
					unlink( $param_room_other_img_3_path.$_POST['room_other_3_lastupd'] );
				}
				// 同じ名前で、UPLOADされたデータをコピー
				IF( is_uploaded_file($_FILES["room_other_img_3"]["tmp_name"]) && $obj_rev->roomdat[0]["room_other_img_3"] != "" ){
					move_uploaded_file( $_FILES["room_other_img_3"]["tmp_name"] , $param_room_other_img_3_path.$room_other_img_org3 );
					chmod( $param_room_other_img_3_path.$room_other_img_org3 , 0755 );
				}

				$obj_other_3_rev = new ImageControl;
				$obj_other_3_rev->max_w = 300;
				$obj_other_3_rev->max_h = 300;
				$obj_other_3_rev->origin_dir = $param_room_other_img_3_path;
				$obj_other_3_rev->origin_img = $room_other_img_org3;
				$obj_other_3_rev->gd_ver = 1;
				list($resize_other_3_rev,$imageType) = $obj_other_3_rev->ImageResizeSave();
				if($resize_other_3_rev == -1){
	                        	$obj_error->ViewErrMessage( "SYSTEM" , "ALL" , "blog_mnt.php" , $arrOther  );
	                       		exit;
				}

				$obj_other_3_save_rev = new ImageControl;
				$obj_other_3_save_rev->origin_dir = $param_room_other_img_3_path;
				$obj_other_3_save_rev->origin_img = $room_other_img_org3;
				$obj_other_3_save_rev->imageResource = $resize_other_3_rev;
				$other_3_suc_rev = $obj_other_3_save_rev->ImageSave($imageType);
				if($other_3_suc_rev == -1){
	                        	$obj_error->ViewErrMessage( "SYSTEM" , "ALL" , "blog_mnt.php" , $arrOther  );
	                       		exit;
				}
			}
			IF( is_uploaded_file( $_FILES["room_other_img_4"]["tmp_name"] ) ){
				// 一度画像を削除==>再度コピー
				IF( file_exists($param_room_other_img_4_path.$_POST['room_other_4_lastupd'] ) && $_POST['room_other_4_lastupd'] != "" ){
					unlink( $param_room_other_img_4_path.$_POST['room_other_4_lastupd'] );
				}
				// 同じ名前で、UPLOADされたデータをコピー
				IF( is_uploaded_file($_FILES["room_other_img_4"]["tmp_name"]) && $obj_rev->roomdat[0]["room_other_img_4"] != "" ){
					move_uploaded_file( $_FILES["room_other_img_4"]["tmp_name"] , $param_room_other_img_4_path.$room_other_img_org4 );
					chmod( $param_room_other_img_4_path.$room_other_img_org4 , 0755 );
				}

				$obj_other_4_rev = new ImageControl;
				$obj_other_4_rev->max_w = 300;
				$obj_other_4_rev->max_h = 300;
				$obj_other_4_rev->origin_dir = $param_room_other_img_4_path;
				$obj_other_4_rev->origin_img = $room_other_img_org4;
				$obj_other_4_rev->gd_ver = 1;
				list($resize_other_4_rev,$imageType) = $obj_other_4_rev->ImageResizeSave();
				if($resize_other_4_rev == -1){
	                        	$obj_error->ViewErrMessage( "SYSTEM" , "ALL" , "blog_mnt.php" , $arrOther  );
	                       		exit;
				}

				$obj_other_4_save_rev = new ImageControl;
				$obj_other_4_save_rev->origin_dir = $param_room_other_img_4_path;
				$obj_other_4_save_rev->origin_img = $room_other_img_org4;
				$obj_other_4_save_rev->imageResource = $resize_other_4_rev;
				$other_4_suc_rev = $obj_other_4_save_rev->ImageSave($imageType);
				if($other_4_suc_rev == -1){
	                        	$obj_error->ViewErrMessage( "SYSTEM" , "ALL" , "blog_mnt.php" , $arrOther  );
	                       		exit;
				}
			}

		}
		if( $suc == -1 ){
			$arrOther["ath_comment"] = "<INPUT TYPE=\"hidden\" NAME=\"room_build_id\" VALUE=\"{$_POST['room_build_id']}\">";
			$arrOther["ath_comment"] .= "<INPUT TYPE=\"hidden\" NAME=\"room_stpos\" VALUE=\"{$_POST['room_stpos']}\">";
			$arrOther["ath_comment"] .= "<INPUT TYPE=\"hidden\" NAME=\"stpos\" VALUE=\"{$_POST['stpos']}\">";
			$arrOther["ath_comment"] .= $athComment;
			$obj_error->ViewErrMessage( "UPD_ERROR" , "ALL" , "room_mnt.php" , $arrOther );
                        exit;
		}
		if( $suc == 1 ){
			$arrOther["ath_comment"] = "<INPUT TYPE=\"hidden\" NAME=\"room_build_id\" VALUE=\"{$_POST['room_build_id']}\">";
			$arrOther["ath_comment"] .= "<INPUT TYPE=\"hidden\" NAME=\"room_stpos\" VALUE=\"{$_POST['room_stpos']}\">";
			$arrOther["ath_comment"] .= "<INPUT TYPE=\"hidden\" NAME=\"stpos\" VALUE=\"{$_POST['stpos']}\">";
			$obj_error->ViewErrMessage( "DOUBLE_UPD" , "ALL" , "room_main.php" , $arrOther );
                        exit;
		}
		if( $suc == 2 ){
			$arrOther["ath_comment"] = "<INPUT TYPE=\"hidden\" NAME=\"room_build_id\" VALUE=\"{$_POST['room_build_id']}\">";
			$arrOther["ath_comment"] .= "<INPUT TYPE=\"hidden\" NAME=\"room_stpos\" VALUE=\"{$_POST['room_stpos']}\">";
			$arrOther["ath_comment"] .= "<INPUT TYPE=\"hidden\" NAME=\"stpos\" VALUE=\"{$_POST['stpos']}\">";
			$arrOther["ath_comment"] .= $athComment;
			$obj_error->ViewErrMessage( "DISP_NO" , "ALL" , "room_mnt.php" , $arrOther );
                        exit;
                }
			
		$message = "部屋情報を修正しました。";
		break;
		
		
	case 'DEL':
		$obj_del = new basedb_RoomClassTblAccess;
		$obj_del->conn = $obj_conn->conn;
		$obj_del->roomdat[0]["room_id"] = $_POST["room_id"];
		$obj_del->roomdat[0]["room_upd_date"] = $_POST["room_upd_date"];
		$suc = $obj_del->basedb_DelRoom(0);
		if( $suc != 0 ){
			$arrOther["ath_comment"] = "<INPUT TYPE=\"hidden\" NAME=\"room_build_id\" VALUE=\"{$_POST['room_build_id']}\">";
                        $obj_error->ViewErrMessage( "DEL_ERROR" , "ALL" , "room_main.php" , $arrOther );
                        exit;
		}
		IF( $suc == "0" ){
			// 画像を削除
			IF( file_exists($param_room_layout_path.$_POST['room_layout_lastupd'] ) && $_POST["room_layout_lastupd"] != "" ){
				unlink( $param_room_layout_path.$_POST['room_layout_lastupd'] );
			}
			IF( file_exists($param_room_other_img_1_path.$_POST['room_other_1_lastupd']) && $_POST['room_other_1_lastupd'] != "" ){
				unlink( $param_room_other_img_1_path.$_POST['room_other_1_lastupd'] );
			}
			IF( file_exists($param_room_other_img_2_path.$_POST['room_other_2_lastupd'] ) && $_POST['room_other_2_lastupd'] != ""){
				unlink( $param_room_other_img_2_path.$_POST['room_other_2_lastupd'] );
			}
			IF( file_exists($param_room_other_img_3_path.$_POST['room_other_3_lastupd'] ) && $_POST['room_other_3_lastupd'] != ""){
				unlink( $param_room_other_img_3_path.$_POST['room_other_3_lastupd'] );
			}
			IF( file_exists($param_room_other_img_4_path.$_POST['room_other_4_lastupd'] ) && $_POST['room_other_4_lastupd'] != ""){
				unlink( $param_room_other_img_4_path.$_POST['room_other_4_lastupd'] );
			}
		}
		$message = "指定された部屋情報を削除しました。";
		break;
	
	case "COPY":
		
		// 指定部屋情報のデータを抽出
		$obj = new basedb_RoomClassTblAccess;
		$obj->conn = $obj_conn->conn;
		$obj->jyoken["room_del_date"] = 1;
		$obj->jyoken["room_id"] = $_POST['room_id'];
		list( $intCnt , $intTotal ) = $obj->basedb_GetRoom( 1 , -1 );
		IF( $intCnt != 1 ){
			$arrOther["ath_comment"] = "";
			FOREACH( $_POST as $key => $val ){
				$arrOther .= "<INPUT type=\"hidden\" name=\"{$key}\" value=\"{$val}\" />\n";
			}
			$arrOther["ath_comment"] = "<INPUT TYPE=\"hidden\" NAME=\"room_build_id\" VALUE=\"{$_POST['room_build_id']}\">";
			$obj_error->ViewErrMessage( "SYSTEM" , "ALL" , "room_main.php" , $arrOther );
			exit;
		}
		
		// 画像がある場合、登録内容を変更
		IF( $obj->roomdat[0]["room_layout_img"] != "" ){
			$before_layout_img = $obj->roomdat[0]["room_layout_img"];
			
			$kakuLayout = split( "\." , $obj->roomdat[0]["room_layout_img"] );
			$copy_layout_img = "layout_".$_SESSION['_cl_id']."_/.".$kakuLayout[1];
			$obj->roomdat[0]["room_layout_img"] = $copy_layout_img;
		}
		IF( $obj->roomdat[0]["room_other_img_1"] != "" ){
			$before_other_img_1 = $obj->roomdat[0]["room_other_img_1"];
			
			$kakuOther1 = split("\.",$_FILES["room_other_img_1"]["name"]);
			$copy_room_other_img_org1 = "room_".$_SESSION['_cl_id']."_/_1.".$kakuOther1[1];
			$obj->roomdat[0]["room_other_img_1"] = $copy_room_other_img_org1;
		}
		IF( $obj->roomdat[0]["room_other_img_2"] != "" ){
			$before_other_img_2 = $obj->roomdat[0]["room_other_img_2"];
			
			$kakuOther2 = split( "\." , $obj->roomdat[0]["room_other_img_2"] );
			$copy_room_other_img_org2 = "room_".$_SESSION['_cl_id']."_/_2.".$kakuOther2[1];
			$obj->roomdat[0]["room_other_img_2"] = $copy_room_other_img_org2;
		}
		IF( $obj->roomdat[0]["room_other_img_3"] != "" ){
			$before_other_img_3 = $obj->roomdat[0]["room_other_img_3"];
			
			$kakuOther3 = split( "\." , $obj->roomdat[0]["room_other_img_3"] );
			$copy_room_other_img_org3 = "room_".$_SESSION['_cl_id']."_/_3.".$kakuOther3[1];
			$obj->roomdat[0]["room_other_img_3"] = $copy_room_other_img_org3;
		}
		IF( $obj->roomdat[0]["room_other_img_4"] != "" ){
			$before_other_img_4 = $obj->roomdat[0]["room_other_img_4"];
			
			$kakuOther4 = split( "\." , $obj->roomdat[0]["room_other_img_4"] );
			$copy_room_other_img_org4 = "room_".$_SESSION['_cl_id']."_/_4.".$kakuOther4[1];
			$obj->roomdat[0]["room_other_img_4"] = $copy_room_other_img_org4;
		}
		
		// 抽出した情報を新規登録
		$suc = $obj->basedb_InsRoom();
		IF( $suc != 0 ){
			$arrOther["ath_comment"] = "";
			FOREACH( $_POST as $key => $val ){
				$arrOther .= "<INPUT type=\"hidden\" name=\"{$key}\" value=\"{$val}\" />\n";
			}
			$obj_error->ViewErrMessage( "COPY_ERROR" , "ALL" , "room_main.php" , $arrOther );
			exit;
		}
		
		// 指定画像をコピー
		IF( $before_layout_img != "" ){
			copy( $param_room_layout_path.$before_layout_img , $param_room_layout_path.$obj->roomdat[0]["room_layout_img"] );
		}
		IF( $before_other_img_1 != "" ){
			copy( $param_room_other_img_1_path.$before_other_img_1 , $param_room_other_img_1_path.$obj->roomdat[0]["room_other_img_1"] );
		}
		IF( $before_other_img_2 != "" ){
			copy( $param_room_other_img_2_path.$before_other_img_2 , $param_room_other_img_2_path.$obj->roomdat[0]["room_other_img_2"] );
		}
		IF( $before_other_img_3 != "" ){
			copy( $param_room_other_img_3_path.$before_other_img_3 , $param_room_other_img_3_path.$obj->roomdat[0]["room_other_img_3"] );
		}
		IF( $before_other_img_4 != "" ){
			copy( $param_room_other_img_4_path.$before_other_img_4 , $param_room_other_img_4_path.$obj->roomdat[0]["room_other_img_4"] );
		}
		
		
		$message = "指定された部屋情報を複製しました。";
		break;
		
	default:
		// 動作指定無しエラー
		$arrOther["ath_comment"] = "";
		FOREACH( $_POST as $key => $val ){
			$arrOther .= "<INPUT type=\"hidden\" name=\"{$key}\" value=\"{$val}\" />\n";
		}
		$arrOther["ath_comment"] = "<INPUT TYPE=\"hidden\" NAME=\"room_build_id\" VALUE=\"{$_POST['room_build_id']}\">";
		$obj_error->ViewErrMessage( "SYSTEM" , "ALL" , "room_main.php" , $arrOther );
		exit;
}

//---------------------------
//会社・ブログ基本情報抽出
$obj_cl_blog = new viewdb_ClientClassTblAccess;
$obj_cl_blog->conn = $obj_conn->conn;
$obj_cl_blog->jyoken["cl_del_date"] = 1;
$obj_cl_blog->jyoken["blog_del_date"] = 1;
$obj_cl_blog->jyoken["cl_id"] = $_SESSION['_cl_id'];
list( $rssCnt , $rssTotal ) = $obj_cl_blog->viewdb_GetClient ( 1 , -1 );


$url_base = _BLOG_SITE_URL_BASE;
//echo("<font color=\"white\">".$_SESSION['_cl_id']."**".$_POST["mode"]."**".$url_base."</font>");
//exec( "./rss.cgi ".$_SESSION['_cl_id']." ".$_POST["mode"]." ".$url_base." ".$param_base_blog_addr_url." > /dev/null &");

/*----------------------------------------------------------
  ＨＴＭＬ生成
----------------------------------------------------------*/
?>
<HTML>
  <HEAD>
    <TITLE>不動産ブログ - 建物情報 登録･修正･削除</title>
    <META http-equiv="Content-Type" content="text/html;charset=EUC-JP" />
    <META http-equiv="Content-Style-Type" content="text/css" />
    <META http-equiv="Content-Script-Type" content="text/javascript" />
    <LINK rel="stylesheet" href="../share/css/room.css" type="text/css" />
    <SCRIPT type="text/javascript" src="../share/js/rss.js"></SCRIPT>
    <NOSCRIPT><META http-equiv="Refresh" content="1;URL=../jserror.html"></NOSCRIPT>
  </HEAD>
  <BODY onload="rssBE('<?=$_SESSION['_cl_id']?>','<?=$_POST["mode"]?>','<?=$url_base?>','<?=$param_base_blog_addr_url?>','<?=$param_base_blog_addr?>');">
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
      <div id="hello"></div>
      <form name="form1" action="room_main.php" method="POST"> 
        <input type="submit" value=" 戻 る " class="btn" />
        <input type="hidden" name="room_build_id" value="<?=$_POST['room_build_id']?>" />
        <input type="hidden" name="stpos" value="<?=$_POST['stpos']?>" />
        <input type="hidden" name="room_stpos" value="<?=$_POST['room_stpos']?>" />
      </form>
<?=$test?>
    </div>
  </body>
</html>
