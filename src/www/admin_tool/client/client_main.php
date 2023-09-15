<?
/******************************************************************************
<< ��ư���֥���Ver.1.O.0 >>
	Name: client_main.php
	Version: 1.0.0
	Function: ���饤����Ȱ���
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
require_once ( SYS_PATH."dbif/basedb_ClientadminClass.php" );
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
	������ʬ
--------------------------------------------------------*/
IF( $_POST["stpos"] != "" ){
	$intStPos = intval($_POST["stpos"]);
}ELSE{
	$intStPos = 1;
}
$intGetNum = 15;
//$intGetNum = 10;

$obj2 = new basedb_ClientClassTblAccess;
$obj2->conn = $obj_conn->conn;
$obj2->jyoken["cl_deldate"] = 1;
IF( $_POST["search_flg"] == 1 ){
	
	$obj2->jyoken["cl_name_like"] = $_POST["sea_cl_name_like"];
	$obj2->jyoken["cl_pref"] = $_POST["sea_cl_pref"];
	$obj2->jyoken["cl_stat"] = $_POST["sea_cl_stat"];
	$obj2->jyoken["cl_dokuji_flg"] = $_POST["sea_cl_dokuji_flg"];
	$obj2->jyoken["cl_advertisement_flg"] = $_POST["sea_cl_advertisement_flg"];
	$obj2->jyoken["cl_limit_date_s"] = $_POST["sea_cl_limit_date_s_y"]."-".$_POST["sea_cl_limit_date_s_m"]."-".$_POST["sea_cl_limit_date_s_d"];
	$obj2->jyoken["cl_limit_date_e"] = $_POST["sea_cl_limit_date_e_y"]."-".$_POST["sea_cl_limit_date_e_m"]."-".$_POST["sea_cl_limit_date_e_d"];
	$obj2->jyoken["cl_start_date_s"] = $_POST["sea_cl_start_date_s_y"]."-".$_POST["sea_cl_start_date_s_m"]."-".$_POST["sea_cl_start_date_s_d"];
	$obj2->jyoken["cl_start_date_e"] = $_POST["sea_cl_start_date_e_y"]."-".$_POST["sea_cl_start_date_e_m"]."-".$_POST["sea_cl_start_date_e_d"];
	
	
}
$obj2->sort["cl_upddate"] = 1;
list( $intCnt , $intTotal ) = $obj2->basedb_GetClient( $intStPos , $intGetNum );
if( $intCnt == -1 ){
        $obj_error->ViewErrMessage( "SYSTEM" , "ALL" , SITE_PATH."blank.php" , NULL );
        exit;
}


/*----------------------------------------------------------
  �ģ�����
----------------------------------------------------------*/
require_once( SYS_PATH."common/db_close.php" );


/*--------------------------------------------------------
  POST�ͤ�ù�
--------------------------------------------------------*/
$arrPostView = Array();
FOREACH( $_POST as $key => $val ){
	$arrPostView[$key] = htmlspecialchars( stripslashes( $val ) );
}


