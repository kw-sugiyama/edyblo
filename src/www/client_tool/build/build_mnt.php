<?
/******************************************************************************
<< 不動産ブログ　Ver.1.O.0 >>
	Name: build_main.php
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
require_once ( SYS_PATH."dbif/basedb_EstateClass.php" );
require_once ( SYS_PATH."dbif/mstdb_ZipcodeClass.php" );
require_once ( SYS_PATH."common/base_common.php" );
require_once ( SYS_PATH."common/sys_common.php" );
require_once ( SYS_PATH."common/form_common.php" );
require_once ( SYS_PATH."common/error.class.php" );
require_once ( SYS_PATH."configs/param_base.conf" );
require_once ( SYS_PATH."configs/param_build.conf" );
require_once ( SYS_PATH."configs/param_file.conf" );
require_once ( SYS_PATH."configs/param_map.conf" );
require_once ( SYS_PATH."configs/param_kodawari.conf" );


/*----------------------------------------------------------
  セッション登録開始
----------------------------------------------------------*/
session_start();


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

		$estate_id = htmlspecialchars ($arrData["estate_id"]);
		$estate_update = htmlspecialchars ($arrData["estate_update"]);
		$estate_homeslimit = htmlspecialchars ($arrData["estate_homeslimit"]);
		$estate_homesflg = htmlspecialchars ($arrData["estate_homesflg"]);
		$estate_jishamono = htmlspecialchars ($arrData["estate_jishamono"]);
		$estate_vacant = htmlspecialchars ($arrData["estate_vacant"]);
		$estate_type = htmlspecialchars ($arrData["estate_type"]);
		$estate_batchflg = htmlspecialchars ($arrData["estate_batchflg"]);
		$estate_toushiflg = htmlspecialchars ($arrData["estate_toushiflg"]);
		$estate_name = htmlspecialchars ($arrData["estate_name"]);
		$estate_kana = htmlspecialchars ($arrData["estate_kana"]);

		$estate_nameflg = htmlspecialchars ($arrData["estate_nameflg"]);
		$estate_division = htmlspecialchars ($arrData["estate_division"]);
		$estate_empty = htmlspecialchars ($arrData["estate_empty"]);
		$estate_emptytext = htmlspecialchars ($arrData["estate_emptytext"]);
		$estate_zip = htmlspecialchars ($arrData["estate_zip"]);
		$estate_zip_arr = split("-",$estate_zip);
		$estate_zip1 = $estate_zip_arr[0];
		$estate_zip2 = $estate_zip_arr[1];

		$estate_addcd = htmlspecialchars ($arrData["estate_addcd"]);
		$estate_addname = htmlspecialchars ($arrData["estate_addname"]);
		$estate_addopen = htmlspecialchars ($arrData["estate_addopen"]);
		$estate_addclose = htmlspecialchars ($arrData["estate_addclose"]);
		$estate_map = htmlspecialchars ($arrData["estate_map"]);
		$estate_line1 = htmlspecialchars ($arrData["estate_line1"]);
		$estate_station1 = htmlspecialchars ($arrData["estate_station1"]);
		$estate_busstop1 = htmlspecialchars ($arrData["estate_busstop1"]);
		$estate_bus1 = htmlspecialchars ($arrData["estate_bus1"]);
		$estate_walk1 = htmlspecialchars ($arrData["estate_walk1"]);
		$estate_line2 = htmlspecialchars ($arrData["estate_line2"]);
		$estate_station2 = htmlspecialchars ($arrData["estate_station2"]);
		$estate_busstop2 = htmlspecialchars ($arrData["estate_busstop2"]);
		$estate_bus2 = htmlspecialchars ($arrData["estate_bus2"]);
		$estate_walk2 = htmlspecialchars ($arrData["estate_walk2"]);
		$estate_otherline = htmlspecialchars ($arrData["estate_otherline"]);
		$estate_car = htmlspecialchars ($arrData["estate_car"]);

		$tochi_chimoku = htmlspecialchars ($arrData["tochi_chimoku"]);
		$tochi_usagearea = htmlspecialchars ($arrData["tochi_usagearea"]);
		$tochi_cityplan = htmlspecialchars ($arrData["tochi_cityplan"]);
		$tochi_terrain = htmlspecialchars ($arrData["tochi_terrain"]);
		$tochi_areamethod = htmlspecialchars ($arrData["tochi_areamethod"]);
		$tochi_area = htmlspecialchars ($arrData["tochi_area"]);
		$tochi_loadarea = htmlspecialchars ($arrData["tochi_loadarea"]);
		$tochi_loadratio = htmlspecialchars ($arrData["tochi_loadratio"]);
		$tochi_share = htmlspecialchars ($arrData["tochi_share"]);
		$tochi_setpack = htmlspecialchars ($arrData["tochi_setpack"]);
		$tochi_setbackratio = htmlspecialchars ($arrData["tochi_setbackratio"]);
		$tochi_coverage = htmlspecialchars ($arrData["tochi_coverage"]);
		$tochi_yousekiritsu = htmlspecialchars ($arrData["tochi_yousekiritsu"]);
		$tochi_setsudoustat = htmlspecialchars ($arrData["tochi_setsudoustat"]);
		$tochi_setsudouazimuth1 = htmlspecialchars ($arrData["tochi_setsudouazimuth1"]);
		$tochi_setsudoumaguchi1 = htmlspecialchars ($arrData["tochi_setsudoumaguchi1"]);
		$tochi_setsudoutype1 = htmlspecialchars ($arrData["tochi_setsudoutype1"]);
		$tochi_setsudouwidth1 = htmlspecialchars ($arrData["tochi_setsudouwidth1"]);
		$tochi_ichishitei1 = htmlspecialchars ($arrData["tochi_ichishitei1"]);
		$tochi_setsudouazimuth2 = htmlspecialchars ($arrData["tochi_setsudouazimuth1"]);
		$tochi_setsudoumaguchi2 = htmlspecialchars ($arrData["tochi_setsudoumaguchi1"]);
		$tochi_setsudoutype2 = htmlspecialchars ($arrData["tochi_setsudoutype1"]);
		$tochi_setsudouwidth2 = htmlspecialchars ($arrData["tochi_setsudouwidth1"]);
		$tochi_ichishitei2 = htmlspecialchars ($arrData["tochi_ichishitei1"]);
		$tochi_setsudouazimuth3 = htmlspecialchars ($arrData["tochi_setsudouazimuth1"]);
		$tochi_setsudoumaguchi3 = htmlspecialchars ($arrData["tochi_setsudoumaguchi1"]);
		$tochi_setsudoutype3 = htmlspecialchars ($arrData["tochi_setsudoutype1"]);
		$tochi_setsudouwidth3 = htmlspecialchars ($arrData["tochi_setsudouwidth1"]);
		$tochi_ichishitei3 = htmlspecialchars ($arrData["tochi_ichishitei1"]);
		$tochi_setsudouazimuth4 = htmlspecialchars ($arrData["tochi_setsudouazimuth1"]);
		$tochi_setsudoumaguchi4 = htmlspecialchars ($arrData["tochi_setsudoumaguchi1"]);
		$tochi_setsudoutype4 = htmlspecialchars ($arrData["tochi_setsudoutype1"]);
		$tochi_setsudouwidth4 = htmlspecialchars ($arrData["tochi_setsudouwidth1"]);
		$tochi_ichishitei4 = htmlspecialchars ($arrData["tochi_ichishitei1"]);
		$tochi_kenri = htmlspecialchars ($arrData["tochi_kenri"]);
		$tochi_todokede = htmlspecialchars ($arrData["tochi_todokede"]);
		$tochi_seigen = htmlspecialchars ($arrData["tochi_seigen"]);

		$build_structure = htmlspecialchars ($arrData["build_structure"]);
		$build_areamethod = htmlspecialchars ($arrData["build_areamethod"]);
		$build_area = htmlspecialchars ($arrData["build_area"]);
		$build_shikichiarea = htmlspecialchars ($arrData["build_shikichiarea"]);
		$build_nobeyukaarea = htmlspecialchars ($arrData["build_nobeyukaarea"]);
		$build_kenchikuarea = htmlspecialchars ($arrData["build_kenchikuarea"]);
		$build_floor = htmlspecialchars ($arrData["build_floor"]);
		$build_basement = htmlspecialchars ($arrData["build_basement"]);
		$build_age = htmlspecialchars ($arrData["build_age"]);
		$build_age_arr = split("-",$build_age);
		$build_age_year = $build_age_arr[0];
		$build_age_month = $build_age_arr[1];
		$build_newflg = htmlspecialchars ($arrData["build_newflg"]);

		$manager_stat = htmlspecialchars ($arrData["manager_stat"]);
		$manager_type = htmlspecialchars ($arrData["manager_type"]);
		$manager_flg = htmlspecialchars ($arrData["manager_flg"]);
		$manager_comname = htmlspecialchars ($arrData["manager_comname"]);

		$room_floor = htmlspecialchars ($arrData["room_floor"]);
		$room_balconyarea = htmlspecialchars ($arrData["room_balconyarea"]);
		$room_azimuth = htmlspecialchars ($arrData["room_azimuth"]);

		$madori_roomnum = htmlspecialchars ($arrData["madori_roomnum"]);
		$madori_roomtype = htmlspecialchars ($arrData["madori_roomtype"]);
		$madori_type1 = htmlspecialchars ($arrData["madori_type1"]);
		$madori_jyounum1 = htmlspecialchars ($arrData["madori_jyounum1"]);
		$madori_floor1 = htmlspecialchars ($arrData["madori_floor1"]);
		$madori_num1 = htmlspecialchars ($arrData["madori_num1"]);
		$madori_type2 = htmlspecialchars ($arrData["madori_type2"]);
		$madori_jyounum2 = htmlspecialchars ($arrData["madori_jyounum2"]);
		$madori_floor2 = htmlspecialchars ($arrData["madori_floor2"]);
		$madori_num2 = htmlspecialchars ($arrData["madori_num2"]);
		$madori_type3 = htmlspecialchars ($arrData["madori_type3"]);
		$madori_jyounum3 = htmlspecialchars ($arrData["madori_jyounum3"]);
		$madori_floor3 = htmlspecialchars ($arrData["madori_floor3"]);
		$madori_num3 = htmlspecialchars ($arrData["madori_num3"]);
		$madori_type4 = htmlspecialchars ($arrData["madori_type4"]);
		$madori_jyounum4 = htmlspecialchars ($arrData["madori_jyounum4"]);
		$madori_floor4 = htmlspecialchars ($arrData["madori_floor4"]);
		$madori_num4 = htmlspecialchars ($arrData["madori_num4"]);
		$madori_type5 = htmlspecialchars ($arrData["madori_type5"]);
		$madori_jyounum5 = htmlspecialchars ($arrData["madori_jyounum5"]);
		$madori_floor5 = htmlspecialchars ($arrData["madori_floor5"]);
		$madori_num5 = htmlspecialchars ($arrData["madori_num5"]);
		$madori_type6 = htmlspecialchars ($arrData["madori_type6"]);
		$madori_jyounum6 = htmlspecialchars ($arrData["madori_jyounum6"]);
		$madori_floor6 = htmlspecialchars ($arrData["madori_floor6"]);
		$madori_num6 = htmlspecialchars ($arrData["madori_num6"]);
		$madori_type7 = htmlspecialchars ($arrData["madori_type7"]);
		$madori_jyounum7 = htmlspecialchars ($arrData["madori_jyounum7"]);
		$madori_floor7 = htmlspecialchars ($arrData["madori_floor7"]);
		$madori_num7 = htmlspecialchars ($arrData["madori_num7"]);
		$madori_type8 = htmlspecialchars ($arrData["madori_type8"]);
		$madori_jyounum8 = htmlspecialchars ($arrData["madori_jyounum8"]);
		$madori_floor8 = htmlspecialchars ($arrData["madori_floor8"]);
		$madori_num8 = htmlspecialchars ($arrData["madori_num8"]);
		$madori_type9 = htmlspecialchars ($arrData["madori_type9"]);
		$madori_jyounum9 = htmlspecialchars ($arrData["madori_jyounum9"]);
		$madori_floor9 = htmlspecialchars ($arrData["madori_floor9"]);
		$madori_num9 = htmlspecialchars ($arrData["madori_num9"]);
		$madori_type10 = htmlspecialchars ($arrData["madori_type10"]);
		$madori_jyounum10 = htmlspecialchars ($arrData["madori_jyounum10"]);
		$madori_floor10 = htmlspecialchars ($arrData["madori_floor10"]);
		$madori_num10 = htmlspecialchars ($arrData["madori_num10"]);
		$madori_biko = htmlspecialchars ($arrData["madori_biko"]);

		$feacher_all = htmlspecialchars ($arrData["feacher_all"]);
		$feacher_a = htmlspecialchars ($arrData["feacher_a"]);
		$feacher_b = htmlspecialchars ($arrData["feacher_b"]);

		$biko_all = htmlspecialchars ($arrData["biko_all"]);
		$biko_a = htmlspecialchars ($arrData["biko_a"]);
		$biko_b = htmlspecialchars ($arrData["biko_b"]);
		$biko_url1 = htmlspecialchars ($arrData["biko_url1"]);
		$biko_url2 = htmlspecialchars ($arrData["biko_url2"]);
		$biko_memo = htmlspecialchars ($arrData["biko_memo"]);

		$price_main = htmlspecialchars ($arrData["price_main"]);
		$price_flg = htmlspecialchars ($arrData["price_flg"]);
		$price_stat = htmlspecialchars ($arrData["price_stat"]);
		$price_taxflg = htmlspecialchars ($arrData["price_taxflg"]);
		$price_tax = htmlspecialchars ($arrData["price_tax"]);
		$price_tsubotanka = htmlspecialchars ($arrData["price_tsubotanka"]);
		$price_cntrlprice = htmlspecialchars ($arrData["price_cntrlprice"]);
		$price_cntrlpricetax = htmlspecialchars ($arrData["price_cntrlprice"]);
		$price_rei = htmlspecialchars ($arrData["price_rei"]);
		$price_reitax = htmlspecialchars ($arrData["price_reitax"]);
		$price_siki = htmlspecialchars ($arrData["price_siki"]);
		$price_secprice = htmlspecialchars ($arrData["price_secprice"]);
		$price_kenrikin = htmlspecialchars ($arrData["price_kenrikin"]);
		$price_kenrikintax = htmlspecialchars ($arrData["price_kenrikintax"]);
		$price_joutokin = htmlspecialchars ($arrData["price_joutokin"]);
		$price_joutokintax = htmlspecialchars ($arrData["price_joutokintax"]);
		$price_sikibiki = htmlspecialchars ($arrData["price_sikibiki"]);
		$price_sikibikitime = htmlspecialchars ($arrData["price_sikibikitime"]);
		$price_updprice = htmlspecialchars ($arrData["price_updprice"]);
		$price_fullyield = htmlspecialchars ($arrData["price_fullyield"]);
		$price_nowyield = htmlspecialchars ($arrData["price_nowyield"]);
		$price_insuranceprice = htmlspecialchars ($arrData["price_insuranceprice"]);
		$price_insuranceperiod = htmlspecialchars ($arrData["price_insuranceperiod"]);
		$price_leaseprice = htmlspecialchars ($arrData["price_leaseprice"]);
		$price_contractyear = htmlspecialchars ($arrData["price_contractyear"]);
		$price_contractmonth = htmlspecialchars ($arrData["price_contractmonth"]);
		$price_contractdivision = htmlspecialchars ($arrData["price_contractdivision"]);
		$price_mendingprice = htmlspecialchars ($arrData["price_mendingprice"]);
		$price_mendingfund = htmlspecialchars ($arrData["price_mendingfund"]);
		$price_otherpricetitle1 = htmlspecialchars ($arrData["price_otherpricetitle1"]);
		$price_otherprice1 = htmlspecialchars ($arrData["price_otherprice1"]);
		$price_otherpricetitle2 = htmlspecialchars ($arrData["price_otherpricetitle2"]);
		$price_otherprice2 = htmlspecialchars ($arrData["price_otherprice2"]);
		$price_otherpricetitle3 = htmlspecialchars ($arrData["price_otherpricetitle3"]);
		$price_otherprice3 = htmlspecialchars ($arrData["price_otherprice3"]);

		$contract_price = htmlspecialchars ($arrData["contract_price"]);
		$contract_date = htmlspecialchars ($arrData["contract_date"]);
		$contract_taxflg = htmlspecialchars ($arrData["contract_taxflg"]);
		$contract_tax = htmlspecialchars ($arrData["contract_tax"]);

		$parking_price = htmlspecialchars ($arrData["parking_price"]);
		$parking_pricetax = htmlspecialchars ($arrData["parking_pricetax"]);
		$parking_division = htmlspecialchars ($arrData["parking_division"]);
		$parking_distance = htmlspecialchars ($arrData["parking_distance"]);
		$parking_emptynum = htmlspecialchars ($arrData["parking_emptynum"]);
		$parking_biko = htmlspecialchars ($arrData["parking_biko"]);

		$delivery_vacant = htmlspecialchars ($arrData["delivery_vacant"]);
		$delivery_flg = htmlspecialchars ($arrData["delivery_flg"]);
		$delivery_date = htmlspecialchars ($arrData["delivery_date"]);
		$delivery_season = htmlspecialchars ($arrData["delivery_season"]);

		$surround_syougakkou = htmlspecialchars ($arrData["surround_syougakkou"]);
		$surround_syoudistance = htmlspecialchars ($arrData["surround_syoudistance"]);
		$surround_syoucd = htmlspecialchars ($arrData["surround_syoucd"]);
		$surround_chuugakkou = htmlspecialchars ($arrData["surround_chuugakkou"]);
		$surround_chuudistance = htmlspecialchars ($arrData["surround_chuudistance"]);
		$surround_chuucd = htmlspecialchars ($arrData["surround_chuucd"]);
		$surround_konbinidistance = htmlspecialchars ($arrData["surround_konbinidistance"]);
		$surround_superdistance = htmlspecialchars ($arrData["surround_superdistance"]);
		$surround_hospitaldistance = htmlspecialchars ($arrData["surround_hospitaldistance"]);

		$tanto_name = htmlspecialchars ($arrData["tanto_name"]);

		$trade_mode = htmlspecialchars ($arrData["trade_mode"]);
		$trade_date = htmlspecialchars ($arrData["trade_date"]);

		$kyakuzuke_flg = htmlspecialchars ($arrData["kyakuzuke_flg"]);
		$kyakuzuke_date = htmlspecialchars ($arrData["kyakuzuke_date"]);
		$kyakuzuke_price = htmlspecialchars ($arrData["kyakuzuke_price"]);
		$kyakuzuke_bunpai = htmlspecialchars ($arrData["kyakuzuke_bunpai"]);
		$kyakuzuke_futan = htmlspecialchars ($arrData["kyakuzuke_futan"]);
		$kyakuzuke_message = htmlspecialchars ($arrData["kyakuzuke_message"]);

		$motozuke_name = htmlspecialchars ($arrData["motozuke_name"]);
		$motozuke_zip = htmlspecialchars ($arrData["motozuke_zip"]);
		$motozuke_addcd = htmlspecialchars ($arrData["motozuke_addcd"]);
		$motozuke_addname = htmlspecialchars ($arrData["motozuke_addname"]);
		$motozuke_addopen = htmlspecialchars ($arrData["motozuke_addopen"]);
		$motozuke_tell = htmlspecialchars ($arrData["motozuke_tell"]);
		$motozuke_fax = htmlspecialchars ($arrData["motozuke_fax"]);
		$motozuke_biko = htmlspecialchars ($arrData["motozuke_biko"]);

		$owner_name = htmlspecialchars ($arrData["owner_name"]);
		$owner_zip = htmlspecialchars ($arrData["owner_zip"]);
		$owner_addcd = htmlspecialchars ($arrData["owner_addcd"]);
		$owner_addname = htmlspecialchars ($arrData["owner_addname"]);
		$owner_addopen = htmlspecialchars ($arrData["owner_addopen"]);
		$owner_tell = htmlspecialchars ($arrData["owner_tell"]);
		$owner_fax = htmlspecialchars ($arrData["owner_fax"]);
		$owner_biko = htmlspecialchars ($arrData["owner_biko"]);

		$openhouse_start = htmlspecialchars ($arrData["openhouse_start"]);
		$openhouse_end = htmlspecialchars ($arrData["openhouse_end"]);
		$openhouse_period = htmlspecialchars ($arrData["openhouse_period"]);
		$openhouse_biko = htmlspecialchars ($arrData["openhouse_biko"]);

		$img_org1 = htmlspecialchars ($arrData["img_org1"]);
		$img_upddate1 = htmlspecialchars ($arrData["img_upddate1"]);
		$img_type1 = htmlspecialchars ($arrData["img_type1"]);
		$img_comment1 = htmlspecialchars ($arrData["img_comment1"]);
		$img_org2 = htmlspecialchars ($arrData["img_org2"]);
		$img_upddate2 = htmlspecialchars ($arrData["img_upddate2"]);
		$img_type2 = htmlspecialchars ($arrData["img_type2"]);
		$img_comment2 = htmlspecialchars ($arrData["img_comment2"]);
		$img_org3 = htmlspecialchars ($arrData["img_org3"]);
		$img_upddate3 = htmlspecialchars ($arrData["img_upddate3"]);
		$img_type3 = htmlspecialchars ($arrData["img_type3"]);
		$img_comment3 = htmlspecialchars ($arrData["img_comment3"]);
		$img_org4 = htmlspecialchars ($arrData["img_org4"]);
		$img_upddate4 = htmlspecialchars ($arrData["img_upddate4"]);
		$img_type4 = htmlspecialchars ($arrData["img_type4"]);
		$img_comment4 = htmlspecialchars ($arrData["img_comment4"]);
		$img_org5 = htmlspecialchars ($arrData["img_org5"]);
		$img_upddate5 = htmlspecialchars ($arrData["img_upddate5"]);
		$img_type5 = htmlspecialchars ($arrData["img_type5"]);
		$img_comment5 = htmlspecialchars ($arrData["img_comment5"]);
		$img_org6 = htmlspecialchars ($arrData["img_org6"]);
		$img_upddate6 = htmlspecialchars ($arrData["img_upddate6"]);
		$img_type6 = htmlspecialchars ($arrData["img_type6"]);
		$img_comment6 = htmlspecialchars ($arrData["img_comment6"]);
		$img_org7 = htmlspecialchars ($arrData["img_org7"]);
		$img_upddate7 = htmlspecialchars ($arrData["img_upddate7"]);
		$img_type7 = htmlspecialchars ($arrData["img_type7"]);
		$img_comment7 = htmlspecialchars ($arrData["img_comment7"]);
		$img_org8 = htmlspecialchars ($arrData["img_org8"]);
		$img_upddate8 = htmlspecialchars ($arrData["img_upddate8"]);
		$img_type8 = htmlspecialchars ($arrData["img_type8"]);
		$img_comment8 = htmlspecialchars ($arrData["img_comment8"]);
		$img_org9 = htmlspecialchars ($arrData["img_org9"]);
		$img_upddate9 = htmlspecialchars ($arrData["img_upddate9"]);
		$img_type9 = htmlspecialchars ($arrData["img_type9"]);
		$img_comment9 = htmlspecialchars ($arrData["img_comment9"]);
		$img_org10 = htmlspecialchars ($arrData["img_org10"]);
		$img_upddate10 = htmlspecialchars ($arrData["img_upddate10"]);
		$img_type10 = htmlspecialchars ($arrData["img_type10"]);
		$img_comment10 = htmlspecialchars ($arrData["img_comment10"]);

		$estate_group = htmlspecialchars ($arrData["estate_group"]);
		$estate_equip = htmlspecialchars ($arrData["estate_equip"]);

		$estate_pointnum = htmlspecialchars ($arrData["estate_pointnum"]);

		$estate_end = htmlspecialchars ($arrData["estate_end"]);

		$estate_clid = htmlspecialchars ($arrData["estate_clid"]);
		$estate_ido = htmlspecialchars ($arrData["estate_ido"]);
		$estate_keido = htmlspecialchars ($arrData["estate_keido"]);
		$estate_zoom = htmlspecialchars ($arrData["estate_zoom"]);
		$estate_adminid = htmlspecialchars ($arrData["estate_adminid"]);
		$estate_insdate = htmlspecialchars ($arrData["estate_insdate"]);
		$estate_upddate = htmlspecialchars ($arrData["estate_upddate"]);
		$estate_deldate = htmlspecialchars ($arrData["estate_deldate"]);
		$estate_yobi1 = htmlspecialchars ($arrData["estate_yobi1"]);
		$estate_yobi2 = htmlspecialchars ($arrData["estate_yobi2"]);
		$estate_yobi3 = htmlspecialchars ($arrData["estate_yobi3"]);
		$estate_yobi4 = htmlspecialchars ($arrData["estate_yobi4"]);
		$estate_yobi5 = htmlspecialchars ($arrData["estate_yobi5"]);

	if($_POST['mode']=="EDIT"){

		$obj = new basedb_BuildClassTblAccess;
		$obj->conn = $obj_conn->conn;
		$obj->jyoken["estate_del_date"] = 1;
		$obj->jyoken["estate_id"] = $_POST['estate_id'];
		list( $intCnt , $intTotal ) = $obj->basedb_GetBuild( 1 , -1 );
		IF( $intCnt == -1 ){
			$arrOther["ath_comment"] = "<INPUT TYPE=\"hidden\" NAME=\"stpos\" VALUE=\"{$_POST['stpos']}\">";
			$obj_error->ViewErrMessage( "SYSTEM" , "ALL" , SITE_PATH."blank.php" , $arrOther );
			exit;
		}

		$strViewDelForm = "";
		$strViewDelForm .= "<form action=\"build_upd.php\" method=\"POST\" name=\"del_form\">\n";
		$strViewDelForm .= "  <td align=\"center\" valign=\"top\">\n";
		$strViewDelForm .= "    <input type=\"button\" value=\"削除する\" onclick=\"return BuildDeleteCheck( this.form , this.form )\" class=\"btn_nosize\" style=\"width:150px;\" />\n";
		$strViewDelForm .= "    <input type=\"hidden\" name=\"mode\" value=\"DEL\" />\n";
		$strViewDelForm .= "    <input type=\"hidden\" name=\"estate_id\" value=\"{$estate_id}\" />\n";
		$strViewDelForm .= "    <input type=\"hidden\" name=\"estate_upddate\" value=\"{$estate_upddate}\" />\n";
		$strViewDelForm .= "    <input type=\"hidden\" name=\"estate_photo_lastupd\" value=\"{$estate_photo}\"/>\n";
		$strViewDelForm .= "    <input type=\"hidden\" name=\"search_flg\" value=\"{$_POST['search_flg']}\"/>\n";
		$strViewDelForm .= "    <input type=\"hidden\" name=\"search_estate_name\" value=\"{$_POST['search_estate_name']}\"/>\n";
		$strViewDelForm .= "    <input type=\"hidden\" name=\"search_address\" value=\"{$_POST['search_address']}\"/>\n";
		$strViewDelForm .= "  </td>\n";
		$strViewDelForm .= "</form>\n";
		
		$modeName = "修正";

	}else if($_POST['mode']=="NEW"){

		$modeName = "登録";
		if($estate_map[3]=="")$estate_map[3] = 10;

	}
}else{
	if($_POST['mode']=="EDIT"){
		$obj = new basedb_EstateClassTblAccess;
		$obj->conn = $obj_conn->conn;
		$obj->jyoken["estate_del_date"] = 1;
		$obj->jyoken["estate_id"] = $_POST['estate_id'];
		list( $intCnt , $intTotal ) = $obj->basedb_GetEstate( 1 , -1 );
		IF( $intCnt == -1 ){
			$arrOther["ath_comment"] = "<INPUT TYPE=\"hidden\" NAME=\"stpos\" VALUE=\"{$_POST['stpos']}\">";
			$obj_error->ViewErrMessage( "SYSTEM" , "ALL" , SITE_PATH."blank.php" , $arrOther );
			exit;
		}

		$estate_id = htmlspecialchars ($obj->estatedat[0]["estate_id"]);
		$estate_update = htmlspecialchars ($obj->estatedat[0]["estate_update"]);
		$estate_homeslimit = htmlspecialchars ($obj->estatedat[0]["estate_homeslimit"]);
		$estate_homesflg = htmlspecialchars ($obj->estatedat[0]["estate_homesflg"]);
		$estate_jishamono = htmlspecialchars ($obj->estatedat[0]["estate_jishamono"]);
		$estate_vacant = htmlspecialchars ($obj->estatedat[0]["estate_vacant"]);
		$estate_type = htmlspecialchars ($obj->estatedat[0]["estate_type"]);
		$estate_batchflg = htmlspecialchars ($obj->estatedat[0]["estate_batchflg"]);
		$estate_toushiflg = htmlspecialchars ($obj->estatedat[0]["estate_toushiflg"]);
		$estate_name = htmlspecialchars ($obj->estatedat[0]["estate_name"]);
		$estate_kana = htmlspecialchars ($obj->estatedat[0]["estate_kana"]);

		$estate_nameflg = htmlspecialchars ($obj->estatedat[0]["estate_nameflg"]);
		$estate_division = htmlspecialchars ($obj->estatedat[0]["estate_division"]);
		$estate_empty = htmlspecialchars ($obj->estatedat[0]["estate_empty"]);
		$estate_emptytext = htmlspecialchars ($obj->estatedat[0]["estate_emptytext"]);
		$estate_zip = htmlspecialchars ($obj->estatedat[0]["estate_zip"]);
		$estate_zip_arr = split("-",$estate_zip);
		$estate_zip1 = $estate_zip_arr[0];
		$estate_zip2 = $estate_zip_arr[1];

		$estate_addcd = htmlspecialchars ($obj->estatedat[0]["estate_addcd"]);
		$estate_addname = htmlspecialchars ($obj->estatedat[0]["estate_addname"]);
		$estate_addopen = htmlspecialchars ($obj->estatedat[0]["estate_addopen"]);
		$estate_addclose = htmlspecialchars ($obj->estatedat[0]["estate_addclose"]);
		$estate_map = htmlspecialchars ($obj->estatedat[0]["estate_map"]);
		$estate_line1 = htmlspecialchars ($obj->estatedat[0]["estate_line1"]);
		$estate_station1 = htmlspecialchars ($obj->estatedat[0]["estate_station1"]);
		$estate_busstop1 = htmlspecialchars ($obj->estatedat[0]["estate_busstop1"]);
		$estate_bus1 = htmlspecialchars ($obj->estatedat[0]["estate_bus1"]);
		$estate_walk1 = htmlspecialchars ($obj->estatedat[0]["estate_walk1"]);
		$estate_line2 = htmlspecialchars ($obj->estatedat[0]["estate_line2"]);
		$estate_station2 = htmlspecialchars ($obj->estatedat[0]["estate_station2"]);
		$estate_busstop2 = htmlspecialchars ($obj->estatedat[0]["estate_busstop2"]);
		$estate_bus2 = htmlspecialchars ($obj->estatedat[0]["estate_bus2"]);
		$estate_walk2 = htmlspecialchars ($obj->estatedat[0]["estate_walk2"]);
		$estate_otherline = htmlspecialchars ($obj->estatedat[0]["estate_otherline"]);
		$estate_car = htmlspecialchars ($obj->estatedat[0]["estate_car"]);

		$tochi_chimoku = htmlspecialchars ($obj->estatedat[0]["tochi_chimoku"]);
		$tochi_usagearea = htmlspecialchars ($obj->estatedat[0]["tochi_usagearea"]);
		$tochi_cityplan = htmlspecialchars ($obj->estatedat[0]["tochi_cityplan"]);
		$tochi_terrain = htmlspecialchars ($obj->estatedat[0]["tochi_terrain"]);
		$tochi_areamethod = htmlspecialchars ($obj->estatedat[0]["tochi_areamethod"]);
		$tochi_area = htmlspecialchars ($obj->estatedat[0]["tochi_area"]);
		$tochi_loadarea = htmlspecialchars ($obj->estatedat[0]["tochi_loadarea"]);
		$tochi_loadratio = htmlspecialchars ($obj->estatedat[0]["tochi_loadratio"]);
		$tochi_share = htmlspecialchars ($obj->estatedat[0]["tochi_share"]);
		$tochi_setpack = htmlspecialchars ($obj->estatedat[0]["tochi_setpack"]);
		$tochi_setbackratio = htmlspecialchars ($obj->estatedat[0]["tochi_setbackratio"]);
		$tochi_coverage = htmlspecialchars ($obj->estatedat[0]["tochi_coverage"]);
		$tochi_yousekiritsu = htmlspecialchars ($obj->estatedat[0]["tochi_yousekiritsu"]);
		$tochi_setsudoustat = htmlspecialchars ($obj->estatedat[0]["tochi_setsudoustat"]);
		$tochi_setsudouazimuth1 = htmlspecialchars ($obj->estatedat[0]["tochi_setsudouazimuth1"]);
		$tochi_setsudoumaguchi1 = htmlspecialchars ($obj->estatedat[0]["tochi_setsudoumaguchi1"]);
		$tochi_setsudoutype1 = htmlspecialchars ($obj->estatedat[0]["tochi_setsudoutype1"]);
		$tochi_setsudouwidth1 = htmlspecialchars ($obj->estatedat[0]["tochi_setsudouwidth1"]);
		$tochi_ichishitei1 = htmlspecialchars ($obj->estatedat[0]["tochi_ichishitei1"]);
		$tochi_setsudouazimuth2 = htmlspecialchars ($obj->estatedat[0]["tochi_setsudouazimuth1"]);
		$tochi_setsudoumaguchi2 = htmlspecialchars ($obj->estatedat[0]["tochi_setsudoumaguchi1"]);
		$tochi_setsudoutype2 = htmlspecialchars ($obj->estatedat[0]["tochi_setsudoutype1"]);
		$tochi_setsudouwidth2 = htmlspecialchars ($obj->estatedat[0]["tochi_setsudouwidth1"]);
		$tochi_ichishitei2 = htmlspecialchars ($obj->estatedat[0]["tochi_ichishitei1"]);
		$tochi_setsudouazimuth3 = htmlspecialchars ($obj->estatedat[0]["tochi_setsudouazimuth1"]);
		$tochi_setsudoumaguchi3 = htmlspecialchars ($obj->estatedat[0]["tochi_setsudoumaguchi1"]);
		$tochi_setsudoutype3 = htmlspecialchars ($obj->estatedat[0]["tochi_setsudoutype1"]);
		$tochi_setsudouwidth3 = htmlspecialchars ($obj->estatedat[0]["tochi_setsudouwidth1"]);
		$tochi_ichishitei3 = htmlspecialchars ($obj->estatedat[0]["tochi_ichishitei1"]);
		$tochi_setsudouazimuth4 = htmlspecialchars ($obj->estatedat[0]["tochi_setsudouazimuth1"]);
		$tochi_setsudoumaguchi4 = htmlspecialchars ($obj->estatedat[0]["tochi_setsudoumaguchi1"]);
		$tochi_setsudoutype4 = htmlspecialchars ($obj->estatedat[0]["tochi_setsudoutype1"]);
		$tochi_setsudouwidth4 = htmlspecialchars ($obj->estatedat[0]["tochi_setsudouwidth1"]);
		$tochi_ichishitei4 = htmlspecialchars ($obj->estatedat[0]["tochi_ichishitei1"]);
		$tochi_kenri = htmlspecialchars ($obj->estatedat[0]["tochi_kenri"]);
		$tochi_todokede = htmlspecialchars ($obj->estatedat[0]["tochi_todokede"]);
		$tochi_seigen = htmlspecialchars ($obj->estatedat[0]["tochi_seigen"]);

		$build_structure = htmlspecialchars ($obj->estatedat[0]["build_structure"]);
		$build_areamethod = htmlspecialchars ($obj->estatedat[0]["build_areamethod"]);
		$build_area = htmlspecialchars ($obj->estatedat[0]["build_area"]);
		$build_shikichiarea = htmlspecialchars ($obj->estatedat[0]["build_shikichiarea"]);
		$build_nobeyukaarea = htmlspecialchars ($obj->estatedat[0]["build_nobeyukaarea"]);
		$build_kenchikuarea = htmlspecialchars ($obj->estatedat[0]["build_kenchikuarea"]);
		$build_floor = htmlspecialchars ($obj->estatedat[0]["build_floor"]);
		$build_basement = htmlspecialchars ($obj->estatedat[0]["build_basement"]);
		$build_age_arr = split("-",$obj->estatedat[0]["build_age"]);
		$build_age_year = htmlspecialchars ($build_age_arr[0]);
		$build_age_month = htmlspecialchars ($build_age_arr[1]);
		$build_newflg = htmlspecialchars ($obj->estatedat[0]["build_newflg"]);

		$manager_stat = htmlspecialchars ($obj->estatedat[0]["manager_stat"]);
		$manager_type = htmlspecialchars ($obj->estatedat[0]["manager_type"]);
		$manager_flg = htmlspecialchars ($obj->estatedat[0]["manager_flg"]);
		$manager_comname = htmlspecialchars ($obj->estatedat[0]["manager_comname"]);

		$room_floor = htmlspecialchars ($obj->estatedat[0]["room_floor"]);
		$room_balconyarea = htmlspecialchars ($obj->estatedat[0]["room_balconyarea"]);
		$room_azimuth = htmlspecialchars ($obj->estatedat[0]["room_azimuth"]);

		$madori_roomnum = htmlspecialchars ($obj->estatedat[0]["madori_roomnum"]);
		$madori_roomtype = htmlspecialchars ($obj->estatedat[0]["madori_roomtype"]);
		$madori_type1 = htmlspecialchars ($obj->estatedat[0]["madori_type1"]);
		$madori_jyounum1 = htmlspecialchars ($obj->estatedat[0]["madori_jyounum1"]);
		$madori_floor1 = htmlspecialchars ($obj->estatedat[0]["madori_floor1"]);
		$madori_num1 = htmlspecialchars ($obj->estatedat[0]["madori_num1"]);
		$madori_type2 = htmlspecialchars ($obj->estatedat[0]["madori_type2"]);
		$madori_jyounum2 = htmlspecialchars ($obj->estatedat[0]["madori_jyounum2"]);
		$madori_floor2 = htmlspecialchars ($obj->estatedat[0]["madori_floor2"]);
		$madori_num2 = htmlspecialchars ($obj->estatedat[0]["madori_num2"]);
		$madori_type3 = htmlspecialchars ($obj->estatedat[0]["madori_type3"]);
		$madori_jyounum3 = htmlspecialchars ($obj->estatedat[0]["madori_jyounum3"]);
		$madori_floor3 = htmlspecialchars ($obj->estatedat[0]["madori_floor3"]);
		$madori_num3 = htmlspecialchars ($obj->estatedat[0]["madori_num3"]);
		$madori_type4 = htmlspecialchars ($obj->estatedat[0]["madori_type4"]);
		$madori_jyounum4 = htmlspecialchars ($obj->estatedat[0]["madori_jyounum4"]);
		$madori_floor4 = htmlspecialchars ($obj->estatedat[0]["madori_floor4"]);
		$madori_num4 = htmlspecialchars ($obj->estatedat[0]["madori_num4"]);
		$madori_type5 = htmlspecialchars ($obj->estatedat[0]["madori_type5"]);
		$madori_jyounum5 = htmlspecialchars ($obj->estatedat[0]["madori_jyounum5"]);
		$madori_floor5 = htmlspecialchars ($obj->estatedat[0]["madori_floor5"]);
		$madori_num5 = htmlspecialchars ($obj->estatedat[0]["madori_num5"]);
		$madori_type6 = htmlspecialchars ($obj->estatedat[0]["madori_type6"]);
		$madori_jyounum6 = htmlspecialchars ($obj->estatedat[0]["madori_jyounum6"]);
		$madori_floor6 = htmlspecialchars ($obj->estatedat[0]["madori_floor6"]);
		$madori_num6 = htmlspecialchars ($obj->estatedat[0]["madori_num6"]);
		$madori_type7 = htmlspecialchars ($obj->estatedat[0]["madori_type7"]);
		$madori_jyounum7 = htmlspecialchars ($obj->estatedat[0]["madori_jyounum7"]);
		$madori_floor7 = htmlspecialchars ($obj->estatedat[0]["madori_floor7"]);
		$madori_num7 = htmlspecialchars ($obj->estatedat[0]["madori_num7"]);
		$madori_type8 = htmlspecialchars ($obj->estatedat[0]["madori_type8"]);
		$madori_jyounum8 = htmlspecialchars ($obj->estatedat[0]["madori_jyounum8"]);
		$madori_floor8 = htmlspecialchars ($obj->estatedat[0]["madori_floor8"]);
		$madori_num8 = htmlspecialchars ($obj->estatedat[0]["madori_num8"]);
		$madori_type9 = htmlspecialchars ($obj->estatedat[0]["madori_type9"]);
		$madori_jyounum9 = htmlspecialchars ($obj->estatedat[0]["madori_jyounum9"]);
		$madori_floor9 = htmlspecialchars ($obj->estatedat[0]["madori_floor9"]);
		$madori_num9 = htmlspecialchars ($obj->estatedat[0]["madori_num9"]);
		$madori_type10 = htmlspecialchars ($obj->estatedat[0]["madori_type10"]);
		$madori_jyounum10 = htmlspecialchars ($obj->estatedat[0]["madori_jyounum10"]);
		$madori_floor10 = htmlspecialchars ($obj->estatedat[0]["madori_floor10"]);
		$madori_num10 = htmlspecialchars ($obj->estatedat[0]["madori_num10"]);
		$madori_biko = htmlspecialchars ($obj->estatedat[0]["madori_biko"]);

		$feacher_all = htmlspecialchars ($obj->estatedat[0]["feacher_all"]);
		$feacher_a = htmlspecialchars ($obj->estatedat[0]["feacher_a"]);
		$feacher_b = htmlspecialchars ($obj->estatedat[0]["feacher_b"]);

		$biko_all = htmlspecialchars ($obj->estatedat[0]["biko_all"]);
		$biko_a = htmlspecialchars ($obj->estatedat[0]["biko_a"]);
		$biko_b = htmlspecialchars ($obj->estatedat[0]["biko_b"]);
		$biko_url1 = htmlspecialchars ($obj->estatedat[0]["biko_url1"]);
		$biko_url2 = htmlspecialchars ($obj->estatedat[0]["biko_url2"]);
		$biko_memo = htmlspecialchars ($obj->estatedat[0]["biko_memo"]);

		$price_main = htmlspecialchars ($obj->estatedat[0]["price_main"]);
		$price_flg = htmlspecialchars ($obj->estatedat[0]["price_flg"]);
		$price_stat = htmlspecialchars ($obj->estatedat[0]["price_stat"]);
		$price_taxflg = htmlspecialchars ($obj->estatedat[0]["price_taxflg"]);
		$price_tax = htmlspecialchars ($obj->estatedat[0]["price_tax"]);
		$price_tsubotanka = htmlspecialchars ($obj->estatedat[0]["price_tsubotanka"]);
		$price_cntrlprice = htmlspecialchars ($obj->estatedat[0]["price_cntrlprice"]);
		$price_cntrlpricetax = htmlspecialchars ($obj->estatedat[0]["price_cntrlprice"]);
		$price_rei = htmlspecialchars ($obj->estatedat[0]["price_rei"]);
		$price_reitax = htmlspecialchars ($obj->estatedat[0]["price_reitax"]);
		$price_siki = htmlspecialchars ($obj->estatedat[0]["price_siki"]);
		$price_secprice = htmlspecialchars ($obj->estatedat[0]["price_secprice"]);
		$price_kenrikin = htmlspecialchars ($obj->estatedat[0]["price_kenrikin"]);
		$price_kenrikintax = htmlspecialchars ($obj->estatedat[0]["price_kenrikintax"]);
		$price_joutokin = htmlspecialchars ($obj->estatedat[0]["price_joutokin"]);
		$price_joutokintax = htmlspecialchars ($obj->estatedat[0]["price_joutokintax"]);
		$price_sikibiki = htmlspecialchars ($obj->estatedat[0]["price_sikibiki"]);
		$price_sikibikitime = htmlspecialchars ($obj->estatedat[0]["price_sikibikitime"]);
		$price_updprice = htmlspecialchars ($obj->estatedat[0]["price_updprice"]);
		$price_fullyield = htmlspecialchars ($obj->estatedat[0]["price_fullyield"]);
		$price_nowyield = htmlspecialchars ($obj->estatedat[0]["price_nowyield"]);
		$price_insuranceprice = htmlspecialchars ($obj->estatedat[0]["price_insuranceprice"]);
		$price_insuranceperiod = htmlspecialchars ($obj->estatedat[0]["price_insuranceperiod"]);
		$price_leaseprice = htmlspecialchars ($obj->estatedat[0]["price_leaseprice"]);
		$price_contractyear = htmlspecialchars ($obj->estatedat[0]["price_contractyear"]);
		$price_contractmonth = htmlspecialchars ($obj->estatedat[0]["price_contractmonth"]);
		$price_contractdivision = htmlspecialchars ($obj->estatedat[0]["price_contractdivision"]);
		$price_mendingprice = htmlspecialchars ($obj->estatedat[0]["price_mendingprice"]);
		$price_mendingfund = htmlspecialchars ($obj->estatedat[0]["price_mendingfund"]);
		$price_otherpricetitle1 = htmlspecialchars ($obj->estatedat[0]["price_otherpricetitle1"]);
		$price_otherprice1 = htmlspecialchars ($obj->estatedat[0]["price_otherprice1"]);
		$price_otherpricetitle2 = htmlspecialchars ($obj->estatedat[0]["price_otherpricetitle2"]);
		$price_otherprice2 = htmlspecialchars ($obj->estatedat[0]["price_otherprice2"]);
		$price_otherpricetitle3 = htmlspecialchars ($obj->estatedat[0]["price_otherpricetitle3"]);
		$price_otherprice3 = htmlspecialchars ($obj->estatedat[0]["price_otherprice3"]);

		$contract_price = htmlspecialchars ($obj->estatedat[0]["contract_price"]);
		$contract_date = htmlspecialchars ($obj->estatedat[0]["contract_date"]);
		$contract_taxflg = htmlspecialchars ($obj->estatedat[0]["contract_taxflg"]);
		$contract_tax = htmlspecialchars ($obj->estatedat[0]["contract_tax"]);

		$parking_price = htmlspecialchars ($obj->estatedat[0]["parking_price"]);
		$parking_pricetax = htmlspecialchars ($obj->estatedat[0]["parking_pricetax"]);
		$parking_division = htmlspecialchars ($obj->estatedat[0]["parking_division"]);
		$parking_distance = htmlspecialchars ($obj->estatedat[0]["parking_distance"]);
		$parking_emptynum = htmlspecialchars ($obj->estatedat[0]["parking_emptynum"]);
		$parking_biko = htmlspecialchars ($obj->estatedat[0]["parking_biko"]);

		$delivery_vacant = htmlspecialchars ($obj->estatedat[0]["delivery_vacant"]);
		$delivery_flg = htmlspecialchars ($obj->estatedat[0]["delivery_flg"]);
		$delivery_date = htmlspecialchars ($obj->estatedat[0]["delivery_date"]);
		$delivery_season = htmlspecialchars ($obj->estatedat[0]["delivery_season"]);

		$surround_syougakkou = htmlspecialchars ($obj->estatedat[0]["surround_syougakkou"]);
		$surround_syoudistance = htmlspecialchars ($obj->estatedat[0]["surround_syoudistance"]);
		$surround_syoucd = htmlspecialchars ($obj->estatedat[0]["surround_syoucd"]);
		$surround_chuugakkou = htmlspecialchars ($obj->estatedat[0]["surround_chuugakkou"]);
		$surround_chuudistance = htmlspecialchars ($obj->estatedat[0]["surround_chuudistance"]);
		$surround_chuucd = htmlspecialchars ($obj->estatedat[0]["surround_chuucd"]);
		$surround_konbinidistance = htmlspecialchars ($obj->estatedat[0]["surround_konbinidistance"]);
		$surround_superdistance = htmlspecialchars ($obj->estatedat[0]["surround_superdistance"]);
		$surround_hospitaldistance = htmlspecialchars ($obj->estatedat[0]["surround_hospitaldistance"]);

		$tanto_name = htmlspecialchars ($obj->estatedat[0]["tanto_name"]);

		$trade_mode = htmlspecialchars ($obj->estatedat[0]["trade_mode"]);
		$trade_date = htmlspecialchars ($obj->estatedat[0]["trade_date"]);

		$kyakuzuke_flg = htmlspecialchars ($obj->estatedat[0]["kyakuzuke_flg"]);
		$kyakuzuke_date = htmlspecialchars ($obj->estatedat[0]["kyakuzuke_date"]);
		$kyakuzuke_price = htmlspecialchars ($obj->estatedat[0]["kyakuzuke_price"]);
		$kyakuzuke_bunpai = htmlspecialchars ($obj->estatedat[0]["kyakuzuke_bunpai"]);
		$kyakuzuke_futan = htmlspecialchars ($obj->estatedat[0]["kyakuzuke_futan"]);
		$kyakuzuke_message = htmlspecialchars ($obj->estatedat[0]["kyakuzuke_message"]);

		$motozuke_name = htmlspecialchars ($obj->estatedat[0]["motozuke_name"]);
		$motozuke_zip = htmlspecialchars ($obj->estatedat[0]["motozuke_zip"]);
		$motozuke_addcd = htmlspecialchars ($obj->estatedat[0]["motozuke_addcd"]);
		$motozuke_addname = htmlspecialchars ($obj->estatedat[0]["motozuke_addname"]);
		$motozuke_addopen = htmlspecialchars ($obj->estatedat[0]["motozuke_addopen"]);
		$motozuke_tell = htmlspecialchars ($obj->estatedat[0]["motozuke_tell"]);
		$motozuke_fax = htmlspecialchars ($obj->estatedat[0]["motozuke_fax"]);
		$motozuke_biko = htmlspecialchars ($obj->estatedat[0]["motozuke_biko"]);

		$owner_name = htmlspecialchars ($obj->estatedat[0]["owner_name"]);
		$owner_zip = htmlspecialchars ($obj->estatedat[0]["owner_zip"]);
		$owner_addcd = htmlspecialchars ($obj->estatedat[0]["owner_addcd"]);
		$owner_addname = htmlspecialchars ($obj->estatedat[0]["owner_addname"]);
		$owner_addopen = htmlspecialchars ($obj->estatedat[0]["owner_addopen"]);
		$owner_tell = htmlspecialchars ($obj->estatedat[0]["owner_tell"]);
		$owner_fax = htmlspecialchars ($obj->estatedat[0]["owner_fax"]);
		$owner_biko = htmlspecialchars ($obj->estatedat[0]["owner_biko"]);

		$openhouse_start = htmlspecialchars ($obj->estatedat[0]["openhouse_start"]);
		$openhouse_end = htmlspecialchars ($obj->estatedat[0]["openhouse_end"]);
		$openhouse_period = htmlspecialchars ($obj->estatedat[0]["openhouse_period"]);
		$openhouse_biko = htmlspecialchars ($obj->estatedat[0]["openhouse_biko"]);

		$img_org1 = htmlspecialchars ($obj->estatedat[0]["img_org1"]);
		$img_upddate1 = htmlspecialchars ($obj->estatedat[0]["img_upddate1"]);
		$img_type1 = htmlspecialchars ($obj->estatedat[0]["img_type1"]);
		$img_comment1 = htmlspecialchars ($obj->estatedat[0]["img_comment1"]);
		$img_org2 = htmlspecialchars ($obj->estatedat[0]["img_org2"]);
		$img_upddate2 = htmlspecialchars ($obj->estatedat[0]["img_upddate2"]);
		$img_type2 = htmlspecialchars ($obj->estatedat[0]["img_type2"]);
		$img_comment2 = htmlspecialchars ($obj->estatedat[0]["img_comment2"]);
		$img_org3 = htmlspecialchars ($obj->estatedat[0]["img_org3"]);
		$img_upddate3 = htmlspecialchars ($obj->estatedat[0]["img_upddate3"]);
		$img_type3 = htmlspecialchars ($obj->estatedat[0]["img_type3"]);
		$img_comment3 = htmlspecialchars ($obj->estatedat[0]["img_comment3"]);
		$img_org4 = htmlspecialchars ($obj->estatedat[0]["img_org4"]);
		$img_upddate4 = htmlspecialchars ($obj->estatedat[0]["img_upddate4"]);
		$img_type4 = htmlspecialchars ($obj->estatedat[0]["img_type4"]);
		$img_comment4 = htmlspecialchars ($obj->estatedat[0]["img_comment4"]);
		$img_org5 = htmlspecialchars ($obj->estatedat[0]["img_org5"]);
		$img_upddate5 = htmlspecialchars ($obj->estatedat[0]["img_upddate5"]);
		$img_type5 = htmlspecialchars ($obj->estatedat[0]["img_type5"]);
		$img_comment5 = htmlspecialchars ($obj->estatedat[0]["img_comment5"]);
		$img_org6 = htmlspecialchars ($obj->estatedat[0]["img_org6"]);
		$img_upddate6 = htmlspecialchars ($obj->estatedat[0]["img_upddate6"]);
		$img_type6 = htmlspecialchars ($obj->estatedat[0]["img_type6"]);
		$img_comment6 = htmlspecialchars ($obj->estatedat[0]["img_comment6"]);
		$img_org7 = htmlspecialchars ($obj->estatedat[0]["img_org7"]);
		$img_upddate7 = htmlspecialchars ($obj->estatedat[0]["img_upddate7"]);
		$img_type7 = htmlspecialchars ($obj->estatedat[0]["img_type7"]);
		$img_comment7 = htmlspecialchars ($obj->estatedat[0]["img_comment7"]);
		$img_org8 = htmlspecialchars ($obj->estatedat[0]["img_org8"]);
		$img_upddate8 = htmlspecialchars ($obj->estatedat[0]["img_upddate8"]);
		$img_type8 = htmlspecialchars ($obj->estatedat[0]["img_type8"]);
		$img_comment8 = htmlspecialchars ($obj->estatedat[0]["img_comment8"]);
		$img_org9 = htmlspecialchars ($obj->estatedat[0]["img_org9"]);
		$img_upddate9 = htmlspecialchars ($obj->estatedat[0]["img_upddate9"]);
		$img_type9 = htmlspecialchars ($obj->estatedat[0]["img_type9"]);
		$img_comment9 = htmlspecialchars ($obj->estatedat[0]["img_comment9"]);
		$img_org10 = htmlspecialchars ($obj->estatedat[0]["img_org10"]);
		$img_upddate10 = htmlspecialchars ($obj->estatedat[0]["img_upddate10"]);
		$img_type10 = htmlspecialchars ($obj->estatedat[0]["img_type10"]);
		$img_comment10 = htmlspecialchars ($obj->estatedat[0]["img_comment10"]);

		$estate_group = htmlspecialchars ($obj->estatedat[0]["estate_group"]);
		$estate_equip = htmlspecialchars ($obj->estatedat[0]["estate_equip"]);

		$estate_pointnum = htmlspecialchars ($obj->estatedat[0]["estate_pointnum"]);

		$estate_end = htmlspecialchars ($obj->estatedat[0]["estate_end"]);

		$estate_clid = htmlspecialchars ($obj->estatedat[0]["estate_clid"]);
		$estate_ido = htmlspecialchars ($obj->estatedat[0]["estate_ido"]);
		$estate_keido = htmlspecialchars ($obj->estatedat[0]["estate_keido"]);
		$estate_zoom = htmlspecialchars ($obj->estatedat[0]["estate_zoom"]);
		$estate_adminid = htmlspecialchars ($obj->estatedat[0]["estate_adminid"]);
		$estate_insdate = htmlspecialchars ($obj->estatedat[0]["estate_insdate"]);
		$estate_upddate = htmlspecialchars ($obj->estatedat[0]["estate_upddate"]);
		$estate_deldate = htmlspecialchars ($obj->estatedat[0]["estate_deldate"]);
		$estate_yobi1 = htmlspecialchars ($obj->estatedat[0]["estate_yobi1"]);
		$estate_yobi2 = htmlspecialchars ($obj->estatedat[0]["estate_yobi2"]);
		$estate_yobi3 = htmlspecialchars ($obj->estatedat[0]["estate_yobi3"]);
		$estate_yobi4 = htmlspecialchars ($obj->estatedat[0]["estate_yobi4"]);
		$estate_yobi5 = htmlspecialchars ($obj->estatedat[0]["estate_yobi5"]);

		$strViewDelForm = "";
		$strViewDelForm .= "<form action=\"build_upd.php\" method=\"POST\" name=\"del_form\">\n";
		$strViewDelForm .= "  <td align=\"center\" valign=\"top\">\n";
		$strViewDelForm .= "    <input type=\"button\" value=\"削除する\" onclick=\"return BuildDeleteCheck( this.form , this.form )\" class=\"btn_nosize\" style=\"width:150px;\" />\n";
		$strViewDelForm .= "    <input type=\"hidden\" name=\"mode\" value=\"DEL\" />\n";
		$strViewDelForm .= "    <input type=\"hidden\" name=\"estate_id\" value=\"{$estate_id}\" />\n";
		$strViewDelForm .= "    <input type=\"hidden\" name=\"estate_upd_date\" value=\"{$estate_upd_date}\" />\n";
		$strViewDelForm .= "    <input type=\"hidden\" name=\"estate_photo_lastupd\" value=\"{$estate_photo}\"/>\n";
		$strViewDelForm .= "    <input type=\"hidden\" name=\"search_flg\" value=\"{$_POST['search_flg']}\"/>\n";
		$strViewDelForm .= "    <input type=\"hidden\" name=\"search_estate_name\" value=\"{$_POST['search_estate_name']}\"/>\n";
		$strViewDelForm .= "    <input type=\"hidden\" name=\"search_address\" value=\"{$_POST['search_address']}\"/>\n";
		$strViewDelForm .= "  </td>\n";
		$strViewDelForm .= "</form>\n";
		
		$modeName = "修正";

	}else if($_POST['mode']=="NEW"){
		$modeName = "登録";
		$estate_map[3] = 10;
	}
}


