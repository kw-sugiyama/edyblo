<?
/*
教室紹介　　　　：1
キャンペーン情報：2
コース情報　　　：3
ブログ(日記)　　：4
*/

//dispnoを抽出
//スクール情報開始
$top_sortno="";
$top_sortno=$obj_login->clientdat[0]['sc_layout5'];//教室紹介の表示位置(1〜4)
if($obj_login->clientdat[0]['sc_topimg']){
	$schoolimg_path='
<td class="td7a center middle nopadding">
	<p class="marginr1">
		<img src="./img_thumbnail.php?w=200&h=156&dir='.$param_cl_photo_path.'&nm='.$obj_login->clientdat[0]['sc_topimg'].'" alt="" />
	</p>
</td>
';
}else{
	$schoolimg_path='
<td class="nopadding">
</td>
';
}

$age_of=$obj_login->clientdat[0]['sc_age'];
$age_check=array();
$age_icon=array();
$age_check_list="";
$age_icon_list="";
if(($age_of & 64)==64){
	$age_check[7]='<span class="marginlr2">社会人　</span>';
	$age_icon[7]='<img src="./share/icons/item_syakaijin_5.gif" alt="" />　';
	$age_of-=64;
}
if(($age_of & 32)==32){
	$age_check[6]='<span class="marginlr2">大学生　</span>';
	$age_icon[6]='<img src="./share/icons/item_daigaku_5.gif" alt="" />　';
	$age_of-=32;
}
if(($age_of & 16)==16){
	$age_check[5]='<span class="marginlr2">浪人生　</span>';
	$age_icon[5]='<img src="./share/icons/item_ronin_5.gif" alt="" />　';
	$age_of-=16;
}
if(($age_of & 8)==8){
	$age_check[4]='<span class="marginlr2">高校　</span>';
	$age_icon[4]='<img src="./share/icons/item_koukou_5.gif" alt="" />　';
	$age_of-=8;
}
if(($age_of & 4)==4){
	$age_check[3]='<span class="marginlr2">中学生　</span>';
	$age_icon[3]='<img src="./share/icons/item_chugaku_5.gif" alt="" />　';
	$age_of-=4;
}
if(($age_of & 2)==2){
	$age_check[2]='<span class="marginlr2">小学生　</span>';
	$age_icon[2]='<img src="./share/icons/item_shougaku_5.gif" alt="" />　';
	$age_of-=2;
}
if(($age_of & 1)==1){
	$age_check[1]='<span class="marginlr2">幼児　</span>';
	$age_icon[1]='<img src="./share/icons/item_youji_5.gif" alt="" />　';
	$age_of-=1;
}

if(count($age_check)){
	ksort($age_check);
	$age_check_list="<p>";
	foreach($age_check as $key3=>$val3){
		$age_check_list.=$val3;
	}
$age_check_list="</p>";
}else{
	$age_check_list="−";
}

if(count($age_icon)){
	ksort($age_icon);
	foreach($age_icon as $key4=>$val4){
		$age_icon_list.=$val4;
	}
}else{
	$age_icon_list="−";
}

$school_of=$obj_login->clientdat[0]['sc_classform'];
$school_check=array();
$school_icon=array();
$school_check_list="";
$school_icon_list="";
if(($school_of & 4)==4){
	$school_check[3]='<span class="marginlr2">個別</span>';
	$school_icon[3]='<img src="./share/icons/item_kobetsu_4.gif" alt="" />　';
	$school_of-=4;
}
if(($school_of & 2)==2){
	$school_check[2]='<span class="marginlr2">少人数</span>';
	$school_icon[2]='<img src="./share/icons/item_shouninzu_4.gif" alt="" />　';
	$school_of-=2;
}
if(($school_of & 1)==1){
	$school_check[1]='<span class="marginlr2">集団</span>';
	$school_icon[1]='<img src="./share/icons/item_shudan_4.gif" alt="" />　';
	$school_of-=1;
}

if(count($school_check)){
	ksort($school_check);
	foreach($school_check as $key3=>$val3){
		$school_check_list.="<p>".$val3."</p>";
	}
}else{
	$school_check_list="−";
}

if(count($school_icon)){
	ksort($school_icon);
	foreach($school_icon as $key4=>$val4){
		$school_icon_list.=$val4;
	}
}else{
	$school_icon_list="−";
}

$sc_pr=htmlspecialchars($obj_login->clientdat[0]['sc_pr']);

