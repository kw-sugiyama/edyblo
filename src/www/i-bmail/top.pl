#!/usr/local/bin/php-cgi-4.3.6
<?PHP
    include "websylpheed.conf";
    include "session.lib";
    include "common.lib";


    $mbox_info = imap_mailboxmsginfo($imap);
    $mbox_nums = $mbox_info->Nmsgs;
    $mbox_size = $mbox_info->Size;

    imap_close($imap);

?>
<HTML>
<HEAD>
<TITLE><?=$mail_addr?> - <?=$system_name?></title>
<META HTTP-EQUIV="Pragma" CONTENT="no-cache">
<META HTTP-EQUIV="Cache-Control" CONTENT="no-cache">
</HEAD>
<BODY bgcolor="<?=$bgcolor?>">
<!--
<MARQUEE direction="right" behavior="alternate" loop="16"><?=$system_name?></MARQUEE>
-->
<?=$system_name?>
<BR>
1 <A ACCESSKEY="1" HREF="maillist.pl?<?=$pwstr?>&mbox=INBOX">�S���[���ꗗ</A>
<BR>
2 <A ACCESSKEY="2" HREF="maillist2.pl?<?=$pwstr?>&mbox=INBOX">���ǃ��[���ꗗ</A>
<BR>
3 <A ACCESSKEY="3" HREf="<? echo "mail_send.pl?$pwstr"; ?>">�V�K���M</A>
<BR>
<? if ($use_db) { ?>
4 <A ACCESSKEY="4" HREF="<? echo "address_edit.pl?$pwstr"; ?>">�A�h���X��</A>
<BR>
5 <A ACCESSKEY="5" HREF="<? echo "signature_edit.pl?$pwstr"; ?>">�����ҏW</A>
<BR>
<? } ?>
6 <A ACCESSKEY="6" HREF="<? echo "save_passwd.pl?$pwstr"; ?>">�p�X���[�h�ۑ�</A>
<BR>
8 <A ACCESSKEY="7" HREF="logout.pl">���O�A�E�g</A>
<HR>
���b�Z�[�W��:<BR> <?=$mbox_nums?>��
<BR>���[��BOX�̃T�C�Y:<BR> <?=$mbox_size?>�o�C�g
</BODY>
</HTML>
