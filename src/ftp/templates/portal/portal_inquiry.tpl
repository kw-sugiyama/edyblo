<?php require_once( SYS_PATH."templates/portal/portal_header.tpl" ); ?>

<body>

<?php require_once( SYS_PATH."templates/portal/portal_container.tpl" ); ?>

<div id="main"><!--main start-->
<div id="mainleft"><!--mainleft start-->

<p class="topicpath"><strong><a href="/">HOME</a></strong><span class="paddinglr1">&gt;</span><strong>����礻</strong></p><!--topic path-->

<h3>����礻</h3><!--search start-->
<div class="box">
	<div class="box2">
		<p class="arrow"><strong><a href="<?=$param_base_blog_addr_url?>/hp_inquiry/index.html">�Υ�����ˤĤ���</a></strong></p>
		<p class="margint1">�������ȤˤĤ��ƤΤ��ո��������ۤʤɤϡ������餫������դ��Ƥ���ޤ���</p>
	</div>

	<div class="box2">
		<p class="arrow"><strong><a href="<?=$param_base_blog_addr_url?>/juku_inquiry/index.html">�ۡ���ڡ�������������ǺܤˤĤ���</a></strong></p>
		<p class="margint1">���͸����Υۡ���ڡ��������䡢����ǺܤΤ�����⾵�äƤ���ޤ���</p>
	</div>

</div>
<!--search end-->


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
