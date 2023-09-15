<?
/******************************************************************************
<< 不動産ブログ　Ver.1.O.0 >>
	Name: admin_mnt.php
	Version: 1.0.0
	Function: 管理者登録／修正画面
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
require_once ( SYS_PATH."common/sys_common.php" );
require_once ( SYS_PATH."common/error.class.php" );


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
if( $login_val["ad_auth"] != "0" ){
	$obj_error->ViewErrMessage( "ACCESS" , "ALL" , SITE_PATH."blank.php" , NULL );
	exit;
}


/*--------------------------------------------------------
	処理部分
--------------------------------------------------------*/
$strMode = htmlspecialchars( $_POST["mode"] );
$ad_id = $_POST["ad_id"];
IF( $strMode == "EDIT" ){
	$obj2 = new basedb_AdminClassTblAccess;
	$obj2->conn = $obj_conn->conn;
	$obj2->jyoken["ad_id"] = intval( $ad_id );
	$obj2->jyoken["ad_deldate"] = 1;
	list( $num , $total ) = $obj2->basedb_GetAdmin( 1 , -1 );
	IF( $num != 1 ){
		$obj_error->ViewErrMessage( "SYSTEM" , "ALL" , "admin_main.php" , NULL );
		exit;
	}
	
	if( $obj2->admindat[0]["ad_auth"] == 0 ){
		$kengen = " checked";
	}
	$ad_name = htmlspecialchars( $obj2->admindat[0]["ad_name"] );
	$ad_loginid = htmlspecialchars( $obj2->admindat[0]["ad_loginid"] );
	$ad_passwd = htmlspecialchars( $obj2->admindat[0]["ad_passwd"] );
	$ad_biko = htmlspecialchars( $obj2->admindat[0]["ad_biko"] );
	$ad_upddate = htmlspecialchars( $obj2->admindat[0]["ad_upddate"] );
	
	$strDelTag = "";
	$strDelTag .= "          <form action=\"admin_upd.php\" method=\"POST\" name=\"del_form\">\n";
	$strDelTag .= "          <td align=\"center\" valign=\"top\">\n";
	$strDelTag .= "            <input type=\"button\" value=\"削除する\" class=\"btn_nosize\" onclick=\"AdminDeleteCheck( document.admin , this.form )\" />\n";
	$strDelTag .= "            <input type=\"hidden\" name=\"mode\" value=\"DEL\" />\n";
	$strDelTag .= "            <input type=\"hidden\" name=\"ad_id\" value=\"{$ad_id}\" />\n";
	$strDelTag .= "            <input type=\"hidden\" name=\"ad_upddate\" value=\"{$ad_upddate}\" />\n";
	$strDelTag .= "          </td>\n";
	$strDelTag .= "          </form>\n";
	
	$strButtonVal = "修正する";
}ELSE{
	
	if( $_POST["ad_auth"] != "" ){
		$kengen = " checked";
	}
	$ad_name = htmlspecialchars( $_POST["ad_name"] );
	$ad_loginid = htmlspecialchars( $_POST["ad_loginid"] );
	$ad_passwd = htmlspecialchars( $_POST["ad_passwd"] );
	$ad_biko = htmlspecialchars( $_POST["ad_biko"] );
	
	$strButtonVal = "登録する";
}


/*--------------------------------------------------------
  ＤＢ切断
--------------------------------------------------------*/
require_once( SYS_PATH."common/db_close.php" );


/*=================================================
    ＨＴＭＬ表示
=================================================*/
?>
<HTML>
  <HEAD>
    <TITLE>塾ブログ - アカウント管理ツール</TITLE>
    <META http-equiv="Content-Type" content="text/html;charset=EUC-JP" />
    <META http-equiv="Content-Style-Type" content="text/css" />
    <META http-equiv="Content-Script-Type" content="text/javascript" />
    <LINK rel="stylesheet" type="text/css" href="../share/css/admin.css" />
    <SCRIPT type="text/javascript" src="../share/js/admin.js"></SCRIPT>
    <SCRIPT type="text/javascript" src="../share/js/input_check.js"></SCRIPT>
    <NOSCRIPT><META http-equiv="Refresh" content="1;URL=../jserror.html"></NOSCRIPT>
  </HEAD>
  <BODY>
    <div align="center">
      <table id="admin" cellspacing="0">
        <tr>
          <form action="admin_upd.php" method="POST" name="admin">
          <th>使用権限</th>
          <td><input type="checkbox" name="ad_auth" value="1" id="kengen"<?=$kengen?> /><label for="kengen">管理者発行可能</label></td>
        </tr>
        <tr>
          <th class="must">ログインID</th>
          <td><input id="i1" type="text" name="ad_loginid" value="<?=$ad_loginid?>" maxlength="15" onFocus='Text("i1", 1)' onBlur='Text("i1", 2)' /><font color="#ff0000">（半角英数字で入力）</font></td>
        </tr>
        <tr>
          <th class="must">パスワード</th>
          <td><input id="i2" type="text" name="ad_passwd" value="<?=$ad_passwd?>" maxlength="15" onFocus='Text("i2", 1)' onBlur='Text("i2", 2)' /><font color="#ff0000">（半角英数字で入力）</font></td>
        </tr>
        <tr>
          <th class="must">氏名</th>
          <td><input type="text" id="i3" name="ad_name" value="<?=$ad_name?>" maxlength="25" onFocus='Text("i3", 1)' onBlur='Text("i3", 2)' /></td>
        </tr>
        <tr>
          <th>備考</th>
          <td><input type="text" id="i4" name="ad_biko" value="<?=$ad_biko?>" maxlength="25" onFocus='Text("i4", 1)' onBlur='Text("i4", 2)' /></td>
        </tr>
      </table>
      <br />
      <table>
        <tr>
          <td align="center" valign="top">
            <input type="button" value="<?=$strButtonVal?>" class="btn_nosize" onclick="AdminInputCheck( this.form , this.form )" />
            <input type="hidden" name="mode" value="<?=$_POST["mode"]?>" />
            <input type="hidden" name="ad_id" value="<?=$ad_id?>" />
            <input type="hidden" name="ad_upddate" value="<?=$ad_upddate?>" />
          </td>
          </form>
<?=$strDelTag?>
          <form method="POST" action="admin_main.php">
          <td align="center" valign="top">
            <input type="submit" name="bak" value="戻る" class="btn_nosize" />
          </td>
          </form>
        </tr>
      </table>
    </DIV>
  </body>
</HTML>
