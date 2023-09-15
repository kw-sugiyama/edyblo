<?
/******************************************************************************
<< ��ư���֥���Ver.1.O.0 >>
	Name: campain_main.php
	Version: 1.0.0
	Function: �������� ��Ͽ�����������
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
require_once ( SYS_PATH."dbif/basedb_CampainClass.php" );
require_once ( SYS_PATH."dbif/basedb_CategoryClass.php" );
require_once ( SYS_PATH."dbif/basedb_TeacherClass.php" );
require_once ( SYS_PATH."common/base_common.php" );
require_once ( SYS_PATH."common/sys_common.php" );
require_once ( SYS_PATH."common/form_common.php" );
include_once ( SYS_PATH."common/error.class.php" );
require_once ( SYS_PATH."configs/param_base.conf" );
require_once ( SYS_PATH."configs/param_file.conf" );
require_once ( SYS_PATH."configs/param_map.conf" );
require_once ( SYS_PATH."configs/param_blog.conf" );


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

if($_POST['error_mode']=="on"){
	foreach($_POST as $key => $val){
		$arrData[$key] = stripslashes($val);
	}

		$obj = new basedb_CampainClassTblAccess;
		$obj->conn = $obj_conn->conn;
		$obj->jyoken["cp_del_date"] = 1;
		$obj->jyoken["cp_id"] = $_POST['cp_id'];
		list( $intCnt , $intTotal ) = $obj->basedb_GetCampain( 1 , -1 );
		IF( $intCnt == -1 ){
			$arrOther["ath_comment"] = "<INPUT TYPE=\"hidden\" NAME=\"stpos\" VALUE=\"{$_POST['stpos']}\">";
			$obj_error->ViewErrMessage( "SYSTEM" , "ALL" , SITE_PATH."blank.php" , $arrOther );
			exit;
		}


		$cp_id = htmlspecialchars ($arrData["cp_id"]);
		$cp_clid = htmlspecialchars ($arrData["cp_clid"]);

		$cp_stat = htmlspecialchars ($arrData["cp_stat"]);
		$cp_flg = htmlspecialchars ($arrData["cp_flg"]);
		$cp_topflg = htmlspecialchars ($arrData["cp_topflg"]);
		$cp_tcid = htmlspecialchars ($arrData["cp_tcid"]);
		$cp_tccomment = htmlspecialchars ($arrData["cp_tccomment"]);
		$cp_start = htmlspecialchars ($arrData["cp_start"]);
		$cp_end = htmlspecialchars ($arrData["cp_end"]);

		$cp_camstart = htmlspecialchars ($arrData["cp_camstart"]);
		$cp_camend = htmlspecialchars ($arrData["cp_camend"]);
		$cp_cgid = htmlspecialchars ($arrData["cp_cgid"]);
		$cp_title = htmlspecialchars ($arrData["cp_title"]);
		$cp_subtitle = htmlspecialchars ($arrData["cp_subtitle"]);
		$cp_linktext = htmlspecialchars ($arrData["cp_linktext"]);
		$cp_btntext = htmlspecialchars ($arrData["cp_btntext"]);
		$cp_contents = htmlspecialchars ($arrData["cp_contents"]);
		$cp_age = htmlspecialchars ($arrData["cp_age"]);

		$cp_bkgdimg = htmlspecialchars ($arrData["cp_bkgdimg"]);
		$cp_bgdimgorg = htmlspecialchars ($arrData["cp_bgdimgorg"]);
		$cp_img1 = htmlspecialchars ($arrData["cp_img1"]);
		$cp_imgorg1 = htmlspecialchars ($arrData["cp_imgorg1"]);
		$cp_img1 = htmlspecialchars ($arrData["cp_img1"]);
		$cp_imgorg1 = htmlspecialchars ($arrData["cp_imgorg1"]);
		$cp_img1 = htmlspecialchars ($arrData["cp_img1"]);
		$cp_imgorg1 = htmlspecialchars ($arrData["cp_imgorg1"]);
		$cp_img1 = htmlspecialchars ($arrData["cp_img1"]);
		$cp_imgorg1 = htmlspecialchars ($arrData["cp_imgorg1"]);

		$cp_topflg = htmlspecialchars ($arrData["cp_topflg"]);
		$cp_tcid = htmlspecialchars ($arrData["cp_tcid"]);
		$cp_ido = htmlspecialchars ($arrData["cp_ido"]);
		$cp_keido = htmlspecialchars ($arrData["cp_keido"]);
		$cp_zoom = htmlspecialchars ($arrData["cp_zoom"]);

		$cp_adminid = htmlspecialchars ($arrData["cp_adminid"]);
		$cp_insdate = htmlspecialchars ($arrData["cp_insdate"]);
		$cp_upddate = htmlspecialchars ($arrData["cp_upddate"]);
		$cp_upddate = htmlspecialchars ($arrData["cp_upddate"]);

	if($_POST['mode']=="EDIT"){
		$modeName = "��Ͽ����";

		
		$DEL_VALUE = "";
		$DEL_VALUE .="<form action=\"campain_upd.php\" method=\"POST\" name=\"del_form\">\n";
	        $DEL_VALUE .="<td align=\"center\" valign=\"top\">\n";
	        $DEL_VALUE .="    <input type=\"button\" value=\"�������\" onclick=\"CampainDeleteCheck( this.form , this.form )\" class=\"btn_nosize\" style=\"width:150px;\" />\n";
	        $DEL_VALUE .="    <input type=\"hidden\" name=\"mode\" value=\"DEL\" />\n";
	        $DEL_VALUE .="    <input type=\"hidden\" name=\"cp_id\" value=\"{$cp_id}\" />\n";
	        $DEL_VALUE .="    <input type=\"hidden\" name=\"cp_upddate\" value=\"{$cp_upddate}\" />\n";
	        $DEL_VALUE .="    <INPUT type=\"hidden\" name=\"cp_img1_lastupd\" value=\"{$cp_img1_lastupd}\" />\n";
	        $DEL_VALUE .="    <INPUT type=\"hidden\" name=\"cp_img2_lastupd\" value=\"{$cp_img2_lastupd}\" />\n";
	        $DEL_VALUE .="    <INPUT type=\"hidden\" name=\"cp_img3_lastupd\" value=\"{$cp_img3_lastupd}\" />\n";
	        $DEL_VALUE .="    <INPUT type=\"hidden\" name=\"cp_img4_lastupd\" value=\"{$cp_img4_lastupd}\" />\n";
	        $DEL_VALUE .="    <INPUT type=\"hidden\" name=\"cp_bkgdimg_lastupd\" value=\"{$cp_bkgdimg_lastupd}\" />\n";
	        $DEL_VALUE .="</td>\n";
	        $DEL_VALUE .="</form>\n";


	}else if($_POST['mode']=="NEW"){

		$modeName = "��Ͽ����";
		$cp_zoom = 10;

	}
}else{
	if($_POST['mode']=="EDIT"){
		$obj = new basedb_CampainClassTblAccess;
		$obj->conn = $obj_conn->conn;
		$obj->jyoken["cp_del_date"] = 1;
		$obj->jyoken["cp_id"] = $_POST['cp_id'];
		list( $intCnt , $intTotal ) = $obj->basedb_GetCampain( 1 , -1 );
		IF( $intCnt == -1 ){
			$arrOther["ath_comment"] = "<INPUT TYPE=\"hidden\" NAME=\"stpos\" VALUE=\"{$_POST['stpos']}\">";
			$obj_error->ViewErrMessage( "SYSTEM" , "ALL" , SITE_PATH."blank.php" , $arrOther );
			exit;
		}

		$cp_id = htmlspecialchars ($obj->campaindat[0]["cp_id"]);
		$cp_clid = htmlspecialchars ($obj->campaindat[0]["cp_clid"]);

		$cp_stat = htmlspecialchars ($obj->campaindat[0]["cp_stat"]);
		$cp_flg = htmlspecialchars ($obj->campaindat[0]["cp_flg"]);
		$cp_topflg = htmlspecialchars ($obj->campaindat[0]["cp_topflg"]);
		$cp_tcid = htmlspecialchars ($obj->campaindat[0]["cp_tcid"]);
		$cp_tccomment = htmlspecialchars ($obj->campaindat[0]["cp_tccomment"]);
		$cp_start = htmlspecialchars ($obj->campaindat[0]["cp_start"]);
		$cp_end = htmlspecialchars ($obj->campaindat[0]["cp_end"]);

		$cp_camstart = htmlspecialchars ($obj->campaindat[0]["cp_camstart"]);
		$cp_camend = htmlspecialchars ($obj->campaindat[0]["cp_camend"]);
		$cp_cgid = htmlspecialchars ($obj->campaindat[0]["cp_cgid"]);
		$cp_title = htmlspecialchars ($obj->campaindat[0]["cp_title"]);
		$cp_subtitle = htmlspecialchars ($obj->campaindat[0]["cp_subtitle"]);
		$cp_linktext = htmlspecialchars ($obj->campaindat[0]["cp_linktext"]);
		$cp_btntext = htmlspecialchars ($obj->campaindat[0]["cp_btntext"]);
		$cp_contents = htmlspecialchars ($obj->campaindat[0]["cp_contents"]);
		$cp_age = htmlspecialchars ($obj->campaindat[0]["cp_age"]);

		$cp_bkgdimg = htmlspecialchars ($obj->campaindat[0]["cp_bkgdimg"]);
		$cp_bgdimgorg = htmlspecialchars ($obj->campaindat[0]["cp_bgdimgorg"]);
		$cp_img1 = htmlspecialchars ($obj->campaindat[0]["cp_img1"]);
		$cp_imgorg1 = htmlspecialchars ($obj->campaindat[0]["cp_imgorg1"]);
		$cp_img1 = htmlspecialchars ($obj->campaindat[0]["cp_img1"]);
		$cp_imgorg1 = htmlspecialchars ($obj->campaindat[0]["cp_imgorg1"]);
		$cp_img1 = htmlspecialchars ($obj->campaindat[0]["cp_img1"]);
		$cp_imgorg1 = htmlspecialchars ($obj->campaindat[0]["cp_imgorg1"]);
		$cp_img1 = htmlspecialchars ($obj->campaindat[0]["cp_img1"]);
		$cp_imgorg1 = htmlspecialchars ($obj->campaindat[0]["cp_imgorg1"]);

		$cp_topflg = htmlspecialchars ($obj->campaindat[0]["cp_topflg"]);
		$cp_tcid = htmlspecialchars ($obj->campaindat[0]["cp_tcid"]);
		$cp_ido = htmlspecialchars ($obj->campaindat[0]["cp_ido"]);
		$cp_keido = htmlspecialchars ($obj->campaindat[0]["cp_keido"]);
		$cp_zoom = htmlspecialchars ($obj->campaindat[0]["cp_zoom"]);

		$cp_adminid = htmlspecialchars ($obj->campaindat[0]["cp_adminid"]);
		$cp_insdate = htmlspecialchars ($obj->campaindat[0]["cp_insdate"]);
		$cp_upddate = htmlspecialchars ($obj->campaindat[0]["cp_upddate"]);

		$modeName = "��Ͽ����";
		
		$DEL_VALUE = "";
		$DEL_VALUE .="<form action=\"campain_upd.php\" method=\"POST\" name=\"del_form\">\n";
	        $DEL_VALUE .="<td align=\"center\" valign=\"top\">\n";
	        $DEL_VALUE .="    <input type=\"button\" value=\"�������\" onclick=\"CampainDeleteCheck( this.form , this.form )\" class=\"btn_nosize\" style=\"width:150px;\" />\n";
	        $DEL_VALUE .="    <input type=\"hidden\" name=\"mode\" value=\"DEL\" />\n";
	        $DEL_VALUE .="    <input type=\"hidden\" name=\"cp_id\" value=\"{$cp_id}\" />\n";
	        $DEL_VALUE .="    <input type=\"hidden\" name=\"cp_upddate\" value=\"{$cp_upddate}\" />\n";
	        $DEL_VALUE .="    <INPUT type=\"hidden\" name=\"cp_img1_lastupd\" value=\"{$cp_img1_lastupd}\" />\n";
	        $DEL_VALUE .="    <INPUT type=\"hidden\" name=\"cp_img2_lastupd\" value=\"{$cp_img2_lastupd}\" />\n";
	        $DEL_VALUE .="    <INPUT type=\"hidden\" name=\"cp_img3_lastupd\" value=\"{$cp_img3_lastupd}\" />\n";
	        $DEL_VALUE .="    <INPUT type=\"hidden\" name=\"cp_img4_lastupd\" value=\"{$cp_img4_lastupd}\" />\n";
	        $DEL_VALUE .="    <INPUT type=\"hidden\" name=\"cp_img4_lastupd\" value=\"{$cp_bkgdimg_lastupd}\" />\n";
	        $DEL_VALUE .="</td>\n";
	        $DEL_VALUE .="</form>\n";


	}else if($_POST['mode']=="NEW"){

		$modeName = "��Ͽ����";
		$cp_zoom = 10;

	}
}

// �����ڡ���Хʡ�
// 2���1��
asort( $param_campain_banner["disp_no"] );
$bannerView = "";
$Cnt = 0;
$rowflg = false;
FOREACH( $param_campain_banner["disp_no"] as $key => $val ){
	$Cnt++;

	$strChk = "";
	if( $param_campain_banner["img"][$key] == $cp_bkgdimg ) $strChk = " checked";

	if ($Cnt % 2 == 1) {
		$bannerView .= "  <tr>\n";
		$rowflg = true;	// �Ԥ��Ϥޤä��ե饰
	}

	$bannerView .= "    <td><INPUT TYPE=\"radio\" NAME=\"cp_bkgdimg\" VALUE=\"{$param_campain_banner["img"][$key]}\"{$strChk}></td>\n";
	//$bannerView .= "    <td><a href=\"{$param_campain_banner_path}{$param_campain_banner["img"][$key]}\" target=\"_blank\"><IMG src=\"{$param_campain_banner_path}{$param_campain_banner["img"][$key]}\" alt=\"{$param_campain_banner["val"][$key]}\" border=\"0\" width=\"297\" height=\"60\" /></a></td>\n";
	$bannerView .= "    <td><a href=\"{$param_campain_banner_path}{$param_campain_banner["img"][$key]}\" target=\"_blank\"><IMG src=\"{$param_campain_banner_path}{$param_campain_banner["img"][$key]}\" alt=\"{$param_campain_banner["val"][$key]}\" border=\"0\" width=\"267\" height=\"54\" /></a></td>\n";

        if ($Cnt % 2 == 0) {
        	$bannerView .= "  </tr>\n";
        	$rowflg = false;	// �Ԥ�����ä��ե饰
        }
}

// �Хʡ������������ä�
// <tr>���ޤ�����äƤ��ʤ��ä��齪��餻��
if ($bannerView != "") {
	if ($rowflg == true) {
		$bannerView .= "  </tr>\n";
	}
}


// ������
$cp_img1_dir = $param_cp_img1_path;
$cp_img1_arr["org"] = $cp_imgorg1;
$cp_img1_arr["chk_in"] = "1";
$cp_img1_txt =  form_ImgDisp( "cp_img1" , $cp_img1_dir , $obj->campaindat[0]["cp_img1"] , "1" , $cp_img1_arr );

$cp_img2_dir = $param_cp_img2_path;
$cp_img2_arr["org"] = $cp_imgorg2;
$cp_img2_arr["chk_in"] = "1";
$cp_img2_txt =  form_ImgDisp( "cp_img2" , $cp_img2_dir , $obj->campaindat[0]["cp_img2"] , "1" , $cp_img2_arr );

$cp_img3_dir = $param_cp_img3_path;
$cp_img3_arr["org"] = $cp_imgorg3;
$cp_img3_arr["chk_in"] = "1";
$cp_img3_txt =  form_ImgDisp( "cp_img3" , $cp_img3_dir , $obj->campaindat[0]["cp_img3"] , "1" , $cp_img3_arr );

$cp_img4_dir = $param_cp_img4_path;
$cp_img4_arr["org"] = $cp_imgorg4;
$cp_img4_arr["chk_in"] = "1";
$cp_img4_txt =  form_ImgDisp( "cp_img4" , $cp_img4_dir , $obj->campaindat[0]["cp_img4"] , "1" , $cp_img4_arr );

//$cp_bkgdimg_dir = $param_cp_bkgdimg_path;
//$cp_bkgdimg_arr["org"] = $cp_imgorg5;
//$cp_bkgdimg_arr["chk_in"] = "1";
//$cp_bkgdimg_txt =  form_ImgDisp( "cp_bkgdimg" , $cp_bkgdimg_dir , $obj->campaindat[0]["cp_bkgdimg"] , "1" , $cp_bkgdimg_arr );


$obj_cate = new basedb_CategoryClassTblAccess;
$obj_cate->conn = $obj_conn->conn;
$obj_cate->jyoken["cg_deldate"] = 1;
$obj_cate->jyoken["cg_stat"] = 1;
$obj_cate->jyoken["cg_type"] = 6;
$obj_cate->jyoken["cg_clid"] = $_SESSION['_cl_id'];
$obj_cate->sort["cg_dispno"] = 2;
list( $intCnt , $intTotal ) = $obj_cate->basedb_GetCategory( 1 , -1 );
IF( $intCnt == -1 ){
	$arrOther["ath_comment"] = "<INPUT TYPE=\"hidden\" NAME=\"stpos\" VALUE=\"{$_POST['stpos']}\">";
	$obj_error->ViewErrMessage( "SYSTEM" , "ALL" , SITE_PATH."blank.php" , $arrOther );
	exit;
}
for($i=0;$i<$intCnt;$i++){
	$cg_select ="";
	$category_name ="";
	$category_id ="";
	$category_name = $obj_cate->categorydat[$i]["cg_stitle"];
	$category_id = $obj_cate->categorydat[$i]["cg_id"];
	if($category_id == $cp_cgid && $cp_cgid!="")$cg_select = "selected";
	$cateValue .= "<OPTION VALUE=\"{$category_id}\" {$cg_select}>{$category_name}</OPTION>";
}

if($cp_zoom=="")$cp_zoom = 10;


// ����
$statchecked1 = "";
$statchecked2 = "";
$statchecked3 = "";
if( $cp_stat == 1 ){
	 $statchecked1 = " checked";
}else if( $cp_stat == 2 ){
	 $statchecked2 = " checked";
}


// �ԣϣХե饰
$topflgchecked1 = "";
$topflgchecked2 = "";
$topflgchecked3 = "";
if( $cp_topflg == 1 ){
	 $topflgchecked1 = " checked";
}else if( $cp_topflg == 2 ){
	 $topflgchecked2 = " checked";
}else if( $cp_topflg == 3 ){
	 $topflgchecked3 = " checked";
}else{
	 $topflgchecked1 = " checked";
}


// �ֻեǡ�������
$obj_teacher = new basedb_TeacherClassTblAccess;
$obj_teacher->conn = $obj_conn->conn;
$obj_teacher->jyoken["tc_deldate"] = 1;
$obj_teacher->jyoken["tc_clid"] = $_SESSION['_cl_id'];
$obj_teacher->sort["tc_upd_date"] = 2;
list( $intCntTc , $intTotalTc ) = $obj_teacher->basedb_GetTeacher( 1 , -1 );
IF( $intCntTc == -1 ){
	$arrOther["ath_comment"] = "<INPUT TYPE=\"hidden\" NAME=\"stpos\" VALUE=\"{$_POST['stpos']}\">";
	$obj_error->ViewErrMessage( "SYSTEM" , "ALL" , SITE_PATH."blank.php" , $arrOther );
	exit;
}
for($i=0;$i<$intCntTc;$i++){
	$tc_select ="";
	$teacher_name ="";
	$teacher_id ="";
	$teacher_name = $obj_teacher->teacherdat[$i]["tc_name"];
	$teacher_id = $obj_teacher->teacherdat[$i]["tc_id"];
	if($teacher_id == $cp_tcid && $cp_tcid!="")$tc_select = "selected";
	$teacerValue .= "<OPTION VALUE=\"{$teacher_id}\" {$tc_select}>{$teacher_name}</OPTION>";
}


// �оݳ�ǯ
if( ($cp_age & 128) == 128 ){
	$agechecked8 = " checked";
	$cp_age -= 128;
}
if( ($cp_age & 64) == 64 ){
	$agechecked7 = " checked";
	$cp_age -= 64;
}
if( ($cp_age & 32) == 32 ){
	$agechecked6 = " checked";
	$cp_age -= 32;
}
if( ($cp_age & 16) == 16 ){
	$agechecked5 = " checked";
	$cp_age -= 16;
}
if( ($cp_age & 8) == 8 ){
	$agechecked4 = " checked";
	$cp_age -= 8;
}
if( ($cp_age & 4) == 4 ){
	$agechecked3 = " checked";
	$cp_age -= 4;
}
if( ($cp_age & 2) == 2 ){
	$agechecked2 = " checked";
	$cp_age -= 2;
}
if( ($cp_age & 1) == 1 ){
	$agechecked1 = " checked";
	$cp_age -= 1;
}


// ��٥�
if( $cp_level == 1 ){
	 $levelchecked1 = " checked";
}else if( $cp_level == 2 ){
	 $levelchecked2 = " checked";
}else if( $cp_level == 3 ){
	 $levelchecked3 = " checked";
}else if( $cp_level == 4 ){
	 $levelchecked4 = " checked";
}else{
	 $levelchecked1 = " checked";
}


// ��Ū
if( $cp_purpose == 1 ){
	 $purposechecked1 = " checked";
}else if( $cp_purpose == 2 ){
	 $purposechecked2 = " checked";
}else if( $cp_purpose == 3 ){
	 $purposechecked3 = " checked";
}else if( $cp_purpose == 4 ){
	 $purposechecked4 = " checked";
}else if( $cp_purpose == 5 ){
	 $purposechecked5 = " checked";
}else if( $cp_purpose == 6 ){
	 $purposechecked6 = " checked";
}else{
	 $purposechecked1 = " checked";
}


// �Ķȳ��ϻ��֡ʻ���ʬ��
IF( $cp_start != "" ){
	$arrBuffStartTime2 = explode( " " , $cp_start );
	$arrBuffStartTime = explode( "-" , $arrBuffStartTime2[0] );
}ELSE{
	$arrBuffStartTime = "";
}
$viewStartTime_h = "";
$iX=0;
FOR( $iX=1; $iX<13; $iX++ ){
	$buffInt = "";
	$buffInt = sprintf( "%02d" , $iX );
	$strSel = "";
	IF( $buffInt == $arrBuffStartTime[1] ) $strSel = " selected";
	$viewStartTime_h .= "<OPTION value=\"{$buffInt}\"{$strSel}>{$buffInt}</OPTION>\n";
}
$viewStartTime_m = "";
$iX=0;
WHILE( $iX<31 ){
	$buffInt = "";
	$buffInt = sprintf( "%02d" , $iX );
	$strSel = "";
	IF( $buffInt == $arrBuffStartTime[2] ) $strSel = " selected";
	$viewStartTime_m .= "<OPTION value=\"{$buffInt}\"{$strSel}>{$buffInt}</OPTION>\n";
	$iX = $iX+1;
}

// �ĶȽ�λ���֡ʻ���ʬ��
IF( $cp_end != "" ){
	$arrBuffEndTime2 = explode( " " , $cp_end );
	$arrBuffEndTime = explode( "-" , $arrBuffEndTime2[0] );
}ELSE{
	$arrBuffEndTime = "";
}
$viewEndTime_h = "";
FOR( $iX=1; $iX<13; $iX++ ){
	$buffInt = "";
	$buffInt = sprintf( "%02d" , $iX );
	$strSel = "";
	IF( $buffInt == $arrBuffEndTime[1] ) $strSel = " selected";
	$viewEndTime_h .= "<OPTION value=\"{$buffInt}\"{$strSel}>{$buffInt}</OPTION>\n";
}
$viewEndTime_m = "";
$iX=0;
WHILE( $iX<31 ){
	$buffInt = "";
	$buffInt = sprintf( "%02d" , $iX );
	$strSel = "";
	IF( $buffInt == $arrBuffEndTime[2] ) $strSel = " selected";
	$viewEndTime_m .= "<OPTION value=\"{$buffInt}\"{$strSel}>{$buffInt}</OPTION>\n";
	$iX = $iX+1;
}


// �Ķȳ��ϻ��֡ʻ���ʬ��
IF( $cp_camstart != "" ){
	$arrBuffCamStartTime2 = explode( " " , $cp_camstart );
	$arrBuffCamStartTime = explode( "-" , $arrBuffCamStartTime2[0] );
}ELSE{
	$arrBuffCamStartTime = "";
}
$viewCamStartTime_h = "";
$iX=0;
FOR( $iX=1; $iX<13; $iX++ ){
	$buffInt = "";
	$buffInt = sprintf( "%02d" , $iX );
	$strSel = "";
	IF( $buffInt == $arrBuffCamStartTime[1] ) $strSel = " selected";
	$viewCamStartTime_h .= "<OPTION value=\"{$buffInt}\"{$strSel}>{$buffInt}</OPTION>\n";
}
$viewCamStartTime_m = "";
$iX=0;
WHILE( $iX<31 ){
	$buffInt = "";
	$buffInt = sprintf( "%02d" , $iX );
	$strSel = "";
	IF( $buffInt == $arrBuffStartTime[2] ) $strSel = " selected";
	$viewCamStartTime_m .= "<OPTION value=\"{$buffInt}\"{$strSel}>{$buffInt}</OPTION>\n";
	$iX = $iX+1;
}

// �ĶȽ�λ���֡ʻ���ʬ��
IF( $cp_camend != "" ){
	$arrBuffCamEndTime2 = explode( " " , $cp_camend );
	$arrBuffCamEndTime = explode( "-" , $arrBuffCamEndTime2[0] );
}ELSE{
	$arrBuffCamEndTime = "";
}
$viewCamEndTime_h = "";
FOR( $iX=1; $iX<13; $iX++ ){
	$buffInt = "";
	$buffInt = sprintf( "%02d" , $iX );
	$strSel = "";
	IF( $buffInt == $arrBuffCamEndTime[1] ) $strSel = " selected";
	$viewCamEndTime_h .= "<OPTION value=\"{$buffInt}\"{$strSel}>{$buffInt}</OPTION>\n";
}
$viewCamEndTime_m = "";
$iX=0;
WHILE( $iX<31 ){
	$buffInt = "";
	$buffInt = sprintf( "%02d" , $iX );
	$strSel = "";
	IF( $buffInt == $arrBuffCamEndTime[2] ) $strSel = " selected";
	$viewCamEndTime_m .= "<OPTION value=\"{$buffInt}\"{$strSel}>{$buffInt}</OPTION>\n";
	$iX = $iX+1;
}


/*--------------------------------------------------------
	ɽ���ꥹ�ȹ��ܺ���
--------------------------------------------------------*/
$lsy_base = date("Y");
$lsy = $lsy_base - 3;
$ley = $lsy_base + 3;
// ͭ�����³���(ǯ)
FOR( $iX=$lsy; $iX<$ley; $iX++ ){
	$strSel = "";
	IF( $iX == intval($arrBuffStartTime[0]) ) $strSel = " selected";
	$start_y .= "              <OPTION value=\"{$iX}\"{$strSel}>{$iX}</OPTION>\n";
}


