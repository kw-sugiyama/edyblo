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

//�����ѡ��Уϣӣ԰��Ϥ�
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

//�������� ���䤤��碌��
$sendmail_i=$mail_info;

if(!$mail_info2==""){
	 $sendmail_i .=",";
	 $sendmail_i .=$mail_info2;
}

if (isset($_SESSION['ticket'], $_POST['ticket']) && $_SESSION['ticket'] === $_POST['ticket']) 

	unset($_SESSION['ticket']);

	//ǯ��׻�
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
		$age_check[7] ='�Ҳ��';
		$age_icon[7]  ='<img src="./share/icons/icon_b_18.gif" alt="" />';
		$age_of-=64;
	}
	if(($age_of & 32) ==32){
		$age_check[6] ='�������';
		$age_icon[6]  ='<img src="./share/icons/icon_b_5.gif" alt="" />��';
		$age_of-=32;
	}
	if(($age_of & 16) ==16){
		$age_check[5] ='ϲ������';
		$age_icon[5]  ='<img src="./share/icons/icon_b_13.gif" alt="" />��';
		$age_of-=16;
	}
	if(($age_of & 8)  ==8){
		$age_check[4] ='�⹻����';
		$age_icon[4]  ='<img src="./share/icons/icon_b_11.gif" alt="" />��';
		$age_of-=8;
	}
	if(($age_of & 4)  ==4){
		$age_check[3] ='�������';
		$age_icon[3]  ='<img src="./share/icons/icon_b_3.gif" alt="" />��';
		$age_of-=4;
	}
	if(($age_of & 2)  ==2){
		$age_check[2] ='��������';
		$age_icon[2]  ='<img src="./share/icons/icon_b_15.gif" alt="" />��';
		$age_of-=2;
	}
	if(($age_of & 1)  ==1){
		$age_check[1] ='�Ļ���';
		$age_icon[1]  ='<img src="./share/icons/icon_b_19.gif" alt="" />��';
		$age_of-=1;
	}
	ksort($age_check);
	foreach($age_check as $val){
		$age_list.=$val;
	}

$mail_finding=$arrMetaHeader['title_corp']."������";

//��ǯ
foreach($param_inq_gakunen["val"] as $key => $val) {
	if ($gakunen == ""){
		$gakunen_disp .= '';
	}else if ($gakunen==$key) {
		$gakunen_disp .= $val;
	} else {
		$gakunen_disp .= '';
	}
}

	$message1='������礻����
';
	if($report1)$message1.='��'.$report1.'
';
	if($report2)$message1.='��'.$report2.'
';
	if($report3)$message1.='��'.$report3.'
';
	if($report4)$message1.='��'.$report4.'
'.$etc.'
';

//��ǯ
$str_gakunen = "";
if ($gakunen_disp       != "" && $gakunen_text != ""){
$str_gakunen = '��ǯ������������������'.$gakunen_disp.'��'.$gakunen_text.'
';
}else if ($gakunen_disp != "" && $gakunen_text == ""){
$str_gakunen = '��ǯ������������������'.$gakunen_disp.'
';
}else if ($gakunen_disp == "" && $gakunen_text != ""){
$str_gakunen = '��ǯ������������������'.$gakunen_text.'
';
}

//�ع�
$str_gakkou = "";
if ($type != "" && $school != ""){
$str_gakkou = '�ع�̾����������������'.$type.' Ω '.$school.'
';
}else if ($type != "" && $school == ""){
$str_gakkou = '�ع�̾����������������'.$type.'
';
}else if ($type == "" && $school != ""){
$str_gakkou = '�ع�̾����������������'.$school.'
';
}

$yuubin ='͹���ֹ桧������������'.$addr_cd_1.'
		  ';
//message2���������===================================================
	$message2='
�������;���
�ݸ�Ի�̾(����)������'.$name_kj_1.'��'.$name_kj_2.'
�ݸ�Ի�̾(�եꥬ��)��'.$name_kn_1.'��'.$name_kn_2.'
�����ͻ�̾(����)������'.$kidsname_kj_1.'��'.$kidsname_kj_2.'
�����ͻ�̾(�եꥬ��)��'.$kidsname_kn_1.'��'.$kidsname_kn_2.'
���̡�����������������'.$sex.'
'.$str_gakunen.$str_gakkou.$yuubin.'
';
	if($pref && $city && $add)$message2.='���ꡧ����������������'.$pref.$city.$add.$Buil.'
';

//��ǯ������������������'.$year.'ǯ'.$month.'��'.$day.'��
//ǯ�𡧡���������������'.$age.'
	if($tel){
		$message2.='�����ֹ桧������������'.$tel.'
';
		$telno='
���������ֹ桧'.$tel;
	}
	if($ctel){
		$message2.='�����ֹ桧������������'.$ctel.'
';
		$telno.='
���������ֹ桧'.$ctel;
	}
	if($mail){
		$message2.='�᡼�륢�ɥ쥹��������'.$mail.'
';
	}
//message3���������==================================================
//	$message3='Ϣ����ˡ:
//';
//	if($demand1)$message3.='��'.$demand1.'
//';//���������դ����ߤ���
//	if($demand2)$message3.='��'.$demand2.$telno.'
//';//�ܺ٤��Τꤿ���Τ����ä����ߤ���
//	if($demand3)$message3.='��'.$demand3.'
//';//�ܺ٤��Τꤿ���Τ�ˬ�䤷����
//	if($demand4)$message3.='��'.$demand4.'
//�᡼�륢�ɥ쥹��'.$mail.'
//';//�������Ƥ��������ߤ���
//=====================================================================
	$message4='
����ա�
�Ŀ;����ݸ�˴ؤ����갷���Ͻ�ʬ��դ���褦���ꤤ���ޤ���

�����������ʤɤ������ޤ����顢�����ޤǤ���礻��������

��������������������������������������������������������
�ؽ������ѥۡ���ڡ�����Edyblo�סʥ��ǥ��֥��
�����ġ�������ҥΥ���
����160-0023������Կ��ɶ�������7-11-3��ʿ�ĥӥ�2F
��TEL��03-5332-6124����FAX��03-5332-6125
�����䤤��碌��support@jukutown.com
��������������������������������������������������������
';

//����
if($publishing){
	$cam_publishing='
����������������������'.$publishing;
	$cs_publishing='
����������������'.$publishing;
}

//switch�ˤ��ʬ��

$mailtype="REQUEST";
switch ($mailtype) {
	
		//��������
		case "REQUEST":
			$html_title='��������';
			if($inquiry)$inquiry='������ʤ�
'.$inquiry;
			$sendmail =$sendmail_i;
			$title    = '�ڥ��ǥ��֥����������ǡ� '.$name_kj_1.' '.$name_kj_2.' �ͤ���λ�������';
			$ml_body  =
$mail_finding.'

��������������������������������������������������������������
�ؽ������ѥۡ���ڡ�����Edyblo�סʥ��ǥ��֥�ˤΥ���������
�˸������Ƥ��뵮�ΤΥڡ�����
�����ͤ�겼�����ƤΤ��䤤��碌������ޤ�����
����ǧ�ξ塢���б��򤪴ꤤ�������ޤ���
��������������������������������������������������������������

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


