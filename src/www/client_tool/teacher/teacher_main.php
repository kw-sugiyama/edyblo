<?
/******************************************************************************
<< ��ư���֥���Ver.1.O.0 >>
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
require_once ( SYS_PATH."dbif/basedb_TeacherClass.php" );
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
IF( $_POST["stpos"] != "" ){
	$intStPos = intval($_POST["stpos"]);
}ELSE{
	$intStPos = 1;
}
$intGetNum = 10;

$obj = new basedb_TeacherClassTblAccess;
$obj->conn = $obj_conn->conn;
$obj->jyoken["tc_deldate"] = 1;
$obj->jyoken["tc_clid"] = $_SESSION['_cl_id'];
$obj->sort["tc_upddate"] = 2;
list( $intCnt , $intTotal ) = $obj->basedb_GetTeacher( $intStPos , $intGetNum );
IF( $intCnt == -1 ){
	$arrOther["ath_comment"] = "<INPUT TYPE=\"hidden\" NAME=\"stpos\" VALUE=\"{$_POST['stpos']}\">";
	$obj_error->ViewErrMessage( "SYSTEM" , "ALL" , SITE_PATH."blank.php" , $arrOther );
	exit;
}
$viewData = "";
IF( $intCnt == 0 ){
	$viewData .= "      <TR>\n";
	$viewData .= "        <TD colspan=\"3\" class=\"td_cm\">���ߡ�����¾��������Ϥ���ޤ���</TD>\n";
	$viewData .= "      </TR>\n";
}ELSE{
	FOR( $i=0; $i<$intCnt; $i++){
		$tc_id[$i] = htmlspecialchars( $obj->teacherdat[$i]["tc_id"] );
		$tc_stat[$i] = htmlspecialchars( $obj->teacherdat[$i]["tc_stat"] );
		if($tc_stat[$i] == 1){
			$tc_statvalue[$i] = "ͭ��";
		}else if($tc_stat[$i] == 9){
			$tc_statvalue[$i] = "̵��";
		}
		$tc_name[$i] = htmlspecialchars( $obj->teacherdat[$i]["tc_name"] );
		

		$viewData .= "      <TR>\n";
		$viewData .= "        <FORM method=\"POST\" action=\"teacher_mnt.php\" target=\"_self\">\n";
		$viewData .= "        <TD class=\"td_cm\">{$tc_statvalue[$i]}</TD>\n";
		$viewData .= "        <TD class=\"td_cm\">{$tc_name[$i]}</TD>\n";
		$viewData .= "        <TD>\n";
		$viewData .= "          <INPUT type=\"submit\" name=\"go_mnt_2\" value=\"����\" class=\"btn\" />\n";
		$viewData .= "          <INPUT type=\"hidden\" name=\"mode\" value=\"EDIT\" />\n";
		$viewData .= "          <INPUT type=\"hidden\" name=\"tc_id\" value=\"{$tc_id[$i]}\" />\n";
		$viewData .= "          <INPUT type=\"hidden\" name=\"stpos\" value=\"{$_POST['stpos']}\" />\n";
		$viewData .= "        </TD>\n";
		$viewData .= "        </FORM>\n";
		$viewData .= "      </TR>\n";
	}
}


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
$viewPageChangeValue = basecom_page_change_VAL( $intCnt , $intTotal , $intGetNum , $intStPos , $intCnt , $intPageNum , "tc_page" , "stpos" , "btn_nosize" );


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
    <TITLE>�Υ֥� - ��������ȴ����ġ���</TITLE>
    <META http-equiv="Content-Type" content="text/html;charset=EUC-JP" />
    <META http-equiv="Content-Style-Type" content="text/css" />
    <META http-equiv="Content-Script-Type" content="text/javascript" />
    <LINK rel="stylesheet" type="text/css" href="../share/css/teacher.css" />
    <NOSCRIPT><META http-equiv="Refresh" content="1;URL=../jserror.html"></NOSCRIPT>
  </HEAD>
  <BODY>
    <IMG src="../share/images/teacher_title.gif" alt="����¾��������" />
    <HR color="#96BC69" />
    <DIV id="title2">���ֻեޥ�����Ͽ</DIV>
    <TABLE>
      <TR>
        <FORM action="teacher_mnt.php" method="POST">
        <TD><INPUT type="submit" name="new" value="�������" class="btn" /></TD>
        <INPUT type="hidden" name="mode" value="NEW" />
        <INPUT type="hidden" name="stpos" value="<?=$_POST['stpos']?>" />
        </FORM>
      </TR>
    </TABLE>
    <BR />
    <TABLE>
      <TR>
        <TD class="td_cl_nosize" width="100">���ƥ��꡼</TD>
        <TD class="td_cl_nosize" width="250">�����ȥ�</TD>
        <TD class="td_cl">&nbsp;</TD>
      </TR>
<?=$viewData?>
    </TABLE>
    <BR />
    <TABLE border="0" cellspacing="0" cellpadding="2" width="700" class="px12">
      <TR>
        <FORM name="tc_page" method="POST" action="teacher_main.php">
<?=$viewPageChangeValue?>
        <INPUT type="hidden" name="stpos" value="" />
        </FORM>
      </TR>
    </TABLE>
  </BODY>
</HTML>
