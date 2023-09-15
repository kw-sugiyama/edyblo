<?
//=====================================================================
//blog_detail.tplで使う変数リスト
//teacher
//img_path
//tc_comment
//=====================================================================
if($_GET['drid']){
		  $drid=$_GET['drid'];
}else{
		  $drid="error";
}

//htmltag削除==========================================================
require"taglist.php";
function strip_between_tag( $str, $tag=array() ) {
foreach( $tag as $val){
$pattern = "/<{$val}.*?>.*?<\/{$val}>/ims";
$str = preg_replace( $pattern , '[ 携帯表示不可 ]', $str);
}
return $str;
}
//=====================================================================

//=====================================================================
//dr_clid    日記のクライアント番号
//cl_id      クライアント番号
//dr_deldate 日記削除番号
//dr_id      日記番号
//=====================================================================
$obj_diary = new basedb_DiaryClassTblAccess;
$obj_diary->conn = $obj_conn->conn;
$obj_diary->jyoken=array();
$obj_diary->jyoken["dr_clid"]=$obj_login->clientdat[0]['cl_id'];
$obj_diary->jyoken["dr_deldate"]=1;
$obj_diary->jyoken["dr_id"]=$drid;

$obj_diary->diarydat=array();
list( $intCnt_diary , $intTotal_diary ) = $obj_diary->basedb_GetDiary ( 1 , -1 );

if($intTotal_diary==0){
		  require_once( SYS_PATH."templates/mobile/error_all.tpl" );
		  exit;
}

//=====================================================================
//cg_clid    カテゴリクライアント番号
//cg_stat    カテゴリ状態
//cg_id      カテゴリID
//cg_deldate カテゴリ削除日時
//dr_cgid    カテゴリ番号
//=====================================================================
$obj_category1 = new basedb_CategoryClassTblAccess;
$obj_category1->conn = $obj_conn->conn;
$obj_category1->jyoken=array();
$obj_category1->jyoken["cg_clid"]=$obj_login->clientdat[0]['cl_id'];
$obj_category1->jyoken["cg_stat"]=1;
$obj_category1->jyoken["cg_id"]=$obj_diary->diarydat[0]['dr_cgid'];
$obj_category1->jyoken["cg_deldate"]=1;

$obj_category1->categorydat=array();
list( $intCnt_category1 , $intTotal_category1 ) = $obj_category1->basedb_GetCategory ( 1 , -1 );

//=====================================================================
//tc_id      講師ID
//tc_deldate 講師削除日時
//=====================================================================
$obj_teacher = new basedb_TeacherClassTblAccess;
$obj_teacher->conn = $obj_conn->conn;
$obj_teacher->jyoken=array();
$obj_teacher->jyoken["tc_id"]=$obj_diary->diarydat[0]['dr_tcid'];
$obj_teacher->jyoken["tc_deldate"]=1;
$obj_teacher->teacherdat=array();
$tc_box="";
$img_path="";
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
		  $tc_comment=($obj_teacher->teacherdat[0]['tc_comment']);
		  $tc_comment=strip_between_tag($tc_comment,$srr_tag);
		  $tc_comment=strip_tags($tc_comment,$srr_tag);
		  $tc_comment=htmlspecialchars($tc_comment);
		  $tc_comment=html_replace($tc_comment);
		  $tc_comment=nl2br($tc_comment);
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
//チェック
$dr_contents=htmlspecialchars($obj_diary->diarydat[0]['dr_contents']);
$dr_contents=html_replace($dr_contents,$obj_diary->diarydat[0]['dr_img1'],$obj_diary->diarydat[0]['dr_img2'],$obj_diary->diarydat[0]['dr_img3'],$obj_diary->diarydat[0]['dr_img4'],1);

$view_blog='
		  <!--boxlittle start-->                 
		  <p>
		  '.$insrert_date.'
		  '.$insrert_week.'曜日
		  '.htmlspecialchars($obj_diary->diarydat[0]['dr_title']).'　　　　　（　<a href="'._BLOG_SITE_URL_BASE.'diary-list/p-0/dr-'.$obj_category1->categorydat[0]['cg_id'].'/">
<font color="#666666">
		  '.htmlspecialchars($obj_category1->categorydat[0]['cg_stitle']).'
</font>
</a>　）
		  </p>
		  <!--box end-->

		  <p>'.nl2br($dr_contents).'</p>
		  ';

echo  $img_path[0];
if($obj_diary->diarydat[0]['dr_img1']){
		  $img_path[0]='
					 <td>
					 <p class="marginr1">
					 <a href="'.$param_dr_img1_path.$obj_diary->diarydat[0]['dr_img1'].'" class="highslide" onclick="return hs.expand(this)" onkeypress="return hs.expand(this)"><img src="./img_thumbnail.php?w=145&h=91&dir='.$param_dr_img1_path.'&nm='.$obj_diary->diarydat[0]['dr_img1'].'" alt="" /></a>
					 </p>
					 </td>';
}else{
		  $img_path[0]='';
}
if($obj_diary->diarydat[0]['dr_img2']){
		  $img_path[1]='
					 <td>
					 <p class="marginr1">
					 <a href="'.$param_dr_img2_path.$obj_diary->diarydat[0]['dr_img2'].'" class="highslide" onclick="return hs.expand(this)" onkeypress="return hs.expand(this)"><img src="./img_thumbnail.php?w=145&h=91&dir='.$param_dr_img2_path.'&nm='.$obj_diary->diarydat[0]['dr_img2'].'" alt="" /></a>
					 </p>
					 </td>';
}else{
		  $img_path[1]='';
}
if($obj_diary->diarydat[0]['dr_img3']){
		  $img_path[2]='
					 <td>
					 <p class="marginr1">
					 <a href="'.$param_dr_img3_path.$obj_diary->diarydat[0]['dr_img3'].'" class="highslide" onclick="return hs.expand(this)" onkeypress="return hs.expand(this)"><img src="./img_thumbnail.php?w=145&h=91&dir='.$param_dr_img3_path.'&nm='.$obj_diary->diarydat[0]['dr_img3'].'" alt="" /></a>
					 </p>
					 </td>';
}else{
		  $img_path[2]='';
}
if($obj_diary->diarydat[0]['dr_img4']){
		  $img_path[3]='	
					 <td>
					 <p class="marginr1">
					 <a href="'.$param_dr_img4_path.$obj_diary->diarydat[0]['dr_img4'].'" class="highslide" onclick="return hs.expand(this)" onkeypress="return hs.expand(this)"><img src="./img_thumbnail.php?w=145&h=91&dir='.$param_dr_img4_path.'&nm='.$obj_diary->diarydat[0]['dr_img4'].'" alt="" /></a>
					 </p>
					 </td>';
}else{
		  $img_path[3]='';
}
$tc_box='
		  <div class="box"><!--box start-->
		  '.$img_path.'
		  '.htmlspecialchars($obj_teacher->teacherdat[0]['tc_name']).'<br>
		  担　当'.$age_check_list.'<br>
		  教　科'.$tc_subject.'<br>

		  </div><!--box end-->
		  ';

$teacher='
		  '.htmlspecialchars($obj_teacher->teacherdat[0][tc_name]).'';
//$link='$obj_diary->diarydat[0]['dr_id']/">';'

if($obj_teacher->teacherdat[0]['tc_img']){
		  $img_path='<center><img src="./img_thumbnail.php?w=84&h=100&dir='.$param_tc_img_path.'&nm='.$obj_teacher->teacherdat[0]['tc_img'].'" alt="" /></center>';
}else{
		  $img_path="";}



?>
