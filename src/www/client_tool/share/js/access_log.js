/*==================================================
    ������������ - ���ջ�������å�
==================================================*/
function AccessSelCheck( parts )
{
	
	// ���ջ���(ǯ)
	if( parts.sea_date_y.value == "" ){
		alert("�����������Ϥ�Ԥ�����(ǯ)����ꤷ�Ʋ�����");
		parts.sea_date_y.focus();
		return false;
	}
	
	// ���ջ���(��)
	if( parts.sea_date_m.value == "" ){
		alert("�����������Ϥ�Ԥ�����(��)����ꤷ�Ʋ�����");
		parts.sea_date_m.focus();
		return false;
	}
	
	// ���ջ���(��)
	if( parts.sea_date_d.value == "" ){
		alert("�����������Ϥ�Ԥ�����(��)����ꤷ�Ʋ�����");
		parts.sea_date_d.focus();
		return false;
	}
	
	// ���������������å�
	var strDate = parts.sea_date_y.value+'-'+parts.sea_date_m.value+'-'+parts.sea_date_d.value;
	if ( ! DateCheck_1( strDate ) ) {
		alert("���ꤵ�줿���դ�ͭ���ǤϤ���ޤ���");
		parts.sea_date_y.focus();
		return false;
	}
	
	parts.submit();
	
	return true;
	
}


