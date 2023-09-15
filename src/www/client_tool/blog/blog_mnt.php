<?
/******************************************************************************
<< 不動産ブログ　Ver.1.O.0 >>
	Name: blog_main.php
	Version: 1.0.0
	Function: ブログ基本設定情報一覧
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
require_once ( SYS_PATH."dbif/basedb_SchoolClass.php" );
require_once ( SYS_PATH."dbif/basedb_EnsenClass.php" );
require_once ( SYS_PATH."common/sys_common.php" );
require_once ( SYS_PATH."common/form_common.php" );
require_once ( SYS_PATH."common/error.class.php" );
require_once ( SYS_PATH."configs/param_base.conf" );
require_once ( SYS_PATH."configs/param_file.conf" );
require_once ( SYS_PATH."configs/param_blog.conf" );
require_once ( SYS_PATH."configs/param_map.conf" );

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
$obj = new basedb_SchoolClassTblAccess;
$obj->conn = $obj_conn->conn;
$obj->jyoken["sc_deldate"] = 1;
$obj->jyoken["sc_clid"] = $_SESSION["_cl_id"];
list( $intNum , $intTotal ) = $obj->basedb_GetSchool( 1 , -1 );
IF( $intNum == -1 ){
	$arrOther["ath_comment"] = "<INPUT TYPE=\"hidden\" NAME=\"stpos\" VALUE=\"{$_POST['stpos']}\">";
	$obj_error->ViewErrMessage( "SYSTEM" , "ALL" , SITE_PATH."blank.php" , $arrOther );
	exit;
}

$obj2 = new basedb_EnsenClassTblAccess;
$obj2->conn = $obj_conn->conn;
$obj2->jyoken["es_deldate"] = 1;
$obj2->jyoken["es_cd"] = $obj->blogdat[0]["sc_clid"];
$obj2->sort["es_dispno"] = 1;
list( $intNum , $intTotal ) = $obj2->basedb_GetEnsen( 1 , -1 );
IF( $intNum == -1 ){
	$arrOther["ath_comment"] = "<INPUT TYPE=\"hidden\" NAME=\"stpos\" VALUE=\"{$_POST['stpos']}\">";
	$obj_error->ViewErrMessage( "SYSTEM" , "ALL" , SITE_PATH."blank.php" , $arrOther );
	exit;
}

//print_r($obj2->ensendat);
/*----------------------------------------------------------
  ＤＢ切断
----------------------------------------------------------*/
require_once( SYS_PATH."common/db_close.php" );


/*--------------------------------------------------------
  一覧表示内容生成
--------------------------------------------------------*/
$layoutNum = 5;

