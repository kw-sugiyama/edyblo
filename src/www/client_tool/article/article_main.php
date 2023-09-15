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
require_once ( SYS_PATH."dbif/basedb_ArticleClass.php" );
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
	$obj2 = new basedb_ArticleClassTblAccess;
	$obj2->conn = $obj_conn->conn;
	$obj2->jyoken["ac_deldate"] = 1;
	$obj2->jyoken["ac_clid"] = $_SESSION['_cl_id'];
	$obj2->jyoken["ac_cateid"] = $_POST['cg_id'];
	$obj2->sort["ac_catedisp"] = 1;
	list( $num , $intTotal ) = $obj2->basedb_GetArticle( 1 , -1 );
	IF( $nmu == -1 ){
		$arrOther["ath_comment"] = "<INPUT TYPE=\"hidden\" NAME=\"stpos\" VALUE=\"{$_POST['stpos']}\">";
		$obj_error->ViewErrMessage( "SYSTEM" , "ALL" , SITE_PATH."blank.php" , $arrOther );
		exit;
	}


	/**************************************
	  表示値生成
	**************************************/
	// カテゴリ情報生成
	$ac_cateid = $obj2->articledat[$i]['ac_cateid'];
	$obj_cate = new basedb_CategoryClassTblAccess;
	$obj_cate->conn = $obj_conn->conn;
	$obj_cate->jyoken["cg_deldate"] = 1;
	$obj_cate->jyoken["cg_stat"] = 1;
	$obj_cate->jyoken["cg_type"] = 1;
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
		if($category_id == $ac_cateid && $ac_cateid!="")$cg_select = "selected";
		$cateValue .= "<OPTION VALUE=\"{$category_id}\" {$cg_select}>{$category_name}</OPTION>";
	}

	$ac_new_form = "";
	$ac_new_form .= "        <img src=\"../share/images/article_new_button.gif\" alt=\"こちらをクリックすると展開表示できます\" width=\"100\" height=\"20\" title=\"詳細条件検索で絞り込む\" />\n";
	$ac_new_form .= "        <div class=\"js_close\">\n";
	$ac_new_form .= "          <DIV id=１\"title\">■基本メニュー情報新規登録</DIV>\n";
	$ac_new_form .= "      <br>\n";
	$ac_new_form .= "        <table border=\"0\" style=\"border:solid thin\" rules=\"none\">\n";
	$ac_new_form .= "        <TR>\n";
	$ac_new_form .= "          <TD class=\"td_cl\" style=\"width:350px\">状態</TD>\n";
	$ac_new_form .= "          <TD class=\"td_cl\" style=\"width:200px\">&nbsp;</TD>\n";
	$ac_new_form .= "          <TD class=\"td_cl\" style=\"width:100px\">&nbsp;</TD>\n";
	$ac_new_form .= "          <TD class=\"td_cl\" style=\"width:100px\">&nbsp;</TD>\n";
	$ac_new_form .= "        </TR>\n";
	$ac_new_form .= "        <TR>\n";
	$ac_new_form .= "          <TD class=\"td_cl\" style=\"width:350px\" rowspan=\"2\">画像</TD>\n";
	$ac_new_form .= "          <TD class=\"td_cl\" style=\"width:300px\" colspan=\"2\">タイトル</TD>\n";
	$ac_new_form .= "          <TD class=\"td_cl\" style=\"width:100px\">表示順</TD>\n";
	$ac_new_form .= "        </TR>\n";
	$ac_new_form .= "          <TD colspan=\"3\" class=\"td_cl\" style=\"width:400px\">コンテンツ</TD>\n";
	$ac_new_form .= "        <TR>\n";
	$ac_new_form .= "        </TR>\n";
	$ac_new_form .= "        </table>\n";
	$ac_new_form .= "      <table border=\"0\" style=\"border:solid thin\" rules=\"none\">\n";
	$ac_new_form .= "      <TR>\n";
	$ac_new_form .= "        <FORM method=\"POST\" action=\"article_upd.php\" target=\"_self\" name=\"editForm\" id=\"editForm\" enctype=\"multipart/form-data\">\n";
	$ac_new_form .= "        <TD class=\"td_cm\" style=\"width:250\"><input type=\"radio\" name=\"ac_stat\" value=\"1\" {$ac_statFlg1}>表示<input type=\"radio\" name=\"ac_stat\" value=\"9\" {$ac_statFlg2}>非表示</TD>\n";
	$ac_new_form .= "        <TD class=\"td_cm\"style=\"width:200\"><select name=\"ac_cateid\">\n";
	$ac_new_form .= "        <option value-\"\">----</option>\n";
	$ac_new_form .= "        {$cateValue}\n";
	$ac_new_form .= "        </TD>\n";
	$ac_new_form .= "        <TD class=\"td_cm\" align=\"right\" style=\"width:100\"><INPUT type=\"button\" name=\"go_mnt_2\" value=\"新規作成\" class=\"btn_article\" onclick=\"return ArticleInputCheck( this.form , this.form )\"/></TD>\n";
	$ac_new_form .= "        <TD class=\"td_cm\" align=\"right\" style=\"width:100\"><input type=\"reset\" value=\"クリア\" class=\"btn_article\" ></TD>\n";
	$ac_new_form .= "      </TR>\n";
	$ac_new_form .= "      <TR>\n";
	$ac_new_form .= "        <TD class=\"td_cm\" style=\"width:350px;vertical-align:top;\" rowspan=\"2\"><input type=\"file\" name=\"ac_img\"\"></TD>\n";
	$ac_new_form .= "        <TD class=\"td_cm\" style=\"width:300\" colspan=\"2\"><input type=\"text\" name=\"ac_title\" value=\"{$ac_title}\" style=\"width:300px\"></TD>\n";
	$ac_new_form .= "        <TD class=\"td_cm\" style=\"width:100\"><input type=\"text\" name=\"ac_dispno\" value=\"{$ac_dispno}\" style=\"width:100px\"></TD>\n";
	$ac_new_form .= "      </TR>\n";
	$ac_new_form .= "      <TR>\n";
	$ac_new_form .= "        <TD class=\"td_cm\" colspan=\"3\" style=\"width:400;align:center\"><textarea name=\"ac_contents\" rows=\"12\" cols=\"53\">{$ac_contents}</textarea></TD>\n";
	$ac_new_form .= "        <INPUT type=\"hidden\" name=\"mode\" value=\"NEW\" />\n";
	$ac_new_form .= "        <INPUT type=\"hidden\" name=\"ac_clid\" value=\"{$_SESSION['_cl_id']}\" />\n";
	$ac_new_form .= "      </TR>\n";
	$ac_new_form .= "        </FORM>\n";
	$ac_new_form .= "      </TR>\n";
	$ac_new_form .= "      </table>\n";
	$ac_new_form .= "      </div>\n";

	$ac_new_form = "";
	$ac_new_form .= "        <img src=\"../share/images/article_new_button.gif\" alt=\"こちらをクリックすると展開表示できます\" width=\"100\" height=\"20\" title=\"新規登録\" />\n";
	$ac_new_form .= "        <div class=\"js_close\">\n";
