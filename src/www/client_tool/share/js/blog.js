/*==================================================
    �֥����ܾ�����Ͽ���������ϥ����å�
==================================================*/
function BlogInputCheck( parts , parts2 )
{
	
	// �ԣϣХ�����ɥ������ȥ�
	if( parts.sc_topwindowtitle.value == "" ){
		alert("�ԣϣХ�����ɥ������ȥ�����Ϥ��Ʋ�����");
		parts.sc_topwindowtitle.focus();
		return false;
	}else if( ! SpaceCheck( parts.sc_topwindowtitle.value ) ) {
			alert("�ԣϣХ�����ɥ������ȥ�ϥ��ڡ����Τߤ���Ͽ������ޤ���");
			parts.sc_topwindowtitle.focus();
			return false;
	}

	
	// �إå����ѥ����ȥ�
	if( parts.sc_headertitle.value == "" ){
		alert("�إå����ѥ����ȥ�����Ϥ��Ʋ�����");
		parts.sc_headertitle.focus();
		return false;
	}else if( ! SpaceCheck( parts.sc_headertitle.value ) ) {
			alert("�إå����ѥ����ȥ�ϥ��ڡ����Τߤ���Ͽ������ޤ���");
			parts.sc_headertitle.focus();
			return false;
	}

	
	// �ԣϣж������󥿥��ȥ�
	if( parts.sc_toptitle.value == "" ){
		alert("�ԣϣж������󥿥��ȥ�����Ϥ��Ʋ�����");
		parts.sc_toptitle.focus();
		return false;
	}else if( ! SpaceCheck( parts.sc_toptitle.value ) ) {
			alert("�ԣϣж������󥿥��ȥ�ϥ��ڡ����Τߤ���Ͽ������ޤ���");
			parts.sc_toptitle.focus();
			return false;
	}

	
	// �ԣϣж������󥵥֥����ȥ�
	if( parts.sc_topsubtitle.value == "" ){
		alert("�ԣϣж������󥵥֥����ȥ�����Ϥ��Ʋ�����");
		parts.sc_topsubtitle.focus();
		return false;
	}else if( ! SpaceCheck( parts.sc_topsubtitle.value ) ) {
			alert("�ԣϣж������󥵥֥����ȥ�ϥ��ڡ����Τߤ���Ͽ������ޤ���");
			parts.sc_topsubtitle.focus();
			return false;
	}

	
	// �ԣϣХ����ڡ��󡦥��٥�Ⱦ��󥿥��ȥ�
	if( parts.sc_campaintitle.value == "" ){
		alert("�ԣϣХ����ڡ��󡦥��٥�Ⱦ��󥿥��ȥ�����Ϥ��Ʋ�����");
		parts.sc_campaintitle.focus();
		return false;
	}else if( ! SpaceCheck( parts.sc_campaintitle.value ) ) {
			alert("�ԣϣХ����ڡ��󡦥��٥�Ⱦ��󥿥��ȥ�ϥ��ڡ����Τߤ���Ͽ������ޤ���");
			parts.sc_campaintitle.focus();
			return false;
	}

	
	// �ԣϣХ��������󥿥��ȥ�
	if( parts.sc_coursetitle.value == "" ){
		alert("�ԣϣХ��������󥿥��ȥ�����Ϥ��Ʋ�����");
		parts.sc_coursetitle.focus();
		return false;
	}else if( ! SpaceCheck( parts.sc_coursetitle.value ) ) {
			alert("�ԣϣХ��������󥿥��ȥ�ϥ��ڡ����Τߤ���Ͽ������ޤ���");
			parts.sc_coursetitle.focus();
			return false;
	}

	
	// �ԣϣ��������󥿥��ȥ�
	if( parts.sc_diarytitle.value == "" ){
		alert("�ԣϣ��������󥿥��ȥ�����Ϥ��Ʋ�����");
		parts.sc_diarytitle.focus();
		return false;
	}else if( ! SpaceCheck( parts.sc_diarytitle.value ) ) {
			alert("�ԣϣ��������󥿥��ȥ�ϥ��ڡ����Τߤ���Ͽ������ޤ���");
			parts.sc_diarytitle.focus();
			return false;
	}

	
	// ��������ʸ
	if( parts.sc_addmission.value == "" ){
		alert("��������ʸ�����Ϥ��Ʋ�����");
		parts.sc_addmission.focus();
		return false;
	}else if( ! SpaceCheck( parts.sc_addmission.value ) ) {
			alert("��������ʸ�ϥ��ڡ����Τߤ���Ͽ������ޤ���");
			parts.sc_addmission.focus();
			return false;
	}

	
	// �֥��Ҳ�ʸ
	ret_disc = ReturnCntCheck( parts.sc_introduce.value , 3 );
	if( !ret_disc ){
		alert("�֥��Ҳ�ʸ�ϣ��԰�������Ϥ��Ʋ�������");
		parts.sc_introduce.focus();
		return false;
	} else {
		arrDisc = parts.sc_introduce.value.split("\n");
		cntDisc = arrDisc.length;
		cntDisc2 = arrDisc.length;
		var intBuffCnt = 0;
		for ( i=0; i<cntDisc; i++ ) {
			arrDisc[i] = ReturnDetection( arrDisc[i] );
			arrDisc[i] = ReturnDelete( arrDisc[i] );
			ibc = arrDisc[i].length;
			if ( ibc > 27 ) cntDisc2 = cntDisc2 + 1;
			intBuffCnt = intBuffCnt + ibc;
		}
		if ( intBuffCnt > 80 ) {
			alert("�֥��Ҳ�ʸ�ϣ���ʸ����������Ϥ��Ʋ�������");
			parts.sc_introduce.focus();
			return false;
		} else {
			if ( cntDisc2 > 3 ) {
				alert("�֥��Ҳ�ʸ�ϣ���ʸ���ߣ��Ԥδ֤����Ϥ��Ʋ�������");
				parts.sc_introduce.focus();
				return false;
			}
		}
	}

	// �֥����ܿ�
	intChk_bd = 9;
	intCnt_bd = parts.elements["sc_clr"].length;
	for( ix=0; ix<intCnt_bd; ix++ )
	{
		if( parts.elements["sc_clr"][ix].checked ){
			intChk_bd = 1;
		}
	}
	if( intChk_bd != 1 ){
		alert("�֥����ܿ�����ꤷ�Ʋ�������");
		parts.elements["sc_clr"][0].focus();
		return false;
	}
	
	// ����ȥ꡼�᡼��������
	if ( parts.sc_entrymail.value == "" ){
		alert("�֤��������ߡ׼�����᡼�륢�ɥ쥹�����ꤷ�Ʋ�������");
		parts.sc_entrymail.focus();
		return false;
	} else {
		if ( !EmailCheck( parts.sc_entrymail.value ) ){
			alert("�֤��������ߡ׼�����᡼�륢�ɥ쥹�����������Ϥ��Ʋ�������");
			parts.sc_entrymail.focus();
			return false;
		}
	}
	
	// ��礻�᡼��������
	if ( parts.sc_infomail.value == "" ){
		alert("�ֻ�������פ��䤤��碌�׼�����᡼�륢�ɥ쥹�����ꤷ�Ʋ�������");
		parts.sc_infomail.focus();
		return false;
	} else {
		if ( !EmailCheck( parts.sc_infomail.value ) ){
			alert("�ֻ�������פ��䤤��碌�׼�����᡼�륢�ɥ쥹�����������Ϥ��Ʋ�������");
			parts.sc_infomail.focus();
			return false;
		}
	}
	
	// �ĶȻ���
	if ( parts.sc_start_h.value == "" ) {
		alert("�Ķȳ��ϻ��֡ʻ��ˤ����򤷤Ʋ�������");
		parts.sc_start_h.focus();
		return false;
	}
	if ( parts.sc_start_m.value == "" ) {
		alert("�Ķȳ��ϻ��֡�ʬ�ˤ����򤷤Ʋ�������");
		parts.sc_start_m.focus();
		return false;
	}
	if ( parts.sc_end_h.value == "" ) {
		alert("�ĶȽ�λ���֡ʻ��ˤ����򤷤Ʋ�������");
		parts.sc_end_h.focus();
		return false;
	}
	if ( parts.sc_end_m.value == "" ) {
		alert("�ĶȽ�λ���֡�ʬ�ˤ����򤷤Ʋ�������");
		parts.sc_end_m.focus();
		return false;
	}
	
	// �����
	if ( parts.sc_holiday.value == "" ){
		alert("����������Ϥ��Ʋ�������");
		parts.sc_holiday.focus();
		return false;
	}
	
	// ��ҥۡ���ڡ���
//	if ( parts.sc_hp.value != "" ) {
//		if ( ! URLCheck( parts.sc_hp.value ) ) {
//			alert("��ҥۡ���ڡ������ɥ쥹�����������Ϥ��Ʋ�������");
//			parts.sc_hp.focus();
//			return false;
//		}
//	}
	
	// �Ǵ��������
	if ( parts.es_line1.value == "" || parts.es_sta1.value == "" ){
		alert("�Ǵ�ؤ����ꤷ�Ʋ�������");
		parts.line_setting.focus();
		return false;
	}
	if ( parts.es_walk1.value == "" ){
		alert("�Ǵ�ؤ���ν��׻��֤����ꤷ�Ʋ�������");
		parts.es_walk1.focus();
		return false;
	} else {
		if ( !IntValCheck( parts.es_walk1.value ) ) {
			alert("���׻��֤�Ⱦ�ѿ����Τ����Ϥ��Ʋ�������");
			parts.es_walk1.focus();
			return false();
		}
	}
	
	// ��ңУ�
	ret_sc_pr = ReturnCntCheck( parts.sc_pr.value , 5 );
	if( !ret_sc_pr ){
		alert("��ңУҤϣ��԰�������Ϥ��Ʋ�������");
		parts.sc_pr.focus();
		return false;
	} else {
		arrPr = parts.sc_pr.value.split("\n");
		cntPr = arrPr.length;
		cntPr2 = arrPr.length;
		var intBuffCnt2 = 0;
		for ( i=0; i<cntPr; i++ ) {
			arrPr[i] = ReturnDetection( arrPr[i] );
			arrPr[i] = ReturnDelete( arrPr[i] );
			ipr = arrPr[i].length;
			if ( ipr > 25 ) cntPr2 = cntPr2 + 1;
			intBuffCnt2 = intBuffCnt2 + ipr;
		}
		if ( intBuffCnt2 > 125 ) {
			alert("��ңУ�ʸ�ϣ�����ʸ����������Ϥ��Ʋ�������");
			parts.sc_pr.focus();
			return false;
		} else {
			if ( cntPr2 > 5 ) {
				alert("��ңУ�ʸ�ϣ���ʸ���ߣ��Ԥδ֤����Ϥ��Ʋ�������");
				parts.sc_pr.focus();
				return false;
			}
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
    ������������̤򳫤�
==================================================*/
function OpenPageSta( line , station , ln_cd , st_cd , ln_cd_name )
{
	window.open( '../station_select.php?fn=go_upd&fg=0&line='+line+'&station='+station+'&ln_cd='+ln_cd+'&st_cd='+st_cd+'&ln_cd_name='+ln_cd_name , 'station' , 'directories=no,location=no,menubar=no,toolbar=no,scrollbars=yes,width=340,height=500,left=0,top=0' );
}