/*--------------------------------------------------------
	�ꥹ��ɽ����������
--------------------------------------------------------*/
$viewData = "";
IF( $intCnt == 0 ){
	$viewData .= "      <TR>\n";
	$viewData .= "        <TD colspan=\"10\" class=\"td_cl_nosize\">�������륯�饤����Ⱦ���Ϥ���ޤ���</TD>\n";
	$viewData .= "      </TR>\n";
}ELSE{
	FOR( $i=0; $i<$intCnt; $i++){
		
		$cl_id = $obj2->clientdat[$i]["cl_id"];
		if( $obj2->clientdat[$i]["cl_stat"] == 1 ){
			$cl_stat = "ͭ��";
		}elseif( $obj2->clientdat[$i]["cl_stat"] == 9 ){
			$cl_stat = "<FONT color=\"#FF0000\">̵��</FONT>";
		}
		if( $obj2->clientdat[$i]["cl_pstat"] == 1 ){
			$cl_pstat = "�Ǻ�";
		}elseif( $obj2->clientdat[$i]["cl_pstat"] == 9 ){
			$cl_pstat = "<FONT color=\"#FF0000\">��Ǻ�</FONT>";
		}else{
			$cl_pstat = "�Ǻ�";
		}
		if( $obj2->clientdat[$i]["cl_dokuji_flg"] == 1 ){
			$cl_dokuji_flg = "��";
		}elseif( $obj2->clientdat[$i]["cl_dokuji_flg"] == 9 ){
			$cl_dokuji_flg = "<FONT color=\"#FF0000\">�Բ�</FONT>";
		}else{
			$cl_dokuji_flg = "<FONT color=\"#FF0000\">�Բ�</FONT>";
		}
		if( $obj2->clientdat[$i]["cl_advertisement_flg"] == 1 ){
			$cl_advertisement_flg = "��";
		}elseif( $obj2->clientdat[$i]["cl_advertisement_flg"] == 9 ){
			$cl_advertisement_flg = "<FONT color=\"#FF0000\">�Բ�</FONT>";
		}else{
			$cl_advertisement_flg = "<FONT color=\"#FF0000\">�Բ�</FONT>";
		}
		$cl_jname = htmlspecialchars( stripslashes($obj2->clientdat[$i]["cl_jname"]) );
		$cl_kname = htmlspecialchars( stripslashes($obj2->clientdat[$i]["cl_kname"]) );
		$cl_loginid = htmlspecialchars( stripslashes($obj2->clientdat[$i]["cl_loginid"]) );
		$cl_passwd = htmlspecialchars( stripslashes($obj2->clientdat[$i]["cl_passwd"]) );
		$cl_urlcd = htmlspecialchars( stripslashes($obj2->clientdat[$i]["cl_urlcd"]) );
		if($obj2->clientdat[$i]["cl_end"]!=""){
			$cl_end = split( " ",$obj2->clientdat[$i]["cl_end"] );
			$cl_end[0] = htmlspecialchars( $cl_end[0] );
		}else{
			$cl_end = "̤����";
		}
		if($obj2->clientdat[$i]["cl_start"]!=""){
			$cl_start = split( " ",$obj2->clientdat[$i]["cl_end"] );
			$cl_start[0] = htmlspecialchars( $cl_start[0] );
		}else{
			$cl_start = "̤����";
		}
		
		$viewData .= "      <TR>\n";
		$viewData .= "        <FORM method=\"POST\" action=\"client_mnt.php\" target=\"_self\">\n";
		$viewData .= "        <TD class=\"td_cl_nosize\">{$cl_stat}</TD>\n";
		$viewData .= "        <TD class=\"td_cl_nosize\">{$cl_pstat}</TD>\n";
		$viewData .= "        <TD class=\"td_cl_nosize\">{$cl_dokuji_flg}</TD>\n";
		$viewData .= "        <TD class=\"td_cl_nosize\">{$cl_advertisement_flg}</TD>\n";
		$viewData .= "        <TD class=\"td_cl_nosize\" style=\"text-align:left\">{$cl_jname}{$cl_kname}</TD>\n";
		$viewData .= "        <TD class=\"td_cl_nosize\">{$cl_loginid}</TD>\n";
		$viewData .= "        <TD class=\"td_cl_nosize\">{$cl_passwd}</TD>\n";
		$viewData .= "        <TD class=\"td_cl_nosize\">{$cl_urlcd}</TD>\n";
		if($cl_start=="̤����" && $cl_end=="̤����"){
			$viewData .= "        <TD class=\"td_cl_nosize\">���¤ʤ�</TD>\n";
		}else{
			$viewData .= "        <TD class=\"td_cl_nosize\">{$cl_start[0]}��{$cl_end[0]}</TD>\n";
		}
		$viewData .= "        <TD class=\"td_cl_nosize\"><INPUT type=\"submit\" value=\"����\" class=\"btn\" /></TD>\n";
		$viewData .= "        <INPUT type=\"hidden\" name=\"cl_id\" value=\"{$cl_id}\" />\n";
       		$viewData .= "        <INPUT type=\"hidden\" name=\"sea_cl_name_like\" value=\"{$arrPostView['sea_cl_name_like']}\" />\n";
       		$viewData .= "        <INPUT type=\"hidden\" name=\"stpos\" value=\"{$arrPostView['stpos']}\" />\n";
        	$viewData .= "        <INPUT type=\"hidden\" name=\"sea_cl_pref\" value=\"{$arrPostView['sea_cl_pref']}\" />\n";
        	$viewData .= "        <INPUT type=\"hidden\" name=\"sea_cl_stat\" value=\"{$arrPostView['sea_cl_stat']}\" />\n";
        	$viewData .= "        <INPUT type=\"hidden\" name=\"sea_cl_dokuji_flg\" value=\"{$arrPostView['sea_cl_dokuji_flg']}\" />\n";
        	$viewData .= "        <INPUT type=\"hidden\" name=\"sea_cl_advertisement_flg\" value=\"{$arrPostView['sea_cl_advertisement_flg']}\" />\n";
        	$viewData .= "        <INPUT type=\"hidden\" name=\"sea_cl_start_date_s_y\" value=\"{$arrPostView['sea_cl_start_date_s_y']}\" />\n";
        	$viewData .= "        <INPUT type=\"hidden\" name=\"sea_cl_start_date_s_m\" value=\"{$arrPostView['sea_cl_start_date_s_m']}\" />\n";
        	$viewData .= "        <INPUT type=\"hidden\" name=\"sea_cl_start_date_s_d\" value=\"{$arrPostView['sea_cl_start_date_s_d']}\" />\n";
        	$viewData .= "        <INPUT type=\"hidden\" name=\"sea_cl_start_date_e_y\" value=\"{$arrPostView['sea_cl_start_date_e_y']}\" />\n";
        	$viewData .= "        <INPUT type=\"hidden\" name=\"sea_cl_start_date_e_m\" value=\"{$arrPostView['sea_cl_start_date_e_m']}\" />\n";
        	$viewData .= "        <INPUT type=\"hidden\" name=\"sea_cl_start_date_e_d\" value=\"{$arrPostView['sea_cl_start_date_e_d']}\" />\n";
        	$viewData .= "        <INPUT type=\"hidden\" name=\"sea_cl_limit_date_s_y\" value=\"{$arrPostView['sea_cl_limit_date_s_y']}\" />\n";
        	$viewData .= "        <INPUT type=\"hidden\" name=\"sea_cl_limit_date_s_m\" value=\"{$arrPostView['sea_cl_limit_date_s_m']}\" />\n";
        	$viewData .= "        <INPUT type=\"hidden\" name=\"sea_cl_limit_date_s_d\" value=\"{$arrPostView['sea_cl_limit_date_s_d']}\" />\n";
        	$viewData .= "        <INPUT type=\"hidden\" name=\"sea_cl_limit_date_e_y\" value=\"{$arrPostView['sea_cl_limit_date_e_y']}\" />\n";
        	$viewData .= "        <INPUT type=\"hidden\" name=\"sea_cl_limit_date_e_m\" value=\"{$arrPostView['sea_cl_limit_date_e_m']}\" />\n";
        	$viewData .= "        <INPUT type=\"hidden\" name=\"sea_cl_limit_date_e_d\" value=\"{$arrPostView['sea_cl_limit_date_e_d']}\" />\n";
        	$viewData .= "        <INPUT type=\"hidden\" name=\"search_flg\" value=\"{$arrPostView['search_flg']}\" />\n";
		$viewData .= "        <INPUT type=\"hidden\" name=\"mode\" value=\"EDIT\" />\n";
		$viewData .= "        </FORM>\n";
		$viewData .= "      </TR>\n";
		
	}
}


