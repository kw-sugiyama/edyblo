
<div class="box"><!--box start-->
	<div id="boxtop">
	</div>
	<div class="boxmiddle">
		<table>
			<tr>
				<td class="td5a center middle nopadding">
					<p class="marginr1"><?=$teacher_img?></p>
				</td>
				<td class="td5b nopadding">
					<table>
						<tr>
							<td class="td1a borderblue">
								<p><span class="large"><em><?=$arrMetaHeader["title_corp"]?></em></span></p>
							</td>
						</tr>
					</table>
					<table class="margint2">
						<tr>
							<td class="td1a center middle bggray">
								<p><em>電　話</em></p></td>
							<td class="paddinglr1 bordergraydotted">
								<p><span class="large pink marginr1"><em><?=$arrHeaderView['cl_phone']?></em></span></p>
							</td>
							<td class="paddinglr1 center middle bggray">
								<p><em>受付時間</em></p>
							</td>
							<td class="paddinglr1 bordergraydotted">
								<p><span class="large"><em><?=ltrim($arrHeaderView['sc_start'],"0")?>〜<?=$arrHeaderView['sc_end']?></em></span></p>
							</td>
						</tr>
						<tr>
							<td class="td1a center middle bggray">
								<p><em>定休日・備考</em></p></td>
							<td colspan="3" class="td1b paddinglr1 bordergraydotted">
								<p><?=$arrHeaderView["sc_holiday"]?></p></td>
						</tr>
						<tr>
							<td class="td1a center middle bggray">
								<p><em>住　所</em></p></td>
							<td colspan="3" class="td1b paddinglr1 bordergraydotted">
								<p>〒<?=$obj_area->areadat[0]['ar_zip']?></p><p><?=$area['address']?></p></td>
						</tr>
						<tr>
							<td class="td1a center middle bggray">
								<p><em>交　通</em></p></td>
							<td colspan="3" class="td1b paddinglr1 bordergraydotted">
								<p><?=$ensen['line1'].$ensen['sta1'].$ensen['bus1'].$ensen['walk1'].$ensen['biko1']?></p></td>
						</tr>
					</table>
				</td>
			</tr>
		</table>
	</div>
	<div id="boxbottom">
	</div>
</div><!--box end-->
<p class="pagetop"><span class="marginl1"><a href="#pagetop">ページトップへ</a></span><br /></p><br class="clear" /><!--to pagetop-->