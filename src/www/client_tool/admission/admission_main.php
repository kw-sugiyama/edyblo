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
require_once ( SYS_PATH."dbif/basedb_AdmissionClass.php" );
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
	$obj2 = new basedb_AdmissionClassTblAccess;
	$obj2->conn = $obj_conn->conn;
	$obj2->jyoken["as_deldate"] = 1;
	$obj2->jyoken["as_clid"] = $_SESSION['_cl_id'];
	$obj2->jyoken["as_cgid"] = $_POST['cg_id'];
	$obj2->sort["as_cgid"] = 1;
	list( $num , $intTotal ) = $obj2->basedb_GetAdmission( 1 , -1 );
	IF( $nmu == -1 ){
		$arrOther["ath_comment"] = "<INPUT TYPE=\"hidden\" NAME=\"stpos\" VALUE=\"{$_POST['stpos']}\">";
		$obj_error->ViewErrMessage( "SYSTEM" , "ALL" , SITE_PATH."blank.php" , $arrOther );
		exit;
	}


	/**************************************
	  表示値生成
	**************************************/
	// カテゴリ情報生成
	$as_cgid = $obj2->admissiondat[$i]['as_cgid'];
	$obj_cate = new basedb_CategoryClassTblAccess;
	$obj_cate->conn = $obj_conn->conn;
	$obj_cate->jyoken["cg_deldate"] = 1;
	$obj_cate->jyoken["cg_stat"] = 1;
	$obj_cate->jyoken["cg_type"] = 2;
	$obj_cate->jyoken["cg_clid"] = $_SESSION['_cl_id'];
	$obj_cate->sort["cg_dispno"] = 2;
	list( $intCntCate , $intTotalCate ) = $obj_cate->basedb_GetCategory( 1 , -1 );
	IF( $intCnt == -1 ){
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
		if($category_id == $as_cgid && $as_cgid!="")$cg_select = "selected";
		$cateValue .= "<OPTION VALUE=\"{$category_id}\" {$cg_select}>{$category_name}</OPTION>";
	}

	$as_new_form = "";
	$as_new_form .= "        <img src=\"../share/images/admission_new_button.gif\" alt=\"こちらをクリックすると展開表示できます\" width=\"100\" height=\"20\" title=\"詳細条件検索で絞り込む\" />\n";
	$as_new_form .= "        <div class=\"js_close\">\n";
	$as_new_form .= "          <DIV id=１\"title\">■入塾までの流れ記事新規登録</DIV>\n";
	$as_new_form .= "      <br>\n";
	$as_new_form .= "        <table border=\"0\" style=\"border:solid thin\" rules=\"none\">\n";
	$as_new_form .= "        <TR>\n";
	$as_new_form .= "          <TD class=\"td_cl\" style=\"width:350px\">状態</TD>\n";
	$as_new_form .= "          <TD class=\"td_cl\" style=\"width:200px\">&nbsp;</TD>\n";
	$as_new_form .= "          <TD class=\"td_cl\" style=\"width:100px\">&nbsp;</TD>\n";
	$as_new_form .= "          <TD class=\"td_cl\" style=\"width:100px\">&nbsp;</TD>\n";
	$as_new_form .= "        </TR>\n";
	$as_new_form .= "        <TR>\n";
	$as_new_form .= "          <TD class=\"td_cl\" style=\"width:350px\" rowspan=\"2\">画像</TD>\n";
	$as_new_form .= "          <TD class=\"td_cl\" style=\"width:300px\" colspan=\"2\">タイトル</TD>\n";
	$as_new_form .= "          <TD class=\"td_cl\" style=\"width:100px\">表示順</TD>\n";
	$as_new_form .= "        </TR>\n";
	$as_new_form .= "          <TD colspan=\"3\" class=\"td_cl\" style=\"width:400px\">コンテンツ</TD>\n";
	$as_new_form .= "        <TR>\n";
	$as_new_form .= "        </TR>\n";
	$as_new_form .= "        </table>\n";
	$as_new_form .= "      <table border=\"0\" style=\"border:solid thin\" rules=\"none\">\n";
	$as_new_form .= "      <TR>\n";
	$as_new_form .= "        <FORM method=\"POST\" action=\"admission_upd.php\" target=\"_self\" name=\"editForm\" id=\"editForm\" enctype=\"multipart/form-data\">\n";
	$as_new_form .= "        <TD class=\"td_cm\" style=\"width:250\"><input type=\"radio\" name=\"as_stat\" value=\"1\" {$as_statFlg1}>表示<input type=\"radio\" name=\"as_stat\" value=\"9\" {$as_statFlg2}>非表示</TD>\n";
	$as_new_form .= "        <TD class=\"td_cm\"style=\"width:200\"><select name=\"as_cgid\">\n";
	$as_new_form .= "        <option value-\"\">----</option>\n";
	$as_new_form .= "        {$cateValue}\n";
	$as_new_form .= "        </TD>\n";
	$as_new_form .= "        <TD class=\"td_cm\" align=\"right\" style=\"width:100\"><INPUT type=\"submit\" name=\"go_mnt_2\" value=\"新規作成\" class=\"btn_admission\" onclick=\"return AdmissionInputCheck( this.form , this.form )\"/></TD>\n";
	$as_new_form .= "        <TD class=\"td_cm\" align=\"right\" style=\"width:100\"><input type=\"reset\" value=\"クリア\" class=\"btn_admission\" ></TD>\n";
	$as_new_form .= "      </TR>\n";
	$as_new_form .= "      <TR>\n";
	$as_new_form .= "        <TD class=\"td_cm\" style=\"width:350px;vertical-align:top;\" rowspan=\"2\"><input type=\"file\" name=\"as_img\"\"></TD>\n";
	$as_new_form .= "        <TD class=\"td_cm\" style=\"width:300\" colspan=\"2\"><input type=\"text\" name=\"as_title\" value=\"{$as_title}\" style=\"width:300px\"></TD>\n";
	$as_new_form .= "        <TD class=\"td_cm\" style=\"width:100\"><input type=\"text\" name=\"as_dispno\" value=\"{$as_dispno}\" style=\"width:100px\"></TD>\n";
	$as_new_form .= "      </TR>\n";
	$as_new_form .= "      <TR>\n";
	$as_new_form .= "        <TD class=\"td_cm\" colspan=\"3\" style=\"width:400;align:center\"><textarea name=\"as_contents\" rows=\"12\" cols=\"53\">{$as_contents}</textarea></TD>\n";
	$as_new_form .= "        <INPUT type=\"hidden\" name=\"mode\" value=\"NEW\" />\n";
	$as_new_form .= "        <INPUT type=\"hidden\" name=\"as_clid\" value=\"{$_SESSION['_cl_id']}\" />\n";
	$as_new_form .= "      </TR>\n";
	$as_new_form .= "        </FORM>\n";
	$as_new_form .= "      </TR>\n";
	$as_new_form .= "      </table>\n";
	$as_new_form .= "      </div>\n";

	$as_new_form = "";
	$as_new_form .= "        <img src=\"../share/images/admission_new_button.gif\" alt=\"こちらをクリックすると展開表示できます\" width=\"100\" height=\"20\" title=\"新規登録\" />\n";
	$as_new_form .= "        <div class=\"js_close\">\n";
