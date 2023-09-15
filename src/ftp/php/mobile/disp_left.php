<?php
$leftmenu_list=array();//∫∏•·•À•Â°º°°HTML•Ω°º•π

//¢ß¢ß¢ß¢ß¢ß¢ß¢ß¢ß¢ß¢ß¥À‹•·•À•Â°ºHTML∫Ó¿Æ¢ß¢ß¢ß¢ß¢ß¢ß¢ß¢ß¢ß¢ß
$basicmenu_sortno = $obj_login->clientdat[0]['sc_layout4'];//¥À‹•·•À•Â°º§Œ…Ωº®∞Ã√÷(1°¡4)
$obj_leftmenu     = new basedb_LeftmenuClassTblAccess;
$obj_leftmenu->conn=$obj_conn->conn;

//$obj_leftmenu->jyoken["lm_type"]   = 4;
$obj_leftmenu->jyoken["lm_clid"]   = $obj_login->clientdat[0]['cl_id'];
$obj_leftmenu->jyoken["lm_stat"]   = 1;
$obj_leftmenu->jyoken["lm_deldate"]= 1;

$obj_leftmenu->leftmenudat=array();
list( $intCnt_leftmenu , $intTotal_leftmenu ) = $obj_leftmenu->basedb_GetLeftmenu ( 1 , -1 );

$obj_menu = new basedb_MenuClassTblAccess;
$obj_menu->conn = $obj_conn->conn;

$obj_menu->jyoken["mn_clid"]    = $obj_login->clientdat[0]['cl_id'];
$obj_menu->jyoken["mn_lstat"]   = 1;
$obj_menu->jyoken["mn_deldate"] = 1;
$obj_menu->sort["mn_ldispno"]   = 1;

$obj_menu->menudat=array();
list( $intCnt_menu , $intTotal_menu ) = $obj_menu->basedb_GetMenu ( 1 , -1 );

$dispcnt="";
$dispcnt=count($obj_menu->menudat)-1;

//¢ß¢ß¢ß¢ß¢ß¢ß¢ß¢ß¢ß¢ß•÷•Ì•∞•·•À•Â°ºHTML∫Ó¿Æ¢ß¢ß¢ß¢ß¢ß¢ß¢ß¢ß¢ß¢ß
$blogmenu_sortno=$obj_login->clientdat[0]['sc_layout3'];//§™√Œ§È§ª•´•∆•¥•Í•·•À•Â°º§Œ…Ωº®∞Ã√÷(1°¡4)
$obj_leftmenu->jyoken=array();

$obj_leftmenu->leftmenudat=array();
list( $intCnt_leftmenu , $intTotal_leftmenu ) = $obj_leftmenu->basedb_GetLeftmenu ( 1 , -1 );

$obj_category = new basedb_CategoryClassTblAccess;
$obj_category->conn                = $obj_conn->conn;
$obj_category->jyoken["cg_clid"]   = $obj_login->clientdat[0]['cl_id'];
$obj_category->jyoken["cg_stat"]   = 1;
$obj_category->jyoken["cg_type"]   = 5;
$obj_category->jyoken["cg_deldate"]= 1;
$obj_category->sort["cg_dispno"]   = 2;

$obj_category->categorydat=array();
list( $intCnt_category , $intTotal_category ) = $obj_category->basedb_GetCategory ( 1 , -1 );

$dispcnt      = "";
$dispcnt      = count($obj_category->categorydat)-1;
$diary_finding= "";
$diary_finding= $obj_leftmenu->leftmenudat[0]['lm_title'];
$blog_stitle  = array();

