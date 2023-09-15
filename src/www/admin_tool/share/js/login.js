/*==================================================
    ログイン時入力チェック
==================================================*/
function ChkLogin( parts )
{
	if( parts.login_id.value == "" )
	{
		alert("IDを入力して下さい");
		parts.login_id.focus();
		return false;
	}
	
	if ( parts.login_pass.value == "" )
	{
		alert("パスワードを入力して下さい");
		parts.login_pass.focus();
		return false;
	}
	
	parts.submit();
	
}
