<div id="footerwrapper"><!--footerwrapper start-->
	<ul id="footerul">
		<li class="footermenu"><a href="<?=_BLOG_SITE_URL_BASE?>school/">��������</a><img src="share/images/line_y.gif" alt="" /></li>
		<li class="footermenu"><a href="<?=_BLOG_SITE_URL_BASE?>kojin/">�ץ饤�Х����ݥꥷ��</a><img src="share/images/line_y.gif" alt="" /></li>
		<li class="footermenu"><a href="javascript:void(0)" onclick="document.inquire.submit(); return false">����礻</a></li>
	</ul>
</div><!--footerwrapper end-->

<div id="wrapperbottom"><!--wrapperbottom start -->
	&nbsp;
</div><!--wrapperbottom end -->

<?=$advertisement?>

<?php
if ( $test ) {
//<p id="credit">Powered by <a href="http://noang.com/">�Υ���</a> / <a href="http://jukutown.com/">�ؽ��Υ�����</a></p>
}
if ( ereg("/site_data/blog/source/program/index.php|/program/index.php", $_SERVER["SCRIPT_NAME"]) ) {
?>
<p id="credit"><a href="http://jukutown.com/" target="_blank">�����ζ�����õ������ζ�������������</a></p>
<?php
}
?>
</div><!--container end-->

<?php
require_once( SYS_PATH."templates/analytics.tpl" );
?>