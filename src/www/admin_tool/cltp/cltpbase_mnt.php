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
require_once ( SYS_PATH."dbif/dbcom_DBconnectClass.php" );
require_once ( SYS_PATH."dbif/basedb_AdminClass.php" );
require_once ( SYS_PATH."dbif/basedb_ClientClass.php" );
require_once ( SYS_PATH."dbif/basedb_CltpbaseClass.php" );
require_once ( SYS_PATH."dbif/basedb_CltpcateClass.php" );
require_once ( SYS_PATH."common/base_common.php" );
require_once ( SYS_PATH."common/sys_common.php" );
require_once ( SYS_PATH."common/form_common.php" );
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
$obj = new basedb_CltpbaseClassTblAccess;
$obj->conn = $obj_conn->conn;
$obj->jyoken["cltpbase_del_date"] = 1;
$obj->jyoken["cltpbase_id"] = $_POST["cltpbase_id"];
list( $intNum , $intTotal ) = $obj->basedb_GetCltpbase( 1 , -1 );

IF( $intNum == -1 ){
	$arrOther["ath_comment"] = "<INPUT TYPE=\"hidden\" NAME=\"stpos\" VALUE=\"{$_POST['stpos']}\">";
	$obj_error->ViewErrMessage( "SYSTEM" , "ALL" , SITE_PATH."blank.php" , $arrOther );
	exit;
}


