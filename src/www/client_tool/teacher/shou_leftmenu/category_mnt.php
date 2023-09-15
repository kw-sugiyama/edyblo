<?
/******************************************************************************
<< ��ư���֥���Ver.1.O.0 >>
	Name: blog_main.php
	Version: 1.0.0
	Function: �֥���������������
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
require_once ( SYS_PATH."dbif/basedb_CategoryClass.php" );
require_once ( SYS_PATH."common/base_common.php" );
require_once ( SYS_PATH."common/sys_common.php" );
require_once ( SYS_PATH."common/form_common.php" );
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
$obj = new basedb_CategoryClassTblAccess;
$obj->conn = $obj_conn->conn;
$obj->jyoken["cg_deldate"] = 1;
$obj->jyoken["cg_clid"] = $_SESSION["_cl_id"];
$obj->jyoken["cg_id"] = $_POST["cg_id"];
list( $intNum , $intTotal ) = $obj->basedb_GetCategory( 1 , -1 );
IF( $intNum == -1 ){
	$arrOther["ath_comment"] = "<INPUT TYPE=\"hidden\" NAME=\"stpos\" VALUE=\"{$_POST['stpos']}\">";
	$obj_error->ViewErrMessage( "SYSTEM" , "ALL" , SITE_PATH."blank.php" , $arrOther );
	exit;
}


/*----------------------------------------------------------
  �ģ�����
----------------------------------------------------------*/
require_once( SYS_PATH."common/db_close.php" );


