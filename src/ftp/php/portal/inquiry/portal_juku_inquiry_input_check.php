<?php
/*=========================================================
    お問合せ - 入力内容チェック
=========================================================*/

// チェッククラス - インスタンス
require_once( SYS_PATH."common/input_check.class.php" );
$obj_check = new input_check();


// お問合せ内容
IF( count($arrInputData["title"]) == 0 ){
	$arrErr["ath_comment"] = "";
	$arrErr["ath_comment"] .= "お問い合わせ内容を選択して下さい。";
	$arrErr["ath_comment"] .= $strInputHidden;
	$arrErr["ath_comment"] .= "<INPUT type=\"hidden\" name=\"form_flg\" value=\"\">\n";
	$obj_error->ViewErrMessage( "INPUT_CHECK_ERROR" , "PORTAL-USER" , _BLOG_SITE_URL_BASE."/juku_inquiry/" , $arrErr );
	exit;
}

// ご希望内容
IF( count($arrInputData["device"]) == 0 ){
	$arrErr["ath_comment"] = "";
	$arrErr["ath_comment"] .= "ご希望内容を選択して下さい。";
	$arrErr["ath_comment"] .= $strInputHidden;
	$arrErr["ath_comment"] .= "<INPUT type=\"hidden\" name=\"form_flg\" value=\"\">\n";
	$obj_error->ViewErrMessage( "INPUT_CHECK_ERROR" , "PORTAL-USER" , _BLOG_SITE_URL_BASE."/juku_inquiry/" , $arrErr );
	exit;
}

/*
// お問合せ内容本文
IF( $arrInputData["contents"] == "" ){
	$arrErr["ath_comment"] = "";
	$arrErr["ath_comment"] .= "お問い合わせ内容を入力して下さい。";
	$arrErr["ath_comment"] .= $strInputHidden;
	$arrErr["ath_comment"] .= "<INPUT type=\"hidden\" name=\"form_flg\" value=\"\">\n";
	$obj_error->ViewErrMessage( "INPUT_CHECK_ERROR" , "PORTAL-USER" , _BLOG_SITE_URL_BASE."/juku_inquiry/" , $arrErr );
	exit;
}ELSE{
	// 空白チェック
	$ret = $obj_check->check_only_space( $arrInputData["contents"] );
	IF( $ret === true ){
		$arrErr["ath_comment"] = "";
		$arrErr["ath_comment"] .= "お問い合わせ内容は空白のみの入力は出来ません。";
		$arrErr["ath_comment"] .= $strInputHidden;
		$arrErr["ath_comment"] .= "<INPUT type=\"hidden\" name=\"form_flg\" value=\"\">\n";
		$obj_error->ViewErrMessage( "INPUT_CHECK_ERROR" , "PORTAL-USER" , _BLOG_SITE_URL_BASE."/juku_inquiry/" , $arrErr );
		exit;
	}
}
*/

// お名前
IF( $arrInputData["name_kj_1"] == "" ){
	$arrErr["ath_comment"] = "";
	$arrErr["ath_comment"] .= "お名前を入力して下さい。";
	$arrErr["ath_comment"] .= $strInputHidden;
	$arrErr["ath_comment"] .= "<INPUT type=\"hidden\" name=\"form_flg\" value=\"\">\n";
	$obj_error->ViewErrMessage( "INPUT_CHECK_ERROR" , "PORTAL-USER" , _BLOG_SITE_URL_BASE."/juku_inquiry/" , $arrErr );
	exit;
}ELSE{
	// 空白チェック
	$ret_1 = $obj_check->check_only_space( $arrInputData["name_kj_1"] );
	IF( $ret_1 === true ){
		$arrErr["ath_comment"] = "";
		$arrErr["ath_comment"] .= "お名前は空白のみの入力は出来ません。";
		$arrErr["ath_comment"] .= $strInputHidden;
		$arrErr["ath_comment"] .= "<INPUT type=\"hidden\" name=\"form_flg\" value=\"\">\n";
		$obj_error->ViewErrMessage( "INPUT_CHECK_ERROR" , "PORTAL-USER" , _BLOG_SITE_URL_BASE."/juku_inquiry/" , $arrErr );
		exit;
	}
}


