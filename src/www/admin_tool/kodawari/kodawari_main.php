<?
/******************************************************************************
<< ��ư���֥���Ver.1.O.0 >>
	Name: kodawari_main.php
	Version: 1.0.0
	Function: ��������ѥ��ɥ쥹������ǽ ����������
	Author: Click inc
	Date of creation: 2007/06
	History of modification:

	Copyright (C)2007 Click, inc. All Rights Reserverd.
******************************************************************************/

/*----------------------------------------------------------
  ɬ�ץե�����ƤӽФ�
----------------------------------------------------------*/
require_once ( "../ini_sets_2.php" );
require_once ( SYS_PATH."dbif/dbcom_DBconnectClass.php" );
require_once ( SYS_PATH."dbif/basedb_AdminClass.php" );
require_once ( SYS_PATH."dbif/basedb_ClientClass.php" );
require_once ( SYS_PATH."common/error.class.php" );
require_once ( SYS_PATH."common/sys_common.php" );
require_once ( SYS_PATH."common/base_common.php" );
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
	�ȣԣͣ�����
--------------------------------------------------------*/
?>
<HTML>
  <HEAD>
    <TITLE>��ư���֥� - ��������ȴ����ġ���</TITLE>
    <META http-equiv="Content-Type" content="text/html;charset=EUC-JP" />
    <META http-equiv="Content-Style-Type" content="text/css" />
    <META http-equiv="Content-Script-Type" content="text/javascript" />
    <LINK rel="stylesheet" type="text/css" href="../share/css/client.css" />
    <SCRIPT type="text/javascript" src="../share/js/client.js"></SCRIPT>
    <LINK rel="stylesheet" type="text/css" href="../share/css/master.css" />
    <SCRIPT type="text/javascript" src="../share/js/input_check.js"></SCRIPT>
    <NOSCRIPT><META http-equiv="Refresh" content="1;URL=../jserror.html"></NOSCRIPT>
  </HEAD>
  <BODY>
    <IMG src="../share/images/kodawari_title.gif" alt="�����ڡ�������" />
    <HR color="#96BC69" />
  <DIV id="category">
    <DIV id="line_01">
      <DIV id="title">�������ڡ�������</DIV>
      <FORM name="goNew" method="POST" action="kodawari_mnt.php" target="_self">
        <INPUT type="submit" value="������̥ڡ���" class="btn" style="width:200px"/>
        <INPUT type="hidden" name="mode" value="result" />
      </FORM>
    </DIV>
  </DIV><BR>
  <DIV id="category">
    <DIV id="line_01">
      <FORM name="goNew" method="POST" action="kodawari_mnt.php" target="_self">
        <INPUT type="submit" value="���ꥢ���������ظ����ڡ���" class="btn" style="width:200px">
        <INPUT type="hidden" name="mode" value="search" />
      </FORM>
    </DIV>
  </DIV>
  </BODY>
</HTML>
