<?
/******************************************************************************
<< 不動産ブログ　Ver.1.O.0 >>
	Name: room_main.php
	Version: 1.0.0
	Function: 建物情報一覧
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
require_once ( SYS_PATH."dbif/basedb_ClientClass.php" );
require_once ( SYS_PATH."dbif/basedb_RoomClass.php" );
require_once ( SYS_PATH."dbif/basedb_CategoryClass.php" );
require_once ( SYS_PATH."common/base_common.php" );
require_once ( SYS_PATH."common/sys_common.php" );
require_once ( SYS_PATH."common/form_common.php" );
include_once ( SYS_PATH."common/error.class.php" );
require_once ( SYS_PATH."configs/param_base.conf" );
require_once ( SYS_PATH."configs/param_room.conf" );
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


/*--------------------------------------------------------
	処理部分
--------------------------------------------------------*/

if($_POST['error_mode']=="on"){
	foreach($_POST as $key => $val){
		$arrData[$key] = stripslashes($val);
	}

		$room_id = htmlspecialchars ($arrData["room_id"]);
		$room_build_id = htmlspecialchars ($arrData["room_build_id"]);
		$room_cate_id = split("/",htmlspecialchars ($arrData["room_cate_id"]));
		$room_code = htmlspecialchars ($arrData["room_code"]);
		$room_madori = htmlspecialchars ($arrData["room_madori"]);
		$room_madori_detail = htmlspecialchars ($arrData["room_madori_detail"]);
		$room_price = htmlspecialchars ($arrData["room_price"]);
		$room_cntrl_price = htmlspecialchars ($arrData["room_cntrl_price"]);
		$room_siki = htmlspecialchars ($arrData["room_siki"]);
		$room_rei = htmlspecialchars ($arrData["room_rei"]);
		$room_syou = htmlspecialchars ($arrData["room_syou"]);
		$room_sikibiki = htmlspecialchars ($arrData["room_sikibiki"]);
		$room_sec_price = htmlspecialchars ($arrData["room_sec_price"]);
		$room_contract = htmlspecialchars ($arrData["room_contract"]);
		$room_upd_price = htmlspecialchars ($arrData["room_upd_price"]);
		$room_upd_year = htmlspecialchars ($arrData["room_upd_year"]);
		$room_area = htmlspecialchars ($arrData["room_area"]);
		$room_floor = htmlspecialchars ($arrData["room_floor"]);
		$room_face = htmlspecialchars ($arrData["room_face"]);
		$room_layout_img = htmlspecialchars ($arrData["room_layout_img"]);
		$room_layout_img_org = htmlspecialchars ($arrData["room_layout_img_org"]);
		$room_other_img_1 = htmlspecialchars ($arrData["room_other_img_1"]);
		$room_other_img_org_1 = htmlspecialchars ($arrData["room_other_img_org_1"]);
		$room_other_img_2 = htmlspecialchars ($arrData["room_other_img_2"]);
		$room_other_img_org_2 = htmlspecialchars ($arrData["room_other_img_org_2"]);
		$room_other_img_3 = htmlspecialchars ($arrData["room_other_img_3"]);
		$room_other_img_org_3 = htmlspecialchars ($arrData["room_other_img_org_3"]);
		$room_other_img_4 = htmlspecialchars ($arrData["room_other_img_4"]);
		$room_other_img_org_4 = htmlspecialchars ($arrData["room_other_img_org_4"]);
		$room_equip = split("/",$arrData["room_equip_value"]);
		$room_equip_other = htmlspecialchars ($arrData["room_equip_other"]);
		IF( $arrData["room_move_date"] != "" ){
			$room_move_date2 = htmlspecialchars($arrData["room_move_date"]);
			$room_move_date = split ("-",$arrData["room_move_date"]);
			IF( $room_move_date[0] != "" ) $room_move_date[0] = sprintf('%d',$room_move_date[0]);
			IF( $room_move_date[1] != "" ) $room_move_date[1] = sprintf('%d',$room_move_date[1]);
			IF( $room_move_date[2] != "" )$room_move_date[2] = sprintf('%d',$room_move_date[2]);
		}
		$room_now_move = htmlspecialchars ($arrData["room_now_move"]);
		$room_trade = htmlspecialchars ($arrData["room_trade"]);
		$room_pr = htmlspecialchars ($arrData["room_pr"]);
		$room_vacant = htmlspecialchars ($arrData["room_vacant"]);
		$room_disp_no = htmlspecialchars ($arrData["room_disp_no"]);
		$room_siki_unit = htmlspecialchars ($arrData["room_siki_unit"]);
		$room_rei_unit = htmlspecialchars ($arrData["room_rei_unit"]);
		$room_syou_unit = htmlspecialchars ($arrData["room_syou_unit"]);
		$room_sikibiki_unit = htmlspecialchars ($arrData["room_sikibiki_unit"]);
		$room_sec_price_unit = htmlspecialchars ($arrData["room_sec_price_unit"]);
		$room_upd_price_unit = htmlspecialchars ($arrData["room_upd_price_unit"]);
		$room_cntrl_price_unit = htmlspecialchars ($arrData["room_cntrl_price_unit"]);
		$room_other_price = htmlspecialchars ($arrData["room_other_price"]);
		$room_upd_date = htmlspecialchars ($arrData["room_upd_date"]);
		$room_ppf = htmlspecialchars ($arrData["room_biko_2"]);
		$room_flg = htmlspecialchars ($arrData["room_flg"]);
		$room_biko_4 = htmlspecialchars ($arrData["room_biko_4"]);
		$room_biko_5 = htmlspecialchars ($arrData["room_biko_5"]);
		$room_biko_5 = htmlspecialchars ($arrData["room_biko_5"]);
		$room_start_date = split(" ".$arrData["room_start_date"]);
		$room_start_date2 = split("-",$room_start_date[0]);
		$room_start_year = $room_start_date2[0];
		$room_start_month = $room_start_date2[1];
		$room_start_day = $room_start_date2[2];
		$room_end_date = split(" ".$arrData["room_end_date"]);
		$room_end_date2 = split("-",$room_end_date[0]);
		$room_end_year = $room_end_date2[0];
		$room_end_month = $room_end_date2[1];
		$room_end_day = $room_end_date2[2];

	if( $_POST['mode'] == "EDIT" ){
		$obj = new basedb_RoomClassTblAccess;
		$obj->conn = $obj_conn->conn;
		$obj->jyoken["room_del_date"] = 1;
		$obj->jyoken["room_id"] = $_POST['room_id'];
		list( $intCnt , $intTotal ) = $obj->basedb_GetRoom( 1 , -1 );
		IF( $intCnt == -1 ){
			$arrOther["ath_comment"] = "<INPUT TYPE=\"hidden\" NAME=\"stpos\" VALUE=\"{$_POST['stpos']}\">";
			$obj_error->ViewErrMessage( "SYSTEM" , "ALL" , SITE_PATH."blank.php" , $arrOther );
			exit;
		}

		$strViewDelForm = "";
		$strViewDelForm .= "<form action=\"room_upd.php\" method=\"POST\" name=\"del_form\">\n";
		$strViewDelForm .= "  <td align=\"center\" valign=\"top\">\n";
		$strViewDelForm .= "    <input type=\"button\" value=\"削除する\" onclick=\"return RoomDeleteCheck( this.form , this.form )\" class=\"btn_nosize\" style=\"width:150px;\" />\n";
		$strViewDelForm .= "    <input type=\"hidden\" name=\"mode\" value=\"DEL\" />\n";
		$strViewDelForm .= "    <input type=\"hidden\" name=\"room_id\" value=\"{$room_id}\" />\n";
		$strViewDelForm .= "    <input type=\"hidden\" name=\"room_build_id\" value=\"{$room_build_id}\" />\n";
		$strViewDelForm .= "    <input type=\"hidden\" name=\"room_upd_date\" value=\"{$room_upd_date}\" />\n";
		$strViewDelForm .= "    <input type=\"hidden\" name=\"stpos\" value=\"{$_POST['stpos']}\" />\n";
		$strViewDelForm .= "    <input type=\"hidden\" name=\"room_layout_lastupd\" value=\"{$room_layout_img}\" />\n";
		$strViewDelForm .= "    <input type=\"hidden\" name=\"room_other_1_lastupd\" value=\"{$room_other_img_1}\" />\n";
		$strViewDelForm .= "    <input type=\"hidden\" name=\"room_other_2_lastupd\" value=\"{$room_other_img_2}\" />\n";
		$strViewDelForm .= "    <input type=\"hidden\" name=\"room_other_3_lastupd\" value=\"{$room_other_img_3}\" />\n";
		$strViewDelForm .= "    <input type=\"hidden\" name=\"room_other_4_lastupd\" value=\"{$room_other_img_4}\" />\n";
		$strViewDelForm .= "  </td>\n";
		$strViewDelForm .= "</form>\n";

		$modeName = "登録する";


	}else if($_POST['mode']=="NEW"){
		$modeName = "登録する";
		$room_build_id = $_POST['room_build_id'];
	}
}else{
	if( $_POST['mode'] == "EDIT" ){
		$obj = new basedb_RoomClassTblAccess;
		$obj->conn = $obj_conn->conn;
		$obj->jyoken["room_del_date"] = 1;
		$obj->jyoken["room_id"] = $_POST['room_id'];
		list( $intCnt , $intTotal ) = $obj->basedb_GetRoom( 1 , -1 );
		IF( $intCnt == -1 ){
			$arrOther["ath_comment"] = "<INPUT TYPE=\"hidden\" NAME=\"stpos\" VALUE=\"{$_POST['stpos']}\">";
			$obj_error->ViewErrMessage( "SYSTEM" , "ALL" , SITE_PATH."blank.php" , $arrOther );
			exit;
		}

		$room_id = htmlspecialchars ($obj->roomdat[0]["room_id"]);
		$room_build_id = htmlspecialchars ($obj->roomdat[0]["room_build_id"]);
		$room_cate_id = split("/",htmlspecialchars ($obj->roomdat[0]["room_cate_id"]));
		$room_code = htmlspecialchars ($obj->roomdat[0]["room_code"]);
		$room_madori = htmlspecialchars ($obj->roomdat[0]["room_madori"]);
		$room_madori_detail = htmlspecialchars ($obj->roomdat[0]["room_madori_detail"]);
		$room_price = htmlspecialchars ($obj->roomdat[0]["room_price"]);
		$room_cntrl_price = htmlspecialchars ($obj->roomdat[0]["room_cntrl_price"]);
		$room_siki = htmlspecialchars ($obj->roomdat[0]["room_siki"]);
		$room_rei = htmlspecialchars ($obj->roomdat[0]["room_rei"]);
		$room_syou = htmlspecialchars ($obj->roomdat[0]["room_syou"]);
		$room_sikibiki = htmlspecialchars ($obj->roomdat[0]["room_sikibiki"]);
		$room_sec_price = htmlspecialchars ($obj->roomdat[0]["room_sec_price"]);
		$room_contract = htmlspecialchars ($obj->roomdat[0]["room_contract"]);
		$room_upd_price = htmlspecialchars ($obj->roomdat[0]["room_upd_price"]);
		$room_upd_year = htmlspecialchars ($obj->roomdat[0]["room_upd_year"]);
		$room_area = htmlspecialchars ($obj->roomdat[0]["room_area"]);
		$room_floor = htmlspecialchars ($obj->roomdat[0]["room_floor"]);
		$room_face = htmlspecialchars ($obj->roomdat[0]["room_face"]);
		$room_layout_img = htmlspecialchars ($obj->roomdat[0]["room_layout_img"]);
		$room_layout_img_org = htmlspecialchars ($obj->roomdat[0]["room_layout_img_org"]);
		$room_other_img_1 = htmlspecialchars ($obj->roomdat[0]["room_other_img_1"]);
		$room_other_img_org_1 = htmlspecialchars ($obj->roomdat[0]["room_other_img_org_1"]);
		$room_other_img_2 = htmlspecialchars ($obj->roomdat[0]["room_other_img_2"]);
		$room_other_img_org_2 = htmlspecialchars ($obj->roomdat[0]["room_other_img_org_2"]);
		$room_other_img_3 = htmlspecialchars ($obj->roomdat[0]["room_other_img_3"]);
		$room_other_img_org_3 = htmlspecialchars ($obj->roomdat[0]["room_other_img_org_3"]);
		$room_other_img_4 = htmlspecialchars ($obj->roomdat[0]["room_other_img_4"]);
		$room_other_img_org_4 = htmlspecialchars ($obj->roomdat[0]["room_other_img_org_4"]);
		$room_equip = split("/",$obj->roomdat[0]["room_equip"]);
		$room_equip_other = htmlspecialchars ($obj->roomdat[0]["room_equip_other"]);
		IF( $obj->roomdat[0]["room_move_date"] != "" ){
			$room_move_date2 = htmlspecialchars($obj->roomdat[0]["room_move_date"]);
			$room_move_date = split ("-",$obj->roomdat[0]["room_move_date"]);
			IF( $room_move_date[0] != "" ) $room_move_date[0] = sprintf('%d',$room_move_date[0]);
			IF( $room_move_date[1] != "" ) $room_move_date[1] = sprintf('%d',$room_move_date[1]);
			IF( $room_move_date[2] != "" )$room_move_date[2] = sprintf('%d',$room_move_date[2]);
		}
		$room_now_move = htmlspecialchars ($obj->roomdat[0]["room_now_move"]);
		$room_trade = htmlspecialchars ($obj->roomdat[0]["room_trade"]);
		$room_pr = htmlspecialchars ($obj->roomdat[0]["room_pr"]);
		$room_vacant = htmlspecialchars ($obj->roomdat[0]["room_vacant"]);
		$room_disp_no = htmlspecialchars ($obj->roomdat[0]["room_disp_no"]);
		$room_siki_unit = htmlspecialchars ($obj->roomdat[0]["room_siki_unit"]);
		$room_rei_unit = htmlspecialchars ($obj->roomdat[0]["room_rei_unit"]);
		$room_syou_unit = htmlspecialchars ($obj->roomdat[0]["room_syou_unit"]);
		$room_sikibiki_unit = htmlspecialchars ($obj->roomdat[0]["room_sikibiki_unit"]);
		$room_sec_price_unit = htmlspecialchars ($obj->roomdat[0]["room_sec_price_unit"]);
		$room_upd_price_unit = htmlspecialchars ($obj->roomdat[0]["room_upd_price_unit"]);
		$room_cntrl_price_unit = htmlspecialchars ($obj->roomdat[0]["room_cntrl_price_unit"]);
		$room_other_price = htmlspecialchars ($obj->roomdat[0]["room_other_price"]);
		$room_upd_date = htmlspecialchars ($obj->roomdat[0]["room_upd_date"]);
		$room_ppf = htmlspecialchars ($obj->roomdat[0]["room_biko_2"]);
		$room_flg = htmlspecialchars ($obj->roomdat[0]["room_biko_3"]);
		$room_biko_4 = htmlspecialchars ($obj->roomdat[0]["room_biko_4"]);
		$room_biko_5 = htmlspecialchars ($obj->roomdat[0]["room_biko_5"]);
		$room_start_date = split(" ",$obj->roomdat[0]["room_start_date"]);
		$room_start_date2 = split("-",$room_start_date[0]);
		$room_start_year = $room_start_date2[0];
		$room_start_month = $room_start_date2[1];
		$room_start_day = $room_start_date2[2];
		$room_end_date = split(" ",$obj->roomdat[0]["room_end_date"]);
		$room_end_date2 = split("-",$room_end_date[0]);
		$room_end_year = $room_end_date2[0];
		$room_end_month = $room_end_date2[1];
		$room_end_day = $room_end_date2[2];

		$strViewDelForm = "";
		$strViewDelForm .= "<form action=\"room_upd.php\" method=\"POST\" name=\"del_form\">\n";
		$strViewDelForm .= "  <td align=\"center\" valign=\"top\">\n";
		$strViewDelForm .= "    <input type=\"button\" value=\"削除する\" onclick=\"return RoomDeleteCheck( this.form , this.form )\" class=\"btn_nosize\" style=\"width:150px;\" />\n";
		$strViewDelForm .= "    <input type=\"hidden\" name=\"mode\" value=\"DEL\" />\n";
		$strViewDelForm .= "    <input type=\"hidden\" name=\"room_id\" value=\"{$room_id}\" />\n";
		$strViewDelForm .= "    <input type=\"hidden\" name=\"room_build_id\" value=\"{$room_build_id}\" />\n";
		$strViewDelForm .= "    <input type=\"hidden\" name=\"room_upd_date\" value=\"{$room_upd_date}\" />\n";
		$strViewDelForm .= "    <input type=\"hidden\" name=\"stpos\" value=\"{$_POST['stpos']}\" />\n";
		$strViewDelForm .= "    <input type=\"hidden\" name=\"room_layout_lastupd\" value=\"{$room_layout_img}\" />\n";
		$strViewDelForm .= "    <input type=\"hidden\" name=\"room_other_1_lastupd\" value=\"{$room_other_img_1}\" />\n";
		$strViewDelForm .= "    <input type=\"hidden\" name=\"room_other_2_lastupd\" value=\"{$room_other_img_2}\" />\n";
		$strViewDelForm .= "    <input type=\"hidden\" name=\"room_other_3_lastupd\" value=\"{$room_other_img_3}\" />\n";
		$strViewDelForm .= "    <input type=\"hidden\" name=\"room_other_4_lastupd\" value=\"{$room_other_img_4}\" />\n";
		$strViewDelForm .= "  </td>\n";
		$strViewDelForm .= "</form>\n";

		$modeName = "登録する";


	}else if($_POST['mode']=="NEW"){
		$modeName = "登録する";
		$room_build_id = $_POST['room_build_id'];
	}
}

