<?
/******************************************************************************
<< ��ư���֥���Ver.1.O.0 >>
	Name: client_upd.php
	Version: 1.0.0
	Function: ���饤�������Ͽ�������������Ͽ
	Author: Click inc
	Date of creation: 2007/02
	History of modification:

	Copyright (C)2007 Click, inc. All Rights Reserverd.
******************************************************************************/

/*---------------------------------------------------------
	�ե꡼����Ѿ�������
	&���夤�Ƥ���Τϻ����Ϥ�
---------------------------------------------------------*/
function fn_create_freeword( $p_conn , $p_cl_id , &$p_cl_yobi1) {
	$p_cl_yobi1 = '';

	// ������������
	//  �֥����ܾ�����Ͽ
	$obj_blog = new basedb_SchoolClassTblAccess;
	$obj_blog->conn = $p_conn;
	$obj_blog->jyoken["sc_clid"] = $p_cl_id;		// ���饤�����ID
	list( $intCnt , $intTotal ) = $obj_blog->basedb_GetSchool( 0 , -1 );
	if( $intCnt == -1 ){
		$arrOther["ath_comment"] = "";
		$arrOther["ath_comment"] .= "<INPUT TYPE=\"hidden\" NAME=\"stpos\" VALUE=\"{$_POST['stpos']}\">";
		$arrOther["ath_comment"] .= $athComment;
	        $obj_error->ViewErrMessage( "SYSTEM" , "ALL" , "blog_mnt.php" , $arrOther );
	        exit;
	}

	// ���ꥢ��������
	$obj_area = new basedb_AreaClassTblAccess;
	$obj_area->conn = $p_conn;
	$obj_area->jyoken["ar_clid"]	= $p_cl_id;	// ���饤�����ID
	$obj_area->sort['ar_flg']	= 2;			// �оݥ��ꥢ��
	list( $intCnt , $intTotal ) = $obj_area->basedb_GetArea( 0 , -1 );
	if( $intCnt == -1 ){
		$arrOther["ath_comment"] = "";
		$arrOther["ath_comment"] .= "<INPUT TYPE=\"hidden\" NAME=\"stpos\" VALUE=\"{$_POST['stpos']}\">";
		$arrOther["ath_comment"] .= $athComment;
	        $obj_error->ViewErrMessage( "SYSTEM" , "ALL" , "blog_mnt.php" , $arrOther );
	        exit;
	}

	// ������������
	$obj_ensen = new basedb_EnsenClassTblAccess;
	$obj_ensen->conn = $p_conn;
	$obj_ensen->jyoken["es_cd"]	= $p_cl_id;	// ���饤�����ID
	$obj_ensen->jyoken["es_dispno"]	= 1;					// ɽ����=1
	list( $intCnt , $intTotal ) = $obj_ensen->basedb_GetEnsen( 0 , -1 );
				
	// ��̾
	$str = $_POST["cl_jname"];
	if($str!="")$p_cl_yobi1 .= $str . '/';

	// ����̾
	$str = $_POST["cl_kname"];
	if($str!="")$p_cl_yobi1 .= $str . '/';

	// ��̾+����̾
	$str = $_POST["cl_jname"] . $_POST["cl_kname"];
	if($str!="")$p_cl_yobi1 .= $str . '/';

	// ���ꥢ���� $obj_area->areadat�˶������ꡢ���ꥢ1��3��4�쥳�����֤äƤ���
	FOREACH($obj_area->areadat as $key => $val ){

		// ͹���ֹ� ���쥳���ɤ˥ϥ��ե����äƤ�Τǲ���
		$str = $val["ar_zip"];
		if($str!="" and $str!="-")$p_cl_yobi1 .= $str . '/';
		// ��ƻ�ܸ�̾
		$str = $val["ar_pref"];
		if($str!="")$p_cl_yobi1 .= $str . '/';
		// �Զ�Į¼̾
		$str = $val["ar_city"];
		if($str!="")$p_cl_yobi1 .= $str . '/';
		
		// $key=0(�ǽ�Υ쥳����)=�Τν��� �ξ��Τ� ���� ��ʪ̾
		if ($key == 0) {
			// ����
			$str = $val["ar_add"];
			if($str!="")$p_cl_yobi1 .= $str . '/';
			// ��ʪ̾
			$str = $val["ar_estate"];
			if($str!="")$p_cl_yobi1 .= $str . '/';

			// ��ƻ�ܸ�̾+�Զ�Į¼̾+����+��ʪ̾
			$buff_add_str = '';
			$buff_add_str = $val["ar_pref"] . $val["ar_city"] . $val["ar_add"] . $val["ar_estate"];
		} else {
			// ��ƻ�ܸ�̾+�Զ�Į¼̾
			$buff_add_str = '';
			$buff_add_str = $val["ar_pref"] . $val["ar_city"];
		}
		if($buff_add_str!="") $p_cl_yobi1 .= $buff_add_str . '/';
	}

	// �֥��Ҳ�ʸ
	$str = $obj_blog->blogdat[0]["sc_introduce"];
	if($str!="")$p_cl_yobi1 .= $str . '/';

	// ���Ĳ��
	$str = $obj_blog->blogdat[0]["sc_company"];
	if($str!="")$p_cl_yobi1 .= $str . '/';

	// TOP������ɥ������ȥ�
	$str = $obj_blog->blogdat[0]["sc_topwindowtitle"];
	if($str!="")$p_cl_yobi1 .= $str . '/';

	// �إå����ѥ����ȥ�
	$str = $obj_blog->blogdat[0]["sc_headertitle"];
	if($str!="")$p_cl_yobi1 .= $str . '/';

	// TOP�������󥿥��ȥ�
	$str = $obj_blog->blogdat[0]["sc_toptitle"];
	if($str!="")$p_cl_yobi1 .= $str . '/';

	// TOP�������󥵥֥����ȥ�
	$str = $obj_blog->blogdat[0]["sc_topsubtitle"];
	if($str!="")$p_cl_yobi1 .= $str . '/';

	// TOP�����ڡ��󥤥٥��
	$str = $obj_blog->blogdat[0]["sc_campaintitle"];
	if($str!="")$p_cl_yobi1 .= $str . '/';

	// TOP���������󥿥��ȥ�
	$str = $obj_blog->blogdat[0]["sc_coursetitle"];
	if($str!="")$p_cl_yobi1 .= $str . '/';

	// TOP�������󥿥��ȥ�
	$str = $obj_blog->blogdat[0]["sc_diarytitle"];
	if($str!="")$p_cl_yobi1 .= $str . '/';

	// ��������ʸ
	$str = $obj_blog->blogdat[0]["sc_addmission"];
	if($str!="")$p_cl_yobi1 .= $str . '/';

	// �оݳ�ǯ
	$sc_age = htmlspecialchars ($obj_blog->blogdat[0]["sc_age"]);
	if(($sc_age & 64) == 64 ){
		$p_cl_yobi1 .= "�Ҳ��" . '/';
		$sc_age -= 64;
	}
	if(($sc_age & 32) == 32 ){
		$p_cl_yobi1 .= "�����" . '/';
		$sc_age -= 32;
	}
	if(($sc_age & 16) == 16 ){
		$p_cl_yobi1 .= "ϲ����" . '/';
		$sc_age -= 16;
	}
	if(($sc_age & 8) == 8 ){
		$p_cl_yobi1 .= "�⹻��" . '/';
		$sc_age -= 8;
	}
	if(($sc_age & 4) == 4 ){
		$p_cl_yobi1 .= "�����" . '/';
		$sc_age -= 4;
	}
	if(($sc_age & 2) == 2 ){
		$p_cl_yobi1 .= "������" . '/';
		$sc_age -= 2;
	}
	if(($sc_age & 1) == 1 ){
		$p_cl_yobi1 .= "�Ļ�" . '/';
		$sc_age -= 1;
	}

	// ���ȷ���
	$sc_classform = htmlspecialchars ($obj_blog->blogdat[0]["sc_classform"]);
	if(($sc_classform & 4) == 4 ){
		$p_cl_yobi1 .= "����" . '/';
		$sc_classform -= 4;
	}
	if(($sc_classform & 2) == 2 ){
		$p_cl_yobi1 .= "���Ϳ�" . '/';
		$sc_classform -= 2;
	}
	if(($sc_classform & 1) == 1 ){
		$p_cl_yobi1 .= "����" . '/';
		$sc_age -= 1;
	}

	// �Ǵ����̾
	$str = $obj_ensen->ensendat[0]["es_line"];
	if($str!="")$p_cl_yobi1 .= $str . '/';

	// �Ǵ��̾
	$str = $obj_ensen->ensendat[0]["es_sta"];
	if($str!="")$p_cl_yobi1 .= $str . '��' . '/';

	// ����
	$str = $obj_ensen->ensendat[0]["es_walk"];
	if($str!="")$p_cl_yobi1 .= '����' . $str . 'ʬ' . '/';

	// �Х�
	$str = $obj_ensen->ensendat[0]["es_bus"];
	if($str!="")$p_cl_yobi1 .= '�Х�' . $str . 'ʬ' . '/';

	// ����PRʸ
	$str = $obj_blog->blogdat[0]["sc_pr"];
	if($str!="")$p_cl_yobi1 .= $str . '/';

	// �Ǹ��Ƭ�˥���å����Ĥ��� (������ʤ����)
	if ($p_cl_yobi1 != "") $p_cl_yobi1 = '/' . $p_cl_yobi1;

}
// �ե꡼����Ѿ�������--END


