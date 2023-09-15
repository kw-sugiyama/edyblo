<?

/******************************************************************************
<< ��ư���֥���Ver.1.O.0 >>
	Name: blog_upd.php
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
require_once ( SYS_PATH."dbif/dbcom_DBconnectClass.php" );
require_once ( SYS_PATH."dbif/basedb_SchoolClass.php" );
require_once ( SYS_PATH."dbif/basedb_EnsenClass.php" );
require_once ( SYS_PATH."dbif/basedb_ClientClass.php" );
require_once ( SYS_PATH."dbif/basedb_AreaClass.php" );
require_once ( SYS_PATH."common/base_common.php" );
require_once ( SYS_PATH."common/sys_common.php" );
require_once ( SYS_PATH."common/error.class.php" );
require_once ( SYS_PATH."common/ImageControl.class.php" );
require_once ( SYS_PATH."configs/param_file.conf" );

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


// �Ķȳ��ϡ���λ����
$_POST["sc_start"] = $_POST["sc_start_h"].":".$_POST["sc_start_m"];
$_POST["sc_end"] = $_POST["sc_end_h"].":".$_POST["sc_end_m"];

$_POST["sc_keywd"] = str_replace( "," , "-" ,  $_POST["sc_keywd"] );

// �оݳ�ǯ
$sc_age = 0;
if(count($_POST['sc_age'])!=0){
	foreach($_POST['sc_age'] as $key => $val){
		$sc_age += $val;
	}
}

// ���ȷ���
$sc_classform = 0;
if(count($_POST['sc_classform'])!=0){
	foreach($_POST['sc_classform'] as $key => $val){
		$sc_classform += $val;
	}
}


/*---------------------------------------------------------
	�ե꡼����Ѿ�������
---------------------------------------------------------*/
$cl_yobi1 = '';

// ���饤����Ⱦ�������
$obj_Client = new basedb_ClientClassTblAccess;
$obj_Client->conn = $obj_conn->conn;
$obj_Client->jyoken["cl_id"] = $_POST["sc_clid"];	// ���饤�����ID
$obj_Client->jyoken["cl_deldate"] = "1";

list( $intCnt , $intTotal ) = $obj_Client->basedb_GetClient( 0 , -1 );
if( $intCnt == -1 ){
	$arrOther["ath_comment"] = "";
	$arrOther["ath_comment"] .= "<INPUT TYPE=\"hidden\" NAME=\"stpos\" VALUE=\"{$_POST['stpos']}\">";
	$arrOther["ath_comment"] .= $athComment;
        $obj_error->ViewErrMessage( "SYSTEM" , "ALL" , "blog_mnt.php" , $arrOther );
        exit;
}

// ���ꥢ��������
$obj_area = new basedb_AreaClassTblAccess;
$obj_area->conn = $obj_conn->conn;
$obj_area->jyoken["ar_clid"]	= $_POST["sc_clid"];	// ���饤�����ID
$obj_area->sort['ar_flg']	= 2;			// �оݥ��ꥢ��
list( $intCnt , $intTotal ) = $obj_area->basedb_GetArea( 0 , -1 );
if( $intCnt == -1 ){
	$arrOther["ath_comment"] = "";
	$arrOther["ath_comment"] .= "<INPUT TYPE=\"hidden\" NAME=\"stpos\" VALUE=\"{$_POST['stpos']}\">";
	$arrOther["ath_comment"] .= $athComment;
        $obj_error->ViewErrMessage( "SYSTEM" , "ALL" , "blog_mnt.php" , $arrOther );
        exit;
}


// ��̾
$str = $obj_Client->clientdat[0]["cl_jname"];
if($str!="")$cl_yobi1 .= $str . '/';

// ����̾
$str = $obj_Client->clientdat[0]["cl_kname"];
if($str!="")$cl_yobi1 .= $str . '/';

// ��̾+����̾
$str = $obj_Client->clientdat[0]["cl_jname"] . $obj_Client->clientdat[0]["cl_kname"];
if($str!="")$cl_yobi1 .= $str . '/';

// ���ꥢ���� $obj_area->areadat�˶������ꡢ���ꥢ1��3��4�쥳�����֤äƤ���
FOREACH($obj_area->areadat as $key => $val ){

	// ͹���ֹ� ���쥳���ɤ˥ϥ��ե����äƤ�Τǲ���
	$str = $val["ar_zip"];
	if($str!="" and $str!="-")$cl_yobi1 .= $str . '/';
	// ��ƻ�ܸ�̾
	$str = $val["ar_pref"];
	if($str!="")$cl_yobi1 .= $str . '/';
	// �Զ�Į¼̾
	$str = $val["ar_city"];
	if($str!="")$cl_yobi1 .= $str . '/';
	
	// $key=0(�ǽ�Υ쥳����)=�Τν��� �ξ��Τ� ���� ��ʪ̾
	if ($key == 0) {
		// ����
		$str = $val["ar_add"];
		if($str!="")$cl_yobi1 .= $str . '/';
		// ��ʪ̾
		$str = $val["ar_estate"];
		if($str!="")$cl_yobi1 .= $str . '/';
		// ��ƻ�ܸ�̾+�Զ�Į¼̾+����+��ʪ̾
		$buff_add_str = '';
		$buff_add_str = $val["ar_pref"] . $val["ar_city"] . $val["ar_add"] . $val["ar_estate"];
	} else {
		// ��ƻ�ܸ�̾+�Զ�Į¼̾
		$buff_add_str = '';
		$buff_add_str = $val["ar_pref"] . $val["ar_city"];
	}
	if($buff_add_str!="") $cl_yobi1 .= $buff_add_str . '/';
}

// �֥��Ҳ�ʸ
$str = $_POST["sc_introduce"];
if($str!="")$cl_yobi1 .= $str . '/';

// ���Ĳ��
$str = $_POST["sc_company"];
if($str!="")$cl_yobi1 .= $str . '/';

// TOP������ɥ������ȥ�
$str = $_POST["sc_topwindowtitle"];
if($str!="")$cl_yobi1 .= $str . '/';

// �إå����ѥ����ȥ�
$str = $_POST["sc_headertitle"];
if($str!="")$cl_yobi1 .= $str . '/';

// TOP�������󥿥��ȥ�
$str = $_POST["sc_toptitle"];
if($str!="")$cl_yobi1 .= $str . '/';

// TOP�������󥵥֥����ȥ�
$str = $_POST["sc_topsubtitle"];
if($str!="")$cl_yobi1 .= $str . '/';

// TOP�����ڡ��󥤥٥��
$str = $_POST["sc_campaintitle"];
if($str!="")$cl_yobi1 .= $str . '/';

// TOP���������󥿥��ȥ�
$str = $_POST["sc_coursetitle"];
if($str!="")$cl_yobi1 .= $str . '/';

// TOP�������󥿥��ȥ�
$str = $_POST["sc_diarytitle"];
if($str!="")$cl_yobi1 .= $str . '/';

// ��������ʸ
$str = $_POST["sc_addmission"];
if($str!="")$cl_yobi1 .= $str . '/';

// �оݳ�ǯ
if ( is_array($_POST["sc_age"]) ) {
	FOREACH($_POST["sc_age"] as $key => $val) {
		switch( $key  ){
			case 0: $cl_yobi1 .= '�Ļ�'   . '/'; break;
			case 1: $cl_yobi1 .= '������' . '/'; break;
			case 2: $cl_yobi1 .= '�����' . '/'; break;
			case 3: $cl_yobi1 .= '�⹻��' . '/'; break;
			case 4: $cl_yobi1 .= 'ϲ����' . '/'; break;
			case 5: $cl_yobi1 .= '�����' . '/'; break;
			case 6: $cl_yobi1 .= '�Ҳ��' . '/'; break;
		}
	}
}

