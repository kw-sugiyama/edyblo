/*==================================================
    ���饤����Ȱ��������������å�
==================================================*/
function ClientSearchCheck( parts , parts2 )
{
	// ���̾����
	if ( parts.sea_cl_name_like.value != "" ){
		if( ! SpaceCheck( parts.sea_cl_name_like.value ) ) {
			alert("���̾����Ǥϥ��ڡ����Τߤθ����ϤǤ��ޤ���");
			parts.sea_cl_name_like.focus();
			return false;
		}
	}
	
	// ���Ѵ��¸���(����)
	if ( parts.sea_cl_limit_date_s_y.value != "" || parts.sea_cl_limit_date_s_m.value != "" || parts.sea_cl_limit_date_s_d.value != "" ){
		if ( parts.sea_cl_limit_date_s_y.value == "" || parts.sea_cl_limit_date_s_m.value == "" || parts.sea_cl_limit_date_s_d.value == "" ){
			alert("���Ѵ��¡ʳ��ϡˤ����������ꤷ�Ʋ�������");
			parts.sea_cl_limit_date_s_y.focus();
			return false;
		}
		ldsy_txt = parts.sea_cl_limit_date_s_y.value+"-"+parts.sea_cl_limit_date_s_m.value+"-"+parts.sea_cl_limit_date_s_d.value
		if ( !DateCheck_1( ldsy_txt ) ) {
			alert("���Ѵ��¡ʳ��ϡˤ����������򤷤Ʋ�������");
			parts.sea_cl_limit_date_s_y.focus();
			return false;
		}
	}
	
	// ���Ѵ��¸���(��λ)
	if ( parts.sea_cl_limit_date_e_y.value != "" || parts.sea_cl_limit_date_e_m.value != "" || parts.sea_cl_limit_date_e_d.value != "" ){
		if ( parts.sea_cl_limit_date_e_y.value == "" || parts.sea_cl_limit_date_e_m.value == "" || parts.sea_cl_limit_date_e_d.value == "" ){
			alert("���Ѵ��¡ʽ�λ�ˤ����������ꤷ�Ʋ�������");
			parts.sea_cl_limit_date_e_y.focus();
			return false;
		}
		ldsy_txt = parts.sea_cl_limit_date_e_y.value+"-"+parts.sea_cl_limit_date_e_m.value+"-"+parts.sea_cl_limit_date_e_d.value
		if ( !DateCheck_1( ldsy_txt ) ) {
			alert("���Ѵ��¡ʽ�λ�ˤ����������򤷤Ʋ�������");
			parts.sea_cl_limit_date_e_y.focus();
			return false;
		}
	}
	
	return true;
}


