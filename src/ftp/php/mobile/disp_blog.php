<?
//=====================================================================
//blog.tplで使う変数リスト
//view_blog
//view_blog2
//tc_box2
//=====================================================================

//=====================================================================
//関数追加(htmltag除去 変換)
//=====================================================================
require"taglist.php";
function strip_between_tag( $str, $tag=array() ) {
foreach( $tag as $val){
$pattern = "/<{$val}.*?>.*?<\/{$val}>/ims";
$str = preg_replace( $pattern , '[ 携帯表示不可 ]', $str);
}
return $str;
}
//=====================================================================

if($_GET['drid']){
	$drid=$_GET['drid'];
}else{
	$drid="error";
}
if($dr_id==error){
break;
}

$obj_diary                           = new basedb_DiaryClassTblAccess;
$obj_diary->conn                     = $obj_conn->conn;
$obj_diary->jyoken                   = array();
$obj_diary->jyoken["dr_id"]          = $drid;
$obj_diary->diarydat=array();
list( $intCnt_diary , $intTotal_diary ) = $obj_diary->basedb_GetDiary ( 1 , -1 );
if($intTotal_diary==0){
	require_once( SYS_PATH."templates/mobile/error_all.tpl" );
	exit;
}

//=====================================================================
//cg clid    カテゴリクライアント番号
//cg stat    状態
//cg id      カテゴリID
//cg deldate 削除日時
//=====================================================================

$obj_category1                       = new basedb_CategoryClassTblAccess;
$obj_category1->conn                 = $obj_conn->conn;
$obj_category1->jyoken               = array();
$obj_category1->jyoken["cg_clid"]    = $obj_login->clientdat[0]['cl_id'];
$obj_category1->jyoken["cg_stat"]    = 1;
$obj_category1->jyoken["cg_id"]      = $obj_diary->diarydat[0]['dr_cgid'];
$obj_category1->jyoken["cg_deldate"] = 1;
$obj_category1->categorydat=array();
list( $intCnt_category1 , $intTotal_category1 ) = $obj_category1->basedb_GetCategory ( 1 , -1 );

