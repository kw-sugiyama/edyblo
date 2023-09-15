<?
/******************************************************************************
<< 不動産ブログ　Ver.1.O.0 >>
	Name: course_main.php
	Version: 1.0.0
	Function: 日記情報 登録･修正･削除
	Author: Click inc
	Date of creation: 2007/02
	History of modification:

	Copyright (C)2007 Click, inc. All Rights Reserverd.
******************************************************************************/

/*----------------------------------------------------------
  必要ファイル呼び出し
----------------------------------------------------------*/
require_once ( "../ini_sets_2.php" );
require_once ( SYS_PATH."dbif/dbcom_DBconnectClass.php" );
require_once ( SYS_PATH."dbif/basedb_ClientClass.php" );
require_once ( SYS_PATH."dbif/basedb_TeacherClass.php" );
require_once ( SYS_PATH."dbif/basedb_CourseClass.php" );
require_once ( SYS_PATH."dbif/basedb_CategoryClass.php" );
require_once ( SYS_PATH."common/base_common.php" );
require_once ( SYS_PATH."common/sys_common.php" );
require_once ( SYS_PATH."common/form_common.php" );
include_once ( SYS_PATH."common/error.class.php" );
require_once ( SYS_PATH."configs/param_base.conf" );
require_once ( SYS_PATH."configs/param_file.conf" );
require_once ( SYS_PATH."configs/param_map.conf" );


/*----------------------------------------------------------
  セッション登録開始
----------------------------------------------------------*/
session_start();


/*----------------------------------------------------------
        エラークラス - インスタンス
----------------------------------------------------------*/
$obj_error = new DispErrMessage();


/*----------------------------------------------------------
  ＤＢ接続
----------------------------------------------------------*/
require_once( SYS_PATH."common/db_connect.php" );


/*----------------------------------------------------------
  ログイン情報チェック
----------------------------------------------------------*/
require_once("../login_chk.php");


/*--------------------------------------------------------
	処理部分
--------------------------------------------------------*/

