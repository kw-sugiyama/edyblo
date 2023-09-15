<?php require_once( SYS_PATH."templates/portal/portal_header.tpl" ); ?>

<body>

<?php require_once( SYS_PATH."templates/portal/portal_container.tpl" ); ?>

<div id="main"><!--main start-->
<div id="mainleft"><!--mainleft start-->

<p class="topicpath"><strong><a href="/">HOME</a></strong><span class="paddinglr1">&gt;</span><strong><a href="/inquiry/">お問合せ</a></strong><span class="paddinglr1">&gt;</span><strong>塾タウンについて</strong></p><!--topic path-->

<h3>お問合せ　塾タウンについて</h3><!--search start-->
<div class="box7">
	<div class="box8">

		<table>
			<tr>
				<td class="tdform-a">
					<p>メールアドレス</p>
					<!-- <p class="red small">必須</p> -->
				</td>
			 	<td class="tdform-b">
					<p><?=$arrViewData["email"]?></p>
				</td>
			</tr>
			<tr>
				<td class="tdform-a">
					<p>件名</p>
				</td>
				<td class="tdform-b middle">
					<p><?=$arrViewData["subject"]?></p>
				</td>
			</tr>
			<tr>
				<td class="tdform-a">
					<p>本文</p>
				</td>
				<td class="tdform-b middle">
					<p><?=$arrViewData["contents"]?></p>
				</td>
			</tr>
		</table>
	</div>
</div><!--search end-->

<div class="submit1">
	<table style="width:auto; margin-left: auto; margin-right: auto;">
		<tr>
			<td>
				<FORM name="inquiry_confirm" method="POST" action="<?=$param_base_blog_addr_url?>/hp_inquiry/index.html" target="_self" style="display: inline;">
					<input type="image" name="imageField1" src="share/css/css1/images/button07.gif" alt="戻る">
						<?=$strInputHidden?>
					<INPUT type="hidden" name="form_flg" value="" >
				</FORM>
			</td>
			<td>
				<FORM name="inquiry_confirm" method="POST" action="<?=$param_base_blog_addr_url?>/hp_inquiry/commit.html" target="_self" style="display: inline;">
					<input type="image" name="imageField2" src="share/css/css1/images/button06.gif" alt="送信">
						<?=$strInputHidden?>
					<INPUT type="hidden" name="mst_hp" value="<?=$arrViewData["mst_hp"]?>" >
					<INPUT type="hidden" name="form_flg" value="CONFIRM" >
				</FORM>
			</td>
		</tr>
	</table>
</div>

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
