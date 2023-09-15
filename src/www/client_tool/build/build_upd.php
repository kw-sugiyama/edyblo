<?
/******************************************************************************
<< 不動産ブログ　Ver.1.O.0 >>
	Name: estate_upd.php
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
require_once ( SYS_PATH."dbif/basedb_EstateClass.php" );
require_once ( SYS_PATH."dbif/basedb_ClientClass.php" );
require_once ( SYS_PATH."dbif/basedb_DiaryClass.php" );
require_once ( SYS_PATH."dbif/viewdb_BuildClass.php" );
require_once ( SYS_PATH."common/base_common.php" );
require_once ( SYS_PATH."common/sys_common.php" );
include_once ( SYS_PATH."common/error.class.php" );
require_once ( SYS_PATH."common/ImageControl.class.php" );
require_once ( SYS_PATH."configs/param_file.conf" );
require_once ( SYS_PATH."configs/param_build.conf" );
require_once ( SYS_PATH."configs/param_room.conf" );


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


// 設備情報テキスト生成
$estate_equip_val = "";
if($_POST["price_hosyou"]!="")$estate_equip_val .= $_POST["price_hosyou"]."/";				// 家賃保障付きフラグ
if($_POST["price_kouko"]!="")$estate_equip_val .= $_POST["price_kouko"]."/";				// 公庫利用可フラグ
if($_POST["price_elebater"]!="")$estate_equip_val .= $_POST["price_elebater"]."/";			// エレベータ有フラグ
if($_POST["price_manshitsu"]!="")$estate_equip_val .= $_POST["price_manshitsu"]."/";			// 満室賃貸中フラグ
if($_POST["delivery_jimusyo"]!="")$estate_equip_val .= $_POST["delivery_jimusyo"]."/";			// 事務所使用可フラグ
if($_POST["delivery_pet"]!="")$estate_equip_val .= $_POST["delivery_pet"]."/";				// ペット相談フラグ
if($_POST["equip_suidou"]!="")$estate_equip_val .= $_POST["equip_suidou"]."/";				// 水道
if($_POST["equip_gasu"]!="")$estate_equip_val .= $_POST["equip_gasu"]."/";				// ガス


// 築年数生成
$build_age_val = "";
$build_age_year_val = sprintf( "%04d" , $_POST["build_age_year"] );
$build_age_month_val = sprintf( "%02d" , $_POST["build_age_month"] );
$build_age_val = $build_age_year_val."-".$build_age_month_val."-01";


// 物件郵便番号
$build_zip_val = "";
$build_zip_val = $_POST['estate_zip1']."-".$_POST['estate_zip2'];


// 物件郵便番号
if($_POST['room_floorflg']==1){
	$room_floor = $_POST['room_floor'];
}else{
	$room_floor = "-".$_POST['room_floor'];
}


$athComment = "";
$athComment .= "<INPUT TYPE=\"hidden\" NAME=\"error_mode\" VALUE=\"on\">";
FOREACH( $_POST as $key => $val ){
	$val = htmlspecialchars( stripslashes( $val ) );
        $athComment .= "<INPUT type=\"hidden\" name=\"{$key}\" value=\"{$val}\">\n";
}

switch( $_POST["mode"] ){
	case 'NEW':
		// ロゴ画像
                if( filesize($_FILES["estate_photo"]["tmp_name"]) > (1024*1024*2) ){
			$arrOther["ath_comment"] .= $athComment;
                        $obj_error->ViewErrMessage( "FILE_SIZE" , "ALL" , "build_mnt.php" , $arrOther );
                        exit;
                }
		IF( is_uploaded_file( $_FILES["estate_photo"]["tmp_name"] ) ){
			$imageInfo = @getimagesize( $_FILES["estate_photo"]["tmp_name"] );
			IF( @getimagesize( $_FILES["estate_photo"]["tmp_name"] ) === FALSE || ( $imageInfo[2] != 1 && $imageInfo[2] != 2 ) ){
			$arrOther["ath_comment"] .= $athComment;
                        	$obj_error->ViewErrMessage( "NOT_IMG" , "ALL" , "build_mnt.php" , $arrOther );
                        	exit;
			}
			$kakuLogo = split("\.",$_FILES["estate_photo"]["name"]);
			$photo_name_org = "estate_".$_SESSION['_cl_id']."_/.".$kakuLogo[1];
		}

		$obj_new = new basedb_EstateClassTblAccess;
		$obj_new->conn = $obj_conn->conn;


		$obj_new->estatedat[0]["estate_update"] = $_POST["estate_update"];
		$obj_new->estatedat[0]["estate_homeslimit"] = $_POST["estate_homeslimit"];
		$obj_new->estatedat[0]["estate_homesflg"] = $_POST["estate_homesflg"];
		$obj_new->estatedat[0]["estate_jishamono"] = $_POST["estate_jishamono"];
		$obj_new->estatedat[0]["estate_vacant"] = $_POST["estate_vacant"];
		$obj_new->estatedat[0]["estate_type"] = $_POST["estate_type"];
		$obj_new->estatedat[0]["estate_batchflg"] = $_POST["estate_batchflg"];
		$obj_new->estatedat[0]["estate_toushiflg"] = $_POST["estate_toushiflg"];
		$obj_new->estatedat[0]["estate_name"] = $_POST["estate_name"];
		$obj_new->estatedat[0]["estate_kana"] = $_POST["estate_kana"];
		$obj_new->estatedat[0]["estate_nameflg"] = $_POST["estate_nameflg"];
		$obj_new->estatedat[0]["estate_division"] = $_POST["estate_division"];
		$obj_new->estatedat[0]["estate_empty"] = $_POST["estate_empty"];
		$obj_new->estatedat[0]["estate_emptytext"] = $_POST["estate_emptytext"];
		$obj_new->estatedat[0]["estate_zip"] = $build_zip_val;
		$obj_new->estatedat[0]["estate_addcd"] = $_POST["estate_addcd"];
		$obj_new->estatedat[0]["estate_addname"] = $_POST["estate_addname"];
		$obj_new->estatedat[0]["estate_addopen"] = $_POST["estate_addopen"];
		$obj_new->estatedat[0]["estate_addclose"] = $_POST["estate_addclose"];
		$obj_new->estatedat[0]["estate_map"] = $_POST["estate_map"];
		$obj_new->estatedat[0]["estate_line1"] = $_POST["estate_line_cd_1"];
		$obj_new->estatedat[0]["estate_station1"] = $_POST["estate_sta_cd_1"];
		$obj_new->estatedat[0]["estate_busstop1"] = $_POST["estate_busstop1"];
		$obj_new->estatedat[0]["estate_bus1"] = $_POST["estate_bus1"];
		$obj_new->estatedat[0]["estate_walk1"] = $_POST["estate_walk1"];
		$obj_new->estatedat[0]["estate_line2"] = $_POST["estate_line_cd_2"];
		$obj_new->estatedat[0]["estate_station2"] = $_POST["estate_sta_cd_2"];
		$obj_new->estatedat[0]["estate_busstop2"] = $_POST["estate_busstop2"];
		$obj_new->estatedat[0]["estate_bus2"] = $_POST["estate_bus2"];
		$obj_new->estatedat[0]["estate_walk2"] = $_POST["estate_walk2"];
		$obj_new->estatedat[0]["estate_otherline"] = $_POST["estate_otherline"];
		$obj_new->estatedat[0]["estate_car"] = $_POST["estate_car"];
		$obj_new->estatedat[0]["tochi_chimoku"] = $_POST["tochi_chimoku"];
		$obj_new->estatedat[0]["tochi_usagearea"] = $_POST["tochi_usagearea"];
		$obj_new->estatedat[0]["tochi_cityplan"] = $_POST["tochi_cityplan"];
		$obj_new->estatedat[0]["tochi_terrain"] = $_POST["tochi_terrain"];
		$obj_new->estatedat[0]["tochi_areamethod"] = $_POST["tochi_areamethod"];
		$obj_new->estatedat[0]["tochi_area"] = $_POST["tochi_area"];
		$obj_new->estatedat[0]["tochi_loadarea"] = $_POST["tochi_loadarea"];
		$obj_new->estatedat[0]["tochi_loadratio"] = $_POST["tochi_loadratio"];
		$obj_new->estatedat[0]["tochi_share"] = $_POST["tochi_share"];
		$obj_new->estatedat[0]["tochi_setpack"] = $_POST["tochi_setpack"];
		$obj_new->estatedat[0]["tochi_setbackratio"] = $_POST["tochi_setbackratio"];
		$obj_new->estatedat[0]["tochi_coverage"] = $_POST["tochi_coverage"];
		$obj_new->estatedat[0]["tochi_yousekiritsu"] = $_POST["tochi_yousekiritsu"];
		$obj_new->estatedat[0]["tochi_setsudoustat"] = $_POST["tochi_setsudoustat"];
		$obj_new->estatedat[0]["tochi_setsudouazimuth1"] = $_POST["tochi_setsudouazimuth1"];
		$obj_new->estatedat[0]["tochi_setsudoumaguchi1"] = $_POST["tochi_setsudoumaguchi1"];
		$obj_new->estatedat[0]["tochi_setsudoutype1"] = $_POST["tochi_setsudoutype1"];
		$obj_new->estatedat[0]["tochi_setsudouwidth1"] = $_POST["tochi_setsudouwidth1"];
		$obj_new->estatedat[0]["tochi_ichishitei1"] = $_POST["tochi_ichishitei1"];
		$obj_new->estatedat[0]["tochi_setsudouazimuth2"] = $_POST["tochi_setsudouazimuth2"];
		$obj_new->estatedat[0]["tochi_setsudoumaguchi2"] = $_POST["tochi_setsudoumaguchi2"];
		$obj_new->estatedat[0]["tochi_setsudoutype2"] = $_POST["tochi_setsudoutype2"];
		$obj_new->estatedat[0]["tochi_setsudouwidth2"] = $_POST["tochi_setsudouwidth2"];
		$obj_new->estatedat[0]["tochi_ichishitei2"] = $_POST["tochi_ichishitei2"];
		$obj_new->estatedat[0]["tochi_setsudouazimuth3"] = $_POST["tochi_setsudouazimuth3"];
		$obj_new->estatedat[0]["tochi_setsudoumaguchi3"] = $_POST["tochi_setsudoumaguchi3"];
		$obj_new->estatedat[0]["tochi_setsudoutype3"] = $_POST["tochi_setsudoutype3"];
		$obj_new->estatedat[0]["tochi_setsudouwidth3"] = $_POST["tochi_setsudouwidth3"];
		$obj_new->estatedat[0]["tochi_ichishitei3"] = $_POST["tochi_ichishitei3"];
		$obj_new->estatedat[0]["tochi_setsudouazimuth4"] = $_POST["tochi_setsudouazimuth4"];
		$obj_new->estatedat[0]["tochi_setsudoumaguchi4"] = $_POST["tochi_setsudoumaguchi4"];
		$obj_new->estatedat[0]["tochi_setsudoutype4"] = $_POST["tochi_setsudoutype4"];
		$obj_new->estatedat[0]["tochi_setsudouwidth4"] = $_POST["tochi_setsudouwidth4"];
		$obj_new->estatedat[0]["tochi_ichishitei4"] = $_POST["tochi_ichishitei4"];
		$obj_new->estatedat[0]["tochi_kenri"] = $_POST["tochi_kenri"];
		$obj_new->estatedat[0]["tochi_todokede"] = $_POST["tochi_todokede"];
		$obj_new->estatedat[0]["tochi_seigen"] = $_POST["tochi_seigen"];

		$obj_new->estatedat[0]["build_structure"] = $_POST["build_structure"];
		$obj_new->estatedat[0]["build_areamethod"] = $_POST["build_areamethod"];
		$obj_new->estatedat[0]["build_area"] = $_POST["build_area"];
		$obj_new->estatedat[0]["build_shikichiarea"] = $_POST["build_shikichiarea"];
		$obj_new->estatedat[0]["build_nobeyukaarea"] = $_POST["build_nobeyukaarea"];
		$obj_new->estatedat[0]["build_kenchikuarea"] = $_POST["build_kenchikuarea"];
		$obj_new->estatedat[0]["build_floor"] = $_POST["build_floor"];
		$obj_new->estatedat[0]["build_basement"] = $_POST["build_basement"];
		$obj_new->estatedat[0]["build_age"] = $build_age_val;
		$obj_new->estatedat[0]["build_newflg"] = $_POST["build_newflg"];

		$obj_new->estatedat[0]["manager_stat"] = $_POST["manager_stat"];
		$obj_new->estatedat[0]["manager_type"] = $_POST["manager_type"];
		$obj_new->estatedat[0]["manager_flg"] = $_POST["manager_flg"];
		$obj_new->estatedat[0]["manager_comname"] = $_POST["manager_comname"];

		$obj_new->estatedat[0]["room_floor"] = $room_floor;
		$obj_new->estatedat[0]["room_balconyarea"] = $_POST["room_balconyarea"];
		$obj_new->estatedat[0]["room_azimuth"] = $_POST["room_azimuth"];

		$obj_new->estatedat[0]["madori_roomnum"] = $_POST["madori_roomnum"];
		$obj_new->estatedat[0]["madori_roomtype"] = $_POST["madori_roomtype"];
		$obj_new->estatedat[0]["madori_type1"] = $_POST["madori_type1"];
		$obj_new->estatedat[0]["madori_jyounum1"] = $_POST["madori_jyounum1"];
		$obj_new->estatedat[0]["madori_floor1"] = $_POST["madori_floor1"];
		$obj_new->estatedat[0]["madori_num1"] = $_POST["madori_num1"];
		$obj_new->estatedat[0]["madori_type2"] = $_POST["madori_type2"];
		$obj_new->estatedat[0]["madori_jyounum2"] = $_POST["madori_jyounum2"];
		$obj_new->estatedat[0]["madori_floor2"] = $_POST["madori_floor2"];
		$obj_new->estatedat[0]["madori_num2"] = $_POST["madori_num2"];
		$obj_new->estatedat[0]["madori_type3"] = $_POST["madori_type3"];
		$obj_new->estatedat[0]["madori_jyounum3"] = $_POST["madori_jyounum3"];
		$obj_new->estatedat[0]["madori_floor3"] = $_POST["madori_floor3"];
		$obj_new->estatedat[0]["madori_num3"] = $_POST["madori_num3"];
		$obj_new->estatedat[0]["madori_type4"] = $_POST["madori_type4"];
		$obj_new->estatedat[0]["madori_jyounum4"] = $_POST["madori_jyounum4"];
		$obj_new->estatedat[0]["madori_floor4"] = $_POST["madori_floor4"];
		$obj_new->estatedat[0]["madori_num4"] = $_POST["madori_num4"];
		$obj_new->estatedat[0]["madori_type5"] = $_POST["madori_type5"];
		$obj_new->estatedat[0]["madori_jyounum5"] = $_POST["madori_jyounum5"];
		$obj_new->estatedat[0]["madori_floor5"] = $_POST["madori_floor5"];
		$obj_new->estatedat[0]["madori_num5"] = $_POST["madori_num5"];
		$obj_new->estatedat[0]["madori_type6"] = $_POST["madori_type6"];
		$obj_new->estatedat[0]["madori_jyounum6"] = $_POST["madori_jyounum6"];
		$obj_new->estatedat[0]["madori_floor6"] = $_POST["madori_floor6"];
		$obj_new->estatedat[0]["madori_num6"] = $_POST["madori_num6"];
		$obj_new->estatedat[0]["madori_type7"] = $_POST["madori_type7"];
		$obj_new->estatedat[0]["madori_jyounum7"] = $_POST["madori_jyounum7"];
		$obj_new->estatedat[0]["madori_floor7"] = $_POST["madori_floor7"];
		$obj_new->estatedat[0]["madori_num7"] = $_POST["madori_num7"];
		$obj_new->estatedat[0]["madori_type8"] = $_POST["madori_type8"];
		$obj_new->estatedat[0]["madori_jyounum8"] = $_POST["madori_jyounum8"];
		$obj_new->estatedat[0]["madori_floor8"] = $_POST["madori_floor8"];
		$obj_new->estatedat[0]["madori_num8"] = $_POST["madori_num8"];
		$obj_new->estatedat[0]["madori_type9"] = $_POST["madori_type9"];
		$obj_new->estatedat[0]["madori_jyounum9"] = $_POST["madori_jyounum9"];
		$obj_new->estatedat[0]["madori_floor9"] = $_POST["madori_floor9"];
		$obj_new->estatedat[0]["madori_num9"] = $_POST["madori_num9"];
		$obj_new->estatedat[0]["madori_type10"] = $_POST["madori_type10"];
		$obj_new->estatedat[0]["madori_jyounum10"] = $_POST["madori_jyounum10"];
		$obj_new->estatedat[0]["madori_floor10"] = $_POST["madori_floor10"];
		$obj_new->estatedat[0]["madori_num10"] = $_POST["madori_num10"];
		$obj_new->estatedat[0]["madori_biko"] = $_POST["madori_biko"];

		$obj_new->estatedat[0]["feacher_all"] = $_POST["feacher_all"];
		$obj_new->estatedat[0]["feacher_a"] = $_POST["feacher_a"];
		$obj_new->estatedat[0]["feacher_b"] = $_POST["feacher_b"];

		$obj_new->estatedat[0]["biko_all"] = $_POST["biko_all"];
		$obj_new->estatedat[0]["biko_a"] = $_POST["biko_a"];
		$obj_new->estatedat[0]["biko_b"] = $_POST["biko_b"];
		$obj_new->estatedat[0]["biko_url1"] = $_POST["biko_url1"];
		$obj_new->estatedat[0]["biko_url2"] = $_POST["biko_url2"];
		$obj_new->estatedat[0]["biko_memo"] = $_POST["biko_memo"];

		$obj_new->estatedat[0]["price_main"] = $_POST["price_main"];
		$obj_new->estatedat[0]["price_flg"] = $_POST["price_flg"];
		$obj_new->estatedat[0]["price_stat"] = $_POST["price_stat"];
		$obj_new->estatedat[0]["price_taxflg"] = $_POST["price_taxflg"];
		$obj_new->estatedat[0]["price_tax"] = $_POST["price_tax"];
		$obj_new->estatedat[0]["price_tsubotanka"] = $_POST["price_tsubotanka"];
		$obj_new->estatedat[0]["price_cntrlprice"] = $_POST["price_cntrlprice"];
		$obj_new->estatedat[0]["price_cntrlpricetax"] = $_POST["price_cntrlpricetax"];
		$obj_new->estatedat[0]["price_rei"] = $_POST["price_rei"];
		$obj_new->estatedat[0]["price_reitax"] = $_POST["price_reitax"];
		$obj_new->estatedat[0]["price_siki"] = $_POST["price_siki"];
		$obj_new->estatedat[0]["price_secprice"] = $_POST["price_secprice"];
		$obj_new->estatedat[0]["price_kenrikin"] = $_POST["price_kenrikin"];
		$obj_new->estatedat[0]["price_kenrikintax"] = $_POST["price_kenrikintax"];
		$obj_new->estatedat[0]["price_joutokin"] = $_POST["price_joutokin"];
		$obj_new->estatedat[0]["price_joutokintax"] = $_POST["price_joutokintax"];
		$obj_new->estatedat[0]["price_sikibiki"] = $_POST["price_sikibiki"];
		$obj_new->estatedat[0]["price_sikibikitime"] = $_POST["price_sikibikitime"];
		$obj_new->estatedat[0]["price_updprice"] = $_POST["price_updprice"];
		$obj_new->estatedat[0]["price_fullyield"] = $_POST["price_fullyield"];
		$obj_new->estatedat[0]["price_nowyield"] = $_POST["price_nowyield"];
		$obj_new->estatedat[0]["price_insuranceprice"] = $_POST["price_insuranceprice"];
		$obj_new->estatedat[0]["price_insuranceperiod"] = $_POST["price_insuranceperiod"];
		$obj_new->estatedat[0]["price_leaseprice"] = $_POST["price_leaseprice"];
		$obj_new->estatedat[0]["price_contractyear"] = $_POST["price_contractyear"];
		$obj_new->estatedat[0]["price_contractmonth"] = $_POST["price_contractmonth"];
		$obj_new->estatedat[0]["price_contractdivision"] = $_POST["price_contractdivision"];
		$obj_new->estatedat[0]["price_mendingprice"] = $_POST["price_mendingprice"];
		$obj_new->estatedat[0]["price_mendingfund"] = $_POST["price_mendingfund"];
		$obj_new->estatedat[0]["price_otherpricetitle1"] = $_POST["price_otherpricetitle1"];
		$obj_new->estatedat[0]["price_otherprice1"] = $_POST["price_otherprice1"];
		$obj_new->estatedat[0]["price_otherpricetitle2"] = $_POST["price_otherpricetitle2"];
		$obj_new->estatedat[0]["price_otherprice2"] = $_POST["price_otherprice2"];
		$obj_new->estatedat[0]["price_otherpricetitle3"] = $_POST["price_otherpricetitle3"];
		$obj_new->estatedat[0]["price_otherprice3"] = $_POST["price_otherprice3"];

		$obj_new->estatedat[0]["contract_price"] = $_POST["contract_price"];
		$obj_new->estatedat[0]["contract_date"] = $_POST["contract_date"];
		$obj_new->estatedat[0]["contract_taxflg"] = $_POST["contract_taxflg"];
		$obj_new->estatedat[0]["contract_tax"] = $_POST["contract_tax"];

		$obj_new->estatedat[0]["parking_price"] = $_POST["parking_price"];
		$obj_new->estatedat[0]["parking_pricetax"] = $_POST["parking_pricetax"];
		$obj_new->estatedat[0]["parking_division"] = $_POST["parking_division"];
		$obj_new->estatedat[0]["parking_distance"] = $_POST["parking_distance"];
		$obj_new->estatedat[0]["parking_emptynum"] = $_POST["parking_emptynum"];
		$obj_new->estatedat[0]["parking_biko"] = $_POST["parking_biko"];

		$obj_new->estatedat[0]["delivery_vacant"] = $_POST["delivery_vacant"];
		$obj_new->estatedat[0]["delivery_flg"] = $_POST["delivery_flg"];
		$obj_new->estatedat[0]["delivery_date"] = $_POST["delivery_date"];
		$obj_new->estatedat[0]["delivery_season"] = $_POST["delivery_season"];

		$obj_new->estatedat[0]["surround_syougakkou"] = $_POST["surround_syougakkou"];
		$obj_new->estatedat[0]["surround_syoudistance"] = $_POST["surround_syoudistance"];
		$obj_new->estatedat[0]["surround_syoucd"] = $_POST["surround_syoucd"];
		$obj_new->estatedat[0]["surround_chuugakkou"] = $_POST["surround_chuugakkou"];
		$obj_new->estatedat[0]["surround_chuudistance"] = $_POST["surround_chuudistance"];
		$obj_new->estatedat[0]["surround_chuucd"] = $_POST["surround_chuucd"];
		$obj_new->estatedat[0]["surround_konbinidistance"] = $_POST["surround_konbinidistance"];
		$obj_new->estatedat[0]["surround_superdistance"] = $_POST["surround_superdistance"];
		$obj_new->estatedat[0]["surround_hospitaldistance"] = $_POST["surround_hospitaldistance"];

		$obj_new->estatedat[0]["tanto_name"] = $_POST["tanto_name"];

		$obj_new->estatedat[0]["trade_mode"] = $_POST["trade_mode"];
		$obj_new->estatedat[0]["trade_date"] = $_POST["trade_date"];

		$obj_new->estatedat[0]["kyakuzuke_flg"] = $_POST["kyakuzuke_flg"];
		$obj_new->estatedat[0]["kyakuzuke_date"] = $_POST["kyakuzuke_date"];
		$obj_new->estatedat[0]["kyakuzuke_price"] = $_POST["kyakuzuke_price"];
		$obj_new->estatedat[0]["kyakuzuke_bunpai"] = $_POST["kyakuzuke_bunpai"];
		$obj_new->estatedat[0]["kyakuzuke_futan"] = $_POST["kyakuzuke_futan"];
		$obj_new->estatedat[0]["kyakuzuke_message"] = $_POST["kyakuzuke_message"];

		$obj_new->estatedat[0]["motozuke_name"] = $_POST["motozuke_name"];
		$obj_new->estatedat[0]["motozuke_zip"] = $_POST["motozuke_zip"];
		$obj_new->estatedat[0]["motozuke_addcd"] = $_POST["motozuke_addcd"];
		$obj_new->estatedat[0]["motozuke_addname"] = $_POST["motozuke_addname"];
		$obj_new->estatedat[0]["motozuke_addopen"] = $_POST["motozuke_addopen"];
		$obj_new->estatedat[0]["motozuke_tell"] = $_POST["motozuke_tell"];
		$obj_new->estatedat[0]["motozuke_fax"] = $_POST["motozuke_fax"];
		$obj_new->estatedat[0]["motozuke_tanto"] = $_POST["motozuke_tanto"];
		$obj_new->estatedat[0]["motozuke_biko"] = $_POST["motozuke_biko"];

		$obj_new->estatedat[0]["owner_name"] = $_POST["owner_name"];
		$obj_new->estatedat[0]["owner_zip"] = $_POST["owner_zip"];
		$obj_new->estatedat[0]["owner_addcd"] = $_POST["owner_addcd"];
		$obj_new->estatedat[0]["owner_addname"] = $_POST["owner_addname"];
		$obj_new->estatedat[0]["owner_addopen"] = $_POST["owner_addopen"];
		$obj_new->estatedat[0]["owner_tell"] = $_POST["owner_tell"];
		$obj_new->estatedat[0]["owner_fax"] = $_POST["owner_fax"];
		$obj_new->estatedat[0]["owner_biko"] = $_POST["owner_biko"];

		$obj_new->estatedat[0]["openhouse_start"] = $_POST["openhouse_start"];
		$obj_new->estatedat[0]["openhouse_end"] = $_POST["openhouse_end"];
		$obj_new->estatedat[0]["openhouse_period"] = $_POST["openhouse_period"];
		$obj_new->estatedat[0]["openhouse_biko"] = $_POST["openhouse_biko"];

		$obj_new->estatedat[0]["img_org1"] = $_POST["img_org1"];
		$obj_new->estatedat[0]["img_type1"] = $_POST["img_type1"];
		$obj_new->estatedat[0]["img_comment1"] = $_POST["img_comment1"];
		$obj_new->estatedat[0]["img_org2"] = $_POST["img_org2"];
		$obj_new->estatedat[0]["img_type2"] = $_POST["img_type2"];
		$obj_new->estatedat[0]["img_comment2"] = $_POST["img_comment2"];
		$obj_new->estatedat[0]["img_org3"] = $_POST["img_org3"];
		$obj_new->estatedat[0]["img_type3"] = $_POST["img_type3"];
		$obj_new->estatedat[0]["img_comment3"] = $_POST["img_comment3"];
		$obj_new->estatedat[0]["img_org4"] = $_POST["img_org4"];
		$obj_new->estatedat[0]["img_type4"] = $_POST["img_type4"];
		$obj_new->estatedat[0]["img_comment4"] = $_POST["img_comment4"];
		$obj_new->estatedat[0]["img_org5"] = $_POST["img_org5"];
		$obj_new->estatedat[0]["img_type5"] = $_POST["img_type5"];
		$obj_new->estatedat[0]["img_comment5"] = $_POST["img_comment5"];
		$obj_new->estatedat[0]["img_org6"] = $_POST["img_org6"];
		$obj_new->estatedat[0]["img_type6"] = $_POST["img_type6"];
		$obj_new->estatedat[0]["img_comment6"] = $_POST["img_comment6"];
		$obj_new->estatedat[0]["img_org7"] = $_POST["img_org7"];
		$obj_new->estatedat[0]["img_type7"] = $_POST["img_type7"];
		$obj_new->estatedat[0]["img_comment7"] = $_POST["img_comment7"];
		$obj_new->estatedat[0]["img_org8"] = $_POST["img_org8"];
		$obj_new->estatedat[0]["img_type8"] = $_POST["img_type8"];
		$obj_new->estatedat[0]["img_comment8"] = $_POST["img_comment8"];
		$obj_new->estatedat[0]["img_org9"] = $_POST["img_org9"];
		$obj_new->estatedat[0]["img_type9"] = $_POST["img_type9"];
		$obj_new->estatedat[0]["img_comment9"] = $_POST["img_comment9"];
		$obj_new->estatedat[0]["img_org10"] = $_POST["img_org10"];
		$obj_new->estatedat[0]["img_type10"] = $_POST["img_type10"];
		$obj_new->estatedat[0]["img_comment10"] = $_POST["img_comment10"];

		$obj_new->estatedat[0]["estate_group"] = $_POST["estate_group"];
		$obj_new->estatedat[0]["estate_equip"] = $estate_equip_val;
		$obj_new->estatedat[0]["estate_pointnum"] = $_POST["estate_pointnum"];
		$obj_new->estatedat[0]["estate_end"] = $_POST["estate_end"];
		$obj_new->estatedat[0]["estate_clid"] = $_SESSION["_cl_id"];
		$obj_new->estatedat[0]["estate_ido"] = $_POST["estate_ido"];
		$obj_new->estatedat[0]["estate_keido"] = $_POST["estate_keido"];
		$obj_new->estatedat[0]["estate_zoom"] = $_POST["estate_zoom"];
		$obj_new->estatedat[0]["estate_adminid"] = $_POST["estate_adminid"];
		$obj_new->estatedat[0]["estate_insdate"] = $_POST["estate_insdate"];
		$obj_new->estatedat[0]["estate_upddate"] = $_POST["estate_upddate"];
		$obj_new->estatedat[0]["estate_deldate"] = $_POST["estate_deldate"];
		$obj_new->estatedat[0]["estate_yobi1"] = $_POST["estate_yobi1"];
		$obj_new->estatedat[0]["estate_yobi2"] = $_POST["estate_yobi2"];
		$obj_new->estatedat[0]["estate_yobi3"] = $_POST["estate_yobi3"];
		$obj_new->estatedat[0]["estate_yobi4"] = $_POST["estate_yobi4"];
		$obj_new->estatedat[0]["estate_yobi5"] = $_POST["estate_yobi5"];
		$suc = $obj_new->basedb_InsEstate();
/*
		IF( $suc == "0" ){
			// 画像保存・削除処理
			IF( is_uploaded_file( $_FILES["estate_photo"]["tmp_name"] ) ){
				// 一度画像を削除==>再度コピー
				IF( file_exists($param_estate_photo_path.$_POST['estate_photo_lastupd'] ) && $_POST['estate_photo_lastupd'] != "" ){
					unlink( $param_estate_photo_path.$_POST['estate_photo_lastupd'] );
				}
				// 同じ名前で、UPLOADされたデータをコピー
				IF( is_uploaded_file($_FILES["estate_photo"]["tmp_name"]) && $obj_new->estatedat[0]["estate_photo"] != "" ){
					move_uploaded_file( $_FILES["estate_photo"]["tmp_name"] , $param_estate_photo_path.$obj_new->estatedat[0]["estate_photo"] );
					chmod( $param_estate_photo_path.$obj_new->estatedat[0]["estate_photo"] , 0755 );
				}

				$obj_photo_new = new ImageControl;
				$obj_photo_new->max_w = 300;
				$obj_photo_new->max_h = 300;
				$obj_photo_new->origin_dir = $param_estate_photo_path;
				$obj_photo_new->origin_img = $obj_new->estatedat[0]["estate_photo"];
				$obj_photo_new->gd_ver = 1;
				list($resize_photo,$imageType) = $obj_photo_new->ImageResizeSave();
				if($resize_photo == -1){
	                        	$obj_error->ViewErrMessage( "SYSTEM" , "ALL" , "blog_mnt.php" , $arrOther  );
	                       		exit;
				}

				$obj_photo_save_new = new ImageControl;
				$obj_photo_save_new->origin_dir = $param_estate_photo_path;
				$obj_photo_save_new->origin_img = $obj_new->estatedat[0]["estate_photo"];
				$obj_photo_save_new->imageResource = $resize_photo;
				$photo_suc = $obj_photo_save_new->ImageSave($imageType);
				if($photo_suc == -1){
	                        	$obj_error->ViewErrMessage( "SYSTEM" , "ALL" , "blog_mnt.php" , $arrOther  );
	                       		exit;
				}
			}
		}
*/
                if( $suc == -1 ){
                        $arrOther["ath_comment"] = "<INPUT TYPE=\"hidden\" NAME=\"stpos\" VALUE=\"{$_POST['stpos']}\">";
			$arrOther["ath_comment"] .= $athComment;
                        $obj_error->ViewErrMessage( "INS_ERROR" , "ALL" , "build_mnt.php" , $arrOther );
                        exit;
                }
                if( $suc == 2 ){
                        $arrOther["ath_comment"] = "<INPUT TYPE=\"hidden\" NAME=\"stpos\" VALUE=\"{$_POST['stpos']}\">";
			$arrOther["ath_comment"] .= $athComment;
                        $obj_error->ViewErrMessage( "DISP_NO" , "ALL" , "build_mnt.php" , $arrOther );
                        exit;
                }
		$message = "建物情報を登録しました。";
		break;
		
		
	case 'EDIT':
		// ロゴ画像