if($_POST['error_mode']=="on"){
	foreach($_POST as $key => $val){
		$arrData[$key] = stripslashes($val);
	}

		$obj = new basedb_CourseClassTblAccess;
		$obj->conn = $obj_conn->conn;
		$obj->jyoken["cs_del_date"] = 1;
		$obj->jyoken["cs_id"] = $_POST['cs_id'];
		list( $intCnt , $intTotal ) = $obj->basedb_GetCourse( 1 , -1 );
		IF( $intCnt == -1 ){
			$arrOther["ath_comment"] = "<INPUT TYPE=\"hidden\" NAME=\"stpos\" VALUE=\"{$_POST['stpos']}\">";
			$obj_error->ViewErrMessage( "SYSTEM" , "ALL" , SITE_PATH."blank.php" , $arrOther );
			exit;
		}


		$cs_id = htmlspecialchars ($arrData["cs_id"]);
		$cs_stat = htmlspecialchars ($arrData["cs_stat"]);
		$cs_clid = htmlspecialchars ($arrData["cs_clid"]);
		$cs_cgid = htmlspecialchars ($arrData["cs_cgid"]);
		$cs_title = htmlspecialchars ($arrData["cs_title"]);
		$cs_contents = htmlspecialchars ($arrData["cs_contents"]);
		$cs_upddate = htmlspecialchars ($arrData["cs_upddate"]);
		$cs_tccomment = htmlspecialchars ($arrData["cs_tccomment"]);
		$cs_imgorg1 = htmlspecialchars ($arrData["cs_imgorg1"]);
		$cs_imgorg2 = htmlspecialchars ($arrData["cs_imgorg2"]);
		$cs_imgorg3 = htmlspecialchars ($arrData["cs_imgorg3"]);
		$cs_imgorg4 = htmlspecialchars ($arrData["cs_imgorg4"]);
		$cs_imgorg5 = htmlspecialchars ($arrData["cs_imgorg5"]);
		$cs_img1_lastupd = htmlspecialchars ($arrData["cs_img1"]);
		$cs_img2_lastupd = htmlspecialchars ($arrData["cs_img2"]);
		$cs_img3_lastupd = htmlspecialchars ($arrData["cs_img3"]);
		$cs_img4_lastupd = htmlspecialchars ($arrData["cs_img4"]);
		$cs_img5_lastupd = htmlspecialchars ($arrData["cs_img5"]);
		$cs_topflg = htmlspecialchars ($arrData["cs_topflg"]);
		$cs_classform = htmlspecialchars ($arrData["cs_classform"]);
		$cs_ido = htmlspecialchars ($arrData["ido"]);
		$cs_keido = htmlspecialchars ($arrData["keido"]);
		$cs_zoom = htmlspecialchars ($arrData["zoom"]);
		if($arrData["cs_biko_1"] != "////" && $arrData["cs_biko_1"] != ""){
			$cs_map = split("/",$arrData["cs_biko_1"]);
		}

	if($_POST['mode']=="EDIT"){
		$modeName = "登録する";

		
		$DEL_VALUE = "";
		$DEL_VALUE .="<form action=\"course_upd.php\" method=\"POST\" name=\"del_form\">\n";
	        $DEL_VALUE .="<td align=\"center\" valign=\"top\">\n";
	        $DEL_VALUE .="    <input type=\"button\" value=\"削除する\" onclick=\"CourseDeleteCheck( this.form , this.form )\" class=\"btn_nosize\" style=\"width:150px;\" />\n";
	        $DEL_VALUE .="    <input type=\"hidden\" name=\"mode\" value=\"DEL\" />\n";
	        $DEL_VALUE .="    <input type=\"hidden\" name=\"cs_id\" value=\"{$cs_id}\" />\n";
	        $DEL_VALUE .="    <input type=\"hidden\" name=\"cs_upddate\" value=\"{$cs_upddate}\" />\n";
	        $DEL_VALUE .="    <INPUT type=\"hidden\" name=\"cs_img1_lastupd\" value=\"{$cs_img1_lastupd}\" />\n";
	        $DEL_VALUE .="    <INPUT type=\"hidden\" name=\"cs_img2_lastupd\" value=\"{$cs_img2_lastupd}\" />\n";
	        $DEL_VALUE .="    <INPUT type=\"hidden\" name=\"cs_img3_lastupd\" value=\"{$cs_img3_lastupd}\" />\n";
	        $DEL_VALUE .="    <INPUT type=\"hidden\" name=\"cs_img4_lastupd\" value=\"{$cs_img4_lastupd}\" />\n";
	        $DEL_VALUE .="    <INPUT type=\"hidden\" name=\"cs_img5_lastupd\" value=\"{$cs_img5_lastupd}\" />\n";
	        $DEL_VALUE .="</td>\n";
	        $DEL_VALUE .="</form>\n";


	}else if($_POST['mode']=="NEW"){

		$modeName = "登録する";
		$cs_zoom = 10;

	}
}else{
	if($_POST['mode']=="EDIT"){
		$obj = new basedb_CourseClassTblAccess;
		$obj->conn = $obj_conn->conn;
		$obj->jyoken["cs_del_date"] = 1;
		$obj->jyoken["cs_id"] = $_POST['cs_id'];
		list( $intCnt , $intTotal ) = $obj->basedb_GetCourse( 1 , -1 );
		IF( $intCnt == -1 ){
			$arrOther["ath_comment"] = "<INPUT TYPE=\"hidden\" NAME=\"stpos\" VALUE=\"{$_POST['stpos']}\">";
			$obj_error->ViewErrMessage( "SYSTEM" , "ALL" , SITE_PATH."blank.php" , $arrOther );
			exit;
		}

		$cs_id = htmlspecialchars ($obj->coursedat[0]["cs_id"]);
		$cs_clid = htmlspecialchars ($obj->coursedat[0]["cs_clid"]);
		$cs_stat = htmlspecialchars ($obj->coursedat[0]["cs_stat"]);
		$cs_cgid = htmlspecialchars ($obj->coursedat[0]["cs_cgid"]);
		$cs_title = htmlspecialchars ($obj->coursedat[0]["cs_title"]);
		$cs_jtitle = htmlspecialchars ($obj->coursedat[0]["cs_jtitle"]);
		$cs_organize = htmlspecialchars ($obj->coursedat[0]["cs_organize"]);
		$cs_tccomment = htmlspecialchars ($obj->coursedat[0]["cs_tccomment"]);

		$cs_start = htmlspecialchars ($obj->coursedat[0]["cs_start"]);
		$cs_end = htmlspecialchars ($obj->coursedat[0]["cs_end"]);
		$cs_week = htmlspecialchars ($obj->coursedat[0]["cs_week"]);

		$cs_price = htmlspecialchars ($obj->coursedat[0]["cs_price"]);
		$cs_entrance = htmlspecialchars ($obj->coursedat[0]["cs_entrance"]);
		$cs_shisetsu = htmlspecialchars ($obj->coursedat[0]["cs_shisetsu"]);
		$cs_textfee = htmlspecialchars ($obj->coursedat[0]["cs_textfee"]);
		$cs_monthlyfee = htmlspecialchars ($obj->coursedat[0]["cs_monthlyfee"]);
		$cs_age = htmlspecialchars ($obj->coursedat[0]["cs_age"]);
		$cs_level = htmlspecialchars ($obj->coursedat[0]["cs_level"]);
		$cs_purpose = htmlspecialchars ($obj->coursedat[0]["cs_purpose"]);
		$cs_subject = htmlspecialchars ($obj->coursedat[0]["cs_subject"]);
		$cs_pr = htmlspecialchars ($obj->coursedat[0]["cs_pr"]);
		$cs_tcid = htmlspecialchars ($obj->coursedat[0]["cs_tcid"]);
		$cs_tcflg = htmlspecialchars ($obj->coursedat[0]["cs_tcflg"]);

		$cs_imgorg1 = htmlspecialchars ($obj->coursedat[0]["cs_imgorg1"]);
		$cs_imgorg2 = htmlspecialchars ($obj->coursedat[0]["cs_imgorg2"]);
		$cs_imgorg3 = htmlspecialchars ($obj->coursedat[0]["cs_imgorg3"]);
		$cs_imgorg4 = htmlspecialchars ($obj->coursedat[0]["cs_imgorg4"]);
		$cs_imgorg5 = htmlspecialchars ($obj->coursedat[0]["cs_imgorg5"]);
		$cs_img1_lastupd = htmlspecialchars ($obj->coursedat[0]["cs_img1"]);
		$cs_img2_lastupd = htmlspecialchars ($obj->coursedat[0]["cs_img2"]);
		$cs_img3_lastupd = htmlspecialchars ($obj->coursedat[0]["cs_img3"]);
		$cs_img4_lastupd = htmlspecialchars ($obj->coursedat[0]["cs_img4"]);
		$cs_img5_lastupd = htmlspecialchars ($obj->coursedat[0]["cs_img5"]);
		$cs_dispno = htmlspecialchars ($obj->coursedat[0]["cs_dispno"]);
		$cs_classform = htmlspecialchars ($obj->coursedat[0]["cs_classform"]);
		$cs_topflg = htmlspecialchars ($obj->coursedat[0]["cs_topflg"]);
		$cs_upddate = htmlspecialchars ($obj->coursedat[0]["cs_upddate"]);

		$modeName = "登録する";
		
		$DEL_VALUE = "";
		$DEL_VALUE .="<form action=\"course_upd.php\" method=\"POST\" name=\"del_form\">\n";
	        $DEL_VALUE .="<td align=\"center\" valign=\"top\">\n";
	        $DEL_VALUE .="    <input type=\"button\" value=\"削除する\" onclick=\"CourseDeleteCheck( this.form , this.form )\" class=\"btn_nosize\" style=\"width:150px;\" />\n";
	        $DEL_VALUE .="    <input type=\"hidden\" name=\"mode\" value=\"DEL\" />\n";
	        $DEL_VALUE .="    <input type=\"hidden\" name=\"cs_id\" value=\"{$cs_id}\" />\n";
	        $DEL_VALUE .="    <input type=\"hidden\" name=\"cs_upddate\" value=\"{$cs_upddate}\" />\n";
	        $DEL_VALUE .="    <INPUT type=\"hidden\" name=\"cs_img1_lastupd\" value=\"{$cs_img1_lastupd}\" />\n";
	        $DEL_VALUE .="    <INPUT type=\"hidden\" name=\"cs_img2_lastupd\" value=\"{$cs_img2_lastupd}\" />\n";
	        $DEL_VALUE .="    <INPUT type=\"hidden\" name=\"cs_img3_lastupd\" value=\"{$cs_img3_lastupd}\" />\n";
	        $DEL_VALUE .="    <INPUT type=\"hidden\" name=\"cs_img4_lastupd\" value=\"{$cs_img4_lastupd}\" />\n";
	        $DEL_VALUE .="    <INPUT type=\"hidden\" name=\"cs_img4_lastupd\" value=\"{$cs_img5_lastupd}\" />\n";
	        $DEL_VALUE .="</td>\n";
	        $DEL_VALUE .="</form>\n";


	}else if($_POST['mode']=="NEW"){

		$modeName = "登録する";
		$cs_zoom = 10;

	}
}