//'.$obj_leftmenu->leftmenudat[0]['lm_title'].'<br />
if($dispcnt>=0){
		  $leftmenu[$blogmenu_sortno]='
					 <!--≤ËÃÃ∫∏•·•À•Â°º•ª•√•» start-->
					 §™√Œ§È§ª°¶∆¸µ≠<br />
					 ';

//		  print("$intTotal_diary");
//		  print("<br />");
		  foreach($obj_category->categorydat as $key=>$val){
					 $blog_stitle[]=$obj_category->categorydat[$key]['cg_stitle'];
					 if($key!=$dispcnt){
								$tempdrid	=			$obj_category->categorydat[$key]['cg_id'];
								$drid=$tempdrid;
								list( $intCnt_category , $intTotal_category ) = $obj_category->basedb_GetCategory ( 1 , -1 );
								$start=$page*10 + 1;
								$end=$start+9;
								$obj_diary = new basedb_DiaryClassTblAccess;
								$obj_diary->conn = $obj_conn->conn;
								$obj_diary->jyoken=array();
								$obj_diary->jyoken["dr_clid"]    = $obj_login->clientdat[0]['cl_id'];
								$obj_diary->jyoken["dr_deldate"] = 1;
								$obj_diary->jyoken["dr_cgid"]    = $drid;
								$obj_diary->sort["dr_upddate"]   = 2;
								$obj_diary->diarydat=array();
								list( $intCnt_diary , $intTotal_diary ) = $obj_diary->basedb_GetDiary ( $start , $end );
								$pagemax="";
								$pagedown="";
								$pageup="";
								if($page>=1){
										  $pagedown='<p><a href="'._BLOG_SITE_URL_BASE.'diary-list/p-'.($page-1).'/dr-'.$drid.'/">¡∞§Œ10∑Ô§Ú…Ωº®</a></p>';
								}
								if(($intTotal_diary/10)-($page+1)>0){
										  $pageup='<p><a href="'._BLOG_SITE_URL_BASE.'diary-list/p-'.($page+1).'/dr-'.$drid.'/">º°§Œ10∑Ô§Ú…Ωº®</a></p>';
								}
								$img_path="";
								$dispcnt="";
								$dispcnt=count($obj_diary->diarydat)-1;
								if($intTotal_diary>0){
										  if($start==($start+$intCnt_diary-1)){
													 $case_number=$intTotal_diary.' ∑Ô√Ê '.$start." ∑ÔÃ‹§Ú…Ωº®";
										  }else{
													 $case_number=$intTotal_diary.' ∑Ô√Ê '.$start.' °¡ '.($start+$intCnt_diary-1)." ∑ÔÃ‹§Ú…Ωº®";
										  }
								}else{
										  $case_number="";
								}

								$leftmenu[$blogmenu_sortno].='°°®≤<a href="'._BLOG_SITE_URL_BASE.'diary-list/p-0/dr-'.$obj_category->categorydat[$key]['cg_id'].'/">'.htmlspecialchars($obj_category->categorydat[$key]['cg_stitle']).'</a>
										  ('.$intTotal_diary.'∑Ô)	 <br />';

					 }elseif($key==$dispcnt){

								$leftmenu[$blogmenu_sortno].='°°®±<a href="'._BLOG_SITE_URL_BASE.'diary-list/p-0/dr-'.$obj_category->categorydat[$key]['cg_id'].'/">'.htmlspecialchars($obj_category->categorydat[$key]['cg_stitle']).'</a><br />
										  ';
					 }
		  }
		  $leftmenu[$blogmenu_sortno].='<!--≤ËÃÃ∫∏•·•À•Â°º•ª•√•» end-->
					 ';
}
//¢•¢•¢•¢•¢•¢•¢•¢•¢•¢••÷•Ì•∞•·•À•Â°ºHTML∫Ó¿Æ¢•¢•¢•¢•¢•¢•¢•¢•¢•¢•

//¢ß¢ß¢ß¢ß¢ß¢ß¢ß¢ß¢ß¢ß•≠•„•Û•⁄°º•Û•·•À•Â°ºHTML∫Ó¿Æ¢ß¢ß¢ß¢ß¢ß¢ß¢ß¢ß¢ß¢ß
$campaignmenu_sortno=$obj_login->clientdat[0]['sc_layout2'];//§™√Œ§È§ª•´•∆•¥•Í•·•À•Â°º§Œ…Ωº®∞Ã√÷(1°¡4)
$obj_leftmenu->jyoken              = array();
$obj_leftmenu->jyoken["lm_type"]   = 2;
$obj_leftmenu->jyoken["lm_clid"]   = $obj_login->clientdat[0]['cl_id'];
$obj_leftmenu->jyoken["lm_stat"]   = 1;
$obj_leftmenu->jyoken["lm_deldate"]= 1;

$obj_leftmenu->leftmenudat=array();
list( $intCnt_leftmenu , $intTotal_leftmenu ) = $obj_leftmenu->basedb_GetLeftmenu ( 1 , -1 );

$obj_category->jyoken              = array();
$obj_category->jyoken["cg_clid"]   = $obj_login->clientdat[0]['cl_id'];
$obj_category->jyoken["cg_stat"]   = 1;
$obj_category->jyoken["cg_type"]   = 6;
$obj_category->jyoken["cg_deldate"]= 1;
$obj_category->sort["cg_dispno"]   = 2;

