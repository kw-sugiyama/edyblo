<?php
/*=========================================================
    物件リクエスト - 入力内容チェック
=========================================================*/
// POST値を格納
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


// チェッククラス - インスタンス
require_once( SYS_PATH."common/input_check.class.php" );
$obj_check = new input_check();


// 氏名(漢字)
IF( $arrRequestValue["name_kj_1"] == "" || $arrRequestValue["name_kj_2"] == "" ){
	$arrErr["ath_comment"] = "";
	$arrErr["ath_comment"] .= "氏名(漢字)を入力して下さい。";
	$arrErr["ath_comment"] .= $strInputHidden;
	$arrErr["ath_comment"] .= "<INPUT type=\"hidden\" name=\"form_flg\" value=\"\">\n";
	$obj_error->ViewErrMessage( "INPUT_CHECK_ERROR" , "USER" , _BLOG_SITE_URL_BASE."request.php" , $arrErr );
	exit;
}ELSE{
	// 空白チェック
	$ret_1 = $obj_check->check_only_space( $arrRequestValue["name_kj_1"] );
	$ret_2 = $obj_check->check_only_space( $arrRequestValue["name_kj_2"] );
	IF( $ret_1 === true || $ret_2 === true ){
		$arrErr["ath_comment"] = "";
		$arrErr["ath_comment"] .= "氏名(漢字)は空白のみの入力は出来ません。";
		$arrErr["ath_comment"] .= $strInputHidden;
		$arrErr["ath_comment"] .= "<INPUT type=\"hidden\" name=\"form_flg\" value=\"\">\n";
		$obj_error->ViewErrMessage( "INPUT_CHECK_ERROR" , "USER" , _BLOG_SITE_URL_BASE."request.php" , $arrErr );
		exit;
	}
}


// 氏名(フリガナ)
IF( $arrRequestValue["name_kn_1"] != "" || $arrRequestValue["name_kn_2"] != "" ){
	IF( $arrRequestValue["name_kn_1"] == "" || $arrRequestValue["name_kn_2"] == "" ){
		$arrErr["ath_comment"] = "";
		$arrErr["ath_comment"] .= "氏名(フリガナ)の入力内容を確認して下さい。";
		$arrErr["ath_comment"] .= $strInputHidden;
		$arrErr["ath_comment"] .= "<INPUT type=\"hidden\" name=\"form_flg\" value=\"\">\n";
		$obj_error->ViewErrMessage( "INPUT_CHECK_ERROR" , "USER" , _BLOG_SITE_URL_BASE."request.php" , $arrErr );
		exit;
	}ELSE{
		// 空白チェック
		$ret_1 = $obj_check->check_only_space( $arrRequestValue["name_kn_1"] );
		$ret_2 = $obj_check->check_only_space( $arrRequestValue["name_kn_2"] );
		IF( $ret_1 === TRUE || $ret_2 === TRUE ){
			$arrErr["ath_comment"] = "";
			$arrErr["ath_comment"] .= "氏名(フリガナ)は空白のみの入力は出来ません。";
			$arrErr["ath_comment"] .= $strInputHidden;
			$arrErr["ath_comment"] .= "<INPUT type=\"hidden\" name=\"form_flg\" value=\"\">\n";
			$obj_error->ViewErrMessage( "INPUT_CHECK_ERROR" , "USER" , _BLOG_SITE_URL_BASE."request.php" , $arrErr );
			exit;
		}
		// 全角カタカナチェック
		$ret_1 = $obj_check->check_katakana( $arrRequestValue["name_kn_1"] );
		$ret_2 = $obj_check->check_katakana( $arrRequestValue["name_kn_2"] );
		IF( $ret_1 === TRUE || $ret_2 === TRUE ){
			$arrErr["ath_comment"] = "";
			$arrErr["ath_comment"] .= "氏名(フリガナ)は全角カタカナで入力して下さい。";
			$arrErr["ath_comment"] .= $strInputHidden;
			$arrErr["ath_comment"] .= "<INPUT type=\"hidden\" name=\"form_flg\" value=\"\">\n";
			$obj_error->ViewErrMessage( "INPUT_CHECK_ERROR" , "USER" , _BLOG_SITE_URL_BASE."request.php" , $arrErr );
			exit;
		}
	}
}