if( $_POST['error_mode'] != "on" ){
	$sc_id = htmlspecialchars ($obj->blogdat[0]["sc_id"]);
	$sc_stat = htmlspecialchars ($obj->blogdat[0]["sc_stat"]);
	$sc_update = htmlspecialchars ($obj->blogdat[0]["sc_update"]);
	$sc_keywd = htmlspecialchars ( str_replace( "-" , "," , $obj->blogdat[0]["sc_keywd"] ) );
	$sc_introduce = htmlspecialchars ( $obj->blogdat[0]["sc_introduce"] );
	$sc_master = htmlspecialchars ( $obj->blogdat[0]["sc_master"] );
	$sc_position = htmlspecialchars ( $obj->blogdat[0]["sc_position"] );
	$sc_classform = htmlspecialchars ( $obj->blogdat[0]["sc_classform"] );
	$sc_age = htmlspecialchars ( $obj->blogdat[0]["sc_age"] );
	$sc_logoorg = htmlspecialchars ($obj->blogdat[0]["sc_logoorg"]);
	$sc_logo_mobile_org = htmlspecialchars ($obj->blogdat[0]["sc_logo_mobile_org"]);
	$sc_topimgorg = htmlspecialchars ($obj->blogdat[0]["sc_topimgorg"]);
	$sc_mapimgorg = htmlspecialchars ($obj->blogdat[0]["sc_mapimgorg"]);
	$sc_movie = htmlspecialchars ($obj->blogdat[0]["sc_movie"]);

	$sc_headertitle = htmlspecialchars ($obj->blogdat[0]["sc_headertitle"]);
	$sc_toptitle = htmlspecialchars ($obj->blogdat[0]["sc_toptitle"]);
	$sc_topsubtitle = htmlspecialchars ($obj->blogdat[0]["sc_topsubtitle"]);
	$sc_campaintitle = htmlspecialchars ($obj->blogdat[0]["sc_campaintitle"]);
	$sc_coursetitle = htmlspecialchars ($obj->blogdat[0]["sc_coursetitle"]);
	$sc_diarytitle = htmlspecialchars ($obj->blogdat[0]["sc_diarytitle"]);
	$sc_topwindowtitle = htmlspecialchars ($obj->blogdat[0]["sc_topwindowtitle"]);
	$sc_company = htmlspecialchars ($obj->blogdat[0]["sc_company"]);
	$sc_addmission = htmlspecialchars ($obj->blogdat[0]["sc_addmission"]);

	$sc_title = htmlspecialchars ($obj->blogdat[0]["sc_title"]);
	$sc_clr = htmlspecialchars ($obj->blogdat[0]["sc_clr"]);
	$sc_entrymail = htmlspecialchars ($obj->blogdat[0]["sc_entrymail"]);
	$sc_infomail = htmlspecialchars ($obj->blogdat[0]["sc_infomail"]);
	$sc_infomail2 = htmlspecialchars ($obj->blogdat[0]["sc_infomail2"]);
	$sc_entrymail2= htmlspecialchars ($obj->blogdat[0]["sc_entrymail2"]);
	$sc_start = htmlspecialchars ($obj->blogdat[0]["sc_start"]);
	$sc_end = htmlspecialchars ($obj->blogdat[0]["sc_end"]);
	$sc_holiday = htmlspecialchars ( $obj->blogdat[0]["sc_holiday"] );
	$sc_hp = htmlspecialchars ( $obj->blogdat[0]["sc_hp"] );
	$sc_privacy = htmlspecialchars ($obj->blogdat[0]["sc_privacy"]);
	$sc_results = htmlspecialchars ($obj->blogdat[0]["sc_results"]);
	$sc_students = htmlspecialchars ($obj->blogdat[0]["sc_students"]);
	$sc_pr = htmlspecialchars ($obj->blogdat[0]["sc_pr"]);
	$sc_rhtml = htmlspecialchars ($obj->blogdat[0]["sc_rhtml"]);
	$sc_lhtml = htmlspecialchars ($obj->blogdat[0]["sc_lhtml"]);
    //hatori
	$sc_thtml = htmlspecialchars ($obj->blogdat[0]["sc_thtml"]);
    //
	$sc_logo_lastupd = htmlspecialchars ($obj->blogdat[0]["sc_logo"]);
	$sc_logo_mobile_lastupd = htmlspecialchars ($obj->blogdat[0]["sc_logo_mobile"]);
	$sc_topimg_lastupd = htmlspecialchars ($obj->blogdat[0]["sc_topimg"]);
	$sc_mapimg_lastupd = htmlspecialchars ($obj->blogdat[0]["sc_mapimg"]);
	$sc_privacy = htmlspecialchars ($obj->blogdat[0]["sc_privacy"]);

	$sc_ido = htmlspecialchars ($obj->blogdat[0]["sc_ido"]);
	$sc_keido = htmlspecialchars ($obj->blogdat[0]["sc_keido"]);
	if($obj->blogdat[0]["sc_zoom"] != ""){
		$sc_zoom = htmlspecialchars ($obj->blogdat[0]["sc_zoom"]);
	}else{
		$sc_zoom = 10;
	}
	$sc_upddate = htmlspecialchars ($obj->blogdat[0]["sc_upddate"]);

	foreach($obj2->ensendat as $key2 => $val2){
		$es_id[$val2["es_dispno"]] = htmlspecialchars ($val2["es_id"]);
		$es_cd[$val2["es_dispno"]] = htmlspecialchars ($val2["es_cd"]);
		$es_type[$val2["es_dispno"]] = htmlspecialchars ($val2["es_type"]);
		$es_dispno[$val2["es_dispno"]] = htmlspecialchars ($val2["es_dispno"]);
		$es_pref[$val2["es_dispno"]] = htmlspecialchars ($val2["es_pref"]);
		$es_line[$val2["es_dispno"]] = htmlspecialchars ($val2["es_line"]);
		$es_linecd[$val2["es_dispno"]] = htmlspecialchars ($val2["es_linecd"]);
		$es_linecdname[$val2["es_dispno"]] = htmlspecialchars ($val2["es_linecdname"]);
		$es_sta[$val2["es_dispno"]] = htmlspecialchars ($val2["es_sta"]);
		$es_stacd[$val2["es_dispno"]] = htmlspecialchars ($val2["es_stacd"]);
		$es_walk[$val2["es_dispno"]] = htmlspecialchars ($val2["es_walk"]);
		$es_bus[$val2["es_dispno"]] = htmlspecialchars ($val2["es_bus"]);
		$es_biko[$val2["es_dispno"]] = htmlspecialchars ($val2["es_biko"]);
		$es_adminid[$val2["es_dispno"]] = htmlspecialchars ($val2["es_adminid"]);
		$es_insdate[$val2["es_dispno"]] = htmlspecialchars ($val2["es_insdate"]);
		$es_upddate[$val2["es_dispno"]] = htmlspecialchars ($val2["es_upddate"]);
		$es_deldate[$val2["es_dispno"]] = htmlspecialchars ($val2["es_deldate"]);
		$es_yobi1[$val2["es_dispno"]] = htmlspecialchars ($val2["es_yobi1"]);
		$es_yobi2[$val2["es_dispno"]] = htmlspecialchars ($val2["es_yobi2"]);
		$es_yobi3[$val2["es_dispno"]] = htmlspecialchars ($val2["es_yobi3"]);
		$es_yobi4[$val2["es_dispno"]] = htmlspecialchars ($val2["es_yobi4"]);
		$es_yobi5[$val2["es_dispno"]] = htmlspecialchars ($val2["es_yobi5"]);
	}

	foreach($obj2->ensendat as $key2 => $val2){
		if($val2["es_type"]!=""){
			$ensenFlg[$val2["es_dispno"]] = "edit";
		}
	}
	if(!$ensenFlg[1]){
		$ensenFlg[1] = "ins";
	}
	if(!$ensenFlg[2]){
		$ensenFlg[2] = "ins";
	}
	if(!$ensenFlg[3]){
		$ensenFlg[3] = "ins";
	}
	if(!$ensenFlg[4]){
		$ensenFlg[4] = "ins";
	}
	if(!$ensenFlg[5]){
		$ensenFlg[5] = "ins";
	}


}else{

	foreach($_POST as $key => $val){
		if(is_array($val)){
			foreach($val as $key2 => $val2){
				$arrData[$key][$key2] = stripslashes($val2);
			}
		}else{
			$arrData[$key] = stripslashes($val);
		}
	}
	$sc_id = htmlspecialchars ($arrData["sc_id"]);
	$sc_stat = htmlspecialchars ($arrData["sc_stat"]);
	$sc_update = htmlspecialchars ($arrData["sc_update"]);
	$sc_keywd = htmlspecialchars ( str_replace( "-" , "," , $arrData["sc_keywd"] ) );
	$sc_introduce = htmlspecialchars ( $arrData["sc_introduce"] );
	$sc_master = htmlspecialchars ( $arrData["sc_master"] );
	$sc_position = htmlspecialchars ( $arrData["sc_position"] );
	$sc_classform = htmlspecialchars ( $arrData["sc_classform"] );
	$sc_age = htmlspecialchars ( $arrData["sc_age"] );
//	$es_linecd = htmlspecialchars ($arrData["es_linecd"]);
//	$es_stacd = htmlspecialchars ($arrData["es_stacd"]);

	$es_linecd2 = htmlspecialchars ($arrData["es_linecd2"]);
	$es_stacd2 = htmlspecialchars ($arrData["es_stacd2"]);

	$sc_logoorg = htmlspecialchars($arrData["sc_logoorg"]);
	$sc_logo_mobile_org= htmlspecialchars($arrData["sc_logo_mobile_org"]);
	$sc_topimgorg = htmlspecialchars ($arrData["sc_topimgorg"]);
	$sc_mapimgorg = htmlspecialchars ($arrData["sc_mapimgorg"]);


	$sc_headertitle = htmlspecialchars ($arrData["sc_headertitle"]);
	$sc_toptitle = htmlspecialchars ($arrData["sc_toptitle"]);
	$sc_topsubtitle = htmlspecialchars ($arrData["sc_topsubtitle"]);
	$sc_campaintitle = htmlspecialchars ($arrData["sc_campaintitle"]);
	$sc_coursetitle = htmlspecialchars ($arrData["sc_coursetitle"]);
	$sc_diarytitle = htmlspecialchars ($arrData["sc_diarytitle"]);
	$sc_topwindowtitle = htmlspecialchars ($obj->blogdat[0]["sc_topwindowtitle"]);
	$sc_company = htmlspecialchars ($obj->blogdat[0]["sc_company"]);
	$sc_addmission = htmlspecialchars ($obj->blogdat[0]["sc_addmission"]);

	$sc_title = htmlspecialchars ($arrData["sc_title"]);
	$sc_clr = htmlspecialchars ($arrData["sc_clr"]);
	$sc_entrymail = htmlspecialchars ($arrData["sc_entrymail"]);
	$sc_infomail = htmlspecialchars ($arrData["sc_infomail"]);
	$sc_infomail2 = htmlspecialchars ($arrData["sc_infomail2"]);
	$sc_entrymail2= htmlspecialchars ($arrData["sc_entrymail2"]);
	$sc_start = htmlspecialchars ($arrData["sc_start"]);
	$sc_end = htmlspecialchars ($arrData["sc_end"]);
	$sc_holiday = htmlspecialchars ( $arrData["sc_holiday"] );
	$sc_hp = htmlspecialchars ( $arrData["sc_hp"] );
	$sc_privacy = htmlspecialchars ($arrData["sc_privacy"]);
	$sc_results = htmlspecialchars ($arrData["sc_results"]);
	$sc_students = htmlspecialchars ($arrData["sc_students"]);
	$sc_pr = htmlspecialchars ($arrData["sc_pr"]);
	$sc_rhtml = htmlspecialchars ($arrData["sc_rhtml"]);
	$sc_lhtml = htmlspecialchars ($arrData["sc_lhtml"]);
    //hatori
	$sc_thtml = htmlspecialchars ($arrData["sc_thtml"]);
    //
	$sc_logo_lastupd        = htmlspecialchars ($arrData["sc_logo"]);
	$sc_logo_mobile_lastupd = htmlspecialchars ($arrData["sc_logo_mobile"]);
	$sc_topimg_lastupd = htmlspecialchars ($arrDatay["sc_topimg"]);
	$sc_mapimg_lastupd = htmlspecialchars ($arrData["sc_mapimg"]);
	$sc_privacy = htmlspecialchars ($arrData["sc_privacy"]);
	$sc_ido = htmlspecialchars ($arrData["sc_ido"]);
	$sc_keido = htmlspecialchars ($arrData["sc_keido"]);
	if($arrData["sc_zoom"]){
		$sc_zoom = htmlspecialchars ($arrData["sc_zoom"]);
	}else{
		$sc_zoom = 10;
	}
	$sc_upddate = htmlspecialchars ($arrData["sc_upddate"]);

	$es_id[1] = htmlspecialchars ($arrData["es_id"][1]);
	$es_cd[1] = htmlspecialchars ($arrData["es_cd"][1]);
	$es_type[1] = htmlspecialchars ($arrData["es_type"][1]);
	$es_dispno[1] = htmlspecialchars ($arrData["es_dispno"][1]);
	$es_pref[1] = htmlspecialchars ($arrData["es_pref"][1]);
	$es_line[1] = htmlspecialchars ($arrData["es_line"][1]);
	$es_linecd[1] = htmlspecialchars ($arrData["es_linecd"][1]);
	$es_linecdname[1] = htmlspecialchars ($arrData["es_linecdname"][1]);
	$es_sta[1] = htmlspecialchars ($arrData["es_sta"][1]);
	$es_stacd[1] = htmlspecialchars ($arrData["es_stacd"][1]);
	$es_walk[1] = htmlspecialchars ($arrData["es_walk"][1]);
	$es_bus[1] = htmlspecialchars ($arrData["es_bus"][1]);
	$es_biko[1] = htmlspecialchars ($arrData["es_biko"][1]);
	$es_adminid[1] = htmlspecialchars ($arrData["es_adminid"][1]);
	$es_insdate[1] = htmlspecialchars ($arrData["es_insdate"][1]);
	$es_upddate[1] = htmlspecialchars ($arrData["es_upddate"][1]);
	$es_deldate[1] = htmlspecialchars ($arrData["es_deldate"][1]);
	$es_yobi1[1] = htmlspecialchars ($arrData["es_yobi1"][1]);
	$es_yobi2[1] = htmlspecialchars ($arrData["es_yobi2"][1]);
	$es_yobi3[1] = htmlspecialchars ($arrData["es_yobi3"][1]);
	$es_yobi4[1] = htmlspecialchars ($arrData["es_yobi4"][1]);
	$es_yobi5[1] = htmlspecialchars ($arrData["es_yobi5"][1]);

	$es_id[2] = htmlspecialchars ($arrData["es_id"][2]);
	$es_cd[2] = htmlspecialchars ($arrData["es_cd"][2]);
	$es_type[2] = htmlspecialchars ($arrData["es_type"][2]);
	$es_dispno[2] = htmlspecialchars ($arrData["es_dispno"][2]);
	$es_pref[2] = htmlspecialchars ($arrData["es_pref"][2]);
	$es_line[2] = htmlspecialchars ($arrData["es_line"][2]);
	$es_linecd[2] = htmlspecialchars ($arrData["es_linecd"][2]);
	$es_sta[2] = htmlspecialchars ($arrData["es_sta"][2]);
	$es_stacd[2] = htmlspecialchars ($arrData["es_stacd"][2]);
	$es_walk[2] = htmlspecialchars ($arrData["es_walk"][2]);
	$es_bus[2] = htmlspecialchars ($arrData["es_bus"][2]);
	$es_biko[2] = htmlspecialchars ($arrData["es_biko"][2]);
	$es_adminid[2] = htmlspecialchars ($arrData["es_adminid"][2]);
	$es_insdate[2] = htmlspecialchars ($arrData["es_insdate"][2]);
	$es_upddate[2] = htmlspecialchars ($arrData["es_upddate"][2]);
	$es_deldate[2] = htmlspecialchars ($arrData["es_deldate"][2]);
	$es_yobi1[2] = htmlspecialchars ($arrData["es_yobi1"][2]);
	$es_yobi2[2] = htmlspecialchars ($arrData["es_yobi2"][2]);
	$es_yobi3[2] = htmlspecialchars ($arrData["es_yobi3"][2]);
	$es_yobi4[2] = htmlspecialchars ($arrData["es_yobi4"][2]);
	$es_yobi5[2] = htmlspecialchars ($arrData["es_yobi5"][2]);

	$es_id[3] = htmlspecialchars ($arrData["es_id"][3]);
	$es_cd[3] = htmlspecialchars ($arrData["es_cd"][3]);
	$es_type[3] = htmlspecialchars ($arrData["es_type"][3]);
	$es_dispno[3] = htmlspecialchars ($arrData["es_dispno"][3]);
	$es_pref[3] = htmlspecialchars ($arrData["es_pref"][3]);
	$es_line[3] = htmlspecialchars ($arrData["es_line"][3]);
	$es_linecd[3] = htmlspecialchars ($arrData["es_linecd"][3]);
	$es_sta[3] = htmlspecialchars ($arrData["es_sta"][3]);
	$es_stacd[3] = htmlspecialchars ($arrData["es_stacd"][3]);
	$es_walk[3] = htmlspecialchars ($arrData["es_walk"][3]);
	$es_bus[3] = htmlspecialchars ($arrData["es_bus"][3]);
	$es_biko[3] = htmlspecialchars ($arrData["es_biko"][3]);
	$es_adminid[3] = htmlspecialchars ($arrData["es_adminid"][3]);
	$es_insdate[3] = htmlspecialchars ($arrData["es_insdate"][3]);
	$es_upddate[3] = htmlspecialchars ($arrData["es_upddate"][3]);
	$es_deldate[3] = htmlspecialchars ($arrData["es_deldate"][3]);
	$es_yobi1[3] = htmlspecialchars ($arrData["es_yobi1"][3]);
	$es_yobi2[3] = htmlspecialchars ($arrData["es_yobi2"][3]);
	$es_yobi3[3] = htmlspecialchars ($arrData["es_yobi3"][3]);
	$es_yobi4[3] = htmlspecialchars ($arrData["es_yobi4"][3]);
	$es_yobi5[3] = htmlspecialchars ($arrData["es_yobi5"][3]);

	$es_id[4] = htmlspecialchars ($arrData["es_id"][4]);
	$es_cd[4] = htmlspecialchars ($arrData["es_cd"][4]);
	$es_type[4] = htmlspecialchars ($arrData["es_type"][4]);
	$es_dispno[4] = htmlspecialchars ($arrData["es_dispno"][4]);
	$es_pref[4] = htmlspecialchars ($arrData["es_pref"][4]);
	$es_line[4] = htmlspecialchars ($arrData["es_line"][4]);
	$es_linecd[4] = htmlspecialchars ($arrData["es_linecd"][4]);
	$es_sta[4] = htmlspecialchars ($arrData["es_sta"][4]);
	$es_stacd[4] = htmlspecialchars ($arrData["es_stacd"][4]);
	$es_walk[4] = htmlspecialchars ($arrData["es_walk"][4]);
	$es_bus[4] = htmlspecialchars ($arrData["es_bus"][4]);
	$es_biko[4] = htmlspecialchars ($arrData["es_biko"][4]);
	$es_adminid[4] = htmlspecialchars ($arrData["es_adminid"][4]);
	$es_insdate[4] = htmlspecialchars ($arrData["es_insdate"][4]);
	$es_upddate[4] = htmlspecialchars ($arrData["es_upddate"][4]);
	$es_deldate[4] = htmlspecialchars ($arrData["es_deldate"][4]);
	$es_yobi1[4] = htmlspecialchars ($arrData["es_yobi1"][4]);
	$es_yobi2[4] = htmlspecialchars ($arrData["es_yobi2"][4]);
	$es_yobi3[4] = htmlspecialchars ($arrData["es_yobi3"][4]);
	$es_yobi4[4] = htmlspecialchars ($arrData["es_yobi4"][4]);
	$es_yobi5[4] = htmlspecialchars ($arrData["es_yobi5"][4]);

	$es_id[5] = htmlspecialchars ($arrData["es_id"][5]);
	$es_cd[5] = htmlspecialchars ($arrData["es_cd"][5]);
	$es_type[5] = htmlspecialchars ($arrData["es_type"][5]);
	$es_dispno[5] = htmlspecialchars ($arrData["es_dispno"][5]);
	$es_pref[5] = htmlspecialchars ($arrData["es_pref"][5]);
	$es_line[5] = htmlspecialchars ($arrData["es_line"][5]);
	$es_linecd[5] = htmlspecialchars ($arrData["es_linecd"][5]);
	$es_sta[5] = htmlspecialchars ($arrData["es_sta"][5]);
	$es_stacd[5] = htmlspecialchars ($arrData["es_stacd"][5]);
	$es_walk[5] = htmlspecialchars ($arrData["es_walk"][5]);
	$es_bus[5] = htmlspecialchars ($arrData["es_bus"][5]);
	$es_biko[5] = htmlspecialchars ($arrData["es_biko"][5]);
	$es_adminid[5] = htmlspecialchars ($arrData["es_adminid"][5]);
	$es_insdate[5] = htmlspecialchars ($arrData["es_insdate"][5]);
	$es_upddate[5] = htmlspecialchars ($arrData["es_upddate"][5]);
	$es_deldate[5] = htmlspecialchars ($arrData["es_deldate"][5]);
	$es_yobi1[5] = htmlspecialchars ($arrData["es_yobi1"][5]);
	$es_yobi2[5] = htmlspecialchars ($arrData["es_yobi2"][5]);
	$es_yobi3[5] = htmlspecialchars ($arrData["es_yobi3"][5]);
	$es_yobi4[5] = htmlspecialchars ($arrData["es_yobi4"][5]);
	$es_yobi5[5] = htmlspecialchars ($arrData["es_yobi5"][5]);

	foreach($obj2->ensendat as $key2 => $val2){
		$es_id[$val2["es_dispno"]] = htmlspecialchars ($val2["es_id"]);
		$es_type[$val2["es_dispno"]] = htmlspecialchars ($val2["es_type"]);
		$es_adminid[$val2["es_dispno"]] = htmlspecialchars ($val2["es_adminid"]);
		$es_insdate[$val2["es_dispno"]] = htmlspecialchars ($val2["es_insdate"]);
		$es_upddate[$val2["es_dispno"]] = htmlspecialchars ($val2["es_upddate"]);
		$es_deldate[$val2["es_dispno"]] = htmlspecialchars ($val2["es_deldate"]);
	}

	foreach($obj2->ensendat as $key2 => $val2){
		if($val2["es_type"]!=""){
			$ensenFlg[$val2["es_dispno"]] = "edit";
		}
	}
	if(!$ensenFlg[1]){
		$ensenFlg[1] = "ins";
	}
	if(!$ensenFlg[2]){
		$ensenFlg[2] = "ins";
	}
	if(!$ensenFlg[3]){
		$ensenFlg[3] = "ins";
	}
	if(!$ensenFlg[4]){
		$ensenFlg[4] = "ins";
	}
	if(!$ensenFlg[5]){
		$ensenFlg[5] = "ins";
	}

}

