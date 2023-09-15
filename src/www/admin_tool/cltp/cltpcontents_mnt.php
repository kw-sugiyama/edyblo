<?
/******************************************************************************
<< 不動産ブログ　Ver.1.O.0 >>
	Name: blog_main.php
	Version: 1.0.0
	Function: ブログ基本設定情報一覧
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
require_once ( SYS_PATH."dbif/basedb_AdminClass.php" );
require_once ( SYS_PATH."dbif/basedb_ClientClass.php" );
require_once ( SYS_PATH."dbif/basedb_CltpcontentsClass.php" );
require_once ( SYS_PATH."dbif/basedb_CltpcateClass.php" );
require_once ( SYS_PATH."common/base_common.php" );
require_once ( SYS_PATH."common/sys_common.php" );
require_once ( SYS_PATH."common/form_common.php" );
include_once ( SYS_PATH."common/error.class.php" );
require_once ( SYS_PATH."configs/param_base.conf" );
require_once ( SYS_PATH."configs/param_file.conf" );


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
$obj = new basedb_CltpcontentsClassTblAccess;
$obj->conn = $obj_conn->conn;
$obj->jyoken["cltpcontents_del_date"] = 1;
$obj->jyoken["cltpcontents_id"] = $_POST["cltpcontents_id"];
list( $intNum , $intTotal ) = $obj->basedb_GetCltpcontents( 1 , -1 );
IF( $intNum == -1 ){
	$arrOther["ath_comment"] = "<INPUT TYPE=\"hidden\" NAME=\"stpos\" VALUE=\"{$_POST['stpos']}\">";
	$obj_error->ViewErrMessage( "SYSTEM" , "ALL" , SITE_PATH."blank.php" , $arrOther );
	exit;
}


/*--------------------------------------------------------
  一覧表示内容生成
--------------------------------------------------------*/
if($_POST['error_mode']=="on"){
	foreach($_POST as $key => $val){
		$arrData[$key] = stripslashes($val);
	}
		$cltpcontents_id = htmlspecialchars ($arrData["cltpcontents_id"]);
		$cltpcontents_cate_id = htmlspecialchars ($arrData["cltpcontents_cate_id"]);
		$cltpcontents_stat = htmlspecialchars ($arrData["cltpcontents_stat"]);
		$cltpcontents_title = htmlspecialchars ($arrData["cltpcontents_title"]);
		$cltpcontents_date = htmlspecialchars ($arrData["cltpcontents_date"]);
		$cltpcontents_contents = htmlspecialchars ($arrData["cltpcontents_contents"]);
		$cltpcontents_upd_date = htmlspecialchars ($arrData["cltpcontents_upd_date"]);
		$cltpcontents_img_org_1 = htmlspecialchars ($arrData["cltpcontents_img_org_1"]);
		$cltpcontents_img_org_2 = htmlspecialchars ($arrData["cltpcontents_img_org_2"]);
		$cltpcontents_img_org_3 = htmlspecialchars ($arrData["cltpcontents_img_org_3"]);
		$cltpcontents_img_org_4 = htmlspecialchars ($arrData["cltpcontents_img_org_4"]);
		$cltpcontents_img_1_lastupd = htmlspecialchars ($arrData["cltpcontents_img_1"]);
		$cltpcontents_img_2_lastupd = htmlspecialchars ($arrData["cltpcontents_img_2"]);
		$cltpcontents_img_3_lastupd = htmlspecialchars ($arrData["cltpcontents_img_3"]);
		$cltpcontents_img_4_lastupd = htmlspecialchars ($arrData["cltpcontents_img_4"]);

		if($cltpcontents_stat == "1" ){
			$CateFlgCheck1 = " checked";
		}else if( $cltpcontents_stat == "9" ){
			$CateFlgCheck2 = " checked";
		}
	if($_POST['mode'] == "EDIT"){

		$strDelTag = "";
		$strDelTag .= "          <form action=\"cltpcontents_upd.php\" method=\"POST\" name=\"del_form\">\n";
		$strDelTag .= "          <td align=\"center\" valign=\"top\">\n";
		$strDelTag .= "            <input type=\"button\" value=\"削除する\" class=\"btn_nosize\" onclick=\"CltpcontentsDelchk( this.form , this.form )\" />\n";
		$strDelTag .= "            <input type=\"hidden\" name=\"mode\" value=\"DEL\" />\n";
		$strDelTag .= "            <input type=\"hidden\" name=\"cltpcontents_id\" value=\"{$cltpcontents_id}\" />\n";
		$strDelTag .= "            <input type=\"hidden\" name=\"cltpcontents_upd_date\" value=\"{$cltpcontents_upd_date}\" />\n";
		$strDelTag .= "            <input type=\"hidden\" name=\"cltpcontents_img_1_lastupd\" value=\"{$cltpcontents_img_1_lastupd}\" />\n";
		$strDelTag .= "            <input type=\"hidden\" name=\"cltpcontents_img_2_lastupd\" value=\"{$cltpcontents_img_2_lastupd}\" />\n";
		$strDelTag .= "            <input type=\"hidden\" name=\"cltpcontents_img_3_lastupd\" value=\"{$cltpcontents_img_3_lastupd}\" />\n";
		$strDelTag .= "            <input type=\"hidden\" name=\"cltpcontents_img_4_lastupd\" value=\"{$cltpcontents_img_4_lastupd}\" />\n";
		$strDelTag .= "          </td>\n";
		$strDelTag .= "          </form>\n";


		$modeName = "修正";
	}else if($_POST["mode"]=="NEW"){
		$modeName = "登録";
	}


}else{
	if($_POST['mode'] == "EDIT"){

		$cltpcontents_id = htmlspecialchars ($obj->cltpcontentsdat[0]["cltpcontents_id"]);
		$cltpcontents_cate_id = htmlspecialchars ($obj->cltpcontentsdat[0]["cltpcontents_cate_id"]);
		$cltpcontents_stat = htmlspecialchars ($obj->cltpcontentsdat[0]["cltpcontents_stat"]);
		$cltpcontents_title = htmlspecialchars ($obj->cltpcontentsdat[0]["cltpcontents_title"]);
		$cltpcontents_date = htmlspecialchars ($obj->cltpcontentsdat[0]["cltpcontents_date"]);
		if($cltpcontents_date!="")$timestamp = split(" ",$cltpcontents_date);
		if($timestamp[0]!="")$date = split("-",$timestamp[0]);

		$cltpcontents_contents = htmlspecialchars ($obj->cltpcontentsdat[0]["cltpcontents_contents"]);
		$cltpcontents_upd_date = htmlspecialchars ($obj->cltpcontentsdat[0]["cltpcontents_upd_date"]);
		$cltpcontents_img_org_1 = htmlspecialchars ($obj->cltpcontentsdat[0]["cltpcontents_img_org_1"]);
		$cltpcontents_img_org_2 = htmlspecialchars ($obj->cltpcontentsdat[0]["cltpcontents_img_org_2"]);
		$cltpcontents_img_org_3 = htmlspecialchars ($obj->cltpcontentsdat[0]["cltpcontents_img_org_3"]);
		$cltpcontents_img_org_4 = htmlspecialchars ($obj->cltpcontentsdat[0]["cltpcontents_img_org_4"]);
		$cltpcontents_img_1_lastupd = htmlspecialchars ($obj->cltpcontentsdat[0]["cltpcontents_img_1"]);
		$cltpcontents_img_2_lastupd = htmlspecialchars ($obj->cltpcontentsdat[0]["cltpcontents_img_2"]);
		$cltpcontents_img_3_lastupd = htmlspecialchars ($obj->cltpcontentsdat[0]["cltpcontents_img_3"]);
		$cltpcontents_img_4_lastupd = htmlspecialchars ($obj->cltpcontentsdat[0]["cltpcontents_img_4"]);

		if($cltpcontents_stat == "1" ){
			$CateFlgCheck1 = " checked";
		}else if( $cltpcontents_stat == "9" ){
			$CateFlgCheck2 = " checked";
		}

		$strDelTag = "";
		$strDelTag .= "          <form action=\"cltpcontents_upd.php\" method=\"POST\" name=\"del_form\">\n";
		$strDelTag .= "          <td align=\"center\" valign=\"top\">\n";
		$strDelTag .= "            <input type=\"button\" value=\"削除する\" class=\"btn_nosize\" onclick=\"CltpcontentsDelchk( this.form , this.form )\" />\n";
		$strDelTag .= "            <input type=\"hidden\" name=\"mode\" value=\"DEL\" />\n";
		$strDelTag .= "            <input type=\"hidden\" name=\"cltpcontents_id\" value=\"{$cltpcontents_id}\" />\n";
		$strDelTag .= "            <input type=\"hidden\" name=\"cltpcontents_upd_date\" value=\"{$cltpcontents_upd_date}\" />\n";
		$strDelTag .= "            <input type=\"hidden\" name=\"cltpcontents_img_1_lastupd\" value=\"{$cltpcontents_img_1_lastupd}\" />\n";
		$strDelTag .= "            <input type=\"hidden\" name=\"cltpcontents_img_2_lastupd\" value=\"{$cltpcontents_img_2_lastupd}\" />\n";
		$strDelTag .= "            <input type=\"hidden\" name=\"cltpcontents_img_3_lastupd\" value=\"{$cltpcontents_img_3_lastupd}\" />\n";
		$strDelTag .= "            <input type=\"hidden\" name=\"cltpcontents_img_4_lastupd\" value=\"{$cltpcontents_img_4_lastupd}\" />\n";
		$strDelTag .= "          </td>\n";
		$strDelTag .= "          </form>\n";


		$modeName = "修正";
	}else if($_POST["mode"]=="NEW"){
		$modeName = "登録";
	}

}