// ロゴ画像
$cs_img1_dir = $param_cs_img1_path;
$cs_img1_arr["org"] = $cs_imgorg1;
$cs_img1_arr["chk_in"] = "1";
$cs_img1_txt =  form_ImgDisp( "cs_img1" , $cs_img1_dir , $obj->coursedat[0]["cs_img1"] , "1" , $cs_img1_arr );

$cs_img2_dir = $param_cs_img2_path;
$cs_img2_arr["org"] = $cs_imgorg2;
$cs_img2_arr["chk_in"] = "1";
$cs_img2_txt =  form_ImgDisp( "cs_img2" , $cs_img2_dir , $obj->coursedat[0]["cs_img2"] , "1" , $cs_img2_arr );

$cs_img3_dir = $param_cs_img3_path;
$cs_img3_arr["org"] = $cs_imgorg3;
$cs_img3_arr["chk_in"] = "1";
$cs_img3_txt =  form_ImgDisp( "cs_img3" , $cs_img3_dir , $obj->coursedat[0]["cs_img3"] , "1" , $cs_img3_arr );

$cs_img4_dir = $param_cs_img4_path;
$cs_img4_arr["org"] = $cs_imgorg4;
$cs_img4_arr["chk_in"] = "1";
$cs_img4_txt =  form_ImgDisp( "cs_img4" , $cs_img4_dir , $obj->coursedat[0]["cs_img4"] , "1" , $cs_img4_arr );

$cs_img5_dir = $param_cs_img5_path;
$cs_img5_arr["org"] = $cs_imgorg5;
$cs_img5_arr["chk_in"] = "1";
$cs_img5_txt =  form_ImgDisp( "cs_img5" , $cs_img5_dir , $obj->coursedat[0]["cs_img5"] , "1" , $cs_img5_arr );


$obj_cate = new basedb_CategoryClassTblAccess;
$obj_cate->conn = $obj_conn->conn;
$obj_cate->jyoken["cg_deldate"] = 1;
$obj_cate->jyoken["cg_stat"] = 1;
$obj_cate->jyoken["cg_type"] = 3;
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
	if($category_id == $cs_cgid && $cs_cgid!="")$cg_select = "selected";
	$cateValue .= "<OPTION VALUE=\"{$category_id}\" {$cg_select}>{$category_name}</OPTION>";
}

