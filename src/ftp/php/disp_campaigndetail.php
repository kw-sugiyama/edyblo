<?
if($_GET['cpid']){
	$cpid=$_GET['cpid'];
}else{
	$cpid="error";
}

$timestamp='(timestamp \''.date("Y").'-'.date("m").'-'.date("d").' 00:00:00\')';

$obj_campaign= new basedb_CampainClassTblAccess;
$obj_campaign->conn = $obj_conn->conn;
$obj_campaign->jyoken=array();
$obj_campaign->jyoken["cp_clid"]=$obj_login->clientdat[0]['cl_id'];
$obj_campaign->jyoken["cp_stat"]=1;
$obj_campaign->jyoken["cp_id"]=$cpid;
$obj_campaign->jyoken["cp_deldate"]=1;
$obj_campaign->jyoken["cp_publishstart"]=$timestamp;
$obj_campaign->jyoken["cp_publishend"]=$timestamp;

$obj_campaign->campaindat=array();
list( $intCnt_campaign , $intTotal_campaign ) = $obj_campaign->basedb_GetCampain ( 1 , -1 );

if($intTotal_campaign==0){
	require_once( SYS_PATH."templates/error_all.tpl" );
	exit;
}

$obj_category1 = new basedb_CategoryClassTblAccess;
$obj_category1->conn = $obj_conn->conn;
$obj_category1->jyoken=array();
$obj_category1->jyoken["cg_clid"]=$obj_login->clientdat[0]['cl_id'];
$obj_category1->jyoken["cg_stat"]=1;
$obj_category1->jyoken["cg_id"]=$obj_campaign->campaindat[0]['cp_cgid'];
$obj_category1->jyoken["cg_deldate"]=1;

$obj_category1->categorydat=array();
list( $intCnt_category1 , $intTotal_category1 ) = $obj_category1->basedb_GetCategory ( 1 , -1 );

$obj_teacher = new basedb_TeacherClassTblAccess;
$obj_teacher->conn = $obj_conn->conn;
$obj_teacher->jyoken=array();
$obj_teacher->jyoken["tc_id"]=$obj_campaign->campaindat[0]['cp_tcid'];
$obj_teacher->jyoken["tc_deldate"]=1;
$obj_teacher->teacherdatz=array();
$tc_box="";
$img_path="";
if($obj_campaign->campaindat[0]['cp_tcid']){
	list( $intCnt_teacher , $intTotal_teacher ) = $obj_teacher->basedb_GetTeacher ( 1 , -1 );
	
	if($obj_teacher->teacherdat[0]['tc_img']){
		$img_path='<img src="./img_thumbnail.php?w=84&h=100&dir='.$param_tc_img_path.'&nm='.$obj_teacher->teacherdat[0]['tc_img'].'" alt="" />';
	}
	if($obj_teacher->teacherdat[0]['tc_comment']){
		$tc_comment=htmlspecialchars($obj_campaign->campaindat[0]['cp_tccomment']);
		$tc_comment=html_replace($tc_comment);
	}
	$tc_comment='
				<td class="td1b nopadding">
					<div id="boxbloger_middle">
					<div id="boxbloger_top">
						<table id="boxbloger">
								<tbody>
								<tr>
									<td class="bgwhite bordergraydotted paddinglr1">
										<p><em>コメント・メッセージ</em></p>
									</td>
								</tr>
								<tr>
									<td class="bgwhite paddinglr1">
										<p>'.nl2br($tc_comment).'</p>
									</td>
								</tr>
							</tbody></table>
						<div id="boxbloger_bottom"></div>
					</div>
													</div>
			</td>

';	
	$tc_box='
	<div class="box"><!--box start-->
		<table>
			<tr>
				<td class="td1a nopadding">
					<p class="marginbr1 center">'.$img_path.'</p>
					<p class="marginr1 center">'.htmlspecialchars($obj_teacher->teacherdat[0]['tc_name']).'</p>
				</td>
				'.$tc_comment.'
			</tr>
		</table>
	</div><!--box end-->
';
}
$campaign_list="";
$img_path="";