/*
                if( filesize($_FILES["estate_photo"]["tmp_name"]) > (1024*1024*2) ){
			$arrOther["ath_comment"] .= $athComment;
                        $obj_error->ViewErrMessage( "FILE_SIZE" , "ALL" , "build_mnt.php" , $arrOther );
                        exit;
                }
		IF( is_uploaded_file( $_FILES["estate_photo"]["tmp_name"] ) ){
			$imageInfo = @getimagesize( $_FILES["estate_photo"]["tmp_name"] );
			IF( @getimagesize( $_FILES["estate_photo"]["tmp_name"] ) === FALSE || ( $imageInfo[2] != 1 && $imageInfo[2] != 2 ) ){
				$arrOther["ath_comment"] .= $athComment;
	                        $obj_error->ViewErrMessage( "NOT_IMG" , "ALL" , "build_mnt.php" , $arrOther );
	                        exit;
			}
			$kakuLogo = split("\.",$_FILES["estate_photo"]["name"]);
			$photo_name_org = "estate_".$_SESSION['_cl_id']."_".$_POST['estate_id'].".".$kakuLogo[1];
		}
*/
		$obj_rev = new basedb_EstateClassTblAccess;
		$obj_rev->conn = $obj_conn->conn;
		$obj_rev->estatedat[0]["estate_id"] = $_POST["estate_id"];
		$obj_rev->estatedat[0]["estate_update"] = $_POST["estate_update"];
		$obj_rev->estatedat[0]["estate_homeslimit"] = $_POST["estate_homeslimit"];
		$obj_rev->estatedat[0]["estate_homesflg"] = $_POST["estate_homesflg"];
		$obj_rev->estatedat[0]["estate_jishamono"] = $_POST["estate_jishamono"];
		$obj_rev->estatedat[0]["estate_vacant"] = $_POST["estate_vacant"];
		$obj_rev->estatedat[0]["estate_type"] = $_POST["estate_type"];
		$obj_rev->estatedat[0]["estate_batchflg"] = $_POST["estate_batchflg"];
		$obj_rev->estatedat[0]["estate_toushiflg"] = $_POST["estate_toushiflg"];
		$obj_rev->estatedat[0]["estate_name"] = $_POST["estate_name"];
		$obj_rev->estatedat[0]["estate_kana"] = $_POST["estate_kana"];
		$obj_rev->estatedat[0]["estate_nameflg"] = $_POST["estate_nameflg"];
		$obj_rev->estatedat[0]["estate_division"] = $_POST["estate_division"];
		$obj_rev->estatedat[0]["estate_empty"] = $_POST["estate_empty"];
		$obj_rev->estatedat[0]["estate_emptytext"] = $_POST["estate_emptytext"];
		$obj_rev->estatedat[0]["estate_zip"] = $build_zip_val;
		$obj_rev->estatedat[0]["estate_addcd"] = $_POST["estate_addcd"];
		$obj_rev->estatedat[0]["estate_addname"] = $_POST["estate_addname"];
		$obj_rev->estatedat[0]["estate_addopen"] = $_POST["estate_addopen"];
		$obj_rev->estatedat[0]["estate_addclose"] = $_POST["estate_addclose"];
		$obj_rev->estatedat[0]["estate_map"] = $_POST["estate_map"];
		$obj_rev->estatedat[0]["estate_line1"] = $_POST["estate_line_cd_1"];
		$obj_rev->estatedat[0]["estate_station1"] = $_POST["estate_sta_cd_1"];
		$obj_rev->estatedat[0]["estate_busstop1"] = $_POST["estate_busstop1"];
		$obj_rev->estatedat[0]["estate_bus1"] = $_POST["estate_bus1"];
		$obj_rev->estatedat[0]["estate_walk1"] = $_POST["estate_walk1"];
		$obj_rev->estatedat[0]["estate_line2"] = $_POST["estate_line_cd_2"];
		$obj_rev->estatedat[0]["estate_station2"] = $_POST["estate_sta_cd_2"];
		$obj_rev->estatedat[0]["estate_busstop2"] = $_POST["estate_busstop2"];
		$obj_rev->estatedat[0]["estate_bus2"] = $_POST["estate_bus2"];
		$obj_rev->estatedat[0]["estate_walk2"] = $_POST["estate_walk2"];
		$obj_rev->estatedat[0]["estate_otherline"] = $_POST["estate_otherline"];
		$obj_rev->estatedat[0]["estate_car"] = $_POST["estate_car"];
		$obj_rev->estatedat[0]["tochi_chimoku"] = $_POST["tochi_chimoku"];
		$obj_rev->estatedat[0]["tochi_usagearea"] = $_POST["tochi_usagearea"];
		$obj_rev->estatedat[0]["tochi_cityplan"] = $_POST["tochi_cityplan"];
		$obj_rev->estatedat[0]["tochi_terrain"] = $_POST["tochi_terrain"];
		$obj_rev->estatedat[0]["tochi_areamethod"] = $_POST["tochi_areamethod"];
		$obj_rev->estatedat[0]["tochi_area"] = $_POST["tochi_area"];
		$obj_rev->estatedat[0]["tochi_loadarea"] = $_POST["tochi_loadarea"];
		$obj_rev->estatedat[0]["tochi_loadratio"] = $_POST["tochi_loadratio"];
		$obj_rev->estatedat[0]["tochi_share"] = $_POST["tochi_share"];
		$obj_rev->estatedat[0]["tochi_setpack"] = $_POST["tochi_setpack"];
		$obj_rev->estatedat[0]["tochi_setbackratio"] = $_POST["tochi_setbackratio"];
		$obj_rev->estatedat[0]["tochi_coverage"] = $_POST["tochi_coverage"];
		$obj_rev->estatedat[0]["tochi_yousekiritsu"] = $_POST["tochi_yousekiritsu"];
		$obj_rev->estatedat[0]["tochi_setsudoustat"] = $_POST["tochi_setsudoustat"];
		$obj_rev->estatedat[0]["tochi_setsudouazimuth1"] = $_POST["tochi_setsudouazimuth1"];
		$obj_rev->estatedat[0]["tochi_setsudoumaguchi1"] = $_POST["tochi_setsudoumaguchi1"];
		$obj_rev->estatedat[0]["tochi_setsudoutype1"] = $_POST["tochi_setsudoutype1"];
		$obj_rev->estatedat[0]["tochi_setsudouwidth1"] = $_POST["tochi_setsudouwidth1"];
		$obj_rev->estatedat[0]["tochi_ichishitei1"] = $_POST["tochi_ichishitei1"];
		$obj_rev->estatedat[0]["tochi_setsudouazimuth2"] = $_POST["tochi_setsudouazimuth2"];
		$obj_rev->estatedat[0]["tochi_setsudoumaguchi2"] = $_POST["tochi_setsudoumaguchi2"];
		$obj_rev->estatedat[0]["tochi_setsudoutype2"] = $_POST["tochi_setsudoutype2"];
		$obj_rev->estatedat[0]["tochi_setsudouwidth2"] = $_POST["tochi_setsudouwidth2"];
		$obj_rev->estatedat[0]["tochi_ichishitei2"] = $_POST["tochi_ichishitei2"];
		$obj_rev->estatedat[0]["tochi_setsudouazimuth3"] = $_POST["tochi_setsudouazimuth3"];
		$obj_rev->estatedat[0]["tochi_setsudoumaguchi3"] = $_POST["tochi_setsudoumaguchi3"];
		$obj_rev->estatedat[0]["tochi_setsudoutype3"] = $_POST["tochi_setsudoutype3"];
		$obj_rev->estatedat[0]["tochi_setsudouwidth3"] = $_POST["tochi_setsudouwidth3"];
		$obj_rev->estatedat[0]["tochi_ichishitei3"] = $_POST["tochi_ichishitei3"];
		$obj_rev->estatedat[0]["tochi_setsudouazimuth4"] = $_POST["tochi_setsudouazimuth4"];
		$obj_rev->estatedat[0]["tochi_setsudoumaguchi4"] = $_POST["tochi_setsudoumaguchi4"];
		$obj_rev->estatedat[0]["tochi_setsudoutype4"] = $_POST["tochi_setsudoutype4"];
		$obj_rev->estatedat[0]["tochi_setsudouwidth4"] = $_POST["tochi_setsudouwidth4"];
		$obj_rev->estatedat[0]["tochi_ichishitei4"] = $_POST["tochi_ichishitei4"];
		$obj_rev->estatedat[0]["tochi_kenri"] = $_POST["tochi_kenri"];
		$obj_rev->estatedat[0]["tochi_todokede"] = $_POST["tochi_todokede"];
		$obj_rev->estatedat[0]["tochi_seigen"] = $_POST["tochi_seigen"];

		$obj_rev->estatedat[0]["build_structure"] = $_POST["build_structure"];
		$obj_rev->estatedat[0]["build_areamethod"] = $_POST["build_areamethod"];
		$obj_rev->estatedat[0]["build_area"] = $_POST["build_area"];
		$obj_rev->estatedat[0]["build_shikichiarea"] = $_POST["build_shikichiarea"];
		$obj_rev->estatedat[0]["build_nobeyukaarea"] = $_POST["build_nobeyukaarea"];
		$obj_rev->estatedat[0]["build_kenchikuarea"] = $_POST["build_kenchikuarea"];
		$obj_rev->estatedat[0]["build_floor"] = $_POST["build_floor"];
		$obj_rev->estatedat[0]["build_basement"] = $_POST["build_basement"];
		$obj_rev->estatedat[0]["build_age"] = $build_age_val;
		$obj_rev->estatedat[0]["build_newflg"] = $_POST["build_newflg"];

		$obj_rev->estatedat[0]["manager_stat"] = $_POST["manager_stat"];
		$obj_rev->estatedat[0]["manager_type"] = $_POST["manager_type"];
		$obj_rev->estatedat[0]["manager_flg"] = $_POST["manager_flg"];
		$obj_rev->estatedat[0]["manager_comname"] = $_POST["manager_comname"];

		$obj_rev->estatedat[0]["room_floor"] = $room_floor;
		$obj_rev->estatedat[0]["room_balconyarea"] = $_POST["room_balconyarea"];
		$obj_rev->estatedat[0]["room_azimuth"] = $_POST["room_azimuth"];

		$obj_rev->estatedat[0]["madori_roomnum"] = $_POST["madori_roomnum"];
		$obj_rev->estatedat[0]["madori_roomtype"] = $_POST["madori_roomtype"];
		$obj_rev->estatedat[0]["madori_type1"] = $_POST["madori_type1"];
		$obj_rev->estatedat[0]["madori_jyounum1"] = $_POST["madori_jyounum1"];
		$obj_rev->estatedat[0]["madori_floor1"] = $_POST["madori_floor1"];
		$obj_rev->estatedat[0]["madori_num1"] = $_POST["madori_num1"];
		$obj_rev->estatedat[0]["madori_type2"] = $_POST["madori_type2"];
		$obj_rev->estatedat[0]["madori_jyounum2"] = $_POST["madori_jyounum2"];
		$obj_rev->estatedat[0]["madori_floor2"] = $_POST["madori_floor2"];
		$obj_rev->estatedat[0]["madori_num2"] = $_POST["madori_num2"];
		$obj_rev->estatedat[0]["madori_type3"] = $_POST["madori_type3"];
		$obj_rev->estatedat[0]["madori_jyounum3"] = $_POST["madori_jyounum3"];
		$obj_rev->estatedat[0]["madori_floor3"] = $_POST["madori_floor3"];
		$obj_rev->estatedat[0]["madori_num3"] = $_POST["madori_num3"];
		$obj_rev->estatedat[0]["madori_type4"] = $_POST["madori_type4"];
		$obj_rev->estatedat[0]["madori_jyounum4"] = $_POST["madori_jyounum4"];
		$obj_rev->estatedat[0]["madori_floor4"] = $_POST["madori_floor4"];
		$obj_rev->estatedat[0]["madori_num4"] = $_POST["madori_num4"];
		$obj_rev->estatedat[0]["madori_type5"] = $_POST["madori_type5"];
		$obj_rev->estatedat[0]["madori_jyounum5"] = $_POST["madori_jyounum5"];
		$obj_rev->estatedat[0]["madori_floor5"] = $_POST["madori_floor5"];
		$obj_rev->estatedat[0]["madori_num5"] = $_POST["madori_num5"];
		$obj_rev->estatedat[0]["madori_type6"] = $_POST["madori_type6"];
		$obj_rev->estatedat[0]["madori_jyounum6"] = $_POST["madori_jyounum6"];
		$obj_rev->estatedat[0]["madori_floor6"] = $_POST["madori_floor6"];
		$obj_rev->estatedat[0]["madori_num6"] = $_POST["madori_num6"];
		$obj_rev->estatedat[0]["madori_type7"] = $_POST["madori_type7"];
		$obj_rev->estatedat[0]["madori_jyounum7"] = $_POST["madori_jyounum7"];
		$obj_rev->estatedat[0]["madori_floor7"] = $_POST["madori_floor7"];
		$obj_rev->estatedat[0]["madori_num7"] = $_POST["madori_num7"];
		$obj_rev->estatedat[0]["madori_type8"] = $_POST["madori_type8"];
		$obj_rev->estatedat[0]["madori_jyounum8"] = $_POST["madori_jyounum8"];
		$obj_rev->estatedat[0]["madori_floor8"] = $_POST["madori_floor8"];
		$obj_rev->estatedat[0]["madori_num8"] = $_POST["madori_num8"];
		$obj_rev->estatedat[0]["madori_type9"] = $_POST["madori_type9"];
		$obj_rev->estatedat[0]["madori_jyounum9"] = $_POST["madori_jyounum9"];
		$obj_rev->estatedat[0]["madori_floor9"] = $_POST["madori_floor9"];
		$obj_rev->estatedat[0]["madori_num9"] = $_POST["madori_num9"];
		$obj_rev->estatedat[0]["madori_type10"] = $_POST["madori_type10"];
		$obj_rev->estatedat[0]["madori_jyounum10"] = $_POST["madori_jyounum10"];
		$obj_rev->estatedat[0]["madori_floor10"] = $_POST["madori_floor10"];
		$obj_rev->estatedat[0]["madori_num10"] = $_POST["madori_num10"];
		$obj_rev->estatedat[0]["madori_biko"] = $_POST["madori_biko"];

		$obj_rev->estatedat[0]["feacher_all"] = $_POST["feacher_all"];
		$obj_rev->estatedat[0]["feacher_a"] = $_POST["feacher_a"];
		$obj_rev->estatedat[0]["feacher_b"] = $_POST["feacher_b"];

		$obj_rev->estatedat[0]["biko_all"] = $_POST["biko_all"];
		$obj_rev->estatedat[0]["biko_a"] = $_POST["biko_a"];
		$obj_rev->estatedat[0]["biko_b"] = $_POST["biko_b"];
		$obj_rev->estatedat[0]["biko_url1"] = $_POST["biko_url1"];
		$obj_rev->estatedat[0]["biko_url2"] = $_POST["biko_url2"];
		$obj_rev->estatedat[0]["biko_memo"] = $_POST["biko_memo"];

		$obj_rev->estatedat[0]["price_main"] = $_POST["price_main"];
		$obj_rev->estatedat[0]["price_flg"] = $_POST["price_flg"];
		$obj_rev->estatedat[0]["price_stat"] = $_POST["price_stat"];
		$obj_rev->estatedat[0]["price_taxflg"] = $_POST["price_taxflg"];
		$obj_rev->estatedat[0]["price_tax"] = $_POST["price_tax"];
		$obj_rev->estatedat[0]["price_tsubotanka"] = $_POST["price_tsubotanka"];
		$obj_rev->estatedat[0]["price_cntrlprice"] = $_POST["price_cntrlprice"];
		$obj_rev->estatedat[0]["price_cntrlpricetax"] = $_POST["price_cntrlpricetax"];
		$obj_rev->estatedat[0]["price_rei"] = $_POST["price_rei"];
		$obj_rev->estatedat[0]["price_reitax"] = $_POST["price_reitax"];
		$obj_rev->estatedat[0]["price_siki"] = $_POST["price_siki"];
		$obj_rev->estatedat[0]["price_secprice"] = $_POST["price_secprice"];
		$obj_rev->estatedat[0]["price_kenrikin"] = $_POST["price_kenrikin"];
		$obj_rev->estatedat[0]["price_kenrikintax"] = $_POST["price_kenrikintax"];
		$obj_rev->estatedat[0]["price_joutokin"] = $_POST["price_joutokin"];
		$obj_rev->estatedat[0]["price_joutokintax"] = $_POST["price_joutokintax"];
		$obj_rev->estatedat[0]["price_sikibiki"] = $_POST["price_sikibiki"];
		$obj_rev->estatedat[0]["price_sikibikitime"] = $_POST["price_sikibikitime"];
		$obj_rev->estatedat[0]["price_updprice"] = $_POST["price_updprice"];
		$obj_rev->estatedat[0]["price_fullyield"] = $_POST["price_fullyield"];
		$obj_rev->estatedat[0]["price_nowyield"] = $_POST["price_nowyield"];
		$obj_rev->estatedat[0]["price_insuranceprice"] = $_POST["price_insuranceprice"];
		$obj_rev->estatedat[0]["price_insuranceperiod"] = $_POST["price_insuranceperiod"];
		$obj_rev->estatedat[0]["price_leaseprice"] = $_POST["price_leaseprice"];
		$obj_rev->estatedat[0]["price_contractyear"] = $_POST["price_contractyear"];
		$obj_rev->estatedat[0]["price_contractmonth"] = $_POST["price_contractmonth"];
		$obj_rev->estatedat[0]["price_contractdivision"] = $_POST["price_contractdivision"];
		$obj_rev->estatedat[0]["price_mendingprice"] = $_POST["price_mendingprice"];
		$obj_rev->estatedat[0]["price_mendingfund"] = $_POST["price_mendingfund"];
		$obj_rev->estatedat[0]["price_otherpricetitle1"] = $_POST["price_otherpricetitle1"];
		$obj_rev->estatedat[0]["price_otherprice1"] = $_POST["price_otherprice1"];
		$obj_rev->estatedat[0]["price_otherpricetitle2"] = $_POST["price_otherpricetitle2"];
		$obj_rev->estatedat[0]["price_otherprice2"] = $_POST["price_otherprice2"];
		$obj_rev->estatedat[0]["price_otherpricetitle3"] = $_POST["price_otherpricetitle3"];
		$obj_rev->estatedat[0]["price_otherprice3"] = $_POST["price_otherprice3"];

		$obj_rev->estatedat[0]["contract_price"] = $_POST["contract_price"];
		$obj_rev->estatedat[0]["contract_date"] = $_POST["contract_date"];
		$obj_rev->estatedat[0]["contract_taxflg"] = $_POST["contract_taxflg"];
		$obj_rev->estatedat[0]["contract_tax"] = $_POST["contract_tax"];

		$obj_rev->estatedat[0]["parking_price"] = $_POST["parking_price"];
		$obj_rev->estatedat[0]["parking_pricetax"] = $_POST["parking_pricetax"];
		$obj_rev->estatedat[0]["parking_division"] = $_POST["parking_division"];
		$obj_rev->estatedat[0]["parking_distance"] = $_POST["parking_distance"];
		$obj_rev->estatedat[0]["parking_emptynum"] = $_POST["parking_emptynum"];
		$obj_rev->estatedat[0]["parking_biko"] = $_POST["parking_biko"];

		$obj_rev->estatedat[0]["delivery_vacant"] = $_POST["delivery_vacant"];
		$obj_rev->estatedat[0]["delivery_flg"] = $_POST["delivery_flg"];
		$obj_rev->estatedat[0]["delivery_date"] = $_POST["delivery_date"];
		$obj_rev->estatedat[0]["delivery_season"] = $_POST["delivery_season"];

		$obj_rev->estatedat[0]["surround_syougakkou"] = $_POST["surround_syougakkou"];
		$obj_rev->estatedat[0]["surround_syoudistance"] = $_POST["surround_syoudistance"];
		$obj_rev->estatedat[0]["surround_syoucd"] = $_POST["surround_syoucd"];
		$obj_rev->estatedat[0]["surround_chuugakkou"] = $_POST["surround_chuugakkou"];
		$obj_rev->estatedat[0]["surround_chuudistance"] = $_POST["surround_chuudistance"];
		$obj_rev->estatedat[0]["surround_chuucd"] = $_POST["surround_chuucd"];
		$obj_rev->estatedat[0]["surround_konbinidistance"] = $_POST["surround_konbinidistance"];
		$obj_rev->estatedat[0]["surround_superdistance"] = $_POST["surround_superdistance"];
		$obj_rev->estatedat[0]["surround_hospitaldistance"] = $_POST["surround_hospitaldistance"];

		$obj_rev->estatedat[0]["tanto_name"] = $_POST["tanto_name"];

		$obj_rev->estatedat[0]["trade_mode"] = $_POST["trade_mode"];
		$obj_rev->estatedat[0]["trade_date"] = $_POST["trade_date"];

		$obj_rev->estatedat[0]["kyakuzuke_flg"] = $_POST["kyakuzuke_flg"];
		$obj_rev->estatedat[0]["kyakuzuke_date"] = $_POST["kyakuzuke_date"];
		$obj_rev->estatedat[0]["kyakuzuke_price"] = $_POST["kyakuzuke_price"];
		$obj_rev->estatedat[0]["kyakuzuke_bunpai"] = $_POST["kyakuzuke_bunpai"];
		$obj_rev->estatedat[0]["kyakuzuke_futan"] = $_POST["kyakuzuke_futan"];
		$obj_rev->estatedat[0]["kyakuzuke_message"] = $_POST["kyakuzuke_message"];

		$obj_rev->estatedat[0]["motozuke_name"] = $_POST["motozuke_name"];
		$obj_rev->estatedat[0]["motozuke_zip"] = $_POST["motozuke_zip"];
		$obj_rev->estatedat[0]["motozuke_addcd"] = $_POST["motozuke_addcd"];
		$obj_rev->estatedat[0]["motozuke_addname"] = $_POST["motozuke_addname"];
		$obj_rev->estatedat[0]["motozuke_addopen"] = $_POST["motozuke_addopen"];
		$obj_rev->estatedat[0]["motozuke_tell"] = $_POST["motozuke_tell"];
		$obj_rev->estatedat[0]["motozuke_fax"] = $_POST["motozuke_fax"];
		$obj_rev->estatedat[0]["motozuke_tanto"] = $_POST["motozuke_tanto"];
		$obj_rev->estatedat[0]["motozuke_biko"] = $_POST["motozuke_biko"];

		$obj_rev->estatedat[0]["owner_name"] = $_POST["owner_name"];
		$obj_rev->estatedat[0]["owner_zip"] = $_POST["owner_zip"];
		$obj_rev->estatedat[0]["owner_addcd"] = $_POST["owner_addcd"];
		$obj_rev->estatedat[0]["owner_addname"] = $_POST["owner_addname"];
		$obj_rev->estatedat[0]["owner_addopen"] = $_POST["owner_addopen"];
		$obj_rev->estatedat[0]["owner_tell"] = $_POST["owner_tell"];
		$obj_rev->estatedat[0]["owner_fax"] = $_POST["owner_fax"];
		$obj_rev->estatedat[0]["owner_biko"] = $_POST["owner_biko"];

		$obj_rev->estatedat[0]["openhouse_start"] = $_POST["openhouse_start"];
		$obj_rev->estatedat[0]["openhouse_end"] = $_POST["openhouse_end"];
		$obj_rev->estatedat[0]["openhouse_period"] = $_POST["openhouse_period"];
		$obj_rev->estatedat[0]["openhouse_biko"] = $_POST["openhouse_biko"];

		$obj_rev->estatedat[0]["img_org1"] = $_POST["img_org1"];
		$obj_rev->estatedat[0]["img_upddate1"] = $_POST["img_upddate1"];
		$obj_rev->estatedat[0]["img_type1"] = $_POST["img_type1"];
		$obj_rev->estatedat[0]["img_comment1"] = $_POST["img_comment1"];
		$obj_rev->estatedat[0]["img_org2"] = $_POST["img_org2"];
		$obj_rev->estatedat[0]["img_upddate2"] = $_POST["img_upddate2"];
		$obj_rev->estatedat[0]["img_type2"] = $_POST["img_type2"];
		$obj_rev->estatedat[0]["img_comment2"] = $_POST["img_comment2"];
		$obj_rev->estatedat[0]["img_org3"] = $_POST["img_org3"];
		$obj_rev->estatedat[0]["img_upddate3"] = $_POST["img_upddate3"];
		$obj_rev->estatedat[0]["img_type3"] = $_POST["img_type3"];
		$obj_rev->estatedat[0]["img_comment3"] = $_POST["img_comment3"];
		$obj_rev->estatedat[0]["img_org4"] = $_POST["img_org4"];
		$obj_rev->estatedat[0]["img_upddate4"] = $_POST["img_upddate4"];
		$obj_rev->estatedat[0]["img_type4"] = $_POST["img_type4"];
		$obj_rev->estatedat[0]["img_comment4"] = $_POST["img_comment4"];
		$obj_rev->estatedat[0]["img_org5"] = $_POST["img_org5"];
		$obj_rev->estatedat[0]["img_upddate5"] = $_POST["img_upddate5"];
		$obj_rev->estatedat[0]["img_type5"] = $_POST["img_type5"];
		$obj_rev->estatedat[0]["img_comment5"] = $_POST["img_comment5"];
		$obj_rev->estatedat[0]["img_org6"] = $_POST["img_org6"];
		$obj_rev->estatedat[0]["img_upddate6"] = $_POST["img_upddate6"];
		$obj_rev->estatedat[0]["img_type6"] = $_POST["img_type6"];
		$obj_rev->estatedat[0]["img_comment6"] = $_POST["img_comment6"];
		$obj_rev->estatedat[0]["img_org7"] = $_POST["img_org7"];
		$obj_rev->estatedat[0]["img_upddate7"] = $_POST["img_upddate7"];
		$obj_rev->estatedat[0]["img_type7"] = $_POST["img_type7"];
		$obj_rev->estatedat[0]["img_comment7"] = $_POST["img_comment7"];
		$obj_rev->estatedat[0]["img_org8"] = $_POST["img_org8"];
		$obj_rev->estatedat[0]["img_upddate8"] = $_POST["img_upddate8"];
		$obj_rev->estatedat[0]["img_type8"] = $_POST["img_type8"];
		$obj_rev->estatedat[0]["img_comment8"] = $_POST["img_comment8"];
		$obj_rev->estatedat[0]["img_org9"] = $_POST["img_org9"];
		$obj_rev->estatedat[0]["img_upddate9"] = $_POST["img_upddate9"];
		$obj_rev->estatedat[0]["img_type9"] = $_POST["img_type9"];
		$obj_rev->estatedat[0]["img_comment9"] = $_POST["img_comment9"];
		$obj_rev->estatedat[0]["img_org10"] = $_POST["img_org10"];
		$obj_rev->estatedat[0]["img_upddate10"] = $_POST["img_upddate10"];
		$obj_rev->estatedat[0]["img_type10"] = $_POST["img_type10"];
		$obj_rev->estatedat[0]["img_comment10"] = $_POST["img_comment10"];

		$obj_rev->estatedat[0]["estate_group"] = $_POST["estate_group"];
		$obj_rev->estatedat[0]["estate_equip"] = $estate_equip_val;
		$obj_rev->estatedat[0]["estate_pointnum"] = $_POST["estate_pointnum"];
		$obj_rev->estatedat[0]["estate_end"] = $_POST["estate_end"];
		$obj_rev->estatedat[0]["estate_clid"] = $_SESSION["_cl_id"];
		$obj_rev->estatedat[0]["estate_ido"] = $_POST["estate_ido"];
		$obj_rev->estatedat[0]["estate_keido"] = $_POST["estate_keido"];
		$obj_rev->estatedat[0]["estate_zoom"] = $_POST["estate_zoom"];
		$obj_rev->estatedat[0]["estate_adminid"] = $_POST["estate_adminid"];
		$obj_rev->estatedat[0]["estate_insdate"] = $_POST["estate_insdate"];
		$obj_rev->estatedat[0]["estate_upddate"] = $_POST["estate_upddate"];
		$obj_rev->estatedat[0]["estate_deldate"] = $_POST["estate_deldate"];
		$obj_rev->estatedat[0]["estate_yobi1"] = $_POST["estate_yobi1"];
		$obj_rev->estatedat[0]["estate_yobi2"] = $_POST["estate_yobi2"];
		$obj_rev->estatedat[0]["estate_yobi3"] = $_POST["estate_yobi3"];
		$obj_rev->estatedat[0]["estate_yobi4"] = $_POST["estate_yobi4"];
		$obj_rev->estatedat[0]["estate_yobi5"] = $_POST["estate_yobi5"];
		$suc = $obj_rev->basedb_UpdEstate();