$index[$top_sortno]='
					<div class="box"><!--box start-->
						<h3><span class="white">'.htmlspecialchars($obj_login->clientdat[0]['sc_toptitle']).'</span></h3>
					
						<table>
							<tr>
								'.$schoolimg_path.'
								<td class="nopadding">
								                        
									<table>
										<tr>
											<td class="borderblue">
												<p><em>'.htmlspecialchars($obj_login->clientdat[0]['sc_topsubtitle']).'</em></p>
											</td>
										</tr>
										<tr>
											<td>
												<p>'.nl2br($sc_pr).'</p>
											</td>
										</tr>
										<tr>
											<td>
												<table>
													<tr>
														<td class="td1a center middle bggray">
															<p><em>対象</em></p>
													</td>
														<td class="paddinglr1 bordergraydotted">
															<p><span class="blue2"><em>'.$age_icon_list.'</em></span></p>
														</td>
													</tr>
													<tr>
														<td class="td1a center middle bggray">
															<p><em>指導方法</em></p>
														</td>
														<td class="paddinglr1 bordergraydotted">
															<p><span class="blue2"><em>'.$school_icon_list.'</em></span></p>
														</td>
													</tr>
												</table>
											</td>
										</tr>
									</table>  
								</td>
							</tr>
						</table>
					</div><!--box end-->
';
//スクール情報終了



//キャンペーンバナー開始
$top_sortno="";
$top_sortno=$obj_login->clientdat[0]['sc_layout6'];//キャンペーンの表示位置(1〜4)

$timestamp='(timestamp \''.date("Y").'-'.date("m").'-'.date("d").' 00:00:00\')';

//見出しの作成
$obj_campaign_chk1 = new basedb_CampainClassTblAccess;
$obj_campaign_chk1->conn = $obj_conn->conn;
$obj_campaign_chk1->jyoken["cp_clid"]=$obj_login->clientdat[0]['cl_id'];
$obj_campaign_chk1->jyoken["cp_stat"]=1;
$obj_campaign_chk1->jyoken["cp_topflg"]=3;
$obj_campaign_chk1->jyoken["cp_deldate"]=1;
$obj_campaign_chk1->jyoken["cp_publishstart"]=$timestamp;
$obj_campaign_chk1->jyoken["cp_publishend"]=$timestamp;
$obj_campaign_chk1->sort["cp_upddate"] = 2;
$obj_campaign_chk1->campaindat=array();
list( $intCnt_campaign , $intTotal_campaign ) = $obj_campaign_chk1->basedb_GetCampain ( 1 , 5 );
$campaign_chk1_cnt="";
$campaign_chk1_cnt=count($obj_campaign_chk1->campaindat)-1;

$obj_campaign_chk2 = new basedb_CampainClassTblAccess;
$obj_campaign_chk2->conn = $obj_conn->conn;
$obj_campaign_chk2->jyoken["cp_clid"]=$obj_login->clientdat[0]['cl_id'];
$obj_campaign_chk2->jyoken["cp_stat"]=1;
$obj_campaign_chk2->jyoken["cp_topflg"]=2;
$obj_campaign_chk2->jyoken["cp_deldate"]=1;
$obj_campaign_chk2->jyoken["cp_publishstart"]=$timestamp;
$obj_campaign_chk2->jyoken["cp_publishend"]=$timestamp;
$obj_campaign_chk2->sort["cp_upddate"] = 2;
$obj_campaign_chk2->campaindat=array();
list( $intCnt_campaign , $intTotal_campaign ) = $obj_campaign_chk2->basedb_GetCampain ( 1 , 5 );
$campaign_chk2_cnt="";
$campaign_chk2_cnt=count($obj_campaign_chk2->campaindat)-1;

if( $campaign_chk1_cnt >= 0 || $campaign_chk2_cnt >= 0 ){
	$index[$top_sortno].='
					<div class="box"><!--box start-->
						<h3 class="white">'.htmlspecialchars($obj_login->clientdat[0]['sc_campaintitle']).'</h3>
';
}

