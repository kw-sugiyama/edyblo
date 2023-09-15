/*==================================================
    �֥����ܾ�����Ͽ���������ϥ����å�
==================================================*/
function RoomInputCheck( parts , parts2 )
{
	
	// �����ֹ�
	if( parts.room_code.value == "" ){
		alert("�����ֹ�����Ϥ��Ʋ�������");
		parts.room_code.focus();
		return false;
	} else if( ! SpaceCheck( parts.room_code.value ) ) {
		alert("�����ֹ�ϥ��ڡ����Τߤ���Ͽ������ޤ���");
		parts.room_code.focus();
		return false;
	}

	//�ּ��
	if ( parts.room_madori.value == "" ) {
		alert("�ּ������򤷤Ʋ�������");
		parts.room_madori.focus();
		return false;
	}

	//�ּ��ܺ�
	if( parts.room_madori_detail.value == "" ){
		alert("�ּ��ܺ٤����Ϥ��Ʋ�������");
		parts.room_madori_detail.focus();
		return false;
	} else if( ! SpaceCheck( parts.room_madori_detail.value ) ) {
		alert("�ּ��ܺ٤ϥ��ڡ����Τߤ���Ͽ������ޤ���");
		parts.room_madori_detail.focus();
		return false;
	}

	//����
	if( parts.room_price.value == "" ){
		alert("���������Ϥ��Ʋ�������");
		parts.room_price.focus();
		return false;
	}else if(!IntValCheck( parts.room_price.value ) && parts.room_price.value != "-" && parts.room_price.value != "��"){
		alert("������Ⱦ�ѿ����ڤӥϥ��ե�����Ϥ��Ƥ���������");
		parts.room_price.focus();
		return false;
	}

	//������
	ret_cntrl_price = parts.room_cntrl_price.value.match(/^[0-9]+\.[0-9]+$/);
	if( parts.room_cntrl_price.value == "" ){
		alert("�����������Ϥ��Ʋ�������");
		parts.room_cntrl_price.focus();
		return false;
	}else if( !ret_cntrl_price && !IntValCheck( parts.room_cntrl_price.value ) && parts.room_cntrl_price.value != "-" && parts.room_cntrl_price.value != "��"){
		alert("��������Ⱦ�ѿ����ڤӥϥ��ե�����Ϥ��Ƥ���������");
		parts.room_cntrl_price.focus();
		return false;
	}

	//�߶�
	ret_siki = parts.room_siki.value.match(/^[0-9]+\.[0-9]+$/);
	if ( parts.room_siki.value == "" ) {
		alert("�߶�����򤷤Ʋ�������");
		parts.room_siki.focus();
		return false;
	} else if ( !ret_siki && !IntValCheck( parts.room_siki.value ) && parts.room_siki.value != "-" && parts.room_siki.value != "��" ) {
		alert("�߶��Ⱦ�������������ڤӥϥ��ե�����Ϥ��Ƥ���������");
		parts.room_siki.focus();
		return false;
	}

	//���
	ret_rei = parts.room_rei.value.match(/^[0-9]+\.[0-9]+$/);
	if ( parts.room_rei.value == "" ) {
		alert("�������򤷤Ʋ�������");
		parts.room_rei.focus();
		return false;
	} else if ( !ret_rei && !IntValCheck( parts.room_rei.value ) && parts.room_rei.value != "-" && parts.room_rei.value != "��" ) {
		alert("����Ⱦ�������������ڤӥϥ��ե�����Ϥ��Ƥ���������");
		parts.room_rei.focus();
		return false;
	}

	//����
	ret_syou = parts.room_syou.value.match(/^[0-9]+\.[0-9]+$/);
	if( parts.room_syou.value != "" ){
		if( !ret_syou && !IntValCheck( parts.room_syou.value ) && parts.room_syou.value != "-" && parts.room_syou.value != "��"){
			alert("���Ѥ�Ⱦ�ѿ����ڤӥϥ��ե�����Ϥ��Ƥ���������");
			parts.room_syou.focus();
			return false;
		}
	}

	//�߰�
	ret_sikibiki = parts.room_sikibiki.value.match(/^[0-9]+\.[0-9]+$/);
	if( parts.room_sikibiki.value != "" ){
		if( !ret_sikibiki && !IntValCheck( parts.room_sikibiki.value ) && parts.room_sikibiki.value != "-" && parts.room_sikibiki.value != "��"){
			alert("�߰���Ⱦ�ѿ����ڤӥϥ��ե�����Ϥ��Ƥ���������");
			parts.room_sikibiki.focus();
			return false;
		}
	}

	//�ݾڶ�
	ret_sec_price = parts.room_sec_price.value.match(/^[0-9]+\.[0-9]+$/);
	if( parts.room_sec_price.value != "" ){
		if( !ret_sec_price && !IntValCheck( parts.room_sec_price.value ) && parts.room_sec_price.value != "-" && parts.room_sec_price.value != "��"){
			alert("�ݾڶ��Ⱦ�ѿ����ڤӥϥ��ե�����Ϥ��Ƥ���������");
			parts.room_sec_price.focus();
			return false;
		}
	}

	//����ǯ
	if( parts.room_contract.value == "" ){
		alert("����ǯ�����Ϥ��Ʋ�������");
		parts.room_contract.focus();
		return false;
	}

	//������
	ret_upd_price = parts.room_upd_price.value.match(/^[0-9]+\.[0-9]+$/);
	if( parts.room_upd_price.value == "" ){
		alert("�����������Ϥ��Ʋ�������");
		parts.room_upd_price.focus();
		return false;
	}else if( !ret_upd_price && !IntValCheck( parts.room_upd_price.value ) && parts.room_upd_price.value != "-" && parts.room_upd_price.value != "��"){
		alert("��������Ⱦ�ѿ����ڤӥϥ��ե�����Ϥ��Ƥ���������");
		parts.room_upd_price.focus();
		return false;
	}

	//����ǯ��
	if( parts.room_upd_year.value == "" ){
		alert("����ǯ�������Ϥ��Ʋ�������");
		parts.room_upd_year.focus();
		return false;
	} else if( !IntValCheck( parts.room_upd_year.value ) ) {
		alert("����ǯ����Ⱦ�ѿ��������Ϥ��Ƥ���������");
		parts.room_upd_year.focus();
		return false;
	}

	//��ͭ����
	ret_area = parts.room_area.value.match(/^[0-9]+\.[0-9]+$/);
	if( parts.room_area.value == "" ){
		alert("��ͭ���Ѥ����Ϥ��Ʋ�������");
		parts.room_area.focus();
		return false;
	} else if ( !ret_area && !IntValCheck( parts.room_area.value ) ) {
		alert("��ͭ���Ѥ�Ⱦ���������ޤ���Ⱦ�Ѿ��������Ϥ��Ƥ���������");
		parts.room_area.focus();
		return false;
	}

	//��߳�
	if( parts.room_floor.value == "" ){
		alert("��߳������Ϥ��Ʋ�������");
		parts.room_floor.focus();
		return false;
	}

	//����
	if ( parts.room_face.value == "" ) {
		alert("���������򤷤Ʋ�������");
		parts.room_face.focus();
		return false;
	}

	// ���Ѳ���
	if ( parts.room_layout_lastupd.value == "" && parts.room_layout_img.value == "" && parts.error_flg.value == "" ){
		alert("���Ѳ��������ꤷ�Ʋ�������");
		parts.room_layout_img.focus();
		return false;
	}

	// ��������(����¾)
	if ( document.getElementById("other").checked && parts.room_equip_other.value == "" ){
		alert("��������(����¾)�����Ϥ��Ʋ�������");
		parts.room_equip_other.focus();
		return false;
	}

	
	// ʪ���������
	intChk_bd = 9;
	intCnt_bd = parts.elements["room_vacant"].length;
	for( ix=0; ix<intCnt_bd; ix++ )
	{
		if( parts.elements["room_vacant"][ix].checked ){
			intChk_bd = 1;
		}
	}
	if( intChk_bd != 1 ){
		alert("ʪ�������������ꤷ�Ʋ�������");
		parts.elements["room_vacant"][0].focus();
		return false;
	}
	
	// ¨����
	intChk_bd = 9;
	intCnt_bd = parts.elements["room_now_move"].length;
	for( ix=0; ix<intCnt_bd; ix++ )
	{
		if( parts.elements["room_now_move"][ix].checked ){
			intChk_bd = 1;
		}
	}
	if( intChk_bd != 1 ){
		alert("¨����Ĥ���ꤷ�Ʋ�������");
		parts.elements["room_now_move"][0].focus();
		return false;
	}

	// ����ͽ����
	if ( parts.elements["room_now_move"][1].checked && parts.room_move_date.value == "" ){
		alert("����ͽ���������Ϥ��Ʋ�������");
		parts.room_move_date.focus();
		return false;
	}

	//�������
	if ( parts.room_trade.value == "" ) {
		alert("������֤����򤷤Ʋ�������");
		parts.room_trade.focus();
		return false;
	}

	// ����PRʸ��
	if( parts.room_pr.value == "" ){
		alert("����PRʸ�Ϥ����Ϥ��Ʋ�������");
		parts.room_pr.focus();
		return false;
	}else{
		if( ! SpaceCheck( parts.room_pr.value ) ) {
			alert("����PRʸ�Ϥϥ��ڡ����Τߤ���Ͽ������ޤ���");
			parts.room_pr.focus();
			return false;
		}
		if( StrCountCheck( parts.room_pr.value , 20 ) ){
			alert("����PRʸ�Ϥ�20ʸ���ʾ�����Ϥ��Ʋ�����");
			parts.room_pr.focus();
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
    ���������ǧ
==================================================*/
function RoomDeleteCheck( parts , parts2 )
{
	ret_com = confirm("������ޤ���������Ǥ�����");
	if ( !ret_com ){
		return false;
	}
	
	parts.submit();
	return true;
}


/*==================================================
    ����ǡ������ԡ�������ǧ
==================================================*/
function RoomCopyCheck( parts )
{
	ret_com = confirm("���ꤵ�줿���������ʣ�����ޤ���������Ǥ�����");
	if ( !ret_com ){
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


/*==================================================
    Disabled
==================================================*/
function selectOther(){
	if(document.getElementById("other").checked){
		document.room.room_equip_other.disabled=false;
	}
	if(!document.getElementById("other").checked){
		document.room.room_equip_other.value="";
		document.room.room_equip_other.disabled=true;
	}
}


