<?
/*=================================================================
    ����礻�᡼����������
=================================================================*/

require_once( SYS_PATH."common/common_mail.php" );


// �᡼�륿���ȥ�
$strBuffMailTitle = "";
$strBuffMailTitle = "����ư���֥�REBLO��".$arrRequestValue["name_kj_1"].$arrRequestValue["name_kj_2"]."�ͤ����ʪ��ꥯ������";

// �᡼������
$strBuffMailContents = "";
$strBuffMailContents .= $obj_login->clientdat[0]['cl_name']."��".$obj_login->clientdat[0]['cl_shiten']."������\n\n";
$strBuffMailContents .= "������������������������������������������������������\n";
$strBuffMailContents .= "��ư���֥�REBLO�ʥ�֥�ˤ�ʪ��ꥯ�����ȤΤ���礻��\n";
$strBuffMailContents .= "����ޤ�����������ǧ�ξ塢���б��򤪴ꤤ�������ޤ���\n";
$strBuffMailContents .= "������������������������������������������������������\n";

$strBuffMailContents .= " \n";
$strBuffMailContents .= "�������;���\n";
$strBuffMailContents .= "��̾(����)������".$arrRequestValue["name_kj_1"]."��".$arrRequestValue["name_kj_2"]."\n";
$strBuffMailContents .= "��̾(�եꥬ��)������".$arrRequestValue["name_kn_1"]."��".$arrRequestValue["name_kn_2"]."\n";
IF( $arrRequestValue["sex"] == 1 ){
	$strBuffMailContents .= "���̡���������\n";
}ELSEIF( $arrRequestValue["sex"] == 2 ){
	$strBuffMailContents .= "���̡���������\n";
}ELSE{
	$strBuffMailContents .= "���̡�\n";
}
IF( $arrRequestValue["old"] != "" ){
	$strBuffMailContents .= "ǯ�𡧡���".$arrRequestValue["old"]." ��\n";
}ELSE{
	$strBuffMailContents .= "ǯ��\n";
}
$intBuffContFlg = 9;
FOREACH( $param_inquiry_work["disp_no"] as $key => $val ){
	IF( $arrRequestValue["work"] == $param_inquiry_work["id"][$key] ){
		$strBuffMailContents .= "���ȡ�����".$param_inquiry_work["val"][$key]."\n";
		$intBuffContFlg = 1;
		break;
	}
}
IF( $intBuffContFlg == 9 ){
	$strBuffMailContents .= "���ȡ�\n";
}
$strBuffMailContents .= "Ϣ����ˡ:\n";
IF( $arrRequestValue["report_type_1"] == 1 ){
	$strBuffMailContents .= "�������äǤ�Ϣ��\n";
	$strBuffMailContents .= "����".$arrRequestValue["tell_1"]."-".$arrRequestValue["tell_2"]."-".$arrRequestValue["tell_3"]."\n";
	$strBuffMailContents .= "����(Ϣ����˾�λ�����:".$arrRequestValue["tell_time"].")\n";
}
IF( $arrRequestValue["report_type_2"] == 2 ){
	$strBuffMailContents .= "����FAX�Ǥ�Ϣ��\n";
	$strBuffMailContents .= "����".$arrRequestValue["fax_1"]."-".$arrRequestValue["fax_2"]."-".$arrRequestValue["fax_3"]."\n";
}
IF( $arrRequestValue["report_type_3"] == 3 ){
	$strBuffMailContents .= "����͹���Ǥ�Ϣ��\n";
	$strBuffMailContents .= "������".$arrRequestValue["addr_cd_1"]."-".$arrRequestValue["addr_cd_2"]."\n";
	$strBuffMailContents .= "����".$arrRequestValue["address_1"]."��".$arrRequestValue["address_2"]."\n";
}
IF( $arrRequestValue["report_type_4"] == 4 ){
	$strBuffMailContents .= "�����ť᡼��Ǥ�Ϣ��\n";
	$strBuffMailContents .= "����".$arrRequestValue["email"]."\n";
}
$strBuffMailContents .= "\n";
$strBuffMailContents .= "������礻����\n";
$strBuffMailContents .= "��̳�莥�̳���κǴ�ء�����".$arrRequestValue["station"]."\n";
$strBuffMailContents .= "��̳�莥�̳���ޤǤδ�˾���׻��֡�����".$request_move_time_value."\n";
$strBuffMailContents .= "��˾�α������ء�����".$arrRequestValue["line"]."\n";
$strBuffMailContents .= "��˾�Υ��ꥢ������".$arrRequestValue["area"]."\n";
$strBuffMailContents .= "��˾�β��¡�����".$request_price1_value." �� ".$request_price2_value."\n";
$strBuffMailContents .= "��˾�δּ�ꡧ����";
if(count($_POST["madori"]) != 0){
asort( $param_room_floor["disp_no"] );
	FOREACH( $param_room_floor["disp_no"] as $key => $val ){
		if(count($_POST["madori"]) != 0){
			foreach($_POST["madori"] as $key2 => $val2){
				if($param_room_floor['id'][$key] == $val2)$strBuffMailContents .= $param_room_floor['val'][$key]."��";

			}	
		}
	}
}
$strBuffMailContents .= "\n";
$strBuffMailContents .= "�Ż뤷�Ƥ��뤳�ȡ�\n";
if($arrRequestValue["equip1"]!="")$strBuffMailContents .= "���������ܤΤ���˾��".$arrRequestValue["equip1"]."\n";
if($arrRequestValue["equip2"]!="")$strBuffMailContents .= "���������ܤΤ���˾��".$arrRequestValue["equip2"]."\n";
if($arrRequestValue["equip3"]!="")$strBuffMailContents .= "���������ܤΤ���˾��".$arrRequestValue["equip3"]."\n";
if($arrRequestValue["equip4"]!="")$strBuffMailContents .= "���������ܤΤ���˾��".$arrRequestValue["equip4"]."\n";
if($arrRequestValue["equip5"]!="")$strBuffMailContents .= "���������ܤΤ���˾��".$arrRequestValue["equip5"]."\n";
$strBuffMailContents .= "����¾������ꡧ\n";
$strBuffMailContents .= $arrRequestValue["otherEquip"]."\n";
$strBuffMailContents .= "����ͽ�����������".$request_move_jiki_value."\n";
$strBuffMailContents .= "����ͽ��Ϳ�������".$request_menber_value."\n";
$strBuffMailContents .= "���ߤβ��¡�����".$request_now_price_value."\n";

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
$ret_mail = fnc_send_mail( "REQUEST" , $obj_login->clientdat[0]["blog_request_mail"] , $strBuffMailTitle , $strBuffMailContents );
IF( $ret_mail != 1 ){
	$obj_error->ViewErrMessage( "MENT" , "USER" , _BLOG_SITE_URL_BASE , $arrErr );
	exit;
}

?>
