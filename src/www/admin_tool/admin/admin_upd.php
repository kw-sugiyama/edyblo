<?
/******************************************************************************
<< 不動産ブログ　Ver.1.O.0 >>
	Name: admin_upd.php
	Version: 1.0.0
	Function: 管理者登録／修正／削除登録
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
require_once ( SYS_PATH."common/error.class.php" );
require_once ( SYS_PATH."common/sys_common.php" );


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
if( $login_val["ad_auth"] != 0 ){
	$obj_error->ViewErrMessage( "ACCESS" , "ALL" , SITE_PATH."blank.php" , NULL );
	exit;
}


/*---------------------------------------------------------
	処理部分
---------------------------------------------------------*/
switch( $_POST["mode"] ){
	case 'NEW':
		$obj_new = new basedb_AdminClassTblAccess;
		$obj_new->conn = $obj_conn->conn;
		$obj_new->admindat[0]["ad_name"] = $_POST["ad_name"];
		$obj_new->admindat[0]["ad_loginid"] = $_POST["ad_loginid"];
		$obj_new->admindat[0]["ad_passwd"] = $_POST["ad_passwd"];
		$obj_new->admindat[0]["ad_logincd"] = sha1($_POST["ad_loginid"]);
		$obj_new->admindat[0]["ad_passcd"] = sha1($_POST["ad_passwd"]);
		IF( $_POST["ad_auth"] != "" ){
			$obj_new->admindat[0]["ad_auth"] = 0;
		}ELSE{
			$obj_new->admindat[0]["ad_auth"] = 1;
		}
		$obj_new->admindat[0]["ad_makeid"] = $_SESSION['ad_id'];
		$obj_new->admindat[0]["ad_biko"] = $_POST["ad_biko"];
		$suc = $obj_new->basedb_InsAdmin();
		if( $suc == -1 ){
			$arrErr["ath_comment"] = "";
			FOREACH( $_POST as $key => $val ){
				$arrErr["ath_comment"] .= "<INPUT type=\"hidden\" name=\"{$key}\" value=\"{$val}\">\n";
			}
			$obj_error->ViewErrMessage( "INS_ERROR" , "ALL" , "admin_mnt.php" , $arrErr );
			exit;
		}
		if( $suc == 1 ){
			$arrErr["ath_comment"] = "";
			FOREACH( $_POST as $key => $val ){
				$arrErr["ath_comment"] .= "<INPUT type=\"hidden\" name=\"{$key}\" value=\"{$val}\">\n";
			}
			$obj_error->ViewErrMessage( "LOGIN_ID" , "ALL" , "admin_mnt.php" , $arrErr );
			exit;
		}
		$message = "管理者を登録しました。";
		break;
		
		
	case 'EDIT':
		$obj_rev = new basedb_AdminClassTblAccess;
		$obj_rev->conn = $obj_conn->conn;
		$obj_rev->admindat[0]["ad_id"] = $_POST["ad_id"];
		$obj_rev->admindat[0]["ad_name"] = $_POST["ad_name"];
		$obj_rev->admindat[0]["ad_loginid"] = $_POST["ad_loginid"];
		$obj_rev->admindat[0]["ad_passwd"] = $_POST["ad_passwd"];
		$obj_rev->admindat[0]["ad_logincd"] = sha1($_POST["ad_loginid"]);
		$obj_rev->admindat[0]["ad_passcd"] = sha1($_POST["ad_passwd"]);
		IF( $_POST["ad_auth"] != "" ){
			$obj_rev->admindat[0]["ad_auth"] = 0;
		}ELSE{
			$obj_rev->admindat[0]["ad_auth"] = 1;
		}
		$obj_rev->admindat[0]["ad_makeid"] = $_SESSION['ad_id'];
		$obj_rev->admindat[0]["ad_biko"] = $_POST["ad_biko"];
		$obj_rev->admindat[0]["ad_upddate"] = $_POST["ad_upddate"];
		$suc = $obj_rev->basedb_UpdAdmin();
		if( $suc == -1 ){
			$arrErr["ath_comment"] = "";
			FOREACH( $_POST as $key => $val ){
				$arrErr["ath_comment"] .= "<INPUT type=\"hidden\" name=\"{$key}\" value=\"{$val}\">\n";
			}
			$obj_error->ViewErrMessage( "UPD_ERROR" , "ALL" , "admin_mnt.php" , $arrErr );
			exit;
		}
		if( $suc == 1 ){
			$arrErr["ath_comment"] = "";
			FOREACH( $_POST as $key => $val ){
				$arrErr["ath_comment"] .= "<INPUT type=\"hidden\" name=\"{$key}\" value=\"{$val}\">\n";
			}
			$obj_error->ViewErrMessage( "LOGIN_ID" , "ALL" , "admin_mnt.php" , $arrErr );
			exit;
		}
			
		$message = "管理者情報を修正しました。";
		break;
		
		
	case 'DEL':
		$obj_del = new basedb_AdminClassTblAccess;
		$obj_del->conn = $obj_conn->conn;
		$obj_del->admindat[0]["ad_id"] = $_POST["ad_id"];
		$obj_del->admindat[0]["ad_upddate"] = $_POST["ad_upddate"];
		$suc = $obj_del->basedb_DelAdmin(0);
		if( $suc != 0 ){
			$arrErr["ath_comment"] = "";
			FOREACH( $_POST as $key => $val ){
				$arrErr["ath_comment"] .= "<INPUT type=\"hidden\" name=\"{$key}\" value=\"{$val}\">\n";
			}
			$obj_error->ViewErrMessage( "UPD_ERROR" , "ALL" , "admin_mnt.php" , $arrErr );
			exit;
		}
		$message = "指定された管理者情報を削除しました。";
		break;
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
    <TITLE>塾ブログ - アカウント管理ツール</title>
    <META http-equiv="Content-Type" content="text/html;charset=EUC-JP" />
    <META http-equiv="Content-Style-Type" content="text/css" />
    <META http-equiv="Content-Script-Type" content="text/javascript" />
    <LINK rel="stylesheet" href="./share/css/admin.css" type="text/css" />
    <NOSCRIPT><META http-equiv="Refresh" content="1;URL=./jserror.html"></NOSCRIPT>
  </HEAD>
  <BODY>
    <div align="center">
      <input type="hidden" name="stpos" value="1">
      <table width="400" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td align="center">
            <br /><br /><br /><br /><br />
            <font size="3" color="#FF6600"><?=$message?></font>
            <br /><br /><br />
          </td>
        </tr>
      </table>
      <form name="form1" method="POST" action="admin_main.php"> 
        <input type="submit" value=" 戻 る " class="btn" />
      </form>
    </div>
  </body>
</html>