//=====================================================================
//tc id       講師ID
//tc deldate  講師削除日時
//=====================================================================
$obj_teacher                         = new basedb_TeacherClassTblAccess;
$obj_teacher->conn                   = $obj_conn->conn;
$obj_teacher->jyoken                 = array();
$obj_teacher->jyoken["tc_id"]        = $obj_diary->diarydat[0]['dr_tcid'];
$obj_teacher->jyoken["tc_deldate"]   = 1;
$obj_teacher->teacherdat             = array();
$tc_box                              = "";
$img_path                            = "";
if($obj_diary->diarydat[0]['dr_tcid']){
	list( $intCnt_teacher , $intTotal_teacher ) = $obj_teacher->basedb_GetTeacher ( 1 , -1 );
	
	$age_of=$obj_teacher->teacherdat[0]['tc_age'];
	$age_check_list="";
	$age_check=array();
	if(($age_of & 64)==64){
		$age_check[7]='社会人　';
		$age_icon[7]='<img src="./share/icons/icon_b_18.gif" alt="" />　';
		$age_of-=64;
	}
	if(($age_of & 32)==32){
		$age_check[6]='大学生　';
		$age_icon[6]='<img src="./share/icons/icon_b_5.gif" alt="" />　';
		$age_of-=32;
	}
	if(($age_of & 16)==16){
		$age_check[5]='浪人生　';
		$age_icon[5]='<img src="./share/icons/icon_b_13.gif" alt="" />　';
		$age_of-=16;
	}
	if(($age_of & 8)==8){
		$age_check[4]='高校生　';
		$age_icon[4]='<img src="./share/icons/icon_b_11.gif" alt="" />　';
		$age_of-=8;
	}
	if(($age_of & 4)==4){
		$age_check[3]='中学生　';
		$age_icon[3]='<img src="./share/icons/icon_b_3.gif" alt="" />　';
		$age_of-=4;
	}
	if(($age_of & 2)==2){
		$age_check[2]='小学生　';
		$age_icon[2]='<img src="./share/icons/icon_b_15.gif" alt="" />　';
		$age_of-=2;
	}
	if(($age_of & 1)==1){
		$age_check[1]='幼児　';
		$age_icon[1]='<img src="./share/icons/icon_b_19.gif" alt="" />　';
		$age_of-=1;
	}
	if(count($age_check)){
		ksort($age_check);
		$age_check_list="";
		foreach($age_check as $key3=>$val3){
			$age_check_list.=$val3;
		}
	$age_check_list.="";
	}else{
		$age_check_list="−";
	}
	
	if(count($age_icon)){
		ksort($age_icon);
		foreach($age_icon as $key4=>$val4){
			$age_icon_list.=$val4;
		}
	}
	if($obj_teacher->teacherdat[0]['tc_subject']){
		$tc_subject=htmlspecialchars($obj_teacher->teacherdat[0]['tc_subject']);
	}
	
	if($obj_teacher->teacherdat[0]['tc_img']){
		$img_path='<img src="./img_thumbnail.php?w=84&h=100&dir='.$param_tc_img_path.'&nm='.$obj_teacher->teacherdat[0]['tc_img'].'" alt="" />';
	}else{
		$img_path="";
	}
	$tc_comment=htmlspecialchars($obj_teacher->teacherdat[0]['tc_comment']);
	$tc_comment=html_replace($tc_comment);
	$tc_box='
					<p>'.$img_path.'</p>
					<p>'.htmlspecialchars($obj_teacher->teacherdat[0]['tc_name']).'</p>
									<p>担　当</p>
									'.$age_check_list.'
									<p>教　科</p>
									<p>'.$tc_subject.'</p>
									<p>自己紹介</p>
									<p>'.$tc_comment.'</p>
								
';
}
$img_path="";
$dispcnt="";
$dispcnt=count($obj_diary->diarydat)-1;
if($dispno>=0){
	
	$insert_year  = substr($obj_diary->diarydat[0]['dr_insdate'],0,4);
	$insert_month = substr($obj_diary->diarydat[0]['dr_insdate'],5,2);
	$insert_day   = substr($obj_diary->diarydat[0]['dr_insdate'],8,2);
	$mkdate_week  = mktime (0,0,0,$insert_month,$insert_day,$insert_year);
	$insrert_week = substr("日月火水木金土", date("w", $mkdate_week)*2, 2);
	$insrert_date = $insert_year.'年'.$insert_month.'月'.$insert_day.'日';
}
$dr_contents=($obj_diary->diarydat[0]['dr_contents']);
$dr_contents=strip_between_tag($dr_contents,$srr_tag);
$dr_contents=strip_tags($dr_contents);
$dr_contents=htmlspecialchars($dr_contents);

//画像変換箇所
$dr_contents=html_replace($dr_contents,$obj_diary->diarydat[0]['dr_img1'],$obj_diary->diarydat[0]['dr_img2'],$obj_diary->diarydat[0]['dr_img3'],$obj_diary->diarydat[0]['dr_img4'],1);

$view_blog='
<!--boxlittle start-->                 
'.htmlspecialchars($obj_diary->diarydat[0]['dr_title']).'　　　　　
<!--box end-->

';

$view_blog2='
				'.nl2br($dr_contents).'<br />
';
//フラグをobj_teacherにセット
$teacher='
'.htmlspecialchars($obj_teacher->teacherdat[0][tc_name]).'';


if($tc_comment == ""){
$tc_box2="";
}else{
//	 echo $_GET[img];
if(!$_GET[img]==1 or !$_GET[img]==2 or !$_GET[img]==3 or !$_GET[img]==4){
	 $tc_box2='
<hr color="#92D050" size="1">
<div class="box"><!--box start-->
		'.$img_path.'
	'.htmlspecialchars($obj_teacher->teacherdat[0]['tc_name']).'<br>
	担　当 :'.$age_check_list.'<br>
	教　科 :'.$tc_subject.'<br>
	<a href="../blogd-'.$obj_diary->diarydat[0][dr_id].'/">
<font color="#666666">
自己紹介
</font>
</a>
</div><!--box end-->
';
	 }else{
	 
$tc_box2="";
	 
	 
	 }
}

$dr_cgid= $obj_diary->diarydat[0][dr_cgid];
if($dr_cgid==""){
$link='';
}else{
$link='
□<a href="
'._BLOG_SITE_URL_BASE.'diary-list/p-1/dr-'.$obj_category1->categorydat[0]['cg_id'].'/">
<font color="#666666">

'.htmlspecialchars($obj_category1->categorydat[0]['cg_stitle']).'
</font>
</a>';
}
?>