/*--------------------------------------------------------
	����������������
--------------------------------------------------------*/
$sea_cl_name_like = $arrPostView['sea_cl_name_like'];

if( $arrPostView['sea_cl_stat'] == 1 ){
	$statSelect1 = " selected";
}elseif( $arrPostView['sea_cl_stat'] == 9 ){
        $statSelect2 = "selected";
}

if( $arrPostView['sea_cl_dokuji_flg'] == 1 ){
	$dokujiSelect1 = " selected";
}elseif( $arrPostView['sea_cl_dokuji_flg'] == 9 ){
        $dokujiSelect2 = "selected";
}

if( $arrPostView['sea_cl_advertisement_flg'] == 1 ){
	$adverSelect1 = " selected";
}elseif( $arrPostView['sea_cl_advertisement_flg'] == 9 ){
        $adverSelect2 = "selected";
}

$s_y = date("Y");
$e_y = $s_y + 3;

$list_y_start = "";
$ySelect_start = array();
FOR( $iX=$s_y; $iX<$e_y; $iX++ ){
	if($iX==$_POST['sea_cl_start_date_s_y'])$ySelect_start[$iX]="selected";
	$list_y_start .= "<OPTION value=\"{$iX}\" ".$ySelect_start[$iX].">{$iX}</OPTION>\n";
}