/*--------------------------------------------------------
  一覧表示内容生成
--------------------------------------------------------*/
if($_POST['error_mode']=="on"){
	foreach($_POST as $key => $val){
		$arrData[$key] = stripslashes($val);
	}

	$cltpbase_id = htmlspecialchars ($arrData["cltpbase_id"]);
	$cltpbase_topic_title_1 = htmlspecialchars ($arrData["cltpbase_topic_title_1"]);
	$cltpbase_topic_contents_1 = htmlspecialchars ($arrData["cltpbase_topic_contents_1"]);
	$cltpbase_topic_link_1 = htmlspecialchars ($arrData["cltpbase_topic_link_1"]);

	$cltpbase_topic_title_2 = htmlspecialchars ($arrData["cltpbase_topic_title_2"]);
	$cltpbase_topic_contents_2 = htmlspecialchars ($arrData["cltpbase_topic_contents_2"]);
	$cltpbase_topic_link_2 = htmlspecialchars ($arrData["cltpbase_topic_link_2"]);

	$cltpbase_topic_title_3 = htmlspecialchars ($arrData["cltpbase_topic_title_3"]);
	$cltpbase_topic_contents_3 = htmlspecialchars ($arrData["cltpbase_topic_contents_3"]);
	$cltpbase_topic_link_3 = htmlspecialchars ($arrData["cltpbase_topic_link_3"]);

	$cltpbase_html = htmlspecialchars ($arrData["cltpbase_html"]);
	$cltpbase_upd_date = htmlspecialchars ($arrData["cltpbase_upd_date"]);

	$modeName = "修正";

}else{

	$cltpbase_id = htmlspecialchars ($obj->cltpbasedat[0]["cltpbase_id"]);
	$cltpbase_topic_title_1 = htmlspecialchars ($obj->cltpbasedat[0]["cltpbase_topic_title_1"]);
	$cltpbase_topic_contents_1 = htmlspecialchars ($obj->cltpbasedat[0]["cltpbase_topic_contents_1"]);
	$cltpbase_topic_link_1 = htmlspecialchars ($obj->cltpbasedat[0]["cltpbase_topic_link_1"]);

	$cltpbase_topic_title_2 = htmlspecialchars ($obj->cltpbasedat[0]["cltpbase_topic_title_2"]);
	$cltpbase_topic_contents_2 = htmlspecialchars ($obj->cltpbasedat[0]["cltpbase_topic_contents_2"]);
	$cltpbase_topic_link_2 = htmlspecialchars ($obj->cltpbasedat[0]["cltpbase_topic_link_2"]);

	$cltpbase_topic_title_3 = htmlspecialchars ($obj->cltpbasedat[0]["cltpbase_topic_title_3"]);
	$cltpbase_topic_contents_3 = htmlspecialchars ($obj->cltpbasedat[0]["cltpbase_topic_contents_3"]);
	$cltpbase_topic_link_3 = htmlspecialchars ($obj->cltpbasedat[0]["cltpbase_topic_link_3"]);

	$cltpbase_html = htmlspecialchars ($obj->cltpbasedat[0]["cltpbase_html"]);
	$cltpbase_upd_date = htmlspecialchars ($obj->cltpbasedat[0]["cltpbase_upd_date"]);

	$modeName = "修正";
}


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
    <TITLE>不動産ブログ - クライアントツール</TITLE>
    <META http-equiv="Content-Type" content="text/html;charset=EUC-JP" />
    <META http-equiv="Content-Style-Type" content="text/css" />
    <META http-equiv="Content-Script-Type" content="text/javascript" />
    <LINK rel="stylesheet" type="text/css" href="../share/css/cltpbase.css" />
    <SCRIPT type="text/javascript" src="../share/js/cltpbase.js"></SCRIPT>
    <SCRIPT type="text/javascript" src="../share/js/input_check.js"></SCRIPT>
    <NOSCRIPT><META http-equiv="Refresh" content="1;URL=../jserror.html"></NOSCRIPT>
  </HEAD>
  <BODY>
    <div align="left">
      <table id="client" cellspacing="0">
        <tr>
          <form action="cltpbase_upd.php" method="POST" name="admin">
          <th>トピックタイトル１</th>
          <td><input id="i1" type="text" name="cltpbase_topic_title_1" value="<?=$cltpbase_topic_title_1?>"  style="width:300px" onFocus='Text("i1", 1)' onBlur='Text("i1", 2)' /></td>
        </tr>
        <tr>
          <th>トピック記事１</th>
          <td><input id="i2" type="text" name="cltpbase_topic_contents_1" value="<?=$cltpbase_topic_contents_1?>"  style="width:300px" onFocus='Text("i2", 1)' onBlur='Text("i2", 2)' /></td>
        </tr>
        <tr>
          <th>トピックリンクＵＲＬ１</th>
          <td><input id="i3" type="text" name="cltpbase_topic_link_1" value="<?=$cltpbase_topic_link_1?>"  style="width:300px" onFocus='Text("i3", 1)' onBlur='Text("i3", 2)' /></td>
        </tr>
        <tr>
          <th>トピックタイトル２</th>
          <td><input id="i4" type="text" name="cltpbase_topic_title_2" value="<?=$cltpbase_topic_title_2?>"  style="width:300px" onFocus='Text("i4", 1)' onBlur='Text("i4", 2)' /></td>
        </tr>
        <tr>
          <th>トピック記事２</th>
          <td><input id="i5" type="text" name="cltpbase_topic_contents_2" value="<?=$cltpbase_topic_contents_2?>"  style="width:300px" onFocus='Text("i5", 1)' onBlur='Text("i5", 2)' /></td>
        </tr>
        <tr>
          <th>トピックリンクＵＲＬ２</th>
          <td><input id="i6" type="text" name="cltpbase_topic_link_2" value="<?=$cltpbase_topic_link_2?>"  style="width:300px" onFocus='Text("i6", 1)' onBlur='Text("i6", 2)' /></td>
        </tr>
        <tr>
          <th>トピックタイトル３</th>
          <td><input id="i7" type="text" name="cltpbase_topic_title_3" value="<?=$cltpbase_topic_title_3?>"  style="width:300px" onFocus='Text("i7", 1)' onBlur='Text("i7", 2)' /></td>
        </tr>
        <tr>
          <th>トピック記事３</th>
          <td><input id="i8" type="text" name="cltpbase_topic_contents_3" value="<?=$cltpbase_topic_contents_3?>"  style="width:300px" onFocus='Text("i8", 1)' onBlur='Text("i8", 2)' /></td>
        </tr>
        <tr>
          <th>トピックリンクＵＲＬ３</th>
          <td><input id="i9" type="text" name="cltpbase_topic_link_3" value="<?=$cltpbase_topic_link_3?>"  style="width:300px" onFocus='Text("i9", 1)' onBlur='Text("i9", 2)' /></td>
        </tr>
        <tr>
          <th>ＨＴＭＬ自由記事</th>
          <td>
            <textarea name="cltpbase_html" rows="10" cols="65" id="i10" onFocus='Text("i10", 1)' onBlur='Text("i10", 2)' ><?=$cltpbase_html?></textarea>
          </td>
        </tr>
      </TABLE>
      <BR><BR>
      <br />
      <table style="margin:0px 0px 0px 250px;">
        <tr>
          <td align="center" valign="top">
				<input type="hidden" name="mode" value="NEW" />
            <input type="button" value="登録する" class="btn_nosize" onclick="CltpbaseInputCheck( this.form , this.form )" />
				<!--<input type="hidden" name="mode" value="<?=$_POST['mode']?>" />-->
            <input type="hidden" name="cltpbase_id" value="<?=$cltpbase_id?>" />
            <input type="hidden" name="cltpbase_upd_date" value="<?=$cltpbase_upd_date?>" />
          </td>
          </form>
<?=$strDelTag?>
          <form method="POST" action="cltpbase_main.php">
          <td align="center" valign="top">
            <input type="submit" name="bak" value="戻る" class="btn_nosize" />
          </td>
          </form>
        </tr>
      </table>
    </DIV>
  </body>
</HTML>
