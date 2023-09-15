/*==================================================
    ログイン時入力チェック
==================================================*/
function ChkLogin()
{
	if( document.loginForm.login_id.value == "" )
	{
		alert("IDを入力して下さい");
		document.loginForm.login_id.focus();
		return false;
	}
	
	if ( document.loginForm.login_pass.value == "" )
	{
		alert("パスワードを入力して下さい");
		document.loginForm.login_pass.focus();
		return false;
	}
	
	return true;
	
}
