<?php
$leftmenu_list=array();//����˥塼��HTML������

//�����������������������ܥ�˥塼HTML������������������������
$basicmenu_sortno = $obj_login->clientdat[0]['sc_layout4'];//���ܥ�˥塼��ɽ������(1��4)
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

//���������������������֥���˥塼HTML������������������������
$blogmenu_sortno=$obj_login->clientdat[0]['sc_layout3'];//���Τ餻���ƥ����˥塼��ɽ������(1��4)
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
					 <!--���̺���˥塼���å� start-->
					 ���Τ餻������<br />
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
										  $pagedown='<p><a href="'._BLOG_SITE_URL_BASE.'diary-list/p-'.($page-1).'/dr-'.$drid.'/">����10���ɽ��</a></p>';
								}
								if(($intTotal_diary/10)-($page+1)>0){
										  $pageup='<p><a href="'._BLOG_SITE_URL_BASE.'diary-list/p-'.($page+1).'/dr-'.$drid.'/">����10���ɽ��</a></p>';
								}
								$img_path="";
								$dispcnt="";
								$dispcnt=count($obj_diary->diarydat)-1;
								if($intTotal_diary>0){
										  if($start==($start+$intCnt_diary-1)){
													 $case_number=$intTotal_diary.' ���� '.$start." ���ܤ�ɽ��";
										  }else{
													 $case_number=$intTotal_diary.' ���� '.$start.' �� '.($start+$intCnt_diary-1)." ���ܤ�ɽ��";
										  }
								}else{
										  $case_number="";
								}

								$leftmenu[$blogmenu_sortno].='����<a href="'._BLOG_SITE_URL_BASE.'diary-list/p-0/dr-'.$obj_category->categorydat[$key]['cg_id'].'/">'.htmlspecialchars($obj_category->categorydat[$key]['cg_stitle']).'</a>
										  ('.$intTotal_diary.'��)	 <br />';

					 }elseif($key==$dispcnt){

								$leftmenu[$blogmenu_sortno].='����<a href="'._BLOG_SITE_URL_BASE.'diary-list/p-0/dr-'.$obj_category->categorydat[$key]['cg_id'].'/">'.htmlspecialchars($obj_category->categorydat[$key]['cg_stitle']).'</a><br />
										  ';
					 }
		  }
		  $leftmenu[$blogmenu_sortno].='<!--���̺���˥塼���å� end-->
					 ';
}
//���������������������֥���˥塼HTML������������������������

//�������������������������ڡ����˥塼HTML������������������������
$campaignmenu_sortno=$obj_login->clientdat[0]['sc_layout2'];//���Τ餻���ƥ����˥塼��ɽ������(1��4)
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
					 <!--���̺���˥塼���å� start-->
					 <!--    <li>'.$obj_leftmenu->leftmenudat[0]['lm_title'].'</li>-->
					 �ֽ������٥�Ⱦ���<br />
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
													 $case_number=$intTotal_campaign.' ���� '.$start." ���ܤ�ɽ��";
										  }else{
													 $case_number=$intTotal_campaign.' ���� '.$start.' �� '.($start+$intCnt_campaign-1)." ���ܤ�ɽ��";
										  }
								}

								$leftmenu[$campaignmenu_sortno].='����<a href="'._BLOG_SITE_URL_BASE.'campain-list/p-0/cp-'.$obj_category->categorydat[$key]['cg_id'].'/">'.htmlspecialchars($obj_category->categorydat[$key]['cg_stitle']).'</a>
										  ('.$intCnt_campaign.'��)<br />';
					 }elseif($key==$dispcnt){

								$leftmenu[$campaignmenu_sortno].='����<a href="'._BLOG_SITE_URL_BASE.'campain-list/p-0/cp-'.$obj_category->categorydat[$key]['cg_id'].'/">'.htmlspecialchars($obj_category->categorydat[$key]['cg_stitle']).'</a>
										  ('.$intCnt_campaign.'��)<br />';
					 }
		  }
		  $leftmenu[$campaignmenu_sortno].='<!--���̺���˥塼���å� end-->
					 ';
}

$free_html=html_replace($obj_login->clientdat[0]['sc_lhtml']);

$free_html_list='
		  <div><!--���̺���˥塼���å� start-->

		  <div><!--freespace start-->
		  '.nl2br($free_html).'
		  </div><!--freespace end-->

		  </div><!--���̺���˥塼���å� end-->
		  ';

if(count($leftmenu)){
		  $leftmenu_list="";
		  ksort($leftmenu);
		  foreach($leftmenu as $key=>$val){
					 $leftmenu_list.=$val;
		  }
}
//testɽ�� ������Խ�
$tophtml ="aaaaaaaaaaaa"

?>
