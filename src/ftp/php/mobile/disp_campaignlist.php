<?
//=====================================================================
//campaignlist で使う変数
//case_numbera
//campaign_list
//strViewPageMove_list
//strViewPageMove_before
//strViewPageMove_after
//=====================================================================

//=====================================================================
//関数追加(htmltag除去 変換)
require"taglist.php";
function strip_between_tag( $str, $tag=array() ) {
foreach( $tag as $val){
$pattern = "/<{$val}.*?>.*?<\/{$val}>/ims";
$str = preg_replace( $pattern , '[ 携帯表示不可 ]', $str);
}
return $str;
}
//=====================================================================


if($_GET['cpid']){
		  $cpid=$_GET['cpid'];
}else{
		  $cpid="0";
}
if($_GET['page']){
		  $page=$_GET['page']-1;
}else{
		  $page="0";
}
$obj_category->jyoken=array();
$obj_category->jyoken["cg_clid"]   = $obj_login->clientdat[0]['cl_id'];
$obj_category->jyoken["cg_stat"]   = 1;
$obj_category->jyoken["cg_id"]     = $cpid;
$obj_category->jyoken["cg_type"]   = 6;
$obj_category->jyoken["cg_deldate"]= 1;
$obj_category->sort["cg_dispno"]   = 2;

$obj_category->categorydat=array();
//何件目から 何件目まで拾ってくる
list( $intCnt_category , $intTotal_category ) = $obj_category->basedb_GetCategory ( 1 , -1 );

$start=$page * 10;
$start=$start+1;
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
list( $intCnt_campaign , $intTotal_campaign ) = $obj_campaign->basedb_GetCampain ( $start , 10 );
$intTotal_campaign2 = ($intTotal_campaign / 10);
$intTotal_campaign2 = ceil($intTotal_campaign2);
$intTotal_campaign2 = $intTotal_campaign2-2;

$pagemax=$intTotal_campaign;
$pagedown="";
$pageup="";
$pagea = $start+$intCnt_campaign;

if($pagea > $intTotal_campaign){

		  $start1 =$start;
		  $case_numbera='(	  
					 '.$start1.' 〜 
					 '.($intTotal_campaign)." 件／全
					 $intTotal_campaign 件)
					 <br />
					 ";


}else{

		  $start1 =$start;
		  //    $case_number=$intTotal_campaign.' 件 '.$start.' 〜 '.($start+$intCnt_campaign-1)." 件目を表示";
		  $case_numbera='(	  
					 '.$start1.' 〜 
					 '.($start+$intCnt_campaign-1)." 件／全
					 $intTotal_campaign 件)
					 <br />
					 ";
}


