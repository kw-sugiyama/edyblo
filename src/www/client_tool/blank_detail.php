<?
/******************************************************************************
<< 不動産ブログ　Ver.1.0.0 >>
    Name: blank.php
    Version: 1.0.0
    Function: 空白画面
    Author: Click inc
    Date of creation: 2007/02
    History of modification:

    Copyright (C)2005 Click, inc. All Rights Reserverd.
******************************************************************************/

/*----------------------------------------------------------
  必要ファイル呼び出し
----------------------------------------------------------*/
require_once ( "./ini_sets_1.php" );
require_once ( "./cltpcontents_html_replace.php" );
require_once ( SYS_PATH."dbif/dbcom_DBconnectClass.php" );
require_once ( SYS_PATH."dbif/basedb_CltpbaseClass.php" );
require_once ( SYS_PATH."dbif/basedb_CltpcateClass.php" );
require_once ( SYS_PATH."dbif/basedb_CltpcontentsClass.php" );
require_once ( SYS_PATH."common/base_common.php" );
require_once ( SYS_PATH."common/sys_common.php" );
require_once ( SYS_PATH."common/error.class.php" );


/*----------------------------------------------------------
  セッション開始
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


/*--------------------------------------------------------
	処理部分
--------------------------------------------------------*/
$obj = new basedb_CltpbaseClassTblAccess;
$obj->conn = $obj_conn->conn;
$obj->jyoken["cltpbase_del_date"] = 1;
list( $num , $total ) = $obj->basedb_GetCltpbase( 1 , -1 );
IF( $num == -1 ){
	$obj_error->ViewErrMessage( "SYSTEM" , "ALL" , SITE_PATH."blank.php" , $arrOther );
	exit;
}


$obj2 = new basedb_CltpcateClassTblAccess;
$obj2->conn = $obj_conn->conn;
$obj2->jyoken["cltpcate_del_date"] = 1;
$obj2->jyoken["cltpcate_stat"] = 1;
$obj2->sort["cltpcate_main"] = 2;
list( $num2 , $intTotal2 ) = $obj2->basedb_GetCltpcate( 1 , -1 );
IF( $num2 == -1 ){
	$arrOther["ath_comment"] = "<INPUT TYPE=\"hidden\" NAME=\"stpos\" VALUE=\"{$_POST['stpos']}\">";
	$obj_error->ViewErrMessage( "SYSTEM" , "ALL" , SITE_PATH."blank.php" , $arrOther );
	exit;
}


IF( $_POST["stpos"] != "" ){
	$intStPos = intval($_POST["stpos"]);
}ELSE{
	$intStPos = 1;
}
$intGetNum = 20;

$obj3 = new basedb_CltpcontentsClassTblAccess;
$obj3->conn = $obj_conn->conn;
$obj3->jyoken["cltpcontents_del_date"] = 1;
$obj3->jyoken["cltpcate_stat"] = 1;
$obj3->jyoken["cltpcontents_stat"] = 1;
$obj3->sort["cltpcontents_date"] = 1;
if($_GET['id']!="")$obj3->jyoken["cltpcontents_id"] = $_GET['id'];
if($_GET['cate']!="")$obj3->jyoken["cltpcontents_cate_id"] = $_GET['cate'];
list( $num3 , $intTotal3 ) = $obj3->basedb_GetCltpcontents( $intStPos , $intGetNum );
IF( $num3 == -1 ){
	$arrOther["ath_comment"] = "<INPUT TYPE=\"hidden\" NAME=\"stpos\" VALUE=\"{$_POST['stpos']}\">";
	$obj_error->ViewErrMessage( "SYSTEM" , "ALL" , SITE_PATH."blank.php" , $arrOther );
	exit;
}
/*----------------------------------------------------------
  ＤＢ切断
----------------------------------------------------------*/
require_once( SYS_PATH."common/db_close.php" );


