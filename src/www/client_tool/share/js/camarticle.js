/*==================================================
    �֥����ܾ�����Ͽ���������ϥ����å�
==================================================*/
function CamarticleInputCheck( parts , parts2 )
{

	// ����
	intChk_bd = 9;
	intCnt_bd = parts.elements["ca_stat"].length;
	for( ix=0; ix<intCnt_bd; ix++ )
	{
		if( parts.elements["ca_stat"][ix].checked ){
			intChk_bd = 1;
		}
	}
	if( intChk_bd != 1 ){
		alert("���֤���ꤷ�Ʋ�������");
		parts.elements["ca_stat"][0].focus();
		return false;
	}

	// �����ȥ�
	if( parts.ca_title.value == "" ){
		alert("�����ȥ�����Ϥ��Ʋ�������");
		parts.ca_title.focus();
		return false;
	} else {
		if( ! SpaceCheck( parts.ca_title.value ) ) {
			alert("�����ȥ�ϥ��ڡ����Τߤ���Ͽ������ޤ���");
			parts.ca_title.focus();
			return false;
		}
	}

	// ɽ����
	if( parts.ca_dispno.value == "" ){
		alert("ɽ��������Ϥ��Ʋ�������");
		parts.ca_dispno.focus();
		return false;
	} else if( !IntValCheck( parts.ca_dispno.value ) ) {
		alert("ɽ�����Ⱦ�ѿ��������Ϥ��Ƥ���������");
		parts.ca_dispno.focus();
		return false;
	}
	
	// ����
	if( parts.ca_contents.value == "" ){
		alert("���Ƥ����Ϥ��Ʋ�������");
		parts.ca_contents.focus();
		return false;
	} else {
		if( ! SpaceCheck( parts.ca_contents.value ) ) {
			alert("���Ƥϥ��ڡ����Τߤ���Ͽ������ޤ���");
			parts.ca_contents.focus();
			return false;
		}
	}

	// ��Ͽ��ǧ
	ret_com = confirm("��Ͽ���������ޤ���������Ǥ�����");
	if( !ret_com ){
		return false;
	}
	
	parts2.submit();
	return true;
	
}


/*==================================================
    �֥����ܾ�����Ͽ���������ϥ����å�
==================================================*/
function DiaryDeleteCheck( parts , parts2 )
{
	
	ret_com = confirm("������ޤ���������Ǥ�����");
	if ( !ret_com ) {
		return false;
	}
	
	parts.submit();
	return true;
}


/*==================================================
    �ե������������طʿ����Ѥ���
==================================================*/
function Text( id , flag ){
	if(document.all){
		object = document.all(id).style;
	}else if(document.getElementById){
		object = document.getElementById(id).style;
	}else{
		return;
	}
	if(flag == 1){
		object.background = "#FFFFCC";
		object.color = "black";
	}else if(flag == 2){
		object.background = "white";
		object.color = "black";
	}
}
