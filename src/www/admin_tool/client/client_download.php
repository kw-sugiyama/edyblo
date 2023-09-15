<?
/******************************************************************************
<< ��ư���֥���Ver.1.O.0 >>
	Name: client_download.php
	Version: 1.0.0
	Function: ���饤����Ȱ������������
	Author: Click inc
	Date of creation: 2007/02
	History of modification:

	Copyright (C)2007 Click, inc. All Rights Reserverd.
******************************************************************************/

/*----------------------------------------------------------
  ɬ�ץե�����ƤӽФ�
----------------------------------------------------------*/
require_once ( "../ini_sets_2.php" );
require_once ( SYS_PATH."/dbif/dbcom_DBconnectClass.php" );
require_once ( SYS_PATH."/dbif/basedb_AdminClass.php" );
require_once ( SYS_PATH."/dbif/basedb_AreaClass.php" );
require_once ( SYS_PATH."/dbif/basedb_ClientClass.php" );
require_once ( SYS_PATH."/common/error.class.php" );
require_once ( SYS_PATH."/common/sys_common.php" );
require_once ( SYS_PATH."/configs/param_base.conf" );
require_once ( SYS_PATH."/configs/param_file.conf" );
require_once ( SYS_PATH."/configs/param_csv.conf" );


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
  ���饤����Ⱦ������
--------------------------------------------------------*/
$obj_cl = new basedb_ClientClassTblAccess;
$obj_cl->conn = $obj_conn->conn;
$obj_cl->jyoken["cl_deldate"] = "1";
$obj_cl->sort["cl_upddate"] = "1";
list( $num , $total ) = $obj_cl->basedb_GetClient( 1 , -1 );
IF( $num == "-1" ){
	$obj_error->ViewErrMessage( "SYSTEM" , "ALL" , "" , NULL );
	exit;
}


/*--------------------------------------------------------
  ���饤����Ȱ����ѥե��������
--------------------------------------------------------*/
mt_srand(microtime()*100000);
$strRand = md5( uniqid( mt_rand() , 1 ) );
$strFileName = date("Ymd")."_cl_list_down_".$strRand.".csv";
if ( ! ( $fp = fopen( $param_mst_file_path.$strFileName , "w" ) ) ) {
	$obj_error->ViewErrMessage( "SYSTEM" , "ALL" , "" , NULL );
	unlink( $param_mst_file_path.$strFileName );
	exit;
}


/*----------------------------------------------------------
  �ե���������ƽ񤭹���
----------------------------------------------------------*/
// �إå�������
$intBuffHeaderCnt = count($param_admin_cl_title);
$strBuffFileData1 = "";
FOR( $iX=0; $iX<$intBuffHeaderCnt; $iX++ ){
	IF( $strBuffFileData1 != "" ) $strBuffFileData1 .= ",";
	$strBuffFileData1 .= $param_admin_cl_title[$iX];
}
$strBuffFileData1 .= "\r\n";

