<?
/******************************************************************************
<< ��ư���֥���Ver.1.0.0 >>
	Name: main.php
	Version: 1.0.0
	Function: �ᥤ����̥ե졼�����
	Author: Click inc
	Date of creation: 2007/02
	History of modification:

	Copyright (C)2006 Click, inc. All Rights Reserverd.
******************************************************************************/

/*----------------------------------------------------------
  ɬ�ץե�����ƤӽФ�
----------------------------------------------------------*/
require_once ( "./ini_sets_1.php" );
require_once ( SYS_PATH."dbif/dbcom_DBcntlClass.php");
require_once ( SYS_PATH."dbif/dbcom_DBconnectClass.php" );
require_once ( SYS_PATH."dbif/basedb_AdminClass.php" );
require_once ( SYS_PATH."common/error.class.php" );


/*----------------------------------------------------------
  ���顼���饹 - ���󥹥���
----------------------------------------------------------*/
$obj_error = new DispErrMessage();


/*----------------------------------------------------------
  ���å������Ͽ����
----------------------------------------------------------*/
session_start();


/*----------------------------------------------------------
  �ģ���³
----------------------------------------------------------*/
require_once( SYS_PATH."common/db_connect.php" );

/*----------------------------------------------------------
	���å���������Ͽ
---------------------------------------------------------*/
$_SESSION['ad_id'] = addslashes( $obj->admindat[0]["ad_id"] );
$_SESSION['ad_logincd'] = $obj->admindat[0]["ad_logincd"];
$_SESSION['ad_passcd'] = $obj->admindat[0]["ad_passcd"];
$_SESSION['ad_auth'] = addslashes( $obj->admindat[0]["ad_auth"]);

require_once( SYS_PATH."php/disp_main_test.php" );

/*----------------------------------------------------------
  �ģ�����
----------------------------------------------------------*/
require_once( SYS_PATH."common/db_close.php" );


/*-------------------------------------------------------------
    �ȣԣͣ�ɽ��
-------------------------------------------------------------*/
require_once( SYS_PATH."templates/main_test.tpl" );

?>
