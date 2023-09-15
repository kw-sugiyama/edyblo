<?php

$leftmenu_list=array();//º¸¥á¥Ë¥å¡¼¡¡HTML¥½¡¼¥¹

//¢§¢§¢§¢§¢§¢§¢§¢§¢§¢§´ðËÜ¥á¥Ë¥å¡¼HTMLºîÀ®¢§¢§¢§¢§¢§¢§¢§¢§¢§¢§
$basicmenu_sortno=$obj_login->clientdat[0]['sc_layout4'];//´ðËÜ¥á¥Ë¥å¡¼¤ÎÉ½¼¨°ÌÃÖ(1¡Á4)
$obj_leftmenu=new basedb_LeftmenuClassTblAccess;
$obj_leftmenu->conn=$obj_conn->conn;
$obj_leftmenu->jyoken["lm_type"]=4;
$obj_leftmenu->jyoken["lm_clid"]=$obj_login->clientdat[0]['cl_id'];
$obj_leftmenu->jyoken["lm_stat"]=1;
$obj_leftmenu->jyoken["lm_deldate"]=1;

$obj_leftmenu->leftmenudat=array();
list( $intCnt_leftmenu , $intTotal_leftmenu ) = $obj_leftmenu->basedb_GetLeftmenu ( 1 , -1 );

$obj_menu = new basedb_MenuClassTblAccess;
$obj_menu->conn = $obj_conn->conn;
$obj_menu->jyoken["mn_clid"]=$obj_login->clientdat[0]['cl_id'];
$obj_menu->jyoken["mn_lstat"]=1;
$obj_menu->jyoken["mn_deldate"]=1;
$obj_menu->sort["mn_ldispno"] = 1;

$obj_menu->menudat=array();
list( $intCnt_menu , $intTotal_menu ) = $obj_menu->basedb_GetMenu ( 1 , -1 );

$dispcnt="";
$dispcnt=count($obj_menu->menudat)-1;
if($dispcnt>=0){
	$leftmenu[$basicmenu_sortno]='
	<ul class="subnavi"><!--²èÌÌº¸¥á¥Ë¥å¡¼¥»¥Ã¥È start-->
	<li class="subnavititle">'.htmlspecialchars($obj_leftmenu->leftmenudat[0]['lm_title']).'</li>
	';

	foreach($obj_menu->menudat as $key=>$val){
		switch ($obj_menu->menudat[$key]['mn_flg']){
			case "1":
				if($key!=$dispcnt){
					$leftmenu[$basicmenu_sortno].='<li class="subnavimiddle"><a href="'._BLOG_SITE_URL_BASE.'school/">'.htmlspecialchars($obj_menu->menudat[$key]['mn_lname']).'</a></li>
					';
				}elseif($key==$dispcnt){
					$leftmenu[$basicmenu_sortno].='<li class="subnavibottom"><a href="'._BLOG_SITE_URL_BASE.'school/">'.htmlspecialchars($obj_menu->menudat[$key]['mn_lname']).'</a></li>
					';
				}
				break;
			case "2":
				if($key!=$dispcnt){
					$leftmenu[$basicmenu_sortno].='<li class="subnavimiddle"><a href="'._BLOG_SITE_URL_BASE.'qa/">'.htmlspecialchars($obj_menu->menudat[$key]['mn_lname']).'</a></li>
					';
				}elseif($key==$dispcnt){
					$leftmenu[$basicmenu_sortno].='<li class="subnavibottom"><a href="'._BLOG_SITE_URL_BASE.'qa/">'.htmlspecialchars($obj_menu->menudat[$key]['mn_lname']).'</a></li>
					';
				}
				break;
			case "3":
				if($key!=$dispcnt){
					$leftmenu[$basicmenu_sortno].='<li class="subnavimiddle"><a href="'._BLOG_SITE_URL_BASE.'flow/">'.htmlspecialchars($obj_menu->menudat[$key]['mn_lname']).'</a></li>
					';
				}elseif($key==$dispcnt){
					$leftmenu[$basicmenu_sortno].='<li class="subnavibottom"><a href="'._BLOG_SITE_URL_BASE.'flow/">'.htmlspecialchars($obj_menu->menudat[$key]['mn_lname']).'</a></li>
					';
				}
				break;
				
			case "4":
				if($key!=$dispcnt){
					$leftmenu[$basicmenu_sortno].='<li class="subnavimiddle"><a href="javascript:void(0)" onclick="document.inquire.submit(); return false">'.htmlspecialchars($obj_menu->menudat[$key]['mn_lname']).'</a></li>
					';
				}elseif($key==$dispcnt){
					$leftmenu[$basicmenu_sortno].='<li class="subnavibottom"><a href="javascript:void(0)" onclick="document.inquire.submit(); return false">'.htmlspecialchars($obj_menu->menudat[$key]['mn_lname']).'</a></li>
					';
				}
				break;
		}
	}
	$leftmenu[$basicmenu_sortno].='</ul><!--²èÌÌº¸¥á¥Ë¥å¡¼¥»¥Ã¥È end-->
	';
}
//¢¥¢¥¢¥¢¥¢¥¢¥¢¥¢¥¢¥¢¥´ðËÜ¥á¥Ë¥å¡¼HTMLºîÀ®¢¥¢¥¢¥¢¥¢¥¢¥¢¥¢¥¢¥¢¥

