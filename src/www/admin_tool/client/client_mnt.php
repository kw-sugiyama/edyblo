<?
/******************************************************************************
<< ��ư���֥���Ver.1.O.0 >>
	Name: client_mnt.php
	Version: 1.0.0
	Function: ���饤�������Ͽ����������
	Author: Click inc
	Date of creation: 2007/02
	History of modification:

	Copyright (C)2007 Click, inc. All Rights Reserverd.
******************************************************************************/

/*----------------------------------------------------------
  ɬ�ץե�����ƤӽФ�
----------------------------------------------------------*/
require_once ( "../ini_sets_2.php" );
require_once ( SYS_PATH."dbif/dbcom_DBconnectClass.php" );
require_once ( SYS_PATH."dbif/basedb_AdminClass.php" );
require_once ( SYS_PATH."dbif/basedb_AreaClass.php" );
require_once ( SYS_PATH."dbif/basedb_ClientClass.php" );
require_once ( SYS_PATH."common/error.class.php" );
require_once ( SYS_PATH."common/sys_common.php" );
require_once ( SYS_PATH."configs/param_base.conf" );


/*----------------------------------------------------------
  ���å������Ͽ����
----------------------------------------------------------*/
session_start();


/*----------------------------------------------------------
  ���顼���饹 - ���󥹥���
----------------------------------------------------------*/
$obj_error = new DispErrMessage();


/*----------------------------------------------------------
  �ģ���³
----------------------------------------------------------*/
require_once( SYS_PATH."common/db_connect.php" );


/*----------------------------------------------------------
  �������������å�
----------------------------------------------------------*/
require_once("../login_chk.php");


/*--------------------------------------------------------
	������ʬ
--------------------------------------------------------*/
$strMode = htmlspecialchars( $_POST["mode"] );
$cl_id = $_POST["cl_id"];

// POST�ͤ�����
$arrPostView = Array();
FOREACH( $_POST as $key => $val ){
	$arrPostView[$key] = htmlspecialchars( stripslashes( $val ) );
}

