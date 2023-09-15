<?
/******************************************************************************
<< 不動産ブログ　Ver.1.O.0 >>
	Name: cl_main.php
	Version: 1.0.0
	Function: クライアント登録情報一覧
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
require_once ( SYS_PATH."dbif/basedb_AreaClass.php" );
require_once ( SYS_PATH."common/error.class.php" );
require_once ( SYS_PATH."common/sys_common.php" );
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
$obj = new basedb_ClientClassTblAccess;
$obj->conn = $obj_conn->conn;
$obj->jyoken["cl_deldate"] = 1;
$obj->jyoken["cl_id"] = $_SESSION["_cl_id"];
list( $num , $total ) = $obj->basedb_GetClient( 1 , -1 );
IF( $num != 1 ){
	$obj_error->ViewErrMessage( "SYSTEM" , "ALL" , SITE_PATH."blank.php" , $arrOther );
	exit;
}


// 指定クライアントIDを検索
$obj_area = new basedb_AreaClassTblAccess;
$obj_area->conn = $obj_conn->conn;
$obj_area->jyoken["ar_clid"] = $_SESSION['_cl_id'];
$obj_area->jyoken["ar_flg"] = 1;
list( $areanum , $areatotal ) = $obj_area->basedb_GetArea( 1 , -1 );
IF( $areanum == -1 ){
echo("b");
	$obj_error->ViewErrMessage( "SYSTEM" , "ALL" , "client_main.php" , NULL );
	exit;
}
$zipcode = split( "-" , $obj_area->areadat[0]['ar_zip'] );
$arrPostView["ar_zip1"] = $zipcode[0];
$arrPostView["ar_zip2"] = $zipcode[1];
if($arrPostView["ar_zip1"]!="" && $arrPostView["ar_zip2"]!="")$zip_val = "〒".$arrPostView["ar_zip1"]."-".$arrPostView["ar_zip2"];


// 指定クライアントIDを検索
$obj_area2 = new basedb_AreaClassTblAccess;
$obj_area2->conn = $obj_conn->conn;
$obj_area2->jyoken["ar_clid"] = $_SESSION['_cl_id'];
$obj_area2->jyoken["ar_flg"] = 2;
list( $areanum , $areatotal ) = $obj_area2->basedb_GetArea( 1 , -1 );
IF( $areanum == -1 ){
echo("b");
	$obj_error->ViewErrMessage( "SYSTEM" , "ALL" , "client_main.php" , NULL );
	exit;
}
$zipcode2 = split( "-" , $obj_area2->areadat[0]['ar_zip'] );
$arrPostView2["ar_zip1"] = $zipcode2[0];
$arrPostView2["ar_zip2"] = $zipcode2[1];
if($arrPostView2["ar_zip1"]!="" && $arrPostView2["ar_zip2"]!="")$zip_val2 = "〒".$arrPostView2["ar_zip1"]."-".$arrPostView2["ar_zip2"];


// 指定クライアントIDを検索
$obj_area3 = new basedb_AreaClassTblAccess;
$obj_area3->conn = $obj_conn->conn;
$obj_area3->jyoken["ar_clid"] = $_SESSION['_cl_id'];
$obj_area3->jyoken["ar_flg"] = 3;
list( $areanum , $areatotal ) = $obj_area3->basedb_GetArea( 1 , -1 );
IF( $areanum == -1 ){
echo("b");
	$obj_error->ViewErrMessage( "SYSTEM" , "ALL" , "client_main.php" , NULL );
	exit;
}
$zipcode3 = split( "-" , $obj_area3->areadat[0]['ar_zip'] );
$arrPostView3["ar_zip1"] = $zipcode3[0];
$arrPostView3["ar_zip2"] = $zipcode3[1];
if($arrPostView3["ar_zip1"]!="" && $arrPostView3["ar_zip2"]!="")$zip_val3 = "〒".$arrPostView3["ar_zip1"]."-".$arrPostView3["ar_zip2"];


// 指定クライアントIDを検索
$obj_area4 = new basedb_AreaClassTblAccess;
$obj_area4->conn = $obj_conn->conn;
$obj_area4->jyoken["ar_clid"] = $_SESSION['_cl_id'];
$obj_area4->jyoken["ar_flg"] = 4;
list( $areanum , $areatotal ) = $obj_area4->basedb_GetArea( 1 , -1 );
IF( $areanum == -1 ){
echo("b");
	$obj_error->ViewErrMessage( "SYSTEM" , "ALL" , "client_main.php" , NULL );
	exit;
}
$zipcode4 = split( "-" , $obj_area4->areadat[0]['ar_zip'] );
$arrPostView4["ar_zip1"] = $zipcode4[0];
$arrPostView4["ar_zip2"] = $zipcode4[1];
if($arrPostView4["ar_zip1"]!="" && $arrPostView4["ar_zip2"]!="")$zip_val4 = "〒".$arrPostView4["ar_zip1"]."-".$arrPostView4["ar_zip2"];

/*----------------------------------------------------------
  ＤＢ切断
----------------------------------------------------------*/
require_once( SYS_PATH."common/db_close.php" );