// ブログ基本色
asort( $param_blog_color["disp_no"] );
$layoutView = "";
FOREACH( $param_blog_color["disp_no"] as $key => $val ){
	$strChk = "";
	if( $param_blog_color["id"][$key] == $sc_clr ) $strChk = " checked";
	$layoutView .= "  <tr>\n";
	$layoutView .= "    <td><INPUT TYPE=\"radio\" NAME=\"sc_clr\" VALUE=\"{$param_blog_color["id"][$key]}\"{$strChk}></td>\n";
	$layoutView .= "    <td><a href=\"{$param_blog_color_path}{$param_blog_color["img"][$key]}\" target=\"_blank\"><IMG src=\"{$param_blog_color_path}{$param_blog_color["img"][$key]}\" alt=\"{$param_blog_color["val"][$key]}\" border=\"0\" width=\"100\" height=\"84\" /></a></td>\n";
        $layoutView .= "  </tr>\n";
}


// 授業形態
if( ($sc_classform & 4) == 4 ){
	$sc_classformChk3 = " checked";
	$sc_classform -= 4;
}
if( ($sc_classform & 2) == 2 ){
	$sc_classformChk2 = " checked";
	$sc_classform -= 2;
}
if( ($sc_classform & 1) == 1 ){
	$sc_classformChk1 = " checked";
	$sc_classform -= 1;
}

