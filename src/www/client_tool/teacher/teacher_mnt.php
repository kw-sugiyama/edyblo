<?
/******************************************************************************
<< 不動産ブログ　Ver.1.O.0 >>
	Name: teacher_main.php
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

		$obj = new basedb_TeacherClassTblAccess;
		$obj->conn = $obj_conn->conn;
		$obj->jyoken["tc_deldate"] = 1;
		$obj->jyoken["tc_id"] = $_POST['tc_id'];
		list( $intCnt , $intTotal ) = $obj->basedb_GetTeacher( 1 , -1 );
		IF( $intCnt == -1 ){
			$arrOther["ath_comment"] = "<INPUT TYPE=\"hidden\" NAME=\"stpos\" VALUE=\"{$_POST['stpos']}\">";
			$obj_error->ViewErrMessage( "SYSTEM" , "ALL" , SITE_PATH."blank.php" , $arrOther );
			exit;
		}


		$tc_id = htmlspecialchars ($arrData["tc_id"]);
		$tc_cpid = htmlspecialchars ($arrData["tc_cpid"]);
		$tc_stat = htmlspecialchars ($arrData["tc_stat"]);
		$tc_name = htmlspecialchars ($arrData["tc_name"]);
		$tc_img_lastupd = htmlspecialchars ($arrData["tc_img"]);
		$tc_imgorg = htmlspecialchars ($arrData["tc_imgorg"]);
		$tc_contents = htmlspecialchars ($arrData["tc_contents"]);
		$tc_comment = htmlspecialchars ($arrData["tc_comment"]);
		$tc_subject = htmlspecialchars ($arrData["tc_subject"]);
		$tc_age = htmlspecialchars ($arrData["tc_age"]);
		$tc_upddate = htmlspecialchars ($arrData["tc_upddate"]);

	if($_POST['mode']=="EDIT"){
		$modeName = "登録する";

		
		$DEL_VALUE = "";
		$DEL_VALUE .="<form action=\"teacher_upd.php\" method=\"POST\" name=\"del_form\">\n";
	        $DEL_VALUE .="<td align=\"center\" valign=\"top\">\n";
	        $DEL_VALUE .="    <input type=\"button\" value=\"削除する\" onclick=\"TeacherDeleteCheck( this.form , this.form )\" class=\"btn_nosize\" style=\"width:150px;\" />\n";
	        $DEL_VALUE .="    <input type=\"hidden\" name=\"mode\" value=\"DEL\" />\n";
	        $DEL_VALUE .="    <input type=\"hidden\" name=\"tc_id\" value=\"{$tc_id}\" />\n";
	        $DEL_VALUE .="    <input type=\"hidden\" name=\"tc_upddate\" value=\"{$tc_upddate}\" />\n";
	        $DEL_VALUE .="    <INPUT type=\"hidden\" name=\"tc_img_lastupd\" value=\"{$tc_img_lastupd}\" />\n";
	        $DEL_VALUE .="</td>\n";
	        $DEL_VALUE .="</form>\n";


	}else if($_POST['mode']=="NEW"){

		$modeName = "登録する";
		$tc_zoom = 10;

	}
}else{
	if($_POST['mode']=="EDIT"){
		$obj = new basedb_TeacherClassTblAccess;
		$obj->conn = $obj_conn->conn;
		$obj->jyoken["tc_del_date"] = 1;
		$obj->jyoken["tc_id"] = $_POST['tc_id'];
		list( $intCnt , $intTotal ) = $obj->basedb_GetTeacher( 1 , -1 );
		IF( $intCnt == -1 ){
			$arrOther["ath_comment"] = "<INPUT TYPE=\"hidden\" NAME=\"stpos\" VALUE=\"{$_POST['stpos']}\">";
			$obj_error->ViewErrMessage( "SYSTEM" , "ALL" , SITE_PATH."blank.php" , $arrOther );
			exit;
		}

		$tc_id = htmlspecialchars ($obj->teacherdat[0]["tc_id"]);
		$tc_cpid = htmlspecialchars ($obj->teacherdat[0]["tc_cpid"]);
		$tc_stat = htmlspecialchars ($obj->teacherdat[0]["tc_stat"]);
		$tc_name = htmlspecialchars ($obj->teacherdat[0]["tc_name"]);
		$tc_img_lastupd = htmlspecialchars ($obj->teacherdat[0]["tc_img"]);
		$tc_imgorg = htmlspecialchars ($obj->teacherdat[0]["tc_imgorg"]);
		$tc_contents = htmlspecialchars ($obj->teacherdat[0]["tc_contents"]);
		$tc_comment = htmlspecialchars ($obj->teacherdat[0]["tc_comment"]);
		$tc_subject = htmlspecialchars ($obj->teacherdat[0]["tc_subject"]);
		$tc_age = htmlspecialchars ($obj->teacherdat[0]["tc_age"]);
		$tc_upddate = htmlspecialchars ($obj->teacherdat[0]["tc_upddate"]);

		$modeName = "登録する";
		
		$DEL_VALUE = "";
		$DEL_VALUE .="<form action=\"teacher_upd.php\" method=\"POST\" name=\"del_form\">\n";
	        $DEL_VALUE .="<td align=\"center\" valign=\"top\">\n";
	        $DEL_VALUE .="    <input type=\"button\" value=\"削除する\" onclick=\"TeacherDeleteCheck( this.form , this.form )\" class=\"btn_nosize\" style=\"width:150px;\" />\n";
	        $DEL_VALUE .="    <input type=\"hidden\" name=\"mode\" value=\"DEL\" />\n";
	        $DEL_VALUE .="    <input type=\"hidden\" name=\"tc_id\" value=\"{$tc_id}\" />\n";
	        $DEL_VALUE .="    <input type=\"hidden\" name=\"tc_upddate\" value=\"{$tc_upddate}\" />\n";
	        $DEL_VALUE .="    <INPUT type=\"hidden\" name=\"tc_img_lastupd\" value=\"{$tc_img_lastupd}\" />\n";
	        $DEL_VALUE .="</td>\n";
	        $DEL_VALUE .="</form>\n";


	}else if($_POST['mode']=="NEW"){

		$modeName = "登録する";
		$tc_zoom = 10;

	}
}

// ロゴ画像
$tc_img_dir = $param_tc_img_path;
$tc_img_arr["org"] = $tc_imgorg;
$tc_img_arr["chk_in"] = "1";
$tc_img_txt =  form_ImgDisp( "tc_img" , $tc_img_dir , $obj->teacherdat[0]["tc_img"] , "1" , $tc_img_arr );


// 対象学年
if( ($tc_age & 128) == 128 ){
	$agechecked8 = " checked";
	$tc_age -= 128;
}
if( ($tc_age & 64) == 64 ){
	$agechecked7 = " checked";
	$tc_age -= 64;
}
if( ($tc_age & 32) == 32 ){
	$agechecked6 = " checked";
	$tc_age -= 32;
}
if( ($tc_age & 16) == 16 ){
	$agechecked5 = " checked";
	$tc_age -= 16;
}
if( ($tc_age & 8) == 8 ){
	$agechecked4 = " checked";
	$tc_age -= 8;
}
if( ($tc_age & 4) == 4 ){
	$agechecked3 = " checked";
	$tc_age -= 4;
}
if( ($tc_age & 2) == 2 ){
	$agechecked2 = " checked";
	$tc_age -= 2;
}
if( ($tc_age & 1) == 1 ){
	$agechecked1 = " checked";
	$tc_age -= 1;
}


// 状態
if( $tc_stat == 1 ){
	 $statchecked1 = " checked";
}else if( $tc_stat == 9 ){
	 $statchecked2 = " checked";
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
    <LINK rel="stylesheet" type="text/css" href="../share/css/teacher.css" />
    <SCRIPT type="text/javascript" src="../share/js/teacher.js"></SCRIPT>
    <SCRIPT type="text/javascript" src="../share/js/tag.js"></SCRIPT>
    <SCRIPT type="text/javascript" src="../share/js/GoogleMap.js"></SCRIPT>
    <SCRIPT type="text/javascript" src="../share/js/input_check.js"></SCRIPT>
    <NOSCRIPT><META http-equiv="Refresh" content="1;URL=../jserror.html"></NOSCRIPT>
  </HEAD>
  <BODY onload="loadMap('1111000','<?=$tc_ido?>','<?=$tc_keido?>','<?=$tc_zoom?>','35.70972275209277','139.6527099609375','10','','','','<?=$param_marker_dia_img?>','<?=$param_marker_shadow_img?>')">
    <div id="teacher">
      <table id="client" cellspacing="0">
        <TR>
        <form action="teacher_upd.php" method="POST" name="client" enctype="multipart/form-data">
          <TH class="must">状態</TH>
          <TD>
            <INPUT type="radio" id="tc_stat0" name="tc_stat" value="1" <?=$statchecked1?> onFocus='Text("tc_stat0", 1)' onBlur='Text("tc_stat0", 2)' />有効　
            <INPUT type="radio" id="tc_stat1" name="tc_stat" value="9" <?=$statchecked2?> onFocus='Text("tc_stat1", 1)' onBlur='Text("tc_stat1", 2)' />無効　
          </TD>
        </TR>
        <tr>
          <th class="must">講師名</th>
          <td><input id="i2" type="text" name="tc_name" value="<?=$tc_name?>" maxlength="30" onFocus='Text("tc_name", 1)' onBlur='Text("tc_name", 2)' style="width:250px;" /></td>
        </tr>
        <tr>
          <th>画像</th>
          <td>
<?=$tc_img_txt?>
            <BR><FONT color="#ff0000">※選択された画像が各詳細ページで表示されます</FONT>
<BR><font color="#ff0000">※画像は2MB以下のGIF画像かJPG画像をアップしてください</font>		
          </td>
        </tr>
        <TR>
          <TH>対象学年</TH>
          <TD>
            <INPUT type="checkbox" id="tc_age0" name="tc_age[0]" value="1" <?=$agechecked1?> onFocus='Text("tc_age0", 1)' onBlur='Text("tc_age0", 2)' />幼児　
            <INPUT type="checkbox" id="tc_age1" name="tc_age[1]" value="2" <?=$agechecked2?> onFocus='Text("tc_age1", 1)' onBlur='Text("tc_age1", 2)' />小学生　
            <INPUT type="checkbox" id="tc_age2" name="tc_age[2]" value="4" <?=$agechecked3?> onFocus='Text("tc_age2", 1)' onBlur='Text("tc_age2", 2)' />中学生　
            <INPUT type="checkbox" id="tc_age3" name="tc_age[3]" value="8" <?=$agechecked4?> onFocus='Text("tc_age3", 1)' onBlur='Text("tc_age3", 2)' />高校生　
            <INPUT type="checkbox" id="tc_age4" name="tc_age[4]" value="16" <?=$agechecked5?> onFocus='Text("tc_age4", 1)' onBlur='Text("tc_age4", 2)' />浪人生　
            <INPUT type="checkbox" id="tc_age5" name="tc_age[5]" value="32" <?=$agechecked6?> onFocus='Text("tc_age5", 1)' onBlur='Text("tc_age5", 2)' />大学生　
            <INPUT type="checkbox" id="tc_age6" name="tc_age[6]" value="64" <?=$agechecked7?> onFocus='Text("tc_age6", 1)' onBlur='Text("tc_age6", 2)' />社会人　
          </TD>
        </TR>
        <tr>
          <th>教科</th>
          <td><input id="i2" type="text" name="tc_subject" value="<?=$tc_subject?>" maxlength="30" onFocus='Text("tc_subject", 1)' onBlur='Text("tc_subject", 2)' style="width:250px;" /></td>
        </tr>
<!--
        <TR>
          <TH>本文</TH>
          <TD><TEXTAREA name="tc_contents" id="tc_contents" rows="5" style="width:370" onFocus='Text("tc_contents", 1)' onBlur='Text("tc_contents", 2)' ><?=$tc_contents?></TEXTAREA></TD>
        </TR>
//-->
        <tr>
          <th>コメント</th>
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
            <INPUT type="image" src="../share/images/form/icon_img_1.gif" alt="画像" onClick="HTML_TAG('free_text','IMAGE-1','1');return false;" />
//-->
            <br />
            <TEXTAREA id="free_text" name="tc_comment" onFocus='Text("free_text", 1)' onBlur='Text("free_text", 2)' cols="60" rows="10"><?=$tc_comment?></TEXTAREA>
            <br />
            <FONT color="#ff0000">※[IMG1〜4]が入っている位置に、上で選択された画像が表示されます。<br />画像が設定されていない場合は表示されません。</FONT>
          </td>
        </tr>
      </table>
    </div>
    <div align="center">
      <table width="500">
        <tr>
          <td align="center" valign="top">
            <input type="button" value="<?=$modeName?>" class="btn_nosize" onclick="return TeacherInputCheck( this.form , this.form )" style="width:150px;" />
            <input type="hidden" name="mode" value="<?=$_POST['mode']?>" />
            <input type="hidden" name="tc_id" value="<?=$tc_id?>" />
            <input type="hidden" name="tc_upddate" value="<?=$tc_upddate?>" />
            <INPUT type="hidden" name="stpos" value="<?=$_POST['stpos']?>" />
            <INPUT type="hidden" name="tc_img_lastupd" value="<?=$tc_img_lastupd?>" />
            <INPUT type="hidden" name="tc_img2_lastupd" value="<?=$tc_img2_lastupd?>" />
            <INPUT type="hidden" name="tc_img3_lastupd" value="<?=$tc_img3_lastupd?>" />
            <INPUT type="hidden" name="tc_img4_lastupd" value="<?=$tc_img4_lastupd?>" />
          </td>
          </form>
<?=$DEL_VALUE?>
          <form method="POST" action="teacher_main.php">
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
