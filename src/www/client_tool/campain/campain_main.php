<?php
/******************************************************************************
<< 不動産ブログ　Ver.1.O.0 >>
	Name: campain_main.php
	Version: 1.0.0
	Function: 日記情報一覧
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
require_once ( SYS_PATH."dbif/basedb_CampainClass.php" );
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


/*--------------------------------------------------------
	処理部分
--------------------------------------------------------*/
IF( $_POST["stpos"] != "" ){
	$intStPos = intval($_POST["stpos"]);
}ELSE{
	$intStPos = 1;
}
$intGetNum = 10;

$obj = new basedb_CampainClassTblAccess;
$obj->conn = $obj_conn->conn;
$obj->jyoken["cp_deldate"] = 1;
$obj->jyoken["cp_clid"] = $_SESSION['_cl_id'];
$obj->sort["cp_upddate"] = 2;
list( $intCnt , $intTotal ) = $obj->basedb_GetCampain( $intStPos , $intGetNum );
IF( $intCnt == -1 ){
	$arrOther["ath_comment"] = "<INPUT TYPE=\"hidden\" NAME=\"stpos\" VALUE=\"{$_POST['stpos']}\">";
	$obj_error->ViewErrMessage( "SYSTEM" , "ALL" , SITE_PATH."blank.php" , $arrOther );
	exit;
}
$viewData = "";
IF( $intCnt == 0 ){
	$viewData .= "      <TR>\n";
	$viewData .= "        <TD colspan=\"3\" class=\"td_cm\">現在、その他記事情報はありません。</TD>\n";
	$viewData .= "      </TR>\n";
}ELSE{
	FOR( $i=0; $i<$intCnt; $i++){
		$cp_id[$i] = htmlspecialchars( $obj->campaindat[$i]["cp_id"] );
		
		$statVal = "";
		$cp_stat[$i] = htmlspecialchars( $obj->campaindat[$i]["cp_stat"] );
		if($cp_stat[$i] == 1){
			$statVal = "有効";
		}else{
			$statVal = "無効";
		}
		$cp_cgid[$i] = htmlspecialchars( $obj->campaindat[$i]["cp_cgid"] );
		$cp_title[$i] = htmlspecialchars( $obj->campaindat[$i]["cp_title"] );
		
		$obj_cate = new basedb_CategoryClassTblAccess;
		$obj_cate->conn = $obj_conn->conn;
		$obj_cate->jyoken["cg_deldate"] = 1;
		$obj_cate->jyoken["cg_stat"] = 1;
		$obj_cate->jyoken["cg_clid"] = $_SESSION['_cl_id'];
		$obj_cate->sort["cg_dispno"] = 2;
		list( $intCnt2 , $intTotal2 ) = $obj_cate->basedb_GetCategory( 1 , -1 );
		IF( $intCnt2 == -1 ){
			$arrOther["ath_comment"] = "<INPUT TYPE=\"hidden\" NAME=\"stpos\" VALUE=\"{$_POST['stpos']}\">";
			$obj_error->ViewErrMessage( "SYSTEM" , "ALL" , SITE_PATH."blank.php" , $arrOther );
			exit;
		}
		for($iX=0;$iX<$intCnt2;$iX++){
			$cg_select ="";
			$category_name ="";
			$category_id ="";
			$category_name = $obj_cate->categorydat[$iX]["cg_stitle"];
			$category_id = $obj_cate->categorydat[$iX]["cg_id"];
			if($category_id == $cp_cg_id[$i] && $cp_cg_id!="")$cp_cg_id_value = $category_name;
		}
		if($cp_cg_id_value == "")$cp_cg_id_value = "未設定";

		$viewData .= "      <TR>\n";
		$viewData .= "        <FORM method=\"POST\" action=\"campain_mnt.php\" target=\"_self\">\n";
		$viewData .= "        <TD class=\"td_cm\">{$statVal}</TD>\n";
		$viewData .= "        <TD class=\"td_cm\">{$cp_title[$i]}</TD>\n";
		$viewData .= "        <TD>\n";
		$viewData .= "          <INPUT type=\"submit\" name=\"go_mnt_2\" value=\"修正\" class=\"btn\" />\n";
		$viewData .= "          <INPUT type=\"hidden\" name=\"mode\" value=\"EDIT\" />\n";
		$viewData .= "          <INPUT type=\"hidden\" name=\"cp_id\" value=\"{$cp_id[$i]}\" />\n";
		$viewData .= "          <INPUT type=\"hidden\" name=\"stpos\" value=\"{$_POST['stpos']}\" />\n";
		$viewData .= "        </TD>\n";
		$viewData .= "        </FORM>\n";
		$viewData .= "        <FORM method=\"POST\" action=\"../camarticle/camarticle_main.php\" target=\"_self\">\n";
		$viewData .= "        <TD>\n";
		$viewData .= "          <INPUT type=\"submit\" value=\"自由記事\" class=\"btn\" />\n";
		$viewData .= "          <INPUT type=\"hidden\" name=\"cp_id\" value=\"{$cp_id[$i]}\" />\n";
		$viewData .= "          <INPUT type=\"hidden\" name=\"stpos\" value=\"{$_POST['stpos']}\" />\n";
		$viewData .= "        </TD>\n";
		$viewData .= "        </FORM>\n";
		$viewData .= "      </TR>\n";

	}
}


