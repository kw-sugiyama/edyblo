<?

print("$_POST[mailtype]");

if(isset($_POST)){
	extract($_POST);
}

$report       = mb_convert_encoding($_POST[report]       , "EUC-JP", "shift-jis");
$report1       = mb_convert_encoding($_POST[report1]       , "EUC-JP", "shift-jis");
$report2       = mb_convert_encoding($_POST[report2]       , "EUC-JP", "shift-jis");
$report3       = mb_convert_encoding($_POST[report3]       , "EUC-JP", "shift-jis");
$report4       = mb_convert_encoding($_POST[report4]       , "EUC-JP", "shift-jis");
$etc           = mb_convert_encoding($_POST[etc]           , "EUC-JP", "shift-jis");
$demand1       = mb_convert_encoding($_POST[demand1]       , "EUC-JP", "shift-jis");
$demand2       = mb_convert_encoding($_POST[demand2]       , "EUC-JP", "shift-jis");
$demand3       = mb_convert_encoding($_POST[demand3]       , "EUC-JP", "shift-jis");
$demand4       = mb_convert_encoding($_POST[demand4]       , "EUC-JP", "shift-jis");
$inquiry       = mb_convert_encoding($_POST[inquiry]       , "EUC-JP", "shift-jis");
$kidsname_kj_1 = mb_convert_encoding($_POST[kidsname_kj_1] , "EUC-JP", "shift-jis");
$kidsname_kj_2 = mb_convert_encoding($_POST[kidsname_kj_2] , "EUC-JP", "shift-jis");
$kidsname_kn_1 = mb_convert_encoding($_POST[kidsname_kn_1] , "EUC-JP", "shift-jis");
$kidsname_kn_2 = mb_convert_encoding($_POST[kidsname_kn_2] , "EUC-JP", "shift-jis");
$sex           = mb_convert_encoding($_POST[sex]           , "EUC-JP", "shift-jis");
$year          = mb_convert_encoding($_POST[year]          , "EUC-JP", "shift-jis");
$month         = mb_convert_encoding($_POST[month]         , "EUC-JP", "shift-jis");
$day           = mb_convert_encoding($_POST[day]           , "EUC-JP", "shift-jis");
$gakunen       = mb_convert_encoding($_POST[gakunen]       , "EUC-JP", "shift-jis");
$gakunen_text  = mb_convert_encoding($_POST[gakunen_text]  , "EUC-JP", "shift-jis");
$type          = mb_convert_encoding($_POST[type]          , "EUC-JP", "shift-jis");
$school        = mb_convert_encoding($_POST[school]        , "EUC-JP", "shift-jis");
$name_kj_1     = mb_convert_encoding($_POST[name_kj_1]     , "EUC-JP", "shift-jis");
$name_kj_2     = mb_convert_encoding($_POST[name_kj_2]     , "EUC-JP", "shift-jis");
$name_kn_1     = mb_convert_encoding($_POST[name_kn_1]     , "EUC-JP", "shift-jis");
$name_kn_2     = mb_convert_encoding($_POST[name_kn_2]     , "EUC-JP", "shift-jis");
$addr_cd_1     = mb_convert_encoding($_POST[addr_cd_1]     , "EUC-JP", "shift-jis");
$addr_cd_2     = mb_convert_encoding($_POST[addr_cd_2]     , "EUC-JP", "shift-jis");
$pref          = mb_convert_encoding($_POST[pref]          , "EUC-JP", "shift-jis");
$city          = mb_convert_encoding($_POST[city]          , "EUC-JP", "shift-jis");
$add           = mb_convert_encoding($_POST[add]           , "EUC-JP", "shift-jis");
$Buil          = mb_convert_encoding($_POST[Buil]          , "EUC-JP", "shift-jis");
$tel           = mb_convert_encoding($_POST[tel]           , "EUC-JP", "shift-jis");
$ctel          = mb_convert_encoding($_POST[ctel]          , "EUC-JP", "shift-jis");
$mail          = mb_convert_encoding($_POST[mail]          , "EUC-JP", "shift-jis");

