<?php require_once( SYS_PATH."templates/portal/portal_header.tpl" ); ?>

<body>

<?php require_once( SYS_PATH."templates/portal/portal_container.tpl" ); ?>

<div id="main"><!--main start-->
<div id="mainleft"><!--mainleft start-->

<p class="topicpath"><strong><a href="/">HOME</a></strong><span class="paddinglr1">&gt;</span><strong>沿線・駅名検索</strong></p><!--topic path-->

<form name="form1" method="get" action="/psearch-line/">

<div class="stationsearch"><!--stationsearch start-->
	<div class="inputbox">
		<label>
			<select name="ar[]" class="inputarea">
				<option value="" selected>都道府県を選択</option>
				<?=$select_val?>
			</select>
		</label>
	</div>

	<div class="searchbutton">
		<label>
			<input type="image" src="share/css/css1/images/button04.gif" alt="送信" onclick="return ChkSearchBox(this.form);">
		</label>
	</div>
	<br class="clear">
</div><!--stationsearch end-->

</form>

<form name="form1" method="get" action="/psearch-line/">

<h3>全国から探す</h3><!--search start-->

<?=$view_pref_list?>

<div class="submit1">
<label><input type="image" src="share/css/css1/images/button04.gif" alt="送信" onclick="return ChkSearchPrefSelect(this.form);"></label>
</div>

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