$obj_campaign = new basedb_CampainClassTblAccess;
$obj_campaign->conn = $obj_conn->conn;
$obj_campaign->jyoken["cp_clid"]=$obj_login->clientdat[0]['cl_id'];
$obj_campaign->jyoken["cp_stat"]=1;
$obj_campaign->jyoken["cp_topflg"]=3;
$obj_campaign->jyoken["cp_deldate"]=1;
$obj_campaign->jyoken["cp_publishstart"]=$timestamp;
$obj_campaign->jyoken["cp_publishend"]=$timestamp;
$obj_campaign->sort["cp_upddate"] = 2;
$obj_campaign->campaindat=array();
//list( $intCnt_campaign , $intTotal_campaign ) = $obj_campaign->basedb_GetCampain ( 1 , 5 );
list( $intCnt_campaign , $intTotal_campaign ) = $obj_campaign->basedb_GetCampain ( 1 , 20 );
$dispcnt="";
$dispcnt=count($obj_campaign->campaindat)-1;
if($dispcnt>=0){
	foreach($obj_campaign->campaindat as $key1=>$val1){
		$obj_category->jyoken=array();
		$obj_category->jyoken["cg_clid"]=$obj_login->clientdat[0]['cl_id'];
		$obj_category->jyoken["cg_stat"]=1;
		$obj_category->jyoken["cg_type"]=6;
		$obj_category->jyoken["cg_deldate"]=1;
		$obj_category->jyoken["cg_id"]=$obj_campaign->campainda[$key1]['cp_cgid'];
		$obj_category->categorydat=array();
		list( $intCnt_category , $intTotal_category ) = $obj_category->basedb_GetCategory ( 1 , -1 );

		$data = pathinfo($obj_campaign->campaindat[$key1]['cp_bkgdimg']);
		$banner = $data['filename'];
		//$data['dirname']; //ディレクトリ名
		//$data['basename']; //ファイル名+拡張子
		//$data['filename']; //ファイル名
		//$data['extension']; //拡張子

		$index[$top_sortno].='
						<div class="campaignbox_'.$banner.'"><!--campaignbox start-->
							<table>
								<tr>
									<td class="tdcampaigna">
										<table>
											<tr>
												<td>
													<p id="campaign1_'.$banner.'">'.htmlspecialchars($obj_campaign->campaindat[$key1]['cp_subtitle']).'</p>
													<p id="campaign2_'.$banner.'">'.htmlspecialchars($obj_campaign->campaindat[$key1]['cp_title']).'</p>
													<p id="campaign3_'.$banner.'"><a href="'._BLOG_SITE_URL_BASE.'campaign-detail-'.$obj_campaign->campaindat[$key1]['cp_id'].'/">'.htmlspecialchars($obj_campaign->campaindat[$key1]['cp_linktext']).'</a></p>
												</td>
											</tr>
										</table>
									</td>
									<td class="tdcampaignb_'.$banner.'">
										<p id="campaign4_'.$banner.'"><a href="'._BLOG_SITE_URL_BASE.'campaign-detail-'.$obj_campaign->campaindat[$key1]['cp_id'].'/">'.htmlspecialchars($obj_campaign->campaindat[$key1]['cp_btntext']).'</a></p>
									</td>
								</tr>
							</table>
						</div><!--campaignbox end-->
';
	}
}
//キャンペーンバナー終了




