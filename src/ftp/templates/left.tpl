<div id="mainleft"><!--mainleft start-->
<p class="imasugu">
<a href="javascript:void(0)" onclick="document.req.submit(); return false"><span class="nodisplay">今すぐ資料請求</span><br class="clear" /></a></p><!--今すぐ資料請求ボタン-->

<?=$leftmenu_list?>

<ul class="ulbookmark"><!--画面左ブックマーク start--> 
	<li class="libookmark"><a href="<?=_BLOG_SITE_URL_BASE?>rss-<?=$obj_login->clientdat[0]['cl_id']?>/"><img src="share/images/rss.gif" alt="" border="0" /></a></li>
	<li class="libookmark"><a href="javascript:void window.open('http://b.hatena.ne.jp/append?'+encodeURIComponent(window.location.href));"><img src="./share/icons/sb_hatena.gif" alt="はてなブックマークに追加" /></a></li>
	<li class="libookmark"><a href="javascript:void window.open('http://del.icio.us/post?url='+encodeURIComponent(window.location.href)+'&title='+encodeURIComponent(document.title));"><img src="./share/icons/sb_delicious.gif" alt="del.icio.us に登録" /></a></li>

</ul><!--画面左ブックマーク end-->  



<?=$free_html_list?>

</div><!--mainleft end-->
