<?php
/*=========================================================
    お問合せ - 入力内容チェック
=========================================================*/

// チェッククラス - インスタンス
require_once( SYS_PATH."common/input_check.class.php" );
$obj_check = new input_check();

// メールチェック
IF( $arrInputData["email"] == "" ){
	$arrErr["ath_comment"] = "";
	$arrErr["ath_comment"] .= "メールアドレスを入力して下さい。";
	$arrErr["ath_comment"] .= $strInputHidden;
	$arrErr["ath_comment"] .= "<INPUT type=\"hidden\" name=\"form_flg\" value=\"\">\n";
	$obj_error->ViewErrMessage( "INPUT_CHECK_ERROR" , "PORTAL-USER" , _BLOG_SITE_URL_BASE."inquiry/" , $arrErr );
	exit;
}
$ret = $obj_check->check_email( $arrInputData["email"] );
IF( $ret === FALSE ){
	$arrErr["ath_comment"] = "";
	$arrErr["ath_comment"] .= "メールアドレスを正しく入力して下さい。";
	$arrErr["ath_comment"] .= $strInputHidden;
	$arrErr["ath_comment"] .= "<INPUT type=\"hidden\" name=\"form_flg\" value=\"\">\n";
	$obj_error->ViewErrMessage( "INPUT_CHECK_ERROR" , "PORTAL-USER" , _BLOG_SITE_URL_BASE."inquiry/" , $arrErr );
	exit;
}

// 件名
IF( $arrInputData["subject"] == "" ){
	$arrErr["ath_comment"] = "";
	$arrErr["ath_comment"] .= "件名を入力して下さい。";
	$arrErr["ath_comment"] .= $strInputHidden;
	$arrErr["ath_comment"] .= "<INPUT type=\"hidden\" name=\"form_flg\" value=\"\">\n";
	$obj_error->ViewErrMessage( "INPUT_CHECK_ERROR" , "PORTAL-USER" , _BLOG_SITE_URL_BASE."inquiry/" , $arrErr );
	exit;
}ELSE{
	// 空白チェック
	$ret = $obj_check->check_only_space( $arrInputData["subject"] );
	IF( $ret === true ){
		$arrErr["ath_comment"] = "";
		$arrErr["ath_comment"] .= "件名は空白のみの入力は出来ません。";
		$arrErr["ath_comment"] .= $strInputHidden;
		$arrErr["ath_comment"] .= "<INPUT type=\"hidden\" name=\"form_flg\" value=\"\">\n";
		$obj_error->ViewErrMessage( "INPUT_CHECK_ERROR" , "PORTAL-USER" , _BLOG_SITE_URL_BASE."inquiry/" , $arrErr );
		exit;
	}
}

/*
// お問合せ内容
IF( $arrInputData["contents"] == "" ){
	$arrErr["ath_comment"] = "";
	$arrErr["ath_comment"] .= "お問い合わせ内容を入力して下さい。";
	$arrErr["ath_comment"] .= $strInputHidden;
	$arrErr["ath_comment"] .= "<INPUT type=\"hidden\" name=\"form_flg\" value=\"\">\n";
	$obj_error->ViewErrMessage( "INPUT_CHECK_ERROR" , "PORTAL-USER" , _BLOG_SITE_URL_BASE."inquiry/" , $arrErr );
	exit;
}ELSE{
	// 空白チェック
	$ret = $obj_check->check_only_space( $arrInputData["contents"] );
	IF( $ret === true ){
		$arrErr["ath_comment"] = "";
		$arrErr["ath_comment"] .= "お問い合わせ内容は空白のみの入力は出来ません。";
		$arrErr["ath_comment"] .= $strInputHidden;
		$arrErr["ath_comment"] .= "<INPUT type=\"hidden\" name=\"form_flg\" value=\"\">\n";
		$obj_error->ViewErrMessage( "INPUT_CHECK_ERROR" , "PORTAL-USER" , _BLOG_SITE_URL_BASE."inquiry/" , $arrErr );
		exit;
	}
}
*/
?>