/*
		IF( $suc == "0" ){
			// 画像保存・削除処理
			IF( is_uploaded_file( $_FILES["estate_photo"]["tmp_name"] ) ){
				// 一度画像を削除==>再度コピー
				IF( file_exists($param_estate_photo_path.$_POST['estate_photo_lastupd'] ) && $_POST['estate_photo_lastupd'] != "" ){
					unlink( $param_estate_photo_path.$_POST['estate_photo_lastupd'] );
				}
				// 同じ名前で、UPLOADされたデータをコピー
				IF( is_uploaded_file($_FILES["estate_photo"]["tmp_name"]) && $obj_rev->estatedat[0]["estate_photo"] != "" ){
					move_uploaded_file( $_FILES["estate_photo"]["tmp_name"] , $param_estate_photo_path.$photo_name_org );
					chmod( $param_estate_photo_path.$photo_name_org , 0755 );
				}

				$obj_photo_rev = new ImageControl;
				$obj_photo_rev->max_w = 300;
				$obj_photo_rev->max_h = 300;
				$obj_photo_rev->origin_dir = $param_estate_photo_path;
				$obj_photo_rev->origin_img = $photo_name_org;
				$obj_photo_rev->gd_ver = 1;
				list($resize_photo_rev,$imageType) = $obj_photo_rev->ImageResizeSave();
				if($resize_photo == -1){
	                        	$obj_error->ViewErrMessage( "SYSTEM" , "ALL" , "blog_mnt.php" , $arrOther  );
	                       		exit;
				}

				$obj_photo_save_rev = new ImageControl;
				$obj_photo_save_rev->origin_dir = $param_estate_photo_path;
				$obj_photo_save_rev->origin_img = $photo_name_org;
				$obj_photo_save_rev->imageResource = $resize_photo_rev;
				$photo_suc_rev = $obj_photo_save_rev->ImageSave($imageType);
				if($photo_suc_rev == -1){
	                        	$obj_error->ViewErrMessage( "SYSTEM" , "ALL" , "blog_mnt.php" , $arrOther  );
	                       		exit;
				}
			}
		}
*/
                if( $suc == -1 ){
                        $arrOther["ath_comment"] = "<INPUT TYPE=\"hidden\" NAME=\"stpos\" VALUE=\"{$_POST['stpos']}\">";
			$arrOther["ath_comment"] .= $athComment;
                        $obj_error->ViewErrMessage( "UPD_ERROR" , "ALL" , "build_mnt.php" , $arrOther );
                        exit;
                }
                if( $suc == 1 ){
                        $arrOther["ath_comment"] = "<INPUT TYPE=\"hidden\" NAME=\"stpos\" VALUE=\"{$_POST['stpos']}\">";
                        $obj_error->ViewErrMessage( "DOUBLE_UPD" , "ALL" , "build_main.php" , $arrOther );
                        exit;
                }
                if( $suc == 2 ){
                        $arrOther["ath_comment"] = "<INPUT TYPE=\"hidden\" NAME=\"stpos\" VALUE=\"{$_POST['stpos']}\">";
			$arrOther["ath_comment"] .= $athComment;
                        $obj_error->ViewErrMessage( "DISP_NO" , "ALL" , "build_mnt.php" , $arrOther );
                        exit;
                }
		$message = "建物情報を修正しました。";
		break;
		
		
	case 'DEL':
		$obj_del = new basedb_EstateClassTblAccess;
		$obj_del->conn = $obj_conn->conn;
		$obj_del->estatedat[0]["estate_id"] = $_POST["estate_id"];
		$obj_del->estatedat[0]["estate_clid"] = $_SESSION["_cl_id"];
		$obj_del->estatedat[0]["estate_upddate"] = $_POST["estate_upddate"];
		$suc = $obj_del->basedb_DelEstate(0);
                if( $suc != 0 ){
                        $arrOther["ath_comment"] = "<INPUT TYPE=\"hidden\" NAME=\"stpos\" VALUE=\"{$_POST['stpos']}\">";
                        $obj_error->ViewErrMessage( "DEL_ERROR" , "ALL" , "build_main.php" , $arrOther );
                        exit;
                }
		IF( $suc == 0 ){
			// 画像を削除
			IF( file_exists($param_estate_photo_path.$_POST['estate_photo_lastupd'] )){
				unlink( $param_estate_photo_path.$_POST['estate_photo_lastupd'] );
			}
		}
		$message = "指定された建物情報を削除しました。";
		break;

}