//	$ac_new_form .= "          <DIV id=\"title\">■基本メニュー情報新規登録</DIV>\n";
//	$ac_new_form .= "      <br>\n";
	$ac_new_form .= "      <table border=\"0\" style=\"border:solid thin\" rules=\"none\">\n";
	$ac_new_form .= "        <TR>\n";
	$ac_new_form .= "          <TD class=\"td_article_new\" style=\"width:350px\">状態</TD>\n";
	$ac_new_form .= "          <TD class=\"td_article_new\" style=\"width:200px\">&nbsp;</TD>\n";
	$ac_new_form .= "          <TD class=\"td_article_new\" style=\"width:200px\" colspan=\"2\">&nbsp;</TD>\n";
	$ac_new_form .= "        </TR>\n";
	$ac_new_form .= "      <TR>\n";
	$ac_new_form .= "        <FORM method=\"POST\" action=\"article_upd.php\" target=\"_self\" name=\"editForm\" id=\"editForm\" enctype=\"multipart/form-data\">\n";
	$ac_new_form .= "        <TD class=\"td_cm\" style=\"width:250\"><input type=\"radio\" name=\"ac_stat\" value=\"1\" {$ac_statFlg1}>表示<input type=\"radio\" name=\"ac_stat\" value=\"9\" {$ac_statFlg2}>非表示</TD>\n";
	$ac_new_form .= "        <TD class=\"td_cm\"style=\"width:200\">\n";
	$ac_new_form .= "        <INPUT type=\"hidden\" name=\"ac_cateid\" value=\"{$_POST['cg_id']}\" />\n";