if($cs_zoom=="")$cs_zoom = 10;


// 講師データ生成
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
	if($teacher_id == $cs_tcid && $cs_tcid!="")$tc_select = "selected";
	$teacerValue .= "<OPTION VALUE=\"{$teacher_id}\" {$tc_select}>{$teacher_name}</OPTION>";
}


// 状態
$statchecked1 = "";
$statchecked2 = "";
if( $cs_stat == 1 ){
	 $statchecked1 = " checked";
}else if( $cs_stat == 2 ){
	 $statchecked2 = " checked";
}else{
	 $statchecked1 = " checked";
}


// ＴＯＰ表示フラグ
$topflgchecked1 = "";
$topflgchecked2 = "";
if( $cs_topflg == 1 ){
	 $topflgchecked1 = " checked";
}else if( $cs_topflg == 2 ){
	 $topflgchecked2 = " checked";
}else{
	 $topflgchecked1 = " checked";
}


// 授業形態
if( ($cs_classform & 4) == 4 ){
	$cs_classformChk3 = " checked";
	$cs_classform -= 4;
}
if( ($cs_classform & 2) == 2 ){
	$cs_classformChk2 = " checked";
	$cs_classform -= 2;
}
if( ($cs_classform & 1) == 1 ){
	$cs_classformChk1 = " checked";
	$cs_classform -= 1;
}


// レベル
if( ($cs_level & 8) == 8 ){
	$cs_levelChk4 = " checked";
	$cs_level -= 8;
}
if( ($cs_classform & 4) == 4 ){
	$cs_levelChk3 = " checked";
	$cs_level -= 4;
}
if( ($cs_classform & 2) == 2 ){
	$cs_levelChk2 = " checked";
	$cs_level -= 2;
}
if( ($cs_classform & 1) == 1 ){
	$cs_levelChk1 = " checked";
	$cs_level -= 1;
}


// 対象学年
if( ($cs_age & 128) == 128 ){
	$agechecked8 = " checked";
	$cs_age -= 128;
}
if( ($cs_age & 64) == 64 ){
	$agechecked7 = " checked";
	$cs_age -= 64;
}
if( ($cs_age & 32) == 32 ){
	$agechecked6 = " checked";
	$cs_age -= 32;
}
if( ($cs_age & 16) == 16 ){
	$agechecked5 = " checked";
	$cs_age -= 16;
}
if( ($cs_age & 8) == 8 ){
	$agechecked4 = " checked";
	$cs_age -= 8;
}
if( ($cs_age & 4) == 4 ){
	$agechecked3 = " checked";
	$cs_age -= 4;
}
if( ($cs_age & 2) == 2 ){
	$agechecked2 = " checked";
	$cs_age -= 2;
}
if( ($cs_age & 1) == 1 ){
	$agechecked1 = " checked";
	$cs_age -= 1;
}


// レベル
if( ($cs_level & 8) == 8 ){
	$cs_levelChk4 = " checked";
	$cs_level -= 8;
}
if( ($cs_level & 4) == 4 ){
	$cs_levelChk3 = " checked";
	$cs_level -= 4;
}
if( ($cs_level & 2) == 2 ){
	$cs_levelChk2 = " checked";
	$cs_level -= 2;
}
if( ($cs_level & 1) == 1 ){
	$cs_levelChk1 = " checked";
	$cs_level -= 1;
}

// 目的
if( ($cs_purpose & 4) == 4 ){
	$purposechecked3 = " checked";
	$cs_purpose -= 4;
}
if( ($cs_purpose & 2) == 2 ){
	$purposechecked2 = " checked";
	$cs_purpose -= 2;
}
if( ($cs_purpose & 1) == 1 ){
	$purposechecked1 = " checked";
	$cs_purpose -= 1;
}

// 営業開始時間（時・分）
IF( $cs_start != "" ){
	$arrBuffStartTime = explode( ":" , $cs_start );
}ELSE{
	$arrBuffStartTime = "";
}
$viewStartTime_h = "";
$iX=0;
FOR( $iX=6; $iX<25; $iX++ ){
	$buffInt = "";
	$buffInt = sprintf( "%02d" , $iX );
	$strSel = "";
	IF( $buffInt == $arrBuffStartTime[0] ) $strSel = " selected";
	$viewStartTime_h .= "<OPTION value=\"{$buffInt}\"{$strSel}>{$buffInt}</OPTION>\n";
}
$viewStartTime_m = "";
$iX=0;
WHILE( $iX<60 ){
	$buffInt = "";
	$buffInt = sprintf( "%02d" , $iX );
	$strSel = "";
	IF( $buffInt == $arrBuffStartTime[1] ) $strSel = " selected";
	$viewStartTime_m .= "<OPTION value=\"{$buffInt}\"{$strSel}>{$buffInt}</OPTION>\n";
	$iX = $iX+10;
}

