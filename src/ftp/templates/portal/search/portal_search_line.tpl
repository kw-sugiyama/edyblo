<?php require_once( SYS_PATH."templates/portal/portal_header.tpl" ); ?>

<body>

<?php require_once( SYS_PATH."templates/portal/portal_container.tpl" ); ?>

<div id="main"><!--main start-->
<div id="mainleft"><!--mainleft start-->

<p class="topicpath"><strong><a href="/">HOME</a></strong><span class="paddinglr1">&gt;</span><strong><a href="/psearch-arealine/">��������̾����</a></strong><span class="paddinglr1">&gt;</span><strong>���̱�������</strong></p>

<form id="form1" name="form1" method="get" action="dummy">

<?=$view_select_pref?><!-- ���򤷤��� -->

<?=$view_line_list?><!-- �������� -->

<?=$hidden_str?>

<div class="submit1">
	<table style="width:auto; margin-left: auto; margin-right: auto;">
		<tr>
			<td>
				<input type="image" src="share/css/css1/images/button09.gif" alt="��������" onclick="return ChkSearchLineSelect1(this.form);">
			</td>
			<td>
				<input type="image" src="share/css/css1/images/button08.gif" alt="��̾�ǹʤ����" onclick="return ChkSearchLineSelect2(this.form);">
			</td>
		</tr>
	</table>
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