// �ꥹ������
$strBuffFileData2 = "";
FOR( $iY=0; $iY<$num; $iY++ ){


	// ���ꥯ�饤�����ID�򸡺�
	$obj_area = new basedb_AreaClassTblAccess;
	$obj_area->conn = $obj_conn->conn;
	$obj_area->jyoken["ar_clid"] = $obj_cl->clientdat[$iY]["cl_id"];
	$obj_area->jyoken["ar_flg"] = 1;
	list( $areanum , $areatotal ) = $obj_area->basedb_GetArea( 1 , -1 );
	IF( $areanum == -1 ){
		$obj_error->ViewErrMessage( "SYSTEM" , "ALL" , "client_main.php" , NULL );
		exit;
	}
	$zipcode = split( "-" , $obj_area->areadat[0]['ar_zip'] );
	$arrPostView["ar_zip1"] = $zipcode[0];
	$arrPostView["ar_zip2"] = $zipcode[1];
	$arrPostView["ar_pref"] = $obj_area->areadat[0]['ar_pref'];
	$arrPostView["ar_city"] = $obj_area->areadat[0]['ar_city'];
	$arrPostView["ar_add"] = $obj_area->areadat[0]['ar_add'];
	$arrPostView["ar_estate"] = $obj_area->areadat[0]['ar_estate'];

	// ���ꥢ��
	$obj_area1 = new basedb_AreaClassTblAccess;
	$obj_area1->conn = $obj_conn->conn;
	$obj_area1->jyoken["ar_clid"] = $obj_cl->clientdat[$iY]["cl_id"];
	$obj_area1->jyoken["ar_flg"] = 2;
	list( $areanum1 , $areatotal1 ) = $obj_area1->basedb_GetArea( 1 , -1 );
	IF( $areanum1 == -1 ){
		$obj_error->ViewErrMessage( "SYSTEM" , "ALL" , "client_main.php" , NULL );
		exit;
	}
	$zipcode1 = split( "-" , $obj_area1->areadat[0]['ar_zip'] );
	$arrPostView["ar_zip1_1"] = $zipcode1[0];
	$arrPostView["ar_zip1_2"] = $zipcode1[1];
	$arrPostView["ar_pref1"] = $obj_area1->areadat[0]['ar_pref'];
	$arrPostView["ar_city1"] = $obj_area1->areadat[0]['ar_city'];
	$arrPostView["ar_add1"] = $obj_area1->areadat[0]['ar_add'];

	// ���ꥢ��
	$obj_area2 = new basedb_AreaClassTblAccess;
	$obj_area2->conn = $obj_conn->conn;
	$obj_area2->jyoken["ar_clid"] = $obj_cl->clientdat[$iY]["cl_id"];
	$obj_area2->jyoken["ar_flg"] = 3;
	list( $areanum2 , $areatotal2 ) = $obj_area2->basedb_GetArea( 1 , -1 );
	IF( $areanum2 == -1 ){
		$obj_error->ViewErrMessage( "SYSTEM" , "ALL" , "client_main.php" , NULL );
		exit;
	}
	$zipcode2 = split( "-" , $obj_area2->areadat[0]['ar_zip'] );
	$arrPostView["ar_zip2_1"] = $zipcode2[0];
	$arrPostView["ar_zip2_2"] = $zipcode2[1];
	$arrPostView["ar_pref2"] = $obj_area2->areadat[0]['ar_pref'];
	$arrPostView["ar_city2"] = $obj_area2->areadat[0]['ar_city'];
	$arrPostView["ar_add2"] = $obj_area2->areadat[0]['ar_add'];

	// ���ꥢ��
	$obj_area3 = new basedb_AreaClassTblAccess;
	$obj_area3->conn = $obj_conn->conn;
	$obj_area3->jyoken["ar_clid"] = $obj_cl->clientdat[$iY]["cl_id"];
	$obj_area3->jyoken["ar_flg"] = 4;
	list( $areanum3 , $areatotal3 ) = $obj_area3->basedb_GetArea( 1 , -1 );
	IF( $areanum3 == -1 ){
		$obj_error->ViewErrMessage( "SYSTEM" , "ALL" , "client_main.php" , NULL );
		exit;
	}
	$zipcode3 = split( "-" , $obj_area3->areadat[0]['ar_zip'] );
	$arrPostView["ar_zip3_1"] = $zipcode3[0];
	$arrPostView["ar_zip3_2"] = $zipcode3[1];
	$arrPostView["ar_pref3"] = $obj_area3->areadat[0]['ar_pref'];
	$arrPostView["ar_city3"] = $obj_area3->areadat[0]['ar_city'];
	$arrPostView["ar_add3"] = $obj_area3->areadat[0]['ar_add'];


	$strBuffFileData2 .= $obj_cl->clientdat[$iY]["cl_id"].",";
	$strBuffFileData2 .= $obj_cl->clientdat[$iY]["cl_loginid"].",";
	$strBuffFileData2 .= $obj_cl->clientdat[$iY]["cl_passwd"].",";
	$strBuffFileData2 .= $obj_cl->clientdat[$iY]["cl_urlcd"].",";
	IF( $obj_cl->clientdat[$iY]["cl_stat"] == "1" ){
		$strBuffFileData2 .= "ͭ��,";
	}ELSEIF( $obj_cl->clientdat[$iY]["cl_stat"] == "9" ){
		$strBuffFileData2 .= "̵��,";
	}ELSE{
		$strBuffFileData2 .= ",";
	}
	IF( $obj_cl->clientdat[$iY]["cl_pstat"] == "1" ){
		$strBuffFileData2 .= "�Ǻ�,";
	}ELSEIF( $obj_cl->clientdat[$iY]["cl_pstat"] == "9" ){
		$strBuffFileData2 .= "��Ǻ�,";
	}ELSE{
		$strBuffFileData2 .= ",";
	}
	IF( $obj_cl->clientdat[$iY]["cl_advertisement_flg"] == "1" ){
		$strBuffFileData2 .= "��,";
	}ELSEIF( $obj_cl->clientdat[$iY]["cl_advertisement_flg"] == "9" ){
		$strBuffFileData2 .= "�Բ�,";
	}ELSE{
		$strBuffFileData2 .= ",";
	}
	IF( $obj_cl->clientdat[$iY]["cl_dokuji_flg"] == "1" ){
		$strBuffFileData2 .= "��,";
	}ELSEIF( $obj_cl->clientdat[$iY]["cl_dokuji_flg"] == "9" ){
		$strBuffFileData2 .= "�Բ�,";
	}ELSE{
		$strBuffFileData2 .= "�Բ�,";
	}
	$strBuffFileData2 .= $obj_cl->clientdat[$iY]["cl_googlemap_key"].",";
	$strBuffFileData2 .= $obj_cl->clientdat[$iY]["cl_dokuji_domain"].",";
	IF( $obj_cl->clientdat[$iY]["cl_start"] == "" ){
		$strBuffFileData2 .= "���¤ʤ�,";
	}ELSE{
		$arrBuffstart = Array();
		$arrBuffstart = explode( "-" , $obj_cl->clientdat[$iY]["cl_start_date"] );
		$strBuffFileData2 .= $arrBuffstart[0]."ǯ".$arrBuffstart[1]."��".$arrBuffstart[2]."��,";
	}
	IF( $obj_cl->clientdat[$iY]["cl_end"] == "" ){
		$strBuffFileData2 .= "���¤ʤ�,";
	}ELSE{
		$arrBuffLimit = Array();
		$arrBuffLimit = explode( "-" , $obj_cl->clientdat[$iY]["cl_limit_date"] );
		$strBuffFileData2 .= $arrBuffLimit[0]."ǯ".$arrBuffLimit[1]."��".$arrBuffLimit[2]."��,";
	}
	$strBuffFileData2 .= $obj_cl->clientdat[$iY]["cl_jname"].",";
	$strBuffFileData2 .= $obj_cl->clientdat[$iY]["cl_kname"].",";
	$strBuffFileData2 .= $obj_cl->clientdat[$iY]["cl_agent"].",";
	$strBuffFileData2 .= $obj_cl->clientdat[$iY]["cl_mail"].",";
	$strBuffFileData2 .= $arrPostView["ar_zip1"]."-".$arrPostView["ar_zip2"].",";
	$strBuffFileData2 .= $arrPostView["ar_pref"].",";
	$strBuffFileData2 .= $arrPostView["ar_city"].",";
	$strBuffFileData2 .= $arrPostView["ar_add"].",";
	$strBuffFileData2 .= $arrPostView["ar_estate"].",";

	$strBuffFileData2 .= $arrPostView["ar_zip1_1"]."-".$arrPostView["ar_zip1_2"].",";
	$strBuffFileData2 .= $arrPostView["ar_pref1"].",";
	$strBuffFileData2 .= $arrPostView["ar_city1"].",";
	$strBuffFileData2 .= $arrPostView["ar_zip2_1"]."-".$arrPostView["ar_zip2_2"].",";
	$strBuffFileData2 .= $arrPostView["ar_pref2"].",";
	$strBuffFileData2 .= $arrPostView["ar_city2"].",";
	$strBuffFileData2 .= $arrPostView["ar_zip3_1"]."-".$arrPostView["ar_zip3_2"].",";
	$strBuffFileData2 .= $arrPostView["ar_pref3"].",";
	$strBuffFileData2 .= $arrPostView["ar_city3"].",";

	$strBuffFileData2 .= $obj_cl->clientdat[$iY]["cl_phone"].",";
	$strBuffFileData2 .= $obj_cl->clientdat[$iY]["cl_fax"].",";

//	$cl_biko_1 = nl2br($obj_cl->clientdat[$iY]["cl_biko"]);
	$cl_biko_1 = str_replace("\r\n","",$obj_cl->clientdat[$iY]["cl_biko"]);

	$strBuffFileData2 .= $cl_biko_1;
	$strBuffFileData2 .= "\r\n";
}

// �ե�����񤭹���
$strFileData = "";
$strFileData = $strBuffFileData1.$strBuffFileData2;
$strFileData = mb_convert_encoding( $strFileData , "SJIS" , "EUC-JP" );
fwrite( $fp , $strFileData );
fclose( $fp );


/*----------------------------------------------------------
  �ģ�����
----------------------------------------------------------*/
require_once( SYS_PATH."common/db_close.php" );


/*----------------------------------------------------------
  �����������ɽ��
----------------------------------------------------------*/
header("Content-type: application/x-csv");
header("Content-Disposition: attachment; filename=".$strFileName." ");
header("Content-Length: ".filesize($param_mst_file_path.$strFileName)." ");
readfile( $param_mst_file_path.$strFileName );
unlink( $param_mst_file_path.$strFileName );

?>
