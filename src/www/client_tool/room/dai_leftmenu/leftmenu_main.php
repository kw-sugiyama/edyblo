<?
/******************************************************************************
<< 不動産ブログ　Ver.1.O.0 >>
	Name: leftmenu_main.php
	Version: 1.0.0
	Function: 管理者一覧
	Author: Click inc
	Date of creation: 2007/02
	History of modification:

	Copyright (C)2007 Click, inc. All Rights Reserverd.
******************************************************************************/

/*----------------------------------------------------------
  必要ファイル呼び出し
----------------------------------------------------------*/
require_once ( "../ini_sets_2.php" );
//require_once ( "../img_thumbnail.php" );
require_once ( SYS_PATH."dbif/dbcom_DBconnectClass.php" );
require_once ( SYS_PATH."dbif/basedb_ClientClass.php" );
require_once ( SYS_PATH."dbif/basedb_LeftmenuClass.php" );
require_once ( SYS_PATH."dbif/basedb_SchoolClass.php" );
require_once ( SYS_PATH."dbif/basedb_LeftmenuClass.php" );
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
	/**************************************
	  教室基本情報検索
	**************************************/
/*
	$obj_cate = new basedb_LeftmenuClassTblAccess;
	$obj_cate->conn = $obj_conn->conn;
	$obj_cate->jyoken["lm_deldate"] = 1;
	$obj_cate->jyoken["lm_cpid"] = $_POST['cp_id'];
	$obj_cate->sort["lm_dispno"] = 1;
	list( $num , $intTotal ) = $obj_cate->basedb_GetLeftmenu( 1 , -1 );
	IF( $num == -1 ){
		$arrOther["ath_comment"] = "<INPUT TYPE=\"hidden\" NAME=\"stpos\" VALUE=\"{$_POST['stpos']}\">";
		$obj_error->ViewErrMessage( "SYSTEM" , "ALL" , SITE_PATH."blank.php" , $arrOther );
		exit;
	}
*/

	/**************************************
	  表示値生成
	**************************************/
	// カテゴリ情報生成
	$obj_cate_campain = new basedb_LeftmenuClassTblAccess;
	$obj_cate_campain->conn = $obj_conn->conn;
	$obj_cate_campain->jyoken["lm_deldate"] = 1;
	$obj_cate_campain->jyoken["lm_type"] = 2;
	$obj_cate_campain->jyoken["lm_clid"] = $_POST['cs_id'];
	$obj_cate_campain->sort["lm_dispno"] = 2;
	list( $intCntCate , $intTotalCate ) = $obj_cate_campain->basedb_GetLeftmenu( 1 , -1 );
	IF( $intCntCate == -1 ){
		$arrOther["ath_comment"] = "<INPUT TYPE=\"hidden\" NAME=\"stpos\" VALUE=\"{$_POST['stpos']}\">";
		$obj_error->ViewErrMessage( "SYSTEM" , "ALL" , SITE_PATH."blank.php" , $arrOther );
		exit;
	}
	/**************************************
	  表示値生成
	**************************************/
	// カテゴリ情報生成
	$obj_cate_blog = new basedb_LeftmenuClassTblAccess;
	$obj_cate_blog->conn = $obj_conn->conn;
	$obj_cate_blog->jyoken["lm_deldate"] = 1;
	$obj_cate_blog->jyoken["lm_type"] = 3;
	$obj_cate_blog->jyoken["lm_clid"] = $_POST['cs_id'];
	$obj_cate_blog->sort["lm_dispno"] = 2;
	list( $intCntCate , $intTotalCate ) = $obj_cate_blog->basedb_GetLeftmenu( 1 , -1 );
	IF( $intCntCate == -1 ){
		$arrOther["ath_comment"] = "<INPUT TYPE=\"hidden\" NAME=\"stpos\" VALUE=\"{$_POST['stpos']}\">";
		$obj_error->ViewErrMessage( "SYSTEM" , "ALL" , SITE_PATH."blank.php" , $arrOther );
		exit;
	}
	/**************************************
	  表示値生成
	**************************************/
	// カテゴリ情報生成
	$obj_cate_menu = new basedb_LeftmenuClassTblAccess;
	$obj_cate_menu->conn = $obj_conn->conn;
	$obj_cate_menu->jyoken["lm_deldate"] = 1;
	$obj_cate_menu->jyoken["lm_type"] = 4;
	$obj_cate_menu->jyoken["lm_clid"] = $_POST['cs_id'];
	$obj_cate_menu->sort["lm_dispno"] = 2;
	list( $intCntCate , $intTotalCate ) = $obj_cate_menu->basedb_GetLeftmenu( 1 , -1 );
	IF( $intCntCate == -1 ){
		$arrOther["ath_comment"] = "<INPUT TYPE=\"hidden\" NAME=\"stpos\" VALUE=\"{$_POST['stpos']}\">";
		$obj_error->ViewErrMessage( "SYSTEM" , "ALL" , SITE_PATH."blank.php" , $arrOther );
		exit;
	}
	/**************************************
	  表示値生成
	**************************************/
	// カテゴリ情報生成
	$obj_cate = new basedb_LeftmenuClassTblAccess;
	$obj_cate->conn = $obj_conn->conn;
	$obj_cate->jyoken["lm_deldate"] = 1;
	$obj_cate->jyoken["lm_type"] = 1;
	$obj_cate->jyoken["lm_clid"] = $_POST['cs_id'];
	$obj_cate->sort["lm_dispno"] = 2;
	list( $intCntCate , $intTotalCate ) = $obj_cate->basedb_GetLeftmenu( 1 , -1 );
	IF( $intCntCate == -1 ){
		$arrOther["ath_comment"] = "<INPUT TYPE=\"hidden\" NAME=\"stpos\" VALUE=\"{$_POST['stpos']}\">";
		$obj_error->ViewErrMessage( "SYSTEM" , "ALL" , SITE_PATH."blank.php" , $arrOther );
		exit;
	}
	$cateValue = "";
	for($iY=0;$iY<$intCntCate;$iY++){
		$lm_select ="";
		$leftmenu_name ="";
		$leftmenu_id ="";
		$leftmenu_name = $obj_cate->leftmenudat[$iY]["lm_title"];
		$leftmenu_name = $obj_cate->leftmenudat[$iY]["lm_title"];
		$leftmenu_id = $obj_cate->leftmenudat[$iY]["lm_id"];
		if($leftmenu_id == $lm_cateid && $lm_cateid!="")$lm_select = "selected";
		$cateValue .= "<OPTION VALUE=\"{$leftmenu_id}\" {$lm_select}>{$leftmenu_name}</OPTION>";
	}
	$lm_new_form = "";