// 物件種別
asort( $param_estate_type["disp_no"] );
$estate_type_value = "";
FOREACH( $param_estate_type["disp_no"] as $key => $val ){
	$strChk = "";
	if( $param_estate_type['id'][$key] == $estate_type )$strChk = " selected";
	$estate_type_value .= "<OPTION value=\"{$param_estate_type['id'][$key]}\"{$strChk}>{$param_estate_type['val'][$key]}</OPTION>\n";
}


// 建物名と部屋/区画NO.表示
asort( $param_estate_nameflg["disp_no"] );
$estate_nameflg_value = "";
FOREACH( $param_estate_nameflg["disp_no"] as $key => $val ){
	$strChk = "";
	if( $param_estate_nameflg['id'][$key] == $estate_nameflg )$strChk = " selected";
	$estate_nameflg_value .= "<OPTION value=\"{$param_estate_nameflg['id'][$key]}\"{$strChk}>{$param_estate_nameflg['val'][$key]}</OPTION>\n";
}


// 状態
$vacantchk1 = "";
$vacantchk3 = "";
$vacantchk4 = "";
$vacantchk9 = "";
if($estate_vacant == 1){
	$vacantchk1 = " checked";
}else if($estate_vacant == 3){
	$vacantchk3 = " checked";
}else if($estate_vacant == 4){
	$vacantchk4 = " checked";
}else if($estate_vacant == 9){
	$vacantchk5 = " checked";
}else{
	$vacantchk1 = " checked";
}

