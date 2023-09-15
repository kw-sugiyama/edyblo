<?

if($obj_login->clientdat[0]['sc_privacy']){
	$privacy_policy='
					<div class="box"><!--boxlittle start-->
						<table>
							<tr>
								<td class="padding1 bggray">
									<p><em>個人情報の取扱いについて</em></p>
								</td>
							</tr>
							<tr>
								<td class="padding1 bordergray">
									<p>'.nl2br($arrHeaderView['sc_privacy']).'</p>
								</td>
							</tr>
						</table>
					</div><!--box end-->
';
}else{
	$privacy_policy="";
}
?>