//携帯用　ＰＯＳＴ引渡し
/*
$report1       = $_POST[report1]          ;
$report2       = $_POST[report2]          ;
$report3       = $_POST[report3]          ;
$report4       = $_POST[report4]          ;
$etc           = $_POST[etc]              ;
$demand1       = $_POST[demand1]          ;
$demand2       = $_POST[demand2]          ;
$demand3       = $_POST[demand3]          ;
$demand4       = $_POST[demand4]          ;
$inquiry       = $_POST[inquiry]          ;
$kidsname_kj_1 = $_POST[kidsname_kj_1]    ;
$kidsname_kj_2 = $_POST[kidsname_kj_2]    ;
$kidsname_kn_1 = $_POST[kidsname_kn_1]    ;
$kidsname_kn_2 = $_POST[kidsname_kn_2]    ;
$sex           = $_POST[sex]              ;
$year          = $_POST[year]             ;
$month         = $_POST[month]            ;
$day           = $_POST[day]              ;
$gakunen       = $_POST[gakunen]          ;
$gakunen_text  = $_POST[gakunen_text]     ;
$type          = $_POST[type]             ;
$school        = $_POST[school]           ;
$name_kj_1     = $_POST[name_kj_1]        ;
$name_kj_2     = $_POST[name_kj_2]        ;
$name_kn_1     = $_POST[name_kn_1]        ;
$name_kn_2     = $_POST[name_kn_2]        ;
$addr_cd_1     = $_POST[addr_cd_1]        ;
$addr_cd_2     = $_POST[addr_cd_2]        ;
$pref          = $_POST[pref]             ;
$city          = $_POST[city]             ;
$add           = $_POST[add]              ;
$Buil          = $_POST[Buil]             ;
$tel           = $_POST[tel]              ;
$ctel          = $_POST[ctel]             ;
$mail          = $_POST[mail]             ;
 */
$category_title=$title;

$mail_info  =$obj_login->clientdat[0]['sc_infomail'];
$mail_info2 =$obj_login->clientdat[0]['sc_infomail2'];

//資料請求 お問い合わせ用
$sendmail_i=$mail_info;

if(!$mail_info2==""){
	 $sendmail_i .=",";
	 $sendmail_i .=$mail_info2;
}

if (isset($_SESSION['ticket'], $_POST['ticket']) && $_SESSION['ticket'] === $_POST['ticket']) 

	unset($_SESSION['ticket']);

	//年齢計算
	if( $year != "" && $month != "" && $day != "" ){
		if($momnth<10)$month="0".$month;
		if($day<10)$day="0".$day;
		$birth=$year.$month.$day;
		$age=(int)((date('Ymd')-$birth)/10000);
	}else{
		$year  = "----";
		$month = "--"  ;
		$day   = "--"  ;
		$age   = "--"  ;
	}

	$age_check=array();
	$age_list="";
	if(($age_of & 64) ==64){
		$age_check[7] ='社会人';
		$age_icon[7]  ='<img src="./share/icons/icon_b_18.gif" alt="" />';
		$age_of-=64;
	}
	if(($age_of & 32) ==32){
		$age_check[6] ='大学生　';
		$age_icon[6]  ='<img src="./share/icons/icon_b_5.gif" alt="" />　';
		$age_of-=32;
	}
	if(($age_of & 16) ==16){
		$age_check[5] ='浪人生　';
		$age_icon[5]  ='<img src="./share/icons/icon_b_13.gif" alt="" />　';
		$age_of-=16;
	}
	if(($age_of & 8)  ==8){
		$age_check[4] ='高校生　';
		$age_icon[4]  ='<img src="./share/icons/icon_b_11.gif" alt="" />　';
		$age_of-=8;
	}
	if(($age_of & 4)  ==4){
		$age_check[3] ='中学生　';
		$age_icon[3]  ='<img src="./share/icons/icon_b_3.gif" alt="" />　';
		$age_of-=4;
	}
	if(($age_of & 2)  ==2){
		$age_check[2] ='小学生　';
		$age_icon[2]  ='<img src="./share/icons/icon_b_15.gif" alt="" />　';
		$age_of-=2;
	}
	if(($age_of & 1)  ==1){
		$age_check[1] ='幼児　';
		$age_icon[1]  ='<img src="./share/icons/icon_b_19.gif" alt="" />　';
		$age_of-=1;
	}
	ksort($age_check);
	foreach($age_check as $val){
		$age_list.=$val;
	}

$mail_finding=$arrMetaHeader['title_corp']."　御中";

//学年
foreach($param_inq_gakunen["val"] as $key => $val) {
	if ($gakunen == ""){
		$gakunen_disp .= '';
	}else if ($gakunen==$key) {
		$gakunen_disp .= $val;
	} else {
		$gakunen_disp .= '';
	}
}

	$message1='■お問合せ内容
';
	if($report1)$message1.='・'.$report1.'
';
	if($report2)$message1.='・'.$report2.'
';
	if($report3)$message1.='・'.$report3.'
';
	if($report4)$message1.='・'.$report4.'
'.$etc.'
';

