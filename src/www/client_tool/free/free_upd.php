<?
require_once ( "../ini_sets_2.php" );
require_once ( "../html_delete.php" );
require_once ( SYS_PATH."dbif/dbcom_DBconnectClass.php" );
require_once ( SYS_PATH."dbif/basedb_TeacherClass.php" );
require_once ( SYS_PATH."dbif/basedb_ClientClass.php" );
require_once ( SYS_PATH."dbif/viewdb_BuildClass.php" );
require_once ( SYS_PATH."dbif/viewdb_ClientClass.php" );
require_once ( SYS_PATH."common/base_common.php" );
require_once ( SYS_PATH."common/sys_common.php" );
include_once ( SYS_PATH."common/error.class.php" );
require_once ( SYS_PATH."dbif/basedb_FreeTextClass.php" );
require_once ( SYS_PATH."common/ImageControl.class.php" );
require_once ( SYS_PATH."configs/param_file.conf" );
require_once ( SYS_PATH."configs/param_room.conf" );
require_once ( SYS_PATH."configs/param_base.conf" );
session_start();
$obj_error = new DispErrMessage();
require_once( SYS_PATH."common/db_connect.php" );
require_once("../login_chk.php");
$athComment = "";
$athComment .= "<INPUT TYPE=\"hidden\" NAME=\"error_mode\" VALUE=\"on\">";
FOREACH( $_POST as $key => $val ){
    if(!is_array($val)){
        $val = stripslashes(htmlspecialchars($val));
        $athComment .= "<INPUT type=\"hidden\" name=\"{$key}\" value=\"{$val}\">\n";
    }else{
        FOREACH( $val as $key2 => $val2 ){
            $val2 = stripslashes(htmlspecialchars($val2));
            $athComment .= "<INPUT type=\"hidden\" name=\"{$key[$key2]}\" value=\"{$val2}\">\n";
        }
    }
}
SWITCH( $_POST["mode"] ){
case "NEW":
    $obj_new = new basedb_FreeClassTblAccess;
    $obj_new->conn = $obj_conn->conn;
    $obj_new->freedat[0]["fr_clid"] = $_SESSION['_cl_id'];
    $obj_new->freedat[0]["fr_title"] = $_POST["fr_title"];
    $obj_new->freedat[0]["fr_html"] = $_POST['fr_html'];
    //登録
    $suc = $obj_new->basedb_Insfree ();

    if( $suc == -1 ){
        $arrOther["ath_comment"] = "<INPUT TYPE=\"hidden\" NAME=\"stpos\" VALUE=\"{$_POST['stpos']}\">";
        $arrOther['ath_comment'] .= $athComment;
        $obj_error->ViewErrMessage( "INS_ERROR" , "ALL" , "teacher_mnt.php" , $arrOther );
        exit;
    }

    $message = "記事情報を登録しました。";
    break;

case "EDIT":

    $obj_rev = new basedb_FreeClassTblAccess;
    $obj_rev->conn = $obj_conn->conn;
    $obj_rev->freedat[0]["fr_id"] = $_POST["fr_id"];
    //$obj_rev->freedat[0]["fr_clid"] = $_SESSION['_cl_id'];
    $obj_rev->freedat[0]["fr_title"] = $_POST["fr_title"];
    $obj_rev->freedat[0]["fr_html"] = $_POST["fr_html"];
    $suc = $obj_rev->basedb_UpdFree();

    $message = "記事情報を修正しました。";
    break;

    case 'DEL':
        $obj_del = new basedb_FreeClassTblAccess;
        $obj_del->conn = $obj_conn->conn;
        $obj_del->freedat[0]["fr_id"] = $_POST["fr_id"];
        $suc = $obj_del->basedb_DelFree();
        $message = "指定された記事情報を削除しました。";
        break;
}
require_once( SYS_PATH."common/db_close.php" );
?>
<HTML>
  <HEAD>
    <TITLE>塾ブログ - クライアント管理ツール</title>
    <META http-equiv="Content-Type" content="text/html;charset=EUC-JP" />
    <META http-equiv="Content-Style-Type" content="text/css" />
    <META http-equiv="Content-Script-Type" content="text/javascript" />
    <LINK rel="stylesheet" href="../share/css/diary.css" type="text/css" />
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
      <form name="form1" action="free_main.php" method="POST"> 
        <INPUT type="hidden" name="stpos" value="<?=$_POST['stpos']?>" />
        <input type="submit" value=" 戻 る " class="btn" />
      </form>
    </div>
  </body>
</html>