// "err_mode" or "mode" �ˤ������ѹ�
IF( $_POST["err_mode"] == "ERR" ){
	
	// URL�ѥ�����
	if( $arrPostView['cl_id'] != '' ){
		if($arrPostView["cl_dokuji_flg"]==1){
			$cl_url_code_dis = " disabled=\"disabled\"";
		}
	}

	// ���顼������֤��ͤ�ɽ��
	if( $arrPostView["cl_stat"] == 1 ){
		$stat_1 = " checked";
	}elseif( $arrPostView["cl_stat"] == 9 ){
		$stat_9 = " checked";
	}
	if( $arrPostView["cl_pstat"] == 1 ){
		$cl_pstat_1 = " checked";
	}elseif( $arrPostView["cl_pstat"] == 9 ){
		$cl_pstat_9 = " checked";
	}else{
		$cl_pstat_1 = " checked";
	}
	if( $arrPostView["cl_dokuji_flg"] == 1 ){
		$cl_dokuji_flg_1 = " checked";
	}elseif( $arrPostView["cl_dokuji_flg"] == 9 ){
		$cl_dokuji_flg_9 = " checked";
	}else{
		$cl_dokuji_flg_9 = " checked";
	}
	if( $arrPostView["cl_advertisement_flg"] == 1 ){
		$cl_advertisement_flg_1 = " checked";
	}elseif( $arrPostView["cl_advertisement_flg"] == 9 ){
		$cl_advertisement_flg_9 = " checked";
	}else{
		$cl_advertisement_flg_9 = " checked";
	}

	if( $arrPostView["cl_mobile_flg"] == 1 ){
		$cl_mobile_flg_1= " checked";
	}elseif( $arrPostView["cl_mobile_flg"] == 9 ){
		$cl_mobile_flg_9= " checked";
	}else{
		$cl_mobile_flg_9= " checked";
	}
	
	if( $arrPostView["cl_mobile_dokuji_flg"] == 1 ){
		$cl_mobile_dokuji_flg_1 = " checked";
	}elseif( $arrPostView["cl_mobile_dokuji_flg"] == 9 ){
		$cl_mobile_dokuji_flg_9 = " checked";
	}else{
		$cl_mobile_dokuji_flg_9 = " checked";
	}

	if( $arrPostView["cl_smartphone_flg"] == 1 ){
		$cl_smartphone_flg_1= " checked";
	}elseif( $arrPostView["cl_smartphone_flg"] == 9 ){
		$cl_smartphone_flg_9= " checked";
	}else{
		$cl_smartphone_flg_9= " checked";
	}

	IF( $arrPostView["cl_start"] != "" ){
		$arrStartDate = explode( "-" , $arrPostView["cl_start"] );
		$arrPostView["cl_start_y"] = $arrStartDate[0];
		$arrPostView["cl_start_m"] = $arrStartDate[1];
		$arrPostView["cl_start_d"] = $arrStartDate[2];
	}
	IF( $arrPostView["cl_end"] != "" ){
		$arrLimitDate = explode( "-" , $arrPostView["cl_end"] );
		$arrPostView["cl_end_y"] = $arrLimitDate[0];
		$arrPostView["cl_end_m"] = $arrLimitDate[1];
		$arrPostView["cl_end_d"] = $arrLimitDate[2];
	}

	$obj_area->areadat[0]["ar_pref"] = $arrPostView["ar_pref"];
	$obj_area->areadat[0]["ar_city"] = $arrPostView["ar_city"];
	$obj_area->areadat[0]["ar_add"] = $arrPostView["ar_add"];
	$obj_area->areadat[0]["ar_estate"] = $arrPostView["ar_estate"];
	$obj_area->areadat[0]["ar_citycd"] = $arrPostView["ar_citycd"];
	$obj_area->areadat[0]["ar_prefcd"] = $arrPostView["ar_prefcd"];

	$obj_area1->areadat[0]["ar_pref"] = $arrPostView["ar_pref1"];
	$obj_area1->areadat[0]["ar_city"] = $arrPostView["ar_city1"];
	$obj_area1->areadat[0]["ar_add"] = $arrPostView["ar_add1"];
	$obj_area1->areadat[0]["ar_estate"] = $arrPostView["ar_estate1"];
	$obj_area1->areadat[0]["ar_citycd"] = $arrPostView["ar_citycd1"];
	$obj_area1->areadat[0]["ar_prefcd"] = $arrPostView["ar_prefcd1"];

	$obj_area2->areadat[0]["ar_pref"] = $arrPostView["ar_pref2"];
	$obj_area2->areadat[0]["ar_city"] = $arrPostView["ar_city2"];
	$obj_area2->areadat[0]["ar_add"] = $arrPostView["ar_add2"];
	$obj_area2->areadat[0]["ar_estate"] = $arrPostView["ar_estate2"];
	$obj_area2->areadat[0]["ar_citycd"] = $arrPostView["ar_citycd2"];
	$obj_area2->areadat[0]["ar_prefcd"] = $arrPostView["ar_prefcd2"];

	$obj_area3->areadat[0]["ar_pref"] = $arrPostView["ar_pref3"];
	$obj_area3->areadat[0]["ar_city"] = $arrPostView["ar_city3"];
	$obj_area3->areadat[0]["ar_add"] = $arrPostView["ar_add3"];
	$obj_area3->areadat[0]["ar_estate"] = $arrPostView["ar_estate3"];
	$obj_area3->areadat[0]["ar_citycd"] = $arrPostView["ar_citycd3"];
	$obj_area3->areadat[0]["ar_prefcd"] = $arrPostView["ar_prefcd3"];

	
	// ����ܥ��������
	$strDelTag = "";
	$strDelTag .= "          <form action=\"client_upd.php\" method=\"POST\" name=\"del_form\">\n";
	$strDelTag .= "          <td align=\"center\" valign=\"top\">\n";
	$strDelTag .= "            <input type=\"button\" value=\"�������\" class=\"btn_nosize\" onclick=\"ClientDeleteCheck( document.admin , this.form )\" />\n";
	$strDelTag .= "            <input type=\"hidden\" name=\"mode\" value=\"DEL\" />\n";
	$strDelTag .= "            <input type=\"hidden\" name=\"cl_id\" value=\"{$arrPostView['cl_id']}\" />\n";
	$strDelTag .= "		   <INPUT type=\"hidden\" name=\"stpos\" value=\"{$arrPostView['stpos']}\" />\n";
	$strDelTag .= "		   <INPUT type=\"hidden\" name=\"sea_cl_name_like\" value=\"{$arrPostView['sea_cl_name_like']}\" />\n";
	$strDelTag .= "            <INPUT type=\"hidden\" name=\"sea_cl_pref\" value=\"{$arrPostView['sea_cl_pref']}\" />\n";
	$strDelTag .= "            <INPUT type=\"hidden\" name=\"sea_cl_stat\" value=\"{$arrPostView['sea_cl_stat']}\" />\n";
	$strDelTag .= "            <INPUT type=\"hidden\" name=\"sea_cl_dokuji_flg\" value=\"{$arrPostView['sea_cl_dokuji_flg']}\" />\n";
	$strDelTag .= "            <INPUT type=\"hidden\" name=\"sea_cl_advertisement_flg\" value=\"{$arrPostView['sea_cl_advertisement_flg']}\" />\n";
	$strDelTag .= "            <INPUT type=\"hidden\" name=\"sea_cl_start_date_s_y\" value=\"{$arrPostView['sea_cl_start_date_s_y']}\" />\n";
	$strDelTag .= "            <INPUT type=\"hidden\" name=\"sea_cl_start_date_s_m\" value=\"{$arrPostView['sea_cl_start_date_s_m']}\" />\n";
	$strDelTag .= "            <INPUT type=\"hidden\" name=\"sea_cl_start_date_s_d\" value=\"{$arrPostView['sea_cl_start_date_s_d']}\" />\n";
	$strDelTag .= "            <INPUT type=\"hidden\" name=\"sea_cl_start_date_e_y\" value=\"{$arrPostView['sea_cl_start_date_e_y']}\" />\n";
	$strDelTag .= "            <INPUT type=\"hidden\" name=\"sea_cl_start_date_e_m\" value=\"{$arrPostView['sea_cl_start_date_e_m']}\" />\n";
	$strDelTag .= "            <INPUT type=\"hidden\" name=\"sea_cl_start_date_e_d\" value=\"{$arrPostView['sea_cl_start_date_e_d']}\" />\n";
	$strDelTag .= "            <INPUT type=\"hidden\" name=\"sea_cl_limit_date_s_y\" value=\"{$arrPostView['sea_cl_limit_date_s_y']}\" />\n";
	$strDelTag .= "            <INPUT type=\"hidden\" name=\"sea_cl_limit_date_s_m\" value=\"{$arrPostView['sea_cl_limit_date_s_m']}\" />\n";
	$strDelTag .= "            <INPUT type=\"hidden\" name=\"sea_cl_limit_date_s_d\" value=\"{$arrPostView['sea_cl_limit_date_s_d']}\" />\n";
	$strDelTag .= "            <INPUT type=\"hidden\" name=\"sea_cl_limit_date_e_y\" value=\"{$arrPostView['sea_cl_limit_date_e_y']}\" />\n";
	$strDelTag .= "            <INPUT type=\"hidden\" name=\"sea_cl_limit_date_e_m\" value=\"{$arrPostView['sea_cl_limit_date_e_m']}\" />\n";
	$strDelTag .= "            <INPUT type=\"hidden\" name=\"sea_cl_limit_date_e_d\" value=\"{$arrPostView['sea_cl_limit_date_e_d']}\" />\n";
	$strDelTag .= "            <INPUT type=\"hidden\" name=\"search_flg\" value=\"{$arrPostView['search_flg']}\" />\n";
	$strDelTag .= "            <input type=\"hidden\" name=\"cl_upd_date\" value=\"{$cl_upd_date}\" />\n";
	$strDelTag .= "          </td>\n";
	$strDelTag .= "          </form>\n";
	
}ELSEIF( $strMode == "EDIT" ){
	
	// ���ꥯ�饤�����ID�򸡺�
	$obj2 = new basedb_ClientClassTblAccess;
	$obj2->conn = $obj_conn->conn;
	$obj2->jyoken["cl_id"] = intval( $cl_id );
	$obj2->jyoken["cl_deldate"] = 1;
	list( $num , $total ) = $obj2->basedb_GetClient( 1 , -1 );
	IF( $num != 1 ){
//echo("a");
		$obj_error->ViewErrMessage( "SYSTEM" , "ALL" , "client_main.php" , NULL );
		exit;
	}
	
	// DB������ͤ�$arrPostView���������
	FOREACH( $obj2->clientdat[0] as $key => $val ){
		$arrPostView[$key] = htmlspecialchars( stripslashes( $val ) );
	}
	
	// URL�ѥ�����
	if($arrPostView["cl_dokuji_flg"]==1){
		$cl_url_code_dis = " disabled=\"disabled\"";
	}

	// ���ͤ��Ѵ�
	if( $arrPostView["cl_stat"] == 1 ){
		$stat_1 = " checked";
	}elseif( $arrPostView["cl_stat"] == 9 ){
		$stat_9 = " checked";
	}
	if( $arrPostView["cl_pstat"] == 1 ){
		$cl_pstat_1 = " checked";
	}elseif( $arrPostView["cl_pstat"] == 9 ){
		$cl_pstat_9 = " checked";
	}else{
		$cl_pstat_1 = " checked";
	}
	if( $arrPostView["cl_dokuji_flg"] == 1 ){
		$cl_dokuji_flg_1 = " checked";
	}elseif( $arrPostView["cl_dokuji_flg"] == 9 ){
		$cl_dokuji_flg_9 = " checked";
	}else{
		$cl_dokuji_flg_9 = " checked";
	}
	if( $arrPostView["cl_advertisement_flg"] == 1 ){
		$cl_advertisement_flg_1 = " checked";
	}elseif( $arrPostView["cl_advertisement_flg"] == 9 ){
		$cl_advertisement_flg_9 = " checked";
	}else{
		$cl_advertisement_flg_9 = " checked";
	}

	if( $arrPostView["cl_mobile_flg"] == 1 ){
		$cl_mobile_flg_1= " checked";
	}elseif( $arrPostView["cl_mobile_flg"] == 9 ){
		$cl_mobile_flg_9= " checked";
	}else{
		$cl_mobile_flg_9= " checked";
	}

	if( $arrPostView["cl_mobile_dokuji_flg"] == 1 ){
		$cl_mobile_dokuji_flg_1 = " checked";
	}elseif( $arrPostView["cl_mobile_dokuji_flg"] == 9 ){
		$cl_mobile_dokuji_flg_9 = " checked";
	}else{
		$cl_mobile_dokuji_flg_9 = " checked";
	}

	if( $arrPostView["cl_smartphone_flg"] == 1 ){
		$cl_smartphone_flg_1= " checked";
	}elseif( $arrPostView["cl_smartphone_flg"] == 9 ){
		$cl_smartphone_flg_9= " checked";
	}else{
		$cl_smartphone_flg_9= " checked";
	}
	
//	$zipcode = split( "-" , $arrPostView["cl_zip"] );
//	$arrPostView["cl_zip1"] = $zipcode[0];
//	$arrPostView["cl_zip2"] = $zipcode[1];
	IF( $arrPostView["cl_start"] != "" ){
		$arrStartDate = explode( "-" , $arrPostView["cl_start"] );
		$arrPostView["cl_start_y"] = $arrStartDate[0];
		$arrPostView["cl_start_m"] = $arrStartDate[1];
		$arrPostView["cl_start_d"] = $arrStartDate[2];
	}
	IF( $arrPostView["cl_end"] != "" ){
		$arrLimitDate = explode( "-" , $arrPostView["cl_end"] );
		$arrPostView["cl_end_y"] = $arrLimitDate[0];
		$arrPostView["cl_end_m"] = $arrLimitDate[1];
		$arrPostView["cl_end_d"] = $arrLimitDate[2];
	}
	
	// ����ܥ��������
	$strDelTag = "";
	$strDelTag .= "          <form action=\"client_upd.php\" method=\"POST\" name=\"del_form\">\n";
	$strDelTag .= "          <td align=\"center\" valign=\"top\">\n";
	$strDelTag .= "            <input type=\"button\" value=\"�������\" class=\"btn_nosize\" onclick=\"ClientDeleteCheck( document.admin , this.form )\" />\n";
	$strDelTag .= "            <input type=\"hidden\" name=\"mode\" value=\"DEL\" />\n";
	$strDelTag .= "            <input type=\"hidden\" name=\"cl_id\" value=\"{$arrPostView['cl_id']}\" />\n";
	$strDelTag .= "		   <INPUT type=\"hidden\" name=\"stpos\" value=\"{$arrPostView['stpos']}\" />\n";
	$strDelTag .= "		   <INPUT type=\"hidden\" name=\"sea_cl_name_like\" value=\"{$arrPostView['sea_cl_name_like']}\" />\n";
	$strDelTag .= "            <INPUT type=\"hidden\" name=\"sea_cl_pref\" value=\"{$arrPostView['sea_cl_pref']}\" />\n";
	$strDelTag .= "            <INPUT type=\"hidden\" name=\"sea_cl_stat\" value=\"{$arrPostView['sea_cl_stat']}\" />\n";
	$strDelTag .= "            <INPUT type=\"hidden\" name=\"sea_cl_start_date_s_y\" value=\"{$arrPostView['sea_cl_start_date_s_y']}\" />\n";
	$strDelTag .= "            <INPUT type=\"hidden\" name=\"sea_cl_start_date_s_m\" value=\"{$arrPostView['sea_cl_start_date_s_m']}\" />\n";
	$strDelTag .= "            <INPUT type=\"hidden\" name=\"sea_cl_start_date_s_d\" value=\"{$arrPostView['sea_cl_start_date_s_d']}\" />\n";
	$strDelTag .= "            <INPUT type=\"hidden\" name=\"sea_cl_start_date_e_y\" value=\"{$arrPostView['sea_cl_start_date_e_y']}\" />\n";
	$strDelTag .= "            <INPUT type=\"hidden\" name=\"sea_cl_start_date_e_m\" value=\"{$arrPostView['sea_cl_start_date_e_m']}\" />\n";
	$strDelTag .= "            <INPUT type=\"hidden\" name=\"sea_cl_start_date_e_d\" value=\"{$arrPostView['sea_cl_start_date_e_d']}\" />\n";
	$strDelTag .= "            <INPUT type=\"hidden\" name=\"sea_cl_limit_date_s_y\" value=\"{$arrPostView['sea_cl_limit_date_s_y']}\" />\n";
	$strDelTag .= "            <INPUT type=\"hidden\" name=\"sea_cl_limit_date_s_m\" value=\"{$arrPostView['sea_cl_limit_date_s_m']}\" />\n";
	$strDelTag .= "            <INPUT type=\"hidden\" name=\"sea_cl_limit_date_s_d\" value=\"{$arrPostView['sea_cl_limit_date_s_d']}\" />\n";
	$strDelTag .= "            <INPUT type=\"hidden\" name=\"sea_cl_limit_date_e_y\" value=\"{$arrPostView['sea_cl_limit_date_e_y']}\" />\n";
	$strDelTag .= "            <INPUT type=\"hidden\" name=\"sea_cl_limit_date_e_m\" value=\"{$arrPostView['sea_cl_limit_date_e_m']}\" />\n";
	$strDelTag .= "            <INPUT type=\"hidden\" name=\"sea_cl_limit_date_e_d\" value=\"{$arrPostView['sea_cl_limit_date_e_d']}\" />\n";
	$strDelTag .= "            <INPUT type=\"hidden\" name=\"search_flg\" value=\"{$arrPostView['search_flg']}\" />\n";
	$strDelTag .= "            <input type=\"hidden\" name=\"cl_upd_date\" value=\"{$cl_upd_date}\" />\n";
	$strDelTag .= "          </td>\n";
	$strDelTag .= "          </form>\n";
	
	// ���ꥯ�饤�����ID�򸡺�
	$obj_area = new basedb_AreaClassTblAccess;
	$obj_area->conn = $obj_conn->conn;
	$obj_area->jyoken["ar_clid"] = intval( $cl_id );
	$obj_area->jyoken["ar_flg"] = 1;
	list( $areanum , $areatotal ) = $obj_area->basedb_GetArea( 1 , -1 );
	IF( $areanum == -1 ){
//echo("b");
		$obj_error->ViewErrMessage( "SYSTEM" , "ALL" , "client_main.php" , NULL );
		exit;
	}
	$zipcode = split( "-" , $obj_area->areadat[0]['ar_zip'] );
	$arrPostView["ar_zip1"] = $zipcode[0];
	$arrPostView["ar_zip2"] = $zipcode[1];

	// ���ꥢ��
	$obj_area1 = new basedb_AreaClassTblAccess;
	$obj_area1->conn = $obj_conn->conn;
	$obj_area1->jyoken["ar_clid"] = intval( $cl_id );
	$obj_area1->jyoken["ar_flg"] = 2;
	list( $areanum1 , $areatotal1 ) = $obj_area1->basedb_GetArea( 1 , -1 );
	IF( $areanum1 == -1 ){
//echo("c");
		$obj_error->ViewErrMessage( "SYSTEM" , "ALL" , "client_main.php" , NULL );
		exit;
	}
	$zipcode1 = split( "-" , $obj_area1->areadat[0]['ar_zip'] );
	$arrPostView["ar_zip1_1"] = $zipcode1[0];
	$arrPostView["ar_zip1_2"] = $zipcode1[1];

	// ���ꥢ��
	$obj_area2 = new basedb_AreaClassTblAccess;
	$obj_area2->conn = $obj_conn->conn;
	$obj_area2->jyoken["ar_clid"] = intval( $cl_id );
	$obj_area2->jyoken["ar_flg"] = 3;
	list( $areanum2 , $areatotal2 ) = $obj_area2->basedb_GetArea( 1 , -1 );
	IF( $areanum2 == -1 ){
//echo("d");
		$obj_error->ViewErrMessage( "SYSTEM" , "ALL" , "client_main.php" , NULL );
		exit;
	}
	$zipcode2 = split( "-" , $obj_area2->areadat[0]['ar_zip'] );
	$arrPostView["ar_zip2_1"] = $zipcode2[0];
	$arrPostView["ar_zip2_2"] = $zipcode2[1];

	// ���ꥢ��
	$obj_area3 = new basedb_AreaClassTblAccess;
	$obj_area3->conn = $obj_conn->conn;
	$obj_area3->jyoken["ar_clid"] = intval( $cl_id );
	$obj_area3->jyoken["ar_flg"] = 4;
	list( $areanum3 , $areatotal3 ) = $obj_area3->basedb_GetArea( 1 , -1 );
	IF( $areanum3 == -1 ){
//echo("e");
		$obj_error->ViewErrMessage( "SYSTEM" , "ALL" , "client_main.php" , NULL );
		exit;
	}
	$zipcode3 = split( "-" , $obj_area3->areadat[0]['ar_zip'] );
	$arrPostView["ar_zip3_1"] = $zipcode3[0];
	$arrPostView["ar_zip3_2"] = $zipcode3[1];

}