/*==================================================
    ���饤�������Ͽ�������������ϥ����å�
==================================================*/
function ClientInputCheck( parts , parts2 )
{
	
	// ����
	if( !parts.elements["cl_stat"][0].checked && !parts.elements["cl_stat"][1].checked ) {
		alert("���֤���ꤷ�Ʋ�����");
		parts.elements["cl_stat"][0].focus();
		return false;
	}
	
	// ���̾
	if( parts.cl_jname.value == "" ){
		alert("���̾�����Ϥ��Ʋ�����");
		parts.cl_jname.focus();
		return false;
	} else {
		if( ! SpaceCheck( parts.cl_jname.value ) ) {
			alert("���̾�ϥ��ڡ����Τߤ���Ͽ�ϤǤ��ޤ���");
			parts.cl_jname.focus();
			return false;
		}
	}
	
	// ��Ź̾
	if( parts.cl_kname.value != "" ){
		if( ! SpaceCheck( parts.cl_kname.value ) ) {
			alert("��Ź̾�ϥ��ڡ����Τߤ���Ͽ�ϤǤ��ޤ���");
			parts.cl_kname.focus();
			return false;
		}
	}
	
	// ô����̾
	if( parts.cl_agent.value != "" ){
		if( ! SpaceCheck( parts.cl_agent.value ) ) {
			alert("ô����̾�ϥ��ڡ����Τߤ���Ͽ�ϤǤ��ޤ���");
			parts.cl_agent.focus();
			return false;
		}
	}
	
	// ��ҽ���
	if( parts.ar_zip1.value == "" ){
		alert("͹���ֹ�����򤷤Ʋ�������");
		parts.ar_zip1.focus();
		return false;
	}
	if( parts.ar_zip2.value == "" ){
		alert("͹���ֹ�����򤷤Ʋ�������");
		parts.ar_zip2.focus();
		return false;
	}
	if( parts.ar_add.value == "" ){
		alert("���Ϥ����Ϥ��Ʋ�����");
		parts.ar_add.focus();
		return false;
	} else {
		if( ! SpaceCheck( parts.ar_add.value ) ) {
			alert("���Ϥϥ��ڡ����Τߤ���Ͽ�ϤǤ��ޤ���");
			parts.ar_add.focus();
			return false;
		}
	}

	if( parts.ar_estate.value != "" ){
		if( ! SpaceCheck( parts.ar_estate.value ) ) {
			alert("��ʪ̾�ϥ��ڡ����Τߤ���Ͽ�ϤǤ��ޤ���");
			parts.ar_estate.focus();
			return false;
		}
	}
	
	// ��������ֹ�
/* 20100218 ���饤����������ֹ�����å��򥳥��ȥ�����
	if( parts.cl_phone.value != "" ){
		if( ! SpaceCheck( parts.cl_phone.value ) ) {
			alert("��������ֹ�ϥ��ڡ����Τߤ���Ͽ�ϤǤ��ޤ���");
			parts.cl_phone.focus();
			return false;
		}
		if( ! TellCheck_2( parts.cl_phone.value ) ) {
			alert("��������ֹ��'-'�դ�Ⱦ�ѿ��������Ϥ��Ʋ�������");
			parts.cl_phone.focus();
			return false;
		}
	}
*/	
	// ��ңƣ���
	if( parts.cl_fax.value != "" ){
		if( ! SpaceCheck( parts.cl_fax.value ) ) {
			alert("��ңƣ����ֹ�ϥ��ڡ����Τߤ���Ͽ�ϤǤ��ޤ���");
			parts.cl_fax.focus();
			return false;
		}
		if( ! TellCheck_2( parts.cl_fax.value ) ) {
			alert("��ңƣ����ֹ��'-'�դ�Ⱦ�ѿ��������Ϥ��Ʋ�������");
			parts.cl_fax.focus();
			return false;
		}
	}
	
	// ô���ԣť᡼��
	if( parts.cl_mail.value == "" ){
		alert("ô���ԣť᡼�륢�ɥ쥹�����Ϥ��Ʋ�����");
		parts.cl_mail.focus();
		return false;
	} else {
		if( ! EmailCheck( parts.cl_mail.value ) ) {
			alert("ô���ԣť᡼�륢�ɥ쥹�����������Ϥ��Ʋ�������");
			parts.cl_mail.focus();
			return false;
		}
	}
	
	// ������ɣ�
	if( parts.cl_loginid.value == "" ){
		alert("������ID�����Ϥ��Ʋ�����");
		parts.cl_loginid.focus();
		return false;
	}
	if( !LoginValCheck( parts.cl_loginid.value ) ){
		alert("������ɣĤ�Ⱦ�ѱѿ����Τ�ͭ���Ǥ�");
		parts.cl_loginid.focus();
		return false;
	}
	
	// ������У��ӣ�
	if( parts.cl_passwd.value == "" ){
		alert("������ѥ���ɤ����Ϥ��Ʋ�����");
		parts.cl_passwd.focus();
		return false;
	}
	if( !LoginValCheck( parts.cl_passwd.value ) ){
		alert("������ѥ���ɤ�Ⱦ�ѱѿ����Τ�ͭ���Ǥ�");
		parts.cl_passwd.focus();
		return false;
	}
	
	// ���ɥ쥹�ѣɣ�
	if( parts.cl_dokuji_flg.value != 1){
		if( parts.cl_urlcd.value == "" ){
			alert("�գң��ѥ����ɤ����Ϥ��Ʋ�����");
			parts.cl_urlcd.focus();
			return false;
		}
		if( !TargetValCheck( parts.cl_urlcd.value , "^[a-z0-9\-]+$" ) ){
			alert("�գң��ѥ����ɤ�Ⱦ�Ѿ�ʸ���ѿ����ȡ� -�ʥϥ��ե�ˡפΤ�ͭ���Ǥ���");
			parts.cl_urlcd.focus();
			return false;
		}
	}
	
	// �ȼ��ɥᥤ���/�Բ�
	if( !parts.elements["cl_dokuji_flg"][0].checked && !parts.elements["cl_dokuji_flg"][1].checked ) {
		alert("�ȼ��ɥᥤ���/�ԲĤ���ꤷ�Ʋ�����");
		parts.elements["cl_dokuji_flg"][0].focus();
		return false;
	}
	
	// �ȼ���GoogleMap API Key
	if( parts.cl_dokuji_flg[0].checked == true && parts.cl_googlemap_key.value == "" ){
		alert("�ȼ��ɥᥤ��Ĥξ����ȼ���GoogleMap API Key�����Ϥ��Ʋ�������");
		parts.cl_googlemap_key.focus();
		return false;
	}
	
	// �ȼ��ɥᥤ��
	if( parts.cl_dokuji_flg[0].checked == true && parts.cl_dokuji_domain.value == "" ){
		alert("�ȼ��ɥᥤ��Ĥξ����ȼ��ɥᥤ������Ϥ��Ʋ�������");
		parts.cl_dokuji_domain.focus();
		return false;
	}
	
	// ͭ������
	if ( parts.cl_end_y.value != "" || parts.cl_end_m.value != "" || parts.cl_end_d.value != "" ) {
		if ( parts.cl_end_y.value == "" || parts.cl_end_m.value == "" || parts.cl_end_d.value == "" ) {
			alert("���դ����������򤷤Ʋ�������");
			parts.cl_end_y.focus();
			return false;
		} else {
			txt_limit_date = parts.cl_end_y.value+"-"+parts.cl_end_m.value+"-"+parts.cl_end_d.value;
			if ( !DateCheck_1( txt_limit_date ) ) {
				alert("���դ����������򤷤Ʋ�������");
				parts.cl_end_y.focus();
				return false;
			}
		}
	}
	// ����Ǻ�
	if( !parts.elements["cl_advertisement_flg"][0].checked && !parts.elements["cl_advertisement_flg"][1].checked ) {
		alert("����Ǻܲ�/�ԲĤ���ꤷ�Ʋ�����");
		parts.elements["cl_advertisement_flg"][0].focus();
		return false;
	}
	// ���𥿥�
	if( parts.cl_advertisement_flg[0].checked == true && parts.cl_advertisement_tag.value == "" ){
		alert("����ǺܲĤξ��Ϲ��𥿥������Ϥ��Ʋ�������");
		parts.cl_advertisement_tag.focus();
		return false;
	}
	
	ret_com = confirm("��Ͽ���������ޤ���������Ǥ�����");
	if( !ret_com ){
		return false;
	}
	
	parts2.submit();
	return true;
	
}


