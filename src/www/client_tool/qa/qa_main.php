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
require_once ( SYS_PATH."dbif/basedb_QaClass.php" );
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
	$obj2 = new basedb_QaClassTblAccess;
	$obj2->conn = $obj_conn->conn;
	$obj2->jyoken["qa_deldate"] = 1;
	$obj2->jyoken["qa_clid"] = $_SESSION['_cl_id'];
	$obj2->jyoken["qa_cgid"] = $_POST['cg_id'];
	$obj2->sort["qa_cgid"] = 1;
	list( $num , $intTotal ) = $obj2->basedb_GetQa( 1 , -1 );
	IF( $nmu == -1 ){
		$arrOther["ath_comment"] = "<INPUT TYPE=\"hidden\" NAME=\"stpos\" VALUE=\"{$_POST['stpos']}\">";
		$obj_error->ViewErrMessage( "SYSTEM" , "ALL" , SITE_PATH."blank.php" , $arrOther );
		exit;
	}


	/**************************************
	  表示値生成
	**************************************/
	// カテゴリ情報生成
	$qa_cgid = $obj2->qadat[$i]['qa_cgid'];
	$obj_cate = new basedb_CategoryClassTblAccess;
	$obj_cate->conn = $obj_conn->conn;
	$obj_cate->jyoken["cg_deldate"] = 1;
	$obj_cate->jyoken["cg_stat"] = 1;
	$obj_cate->jyoken["cg_type"] = 4;
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
		if($category_id == $qa_cgid && $qa_cgid!="")$cg_select = "selected";
		$cateValue .= "<OPTION VALUE=\"{$category_id}\" {$cg_select}>{$category_name}</OPTION>";
	}

	$qa_new_form = "";
	$qa_new_form .= "        <img src=\"../share/images/qa_new_button.gif\" alt=\"こちらをクリックすると展開表示できます\" width=\"100\" height=\"20\" title=\"詳細条件検索で絞り込む\" />\n";
	$qa_new_form .= "        <div class=\"js_close\">\n";
	$qa_new_form .= "          <DIV id=１\"title\">■入塾までの流れ記事新規登録</DIV>\n";
	$qa_new_form .= "      <br>\n";
	$qa_new_form .= "        <table border=\"0\" style=\"border:solid thin\" rules=\"none\">\n";
	$qa_new_form .= "        <TR>\n";
	$qa_new_form .= "          <TD class=\"td_cl\" style=\"width:200px\">状態</TD>\n";
	$qa_new_form .= "          <TD class=\"td_cl\" style=\"width:150px\">表示順</TD>\n";
	$qa_new_form .= "          <TD class=\"td_cl\" style=\"width:200px\">カテゴリ</TD>\n";
	$qa_new_form .= "          <TD class=\"td_cl\" style=\"width:200px\" colspan=\"2\">&nbsp;</TD>\n";
	$qa_new_form .= "        </TR>\n";
	$qa_new_form .= "        <TR>\n";
	$qa_new_form .= "          <TD class=\"td_cl\" style=\"width:300px\" colspan=\"2\">タイトル</TD>\n";
	$qa_new_form .= "        </TR>\n";
	$qa_new_form .= "          <TD colspan=\"3\" class=\"td_cl\" style=\"width:400px\">コンテンツ</TD>\n";
	$qa_new_form .= "        <TR>\n";
	$qa_new_form .= "        </TR>\n";
	$qa_new_form .= "        </table>\n";
	$qa_new_form .= "      <table border=\"0\" style=\"border:solid thin\" rules=\"none\">\n";
	$qa_new_form .= "      <TR>\n";
	$qa_new_form .= "        <FORM method=\"POST\" action=\"qa_upd.php\" target=\"_self\" name=\"editForm\" id=\"editForm\" enctype=\"multipart/form-data\">\n";
	$qa_new_form .= "        <TD class=\"td_cm\" style=\"width:250\"><input type=\"radio\" name=\"qa_stat\" value=\"1\" {$qa_statFlg1}>表示<input type=\"radio\" name=\"qa_stat\" value=\"9\" {$qa_statFlg2}>非表示</TD>\n";
	$qa_new_form .= "        <TD class=\"td_cm\"style=\"width:200\"><select name=\"qa_cgid\">\n";
	$qa_new_form .= "        <option value-\"\">----</option>\n";
	$qa_new_form .= "        {$cateValue}\n";
	$qa_new_form .= "        </TD>\n";
	$qa_new_form .= "        <TD class=\"td_cm\" align=\"right\" style=\"width:100\"><INPUT type=\"button\" name=\"go_mnt_2\" value=\"新規作成\" class=\"btn_qa\" onclick=\"return QaInputCheck( this.form , this.form )\"/></TD>\n";
	$qa_new_form .= "        <TD class=\"td_cm\" align=\"right\" style=\"width:100\"><input type=\"reset\" value=\"クリア\" class=\"btn_qa\" ></TD>\n";
	$qa_new_form .= "      </TR>\n";
	$qa_new_form .= "      <TR>\n";
	$qa_new_form .= "        <TD class=\"td_cm\" style=\"width:350px;vertical-align:top;\" rowspan=\"2\"><input type=\"file\" name=\"qa_img\"\"></TD>\n";
	$qa_new_form .= "        <TD class=\"td_cm\" style=\"width:300\" colspan=\"2\"><input type=\"text\" name=\"qa_question\" value=\"{$qa_question}\" style=\"width:300px\"></TD>\n";
	$qa_new_form .= "        <TD class=\"td_cm\" style=\"width:100\"><input type=\"text\" name=\"qa_dispno\" value=\"{$qa_dispno}\" style=\"width:100px\"></TD>\n";
	$qa_new_form .= "      </TR>\n";
	$qa_new_form .= "      <TR>\n";
	$qa_new_form .= "        <TD class=\"td_cm\" colspan=\"3\" style=\"width:400;align:center\"><textarea name=\"qa_answer\" rows=\"12\" cols=\"53\">{$qa_answer}</textarea></TD>\n";
	$qa_new_form .= "        <INPUT type=\"hidden\" name=\"mode\" value=\"NEW\" />\n";
	$qa_new_form .= "        <INPUT type=\"hidden\" name=\"qa_clid\" value=\"{$_SESSION['_cl_id']}\" />\n";
	$qa_new_form .= "      </TR>\n";
	$qa_new_form .= "        </FORM>\n";
	$qa_new_form .= "      </TR>\n";
	$qa_new_form .= "      </table>\n";
	$qa_new_form .= "      </div>\n";

	$qa_new_form = "";
	$qa_new_form .= "        <img src=\"../share/images/qa_new_button.gif\" alt=\"こちらをクリックすると展開表示できます\" width=\"100\" height=\"20\" title=\"新規登録\" />\n";
	$qa_new_form .= "        <div class=\"js_close\">\n";
