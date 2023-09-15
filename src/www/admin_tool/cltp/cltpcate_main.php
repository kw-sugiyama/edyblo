<?
/******************************************************************************
<< 不動産ブログ　Ver.1.O.0 >>
	Name: cltpcate_main.php
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
require_once ( SYS_PATH."dbif/basedb_AdminClass.php" );
require_once ( SYS_PATH."dbif/basedb_ClientClass.php" );
require_once ( SYS_PATH."dbif/basedb_CltpcateClass.php" );
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
	$cltpcate_title = "カテゴリ一覧";
	$cltpcate_title_img = "<span style=\"font-size:15px;color:#6BD7B5;\">カテゴリ設定</spann>";
	$cltpcate_comment_top = "";
	
	$cltpcate_list_title = "";
	$cltpcate_list_title .= "        <TD class=\"td_cl\" style=\"width:100px\">状態</TD>\n";
	$cltpcate_list_title .= "        <TD class=\"td_cl\" style=\"width:300px\">カテゴリ名</TD>\n";
	$cltpcate_list_title .= "        <TD class=\"td_cl\" style=\"width:100px\">カテゴリ表示順</TD>\n";
	$cltpcate_list_title .= "        <TD class=\"td_cl\" style=\"width:100px\">&nbsp;</TD>\n";


/*--------------------------------------------------------
	処理部分
--------------------------------------------------------*/
$obj2 = new basedb_CltpcateClassTblAccess;
$obj2->conn = $obj_conn->conn;
$obj2->jyoken["cltpcate_del_date"] = 1;
$obj2->sort["cltpcate_main"] = 2;
list( $num , $intTotal ) = $obj2->basedb_GetCltpcate( 1 , -1 );
IF( $nmu == -1 ){
	$arrOther["ath_comment"] = "<INPUT TYPE=\"hidden\" NAME=\"stpos\" VALUE=\"{$_POST['stpos']}\">";
	$obj_error->ViewErrMessage( "SYSTEM" , "ALL" , SITE_PATH."blank.php" , $arrOther );
	exit;
}
$viewData = "";
IF( $num == 0 ){
	$viewData .= "      <TR>\n";
	$viewData .= "        <TD colspan=\"4\" class=\"td_cl_nosize\">該当するカテゴリ情報はありません。</TD>\n";
	$viewData .= "      </TR>\n";
}
FOR( $i=0; $i<$num; $i++){
	
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
	$viewData .= "      <TR>\n";
	$viewData .= "        <FORM method=\"POST\" action=\"cltpcate_mnt.php\" target=\"_self\" name=\"editForm{$i}\" id=\"editForm{$i}\">\n";
	$viewData .= "        <TD class=\"td_cl_nosize\">{$cltpcate_stat_value}</TD>\n";
	IF( $_POST['cltpcate_kind'] == 1 ){
		$viewData .= "        <TD class=\"td_cl_nosize\">{$cltpcate_top_flg}</TD>\n";
	}
	$viewData .= "        <TD class=\"td_cl_nosize\">{$cltpcate_name}</TD>\n";
	$viewData .= "        <TD class=\"td_cl_nosize\"><INPUT type=\"{$dispNoMode}\" id=\"{$i}\" name=\"cltpcate_disp_no\" value=\"{$cltpcate_disp_no}\" style=\"width:50px;\" {$readonly} onFocus='Text(\"{$i}\", 1)' onBlur='Text(\"{$i}\", 2)'></TD>\n";
	$viewData .= "        <TD class=\"td_cl_nosize\"><INPUT type=\"submit\" name=\"go_mnt_2\" value=\"修正\" class=\"btn\" /></TD>\n";
	$viewData .= "        <INPUT type=\"hidden\" name=\"mode\" value=\"EDIT\" />\n";
	$viewData .= "        <INPUT type=\"hidden\" name=\"cltpcate_kind\" value=\"{$_POST['cltpcate_kind']}\" />\n";
	$viewData .= "        <INPUT type=\"hidden\" name=\"cltpcate_id\" value=\"{$cltpcate_id}\" />\n";
	$viewData .= "        </FORM>\n";
	$viewData .= "      </TR>\n";

	if( $i != 0 && $obj2->cltpcatedat[$i]["cltpcate_stat"] == 1)$disp_cltpcate_id .= "/";
	if( $obj2->cltpcatedat[$i]["cltpcate_stat"] == 1)$disp_cltpcate_id .= $obj2->cltpcatedat[$i]["cltpcate_id"];
	if( $i != 0 && $obj2->cltpcatedat[$i]["cltpcate_stat"] == 1)$disp_cltpcate_upd_date .= "/";
	if( $obj2->cltpcatedat[$i]["cltpcate_stat"] == 1)$disp_cltpcate_upd_date .= $obj2->cltpcatedat[$i]["cltpcate_upd_date"];
	if( $i != 0 && $obj2->cltpcatedat[$i]["cltpcate_stat"] == 1)$disp_cltpcate_stat .= "/";
	if( $obj2->cltpcatedat[$i]["cltpcate_stat"] == 1)$disp_cltpcate_stat .= $obj2->cltpcatedat[$i]["cltpcate_stat"];

	if( $obj2->cltpcatedat[$i]["cltpcate_stat"] == 1)$num2++;	
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
$viewPageChangeValue = basecom_page_change_VAL( $num , $intTotal , $intGetNum , $intStPos , $intGetNum , $intPageNum , "cltpcate_main" , "stpos" , "" );
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
    <TITLE>不動産ブログ - クライアントツール</TITLE>
    <META http-equiv="Content-Type" content="text/html;charset=EUC-JP" />
    <META http-equiv="Content-Style-Type" content="text/css" />
    <META http-equiv="Content-Script-Type" content="text/javascript" />
    <LINK rel="stylesheet" type="text/css" href="../share/css/cltpcate.css" />
    <SCRIPT type="text/javascript" src="../share/js/cltpcate.js"></SCRIPT>
    <NOSCRIPT><META http-equiv="Refresh" content="1;URL=../jserror.html"></NOSCRIPT>
  </HEAD>
  <BODY>
    <TABLE>
      <TR>
        <TD><?=$cltpcate_title_img?></TD>
        <FORM ACTION="cltp_select.php" METHOD="POST">
        <TD>
          <input type="submit" value="機能選択に戻る" class="btn_nosize">
        </TD>
        </FORM>
      </TR>
    </TABLE>
    <HR color="#96BC69" />
    <TABLE width="700">
      <?=$cltpcate_comment_top?>
      <TR>
        <FORM action="cltpcate_mnt.php" method="POST" >
        <TD><INPUT type="submit" name="new" value="新規カテゴリを作成する" class="btn_nosize" /></TD>
        <INPUT type="hidden" name="mode" value="NEW" class="btn" /></TD>
        <INPUT type="hidden" name="cltpcate_kind" value="<?=$_POST['cltpcate_kind']?>"/></TD>
        </FORM>
        <FORM action="cltpcate_upd.php" method="POST" onsubmit="return dispSet(<?=$intTotal?>)" name="disp_set">
        <TD align="right"><INPUT type="submit" name="new" value="表示順を反映する" class="btn_nosize" /></TD>
        <INPUT type="hidden" name="cltpcate_upd_date" value="<?=$disp_cltpcate_upd_date?>" />
        <INPUT type="hidden" name="cltpcate_top_flg" value="<?=$disp_cltpcate_stat?>" />
        <INPUT type="hidden" name="cltpcate_disp_no" value="" />
        <INPUT type="hidden" name="cltpcate_id" value="<?=$disp_cltpcate_id?>" />
        <INPUT type="hidden" name="cltpcate_kind" value="<?=$_POST['cltpcate_kind']?>" />
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
	<?=$cltpcate_list_title?>
      </TR>
<?=$viewData?>
    </TABLE>
    <BR />
    <TABLE border="0" cellspacing="0" cellpadding="2" width="700" class="px12">
      <TR>
        <FORM name="cltpcate_main" method="POST" action="cltpcate_main.html">
        <INPUT type="hidden" name="stpos" value="" />
        </TD>
        </FORM>
      </TR>
    </TABLE>
  </BODY>
</HTML>