/*==================================================
    ���饤����Ⱦ����������å�
==================================================*/
function ClientDeleteCheck( parts , parts2 )
{
	
	ret_com = confirm("������ޤ���������Ǥ�����");
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
    ���긡��
==================================================*/
function zipSearch(){
	ar_zip = document.client.ar_zip1.value + "-" + document.client.ar_zip2.value;
	window.open('../zip_search.php?fn=client&zip='+ar_zip+'&pc=ar_prefcd&ad1=ar_pref&adc=ar_citycd&ad2=ar_city&ad3=ar_add','','directories=no,location=no,menubar=no,toolbar=no,width=10,height=10','');
}


/*==================================================
    ���ꥢ��
==================================================*/
function zipSearch1(){
	ar_zip1 = document.client.ar_zip1_1.value + "-" + document.client.ar_zip1_2.value;
	window.open('../zip_search.php?fn=client&zip='+ar_zip1+'&pc=ar_prefcd1&ad1=ar_pref1&adc=ar_citycd1&ad2=ar_city1&ad3=ar_add1','','directories=no,location=no,menubar=no,toolbar=no,width=10,height=10','');
}


/*==================================================
    ���ꥢ��
==================================================*/
function zipSearch2(){
	ar_zip2 = document.client.ar_zip2_1.value + "-" + document.client.ar_zip2_2.value;
	window.open('../zip_search.php?fn=client&zip='+ar_zip2+'&pc=ar_prefcd2&ad1=ar_pref2&adc=ar_citycd2&ad2=ar_city2&ad3=ar_add2','','directories=no,location=no,menubar=no,toolbar=no,width=10,height=10','');
}


/*==================================================
    ���ꥢ��
==================================================*/
function zipSearch3(){
	ar_zip3 = document.client.ar_zip3_1.value + "-" + document.client.ar_zip3_2.value;
	window.open('../zip_search.php?fn=client&zip='+ar_zip3+'&pc=ar_prefcd3&ad1=ar_pref3&adc=ar_citycd3&ad2=ar_city3&ad3=ar_add3','','directories=no,location=no,menubar=no,toolbar=no,width=10,height=10','');
}


/*==================================================
    URL�ѥ����ɽ�ʣ�����å�
==================================================*/
function url_code_chk( parts ){
	cl_cd = document.client.cl_urlcd.value;
	cl_id = document.client.cl_id.value;
	window.open( '../account_search.php?ac='+cl_cd+'&ci='+cl_id , '' , 'directories=no,location=no,menubar=no,toolbar=no,width=300,height=50' , '');
}