//	$qa_new_form .= "          <DIV id=\"title\">■入塾までの流れ記事</DIV>\n";
//	$qa_new_form .= "      <br>\n";
	$qa_new_form .= "      <table border=\"0\" style=\"border:solid thin\" rules=\"none\">\n";
	$qa_new_form .= "        <TR>\n";
	$qa_new_form .= "          <TD class=\"td_qa_new\" style=\"width:200px\">状態</TD>\n";
	$qa_new_form .= "          <TD class=\"td_qa_new\" style=\"width:150px\">表示順</TD>\n";
	$qa_new_form .= "          <TD class=\"td_qa_new\" style=\"width:150px\">&nbsp;</TD>\n";
	$qa_new_form .= "          <TD class=\"td_qa_new\" style=\"width:200px\" colspan=\"2\">&nbsp;</TD>\n";
	$qa_new_form .= "        </TR>\n";
	$qa_new_form .= "      <TR>\n";
	$qa_new_form .= "        <FORM method=\"POST\" action=\"qa_upd.php\" target=\"_self\" name=\"editForm\" id=\"editForm\" enctype=\"multipart/form-data\">\n";
	$qa_new_form .= "        <TD class=\"td_cm\" style=\"width:200\"><input type=\"radio\" name=\"qa_stat\" value=\"1\" {$qa_statFlg1}>表示<input type=\"radio\" name=\"qa_stat\" value=\"9\" {$qa_statFlg2}>非表示</TD>\n";
	$qa_new_form .= "        <TD class=\"td_cm\" style=\"width:150\"><input type=\"text\" name=\"qa_dispno\" value=\"{$qa_dispno}\" style=\"width:150px\"></TD>\n";
	$qa_new_form .= "        <TD class=\"td_cm\"style=\"width:150\">\n";
	$qa_new_form .= "        <INPUT type=\"hidden\" name=\"qa_cgid\" value=\"{$_POST['cg_id']}\" />\n";

