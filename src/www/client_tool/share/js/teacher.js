/*==================================================
    �֥����ܾ�����Ͽ���������ϥ����å�
==================================================*/
function TeacherInputCheck( parts , parts2 )
{

	// ����
	intChk_bd = 9;
	intCnt_bd = parts.elements["tc_stat"].length;
	for( ix=0; ix<intCnt_bd; ix++ )
	{
		if( parts.elements["tc_stat"][ix].checked ){
			intChk_bd = 1;
		}
	}
	if( intChk_bd != 1 ){
		alert("���֤���ꤷ�Ʋ�������");
		parts.elements["tc_stat"][0].focus();
		return false;
	}

	// ������
	if( ! SpaceCheck( parts.tc_comment.value ) ) {
		alert("�����Ȥϥ��ڡ����Τߤ���Ͽ������ޤ���");
		parts.tc_comment.focus();
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
function TeacherDeleteCheck( parts , parts2 )
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
