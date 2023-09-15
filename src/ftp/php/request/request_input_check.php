<?php
/*=========================================================
    ʪ��ꥯ������ - �������ƥ����å�
=========================================================*/
// POST�ͤ��Ǽ
$arrInputValue = Array();
$strInputHidden = "";
FOREACH( $_POST as $key => $val ){
	if($key != "madori"){
		$arrInputValue[$key] = htmlspecialchars( stripslashes( $val ) );
		$strInputHidden .= "<INPUT type=\"hidden\" name=\"{$key}\" value=\"{$arrInputValue[$key]}\" />\n";
	}
}
if(count($_POST['madori'])!=0){
	FOREACH( $_POST['madori'] as $key => $val ){
		$arrInputValue['madori'][$key] = htmlspecialchars( stripslashes( $val ) );
		$strInputHidden .= "<INPUT type=\"hidden\" name=\"madori[{$key}]\" value=\"{$arrInputValue['madori'][$key]}\" />\n";
	}
}

$arrRequestValue["otherEquip"] = str_replace("<BR>","\r\n",$arrRequestValue["otherEquip"]);


// �����å����饹 - ���󥹥���
require_once( SYS_PATH."common/input_check.class.php" );
$obj_check = new input_check();


// ��̾(����)
IF( $arrRequestValue["name_kj_1"] == "" || $arrRequestValue["name_kj_2"] == "" ){
	$arrErr["ath_comment"] = "";
	$arrErr["ath_comment"] .= "��̾(����)�����Ϥ��Ʋ�������";
	$arrErr["ath_comment"] .= $strInputHidden;
	$arrErr["ath_comment"] .= "<INPUT type=\"hidden\" name=\"form_flg\" value=\"\">\n";
	$obj_error->ViewErrMessage( "INPUT_CHECK_ERROR" , "USER" , _BLOG_SITE_URL_BASE."request.php" , $arrErr );
	exit;
}ELSE{
	// ��������å�
	$ret_1 = $obj_check->check_only_space( $arrRequestValue["name_kj_1"] );
	$ret_2 = $obj_check->check_only_space( $arrRequestValue["name_kj_2"] );
	IF( $ret_1 === true || $ret_2 === true ){
		$arrErr["ath_comment"] = "";
		$arrErr["ath_comment"] .= "��̾(����)�϶���Τߤ����ϤϽ���ޤ���";
		$arrErr["ath_comment"] .= $strInputHidden;
		$arrErr["ath_comment"] .= "<INPUT type=\"hidden\" name=\"form_flg\" value=\"\">\n";
		$obj_error->ViewErrMessage( "INPUT_CHECK_ERROR" , "USER" , _BLOG_SITE_URL_BASE."request.php" , $arrErr );
		exit;
	}
}


