/*=====================================================================
    ����礻 - ���ϥե���������å�
=====================================================================*/
//���䤤�礻
function inquiry_input_check1( parts )
{
	//���䤤�礻���ƥ����å��ܥ���
	if (!parts.report1.checked && !parts.report2.checked && !parts.report3.checked && !parts.report4.checked) { 
    	alert("���䤤�礻���Ƥ����򲼤���");
		parts.report1.focus();
		return false;
	}else{
		if (parts.report4.checked && parts.etc.value == ""){
			alert("����¾ ���Ƥ򤴵���������");
			parts.etc.focus();
			return false;
		}
    } 

	//��Ϣ����ˡ�����å��ܥ���
	if (!parts.demand1.checked && !parts.demand2.checked && !parts.demand3.checked && !parts.demand4.checked) { 
    	alert("��Ϣ����ˡ�����򲼤���");
		parts.demand1.focus();
		return false;
	}else{
		if (parts.demand4.checked && parts.inquiry.value == ""){
			alert("�������Ƥ򤴵���������");
			parts.inquiry.focus();
			return false;
		}
	}

		// ��̾(����) - ��(���ɤ�)
	if ( parts.kidsname_kj_1.value == "" ) {
		alert("�����ͤλ�̾(����)-�������Ϥ��Ʋ�������");
		parts.kidsname_kj_1.focus();
		return false;
	} else {
		// ���ڡ����Τߥ����å�
		if ( !SpaceCheck( parts.kidsname_kj_1.value ) ) {
			alert("�����ͤλ�̾(����)-���ϥ��ڡ����Τߤ����ϤϤǤ��ޤ���");
			parts.kidsname_kj_1.focus();
			return false;
		}
	}

	// ��̾(����) - ̾(���ɤ�)
	if ( parts.kidsname_kj_2.value == "" ) {
		alert("�����ͤλ�̾(����)-̾�����Ϥ��Ʋ�������");
		parts.kidsname_kj_2.focus();
		return false;
	} else {
		// ���ڡ����Τߥ����å�
		if ( !SpaceCheck( parts.kidsname_kj_2.value ) ) {
			alert("�����ͤλ�̾(����)-̾�ϥ��ڡ����Τߤ����ϤϤǤ��ޤ���");
			parts.kidsname_kj_2.focus();
			return false;
		}
	}
	
	// ��̾(�եꥬ��) - ��(���ɤ�)
	if ( parts.kidsname_kn_1.value == "" ) {
		alert("�����ͤλ�̾(�եꥬ��)-�������Ϥ��Ʋ�������");
		parts.kidsname_kn_1.focus();
		return false;
	}
	// ���ڡ����Τߥ����å�
	if ( !SpaceCheck( parts.kidsname_kn_1.value ) ) {
		alert("�����ͤλ�̾(�եꥬ��)-���ϥ��ڡ����Τߤ����ϤϤǤ��ޤ���");
		parts.kidsname_kn_1.focus();
		return false;
	}
	// �������ʤΤߥ����å�
	if ( !StrKatakanaCheck( parts.kidsname_kn_1.value ) ) {
		alert("�����ͤλ�̾(�եꥬ��)-�������ѥ������ʤ����Ϥ��Ʋ�������");
		parts.kidsname_kn_1.focus();
		return false;
	}
	
	// ��̾(�եꥬ��) - ̾(���ɤ�)
	if ( parts.kidsname_kn_2.value == "" ) {
		alert("�����ͤλ�̾(�եꥬ��)-̾�����Ϥ��Ʋ�������");
		parts.kidsname_kn_2.focus();
		return false;
	}
	// ���ڡ����Τߥ����å�
	if ( !SpaceCheck( parts.kidsname_kn_2.value ) ) {
		alert("�����ͤλ�̾(�եꥬ��)-̾�ϥ��ڡ����Τߤ����ϤϤǤ��ޤ���");
		parts.kidsname_kn_2.focus();
		return false;
	}
	// �������ʤΤߥ����å�
	if ( !StrKatakanaCheck( parts.kidsname_kn_2.value ) ) {
		alert("�����ͤλ�̾(�եꥬ��)-̾�����ѥ������ʤ����Ϥ��Ʋ�������");
		parts.kidsname_kn_2.focus();
		return false;
	}
	
	//���ե����å�
	if( parts.year.value != "" || parts.month.value != "" || parts.day.value != ""){
		if(!DateCheck_1(parts.year.value+"-"+parts.month.value+"-"+parts.day.value)){
			alert("���������դ����Ϥ��Ʋ�������");
			parts.year.focus();
			return false;
		}
	}
	
	//��ǯ
	if(parts.gakunen.selectedIndex == 0){
		alert("��ǯ�����򤷤Ʋ�������");
		parts.gakunen.focus();
		return false;
	}
/*
	// ���̤��γع�
	//(��Ω����Ω�����ͻ�Ω��
	if ( parts.type.value == "" ) {
		alert("���̤��γع�(��Ω����Ω�����ͻ�Ω)�����Ϥ��Ʋ�������");
		parts.type.focus();
		return false;
	} else {
		// ���ڡ����Τߥ����å�
		if ( !SpaceCheck( parts.type.value ) ) {
			alert("���̤��γع��ʹ񡦸����ԡ���ˤϥ��ڡ����Τߤ����ϤϤǤ��ޤ���");
			parts.type.focus();
			return false;
		}
	}
	//�ع�̾
	if ( parts.school.value == "" ) {
		alert("���̤��γع��ʳع�̾�ˤ����Ϥ��Ʋ�������");
		parts.school.focus();
		return false;
	} else {
		// ���ڡ����Τߥ����å�
		if ( !SpaceCheck( parts.school.value ) ) {
			alert("���̤��γع��ʹ�Ω����Ω����Ω����Ω�ˤϥ��ڡ����Τߤ����ϤϤǤ��ޤ���");
			parts.school.focus();
			return false;
		}
	}
*/
	// ���̤��γع�
	//(��Ω����Ω�����ͻ�Ω��
	// ���ڡ����Τߥ����å�
	if ( !SpaceCheck( parts.type.value ) ) {
		alert("���̤��γع��ʹ񡦸����ԡ���ˤϥ��ڡ����Τߤ����ϤϤǤ��ޤ���");
		parts.type.focus();
		return false;
	}
	//�ع�̾
	// ���ڡ����Τߥ����å�
	if ( !SpaceCheck( parts.school.value ) ) {
		alert("���̤��γع��ʹ�Ω����Ω����Ω����Ω�ˤϥ��ڡ����Τߤ����ϤϤǤ��ޤ���");
		parts.school.focus();
		return false;
	}

	// ��̾(����) - �����ݸ�ԡ�
	if ( parts.name_kj_1.value == "" ) {
		alert("�ݸ���ͤλ�̾(����)-�������Ϥ��Ʋ�������");
		parts.name_kj_1.focus();
		return false;
	} else {
		// ���ڡ����Τߥ����å�
		if ( !SpaceCheck( parts.name_kj_1.value ) ) {
			alert("�ݸ���ͤλ�̾(����)-���ϥ��ڡ����Τߤ����ϤϤǤ��ޤ���");
			parts.name_kj_1.focus();
			return false;
		}
	}
	
	
	// ��̾(����) - ̾
	if ( parts.name_kj_2.value == "" ) {
		alert("�ݸ���ͤλ�̾(����)-̾�����Ϥ��Ʋ�������");
		parts.name_kj_2.focus();
		return false;
	} else {
		// ���ڡ����Τߥ����å�
		if ( !SpaceCheck( parts.name_kj_2.value ) ) {
			alert("�ݸ���ͤλ�̾(����)-̾�ϥ��ڡ����Τߤ����ϤϤǤ��ޤ���");
			parts.name_kj_2.focus();
			return false;
		}
	}
	
	
	// ��̾(�եꥬ��) - ��(�ݸ��)
	if ( parts.name_kn_1.value == "" ) {
		alert("�ݸ���ͤλ�̾(�եꥬ��)-�������Ϥ��Ʋ�������");
		parts.name_kn_1.focus();
		return false;
	}
	// ���ڡ����Τߥ����å�
	if ( !SpaceCheck( parts.name_kn_1.value ) ) {
		alert("�ݸ���ͤλ�̾(�եꥬ��)-���ϥ��ڡ����Τߤ����ϤϤǤ��ޤ���");
		parts.name_kn_1.focus();
		return false;
	}
	// �������ʤΤߥ����å�
	if ( !StrKatakanaCheck( parts.name_kn_1.value ) ) {
		alert("�ݸ���ͤλ�̾(�եꥬ��)-�������ѥ������ʤ����Ϥ��Ʋ�������");
		parts.name_kn_1.focus();
		return false;
	}
		
	// ��̾(�եꥬ��) - ��(�ݸ��)
	if ( parts.name_kn_2.value == "" ) {
		alert("�ݸ���ͤλ�̾(�եꥬ��)-̾�����Ϥ��Ʋ�������");
		parts.name_kn_2.focus();
		return false;
	}
	// ���ڡ����Τߥ����å�
	if ( !SpaceCheck( parts.name_kn_2.value ) ) {
		alert("�ݸ���ͤλ�̾(�եꥬ��)-̾�ϥ��ڡ����Τߤ����ϤϤǤ��ޤ���");
		parts.name_kn_2.focus();
		return false;
	}
	// �������ʤΤߥ����å�
	if ( !StrKatakanaCheck( parts.name_kn_2.value ) ) {
		alert("�ݸ���ͤλ�̾(�եꥬ��)-̾�����ѥ������ʤ����Ϥ��Ʋ�������");
		parts.name_kn_2.focus();
		return false;
	}

	if( parts.privacy != null){
		if (!parts.privacy.checked){
				alert("�ָĿ;���μ谷�ˤĤ��ơפˤ�Ʊ�դ��������ʤ����ϡ����䤤��碌������ĺ���ޤ���");
				parts.privacy.focus();
				return false;
		}
	}
	
	return true;
	
}