// 性別 - チェックしない


// 年齢
IF( $arrRequestValue["old"] != "" ){
	$ret = $obj_check->check_only_hanint( $arrRequestValue["old"] );
	IF( $ret === FALSE ){
		$arrErr["ath_comment"] = "";
		$arrErr["ath_comment"] .= "年齢は半角数字のみで入力して下さい。";
		$arrErr["ath_comment"] .= $strInputHidden;
		$arrErr["ath_comment"] .= "<INPUT type=\"hidden\" name=\"form_flg\" value=\"\">\n";
		$obj_error->ViewErrMessage( "INPUT_CHECK_ERROR" , "USER" , _BLOG_SITE_URL_BASE."request.php" , $arrErr );
		exit;
	}
}


// 職業 - チェックしない


// 連絡方法
IF( $arrRequestValue["report_type_1"] != 1 && $arrRequestValue["report_type_2"] != 2 && $arrRequestValue["report_type_3"] != 3 && $arrRequestValue["report_type_4"] != 4 ){
	$arrErr["ath_comment"] = "";
	$arrErr["ath_comment"] .= "連絡方法をひとつ以上選択して下さい。";
	$arrErr["ath_comment"] .= $strInputHidden;
	$arrErr["ath_comment"] .= "<INPUT type=\"hidden\" name=\"form_flg\" value=\"\">\n";
	$obj_error->ViewErrMessage( "INPUT_CHECK_ERROR" , "USER" , _BLOG_SITE_URL_BASE."request.php" , $arrErr );
	exit;
}ELSE{
	// 電話連絡OK
	IF( $arrRequestValue["report_type_1"] == 1 ){
		IF( $arrRequestValue["tell_1"] == "" || $arrRequestValue["tell_2"] == "" || $arrRequestValue["tell_3"] == "" ){
			$arrErr["ath_comment"] = "";
			$arrErr["ath_comment"] .= "電話番号を正しく入力して下さい。";
			$arrErr["ath_comment"] .= $strInputHidden;
			$arrErr["ath_comment"] .= "<INPUT type=\"hidden\" name=\"form_flg\" value=\"\">\n";
			$obj_error->ViewErrMessage( "INPUT_CHECK_ERROR" , "USER" , _BLOG_SITE_URL_BASE."request.php" , $arrErr );
			exit;
		}
//		$strBuffTell = $arrRequestValue["tell_1"]."-".$arrRequestValue["tell_2"]."-".$arrRequestValue["tell_3"];
//		$ret = $obj_check->check_tell_2( $strBuffTell );
//		IF( $ret === FALSE ){
//			$arrErr["ath_comment"] = "";
//			$arrErr["ath_comment"] .= "電話番号を正しく入力して下さい。<br />電話番号は半角数字のみで入力して下さい。";
//			$arrErr["ath_comment"] .= $strInputHidden;
//			$arrErr["ath_comment"] .= "<INPUT type=\"hidden\" name=\"form_flg\" value=\"\">\n";
//			$obj_error->ViewErrMessage( "INPUT_CHECK_ERROR" , "USER" , _BLOG_SITE_URL_BASE."request.php" , $arrErr );
//			exit;
//		}
		IF( $arrRequestValue["tell_time"] == "" ){
			$arrErr["ath_comment"] = "";
			$arrErr["ath_comment"] .= "電話連絡のご希望時間帯を入力して下さい。";
			$arrErr["ath_comment"] .= $strInputHidden;
			$arrErr["ath_comment"] .= "<INPUT type=\"hidden\" name=\"form_flg\" value=\"\">\n";
			$obj_error->ViewErrMessage( "INPUT_CHECK_ERROR" , "USER" , _BLOG_SITE_URL_BASE."request.php" , $arrErr );
			exit;
		}ELSE{
			$ret = $obj_check->check_only_space( $arrRequestValue["tell_time"] );
			IF( $ret === true ){
				$arrErr["ath_comment"] = "";
				$arrErr["ath_comment"] .= "電話連絡のご希望時間帯は、スペースのみの入力はできません。";
				$arrErr["ath_comment"] .= $strInputHidden;
				$arrErr["ath_comment"] .= "<INPUT type=\"hidden\" name=\"form_flg\" value=\"\">\n";
				$obj_error->ViewErrMessage( "INPUT_CHECK_ERROR" , "USER" , _BLOG_SITE_URL_BASE."request.php" , $arrErr );
				exit;
			}
		}
	}
	
	// FAX連絡OK
	IF( $arrRequestValue["report_type_2"] == 2 ){
		IF( $arrRequestValue["fax_1"] == "" || $arrRequestValue["fax_2"] == "" || $arrRequestValue["fax_3"] == "" ){
			$arrErr["ath_comment"] = "";
			$arrErr["ath_comment"] .= "FAX番号を正しく入力して下さい。";
			$arrErr["ath_comment"] .= $strInputHidden;
			$arrErr["ath_comment"] .= "<INPUT type=\"hidden\" name=\"form_flg\" value=\"\">\n";
			$obj_error->ViewErrMessage( "INPUT_CHECK_ERROR" , "USER" , _BLOG_SITE_URL_BASE."request.php" , $arrErr );
			exit;
		}
//		$strBuffFax = $arrRequestValue["fax_1"]."-".$arrRequestValue["fax_2"]."-".$arrRequestValue["fax_3"];
//		$ret = $obj_check->check_tell_2( $strBuffFax );
//		IF( $ret === FALSE ){
//			$arrErr["ath_comment"] = "";
//			$arrErr["ath_comment"] .= "FAX番号を正しく入力して下さい。<br />FAX番号は半角数字のみで入力して下さい。";
//			$arrErr["ath_comment"] .= $strInputHidden;
//			$arrErr["ath_comment"] .= "<INPUT type=\"hidden\" name=\"form_flg\" value=\"\">\n";
//			$obj_error->ViewErrMessage( "INPUT_CHECK_ERROR" , "USER" , _BLOG_SITE_URL_BASE."request.php" , $arrErr );
//			exit;
//		}
	}
	
	// 郵送連絡OK
	IF( $arrRequestValue["report_type_3"] == 3 ){
		// 郵便番号チェック
		IF( $arrRequestValue["addr_cd_1"] == "" || $arrRequestValue["addr_cd_2"] == "" ){
			$arrErr["ath_comment"] = "";
			$arrErr["ath_comment"] .= "郵便番号を入力して下さい。";
			$arrErr["ath_comment"] .= $strInputHidden;
			$arrErr["ath_comment"] .= "<INPUT type=\"hidden\" name=\"form_flg\" value=\"\">\n";
			$obj_error->ViewErrMessage( "INPUT_CHECK_ERROR" , "USER" , _BLOG_SITE_URL_BASE."request.php" , $arrErr );
			exit;
		}
		$strBuffAddrCd = $arrRequestValue["addr_cd_1"]."-".$arrRequestValue["addr_cd_2"];
		$ret = $obj_check->check_address_code( $strBuffAddrCd );
		IF( $ret === FALSE ){
			$arrErr["ath_comment"] = "";
			$arrErr["ath_comment"] .= "郵便番号を正しく入力して下さい。<br />郵便番号は半角数字のみで入力して下さい。";
			$arrErr["ath_comment"] .= $strInputHidden;
			$arrErr["ath_comment"] .= "<INPUT type=\"hidden\" name=\"form_flg\" value=\"\">\n";
			$obj_error->ViewErrMessage( "INPUT_CHECK_ERROR" , "USER" , _BLOG_SITE_URL_BASE."request.php" , $arrErr );
			exit;
		}
		
		// 住所チェック
		IF( $arrRequestValue["address_1"] == "" ){
			$arrErr["ath_comment"] = "";
			$arrErr["ath_comment"] .= "住所１を例のように入力して下さい。";
			$arrErr["ath_comment"] .= $strInputHidden;
			$arrErr["ath_comment"] .= "<INPUT type=\"hidden\" name=\"form_flg\" value=\"\">\n";
			$obj_error->ViewErrMessage( "INPUT_CHECK_ERROR" , "USER" , _BLOG_SITE_URL_BASE."request.php" , $arrErr );
			exit;
		}ELSE{
			$ret = $obj_check->check_only_space( $arrRequestValue["address_1"] );
			IF( $ret === TRUE ){
				$arrErr["ath_comment"] = "";
				$arrErr["ath_comment"] .= "住所１は空白のみの入力はできません。";
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
				$arrErr["ath_comment"] .= "住所２は空白のみの入力はできません。";
				$arrErr["ath_comment"] .= $strInputHidden;
				$arrErr["ath_comment"] .= "<INPUT type=\"hidden\" name=\"form_flg\" value=\"\">\n";
				$obj_error->ViewErrMessage( "INPUT_CHECK_ERROR" , "USER" , _BLOG_SITE_URL_BASE."request.php" , $arrErr );
				exit;
			}
		}
	}
	
	// Eメール連絡OK
	IF( $arrRequestValue["report_type_4"] == 4 ){
		IF( $arrRequestValue["email"] == "" ){
			$arrErr["ath_comment"] = "";
			$arrErr["ath_comment"] .= "Ｅメールアドレスを入力して下さい。";
			$arrErr["ath_comment"] .= $strInputHidden;
			$arrErr["ath_comment"] .= "<INPUT type=\"hidden\" name=\"form_flg\" value=\"\">\n";
			$obj_error->ViewErrMessage( "INPUT_CHECK_ERROR" , "USER" , _BLOG_SITE_URL_BASE."request.php" , $arrErr );
			exit;
		}
		$ret = $obj_check->check_email( $arrRequestValue["email"] );
		IF( $ret === FALSE ){
			$arrErr["ath_comment"] = "";
			$arrErr["ath_comment"] .= "Ｅメールアドレスを正しく入力して下さい。";
			$arrErr["ath_comment"] .= $strInputHidden;
			$arrErr["ath_comment"] .= "<INPUT type=\"hidden\" name=\"form_flg\" value=\"\">\n";
			$obj_error->ViewErrMessage( "INPUT_CHECK_ERROR" , "USER" , _BLOG_SITE_URL_BASE."request.php" , $arrErr );
			exit;
		}
	}
	
}

