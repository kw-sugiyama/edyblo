<?php
/*=========================================================
    ����礻 - �������ƥ����å�
=========================================================*/

// �����å����饹 - ���󥹥���
require_once( SYS_PATH."common/input_check.class.php" );
$obj_check = new input_check();


// ����礻����
IF( is_array( $arrInputData["question"] ) === FALSE ){
	$arrErr["ath_comment"] = "";
	$arrErr["ath_comment"] .= "���䤤��碌���Ƥ����򤷤Ʋ�������";
	$arrErr["ath_comment"] .= $strInputHidden;
	$arrErr["ath_comment"] .= "<INPUT type=\"hidden\" name=\"form_flg\" value=\"\">\n";
	$obj_error->ViewErrMessage( "INPUT_CHECK_ERROR" , "USER" , _BLOG_SITE_URL_BASE."applicate/" , $arrErr );
	exit;
}ELSEIF( in_array( "99" , $arrInputData["question"] ) ){
	IF( $arrInputData["question_other"] == "" ){
		$arrErr["ath_comment"] = "";
		$arrErr["ath_comment"] .= "�֤���¾�פ����򤷤���硢���Ƥ����Ϥ��Ʋ�������";
		$arrErr["ath_comment"] .= $strInputHidden;
		$arrErr["ath_comment"] .= "<INPUT type=\"hidden\" name=\"form_flg\" value=\"\">\n";
		$obj_error->ViewErrMessage( "INPUT_CHECK_ERROR" , "USER" , _BLOG_SITE_URL_BASE."applicate/" , $arrErr );
		exit;
	}ELSE{
		// ��������å�
		$ret = $obj_check->check_only_space( $arrInputData["contents"] );
		IF( $ret === true ){
			$arrErr["ath_comment"] = "";
			$arrErr["ath_comment"] .= "�֤���¾�פ����Ƥ϶���Τߤ����ϤϽ���ޤ���";
			$arrErr["ath_comment"] .= $strInputHidden;
			$arrErr["ath_comment"] .= "<INPUT type=\"hidden\" name=\"form_flg\" value=\"\">\n";
			$obj_error->ViewErrMessage( "INPUT_CHECK_ERROR" , "USER" , _BLOG_SITE_URL_BASE."applicate/" , $arrErr );
			exit;
		}
	}
}


// ��̾(����)
IF( $arrInputData["name_kj_1"] == "" || $arrInputData["name_kj_2"] == "" ){
	$arrErr["ath_comment"] = "";
	$arrErr["ath_comment"] .= "��̾(����)�����Ϥ��Ʋ�������";
	$arrErr["ath_comment"] .= $strInputHidden;
	$arrErr["ath_comment"] .= "<INPUT type=\"hidden\" name=\"form_flg\" value=\"\">\n";
	$obj_error->ViewErrMessage( "INPUT_CHECK_ERROR" , "USER" , _BLOG_SITE_URL_BASE."applicate/" , $arrErr );
	exit;
}ELSE{
	// ��������å�
	$ret_1 = $obj_check->check_only_space( $arrInputData["name_kj_1"] );
	$ret_2 = $obj_check->check_only_space( $arrInputData["name_kj_2"] );
	IF( $ret_1 === true || $ret_2 === true ){
		$arrErr["ath_comment"] = "";
		$arrErr["ath_comment"] .= "��̾(����)�϶���Τߤ����ϤϽ���ޤ���";
		$arrErr["ath_comment"] .= $strInputHidden;
		$arrErr["ath_comment"] .= "<INPUT type=\"hidden\" name=\"form_flg\" value=\"\">\n";
		$obj_error->ViewErrMessage( "INPUT_CHECK_ERROR" , "USER" , _BLOG_SITE_URL_BASE."applicate/" , $arrErr );
		exit;
	}
}


