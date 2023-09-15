<?
/*=================================================================
    お問合せメール送信処理
=================================================================*/

require_once( SYS_PATH."common/common_mail.php" );


// メールタイトル
$strBuffMailTitle = "";
$strBuffMailTitle = "【不動産ブログREBLO】".$arrInputData["name_kj_1"].$arrInputData["name_kj_2"]."様からの物件お問い合わせ";

// メール内容
$strBuffMailContents = "";
$strBuffMailContents .= $obj_login->clientdat[0]['cl_name']."　".$obj_login->clientdat[0]['cl_shiten']."　御中\n\n";
$strBuffMailContents .= "━━━━━━━━━━━━━━━━━━━━━━━━━━━\n";
$strBuffMailContents .= "不動産ブログREBLO（リブロ）に公開している貴社の物件情報に\n";
$strBuffMailContents .= "お客様より下記内容のお問合せがありました。　ご確認の上、\n";
$strBuffMailContents .= "ご対応をお願いいたします。\n";
$strBuffMailContents .= "━━━━━━━━━━━━━━━━━━━━━━━━━━━\n";

$strBuffMailContents .= "■お問合せ物件\n";
$strBuffMailContents .= $strMailRoomList;

$strBuffMailContents .= "■お問合せ内容\n";
FOREACH( $_POST["question"] as $key => $val ){
	reset( $param_applicate_question["disp_no"] );
	asort( $param_applicate_question["disp_no"] );
	FOREACH( $param_applicate_question["disp_no"] as $key2 => $val2 ){
		IF( $val == $param_applicate_question["id"][$key2] ){
			$strBuffMailContents .= "・".$param_applicate_question["val"][$key2]."\n";
			break;
		}
	}
}
IF( $arrInputData["question_other"] != "" ){
	$strBuffMailContents .= str_replace( "\n\n" , "\n" , str_replace( "\r" , "\n" , $arrInputData["question_other"] ) )."\n";
}
$strBuffMailContents .= "\n";
$strBuffMailContents .= "■お客様情報\n";
$strBuffMailContents .= "氏名(漢字)：　　".$arrInputData["name_kj_1"]."　".$arrInputData["name_kj_2"]."\n";
$strBuffMailContents .= "氏名(フリガナ)：　　".$arrInputData["name_kn_1"]."　".$arrInputData["name_kn_2"]."\n";
IF( $arrInputData["sex"] == 1 ){
	$strBuffMailContents .= "性別：　　男性\n";
}ELSEIF( $arrInputData["sex"] == 2 ){
	$strBuffMailContents .= "性別：　　女性\n";
}ELSE{
	$strBuffMailContents .= "性別：\n";
}
IF( $arrInputData["old"] != "" ){
	$strBuffMailContents .= "年齢：　　".$arrInputData["old"]." 歳\n";
}ELSE{
	$strBuffMailContents .= "年齢：\n";
}
$intBuffContFlg = 9;
FOREACH( $param_inquiry_work["disp_no"] as $key => $val ){
	IF( $arrInputData["work_kind"] == $param_inquiry_work["id"][$key] ){
		$strBuffMailContents .= "職業：　　".$param_inquiry_work["val"][$key]."\n";
		$intBuffContFlg = 1;
		break;
	}
}
IF( $intBuffContFlg == 9 ){
	$strBuffMailContents .= "職業：\n";
}
$strBuffMailContents .= "連絡方法:\n";
IF( $arrInputData["report_type_1"] == 1 ){
	$strBuffMailContents .= "　・電話での連絡：\n";
	$strBuffMailContents .= "　　".$arrInputData["tell_1"]."-".$arrInputData["tell_2"]."-".$arrInputData["tell_3"]."\n";
	$strBuffMailContents .= "　　(連絡ご希望の時間帯:".$arrInputData["tell_time"].")\n";
}
IF( $arrInputData["report_type_2"] == 2 ){
	$strBuffMailContents .= "　・FAXでの連絡：\n";
	$strBuffMailContents .= "　　".$arrInputData["fax_1"]."-".$arrInputData["fax_2"]."-".$arrInputData["fax_3"]."\n";
}
IF( $arrInputData["report_type_3"] == 3 ){
	$strBuffMailContents .= "　・郵送での連絡：\n";
	$strBuffMailContents .= "　　〒".$arrInputData["addr_cd_1"]."-".$arrInputData["addr_cd_2"]."\n";
	$strBuffMailContents .= "　　".$arrInputData["address_1"]."　".$arrInputData["address_2"]."\n";
}
IF( $arrInputData["report_type_4"] == 4 ){
	$strBuffMailContents .= "　・Ｅメールでの連絡：\n";
	$strBuffMailContents .= "　　".$arrInputData["email"]."\n";
}

$strBuffMailContents .= " \n";
$strBuffMailContents .= "＜注意＞\n";
$strBuffMailContents .= "個人情報保護に関する取り扱いは充分注意するようお願 いします。\n\n";
$strBuffMailContents .= "ご不明な点などございましたら、下記までお問合せ下さい。\n";
$strBuffMailContents .= "━━━━━━━━━━━━━━━━━━━━━━━━\n";
$strBuffMailContents .= "　不動産ブログシステム・REBLO（リブロ）\n";
$strBuffMailContents .= "　運営：スラッシュ株式会社\n";
$strBuffMailContents .= "　TEL  03-5772-7710　　FAX  03-5772-7720\n";
$strBuffMailContents .= "　（受付時間　平日１０：３０〜１８：００）\n";
$strBuffMailContents .= "　mailto:support@reblo.net\n";
$strBuffMailContents .= "　REBLO（リブロ）ポータル\n";
$strBuffMailContents .= "　http://www.reblo.net\n";
$strBuffMailContents .= "━━━━━━━━━━━━━━━━━━━━━━━━\n";


// メール送信処理
$ret_mail = fnc_send_mail( "APPLICATE" , $obj_login->clientdat[0]["blog_entry_mail"] , $strBuffMailTitle , $strBuffMailContents );
IF( $ret_mail != 1 ){
	$obj_error->ViewErrMessage( "MENT" , "USER" , _BLOG_SITE_URL_BASE , $arrErr );
	exit;
}

?>