//キャンペーンテキスト開始
$obj_campaign2 = new basedb_CampainClassTblAccess;
$obj_campaign2->conn = $obj_conn->conn;
$obj_campaign2->jyoken["cp_clid"]=$obj_login->clientdat[0]['cl_id'];
$obj_campaign2->jyoken["cp_stat"]=1;
$obj_campaign2->jyoken["cp_topflg"]=2;
$obj_campaign2->jyoken["cp_deldate"]=1;
$obj_campaign2->jyoken["cp_publishstart"]=$timestamp;
$obj_campaign2->jyoken["cp_publishend"]=$timestamp;
$obj_campaign2->sort["cp_upddate"] = 2;
$obj_campaign2->campaindat=array();
list( $intCnt_campaign , $intTotal_campaign ) = $obj_campaign2->basedb_GetCampain ( 1 , 5 );
$dispcnt="";
$dispcnt=count($obj_campaign2->campaindat)-1;
if($dispcnt>=0){
	foreach($obj_campaign2->campaindat as $key1=>$val1){
		$obj_category->jyoken=array();
		$obj_category->jyoken["cg_clid"]=$obj_login->clientdat[0]['cl_id'];
		$obj_category->jyoken["cg_stat"]=1;
		$obj_category->jyoken["cg_type"]=6;
		$obj_category->jyoken["cg_deldate"]=1;
		$obj_category->jyoken["cg_id"]=$obj_campaign2->campainda[$key1]['cp_cgid'];
		$obj_category->categorydat=array();
		list( $intCnt_category , $intTotal_category ) = $obj_category->basedb_GetCategory ( 1 , -1 );
		
		$start_year=substr($obj_campaign2->campaindat[$key1]['cp_upddate'],0,4);
		$start_month=substr($obj_campaign2->campaindat[$key1]['cp_upddate'],5,2);
		$start_day=substr($obj_campaign2->campaindat[$key1]['cp_upddate'],8,2);
		$start_date=$start_year.'年'.$start_month.'月'.$start_day.'日';
		
		if($key1==0){
			$index[$top_sortno].='
						<div class="boxmargin"><!--box内のbox start-->            
							<table>';
		}
		
		$index[$top_sortno].='
								<tr>
									<td class="td2a bordergraydotted">
										<p><img src="share/images/item_ex'.$img_color.'.gif" alt="" /></p>
									</td>
									<td class="td2b bordergraydotted">
										<p><span class="blue2">'.$start_date.'</span></p>
									</td>
									<td class="td2c bordergraydotted">
										<p class="normallink">
										<a href="'._BLOG_SITE_URL_BASE.'campaign-detail-'.$obj_campaign2->campaindat[$key1]['cp_id'].'/">'.htmlspecialchars($obj_campaign2->campaindat[$key1]['cp_title']).'</a></p>
									</td>
								</tr>
';
	}
	$index[$top_sortno].='
							</table>
						</div><!--box内のbox end-->
';
}

if( $campaign_chk1_cnt >= 0 || $campaign_chk2_cnt >= 0 ){
	$index[$top_sortno].='
					</div><!--box end-->
';
}

//キャンペーンテキスト終了



//コース情報開始
$top_sortno="";
$top_sortno=$obj_login->clientdat[0]['sc_layout7'];//コースの表示位置(1〜4)
$obj_course = new basedb_CourseClassTblAccess;
$obj_course->conn = $obj_conn->conn;
$obj_course->jyoken=array();
$obj_course->jyoken["cs_clid"]=$obj_login->clientdat[0]['cl_id'];
$obj_course->jyoken["cs_stat"]=1;
$obj_course->jyoken["cs_deldate"]=1;
$obj_course->jyoken["cs_topflg"]=2;
$obj_course->sort["cs_upddate"] = 2;
$obj_course->coursedat=array();
list( $intCnt_course , $intTotal_course ) = $obj_course->basedb_GetCourse ( 1 , 5 );

