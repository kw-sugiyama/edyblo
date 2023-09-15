<?
/******************************************************************************
<< 不動産ブログ　Ver.1.O.0 >>
	Name: category_main.php
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
require_once ( SYS_PATH."dbif/basedb_CamarticleClass.php" );
require_once ( SYS_PATH."dbif/basedb_SchoolClass.php" );
require_once ( SYS_PATH."dbif/basedb_CategoryClass.php" );
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
	$obj_cate = new basedb_CamarticleClassTblAccess;
	$obj_cate->conn = $obj_conn->conn;
	$obj_cate->jyoken["cg_deldate"] = 1;
	$obj_cate->jyoken["cg_cpid"] = $_POST['cp_id'];
	$obj_cate->sort["cg_dispno"] = 1;
	list( $num , $intTotal ) = $obj_cate->basedb_GetCamarticle( 1 , -1 );
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
	$cg_cateid = $obj_cate->categorydat[$i]['cg_cateid'];
	$obj_cate = new basedb_CategoryClassTblAccess;
	$obj_cate->conn = $obj_conn->conn;
	$obj_cate->jyoken["cg_deldate"] = 1;
	$obj_cate->jyoken["cg_type"] = 8;
	$obj_cate->jyoken["cg_clid"] = $_POST['cp_id'];
	$obj_cate->sort["cg_dispno"] = 2;
	list( $intCntCate , $intTotalCate ) = $obj_cate->basedb_GetCategory( 1 , -1 );
	IF( $intCntCate == -1 ){
		$arrOther["ath_comment"] = "<INPUT TYPE=\"hidden\" NAME=\"stpos\" VALUE=\"{$_POST['stpos']}\">";
		$obj_error->ViewErrMessage( "SYSTEM" , "ALL" , SITE_PATH."blank.php" , $arrOther );
		exit;
	}
	$cateValue = "";
	for($iY=0;$iY<$intCntCate;$iY++){
		$cg_select ="";
		$category_name ="";
		$category_id ="";
		$category_name = $obj_cate->categorydat[$iY]["cg_stitle"];
		$category_id = $obj_cate->categorydat[$iY]["cg_id"];
		if($category_id == $cg_cateid && $cg_cateid!="")$cg_select = "selected";
		$cateValue .= "<OPTION VALUE=\"{$category_id}\" {$cg_select}>{$category_name}</OPTION>";
	}
	$cg_new_form = "";
//	$cg_new_form .= "        <img src=\"../share/images/camarticle_new_button.gif\" alt=\"こちらをクリックすると展開表示できます\" width=\"100\" height=\"20\" title=\"詳細条件検索で絞り込む\" />\n";
//	$cg_new_form .= "        <div class=\"js_close\">\n";
//	$cg_new_form .= "          <DIV id=\"title\">■キャンペーン自由記事用カテゴリ</DIV>\n";
//	$cg_new_form .= "      <br>\n";
	$cg_new_form .= "      <table border=\"0\" style=\"border:solid thin\" rules=\"none\">\n";
	$cg_new_form .= "        <TR>\n";
	$cg_new_form .= "          <TD class=\"td_camarticle_new\" style=\"width:120px\">状態</TD>\n";
	$cg_new_form .= "          <TD class=\"td_camarticle_new\" style=\"width:300px\">講習・イベント自由記事 小見出し</TD>\n";
	$cg_new_form .= "          <TD class=\"td_camarticle_new\" style=\"width:100px\">表示順</TD>\n";
	$cg_new_form .= "          <TD class=\"td_camarticle_new\" style=\"width:300px\">&nbsp;</TD>\n";
	$cg_new_form .= "        </TR>\n";
	$cg_new_form .= "      <TR>\n";
	$cg_new_form .= "        <FORM method=\"POST\" action=\"camcategory_upd.php\" target=\"_self\" name=\"editForm\" id=\"editForm\" enctype=\"multipart/form-data\">\n";
	$cg_new_form .= "        <TD class=\"td_cm\" style=\"width:120\"><input type=\"radio\" name=\"cg_stat\" value=\"1\" {$cg_statFlg1}>表示<input type=\"radio\" name=\"cg_stat\" value=\"9\" {$cg_statFlg2}>非表示</TD>\n";
	$cg_new_form .= "        <TD class=\"td_cm\" style=\"width:300\"><input type=\"text\" name=\"cg_stitle\" value=\"{$cg_stitle}\" style=\"width:300px\"></TD>\n";
	$cg_new_form .= "        <TD class=\"td_cm\" style=\"width:100\"><input type=\"text\" name=\"cg_dispno\" value=\"{$cg_dispno}\" style=\"width:100px\"></TD>\n";
//	$cg_new_form .= "        <TD class=\"td_cm\" align=\"right\" style=\"width:100\"><INPUT type=\"button\" name=\"go_mnt_2\" value=\"カテゴリ登録\" class=\"btn_camarticle\" onclick=\"return CamarticleInputCheck( this.form , this.form )\"/></TD>\n";
	$cg_new_form .= "        <TD class=\"td_cm\" align=\"right\" style=\"width:300\"><INPUT type=\"button\" name=\"go_mnt_2\" value=\"小見出し登録\" class=\"btn_camarticle\" onclick=\"return CamcategoryInputCheck( this.form , this.form )\"/><input type=\"reset\" value=\"クリア\" class=\"btn_camarticle\" ></TD>\n";
//	$cg_new_form .= "        <TD class=\"td_cm\" align=\"right\" style=\"width:200\"></TD>\n";
	$cg_new_form .= "      <input type=\"hidden\" name=\"cg_type\" value=\"8\">\n";
	$cg_new_form .= "<INPUT type=\"hidden\" name=\"cp_id\" value=\"{$_POST['cp_id']}\" />\n";
	$cg_new_form .= "      <input type=\"hidden\" name=\"mode\" value=\"NEW\">\n";
	$cg_new_form .= "      </TR>\n";
	$cg_new_form .= "        </FORM>\n";
//	$cg_new_form .= "      </TR>\n";
	$cg_new_form .= "      </table>\n";
//	$cg_new_form .= "      </div>\n";

	$cg_list_title = "";
	$cg_list_title .= "        <table border=\"0\" style=\"border:solid thin\" rules=\"none\">\n";
	$cg_list_title .= "        <TR>\n";
	$cg_list_title .= "          <TD class=\"td_cl\" style=\"width:120px\">状態</TD>\n";
	$cg_list_title .= "          <TD class=\"td_cl\" style=\"width:300px\">講習・イベント自由記事 小見出し</TD>\n";
	$cg_list_title .= "          <TD class=\"td_cl\" style=\"width:100px\">表示順</TD>\n";
	$cg_list_title .= "          <TD class=\"td_cl\" style=\"width:300px\">&nbsp;</TD>\n";
	$cg_list_title .= "        </TR>\n";
	$cg_list_title .= "        </TR>\n";

	if($intTotalCate==0){
		$cg_list_title .= "      <TR>\n";
		$cg_list_title .= "        <TD class=\"td_cm\" colspan=\"4\" style=\"width:750\"><br>記事は登録されておりません。<br><br></TD>\n";
		$cg_list_title .= "      </TR>\n";
	}

	$cg_list_title .= "        </table>\n";


	for($i=0;$i<$intTotalCate;$i++){
		$cg_id = $obj_cate->categorydat[$i]['cg_id'];
		$cg_clid = $obj_cate->categorydat[$i]['cg_clid'];

		// 状態情報生成
		$cg_id = $obj_cate->categorydat[$i]['cg_id'];
		$cg_statFlg1 = "";
		$cg_statFlg2 = "";
		$dispnoClr = "";
		$cg_stat = $obj_cate->categorydat[$i]['cg_stat'];
		if($cg_stat == 1){
			$cg_statFlg1 = " checked";
		}else{
			$cg_statFlg2 = " checked";
			$dispnoClr = "background-color:#999999;";
		}
		$cg_stitle = $obj_cate->categorydat[$i]['cg_stitle'];
		$cg_img = $obj_cate->categorydat[$i]['cg_img'];
		$cg_imgorg = $obj_cate->categorydat[$i]['cg_imgorg'];
		$cg_contents = $obj_cate->categorydat[$i]['cg_contents'];
		$cg_dispno = $obj_cate->categorydat[$i]['cg_dispno'];
		$cg_adminid = $obj_cate->categorydat[$i]['cg_adminid'];
		$cg_insdate = $obj_cate->categorydat[$i]['cg_insdate'];
		$cg_upddate = $obj_cate->categorydat[$i]['cg_upddate'];
		$cg_deldate = $obj_cate->categorydat[$i]['cg_deldate'];

		// 画像
		$cg_img_dir = $param_camarticle_img_path;
		$cg_img_arr["org"] = $cg_imgorg;
		$cg_img_arr["chk_in"] = "1";
		$cg_img_arr["width"] = "150";
		$cg_img_arr["height"] = "150";
		$cg_img_txt =  form_ImgDisp( "cg_img" , $cg_img_dir , $obj_cate->categorydat[$i]["cg_img"] , "3" , $cg_img_arr );

		$viewData .= "      <table border=\"0\" style=\"border:solid thin\" rules=\"none\">\n";
		$viewData .= "      <TR>\n";
		$viewData .= "        <FORM method=\"POST\" action=\"camcategory_upd.php\" target=\"_self\" name=\"editForm{$i}\" id=\"editForm{$i}\" enctype=\"multipart/form-data\">\n";
		$viewData .= "        <TD class=\"td_cm\" style=\"width:120\"><input type=\"radio\" name=\"cg_stat\" value=\"1\" {$cg_statFlg1}>表示<input type=\"radio\" name=\"cg_stat\" value=\"9\" {$cg_statFlg2}>非表示</TD>\n";
		$viewData .= "        <TD class=\"td_cm\" style=\"width:300\"><input type=\"text\" name=\"cg_stitle\" value=\"{$cg_stitle}\" style=\"width:300px\"></TD>\n";
		$viewData .= "        <TD class=\"td_cm\" style=\"width:100\"><input type=\"text\" name=\"cg_dispno\" value=\"{$cg_dispno}\" style=\"width:100px;{$dispnoClr}\"></TD>\n";
//		$viewData .= "        <TD class=\"td_cm\" align=\"right\" style=\"width:100\"><INPUT type=\"button\" name=\"go_mnt_2\" value=\"カテゴリ修正\" class=\"btn\"  onclick=\"return CamarticleInputCheck( this.form , this.form )\"/></TD>\n";
		$viewData .= "        <TD class=\"td_cm\" align=\"right\" style=\"width:300\" colspan=\"3\"><INPUT type=\"button\" name=\"go_mnt_2\" value=\"小見出し修正\" class=\"btn\" onclick=\"return CamcategoryInputCheck( this.form , this.form )\"/><INPUT type=\"button\" value=\"削除\" class=\"btn\" onclick=\"document.del_camarticle{$i}.submit();return false;\"/><INPUT type=\"button\" value=\"自由記事\" class=\"btn\" onclick=\"document.article_camarticle{$i}.submit();return false;\"/></TD>\n";
//		$viewData .= "        <TD class=\"td_cm\" align=\"right\" style=\"width:100\"></TD>\n";
//		$viewData .= "        <TD class=\"td_cm\" align=\"right\" style=\"width:100\"></TD>\n";
		$viewData .= "      <input type=\"hidden\" name=\"cg_type\" value=\"8\">\n";
		$viewData .= "<INPUT type=\"hidden\" name=\"cg_id\" value=\"{$cg_id}\" />\n";
		$viewData .= "<INPUT type=\"hidden\" name=\"cp_id\" value=\"{$_POST['cp_id']}\" />\n";
		$viewData .= "<INPUT type=\"hidden\" name=\"cg_upddate\" value=\"{$cg_upddate}\" />\n";
		$viewData .= "      <input type=\"hidden\" name=\"mode\" value=\"EDIT\">\n";
		$viewData .= "      </TR>\n";
		$viewData .= "        </FORM>\n";
//		$viewData .= "      </TR>\n";
		$viewData .= "      </table>\n";

		$viewData2 .= "<FORM name=\"article_camarticle{$i}\" action=\"camarticle_mnt.php\" method=\"POST\">\n";

		$viewData2 .= "<INPUT type=\"hidden\" name=\"cp_id\" value=\"{$_POST['cp_id']}\" />\n";
		$viewData2 .= "      <input type=\"hidden\" name=\"cg_id\" value=\"{$cg_id}\">\n";
		$viewData2 .= "      <input type=\"hidden\" name=\"cg_type\" value=\"8\">\n";
		$viewData2 .= "      <input type=\"hidden\" name=\"mode\" value=\"EDIT\">\n";

		$viewData2 .= "</FORM>\n";

		$viewData3 .= "<FORM name=\"del_camarticle{$i}\" action=\"camcategory_upd.php\" method=\"POST\">\n";

		$viewData3 .= "<INPUT type=\"hidden\" name=\"cp_id\" value=\"{$_POST['cp_id']}\" />\n";
		$viewData3 .= "      <input type=\"hidden\" name=\"cg_id\" value=\"{$cg_id}\">\n";
		$viewData3 .= "      <input type=\"hidden\" name=\"cg_type\" value=\"8\">\n";
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
    <TITLE>塾ブログ - クライアントツール</TITLE>
    <META http-equiv="Content-Type" content="text/html;charset=EUC-JP" />
    <META http-equiv="Content-Style-Type" content="text/css" />
    <META http-equiv="Content-Script-Type" content="text/javascript" />
    <LINK rel="stylesheet" type="text/css" href="../share/css/camarticle.css" />
    <SCRIPT type="text/javascript" src="../share/js/Camcategory.js"></SCRIPT>
    <SCRIPT type="text/javascript" src="../share/js/input_check.js"></SCRIPT>
    <SCRIPT type="text/javascript" src="../share/js/more.js"></SCRIPT>
    <NOSCRIPT><META http-equiv="Refresh" content="1;URL=../jserror.html"></NOSCRIPT>
  </HEAD>
  <BODY>
    <TABLE>
      <TR>
        <TD><IMG src="../share/images/campain_small_title.gif" alt="講習・イベント自由記事 小見出し登録" /></TD>
        <FORM ACTION="camarticle_select.php" METHOD="POST">
        <TD>
          <?=$cg_stitle_img?>
        </TD>
        </FORM>
        <FORM ACTION="../campain/campain_main.php" METHOD="POST">
        <TD>
          <input type="submit" value="講習・イベント自由記事見出し一覧へ戻る" style="width:300px;" class="btn">
          <input type="hidden" name="stpos" value="<?=$_POST['stpos']?>">        </TD>
        </FORM>
      </TR>
    </TABLE>
    <HR color="#96BC69" />
    <DIV id="title2">■講習・イベント自由記事 小見出し登録</DIV>
<br>
<?=$cg_new_form?>
<br><br>
<?=$cg_list_title?>
<?=$viewData?>
<?=$viewData2?>
<?=$viewData3?>

    <BR />
  </BODY>
</HTML>