//	$qa_new_form .= "        <select name=\"qa_cgid\">\n";
//	$qa_new_form .= "        <option value-\"\">----</option>\n";
//	$qa_new_form .= "        {$cateValue}\n";

	$qa_new_form .= "        </TD>\n";
	$qa_new_form .= "        <TD class=\"td_cm\" align=\"right\" style=\"width:100\"><INPUT type=\"button\" name=\"go_mnt_2\" value=\"新規作成\" class=\"btn_qa\" onclick=\"return QaInputCheck( this.form , this.form )\"/></TD>\n";
	$qa_new_form .= "        <TD class=\"td_cm\" align=\"right\" style=\"width:100\"><input type=\"reset\" value=\"クリア\" class=\"btn_qa\" ></TD>\n";
	$qa_new_form .= "      </TR>\n";
	$qa_new_form .= "        <TR>\n";
	$qa_new_form .= "          <TD class=\"td_qa_new\" style=\"width:350px\" colspan=\"2\">質問</TD>\n";
	$qa_new_form .= "          <TD colspan=\"3\" class=\"td_qa_new\" style=\"width:350px\">回答</TD>\n";
	$qa_new_form .= "        </TR>\n";
	$qa_new_form .= "      <TR>\n";
	$qa_new_form .= "        <TD class=\"td_cm\" colspan=\"2\" style=\"width:350;align:center\"><textarea name=\"qa_question\" rows=\"12\" cols=\"46\">{$qa_question}</textarea></TD>\n";