// ��̾(�եꥬ��)
IF( $arrRequestValue["name_kn_1"] != "" || $arrRequestValue["name_kn_2"] != "" ){
	IF( $arrRequestValue["name_kn_1"] == "" || $arrRequestValue["name_kn_2"] == "" ){
		$arrErr["ath_comment"] = "";
		$arrErr["ath_comment"] .= "��̾(�եꥬ��)���������Ƥ��ǧ���Ʋ�������";
		$arrErr["ath_comment"] .= $strInputHidden;
		$arrErr["ath_comment"] .= "<INPUT type=\"hidden\" name=\"form_flg\" value=\"\">\n";
		$obj_error->ViewErrMessage( "INPUT_CHECK_ERROR" , "USER" , _BLOG_SITE_URL_BASE."request.php" , $arrErr );
		exit;
	}ELSE{
		// ��������å�
		$ret_1 = $obj_check->check_only_space( $arrRequestValue["name_kn_1"] );
		$ret_2 = $obj_check->check_only_space( $arrRequestValue["name_kn_2"] );
		IF( $ret_1 === TRUE || $ret_2 === TRUE ){
			$arrErr["ath_comment"] = "";
			$arrErr["ath_comment"] .= "��̾(�եꥬ��)�϶���Τߤ����ϤϽ���ޤ���";
			$arrErr["ath_comment"] .= $strInputHidden;
			$arrErr["ath_comment"] .= "<INPUT type=\"hidden\" name=\"form_flg\" value=\"\">\n";
			$obj_error->ViewErrMessage( "INPUT_CHECK_ERROR" , "USER" , _BLOG_SITE_URL_BASE."request.php" , $arrErr );
			exit;
		}
		// ���ѥ������ʥ����å�
		$ret_1 = $obj_check->check_katakana( $arrRequestValue["name_kn_1"] );
		$ret_2 = $obj_check->check_katakana( $arrRequestValue["name_kn_2"] );
		IF( $ret_1 === TRUE || $ret_2 === TRUE ){
			$arrErr["ath_comment"] = "";
			$arrErr["ath_comment"] .= "��̾(�եꥬ��)�����ѥ������ʤ����Ϥ��Ʋ�������";
			$arrErr["ath_comment"] .= $strInputHidden;
			$arrErr["ath_comment"] .= "<INPUT type=\"hidden\" name=\"form_flg\" value=\"\">\n";
			$obj_error->ViewErrMessage( "INPUT_CHECK_ERROR" , "USER" , _BLOG_SITE_URL_BASE."request.php" , $arrErr );
			exit;
		}
	}
}


// ���� - �����å����ʤ�


// ǯ��
IF( $arrRequestValue["old"] != "" ){
	$ret = $obj_check->check_only_hanint( $arrRequestValue["old"] );
	IF( $ret === FALSE ){
		$arrErr["ath_comment"] = "";
		$arrErr["ath_comment"] .= "ǯ���Ⱦ�ѿ����Τߤ����Ϥ��Ʋ�������";
		$arrErr["ath_comment"] .= $strInputHidden;
		$arrErr["ath_comment"] .= "<INPUT type=\"hidden\" name=\"form_flg\" value=\"\">\n";
		$obj_error->ViewErrMessage( "INPUT_CHECK_ERROR" , "USER" , _BLOG_SITE_URL_BASE."request.php" , $arrErr );
		exit;
	}
}


// ���� - �����å����ʤ�


