<?
/******************************************************************************
<< ��ư���֥���Ver.1.O.0 >>
	Name: master_main.php
	Version: 1.0.0
	Function: �ޥ�������������
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
require_once ( SYS_PATH."dbif/basedb_AdminClass.php" );
require_once ( SYS_PATH."dbif/basedb_ClientClass.php" );
require_once ( SYS_PATH."common/error.class.php" );
require_once ( SYS_PATH."common/sys_common.php" );
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
if( $login_val["ad_auth"] != "0" ){
	$obj_error->ViewErrMessage( "ACCESS" , "ALL" , SITE_PATH."blank.php" , NULL );
	exit;
}


/*----------------------------------------------------------
  �ģ�����
----------------------------------------------------------*/
require_once( SYS_PATH."common/db_close.php" );


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
    <LINK rel="stylesheet" type="text/css" href="../share/css/master.css" />
    <SCRIPT type="text/javascript" src="../share/js/master.js"></SCRIPT>
    <NOSCRIPT><META http-equiv="Refresh" content="1;URL=../jserror.html"></NOSCRIPT>
  </HEAD>
  <BODY>
    <IMG src="../share/images/master_title.gif" alt="�Ƽ�ޥ����գ�" />
    <HR color="#96BC69" />
    <DIV id="title">�ֽ���ޥ�����UPLOAD</DIV>
    <TABLE>
      <TR>
        <FORM name="mst_zip" method="POST" action="" target="_self" enctype="multipart/form-data">
        <TD>
          <INPUT type="file" name="zip_master" style="width:300px;" /><br /><br />
          <INPUT type="button" value="��Ͽ" class="btn" onClick="return ZipChangeCheck( this.form , 1 )" />
          &nbsp;&nbsp;&nbsp;
          <INPUT type="button" value="���" class="btn" onClick="return ZipChangeCheck( this.form , 2 )" />
        </TD>
        </FORM>
      </TR>
    </TABLE>
    
    <br /><br /><br /><br />
    
    <DIV id="title">�ֱ������إޥ�����UPLOAD</DIV>
    <TABLE>
      <TR>
        <FORM name="mst_line" method="POST" action="" target="_self" enctype="multipart/form-data">
        <TD>
          <INPUT type="file" name="line_master" style="width:300px;" /><br /><br />
          <INPUT type="button" value="��Ͽ" class="btn" onClick="return LineChangeCheck( this.form , 1 )" />
          &nbsp;&nbsp;&nbsp;
          <INPUT type="button" value="���" class="btn" onClick="return LineChangeCheck( this.form , 2 )" />
        </TD>
        </FORM>
      </TR>
    </TABLE>


    <!-- �ޥ�������ݡ��Ȼ������ ����å������С�html��ifram�ǸƤӽФ� -->
    <br />
    <iframe src="http://www.sp-jobnet.co.jp/slash/open/chuiten.html" width="80%"></iframe>
    
    
  </BODY>
</HTML>