//	$lm_new_form .= "        <img src=\"../share/images/leftmenu_new_button.gif\" alt=\"こちらをクリックすると展開表示できます\" width=\"100\" height=\"20\" title=\"詳細条件検索で絞り込む\" />\n";
//	$lm_new_form .= "        <div class=\"js_close\">\n";
//	$lm_new_form .= "          <DIV id=\"title\">■キャンペーンカテゴリ登録用カテゴリ</DIV>\n";
//	$lm_new_form .= "      <br>\n";
	$lm_new_form .= "      <table border=\"0\" style=\"border:solid thin\" rules=\"none\">\n";
	$lm_new_form .= "        <TR>\n";
	$lm_new_form .= "          <TD class=\"td_leftmenu_new\" style=\"width:200px\">状態</TD>\n";
	$lm_new_form .= "          <TD class=\"td_leftmenu_new\" style=\"width:300px\">コース用カテゴリタイトル</TD>\n";
	$lm_new_form .= "          <TD class=\"td_leftmenu_new\" style=\"width:100px\">表示順</TD>\n";
	$lm_new_form .= "          <TD class=\"td_leftmenu_new\" style=\"width:300px\">&nbsp;</TD>\n";
	$lm_new_form .= "        </TR>\n";
	$lm_new_form .= "      <TR>\n";
	$lm_new_form .= "        <FORM method=\"POST\" action=\"leftmenu_upd.php\" target=\"_self\" name=\"editForm\" id=\"editForm\" enctype=\"multipart/form-data\">\n";
	$lm_new_form .= "          <TD class=\"td_cm\" style=\"width:200\"><input type=\"radio\" name=\"lm_stat\" value=\"1\" {$lm_statFlg1}>表示<input type=\"radio\" name=\"lm_stat\" value=\"9\" {$lm_statFlg2}>非表示</TD>\n";
	$lm_new_form .= "          <TD class=\"td_cm\" style=\"width:300\"><input type=\"text\" name=\"lm_title\" value=\"{$lm_title}\" style=\"width:300px\"></TD>\n";
	$lm_new_form .= "          <TD class=\"td_cm\" style=\"width:100\"><input type=\"text\" name=\"lm_dispno\" value=\"{$lm_dispno}\" style=\"width:100px\"></TD>\n";