/******
	//---------------------------
	//会社・ブログ基本情報抽出
	$obj_cl_blog = new viewdb_ClientClassTblAccess;
	$obj_cl_blog->conn = $obj_conn->conn;
	$obj_cl_blog->jyoken["cl_del_date"] = 1;
	$obj_cl_blog->jyoken["blog_del_date"] = 1;
	$obj_cl_blog->jyoken["cl_id"] = $_SESSION['_cl_id'];
	list( $rssCnt , $rssTotal ) = $obj_cl_blog->viewdb_GetClient ( 1 , -1 );

	//---------------------------
	//建物ＲＳＳ生成

	//建物+部屋情報抽出
	$obj_rev_rss = new viewdb_EstateClassTblAccess;
	$obj_rev_rss->conn = $obj_conn->conn;
	$obj_rev_rss->jyoken["estate_del_date"] = 1;
	$obj_rev_rss->jyoken["room_del_date"] = 1;
	$obj_rev_rss->jyoken["estate_cl_id"] = $_SESSION['_cl_id'];
	list( $rssCnt , $rssTotal ) = $obj_rev_rss->viewdb_GetEstate ( 1 , -1 );

	//各アイテム（物件情報）XMLタグ生成
	$rssEstateItemValue = "";
	for($rssX=0;$rssX<$rssCnt;$rssX++){
		// timestamp形をRFC822形式へ変更
		$bufDate1 = explode( "." , $obj_rev_rss->estatedat[$rssX]["room_upd_date"] );	// マイクロ秒を切り捨てる
		$bufDate2 = explode( " " , $bufDate1[0] );			// 日付と時間を分ける
		$bufDate3_1 = explode( "-" , $bufDate2[0] );			// 年月日を分ける
		$bufDate3_2 = explode( ":" , $bufDate2[1] );			// 時分秒を分ける
		$bufTimeUnix = mktime( $bufDate3_2[0] , $bufDate3_2[1] , $bufDate3_2[2] , $bufDate3_1[1] , $bufDate3_1[2] , $bufDate3_1[0] );
		$strSemiUpdate = date( "r" , $bufTimeUnix );

		$rssEstateItemValue .= "    <item>\n";
		$rssEstateItemValue .= "      <title>";
		$rssEstateItemValue .= $obj_rev_rss->estatedat[$rssX]['estate_line_name_1']."線".$obj_rev_rss->estatedat[$rssX]['estate_sta_name_1']."駅から徒歩".$obj_rev_rss->estatedat[$rssX]['estate_move_1']."分";
		if($obj_rev_rss->estatedat[$rssX]['estate_move_bus_1']!="")$rssEstateItemValue .= " バス".$obj_rev_rss->estatedat[$rssX]['estate_move_bus_1']."分";

		//間取り表示内容生成
		asort( $param_room_floor["disp_no"] );
		FOREACH( $param_room_floor["disp_no"] as $key => $val ){
			if($param_room_floor['id'][$key] == $obj_rev_rss->estatedat[$rssX]['room_madori'])$rssEstateItemValue .= " ".$param_room_floor['val'][$key];
		}
		$rssEstateItemValue .= " 家賃".number_format($obj_rev_rss->estatedat[$rssX]['room_price'])."円</title>\n";
		$rssEstateItemValue .= "      <link>"._BLOG_SITE_URL_BASE."room-".$obj_rev_rss->estatedat[$rssX]['room_id']."/</link>\n";
	//	$rssRoomUpdDate = substr($obj_rev_rss->estatedat[$rssX]['room_upd_date'],"20","7");
		$rssEstateItemValue .= "      <guid>"._BLOG_SITE_URL_BASE."room-".$obj_rev_rss->estatedat[$rssX]['room_id']."/</guid>\n";
		$rssEstateItemValue .= "      <description>".$obj_rev_rss->estatedat[$rssX]['room_pr']."</description>\n";
		$rssEstateItemValue .= "      <pubDate>".$strSemiUpdate."</pubDate>\n";
		$rssEstateItemValue .= "    </item>\n";
	}

	//RSSファイル生成
	$buildRssTmp = fopen(SITE_PATH."rss/rss_estate_".$_SESSION['_cl_id'].".tmp","w");
	if($buildRssTmp===flase)exit("ファイルオープン失敗");
	flock($buildRssTmp,LOCK_EX);
	$rssEstateValue = "<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n";
	$rssEstateValue .= "<?xml-stylesheet type=\"text/css\" href=\"rss.css\"?>\n";
	$rssEstateValue .= "<rss version=\"2.0\">\n";
	$rssEstateValue .= "  <channel>\n";
	$rssEstateValue .= "    <title>".$obj_cl_blog->clientdat[0]['blog_title']."</title>\n";
	$rssEstateValue .= "    <link>"._BLOG_SITE_URL_BASE.$login_val['cl_url_cd']."</link>\n";
	$rssEstateValue .= "    <copyright>".$obj_cl_blog->clientdat[0]['cl_name'].$obj_cl_blog->clientdat[0]['cl_shiten']."</copyright>\n";
	$rssEstateValue .= "    <description>".$obj_cl_blog->clientdat[0]['blog_discription']."</description>\n";
	$rssEstateValue .= $rssEstateItemValue;
	$rssEstateValue .= "  </channel>\n";
	$rssEstateValue .= "</rss>\n";
	$rssEstateValue = mb_convert_encoding($rssEstateValue,"UTF-8","EUC-JP");
	fputs($buildRssTmp,$rssEstateValue);
	flock($buildRssTmp,LOCK_UN);
	fclose($buildRssTmp);
	$cpEstateRss = copy(SITE_PATH."rss/rss_estate_".$_SESSION['_cl_id'].".tmp", SITE_PATH."rss/rss_estate_".$_SESSION['_cl_id'].".xml");
	//$rnEstateRss = rename(SITE_PATH."rss/rss_estate_".$_SESSION['_cl_id'].".tmp", SITE_PATH."rss/rss_estate_".$_SESSION['_cl_id'].".xml");
	if($cpEstateRss===flase)exit("ファイルコピー失敗");

	$exEstateRss = file_exists(SITE_PATH."rss/rss_estate_".$_SESSION['_cl_id'].".xml");
	if($exEstateRss !== FALSE){
		$dlEstateRss = unlink(SITE_PATH."rss/rss_estate_".$_SESSION['_cl_id'].".tmp");
		if($dlEstateRss===flase)exit("ファイル削除失敗");
	}

	//---------------------------
	//スタッフ日記ＲＳＳ生成

	//建物+部屋情報抽出
	$obj_rss_diary_blog = new basedb_DiaryClassTblAccess;
	$obj_rss_diary_blog->conn = $obj_conn->conn;
	$obj_rss_diary_blog->jyoken["diary_del_date"] = 1;
	$obj_rss_diary_blog->jyoken["diary_cl_id"] = $_SESSION['_cl_id'];
	list( $rssDiaryBlogCnt , $rssDiaryBlogTotal ) = $obj_rss_diary_blog->basedb_GetDiary ( 1 , -1 );

	//各アイテム（スタッフ日記情報）XMLタグ生成
	$rssDiaryItemValue = "";
	$rssDiaryItemValue .= $rssEstateItemValue;
	for($rssX=0;$rssX<$rssDiaryBlogCnt;$rssX++){
		// timestamp形をRFC822形式へ変更
		$bufDate1 = explode( "." , $obj_rss_diary_blog->estatedat[$rssX]["diary_upd_date"] );	// マイクロ秒を切り捨てる
		$bufDate2 = explode( " " , $bufDate1[0] );			// 日付と時間を分ける
		$bufDate3_1 = explode( "-" , $bufDate2[0] );			// 年月日を分ける
		$bufDate3_2 = explode( ":" , $bufDate2[1] );			// 時分秒を分ける
		$bufTimeUnix = mktime( $bufDate3_2[0] , $bufDate3_2[1] , $bufDate3_2[2] , $bufDate3_1[1] , $bufDate3_1[2] , $bufDate3_1[0] );
		$strSemiUpdate = date( "r" , $bufTimeUnix );

		$rssDiaryItemValue .= "    <item>\n";
		$rssDiaryItemValue .= "      <title>".$obj_rss_diary_blog->diarydat[$rssX]['diary_title']."</title>\n";
		$rssDiaryItemValue .= "      <link>"._BLOG_SITE_URL_BASE."diary-detail".$obj_rss_diary_blog->diarydat[$rssX]['diary_id']."/</link>\n";
		$rssDiaryItemValue .= "      <guid>"._BLOG_SITE_URL_BASE."diary-detail".$obj_rss_diary_blog->diarydat[$rssX]['diary_id']."/</guid>\n";
		$rssDiaryItemValue .= "      <description>".$obj_rss_diary_blog->diarydat[$rssX]['diary_contents']."</description>\n";
		$rssDiaryItemValue .= "      <pubDate>".$strSemiUpdate."</pubDate>\n";
		$rssDiaryItemValue .= "    </item>\n";
	}

	//RSSファイル生成
	$diaryRssTmp = fopen(SITE_PATH."rss/rss_".$_SESSION['_cl_id'].".tmp","w");
	if($diaryRssTmp===flase)exit("ファイルオープン失敗");
	flock($diaryRssTmp,LOCK_EX);
	$rssDiaryValue = "<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n";
	$rssDiaryValue .= "<?xml-stylesheet type=\"text/css\" href=\"rss.css\"?>\n";
	$rssDiaryValue .= "<rss version=\"2.0\">\n";
	$rssDiaryValue .= "  <channel>\n";
	$rssDiaryValue .= "    <title>".$obj_cl_blog->clientdat[0]['blog_title']."</title>\n";
	$rssDiaryValue .= "    <link>"._BLOG_SITE_URL_BASE.$login_val['cl_url_cd']."</link>\n";
	$rssDiaryValue .= "    <copyright>".$obj_cl_blog->clientdat[0]['cl_name'].$obj_cl_blog->clientdat[0]['cl_shiten']."</copyright>\n";
	$rssDiaryValue .= "    <description>".$obj_cl_blog->clientdat[0]['blog_discription']."</description>\n";
	$rssDiaryValue .= $rssDiaryItemValue;
	$rssDiaryValue .= "  </channel>\n";
	$rssDiaryValue .= "</rss>\n";
	$rssDiaryValue = html_delete($rssDiaryValue);
	$rssDiaryValue = mb_convert_encoding($rssDiaryValue,"UTF-8","EUC-JP");
	fputs($diaryRssTmp,$rssDiaryValue);
	flock($diaryRssTmp,LOCK_UN);
	fclose($diaryRssTmp);
	$cpEstateRss = copy(SITE_PATH."rss/rss_".$_SESSION['_cl_id'].".tmp", SITE_PATH."rss/rss_".$_SESSION['_cl_id'].".xml");
	//$rnEstateRss = rename(SITE_PATH."rss/rss_".$_SESSION['_cl_id'].".tmp", SITE_PATH."rss/rss_".$_SESSION['_cl_id'].".xml");
	if($cpEstateRss===flase)exit("ファイルコピー失敗");

	$exEstateRss = file_exists(SITE_PATH."rss/rss_".$_SESSION['_cl_id'].".xml");
	if($exEstateRss !== FALSE){
		$dlEstateRss = unlink(SITE_PATH."rss/rss_".$_SESSION['_cl_id'].".tmp");
		if($dlEstateRss===flase)exit("ファイル削除失敗");
	}

	//---------------------------
	//建物ＲＳＳ生成

	//建物+部屋情報抽出
	$obj_rss_buidP = new viewdb_EstateClassTblAccess;
	$obj_rss_buidP->conn = $obj_conn->conn;
	$obj_rss_buidP->jyoken["estate_del_date"] = 1;
	$obj_rss_buidP->jyoken["room_del_date"] = 1;
	list( $rssCnt , $rssTotal ) = $obj_rss_buidP->viewdb_GetEstate ( 1 , -1 );

	//各アイテム（物件情報）XMLタグ生成
	$rssEstateItemValue = "";
	for($rssX=0;$rssX<$rssCnt;$rssX++){
		// timestamp形をRFC822形式へ変更
		$bufDate1 = explode( "." , $obj_rss_buidP->estatedat[$rssX]["room_upd_date"] );	// マイクロ秒を切り捨てる
		$bufDate2 = explode( " " , $bufDate1[0] );			// 日付と時間を分ける
		$bufDate3_1 = explode( "-" , $bufDate2[0] );			// 年月日を分ける
		$bufDate3_2 = explode( ":" , $bufDate2[1] );			// 時分秒を分ける
		$bufTimeUnix = mktime( $bufDate3_2[0] , $bufDate3_2[1] , $bufDate3_2[2] , $bufDate3_1[1] , $bufDate3_1[2] , $bufDate3_1[0] );
		$strSemiUpdate = date( "r" , $bufTimeUnix );

		$rssEstateItemValue .= "    <item>\n";
		$rssEstateItemValue .= "      <title>";
		$rssEstateItemValue .= $obj_rss_buidP->estatedat[$rssX]['estate_line_name_1']."線".$obj_rss_buidP->estatedat[$rssX]['estate_sta_name_1']."駅から徒歩".$obj_rss_buidP->estatedat[$rssX]['estate_move_1']."分";
		if($obj_rss_buidP->estatedat[$rssX]['estate_move_bus_1']!="")$rssEstateItemValue .= " バス".$obj_rss_buidP->estatedat[$rssX]['estate_move_bus_1']."分";

		//間取り表示内容生成
		asort( $param_room_floor["disp_no"] );
		FOREACH( $param_room_floor["disp_no"] as $key => $val ){
			if($param_room_floor['id'][$key] == $obj_rss_buidP->estatedat[$rssX]['room_madori'])$rssEstateItemValue .= " ".$param_room_floor['val'][$key];
		}
		$rssEstateItemValue .= " 家賃".number_format($obj_rss_buidP->estatedat[$rssX]['room_price'])."円</title>\n";
		$rssEstateItemValue .= "      <link>"._BLOG_SITE_URL_BASE."room-".$obj_rss_buidP->estatedat[$rssX]['room_id']."/</link>\n";
	//	$rssRoomUpdDate = substr($obj_rss_buidP->estatedat[$rssX]['room_upd_date'],"20","7");
		$rssEstateItemValue .= "      <guid>"._BLOG_SITE_URL_BASE."room-".$obj_rss_buidP->estatedat[$rssX]['room_id']."/</guid>\n";
		$rssEstateItemValue .= "      <description>".$obj_rss_buidP->estatedat[$rssX]['room_pr']."</description>\n";
		$rssEstateItemValue .= "      <pubDate>".$strSemiUpdate."</pubDate>\n";
		$rssEstateItemValue .= "    </item>\n";
	}

	//RSSファイル生成
	$buildPRssTmp = fopen(SITE_PATH."rss/rss_build.tmp","w");
	if($buildPRssTmp===flase)exit("ファイルオープン失敗");
	flock($buildPRssTmp,LOCK_EX);
	$rssEstateValue = "<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n";
	$rssEstateValue .= "<?xml-stylesheet type=\"text/css\" href=\"rss.css\"?>\n";
	$rssEstateValue .= "<rss version=\"2.0\">\n";
	$rssEstateValue .= "  <channel>\n";
	$rssEstateValue .= "    <title>".$obj_cl_blog->clientdat[0]['blog_title']."</title>\n";
	$rssEstateValue .= "    <link>"._BLOG_SITE_URL_BASE.$login_val['cl_url_cd']."</link>\n";
	$rssEstateValue .= "    <copyright>".$obj_cl_blog->clientdat[0]['cl_name'].$obj_cl_blog->clientdat[0]['cl_shiten']."</copyright>\n";
	$rssEstateValue .= "    <description>".$obj_cl_blog->clientdat[0]['blog_discription']."</description>\n";
	$rssEstateValue .= $rssEstateItemValue;
	$rssEstateValue .= "  </channel>\n";
	$rssEstateValue .= "</rss>\n";
	$rssEstateValue = mb_convert_encoding($rssEstateValue,"UTF-8","EUC-JP");
	fputs($buildPRssTmp,$rssEstateValue);
	flock($buildPRssTmp,LOCK_UN);
	fclose($buildPRssTmp);
	$cpEstateRss = copy(SITE_PATH."rss/rss_build.tmp", SITE_PATH."rss/rss_build.xml");
	if($cpEstateRss===false)exit("ファイルコピー失敗");

	$exEstateRss = file_exists(SITE_PATH."rss/rss_build.xml");
	if($exEstateRss !== FALSE){
		$dlEstateRss = unlink(SITE_PATH."rss/rss_build.tmp");
		if($dlEstateRss===flase)exit("ファイル削除失敗");
	}
****/

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
    <TITLE>不動産ブログ - 建物情報 登録･修正･削除</title>
    <META http-equiv="Content-Type" content="text/html;charset=EUC-JP" />
    <META http-equiv="Content-Style-Type" content="text/css" />
    <META http-equiv="Content-Script-Type" content="text/javascript" />
    <LINK rel="stylesheet" href="../share/css/build.css" type="text/css" />
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
      <form name="form1" action="build_main.php" method="POST"> 
        <input type="submit" value=" 戻 る " class="btn" />
        <INPUT type="hidden" name="stpos" value="<?=$_POST['stpos']?>" />
        <INPUT type="hidden" name="search_flg" value="<?=$_POST['search_flg']?>" />
        <INPUT type="hidden" name="search_estate_name" value="<?=$_POST['search_estate_name']?>" />
        <INPUT type="hidden" name="search_address" value="<?=$_POST['search_address']?>" />
      </form>
    </div>
  </body>
</html>
