<?
/*=================================================================
    ����礻�᡼����������
=================================================================*/

require_once( SYS_PATH."common/common_mail.php" );


// �᡼�륿���ȥ�
$strBuffMailTitle = "";
$strBuffMailTitle = "����ư���֥�REBLO��".$arrInputData["name_kj_1"].$arrInputData["name_kj_2"]."�ͤ����ʪ�浪�䤤��碌";

// �᡼������
$strBuffMailContents = "";
$strBuffMailContents .= $obj_login->clientdat[0]['cl_name']."��".$obj_login->clientdat[0]['cl_shiten']."������\n\n";
$strBuffMailContents .= "������������������������������������������������������\n";
$strBuffMailContents .= "��ư���֥�REBLO�ʥ�֥�ˤ˸������Ƥ��뵮�Ҥ�ʪ������\n";
$strBuffMailContents .= "�����ͤ�겼�����ƤΤ���礻������ޤ�����������ǧ�ξ塢\n";
$strBuffMailContents .= "���б��򤪴ꤤ�������ޤ���\n";
$strBuffMailContents .= "������������������������������������������������������\n";

$strBuffMailContents .= "������礻ʪ��\n";
$strBuffMailContents .= $strMailRoomList;

$strBuffMailContents .= "������礻����\n";
FOREACH( $_POST["question"] as $key => $val ){
	reset( $param_applicate_question["disp_no"] );
	asort( $param_applicate_question["disp_no"] );
	FOREACH( $param_applicate_question["disp_no"] as $key2 => $val2 ){
		IF( $val == $param_applicate_question["id"][$key2] ){
			$strBuffMailContents .= "��".$param_applicate_question["val"][$key2]."\n";
			break;
		}
	}
}
IF( $arrInputData["question_other"] != "" ){
	$strBuffMailContents .= str_replace( "\n\n" , "\n" , str_replace( "\r" , "\n" , $arrInputData["question_other"] ) )."\n";
}
$strBuffMailContents .= "\n";
$strBuffMailContents .= "�������;���\n";
$strBuffMailContents .= "��̾(����)������".$arrInputData["name_kj_1"]."��".$arrInputData["name_kj_2"]."\n";
$strBuffMailContents .= "��̾(�եꥬ��)������".$arrInputData["name_kn_1"]."��".$arrInputData["name_kn_2"]."\n";
IF( $arrInputData["sex"] == 1 ){
	$strBuffMailContents .= "���̡���������\n";
}ELSEIF( $arrInputData["sex"] == 2 ){
	$strBuffMailContents .= "���̡���������\n";
}ELSE{
	$strBuffMailContents .= "���̡�\n";
}
IF( $arrInputData["old"] != "" ){
	$strBuffMailContents .= "ǯ�𡧡���".$arrInputData["old"]." ��\n";
}ELSE{
	$strBuffMailContents .= "ǯ��\n";
}
$intBuffContFlg = 9;
FOREACH( $param_inquiry_work["disp_no"] as $key => $val ){
	IF( $arrInputData["work_kind"] == $param_inquiry_work["id"][$key] ){
		$strBuffMailContents .= "���ȡ�����".$param_inquiry_work["val"][$key]."\n";
		$intBuffContFlg = 1;
		break;
	}
}
IF( $intBuffContFlg == 9 ){
	$strBuffMailContents .= "���ȡ�\n";
}
$strBuffMailContents .= "Ϣ����ˡ:\n";
IF( $arrInputData["report_type_1"] == 1 ){
	$strBuffMailContents .= "�������äǤ�Ϣ��\n";
	$strBuffMailContents .= "����".$arrInputData["tell_1"]."-".$arrInputData["tell_2"]."-".$arrInputData["tell_3"]."\n";
	$strBuffMailContents .= "����(Ϣ����˾�λ�����:".$arrInputData["tell_time"].")\n";
}
IF( $arrInputData["report_type_2"] == 2 ){
	$strBuffMailContents .= "����FAX�Ǥ�Ϣ��\n";
	$strBuffMailContents .= "����".$arrInputData["fax_1"]."-".$arrInputData["fax_2"]."-".$arrInputData["fax_3"]."\n";
}
IF( $arrInputData["report_type_3"] == 3 ){
	$strBuffMailContents .= "����͹���Ǥ�Ϣ��\n";
	$strBuffMailContents .= "������".$arrInputData["addr_cd_1"]."-".$arrInputData["addr_cd_2"]."\n";
	$strBuffMailContents .= "����".$arrInputData["address_1"]."��".$arrInputData["address_2"]."\n";
}
IF( $arrInputData["report_type_4"] == 4 ){
	$strBuffMailContents .= "�����ť᡼��Ǥ�Ϣ��\n";
	$strBuffMailContents .= "����".$arrInputData["email"]."\n";
}

$strBuffMailContents .= " \n";
$strBuffMailContents .= "����ա�\n";
$strBuffMailContents .= "�Ŀ;����ݸ�˴ؤ����갷���Ͻ�ʬ��դ���褦���� �����ޤ���\n\n";
$strBuffMailContents .= "�����������ʤɤ������ޤ����顢�����ޤǤ���礻��������\n";
$strBuffMailContents .= "������������������������������������������������\n";
$strBuffMailContents .= "����ư���֥������ƥࡦREBLO�ʥ�֥��\n";
$strBuffMailContents .= "�����ġ�����å���������\n";
$strBuffMailContents .= "��TEL  03-5772-7710����FAX  03-5772-7720\n";
$strBuffMailContents .= "���ʼ��ջ��֡�ʿ��������������������������\n";
$strBuffMailContents .= "��mailto:support@reblo.net\n";
$strBuffMailContents .= "��REBLO�ʥ�֥�˥ݡ�����\n";
$strBuffMailContents .= "��http://www.reblo.net\n";
$strBuffMailContents .= "������������������������������������������������\n";


// �᡼����������
$ret_mail = fnc_send_mail( "APPLICATE" , $obj_login->clientdat[0]["blog_entry_mail"] , $strBuffMailTitle , $strBuffMailContents );
IF( $ret_mail != 1 ){
	$obj_error->ViewErrMessage( "MENT" , "USER" , _BLOG_SITE_URL_BASE , $arrErr );
	exit;
}

?>
