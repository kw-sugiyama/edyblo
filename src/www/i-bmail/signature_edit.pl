#!/usr/local/bin/php-cgi-4.3.6
<?PHP
    include "websylpheed.conf";
    include "session.lib";
    include "common.lib";
    include $db_include;

    /* 署名の登録 */
    if ( $reg == 1 ) {
        addSign( $sign, $new );
    }

    /* 署名の読み込み */
    $sign = getSign();
    if ( $sign != "" ) {
        $new = 0;
    } else {
        $new = 1;
    }

    db_close();
    imap_close($imap);
    $sign = i18n_convert ($sign,$internal_encoding,"AUTO");

?>	
<HTML>
<HEAD></HEAD>
<BODY bgcolor="<?=$bgcolor?>">
<FORM action="signature_edit.pl" method="post">
署名編集<BR>
<TEXTAREA rows="5" cols="16" name="sign">
<?=$sign?>
</TEXTAREA>
<BR>
<INPUT type="hidden" name="reg" value="1">
<INPUT type="hidden" name="new" value="<?=$new?>">
<INPUT type="hidden" name="sess" value="<?=$sess?>">
<INPUT type="submit" name="submit" value="登録">
</FORM>

<A HREF="top.pl?<?=$pwstr?>">[TOPページへ]</a>
</BODY>
</HTML>