// 対象学年
if( ($sc_age & 128) == 128 ){
	$sc_ageChk8 = " checked";
	$sc_age -= 128;
}
if( ($sc_age & 64) == 64 ){
	$sc_ageChk7 = " checked";
	$sc_age -= 64;
}
if( ($sc_age & 32) == 32 ){
	$sc_ageChk6 = " checked";
	$sc_age -= 32;
}
if( ($sc_age & 16) == 16 ){
	$sc_ageChk5 = " checked";
	$sc_age -= 16;
}
if( ($sc_age & 8) == 8 ){
	$sc_ageChk4 = " checked";
	$sc_age -= 8;
}
if( ($sc_age & 4) == 4 ){
	$sc_ageChk3 = " checked";
	$sc_age -= 4;
}
if( ($sc_age & 2) == 2 ){
	$sc_ageChk2 = " checked";
	$sc_age -= 2;
}
if( ($sc_age & 1) == 1 ){
	$sc_ageChk1 = " checked";
	$sc_age -= 1;
}


// 営業開始時間（時・分）
IF( $sc_start != "" ){
	$arrBuffStartTime = explode( ":" , $sc_start );
}ELSE{
	$arrBuffStartTime = "";
}
$viewStartTime_h = "";
$iX=0;
FOR( $iX=6; $iX<25; $iX++ ){
	$buffInt = "";
	$buffInt = sprintf( "%02d" , $iX );
	$strSel = "";
	IF( $buffInt == $arrBuffStartTime[0] ) $strSel = " selected";
	$viewStartTime_h .= "<OPTION value=\"{$buffInt}\"{$strSel}>{$buffInt}</OPTION>\n";
}
$viewStartTime_m = "";
$iX=0;
WHILE( $iX<60 ){
	$buffInt = "";
	$buffInt = sprintf( "%02d" , $iX );
	$strSel = "";
	IF( $buffInt == $arrBuffStartTime[1] ) $strSel = " selected";
	$viewStartTime_m .= "<OPTION value=\"{$buffInt}\"{$strSel}>{$buffInt}</OPTION>\n";
	$iX = $iX+10;
}

// 営業終了時間（時・分）
IF( $sc_end != "" ){
	$arrBuffEndTime = explode( ":" , $sc_end );
}ELSE{
	$arrBuffEndTime = "";
}
$viewEndTime_h = "";
FOR( $iX=6; $iX<25; $iX++ ){
	$buffInt = "";
	$buffInt = sprintf( "%02d" , $iX );
	$strSel = "";
	IF( $buffInt == $arrBuffEndTime[0] ) $strSel = " selected";
	$viewEndTime_h .= "<OPTION value=\"{$buffInt}\"{$strSel}>{$buffInt}</OPTION>\n";
}
$viewEndTime_m = "";
$iX=0;
WHILE( $iX<60 ){
	$buffInt = "";
	$buffInt = sprintf( "%02d" , $iX );
	$strSel = "";
	IF( $buffInt == $arrBuffEndTime[1] ) $strSel = " selected";
	$viewEndTime_m .= "<OPTION value=\"{$buffInt}\"{$strSel}>{$buffInt}</OPTION>\n";
	$iX = $iX+10;
}


// ロゴ画像
$cl_logo_dir = $param_cl_logo_path;
$cl_logo_arr["org"] = $sc_logoorg;
$cl_logo_arr["chk_in"] = "1";
$cl_logo_txt =  form_ImgDisp( "sc_logo" , $cl_logo_dir , $obj->blogdat[0]["sc_logo"] , "1" , $cl_logo_arr );



// モバイルロゴ画像
$cl_logo_mobile_dir = $param_cl_logo_mobile_path;
$cl_logo_arr["org"] = $sc_logo_mobile_org;
$cl_logo_arr["chk_in"] = "1";
$cl_logo_mobile_txt =  form_ImgDisp( "sc_logo_mobile" , $cl_logo_mobile_dir , $obj->blogdat[0]["sc_logo_mobile"] , "1" , $cl_logo_arr);



// 外観画像
$cl_photo_dir = $param_cl_photo_path;
$cl_photo_arr["org"] = $sc_topimgorg;
$cl_photo_arr["chk_in"] = "1";
$cl_photo_txt =  form_ImgDisp( "sc_topimg" , $cl_photo_dir , $obj->blogdat[0]["sc_topimg"] , "1" , $cl_photo_arr );

