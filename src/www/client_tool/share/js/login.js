/*==================================================
    ����������ϥ����å�
==================================================*/
function ChkLogin()
{
	if( document.loginForm.login_id.value == "" )
	{
		alert("ID�����Ϥ��Ʋ�����");
		document.loginForm.login_id.focus();
		return false;
	}
	
	if ( document.loginForm.login_pass.value == "" )
	{
		alert("�ѥ���ɤ����Ϥ��Ʋ�����");
		document.loginForm.login_pass.focus();
		return false;
	}
	
	return true;
	
}
