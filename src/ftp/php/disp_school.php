<?

$obj_area = new basedb_AreaClassTblAccess;
$obj_area->conn = $obj_conn->conn;
$obj_area->jyoken["ar_clid"]=$obj_login->clientdat[0]['cl_id'];
$obj_area->sort['ar_flg'] = 2;
$obj_area->areadat=array();
list( $intCnt_area , $intTotal_area ) = $obj_area->basedb_GetArea ( 1 , -1 );
$area['address']=$obj_area->areadat[0]['ar_pref'].$obj_area->areadat[0]['ar_city'].$obj_area->areadat[0]['ar_add']." ".$obj_area->areadat[0]['ar_estate'];

//未入力項目は「−」を表示
if($obj_login->clientdat[0]['cl_kname']){
	$cl_kname=$obj_login->clientdat[0]['cl_kname'];
}else{
	$cl_kname="−";
}
if($obj_login->clientdat[0]['sc_company']){
	$sc_company=$obj_login->clientdat[0]['sc_company'];
}else{
	$sc_company="−";
}
if($obj_login->clientdat[0]['cl_phone']){
	$cl_phone=$obj_login->clientdat[0]['cl_phone'];
}else{
	$cl_phone="−";
}
if($obj_login->clientdat[0]['cl_fax']){
	$cl_fax=$obj_login->clientdat[0]['cl_fax'];
}else{
	$cl_fax="−";
}


if($obj_login->clientdat[0]['sc_topimg']){
	$img_path='
									<td class="td7a center middle nopadding">
										<p class="marginr1">
											<img src="./img_thumbnail.php?w=200&h=205&dir='.$param_cl_photo_path.'&nm='.$obj_login->clientdat[0]['sc_topimg'].'" alt="" />
										</p>
									</td>
';
}else{
	$img_path='
									<td class="nopadding">
										<p class="marginr1">
										</p>
									</td>
';
}

$school_list.='
						<div class="box"><!--box start-->
							<h3><span class="white">'.htmlspecialchars($obj_login->clientdat[0]['sc_toptitle']).'</span></h3>
							<table>
								<tr>
									'.$img_path.'
									<td class="nopadding">
									<table>
											<tr>
												<td class="td1a center middle bggray">
													<p><em>塾　名</em></p>
													<p><em> 教室名</em></p>
												</td>
												<td class="td1b paddinglr1 bordergraydotted">
													<p>'.htmlspecialchars($obj_login->clientdat[0]['cl_jname']).'</p>
													<p>'.htmlspecialchars($cl_kname).'</p>
												</td>
											</tr>
											<tr>
												<td class="center middle bggray">
													<p><em>運営会社</em></p>
												</td>
												<td class="td1b paddinglr1 bordergraydotted">
													<p>'.htmlspecialchars($sc_company).'</p>
												</td>
												</tr>
											<tr>
												<td class="center middle bggray">
													<p><em>住　所</em></p>
												</td>
												<td class="td1b paddinglr1 bordergraydotted">
													<p>'.htmlspecialchars($area['address']).'</p>
												</td>
											</tr>
											<tr>
												<td class="center middle bggray">
													<p><em>電話番号</em></p>
												</td>
												<td class="td1b paddinglr1 bordergraydotted">
													<p>'.$cl_phone.'</p>
												</td>
											</tr>
											<tr>
												<td class="center middle bggray">
													<p><em>ＦＡＸ</em></p>
												</td>
												<td class="paddinglr1 bordergraydotted">
													<p>'.$cl_fax.'</p>
												</td>
											</tr>
											<tr>
												<td class="center middle bggray">
													<p><em>受付時間</em></p>
												</td>
												<td class="paddinglr1 bordergraydotted">
													<p>'.ltrim($obj_login->clientdat[0]['sc_start'],"0").' 〜 '.ltrim($obj_login->clientdat[0]['sc_end'],"0").'</p>
												</td>
											</tr>
											<tr>
												<td class="center middle bggray">
													<p><em>定休日</em></p>
												</td>
												<td class="paddinglr1 bordergraydotted">
													<p>'.htmlspecialchars($obj_login->clientdat[0]['sc_holiday']).'</p>
												</td>
											</tr>
										</table>
									</td>
								</tr>
							</table>
						</div><!--box end-->
';



$obj_category->jyoken=array();
$obj_category->jyoken["cg_clid"]=$obj_login->clientdat[0]['cl_id'];
$obj_category->jyoken["cg_stat"]=1;
$obj_category->jyoken["cg_type"]=1;
$obj_category->jyoken["cg_deldate"]=1;
$obj_category->sort["cg_dispno"]=2;
$obj_category->categorydat=array();
list( $intCnt_category , $intTotal_category ) = $obj_category->basedb_GetCategory ( 1 , -1 );