// 勤務先･通学先の最寄駅
// 空白チェック
$ret_1 = $obj_check->check_only_space( $arrRequestValue["station"] );
$ret_2 = $obj_check->check_only_space( $arrRequestValue["station"] );
IF( $ret_1 === true || $ret_2 === true ){
	$arrErr["ath_comment"] = "";
	$arrErr["ath_comment"] .= "勤務先･通学先の最寄駅は空白のみの入力は出来ません。";
	$arrErr["ath_comment"] .= $strInputHidden;
	$arrErr["ath_comment"] .= "<INPUT type=\"hidden\" name=\"form_flg\" value=\"\">\n";
	$obj_error->ViewErrMessage( "INPUT_CHECK_ERROR" , "USER" , _BLOG_SITE_URL_BASE."request.php" , $arrErr );
	exit;
}

// 勤務先･通学先までの希望所要時間
// 空白チェック
$ret_1 = $obj_check->check_only_space( $arrRequestValue["move"] );
IF( $ret_1 === true ){
	$arrErr["ath_comment"] = "";
	$arrErr["ath_comment"] .= "勤務先･通学先までの希望所要時間は空白のみの入力は出来ません。";
	$arrErr["ath_comment"] .= $strInputHidden;
	$arrErr["ath_comment"] .= "<INPUT type=\"hidden\" name=\"form_flg\" value=\"\">\n";
	$obj_error->ViewErrMessage( "INPUT_CHECK_ERROR" , "USER" , _BLOG_SITE_URL_BASE."request.php" , $arrErr );
	exit;
}

