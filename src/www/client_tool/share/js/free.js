/*==================================================
    �֥����ܾ�����Ͽ���������ϥ����å�
==================================================*/
function freeInputCheck( parts , parts2 )
{


	// �����ȥ�
	if( parts.fr_title.value === "" ){
		alert("�����ȥ�����Ϥ��Ʋ�������");
		parts.fr_title.focus();
		return false;
	} else {
		if( ! SpaceCheck( parts.fr_title.value ) ) {
			alert("�����ȥ�ϥ��ڡ����Τߤ���Ͽ������ޤ���");
			parts.fr_title.focus();
			return false;
		}
	}




	// �����ȥ�
	if( parts.fr_html.value === "" ){
		alert("��ͳ�ȣԣ̤ͣ����Ϥ��Ʋ�������");
		parts.fr_html.focus();
		return false;
	} else {
		if( ! SpaceCheck( parts.fr_html.value ) ) {
			alert("��ͳ�ȣԣ̤ͣϥ��ڡ����Τߤ���Ͽ������ޤ���");
			parts.fr_html.focus();
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
function FreeDeleteCheck( parts , parts2 )
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
