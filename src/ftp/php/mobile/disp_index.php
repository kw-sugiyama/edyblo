<?
//=====================================================================
// index.tplで使う変数リスト
//
//index_listI
//leftmenu_listibento
//index_listC
//leftmenu_lista?
//leftmenu_listo
//=====================================================================

//マーク定数
$hosimark= "<font color=\"#00B0F0\">*</font>";

/* 教室紹介　　　　 ：1 <キャンペーン情報：2 コース情報　　　 ：3 ブログ(日記)　　 ：4 */
//▲▲▲▲▲▲▲▲▲▲キャンペーン・イベント情報一覧開始▲▲▲▲▲▲▲▲▲▲
$obj_campaign_chk2                             = new basedb_CampainClassTblAccess;
$obj_campaign_chk2->conn                       = $obj_conn->conn;
$obj_campaign_chk2->jyoken["cp_clid"]          = $obj_login->clientdat[0]['cl_id'];
$obj_campaign_chk2->jyoken["cp_stat"]          = 1;
//$obj_campaign_chk2->jyoken["cp_topflg"]        = 2;
$obj_campaign_chk2->jyoken["cp_deldate"]       = 1;
$obj_campaign_chk2->jyoken["cp_publishstart"]  = $timestamp;
$obj_campaign_chk2->jyoken["cp_publishend"]    = $timestamp;
$obj_campaign_chk2->sort["cp_upddate"]         = 2;
$obj_campaign_chk2->campaindat                 = array();
list( $intCnt_campaign , $intTotal_campaign )  = $obj_campaign_chk2->basedb_GetCampain ( 1 , 3 );
$campaign_chk2_cnt                             = "";
$campaign_chk2_cnt                             = count($obj_campaign_chk2->campaindat)-1;
//見出しタイトル作成
if( $campaign_chk1_cnt >= 0 || $campaign_chk2_cnt >= 0 ){
	//$indexI[$top_sortno].='<!--box start-->'.htmlspecialchars($obj_login->clientdat[0]['sc_campaintitle']).'<br>';
	$indexI[$top_sortno].='<br /><img src="./share/images/event.gif" ><br />';
}

$timestamp                                  = '(timestamp \''.date("Y").'-'.date("m").'-'.date("d").' 00:00:00\')';
$obj_campaign                               = new basedb_CampainClassTblAccess;