// お名前(フリガナ)
IF( $arrInputData["name_kn_1"] != "" ){
	IF( $arrInputData["name_kn_1"] == "" ){
		$arrErr["ath_comment"] = "";
		$arrErr["ath_comment"] .= "お名前(フリガナ)の入力内容を確認して下さい。";
		$arrErr["ath_comment"] .= $strInputHidden;
		$arrErr["ath_comment"] .= "<INPUT type=\"hidden\" name=\"form_flg\" value=\"\">\n";
		$obj_error->ViewErrMessage( "INPUT_CHECK_ERROR" , "PORTAL-USER" , _BLOG_SITE_URL_BASE."/juku_inquiry/" , $arrErr );
		exit;
	}ELSE{
		// 空白チェック
		$ret_1 = $obj_check->check_only_space( $arrInputData["name_kn_1"] );
		IF( $ret_1 === TRUE ){
			$arrErr["ath_comment"] = "";
			$arrErr["ath_comment"] .= "お名前(フリガナ)は空白のみの入力は出来ません。";
			$arrErr["ath_comment"] .= $strInputHidden;
			$arrErr["ath_comment"] .= "<INPUT type=\"hidden\" name=\"form_flg\" value=\"\">\n";
			$obj_error->ViewErrMessage( "INPUT_CHECK_ERROR" , "PORTAL-USER" , _BLOG_SITE_URL_BASE."/juku_inquiry/" , $arrErr );
			exit;
		}
		// 全角カタカナチェック
		$ret_1 = $obj_check->check_katakana( $arrInputData["name_kn_1"] );
		IF( $ret_1 === TRUE ){
			$arrErr["ath_comment"] = "";
			$arrErr["ath_comment"] .= "お名前(フリガナ)は全角カタカナで入力して下さい。";
			$arrErr["ath_comment"] .= $strInputHidden;
			$arrErr["ath_comment"] .= "<INPUT type=\"hidden\" name=\"form_flg\" value=\"\">\n";
			$obj_error->ViewErrMessage( "INPUT_CHECK_ERROR" , "PORTAL-USER" , _BLOG_SITE_URL_BASE."/juku_inquiry/" , $arrErr );
			exit;
		}
	}
}

	
// Eメールチェック
IF( $arrInputData["email"] == "" ){
	$arrErr["ath_comment"] = "";
	$arrErr["ath_comment"] .= "Ｅメールアドレスを入力して下さい。";
	$arrErr["ath_comment"] .= $strInputHidden;
	$arrErr["ath_comment"] .= "<INPUT type=\"hidden\" name=\"form_flg\" value=\"\">\n";
	$obj_error->ViewErrMessage( "INPUT_CHECK_ERROR" , "PORTAL-USER" , _BLOG_SITE_URL_BASE."/juku_inquiry/" , $arrErr );
	exit;
}
$ret = $obj_check->check_email( $arrInputData["email"] );
IF( $ret === FALSE ){
	$arrErr["ath_comment"] = "";
	$arrErr["ath_comment"] .= "Ｅメールアドレスを正しく入力して下さい。";
	$arrErr["ath_comment"] .= $strInputHidden;
	$arrErr["ath_comment"] .= "<INPUT type=\"hidden\" name=\"form_flg\" value=\"\">\n";
	$obj_error->ViewErrMessage( "INPUT_CHECK_ERROR" , "PORTAL-USER" , _BLOG_SITE_URL_BASE."/juku_inquiry/" , $arrErr );
	exit;
}


// 郵便番号チェック
IF( $arrInputData["addr_cd_1"] != "" || $arrInputData["addr_cd_2"] != "" ){
	IF( $arrInputData["addr_cd_1"] == "" || $arrInputData["addr_cd_2"] == "" ){
		$arrErr["ath_comment"] = "";
		$arrErr["ath_comment"] .= "郵便番号を入力して下さい。";
		$arrErr["ath_comment"] .= $strInputHidden;
		$arrErr["ath_comment"] .= "<INPUT type=\"hidden\" name=\"form_flg\" value=\"\">\n";
		$obj_error->ViewErrMessage( "INPUT_CHECK_ERROR" , "PORTAL-USER" , _BLOG_SITE_URL_BASE."/juku_inquiry/" , $arrErr );
		exit;
	}
	$strBuffAddrCd = $arrInputData["addr_cd_1"]."-".$arrInputData["addr_cd_2"];
	$ret = $obj_check->check_address_code( $strBuffAddrCd );
	IF( $ret === FALSE ){
		$arrErr["ath_comment"] = "";
		$arrErr["ath_comment"] .= "郵便番号を正しく入力して下さい。<br />郵便番号は半角数字のみで入力して下さい。";
		$arrErr["ath_comment"] .= $strInputHidden;
		$arrErr["ath_comment"] .= "<INPUT type=\"hidden\" name=\"form_flg\" value=\"\">\n";
		$obj_error->ViewErrMessage( "INPUT_CHECK_ERROR" , "PORTAL-USER" , _BLOG_SITE_URL_BASE."/juku_inquiry/" , $arrErr );
		exit;
	}
}

