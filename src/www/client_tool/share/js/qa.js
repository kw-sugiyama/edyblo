/*==================================================
    �֥����ܾ�����Ͽ���������ϥ����å�
==================================================*/
function QaInputCheck( parts , parts2 )
{

	// ����
	intChk_bd = 9;
	intCnt_bd = parts.elements["qa_stat"].length;
	for( ix=0; ix<intCnt_bd; ix++ )
	{
		if( parts.elements["qa_stat"][ix].checked ){
			intChk_bd = 1;
		}
	}
	if( intChk_bd != 1 ){
		alert("���֤���ꤷ�Ʋ�������");
		parts.elements["qa_stat"][0].focus();
		return false;
	}

	// ɽ����
	if( parts.qa_dispno.value == "" ){
		alert("ɽ��������Ϥ��Ʋ�������");
		parts.qa_dispno.focus();
		return false;
	} else if( !IntValCheck( parts.qa_dispno.value ) ) {
		alert("ɽ�����Ⱦ�ѿ��������Ϥ��Ƥ���������");
		parts.qa_dispno.focus();
		return false;
	}
	
	// ���ƥ���
	if ( parts.qa_cgid.value == "" ) {
		alert("���ƥ�������򤷤Ʋ�������");
		parts.qa_cgid.focus();
		return false;
	}

	// ����
	if( parts.qa_question.value == "" ){
		alert("��������Ϥ��Ʋ�������");
		parts.qa_question.focus();
		return false;
	} else {
		if( ! SpaceCheck( parts.qa_question.value ) ) {
			alert("����ϥ��ڡ����Τߤ���Ͽ������ޤ���");
			parts.qa_question.focus();
			return false;
		}
	}

	// ����
	if( parts.qa_answer.value == "" ){
		alert("���������Ϥ��Ʋ�������");
		parts.qa_answer.focus();
		return false;
	} else {
		if( ! SpaceCheck( parts.qa_answer.value ) ) {
			alert("�����ϥ��ڡ����Τߤ���Ͽ������ޤ���");
			parts.qa_answer.focus();
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