$dispcnt="";
$dispcnt=count($obj_course->coursedat)-1;
if($dispcnt>=0){
	foreach($obj_course->coursedat as $key1=>$val1){
		$obj_category->jyoken=array();
		$obj_category->jyoken["cg_clid"]=$obj_login->clientdat[0]['cl_id'];
		$obj_category->jyoken["cg_stat"]=1;
		$obj_category->jyoken["cg_type"]=3;
		$obj_category->jyoken["cg_deldate"]=1;
		$obj_category->jyoken["cg_id"]=$obj_course->coursedat[$key1]['cs_cgid'];
		$obj_category->categorydat=array();
		list( $intCnt_category , $intTotal_category ) = $obj_category->basedb_GetCategory ( 1 , -1 );
		
		$age_of=$obj_course->coursedat[$key1]['cs_age'];
		$age_check=array();
		$age_icon=array();
		$age_check_list="";
		$age_icon_list="";
		if(($age_of & 64)==64){
			$age_check[7]='<span class="marginlr2">社会人　　</span>';
			$age_icon[7]='<img src="./share/icons/item_syakaijin_5.gif" alt="" />';
			$age_of-=64;
		}
		if(($age_of & 32)==32){
			$age_check[6]='<span class="marginlr2">大学生　　</span>';
			$age_icon[6]='<img src="./share/icons/item_daigaku_5.gif" alt="" />　';
			$age_of-=32;
		}
		if(($age_of & 16)==16){
			$age_check[5]='<span class="marginlr2">浪人生　　</span>';
			$age_icon[5]='<img src="./share/icons/item_ronin_5.gif" alt="" />　';
			$age_of-=16;
		}
		if(($age_of & 8)==8){
			$age_check[4]='<span class="marginlr2">高校　　</span>';
			$age_icon[4]='<img src="./share/icons/item_koukou_5.gif" alt="" />　';
			$age_of-=8;
		}
		if(($age_of & 4)==4){
			$age_check[3]='<span class="marginlr2">中学生　　</span>';
			$age_icon[3]='<img src="./share/icons/item_chugaku_5.gif" alt="" />　';
			$age_of-=4;
		}
		if(($age_of & 2)==2){
			$age_check[2]='<span class="marginlr2">小学生　　</span>';
			$age_icon[2]='<img src="./share/icons/item_shougaku_5.gif" alt="" />　';
			$age_of-=2;
		}
		if(($age_of & 1)==1){
			$age_check[1]='<span class="marginlr2">幼児　　</span>';
			$age_icon[1]='<img src="./share/icons/item_youji_5.gif" alt="" />　';
			$age_of-=1;
		}
		
		if(count($age_check)){
			ksort($age_check);
			foreach($age_check as $key3=>$val3){
				$age_check_list.=$val3;
			}
		}else{
			$age_check_list="−";
		}
		
		if(count($age_icon)){
			ksort($age_icon);
			foreach($age_icon as $key4=>$val4){
				$age_icon_list.=$val4;
			}
		}
		
		$school_of=$obj_course->coursedat[$key1]['cs_classform'];
		$school_check=array();
		$school_icon=array();
		$school_check_list="";
		$school_icon_list="";
		if(($school_of & 4)==4){
			$school_check[3]='<span class="marginlr2">個別　</span>';
			$school_icon[3]='<img src="./share/icons/item_kobetsu_4.gif" alt="" />';
			$school_of-=4;
		}
		if(($school_of & 2)==2){
			$school_check[2]='<span class="marginlr2">少人数　</span>';
			$school_icon[2]='<img src="./share/icons/item_shouninzu_4.gif" alt="" />　';
			$school_of-=2;
		}
		if(($school_of & 1)==1){
			$school_check[1]='<span class="marginlr2">集団　</span>';
			$school_icon[1]='<img src="./share/icons/item_shudan_4.gif" alt="" />　';
			$school_of-=1;
		}
		
		if(count($school_check)){
			ksort($school_check);
			foreach($school_check as $key3=>$val3){
				$school_check_list.=$val3;
			}
		}else{
			$school_check_list="−";
		}
		
		if(count($school_icon)){
			ksort($school_icon);
			foreach($school_icon as $key4=>$val4){
				$school_icon_list.=$val4;
			}
		}
		
		if($obj_course->coursedat[$key1]['cs_img1']){
			$img_path='
<td class="td3a nopadding">
	<p class="marginr1">
		<img src="./img_thumbnail.php?w=140&h=115&dir='.$param_cs_img1_path.'&nm='.$obj_course->coursedat[$key1]['cs_img1'].'" alt="" />
	</p>
</td>
';
			$cs_pr="";
			$cs_pr=html_delete($obj_course->coursedat[$key1]['cs_pr']);
			$cs_pr=mb_substr($cs_pr,0,120,"EUC-JP").' ．．．';
		}else{
			$img_path="";
			$cs_pr="";
			$cs_pr=html_delete($obj_course->coursedat[$key1]['cs_pr']);
			$cs_pr=mb_substr($cs_pr,0,168,"EUC-JP").' ．．．';
		}
				
		if($key1==0){
		$index[$top_sortno]='
			<div class="box"><!--box start-->
				<table class="tableforh3noback">
					<tr>
						<td class="nopadding">            
							<h3 class="h3noback white">'.htmlspecialchars($obj_login->clientdat[0]['sc_coursetitle']).'</h3>
						</td>
						<td class="nopadding right middle">
							<span class="small white paddingr1"><a href="'._BLOG_SITE_URL_BASE.'course-rss-'.$obj_login->clientdat[0]['cl_id'].'/"><img src="share/images/rsstext.gif" alt="" /></a></span>
						</td>
					</tr>
				</table>
';
		}
		$index[$top_sortno].=
'
				<table class="bordergraydotted margint2">
					<tr>
						'.$img_path.'
						<td class="td3b nopadding">
							<table>
								<tr>
									<td class="borderblue">
										<p><span class="detailblue"><a href="'._BLOG_SITE_URL_BASE.'course-detail-'.$obj_course->coursedat[$key1]['cs_id'].'/">'.htmlspecialchars($obj_course->coursedat[$key1]['cs_title']).'</a></span></p>
									</td>
								</tr>
								<tr>
									<td>
										<table class="widthauto">
											<tr>
												<td>
													<p class="marginr1">'.$age_icon_list.'</p>
												</td>
												<td>
													<p class="marginr1">'.$school_icon_list.'</p>
												</td>
												<td>
													<p><span class="blue2"><em>'.htmlspecialchars($obj_course->coursedat[$key1]['cs_jtitle']).'</em></span></p>
												</td>
											</tr>
										</table>
									</td>
								</tr>
								<tr>
									<td>
										<p>'.$cs_pr.'</p>
										<p class="detail margint1"><a href="'._BLOG_SITE_URL_BASE.'course-detail-'.$obj_course->coursedat[$key1]['cs_id'].'/">   　</a></p><br class="clear" />
									</td>
								</tr>
							</table>
						</td>
					</tr>
				</table>
';
	}
$index[$top_sortno].='			</div><!--box end-->';
}
//コース情報終了