// ロゴ画像
$room_layout_dir = $param_room_layout_path;
$room_layout_arr["org"] = $room_layout_img_org;
$room_layout_arr["chk_in"] = "9";
$room_layout_txt =  form_ImgDisp( "room_layout_img" , $room_layout_dir , $obj->roomdat[0]["room_layout_img"] , "1" , $room_layout_arr );

$room_other_dir1 = $param_room_other_img_1_path;
$room_other_arr1["org"] = $room_other_img_org_1;
$room_other_arr1["chk_in"] = "1";
$room_other_txt1 =  form_ImgDisp( "room_other_img_1" , $room_other_dir1 , $obj->roomdat[0]["room_other_img_1"], "1" , $room_other_arr1 );

$room_other_dir2 = $param_room_other_img_2_path;
$room_other_arr2["org"] = $room_other_img_org_2;
$room_other_arr2["chk_in"] = "1";
$room_other_txt2 =  form_ImgDisp( "room_other_img_2" , $room_other_dir2 , $obj->roomdat[0]["room_other_img_2"] , "1" , $room_other_arr2 );

$room_other_dir3 = $param_room_other_img_3_path;
$room_other_arr3["org"] = $room_other_img_org_3;
$room_other_arr3["chk_in"] = "1";
$room_other_txt3 =  form_ImgDisp( "room_other_img_3" , $room_other_dir3 , $obj->roomdat[0]["room_other_img_3"] , "1" , $room_other_arr3 );

