<?
/*=================================================================
    ����礻�᡼����������
=================================================================*/

require_once( SYS_PATH."common/common_mail.php" );


// �᡼�륿���ȥ� ������
$strBuffMailTitle_admin = "";
$strBuffMailTitle_admin = "�Υ�����ڰ�����礻��".$arrInputData["subject"];

/*
// �᡼�륿���ȥ� ������
$strBuffMailTitle_customer = "";
$strBuffMailTitle_customer = "��Jukutown�ؤ��䤤�礻���������ޤ�����";
*/

// �᡼������
IF( $arrInputData["email"] != "" ){
	$strBuffMailContents .= "���ť᡼�롧\n";
	$strBuffMailContents .= $arrInputData["email"]."\n\n";
}
$strBuffMailContents .= "����̾\n";
$strBuffMailContents .= $arrInputData["subject"];
$strBuffMailContents .= "\n\n";

$strBuffMailContents .= "����ʸ\n";
$strBuffMailContents .= str_replace( "\n\n" , "\n" , str_replace( "\r" , "\n" , $arrInputData["contents"] ) );
$strBuffMailContents .= "\n";

// �᡼���������� ������
$ret_mail = fnc_send_mail( "PORTAL" , $param_mail_portal_inq["to_addr"] , $strBuffMailTitle_admin , $strBuffMailContents );
IF( $ret_mail != 1 ){
	$obj_error->ViewErrMessage( "SEND_MAIL_ERROR" , "PORTAL-USER" , _BLOG_SITE_URL_BASE , $arrErr );
	exit;
}

/*
// �᡼���������� �����ͤ�
$ret_mail = fnc_send_mail( "PORTAL" , $arrInputData["email"] , $strBuffMailTitle_customer , $strBuffMailContents );
IF( $ret_mail != 1 ){
	$obj_error->ViewErrMessage( "SEND_MAIL_ERROR" , "PORTAL-USER" , _BLOG_SITE_URL_BASE , $arrErr );
	exit;
}
*/
?>