// ͭ�����³���(��)
$start_m = "";
FOR( $iX=1; $iX<13; $iX++ ){
	$strSel = "";
	IF( $iX == intval($arrBuffStartTime[1]) ) $strSel = " selected";
	$start_m .= "              <OPTION value=\"{$iX}\"{$strSel}>{$iX}</OPTION>\n";
}


// ͭ�����³���(��)
$start_d = "";
FOR( $iX=1; $iX<32; $iX++ ){
	$strSel = "";
	IF( $iX == intval($arrBuffStartTime[2]) ) $strSel = " selected";
	$start_d .= "              <OPTION value=\"{$iX}\"{$strSel}>{$iX}</OPTION>\n";
}


// ͭ�����½�λ(ǯ)
$end_y = "";
FOR( $iX=$lsy; $iX<$ley; $iX++ ){
	$strSel = "";
	IF( $iX == intval($arrBuffEndTime[0]) ) $strSel = " selected";
	$end_y .= "              <OPTION value=\"{$iX}\"{$strSel}>{$iX}</OPTION>\n";
}

// ͭ�����½�λ(��)
$end_m = "";
FOR( $iX=1; $iX<13; $iX++ ){
	$strSel = "";
	IF( $iX == intval($arrBuffEndTime[1]) ) $strSel = " selected";
	$end_m .= "              <OPTION value=\"{$iX}\"{$strSel}>{$iX}</OPTION>\n";
}