// ロゴ画像
$cltpcontents_img_1_dir = $param_cltpcontents_img_1_relativepath_admin;
$cltpcontents_img_1_arr["org"] = $cltpcontents_img_org_1;
$cltpcontents_img_1_arr["chk_in"] = "1";
$cltpcontents_img_1_txt =  form_ImgDisp( "cltpcontents_img_1" , $cltpcontents_img_1_dir , $obj->cltpcontentsdat[0]["cltpcontents_img_1"] , "1" , $cltpcontents_img_1_arr );

$cltpcontents_img_2_dir = $param_cltpcontents_img_2_relativepath_admin;
$cltpcontents_img_2_arr["org"] = $cltpcontents_img_org_2;
$cltpcontents_img_2_arr["chk_in"] = "1";
$cltpcontents_img_2_txt =  form_ImgDisp( "cltpcontents_img_2" , $cltpcontents_img_2_dir , $obj->cltpcontentsdat[0]["cltpcontents_img_2"] , "1" , $cltpcontents_img_2_arr );

$cltpcontents_img_3_dir = $param_cltpcontents_img_3_relativepath_admin;
$cltpcontents_img_3_arr["org"] = $cltpcontents_img_org_3;
$cltpcontents_img_3_arr["chk_in"] = "1";
$cltpcontents_img_3_txt =  form_ImgDisp( "cltpcontents_img_3" , $cltpcontents_img_3_dir , $obj->cltpcontentsdat[0]["cltpcontents_img_3"] , "1" , $cltpcontents_img_3_arr );