//接続
$obj_campaign                                  = new basedb_CampainClassTblAccess;
$obj_campaign->conn                            = $obj_conn->conn;
$obj_campaign->jyoken["cp_clid"]               = $obj_login->clientdat[0]['cl_id'];
$obj_campaign->jyoken["cp_stat"]               = 1;
// top flg = バナー表示1 非表示2 一行テキスト表示3
$obj_campaign->jyoken["cp_deldate"]            = 1;
$obj_campaign->jyoken["cp_publishstart"]       = $timestamp;
$obj_campaign->jyoken["cp_publishend"]         = $timestamp;
$obj_campaign->sort["cp_upddate"]              = 2;
$obj_campaign->campaindat                      = array();
list( $intCnt_campaign , $intTotal_campaign )  = $obj_campaign->basedb_GetCampain ( 1 , 3 );
$dispcnt="";
$dispcnt=count($obj_campaign->campaindat)-1;
if($dispcnt>=0)
	foreach($obj_campaign->campaindat as $key1=>$val1){
		$obj_category->jyoken                           = array();
		$obj_category->jyoken["cg_clid"]                = $obj_login->clientdat[0]['cl_id'];
		$obj_category->jyoken["cg_stat"]                = 1;
		$obj_category->jyoken["cg_type"]                = 6;
		$obj_category->jyoken["cg_deldate"]             = 1;
		$obj_category->jyoken["cg_id"]                  = $obj_campaign->campainda[$key1]['cp_cgid'];
		$obj_category->categorydat                      = array();
		//list( $intCnt_category , $intTotal_category ) = $obj_category->basedb_GetCategory ( 1 , -1 );
		$data                                           = pathinfo($obj_campaign->campaindat[$key1]['cp_bkgdimg']);
		$banner = $data['filename'];
		
		if($key1==$dispcnt)
		{     //最後以外の行
				  $indexI[$top_sortno].='
							 <!--campaignbox start-->'.$hosimark.'
							 <a href="'._BLOG_SITE_URL_BASE.'campaign-detail-'.$obj_campaign->campaindat[$key1]['cp_id'].'/">
<font color="#666666">
							 '.htmlspecialchars($obj_campaign->campaindat[$key1]['cp_title']).'
							 <!-- <a href="'._BLOG_SITE_URL_BASE.'campaign-detail-'.$obj_campaign->campaindat[$key1]['cp_id'].'/">'.htmlspecialchars($obj_campaign->campaindat[$key1]['cp_linktext']).'</a>-->
							 <!-- <a href="'._BLOG_SITE_URL_BASE.'campaign-detail-'.$obj_campaign->campaindat[$key1]['cp_id'].'/">'.htmlspecialchars($obj_campaign->campaindat[$key1]['cp_btntext']).'</a><br>-->
</font>
</a><br />
							 <!--campaignbox end-->
							 ';		
		}else{//最後の行
				  $indexI[$top_sortno].='
							 <!--campaignbox start-->'.$hosimark.'
							 <a href="'._BLOG_SITE_URL_BASE.'campaign-detail-'.$obj_campaign->campaindat[$key1]['cp_id'].'/">
<font color="#666666">
							 '.htmlspecialchars($obj_campaign->campaindat[$key1]['cp_title']).'
							 <!-- <a href="'._BLOG_SITE_URL_BASE.'campaign-detail-'.$obj_campaign->campaindat[$key1]['cp_id'].'/">'.htmlspecialchars($obj_campaign->campaindat[$key1]['cp_linktext']).'</a>-->
							 <!-- <a href="'._BLOG_SITE_URL_BASE.'campaign-detail-'.$obj_campaign->campaindat[$key1]['cp_id'].'/">'.htmlspecialchars($obj_campaign->campaindat[$key1]['cp_btntext']).'</a><br>-->
</font>
</a><br />
							 <!--campaignbox end-->
							 ';
		}
	}



if(count($indexI)){
		  $index_listI="";
		  ksort($indexI);
		  foreach($indexI as $key=>$val){
					 $index_listI.=$val;
		  }
}

//マーク定数
$hosimark2= "<font color=\"#FFC000\">*</font>";