// 建物タイプ
asort( $param_estate_type["disp_no"] );
$estate_type_value = "";
FOREACH( $param_estate_type["disp_no"] as $key => $val ){
	$strChk = "";
	if( $param_estate_type['id'][$key] == $estate_type ) $strChk = " selected";
	$estate_type_value .= "<OPTION value=\"{$param_estate_type['id'][$key]}\"{$strChk}>{$param_estate_type['val'][$key]}</OPTION>\n";
}


// 家賃保障付フラグ判定
$price_hosyou_chk = "";
$equip = split("/",$estate_equip);
$equipcnt = count($equip);
for($i=1;$i<$equipcnt;$i++){
	if($equip[$i]=="11901")$price_hosyou_chk = " checked";
}


// 物件住所生成
$obj_zip = new mstdb_ZipcodeClassTblAccess;
$obj_zip->conn = $obj_conn->conn;
$obj_zip->jyoken["zip"] = $estate_zip;
list( $ret , $cnt ) = $obj_zip->mstdb_GetZipcode( 1 , -1 );
IF( $ret == "-1" ){
	$arrOther["ath_comment"] = "<INPUT TYPE=\"hidden\" NAME=\"stpos\" VALUE=\"{$_POST['stpos']}\">";
	$obj_error->ViewErrMessage( "SYSTEM" , "ALL" , SITE_PATH."blank.php" , $arrOther );
	exit;
}


// 公庫利用可フラグ判定
$price_kouko_chk = "";
$equip = split("/",$estate_equip);
$equipcnt = count($equip);
for($i=1;$i<$equipcnt;$i++){
	if($equip[$i]=="11101")$price_kouko_chk = " checked";
}


// エレベータ有フラグ判定
$price_elebater_chk = "";
$equip = split("/",$estate_equip);
$equipcnt = count($equip);
for($i=1;$i<$equipcnt;$i++){
	if($equip[$i]=="22401")$price_elebater_chk = " checked";
}


