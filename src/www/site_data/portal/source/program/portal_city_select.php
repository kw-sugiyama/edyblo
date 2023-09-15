<?

require_once ( "./ini_sets_1.php" );
require_once ( SYS_PATH."dbif/dbcom_DBconnectClass.php" );
require_once ( SYS_PATH."dbif/dbcom_DBconnectMstClass.php" );
require_once ( SYS_PATH."dbif/mstdb_ZipcodeClass.php" );
require_once ( SYS_PATH."dbif/viewdb_SearchPrefClass.php" );
require_once ( SYS_PATH."common/base_common.php" );
require_once ( SYS_PATH."common/sys_common.php" );
require_once ( SYS_PATH."common/error.class.php" );

/*----------------------------------------------------------
  £Ä£ÂÀÜÂ³
----------------------------------------------------------*/
require_once( SYS_PATH."common/db_connect.php" );
require_once( SYS_PATH."common/db_connect_mst.php" );

if( $_GET['prefcd'] != "" ){

	// viewdb_SearchPrefClass.php
	/*=======================================================
	    »Ô¡¡¸¡º÷½èÍı
	=======================================================*/
	$obj_scity = new viewdb_SPrefClassTblAccess;
	$obj_scity->conn = $obj_conn->conn;
	$obj_scity->jyoken = array(); 
	$obj_scity->jyoken['ar_prefcd'] = $_GET['prefcd'];
	$obj_scity->jyoken["cl_stat"] = 1;
	$obj_scity->jyoken["cl_pstat"] = 1;
	$obj_scity->jyoken["cl_start"] = 1;
	$obj_scity->jyoken["cl_end"] = 1;
	$obj_scity->jyoken["cl_deldate"] = 1;
	$obj_scity->jyoken["sc_stat"] = 1;
	$obj_scity->sort["ar_citycd"] = 1;
	$ret = $obj_scity->viewdb_GetSCity( 1 , -1);

	$city_list = '<select name="pf[]" class="inputarea2">'."\n";
	$city_list .= '<option value="">»ØÄê¤·¤Ê¤¤</option>'."\n";
	foreach( $obj_scity->sprefdat as $key => $val ){
		$selected = "";
		if( $_GET['citycd'] == $obj_scity->sprefdat[$key]['ar_citycd'] ) $selected = ' selected="selected"';

		$city_list .= '<option value="'.$obj_scity->sprefdat[$key]['ar_citycd'].'"'.$selected.'>'.mb_convert_encoding( $obj_scity->sprefdat[$key]['ar_city'], "EUC-JP", "EUC-JP" ).'</option>'."\n";
	}
	$city_list .= "</select>\n";


/*
	//Á´¤Æ¤Î»Ô¶èÄ®Â¼¤òÉ½¼¨
	$obj_citysearch = new mstdb_ZipcodeClassTblAccess;
	$obj_citysearch->conn = $obj_conn->conn;
	
	$obj_citysearch->jyoken["zp_prefcd"] = $_GET['prefcd']; 
	$obj_citysearch->jyoken["distinct"] = 1;
	$obj_citysearch->sort["zip"] = "asc";
	$obj_citysearch->mstdb_GetZipcode( 1 , -1);

	$city_list = '<select name="pf[]" class="inputarea2">';
	foreach( $obj_citysearch->zipdat as $key => $val ){
		$city_list .= '<option value="'.mb_convert_encoding( $obj_citysearch->zipdat[$key]['zp_citycd'],"UTF-8","EUC-JP" ).'">'.mb_convert_encoding( $obj_citysearch->zipdat[$key]['zp_city'], "UTF-8", "EUC-JP" ).'</option>';
	}
	$city_list .= "</select>";
*/
}else{

	$city_list = '<select name="pf[]" class="inputarea2">'."\n";

	$city_list .= '<option value="">»Ô¶èÄ®Â¼</option>'."\n";

	$city_list .= "</select>\n";
}

echo $city_list;

?>