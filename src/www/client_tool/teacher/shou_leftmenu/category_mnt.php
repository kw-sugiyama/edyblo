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
require_once ( SYS_PATH."dbif/basedb_ClientClass.php" );
require_once ( SYS_PATH."dbif/basedb_CategoryClass.php" );
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
$obj = new basedb_CategoryClassTblAccess;
$obj->conn = $obj_conn->conn;
$obj->jyoken["cg_deldate"] = 1;
$obj->jyoken["cg_clid"] = $_SESSION["_cl_id"];
$obj->jyoken["cg_id"] = $_POST["cg_id"];
list( $intNum , $intTotal ) = $obj->basedb_GetCategory( 1 , -1 );
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

		$cg_id = htmlspecialchars ($arrData["cg_id"]);
		$cg_clid = htmlspecialchars ($arrData["cg_clid"]);
		$cg_stat = htmlspecialchars ($arrData["cg_stat"]);
		$cg_dispno = htmlspecialchars ($arrData["cg_dispno"]);
		$cg_topflg = htmlspecialchars ($arrData["cg_topflg"]);
		$cg_stitle = htmlspecialchars ($arrData["cg_stitle"]);
		$cg_ltitle = htmlspecialchars ($arrData["cg_ltitle"]);
		$cg_upddate = htmlspecialchars ($arrData["cg_upddate"]);

		if($cg_topflg == "1"){
			$topFlgCheck1 = "checked";
			$strTopNameDis = "";
		}else if($cg_topflg == "9"){
			$topFlgCheck2 = "checked";
			$strTopNameDis = " disabled";
		}
		
		if($cg_stat == "1" ){
			$CateFlgCheck1 = " checked";
		}else if( $cg_stat == "9" ){
			$CateFlgCheck2 = " checked";
		}
	if($_POST['mode'] == "EDIT"){

		$strDelTag = "";
		$strDelTag .= "          <form action=\"category_upd.php\" method=\"POST\" name=\"del_form\">\n";
		$strDelTag .= "          <td align=\"center\" valign=\"top\">\n";
		$strDelTag .= "            <input type=\"submit\" value=\"削除する\" class=\"btn_nosize\" />\n";
		$strDelTag .= "            <input type=\"hidden\" name=\"mode\" value=\"DEL\" />\n";
		$strDelTag .= "            <input type=\"hidden\" name=\"cg_id\" value=\"{$cg_id}\" />\n";
		$strDelTag .= "            <input type=\"hidden\" name=\"cg_clid\" value=\"{$_SESSION['_cl_id']}\" />\n";
		$strDelTag .= "            <input type=\"hidden\" name=\"cg_type\" value=\"{$_POST['cg_type']}\" />\n";
		$strDelTag .= "            <input type=\"hidden\" name=\"cl_id\" value=\"{$_POST['cl_id']}\" />\n";
		$strDelTag .= "            <input type=\"hidden\" name=\"cg_upddate\" value=\"{$cg_upddate}\" />\n";
		$strDelTag .= "          </td>\n";
		$strDelTag .= "          </form>\n";


		$modeName = "修正";
	}else if($_POST["mode"]=="NEW"){
		$modeName = "登録";
	}

	if($_POST['cg_type']==3){
	        $dispTopValue .= "<DIV id=\"title\" ALIGN=\"left\">TOP表示用</DIV>\n";
	        $dispTopValue .= "<TABLE id=\"category\" cellspacing=\"0\">\n";
	        $dispTopValue .= "<tr>\n";
	        $dispTopValue .= "  <th class=\"must\">TOP表示／非表示</th>\n";
	        $dispTopValue .= "  <td>\n";
	        $dispTopValue .= "    <input type=\"radio\" name=\"cg_topflg\" value=\"1\" id=\"top1\" {$topFlgCheck1} onClick=\"CateChangeUse( this.form , 1 )\" /><label for=\"top1\">表示</label>\n";
	        $dispTopValue .= "    <input type=\"radio\" name=\"cg_topflg\" value=\"9\" id=\"top9\" {$topFlgCheck2} onClick=\"CateChangeUse( this.form , 9 )\" /><label for=\"top9\">非表示</label><BR>\n";
	        $dispTopValue .= "    <FONT COLOR=\"#FF0000\">※表示を選択すると上記で設定したカテゴリをブログＴＯＰ中央に<BR>掲載することができます。</FONT>\n";
	        $dispTopValue .= "  </td>\n";
	        $dispTopValue .= "</tr>\n";
	        $dispTopValue .= "<tr>\n";
	        $dispTopValue .= "  <th>ＴＯＰ表示名</th>\n";
	        $dispTopValue .= "  <td><input id=\"i4\" type=\"text\" name=\"cg_ltitle\" value=\"{$cg_ltitle}\" maxlength=\"20\" style=\"width:250px\" onFocus='Text(\"i4\", 1)' onBlur='Text(\"i4\", 2)' {$strTopNameDis} /> <font color=\"#FF0000\">(20文字以内)<BR>※ブログＴＯＰ中央に表記したいタイトルを入力してください。</font></td>\n";
	        $dispTopValue .= "</tr>\n";
	        $dispTopValue .= "</table>\n";
	        $jsFile = "category.js";
	}else{
		$jsFile = "category2.js";
		$dispTopValue .= "<input type=\"hidden\" name=\"cg_topflg\" value=\"9\">\n";
	        $dispTopValue .= "<input type=\"hidden\" name=\"cg_ltitle\" value=\"\">\n";
	}

}else{
	if($_POST['mode'] == "EDIT"){

		$cg_id = htmlspecialchars ($obj->categorydat[0]["cg_id"]);
		$cg_clid = htmlspecialchars ($obj->categorydat[0]["cg_clid"]);
		$cg_stat = htmlspecialchars ($obj->categorydat[0]["cg_stat"]);
		$cg_dispno = htmlspecialchars ($obj->categorydat[0]["cg_dispno"]);
		$cg_stitle = htmlspecialchars ($obj->categorydat[0]["cg_stitle"]);
		$cg_ltitle = htmlspecialchars ($obj->categorydat[0]["cg_ltitle"]);
		$cg_topflg = htmlspecialchars ($obj->categorydat[0]["cg_topflg"]);
		$cg_upddate = htmlspecialchars ($obj->categorydat[0]["cg_upddate"]);

		if($cg_topflg == "1"){
			$topFlgCheck1 = "checked";
			$strTopNameDis = "";
		}else if($cg_topflg == "9"){
			$topFlgCheck2 = "checked";
			$strTopNameDis = " disabled";
		}
		
		if($cg_stat == "1" ){
			$CateFlgCheck1 = " checked";
		}else if( $cg_stat == "9" ){
			$CateFlgCheck2 = " checked";
		}

		$strDelTag = "";
		$strDelTag .= "          <form action=\"category_upd.php\" method=\"POST\" name=\"del_form\">\n";
		$strDelTag .= "          <td align=\"center\" valign=\"top\">\n";
		$strDelTag .= "            <input type=\"submit\" value=\"削除する\" class=\"btn_nosize\" />\n";
		$strDelTag .= "            <input type=\"hidden\" name=\"mode\" value=\"DEL\" />\n";
		$strDelTag .= "            <input type=\"hidden\" name=\"cg_id\" value=\"{$cg_id}\" />\n";
		$strDelTag .= "            <input type=\"hidden\" name=\"cg_clid\" value=\"{$_SESSION['_cl_id']}\" />\n";
		$strDelTag .= "            <input type=\"hidden\" name=\"cg_type\" value=\"{$_POST['cg_type']}\" />\n";
		$strDelTag .= "            <input type=\"hidden\" name=\"cl_id\" value=\"{$_POST['cl_id']}\" />\n";
		$strDelTag .= "            <input type=\"hidden\" name=\"cg_ltitle\" value=\"{$cg_ltitle}\" />\n";
		$strDelTag .= "            <input type=\"hidden\" name=\"cg_upddate\" value=\"{$cg_upddate}\" />\n";
		$strDelTag .= "          </td>\n";
		$strDelTag .= "          </form>\n";


		$modeName = "修正";
	}else if($_POST["mode"]=="NEW"){
		$modeName = "登録";
	}

	if($_POST['cg_type']==3){
	        $dispTopValue .= "<DIV id=\"title\" ALIGN=\"left\">TOP表示用</DIV>\n";
	        $dispTopValue .= "<TABLE id=\"category\" cellspacing=\"0\">\n";
	        $dispTopValue .= "<tr>\n";
	        $dispTopValue .= "  <th class=\"must\">TOP表示／非表示</th>\n";
	        $dispTopValue .= "  <td>\n";
	        $dispTopValue .= "    <input type=\"radio\" name=\"cg_topflg\" value=\"1\" id=\"top1\" {$topFlgCheck1} onClick=\"CateChangeUse( this.form , 1 )\" /><label for=\"top1\">表示</label>\n";
	        $dispTopValue .= "    <input type=\"radio\" name=\"cg_topflg\" value=\"9\" id=\"top9\" {$topFlgCheck2} onClick=\"CateChangeUse( this.form , 9 )\" /><label for=\"top9\">非表示</label><BR>\n";
	        $dispTopValue .= "    <FONT COLOR=\"#FF0000\">※表示を選択すると上記で設定したカテゴリをブログＴＯＰ中央に<BR>掲載することができます。</FONT>\n";
	        $dispTopValue .= "  </td>\n";
	        $dispTopValue .= "</tr>\n";
	        $dispTopValue .= "<tr>\n";
	        $dispTopValue .= "  <th>ＴＯＰ表示名</th>\n";
	        $dispTopValue .= "  <td><input id=\"i4\" type=\"text\" name=\"cg_ltitle\" value=\"{$cg_ltitle}\" maxlength=\"20\" style=\"width:250px\" onFocus='Text(\"i4\", 1)' onBlur='Text(\"i4\", 2)' {$strTopNameDis} /> <font color=\"#FF0000\">(20文字以内)<BR>※ブログＴＯＰ中央に表記したいタイトルを入力してください。</font></td>\n";
	        $dispTopValue .= "</tr>\n";
	        $dispTopValue .= "</table>\n";
	        $jsFile = "category.js";
	}else{
		$jsFile = "category2.js";
		$dispTopValue .= "<input type=\"hidden\" name=\"cg_topflg\" value=\"9\">\n";
	        $dispTopValue .= "<input type=\"hidden\" name=\"cg_ltitle\" value=\"\">\n";
	}
}
/*--------------------------------------------------------
	ＨＴＭＬ生成
--------------------------------------------------------*/
?>
<HTML>
  <HEAD>
    <TITLE>塾ブログ - クライアントツール</TITLE>
    <META http-equiv="Content-Type" content="text/html;charset=EUC-JP" />
    <META http-equiv="Content-Style-Type" content="text/css" />
    <META http-equiv="Content-Script-Type" content="text/javascript" />
    <LINK rel="stylesheet" type="text/css" href="../share/css/category.css" />
    <SCRIPT type="text/javascript" src="../share/js/<?=$jsFile?>"></SCRIPT>
    <SCRIPT type="text/javascript" src="../share/js/input_check.js"></SCRIPT>
    <NOSCRIPT><META http-equiv="Refresh" content="1;URL=../jserror.html"></NOSCRIPT>
  </HEAD>
  <BODY>
    <div align="center">
      <DIV id="title" ALIGN="left">カテゴリメニュー用</DIV>
      <table id="category" cellspacing="0">
        <tr>
          <form action="category_upd.php" method="POST" name="admin">
          <th class="must">状態</th>
          <td>
            <input type="radio" name="cg_stat" value="1" id="kengen1" <?=$CateFlgCheck1?>/><label for="kengen1">表示</label>
            <input type="radio" name="cg_stat" value="9" id="kengen9" <?=$CateFlgCheck2?>/><label for="kengen9">非表示</label><BR>
	    <FONT COLOR="#FF0000">※表示を選択すると、ブログＴＯＰ左側のカテゴリが追加されます。</FONT>
          </td>
        </tr>
        <tr>
          <th class="must">カテゴリー名</th>
          <td><input id="i1" type="text" name="cg_stitle" value="<?=$cg_stitle?>" maxlength="12" style="width:160px" onFocus='Text("i1", 1)' onBlur='Text("i1", 2)' /> <font color="#FF0000">(12文字以内)</font></td>
        </tr>
        <input type="hidden" name="cg_dispno" value="<?=$cg_dispno?>"/>
      </TABLE>
      <BR><BR>
