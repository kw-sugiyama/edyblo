<?

foreach($_POST as $key=>$val){
	$hidden.='<INPUT type="hidden" name="'.$key.'" value="'.$val.'" />
	';
}

$obj_course = new basedb_CourseClassTblAccess;
$obj_course->conn = $obj_conn->conn;
$obj_course->jyoken=array();
$obj_course->jyoken["cs_clid"]=$obj_login->clientdat[0]['cl_id'];
$obj_course->jyoken["cs_stat"]=1;
$obj_course->jyoken["cs_id"]=$_POST['csid'];
$obj_course->jyoken["cs_deldate"]=1;
$obj_course->coursedat=array();
list( $intCnt_course , $intTotal_course ) = $obj_course->basedb_GetCourse ( 1 , -1 );

if($obj_course->coursedat[0]['cs_img1']){
	$img_path='
<td class="nopadding">
	<p class="marginr1">
		<img src="./img_thumbnail.php?w=145&h=91&dir='.$param_cs_img1_path.'&nm='.$obj_course->coursedat[0]['cs_img1'].'" alt="" />
	</p>
</td>
';
}else{
	$img_path='
<td class="nopadding">
	<p class="marginr1">
	</p>
</td>
';
}

$execution_time="";
if($obj_course->coursedat[0]['cs_start'] && $obj_course->coursedat[0]['cs_end']){
	$start_time=substr($obj_course->coursedat[0]['cs_start'],0,5);
	$end_time=substr($obj_course->coursedat[0]['cs_end'],0,5);
	$execution_time=ltrim($start_time,"0")." 〜 ".ltrim($end_time,"0");
}

$cs_shisetsu="";
if($obj_course->coursedat[0]['cs_shisetsu']){
	$cs_shisetsu=htmlspecialchars($obj_course->coursedat[0]['cs_shisetsu']);
}

if(!$execution_time && !$cs_shisetsu){
	$execution_times='<p>−</p>';
}else{
	$execution_times='<p>'.$cs_shisetsu.'</p><p>'.$execution_time.'</p>';
}

$age_of=$obj_course->coursedat[0]['cs_age'];
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

		

$course_list='
					<div class="boxlittlemargin"><!--box start-->
						<h4 class="white">'.$obj_course->coursedat[0]['cs_title'].'</h4>
						<table>
							<tr>
								'.$img_path.'
								<td class="nopadding">

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
												'.$execution_times.'
											</td>
										</tr>
									</table>
               
								</td>
							</tr>
						</table>
					</div><!--boxlittle end-->
';

?>
