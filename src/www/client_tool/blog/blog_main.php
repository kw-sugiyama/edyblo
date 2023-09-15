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
require_once ( "../html_replace.php" );
require_once ( SYS_PATH."dbif/dbcom_DBconnectClass.php" );
require_once ( SYS_PATH."dbif/basedb_ClientClass.php" );
require_once ( SYS_PATH."dbif/basedb_SchoolClass.php" );
require_once ( SYS_PATH."dbif/basedb_EnsenClass.php" );
require_once ( SYS_PATH."common/base_common.php" );
require_once ( SYS_PATH."common/sys_common.php" );
require_once ( SYS_PATH."common/error.class.php" );
require_once ( SYS_PATH."configs/param_base.conf" );
require_once ( SYS_PATH."configs/param_file.conf" );
require_once ( SYS_PATH."configs/param_blog.conf" );
require_once ( SYS_PATH."configs/param_map.conf" );


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
$obj = new basedb_SchoolClassTblAccess;
$obj->conn = $obj_conn->conn;
$obj->jyoken["sc_deldate"] = 1;
$obj->jyoken["sc_clid"] = $_SESSION["_cl_id"];
list( $intNum , $intTotal ) = $obj->basedb_GetSchool( 1 , -1 );
IF( $intNum == -1 ){
	$arrOther["ath_comment"] = "<INPUT TYPE=\"hidden\" NAME=\"stpos\" VALUE=\"{$_POST['stpos']}\">";
	$obj_error->ViewErrMessage( "SYSTEM" , "ALL" , SITE_PATH."blank.php" , $arrOther );
	exit;
}

$obj2 = new basedb_EnsenClassTblAccess;
$obj2->conn = $obj_conn->conn;
$obj2->jyoken["es_deldate"] = 1;
$obj2->jyoken["es_cd"] = $obj->blogdat[0]["sc_clid"];
$obj2->sort["es_dispno"] = 1;
list( $intNum , $intTotal ) = $obj2->basedb_GetEnsen( 1 , -1 );
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
$sc_title = htmlspecialchars ($obj->blogdat[0]["sc_title"]);
$sc_keywd = htmlspecialchars( str_replace( "-" , "," , $obj->blogdat[0]["sc_keywd"] ) );
$sc_introduce = str_replace("\r\n","<BR>",htmlspecialchars( $obj->blogdat[0]["sc_introduce"] ));
$sc_clr = htmlspecialchars ($obj->blogdat[0]["sc_clr"]);
IF( $sc_clr != "" ){
	FOREACH( $param_blog_color["id"] as $key => $val ){
		IF( $param_blog_color["id"][$key] == $sc_clr ){
			$sc_clr = "<IMG src=\"{$param_blog_color_path}{$param_blog_color["img"][$key]}\" alt=\"{$param_blog_color["val"][$key]}\" border=\"0\" />";
			break;
		}
	}
}

$sc_master = htmlspecialchars ($obj->blogdat[0]["sc_master"]);
$sc_position = htmlspecialchars ($obj->blogdat[0]["sc_position"]);


$sc_company = htmlspecialchars ($obj->blogdat[0]["sc_company"]);
$sc_topwindowtitle = htmlspecialchars ($obj->blogdat[0]["sc_topwindowtitle"]);
$sc_headertitle = htmlspecialchars ($obj->blogdat[0]["sc_headertitle"]);
$sc_toptitle = htmlspecialchars ($obj->blogdat[0]["sc_toptitle"]);
$sc_topsubtitle = htmlspecialchars ($obj->blogdat[0]["sc_topsubtitle"]);
$sc_campaintitle = htmlspecialchars ($obj->blogdat[0]["sc_campaintitle"]);
$sc_coursetitle = htmlspecialchars ($obj->blogdat[0]["sc_coursetitle"]);
$sc_diarytitle = htmlspecialchars ($obj->blogdat[0]["sc_diarytitle"]);
$sc_addmission = nl2br(htmlspecialchars ($obj->blogdat[0]["sc_addmission"]));


$sc_age = htmlspecialchars ($obj->blogdat[0]["sc_age"]);
if(($sc_age & 64) == 64 ){
	$ageValue .= "�Ҳ�͡�";
	$sc_age -= 64;
}
if(($sc_age & 32) == 32 ){
	$ageValue .= "�������";
	$sc_age -= 32;
}
if(($sc_age & 16) == 16 ){
	$ageValue .= "ϲ������";
	$sc_age -= 16;
}
if(($sc_age & 8) == 8 ){
	$ageValue .= "�⹻����";
	$sc_age -= 8;
}
if(($sc_age & 4) == 4 ){
	$ageValue .= "�������";
	$sc_age -= 4;
}
if(($sc_age & 2) == 2 ){
	$ageValue .= "��������";
	$sc_age -= 2;
}
if(($sc_age & 1) == 1 ){
	$ageValue .= "�Ļ���";
	$sc_age -= 1;
}