// 希望の沿線･駅
// 空白チェック
$ret_1 = $obj_check->check_only_space( $arrRequestValue["line"] );
IF( $ret_1 === true　){
	$arrErr["ath_comment"] = "";
	$arrErr["ath_comment"] .= "希望の沿線･駅は空白のみの入力は出来ません。";
	$arrErr["ath_comment"] .= $strInputHidden;
	$arrErr["ath_comment"] .= "<INPUT type=\"hidden\" name=\"form_flg\" value=\"\">\n";
	$obj_error->ViewErrMessage( "INPUT_CHECK_ERROR" , "USER" , _BLOG_SITE_URL_BASE."request.php" , $arrErr );
	exit;
}

// 希望のエリア
// 空白チェック
$ret_1 = $obj_check->check_only_space( $arrRequestValue["area"] );
IF( $ret_1 === true ){
	$arrErr["ath_comment"] = "";
	$arrErr["ath_comment"] .= "希望のエリアは空白のみの入力は出来ません。";
	$arrErr["ath_comment"] .= $strInputHidden;
	$arrErr["ath_comment"] .= "<INPUT type=\"hidden\" name=\"form_flg\" value=\"\">\n";
	$obj_error->ViewErrMessage( "INPUT_CHECK_ERROR" , "USER" , _BLOG_SITE_URL_BASE."request.php" , $arrErr );
	exit;
}