// ��̾(�եꥬ��)
IF( $arrInputData["name_kn_1"] != "" || $arrInputData["name_kn_2"] != "" ){
	IF( $arrInputData["name_kn_1"] == "" || $arrInputData["name_kn_2"] == "" ){
		$arrErr["ath_comment"] = "";
		$arrErr["ath_comment"] .= "��̾(�եꥬ��)���������Ƥ��ǧ���Ʋ�������";
		$arrErr["ath_comment"] .= $strInputHidden;
		$arrErr["ath_comment"] .= "<INPUT type=\"hidden\" name=\"form_flg\" value=\"\">\n";
		$obj_error->ViewErrMessage( "INPUT_CHECK_ERROR" , "USER" , _BLOG_SITE_URL_BASE."applicate/" , $arrErr );
		exit;
	}ELSE{
		// ��������å�
		$ret_1 = $obj_check->check_only_space( $arrInputData["name_kn_1"] );
		$ret_2 = $obj_check->check_only_space( $arrInputData["name_kn_2"] );
		IF( $ret_1 === TRUE || $ret_2 === TRUE ){
			$arrErr["ath_comment"] = "";
			$arrErr["ath_comment"] .= "��̾(�եꥬ��)�϶���Τߤ����ϤϽ���ޤ���";
			$arrErr["ath_comment"] .= $strInputHidden;
			$arrErr["ath_comment"] .= "<INPUT type=\"hidden\" name=\"form_flg\" value=\"\">\n";
			$obj_error->ViewErrMessage( "INPUT_CHECK_ERROR" , "USER" , _BLOG_SITE_URL_BASE."applicate/" , $arrErr );
			exit;
		}
		// ���ѥ������ʥ����å�
		$ret_1 = $obj_check->check_katakana( $arrInputData["name_kn_1"] );
		$ret_2 = $obj_check->check_katakana( $arrInputData["name_kn_2"] );
		IF( $ret_1 === TRUE || $ret_2 === TRUE ){
			$arrErr["ath_comment"] = "";
			$arrErr["ath_comment"] .= "��̾(�եꥬ��)�����ѥ������ʤ����Ϥ��Ʋ�������";
			$arrErr["ath_comment"] .= $strInputHidden;
			$arrErr["ath_comment"] .= "<INPUT type=\"hidden\" name=\"form_flg\" value=\"\">\n";
			$obj_error->ViewErrMessage( "INPUT_CHECK_ERROR" , "USER" , _BLOG_SITE_URL_BASE."applicate/" , $arrErr );
			exit;
		}
	}
}


// ���� - �����å����ʤ�


// ǯ��
IF( $arrInputData["old"] != "" ){
	$ret = $obj_check->check_only_hanint( $arrInputData["old"] );
	IF( $ret === FALSE ){
		$arrErr["ath_comment"] = "";
		$arrErr["ath_comment"] .= "ǯ���Ⱦ�ѿ����Τߤ����Ϥ��Ʋ�������";
		$arrErr["ath_comment"] .= $strInputHidden;
		$arrErr["ath_comment"] .= "<INPUT type=\"hidden\" name=\"form_flg\" value=\"\">\n";
		$obj_error->ViewErrMessage( "INPUT_CHECK_ERROR" , "USER" , _BLOG_SITE_URL_BASE."applicate/" , $arrErr );
		exit;
	}
}


// ���� - �����å����ʤ�


// Ϣ����ˡ
IF( $arrInputData["report_type_1"] != 1 && $arrInputData["report_type_2"] != 2 && $arrInputData["report_type_3"] != 3 && $arrInputData["report_type_4"] != 4 ){
	$arrErr["ath_comment"] = "";
	$arrErr["ath_comment"] .= "Ϣ����ˡ��ҤȤİʾ����򤷤Ʋ�������";
	$arrErr["ath_comment"] .= $strInputHidden;
	$arrErr["ath_comment"] .= "<INPUT type=\"hidden\" name=\"form_flg\" value=\"\">\n";
	$obj_error->ViewErrMessage( "INPUT_CHECK_ERROR" , "USER" , _BLOG_SITE_URL_BASE."applicate/" , $arrErr );
	exit;
}ELSE{
	// ����Ϣ��OK
	IF( $arrInputData["report_type_1"] == 1 ){
		IF( $arrInputData["tell_1"] == "" || $arrInputData["tell_2"] == "" || $arrInputData["tell_3"] == "" ){
			$arrErr["ath_comment"] = "";
			$arrErr["ath_comment"] .= "�����ֹ�����������Ϥ��Ʋ�������";
			$arrErr["ath_comment"] .= $strInputHidden;
			$arrErr["ath_comment"] .= "<INPUT type=\"hidden\" name=\"form_flg\" value=\"\">\n";
			$obj_error->ViewErrMessage( "INPUT_CHECK_ERROR" , "USER" , _BLOG_SITE_URL_BASE."applicate/" , $arrErr );
			exit;
		}
		$strBuffTell = $arrInputData["tell_1"]."-".$arrInputData["tell_2"]."-".$arrInputData["tell_3"];
//		$ret = $obj_check->check_tell_2( $strBuffTell );
//		IF( $ret === FALSE ){
//			$arrErr["ath_comment"] = "";
//			$arrErr["ath_comment"] .= "�����ֹ�����������Ϥ��Ʋ�������<br />�����ֹ��Ⱦ�ѿ����Τߤ����Ϥ��Ʋ�������";
//			$arrErr["ath_comment"] .= $strInputHidden;
//			$arrErr["ath_comment"] .= "<INPUT type=\"hidden\" name=\"form_flg\" value=\"\">\n";
//			$obj_error->ViewErrMessage( "INPUT_CHECK_ERROR" , "USER" , _BLOG_SITE_URL_BASE."applicate/" , $arrErr );
//			exit;
//		}
		IF( $arrInputData["tell_time"] == "" ){
			$arrErr["ath_comment"] = "";
			$arrErr["ath_comment"] .= "����Ϣ��Τ���˾�����Ӥ����Ϥ��Ʋ�������";
			$arrErr["ath_comment"] .= $strInputHidden;
			$arrErr["ath_comment"] .= "<INPUT type=\"hidden\" name=\"form_flg\" value=\"\">\n";
			$obj_error->ViewErrMessage( "INPUT_CHECK_ERROR" , "USER" , _BLOG_SITE_URL_BASE."applicate/" , $arrErr );
			exit;
		}ELSE{
			$ret = $obj_check->check_only_space( $arrInputData["tell_time"] );
			IF( $ret === true ){
				$arrErr["ath_comment"] = "";
				$arrErr["ath_comment"] .= "����Ϣ��Τ���˾�����Ӥϡ����ڡ����Τߤ����ϤϤǤ��ޤ���";
				$arrErr["ath_comment"] .= $strInputHidden;
				$arrErr["ath_comment"] .= "<INPUT type=\"hidden\" name=\"form_flg\" value=\"\">\n";
				$obj_error->ViewErrMessage( "INPUT_CHECK_ERROR" , "USER" , _BLOG_SITE_URL_BASE."applicate/" , $arrErr );
				exit;
			}
		}
	}
	
	// FAXϢ��OK
	IF( $arrInputData["report_type_2"] == 2 ){
		IF( $arrInputData["fax_1"] == "" || $arrInputData["fax_2"] == "" || $arrInputData["fax_3"] == "" ){
			$arrErr["ath_comment"] = "";
			$arrErr["ath_comment"] .= "FAX�ֹ�����������Ϥ��Ʋ�������";
			$arrErr["ath_comment"] .= $strInputHidden;
			$arrErr["ath_comment"] .= "<INPUT type=\"hidden\" name=\"form_flg\" value=\"\">\n";
			$obj_error->ViewErrMessage( "INPUT_CHECK_ERROR" , "USER" , _BLOG_SITE_URL_BASE."applicate/" , $arrErr );
			exit;
		}
		$strBuffFax = $arrInputData["fax_1"]."-".$arrInputData["fax_2"]."-".$arrInputData["fax_3"];
//		$ret = $obj_check->check_tell_2( $strBuffFax );
//		IF( $ret === FALSE ){
//			$arrErr["ath_comment"] = "";
//			$arrErr["ath_comment"] .= "FAX�ֹ�����������Ϥ��Ʋ�������<br />FAX�ֹ��Ⱦ�ѿ����Τߤ����Ϥ��Ʋ�������";
//			$arrErr["ath_comment"] .= $strInputHidden;
//			$arrErr["ath_comment"] .= "<INPUT type=\"hidden\" name=\"form_flg\" value=\"\">\n";
//			$obj_error->ViewErrMessage( "INPUT_CHECK_ERROR" , "USER" , _BLOG_SITE_URL_BASE."applicate/" , $arrErr );
//			exit;
//		}
	}
	
	// ͹��Ϣ��OK
	IF( $arrInputData["report_type_3"] == 3 ){
		// ͹���ֹ�����å�
		IF( $arrInputData["addr_cd_1"] == "" || $arrInputData["addr_cd_2"] == "" ){
			$arrErr["ath_comment"] = "";
			$arrErr["ath_comment"] .= "͹���ֹ�����Ϥ��Ʋ�������";
			$arrErr["ath_comment"] .= $strInputHidden;
			$arrErr["ath_comment"] .= "<INPUT type=\"hidden\" name=\"form_flg\" value=\"\">\n";
			$obj_error->ViewErrMessage( "INPUT_CHECK_ERROR" , "USER" , _BLOG_SITE_URL_BASE."applicate/" , $arrErr );
			exit;
		}
		$strBuffAddrCd = $arrInputData["addr_cd_1"]."-".$arrInputData["addr_cd_2"];
		$ret = $obj_check->check_address_code( $strBuffAddrCd );
		IF( $ret === FALSE ){
			$arrErr["ath_comment"] = "";
			$arrErr["ath_comment"] .= "͹���ֹ�����������Ϥ��Ʋ�������<br />͹���ֹ��Ⱦ�ѿ����Τߤ����Ϥ��Ʋ�������";
			$arrErr["ath_comment"] .= $strInputHidden;
			$arrErr["ath_comment"] .= "<INPUT type=\"hidden\" name=\"form_flg\" value=\"\">\n";
			$obj_error->ViewErrMessage( "INPUT_CHECK_ERROR" , "USER" , _BLOG_SITE_URL_BASE."applicate/" , $arrErr );
			exit;
		}
		
		// ��������å�
		IF( $arrInputData["address_1"] == "" ){
			$arrErr["ath_comment"] = "";
			$arrErr["ath_comment"] .= "���꣱����Τ褦�����Ϥ��Ʋ�������";
			$arrErr["ath_comment"] .= $strInputHidden;
			$arrErr["ath_comment"] .= "<INPUT type=\"hidden\" name=\"form_flg\" value=\"\">\n";
			$obj_error->ViewErrMessage( "INPUT_CHECK_ERROR" , "USER" , _BLOG_SITE_URL_BASE."applicate/" , $arrErr );
			exit;
		}ELSE{
			$ret = $obj_check->check_only_space( $arrInputData["address_1"] );
			IF( $ret === TRUE ){
				$arrErr["ath_comment"] = "";
				$arrErr["ath_comment"] .= "���꣱�϶���Τߤ����ϤϤǤ��ޤ���";
				$arrErr["ath_comment"] .= $strInputHidden;
				$arrErr["ath_comment"] .= "<INPUT type=\"hidden\" name=\"form_flg\" value=\"\">\n";
				$obj_error->ViewErrMessage( "INPUT_CHECK_ERROR" , "USER" , _BLOG_SITE_URL_BASE."applicate/" , $arrErr );
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
				$obj_error->ViewErrMessage( "INPUT_CHECK_ERROR" , "USER" , _BLOG_SITE_URL_BASE."applicate/" , $arrErr );
				exit;
			}
		}
	}
	
	// E�᡼��Ϣ��OK
	IF( $arrInputData["report_type_4"] == 4 ){
		IF( $arrInputData["email"] == "" ){
			$arrErr["ath_comment"] = "";
			$arrErr["ath_comment"] .= "�ť᡼�륢�ɥ쥹�����Ϥ��Ʋ�������";
			$arrErr["ath_comment"] .= $strInputHidden;
			$arrErr["ath_comment"] .= "<INPUT type=\"hidden\" name=\"form_flg\" value=\"\">\n";
			$obj_error->ViewErrMessage( "INPUT_CHECK_ERROR" , "USER" , _BLOG_SITE_URL_BASE."applicate/" , $arrErr );
			exit;
		}
		$ret = $obj_check->check_email( $arrInputData["email"] );
		IF( $ret === FALSE ){
			$arrErr["ath_comment"] = "";
			$arrErr["ath_comment"] .= "�ť᡼�륢�ɥ쥹�����������Ϥ��Ʋ�������";
			$arrErr["ath_comment"] .= $strInputHidden;
			$arrErr["ath_comment"] .= "<INPUT type=\"hidden\" name=\"form_flg\" value=\"\">\n";
			$obj_error->ViewErrMessage( "INPUT_CHECK_ERROR" , "USER" , _BLOG_SITE_URL_BASE."applicate/" , $arrErr );
			exit;
		}
	}
	
}

?>