if($dispcnt>=0){
		  foreach($obj_campaign->campaindat as $key1=>$val1){
					 if($obj_campaign->campaindat[$key1]['cp_img1']){
								$img_path='';
								$cp_contents = "";
								$cp_contents = strip_between_tag($obj_campaign->campaindat[$key1]['cp_contents'],$srr_tag) ;
								$cp_contents = strip_tags($cp_contents);
								$cp_contents = htmlspecialchars($cp_contents);
								$cp_contents = mb_substr($cp_contents,0,30,"EUC-JP").'．．．<a href="'._BLOG_SITE_URL_BASE.'campaign-detail-'.$obj_campaign->campaindat[$key1]['cp_id'].'/">
<font color="#666666">
									 （詳細はこちら）
</a>
</font>
';
					 }else{
								$img_path = '';

								$cp_contents = "";
								$cp_contents = strip_between_tag($obj_campaign->campaindat[$key1]['cp_contents'],$srr_tag) ;
								$cp_contents = strip_tags($cp_contents);
								$cp_contents = htmlspecialchars($cp_contents);
								$cp_contents = mb_substr($cp_contents,0,30,"EUC-JP").'．．．<a href="'._BLOG_SITE_URL_BASE.'campaign-detail-'.$obj_campaign->campaindat[$key1]['cp_id'].'/">
<font color="#666666">
									 （詳細はこちら）
</a>
</font>
';
					 }

					 $campaign_list.='
								<!--box start-->
								<font size="1" color="#00B0F0">■</font><font size="1"><a href="'._BLOG_SITE_URL_BASE.'campaign-detail-'.$obj_campaign->campaindat[$key1]['cp_id'].'/">
<font size="1" color="#666666">
								'.htmlspecialchars($obj_campaign->campaindat[$key1]['cp_title']).'
</font>
</a>
								<br><a href="'._BLOG_SITE_URL_BASE.'campaign-detail-'.$obj_campaign->campaindat[$key1]['cp_id'].'/"></a>
								'.$img_path.'
								<font size="1">'.$cp_contents.'<br>
';
$age_of         = $obj_campaign->campaindat[$key1]['cp_age'];
$age_check      = array();
$age_icon       = array() ;
$age_check_list = "";
$age_icon_list  = "" ;
if(($age_of & 64)==64){
	   $age_check[7]='社会人　';
		  $age_icon[7]='<img src="./share/icons/item_syakaijin_5.gif" alt="" width="45" height="30" />';
		  $age_of-=64;
}
if(($age_of & 32)==32){
	   $age_check[6]='大学生　';
		  $age_icon[6]='<img src="./share/icons/item_daigaku_5.gif" alt="" width="45" height="30" />　';
		  $age_of-=32;
}
if(($age_of & 16)==16){
	   $age_check[5]='浪人生　';
		  $age_icon[5]='<img src="./share/icons/item_ronin_5.gif" alt="" width="45" height="30" />　';
		  $age_of-=16;
}
if(($age_of & 8)==8){
	   $age_check[4]='高校生　';
		  $age_icon[4]='<img src="./share/icons/item_koukou_5.gif" alt="" width="45" height="30" />　';
		  $age_of-=8;
}
if(($age_of & 4)==4){
	   $age_check[3]='中学生　';
		  $age_icon[3]='<img src="./share/icons/item_chugaku_5.gif" alt="" width="45" height="30" />　';
		  $age_of-=4;
}
if(($age_of & 2)==2){
	   $age_check[2]='小学生　';
		  $age_icon[2]='<img src="./share/icons/item_shougaku_5.gif" alt="" width="45" height="30" />　';
		  $age_of-=2;
}
if(($age_of & 1)==1){
	   $age_check[1]='幼児　';
		  $age_icon[1]='<img src="./share/icons/item_youji_5.gif" alt="" width="45" height="30" />　';
		  $age_of-=1;
}

if(count($age_check)){
	   ksort($age_check) ;
		  $age_check_list="";
		  foreach($age_check as $key3=>$val3){
				    $age_check_list.=$val3;
					   }
		    $age_check_list.="" ;
}else{
	   $age_check_list="−";
}

if($age_check_list=="−"){}else{
$campaign_list.='
  <font size="1"><font color="#FFC000">*</font><font size="1" color="#538ED5">対　象</font><br>
  <font size="1">　'.$age_check_list.'<br>
  ';
}

$start_year ="";
$start_month="";
$start_day  ="";
$start_date ="";
$end_year   ="";
$end_month  ="";
$end_day    ="";
$end_date   ="";
$publishing_period="";
if($obj_campaign->campaindat[$key1]['cp_camstart'] || $obj_campaign->campaindat[$key1]['cp_camend'])
{
$start_year  = substr($obj_campaign->campaindat[$key1]['cp_camstart'],0,4);
$start_month = substr($obj_campaign->campaindat[$key1]['cp_camstart'],5,2);
$start_day   = substr($obj_campaign->campaindat[$key1]['cp_camstart'],8,2);

$start_date  = $start_year.'年'.$start_month.'月'.$start_day.'日';

$end_year    = substr($obj_campaign->campaindat[$key1]['cp_camend'],0,4);
$end_month   = substr($obj_campaign->campaindat[$key1]['cp_camend'],5,2);
$end_day     = substr($obj_campaign->campaindat[$key1]['cp_camend'],8,2);

$end_date    = $end_year.'年'.$end_month.'月'.$end_day.'日';

				  $publishing_period=ltrim($start_date,"0")." 〜 ".ltrim($end_date,"0");
}else{
	   $publishing_period="−";
}




if($publishing_period=="−"){}else{
	
	
$campaign_list.='
  <font size="1"><font color="#FFC000">*</font><font size="1" color="#538ED5">実施日時</font><br>
  <font size="1">　'.$publishing_period.'<br>
  </div><!--box end-->
  ';
}

$campaign_list.='<HR color="#FFC000" size="1">';

		  }

}






$campaign_list.='
		  　'.$pagedown.'　
		  　'.$pageup.'　
		 ';
