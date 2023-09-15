<?php require_once( SYS_PATH."templates/portal/portal_header.tpl" ); ?>

<body>

<?php require_once( SYS_PATH."templates/portal/portal_container.tpl" ); ?>

	<div id="main"><!--main start-->
		<div id="mainleft"><!--mainleft start-->

<p class="topicpath"><strong><a href="/">HOME</a></strong><span class="paddinglr1">&gt;</span><strong><a href="/inquiry/">お問合せ</a></strong><span class="paddinglr1">&gt;</span><strong>塾タウンについて</strong></p><!--topic path-->

<h3>お問合せ　塾タウンについて</h3><!--search start-->
<div class="box7"><!--box start-->
	<div class="box8">
		<table class="search3">
			<tr>
				<th>
					<p class="center"><strong>お問合せありがとうございました。</strong></p>
				</th>
			</tr>
			<tr>
				<td>
					<p>お問合せの内容が送信されました。</p> 
					<p>後ほど担当の者よりご連絡させていただきます。</p>
					<p>もしお問合せから1週間以上ご連絡がない場合には、お手数ですが下記までご確認下さい。</p>
					<p>&nbsp;</p> 
					<p>株式会社ノアング</p> 
					<p>〒160-0023&nbsp;&nbsp;&nbsp;東京都新宿区西新宿7-11-3 平田ビル2F</p>
					<p>Eメール&nbsp;:&nbsp;<?=$param_mail_portal_inq["to_addr_direct"]?></p>
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
