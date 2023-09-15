<?
/******************************************************************************
<< 不動産ブログ　Ver.1.O.0 >>
	Name: cltpbase_main.php
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
require_once ( SYS_PATH."dbif/basedb_AdminClass.php" );
require_once ( SYS_PATH."dbif/basedb_CltpbaseClass.php" );
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
$obj = new basedb_CltpbaseClassTblAccess;
$obj->conn = $obj_conn->conn;
$obj->jyoken["cltpbase_del_date"] = 1;
list( $num , $total ) = $obj->basedb_GetCltpbase( 1 , -1 );
IF( $num == -1 ){
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
    <NOSCRIPT><META http-equiv="Refresh" content="1;URL=../jserror.html"></NOSCRIPT>
  </HEAD>
  <BODY>
  <TABLE>
    <TR>
      <TD>
    <!--
        <IMG src="../share/images/cltpbase_title.gif" alt="基本情報設定" />
    -->
    
    <span style="font-size:15px;color:#6BD7B5;">基本情報設定</spann>

      </TD>
      <FORM ACTION="cltp_select.php" METHOD="POST">
      <TD>
        <input type="submit" value="機能選択に戻る" class="btn_nosize">
      </TD>
      </FORM>
    </TR>
  </TABLE>
    <HR color="#96BC69" />
    <br /><br />
    <TABLE>
      <TR>
        <FORM name="go_mnt" method="POST" action="cltpbase_mnt.php" target="_self">
        <TD><INPUT type="submit" value="基本情報を変更する" style="width:150" class="btn"/></TD>
        </FORM>
      </TR>
    </TABLE>
<BR>
    <DIV id="client">
      <TABLE>
        <TR>
          <TH>トピックタイトル１</TH>
          <TD><?=$viewData["cltpbase_topic_title_1"]?></TD>
        </TR>
        <TR>
          <TH>トピック記事１</TH>
          <TD><?=$viewData["cltpbase_topic_contents_1"]?></TD>
        </TR>
        <TR>
          <TH>トピックリンクURL１</TH>
          <TD><?=$viewData["cltpbase_topic_link_1"]?></TD>
        </TR>
        <TR>
          <TH>トピックタイトル２</TH>
          <TD><?=$viewData["cltpbase_topic_title_2"]?></TD>
        </TR>
        <TR>
          <TH>トピック記事２</TH>
          <TD><?=$viewData["cltpbase_topic_contents_2"]?></TD>
        </TR>
        <TR>
          <TH>トピックリンクURL２</TH>
          <TD><?=$viewData["cltpbase_topic_link_2"]?></TD>
        </TR>
        <TR>
          <TH>トピックタイトル３</TH>
          <TD><?=$viewData["cltpbase_topic_title_3"]?></TD>
        </TR>
        <TR>
          <TH>トピック記事３</TH>
          <TD><?=$viewData["cltpbase_topic_contents_3"]?></TD>
        </TR>
        <TR>
          <TH>トピックリンクURL３</TH>
          <TD><?=$viewData["cltpbase_topic_link_3"]?></TD>
        </TR>
        <TR>
          <TH>ＨＴＭＬ自由表記</TH>
          <TD><?=$viewData["cltpbase_html"]?></TD>
        </TR>
      </TABLE>
    </DIV>
    <br />
    <TABLE>
      <TR>
        <FORM name="go_mnt" method="POST" action="cltpbase_mnt.php" target="_self">
        <TD><INPUT type="submit" value="基本情報を変更する" style="width:150" class="btn"/></TD>
        </FORM>
      </TR>
    </TABLE>
  </BODY>
</HTML>
