<?
if(isset($_POST)){
	extract($_POST);
}

if($_SESSION['reload']!=1 && !isset( $_POST['year']) ){
	require_once( SYS_PATH."templates/error_all.tpl" );
	exit;
}
$category_title=$title;

//当て先追加

$mail_entry =$obj_login->clientdat[0]['sc_entrymail'];
$mail_entry2=$obj_login->clientdat[0]['sc_entrymail2'];

$mail_info  =$obj_login->clientdat[0]['sc_infomail'];
$mail_info2 =$obj_login->clientdat[0]['sc_infomail2'];


//お申し込み用
$sendmail_e=$mail_entry;

if(!$mail_entry2==""){
	 $sendmail_e .=",";
	 $sendmail_e .=$mail_entry2;
}
//echo $sendmail_e;

//資料請求 お問い合わせ用
$sendmail_i=$mail_info;

if(!$mail_info2==""){
	 $sendmail_i .=",";
	 $sendmail_i .=$mail_info2;
}

//echo $sendmail_i;
//echo $sendmail_e;


//print_r($obj_login->clientdat[0]);

if (isset($_SESSION['ticket'], $_POST['ticket']) && $_SESSION['ticket'] === $_POST['ticket']) {
	unset($_SESSION['ticket']);

	//年齢計算
	if( $year != "" && $month != "" && $day != "" ){
		//月と日を0埋め二桁にする
		$month= sprintf('%02d',$month);
		$day= sprintf('%02d',$day);
		//年月日を結合
		$birth=$year.$month.$day;
		//現在年月日からマイナスし、10000で割り小数点以下切り捨てで年齢を算出
		$age=(int)((date('Ymd')-$birth)/10000);
	}else{
		$year = "----";
		$month = "--";
		$day = "--";
		$age ="--";
	}

	$age_check=array();
	$age_list="";
	if(($age_of & 64)==64){
		$age_check[7]='社会人';
		$age_icon[7]='<img src="./share/icons/icon_b_18.gif" alt="" />';
		$age_of-=64;
	}
	if(($age_of & 32)==32){
		$age_check[6]='大学生　';
		$age_icon[6]='<img src="./share/icons/icon_b_5.gif" alt="" />　';
		$age_of-=32;
	}
	if(($age_of & 16)==16){
		$age_check[5]='浪人生　';
		$age_icon[5]='<img src="./share/icons/icon_b_13.gif" alt="" />　';
		$age_of-=16;
	}
	if(($age_of & 8)==8){
		$age_check[4]='高校　';
		$age_icon[4]='<img src="./share/icons/icon_b_11.gif" alt="" />　';
		$age_of-=8;
	}
	if(($age_of & 4)==4){
		$age_check[3]='中学生　';
		$age_icon[3]='<img src="./share/icons/icon_b_3.gif" alt="" />　';
		$age_of-=4;
	}
	if(($age_of & 2)==2){
		$age_check[2]='小学生　';
		$age_icon[2]='<img src="./share/icons/icon_b_15.gif" alt="" />　';
		$age_of-=2;
	}
	if(($age_of & 1)==1){
		$age_check[1]='幼児　';
		$age_icon[1]='<img src="./share/icons/icon_b_19.gif" alt="" />　';
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
if ($gakunen_disp != "" && $gakunen_text != ""){
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

	$message2='
■お客様情報
保護者氏名(漢字)：　　'.$name_kj_1.'　'.$name_kj_2.'
保護者氏名(フリガナ)：'.$name_kn_1.'　'.$name_kn_2.'

お子様氏名(漢字)：　　'.$kidsname_kj_1.'　'.$kidsname_kj_2.'
お子様氏名(フリガナ)：'.$kidsname_kn_1.'　'.$kidsname_kn_2.'
性別：　　　　　　　　'.$sex.'
生年月日：　　　　　　'.$year.'年'.$month.'月'.$day.'日
年齢：　　　　　　　　'.$age.'
'.$str_gakunen.$str_gakkou.'
';

	if( $addr_cd_1 && $addr_cd_2 ){
		$message2.='郵便番号：　　　　　　'.$addr_cd_1.'-'.$addr_cd_2.'
';
	}

	if($pref && $city && $add){
		$message2.='住所：　　　　　　　　'.$pref.$city.$add.$Buil.'
';
	}
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
	$message3='連絡方法:
';
	if($demand1)$message3.='・'.$demand1.'
';//資料を送付して欲しい

	if($demand2)$message3.='・'.$demand2.$telno.'
';//詳細を知りたいので電話して欲しい

	if($demand3)$message3.='・'.$demand3.'
';//詳細を知りたいので訪問したい

	if($demand4)$message3.='・'.$demand4.'
　　メールアドレス：'.$mail.'
';//質問内容に答えて欲しい

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

	switch ($mailtype) {
	
		//問い合わせ
		case "INQUIRY":
			$html_title='お問い合わせ';
			if($inquiry)$inquiry='ご質問内容
'.$inquiry;
			$sendmail=$sendmail_i;
			$title = '【エディブロ】 '.$name_kj_1.' '.$name_kj_2.' 様からのお問い合わせ';
			$ml_body=
$mail_finding.'

━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━
学習塾専用ホームページ「Edyblo」（エディブロ）に公開している
貴社のページに
お客様より下記内容のお問い合わせがありました。
ご確認の上、ご対応をお願いいたします。
━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━

'.$message1.'
'.$inquiry.'
'.$message2.'
'.$message3.'
'.$message4;
			break;
			
		//イベント申し込み
		case "APPLICATE":
			$html_title=$category_title.'へのお申し込み';
			if($inquiry)$inquiry='コメント欄
'.$inquiry;
			$sendmail =$sendmail_e;
			$title = '【エディブロ】 '.$name_kj_1.' '.$name_kj_2.' 様からのイベントお申し込み';
			$ml_body=
$mail_finding.'

━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━
学習塾専用ホームページ「Edyblo」（エディブロ）に公開している
貴社のページに
お客様より下記内容のイベントお申し込みがありました。
ご確認の上、ご対応をお願いいたします。
━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━

■申込み対象イベント情報
キャンペーンタイトル：'.$category_title.'
対象　　　　　　　　：'.$age_list.$cam_publishing.'
URL　　　　　　　　 ：'.$url.'
'.$message1.'
'.$inquiry.'
'.$message2.'
'.$message4;
			break;
			
		//イベント問い合せ
		case "CAMPAIGN":
			$html_title=$category_title.'へのお問い合わせ';
			if($inquiry)$inquiry='ご質問内容
'.$inquiry;
			$sendmail =$sendmail_i;
			$title = '【エディブロ】 '.$name_kj_1.' '.$name_kj_2.' 様からのイベントお問い合わせ';
			$ml_body=
$mail_finding.'

━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━
学習塾専用ホームページ「Edyblo」（エディブロ）に公開している
貴社のページに
お客様より下記内容のイベントお問い合わせがありました。
ご確認の上、ご対応をお願いいたします。
━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━

■お問い合わせ対象イベント情報
キャンペーンタイトル：'.$category_title.'
対象　　　　　　　　：'.$age_list.$cam_publishing.'
URL　　　　　　　　 ：'.$url.'
'.$message1.'
'.$inquiry.'
'.$message2.'
'.$message3.'
'.$message4;
			break;
			
		//コース問い合せ
		case "COURSEINQ":
			$html_title=$category_title.'へのお問い合わせ';
			if($inquiry)$inquiry='お問い合わせ内容
'.$inquiry;
			$sendmail =$sendmail_i;
			$title = '【エディブロ】 '.$name_kj_1.' '.$name_kj_2.' 様からのコースお問い合わせ';
			$ml_body=
$mail_finding.'

━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━
学習塾専用ホームページ「Edyblo」（エディブロ）に公開している
貴社のページに
お客様より下記内容のコースお問い合わせがありました。
ご確認の上、ご対応をお願いいたします。
━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━

■お問い合わせ対象コース情報
コースタイトル：'.$category_title.'
対象　　　　　：'.$age_list.$cs_publishing.'
URL　　　　　 ：'.$url.'
'.$message1.'
'.$inquiry.'
'.$message2.'
'.$message3.'
'.$message4;
			break;
			
		//コース資料請求
		case "COURSEREQ":
			$html_title=$category_title.'の資料請求';
			if($inquiry)$inquiry='ご質問など
'.$inquiry;
			$sendmail =$sendmail_i;
			$title = '【エディブロ】 '.$name_kj_1.' '.$name_kj_2.' 様からのコース資料請求';
			$ml_body=
$mail_finding.'

━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━
学習塾専用ホームページ「Edyblo」（エディブロ）に公開している
貴社のページに
お客様より下記内容のコース資料請求がありました。
ご確認の上、ご対応をお願いいたします。
━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━

■資料請求対象コース情報
コースタイトル：'.$category_title.'
対象　　　　　：'.$age_list.$cs_publishing.'
URL　　　　　 ：'.$url.'
'.$message1.'
'.$inquiry.'
'.$message2.'
'.$message4;
			break;
			
		//資料請求
		case "REQUEST":
			$html_title='資料請求';
			if($inquiry)$inquiry='ご質問など
'.$inquiry;
			$sendmail =$sendmail_i;
			$title = '【エディブロ】 '.$name_kj_1.' '.$name_kj_2.' 様からの資料請求';
			$ml_body=
$mail_finding.'

━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━
学習塾専用ホームページ「Edyblo」（エディブロ）に公開している
貴社のページに
お客様より下記内容の資料請求がありました。
ご確認の上、ご対応をお願いいたします。
━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━

'.$message1.'
'.$inquiry.'
'.$message2.'
'.$message4;
			break;
			
			
	}

//$sendmail="hatori@ns.sp-jobnet.co.jp";

//echo $sendmail;

if($Identification===$_SESSION['Identification']){
		$result=fnc_send_mail( $mailtype , $sendmail , $title , $ml_body );
		unset($_SESSION);
		session_start();
		$_SESSION['reload']=1;
		session_write_close();
	}
}
?>
