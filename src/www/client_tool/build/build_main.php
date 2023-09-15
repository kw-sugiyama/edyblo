<?
/******************************************************************************
<< ��ư���֥���Ver.1.O.0 >>
	Name: build_main.php
	Version: 1.0.0
	Function: ��ʪ�������
	Author: Click inc
	Date of creation: 2007/02
	History of modification:

	Copyright (C)2007 Click, inc. All Rights Reserverd.
******************************************************************************/
$syserr_msg = "build_main.php�ǥ����ƥ२�顼��ȯ�����ޤ����������Ԥ�Ϣ���Ʋ�������";
$syserr_msg1 = "��������󤬤���ޤ���";

require_once ( "../ini_sets_2.php" );
require_once ( SYS_PATH."/dbif/dbcom_DBconnectClass.php" );
require_once ( SYS_PATH."/dbif/basedb_ClientClass.php" );
require_once ( SYS_PATH."/dbif/basedb_BuildClass.php" );
require_once ( SYS_PATH."/common/base_common.php" );
require_once ( SYS_PATH."/common/sys_common.php" );
include_once ( SYS_PATH."/common/error.class.php" );
require_once ( SYS_PATH."/configs/param_base.conf" );


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
IF( $_POST["stpos"] != "" ){
	$intStPos = intval($_POST["stpos"]);
}ELSE{
	$intStPos = 1;
}
//$intGetNum = 10;
$intGetNum = 10;

$obj = new basedb_BuildClassTblAccess;
$obj->conn = $obj_conn->conn;
$obj->jyoken["build_del_date"] = 1;
$obj->jyoken["build_cl_id"] = $_SESSION['_cl_id'];
$obj->sort["build_upd_date"] = 1;
IF( $_POST["search_flg"] == 1 ){
	$obj->jyoken["search_build_name"] = $_POST["search_build_name"];
	$obj->jyoken["search_address"] = $_POST["search_address"];
}
list( $intCnt , $intTotal ) = $obj->basedb_GetBuild( $intStPos , $intGetNum );
IF( $intCnt == -1 ){
	$arrOther["ath_comment"] = "<INPUT TYPE=\"hidden\" NAME=\"stpos\" VALUE=\"{$_POST['stpos']}\">";
	$obj_error->ViewErrMessage( "SYSTEM" , "ALL" , SITE_PATH."blank.php" , $arrOther );
	exit;
}
$viewData = "";
IF( $intCnt == 0 ){
	$viewData .= "      <TR>\n";
	$viewData .= "        <TD colspan=\"4\" class=\"td_cm\">���������ʪ����Ϥ���ޤ���</TD>\n";
	$viewData .= "      </TR>\n";
}
FOR( $i=0; $i<$intCnt; $i++){	
	$build_name = htmlspecialchars( $obj->builddat[$i]["build_name"] );
	$build_address = htmlspecialchars( $obj->builddat[$i]["build_address"] );
	if($build_address=="")$build_address="���ꤵ��Ƥ��ޤ���";
	$build_sta_name_1 = htmlspecialchars( $obj->builddat[$i]["build_sta_name_1"] );
	$build_id = htmlspecialchars ($obj->builddat[$i]["build_id"]);
	
	$viewData .= "      <TR>\n";
	$viewData .= "        <TD class=\"td_cm\" style=\"width:150px\">{$build_name}</TD>\n";
	$viewData .= "        <TD class=\"td_cm\" style=\"width:200px\">{$build_address}</TD>\n";
	$viewData .= "        <TD class=\"td_cm\" style=\"width:80px\">{$build_sta_name_1}</TD>\n";
	$viewData .= "        <TD class=\"td_cm\" >\n";
	$viewData .= "          <TABLE>\n";
	$viewData .= "            <TR>\n";
	$viewData .= "                <FORM method=\"POST\" action=\"build_mnt.php\" target=\"_self\">\n";
	$viewData .= "              <TD>\n";
	$viewData .= "                <INPUT type=\"submit\" value=\"��ʪ�����������\" class=\"btn_nosize\" />\n";
	$viewData .= "                <INPUT type=\"hidden\" name=\"mode\" value=\"EDIT\" />\n";
	$viewData .= "                <INPUT type=\"hidden\" name=\"build_id\" value=\"{$build_id}\" />\n";
	$viewData .= "                <INPUT type=\"hidden\" name=\"stpos\" value=\"{$_POST['stpos']}\" />\n";
	$viewData .= "                <INPUT type=\"hidden\" name=\"search_flg\" value=\"{$_POST['search_flg']}\" />\n";
	$viewData .= "                <INPUT type=\"hidden\" name=\"search_build_name\" value=\"{$_POST['search_build_name']}\" />\n";
	$viewData .= "                <INPUT type=\"hidden\" name=\"search_address\" value=\"{$_POST['search_address']}\" />\n";
	$viewData .= "              </TD>\n";
	$viewData .= "                </FORM>\n";
	$viewData .= "                <FORM method=\"POST\" action=\"../room/room_main.php\" target=\"_self\">\n";
	$viewData .= "              <TD>\n";
	$viewData .= "                <INPUT type=\"submit\" value=\"��������\" class=\"btn\" />\n";
	$viewData .= "                <INPUT type=\"hidden\" name=\"room_build_id\" value=\"{$build_id}\" />\n";
	$viewData .= "                <INPUT type=\"hidden\" name=\"stpos\" value=\"{$_POST['stpos']}\" />\n";
	$viewData .= "                <INPUT type=\"hidden\" name=\"search_flg\" value=\"{$_POST['search_flg']}\" />\n";
	$viewData .= "                <INPUT type=\"hidden\" name=\"search_build_name\" value=\"{$_POST['search_build_name']}\" />\n";
	$viewData .= "                <INPUT type=\"hidden\" name=\"search_address\" value=\"{$_POST['search_address']}\" />\n";
	$viewData .= "              </TD>\n";
	$viewData .= "                </FORM>\n";
	$viewData .= "            </TR>\n";
	$viewData .= "          </TABLE>\n";
	$viewData .= "        </TD>\n";
	$viewData .= "      </TR>\n";
}

