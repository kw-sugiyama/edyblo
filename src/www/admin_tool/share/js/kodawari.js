/*==================================================
    �֥����ܾ�����Ͽ���������ϥ����å�
==================================================*/
function BuildInputCheck( parts , parts2 )
{
	
	// ��ʪ̾��(������)
	if( parts.build_name.value == "" ){
		alert("��ʪ̾�����Ϥ��Ʋ�������");
		parts.build_name.focus();
		return false;
	} else {
		if( ! SpaceCheck( parts.build_name.value ) ) {
			alert("��ʪ̾�ϥ��ڡ����Τߤ���Ͽ������ޤ���");
			parts.build_name.focus();
			return false;
		}
	}
	
	// ��ʪ̾��(ɽ����)
	if( parts.build_name_disp.value == "" ){
		alert("��ʪ̾�Τ����Ϥ��Ʋ�������");
		parts.build_name_disp.focus();
		return false;
	} else {
		if( ! SpaceCheck( parts.build_name_disp.value ) ) {
			alert("��ʪ̾�Τϥ��ڡ����Τߤ���Ͽ������ޤ���");
			parts.build_name_disp.focus();
			return false;
		}
	}

	// ʪ�ｻ��(ɽ����)
	if( parts.build_zip1.value == "" || parts.build_zip2.value == "" || parts.build_pref.value == "" || parts.build_address1.value == ""){
		alert("ʪ�ｻ������Ϥ��Ʋ�������");
		parts.build_zip1.focus();
		return false;
	}
	if( ! IntValCheck( parts.build_zip1.value ) ) {
		alert("͹���ֹ��Ⱦ�ѿ����Τߤ����Ϥ��Ʋ�������");
		parts.build_zip1.focus();
		return false;
	}
	if( ! IntValCheck( parts.build_zip2.value ) ) {
		alert("͹���ֹ��Ⱦ�ѿ����Τߤ����Ϥ��Ʋ�������");
		parts.build_zip2.focus();
		return false;
	}
	if( parts.build_address2.value == "" ){
		alert("���Ϥ����Ϥ��Ʋ�������");
		parts.build_address2.focus();
		return false;
	} else {
		if( ! SpaceCheck( parts.build_address2.value ) ) {
			alert("���Ϥϥ��ڡ����Τߤ���Ͽ������ޤ���");
			parts.build_address2.focus();
			return false;
		}
	}

	// �Ǵ��1
	if( parts.build_line_name_1.value == "" || parts.build_sta_name_1.value == "" ){
		alert("�������ؤ����ꤷ�Ʋ�������");
		parts.line_setting1.focus();
		return false;
	}
	if( parts.build_move_1.value == "" ){
		alert("��ư���֤����Ϥ��Ʋ�������");
		parts.build_move_1.focus();
		return false;
	}else if( ! IntValCheck( parts.build_move_1.value ) ) {
		alert("��ư���֤�Ⱦ�ѿ����Τߤ����Ϥ��Ʋ�������");
		parts.build_move_1.focus();
		return false;
	}
	if( parts.build_move_bus_1.value != "" ) {
		if ( ! IntValCheck( parts.build_move_bus_1.value ) ) {
			alert("�Х��Ǥΰ�ư���֤�Ⱦ�ѿ����Τߤ����Ϥ��Ʋ�������");
			parts.build_move_bus_1.focus();
			return false;
		}
	}
	
	// �Ǵ��2
	if( parts.build_line_name_2.value != "" && parts.build_sta_name_2.value != "" ){
		if( parts.build_move_2.value == "" ){
			alert("��ư���֤����Ϥ��Ʋ�������");
			parts.build_move_2.focus();
			return false;
		}
		if( ! IntValCheck( parts.build_move_2.value ) ){
			alert("��ư���֤�Ⱦ�ѿ����Τߤ����Ϥ��Ʋ�������");
			parts.build_move_2.focus();
			return false;
		}
		if( parts.build_move_bus_2.value != "" ) {
			if ( ! IntValCheck( parts.build_move_bus_2.value ) ) {
				alert("�Х��Ǥΰ�ư���֤�Ⱦ�ѿ����Τߤ����Ϥ��Ʋ�������");
				parts.build_move_bus_2.focus();
				return false;
			}
		}
	}
	
	// ��ǯ��
	if( parts.build_date_year.value == "" ){
		alert("��ǯ������Ϥ��Ʋ�������");
		parts.build_date_year.focus();
		return false;
	}else{
		if( ! IntValCheck( parts.build_date_year.value ) ) {
			alert("��ǯ���Ⱦ�ѿ����Τߤ����Ϥ��Ʋ�������");
			parts.build_date_year.focus();
			return false;
		}
		if( ! StrCountCheck_Equal( parts.build_date_year.value , 4 ) ){
			alert("��ǯ��(ǯ)����������Ϥ��Ʋ�������");
			parts.build_date_year.focus();
			return false;
		}
	}
	if( parts.build_date_month.value == "" ){
		alert("��ǯ������Ϥ��Ʋ�������");
		parts.build_date_month.focus();
		return false;
	}else if( ! IntValCheck( parts.build_date_month.value ) ) {
		alert("��ǯ���Ⱦ�ѿ����Τߤ����Ϥ��Ʋ�������");
		parts.build_date_month.focus();
		return false;
	}
	
	// ���۹�¤
	if( parts.build_material.value == "" ){
		alert("���۹�¤�����Ϥ��Ʋ�������");
		parts.build_material.focus();
		return false;
	}
	
	// ����
	if( parts.build_all_floor.value == "" ){
		alert("���������Ϥ��Ʋ�������");
		parts.build_all_floor.focus();
		return false;
	}else if( ! IntValCheck( parts.build_all_floor.value ) ) {
		alert("������Ⱦ�ѿ����Τߤ����Ϥ��Ʋ�������");
		parts.build_all_floor.focus();
		return false;
	}
	
	// ��ʪ������
	if( parts.build_type.value == "" ){
		alert("��ʪ�����פ���ꤷ�Ʋ�������");
		parts.build_type.focus();
		return false;
	}
	
	// ���Ѳ���
	if ( parts.build_photo_lastupd.value == "" && parts.build_photo.value == "" ){
		alert("���Ѳ��������ꤷ�Ʋ�������");
		parts.build_photo.focus();
		return false;
	}
	
	// �Ͽ޾���
	if ( parts.mkr_flg.value == ""){
		alert("�Ͽ޾�������ꤷ�Ʋ�������");
		parts.onMarker.focus();
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
    ��ʪ��������ǧ
==================================================*/
function BuildDeleteCheck( parts , parts2 )
{
	ret_com = confirm("������ޤ���������Ǥ�����");
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
    ���긡��
==================================================*/
function zipSearch(){
	build_zip = document.build.build_zip1.value + "-" + document.build.build_zip2.value;
	window.open('../zip_search.php?fn=build&zip='+build_zip+'&pc=build_pref_cd&ad1=build_pref&adc=build_addr_cd&ad2=build_address1&ad3=build_address2','','directories=no,location=no,menubar=no,toolbar=no,width=10,height=10','');
}


/*==================================================
    ��������̤򳫤�
==================================================*/
function OpenPageSta( line , station , ln_cd , st_cd , st_cd_name )
{
	window.open( '../station_select.php?fn=build&fg=0&line='+line+'&station='+station+'&ln_cd='+ln_cd+'&st_cd='+st_cd+'&ln_cd_name='+st_cd_name , 'station' , 'directories=no,location=no,menubar=no,toolbar=no,scrollbars=yes,width=340,height=500,left=0,top=0' );
}


/*==================================================
    ����������̤򳫤�
==================================================*/
function OpenPageLine( line , station , ln_cd , st_cd , st_cd_name )
{
	window.open( '../line_select.php?fn=build&fg=0&line='+line+'&station='+station+'&ln_cd='+ln_cd+'&st_cd='+st_cd+'&ln_cd_name='+st_cd_name , 'station' , 'directories=no,location=no,menubar=no,toolbar=no,scrollbars=yes,width=340,height=500,left=0,top=0' );
}


/*==================================================
    �Զ�Į¼������̤򳫤�
==================================================*/
function OpenPageArea( line , station , ln_cd , st_cd , st_cd_name )
{
	window.open( '../area_select.php?fn=build&fg=0&line='+line+'&station='+station+'&ln_cd='+ln_cd+'&st_cd='+st_cd+'&ln_cd_name='+st_cd_name , 'station' , 'directories=no,location=no,menubar=no,toolbar=no,scrollbars=yes,width=340,height=500,left=0,top=0' );
}


/*==================================================
    �ꥹ�ȥꥻ�å�
==================================================*/
function ListReset( cd , txtAr )
{
	document.getElementById(cd).value = "";
	document.getElementById(txtAr).value = "";

}
