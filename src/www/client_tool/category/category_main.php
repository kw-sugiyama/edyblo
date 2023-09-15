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
require_once ( SYS_PATH."dbif/dbcom_DBconnectClass.php" );
require_once ( SYS_PATH."dbif/basedb_ClientClass.php" );
require_once ( SYS_PATH."dbif/basedb_CategoryClass.php" );
require_once ( SYS_PATH."common/base_common.php" );
require_once ( SYS_PATH."common/sys_common.php" );
include_once ( SYS_PATH."common/error.class.php" );
require_once ( SYS_PATH."configs/param_base.conf" );


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


/*----------------------------------------------------------
   建物用／日記用 判別処理
----------------------------------------------------------*/
//echo("##");

if($_POST['cg_type'] == 1){
	$cg_title = "教室案内自由記事カテゴリ一覧";
	$cg_title_img = "      <IMG src=\"../share/images/cate_school_title.gif\" alt=\"教室案内自由記事情報カテゴリ設定\" />";
	$cg_comment_top = "";
	$cg_list_title = "";
	$cg_list_title .= "        <TD class=\"td_cl\" style=\"width:100px\">状態</TD>\n";
	//$cg_list_title .= "        <TD class=\"td_cl\" style=\"width:100px\">TOP表示状態</TD>\n";
	$cg_list_title .= "        <TD class=\"td_cl\" style=\"width:300px\">カテゴリ名</TD>\n";
	$cg_list_title .= "        <TD class=\"td_cl\" style=\"width:100px\">カテゴリ表示順</TD>\n";
	$cg_list_title .= "        <TD class=\"td_cl\" style=\"width:100px\">&nbsp;</TD>\n";
	$cg_list_title .= "        <TD class=\"td_cl\" style=\"width:200px\">&nbsp;</TD>\n";
}else if($_POST['cg_type'] == 2){
	$cg_title = "入塾の流れ自由記事情報カテゴリ一覧";
	$cg_title_img = "      <IMG src=\"../share/images/cate_admission_title.gif\" alt=\"入塾の流れ自由記事情報カテゴリ設定\" />";
	$cg_comment_top = "";
	$cg_list_title = "";
	$cg_list_title .= "        <TD class=\"td_cl\" style=\"width:100px\">状態</TD>\n";
	$cg_list_title .= "        <TD class=\"td_cl\" style=\"width:300px\">カテゴリ名</TD>\n";
	$cg_list_title .= "        <TD class=\"td_cl\" style=\"width:100px\">カテゴリ表示順</TD>\n";
	$cg_list_title .= "        <TD class=\"td_cl\" style=\"width:100px\">&nbsp;</TD>\n";
	$cg_list_title .= "        <TD class=\"td_cl\" style=\"width:200px\">&nbsp;</TD>\n";
}else if($_POST['cg_type'] == 3){
	$cg_title = "コース情報カテゴリ一覧";
	$cg_title_img = "      <IMG src=\"../share/images/cate_course_title.gif\" alt=\"コース情報カテゴリ設定\" />";
	$cg_comment_top = "";
	$cg_comment_top .= "      <tr>\n";
	$cg_comment_top .= "        <td colspan=\"2\">\n";
	$cg_comment_top .= "          <FONT class=\"comment\">\n";
	$cg_comment_top .= "            ※ブログ中央に表示できるカテゴリはひとつです。<br />\n";
	$cg_comment_top .= "          </FONT>\n";
	$cg_comment_top .= "        </td>\n";
	$cg_comment_top .= "      </tr>\n";
	
	$cg_list_title = "";
	$cg_list_title .= "        <TD class=\"td_cl\" style=\"width:100px\">状態</TD>\n";
	$cg_list_title .= "        <TD class=\"td_cl\" style=\"width:300px\">カテゴリ名</TD>\n";
	$cg_list_title .= "        <TD class=\"td_cl\" style=\"width:100px\">カテゴリ表示順</TD>\n";
	$cg_list_title .= "        <TD class=\"td_cl\" style=\"width:100px\">&nbsp;</TD>\n";
}else if($_POST['cg_type'] == 4){
	$cg_title = "よくある質問自由記事情報カテゴリ一覧";
	$cg_title_img = "      <IMG src=\"../share/images/cate_qa_title.gif\" alt=\"よくある質問自由記事情報カテゴリ設定\" />";
	$cg_comment_top = "";
	$cg_list_title = "";
	$cg_list_title .= "        <TD class=\"td_cl\" style=\"width:100px\">状態</TD>\n";
	$cg_list_title .= "        <TD class=\"td_cl\" style=\"width:300px\">カテゴリ名</TD>\n";
	$cg_list_title .= "        <TD class=\"td_cl\" style=\"width:100px\">カテゴリ表示順</TD>\n";
	$cg_list_title .= "        <TD class=\"td_cl\" style=\"width:100px\">&nbsp;</TD>\n";
	$cg_list_title .= "        <TD class=\"td_cl\" style=\"width:200px\">&nbsp;</TD>\n";
}else if($_POST['cg_type'] == 5){
	$cg_title = "日記情報用カテゴリ一覧";
	$cg_title_img = "      <IMG src=\"../share/images/cate_diary_title.gif\" alt=\"スタッフ日記カテゴリ設定\" />";
	$cg_comment_top = "";
	$cg_list_title = "";
	$cg_list_title .= "        <TD class=\"td_cl\" style=\"width:100px\">状態</TD>\n";
	$cg_list_title .= "        <TD class=\"td_cl\" style=\"width:300px\">カテゴリ名</TD>\n";
	$cg_list_title .= "        <TD class=\"td_cl\" style=\"width:100px\">カテゴリ表示順</TD>\n";
	$cg_list_title .= "        <TD class=\"td_cl\" style=\"width:100px\">&nbsp;</TD>\n";
}else if($_POST['cg_type'] == 6){
	$cg_title = "講習・イベント情報用カテゴリ一覧";
	$cg_title_img = "      <IMG src=\"../share/images/cate_campain_title.gif\" alt=\"キャンペーンカテゴリ設定\" />";
	$cg_comment_top = "";
	$cg_list_title = "";
	$cg_list_title .= "        <TD class=\"td_cl\" style=\"width:100px\">状態</TD>\n";
	$cg_list_title .= "        <TD class=\"td_cl\" style=\"width:400px\">カテゴリ名</TD>\n";
	$cg_list_title .= "        <TD class=\"td_cl\" style=\"width:100px\">カテゴリ表示順</TD>\n";
	$cg_list_title .= "        <TD class=\"td_cl\" style=\"width:100px\">&nbsp;</TD>\n";
}


