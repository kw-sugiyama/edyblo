<?
//===================================
//blog.tplで使う変数リスト
//case_number
//blog_listtitle
//blog_list
//strViewPageMove_list
//strViewPageMove_before
//strViewPageMove_after
//===================================

//==================================
//関数追加(htmltag除去 変換)
require"taglist.php";
function strip_between_tag( $str, $tag=array() ) {
foreach( $tag as $val){
$pattern = "/<{$val}.*?>.*?<\/{$val}>/ims";
$str = preg_replace( $pattern , '[ 携帯表示不可 ]', $str);
}
return $str;
}
//==================================

if($_GET['drid']){
		  $drid=$_GET['drid'];
}else{
		  $drid=0;
}
if($_GET['page']){
		  $page=$_GET['page']-1;
}else{
		  $page=0;
}
$obj_category->jyoken=array();
$obj_category->jyoken["cg_clid"]   = $obj_login->clientdat[0]['cl_id'];
$obj_category->jyoken["cg_stat"]   = 1;
$obj_category->jyoken["cg_type"]   = 5;
$obj_category->jyoken["cg_id"]     = $drid;
$obj_category->jyoken["cg_deldate"]= 1;
$obj_category->sort["cg_dispno"]   = 2;
$obj_category->categorydat=array();

//何件目から　何件目まで拾ってくる
list( $intCnt_category , $intTotal_category ) = $obj_category->basedb_GetCategory ( 1 , -1 );

$start=$page * 10;
$start=$start+1;
$obj_diary = new basedb_DiaryClassTblAccess;
$obj_diary->conn = $obj_conn->conn;
$obj_diary->jyoken=array();
$obj_diary->jyoken["dr_clid"]    = $obj_login->clientdat[0]['cl_id'];
$obj_diary->jyoken["dr_deldate"] = 1;
$obj_diary->jyoken["dr_cgid"]    = $drid;
$obj_diary->sort["dr_upddate"]   = 2;
$obj_diary->diarydat=array();
list( $intCnt_diary , $intTotal_diary ) = $obj_diary->basedb_GetDiary ( $start , 10 );
//ページマックス件数start
$intTotal_diary2 = ($intTotal_diary / 10);
$intTotal_diary2 = ceil($intTotal_diary2);
$intTotal_diary2 = $intTotal_diary2-2;
//ページマックス件数end

$pagemax ="$intTotal_diary";
$pagedown="";
$pageup  ="";
//日記表示件数

//echo $intTotal_diary;
//echo $start;
//echo $pagemax;
$pagea = $start+$intCnt_diary;
//echo $pagea;

if($pagea > $intTotal_diary){

		  $start1 =$start;
		  $case_number='(	  
					 '.$start1.' 〜 
					 '.($intTotal_diary)." 件／全
					 $intTotal_diary 件)
					 <br />
					 ";
}else{

		  $start1 =$start;
		  //    $case_number=$intTotal_campaign.' 件 '.$start.' 〜 '.($start+$intCnt_campaign-1)." 件目を表示";
		  $case_number='(	  
					 '.$start1.' 〜 
					 '.($start+$intCnt_diary-1)." 件／全
					 $intTotal_diary 件)
					 <br />
					 ";
}



$img_path="";
$dispcnt="";
$dispcnt=count($obj_diary->diarydat)-1;


if($dispcnt>=0){
		  foreach($obj_diary->diarydat as $key1=>$val1){
					 $img_flag=ereg("\[IMG1\]",$obj_diary->diarydat[$key1]['dr_contents']);
					 if($obj_diary->diarydat[$key1]['dr_img1'] && $img_flag){
								$img_path='<img src="./img_thumbnail.php?w=145&h=91&dir='.$param_dr_img1_path.'&nm='.$obj_diary->diarydat[$key1]['dr_img1'].'" alt="" /><br />';
								$dr_contents="";
								$dr_contents=html_delete($obj_diary->diarydat[$key1]['dr_contents']);
								$dr_contents=strip_between_tag($dr_contents,$srr_tag);
								$dr_contents=strip_tags($dr_contents);
								$dr_contents=htmlspecialchars($dr_contents);
								$dr_contents=mb_substr($dr_contents,0,30,"EUC-JP").'．．．<a href="'._BLOG_SITE_URL_BASE.'blog-'.$obj_diary->diarydat[$key1]['dr_id'].'/">
<font color="#666666">
									 （詳細はこちら）
</font><font size="1">
<hr color="#FFC000" size="1">
									 </a>';
					 }else{
								$img_path='';
								$dr_contents="";
								$dr_contents=html_delete($obj_diary->diarydat[$key1]['dr_contents']);
								$dr_contents=strip_between_tag($dr_contents,$srr_tag);
								$dr_contents=strip_tags($dr_contents);
								$dr_contents=htmlspecialchars($dr_contents);
								$dr_contents=mb_substr($dr_contents,0,30,"EUC-JP").'．．．<a href="'._BLOG_SITE_URL_BASE.'blog-'.$obj_diary->diarydat[$key1]['dr_id'].'/">
<font color="#666666" size="1">
									 （詳細はこちら）
</font><font size="1">
<hr color="#FFC000" size="1">
									 </a>';
					 }
					 if($img_path){
							$blog_list.='
									  '.$insrert_date.'
									  '.$insrert_week.'<!--曜日-->
									  <font size="1" color="#FFC000">■</font><font size="1"><a href="'._BLOG_SITE_URL_BASE.'blog-'.$obj_diary->diarydat[$key1]['dr_id'].'/">
<font color="#666666">
									  '.htmlspecialchars($obj_diary->diarydat[$key1]['dr_title']).'
</font><font size="1">
</a><br />
									  '.$dr_contents.'
									  <a href="'._BLOG_SITE_URL_BASE.'blog-'.$obj_diary->diarydat[$key1]['dr_id'].'/">
</a>
									  ';
					 }else{
							$blog_list.='
									  '.$insrert_date.'
									  '.$insrert_week.'<!--曜日-->
									  <font size="1" color="#FFC000">■</font><font size="1"><a href="'._BLOG_SITE_URL_BASE.'blog-'.$obj_diary->diarydat[$key1]['dr_id'].'/">
<font color="#666666">
									  '.htmlspecialchars($obj_diary->diarydat[$key1]['dr_title']).'
</font><font size="1">
</a><br />
									  
									  '.$dr_contents.'
									  <a href="'._BLOG_SITE_URL_BASE.'blog-'.$obj_diary->diarydat[$key1]['dr_id'].'/"></a>
									  ';
					 }


  }

}
$blog_list.='
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
	$strBuffBuildStartCnt = ( $intMaxViewCnt * ( $_GET["p"] - 1 ) ) + 1;
	$strBuffBuildEndCnt   = ( $intMaxViewCnt * ( $_GET["p"] - 1 ) ) + $buildCnt;
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
	