$room_other_dir4 = $param_room_other_img_4_path;
$room_other_arr4["org"] = $room_other_img_org_4;
$room_other_arr4["chk_in"] = "1";
$room_other_txt4 =  form_ImgDisp( "room_other_img_4" , $room_other_dir4 , $obj->roomdat[0]["room_other_img_4"] , "1" , $room_other_arr4 );


$obj_cate = new basedb_CategoryClassTblAccess;
$obj_cate->conn = $obj_conn->conn;
$obj_cate->jyoken["cate_del_date"] = 1;
$obj_cate->jyoken["cate_kind"] = 1;
$obj_cate->jyoken["cate_flg"] = 1;
$obj_cate->jyoken["cate_cl_id"] = $_SESSION['_cl_id'];
$obj_cate->sort["cate_disp_no"] = 2;
list( $intCnt , $intTotal ) = $obj_cate->basedb_GetCategory( 1 , -1 );
IF( $intCnt == -1 ){
	$arrOther["ath_comment"] = "<INPUT TYPE=\"hidden\" NAME=\"stpos\" VALUE=\"{$_POST['stpos']}\">";
	$obj_error->ViewErrMessage( "SYSTEM" , "ALL" , SITE_PATH."blank.php" , $arrOther );
	exit;
}
for($j=1;$j<6;$j++){
	for($i=0;$i<$intCnt;$i++){
		$cate_select ="";
		$category_name ="";
		$category_id ="";
		$category_name = $obj_cate->categorydat[$i]["cate_name"];
		$category_id = $obj_cate->categorydat[$i]["cate_id"];
		if($category_id == $room_cate_id[$j] && $room_cate_id[$j]!="")$cate_select = "selected";
		$cateValue[$j] .= "<OPTION VALUE=\"{$category_id}\" {$cate_select}>{$category_name}</OPTION>";
	}
}


