<?
/******************************************************************************
<< 不動産ブログ　Ver.1.O.0 >>
	Name: blog_main.php
	Version: 1.0.0
	Function: ブログ基本設定情報一覧
	Author: Click inc
	Date of creation: 2007/02
	History of modification:

	Copyright (C)2007 Click, inc. All Rights Reserverd.
******************************************************************************/

/*----------------------------------------------------------
  必要ファイル呼び出し
----------------------------------------------------------*/
require_once ( "../ini_sets_2.php" );
require_once ( "../html_replace.php" );
require_once ( SYS_PATH."dbif/dbcom_DBconnectClass.php" );
require_once ( SYS_PATH."dbif/basedb_ClientClass.php" );
require_once ( SYS_PATH."dbif/basedb_SchoolClass.php" );
require_once ( SYS_PATH."dbif/basedb_EnsenClass.php" );
require_once ( SYS_PATH."common/base_common.php" );
require_once ( SYS_PATH."common/sys_common.php" );
require_once ( SYS_PATH."common/error.class.php" );
require_once ( SYS_PATH."configs/param_base.conf" );
require_once ( SYS_PATH."configs/param_file.conf" );
require_once ( SYS_PATH."configs/param_blog.conf" );
require_once ( SYS_PATH."configs/param_map.conf" );


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
$obj = new basedb_SchoolClassTblAccess;
$obj->conn = $obj_conn->conn;
$obj->jyoken["sc_deldate"] = 1;
$obj->jyoken["sc_clid"] = $_SESSION["_cl_id"];
list( $intNum , $intTotal ) = $obj->basedb_GetSchool( 1 , -1 );
IF( $intNum == -1 ){
	$arrOther["ath_comment"] = "<INPUT TYPE=\"hidden\" NAME=\"stpos\" VALUE=\"{$_POST['stpos']}\">";
	$obj_error->ViewErrMessage( "SYSTEM" , "ALL" , SITE_PATH."blank.php" , $arrOther );
	exit;
}

$obj2 = new basedb_EnsenClassTblAccess;
$obj2->conn = $obj_conn->conn;
$obj2->jyoken["es_deldate"] = 1;
$obj2->jyoken["es_cd"] = $obj->blogdat[0]["sc_clid"];
$obj2->sort["es_dispno"] = 1;
list( $intNum , $intTotal ) = $obj2->basedb_GetEnsen( 1 , -1 );
IF( $intNum == -1 ){
	$arrOther["ath_comment"] = "<INPUT TYPE=\"hidden\" NAME=\"stpos\" VALUE=\"{$_POST['stpos']}\">";
	$obj_error->ViewErrMessage( "SYSTEM" , "ALL" , SITE_PATH."blank.php" , $arrOther );
	exit;
}


/*----------------------------------------------------------
  ＤＢ切断
----------------------------------------------------------*/
require_once( SYS_PATH."common/db_close.php" );


/*--------------------------------------------------------
  一覧表示内容生成
--------------------------------------------------------*/
$sc_title = htmlspecialchars ($obj->blogdat[0]["sc_title"]);
$sc_keywd = htmlspecialchars( str_replace( "-" , "," , $obj->blogdat[0]["sc_keywd"] ) );
$sc_introduce = str_replace("\r\n","<BR>",htmlspecialchars( $obj->blogdat[0]["sc_introduce"] ));
$sc_clr = htmlspecialchars ($obj->blogdat[0]["sc_clr"]);
IF( $sc_clr != "" ){
	FOREACH( $param_blog_color["id"] as $key => $val ){
		IF( $param_blog_color["id"][$key] == $sc_clr ){
			$sc_clr = "<IMG src=\"{$param_blog_color_path}{$param_blog_color["img"][$key]}\" alt=\"{$param_blog_color["val"][$key]}\" border=\"0\" />";
			break;
		}
	}
}

$sc_master = htmlspecialchars ($obj->blogdat[0]["sc_master"]);
$sc_position = htmlspecialchars ($obj->blogdat[0]["sc_position"]);


$sc_company = htmlspecialchars ($obj->blogdat[0]["sc_company"]);
$sc_topwindowtitle = htmlspecialchars ($obj->blogdat[0]["sc_topwindowtitle"]);
$sc_headertitle = htmlspecialchars ($obj->blogdat[0]["sc_headertitle"]);
$sc_toptitle = htmlspecialchars ($obj->blogdat[0]["sc_toptitle"]);
$sc_topsubtitle = htmlspecialchars ($obj->blogdat[0]["sc_topsubtitle"]);
$sc_campaintitle = htmlspecialchars ($obj->blogdat[0]["sc_campaintitle"]);
$sc_coursetitle = htmlspecialchars ($obj->blogdat[0]["sc_coursetitle"]);
$sc_diarytitle = htmlspecialchars ($obj->blogdat[0]["sc_diarytitle"]);
$sc_addmission = nl2br(htmlspecialchars ($obj->blogdat[0]["sc_addmission"]));