/*---------------------------------------------------------
ページ遷移部品作成
$strViewPageNowCount    ... 現在表示している件数コメント
$strViewPageMove        ... ページ遷移リンク
$strViewPageMove_before ... 「前へ」
$strViewPageMove_after  ... 「後へ」
$_GET["p"]              ... 現在のページ
$intMaxViewCnt          ... 表示件数(上限)
		 (上にて指定済み)
$buildTotal             ... 検索対象全体数
$strGetSearch           ... 検索条件保存値
---------------------------------------------------------*/
if($_GET['new']){

}
//IF( $buildCnt != 0 ){
$strViewPageNowCount  = "";
$strBuffBuildStartCnt = ( $intMaxViewCnt * ( $_GET["page"] - 1 ) ) + 1;
$strBuffBuildEndCnt   = ( $intMaxViewCnt * ( $_GET["page"] - 1 ) ) + $buildCnt;
$strViewPageNowCount .= '('.$strBuffBuildStartCnt.'〜'.$strBuffBuildEndCnt.'件／全'.$build_list_cnt."件)<br>\n";

//	$intBuffMove = $build_list_cnt / $intMaxViewCnt;
IF( is_int($intBuffMove) === FALSE ){
		  $intBuffMove = ceil($intBuffMove);
}

//計算部分	
$page_category="";
$page_category=ceil($_GET['page'] / 5);
$start = ( $page_category - 1 ) * 5 +1;
$end = $start + 4;
$strViewPageMove_list="";


if($pagea > $intTotal_campaign){

	$last =$pagemax / 10;

	$last =floor($last);
	if($last==0){
	$last=1;
	}



// 通常処理(リスト)
for($cnt=$start;$cnt<=$end;$cnt++){
	if($cnt==$_GET['page']){
			  $strViewPageMove_list.='<td><font size="1">['.$cnt."]</td>\n";
	}else{
			  if($cnt>$last){
			  }else{
						 $strViewPageMove_list.=
'<td><font size="1"><A href="'._BLOG_SITE_URL_BASE.'campain-list/p-'.($start-1).'/cp-'.$cpid.'/?page='.$cnt.''.$strGetSearch_lay.'" target="_self">
<font size="1" color="#666666">['.$cnt."]</font></td></a>\n";

			  }
	}
}


	$strViewPageMove_before = "";
	if($page_category!=1){
		$intBuffCnt_be=$last;
		$strViewPageMove_before .=
		'<A href="'._BLOG_SITE_URL_BASE.'campain-list/p-'.($start-1).'/cp-'.$cpid.'/'.$strGetSearch_lay.'" target="_self">
<font size="1" color="#666666">
		前のページ
</font>
		</A>'."\n";
	}

}else{

	$last =$pagemax / 10;

	$last =ceil($last);
	if($last==0){
	$last=1;
	}

	if($last ==1){
	}else{


//通常処理(リスト)
			  for($cnt=$start;$cnt<=$end;$cnt++){
				if($cnt==$_GET['page']){
					$strViewPageMove_list.='<td><font size="1">['.$cnt."]</td>\n";
				}else{
 if($cnt>$last){

							}else{

		$strViewPageMove_list.=

		'
<td>		
<A href="'._BLOG_SITE_URL_BASE.'campain-list/p-'.($cnt).'/cp-'.$cpid.'/'.$strGetSearch_lay.'" target="_self">
<font size="1" color="#666666">
		['.$cnt."]
</td>
</font></a>
		 \n";

							}
				}
			  }



 $strViewPageMove_after = "";
if($end+1 <=$last){
		$intBuffCnt_af=$start+5;
		$strViewPageMove_after .='<A href="'._BLOG_SITE_URL_BASE.'campain-list/p-'.($end+1).'/cp-'.$cpid.'/'.$strGetSearch_lay.'" target="_self">
<font color="#666666">
		次のページ
</a>
</font>
		'."\n";
}


	$strViewPageMove_before = "";
	if($page_category!=1){
		$intBuffCnt_be=$start-1;
		$strViewPageMove_before .=
		'<A href="'._BLOG_SITE_URL_BASE.'campain-list/p-'.($start-1).'/cp-'.$cpid.'/'.$strGetSearch_lay.'" target="_self">
<font color="#666666">
		前のページ
</a></font>
		'."\n";
	}

}

//ボタン
if($strViewPageMove_before && !$strViewPageMove_after){
$strViewCategoryPageMove = "		".$strViewPageMove_before."\n";
}elseif($strViewPageMove_before && $strViewPageMove_after){
$strViewCategoryPageMove .= "		".$strViewPageMove_before."　".$strViewPageMove_after."\n";
}else{
$strViewCategoryPageMove = "		".$strViewPageMove_after."\n";
}
}
?>