asort( $param_room_floor["disp_no"] );
$madori_value = "";
FOREACH( $param_room_floor["disp_no"] as $key => $val ){
	$selected = "";
	if($param_room_floor['id'][$key] == $room_madori)$selected = "selected";
	$madori_value .= "<OPTION VALUE=\"{$param_room_floor['id'][$key]}\" {$selected}>{$param_room_floor['val'][$key]}</OPTION>\n";	
}


asort( $param_room_trade["disp_no"] );
$trade_value = "";
FOREACH( $param_room_trade["disp_no"] as $key => $val ){
	$selected = "";
	if($param_room_trade['id'][$key] == $room_trade)$selected = "selected";
	$trade_value .= "<OPTION VALUE=\"{$param_room_trade['id'][$key]}\" {$selected}>{$param_room_trade['val'][$key]}</OPTION>\n";	
}


asort( $param_room_face["disp_no"] );
$face_value = "";
FOREACH( $param_room_face["disp_no"] as $key => $val ){
	$selected = "";
	if($param_room_face['id'][$key] == $room_face)$selected = "selected";
	$face_value .= "<OPTION VALUE=\"{$param_room_face['id'][$key]}\" {$selected}>{$param_room_face['val'][$key]}</OPTION>\n";	
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
	for($jX==0;$jX<count($room_equip);$jX++){
		if($param_room_equip['id'][$key] == $room_equip[$jX])$checked = "checked";
	}
	$equip_value .= "<TD class=\"equip\"><INPUT TYPE=\"checkbox\" NAME=\"room_equip[{$iX}]\" VALUE=\"{$param_room_equip['id'][$key]}\" {$check_id} {$checked}>{$param_room_equip['val'][$key]}</TD>\n";	
	if( $iX % 4 == 0 )$equip_value .= "</TR><TR>";
}


