/*==================================================
    �֥����ܾ�����Ͽ���������ϥ����å�
==================================================*/
function DiaryInputCheck( parts , parts2 )
{

	// �����ȥ�
	if( parts.dr_title.value == "" ){
		alert("�����ȥ�����Ϥ��Ʋ�������");
		parts.dr_title.focus();
		return false;
	} else {
		if( ! SpaceCheck( parts.dr_title.value ) ) {
			alert("�����ȥ�ϥ��ڡ����Τߤ���Ͽ������ޤ���");
			parts.dr_title.focus();
			return false;
		}
	}
	
	// ��°���ƥ��꡼
	if( parts.dr_cgid.value == "" ){
		alert("��°���ƥ��꡼�����򤷤Ʋ�������");
		parts.dr_cgid.focus();
		return false;
	}



	// ��������ʸ
	if( parts.dr_contents.value == "" ){
		alert("��������ʸ�����Ϥ��Ʋ�������");
		parts.dr_contents.focus();
		return false;
	} else {
		if( ! SpaceCheck( parts.dr_contents.value ) ) {
			alert("��������ʸ�ϥ��ڡ����Τߤ���Ͽ������ޤ���");
			parts.dr_contents.focus();
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