$cltpcontents_img_4_dir = $param_cltpcontents_img_4_relativepath_admin;
$cltpcontents_img_4_arr["org"] = $cltpcontents_img_org_4;
$cltpcontents_img_4_arr["chk_in"] = "1";
$cltpcontents_img_4_txt =  form_ImgDisp( "cltpcontents_img_4" , $cltpcontents_img_4_dir , $obj->cltpcontentsdat[0]["cltpcontents_img_4"] , "1" , $cltpcontents_img_4_arr );


$obj_cate = new basedb_CltpcateClassTblAccess;
$obj_cate->conn = $obj_conn->conn;
$obj_cate->jyoken["cltpcate_del_date"] = 1;
$obj_cate->jyoken["cltpcate_stat"] = 1;
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
	if($cltpcate_id == $cltpcontents_cate_id && $cltpcontents_cate_id!="")$cltpcate_select = "selected";
	$cltpcateValue .= "<OPTION VALUE=\"{$cltpcate_id}\" {$cltpcate_select}>{$cltpcate_name}</OPTION>";
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
  <HEAD>
    <TITLE>不動産ブログ - クライアントツール</TITLE>
    <META http-equiv="Content-Type" content="text/html;charset=EUC-JP" />
    <META http-equiv="Content-Style-Type" content="text/css" />
    <META http-equiv="Content-Script-Type" content="text/javascript" />
    <LINK rel="stylesheet" type="text/css" href="../share/css/cltpcontents.css" />
    <SCRIPT type="text/javascript" src="../share/js/cltpcontents.js"></SCRIPT>
    <SCRIPT type="text/javascript" src="../share/js/tag.js"></SCRIPT>
    <SCRIPT type="text/javascript" src="../share/js/input_check.js"></SCRIPT>
    <NOSCRIPT><META http-equiv="Refresh" content="1;URL=../jserror.html"></NOSCRIPT>
  </HEAD>
  <BODY>
    <div align="left">
      <table id="client" cellspacing="0">
        <tr>
          <form action="cltpcontents_upd.php" method="POST" name="admin" enctype="multipart/form-data">
          <th class="must">状態</th>
          <td>
            <input type="radio" name="cltpcontents_stat" value="1" id="kengen1" <?=$CateFlgCheck1?>/><label for="kengen1">表示</label>
            <input type="radio" name="cltpcontents_stat" value="9" id="kengen9" <?=$CateFlgCheck2?>/><label for="kengen9">非表示</label>
          </td>
        </tr>
        <tr>
          <th class="must">日付</th>
          <td>
            <input type="text" name="cltpcontents_date_year" value="<?=$date[0]?>" style="width:50px"/>年
            <input type="text" name="cltpcontents_date_month" value="<?=$date[1]?>" style="width:25px"/>月
            <input type="text" name="cltpcontents_date_day" value="<?=$date[2]?>" style="width:25px"/>日
          </td>
        </tr>
        <tr>
          <th class="must">カテゴリ</th>
          <td>
            <select name="cltpcontents_cate_id">
