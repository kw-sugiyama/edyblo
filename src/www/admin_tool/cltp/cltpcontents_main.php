<?
/******************************************************************************
<< ��ư���֥���Ver.1.O.0 >>
	Name: cltpcontents_main.php
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
require_once ( SYS_PATH."dbif/basedb_ClientClass.php" );
require_once ( SYS_PATH."dbif/basedb_CltpcateClass.php" );
require_once ( SYS_PATH."dbif/basedb_CltpcontentsClass.php" );
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


/*----------------------------------------------------------
   ��ʪ�ѡ������� Ƚ�̽���
----------------------------------------------------------*/
	$cltpcontents_title = "���ƥ������";
	$cltpcontents_title_img ="	<span style=\"font-size:15px;color:#6BD7B5;\">��������</spann>";

	$cltpcontents_comment_top = "";
	
	$cltpcontents_list_title = "";
	$cltpcontents_list_title .= "        <TD class=\"td_cl\" style=\"width:100px\">����</TD>\n";
	$cltpcontents_list_title .= "        <TD class=\"td_cl\" style=\"width:100px\">���ƥ���</TD>\n";
	$cltpcontents_list_title .= "        <TD class=\"td_cl\" style=\"width:300px\">�����ȥ�</TD>\n";
	$cltpcontents_list_title .= "        <TD class=\"td_cl\" style=\"width:100px\">����</TD>\n";
	$cltpcontents_list_title .= "        <TD class=\"td_cl\" style=\"width:100px\">&nbsp;</TD>\n";


