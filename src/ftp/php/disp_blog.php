<?


if($_GET['drid']){
	$drid=$_GET['drid'];
}else{
	$drid="error";
}
$obj_diary = new basedb_DiaryClassTblAccess;
$obj_diary->conn = $obj_conn->conn;
$obj_diary->jyoken=array();
$obj_diary->jyoken["dr_clid"]=$obj_login->clientdat[0]['cl_id'];
//$obj_diary->jyoken["dr_stat"]=1;
$obj_diary->jyoken["dr_deldate"]=1;
$obj_diary->jyoken["dr_id"]=$drid;

$obj_diary->diarydat=array();
list( $intCnt_diary , $intTotal_diary ) = $obj_diary->basedb_GetDiary ( 1 , -1 );

if($intTotal_diary==0){
	require_once( SYS_PATH."templates/error_all.tpl" );
	exit;
}

$obj_category1 = new basedb_CategoryClassTblAccess;
$obj_category1->conn = $obj_conn->conn;
$obj_category1->jyoken=array();
$obj_category1->jyoken["cg_clid"]=$obj_login->clientdat[0]['cl_id'];
$obj_category1->jyoken["cg_stat"]=1;
$obj_category1->jyoken["cg_id"]=$obj_diary->diarydat[0]['dr_cgid'];
$obj_category1->jyoken["cg_deldate"]=1;

$obj_category1->categorydat=array();
list( $intCnt_category1 , $intTotal_category1 ) = $obj_category1->basedb_GetCategory ( 1 , -1 );

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
		$age_check[4]='高校　';
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
		$age_check_list="<p>";
		foreach($age_check as $key3=>$val3){
			$age_check_list.=$val3;
		}
	$age_check_list.="</p>";
	}else{
		$age_check_list="<p>−</p>";
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
	$tc_comment=html_replace($tc_comment);
	
	$tc_box='
	<div class="box"><!--box start-->
		<table>
			<tr>
				<td class="td1a nopadding">
					<p class="marginbr1 center">'.$img_path.'</p>
				<p class="marginr1 center">'.htmlspecialchars($obj_teacher->teacherdat[0]['tc_name']).'</p></td>
					<td class="td1b nopadding">

					<div id="boxbloger_middle">
					<div id="boxbloger_top">
					<table id="boxbloger">
							<tr>
								<td class="td1a center middle bgblue">
									<p><span class="white"><em>担　当</em></span></p></td>
								<td class="td1b paddinglr1 bgwhite">
									'.$age_check_list.'
								</td>
							</tr>
							<tr>
								<td class="td1a center middle bgblue">
									<p><span class="white"><em>教　科</em></span></p></td>
								<td class="td1b paddinglr1 bgwhite">
									<p>'.$tc_subject.'</p></td>
							</tr>
							<tr>
								<td class="td1a center middle bgblue">
									<p><span class="white"><em>自己紹介</em></span></p></td>
								<td class="td1b paddinglr1 bgwhite">
									<p>'.$tc_comment.'</p>
								</td>
							</tr>
					</div>						
					</table>
					<div id="boxbloger_bottom">
				</div>
				</div>
				</td>
			</tr>
		</table>
	</div><!--box end-->
';
}

$img_path="";
$dispcnt="";
$dispcnt=count($obj_diary->diarydat)-1;
if($dispno>=0){
	
	$insert_year=substr($obj_diary->diarydat[0]['dr_insdate'],0,4);
	$insert_month=substr($obj_diary->diarydat[0]['dr_insdate'],5,2);
	$insert_day=substr($obj_diary->diarydat[0]['dr_insdate'],8,2);
	$mkdate_week=mktime (0,0,0,$insert_month,$insert_day,$insert_year);
	$insrert_week=substr("日月火水木金土", date("w", $mkdate_week)*2, 2);
	$insrert_date=$insert_year.'年'.$insert_month.'月'.$insert_day.'日';
}
$dr_contents=htmlspecialchars($obj_diary->diarydat[0]['dr_contents']);

$dr_contents=html_replace($dr_contents,$obj_diary->diarydat[0]['dr_img1'],$obj_diary->diarydat[0]['dr_img2'],$obj_diary->diarydat[0]['dr_img3'],$obj_diary->diarydat[0]['dr_img4'],1);
$dr_contents=htmlspecialchars_decode($dr_contents);
$view_blog='
<div class="box"><!--boxlittle start-->                 
	<table>
		<tr>
			<td  class="borderblue">
				<p>
					<span class="blue"><em>'.$insrert_date.'</em></span>
					<span class="blue"><em>'.$insrert_week.'曜日</em></span>
					<span class="normallink"><em>'.htmlspecialchars($obj_diary->diarydat[0]['dr_title']).'　　　　　（　<a href="'._BLOG_SITE_URL_BASE.'diary-list/p-0/dr-'.$obj_category1->categorydat[0]['cg_id'].'/">'.htmlspecialchars($obj_category1->categorydat[0]['cg_stitle']).'</a>　）</em></span>
				</p>
			</td>
		</tr>
	</table>
</div><!--box end-->

<div class="boxlittle"><!--boxlittle start-->                 
	<table>
		<tr>
			<td class="td8a">
				<p>'.nl2br($dr_contents).'</p>
			</td>
		</tr>
	</table>
</div>
<!--box end-->
';

/*
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

	<tr>
		<td class="nopadding">
			<table>
				<tr>
					'.$img_path[0].$img_path[1].$img_path[2].$img_path[3].'
				</tr>
			</table>
		</td>
	</tr>
*/


?>
