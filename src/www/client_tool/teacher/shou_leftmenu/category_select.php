<?
/******************************************************************************
<< ��ư���֥�����Ver.1.O.0 >>
	Name: master_list.php
	Version: 1.0.0
	Function: ���ƥ����������
	Author: Click inc
	Date of creation: 2007/3
	History of modification:

	Copyright (C)2007 Click, inc. All Rights Reserverd.
******************************************************************************/

/*----------------------------------------------------------
  ɬ�ץե�����ƤӽФ�
----------------------------------------------------------*/
require_once ( "../ini_sets_2.php" );
require_once ( SYS_PATH."dbif/dbcom_DBconnectClass.php" );
require_once ( SYS_PATH."dbif/basedb_ClientClass.php" );
require_once ( SYS_PATH."dbif/basedb_CategoryClass.php" );
require_once ( SYS_PATH."common/base_common.php" );
require_once ( SYS_PATH."common/sys_common.php" );
include_once ( SYS_PATH."common/error.class.php" );
require_once ( SYS_PATH."configs/param_base.conf" );

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
  ���������������å�
----------------------------------------------------------*/
require_once("../login_chk.php");


/*----------------------------------------------------------
  �ģ���³
----------------------------------------------------------*/
require_once( SYS_PATH."common/db_connect.php" );


/*----------------------------------------------------------
  �ȣԣͣ�����
----------------------------------------------------------*/
print <<<EOF
<HTML>
<HEAD>
    <META http-equiv="Content-Type" content="text/html;charset=EUC-JP" />
    <META http-equiv="Content-Style-Type" content="text/css" />
    <META http-equiv="Content-Script-Type" content="text/javascript" />
    <LINK rel="stylesheet" type="text/css" href="../share/css/category.css" />
    <SCRIPT type="text/javascript" src="../share/js/category.js"></SCRIPT>
    <NOSCRIPT><META http-equiv="Refresh" content="1;URL=../jserror.html"></NOSCRIPT>
</HEAD>
<BODY>
    <IMG src="../share/images/cate_kind_title.gif" alt="���ƥ��꡼��������" />
    <HR color="#96BC69" />
  <DIV id="category">
    <DIV id="line_01">
      <FORM name="goNew" method="POST" action="./category_main.php" target="_self">
        <INPUT type="submit" value="���������󥫥ƥ���" class="btn" style="width:150px">
        <INPUT type="hidden" name="cg_type" value="3" />
      </FORM>
    </DIV>
  </DIV>
  <DIV id="category">
    <DIV id="line_01">
      <FORM name="goNew" method="POST" action="./category_main.php" target="_self">
        <INPUT type="submit" value="�����å��������ƥ���" class="btn" style="width:150px">
        <INPUT type="hidden" name="cg_type" value="5" />
      </FORM>
    </DIV>
  </DIV>
  <DIV id="category">
    <DIV id="line_01">
      <FORM name="goNew" method="POST" action="./category_main.php" target="_self">
        <INPUT type="submit" value="�����ڡ��󥫥ƥ���" class="btn" style="width:150px">
        <INPUT type="hidden" name="cg_type" value="6" />
      </FORM>
    </DIV>
  </DIV>
  <DIV id="category">
    <DIV id="line_01">
      <FORM name="goNew" method="POST" action="../menu/menu_main.php" target="_self">
        <INPUT type="submit" value="���ܥ�˥塼" class="btn" style="width:150px">
      </FORM>
    </DIV>
  </DIV>
</BODY>
</HTML>
EOF;
?>