#!/usr/local/bin/php-cgi-4.3.6
<?php
    include "websylpheed.conf";
    include "session.lib";
    include "common.lib";
    include $db_include;

    imap_close($imap);
?>
<HTML><HEAD></HEAD>
<BODY bgcolor="<?=$bgcolor?>">
<FORM action="address_edit.pl" method="post">
<?PHP
    $flg = true;
    $submit=i18n_convert($submit,"SJIS","AUTO");
    if ( $submit == "�V�K" ) {
    //if ( $submit == "NEW" ) {
	$msg= "�V�K�A�h���X�o�^";
	$name = "";
	$select_mail = "";
	$new_flg = 1;
    } elseif ( $select_mail == "" ) {
	$msg = "�I�����Ă�������";
	$flg = false;
    } elseif ( $submit == "�폜" ) {
    //} elseif ( $submit == "DELETE" ) {
	delAddressBook( $select_mail );
	$msg =  "�폜���܂���";
	$flg = false;
    } elseif ( $select_mail != "" ) {
	$msg = "�A�h���X�ҏW";
	$name = getFullnameFromAB( $select_mail );
	$name = i18n_convert($name, $internal_encoding, "EUC");
	$select_mail = i18n_convert($select_mail,  $internal_encoding, "EUC");
	$new_flg = 0;
    }
    db_close();
    if ($flg){
?>
<?=$msg?><BR><HR>
���O<BR>
<INPUT type="text" size="16" name="name" value="<?=$name?>"><br>
���[���A�h���X<br>
<INPUT type="text" size="16" istyle="3" name="mail_add" value="<?=$select_mail?>"><br>

<INPUT type="hidden" name="reg" value="1">
<INPUT type="hidden" name="sess" value="<?=$sess?>">
<INPUT type="submit" name="submit" value="�o�^">
<INPUT type="hidden" name="new_flg" value="<?=$new_flg?>">
<INPUT type="hidden" name="select_mail" value="<?=$select_mail?>">
<?PHP
    } else {
?>
<?=$msg?><BR>
<INPUT type="hidden" name="sess" value="<?=$sess?>">
<input type="submit" name="submit" value="�߂�">
<?PHP
    }
?>
</FORM>
</BODY></HTML>