$list_m_start = "";
$mSelect_start = array();
FOR( $iX=1; $iX<13; $iX++ ){
	if($iX==$_POST['sea_cl_start_date_s_m'])$mSelect_start[$iX]="selected";
	$list_m_start .= "<OPTION value=\"{$iX}\" ".$mSelect_start[$iX].">{$iX}</OPTION>\n";
}

$list_d_start = "";
$dSelect_start = array();
FOR( $iX=1; $iX<32; $iX++ ){
	if($iX==$_POST['sea_cl_start_date_s_d'])$dSelect_start[$iX]="selected";
	$list_d_start .= "<OPTION value=\"{$iX}\" ".$dSelect_start[$iX].">{$iX}</OPTION>\n";
}

$list_y2_start = "";
$ySelect2_start = array();
FOR( $iX=$s_y; $iX<$e_y; $iX++ ){
        if($iX==$_POST['sea_cl_start_date_e_y'])$ySelect2_start[$iX]="selected";
        $list_y2_start .= "<OPTION value=\"{$iX}\" ".$ySelect2_start[$iX].">{$iX}</OPTION>\n";
}

$list_m2_start = "";
$mSelect2_start = array();
FOR( $iX=1; $iX<13; $iX++ ){
        if($iX==$_POST['sea_cl_start_date_e_m'])$mSelect2_start[$iX]="selected";
        $list_m2_start .= "<OPTION value=\"{$iX}\" ".$mSelect2_start[$iX].">{$iX}</OPTION>\n";
}

$list_d2_start = "";
$dSelect2_start = array();
FOR( $iX=1; $iX<32; $iX++ ){
        if($iX==$_POST['sea_cl_start_date_e_d'])$dSelect2_start[$iX]="selected";
        $list_d2_start .= "<OPTION value=\"{$iX}\" ".$dSelect2_start[$iX].">{$iX}</OPTION>\n";
}


$list_y_limit = "";
$ySelect_limit = array();
FOR( $iX=$s_y; $iX<$e_y; $iX++ ){
	if($iX==$_POST['sea_cl_limit_date_s_y'])$ySelect_limit[$iX]="selected";
	$list_y_limit .= "<OPTION value=\"{$iX}\" ".$ySelect_limit[$iX].">{$iX}</OPTION>\n";
}

