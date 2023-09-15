#!/usr/local/bin/php-cgi-4.3.6
<?
    include "websylpheed.conf";
    include "session.lib";
    include "common.lib";
    include "functions.lib";
    include "imap-utf7.lib";

    if ($mbox == "") {
       $mbox = "INBOX";
    }
    $mbox2 = urlencode($mbox);
    $default_char_nums = 1500;
    if ($set_seen_flag) {
        $flg = 0;
    } else {
        $flg = OP_READONLY;
    }

    /* メールサーバへの接続 */
    if ( ! imap_reopen($imap, "$connstr$mbox", $flg) ) {
?>
<HTML>
<BODY bgcolor="<? echo $bgcolor; ?>">
開けません。
</BODY></HTML>
<?PHP
        exit;
    }

    /* メール取り込み */
    $header = imap_header($imap, imap_msgno($imap, $msgno));
    $subject = zen2han(i18n_mime_htmlSpecialChars( $header->Subject ));
    $from = zen2han(i18n_mime_htmlSpecialChars( $header->fromaddress ));
    $to = zen2han(i18n_mime_htmlSpecialChars( $header->toaddress ));
    $body = getMailBody($imap, $msgno, FT_UID, (strlen($subject) + strlen($from)) + strlen($to) + 20);

    /* フラグの更新(既読にする）*/
    $status = imap_setflag_full($imap,imap_msgno($imap, $msgno),"\\Seen \\Flagged");
    $msg_no = imap_msgno($imap, $msgno);
    /* ヘッダ部の表示設定 */
    if ($subject_mark != ""){
        $d_subject = "$subject_mark $subject<BR>";
    }
    if ($from_mark != ""){
        $d_from = "$from_mark $from<BR>";
    }
    if ($to_mark != ""){
        $to_addr = $header->to[0]->mailbox . "@" . $header->to[0]->host;
        if ( $mail_addr != $to_addr ){
	    $d_to = "$to_mark $to<BR>";
        }
    }
    if ($date_mark != ""){
        list ($sec, $min, $hour, $day, $mon, $year) = parseDate($header->Date);
	if ( $year > 0 && $mon > 0 && $day > 0 ){
            $d_date = "$date_mark ".($mon+0)."月".($day+0)."日 "."$hour:$min:$sec";
        }
    }
    $param = "$pwstr&reply=1&mbox=$mbox2&msgno=$msgno";
    imap_close($imap);

    
    $body = ereg_replace ("<BR>","\t",$body);
    $bodynums = mbstrlen($body,SJIS);
    
    if ( $bodynums > $default_char_nums) {
		if ( !$start ) { 
				$start = 0;
				$pages = round ($bodynums / $default_char_nums);
				$fixed_pages = round ($bodynums / $default_char_nums) + 1;
				$body = mbsubstr($body,$start,$default_char_nums);
    				$body = ereg_replace ("\t","<BR>",$body);
				$start = $start + $default_char_nums;
				$pages = $pages -1;
				$page =1;

		} elseif ($start >= 1 ) {	
    				$body = mbsubstr($body,$start,$default_char_nums);
    				$body = ereg_replace ("\t","<BR>",$body);
				$start = $start + $default_char_nums;
				$pages = $pages -1;
				$fixed_pages = round ($bodynums / $default_char_nums) + 1;
				$page++;
		}
    } else {
		$body = ereg_replace ("\t","<BR>",$body);	
    }

?>
<HTML>
<BODY bgcolor="<? echo $bgcolor; ?>">
<?PHP
if ( $start == 0 && $bodynums > $default_char_nums){ 
	echo "$d_subject";
	echo "$d_from";
	echo "$d_to";
	echo "$d_date";
	echo "<HR>";
}
?>
<?PHP
	if ( $bodynums > $default_char_nums ) {
			print "$page/$fixed_pages page<P>";
        }
?>
<?=$body?>
<?PHP
	if ( $bodynums > $default_char_nums && $pages >= 0 ) {
			print "<BR><BR><A HREF=$PHP_SELF?$param&start=$start&pages=$pages&page=$page&fixed_pages=$fixed_pages>続きを読む</A>";
        }
?>
<BR><BR>1 <A ACCESSKEY="1" HREF="maillist.pl?<?=$pwstr?>">全メール一覧</A>
<BR>2 <A ACCESSKEY="2" HREF="maillist2.pl?<?=$pwstr?>">未読メール一覧</A>
<BR>6 <A ACCESSKEY="3" HREF="mail_send.pl?<?=$param?>">メール返信</A>
<BR>7 <A ACCESSKEY="7" HREF="delete_mail.pl?<?=$pwstr?>&msg_no=<?=$msg_no?>&msgno=<?=$msgno?>">メール削除</A>
<BR>8 <A ACCESSKEY="8" HREF="logout.pl">ログアウト</A>
<BR><A ACCESSKEY="0" HREF="top.pl?<?=$pwstr?>">[TOPページへ]</A>
</BODY>
</HTML>
