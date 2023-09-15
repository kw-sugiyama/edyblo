<?
/******************************************************************************
<< 不動産ブログ　Ver.1.O.0 >>
	Name: diary_main.php
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
require_once ( SYS_PATH."dbif/basedb_DiaryClass.php" );
require_once ( SYS_PATH."dbif/basedb_TeacherClass.php" );
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

		if( $_POST['dr_id'] != '' ){
			$obj = new basedb_DiaryClassTblAccess;
			$obj->conn = $obj_conn->conn;
			$obj->jyoken["dr_del_date"] = 1;
			$obj->jyoken["dr_id"] = $_POST['dr_id'];
			list( $intCnt , $intTotal ) = $obj->basedb_GetDiary( 1 , -1 );
			IF( $intCnt == -1 ){
				$arrOther["ath_comment"] = "<INPUT TYPE=\"hidden\" NAME=\"stpos\" VALUE=\"{$_POST['stpos']}\">";
				$obj_error->ViewErrMessage( "SYSTEM" , "ALL" , SITE_PATH."blank.php" , $arrOther );
				exit;
			}
		}

		$dr_id = htmlspecialchars ($arrData["dr_id"]);
		$dr_clid = htmlspecialchars ($arrData["dr_clid"]);
		$dr_cgid = htmlspecialchars ($arrData["dr_cgid"]);
		$dr_tcid = htmlspecialchars ($arrData["dr_tcid"]);
		$dr_title = htmlspecialchars ($arrData["dr_title"]);
		$dr_contents = htmlspecialchars ($arrData["dr_contents"]);
		$dr_upddate = htmlspecialchars ($arrData["dr_upddate"]);
		$dr_imgorg1 = htmlspecialchars ($arrData["dr_imgorg1"]);
		$dr_imgorg2 = htmlspecialchars ($arrData["dr_imgorg2"]);
		$dr_imgorg3 = htmlspecialchars ($arrData["dr_imgorg3"]);
		$dr_imgorg4 = htmlspecialchars ($arrData["dr_imgorg4"]);
		$dr_img1_lastupd = htmlspecialchars ($arrData["dr_img1"]);
		$dr_img2_lastupd = htmlspecialchars ($arrData["dr_img2"]);
		$dr_img3_lastupd = htmlspecialchars ($arrData["dr_img3"]);
		$dr_img4_lastupd = htmlspecialchars ($arrData["dr_img4"]);
		$dr_ido = htmlspecialchars ($arrData["ido"]);
		$dr_keido = htmlspecialchars ($arrData["keido"]);
		$dr_zoom = htmlspecialchars ($arrData["zoom"]);
		if($arrData["dr_biko_1"] != "////" && $arrData["dr_biko_1"] != ""){
			$dr_map = split("/",$arrData["dr_biko_1"]);
		}

	if($_POST['mode']=="EDIT"){
		$modeName = "登録する";

		
		$DEL_VALUE = "";
		$DEL_VALUE .="<form action=\"diary_upd.php\" method=\"POST\" name=\"del_form\">\n";
	        $DEL_VALUE .="<td align=\"center\" valign=\"top\">\n";
	        $DEL_VALUE .="    <input type=\"button\" value=\"削除する\" onclick=\"DiaryDeleteCheck( this.form , this.form )\" class=\"btn_nosize\" style=\"width:150px;\" />\n";
	        $DEL_VALUE .="    <input type=\"hidden\" name=\"mode\" value=\"DEL\" />\n";
	        $DEL_VALUE .="    <input type=\"hidden\" name=\"dr_id\" value=\"{$dr_id}\" />\n";
	        $DEL_VALUE .="    <input type=\"hidden\" name=\"dr_upddate\" value=\"{$dr_upddate}\" />\n";
	        $DEL_VALUE .="    <INPUT type=\"hidden\" name=\"dr_img1_lastupd\" value=\"{$dr_img1_lastupd}\" />\n";
	        $DEL_VALUE .="    <INPUT type=\"hidden\" name=\"dr_img2_lastupd\" value=\"{$dr_img2_lastupd}\" />\n";
	        $DEL_VALUE .="    <INPUT type=\"hidden\" name=\"dr_img3_lastupd\" value=\"{$dr_img3_lastupd}\" />\n";
	        $DEL_VALUE .="    <INPUT type=\"hidden\" name=\"dr_img4_lastupd\" value=\"{$dr_img4_lastupd}\" />\n";
	        $DEL_VALUE .="</td>\n";
	        $DEL_VALUE .="</form>\n";


	}else if($_POST['mode']=="NEW"){

		$modeName = "登録する";
		$dr_zoom = 10;

	}
}else{
	if($_POST['mode']=="EDIT"){
		$obj = new basedb_DiaryClassTblAccess;
		$obj->conn = $obj_conn->conn;
		$obj->jyoken["dr_del_date"] = 1;
		$obj->jyoken["dr_id"] = $_POST['dr_id'];
		list( $intCnt , $intTotal ) = $obj->basedb_GetDiary( 1 , -1 );
		IF( $intCnt == -1 ){
			$arrOther["ath_comment"] = "<INPUT TYPE=\"hidden\" NAME=\"stpos\" VALUE=\"{$_POST['stpos']}\">";
			$obj_error->ViewErrMessage( "SYSTEM" , "ALL" , SITE_PATH."blank.php" , $arrOther );
			exit;
		}

		$dr_id = htmlspecialchars ($obj->diarydat[0]["dr_id"]);
		$dr_clid = htmlspecialchars ($obj->diarydat[0]["dr_clid"]);
		$dr_cgid = htmlspecialchars ($obj->diarydat[0]["dr_cgid"]);
		$dr_tcid = htmlspecialchars ($obj->diarydat[0]["dr_tcid"]);
		$dr_title = htmlspecialchars ($obj->diarydat[0]["dr_title"]);
		$dr_contents = htmlspecialchars ($obj->diarydat[0]["dr_contents"]);
		$dr_upddate = htmlspecialchars ($obj->diarydat[0]["dr_upddate"]);
		$dr_imgorg1 = htmlspecialchars ($obj->diarydat[0]["dr_imgorg1"]);
		$dr_imgorg2 = htmlspecialchars ($obj->diarydat[0]["dr_imgorg2"]);
		$dr_imgorg3 = htmlspecialchars ($obj->diarydat[0]["dr_imgorg3"]);
		$dr_imgorg4 = htmlspecialchars ($obj->diarydat[0]["dr_imgorg4"]);
		$dr_img1_lastupd = htmlspecialchars ($obj->diarydat[0]["dr_img1"]);
		$dr_img2_lastupd = htmlspecialchars ($obj->diarydat[0]["dr_img2"]);
		$dr_img3_lastupd = htmlspecialchars ($obj->diarydat[0]["dr_img3"]);
		$dr_img4_lastupd = htmlspecialchars ($obj->diarydat[0]["dr_img4"]);
		$dr_ido = htmlspecialchars ($obj->diarydat[0]["dr_ido"]);
		$dr_keido = htmlspecialchars ($obj->diarydat[0]["dr_keido"]);
		$dr_zoom = htmlspecialchars ($obj->diarydat[0]["dr_zoom"]);
		if($obj->diarydat[0]["dr_biko_1"] != "////" && $obj->diarydat[0]["dr_biko_1"] != ""){
			$dr_map = split("/",$obj->diarydat[0]["dr_biko_1"]);
		}

		$modeName = "登録する";
		
		$DEL_VALUE = "";
		$DEL_VALUE .="<form action=\"diary_upd.php\" method=\"POST\" name=\"del_form\">\n";
	        $DEL_VALUE .="<td align=\"center\" valign=\"top\">\n";
	        $DEL_VALUE .="    <input type=\"button\" value=\"削除する\" onclick=\"DiaryDeleteCheck( this.form , this.form )\" class=\"btn_nosize\" style=\"width:150px;\" />\n";
	        $DEL_VALUE .="    <input type=\"hidden\" name=\"mode\" value=\"DEL\" />\n";
	        $DEL_VALUE .="    <input type=\"hidden\" name=\"dr_id\" value=\"{$dr_id}\" />\n";
	        $DEL_VALUE .="    <input type=\"hidden\" name=\"dr_upddate\" value=\"{$dr_upddate}\" />\n";
	        $DEL_VALUE .="    <INPUT type=\"hidden\" name=\"dr_img1_lastupd\" value=\"{$dr_img1_lastupd}\" />\n";
	        $DEL_VALUE .="    <INPUT type=\"hidden\" name=\"dr_img2_lastupd\" value=\"{$dr_img2_lastupd}\" />\n";
	        $DEL_VALUE .="    <INPUT type=\"hidden\" name=\"dr_img3_lastupd\" value=\"{$dr_img3}\" />\n";
	        $DEL_VALUE .="    <INPUT type=\"hidden\" name=\"dr_img4_lastupd\" value=\"{$dr_img4_lastupd}\" />\n";
	        $DEL_VALUE .="</td>\n";
	        $DEL_VALUE .="</form>\n";


	}else if($_POST['mode']=="NEW"){

		$modeName = "登録する";
		$dr_zoom = 10;

	}
}

// ロゴ画像
$dr_img1_dir = $param_dr_img1_path;
$dr_img1_arr["org"] = $dr_imgorg1;
$dr_img1_arr["chk_in"] = "1";
$dr_img1_txt =  form_ImgDisp( "dr_img1" , $dr_img1_dir , $obj->diarydat[0]["dr_img1"] , "1" , $dr_img1_arr );

$dr_img2_dir = $param_dr_img2_path;
$dr_img2_arr["org"] = $dr_imgorg2;
$dr_img2_arr["chk_in"] = "1";
$dr_img2_txt =  form_ImgDisp( "dr_img2" , $dr_img2_dir , $obj->diarydat[0]["dr_img2"] , "1" , $dr_img2_arr );

$dr_img3_dir = $param_dr_img3_path;
$dr_img3_arr["org"] = $dr_imgorg3;
$dr_img3_arr["chk_in"] = "1";
$dr_img3_txt =  form_ImgDisp( "dr_img3" , $dr_img3_dir , $obj->diarydat[0]["dr_img3"] , "1" , $dr_img3_arr );

$dr_img4_dir = $param_dr_img4_path;
$dr_img4_arr["org"] = $dr_imgorg4;
$dr_img4_arr["chk_in"] = "1";
$dr_img4_txt =  form_ImgDisp( "dr_img4" , $dr_img4_dir , $obj->diarydat[0]["dr_img4"] , "1" , $dr_img4_arr );


$obj_cate = new basedb_CategoryClassTblAccess;
$obj_cate->conn = $obj_conn->conn;
$obj_cate->jyoken["cg_deldate"] = 1;
$obj_cate->jyoken["cg_stat"] = 1;
$obj_cate->jyoken["cg_type"] = 5;
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
	if($category_id == $dr_cgid && $dr_cgid!="")$cg_select = "selected";
	$cateValue .= "<OPTION VALUE=\"{$category_id}\" {$cg_select}>{$category_name}</OPTION>";
}

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
	if($teacher_id == $dr_tcid && $dr_tcid!="")$tc_select = "selected";
	$teacerValue .= "<OPTION VALUE=\"{$teacher_id}\" {$tc_select}>{$teacher_name}</OPTION>";
}


if($dr_zoom=="")$dr_zoom = 10;


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
    <LINK rel="stylesheet" type="text/css" href="../share/css/diary.css" />
    <SCRIPT type="text/javascript" src="../share/js/diary.js"></SCRIPT>
    <SCRIPT type="text/javascript" src="../share/js/tag.js"></SCRIPT>
    <SCRIPT type="text/javascript" src="../share/js/GoogleMap.js"></SCRIPT>
    <SCRIPT type="text/javascript" src="../share/js/input_check.js"></SCRIPT>
    <NOSCRIPT><META http-equiv="Refresh" content="1;URL=../jserror.html"></NOSCRIPT>
  </HEAD>
<!--
  <BODY onload="loadMap('1111000','<?=$dr_ido?>','<?=$dr_keido?>','<?=$dr_zoom?>','35.70972275209277','139.6527099609375','10','','','','<?=$param_marker_dia_img?>','<?=$param_marker_shadow_img?>')">
//-->
  <BODY>
    <div id="diary">
      <table id="client" cellspacing="0">
        <tr>
          <form action="diary_upd.php" method="POST" name="client" enctype="multipart/form-data">
          <th class="must">所属カテゴリー</th>
          <td>
            <SELECT name="dr_cgid">
              <option value="">-- 選択 --</option>
<?=$cateValue?>
            </SELECT>
          </td>
        </tr>
        <tr>
          <th class="must">タイトル</th>
          <td><input id="i2" type="text" name="dr_title" value="<?=$dr_title?>" maxlength="30" onFocus='Text("i2", 1)' onBlur='Text("i2", 2)' style="width:250px;" /></td>
        </tr>
        <tr>
          <th>講師</th>
          <td>
            <SELECT name="dr_tcid">
              <option value="">-- 選択 --</option>
<?=$teacerValue?>
            </SELECT>
          </td>
        </tr>
        <tr>
          <th>画像1</th>
          <td>
<?=$dr_img1_txt?>
            <BR><!--<FONT color="#ff0000">※選択された画像が日記情報一覧に表示されます</FONT>-->
<BR><font color="#ff0000">※画像は2MB以下のGIF画像かJPG画像をアップしてください</font>		
          </td>
        </tr>
        <tr>
          <th>画像2</th>
          <td>
<?=$dr_img2_txt?>
<BR><font color="#ff0000">※画像は2MB以下のGIF画像かJPG画像をアップしてください</font>		
          </td>
        </tr>
        <tr>
          <th>画像3</th>
          <td>
<?=$dr_img3_txt?>
<BR><font color="#ff0000">※画像は2MB以下のGIF画像かJPG画像をアップしてください</font>		
          </td>
        </tr>
        <tr>
          <th>画像4</th>
          <td>
<?=$dr_img4_txt?>
<BR><font color="#ff0000">※画像は2MB以下のGIF画像かJPG画像をアップしてください</font>		
          </td>
        </tr>
        <tr>
          <th class="must">本文</th>
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
            <INPUT type="image" src="../share/images/form/icon_img_1.gif" alt="画像1" onClick="HTML_TAG('free_text','IMAGE-1','1');return false;" />
            <INPUT type="image" src="../share/images/form/icon_img_2.gif" alt="画像2" onClick="HTML_TAG('free_text','IMAGE-2','1');return false;" />
            <INPUT type="image" src="../share/images/form/icon_img_3.gif" alt="画像3" onClick="HTML_TAG('free_text','IMAGE-3','1');return false;" />
            <INPUT type="image" src="../share/images/form/icon_img_4.gif" alt="画像4" onClick="HTML_TAG('free_text','IMAGE-4','1');return false;" />
            <br />
            <TEXTAREA id="free_text" name="dr_contents" onFocus='Text("free_text", 1)' onBlur='Text("free_text", 2)' cols="60" rows="10"><?=$dr_contents?></TEXTAREA>
            <br />
            <FONT color="#ff0000">※[IMG1〜4]が入っている位置に、上で選択された画像が表示されます。<br />画像が設定されていない場合は表示されません。</FONT>
          </td>
        </tr>
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
<input type="hidden" id="mapX" name="dr_keido" value="<?=$dr_keido?>"/>
<input type="hidden" id="mapY" name="dr_ido" value="<?=$dr_ido?>"/>
<input type="hidden" id="zoomN" name="dr_zoom" value="<?=$dr_zoom?>"/><BR>
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
            <input type="button" value="<?=$modeName?>" class="btn_nosize" onclick="return DiaryInputCheck( this.form , this.form )" style="width:150px;" />
            <input type="hidden" name="mode" value="<?=$_POST['mode']?>" />
            <input type="hidden" name="dr_id" value="<?=$dr_id?>" />
            <input type="hidden" name="dr_upddate" value="<?=$dr_upddate?>" />
            <INPUT type="hidden" name="stpos" value="<?=$_POST['stpos']?>" />
            <INPUT type="hidden" name="dr_img1_lastupd" value="<?=$dr_img1_lastupd?>" />
            <INPUT type="hidden" name="dr_img2_lastupd" value="<?=$dr_img2_lastupd?>" />
            <INPUT type="hidden" name="dr_img3_lastupd" value="<?=$dr_img3_lastupd?>" />
            <INPUT type="hidden" name="dr_img4_lastupd" value="<?=$dr_img4_lastupd?>" />
          </td>
          </form>
<?=$DEL_VALUE?>
          <form method="POST" action="diary_main.php">
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
