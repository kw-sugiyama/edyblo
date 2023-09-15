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
    if ( $submit == "新規" ) {
    //if ( $submit == "NEW" ) {
	$msg= "新規アドレス登録";
	$name = "";
	$select_mail = "";
	$new_flg = 1;
    } elseif ( $select_mail == "" ) {
	$msg = "選択してください";
	$flg = false;
    } elseif ( $submit == "削除" ) {
    //} elseif ( $submit == "DELETE" ) {
	delAddressBook( $select_mail );
	$msg =  "削除しました";
	$flg = false;
    } elseif ( $select_mail != "" ) {
	$msg = "アドレス編集";
	$name = getFullnameFromAB( $select_mail );
	$name = i18n_convert($name, $internal_encoding, "EUC");
	$select_mail = i18n_convert($select_mail,  $internal_encoding, "EUC");
	$new_flg = 0;
    }
    db_close();
    if ($flg){
?>
<?=$msg?><BR><HR>
名前<BR>
<INPUT type="text" size="16" name="name" value="<?=$name?>"><br>
メールアドレス<br>
<INPUT type="text" size="16" istyle="3" name="mail_add" value="<?=$select_mail?>"><br>

<INPUT type="hidden" name="reg" value="1">
<INPUT type="hidden" name="sess" value="<?=$sess?>">
<INPUT type="submit" name="submit" value="登録">
<INPUT type="hidden" name="new_flg" value="<?=$new_flg?>">
<INPUT type="hidden" name="select_mail" value="<?=$select_mail?>">
<?PHP
    } else {
?>
<?=$msg?><BR>
<INPUT type="hidden" name="sess" value="<?=$sess?>">
<input type="submit" name="submit" value="戻る">
<?PHP
    }
?>
</FORM>
</BODY></HTML>