/*
// 住所チェック
IF( $arrInputData["address_1"] != "" || $arrInputData["address_2"] != "" ){
	IF( $arrInputData["address_1"] == "" ){
		$arrErr["ath_comment"] = "";
		$arrErr["ath_comment"] .= "住所１を例のように入力して下さい。";
		$arrErr["ath_comment"] .= $strInputHidden;
		$arrErr["ath_comment"] .= "<INPUT type=\"hidden\" name=\"form_flg\" value=\"\">\n";
		$obj_error->ViewErrMessage( "INPUT_CHECK_ERROR" , "PORTAL-USER" , _BLOG_SITE_URL_BASE."/juku_inquiry/" , $arrErr );
		exit;
	}ELSE{
		$ret = $obj_check->check_only_space( $arrInputData["address_1"] );
		IF( $ret === TRUE ){
			$arrErr["ath_comment"] = "";
			$arrErr["ath_comment"] .= "住所１は空白のみの入力はできません。";
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
			$arrErr["ath_comment"] .= "住所２は空白のみの入力はできません。";
			$arrErr["ath_comment"] .= $strInputHidden;
			$arrErr["ath_comment"] .= "<INPUT type=\"hidden\" name=\"form_flg\" value=\"\">\n";
			$obj_error->ViewErrMessage( "INPUT_CHECK_ERROR" , "PORTAL-USER" , _BLOG_SITE_URL_BASE."/juku_inquiry/" , $arrErr );
			exit;
		}
	}
}
*/

// 電話番号チェック
IF( $arrInputData["tell_1"] != "" ){
//	IF( $arrInputData["tell_1"] == "" || $arrInputData["tell_2"] == "" || $arrInputData["tell_3"] == "" ){
//		$arrErr["ath_comment"] = "";
//		$arrErr["ath_comment"] .= "電話番号を正しく入力して下さい。";
//		$arrErr["ath_comment"] .= $strInputHidden;
//		$arrErr["ath_comment"] .= "<INPUT type=\"hidden\" name=\"form_flg\" value=\"\">\n";
//		$obj_error->ViewErrMessage( "INPUT_CHECK_ERROR" , "PORTAL-USER" , _BLOG_SITE_URL_BASE."/juku_inquiry/" , $arrErr );
//		exit;
//	}
	$strBuffTell = $arrInputData["tell_1"];
	$ret = $obj_check->check_tell_2( $strBuffTell );
	IF( $ret === FALSE ){
		$arrErr["ath_comment"] = "";
		$arrErr["ath_comment"] .= "電話番号を正しく入力して下さい。<br />電話番号は半角数字のみで入力して下さい。";
		$arrErr["ath_comment"] .= $strInputHidden;
		$arrErr["ath_comment"] .= "<INPUT type=\"hidden\" name=\"form_flg\" value=\"\">\n";
		$obj_error->ViewErrMessage( "INPUT_CHECK_ERROR" , "PORTAL-USER" , _BLOG_SITE_URL_BASE."/juku_inquiry/" , $arrErr );
		exit;
	}
}

// 携帯電話番号チェック
IF( $arrInputData["mobile_1"] != "" ){
//	IF( $arrInputData["tell_1"] == "" || $arrInputData["tell_2"] == "" || $arrInputData["tell_3"] == "" ){
//		$arrErr["ath_comment"] = "";
//		$arrErr["ath_comment"] .= "電話番号を正しく入力して下さい。";
//		$arrErr["ath_comment"] .= $strInputHidden;
//		$arrErr["ath_comment"] .= "<INPUT type=\"hidden\" name=\"form_flg\" value=\"\">\n";
//		$obj_error->ViewErrMessage( "INPUT_CHECK_ERROR" , "PORTAL-USER" , _BLOG_SITE_URL_BASE."/juku_inquiry/" , $arrErr );
//		exit;
//	}
	$strBuffTell = $arrInputData["mobile_1"];
	$ret = $obj_check->check_keitai_tell_2( $strBuffTell );
	IF( $ret === FALSE ){
		$arrErr["ath_comment"] = "";
		$arrErr["ath_comment"] .= "携帯電話番号を正しく入力して下さい。<br />携帯電話番号は半角数字のみで入力して下さい。";
		$arrErr["ath_comment"] .= $strInputHidden;
		$arrErr["ath_comment"] .= "<INPUT type=\"hidden\" name=\"form_flg\" value=\"\">\n";
		$obj_error->ViewErrMessage( "INPUT_CHECK_ERROR" , "PORTAL-USER" , _BLOG_SITE_URL_BASE."/juku_inquiry/" , $arrErr );
		exit;
	}
}

/*
// FAX番号チェック
IF( $arrInputData["fax_1"] != "" || $arrInputData["fax_2"] != "" || $arrInputData["fax_3"] != "" ){
	IF( $arrInputData["fax_1"] == "" || $arrInputData["fax_2"] == "" || $arrInputData["fax_3"] == "" ){
		$arrErr["ath_comment"] = "";
		$arrErr["ath_comment"] .= "FAX番号を正しく入力して下さい。";
		$arrErr["ath_comment"] .= $strInputHidden;
		$arrErr["ath_comment"] .= "<INPUT type=\"hidden\" name=\"form_flg\" value=\"\">\n";
		$obj_error->ViewErrMessage( "INPUT_CHECK_ERROR" , "PORTAL-USER" , _BLOG_SITE_URL_BASE."/juku_inquiry/" , $arrErr );
		exit;
	}
}
*/

?>