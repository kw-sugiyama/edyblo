<?
/******************************************************************************
	Name: teacher_main.php
	Version: 1.0.0
	Function: �����������
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
require_once ( SYS_PATH."dbif/basedb_ClientClass.php" );
require_once ( SYS_PATH."dbif/basedb_DiaryClass.php" );
require_once ( SYS_PATH."dbif/basedb_FreeTextClass.php" );
require_once ( SYS_PATH."dbif/basedb_CategoryClass.php" );
require_once ( SYS_PATH."common/base_common.php" );
require_once ( SYS_PATH."common/sys_common.php" );
include_once ( SYS_PATH."common/error.class.php" );
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
	������ʬ
--------------------------------------------------------*/
$obj = new basedb_FreeClassTblAccess;
$obj->conn = $obj_conn->conn;
$obj->jyoken["fr_deldate"] = 1;
$obj->jyoken["fr_clid"] = $_SESSION['_cl_id'];

list( $intCnt , $intTotal ) = $obj->basedb_GetFree( $intStPos = 0 , $intGetNum = -1 );

if($login_val["cl_dokuji_flg"]==1 && $login_val["cl_dokuji_domain"]!=""){
    //�ȼ��ɥᥤ��ͭ��
     $DEFINE_URL = $login_val["cl_dokuji_domain"];
}else{
    //�ȼ��ɥᥤ��̵��
     $DEFINE_URL = $param_base_blog_addr_url.$param_base_blog_addr.$login_val["cl_urlcd"].'/';
}

/*----------------------------------------------------------*/ 
//���顼
/*----------------------------------------------------------*/ 
IF( $intCnt == -1 )
{
    $obj_error->ViewErrMessage( "SYSTEM" , "ALL" , SITE_PATH."blank.php" , $arrOther );
    exit;
}

$viewData = "";
IF( $intCnt == 0 ){
    /*----------------------------------------------------------*/ 
    //���Ǥ����
    /*----------------------------------------------------------*/ 
	$viewData .= "      <TR>\n";
	$viewData .= "        <TD colspan=\"3\" class=\"td_cm\">���ߡ���Ͽ����Ϥ���ޤ���</TD>\n";
	$viewData .= "      </TR>\n";
}ELSE{

	FOR( $i=0; $i<$intCnt; $i++){
		$fr_id[$i] = htmlspecialchars( $obj->freedat[$i]["fr_id"] );
		$fr_title[$i] = htmlspecialchars( $obj->freedat[$i]["fr_title"] );
        $fr_html[$i] = htmlspecialchars( $obj->freedat[$i]["fr_html"] );
		$fr_url[$i] = $DEFINE_URL.'free-'.$obj->freedat[$i]["fr_id"].'/';
		$viewData .= "      <TR>\n";
		$viewData .= "        <FORM method=\"POST\" action=\"free_mnt.php\" target=\"_self\">\n";
		$viewData .= "        <TD class=\"td_cm\">��{$fr_title[$i]}</TD>\n";
		$viewData .= "        <TD class=\"td_cm\">{$fr_url[$i]}</TD>\n";
		$viewData .= "        <TD class=\"td_cm\">\n";
		$viewData .= "          <INPUT type=\"submit\" name=\"go_mnt_2\" value=\"����\" class=\"btn\" />\n";
		$viewData .= "          <INPUT type=\"hidden\" name=\"mode\" value=\"EDIT\" />\n";
		$viewData .= "          <INPUT type=\"hidden\" name=\"fr_id\" value=\"{$fr_id[$i]}\" />\n";
		$viewData .= "          <INPUT type=\"hidden\" name=\"stpos\" value=\"{$_POST['stpos']}\" />\n";
		$viewData .= "        </TD>\n";
		$viewData .= "        </FORM>\n";
		$viewData .= "      </TR>\n";
	}
}

require_once( SYS_PATH."common/db_close.php" );
?>
<HTML>
  <HEAD>
    <TITLE>�Υ֥� - ��������ȴ����ġ���</TITLE>
    <META http-equiv="Content-Type" content="text/html;charset=EUC-JP" />
    <META http-equiv="Content-Style-Type" content="text/css" />
    <META http-equiv="Content-Script-Type" content="text/javascript" />
    <LINK rel="stylesheet" type="text/css" href="../share/css/free.css" />
    <NOSCRIPT><META http-equiv="Refresh" content="1;URL=../jserror.html"></NOSCRIPT>
  </HEAD>
  <BODY>
<p>�ե꡼�ڡ��� </p>
    <HR color="#96BC69" />
    <DIV id="title2">���ե꡼�ڡ�����Ͽ</DIV>
    <TABLE>
      <TR>
        <FORM action="free_mnt.php" method="POST">
        <TD><INPUT type="submit" name="new" value="�������" class="btn" /></TD>
        <INPUT type="hidden" name="mode" value="NEW" />
        <INPUT type="hidden" name="stpos" value="<?=$_POST['stpos']?>" />
        </FORM>
      </TR>
    </TABLE>
    <BR />
    <TABLE>
      <TR>
        <TD class="td_cl_nosize" width="200">�����ȥ�</TD>
        <TD class="td_cl_nosize" width="350">�գң�</TD>
        <TD class="td_cl">&nbsp;</TD>
      </TR>
<?=$viewData?>
    </TABLE>
    <BR />
    <TABLE border="0" cellspacing="0" cellpadding="2" width="700" class="px12">
      <TR>
        <FORM name="fr_page" method="POST" action="teacher_main.php">
<?=$viewPageChangeValue?>
        <INPUT type="hidden" name="stpos" value="" />
        </FORM>
      </TR>
    </TABLE>
  </BODY>
</HTML>