// 建物構造
asort( $param_build_structure["disp_no"] );
$build_structure_value = "";
FOREACH( $param_build_structure["disp_no"] as $key => $val ){
	$strChk = "";
	if( $param_build_structure['id'][$key] == $build_structure )$strChk = " selected";
	$build_structure_value .= "<OPTION value=\"{$param_build_structure['id'][$key]}\"{$strChk}>{$param_build_structure['val'][$key]}</OPTION>\n";	
}


// 建物計測方式
asort( $param_build_areamethod["disp_no"] );
$build_areamethod_value = "";
FOREACH( $param_build_areamethod["disp_no"] as $key => $val ){
	$strChk = "";
	if( $param_build_areamethod['id'][$key] == $build_areamethod )$strChk = " selected";
	$build_areamethod_value .= "<OPTION value=\"{$param_build_areamethod['id'][$key]}\"{$strChk}>{$param_build_areamethod['val'][$key]}</OPTION>\n";	
}


// 管理人
asort( $param_manager_stat["disp_no"] );
$manager_stat_value = "";
FOREACH( $param_manager_stat["disp_no"] as $key => $val ){
	$strChk = "";
	if( $param_manager_stat['id'][$key] == $manager_stat )$strChk = " selected";
	$manager_stat_value .= "<OPTION value=\"{$param_manager_stat['id'][$key]}\"{$strChk}>{$param_manager_stat['val'][$key]}</OPTION>\n";	
}


// 管理形態
asort( $param_manager_type["disp_no"] );
$manager_type_value = "";
FOREACH( $param_manager_type["disp_no"] as $key => $val ){
	$strChk = "";
	if( $param_manager_type['id'][$key] == $manager_type )$strChk = " checked";
	$manager_type_value .= "<input type=\"radio\" name=\"manager_type\" value=\"{$param_manager_type['id'][$key]}\"{$strChk}>{$param_manager_type['val'][$key]}　\n";	
}


// 管理組合
asort( $param_manager_flg["disp_no"] );
$manager_flg_value = "";
FOREACH( $param_manager_flg["disp_no"] as $key => $val ){
	$strChk = "";
	if( $param_manager_flg['id'][$key] == $manager_flg )$strChk = " checked";
	$manager_flg_value .= "<input type=\"radio\" name=\"manager_flg\" value=\"{$param_manager_flg['id'][$key]}\"{$strChk}>{$param_manager_flg['val'][$key]}　\n";	
}


// 間取部屋種類
asort( $param_madori_roomtype["disp_no"] );
$madori_roomtype_value = "";
FOREACH( $param_madori_roomtype["disp_no"] as $key => $val ){
	$strChk = "";
	if( $param_madori_roomtype['id'][$key] == $madori_roomtype )$strChk = " selected";
	$madori_roomtype_value .= "<OPTION value=\"{$param_madori_roomtype['id'][$key]}\"{$strChk}>{$param_madori_roomtype['val'][$key]}</OPTION>\n";	
}


// 所在階地上地下判定
$floor_chika_chk = "";
$floor_chijou_chk = "";
if($room_floor < 0){
	$floor_chika_chk = " checked";
}else{
	$floor_chijou_chk = " checked";
}
$room_floor = htmlspecialchars (ltrim($room_floor,"-"));


// 向き
asort( $param_room_azimuth["disp_no"] );
$room_azimuth_value = "";
FOREACH( $param_room_azimuth["disp_no"] as $key => $val ){
	$strChk = "";
	if( $param_room_azimuth['id'][$key] == $room_azimuth )$strChk = " selected";
	$room_azimuth_value .= "<OPTION value=\"{$param_room_azimuth['id'][$key]}\"{$strChk}>{$param_room_azimuth['val'][$key]}</OPTION>\n";	
}


// 間取(種類)１
asort( $param_madori_type["disp_no"] );
$madori_type1_value = "";
FOREACH( $param_madori_type["disp_no"] as $key => $val ){
	$strChk = "";
	if( $param_madori_type['id'][$key] == $madori_type1 )$strChk = " selected";
	$madori_type1_value .= "<OPTION value=\"{$param_madori_type['id'][$key]}\"{$strChk}>{$param_madori_type['val'][$key]}</OPTION>\n";	
}


// 間取(種類)２
asort( $param_madori_type["disp_no"] );
$madori_type2_value = "";
FOREACH( $param_madori_type["disp_no"] as $key => $val ){
	$strChk = "";
	if( $param_madori_type['id'][$key] == $madori_type2 )$strChk = " selected";
	$madori_type2_value .= "<OPTION value=\"{$param_madori_type['id'][$key]}\"{$strChk}>{$param_madori_type['val'][$key]}</OPTION>\n";	
}


// 間取(種類)３
asort( $param_madori_type["disp_no"] );
$madori_type3_value = "";
FOREACH( $param_madori_type["disp_no"] as $key => $val ){
	$strChk = "";
	if( $param_madori_type['id'][$key] == $madori_type3 )$strChk = " selected";
	$madori_type3_value .= "<OPTION value=\"{$param_madori_type['id'][$key]}\"{$strChk}>{$param_madori_type['val'][$key]}</OPTION>\n";	
}


// 間取(種類)４
asort( $param_madori_type["disp_no"] );
$madori_type4_value = "";
FOREACH( $param_madori_type["disp_no"] as $key => $val ){
	$strChk = "";
	if( $param_madori_type['id'][$key] == $madori_type4 )$strChk = " selected";
	$madori_type4_value .= "<OPTION value=\"{$param_madori_type['id'][$key]}\"{$strChk}>{$param_madori_type['val'][$key]}</OPTION>\n";	
}


// 間取(種類)５
asort( $param_madori_type["disp_no"] );
$madori_type5_value = "";
FOREACH( $param_madori_type["disp_no"] as $key => $val ){
	$strChk = "";
	if( $param_madori_type['id'][$key] == $madori_type5 )$strChk = " selected";
	$madori_type5_value .= "<OPTION value=\"{$param_madori_type['id'][$key]}\"{$strChk}>{$param_madori_type['val'][$key]}</OPTION>\n";	
}


// 間取(種類)６
asort( $param_madori_type["disp_no"] );
$madori_type6_value = "";
FOREACH( $param_madori_type["disp_no"] as $key => $val ){
	$strChk = "";
	if( $param_madori_type['id'][$key] == $madori_type6 )$strChk = " selected";
	$madori_type6_value .= "<OPTION value=\"{$param_madori_type['id'][$key]}\"{$strChk}>{$param_madori_type['val'][$key]}</OPTION>\n";	
}


// 間取(種類)７
asort( $param_madori_type["disp_no"] );
$madori_type7_value = "";
FOREACH( $param_madori_type["disp_no"] as $key => $val ){
	$strChk = "";
	if( $param_madori_type['id'][$key] == $madori_type7 )$strChk = " selected";
	$madori_type7_value .= "<OPTION value=\"{$param_madori_type['id'][$key]}\"{$strChk}>{$param_madori_type['val'][$key]}</OPTION>\n";	
}


// 間取(種類)８
asort( $param_madori_type["disp_no"] );
$madori_type8_value = "";
FOREACH( $param_madori_type["disp_no"] as $key => $val ){
	$strChk = "";
	if( $param_madori_type['id'][$key] == $madori_type8 )$strChk = " selected";
	$madori_type8_value .= "<OPTION value=\"{$param_madori_type['id'][$key]}\"{$strChk}>{$param_madori_type['val'][$key]}</OPTION>\n";	
}


// 間取(種類)９
asort( $param_madori_type["disp_no"] );
$madori_type9_value = "";
FOREACH( $param_madori_type["disp_no"] as $key => $val ){
	$strChk = "";
	if( $param_madori_type['id'][$key] == $madori_type9 )$strChk = " selected";
	$madori_type9_value .= "<OPTION value=\"{$param_madori_type['id'][$key]}\"{$strChk}>{$param_madori_type['val'][$key]}</OPTION>\n";	
}


// 間取(種類)１０
asort( $param_madori_type["disp_no"] );
$madori_type10_value = "";
FOREACH( $param_madori_type["disp_no"] as $key => $val ){
	$strChk = "";
	if( $param_madori_type['id'][$key] == $madori_type10 )$strChk = " selected";
	$madori_type10_value .= "<OPTION value=\"{$param_madori_type['id'][$key]}\"{$strChk}>{$param_madori_type['val'][$key]}</OPTION>\n";	
}


// 引渡/入居時期
asort( $param_delivery_flg["disp_no"] );
$delivery_flg_value = "";
FOREACH( $param_delivery_flg["disp_no"] as $key => $val ){
	$strChk = "";
	if( $param_delivery_flg['id'][$key] == $delivery_flg )$strChk = " selected";
	$delivery_flg_value .= "<OPTION value=\"{$param_delivery_flg['id'][$key]}\"{$strChk}>{$param_delivery_flg['val'][$key]}</OPTION>\n";	
}


// 満室賃貸中フラグ判定
$price_manshitsu_chk = "";
$equip = split("/",$estate_equip);
$equipcnt = count($equip);
for($i=1;$i<$equipcnt;$i++){
	if($equip[$i]=="12001")$price_manshitsu_chk = " checked";
}


// 現況
asort( $param_delivery_vacant["disp_no"] );
$delivery_vacant_value = "";
FOREACH( $param_delivery_vacant["disp_no"] as $key => $val ){
	$strChk = "";
	if( $param_delivery_vacant['id'][$key] == $delivery_vacant )$strChk = " selected";
	$delivery_vacant_value .= "<OPTION value=\"{$param_delivery_vacant['id'][$key]}\"{$strChk}>{$param_delivery_vacant['val'][$key]}</OPTION>\n";	
}


// 事務所使用
$price_jimusyo_slct = "";
$equip = split("/",$estate_equip);
$equipcnt = count($equip);
for($i=1;$i<$equipcnt;$i++){
	if($equip[$i]=="10101")$price_jimusyo_slct = " selected";
}


// ペット相談
$delivery_pet_slct = "";
$equip = split("/",$estate_equip);
$equipcnt = count($equip);
for($i=1;$i<$equipcnt;$i++){
	if($equip[$i]=="10901")$delivery_pet_slct = " selected";
}


// 水道
asort( $param_equip_suidou["disp_no"] );
$equip_suidou_value = "";
FOREACH( $param_equip_suidou["disp_no"] as $key => $val ){
	$equip_sudou_chk = "";
	$equip = split("/",$estate_equip);
	$equipcnt = count($equip);
	for($i=1;$i<$equipcnt;$i++){
		if($equip[$i]==$param_equip_suidou['id'][$key] && $param_equip_suidou['id'][$key] != "")$equip_sudou_chk = " checked";
	}
	if($param_equip_suidou['id'][$key] == "")$equip_sudou_chk = " checked";
	$equip_suidou_value .= "<input type=\"radio\" name=\"equip_suidou\" value=\"{$param_equip_suidou['id'][$key]}\" {$equip_sudou_chk}>{$param_equip_suidou['val'][$key]}　\n";	
}


// 水道
asort( $param_equip_gasu["disp_no"] );
$equip_gasu_value = "";
FOREACH( $param_equip_gasu["disp_no"] as $key => $val ){
	$equip_sudou_chk = "";
	$equip = split("/",$estate_equip);
	$equipcnt = count($equip);
	for($i=1;$i<$equipcnt;$i++){
		if($equip[$i]==$param_equip_gasu['id'][$key] && $param_equip_gasu['id'][$key] != "")$equip_sudou_chk = " checked";
	}
	if($param_equip_gasu['id'][$key] == "")$equip_sudou_chk = " checked";
	$equip_gasu_value .= "<input type=\"radio\" name=\"equip_gasu\" value=\"{$param_equip_gasu['id'][$key]}\" {$equip_sudou_chk}>{$param_equip_gasu['val'][$key]}　\n";	
}


// 管理形態
/*
asort( $param_manager_type["disp_no"] );
$manager_type_value = "";
$iX = 0;
FOREACH( $param_manager_type["disp_no"] as $key => $val ){
	$iX++;
	$checked = "";
	$jX = "";
	$check_id = "";
	for($jX==0;$jX<count($room_equip);$jX++){
		if($param_manager_type['id'][$key] == $room_equip[$jX])$checked = "checked";
	}
	$manager_type_value .= "<TD class=\"equip\"><INPUT TYPE=\"checkbox\" NAME=\"room_equip[{$iX}]\" VALUE=\"{$param_manager_type['id'][$key]}\" {$checked}>{$param_manager_type['val'][$key]}</TD>\n";	
	if( $iX % 4 == 0 )$manager_type_value .= "</TR><TR>";
}
*/


// ロゴ画像
if($estate_photo_org == "") $photo_flg = "no_img";
$estate_photo_dir = $param_estate_photo_path;
$estate_photo_arr["org"] = $estate_photo_org;
$estate_photo_arr["chk_in"] = "9";
$estate_photo_txt =  form_ImgDisp( "estate_photo" , $estate_photo_dir , $obj->estatedat[0]["estate_photo"] , "1" , $estate_photo_arr );


