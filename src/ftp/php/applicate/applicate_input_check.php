<?php
/*=========================================================
    お問合せ - 入力内容チェック
=========================================================*/

// チェッククラス - インスタンス
require_once( SYS_PATH."common/input_check.class.php" );
$obj_check = new input_check();


// お問合せ内容
IF( is_array( $arrInputData["question"] ) === FALSE ){
	$arrErr["ath_comment"] = "";
	$arrErr["ath_comment"] .= "お問い合わせ内容を選択して下さい。";
	$arrErr["ath_comment"] .= $strInputHidden;
	$arrErr["ath_comment"] .= "<INPUT type=\"hidden\" name=\"form_flg\" value=\"\">\n";
	$obj_error->ViewErrMessage( "INPUT_CHECK_ERROR" , "USER" , _BLOG_SITE_URL_BASE."applicate/" , $arrErr );
	exit;
}ELSEIF( in_array( "99" , $arrInputData["question"] ) ){
	IF( $arrInputData["question_other"] == "" ){
		$arrErr["ath_comment"] = "";
		$arrErr["ath_comment"] .= "「その他」を選択した場合、内容を入力して下さい。";
		$arrErr["ath_comment"] .= $strInputHidden;
		$arrErr["ath_comment"] .= "<INPUT type=\"hidden\" name=\"form_flg\" value=\"\">\n";
		$obj_error->ViewErrMessage( "INPUT_CHECK_ERROR" , "USER" , _BLOG_SITE_URL_BASE."applicate/" , $arrErr );
		exit;
	}ELSE{
		// 空白チェック
		$ret = $obj_check->check_only_space( $arrInputData["contents"] );
		IF( $ret === true ){
			$arrErr["ath_comment"] = "";
			$arrErr["ath_comment"] .= "「その他」の内容は空白のみの入力は出来ません。";
			$arrErr["ath_comment"] .= $strInputHidden;
			$arrErr["ath_comment"] .= "<INPUT type=\"hidden\" name=\"form_flg\" value=\"\">\n";
			$obj_error->ViewErrMessage( "INPUT_CHECK_ERROR" , "USER" , _BLOG_SITE_URL_BASE."applicate/" , $arrErr );
			exit;
		}
	}
}


// 氏名(漢字)
IF( $arrInputData["name_kj_1"] == "" || $arrInputData["name_kj_2"] == "" ){
	$arrErr["ath_comment"] = "";
	$arrErr["ath_comment"] .= "氏名(漢字)を入力して下さい。";
	$arrErr["ath_comment"] .= $strInputHidden;
	$arrErr["ath_comment"] .= "<INPUT type=\"hidden\" name=\"form_flg\" value=\"\">\n";
	$obj_error->ViewErrMessage( "INPUT_CHECK_ERROR" , "USER" , _BLOG_SITE_URL_BASE."applicate/" , $arrErr );
	exit;
}ELSE{
	// 空白チェック
	$ret_1 = $obj_check->check_only_space( $arrInputData["name_kj_1"] );
	$ret_2 = $obj_check->check_only_space( $arrInputData["name_kj_2"] );
	IF( $ret_1 === true || $ret_2 === true ){
		$arrErr["ath_comment"] = "";
		$arrErr["ath_comment"] .= "氏名(漢字)は空白のみの入力は出来ません。";
		$arrErr["ath_comment"] .= $strInputHidden;
		$arrErr["ath_comment"] .= "<INPUT type=\"hidden\" name=\"form_flg\" value=\"\">\n";
		$obj_error->ViewErrMessage( "INPUT_CHECK_ERROR" , "USER" , _BLOG_SITE_URL_BASE."applicate/" , $arrErr );
		exit;
	}
}