//������/�����ڡ����䤤��碌
function inquiry_input_check2( parts )
{
	//��Ϣ����ˡ�����å��ܥ���
	if (!parts.demand1.checked && !parts.demand2.checked && !parts.demand3.checked && !parts.demand4.checked) { 
    	alert("��Ϣ����ˡ�����򲼤���");
		parts.demand1.focus();
		return false;
	}else{
		if (parts.demand4.checked && parts.inquiry.value == ""){
			alert("�������Ƥ򤴵���������");
			parts.inquiry.focus();
			return false;
		}
	}
 

		// ��̾(����) - ��(���ɤ�)
	if ( parts.kidsname_kj_1.value == "" ) {
		alert("�����ͤλ�̾(����)-�������Ϥ��Ʋ�������");
		parts.kidsname_kj_1.focus();
		return false;
	} else {
		// ���ڡ����Τߥ����å�
		if ( !SpaceCheck( parts.kidsname_kj_1.value ) ) {
			alert("�����ͤλ�̾(����)-���ϥ��ڡ����Τߤ����ϤϤǤ��ޤ���");
			parts.kidsname_kj_1.focus();
			return false;
		}
	}

	// ��̾(����) - ̾(���ɤ�)
	if ( parts.kidsname_kj_2.value == "" ) {
		alert("�����ͤλ�̾(����)-̾�����Ϥ��Ʋ�������");
		parts.kidsname_kj_2.focus();
		return false;
	} else {
		// ���ڡ����Τߥ����å�
		if ( !SpaceCheck( parts.kidsname_kj_2.value ) ) {
			alert("�����ͤλ�̾(����)-̾�ϥ��ڡ����Τߤ����ϤϤǤ��ޤ���");
			parts.kidsname_kj_2.focus();
			return false;
		}
	}
	
	
	// ��̾(�եꥬ��) - ��(���ɤ�)
	if ( parts.kidsname_kn_1.value == "" ) {
		alert("�����ͤλ�̾(�եꥬ��)-�������Ϥ��Ʋ�������");
		parts.kidsname_kn_1.focus();
		return false;
	}
	// ���ڡ����Τߥ����å�
	if ( !SpaceCheck( parts.kidsname_kn_1.value ) ) {
		alert("�����ͤλ�̾(�եꥬ��)-���ϥ��ڡ����Τߤ����ϤϤǤ��ޤ���");
		parts.kidsname_kn_1.focus();
		return false;
	}
	// �������ʤΤߥ����å�
	if ( !StrKatakanaCheck( parts.kidsname_kn_1.value ) ) {
		alert("�����ͤλ�̾(�եꥬ��)-�������ѥ������ʤ����Ϥ��Ʋ�������");
		parts.kidsname_kn_1.focus();
		return false;
	}
		
	// ��̾(�եꥬ��) - ̾(���ɤ�)
	if ( parts.kidsname_kn_2.value == "" ) {
		alert("�����ͤλ�̾(�եꥬ��)-̾�����Ϥ��Ʋ�������");
		parts.kidsname_kn_2.focus();
		return false;
	}
	// ���ڡ����Τߥ����å�
	if ( !SpaceCheck( parts.kidsname_kn_2.value ) ) {
		alert("�����ͤλ�̾(�եꥬ��)-̾�ϥ��ڡ����Τߤ����ϤϤǤ��ޤ���");
		parts.kidsname_kn_2.focus();
		return false;
	}
	// �������ʤΤߥ����å�
	if ( !StrKatakanaCheck( parts.kidsname_kn_2.value ) ) {
		alert("�����ͤλ�̾(�եꥬ��)-̾�����ѥ������ʤ����Ϥ��Ʋ�������");
		parts.kidsname_kn_2.focus();
		return false;
	}
	
	//���ե����å�
	if( parts.year.value != "" || parts.month.value != "" || parts.day.value != ""){
		if(!DateCheck_1(parts.year.value+"-"+parts.month.value+"-"+parts.day.value)){
			alert("���������դ����Ϥ��Ʋ�������");
			parts.year.focus();
			return false;
		}
	}
	
	//��ǯ
	if(parts.gakunen.selectedIndex == 0){
		alert("��ǯ�����򤷤Ʋ�������");
		parts.gakunen.focus();
		return false;
	}
/*
	// ���̤��γع�
	//(��Ω����Ω�����ͻ�Ω��
	if ( parts.type.value == "" ) {
		alert("���̤��γع�(��Ω����Ω�����ͻ�Ω)�����Ϥ��Ʋ�������");
		parts.type.focus();
		return false;
	} else {
		// ���ڡ����Τߥ����å�
		if ( !SpaceCheck( parts.type.value ) ) {
			alert("���̤��γع��ʹ񡦸����ԡ���ˤϥ��ڡ����Τߤ����ϤϤǤ��ޤ���");
			parts.type.focus();
			return false;
		}
	}
	//�ع�̾
	if ( parts.school.value == "" ) {
		alert("���̤��γع��ʳع�̾�ˤ����Ϥ��Ʋ�������");
		parts.school.focus();
		return false;
	} else {
		// ���ڡ����Τߥ����å�
		if ( !SpaceCheck( parts.school.value ) ) {
			alert("���̤��γع��ʹ�Ω����Ω����Ω����Ω�ˤϥ��ڡ����Τߤ����ϤϤǤ��ޤ���");
			parts.school.focus();
			return false;
		}
	}
*/
	// ���̤��γع�
	//(��Ω����Ω�����ͻ�Ω��
	// ���ڡ����Τߥ����å�
	if ( !SpaceCheck( parts.type.value ) ) {
		alert("���̤��γع��ʹ񡦸����ԡ���ˤϥ��ڡ����Τߤ����ϤϤǤ��ޤ���");
		parts.type.focus();
		return false;
	}
	//�ع�̾
	// ���ڡ����Τߥ����å�
	if ( !SpaceCheck( parts.school.value ) ) {
		alert("���̤��γع��ʹ�Ω����Ω����Ω����Ω�ˤϥ��ڡ����Τߤ����ϤϤǤ��ޤ���");
		parts.school.focus();
		return false;
	}

	// ��̾(����) - �����ݸ�ԡ�
	if ( parts.name_kj_1.value == "" ) {
		alert("�ݸ���ͤλ�̾(����)-�������Ϥ��Ʋ�������");
		parts.name_kj_1.focus();
		return false;
	} else {
		// ���ڡ����Τߥ����å�
		if ( !SpaceCheck( parts.name_kj_1.value ) ) {
			alert("�ݸ���ͤλ�̾(����)-���ϥ��ڡ����Τߤ����ϤϤǤ��ޤ���");
			parts.name_kj_1.focus();
			return false;
		}
	}
	
	
	// ��̾(����) - ̾
	if ( parts.name_kj_2.value == "" ) {
		alert("�ݸ���ͤλ�̾(����)-̾�����Ϥ��Ʋ�������");
		parts.name_kj_2.focus();
		return false;
	} else {
		// ���ڡ����Τߥ����å�
		if ( !SpaceCheck( parts.name_kj_2.value ) ) {
			alert("�ݸ���ͤλ�̾(����)-̾�ϥ��ڡ����Τߤ����ϤϤǤ��ޤ���");
			parts.name_kj_2.focus();
			return false;
		}
	}
	
	
	// ��̾(�եꥬ��) - ��(�ݸ��)
	if ( parts.name_kn_1.value == "" ) {
		alert("�ݸ���ͤλ�̾(�եꥬ��)-�������Ϥ��Ʋ�������");
		parts.name_kn_1.focus();
		return false;
	}
	// ���ڡ����Τߥ����å�
	if ( !SpaceCheck( parts.name_kn_1.value ) ) {
		alert("�ݸ���ͤλ�̾(�եꥬ��)-���ϥ��ڡ����Τߤ����ϤϤǤ��ޤ���");
		parts.name_kn_1.focus();
		return false;
	}
	// �������ʤΤߥ����å�
	if ( !StrKatakanaCheck( parts.name_kn_1.value ) ) {
		alert("�ݸ���ͤλ�̾(�եꥬ��)-�������ѥ������ʤ����Ϥ��Ʋ�������");
		parts.name_kn_1.focus();
		return false;
	}
		
	// ��̾(�եꥬ��) - ��(�ݸ��)
	if ( parts.name_kn_2.value == "" ) {
		alert("�ݸ���ͤλ�̾(�եꥬ��)-̾�����Ϥ��Ʋ�������");
		parts.name_kn_2.focus();
		return false;
	}
	// ���ڡ����Τߥ����å�
	if ( !SpaceCheck( parts.name_kn_2.value ) ) {
		alert("�ݸ���ͤλ�̾(�եꥬ��)-̾�ϥ��ڡ����Τߤ����ϤϤǤ��ޤ���");
		parts.name_kn_2.focus();
		return false;
	}
	// �������ʤΤߥ����å�
	if ( !StrKatakanaCheck( parts.name_kn_2.value ) ) {
		alert("�ݸ���ͤλ�̾(�եꥬ��)-̾�����ѥ������ʤ����Ϥ��Ʋ�������");
		parts.name_kn_2.focus();
		return false;
	}

	if (!parts.privacy.checked){
			alert("�ָĿ;���μ谷�ˤĤ��ơפˤ�Ʊ�դ��������ʤ����ϡ����䤤��碌������ĺ���ޤ���");
			parts.privacy.focus();
			return false;
	}

	return true;
	
}

