/*==================================================
    �֥����ܾ�����Ͽ���������ϥ����å�
==================================================*/
function CourseInputCheck( parts , parts2 )
{

	// ��°���ƥ��꡼
	if( parts.cs_cgid.value == "" ){
		alert("��°���ƥ��꡼�����򤷤Ʋ�������");
		parts.cs_cgid.focus();
		return false;
	}

	// �����ȥ�
	if( parts.cs_title.value == "" ){
		alert("�����ȥ�����Ϥ��Ʋ�������");
		parts.cs_title.focus();
		return false;
	} else {
		if( ! SpaceCheck( parts.cs_title.value ) ) {
			alert("�����ȥ�ϥ��ڡ����Τߤ���Ͽ������ޤ���");
			parts.cs_title.focus();
			return false;
		}
	}
	
	// �ֻ�
	if( parts.cs_tccomment.value != "" ){
		if( ! SpaceCheck( parts.cs_tccomment.value ) ) {
			alert("�ֻե����Ȥϥ��ڡ����Τߤ���Ͽ������ޤ���");
			parts.cs_tccomment.focus();
			return false;
		}
	}
	if( parts.cs_tcid.value == "" && parts.cs_tccomment.value != "" ){
		alert("�ֻե����Ȥ����Ϥ��줿���Ϲֻդ����򤷤Ʋ�������");
		parts.cs_tcid.focus();
		return false;
	}
	if( parts.cs_tcid.value != "" && parts.cs_tccomment.value == "" ){
		alert("�ֻդ����򤵤줿���Ϲֻե����Ȥ����Ϥ��Ʋ�������");
		parts.cs_tccomment.focus();
		return false;
	}

	// ����
	if( parts.cs_jtitle.value == "" ){
		alert("���ʤ����Ϥ��Ʋ�������");
		parts.cs_jtitle.focus();
		return false;
	} else {
		if( ! SpaceCheck( parts.cs_jtitle.value ) ) {
			alert("���ʤϥ��ڡ����Τߤ���Ͽ������ޤ���");
			parts.cs_jtitle.focus();
			return false;
		}
	}
	
	//��Ū
	if (!document.getElementById("cs_purpose0").checked && !document.getElementById("cs_purpose1").checked && !document.getElementById("cs_purpose2").checked) { 
    	alert("��Ū�����򤷤Ʋ�����");
		document.getElementById("cs_purpose0").focus();
		return false;
	}

	// �»�����
	if( parts.cs_week.value != "" ){
		if( ! SpaceCheck( parts.cs_week.value ) ) {
			alert("�»������ϥ��ڡ����Τߤ���Ͽ������ޤ���");
			parts.cs_week.focus();
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
function CourseDeleteCheck( parts , parts2 )
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
