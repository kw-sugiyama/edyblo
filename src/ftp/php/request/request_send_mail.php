<?
/*=================================================================
    お問合せメール送信処理
=================================================================*/

require_once( SYS_PATH."common/common_mail.php" );


// メールタイトル
$strBuffMailTitle = "";
$strBuffMailTitle = "【不動産ブログREBLO】".$arrRequestValue["name_kj_1"].$arrRequestValue["name_kj_2"]."様からの物件リクエスト";

// メール内容
$strBuffMailContents = "";
$strBuffMailContents .= $obj_login->clientdat[0]['cl_name']."　".$obj_login->clientdat[0]['cl_shiten']."　御中\n\n";
$strBuffMailContents .= "━━━━━━━━━━━━━━━━━━━━━━━━━━━\n";
$strBuffMailContents .= "不動産ブログREBLO（リブロ）に物件リクエストのお問合せが\n";
$strBuffMailContents .= "ありました。　ご確認の上、ご対応をお願いいたします。\n";
$strBuffMailContents .= "━━━━━━━━━━━━━━━━━━━━━━━━━━━\n";

$strBuffMailContents .= " \n";
$strBuffMailContents .= "■お客様情報\n";
$strBuffMailContents .= "氏名(漢字)：　　".$arrRequestValue["name_kj_1"]."　".$arrRequestValue["name_kj_2"]."\n";
$strBuffMailContents .= "氏名(フリガナ)：　　".$arrRequestValue["name_kn_1"]."　".$arrRequestValue["name_kn_2"]."\n";
IF( $arrRequestValue["sex"] == 1 ){
	$strBuffMailContents .= "性別：　　男性\n";
}ELSEIF( $arrRequestValue["sex"] == 2 ){
	$strBuffMailContents .= "性別：　　女性\n";
}ELSE{
	$strBuffMailContents .= "性別：\n";
}
IF( $arrRequestValue["old"] != "" ){
	$strBuffMailContents .= "年齢：　　".$arrRequestValue["old"]." 歳\n";
}ELSE{
	$strBuffMailContents .= "年齢：\n";
}
$intBuffContFlg = 9;
FOREACH( $param_inquiry_work["disp_no"] as $key => $val ){
	IF( $arrRequestValue["work"] == $param_inquiry_work["id"][$key] ){
		$strBuffMailContents .= "職業：　　".$param_inquiry_work["val"][$key]."\n";
		$intBuffContFlg = 1;
		break;
	}
}
IF( $intBuffContFlg == 9 ){
	$strBuffMailContents .= "職業：\n";
}
$strBuffMailContents .= "連絡方法:\n";
IF( $arrRequestValue["report_type_1"] == 1 ){
	$strBuffMailContents .= "　・電話での連絡：\n";
	$strBuffMailContents .= "　　".$arrRequestValue["tell_1"]."-".$arrRequestValue["tell_2"]."-".$arrRequestValue["tell_3"]."\n";
	$strBuffMailContents .= "　　(連絡ご希望の時間帯:".$arrRequestValue["tell_time"].")\n";
}
IF( $arrRequestValue["report_type_2"] == 2 ){
	$strBuffMailContents .= "　・FAXでの連絡：\n";
	$strBuffMailContents .= "　　".$arrRequestValue["fax_1"]."-".$arrRequestValue["fax_2"]."-".$arrRequestValue["fax_3"]."\n";
}
IF( $arrRequestValue["report_type_3"] == 3 ){
	$strBuffMailContents .= "　・郵送での連絡：\n";
	$strBuffMailContents .= "　　〒".$arrRequestValue["addr_cd_1"]."-".$arrRequestValue["addr_cd_2"]."\n";
	$strBuffMailContents .= "　　".$arrRequestValue["address_1"]."　".$arrRequestValue["address_2"]."\n";
}
IF( $arrRequestValue["report_type_4"] == 4 ){
	$strBuffMailContents .= "　・Ｅメールでの連絡：\n";
	$strBuffMailContents .= "　　".$arrRequestValue["email"]."\n";
}
$strBuffMailContents .= "\n";
$strBuffMailContents .= "■お問合せ内容\n";
$strBuffMailContents .= "勤務先･通学先の最寄駅：　　".$arrRequestValue["station"]."\n";
$strBuffMailContents .= "勤務先･通学先までの希望所要時間：　　".$request_move_time_value."\n";
$strBuffMailContents .= "希望の沿線･駅：　　".$arrRequestValue["line"]."\n";
$strBuffMailContents .= "希望のエリア：　　".$arrRequestValue["area"]."\n";
$strBuffMailContents .= "希望の家賃：　　".$request_price1_value." 〜 ".$request_price2_value."\n";
$strBuffMailContents .= "希望の間取り：　　";
if(count($_POST["madori"]) != 0){
asort( $param_room_floor["disp_no"] );
	FOREACH( $param_room_floor["disp_no"] as $key => $val ){
		if(count($_POST["madori"]) != 0){
			foreach($_POST["madori"] as $key2 => $val2){
				if($param_room_floor['id'][$key] == $val2)$strBuffMailContents .= $param_room_floor['val'][$key]."、";

			}	
		}
	}
}
$strBuffMailContents .= "\n";
$strBuffMailContents .= "重視していること：\n";
if($arrRequestValue["equip1"]!="")$strBuffMailContents .= "　・１番目のご希望：".$arrRequestValue["equip1"]."\n";
if($arrRequestValue["equip2"]!="")$strBuffMailContents .= "　・２番目のご希望：".$arrRequestValue["equip2"]."\n";
if($arrRequestValue["equip3"]!="")$strBuffMailContents .= "　・３番目のご希望：".$arrRequestValue["equip3"]."\n";
if($arrRequestValue["equip4"]!="")$strBuffMailContents .= "　・４番目のご希望：".$arrRequestValue["equip4"]."\n";
if($arrRequestValue["equip5"]!="")$strBuffMailContents .= "　・５番目のご希望：".$arrRequestValue["equip5"]."\n";
$strBuffMailContents .= "その他こだわり：\n";
$strBuffMailContents .= $arrRequestValue["otherEquip"]."\n";
$strBuffMailContents .= "入居予定時期：　　".$request_move_jiki_value."\n";
$strBuffMailContents .= "入居予定人数：　　".$request_menber_value."\n";
$strBuffMailContents .= "現在の家賃：　　".$request_now_price_value."\n";

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
$ret_mail = fnc_send_mail( "REQUEST" , $obj_login->clientdat[0]["blog_request_mail"] , $strBuffMailTitle , $strBuffMailContents );
IF( $ret_mail != 1 ){
	$obj_error->ViewErrMessage( "MENT" , "USER" , _BLOG_SITE_URL_BASE , $arrErr );
	exit;
}

?>