//新着日記情報開始
$top_sortno=$obj_login->clientdat[0]['sc_layout8'];//日記の表示位置(1〜4)
$obj_diary = new basedb_DiaryClassTblAccess;
$obj_diary->conn = $obj_conn->conn;
$obj_diary->jyoken=array();
$obj_diary->jyoken["dr_clid"]=$obj_login->clientdat[0]['cl_id'];
$obj_diary->jyoken["dr_deldate"]=1;
$obj_diary->sort["dr_upddate"] = 2;
$obj_diary->diarydat=array();
list( $intCnt_diarylist , $intTotal_diarylist ) = $obj_diary->basedb_GetDiary ( 1 , 5 );

$img_path="";
$dispcnt="";
$dispcnt=count($obj_diary->diarydat)-1;
if($dispcnt>=0){
	foreach($obj_diary->diarydat as $key1=>$val1){
			
		/*
		$obj_category->jyoken=array();
		$obj_category->jyoken["cg_clid"]=$obj_login->clientdat[0]['cl_id'];
		$obj_category->jyoken["cg_stat"]=1;
		$obj_category->jyoken["cg_type"]=5;
		$obj_category->jyoken["cg_deldate"]=1;
		$obj_category->jyoken["cg_id"]=$obj_diary->diarydat[$key1]['dr_cgid'];
		$obj_category->categorydat=array();
		list( $intCnt_category , $intTotal_category ) = $obj_category->basedb_GetCategory ( 1 , -1 );
		*/
		
		$insert_year=substr($obj_diary->diarydat[$key1]['dr_insdate'],0,4);
		$insert_month=substr($obj_diary->diarydat[$key1]['dr_insdate'],5,2);
		$insert_day=substr($obj_diary->diarydat[$key1]['dr_insdate'],8,2);
		$insrert_date=$insert_year.'年'.$insert_month.'月'.$insert_day.'日';
		
		if($key1==0){
			$index[$top_sortno]='
			<div class="box"><!--box start-->
					<table class="tableforh3noback">
						<tr>
							<td class="nopadding">            
								<h3 class="h3noback white">'.htmlspecialchars($obj_login->clientdat[0]['sc_diarytitle']).'</h3>
							</td>
								<td class="nopadding right middle">
								<span class="small white paddingr1"><a href="'._BLOG_SITE_URL_BASE.'diary-rss-'.$obj_login->clientdat[0]['cl_id'].'/"><img src="share/images/rsstext.gif" alt="" /></a></span></td>
						</tr>
					</table>
				<table>';
			}
			
		$index[$top_sortno].='
				<tr>
					<td class="td2a bordergraydotted">
						<p><img src="share/images/item_pen'.$img_color.'.gif" alt="" width="11" height="14" /></p>
					</td>
					<td class="td2b bordergraydotted">
						<p><span class="blue2">'.$insrert_date.'</span></p>
					</td>
					<td class="td2c bordergraydotted">
						<p class="normallink"><a href="'._BLOG_SITE_URL_BASE.'blog-'.$obj_diary->diarydat[$key1]['dr_id'].'/">'.htmlspecialchars($obj_diary->diarydat[$key1]['dr_title']).'</a></p>
					</td>
				</tr>
';
	}
$index[$top_sortno].='				</table>
		</div><!--box end-->';
}
//日記情報終了

if(count($index)){
	$index_list="";
	ksort($index);
	foreach($index as $key=>$val){
		$index_list.=$val;
	}
}

?>