//¢§¢§¢§¢§¢§¢§¢§¢§¢§¢§¥Ö¥í¥°¥á¥Ë¥å¡¼HTMLºîÀ®¢§¢§¢§¢§¢§¢§¢§¢§¢§¢§
$blogmenu_sortno=$obj_login->clientdat[0]['sc_layout3'];//¤ªÃÎ¤é¤»¥«¥Æ¥´¥ê¥á¥Ë¥å¡¼¤ÎÉ½¼¨°ÌÃÖ(1¡Á4)
$obj_leftmenu->jyoken=array();
$obj_leftmenu->jyoken["lm_type"]=3;
$obj_leftmenu->jyoken["lm_clid"]=$obj_login->clientdat[0]['cl_id'];
$obj_leftmenu->jyoken["lm_stat"]=1;
$obj_leftmenu->jyoken["lm_deldate"]=1;

$obj_leftmenu->leftmenudat=array();
list( $intCnt_leftmenu , $intTotal_leftmenu ) = $obj_leftmenu->basedb_GetLeftmenu ( 1 , -1 );


$obj_category = new basedb_CategoryClassTblAccess;
$obj_category->conn = $obj_conn->conn;
$obj_category->jyoken["cg_clid"]=$obj_login->clientdat[0]['cl_id'];
$obj_category->jyoken["cg_stat"]=1;
$obj_category->jyoken["cg_type"]=5;
$obj_category->jyoken["cg_deldate"]=1;
$obj_category->jyoken["cg_lmid"]=$obj_leftmenu->leftmenudat[0]['lm_id'];
$obj_category->sort["cg_dispno"] = 2;

$obj_category->categorydat=array();
list( $intCnt_category , $intTotal_category ) = $obj_category->basedb_GetCategory ( 1 , -1 );