$list_m_limit = "";
$mSelect_limit = array();
FOR( $iX=1; $iX<13; $iX++ ){
	if($iX==$_POST['sea_cl_limit_date_s_m'])$mSelect_limit[$iX]="selected";
	$list_m_limit .= "<OPTION value=\"{$iX}\" ".$mSelect_limit[$iX].">{$iX}</OPTION>\n";
}

$list_d_limit = "";
$dSelect_limit = array();
FOR( $iX=1; $iX<32; $iX++ ){
	if($iX==$_POST['sea_cl_limit_date_s_d'])$dSelect_limit[$iX]="selected";
	$list_d_limit .= "<OPTION value=\"{$iX}\" ".$dSelect_limit[$iX].">{$iX}</OPTION>\n";
}

$list_y2_limit = "";
$ySelect2_limit = array();
FOR( $iX=$s_y; $iX<$e_y; $iX++ ){
        if($iX==$_POST['sea_cl_limit_date_e_y'])$ySelect2_limit[$iX]="selected";
        $list_y2_limit .= "<OPTION value=\"{$iX}\" ".$ySelect2_limit[$iX].">{$iX}</OPTION>\n";
}

$list_m2_limit = "";
$mSelect2_limit = array();
FOR( $iX=1; $iX<13; $iX++ ){
        if($iX==$_POST['sea_cl_limit_date_e_m'])$mSelect2_limit[$iX]="selected";
        $list_m2_limit .= "<OPTION value=\"{$iX}\" ".$mSelect2_limit[$iX].">{$iX}</OPTION>\n";
}

$list_d2_limit = "";
$dSelect2_limit = array();
FOR( $iX=1; $iX<32; $iX++ ){
        if($iX==$_POST['sea_cl_limit_date_e_d'])$dSelect2_limit[$iX]="selected";
        $list_d2_limit .= "<OPTION value=\"{$iX}\" ".$dSelect2_limit[$iX].">{$iX}</OPTION>\n";
}

$list_pref_limit = "";
$intCnt_pref_limit = count($psel);
FOR( $iX=1; $iX<$intCnt_pref; $iX++ ){
	if($iX==$_POST['sea_cl_pref_limit'])$prefSelect_limit[$iX]="selected";
	$list_pref_limit .= "<OPTION value=\"{$iX}\" ".$prefSelect_limit[$iX].">{$psel[$iX]}</OPTION>\n";
}


// ��������ƻ�ܸ�
$list_pref_start = "";
$intCnt_pref_start = count( $psel );
FOR( $iX=1; $iX<$intCnt_pref_start; $iX++ ){
	IF( $psel[$iX] == $_POST["sea_cl_pref"] ) $prefSelect_start[$iX] = " selected";
	$list_pref_start .= "<OPTION value=\"{$psel[$iX]}\"{$prefSelect_start[$iX]}>{$psel[$iX]}</OPTION>\n";
}