//▲▲▲▲▲▲▲▲▲▲日記・イベント情報一覧開始▲▲▲▲▲▲▲▲▲▲
$top_sortno                      = $obj_login->clientdat[0]['sc_layout8'];//日記の表示位置(1〜4)
$obj_diary                       = new basedb_DiaryClassTblAccess;
$obj_diary->conn                 = $obj_conn->conn;
$obj_diary->jyoken               = array();
$obj_diary->jyoken["dr_clid"]    = $obj_login->clientdat[0]['cl_id'];
$obj_diary->jyoken["dr_deldate"] = 1;
$obj_diary->sort["dr_upddate"]   = 2;
$obj_diary->diarydat             = array();
//listの数を設定
list( $intCnt_diarylist , $intTotal_diarylist ) = $obj_diary->basedb_GetDiary ( 1 , 3 );
$img_path   = "";
$dispcnt    = "";
$dispcnt    = count($obj_diary->diarydat)-1;
if($dispcnt>=0){
		  foreach($obj_diary->diarydat as $key1=>$val1){

					 $insert_year  = substr($obj_diary->diarydat[$key1]['dr_insdate'],0,4);
					 $insert_month = substr($obj_diary->diarydat[$key1]['dr_insdate'],5,2);
					 $insert_day   = substr($obj_diary->diarydat[$key1]['dr_insdate'],8,2);
					 $insrert_date = $insert_year.'年'.$insert_month.'月'.$insert_day.'日';

					 if($key1==0){//title（見出し）を表示する
								//$indexC[$top_sortno]=' <div><!--box start--> '.htmlspecialchars($obj_login->clientdat[0]['sc_diarytitle']).'</font> <br />';
								$indexC[$top_sortno].='<br /><img src="./share/images/oshirase.gif"><br />';
					 }
					 if ( $key1!=$dispcnt )
					 {//最後以外の行
								$indexC[$top_sortno].='
									 		'.$hosimark2.'
										  <a href="'._BLOG_SITE_URL_BASE.'blog-'.$obj_diary->diarydat[$key1]['dr_id'].'/">
<font color="#666666">
										  '.htmlspecialchars($obj_diary->diarydat[$key1]['dr_title']).'
</font>
</a>
										  <br />
										  ';
					 }
					 if ( $key1==$dispcnt )
					 {//最後の行
								$indexC[$top_sortno].='
									 		'.$hosimark2.'
										  <a href="'._BLOG_SITE_URL_BASE.'blog-'.$obj_diary->diarydat[$key1]['dr_id'].'/">
<font color="#666666">
										  '.htmlspecialchars($obj_diary->diarydat[$key1]['dr_title']).'
</font>
</a>
										  <br />';
					 }
		  }
		  $indexC[$top_sortno].='
		  </div><!--box end-->';
}
if(count($indexC)){
		  $index_listC="";
		  ksort($indexC);
		  foreach($indexC as $key=>$val){
				$index_listC.=$val;
		  }
}


$leftmenu_list="";
//講習タイトル表示
$basicmenu_sortno=$obj_login->clientdat[0]['sc_layout4'];//基本メニューの表示位置(1〜4)
$obj_leftmenu=new basedb_LeftmenuClassTblAccess;
$obj_leftmenu->conn=$obj_conn->conn;
$obj_leftmenu->jyoken["lm_type"]=2;
$obj_leftmenu->jyoken["lm_clid"]=$obj_login->clientdat[0]['cl_id'];
$obj_leftmenu->jyoken["lm_stat"]=1;
$obj_leftmenu->jyoken["lm_deldate"]=1;
$obj_leftmenu->leftmenudat=array();
list( $intCnt_leftmenu , $intTotal_leftmenu ) = $obj_leftmenu->basedb_GetLeftmenu ( 1 , -1 );
$ktitle= htmlspecialchars($obj_leftmenu->leftmenudat[0]['lm_title']);
//print_r($obj_leftmenu->leftmenudat[0]);

//▲▲▲▲▲▲▲▲▲▲講習イベント一覧開始▲▲▲▲▲▲▲▲▲▲
$obj_category                           = new basedb_CategoryClassTblAccess;
$obj_category->conn                     = $obj_conn->conn;
$obj_category->jyoken                   = array();
$obj_category->jyoken["cg_clid"]        = $obj_login->clientdat[0]['cl_id'];
$obj_category->jyoken["cg_stat"]        = 1;
$obj_category->jyoken["cg_type"]        = 6;
$obj_category->jyoken["cg_deldate"]     = 1;
$obj_category->sort["cg_dispno"]        = 2;
$obj_category->categorydat              = array();
list( $intCnt_category , $intTotal_category ) = $obj_category->basedb_GetCategory ( 1 , -1 );