//	$lm_new_form .= "          <TD class=\"td_cm\" align=\"right\" style=\"width:100\"><INPUT type=\"button\" name=\"go_mnt_2\" value=\"カテゴリ登録\" class=\"btn_leftmenu\" onclick=\"return leftmenuInputCheck( this.form , this.form )\"/></TD>\n";
	$lm_new_form .= "          <TD class=\"td_cm\" align=\"right\" style=\"width:300\"><INPUT type=\"submit\" name=\"go_mnt_2\" value=\"カテゴリ登録\" class=\"btn_leftmenu\"/><input type=\"reset\" value=\"クリア\" class=\"btn_leftmenu\" ></TD>\n";
//	$lm_new_form .= "          <TD class=\"td_cm\" align=\"right\" style=\"width:200\"></TD>\n";
	$lm_new_form .= "      <input type=\"hidden\" name=\"lm_type\" value=\"1\">\n";
	$lm_new_form .= "      <input type=\"hidden\" name=\"cs_id\" value=\"{$_POST['cs_id']}\">\n";
	$lm_new_form .= "<INPUT type=\"hidden\" name=\"cp_id\" value=\"{$_POST['cp_id']}\" />\n";
	$lm_new_form .= "      <input type=\"hidden\" name=\"mode\" value=\"NEW\">\n";
	$lm_new_form .= "      </TR>\n";
	$lm_new_form .= "        </FORM>\n";
//	$lm_new_form .= "      </TR>\n";
	$lm_new_form .= "      </table>\n";