<?=$dispTopValue?>
      <br />
      <table>
        <tr>
          <td align="center" valign="top">
            <input type="button" value="登録する" class="btn_nosize" onclick="CategoryInputCheck( this.form , this.form )" />
            <input type="hidden" name="mode" value="<?=$_POST['mode']?>" />
            <input type="hidden" name="cg_id" value="<?=$cg_id?>" />
            <input type="hidden" name="cg_clid" value="<?=$_SESSION['_cl_id']?>" />
            <input type="hidden" name="cg_type" value="<?=$_POST['cg_type']?>" />
            <input type="hidden" name="lm_id" value="<?=$_POST['lm_id']?>" />
            <input type="hidden" name="cg_upddate" value="<?=$cg_upddate?>" />
            <input type="hidden" name="cg_stat_lastupd" value="<?=$cg_stat?>" />
            <input type="hidden" name="cg_topflg_lastupd" value="<?=$cg_topflg?>" />
          </td>
          </form>
<?=$strDelTag?>
          <form method="POST" action="category_main.php">
          <td align="center" valign="top">
            <input type="submit" name="bak" value="戻る" class="btn_nosize" />
            <input type="hidden" name="cg_type" value="<?=$_POST['cg_type']?>" />
            <input type="hidden" name="lm_id" value="<?=$_POST['lm_id']?>" />
          </td>
          </form>
        </tr>
      </table>
    </DIV>
  </body>
</HTML>
