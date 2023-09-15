#!/usr/local/bin/php-cgi-4.3.6
<? 
    include "websylpheed.conf";
    include "session.lib";
    include "common.lib";
    include "imap-utf7.lib";
    include "functions.lib";

    if ($mbox == "") {
       $mbox = "INBOX";
    }
    $mbox2 = urlencode($mbox);

    if ($mbox == "INBOX") {
       $boxName = "受信箱";
    } else {
        $boxName = i18n_convert( decode_imap_utf7($mbox), $internal_encoding,  'UTF-8' );
        if ($personal_folders != "" ){
	    $boxName = ereg_replace("^".$personal_folders, "", $boxName );
        }
    }
    $boxName = zen2han($boxName);
?>
<HTML>
<HEAD>
<TITLE><?=$boxName?> - <?=$mail_addr?></TITLE>
</HEAD>
<BODY BGCOLOR="<? echo $bgcolor; ?>">
未読メール一覧
<?
    if ( ! imap_reopen($imap, "$connstr$mbox", OP_READONLY) ) {
        echo "開けません。";
        echo "</BODY></HTML>";
        exit;
    }

    /* メールリストの作成
       INBOX の場合、削除済みメールを表示しない */
    $mail_array = imap_sort($imap, SORTARRIVAL, 0, SE_UID);
    if ($mbox != "INBOX" || $show_deleted){
        $mail_list = $mail_array;
    } else {
        $mail_list = array();
        while(list($key, $msgid) = each($mail_array)) {
	    $header = imap_header($imap, imap_msgno($imap, $msgid));
	    if ($header->Unseen == 'U' ){
	        $mail_list[] = $msgid;
	    }
        }
    }

    $msg_num = count($mail_list);
    if ( $msg_num <= 0 ) {
        echo "<BR>未読メッセージは0通です。";
	echo '<BR><A HREF="top.pl';echo "?$pwstr"; echo '">[TOPページへ]</A>';
        echo "</BODY></HTML>";
        exit;
    }

    /* 表示範囲の設定 */
    if ( $top == "" || $top > $msg_num ) {
        $top = $msg_num -1;
    }
    $end = $top - $maillist_num + 1;
    if ( $end < 1 ) {
        $end = 0;
    }

    /* ページ位置計算 */
    $page1 = ceil(($msg_num-$top+1) / $maillist_num);
    $page2 = ceil(($msg_num-1) / $maillist_num);
    if ($page2 > 1){
	$page = "[$page1/$page2]";
    }

    /* 前次ページボタン */
    $nav = "";
    if ( $top - $maillist_num > 1 ) {
       $next_top = $top - $maillist_num;
       $nav = $nav . "<A HREF=maillist2.pl?$pwstr&mbox=$mbox2&top=$next_top>[次へ]</A>\n";
    }
    if ( $top < $msg_num-1 ) {
       $next_top = $top + $maillist_num;
       $nav = $nav . "<A HREF=maillist2.pl?$pwstr&mbox=$mbox2&top=$next_top>[前へ]</A>\n";
    }
?>
<?=$page?><BR>
<?=$nav?><HR>
<?PHP

    /* 表示範囲内のメール一覧 */
    for ($i = $top; $i >= $end; $i --) {
        $msgno = $mail_list[$i];
        $header = imap_header($imap, imap_msgno($imap, $msgno));

	/* 件名の設定 */
        $subject = i18n_mime_htmlSpecialChars($header->Subject);
        //$subject = $header->Subject;
	if ($subject == "")  $subject = "(無題)";
	//$subject = zen2han($subject);

	/* 送信者名の設定 */
        $from = "";
        if ( $header->from[0]->personal != "" ) {
	    $from = $header->from[0]->personal;
        } else {
	    $from = $header->fromaddress;
        }
        $from = zen2han(i18n_mime_htmlSpecialChars($from));

	/* タイトル先頭のマーク設定 */
        if ($header->Deleted == 'D'){
	    $mark = $deleted_mail;
        } elseif ($header->Unseen == 'U'){
	    $mark = $unseen_mail;
        } else {
	    $mark = $normal_mail;
        }

        $param = "$pwstr&mbox=$mbox2&msgno=$msgno";
	$subject = "$subject";
	$subject = i18n_htmlSpecialChars($subject);
	
	
?>

<?=$mark?><A HREF=showmail.pl?<?=$param?>><?=$subject?></A><BR>
<?=$from?><HR>
<?PHP
    }
    imap_close($imap);
    $f_msg = zen2han("[TOPページへ]");
?>
<A HREF=top.pl?<?=$pwstr?>><?=$f_msg?></A><BR>
<?=$nav?>
</BODY>
</HTML>