// スタッフ画像
$cl_staff_dir = $param_cl_staff_path;
$cl_staff_arr["org"] = $sc_mapimgorg;
$cl_staff_arr["chk_in"] = "1";
$cl_staff_txt =  form_ImgDisp( "sc_mapimg" , $cl_staff_dir , $obj->blogdat[0]["sc_mapimg"] , "1" , $cl_staff_arr );


/*--------------------------------------------------------
	ＨＴＭＬ生成
--------------------------------------------------------*/
?>
<HTML>
  <HEAD>
    <TITLE>塾ブログ - クライアントツール</TITLE>
    <META http-equiv="Content-Type" content="text/html;charset=EUC-JP" />
    <META http-equiv="Content-Style-Type" content="text/css" />
    <META http-equiv="Content-Script-Type" content="text/javascript" />
    <LINK rel="stylesheet" type="text/css" href="../share/css/blog.css" />
    <SCRIPT type="text/javascript" src="../share/js/blog.js"></SCRIPT>
    <SCRIPT type="text/javascript" src="../share/js/input_check.js"></SCRIPT>
    <SCRIPT type="text/javascript" src="../share/js/tag.js"></SCRIPT>
    <SCRIPT type="text/javascript" src="../share/js/GoogleMap.js"></SCRIPT>
    <script src="https://maps.googleapis.com/maps/api/js?key=<?=$param_api_key?>" type="text/javascript" charset="utf-8"></script>
    <NOSCRIPT><META http-equiv="Refresh" content="1;URL=../jserror.html"></NOSCRIPT>
  </HEAD>
  <BODY onload="loadMap('11110','<?=$sc_ido?>','<?=$sc_keido?>','<?=$sc_zoom?>','35.70972275209277','139.6527099609375','10','','','','<?=$param_marker_com_img?>','<?=$param_marker_shadow_img?>')">
    <DIV id="blog">
      <DIV id="title">基本設定１</DIV>
      <TABLE>
        <FORM name="go_upd" method="POST" action="blog_upd.php" target="_self" enctype="multipart/form-data">
<!--
        <TR>
          <TH class="must">ブログタイトル</TH>
          <TD><INPUT id="i1" TYPE="text" name="sc_title" VALUE="<?=$sc_title?>" maxlength="25" style="width:310px" onFocus='Text("i1", 1)' onBlur='Text("i1", 2)' /><BR><font color="#ff0000">※。</font></TD>
        </TR>
//-->
        <TR>
          <TH>ディスクリプション-<br />エディブロ非表示<br />（検索エンジン結果テキスト）</TH>
          <TD><TEXTAREA NAME="sc_introduce" id="i3" style="width:410px" wrap="soft" onFocus='Text("i3", 1)' onBlur='Text("i3", 2)' rows="3"><?=$sc_introduce?></TEXTAREA></TD>
        </TR>
        <TR>
          <TH class="must">デザインパターン</TH>
            <TD>
              <DIV id="layout">
                <table>
<?=$layoutView?>
                </table>
              </DIV>
            </TD>
        </TR>
        <TR>
          <TH>SEO対策補助キーワード</TH>
          <TD><INPUT type="text" id="i2" name="sc_keywd" value="<?=$sc_keywd?>" style="width:400px" onFocus='Text("i2", 1)' onBlur='Text("i2", 2)' /> <font color="#ff0000"><BR>※このブログに関連するキーワードを入力してください。<BR>※複数指定の場合は , (カンマ)で区切って入力してください。<BR>　例：学習塾,個別指導,･･･</font></TD>
        </TR>
        <TR>
          <TH>運営会社</TH>
          <TD><INPUT type="text" id="i2" name="sc_company" value="<?=$sc_company?>" style="width:400px" onFocus='Text("i2", 1)' onBlur='Text("i2", 2)' /> <font color="#ff0000"></TD>
        </TR>
        <TR>
          <TH class="must">メインタイトル<br />（検索エンジン結果タイトル・PC画面最上部テキスト）</TH>
          <TD><INPUT type="text" id="i2" name="sc_topwindowtitle" value="<?=$sc_topwindowtitle?>" style="width:400px" onFocus='Text("i2", 1)' onBlur='Text("i2", 2)' /> <font color="#ff0000"></TD>
        </TR>
        <TR>
          <TH class="must">ロゴタイトル<br />（ロゴ上部の紹介テキスト）</TH>
          <TD><INPUT type="text" id="i2" name="sc_headertitle" value="<?=$sc_headertitle?>" style="width:400px" onFocus='Text("i2", 1)' onBlur='Text("i2", 2)' /> <font color="#ff0000"></TD>
        </TR>
        <TR>
          <TH class="must">見出し-教室紹介<br />（トップ画像上）</TH>
          <TD><INPUT type="text" id="i2" name="sc_toptitle" value="<?=$sc_toptitle?>" style="width:400px" onFocus='Text("i2", 1)' onBlur='Text("i2", 2)' /> <font color="#ff0000"></TD>
        </TR>
        <TR>
          <TH class="must">教室紹介太字（トップ画像右・塾タウン掲載時）</TH>
          <TD><INPUT type="text" id="i2" name="sc_topsubtitle" value="<?=$sc_topsubtitle?>" style="width:400px" onFocus='Text("i2", 1)' onBlur='Text("i2", 2)' /> <font color="#ff0000"></TD>
        </TR>
        <TR>
          <TH class="must">見出し-講習・イベント<br />（イベントバナー上）</TH>
          <TD><INPUT type="text" id="i2" name="sc_campaintitle" value="<?=$sc_campaintitle?>" style="width:400px" onFocus='Text("i2", 1)' onBlur='Text("i2", 2)' /> <font color="#ff0000"></TD>
        </TR>
        <TR>
          <TH class="must">見出し-コース</TH>
          <TD><INPUT type="text" id="i2" name="sc_coursetitle" value="<?=$sc_coursetitle?>" style="width:400px" onFocus='Text("i2", 1)' onBlur='Text("i2", 2)' /> <font color="#ff0000"></TD>
        </TR>
        <TR>
          <TH class="must">見出し-お知らせ・日記</TH>
          <TD><INPUT type="text" id="i2" name="sc_diarytitle" value="<?=$sc_diarytitle?>" style="width:400px" onFocus='Text("i2", 1)' onBlur='Text("i2", 2)' /> <font color="#ff0000"></TD>
        </TR>
        <TR>
          <TH class="must">入塾の流れテキスト<br >（入塾の流れページ内、トップ画像右）</TH>
          <TD><TEXTAREA name="sc_addmission" id="i10" rows="5" style="width:370" onFocus='Text("i10", 1)' onBlur='Text("i10", 2)' ><?=$sc_addmission?></TEXTAREA></TD>
        </TR>
      </TABLE>
      <br />
      <DIV id="title">メール受信先</DIV>
      <TABLE>
        <TR>
          <TH class="must">「お申し込み」<br />受信先メールアドレス</TH>
          <TD><INPUT TYPE="text" id="i4" name="sc_entrymail" VALUE="<?=$sc_entrymail?>" style="width:200px" onFocus='Text("i4", 1)' onBlur='Text("i4", 2)' ></TD>
        </TR>
        <TR>
          <TH class="">「お申し込み」<br />受信先メールアドレス</TH>
          <TD><INPUT TYPE="text" id="i5" name="sc_entrymail2" VALUE="<?=$sc_entrymail2?>" style="width:200px" onFocus='Text("i5", 1)' onBlur='Text("i5", 2)' ></TD>
		  </TR>

        <TR>
          <TH class="must">「資料請求」<br />「お問い合わせ」<br />受信先メールアドレス</TH>
          <TD><INPUT TYPE="text" id="i5" name="sc_infomail" VALUE="<?=$sc_infomail?>" style="width:200px" onFocus='Text("i5", 1)' onBlur='Text("i5", 2)' ></TD>
        </TR>

        <TR>
          <TH class="">「資料請求」<br />「お問い合わせ」<br />受信先メールアドレス</TH>
          <TD><INPUT TYPE="text" id="i5" name="sc_infomail2" VALUE="<?=$sc_infomail2?>" style="width:200px" onFocus='Text("i5", 1)' onBlur='Text("i5", 2)' ></TD>
		  </TR>

      </TABLE>
      <br />
      <DIV id="title">基本設定２</DIV>
      <TABLE>
