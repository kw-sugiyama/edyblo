<?
/******************************************************************************
<< 不動産ブログ　Ver.1.O.0 >>
	Name: category_main.php
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
require_once ( SYS_PATH."dbif/basedb_ClientClass.php" );
require_once ( SYS_PATH."dbif/basedb_CategoryClass.php" );
require_once ( SYS_PATH."dbif/basedb_MenuClass.php" );
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


/*--------------------------------------------------------
	処理部分
--------------------------------------------------------*/
	/**************************************
	  教室基本情報検索
	**************************************/
	$obj2 = new basedb_MenuClassTblAccess;
	$obj2->conn = $obj_conn->conn;
	$obj2->jyoken["mn_deldate"] = 1;
	$obj2->jyoken["mn_clid"] = $_SESSION['_cl_id'];
	$obj2->sort["mn_ldispno"] = 1;
	list( $num , $intTotal ) = $obj2->basedb_GetMenu( 1 , -1 );
	IF( $nmu == -1 ){
		$arrOther["ath_comment"] = "<INPUT TYPE=\"hidden\" NAME=\"stpos\" VALUE=\"{$_POST['stpos']}\">";
		$obj_error->ViewErrMessage( "SYSTEM" , "ALL" , SITE_PATH."blank.php" , $arrOther );
		exit;
	}


	/**************************************
	  基本メニュー情報テーブル生成
	**************************************/
	$mn_list_title = "";
	$mn_list_title .= "      <TR>\n";
	$mn_list_title .= "        <TD class=\"td_cl\" style=\"width:330px\" colspan=\"3\">左メニュー</TD>\n";
	$mn_list_title .= "        <TD class=\"td_cl\" style=\"width:680px\" colspan=\"4\">ヘッダーメニュー</TD>\n";
	$mn_list_title .= "        <TD class=\"td_cl\" style=\"width:100px\" rowspan=\"2\">　</TD>\n";
	$mn_list_title .= "      </TR>\n";
	$mn_list_title .= "      <TR>\n";
	$mn_list_title .= "        <TD class=\"td_cl\" style=\"width:100px\">状態</TD>\n";
	$mn_list_title .= "        <TD class=\"td_cl\" style=\"width:200px\">タイトル</TD>\n";
	$mn_list_title .= "        <TD class=\"td_cl\" style=\"width:30px\">表示順</TD>\n";
	$mn_list_title .= "        <TD class=\"td_cl\" style=\"width:150px\">状態</TD>\n";
	$mn_list_title .= "        <TD class=\"td_cl\" style=\"width:30px\">表示順</TD>\n";
	$mn_list_title .= "        <TD class=\"td_cl\" style=\"width:200px\">タイトル</TD>\n";
	$mn_list_title .= "        <TD class=\"td_cl\" style=\"width:200px\">ＵＲＬ</TD>\n";
