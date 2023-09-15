<?
/******************************************************************************
<< ��ư���֥���Ver.1.O.0 >>
	Name: admin_main.php
	Version: 1.0.0
	Function: �����԰���
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
require_once ( SYS_PATH."common/sys_common.php" );
require_once ( SYS_PATH."common/error.class.php" );


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


/*--------------------------------------------------------
	������ʬ
--------------------------------------------------------*/
$obj2 = new basedb_AdminClassTblAccess;
$obj2->conn = $obj_conn->conn;
$obj2->jyoken["ad_deldate"] = 1;
list( $num , $total ) = $obj2->basedb_GetAdmin( 1 , -1 );
if( $num == -1 ){
	$obj_error->ViewErrMessage( "SYSTEM" , "ALL" , SITE_PATH."blank.php" , NULL );
	exit;
}

$viewData = "";
FOR( $i=0; $i<$num; $i++){
	
	if( $obj2->admindat[$i]["ad_auth"] == 0){
		$kengen = "��ǽ";
	}elseif( $obj2->admindat[$i]["ad_auth"] == 1 ){
		$kengen = "<FONT color=\"#FF0000\">�Բ�</FONT>";
	}
	$ad_id = htmlspecialchars( $obj2->admindat[$i]["ad_id"] );
	$ad_name = htmlspecialchars( $obj2->admindat[$i]["ad_name"] );
	$ad_loginid = htmlspecialchars( $obj2->admindat[$i]["ad_loginid"] );
	$ad_passwd = htmlspecialchars( $obj2->admindat[$i]["ad_passwd"] );
	$ad_biko = htmlspecialchars( $obj2->admindat[$i]["ad_biko"] );
	
	$viewData .= "      <TR>\n";
	$viewData .= "        <FORM method=\"POST\" action=\"admin_mnt.php\" target=\"_self\">\n";
	$viewData .= "        <TD class=\"td_cl_nosize\">{$kengen}</TD>\n";
	$viewData .= "        <TD class=\"td_cl_nosize\">{$ad_name}</TD>\n";
	$viewData .= "        <TD class=\"td_cl_nosize\">{$ad_loginid}</TD>\n";
	$viewData .= "        <TD class=\"td_cl_nosize\">{$ad_passwd}</TD>\n";
	$viewData .= "        <TD class=\"td_cl_nosize\">{$ad_biko}</TD>\n";
	$viewData .= "        <TD class=\"td_cl_nosize\"><INPUT type=\"submit\" value=\"����\" class=\"btn\" /></TD>\n";
	$viewData .= "        <INPUT type=\"hidden\" name=\"ad_id\" value=\"{$ad_id}\" />\n";
	$viewData .= "        <INPUT type=\"hidden\" name=\"mode\" value=\"EDIT\" />\n";
	$viewData .= "        </FORM>\n";
	$viewData .= "      </TR>\n";
	
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
    <TITLE>�Υ֥� - ��������ȴ����ġ���</TITLE>
    <META http-equiv="Content-Type" content="text/html;charset=EUC-JP" />
    <META http-equiv="Content-Style-Type" content="text/css" />
    <META http-equiv="Content-Script-Type" content="text/javascript" />
    <LINK rel="stylesheet" type="text/css" href="../share/css/admin.css" />
    <NOSCRIPT><META http-equiv="Refresh" content="1;URL=../jserror.html"></NOSCRIPT>
  </HEAD>
  <BODY>
    <IMG src="../share/images/admin_title.gif" alt="�����԰���" />
    <HR color="#96BC69" />
    <TABLE>
      <TR>
        <FORM method="POST" action="admin_mnt.php" target="_self">
        <TD><INPUT type="submit" name="new" value="������Ͽ" class="btn" /></TD>
        <INPUT type="hidden" name="mode" value="NEW" />
        </FORM>
      </TR>
    </TABLE>
    <BR />
    <TABLE>
      <TR>
        <TD class="td_cl">������ȯ��</TD>
        <TD class="td_cl">��̾</TD>
        <TD class="td_cl">������ID</TD>
        <TD class="td_cl">������ѥ����</TD>
        <TD class="td_cl">����</TD>
        <TD class="td_cl">&nbsp;</TD>
      </TR>
<?=$viewData?>
    </TABLE>
  </BODY>
</HTML>
