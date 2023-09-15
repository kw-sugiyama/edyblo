<?php require_once( SYS_PATH."templates/portal/portal_header.tpl" ); ?>

<body>

<?php require_once( SYS_PATH."templates/portal/portal_container.tpl" ); ?>

<div id="main"><!--main start-->
<div id="mainleft"><!--mainleft start-->

<p class="topicpath"><strong><a href="/">HOME</a></strong><span class="paddinglr1">&gt;</span><strong><a href="/inquiry/">お問合せ</a></strong><span class="paddinglr1">&gt;</span><strong>ホームページ作成・広告掲載について</strong></p><!--topic path-->

<h3>お問合せ　ホームページ作成・広告掲載について</h3>
<!--search start-->
<div class="box7">
	<div class="box8">

		<table>
			<tr>
				<td class="tdform-a">
					<p>お問合せ内容を<br>
					  選択して下さい。</p>
				</td>
				<td class="tdform-b middle">
					<p><?=$arrViewData["title"]?></p>
				</td>
			</tr>
			<tr>
				<td class="tdform-a">
					<p>ご希望内容を<br>
					  選択して下さい。</p>
				</td>
				<td class="tdform-b middle">
					<p><?=$arrViewData["device"]?></p>
				</td>
			</tr>
			<tr>
				<td class="tdform-a">
					<p>お問合せ内容</p>
				</td>
				<td class="tdform-b middle">
					<p><?=$arrViewData["contents"]?></p>
				</td>
			</tr>
		</table>

		<p class="margint5 red">法人の場合は会社名、部署、役職名、ご住所、ご連絡先電話番号をご記入下さい。</p>

		<table>
			<tr>
				<td class="tdform-a">
					<p>お名前</p>
					<!-- <p><span class="red small">必須</span></p> -->
				</td>
				<td class="tdform-b middle">
					<p><?=$arrViewData["name_kj"]?></p>
				</td>
			</tr>
			<tr>
				<td class="tdform-a middle">
					<p>フリガナ</p>
				</td>
				<td class="tdform-b middle">
					<p><?=$arrViewData["name_kn"]?></p>
				</td>
			</tr>
			<tr>
				<td class="tdform-a">
					<p>メールアドレス</p>
					<!-- <p class="red small">必須</p> -->
				</td>
				<td class="tdform-b middle">
					<p><?=$arrInputData["email"]?></p>
				</td>
			</tr>
			<tr>
				<td class="tdform-a">
				<p>法人名</p></td>
				 <td class="tdform-b">
				<p><?=$arrInputData["corporation"]?></p>
				</td>
			</tr>
			<tr>
				<td class="tdform-a">
					<p>部署名</p>
				</td>
				<td class="tdform-b">
					<p><?=$arrInputData["post"]?></p>
				</td>
			</tr>
			<tr>
				<td class="tdform-a">
					<p>役職名</p>
				</td>
				<td class="tdform-b">
					<p><?=$arrInputData["position"]?></p>
				</td>
			</tr>
			<tr>
				<td class="tdform-a">
					<p>住所</p>
				</td>
				<td class="tdform-b">
					<p><?=$arrViewData["addr_cd"]?></p>
					<br>
					<p><?=$arrViewData["pref"]?></p>
					<br>
					<p><?=$arrViewData["addr"]?></p>
				</td>
			</tr>
			<tr>
				<td class="tdform-a">
					<p>電話番号</p>
				</td>
				<td class="tdform-b">
					<p><?=$_POST['tell_1']?></p>
				</td>
			</tr>
			<tr>
				<td class="tdform-a">
					<p>携帯電話</p>
				</td>
				<td class="tdform-b">
					<p><?=$_POST['mobile_1']?></p>
				</td>
			</tr>
	</table>

	</div>
</div><!--search end-->

<div class="submit1">
	<table style="width:auto; margin-left: auto; margin-right: auto;">
		<tr>
			<td>
				<FORM name="inquiry_confirm" method="POST" action="<?=$param_base_blog_addr_url?>/juku_inquiry/index.html" target="_self" style="display: inline; margin: 0px; padding: 0px;">
					<input type="image" name="imageField1" src="share/css/css1/images/button07.gif" alt="戻る">
						<?=$strInputHidden?>
					<INPUT type="hidden" name="form_flg" value="" >
				</FORM>
			</td>
			<td>
				<FORM name="inquiry_confirm" method="POST" action="<?=$param_base_blog_addr_url?>/juku_inquiry/commit.html" target="_self" style="display: inline; margin: 0px; padding: 0px;">
					<input type="image" name="imageField2" src="share/css/css1/images/button06.gif" alt="送信">
						<?=$strInputHidden?>
					<INPUT type="hidden" name="mst_juku" value="<?=$arrViewData["mst_juku"]?>" >
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
