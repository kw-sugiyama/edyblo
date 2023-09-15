<?
/******************************************************************************
<< 不動産ブログ　Ver.1.0.0 >>
    Name: menu.php
    Version: 1.0.0
    Function: 空白画面
    Author: Click inc
    Date of creation: 2006/09
    History of modification:

    Copyright (C)2005 Click, inc. All Rights Reserverd.
******************************************************************************/

/*----------------------------------------------------------
  必要ファイル呼び出し
----------------------------------------------------------*/
require_once ( "./ini_sets_1.php" );
require_once ( SYS_PATH."dbif/basedb_AdminClass.php" );
require_once ( SYS_PATH."dbif/dbcom_DBconnectClass.php" );
require_once ( SYS_PATH."common/sys_common.php" );
require_once ( SYS_PATH."common/error.class.php" );


/*----------------------------------------------------------
  エラークラス - インスタンス
----------------------------------------------------------*/
$obj_error = new DispErrMessage();


/*----------------------------------------------------------
  セッション開始
----------------------------------------------------------*/
session_start();


/*----------------------------------------------------------
  ＤＢ接続
----------------------------------------------------------*/
require_once( SYS_PATH."common/db_connect.php" );


/*----------------------------------------------------------
  ログイン情報チェック
----------------------------------------------------------*/
require_once("./login_chk.php");


/*----------------------------------------------------------
  管理者権限ユーザーの場合、該当項目を表示
----------------------------------------------------------*/
if( $login_val["ad_auth"] == "0"){
	$viewKanriIcon = "";
	$viewKanriIcon .= "<li><a href=\"./admin/admin_main.php\" target=\"home\">管理者登録</a></li>\n";
	$viewMasterIcon = "";
	$viewMasterIcon = "<li><a href=\"./master/master_main.php\" target=\"home\">マスタ登録</a></li>\n";
}


/*----------------------------------------------------------
  ＤＢ切断
----------------------------------------------------------*/
require_once( SYS_PATH."common/db_close.php" );


/*----------------------------------------------------------
  ＨＴＭＬ生成
----------------------------------------------------------*/
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<HTML xmlns="http:www.w3.org/1999/xhtml" xml:lang="ja" lang="ja">
  <HEAD>
    <META http-equiv="Content-Type" content="text/html;charset=EUC-JP">
    <TITLE>不動産ブログ - アカウント管理ツール</TITLE>
    <META http-equiv="Content-Style-Type" content="text/css" />
    <META http-equiv="Content-Script-Type" content="text/javascript" />
    <LINK rel="stylesheet" href="./share/css/menu.css" type="text/css" />
    <base target="home" />
    <NOSCRIPT><META http-equiv="Refresh" content="1;URL=./jserror.html"></NOSCRIPT>
  </HEAD>
  <BODY>
    <DIV id="navigation">
      <ul>
        <?=$viewKanriIcon?>
        <?=$viewMasterIcon?>
        <li><a href="./client/client_main.php" target="home">クライアント登録</a></li>
        <li><a href="./cltp/cltp_select.php" target="home">お知らせ管理</a></li>
<!--
        <li><a href="./client/client_main.php" target="home">お知らせ管理</a></li>
        <li><a href="./kodawari/kodawari_main.php" target="home">こだわり用アドレス生成</a></li>
//-->
        <li><a href="index.php" target="_top">ログアウト</a></li>
      </ul>
    </DIV>
  </BODY>
</HTML>
