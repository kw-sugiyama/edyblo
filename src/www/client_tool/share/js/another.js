/*==================================================
    ����¾������Ͽ���������ϥ����å�
==================================================*/
function AnotherInputCheck( parts , parts2 )
{
	
	if( parts.another_news_title.value == "" ){
		alert("�����ȥ�����Ϥ��Ʋ�����");
		parts.another_news_title.focus();
		return false;
	} else {
		if( ! SpaceCheck( parts.another_news_title.value ) ) {
			alert("�����ȥ�ϥ��ڡ����Τߤ���Ͽ���Ǥ��ޤ���");
			parts.another_news_title.focus();
			return false;
		}
	}
	
	if( parts.another_news_comment.value == "" ){
		alert("�����ȥ�����Ϥ��Ʋ�����");
		parts.another_news_comment.focus();
		return false;
	} else {
		if( ! SpaceCheck( parts.another_news_comment.value ) ) {
			alert("��ʸ�ϥ��ڡ����Τߤ���Ͽ���Ǥ��ޤ���");
			parts.another_news_comment.focus();
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