$obj_category->categorydat=array();
list( $intCnt_category , $intTotal_category ) = $obj_category->basedb_GetCategory ( 1 , -1 );

$dispcnt="";
$dispcnt=count($obj_category->categorydat)-1;
$campaign_finding="";
$campaign_finding=$obj_leftmenu->leftmenudat[0]['lm_title'];
if($dispcnt>=0){
		  $leftmenu[$campaignmenu_sortno]='
					 <!--≤ËÃÃ∫∏•·•À•Â°º•ª•√•» start-->
					 <!--    <li>'.$obj_leftmenu->leftmenudat[0]['lm_title'].'</li>-->
					 π÷Ω¨°¶•§•Ÿ•Û•»æ Û<br />
					 ';
		  foreach($obj_category->categorydat as $key=>$val){
					 if($key!=$dispcnt){

								$cpid	=			$obj_category->categorydat[$key]['cg_id'];

								//if($_GET['cpid']){ $cpid=$_GET['cpid']; }else{ $cpid="1726"; }

								if($_GET['page']){
										  $page=$_GET['page'];
								}else{
										  $page="0";
								}

								$obj_category->categorydat=array();
								list( $intCnt_category , $intTotal_category ) = $obj_category->basedb_GetCategory ( 1 , -1 );

								$start = $page*5 + 1;
								$end   = $start  + 4;

								$timestamp='(timestamp \''.date("Y").'-'.date("m").'-'.date("d").' 00:00:00\')';

								$obj_campaign = new basedb_CampainClassTblAccess;
								$obj_campaign->conn = $obj_conn->conn;
								$obj_campaign->jyoken["cp_clid"]        = $obj_login->clientdat[0]['cl_id'];
								$obj_campaign->jyoken["cp_stat"]        = 1;
								$obj_campaign->jyoken["cp_cgid"]        = $cpid;
								$obj_campaign->jyoken["cp_deldate"]     = 1;
								$obj_campaign->jyoken["cp_publishstart"]= $timestamp;
								$obj_campaign->jyoken["cp_publishend"]  = $timestamp;
								$obj_campaign->sort["cp_upddate"]       = 2;

								$obj_campaign->campaindat=array();
								list( $intCnt_campaign , $intTotal_campaign ) = $obj_campaign->basedb_GetCampain ( $start , $end );

								if($intTotal_campaign>0){
										  if($start==($start+$intCnt_campaign-1)){
													 $case_number=$intTotal_campaign.' ∑Ô√Ê '.$start." ∑ÔÃ‹§Ú…Ωº®";
										  }else{
													 $case_number=$intTotal_campaign.' ∑Ô√Ê '.$start.' °¡ '.($start+$intCnt_campaign-1)." ∑ÔÃ‹§Ú…Ωº®";
										  }
								}

								$leftmenu[$campaignmenu_sortno].='°°®≤<a href="'._BLOG_SITE_URL_BASE.'campain-list/p-0/cp-'.$obj_category->categorydat[$key]['cg_id'].'/">'.htmlspecialchars($obj_category->categorydat[$key]['cg_stitle']).'</a>
										  ('.$intCnt_campaign.'∑Ô)<br />';
					 }elseif($key==$dispcnt){

								$leftmenu[$campaignmenu_sortno].='°°®≤<a href="'._BLOG_SITE_URL_BASE.'campain-list/p-0/cp-'.$obj_category->categorydat[$key]['cg_id'].'/">'.htmlspecialchars($obj_category->categorydat[$key]['cg_stitle']).'</a>
										  ('.$intCnt_campaign.'∑Ô)<br />';
					 }
		  }
		  $leftmenu[$campaignmenu_sortno].='<!--≤ËÃÃ∫∏•·•À•Â°º•ª•√•» end-->
					 ';
}

$free_html=html_replace($obj_login->clientdat[0]['sc_lhtml']);

$free_html_list='
		  <div><!--≤ËÃÃ∫∏•·•À•Â°º•ª•√•» start-->

		  <div><!--freespace start-->
		  '.nl2br($free_html).'
		  </div><!--freespace end-->

		  </div><!--≤ËÃÃ∫∏•·•À•Â°º•ª•√•» end-->
		  ';

if(count($leftmenu)){
		  $leftmenu_list="";
		  ksort($leftmenu);
		  foreach($leftmenu as $key=>$val){
					 $leftmenu_list.=$val;
		  }
}
//test…Ωº® •¢•Û•… ‘Ω∏
$tophtml ="aaaaaaaaaaaa"

?>