$dispcnt="";
$dispcnt=count($obj_category->categorydat)-1;
$diary_finding="";
$diary_finding=htmlspecialchars($obj_leftmenu->leftmenudat[0]['lm_title']);
$blog_stitle=array();
if($dispcnt>=0){
	$leftmenu[$blogmenu_sortno]='
	<ul class="subnavi"><!--²èÌÌº¸¥á¥Ë¥å¡¼¥»¥Ã¥È start-->
	<li class="subnavititle">'.htmlspecialchars($obj_leftmenu->leftmenudat[0]['lm_title']).'</li>
	';
	foreach($obj_category->categorydat as $key=>$val){
		$blog_stitle[]=$obj_category->categorydat[$key]['cg_stitle'];
		if($key!=$dispcnt){
			if($obj_category->categorydat[$key]['cg_yobi1'] == 1){
				$target = "_self";
				if($obj_category->categorydat[$key]['cg_yobi3'] == 2){
					$target = "_blank";
				}
				$leftmenu[$blogmenu_sortno].='<li class="subnavimiddle"><a href="'.htmlspecialchars($obj_category->categorydat[$key]['cg_yobi2']).'" target="'.$target.'">'.htmlspecialchars($obj_category->categorydat[$key]['cg_stitle']).'</a></li>' . "\n";
			}else{
				$leftmenu[$blogmenu_sortno].='<li class="subnavimiddle"><a href="'._BLOG_SITE_URL_BASE.'diary-list/p-0/dr-'.$obj_category->categorydat[$key]['cg_id'].'/">'.htmlspecialchars($obj_category->categorydat[$key]['cg_stitle']).'</a></li>' . "\n";
			}
		}elseif($key==$dispcnt){
			if($obj_category->categorydat[$key]['cg_yobi1'] == 1){
				$target = "_self";
				if($obj_category->categorydat[$key]['cg_yobi3'] == 2){
					$target = "_blank";
				}
				$leftmenu[$blogmenu_sortno].='<li class="subnavibottom"><a href="'.htmlspecialchars($obj_category->categorydat[$key]['cg_yobi2']).'" target="'.$target.'">'.htmlspecialchars($obj_category->categorydat[$key]['cg_stitle']).'</a></li>' . "\n";
			}else{
				$leftmenu[$blogmenu_sortno].='<li class="subnavibottom"><a href="'._BLOG_SITE_URL_BASE.'diary-list/p-0/dr-'.$obj_category->categorydat[$key]['cg_id'].'/">'.htmlspecialchars($obj_category->categorydat[$key]['cg_stitle']).'</a></li>' . "\n";
			}
		}
	}
	$leftmenu[$blogmenu_sortno].='</ul><!--²èÌÌº¸¥á¥Ë¥å¡¼¥»¥Ã¥È end-->
	';
}
//¢¥¢¥¢¥¢¥¢¥¢¥¢¥¢¥¢¥¢¥¥Ö¥í¥°¥á¥Ë¥å¡¼HTMLºîÀ®¢¥¢¥¢¥¢¥¢¥¢¥¢¥¢¥¢¥¢¥

//¢§¢§¢§¢§¢§¢§¢§¢§¢§¢§¥­¥ã¥ó¥Ú¡¼¥ó¥á¥Ë¥å¡¼HTMLºîÀ®¢§¢§¢§¢§¢§¢§¢§¢§¢§¢§
$campaignmenu_sortno=$obj_login->clientdat[0]['sc_layout2'];//¤ªÃÎ¤é¤»¥«¥Æ¥´¥ê¥á¥Ë¥å¡¼¤ÎÉ½¼¨°ÌÃÖ(1¡Á4)
$obj_leftmenu->jyoken=array();
$obj_leftmenu->jyoken["lm_type"]=2;
$obj_leftmenu->jyoken["lm_clid"]=$obj_login->clientdat[0]['cl_id'];
$obj_leftmenu->jyoken["lm_stat"]=1;
$obj_leftmenu->jyoken["lm_deldate"]=1;

$obj_leftmenu->leftmenudat=array();
list( $intCnt_leftmenu , $intTotal_leftmenu ) = $obj_leftmenu->basedb_GetLeftmenu ( 1 , -1 );

$obj_category->jyoken=array();
$obj_category->jyoken["cg_clid"]=$obj_login->clientdat[0]['cl_id'];
$obj_category->jyoken["cg_stat"]=1;
$obj_category->jyoken["cg_type"]=6;
$obj_category->jyoken["cg_deldate"]=1;
$obj_category->jyoken["cg_lmid"]=$obj_leftmenu->leftmenudat[0]['lm_id'];
$obj_category->sort["cg_dispno"] = 2;

$obj_category->categorydat=array();
list( $intCnt_category , $intTotal_category ) = $obj_category->basedb_GetCategory ( 1 , -1 );