// 氏名(フリガナ)
IF( $arrInputData["name_kn_1"] != "" || $arrInputData["name_kn_2"] != "" ){
	IF( $arrInputData["name_kn_1"] == "" || $arrInputData["name_kn_2"] == "" ){
		$arrErr["ath_comment"] = "";
		$arrErr["ath_comment"] .= "氏名(フリガナ)の入力内容を確認して下さい。";
		$arrErr["ath_comment"] .= $strInputHidden;
		$arrErr["ath_comment"] .= "<INPUT type=\"hidden\" name=\"form_flg\" value=\"\">\n";
		$obj_error->ViewErrMessage( "INPUT_CHECK_ERROR" , "USER" , _BLOG_SITE_URL_BASE."applicate/" , $arrErr );
		exit;
	}ELSE{
		// 空白チェック
		$ret_1 = $obj_check->check_only_space( $arrInputData["name_kn_1"] );
		$ret_2 = $obj_check->check_only_space( $arrInputData["name_kn_2"] );
		IF( $ret_1 === TRUE || $ret_2 === TRUE ){
			$arrErr["ath_comment"] = "";
			$arrErr["ath_comment"] .= "氏名(フリガナ)は空白のみの入力は出来ません。";
			$arrErr["ath_comment"] .= $strInputHidden;
			$arrErr["ath_comment"] .= "<INPUT type=\"hidden\" name=\"form_flg\" value=\"\">\n";
			$obj_error->ViewErrMessage( "INPUT_CHECK_ERROR" , "USER" , _BLOG_SITE_URL_BASE."applicate/" , $arrErr );
			exit;
		}
		// 全角カタカナチェック
		$ret_1 = $obj_check->check_katakana( $arrInputData["name_kn_1"] );
		$ret_2 = $obj_check->check_katakana( $arrInputData["name_kn_2"] );
		IF( $ret_1 === TRUE || $ret_2 === TRUE ){
			$arrErr["ath_comment"] = "";
			$arrErr["ath_comment"] .= "氏名(フリガナ)は全角カタカナで入力して下さい。";
			$arrErr["ath_comment"] .= $strInputHidden;
			$arrErr["ath_comment"] .= "<INPUT type=\"hidden\" name=\"form_flg\" value=\"\">\n";
			$obj_error->ViewErrMessage( "INPUT_CHECK_ERROR" , "USER" , _BLOG_SITE_URL_BASE."applicate/" , $arrErr );
			exit;
		}
	}
}


// 性別 - チェックしない


// 年齢
IF( $arrInputData["old"] != "" ){
	$ret = $obj_check->check_only_hanint( $arrInputData["old"] );
	IF( $ret === FALSE ){
		$arrErr["ath_comment"] = "";
		$arrErr["ath_comment"] .= "年齢は半角数字のみで入力して下さい。";
		$arrErr["ath_comment"] .= $strInputHidden;
		$arrErr["ath_comment"] .= "<INPUT type=\"hidden\" name=\"form_flg\" value=\"\">\n";
		$obj_error->ViewErrMessage( "INPUT_CHECK_ERROR" , "USER" , _BLOG_SITE_URL_BASE."applicate/" , $arrErr );
		exit;
	}
}


// 職業 - チェックしない