//	$as_new_form .= "          <DIV id=\"title\">■入塾までの流れ記事</DIV>\n";
//	$as_new_form .= "      <br>\n";
	$as_new_form .= "      <table border=\"0\" style=\"border:solid thin\" rules=\"none\">\n";
	$as_new_form .= "        <TR>\n";
	$as_new_form .= "          <TD class=\"td_admission_new\" style=\"width:350px\">状態</TD>\n";
	$as_new_form .= "          <TD class=\"td_admission_new\" style=\"width:200px\">&nbsp;</TD>\n";
	$as_new_form .= "          <TD class=\"td_admission_new\" style=\"width:200px\" colspan=\"2\">&nbsp;</TD>\n";
	$as_new_form .= "        </TR>\n";
	$as_new_form .= "      <TR>\n";
	$as_new_form .= "        <FORM method=\"POST\" action=\"admission_upd.php\" target=\"_self\" name=\"editForm\" id=\"editForm\" enctype=\"multipart/form-data\">\n";
	$as_new_form .= "        <TD class=\"td_cm\" style=\"width:250\"><input type=\"radio\" name=\"as_stat\" value=\"1\" {$as_statFlg1}>表示<input type=\"radio\" name=\"as_stat\" value=\"9\" {$as_statFlg2}>非表示</TD>\n";
	$as_new_form .= "        <TD class=\"td_cm\"style=\"width:200\">\n";
	$as_new_form .= "       <INPUT type=\"hidden\" name=\"as_cgid\" value=\"{$_POST['cg_id']}\" />\n";