//	$qa_new_form .= "        <TD class=\"td_cm\" style=\"width:300\" colspan=\"2\"><input type=\"text\" name=\"qa_question\" value=\"{$qa_question}\" style=\"width:300px\"></TD>\n";
	$qa_new_form .= "        <TD class=\"td_cm\" colspan=\"3\" style=\"width:350;align:center\"><textarea name=\"qa_answer\" rows=\"12\" cols=\"46\">{$qa_answer}</textarea></TD>\n";
	$qa_new_form .= "        <INPUT type=\"hidden\" name=\"mode\" value=\"NEW\" />\n";
	$qa_new_form .= "        <INPUT type=\"hidden\" name=\"qa_clid\" value=\"{$_SESSION['_cl_id']}\" />\n";
	$qa_new_form .= "      </TR>\n";
	$qa_new_form .= "        </FORM>\n";
	$qa_new_form .= "      </TR>\n";
	$qa_new_form .= "      </table>\n";
	$qa_new_form .= "      </div>\n";

	$qa_list_title = "";
	$qa_list_title .= "        <table border=\"0\" style=\"border:solid thin\" rules=\"none\">\n";
	$qa_list_title .= "        <TR>\n";
	$qa_list_title .= "          <TD class=\"td_cl\" style=\"width:200px\">状態</TD>\n";
	$qa_list_title .= "          <TD class=\"td_cl\" style=\"width:150px\">表示順</TD>\n";
	$qa_list_title .= "          <TD class=\"td_cl\" style=\"width:150px\">カテゴリ</TD>\n";
	$qa_list_title .= "          <TD class=\"td_cl\" style=\"width:200px\" colspan=\"2\">&nbsp;</TD>\n";
	$qa_list_title .= "        </TR>\n";
	$qa_list_title .= "        <TR>\n";
	$qa_list_title .= "          <TD class=\"td_cl\" style=\"width:350px\" colspan=\"2\">質問</TD>\n";
	$qa_list_title .= "          <TD colspan=\"3\" class=\"td_cl\" style=\"width:350px\">回答</TD>\n";
	$qa_list_title .= "        </TR>\n";

	if($intTotal==0){
		$qa_list_title .= "      <TR>\n";
		$qa_list_title .= "        <TD class=\"td_cm\" colspan=\"5\" style=\"width:700\"><br>記事は登録されておりません。<br><br></TD>\n";
		$qa_list_title .= "      </TR>\n";
	}

	$qa_list_title .= "        </table>\n";


	for($i=0;$i<$intTotal;$i++){
		$qa_id = $obj2->qadat[$i]['qa_id'];
		$qa_clid = $obj2->qadat[$i]['qa_clid'];

		// 状態情報生成
		$qa_statFlg1 = "";
		$qa_statFlg2 = "";
		$dispnoClr = "";
		$qa_stat = $obj2->qadat[$i]['qa_stat'];
		if($qa_stat == 1){
			$qa_statFlg1 = " checked";
		}else{
			$qa_statFlg2 = " checked";
			$dispnoClr = "background-color:#999999;";
		}

		// カテゴリ情報生成
		$cateValue = "";
		$qa_cgid = $obj2->qadat[$i]['qa_cgid'];
		$obj_cate = new basedb_CategoryClassTblAccess;
		$obj_cate->conn = $obj_conn->conn;
		$obj_cate->jyoken["cg_deldate"] = 1;
		$obj_cate->jyoken["cg_stat"] = 1;
		$obj_cate->jyoken["cg_type"] = 4;
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
			if($category_id == $qa_cgid && $qa_cgid!="")$cg_select = "selected";
			$cateValue .= "<OPTION VALUE=\"{$category_id}\" {$cg_select}>{$category_name}</OPTION>";
		}

		$qa_question = $obj2->qadat[$i]['qa_question'];
		$qa_answer = $obj2->qadat[$i]['qa_answer'];
		$qa_dispno = $obj2->qadat[$i]['qa_dispno'];
		$qa_adminid = $obj2->qadat[$i]['qa_adminid'];
		$qa_insdate = $obj2->qadat[$i]['qa_insdate'];
		$qa_upddate = $obj2->qadat[$i]['qa_upddate'];
		$qa_deldate = $obj2->qadat[$i]['qa_deldate'];

		$viewData .= "      <table border=\"0\" style=\"border:solid thin\" rules=\"none\">\n";
		$viewData .= "      <TR>\n";
		$viewData .= "        <FORM method=\"POST\" action=\"qa_upd.php\" target=\"_self\" name=\"editForm{$i}\" id=\"editForm{$i}\" enctype=\"multipart/form-data\">\n";
		$viewData .= "        <TD class=\"td_cm\" style=\"width:200\"><input type=\"radio\" name=\"qa_stat\" value=\"1\" {$qa_statFlg1}>表示<input type=\"radio\" name=\"qa_stat\" value=\"9\" {$qa_statFlg2}>非表示</TD>\n";
		$viewData .= "        <TD class=\"td_cm\" style=\"width:150\"><input type=\"text\" name=\"qa_dispno\" value=\"{$qa_dispno}\" style=\"width:150px;{$dispnoClr}\"></TD>\n";
		$viewData .= "        <TD class=\"td_cm\"style=\"width:150\">\n";
		$viewData .= "        <INPUT type=\"hidden\" name=\"qa_cgid\" value=\"{$_POST['cg_id']}\" />\n";