// Ϣ����ˡ
IF( $arrRequestValue["report_type_1"] != 1 && $arrRequestValue["report_type_2"] != 2 && $arrRequestValue["report_type_3"] != 3 && $arrRequestValue["report_type_4"] != 4 ){
	$arrErr["ath_comment"] = "";
	$arrErr["ath_comment"] .= "Ϣ����ˡ��ҤȤİʾ����򤷤Ʋ�������";
	$arrErr["ath_comment"] .= $strInputHidden;
	$arrErr["ath_comment"] .= "<INPUT type=\"hidden\" name=\"form_flg\" value=\"\">\n";
	$obj_error->ViewErrMessage( "INPUT_CHECK_ERROR" , "USER" , _BLOG_SITE_URL_BASE."request.php" , $arrErr );
	exit;
}ELSE{
	// ����Ϣ��OK
	IF( $arrRequestValue["report_type_1"] == 1 ){
		IF( $arrRequestValue["tell_1"] == "" || $arrRequestValue["tell_2"] == "" || $arrRequestValue["tell_3"] == "" ){
			$arrErr["ath_comment"] = "";
			$arrErr["ath_comment"] .= "�����ֹ�����������Ϥ��Ʋ�������";
			$arrErr["ath_comment"] .= $strInputHidden;
			$arrErr["ath_comment"] .= "<INPUT type=\"hidden\" name=\"form_flg\" value=\"\">\n";
			$obj_error->ViewErrMessage( "INPUT_CHECK_ERROR" , "USER" , _BLOG_SITE_URL_BASE."request.php" , $arrErr );
			exit;
		}
//		$strBuffTell = $arrRequestValue["tell_1"]."-".$arrRequestValue["tell_2"]."-".$arrRequestValue["tell_3"];
//		$ret = $obj_check->check_tell_2( $strBuffTell );
//		IF( $ret === FALSE ){
//			$arrErr["ath_comment"] = "";
//			$arrErr["ath_comment"] .= "�����ֹ�����������Ϥ��Ʋ�������<br />�����ֹ��Ⱦ�ѿ����Τߤ����Ϥ��Ʋ�������";
//			$arrErr["ath_comment"] .= $strInputHidden;
//			$arrErr["ath_comment"] .= "<INPUT type=\"hidden\" name=\"form_flg\" value=\"\">\n";
//			$obj_error->ViewErrMessage( "INPUT_CHECK_ERROR" , "USER" , _BLOG_SITE_URL_BASE."request.php" , $arrErr );
//			exit;
//		}
		IF( $arrRequestValue["tell_time"] == "" ){
			$arrErr["ath_comment"] = "";
			$arrErr["ath_comment"] .= "����Ϣ��Τ���˾�����Ӥ����Ϥ��Ʋ�������";
			$arrErr["ath_comment"] .= $strInputHidden;
			$arrErr["ath_comment"] .= "<INPUT type=\"hidden\" name=\"form_flg\" value=\"\">\n";
			$obj_error->ViewErrMessage( "INPUT_CHECK_ERROR" , "USER" , _BLOG_SITE_URL_BASE."request.php" , $arrErr );
			exit;
		}ELSE{
			$ret = $obj_check->check_only_space( $arrRequestValue["tell_time"] );
			IF( $ret === true ){
				$arrErr["ath_comment"] = "";
				$arrErr["ath_comment"] .= "����Ϣ��Τ���˾�����Ӥϡ����ڡ����Τߤ����ϤϤǤ��ޤ���";
				$arrErr["ath_comment"] .= $strInputHidden;
				$arrErr["ath_comment"] .= "<INPUT type=\"hidden\" name=\"form_flg\" value=\"\">\n";
				$obj_error->ViewErrMessage( "INPUT_CHECK_ERROR" , "USER" , _BLOG_SITE_URL_BASE."request.php" , $arrErr );
				exit;
			}
		}
	}
	
	// FAXϢ��OK
	IF( $arrRequestValue["report_type_2"] == 2 ){
		IF( $arrRequestValue["fax_1"] == "" || $arrRequestValue["fax_2"] == "" || $arrRequestValue["fax_3"] == "" ){
			$arrErr["ath_comment"] = "";
			$arrErr["ath_comment"] .= "FAX�ֹ�����������Ϥ��Ʋ�������";
			$arrErr["ath_comment"] .= $strInputHidden;
			$arrErr["ath_comment"] .= "<INPUT type=\"hidden\" name=\"form_flg\" value=\"\">\n";
			$obj_error->ViewErrMessage( "INPUT_CHECK_ERROR" , "USER" , _BLOG_SITE_URL_BASE."request.php" , $arrErr );
			exit;
		}
//		$strBuffFax = $arrRequestValue["fax_1"]."-".$arrRequestValue["fax_2"]."-".$arrRequestValue["fax_3"];
//		$ret = $obj_check->check_tell_2( $strBuffFax );
//		IF( $ret === FALSE ){
//			$arrErr["ath_comment"] = "";
//			$arrErr["ath_comment"] .= "FAX�ֹ�����������Ϥ��Ʋ�������<br />FAX�ֹ��Ⱦ�ѿ����Τߤ����Ϥ��Ʋ�������";
//			$arrErr["ath_comment"] .= $strInputHidden;
//			$arrErr["ath_comment"] .= "<INPUT type=\"hidden\" name=\"form_flg\" value=\"\">\n";
//			$obj_error->ViewErrMessage( "INPUT_CHECK_ERROR" , "USER" , _BLOG_SITE_URL_BASE."request.php" , $arrErr );
//			exit;
//		}
	}
	
	// ͹��Ϣ��OK
	IF( $arrRequestValue["report_type_3"] == 3 ){
		// ͹���ֹ�����å�
		IF( $arrRequestValue["addr_cd_1"] == "" || $arrRequestValue["addr_cd_2"] == "" ){
			$arrErr["ath_comment"] = "";
			$arrErr["ath_comment"] .= "͹���ֹ�����Ϥ��Ʋ�������";
			$arrErr["ath_comment"] .= $strInputHidden;
			$arrErr["ath_comment"] .= "<INPUT type=\"hidden\" name=\"form_flg\" value=\"\">\n";
			$obj_error->ViewErrMessage( "INPUT_CHECK_ERROR" , "USER" , _BLOG_SITE_URL_BASE."request.php" , $arrErr );
			exit;
		}
		$strBuffAddrCd = $arrRequestValue["addr_cd_1"]."-".$arrRequestValue["addr_cd_2"];
		$ret = $obj_check->check_address_code( $strBuffAddrCd );
		IF( $ret === FALSE ){
			$arrErr["ath_comment"] = "";
			$arrErr["ath_comment"] .= "͹���ֹ�����������Ϥ��Ʋ�������<br />͹���ֹ��Ⱦ�ѿ����Τߤ����Ϥ��Ʋ�������";
			$arrErr["ath_comment"] .= $strInputHidden;
			$arrErr["ath_comment"] .= "<INPUT type=\"hidden\" name=\"form_flg\" value=\"\">\n";
			$obj_error->ViewErrMessage( "INPUT_CHECK_ERROR" , "USER" , _BLOG_SITE_URL_BASE."request.php" , $arrErr );
			exit;
		}
		
		// ��������å�
		IF( $arrRequestValue["address_1"] == "" ){
			$arrErr["ath_comment"] = "";
			$arrErr["ath_comment"] .= "���꣱����Τ褦�����Ϥ��Ʋ�������";
			$arrErr["ath_comment"] .= $strInputHidden;
			$arrErr["ath_comment"] .= "<INPUT type=\"hidden\" name=\"form_flg\" value=\"\">\n";
			$obj_error->ViewErrMessage( "INPUT_CHECK_ERROR" , "USER" , _BLOG_SITE_URL_BASE."request.php" , $arrErr );
			exit;
		}ELSE{
			$ret = $obj_check->check_only_space( $arrRequestValue["address_1"] );
			IF( $ret === TRUE ){
				$arrErr["ath_comment"] = "";
				$arrErr["ath_comment"] .= "���꣱�϶���Τߤ����ϤϤǤ��ޤ���";
				$arrErr["ath_comment"] .= $strInputHidden;
				$arrErr["ath_comment"] .= "<INPUT type=\"hidden\" name=\"form_flg\" value=\"\">\n";
				$obj_error->ViewErrMessage( "INPUT_CHECK_ERROR" , "USER" , _BLOG_SITE_URL_BASE."request.php" , $arrErr );
				exit;
			}
		}
		IF( $arrRequestValue["address_2"] != "" ){
			$ret = $obj_check->check_only_space( $arrRequestValue["address_2"] );
			IF( $ret === TRUE ){
				$arrErr["ath_comment"] = "";
				$arrErr["ath_comment"] .= "���ꣲ�϶���Τߤ����ϤϤǤ��ޤ���";
				$arrErr["ath_comment"] .= $strInputHidden;
				$arrErr["ath_comment"] .= "<INPUT type=\"hidden\" name=\"form_flg\" value=\"\">\n";
				$obj_error->ViewErrMessage( "INPUT_CHECK_ERROR" , "USER" , _BLOG_SITE_URL_BASE."request.php" , $arrErr );
				exit;
			}
		}
	}
	
	// E�᡼��Ϣ��OK
	IF( $arrRequestValue["report_type_4"] == 4 ){
		IF( $arrRequestValue["email"] == "" ){
			$arrErr["ath_comment"] = "";
			$arrErr["ath_comment"] .= "�ť᡼�륢�ɥ쥹�����Ϥ��Ʋ�������";
			$arrErr["ath_comment"] .= $strInputHidden;
			$arrErr["ath_comment"] .= "<INPUT type=\"hidden\" name=\"form_flg\" value=\"\">\n";
			$obj_error->ViewErrMessage( "INPUT_CHECK_ERROR" , "USER" , _BLOG_SITE_URL_BASE."request.php" , $arrErr );
			exit;
		}
		$ret = $obj_check->check_email( $arrRequestValue["email"] );
		IF( $ret === FALSE ){
			$arrErr["ath_comment"] = "";
			$arrErr["ath_comment"] .= "�ť᡼�륢�ɥ쥹�����������Ϥ��Ʋ�������";
			$arrErr["ath_comment"] .= $strInputHidden;
			$arrErr["ath_comment"] .= "<INPUT type=\"hidden\" name=\"form_flg\" value=\"\">\n";
			$obj_error->ViewErrMessage( "INPUT_CHECK_ERROR" , "USER" , _BLOG_SITE_URL_BASE."request.php" , $arrErr );
			exit;
		}
	}
	
}

