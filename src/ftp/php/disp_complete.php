<?
if(isset($_POST)){
	extract($_POST);
}

if($_SESSION['reload']!=1 && !isset( $_POST['year']) ){
	require_once( SYS_PATH."templates/error_all.tpl" );
	exit;
}
$category_title=$title;

//�������ɲ�

$mail_entry =$obj_login->clientdat[0]['sc_entrymail'];
$mail_entry2=$obj_login->clientdat[0]['sc_entrymail2'];

$mail_info  =$obj_login->clientdat[0]['sc_infomail'];
$mail_info2 =$obj_login->clientdat[0]['sc_infomail2'];


//������������
$sendmail_e=$mail_entry;

if(!$mail_entry2==""){
	 $sendmail_e .=",";
	 $sendmail_e .=$mail_entry2;
}
//echo $sendmail_e;

//�������� ���䤤��碌��
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

	//ǯ��׻�
	if( $year != "" && $month != "" && $day != "" ){
		//�������0������ˤ���
		$month= sprintf('%02d',$month);
		$day= sprintf('%02d',$day);
		//ǯ��������
		$birth=$year.$month.$day;
		//����ǯ��������ޥ��ʥ�����10000�ǳ�꾮�����ʲ��ڤ�ΤƤ�ǯ��򻻽�
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
		$age_check[7]='�Ҳ��';
		$age_icon[7]='<img src="./share/icons/icon_b_18.gif" alt="" />';
		$age_of-=64;
	}
	if(($age_of & 32)==32){
		$age_check[6]='�������';
		$age_icon[6]='<img src="./share/icons/icon_b_5.gif" alt="" />��';
		$age_of-=32;
	}
	if(($age_of & 16)==16){
		$age_check[5]='ϲ������';
		$age_icon[5]='<img src="./share/icons/icon_b_13.gif" alt="" />��';
		$age_of-=16;
	}
	if(($age_of & 8)==8){
		$age_check[4]='�⹻��';
		$age_icon[4]='<img src="./share/icons/icon_b_11.gif" alt="" />��';
		$age_of-=8;
	}
	if(($age_of & 4)==4){
		$age_check[3]='�������';
		$age_icon[3]='<img src="./share/icons/icon_b_3.gif" alt="" />��';
		$age_of-=4;
	}
	if(($age_of & 2)==2){
		$age_check[2]='��������';
		$age_icon[2]='<img src="./share/icons/icon_b_15.gif" alt="" />��';
		$age_of-=2;
	}
	if(($age_of & 1)==1){
		$age_check[1]='�Ļ���';
		$age_icon[1]='<img src="./share/icons/icon_b_19.gif" alt="" />��';
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
if ($gakunen_disp != "" && $gakunen_text != ""){
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

	$message2='
�������;���
�ݸ�Ի�̾(����)������'.$name_kj_1.'��'.$name_kj_2.'
�ݸ�Ի�̾(�եꥬ��)��'.$name_kn_1.'��'.$name_kn_2.'

�����ͻ�̾(����)������'.$kidsname_kj_1.'��'.$kidsname_kj_2.'
�����ͻ�̾(�եꥬ��)��'.$kidsname_kn_1.'��'.$kidsname_kn_2.'
���̡�����������������'.$sex.'
��ǯ������������������'.$year.'ǯ'.$month.'��'.$day.'��
ǯ�𡧡���������������'.$age.'
'.$str_gakunen.$str_gakkou.'
';

	if( $addr_cd_1 && $addr_cd_2 ){
		$message2.='͹���ֹ桧������������'.$addr_cd_1.'-'.$addr_cd_2.'
';
	}

	if($pref && $city && $add){
		$message2.='���ꡧ����������������'.$pref.$city.$add.$Buil.'
';
	}
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
	$message3='Ϣ����ˡ:
';
	if($demand1)$message3.='��'.$demand1.'
';//���������դ����ߤ���

	if($demand2)$message3.='��'.$demand2.$telno.'
';//�ܺ٤��Τꤿ���Τ����ä����ߤ���

	if($demand3)$message3.='��'.$demand3.'
';//�ܺ٤��Τꤿ���Τ�ˬ�䤷����

	if($demand4)$message3.='��'.$demand4.'
�����᡼�륢�ɥ쥹��'.$mail.'
';//�������Ƥ��������ߤ���

	$message4='
�����ա�
�Ŀ;����ݸ�˴ؤ����갷���Ͻ�ʬ���դ���褦���ꤤ���ޤ���

�����������ʤɤ������ޤ����顢�����ޤǤ���礻��������

��������������������������������������������������������
�ؽ������ѥۡ���ڡ�����Edyblo�סʥ��ǥ��֥���
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

	switch ($mailtype) {
	
		//�䤤��碌
		case "INQUIRY":
			$html_title='���䤤��碌';
			if($inquiry)$inquiry='����������
'.$inquiry;
			$sendmail=$sendmail_i;
			$title = '�ڥ��ǥ��֥��� '.$name_kj_1.' '.$name_kj_2.' �ͤ���Τ��䤤��碌';
			$ml_body=
$mail_finding.'

��������������������������������������������������������������
�ؽ������ѥۡ���ڡ�����Edyblo�סʥ��ǥ��֥��ˤ˸������Ƥ���
���ҤΥڡ�����
�����ͤ�겼�����ƤΤ��䤤��碌������ޤ�����
����ǧ�ξ塢���б��򤪴ꤤ�������ޤ���
��������������������������������������������������������������

'.$message1.'
'.$inquiry.'
'.$message2.'
'.$message3.'
'.$message4;
			break;
			
		//���٥�ȿ�������
		case "APPLICATE":
			$html_title=$category_title.'�ؤΤ���������';
			if($inquiry)$inquiry='��������
'.$inquiry;
			$sendmail =$sendmail_e;
			$title = '�ڥ��ǥ��֥��� '.$name_kj_1.' '.$name_kj_2.' �ͤ���Υ��٥�Ȥ���������';
			$ml_body=
$mail_finding.'

��������������������������������������������������������������
�ؽ������ѥۡ���ڡ�����Edyblo�סʥ��ǥ��֥��ˤ˸������Ƥ���
���ҤΥڡ�����
�����ͤ�겼�����ƤΥ��٥�Ȥ��������ߤ�����ޤ�����
����ǧ�ξ塢���б��򤪴ꤤ�������ޤ���
��������������������������������������������������������������

���������оݥ��٥�Ⱦ���
�����ڡ��󥿥��ȥ롧'.$category_title.'
�оݡ�����������������'.$age_list.$cam_publishing.'
URL���������������� ��'.$url.'
'.$message1.'
'.$inquiry.'
'.$message2.'
'.$message4;
			break;
			
		//���٥���䤤�礻
		case "CAMPAIGN":
			$html_title=$category_title.'�ؤΤ��䤤��碌';
			if($inquiry)$inquiry='����������
'.$inquiry;
			$sendmail =$sendmail_i;
			$title = '�ڥ��ǥ��֥��� '.$name_kj_1.' '.$name_kj_2.' �ͤ���Υ��٥�Ȥ��䤤��碌';
			$ml_body=
$mail_finding.'

��������������������������������������������������������������
�ؽ������ѥۡ���ڡ�����Edyblo�סʥ��ǥ��֥��ˤ˸������Ƥ���
���ҤΥڡ�����
�����ͤ�겼�����ƤΥ��٥�Ȥ��䤤��碌������ޤ�����
����ǧ�ξ塢���б��򤪴ꤤ�������ޤ���
��������������������������������������������������������������

�����䤤��碌�оݥ��٥�Ⱦ���
�����ڡ��󥿥��ȥ롧'.$category_title.'
�оݡ�����������������'.$age_list.$cam_publishing.'
URL���������������� ��'.$url.'
'.$message1.'
'.$inquiry.'
'.$message2.'
'.$message3.'
'.$message4;
			break;
			
		//�������䤤�礻
		case "COURSEINQ":
			$html_title=$category_title.'�ؤΤ��䤤��碌';
			if($inquiry)$inquiry='���䤤��碌����
'.$inquiry;
			$sendmail =$sendmail_i;
			$title = '�ڥ��ǥ��֥��� '.$name_kj_1.' '.$name_kj_2.' �ͤ���Υ��������䤤��碌';
			$ml_body=
$mail_finding.'

��������������������������������������������������������������
�ؽ������ѥۡ���ڡ�����Edyblo�סʥ��ǥ��֥��ˤ˸������Ƥ���
���ҤΥڡ�����
�����ͤ�겼�����ƤΥ��������䤤��碌������ޤ�����
����ǧ�ξ塢���б��򤪴ꤤ�������ޤ���
��������������������������������������������������������������

�����䤤��碌�оݥ���������
�����������ȥ롧'.$category_title.'
�оݡ�����������'.$age_list.$cs_publishing.'
URL���������� ��'.$url.'
'.$message1.'
'.$inquiry.'
'.$message2.'
'.$message3.'
'.$message4;
			break;
			
		//��������������
		case "COURSEREQ":
			$html_title=$category_title.'�λ�������';
			if($inquiry)$inquiry='������ʤ�
'.$inquiry;
			$sendmail =$sendmail_i;
			$title = '�ڥ��ǥ��֥��� '.$name_kj_1.' '.$name_kj_2.' �ͤ���Υ�������������';
			$ml_body=
$mail_finding.'

��������������������������������������������������������������
�ؽ������ѥۡ���ڡ�����Edyblo�סʥ��ǥ��֥��ˤ˸������Ƥ���
���ҤΥڡ�����
�����ͤ�겼�����ƤΥ������������᤬����ޤ�����
����ǧ�ξ塢���б��򤪴ꤤ�������ޤ���
��������������������������������������������������������������

�����������оݥ���������
�����������ȥ롧'.$category_title.'
�оݡ�����������'.$age_list.$cs_publishing.'
URL���������� ��'.$url.'
'.$message1.'
'.$inquiry.'
'.$message2.'
'.$message4;
			break;
			
		//��������
		case "REQUEST":
			$html_title='��������';
			if($inquiry)$inquiry='������ʤ�
'.$inquiry;
			$sendmail =$sendmail_i;
			$title = '�ڥ��ǥ��֥��� '.$name_kj_1.' '.$name_kj_2.' �ͤ���λ�������';
			$ml_body=
$mail_finding.'

��������������������������������������������������������������
�ؽ������ѥۡ���ڡ�����Edyblo�סʥ��ǥ��֥��ˤ˸������Ƥ���
���ҤΥڡ�����
�����ͤ�겼�����Ƥλ������᤬����ޤ�����
����ǧ�ξ塢���б��򤪴ꤤ�������ޤ���
��������������������������������������������������������������

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