/*--------------------------------------------------------
  一覧表示内容生成
--------------------------------------------------------*/
$viewData["cl_login_id"] = htmlspecialchars( $obj->clientdat[0]["cl_loginid"] );
$viewData["cl_login_pass"] = htmlspecialchars( $obj->clientdat[0]["cl_passwd"] );
$viewData["cl_name"] = htmlspecialchars( $obj->clientdat[0]["cl_jname"] );
$viewData["cl_shiten"] = htmlspecialchars( $obj->clientdat[0]["cl_kname"] );
$viewData["cl_agent"] = htmlspecialchars( $obj->clientdat[0]["cl_agent"] );
$viewData["cl_agent_mail"] = htmlspecialchars( $obj->clientdat[0]["cl_mail"] );
$viewData["cl_zip"] = htmlspecialchars( $obj->clientdat[0]["cl_zip"] );
$viewData["cl_pref"] = htmlspecialchars( $obj->clientdat[0]["cl_pref"] );
$viewData["cl_address1"] = htmlspecialchars( $obj->clientdat[0]["cl_city"] );
$viewData["cl_address2"] = htmlspecialchars( $obj->clientdat[0]["cl_add"] );
$viewData["cl_address3"] = htmlspecialchars( $obj->clientdat[0]["cl_estate"] );
$viewData["cl_tell"] = htmlspecialchars( $obj->clientdat[0]["cl_phone"] );
$viewData["cl_fax"] = htmlspecialchars( $obj->clientdat[0]["cl_fax"] );
IF( $obj->clientdat[0]["cl_end"] != "" ){
	$arrWeekName = Array( "日" , "月" , "火" , "水" , "木" , "金" , "土" );
	$intWeek = date( "w" , strtotime($obj->clientdat[0]["cl_end"]) );
	$arrBuffLimit = explode( "-" , $obj->clientdat[0]["cl_end"] );
	$viewData["cl_limit_date"] = $arrBuffLimit[0]."年".$arrBuffLimit[1]."月".$arrBuffLimit[2]."日（".$arrWeekName[$intWeek]."）";
}ELSE{
	$viewData["cl_limit_date"] = "期限なし";
}


/*--------------------------------------------------------
	ＨＴＭＬ生成
--------------------------------------------------------*/
?>
<HTML>
  <HEAD>
    <TITLE>塾ブログ - クライアントツール</TITLE>
    <META http-equiv="Content-Type" content="text/html;charset=EUC-JP" />
    <META http-equiv="Content-Style-Type" content="text/css" />
    <META http-equiv="Content-Script-Type" content="text/javascript" />
    <LINK rel="stylesheet" type="text/css" href="../share/css/cl.css" />
    <NOSCRIPT><META http-equiv="Refresh" content="1;URL=../jserror.html"></NOSCRIPT>
  </HEAD>
  <BODY>