/*--------------------------------------------------------
	処理部分
--------------------------------------------------------*/
$viewData = "";
IF( $num3 == 0 ){
	$viewData3 .= "        <p class=\"contents\">該当するカテゴリ情報はありません。</p>\n";
}
FOR( $i=0; $i<$num3; $i++){
	
	$cltpcontents_id = htmlspecialchars( $obj3->cltpcontentsdat[$i]["cltpcontents_id"] );
	$cltpcontents_title = htmlspecialchars( $obj3->cltpcontentsdat[$i]["cltpcontents_title"] );
	$cltpcontents_stat = htmlspecialchars( $obj3->cltpcontentsdat[$i]["cltpcontents_stat"] );
	if($cltpcontents_stat==1){
		$cltpcontents_stat_value = "表示";
	}else if($cltpcontents_stat==9){
		$cltpcontents_stat_value = "非表示";
	}
	$cltpcontents_date = htmlspecialchars( $obj3->cltpcontentsdat[$i]["cltpcontents_date"] );
	if($cltpcontents_date!="")$timestamp = split(" ",$cltpcontents_date);
	if($timestamp[0]!="")$date = split("-",$timestamp[0]);

	$cltpcontents_upd_date = htmlspecialchars( $obj3->cltpcontentsdat[$i]["cltpcontents_upd_date"] );
	$readonly="";
	if($cltpcontents_stat == 9)$readonly="readonly";
	$dispNoMode = "";
        if($cltpcontents_stat == 1){
		$dispNoMode="text";
	}else if($cltpcontents_stat == 9){
                $dispNoMode="hidden";
	}
	if($cltpcontents_top_flg==1){
		$cltpcontents_top_flg = "表示";
	}else{
		$cltpcontents_top_flg = "";
	}
	$cltpcontents_contents = html_replace( nl2br($obj3->cltpcontentsdat[$i]["cltpcontents_contents"]), 
						$obj3->cltpcontentsdat[$i]["cltpcontents_img_1"],
						$obj3->cltpcontentsdat[$i]["cltpcontents_img_2"],
						$obj3->cltpcontentsdat[$i]["cltpcontents_img_3"],
						$obj3->cltpcontentsdat[$i]["cltpcontents_img_4"]
					);
	$viewData3 .= "      <p>{$date[0]}年{$date[1]}月{$date[2]}日　<span class=\"title\">{$cltpcontents_title}</span>　（<a href=\"./blank.php?cate={$obj3->cltpcontentsdat[$i]["cltpcate_id"]}\" target=\"home\">{$obj3->cltpcontentsdat[$i]["cltpcate_name"]}</a>）</p>\n";
	$viewData3 .= "      <p>{$cltpcontents_contents}</p>\n";

	if( $i != 0 && $obj3->cltpcontentsdat[$i]["cltpcontents_stat"] == 1)$disp_cltpcontents_id .= "/";
	if( $obj3->cltpcontentsdat[$i]["cltpcontents_stat"] == 1)$disp_cltpcontents_id .= $obj3->cltpcontentsdat[$i]["cltpcontents_id"];
	if( $i != 0 && $obj3->cltpcontentsdat[$i]["cltpcontents_stat"] == 1)$disp_cltpcontents_upd_date .= "/";
	if( $obj3->cltpcontentsdat[$i]["cltpcontents_stat"] == 1)$disp_cltpcontents_upd_date .= $obj3->cltpcontentsdat[$i]["cltpcontents_upd_date"];
	if( $i != 0 && $obj3->cltpcontentsdat[$i]["cltpcontents_stat"] == 1)$disp_cltpcontents_stat .= "/";
	if( $obj3->cltpcontentsdat[$i]["cltpcontents_stat"] == 1)$disp_cltpcontents_stat .= $obj3->cltpcontentsdat[$i]["cltpcontents_stat"];

	if( $obj3->cltpcontentsdat[$i]["cltpcontents_stat"] == 1)$num32++;	
}