// 希望の家賃1
// 半角数字チェック
IF($arrRequestValue["price1"] != ""){
	$ret = $obj_check->check_only_hanint( $arrRequestValue["price1"] );
	IF( $ret === FALSE ){
		$arrErr["ath_comment"] = "";
		$arrErr["ath_comment"] .= "希望の家賃は半角数字のみで入力して下さい。";
		$arrErr["ath_comment"] .= $strInputHidden;
		$arrErr["ath_comment"] .= "<INPUT type=\"hidden\" name=\"form_flg\" value=\"\">\n";
		$obj_error->ViewErrMessage( "INPUT_CHECK_ERROR" , "USER" , _BLOG_SITE_URL_BASE."request.php" , $arrErr );
		exit;
	}
}

// 希望の家賃2
// 半角数字チェック
IF($arrRequestValue["price1"] != ""){
	$ret = $obj_check->check_only_hanint( $arrRequestValue["price2"] );
	IF( $ret === FALSE ){
		$arrErr["ath_comment"] = "";
		$arrErr["ath_comment"] .= "希望の家賃は半角数字のみで入力して下さい。";
		$arrErr["ath_comment"] .= $strInputHidden;
		$arrErr["ath_comment"] .= "<INPUT type=\"hidden\" name=\"form_flg\" value=\"\">\n";
		$obj_error->ViewErrMessage( "INPUT_CHECK_ERROR" , "USER" , _BLOG_SITE_URL_BASE."request.php" , $arrErr );
		exit;
	}
}

// 重視している事1
// 空白チェック
$ret_1 = $obj_check->check_only_space( $arrRequestValue["equip1"] );
IF( $ret_1 === true ){
	$arrErr["ath_comment"] = "";
	$arrErr["ath_comment"] .= "重視している事は空白のみの入力は出来ません。";
	$arrErr["ath_comment"] .= $strInputHidden;
	$arrErr["ath_comment"] .= "<INPUT type=\"hidden\" name=\"form_flg\" value=\"\">\n";
	$obj_error->ViewErrMessage( "INPUT_CHECK_ERROR" , "USER" , _BLOG_SITE_URL_BASE."request.php" , $arrErr );
	exit;
}

// 重視している事2
// 空白チェック
$ret_1 = $obj_check->check_only_space( $arrRequestValue["equip2"] );
IF( $ret_1 === true ){
	$arrErr["ath_comment"] = "";
	$arrErr["ath_comment"] .= "重視している事は空白のみの入力は出来ません。";
	$arrErr["ath_comment"] .= $strInputHidden;
	$arrErr["ath_comment"] .= "<INPUT type=\"hidden\" name=\"form_flg\" value=\"\">\n";
	$obj_error->ViewErrMessage( "INPUT_CHECK_ERROR" , "USER" , _BLOG_SITE_URL_BASE."request.php" , $arrErr );
	exit;
}