// ���ȷ���
if ( is_array($_POST["sc_classform"]) ) {
	FOREACH($_POST["sc_classform"] as $key => $val) {
		switch( $key  ){
			case 0: $cl_yobi1 .= '����'   . '/'; break;
			case 1: $cl_yobi1 .= '���Ϳ�' . '/'; break;
			case 2: $cl_yobi1 .= '����'   . '/'; break;
		}
	}
}

// �Ǵ����̾
$str = $_POST["es_line1"];
if($str!="")$cl_yobi1 .= $str . '/';

// �Ǵ��̾
$str = $_POST["es_sta1"];
if($str!="")$cl_yobi1 .= $str . '��' . '/';

// ����
$str = $_POST["es_walk1"];
if($str!="")$cl_yobi1 .= '����' . $str . 'ʬ' . '/';

// �Х�
$str = $_POST["es_bus1"];
if($str!="")$cl_yobi1 .= '�Х�' . $str . 'ʬ' . '/';

// ����PRʸ
$str = $_POST["sc_pr"];
if($str!="")$cl_yobi1 .= $str . '/';

// �Ǹ��Ƭ�˥���å����Ĥ��� (������ʤ����)
if ($cl_yobi1 != "") $cl_yobi1 = '/' . $cl_yobi1;

// �ե꡼����Ѿ�������--END


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
$athComment .= '<INPUT type="hidden" name="es_line[1]" value="'.stripslashes(htmlspecialchars($_POST['es_line1'])).'">'."\n";
$athComment .= '<INPUT type="hidden" name="es_sta[1]" value="'.stripslashes(htmlspecialchars($_POST['es_sta1'])).'">'."\n";
$athComment .= '<INPUT type="hidden" name="es_bus[1]" value="'.stripslashes(htmlspecialchars($_POST['es_bus1'])).'">'."\n";
$athComment .= '<INPUT type="hidden" name="es_walk[1]" value="'.stripslashes(htmlspecialchars($_POST['es_walk1'])).'">'."\n";
$athComment .= '<INPUT type="hidden" name="es_biko[1]" value="'.stripslashes(htmlspecialchars($_POST['es_biko1'])).'">'."\n";
$athComment .= '<INPUT type="hidden" name="es_linecd[1]" value="'.stripslashes(htmlspecialchars($_POST['es_linecd1'])).'">'."\n";
$athComment .= '<INPUT type="hidden" name="es_linecdname[1]" value="'.stripslashes(htmlspecialchars($_POST['es_linecdname1'])).'">'."\n";
$athComment .= '<INPUT type="hidden" name="es_stacd[1]" value="'.stripslashes(htmlspecialchars($_POST['es_stacd1'])).'">'."\n";


