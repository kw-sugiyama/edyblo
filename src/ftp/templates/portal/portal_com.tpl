<?php require_once( SYS_PATH."templates/portal/portal_header.tpl" ); ?>

<body>

<?php require_once( SYS_PATH."templates/portal/portal_container.tpl" ); ?>

<div id="main"><!--main start-->
<div id="mainleft"><!--mainleft start-->

<p class="topicpath"><strong><a href="/">HOME</a></strong><span class="paddinglr1">&gt;</span><strong>���Ĳ��</strong></p><!--topic path-->

<h3>���Ĳ��</h3><!--search start-->
<div class="box">
<div class="box2">
<p class="icon_sitemap">���̾&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;������ҥΥ���</p>
<p>&nbsp;</p>
<p class="icon_sitemap">�����&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;������������������<br>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;����Կ��ɶ������ɣ��ݣ����ݣ���ʿ�ĥӥ룲��</p>
<p>&nbsp;</p>
<p class="icon_sitemap">�᡼��&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?=$param_mail_portal_inq["to_addr_direct"]?></p>
<p>&nbsp;</p>
<p class="icon_sitemap">��Ωǯ��&nbsp;&nbsp;&nbsp;��������ǯ����</p>
<p>&nbsp;</p>
<p class="icon_sitemap">���ܶ�&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;��,������,��������</p>
<p>&nbsp;</p>
<p class="icon_sitemap">��������&nbsp;&nbsp;&nbsp;���ؽ��Υݡ����륵���ȡ�<a href="http://jukutown.com/" target="_blank">Jukutown�ʽΥ������</a>�٤α���<br>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;���ؽ��θ����ۡ���ڡ������������ӥ���<a href="http://noang.com/edyblo/" target="_blank">Edyblo�ʥ��ǥ��֥���</a>��
<!--&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;���ؽ������祢��Х��ȥ����ȡ�<a href="http://jukudebaito.com/" target="_blank">�ΤǥХ���</a>�٤α���--></p>
<p>&nbsp;</p>
<p class="icon_sitemap">�գң�&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="http://noang.com/" target="_blank">http://noang.com/</a></p>
</div>

</div><!--search end-->
<!--box end-->

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
