<?php require_once( SYS_PATH."templates/portal/portal_header.tpl" ); ?>

<body>

<?php require_once( SYS_PATH."templates/portal/portal_container.tpl" ); ?>

<div id="main"><!--main start-->
<div id="mainleft"><!--mainleft start-->

<!--topic path start-->
<?=$view_pan_list?>
<!--topic path start-->

<form id="form1" name="form1" method="get" action="/psearch-result/page-1.html">

<?=$view_select_line?><!-- 選択した沿線 -->

<?=$view_station_list?><!-- 駅一覧 -->

<?=$hidden_str?>

<div class="submit1">
	<table style="width:auto; margin-left: auto; margin-right: auto;">
		<tr>
			<td>
				<input type="image" src="share/css/css1/images/button09.gif" alt="検索する" onclick="return ChkSearchStaSelect(this.form);">
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