/*--------------------------------------------------------
	処理部分
--------------------------------------------------------*/
$obj2 = new basedb_CategoryClassTblAccess;
$obj2->conn = $obj_conn->conn;
if($_POST['cg_type']==1){
	$obj2->jyoken["cg_type"] = 1;
}else if($_POST['cg_type']==2){
	$obj2->jyoken["cg_type"] = 2;
}else if($_POST['cg_type']==3){
	$obj2->jyoken["cg_type"] = 3;
}else if($_POST['cg_type']==4){
	$obj2->jyoken["cg_type"] = 4;
}else if($_POST['cg_type']==5){
	$obj2->jyoken["cg_type"] = 5;
}else if($_POST['cg_type']==6){
	$obj2->jyoken["cg_type"] = 6;
}else{
        $obj_error->ViewErrMessage( "CATE_TYPE" , "ALL" , SITE_PATH."blank.php" , $arrOther );
        exit;
}
$obj2->jyoken["cg_deldate"] = 1;
$obj2->jyoken["cg_clid"] = $_SESSION['_cl_id'];
$obj2->sort["cg_dispno"] = 2;
$obj2->sort["cg_type"] = 2;
list( $num , $intTotal ) = $obj2->basedb_GetCategory( 1 , -1 );
IF( $nmu == -1 ){
	$arrOther["ath_comment"] = "<INPUT TYPE=\"hidden\" NAME=\"stpos\" VALUE=\"{$_POST['stpos']}\">";
	$obj_error->ViewErrMessage( "SYSTEM" , "ALL" , SITE_PATH."blank.php" , $arrOther );
	exit;
}
$viewData = "";
IF( $num == 0 ){
	$viewData .= "      <TR>\n";
	$viewData .= "        <TD colspan=\"4\" class=\"td_cm\">該当するカテゴリ情報はありません。</TD>\n";
	$viewData .= "      </TR>\n";
}
FOR( $i=0; $i<$num; $i++){
	
	if( $obj2->admindat[$i]["kanri_kengen_1"] == 0){
		$kengen = "可能";
	}elseif( $obj2->admindat[$i]["kanri_kengen_1"] == 1 ){
		$kengen = "<FONT color=\"#FF0000\">不可</FONT>";
	}
	$cg_id = htmlspecialchars( $obj2->categorydat[$i]["cg_id"] );
	$cg_clid = htmlspecialchars( $obj2->categorydat[$i]["cg_clid"] );
	$cg_stitle = htmlspecialchars( $obj2->categorydat[$i]["cg_stitle"] );
	if($_POST['error_mode']=="on" && $_POST['num']>$i){
		$cg_dispno = htmlspecialchars( $_POST[$i] );
	}else{
		$cg_dispno = htmlspecialchars( $obj2->categorydat[$i]["cg_dispno"] );
	}
	$cg_stat = htmlspecialchars( $obj2->categorydat[$i]["cg_stat"] );
	if($cg_stat==1){
		$cg_stat_value = "表示";
	}else if($cg_stat==9){
		$cg_stat_value = "非表示";
	}
	$cg_stitle = htmlspecialchars( $obj2->categorydat[$i]["cg_stitle"] );
	$cg_topflg = htmlspecialchars( $obj2->categorydat[$i]["cg_topflg"] );
	$cg_upddate = htmlspecialchars( $obj2->categorydat[$i]["cg_upddate"] );
	$readonly="";
	if($cg_stat == 9)$readonly="readonly";
	$dispNoMode = "";
        if($cg_stat == 1){
		$dispNoMode="text";
	}else if($cg_stat == 9){
                $dispNoMode="hidden";
	}
	if($cg_topflg==1){
		$cg_topflg = "表示";
	}else{
		$cg_topflg = "";
	}
	$viewData .= "      <TR>\n";
	$viewData .= "        <FORM method=\"POST\" action=\"category_mnt.php\" target=\"_self\" name=\"editForm{$i}\" id=\"editForm{$i}\">\n";
	$viewData .= "        <TD class=\"td_cm\">{$cg_stat_value}</TD>\n";
//	IF( $_POST['cg_type'] == 1 ){
//		$viewData .= "        <TD class=\"td_cm\">{$cg_topflg}</TD>\n";
//	}
	$viewData .= "        <TD class=\"td_cm\">{$cg_stitle}</TD>\n";
	$viewData .= "        <TD class=\"td_cm\"><INPUT type=\"{$dispNoMode}\" id=\"{$i}\" name=\"cg_dispno\" value=\"{$cg_dispno}\" style=\"width:50px;\" {$readonly} onFocus='Text(\"{$i}\", 1)' onBlur='Text(\"{$i}\", 2)'></TD>\n";
	$viewData .= "        <TD class=\"td_cm\"><INPUT type=\"submit\" name=\"go_mnt_2\" value=\"修正\" class=\"btn\" /></TD>\n";
	$viewData .= "        <INPUT type=\"hidden\" name=\"mode\" value=\"EDIT\" />\n";
	$viewData .= "        <INPUT type=\"hidden\" name=\"cg_type\" value=\"{$_POST['cg_type']}\" />\n";
	$viewData .= "        <INPUT type=\"hidden\" name=\"cg_id\" value=\"{$cg_id}\" />\n";
	$viewData .= "        </FORM>\n";

	if($_POST['cg_type']==1){
		$viewData .= "              <FORM name=\"goNew\" method=\"POST\" action=\"../article/article_main.php\" target=\"_self\">\n";
		$viewData .= "                <TD class=\"td_cm\"><INPUT type=\"submit\" value=\"教室案内自由記事登録\" class=\"btn\" style=\"width:180px\"/></TD>\n";
		$viewData .= "                <INPUT type=\"hidden\" name=\"cg_id\" value=\"{$cg_id}\" />\n";
		$viewData .= "              </FORM>\n";
	}else if($_POST['cg_type']==2){
		$viewData .= "              <FORM name=\"goNew\" method=\"POST\" action=\"../admission/admission_main.php\" target=\"_self\">\n";
		$viewData .= "                <TD class=\"td_cm\"><INPUT type=\"submit\" value=\"入塾の流れ自由記事登録\" class=\"btn\" style=\"width:180px\"/></TD>\n";
		$viewData .= "                <INPUT type=\"hidden\" name=\"cg_id\" value=\"{$cg_id}\" />\n";
		$viewData .= "              </FORM>\n";
	}else if($_POST['cg_type']==4){
		$viewData .= "              <FORM name=\"goNew\" method=\"POST\" action=\"../qa/qa_main.php\" target=\"_self\">\n";
		$viewData .= "                <TD class=\"td_cm\"><INPUT type=\"submit\" value=\"よくある質問自由記事登録\" class=\"btn\" style=\"width:180px\"/></TD>\n";
		$viewData .= "                <INPUT type=\"hidden\" name=\"cg_id\" value=\"{$cg_id}\" />\n";
		$viewData .= "              </FORM>\n";
	}

	$viewData .= "      </TR>\n";

	if( $i != 0 && $obj2->categorydat[$i]["cg_stat"] == 1)$disp_cg_id .= "/";
	if( $obj2->categorydat[$i]["cg_stat"] == 1)$disp_cg_id .= $obj2->categorydat[$i]["cg_id"];
	if( $i != 0 && $obj2->categorydat[$i]["cg_stat"] == 1)$disp_cg_upddate .= "/";
	if( $obj2->categorydat[$i]["cg_stat"] == 1)$disp_cg_upddate .= $obj2->categorydat[$i]["cg_upddate"];
	if( $i != 0 && $obj2->categorydat[$i]["cg_stat"] == 1)$disp_cg_stat .= "/";
	if( $obj2->categorydat[$i]["cg_stat"] == 1)$disp_cg_stat .= $obj2->categorydat[$i]["cg_stat"];

	if( $obj2->categorydat[$i]["cg_stat"] == 1)$num2++;	
}

