/*=====================================================================
    ����礻 - ���ϥե���������å�
=====================================================================*/


//HP���䤤�礻
function hp_inquiry_check( parts )
{
	//���䤤�礻���ƥ����å��ܥ���
	
	//�᡼�륢�ɥ쥹
	if ( parts.email.value == "" ) {
		alert("�᡼�륢�ɥ쥹�����Ϥ��Ʋ�������");
		parts.email.focus();
		return false;
	} else {
		if ( !EmailCheck( parts.email.value ) ) {
			alert("�᡼�륢�ɥ쥹�����������Ϥ��Ʋ�������");
			parts.email.focus();
			return false;
		}
	}

	// ��̾
	if ( parts.subject.value == "" ) {
		alert("��̾�����Ϥ��Ʋ�������");
		parts.subject.focus();
		return false;
	} else {
		// ���ڡ����Τߥ����å�
		if ( !SpaceCheck( parts.subject.value ) ) {
			alert("��̾�ϥ��ڡ����Τߤ����ϤϤǤ��ޤ���");
			parts.subject.focus();
			return false;
		}
	}
	
	return true;
	
}

//���䤤��碌
function juku_inquiry_check( parts )
{

	//���䤤�礻���ƥ����å��ܥ���
	if( !parts.elements['title[0]'].checked && !parts.elements['title[1]'].checked && !parts.elements['title[2]'].checked && !parts.elements['title[3]'].checked){
    	alert("���䤤�礻���Ƥ����Ӳ�������");
		parts.elements['title[0]'].focus();
		return false;
	}

	//���䤤�礻���ƥ����å��ܥ���
	if( !parts.elements['device[0]'].checked && !parts.elements['device[1]'].checked && !parts.elements['device[2]'].checked && !parts.elements['device[3]'].checked){
    	alert("����˾���Ƥ����Ӳ�������");
		parts.elements['device[0]'].focus();
		return false;
	}
	
	// ��̾��
	if ( parts.name_kj_1.value == "" ) {
		alert("��̾�������Ϥ��Ʋ�������");
		parts.name_kj_1.focus();
		return false;
	} else {
		// ���ڡ����Τߥ����å�
		if ( !SpaceCheck( parts.name_kj_1.value ) ) {
			alert("��̾���ϥ��ڡ����Τߤ����ϤϤǤ��ޤ���");
			parts.name_kj_1.focus();
			return false;
		}
	}
	
	//�եꥬ�ʡݥ������ʥ����å�
	if ( !StrKatakanaCheck( parts.name_kn_1.value ) && parts.name_kn_1.value !="" ) {
		alert("�եꥬ�ʤ����ѥ������ʤ����Ϥ��Ʋ�������");
		parts.name_kn_1.focus();
		return false;
	}
		
	//�᡼�륢�ɥ쥹
	if ( parts.email.value == "" ) {
		alert("�᡼�륢�ɥ쥹�����Ϥ��Ʋ�������");
		parts.email.focus();
		return false;
	} else {
		if ( !EmailCheck( parts.email.value ) ) {
			alert("�᡼�륢�ɥ쥹�����������Ϥ��Ʋ�������");
			parts.email.focus();
			return false;
		}
	}

	//�����ֹ�����å����ʥϥ��ե�ɬ�ܡ�
	if ( !TellCheck_2( parts.tell_1.value ) && parts.tell_1.value !="") {
		alert("�����ֹ��ϥ��ե���������������Ϥ��Ʋ�������");
		parts.tell_1.focus();
		return false;
	}

	//�����ֹ�����å����ʥϥ��ե�ɬ�ܡ�
	if ( !PhsCheck_2( parts.mobile_1.value ) && parts.mobile_1.value !="") {
		alert("���������ֹ��ϥ��ե���������������Ϥ��Ʋ�������");
		parts.mobile_1.focus();
		return false;
	}

	return true;
	
}