$dispcnt          = "";
$dispcnt          = count($obj_category->categorydat)-1;
$campaign_finding = "";
$campaign_finding = $obj_leftmenu->leftmenudat[0]['lm_title'];
if($dispcnt>=0){
		  $leftmenu[$campaignmenu_sortno]='
					 <!--メニューセット start-->
					 <!--    <li>'.$obj_leftmenu->leftmenudat[0]['lm_title'].'</li>-->
					 <font size="1" color="#538ED5">'.$ktitle.'</font><br />
					 ';
		  foreach($obj_category->categorydat as $key=>$val){
					 $cpid	=			$obj_category->categorydat[$key]['cg_id'];

					 if($_GET['page']){
								$page=$_GET['page'];
					 }else{
								$page="0";
					 }
					 $obj_category->categorydat=array();
					 list( $intCnt_category , $intTotal_category ) = $obj_category->basedb_GetCategory ( 1 , -1 );

					 $timestamp                               = '(timestamp \''.date("Y").'-'.date("m").'-'.date("d").' 00:00:00\')';
					 $obj_campaign                            = new basedb_CampainClassTblAccess;
					 $obj_campaign->conn                      = $obj_conn->conn;
					 $obj_campaign->jyoken["cp_clid"]         = $obj_login->clientdat[0]['cl_id'];
					 $obj_campaign->jyoken["cp_stat"]         = 1;
					 $obj_campaign->jyoken["cp_cgid"]         = $cpid;
					 $obj_campaign->jyoken["cp_deldate"]      = 1;
					 $obj_campaign->jyoken["cp_publishstart"] = $timestamp;
					 $obj_campaign->jyoken["cp_publishend"]   = $timestamp;
					 $obj_campaign->sort["cp_upddate"]        = 2;
					 $obj_campaign->campaindat                = array();
					 list( $intCnt_campaign , $intTotal_campaign ) = $obj_campaign->basedb_GetCampain ( 1 , -1 );
					 //					 $leftmenu[$campaignmenu_sortno].='　┣<a href="'._BLOG_SITE_URL_BASE.'campain-list/p-1/cp-'.$obj_category->categorydat[$key]['cg_id'].'/">'.htmlspecialchars($obj_category->categorydat[$key]['cg_stitle']).'</a>
					 //								('.$intCnt_campaign.'件)<br />';
					 if($key==$dispcnt){
								if($intCnt_campaign=="0"){
								//最後のリスト
									 $leftmenu[$campaignmenu_sortno].='
											'.$hosimark.'<font color="#663300">
										  '.htmlspecialchars($obj_category->categorydat[$key]['cg_stitle']).'
													 ('.$intCnt_campaign.'件)<br /></font>';
								}else{
									 $leftmenu[$campaignmenu_sortno].='
											'.$hosimark.'
										  <a href="'._BLOG_SITE_URL_BASE.'campain-list/p-1/cp-'.$obj_category->categorydat[$key]['cg_id'].'/">
<font color="#666666">
										  '.htmlspecialchars($obj_category->categorydat[$key]['cg_stitle']).'
</a>
													 ('.$intCnt_campaign.'件)<br />';
								}
					 }else{//途中のリスト
								if($intCnt_campaign=="0"){
									 $leftmenu[$campaignmenu_sortno].='
											'.$hosimark.'<font color="#663300">
										  '.htmlspecialchars($obj_category->categorydat[$key]['cg_stitle']).'
													 ('.$intCnt_campaign.'件)<br />';
								}else{
									 $leftmenu[$campaignmenu_sortno].='
											'.$hosimark.'
										  <a href="'._BLOG_SITE_URL_BASE.'campain-list/p-1/cp-'.$obj_category->categorydat[$key]['cg_id'].'/">
<font color="#666666">
										  '.htmlspecialchars($obj_category->categorydat[$key]['cg_stitle']).'
</font>
</a>
													 ('.$intCnt_campaign.'件)<br />';
								}
					 }
		  }
}
$leftmenu[$campaignmenu_sortno].='<!--画面左メニューセット end-->';

$free_html      = html_replace($obj_login->clientdat[0]['sc_lhtml']);
$free_html_list = '
		  <div><!--画面左メニューセット start-->
		  <div><!--freespace start-->
		  '.nl2br($free_html).'
		  </div><!--freespace end-->

		  </div><!--画面左メニューセット end-->
		  ';