/*----------------------------------------------------------
  ɬ�ץե�����ƤӽФ�
----------------------------------------------------------*/
require_once ( "../ini_sets_2.php" );
require_once ( SYS_PATH."dbif/dbcom_DBconnectClass.php" );
require_once ( SYS_PATH."dbif/basedb_AdminClass.php" );
require_once ( SYS_PATH."dbif/basedb_AreaClass.php" );
require_once ( SYS_PATH."dbif/basedb_ClientClass.php" );
require_once ( SYS_PATH."dbif/basedb_SchoolClass.php" );
require_once ( SYS_PATH."dbif/basedb_EnsenClass.php" );
require_once ( SYS_PATH."common/base_common.php" );
require_once ( SYS_PATH."common/sys_common.php" );
require_once ( SYS_PATH."common/error.class.php" );
require_once ( SYS_PATH."configs/param_mail.conf" );


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
//print_r($_POST);


$_POST['cl_zip'] = $_POST['cl_zip1']."-".$_POST['cl_zip2'];
$zip = $_POST['ar_zip1']."-".$_POST['ar_zip2'];
$zip1 = $_POST['ar_zip1_1']."-".$_POST['ar_zip1_2'];
$zip2 = $_POST['ar_zip2_1']."-".$_POST['ar_zip2_2'];
$zip3 = $_POST['ar_zip3_1']."-".$_POST['ar_zip3_2'];

