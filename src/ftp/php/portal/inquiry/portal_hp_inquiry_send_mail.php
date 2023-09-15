<?
/*=================================================================
    お問合せメール送信処理
=================================================================*/

require_once( SYS_PATH."common/common_mail.php" );


// メールタイトル 管理者
$strBuffMailTitle_admin = "";
$strBuffMailTitle_admin = "塾タウン【一般問合せ】".$arrInputData["subject"];

/*
// メールタイトル お客様
$strBuffMailTitle_customer = "";
$strBuffMailTitle_customer = "【Jukutownへお問い合せを送信しました】";
*/

// メール内容
IF( $arrInputData["email"] != "" ){
	$strBuffMailContents .= "■Ｅメール：\n";
	$strBuffMailContents .= $arrInputData["email"]."\n\n";
}
$strBuffMailContents .= "■件名\n";
$strBuffMailContents .= $arrInputData["subject"];
$strBuffMailContents .= "\n\n";

$strBuffMailContents .= "■本文\n";
$strBuffMailContents .= str_replace( "\n\n" , "\n" , str_replace( "\r" , "\n" , $arrInputData["contents"] ) );
$strBuffMailContents .= "\n";

// メール送信処理 管理者
$ret_mail = fnc_send_mail( "PORTAL" , $param_mail_portal_inq["to_addr"] , $strBuffMailTitle_admin , $strBuffMailContents );
IF( $ret_mail != 1 ){
	$obj_error->ViewErrMessage( "SEND_MAIL_ERROR" , "PORTAL-USER" , _BLOG_SITE_URL_BASE , $arrErr );
	exit;
}

/*
// メール送信処理 お客様へ
$ret_mail = fnc_send_mail( "PORTAL" , $arrInputData["email"] , $strBuffMailTitle_customer , $strBuffMailContents );
IF( $ret_mail != 1 ){
	$obj_error->ViewErrMessage( "SEND_MAIL_ERROR" , "PORTAL-USER" , _BLOG_SITE_URL_BASE , $arrErr );
	exit;
}
*/
?>