asort( $param_room_siki["disp_no"] );
$siki_value = "";
FOREACH( $param_room_siki["disp_no"] as $key => $val ){
	$selected = "";
	if($param_room_siki['id'][$key] == $room_siki)$selected = "selected";
	$siki_value .= "<OPTION VALUE=\"{$param_room_siki['id'][$key]}\" {$selected}>{$param_room_siki['val'][$key]}</OPTION>\n";	
}


asort( $param_room_rei["disp_no"] );
$rei_value = "";
FOREACH( $param_room_rei["disp_no"] as $key => $val ){
	$selected = "";
	if($param_room_rei['id'][$key] == $room_rei)$selected = "selected";
	$rei_value .= "<OPTION VALUE=\"{$param_room_rei['id'][$key]}\" {$selected}>{$param_room_rei['val'][$key]}</OPTION>\n";	
}


if($room_now_move==1){
	$move_checked1="checked";
}else if($room_now_move==2){
	$move_checked2="checked";
}

if($room_vacant==1){
	$vacant_checked1="checked";
}else if($room_vacant==2){
	$vacant_checked2="checked";
}

if($room_ppf==1){
	$ppf_checked1="checked";
}else if($room_ppf==9){
	$ppf_checked2="checked";
}else{
	$ppf_checked1="checked";
}

if($room_flg==1){
	$rflg_checked1="checked";
}else if($room_flg==9){
	$rflg_checked2="checked";
}else{
	$rflg_checked1="checked";
}


if($room_siki_unit==1){
	$sikiUnit_selected1="selected";
}else if($room_siki_unit==9){
	$sikiUnit_selected2="selected";
}else{
	$sikiUnit_selected1="selected";
}


if($room_rei_unit==1){
	$reiUnit_selected1="selected";
}else if($room_rei_unit==9){
	$reiUnit_selected2="selected";
}else{
	$reiUnit_selected1="selected";
}


if($room_syou_unit==1){
	$syouUnit_selected1="selected";
}else if($room_syou_unit==9){
	$syouUnit_selected2="selected";
}else{
	$syouUnit_selected2="selected";
}


if($room_sikibiki_unit==1){
	$sikibikiUnit_selected1="selected";
}else if($room_sikibiki_unit==9){
	$sikibikiUnit_selected2="selected";
}else{
	$sikibikiUnit_selected2="selected";
}


if($room_sec_price_unit==1){
	$secPriceUnit_selected1="selected";
}else if($room_sec_price_unit==9){
	$secPriceUnit_selected2="selected";
}else{
	$secPriceUnit_selected1="selected";
}


if($room_upd_price_unit==1){
	$updPriceUnit_selected1="selected";
}else if($room_upd_price_unit==9){
	$updPriceUnit_selected2="selected";
}else{
	$updPriceUnit_selected2="selected";
}



if($room_cntrl_price_unit==1){
	$cntrlPriceUnit_selected1="selected";
}else if($room_cntrl_price_unit==9){
	$cntrlPriceUnit_selected2="selected";
}else{
	$cntrlPriceUnit_selected2="selected";
}


/*--------------------------------------------------------
	表示リスト項目作成
--------------------------------------------------------*/
$lsy_base = date("Y");
$lsy = $lsy_base - 3;
$ley = $lsy_base + 3;
// 有効期限開始(年)
FOR( $iX=$lsy; $iX<$ley; $iX++ ){
	$strSel = "";
	IF( $iX == intval($room_start_year) ) $strSel = " selected";
	$start_y .= "              <OPTION value=\"{$iX}\"{$strSel}>{$iX}</OPTION>\n";
}


// 有効期限開始(月)
$start_m = "";
FOR( $iX=1; $iX<13; $iX++ ){
	$strSel = "";
	IF( $iX == intval($room_start_month) ) $strSel = " selected";
	$start_m .= "              <OPTION value=\"{$iX}\"{$strSel}>{$iX}</OPTION>\n";
}


// 有効期限開始(日)
$start_d = "";
FOR( $iX=1; $iX<32; $iX++ ){
	$strSel = "";
	IF( $iX == intval($room_start_day) ) $strSel = " selected";
	$start_d .= "              <OPTION value=\"{$iX}\"{$strSel}>{$iX}</OPTION>\n";
}


// 有効期限終了(年)
$end_y = "";
FOR( $iX=$lsy; $iX<$ley; $iX++ ){
	$strSel = "";
	IF( $iX == intval($room_end_year) ) $strSel = " selected";
	$end_y .= "              <OPTION value=\"{$iX}\"{$strSel}>{$iX}</OPTION>\n";
}