// ͭ�����½�λ(��)
$end_d = "";
FOR( $iX=1; $iX<32; $iX++ ){
	$strSel = "";
	IF( $iX == intval($arrBuffEndTime[2]) ) $strSel = " selected";
	$end_d .= "              <OPTION value=\"{$iX}\"{$strSel}>{$iX}</OPTION>\n";
}


/*--------------------------------------------------------
	ɽ���ꥹ�ȹ��ܺ���
--------------------------------------------------------*/
$lsy_base = date("Y");
$lsy = $lsy_base - 3;
$ley = $lsy_base + 3;
// ͭ�����³���(ǯ)
FOR( $iX=$lsy; $iX<$ley; $iX++ ){
	$strSel = "";
	IF( $iX == intval($arrBuffCamStartTime[0]) ) $strSel = " selected";
	$camstart_y .= "              <OPTION value=\"{$iX}\"{$strSel}>{$iX}</OPTION>\n";
}


// ͭ�����³���(��)
$camstart_m = "";
FOR( $iX=1; $iX<13; $iX++ ){
	$strSel = "";
	IF( $iX == intval($arrBuffCamStartTime[1]) ) $strSel = " selected";
	$camstart_m .= "              <OPTION value=\"{$iX}\"{$strSel}>{$iX}</OPTION>\n";
}