/*----------------------------------------------------------
  �ģ�����
----------------------------------------------------------*/
require_once( SYS_PATH."common/db_close.php" );


/*--------------------------------------------------------
	ɽ���ꥹ�ȹ��ܺ���
--------------------------------------------------------*/
$lsy_base = date("Y");
$lsy = $lsy_base - 3;
$ley = $lsy_base + 3;
// ͭ�����³���(ǯ)
FOR( $iX=$lsy; $iX<$ley; $iX++ ){
	$strSel = "";
	IF( $iX == intval( $arrPostView["cl_start_y"]) ) $strSel = " selected";
	$start_y .= "              <OPTION value=\"{$iX}\"{$strSel}>{$iX}</OPTION>\n";
}


// ͭ�����³���(��)
$start_m = "";
FOR( $iX=1; $iX<13; $iX++ ){
	$strSel = "";
	IF( $iX == intval($arrPostView["cl_start_m"]) ) $strSel = " selected";
	$start_m .= "              <OPTION value=\"{$iX}\"{$strSel}>{$iX}</OPTION>\n";
}


// ͭ�����³���(��)
$start_d = "";
FOR( $iX=1; $iX<32; $iX++ ){
	$strSel = "";
	IF( $iX == intval($arrPostView["cl_start_d"]) ) $strSel = " selected";
	$start_d .= "              <OPTION value=\"{$iX}\"{$strSel}>{$iX}</OPTION>\n";
}


