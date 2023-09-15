<?
/******************************************************************************
<< ��ư���֥���Ver.1.O.0 >>
	Name: account_search.php
	Version: 1.0.0
	Function: �գң��ѥ����ɤν�ʣ��ǧ
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
require_once ( SYS_PATH."dbif/basedb_AdminClass.php" );
require_once ( SYS_PATH."dbif/basedb_ClientClass.php" );
require_once ( SYS_PATH."common/error.class.php" );
require_once ( SYS_PATH."common/sys_common.php" );


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
require_once("./login_chk.php");


/*--------------------------------------------------------
  �ͥ����å�
--------------------------------------------------------*/
IF( ereg( "^[a-z0-9_]+$" , $_GET["ac"] ) === false ){
	echo "URL�ѥ����ɤ�����������ޤ���";
	exit;
}
IF( $_GET["ci"] != "" ){
	IF( ereg( "^[0-9]+$" , $_GET["ci"] ) === false ){
		echo "���饤����ȥ����ɤ�����������ޤ���";
		exit;
	}
}


/*--------------------------------------------------------
  ����URL�����ɴ�¸��������å�
--------------------------------------------------------*/
$obj_cl = new basedb_ClientClassTblAccess;
$obj_cl->conn = $obj_conn->conn;
$obj_cl->jyoken["cl_urlcd"] = $_GET["ac"];
$obj_cl->jyoken["cl_deldate"] = 1;
IF( $_GET["ci"] != "" ){
	$obj_cl->jyoken["cl_id_not"] = $_GET["ci"];
}
list( $cnt , $total ) = $obj_cl->basedb_GetClient( 1 , -1 );
IF( $cnt == "-1" ){
	echo "�����ƥ२�顼��ȯ�����ޤ����������Ԥ�Ϣ���Ʋ�������";
	exit;
}

IF( $cnt >= 1 ){
	$viewComment = "����URL�ѥ����ɤϴ�����Ͽ����Ƥ��ޤ���";
}ELSE{
	$viewComment = "����URL�ѥ����ɤ���Ͽ��ǽ�Ǥ���";
}


/*----------------------------------------------------------
  �ģ�����
----------------------------------------------------------*/
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
    <NOSCRIPT><META http-equiv="Refresh" content="1;URL=./jserror.html"></NOSCRIPT>
  </HEAD>
  <BODY width="200" height="100">
    <CENTER>
      <?=$viewComment?>
      <br />
      <INPUT type="button" value="�Ĥ���" onClick="window.close();" />
    </CENTER>
  </BODY>
</HTML>
