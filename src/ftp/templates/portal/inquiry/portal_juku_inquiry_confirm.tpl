<?php require_once( SYS_PATH."templates/portal/portal_header.tpl" ); ?>

<body>

<?php require_once( SYS_PATH."templates/portal/portal_container.tpl" ); ?>

<div id="main"><!--main start-->
<div id="mainleft"><!--mainleft start-->

<p class="topicpath"><strong><a href="/">HOME</a></strong><span class="paddinglr1">&gt;</span><strong><a href="/inquiry/">����礻</a></strong><span class="paddinglr1">&gt;</span><strong>�ۡ���ڡ�������������ǺܤˤĤ���</strong></p><!--topic path-->

<h3>����礻���ۡ���ڡ�������������ǺܤˤĤ���</h3>
<!--search start-->
<div class="box7">
	<div class="box8">

		<table>
			<tr>
				<td class="tdform-a">
					<p>����礻���Ƥ�<br>
					  ���򤷤Ʋ�������</p>
				</td>
				<td class="tdform-b middle">
					<p><?=$arrViewData["title"]?></p>
				</td>
			</tr>
			<tr>
				<td class="tdform-a">
					<p>����˾���Ƥ�<br>
					  ���򤷤Ʋ�������</p>
				</td>
				<td class="tdform-b middle">
					<p><?=$arrViewData["device"]?></p>
				</td>
			</tr>
			<tr>
				<td class="tdform-a">
					<p>����礻����</p>
				</td>
				<td class="tdform-b middle">
					<p><?=$arrViewData["contents"]?></p>
				</td>
			</tr>
		</table>

		<p class="margint5 red">ˡ�ͤξ��ϲ��̾��������̾�������ꡢ��Ϣ���������ֹ�򤴵�����������</p>

		<table>
			<tr>
				<td class="tdform-a">
					<p>��̾��</p>
					<!-- <p><span class="red small">ɬ��</span></p> -->
				</td>
				<td class="tdform-b middle">
					<p><?=$arrViewData["name_kj"]?></p>
				</td>
			</tr>
			<tr>
				<td class="tdform-a middle">
					<p>�եꥬ��</p>
				</td>
				<td class="tdform-b middle">
					<p><?=$arrViewData["name_kn"]?></p>
				</td>
			</tr>
			<tr>
				<td class="tdform-a">
					<p>�᡼�륢�ɥ쥹</p>
					<!-- <p class="red small">ɬ��</p> -->
				</td>
				<td class="tdform-b middle">
					<p><?=$arrInputData["email"]?></p>
				</td>
			</tr>
			<tr>
				<td class="tdform-a">
				<p>ˡ��̾</p></td>
				 <td class="tdform-b">
				<p><?=$arrInputData["corporation"]?></p>
				</td>
			</tr>
			<tr>
				<td class="tdform-a">
					<p>����̾</p>
				</td>
				<td class="tdform-b">
					<p><?=$arrInputData["post"]?></p>
				</td>
			</tr>
			<tr>
				<td class="tdform-a">
					<p>��̾</p>
				</td>
				<td class="tdform-b">
					<p><?=$arrInputData["position"]?></p>
				</td>
			</tr>
			<tr>
				<td class="tdform-a">
					<p>����</p>
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
					<p>�����ֹ�</p>
				</td>
				<td class="tdform-b">
					<p><?=$_POST['tell_1']?></p>
				</td>
			</tr>
			<tr>
				<td class="tdform-a">
					<p>��������</p>
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
					<input type="image" name="imageField1" src="share/css/css1/images/button07.gif" alt="���">
						<?=$strInputHidden?>
					<INPUT type="hidden" name="form_flg" value="" >
				</FORM>
			</td>
			<td>
				<FORM name="inquiry_confirm" method="POST" action="<?=$param_base_blog_addr_url?>/juku_inquiry/commit.html" target="_self" style="display: inline; margin: 0px; padding: 0px;">
					<input type="image" name="imageField2" src="share/css/css1/images/button06.gif" alt="����">
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
