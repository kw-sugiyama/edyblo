<?
require_once ( "../ini_sets_2.php" );
require_once ( "../html_delete.php" );
require_once ( SYS_PATH."dbif/dbcom_DBconnectClass.php" );
require_once ( SYS_PATH."dbif/basedb_TeacherClass.php" );
require_once ( SYS_PATH."dbif/basedb_ClientClass.php" );
require_once ( SYS_PATH."dbif/viewdb_BuildClass.php" );
require_once ( SYS_PATH."dbif/viewdb_ClientClass.php" );
require_once ( SYS_PATH."dbif/basedb_FreeTextClass.php" );
require_once ( SYS_PATH."common/base_common.php" );
require_once ( SYS_PATH."common/sys_common.php" );
include_once ( SYS_PATH."common/error.class.php" );
require_once ( SYS_PATH."common/ImageControl.class.php" );
require_once ( SYS_PATH."configs/param_file.conf" );
require_once ( SYS_PATH."configs/param_room.conf" );
require_once ( SYS_PATH."configs/param_base.conf" );
session_start();
$obj_error = new DispErrMessage();
require_once( SYS_PATH."common/db_connect.php" );
require_once("../login_chk.php");

if($_POST['error_mode']=="on"){
	foreach($_POST as $key => $val){
		$arrData[$key] = stripslashes($val);
	}

		$obj = new basedb_FreeClassTblAccess;
		$obj->conn = $obj_conn->conn;
		$obj->jyoken["fr_deldate"] = 1;
		$obj->jyoken["fr_id"] = $_POST['fr_id'];
        list( $infrnt , $intTotal ) = $obj->basedb_GetFree( 1 , -1 );
        /*----------------------------------------------------------*/ 
        // hiddenにデータ退避
        /*----------------------------------------------------------*/ 
		IF( $infrnt == -1 ){
			$arrOther["ath_comment"] = "<INPUT TYPE=\"hidden\" NAME=\"stpos\" VALUE=\"{$_POST['stpos']}\">";
			$obj_error->ViewErrMessage( "SYSTEM" , "ALL" , SITE_PATH."blank.php" , $arrOther );
			exit;
		}


		$fr_id = htmlspecialchars ($arrData["fr_id"]);
		$fr_clid = htmlspecialchars ($arrData["fr_clid"]);
		$fr_title= htmlspecialchars ($arrData["fr_title"]);
		$fr_html= htmlspecialchars ($arrData["fr_html"]);


        if($_POST['mode']=="EDIT"){
            /*----------------------------------------------------------*/ 
            //編集 エラーモード
            /*----------------------------------------------------------*/ 
		$modeName = "登録する";

		
		$DEL_VALUE = "";
		$DEL_VALUE .="<form action=\"free_upd.php\" method=\"POST\" name=\"del_form\">\n";
	        $DEL_VALUE .="<td align=\"center\" valign=\"top\">\n";
	        $DEL_VALUE .="    <input type=\"button\" value=\"削除する\" onclick=\"FreeDeleteCheck( this.form , this.form )\" class=\"btn_nosize\" style=\"width:150px;\" />\n";
	        $DEL_VALUE .="    <input type=\"hidden\" name=\"mode\" value=\"DEL\" />\n";
	        $DEL_VALUE .="    <input type=\"hidden\" name=\"fr_id\" value=\"{$fr_id}\" />\n";
	        $DEL_VALUE .="    <input type=\"hidden\" name=\"fr_upddate\" value=\"{$fr_upddate}\" />\n";
	        $DEL_VALUE .="    <INPUT type=\"hidden\" name=\"fr_img_lastupd\" value=\"{$fr_img_lastupd}\" />\n";
	        $DEL_VALUE .="</td>\n";
	        $DEL_VALUE .="</form>\n";


	}else if($_POST['mode']=="NEW"){
        /*----------------------------------------------------------*/ 
        //新規 エラーモード
        /*----------------------------------------------------------*/ 
		$modeName = "登録する";
	}
}else{
	if($_POST['mode']=="EDIT"){
        /*----------------------------------------------------------*/ 
        //編集
        /*----------------------------------------------------------*/ 
		$obj = new basedb_FreeClassTblAccess;
		$obj->conn = $obj_conn->conn;
		$obj->jyoken["fr_del_date"] = 1;
		$obj->jyoken["fr_id"] = $_POST['fr_id'];
		list( $infrnt , $intTotal ) = $obj->basedb_GetFree( 1 , -1 );
		IF( $infrnt == -1 ){
			$arrOther["ath_comment"] = "<INPUT TYPE=\"hidden\" NAME=\"stpos\" VALUE=\"{$_POST['stpos']}\">";
			$obj_error->ViewErrMessage( "SYSTEM" , "ALL" , SITE_PATH."blank.php" , $arrOther );
			exit;
        }
		$fr_id = htmlspecialchars ($obj->freedat[0]["fr_id"]);
        $fr_clid = ($obj->freedat[0]["fr_clid"]);

		$fr_title= ($obj->freedat[0]["fr_title"]);
		$fr_html= htmlspecialchars ($obj->freedat[0]["fr_html"]);

		$modeName = "登録する";
		
		$DEL_VALUE = "";
		$DEL_VALUE .="<form action=\"free_upd.php\" method=\"POST\" name=\"del_form\">\n";
	        $DEL_VALUE .="<td align=\"center\" valign=\"top\">\n";
	        $DEL_VALUE .="    <input type=\"button\" value=\"削除する\" onclick=\"FreeDeleteCheck( this.form , this.form )\" class=\"btn_nosize\" style=\"width:150px;\" />\n";
	        $DEL_VALUE .="    <input type=\"hidden\" name=\"mode\" value=\"DEL\" />\n";
	        $DEL_VALUE .="    <input type=\"hidden\" name=\"fr_id\" value=\"{$fr_id}\" />\n";
	        $DEL_VALUE .="    <input type=\"hidden\" name=\"fr_upddate\" value=\"{$fr_upddate}\" />\n";
	        $DEL_VALUE .="    <INPUT type=\"hidden\" name=\"fr_img_lastupd\" value=\"{$fr_img_lastupd}\" />\n";
	        $DEL_VALUE .="</td>\n";
	        $DEL_VALUE .="</form>\n";


    }else if($_POST['mode']=="NEW"){
        /*----------------------------------------------------------*/ 
        //新規
        /*----------------------------------------------------------*/ 

		$modeName = "登録する";

	}
}
//ＤＢ切断
require_once( SYS_PATH."common/db_close.php" );
?>
<HTML>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"
      xmlns:v="urn:schemas-microsoft-com:vml">
  <HEAD>
    <TITLE>塾ブログ - アカウント管理ツール</TITLE>
    <META http-equiv="Content-Type" content="text/html;charset=EUC-JP" />
    <META http-equiv="Content-Style-Type" content="text/css" />
    <META http-equiv="Content-Script-Type" content="text/javascript" />

    <LINK rel="stylesheet" type="text/css" href="../share/css/free.css" />
    <SCRIPT type="text/javascript" src="../share/js/input_check.js"></SCRIPT>
    <SCRIPT type="text/javascript" src="../share/js/free.js"></SCRIPT>

    <NOSCRIPT><META http-equiv="Refresh" content="1;URL=../jserror.html"></NOSCRIPT>
  </HEAD>
  <BODY>
    <div id="teacher">
      <table id="client" cellspacing="0">
        <tr>
        <form action="free_upd.php" method="POST" name="client" enctype="multipart/form-data">
          <th class="must">タイトル</th>
          <td><input id="i2" type="text" name="fr_title" value="<?=$fr_title?>" maxlength="30"  style="width:400px;" /></td>
        </tr>

        <tr>
          <th class="must">自由ＨＴＭＬ</th>
          <td>
            <TEXTAREA id="free_text" name="fr_html"  cols="70" rows="10"><?=$fr_html?></TEXTAREA>
          </td>
        </tr>
      </table>
    </div>
    <div align="center">
      <table width="500">
        <tr>
          <td align="center" valign="top">
            <input type="hidden" name="fr_id" value="<?=$fr_id?>" />
            <input type="button" value="<?=$modeName?>" class="btn_nosize" onclick="freeInputCheck( this.form , this.form )" style="width:150px;" />
            <input type="hidden" name="mode" value="<?=$_POST['mode']?>" />
            <input type="hidden" name="fr_upddate" value="<?=$fr_upddate?>" />
          </td>
          </form>
<?=$DEL_VALUE?>
          <form method="POST" action="free_main.php">
          <td align="center" valign="top">
            <input type="submit" name="bak" value="戻る" class="btn_nosize" style="width:150px;" />
            <INPUT type="hidden" name="stpos" value="<?=$_POST['stpos']?>" />
          </td>
          </form>
        </tr>
      </table>
    </div>
  </body>
</HTML>
