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
<?=$mail_addr?> �̃p�X���[�h��ۑ����܂�
<BR>
���O�C����ēx�ATOP��ʂɖ߂�܂��̂ł����Ńu�b�N�}�[�N�o�^���Ă�������
<BR>
<BR>
<input type=hidden name=sess value=<?=$sess?>>
<input type=submit value="���O�C��">
</form>
</body>
</html>
