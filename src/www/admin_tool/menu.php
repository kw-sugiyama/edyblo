<?
/******************************************************************************
<< ��ư���֥���Ver.1.0.0 >>
    Name: menu.php
    Version: 1.0.0
    Function: �������
    Author: Click inc
    Date of creation: 2006/09
    History of modification:

    Copyright (C)2005 Click, inc. All Rights Reserverd.
******************************************************************************/

/*----------------------------------------------------------
  ɬ�ץե�����ƤӽФ�
----------------------------------------------------------*/
require_once ( "./ini_sets_1.php" );
require_once ( SYS_PATH."dbif/basedb_AdminClass.php" );
require_once ( SYS_PATH."dbif/dbcom_DBconnectClass.php" );
require_once ( SYS_PATH."common/sys_common.php" );
require_once ( SYS_PATH."common/error.class.php" );


/*----------------------------------------------------------
  ���顼���饹 - ���󥹥���
----------------------------------------------------------*/
$obj_error = new DispErrMessage();


/*----------------------------------------------------------
  ���å���󳫻�
----------------------------------------------------------*/
session_start();


/*----------------------------------------------------------
  �ģ���³
----------------------------------------------------------*/
require_once( SYS_PATH."common/db_connect.php" );


/*----------------------------------------------------------
  �������������å�
----------------------------------------------------------*/
require_once("./login_chk.php");


/*----------------------------------------------------------
  �����Ը��¥桼�����ξ�硢�������ܤ�ɽ��
----------------------------------------------------------*/
if( $login_val["ad_auth"] == "0"){
	$viewKanriIcon = "";
	$viewKanriIcon .= "<li><a href=\"./admin/admin_main.php\" target=\"home\">��������Ͽ</a></li>\n";
	$viewMasterIcon = "";
	$viewMasterIcon = "<li><a href=\"./master/master_main.php\" target=\"home\">�ޥ�����Ͽ</a></li>\n";
}


/*----------------------------------------------------------
  �ģ�����
----------------------------------------------------------*/
require_once( SYS_PATH."common/db_close.php" );


/*----------------------------------------------------------
  �ȣԣͣ�����
----------------------------------------------------------*/
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<HTML xmlns="http:www.w3.org/1999/xhtml" xml:lang="ja" lang="ja">
  <HEAD>
    <META http-equiv="Content-Type" content="text/html;charset=EUC-JP">
    <TITLE>��ư���֥� - ��������ȴ����ġ���</TITLE>
    <META http-equiv="Content-Style-Type" content="text/css" />
    <META http-equiv="Content-Script-Type" content="text/javascript" />
    <LINK rel="stylesheet" href="./share/css/menu.css" type="text/css" />
    <base target="home" />
    <NOSCRIPT><META http-equiv="Refresh" content="1;URL=./jserror.html"></NOSCRIPT>
  </HEAD>
  <BODY>
    <DIV id="navigation">
      <ul>
        <?=$viewKanriIcon?>
        <?=$viewMasterIcon?>
        <li><a href="./client/client_main.php" target="home">���饤�������Ͽ</a></li>
        <li><a href="./cltp/cltp_select.php" target="home">���Τ餻����</a></li>
<!--
        <li><a href="./client/client_main.php" target="home">���Τ餻����</a></li>
        <li><a href="./kodawari/kodawari_main.php" target="home">��������ѥ��ɥ쥹����</a></li>
//-->
        <li><a href="index.php" target="_top">��������</a></li>
      </ul>
    </DIV>
  </BODY>
</HTML>
