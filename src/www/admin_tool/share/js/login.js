/*==================================================
    ����������ϥ����å�
==================================================*/
function ChkLogin( parts )
{
	if( parts.login_id.value == "" )
	{
		alert("ID�����Ϥ��Ʋ�����");
		parts.login_id.focus();
		return false;
	}
	
	if ( parts.login_pass.value == "" )
	{
		alert("�ѥ���ɤ����Ϥ��Ʋ�����");
		parts.login_pass.focus();
		return false;
	}
	
	parts.submit();
	
}