/*----------------------------------------------------------
   ページ遷移用
----------------------------------------------------------*/
$intPageNum = $intTotal / $intGetNum;
IF( !strpos( $intPageNum , "." ) ){
	$intPageNum = (int)$intPageNum;
}ELSE{
	$intPageNum = (int)$intPageNum + 1;
}
$intEdPos = $intGetNum + $intStPos - 1;
IF( $intEdPos > $intTotal ) $intEdPos = $intTotal;
$viewPageChangeValue = basecom_page_change_VAL( $intCnt , $intTotal , $intGetNum , $intStPos , $intCnt , $intPageNum , "cp_page" , "stpos" , "btn_nosize" );


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
    <TITLE>塾ブログ - アカウント管理ツール</TITLE>
    <META http-equiv="Content-Type" content="text/html;charset=EUC-JP" />
    <META http-equiv="Content-Style-Type" content="text/css" />
    <META http-equiv="Content-Script-Type" content="text/javascript" />
    <LINK rel="stylesheet" type="text/css" href="../share/css/campain.css" />
    <NOSCRIPT><META http-equiv="Refresh" content="1;URL=../jserror.html"></NOSCRIPT>
  </HEAD>
  <BODY>
    <IMG src="../share/images/campain_title.gif" alt="講習・イベント自由記事見出し登録" />
    <HR color="#96BC69" />
    <DIV id="title2">■講習・イベント自由記事見出し登録</DIV>
    <TABLE>
      <TR>
        <FORM action="campain_mnt.php" method="POST">
        <TD><INPUT type="submit" name="new" value="記事を書く" class="btn" /></TD>
        <INPUT type="hidden" name="mode" value="NEW" />
        <INPUT type="hidden" name="stpos" value="<?=$_POST['stpos']?>" />
        </FORM>
      </TR>
    </TABLE>
    <BR />
    <TABLE>
      <TR>
        <TD class="td_cl_nosize" width="100">状態</TD>
        <TD class="td_cl_nosize" width="250">講習・イベント自由記事 見出し</TD>
        <TD class="td_cl">&nbsp;</TD>
        <TD class="td_cl">&nbsp;</TD>
      </TR>
<?=$viewData?>
    </TABLE>
    <BR />
    <TABLE border="0" cellspacing="0" cellpadding="2" width="700" class="px12">
      <TR>
        <FORM name="cp_page" method="POST" action="campain_main.php">
<?=$viewPageChangeValue?>
        <INPUT type="hidden" name="stpos" value="" />
        </FORM>
      </TR>
    </TABLE>
  </BODY>
</HTML>