$dispcnt="";
$dispcnt=count($obj_category->categorydat)-1;
$campaign_finding="";
$campaign_finding=htmlspecialchars($obj_leftmenu->leftmenudat[0]['lm_title']);
if($dispcnt>=0){
	$leftmenu[$campaignmenu_sortno]='
	<ul class="subnavi"><!--²èÌÌº¸¥á¥Ë¥å¡¼¥»¥Ã¥È start-->
	<li class="subnavititle">'.htmlspecialchars($obj_leftmenu->leftmenudat[0]['lm_title']).'</li>
	';
	foreach($obj_category->categorydat as $key=>$val){
		if($key!=$dispcnt){
			if($obj_category->categorydat[$key]['cg_yobi1'] == 1){
				$target = "_self";
				if($obj_category->categorydat[$key]['cg_yobi3'] == 2){
					$target = "_blank";
				}
				$leftmenu[$campaignmenu_sortno].='<li class="subnavimiddle"><a href="'.htmlspecialchars($obj_category->categorydat[$key]['cg_yobi2']).'" target="'.$target.'">'.htmlspecialchars($obj_category->categorydat[$key]['cg_stitle']).'</a></li>' . "\n";
			}else{
				$leftmenu[$campaignmenu_sortno].='<li class="subnavimiddle"><a href="'._BLOG_SITE_URL_BASE.'campain-list/p-0/cp-'.$obj_category->categorydat[$key]['cg_id'].'/">'.htmlspecialchars($obj_category->categorydat[$key]['cg_stitle']).'</a></li>' . "\n";
			}
		}elseif($key==$dispcnt){
			if($obj_category->categorydat[$key]['cg_yobi1'] == 1){
				$target = "_self";
				if($obj_category->categorydat[$key]['cg_yobi3'] == 2){
					$target = "_blank";
				}
				$leftmenu[$campaignmenu_sortno].='<li class="subnavibottom"><a href="'.htmlspecialchars($obj_category->categorydat[$key]['cg_yobi2']).'" target="'.$target.'">'.htmlspecialchars($obj_category->categorydat[$key]['cg_stitle']).'</a></li>' . "\n";
			}else{
				$leftmenu[$campaignmenu_sortno].='<li class="subnavibottom"><a href="'._BLOG_SITE_URL_BASE.'campain-list/p-0/cp-'.$obj_category->categorydat[$key]['cg_id'].'/">'.htmlspecialchars($obj_category->categorydat[$key]['cg_stitle']).'</a></li>' . "\n";
			}
		}
	}
	$leftmenu[$campaignmenu_sortno].='</ul><!--²èÌÌº¸¥á¥Ë¥å¡¼¥»¥Ã¥È end-->
	';
}
//¢¥¢¥¢¥¢¥¢¥¢¥¢¥¢¥¢¥¢¥¥­¥ã¥ó¥Ú¡¼¥ó¥á¥Ë¥å¡¼HTMLºîÀ®¢¥¢¥¢¥¢¥¢¥¢¥¢¥¢¥¢¥¢¥

//¢§¢§¢§¢§¢§¢§¢§¢§¢§¢§¥³¡¼¥¹¥«¥Æ¥´¥êHTMLºîÀ®¢§¢§¢§¢§¢§¢§¢§¢§¢§¢§
$coursenmenu_sortno=$obj_login->clientdat[0]['sc_layout1'];//¤ªÃÎ¤é¤»¥«¥Æ¥´¥ê¥á¥Ë¥å¡¼¤ÎÉ½¼¨°ÌÃÖ(1¡Á4)
$obj_leftmenu->jyoken=array();
$obj_leftmenu->jyoken["lm_type"]=1;
$obj_leftmenu->jyoken["lm_clid"]=$obj_login->clientdat[0]['cl_id'];
$obj_leftmenu->jyoken["lm_stat"]=1;
$obj_leftmenu->jyoken["lm_deldate"]=1;
$obj_leftmenu->sort["lm_dispno"]=2;

$obj_leftmenu->leftmenudat=array();
list( $intCnt_leftmenu , $intTotal_leftmenu ) = $obj_leftmenu->basedb_GetLeftmenu ( 1 , -1 );

$course_category_cnt="";
$course_category_cnt=count($obj_leftmenu->leftmenudat)-1;

