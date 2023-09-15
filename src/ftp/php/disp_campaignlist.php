<?

if($_GET['cpid']){
	$cpid=$_GET['cpid'];
}else{
	$cpid="0";
}
if($_GET['page']){
	$page=$_GET['page'];
}else{
	$page="0";
}

$obj_category->jyoken=array();
$obj_category->jyoken["cg_clid"]=$obj_login->clientdat[0]['cl_id'];
$obj_category->jyoken["cg_stat"]=1;
$obj_category->jyoken["cg_id"]=$cpid;
$obj_category->jyoken["cg_type"]=6;
$obj_category->jyoken["cg_deldate"]=1;
$obj_category->sort["cg_dispno"] = 2;

$obj_category->categorydat=array();
list( $intCnt_category , $intTotal_category ) = $obj_category->basedb_GetCategory ( 1 , -1 );

$start=$page*5 + 1;
$end=$start+4;
// 1ページあたり表示件数 ページ遷移バグ修正 2009/12/02 大塚
$get_cnt = 5;

$timestamp='(timestamp \''.date("Y").'-'.date("m").'-'.date("d").' 00:00:00\')';

$obj_campaign = new basedb_CampainClassTblAccess;
$obj_campaign->conn = $obj_conn->conn;
$obj_campaign->jyoken["cp_clid"]=$obj_login->clientdat[0]['cl_id'];
$obj_campaign->jyoken["cp_stat"]=1;
$obj_campaign->jyoken["cp_cgid"]=$cpid;
$obj_campaign->jyoken["cp_deldate"]=1;
$obj_campaign->jyoken["cp_publishstart"]=$timestamp;
$obj_campaign->jyoken["cp_publishend"]=$timestamp;
$obj_campaign->sort["cp_upddate"] = 2;

$obj_campaign->campaindat=array();
// ページ遷移バグ修正 2009/12/02 大塚	list( $intCnt_campaign , $intTotal_campaign ) = $obj_campaign->basedb_GetCampain ( $start , $end );
list( $intCnt_campaign , $intTotal_campaign ) = $obj_campaign->basedb_GetCampain ( $start , $get_cnt );

if($intTotal_campaign>0){
	if($start==($start+$intCnt_campaign-1)){
		$case_number=$intTotal_campaign.' 件中 '.$start." 件目を表示";
	}else{
		$case_number=$intTotal_campaign.' 件中 '.$start.' 〜 '.($start+$intCnt_campaign-1)." 件目を表示";
	}
}else{
	$case_number="";
}

$pagemax="";
$pagedown="";
$pageup="";
if($page>=1){
	$pagedown='<p class="search"><a href="'._BLOG_SITE_URL_BASE.'campain-list/p-'.($page-1).'/cp-'.$cpid.'/">前の5件を表示</a></p>';
}
if(($intTotal_campaign/5)-($page+1)>0){
	$pageup='<p class="search"><a href="'._BLOG_SITE_URL_BASE.'campain-list/p-'.($page+1).'/cp-'.$cpid.'/">次の5件を表示</a></p>';
}

