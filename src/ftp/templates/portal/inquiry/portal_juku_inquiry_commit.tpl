<?php require_once( SYS_PATH."templates/portal/portal_header.tpl" ); ?>

<body>

<?php require_once( SYS_PATH."templates/portal/portal_container.tpl" ); ?>

	<div id="main"><!--main start-->
		<div id="mainleft"><!--mainleft start-->

<p class="topicpath"><strong><a href="/">HOME</a></strong><span class="paddinglr1">&gt;</span><strong><a href="/inquiry/">����礻</a></strong><span class="paddinglr1">&gt;</span><strong>�ۡ���ڡ�������������ǺܤˤĤ���</strong></p><!--topic path-->

<h3>����礻���ۡ���ڡ�������������ǺܤˤĤ���</h3><!--search start-->
<div class="box7"><!--box start-->
	<div class="box8">
		<table class="search3">
			<tr>
				<th>
					<p class="center"><strong>����礻���꤬�Ȥ��������ޤ�����</strong></p>
				</th>
			</tr>
			<tr>
				<td>
					<p>����礻�����Ƥ���������ޤ�����</p> 
					<p>��ۤ�ô���μԤ�ꤴϢ�����Ƥ��������ޤ���</p>
					<p>�⤷����礻����1���ְʾ头Ϣ���ʤ����ˤϡ�������Ǥ��������ޤǤ���ǧ��������</p>
					<p>&nbsp;</p> 
					<p>������ҥΥ���</p> 
					<p>��160-0023&nbsp;&nbsp;&nbsp;����Կ��ɶ�������7-11-3 ʿ�ĥӥ�2F</p>
					<p>E�᡼��&nbsp;:&nbsp;<?=$param_mail_portal_inq["to_addr_direct"]?></p>
				</td>
			</tr>
		</table>
	</div>
</div><!--box end-->

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
