<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html lang="ja">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=euc-jp" >
<meta name="Keywords" content="学習塾,進学塾,個別指導,中学受験,塾タウン,小学校,中学校,高校,中高一貫,公立,私立,エラー">
<meta name="Description" content="エラー表示です。塾タウンは学習塾・進学塾探しのポータルサイトです。地域や目的（受験対策・補修）、指導形式（個別指導・少人数指導・集団指導）、対象（小学校・中学校・高校・大学）などから簡単に塾を検索できます。">
<link href="share/css/css1/style_import.css" rel="stylesheet" type="text/css" media="screen">
<link href="share/css/css1/print.css" rel="stylesheet" type="text/css" media="print">

<title>エラー｜学習塾・進学塾・塾探しのポータルサイト「塾タウン」</title>
<script src="share/js/AC_RunActiveContent.js" type="text/javascript"></script>
<script type="text/javascript" src="share/js/jslb_ajax.js"></script>
<script type="text/javascript" src="share/js/getdatafile.js"></script>

<script type="text/javascript" src="./share/js/highslide.js"></script>
<script type="text/javascript" src="./share/js/highslide_config.js"></script>
<script type="text/javascript" src="./share/js/more.js"></script>
<script type="text/javascript" src="./share/js/formclear.js"></script>
<script type="text/javascript" src="./share/js/actionReplace.js"></script>
<?=$param_meta_robots?>
</head>
<body>

<?php require_once( SYS_PATH."templates/portal/portal_container.tpl" ); ?>

<div id="main"><!--main start-->
<div id="mainleft"><!--mainleft start-->

<p class="topicpath"><strong><a href="/">HOME</a></strong><span class="paddinglr1">&gt;</span><strong>エラー</strong></p><!--topic path-->

<h3>エラー発生</h3>
<!--search start-->

<div class="box3"><!--box start-->
<table class="search3">
<tr>
<th>
<p class="center"><strong>エラーが発生しました。</strong></p>
</th>
</tr>
<tr>
<td>
<p style="color:#FF0000;"><?=$buffViewString?></p>
<p><?=$_arrOther["ath_comment"]?></p>
<p>お手数ですがブラウザの戻るボタンをクリックして、元のページへお戻り下さい。</p>
</td>
</tr>
</table>
</div><!--box end-->

<!--
<div class="box">
	<div class="box4">
		<FORM name="error_back" method="<?=$_arrOther["next_pass"]?>" action="<?=$_buffGoto?>" target="_self">
			<strong class="red"><?=$buffViewString?></strong>
			<p><?=$_arrOther["ath_comment"]?></p>
			<p>&nbsp;</p>
			<p><input type="submit" value="前のページに戻る"></p>
		</FORM>
	</div>
</div>
-->

<!--to pagetop start--> 
<?php require_once( SYS_PATH."templates/portal/portal_main_footer.tpl" ); ?>
<!--to pagetop end--> 

</div><!--mainleft end-->

<div id="mainright"><!--mainright start-->
<?php require_once( SYS_PATH."templates/portal/portal_right_menu.tpl" ); ?>
</div><!--mainright end-->    
        
</div><!--main end-->    

<div id="footerwrapper"><!--footerwrapper start-->

</div><!--footerwrapper end-->
<?php require_once( SYS_PATH."edy/portal_footer.tpl" ); ?>
</div><!--container end-->

<?php require_once( SYS_PATH."templates/portal/portal_analytics.tpl" ); ?>

</body>
</html>