<!--
        <TR>
          <TH class="must">教室責任者</TH>
          <TD><INPUT type="text" id="sc_master" name="sc_master" value="<?=$sc_master?>" onFocus='Text("sc_master", 1)' onBlur='Text("sc_master", 2)' /></TD>
        </TR>
        <TR>
          <TH class="must">教室責任者肩書き</TH>
          <TD><INPUT type="text" id="sc_position" name="sc_position" value="<?=$sc_position?>" onFocus='Text("sc_position", 1)' onBlur='Text("sc_position", 2)' /></TD>
        </TR>
//-->
        <TR>
          <TH class="must">対象学年アイコン<br />（トップ画像右・塾タウン掲載時）</TH>
          <TD>
            <INPUT type="checkbox" id="sc_age0" name="sc_age[0]" value="1" <?=$sc_ageChk1?> onFocus='Text("sc_age0", 1)' onBlur='Text("sc_age0", 2)' />幼児　
            <INPUT type="checkbox" id="sc_age1" name="sc_age[1]" value="2" <?=$sc_ageChk2?> onFocus='Text("sc_age1", 1)' onBlur='Text("sc_age1", 2)' />小学生　
            <INPUT type="checkbox" id="sc_age2" name="sc_age[2]" value="4" <?=$sc_ageChk3?> onFocus='Text("sc_age2", 1)' onBlur='Text("sc_age2", 2)' />中学生　
            <INPUT type="checkbox" id="sc_age3" name="sc_age[3]" value="8" <?=$sc_ageChk4?> onFocus='Text("sc_age3", 1)' onBlur='Text("sc_age3", 2)' />高校生　
            <INPUT type="checkbox" id="sc_age4" name="sc_age[4]" value="16" <?=$sc_ageChk5?> onFocus='Text("sc_age4", 1)' onBlur='Text("sc_age4", 2)' />浪人生　
            <INPUT type="checkbox" id="sc_age5" name="sc_age[5]" value="32" <?=$sc_ageChk6?> onFocus='Text("sc_age5", 1)' onBlur='Text("sc_age5", 2)' />大学生　
            <INPUT type="checkbox" id="sc_age6" name="sc_age[6]" value="64" <?=$sc_ageChk7?> onFocus='Text("sc_age6", 1)' onBlur='Text("sc_age6", 2)' />社会人　
          </TD>
        </TR>
        <TR>
          <TH class="must">授業形態アイコン<br />（トップ画像右・塾タウン掲載時）</TH>
          <TD>
            <INPUT type="checkbox" id="sc_classform0" name="sc_classform[0]" value="1" <?=$sc_classformChk1?> onFocus='Text("sc_classform0", 1)' onBlur='Text("sc_classform0", 2)' />集団　
            <INPUT type="checkbox" id="sc_classform1" name="sc_classform[1]" value="2" <?=$sc_classformChk2?> onFocus='Text("sc_classform1", 1)' onBlur='Text("sc_classform1", 2)' />少人数　
            <INPUT type="checkbox" id="sc_classform2" name="sc_classform[2]" value="4" <?=$sc_classformChk3?> onFocus='Text("sc_classform2", 1)' onBlur='Text("sc_classform2", 2)' />個別　
          </TD>
        </TR>
        <TR>
          <TH class="must">受付時間<br />（ロゴ右・各ページ最下部基本情報）</TH>
          <TD>
            <SELECT name="sc_start_h">
              <OPTION value="">--</OPTION>
              <?=$viewStartTime_h?>
            </SELECT>
            時
            <SELECT name="sc_start_m">
              <OPTION value="">--</OPTION>
              <?=$viewStartTime_m?>
            </SELECT>
            分
             〜 
            <SELECT name="sc_end_h">
              <OPTION value="">--</OPTION>
              <?=$viewEndTime_h?>
            </SELECT>
            時
            <SELECT name="sc_end_m">
              <OPTION value="">--</OPTION>
              <?=$viewEndTime_m?>
            </SELECT>
            分
          </TD>
        </TR>
        <TR>
          <TH class="must">定休日<br />（ロゴ右・各ページ最下部基本情報）</TH>
          <TD><INPUT type="text" id="i7" name="sc_holiday" value="<?=$sc_holiday?>" onFocus='Text("i7", 1)' onBlur='Text("i7", 2)' /></TD>
        </TR>
<!--

        <TR>
          <TH>教室ホームページ</TH>
          <TD><INPUT type="text" id="i23" name="sc_hp" value="<?=$sc_hp?>" onFocus='Text("i23", 1)' onBlur='Text("i23", 2)' style="width:300px;" /></TD>
        </TR>
//-->
        <TR>
          <TH class="must">交通<br />（各ページ最下部基本情報）</TH>
          <TD>
            <TABLE style="border:0px;style="width:650px"">
              <TR>
                <TD class="noline"><INPUT TYPE="text" name="es_line1" VALUE="<?=$es_line[1]?>" readonly /> <INPUT TYPE="text" name="es_sta1" VALUE="<?=$es_sta[1]?>" readonly /> 駅からバス <INPUT type="text" id="bus" name="es_bus1" value="<?=$es_bus[1]?>" onFocus='Text("bus", 1)' onBlur='Text("bus", 2)' style="width:30px;" />分　徒歩 <INPUT type="text" id="i8" name="es_walk1" value="<?=$es_walk[1]?>" onFocus='Text("i8", 1)' onBlur='Text("i8", 2)' style="width:30px;" />分　備考：<input type="text" name="es_biko1" value="<?=$es_biko[1]?>">　<INPUT type="button" name="line_setting" value="沿線・駅設定" onClick="OpenPageSta('es_line1','es_sta1','es_linecd1','es_stacd1','es_linecdname1');" /></TD>
              </TR>
            </TABLE>
          </TD>
        </TR>