// 営業終了時間（時・分）
IF( $cs_end != "" ){
	$arrBuffEndTime = explode( ":" , $cs_end );
}ELSE{
	$arrBuffEndTime = "";
}
$viewEndTime_h = "";
FOR( $iX=6; $iX<25; $iX++ ){
	$buffInt = "";
	$buffInt = sprintf( "%02d" , $iX );
	$strSel = "";
	IF( $buffInt == $arrBuffEndTime[0] ) $strSel = " selected";
	$viewEndTime_h .= "<OPTION value=\"{$buffInt}\"{$strSel}>{$buffInt}</OPTION>\n";
}
$viewEndTime_m = "";
$iX=0;
WHILE( $iX<60 ){
	$buffInt = "";
	$buffInt = sprintf( "%02d" , $iX );
	$strSel = "";
	IF( $buffInt == $arrBuffEndTime[1] ) $strSel = " selected";
	$viewEndTime_m .= "<OPTION value=\"{$buffInt}\"{$strSel}>{$buffInt}</OPTION>\n";
	$iX = $iX+10;
}


/*----------------------------------------------------------
  ＤＢ切断
----------------------------------------------------------*/
require_once( SYS_PATH."common/db_close.php" );


/*--------------------------------------------------------
	ＨＴＭＬ生成
--------------------------------------------------------*/
?>
<HTML>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"
    xmlns:v="urn:schemas-microsoft-com:vml">
  <HEAD>
    <TITLE>塾ブログ - アカウント管理ツール</TITLE>
    <script src="http://maps.google.com/maps?file=api&v=2&key=<?=$param_api_key?>"
        type="text/javascript" charset="utf-8"></script>
    <META http-equiv="Content-Type" content="text/html;charset=EUC-JP" />
    <META http-equiv="Content-Style-Type" content="text/css" />
    <META http-equiv="Content-Script-Type" content="text/javascript" />
    <LINK rel="stylesheet" type="text/css" href="../share/css/course.css" />
    <SCRIPT type="text/javascript" src="../share/js/course.js"></SCRIPT>
    <SCRIPT type="text/javascript" src="../share/js/tag.js"></SCRIPT>
    <SCRIPT type="text/javascript" src="../share/js/GoogleMap.js"></SCRIPT>
    <SCRIPT type="text/javascript" src="../share/js/input_check.js"></SCRIPT>
    <NOSCRIPT><META http-equiv="Refresh" content="1;URL=../jserror.html"></NOSCRIPT>
  </HEAD>
  <BODY>
    <div id="course">
      <table id="client" cellspacing="0">
        <TR>
          <form action="course_upd.php" method="POST" name="client" enctype="multipart/form-data">
          <TH class="must">状態</TH>
          <TD>
            <INPUT type="radio" id="cs_stat0" name="cs_stat" value="1" <?=$statchecked1?> onFocus='Text("cs_stat0", 1)' onBlur='Text("cs_stat0", 2)' />有効　
            <INPUT type="radio" id="cs_stat1" name="cs_stat" value="2" <?=$statchecked2?> onFocus='Text("cs_stat1", 1)' onBlur='Text("cs_stat1", 2)' />無効　
          </TD>
        </TR>
        <TR>
          <TH class="must">ＴＯＰ表示フラグ</TH>
          <TD>
            <INPUT type="radio" id="cs_topflg1" name="cs_topflg" value="2" <?=$topflgchecked2?> onFocus='Text("cs_topflg1", 1)' onBlur='Text("cs_topflg1", 2)' />表示　
            <INPUT type="radio" id="cs_topflg0" name="cs_topflg" value="1" <?=$topflgchecked1?> onFocus='Text("cs_topflg0", 1)' onBlur='Text("cs_topflg0", 2)' />非表示　
          </TD>
        </TR>
        <tr>
          <th class="must">所属カテゴリー</th>
          <td>
            <SELECT name="cs_cgid">
              <option value="">-- 選択 --</option>
<?=$cateValue?>
            </SELECT>
          </td>
        </tr>
        <tr>
          <th>講師</th>
          <td>
            <SELECT name="cs_tcid">
              <option value="">-- 選択 --</option>
<?=$teacerValue?>
            </SELECT>
          </td>
        </tr>
        <TR>
          <TH>講師コメント</TH>
          <TD><TEXTAREA name="cs_tccomment" id="i10" rows="5" style="width:370" onFocus='Text("i10", 1)' onBlur='Text("i10", 2)' ><?=$cs_tccomment?></TEXTAREA></TD>
        </TR>
        <tr>
          <th class="must">コースタイトル</th>
          <td><input id="i2" type="text" name="cs_title" value="<?=$cs_title?>" maxlength="30" onFocus='Text("i2", 1)' onBlur='Text("i2", 2)' style="width:250px;" /></td>
        </tr>
        <tr>
          <th class="must">教科</th>
          <td><input id="cs_jtitle" type="text" name="cs_jtitle" value="<?=$cs_jtitle?>" maxlength="30" onFocus='Text("cs_jtitle", 1)' onBlur='Text("cs_jtitle", 2)' style="width:250px;" /></td>
        </tr>
        <TR>
          <TH>実施時間</TH>
          <TD>
            <SELECT name="cs_start_h">
              <OPTION value="">--</OPTION>
              <?=$viewStartTime_h?>
            </SELECT>
            時
            <SELECT name="cs_start_m">
              <OPTION value="">--</OPTION>
              <?=$viewStartTime_m?>
            </SELECT>
            分
             〜 
            <SELECT name="cs_end_h">
              <OPTION value="">--</OPTION>
              <?=$viewEndTime_h?>
            </SELECT>
            時
            <SELECT name="cs_end_m">
              <OPTION value="">--</OPTION>
              <?=$viewEndTime_m?>
            </SELECT>
            分
          </TD>
        </TR>
        <tr>
          <th>実施曜日</th>
          <td><input id="cs_week" type="text" name="cs_week" value="<?=$cs_week?>" maxlength="30" onFocus='Text("cs_week", 1)' onBlur='Text("cs_week", 2)' style="width:250px;" /></td>
        </tr>
        <TR>
          <TH>クラス編成</TH>
          <TD><TEXTAREA name="cs_organize" id="i10" rows="5" style="width:370" onFocus='Text("i10", 1)' onBlur='Text("i10", 2)' ><?=$cs_organize?></TEXTAREA></TD>
        </TR>
