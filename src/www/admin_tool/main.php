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
          �������������å�
i----------------------------------------------------------*/
$obj = new basedb_AdminClassTblAccess;
$obj->conn = $obj_conn->conn;
$obj->admindat[0]["ad_logincd"] = sha1( $_POST["login_id"] );
$obj->admindat[0]["ad_passcd"] = sha1( $_POST["login_pass"] );
$ret = $obj->basedb_CheckAdmin ();
if ( $ret == -1 ) {
	$obj_error->ViewErrMessage( "SYSTEM" , "ALL" , SITE_PATH."index.php" , NULL );
	exit;
} elseif ( $ret == 1 ) {
	$obj_error->ViewErrMessage( "LOGIN" , "ALL" , SITE_PATH."index.php" , NULL );
	exit;
} elseif ( $ret == 2 ) {
	$obj_error->ViewErrMessage( "LOGIN" , "ALL" , SITE_PATH."index.php" , NULL );
	exit;
}


/*----------------------------------------------------------
	���å���������Ͽ
---------------------------------------------------------*/
$_SESSION['ad_id'] = addslashes( $obj->admindat[0]["ad_id"] );
$_SESSION['ad_logincd'] = $obj->admindat[0]["ad_logincd"];
$_SESSION['ad_passcd'] = $obj->admindat[0]["ad_passcd"];
$_SESSION['ad_auth'] = addslashes( $obj->admindat[0]["ad_auth"]);


/*----------------------------------------------------------
  �ģ�����
----------------------------------------------------------*/
require_once( SYS_PATH."common/db_close.php" );


/*-------------------------------------------------------------
    �ȣԣͣ�ɽ��
-------------------------------------------------------------*/
?>
<HTML>
  <HEAD>
    <META http-equiv="Content-Type" content="text/html;charset=EUC-JP">
    <TITLE>���ǥ��֥� - ��������ȴ����ġ���</TITLE>
    <META http-equiv="Content-Style-Type" content="text/css" />
    <META http-equiv="Content-Script-Type" content="text/javascript" />
    <NOSCRIPT><META http-equiv="Refresh" content="1;URL=./jserror.html"></NOSCRIPT>
  </HEAD>
  <FRAMESET rows="60,*,20" border="0" framespacing="0" bordercolor="0" frameborder="0">
    <FRAME src="./top.php" name="top" scrolling="no" noresize frameborder="0">
    <FRAMESET cols="140,*" border="0" framespacing="0" bordercolor="0" frameborder="0">
      <FRAME src="./menu.php" name="menu" scrolling="no" noresize frameborder="0" />
      <FRAME src="./blank.php" name="home" noresize frameborder="0" />
    </FRAMESET>
    <FRAME src="./bottom.php" name="bottom" scrolling="no" noresize frameborder="0">
  </FRAMESET>
  <NOFRAMES>Please see the page from here by a browser for the frame.</NOFRAMES>
</HTML>