// ��̳�莥�̳���κǴ��
// ��������å�
$ret_1 = $obj_check->check_only_space( $arrRequestValue["station"] );
$ret_2 = $obj_check->check_only_space( $arrRequestValue["station"] );
IF( $ret_1 === true || $ret_2 === true ){
	$arrErr["ath_comment"] = "";
	$arrErr["ath_comment"] .= "��̳�莥�̳���κǴ�ؤ϶���Τߤ����ϤϽ���ޤ���";
	$arrErr["ath_comment"] .= $strInputHidden;
	$arrErr["ath_comment"] .= "<INPUT type=\"hidden\" name=\"form_flg\" value=\"\">\n";
	$obj_error->ViewErrMessage( "INPUT_CHECK_ERROR" , "USER" , _BLOG_SITE_URL_BASE."request.php" , $arrErr );
	exit;
}

// ��̳�莥�̳���ޤǤδ�˾���׻���
// ��������å�
$ret_1 = $obj_check->check_only_space( $arrRequestValue["move"] );
IF( $ret_1 === true ){
	$arrErr["ath_comment"] = "";
	$arrErr["ath_comment"] .= "��̳�莥�̳���ޤǤδ�˾���׻��֤϶���Τߤ����ϤϽ���ޤ���";
	$arrErr["ath_comment"] .= $strInputHidden;
	$arrErr["ath_comment"] .= "<INPUT type=\"hidden\" name=\"form_flg\" value=\"\">\n";
	$obj_error->ViewErrMessage( "INPUT_CHECK_ERROR" , "USER" , _BLOG_SITE_URL_BASE."request.php" , $arrErr );
	exit;
}