SWITCH( $_POST["mode"] ){
	case "EDIT":
//====================================================================================================================
		 if( filesize($_FILES["sc_logo"]["tmp_name"]) > (1024*1024*2) ){
			$arrOther["ath_comment"] = "";
			$arrOther["ath_comment"] .= "<INPUT TYPE=\"hidden\" NAME=\"stpos\" VALUE=\"{$_POST['stpos']}\">";
                       	$arrOther["ath_comment"] .= $athComment;
                        $obj_error->ViewErrMessage( "FILE_SIZE" , "ALL" , "blog_mnt.php" , $arrOther  );
                        exit;
					 }
//���ӥ��б�====================================================================================================================
		 if( filesize($_FILES["sc_logo_mobile"]["tmp_name"]) > (1024*1024*2) ){
			$arrOther["ath_comment"] = "";
			$arrOther["ath_comment"] .= "<INPUT TYPE=\"hidden\" NAME=\"stpos\" VALUE=\"{$_POST['stpos']}\">";
                       	$arrOther["ath_comment"] .= $athComment;
                        $obj_error->ViewErrMessage( "FILE_SIZE" , "ALL" , "blog_mnt.php" , $arrOther  );
                        exit;
		 }
//====================================================================================================================


                if( filesize($_FILES["sc_topimg"]["tmp_name"]) > (1024*1024*2) ){
			$arrOther["ath_comment"] = "";
			$arrOther["ath_comment"] .= "<INPUT TYPE=\"hidden\" NAME=\"stpos\" VALUE=\"{$_POST['stpos']}\">";
                       	$arrOther["ath_comment"] .= $athComment;
                        $obj_error->ViewErrMessage( "FILE_SIZE" , "ALL" , "blog_mnt.php" , $arrOther  );
                        exit;
                }
                if( filesize($_FILES["sc_mapimg"]["tmp_name"]) > (1024*1024*2) ){
			$arrOther["ath_comment"] = "";
			$arrOther["ath_comment"] .= "<INPUT TYPE=\"hidden\" NAME=\"stpos\" VALUE=\"{$_POST['stpos']}\">";
                       	$arrOther["ath_comment"] .= $athComment;
                        $obj_error->ViewErrMessage( "FILE_SIZE" , "ALL" , "blog_mnt.php" , $arrOther  );
                        exit;
					 }
//====================================================================================================================
		IF( is_uploaded_file( $_FILES["sc_logo"]["tmp_name"] ) ){
			$imageInfo = @getimagesize( $_FILES["sc_logo"]["tmp_name"] );
			IF( @getimagesize( $_FILES["sc_logo"]["tmp_name"] ) === FALSE || ( $imageInfo[2] != 1 &&  $imageInfo[2] != 2 ) ){
				$arrOther["ath_comment"] = "";
				$arrOther["ath_comment"] .= "<INPUT TYPE=\"hidden\" NAME=\"stpos\" VALUE=\"{$_POST['stpos']}\">";
        	               	$arrOther["ath_comment"] .= $athComment;
                        	$obj_error->ViewErrMessage( "NOT_IMG" , "ALL" , "blog_mnt.php" , $arrOther  );
                        	exit;
			}
			$kakuLogo = split("\.",$_FILES["sc_logo"]["name"]);
			$logo_name_org = $kakuLogo[0].".".$kakuLogo[1];
			$logo_name = "cl_logo_".$_POST["sc_clid"].".".$kakuLogo[1];
		}
//���ӥ��б�====================================================================================================================
		 IF( is_uploaded_file( $_FILES["sc_logo_mobile"]["tmp_name"] ) ){
			$imageInfo = @getimagesize( $_FILES["sc_logo_mobile"]["tmp_name"] );
			IF( @getimagesize( $_FILES["sc_logo_mobile"]["tmp_name"] ) === FALSE || ( $imageInfo[2] != 1 &&  $imageInfo[2] != 2 ) ){
				$arrOther["ath_comment"] = "";
				$arrOther["ath_comment"] .= "<INPUT TYPE=\"hidden\" NAME=\"stpos\" VALUE=\"{$_POST['stpos']}\">";
        	               	$arrOther["ath_comment"] .= $athComment;
                        	$obj_error->ViewErrMessage( "NOT_IMG" , "ALL" , "blog_mnt.php" , $arrOther  );
                        	exit;
			}
			$kakuLogo = split("\.",$_FILES["sc_logo_mobile"]["name"]);
			$logo_name_org_m = $kakuLogo[0].".".$kakuLogo[1];
			$logo_name_m = "cl_logo_".$_POST["sc_clid"].".".$kakuLogo[1];
		}
//====================================================================================================================
		IF( is_uploaded_file( $_FILES["sc_topimg"]["tmp_name"] ) ){
			$imageInfo = @getimagesize( $_FILES["sc_topimg"]["tmp_name"] );
			IF( @getimagesize( $_FILES["sc_topimg"]["tmp_name"] ) === FALSE || ( $imageInfo[2] != 1 &&  $imageInfo[2] != 2 ) ){
				$arrOther["ath_comment"] = "";
				$arrOther["ath_comment"] .= "<INPUT TYPE=\"hidden\" NAME=\"stpos\" VALUE=\"{$_POST['stpos']}\">";
        	               	$arrOther["ath_comment"] .= $athComment;
                        	$obj_error->ViewErrMessage( "NOT_IMG" , "ALL" , "blog_mnt.php" , $arrOther  );
                        	exit;
			}
			$kakuPhoto = split("\.",$_FILES["sc_topimg"]["name"]);
			$photo_name_org = $kakuPhoto[0].".".$kakuPhoto[1];
			$photo_name = "cl_photo_".$_POST["sc_clid"].".".$kakuPhoto[1];
		}
		IF( is_uploaded_file( $_FILES["sc_mapimg"]["tmp_name"] ) ){
			$imageInfo = @getimagesize( $_FILES["sc_mapimg"]["tmp_name"] );
			IF( @getimagesize( $_FILES["sc_mapimg"]["tmp_name"] ) === FALSE || ( $imageInfo[2] != 1 &&  $imageInfo[2] != 2 ) ){
				$arrOther["ath_comment"] = "";
				$arrOther["ath_comment"] .= "<INPUT TYPE=\"hidden\" NAME=\"stpos\" VALUE=\"{$_POST['stpos']}\">";
        	               	$arrOther["ath_comment"] .= $athComment;
                        	$obj_error->ViewErrMessage( "NOT_IMG" , "ALL" , "blog_mnt.php" , $arrOther  );
                        	exit;
			}
			$kakuStaff = split("\.",$_FILES["sc_mapimg"]["name"]);
			$staff_name_org = $kakuStaff[0].".".$kakuStaff[1];
			$staff_name = "cl_staff_".$_POST["sc_clid"].".".$kakuStaff[1];
		}

		$obj_rev = new basedb_SchoolClassTblAccess;
		$obj_rev->conn = $obj_conn->conn;
		$obj_rev->blogdat[0]["sc_id"] = $_POST["sc_id"];
		$obj_rev->blogdat[0]["sc_clid"] = $_POST["sc_clid"];
		$obj_rev->blogdat[0]["sc_stat"] = 1;
		$obj_rev->blogdat[0]["sc_title"] = $_POST["sc_title"];
		$obj_rev->blogdat[0]["sc_keywd"] = $_POST["sc_keywd"];
		$obj_rev->blogdat[0]["sc_introduce"] = $_POST["sc_introduce"];
		$obj_rev->blogdat[0]["sc_classform"] = $sc_classform;
		$obj_rev->blogdat[0]["sc_clr"] = $_POST["sc_clr"];
		$obj_rev->blogdat[0]["sc_upd"] = $_POST["sc_upd"];
		$obj_rev->blogdat[0]["sc_master"] = $_POST["sc_master"];
		$obj_rev->blogdat[0]["sc_age"] = $sc_age;
		$obj_rev->blogdat[0]["sc_position"] = $_POST["sc_position"];
		$obj_rev->blogdat[0]["es_line"] = $_POST["es_line"];
		$obj_rev->blogdat[0]["es_linecd"] = $_POST["es_linecd"];
		$obj_rev->blogdat[0]["es_sta"] = $_POST['es_sta'];
		$obj_rev->blogdat[0]["es_stacd"] = $_POST["es_stacd"];

		$obj_rev->blogdat[0]["es_line2"] = $_POST["es_line2"];
		$obj_rev->blogdat[0]["es_linecd2"] = $_POST["es_linecd2"];
		$obj_rev->blogdat[0]["es_sta2"] = $_POST['es_sta2'];
		$obj_rev->blogdat[0]["es_stacd2"] = $_POST["es_stacd2"];

		$obj_rev->blogdat[0]["es_line3"] = $_POST["es_line3"];
		$obj_rev->blogdat[0]["es_linecd3"] = $_POST["es_linecd3"];
		$obj_rev->blogdat[0]["es_sta3"] = $_POST['es_sta3'];
		$obj_rev->blogdat[0]["es_stacd3"] = $_POST["es_stacd3"];

		$obj_rev->blogdat[0]["es_line4"] = $_POST["es_line4"];
		$obj_rev->blogdat[0]["es_linecd4"] = $_POST["es_linecd4"];
		$obj_rev->blogdat[0]["es_sta4"] = $_POST['es_sta4'];
		$obj_rev->blogdat[0]["es_stacd4"] = $_POST["es_stacd4"];

		$obj_rev->blogdat[0]["es_line5"] = $_POST["es_line5"];
		$obj_rev->blogdat[0]["es_linecd5"] = $_POST["es_linecd5"];
		$obj_rev->blogdat[0]["es_sta5"] = $_POST['es_sta5'];
		$obj_rev->blogdat[0]["es_stacd5"] = $_POST["es_stacd5"];

		$obj_rev->blogdat[0]["sc_start"] = $_POST["sc_start"];
		$obj_rev->blogdat[0]["sc_end"] = $_POST["sc_end"];
		$obj_rev->blogdat[0]["sc_holiday"] = $_POST["sc_holiday"];
		$obj_rev->blogdat[0]["sc_hp"] = $_POST["sc_hp"];
		$obj_rev->blogdat[0]["sc_walk"] = $_POST["sc_walk"];
		$obj_rev->blogdat[0]["sc_bus"] = $_POST["sc_bus"];

		$obj_rev->blogdat[0]["sc_walk2"] = $_POST["sc_walk2"];
		$obj_rev->blogdat[0]["sc_bus2"] = $_POST["sc_bus2"];

		$obj_rev->blogdat[0]["sc_walk3"] = $_POST["sc_walk3"];
		$obj_rev->blogdat[0]["sc_bus3"] = $_POST["sc_bus3"];

		$obj_rev->blogdat[0]["sc_walk4"] = $_POST["sc_walk4"];
		$obj_rev->blogdat[0]["sc_bus4"] = $_POST["sc_bus4"];

		$obj_rev->blogdat[0]["sc_walk5"] = $_POST["sc_walk5"];
		$obj_rev->blogdat[0]["sc_bus5"] = $_POST["sc_bus5"];

		$obj_rev->blogdat[0]["sc_entrymail"] = $_POST["sc_entrymail"];
		$obj_rev->blogdat[0]["sc_infomail"]  = $_POST["sc_infomail"];
		$obj_rev->blogdat[0]["sc_infomail2"] = $_POST["sc_infomail2"];
		$obj_rev->blogdat[0]["sc_entrymail2"] = $_POST["sc_entrymail2"];
		
//====================================================================================================================
		IF( is_uploaded_file($_FILES["sc_logo"]["tmp_name"]) ){
			$obj_rev->blogdat[0]["sc_logoorg"] = $logo_name_org;
			$obj_rev->blogdat[0]["sc_logo"] = $logo_name;
		}
//���ӥ��б�====================================================================================================================
		IF( is_uploaded_file($_FILES["sc_logo_mobile"]["tmp_name"]) ){
			$obj_rev->blogdat[0]["sc_logo_mobile_org"] = $logo_name_org_m;
			$obj_rev->blogdat[0]["sc_logo_mobile"] = $logo_name_m;
	}
//====================================================================================================================
		$obj_rev->blogdat[0]["sc_logo_del_chk"] = $_POST["sc_logo_del_chk"];
//���ӥ��б�====================================================================================================================
		$obj_rev->blogdat[0]["sc_logo_mobile_del_chk"] = $_POST["sc_logo_mobile_del_chk"];
//====================================================================================================================
		IF( is_uploaded_file($_FILES["sc_topimg"]["tmp_name"]) ){
			$obj_rev->blogdat[0]["sc_topimgorg"] = $photo_name_org;
			$obj_rev->blogdat[0]["sc_topimg"] = $photo_name;
		}
		$obj_rev->blogdat[0]["sc_topimg_del_chk"] = $_POST["sc_topimg_del_chk"];
		IF( is_uploaded_file($_FILES["sc_mapimg"]["tmp_name"]) ){
			$obj_rev->blogdat[0]["sc_mapimgorg"] = $staff_name_org;
			$obj_rev->blogdat[0]["sc_mapimg"] = $staff_name;
		}
		$obj_rev->blogdat[0]["sc_mapimg_del_chk"] = $_POST["sc_mapimg_del_chk"];
		$obj_rev->blogdat[0]["blog_cl_pr"] = $_POST["blog_cl_pr"];
		$obj_rev->blogdat[0]["sc_rhtml"] = $_POST["sc_rhtml"];
		$obj_rev->blogdat[0]["sc_lhtml"] = $_POST["sc_lhtml"];
//TOP HTML hatori====================================================================================================================

		$obj_rev->blogdat[0]["sc_thtml"] = $_POST["sc_thtml"];

//====================================================================================================================
		$obj_rev->blogdat[0]["sc_ido"] = $_POST["sc_ido"];
		$obj_rev->blogdat[0]["sc_keido"] = $_POST["sc_keido"];
		$obj_rev->blogdat[0]["sc_zoom"] = $_POST["sc_zoom"];

		$obj_rev->blogdat[0]["sc_movie"] = $_POST["sc_movie"];
		$obj_rev->blogdat[0]["sc_privacy"] = $_POST["sc_privacy"];
		$obj_rev->blogdat[0]["sc_results"] = $_POST["sc_results"];
		$obj_rev->blogdat[0]["sc_students"] = $_POST["sc_students"];
		$obj_rev->blogdat[0]["sc_pr"] = $_POST["sc_pr"];
		$obj_rev->blogdat[0]["es_biko1"] = $_POST["es_biko1"];
		$obj_rev->blogdat[0]["es_biko2"] = $_POST["es_biko2"];
		$obj_rev->blogdat[0]["es_biko3"] = $_POST["es_biko3"];
		$obj_rev->blogdat[0]["es_biko4"] = $_POST["es_biko4"];
		$obj_rev->blogdat[0]["es_biko5"] = $_POST["es_biko5"];

		$obj_rev->blogdat[0]["sc_headertitle"] = $_POST["sc_headertitle"];
		$obj_rev->blogdat[0]["sc_toptitle"] = $_POST["sc_toptitle"];
		$obj_rev->blogdat[0]["sc_topsubtitle"] = $_POST["sc_topsubtitle"];
		$obj_rev->blogdat[0]["sc_campaintitle"] = $_POST["sc_campaintitle"];
		$obj_rev->blogdat[0]["sc_coursetitle"] = $_POST["sc_coursetitle"];
		$obj_rev->blogdat[0]["sc_diarytitle"] = $_POST["sc_diarytitle"];
		$obj_rev->blogdat[0]["sc_topwindowtitle"] = $_POST["sc_topwindowtitle"];
		$obj_rev->blogdat[0]["sc_company"] = $_POST["sc_company"];
		$obj_rev->blogdat[0]["sc_addmission"] = $_POST["sc_addmission"];

		$obj_rev->blogdat[0]["sc_adminid"] = NULL;
		$obj_rev->blogdat[0]["sc_upddate"] = $_POST["sc_upddate"];
		$suc = $obj_rev->basedb_UpdSchool();

		IF( $suc == "0" ){

//===============================================================================================================================
			IF($_POST['sc_logo_del_chk']==1){
		 		IF( file_exists( $param_cl_logo_path.$_POST['sc_logo_lastupd'] ) && $_POST['sc_logo_lastupd'] != "" && $_POST["sc_logo_lastupd"] != "" ){
                                        unlink( $param_cl_logo_path.$_POST['sc_logo_lastupd'] );
                                }
			}

//���ӥ��б�====================================================================================================================

			IF($_POST['sc_logo_mobile_del_chk']==1){
		 		IF( file_exists( $param_cl_logo_mobile_path.$_POST['sc_logo_mobile_lastupd'] ) && $_POST['sc_logo_mobile_lastupd'] != "" && $_POST["sc_logo_mobile_lastupd"] != "" ){
                                        unlink( $param_cl_logo_mobile_path.$_POST['sc_logo_mobile_lastupd'] );
                                }
			}
	 
//================================================================================================================================

			IF($_POST['sc_topimg_del_chk']==1){
				IF( file_exists( $param_cl_photo_path.$_POST['sc_topimg_lastupd'] ) && $_POST['sc_topimg_lastupd'] != "" && $_POST['sc_topimg_lastupd'] != "" ){
                                        unlink( $param_cl_photo_path.$_POST['sc_topimg_lastupd'] );
                                }
			}
                        IF($_POST['sc_mapimg_del_chk']==1){
				IF( file_exists( $param_cl_staff_path.$_POST['sc_mapimg_lastupd'] ) && $_POST['sc_mapimg_lastupd'] != "" && $_POST['sc_mapimg_lastupd'] != "" ){
                                        unlink( $param_cl_staff_path.$_POST['sc_mapimg_lastupd'] );
                                }
			}
//====================================================================================================================
			// ������¸���������
			IF( is_uploaded_file( $_FILES["sc_logo"]["tmp_name"] ) ){
				// ���ٲ�������==>���٥��ԡ�
				IF( file_exists( $param_cl_logo_path.$_POST['sc_logo_lastupd'] ) && $_POST['sc_logo_lastupd'] != "" && $_POST["sc_logo_lastupd"] != "" ){
					unlink( $param_cl_logo_path.$_POST['sc_logo_lastupd'] );
				}
				// Ʊ��̾���ǡ�UPLOAD���줿�ǡ����򥳥ԡ�
				IF( is_uploaded_file($_FILES["sc_logo"]["tmp_name"]) && $obj_rev->blogdat[0]["sc_logo"] != "" ){
					move_uploaded_file( $_FILES["sc_logo"]["tmp_name"] , $param_cl_logo_path.$logo_name );
					chmod( $param_cl_logo_path.$logo_name , 0755 );
				}
				$obj_logo = new ImageControl;
				$obj_logo->max_w = 400;
				$obj_logo->max_h = 90;
				$obj_logo->origin_dir = $param_cl_logo_path;
				$obj_logo->origin_img = $logo_name;
				$obj_logo->gd_ver = 1;
				list($resize_logo,$imageType) = $obj_logo->ImageResizeSave();
				if($resize_logo == -1){
echo("#1#");
	                        	$obj_error->ViewErrMessage( "SYSTEM" , "ALL" , "blog_mnt.php" , $arrOther  );
	                       		exit;
				}

				$obj_logo_save = new ImageControl;
				$obj_logo_save->origin_dir = $param_cl_logo_path;
				$obj_logo_save->origin_img = $logo_name;
				$obj_logo_save->imageResource = $resize_logo;
				$logo_suc = $obj_logo_save->ImageSave($imageType);
				if($logo_suc == -1){
echo("#2#");
	                        	$obj_error->ViewErrMessage( "SYSTEM" , "ALL" , "blog_mnt.php" , $arrOther  );
	                       		exit;
				}
				}
//���ӥ��б�====================================================================================================================
			// ������¸���������
			IF( is_uploaded_file( $_FILES["sc_logo_mobile"]["tmp_name"] ) ){
				// ���ٲ�������==>���٥��ԡ�
				IF( file_exists( $param_cl_logo_mobile_path.$_POST['sc_logo_mobile_lastupd'] ) && $_POST['sc_logo_mobile_lastupd'] != "" && $_POST["sc_logo_mobile_lastupd"] != "" ){
					unlink( $param_cl_logo_mobile_path.$_POST['sc_logo_mobile_lastupd'] );
				}
				// Ʊ��̾���ǡ�UPLOAD���줿�ǡ����򥳥ԡ�
				IF( is_uploaded_file($_FILES["sc_logo_mobile"]["tmp_name"]) && $obj_rev->blogdat[0]["sc_logo_mobile"] != "" ){
					 move_uploaded_file( $_FILES["sc_logo_mobile"]["tmp_name"] , $param_cl_logo_mobile_path.$logo_name_m );
					chmod( $param_cl_logo_mobile_path.$logo_name_m , 0755 );
				}


				$obj_logo = new ImageControl;
				$obj_logo->max_w = 400;
				$obj_logo->max_h = 90;
				$obj_logo->origin_dir = $param_cl_logo_mobile_path;
				$obj_logo->origin_img = $logo_name_m;
				$obj_logo->gd_ver = 1;
				list($resize_logo,$imageType) = $obj_logo->ImageResizeSave();
				if($resize_logo == -1){
echo("#1#");
	                        	$obj_error->ViewErrMessage( "SYSTEM" , "ALL" , "blog_mnt.php" , $arrOther  );
	                       		exit;
				}

				$obj_logo_save = new ImageControl;
				$obj_logo_save->origin_dir = $param_cl_logo_mobile_path;
				$obj_logo_save->origin_img = $logo_name_m;
				$obj_logo_save->imageResource = $resize_logo;
				$logo_suc = $obj_logo_save->ImageSave($imageType);
				if($logo_suc == -1){
echo("#2#");
	                        	$obj_error->ViewErrMessage( "SYSTEM" , "ALL" , "blog_mnt.php" , $arrOther  );
	                       		exit;
				}
			}
//====================================================================================================================
	
			IF( is_uploaded_file( $_FILES["sc_topimg"]["tmp_name"] ) ){
				// ���ٲ�������==>���٥��ԡ�
				IF( file_exists( $param_cl_photo_path.$_POST['sc_topimg_lastupd'] ) && $_POST['sc_topimg_lastupd'] != "" && $_POST['sc_topimg_lastupd'] != "" ){
					unlink( $param_cl_photo_path.$_POST['sc_topimg_lastupd'] );
				}
				// Ʊ��̾���ǡ�UPLOAD���줿�ǡ����򥳥ԡ�
				IF( is_uploaded_file($_FILES["sc_topimg"]["tmp_name"]) && $obj_rev->blogdat[0]["sc_topimg"] != "" ){
					move_uploaded_file( $_FILES["sc_topimg"]["tmp_name"] , $param_cl_photo_path.$photo_name );
					chmod( $param_cl_photo_path.$photo_name , 0755 );
				}
				
				$obj_photo = new ImageControl;
				$obj_photo->max_w = 300;
				$obj_photo->max_h = 300;
				$obj_photo->origin_dir = $param_cl_photo_path;
				$obj_photo->origin_img = $photo_name;
				$obj_photo->gd_ver = 1;
				list($resize_photo,$imageType) = $obj_photo->ImageResizeSave();
				if($resize_photo == -1){
echo("#3#");
		                        	$obj_error->ViewErrMessage( "SYSTEM" , "ALL" , "blog_mnt.php" , $arrOther  );
		                       		exit;
				}

				$obj_photo_save = new ImageControl;
				$obj_photo_save->origin_dir = $param_cl_photo_path;
				$obj_photo_save->origin_img = $photo_name;
				$obj_photo_save->imageResource = $resize_photo;
				$photo_suc = $obj_photo_save->ImageSave($imageType);
				if($photo_suc == -1){
echo("#4#");
		                        	$obj_error->ViewErrMessage( "SYSTEM" , "ALL" , "blog_mnt.php" , $arrOther  );
		                       		exit;
				}
			}

			IF( is_uploaded_file( $_FILES["sc_mapimg"]["tmp_name"] ) ){
				// ���ٲ�������==>���٥��ԡ�
				IF( file_exists( $param_cl_staff_path.$_POST['sc_mapimg_lastupd'] ) && $_POST['sc_mapimg_lastupd'] != "" && $_POST['sc_mapimg_lastupd'] != "" ){
					unlink( $param_cl_staff_path.$_POST['sc_mapimg_lastupd'] );
				}
				// Ʊ��̾���ǡ�UPLOAD���줿�ǡ����򥳥ԡ�
				IF( is_uploaded_file($_FILES["sc_mapimg"]["tmp_name"]) && $obj_rev->blogdat[0]["sc_mapimg"] != "" ){
					move_uploaded_file( $_FILES["sc_mapimg"]["tmp_name"] , $param_cl_staff_path.$staff_name);
					chmod( $param_cl_staff_path.$staff_name , 0755 );
				}

				$obj_staff = new ImageControl;
				$obj_staff->max_w = 300;
				$obj_staff->max_h = 300;
				$obj_staff->origin_dir = $param_cl_staff_path;
				$obj_staff->origin_img = $staff_name;
				$obj_staff->gd_ver = 1;
				list($resize_staff,$imageType) = $obj_staff->ImageResizeSave();
				if($resize_staff == -1){
echo("#5#");
	                        	$obj_error->ViewErrMessage( "SYSTEM" , "ALL" , "blog_mnt.php" , $arrOther  );
	                       		exit;
				}

				$obj_staff_save = new ImageControl;
				$obj_staff_save->origin_dir = $param_cl_staff_path;
				$obj_staff_save->origin_img = $staff_name;
				$obj_staff_save->imageResource = $resize_staff;
				$staff_suc = $obj_staff_save->ImageSave($imageType);
				if($staff_suc == -1){
echo("#6#");
	                        	$obj_error->ViewErrMessage( "SYSTEM" , "ALL" , "blog_mnt.php" , $arrOther  );
	                       		exit;
				}
			}

		}
		switch( $suc ){
			case "-1":
echo("#7#");
				$arrOther["ath_comment"] = "";
				$arrOther["ath_comment"] .= "<INPUT TYPE=\"hidden\" NAME=\"stpos\" VALUE=\"{$_POST['stpos']}\">";
        	               	$arrOther["ath_comment"] .= $athComment;
                        	$obj_error->ViewErrMessage( "SYSTEM" , "ALL" , "blog_mnt.php" , $arrOther  );
                       		exit;

			case "1":
				$arrOther["ath_comment"] = "";
				$arrOther["ath_comment"] .= "<INPUT TYPE=\"hidden\" NAME=\"stpos\" VALUE=\"{$_POST['stpos']}\">";
                        	$obj_error->ViewErrMessage( "DOUBLE_UPD" , "ALL" , "blog_main.php" , $arrOther  );
                       		exit;
		}

		if($_POST["ensen1Flg"]=="ins"){
			$obj_ensen_ins1 = new basedb_EnsenClassTblAccess;
			$obj_ensen_ins1->conn = $obj_conn->conn;
			$obj_ensen_ins1->ensendat[0]["es_cd"] = $_POST["sc_clid"];
			$obj_ensen_ins1->ensendat[0]["es_type"] = 1;
			$obj_ensen_ins1->ensendat[0]["es_dispno"] = 1;
			$obj_ensen_ins1->ensendat[0]["es_prefcd"] = $_POST["es_prefcd1"];
			$obj_ensen_ins1->ensendat[0]["es_line"] = $_POST["es_line1"];
			$obj_ensen_ins1->ensendat[0]["es_linecd"] = $_POST["es_linecd1"];
			$obj_ensen_ins1->ensendat[0]["es_linecdname"] = $_POST["es_linecdname1"];
			$obj_ensen_ins1->ensendat[0]["es_sta"] = $_POST["es_sta1"];
			$obj_ensen_ins1->ensendat[0]["es_stacd"] = $_POST["es_stacd1"];
			$obj_ensen_ins1->ensendat[0]["es_walk"] = $_POST["es_walk1"];
			$obj_ensen_ins1->ensendat[0]["es_bus"] = $_POST["es_bus1"];
			$obj_ensen_ins1->ensendat[0]["es_biko"] = $_POST["es_biko1"];
			$obj_ensen_ins1->ensendat[0]["es_adminid"] = $_POST["es_clid"];
			$obj_ensen_ins1->ensendat[0]["es_yoni1"] = $_POST["es_yoni1_1"];
			$obj_ensen_ins1->ensendat[0]["es_yoni2"] = $_POST["es_yoni2_1"];
			$obj_ensen_ins1->ensendat[0]["es_yoni3"] = $_POST["es_yoni3_1"];
			$obj_ensen_ins1->ensendat[0]["es_yoni4"] = $_POST["es_yoni4_1"];
			$obj_ensen_ins1->ensendat[0]["es_yoni5"] = $_POST["es_yoni5_1"];
			$suc = $obj_ensen_ins1->basedb_InsEnsen();
		}else if($_POST["ensen1Flg"]=="edit"){
			$obj_ensen_upd1 = new basedb_EnsenClassTblAccess;
			$obj_ensen_upd1->conn = $obj_conn->conn;
			$obj_ensen_upd1->ensendat[0]["es_id"] = $_POST["es_id1"];
			$obj_ensen_upd1->ensendat[0]["es_cd"] = $_POST["sc_clid"];
			$obj_ensen_upd1->ensendat[0]["es_type"] = 1;
			$obj_ensen_upd1->ensendat[0]["es_dispno"] = 1;
			$obj_ensen_upd1->ensendat[0]["es_prefcd"] = $_POST["es_prefcd1"];
			$obj_ensen_upd1->ensendat[0]["es_line"] = $_POST["es_line1"];
			$obj_ensen_upd1->ensendat[0]["es_linecd"] = $_POST["es_linecd1"];
			$obj_ensen_upd1->ensendat[0]["es_linecdname"] = $_POST["es_linecdname1"];
			$obj_ensen_upd1->ensendat[0]["es_sta"] = $_POST["es_sta1"];
			$obj_ensen_upd1->ensendat[0]["es_stacd"] = $_POST["es_stacd1"];
			$obj_ensen_upd1->ensendat[0]["es_walk"] = $_POST["es_walk1"];
			$obj_ensen_upd1->ensendat[0]["es_bus"] = $_POST["es_bus1"];
			$obj_ensen_upd1->ensendat[0]["es_biko"] = $_POST["es_biko1"];
			$obj_ensen_upd1->ensendat[0]["es_adminid"] = $_POST["es_clid"];
			$obj_ensen_upd1->ensendat[0]["es_upddate"] = $_POST["es_upddate1"];
			$obj_ensen_upd1->ensendat[0]["es_yoni1"] = $_POST["es_yoni1_1"];
			$obj_ensen_upd1->ensendat[0]["es_yoni2"] = $_POST["es_yoni2_1"];
			$obj_ensen_upd1->ensendat[0]["es_yoni3"] = $_POST["es_yoni3_1"];
			$obj_ensen_upd1->ensendat[0]["es_yoni4"] = $_POST["es_yoni4_1"];
			$obj_ensen_upd1->ensendat[0]["es_yoni5"] = $_POST["es_yoni5_1"];
			$suc = $obj_ensen_upd1->basedb_UpdEnsen();
		}

		if($_POST["ensen2Flg"]=="ins"){
			$obj_ensen_ins2 = new basedb_EnsenClassTblAccess;
			$obj_ensen_ins2->conn = $obj_conn->conn;
			$obj_ensen_ins2->ensendat[0]["es_cd"] = $_POST["sc_clid"];
			$obj_ensen_ins2->ensendat[0]["es_type"] = 1;
			$obj_ensen_ins2->ensendat[0]["es_dispno"] = 2;
			$obj_ensen_ins2->ensendat[0]["es_prefcd"] = $_POST["es_prefcd2"];
			$obj_ensen_ins2->ensendat[0]["es_line"] = $_POST["es_line2"];
			$obj_ensen_ins2->ensendat[0]["es_linecd"] = $_POST["es_linecd2"];
			$obj_ensen_ins2->ensendat[0]["es_linecdname"] = $_POST["es_linecdname2"];
			$obj_ensen_ins2->ensendat[0]["es_sta"] = $_POST["es_sta2"];
			$obj_ensen_ins2->ensendat[0]["es_stacd"] = $_POST["es_stacd2"];
			$obj_ensen_ins2->ensendat[0]["es_walk"] = $_POST["es_walk2"];
			$obj_ensen_ins2->ensendat[0]["es_bus"] = $_POST["es_bus2"];
			$obj_ensen_ins2->ensendat[0]["es_biko"] = $_POST["es_biko2"];
			$obj_ensen_ins2->ensendat[0]["es_adminid"] = $_POST["sc_clid"];
			$obj_ensen_ins2->ensendat[0]["es_yoni1"] = $_POST["es_yoni1_2"];
			$obj_ensen_ins2->ensendat[0]["es_yoni2"] = $_POST["es_yoni2_2"];
			$obj_ensen_ins2->ensendat[0]["es_yoni3"] = $_POST["es_yoni3_2"];
			$obj_ensen_ins2->ensendat[0]["es_yoni4"] = $_POST["es_yoni4_2"];
			$obj_ensen_ins2->ensendat[0]["es_yoni5"] = $_POST["es_yoni5_2"];
			$suc = $obj_ensen_ins2->basedb_InsEnsen();
		}else if($_POST["ensen2Flg"]=="edit"){
			$obj_ensen_upd2 = new basedb_EnsenClassTblAccess;
			$obj_ensen_upd2->conn = $obj_conn->conn;
			$obj_ensen_upd2->ensendat[0]["es_id"] = $_POST["es_id2"];
			$obj_ensen_upd2->ensendat[0]["es_cd"] = $_POST["sc_clid"];
			$obj_ensen_upd2->ensendat[0]["es_type"] = 1;
			$obj_ensen_upd2->ensendat[0]["es_dispno"] = 2;
			$obj_ensen_upd2->ensendat[0]["es_prefcd"] = $_POST["es_prefcd2"];
			$obj_ensen_upd2->ensendat[0]["es_line"] = $_POST["es_line2"];
			$obj_ensen_upd2->ensendat[0]["es_linecd"] = $_POST["es_linecd2"];
			$obj_ensen_upd2->ensendat[0]["es_linecdname"] = $_POST["es_linecdname2"];
			$obj_ensen_upd2->ensendat[0]["es_sta"] = $_POST["es_sta2"];
			$obj_ensen_upd2->ensendat[0]["es_stacd"] = $_POST["es_stacd2"];
			$obj_ensen_upd2->ensendat[0]["es_walk"] = $_POST["es_walk2"];
			$obj_ensen_upd2->ensendat[0]["es_bus"] = $_POST["es_bus2"];
			$obj_ensen_upd2->ensendat[0]["es_biko"] = $_POST["es_biko2"];
			$obj_ensen_upd2->ensendat[0]["es_adminid"] = $_POST["sc_clid"];
			$obj_ensen_upd2->ensendat[0]["es_upddate"] = $_POST["es_upddate2"];
			$obj_ensen_upd2->ensendat[0]["es_yoni1"] = $_POST["es_yoni1_2"];
			$obj_ensen_upd2->ensendat[0]["es_yoni2"] = $_POST["es_yoni2_2"];
			$obj_ensen_upd2->ensendat[0]["es_yoni3"] = $_POST["es_yoni3_2"];
			$obj_ensen_upd2->ensendat[0]["es_yoni4"] = $_POST["es_yoni4_2"];
			$obj_ensen_upd2->ensendat[0]["es_yoni5"] = $_POST["es_yoni5_2"];
			$suc = $obj_ensen_upd2->basedb_UpdEnsen();
		}

		if($_POST["ensen3Flg"]=="ins"){
			$obj_ensen_ins3 = new basedb_EnsenClassTblAccess;
			$obj_ensen_ins3->conn = $obj_conn->conn;
			$obj_ensen_ins3->ensendat[0]["es_cd"] = $_POST["sc_clid"];
			$obj_ensen_ins3->ensendat[0]["es_type"] = 1;
			$obj_ensen_ins3->ensendat[0]["es_dispno"] = 3;
			$obj_ensen_ins3->ensendat[0]["es_prefcd"] = $_POST["es_prefcd3"];
			$obj_ensen_ins3->ensendat[0]["es_line"] = $_POST["es_line3"];
			$obj_ensen_ins3->ensendat[0]["es_linecd"] = $_POST["es_linecd3"];
			$obj_ensen_ins3->ensendat[0]["es_linecdname"] = $_POST["es_linecdname3"];
			$obj_ensen_ins3->ensendat[0]["es_sta"] = $_POST["es_sta3"];
			$obj_ensen_ins3->ensendat[0]["es_stacd"] = $_POST["es_stacd3"];
			$obj_ensen_ins3->ensendat[0]["es_walk"] = $_POST["es_walk3"];
			$obj_ensen_ins3->ensendat[0]["es_bus"] = $_POST["es_bus3"];
			$obj_ensen_ins3->ensendat[0]["es_biko"] = $_POST["es_biko3"];
			$obj_ensen_ins3->ensendat[0]["es_adminid"] = $_POST["sc_clid"];
			$obj_ensen_ins3->ensendat[0]["es_yoni1"] = $_POST["es_yoni1_3"];
			$obj_ensen_ins3->ensendat[0]["es_yoni2"] = $_POST["es_yoni2_3"];
			$obj_ensen_ins3->ensendat[0]["es_yoni3"] = $_POST["es_yoni3_3"];
			$obj_ensen_ins3->ensendat[0]["es_yoni4"] = $_POST["es_yoni4_3"];
			$obj_ensen_ins3->ensendat[0]["es_yoni5"] = $_POST["es_yoni5_3"];
			$suc = $obj_ensen_ins3->basedb_InsEnsen();
		}else if($_POST["ensen3Flg"]=="edit"){
			$obj_ensen_upd3 = new basedb_EnsenClassTblAccess;
			$obj_ensen_upd3->conn = $obj_conn->conn;
			$obj_ensen_upd3->ensendat[0]["es_id"] = $_POST["es_id3"];
			$obj_ensen_upd3->ensendat[0]["es_cd"] = $_POST["sc_clid"];
			$obj_ensen_upd3->ensendat[0]["es_type"] = 1;
			$obj_ensen_upd3->ensendat[0]["es_dispno"] = 3;
			$obj_ensen_upd3->ensendat[0]["es_prefcd"] = $_POST["es_prefcd3"];
			$obj_ensen_upd3->ensendat[0]["es_line"] = $_POST["es_line3"];
			$obj_ensen_upd3->ensendat[0]["es_linecd"] = $_POST["es_linecd3"];
			$obj_ensen_upd3->ensendat[0]["es_linecdname"] = $_POST["es_linecdname3"];
			$obj_ensen_upd3->ensendat[0]["es_sta"] = $_POST["es_sta3"];
			$obj_ensen_upd3->ensendat[0]["es_stacd"] = $_POST["es_stacd3"];
			$obj_ensen_upd3->ensendat[0]["es_walk"] = $_POST["es_walk3"];
			$obj_ensen_upd3->ensendat[0]["es_bus"] = $_POST["es_bus3"];
			$obj_ensen_upd3->ensendat[0]["es_biko"] = $_POST["es_biko3"];
			$obj_ensen_upd3->ensendat[0]["es_adminid"] = $_POST["sc_clid"];
			$obj_ensen_upd3->ensendat[0]["es_upddate"] = $_POST["es_upddate3"];
			$obj_ensen_upd3->ensendat[0]["es_yoni1"] = $_POST["es_yoni1_3"];
			$obj_ensen_upd3->ensendat[0]["es_yoni2"] = $_POST["es_yoni2_3"];
			$obj_ensen_upd3->ensendat[0]["es_yoni3"] = $_POST["es_yoni3_3"];
			$obj_ensen_upd3->ensendat[0]["es_yoni4"] = $_POST["es_yoni4_3"];
			$obj_ensen_upd3->ensendat[0]["es_yoni5"] = $_POST["es_yoni5_3"];
			$suc = $obj_ensen_upd3->basedb_UpdEnsen();
		}

		if($_POST["ensen4Flg"]=="ins"){
			$obj_ensen_ins4 = new basedb_EnsenClassTblAccess;
			$obj_ensen_ins4->conn = $obj_conn->conn;
			$obj_ensen_ins4->ensendat[0]["es_cd"] = $_POST["sc_clid"];
			$obj_ensen_ins4->ensendat[0]["es_type"] = 1;
			$obj_ensen_ins4->ensendat[0]["es_dispno"] = 4;
			$obj_ensen_ins4->ensendat[0]["es_prefcd"] = $_POST["es_prefcd4"];
			$obj_ensen_ins4->ensendat[0]["es_line"] = $_POST["es_line4"];
			$obj_ensen_ins4->ensendat[0]["es_linecd"] = $_POST["es_linecd4"];
			$obj_ensen_ins4->ensendat[0]["es_linecdname"] = $_POST["es_linecdname4"];
			$obj_ensen_ins4->ensendat[0]["es_sta"] = $_POST["es_sta4"];
			$obj_ensen_ins4->ensendat[0]["es_stacd"] = $_POST["es_stacd4"];
			$obj_ensen_ins4->ensendat[0]["es_walk"] = $_POST["es_walk4"];
			$obj_ensen_ins4->ensendat[0]["es_bus"] = $_POST["es_bus4"];
			$obj_ensen_ins4->ensendat[0]["es_biko"] = $_POST["es_biko4"];
			$obj_ensen_ins4->ensendat[0]["es_adminid"] = $_POST["sc_clid"];
			$obj_ensen_ins4->ensendat[0]["es_yoni1"] = $_POST["es_yoni1_4"];
			$obj_ensen_ins4->ensendat[0]["es_yoni2"] = $_POST["es_yoni2_4"];
			$obj_ensen_ins4->ensendat[0]["es_yoni3"] = $_POST["es_yoni3_4"];
			$obj_ensen_ins4->ensendat[0]["es_yoni4"] = $_POST["es_yoni4_4"];
			$obj_ensen_ins4->ensendat[0]["es_yoni5"] = $_POST["es_yoni5_4"];
			$suc = $obj_ensen_ins4->basedb_InsEnsen();
		}else if($_POST["ensen4Flg"]=="edit"){
			$obj_ensen_upd4 = new basedb_EnsenClassTblAccess;
			$obj_ensen_upd4->conn = $obj_conn->conn;
			$obj_ensen_upd4->ensendat[0]["es_id"] = $_POST["es_id4"];
			$obj_ensen_upd4->ensendat[0]["es_cd"] = $_POST["sc_clid"];
			$obj_ensen_upd4->ensendat[0]["es_type"] = 1;
			$obj_ensen_upd4->ensendat[0]["es_dispno"] = 4;
			$obj_ensen_upd4->ensendat[0]["es_prefcd"] = $_POST["es_prefcd4"];
			$obj_ensen_upd4->ensendat[0]["es_line"] = $_POST["es_line4"];
			$obj_ensen_upd4->ensendat[0]["es_linecd"] = $_POST["es_linecd4"];
			$obj_ensen_upd4->ensendat[0]["es_linecdname"] = $_POST["es_linecdname4"];
			$obj_ensen_upd4->ensendat[0]["es_sta"] = $_POST["es_sta4"];
			$obj_ensen_upd4->ensendat[0]["es_stacd"] = $_POST["es_stacd4"];
			$obj_ensen_upd4->ensendat[0]["es_walk"] = $_POST["es_walk4"];
			$obj_ensen_upd4->ensendat[0]["es_bus"] = $_POST["es_bus4"];
			$obj_ensen_upd4->ensendat[0]["es_biko"] = $_POST["es_biko4"];
			$obj_ensen_upd4->ensendat[0]["es_adminid"] = $_POST["sc_clid"];
			$obj_ensen_upd4->ensendat[0]["es_upddate"] = $_POST["es_upddate4"];
			$obj_ensen_upd4->ensendat[0]["es_yoni1"] = $_POST["es_yoni1_4"];
			$obj_ensen_upd4->ensendat[0]["es_yoni2"] = $_POST["es_yoni2_4"];
			$obj_ensen_upd4->ensendat[0]["es_yoni3"] = $_POST["es_yoni3_4"];
			$obj_ensen_upd4->ensendat[0]["es_yoni4"] = $_POST["es_yoni4_4"];
			$obj_ensen_upd4->ensendat[0]["es_yoni5"] = $_POST["es_yoni5_4"];
			$suc = $obj_ensen_upd4->basedb_UpdEnsen();
		}

		if($_POST["ensen5Flg"]=="ins"){
			$obj_ensen_ins5 = new basedb_EnsenClassTblAccess;
			$obj_ensen_ins5->conn = $obj_conn->conn;
			$obj_ensen_ins5->ensendat[0]["es_cd"] = $_POST["sc_clid"];
			$obj_ensen_ins5->ensendat[0]["es_type"] = 1;
			$obj_ensen_ins5->ensendat[0]["es_dispno"] = 5;
			$obj_ensen_ins5->ensendat[0]["es_prefcd"] = $_POST["es_prefcd5"];
			$obj_ensen_ins5->ensendat[0]["es_line"] = $_POST["es_line5"];
			$obj_ensen_ins5->ensendat[0]["es_linecd"] = $_POST["es_linecd5"];
			$obj_ensen_ins5->ensendat[0]["es_linecdname"] = $_POST["es_linecdname5"];
			$obj_ensen_ins5->ensendat[0]["es_sta"] = $_POST["es_sta5"];
			$obj_ensen_ins5->ensendat[0]["es_stacd"] = $_POST["es_stacd5"];
			$obj_ensen_ins5->ensendat[0]["es_walk"] = $_POST["es_walk5"];
			$obj_ensen_ins5->ensendat[0]["es_bus"] = $_POST["es_bus5"];
			$obj_ensen_ins5->ensendat[0]["es_biko"] = $_POST["es_biko5"];
			$obj_ensen_ins5->ensendat[0]["es_adminid"] = $_POST["sc_clid"];
			$obj_ensen_ins5->ensendat[0]["es_yoni1"] = $_POST["es_yoni1_5"];
			$obj_ensen_ins5->ensendat[0]["es_yoni2"] = $_POST["es_yoni2_5"];
			$obj_ensen_ins5->ensendat[0]["es_yoni3"] = $_POST["es_yoni3_5"];
			$obj_ensen_ins5->ensendat[0]["es_yoni4"] = $_POST["es_yoni4_5"];
			$obj_ensen_ins5->ensendat[0]["es_yoni5"] = $_POST["es_yoni5_5"];
			$suc = $obj_ensen_ins5->basedb_InsEnsen();
		}else if($_POST["ensen5Flg"]=="edit"){
			$obj_ensen_upd5 = new basedb_EnsenClassTblAccess;
			$obj_ensen_upd5->conn = $obj_conn->conn;
			$obj_ensen_upd5->ensendat[0]["es_id"] = $_POST["es_id5"];
			$obj_ensen_upd5->ensendat[0]["es_cd"] = $_POST["sc_clid"];
			$obj_ensen_upd5->ensendat[0]["es_type"] = 1;
			$obj_ensen_upd5->ensendat[0]["es_dispno"] = 5;
			$obj_ensen_upd5->ensendat[0]["es_prefcd"] = $_POST["es_prefcd5"];
			$obj_ensen_upd5->ensendat[0]["es_line"] = $_POST["es_line5"];
			$obj_ensen_upd5->ensendat[0]["es_linecd"] = $_POST["es_linecd5"];
			$obj_ensen_upd5->ensendat[0]["es_linecdname"] = $_POST["es_linecdname5"];
			$obj_ensen_upd5->ensendat[0]["es_sta"] = $_POST["es_sta5"];
			$obj_ensen_upd5->ensendat[0]["es_stacd"] = $_POST["es_stacd5"];
			$obj_ensen_upd5->ensendat[0]["es_walk"] = $_POST["es_walk5"];
			$obj_ensen_upd5->ensendat[0]["es_bus"] = $_POST["es_bus5"];
			$obj_ensen_upd5->ensendat[0]["es_biko"] = $_POST["es_biko5"];
			$obj_ensen_upd5->ensendat[0]["es_adminid"] = $_POST["sc_clid"];
			$obj_ensen_upd5->ensendat[0]["es_upddate"] = $_POST["es_upddate5"];
			$obj_ensen_upd5->ensendat[0]["es_yoni1"] = $_POST["es_yoni1_5"];
			$obj_ensen_upd5->ensendat[0]["es_yoni2"] = $_POST["es_yoni2_5"];
			$obj_ensen_upd5->ensendat[0]["es_yoni3"] = $_POST["es_yoni3_5"];
			$obj_ensen_upd5->ensendat[0]["es_yoni4"] = $_POST["es_yoni4_5"];
			$obj_ensen_upd5->ensendat[0]["es_yoni5"] = $_POST["es_yoni5_5"];
			$suc = $obj_ensen_upd5->basedb_UpdEnsen();
		}

		// ���饤����Ⱦ���Υե꡼��ɸ����ѥե�����ɤ򹹿�
		$obj_rev = new basedb_ClientClassTblAccess;
		$obj_rev->conn = $obj_conn->conn;
		$obj_rev->clientdat[0]["cl_id"] = $_POST["sc_clid"];
		$obj_rev->clientdat[0]["cl_upddate"] = $obj_Client->clientdat[0]["cl_upddate"];;
		$obj_rev->clientdat[0]["cl_yobi1"] = $cl_yobi1;
		$obj_rev->clientdat[0]["ins_yobi1"] = 1;	// ������Ͽ���UPDATE����1 ;�פ�UPDATE�򤷤ʤ�
		$suc = $obj_rev->basedb_UpdClient();
		switch( $suc ){
			case "-1":
				$arrErr["ath_comment"] = $strErrHidden;
				$obj_error->ViewErrMessage( "UPD_ERROR" , "ALL" , "blog_mnt.php" , $arrErr );
				exit;
			case "1":
				$arrErr["ath_comment"] = $strErrHidden;
				$obj_error->ViewErrMessage( "DOUBLE_UPD" , "ALL" , "blog_mnt.php" , $arrErr );
				exit;
			case "4":
				$arrErr["ath_comment"] = $strErrHidden;
				$obj_error->ViewErrMessage( "LOGIN_ID" , "ALL" , "blog_mnt.php" , $arrErr );
				exit;
			case "3":
				$arrErr["ath_comment"] = $strErrHidden;
				$obj_error->ViewErrMessage( "URL_CODE" , "ALL" , "blog_mnt.php" , $arrErr );
				exit;
		}

		$message = "��������������ޤ�����";
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
    <TITLE>�Υ֥� - ��������ȴ����ġ���</title>
    <META http-equiv="Content-Type" content="text/html;charset=EUC-JP" />
    <META http-equiv="Content-Style-Type" content="text/css" />
    <META http-equiv="Content-Script-Type" content="text/javascript" />
    <LINK rel="stylesheet" href="../share/css/blog.css" type="text/css" />
    <NOSCRIPT><META http-equiv="Refresh" content="1;URL=../jserror.html"></NOSCRIPT>
  </HEAD>
  <BODY onLoad="window.parent.menu.location.reload();">
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
      <form name="form1" action="blog_main.php" method="POST"> 
        <input type="submit" value=" �� �� " class="btn" />
      </form>
    </div>
  </body>
</html>
