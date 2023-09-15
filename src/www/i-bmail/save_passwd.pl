#!/usr/local/bin/php-cgi-4.3.6
<?php
    include "websylpheed.conf";
    include "session.lib";
    include "common.lib";

    imap_close($imap);
?>
<html>
<head></head>
<body bgcolor="<?=$bgcolor?>">
<?=$system_name?>
<br>
<form action="top.pl">
<?=$mail_addr?> のパスワードを保存します
<BR>
ログイン後再度、TOP画面に戻りますのでそこでブックマーク登録してください
<BR>
<BR>
<input type=hidden name=sess value=<?=$sess?>>
<input type=submit value="ログイン">
</form>
</body>
</html>