<!--
        <TR>
          <TH>最寄沿線・駅2</TH>
          <TD>
            <TABLE style="border:0px;style="width:650px"">
              <TR>
                <TD class="noline"><INPUT TYPE="text" name="es_line2" VALUE="<?=$es_line[2]?>" readonly /> <INPUT TYPE="text" name="es_sta2" VALUE="<?=$es_sta[2]?>" readonly /> 駅からバス <INPUT type="text" id="bus100" name="es_bus2" value="<?=$es_bus[2]?>" onFocus='Text("bus100", 1)' onBlur='Text("bus100", 2)' style="width:30px;" />分　徒歩 <INPUT type="text" id="i800" name="es_walk2" value="<?=$es_walk[2]?>" onFocus='Text("i800", 1)' onBlur='Text("i800", 2)' style="width:30px;" />分　備考：<input type="text" name="es_biko2" value="<?=$es_biko[2]?>">　<INPUT type="button" name="line_setting" value="沿線・駅設定" onClick="OpenPageSta('es_line2','es_sta2','es_linecd2','es_stacd2','es_linecdname2');" /></TD>
              </TR>
            </TABLE>
          </TD>
        </TR>
        <TR>
          <TH>最寄沿線・駅3</TH>
          <TD>
            <TABLE style="border:0px;style="width:650px"">
              <TR>
                <TD class="noline"><INPUT TYPE="text" name="es_line3" VALUE="<?=$es_line[3]?>" readonly /> <INPUT TYPE="text" name="es_sta3" VALUE="<?=$es_sta[3]?>" readonly /> 駅からバス <INPUT type="text" id="bus100" name="es_bus3" value="<?=$es_bus[3]?>" onFocus='Text("bus100", 1)' onBlur='Text("bus100", 2)' style="width:30px;" />分　徒歩 <INPUT type="text" id="i800" name="es_walk3" value="<?=$es_walk[3]?>" onFocus='Text("i800", 1)' onBlur='Text("i800", 2)' style="width:30px;" />分　備考：<input type="text" name="es_biko3" value="<?=$es_biko[3]?>">　<INPUT type="button" name="line_setting" value="沿線・駅設定" onClick="OpenPageSta('es_line3','es_sta3','es_linecd3','es_stacd3','es_linecdname3');" /></TD>
              </TR>
            </TABLE>
          </TD>
        </TR>
        <TR>
          <TH>最寄沿線・駅4</TH>
          <TD>
            <TABLE style="border:0px;style="width:650px"">
              <TR>
                <TD class="noline"><INPUT TYPE="text" name="es_line4" VALUE="<?=$es_line[4]?>" readonly /> <INPUT TYPE="text" name="es_sta4" VALUE="<?=$es_sta[4]?>" readonly /> 駅からバス <INPUT type="text" id="bus100" name="es_bus4" value="<?=$es_bus[4]?>" onFocus='Text("bus100", 1)' onBlur='Text("bus100", 2)' style="width:30px;" />分　徒歩 <INPUT type="text" id="i800" name="es_walk4" value="<?=$es_walk[4]?>" onFocus='Text("i800", 1)' onBlur='Text("i800", 2)' style="width:30px;" />分　備考：<input type="text" name="es_biko4" value="<?=$es_biko[4]?>">　<INPUT type="button" name="line_setting" value="沿線・駅設定" onClick="OpenPageSta('es_line4','es_sta4','es_linecd4','es_stacd4','es_linecdname4');" /></TD>
              </TR>
            </TABLE>
          </TD>
        </TR>
        <TR>
          <TH>最寄沿線・駅5</TH>
          <TD>
            <TABLE style="border:0px;style="width:650px"">
              <TR>
                <TD class="noline"><INPUT TYPE="text" name="es_line5" VALUE="<?=$es_line[5]?>" readonly /> <INPUT TYPE="text" name="es_sta5" VALUE="<?=$es_sta[5]?>" readonly /> 駅からバス <INPUT type="text" id="bus100" name="es_bus5" value="<?=$es_bus[5]?>" onFocus='Text("bus100", 1)' onBlur='Text("bus100", 2)' style="width:30px;" />分　徒歩 <INPUT type="text" id="i800" name="es_walk5" value="<?=$es_walk[5]?>" onFocus='Text("i800", 1)' onBlur='Text("i800", 2)' style="width:30px;" />分　備考：<input type="text" name="es_biko5" value="<?=$es_biko[5]?>">　<INPUT type="button" name="line_setting" value="沿線・駅設定" onClick="OpenPageSta('es_line5','es_sta5','es_linecd5','es_stacd5','es_linecdname5');" /></TD>
              </TR>
            </TABLE>
          </TD>
        </TR>
        <TR>
          <TH>実績校</TH>
          <TD><TEXTAREA name="sc_results" id="i10" rows="5" style="width:370" onFocus='Text("i10", 1)' onBlur='Text("i10", 2)' ><?=$sc_results?></TEXTAREA></TD>
        </TR>
        <TR>
          <TH>在校生徒学校</TH>
          <TD><TEXTAREA name="sc_students" id="i11" rows="5" style="width:370" onFocus='Text("i11", 1)' onBlur='Text("i11", 2)' ><?=$sc_students?></TEXTAREA></TD>
        </TR>
//-->
<!--===============================================-->
        <TR>
          <TH>教室紹介テキスト<br />（トップ画像右・塾タウン掲載時）</TH>
          <TD><TEXTAREA name="sc_pr" id="i12" rows="5" style="width:370" onFocus='Text("i12", 1)' onBlur='Text("i12", 2)' ><?=$sc_pr?></TEXTAREA></TD>
        </TR>
        <TR>
<!--===============================================-->
          <TH>ロゴ画像</TH>
          <TD>
<?=$cl_logo_txt?>
<BR><font color="#ff0000">※画像は2MB以下のGIF画像かJPEG画像をアップしてください</font>		
          </TD>
        </TR>
<!--===============================================-->
          <TH>モバイル<br />ロゴ画像</TH>
          <TD>
<?=$cl_logo_mobile_txt?>
<BR><font color="#ff0000">※画像は2MB以下のGIF画像かJPEG画像をアップしてください</font>		
          </TD>
        </TR>
<!--===============================================-->
        <TR>
          <TH>トップ画像</TH>
          <TD>
<?=$cl_photo_txt?>
<BR><font color="#ff0000">※画像は2MB以下のGIF画像かJPEG画像をアップしてください</font>		
          </TD>
		  </TR>
<!--===============================================-->
        <TR>
          <TH>基本情報画像<br />（各ページ最下部基本情報）</TH>
          <TD>
<?=$cl_staff_txt?>
<BR><font color="#ff0000">※画像は2MB以下のGIF画像かJPEG画像をアップしてください</font>		
          </TD>
        </TR>
<!--
        <TR>
          <TH>会社概要用動画</TH>
          <TD><INPUT TYPE="text" id="movie" name="sc_movie" VALUE="<?=$sc_movie?>" style="width:300px" onFocus='Text("movie", 1)' onBlur='Text("movie", 2)' ></TD>
        </TR>
//-->
        <TR>
          <TH class="must">教室地図<br />（教室案内ページ内）</TH>
          <TD>
<input type="text" value="" id="zip" size="40" onFocus='Text("zip", 1)' onBlur='Text("zip", 2)'/>
<input type="button" value="住所検索" onClick="showAddress()" />
<div id="gmap" style="width: 370px; height: 370px"></div>
<input type="button" name="onMarker" value="マーカー" onClick="marker('<?=$param_marker_com_img?>','<?=$param_marker_shadow_img?>')" /><br />
		<input type="button" value="＋" onclick="zmup()">
		<input type="button" value="−" onclick="zmdown()">
<input type="hidden" id="mapX" name="sc_keido" value="<?=$sc_keido?>"/>
<input type="hidden" id="mapY" name="sc_ido" value="<?=$sc_ido?>"/>
<input type="hidden" id="zoomN" name="sc_zoom" value="<?=$sc_zoom?>"/><BR>
<input type="hidden" id="marker_flg" name="mkr_flg" value=""/><BR>
          </TD>
        </TR>
        <TR>
          <TH>個人情報保護方針</TH>
          <TD><TEXTAREA NAME="sc_privacy" id="i13" onFocus='Text("i13", 1)' onBlur='Text("i13", 2)' style="width:725px" rows="20"><?=$sc_privacy?></TEXTAREA></TD>
        </TR>
<!--
        <TR>
          <TH>HTML自由表記内容(右メニュー用)</TH>
          <TD>
            <INPUT type="image" src="<?=$param_html_btn_img_path?>icon_b.gif" alt="強調" onClick="HTML_TAG('free_text','B','2');return false;"/>
            <INPUT type="image" src="<?=$param_html_btn_img_path?>icon_a.gif" alt="リンク" onClick="HTML_TAG( 'free_text','A','2');return false;" />
            <INPUT type="image" src="<?=$param_html_btn_img_path?>icon_u.gif" alt="下線" onClick="HTML_TAG('free_text','U','2');return false;" />
            <INPUT type="image" src="<?=$param_html_btn_img_path?>icon_s.gif" alt="取り消し線" onClick="HTML_TAG('free_text','S','2');return false;" />
            <INPUT type="image" src="<?=$param_html_btn_img_path?>icon_i.gif" alt="斜体" onClick="HTML_TAG('free_text','I','2');return false;" />
            <INPUT type="image" src="<?=$param_html_btn_img_path?>icon_color_red.gif" alt="文字色(赤)" onClick="HTML_TAG('free_text','FONT-RED','2');return false;" />
            <INPUT type="image" src="<?=$param_html_btn_img_path?>icon_color_blue.gif" alt="文字色(青)" onClick="HTML_TAG('free_text','FONT-BLUE','2');return false;" />
            <INPUT type="image" src="<?=$param_html_btn_img_path?>icon_color_yellow.gif" alt="文字色(黄)" onClick="HTML_TAG('free_text','FONT-YELLOW','2');return false;" />
            <INPUT type="image" src="<?=$param_html_btn_img_path?>icon_color_green.gif" alt="文字色(緑)" onClick="HTML_TAG('free_text','FONT-GREEN','2');return false;" />
            <br />
            <TEXTAREA id="free_text" name="sc_rhtml" cols="50" rows="10" onFocus='Text("free_text", 1)' onBlur='Text("free_text", 2)' ><?=$sc_rhtml?></TEXTAREA>
          </TD>
        </TR>