/*--------------------------------------------------------
	������ʬ
--------------------------------------------------------*/
$obj2 = new basedb_CltpcontentsClassTblAccess;
$obj2->conn = $obj_conn->conn;
$obj2->jyoken["cltpcontents_del_date"] = 1;
if($_POST['sea_cltpcate_name']!="")$obj2->jyoken["cltpcate_name"] = $_POST['sea_cltpcate_name'];
if($_POST['sea_cltpcate_name']!="")$obj2->jyoken["cltpcate_name"] = $_POST['sea_cltpcate_name'];
IF( $_POST["search_flg"] == 1 ){
	$obj2->jyoken["cltpcate_id"] = $_POST["sea_cltpcate_id"];
	if($_POST["sea_cltpcontents_date_s_y"]!="" && $_POST["sea_cltpcontents_date_s_m"]!="" && $_POST["sea_cltpcontents_date_s_d"]!="")$obj2->jyoken["cltpcontents_date_s"] = $_POST["sea_cltpcontents_date_s_y"]."-".$_POST["sea_cltpcontents_date_s_m"]."-".$_POST["sea_cltpcontents_date_s_d"];
	if($_POST["sea_cltpcontents_date_e_y"]!="" && $_POST["sea_cltpcontents_date_e_m"]!="" && $_POST["sea_cltpcontents_date_e_d"]!="")$obj2->jyoken["cltpcontents_date_e"] = $_POST["sea_cltpcontents_date_e_y"]."-".$_POST["sea_cltpcontents_date_e_m"]."-".$_POST["sea_cltpcontents_date_e_d"];
}
$obj2->sort["cltpcontents_upd_date"] = 1;
list( $num , $intTotal ) = $obj2->basedb_GetCltpcontents( 1 , -1 );
IF( $nmu == -1 ){
	$arrOther["ath_comment"] = "<INPUT TYPE=\"hidden\" NAME=\"stpos\" VALUE=\"{$_POST['stpos']}\">";
	$obj_error->ViewErrMessage( "SYSTEM" , "ALL" , SITE_PATH."blank.php" , $arrOther );
	exit;
}
$viewData = "";
IF( $num == 0 ){
	$viewData .= "      <TR>\n";
	$viewData .= "        <TD colspan=\"5\" class=\"td_cl_nosize\">�������륫�ƥ������Ϥ���ޤ���</TD>\n";
	$viewData .= "      </TR>\n";
}
FOR( $i=0; $i<$num; $i++){
	
	$cltpcontents_id = htmlspecialchars( $obj2->cltpcontentsdat[$i]["cltpcontents_id"] );
	$cltpcontents_title = htmlspecialchars( $obj2->cltpcontentsdat[$i]["cltpcontents_title"] );
	$cltpcontents_stat = htmlspecialchars( $obj2->cltpcontentsdat[$i]["cltpcontents_stat"] );
	if($cltpcontents_stat==1){
		$cltpcontents_stat_value = "ɽ��";
	}else if($cltpcontents_stat==9){
		$cltpcontents_stat_value = "��ɽ��";
	}
	$cltpcontents_date = htmlspecialchars( $obj2->cltpcontentsdat[$i]["cltpcontents_date"] );
	if($cltpcontents_date!="")$timestamp = split(" ",$cltpcontents_date);
	if($timestamp[0]!="")$date = split("-",$timestamp[0]);

	$cltpcontents_upd_date = htmlspecialchars( $obj2->cltpcontentsdat[$i]["cltpcontents_upd_date"] );
	$readonly="";
	if($cltpcontents_stat == 9)$readonly="readonly";
	$dispNoMode = "";
        if($cltpcontents_stat == 1){
		$dispNoMode="text";
	}else if($cltpcontents_stat == 9){
                $dispNoMode="hidden";
	}
	if($cltpcontents_top_flg==1){
		$cltpcontents_top_flg = "ɽ��";
	}else{
		$cltpcontents_top_flg = "";
	}
	$viewData .= "      <TR>\n";
	$viewData .= "        <FORM method=\"POST\" action=\"cltpcontents_mnt.php\" target=\"_self\" name=\"editForm{$i}\" id=\"editForm{$i}\">\n";
	$viewData .= "        <input type=\"hidden\" name=\"stpos\" value=\"{$_POST["stpos"]}\" />\n";
	$viewData .= "        <input type=\"hidden\" name=\"sea_cltpcate_id\" value=\"{$_POST["sea_cltpcate_id"]}\" />\n";
	$viewData .= "        <input type=\"hidden\" name=\"sea_cltpcontents_date_s_y\" value=\"{$_POST["sea_cltpcontents_date_s_y"]}\" />\n";
	$viewData .= "        <input type=\"hidden\" name=\"sea_cltpcontents_date_s_m\" value=\"{$_POST["sea_cltpcontents_date_s_m"]}\" />\n";
	$viewData .= "        <input type=\"hidden\" name=\"sea_cltpcontents_date_s_d\" value=\"{$_POST["sea_cltpcontents_date_s_d"]}\" />\n";
	$viewData .= "        <input type=\"hidden\" name=\"sea_cltpcontents_date_e_y\" value=\"{$_POST["sea_cltpcontents_date_e_y"]}\" />\n";
	$viewData .= "        <input type=\"hidden\" name=\"sea_cltpcontents_date_e_m\" value=\"{$_POST["sea_cltpcontents_date_e_m"]}\" />\n";
	$viewData .= "        <input type=\"hidden\" name=\"sea_cltpcontents_date_e_d\" value=\"{$_POST["sea_cltpcontents_date_e_d"]}\" />\n";
	$viewData .= "        <input type=\"hidden\" name=\"search_flg\" value=\"{$_POST["search_flg"]}\" />\n";
	$viewData .= "        <TD class=\"td_cl_nosize\">{$cltpcontents_stat_value}</TD>\n";
	$viewData .= "        <TD class=\"td_cl_nosize\">{$obj2->cltpcontentsdat[$i]["cltpcate_name"]}</TD>\n";
	$viewData .= "        <TD class=\"td_cl_nosize\">{$cltpcontents_title}</TD>\n";
	$viewData .= "        <TD class=\"td_cl_nosize\">{$date[0]}ǯ{$date[1]}��{$date[2]}��</TD>\n";
	$viewData .= "        <TD class=\"td_cl_nosize\"><INPUT type=\"submit\" name=\"go_mnt_2\" value=\"����\" class=\"btn\" /></TD>\n";
	$viewData .= "        <INPUT type=\"hidden\" name=\"mode\" value=\"EDIT\" />\n";
	$viewData .= "        <INPUT type=\"hidden\" name=\"cltpcontents_kind\" value=\"{$_POST['cltpcontents_kind']}\" />\n";
	$viewData .= "        <INPUT type=\"hidden\" name=\"cltpcontents_id\" value=\"{$cltpcontents_id}\" />\n";
	$viewData .= "        </FORM>\n";
	$viewData .= "      </TR>\n";

	if( $i != 0 && $obj2->cltpcontentsdat[$i]["cltpcontents_stat"] == 1)$disp_cltpcontents_id .= "/";
	if( $obj2->cltpcontentsdat[$i]["cltpcontents_stat"] == 1)$disp_cltpcontents_id .= $obj2->cltpcontentsdat[$i]["cltpcontents_id"];
	if( $i != 0 && $obj2->cltpcontentsdat[$i]["cltpcontents_stat"] == 1)$disp_cltpcontents_upd_date .= "/";
	if( $obj2->cltpcontentsdat[$i]["cltpcontents_stat"] == 1)$disp_cltpcontents_upd_date .= $obj2->cltpcontentsdat[$i]["cltpcontents_upd_date"];
	if( $i != 0 && $obj2->cltpcontentsdat[$i]["cltpcontents_stat"] == 1)$disp_cltpcontents_stat .= "/";
	if( $obj2->cltpcontentsdat[$i]["cltpcontents_stat"] == 1)$disp_cltpcontents_stat .= $obj2->cltpcontentsdat[$i]["cltpcontents_stat"];

	if( $obj2->cltpcontentsdat[$i]["cltpcontents_stat"] == 1)$num2++;	
}

