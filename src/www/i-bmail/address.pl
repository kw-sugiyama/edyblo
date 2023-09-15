#!/usr/local/bin/php-cgi-4.3.6
<?PHP
    include "websylpheed.conf";
    include "session.lib";
    include "common.lib";
    include "imap-utf7.lib";
    include "functions.lib";
    if ($use_db ) {
	include $db_include; 
    }


    $to=i18n_convert($to,$internal_encoding,"AUTO");
    $cc=i18n_convert($cc,$internal_encoding,"AUTO");	
    $bcc=i18n_convert($bcc,$internal_encoding,"AUTO");	
    $subject=i18n_convert($subject,$internal_encoding,"AUTO");	
    $body=i18n_convert($body,$internal_encoding,"AUTO");	

    $to2 = urlencode($to);
    $cc2 = urlencode($cc);
    $bcc2 = urlencode($bcc);
    $subject2 = urlencode($subject);
    $body2 = urlencode($body);

?>

<HTML>
<HEAD></HEAD>
<BODY BGCOLOR="<?=$bgcolor?>">
<?PHP
	$submit=i18n_convert($submit,"SJIS","AUTO");
    if ($submit == "署名挿入"){
	$sign = getSign();
	$sign=i18n_convert($sign,$internal_encoding,"AUTO");
?>
<form action="mail_send.pl" method="post"><br>
<textarea rows="5" cols="16" name="sign"><?=$sign?></textarea>
<br>
<input type="submit" name="sign_submit" value="挿入">

<input type="hidden" name="sess" value="<?=$sess?>">
<input type="hidden" name="to" value="<?=$to2?>">
<input type="hidden" name="cc" value="<?=$cc2?>">
<input type="hidden" name="bcc" value="<?=$bcc2?>">
<input type="hidden" name="subject" value="<?=$subject2?>">
<input type="hidden" name="body" value="<?=$body2?>">

</form>
<?PHP
    } elseif ( $submit != "" ) {
 	if ( $to == "" ) {
            print '宛先が選択されていません';
	    print '<BR><A HREF="mail_send.pl?'.$pwstr.'">戻る</A>';
	} else {

	    $header = "From: " . $mail_addr;
	    $header .= "\nDate: " . date("r");
	    if ( $cc != "" ) {
	        $header .= "\nCC: ".$cc;
	    }
	    if ( $bcc != "" ) {
	        $header .= "\nBCC: ".$bcc;
	    }
	    if ( $X_Mailer != "" ){
		$header .= "\nX-Mailer: ".$X_Mailer;
	    }
  	    /* edited by muta  */	
	    $header .= "\nReturn-Path: ".$mail_addr;
	    /*$subject = han2zen($subject,$internal_encoding);
	    $subject = i18n_convert("$subject","JIS","AUTO"); */
	    $subject =  han2zen( i18n_convert($subject, "JIS", "AUTO" ), "JIS");
	    	$body =  han2zen( i18n_convert($body, "JIS", "AUTO" ), "JIS");
		if (ereg ( "(<.*>)",$to,$reg)){
        		$to = $reg[1];
		}
	    
	    mb_send_mail( $to, $subject, $body, $header );

	    /* 送信メールの保存 */
            if ( $save_sent_mail ){
		$send_folder = encode_imap_utf7( i18n_convert($personal_folders . $sent_mail, 'UTF-8', "AUTO")); 
                if (!imap_listmailbox($imap, $connstr, $send_folder)){
		    imap_createmailbox($imap, $connstr . $send_folder);
		}
		$msg  = "To: $to\n";
		$msg .= "Subject: $subject\n";
		$msg .= $header . "\n\n";
		$msg .= $body . "\n";
		imap_append($imap, $connstr . $send_folder, $msg, '\\Seen');
	    }
?>
送信完了
<HR>
<A HREF="top.pl?<?=$pwstr?>">TOPページへ</A>
<?PHP
	}
    } else {
	if ($to_submit != "") {
	    $submit_flg = "to";
            $msg = "TO: アドレス";
	}		
	if ($cc_submit != "") {
	    $submit_flg = "cc";
            $msg = "CC: アドレス";
	}
	if ($bcc_submit != "") {
	    $submit_flg = "bcc";
            $msg = "BCC: アドレス";
	}

	$list = getAddressList();
?>
<?=$msg?>
<FORM action="mail_send.pl" method="post"><br>
<?PHP
	for ( $i = 0; $i < count($list); $i++ ) {
            list($mail_add, $name) = $list[$i];
            //$name = i18n_convert($name, $internal_encoding, "EUC");
            $name = i18n_convert($name, SJIS, "EUC");
            //$mail_add = i18n_convert($mail_add, $internal_encoding, "EUC");
            $mail_add = i18n_convert($mail_add, SJIS, "EUC");
?>
<INPUT type="radio" name="select_mail" value="<?=$mail_add?>"><?=$name?><BR>
<?=$mail_add?><HR>
<?PHP
	}
?>
<INPUT type="submit" name="address" value="決定">
<INPUT type="hidden" name="sess" value="<?=$sess?>">
<INPUT type="hidden" name="submit_flg" value="<?=$submit_flg?>">
<INPUT type="hidden" name="to" value="<?=$to2?>">
<INPUT type="hidden" name="cc" value="<?=$cc2?>">
<INPUT type="hidden" name="bcc" value="<?=$bcc2?>">
<INPUT type="hidden" name="subject" value="<?=$subject2?>">
<INPUT type="hidden" name="body" value="<?=$body2?>">
</FORM>
<?PHP
    }
 if ( $use_db ) {
    db_close($conn);
 }
    imap_close($imap);
?>
</BODY></HTML>