// �ڡ���������
$intPageNum = $intTotal / $intGetNum;
IF( !strpos( $intPageNum , "." ) ){
	$intPageNum = (int)$intPageNum;
}ELSE{
	$intPageNum = (int)$intPageNum + 1;
}
$intEdPos = $intGetNum + $intStPos - 1;
IF( $intEdPos > $intTotal ) $intEdPos = $intTotal;
$viewPageChangeValue = basecom_page_change_VAL( $intCnt , $intTotal , $intGetNum , $intStPos , $intCnt , $intPageNum , "client_list" , "stpos" , "btn_nosize" );



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
    <LINK rel="stylesheet" type="text/css" href="../share/css/client.css" />
    <SCRIPT type="text/javascript" src="../share/js/client.js"></SCRIPT>
    <SCRIPT type="text/javascript" src="../share/js/input_check.js"></SCRIPT>
    <NOSCRIPT><META http-equiv="Refresh" content="1;URL=../jserror.html"></NOSCRIPT>
  </HEAD>
  <BODY>
    <TABLE width="100%">
      <TR>
        <TD width="100"><IMG src="../share/images/client_title.gif" alt="���饤����Ȱ���" /></TD>
        <FORM action="client_mnt.php" method="POST" target="_self">
        <TD align="left"><INPUT type="submit" name="new" value="������Ͽ" class="btn" /></TD>
        <INPUT type="hidden" name="sea_cl_name_like" value="<?=$arrPostView['sea_cl_name_like']?>" />
        <INPUT type="hidden" name="stpos" value="<?=$arrPostView['stpos']?>" />
        <INPUT type="hidden" name="sea_cl_pref" value="<?=$arrPostView['sea_cl_pref']?>" />
        <INPUT type="hidden" name="sea_cl_stat" value="<?=$arrPostView['sea_cl_stat']?>" />
        <INPUT type="hidden" name="sea_cl_dokuji_flg" value="<?=$arrPostView['sea_cl_dokuji_flg']?>" />
        <INPUT type="hidden" name="sea_cl_advertisement_flg" value="<?=$arrPostView['sea_cl_advertisement_flg']?>" />
        <INPUT type="hidden" name="sea_cl_start_date_s_y" value="<?=$arrPostView['sea_cl_start_date_s_y']?>" />
        <INPUT type="hidden" name="sea_cl_start_date_s_m" value="<?=$arrPostView['sea_cl_start_date_s_m']?>" />
        <INPUT type="hidden" name="sea_cl_start_date_s_d" value="<?=$arrPostView['sea_cl_start_date_s_d']?>" />
        <INPUT type="hidden" name="sea_cl_start_date_e_y" value="<?=$arrPostView['sea_cl_start_date_e_y']?>" />
        <INPUT type="hidden" name="sea_cl_start_date_e_m" value="<?=$arrPostView['sea_cl_start_date_e_m']?>" />
        <INPUT type="hidden" name="sea_cl_start_date_e_d" value="<?=$arrPostView['sea_cl_start_date_e_d']?>" />
	<INPUT type="hidden" name="sea_cl_limit_date_s_y" value="<?=$arrPostView['sea_cl_limit_date_s_y']?>" />
        <INPUT type="hidden" name="sea_cl_limit_date_s_m" value="<?=$arrPostView['sea_cl_limit_date_s_m']?>" />
        <INPUT type="hidden" name="sea_cl_limit_date_s_d" value="<?=$arrPostView['sea_cl_limit_date_s_d']?>" />
        <INPUT type="hidden" name="sea_cl_limit_date_e_y" value="<?=$arrPostView['sea_cl_limit_date_e_y']?>" />
        <INPUT type="hidden" name="sea_cl_limit_date_e_m" value="<?=$arrPostView['sea_cl_limit_date_e_m']?>" />
        <INPUT type="hidden" name="sea_cl_limit_date_e_d" value="<?=$arrPostView['sea_cl_limit_date_e_d']?>" />
	<INPUT type="hidden" name="search_flg" value="<?=$arrPostView['search_flg']?>" />
        <INPUT type="hidden" name="mode" value="NEW" />
	</FORM>
        <FORM action="client_download.php" method="POST" target="_self">
        <TD align="right"><INPUT type="submit" name="new" value="���饤����Ⱦ�������Download" class="btn_nosize" /></TD>
        </FORM>
      </TR>
    </TABLE>
    <HR color="#96BC69" />
    <TABLE>
    <TR><TD>
    <TABLE>
      <TR>
        <FORM name="client_search" method="POST" action="client_main.php" target="_self">
        <TD class="td_cl">�Ρ�����̾</TD>
        <TD><INPUT type="text" name="sea_cl_name_like" value="<?=$sea_cl_name_like?>" /></TD>
        <TD class="td_cl">��ƻ�ܸ�</TD>
        <TD>
          <SELECT name="sea_cl_pref">
            <OPTION value="">--����--</OPTION>