// ͭ�����½�λ(ǯ)
$limit_y = "";
FOR( $iX=$lsy; $iX<$ley; $iX++ ){
	$strSel = "";
	IF( $iX == intval($arrPostView["cl_end_y"]) ) $strSel = " selected";
	$limit_y .= "              <OPTION value=\"{$iX}\"{$strSel}>{$iX}</OPTION>\n";
}

// ͭ�����½�λ(��)
$limit_m = "";
FOR( $iX=1; $iX<13; $iX++ ){
	$strSel = "";
	IF( $iX == intval($arrPostView["cl_end_m"]) ) $strSel = " selected";
	$limit_m .= "              <OPTION value=\"{$iX}\"{$strSel}>{$iX}</OPTION>\n";
}

// ͭ�����½�λ(��)
$limit_d = "";
FOR( $iX=1; $iX<32; $iX++ ){
	$strSel = "";
	IF( $iX == intval($arrPostView["cl_end_d"]) ) $strSel = " selected";
	$limit_d .= "              <OPTION value=\"{$iX}\"{$strSel}>{$iX}</OPTION>\n";
}


/*=================================================
    �ȣԣͣ�ɽ��
=================================================*/
?>
<HTML>
  <HEAD>
    <TITLE>�Υ֥� - ��������ȴ����ġ���</TITLE>
    <META http-equiv="Content-Type" content="text/html;charset=EUC-JP" />
    <META http-equiv="Content-Style-Type" content="text/css" />
    <META http-equiv="Content-Script-Type" content="text/javascript" />
    <LINK rel="stylesheet" type="text/css" href="../share/css/client.css" />
    <SCRIPT type="text/javascript" src="../share/js/client.js"></SCRIPT>
    <SCRIPT type="text/javascript" src="../share/js/input_check.js"></SCRIPT>
    <NOSCRIPT><META http-equiv="Refresh" content="1;URL=../jserror.html"></NOSCRIPT>
  </HEAD>
  <BODY>
    <div align="center">
      <table id="client" cellspacing="0">
        <tr>
          <form action="client_upd.php" method="POST" name="client">
          <th class="must">����</th>
          <td>
            <input type="radio" name="cl_stat" value="1" id="kengen1"<?=$stat_1?> /><label for="kengen1">ͭ��</label>
            <input type="radio" name="cl_stat" value="9" id="kengen9"<?=$stat_9?> /><label for="kengen9">̵��</label>
          </td>
        </tr>
        <tr>
          <th class="must">�ݡ����륵����<BR>�Ǻ�/��Ǻ�</th>
          <td>
            <input type="radio" name="cl_pstat" value="1" id="cl_pstat_1"<?=$cl_pstat_1?> /><label for="cl_pstat_1">�Ǻ�</label>
            <input type="radio" name="cl_pstat" value="9" id="cl_pstat_9"<?=$cl_pstat_9?> /><label for="cl_pstat_9">��Ǻ�</label>
          </td>
        </tr>
        <tr>
          <th class="must">���ӥ�����<BR>ͭ��/̵��</th>
          <td>
            <input type="radio" name="cl_mobile_flg" value="1" id="cl_mobile_flg_1"<?=$cl_mobile_flg_1?> /><label for="cl_mobile_flg_1">ͭ��</label>
            <input type="radio" name="cl_mobile_flg" value="9" id="cl_mobile_flg_9"<?=$cl_mobile_flg_9?> /><label for="cl_mobile_flg_9">̵��</label>
          </td>
        </tr>
        <tr>
          <th class="must">���ޡ��ȥե��󥵥���<BR>ͭ��/̵��</th>
          <td>
            <input type="radio" name="cl_smartphone_flg" value="1" id="cl_smartphone_flg_1"<?=$cl_smartphone_flg_1?> /><label for="cl_smartphone_flg_1">ͭ��</label>
            <input type="radio" name="cl_smartphone_flg" value="9" id="cl_smartphone_flg_9"<?=$cl_smartphone_flg_9?> /><label for="cl_smartphone_flg_9">̵��</label>
          </td>
        </tr>
        <tr>
          <th class="must">��̾</th>
          <td><input id="i1" type="text" name="cl_jname" value="<?=$arrPostView["cl_jname"]?>" style="width:200px" maxlength="50" onFocus='Text("i1", 1)' onBlur='Text("i1", 2)' /></td>
        </tr>
        <tr>
          <th>����̾</th>
          <td><input id="i2" type="text" name="cl_kname" value="<?=$arrPostView["cl_kname"]?>" style="width:200px" maxlength="50" onFocus='Text("i2", 1)' onBlur='Text("i2", 2)' /></td>
        </tr>
        <tr>
          <th>ô����̾</th>
          <td><input id="i3" type="text" name="cl_agent" value="<?=$arrPostView["cl_agent"]?>" style="width:200px" maxlength="50" onFocus='Text("i3", 1)' onBlur='Text("i3", 2)' /></td>
        </tr>
        <tr>
          <th class="must">��������</th>
          <td>
	    <table class="zip"><tr>
	    <td class="zip" align="right" width="60px">��</td><td class="zip"><input id="i4_1" type="text" name="ar_zip1" value="<?=$arrPostView["ar_zip1"]?>" style="width:40px" maxlength="3" onFocus='Text("i4_1", 1)' onBlur='Text("i4_1", 2)' />
	    -<input id="i11_1" type="text" name="ar_zip2" value="<?=$arrPostView["ar_zip2"]?>" style="width:50px" maxlength="4" onFocus='Text("i11_1", 1)' onBlur='Text("i11_1", 2)' />
	    <input type="button" value="�������" onclick="return zipSearch()"></td>
	    </tr><tr>
            <td class="zip" align="right" width="60px">��ƻ�ܸ�</td><td class="zip"><input id="i12" type="text" name="ar_pref" value="<?=$obj_area->areadat[0]["ar_pref"]?>" maxlength="80" style="width:200px" readonly /><td>
	    </tr><tr>
            <td class="zip" align="right" width="60px">�Զ�Į¼</td><td class="zip"><input id="i13" type="text" name="ar_city" value="<?=$obj_area->areadat[0]["ar_city"]?>" maxlength="80" style="width:200px" readonly /></td>
	    </tr><tr>
            <td class="zip" align="right" width="60px">����</td><td class="zip"><input id="i14" type="text" name="ar_add" value="<?=$obj_area->areadat[0]["ar_add"]?>" maxlength="80" style="width:200px" onFocus='Text("i14", 1)' onBlur='Text("i14", 2)' /><font color="#ff0000">(�㡧���Ļ�1-16-2)</font><td>
	    </tr><tr>
            <td class="zip" align="right" width="60px">��ʪ̾</td><td class="zip"><input id="i15" type="text" name="ar_estate" value="<?=$obj_area->areadat[0]["ar_estate"]?>" maxlength="80" style="width:200px" onFocus='Text("i15", 1)' onBlur='Text("i15", 2)' /><font color="#ff0000">(�㡧SASAKI�ӥ�3F)</font></td>
	    </tr></table>
	  <input type="hidden" name="ar_prefcd" value="<?=$obj_area->areadat[0]["ar_prefcd"]?>">
	  <input type="hidden" name="ar_citycd" value="<?=$obj_area->areadat[0]["ar_citycd"]?>">
          </td>
        </tr>
        <tr>
          <th>���ꥢ��</th>
          <td>
	    <table class="zip"><tr>
	    <td class="zip" align="right" width="60px">��</td><td class="zip"><input id="i4_2" type="text" name="ar_zip1_1" value="<?=$arrPostView["ar_zip1_1"]?>" style="width:40px" maxlength="3" onFocus='Text("i4_2", 1)' onBlur='Text("i4_2", 2)' />
	    -<input id="i11_2" type="text" name="ar_zip1_2" value="<?=$arrPostView["ar_zip1_2"]?>" style="width:50px" maxlength="4" onFocus='Text("i11_2", 1)' onBlur='Text("i11_2", 2)' />
	    <input type="button" value="�������" onclick="return zipSearch1()"></td>
	    </tr><tr>
            <td class="zip" align="right" width="60px">��ƻ�ܸ�</td><td class="zip"><input id="i12" type="text" name="ar_pref1" value="<?=$obj_area1->areadat[0]["ar_pref"]?>" maxlength="80" style="width:200px" readonly /><td>
	    </tr><tr>
            <td class="zip" align="right" width="60px">�Զ�Į¼</td><td class="zip"><input id="i13" type="text" name="ar_city1" value="<?=$obj_area1->areadat[0]["ar_city"]?>" maxlength="80" style="width:200px" readonly /></td>
	    </tr></table>
	  <input id="i15" type="hidden" name="ar_estate1" value="<?=$obj_area1->areadat[0]["ar_estate"]?>" maxlength="80" style="width:200px" onFocus='Text("i15", 1)' onBlur='Text("i15", 2)' />
	  <input id="i14" type="hidden" name="ar_add1" value="<?=$obj_area1->areadat[0]["ar_add"]?>" maxlength="80" style="width:200px" onFocus='Text("i14", 1)' onBlur='Text("i14", 2)' />
	  <input type="hidden" name="ar_prefcd1" value="<?=$obj_area1->areadat[0]["ar_prefcd"]?>">
	  <input type="hidden" name="ar_citycd1" value="<?=$obj_area1->areadat[0]["ar_citycd"]?>">
          </td>
        </tr>
        <tr>
          <th>���ꥢ��</th>
          <td>
	    <table class="zip"><tr>
	    <td class="zip" align="right" width="60px">��</td><td class="zip"><input id="i4_3" type="text" name="ar_zip2_1" value="<?=$arrPostView["ar_zip2_1"]?>" style="width:40px" maxlength="3" onFocus='Text("i4_3", 1)' onBlur='Text("i4_3", 2)' />
	    -<input id="i11_3" type="text" name="ar_zip2_2" value="<?=$arrPostView["ar_zip2_2"]?>" style="width:50px" maxlength="4" onFocus='Text("i11_3", 1)' onBlur='Text("i11_3", 2)' />
	    <input type="button" value="�������" onclick="return zipSearch2()"></td>
	    </tr><tr>
            <td class="zip" align="right" width="60px">��ƻ�ܸ�</td><td class="zip"><input id="i12" type="text" name="ar_pref2" value="<?=$obj_area2->areadat[0]["ar_pref"]?>" maxlength="80" style="width:200px" readonly /><td>
	    </tr><tr>
            <td class="zip" align="right" width="60px">�Զ�Į¼</td><td class="zip"><input id="i13" type="text" name="ar_city2" value="<?=$obj_area2->areadat[0]["ar_city"]?>" maxlength="80" style="width:200px" readonly /></td>
	    </tr></table>
	  <input id="i15" type="hidden" name="ar_estate2" value="<?=$obj_area2->areadat[0]["ar_estate"]?>" maxlength="80" style="width:200px" onFocus='Text("i15", 1)' onBlur='Text("i15", 2)' />
	  <input id="i14" type="hidden" name="ar_add2" value="<?=$obj_area2->areadat[0]["ar_add"]?>" maxlength="80" style="width:200px" onFocus='Text("i14", 1)' onBlur='Text("i14", 2)' />
	  <input type="hidden" name="ar_prefcd2" value="<?=$obj_area2->areadat[0]["ar_prefcd"]?>">
	  <input type="hidden" name="ar_citycd2" value="<?=$obj_area2->areadat[0]["ar_citycd"]?>">
          </td>
        </tr>
        <tr>
          <th>���ꥢ��</th>
          <td>
	    <table class="zip"><tr>
	    <td class="zip" align="right" width="60px">��</td><td class="zip"><input id="i4_4" type="text" name="ar_zip3_1" value="<?=$arrPostView["ar_zip3_1"]?>" style="width:40px" maxlength="3" onFocus='Text("i4_4", 1)' onBlur='Text("i4_4", 2)' />
	    -<input id="i11_4" type="text" name="ar_zip3_2" value="<?=$arrPostView["ar_zip3_2"]?>" style="width:50px" maxlength="4" onFocus='Text("i11_4", 1)' onBlur='Text("i11_4", 2)' />
	    <input type="button" value="�������" onclick="return zipSearch3()"></td>
	    </tr><tr>
            <td class="zip" align="right" width="60px">��ƻ�ܸ�</td><td class="zip"><input id="i12" type="text" name="ar_pref3" value="<?=$obj_area3->areadat[0]["ar_pref"]?>" maxlength="80" style="width:200px" readonly /><td>
	    </tr><tr>
            <td class="zip" align="right" width="60px">�Զ�Į¼</td><td class="zip"><input id="i13" type="text" name="ar_city3" value="<?=$obj_area3->areadat[0]["ar_city"]?>" maxlength="80" style="width:200px" readonly /></td>
	    </tr></table>
	  <input id="i15" type="hidden" name="ar_estate3" value="<?=$obj_area3->areadat[0]["ar_estate"]?>" maxlength="80" style="width:200px" onFocus='Text("i15", 1)' onBlur='Text("i15", 2)' />
	  <input id="i14" type="hidden" name="ar_add3" value="<?=$obj_area3->areadat[0]["ar_add"]?>" maxlength="80" style="width:200px" onFocus='Text("i14", 1)' onBlur='Text("i14", 2)' />
	  <input type="hidden" name="ar_prefcd3" value="<?=$obj_area3->areadat[0]["ar_prefcd"]?>">
	  <input type="hidden" name="ar_citycd3" value="<?=$obj_area3->areadat[0]["ar_citycd"]?>">
          </td>
        </tr>
        <tr>
          <th>�����ԣţ�</th>
          <td><input id="i5" type="text" name="cl_phone" value="<?=$arrPostView["cl_phone"]?>" maxlength="15" style="width:200px" onFocus='Text("i5", 1)' onBlur='Text("i5", 2)' /><font color="#FF0000">(�㡧03-5772-7710)</font></td>
        </tr>
        <tr>
          <th>�����ƣ���</th>
          <td><input id="i6" type="text" name="cl_fax" value="<?=$arrPostView["cl_fax"]?>" maxlength="15" style="width:200px" onFocus='Text("i6", 1)' onBlur='Text("i6", 2)' /><font color="#FF0000">(�㡧03-5772-7720)</font></td>
        </tr>
        <tr>
          <th class="must">ô���ԣť᡼��</th>
          <td><input id="i7" type="text" name="cl_mail" value="<?=$arrPostView["cl_mail"]?>" maxlength="50" style="width:200px" onFocus='Text("i7", 1)' onBlur='Text("i7", 2)' /></td>
        </tr>
        <tr>
          <th class="must">������ID</th>
          <td><input id="i8" type="text" name="cl_loginid" value="<?=$arrPostView["cl_loginid"]?>" maxlength="15" style="width:200px" onFocus='Text("i8", 1)' onBlur='Text("i8", 2)' /><font color="#ff0000">��Ⱦ�ѱѿ��������ϡ�</font></td>
        </tr>
        <tr>
          <th class="must">�ѥ����</th>
          <td><input id="i9" type="text" name="cl_passwd" value="<?=$arrPostView["cl_passwd"]?>" maxlength="15" style="width:200px" onFocus='Text("i9", 1)' onBlur='Text("i9", 2)' /><font color="#ff0000">��Ⱦ�ѱѿ��������ϡ�</font></td>
        </tr>
        <tr>
          <th class="must">�գң��ѥ�����</th>
          <td><input type="text" id="i10" name="cl_urlcd" value="<?=$arrPostView["cl_urlcd"]?>" maxlength="25" style="width:200px" onFocus='Text("i10", 1)' onBlur='Text("i10", 2)' <?=$cl_url_code_dis?>/><INPUT type="button" value="��ʣ�����å�" onClick="return url_code_chk( this.form )"><br /><font color="#ff0000">��Ⱦ�Ѿ�ʸ���ѿ����ȡ� -�ʥϥ��ե�)�פΤߤ����ϡ�</font></td>
        </tr>
        <tr>
          <th class="must">�ȼ��ɥᥤ��<BR>��/�Բ�</th>
          <td>
            <input type="radio" name="cl_dokuji_flg" value="1" id="cl_dokuji_flg_1"<?=$cl_dokuji_flg_1?> /><label for="cl_dokuji_flg_1">��</label>
            <input type="radio" name="cl_dokuji_flg" value="9" id="cl_dokuji_flg_9"<?=$cl_dokuji_flg_9?> /><label for="cl_dokuji_flg_9">�Բ�</label>
          </td>
        </tr>
        <tr>
          <th>�ȼ���GoogleMap API Key</th>
          <td><input id="i1" type="text" name="cl_googlemap_key" value="<?=$arrPostView["cl_googlemap_key"]?>" style="width:450px" onFocus='Text("i1", 1)' onBlur='Text("i1", 2)' /></td>
        </tr>
        <tr>
          <th>�ȼ��ɥᥤ��</th>
          <td><input id="i1" type="text" name="cl_dokuji_domain" value="<?=$arrPostView["cl_dokuji_domain"]?>" style="width:450px" onFocus='Text("i1", 1)' onBlur='Text("i1", 2)' /><BR><font color="#ff0000">���㡧http://jukutown.com/��</font></td>
        </tr>
        <tr>
          <th class="must">�����ȼ��ɥᥤ��<BR>��/�Բ�</th>
          <td>
            <input type="radio" name="cl_mobile_dokuji_flg" value="1" id="cl_mobile_dokuji_flg_1"<?=$cl_mobile_dokuji_flg_1?> /><label for="cl_mobile_dokuji_flg_1">��</label>
            <input type="radio" name="cl_mobile_dokuji_flg" value="9" id="cl_mobile_dokuji_flg_9"<?=$cl_mobile_dokuji_flg_9?> /><label for="cl_mobile_dokuji_flg_9">�Բ�</label>
          </td>
        </tr>
        <tr>
          <th>�����ȼ���GoogleMap API Key</th>
          <td><input id="i1" type="text" name="cl_mobile_googlemap_key" value="<?=$arrPostView["cl_mobile_googlemap_key"]?>" style="width:450px" onFocus='Text("i1", 1)' onBlur='Text("i1", 2)' /></td>
        </tr>
        <tr>
          <th>�����ȼ��ɥᥤ��</th>
          <td><input id="i1" type="text" name="cl_mobile_dokuji_domain" value="<?=$arrPostView["cl_mobile_dokuji_domain"]?>" style="width:450px" onFocus='Text("i1", 1)' onBlur='Text("i1", 2)' /><BR><font color="#ff0000">���㡧http://m.jukutown.com/��</font></td>
        </tr>
        <tr>
          <th>ͭ������</th>
          <td>
            <select name="cl_start_y">
              <option value="">----</option>