//		$viewData .= "        <select name=\"qa_cgid\">\n";
//		$viewData .= "        <option value-\"\">----</option>\n";
//		$viewData .= "        {$cateValue}\n";

		$viewData .= "        </TD>\n";
		$viewData .= "        <TD class=\"td_cm\" align=\"right\" style=\"width:100\"><INPUT type=\"button\" name=\"go_mnt_2\" value=\"修正\" class=\"btn\"  onclick=\"return QaInputCheck( this.form , this.form )\"/></TD>\n";
		$viewData .= "        <TD class=\"td_cm\" align=\"right\" style=\"width:100\"><INPUT type=\"button\" value=\"削除\" class=\"btn\" onclick=\"document.del_qa{$i}.submit();return false;\"/></TD>\n";
		$viewData .= "      </TR>\n";
		$viewData .= "      <TR>\n";
		$viewData .= "        <TD class=\"td_cm\" colspan=\"2\" style=\"width:350;align:center\"><textarea name=\"qa_question\" rows=\"12\" cols=\"46\">{$qa_question}</textarea></TD>\n";
//		$viewData .= "        <TD class=\"td_cm\" style=\"width:300\" colspan=\"2\"><input type=\"text\" name=\"qa_question\" value=\"{$qa_question}\" style=\"width:300px\"></TD>\n";
		$viewData .= "        <TD class=\"td_cm\" colspan=\"3\" style=\"width:350;align:center\"><textarea name=\"qa_answer\" rows=\"12\" cols=\"46\">{$qa_answer}</textarea></TD>\n";
		$viewData .= "        <INPUT type=\"hidden\" name=\"mode\" value=\"EDIT\" />\n";
		$viewData .= "        <INPUT type=\"hidden\" name=\"qa_clid\" value=\"{$_SESSION['_cl_id']}\" />\n";
		$viewData .= "       <INPUT type=\"hidden\" name=\"qa_id\" value=\"{$qa_id}\" />\n";
		$viewData .= "       <INPUT type=\"hidden\" name=\"qa_upddate\" value=\"{$qa_upddate}\" />\n";
		$viewData .= "        <INPUT type=\"hidden\" name=\"qa_img_lastupd\" value=\"{$qa_img}\" />\n";
		$viewData .= "      </TR>\n";
		$viewData .= "        </FORM>\n";
		$viewData .= "      </TR>\n";
		$viewData .= "      </table>\n";

		$viewData2 .= "<FORM name=\"del_qa{$i}\" action=\"qa_upd.php\" method=\"POST\">\n";

		$viewData2 .= "<INPUT type=\"hidden\" name=\"mode\" value=\"DEL\" />\n";
		$viewData2 .= "<INPUT type=\"hidden\" name=\"qa_upddate\" value=\"{$qa_upddate}\" />\n";
		$viewData2 .= "<INPUT type=\"hidden\" name=\"qa_id\" value=\"{$qa_id}\" />\n";
		$viewData2 .= "<INPUT type=\"hidden\" name=\"qa_cgid\" value=\"{$_POST['cg_id']}\" />\n";

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
    <LINK rel="stylesheet" type="text/css" href="../share/css/qa.css" />
    <SCRIPT type="text/javascript" src="../share/js/qa.js"></SCRIPT>
    <SCRIPT type="text/javascript" src="../share/js/input_check.js"></SCRIPT>
    <SCRIPT type="text/javascript" src="../share/js/more.js"></SCRIPT>
    <NOSCRIPT><META http-equiv="Refresh" content="1;URL=../jserror.html"></NOSCRIPT>
  </HEAD>
  <BODY>
    <TABLE>
      <TR>
        <TD><IMG src="../share/images/qa_title.gif" alt="よくある質問自由記事情報登録" /></TD>
        <FORM ACTION="../category/category_main.php" METHOD="POST">
        <TD>
          <input type="hidden" name="stpos" value="<?=$_POST['stpos']?>">
          <INPUT type="hidden" name="cg_type" value="4" />
          <input type="submit" value="よくある質問情報用カテゴリ一覧へ戻る" style="width:300px;" class="btn">
        </TD>
        </FORM>
      </TR>
    </TABLE>
    <HR color="#96BC69" />
    <DIV id="title2">■よくある質問自由記事情報</DIV>
<?=$qa_list_title?>
<?=$viewData?>
<?=$viewData2?>
<br>
<?=$qa_new_form?>
<br><br>

    <BR />
  </BODY>
</HTML>
