/*==================================================
    �Ʒ���󼡥ڡ������å�
==================================================*/
function EstateSelect( parts , flg )
{
	
	switch( flg ){
		case 1:
			parts.action = "estate_news_mnt.html";
			break;
		case 2:
			parts.action = "room_main.html";
			break;
		default:
			alert("�ͤ�����ǤϤ���ޤ���");
			return false;
	}
	
	parts.submit();
	return true;
	
}


/*==================================================
    �Ʒ������Ͽ���������ϥ����å�
==================================================*/
function EstateInputCheck( parts , parts2 )
{
	
	if( ! parts.elements["stat"][0].checked && ! parts.elements["stat"][1].checked ){
		alert("���֤���ꤷ�Ʋ�������");
		parts.elements["stat"][0].focus();
		return false;
	}
	
	if( parts.category_name.value == "" ){
		alert("���ƥ��꡼̾�����Ϥ��Ʋ�����");
		parts.category_name.focus();
		return false;
	} else {
		if( ! SpaceCheck( parts.category_name.value ) ) {
			alert("���ƥ��꡼̾�ϥ��ڡ����Τߤ���Ͽ���Ǥ��ޤ���");
			parts.category_name.focus();
			return false;
		}
	}
	
	if( parts.disp_no.value == "" ){
		alert("ɽ��������Ϥ��Ʋ�����");
		parts.disp_no.focus();
		return false;
	} else {
		if( ! IntValCheck( parts.disp_no.value ) ) {
			alert("ɽ�����Ⱦ�ѿ����Τߤ����Ϥ��Ʋ�������");
			parts.disp_no.focus();
			return false;
		}
	}
	
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


