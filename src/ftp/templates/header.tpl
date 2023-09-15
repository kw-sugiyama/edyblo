<!-- include header.tpl -->
<form method="post" action="<?=_BLOG_SITE_URL_BASE?>req/"  name="req" id="req"><!--資料請求-->
	<input type="hidden" name="session_unset" value="1" />
</form>
<form method="post" action="<?=_BLOG_SITE_URL_BASE?>inquire/" name="inquire" id="inquire"><!--お問い合わせ-->
	<input type="hidden" name="session_unset" value="1" />
</form>
<form method="post" action="<?=_BLOG_SITE_URL_BASE?>campaign-inq/" name="campaigninq" id="campaigninq"><!--キャンペーンお問い合わせ-->
	<input type="hidden" name="session_unset" value="1" />
	<input type="hidden" name="url" value="<?=$url?>" />
	<input type="hidden" name="age_of" value="<?=$obj_campaign->campaindat[0]['cp_age']?>" />
	<input type="hidden" name="publishing" value="<?=$publishing_period?>" />
	<input type="hidden" name="title" value="<?=htmlspecialchars($obj_campaign->campaindat[0]['cp_title'])?>" />
	<input type="hidden" name="cpid" value="<?=$obj_campaign->campaindat[0]['cp_id']?>" />
</form>
<form method="post" action="<?=_BLOG_SITE_URL_BASE?>campaign-apply/" name="campaignapply" id="campaignapply"><!--キャンペーン申し込み-->
	<input type="hidden" name="session_unset" value="1" />
	<input type="hidden" name="url" value="<?=$url?>" />
	<input type="hidden" name="age_of" value="<?=$obj_campaign->campaindat[0]['cp_age']?>" />
	<input type="hidden" name="publishing" value="<?=$publishing_period?>" />
	<input type="hidden" name="title" value="<?=htmlspecialchars($obj_campaign->campaindat[0]['cp_title'])?>" />
	<input type="hidden" name="cpid" value="<?=$obj_campaign->campaindat[0]['cp_id']?>" />
</form>
<form method="post" action="<?=_BLOG_SITE_URL_BASE?>course-inq/" name="courseinq" id="courseinq"><!--コースお問合せ-->
	<input type="hidden" name="session_unset" value="1" />
	<input type="hidden" name="url" value="<?=$url?>" />
	<input type="hidden" name="age_of" value="<?=$obj_course->coursedat[0]['cs_age']?>" />
	<input type="hidden" name="publishing" value="<?=htmlspecialchars($cs_shisetsu)?>" />
	<input type="hidden" name="title" value="<?=htmlspecialchars($obj_course->coursedat[0]['cs_title'])?>" />
	<input type="hidden" name="csid" value="<?=$obj_course->coursedat[0]['cs_id']?>" />
</form>
<form method="post" action="<?=_BLOG_SITE_URL_BASE?>course-req/"  name="coursereq" id="coursereq"><!--コース資料請求-->
	<input type="hidden" name="session_unset" value="1" />
	<input type="hidden" name="url" value="<?=$url?>" />
	<input type="hidden" name="age_of" value="<?=$obj_course->coursedat[0]['cs_age']?>" />
	<input type="hidden" name="publishing" value="<?=htmlspecialchars($cs_shisetsu)?>" />
	<input type="hidden" name="title" value="<?=htmlspecialchars($obj_course->coursedat[0]['cs_title'])?>" />
	<input type="hidden" name="csid" value="<?=$obj_course->coursedat[0]['cs_id']?>" />
</form>
<form method="post" action="<?=_BLOG_SITE_URL_BASE?>campaign-inq/" name="campaigninqback" id="campaigninqback"><!--キャンペーンお問い合わせ戻る用-->
	<input type="hidden" name="url" value="<?=$url?>" />
	<input type="hidden" name="age_of" value="<?=$obj_campaign->campaindat[0]['cp_age']?>" />
	<input type="hidden" name="publishing" value="<?=$publishing_period?>" />
	<input type="hidden" name="title" value="<?=htmlspecialchars($obj_campaign->campaindat[0]['cp_title'])?>" />
	<input type="hidden" name="cpid" value="<?=$obj_campaign->campaindat[0]['cp_id']?>" />
</form>
<form method="post" action="<?=_BLOG_SITE_URL_BASE?>campaign-apply/" name="campaignapplyback" id="campaignapplyback"><!--キャンペーン申し込み戻る用-->
	<input type="hidden" name="url" value="<?=$url?>" />
	<input type="hidden" name="age_of" value="<?=$obj_campaign->campaindat[0]['cp_age']?>" />
	<input type="hidden" name="publishing" value="<?=$publishing_period?>" />
	<input type="hidden" name="title" value="<?=htmlspecialchars($obj_campaign->campaindat[0]['cp_title'])?>" />
	<input type="hidden" name="cpid" value="<?=$obj_campaign->campaindat[0]['cp_id']?>" />