// 有効期限終了(月)
$end_m = "";
FOR( $iX=1; $iX<13; $iX++ ){
	$strSel = "";
	IF( $iX == intval($room_end_month) ) $strSel = " selected";
	$end_m .= "              <OPTION value=\"{$iX}\"{$strSel}>{$iX}</OPTION>\n";
}

// 有効期限終了(日)
$end_d = "";
FOR( $iX=1; $iX<32; $iX++ ){
	$strSel = "";
	IF( $iX == intval($room_end_day) ) $strSel = " selected";
	$end_d .= "              <OPTION value=\"{$iX}\"{$strSel}>{$iX}</OPTION>\n";
}

/*----------------------------------------------------------
  ＤＢ切断
----------------------------------------------------------*/
require_once( SYS_PATH."common/db_close.php" );


/*--------------------------------------------------------
	ＨＴＭＬ生成
--------------------------------------------------------*/
?>
<HTML>
  <HEAD>
    <TITLE>不動産ブログ - アカウント管理ツール</TITLE>
    <META http-equiv="Content-Type" content="text/html;charset=EUC-JP" />
    <META http-equiv="Content-Style-Type" content="text/css" />
    <META http-equiv="Content-Script-Type" content="text/javascript" />
    <LINK rel="stylesheet" type="text/css" href="../share/css/room.css" />
    <SCRIPT type="text/javascript" src="../share/js/room.js"></SCRIPT>
    <SCRIPT type="text/javascript" src="../share/js/input_check.js"></SCRIPT>
    <NOSCRIPT><META http-equiv="Refresh" content="1;URL=../jserror.html"></NOSCRIPT>
  </HEAD>
  <BODY onload="selectOther()">
    <div id="room">
      <div id="title">部屋情報</div>
      <table id="client" cellspacing="0">
        <FORM name="room" method="POST" action="room_upd.php" target="_self" enctype="multipart/form-data">
        <tr>
          <th class="must">部屋表示<BR>表示/非表示</th>
          <td>
            <input type="radio" name="room_flg" value="1" <?=$rflg_checked1?>>表示
            　<input type="radio" name="room_flg" value="9" <?=$rflg_checked2?>>非表示
          </td>
        </tr>
        <tr>
          <th class="must">ポータルサイト<BR>掲載/非掲載</th>
          <td>
            <input type="radio" name="p_pub_flg" value="1" <?=$ppf_checked1?>>掲載
            　<input type="radio" name="p_pub_flg" value="9" <?=$ppf_checked2?>>非掲載
          </td>
        </tr>
        <tr>
          <th>掲載期限</th>
          <td>
            <select name="room_start_year">
              <option value="">----</option>
<?=$start_y?>
            </select>
            年
            <select name="room_start_month">
              <option value="">--</option>
<?=$start_m?>
            </select>
            月
            <select name="room_start_day">
              <option value="">--</option>
<?=$start_d?>
            </select>
〜
            <select name="room_end_year">
              <option value="">----</option>
<?=$end_y?>
            </select>
            年
            <select name="room_end_month">
              <option value="">--</option>
<?=$end_m?>
            </select>
            月
            <select name="room_end_day">
              <option value="">--</option>
<?=$end_d?>
            </select>
          </td>
        </tr>
        <tr>
          <th>詳細ページタイトル</th>
          <td>
          <input id="i101" type="text" name="room_biko_4" value="<?=$room_biko_4?>" maxlength="50" onFocus='Text("i101", 1)' onBlur='Text("i101", 2)' style="width:300px;"/>
            <br />
            <FONT class="comment">※入力しない場合デフォルトのタイトルが表示されます。</FONT>
          </td>
        </tr>
        <tr>
          <th>おすすめ物件見出し</th>
          <td>
          <input id="i1010" type="text" name="room_biko_5" value="<?=$room_biko_5?>" maxlength="50" onFocus='Text("i1010", 1)' onBlur='Text("i1010", 2)' style="width:300px;"/>
          </td>
        </tr>
        <tr>
          <th>所属カテゴリー1</th>
          <td>
            <SELECT name="room_cate_id_1">
              <option value="">-- 選択 --</option>
<?=$cateValue[1]?>
            </SELECT>
            <br />
            <FONT class="comment">※カテゴリーを追加したい場合は、カテゴリー登録ページにて追加できます。</FONT>
          </td>
        </tr>
        <tr>
          <th>所属カテゴリー2</th>
          <td>
            <SELECT name="room_cate_id_2">
              <option value="">-- 選択 --</option>
<?=$cateValue[2]?>
            </SELECT>
          </td>
        </tr>
        <tr>
          <th>所属カテゴリー3</th>
          <td>
            <SELECT name="room_cate_id_3">
              <option value="">-- 選択 --</option>
<?=$cateValue[3]?>
            </SELECT>
          </td>
        </tr>
        <tr>
          <th>所属カテゴリー4</th>
          <td>
            <SELECT name="room_cate_id_4">
              <option value="">-- 選択 --</option>
<?=$cateValue[4]?>
            </SELECT>
          </td>
        </tr>
        <tr>
          <th>所属カテゴリー5</th>
          <td>
            <SELECT name="room_cate_id_5">
              <option value="">-- 選択 --</option>
<?=$cateValue[5]?>
            </SELECT>
          </td>
        </tr>
        <tr>
          <th class="must">物件コード</th>
          <td><input id="i1" type="text" name="room_code" value="<?=$room_code?>" maxlength="50" onFocus='Text("i1", 1)' onBlur='Text("i1", 2)' style="width:300px;"/></td>
        </tr>
        <tr>
          <th class="must">間取り</th>
          <td>
            <select name="room_madori">
              <option value="">-- 選択 --</option>