/*--------------------------------------------------------
  ����ɽ����������
--------------------------------------------------------*/
if($_POST['error_mode']=="on"){
	foreach($_POST as $key => $val){
		$arrData[$key] = stripslashes($val);
	}

		$cg_id = htmlspecialchars ($arrData["cg_id"]);
		$cg_clid = htmlspecialchars ($arrData["cg_clid"]);
		$cg_stat = htmlspecialchars ($arrData["cg_stat"]);
		$cg_dispno = htmlspecialchars ($arrData["cg_dispno"]);
		$cg_topflg = htmlspecialchars ($arrData["cg_topflg"]);
		$cg_stitle = htmlspecialchars ($arrData["cg_stitle"]);
		$cg_ltitle = htmlspecialchars ($arrData["cg_ltitle"]);
		$cg_upddate = htmlspecialchars ($arrData["cg_upddate"]);

		if($cg_topflg == "1"){
			$topFlgCheck1 = "checked";
			$strTopNameDis = "";
		}else if($cg_topflg == "9"){
			$topFlgCheck2 = "checked";
			$strTopNameDis = " disabled";
		}
		
		if($cg_stat == "1" ){
			$CateFlgCheck1 = " checked";
		}else if( $cg_stat == "9" ){
			$CateFlgCheck2 = " checked";
		}
	if($_POST['mode'] == "EDIT"){

		$strDelTag = "";
		$strDelTag .= "          <form action=\"category_upd.php\" method=\"POST\" name=\"del_form\">\n";
		$strDelTag .= "          <td align=\"center\" valign=\"top\">\n";
		$strDelTag .= "            <input type=\"submit\" value=\"�������\" class=\"btn_nosize\" />\n";
		$strDelTag .= "            <input type=\"hidden\" name=\"mode\" value=\"DEL\" />\n";
		$strDelTag .= "            <input type=\"hidden\" name=\"cg_id\" value=\"{$cg_id}\" />\n";
		$strDelTag .= "            <input type=\"hidden\" name=\"cg_clid\" value=\"{$_SESSION['_cl_id']}\" />\n";
		$strDelTag .= "            <input type=\"hidden\" name=\"cg_type\" value=\"{$_POST['cg_type']}\" />\n";
		$strDelTag .= "            <input type=\"hidden\" name=\"cl_id\" value=\"{$_POST['cl_id']}\" />\n";
		$strDelTag .= "            <input type=\"hidden\" name=\"cg_upddate\" value=\"{$cg_upddate}\" />\n";
		$strDelTag .= "          </td>\n";
		$strDelTag .= "          </form>\n";


		$modeName = "����";
	}else if($_POST["mode"]=="NEW"){
		$modeName = "��Ͽ";
	}

	if($_POST['cg_type']==3){
	        $dispTopValue .= "<DIV id=\"title\" ALIGN=\"left\">TOPɽ����</DIV>\n";
	        $dispTopValue .= "<TABLE id=\"category\" cellspacing=\"0\">\n";
	        $dispTopValue .= "<tr>\n";
	        $dispTopValue .= "  <th class=\"must\">TOPɽ������ɽ��</th>\n";
	        $dispTopValue .= "  <td>\n";
	        $dispTopValue .= "    <input type=\"radio\" name=\"cg_topflg\" value=\"1\" id=\"top1\" {$topFlgCheck1} onClick=\"CateChangeUse( this.form , 1 )\" /><label for=\"top1\">ɽ��</label>\n";
	        $dispTopValue .= "    <input type=\"radio\" name=\"cg_topflg\" value=\"9\" id=\"top9\" {$topFlgCheck2} onClick=\"CateChangeUse( this.form , 9 )\" /><label for=\"top9\">��ɽ��</label><BR>\n";
	        $dispTopValue .= "    <FONT COLOR=\"#FF0000\">��ɽ�������򤹤�Ⱦ嵭�����ꤷ�����ƥ����֥��ԣϣ������<BR>�Ǻܤ��뤳�Ȥ��Ǥ��ޤ���</FONT>\n";
	        $dispTopValue .= "  </td>\n";
	        $dispTopValue .= "</tr>\n";
	        $dispTopValue .= "<tr>\n";
	        $dispTopValue .= "  <th>�ԣϣ�ɽ��̾</th>\n";
	        $dispTopValue .= "  <td><input id=\"i4\" type=\"text\" name=\"cg_ltitle\" value=\"{$cg_ltitle}\" maxlength=\"20\" style=\"width:250px\" onFocus='Text(\"i4\", 1)' onBlur='Text(\"i4\", 2)' {$strTopNameDis} /> <font color=\"#FF0000\">(20ʸ������)<BR>���֥��ԣϣ������ɽ�������������ȥ�����Ϥ��Ƥ���������</font></td>\n";
	        $dispTopValue .= "</tr>\n";
	        $dispTopValue .= "</table>\n";
	        $jsFile = "category.js";
	}else{
		$jsFile = "category2.js";
		$dispTopValue .= "<input type=\"hidden\" name=\"cg_topflg\" value=\"9\">\n";
	        $dispTopValue .= "<input type=\"hidden\" name=\"cg_ltitle\" value=\"\">\n";
	}

}else{
	if($_POST['mode'] == "EDIT"){

		$cg_id = htmlspecialchars ($obj->categorydat[0]["cg_id"]);
		$cg_clid = htmlspecialchars ($obj->categorydat[0]["cg_clid"]);
		$cg_stat = htmlspecialchars ($obj->categorydat[0]["cg_stat"]);
		$cg_dispno = htmlspecialchars ($obj->categorydat[0]["cg_dispno"]);
		$cg_stitle = htmlspecialchars ($obj->categorydat[0]["cg_stitle"]);
		$cg_ltitle = htmlspecialchars ($obj->categorydat[0]["cg_ltitle"]);
		$cg_topflg = htmlspecialchars ($obj->categorydat[0]["cg_topflg"]);
		$cg_upddate = htmlspecialchars ($obj->categorydat[0]["cg_upddate"]);

		if($cg_topflg == "1"){
			$topFlgCheck1 = "checked";
			$strTopNameDis = "";
		}else if($cg_topflg == "9"){
			$topFlgCheck2 = "checked";
			$strTopNameDis = " disabled";
		}
		
		if($cg_stat == "1" ){
			$CateFlgCheck1 = " checked";
		}else if( $cg_stat == "9" ){
			$CateFlgCheck2 = " checked";
		}

		$strDelTag = "";
		$strDelTag .= "          <form action=\"category_upd.php\" method=\"POST\" name=\"del_form\">\n";
		$strDelTag .= "          <td align=\"center\" valign=\"top\">\n";
		$strDelTag .= "            <input type=\"submit\" value=\"�������\" class=\"btn_nosize\" />\n";
		$strDelTag .= "            <input type=\"hidden\" name=\"mode\" value=\"DEL\" />\n";
		$strDelTag .= "            <input type=\"hidden\" name=\"cg_id\" value=\"{$cg_id}\" />\n";
		$strDelTag .= "            <input type=\"hidden\" name=\"cg_clid\" value=\"{$_SESSION['_cl_id']}\" />\n";
		$strDelTag .= "            <input type=\"hidden\" name=\"cg_type\" value=\"{$_POST['cg_type']}\" />\n";
		$strDelTag .= "            <input type=\"hidden\" name=\"cl_id\" value=\"{$_POST['cl_id']}\" />\n";
		$strDelTag .= "            <input type=\"hidden\" name=\"cg_ltitle\" value=\"{$cg_ltitle}\" />\n";
		$strDelTag .= "            <input type=\"hidden\" name=\"cg_upddate\" value=\"{$cg_upddate}\" />\n";
		$strDelTag .= "          </td>\n";
		$strDelTag .= "          </form>\n";


		$modeName = "����";
	}else if($_POST["mode"]=="NEW"){
		$modeName = "��Ͽ";
	}

	if($_POST['cg_type']==3){
	        $dispTopValue .= "<DIV id=\"title\" ALIGN=\"left\">TOPɽ����</DIV>\n";
	        $dispTopValue .= "<TABLE id=\"category\" cellspacing=\"0\">\n";
	        $dispTopValue .= "<tr>\n";
	        $dispTopValue .= "  <th class=\"must\">TOPɽ������ɽ��</th>\n";
	        $dispTopValue .= "  <td>\n";
	        $dispTopValue .= "    <input type=\"radio\" name=\"cg_topflg\" value=\"1\" id=\"top1\" {$topFlgCheck1} onClick=\"CateChangeUse( this.form , 1 )\" /><label for=\"top1\">ɽ��</label>\n";
	        $dispTopValue .= "    <input type=\"radio\" name=\"cg_topflg\" value=\"9\" id=\"top9\" {$topFlgCheck2} onClick=\"CateChangeUse( this.form , 9 )\" /><label for=\"top9\">��ɽ��</label><BR>\n";
	        $dispTopValue .= "    <FONT COLOR=\"#FF0000\">��ɽ�������򤹤�Ⱦ嵭�����ꤷ�����ƥ����֥��ԣϣ������<BR>�Ǻܤ��뤳�Ȥ��Ǥ��ޤ���</FONT>\n";
	        $dispTopValue .= "  </td>\n";
	        $dispTopValue .= "</tr>\n";
	        $dispTopValue .= "<tr>\n";
	        $dispTopValue .= "  <th>�ԣϣ�ɽ��̾</th>\n";
	        $dispTopValue .= "  <td><input id=\"i4\" type=\"text\" name=\"cg_ltitle\" value=\"{$cg_ltitle}\" maxlength=\"20\" style=\"width:250px\" onFocus='Text(\"i4\", 1)' onBlur='Text(\"i4\", 2)' {$strTopNameDis} /> <font color=\"#FF0000\">(20ʸ������)<BR>���֥��ԣϣ������ɽ�������������ȥ�����Ϥ��Ƥ���������</font></td>\n";
	        $dispTopValue .= "</tr>\n";
	        $dispTopValue .= "</table>\n";
	        $jsFile = "category.js";
	}else{
		$jsFile = "category2.js";
		$dispTopValue .= "<input type=\"hidden\" name=\"cg_topflg\" value=\"9\">\n";
	        $dispTopValue .= "<input type=\"hidden\" name=\"cg_ltitle\" value=\"\">\n";
	}
}
/*--------------------------------------------------------
	�ȣԣͣ�����
--------------------------------------------------------*/
?>
<HTML>
  <HEAD>
    <TITLE>�Υ֥� - ���饤����ȥġ���</TITLE>
    <META http-equiv="Content-Type" content="text/html;charset=EUC-JP" />
    <META http-equiv="Content-Style-Type" content="text/css" />
    <META http-equiv="Content-Script-Type" content="text/javascript" />
    <LINK rel="stylesheet" type="text/css" href="../share/css/category.css" />
    <SCRIPT type="text/javascript" src="../share/js/<?=$jsFile?>"></SCRIPT>
    <SCRIPT type="text/javascript" src="../share/js/input_check.js"></SCRIPT>
    <NOSCRIPT><META http-equiv="Refresh" content="1;URL=../jserror.html"></NOSCRIPT>
  </HEAD>
  <BODY>
    <div align="center">
      <DIV id="title" ALIGN="left">���ƥ����˥塼��</DIV>
      <table id="category" cellspacing="0">
        <tr>
          <form action="category_upd.php" method="POST" name="admin">
          <th class="must">����</th>
          <td>
            <input type="radio" name="cg_stat" value="1" id="kengen1" <?=$CateFlgCheck1?>/><label for="kengen1">ɽ��</label>
            <input type="radio" name="cg_stat" value="9" id="kengen9" <?=$CateFlgCheck2?>/><label for="kengen9">��ɽ��</label><BR>
	    <FONT COLOR="#FF0000">��ɽ�������򤹤�ȡ��֥��ԣϣк�¦�Υ��ƥ��꤬�ɲä���ޤ���</FONT>
          </td>
        </tr>
        <tr>
          <th class="must">���ƥ��꡼̾</th>
          <td><input id="i1" type="text" name="cg_stitle" value="<?=$cg_stitle?>" maxlength="12" style="width:160px" onFocus='Text("i1", 1)' onBlur='Text("i1", 2)' /> <font color="#FF0000">(12ʸ������)</font></td>
        </tr>
        <input type="hidden" name="cg_dispno" value="<?=$cg_dispno?>"/>
      </TABLE>
      <BR><BR>
