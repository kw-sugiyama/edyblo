<?php require_once( SYS_PATH."templates/portal/portal_header.tpl" ); ?>
<body>

<?php require_once( SYS_PATH."templates/portal/portal_container.tpl" ); ?>

<div id="main"><!--main start-->
<div id="mainleft"><!--mainleft start-->

<p class="topicpath"><strong><a href="/">HOME</a></strong><span class="paddinglr1">&gt;</span><strong><a href="/psearch-area/">エリア検索</a></strong><span class="paddinglr1">&gt;</span><strong>県別一覧</strong></p>
<form id="form1" name="form1" method="get" action="/psearch-result/page-1.html">
<input type="hidden" name="mode" value="ar">
<?=$view_select_pref?>

<!--search start-->
<?=$view_city_list?>
<!--search end-->

<div class="submit1">
<label><input type="image" src="share/css/css1/images/button09.gif" alt="検索する" onclick="return ChkSearchCitySelect(this.form);"></label>
</div>

<!--search end-->

<!--to pagetop start--> 
<?php require_once( SYS_PATH."templates/portal/portal_main_footer.tpl" ); ?>
<!--to pagetop end--> 

</form>

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