// ��˾�α�������
// ��������å�
$ret_1 = $obj_check->check_only_space( $arrRequestValue["line"] );
IF( $ret_1 === true��){
	$arrErr["ath_comment"] = "";
	$arrErr["ath_comment"] .= "��˾�α������ؤ϶���Τߤ����ϤϽ���ޤ���";
	$arrErr["ath_comment"] .= $strInputHidden;
	$arrErr["ath_comment"] .= "<INPUT type=\"hidden\" name=\"form_flg\" value=\"\">\n";
	$obj_error->ViewErrMessage( "INPUT_CHECK_ERROR" , "USER" , _BLOG_SITE_URL_BASE."request.php" , $arrErr );
	exit;
}

// ��˾�Υ��ꥢ
// ��������å�
$ret_1 = $obj_check->check_only_space( $arrRequestValue["area"] );
IF( $ret_1 === true ){
	$arrErr["ath_comment"] = "";
	$arrErr["ath_comment"] .= "��˾�Υ��ꥢ�϶���Τߤ����ϤϽ���ޤ���";
	$arrErr["ath_comment"] .= $strInputHidden;
	$arrErr["ath_comment"] .= "<INPUT type=\"hidden\" name=\"form_flg\" value=\"\">\n";
	$obj_error->ViewErrMessage( "INPUT_CHECK_ERROR" , "USER" , _BLOG_SITE_URL_BASE."request.php" , $arrErr );
	exit;
}