$sc_classform = htmlspecialchars ($obj->blogdat[0]["sc_classform"]);
if($sc_classform & 4)$classformValue .= "���� ";
if($sc_classform & 2)$classformValue .= "���Ϳ� ";
if($sc_classform & 1)$classformValue .= "����";

$sc_results = htmlspecialchars ($obj->blogdat[0]["sc_results"]);
$sc_students = htmlspecialchars ($obj->blogdat[0]["sc_students"]);


$sc_entrymail = htmlspecialchars ($obj->blogdat[0]["sc_entrymail"]);
$sc_infomail = htmlspecialchars ($obj->blogdat[0]["sc_infomail"]);
$sc_infomail2 = htmlspecialchars ($obj->blogdat[0]["sc_infomail2"]);
$sc_entrymail2= htmlspecialchars ($obj->blogdat[0]["sc_entrymail2"]);



$sc_start = htmlspecialchars ($obj->blogdat[0]["sc_start"]);
$sc_end = htmlspecialchars ($obj->blogdat[0]["sc_end"]);
IF( $sc_start != "" || $sc_start != "" ){
	$sc_end = $sc_start." �� ".$sc_end;
}
$sc_holiday = htmlspecialchars( $obj->blogdat[0]["sc_holiday"] );
$sc_hp = htmlspecialchars( $obj->blogdat[0]["sc_hp"] );

$sc_pr = nl2br(htmlspecialchars($obj->blogdat[0]["sc_pr"]));


$sc_privacy = str_replace("\r\n","<BR>",htmlspecialchars ($obj->blogdat[0]["sc_privacy"]));
$sc_movie = htmlspecialchars($obj->blogdat[0]["sc_movie"]);
$sc_rhtml = $obj->blogdat[0]["sc_rhtml"];
$sc_rhtml = html_replace( $sc_rhtml , "" , "" , "" , "" );
$sc_rhtml = nl2br($sc_rhtml);
$sc_lhtml = $obj->blogdat[0]["sc_lhtml"];
$sc_lhtml = html_replace( $sc_lhtml , "" , "" , "" , "" );
$sc_lhtml = nl2br($sc_lhtml);
//hatori================================================

$sc_thtml = nl2br($obj->blogdat[0]["sc_thtml"]);

//================================================
if($obj->blogdat[0]["sc_logo"] != ""){
	$sc_logo = "<IMG src=\"./img_thumbnail.php?w=200&h=60&dir={$param_cl_logo_path}&nm={$obj->blogdat[0]["sc_logo"]}\" border=\"1\" />";
}else{
	$sc_logo = "";
}

//================================================
if($obj->blogdat[0]["sc_logo_mobile"] != ""){
	$sc_logo_mobile= "<IMG src=\"./img_thumbnail.php?w=200&h=60&dir={$param_cl_logo_mobile_path}&nm={$obj->blogdat[0]["sc_logo_mobile"]}\" border=\"1\" />";
}else{
	$sc_logo_mobile= "";
}


//print_r($obj->blogdat[0]);
//================================================
if($obj->blogdat[0]["sc_topimg"] != ""){
	$sc_topimg = "<IMG src=\"./img_thumbnail.php?w=360&h=360&dir={$param_cl_photo_path}&nm={$obj->blogdat[0]["sc_topimg"]}\" border=\"1\" />";
}else{
	$sc_topimg = "";
}
if($obj->blogdat[0]["sc_mapimg"] != ""){
	$sc_mapimg = "<IMG src=\"./img_thumbnail.php?w=360&h=360&dir={$param_cl_staff_path}&nm={$obj->blogdat[0]["sc_mapimg"]}\" border=\"1\" />";
}else{
	$sc_mapimg = "";
}
if($obj->blogdat[0]["sc_ido"] != "" && $obj->blogdat[0]["sc_ido"] != null){
	$sc_ido = $obj->blogdat[0]["sc_ido"];
	$sc_keido = $obj->blogdat[0]["sc_keido"];
	$sc_zoom = $obj->blogdat[0]["sc_zoom"];
}