/*----------------------------------------------------------
   ページ遷移用
----------------------------------------------------------*/
$intPageNum = $intTotal3 / $intGetNum;
IF( !strpos( $intPageNum , "." ) ){
	$intPageNum = (int)$intPageNum;
}ELSE{
	$intPageNum = (int)$intPageNum + 1;
}
$intEdPos = $intGetNum + $intStPos - 1;
IF( $intEdPos > $intTotal3 ) $intEdPos = $intTotal3;
$viewPageChangeValue = basecom_page_change_VAL_blank( $num3 , $intTotal3 , $intGetNum , $intStPos , $intEdPos , $intPageNum , "cltpcontents_main" , "stpos" , "btn_nosize" );


/*--------------------------------------------------------
	処理部分
--------------------------------------------------------*/
$viewData = "";
IF( $num2 == 0 ){
	$viewData2 .= "        <p>該当するカテゴリ情報はありません。</p>\n";
}
FOR( $i=0; $i<$num2; $i++){
	
	$cltpcate_id = htmlspecialchars( $obj2->cltpcatedat[$i]["cltpcate_id"] );
	$cltpcate_name = htmlspecialchars( $obj2->cltpcatedat[$i]["cltpcate_name"] );
	if($_POST['error_mode']=="on" && $_POST['num']>$i){
		$cltpcate_disp_no = htmlspecialchars( $_POST[$i] );
	}else{
		$cltpcate_disp_no = htmlspecialchars( $obj2->cltpcatedat[$i]["cltpcate_disp_no"] );
	}
	$cltpcate_stat = htmlspecialchars( $obj2->cltpcatedat[$i]["cltpcate_stat"] );
	if($cltpcate_stat==1){
		$cltpcate_stat_value = "表示";
	}else if($cltpcate_stat==9){
		$cltpcate_stat_value = "非表示";
	}
	$cltpcate_top_name = htmlspecialchars( $obj2->cltpcatedat[$i]["cltpcate_top_name"] );
	$cltpcate_top_flg = htmlspecialchars( $obj2->cltpcatedat[$i]["cltpcate_top_flg"] );
	$cltpcate_upd_date = htmlspecialchars( $obj2->cltpcatedat[$i]["cltpcate_upd_date"] );
	$readonly="";
	if($cltpcate_stat == 9)$readonly="readonly";
	$dispNoMode = "";
        if($cltpcate_stat == 1){
		$dispNoMode="text";
	}else if($cltpcate_stat == 9){
                $dispNoMode="hidden";
	}
	if($cltpcate_top_flg==1){
		$cltpcate_top_flg = "表示";
	}else{
		$cltpcate_top_flg = "";
	}
	$viewData2 .= "      <li><a href=\"./blank.php?cate={$cltpcate_id}\" target=\"home\" class=\"bt_menu\">{$cltpcate_name}</a></li>\n";
}


/*--------------------------------------------------------
  一覧表示内容生成
--------------------------------------------------------*/
$viewData["cltpbase_id"] = htmlspecialchars( $obj->cltpbasedat[0]["cltpbase_id"] );
$viewData["cltpbase_topic_title_1"] = htmlspecialchars( $obj->cltpbasedat[0]["cltpbase_topic_title_1"] );
$viewData["cltpbase_topic_contents_1"] = htmlspecialchars( $obj->cltpbasedat[0]["cltpbase_topic_contents_1"] );
$viewData["cltpbase_topic_link_1"] = htmlspecialchars( $obj->cltpbasedat[0]["cltpbase_topic_link_1"] );
$viewData["cltpbase_topic_title_2"] = htmlspecialchars( $obj->cltpbasedat[0]["cltpbase_topic_title_2"] );
$viewData["cltpbase_topic_contents_2"] = htmlspecialchars( $obj->cltpbasedat[0]["cltpbase_topic_contents_2"] );
$viewData["cltpbase_topic_link_2"] = htmlspecialchars( $obj->cltpbasedat[0]["cltpbase_topic_link_2"] );
$viewData["cltpbase_topic_title_3"] = htmlspecialchars( $obj->cltpbasedat[0]["cltpbase_topic_title_3"] );
$viewData["cltpbase_topic_contents_3"] = htmlspecialchars( $obj->cltpbasedat[0]["cltpbase_topic_contents_3"] );
$viewData["cltpbase_topic_link_3"] = htmlspecialchars( $obj->cltpbasedat[0]["cltpbase_topic_link_3"] );
$viewData["cltpbase_html"] = $obj->cltpbasedat[0]["cltpbase_html"];
$viewData["cltpbase_upd_date"] = htmlspecialchars( $obj->cltpbasedat[0]["cltpbase_upd_date"] );