//�������ᡢ��������������
function inquiry_input_check3( parts )
{
		// ��̾(����) - ��(���ɤ�)
	if ( parts.kidsname_kj_1.value == "" ) {
		alert("�����ͤλ�̾(����)-�������Ϥ��Ʋ�������");
		parts.kidsname_kj_1.focus();
		return false;
	} else {
		// ���ڡ����Τߥ����å�
		if ( !SpaceCheck( parts.kidsname_kj_1.value ) ) {
			alert("�����ͤλ�̾(����)-���ϥ��ڡ����Τߤ����ϤϤǤ��ޤ���");
			parts.kidsname_kj_1.focus();
			return false;
		}
	}

	// ��̾(����) - ̾(���ɤ�)
	if ( parts.kidsname_kj_2.value == "" ) {
		alert("�����ͤλ�̾(����)-̾�����Ϥ��Ʋ�������");
		parts.kidsname_kj_2.focus();
		return false;
	} else {
		// ���ڡ����Τߥ����å�
		if ( !SpaceCheck( parts.kidsname_kj_2.value ) ) {
			alert("�����ͤλ�̾(����)-̾�ϥ��ڡ����Τߤ����ϤϤǤ��ޤ���");
			parts.kidsname_kj_2.focus();
			return false;
		}
	}
	
	
	// ��̾(�եꥬ��) - ��(���ɤ�)
	if ( parts.kidsname_kn_1.value == "" ) {
		alert("�����ͤλ�̾(�եꥬ��)-�������Ϥ��Ʋ�������");
		parts.kidsname_kn_1.focus();
		return false;
	}
	// ���ڡ����Τߥ����å�
	if ( !SpaceCheck( parts.kidsname_kn_1.value ) ) {
		alert("�����ͤλ�̾(�եꥬ��)-���ϥ��ڡ����Τߤ����ϤϤǤ��ޤ���");
		parts.kidsname_kn_1.focus();
		return false;
	}
	// �������ʤΤߥ����å�
	if ( !StrKatakanaCheck( parts.kidsname_kn_1.value ) ) {
		alert("�����ͤλ�̾(�եꥬ��)-�������ѥ������ʤ����Ϥ��Ʋ�������");
		parts.kidsname_kn_1.focus();
		return false;
	}
		
	// ��̾(�եꥬ��) - ̾(���ɤ�)
	if ( parts.kidsname_kn_2.value == "" ) {
		alert("�����ͤλ�̾(�եꥬ��)-̾�����Ϥ��Ʋ�������");
		parts.kidsname_kn_2.focus();
		return false;
	}
	// ���ڡ����Τߥ����å�
	if ( !SpaceCheck( parts.kidsname_kn_2.value ) ) {
		alert("�����ͤλ�̾(�եꥬ��)-̾�ϥ��ڡ����Τߤ����ϤϤǤ��ޤ���");
		parts.kidsname_kn_2.focus();
		return false;
	}
	// �������ʤΤߥ����å�
	if ( !StrKatakanaCheck( parts.kidsname_kn_2.value ) ) {
		alert("�����ͤλ�̾(�եꥬ��)-̾�����ѥ������ʤ����Ϥ��Ʋ�������");
		parts.kidsname_kn_2.focus();
		return false;
	}
	
	//���ե����å�
	if( parts.year.value != "" || parts.month.value != "" || parts.day.value != ""){
		if(!DateCheck_1(parts.year.value+"-"+parts.month.value+"-"+parts.day.value)){
			alert("���������դ����Ϥ��Ʋ�������");
			parts.year.focus();
			return false;
		}
	}
	
	//��ǯ
	if(parts.gakunen.selectedIndex == 0){
		alert("��ǯ�����򤷤Ʋ�������");
		parts.gakunen.focus();
		return false;
	}
/*
	// ���̤��γع�
	//(��Ω����Ω�����ͻ�Ω��
	if ( parts.type.value == "" ) {
		alert("���̤��γع�(��Ω����Ω�����ͻ�Ω)�����Ϥ��Ʋ�������");
		parts.type.focus();
		return false;
	} else {
		// ���ڡ����Τߥ����å�
		if ( !SpaceCheck( parts.type.value ) ) {
			alert("���̤��γع��ʹ񡦸����ԡ���ˤϥ��ڡ����Τߤ����ϤϤǤ��ޤ���");
			parts.type.focus();
			return false;
		}
	}
	//�ع�̾
	if ( parts.school.value == "" ) {
		alert("���̤��γع��ʳع�̾�ˤ����Ϥ��Ʋ�������");
		parts.school.focus();
		return false;
	} else {
		// ���ڡ����Τߥ����å�
		if ( !SpaceCheck( parts.school.value ) ) {
			alert("���̤��γع��ʹ�Ω����Ω����Ω����Ω�ˤϥ��ڡ����Τߤ����ϤϤǤ��ޤ���");
			parts.school.focus();
			return false;
		}
	}
*/
	// ���̤��γع�
	//(��Ω����Ω�����ͻ�Ω��
	// ���ڡ����Τߥ����å�
	if ( !SpaceCheck( parts.type.value ) ) {
		alert("���̤��γع��ʹ񡦸����ԡ���ˤϥ��ڡ����Τߤ����ϤϤǤ��ޤ���");
		parts.type.focus();
		return false;
	}
	//�ع�̾
	// ���ڡ����Τߥ����å�
	if ( !SpaceCheck( parts.school.value ) ) {
		alert("���̤��γع��ʹ�Ω����Ω����Ω����Ω�ˤϥ��ڡ����Τߤ����ϤϤǤ��ޤ���");
		parts.school.focus();
		return false;
	}

	// ��̾(����) - �����ݸ�ԡ�
	if ( parts.name_kj_1.value == "" ) {
		alert("�ݸ���ͤλ�̾(����)-�������Ϥ��Ʋ�������");
		parts.name_kj_1.focus();
		return false;
	} else {
		// ���ڡ����Τߥ����å�
		if ( !SpaceCheck( parts.name_kj_1.value ) ) {
			alert("�ݸ���ͤλ�̾(����)-���ϥ��ڡ����Τߤ����ϤϤǤ��ޤ���");
			parts.name_kj_1.focus();
			return false;
		}
	}
	
	
	// ��̾(����) - ̾
	if ( parts.name_kj_2.value == "" ) {
		alert("�ݸ���ͤλ�̾(����)-̾�����Ϥ��Ʋ�������");
		parts.name_kj_2.focus();
		return false;
	} else {
		// ���ڡ����Τߥ����å�
		if ( !SpaceCheck( parts.name_kj_2.value ) ) {
			alert("�ݸ���ͤλ�̾(����)-̾�ϥ��ڡ����Τߤ����ϤϤǤ��ޤ���");
			parts.name_kj_2.focus();
			return false;
		}
	}
	
	
	// ��̾(�եꥬ��) - ��(�ݸ��)
	if ( parts.name_kn_1.value == "" ) {
		alert("�ݸ���ͤλ�̾(�եꥬ��)-�������Ϥ��Ʋ�������");
		parts.name_kn_1.focus();
		return false;
	}
	// ���ڡ����Τߥ����å�
	if ( !SpaceCheck( parts.name_kn_1.value ) ) {
		alert("�ݸ���ͤλ�̾(�եꥬ��)-���ϥ��ڡ����Τߤ����ϤϤǤ��ޤ���");
		parts.name_kn_1.focus();
		return false;
	}
	// �������ʤΤߥ����å�
	if ( !StrKatakanaCheck( parts.name_kn_1.value ) ) {
		alert("�ݸ���ͤλ�̾(�եꥬ��)-�������ѥ������ʤ����Ϥ��Ʋ�������");
		parts.name_kn_1.focus();
		return false;
	}
		
	// ��̾(�եꥬ��) - ��(�ݸ��)
	if ( parts.name_kn_2.value == "" ) {
		alert("�ݸ���ͤλ�̾(�եꥬ��)-̾�����Ϥ��Ʋ�������");
		parts.name_kn_2.focus();
		return false;
	}
	// ���ڡ����Τߥ����å�
	if ( !SpaceCheck( parts.name_kn_2.value ) ) {
		alert("�ݸ���ͤλ�̾(�եꥬ��)-̾�ϥ��ڡ����Τߤ����ϤϤǤ��ޤ���");
		parts.name_kn_2.focus();
		return false;
	}
	// �������ʤΤߥ����å�
	if ( !StrKatakanaCheck( parts.name_kn_2.value ) ) {
		alert("�ݸ���ͤλ�̾(�եꥬ��)-̾�����ѥ������ʤ����Ϥ��Ʋ�������");
		parts.name_kn_2.focus();
		return false;
	}

	// ͹���ֹ�����å�
	for ( iX=1; iX<3; iX++ ) {
		strAddrName = "addr_cd_"+iX;
		if ( parts.elements[strAddrName].value == "" ) {
			alert("͹���ֹ�����Ϥ��Ʋ�������");
			parts.elements[strAddrName].focus();
			return false;
		}
		if ( !IntValCheck( parts.elements[strAddrName].value ) ) {
			alert("͹���ֹ��Ⱦ�ѿ����Τߤ����Ϥ��Ʋ�������");
			parts.elements[strAddrName].focus();
			return false;
		}
		if ( iX == 1 ) {
			if ( !StrCountCheck_Equal( parts.elements[strAddrName].value , 3 ) ){
				alert("͹���ֹ�����������Ϥ��Ʋ�������");
				parts.elements[strAddrName].focus();
				return false;
			}
		} else {
			if ( !StrCountCheck_Equal( parts.elements[strAddrName].value , 4 ) ){
				alert("͹���ֹ�����������Ϥ��Ʋ�������");
				parts.elements[strAddrName].focus();
				return false;
			}
			
		}
	}
	
	
	// ��������å�
	if ( parts.pref.value == "" ) {
		alert("��ƻ�ܸ�̾�����򤷤Ʋ�������");
		parts.pref.focus();
		return false;
	}
	if ( parts.city.value == "" ){
		alert("����ʻԶ�Į¼̾�ˤ����Ϥ��Ʋ�����");
		parts.city.focus();
		return false;
	} else {
		if ( !SpaceCheck( parts.city.value ) ) {
			alert("����ʻԶ�Į¼̾�ˤϥ��ڡ����Τߤ����ϤϤǤ��ޤ���");
			parts.city.focus();
			return false;
		}
	}
	if ( parts.add.value == "" ){
		alert("����ʻԶ�Į¼�ʹߡˤ����Ϥ��Ʋ�����");
		parts.add.focus();
		return false;
	} else {
		if ( !SpaceCheck( parts.add.value ) ) {
			alert("����ʻԶ�Į¼�ʹߡˤϥ��ڡ����Τߤ����ϤϤǤ��ޤ���");
			parts.add.focus();
			return false;
		}
	}

	if (!parts.privacy.checked){
			alert("�ָĿ;���μ谷�ˤĤ��ơפˤ�Ʊ�դ��������ʤ����ϡ��������������ĺ���ޤ���");
			parts.privacy.focus();
			return false;
	}

	return true;
	
}