<?=$madori_value?>
            </select>
          </td>
        </tr>
        <tr>
          <th class="must">間取り詳細</th>
          <td><input id="i2" type="text" name="room_madori_detail" value="<?=$room_madori_detail?>" maxlength="50" style="width:200px" onFocus='Text("i2", 1)' onBlur='Text("i2", 2)' />　<font color="#ff0000">(例)洋2 和1</font></td>
        </tr>
        <tr>
          <th class="must">賃料</th>
          <td><input id="i3" type="text" name="room_price" value="<?=$room_price?>" maxlength="15" onFocus='Text("i3", 1)' onBlur='Text("i3", 2)' style="width:80px"/>円 <font color="#ff0000">(半角数字)</font></td>
        </tr>
        <tr>
          <th>料金：その他</th>
          <td><input id="i50" type="text" name="room_other_price" value="<?=$room_other_price?>" onFocus='Text("i50", 1)' onBlur='Text("i50", 2)' style="width:300px"/></td>
        </tr>
        <tr>
          <th class="must">管理料</th>
          <td><input id="i4" type="text" name="room_cntrl_price" value="<?=$room_cntrl_price?>" maxlength="15" onFocus='Text("i4", 1)' onBlur='Text("i4", 2)' style="width:80px"/>
            <select name="room_cntrl_price_unit">
              <option value="1" <?=$cntrlPriceUnit_selected1?>>ヶ月</option>
              <option value="9" <?=$cntrlPriceUnit_selected2?>>円</option>
            </select>
            <font color="#ff0000">(半角数字)</font></td>
        </tr>
        <tr>
          <th class="must">敷金／礼金</th>
          <td>
            敷金：
            <input type="input" name="room_siki" value="<?=$room_siki?>">
            <select name="room_siki_unit">
              <option value="1" <?=$sikiUnit_selected1?>>ヶ月</option>
              <option value="9" <?=$sikiUnit_selected2?>>円</option>
            </select>
            &nbsp;&nbsp;
            礼金：
            <input type="input" name="room_rei" value="<?=$room_rei?>">
            <select name="room_rei_unit">
              <option value="1" <?=$reiUnit_selected1?>>ヶ月</option>
              <option value="9" <?=$reiUnit_selected2?>>円</option>
            </select>
          </td>
        </tr>
        <tr>
          <th>償却</th>
          <td><input id="i5" type="text" name="room_syou" value="<?=$room_syou?>" maxlength="15" onFocus='Text("i5", 1)' onBlur='Text("i5", 2)' style="width:80px"/>
            <select name="room_syou_unit">
              <option value="1" <?=$syouUnit_selected1?>>ヶ月</option>
              <option value="9" <?=$syouUnit_selected2?>>円</option>
            </select>
            <font color="#ff0000">(半角数字)</font>
          </td>
        </tr>
        <tr>
          <th>敷引</th>
          <td><input id="i6" type="text" name="room_sikibiki" value="<?=$room_sikibiki?>" maxlength="15" onFocus='Text("i6", 1)' onBlur='Text("i6", 2)' style="width:80px"/>
            <select name="room_sikibiki_unit">
              <option value="1" <?=$sikibikiUnit_selected1?>>ヶ月</option>
              <option value="9" <?=$sikibikiUnit_selected2?>>円</option>
            </select>
            <font color="#ff0000">(半角数字)</font></td>
        </tr>
        <tr>
          <th>保証金</th>
          <td><input id="i35" type="text" name="room_sec_price" value="<?=$room_sec_price?>" maxlength="15" onFocus="Text('i35',1)" onBlur="Text('i35',2)" style="width:80px;" />
            <select name="room_sec_price_unit">
              <option value="1" <?=$secPriceUnit_selected1?>>ヶ月</option>
              <option value="9" <?=$secPriceUnit_selected2?>>円</option>
            </select>
            <font color="#ff0000">（半角数字）</font></td>
        </tr>
        <tr>
          <th class="must">契約年</th>
          <td><input id="i7" type="text" name="room_contract" value="<?=$room_contract?>" maxlength="15" onFocus='Text("i7", 1)' onBlur='Text("i7", 2)' style="width:60px"/></td>
        </tr>
        <tr>
          <th class="must">更新料</th>
          <td><input id="i8" type="text" name="room_upd_price" value="<?=$room_upd_price?>" maxlength="15" onFocus='Text("i8", 1)' onBlur='Text("i8", 2)' style="width:80px"/>
            <select name="room_upd_price_unit">
              <option value="1" <?=$updPriceUnit_selected1?>>ヶ月</option>
              <option value="9" <?=$updPriceUnit_selected2?>>円</option>
            </select>
            <font color="#ff0000">(半角数字)</font></td>
        </tr>
<!--
        <tr>
          <th class="must">更新年数</th>
          <td><input id="i9" type="text" name="room_upd_year" value="<?=$room_upd_year?>" maxlength="15" onFocus='Text("i9", 1)' onBlur='Text("i9", 2)' style="width:30px"/>年 <font color="#ff0000">(半角数字)</font></td>
        </tr>