$_POST["cl_logincd"]=sha1($_POST["cl_loginid"]);
$_POST["cl_passcd"]=sha1($_POST["cl_passwd"]);

$athComment = "";
$athComment .= "<INPUT TYPE=\"hidden\" NAME=\"error_mode\" VALUE=\"on\">";
FOREACH( $_POST as $key => $val ){
	$val = stripslashes(htmlspecialchars($val));
        $athComment .= "<INPUT type=\"hidden\" name=\"{$key}\" value=\"{$val}\">\n";
}

switch( $_POST["mode"] ){
	case 'EDIT':
		// �ե꡼��ɸ�����ʸ���������
		fn_create_freeword( $obj_conn->conn , $_POST["cl_id"] , $cl_yobi1);

		$obj_rev = new basedb_ClientClassTblAccess;
		$obj_rev->conn = $obj_conn->conn;
		$obj_rev->clientdat[0]["cl_id"] = $_POST["cl_id"];
		$obj_rev->clientdat[0]["cl_loginid"] = $_POST["cl_loginid"];
		$obj_rev->clientdat[0]["cl_passwd"] = $_POST["cl_passwd"];
		$obj_rev->clientdat[0]["cl_logincd"] = $_POST["cl_logincd"];
		$obj_rev->clientdat[0]["cl_passcd"] = sha1($_POST["cl_passwd"]);
		$obj_rev->clientdat[0]["cl_urlcd"] = $_POST["cl_urlcd"];
		$obj_rev->clientdat[0]["cl_stat"] = $_POST["cl_stat"];
		$obj_rev->clientdat[0]["cl_pstat"] = $_POST["cl_pstat"];
		$obj_rev->clientdat[0]["cl_start"] = $_POST["cl_start"];
		$obj_rev->clientdat[0]["cl_end"] = $_POST["cl_end"];
		$obj_rev->clientdat[0]["cl_jname"] = $_POST["cl_jname"];
		$obj_rev->clientdat[0]["cl_kname"] = $_POST["cl_kname"];
		$obj_rev->clientdat[0]["cl_agent"] = $_POST["cl_agent"];
		$obj_rev->clientdat[0]["cl_mail"] = $_POST["cl_mail"];
		$obj_rev->clientdat[0]["cl_zip"] = $_POST['cl_zip'];
		$obj_rev->clientdat[0]["cl_pref"] = $_POST["cl_pref"];
		$obj_rev->clientdat[0]["cl_prefcd"] = $_POST['cl_prefcd'];
		$obj_rev->clientdat[0]["cl_city"] = $_POST["cl_city"];
		$obj_rev->clientdat[0]["cl_citycd"] = $_POST['cl_citycd'];
		$obj_rev->clientdat[0]["cl_add"] = $_POST["cl_add"];
		$obj_rev->clientdat[0]["cl_estate"] = $_POST["cl_estate"];
		$obj_rev->clientdat[0]["cl_phone"] = $_POST["cl_phone"];
		$obj_rev->clientdat[0]["cl_fax"] = $_POST["cl_fax"];
		$obj_rev->clientdat[0]["cl_biko"] = $_POST["cl_biko"];
		$obj_rev->clientdat[0]["cl_dokuji_flg"] = $_POST["cl_dokuji_flg"];
		$obj_rev->clientdat[0]["cl_googlemap_key"] = $_POST["cl_googlemap_key"];
		$obj_rev->clientdat[0]["cl_dokuji_domain"] = $_POST["cl_dokuji_domain"];
		$obj_rev->clientdat[0]["cl_adminid"] = NULL;
		$obj_rev->clientdat[0]["cl_upddate"] = $_POST["cl_upddate"];
		$obj_rev->clientdat[0]["cl_yobi1"] = $cl_yobi1;
		$suc = $obj_rev->basedb_UpdClient();
		switch( $suc ){
			case "-1":
				$arrErr["ath_comment"] = "";
                       		$arrOther["ath_comment"] .= "<INPUT TYPE=\"hidden\" NAME=\"stpos\" VALUE=\"{$_POST['stpos']}\">";
                       		$arrOther["ath_comment"] .= $athComment;
                        	$obj_error->ViewErrMessage( "UPD_ERROR" , "ALL" , "cl_mnt.php" , $arrOther );
                        	exit;
			case "1":
				$arrErr["ath_comment"] = "";
                        	$arrOther["ath_comment"] = "<INPUT TYPE=\"hidden\" NAME=\"stpos\" VALUE=\"{$_POST['stpos']}\">";
                        	$obj_error->ViewErrMessage( "DOUBLE_UPD" , "ALL" , "cl_main.php" , $arrOther );
                        	exit;
			case "3":
				$arrErr["ath_comment"] = "";
                        	$arrOther["ath_comment"] = "<INPUT TYPE=\"hidden\" NAME=\"stpos\" VALUE=\"{$_POST['stpos']}\">";
                       		$arrOther["ath_comment"] .= $athComment;
                        	$obj_error->ViewErrMessage( "URL_CODE" , "ALL" , "cl_mnt.php" , $arrOther );
                        	exit;
			case "4":
				$arrErr["ath_comment"] = "";
                        	$arrOther["ath_comment"] = "<INPUT TYPE=\"hidden\" NAME=\"stpos\" VALUE=\"{$_POST['stpos']}\">";
                       		$arrOther["ath_comment"] .= $athComment;
                        	$obj_error->ViewErrMessage( "LOGIN_ID" , "ALL" , "cl_mnt.php" , $arrOther );
                        	exit;
		}
		
		//  ���ꥢ������Ͽ
		$obj_area = new basedb_AreaClassTblAccess;
		$obj_area->conn = $obj_conn->conn;
		$obj_area->areadat[0]["ar_id"] = $_POST["ar_id"];;
		$obj_area->areadat[0]["ar_clid"] = $obj_new->clientdat[0]["cl_id"];
		$obj_area->areadat[0]["ar_flg"] = 1;
		$obj_area->areadat[0]["ar_zip"] = $zip;
		$obj_area->areadat[0]["ar_pref"] = $_POST["ar_pref"];
		$obj_area->areadat[0]["ar_prefcd"] = $_POST["ar_prefcd"];
		$obj_area->areadat[0]["ar_city"] = $_POST["ar_city"];
		$obj_area->areadat[0]["ar_citycd"] = $_POST["ar_citycd"];
		$obj_area->areadat[0]["ar_add"] = $_POST["ar_add"];
		$obj_area->areadat[0]["ar_estate"] = $_POST["ar_estate"];
		$obj_area->areadat[0]["ar_upddate"] = $_POST["ar_upddate"];
		$ret_area = $obj_area->basedb_UpdArea();
		IF( $ret_area != 0 ) {
echo("ret_area...".$ret_area);
			$arrErr["ath_comment"] = $strErrHidden;
			$obj_error->ViewErrMessage( "CLIENT_NO_BLOG" , "ALL" , "client_main.php" , $arrErr );
			exit;
		}

		//  ���ꥢ������Ͽ
		$obj_area1 = new basedb_AreaClassTblAccess;
		$obj_area1->conn = $obj_conn->conn;
		$obj_area1->areadat[0]["ar_id"] = $_POST["ar_id1"];;
		$obj_area1->areadat[0]["ar_clid"] = $obj_new->clientdat[0]["cl_id"];
		$obj_area1->areadat[0]["ar_flg"] = 2;
		$obj_area1->areadat[0]["ar_zip"] = $zip1;
		$obj_area1->areadat[0]["ar_pref"] = $_POST["ar_pref1"];
		$obj_area1->areadat[0]["ar_prefcd"] = $_POST["ar_prefcd1"];
		$obj_area1->areadat[0]["ar_city"] = $_POST["ar_city1"];
		$obj_area1->areadat[0]["ar_citycd"] = $_POST["ar_citycd1"];
		$obj_area1->areadat[0]["ar_add"] = $_POST["ar_add1"];
		$obj_area1->areadat[0]["ar_estate"] = $_POST["ar_estate1"];
		$obj_area1->areadat[0]["ar_upddate"] = $_POST["ar_upddate1"];
		$ret_area1 = $obj_area1->basedb_UpdArea();
		IF( $ret_area1 != 0 ) {
echo("ret_area1...".$ret_area1);
			$arrErr["ath_comment"] = $strErrHidden;
			$obj_error->ViewErrMessage( "CLIENT_NO_BLOG" , "ALL" , "client_main.php" , $arrErr );
			exit;
		}

		//  ���ꥢ������Ͽ
		$obj_area2 = new basedb_AreaClassTblAccess;
		$obj_area2->conn = $obj_conn->conn;
		$obj_area2->areadat[0]["ar_id"] = $_POST["ar_id2"];;
		$obj_area2->areadat[0]["ar_clid"] = $obj_new->clientdat[0]["cl_id"];
		$obj_area2->areadat[0]["ar_flg"] = 3;
		$obj_area2->areadat[0]["ar_zip"] = $zip2;
		$obj_area2->areadat[0]["ar_pref"] = $_POST["ar_pref2"];
		$obj_area2->areadat[0]["ar_prefcd"] = $_POST["ar_prefcd2"];
		$obj_area2->areadat[0]["ar_city"] = $_POST["ar_city2"];
		$obj_area2->areadat[0]["ar_citycd"] = $_POST["ar_citycd2"];
		$obj_area2->areadat[0]["ar_add"] = $_POST["ar_add2"];
		$obj_area2->areadat[0]["ar_estate"] = $_POST["ar_estate2"];
		$obj_area2->areadat[0]["ar_upddate"] = $_POST["ar_upddate2"];
		$ret_area2 = $obj_area2->basedb_UpdArea();
		IF( $ret_area2 != 0 ) {
echo("ret_area2...".$ret_area2);
			$arrErr["ath_comment"] = $strErrHidden;
			$obj_error->ViewErrMessage( "CLIENT_NO_BLOG" , "ALL" , "client_main.php" , $arrErr );
			exit;
		}

		//  ���ꥢ������Ͽ
		$obj_area3 = new basedb_AreaClassTblAccess;
		$obj_area3->conn = $obj_conn->conn;
		$obj_area3->areadat[0]["ar_id"] = $_POST["ar_id3"];;
		$obj_area3->areadat[0]["ar_clid"] = $obj_new->clientdat[0]["cl_id"];
		$obj_area3->areadat[0]["ar_flg"] = 4;
		$obj_area3->areadat[0]["ar_zip"] = $zip3;
		$obj_area3->areadat[0]["ar_pref"] = $_POST["ar_pref3"];
		$obj_area3->areadat[0]["ar_prefcd"] = $_POST["ar_prefcd3"];
		$obj_area3->areadat[0]["ar_city"] = $_POST["ar_city3"];
		$obj_area3->areadat[0]["ar_citycd"] = $_POST["ar_citycd3"];
		$obj_area3->areadat[0]["ar_add"] = $_POST["ar_add3"];
		$obj_area3->areadat[0]["ar_estate"] = $_POST["ar_estate3"];
		$obj_area3->areadat[0]["ar_upddate"] = $_POST["ar_upddate3"];
		$ret_area3 = $obj_area3->basedb_UpdArea();
		IF( $ret_area3 != 0 ) {
echo("ret_area3...".$ret_area3);
			$arrErr["ath_comment"] = $strErrHidden;
			$obj_error->ViewErrMessage( "CLIENT_NO_BLOG" , "ALL" , "client_main.php" , $arrErr );
			exit;
		}

		/*----------------------------------------------------------
		  �������ƥ᡼�������Ԥ�����
		----------------------------------------------------------*/
		$strFromName = $_POST["cl_jname"].$_POST["cl_kname"];
		$strFromName = mb_convert_encoding( $strFromName , "JIS" , "AUTO" );
		$strFromAddr = $_POST["cl_mail"];
		$strMailTitle = $param_mail_cl_edit["title"];
		$strMailContents = $param_mail_cl_edit["contents"];
		$strMailContents = mb_convert_encoding( $strMailContents , "JIS" , "AUTO" );
		
		// �᡼��إå���
		$headers = "";
		$headers .= "From: =?iso-2022-jp?B?".base64_encode($strFromName)."?= <{$strFromAddr}>\n";
		$headers .= "Errors-To: {$param_mail_cl_edit["error"]}\n";
		$headers .= "Reply-To: {$strFromAddr}\n";
		$headers .= "Mine-Version: 1.0\n";
		$headers .= "Content-Type: text/plain; charset=iso-2022-jp\n";
		$headers .= "Content-Transfer-Encoding: 7bit\n";
		$headers .= "X-Sender: {$strFromAddr}\n";
		$headers .= "X-Mailer: PHP";
		
		// �᡼�륿���ȥ�
		$subject = mb_convert_encoding( $strMailTitle , "JIS" , "AUTO" );
		$subject = "=?iso-2022-jp?B?".base64_encode($subject)."?=";
		
		// �᡼����ʸ
		$strReplace = "";
		$strReplace .= "���̾ : {$_POST["cl_jname"]}\n";
		$strReplace .= "��Ź̾ : {$_POST["cl_kname"]}\n";
		$strReplace .= "ô����̾ : {$_POST["cl_agent"]}\n";
		$strReplace .= "ô���ԥ᡼�륢�ɥ쥹 : {$_POST["cl_mail"]}\n";
		$strReplace .= "���͹���ֹ� : {$_POST["cl_zip1"]}-{$_POST["cl_zip2"]}\n";
		$strReplace .= "��ҽ��� : {$_POST["cl_pref"]}{$_POST["cl_city"]}{$_POST["cl_add"]}��{$_POST["cl_estate"]}\n";
		$strReplace .= "��������ֹ� : {$_POST["cl_phone"]}\n";
		$strReplace .= "���FAX�ֹ� : {$_POST["cl_fax"]}\n";
		$strReplace = mb_convert_encoding( $strReplace , "JIS" , "AUTO" );
		$body = str_replace( "<--CODE-->" , $strReplace , $strMailContents );
		$body = str_replace( "\r" , "\n" , str_replace( "\r\n" , "\n" , $body ) );
		
		// �᡼����������
		IF( !mail( $param_mail_cl_edit["to"] , $subject , $body , $headers , "-f".$param_mail_cl_edit["error"] ) ){
                        	$arrOther["ath_comment"] = "<INPUT TYPE=\"hidden\" NAME=\"stpos\" VALUE=\"{$_POST['stpos']}\">";
                        	$obj_error->ViewErrMessage( "CLIENT_MAIL_ERROR" , "ALL" , "cl_main.php" , $arrOther );
                        	exit;
		}ELSE{
			$message = "";
			$message .= "���饤����Ⱦ���������ޤ�����<br />�����Ԥؽ������Ƥ�᡼���������ޤ�����";
		}
		
		// ������ѥ���ɤ��ѹ�������м��ڡ������ѹ�����
		IF( $obj_rev->clientdat[0]["login_pass_change"] == 1 ){
			$message .= "<br />������ѥ���ɤ��ѹ�������硢���٥�����򤷤Ʋ�������";
			$FormNext = "../index.html";
			$FormTarget = "_top";
		}ELSE{
			$FormNext = "cl_main.php";
			$FormTarget = "_self";
		}
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
    <LINK rel="stylesheet" type="text/css" href="../share/css/cl.css" />
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
      <form name="form1" method="POST" action="<?=$FormNext?>" target="<?=$FormTarget?>"> 
        <input type="submit" value=" �� �� " class="btn" />
      </form>
    </div>
  </body>
</html>
