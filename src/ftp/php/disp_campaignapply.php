<?

if(!isset($_POST['title'])){
	require_once( SYS_PATH."templates/error_all.tpl" );
	exit;
}

foreach($_POST as $key=>$val){
	$hidden.='<input type="hidden" name="'.$key.'" value="'.$val.'" />
	';
}
$obj_campaign= new basedb_CampainClassTblAccess;
$obj_campaign->conn = $obj_conn->conn;
$obj_campaign->jyoken=array();
$obj_campaign->jyoken["cp_clid"]=$obj_login->clientdat[0]['cl_id'];
$obj_campaign->jyoken["cp_stat"]=1;
$obj_campaign->jyoken["cp_id"]=$_POST['cpid'];
$obj_campaign->jyoken["cp_deldate"]=1;

$obj_campaign->campaindat=array();
list( $intCnt_campaign , $intTotal_campaign ) = $obj_campaign->basedb_GetCampain ( 1 , -1 );

if($obj_campaign->campaindat[0]['cp_img1']){
	$img_path='
<td class="nopadding">
	<p class="marginr1">
		<img src="./img_thumbnail.php?w=145&h=91&dir='.$param_cp_img1_path.'&nm='.$obj_campaign->campaindat[0]['cp_img1'].'" alt="" />
	</p>
</td>
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


$campaign_list='
					<div class="boxlittlemargin"><!--box start-->
						<h4 class="white">'.$obj_campaign->campaindat[0]['cp_title'].'</h4>
						<table>
							<tr>
								'.$img_path.'
								<td class="td3b nopadding">
								
									<table>
										<tr>
											<td class="center middle bggray">
												<p><em>対　象</em></p>
											</td>
											<td class="paddinglr1 bordergraydotted">
												<p>'.$age_icon_list.'</p>
											</td>
										</tr>
										<tr>
											<td class="center middle bggray">
												<p><em>実施日時・期間</em></p>
											</td>
											<td class="paddinglr1 bordergraydotted">
												<p>'.$publishing_period.'</p>
												<p></p>
											</td>
										</tr>
									</table>
						               
								</td>
							</tr>
						</table>
					</div><!--boxlittle end-->
';
?>