// 重視している事3
// 空白チェック
$ret_1 = $obj_check->check_only_space( $arrRequestValue["equip3"] );
IF( $ret_1 === true ){
	$arrErr["ath_comment"] = "";
	$arrErr["ath_comment"] .= "重視している事は空白のみの入力は出来ません。";
	$arrErr["ath_comment"] .= $strInputHidden;
	$arrErr["ath_comment"] .= "<INPUT type=\"hidden\" name=\"form_flg\" value=\"\">\n";
	$obj_error->ViewErrMessage( "INPUT_CHECK_ERROR" , "USER" , _BLOG_SITE_URL_BASE."request.php" , $arrErr );
	exit;
}

// 重視している事4
// 空白チェック
$ret_1 = $obj_check->check_only_space( $arrRequestValue["equip4"] );
IF( $ret_1 === true ){
	$arrErr["ath_comment"] = "";
	$arrErr["ath_comment"] .= "重視している事は空白のみの入力は出来ません。";
	$arrErr["ath_comment"] .= $strInputHidden;
	$arrErr["ath_comment"] .= "<INPUT type=\"hidden\" name=\"form_flg\" value=\"\">\n";
	$obj_error->ViewErrMessage( "INPUT_CHECK_ERROR" , "USER" , _BLOG_SITE_URL_BASE."request.php" , $arrErr );
	exit;
}

// 重視している事5
// 空白チェック
$ret_1 = $obj_check->check_only_space( $arrRequestValue["equip5"] );
IF( $ret_1 === true ){
	$arrErr["ath_comment"] = "";
	$arrErr["ath_comment"] .= "重視している事は空白のみの入力は出来ません。";
	$arrErr["ath_comment"] .= $strInputHidden;
	$arrErr["ath_comment"] .= "<INPUT type=\"hidden\" name=\"form_flg\" value=\"\">\n";
	$obj_error->ViewErrMessage( "INPUT_CHECK_ERROR" , "USER" , _BLOG_SITE_URL_BASE."request.php" , $arrErr );
	exit;
}

// その他こだわり
// 空白チェック
$ret_1 = $obj_check->check_only_space( $arrRequestValue["otherEquip"] );
IF( $ret_1 === true ){
	$arrErr["ath_comment"] = "";
	$arrErr["ath_comment"] .= "その他こだわりは空白のみの入力は出来ません。";
	$arrErr["ath_comment"] .= $strInputHidden;
	$arrErr["ath_comment"] .= "<INPUT type=\"hidden\" name=\"form_flg\" value=\"\">\n";
	$obj_error->ViewErrMessage( "INPUT_CHECK_ERROR" , "USER" , _BLOG_SITE_URL_BASE."request.php" , $arrErr );
	exit;
}

// 入居予定時期
// 空白チェック
$ret_1 = $obj_check->check_only_space( $arrRequestValue["moveTime"] );
IF( $ret_1 === true ){
	$arrErr["ath_comment"] = "";
	$arrErr["ath_comment"] .= "入居予定時期は空白のみの入力は出来ません。";
	$arrErr["ath_comment"] .= $strInputHidden;
	$arrErr["ath_comment"] .= "<INPUT type=\"hidden\" name=\"form_flg\" value=\"\">\n";
	$obj_error->ViewErrMessage( "INPUT_CHECK_ERROR" , "USER" , _BLOG_SITE_URL_BASE."request.php" , $arrErr );
	exit;
}

// 現在の家賃
// 半角数字チェック
IF($arrRequestValue["nowPrice"] != ""){
	$ret = $obj_check->check_only_hanint( $arrRequestValue["nowPrice"] );
	IF( $ret === FALSE ){
		$arrErr["ath_comment"] = "";
		$arrErr["ath_comment"] .= "現在の家賃は半角数字のみで入力して下さい。";
		$arrErr["ath_comment"] .= $strInputHidden;
		$arrErr["ath_comment"] .= "<INPUT type=\"hidden\" name=\"form_flg\" value=\"\">\n";
		$obj_error->ViewErrMessage( "INPUT_CHECK_ERROR" , "USER" , _BLOG_SITE_URL_BASE."request.php" , $arrErr );
		exit;
	}
}

?>
