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
$obj = new basedb_CltpcateClassTblAccess;
$obj->conn = $obj_conn->conn;
$obj->jyoken["cltpcate_del_date"] = 1;
$obj->jyoken["cltpcate_id"] = $_POST["cltpcate_id"];
list( $intNum , $intTotal ) = $obj->basedb_GetCltpcate( 1 , -1 );
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
if($_POST['error_mode']=="on"){
	foreach($_POST as $key => $val){
		$arrData[$key] = stripslashes($val);
	}
		$cltpcate_id       = htmlspecialchars ($arrData["cltpcate_id"]);
		$cltpcate_stat     = htmlspecialchars ($arrData["cltpcate_stat"]);
		$cltpcate_name     = htmlspecialchars ($arrData["cltpcate_name"]);
		$cltpcate_disp_no  = htmlspecialchars ($arrData["cltpcate_disp_no"]);
		$cltpcate_upd_date = htmlspecialchars ($arrData["cltpcate_upd_date"]);

		if($cltpcate_stat == "1" ){
			$CateFlgCheck1 = " checked";
		}else if( $cltpcate_stat == "9" ){
			$CateFlgCheck2 = " checked";
		}
	if($_POST['mode'] == "EDIT"){

		$strDelTag = "";
		$strDelTag .= "          <form action=\"cltpcate_upd.php\" method=\"POST\" name=\"del_form\">\n";
		$strDelTag .= "          <td align=\"center\" valign=\"top\">\n";
		$strDelTag .= "            <input type=\"button\" value=\"削除する\" class=\"btn_nosize\" onclick=\"CltpcateDelchk( this.form , this.form )\" />\n";
		$strDelTag .= "            <input type=\"hidden\" name=\"mode\" value=\"DEL\" />\n";
		$strDelTag .= "            <input type=\"hidden\" name=\"cltpcate_id\" value=\"{$cltpcate_id}\" />\n";
		$strDelTag .= "            <input type=\"hidden\" name=\"cltpcate_upd_date\" value=\"{$cltpcate_upd_date}\" />\n";
		$strDelTag .= "          </td>\n";
		$strDelTag .= "          </form>\n";


		$modeName = "修正";
	}else if($_POST["mode"]=="NEW"){
		$modeName = "登録";
	}


}else{
	if($_POST['mode'] == "EDIT"){

		$cltpcate_id       = htmlspecialchars ($obj->cltpcatedat[0]["cltpcate_id"]);
		$cltpcate_stat     = htmlspecialchars ($obj->cltpcatedat[0]["cltpcate_stat"]);
		$cltpcate_name     = htmlspecialchars ($obj->cltpcatedat[0]["cltpcate_name"]);
		$cltpcate_disp_no  = htmlspecialchars ($obj->cltpcatedat[0]["cltpcate_disp_no"]);
		$cltpcate_upd_date = htmlspecialchars ($obj->cltpcatedat[0]["cltpcate_upd_date"]);

		if($cltpcate_stat == "1" ){
			$CateFlgCheck1 = " checked";
		}else if( $cltpcate_stat == "9" ){
			$CateFlgCheck2 = " checked";
		}

		$strDelTag = "";
		$strDelTag .= "          <form action=\"cltpcate_upd.php\" method=\"POST\" name=\"del_form\">\n";
		$strDelTag .= "          <td align=\"center\" valign=\"top\">\n";
		$strDelTag .= "            <input type=\"button\" value=\"削除する\" class=\"btn_nosize\" onclick=\"CltpcateDelchk( this.form , this.form )\" />\n";
		$strDelTag .= "            <input type=\"hidden\" name=\"mode\" value=\"DEL\" />\n";
		$strDelTag .= "            <input type=\"hidden\" name=\"cltpcate_id\" value=\"{$cltpcate_id}\" />\n";
		$strDelTag .= "            <input type=\"hidden\" name=\"cltpcate_upd_date\" value=\"{$cltpcate_upd_date}\" />\n";
		$strDelTag .= "          </td>\n";
		$strDelTag .= "          </form>\n";


		$modeName = "修正";
	}else if($_POST["mode"]=="NEW"){
		$modeName = "登録";
	}

}
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
    <LINK rel="stylesheet" type="text/css" href="../share/css/cltpcate.css" />
    <SCRIPT type="text/javascript" src="../share/js/cltpcate.js"></SCRIPT>
    <SCRIPT type="text/javascript" src="../share/js/input_check.js"></SCRIPT>
    <NOSCRIPT><META http-equiv="Refresh" content="1;URL=../jserror.html"></NOSCRIPT>
  </HEAD>
  <BODY>
    <div align="center">
      <table id="client" cellspacing="0">
        <tr>
          <form action="cltpcate_upd.php" method="POST" name="admin">
          <th class="must">状態</th>
          <td>
            <input type="radio" name="cltpcate_stat" value="1" id="kengen1" <?=$CateFlgCheck1?>/><label for="kengen1">表示</label>
            <input type="radio" name="cltpcate_stat" value="9" id="kengen9" <?=$CateFlgCheck2?>/><label for="kengen9">非表示</label>
          </td>
        </tr>
        <tr>
          <th class="must">カテゴリー名</th>
          <td><input id="i1" type="text" name="cltpcate_name" value="<?=$cltpcate_name?>" maxlength="12" style="width:160px" onFocus='Text("i1", 1)' onBlur='Text("i1", 2)' /> <font color="#FF0000">(12文字以内)</font></td>
        </tr>
        <input type="hidden" name="cltpcate_disp_no" value="<?=$cltpcate_disp_no?>"/>
      </TABLE>
      <BR><BR>
      <br />
      <table>
        <tr>
          <td align="center" valign="top">
            <input type="button" value="登録する" class="btn_nosize" onclick="CltpcateInputCheck( this.form , this.form )" />
            <input type="hidden" name="mode" value="<?=$_POST['mode']?>" />
            <input type="hidden" name="cltpcate_id" value="<?=$cltpcate_id?>" />
            <input type="hidden" name="cltpcate_upd_date" value="<?=$cltpcate_upd_date?>" />
          </td>
          </form>
<?=$strDelTag?>
          <form method="POST" action="cltpcate_main.php">
          <td align="center" valign="top">
            <input type="submit" name="bak" value="戻る" class="btn_nosize" />
          </td>
          </form>
        </tr>
      </table>
    </DIV>
  </body>
</HTML>
