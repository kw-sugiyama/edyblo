<?
/******************************************************************************
<< 不動産ブログ　Ver.1.O.0 >>
	Name: category_upd.php
	Version: 1.0.0
	Function: カテゴリ情報 登録／修正／削除
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
require_once ( SYS_PATH."dbif/basedb_CategoryClass.php" );
require_once ( SYS_PATH."dbif/basedb_ClientClass.php" );
require_once ( SYS_PATH."common/base_common.php" );
require_once ( SYS_PATH."common/sys_common.php" );
include_once ( SYS_PATH."common/error.class.php" );


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


/*---------------------------------------------------------
	処理部分
---------------------------------------------------------*/
$athComment = "";
$athComment .= "<INPUT TYPE=\"hidden\" NAME=\"error_mode\" VALUE=\"on\">";
FOREACH( $_POST as $key => $val ){
	$val = htmlspecialchars( stripslashes( $val ) );
        $athComment .= "<INPUT type=\"hidden\" name=\"{$key}\" value=\"{$val}\">\n";
}


$obj_no = new basedb_CategoryClassTblAccess;
$obj_no->conn = $obj_conn->conn;
$obj_no->jyoken["cg_clid"] = $_POST["lm_id"];
$obj_no->jyoken["cg_stat"] = 1;
$obj_no->jyoken["cg_type"] = $_POST['cg_type'];
$obj_no->jyoken["cg_deldate"] = 1;
list($noCnt,$noTotal) = $obj_no->basedb_GetCategory(1,-1);
if( $noCnt == -1 ){
	$arrOther["ath_comment"] .= "<INPUT TYPE=\"hidden\" NAME=\"stpos\" VALUE=\"{$_POST['stpos']}\">";
	$arrOther["ath_comment"] .= "<input type=\"hidden\" name=\"cg_type\" value=\"{$_POST['cg_type']}\" />";
	$arrOther["ath_comment"] .= $athComment;
	$obj_error->ViewErrMessage( "INS_ERROR" , "ALL" , "category_mnt.php" , $arrOther );
	exit;
}

$max = 0;
for($noX=0;$noX<$noCnt;$noX++){
	if($obj_no->categorydat[$noX]["cg_dispno"] > $max){
	$max = $obj_no->categorydat[$noX]["cg_dispno"]; 
	}
}

if($_POST['mode']=="NEW" && $_POST['cg_stat']!=9|| $_POST['cg_stat_lastupd']==9 && $_POST['cg_stat']==1){
	$_POST["cg_dispno"] = $max + 1;
}else if($_POST['mode']=="EDIT" && $_POST['cg_stat']!=9){
	$_POST['cg_dispno'] = $_POST['cg_dispno'];
}else if($_POST['cg_stat']==9){
	$_POST['cg_dispno'] = 999;
}

