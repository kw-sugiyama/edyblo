<?
//===================================
//blog.tpl�ǻȤ��ѿ��ꥹ��
//case_number
//blog_listtitle
//blog_list
//strViewPageMove_list
//strViewPageMove_before
//strViewPageMove_after
//===================================

//==================================
//�ؿ��ɲ�(htmltag���� �Ѵ�)
require"taglist.php";
function strip_between_tag( $str, $tag=array() ) {
foreach( $tag as $val){
$pattern = "/<{$val}.*?>.*?<\/{$val}>/ims";
$str = preg_replace( $pattern , '[ ����ɽ���Բ� ]', $str);
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

//�����ܤ��顡�����ܤޤǽ��äƤ���
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
//�ڡ����ޥå������start
$intTotal_diary2 = ($intTotal_diary / 10);
$intTotal_diary2 = ceil($intTotal_diary2);
$intTotal_diary2 = $intTotal_diary2-2;
//�ڡ����ޥå������end

$pagemax ="$intTotal_diary";
$pagedown="";
$pageup  ="";
//����ɽ�����

//echo $intTotal_diary;
//echo $start;
//echo $pagemax;
$pagea = $start+$intCnt_diary;
//echo $pagea;

if($pagea > $intTotal_diary){

		  $start1 =$start;
		  $case_number='(	  
					 '.$start1.' �� 
					 '.($intTotal_diary)." ���
					 $intTotal_diary ��)
					 <br />
					 ";
}else{

		  $start1 =$start;
		  //    $case_number=$intTotal_campaign.' �� '.$start.' �� '.($start+$intCnt_campaign-1)." ���ܤ�ɽ��";
		  $case_number='(	  
					 '.$start1.' �� 
					 '.($start+$intCnt_diary-1)." ���
					 $intTotal_diary ��)
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
								$dr_contents=mb_substr($dr_contents,0,30,"EUC-JP").'������<a href="'._BLOG_SITE_URL_BASE.'blog-'.$obj_diary->diarydat[$key1]['dr_id'].'/">
<font color="#666666">
									 �ʾܺ٤Ϥ������
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
								$dr_contents=mb_substr($dr_contents,0,30,"EUC-JP").'������<a href="'._BLOG_SITE_URL_BASE.'blog-'.$obj_diary->diarydat[$key1]['dr_id'].'/">
<font color="#666666" size="1">
									 �ʾܺ٤Ϥ������
</font><font size="1">
<hr color="#FFC000" size="1">
									 </a>';
					 }
					 if($img_path){
							$blog_list.='
									  '.$insrert_date.'
									  '.$insrert_week.'<!--����-->
									  <font size="1" color="#FFC000">��</font><font size="1"><a href="'._BLOG_SITE_URL_BASE.'blog-'.$obj_diary->diarydat[$key1]['dr_id'].'/">
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
									  '.$insrert_week.'<!--����-->
									  <font size="1" color="#FFC000">��</font><font size="1"><a href="'._BLOG_SITE_URL_BASE.'blog-'.$obj_diary->diarydat[$key1]['dr_id'].'/">
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
		  ��'.$pagedown.'��
		  ��'.$pageup.'��
		  ';

/*---------------------------------------------------------
	 �ڡ����������ʺ���
	$strViewPageNowCount    ... ����ɽ�����Ƥ�����������
	$strViewPageMove        ... �ڡ������ܥ��
	$strViewPageMove_before ... �����ء�
	$strViewPageMove_after  ... �ָ�ء�
	$_GET["p"]              ... ���ߤΥڡ���
	$intMaxViewCnt          ... ɽ�����(���)
					(��ˤƻ���Ѥ�)
	$buildTotal             ... �����о����ο�
	$strGetSearch           ... ���������¸��
---------------------------------------------------------*/
if($_GET['new']){

}

//IF( $buildCnt != 0 ){
	$strViewPageNowCount  = "";
	$strBuffBuildStartCnt = ( $intMaxViewCnt * ( $_GET["p"] - 1 ) ) + 1;
	$strBuffBuildEndCnt   = ( $intMaxViewCnt * ( $_GET["p"] - 1 ) ) + $buildCnt;
	$strViewPageNowCount .= '('.$strBuffBuildStartCnt.'��'.$strBuffBuildEndCnt.'���'.$build_list_cnt."��)<br>\n";
	
//	$intBuffMove = $build_list_cnt / $intMaxViewCnt;
	IF( is_int($intBuffMove) === FALSE ){
		$intBuffMove = ceil($intBuffMove);
	}
	
//�׻���ʬ	
	$page_category="";
	$page_category=ceil($_GET['page'] / 5);
	$start = ( $page_category - 1 ) * 5 +1;
	$end = $start + 4;
	$strViewPageMove_list="";
	
//	echo $start;
//�����ڡ����׻�
$case_number;
//�ڡ���������٤� 

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
		���Υڡ���
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
//�̾����(�ꥹ��)
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
//		$strViewPageMove_after='<A href="./?test">���ڡ�����</A>';
		$strViewPageMove_after .='<A href="'._BLOG_SITE_URL_BASE.'diary-list/p-'.($end+1).'/dr-'.$drid.'/'.$strGetSearch_lay.'" target="_self">
<font color="#666666">
		���Υڡ���
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
		���Υڡ���
</a>
</font>
		'."\n";
	}
	}


}


if($strViewPageMove_before && !$strViewPageMove_after){
$strViewCategoryPageMove = "		".$strViewPageMove_before."\n";
}elseif($strViewPageMove_before && $strViewPageMove_after){
$strViewCategoryPageMove .= "		".$strViewPageMove_before."��".$strViewPageMove_after."\n";
}else{
$strViewCategoryPageMove = "		".$strViewPageMove_after."\n";
}

?>
