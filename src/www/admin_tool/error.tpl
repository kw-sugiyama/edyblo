<HTML>
  <HEAD>
    <TITLE>塾ブログ - エラー</TITLE>
    <META http-equiv="Content-Type" content="text/html; charset=EUC-JP">
    <STYLE type="text/css">
    <!--
      A{ color: black}
      A:hover { color: red }
    //-->
    </STYLE>
  </HEAD>
  <BODY>
    <div align="center">
      <table width="400" border="0" cellspacing="0" cellpadding="0">
        <tr>
	  <td>
            <br><br>
            <div align="center">
              <font size="3" color="#FF6600">
                <FORM name="error_back" method="POST" action="<?=$_buffGoto?>" target="_self">
                <P><?=$buffViewString?></P>
                <P><?=$_arrOther["ath_comment"]?></P>
                <P></P>
                <INPUT type="submit" value="戻る" />
                </FORM>
              </FONT>
            </div>
          </td>
        </tr>
      </table>
    </div>
  </BODY>
</HTML>