//学年
$str_gakunen = "";
if ($gakunen_disp       != "" && $gakunen_text != ""){
$str_gakunen = '学年：　　　　　　　　'.$gakunen_disp.'　'.$gakunen_text.'
';
}else if ($gakunen_disp != "" && $gakunen_text == ""){
$str_gakunen = '学年：　　　　　　　　'.$gakunen_disp.'
';
}else if ($gakunen_disp == "" && $gakunen_text != ""){
$str_gakunen = '学年：　　　　　　　　'.$gakunen_text.'
';
}

//学校
$str_gakkou = "";
if ($type != "" && $school != ""){
$str_gakkou = '学校名：　　　　　　　'.$type.' 立 '.$school.'
';
}else if ($type != "" && $school == ""){
$str_gakkou = '学校名：　　　　　　　'.$type.'
';
}else if ($type == "" && $school != ""){
$str_gakkou = '学校名：　　　　　　　'.$school.'
';
}

$yuubin ='郵便番号：　　　　　　'.$addr_cd_1.'
		  ';
//message2セクション===================================================
	$message2='
■お客様情報
保護者氏名(漢字)：　　'.$name_kj_1.'　'.$name_kj_2.'
保護者氏名(フリガナ)：'.$name_kn_1.'　'.$name_kn_2.'
お子様氏名(漢字)：　　'.$kidsname_kj_1.'　'.$kidsname_kj_2.'
お子様氏名(フリガナ)：'.$kidsname_kn_1.'　'.$kidsname_kn_2.'
性別：　　　　　　　　'.$sex.'
'.$str_gakunen.$str_gakkou.$yuubin.'
';
	if($pref && $city && $add)$message2.='住所：　　　　　　　　'.$pref.$city.$add.$Buil.'
';

//生年月日：　　　　　　'.$year.'年'.$month.'月'.$day.'日
//年齢：　　　　　　　　'.$age.'
	if($tel){
		$message2.='電話番号：　　　　　　'.$tel.'
';
		$telno='
　　電話番号：'.$tel;
	}
	if($ctel){
		$message2.='携帯番号：　　　　　　'.$ctel.'
';
		$telno.='
　　携帯番号：'.$ctel;
	}
	if($mail){
		$message2.='メールアドレス：　　　'.$mail.'
';
	}
//message3セクション==================================================
//	$message3='連絡方法:
//';
//	if($demand1)$message3.='・'.$demand1.'
//';//資料を送付して欲しい
//	if($demand2)$message3.='・'.$demand2.$telno.'
//';//詳細を知りたいので電話して欲しい
//	if($demand3)$message3.='・'.$demand3.'
//';//詳細を知りたいので訪問したい
//	if($demand4)$message3.='・'.$demand4.'
//メールアドレス：'.$mail.'
//';//質問内容に答えて欲しい
//=====================================================================
	$message4='
＜注意＞
個人情報保護に関する取り扱いは充分注意するようお願いします。

ご不明な点などございましたら、下記までお問合せ下さい。

━━━━━━━━━━━━━━━━━━━━━━━━━━━━
学習塾専用ホームページ「Edyblo」（エディブロ）
　運営：株式会社ノアング
　〒160-0023　東京都新宿区西新宿7-11-3　平田ビル2F
　TEL：03-5332-6124　　FAX：03-5332-6125
　お問い合わせ：support@jukutown.com
━━━━━━━━━━━━━━━━━━━━━━━━━━━━
';

//日時
if($publishing){
	$cam_publishing='
日時　　　　　　　　：'.$publishing;
	$cs_publishing='
日時　　　　　：'.$publishing;
}

//switchによる分岐

$mailtype="REQUEST";
switch ($mailtype) {
	
		//資料請求
		case "REQUEST":
			$html_title='資料請求';
			if($inquiry)$inquiry='ご質問など
'.$inquiry;
			$sendmail =$sendmail_i;
			$title    = '【エディブロ・ケータイ版】 '.$name_kj_1.' '.$name_kj_2.' 様からの資料請求';
			$ml_body  =
$mail_finding.'

━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━
学習塾専用ホームページ「Edyblo」（エディブロ）のケータイ版
に公開している貴塾のページに
お客様より下記内容のお問い合わせがありました。
ご確認の上、ご対応をお願いいたします。
━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━

'.$inquiry.'
'.$message2.'
'.$message4;
			break;
}
//$sendmail ="hatori@ns.sp-jobnet.co.jp" ;
//'.$message1.'

function esc1 ($st){
$str= $st;		  
$str = stripslashes($str);
$str = preg_replace("/,/","",$str);
return $str;
}

$mailtype =esc1($mailtype);
$title    =esc1($title);
$ml_body  =esc1($ml_body);

$result=fnc_send_mail( $mailtype , $sendmail , $title , $ml_body );


?>


