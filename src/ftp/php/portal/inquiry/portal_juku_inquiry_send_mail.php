<?php
/*=================================================================
    ����礻�᡼����������
=================================================================*/

require_once( SYS_PATH."common/common_mail.php" );


// �᡼�륿���ȥ� ������
$strBuffMailTitle_admin = "";
$strBuffMailTitle_admin = "�Υ�����ڴ����礻��".$arrInputData["corporation"].$arrInputData["name_kj_1"]."�ͤ��";

/*
// �᡼�륿���ȥ� ������
$strBuffMailTitle_customer = "";
$strBuffMailTitle_customer = "��Jukutown�ؤ���礻���������ޤ�����";
*/

// �᡼������
$strBuffMailContents .= "�����䤤��碌����\n";
$strBuffMailContents .= $arrViewData["title"];
$strBuffMailContents .= "\n";

$strBuffMailContents .= "������˾����\n";
$strBuffMailContents .= $arrViewData["device"];
$strBuffMailContents .= "\n\n";

$strBuffMailContents .= "����ʸ\n";
$strBuffMailContents .= str_replace( "\n\n" , "\n" , str_replace( "\r" , "\n" , $arrInputData["contents"] ) );
$strBuffMailContents .= "\n\n";

$strBuffMailContents .= "�������;���\n";
$strBuffMailContents .= "��̾��������".$arrViewData["name_kj"]."\n";
IF( $arrViewData["name_kn"] != "" ){
	$strBuffMailContents .= "��̾(�եꥬ��)������".$arrViewData["name_kn"]."\n\n";
}
IF( $arrInputData["email"] != "" ){
	$strBuffMailContents .= "�����ť᡼�롧\n";
	$strBuffMailContents .= "����".$arrInputData["email"]."\n";
}
IF( $arrInputData["corporation"] != "" ){
	$strBuffMailContents .= "����ˡ��̾������".$arrInputData["corporation"]."\n";
}
IF( $arrInputData["post"] != "" ){
	$strBuffMailContents .= "��������̾������".$arrInputData["post"]."\n";
}
IF( $arrInputData["position"] != "" ){
	$strBuffMailContents .= "������̾������".$arrInputData["position"]."\n";
}
IF( $arrInputData["addr_cd_1"] != "" && $arrInputData["addr_cd_2"] != "" && $arrInputData["pref"] !="" && $arrInputData["address_1"] !="" ){
	$strBuffMailContents .= "��������\n";
	$strBuffMailContents .= "������".$arrInputData["addr_cd_1"]."-".$arrInputData["addr_cd_2"]."\n";
	$strBuffMailContents .= "����".$psel[$arrInputData["pref"]]."\n";
	$strBuffMailContents .= "����".$arrInputData["address_1"]."��".$arrInputData["address_2"]."\n";
}
IF( $arrInputData["tell_1"] != "" && $arrInputData["tell_2"] != "" && $arrInputData["tell_3"] != "" ){
	$strBuffMailContents .= "���������ֹ桧\n";
	$strBuffMailContents .= "����".$arrInputData["tell_1"]."-".$arrInputData["tell_2"]."-".$arrInputData["tell_3"]."\n";
}
IF( $arrInputData["fax_1"] != "" && $arrInputData["fax_2"] != "" && $arrInputData["fax_3"] != "" ){
	$strBuffMailContents .= "����FAX�ֹ桧\n";
	$strBuffMailContents .= "����".$arrInputData["fax_1"]."-".$arrInputData["fax_2"]."-".$arrInputData["fax_3"]."\n";
}


// �᡼���������� ������
$ret_mail = fnc_send_mail( "PORTAL" , $param_mail_portal_inq["to_addr"] , $strBuffMailTitle_admin , $strBuffMailContents );
IF( $ret_mail != 1 ){
	$obj_error->ViewErrMessage( "SEND_MAIL_ERROR" , "PORTAL-USER" , _BLOG_SITE_URL_BASE , $arrErr );
	exit;
}

/*
// �᡼���������� ������
$ret_mail = fnc_send_mail( "PORTAL" , $arrInputData["email"] , $strBuffMailTitle_customer , $strBuffMailContents );
IF( $ret_mail != 1 ){
	$obj_error->ViewErrMessage( "SEND_MAIL_ERROR" , "PORTAL-USER" , _BLOG_SITE_URL_BASE , $arrErr );
	exit;
}
*/
?>