<?=$list_pref_start?>
          </SELECT>
        </TD>
        <TD class="td_cl">����</TD>
        <TD>
          <SELECT name="sea_cl_stat">
            <OPTION value="">----</OPTION>
            <OPTION value="1" <?=$statSelect1?>>ͭ��</OPTION>
            <OPTION value="9" <?=$statSelect2?>>̵��</OPTION>
          </SELECT>
        </TD>
        <TD class="td_cl">�ȼ��ե饰</TD>
        <TD>
          <SELECT name="sea_cl_dokuji_flg">
            <OPTION value="">----</OPTION>
            <OPTION value="1" <?=$dokujiSelect1?>>��</OPTION>
            <OPTION value="9" <?=$dokujiSelect2?>>�Բ�</OPTION>
          </SELECT>
        </TD>
        <TD class="td_cl">����Ǻ�</TD>
        <TD>
          <SELECT name="sea_cl_advertisement_flg">
            <OPTION value="">----</OPTION>
            <OPTION value="1" <?=$adverSelect1?>>��</OPTION>
            <OPTION value="9" <?=$adverSelect2?>>�Բ�</OPTION>
          </SELECT>
        </TD>
      </TR>
      <TR>
        <TD class="td_cl">ͭ�����³�����</TD>
        <TD colspan="7" align="left">
          <SELECT name="sea_cl_start_date_s_y">
            <OPTION value="">----</OPTION>
            <?=$list_y_start?>
          </SELECT>
          ǯ
          <SELECT name="sea_cl_start_date_s_m">
            <OPTION value="">--</OPTION>
            <?=$list_m_start?>
          </SELECT>
          ��
          <SELECT name="sea_cl_start_date_s_d">
            <OPTION value="">--</OPTION>
            <?=$list_d_start?>
          </SELECT>
          ��
          ��
          <SELECT name="sea_cl_start_date_e_y">
            <OPTION value="">----</OPTION>
            <?=$list_y2_start?>
          </SELECT>
          ǯ
          <SELECT name="sea_cl_start_date_e_m">
            <OPTION value="">--</OPTION>
            <?=$list_m2_start?>
          </SELECT>
          ��
          <SELECT name="sea_cl_start_date_e_d">
            <OPTION value="">--</OPTION>
            <?=$list_d2_start?>
          </SELECT>
          ��
        </TD>
      </TR>
      <TR>
        <TD class="td_cl">ͭ�����½�λ��</TD>
        <TD colspan="7" align="left">
          <SELECT name="sea_cl_limit_date_s_y">
            <OPTION value="">----</OPTION>
            <?=$list_y_limit?>
          </SELECT>
          ǯ
          <SELECT name="sea_cl_limit_date_s_m">
            <OPTION value="">--</OPTION>
            <?=$list_m_limit?>
          </SELECT>
          ��
          <SELECT name="sea_cl_limit_date_s_d">
            <OPTION value="">--</OPTION>
            <?=$list_d_limit?>
          </SELECT>
          ��
          ��
          <SELECT name="sea_cl_limit_date_e_y">
            <OPTION value="">----</OPTION>
            <?=$list_y2_limit?>
          </SELECT>
          ǯ
          <SELECT name="sea_cl_limit_date_e_m">
            <OPTION value="">--</OPTION>
            <?=$list_m2_limit?>
          </SELECT>
          ��
          <SELECT name="sea_cl_limit_date_e_d">
            <OPTION value="">--</OPTION>
            <?=$list_d2_limit?>
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
        <FORM name="client_search2" method="POST" action="client_main.php" target="_self">
        <INPUT type="submit" value="�����" />
        </FORM>
    </TD></TR>
    </TABLE>
    <HR color="#96BC69" />
    <TABLE>
      <TR>
        <TD class="td_cl" style="width:50">����</TD>
        <TD class="td_cl" style="width:50">�ݡ�����Ǻ�</TD>
        <TD class="td_cl" style="width:50">�ȼ��ɥᥤ��</TD>
        <TD class="td_cl" style="width:50">����<br>�Ǻ�</TD>
        <TD class="td_cl" style="width:200">��̾/����̾</TD>
        <TD class="td_cl">������ID</TD>
        <TD class="td_cl">������ѥ����</TD>
        <TD class="td_cl">URL�ѥ�����</TD>
        <TD class="td_cl">ͭ������</TD>
        <TD class="td_cl">&nbsp;</TD>
      </TR>
