function ChkSearchBox( parts ){
	// ����
	//���I���Ȃ�A���[�g
	if ( parts.elements['ar[]'].value == "" ) {
		alert("������I�����ĉ������B");
		parts.elements['ar[]'].focus();
		return false;
	}
	return true;
}


function ChkFreeSearchBox( parts ){
	// �t���[���[�h
	//�f�t�H���g�E��E�X�y�[�X�݂̂Ȃ�A���[�g
	if ( parts.elements['fw'].value == "" || parts.elements['fw'].value == parts.elements['fw'].defaultValue || !SpaceCheck( parts.elements['fw'].value ) ) {
		alert("�������[�h����͂��ĉ������B");
		parts.elements['fw'].focus();
		return false;
	}
	return true;
}

function ChkFreeSearchBoxReset( parts ){
	// �t���[���[�h
	//�f�t�H���g��ԂȂ��ɂ���
	if ( parts.elements['fw'].value == parts.elements['fw'].defaultValue ) {
		parts.elements['fw'].value = "";
	}
}

function ChkSearchBox2( parts ){
	// �t���[���[�h
	//�������� ���� �t���[���[�h���A��E�f�t�H���g�E�X�y�[�X�̂ǂꂩ�Ȃ�A���[�g
	if ( parts.elements['ar[]'].value == "" && ( parts.elements['fw'].value == "" || parts.elements['fw'].value == parts.elements['fw'].defaultValue || !SpaceCheck( parts.elements['fw'].value ) ) ) {
		alert("�����E�L�[���[�h�̂ǂ��炩��ݒ肵�ĉ������B");
		parts.elements['ar[]'].focus();
		return false;
	}
	return true;
}

function ChkSearchPrefSelect( parts ){
	//���`�F�b�N�{�^��
	var chk_flg = 9;
	if( parts.elements['ar[]'].length > 0 ){
		for (var i = 0; i < parts.elements['ar[]'].length; i++){
			if( parts.elements['ar[]'][i].checked ){
	    		var chk_flg = 1;
	    	}
		}
	}else{
		if( parts.elements['ar[]'].checked ){
	    	var chk_flg = 1;
		}
	}
	if( chk_flg == 9 ){
	    alert("������ȏ�I�����ĉ������B");
		return false;
	}
}

function ChkSearchCitySelect( parts ){
	//���`�F�b�N�{�^��
	var chk_flg = 9;
	if( parts.elements['pf[]'].length > 0 ){
		for (var i = 0; i < parts.elements['pf[]'].length; i++){
			if( parts.elements['pf[]'][i].checked ){
	    		var chk_flg = 1;
	    	}
		}
	}else{
		if( parts.elements['pf[]'].checked ){
	    	var chk_flg = 1;
		}
	}
	if( chk_flg == 9 ){
	    alert("�s��Q����ȏ�I�����ĉ������B");
		return false;
	}
}

function ChkSearchLineSelect1( parts ){
	//���`�F�b�N�{�^��
	var chk_flg = 9;
	if( parts.elements['ln[]'].length > 0 ){
		for (var i = 0; i < parts.elements['ln[]'].length; i++){
			if( parts.elements['ln[]'][i].checked ){
	    		var chk_flg = 1;
	    	}
		}
	}else{
		if( parts.elements['ln[]'].checked ){
	    	var chk_flg = 1;
		}
	}
	if( chk_flg == 9 ){
	    alert("��������ȏ�I�����ĉ������B");
		return false;
	}else{
		actnRplcHidden('mode','mode','ln');
		actnRplc('form1','/psearch-result/page-1.html','');
		return true;
	}
}

function ChkSearchLineSelect2( parts ){
	//���`�F�b�N�{�^��
	var chk_flg = 9;
	if( parts.elements['ln[]'].length > 0 ){
		for (var i = 0; i < parts.elements['ln[]'].length; i++){
			if( parts.elements['ln[]'][i].checked ){
	    		var chk_flg = 1;
	    	}
		}
	}else{
		if( parts.elements['ln[]'].checked ){
	    	var chk_flg = 1;
		}
	}
	if( chk_flg == 9 ){
	    alert("��������ȏ�I�����ĉ������B");
		return false;
	}else{
		actnRplcHidden('mode','','');
		actnRplc('form1','/psearch-sta/','');
		return true;
	}
}

function ChkSearchStaSelect( parts ){
	//���`�F�b�N�{�^��
	var chk_flg = 9;
	if( parts.elements['st[]'].length > 0 ){
		for (var i = 0; i < parts.elements['st[]'].length; i++){
			if( parts.elements['st[]'][i].checked ){
	    		var chk_flg = 1;
	    	}
		}
	}else{
		if( parts.elements['st[]'].checked ){
	    	var chk_flg = 1;
		}
	}
	if( chk_flg == 9 ){
	    alert("�w����ȏ�I�����ĉ������B");
		return false;
	}
}
