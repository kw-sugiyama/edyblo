<?
/******************************************************************************
<< ��ư���֥���Ver.1.0.0 >>
    Name: top.php
    Version: 1.0.0
    Function: ���̾�����
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
require_once ( SYS_PATH."common/error.class.php" );
require_once ( SYS_PATH."common/sys_common.php" );


/*----------------------------------------------------------
  ���å���󳫻�
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
    <TITLE>���ǥ��֥� - ��������ȴ����ġ���</TITLE>
    <META http-equiv="Content-Type" content="text/html;charset=EUC-JP" />
    <META http-equiv="Content-Style-Type" content="text/css" />
    <META http-equiv="Content-Script-Type" content="text/javascript" />
    <LINK rel="stylesheet" href="./share/css/top.css" type="text/css" />
    <NOSCRIPT><META http-equiv="Refresh" content="1;URL=./jserror.html"></NOSCRIPT>
  </HEAD>
  <BODY leftmargin="0" marginwidth="0" topmargin="0" marginheight="0">
    <DIV id="top">
      <TABLE>
        <TR>
          <TD class="logo"><IMG src="./share/images/ediblo_logo.gif" width="210" height="50" border="0"/></TD>
          <TD class="title">Edyblo(���ǥ��֥�) �����ƥ��������</TD>
        </TR>
      </TABLE>
    </DIV>
  </BODY>
</HTML>