<?=$cltpcateValue?>
            </select>
          </td>
        </tr>
        <tr>
          <th class="must">タイトル</th>
          <td><input id="i1" type="text" name="cltpcontents_title" value="<?=$cltpcontents_title?>"  style="width:300px" onFocus='Text("i1", 1)' onBlur='Text("i1", 2)' /></td>
        </tr>
        <input type="hidden" name="cltpcontents_disp_no" value="<?=$cltpcontents_disp_no?>"/>
        <tr>
          <th>画像1</th>
          <td>
<?=$cltpcontents_img_1_txt?>
<BR><font color="#ff0000">※画像は2MB以下のGIF画像かJPG画像をアップしてください</font>		
          </td>
        </tr>
        <tr>
          <th>画像2</th>
          <td>
<?=$cltpcontents_img_2_txt?>
<BR><font color="#ff0000">※画像は2MB以下のGIF画像かJPG画像をアップしてください</font>		
          </td>
        </tr>
        <tr>
          <th>画像3</th>
          <td>
<?=$cltpcontents_img_3_txt?>
<BR><font color="#ff0000">※画像は2MB以下のGIF画像かJPG画像をアップしてください</font>		
          </td>
        </tr>
        <tr>
          <th>画像4</th>
          <td>
<?=$cltpcontents_img_4_txt?>
<BR><font color="#ff0000">※画像は2MB以下のGIF画像かJPG画像をアップしてください</font>		
          </td>
        </tr>
        <tr>
          <th class="must">記事内容</th>
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
            <textarea id="free_text" name="cltpcontents_contents" onFocus='Text("free_text", 1)' onBlur='Text("free_text", 2)' rows="10" cols="65"><?=$cltpcontents_contents?></textarea>
            <br />
            <FONT color="#ff0000">※[IMG1〜4]が入っている位置に、上で選択された画像が表示されます。<br />画像が設定されていない場合は表示されません。</FONT>
          </td>
        </tr>
      </TABLE>
      <BR><BR>
      <br />
      <table style="margin:0px 0px 0px 200px;">
        <tr>
          <td align="center" valign="top">
            <input type="button" value="登録する" class="btn_nosize" onclick="CltpcontentsInputCheck( this.form , this.form )" />
            <input type="hidden" name="stpos" value="<?=$_POST["stpos"]?>" />
            <input type="hidden" name="sea_cltpcate_id" value="<?=$_POST["sea_cltpcate_id"]?>" />
            <input type="hidden" name="sea_cltpcontents_date_s_y" value="<?=$_POST["sea_cltpcontents_date_s_y"]?>" />
            <input type="hidden" name="sea_cltpcontents_date_s_m" value="<?=$_POST["sea_cltpcontents_date_s_m"]?>" />
            <input type="hidden" name="sea_cltpcontents_date_s_d" value="<?=$_POST["sea_cltpcontents_date_s_d"]?>" />
            <input type="hidden" name="sea_cltpcontents_date_e_y" value="<?=$_POST["sea_cltpcontents_date_e_y"]?>" />
            <input type="hidden" name="sea_cltpcontents_date_e_m" value="<?=$_POST["sea_cltpcontents_date_e_m"]?>" />
            <input type="hidden" name="sea_cltpcontents_date_e_d" value="<?=$_POST["sea_cltpcontents_date_e_d"]?>" />
            <input type="hidden" name="search_flg" value="<?=$_POST["search_flg"]?>" />
            <input type="hidden" name="mode" value="<?=$_POST['mode']?>" />
            <input type="hidden" name="cltpcontents_id" value="<?=$cltpcontents_id?>" />
            <input type="hidden" name="cltpcontents_upd_date" value="<?=$cltpcontents_upd_date?>" />
            <input type="hidden" name="cltpcontents_img_1_lastupd" value="<?=$cltpcontents_img_1_lastupd?>" />
            <input type="hidden" name="cltpcontents_img_2_lastupd" value="<?=$cltpcontents_img_2_lastupd?>" />
            <input type="hidden" name="cltpcontents_img_3_lastupd" value="<?=$cltpcontents_img_3_lastupd?>" />
            <input type="hidden" name="cltpcontents_img_4_lastupd" value="<?=$cltpcontents_img_4_lastupd?>" />
          </td>
          </form>