<?=$dispTopValue?>
      <br />
      <table>
        <tr>
          <td align="center" valign="top">
            <input type="button" value="��Ͽ����" class="btn_nosize" onclick="CategoryInputCheck( this.form , this.form )" />
            <input type="hidden" name="mode" value="<?=$_POST['mode']?>" />
            <input type="hidden" name="cg_id" value="<?=$cg_id?>" />
            <input type="hidden" name="cg_clid" value="<?=$_SESSION['_cl_id']?>" />
            <input type="hidden" name="cg_type" value="<?=$_POST['cg_type']?>" />
            <input type="hidden" name="lm_id" value="<?=$_POST['lm_id']?>" />
            <input type="hidden" name="cg_upddate" value="<?=$cg_upddate?>" />
            <input type="hidden" name="cg_stat_lastupd" value="<?=$cg_stat?>" />
            <input type="hidden" name="cg_topflg_lastupd" value="<?=$cg_topflg?>" />
          </td>
          </form>
<?=$strDelTag?>
          <form method="POST" action="category_main.php">
          <td align="center" valign="top">
            <input type="submit" name="bak" value="���" class="btn_nosize" />
            <input type="hidden" name="cg_type" value="<?=$_POST['cg_type']?>" />
            <input type="hidden" name="lm_id" value="<?=$_POST['lm_id']?>" />
          </td>
          </form>
        </tr>
      </table>
    </DIV>
  </body>
</HTML>