$dispno="";
$dispno=count($obj_category->categorydat)-1;
if($dispno>=0){
	foreach($obj_category->categorydat as $key1=>$val1){
		$obj_article=new basedb_ArticleClassTblAccess;
		$obj_article->conn = $obj_conn->conn;
		$obj_article->jyoken=array();
		$obj_article->jyoken["ac_clid"]=$obj_login->clientdat[0]['cl_id'];
		$obj_article->jyoken["ac_stat"]=1;
		$obj_article->jyoken["ac_cateid"]=$obj_category->categorydat[$key1]['cg_id'];
		$obj_article->jyoken["ac_deldate"]=1;
		$obj_article->sort["ac_dispno"]=1;
		$obj_article->articledat=array();
		list( $intCnt_article , $intTotal_article ) = $obj_article->basedb_GetArticle ( 1 , -1 );
		
		$dispno="";
		$img_path="";
		$dispno=count($obj_article->articledat)-1;
		if($dispno>=0){
			foreach($obj_article->articledat as $key2=>$val2){
				
				if($obj_article->articledat[$key2]['ac_img']){
					$img_path='
				<td class="nopadding">
					<p class="marginr1">
						<img src="./img_thumbnail.php?w=150&h=120&dir='.$param_article_img_path.'&nm='.$obj_article->articledat[$key2]['ac_img'].'" alt="" />
					</p>
				</td>
';
				}else{
					$img_path="";
				}

				if($key2==0){
					$school_list.='
						<div class="boxlittle"><!--box start-->                      
							<h4><span class="white">'.htmlspecialchars($obj_category->categorydat[$key1]['cg_stitle']).'</span></h4>
';
				}
				
				if($img_path){
					$school_list.='
							<table class="margint2">
								<tr>
									'.$img_path.'
									<td class="td3b nopadding">
										<table>
											<tr>
												<td class="borderblue">
													<p><span class="blue2"><em>'.htmlspecialchars($obj_article->articledat[$key2]['ac_title']).'</em></span></p>
												</td>
											</tr>
											<tr>
												<td>
													<p>'.nl2br($obj_article->articledat[$key2]['ac_contents']).'</p>
												</td>
											</tr>
										</table>
									
									</td>
								</tr>
							</table>
';
				}else{
					$school_list.='					                  
							<table>
								<tr>
									<td class="borderblue">
										<p><span class="blue2"><em>'.htmlspecialchars($obj_article->articledat[$key2]['ac_title']).'</em></span></p>
									</td>
								</tr>
								<tr>
									<td>
										<p>'.nl2br($obj_article->articledat[$key2]['ac_contents']).'</p>
									</td>
								</tr>
							</table>
';
				}
			}
		$school_list.='	
						</div><!--boxlittle end-->';
		}else{
			$school_list.='
						<div class="boxlittle"><!--box start-->                      
							<h4><span class="white">'.htmlspecialchars($obj_category->categorydat[$key1]['cg_stitle']).'</span></h4>
						</div><!--boxlittle end-->';
		}
	}
}

$school_list.='
					<div class="boxlittle "><!-- boxlittle start -->

						<table class="widthauto center2">
								<tr>
									<td>
										<div id="gmap" style="width: 530px; height: 277px; overflow:hidden;border:1px solid #000000">
											<noscript><br /><font style="color:#FF0000;font-size:10px;">※JavaScriptが有効でない場合、機能しません。</font></noscript>
										</div>
									</td>
								</tr>
								<tr>
									<td>
										<center><input type="button" value="元に戻す" style="width:100px;height:25px;" onclick="replace('.$obj_login->clientdat[0]['sc_ido'].','.$obj_login->clientdat[0]['sc_keido'].','.$obj_login->clientdat[0]['sc_zoom'].')" /></center>
										<input type="hidden" id="zoomN" name="zoom2" value="">
										<input type="hidden" name="marker_flg" value="" id="marker_flg" />
									</td>
								</tr>
						</table>
					</div><!-- boxlittle end -->
';

if($obj_login->clientdat[0]['sc_ido'] && $obj_login->clientdat[0]['sc_keido']){
	$sc_ido=$obj_login->clientdat[0]['sc_ido'];
	$sc_keido=$obj_login->clientdat[0]['sc_keido'];
	$sc_zoom=$obj_login->clientdat[0]['sc_zoom'];
}else{
	$sc_ido="35.7097227520928";
	$sc_keido="139.652709960938";
	$sc_zoom="10";
}

?>
