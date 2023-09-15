<?php
/*=========================================================
    ����礻 - �������ƥ����å�
=========================================================*/

// �����å����饹 - ���󥹥���
require_once( SYS_PATH."common/input_check.class.php" );
$obj_check = new input_check();


// ����礻����
IF( count($arrInputData["title"]) == 0 ){
	$arrErr["ath_comment"] = "";
	$arrErr["ath_comment"] .= "���䤤��碌���Ƥ����򤷤Ʋ�������";
	$arrErr["ath_comment"] .= $strInputHidden;
	$arrErr["ath_comment"] .= "<INPUT type=\"hidden\" name=\"form_flg\" value=\"\">\n";
	$obj_error->ViewErrMessage( "INPUT_CHECK_ERROR" , "PORTAL-USER" , _BLOG_SITE_URL_BASE."/juku_inquiry/" , $arrErr );
	exit;
}

// ����˾����
IF( count($arrInputData["device"]) == 0 ){
	$arrErr["ath_comment"] = "";
	$arrErr["ath_comment"] .= "����˾���Ƥ����򤷤Ʋ�������";
	$arrErr["ath_comment"] .= $strInputHidden;
	$arrErr["ath_comment"] .= "<INPUT type=\"hidden\" name=\"form_flg\" value=\"\">\n";
	$obj_error->ViewErrMessage( "INPUT_CHECK_ERROR" , "PORTAL-USER" , _BLOG_SITE_URL_BASE."/juku_inquiry/" , $arrErr );
	exit;
}

/*
// ����礻������ʸ
IF( $arrInputData["contents"] == "" ){
	$arrErr["ath_comment"] = "";
	$arrErr["ath_comment"] .= "���䤤��碌���Ƥ����Ϥ��Ʋ�������";
	$arrErr["ath_comment"] .= $strInputHidden;
	$arrErr["ath_comment"] .= "<INPUT type=\"hidden\" name=\"form_flg\" value=\"\">\n";
	$obj_error->ViewErrMessage( "INPUT_CHECK_ERROR" , "PORTAL-USER" , _BLOG_SITE_URL_BASE."/juku_inquiry/" , $arrErr );
	exit;
}ELSE{
	// ��������å�
	$ret = $obj_check->check_only_space( $arrInputData["contents"] );
	IF( $ret === true ){
		$arrErr["ath_comment"] = "";
		$arrErr["ath_comment"] .= "���䤤��碌���Ƥ϶���Τߤ����ϤϽ���ޤ���";
		$arrErr["ath_comment"] .= $strInputHidden;
		$arrErr["ath_comment"] .= "<INPUT type=\"hidden\" name=\"form_flg\" value=\"\">\n";
		$obj_error->ViewErrMessage( "INPUT_CHECK_ERROR" , "PORTAL-USER" , _BLOG_SITE_URL_BASE."/juku_inquiry/" , $arrErr );
		exit;
	}
}
*/

// ��̾��
IF( $arrInputData["name_kj_1"] == "" ){
	$arrErr["ath_comment"] = "";
	$arrErr["ath_comment"] .= "��̾�������Ϥ��Ʋ�������";
	$arrErr["ath_comment"] .= $strInputHidden;
	$arrErr["ath_comment"] .= "<INPUT type=\"hidden\" name=\"form_flg\" value=\"\">\n";
	$obj_error->ViewErrMessage( "INPUT_CHECK_ERROR" , "PORTAL-USER" , _BLOG_SITE_URL_BASE."/juku_inquiry/" , $arrErr );
	exit;
}ELSE{
	// ��������å�
	$ret_1 = $obj_check->check_only_space( $arrInputData["name_kj_1"] );
	IF( $ret_1 === true ){
		$arrErr["ath_comment"] = "";
		$arrErr["ath_comment"] .= "��̾���϶���Τߤ����ϤϽ���ޤ���";
		$arrErr["ath_comment"] .= $strInputHidden;
		$arrErr["ath_comment"] .= "<INPUT type=\"hidden\" name=\"form_flg\" value=\"\">\n";
		$obj_error->ViewErrMessage( "INPUT_CHECK_ERROR" , "PORTAL-USER" , _BLOG_SITE_URL_BASE."/juku_inquiry/" , $arrErr );
		exit;
	}
}