//-->
        <TR>
          <TH>HTML自由表記内容(上部)</TH>
          <TD>
            <TEXTAREA cols="50" rows="10" name="sc_thtml"><?=$sc_thtml?></TEXTAREA>
          </TD>
        </TR>

        <TR>
          <TH>HTML自由表記内容(左メニュー用)</TH>
          <TD>
            <INPUT type="image" src="<?=$param_html_btn_img_path?>icon_b.gif" alt="強調" onClick="HTML_TAG('free_text2','B','2');return false;"/>
            <INPUT type="image" src="<?=$param_html_btn_img_path?>icon_a.gif" alt="リンク" onClick="HTML_TAG( 'free_text2','A','2');return false;" />
            <INPUT type="image" src="<?=$param_html_btn_img_path?>icon_u.gif" alt="下線" onClick="HTML_TAG('free_text2','U','2');return false;" />
            <INPUT type="image" src="<?=$param_html_btn_img_path?>icon_s.gif" alt="取り消し線" onClick="HTML_TAG('free_text2','S','2');return false;" />
            <INPUT type="image" src="<?=$param_html_btn_img_path?>icon_i.gif" alt="斜体" onClick="HTML_TAG('free_text2','I','2');return false;" />
            <INPUT type="image" src="<?=$param_html_btn_img_path?>icon_color_red.gif" alt="文字色(赤)" onClick="HTML_TAG('free_text2','FONT-RED','2');return false;" />
            <INPUT type="image" src="<?=$param_html_btn_img_path?>icon_color_blue.gif" alt="文字色(青)" onClick="HTML_TAG('free_text2','FONT-BLUE','2');return false;" />
            <INPUT type="image" src="<?=$param_html_btn_img_path?>icon_color_yellow.gif" alt="文字色(黄)" onClick="HTML_TAG('free_text2','FONT-YELLOW','2');return false;" />
            <INPUT type="image" src="<?=$param_html_btn_img_path?>icon_color_green.gif" alt="文字色(緑)" onClick="HTML_TAG('free_text2','FONT-GREEN','2');return false;" />
            <br />
            <TEXTAREA id="free_text2" name="sc_lhtml" cols="50" rows="10" onFocus='Text("free_text2", 1)' onBlur='Text("free_text2", 2)' ><?=$sc_lhtml?></TEXTAREA>
          </TD>
        </TR>

      </TABLE>
    </DIV>
    <br />
    <TABLE>
      <TR><TD VALIGN="top">
        <INPUT type="hidden" name="mode" value="EDIT" />
        <INPUT type="hidden" name="sc_clid" value="<?=$_SESSION['_cl_id']?>" />
        <INPUT type="hidden" name="sc_logo_lastupd" value="<?=$sc_logo_lastupd?>" />
        <INPUT type="hidden" name="sc_logo_mobile_lastupd" value="<?=$sc_logo_mobile_lastupd?>" />
        <INPUT type="hidden" name="sc_topimg_lastupd" value="<?=$sc_topimg_lastupd?>" />
        <INPUT type="hidden" name="sc_mapimg_lastupd" value="<?=$sc_mapimg_lastupd?>" />
        <INPUT type="hidden" name="sc_id" value="<?=$sc_id?>" />
        <INPUT type="hidden" name="sc_stat" value="<?=$sc_stat?>" />
        <INPUT type="hidden" name="sc_update" value="<?=$sc_update?>" />
        <INPUT type="hidden" name="es_linecd1" value="<?=$es_linecd[1]?>" />
        <INPUT type="hidden" name="es_linecdname1" value="<?=$es_linecdname[1]?>" />
        <INPUT type="hidden" name="es_stacd1" value="<?=$es_stacd[1]?>" />

        <INPUT type="hidden" name="es_linecd2" value="<?=$es_linecd[2]?>" />
        <INPUT type="hidden" name="es_linecdname2" value="<?=$es_linecdname[2]?>" />
        <INPUT type="hidden" name="es_stacd2" value="<?=$es_stacd[2]?>" />

        <INPUT type="hidden" name="es_linecd3" value="<?=$es_linecd[3]?>" />
        <INPUT type="hidden" name="es_linecdname3" value="<?=$es_linecdname[3]?>" />
        <INPUT type="hidden" name="es_stacd3" value="<?=$es_stacd[3]?>" />

        <INPUT type="hidden" name="es_linecd4" value="<?=$es_linecd[4]?>" />
        <INPUT type="hidden" name="es_linecdname4" value="<?=$es_linecdname[4]?>" />
        <INPUT type="hidden" name="es_stacd4" value="<?=$es_stacd[4]?>" />

        <INPUT type="hidden" name="es_linecd5" value="<?=$es_linecd[5]?>" />
        <INPUT type="hidden" name="es_linecdname5" value="<?=$es_linecdname[5]?>" />
        <INPUT type="hidden" name="es_stacd5" value="<?=$es_stacd[5]?>" />

        <INPUT type="hidden" name="ensen1Flg" value="<?=$ensenFlg[1]?>" />
        <INPUT type="hidden" name="ensen2Flg" value="<?=$ensenFlg[2]?>" />
        <INPUT type="hidden" name="ensen3Flg" value="<?=$ensenFlg[3]?>" />
        <INPUT type="hidden" name="ensen4Flg" value="<?=$ensenFlg[4]?>" />
        <INPUT type="hidden" name="ensen5Flg" value="<?=$ensenFlg[5]?>" />

        <INPUT type="hidden" name="es_upddate1" value="<?=$es_upddate[1]?>" />
        <INPUT type="hidden" name="es_upddate2" value="<?=$es_upddate[2]?>" />
        <INPUT type="hidden" name="es_upddate3" value="<?=$es_upddate[3]?>" />
        <INPUT type="hidden" name="es_upddate4" value="<?=$es_upddate[4]?>" />
        <INPUT type="hidden" name="es_upddate5" value="<?=$es_upddate[5]?>" />

        <INPUT type="hidden" name="es_id1" value="<?=$es_id[1]?>" />
        <INPUT type="hidden" name="es_id2" value="<?=$es_id[2]?>" />
        <INPUT type="hidden" name="es_id3" value="<?=$es_id[3]?>" />
        <INPUT type="hidden" name="es_id4" value="<?=$es_id[4]?>" />
        <INPUT type="hidden" name="es_id5" value="<?=$es_id[5]?>" />

        <INPUT type="hidden" name="sc_logoorg" value="<?=$sc_logoorg?>" />
        <INPUT type="hidden" name="sc_logo_mobile_org" value="<?=$sc_logo_mobile_org?>" />
        <INPUT type="hidden" name="sc_topimgorg" value="<?=$sc_topimgorg?>" />
        <INPUT type="hidden" name="sc_mapimgorg" value="<?=$sc_mapimgorg?>" />
        <INPUT type="hidden" name="sc_upddate" value="<?=$sc_upddate?>" />
        <INPUT type="button" value="登録する" style="width:150px" class="btn" onClick="return BlogInputCheck( this.form , this.form )"/>
        </FORM>
      </TD><TD VALIGN="top">
	<FORM ACTION="blog_main.php" METHOD="POST">
	　<INPUT TYPE="submit" VALUE="戻る" class="btn">
	</FORM>
      </TD></TR>
    </TABLE>
  </BODY>
</HTML>