<FORM name="go_leftmenu" method="POST" action="../dai_leftmenu/leftmenu_main.php" target="_self">
</form>
<FORM name="go_layout" method="POST" action="../layout/layout_main.php" target="_self">
</form>
<FORM name="go_blog" method="POST" action="../blog/blog_main.php" target="_self">
</form>
<table style="width:100%">
  <tr>
	 <td style="width:20%">
<span style="font-size:15px;color:#6BD7B5;">クライアント情報修正</spann>
    </td>
    <td style="width:80%;text-align:right;">
      <INPUT type="button" value="基本設定" class="btn_nosize_grey" onclick="document.go_blog.submit();return false;"/>
      <INPUT type="button" value="TOP画面レイアウト" class="btn_nosize_grey" onclick="document.go_layout.submit();return false;"/>&nbsp;
      <INPUT type="button" value="左メニュー登録" class="btn_nosize_grey" onclick="document.go_leftmenu.submit();return false;"/>
    </td>
  </tr>
</table>

    <HR color="#96BC69" />
    <FONT size="-1">
      現在以下の内容で登録されています。<br />
      登録内容が変更された場合には管理者までメールで通知されます。
    </FONT>
    <br /><br />
    <DIV id="title2">■基本情報</DIV>
    <DIV id="client">
      <TABLE>
        <TR>
          <TH>塾名</TH>
          <TD><?=$viewData["cl_name"]?></TD>
        </TR>
        <TR>
          <TH>教室名</TH>
          <TD><?=$viewData["cl_shiten"]?></TD>
        </TR>
        <TR>
          <TH>担当者名</TH>
          <TD><?=$viewData["cl_agent"]?></TD>
        </TR>
        <TR>
          <TH>住所</TH>
          <TD>
            <?=$zip_val?>　<?=$obj_area->areadat[0]['ar_pref']?><?=$obj_area->areadat[0]['ar_city']?><?=$obj_area->areadat[0]['ar_add']?> <?=$obj_area->areadat[0]['ar_estate']?><br>
            <?=$zip_val2?>　<?=$obj_area2->areadat[0]['ar_pref']?><?=$obj_area2->areadat[0]['ar_city']?><br>
            <?=$zip_val3?>　<?=$obj_area3->areadat[0]['ar_pref']?><?=$obj_area3->areadat[0]['ar_city']?><br>
            <?=$zip_val4?>　<?=$obj_area4->areadat[0]['ar_pref']?><?=$obj_area4->areadat[0]['ar_city']?>
          </TD>
        </TR>
        <TR>
          <TH>電話番号</TH>
          <TD><?=$viewData["cl_tell"]?></TD>
        </TR>
        <TR>
          <TH>FAX番号</TH>
          <TD><?=$viewData["cl_fax"]?></TD>
        </TR>
        <TR>
          <TH>担当者Eメール</TH>
          <TD><?=$viewData["cl_agent_mail"]?></TD>
        </TR>
        <TR>
          <TH>ログインID</TH>
          <TD><?=$viewData["cl_login_id"]?></TD>
        </TR>
        <TR>
          <TH>パスワード</TH>
          <TD><?=$viewData["cl_login_pass"]?></TD>
        </TR>
        <TR>
          <TH>使用期限</TH>
          <TD><?=$viewData["cl_limit_date"]?></TD>
        </TR>
      </TABLE>
    </DIV>
    <br />
    <TABLE>
      <TR>
        <FORM name="go_mnt" method="POST" action="cl_mnt.php" target="_self">
		  <TD><INPUT type="submit" value="クライアント情報を修正する　" style="width:180" class="btn"/></TD>
        <INPUT type="hidden" name="cl_id" value="<?=$_SESSION['_cl_id']?>" />
        </FORM>
      </TR>
    </TABLE>
  </BODY>
</HTML>
