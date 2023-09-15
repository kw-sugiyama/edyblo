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
	$obj2 = new basedb_CamarticleClassTblAccess;
	$obj2->conn = $obj_conn->conn;
	$obj2->jyoken["ca_deldate"] = 1;
	$obj2->jyoken["ca_cpid"] = $_POST['cg_id'];
	$obj2->sort["ca_dispno"] = 1;
	list( $num , $intTotal ) = $obj2->basedb_GetCamarticle( 1 , -1 );
	IF( $num == -1 ){
		$arrOther["ath_comment"] = "<INPUT TYPE=\"hidden\" NAME=\"stpos\" VALUE=\"{$_POST['stpos']}\">";
		$obj_error->ViewErrMessage( "SYSTEM" , "ALL" , SITE_PATH."blank.php" , $arrOther );
		exit;
	}


	/**************************************
	  表示値生成
	**************************************/
	// カテゴリ情報生成
	$ca_cateid = $obj2->camarticledat[$i]['ca_cateid'];
	$obj_cate = new basedb_CategoryClassTblAccess;
	$obj_cate->conn = $obj_conn->conn;
	$obj_cate->jyoken["cg_deldate"] = 1;
	$obj_cate->jyoken["cg_stat"] = 1;
	$obj_cate->jyoken["cg_type"] = 6;
	$obj_cate->jyoken["cg_clid"] = $_SESSION['_cl_id'];
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
		if($category_id == $ca_cateid && $ca_cateid!="")$cg_select = "selected";
		$cateValue .= "<OPTION VALUE=\"{$category_id}\" {$cg_select}>{$category_name}</OPTION>";
	}
	$ca_new_form = "";
	$ca_new_form .= "        <img src=\"../share/images/camarticle_new_button.gif\" alt=\"こちらをクリックすると展開表示できます\" width=\"100\" height=\"20\" title=\"詳細条件検索で絞り込む\" />\n";
	$ca_new_form .= "        <div class=\"js_close\">\n";
	$ca_new_form .= "          <DIV id=１\"title\">■入塾までの流れ記事新規登録</DIV>\n";
	$ca_new_form .= "      <br>\n";
	$ca_new_form .= "        <table border=\"0\" style=\"border:solid thin\" rules=\"none\">\n";
	$ca_new_form .= "        <TR>\n";
	$ca_new_form .= "          <TD class=\"td_cl\" style=\"width:350px\">状態</TD>\n";
	$ca_new_form .= "          <TD class=\"td_cl\" style=\"width:200px\">カテゴリ</TD>\n";
	$ca_new_form .= "          <TD class=\"td_cl\" style=\"width:100px\">&nbsp;</TD>\n";
	$ca_new_form .= "          <TD class=\"td_cl\" style=\"width:100px\">&nbsp;</TD>\n";
	$ca_new_form .= "        </TR>\n";
	$ca_new_form .= "        <TR>\n";
	$ca_new_form .= "          <TD class=\"td_cl\" style=\"width:350px\" rowspan=\"2\">画像</TD>\n";
	$ca_new_form .= "          <TD class=\"td_cl\" style=\"width:300px\">タイトル</TD>\n";
	$ca_new_form .= "          <TD class=\"td_cl\" style=\"width:100px\">表示順</TD>\n";
	$ca_new_form .= "        </TR>\n";
	$ca_new_form .= "          <TD colspan=\"3\" class=\"td_cl\" style=\"width:400px\">コンテンツ</TD>\n";
	$ca_new_form .= "        <TR>\n";
	$ca_new_form .= "        </TR>\n";
	$ca_new_form .= "        </table>\n";
	$ca_new_form .= "      <table border=\"0\" style=\"border:solid thin\" rules=\"none\">\n";
	$ca_new_form .= "      <TR>\n";
	$ca_new_form .= "        <FORM method=\"POST\" action=\"camarticle_upd.php\" target=\"_self\" name=\"editForm\" id=\"editForm\" enctype=\"multipart/form-data\">\n";
	$ca_new_form .= "        <TD class=\"td_cm\" style=\"width:250\"><input type=\"radio\" name=\"ca_stat\" value=\"1\" {$ca_statFlg1}>表示<input type=\"radio\" name=\"ca_stat\" value=\"9\" {$ca_statFlg2}>非表示</TD>\n";
	$ca_new_form .= "        <TD class=\"td_cm\"style=\"width:200\"><select name=\"ca_cateid\">\n";
	$ca_new_form .= "        <option value-\"\">----</option>\n";
	$ca_new_form .= "        {$cateValue}\n";
	$ca_new_form .= "        </TD>\n";
	$ca_new_form .= "        <TD class=\"td_cm\" align=\"right\" style=\"width:100\"><INPUT type=\"button\" name=\"go_mnt_2\" value=\"新規作成\" class=\"btn_camarticle\" onclick=\"return CamarticleInputCheck( this.form , this.form )\"/></TD>\n";
	$ca_new_form .= "        <TD class=\"td_cm\" align=\"right\" style=\"width:100\"><input type=\"reset\" value=\"クリア\" class=\"btn_camarticle\" ></TD>\n";
	$ca_new_form .= "      </TR>\n";
	$ca_new_form .= "      <TR>\n";
	$ca_new_form .= "        <TD class=\"td_cm\" style=\"width:350px;vertical-align:top;\" rowspan=\"2\"><input type=\"file\" name=\"ca_img\"\"></TD>\n";
	$ca_new_form .= "        <TD class=\"td_cm\" style=\"width:300\"><input type=\"text\" name=\"ca_title\" value=\"{$ca_title}\" style=\"width:300px\"></TD>\n";
	$ca_new_form .= "        <TD class=\"td_cm\" style=\"width:100\"><input type=\"text\" name=\"ca_dispno\" value=\"{$ca_dispno}\" style=\"width:100px\"></TD>\n";
	$ca_new_form .= "      </TR>\n";
	$ca_new_form .= "      <TR>\n";
	$ca_new_form .= "        <TD class=\"td_cm\" colspan=\"3\" style=\"width:400;align:center\"><textarea name=\"ca_contents\" rows=\"12\" cols=\"53\">{$ca_contents}</textarea></TD>\n";
	$ca_new_form .= "        <INPUT type=\"hidden\" name=\"mode\" value=\"NEW\" />\n";
	$ca_new_form .= "        <INPUT type=\"hidden\" name=\"ca_clid\" value=\"{$_SESSION['_cl_id']}\" />\n";
	$ca_new_form .= "      </TR>\n";
	$ca_new_form .= "        </FORM>\n";
	$ca_new_form .= "      </TR>\n";
	$ca_new_form .= "      </table>\n";
	$ca_new_form .= "      </div>\n";

	$ca_new_form = "";
	$ca_new_form .= "        <img src=\"../share/images/camarticle_new_button.gif\" alt=\"こちらをクリックすると展開表示できます\" width=\"100\" height=\"20\" title=\"詳細条件検索で絞り込む\" />\n";
	$ca_new_form .= "        <div class=\"js_close\">\n";