$dispcnt="";
$dispcnt=count($obj_campaign->campaindat)-1;
if($dispcnt>=0){
	foreach($obj_campaign->campaindat as $key1=>$val1){
		if($obj_campaign->campaindat[$key1]['cp_img1']){
			 $img_path='
			<td class="nopadding">
				  <p class="marginr1"><img src="./img_thumbnail.php?w=160&h=115&dir='.$param_cp_img1_path.'&nm='.$obj_campaign->campaindat[$key1]['cp_img1'].'" alt="" /></p>
			</td>';
			
			$cp_contents="";
			$cp_contents=$obj_campaign->campaindat[$key1]['cp_contents'];
			$cp_contents=strip_tags($cp_contents);
			$cp_contents=mb_substr($cp_contents,0,112,"EUC-JP").'．．．<a href="'._BLOG_SITE_URL_BASE.'campaign-detail-'.$obj_campaign->campaindat[$key1]['cp_id'].'/">（詳細はこちら）</a>';
		}else{
			$img_path='';
			
			$cp_contents="";
			$cp_contents=$obj_campaign->campaindat[$key1]['cp_contents'];
			$cp_contents=strip_tags($cp_contents);
			$cp_contents=mb_substr($cp_contents,0,168,"EUC-JP").'．．．<a href="'._BLOG_SITE_URL_BASE.'campaign-detail-'.$obj_campaign->campaindat[$key1]['cp_id'].'/">（詳細はこちら）</a>';
		}
		
		$age_of=$obj_campaign->campaindat[$key1]['cp_age'];
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
		
		//キャンペーン実施期間の計算
		if($obj_campaign->campaindat[$key1]['cp_camstart'] || $obj_campaign->campaindat[$key1]['cp_camend']){
			$start_year=substr($obj_campaign->campaindat[$key1]['cp_camstart'],0,4);
			$start_month=substr($obj_campaign->campaindat[$key1]['cp_camstart'],5,2);
			$start_day=substr($obj_campaign->campaindat[$key1]['cp_camstart'],8,2);
			$start_date=$start_year.'年'.$start_month.'月'.$start_day.'日';
			$end_year=substr($obj_campaign->campaindat[$key1]['cp_camend'],0,4);
			$end_month=substr($obj_campaign->campaindat[$key1]['cp_camend'],5,2);
			$end_day=substr($obj_campaign->campaindat[$key1]['cp_camend'],8,2);
			$end_date=$end_year.'年'.$end_month.'月'.$end_day.'日';

            //日付が一緒なら 単一表示 hatori
            if($start_date == $end_date)
            {
                $publishing_period=$start_date; 
            }else{
                $publishing_period=$start_date." 〜 ".$end_date;
            }

		}else{
			$publishing_period="−";
		}
		
		if($key1==0){
			$campaign_list.='
<div class="box"><!--box start-->
	<h3><span class="white">'.$obj_category->categorydat[0]['cg_stitle'].'</span></h3>
</div><!--box end-->

<div class="box"><!--box start-->
	<table>
		<tr>
			<td><p class="search">'.$case_number.'</p></td>
		</tr>
	</table>
	<table>
		<tr>
			<td class="left">　'.$pagedown.'　</td>
			<td class="right">　'.$pageup.'　</td>
		</tr>
	</table>
</div><!--box end-->
';
		}
	
		$campaign_list.='
<div class="boxlittle"><!--box start-->
	<table class="tableforh4noback">
		<tr>
			<td class="nopadding">            
				<h4 class="h4noback white"><a href="'._BLOG_SITE_URL_BASE.'campaign-detail-'.$obj_campaign->campaindat[$key1]['cp_id'].'/">'.htmlspecialchars($obj_campaign->campaindat[$key1]['cp_title']).'</a></h4>
			</td>
			<td class="right paddingt2"> 
				<span class="small white paddingr1"><em><a href="'._BLOG_SITE_URL_BASE.'campaign-detail-'.$obj_campaign->campaindat[$key1]['cp_id'].'/">詳細</a></em></span>
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
							<p>'.$cp_contents.'</p>
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

<p class="detail margint2"><a href="'._BLOG_SITE_URL_BASE.'campaign-detail-'.$obj_campaign->campaindat[$key1]['cp_id'].'/">　　 </a></p><br class="clear" />
</div><!--box end-->
';
	}
}
$campaign_list.='
<div class="box"><!--box start-->
	<table>
		<tr>
			<td><p class="search">'.$case_number.'</p></td>
		</tr>
	</table>
	<table>
		<tr>
			<td class="left">　'.$pagedown.'　</td>
			<td class="right">　'.$pageup.'　</td>
		</tr>
	</table>
</div><!--box end-->';
?>