/*----------------------------------------------------------
   �ڡ���������
	=> 2007/03/16 ���߻��Ѥ��Ƥʤ�
----------------------------------------------------------*/
/*
IF( $_POST["stpos"] != "" ){
	$intStPos = intval($_POST["stpos"]);
}ELSE{
	$intStPos = 1;
}
$intPageNum = $intTotal / $intGetNum;
IF( !strpos( $intPageNum , "." ) ){
	$intPageNum = (int)$intPageNum;
}ELSE{
	$intPageNum = (int)$intPageNum + 1;
}
$intEdPos = $intGetNum + $intStPos - 1;
IF( $intEdPos > $intTotal ) $intEdPos = $intTotal;
$viewPageChangeValue = basecom_page_change_VAL( $num , $intTotal , $intGetNum , $intStPos , $intGetNum , $intPageNum , "cltpcontents_main" , "stpos" , "" );
*/


/*----------------------------------------------------------
   ���ƥ��긡������
----------------------------------------------------------*/
$obj_cate = new basedb_CltpcateClassTblAccess;
$obj_cate->conn = $obj_conn->conn;
$obj_cate->jyoken["cltpcate_del_date"] = 1;
$obj_cate->sort["cltpcate_main"] = 2;
list( $intCnt , $intTotal ) = $obj_cate->basedb_GetCltpcate( 1 , -1 );
IF( $intCnt == -1 ){
	$arrOther["ath_comment"] = "<INPUT TYPE=\"hidden\" NAME=\"stpos\" VALUE=\"{$_POST['stpos']}\">";
	$obj_error->ViewErrMessage( "SYSTEM" , "ALL" , SITE_PATH."blank.php" , $arrOther );
	exit;
}
for($i=0;$i<$intCnt;$i++){
	$cltpcate_select ="";
	$cltpcate_name ="";
	$cltpcate_id ="";
	$cltpcate_name = $obj_cate->cltpcatedat[$i]["cltpcate_name"];
	$cltpcate_id = $obj_cate->cltpcatedat[$i]["cltpcate_id"];
	if($cltpcate_id == $_POST['sea_cltpcate_id'])$cltpcate_select = "selected";
	$cltpcateValue .= "<OPTION VALUE=\"{$cltpcate_id}\" {$cltpcate_select}>{$cltpcate_name}</OPTION>";
}