//	$mn_list_title .= "        <TD class=\"td_cl\" style=\"width:100px\">　</TD>\n";
	$mn_list_title .= "      </TR>\n";


	$viewData = "";

	$i = 0;
	foreach($obj2->menudat as $key => $val){
		$lstatcheck1 = "";
		$lstatcheck2 = "";
		$hstatcheck1 = "";
		$hstatcheck2 = "";
		$hstatcheck3 = "";
		$dispnioStyle1 = "";
		$dispnioStyle2 = "";
		if($val['mn_lstat']==1){
			$lstatcheck1 = " checked";
		}else{
			$lstatcheck2 = " checked";
			$dispnioStyle1 = "background-color:#999999";
		}
		if($val['mn_hstat']==1){
			$hstatcheck1 = " checked";
		}else if($val['mn_hstat']==2){
			$hstatcheck2 = " checked";
			$dispnioStyle2 = "background-color:#999999";
		}else{
			$hstatcheck3 = " checked";
		}
		
		$viewData .= "      <FORM action=\"menu_upd.php\" method=\"POST\" onsubmit=\"return dispSet({$intTotal})\" name=\"disp_set[{$i}]\">\n";
		$viewData .= "      <TR>\n";
		$viewData .= "        <TD class=\"td_cm_center\"><input type=\"radio\" name=\"mn_lstat\" value=\"1\" {$lstatcheck1}>表示<input type=\"radio\" name=\"mn_lstat\" value=\"9\" {$lstatcheck2}>非表示</TD>\n";
		$viewData .= "        <TD class=\"td_cm_center\"><INPUT type=\"text\" id=\"mn_lname\" name=\"mn_lname\" value=\"{$val['mn_lname']}\" style=\"width:200px;\" onFocus='Text(\"mn_lname\", 1)' onBlur='Text(\"mn_lname\", 2)'></TD>\n";
		$viewData .= "        <TD class=\"td_cm_center\"><INPUT type=\"text\" id=\"mn_ldispno\" name=\"mn_ldispno\" value=\"{$val['mn_ldispno']}\" style=\"width:30px;{$dispnioStyle1}\" onFocus='Text(\"mn_ldispno\", 1)' onBlur='Text(\"mn_ldispno\", 2)'></TD>\n";
		$viewData .= "        <TD class=\"td_cm_center\"><input type=\"radio\" name=\"mn_hstat\" value=\"1\" {$hstatcheck1}>表示<input type=\"radio\" name=\"mn_hstat\" value=\"2\" {$hstatcheck2}>非表示<input type=\"radio\" name=\"mn_hstat\" value=\"3\" {$hstatcheck3}>代替</TD>\n";
		$viewData .= "        <TD class=\"td_cm_center\"><INPUT type=\"text\" id=\"mn_hdispno\" name=\"mn_hdispno\" value=\"{$val['mn_hdispno']}\" style=\"width:30px;{$dispnioStyle2}\" onFocus='Text(\"mn_hdispno\", 1)' onBlur='Text(\"mn_hdispno\", 2)'></TD>\n";
		$viewData .= "        <TD class=\"td_cm_center\"><INPUT type=\"text\" id=\"mn_hname\" name=\"mn_hname\" value=\"{$val['mn_hname']}\" style=\"width:200px;\" onFocus='Text(\"mn_hname\", 1)' onBlur='Text(\"mn_hname\", 2)'></TD>\n";
		$viewData .= "        <TD class=\"td_cm_center\"><INPUT type=\"text\" id=\"mn_hurl\" name=\"mn_hurl\" value=\"{$val['mn_hurl']}\" style=\"width:200px;\" onFocus='Text(\"mn_hurl\", 1)' onBlur='Text(\"mn_hurl\", 2)'></TD>\n";
		$viewData .= "        <TD class=\"td_cm_center\">\n";
		$viewData .= "          <INPUT type=\"submit\" name=\"go_mnt_2\" value=\"修正\" class=\"btn\" />\n";
		$viewData .= "          <INPUT type=\"hidden\" name=\"mode\" value=\"EDIT\" />\n";
		$viewData .= "          <INPUT type=\"hidden\" name=\"mn_id\" value=\"{$val['mn_id']}\" />\n";
		$viewData .= "          <INPUT type=\"hidden\" name=\"mn_upddate\" value=\"{$val['mn_upddate']}\" />\n";
		$viewData .= "          <INPUT type=\"hidden\" name=\"stpos\" value=\"{$_POST['stpos']}\" />\n";
		$viewData .= "        </TD>\n";
		$viewData .= "      </TR>\n";
		$viewData .= "      </FORM>\n";

		$i++;
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
    <TITLE>塾ブログ - クライアントツール</TITLE>
    <META http-equiv="Content-Type" content="text/html;charset=EUC-JP" />
    <META http-equiv="Content-Style-Type" content="text/css" />
    <META http-equiv="Content-Script-Type" content="text/javascript" />
    <LINK rel="stylesheet" type="text/css" href="../share/css/menubase.css" />
    <SCRIPT type="text/javascript" src="../share/js/category.js"></SCRIPT>
    <NOSCRIPT><META http-equiv="Refresh" content="1;URL=../jserror.html"></NOSCRIPT>
  </HEAD>
  <BODY>
    <TABLE>
      <TR>
        <FORM ACTION="../dai_leftmenu/leftmenu_main.php" METHOD="POST">
        <TD><IMG src="../share/images/menu_title.gif" alt="基本メニュー情報登録" /></TD>
        <TD>
          <INPUT type="hidden" name="lm_id" value="<?=$_POST['lm_id']?>"/>
          <?=$cg_title_img?><input type="submit" value="見出し登録に戻る" class="btn_nosize">
        </TD>
        </FORM>
      </TR>
    </TABLE>
    <HR color="#96BC69" />
    <DIV id="title">■基本メニュー情報登録</DIV>
    <br>
    <TABLE>
<?=$mn_list_title?>
<?=$viewData?>
    </TABLE>
    <BR />
  </BODY>
</HTML>
