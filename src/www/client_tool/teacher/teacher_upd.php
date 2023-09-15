<?
/******************************************************************************
<< ��ư���֥���Ver.1.O.0 >>
	Name: tc_upd.php
	Version: 1.0.0
	Function: �֥����ܾ��� ��Ͽ�����������
	Author: Click inc
	Date of creation: 2007/02
	History of modification:

	Copyright (C)2007 Click, inc. All Rights Reserverd.
******************************************************************************/

/*----------------------------------------------------------
  ɬ�ץե�����ƤӽФ�
----------------------------------------------------------*/
require_once ( "../ini_sets_2.php" );
require_once ( "../html_delete.php" );
require_once ( SYS_PATH."dbif/dbcom_DBconnectClass.php" );
require_once ( SYS_PATH."dbif/basedb_TeacherClass.php" );
require_once ( SYS_PATH."dbif/basedb_ClientClass.php" );
require_once ( SYS_PATH."dbif/basedb_TeacherClass.php" );
require_once ( SYS_PATH."dbif/viewdb_BuildClass.php" );
require_once ( SYS_PATH."dbif/viewdb_ClientClass.php" );
require_once ( SYS_PATH."common/base_common.php" );
require_once ( SYS_PATH."common/sys_common.php" );
include_once ( SYS_PATH."common/error.class.php" );
require_once ( SYS_PATH."common/ImageControl.class.php" );
require_once ( SYS_PATH."configs/param_file.conf" );
require_once ( SYS_PATH."configs/param_room.conf" );
require_once ( SYS_PATH."configs/param_base.conf" );


/*----------------------------------------------------------
  ���å������Ͽ����
----------------------------------------------------------*/
session_start();


/*----------------------------------------------------------
        ���顼���饹 - ���󥹥���
----------------------------------------------------------*/
$obj_error = new DispErrMessage();


/*----------------------------------------------------------
  �ģ���³
----------------------------------------------------------*/
require_once( SYS_PATH."common/db_connect.php" );


/*----------------------------------------------------------
  �������������å�
----------------------------------------------------------*/
require_once("../login_chk.php");


/*---------------------------------------------------------
	������ʬ
---------------------------------------------------------*/

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


// �оݳ�ǯ
$tc_age = 0;
if(count($_POST['tc_age'])!=0){
	foreach($_POST['tc_age'] as $key => $val){
		$tc_age += $val;
	}
}