/*--------------------------------------------------------
	����������������
--------------------------------------------------------*/
$s_y = date("Y") - 10;
$e_y = $s_y + 20;

$list_y_start = "";
$ySelect_start = array();
FOR( $iX=$s_y; $iX<$e_y; $iX++ ){
	if($iX==$_POST['sea_cltpcontents_date_s_y'])$ySelect_start[$iX]="selected";
	$list_y_start .= "<OPTION value=\"{$iX}\" ".$ySelect_start[$iX].">{$iX}</OPTION>\n";
}

$list_m_start = "";
$mSelect_start = array();
FOR( $iX=1; $iX<13; $iX++ ){
	if($iX==$_POST['sea_cltpcontents_date_s_m'])$mSelect_start[$iX]="selected";
	$list_m_start .= "<OPTION value=\"{$iX}\" ".$mSelect_start[$iX].">{$iX}</OPTION>\n";
}

$list_d_start = "";
$dSelect_start = array();
FOR( $iX=1; $iX<32; $iX++ ){
	if($iX==$_POST['sea_cltpcontents_date_s_d'])$dSelect_start[$iX]="selected";
	$list_d_start .= "<OPTION value=\"{$iX}\" ".$dSelect_start[$iX].">{$iX}</OPTION>\n";
}

$list_y2_start = "";
$ySelect2_start = array();
FOR( $iX=$s_y; $iX<$e_y; $iX++ ){
        if($iX==$_POST['sea_cltpcontents_date_e_y'])$ySelect2_start[$iX]="selected";
        $list_y2_start .= "<OPTION value=\"{$iX}\" ".$ySelect2_start[$iX].">{$iX}</OPTION>\n";
}

$list_m2_start = "";
$mSelect2_start = array();
FOR( $iX=1; $iX<13; $iX++ ){
        if($iX==$_POST['sea_cltpcontents_date_e_m'])$mSelect2_start[$iX]="selected";
        $list_m2_start .= "<OPTION value=\"{$iX}\" ".$mSelect2_start[$iX].">{$iX}</OPTION>\n";
}