/*----------------------------------------------------------
  ＨＴＭＬ生成
----------------------------------------------------------*/
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<HTML>
<HEAD>
<META http-equiv="Content-Type" content="text/html; charset=EUC-JP">
<META name="GENERATOR" content="IBM WebSphere Studio Homepage Builder Version 9.0.0.0 for Windows">
<META http-equiv="Content-Style-Type" content="text/css">
<LINK rel="stylesheet" href="./share/css/menu2.css" type="text/css" />
<TITLE></TITLE>
<style type="text/css">
<!--
.style1 {font-size: 12px}
-->
</style>
</HEAD>
<BODY>
<TABLE>
  <TBODY>
    <TR>
      <TD width="600" height="545" valign="top">
        <h3>エディブロからのお知らせトピックス</h3>

<table style="border:1px #7f7f7f solid;width:600px;" style="margin:15px 0px 0px 0px;">
  <tr>
    <td style="padding:5px 15px 5px 15px;">
<p><font color="#e52d2d"><B><?=$viewData["cltpbase_topic_title_1"]?></B></font>　<a href="<?=$viewData["cltpbase_topic_link_1"]?>" target="_blank" class="boldlink"><?=$viewData["cltpbase_topic_contents_1"]?></a></p>
<p><font color="#e52d2d"><B><?=$viewData["cltpbase_topic_title_2"]?></B></font>　<a href="<?=$viewData["cltpbase_topic_link_2"]?>" target="_blank" class="boldlink"><?=$viewData["cltpbase_topic_contents_2"]?></a></p>
<p><font color="#e52d2d"><B><?=$viewData["cltpbase_topic_title_3"]?></B></font>　<a href="<?=$viewData["cltpbase_topic_link_3"]?>" target="_blank" class="boldlink"><?=$viewData["cltpbase_topic_contents_3"]?></a></p>
    </td>
  </tr>
</table>

<!--      <IFRAME src="news.html" name="news" width="600" height="231">この部分はインラインフレームを使用しています。</IFRAME>//-->

        <h3><?=$date[0]?>年<?=$date[1]?>月<?=$date[2]?>日　<?=$cltpcontents_title?></h3>
        <!-- <IMG src="share/images/bar_maintenance.gif" width="600" height="25" border="0"> //-->

<table style="border:1px #7f7f7f solid;width:600px;" style="margin:15px 0px 0px 0px;">
  <tr>
    <td style="padding:5px 15px 5px 15px;"><?=$viewData3?></td>
  </tr>
</table>

<!--<iframe src="maintenance.html" name="maintenance" width="600" height="236"> この部分はインラインフレームを使用しています。 </iframe>//-->
</TD>
      <TD width="172" height="545" valign="top" align="center">
    <DIV id="navigation">
      <ul>
<?=$viewData2?>
      </ul>
    </DIV>
    <DIV>
<?=$viewData["cltpbase_html"]?>
    </DIV>

<BR>
<!--<iframe src="http://rcm-jp.amazon.co.jp/e/cm?t=tsbar-22&o=9&p=14&l=st1&mode=books-jp&search=%E4%B8%8D%E5%8B%95%E7%94%A3&fc1=000000&lt1=&lc1=3366FF&bg1=FFFFFF&f=ifr" marginwidth="0" marginheight="0" width="160" height="600" border="0" frameborder="0" style="border:none;" scrolling="no"></iframe>//-->

      </TD>
    </TR>
  </TBODY>
</TABLE>
</BODY>
</HTML>
