/*==================================================
    ��������Ͽ�������������ϥ����å�
==================================================*/
function AdminInputCheck( parts , parts2 )
{
	
	if( parts.ad_loginid.value == "" ){
		alert("������ID�����Ϥ��Ʋ�����");
		parts.ad_loginid.focus();
		return false;
	}
	if( !LoginValCheck( parts.ad_loginid.value ) ){
		alert("������ɣĤ�Ⱦ�ѱѿ����Τ�ͭ���Ǥ�");
		parts.ad_loginid.focus();
		return false;
	}
	
	if( parts.ad_passwd.value == "" ){
		alert("������ѥ���ɤ����Ϥ��Ʋ�����");
		parts.ad_passwd.focus();
		return false;
	}
	if( !LoginValCheck( parts.ad_passwd.value ) ){
		alert("������ѥ���ɤ�Ⱦ�ѱѿ����Τ�ͭ���Ǥ�");
		parts.ad_passwd.focus();
		return false;
	}
	
	if( parts.ad_name.value == "" ){
		alert("������̾�Τ����Ϥ��Ʋ�����");
		parts.ad_name.focus();
		return false;
	} else {
		if( ! SpaceCheck( parts.ad_name.value ) ) {
			alert("���ڡ����Τߤ���Ͽ�ϤǤ��ޤ���");
			parts.ad_name.focus();
			return false;
		}
	}
	if( parts2.ad_id.value == 1 && parts.ad_auth.checked == false ){
		alert("���δ����Ԥδ������¤��ѹ��Ǥ��ޤ���");
		parts.ad_auth.focus();
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
    �����Ծ����������å�
==================================================*/
function AdminDeleteCheck( parts , parts2 )
{
	
	if( parts2.ad_id.value == 1 ){
		alert("���δ����ԤϺ���Ǥ��ޤ���");
		return false;
	}
	
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