//	$as_new_form .= "        <select name=\"as_cgid\">\n";
//	$as_new_form .= "        <option value-\"\">----</option>\n";
//	$as_new_form .= "        {$cateValue}\n";

	$as_new_form .= "        </TD>\n";
	$as_new_form .= "        <TD class=\"td_cm\" align=\"right\" style=\"width:100\"><INPUT type=\"button\" name=\"go_mnt_2\" value=\"新規作成\" class=\"btn_admission\" onclick=\"return AdmissionInputCheck( this.form , this.form )\"/></TD>\n";
	$as_new_form .= "        <TD class=\"td_cm\" align=\"right\" style=\"width:100\"><input type=\"reset\" value=\"クリア\" class=\"btn_admission\" ></TD>\n";
	$as_new_form .= "      </TR>\n";
	$as_new_form .= "        <TR>\n";
	$as_new_form .= "          <TD class=\"td_admission_new\" style=\"width:350px\">画像</TD>\n";
	$as_new_form .= "          <TD class=\"td_admission_new\" style=\"width:300px\" colspan=\"2\">タイトル</TD>\n";
	$as_new_form .= "          <TD class=\"td_admission_new\" style=\"width:100px\">表示順</TD>\n";
	$as_new_form .= "        </TR>\n";
	$as_new_form .= "      <TR>\n";
	$as_new_form .= "        <TD class=\"td_cm\" style=\"width:350px;vertical-align:top;\" rowspan=\"3\"><input type=\"file\" name=\"as_img\"\"></TD>\n";
	$as_new_form .= "        <TD class=\"td_cm\" style=\"width:300\" colspan=\"2\"><input type=\"text\" name=\"as_title\" value=\"{$as_title}\" style=\"width:300px\"></TD>\n";
	$as_new_form .= "        <TD class=\"td_cm\" style=\"width:100\"><input type=\"text\" name=\"as_dispno\" value=\"{$as_dispno}\" style=\"width:100px\"></TD>\n";
	$as_new_form .= "      </TR>\n";
	$as_new_form .= "        <TR>\n";
	$as_new_form .= "          <TD colspan=\"3\" class=\"td_admission_new\" style=\"width:400px\">コンテンツ</TD>\n";
	$as_new_form .= "        </TR>\n";
	$as_new_form .= "      <TR>\n";
	$as_new_form .= "        <TD class=\"td_cm\" colspan=\"3\" style=\"width:400;align:center\"><textarea name=\"as_contents\" rows=\"12\" cols=\"53\">{$as_contents}</textarea></TD>\n";
	$as_new_form .= "        <INPUT type=\"hidden\" name=\"mode\" value=\"NEW\" />\n";
	$as_new_form .= "        <INPUT type=\"hidden\" name=\"as_clid\" value=\"{$_SESSION['_cl_id']}\" />\n";
	$as_new_form .= "      </TR>\n";
	$as_new_form .= "        </FORM>\n";
	$as_new_form .= "      </TR>\n";
	$as_new_form .= "      </table>\n";
	$as_new_form .= "      </div>\n";

	$as_list_title = "";
	$as_list_title .= "        <table border=\"0\" style=\"border:solid thin\" rules=\"none\">\n";
	$as_list_title .= "        <TR>\n";
	$as_list_title .= "          <TD class=\"td_cl\" style=\"width:350px\">状態</TD>\n";
	$as_list_title .= "          <TD class=\"td_cl\" style=\"width:200px\">&nbsp;</TD>\n";
	$as_list_title .= "          <TD class=\"td_cl\" style=\"width:100px\">&nbsp;</TD>\n";
	$as_list_title .= "          <TD class=\"td_cl\" style=\"width:100px\">&nbsp;</TD>\n";
	$as_list_title .= "        </TR>\n";
	$as_list_title .= "        <TR>\n";
	$as_list_title .= "          <TD class=\"td_cl\" style=\"width:350px\" rowspan=\"2\">画像</TD>\n";
	$as_list_title .= "          <TD class=\"td_cl\" style=\"width:300px\" colspan=\"2\">タイトル</TD>\n";
	$as_list_title .= "          <TD class=\"td_cl\" style=\"width:100px\">表示順</TD>\n";
	$as_list_title .= "        </TR>\n";
	$as_list_title .= "        <TR>\n";
	$as_list_title .= "          <TD colspan=\"3\" class=\"td_cl\" style=\"width:400px\">コンテンツ</TD>\n";
	$as_list_title .= "        </TR>\n";

	if($intTotal==0){
		$as_list_title .= "      <TR>\n";
		$as_list_title .= "        <TD class=\"td_cm\" colspan=\"4\" style=\"width:750\"><br>記事は登録されておりません。<br><br></TD>\n";
		$as_list_title .= "      </TR>\n";
	}

	$as_list_title .= "        </table>\n";


	for($i=0;$i<$intTotal;$i++){
		$as_id = $obj2->admissiondat[$i]['as_id'];
		$as_clid = $obj2->admissiondat[$i]['as_clid'];

		// 状態情報生成
		$as_statFlg1 = "";
		$as_statFlg2 = "";
		$dispnoClr = "";
		$as_stat = $obj2->admissiondat[$i]['as_stat'];
		if($as_stat == 1){
			$as_statFlg1 = " checked";
		}else{
			$as_statFlg2 = " checked";
			$dispnoClr = "background-color:#999999;";
		}

		// カテゴリ情報生成
		$cateValue = "";
		$as_cgid = $obj2->admissiondat[$i]['as_cgid'];
		$obj_cate = new basedb_CategoryClassTblAccess;
		$obj_cate->conn = $obj_conn->conn;
		$obj_cate->jyoken["cg_deldate"] = 1;
		$obj_cate->jyoken["cg_stat"] = 1;
		$obj_cate->jyoken["cg_type"] = 2;
		$obj_cate->jyoken["cg_clid"] = $_SESSION['_cl_id'];
		$obj_cate->sort["cg_dispno"] = 2;
		list( $intCntCate , $intTotalCate ) = $obj_cate->basedb_GetCategory( 1 , -1 );
		IF( $intCnt == -1 ){
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
			if($category_id == $as_cgid && $as_cgid!="")$cg_select = "selected";
			$cateValue .= "<OPTION VALUE=\"{$category_id}\" {$cg_select}>{$category_name}</OPTION>";
		}

		$as_title = $obj2->admissiondat[$i]['as_title'];
		$as_img = $obj2->admissiondat[$i]['as_img'];
		$as_imgorg = $obj2->admissiondat[$i]['as_imgorg'];
		$as_contents = $obj2->admissiondat[$i]['as_contents'];
		$as_dispno = $obj2->admissiondat[$i]['as_dispno'];
		$as_adminid = $obj2->admissiondat[$i]['as_adminid'];
		$as_insdate = $obj2->admissiondat[$i]['as_insdate'];
		$as_upddate = $obj2->admissiondat[$i]['as_upddate'];
		$as_deldate = $obj2->admissiondat[$i]['as_deldate'];

		// 画像
		$as_img_dir = $param_admission_img_path;
		$as_img_arr["org"] = $as_imgorg;
		$as_img_arr["chk_in"] = "1";
		$as_img_arr["width"] = "150";
		$as_img_arr["height"] = "150";
		$as_img_txt =  form_ImgDisp( "as_img" , $as_img_dir , $obj2->admissiondat[$i]["as_img"] , "3" , $as_img_arr );

		$viewData .= "      <table border=\"0\" style=\"border:solid thin\" rules=\"none\">\n";
		$viewData .= "      <TR>\n";
		$viewData .= "        <FORM method=\"POST\" action=\"admission_upd.php\" target=\"_self\" name=\"editForm{$i}\" id=\"editForm{$i}\" enctype=\"multipart/form-data\">\n";
		$viewData .= "        <TD class=\"td_cm\" style=\"width:350\"><input type=\"radio\" name=\"as_stat\" value=\"1\" {$as_statFlg1}>表示<input type=\"radio\" name=\"as_stat\" value=\"9\" {$as_statFlg2}>非表示</TD>\n";
		$viewData .= "        <TD class=\"td_cm\"style=\"width:200\">\n";
		$viewData .= "       <INPUT type=\"hidden\" name=\"as_cgid\" value=\"{$_POST['cg_id']}\" />\n";

//		$viewData .= "        <select name=\"as_cgid\">\n";
//		$viewData .= "        <option value-\"\">----</option>\n";
//		$viewData .= "        {$cateValue}\n";

		$viewData .= "        </TD>\n";
		$viewData .= "        <TD class=\"td_cm\" align=\"right\" style=\"width:100\"><INPUT type=\"button\" name=\"go_mnt_2\" value=\"修正\" class=\"btn\"  onclick=\"return AdmissionInputCheck( this.form , this.form )\"/></TD>\n";
		$viewData .= "        <TD class=\"td_cm\" align=\"right\" style=\"width:100\"><INPUT type=\"button\" value=\"削除\" class=\"btn\" onclick=\"document.del_admission{$i}.submit();return false;\"/></TD>\n";
		$viewData .= "      </TR>\n";
		$viewData .= "      <TR>\n";
		$viewData .= "        <TD class=\"td_cm\" style=\"width:350px;vertical-align:top;\" rowspan=\"2\">{$as_img_txt}</TD>\n";
//		$viewData .= "        <TD class=\"td_cm\" style=\"width:350px\"><input type=\"file\" name=\"as_img\"></TD>\n";
		$viewData .= "        <TD class=\"td_cm\" style=\"width:300\" colspan=\"2\"><input type=\"text\" name=\"as_title\" value=\"{$as_title}\" style=\"width:300px\"></TD>\n";
		$viewData .= "        <TD class=\"td_cm\" style=\"width:100\"><input type=\"text\" name=\"as_dispno\" value=\"{$as_dispno}\" style=\"width:100px;{$dispnoClr}\"></TD>\n";
		$viewData .= "      </TR>\n";
		$viewData .= "        <TD class=\"td_cm\" colspan=\"3\" style=\"width:400;align:center\"><textarea name=\"as_contents\" rows=\"12\" cols=\"53\">{$as_contents}</textarea></TD>\n";
		$viewData .= "      <TR>\n";
		$viewData .= "        <INPUT type=\"hidden\" name=\"mode\" value=\"EDIT\" />\n";
		$viewData .= "        <INPUT type=\"hidden\" name=\"as_clid\" value=\"{$_SESSION['_cl_id']}\" />\n";
		$viewData .= "       <INPUT type=\"hidden\" name=\"as_id\" value=\"{$as_id}\" />\n";
		$viewData .= "       <INPUT type=\"hidden\" name=\"as_upddate\" value=\"{$as_upddate}\" />\n";
		$viewData .= "        <INPUT type=\"hidden\" name=\"as_img_lastupd\" value=\"{$as_img}\" />\n";
		$viewData .= "      </TR>\n";
		$viewData .= "        </FORM>\n";
		$viewData .= "      </TR>\n";
		$viewData .= "      </table>\n";

		$viewData2 .= "<FORM name=\"del_admission{$i}\" action=\"admission_upd.php\" method=\"POST\">\n";

		$viewData2 .= "<INPUT type=\"hidden\" name=\"mode\" value=\"DEL\" />\n";
		$viewData2 .= "<INPUT type=\"hidden\" name=\"as_upddate\" value=\"{$as_upddate}\" />\n";
		$viewData2 .= "<INPUT type=\"hidden\" name=\"as_cgid\" value=\"{$_POST['cg_id']}\" />\n";
		$viewData2 .= "<INPUT type=\"hidden\" name=\"as_id\" value=\"{$as_id}\" />\n";

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
    <LINK rel="stylesheet" type="text/css" href="../share/css/admission.css" />
    <SCRIPT type="text/javascript" src="../share/js/admission.js"></SCRIPT>
    <SCRIPT type="text/javascript" src="../share/js/input_check.js"></SCRIPT>
    <SCRIPT type="text/javascript" src="../share/js/more.js"></SCRIPT>
    <NOSCRIPT><META http-equiv="Refresh" content="1;URL=../jserror.html"></NOSCRIPT>
  </HEAD>
  <BODY>
    <TABLE>
      <TR>
        <TD><IMG src="../share/images/admission_title.gif" alt="入塾の流れ自由記事情報登録" /></TD>
        <FORM ACTION="../category/category_main.php" METHOD="POST">
        <TD>
          <input type="hidden" name="stpos" value="<?=$_POST['stpos']?>">
          <INPUT type="hidden" name="cg_type" value="2" />
          <input type="submit" value="入塾の流れ情報用カテゴリ一覧へ戻る" style="width:300px;" class="btn">
        </TD>
        </FORM>
      </TR>
    </TABLE>
    <HR color="#96BC69" />
    <DIV id="title2">■入塾の流れ自由記事情報</DIV>
<?=$as_list_title?>
<?=$viewData?>
<?=$viewData2?>
<br>
<?=$as_new_form?>
<br><br>

    <BR />
  </BODY>
</HTML>