//	$lm_new_form .= "      </div>\n";

	$lm_list_title = "";
	$lm_list_title .= "        <table border=\"0\" style=\"border:solid thin\" rules=\"none\">\n";
	$lm_list_title .= "        <TR>\n";
	$lm_list_title .= "          <TD class=\"td_cl\" style=\"width:200px\">状態</TD>\n";
	$lm_list_title .= "          <TD class=\"td_cl\" style=\"width:300px\">コース用カテゴリタイトル</TD>\n";
	$lm_list_title .= "          <TD class=\"td_cl\" style=\"width:100px\">表示順</TD>\n";
	$lm_list_title .= "          <TD class=\"td_cl\" style=\"width:300px\">&nbsp;</TD>\n";
	$lm_list_title .= "        </TR>\n";
	$lm_list_title .= "        </TR>\n";

	if($intTotalCate==0){
		$lm_list_title .= "      <TR>\n";
		$lm_list_title .= "        <TD class=\"td_cm\" colspan=\"4\" style=\"width:750\"><br>記事は登録されておりません。<br><br></TD>\n";
		$lm_list_title .= "      </TR>\n";
	}

	$lm_list_title .= "        </table>\n";


	for($i=0;$i<$intTotalCate;$i++){
		$lm_id = $obj_cate->leftmenudat[$i]['lm_id'];
		$lm_clid = $obj_cate->leftmenudat[$i]['lm_clid'];

		// 状態情報生成
		$lm_id = $obj_cate->leftmenudat[$i]['lm_id'];
		$lm_statFlg1 = "";
		$lm_statFlg2 = "";
		$dispnoClr = "";
		$lm_stat = $obj_cate->leftmenudat[$i]['lm_stat'];
		if($lm_stat == 1){
			$lm_statFlg1 = " checked";
		}else{
			$lm_statFlg2 = " checked";
			$dispnoClr = "background-color:#999999;";
		}
		$lm_title = $obj_cate->leftmenudat[$i]['lm_title'];
		$lm_img = $obj_cate->leftmenudat[$i]['lm_img'];
		$lm_imgorg = $obj_cate->leftmenudat[$i]['lm_imgorg'];
		$lm_contents = $obj_cate->leftmenudat[$i]['lm_contents'];
		$lm_dispno = $obj_cate->leftmenudat[$i]['lm_dispno'];
		$lm_adminid = $obj_cate->leftmenudat[$i]['lm_adminid'];
		$lm_insdate = $obj_cate->leftmenudat[$i]['lm_insdate'];
		$lm_upddate = $obj_cate->leftmenudat[$i]['lm_upddate'];
		$lm_deldate = $obj_cate->leftmenudat[$i]['lm_deldate'];

		// 画像
		$lm_img_dir = $param_leftmenu_img_path;
		$lm_img_arr["org"] = $lm_imgorg;
		$lm_img_arr["chk_in"] = "1";
		$lm_img_arr["width"] = "150";
		$lm_img_arr["height"] = "150";
		$lm_img_txt =  form_ImgDisp( "lm_img" , $lm_img_dir , $obj_cate->leftmenudat[$i]["lm_img"] , "3" , $lm_img_arr );

		$viewData .= "      <table border=\"0\" style=\"border:solid thin\" rules=\"none\">\n";
		$viewData .= "      <TR>\n";
		$viewData .= "        <FORM method=\"POST\" action=\"leftmenu_upd.php\" target=\"_self\" name=\"editForm{$i}\" id=\"editForm{$i}\" enctype=\"multipart/form-data\">\n";
		$viewData .= "          <TD class=\"td_cm\" style=\"width:200\"><input type=\"radio\" name=\"lm_stat\" value=\"1\" {$lm_statFlg1}>表示<input type=\"radio\" name=\"lm_stat\" value=\"9\" {$lm_statFlg2}>非表示</TD>\n";
		$viewData .= "          <TD class=\"td_cm\" style=\"width:300\"><input type=\"text\" name=\"lm_title\" value=\"{$lm_title}\" style=\"width:300px\"></TD>\n";
		$viewData .= "          <TD class=\"td_cm\" style=\"width:100\"><input type=\"text\" name=\"lm_dispno\" value=\"{$lm_dispno}\" style=\"width:100px;{$dispnoClr}\"></TD>\n";
//		$viewData .= "          <TD class=\"td_cm\" align=\"right\" style=\"width:100\"><INPUT type=\"button\" name=\"go_mnt_2\" value=\"カテゴリ修正\" class=\"btn\"  onclick=\"return leftmenuInputCheck( this.form , this.form )\"/></TD>\n";
		$viewData .= "          <TD class=\"td_cm\" align=\"right\" style=\"width:300\" colspan=\"3\"><INPUT type=\"submit\" name=\"go_mnt_2\" value=\"カテゴリ修正\" class=\"btn\"/><INPUT type=\"button\" value=\"削除\" class=\"btn\" onclick=\"document.del_leftmenu{$i}.submit();return false;\"/><INPUT type=\"button\" value=\"カテゴリ登録\" class=\"btn\" onclick=\"document.article_leftmenu{$i}.submit();return false;\"/></TD>\n";
//		$viewData .= "          <TD class=\"td_cm\" align=\"right\" style=\"width:100\"></TD>\n";
//		$viewData .= "          <TD class=\"td_cm\" align=\"right\" style=\"width:100\"></TD>\n";
		$viewData .= "      <input type=\"hidden\" name=\"lm_type\" value=\"1\">\n";
		$viewData .= "<INPUT type=\"hidden\" name=\"lm_id\" value=\"{$lm_id}\" />\n";
		$viewData .= "      <input type=\"hidden\" name=\"cs_id\" value=\"{$_POST['cs_id']}\">\n";
		$viewData .= "<INPUT type=\"hidden\" name=\"cp_id\" value=\"{$_POST['cp_id']}\" />\n";
		$viewData .= "<INPUT type=\"hidden\" name=\"lm_upddate\" value=\"{$lm_upddate}\" />\n";
		$viewData .= "      <input type=\"hidden\" name=\"mode\" value=\"EDIT\">\n";
		$viewData .= "      </TR>\n";
		$viewData .= "        </FORM>\n";
//		$viewData .= "      </TR>\n";
		$viewData .= "      </table>\n";

		$viewData2 .= "<FORM name=\"article_leftmenu{$i}\" action=\"../shou_leftmenu/category_main.php\" method=\"POST\">\n";

		$viewData2 .= "<INPUT type=\"hidden\" name=\"cp_id\" value=\"{$_POST['cp_id']}\" />\n";
		$viewData2 .= "<INPUT type=\"hidden\" name=\"lm_id\" value=\"{$lm_id}\" />\n";
		$viewData2 .= "      <input type=\"hidden\" name=\"cs_id\" value=\"{$_POST['cs_id']}\">\n";
		$viewData2 .= "      <input type=\"hidden\" name=\"lm_id\" value=\"{$lm_id}\">\n";
		$viewData2 .= "      <input type=\"hidden\" name=\"lm_type\" value=\"1\">\n";
		$viewData2 .= "      <input type=\"hidden\" name=\"cg_type\" value=\"3\">\n";
		$viewData2 .= "      <input type=\"hidden\" name=\"mode\" value=\"EDIT\">\n";

		$viewData2 .= "</FORM>\n";

		$viewData3 .= "<FORM name=\"del_leftmenu{$i}\" action=\"leftmenu_upd.php\" method=\"POST\">\n";

		$viewData3 .= "<INPUT type=\"hidden\" name=\"cp_id\" value=\"{$_POST['cp_id']}\" />\n";
		$viewData3 .= "      <input type=\"hidden\" name=\"cs_id\" value=\"{$_POST['cs_id']}\">\n";
		$viewData3 .= "      <input type=\"hidden\" name=\"lm_id\" value=\"{$lm_id}\">\n";
		$viewData3 .= "      <input type=\"hidden\" name=\"lm_type\" value=\"1\">\n";
		$viewData3 .= "      <input type=\"hidden\" name=\"mode\" value=\"DEL\">\n";

		$viewData3 .= "</FORM>\n";
	}