<!--
        <TR>
          <TH>費用</TH>
          <TD><TEXTAREA name="cs_price" id="i10" rows="5" style="width:370" onFocus='Text("i10", 1)' onBlur='Text("i10", 2)' ><?=$cs_price?></TEXTAREA></TD>
        </TR>
        <TR>
          <TH>入学金</TH>
          <TD><TEXTAREA name="cs_entrance" id="i10" rows="5" style="width:370" onFocus='Text("i10", 1)' onBlur='Text("i10", 2)' ><?=$cs_entrance?></TEXTAREA></TD>
        </TR>
//-->
        <TR>
          <TH>実施期間</TH>
          <TD><TEXTAREA name="cs_shisetsu" id="i10" rows="5" style="width:370" onFocus='Text("i10", 1)' onBlur='Text("i10", 2)' ><?=$cs_shisetsu?></TEXTAREA></TD>
        </TR>
        <TR>
          <TH>教材</TH>
          <TD><TEXTAREA name="cs_textfee" id="i10" rows="5" style="width:370" onFocus='Text("i10", 1)' onBlur='Text("i10", 2)' ><?=$cs_textfee?></TEXTAREA></TD>
        </TR>
<!--
        <TR>
          <TH>月謝</TH>
          <TD><TEXTAREA name="cs_monthlyfee" id="i10" rows="5" style="width:370" onFocus='Text("i10", 1)' onBlur='Text("i10", 2)' ><?=$cs_monthlyfee?></TEXTAREA></TD>
        </TR>
//-->
        <TR>
          <TH>対象学年</TH>
          <TD>
            <INPUT type="checkbox" id="cs_age0" name="cs_age[0]" value="1" <?=$agechecked1?> onFocus='Text("cs_age0", 1)' onBlur='Text("cs_age0", 2)' />幼児　
            <INPUT type="checkbox" id="cs_age1" name="cs_age[1]" value="2" <?=$agechecked2?> onFocus='Text("cs_age1", 1)' onBlur='Text("cs_age1", 2)' />小学生　
            <INPUT type="checkbox" id="cs_age2" name="cs_age[2]" value="4" <?=$agechecked3?> onFocus='Text("cs_age2", 1)' onBlur='Text("cs_age2", 2)' />中学生　
            <INPUT type="checkbox" id="cs_age3" name="cs_age[3]" value="8" <?=$agechecked4?> onFocus='Text("cs_age3", 1)' onBlur='Text("cs_age3", 2)' />高校生　
            <INPUT type="checkbox" id="cs_age4" name="cs_age[4]" value="16" <?=$agechecked5?> onFocus='Text("cs_age4", 1)' onBlur='Text("cs_age4", 2)' />浪人生　
            <INPUT type="checkbox" id="cs_age5" name="cs_age[5]" value="32" <?=$agechecked6?> onFocus='Text("cs_age5", 1)' onBlur='Text("cs_age5", 2)' />大学生　
            <INPUT type="checkbox" id="cs_age6" name="cs_age[6]" value="64" <?=$agechecked7?> onFocus='Text("cs_age6", 1)' onBlur='Text("cs_age6", 2)' />社会人　
          </TD>
        </TR>
        <TR>
          <TH>授業形態</TH>
          <TD>
            <INPUT type="checkbox" id="cs_classform0" name="cs_classform[0]" value="1" <?=$cs_classformChk1?> onFocus='Text("cs_classform0", 1)' onBlur='Text("cs_classform0", 2)' />集団　
            <INPUT type="checkbox" id="cs_classform1" name="cs_classform[1]" value="2" <?=$cs_classformChk2?> onFocus='Text("cs_classform1", 1)' onBlur='Text("cs_classform1", 2)' />少人数　
            <INPUT type="checkbox" id="cs_classform2" name="cs_classform[2]" value="4" <?=$cs_classformChk3?> onFocus='Text("cs_classform2", 1)' onBlur='Text("cs_classform2", 2)' />個別　
          </TD>
        </TR>
        <TR>
          <TH>レベル</TH>
          <TD>
            <INPUT type="checkbox" id="cs_level0" name="cs_level[1]" value="1" <?=$cs_levelChk1?> onFocus='Text("cs_level0", 1)' onBlur='Text("cs_level0", 2)' />基礎　
            <INPUT type="checkbox" id="cs_level1" name="cs_level[2]" value="2" <?=$cs_levelChk2?> onFocus='Text("cs_level1", 1)' onBlur='Text("cs_level1", 2)' />中堅　
            <INPUT type="checkbox" id="cs_level2" name="cs_level[3]" value="4" <?=$cs_levelChk3?> onFocus='Text("cs_level2", 1)' onBlur='Text("cs_level2", 2)' />難関　
            <INPUT type="checkbox" id="cs_level3" name="cs_level[4]" value="8" <?=$cs_levelChk4?> onFocus='Text("cs_level3", 1)' onBlur='Text("cs_level3", 2)' />最難関　
          </TD>
        </TR>
        <TR>
          <TH class="must">目的</TH>
          <TD>
            <INPUT type="checkbox" id="cs_purpose0" name="cs_purpose[1]" value="1" <?=$purposechecked1?> onFocus='Text("cs_purpose0", 1)' onBlur='Text("cs_purpose0", 2)' />受験　
            <INPUT type="checkbox" id="cs_purpose1" name="cs_purpose[2]" value="2" <?=$purposechecked2?> onFocus='Text("cs_purpose1", 1)' onBlur='Text("cs_purpose1", 2)' />補習　
            <INPUT type="checkbox" id="cs_purpose2" name="cs_purpose[3]" value="4" <?=$purposechecked3?> onFocus='Text("cs_purpose2", 1)' onBlur='Text("cs_purpose2", 2)' />検定　
          </TD>
        </TR>