//	$ca_new_form .= "          <DIV id=\"title\">■入塾までの流れ記事</DIV>\n";
//	$ca_new_form .= "      <br>\n";
	$ca_new_form .= "      <table border=\"0\" style=\"border:solid thin\" rules=\"none\">\n";
	$ca_new_form .= "        <TR>\n";
	$ca_new_form .= "          <TD class=\"td_camarticle_new\" style=\"width:350px\">状態</TD>\n";
	$ca_new_form .= "          <TD class=\"td_camarticle_new\" style=\"width:400px\" colspan=\"2\">&nbsp;</TD>\n";
	$ca_new_form .= "        </TR>\n";
	$ca_new_form .= "      <TR>\n";
	$ca_new_form .= "        <FORM method=\"POST\" action=\"camarticle_upd.php\" target=\"_self\" name=\"editForm\" id=\"editForm\" enctype=\"multipart/form-data\">\n";
	$ca_new_form .= "        <TD class=\"td_cm\" style=\"width:250\"><input type=\"radio\" name=\"ca_stat\" value=\"1\" {$ca_statFlg1}>表示<input type=\"radio\" name=\"ca_stat\" value=\"9\" {$ca_statFlg2}>非表示</TD>\n";
	$ca_new_form .= "        <TD class=\"td_cm\" align=\"right\" style=\"width:400;text-align:right;\" colspan=\"2\"><INPUT type=\"button\" name=\"go_mnt_2\" value=\"新規作成\" class=\"btn_camarticle\" onclick=\"return CamarticleInputCheck( this.form , this.form )\"/><input type=\"reset\" value=\"クリア\" class=\"btn_camarticle\" ></TD>\n";
	$ca_new_form .= "      </TR>\n";
	$ca_new_form .= "        <TR>\n";
	$ca_new_form .= "          <TD class=\"td_camarticle_new\" style=\"width:350px\">画像</TD>\n";
	$ca_new_form .= "          <TD class=\"td_camarticle_new\" style=\"width:300px\">タイトル</TD>\n";
	$ca_new_form .= "          <TD class=\"td_camarticle_new\" style=\"width:100px\">表示順</TD>\n";
	$ca_new_form .= "        </TR>\n";
	$ca_new_form .= "      <TR>\n";
	$ca_new_form .= "        <TD class=\"td_cm\" style=\"width:350px;vertical-align:top;\" rowspan=\"3\"><input type=\"file\" name=\"ca_img\"\"></TD>\n";
	$ca_new_form .= "        <TD class=\"td_cm\" style=\"width:300\"><input type=\"text\" name=\"ca_title\" value=\"{$ca_title}\" style=\"width:300px\"></TD>\n";
	$ca_new_form .= "        <TD class=\"td_cm\" style=\"width:100\"><input type=\"text\" name=\"ca_dispno\" value=\"{$ca_dispno}\" style=\"width:100px\"></TD>\n";
	$ca_new_form .= "      </TR>\n";
	$ca_new_form .= "        <TR>\n";
	$ca_new_form .= "          <TD colspan=\"2\" class=\"td_camarticle_new\" style=\"width:400px\">コンテンツ</TD>\n";
	$ca_new_form .= "        </TR>\n";
	$ca_new_form .= "      <TR>\n";
	$ca_new_form .= "        <TD class=\"td_cm\" colspan=\"3\" style=\"width:400;align:center\"><textarea name=\"ca_contents\" rows=\"12\" cols=\"53\">{$ca_contents}</textarea></TD>\n";
	$ca_new_form .= "        <INPUT type=\"hidden\" name=\"mode\" value=\"NEW\" />\n";
	$ca_new_form .= "        <INPUT type=\"hidden\" name=\"cg_id\" value=\"{$_POST['cg_id']}\" />\n";
	$ca_new_form .= "        <INPUT type=\"hidden\" name=\"ca_clid\" value=\"{$_SESSION['_cl_id']}\" />\n";
	$ca_new_form .= "        <INPUT type=\"hidden\" name=\"ca_cpid\" value=\"{$_POST['cp_id']}\" />\n";
	$ca_new_form .= "      </TR>\n";
	$ca_new_form .= "        </FORM>\n";
	$ca_new_form .= "      </TR>\n";
	$ca_new_form .= "      </table>\n";
	$ca_new_form .= "      </div>\n";

	$ca_list_title = "";
	$ca_list_title .= "        <table border=\"0\" style=\"border:solid thin\" rules=\"none\">\n";
	$ca_list_title .= "        <TR>\n";
	$ca_list_title .= "          <TD class=\"td_cl\" style=\"width:350px\">状態</TD>\n";
	$ca_list_title .= "          <TD class=\"td_cl\" style=\"width:400px\" colspan=\"2\">&nbsp;</TD>\n";
	$ca_list_title .= "        </TR>\n";
	$ca_list_title .= "        <TR>\n";
	$ca_list_title .= "          <TD class=\"td_cl\" style=\"width:350px\" rowspan=\"2\">画像</TD>\n";
	$ca_list_title .= "          <TD class=\"td_cl\" style=\"width:300px\">タイトル</TD>\n";
	$ca_list_title .= "          <TD class=\"td_cl\" style=\"width:100px\">表示順</TD>\n";
	$ca_list_title .= "        </TR>\n";
	$ca_list_title .= "        <TR>\n";
	$ca_list_title .= "          <TD colspan=\"2\" class=\"td_cl\" style=\"width:400px\">コンテンツ</TD>\n";
	$ca_list_title .= "        </TR>\n";

	if($intTotal==0){
		$ca_list_title .= "      <TR>\n";
		$ca_list_title .= "        <TD class=\"td_cm\" colspan=\"4\" style=\"width:750\"><br>記事は登録されておりません。<br><br></TD>\n";
		$ca_list_title .= "      </TR>\n";
	}

	$ca_list_title .= "        </table>\n";


	for($i=0;$i<$intTotal;$i++){
		$ca_id = $obj2->camarticledat[$i]['ca_id'];
		$ca_clid = $obj2->camarticledat[$i]['ca_clid'];

		// 状態情報生成
		$ca_statFlg1 = "";
		$ca_statFlg2 = "";
		$dispnoClr = "";
		$ca_stat = $obj2->camarticledat[$i]['ca_stat'];
		if($ca_stat == 1){
			$ca_statFlg1 = " checked";
		}else{
			$ca_statFlg2 = " checked";
			$dispnoClr = "background-color:#999999;";
		}

		// カテゴリ情報生成
		$cateValue = "";
		$ca_cateid = $obj2->camarticledat[$i]['ca_cateid'];
		$obj_cate = new basedb_CategoryClassTblAccess;
		$obj_cate->conn = $obj_conn->conn;
		$obj_cate->jyoken["cg_deldate"] = 1;
		$obj_cate->jyoken["cg_stat"] = 1;
		$obj_cate->jyoken["cg_type"] = 6;
		$obj_cate->jyoken["cg_clid"] = $_SESSION['_cl_id'];
		$obj_cate->sort["cg_dispno"] = 2;
		list( $intCntCate2 , $intTotalCate2 ) = $obj_cate->basedb_GetCategory( 1 , -1 );
		IF( $intCntCate2 == -1 ){
			$arrOther["ath_comment"] = "<INPUT TYPE=\"hidden\" NAME=\"stpos\" VALUE=\"{$_POST['stpos']}\">";
			$obj_error->ViewErrMessage( "SYSTEM" , "ALL" , SITE_PATH."blank.php" , $arrOther );
			exit;
		}
		for($iY=0;$iY<$intCntCate;$iY++){
			$cg_select ="";
			$category_name ="";
			$category_id ="";
			$category_name = $obj_cate->categorydat[$iY]["cg_stitle"];
			$category_id = $obj_cate->categorydat[$iY]["cg_id"];
			if($category_id == $ca_cateid && $ca_cateid!="")$cg_select = "selected";
			$cateValue .= "<OPTION VALUE=\"{$category_id}\" {$cg_select}>{$category_name}</OPTION>";
		}

		$ca_title = $obj2->camarticledat[$i]['ca_title'];
		$ca_img = $obj2->camarticledat[$i]['ca_img'];
		$ca_imgorg = $obj2->camarticledat[$i]['ca_imgorg'];
		$ca_contents = $obj2->camarticledat[$i]['ca_contents'];
		$ca_dispno = $obj2->camarticledat[$i]['ca_dispno'];
		$ca_adminid = $obj2->camarticledat[$i]['ca_adminid'];
		$ca_insdate = $obj2->camarticledat[$i]['ca_insdate'];
		$ca_upddate = $obj2->camarticledat[$i]['ca_upddate'];
		$ca_deldate = $obj2->camarticledat[$i]['ca_deldate'];

		// 画像
		$ca_img_dir = $param_camarticle_img_path;
		$ca_img_arr["org"] = $ca_imgorg;
		$ca_img_arr["chk_in"] = "1";
		$ca_img_arr["width"] = "150";
		$ca_img_arr["height"] = "150";
		$ca_img_txt =  form_ImgDisp( "ca_img" , $ca_img_dir , $obj2->camarticledat[$i]["ca_img"] , "3" , $ca_img_arr );

		$viewData .= "      <table border=\"0\" style=\"border:solid thin\" rules=\"none\">\n";
		$viewData .= "      <TR>\n";
		$viewData .= "        <FORM method=\"POST\" action=\"camarticle_upd.php\" target=\"_self\" name=\"editForm{$i}\" id=\"editForm{$i}\" enctype=\"multipart/form-data\">\n";
		$viewData .= "        <TD class=\"td_cm\" style=\"width:350\"><input type=\"radio\" name=\"ca_stat\" value=\"1\" {$ca_statFlg1}>表示<input type=\"radio\" name=\"ca_stat\" value=\"9\" {$ca_statFlg2}>非表示</TD>\n";
		$viewData .= "        <TD class=\"td_cm\" align=\"right\" style=\"width:400;text-align:right;\" colspan=\"2\"><INPUT type=\"button\" name=\"go_mnt_2\" value=\"修正\" class=\"btn\"  onclick=\"return CamarticleInputCheck( this.form , this.form )\"/><INPUT type=\"button\" value=\"削除\" class=\"btn\" onclick=\"document.del_camarticle{$i}.submit();return false;\"/></TD>\n";
		$viewData .= "      </TR>\n";
		$viewData .= "      <TR>\n";
		$viewData .= "        <TD class=\"td_cm\" style=\"width:350px;vertical-align:top;\" rowspan=\"2\">{$ca_img_txt}</TD>\n";
//		$viewData .= "        <TD class=\"td_cm\" style=\"width:350px\"><input type=\"file\" name=\"ca_img\"></TD>\n";
		$viewData .= "        <TD class=\"td_cm\" style=\"width:300;text-align:right;\"><input type=\"text\" name=\"ca_title\" value=\"{$ca_title}\" style=\"width:300px\"></TD>\n";
		$viewData .= "        <TD class=\"td_cm\" style=\"width:100\"><input type=\"text\" name=\"ca_dispno\" value=\"{$ca_dispno}\" style=\"width:100px;{$dispnoClr}\"></TD>\n";
		$viewData .= "      </TR>\n";
		$viewData .= "        <TD class=\"td_cm\" colspan=\"2\" style=\"width:400;align:center\"><textarea name=\"ca_contents\" rows=\"12\" cols=\"53\">{$ca_contents}</textarea></TD>\n";
		$viewData .= "      <TR>\n";
		$viewData .= "        <INPUT type=\"hidden\" name=\"mode\" value=\"EDIT\" />\n";
		$viewData .= "        <INPUT type=\"hidden\" name=\"ca_clid\" value=\"{$_SESSION['_cl_id']}\" />\n";
		$viewData .= "       <INPUT type=\"hidden\" name=\"cg_id\" value=\"{$_POST['cg_id']}\" />\n";
		$viewData .= "       <INPUT type=\"hidden\" name=\"ca_id\" value=\"{$ca_id}\" />\n";
		$viewData .= "       <INPUT type=\"hidden\" name=\"ca_cpid\" value=\"{$_POST['cp_id']}\" />\n";
		$viewData .= "       <INPUT type=\"hidden\" name=\"ca_upddate\" value=\"{$ca_upddate}\" />\n";
		$viewData .= "        <INPUT type=\"hidden\" name=\"ca_img_lastupd\" value=\"{$ca_img}\" />\n";
		$viewData .= "      </TR>\n";
		$viewData .= "        </FORM>\n";
		$viewData .= "      </TR>\n";
		$viewData .= "      </table>\n";

		$viewData2 .= "<FORM name=\"del_camarticle{$i}\" action=\"camarticle_upd.php\" method=\"POST\">\n";

		$viewData2 .= "       <INPUT type=\"hidden\" name=\"ca_cpid\" value=\"{$_POST['cp_id']}\" />\n";
		$viewData2 .= "<INPUT type=\"hidden\" name=\"mode\" value=\"DEL\" />\n";
		$viewData2 .= "<INPUT type=\"hidden\" name=\"ca_upddate\" value=\"{$ca_upddate}\" />\n";
		$viewData2 .= "<INPUT type=\"hidden\" name=\"ca_id\" value=\"{$ca_id}\" />\n";
		$viewData2 .= "<INPUT type=\"hidden\" name=\"cg_id\" value=\"{$_POST['cg_id']}\" />\n";

		$viewData2 .= "</FORM>\n";
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
    <SCRIPT type="text/javascript" src="../share/js/camarticle.js"></SCRIPT>
    <SCRIPT type="text/javascript" src="../share/js/input_check.js"></SCRIPT>
    <SCRIPT type="text/javascript" src="../share/js/more.js"></SCRIPT>
    <NOSCRIPT><META http-equiv="Refresh" content="1;URL=../jserror.html"></NOSCRIPT>
  </HEAD>
  <BODY>
    <TABLE>
      <TR>
        <TD><IMG src="../share/images/camarticle_title.gif" alt="講習・イベント自由記事登録" /></TD>
        <FORM ACTION="camarticle_select.php" METHOD="POST">
        <TD>
          <?=$ca_title_img?>
        </TD>
        </FORM>
        <FORM ACTION="camarticle_main.php" METHOD="POST">
        <TD>
          <input type="hidden" name="cp_id" value="<?=$_POST['cp_id']?>">
          <input type="submit" value="講習・イベント自由記事 小見出し登録へ戻る" style="width:300px;" class="btn">
        </TD>
        </FORM>
      </TR>
    </TABLE>
    <HR color="#96BC69" />
    <DIV id="title2">■講習・イベント自由記事登録</DIV>
<?=$ca_list_title?>
<?=$viewData?>
<br>
<?=$ca_new_form?>
<br><br>
<?=$viewData2?>

    <BR />
  </BODY>
</HTML>