/*----------------------------------------------------------
  ＤＢ切断
----------------------------------------------------------*/
require_once( SYS_PATH."common/db_close.php" );


/*----------------------------------------------------------
  ＨＴＭＬ生成
----------------------------------------------------------*/
?>
<HTML>
  <HEAD>
    <TITLE>不動産ブログ - クライアントツール</TITLE>
    <META http-equiv="Content-Type" content="text/html;charset=EUC-JP" />
    <META http-equiv="Content-Style-Type" content="text/css" />
    <META http-equiv="Content-Script-Type" content="text/javascript" />
    <LINK rel="stylesheet" type="text/css" href="../share/css/Leftmenu.css" />
    <LINK rel="stylesheet" type="text/css" href="../share/css/campain.css" />
    <SCRIPT type="text/javascript" src="../share/js/Leftmenu.js"></SCRIPT>
    <SCRIPT type="text/javascript" src="../share/js/input_check.js"></SCRIPT>
    <SCRIPT type="text/javascript" src="../share/js/more.js"></SCRIPT>
    <NOSCRIPT><META http-equiv="Refresh" content="1;URL=../jserror.html"></NOSCRIPT>
  </HEAD>
  <BODY>
    <TABLE>
      <TR>
        <TD><IMG src="../share/images/leftmenu_title.gif" alt="入塾までの流れ記事情報登録" /></TD>
        <FORM ACTION="leftmenu_select.php" METHOD="POST">
        <TD>
          <?=$lm_title_img?>
        </TD>
        </FORM>
      </TR>
    </TABLE>
    <HR color="#96BC69" />
    <DIV id="title">■コース見出し登録</DIV>
<br>
<?=$lm_new_form?>
<br><br>
<?=$lm_list_title?>
<?=$viewData?>
<?=$viewData2?>
<?=$viewData3?>

    <BR />
    <DIV id="title">■キャンペーン・ブログ・基本メニュー見出し登録</DIV>
