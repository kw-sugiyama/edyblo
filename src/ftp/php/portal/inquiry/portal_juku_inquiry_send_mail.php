<?php
/*=================================================================
    お問合せメール送信処理
=================================================================*/

require_once( SYS_PATH."common/common_mail.php" );


// メールタイトル 管理者
$strBuffMailTitle_admin = "";
$strBuffMailTitle_admin = "塾タウン【企業問合せ】".$arrInputData["corporation"].$arrInputData["name_kj_1"]."様より";

/*
// メールタイトル お客様
$strBuffMailTitle_customer = "";
$strBuffMailTitle_customer = "【Jukutownへお問合せを送信しました】";
*/

// メール内容
$strBuffMailContents .= "■お問い合わせ内容\n";
$strBuffMailContents .= $arrViewData["title"];
$strBuffMailContents .= "\n";

$strBuffMailContents .= "■ご希望内容\n";
$strBuffMailContents .= $arrViewData["device"];
$strBuffMailContents .= "\n\n";

$strBuffMailContents .= "■本文\n";
$strBuffMailContents .= str_replace( "\n\n" , "\n" , str_replace( "\r" , "\n" , $arrInputData["contents"] ) );
$strBuffMailContents .= "\n\n";

$strBuffMailContents .= "■お客様情報\n";
$strBuffMailContents .= "お名前：　　".$arrViewData["name_kj"]."\n";
IF( $arrViewData["name_kn"] != "" ){
	$strBuffMailContents .= "氏名(フリガナ)：　　".$arrViewData["name_kn"]."\n\n";
}
IF( $arrInputData["email"] != "" ){
	$strBuffMailContents .= "　・Ｅメール：\n";
	$strBuffMailContents .= "　　".$arrInputData["email"]."\n";
}
IF( $arrInputData["corporation"] != "" ){
	$strBuffMailContents .= "　・法人名：　　".$arrInputData["corporation"]."\n";
}
IF( $arrInputData["post"] != "" ){
	$strBuffMailContents .= "　・部署名：　　".$arrInputData["post"]."\n";
}
IF( $arrInputData["position"] != "" ){
	$strBuffMailContents .= "　・役職名：　　".$arrInputData["position"]."\n";
}
IF( $arrInputData["addr_cd_1"] != "" && $arrInputData["addr_cd_2"] != "" && $arrInputData["pref"] !="" && $arrInputData["address_1"] !="" ){
	$strBuffMailContents .= "　・住所\n";
	$strBuffMailContents .= "　　〒".$arrInputData["addr_cd_1"]."-".$arrInputData["addr_cd_2"]."\n";
	$strBuffMailContents .= "　　".$psel[$arrInputData["pref"]]."\n";
	$strBuffMailContents .= "　　".$arrInputData["address_1"]."　".$arrInputData["address_2"]."\n";
}
IF( $arrInputData["tell_1"] != "" && $arrInputData["tell_2"] != "" && $arrInputData["tell_3"] != "" ){
	$strBuffMailContents .= "　・電話番号：\n";
	$strBuffMailContents .= "　　".$arrInputData["tell_1"]."-".$arrInputData["tell_2"]."-".$arrInputData["tell_3"]."\n";
}
IF( $arrInputData["fax_1"] != "" && $arrInputData["fax_2"] != "" && $arrInputData["fax_3"] != "" ){
	$strBuffMailContents .= "　・FAX番号：\n";
	$strBuffMailContents .= "　　".$arrInputData["fax_1"]."-".$arrInputData["fax_2"]."-".$arrInputData["fax_3"]."\n";
}


// メール送信処理 管理者
$ret_mail = fnc_send_mail( "PORTAL" , $param_mail_portal_inq["to_addr"] , $strBuffMailTitle_admin , $strBuffMailContents );
IF( $ret_mail != 1 ){
	$obj_error->ViewErrMessage( "SEND_MAIL_ERROR" , "PORTAL-USER" , _BLOG_SITE_URL_BASE , $arrErr );
	exit;
}

/*
// メール送信処理 お客様
$ret_mail = fnc_send_mail( "PORTAL" , $arrInputData["email"] , $strBuffMailTitle_customer , $strBuffMailContents );
IF( $ret_mail != 1 ){
	$obj_error->ViewErrMessage( "SEND_MAIL_ERROR" , "PORTAL-USER" , _BLOG_SITE_URL_BASE , $arrErr );
	exit;
}
*/
?>