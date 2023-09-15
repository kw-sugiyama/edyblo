#!/usr/local/bin/php-cgi-4.3.6
<?PHP

    include "websylpheed.conf";
    include "session.lib";
    include "common.lib";
    include "imap-utf7.lib";
    include "functions.lib";
?>

<HTML>
<BODY bgcolor="<? echo $bgcolor; ?>">
<?PHP
    if ( ! imap_reopen($imap, "$connstr$mbox") ) {
        echo "開けません。";
        echo "</BODY></HTML>";
        exit;
    }

imap_delete($imap,imap_msgno($imap, $msgno));
imap_expunge ($imap);
print "NO[$msg_no]メールを削除しました。";
print '<BR><A HREF="maillist.pl?'.$pwstr.'">戻る</A>';
imap_close ($imap);
?>
</BODY>
</HTML>
