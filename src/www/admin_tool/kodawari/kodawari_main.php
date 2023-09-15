<?
/******************************************************************************
<< 不動産ブログ　Ver.1.O.0 >>
	Name: kodawari_main.php
	Version: 1.0.0
	Function: こだわり用アドレス生成機能 飛び先選択
	Author: Click inc
	Date of creation: 2007/06
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
require_once ( SYS_PATH."common/error.class.php" );
require_once ( SYS_PATH."common/sys_common.php" );
require_once ( SYS_PATH."common/base_common.php" );
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
	ＨＴＭＬ生成
--------------------------------------------------------*/
?>
<HTML>
  <HEAD>
    <TITLE>不動産ブログ - アカウント管理ツール</TITLE>
    <META http-equiv="Content-Type" content="text/html;charset=EUC-JP" />
    <META http-equiv="Content-Style-Type" content="text/css" />
    <META http-equiv="Content-Script-Type" content="text/javascript" />
    <LINK rel="stylesheet" type="text/css" href="../share/css/client.css" />
    <SCRIPT type="text/javascript" src="../share/js/client.js"></SCRIPT>
    <LINK rel="stylesheet" type="text/css" href="../share/css/master.css" />
    <SCRIPT type="text/javascript" src="../share/js/input_check.js"></SCRIPT>
    <NOSCRIPT><META http-equiv="Refresh" content="1;URL=../jserror.html"></NOSCRIPT>
  </HEAD>
  <BODY>
    <IMG src="../share/images/kodawari_title.gif" alt="リンク先ページ指定" />
    <HR color="#96BC69" />
  <DIV id="category">
    <DIV id="line_01">
      <DIV id="title">■リンク先ページ選択</DIV>
      <FORM name="goNew" method="POST" action="kodawari_mnt.php" target="_self">
        <INPUT type="submit" value="検索結果ページ" class="btn" style="width:200px"/>
        <INPUT type="hidden" name="mode" value="result" />
      </FORM>
    </DIV>
  </DIV><BR>
  <DIV id="category">
    <DIV id="line_01">
      <FORM name="goNew" method="POST" action="kodawari_mnt.php" target="_self">
        <INPUT type="submit" value="エリア・沿線・駅検索ページ" class="btn" style="width:200px">
        <INPUT type="hidden" name="mode" value="search" />
      </FORM>
    </DIV>
  </DIV>
  </BODY>
</HTML>
