/*==================================================
    �֥����ܾ�����Ͽ���������ϥ����å�
==================================================*/
function BuildSearchCheck( parts , parts2 )
{
	// ��ʪ̾
	if( ! SpaceCheck( parts.search_build_name.value ) ) {
		alert("��ʪ̾�ϥ��ڡ����Τߤθ���������ޤ���");
		parts.search_build_name.focus();
		return false;
	}
	
	// ��ʪ�����
	if( ! SpaceCheck( parts.search_address.value ) ) {
		alert("��ʪ����Ϥϥ��ڡ����Τߤθ���������ޤ���");
		parts.search_address.focus();
		return false;
	}
	
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



