<?
/******************************************************************************
<< ��ư���֥���Ver.1.O.0 >>
	Name: master_zip_upd.php
	Version: 1.0.0
	Function: ͹���ֹ�ޥ����������
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
require_once ( SYS_PATH."dbif/dbcom_DBconnectMstClass.php" );
require_once ( SYS_PATH."dbif/basedb_AdminClass.php" );
require_once ( SYS_PATH."dbif/mstdb_ZipcodeClass.php" );
require_once ( SYS_PATH."common/error.class.php" );
require_once ( SYS_PATH."common/sys_common.php" );
require_once ( SYS_PATH."configs/param_file.conf" );


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
require_once( SYS_PATH."common/db_connect_mst.php" );


/*----------------------------------------------------------
  �������������å�
----------------------------------------------------------*/
require_once("../login_chk.php");
if( $login_val["ad_auth"] != "0" ){
	$obj_error->ViewErrMessage( "ACCESS" , "ALL" , SITE_PATH."blank.php" , NULL );
	exit;
}


/*--------------------------------------------------------
  �ޥ������������ʬ
--------------------------------------------------------*/
$obj_zip = new mstdb_ZipcodeClassTblAccess;
$obj_zip->conn = $obj_conn_mst->conn;
list( $ret , $intDelCnt ) = $obj_zip->mstdb_DelZipcodeAll();
IF( $ret == "-1" ){
	$obj_error->ViewErrMessage( "SYSTEM" , "ALL" , "master_main.php" , NULL );
	exit;
}ELSE{
	$viewComment = $intDelCnt."���͹���ֹ���󤬺������ޤ�����";
}


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
    <LINK rel="stylesheet" type="text/css" href="../share/css/master.css" />
    <NOSCRIPT><META http-equiv="Refresh" content="1;URL=../jserror.html"></NOSCRIPT>
  </HEAD>
  <BODY>
    <div align="center">
      <table width="400" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td align="center">
            <br /><br /><br /><br /><br />
            <font size="3" color="#FF6600"><?=$viewComment?></font>
            <br /><br /><br />
          </td>
        </tr>
      </table>
      <form name="form1" method="POST" action="master_main.php"> 
        <input type="submit" value=" �� �� " class="btn" />
      </form>
    </div>
  </BODY>
</HTML>
