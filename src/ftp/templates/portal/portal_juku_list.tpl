<?php require_once( SYS_PATH."templates/portal/portal_header.tpl" ); ?>

<body>

<?php require_once( SYS_PATH."templates/portal/portal_container.tpl" ); ?>

<div id="main"><!--main start-->
<div id="mainleft"><!--mainleft start-->

<!--topic path start-->
<?=$view_pan_list?>
<!--topic path start-->


<!--keywordsearch start-->
<form name="form1" method="get" action="/psearch-result/page-1.html">
<input type="hidden" name="mode" value="ms">
<div class="keywordsearch">
<div class="gladeselect"></div>
<div class="gladeselect2">
<label>
<select name="ar[]" class="inputarea2" id="pref" onchange="get_city(this.value)">
<?=$view_pref_list?>
</select>
</label>
&nbsp;&nbsp;&nbsp;
<label>
<span id="city">
<select name="pf[]" class="inputarea2">
<option value="">»Ô¶èÄ®Â¼</option>
</select>
</span>
</label>
</div>
<div class="gladeselect2"><span class="gladeselect">
<label>
<select name="ag" class="inputarea2">
<?=$view_sc_age?>
</select>
</label>
</span></div>
<div class="gladeselect2">
<p>
<?=$view_sc_classform?>
</p>
</div>
<div class="gladeselect2">
<label>
<input type="text" name="fw" id="keyword">
</label>
</div>
<div class="gladeselect3">
<label>
<input name="button" type="image" id="button" value="Á÷¿®" src="share/css/css1/images/researchbuttonn.gif" alt="Á÷¿®" onclick="return ChkSearchBox2(this.form);">
</label>
</div>
</div>
</form>
<!--keywordsearch end-->

<!--pagenavi start-->
<?=$view_page_link?>
<!--pagenavi end-->

<!--schoolinfo start-->
<?=$view_school_list?>
<!--schoolinfo end-->

<!--pagenavi start-->
<?=$view_page_link?>
<!--pagenavi end-->

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