<?=$start_y?>
            </select>
            ǯ
            <select name="cl_start_m">
              <option value="">--</option>
<?=$start_m?>
            </select>
            ��
            <select name="cl_start_d">
              <option value="">--</option>
<?=$start_d?>
            </select>
��
            <select name="cl_end_y">
              <option value="">----</option>
<?=$limit_y?>
            </select>
            ǯ
            <select name="cl_end_m">
              <option value="">--</option>
<?=$limit_m?>
            </select>
            ��
            <select name="cl_end_d">
              <option value="">--</option>
<?=$limit_d?>
            </select>
          </td>
        </tr>
        <tr>
          <th>������</th>
          <td><textarea id="i16" name="cl_biko" style="width:350px" rows="4" onFocus='Text("i16", 1)' onBlur='Text("i16", 2)' /><?=$arrPostView["cl_biko"]?></textarea></td>
        </tr>
        <tr>
          <th class="must">����Ǻ�</th>
          <td>
            <input type="radio" name="cl_advertisement_flg" value="1" id="cl_advertisement_flg_1"<?=$cl_advertisement_flg_1?> /><label for="cl_advertisement_flg_1">��</label>
            <input type="radio" name="cl_advertisement_flg" value="9" id="cl_advertisement_flg_9"<?=$cl_advertisement_flg_9?> /><label for="cl_advertisement_flg_9">�Բ�</label>
          </td>
        </tr>
        <tr>
          <th>���𥿥�</th>
          <td><textarea id="i17" name="cl_advertisement_tag" style="width:350px" rows="4" onFocus='Text("i17", 1)' onBlur='Text("i17", 2)' /><?=$arrPostView["cl_advertisement_tag"]?></textarea></td>
        </tr>
      </table>
      <br />
      <table>
        <tr>
          <td align="center" valign="top">
            <input type="button" value="��Ͽ����" class="btn_nosize" onclick="ClientInputCheck( this.form , this.form )" />
            <input type="hidden" name="mode" value="<?=$strMode?>" />
            <input type="hidden" name="cl_id" value="<?=$arrPostView["cl_id"]?>" />
            <input type="hidden" name="cl_upddate" value="<?=$arrPostView["cl_upddate"]?>" />
            <INPUT type="hidden" name="stpos" value="<?=$arrPostView["stpos"]?>" />
            <INPUT type="hidden" name="sea_cl_name_like" value="<?=$arrPostView['sea_cl_name_like']?>" />
            <INPUT type="hidden" name="sea_cl_pref" value="<?=$arrPostView['sea_cl_pref']?>" />
            <INPUT type="hidden" name="sea_cl_stat" value="<?=$arrPostView['sea_cl_stat']?>" />
            <INPUT type="hidden" name="sea_cl_dokuji_flg" value="<?=$arrPostView['sea_cl_dokuji_flg']?>" />
            <INPUT type="hidden" name="sea_cl_advertisement_flg" value="<?=$arrPostView['sea_cl_advertisement_flg']?>" />
            <INPUT type="hidden" name="sea_cl_start_date_s_y" value="<?=$arrPostView['sea_cl_start_date_s_y']?>" />
            <INPUT type="hidden" name="sea_cl_start_date_s_m" value="<?=$arrPostView['sea_cl_start_date_s_m']?>" />
            <INPUT type="hidden" name="sea_cl_start_date_s_d" value="<?=$arrPostView['sea_cl_start_date_s_d']?>" />
            <INPUT type="hidden" name="sea_cl_start_date_e_y" value="<?=$arrPostView['sea_cl_start_date_e_y']?>" />
            <INPUT type="hidden" name="sea_cl_start_date_e_m" value="<?=$arrPostView['sea_cl_start_date_e_m']?>" />
            <INPUT type="hidden" name="sea_cl_start_date_e_d" value="<?=$arrPostView['sea_cl_start_date_e_d']?>" />
            <INPUT type="hidden" name="sea_cl_limit_date_s_y" value="<?=$arrPostView['sea_cl_limit_date_s_y']?>" />
            <INPUT type="hidden" name="sea_cl_limit_date_s_m" value="<?=$arrPostView['sea_cl_limit_date_s_m']?>" />
            <INPUT type="hidden" name="sea_cl_limit_date_s_d" value="<?=$arrPostView['sea_cl_limit_date_s_d']?>" />
            <INPUT type="hidden" name="sea_cl_limit_date_e_y" value="<?=$arrPostView['sea_cl_limit_date_e_y']?>" />
            <INPUT type="hidden" name="sea_cl_limit_date_e_m" value="<?=$arrPostView['sea_cl_limit_date_e_m']?>" />
            <INPUT type="hidden" name="sea_cl_limit_date_e_d" value="<?=$arrPostView['sea_cl_limit_date_e_d']?>" />
            <INPUT type="hidden" name="search_flg" value="<?=$arrPostView['search_flg']?>" />
            <INPUT type="hidden" name="ar_id" value="<?=$obj_area->areadat[0]['ar_id']?>" />
            <INPUT type="hidden" name="ar_upddate" value="<?=$obj_area->areadat[0]['ar_upddate']?>" />
            <INPUT type="hidden" name="ar_id1" value="<?=$obj_area1->areadat[0]['ar_id']?>" />
            <INPUT type="hidden" name="ar_upddate1" value="<?=$obj_area1->areadat[0]['ar_upddate']?>" />
            <INPUT type="hidden" name="ar_id2" value="<?=$obj_area2->areadat[0]['ar_id']?>" />
            <INPUT type="hidden" name="ar_upddate2" value="<?=$obj_area2->areadat[0]['ar_upddate']?>" />
            <INPUT type="hidden" name="ar_id3" value="<?=$obj_area3->areadat[0]['ar_id']?>" />
            <INPUT type="hidden" name="ar_upddate3" value="<?=$obj_area3->areadat[0]['ar_upddate']?>" />
          </td>
          </form>