$search_build_name = htmlspecialchars( stripslashes($_POST['search_build_name'] ) );
$search_address = htmlspecialchars( stripslashes($_POST['search_address'] ) );


/*----------------------------------------------------------
   �ڡ���������
----------------------------------------------------------*/
$intPageNum = $intTotal / $intGetNum;
IF( !strpos( $intPageNum , "." ) ){
	$intPageNum = (int)$intPageNum;
}ELSE{
	$intPageNum = (int)$intPageNum + 1;
}
$intEdPos = $intGetNum + $intStPos - 1;
IF( $intEdPos > $intTotal ) $intEdPos = $intTotal;
$viewPageChangeValue = basecom_page_change_VAL( $intCnt , $intTotal , $intGetNum , $intStPos , $intCnt , $intPageNum , "build_page" , "stpos" , "btn_nosize" );


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
    <LINK rel="stylesheet" type="text/css" href="../share/css/build.css" />
    <SCRIPT type="text/javascript" src="../share/js/build_search.js"></SCRIPT>
    <SCRIPT type="text/javascript" src="../share/js/input_check.js"></SCRIPT>
    <NOSCRIPT><META http-equiv="Refresh" content="1;URL=../jserror.html"></NOSCRIPT>
  </HEAD>
  <BODY>
    <IMG src="../share/images/build_title.gif" alt="ʪ�����" />
    <DIV id="com_setsu">
      <TABLE>
        <TR><TD class="bold">ʪ�����ϼ��</TD></TR>
        <TR><TD class="sel">������ʪ��������Ϥ��롣</TD></TR>
        <TR><TD class="sel">����������������Ϥ��롣</TD></TR>
        <TR><TD class="comment">��Ʊ����ʪ��ʪ��Ϸ�ʪ��Ͽ�ϣ��ĤǤ������������ʣ����ʪ�����Ϥ��Ǥ��ޤ���</TD></TR>
      </TABLE>
    </DIV>
    <HR color="#96BC69" />
    <TABLE>
      <TR>
        <FORM name="build_search" method="POST" action="build_main.php" target="_self">
        <TD class="td_cl_nosize" style="width:150">��ʪ̾</TD>
        <TD><INPUT id="i1" type="text" name="search_build_name" value="<?=$search_build_name?>" onFocus='Text("i1", 1)' onBlur='Text("i1", 2)'/></TD>
        <TD class="td_cl_nosize" style="width:150">��ʪ�����</TD>
        <TD><INPUT id="i2" type="text" name="search_address" value="<?=$search_address?>" onFocus='Text("i2", 1)' onBlur='Text("i2", 2)'/></TD>
        <TD>
          <INPUT type="submit"  class="btn" value="����" onClick="return BuildSearchCheck( this.form , this.form );" />
          <INPUT TYPE="hidden" NAME="search_flg" value="1">
        </TD>
        </FORM>
          <FORM name="build_search2" method="POST" action="build_main.php" target="_self">
        <TD><INPUT type="submit" value="�����" class="btn" /></TD>
        </FORM>
      </TR>
    </TABLE>
    <HR color="#96BC69" />
    <BR>
    <TABLE>
      <TR>
        <FORM action="build_mnt.php" method="POST">
        <TD>
          <INPUT type="submit" name="new" value="��ʪ���ɲä���" class="btn_nosize" />
          <INPUT type="hidden" name="mode" value="NEW" class="btn" />
          <INPUT type="hidden" name="stpos" value="<?=$_POST['stpos']?>" />
          <INPUT type="hidden" name="search_flg" value="<?=$_POST['search_flg']?>" />
          <INPUT type="hidden" name="search_build_name" value="<?=$_POST['search_build_name']?>" />
          <INPUT type="hidden" name="search_address" value="<?=$_POST['search_address']?>" />
        </TD>
        </FORM>
      </TR>
    </TABLE>
    <TABLE>
      <TR>
        <TD class="td_cl_nosize" style="width:200">�����ѷ�ʪ̾</TD>
        <TD class="td_cl_nosize" style="width:300">�����ѷ�ʪ�����</TD>
        <TD class="td_cl_nosize" style="width:80">�Ǵ��</TD>
        <TD class="td_cl">&nbsp;</TD>
      </TR>
<?=$viewData?>
    </TABLE>
    <BR />
    <TABLE>
      <TR>
      <FORM ACTION="" METHOD="POST" NAME="build_page">
        <INPUT type="hidden" name="stpos" value="" />
<?=$viewPageChangeValue?>
      </FORM>
      </TR>
    </TABLE>
  </BODY>
</HTML>
