<div id="mainleft"><!--mainleft start-->
<p class="imasugu">
<a href="javascript:void(0)" onclick="document.req.submit(); return false"><span class="nodisplay">��������������</span><br class="clear" /></a></p><!--��������������ܥ���-->

<?=$leftmenu_list?>

<ul class="ulbookmark"><!--���̺��֥å��ޡ��� start--> 
	<li class="libookmark"><a href="<?=_BLOG_SITE_URL_BASE?>rss-<?=$obj_login->clientdat[0]['cl_id']?>/"><img src="share/images/rss.gif" alt="" border="0" /></a></li>
	<li class="libookmark"><a href="javascript:void window.open('http://b.hatena.ne.jp/append?'+encodeURIComponent(window.location.href));"><img src="./share/icons/sb_hatena.gif" alt="�ϤƤʥ֥å��ޡ������ɲ�" /></a></li>
	<li class="libookmark"><a href="javascript:void window.open('http://del.icio.us/post?url='+encodeURIComponent(window.location.href)+'&title='+encodeURIComponent(document.title));"><img src="./share/icons/sb_delicious.gif" alt="del.icio.us ����Ͽ" /></a></li>

</ul><!--���̺��֥å��ޡ��� end-->  



<?=$free_html_list?>

</div><!--mainleft end-->
