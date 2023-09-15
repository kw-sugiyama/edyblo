<?
/******************************************************************************
<< ��ư���֥���Ver.1.O.0 >>
	Name: zip_search.php
	Version: 1.0.0
	Function: ͹���ֹ椫�齻�긡��
	Author: Click inc
	Date of creation: 2007/02
	History of modification:

	Copyright (C)2007 Click, inc. All Rights Reserverd.
******************************************************************************/

/*----------------------------------------------------------
  ɬ�ץե�����ƤӽФ�
----------------------------------------------------------*/
require_once ( "./ini_sets_1.php" );
require_once ( SYS_PATH."dbif/dbcom_DBconnectClass.php" );
require_once ( SYS_PATH."dbif/dbcom_DBconnectMstClass.php" );
require_once ( SYS_PATH."dbif/basedb_ClientClass.php" );
require_once ( SYS_PATH."dbif/basedb_AdminClass.php" );
require_once ( SYS_PATH."dbif/mstdb_ZipcodeClass.php" );
require_once ( SYS_PATH."common/base_common.php" );
require_once ( SYS_PATH."common/sys_common.php" );
require_once ( SYS_PATH."common/error.class.php" );


/*----------------------------------------------------------
  ���å������Ͽ����
----------------------------------------------------------*/
session_start();


/*----------------------------------------------------------
  �ģ���³
----------------------------------------------------------*/
require_once( SYS_PATH."common/db_connect.php" );
require_once( SYS_PATH."common/db_connect_mst.php" );

/*--------------------------------------------------------
  �ͥ����å�
	@$_GET["fn"]  ... �ͤ�������ߤ����ե�����̾
	@$_GET["zip"] ... ͹���ֹ���(��:370-0861)
	@$_GET["pc"]  ... �������ɤ������ե���������̾
	@$_GET["ad1"] ... ��̾�������ե���������̾
	@$_GET["adc"] ... ���ꥳ���ɤ������ե���������̾
	@$_GET["ad2"] ... �Զ跴̾�������ե���������̾
	@$_GET["ad3"] ... Į̾�������ե���������̾
--------------------------------------------------------*/
IF( $_GET["fn"] == "" || $_GET["zip"] == "" || $_GET["pc"] == "" || $_GET["ad1"] == "" || $_GET["adc"] == "" || $_GET["ad2"] == "" || $_GET["ad3"] == "" ){
	echo "�ͤ���­���Ƥ��ޤ���";
	exit;
}
IF( ereg( "^[0-9]{3}-[0-9]{4}$" , $_GET["zip"] ) === false ){
	echo "͹���ֹ椬����������ޤ���";
	exit;
}


/*--------------------------------------------------------
  ͹���ֹ渡��
--------------------------------------------------------*/

$obj_zip = new mstdb_ZipcodeClassTblAccess;
$obj_zip->conn = $obj_conn_mst->conn;
$obj_zip->jyoken["zp_zip"] = $_GET["zip"];
list( $ret , $cnt ) = $obj_zip->mstdb_GetZipcode( 1 , -1 );
IF( $ret == "-1" ){
	echo $syserr_msg;
	exit;
}
IF( $cnt != 1 ){
	echo "���ꤵ�줿͹���ֹ�ϥޥ�������Ͽ����Ƥ���ޤ���";
	exit;
}
$form_name = $_GET['fn'];
$pref = $obj_zip->zipdat[0]["zp_pref"];
$prefcd = $obj_zip->zipdat[0]["zp_prefcd"];
$city = $obj_zip->zipdat[0]["zp_city"];
$citycd = $obj_zip->zipdat[0]["zp_citycd"];
$add = $obj_zip->zipdat[0]["zp_add"];

//print_r($obj_zip->zipdat);


/*----------------------------------------------------------
  �ģ�����
----------------------------------------------------------*/
require_once( SYS_PATH."common/db_close_mst.php" );
require_once( SYS_PATH."common/db_close.php" );


/*----------------------------------------------------------
  �ȣԣͣ�����
----------------------------------------------------------*/
?>
<HTML>
  <HEAD>
    <TITLE>��ư���֥� - ��������ȴ����ġ���</TITLE>
    <META http-equiv="Content-Type" content="text/html;charset=EUC-JP" />
    <META http-equiv="Content-Style-Type" content="text/css" />
    <META http-equiv="Content-Script-Type" content="text/javascript" />
    <SCRIPT language="javascript">
    	<!--
    	function SetZipAddress(){
		var cnt = <?=$pref_cd?>-1;
		window.opener.document.<?=$form_name?>.pref.value = "<?=$pref?>";
    		window.opener.document.<?=$form_name?>.city.value = "<?=$city?>";
    		window.opener.document.<?=$form_name?>.add.value = "<?=$add?>";
    		
    		window.close();
    	}
    	-->
    </SCRIPT>
    <NOSCRIPT><META http-equiv="Refresh" content="1;URL=./jserror.html"></NOSCRIPT>
  </HEAD>
  <BODY onLoad="SetZipAddress()">
    Weit .......
  </BODY>
</HTML>