//�����ڡ��󿽤�����
function inquiry_input_check4( parts )
{
		// ��̾(����) - ��(���ɤ�)
	if ( parts.kidsname_kj_1.value == "" ) {
		alert("�����ͤλ�̾(����)-�������Ϥ��Ʋ�������");
		parts.kidsname_kj_1.focus();
		return false;
	} else {
		// ���ڡ����Τߥ����å�
		if ( !SpaceCheck( parts.kidsname_kj_1.value ) ) {
			alert("�����ͤλ�̾(����)-���ϥ��ڡ����Τߤ����ϤϤǤ��ޤ���");
			parts.kidsname_kj_1.focus();
			return false;
		}
	}

	// ��̾(����) - ̾(���ɤ�)
	if ( parts.kidsname_kj_2.value == "" ) {
		alert("�����ͤλ�̾(����)-̾�����Ϥ��Ʋ�������");
		parts.kidsname_kj_2.focus();
		return false;
	} else {
		// ���ڡ����Τߥ����å�
		if ( !SpaceCheck( parts.kidsname_kj_2.value ) ) {
			alert("�����ͤλ�̾(����)-̾�ϥ��ڡ����Τߤ����ϤϤǤ��ޤ���");
			parts.kidsname_kj_2.focus();
			return false;
		}
	}
	
	
	// ��̾(�եꥬ��) - ��(���ɤ�)
	if ( parts.kidsname_kn_1.value == "" ) {
		alert("�����ͤλ�̾(�եꥬ��)-�������Ϥ��Ʋ�������");
		parts.kidsname_kn_1.focus();
		return false;
	}
	// ���ڡ����Τߥ����å�
	if ( !SpaceCheck( parts.kidsname_kn_1.value ) ) {
		alert("�����ͤλ�̾(�եꥬ��)-���ϥ��ڡ����Τߤ����ϤϤǤ��ޤ���");
		parts.kidsname_kn_1.focus();
		return false;
	}
	// �������ʤΤߥ����å�
	if ( !StrKatakanaCheck( parts.kidsname_kn_1.value ) ) {
		alert("�����ͤλ�̾(�եꥬ��)-�������ѥ������ʤ����Ϥ��Ʋ�������");
		parts.kidsname_kn_1.focus();
		return false;
	}
		
	// ��̾(�եꥬ��) - ̾(���ɤ�)
	if ( parts.kidsname_kn_2.value == "" ) {
		alert("�����ͤλ�̾(�եꥬ��)-̾�����Ϥ��Ʋ�������");
		parts.kidsname_kn_2.focus();
		return false;
	}
	// ���ڡ����Τߥ����å�
	if ( !SpaceCheck( parts.kidsname_kn_2.value ) ) {
		alert("�����ͤλ�̾(�եꥬ��)-̾�ϥ��ڡ����Τߤ����ϤϤǤ��ޤ���");
		parts.kidsname_kn_2.focus();
		return false;
	}
	// �������ʤΤߥ����å�
	if ( !StrKatakanaCheck( parts.kidsname_kn_2.value ) ) {
		alert("�����ͤλ�̾(�եꥬ��)-̾�����ѥ������ʤ����Ϥ��Ʋ�������");
		parts.kidsname_kn_2.focus();
		return false;
	}
	
	//���ե����å�
	if( parts.year.value != "" || parts.month.value != "" || parts.day.value != ""){
		if(!DateCheck_1(parts.year.value+"-"+parts.month.value+"-"+parts.day.value)){
			alert("���������դ����Ϥ��Ʋ�������");
			parts.year.focus();
			return false;
		}
	}
	
	//��ǯ
	if(parts.gakunen.selectedIndex == 0){
		alert("��ǯ�����򤷤Ʋ�������");
		parts.gakunen.focus();
		return false;
	}
/*
	// ���̤��γع�
	//(��Ω����Ω�����ͻ�Ω��
	if ( parts.type.value == "" ) {
		alert("���̤��γع�(��Ω����Ω�����ͻ�Ω)�����Ϥ��Ʋ�������");
		parts.type.focus();
		return false;
	} else {
		// ���ڡ����Τߥ����å�
		if ( !SpaceCheck( parts.type.value ) ) {
			alert("���̤��γع��ʹ񡦸����ԡ���ˤϥ��ڡ����Τߤ����ϤϤǤ��ޤ���");
			parts.type.focus();
			return false;
		}
	}
	//�ع�̾
	if ( parts.school.value == "" ) {
		alert("���̤��γع��ʳع�̾�ˤ����Ϥ��Ʋ�������");
		parts.school.focus();
		return false;
	} else {
		// ���ڡ����Τߥ����å�
		if ( !SpaceCheck( parts.school.value ) ) {
			alert("���̤��γع��ʹ�Ω����Ω����Ω����Ω�ˤϥ��ڡ����Τߤ����ϤϤǤ��ޤ���");
			parts.school.focus();
			return false;
		}
	}
*/
	// ���̤��γع�
	//(��Ω����Ω�����ͻ�Ω��
	// ���ڡ����Τߥ����å�
	if ( !SpaceCheck( parts.type.value ) ) {
		alert("���̤��γع��ʹ񡦸����ԡ���ˤϥ��ڡ����Τߤ����ϤϤǤ��ޤ���");
		parts.type.focus();
		return false;
	}
	//�ع�̾
	// ���ڡ����Τߥ����å�
	if ( !SpaceCheck( parts.school.value ) ) {
		alert("���̤��γع��ʹ�Ω����Ω����Ω����Ω�ˤϥ��ڡ����Τߤ����ϤϤǤ��ޤ���");
		parts.school.focus();
		return false;
	}
	
	// ��̾(����) - �����ݸ�ԡ�
	if ( parts.name_kj_1.value == "" ) {
		alert("�ݸ���ͤλ�̾(����)-�������Ϥ��Ʋ�������");
		parts.name_kj_1.focus();
		return false;
	} else {
		// ���ڡ����Τߥ����å�
		if ( !SpaceCheck( parts.name_kj_1.value ) ) {
			alert("�ݸ���ͤλ�̾(����)-���ϥ��ڡ����Τߤ����ϤϤǤ��ޤ���");
			parts.name_kj_1.focus();
			return false;
		}
	}
	
	
	// ��̾(����) - ̾
	if ( parts.name_kj_2.value == "" ) {
		alert("�ݸ���ͤλ�̾(����)-̾�����Ϥ��Ʋ�������");
		parts.name_kj_2.focus();
		return false;
	} else {
		// ���ڡ����Τߥ����å�
		if ( !SpaceCheck( parts.name_kj_2.value ) ) {
			alert("�ݸ���ͤλ�̾(����)-̾�ϥ��ڡ����Τߤ����ϤϤǤ��ޤ���");
			parts.name_kj_2.focus();
			return false;
		}
	}
	
	
	// ��̾(�եꥬ��) - ��(�ݸ��)
	if ( parts.name_kn_1.value == "" ) {
		alert("�ݸ���ͤλ�̾(�եꥬ��)-�������Ϥ��Ʋ�������");
		parts.name_kn_1.focus();
		return false;
	}
	// ���ڡ����Τߥ����å�
	if ( !SpaceCheck( parts.name_kn_1.value ) ) {
		alert("�ݸ���ͤλ�̾(�եꥬ��)-���ϥ��ڡ����Τߤ����ϤϤǤ��ޤ���");
		parts.name_kn_1.focus();
		return false;
	}
	// �������ʤΤߥ����å�
	if ( !StrKatakanaCheck( parts.name_kn_1.value ) ) {
		alert("�ݸ���ͤλ�̾(�եꥬ��)-�������ѥ������ʤ����Ϥ��Ʋ�������");
		parts.name_kn_1.focus();
		return false;
	}
		
	// ��̾(�եꥬ��) - ��(�ݸ��)
	if ( parts.name_kn_2.value == "" ) {
		alert("�ݸ���ͤλ�̾(�եꥬ��)-̾�����Ϥ��Ʋ�������");
		parts.name_kn_2.focus();
		return false;
	}
	// ���ڡ����Τߥ����å�
	if ( !SpaceCheck( parts.name_kn_2.value ) ) {
		alert("�ݸ���ͤλ�̾(�եꥬ��)-̾�ϥ��ڡ����Τߤ����ϤϤǤ��ޤ���");
		parts.name_kn_2.focus();
		return false;
	}
	// �������ʤΤߥ����å�
	if ( !StrKatakanaCheck( parts.name_kn_2.value ) ) {
		alert("�ݸ���ͤλ�̾(�եꥬ��)-̾�����ѥ������ʤ����Ϥ��Ʋ�������");
		parts.name_kn_2.focus();
		return false;
	}

	// ͹���ֹ�����å�
	for ( iX=1; iX<3; iX++ ) {
		strAddrName = "addr_cd_"+iX;
		if ( parts.elements[strAddrName].value == "" ) {
			alert("͹���ֹ�����Ϥ��Ʋ�������");
			parts.elements[strAddrName].focus();
			return false;
		}
		if ( !IntValCheck( parts.elements[strAddrName].value ) ) {
			alert("͹���ֹ��Ⱦ�ѿ����Τߤ����Ϥ��Ʋ�������");
			parts.elements[strAddrName].focus();
			return false;
		}
		if ( iX == 1 ) {
			if ( !StrCountCheck_Equal( parts.elements[strAddrName].value , 3 ) ){
				alert("͹���ֹ�����������Ϥ��Ʋ�������");
				parts.elements[strAddrName].focus();
				return false;
			}
		} else {
			if ( !StrCountCheck_Equal( parts.elements[strAddrName].value , 4 ) ){
				alert("͹���ֹ�����������Ϥ��Ʋ�������");
				parts.elements[strAddrName].focus();
				return false;
			}
			
		}
	}
	
	
	// ��������å�
	if ( parts.pref.value == "" ) {
		alert("��ƻ�ܸ�̾�����򤷤Ʋ�������");
		parts.pref.focus();
		return false;
	}
	if ( parts.city.value == "" ){
		alert("����ʻԶ�Į¼̾�ˤ����Ϥ��Ʋ�����");
		parts.city.focus();
		return false;
	} else {
		if ( !SpaceCheck( parts.city.value ) ) {
			alert("����ʻԶ�Į¼̾�ˤϥ��ڡ����Τߤ����ϤϤǤ��ޤ���");
			parts.city.focus();
			return false;
		}
	}
	if ( parts.add.value == "" ){
		alert("����ʻԶ�Į¼�ʹߡˤ����Ϥ��Ʋ�����");
		parts.add.focus();
		return false;
	} else {
		if ( !SpaceCheck( parts.add.value ) ) {
			alert("����ʻԶ�Į¼�ʹߡˤϥ��ڡ����Τߤ����ϤϤǤ��ޤ���");
			parts.add.focus();
			return false;
		}
	}

	//�����ֹ�
	if ( parts.tel.value == "" && parts.ctel.value == "") {
		alert("�����ֹ椫�����ֹ椤���줫�����Ϥ��Ʋ�������");
		parts.tel.focus();
		return false;
	}
	if( parts.tel.value != ""){
		if( !TellCheck_2(parts.tel.value)){
			alert("�����ֹ�����������Ϥ��Ʋ�������");
			parts.tel.focus();
			return false;
		}
	}
	if( parts.ctel.value != ""){
		if( !PhsCheck_2(parts.ctel.value)){
			alert("�����ֹ�����������Ϥ��Ʋ�������");
			parts.ctel.focus();
			return false;
		}
	}

	//�᡼�륢�ɥ쥹
	if ( parts.mail.value == "" ) {
		alert("�᡼�륢�ɥ쥹�����Ϥ��Ʋ�������");
		parts.mail.focus();
		return false;
	} else {
		if ( !EmailCheck( parts.mail.value ) ) {
			alert("�᡼�륢�ɥ쥹�����������Ϥ��Ʋ�������");
			parts.mail.focus();
			return false;
		}
	}

	if (!parts.privacy.checked){
			alert("�ָĿ;���μ谷�ˤĤ��ơפˤ�Ʊ�դ��������ʤ����ϡ����������ߤ��������ޤ���");
			parts.privacy.focus();
			return false;
	}
	
	return true;
	
}