//代入leftmenu
if(count($leftmenu)){
		  $leftmenu_listibento="";
		  ksort($leftmenu);
		  foreach($leftmenu as $key=>$val){
					 $leftmenu_listibento.=$val;
		  }
}
//print("<font size=\"1\">");
$leftmenu_listo="";

//▲▲▲▲▲▲▲▲▲▲お知らせ日記情報開始▲▲▲▲▲▲▲▲▲▲
$leftmenu_listo=array();//左メニュー　HTMLソース

$obj_category                       = new basedb_CategoryClassTblAccess;
$obj_category->conn                 = $obj_conn->conn;
$obj_category->jyoken["cg_clid"]    = $obj_login->clientdat[0]['cl_id'];
$obj_category->jyoken["cg_stat"]    = 1;
$obj_category->jyoken["cg_type"]    = 5;
$obj_category->jyoken["cg_deldate"] = 1;
$obj_category->sort["cg_dispno"]    = 2;
$obj_category->categorydat          = array();
list( $intCnt_category , $intTotal_category ) = $obj_category->basedb_GetCategory ( 1 , -1 );

$dispcnt      = "";
$dispcnt      = count($obj_category->categorydat)-1;
//$dispcnt      = count($obj_diary->diarydat)-1;
//print("$dispcnt");
$diary_finding= "";
$diary_finding= $obj_leftmenu->leftmenudat[0]['lm_title'];
$blog_stitle  = array();
//=====================================================================
//blogタイトル表示
$basicmenu_sortno=$obj_login->clientdat[0]['sc_layout4'];//基本メニューの表示位置(1〜4)
$obj_leftmenu=new basedb_LeftmenuClassTblAccess;
$obj_leftmenu->conn=$obj_conn->conn;
$obj_leftmenu->jyoken["lm_type"]=3;
$obj_leftmenu->jyoken["lm_clid"]=$obj_login->clientdat[0]['cl_id'];
$obj_leftmenu->jyoken["lm_stat"]=1;
$obj_leftmenu->jyoken["lm_deldate"]=1;
$obj_leftmenu->leftmenudat=array();
list( $intCnt_leftmenu , $intTotal_leftmenu ) = $obj_leftmenu->basedb_GetLeftmenu ( 1 , -1 );
$blogtitle = htmlspecialchars($obj_leftmenu->leftmenudat[0]['lm_title']);
//print_r($obj_leftmenu->leftmenudat[0]);
//=====================================================================
$dispcnttemp=$dispcnt;
//'.$obj_leftmenu->leftmenudat[0]['lm_title'].'<br />
if($dispcnt>=0){
		  $leftmenu[$blogmenu_sortno]='
					 <!--画面左メニューセット start-->
					 <font size="1" color="#FF6600">'.$blogtitle.'</font><br />
					 ';
		  foreach($obj_category->categorydat as $key=>$val){
					 $blog_stitle[]=$obj_category->categorydat[$key]['cg_stitle'];

	//				 if($key!=$dispcnt){
								$tempdrid	=			$obj_category->categorydat[$key]['cg_id'];
								$drid=$tempdrid;
								list( $intCnt_category , $intTotal_category ) = $obj_category->basedb_GetCategory ( 1 , -1 );

								$obj_diary = new basedb_DiaryClassTblAccess;
								$obj_diary->conn = $obj_conn->conn;
								$obj_diary->jyoken=array();
								$obj_diary->jyoken["dr_clid"]    = $obj_login->clientdat[0]['cl_id'];
								$obj_diary->jyoken["dr_deldate"] = 1;
								$obj_diary->jyoken["dr_cgid"]    = $drid;
								$obj_diary->sort["dr_upddate"]   = 2;
								$obj_diary->diarydat=array();

								list( $intCnt_diary , $intTotal_diary ) = $obj_diary->basedb_GetDiary ( 1, 1);
								$img_path="";
								$dispcnt=count($obj_diary->diarydat)-1;

								if($key == $dispcnttemp){
									 
									 if($intTotal_diary=="0"){
										//最後のリスト  
										  $leftmenu[$blogmenu_sortno].='
											'.$hosimark2.'<font color="#663300">
												'.htmlspecialchars($obj_category->categorydat[$key]['cg_stitle']).'
										  ('.$intTotal_diary.'件)	 <br />';
										  }else{
										  
												$leftmenu[$blogmenu_sortno].='
											'.$hosimark2.'
													 <a href="'._BLOG_SITE_URL_BASE.'diary-list/p-1/dr-'.$obj_category->categorydat[$key]['cg_id'].'/">
<font color="#666666">
													 '.htmlspecialchars($obj_category->categorydat[$key]['cg_stitle']).'
</font>
</a>
										  ('.$intTotal_diary.'件)	 <br />';
										  }
								}else{//途中のリスト
										  if($intTotal_diary=="0"){
												$leftmenu[$blogmenu_sortno].='
											'.$hosimark2.'<font color="#663300">
													 '.htmlspecialchars($obj_category->categorydat[$key]['cg_stitle']).'
										  ('.$intTotal_diary.'件)	 <br />';
										  }else{
												$leftmenu[$blogmenu_sortno].='
											'.$hosimark2.'
													 <a href="'._BLOG_SITE_URL_BASE.'diary-list/p-1/dr-'.$obj_category->categorydat[$key]['cg_id'].'/">
<font color="#666666">
													 '.htmlspecialchars($obj_category->categorydat[$key]['cg_stitle']).'
</font>
</a>
										  ('.$intTotal_diary.'件)	 <br />';
}
								}

//					 }
		  }
		  $leftmenu[$blogmenu_sortno].='<!--画面左メニューセット end-->
					 ';
		  if(count($leftmenu)){
					 $leftmenu_listo="";
					 ksort($leftmenu);
					 foreach($leftmenu as $key=>$val){
								$leftmenu_listo.=$val;
					 }

		  }
}else{
		  //何も入ってなかったら空欄
		  $leftmenu_listo="";
}