$sc_age = htmlspecialchars ($obj->blogdat[0]["sc_age"]);
if(($sc_age & 64) == 64 ){
	$ageValue .= "社会人　";
	$sc_age -= 64;
}
if(($sc_age & 32) == 32 ){
	$ageValue .= "大学生　";
	$sc_age -= 32;
}
if(($sc_age & 16) == 16 ){
	$ageValue .= "浪人生　";
	$sc_age -= 16;
}
if(($sc_age & 8) == 8 ){
	$ageValue .= "高校生　";
	$sc_age -= 8;
}
if(($sc_age & 4) == 4 ){
	$ageValue .= "中学生　";
	$sc_age -= 4;
}
if(($sc_age & 2) == 2 ){
	$ageValue .= "小学生　";
	$sc_age -= 2;
}
if(($sc_age & 1) == 1 ){
	$ageValue .= "幼児　";
	$sc_age -= 1;
}

$sc_classform = htmlspecialchars ($obj->blogdat[0]["sc_classform"]);
if($sc_classform & 4)$classformValue .= "個別 ";
if($sc_classform & 2)$classformValue .= "少人数 ";
if($sc_classform & 1)$classformValue .= "集団";

$sc_results = htmlspecialchars ($obj->blogdat[0]["sc_results"]);
$sc_students = htmlspecialchars ($obj->blogdat[0]["sc_students"]);


$sc_entrymail = htmlspecialchars ($obj->blogdat[0]["sc_entrymail"]);
$sc_infomail = htmlspecialchars ($obj->blogdat[0]["sc_infomail"]);
$sc_infomail2 = htmlspecialchars ($obj->blogdat[0]["sc_infomail2"]);
$sc_entrymail2= htmlspecialchars ($obj->blogdat[0]["sc_entrymail2"]);



$sc_start = htmlspecialchars ($obj->blogdat[0]["sc_start"]);
$sc_end = htmlspecialchars ($obj->blogdat[0]["sc_end"]);
IF( $sc_start != "" || $sc_start != "" ){
	$sc_end = $sc_start." 〜 ".$sc_end;
}
$sc_holiday = htmlspecialchars( $obj->blogdat[0]["sc_holiday"] );
$sc_hp = htmlspecialchars( $obj->blogdat[0]["sc_hp"] );

$sc_pr = nl2br(htmlspecialchars($obj->blogdat[0]["sc_pr"]));


$sc_privacy = str_replace("\r\n","<BR>",htmlspecialchars ($obj->blogdat[0]["sc_privacy"]));
$sc_movie = htmlspecialchars($obj->blogdat[0]["sc_movie"]);
$sc_rhtml = $obj->blogdat[0]["sc_rhtml"];
$sc_rhtml = html_replace( $sc_rhtml , "" , "" , "" , "" );
$sc_rhtml = nl2br($sc_rhtml);
$sc_lhtml = $obj->blogdat[0]["sc_lhtml"];
$sc_lhtml = html_replace( $sc_lhtml , "" , "" , "" , "" );
$sc_lhtml = nl2br($sc_lhtml);
//hatori================================================

$sc_thtml = nl2br($obj->blogdat[0]["sc_thtml"]);

//================================================
if($obj->blogdat[0]["sc_logo"] != ""){
	$sc_logo = "<IMG src=\"./img_thumbnail.php?w=200&h=60&dir={$param_cl_logo_path}&nm={$obj->blogdat[0]["sc_logo"]}\" border=\"1\" />";
}else{
	$sc_logo = "";
}

//================================================
if($obj->blogdat[0]["sc_logo_mobile"] != ""){
	$sc_logo_mobile= "<IMG src=\"./img_thumbnail.php?w=200&h=60&dir={$param_cl_logo_mobile_path}&nm={$obj->blogdat[0]["sc_logo_mobile"]}\" border=\"1\" />";
}else{
	$sc_logo_mobile= "";
}


