<?php
/*=========================================================
    ����礻 - �������ƥ����å�
=========================================================*/

// �����å����饹 - ���󥹥���
require_once( SYS_PATH."common/input_check.class.php" );
$obj_check = new input_check();

// �᡼������å�
IF( $arrInputData["email"] == "" ){
	$arrErr["ath_comment"] = "";
	$arrErr["ath_comment"] .= "�᡼�륢�ɥ쥹�����Ϥ��Ʋ�������";
	$arrErr["ath_comment"] .= $strInputHidden;
	$arrErr["ath_comment"] .= "<INPUT type=\"hidden\" name=\"form_flg\" value=\"\">\n";
	$obj_error->ViewErrMessage( "INPUT_CHECK_ERROR" , "PORTAL-USER" , _BLOG_SITE_URL_BASE."inquiry/" , $arrErr );
	exit;
}
$ret = $obj_check->check_email( $arrInputData["email"] );
IF( $ret === FALSE ){
	$arrErr["ath_comment"] = "";
	$arrErr["ath_comment"] .= "�᡼�륢�ɥ쥹�����������Ϥ��Ʋ�������";
	$arrErr["ath_comment"] .= $strInputHidden;
	$arrErr["ath_comment"] .= "<INPUT type=\"hidden\" name=\"form_flg\" value=\"\">\n";
	$obj_error->ViewErrMessage( "INPUT_CHECK_ERROR" , "PORTAL-USER" , _BLOG_SITE_URL_BASE."inquiry/" , $arrErr );
	exit;
}

// ��̾
IF( $arrInputData["subject"] == "" ){
	$arrErr["ath_comment"] = "";
	$arrErr["ath_comment"] .= "��̾�����Ϥ��Ʋ�������";
	$arrErr["ath_comment"] .= $strInputHidden;
	$arrErr["ath_comment"] .= "<INPUT type=\"hidden\" name=\"form_flg\" value=\"\">\n";
	$obj_error->ViewErrMessage( "INPUT_CHECK_ERROR" , "PORTAL-USER" , _BLOG_SITE_URL_BASE."inquiry/" , $arrErr );
	exit;
}ELSE{
	// ��������å�
	$ret = $obj_check->check_only_space( $arrInputData["subject"] );
	IF( $ret === true ){
		$arrErr["ath_comment"] = "";
		$arrErr["ath_comment"] .= "��̾�϶���Τߤ����ϤϽ���ޤ���";
		$arrErr["ath_comment"] .= $strInputHidden;
		$arrErr["ath_comment"] .= "<INPUT type=\"hidden\" name=\"form_flg\" value=\"\">\n";
		$obj_error->ViewErrMessage( "INPUT_CHECK_ERROR" , "PORTAL-USER" , _BLOG_SITE_URL_BASE."inquiry/" , $arrErr );
		exit;
	}
}

/*
// ����礻����
IF( $arrInputData["contents"] == "" ){
	$arrErr["ath_comment"] = "";
	$arrErr["ath_comment"] .= "���䤤��碌���Ƥ����Ϥ��Ʋ�������";
	$arrErr["ath_comment"] .= $strInputHidden;
	$arrErr["ath_comment"] .= "<INPUT type=\"hidden\" name=\"form_flg\" value=\"\">\n";
	$obj_error->ViewErrMessage( "INPUT_CHECK_ERROR" , "PORTAL-USER" , _BLOG_SITE_URL_BASE."inquiry/" , $arrErr );
	exit;
}ELSE{
	// ��������å�
	$ret = $obj_check->check_only_space( $arrInputData["contents"] );
	IF( $ret === true ){
		$arrErr["ath_comment"] = "";
		$arrErr["ath_comment"] .= "���䤤��碌���Ƥ϶���Τߤ����ϤϽ���ޤ���";
		$arrErr["ath_comment"] .= $strInputHidden;
		$arrErr["ath_comment"] .= "<INPUT type=\"hidden\" name=\"form_flg\" value=\"\">\n";
		$obj_error->ViewErrMessage( "INPUT_CHECK_ERROR" , "PORTAL-USER" , _BLOG_SITE_URL_BASE."inquiry/" , $arrErr );
		exit;
	}
}
*/
?>