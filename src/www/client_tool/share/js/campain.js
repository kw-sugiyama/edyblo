/*==================================================
    �֥����ܾ�����Ͽ���������ϥ����å�
==================================================*/
function CampainInputCheck( parts , parts2 )
{

	// ����
	intChk_bd = 9;
	intCnt_bd = parts.elements["cp_stat"].length;
	for( ix=0; ix<intCnt_bd; ix++ )
	{
		if( parts.elements["cp_stat"][ix].checked ){
			intChk_bd = 1;
		}
	}
	if( intChk_bd != 1 ){
		alert("���֤���ꤷ�Ʋ�������");
		parts.elements["cp_stat"][0].focus();
		return false;
	}

	// �ֻ�
	if( parts.cp_tccomment.value != "" ){
		if( ! SpaceCheck( parts.cp_tccomment.value ) ) {
			alert("�ֻե����Ȥϥ��ڡ����Τߤ���Ͽ������ޤ���");
			parts.cp_tccomment.focus();
			return false;
		}
	}
	if( parts.cp_tcid.value == "" && parts.cp_tccomment.value != "" ){
		alert("�ֻե����Ȥ����Ϥ��줿���Ϲֻդ����򤷤Ʋ�������");
		parts.cp_tcid.focus();
		return false;
	}
	if( parts.cp_tcid.value != "" && parts.cp_tccomment.value == "" ){
		alert("�ֻդ����򤵤줿���Ϲֻե����Ȥ����Ϥ��Ʋ�������");
		parts.cp_tccomment.focus();
		return false;
	}

	// ��°���ƥ��꡼
	if( parts.cp_cgid.value == "" ){
		alert("��°���ƥ��꡼�����򤷤Ʋ�������");
		parts.cp_cgid.focus();
		return false;
	}

	// �����ȥ�
	if( parts.cp_title.value == "" ){
		alert("�����ȥ�����Ϥ��Ʋ�������");
		parts.cp_title.focus();
		return false;
	} else {
		if( ! SpaceCheck( parts.cp_title.value ) ) {
			alert("�����ȥ�ϥ��ڡ����Τߤ���Ͽ������ޤ���");
			parts.cp_title.focus();
			return false;
		}
	}
	
	// ���֥����ȥ�
	if( parts.cp_subtitle.value == "" ){
		alert("���֥����ȥ�����Ϥ��Ʋ�������");
		parts.cp_subtitle.focus();
		return false;
	} else {
		if( ! SpaceCheck( parts.cp_subtitle.value ) ) {
			alert("�����ȥ�ϥ��ڡ����Τߤ���Ͽ������ޤ���");
			parts.cp_subtitle.focus();
			return false;
		}
	}
	
	if (parts.cp_btntext.value.length > 20) {
		alert("�ܥ���ƥ����Ȥ�20ʸ����������Ϥ��Ƥ���������");
		return false;
	}

	// ����
	if( parts.cp_contents.value == "" ){
		alert("���Ƥ����Ϥ��Ʋ�������");
		parts.cp_contents.focus();
		return false;
	} else {
		if( ! SpaceCheck( parts.cp_contents.value ) ) {
			alert("���Ƥϥ��ڡ����Τߤ���Ͽ������ޤ���");
			parts.cp_contents.focus();
			return false;
		}
	}

	// �����ڡ���Хʡ��쥤������
	intChk_bd = 9;
	intCnt_bd = parts.elements["cp_bkgdimg"].length;
	for( ix=0; ix<intCnt_bd; ix++ )
	{
		if( parts.elements["cp_bkgdimg"][ix].checked ){
			intChk_bd = 1;
		}
	}
	if( intChk_bd != 1 ){
		alert("�����ڡ���Хʡ��쥤�����Ȥ���ꤷ�Ʋ�������");
		parts.elements["cp_bkgdimg"][0].focus();
		return false;
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
function CampainDeleteCheck( parts , parts2 )
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