//	$ac_new_form .= "        <select name=\"ac_cateid\">\n";
//	$ac_new_form .= "        <option value-\"\">----</option>\n";
//	$ac_new_form .= "        {$cateValue}\n";

	$ac_new_form .= "        </TD>\n";
	$ac_new_form .= "        <TD class=\"td_cm\" align=\"right\" style=\"width:100\"><INPUT type=\"button\" name=\"go_mnt_2\" value=\"新規作成\" class=\"btn_article\" onclick=\"return ArticleInputCheck( this.form , this.form )\"/></TD>\n";
	$ac_new_form .= "        <TD class=\"td_cm\" align=\"right\" style=\"width:100\"><input type=\"reset\" value=\"クリア\" class=\"btn_article\" ></TD>\n";
	$ac_new_form .= "      </TR>\n";
	$ac_new_form .= "        <TR>\n";
	$ac_new_form .= "          <TD class=\"td_article_new\" style=\"width:350px\">画像</TD>\n";
	$ac_new_form .= "          <TD class=\"td_article_new\" style=\"width:300px\" colspan=\"2\">タイトル</TD>\n";
	$ac_new_form .= "          <TD class=\"td_article_new\" style=\"width:100px\">表示順</TD>\n";
	$ac_new_form .= "        </TR>\n";
	$ac_new_form .= "      <TR>\n";
	$ac_new_form .= "        <TD class=\"td_cm\" style=\"width:350px;vertical-align:top;\" rowspan=\"3\"><input type=\"file\" name=\"ac_img\"\"></TD>\n";
	$ac_new_form .= "        <TD class=\"td_cm\" style=\"width:300\" colspan=\"2\"><input type=\"text\" name=\"ac_title\" value=\"{$ac_title}\" style=\"width:300px\"></TD>\n";
	$ac_new_form .= "        <TD class=\"td_cm\" style=\"width:100\"><input type=\"text\" name=\"ac_dispno\" value=\"{$ac_dispno}\" style=\"width:100px\"></TD>\n";
	$ac_new_form .= "      </TR>\n";
	$ac_new_form .= "        <TR>\n";
	$ac_new_form .= "          <TD colspan=\"3\" class=\"td_article_new\" style=\"width:400px\">コンテンツ</TD>\n";
	$ac_new_form .= "        </TR>\n";
	$ac_new_form .= "      <TR>\n";
	$ac_new_form .= "        <TD class=\"td_cm\" colspan=\"3\" style=\"width:400;align:center\"><textarea name=\"ac_contents\" rows=\"12\" cols=\"53\">{$ac_contents}</textarea></TD>\n";
	$ac_new_form .= "        <INPUT type=\"hidden\" name=\"mode\" value=\"NEW\" />\n";
	$ac_new_form .= "        <INPUT type=\"hidden\" name=\"ac_clid\" value=\"{$_SESSION['_cl_id']}\" />\n";
	$ac_new_form .= "      </TR>\n";
	$ac_new_form .= "        </FORM>\n";
	$ac_new_form .= "      </TR>\n";
	$ac_new_form .= "      </table>\n";
	$ac_new_form .= "      </div>\n";

	$ac_list_title = "";
	$ac_list_title .= "        <table border=\"0\" style=\"border:solid thin\" rules=\"none\">\n";
	$ac_list_title .= "        <TR>\n";
	$ac_list_title .= "          <TD class=\"td_cl\" style=\"width:350px\">状態</TD>\n";
	$ac_list_title .= "          <TD class=\"td_cl\" style=\"width:200px\">カテゴリ</TD>\n";
	$ac_list_title .= "          <TD class=\"td_cl\" style=\"width:100px\">&nbsp;</TD>\n";
	$ac_list_title .= "          <TD class=\"td_cl\" style=\"width:100px\">&nbsp;</TD>\n";
	$ac_list_title .= "        </TR>\n";
	$ac_list_title .= "        <TR>\n";
	$ac_list_title .= "          <TD class=\"td_cl\" style=\"width:350px\" rowspan=\"2\">画像</TD>\n";
	$ac_list_title .= "          <TD class=\"td_cl\" style=\"width:300px\" colspan=\"2\">タイトル</TD>\n";
	$ac_list_title .= "          <TD class=\"td_cl\" style=\"width:100px\">表示順</TD>\n";
	$ac_list_title .= "        </TR>\n";
	$ac_list_title .= "        <TR>\n";
	$ac_list_title .= "          <TD colspan=\"3\" class=\"td_cl\" style=\"width:400px\">コンテンツ</TD>\n";
	$ac_list_title .= "        </TR>\n";

	if($intTotal==0){
		$as_list_title .= "      <TR>\n";
		$as_list_title .= "        <TD class=\"td_cm\" colspan=\"4\" style=\"width:750\"><br>記事は登録されておりません。<br><br></TD>\n";
		$as_list_title .= "      </TR>\n";
	}

	$ac_list_title .= "        </table>\n";

	for($i=0;$i<$intTotal;$i++){
		$ac_id = $obj2->articledat[$i]['ac_id'];
		$ac_clid = $obj2->articledat[$i]['ac_clid'];

		// 状態情報生成
		$ac_statFlg1 = "";
		$ac_statFlg2 = "";
		$dispnoClr = "";
		$ac_stat = $obj2->articledat[$i]['ac_stat'];
		if($ac_stat == 1){
			$ac_statFlg1 = " checked";
		}else{
			$ac_statFlg2 = " checked";
			$dispnoClr = "background-color:#999999;";
		}

		// カテゴリ情報生成
		$cateValue = "";
		$ac_cateid = $obj2->articledat[$i]['ac_cateid'];
		$obj_cate = new basedb_CategoryClassTblAccess;
		$obj_cate->conn = $obj_conn->conn;
		$obj_cate->jyoken["cg_deldate"] = 1;
		$obj_cate->jyoken["cg_stat"] = 1;
		$obj_cate->jyoken["cg_type"] = 1;
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
			if($category_id == $ac_cateid && $ac_cateid!="")$cg_select = "selected";
			$cateValue .= "<OPTION VALUE=\"{$category_id}\" {$cg_select}>{$category_name}</OPTION>";
		}

		$ac_title = $obj2->articledat[$i]['ac_title'];
		$ac_img = $obj2->articledat[$i]['ac_img'];
		$ac_imgorg = $obj2->articledat[$i]['ac_imgorg'];
		$ac_contents = $obj2->articledat[$i]['ac_contents'];
		$ac_dispno = $obj2->articledat[$i]['ac_dispno'];
		$ac_adminid = $obj2->articledat[$i]['ac_adminid'];
		$ac_insdate = $obj2->articledat[$i]['ac_insdate'];
		$ac_upddate = $obj2->articledat[$i]['ac_upddate'];
		$ac_deldate = $obj2->articledat[$i]['ac_deldate'];

		// 画像
		$ac_img_dir = $param_article_img_path;
		$ac_img_arr["org"] = $ac_imgorg;
		$ac_img_arr["chk_in"] = "1";
		$ac_img_arr["width"] = "150";
		$ac_img_arr["height"] = "150";
		$ac_img_txt =  form_ImgDisp( "ac_img" , $ac_img_dir , $obj2->articledat[$i]["ac_img"] , "3" , $ac_img_arr );

		$viewData .= "      <table border=\"0\" style=\"border:solid thin\" rules=\"none\">\n";
		$viewData .= "      <TR>\n";
		$viewData .= "        <FORM method=\"POST\" action=\"article_upd.php\" target=\"_self\" name=\"editForm{$i}\" id=\"editForm{$i}\" enctype=\"multipart/form-data\">\n";
		$viewData .= "        <TD class=\"td_cm\" style=\"width:350\"><input type=\"radio\" name=\"ac_stat\" value=\"1\" {$ac_statFlg1}>表示<input type=\"radio\" name=\"ac_stat\" value=\"9\" {$ac_statFlg2}>非表示</TD>\n";
		$viewData .= "        <TD class=\"td_cm\"style=\"width:200\">\n";
		$viewData .= "       <INPUT type=\"hidden\" name=\"ac_cateid\" value=\"{$_POST['cg_id']}\" />\n";