// ͭ�����³���(��)
$camstart_d = "";
FOR( $iX=1; $iX<32; $iX++ ){
	$strSel = "";
	IF( $iX == intval($arrBuffCamStartTime[2]) ) $strSel = " selected";
	$camstart_d .= "              <OPTION value=\"{$iX}\"{$strSel}>{$iX}</OPTION>\n";
}


// ͭ�����½�λ(ǯ)
$camend_y = "";
FOR( $iX=$lsy; $iX<$ley; $iX++ ){
	$strSel = "";
	IF( $iX == intval($arrBuffCamEndTime[0]) ) $strSel = " selected";
	$camend_y .= "              <OPTION value=\"{$iX}\"{$strSel}>{$iX}</OPTION>\n";
}

// ͭ�����½�λ(��)
$camend_m = "";
FOR( $iX=1; $iX<13; $iX++ ){
	$strSel = "";
	IF( $iX == intval($arrBuffCamEndTime[1]) ) $strSel = " selected";
	$camend_m .= "              <OPTION value=\"{$iX}\"{$strSel}>{$iX}</OPTION>\n";
}

// ͭ�����½�λ(��)
$camend_d = "";
FOR( $iX=1; $iX<32; $iX++ ){
	$strSel = "";
	IF( $iX == intval($arrBuffCamEndTime[2]) ) $strSel = " selected";
	$camend_d .= "              <OPTION value=\"{$iX}\"{$strSel}>{$iX}</OPTION>\n";
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
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"
    xmlns:v="urn:schemas-microsoft-com:vml">
  <HEAD>
    <TITLE>�Υ֥� - ��������ȴ����ġ���</TITLE>
    <script src="http://maps.google.com/maps?file=api&v=2&key=<?=$param_api_key?>"
        type="text/javascript" charset="utf-8"></script>
    <META http-equiv="Content-Type" content="text/html;charset=EUC-JP" />
    <META http-equiv="Content-Style-Type" content="text/css" />
    <META http-equiv="Content-Script-Type" content="text/javascript" />
    <LINK rel="stylesheet" type="text/css" href="../share/css/campain.css" />
    <SCRIPT type="text/javascript" src="../share/js/campain.js"></SCRIPT>
    <SCRIPT type="text/javascript" src="../share/js/tag.js"></SCRIPT>
    <SCRIPT type="text/javascript" src="../share/js/GoogleMap.js"></SCRIPT>
    <SCRIPT type="text/javascript" src="../share/js/input_check.js"></SCRIPT>
    <NOSCRIPT><META http-equiv="Refresh" content="1;URL=../jserror.html"></NOSCRIPT>
  </HEAD>
  <BODY>
    <div id="campain">
      <table id="client" cellspacing="0">
          <form action="campain_upd.php" method="POST" name="client" enctype="multipart/form-data">
        <TR>
          <TH class="must">����</TH>
          <TD>
            <INPUT type="radio" id="cp_stat0" name="cp_stat" value="1" <?=$statchecked1?> onFocus='Text("cp_stat0", 1)' onBlur='Text("cp_stat0", 2)' />ͭ����
            <INPUT type="radio" id="cp_stat1" name="cp_stat" value="2" <?=$statchecked2?> onFocus='Text("cp_stat1", 1)' onBlur='Text("cp_stat1", 2)' />̵����
          </TD>
        </TR>
        <tr>
          <th class="must">��°���ƥ��꡼</th>
          <td>
            <SELECT name="cp_cgid">
              <option value="">-- ���� --</option>
<?=$cateValue?>
            </SELECT>
          </td>
        </tr>
        <TR>
          <TH class="must">�ԣϣ�ɽ���ե饰</TH>
          <TD>
            <INPUT type="radio" id="cp_topflg0" name="cp_topflg" value="1" <?=$topflgchecked1?> onFocus='Text("cp_topflg0", 1)' onBlur='Text("cp_topflg0", 2)' />��ɽ����
            <INPUT type="radio" id="cp_topflg1" name="cp_topflg" value="2" <?=$topflgchecked2?> onFocus='Text("cp_topflg1", 1)' onBlur='Text("cp_topflg1", 2)' />��ԥƥ�����ɽ����
            <INPUT type="radio" id="cp_topflg2" name="cp_topflg" value="3" <?=$topflgchecked3?> onFocus='Text("cp_topflg2", 1)' onBlur='Text("cp_topflg2", 2)' />�Хʡ�ɽ����
          </TD>
        </TR>
        <tr>
          <th>�ֻ�</th>
          <td>
            <SELECT name="cp_tcid">
              <option value="">-- ���� --</option>
<?=$teacerValue?>
            </SELECT>
          </td>
        </tr>
        <tr>
          <th>�ֻե�����</th>
          <TD><TEXTAREA name="cp_tccomment" id="i10" rows="5" style="width:370" onFocus='Text("i10", 1)' onBlur='Text("i10", 2)' ><?=$cp_tccomment?></TEXTAREA></TD>
        </tr>
        <tr>
          <th class="must">�ֽ���<br>���٥�ȥ����ȥ�</th>
          <td><input id="i2" type="text" name="cp_title" value="<?=$cp_title?>" maxlength="17" onFocus='Text("i2", 1)' onBlur='Text("i2", 2)' style="width:250px;" /></td>
        </tr>
        <tr>
          <th class="must">���֥����ȥ�</th>
          <td><input id="cp_subtitle" type="text" name="cp_subtitle" value="<?=$cp_subtitle?>" maxlength="25" onFocus='Text("cp_subtitle", 1)' onBlur='Text("cp_subtitle", 2)' style="width:350px;" /></td>
        </tr>
        <TR>
          <TH>�оݳ�ǯ</TH>
          <TD>
            <INPUT type="checkbox" id="cp_age0" name="cp_age[0]" value="1" <?=$agechecked1?> onFocus='Text("cp_age0", 1)' onBlur='Text("cp_age0", 2)' />�Ļ���
            <INPUT type="checkbox" id="cp_age1" name="cp_age[1]" value="2" <?=$agechecked2?> onFocus='Text("cp_age1", 1)' onBlur='Text("cp_age1", 2)' />��������
            <INPUT type="checkbox" id="cp_age2" name="cp_age[2]" value="4" <?=$agechecked3?> onFocus='Text("cp_age2", 1)' onBlur='Text("cp_age2", 2)' />�������
            <INPUT type="checkbox" id="cp_age3" name="cp_age[3]" value="8" <?=$agechecked4?> onFocus='Text("cp_age3", 1)' onBlur='Text("cp_age3", 2)' />�⹻����
            <INPUT type="checkbox" id="cp_age4" name="cp_age[4]" value="16" <?=$agechecked5?> onFocus='Text("cp_age4", 1)' onBlur='Text("cp_age4", 2)' />ϲ������
            <INPUT type="checkbox" id="cp_age5" name="cp_age[5]" value="32" <?=$agechecked6?> onFocus='Text("cp_age5", 1)' onBlur='Text("cp_age5", 2)' />�������
            <INPUT type="checkbox" id="cp_age6" name="cp_age[6]" value="64" <?=$agechecked7?> onFocus='Text("cp_age6", 1)' onBlur='Text("cp_age6", 2)' />�Ҳ�͡�
          </TD>
        </TR>
        <tr>
          <th>�Ǻܴ���</th>
          <td>
            <select name="cp_start_y">
              <option value="">----</option>
<?=$start_y?>
            </select>
            ǯ
            <select name="cp_start_m">
              <option value="">--</option>
<?=$start_m?>
            </select>
            ��
            <select name="cp_start_d">
              <option value="">--</option>
<?=$start_d?>
            </select>
��
            <select name="cp_end_y">
              <option value="">----</option>
<?=$end_y?>
            </select>
            ǯ
            <select name="cp_end_m">
              <option value="">--</option>
<?=$end_m?>
            </select>
            ��
            <select name="cp_end_d">
              <option value="">--</option>
<?=$end_d?>
            </select>
          </td>
        </tr>
        <tr>
          <th>�»ܴ���</th>
          <td>
            <select name="cp_camstart_y">
              <option value="">----</option>
<?=$camstart_y?>
            </select>
            ǯ
            <select name="cp_camstart_m">
              <option value="">--</option>
<?=$camstart_m?>
            </select>
            ��
            <select name="cp_camstart_d">
              <option value="">--</option>
<?=$camstart_d?>
            </select>
��
            <select name="cp_camend_y">
              <option value="">----</option>
<?=$camend_y?>
            </select>
            ǯ
            <select name="cp_camend_m">
              <option value="">--</option>
<?=$camend_m?>
            </select>
            ��
            <select name="cp_camend_d">
              <option value="">--</option>
<?=$camend_d?>
            </select>
          </td>
        </tr>
        <TR>
          <TH>��󥯥ƥ�����</TH>
          <td><input id="cp_linktext" type="text" name="cp_linktext" value="<?=$cp_linktext?>" maxlength="15" onFocus='Text("cp_linktext", 1)' onBlur='Text("cp_linktext", 2)' style="width:250px;" /></td>
        </TR>
        <TR>
          <TH>�ܥ���ƥ�����</TH>
          <TD><TEXTAREA name="cp_btntext" id="i10" rows="4" style="width:95" onFocus='Text("i10", 1)' onBlur='Text("i10", 2)' maxlength="25"><?=$cp_btntext?></TEXTAREA></TD>
        </TR>
        <tr>
          <th class="must">����</th>
          <TD><TEXTAREA name="cp_contents" id="i10" rows="5" style="width:370" onFocus='Text("i10", 1)' onBlur='Text("i10", 2)' ><?=$cp_contents?></TEXTAREA></TD>
        </tr>
        <tr>
          <th>����</th>
          <td>
<?=$cp_img1_txt?>
            <BR><FONT color="#ff0000">�����򤵤줿�������ֽ������٥�Ⱦ���������ܺ٤�ɽ������ޤ�</FONT>
<BR><font color="#ff0000">��������2MB�ʲ���GIF������JPG�����򥢥åפ��Ƥ�������</font>		
          </td>
        </tr>
        <TR>
          <TH class="must">�ֽ���<br>���٥�ȥХʡ�<br>�쥤������</TH>
            <TD>
              <DIV id="layout">
                <table>
<?=$bannerView?>
                </table>
              </DIV>
            </TD>
        </TR>
<!--
        <tr>
          <th>�Хʡ��طʲ���</th>
          <td>
<?=$cp_bkgdimg_txt?>
<BR><font color="#ff0000">��������2MB�ʲ���GIF������JPG�����򥢥åפ��Ƥ�������</font>		
          </td>
        </tr>
//-->
<!--
        <tr>
          <th>����2</th>
          <td>
<?=$cp_img2_txt?>
<BR><font color="#ff0000">��������2MB�ʲ���GIF������JPG�����򥢥åפ��Ƥ�������</font>		
          </td>
        </tr>
        <tr>
          <th>����3</th>
          <td>
<?=$cp_img3_txt?>
<BR><font color="#ff0000">��������2MB�ʲ���GIF������JPG�����򥢥åפ��Ƥ�������</font>		
          </td>
        </tr>
        <tr>
          <th>����4</th>
          <td>
<?=$cp_img4_txt?>
<BR><font color="#ff0000">��������2MB�ʲ���GIF������JPG�����򥢥åפ��Ƥ�������</font>		
          </td>
        </tr>
//-->
      </table>
    </div>
    <div align="center">
      <table width="500">
        <tr>
          <td align="center" valign="top">
            <input type="submit" value="<?=$modeName?>" class="btn_nosize" onclick="return CampainInputCheck( this.form , this.form )" style="width:150px;" />
            <input type="hidden" name="mode" value="<?=$_POST['mode']?>" />
            <input type="hidden" name="cp_id" value="<?=$cp_id?>" />
            <input type="hidden" name="cp_upddate" value="<?=$cp_upddate?>" />
            <INPUT type="hidden" name="stpos" value="<?=$_POST['stpos']?>" />
            <INPUT type="hidden" name="cp_img1_lastupd" value="<?=$cp_img1_lastupd?>" />
            <INPUT type="hidden" name="cp_img2_lastupd" value="<?=$cp_img2_lastupd?>" />
            <INPUT type="hidden" name="cp_img3_lastupd" value="<?=$cp_img3_lastupd?>" />
            <INPUT type="hidden" name="cp_img4_lastupd" value="<?=$cp_img4_lastupd?>" />
            <INPUT type="hidden" name="cp_bkgdimg_lastupd" value="<?=$cp_bkgdimg_lastupd?>" />
          </td>
          </form>
<?=$DEL_VALUE?>
          <form method="POST" action="campain_main.php">
          <td align="center" valign="top">
            <input type="submit" name="bak" value="���" class="btn_nosize" style="width:150px;" />
            <INPUT type="hidden" name="stpos" value="<?=$_POST['stpos']?>" />
          </td>
          </form>
        </tr>
      </table>
    </div>
  </body>
</HTML>
