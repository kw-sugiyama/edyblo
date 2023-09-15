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
require_once ( SYS_PATH."dbif/basedb_SchoolClass.php" );
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
	/**************************************
	  教室基本情報検索
	**************************************/
	$obj2 = new basedb_SchoolClassTblAccess;
	$obj2->conn = $obj_conn->conn;
	$obj2->jyoken["sc_deldate"] = 1;
	$obj2->jyoken["sc_clid"] = $_SESSION['_cl_id'];
	list( $num , $intTotal ) = $obj2->basedb_GetSchool( 1 , -1 );
	IF( $nmu == -1 ){
		$arrOther["ath_comment"] = "<INPUT TYPE=\"hidden\" NAME=\"stpos\" VALUE=\"{$_POST['stpos']}\">";
		$obj_error->ViewErrMessage( "SYSTEM" , "ALL" , SITE_PATH."blank.php" , $arrOther );
		exit;
	}


	$sc_id = htmlspecialchars($obj2->blogdat[0]["sc_id"]);
	$sc_upddate = htmlspecialchars($obj2->blogdat[0]["sc_upddate"]);

	$layout_menu = array($obj2->blogdat[0]["sc_layout1"],$obj2->blogdat[0]["sc_layout2"],$obj2->blogdat[0]["sc_layout3"],$obj2->blogdat[0]["sc_layout4"]);
	$layout_main = array($obj2->blogdat[0]["sc_layout5"],$obj2->blogdat[0]["sc_layout6"],$obj2->blogdat[0]["sc_layout7"],$obj2->blogdat[0]["sc_layout8"],$obj2->blogdat[0]["sc_layout9"]);

if($layout_menu[0] == 1){
	$layout_menu1 = 1;
}else if($layout_menu[0] == 2){
	$layout_menu2 = 1;
}else if($layout_menu[0] == 3){
	$layout_menu3 = 1;
}else if($layout_menu[0] == 4){
	$layout_menu4 = 1;
}

if($layout_menu[1] == 1){
	$layout_menu1 = 2;
}else if($layout_menu[1] == 2){
	$layout_menu2 = 2;
}else if($layout_menu[1] == 3){
	$layout_menu3 = 2;
}else if($layout_menu[1] == 4){
	$layout_menu4 = 2;
}

if($layout_menu[2] == 1){
	$layout_menu1 = 3;
}else if($layout_menu[2] == 2){
	$layout_menu2 = 3;
}else if($layout_menu[2] == 3){
	$layout_menu3 = 3;
}else if($layout_menu[2] == 4){
	$layout_menu4 = 3;
}

if($layout_menu[3] == 1){
	$layout_menu1 = 4;
}else if($layout_menu[3] == 2){
	$layout_menu2 = 4;
}else if($layout_menu[3] == 3){
	$layout_menu3 = 4;
}else if($layout_menu[3] == 4){
	$layout_menu4 = 4;
}

if($layout_main[0] == 1){
	$layout_main1 = 1;
}else if($layout_main[0] == 2){
	$layout_main2 = 1;
}else if($layout_main[0] == 3){
	$layout_main3 = 1;
}else if($layout_main[0] == 4){
	$layout_main4 = 1;
}

if($layout_main[1] == 1){
	$layout_main1 = 2;
}else if($layout_main[1] == 2){
	$layout_main2 = 2;
}else if($layout_main[1] == 3){
	$layout_main3 = 2;
}else if($layout_main[1] == 4){
	$layout_main4 = 2;
}

if($layout_main[2] == 1){
	$layout_main1 = 3;
}else if($layout_main[2] == 2){
	$layout_main2 = 3;
}else if($layout_main[2] == 3){
	$layout_main3 = 3;
}else if($layout_main[2] == 4){
	$layout_main4 = 3;
}