SWITCH( $_POST["mode"] ){
	case "NEW":
		// ����1
                if( filesize($_FILES["tc_img"]["tmp_name"]) > (1024*1024*2) ){
			$arrOther['ath_comment'] .= $athComment;
                        $obj_error->ViewErrMessage( "FILE_SIZE" , "ALL" , "teacher_mnt.php" , $arrOther );
                        exit;
                }
		IF( is_uploaded_file( $_FILES["tc_img"]["tmp_name"] ) ){
			$imageInfo = @getimagesize( $_FILES["tc_img"]["tmp_name"] );
			IF( @getimagesize( $_FILES["tc_img"]["tmp_name"] ) === FALSE || ( $imageInfo[2] != 1 && $imageInfo[2] != 2 ) ){
				$arrOther['ath_comment'] .= $athComment;
                        	$obj_error->ViewErrMessage( "NOT_IMG" , "ALL" , "teacher_mnt.php" , $arrOther );
                        	exit;
			}
		$kaku1 = split("\.",$_FILES["tc_img"]["name"]);
		$tc_imgorg = $kaku1[0].".".$kaku1[1];
		$tc_img = "teacher_".$_SESSION["_cl_id"]."_/_1.".$kaku1[1];
		}


		$obj_new = new basedb_TeacherClassTblAccess;
		$obj_new->conn = $obj_conn->conn;
		$obj_new->teacherdat[0]["tc_cpid"] = $_SESSION['_cl_id'];
		$obj_new->teacherdat[0]["tc_stat"] = $_POST["tc_stat"];
		$obj_new->teacherdat[0]["tc_name"] = $_POST["tc_name"];
		IF( is_uploaded_file($_FILES["tc_img"]["tmp_name"]) ){
			$obj_new->teacherdat[0]["tc_imgorg"] = $tc_imgorg;
			$obj_new->teacherdat[0]["tc_img"] = $tc_img;
		}
		$obj_new->teacherdat[0]["tc_contents"] = $_POST["tc_contents"];
		$obj_new->teacherdat[0]["tc_comment"] = $_POST['tc_comment'];
		$obj_new->teacherdat[0]["tc_subject"] = $_POST['tc_subject'];
		$obj_new->teacherdat[0]["tc_age"] = $tc_age;
		$obj_new->teacherdat[0]["tc_adminid"] = NULL;
		$obj_new->teacherdat[0]["tc_upddate"] = $_POST["tc_upddate"];
		$suc = $obj_new->basedb_InsTeacher();
		IF( $suc == "0" ){


			// ������¸���������
			IF( is_uploaded_file( $_FILES["tc_img"]["tmp_name"] ) ){
				// ���ٲ�������==>���٥��ԡ�
				IF( file_exists( $param_tc_img_path.$_POST['tc_img_lastupd'] ) && $_POST['tc_img_lastupd'] != "" ){
					unlink( $param_tc_img_path.$_POST['tc_img_lastupd'] );
				}
				// Ʊ��̾���ǡ�UPLOAD���줿�ǡ����򥳥ԡ�
				IF( is_uploaded_file($_FILES["tc_img"]["tmp_name"]) && $obj_new->teacherdat[0]["tc_img"] != "" ){
					move_uploaded_file( $_FILES["tc_img"]["tmp_name"] , $param_tc_img_path.$obj_new->teacherdat[0]["tc_img"] );
					chmod( $param_tc_img_path.$obj_new->teacherdat[0]["tc_img"] , 0755 );
				}

				$obj_tc_1_new = new ImageControl;
				$obj_tc_1_new->max_w = 300;
				$obj_tc_1_new->max_h = 300;
				$obj_tc_1_new->origin_dir = $param_tc_img_path;
				$obj_tc_1_new->origin_img = $obj_new->teacherdat[0]["tc_img"];
				$obj_tc_1_new->gd_ver = 1;
				list($resize_tc_1_new,$imageType) = $obj_tc_1_new->ImageResizeSave();
				if($resize_tc_1_new == -1){
	                        	$obj_error->ViewErrMessage( "SYSTEM" , "ALL" , "blog_mnt.php" , $arrOther  );
	                       		exit;
				}

				$obj_other_1_save_new = new ImageControl;
				$obj_other_1_save_new->origin_dir = $param_tc_img_path;
				$obj_other_1_save_new->origin_img = $obj_new->teacherdat[0]["tc_img"];
				$obj_other_1_save_new->imageResource = $resize_tc_1_new;
				$tc_1_suc_new = $obj_other_1_save_new->ImageSave($imageType);
				if($tc_1_suc_new == -1){
	                        	$obj_error->ViewErrMessage( "SYSTEM" , "ALL" , "blog_mnt.php" , $arrOther  );
	                       		exit;
				}
			}
			
		}
		if( $suc == -1 ){
                        $arrOther["ath_comment"] = "<INPUT TYPE=\"hidden\" NAME=\"stpos\" VALUE=\"{$_POST['stpos']}\">";
			$arrOther['ath_comment'] .= $athComment;
                        $obj_error->ViewErrMessage( "INS_ERROR" , "ALL" , "teacher_mnt.php" , $arrOther );
                        exit;
		}
		$message = "�����������Ͽ���ޤ�����";
		break;

	case "EDIT":
		// ����1
                if( filesize($_FILES["tc_img"]["tmp_name"]) > (1024*1024*2) ){
			$arrOther['ath_comment'] .= $athComment;
                        $obj_error->ViewErrMessage( "FILE_SIZE" , "ALL" , "teacher_mnt.php" , $arrOther );
                        exit;
                }
		IF( is_uploaded_file( $_FILES["tc_img"]["tmp_name"] ) ){
			$imageInfo = @getimagesize( $_FILES["tc_img"]["tmp_name"] );
			IF( @getimagesize( $_FILES["tc_img"]["tmp_name"] ) === FALSE || ( $imageInfo[2] != 1 && $imageInfo[2] != 2 ) ){
				$arrOther['ath_comment'] .= $athComment;
                        	$obj_error->ViewErrMessage( "NOT_IMG" , "ALL" , "teacher_mnt.php" , $arrOther );
                        	exit;
			}
			$kaku1 = split("\.",$_FILES["tc_img"]["name"]);
			$tc_imgorg = $kaku1[0].".".$kaku1[1];
			$tc_img = "teacher_".$_SESSION["_cl_id"]."_".$_POST['tc_id']."_1.".$kaku1[1];
		}

		$obj_rev = new basedb_TeacherClassTblAccess;
		$obj_rev->conn = $obj_conn->conn;

		$obj_rev->teacherdat[0]["tc_id"] = $_POST["tc_id"];
		$obj_rev->teacherdat[0]["tc_cpid"] = $_SESSION['_cl_id'];
		$obj_rev->teacherdat[0]["tc_stat"] = $_POST["tc_stat"];
		$obj_rev->teacherdat[0]["tc_name"] = $_POST["tc_name"];
		$obj_rev->teacherdat[0]["tc_img_del_chk"] = $_POST["tc_img_del_chk"];
		IF( is_uploaded_file($_FILES["tc_img"]["tmp_name"]) ){
			$obj_rev->teacherdat[0]["tc_imgorg"] = $tc_imgorg;
			$obj_rev->teacherdat[0]["tc_img"] = $tc_img;
		}
		$obj_rev->teacherdat[0]["tc_contents"] = $_POST["tc_contents"];
		$obj_rev->teacherdat[0]["tc_comment"] = $_POST['tc_comment'];
		$obj_rev->teacherdat[0]["tc_subject"] = $_POST['tc_subject'];
		$obj_rev->teacherdat[0]["tc_age"] = $tc_age;
		$obj_rev->teacherdat[0]["tc_adminid"] = NULL;
		$obj_rev->teacherdat[0]["tc_upddate"] = $_POST["tc_upddate"];
		$suc = $obj_rev->basedb_UpdTeacher();
		IF( $suc == "0" ){
			IF($_POST['tc_img_del_chk']==1){
				IF( file_exists( $param_tc_img_path.$_POST['tc_img_lastupd'] ) && $_POST['tc_img_lastupd'] != "" ){
					unlink( $param_tc_img_path.$_POST['tc_img_lastupd'] );
				}
			}
			// ������¸���������
			IF( is_uploaded_file( $_FILES["tc_img"]["tmp_name"] ) ){
				// ���ٲ�������==>���٥��ԡ�
				IF( file_exists( $param_tc_img_path.$_POST['tc_img_lastupd'] ) && $_POST['tc_img_lastupd'] != "" ){
					unlink( $param_tc_img_path.$_POST['tc_img_lastupd'] );
				}
				// Ʊ��̾���ǡ�UPLOAD���줿�ǡ����򥳥ԡ�
				IF( is_uploaded_file($_FILES["tc_img"]["tmp_name"]) && $obj_rev->teacherdat[0]["tc_img"] != "" ){
					move_uploaded_file( $_FILES["tc_img"]["tmp_name"] , $param_tc_img_path.$tc_img );
					chmod( $param_tc_img_path.$tc_img , 0755 );
				}

				$obj_tc_1_rev = new ImageControl;
				$obj_tc_1_rev->max_w = 300;
				$obj_tc_1_rev->max_h = 300;
				$obj_tc_1_rev->origin_dir = $param_tc_img_path;
				$obj_tc_1_rev->origin_img = $tc_img;
				$obj_tc_1_rev->gd_ver = 1;
				list($resize_tc_1_rev,$imageType) = $obj_tc_1_rev->ImageResizeSave();
				if($resize_tc_1_rev == -1){
	                        	$obj_error->ViewErrMessage( "SYSTEM" , "ALL" , "blog_mnt.php" , $arrOther  );
	                       		exit;
				}

				$obj_tc_1_save_rev = new ImageControl;
				$obj_tc_1_save_rev->origin_dir = $param_tc_img_path;
				$obj_tc_1_save_rev->origin_img = $tc_img;
				$obj_tc_1_save_rev->imageResource = $resize_tc_1_rev;
				$tc_1_suc_rev = $obj_tc_1_save_rev->ImageSave($imageType);
				if($tc_1_suc_rev == -1){
	                        	$obj_error->ViewErrMessage( "SYSTEM" , "ALL" , "blog_mnt.php" , $arrOther  );
	                       		exit;
				}
			}
			
		}
		switch( $suc ){
			case "-1":
				$arrOther['ath_comment'] .= $athComment;
                        	$arrOther["ath_comment"] = "<INPUT TYPE=\"hidden\" NAME=\"stpos\" VALUE=\"{$_POST['stpos']}\">";
                        	$obj_error->ViewErrMessage( "UPD_ERROR" , "ALL" , "teacher_mnt.php" , $arrOther );
                        	exit;
			case "1":
                        	$arrOther["ath_comment"] = "<INPUT TYPE=\"hidden\" NAME=\"stpos\" VALUE=\"{$_POST['stpos']}\">";
                        	$obj_error->ViewErrMessage( "DOUBLE_UPD" , "ALL" , "teacher_main.php" , $arrOther );
                        	exit;
		}
		$message = "��������������ޤ�����";
		break;

	case 'DEL':
		$obj_del = new basedb_TeacherClassTblAccess;
		$obj_del->conn = $obj_conn->conn;
		$obj_del->teacherdat[0]["tc_id"] = $_POST["tc_id"];
		$obj_del->teacherdat[0]["tc_upddate"] = $_POST["tc_upddate"];
		$suc = $obj_del->basedb_DelTeacher(0);
		if( $suc == -1 ){
                        $arrOther["ath_comment"] = "<INPUT TYPE=\"hidden\" NAME=\"stpos\" VALUE=\"{$_POST['stpos']}\">";
                        $obj_error->ViewErrMessage( "DEL_ERROR" , "ALL" , "teacher_main.php" , $arrOther );
                        exit;
		}
		IF( $suc == "0" ){
			// ��������
			IF( file_exists( $param_tc_img_path.$_POST['tc_img_lastupd'] ) && $_POST['tc_img_lastupd'] != ""){
				unlink( $param_tc_img_path.$_POST['tc_img_lastupd'] );
			}
		}
		$message = "���ꤵ�줿��������������ޤ�����";
		break;

}


/*----------------------------------------------------------
  �ģ�����
----------------------------------------------------------*/
require_once( SYS_PATH."common/db_close.php" );


/*----------------------------------------------------------
  �ȣԣͣ�����
----------------------------------------------------------*/
?>
<HTML>
  <HEAD>
    <TITLE>�Υ֥� - ���饤����ȴ����ġ���</title>
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
      <form name="form1" action="teacher_main.php" method="POST"> 
        <INPUT type="hidden" name="stpos" value="<?=$_POST['stpos']?>" />
        <input type="submit" value=" �� �� " class="btn" />
      </form>
    </div>
  </body>
</html>