// 連絡方法
IF( $arrInputData["report_type_1"] != 1 && $arrInputData["report_type_2"] != 2 && $arrInputData["report_type_3"] != 3 && $arrInputData["report_type_4"] != 4 ){
	$arrErr["ath_comment"] = "";
	$arrErr["ath_comment"] .= "連絡方法をひとつ以上選択して下さい。";
	$arrErr["ath_comment"] .= $strInputHidden;
	$arrErr["ath_comment"] .= "<INPUT type=\"hidden\" name=\"form_flg\" value=\"\">\n";
	$obj_error->ViewErrMessage( "INPUT_CHECK_ERROR" , "USER" , _BLOG_SITE_URL_BASE."applicate/" , $arrErr );
	exit;
}ELSE{
	// 電話連絡OK
	IF( $arrInputData["report_type_1"] == 1 ){
		IF( $arrInputData["tell_1"] == "" || $arrInputData["tell_2"] == "" || $arrInputData["tell_3"] == "" ){
			$arrErr["ath_comment"] = "";
			$arrErr["ath_comment"] .= "電話番号を正しく入力して下さい。";
			$arrErr["ath_comment"] .= $strInputHidden;
			$arrErr["ath_comment"] .= "<INPUT type=\"hidden\" name=\"form_flg\" value=\"\">\n";
			$obj_error->ViewErrMessage( "INPUT_CHECK_ERROR" , "USER" , _BLOG_SITE_URL_BASE."applicate/" , $arrErr );
			exit;
		}
		$strBuffTell = $arrInputData["tell_1"]."-".$arrInputData["tell_2"]."-".$arrInputData["tell_3"];
//		$ret = $obj_check->check_tell_2( $strBuffTell );
//		IF( $ret === FALSE ){
//			$arrErr["ath_comment"] = "";
//			$arrErr["ath_comment"] .= "電話番号を正しく入力して下さい。<br />電話番号は半角数字のみで入力して下さい。";
//			$arrErr["ath_comment"] .= $strInputHidden;
//			$arrErr["ath_comment"] .= "<INPUT type=\"hidden\" name=\"form_flg\" value=\"\">\n";
//			$obj_error->ViewErrMessage( "INPUT_CHECK_ERROR" , "USER" , _BLOG_SITE_URL_BASE."applicate/" , $arrErr );
//			exit;
//		}
		IF( $arrInputData["tell_time"] == "" ){
			$arrErr["ath_comment"] = "";
			$arrErr["ath_comment"] .= "電話連絡のご希望時間帯を入力して下さい。";
			$arrErr["ath_comment"] .= $strInputHidden;
			$arrErr["ath_comment"] .= "<INPUT type=\"hidden\" name=\"form_flg\" value=\"\">\n";
			$obj_error->ViewErrMessage( "INPUT_CHECK_ERROR" , "USER" , _BLOG_SITE_URL_BASE."applicate/" , $arrErr );
			exit;
		}ELSE{
			$ret = $obj_check->check_only_space( $arrInputData["tell_time"] );
			IF( $ret === true ){
				$arrErr["ath_comment"] = "";
				$arrErr["ath_comment"] .= "電話連絡のご希望時間帯は、スペースのみの入力はできません。";
				$arrErr["ath_comment"] .= $strInputHidden;
				$arrErr["ath_comment"] .= "<INPUT type=\"hidden\" name=\"form_flg\" value=\"\">\n";
				$obj_error->ViewErrMessage( "INPUT_CHECK_ERROR" , "USER" , _BLOG_SITE_URL_BASE."applicate/" , $arrErr );
				exit;
			}
		}
	}
	
	// FAX連絡OK
	IF( $arrInputData["report_type_2"] == 2 ){
		IF( $arrInputData["fax_1"] == "" || $arrInputData["fax_2"] == "" || $arrInputData["fax_3"] == "" ){
			$arrErr["ath_comment"] = "";
			$arrErr["ath_comment"] .= "FAX番号を正しく入力して下さい。";
			$arrErr["ath_comment"] .= $strInputHidden;
			$arrErr["ath_comment"] .= "<INPUT type=\"hidden\" name=\"form_flg\" value=\"\">\n";
			$obj_error->ViewErrMessage( "INPUT_CHECK_ERROR" , "USER" , _BLOG_SITE_URL_BASE."applicate/" , $arrErr );
			exit;
		}
		$strBuffFax = $arrInputData["fax_1"]."-".$arrInputData["fax_2"]."-".$arrInputData["fax_3"];
//		$ret = $obj_check->check_tell_2( $strBuffFax );
//		IF( $ret === FALSE ){
//			$arrErr["ath_comment"] = "";
//			$arrErr["ath_comment"] .= "FAX番号を正しく入力して下さい。<br />FAX番号は半角数字のみで入力して下さい。";
//			$arrErr["ath_comment"] .= $strInputHidden;
//			$arrErr["ath_comment"] .= "<INPUT type=\"hidden\" name=\"form_flg\" value=\"\">\n";
//			$obj_error->ViewErrMessage( "INPUT_CHECK_ERROR" , "USER" , _BLOG_SITE_URL_BASE."applicate/" , $arrErr );
//			exit;
//		}
	}
	
	// 郵送連絡OK
	IF( $arrInputData["report_type_3"] == 3 ){
		// 郵便番号チェック
		IF( $arrInputData["addr_cd_1"] == "" || $arrInputData["addr_cd_2"] == "" ){
			$arrErr["ath_comment"] = "";
			$arrErr["ath_comment"] .= "郵便番号を入力して下さい。";
			$arrErr["ath_comment"] .= $strInputHidden;
			$arrErr["ath_comment"] .= "<INPUT type=\"hidden\" name=\"form_flg\" value=\"\">\n";
			$obj_error->ViewErrMessage( "INPUT_CHECK_ERROR" , "USER" , _BLOG_SITE_URL_BASE."applicate/" , $arrErr );
			exit;
		}
		$strBuffAddrCd = $arrInputData["addr_cd_1"]."-".$arrInputData["addr_cd_2"];
		$ret = $obj_check->check_address_code( $strBuffAddrCd );
		IF( $ret === FALSE ){
			$arrErr["ath_comment"] = "";
			$arrErr["ath_comment"] .= "郵便番号を正しく入力して下さい。<br />郵便番号は半角数字のみで入力して下さい。";
			$arrErr["ath_comment"] .= $strInputHidden;
			$arrErr["ath_comment"] .= "<INPUT type=\"hidden\" name=\"form_flg\" value=\"\">\n";
			$obj_error->ViewErrMessage( "INPUT_CHECK_ERROR" , "USER" , _BLOG_SITE_URL_BASE."applicate/" , $arrErr );
			exit;
		}
		
		// 住所チェック
		IF( $arrInputData["address_1"] == "" ){
			$arrErr["ath_comment"] = "";
			$arrErr["ath_comment"] .= "住所１を例のように入力して下さい。";
			$arrErr["ath_comment"] .= $strInputHidden;
			$arrErr["ath_comment"] .= "<INPUT type=\"hidden\" name=\"form_flg\" value=\"\">\n";
			$obj_error->ViewErrMessage( "INPUT_CHECK_ERROR" , "USER" , _BLOG_SITE_URL_BASE."applicate/" , $arrErr );
			exit;
		}ELSE{
			$ret = $obj_check->check_only_space( $arrInputData["address_1"] );
			IF( $ret === TRUE ){
				$arrErr["ath_comment"] = "";
				$arrErr["ath_comment"] .= "住所１は空白のみの入力はできません。";
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
				$arrErr["ath_comment"] .= "住所２は空白のみの入力はできません。";
				$arrErr["ath_comment"] .= $strInputHidden;
				$arrErr["ath_comment"] .= "<INPUT type=\"hidden\" name=\"form_flg\" value=\"\">\n";
				$obj_error->ViewErrMessage( "INPUT_CHECK_ERROR" , "USER" , _BLOG_SITE_URL_BASE."applicate/" , $arrErr );
				exit;
			}
		}
	}
	
	// Eメール連絡OK
	IF( $arrInputData["report_type_4"] == 4 ){
		IF( $arrInputData["email"] == "" ){
			$arrErr["ath_comment"] = "";
			$arrErr["ath_comment"] .= "Ｅメールアドレスを入力して下さい。";
			$arrErr["ath_comment"] .= $strInputHidden;
			$arrErr["ath_comment"] .= "<INPUT type=\"hidden\" name=\"form_flg\" value=\"\">\n";
			$obj_error->ViewErrMessage( "INPUT_CHECK_ERROR" , "USER" , _BLOG_SITE_URL_BASE."applicate/" , $arrErr );
			exit;
		}
		$ret = $obj_check->check_email( $arrInputData["email"] );
		IF( $ret === FALSE ){
			$arrErr["ath_comment"] = "";
			$arrErr["ath_comment"] .= "Ｅメールアドレスを正しく入力して下さい。";
			$arrErr["ath_comment"] .= $strInputHidden;
			$arrErr["ath_comment"] .= "<INPUT type=\"hidden\" name=\"form_flg\" value=\"\">\n";
			$obj_error->ViewErrMessage( "INPUT_CHECK_ERROR" , "USER" , _BLOG_SITE_URL_BASE."applicate/" , $arrErr );
			exit;
		}
	}
	
}

?>