//		$viewData .= "        <select name=\"ac_cateid\">\n";
//		$viewData .= "        <option value-\"\">----</option>\n";
//		$viewData .= "        {$cateValue}\n";

		$viewData .= "        </TD>\n";
		$viewData .= "        <TD class=\"td_cm\" align=\"right\" style=\"width:100\"><INPUT type=\"button\" name=\"go_mnt_2\" value=\"修正\" class=\"btn\"  onclick=\"return ArticleInputCheck( this.form , this.form )\"/></TD>\n";
		$viewData .= "        <TD class=\"td_cm\" align=\"right\" style=\"width:100\"><INPUT type=\"button\" value=\"削除\" class=\"btn\" onclick=\"document.del_article{$i}.submit();return false;\"/></TD>\n";
		$viewData .= "      </TR>\n";
		$viewData .= "      <TR>\n";
		$viewData .= "        <TD class=\"td_cm\" style=\"width:350px;vertical-align:top;\" rowspan=\"2\">{$ac_img_txt}</TD>\n";
//		$viewData .= "        <TD class=\"td_cm\" style=\"width:350px\"><input type=\"file\" name=\"ac_img\"></TD>\n";
		$viewData .= "        <TD class=\"td_cm\" style=\"width:300\" colspan=\"2\"><input type=\"text\" name=\"ac_title\" value=\"{$ac_title}\" style=\"width:300px\"></TD>\n";
		$viewData .= "        <TD class=\"td_cm\" style=\"width:100\"><input type=\"text\" name=\"ac_dispno\" value=\"{$ac_dispno}\" style=\"width:100px;{$dispnoClr}\"></TD>\n";
		$viewData .= "      </TR>\n";
		$viewData .= "        <TD class=\"td_cm\" colspan=\"3\" style=\"width:400;align:center\"><textarea name=\"ac_contents\" rows=\"12\" cols=\"53\">{$ac_contents}</textarea></TD>\n";
		$viewData .= "      <TR>\n";
		$viewData .= "        <INPUT type=\"hidden\" name=\"mode\" value=\"EDIT\" />\n";
		$viewData .= "        <INPUT type=\"hidden\" name=\"ac_clid\" value=\"{$_SESSION['_cl_id']}\" />\n";
		$viewData .= "       <INPUT type=\"hidden\" name=\"ac_id\" value=\"{$ac_id}\" />\n";
		$viewData .= "       <INPUT type=\"hidden\" name=\"ac_upddate\" value=\"{$ac_upddate}\" />\n";
		$viewData .= "        <INPUT type=\"hidden\" name=\"ac_img_lastupd\" value=\"{$ac_img}\" />\n";
		$viewData .= "      </TR>\n";
		$viewData .= "        </FORM>\n";
		$viewData .= "      </TR>\n";
		$viewData .= "      </table>\n";

		$viewData2 .= "<FORM name=\"del_article{$i}\" action=\"article_upd.php\" method=\"POST\">\n";

		$viewData2 .= "<INPUT type=\"hidden\" name=\"mode\" value=\"DEL\" />\n";
		$viewData2 .= "<INPUT type=\"hidden\" name=\"ac_upddate\" value=\"{$ac_upddate}\" />\n";
		$viewData2 .= "<INPUT type=\"hidden\" name=\"ac_id\" value=\"{$ac_id}\" />\n";
		$viewData2 .= "<INPUT type=\"hidden\" name=\"ac_cateid\" value=\"{$_POST['cg_id']}\" />\n";

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
    <LINK rel="stylesheet" type="text/css" href="../share/css/article.css" />
    <SCRIPT type="text/javascript" src="../share/js/article.js"></SCRIPT>
    <SCRIPT type="text/javascript" src="../share/js/input_check.js"></SCRIPT>
    <SCRIPT type="text/javascript" src="../share/js/more.js"></SCRIPT>
    <NOSCRIPT><META http-equiv="Refresh" content="1;URL=../jserror.html"></NOSCRIPT>
  </HEAD>
  <BODY>
    <TABLE>
      <TR>
        <TD><IMG src="../share/images/article_title.gif" alt="教室案内自由記事情報登録" /></TD>
        <FORM ACTION="../category/category_main.php" METHOD="POST">
        <TD>
          <input type="hidden" name="stpos" value="<?=$_POST['stpos']?>">
          <INPUT type="hidden" name="cg_type" value="1" />
          <input type="submit" value="教室案内自由記事カテゴリ一覧へ戻る" style="width:300px;" class="btn">
        </TD>
        </FORM>
      </TR>
    </TABLE>
    <HR color="#96BC69" />
    <DIV id="title2">■教室案内自由記事情報</DIV>
<?=$ac_list_title?>
<?=$viewData?>
<?=$viewData2?>
<br>
<?=$ac_new_form?>
<br><br>

    <BR />
  </BODY>
</HTML>