<?=$strDelTag?>
          <form method="POST" action="client_main.php">
          <td align="center" valign="top">
            <input type="submit" name="bak" value="���" class="btn_nosize" />
            <INPUT type="hidden" name="stpos" value="<?=$arrPostView['stpos']?>" />
            <INPUT type="hidden" name="sea_cl_name_like" value="<?=$arrPostView['sea_cl_name_like']?>" />
            <INPUT type="hidden" name="sea_cl_pref" value="<?=$arrPostView['sea_cl_pref']?>" />
            <INPUT type="hidden" name="sea_cl_stat" value="<?=$arrPostView['sea_cl_stat']?>" />
            <INPUT type="hidden" name="sea_cl_dokuji_flg" value="<?=$arrPostView['sea_cl_dokuji_flg']?>" />
            <INPUT type="hidden" name="sea_cl_advertisement_flg" value="<?=$arrPostView['sea_cl_advertisement_flg']?>" />
            <INPUT type="hidden" name="sea_cl_start_date_s_y" value="<?=$arrPostView['sea_cl_start_date_s_y']?>" />
            <INPUT type="hidden" name="sea_cl_start_date_s_m" value="<?=$arrPostView['sea_cl_start_date_s_m']?>" />
            <INPUT type="hidden" name="sea_cl_start_date_s_d" value="<?=$arrPostView['sea_cl_start_date_s_d']?>" />
            <INPUT type="hidden" name="sea_cl_start_date_e_y" value="<?=$arrPostView['sea_cl_start_date_e_y']?>" />
            <INPUT type="hidden" name="sea_cl_start_date_e_m" value="<?=$arrPostView['sea_cl_start_date_e_m']?>" />
            <INPUT type="hidden" name="sea_cl_start_date_e_d" value="<?=$arrPostView['sea_cl_start_date_e_d']?>" />
            <INPUT type="hidden" name="sea_cl_limit_date_s_y" value="<?=$arrPostView['sea_cl_limit_date_s_y']?>" />
            <INPUT type="hidden" name="sea_cl_limit_date_s_m" value="<?=$arrPostView['sea_cl_limit_date_s_m']?>" />
            <INPUT type="hidden" name="sea_cl_limit_date_s_d" value="<?=$arrPostView['sea_cl_limit_date_s_d']?>" />
            <INPUT type="hidden" name="sea_cl_limit_date_e_y" value="<?=$arrPostView['sea_cl_limit_date_e_y']?>" />
            <INPUT type="hidden" name="sea_cl_limit_date_e_m" value="<?=$arrPostView['sea_cl_limit_date_e_m']?>" />
            <INPUT type="hidden" name="sea_cl_limit_date_e_d" value="<?=$arrPostView['sea_cl_limit_date_e_d']?>" />
            <INPUT type="hidden" name="search_flg" value="<?=$arrPostView['search_flg']?>" />
          </td>
          </form>
        </tr>
      </table>
    </DIV>
  </body>
</HTML>
