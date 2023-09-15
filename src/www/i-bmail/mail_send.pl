#!/usr/local/bin/php-cgi-4.3.6
<?php
    include "websylpheed.conf";
    include "session.lib";
    include "common.lib";
    include "functions.lib";

    $to = urldecode($to);
    $cc = urldecode($cc);
    $bcc = urldecode($bcc);
    $subject = urldecode($subject);
    $body = htmlSpecialChars(urldecode($body));

?>
<HTML>
<HEAD></HEAD>
<?php
//返信の場合
    if ( $reply == 1 ) {
        if ( ! imap_reopen($imap, "$connstr$mbox", OP_READONLY) ) {
	    echo "開けません。";
	    echo "</body></html>";
	    exit;
        }
        $header = imap_header($imap, imap_msgno($imap, $msgno));
        $subject = htmlSpecialChars( zen2han(i18n_convert( i18n_mime_header_decode($header->Subject), $internal_encoding, "AUTO" )));
        //$from = htmlSpecialChars( i18n_convert( i18n_mime_header_decode($header->fromaddress), $internal_encoding, "AUTO" ));
        $from = htmlSpecialChars( i18n_convert( i18n_mime_header_decode($header->fromaddress), $internal_encoding, "AUTO" ));
        $to = $from;	
        $body = getMailBody($imap, $msgno, FT_UID, (strlen($subject) + strlen($from) + 500), FALSE );

        $body = ereg_replace("(^|\n)([^$])","\\1>\\2",$body);
    }
    imap_close ( $imap );

    if ( $select_mail != "" ) {
        switch ( $submit_flg ) {
        case "to":
	    if ( $to != "" ) {
	        $to .= ",".$select_mail;
	    } else {
	        $to = $select_mail;
	    }
	    break;
        case "cc":
	    if ( $cc != "" ) {
	        $cc .= ",".$select_mail;
	    } else {
	        $cc = $select_mail;
	    }
	    break;
        case "bcc":
	    if ( $bcc != "" ) {
	        $bcc .= ",".$select_mail;
	    } else {
	        $bcc = $select_mail;
	    }
            break;
        }
    }
    if ( $reply != "" ) {
        $subject = "Re: ".$subject;
    }
    if ($use_db) {
        $to_submit = '<input type="submit" name="to_submit" value="アドレス帳">';
        $cc_submit = '<input type="submit" name="cc_submit" value="アドレス帳">';
        $bcc_submit = '<input type="submit" name="bcc_submit" value="アドレス帳">';
        $sign_submit = '<input type="submit" name="submit" value="署名挿入">';
        //$sign_submit = '<input type="submit" name="submit" value="SIGN">';
    } else {
        $to_submit = '';
        $cc_submit = '';
        $bcc_submit = '';
        $sign_submit = '';
    }

    $body = trim($body);
?>
<body bgcolor="<?=$bgcolor?>">
新規メール作成
<br><hr>
<form action="address.pl" method="post">
TO: <?=$to_submit?> <br>
<input type="text" size="16" istyle="3" name="to" value="<?=$to?>"> <br>

Subject:<br>
<input type="text" size="16" istyle="3" name="subject" value="<?=$subject?>"> <br>

CC: <?=$cc_submit?> <br>
<input type="text" size="16" istyle="3" name="cc" value="<?=$cc?>"> <br>

BCC:  <?=$bcc_submit?> <br>
<input type="text" size="16" istyle="3" name="bcc" value="<?=$bcc?>"> <br>

本文: <?=$sign_submit?> <br>
<textarea rows="5" cols="16" name="body">
<?PHP if ($reply != 1){ echo "$body"; } ?>

<?=i18n_convert($sign,$internal_encoding,"AUTO");?>
</textarea>
<br>
<INPUT type="hidden" name="sess" value="<?=$sess?>">
<input type="submit" name="submit" value="送信">
<input type="reset" value="クリア">
<hr><a href="top.pl?<?php echo $pwstr; ?>">[TOPページへ]</a>
</form>
</body>
</html>