<?=$viewData?>
    </TABLE>
    <BR />
    <TABLE border="0" cellspacing="0" cellpadding="2" width="700" class="px12">
      <TR>
        <FORM name="client_list" method="POST" action="client_main.php">
        <INPUT type="hidden" name="stpos" value="" />
        <INPUT type="hidden" name="sea_cl_name_like" value="<?=$arrPostView['sea_cl_name_like']?>" />
        <INPUT type="hidden" name="sea_cl_dokuji_flg" value="<?=$arrPostView['sea_cl_dokuji_flg']?>" />
        <INPUT type="hidden" name="sea_cl_advertisement_flg" value="<?=$arrPostView['sea_cl_advertisement_flg']?>" />
        <INPUT type="hidden" name="sea_cl_pref" value="<?=$arrPostView['sea_cl_pref']?>" />
        <INPUT type="hidden" name="sea_cl_stat" value="<?=$arrPostView['sea_cl_stat']?>" />
        <INPUT type="hidden" name="sea_cl_dokuji_flg" value="<?=$arrPostView['sea_cl_dokuji_flg']?>" />
        <INPUT type="hidden" name="sea_cl_advertisement_flg" value="<?=$arrPostView['sea_cl_advertisement_flg']?>" />
        <INPUT type="hidden" name="sea_cl_start_date_s_y" value="<?=$arrPostView['sea_cl_start_date_s_y']?>" />
        <INPUT type="hidden" name="sea_cl_start_date_s_m" value="<?=$arrPostView['sea_cl_start_date_s_m']?>" />
        <INPUT type="hidden" name="sea_cl_start_date_s_d" value="<?=$arrPostView['sea_cl_start_date_s_d']?>" />
        <INPUT type="hidden" name="sea_cl_start_date_e_y" value="<?=$arrPostView['sea_cl_start_date_e_y']?>" />
        <INPUT type="hidden" name="sea_cl_start_date_e_m" value="<?=$arrPostView['sea_cl_start_date_e_m']?>" />
        <INPUT type="hidden" name="sea_cl_start_date_e_d" value="<?=$arrPostView['sea_cl_start_date_e_d']?>" />
        <INPUT type="hidden" name="sea_cl_limit_date_s_y" value="<?=$arrPostView['sea_cl_limit_date_s_y']?>" />
        <INPUT type="hidden" name="sea_cl_limit_date_s_m" value="<?=$arrPostView['sea_cl_limit_date_s_m']?>" />
        <INPUT type="hidden" name="sea_cl_limit_date_s_d" value="<?=$arrPostView['sea_cl_limit_date_s_d']?>" />
        <INPUT type="hidden" name="sea_cl_limit_date_e_y" value="<?=$arrPostView['sea_cl_limit_date_e_y']?>" />
        <INPUT type="hidden" name="sea_cl_limit_date_e_m" value="<?=$arrPostView['sea_cl_limit_date_e_m']?>" />
        <INPUT type="hidden" name="sea_cl_limit_date_e_d" value="<?=$arrPostView['sea_cl_limit_date_e_d']?>" />
        <INPUT type="hidden" name="search_flg" value="<?=$arrPostView['search_flg']?>" />
<?=$viewPageChangeValue?>
        </FORM>
      </TR>
    </TABLE>
  </BODY>
</HTML>