if($obj_campaign->campaindat[0]['cp_img1']){
	$img_path='<td class="nopadding">
<p class="marginr1"><a href="'.$param_cp_img1_path.$obj_campaign->campaindat[0]['cp_img1'].'" class="highslide" onclick="return hs.expand(this)" onkeypress="return hs.expand(this)"><img src="./img_thumbnail.php?w=160&h=120&dir='.$param_cp_img1_path.'&nm='.$obj_campaign->campaindat[0]['cp_img1'].'" alt="" /></a></p></td>
';
}else{
$img_path='';
}

$age_of=$obj_campaign->campaindat[0]['cp_age'];
$age_check=array();
$age_icon=array();
$age_check_list="";
$age_icon_list="";
if(($age_of & 64)==64){
	$age_check[7]='<span class="marginlr2">社会人　</span>';
	$age_icon[7]='<img src="./share/icons/item_syakaijin_5.gif" alt="" />';
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
$age_check_list.="</p>";
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

$start_year="";
$start_month="";
$start_day="";
$start_date="";
$end_year="";
$end_month="";
$end_day="";
$end_date="";
$publishing_period="";

if($obj_campaign->campaindat[0]['cp_camstart'] || $obj_campaign->campaindat[0]['cp_camend']){
	$start_year=substr($obj_campaign->campaindat[0]['cp_camstart'],0,4);
	$start_month=substr($obj_campaign->campaindat[0]['cp_camstart'],5,2);
	$start_day=substr($obj_campaign->campaindat[0]['cp_camstart'],8,2);
	$start_date=$start_year.'年'.$start_month.'月'.$start_day.'日';
	$end_year=substr($obj_campaign->campaindat[0]['cp_camend'],0,4);
	$end_month=substr($obj_campaign->campaindat[0]['cp_camend'],5,2);
	$end_day=substr($obj_campaign->campaindat[0]['cp_camend'],8,2);
	$end_date=$end_year.'年'.$end_month.'月'.$end_day.'日';
		
            //日付が一緒なら 単一表示 hatori
            if($start_date == $end_date)
            {
                $publishing_period=ltrim($start_date,"0");
            }else{
                $publishing_period=ltrim($start_date,"0")." 〜 ".ltrim($end_date,"0");
            }




}else{
	$publishing_period="−";
}

$cp_contents=$obj_campaign->campaindat[0]['cp_contents'];

$campaign_list='
<div class="boxlittle"><!--box start-->
	<table  class="tableforh4noback">
		<tr>
			<td class="nopadding">            
				<h3><span class="white">'.htmlspecialchars($obj_campaign->campaindat[0]['cp_title']).'</span></h3>
			</td>
		</tr>
	</table>
	<table>
		<tr>
'.$img_path.'
				<td class="td3b nopadding">
				<table>
					<tr>
						<td>
							<p>'.nl2br($cp_contents).'</p>
						</td>
					</tr>
				</table>
			</td>
		</tr>
	</table>
	<table class="margint2">
		<tr>
			<td class="td1a center middle bggray">
				<p><em>対　象</em></p>
			</td>
			<td class="td1b paddinglr1 bordergraydotted">
				<p>'.$age_icon_list.'</p>
			</td>
		</tr>
		<tr>
			<td class="td1a center middle bggray">
				<p><em>実施日</em></p>
			</td>
			<td class="td1b paddinglr1 bordergraydotted">
				<p>'.$publishing_period.'</p>
			</td>
		</tr>
	</table>
</div><!--box end-->
';

$obj_category= new basedb_CategoryClassTblAccess;
$obj_category->conn = $obj_conn->conn;
$obj_category->jyoken=array();
$obj_category->jyoken["cg_clid"]=$obj_campaign->campaindat[0]['cp_id'];
$obj_category->jyoken["cg_stat"]=1;
$obj_category->jyoken["cg_type"]=8;
$obj_category->jyoken["cg_deldate"] = 1;
$obj_category->sort["cg_dispno"]=2;
$obj_category->categorydat=array();
list( $intCnt_category , $intTotal_category ) = $obj_category->basedb_GetCategory ( 1 , -1 );

$dispcnt="";
$dispcnt=count($obj_category->categorydat)-1;
if($dispcnt>=0){
	foreach($obj_category->categorydat as $key1=>$val1){
		
		$obj_camarticle = new basedb_CamarticleClassTblAccess;
		$obj_camarticle->conn = $obj_conn->conn;
		$obj_camarticle->jyoken=array();
		$obj_camarticle->jyoken["ca_cpid"]=$obj_category->categorydat[$key1]['cg_id'];
		$obj_camarticle->jyoken["ca_stat"]=1;
		$obj_camarticle->jyoken["ca_deldate"]=1;
		$obj_camarticle->sort["ca_dispno"] = 1;
		$obj_camarticle->camarticledat=array();
		list( $intCnt_camarticle , $intTotal_camarticle ) = $obj_camarticle->basedb_GetCamarticle ( 1 , -1 );
		
		$dispcnt="";
		$dispcnt=count($obj_camarticle->camarticledat)-1;
		if($dispcnt>=0){
			foreach($obj_camarticle->camarticledat as $key2=>$va2){
					
				if($key2==0){
				$campaign_list.='
<div class="boxlittle"><!--box start-->
	<h4><span class="white">'.htmlspecialchars($obj_category->categorydat[$key1]['cg_stitle']).'</span></h4>
';
				}
				
				$ca_contents=$obj_camarticle->camarticledat[$key2]['ca_contents'];
				
				if($obj_camarticle->camarticledat[$key2]['ca_img']){
					$img_path='
<td class="nopadding">
	<p class="marginr1">
			<a href="'.$param_camarticle_img_path.$obj_camarticle->camarticledat[$key2]['ca_img'].'" class="highslide" onclick="return hs.expand(this)" onkeypress="return hs.expand(this)"><img src="./img_thumbnail.php?w=150&h=120&dir='.$param_camarticle_img_path.'&nm='.$obj_camarticle->camarticledat[$key2]['ca_img'].'" alt="" /></a>
	</p>
</td>';
				}else{
$img_path='
<td class="nopadding">
<p class="marginr1">
</p>
</td>
';
				}
						
				if($obj_camarticle->camarticledat[$key2]['ca_img']){
					$campaign_list.='
								<table class="margint2">
									<tr>
										'.$img_path.'
										<td class="td3b nopadding">
											<table>
												<tr>
													<td class="borderblue">
														<p><span class="blue2"><em>'.htmlspecialchars($obj_camarticle->camarticledat[$key2]['ca_title']).'</em></span></p>
													</td>
												</tr>
												<tr>
													<td>
														<div style="color:#333333;font-family:\'ＭＳ Ｐゴシック\',Osaka;font-size:12px;font-style:normal;font-weight:normal;line-height:1.5;";>'.nl2br($ca_contents).'</div>
													</td>
												</tr>
											</table>
										</td>
									</tr>
								</table>
';
				}else{
							$campaign_list.='					                  
								<table>
									<tr>
										<td class="borderblue">
											<p><span class="blue2"><em>'.htmlspecialchars($obj_camarticle->camarticledat[$key2]['ca_title']).'</em></span></p>
										</td>
									</tr>
									<tr>
										<td>
											<div style="color:#333333;font-family:\'ＭＳ Ｐゴシック\',Osaka;font-size:12px;font-style:normal;font-weight:normal;line-height:1.5;";>'.nl2br($ca_contents).'</div>
										</td>
									</tr>
								</table>
';
				}
			}
		$campaign_list.='</div><!--boxlittle end-->';
		}else{
			$campaign_list.='
<div class="boxlittle"><!--box start-->
	<h4><span class="white">'.htmlspecialchars($obj_category->categorydat[$key1]['cg_stitle']).'</span></h4>
</div><!--boxlittle end-->';
		}
	}
}

// メール内に記載する詳細ページURL 
$url="";
//$url=_BLOG_SITE_URL_BASE.'campaign-detail-'.$cpid.'/';
if( $obj_login->clientdat[0]["cl_dokuji_flg"] == 1 && $obj_login->clientdat[0]["cl_dokuji_domain"] != "" ) {
	// 独自ドメインの場合
	$url=$obj_login->clientdat[0]["cl_dokuji_domain"].'campaign-detail-'.$cpid.'/';
} else {
	$url=$param_base_blog_addr_url.'/campaign-detail-'.$cpid.'/';
}