$list_d2_start = "";
$dSelect2_start = array();
FOR( $iX=1; $iX<32; $iX++ ){
        if($iX==$_POST['sea_cltpcontents_date_e_d'])$dSelect2_start[$iX]="selected";
        $list_d2_start .= "<OPTION value=\"{$iX}\" ".$dSelect2_start[$iX].">{$iX}</OPTION>\n";
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
    <TITLE>��ư���֥� - ���饤����ȥġ���</TITLE>
    <META http-equiv="Content-Type" content="text/html;charset=EUC-JP" />
    <META http-equiv="Content-Style-Type" content="text/css" />
    <META http-equiv="Content-Script-Type" content="text/javascript" />
    <LINK rel="stylesheet" type="text/css" href="../share/css/cltpcontents.css" />
    <SCRIPT type="text/javascript" src="../share/js/cltpcontents.js"></SCRIPT>
    <NOSCRIPT><META http-equiv="Refresh" content="1;URL=../jserror.html"></NOSCRIPT>
  </HEAD>
  <BODY>
    <TABLE>
      <TR>
        <TD><?=$cltpcontents_title_img?></TD>
        <FORM ACTION="cltp_select.php" METHOD="POST">
        <TD>
          <input type="submit" value="��ǽ��������" class="btn_nosize">
        </TD>
        </FORM>
      </TR>
    </TABLE>
    <HR color="#96BC69" />
    <TABLE width="700">
      <?=$cltpcontents_comment_top?>
      <TR>
        <TD>

    <TABLE>
    <TR><TD>
    <TABLE>
      <TR>
        <FORM name="cltpcontents_main" method="POST" action="cltpcontents_main.php" target="_self">
        <TD class="td_cl">���ƥ���</TD>
        <TD>
          <SELECT name="sea_cltpcate_id">
            <OPTION value="">--����--</OPTION>
<?=$cltpcateValue?>
          </SELECT>
        </TD>
      </TR>
      <TR>
        <TD class="td_cl">����</TD>
        <TD colspan="7" align="center">
          <SELECT name="sea_cltpcontents_date_s_y">
            <OPTION value="">----</OPTION>
            <?=$list_y_start?>
          </SELECT>
          ǯ
          <SELECT name="sea_cltpcontents_date_s_m">
            <OPTION value="">--</OPTION>
            <?=$list_m_start?>
          </SELECT>
          ��
          <SELECT name="sea_cltpcontents_date_s_d">
            <OPTION value="">--</OPTION>
            <?=$list_d_start?>
          </SELECT>
          ��
          ��
          <SELECT name="sea_cltpcontents_date_e_y">
            <OPTION value="">----</OPTION>
            <?=$list_y2_start?>
          </SELECT>
          ǯ
          <SELECT name="sea_cltpcontents_date_e_m">
            <OPTION value="">--</OPTION>
            <?=$list_m2_start?>
          </SELECT>
          ��
          <SELECT name="sea_cltpcontents_date_e_d">
            <OPTION value="">--</OPTION>
            <?=$list_d2_start?>
          </SELECT>
          ��
        </TD>
      </TR>
    </TABLE>
    </TD><TD align="center" valign="top" rowspan="3">
        <INPUT type="submit" value="����" onClick="return ClientSearchCheck( this.form , this.form );" />
	<INPUT TYPE="hidden" NAME="search_flg" value="1">
        </FORM>
    </TD><TD align="center" valign="top" rowspan="3">
        <FORM name="cltpcontents_main2" method="POST" action="cltpcontents_main.php" target="_self">
        <INPUT type="submit" value="�����" />
        </FORM>
    </TD></TR>
    </TABLE>

       </TD>
      </TR>
      <TR>
        <FORM action="cltpcontents_mnt.php" method="POST" >
        <TD><INPUT type="submit" name="new" value="�����������������" class="btn_nosize" /></TD>
        <INPUT type="hidden" name="mode" value="NEW" class="btn" /></TD>
            <input type="hidden" name="stpos" value="<?=$_POST["stpos"]?>" />
            <input type="hidden" name="sea_cltpcate_id" value="<?=$_POST["sea_cltpcate_id"]?>" />
            <input type="hidden" name="sea_cltpcontents_date_s_y" value="<?=$_POST["sea_cltpcontents_date_s_y"]?>" />
            <input type="hidden" name="sea_cltpcontents_date_s_m" value="<?=$_POST["sea_cltpcontents_date_s_m"]?>" />
            <input type="hidden" name="sea_cltpcontents_date_s_d" value="<?=$_POST["sea_cltpcontents_date_s_d"]?>" />
            <input type="hidden" name="sea_cltpcontents_date_e_y" value="<?=$_POST["sea_cltpcontents_date_e_y"]?>" />
            <input type="hidden" name="sea_cltpcontents_date_e_m" value="<?=$_POST["sea_cltpcontents_date_e_m"]?>" />
            <input type="hidden" name="sea_cltpcontents_date_e_d" value="<?=$_POST["sea_cltpcontents_date_e_d"]?>" />
            <input type="hidden" name="search_flg" value="<?=$_POST["search_flg"]?>" />
        </FORM>
      </TR>
    </TABLE>
    <br />
    <TABLE>
      <TR>
	<?=$cltpcontents_list_title?>
      </TR>
<?=$viewData?>
    </TABLE>
    <BR />
    <TABLE border="0" cellspacing="0" cellpadding="2" width="700" class="px12">
      <TR>
        <FORM name="cltpcontents_main" method="POST" action="cltpcontents_main.html">
        <INPUT type="hidden" name="stpos" value="" />
        </TD>
        </FORM>
      </TR>
    </TABLE>
  </BODY>
</HTML>