<!--
        <TR>
          <TH class="must">科目</TH>
          <TD>
            <INPUT type="checkbox" id="cs_age0" name="cs_age[0]" value="1" <?=$agechecked1?> onFocus='Text("cs_age0", 1)' onBlur='Text("cs_age0", 2)' />国語　
            <INPUT type="checkbox" id="cs_age1" name="cs_age[1]" value="2" <?=$agechecked2?> onFocus='Text("cs_age1", 1)' onBlur='Text("cs_age1", 2)' />数学
            <INPUT type="checkbox" id="cs_age2" name="cs_age[2]" value="4" <?=$agechecked3?> onFocus='Text("cs_age2", 1)' onBlur='Text("cs_age2", 2)' />小学生高学年　
            <INPUT type="checkbox" id="cs_age3" name="cs_age[3]" value="8" <?=$agechecked4?> onFocus='Text("cs_age3", 1)' onBlur='Text("cs_age3", 2)' />中学生　
            <INPUT type="checkbox" id="cs_age4" name="cs_age[4]" value="16" <?=$agechecked5?> onFocus='Text("cs_age4", 1)' onBlur='Text("cs_age4", 2)' />高校生　
            <INPUT type="checkbox" id="cs_age5" name="cs_age[5]" value="32" <?=$agechecked6?> onFocus='Text("cs_age5", 1)' onBlur='Text("cs_age5", 2)' />浪人生　
            <INPUT type="checkbox" id="cs_age6" name="cs_age[6]" value="64" <?=$agechecked7?> onFocus='Text("cs_age6", 1)' onBlur='Text("cs_age6", 2)' />大学生　
            <INPUT type="checkbox" id="cs_age7" name="cs_age[7]" value="128" <?=$agechecked8?> onFocus='Text("cs_age7", 1)' onBlur='Text("cs_age7", 2)' />社会人　
          </TD>
        </TR>
//-->
        <tr>
          <th>画像1</th>
          <td>
<?=$cs_img1_txt?>
            <BR><FONT color="#ff0000">※選択された画像がコース情報一覧／詳細に表示されます</FONT>
<BR><font color="#ff0000">※画像は2MB以下のGIF画像かJPG画像をアップしてください</font>		
          </td>
        </tr>
        <tr>
          <th>コースＰＲ</th>
          <td>
            <INPUT type="image" src="../share/images/form/icon_b.gif" alt="強調" onClick="HTML_TAG('free_text','B','2');return false;"/>
            <INPUT type="image" src="../share/images/form/icon_a.gif" alt="リンク" onClick="HTML_TAG( 'free_text','A','2');return false;" />
            <INPUT type="image" src="../share/images/form/icon_u.gif" alt="下線" onClick="HTML_TAG('free_text','U','2');return false;" />
            <INPUT type="image" src="../share/images/form/icon_s.gif" alt="取り消し線" onClick="HTML_TAG('free_text','S','2');return false;" />
            <INPUT type="image" src="../share/images/form/icon_i.gif" alt="斜体" onClick="HTML_TAG('free_text','I','2');return false;" />
            <INPUT type="image" src="../share/images/form/icon_color_red.gif" alt="文字色(赤)" onClick="HTML_TAG('free_text','FONT-RED','2');return false;" />
            <INPUT type="image" src="../share/images/form/icon_color_blue.gif" alt="文字色(青)" onClick="HTML_TAG('free_text','FONT-BLUE','2');return false;" />
            <INPUT type="image" src="../share/images/form/icon_color_yellow.gif" alt="文字色(黄)" onClick="HTML_TAG('free_text','FONT-YELLOW','2');return false;" />
            <INPUT type="image" src="../share/images/form/icon_color_green.gif" alt="文字色(緑)" onClick="HTML_TAG('free_text','FONT-GREEN','2');return false;" />
