#!/usr/local/bin/php-cgi-4.3.6
<?PHP
    include "websylpheed.conf";
    include "session.lib";
    include "common.lib";
    include "functions.lib";
    include "imap-utf7.lib";

    function folderName($box) {
        list($server_part, $name_part) = explode('}', $box);
        return $name_part;
    }

    function folderName_decode($box) {
	global $internal_encoding, $personal_folders;
        $name = i18n_convert( decode_imap_utf7($box), $internal_encoding, 'UTF-8');
        if ($personal_folders != "" ){
            $name = ereg_replace("^" . $personal_folders, "", $name );
	}
        return zen2han($name);
    }

    if ($use_imap_subscribe) {
        $boxlist = imap_listsubscribed($imap, $connstr, "*");
    } else {
        $boxlist = imap_listmailboxes($imap, $connstr, "*");
    }
    imap_close($imap);
?>
<HTML>
<HEAD>
<TITLE>フォルダ選択 - <?=$mail_addr?></TITLE>
</HEAD>
<body bgcolor="<?=$bgcolor?>">
フォルダ選択<br>
<A HREF="maillist.pl?<?=$pwstr?>&mbox=INBOX">受信箱</A><BR>
<?PHP
    if (is_array($boxlist)) {
        natcasesort($boxlist);
        reset($boxlist);
        while(list($key, $box) = each($boxlist)) {
            $boxName = folderName($box);
            $boxName1 = urlencode($boxName);
            $boxName2 = folderName_decode($boxName);

	    if ($boxName == 'INBOX'){
	        continue;
	    } elseif (!$show_dotfiles && $boxName[0] == '.'){
	        continue;
	    } else {
?>
<A HREF="maillist.pl?<?=$pwstr?>&mbox=<?=$boxName1?>"><?=$boxName2?></A><BR>
<?PHP
	    }
	}
    }
?>
<HR>
<A HREF="top.pl?<?=$pwstr?>">TOPページへ</A>
<BODY>
<HTML>