//▲▲▲▲▲▲▲▲▲▲お知らせ日記情報開始▲▲▲▲▲▲▲▲▲▲

if(count($index)){
		  $index_list="";
		  ksort($index);
		  foreach($index as $key=>$val){
					 $index_list.=$val;
		  }
}
//沿線情報
$obj_ensen                    = new basedb_EnsenClassTblAccess;
$obj_ensen->conn              = $obj_conn->conn;
$obj_ensen->jyoken["es_cd"]   = $obj_login->clientdat[0]['cl_id'];
$obj_ensen->sort["es_dispno"] = 1;

$obj_ensen->ensendat=array();
list( $intCnt_ensen , $intTotal_ensen ) = $obj_ensen->basedb_GetEnsen ( 1 , -1 );

$ensen=array();
$ensen['line1'] = $obj_ensen->ensendat[0]['es_line'];
if($obj_ensen->ensendat[0]['es_sta'])  $ensen['sta1']  = $obj_ensen->ensendat[0]['es_sta']."駅";
if($obj_ensen->ensendat[0]['es_bus'])  $ensen['bus1']  = " バス".$obj_ensen->ensendat[0]['es_bus']."分";
if($obj_ensen->ensendat[0]['es_walk']) $ensen['walk1'] =" 徒歩".$obj_ensen->ensendat[0]['es_walk']."分";
if($obj_ensen->ensendat[0]['es_biko']) $ensen['biko1'] =" ".$obj_ensen->ensendat[0]['es_biko'];

if($obj_ensen->ensendat[1]['es_line']){
		  $ensen['line2'] =  $obj_ensen->ensendat[1]['es_line'];
		  if($obj_ensen->ensendat[1]['es_sta']) $ensen['sta2']   = $obj_ensen->ensendat[1]['es_sta']."駅";
		  if($obj_ensen->ensendat[1]['es_bus']) $ensen['bus2']   = "　バス".$obj_ensen->ensendat[1]['es_bus']."分";
		  if($obj_ensen->ensendat[1]['es_walk']) $ensen['walk2'] ="　徒歩".$obj_ensen->ensendat[1]['es_walk']."分";
		  if($obj_ensen->ensendat[1]['es_biko']) $ensen['biko2'] =" ".$obj_ensen->ensendat[1]['es_biko'];
}

