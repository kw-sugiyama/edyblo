/*==================================================
    �֥����ܾ�����Ͽ���������ϥ����å�
==================================================*/
function ArticleInputCheck( parts , parts2 )
{

	// ����
	intChk_bd = 9;
	intCnt_bd = parts.elements["ac_stat"].length;
	for( ix=0; ix<intCnt_bd; ix++ )
	{
		if( parts.elements["ac_stat"][ix].checked ){
			intChk_bd = 1;
		}
	}
	if( intChk_bd != 1 ){
		alert("���֤���ꤷ�Ʋ�������");
		parts.elements["ac_stat"][0].focus();
		return false;
	}

	// ���ƥ���
	if ( parts.ac_cateid.value == "" ) {
		alert("���ƥ�������򤷤Ʋ�������");
		parts.ac_cateid.focus();
		return false;
	}

	// �����ȥ�
	if( parts.ac_title.value == "" ){
		alert("�����ȥ�����Ϥ��Ʋ�������");
		parts.ac_title.focus();
		return false;
	} else {
		if( ! SpaceCheck( parts.ac_title.value ) ) {
			alert("�����ȥ�ϥ��ڡ����Τߤ���Ͽ������ޤ���");
			parts.ac_title.focus();
			return false;
		}
	}

	// ɽ����
	if( parts.ac_dispno.value == "" ){
		alert("ɽ��������Ϥ��Ʋ�������");
		parts.ac_dispno.focus();
		return false;
	} else if( !IntValCheck( parts.ac_dispno.value ) ) {
		alert("ɽ�����Ⱦ�ѿ��������Ϥ��Ƥ���������");
		parts.ac_dispno.focus();
		return false;
	}
	
	// ����
	if( parts.ac_contents.value == "" ){
		alert("���Ƥ����Ϥ��Ʋ�������");
		parts.ac_contents.focus();
		return false;
	} else {
		if( ! SpaceCheck( parts.ac_contents.value ) ) {
			alert("���Ƥϥ��ڡ����Τߤ���Ͽ������ޤ���");
			parts.ac_contents.focus();
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