// ��̾��(�եꥬ��)
IF( $arrInputData["name_kn_1"] != "" ){
	IF( $arrInputData["name_kn_1"] == "" ){
		$arrErr["ath_comment"] = "";
		$arrErr["ath_comment"] .= "��̾��(�եꥬ��)���������Ƥ��ǧ���Ʋ�������";
		$arrErr["ath_comment"] .= $strInputHidden;
		$arrErr["ath_comment"] .= "<INPUT type=\"hidden\" name=\"form_flg\" value=\"\">\n";
		$obj_error->ViewErrMessage( "INPUT_CHECK_ERROR" , "PORTAL-USER" , _BLOG_SITE_URL_BASE."/juku_inquiry/" , $arrErr );
		exit;
	}ELSE{
		// ��������å�
		$ret_1 = $obj_check->check_only_space( $arrInputData["name_kn_1"] );
		IF( $ret_1 === TRUE ){
			$arrErr["ath_comment"] = "";
			$arrErr["ath_comment"] .= "��̾��(�եꥬ��)�϶���Τߤ����ϤϽ���ޤ���";
			$arrErr["ath_comment"] .= $strInputHidden;
			$arrErr["ath_comment"] .= "<INPUT type=\"hidden\" name=\"form_flg\" value=\"\">\n";
			$obj_error->ViewErrMessage( "INPUT_CHECK_ERROR" , "PORTAL-USER" , _BLOG_SITE_URL_BASE."/juku_inquiry/" , $arrErr );
			exit;
		}
		// ���ѥ������ʥ����å�
		$ret_1 = $obj_check->check_katakana( $arrInputData["name_kn_1"] );
		IF( $ret_1 === TRUE ){
			$arrErr["ath_comment"] = "";
			$arrErr["ath_comment"] .= "��̾��(�եꥬ��)�����ѥ������ʤ����Ϥ��Ʋ�������";
			$arrErr["ath_comment"] .= $strInputHidden;
			$arrErr["ath_comment"] .= "<INPUT type=\"hidden\" name=\"form_flg\" value=\"\">\n";
			$obj_error->ViewErrMessage( "INPUT_CHECK_ERROR" , "PORTAL-USER" , _BLOG_SITE_URL_BASE."/juku_inquiry/" , $arrErr );
			exit;
		}
	}
}

	
// E�᡼������å�
IF( $arrInputData["email"] == "" ){
	$arrErr["ath_comment"] = "";
	$arrErr["ath_comment"] .= "�ť᡼�륢�ɥ쥹�����Ϥ��Ʋ�������";
	$arrErr["ath_comment"] .= $strInputHidden;
	$arrErr["ath_comment"] .= "<INPUT type=\"hidden\" name=\"form_flg\" value=\"\">\n";
	$obj_error->ViewErrMessage( "INPUT_CHECK_ERROR" , "PORTAL-USER" , _BLOG_SITE_URL_BASE."/juku_inquiry/" , $arrErr );
	exit;
}
$ret = $obj_check->check_email( $arrInputData["email"] );
IF( $ret === FALSE ){
	$arrErr["ath_comment"] = "";
	$arrErr["ath_comment"] .= "�ť᡼�륢�ɥ쥹�����������Ϥ��Ʋ�������";
	$arrErr["ath_comment"] .= $strInputHidden;
	$arrErr["ath_comment"] .= "<INPUT type=\"hidden\" name=\"form_flg\" value=\"\">\n";
	$obj_error->ViewErrMessage( "INPUT_CHECK_ERROR" , "PORTAL-USER" , _BLOG_SITE_URL_BASE."/juku_inquiry/" , $arrErr );
	exit;
}