<?=$strDelTag?>
          <form method="POST" action="cltpcontents_main.php">
          <td align="center" valign="top">
            <input type="hidden" name="stpos" value="<?=$_POST["stpos"]?>" />
            <input type="hidden" name="sea_cltpcate_id" value="<?=$_POST["sea_cltpcate_id"]?>" />
            <input type="hidden" name="sea_cltpcontents_date_s_y" value="<?=$_POST["sea_cltpcontents_date_s_y"]?>" />
            <input type="hidden" name="sea_cltpcontents_date_s_m" value="<?=$_POST["sea_cltpcontents_date_s_m"]?>" />
            <input type="hidden" name="sea_cltpcontents_date_s_d" value="<?=$_POST["sea_cltpcontents_date_s_d"]?>" />
            <input type="hidden" name="sea_cltpcontents_date_e_y" value="<?=$_POST["sea_cltpcontents_date_e_y"]?>" />
            <input type="hidden" name="sea_cltpcontents_date_e_m" value="<?=$_POST["sea_cltpcontents_date_e_m"]?>" />
            <input type="hidden" name="sea_cltpcontents_date_e_d" value="<?=$_POST["sea_cltpcontents_date_e_d"]?>" />
            <input type="hidden" name="search_flg" value="<?=$_POST["search_flg"]?>" />
            <input type="submit" name="bak" value="戻る" class="btn_nosize" />
          </td>
          </form>
        </tr>
      </table>
    </DIV>
  </body>
</HTML>
