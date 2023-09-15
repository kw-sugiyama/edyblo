<?

if($_GET['drid']){
	$drid=$_GET['drid'];
}else{
	$drid=0;
}
if($_GET['page']){
	$page=$_GET['page'];
}else{
	$page=0;
}

$obj_category->jyoken=array();
$obj_category->jyoken["cg_clid"]=$obj_login->clientdat[0]['cl_id'];
$obj_category->jyoken["cg_stat"]=1;
$obj_category->jyoken["cg_type"]=5;
$obj_category->jyoken["cg_id"]=$drid;
$obj_category->jyoken["cg_deldate"]=1;
$obj_category->sort["cg_dispno"] = 2;

$obj_category->categorydat=array();
list( $intCnt_category , $intTotal_category ) = $obj_category->basedb_GetCategory ( 1 , -1 );

$start=$page*10 + 1;
$end=$start+9;
// 1ページあたり表示件数 ページ遷移バグ修正 2009/12/02 大塚
$get_cnt = 10;

$obj_diary = new basedb_DiaryClassTblAccess;
$obj_diary->conn = $obj_conn->conn;
$obj_diary->jyoken=array();
$obj_diary->jyoken["dr_clid"]=$obj_login->clientdat[0]['cl_id'];
//$obj_diary->jyoken["dr_stat"]=1;
$obj_diary->jyoken["dr_deldate"]=1;
$obj_diary->jyoken["dr_cgid"]=$drid;
$obj_diary->sort["dr_upddate"] = 2;

$obj_diary->diarydat=array();
// ページ遷移バグ修正 2009/12/02 大塚	list( $intCnt_diary , $intTotal_diary ) = $obj_diary->basedb_GetDiary ( $start , $end );
list( $intCnt_diary , $intTotal_diary ) = $obj_diary->basedb_GetDiary ( $start , $get_cnt );

$pagemax="";
$pagedown="";
$pageup="";




if($page>=1){
	$pagedown='<p class="search"><a href="'._BLOG_SITE_URL_BASE.'diary-list/p-'.($page-1).'/dr-'.$drid.'/">前の10件を表示</a></p>';
}
if(($intTotal_diary/10)-($page+1)>0){
	$pageup='<p class="search"><a href="'._BLOG_SITE_URL_BASE.'diary-list/p-'.($page+1).'/dr-'.$drid.'/">次の10件を表示</a></p>';
}





$img_path="";
$dispcnt="";
$dispcnt=count($obj_diary->diarydat)-1;

if($intTotal_diary>0){
	if($start==($start+$intCnt_diary-1)){
		$case_number=$intTotal_diary.' 件中 '.$start." 件目を表示";
	}else{
		$case_number=$intTotal_diary.' 件中 '.$start.' 〜 '.($start+$intCnt_diary-1)." 件目を表示";
	}
}else{
	$case_number="";
}

if($dispcnt>=0){
	foreach($obj_diary->diarydat as $key1=>$val1){
		$img_flag=ereg("\[IMG1\]",$obj_diary->diarydat[$key1]['dr_contents']);
		
		if($obj_diary->diarydat[$key1]['dr_img1'] && $img_flag){
			$img_path='<p class="marginr1"><img src="./img_thumbnail.php?w=145&h=91&dir='.$param_dr_img1_path.'&nm='.$obj_diary->diarydat[$key1]['dr_img1'].'" alt="" /></p>';
		
			$dr_contents="";
			$dr_contents=html_delete($obj_diary->diarydat[$key1]['dr_contents']);
			//$dr_contents=htmlspecialchars($dr_contents);
			$dr_contents=strip_tags($dr_contents);
			$dr_contents=mb_substr($dr_contents,0,135,"EUC-JP").'．．．<a href="'._BLOG_SITE_URL_BASE.'blog-'.$obj_diary->diarydat[$key1]['dr_id'].'/">（詳細はこちら）</a>';
		}else{
			$img_path='';

			$dr_contents="";
			$dr_contents=html_delete($obj_diary->diarydat[$key1]['dr_contents']);
			//$dr_contents=htmlspecialchars($dr_contents);
			$dr_contents=strip_tags($dr_contents);
			$dr_contents=mb_substr($dr_contents,0,188,"EUC-JP").'．．．<a href="'._BLOG_SITE_URL_BASE.'blog-'.$obj_diary->diarydat[$key1]['dr_id'].'/">（詳細はこちら）</a>';
		}
		
		
		if($key1==0){
			$blog_list='
<div class="box"><!--box start-->
	<h3 class="white">'.htmlspecialchars($obj_category->categorydat[0]['cg_stitle']).'</h3>
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
		$insert_year=substr($obj_diary->diarydat[$key1]['dr_insdate'],0,4);
		$insert_month=substr($obj_diary->diarydat[$key1]['dr_insdate'],5,2);
		$insert_day=substr($obj_diary->diarydat[$key1]['dr_insdate'],8,2);
	
		$mkdate_week=mktime (0,0,0,$insert_month,$insert_day,$insert_year);
		$insrert_week=substr("日月火水木金土", date("w", $mkdate_week)*2, 2);
	
		$insrert_date=$insert_year.'年'.$insert_month.'月'.$insert_day.'日';
		
		if($img_path){
			
			$blog_list.='
<div class="boxlittle"><!--boxlittle start-->                 
	<table>
		<tr>
			<td  class="borderblue" colspan="2">
				<p>
					<span class="blue"><em>'.$insrert_date.'</em></span>
					<span class="blue"><em>'.$insrert_week.'曜日</em></span>
					<span class="normallink"><em><a href="'._BLOG_SITE_URL_BASE.'blog-'.$obj_diary->diarydat[$key1]['dr_id'].'/">'.htmlspecialchars($obj_diary->diarydat[$key1]['dr_title']).'</a></em></span>
				</p>
			</td>
		</tr>
		<tr>
			<td class="td3a">
				'.$img_path.'</td>
			<td class="td3b">
				<p>'.$dr_contents.'</p></td>
		</tr>
	</table>
	<p class="detail margint2"><a href="'._BLOG_SITE_URL_BASE.'blog-'.$obj_diary->diarydat[$key1]['dr_id'].'/">　</a></p><br class="clear" />
</div><!--box end-->
';
		}else{
		$blog_list.='
<div class="boxlittle"><!--boxlittle start-->                 
	<table>
		<tr>
			<td  class="borderblue" colspan="2">
				<p>
					<span class="blue"><em>'.$insrert_date.'</em></span>
					<span class="blue"><em>'.$insrert_week.'曜日</em></span>
					<span class="normallink"><em><a href="'._BLOG_SITE_URL_BASE.'blog-'.$obj_diary->diarydat[$key1]['dr_id'].'/">'.$obj_diary->diarydat[$key1]['dr_title'].'</a></em></span>
				</p>
			</td>
		</tr>
		<tr>
			<td>
				<p>'.$dr_contents.'</p>
			</td>
		</tr>
	</table>
	<p class="detail margint2"><a href="'._BLOG_SITE_URL_BASE.'blog-'.$obj_diary->diarydat[$key1]['dr_id'].'/">　</a></p><br class="clear" />
</div><!--box end-->
';
		}
	}
}
$blog_list.='
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
?>