</form>
<form method="post" action="<?=_BLOG_SITE_URL_BASE?>course-inq/" name="courseinqback" id="courseinqback"><!--コースお問合せ戻る用-->
	<input type="hidden" name="url" value="<?=$url?>" />
	<input type="hidden" name="age_of" value="<?=$obj_course->coursedat[0]['cs_age']?>" />
	<input type="hidden" name="publishing" value="<?=htmlspecialchars($cs_shisetsu)?>" />
	<input type="hidden" name="title" value="<?=htmlspecialchars($obj_course->coursedat[0]['cs_title'])?>" />
	<input type="hidden" name="csid" value="<?=$obj_course->coursedat[0]['cs_id']?>" />
</form>
<form method="post" action="<?=_BLOG_SITE_URL_BASE?>course-req/"  name="coursereqback" id="coursereqback"><!--コース資料請求戻る用-->
	<input type="hidden" name="url" value="<?=$url?>" />
	<input type="hidden" name="age_of" value="<?=$obj_course->coursedat[0]['cs_age']?>" />
	<input type="hidden" name="publishing" value="<?=htmlspecialchars($cs_shisetsu)?>" />
	<input type="hidden" name="title" value="<?=htmlspecialchars($obj_course->coursedat[0]['cs_title'])?>" />
	<input type="hidden" name="csid" value="<?=$obj_course->coursedat[0]['cs_id']?>" />
</form>

<?php
	if ( $sp_button_disp_flag == true ) {
?>
<style type="text/css">
<!--
#sp_button_box{width: 800px;margin: 0 auto;padding:5px 0;background-color:#fff;}
#sp_button_box a{
    -moz-text-blink: none;
    -moz-text-decoration-color: -moz-use-text-color;
    -moz-text-decoration-line: none;
    -moz-text-decoration-style: solid;
    background-color: #006DCC;
    background-repeat: repeat-x;
    border-bottom-color: rgba(0, 0, 0, 0.25);
    border-bottom-left-radius: 5px;
    border-bottom-right-radius: 5px;
    border-left-color-ltr-source: physical;
    border-left-color-rtl-source: physical;
    border-left-color-value: rgba(0, 0, 0, 0.1);
    border-right-color-ltr-source: physical;
    border-right-color-rtl-source: physical;
    border-right-color-value: rgba(0, 0, 0, 0.1);
    border-top-color: rgba(0, 0, 0, 0.1);
    border-top-left-radius: 5px;
    border-top-right-radius: 5px;
    color: #FFFFFF;
    display: block;
    font-size: 34px;	font-weight: bold;
    margin-left: 0;
    margin-right: 0;
    padding-bottom: 15px;
    padding-left: 19px;
    padding-right: 19px;
    padding-top: 15px;
    text-align: center;
    text-shadow: 0 -1px 0 rgba(0, 0, 0, 0.25);
    font-family: 'ヒラギノ角ゴ Pro W3','Hiragino Kaku Gothic Pro','メイリオ',Meiryo,'ＭＳ Ｐゴシック',sans-serif;
}
-->
</style>
	<div id="sp_button_box"><a href="<?= $sp_button_link_url ?>">スマートフォン版を見る</a></div>
<?php
	}
?>
<div id="header"><!--header start -->
	<div id="headerleft"><!--header left start -->
		<h1><a name="pagetop" id="pagetop"></a><?=htmlspecialchars($obj_login->clientdat[0]['sc_headertitle'])?></h1>
		<p class="marginl1"><?=$sc_logo?></p>
	</div><!--headerleft end -->
	<div id="headerright"><!--headerright start -->
		<table>
			<tr>
				<td class="nopadding">
					<h2><span class="white"><?=$arrMetaHeader["title_corp"]?></span></h2>
				</td>
			</tr>
			<tr>
				<td>
					<table class="widthauto center2">
						<tr>
							<td>
								<p class="margint3 marginr2"><img src="share/images/item_tel.gif" alt="" /></p></td>
							<td>
								<p class="marginr2 pink"><span class="font1"><em><?=$arrHeaderView['cl_phone']?></em></span></p></td>
							<td>
								<p class="margint3 marginr2"><img src="share/images/uketsuke.gif" alt="" width="59" height="20" /></p></td>
							<td>
								<p><span class="font1"><em><?=ltrim($arrHeaderView['sc_start'],"0")?>〜<?=ltrim($arrHeaderView['sc_end'],"0")?></em></span></p></td>
						</tr>
					</table>
				</td>
			</tr>
			<tr>
				<td class="nopadding">
					<p class="small paddinglr3">定休日　：　<?=$arrHeaderView["sc_holiday"]?></p>
				</td>
			</tr>
		</table>
	</div><!--headerright end -->
</div><!--header end -->

<div id="globalmenuwrapper"><!--globalmenuwrapper start -->
	<ul id="globalmenu">
		<li class="globalmenu1"><a href="<?=_BLOG_SITE_URL_BASE?>">ホーム</a></li>
		<?=$topmenu;?>
	</ul>
</div><!--globalmenuwrapper end -->