//沿線情報
$a = $ensen;
foreach( $a as $key => $value ){
		  $ensendate .=$value;
}

//電話番号　地域
$obj_area                   = new basedb_AreaClassTblAccess;
$obj_area->conn             = $obj_conn ->conn;
$obj_area->jyoken["ar_clid"]= $obj_login->clientdat[0]['cl_id'];
$obj_area->sort['ar_flg']   = 2;
$obj_area->areadat=array();

list( $intCnt_area , $intTotal_area ) = $obj_area->basedb_GetArea ( 1 , -1 );

$area['address']=$obj_area->areadat[0]['ar_pref'].$obj_area->areadat[0]['ar_city'].$obj_area->areadat[0]['ar_add']." ".$obj_area->areadat[0]['ar_estate'];

//未入力項目は「−」を表示
if($obj_login->clientdat[0]['cl_kname']){
		  $cl_kname  =$obj_login->clientdat[0]['cl_kname'];
}

if($obj_login->clientdat[0]['cl_phone']){
		  $cl_phone  =$obj_login->clientdat[0]['cl_phone'];
}else{
		  $cl_phone  ="−";
}

//未入力は無し
if($obj_login->clientdat[0]['cl_fax']){
		  $cl_fax    =$obj_login->clientdat[0]['cl_fax'];
}else{
		  $cl_fax    ="";
}
//追加タイトル
#$sc_top_title = $obj_login->clientdat[0]['sc_toptitle'];
#$sc_cl_jname  = $obj_login->clientdat[1]['cl_jname'];
$school_box_title    = $obj_login->clientdat[0]['cl_jname'];


//▲▲▲▲▲▲▲▲▲▲HTML情報開始▲▲▲▲▲▲▲▲▲▲


//マーク定数
$mark= "<font size=\"1\" color=\"#C5BE97\">■</font>";
//FAXが無かったら空欄
if(!$cl_fax){
$cl_faxprint="";
}else{
$cl_faxprint="$mark FAX $cl_fax<br>";
}
//教室情報 代入
$school_list.='
		  <!--box start-->
		  '.$img_path.'
		  <font size ="1">
		  '.$mark.'
		  '.htmlspecialchars($obj_login->clientdat[0]['cl_jname']).'
		  '.htmlspecialchars($cl_kname).'<br />
		  
		  '.$mark.'
		  	'.htmlspecialchars($area['address']).'<br />
		  
		  '.$mark.'
			<a href="'._BLOG_SITE_URL_BASE.'school/">
<font size ="1" color="#666666">
			地図
</a>
</font>
		     <br>
		  
		  '.$mark.'
		  	'.htmlspecialchars($ensendate).'<br />
		  
			'.$mark.'
			<font size="1">
		   TEL
		  </span><font size="1">
		  <a href="tel:'.$cl_phone.'">
<font  sizee="1" color="#666666">
		  '.$cl_phone.'
</a>
</font>
		<br />
		  '.$cl_faxprint.'
		  
		  '.$mark.'
<font  size="1" color="">
		   受付時間
		  '.ltrim($obj_login->clientdat[0]['sc_start'],"0").' 〜 '.ltrim($obj_login->clientdat[0]['sc_end'],"0").'<br />
		  
		  '.$mark.'
<font  size="1" color="">
		   定休日
		  '.htmlspecialchars($obj_login->clientdat[0]['sc_holiday']).'<br />
		  </a>
		  
		  '.$mark.'
<font  sizee="1" color="#666666">
		    <a href="'._BLOG_SITE_URL_BASE.'school_detail/">
<font color="#666666">
		   詳細はこちら
</a>
</font>
		  ';
?>