// ��˾�β���1
// Ⱦ�ѿ��������å�
IF($arrRequestValue["price1"] != ""){
	$ret = $obj_check->check_only_hanint( $arrRequestValue["price1"] );
	IF( $ret === FALSE ){
		$arrErr["ath_comment"] = "";
		$arrErr["ath_comment"] .= "��˾�β��¤�Ⱦ�ѿ����Τߤ����Ϥ��Ʋ�������";
		$arrErr["ath_comment"] .= $strInputHidden;
		$arrErr["ath_comment"] .= "<INPUT type=\"hidden\" name=\"form_flg\" value=\"\">\n";
		$obj_error->ViewErrMessage( "INPUT_CHECK_ERROR" , "USER" , _BLOG_SITE_URL_BASE."request.php" , $arrErr );
		exit;
	}
}

// ��˾�β���2
// Ⱦ�ѿ��������å�
IF($arrRequestValue["price1"] != ""){
	$ret = $obj_check->check_only_hanint( $arrRequestValue["price2"] );
	IF( $ret === FALSE ){
		$arrErr["ath_comment"] = "";
		$arrErr["ath_comment"] .= "��˾�β��¤�Ⱦ�ѿ����Τߤ����Ϥ��Ʋ�������";
		$arrErr["ath_comment"] .= $strInputHidden;
		$arrErr["ath_comment"] .= "<INPUT type=\"hidden\" name=\"form_flg\" value=\"\">\n";
		$obj_error->ViewErrMessage( "INPUT_CHECK_ERROR" , "USER" , _BLOG_SITE_URL_BASE."request.php" , $arrErr );
		exit;
	}
}

// �Ż뤷�Ƥ����1
// ��������å�
$ret_1 = $obj_check->check_only_space( $arrRequestValue["equip1"] );
IF( $ret_1 === true ){
	$arrErr["ath_comment"] = "";
	$arrErr["ath_comment"] .= "�Ż뤷�Ƥ�����϶���Τߤ����ϤϽ���ޤ���";
	$arrErr["ath_comment"] .= $strInputHidden;
	$arrErr["ath_comment"] .= "<INPUT type=\"hidden\" name=\"form_flg\" value=\"\">\n";
	$obj_error->ViewErrMessage( "INPUT_CHECK_ERROR" , "USER" , _BLOG_SITE_URL_BASE."request.php" , $arrErr );
	exit;
}

// �Ż뤷�Ƥ����2
// ��������å�
$ret_1 = $obj_check->check_only_space( $arrRequestValue["equip2"] );
IF( $ret_1 === true ){
	$arrErr["ath_comment"] = "";
	$arrErr["ath_comment"] .= "�Ż뤷�Ƥ�����϶���Τߤ����ϤϽ���ޤ���";
	$arrErr["ath_comment"] .= $strInputHidden;
	$arrErr["ath_comment"] .= "<INPUT type=\"hidden\" name=\"form_flg\" value=\"\">\n";
	$obj_error->ViewErrMessage( "INPUT_CHECK_ERROR" , "USER" , _BLOG_SITE_URL_BASE."request.php" , $arrErr );
	exit;
}

// �Ż뤷�Ƥ����3
// ��������å�
$ret_1 = $obj_check->check_only_space( $arrRequestValue["equip3"] );
IF( $ret_1 === true ){
	$arrErr["ath_comment"] = "";
	$arrErr["ath_comment"] .= "�Ż뤷�Ƥ�����϶���Τߤ����ϤϽ���ޤ���";
	$arrErr["ath_comment"] .= $strInputHidden;
	$arrErr["ath_comment"] .= "<INPUT type=\"hidden\" name=\"form_flg\" value=\"\">\n";
	$obj_error->ViewErrMessage( "INPUT_CHECK_ERROR" , "USER" , _BLOG_SITE_URL_BASE."request.php" , $arrErr );
	exit;
}