<div id="campain">
<br>
  <table id="client" cellspacing="0">
    <tr>
      <th>キャンペーン見出し</th>
        <FORM method="POST" action="leftmenu_upd.php" target="_self" name="editFormcam" id="editFormcam" enctype="multipart/form-data">
      <td>
        <input type="text" name="lm_title" value="<?=$obj_cate_campain->leftmenudat[0]['lm_title']?>" style="width:300px">
        <input type="hidden" name="lm_dispno" value="1">
        <input type="hidden" name="lm_type" value="2">
        <input type="hidden" name="mode" value="EDIT">
        <input type="hidden" name="lm_stat" value="<?=$obj_cate_campain->leftmenudat[0]['lm_stat']?>">
        <input type="hidden" name="lm_id" value="<?=$obj_cate_campain->leftmenudat[0]['lm_id']?>">
        <input type="hidden" name="lm_upddate" value="<?=$obj_cate_campain->leftmenudat[0]['lm_upddate']?>">
        <input type="submit" value="反映" class="btn">
        <INPUT type="button" value="カテゴリ登録" class="btn" onclick="document.editFormcam2.submit();return false;"/>
      </td>
        </form>
        <FORM method="POST" action="../shou_leftmenu/category_main.php" target="_self" name="editFormcam2" id="editFormcam2" enctype="multipart/form-data">
      <td>
        <input type="hidden" name="cs_id" value="<?=$_POST['cs_id']?>">
        <input type="hidden" name="lm_id" value="<?=$obj_cate_campain->leftmenudat[0]['lm_id']?>">
        <input type="hidden" name="lm_type" value="1">
        <input type="hidden" name="cg_type" value="6">
        <input type="hidden" name="mode" value="EDIT">
      </td>
        </form>
    </tr>
    <tr>
      <th>ブログ見出し</th>
        <FORM method="POST" action="leftmenu_upd.php" target="_self" name="editFormblog" id="editFormblog" enctype="multipart/form-data">
      <td>
        <input type="text" name="lm_title" value="<?=$obj_cate_blog->leftmenudat[0]['lm_title']?>" style="width:300px">
        <input type="hidden" name="lm_dispno" value="1">
        <input type="hidden" name="lm_type" value="3">
        <input type="hidden" name="lm_stat" value="<?=$obj_cate_blog->leftmenudat[0]['lm_stat']?>">
        <input type="hidden" name="mode" value="EDIT">
        <input type="hidden" name="lm_id" value="<?=$obj_cate_blog->leftmenudat[0]['lm_id']?>">
        <input type="hidden" name="lm_upddate" value="<?=$obj_cate_blog->leftmenudat[0]['lm_upddate']?>">
        <input type="submit" value="反映" class="btn">
        <INPUT type="button" value="カテゴリ登録" class="btn" onclick="document.editFormblog2.submit();return false;"/>
      </td>
        </form>
        <FORM method="POST" action="../shou_leftmenu/category_main.php" target="_self" name="editFormblog2" id="editFormblog2" enctype="multipart/form-data">
      <td>
        <input type="hidden" name="cs_id" value="<?=$_POST['cs_id']?>">
        <input type="hidden" name="lm_id" value="<?=$obj_cate_blog->leftmenudat[0]['lm_id']?>">
        <input type="hidden" name="lm_type" value="1">
        <input type="hidden" name="cg_type" value="5">
        <input type="hidden" name="mode" value="EDIT">
      </td>
        </form>
    </tr>
    <tr>
      <th>基本メニュ−見出し</th>
        <FORM method="POST" action="leftmenu_upd.php" target="_self" name="editFormmenu" id="editFormmenu" enctype="multipart/form-data">
      <td>
        <input type="text" name="lm_title" value="<?=$obj_cate_menu->leftmenudat[0]['lm_title']?>" style="width:300px">
        <input type="hidden" name="lm_dispno" value="1">
        <input type="hidden" name="lm_type" value="4">
        <input type="hidden" name="lm_stat" value="<?=$obj_cate_menu->leftmenudat[0]['lm_stat']?>">
        <input type="hidden" name="mode" value="EDIT">
        <input type="hidden" name="lm_id" value="<?=$obj_cate_menu->leftmenudat[0]['lm_id']?>">
        <input type="hidden" name="lm_upddate" value="<?=$obj_cate_menu->leftmenudat[0]['lm_upddate']?>">
        <input type="submit" value="反映" class="btn">
        <INPUT type="button" value="カテゴリ登録" class="btn" onclick="document.editFormmenu2.submit();return false;"/>
      </td>
        </form>
        <FORM method="POST" action="../menu/menu_main.php" target="_self" name="editFormmenu2" id="editFormmenu2" enctype="multipart/form-data">
      <td>
        <input type="hidden" name="cs_id" value="<?=$_POST['cs_id']?>">
        <input type="hidden" name="lm_id" value="<?=$obj_cate_menu->leftmenudat[0]['lm_id']?>">
        <input type="hidden" name="lm_type" value="1">
        <input type="hidden" name="cg_type" value="3">
        <input type="hidden" name="mode" value="EDIT">
      </td>
        </form>
    </tr>
  </table>
</div>
  </BODY>
</HTML>
