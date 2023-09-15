<HTML>
  <HEAD>
    <META http-equiv="Content-Type" content="text/html; charset=EUC-JP">
    <META name="ROBOTS" content="ALL">
    <META name="description" content="">
    <META name="keywords" content="">
    <META http-equiv="Content-Style-Type" content="text/css">
    <META http-equiv="Content-Script-Type" content="text/javascript">
    <TITLE>塾ブログ - アカウント管理ツールログイン</TITLE>
    <LINK rel="stylesheet" type="text/css" href="./share/css/login.css" />
    <SCRIPT type="text/javascript" src="./share/js/login.js"></SCRIPT>
    <NOSCRIPT><META http-equiv="Refresh" content="1;URL=./jserror.html"></NOSCRIPT>
  </HEAD>
  <BODY>
    <DIV id="message"></DIV>
    <DIV id="wrapper">
      <FORM name="loginForm" action="main.php" method="post">
      <EM>ＩＤとパスワードを入れてログインしてください</EM>
      <TABLE id="login" cellspacing="0" align="center">
        <TR>
          <TH class="must">ＩＤ</TH>
          <TD><INPUT type="text" name="login_id" size="30" class="border" /></TD>
        </TR>
        <TR>
          <TH class="must">パスワード</TH>
          <TD><INPUT type="password" name="login_pass" size="30" class="border" /></TD>
        </TR>
      </TABLE>
      <p><INPUT type="button" onClick="ChkLogin(this.form)" value="ログイン" class="btn_nosize" /></p>
      </FORM>
      <hr color="#0000FF" />
      <ADDRESS>Copyright(C) 2007 Slash. All Rights Reserved.</ADDRESS>
    </DIV>
  </BODY>
</HTML>
