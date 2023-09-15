<?php require_once( SYS_PATH."templates/portal/portal_header.tpl" ); ?>

<body>

<?php require_once( SYS_PATH."templates/portal/portal_container.tpl" ); ?>

<div id="main"><!--main start-->
<div id="mainleft"><!--mainleft start-->

<!--topbox01 start-->
<form name="form1" method="get" action="/psearch-result/page-1.html">
<input type="hidden" name="mode" value="sf">
<div class="topbox01">
<div class="topbox02"></div>
<div class="topbox03">
<label>
<select name="ar[]" class="inputarea2" id="pref" onchange="get_city(this.value)">
<?=$view_pref_list?>
</select>
</label>
&nbsp;&nbsp;&nbsp;
<label>
<span id="city">
<select name="pf[]" class="inputarea2">
<option value="">市区町村</option>
</select>
</span>
</label>
</div>
<div class="topbox03">
<select name="ag" class="inputarea2">
<?=$view_sc_age?>
</select>
</div>
<div class="topbox03">
<p>
<?=$view_sc_classform?>
</p>
</div>
<div class="topbox04">
<label>
<input name="button" type="image" id="button" value="送信" src="share/css/css1/images/button02.gif" alt="送信" onclick="return ChkSearchBox(this.form);">
</label>
</div>
</div>
</form>
<!--topbox01 end-->

<div class="areasearch"><!--areasearch start-->
<div class="flash">
<script type="text/javascript">
AC_FL_RunContent( 'codebase','http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=9,0,28,0','width','563','height','294','title','エリア検索','src','share/css/css1/images/top','quality','high','pluginspage','http://www.adobe.com/shockwave/download/download.cgi?P1_Prod_Version=ShockwaveFlash','movie','share/css/css1/images/top' ); //end AC code
</script>
<noscript>
<object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=9,0,28,0" width="563" height="294" title="エリア検索">
<param name="movie" value="share/css/css1/images/top.swf">
<param name="quality" value="high">
<param name="width" value="563">
<param name="height" value="294">
<param name="type" value="application/x-shockwave-flash">
&nbsp;
</object>
</noscript>
</div>
</div><!--areasearch end-->

<form action="/psearch-line/" method="get">
<div class="stationsearch"><!--stationsearch start-->
<div class="inputbox">
<label>
<select name="ar[]" class="inputarea">
<?=$view_prefline_list?>
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

<form action="/psearch-result/page-1.html" method="get">
<div class="freewordsearch"><!--freewordsearch start-->
<div class="inputbox">
<label>
<input class="inputarea" type="text" name="fw" value="例）新宿　個別" onfocus="ChkFreeSearchBoxReset(this.form);">
</label>
<input type="hidden" name="mode" value="fw">
</div>

<div class="searchbutton">
<label>
<input type="image" src="share/css/css1/images/button04.gif" alt="送信" onclick="return ChkFreeSearchBox(this.form);">
</label>
</div>
<br class="clear">
</div><!--freewordsearch end-->
</form>

<!--topic start//-->
<?php require_once( SYS_PATH."edy/portal_top_topic.tpl" ); ?>
<!--topic end//-->

<!--osusume start//-->
<?php require_once( SYS_PATH."edy/portal_top_osusume.tpl" ); ?>
<!--osusume end//-->

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