for($cnt=0;$cnt<=$course_category_cnt;$cnt++){
	
	$obj_category->jyoken=array();
	$obj_category->jyoken["cg_clid"]=$obj_login->clientdat[0]['cl_id'];
	$obj_category->jyoken["cg_stat"]=1;
	$obj_category->jyoken["cg_type"]=3;
	$obj_category->jyoken["cg_deldate"]=1;
	$obj_category->jyoken["cg_lmid"]=$obj_leftmenu->leftmenudat[$cnt]['lm_id'];
	$obj_category->sort["cg_dispno"]=2;

	$obj_category->categorydat=array();
	list( $intCnt_category , $intTotal_category ) = $obj_category->basedb_GetCategory ( 1 , -1 );
	
	$dispcnt="";
	$dispcnt=count($obj_category->categorydat)-1;
	
	$course_finding=array();
	$course_finding[]=htmlspecialchars($obj_leftmenu->leftmenudat[$cnt]['lm_title']);
	
	if($dispcnt>=0){
		$leftmenu[$coursenmenu_sortno].='
		<ul class="subnavi"><!--²èÌÌº¸¥á¥Ë¥å¡¼¥»¥Ã¥È start-->
		<li class="subnavititle">'.htmlspecialchars($obj_leftmenu->leftmenudat[$cnt]['lm_title']).'</li>
		';
		foreach($obj_category->categorydat as $key=>$val){
			if($key!=$dispcnt){
				if($obj_category->categorydat[$key]['cg_yobi1'] == 1){
					$target = "_self";
					if($obj_category->categorydat[$key]['cg_yobi3'] == 2){
						$target = "_blank";
					}
					$leftmenu[$coursenmenu_sortno].='<li class="subnavimiddle"><a href="'.htmlspecialchars($obj_category->categorydat[$key]['cg_yobi2']).'" target="'.$target.'">'.htmlspecialchars($obj_category->categorydat[$key]['cg_stitle']).'</a></li>' . "\n";
				}else{
					$leftmenu[$coursenmenu_sortno].='<li class="subnavimiddle"><a href="'._BLOG_SITE_URL_BASE.'course-list/p-0/cs-'.$obj_category->categorydat[$key]['cg_id'].'/">'.htmlspecialchars($obj_category->categorydat[$key]['cg_stitle']).'</a></li>' . "\n";
				}
			}elseif($key==$dispcnt){
				if($obj_category->categorydat[$key]['cg_yobi1'] == 1){
					$target = "_self";
					if($obj_category->categorydat[$key]['cg_yobi3'] == 2){
						$target = "_blank";
					}
					$leftmenu[$coursenmenu_sortno].='<li class="subnavibottom"><a href="'.htmlspecialchars($obj_category->categorydat[$key]['cg_yobi2']).'" target="'.$target.'">'.htmlspecialchars($obj_category->categorydat[$key]['cg_stitle']).'</a></li>' . "\n";
				}else{
					$leftmenu[$coursenmenu_sortno].='<li class="subnavibottom"><a href="'._BLOG_SITE_URL_BASE.'course-list/p-0/cs-'.$obj_category->categorydat[$key]['cg_id'].'/">'.htmlspecialchars($obj_category->categorydat[$key]['cg_stitle']).'</a></li>' . "\n";
				}
			}
		}
		$leftmenu[$coursenmenu_sortno].='</ul><!--²èÌÌº¸¥á¥Ë¥å¡¼¥»¥Ã¥È end-->
';
	}
}

//¢¥¢¥¢¥¢¥¢¥¢¥¢¥¢¥¢¥¢¥¥³¡¼¥¹¥«¥Æ¥´¥êHTMLºîÀ®¢¥¢¥¢¥¢¥¢¥¢¥¢¥¢¥¢¥¢¥


$free_html=html_replace($obj_login->clientdat[0]['sc_lhtml']);
$free_html=htmlspecialchars($free_html);
$free_html=htmlspecialchars_decode($free_html);
$free_html_list='
<div class="subnavi"><!--²èÌÌº¸¥á¥Ë¥å¡¼¥»¥Ã¥È start-->

	<div class="freespace"><!--freespace start-->
		'.nl2br($free_html).'
	</div><!--freespace end-->

</div><!--²èÌÌº¸¥á¥Ë¥å¡¼¥»¥Ã¥È end-->
';

if(count($leftmenu)){
	$leftmenu_list="";
	ksort($leftmenu);
	foreach($leftmenu as $key=>$val){
		$leftmenu_list.=$val;
	}
}

?>