//print_r($obj->blogdat[0]);
//================================================
if($obj->blogdat[0]["sc_topimg"] != ""){
	$sc_topimg = "<IMG src=\"./img_thumbnail.php?w=360&h=360&dir={$param_cl_photo_path}&nm={$obj->blogdat[0]["sc_topimg"]}\" border=\"1\" />";
}else{
	$sc_topimg = "";
}
if($obj->blogdat[0]["sc_mapimg"] != ""){
	$sc_mapimg = "<IMG src=\"./img_thumbnail.php?w=360&h=360&dir={$param_cl_staff_path}&nm={$obj->blogdat[0]["sc_mapimg"]}\" border=\"1\" />";
}else{
	$sc_mapimg = "";
}
if($obj->blogdat[0]["sc_ido"] != "" && $obj->blogdat[0]["sc_ido"] != null){
	$sc_ido = $obj->blogdat[0]["sc_ido"];
	$sc_keido = $obj->blogdat[0]["sc_keido"];
	$sc_zoom = $obj->blogdat[0]["sc_zoom"];
}

foreach($obj2->ensendat as $key2 => $val2){
	$es_id[$val2["es_dispno"]] = htmlspecialchars ($val2["es_id"]);
	$es_cd[$val2["es_dispno"]] = htmlspecialchars ($val2["es_cd"]);
	$es_type[$val2["es_dispno"]] = htmlspecialchars ($val2["es_type"]);
	$es_dispno[$val2["es_dispno"]] = htmlspecialchars ($val2["es_dispno"]);
	$es_pref[$val2["es_dispno"]] = htmlspecialchars ($val2["es_pref"]);
	$es_line[$val2["es_dispno"]] = htmlspecialchars ($val2["es_line"]);
	$es_linecd[$val2["es_dispno"]] = htmlspecialchars ($val2["es_linecd"]);
	$es_sta[$val2["es_dispno"]] = htmlspecialchars ($val2["es_sta"]);
	$es_stacd[$val2["es_dispno"]] = htmlspecialchars ($val2["es_stacd"]);
	$es_walk[$val2["es_dispno"]] = htmlspecialchars ($val2["es_walk"]);
	$es_bus[$val2["es_dispno"]] = htmlspecialchars ($val2["es_bus"]);
	$es_biko[$val2["es_dispno"]] = htmlspecialchars ($val2["es_biko"]);
	$es_adminid[$val2["es_dispno"]] = htmlspecialchars ($val2["es_adminid"]);
	$es_insdate[$val2["es_dispno"]] = htmlspecialchars ($val2["es_insdate"]);
	$es_upddate[$val2["es_dispno"]] = htmlspecialchars ($val2["es_upddate"]);
	$es_deldate[$val2["es_dispno"]] = htmlspecialchars ($val2["es_deldate"]);
	$es_yobi1[$val2["es_dispno"]] = htmlspecialchars ($val2["es_yobi1"]);
	$es_yobi2[$val2["es_dispno"]] = htmlspecialchars ($val2["es_yobi2"]);
	$es_yobi3[$val2["es_dispno"]] = htmlspecialchars ($val2["es_yobi3"]);
	$es_yobi4[$val2["es_dispno"]] = htmlspecialchars ($val2["es_yobi4"]);
	$es_yobi5[$val2["es_dispno"]] = htmlspecialchars ($val2["es_yobi5"]);
}
if($es_line[1]!=""){
	$moyori1 = $es_line[1].$es_sta[1]."駅　徒歩".$es_walk[1]."分";
	if($es_bus[1]!="")$moyori1 .= "　バス".$es_bus[1]."分";
}
if($es_line[2]!=""){
	$moyori2 = $es_line[2].$es_sta[2]."駅　徒歩".$es_walk[2]."分";
	if($es_bus[2]!="")$moyori2 .= "　バス".$es_bus[2]."分";
}
if($es_line[3]!=""){
	$moyori3 = $es_line[3].$es_sta[3]."駅　徒歩".$es_walk[3]."分";
	if($es_bus[3]!="")$moyori3 .= "　バス".$es_bus[3]."分";
}
if($es_line[4]!=""){
	$moyori4 = $es_line[4].$es_sta[4]."駅　徒歩".$es_walk[4]."分";
	if($es_bus[4]!="")$moyori4 .= "　バス".$es_bus[4]."分";
}
if($es_line[5]!=""){
	$moyori5 = $es_line[5].$es_sta[5]."駅　徒歩".$es_walk[5]."分";
	if($es_bus[5]!="")$moyori5 .= "　バス".$es_bus[5]."分";
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
    <LINK rel="stylesheet" type="text/css" href="../share/css/blog.css" />
    <SCRIPT type="text/javascript" src="../share/js/GoogleMap.js"></SCRIPT>
    <NOSCRIPT><META http-equiv="Refresh" content="1;URL=../jserror.html"></NOSCRIPT>
    <script src="https://maps.googleapis.com/maps/api/js?key=<?=$param_api_key?>" type="text/javascript" charset="utf-8"></script>
  </HEAD>
  <BODY onload="loadMap('00001','<?=$sc_ido?>','<?=$sc_keido?>','<?=$sc_zoom?>','35.70972275209277','139.6527099609375','10','','','','<?=$param_marker_com_img?>','<?=$param_marker_shadow_img?>')">
<FORM name="go_company" method="POST" action="../cl/cl_main.php" target="_self">
</form>
<FORM name="go_layout" method="POST" action="../layout/layout_main.php" target="_self">
</form>
<FORM name="go_leftmenu" method="POST" action="../dai_leftmenu/leftmenu_main.php" target="_self">
</form>
<table style="width:100%">
  <tr>
	 <td style="width:20%">
<span style="font-size:15px;color:#6BD7B5;">基本設定</spann>
    </td>
    <td style="width:80%;text-align:right;">
      <INPUT type="button" value="クライアント情報修正" class="btn_nosize_grey" onclick="document.go_company.submit();return false;"/>&nbsp;
      <INPUT type="button" value="TOP画面レイアウト" class="btn_nosize_grey" onclick="document.go_layout.submit();return false;"/>&nbsp;
      <INPUT type="button" value="左メニュー登録" class="btn_nosize_grey" onclick="document.go_leftmenu.submit();return false;"/>
    </td>
  </tr>
</table>
    <HR color="#96BC69" />
    <TABLE>
      <TR>
        <FORM name="go_mnt" method="POST" action="blog_mnt.php" target="_self">
        <TD><INPUT type="submit" value="新規登録/登録内容を変更する" class="btn_nosize"/></TD>
        </FORM>
      </TR>
    </TABLE>
    <DIV id="blog">
      <DIV id="title2">基本設定１</DIV>
      <TABLE>
<!--
        <TR>
          <TH>ブログタイトル</TH>
          <TD><?=$sc_title?></TD>
        </TR>
//-->
        <TR>
          <TH>ディスクリプション-<br />エディブロ非表示<br />（検索エンジン結果テキスト）</TH>
          <TD><?=$sc_introduce?></TD>
        </TR>
        <TR>
          <TH>デザインパターン</TH>
          <TD><?=$sc_clr?></TD>
        </TR>
        <TR>
			 <TH>SEO対策補助キーワード</TH>
          <TD><?=$sc_keywd?>　</TD>
        </TR>
        <TR>
          <TH>運営会社</TH>
          <TD><?=$sc_company?>　</TD>
        </TR>
        <TR>
          <TH>メインタイトル<br />（検索エンジン結果タイトル・PC画面最上部テキスト）</TH>
          <TD><?=$sc_topwindowtitle?>　</TD>
        </TR>
        <TR>
          <TH>ロゴタイトル<br />（ロゴ上部の紹介テキスト）</TH>
          <TD><?=$sc_headertitle?>　</TD>
        </TR>
        <TR>
          <TH>見出し-教室紹介<br />（トップ画像上）</TH>
          <TD><?=$sc_toptitle?>　</TD>
        </TR>
        <TR>
          <TH>教室紹介太字（トップ画像右・塾タウン掲載時）</TH>
          <TD><?=$sc_topsubtitle?>　</TD>
        </TR>
        <TR>
          <TH>見出し-講習・イベント<br />（イベントバナー上）</TH>
          <TD><?=$sc_campaintitle?>　</TD>
        </TR>
        <TR>
          <TH>見出し-コース</TH>
          <TD><?=$sc_coursetitle?>　</TD>
        </TR>
        <TR>
          <TH>見出し-お知らせ・日記</TH>
          <TD><?=$sc_diarytitle?>　</TD>
        </TR>
        <TR>
          <TH>入塾の流れテキスト<br />（入塾の流れページ内、トップ画像右）</TH>
          <TD><?=$sc_addmission?>　</TD>
        </TR>
      </TABLE>
      <br />
      <DIV id="title2">メール受信先</DIV>
      <TABLE>
        <TR>
          <TH>「お申し込み」<br />受信先メールアドレス</TH>
          <TD><?=$sc_entrymail?></TD>
        </TR>
        <TR>
          <TH>「お申し込み」<br />受信先メールアドレス</TH>
          <TD><?=$sc_entrymail2?></TD>
        </TR>
        <TR>
          <TH>「資料請求」<br />「お問い合わせ」<br />受信先メールアドレス</TH>
          <TD><?=$sc_infomail?></TD>
        </TR>
        <TR>
          <TH>「資料請求」<br />「お問い合わせ」<br />受信先メールアドレス</TH>
          <TD><?=$sc_infomail2?></TD>
        </TR>
      </TABLE>
      <br />
      <DIV id="title2">基本設定２</DIV>
      <TABLE>
<!--
        <TR>
          <TH>教室責任者</TH>
          <TD><?=$sc_master?></TD>
        </TR>
        <TR>
          <TH>教室責任者肩書き</TH>
          <TD><?=$sc_position?></TD>
        </TR>
        <TR>
//-->
          <TH>対象学年アイコン<br />（トップ画像右・塾タウン掲載時）</TH>
          <TD><?=$ageValue?></TD>
        </TR>
        <TR>
          <TH>授業形態アイコン<br />（トップ画像右・塾タウン掲載時）</TH>
          <TD><?=$classformValue?></TD>
        </TR>
        <TR>
          <TH>受付時間<br />（ロゴ右・各ページ最下部基本情報）</TH>
          <TD><?=$sc_end?></TD>
        </TR>
        <TR>
          <TH>定休日<br />（ロゴ右・各ページ最下部基本情報）</TH>
          <TD><?=$sc_holiday?></TD>
        </TR>
<!--
        <TR>
          <TH>会社ホームページ</TH>
          <TD><?=$sc_hp?></TD>
        </TR>
//-->
        <TR>
          <TH>交通<br />（各ページ最下部基本情報）</TH>
          <TD><?=$moyori1?></TD>
        </TR>
<!--
        <TR>
          <TH>最寄駅2</TH>
          <TD><?=$moyori2?></TD>
        </TR>
-->
<!-- 
       <TR>
          <TH>最寄駅3</TH>
          <TD><?=$moyori3?></TD>
        </TR>
        <TR>
          <TH>最寄駅4</TH>
          <TD><?=$moyori4?></TD>
        </TR>
        <TR>
          <TH>最寄駅5</TH>
          <TD><?=$moyori5?></TD>
        </TR>
        <TR>
          <TH>実績校</TH>
          <TD><?=$sc_results?></TD>
        </TR>
        <TR>
          <TH>在校生徒学校</TH>
          <TD><?=$sc_students?></TD>
        </TR>
//-->
        <TR>
          <TH>教室紹介テキスト<br />（トップ画像右・塾タウン掲載時）</TH>
          <TD><?=$sc_pr?></TD>
        </TR>
        <TR>
          <TH>ロゴ画像</TH>
          <TD><?=$sc_logo?></TD>
        </TR>
        <TR>
          <TH>モバイル<br />ロゴ画像</TH>
          <TD><?=$sc_logo_mobile?></TD>
        </TR>
        <TR>
          <TH>トップ画像</TH>
          <TD><?=$sc_topimg?></TD>
        </TR>
        <TR>
          <TH>基本情報画像<br />（各ページ最下部基本情報）</TH>
          <TD><?=$sc_mapimg?></TD>
        </TR>
<!--
        <TR>
          <TH>会社概要用動画</TH>
          <TD><?=$sc_movie?></TD>
        </TR>
//-->
        <TR>
          <TH>教室地図<br />（教室案内ページ内）</TH>
            <TD>
		<div id="gmap" style="width:300px; height: 200px"></div>
		ズーム:
		<input type="button" value="＋" onclick="zmup()">
		<input type="button" value="−" onclick="zmdown()">
		<input type="hidden" id="zoomN" name="zoom2" value="<?=$sc_zoom?>">
		<input type="hidden" id="marker_flg" name="mkr_flg" value="">
          </TD>
        </TR>
        <TR>
          <TH>個人情報保護方針</TH>
          <TD><?=$sc_privacy?></TD>
        </TR>
<!--
        <TR>
          <TH>HTML自由表記内容(右メニュー用)</TH>
          <TD><?=$sc_rhtml?></TD>
        </TR>
//-->
        <TR>
          <TH>HTML自由表記内容(上部)</TH>
          <TD> <?=$sc_thtml?> </TD>
        </TR>
        <TR>
          <TH>HTML自由表記内容(左メニュー用)</TH>
          <TD><?=$sc_lhtml?></TD>
        </TR>

      </TABLE>
    </DIV>
    <br />
    <TABLE>
      <TR>
        <FORM name="go_mnt" method="POST" action="blog_mnt.php" target="_self">
        <TD><INPUT type="submit" value="新規登録/登録内容を変更する　" class="btn_nosize"/></TD>
        </FORM>
      </TR>
    </TABLE>
  </BODY>
</HTML>
