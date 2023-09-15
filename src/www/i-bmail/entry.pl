#!/usr/local/bin/php-cgi-4.3.6
<?PHP
    include "websylpheed.conf";
	if (ereg ( "(Mozilla)",$HTTP_USER_AGENT,$reg)){
		echo "ERROR";
		exit;
	}
?>
<HTML>
<HEAD>
<TITLE><?=$system_name?></TITLE>
<META HTTP-EQUIV="Pragma" CONTENT="no-cache">
<META HTTP-EQUIV="Cache-Control" CONTENT="no-cache">
<META http-equiv="Content-Type" content="text/html; charset=SHIFT_JIS">
</HEAD>
<DIV ALIGN="CENTER">
<BODY bgcolor="<?=$bgcolor?>">
<?PHP 
if ($mode == "no") {
	echo "BAD USERID";
}
?>
<?=$system_name?><BR>
<FORM action="top.pl" method="post">
ユーザーID<BR>
<INPUT type="text" istyle="3" size="16" name="user_id">
<BR>
パスワード<BR>
<INPUT type="text" istyle="3" size="16" name="passwd">
<BR>
<INPUT type="hidden" name="first_sess" value=1>
<INPUT type="submit" value="ログイン">
<INPUT type="reset" value="クリア">
</FORM>
</DIV>
</BODY>
</HTML>
