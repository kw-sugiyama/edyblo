#!/usr/local/bin/php-cgi-4.3.6
<?PHP
    include "websylpheed.conf";
    include "session.lib";
    include "common.lib";
    include $db_include;

    imap_close($imap);
?>
<HTML>
<HEAD></HEAD>
<BODY BGCOLOR="<?=$bgcolor?>">
アドレス編集<BR>
<?PHP
    /* ＤＢへの登録 */
    $submit = i18n_convert($submit,$internal_encoding,"AUTO");
    if ( $reg == 1 ) {
        if ( $submit == "登録" && $mail_add == "" ) {
?>
メールアドレスを入力してください
<BR><A HREF="address_edit.pl?<?=$pwstr?>">戻る</A>
</BODY></HTML>
<?PHP
            exit;
        }

        $name = i18n_convert( $name, "EUC", "AUTO" );
        $mail_add = i18n_convert( $mail_add, "EUC", "AUTO" );
        addAddressBook( $mail_add, $name, $select_mail, $new_flg );
    }

    /* 一覧取得 */
    $list = getAddressList();
    db_close();	
?>
<FORM action="address_edit_2.pl" method="post">
<?PHP
    for ( $i = 0; $i < count($list); $i++ ) {
        list($mail_add, $name) = $list[$i];
        /* $name = i18n_convert($name, $internal_encoding, "EUC"); */
        $name = i18n_convert($name, $internal_encoding, "EUC"); 
        /* $mail_add = i18n_convert($mail_add, $internal_encoding, "EUC"); */
        $mail_add = i18n_convert($mail_add, $internal_encoding, "SJIS");
?>
<HR>
<INPUT type="radio" name="select_mail" value="<?=$mail_add?>"><?=$name?><BR>
<?=$mail_add?>
<?PHP
    }
?>
<HR>

<INPUT type="hidden" name="sess" value="<?=$sess?>">
<INPUT type="submit" name="submit" value="編集">
<INPUT type="submit" name="submit" value="削除">
<INPUT type="submit" name="submit" value="新規">
</FORM>
<A HREF="top.pl?<?=$pwstr?>">[TOPページへ]</A>
</BODY></HTML>