foreach($obj2->ensendat as $key2 => $val2){
	$es_id[$val2["es_dispno"]] = htmlspecialchars ($val2["es_id"]);
	$es_cd[$val2["es_dispno"]] = htmlspecialchars ($val2["es_cd"]);
	$es_type[$val2["es_dispno"]] = htmlspecialchars ($val2["es_type"]);
	$es_dispno[$val2["es_dispno"]] = htmlspecialchars ($val2["es_dispno"]);
	$es_pref[$val2["es_dispno"]] = htmlspecialchars ($val2["es_pref"]);
	$es_line[$val2["es_dispno"]] = htmlspecialchars ($val2["es_line"]);
	$es_linecd[$val2["es_dispno"]] = htmlspecialchars ($val2["es_linecd"]);
	$es_sta[$val2["es_dispno"]] = htmlspecialchars ($val2["es_sta"]);
	$es_stacd[$val2["es_dispno"]] = htmlspecialchars ($val2["es_stacd"]);
	$es_walk[$val2["es_dispno"]] = htmlspecialchars ($val2["es_walk"]);
	$es_bus[$val2["es_dispno"]] = htmlspecialchars ($val2["es_bus"]);
	$es_biko[$val2["es_dispno"]] = htmlspecialchars ($val2["es_biko"]);
	$es_adminid[$val2["es_dispno"]] = htmlspecialchars ($val2["es_adminid"]);
	$es_insdate[$val2["es_dispno"]] = htmlspecialchars ($val2["es_insdate"]);
	$es_upddate[$val2["es_dispno"]] = htmlspecialchars ($val2["es_upddate"]);
	$es_deldate[$val2["es_dispno"]] = htmlspecialchars ($val2["es_deldate"]);
	$es_yobi1[$val2["es_dispno"]] = htmlspecialchars ($val2["es_yobi1"]);
	$es_yobi2[$val2["es_dispno"]] = htmlspecialchars ($val2["es_yobi2"]);
	$es_yobi3[$val2["es_dispno"]] = htmlspecialchars ($val2["es_yobi3"]);
	$es_yobi4[$val2["es_dispno"]] = htmlspecialchars ($val2["es_yobi4"]);
	$es_yobi5[$val2["es_dispno"]] = htmlspecialchars ($val2["es_yobi5"]);
}
if($es_line[1]!=""){
	$moyori1 = $es_line[1].$es_sta[1]."�ء�����".$es_walk[1]."ʬ";
	if($es_bus[1]!="")$moyori1 .= "���Х�".$es_bus[1]."ʬ";
}
if($es_line[2]!=""){
	$moyori2 = $es_line[2].$es_sta[2]."�ء�����".$es_walk[2]."ʬ";
	if($es_bus[2]!="")$moyori2 .= "���Х�".$es_bus[2]."ʬ";
}
if($es_line[3]!=""){
	$moyori3 = $es_line[3].$es_sta[3]."�ء�����".$es_walk[3]."ʬ";
	if($es_bus[3]!="")$moyori3 .= "���Х�".$es_bus[3]."ʬ";
}
if($es_line[4]!=""){
	$moyori4 = $es_line[4].$es_sta[4]."�ء�����".$es_walk[4]."ʬ";
	if($es_bus[4]!="")$moyori4 .= "���Х�".$es_bus[4]."ʬ";
}
if($es_line[5]!=""){
	$moyori5 = $es_line[5].$es_sta[5]."�ء�����".$es_walk[5]."ʬ";
	if($es_bus[5]!="")$moyori5 .= "���Х�".$es_bus[5]."ʬ";
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
    <LINK rel="stylesheet" type="text/css" href="../share/css/blog.css" />
    <SCRIPT type="text/javascript" src="../share/js/GoogleMap.js"></SCRIPT>
    <NOSCRIPT><META http-equiv="Refresh" content="1;URL=../jserror.html"></NOSCRIPT>
    <script src="https://maps.googleapis.com/maps/api/js?key=<?=$param_api_key?>" type="text/javascript" charset="utf-8"></script>
  </HEAD>
  <BODY onload="loadMap('00001','<?=$sc_ido?>','<?=$sc_keido?>','<?=$sc_zoom?>','35.70972275209277','139.6527099609375','10','','','','<?=$param_marker_com_img?>','<?=$param_marker_shadow_img?>')">
<FORM name="go_company" method="POST" action="../cl/cl_main.php" target="_self">
</form>
<FORM name="go_layout" method="POST" action="../layout/layout_main.php" target="_self">
</form>
<FORM name="go_leftmenu" method="POST" action="../dai_leftmenu/leftmenu_main.php" target="_self">
</form>
<table style="width:100%">
  <tr>
	 <td style="width:20%">
<span style="font-size:15px;color:#6BD7B5;">��������</spann>
    </td>
    <td style="width:80%;text-align:right;">
      <INPUT type="button" value="���饤����Ⱦ�����" class="btn_nosize_grey" onclick="document.go_company.submit();return false;"/>&nbsp;
      <INPUT type="button" value="TOP���̥쥤������" class="btn_nosize_grey" onclick="document.go_layout.submit();return false;"/>&nbsp;
      <INPUT type="button" value="����˥塼��Ͽ" class="btn_nosize_grey" onclick="document.go_leftmenu.submit();return false;"/>
    </td>
  </tr>
</table>
    <HR color="#96BC69" />
    <TABLE>
      <TR>
        <FORM name="go_mnt" method="POST" action="blog_mnt.php" target="_self">
        <TD><INPUT type="submit" value="������Ͽ/��Ͽ���Ƥ��ѹ�����" class="btn_nosize"/></TD>
        </FORM>
      </TR>
    </TABLE>
    <DIV id="blog">
      <DIV id="title2">�������꣱</DIV>
      <TABLE>
<!--
        <TR>
          <TH>�֥������ȥ�</TH>
          <TD><?=$sc_title?></TD>
        </TR>
//-->
        <TR>
          <TH>�ǥ�������ץ����-<br />���ǥ��֥���ɽ��<br />�ʸ������󥸥��̥ƥ����ȡ�</TH>
          <TD><?=$sc_introduce?></TD>
        </TR>
        <TR>
          <TH>�ǥ�����ѥ�����</TH>
          <TD><?=$sc_clr?></TD>
        </TR>
        <TR>
			 <TH>SEO�к�����������</TH>
          <TD><?=$sc_keywd?>��</TD>
        </TR>
        <TR>
          <TH>���Ĳ��</TH>
          <TD><?=$sc_company?>��</TD>
        </TR>
        <TR>
          <TH>�ᥤ�󥿥��ȥ�<br />�ʸ������󥸥��̥����ȥ롦PC���̺Ǿ����ƥ����ȡ�</TH>
          <TD><?=$sc_topwindowtitle?>��</TD>
        </TR>
        <TR>
          <TH>�������ȥ�<br />�ʥ������ξҲ�ƥ����ȡ�</TH>
          <TD><?=$sc_headertitle?>��</TD>
        </TR>
        <TR>
          <TH>���Ф�-�����Ҳ�<br />�ʥȥåײ������</TH>
          <TD><?=$sc_toptitle?>��</TD>
        </TR>
        <TR>
          <TH>�����Ҳ������ʥȥåײ��������Υ�����Ǻܻ���</TH>
          <TD><?=$sc_topsubtitle?>��</TD>
        </TR>
        <TR>
          <TH>���Ф�-�ֽ������٥��<br />�ʥ��٥�ȥХʡ����</TH>
          <TD><?=$sc_campaintitle?>��</TD>
        </TR>
        <TR>
          <TH>���Ф�-������</TH>
          <TD><?=$sc_coursetitle?>��</TD>
        </TR>
        <TR>
          <TH>���Ф�-���Τ餻������</TH>
          <TD><?=$sc_diarytitle?>��</TD>
        </TR>
        <TR>
          <TH>���Τ�ή��ƥ�����<br />�����Τ�ή��ڡ����⡢�ȥåײ�������</TH>
          <TD><?=$sc_addmission?>��</TD>
        </TR>
      </TABLE>
      <br />
      <DIV id="title2">�᡼�������</DIV>
      <TABLE>
        <TR>
          <TH>�֤��������ߡ�<br />������᡼�륢�ɥ쥹</TH>
          <TD><?=$sc_entrymail?></TD>
        </TR>
        <TR>
          <TH>�֤��������ߡ�<br />������᡼�륢�ɥ쥹</TH>
          <TD><?=$sc_entrymail2?></TD>
        </TR>
        <TR>
          <TH>�ֻ��������<br />�֤��䤤��碌��<br />������᡼�륢�ɥ쥹</TH>
          <TD><?=$sc_infomail?></TD>
        </TR>
        <TR>
          <TH>�ֻ��������<br />�֤��䤤��碌��<br />������᡼�륢�ɥ쥹</TH>
          <TD><?=$sc_infomail2?></TD>
        </TR>
      </TABLE>
      <br />
      <DIV id="title2">�������ꣲ</DIV>
      <TABLE>
<!--
        <TR>
          <TH>������Ǥ��</TH>
          <TD><?=$sc_master?></TD>
        </TR>
        <TR>
          <TH>������Ǥ�Ը���</TH>
          <TD><?=$sc_position?></TD>
        </TR>
        <TR>
//-->
          <TH>�оݳ�ǯ��������<br />�ʥȥåײ��������Υ�����Ǻܻ���</TH>
          <TD><?=$ageValue?></TD>
        </TR>
        <TR>
          <TH>���ȷ��֥�������<br />�ʥȥåײ��������Υ�����Ǻܻ���</TH>
          <TD><?=$classformValue?></TD>
        </TR>
        <TR>
          <TH>���ջ���<br />�ʥ������ƥڡ����ǲ������ܾ����</TH>
          <TD><?=$sc_end?></TD>
        </TR>
        <TR>
          <TH>�����<br />�ʥ������ƥڡ����ǲ������ܾ����</TH>
          <TD><?=$sc_holiday?></TD>
        </TR>
<!--
        <TR>
          <TH>��ҥۡ���ڡ���</TH>
          <TD><?=$sc_hp?></TD>
        </TR>
//-->
        <TR>
          <TH>����<br />�ʳƥڡ����ǲ������ܾ����</TH>
          <TD><?=$moyori1?></TD>
        </TR>
<!--
        <TR>
          <TH>�Ǵ��2</TH>
          <TD><?=$moyori2?></TD>
        </TR>
-->
<!-- 
       <TR>
          <TH>�Ǵ��3</TH>
          <TD><?=$moyori3?></TD>
        </TR>
        <TR>
          <TH>�Ǵ��4</TH>
          <TD><?=$moyori4?></TD>
        </TR>
        <TR>
          <TH>�Ǵ��5</TH>
          <TD><?=$moyori5?></TD>
        </TR>
        <TR>
          <TH>���ӹ�</TH>
          <TD><?=$sc_results?></TD>
        </TR>
        <TR>
          <TH>�߹����̳ع�</TH>
          <TD><?=$sc_students?></TD>
        </TR>
//-->
        <TR>
          <TH>�����Ҳ�ƥ�����<br />�ʥȥåײ��������Υ�����Ǻܻ���</TH>
          <TD><?=$sc_pr?></TD>
        </TR>
        <TR>
          <TH>������</TH>
          <TD><?=$sc_logo?></TD>
        </TR>
        <TR>
          <TH>��Х���<br />������</TH>
          <TD><?=$sc_logo_mobile?></TD>
        </TR>
        <TR>
          <TH>�ȥåײ���</TH>
          <TD><?=$sc_topimg?></TD>
        </TR>
        <TR>
          <TH>���ܾ������<br />�ʳƥڡ����ǲ������ܾ����</TH>
          <TD><?=$sc_mapimg?></TD>
        </TR>
<!--
        <TR>
          <TH>��ҳ�����ư��</TH>
          <TD><?=$sc_movie?></TD>
        </TR>
//-->
        <TR>
          <TH>�����Ͽ�<br />�ʶ�������ڡ������</TH>
            <TD>
		<div id="gmap" style="width:300px; height: 200px"></div>
		������:
		<input type="button" value="��" onclick="zmup()">
		<input type="button" value="��" onclick="zmdown()">
		<input type="hidden" id="zoomN" name="zoom2" value="<?=$sc_zoom?>">
		<input type="hidden" id="marker_flg" name="mkr_flg" value="">
          </TD>
        </TR>
        <TR>
          <TH>�Ŀ;����ݸ�����</TH>
          <TD><?=$sc_privacy?></TD>
        </TR>
<!--
        <TR>
          <TH>HTML��ͳɽ������(����˥塼��)</TH>
          <TD><?=$sc_rhtml?></TD>
        </TR>
//-->
        <TR>
          <TH>HTML��ͳɽ������(����)</TH>
          <TD> <?=$sc_thtml?> </TD>
        </TR>
        <TR>
          <TH>HTML��ͳɽ������(����˥塼��)</TH>
          <TD><?=$sc_lhtml?></TD>
        </TR>

      </TABLE>
    </DIV>
    <br />
    <TABLE>
      <TR>
        <FORM name="go_mnt" method="POST" action="blog_mnt.php" target="_self">
        <TD><INPUT type="submit" value="������Ͽ/��Ͽ���Ƥ��ѹ����롡" class="btn_nosize"/></TD>
        </FORM>
      </TR>
    </TABLE>
  </BODY>
</HTML>