<!--
            <INPUT type="image" src="../share/images/form/icon_img_1.gif" alt="画像1" onClick="HTML_TAG('free_text','IMAGE-1','1');return false;" />
            <INPUT type="image" src="../share/images/form/icon_img_2.gif" alt="画像2" onClick="HTML_TAG('free_text','IMAGE-2','1');return false;" />
            <INPUT type="image" src="../share/images/form/icon_img_3.gif" alt="画像3" onClick="HTML_TAG('free_text','IMAGE-3','1');return false;" />
            <INPUT type="image" src="../share/images/form/icon_img_4.gif" alt="画像4" onClick="HTML_TAG('free_text','IMAGE-4','1');return false;" />
//-->
            <br />
            <TEXTAREA id="free_text" name="cs_pr" onFocus='Text("free_text", 1)' onBlur='Text("free_text", 2)' cols="60" rows="10"><?=$cs_pr?></TEXTAREA>
            <br />
            <!--<FONT color="#ff0000">※[IMG1〜4]が入っている位置に、上で選択された画像が表示されます。<br />画像が設定されていない場合は表示されません。</FONT>-->
          </td>
        </tr>
<!--
        <tr>
          <th>画像2</th>
          <td>
<?=$cs_img2_txt?>
<BR><font color="#ff0000">※画像は2MB以下のGIF画像かJPG画像をアップしてください</font>		
          </td>
        </tr>
        <tr>
          <th>画像3</th>
          <td>
<?=$cs_img3_txt?>
<BR><font color="#ff0000">※画像は2MB以下のGIF画像かJPG画像をアップしてください</font>		
          </td>
        </tr>
        <tr>
          <th>画像4</th>
          <td>
<?=$cs_img4_txt?>
<BR><font color="#ff0000">※画像は2MB以下のGIF画像かJPG画像をアップしてください</font>		
          </td>
        </tr>
        <tr>
          <th>画像5</th>
          <td>
<?=$cs_img5_txt?>
<BR><font color="#ff0000">※画像は2MB以下のGIF画像かJPG画像をアップしてください</font>		
          </td>
        </tr>
//-->
<!--
        <tr>
          <th>地図情報</th>
          <TD>
<input type="text" value="" id="zip" size="40" onFocus='Text("zip", 1)' onBlur='Text("zip", 2)'/>
<input type="button" value="住所検索" onClick="showAddress()" />
<input type="hidden" id="zm4" name="zoom3" value="12"/>
<div id="gmap" style="width: 620px; height: 300px"></div>
<div id="mapOpt"></div>
<input type="button" name="onMarker" value="マーカー" onClick="marker('<?=$param_marker_dia_img?>','<?=$param_marker_shadow_img?>')" /><br />
<form action="GoogleMapStop.php" method="POST">
<input type="hidden" id="mapX" name="cs_keido" value="<?=$cs_keido?>"/>
<input type="hidden" id="mapY" name="cs_ido" value="<?=$cs_ido?>"/>
<input type="hidden" id="zoomN" name="cs_zoom" value="<?=$cs_zoom?>"/><BR>
<input type="hidden" id="marker_flg" name="mkr_flg" value=""/><BR>
          </TD>
        </tr>
//-->
      </table>
    </div>
    <div align="center">
      <table width="500">
        <tr>
          <td align="center" valign="top">
            <input type="submit" value="<?=$modeName?>" class="btn_nosize" onclick="return CourseInputCheck( this.form , this.form )" style="width:150px;" />
            <input type="hidden" name="mode" value="<?=$_POST['mode']?>" />
            <input type="hidden" name="cs_id" value="<?=$cs_id?>" />
            <input type="hidden" name="cs_upddate" value="<?=$cs_upddate?>" />
            <INPUT type="hidden" name="stpos" value="<?=$_POST['stpos']?>" />
            <INPUT type="hidden" name="cs_img1_lastupd" value="<?=$cs_img1_lastupd?>" />
            <INPUT type="hidden" name="cs_img2_lastupd" value="<?=$cs_img2_lastupd?>" />
            <INPUT type="hidden" name="cs_img3_lastupd" value="<?=$cs_img3_lastupd?>" />
            <INPUT type="hidden" name="cs_img4_lastupd" value="<?=$cs_img4_lastupd?>" />
            <INPUT type="hidden" name="cs_img5_lastupd" value="<?=$cs_img5_lastupd?>" />
          </td>
          </form>
<?=$DEL_VALUE?>
          <form method="POST" action="course_main.php">
          <td align="center" valign="top">
            <input type="submit" name="bak" value="戻る" class="btn_nosize" style="width:150px;" />
            <INPUT type="hidden" name="stpos" value="<?=$_POST['stpos']?>" />
          </td>
          </form>
        </tr>
      </table>
    </div>
  </body>
</HTML>