//-->
        <tr>
          <th class="must">専有面積</th>
          <td><input id="i10" type="text" name="room_area" value="<?=$room_area?>" maxlength="15" onFocus='Text("i10", 1)' onBlur='Text("i10", 2)' style="width:80px"/>�� <font color="#ff0000">(少数点第二位までの半角数字)</font></td>
        </tr>
        <tr>
          <th class="must">所在階</th>
          <td><input id="i11" type="text" name="room_floor" value="<?=$room_floor?>" maxlength="15" onFocus='Text("i11", 1)' onBlur='Text("i11", 2)' style="width:60px"/></td>
        </tr>
        <tr>
          <th class="must">方位</th>
          <td>
            <select name="room_face">
              <option value="">-- 選択 --</option>
<?=$face_value?>
            </select>
          </td>
        </tr>
        <tr>
          <th class="must">画像（間取り）</th>
          <td>
<?=$room_layout_txt?>
<BR><font color="#ff0000">※画像は2MB以下のGIF画像かJPG画像をアップしてください</font>		
          </td>
        </tr>
        <tr>
          <th>画像1</th>
          <td>
<?=$room_other_txt1?>
<BR><font color="#ff0000">※画像は2MB以下のGIF画像かJPG画像をアップしてください</font>		
          </td>
        </tr>
        <tr>
          <th>画像2</th>
          <td>
<?=$room_other_txt2?>
<BR><font color="#ff0000">※画像は2MB以下のGIF画像かJPG画像をアップしてください</font>		
          </td>
        </tr>
        <tr>
          <th>画像3</th>
          <td>
<?=$room_other_txt3?>
<BR><font color="#ff0000">※画像は2MB以下のGIF画像かJPG画像をアップしてください</font>		
          </td>
        </tr>
        <tr>
          <th>画像4</th>
          <td>
<?=$room_other_txt4?>
<BR><font color="#ff0000">※画像は2MB以下のGIF画像かJPG画像をアップしてください</font>		
          </td>
        </tr>
        <tr>
          <th>設備情報<BR>※複数選択可</th>
          <td>
          <TABLE class="equip">
            <TR>
<?=$equip_value?>
            </TR>
          </TABLE>
          </td>
        </tr>
        <tr>
          <th>設備情報(その他)</th>
          <td><input id="i12" type="text" name="room_equip_other" value="<?=$room_equip_other?>" maxlength="15" style="width:200px" onFocus='Text("i12", 1)' onBlur='Text("i12", 2)' /><font color="#ff0000">&nbsp;※設備情報でその他を選択した場合のみ入力</font></td>
        </tr>
        <tr>
          <th class="must">物件空き状況</th>
          <td>
            <input type="radio" name="room_vacant" value="1" <?=$vacant_checked1?> />入居中　
            <input type="radio" name="room_vacant" value="2" <?=$vacant_checked2?> />空き
          </td>
        </tr>
        <tr>
          <th class="must">即入居可</th>
          <td>
            <input type="radio" name="room_now_move" value="1" <?=$move_checked1?> />可　
            <input type="radio" name="room_now_move" value="2" <?=$move_checked2?> />不可
          </td>
        </tr>
        <tr>
          <th>入居可能日</th>
          <td>
            <input id="i170" type="text" name="room_move_date" value="<?=$room_move_date2?>" style="width:100px" onFocus='Text("i170", 1)' onBlur='Text("i170", 2)' />
          </td>
        </tr>
        <tr>
          <th class="must">取引形態</th>
          <td>
            <select name="room_trade">
              <option value="">-- 選択 --</option>
<?=$trade_value?>
            </select>
          </td>
        </tr>
        <tr>
          <th class="must">部屋PR文章</th>
          <TD><TEXTAREA id="i13" name="room_pr" style="width:725px" rows="10" onFocus='Text("i13", 1)' onBlur='Text("i13", 2)'><?=$room_pr?></TEXTAREA></TD>
        </tr>
      </table>
    </div>
    <div align="center">
      <table width="500">
        <tr>
          <td align="center" valign="top">
            <input type="submit" value="<?=$modeName?>" class="btn_nosize" onclick="return RoomInputCheck( this.form , this.form )" style="width:150px;" />
            <input type="hidden" name="mode" value="<?=$_POST['mode']?>" />
            <input type="hidden" name="room_id" value="<?=$room_id?>" />
            <input type="hidden" name="room_layout_lastupd" value="<?=$room_layout_img?>" />
            <input type="hidden" name="room_other_1_lastupd" value="<?=$room_other_img_1?>" />
            <input type="hidden" name="room_other_2_lastupd" value="<?=$room_other_img_2?>" />
            <input type="hidden" name="room_other_3_lastupd" value="<?=$room_other_img_3?>" />
            <input type="hidden" name="room_other_4_lastupd" value="<?=$room_other_img_4?>" />
            <input type="hidden" name="room_build_id" value="<?=$room_build_id?>" />
            <input type="hidden" name="error_flg" value="<?=$obj->roomdat[0]["room_layout_img"]?>" />
            <input type="hidden" name="room_upd_date" value="<?=$room_upd_date?>" />
            <input type="hidden" name="stpos" value="<?=$_POST['stpos']?>" />
            <input type="hidden" name="room_stpos" value="<?=$_POST['room_stpos']?>" />
          </td>
          </form>
<?=$strViewDelForm?>
          <form method="POST" action="room_main.php">
          <td align="center" valign="top">
            <input type="submit" name="bak" value="戻る" class="btn_nosize" style="width:150px;" />
            <input type="hidden" name="room_build_id" value="<?=$room_build_id?>" />
            <input type="hidden" name="stpos" value="<?=$_POST['stpos']?>" />
            <input type="hidden" name="room_stpos" value="<?=$_POST['room_stpos']?>" />
          </td>
          </form>
        </tr>
      </table>
    </div>
  </body>
</HTML>