if($layout_main[3] == 1){
	$layout_main1 = 4;
}else if($layout_main[3] == 2){
	$layout_main2 = 4;
}else if($layout_main[3] == 3){
	$layout_main3 = 4;
}else if($layout_main[3] == 4){
	$layout_main4 = 4;
}

	// TOP左メニューレイアウト１
	asort( $param_layout_menu["disp_no"] );
	$madori_value = "";
	FOREACH( $param_layout_menu["disp_no"] as $key => $val ){
		$selected = "";
		if($param_layout_menu['id'][$key] == $layout_menu1)$selected = "selected";
		$layout_menu_val1 .= "<OPTION VALUE=\"{$param_layout_menu['id'][$key]}\" {$selected}>{$param_layout_menu['val'][$key]}</OPTION>\n";	
	}

	// TOP左メニューレイアウト２
	asort( $param_layout_menu["disp_no"] );
	$madori_value = "";
	FOREACH( $param_layout_menu["disp_no"] as $key => $val ){
		$selected = "";
		if($param_layout_menu['id'][$key] == $layout_menu2)$selected = "selected";
		$layout_menu_val2 .= "<OPTION VALUE=\"{$param_layout_menu['id'][$key]}\" {$selected}>{$param_layout_menu['val'][$key]}</OPTION>\n";	
	}

	// TOP左メニューレイアウト３
	asort( $param_layout_menu["disp_no"] );
	$madori_value = "";
	FOREACH( $param_layout_menu["disp_no"] as $key => $val ){
		$selected = "";
		if($param_layout_menu['id'][$key] == $layout_menu3)$selected = "selected";
		$layout_menu_val3 .= "<OPTION VALUE=\"{$param_layout_menu['id'][$key]}\" {$selected}>{$param_layout_menu['val'][$key]}</OPTION>\n";	
	}

	// TOP左メニューレイアウト４
	asort( $param_layout_menu["disp_no"] );
	$madori_value = "";
	FOREACH( $param_layout_menu["disp_no"] as $key => $val ){
		$selected = "";
		if($param_layout_menu['id'][$key] == $layout_menu4)$selected = "selected";
		$layout_menu_val4 .= "<OPTION VALUE=\"{$param_layout_menu['id'][$key]}\" {$selected}>{$param_layout_menu['val'][$key]}</OPTION>\n";	
	}

	// TOPメインレイアウト１
	asort( $param_layout_main["disp_no"] );
	$madori_value = "";
	FOREACH( $param_layout_main["disp_no"] as $key => $val ){
		$selected = "";
		if($param_layout_main['id'][$key] == $layout_main1)$selected = "selected";
		$layout_main_val1 .= "<OPTION VALUE=\"{$param_layout_main['id'][$key]}\" {$selected}>{$param_layout_main['val'][$key]}</OPTION>\n";	
	}

	// TOPメインレイアウト２
	asort( $param_layout_main["disp_no"] );
	$madori_value = "";
	FOREACH( $param_layout_main["disp_no"] as $key => $val ){
		$selected = "";
		if($param_layout_main['id'][$key] == $layout_main2)$selected = "selected";
		$layout_main_val2 .= "<OPTION VALUE=\"{$param_layout_main['id'][$key]}\" {$selected}>{$param_layout_main['val'][$key]}</OPTION>\n";	
	}

	// TOPメインレイアウト３
	asort( $param_layout_main["disp_no"] );
	$madori_value = "";
	FOREACH( $param_layout_main["disp_no"] as $key => $val ){
		$selected = "";
		if($param_layout_main['id'][$key] == $layout_main3)$selected = "selected";
		$layout_main_val3 .= "<OPTION VALUE=\"{$param_layout_main['id'][$key]}\" {$selected}>{$param_layout_main['val'][$key]}</OPTION>\n";	
	}

	// TOPメインレイアウト４
	asort( $param_layout_main["disp_no"] );
	$madori_value = "";
	FOREACH( $param_layout_main["disp_no"] as $key => $val ){
		$selected = "";
		if($param_layout_main['id'][$key] == $layout_main4)$selected = "selected";
		$layout_main_val4 .= "<OPTION VALUE=\"{$param_layout_main['id'][$key]}\" {$selected}>{$param_layout_main['val'][$key]}</OPTION>\n";	
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
    <LINK rel="stylesheet" type="text/css" href="../share/css/menubase.css" />
    <SCRIPT type="text/javascript" src="../share/js/category.js"></SCRIPT>
    <SCRIPT type="text/javascript" src="../share/js/Layout.js"></SCRIPT>
    <NOSCRIPT><META http-equiv="Refresh" content="1;URL=../jserror.html"></NOSCRIPT>
  </HEAD>
  <BODY>
<FORM name="go_company" method="POST" action="../cl/cl_main.php" target="_self">
</form>
<FORM name="go_leftmenu" method="POST" action="../dai_leftmenu/leftmenu_main.php" target="_self">
</form>
<FORM name="go_blog" method="POST" action="../blog/blog_main.php" target="_self">
</form>
<table style="width:100%">
  <tr>
    <td style="width:20%">
        <IMG src="../share/images/layout_title.gif" alt="ＴＯＰ画面レイアウト情報登録" />
    </td>
    <td style="width:80%;text-align:right;">
      <INPUT type="button" value="クライアント情報修正" class="btn_nosize_grey" onclick="document.go_company.submit();return false;"/>&nbsp;
      <INPUT type="button" value="基本設定" class="btn_nosize_grey" onclick="document.go_blog.submit();return false;"/>
      <INPUT type="button" value="左メニュー登録" class="btn_nosize_grey" onclick="document.go_leftmenu.submit();return false;"/>
    </td>
  </tr>
</table>
    <HR color="#96BC69" />
    <DIV id="title2">■ＴＯＰ画面レイアウト情報登録</DIV>
    <TABLE>
      <FORM action="layout_upd.php" method="POST" onsubmit="return dispSet(<?=$intTotal?>)" name="disp_set">
      <TR>
        <td colspan="2" style="width:572px"><img src="../share/images/layout_header.jpg"></td>
      </TR>
      <TR>
        <td style="width:200px;background-color:#94D7E8;text-align:center;">
          <select name="sc_layout1">
<?=$layout_menu_val1?>
          </select>
        </td>
        <td style="width:372px;text-align:center;">
          <select name="sc_layout5">
<?=$layout_main_val1?>
          </select>
        </td>
      </TR>
      <TR>
        <td style="width:200px;background-color:#94D7E8;text-align:center;">
          <select name="sc_layout2">
<?=$layout_menu_val2?>
          </select>
        </td>
        <td style="width:372px;text-align:center;">
          <select name="sc_layout6">
<?=$layout_main_val2?>
          </select>
        </td>
      </TR>
      <TR>
        <td style="width:200px;background-color:#94D7E8;text-align:center;">
          <select name="sc_layout3">
<?=$layout_menu_val3?>
          </select>
        </td>
        <td style="width:372px;text-align:center;">
          <select name="sc_layout7">
<?=$layout_main_val3?>
          </select>
        </td>
      </TR>
      <TR>
        <td style="width:200px;background-color:#94D7E8;text-align:center;">
          <select name="sc_layout4">
<?=$layout_menu_val4?>
          </select>
        </td>
        <td style="width:372px;text-align:center;">
          <select name="sc_layout8">
<?=$layout_main_val4?>
          </select>
        </td>
      </TR>
<!--
      <TR>
        <td style="width:200px;background-color:#94D7E8;text-align:center;"></td>
        <td style="width:372px;text-align:center;">
          <select name="sc_layout9">
<?=$layout_main_val5?>
          </select>
        </td>
      </TR>
//-->
      <TR>
        <td colspan="2" style="width:572px">
          <img src="../share/images/layout_footer.jpg">
          <input type="hidden" name="sc_id" value="<?=$sc_id?>">
          <input type="hidden" name="sc_upddate" value="<?=$sc_upddate?>">
        </td>
      </TR>
      <TR>
        <TD style="text-align:center;" colspan="2"><INPUT type="button" name="new" value="ＴＯＰ画面レイアウト情報を修正する" class="btn_nosize" onclick="return LayoutInputCheck( this.form , this.form )"/></TD>
      </TR>
      </FORM>
    </TABLE>
    <BR />
  </BODY>
</HTML>