/*----------------------------------------------------------
   ページ遷移用
	=> 2007/03/16 現在使用してない
----------------------------------------------------------*/
/*
IF( $_POST["stpos"] != "" ){
	$intStPos = intval($_POST["stpos"]);
}ELSE{
	$intStPos = 1;
}
$intPageNum = $intTotal / $intGetNum;
IF( !strpos( $intPageNum , "." ) ){
	$intPageNum = (int)$intPageNum;
}ELSE{
	$intPageNum = (int)$intPageNum + 1;
}
$intEdPos = $intGetNum + $intStPos - 1;
IF( $intEdPos > $intTotal ) $intEdPos = $intTotal;
$viewPageChangeValue = basecom_page_change_VAL( $num , $intTotal , $intGetNum , $intStPos , $intGetNum , $intPageNum , "category_main" , "stpos" , "" );
*/


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
    <LINK rel="stylesheet" type="text/css" href="../share/css/category.css" />
    <SCRIPT type="text/javascript" src="../share/js/category.js"></SCRIPT>
    <NOSCRIPT><META http-equiv="Refresh" content="1;URL=../jserror.html"></NOSCRIPT>
  </HEAD>
  <BODY>
    <TABLE>
      <TR>
        <TD><?=$cg_title_img?></TD>
      </TR>
    </TABLE>
    <HR color="#96BC69" />
    <DIV id="title2">■<?=$cg_title?></DIV>
    <TABLE width="700">
      <?=$cg_comment_top?>
      <TR>
        <FORM action="category_mnt.php" method="POST" >
        <TD><INPUT type="submit" name="new" value="新規カテゴリを作成する" class="btn_nosize" /></TD>
        <INPUT type="hidden" name="mode" value="NEW" class="btn" /></TD>
        <INPUT type="hidden" name="cg_type" value="<?=$_POST['cg_type']?>"/></TD>
        </FORM>
        <FORM action="category_upd.php" method="POST" onsubmit="return dispSet(<?=$intTotal?>)" name="disp_set">
        <TD align="right"><INPUT type="submit" name="new" value="表示順を反映する" class="btn_nosize" /></TD>
        <INPUT type="hidden" name="cg_upddate" value="<?=$disp_cg_upddate?>" />
        <INPUT type="hidden" name="cg_topflg" value="<?=$disp_cg_stat?>" />
        <INPUT type="hidden" name="cg_dispno" value="" />
        <INPUT type="hidden" name="cg_id" value="<?=$disp_cg_id?>" />
        <INPUT type="hidden" name="cg_type" value="<?=$_POST['cg_type']?>" />
        <INPUT type="hidden" name="intCnt" value="<?=$intTotal?>" />
        <INPUT type="hidden" name="num" value="<?=$num2?>" />
        <INPUT type="hidden" name="mode" value="DISP" />
        </FORM>
	<TD><FONT class="comment">※カテゴリ表示順を変更したら「表示順を反映する」<BR>をクリックしてください。</FONT></TD>
      </TR>
    </TABLE>
    <br />
    <TABLE>
      <TR>
	<?=$cg_list_title?>
      </TR>
<?=$viewData?>
    </TABLE>
    <BR />
    <TABLE border="0" cellspacing="0" cellpadding="2" width="700" class="px12">
      <TR>
        <FORM name="category_main" method="POST" action="category_main.html">
        <INPUT type="hidden" name="stpos" value="" />
        </TD>
        </FORM>
      </TR>
    </TABLE>
  </BODY>
</HTML>