switch( $_POST["mode"] ){
	case 'NEW':

		$obj_no = new basedb_CategoryClassTblAccess;
		$obj_no->conn = $obj_conn->conn;
		$obj_no->jyoken["cg_clid"] = $_POST["lm_id"];
		$obj_no->jyoken["cg_stat"] = 1;
		$obj_no->jyoken["cg_type"] = $_POST['cg_type'];
		$obj_no->jyoken["cg_deldate"] = 1;
		list($noCnt,$noTotal) = $obj_no->basedb_GetCategory(1,-1);
                if( $noCnt == -1 ){
                        $arrOther["ath_comment"] .= "<INPUT TYPE=\"hidden\" NAME=\"stpos\" VALUE=\"{$_POST['stpos']}\">";
			$arrOther["ath_comment"] .= "<input type=\"hidden\" name=\"cg_type\" value=\"{$_POST['cg_type']}\" />";
			$arrOther["ath_comment"] .= $athComment;
                        $obj_error->ViewErrMessage( "INS_ERROR" , "ALL" , "category_mnt.php" , $arrOther );
                        exit;
                }

		$max = 0;
		for($noX=0;$noX<$noCnt;$noX++){
		  if($obj_no->categorydat[$noX]["cg_dispno"] > $max){
		   $max = $obj_no->categorydat[$noX]["cg_dispno"]; 
		  }
		}
		$_POST["cg_dispno"] = $max + 1;


		
		$obj_new = new basedb_CategoryClassTblAccess;
		$obj_new->conn = $obj_conn->conn;
		$obj_new->categorydat[0]["cg_clid"] = $_POST["lm_id"];
		$obj_new->categorydat[0]["cg_stat"] = $_POST["cg_stat"];
		$obj_new->categorydat[0]["cg_type"] = $_POST["cg_type"];
		$obj_new->categorydat[0]["cg_stitle"] = $_POST["cg_stitle"];
		$obj_new->categorydat[0]["cg_dispno"] = $_POST["cg_dispno"];
		$obj_new->categorydat[0]["cg_topflg"] = $_POST["cg_topflg"];
		$obj_new->categorydat[0]["cg_ltitle"] = $_POST["cg_ltitle"];
		$obj_new->categorydat[0]["cg_adminid"] = NULL;
		$suc = $obj_new->basedb_InsCategory();
                if( $suc == -1 ){
			$arrOther["ath_comment"] = "";
                        $arrOther["ath_comment"] = "<INPUT TYPE=\"hidden\" NAME=\"stpos\" VALUE=\"{$_POST['stpos']}\">";
			$arrOther["ath_comment"] .= "<input type=\"hidden\" name=\"cg_type\" value=\"{$_POST['cg_type']}\" />";
			$arrOther["ath_comment"] .= $athComment;
                        $obj_error->ViewErrMessage( "INS_ERROR" , "ALL" , "category_mnt.php" , $arrOther );
                        exit;
                }
                if( $suc == 2 ){
			$arrOther["ath_comment"] = "";
                        $arrOther["ath_comment"] = "<INPUT TYPE=\"hidden\" NAME=\"stpos\" VALUE=\"{$_POST['stpos']}\">";
			$arrOther["ath_comment"] .= "<input type=\"hidden\" name=\"cg_type\" value=\"{$_POST['cg_type']}\" />";
			$arrOther["ath_comment"] .= $athComment;
                        $obj_error->ViewErrMessage( "DISP_NO" , "ALL" , "category_mnt.php" , $arrOther );
                        exit;
                }
                if( $suc == 10 ){
			$arrOther["ath_comment"] = "";
                        $arrOther["ath_comment"] = "<INPUT TYPE=\"hidden\" NAME=\"stpos\" VALUE=\"{$_POST['stpos']}\">";
			$arrOther["ath_comment"] .= "<input type=\"hidden\" name=\"cg_type\" value=\"{$_POST['cg_type']}\" />";
			$arrOther["ath_comment"] .= $athComment;
                        $obj_error->ViewErrMessage( "CATE_TOP_FLG" , "ALL" , "category_mnt.php" , $arrOther );
                        exit;
                }
		$message = "カテゴリを登録しました。";
		break;
		
		
	case 'EDIT':
		$obj_rev = new basedb_CategoryClassTblAccess;
		$obj_rev->conn = $obj_conn->conn;
		$obj_rev->categorydat[0]["cg_id"] = $_POST["cg_id"];
		$obj_rev->categorydat[0]["cg_clid"] = $_POST["lm_id"];
		$obj_rev->categorydat[0]["cg_type"] = $_POST["cg_type"];
		$obj_rev->categorydat[0]["cg_stat"] = $_POST["cg_stat"];
		$obj_rev->categorydat[0]["cg_stitle"] = $_POST["cg_stitle"];
		$obj_rev->categorydat[0]["cg_dispno"] = $_POST["cg_dispno"];
		$obj_rev->categorydat[0]["cg_topflg"] = $_POST["cg_topflg"];
		$obj_rev->categorydat[0]["cg_ltitle"] = $_POST["cg_ltitle"];
		$obj_rev->categorydat[0]["cg_adminid"] = NULL;
		$obj_rev->categorydat[0]["cg_upddate"] = $_POST["cg_upddate"];
		$suc = $obj_rev->basedb_UpdCategory();
                if( $suc == -1 ){
			$arrOther["ath_comment"] = "";
                        $arrOther["ath_comment"] = "<INPUT TYPE=\"hidden\" NAME=\"stpos\" VALUE=\"{$_POST['stpos']}\">";
			$arrOther["ath_comment"] .= "<input type=\"hidden\" name=\"cg_type\" value=\"{$_POST['cg_type']}\" />";
			$arrOther["ath_comment"] .= $athComment;
                        $obj_error->ViewErrMessage( "UPD_ERROR" , "ALL" , "category_mnt.php" , $arrOther );
                        exit;
                }
                if( $suc == 1 ){
			$arrOther["ath_comment"] = "";
                        $arrOther["ath_comment"] = "<INPUT TYPE=\"hidden\" NAME=\"stpos\" VALUE=\"{$_POST['stpos']}\">";
			$arrOther["ath_comment"] .= "<input type=\"hidden\" name=\"cg_type\" value=\"{$_POST['cg_type']}\" />";
                        $obj_error->ViewErrMessage( "DOUBLE_UPD" , "ALL" , "category_main.php" , $arrOther );
                        exit;
                }
                if( $suc == 2 ){
			$arrOther["ath_comment"] = "";
                        $arrOther["ath_comment"] = "<INPUT TYPE=\"hidden\" NAME=\"stpos\" VALUE=\"{$_POST['stpos']}\">";
			$arrOther["ath_comment"] .= "<input type=\"hidden\" name=\"cg_type\" value=\"{$_POST['cg_type']}\" />";
			$arrOther["ath_comment"] .= $athComment;
                        $obj_error->ViewErrMessage( "DISP_NO" , "ALL" , "category_mnt.php" , $arrOther );
                        exit;
                }
                if( $suc == 10 ){
			$arrOther["ath_comment"] = "";
                        $arrOther["ath_comment"] = "<INPUT TYPE=\"hidden\" NAME=\"stpos\" VALUE=\"{$_POST['stpos']}\">";
			$arrOther["ath_comment"] .= "<input type=\"hidden\" name=\"cg_type\" value=\"{$_POST['cg_type']}\" />";
			$arrOther["ath_comment"] .= $athComment;
                        $obj_error->ViewErrMessage( "CATE_TOP_FLG" , "ALL" , "category_mnt.php" , $arrOther );
                        exit;
                }
		$message = "カテゴリ情報を修正しました。";
		break;
		
		
	case 'DEL':
		$obj_del = new basedb_CategoryClassTblAccess;
		$obj_del->conn = $obj_conn->conn;
		$obj_del->categorydat[0]["cg_id"] = $_POST["cg_id"];
		$obj_del->categorydat[0]["cg_upddate"] = $_POST["cg_upddate"];
		$suc = $obj_del->basedb_DelCategory(0);
                if( $suc != 0 ){
			$arrOther["ath_comment"] = "";
                        $arrOther["ath_comment"] = "<INPUT TYPE=\"hidden\" NAME=\"stpos\" VALUE=\"{$_POST['stpos']}\">";
			$arrOther["ath_comment"] .= "<input type=\"hidden\" name=\"cg_type\" value=\"{$_POST['cg_type']}\" />";
                        $obj_error->ViewErrMessage( "DEL_ERROR" , "ALL" , "category_main.php" , $arrOther );
                        exit;
                }
		$message = "指定されたカテゴリ情報を削除しました。";
		break;

        case 'DISP':
		$disp_cg_id = split("/",$_POST['cg_id']);
		$disp_cg_upddate = split("/",$_POST['cg_upddate']);
		$disp_cg_dispno = split("/",$_POST['cg_dispno']);
                $obj_dsp = new basedb_CategoryClassTblAccess;
		$athComment = "";
		$athComment .= "<INPUT TYPE=\"hidden\" NAME=\"error_mode\" VALUE=\"on\">";
		$athComment .= "<INPUT TYPE=\"hidden\" NAME=\"num\" VALUE=\"{$_POST['num']}\">";
		FOREACH( $disp_cg_dispno as $key => $val ){
			$val = stripslashes($val);
		        $athComment .= "<INPUT type=\"hidden\" name=\"{$key}\" value=\"{$val}\">\n";
		}
                $obj_dsp->conn = $obj_conn->conn;
                $obj_dsp->categorydat[0]["intCnt"] = $_POST["num"];
		for($iX=0;$iX<$_POST['intCnt'];$iX++){
               		$obj_dsp->categorydat[$iX]["cg_id"] = $disp_cg_id[$iX];
               		$obj_dsp->categorydat[$iX]["cg_upddate"] = $disp_cg_upddate[$iX];
               		$obj_dsp->categorydat[$iX]["cg_dispno"] = $disp_cg_dispno[$iX];
		}
                $suc = $obj_dsp->basedb_DspCategory();
                if( $suc == -1 ){
			$arrOther["ath_comment"] = "";
                        $arrOther["ath_comment"] = "<INPUT TYPE=\"hidden\" NAME=\"stpos\" VALUE=\"{$_POST['stpos']}\">";
			$arrOther["ath_comment"] .= "<input type=\"hidden\" name=\"cg_type\" value=\"{$_POST['cg_type']}\" />";
			$arrOther["ath_comment"] .= $athComment;
                        $obj_error->ViewErrMessage( "UPD_ERROR" , "ALL" , "category_main.php" , $arrOther );
                        exit;
                }
                if( $suc == 1 ){
			$arrOther["ath_comment"] = "";
                        $arrOther["ath_comment"] = "<INPUT TYPE=\"hidden\" NAME=\"stpos\" VALUE=\"{$_POST['stpos']}\">";
			$arrOther["ath_comment"] .= "<input type=\"hidden\" name=\"cg_type\" value=\"{$_POST['cg_type']}\" />";
                        $obj_error->ViewErrMessage( "DOUBLE_UPD" , "ALL" , "category_main.php" , $arrOther );
                        exit;
                }
                if( $suc == 2 ){
			$arrOther["ath_comment"] = "";
                        $arrOther["ath_comment"] = "<INPUT TYPE=\"hidden\" NAME=\"stpos\" VALUE=\"{$_POST['stpos']}\">";
			$arrOther["ath_comment"] .= "<input type=\"hidden\" name=\"cg_type\" value=\"{$_POST['cg_type']}\" />";
			$arrOther["ath_comment"] .= $athComment;
                        $obj_error->ViewErrMessage( "DISP_NO" , "ALL" , "category_main.php" , $arrOther );
                        exit;
                }
                $message = "表示順を反映しました。";
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
    <TITLE>塾ブログ - カテゴリ登録･修正･削除</title>
    <META http-equiv="Content-Type" content="text/html;charset=EUC-JP" />
    <META http-equiv="Content-Style-Type" content="text/css" />
    <META http-equiv="Content-Script-Type" content="text/javascript" />
    <LINK rel="stylesheet" href="../share/css/category.css" type="text/css" />
    <NOSCRIPT><META http-equiv="Refresh" content="1;URL=../jserror.html"></NOSCRIPT>
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
      <form name="form1" action="category_main.php" method="POST"> 
        <input type="submit" value=" 戻 る " class="btn" />
        <input type="hidden" name="cg_type" value="<?=$_POST['cg_type']?>" />
        <input type="hidden" name="lm_id" value="<?=$_POST['lm_id']?>" />
      </form>
    </div>
  </body>
</html>