// ͹���ֹ�����å�
IF( $arrInputData["addr_cd_1"] != "" || $arrInputData["addr_cd_2"] != "" ){
	IF( $arrInputData["addr_cd_1"] == "" || $arrInputData["addr_cd_2"] == "" ){
		$arrErr["ath_comment"] = "";
		$arrErr["ath_comment"] .= "͹���ֹ�����Ϥ��Ʋ�������";
		$arrErr["ath_comment"] .= $strInputHidden;
		$arrErr["ath_comment"] .= "<INPUT type=\"hidden\" name=\"form_flg\" value=\"\">\n";
		$obj_error->ViewErrMessage( "INPUT_CHECK_ERROR" , "PORTAL-USER" , _BLOG_SITE_URL_BASE."/juku_inquiry/" , $arrErr );
		exit;
	}
	$strBuffAddrCd = $arrInputData["addr_cd_1"]."-".$arrInputData["addr_cd_2"];
	$ret = $obj_check->check_address_code( $strBuffAddrCd );
	IF( $ret === FALSE ){
		$arrErr["ath_comment"] = "";
		$arrErr["ath_comment"] .= "͹���ֹ�����������Ϥ��Ʋ�������<br />͹���ֹ��Ⱦ�ѿ����Τߤ����Ϥ��Ʋ�������";
		$arrErr["ath_comment"] .= $strInputHidden;
		$arrErr["ath_comment"] .= "<INPUT type=\"hidden\" name=\"form_flg\" value=\"\">\n";
		$obj_error->ViewErrMessage( "INPUT_CHECK_ERROR" , "PORTAL-USER" , _BLOG_SITE_URL_BASE."/juku_inquiry/" , $arrErr );
		exit;
	}
}

/*
// ��������å�
IF( $arrInputData["address_1"] != "" || $arrInputData["address_2"] != "" ){
	IF( $arrInputData["address_1"] == "" ){
		$arrErr["ath_comment"] = "";
		$arrErr["ath_comment"] .= "���꣱����Τ褦�����Ϥ��Ʋ�������";
		$arrErr["ath_comment"] .= $strInputHidden;
		$arrErr["ath_comment"] .= "<INPUT type=\"hidden\" name=\"form_flg\" value=\"\">\n";
		$obj_error->ViewErrMessage( "INPUT_CHECK_ERROR" , "PORTAL-USER" , _BLOG_SITE_URL_BASE."/juku_inquiry/" , $arrErr );
		exit;
	}ELSE{
		$ret = $obj_check->check_only_space( $arrInputData["address_1"] );
		IF( $ret === TRUE ){
			$arrErr["ath_comment"] = "";
			$arrErr["ath_comment"] .= "���꣱�϶���Τߤ����ϤϤǤ��ޤ���";
			$arrErr["ath_comment"] .= $strInputHidden;
			$arrErr["ath_comment"] .= "<INPUT type=\"hidden\" name=\"form_flg\" value=\"\">\n";
			$obj_error->ViewErrMessage( "INPUT_CHECK_ERROR" , "PORTAL-USER" , _BLOG_SITE_URL_BASE."/juku_inquiry/" , $arrErr );
			exit;
		}
	}
	IF( $arrInputData["address_2"] != "" ){
		$ret = $obj_check->check_only_space( $arrInputData["address_2"] );
		IF( $ret === TRUE ){
			$arrErr["ath_comment"] = "";
			$arrErr["ath_comment"] .= "���ꣲ�϶���Τߤ����ϤϤǤ��ޤ���";
			$arrErr["ath_comment"] .= $strInputHidden;
			$arrErr["ath_comment"] .= "<INPUT type=\"hidden\" name=\"form_flg\" value=\"\">\n";
			$obj_error->ViewErrMessage( "INPUT_CHECK_ERROR" , "PORTAL-USER" , _BLOG_SITE_URL_BASE."/juku_inquiry/" , $arrErr );
			exit;
		}
	}
}
*/

