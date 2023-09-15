<?
/******************************************************************************
<< 不動産ブログ　Ver.1.O.0 >>
	Name: cltpcate_upd.php
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
require_once ( SYS_PATH."dbif/basedb_CltpcateClass.php" );
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


$obj_no = new basedb_CltpcateClassTblAccess;
$obj_no->conn = $obj_conn->conn;
$obj_no->jyoken["cltpcate_stat"] = 1;
$obj_no->jyoken["cltpcate_del_date"] = 1;
list($noCnt,$noTotal) = $obj_no->basedb_GetCltpcate(1,-1);
if( $noCnt == -1 ){
echo("#1#error#");
	$arrOther["ath_comment"] .= "<INPUT TYPE=\"hidden\" NAME=\"stpos\" VALUE=\"{$_POST['stpos']}\">";
	$arrOther["ath_comment"] .= $athComment;
	$obj_error->ViewErrMessage( "INS_ERROR" , "ALL" , "cltpcate_mnt.php" , $arrOther );
	exit;
}

$max = 0;
for($noX=0;$noX<$noCnt;$noX++){
	if($obj_no->cltpcatedat[$noX]["cltpcate_disp_no"] > $max){
	$max = $obj_no->cltpcatedat[$noX]["cltpcate_disp_no"]; 
	}
}

if($_POST['mode']=="NEW" && $_POST['cltpcate_stat']!=9|| $_POST['cltpcate_stat_lastupd']==9 && $_POST['cltpcate_stat']==1){
	$_POST["cltpcate_disp_no"] = $max + 1;
}else if($_POST['mode']=="EDIT" && $_POST['cltpcate_stat']!=9){
	$_POST["cltpcate_disp_no"] = $_POST["cltpcate_disp_no"];
}else if($_POST['cltpcate_stat']==9){
	$_POST["cltpcate_disp_no"] = 999;
}

switch( $_POST["mode"] ){
	case 'NEW':

		$obj_no = new basedb_CltpcateClassTblAccess;
		$obj_no->conn = $obj_conn->conn;
		$obj_no->jyoken["cltpcate_stat"] = 1;
		$obj_no->jyoken["cltpcate_del_date"] = 1;
		list($noCnt,$noTotal) = $obj_no->basedb_GetCltpcate(1,-1);
                if( $noCnt == -1 ){
echo("#2#error#");
                        $arrOther["ath_comment"] .= "<INPUT TYPE=\"hidden\" NAME=\"stpos\" VALUE=\"{$_POST['stpos']}\">";
			$arrOther["ath_comment"] .= "<input type=\"hidden\" name=\"cltpcate_kind\" value=\"{$_POST['cltpcate_kind']}\" />";
			$arrOther["ath_comment"] .= $athComment;
                        $obj_error->ViewErrMessage( "INS_ERROR" , "ALL" , "cltpcate_mnt.php" , $arrOther );
                        exit;
                }

		if($_POST['cltpcate_stat']!=9){
			$max = 0;
			for($noX=0;$noX<$noCnt;$noX++){
			  if($obj_no->cltpcatedat[$noX]["cltpcate_disp_no"] > $max){
			   $max = $obj_no->cltpcatedat[$noX]["cltpcate_disp_no"]; 
			  }
			}
			$_POST["cltpcate_disp_no"] = $max + 1;
		}
		
		$obj_new = new basedb_CltpcateClassTblAccess;
		$obj_new->conn = $obj_conn->conn;
		$obj_new->cltpcatedat[0]["cltpcate_id"] = $_POST["cltpcate_id"];
		$obj_new->cltpcatedat[0]["cltpcate_stat"] = $_POST["cltpcate_stat"];
		$obj_new->cltpcatedat[0]["cltpcate_name"] = $_POST["cltpcate_name"];
		$obj_new->cltpcatedat[0]["cltpcate_disp_no"] = $_POST["cltpcate_disp_no"];
		$obj_new->cltpcatedat[0]["cltpcate_upd_date"] = $_POST["cltpcate_upd_date"];
		$suc = $obj_new->basedb_InsCltpcate();
                if( $suc == -1 ){
echo("#3#error#");
			$arrOther["ath_comment"] = "";
                        $arrOther["ath_comment"] = "<INPUT TYPE=\"hidden\" NAME=\"stpos\" VALUE=\"{$_POST['stpos']}\">";
			$arrOther["ath_comment"] .= "<input type=\"hidden\" name=\"cltpcate_kind\" value=\"{$_POST['cltpcate_kind']}\" />";
			$arrOther["ath_comment"] .= $athComment;
                        $obj_error->ViewErrMessage( "INS_ERROR" , "ALL" , "cltpcate_mnt.php" , $arrOther );
                        exit;
                }
                if( $suc == 2 ){
echo("#4#error#");
			$arrOther["ath_comment"] = "";
                        $arrOther["ath_comment"] = "<INPUT TYPE=\"hidden\" NAME=\"stpos\" VALUE=\"{$_POST['stpos']}\">";
			$arrOther["ath_comment"] .= "<input type=\"hidden\" name=\"cltpcate_kind\" value=\"{$_POST['cltpcate_kind']}\" />";
			$arrOther["ath_comment"] .= $athComment;
                        $obj_error->ViewErrMessage( "DISP_NO" , "ALL" , "cltpcate_mnt.php" , $arrOther );
                        exit;
                }
                if( $suc == 10 ){
echo("#5#error#");
			$arrOther["ath_comment"] = "";
                        $arrOther["ath_comment"] = "<INPUT TYPE=\"hidden\" NAME=\"stpos\" VALUE=\"{$_POST['stpos']}\">";
			$arrOther["ath_comment"] .= "<input type=\"hidden\" name=\"cltpcate_kind\" value=\"{$_POST['cltpcate_kind']}\" />";
			$arrOther["ath_comment"] .= $athComment;
                        $obj_error->ViewErrMessage( "CATE_TOP_FLG" , "ALL" , "cltpcate_mnt.php" , $arrOther );
                        exit;
                }
		$message = "カテゴリを登録しました。";
		break;
		
		
	case 'EDIT':
		$obj_rev = new basedb_CltpcateClassTblAccess;
		$obj_rev->conn = $obj_conn->conn;
		$obj_rev->cltpcatedat[0]["cltpcate_id"] = $_POST["cltpcate_id"];
		$obj_rev->cltpcatedat[0]["cltpcate_stat"] = $_POST["cltpcate_stat"];
		$obj_rev->cltpcatedat[0]["cltpcate_name"] = $_POST["cltpcate_name"];
		$obj_rev->cltpcatedat[0]["cltpcate_disp_no"] = $_POST["cltpcate_disp_no"];
		$obj_rev->cltpcatedat[0]["cltpcate_upd_date"] = $_POST["cltpcate_upd_date"];
		$suc = $obj_rev->basedb_UpdCltpcate();
                if( $suc == -1 ){
echo("#6#error#");
			$arrOther["ath_comment"] = "";
                        $arrOther["ath_comment"] = "<INPUT TYPE=\"hidden\" NAME=\"stpos\" VALUE=\"{$_POST['stpos']}\">";
			$arrOther["ath_comment"] .= "<input type=\"hidden\" name=\"cltpcate_kind\" value=\"{$_POST['cltpcate_kind']}\" />";
			$arrOther["ath_comment"] .= $athComment;
                        $obj_error->ViewErrMessage( "UPD_ERROR" , "ALL" , "cltpcate_mnt.php" , $arrOther );
                        exit;
                }
                if( $suc == 1 ){
echo("#7#error#");
			$arrOther["ath_comment"] = "";
                        $arrOther["ath_comment"] = "<INPUT TYPE=\"hidden\" NAME=\"stpos\" VALUE=\"{$_POST['stpos']}\">";
			$arrOther["ath_comment"] .= "<input type=\"hidden\" name=\"cltpcate_kind\" value=\"{$_POST['cltpcate_kind']}\" />";
                        $obj_error->ViewErrMessage( "DOUBLE_UPD" , "ALL" , "cltpcate_main.php" , $arrOther );
                        exit;
                }
                if( $suc == 2 ){
echo("#8#error#");
			$arrOther["ath_comment"] = "";
                        $arrOther["ath_comment"] = "<INPUT TYPE=\"hidden\" NAME=\"stpos\" VALUE=\"{$_POST['stpos']}\">";
			$arrOther["ath_comment"] .= "<input type=\"hidden\" name=\"cltpcate_kind\" value=\"{$_POST['cltpcate_kind']}\" />";
			$arrOther["ath_comment"] .= $athComment;
                        $obj_error->ViewErrMessage( "DISP_NO" , "ALL" , "cltpcate_mnt.php" , $arrOther );
                        exit;
                }
                if( $suc == 10 ){
echo("#9#error#");
			$arrOther["ath_comment"] = "";
                        $arrOther["ath_comment"] = "<INPUT TYPE=\"hidden\" NAME=\"stpos\" VALUE=\"{$_POST['stpos']}\">";
			$arrOther["ath_comment"] .= "<input type=\"hidden\" name=\"cltpcate_kind\" value=\"{$_POST['cltpcate_kind']}\" />";
			$arrOther["ath_comment"] .= $athComment;
                        $obj_error->ViewErrMessage( "CATE_TOP_FLG" , "ALL" , "cltpcate_mnt.php" , $arrOther );
                        exit;
                }
		$message = "カテゴリ情報を修正しました。";
		break;
		
		
	case 'DEL':
		$obj_del = new basedb_CltpcateClassTblAccess;
		$obj_del->conn = $obj_conn->conn;
		$obj_del->cltpcatedat[0]["cltpcate_id"] = $_POST["cltpcate_id"];
		$obj_del->cltpcatedat[0]["cltpcate_upd_date"] = $_POST["cltpcate_upd_date"];
		$suc = $obj_del->basedb_DelCltpcate(0);
                if( $suc != 0 ){
echo("#10#error#");
			$arrOther["ath_comment"] = "";
                        $arrOther["ath_comment"] = "<INPUT TYPE=\"hidden\" NAME=\"stpos\" VALUE=\"{$_POST['stpos']}\">";
			$arrOther["ath_comment"] .= "<input type=\"hidden\" name=\"cltpcate_kind\" value=\"{$_POST['cltpcate_kind']}\" />";
                        $obj_error->ViewErrMessage( "DEL_ERROR" , "ALL" , "cltpcate_main.php" , $arrOther );
                        exit;
                }
		$message = "指定されたカテゴリ情報を削除しました。";
		break;

        case 'DISP':
		$disp_cltpcate_id = split("/",$_POST['cltpcate_id']);
		$disp_cltpcate_upd_date = split("/",$_POST['cltpcate_upd_date']);
		$disp_cltpcate_disp_no = split("/",$_POST['cltpcate_disp_no']);
                $obj_dsp = new basedb_CltpcateClassTblAccess;
		$athComment = "";
		$athComment .= "<INPUT TYPE=\"hidden\" NAME=\"error_mode\" VALUE=\"on\">";
		$athComment .= "<INPUT TYPE=\"hidden\" NAME=\"num\" VALUE=\"{$_POST['num']}\">";
		FOREACH( $disp_cltpcate_disp_no as $key => $val ){
			$val = stripslashes($val);
		        $athComment .= "<INPUT type=\"hidden\" name=\"{$key}\" value=\"{$val}\">\n";
		}
                $obj_dsp->conn = $obj_conn->conn;
                $obj_dsp->cltpcatedat[0]["intCnt"] = $_POST["num"];
		for($iX=0;$iX<$_POST['intCnt'];$iX++){
               		$obj_dsp->cltpcatedat[$iX]["cltpcate_id"] = $disp_cltpcate_id[$iX];
               		$obj_dsp->cltpcatedat[$iX]["cltpcate_upd_date"] = $disp_cltpcate_upd_date[$iX];
               		$obj_dsp->cltpcatedat[$iX]["cltpcate_disp_no"] = $disp_cltpcate_disp_no[$iX];
		}
                $suc = $obj_dsp->basedb_DspCltpcate();
                if( $suc == -1 ){
echo("#11#error#");
			$arrOther["ath_comment"] = "";
                        $arrOther["ath_comment"] = "<INPUT TYPE=\"hidden\" NAME=\"stpos\" VALUE=\"{$_POST['stpos']}\">";
			$arrOther["ath_comment"] .= $athComment;
                        $obj_error->ViewErrMessage( "UPD_ERROR" , "ALL" , "cltpcate_main.php" , $arrOther );
                        exit;
                }
                if( $suc == 1 ){
echo("#12#error#");
			$arrOther["ath_comment"] = "";
                        $arrOther["ath_comment"] = "<INPUT TYPE=\"hidden\" NAME=\"stpos\" VALUE=\"{$_POST['stpos']}\">";
                        $obj_error->ViewErrMessage( "DOUBLE_UPD" , "ALL" , "cltpcate_main.php" , $arrOther );
                        exit;
                }
                if( $suc == 2 ){
echo("#13#error#");
			$arrOther["ath_comment"] = "";
                        $arrOther["ath_comment"] = "<INPUT TYPE=\"hidden\" NAME=\"stpos\" VALUE=\"{$_POST['stpos']}\">";
			$arrOther["ath_comment"] .= $athComment;
                        $obj_error->ViewErrMessage( "DISP_NO" , "ALL" , "cltpcate_main.php" , $arrOther );
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
    <TITLE>不動産ブログ - カテゴリ登録･修正･削除</title>
    <META http-equiv="Content-Type" content="text/html;charset=EUC-JP" />
    <META http-equiv="Content-Style-Type" content="text/css" />
    <META http-equiv="Content-Script-Type" content="text/javascript" />
    <LINK rel="stylesheet" href="../share/css/cltpcate.css" type="text/css" />
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
      <form name="form1" action="cltpcate_main.php" method="POST"> 
        <input type="submit" value=" 戻 る " class="btn" />
        <input type="hidden" name="cltpcate_kind" value="<?=$_POST['cltpcate_kind']?>" />
      </form>
    </div>
  </body>
</html>
