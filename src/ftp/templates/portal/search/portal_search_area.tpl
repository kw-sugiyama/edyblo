<?php require_once( SYS_PATH."templates/portal/portal_header.tpl" ); ?>

<body>

<?php require_once( SYS_PATH."templates/portal/portal_container.tpl" ); ?>

<div id="main"><!--main start-->
<div id="mainleft"><!--mainleft start-->

<p class="topicpath"><strong><a href="/">HOME</a></strong><span class="paddinglr1">&gt;</span><strong>エリア検索</strong></p><!--topic path-->

<form id="form1" name="form1" method="get" action="/psearch-pref/">

<div class="areasearch3"><!--search start-->
<div class="flash2">
  <script type="text/javascript">
AC_FL_RunContent( 'codebase','http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=9,0,28,0','width','432','height','350','title','area_top','src','share/css/css1/images/area_top','quality','high','pluginspage','http://www.adobe.com/shockwave/download/download.cgi?P1_Prod_Version=ShockwaveFlash','movie','share/css/css1/images/area_top' ); //end AC code
</script><noscript><object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=9,0,28,0" width="432" height="350" title="area_top">
    <param name="movie" value="share/css/css1/images/area_top.swf">
    <param name="quality" value="high">
    <param name="width" value="432">
    <param name="height" value="350">
    <param name="type" value="application/x-shockwave-flash">
  </object></noscript>
</div>
</div><!--search end-->


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