// �����ֹ�����å�
IF( $arrInputData["tell_1"] != "" ){
//	IF( $arrInputData["tell_1"] == "" || $arrInputData["tell_2"] == "" || $arrInputData["tell_3"] == "" ){
//		$arrErr["ath_comment"] = "";
//		$arrErr["ath_comment"] .= "�����ֹ�����������Ϥ��Ʋ�������";
//		$arrErr["ath_comment"] .= $strInputHidden;
//		$arrErr["ath_comment"] .= "<INPUT type=\"hidden\" name=\"form_flg\" value=\"\">\n";
//		$obj_error->ViewErrMessage( "INPUT_CHECK_ERROR" , "PORTAL-USER" , _BLOG_SITE_URL_BASE."/juku_inquiry/" , $arrErr );
//		exit;
//	}
	$strBuffTell = $arrInputData["tell_1"];
	$ret = $obj_check->check_tell_2( $strBuffTell );
	IF( $ret === FALSE ){
		$arrErr["ath_comment"] = "";
		$arrErr["ath_comment"] .= "�����ֹ�����������Ϥ��Ʋ�������<br />�����ֹ��Ⱦ�ѿ����Τߤ����Ϥ��Ʋ�������";
		$arrErr["ath_comment"] .= $strInputHidden;
		$arrErr["ath_comment"] .= "<INPUT type=\"hidden\" name=\"form_flg\" value=\"\">\n";
		$obj_error->ViewErrMessage( "INPUT_CHECK_ERROR" , "PORTAL-USER" , _BLOG_SITE_URL_BASE."/juku_inquiry/" , $arrErr );
		exit;
	}
}

// ���������ֹ�����å�
IF( $arrInputData["mobile_1"] != "" ){
//	IF( $arrInputData["tell_1"] == "" || $arrInputData["tell_2"] == "" || $arrInputData["tell_3"] == "" ){
//		$arrErr["ath_comment"] = "";
//		$arrErr["ath_comment"] .= "�����ֹ�����������Ϥ��Ʋ�������";
//		$arrErr["ath_comment"] .= $strInputHidden;
//		$arrErr["ath_comment"] .= "<INPUT type=\"hidden\" name=\"form_flg\" value=\"\">\n";
//		$obj_error->ViewErrMessage( "INPUT_CHECK_ERROR" , "PORTAL-USER" , _BLOG_SITE_URL_BASE."/juku_inquiry/" , $arrErr );
//		exit;
//	}
	$strBuffTell = $arrInputData["mobile_1"];
	$ret = $obj_check->check_keitai_tell_2( $strBuffTell );
	IF( $ret === FALSE ){
		$arrErr["ath_comment"] = "";
		$arrErr["ath_comment"] .= "���������ֹ�����������Ϥ��Ʋ�������<br />���������ֹ��Ⱦ�ѿ����Τߤ����Ϥ��Ʋ�������";
		$arrErr["ath_comment"] .= $strInputHidden;
		$arrErr["ath_comment"] .= "<INPUT type=\"hidden\" name=\"form_flg\" value=\"\">\n";
		$obj_error->ViewErrMessage( "INPUT_CHECK_ERROR" , "PORTAL-USER" , _BLOG_SITE_URL_BASE."/juku_inquiry/" , $arrErr );
		exit;
	}
}

/*
// FAX�ֹ�����å�
IF( $arrInputData["fax_1"] != "" || $arrInputData["fax_2"] != "" || $arrInputData["fax_3"] != "" ){
	IF( $arrInputData["fax_1"] == "" || $arrInputData["fax_2"] == "" || $arrInputData["fax_3"] == "" ){
		$arrErr["ath_comment"] = "";
		$arrErr["ath_comment"] .= "FAX�ֹ�����������Ϥ��Ʋ�������";
		$arrErr["ath_comment"] .= $strInputHidden;
		$arrErr["ath_comment"] .= "<INPUT type=\"hidden\" name=\"form_flg\" value=\"\">\n";
		$obj_error->ViewErrMessage( "INPUT_CHECK_ERROR" , "PORTAL-USER" , _BLOG_SITE_URL_BASE."/juku_inquiry/" , $arrErr );
		exit;
	}
}
*/

?>