// �Ż뤷�Ƥ����4
// ��������å�
$ret_1 = $obj_check->check_only_space( $arrRequestValue["equip4"] );
IF( $ret_1 === true ){
	$arrErr["ath_comment"] = "";
	$arrErr["ath_comment"] .= "�Ż뤷�Ƥ�����϶���Τߤ����ϤϽ���ޤ���";
	$arrErr["ath_comment"] .= $strInputHidden;
	$arrErr["ath_comment"] .= "<INPUT type=\"hidden\" name=\"form_flg\" value=\"\">\n";
	$obj_error->ViewErrMessage( "INPUT_CHECK_ERROR" , "USER" , _BLOG_SITE_URL_BASE."request.php" , $arrErr );
	exit;
}

// �Ż뤷�Ƥ����5
// ��������å�
$ret_1 = $obj_check->check_only_space( $arrRequestValue["equip5"] );
IF( $ret_1 === true ){
	$arrErr["ath_comment"] = "";
	$arrErr["ath_comment"] .= "�Ż뤷�Ƥ�����϶���Τߤ����ϤϽ���ޤ���";
	$arrErr["ath_comment"] .= $strInputHidden;
	$arrErr["ath_comment"] .= "<INPUT type=\"hidden\" name=\"form_flg\" value=\"\">\n";
	$obj_error->ViewErrMessage( "INPUT_CHECK_ERROR" , "USER" , _BLOG_SITE_URL_BASE."request.php" , $arrErr );
	exit;
}

// ����¾�������
// ��������å�
$ret_1 = $obj_check->check_only_space( $arrRequestValue["otherEquip"] );
IF( $ret_1 === true ){
	$arrErr["ath_comment"] = "";
	$arrErr["ath_comment"] .= "����¾�������϶���Τߤ����ϤϽ���ޤ���";
	$arrErr["ath_comment"] .= $strInputHidden;
	$arrErr["ath_comment"] .= "<INPUT type=\"hidden\" name=\"form_flg\" value=\"\">\n";
	$obj_error->ViewErrMessage( "INPUT_CHECK_ERROR" , "USER" , _BLOG_SITE_URL_BASE."request.php" , $arrErr );
	exit;
}

// ����ͽ�����
// ��������å�
$ret_1 = $obj_check->check_only_space( $arrRequestValue["moveTime"] );
IF( $ret_1 === true ){
	$arrErr["ath_comment"] = "";
	$arrErr["ath_comment"] .= "����ͽ������϶���Τߤ����ϤϽ���ޤ���";
	$arrErr["ath_comment"] .= $strInputHidden;
	$arrErr["ath_comment"] .= "<INPUT type=\"hidden\" name=\"form_flg\" value=\"\">\n";
	$obj_error->ViewErrMessage( "INPUT_CHECK_ERROR" , "USER" , _BLOG_SITE_URL_BASE."request.php" , $arrErr );
	exit;
}

// ���ߤβ���
// Ⱦ�ѿ��������å�
IF($arrRequestValue["nowPrice"] != ""){
	$ret = $obj_check->check_only_hanint( $arrRequestValue["nowPrice"] );
	IF( $ret === FALSE ){
		$arrErr["ath_comment"] = "";
		$arrErr["ath_comment"] .= "���ߤβ��¤�Ⱦ�ѿ����Τߤ����Ϥ��Ʋ�������";
		$arrErr["ath_comment"] .= $strInputHidden;
		$arrErr["ath_comment"] .= "<INPUT type=\"hidden\" name=\"form_flg\" value=\"\">\n";
		$obj_error->ViewErrMessage( "INPUT_CHECK_ERROR" , "USER" , _BLOG_SITE_URL_BASE."request.php" , $arrErr );
		exit;
	}
}

?>