// 県
reset( $param_search_pref );
asort( $param_search_pref["disp_no"] );
$estate_pref_value = "";
FOREACH( $param_search_pref["disp_no"] as $key => $val ){
	$selected = "";
	IF( $param_search_pref['id'][$key] == $obj_zip->zipdat[0]["pref_cd"] ) $selected = " selected";
	$estate_pref_value .= "<OPTION value=\"{$param_search_pref['val2'][$key]}\"{$selected}>{$param_search_pref['val2'][$key]}</OPTION>\n";
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
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"
    xmlns:v="urn:schemas-microsoft-com:vml">
  <HEAD>
    <TITLE>不動産ブログ - アカウント管理ツール</TITLE>
    <script src="http://maps.google.com/maps?file=api&v=2&key=<?=$param_api_key?>"
        type="text/javascript" charset="utf-8"></script>
    <META http-equiv="Content-Type" content="text/html;charset=EUC-JP" />
    <META http-equiv="Content-Style-Type" content="text/css" />
    <META http-equiv="Content-Script-Type" content="text/javascript" />
    <LINK rel="stylesheet" type="text/css" href="../share/css/build.css" />
    <SCRIPT type="text/javascript" src="../share/js/build.js"></SCRIPT>
    <SCRIPT type="text/javascript" src="../share/js/input_check.js"></SCRIPT>
    <SCRIPT type="text/javascript" src="../share/js/tag.js"></SCRIPT>
    <SCRIPT type="text/javascript" src="../share/js/GoogleMap.js"></SCRIPT>
    <NOSCRIPT><META http-equiv="Refresh" content="1;URL=../jserror.html"></NOSCRIPT>
  </HEAD>
  <BODY onload="loadMap('1111000','<?=$estate_ido?>','<?=$estate_keido?>','<?=$estate_zoom?>','35.70972275209277','139.6527099609375','10','','','','<?=$param_marker_img?>','<?=$param_marker_shadow_img?>')">
    <div id="estate">
      <div id="title">　基本情報</div>
        <FORM name="build" method="POST" action="build_upd.php" target="_self" enctype="multipart/form-data">
      <table id="client" cellspacing="0">
        <tr>
          <th class="must">建物種別</th>
          <td>
            <SELECT name="estate_type">
              <OPTION value="">-- 選択 --</OPTION>
<?=$estate_type_value?>
            </SELECT>
          </td>
        </tr>
        <tr>
          <th class="must">建物名</th>
          <td>
            <input type="text" id="estate_name" name="estate_name" value="<?=$estate_name?>" onFocus='Text("estate_name", 1)' onBlur='Text("estate_name", 2)' style="width:250px;" />
          </td>
        </tr>
        <tr>
          <th class="must">建物名(カナ)</th>
          <td>
            <input type="text" id="estate_kana" name="estate_kana" value="<?=$estate_kana?>" onFocus='Text("estate_kana", 1)' onBlur='Text("estate_kana", 2)' style="width:250px;" />
          </td>
        </tr>
        <tr>
          <th class="must">部屋/区画Ｎｏ.</th>
          <td>
            <input type="text" id="estate_emptytext" name="estate_emptytext" value="<?=$estate_emptytext?>" onFocus='Text("estate_emptytext", 1)' onBlur='Text("estate_emptytext", 2)' style="width:250px;" />
          </td>
        </tr>
        <tr>
          <th class="must">建物名と部屋/区画NO.表示</th>
          <td>
            <SELECT name="estate_nameflg">
              <OPTION value="">-- 選択 --</OPTION>
<?=$estate_nameflg_value?>
            </SELECT>
          </td>
        </tr>
        <tr>
          <th class="must">状態</th>
          <td>
            <input type="radio" id="estate_vacant1"name="estate_vacant" value="1" onFocus='Text("estate_vacant1", 1)' onBlur='Text("estate_vacant1", 2)' <?=$vacantchk1?> />空有/売出中
            　<input type="radio" id="estate_vacant3"name="estate_vacant" value="3" onFocus='Text("estate_vacant3", 1)' onBlur='Text("estate_vacant3", 2)' <?=$vacantchk3?> />空無/売止
            　<input type="radio" id="estate_vacant4"name="estate_vacant" value="4" onFocus='Text("estate_vacant4", 1)' onBlur='Text("estate_vacant4", 2)' <?=$vacantchk4?> />成約
            　<input type="radio" id="estate_vacant9"name="estate_vacant" value="9" onFocus='Text("estate_vacant9", 1)' onBlur='Text("estate_vacant9", 2)' <?=$vacantchk9?> />削除
          </td>
        </tr>
        <tr>
          <th class="must">利回り</th>
          <td>
            満室時<input type="text" id="price_fullyield" name="price_fullyield" value="<?=$price_fullyield?>" onFocus='Text("price_fullyield", 1)' onBlur='Text("price_fullyield", 2)' style="width:50　px;" />％
            　現行<input type="text" id="price_nowyield" name="price_nowyield" value="<?=$price_nowyield?>" onFocus='Text("price_nowyield", 1)' onBlur='Text("price_nowyield", 2)' style="width:50　px;" />％
            　<input type="checkbox" id="price_hosyou" name="price_hosyou" value="11901" onFocus='Text("price_hosyou", 1)' onBlur='Text("price_hosyou", 2)' <?=$price_hosyou_chk?>/>家賃保障付
          </td>
        </tr>
        <tr>
          <th class="must">物件担当者</th>
          <td>
            <SELECT name="tanto_name">
              <OPTION value="">-- 選択 --</OPTION>
<?=$tanto_name_value?>
            </SELECT>
          </td>
        </tr>
      </table>
      <br />
      <div id="title">　所在地</div>
      <br>
      <table id="client" cellspacing="0">
        <tr>
          <th class="must">建物住所<BR>(※番地以下省略可)</th>
          <td>
            <table><tr>
            <td>
              <input type="text" id="address_word" name="address_word" value=""><input type="button" value="検索" onclick="sendDataAdd(this.form)"><br>
              <div id="hello">
              <select name="address_list" id="address_list" size="10" style="width:200px">
                <option value=""> </option>
              </select>
              </div>
            </td>
            <td valign="middle">
              <input type="button" value="→" onclick="sendDataAdd2(this.form)">
            </td>
            <td>
              <div id="hello2">
	      <table class="zip"><tr>
	      <td class="zip" align="right" width="100px">〒</td><td class="zip"><input id="i4" type="text" name="estate_zip1" value="<?=$estate_zip1?>" style="width:40px" maxlength="3" onFocus='Text("i4", 1)' onBlur='Text("i4", 2)' />
	      -<input id="i5" type="text" name="estate_zip2" value="<?=$estate_zip2?>" style="width:50px" maxlength="4" onFocus='Text("i5", 1)' onBlur='Text("i5", 2)' />
	      <input type="button" value="住所取得" onclick="return zipSearch()">
              <font color="#ff0000">（半角数字で入力）</font>
              </td>
	      </tr><tr>
              <td class="zip" align="right" width="100px">都道府県</td>
              <td class="zip">
                <select name="estate_pref">
<?=$estate_pref_value?>
                </select>
              <td>
	      </tr><tr>
              <td class="zip" align="right" width="100px">市区郡</td><td class="zip"><input type="text" name="estate_address1" value="<?=$obj_zip->zipdat[0]["address1"]?>" maxlength="80" style="width:200px" readonly /></td>
	      </tr><tr>
              <td class="zip" align="right" width="100px">町村</td><td class="zip"><input type="text" name="estate_address2" value="<?=$obj_zip->zipdat[0]["address2"]?>" maxlength="80" style="width:200px" readonly /><td>
	      </tr><tr>
              <td class="zip" align="right" width="100px">丁目</td><td class="zip"><input type="text" name="estate_addname" value="<?=$estate_addname?>" maxlength="80" style="width:200px" /><td>
	      </tr><tr>
              <td class="zip" align="right" width="100px">番地(表示)</td><td class="zip"><input type="text" name="estate_addopen" value="<?=$estate_addopen?>" maxlength="80" style="width:200px" /><td>
	      </tr><tr>
              <td class="zip" align="right" width="100px">番地(非表示)</td><td class="zip"><input type="text" name="estate_addclose" value="<?=$estate_addclose?>" maxlength="80" style="width:200px" /><td>
	      </tr>
	      </table>
	      <input type="hidden" name="estate_addcd1" value="<?=$estate_addcd1?>">
	      <input type="hidden" name="estate_addcd2" value="<?=$estate_addcd2?>">
            </td>
            </tr></table>
            </div>
          <td>
        </tr>
        <tr>
          <th class="must">地図情報</th>
          <TD>
<input type="text" value="" id="zip" size="40" onFocus='Text("zip", 1)' onBlur='Text("zip", 2)'/>
<input type="button" value="住所検索" onClick="showAddress()" />
<input type="hidden" id="zm4" name="zoom3" value="12"/>
  <input type="hidden" id="mapX" name="estate_keido" value="<?=$estate_keido?>"/>
  <input type="hidden" id="mapY" name="estate_ido" value="<?=$estate_ido?>"/>
  <input type="hidden" id="zoomN" name="estate_zoom" value="<?=$estate_zoom?>"/><BR>
  <input type="hidden" id="marker_flg" name="mkr_flg" value=""/><BR>
<div id="gmap" style="width: 620px; height: 300px"></div>
<div id="mapOpt"></div>
<input type="button" name="onMarker" value="マーカー" onClick="marker('<?=$param_marker_img?>','<?=$param_marker_shadow_img?>')" /><input type="button" value="ランドマーク登録" onclick="document.randmark.submit();return false;"><br />
          </TD>
        </tr>
      </table>
      <br />
      <div id="title">　交通</div>
      <br>
      <table id="client" cellspacing="0">
        <tr>
          <th class="must">最寄駅1</th>
          <td>
            <INPUT type="button" name="line_setting1" value="沿線・駅設定" onClick="OpenPageSta('estate_line1','estate_station1','estate_line_cd_1','estate_sta_cd_1','estate_line_cd_name_1');" />
            <INPUT TYPE="text" name="estate_line1" VALUE="<?=$estate_line1?>" readonly>線
            <INPUT TYPE="text" name="estate_station1" VALUE="<?=$estate_station1?>" readonly>駅から
            バス<INPUT type="text" id="bus" name="estate_bus1" value="<?=$estate_bus1?>" onFocus='Text("bus", 1)' onBlur='Text("bus", 2)' style="width:30px"/>分　
            徒歩<INPUT type="text" id="i7" name="estate_walk1" value="<?=$estate_walk1?>" onFocus='Text("i7", 1)' onBlur='Text("i7", 2)' style="width:30px"/>分
            <br />
            <font color="#ff0000">（徒歩○○分・バス○○分は半角数字のみで入力）</font>
            <input type="hidden" name="estate_line_cd_1" value="<?=$estate_line_cd_1?>" />
            <input type="hidden" name="estate_line_cd_name_1" value="<?=$estate_line_cd_name_1?>" />
            <input type="hidden" name="estate_sta_cd_1" value="<?=$estate_sta_cd_1?>" />
          </td>
        </tr>
        <tr>
          <th>最寄駅2</th>
          <td>
            <INPUT type="button" name="line_setting2" value="沿線・駅設定" onClick="OpenPageSta('estate_line2','estate_station2','estate_line_cd_2','estate_sta_cd_2','estate_line_cd_name_2');" />
            <INPUT TYPE="text" name="estate_line2" VALUE="<?=$estate_line2?>" readonly>線
            <INPUT TYPE="text" name="estate_station2" VALUE="<?=$estate_station2?>" readonly>駅から
            バス<INPUT type="text" id="i13" name="estate_bus2" value="<?=$estate_bus2?>" onFocus='Text("i13", 1)' onBlur='Text("i13", 2)' style="width:30px"/>分　
            徒歩<INPUT type="text" id="i8" name="estate_walk2" value="<?=$estate_walk2?>" onFocus='Text("i8", 1)' onBlur='Text("i8", 2)' style="width:30px"/>分
            <br />
            <font color="#ff0000">（徒歩○○分・バス○○分は半角数字のみで入力）</font>
            <input type="hidden" name="estate_line_cd_2" value="<?=$estate_line_cd_2?>" />
            <input type="hidden" name="estate_line_cd_name_2" value="<?=$estate_line_cd_name_2?>" />
            <input type="hidden" name="estate_sta_cd_2" value="<?=$estate_sta_cd_2?>" />
          </td>
        </tr>
      </table>
      <br />
      <div id="title">　金額</div>
      <br>
      <table id="client" cellspacing="0">
        <tr>
          <th class="must">価格</th>
          <td>
            <input type="text" id="price_main" name="price_main" value="<?=$price_main?>" onFocus='Text("price_main", 1)' onBlur='Text("price_main", 2)' style="width:100px;" />万円
            <SELECT name="price_taxflg">
              <OPTION value="2">税込</OPTION>
              <OPTION value="3">税無</OPTION>
            </SELECT>
            　<input type="checkbox" id="price_kouko" name="price_kouko" value="11101" onFocus='Text("price_kouko", 1)' onBlur='Text("price_kouko", 2)' <?=$price_kouko_chk?>/>公庫利用可
          </td>
        </tr>
        <tr>
          <th class="must">共益/管理費</th>
          <td>
            <input type="text" id="price_cntrlprice" name="price_cntrlprice" value="<?=$price_cntrlprice?>" onFocus='Text("price_cntrlprice", 1)' onBlur='Text("price_cntrlprice", 2)' style="width:100px;" />円
            <SELECT name="price_cntrlpriceflg">
              <OPTION value="2">税込</OPTION>
              <OPTION value="3">税無</OPTION>
            </SELECT>
          </td>
        </tr>
        <tr>
          <th class="must">修繕積立金</th>
          <td>
            <input type="text" id="price_mendingprice" name="price_mendingprice" value="<?=$price_mendingprice?>" onFocus='Text("price_mendingprice", 1)' onBlur='Text("price_mendingprice", 2)' style="width:100px;" />円
          </td>
        </tr>
        <tr>
          <th class="must">修繕積立基金</th>
          <td>
            <input type="text" id="price_mendingfund" name="price_mendingfund" value="<?=$price_mendingfund?>" onFocus='Text("price_mendingfund", 1)' onBlur='Text("price_mendingfund", 2)' style="width:100px;" />万円
          </td>
        </tr>
        <tr>
          <th class="must">敷金</th>
          <td>
            <input type="text" id="price_siki" name="price_siki" value="<?=$price_siki?>" onFocus='Text("price_siki", 1)' onBlur='Text("price_siki", 2)' style="width:100px;" />
            <SELECT name="price_secpriceunit">
              <OPTION value="2">ヶ月</OPTION>
              <OPTION value="3">円</OPTION>
            </SELECT>
          </td>
        </tr>
        <tr>
          <th class="must">保証金</th>
          <td>
            <input type="text" id="price_secprice" name="price_secprice" value="<?=$price_secprice?>" onFocus='Text("price_secprice", 1)' onBlur='Text("price_secprice", 2)' style="width:100px;" />
            <SELECT name="price_cntrlpriceflg">
              <OPTION value="2">ヶ月</OPTION>
              <OPTION value="3">円</OPTION>
            </SELECT>
          </td>
        </tr>
        <tr>
          <th class="must">仲介手数料</th>
          <td>
            <input type="text" id="kyakuzuke_price" name="kyakuzuke_price" value="<?=$kyakuzuke_price?>" onFocus='Text("kyakuzuke_price", 1)' onBlur='Text("kyakuzuke_price", 2)' style="width:100px;" />
            <SELECT name="kyakuzuke_priceunit">
              <OPTION value="1">％</OPTION>
              <OPTION value="2">円</OPTION>
              <OPTION value="3">３％＋６万円</OPTION>
            </SELECT>
          </td>
        </tr>
        <tr>
          <th class="must">その他費用１</th>
          <td>
            <input type="text" id="price_otherprice1" name="price_otherprice1" value="<?=$price_otherprice1?>" onFocus='Text("price_otherprice1", 1)' onBlur='Text("price_otherprice1", 2)' style="width:100px;" />円　名目
            <input type="text" id="price_otherpricetitle1" name="price_otherpricetitle1" value="<?=$price_otherpricetitle1?>" onFocus='Text("price_otherpricetitle1", 1)' onBlur='Text("price_otherpricetitle1", 2)' style="width:200px;" />
          </td>
        </tr>
        <tr>
          <th class="must">その他費用２</th>
          <td>
            <input type="text" id="price_otherprice2" name="price_otherprice2" value="<?=$price_otherprice2?>" onFocus='Text("price_otherprice2", 1)' onBlur='Text("price_otherprice2", 2)' style="width:100px;" />円　名目
            <input type="text" id="price_otherpricetitle2" name="price_otherpricetitle2" value="<?=$price_otherpricetitle2?>" onFocus='Text("price_otherpricetitle2", 1)' onBlur='Text("price_otherpricetitle2", 2)' style="width:200px;" />
          </td>
        </tr>
        <tr>
          <th class="must">その他費用３</th>
          <td>
            <input type="text" id="price_otherprice3" name="price_otherprice3" value="<?=$price_otherprice3?>" onFocus='Text("price_otherprice3", 1)' onBlur='Text("price_otherprice3", 2)' style="width:100px;" />円　名目
            <input type="text" id="price_otherpricetitle3" name="price_otherpricetitle3" value="<?=$price_otherpricetitle3?>" onFocus='Text("price_otherpricetitle3", 1)' onBlur='Text("price_otherpricetitle3", 2)' style="width:200px;" />
          </td>
        </tr>
      </table>
      <br />
      <div id="title">　建物</div>
      <br>
      <table id="client" cellspacing="0">
        <tr>
          <th class="must">建物階建</th>
          <td>
            地上<input type="text" id="build_floor" name="build_floor" value="<?=$build_floor?>" onFocus='Text("build_floor", 1)' onBlur='Text("build_floor", 2)' style="width:100px;" />階
            　地下<input type="text" id="build_basement" name="build_basement" value="<?=$build_basement?>" onFocus='Text("build_basement", 1)' onBlur='Text("build_basement", 2)' style="width:100px;" />階
            　<input type="checkbox" id="price_elebater" name="price_elebater" value="22401" onFocus='Text("price_elebater", 1)' onBlur='Text("price_elebater", 2)' <?=$price_elebater_chk?>/>エレベーター有
          </td>
        </tr>
        <tr>
          <th class="must">総戸数</th>
          <td>
            空き戸数<input type="text" id="estate_division" name="estate_division" value="<?=$estate_division?>" onFocus='Text("estate_division", 1)' onBlur='Text("estate_division", 2)' style="width:100px;" />
            ／ 総戸数<input type="text" id="estate_empty" name="estate_empty" value="<?=$estate_empty?>" onFocus='Text("estate_empty", 1)' onBlur='Text("estate_empty", 2)' style="width:100px;" />
          </td>
        </tr>
        <tr>
          <th class="must">築年月</th>
          <td>
            西暦<input type="text" id="build_age_year" name="build_age_year" value="<?=$build_age_year?>" style="width:40px;" onFocus='Text("build_age_year", 1)' onBlur='Text("build_age_year", 2)' />
            年
            <input type="text" id="build_age_month" name="build_age_month" value="<?=$build_age_month?>" style="width:20px;" onFocus='Text("build_age_month", 1)' onBlur='Text("build_age_month", 2)' />
            月
            <FONT color="#FF0000">(半角数字のみで入力　例：2006年3月)</FONT>
          </td>
        </tr>
        <tr>
          <th class="must">建物構造</th>
          <td>
            <SELECT name="build_structure">
              <OPTION value="">-- 選択 --</OPTION>
<?=$build_structure_value?>
            </SELECT>
          </td>
        </tr>
        <tr>
          <th class="must">専有面積</th>
          <td>
            <input type="text" id="build_area" name="build_area" value="<?=$build_area?>" onFocus='Text("build_area", 1)' onBlur='Text("build_area", 2)' style="width:100px;" />ｍ<sup>2</sup>
            <SELECT name="build_areamethod">
              <OPTION value="">---</OPTION>
<?=$build_areamethod_value?>
            </SELECT>
          </td>
        </tr>
        <tr>
          <th class="must">建築面積</th>
          <td>
            <input type="text" id="build_kenchikuarea" name="build_kenchikuarea" value="<?=$build_kenchikuarea?>" onFocus='Text("build_kenchikuarea", 1)' onBlur='Text("build_kenchikuarea", 2)' style="width:100px;" />ｍ<sup>2</sup>
          </td>
        </tr>
        <tr>
          <th class="must">敷地全体面積</th>
          <td>
            <input type="text" id="build_shikichiarea" name="build_shikichiarea" value="<?=$build_shikichiarea?>" onFocus='Text("build_shikichiarea", 1)' onBlur='Text("build_shikichiarea", 2)' style="width:100px;" />ｍ<sup>2</sup>
          </td>
        </tr>
      </table>
      <br />
      <div id="title">　管理</div>
      <br>
      <table id="client" cellspacing="0">
        <tr>
          <th class="must">管理人</th>
          <td>
            <SELECT name="manager_stat">
              <OPTION value="">---</OPTION>
<?=$manager_stat_value?>
            </SELECT>
          </td>
        </tr>
        <tr>
          <th class="must">管理会社名</th>
          <td><input id="manager_comname" type="text" name="manager_comname" value="<?=$manager_comname?>" style="width:250px;" maxlength="15" onFocus='Text("manager_comname", 1)' onBlur='Text("manager_comname", 2)' /></td>
        </tr>
        <tr>
          <th class="must">管理形態</th>
          <td>
<?=$manager_type_value?>
          </td>
        </tr>
        <tr>
          <th class="must">管理組合</th>
          <td>
<?=$manager_flg_value?>
          </td>
        </tr>
      </table>
      <br />
      <div id="title">　部屋</div>
      <br>
      <table id="client" cellspacing="0">
        <tr>
          <th class="must">間取り</th>
          <td>
            <input type="text" id="madori_roomnum" name="madori_roomnum" value="<?=$madori_roomnum?>" onFocus='Text("madori_roomnum", 1)' onBlur='Text("madori_roomnum", 2)' style="width:100px;" />
            <SELECT name="madori_roomtype">
<?=$madori_roomtype_value?>
            </SELECT>
          </td>
        </tr>
        <tr>
          <th class="must">所在階</th>
          <td>
            <input type="radio" id="room_floorflg1" name="room_floorflg" value="1" onFocus='Text("room_floorflg1", 1)' onBlur='Text("room_floorflg1", 2)' <?=$floor_chijou_chk?> />地上
            　<input type="radio" id="room_floorflg2" name="room_floorflg" value="2" onFocus='Text("room_floorflg2", 1)' onBlur='Text("room_floorflg2", 2)' <?=$floor_chika_chk?> />地下
            　階数<input type="text" id="room_floor" name="room_floor" value="<?=$room_floor?>" onFocus='Text("room_floor", 1)' onBlur='Text("room_floor", 2)' />階
          </td>
        </tr>
        <tr>
          <th class="must">主要採光面</th>
          <td>
            <SELECT name="room_azimuth">
              <OPTION value="">---</OPTION>
<?=$room_azimuth_value?>
            </SELECT>
          </td>
        </tr>
        <tr>
          <th class="must">バルコニー面積</th>
          <td>
            <input type="text" id="room_balconyarea" name="room_balconyarea" value="<?=$room_balconyarea?>" onFocus='Text("room_balconyarea", 1)' onBlur='Text("room_balconyarea", 2)' style="width:100px;" />ｍ<sup>2</sup>
          </td>
        </tr>
        <tr>
          <th class="must">部屋１</th>
          <td>
            <SELECT name="madori_type1">
              <OPTION value="">---</OPTION>
<?=$madori_type1_value?>
            </SELECT>
            <input type="text" id="madori_jyounum1" name="madori_jyounum1" value="<?=$madori_jyounum1?>" onFocus='Text("madori_jyounum1", 1)' onBlur='Text("madori_jyounum1", 2)' style="width:100px;" />畳
            <input type="text" id="madori_floor1" name="madori_floor1" value="<?=$madori_floor1?>" onFocus='Text("madori_floor1", 1)' onBlur='Text("madori_floor1", 2)' style="width:100px;" />階
            <input type="text" id="madori_num1" name="madori_num1" value="<?=$madori_num1?>" onFocus='Text("madori_num1", 1)' onBlur='Text("madori_num1", 2)' style="width:100px;" />室
          </td>
        </tr>
        <tr>
          <th class="must">部屋２</th>
          <td>
            <SELECT name="madori_type2">
              <OPTION value="">---</OPTION>
<?=$madori_type2_value?>
            </SELECT>
            <input type="text" id="madori_jyounum2" name="madori_jyounum2" value="<?=$madori_jyounum2?>" onFocus='Text("madori_jyounum2", 1)' onBlur='Text("madori_jyounum2", 2)' style="width:100px;" />畳
            <input type="text" id="madori_floor2" name="madori_floor2" value="<?=$madori_floor2?>" onFocus='Text("madori_floor2", 1)' onBlur='Text("madori_floor2", 2)' style="width:100px;" />階
            <input type="text" id="madori_num2" name="madori_num2" value="<?=$madori_num2?>" onFocus='Text("madori_num2", 1)' onBlur='Text("madori_num2", 2)' style="width:100px;" />室
          </td>
        </tr>
        <tr>
          <th class="must">部屋３</th>
          <td>
            <SELECT name="madori_type3">
              <OPTION value="">---</OPTION>
<?=$madori_type3_value?>
            </SELECT>
            <input type="text" id="madori_jyounum3" name="madori_jyounum3" value="<?=$madori_jyounum3?>" onFocus='Text("madori_jyounum3", 1)' onBlur='Text("madori_jyounum3", 2)' style="width:100px;" />畳
            <input type="text" id="madori_floor3" name="madori_floor3" value="<?=$madori_floor3?>" onFocus='Text("madori_floor3", 1)' onBlur='Text("madori_floor3", 2)' style="width:100px;" />階
            <input type="text" id="madori_num3" name="madori_num3" value="<?=$madori_num3?>" onFocus='Text("madori_num3", 1)' onBlur='Text("madori_num3", 2)' style="width:100px;" />室
          </td>
        </tr>
        <tr>
          <th class="must">部屋４</th>
          <td>
            <SELECT name="madori_type4">
              <OPTION value="">---</OPTION>
<?=$madori_type4_value?>
            </SELECT>
            <input type="text" id="madori_jyounum4" name="madori_jyounum4" value="<?=$madori_jyounum4?>" onFocus='Text("madori_jyounum4", 1)' onBlur='Text("madori_jyounum4", 2)' style="width:100px;" />畳
            <input type="text" id="madori_floor4" name="madori_floor4" value="<?=$madori_floor4?>" onFocus='Text("madori_floor4", 1)' onBlur='Text("madori_floor4", 2)' style="width:100px;" />階
            <input type="text" id="madori_num4" name="madori_num4" value="<?=$madori_num4?>" onFocus='Text("madori_num4", 1)' onBlur='Text("madori_num4", 2)' style="width:100px;" />室
          </td>
        </tr>
        <tr>
          <th class="must">部屋５</th>
          <td>
            <SELECT name="madori_type5">
              <OPTION value="">---</OPTION>
<?=$madori_type5_value?>
            </SELECT>
            <input type="text" id="madori_jyounum5" name="madori_jyounum5" value="<?=$madori_jyounum5?>" onFocus='Text("madori_jyounum5", 1)' onBlur='Text("madori_jyounum5", 2)' style="width:100px;" />畳
            <input type="text" id="madori_floor5" name="madori_floor5" value="<?=$madori_floor5?>" onFocus='Text("madori_floor5", 1)' onBlur='Text("madori_floor5", 2)' style="width:100px;" />階
            <input type="text" id="madori_num5" name="madori_num5" value="<?=$madori_num5?>" onFocus='Text("madori_num5", 1)' onBlur='Text("madori_num5", 2)' style="width:100px;" />室
          </td>
        </tr>
        <tr>
          <th class="must">部屋６</th>
          <td>
            <SELECT name="madori_type6">
              <OPTION value="">---</OPTION>
<?=$madori_type6_value?>
            </SELECT>
            <input type="text" id="madori_jyounum6" name="madori_jyounum6" value="<?=$madori_jyounum6?>" onFocus='Text("madori_jyounum6", 1)' onBlur='Text("madori_jyounum6", 2)' style="width:100px;" />畳
            <input type="text" id="madori_floor6" name="madori_floor6" value="<?=$madori_floor6?>" onFocus='Text("madori_floor6", 1)' onBlur='Text("madori_floor6", 2)' style="width:100px;" />階
            <input type="text" id="madori_num6" name="madori_num6" value="<?=$madori_num6?>" onFocus='Text("madori_num6", 1)' onBlur='Text("madori_num6", 2)' style="width:100px;" />室
          </td>
        </tr>
        <tr>
          <th class="must">部屋７</th>
          <td>
            <SELECT name="madori_type7">
              <OPTION value="">---</OPTION>
<?=$madori_type7_value?>
            </SELECT>
            <input type="text" id="madori_jyounum7" name="madori_jyounum7" value="<?=$madori_jyounum7?>" onFocus='Text("madori_jyounum7", 1)' onBlur='Text("madori_jyounum7", 2)' style="width:100px;" />畳
            <input type="text" id="madori_floor7" name="madori_floor7" value="<?=$madori_floor7?>" onFocus='Text("madori_floor7", 1)' onBlur='Text("madori_floor7", 2)' style="width:100px;" />階
            <input type="text" id="madori_num7" name="madori_num7" value="<?=$madori_num7?>" onFocus='Text("madori_num7", 1)' onBlur='Text("madori_num7", 2)' style="width:100px;" />室
          </td>
        </tr>
        <tr>
          <th class="must">部屋８</th>
          <td>
            <SELECT name="madori_type8">
              <OPTION value="">---</OPTION>
<?=$madori_type8_value?>
            </SELECT>
            <input type="text" id="madori_jyounum8" name="madori_jyounum8" value="<?=$madori_jyounum8?>" onFocus='Text("madori_jyounum8", 1)' onBlur='Text("madori_jyounum8", 2)' style="width:100px;" />畳
            <input type="text" id="madori_floor8" name="madori_floor8" value="<?=$madori_floor8?>" onFocus='Text("madori_floor8", 1)' onBlur='Text("madori_floor8", 2)' style="width:100px;" />階
            <input type="text" id="madori_num8" name="madori_num8" value="<?=$madori_num8?>" onFocus='Text("madori_num8", 1)' onBlur='Text("madori_num8", 2)' style="width:100px;" />室
          </td>
        </tr>
        <tr>
          <th class="must">部屋９</th>
          <td>
            <SELECT name="madori_type9">
              <OPTION value="">---</OPTION>
<?=$madori_type9_value?>
            </SELECT>
            <input type="text" id="madori_jyounum9" name="madori_jyounum9" value="<?=$madori_jyounum9?>" onFocus='Text("madori_jyounum9", 1)' onBlur='Text("madori_jyounum9", 2)' style="width:100px;" />畳
            <input type="text" id="madori_floor9" name="madori_floor9" value="<?=$madori_floor9?>" onFocus='Text("madori_floor9", 1)' onBlur='Text("madori_floor9", 2)' style="width:100px;" />階
            <input type="text" id="madori_num9" name="madori_num9" value="<?=$madori_num9?>" onFocus='Text("madori_num9", 1)' onBlur='Text("madori_num9", 2)' style="width:100px;" />室
          </td>
        </tr>
        <tr>
          <th class="must">部屋１０</th>
          <td>
            <SELECT name="madori_type10">
<?=$madori_type10_value?>
            </SELECT>
            <input type="text" id="madori_jyounum10" name="madori_jyounum10" value="<?=$madori_jyounum10?>" onFocus='Text("madori_jyounum10", 1)' onBlur='Text("madori_jyounum10", 2)' style="width:100px;" />畳
            <input type="text" id="madori_floor10" name="madori_floor10" value="<?=$madori_floor10?>" onFocus='Text("madori_floor10", 1)' onBlur='Text("madori_floor10", 2)' style="width:100px;" />階
            <input type="text" id="madori_num10" name="madori_num10" value="<?=$madori_num10?>" onFocus='Text("madori_num10", 1)' onBlur='Text("madori_num10", 2)' style="width:100px;" />室
          </td>
        </tr>
        <tr>
          <th class="must">間取り備考</th>
          <td>
            <input type="text" id="madori_biko" name="madori_biko" value="<?=$madori_biko?>" onFocus='Text("madori_biko", 1)' onBlur='Text("madori_biko", 2)' style="width:250px;" />
	  </td>
        </tr>
      </table>
      <br />
      <div id="title">　契約条件</div>
      <br>
      <table id="client" cellspacing="0">
        <tr>
          <th class="must">入居/引渡時期</th>
          <td>
            <SELECT name="delivery_flg">
<?=$delivery_flg_value?>
            </SELECT>
          </td>
        </tr>
        <tr>
          <th class="must">現況</th>
          <td>
            <SELECT name="delivery_vacant">
              <OPTION value="">---</OPTION>
<?=$delivery_vacant_value?>
            </SELECT>
            <input type="checkbox" id="price_manshitsu" name="price_manshitsu" value="12001" onFocus='Text("price_manshitsu", 1)' onBlur='Text("price_manshitsu", 2)' <?=$price_manshitsu_chk?>/>満室賃貸中
          </td>
        </tr>
      </table>
      <br />
      <div id="title">　その他条件</div>
      <br>
      <table id="client" cellspacing="0">
        <tr>
          <th class="must">事務所使用</th>
          <td>
            <SELECT name="delivery_jimusyo">
              <OPTION value="">不可</OPTION>
              <OPTION value="10101" <?=$price_jimusyo_slct?>>可</OPTION>
            </SELECT>
          </td>
        </tr>
        <tr>
          <th class="must">手付金保障</th>
          <td>
            <SELECT name="delivery_flg3">
              <OPTION value="">---</OPTION>
<?=$delivery_flg3_value?>
              <OPTION value="1">有</OPTION>
            </SELECT>
          </td>
        </tr>
        <tr>
          <th class="must">ペット</th>
          <td>
            <SELECT name="delivery_pet">
              <OPTION value="">不可</OPTION>
              <OPTION value="10901" <?=$delivery_pet_slct?>>相談</OPTION>
            </SELECT>
          </td>
        </tr>
      </table>
      <br />
      <div id="title">　設備</div>
      <br>
      <table id="client" cellspacing="0">
        <tr>
          <th class="must">水道</th>
          <td>
<?=$equip_suidou_value?>
          </td>
        </tr>
        <tr>
          <th class="must">ガス</th>
          <td>
<?=$equip_gasu_value?>
          </td>
        </tr>
        <tr>
          <th class="must">排水</th>
          <td>
            <input type="radio" id="haisui1" name="haisui" value="" onFocus='Text("haisui1", 1)' onBlur='Text("haisui1", 2)' <?=$haisuichk1?> />指定なし
            　<input type="radio" id="haisui2" name="haisui" value="1" onFocus='Text("haisui2", 1)' onBlur='Text("haisui2", 2)' <?=$haisuichk2?> />下水
            　<input type="radio" id="haisui3" name="haisui" value="2" onFocus='Text("haisui3", 1)' onBlur='Text("haisui3", 2)' <?=$haisuichk3?> />浄化槽
            　<input type="radio" id="haisui4" name="haisui" value="2" onFocus='Text("haisui4", 1)' onBlur='Text("haisui4", 2)' <?=$haisuichk4?> />汲取
            　<input type="radio" id="haisui5" name="haisui" value="3" onFocus='Text("haisui5", 1)' onBlur='Text("haisui5", 2)' <?=$haisuichk5?> />その他
          </td>
        </tr>
        <tr>
          <th class="must">バス</th>
          <td>
            <input type="radio" id="bus1" name="bus" value="" onFocus='Text("bus1", 1)' onBlur='Text("bus1", 2)' <?=$buschk1?> />指定なし
            　<input type="radio" id="bus2" name="bus" value="1" onFocus='Text("bus2", 1)' onBlur='Text("bus2", 2)' <?=$buschk2?> />専用
            　<input type="radio" id="bus3" name="bus" value="2" onFocus='Text("bus3", 1)' onBlur='Text("bus3", 2)' <?=$buschk3?> />共同
            　<input type="radio" id="bus4" name="bus" value="3" onFocus='Text("bus4", 1)' onBlur='Text("bus4", 2)' <?=$buschk4?> />無
          </td>
        </tr>
        <tr>
          <th class="must">コンロ</th>
          <td>
            <input type="radio" id="konro1" name="konro" value="" onFocus='Text("konro1", 1)' onBlur='Text("konro1", 2)' <?=$konrochk1?> />指定なし
            　<input type="radio" id="konro2" name="konro" value="1" onFocus='Text("konro2", 1)' onBlur='Text("konro2", 2)' <?=$konrochk2?> />ガス
            　<input type="radio" id="konro3" name="konro" value="2" onFocus='Text("konro3", 1)' onBlur='Text("konro3", 2)' <?=$konrochk3?> />電気
            　<input type="radio" id="konro4" name="konro" value="3" onFocus='Text("konro4", 1)' onBlur='Text("konro4", 2)' <?=$konrochk4?> />ＩＨ
          </td>
        </tr>
        <tr>
          <th class="must">トイレ</th>
          <td>
            <input type="radio" id="toire1" name="toire" value="" onFocus='Text("toire1", 1)' onBlur='Text("toire1", 2)' <?=$toirechk1?> />指定なし
            　<input type="radio" id="toire2" name="toire" value="1" onFocus='Text("toire2", 1)' onBlur='Text("toire2", 2)' <?=$toirechk2?> />専用
            　<input type="radio" id="toire3" name="toire" value="2" onFocus='Text("toire3", 1)' onBlur='Text("toire3", 2)' <?=$toirechk3?> />共同
            　<input type="radio" id="toire4" name="toire" value="3" onFocus='Text("toire4", 1)' onBlur='Text("toire4", 2)' <?=$toirechk4?> />無
          </td>
        </tr>
        <tr>
          <th class="must">冷暖房</th>
          <td>
            <input type="radio" id="reidanbou1" name="reidanbou" value="" onFocus='Text("reidanbou1", 1)' onBlur='Text("reidanbou1", 2)' <?=$reidanbouchk1?> />指定なし
            　<input type="radio" id="reidanbou2" name="reidanbou" value="1" onFocus='Text("reidanbou2", 1)' onBlur='Text("reidanbou2", 2)' <?=$reidanbouchk2?> />冷房
            　<input type="radio" id="reidanbou3" name="reidanbou" value="2" onFocus='Text("reidanbou3", 1)' onBlur='Text("reidanbou3", 2)' <?=$reidanbouchk3?> />ガス暖房
            　<input type="radio" id="reidanbou4" name="reidanbou" value="3" onFocus='Text("reidanbou4", 1)' onBlur='Text("reidanbou4", 2)' <?=$reidanbouchk4?> />石油暖房他
            　<input type="radio" id="reidanbou5" name="reidanbou" value="3" onFocus='Text("reidanbou5", 1)' onBlur='Text("reidanbou5", 2)' <?=$reidanbouchk5?> />エアコン
          </td>
        </tr>
        <tr>
          <th class="must">INTERNET対応</th>
          <td>
            <input type="radio" id="internet1" name="internet" value="" onFocus='Text("internet1", 1)' onBlur='Text("internet1", 2)' <?=$internetchk1?> />指定なし
            　<input type="radio" id="internet2" name="internet" value="1" onFocus='Text("internet2", 1)' onBlur='Text("internet2", 2)' <?=$internetchk?> />インターネット対応
            　<input type="radio" id="internet3" name="internet" value="2" onFocus='Text("internet3", 1)' onBlur='Text("internet3", 2)' <?=$internetchk?> />高速インターネット
            　<input type="radio" id="internet4" name="internet" value="3" onFocus='Text("internet4", 1)' onBlur='Text("internet4", 2)' <?=$internetchk?> />光ファイバー
          </td>
        </tr>
        <tr>
          <th class="must">洗濯機置場</th>
          <td>
            <input type="radio" id="sentaku1" name="sentaku" value="" onFocus='Text("sentaku1", 1)' onBlur='Text("sentaku1", 2)' <?=$sentakuchk1?> />指定なし
            　<input type="radio" id="sentaku2" name="sentaku" value="1" onFocus='Text("sentaku2", 1)' onBlur='Text("sentaku2", 2)' <?=$sentakuchk2?> />室内
            　<input type="radio" id="sentaku3" name="sentaku" value="2" onFocus='Text("sentaku3", 1)' onBlur='Text("sentaku3", 2)' <?=$sentakuchk3?> />有
          </td>
        </tr>
      </table>
      <br />
      <div id="title">　その他設備</div>
      <br>
      <table id="client" cellspacing="0">
        <tr>
          <th class="must">その他設備</th>
          <td>
            <input type="checkbox" id="equip1" name="equip" value="" onFocus='Text("equip1", 1)' onBlur='Text("equip1", 2)' <?=$roomfloorflgchk1?> />バス・トイレ別
            　<input type="checkbox" id="equip2" name="equip" value="1" onFocus='Text("equip2", 1)' onBlur='Text("equip2", 2)' <?=$roomfloorflgchk2?> />シャワー
            　<input type="checkbox" id="equip3" name="equip" value="2" onFocus='Text("equip3", 1)' onBlur='Text("equip3", 2)' <?=$roomfloorflgchk2?> />システムキッチン
            　<input type="checkbox" id="equip4" name="equip" value="2" onFocus='Text("equip4", 1)' onBlur='Text("equip4", 2)' <?=$roomfloorflgchk2?> />給湯
            　<input type="checkbox" id="equip5" name="equip" value="2" onFocus='Text("equip5", 1)' onBlur='Text("equip5", 2)' <?=$roomfloorflgchk2?> />追い焚き
            　<input type="checkbox" id="equip6" name="equip" value="2" onFocus='Text("equip6", 1)' onBlur='Text("equip6", 2)' <?=$roomfloorflgchk2?> />シャンプードレッサー<BR>
            <input type="checkbox" id="equip7" name="equip" value="2" onFocus='Text("equip7", 1)' onBlur='Text("equip7", 2)' <?=$roomfloorflgchk2?> />トランクルーム
            　<input type="checkbox" id="equip8" name="equip" value="2" onFocus='Text("equip8", 1)' onBlur='Text("equip8", 2)' <?=$roomfloorflgchk2?> />床下収納
            　<input type="checkbox" id="equip9" name="equip" value="2" onFocus='Text("equip9", 1)' onBlur='Text("equip9", 2)' <?=$roomfloorflgchk2?> />ウォークインクローゼット
            　<input type="checkbox" id="equip10" name="equip" value="2" onFocus='Text("equip10", 1)' onBlur='Text("equip10", 2)' <?=$roomfloorflgchk2?> />ロフト付き
            　<input type="checkbox" id="equip11" name="equip" value="2" onFocus='Text("equip11", 1)' onBlur='Text("equip11", 2)' <?=$roomfloorflgchk2?> />ＣＡＴＶ
            　<input type="checkbox" id="equip12" name="equip" value="2" onFocus='Text("equip12", 1)' onBlur='Text("equip12", 2)' <?=$roomfloorflgchk2?> />ＣＳアンテナ<BR>
            <input type="checkbox" id="equip13" name="equip" value="2" onFocus='Text("equip13", 1)' onBlur='Text("equip13", 2)' <?=$roomfloorflgchk2?> />ＢＳアンテナ
            　<input type="checkbox" id="equip14" name="equip" value="2" onFocus='Text("equip14", 1)' onBlur='Text("equip14", 2)' <?=$roomfloorflgchk2?> />有線放送
            　<input type="checkbox" id="equip15" name="equip" value="2" onFocus='Text("equip15", 1)' onBlur='Text("equip15", 2)' <?=$roomfloorflgchk2?> />オートロック
            　<input type="checkbox" id="equip16" name="equip" value="2" onFocus='Text("equip16", 1)' onBlur='Text("equip16", 2)' <?=$roomfloorflgchk2?> />専用庭
            　<input type="checkbox" id="equip17" name="equip" value="2" onFocus='Text("equip17", 1)' onBlur='Text("equip17", 2)' <?=$roomfloorflgchk2?> />出窓
            　<input type="checkbox" id="equip18" name="equip" value="2" onFocus='Text("equip18", 1)' onBlur='Text("equip18", 2)' <?=$roomfloorflgchk2?> />バルコニー<BR>
            <input type="checkbox" id="equip19" name="equip" value="2" onFocus='Text("equip19", 1)' onBlur='Text("equip19", 2)' <?=$roomfloorflgchk2?> />フローリング
            　<input type="checkbox" id="equip20" name="equip" value="2" onFocus='Text("equip20", 1)' onBlur='Text("equip20", 2)' <?=$roomfloorflgchk2?> />冷蔵庫あり
            　<input type="checkbox" id="equip21" name="equip" value="2" onFocus='Text("equip21", 1)' onBlur='Text("equip21", 2)' <?=$roomfloorflgchk2?> />宅配ボックス
            　<input type="checkbox" id="equip22" name="equip" value="2" onFocus='Text("equip22", 1)' onBlur='Text("equip22", 2)' <?=$roomfloorflgchk2?> />駐車場あり
            　<input type="checkbox" id="equip23" name="equip" value="2" onFocus='Text("equip23", 1)' onBlur='Text("equip23", 2)' <?=$roomfloorflgchk2?> />バイク置き場あり
            　<input type="checkbox" id="equip24" name="equip" value="2" onFocus='Text("equip24", 1)' onBlur='Text("equip24", 2)' <?=$roomfloorflgchk2?> />タイル貼り<BR>
            <input type="checkbox" id="equip25" name="equip" value="2" onFocus='Text("equip25", 1)' onBlur='Text("equip25", 2)' <?=$roomfloorflgchk2?> />角部屋
            　<input type="checkbox" id="equip26" name="equip" value="2" onFocus='Text("equip26", 1)' onBlur='Text("equip26", 2)' <?=$roomfloorflgchk2?> />床暖房
            　<input type="checkbox" id="equip27" name="equip" value="2" onFocus='Text("equip27", 1)' onBlur='Text("equip27", 2)' <?=$roomfloorflgchk2?> />ＴＶドアホン
            　<input type="checkbox" id="equip28" name="equip" value="2" onFocus='Text("equip28", 1)' onBlur='Text("equip28", 2)' <?=$roomfloorflgchk2?> />住宅性能保障付き
            　<input type="checkbox" id="equip29" name="equip" value="2" onFocus='Text("equip29", 1)' onBlur='Text("equip29", 2)' <?=$roomfloorflgchk2?> />バリアフリー
            　<input type="checkbox" id="equip30" name="equip" value="2" onFocus='Text("equip30", 1)' onBlur='Text("equip30", 2)' <?=$roomfloorflgchk2?> />シャワートイレ<BR>
            <input type="checkbox" id="equip31" name="equip" value="2" onFocus='Text("equip31", 1)' onBlur='Text("equip31", 2)' <?=$roomfloorflgchk2?> />デザイナーズ
            　<input type="checkbox" id="equip32" name="equip" value="2" onFocus='Text("equip32", 1)' onBlur='Text("equip32", 2)' <?=$roomfloorflgchk2?> />オール電化
            　<input type="checkbox" id="equip33" name="equip" value="2" onFocus='Text("equip33", 1)' onBlur='Text("equip33", 2)' <?=$roomfloorflgchk2?> />カウンターキッチン
            　<input type="checkbox" id="equip34" name="equip" value="2" onFocus='Text("equip34", 1)' onBlur='Text("equip34", 2)' <?=$roomfloorflgchk2?> />浴室乾燥機
          </td>
        </tr>
      </table>
      <br />
      <div id="title">　駐車場</div>
      <br>
      <table id="client" cellspacing="0">
        <tr>
          <th class="must">区分</th>
          <td>
            <SELECT name="parking_division">
              <OPTION value="">---</OPTION>
<?=$parking_division_value?>
              <OPTION value="1">空有</OPTION>
              <OPTION value="2">空無</OPTION>
              <OPTION value="3">近隣</OPTION>
              <OPTION value="4">無</OPTION>
            </SELECT>
          </td>
        </tr>
        <tr>
          <th class="must">駐車場料金</th>
          <td>
            <input type="text" id="parking_price" name="parking_price" value="<?=$parking_price?>" onFocus='Text("parking_price", 1)' onBlur='Text("parking_price", 2)' style="width:100px;" />円
            <SELECT name="parking_pricetax">
              <OPTION value="">---</OPTION>
<?=$parking_pricetax_value?>
              <OPTION value="2">税込</OPTION>
              <OPTION value="3">税無</OPTION>
            </SELECT>
          </td>
        </tr>
        <tr>
          <th class="must">空台数</th>
          <td>
            <input type="text" id="parking_emptynum" name="parking_emptynum" value="<?=$parking_emptynum?>" onFocus='Text("parking_emptynum", 1)' onBlur='Text("parking_emptynum", 2)' style="width:100px;" />
          </td>
        </tr>
        <tr>
          <th class="must">距離</th>
          <td>
            <input type="text" id="parking_distance" name="parking_distance" value="<?=$parking_distance?>" onFocus='Text("parking_distance", 1)' onBlur='Text("parking_distance", 2)' style="width:100px;" />ｍ
          </td>
        </tr>
        <tr>
          <th class="must">備考</th>
          <td>
            <input type="text" id="parking_biko" name="parking_biko" value="<?=$parking_biko?>" onFocus='Text("parking_biko", 1)' onBlur='Text("parking_biko", 2)' style="width:250px;" />
          </td>
        </tr>
      </table>
      <br />
      <div id="title">　周辺環境</div>
      <br>
      <table id="client" cellspacing="0">
        <tr>
          <th class="must">小学校</th>
          <td>
            <input type="text" id="surround_syougakkou" name="surround_syougakkou" value="<?=$surround_syougakkou?>" onFocus='Text("surround_syougakkou", 1)' onBlur='Text("surround_syougakkou", 2)' style="width:200px;" />
            <input type="text" id="surround_syoudistance" name="surround_syoudistance" value="<?=$surround_syoudistance?>" onFocus='Text("surround_syoudistance", 1)' onBlur='Text("surround_syoudistance", 2)' style="width:100px;" />ｍ
          </td>
        </tr>
        <tr>
          <th class="must">中学校</th>
          <td>
            <input type="text" id="surround_chuugakkou" name="surround_chuugakkou" value="<?=$surround_chuugakkou?>" onFocus='Text("surround_chuugakkou", 1)' onBlur='Text("surround_chuugakkou", 2)' style="width:200px;" />
            <input type="text" id="surround_chuudistance" name="surround_chuudistance" value="<?=$surround_chuudistance?>" onFocus='Text("surround_chuudistance", 1)' onBlur='Text("surround_chuudistance", 2)' style="width:100px;" />ｍ
          </td>
        </tr>
        <tr>
          <th class="must">コンビニ</th>
          <td>
            <input type="text" id="surround_konbinidistance" name="surround_konbinidistance" value="<?=$surround_konbinidistance?>" onFocus='Text("surround_konbinidistance", 1)' onBlur='Text("surround_konbinidistance", 2)' style="width:250px;" />ｍ
          </td>
        </tr>
        <tr>
          <th class="must">スーパー</th>
          <td>
            <input type="text" id="surround_superdistance" name="surround_superdistance" value="<?=$surround_superdistance?>" onFocus='Text("surround_superdistance", 1)' onBlur='Text("surround_superdistance", 2)' style="width:250px;" />ｍ
          </td>
        </tr>
        <tr>
          <th class="must">総合病院</th>
          <td>
            <input type="text" id="surround_hospitaldistance" name="surround_hospitaldistance" value="<?=$surround_hospitaldistance?>" onFocus='Text("surround_hospitaldistance", 1)' onBlur='Text("surround_hospitaldistance", 2)' style="width:250px;" />ｍ
          </td>
        </tr>
      </table>
      <br />
      <div id="title">　物件の特徴</div>
      <br>
      <table id="client" cellspacing="0">
        <tr>
          <th class="must">キャッチコピー</th>
          <td>
            <input type="text" id="feacher_all" name="feacher_all" value="<?=$feacher_all?>" onFocus='Text("feacher_all", 1)' onBlur='Text("feacher_all", 2)' style="width:250px;" />
          </td>
        </tr>
        <tr>
          <th class="must">自社ＨＰに表示</th>
          <td>
            <input type="text" id="feacher_a" name="feacher_a" value="<?=$feacher_a?>" onFocus='Text("feacher_a", 1)' onBlur='Text("feacher_a", 2)' style="width:250px;" />
          </td>
        </tr>
        <tr>
          <th class="must">他社ＨＰに表示</th>
          <td>
            <input type="text" id="feacher_b" name="feacher_b" value="<?=$feacher_b?>" onFocus='Text("feacher_b", 1)' onBlur='Text("feacher_b", 2)' style="width:250px;" />
          </td>
        </tr>
      </table>
      <br />
      <div id="title">　備考</div>
      <br>
      <table id="client" cellspacing="0">
        <tr>
          <th class="must">備考</th>
          <td>
            <input type="text" id="biko_all" name="biko_all" value="<?=$biko_all?>" onFocus='Text("biko_all", 1)' onBlur='Text("biko_all", 2)' style="width:250px;" />
          </td>
        </tr>
        <tr>
          <th class="must">自社ＨＰに表示</th>
          <td>
            <input type="text" id="biko_a" name="biko_a" value="<?=$biko_a?>" onFocus='Text("biko_a", 1)' onBlur='Text("biko_a", 2)' style="width:250px;" />
          </td>
        </tr>
        <tr>
          <th class="must">他社ＨＰに表示</th>
          <td>
            <input type="text" id="biko_b" name="biko_b" value="<?=$biko_b?>" onFocus='Text("biko_b", 1)' onBlur='Text("biko_b", 2)' style="width:250px;" />
          </td>
        </tr>
        <tr>
          <th class="must">リンク先ＵＲＬ</th>
          <td>
            <SELECT name="biko_url1">
<?=$biko_url1_value?>
              <OPTION value="0">物件ページ</OPTION>
              <OPTION value="1">動画</OPTION>
              <OPTION value="3">自社ＨＰ</OPTION>
            </SELECT>
            <br>
            <input type="text" id="biko_url2" name="biko_url2" value="<?=$biko_url2?>" onFocus='Text("biko_url2", 1)' onBlur='Text("biko_url2", 2)' style="width:250px;" />
          </td>
        </tr>
        <tr>
          <th class="must">社内メモ</th>
          <td>
            <input type="text" id="biko_memo" name="biko_memo" value="<?=$biko_memo?>" onFocus='Text("biko_memo", 1)' onBlur='Text("biko_memo", 2)' style="width:250px;" />
          </td>
        </tr>
      </table>
      <br />
      <div id="title">　オープンルーム/オープンハウス</div>
      <br>
      <table id="client" cellspacing="0">
        <tr>
          <th class="must">開始日</th>
          <td>
            西暦<input type="text" id="openhouse_start_year" name="openhouse_start_year" value="<?=$openhouse_start_year?>" onFocus='Text("openhouse_start_year", 1)' onBlur='Text("openhouse_start_year", 2)' style="width:100px;" />年
            <input type="text" id="openhouse_start_month" name="openhouse_start_month" value="<?=$openhouse_start_month?>" onFocus='Text("openhouse_start_month", 1)' onBlur='Text("openhouse_start_month", 2)' style="width:100px;" />月
            <input type="text" id="openhouse_start_day" name="openhouse_start_day" value="<?=$openhouse_start_day?>" onFocus='Text("openhouse_start_day", 1)' onBlur='Text("openhouse_start_day", 2)' style="width:100px;" />日
          </td>
        </tr>
        <tr>
          <th class="must">終了日</th>
          <td>
            西暦<input type="text" id="openhouse_end_year" name="openhouse_end_year" value="<?=$openhouse_end_year?>" onFocus='Text("openhouse_end_year", 1)' onBlur='Text("openhouse_end_year", 2)' style="width:100px;" />年
            <input type="text" id="openhouse_end_month" name="openhouse_end_month" value="<?=$openhouse_end_month?>" onFocus='Text("openhouse_end_month", 1)' onBlur='Text("openhouse_end_month", 2)' style="width:100px;" />月
            <input type="text" id="openhouse_end_day" name="openhouse_end_day" value="<?=$openhouse_end_day?>" onFocus='Text("openhouse_end_day", 1)' onBlur='Text("openhouse_end_day", 2)' style="width:100px;" />日
          </td>
        </tr>
        <tr>
          <th class="must">開催時間</th>
          <td>
            <input type="text" id="openhouse_period" name="openhouse_period" value="<?=$openhouse_period?>" onFocus='Text("openhouse_period", 1)' onBlur='Text("openhouse_period", 2)' style="width:250px;" />
          </td>
        </tr>
        <tr>
          <th class="must">備考</th>
          <td>
            <input type="text" id="openhouse_biko" name="openhouse_biko" value="<?=$openhouse_biko?>" onFocus='Text("openhouse_biko", 1)' onBlur='Text("openhouse_biko", 2)' style="width:250px;" />
          </td>
        </tr>
      </table>
      <br />
      <div id="title">　取引情報</div>
      <br>
      <table id="client" cellspacing="0">
        <tr>
          <th class="must">取引形態</th>
          <td>
            <SELECT name="trade_mode">
              <OPTION value="">---</OPTION>
<?=$trade_mode_value?>
              <OPTION value="1">売主</OPTION>
              <OPTION value="2">代理</OPTION>
              <OPTION value="3">専属専任媒介</OPTION>
              <OPTION value="4">専任媒介</OPTION>
              <OPTION value="5">一般媒介</OPTION>
              <OPTION value="6">仲介</OPTION>
            </SELECT>
          </td>
        </tr>
        <tr>
          <th class="must">客付け</th>
          <td>
            <SELECT name="kyakuzuke_flg">
              <OPTION value="">---</OPTION>
<?=$kyakuzuke_flg_value?>
              <OPTION value="0">不可</OPTION>
              <OPTION value="1">可（他社取込不可）</OPTION>
              <OPTION value="2">可（他社取込可）</OPTION>
            </SELECT><BR>
            手数料<SELECT name="kyakuzuke_futan">
              <OPTION value="">---</OPTION>
<?=$kyakuzuke_futan_value?>
              <OPTION value="110">分かれ</OPTION>
              <OPTION value="111">0.5％</OPTION>
              <OPTION value="112">1.0％</OPTION>
              <OPTION value="113">1.5％</OPTION>
              <OPTION value="114">2.0％</OPTION>
              <OPTION value="115">2.5％</OPTION>
              <OPTION value="116">3.0％</OPTION>
              <OPTION value="117">正規手数料</OPTION>
            </SELECT><BR>
            客付業者へのメッセージ<input type="text" id="kyakuzuke_message" name="kyakuzuke_message" value="<?=$kyakuzuke_message?>" onFocus='Text("kyakuzuke_message", 1)' onBlur='Text("kyakuzuke_message", 2)' style="width:250px;" />
          </td>
        </tr>
        <tr>
          <th class="must">自社先物</th>
          <td>
            <input type="radio" id="estate_jishamono1" name="estate_jishamono" value="" onFocus='Text("estate_jishamono1", 1)' onBlur='Text("estate_jishamono1", 2)' <?=$estate_jishamonochk1?> />先物
            　<input type="radio" id="estate_jishamono2" name="estate_jishamono" value="1" onFocus='Text("estate_jishamono2", 1)' onBlur='Text("estate_jishamono2", 2)' <?=$estate_jishamonochk2?> />自社物
          </td>
        </tr>
        <tr>
          <th class="must">媒介契約年月日</th>
          <td>
            西暦<input type="text" id="kyakuzuke_date_year" name="kyakuzuke_date_year" value="<?=$kyakuzuke_date_year?>" onFocus='Text("kyakuzuke_date_year", 1)' onBlur='Text("kyakuzuke_date_year", 2)' style="width:100px;" />年
            <input type="text" id="kyakuzuke_date_month" name="kyakuzuke_date_month" value="<?=$kyakuzuke_date_month?>" onFocus='Text("kyakuzuke_date_month", 1)' onBlur='Text("kyakuzuke_date_month", 2)' style="width:100px;" />月
            <input type="text" id="kyakuzuke_date_day" name="kyakuzuke_date_day" value="<?=$kyakuzuke_date_day?>" onFocus='Text("kyakuzuke_date_day", 1)' onBlur='Text("kyakuzuke_date_day", 2)' style="width:100px;" />日
          </td>
        </tr>
      </table>
      <br />
      <div id="title">　所有者</div>
      <br>
      <table id="client" cellspacing="0">
        <tr>
          <th class="must">所有者名</th>
          <td>
            <input type="text" id="owner_name" name="owner_name" value="<?=$owner_name?>" onFocus='Text("owner_name", 1)' onBlur='Text("owner_name", 2)' style="width:250px;" />
          </td>
        </tr>
        <tr>
          <th class="must">ＴＥＬ</th>
          <td>
            <input type="text" id="owner_tell1" name="owner_tell1" value="<?=$owner_tell1?>" onFocus='Text("owner_tell1", 1)' onBlur='Text("owner_tell1", 2)' style="width:100px;" />−
            <input type="text" id="owner_tell2" name="owner_tell2" value="<?=$owner_tell2?>" onFocus='Text("owner_tell2", 1)' onBlur='Text("owner_tell2", 2)' style="width:100px;" />−
            <input type="text" id="owner_tell3" name="owner_tell3" value="<?=$owner_tell3?>" onFocus='Text("owner_tell3", 1)' onBlur='Text("owner_tell3", 2)' style="width:100px;" />
          </td>
        </tr>
        <tr>
          <th class="must">ＦＡＸ</th>
          <td>
            <input type="text" id="owner_fax1" name="owner_fax1" value="<?=$owner_fax1?>" onFocus='Text("owner_fax1", 1)' onBlur='Text("owner_fax1", 2)' style="width:100px;" />−
            <input type="text" id="owner_fax2" name="owner_fax2" value="<?=$owner_fax2?>" onFocus='Text("owner_fax2", 1)' onBlur='Text("owner_fax2", 2)' style="width:100px;" />−
            <input type="text" id="owner_fax3" name="owner_fax3" value="<?=$owner_fax3?>" onFocus='Text("owner_fax3", 1)' onBlur='Text("owner_fax3", 2)' style="width:100px;" />
          </td>
        </tr>
        <tr>
          <th class="must">備考</th>
          <td>
            <input type="text" id="owner_biko" name="owner_biko" value="<?=$owner_biko?>" onFocus='Text("owner_biko", 1)' onBlur='Text("owner_biko", 2)' style="width:250px;" />
          </td>
        </tr>
        <tr>
          <th class="must">住所<BR>(※番地以下省略可)</th>
          <td>
            <table><tr>
            <td>
              <input type="text" id="address_wordOwner" name="address_wordOwner" value=""><input type="button" value="検索" onclick="sendDataAddOwner(this.form)"><br>
              <div id="helloOwner">
              <select name="address_listOwner" id="address_listOwner" size="10" style="width:200px">
                <option value=""> </option>
              </select>
              </div>
            </td>
            <td valign="middle">
              <input type="button" value="→" onclick="sendDataAddOwner2(this.form)">
            </td>
            <td>
              <div id="helloOwner2">
	      <table class="zip"><tr>
	      <td class="zip" align="right" width="100px">〒</td><td class="zip"><input id="owner_zip1" type="text" name="owner_zip1" value="<?=$owner_zip1?>" style="width:40px" maxlength="3" onFocus='Text("owner_zip1", 1)' onBlur='Text("owner_zip1", 2)' />
	      -<input id="owner_zip2" type="text" name="owner_zip2" value="<?=$owner_zip2?>" style="width:50px" maxlength="4" onFocus='Text("owner_zip2", 1)' onBlur='Text("owner_zip2", 2)' />
	      <input type="button" value="住所取得" onclick="return zipSearchOwner()">
              <font color="#ff0000">（半角数字で入力）</font>
              </td>
	      </tr><tr>
              <td class="zip" align="right" width="100px">都道府県</td>
              <td class="zip">
                <select name="owner_pref">
<?=$owner_pref_value?>
                </select>
              <td>
	      </tr><tr>
              <td class="zip" align="right" width="100px">市区郡</td><td class="zip"><input type="text" name="owner_address1" value="<?=$owner_address1?>" maxlength="80" style="width:200px" readonly /></td>
	      </tr><tr>
              <td class="zip" align="right" width="100px">町村</td><td class="zip"><input type="text" name="owner_address2" value="<?=$owner_address2?>" maxlength="80" style="width:200px" readonly /><td>
	      </tr><tr>
              <td class="zip" align="right" width="100px">丁目</td><td class="zip"><input type="text" name="owner_addname" value="<?=$owner_addname?>" maxlength="80" style="width:200px" /><td>
	      </tr><tr>
              <td class="zip" align="right" width="100px">番地</td><td class="zip"><input type="text" name="owner_addopen" value="<?=$owner_addopen?>" maxlength="80" style="width:200px" /><td>
	      </tr>
	      </table>
	      <input type="hidden" name="owner_addcd1" value="<?=$owner_addcd1?>">
	      <input type="hidden" name="owner_addcd2" value="<?=$owner_addcd2?>">
            </td>
            </tr></table>
            </div>
          <td>
        </tr>
      </table>
      <br />
      <div id="title">　元付会社</div>
      <br>
      <table id="client" cellspacing="0">
        <tr>
          <th class="must">会社名</th>
          <td>
            <input type="text" id="motozuke_name" name="motozuke_name" value="<?=$motozuke_name?>" onFocus='Text("motozuke_name", 1)' onBlur='Text("motozuke_name", 2)' style="width:250px;" />
          </td>
        </tr>
        <tr>
          <th class="must">物件担当者名</th>
          <td>
            <input type="text" id="owner_name" name="tanto_name" value="<?=$tanto_name?>" onFocus='Text("tanto_name", 1)' onBlur='Text("tanto_name", 2)' style="width:250px;" />
          </td>
        </tr>
        <tr>
          <th class="must">ＴＥＬ</th>
          <td>
            <input type="text" id="motozuke_tell1" name="motozuke_tell1" value="<?=$motozuke_tell1?>" onFocus='Text("motozuke_tell1", 1)' onBlur='Text("motozuke_tell1", 2)' style="width:100px;" />−
            <input type="text" id="motozuke_tell2" name="motozuke_tell2" value="<?=$motozuke_tell2?>" onFocus='Text("motozuke_tell2", 1)' onBlur='Text("motozuke_tell2", 2)' style="width:100px;" />−
            <input type="text" id="motozuke_tell3" name="motozuke_tell3" value="<?=$motozuke_tell3?>" onFocus='Text("motozuke_tell3", 1)' onBlur='Text("motozuke_tell3", 2)' style="width:100px;" />
          </td>
        </tr>
        <tr>
          <th class="must">ＦＡＸ</th>
          <td>
            <input type="text" id="motozuke_fax1" name="motozuke_fax1" value="<?=$motozuke_fax1?>" onFocus='Text("motozuke_fax1", 1)' onBlur='Text("motozuke_fax1", 2)' style="width:100px;" />−
            <input type="text" id="motozuke_fax2" name="motozuke_fax2" value="<?=$motozuke_fax2?>" onFocus='Text("motozuke_fax2", 1)' onBlur='Text("motozuke_fax2", 2)' style="width:100px;" />−
            <input type="text" id="motozuke_fax3" name="motozuke_fax3" value="<?=$motozuke_fax3?>" onFocus='Text("motozuke_fax3", 1)' onBlur='Text("motozuke_fax3", 2)' style="width:100px;" />
          </td>
        </tr>
        <tr>
          <th class="must">備考</th>
          <td>
            <input type="text" id="motozuke_biko" name="motozuke_biko" value="<?=$motozuke_biko?>" onFocus='Text("motozuke_biko", 1)' onBlur='Text("motozuke_biko", 2)' style="width:250px;" />
          </td>
        </tr>
        <tr>
          <th class="must">掲載確認日</th>
          <td>
            西暦<input type="text" id="trade_date_year" name="trade_date_year" value="<?=$trade_date_year?>" onFocus='Text("trade_date_year", 1)' onBlur='Text("trade_date_year", 2)' style="width:100px;" />年
            <input type="text" id="trade_date_month" name="trade_date_month" value="<?=$trade_date_month?>" onFocus='Text("trade_date_month", 1)' onBlur='Text("trade_date_month", 2)' style="width:100px;" />月
            <input type="text" id="trade_date_day" name="trade_date_day" value="<?=$trade_date_day?>" onFocus='Text("trade_date_day", 1)' onBlur='Text("trade_date_day", 2)' style="width:100px;" />日
          </td>
        </tr>
        <tr>
          <th class="must">住所<BR>(※番地以下省略可)</th>
          <td>
            <table><tr>
            <td>
              <input type="text" id="address_wordmotozuke" name="address_wordmotozuke" value=""><input type="button" value="検索" onclick="sendDataAddmotozuke(this.form)"><br>
              <div id="hellomotozuke">
              <select name="address_listmotozuke" id="address_listmotozuke" size="10" style="width:200px">
                <option value=""> </option>
              </select>
              </div>
            </td>
            <td valign="middle">
              <input type="button" value="→" onclick="sendDataAddmotozuke2(this.form)">
            </td>
            <td>
              <div id="hellomotozuke2">
	      <table class="zip"><tr>
	      <td class="zip" align="right" width="100px">〒</td><td class="zip"><input id="motozuke_zip1" type="text" name="motozuke_zip1" value="<?=$motozuke_zip1?>" style="width:40px" maxlength="3" onFocus='Text("motozuke_zip1", 1)' onBlur='Text("motozuke_zip1", 2)' />
	      -<input id="motozuke_zip2" type="text" name="motozuke_zip2" value="<?=$motozuke_zip2?>" style="width:50px" maxlength="4" onFocus='Text("motozuke_zip2", 1)' onBlur='Text("motozuke_zip2", 2)' />
	      <input type="button" value="住所取得" onclick="return zipSearchmotozuke()">
              <font color="#ff0000">（半角数字で入力）</font>
              </td>
	      </tr><tr>
              <td class="zip" align="right" width="100px">都道府県</td>
              <td class="zip">
                <select name="motozuke_pref">
<?=$motozuke_pref_value?>
                </select>
              <td>
	      </tr><tr>
              <td class="zip" align="right" width="100px">市区郡</td><td class="zip"><input type="text" name="motozuke_address1" value="<?=$motozuke_address1?>" maxlength="80" style="width:200px" readonly /></td>
	      </tr><tr>
              <td class="zip" align="right" width="100px">町村</td><td class="zip"><input type="text" name="motozuke_address2" value="<?=$motozuke_address2?>" maxlength="80" style="width:200px" readonly /><td>
	      </tr><tr>
              <td class="zip" align="right" width="100px">丁目</td><td class="zip"><input type="text" name="motozuke_addname" value="<?=$motozuke_addname?>" maxlength="80" style="width:200px" /><td>
	      </tr><tr>
              <td class="zip" align="right" width="100px">番地</td><td class="zip"><input type="text" name="motozuke_addopen" value="<?=$motozuke_addopen?>" maxlength="80" style="width:200px" /><td>
	      </tr>
	      </table>
	      <input type="hidden" name="motozuke_addcd1" value="<?=$motozuke_addcd1?>">
	      <input type="hidden" name="motozuke_addcd2" value="<?=$motozuke_addcd2?>">
            </td>
            </tr></table>
            </div>
          <td>
        </tr>
      </table>
      <br />
      <div id="title">　面積・区画</div>
      <br>
      <table id="client" cellspacing="0">
        <tr>
          <th class="must">地勢</th>
          <td>
            <SELECT name="tochi_terrain">
              <OPTION value="">---</OPTION>
<?=$tochi_terrain_value?>
              <OPTION value="1">平坦</OPTION>
              <OPTION value="2">高台</OPTION>
              <OPTION value="3">低地</OPTION>
              <OPTION value="4">ひな段</OPTION>
              <OPTION value="5">傾斜地</OPTION>
              <OPTION value="9">その他</OPTION>
            </SELECT>
          </td>
        </tr>
        <tr>
          <th class="must">用途地域</th>
          <td>
            <SELECT name="tochi_terrain">
              <OPTION value="">---</OPTION>
<?=$tochi_terrain_value?>
              <OPTION value="1">第一種低層住居専用地域</OPTION>
              <OPTION value="2">第二種中高層住居専用地域</OPTION>
              <OPTION value="3">第二種住居地域</OPTION>
              <OPTION value="4">近隣商業地域</OPTION>
              <OPTION value="5">商業地域</OPTION>
              <OPTION value="6">準工業地域</OPTION>
              <OPTION value="7">工業地域</OPTION>
              <OPTION value="8">工業専用地域</OPTION>
              <OPTION value="10">第二種低層住居専用地域</OPTION>
              <OPTION value="11">第一種中高層専用地域</OPTION>
              <OPTION value="12">第一種住居地域</OPTION>
              <OPTION value="13">準住居地域</OPTION>
              <OPTION value="99">無指定</OPTION>
            </SELECT>
          </td>
        </tr>
      </table>
      <br />
      <div id="title">　権利・制限</div>
      <br>
      <table id="client" cellspacing="0">
        <tr>
          <th class="must">土地権利</th>
          <td>
            <SELECT name="tochi_terrain">
              <OPTION value="">---</OPTION>
<?=$tochi_terrain_value?>
              <OPTION value="1">所有権</OPTION>
              <OPTION value="2">旧法地上権</OPTION>
              <OPTION value="3">旧法賃借権</OPTION>
              <OPTION value="4">普通地上権</OPTION>
              <OPTION value="5">定期地上権</OPTION>
              <OPTION value="6">普通賃借権</OPTION>
              <OPTION value="7">定期賃借権</OPTION>
              <OPTION value="8">一時使用</OPTION>
            </SELECT>
          </td>
        </tr>
        <tr>
          <th class="must">借地期間</th>
          <td>
            <input type="text" id="price_contractyear" name="price_contractyear" value="<?=$price_contractyear?>" onFocus='Text("price_contractyear", 1)' onBlur='Text("price_contractyear", 2)' style="width:100px;" />年
            <input type="text" id="price_contractmonth" name="price_contractmonth" value="<?=$price_contractmonth?>" onFocus='Text("price_contractmonth", 1)' onBlur='Text("price_contractmonth", 2)' style="width:100px;" />
            <SELECT name="price_contractdivision">
              <OPTION value="1">月まで（期限）</OPTION>
              <OPTION value="2">ヶ月（期間）</OPTION>
            </SELECT>
          </td>
        </tr>
        <tr>
          <th class="must">借地料</th>
          <td>
            <input type="text" id="price_leaseprice" name="price_leaseprice" value="<?=$price_leaseprice?>" onFocus='Text("price_leaseprice", 1)' onBlur='Text("price_leaseprice", 2)' style="width:200px;" />円
          </td>
        </tr>
        <tr>
          <th class="must">冷暖房</th>
          <td>
            <input type="radio" id="reidanbou1" name="reidanbou" value="" onFocus='Text("reidanbou1", 1)' onBlur='Text("reidanbou1", 2)' <?=$reidanbouchk1?> />指定なし
            　<input type="radio" id="reidanbou2" name="reidanbou" value="1" onFocus='Text("reidanbou2", 1)' onBlur='Text("reidanbou2", 2)' <?=$reidanbouchk2?> />要
            　<input type="radio" id="reidanbou3" name="reidanbou" value="2" onFocus='Text("reidanbou3", 1)' onBlur='Text("reidanbou3", 2)' <?=$reidanbouchk3?> />届出中
            　<input type="radio" id="reidanbou4" name="reidanbou" value="3" onFocus='Text("reidanbou4", 1)' onBlur='Text("reidanbou4", 2)' <?=$reidanbouchk4?> />不要
          </td>
        </tr>
        <tr>
          <th class="must">法律上の制限</th>
          <td>
            <input type="text" id="tochi_seigen" name="tochi_seigen" value="<?=$tochi_seigen?>" onFocus='Text("tochi_seigen", 1)' onBlur='Text("tochi_seigen", 2)' style="width:250px;" />円
          </td>
        </tr>
      </table>
      <br />
      <div id="title">　画像読み込み</div>
      <br>
      <table id="client" cellspacing="0">
        <tr>
          <th class="must">画像１</th>
          <td>
            <SELECT name="img_type1">
<?=$img_type1_value?>
              <OPTION value="1">間取り</OPTION>
              <OPTION value="2">外観</OPTION>
              <OPTION value="3">地図</OPTION>
              <OPTION value="4">周辺</OPTION>
              <OPTION value="5">内装</OPTION>
              <OPTION value="9">その他</OPTION>
              <OPTION value="10">玄関</OPTION>
              <OPTION value="11">居間</OPTION>
              <OPTION value="12">キッチン</OPTION>
              <OPTION value="13">寝室</OPTION>
              <OPTION value="14">子供部屋</OPTION>
              <OPTION value="15">風呂</OPTION>
            </SELECT>
            <input type="text" id="img_comment1" name="img_comment1" value="<?=$img_comment1?>" onFocus='Text("img_comment1", 1)' onBlur='Text("img_comment1", 2)' style="width:250px;" />
            <input type="file" id="img_org1" name="img_org1" onFocus='Text("img_org1", 1)' onBlur='Text("img_org1", 2)' style="width:100px;" />
          </td>
        </tr>
        <tr>
          <th class="must">画像２</th>
          <td>
            <SELECT name="img_type2">
<?=$img_type2_value?>
              <OPTION value="1">間取り</OPTION>
              <OPTION value="2">外観</OPTION>
              <OPTION value="3">地図</OPTION>
              <OPTION value="4">周辺</OPTION>
              <OPTION value="5">内装</OPTION>
              <OPTION value="9">その他</OPTION>
              <OPTION value="10">玄関</OPTION>
              <OPTION value="11">居間</OPTION>
              <OPTION value="12">キッチン</OPTION>
              <OPTION value="13">寝室</OPTION>
              <OPTION value="14">子供部屋</OPTION>
              <OPTION value="15">風呂</OPTION>
            </SELECT>
            <input type="text" id="img_comment2" name="img_comment2" value="<?=$img_comment2?>" onFocus='Text("img_comment2", 1)' onBlur='Text("img_comment2", 2)' style="width:250px;" />
            <input type="file" id="img_org2" name="img_org2" onFocus='Text("img_org2", 1)' onBlur='Text("img_org2", 2)' style="width:100px;" />
          </td>
        </tr>
        <tr>
          <th class="must">画像３</th>
          <td>
            <SELECT name="img_type3">
<?=$img_type3_value?>
              <OPTION value="1">間取り</OPTION>
              <OPTION value="2">外観</OPTION>
              <OPTION value="3">地図</OPTION>
              <OPTION value="4">周辺</OPTION>
              <OPTION value="5">内装</OPTION>
              <OPTION value="9">その他</OPTION>
              <OPTION value="10">玄関</OPTION>
              <OPTION value="11">居間</OPTION>
              <OPTION value="12">キッチン</OPTION>
              <OPTION value="13">寝室</OPTION>
              <OPTION value="14">子供部屋</OPTION>
              <OPTION value="15">風呂</OPTION>
            </SELECT>
            <input type="text" id="img_comment3" name="img_comment3" value="<?=$img_comment3?>" onFocus='Text("img_comment3", 1)' onBlur='Text("img_comment3", 2)' style="width:250px;" />
            <input type="file" id="img_org3" name="img_org3" onFocus='Text("img_org3", 1)' onBlur='Text("img_org3", 2)' style="width:100px;" />
          </td>
        </tr>
        <tr>
          <th class="must">画像４</th>
          <td>
            <SELECT name="img_type4">
<?=$img_type4_value?>
              <OPTION value="1">間取り</OPTION>
              <OPTION value="2">外観</OPTION>
              <OPTION value="3">地図</OPTION>
              <OPTION value="4">周辺</OPTION>
              <OPTION value="5">内装</OPTION>
              <OPTION value="9">その他</OPTION>
              <OPTION value="10">玄関</OPTION>
              <OPTION value="11">居間</OPTION>
              <OPTION value="12">キッチン</OPTION>
              <OPTION value="13">寝室</OPTION>
              <OPTION value="14">子供部屋</OPTION>
              <OPTION value="15">風呂</OPTION>
            </SELECT>
            <input type="text" id="img_comment4" name="img_comment4" value="<?=$img_comment4?>" onFocus='Text("img_comment4", 1)' onBlur='Text("img_comment4", 2)' style="width:250px;" />
            <input type="file" id="img_org4" name="img_org4" onFocus='Text("img_org4", 1)' onBlur='Text("img_org4", 2)' style="width:100px;" />
          </td>
        </tr>
        <tr>
          <th class="must">画像５</th>
          <td>
            <SELECT name="img_type5">
<?=$img_type5_value?>
              <OPTION value="1">間取り</OPTION>
              <OPTION value="2">外観</OPTION>
              <OPTION value="3">地図</OPTION>
              <OPTION value="4">周辺</OPTION>
              <OPTION value="5">内装</OPTION>
              <OPTION value="9">その他</OPTION>
              <OPTION value="10">玄関</OPTION>
              <OPTION value="11">居間</OPTION>
              <OPTION value="12">キッチン</OPTION>
              <OPTION value="13">寝室</OPTION>
              <OPTION value="14">子供部屋</OPTION>
              <OPTION value="15">風呂</OPTION>
            </SELECT>
            <input type="text" id="img_comment5" name="img_comment5" value="<?=$img_comment5?>" onFocus='Text("img_comment5", 1)' onBlur='Text("img_comment5", 2)' style="width:250px;" />
            <input type="file" id="img_org5" name="img_org5" onFocus='Text("img_org5", 1)' onBlur='Text("img_org5", 2)' style="width:100px;" />
          </td>
        </tr>
        <tr>
          <th class="must">画像６</th>
          <td>
            <SELECT name="img_type6">
<?=$img_type6_value?>
              <OPTION value="1">間取り</OPTION>
              <OPTION value="2">外観</OPTION>
              <OPTION value="3">地図</OPTION>
              <OPTION value="4">周辺</OPTION>
              <OPTION value="5">内装</OPTION>
              <OPTION value="9">その他</OPTION>
              <OPTION value="10">玄関</OPTION>
              <OPTION value="11">居間</OPTION>
              <OPTION value="12">キッチン</OPTION>
              <OPTION value="13">寝室</OPTION>
              <OPTION value="14">子供部屋</OPTION>
              <OPTION value="15">風呂</OPTION>
            </SELECT>
            <input type="text" id="img_comment6" name="img_comment6" value="<?=$img_comment6?>" onFocus='Text("img_comment6", 1)' onBlur='Text("img_comment6", 2)' style="width:250px;" />
            <input type="file" id="img_org6" name="img_org6" onFocus='Text("img_org6", 1)' onBlur='Text("img_org6", 2)' style="width:100px;" />
          </td>
        </tr>
        <tr>
          <th class="must">画像７</th>
          <td>
            <SELECT name="img_type7">
<?=$img_type7_value?>
              <OPTION value="1">間取り</OPTION>
              <OPTION value="2">外観</OPTION>
              <OPTION value="3">地図</OPTION>
              <OPTION value="4">周辺</OPTION>
              <OPTION value="5">内装</OPTION>
              <OPTION value="9">その他</OPTION>
              <OPTION value="10">玄関</OPTION>
              <OPTION value="11">居間</OPTION>
              <OPTION value="12">キッチン</OPTION>
              <OPTION value="13">寝室</OPTION>
              <OPTION value="14">子供部屋</OPTION>
              <OPTION value="15">風呂</OPTION>
            </SELECT>
            <input type="text" id="img_comment7" name="img_comment7" value="<?=$img_comment7?>" onFocus='Text("img_comment7", 1)' onBlur='Text("img_comment7", 2)' style="width:250px;" />
            <input type="file" id="img_org7" name="img_org7" onFocus='Text("img_org7", 1)' onBlur='Text("img_org7", 2)' style="width:100px;" />
          </td>
        </tr>
        <tr>
          <th class="must">画像８</th>
          <td>
            <SELECT name="img_type8">
<?=$img_type8_value?>
              <OPTION value="1">間取り</OPTION>
              <OPTION value="2">外観</OPTION>
              <OPTION value="3">地図</OPTION>
              <OPTION value="4">周辺</OPTION>
              <OPTION value="5">内装</OPTION>
              <OPTION value="9">その他</OPTION>
              <OPTION value="10">玄関</OPTION>
              <OPTION value="11">居間</OPTION>
              <OPTION value="12">キッチン</OPTION>
              <OPTION value="13">寝室</OPTION>
              <OPTION value="14">子供部屋</OPTION>
              <OPTION value="15">風呂</OPTION>
            </SELECT>
            <input type="text" id="img_type8" name="img_type8" value="<?=$img_type8?>" onFocus='Text("img_type8", 1)' onBlur='Text("img_type8", 2)' style="width:250px;" />
            <input type="file" id="img_org8" name="img_org8" onFocus='Text("img_org8", 1)' onBlur='Text("img_org8", 2)' style="width:100px;" />
          </td>
        </tr>
        <tr>
          <th class="must">画像９</th>
          <td>
            <SELECT name="img_type9">
<?=$img_type9_value?>
              <OPTION value="1">間取り</OPTION>
              <OPTION value="2">外観</OPTION>
              <OPTION value="3">地図</OPTION>
              <OPTION value="4">周辺</OPTION>
              <OPTION value="5">内装</OPTION>
              <OPTION value="9">その他</OPTION>
              <OPTION value="10">玄関</OPTION>
              <OPTION value="11">居間</OPTION>
              <OPTION value="12">キッチン</OPTION>
              <OPTION value="13">寝室</OPTION>
              <OPTION value="14">子供部屋</OPTION>
              <OPTION value="15">風呂</OPTION>
            </SELECT>
            <input type="text" id="img_comment9" name="img_comment9" value="<?=$img_comment9?>" onFocus='Text("img_comment9", 1)' onBlur='Text("img_comment9", 2)' style="width:250px;" />
            <input type="file" id="img_org9" name="img_org9" onFocus='Text("img_org9", 1)' onBlur='Text("img_org9", 2)' style="width:100px;" />
          </td>
        </tr>
        <tr>
          <th class="must">画像１０</th>
          <td>
            <SELECT name="img_type10">
<?=$img_type10_value?>
              <OPTION value="1">間取り</OPTION>
              <OPTION value="2">外観</OPTION>
              <OPTION value="3">地図</OPTION>
              <OPTION value="4">周辺</OPTION>
              <OPTION value="5">内装</OPTION>
              <OPTION value="9">その他</OPTION>
              <OPTION value="10">玄関</OPTION>
              <OPTION value="11">居間</OPTION>
              <OPTION value="12">キッチン</OPTION>
              <OPTION value="13">寝室</OPTION>
              <OPTION value="14">子供部屋</OPTION>
              <OPTION value="15">風呂</OPTION>
            </SELECT>
            <input type="text" id="img_comment10" name="img_comment10" value="<?=$img_comment10?>" onFocus='Text("img_comment10", 1)' onBlur='Text("img_comment10", 2)' style="width:250px;" />
            <input type="file" id="img_org10" name="img_org10" onFocus='Text("img_org10", 1)' onBlur='Text("img_org10", 2)' style="width:100px;" />
          </td>
        </tr>
      </table>
    </div>
    <div align="center">
      <table width="500">
        <tr>
          <td align="center" valign="top">
            <input type="submit" value="登録する" class="btn_nosize" onClick="return BuildInputCheck( this.form , this.form )" style="width:150px;" />
            <input type="hidden" name="mode" value="<?=$_POST['mode']?>" />
            <input type="hidden" name="estate_id" value="<?=$estate_id?>" />
            <input type="hidden" name="estate_clid" value="<?=$_SESSION['_cl_id']?>" />
            <input type="hidden" name="estate_upddate" value="<?=$estate_upddate?>" />
            <INPUT type="hidden" name="stpos" value="<?=$_POST['stpos']?>" />
            <INPUT type="hidden" name="search_flg" value="<?=$_POST['search_flg']?>" />
            <INPUT type="hidden" name="search_estate_name" value="<?=$_POST['search_estate_name']?>" />
            <INPUT type="hidden" name="search_address" value="<?=$_POST['search_address']?>" />
          </td>
          </form>
<?=$strViewDelForm?>
          <form method="POST" action="build_main.php">
          <td align="center" valign="top">
            <input type="submit" name="bak" value="戻る" class="btn_nosize" style="width:150px;" />
            <INPUT type="hidden" name="stpos" value="<?=$_POST['stpos']?>" />
            <INPUT type="hidden" name="search_flg" value="<?=$_POST['search_flg']?>" />
            <INPUT type="hidden" name="search_estate_name" value="<?=$_POST['search_estate_name']?>" />
            <INPUT type="hidden" name="search_address" value="<?=$_POST['search_address']?>" />
          </td>
          </form>
        </tr>
      </table>
      <form name="randmark" method="POST" action="../randmark/randmark_main.php" target="_blank">
        <INPUT type="hidden" name="estate_id" value="<?=$estate_id?>" />
      </form>
<form action="GoogleMapStop.php" method="POST">
  <input type="hidden" id="mapX" name="estate_keido" value="<?=$estate_keido?>"/>
  <input type="hidden" id="mapY" name="estate_ido" value="<?=$estate_ido?>"/>
  <input type="hidden" id="zoomN" name="estate_zoom" value="<?=$estate_zoom?>"/><BR>
  <input type="hidden" id="marker_flg" name="mkr_flg" value=""/><BR>
</form>
    </div>
  </body>
</HTML>