//	echo $start;
//終わりページ計算
$case_number;
//ページ数を比べる 

if($pagea > $intTotal_diary){
	 $temp =$pagemax;
	$page_category="";
	$page_category=ceil($_GET['page'] / 5);
	$start = ( $page_category - 1 ) * 5 +1;
	$end = $start + 4;
	$strViewPageMove_list="";
	$page_category="";
	$page_category=ceil($_GET['page'] / 5);
	$start = ( $page_category - 1 ) * 5 +1;
	$end = $start + 4;	
	$intTotal_category = $pagemax% 5;



	$last =$pagemax / 10;
	$last =floor($last);
	if($last==0){
	$last=1;
	}

	if($page_category!=1){
	$strViewPageMove_before = "";
		$intBuffCnt_be=$endp;
		$strViewPageMove_before .=
		'<A href="'._BLOG_SITE_URL_BASE.'diary-list/p-'.($start-1).'/dr-'.$drid.'/'.$strGetSearch_lay.'" target="_self">
<font color="#666666">
		前のページ
</a>
</font>
		'."\n";
	}



for($cnt=$start;$cnt<=$end;$cnt++){
if($cnt==$_GET['page']){
	 $strViewPageMove_list.=
		  '<td><font size="1">['.$cnt."]</td>\n";
}else{
	if($cnt>$last){
	}else{
			  $strViewPageMove_list.=
'
<td>
<A href="'._BLOG_SITE_URL_BASE.'diary-list/p-'.($start).'/dr-'.$drid.'/?page='.$cnt.''.$strGetSearch_lay.'" target="_self">
<font size="1" color="#666666">
['.$cnt."]
</a>
</td> \n";
	}
}
}

}else{
//通常処理(リスト)
//	if($intBuffMove>1){
	$last =$pagemax / 10;
	$last =ceil($last);
	
	if($last==0){
	$last=1;
	}
	if($last ==1){
	 
	}else{

for($cnt=$start;$cnt<=$end;$cnt++){
if($cnt==$_GET['page']){
	$strViewPageMove_list.='<td><font size="1">['.$cnt."]</td>\n";
}else{
	if($cnt>$last){
	}else{
			  $strViewPageMove_list.=
'

<A href="'._BLOG_SITE_URL_BASE.'diary-list/p-'.($cnt).'/dr-'.$drid.'/'.$strGetSearch_lay.'" target="_self">
<font size="1" color="#666666">
<td>
<A href="'._BLOG_SITE_URL_BASE.'diary-list/p-'.($cnt).'/dr-'.$drid.'/'.$strGetSearch_lay.'" target="_self">
<font size="1" color="#666666">
['.$cnt."]
</td>
</font>
</A>
\n";
	}
}
}





	$strViewPageMove_after = "";

if($end+1 <= $last){
	//	if($intBuffMove >= $start+5){
		$intBuffCnt_af=$start+5;
//		$strViewPageMove_after='<A href="./?test">次ページへ</A>';
		$strViewPageMove_after .='<A href="'._BLOG_SITE_URL_BASE.'diary-list/p-'.($end+1).'/dr-'.$drid.'/'.$strGetSearch_lay.'" target="_self">
<font color="#666666">
		次のページ
</a>
</font>
		'."\n";
}
//	}
	$strViewPageMove_before = "";
	if($page_category!=1){
		$intBuffCnt_be=$start-1;
		$strViewPageMove_before .=
		'<A href="'._BLOG_SITE_URL_BASE.'diary-list/p-'.($start-1).'/dr-'.$drid.'/'.$strGetSearch_lay.'" target="_self">
<font color="#666666">
		前のページ
</a>
</font>
		'."\n";
	}
	}


}


if($strViewPageMove_before && !$strViewPageMove_after){
$strViewCategoryPageMove = "		".$strViewPageMove_before."\n";
}elseif($strViewPageMove_before && $strViewPageMove_after){
$strViewCategoryPageMove .= "		".$strViewPageMove_before."　".$strViewPageMove_after."\n";
}else{
$strViewCategoryPageMove = "		".$strViewPageMove_after."\n";
}

?>
