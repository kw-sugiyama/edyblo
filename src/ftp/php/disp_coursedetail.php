<?
if($_GET['csid']){
	$csid=$_GET['csid'];
}else{
	$csid="error";
}

$obj_course = new basedb_CourseClassTblAccess;
$obj_course->conn = $obj_conn->conn;
$obj_course->jyoken=array();
$obj_course->jyoken["cs_clid"]=$obj_login->clientdat[0]['cl_id'];
$obj_course->jyoken["cs_stat"]=1;
$obj_course->jyoken["cs_id"]=$csid;
$obj_course->jyoken["cs_deldate"]=1;

$obj_course->coursedat=array();
list( $intCnt_course , $intTotal_course ) = $obj_course->basedb_GetCourse ( 1 , -1 );

if($intTotal_course==0){
	require_once( SYS_PATH."templates/error_all.tpl" );
	exit;
}

$obj_category1 = new basedb_CategoryClassTblAccess;
$obj_category1->conn = $obj_conn->conn;
$obj_category1->jyoken=array();
$obj_category1->jyoken["cg_clid"]=$obj_login->clientdat[0]['cl_id'];
$obj_category1->jyoken["cg_stat"]=1;
$obj_category1->jyoken["cg_id"]=$obj_course->coursedat[0]['cs_cgid'];
$obj_category1->jyoken["cg_deldate"]=1;

$obj_category1->categorydat=array();
list( $intCnt_category1 , $intTotal_category1 ) = $obj_category1->basedb_GetCategory ( 1 , -1 );

$obj_teacher = new basedb_TeacherClassTblAccess;
$obj_teacher->conn = $obj_conn->conn;
$obj_teacher->jyoken=array();
$obj_teacher->jyoken["tc_id"]=$obj_course->coursedat[0]['cs_tcid'];
$obj_teacher->jyoken["tc_deldate"]=1;

$obj_teacher->teacherdat=array();
$tc_box="";
$img_path="";
if($obj_course->coursedat[0]['cs_tcid']){
	list( $intCnt_teacher , $intTotal_teacher ) = $obj_teacher->basedb_GetTeacher ( 1 , -1 );

	if($obj_teacher->teacherdat[0]['tc_img']){
		$img_path='<img src="./img_thumbnail.php?w=84&h=100&dir='.$param_tc_img_path.'&nm='.$obj_teacher->teacherdat[0]['tc_img'].'" alt="" />';
	}
	
	if($obj_teacher->teacherdat[0]['tc_comment']){
		$tc_comment=htmlspecialchars($obj_course->coursedat[0]['cs_tccomment']);
		$tc_comment=html_replace($tc_comment);
//		$tc_comment=htmlspecialchars_decode($tc_comment);
	}

	$tc_comment='
				<td class="td1b nopadding">
				 <div id="boxbloger_middle">
						<div id="boxbloger_top">
							<table id="boxbloger">
								<tr>
									<td class="bgwhite bordergraydotted paddinglr1">
										<p><em>コメント・メッセージ</em></p>
									</td>
								</tr>
								<tr>
									<td class="bgwhite paddinglr1">
										<p>'.nl2br($tc_comment).'</p>
									</td>
								</tr>
							</table>
					<div id="boxbloger_bottom"></div>
						</div>
					</div>
				</td>
';
	$tc_box='
	<div class="box"><!--box start-->
		<table>
			<tr>
				<td class="td1a nopadding">
					<p class="marginbr1 center">'.$img_path.'</p>
					<p class="marginr1 center">'.htmlspecialchars($obj_teacher->teacherdat[0]['tc_name']).'</p>
				</td>
				'.$tc_comment.'
			</tr>
		</table>
	</div><!--box end-->
';
}

$course_list="";
$img_path="";


if($obj_course->coursedat[0]['cs_img1']){
$img_path='
<td class="nopadding">
	<p class="marginr1">
		<a href="'.$param_cs_img1_path.$obj_course->coursedat[0]['cs_img1'].'" class="highslide" onclick="return hs.expand(this)" onkeypress="return hs.expand(this)"><img src="./img_thumbnail.php?w=160&h=120&dir='.$param_cs_img1_path.'&nm='.$obj_course->coursedat[0]['cs_img1'].'" alt="" /></a>
	</p>
</td>
';
}else{
			$img_path='';
}

//対象
$age_of=$obj_course->coursedat[0]['cs_age'];
$age_check=array();
$age_icon=array();
$age_check_list="";
$age_icon_list="";
if(($age_of & 64)==64){
	$age_check[7]='<span class="marginlr2">社会人　</span>';
	$age_icon[7]='<img src="./share/icons/item_syakaijin_5.gif" alt="" />　';
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
	$age_check[4]='<span class="marginlr2">高校生　</span>';
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
	foreach($age_check as $key3=>$val3){
		$age_check_list.=$val3;
	}
}else{
	$age_check_list="−";
}

if(count($age_icon)){
	ksort($age_icon);
	foreach($age_icon as $key4=>$val4){
		$age_icon_list.=$val4;
	}
}

//授業形態
$school_of=$obj_course->coursedat[0]['cs_classform'];
$school_check=array();
$school_icon=array();
$school_check_list="";
$school_icon_list="";
if(($school_of & 4)==4){
	$school_check[3]='<span class="marginlr2">個別</span>';
	$school_icon[3]='<img src="./share/icons/item_kobetsu_4.gif" alt="" />　';
	$school_of-=4;
}
if(($school_of & 2)==2){
	$school_check[2]='<span class="marginlr2">少人数</span>';
	$school_icon[2]='<img src="./share/icons/item_shouninzu_4.gif" alt="" />　';
	$school_of-=2;
}
if(($school_of & 1)==1){
	$school_check[1]='<span class="marginlr2">集団</span>';
	$school_icon[1]='<img src="./share/icons/item_shudan_4.gif" alt="" />　';
	$school_of-=1;
}
if(count($school_check)){
	ksort($school_check);
	foreach($school_check as $key3=>$val3){
		$school_check_list.=$val3;
	}
}else{
	$school_check_list="−";
}
if(count($school_icon)){
	ksort($school_icon);
	foreach($school_icon as $key4=>$val4){
		$school_icon_list.=$val4;
	}
}

//レベル
$level_of="";
$level_of=$obj_course->coursedat[0]['cs_level'];
$level_check=array();
$level_icon=array();
$level_icon_list="";
if(($level_of & 8)==8){
	$level_check[4]='<span class="marginlr2">最難関</span>';
	$level_icon[4]='<img src="./share/icons/item_sainankan_2.gif" alt="" />　';
	$level_of-=8;
}
if(($level_of & 4)==4){
	$level_check[3]='<span class="marginlr2">難関</span>';
	$level_icon[3]='<img src="./share/icons/item_nankan_2.gif" alt="" />　';
	$level_of-=4;
}
if(($level_of & 2)==2){
	$level_check[2]='<span class="marginlr2">中堅</span>';
	$level_icon[2]='<img src="./share/icons/item_chuken_2.gif" alt="" />　';
	$level_of-=2;
}
if(($level_of & 1)==1){
	$level_check[1]='<span class="marginlr2">基礎</span>';
	$level_icon[1]='<img src="./share/icons/item_kiso_2.gif" alt="" />　';
	$level_of-=1;
}
if(count($level_icon)){
	ksort($level_icon);
	foreach($level_icon as $key4=>$val4){
		$level_icon_list.=$val4;
	}
}else{
	$level_icon_list="−";
}

//目的
$purpose_of="";
$purpose_of=$obj_course->coursedat[0]['cs_purpose'];
$purpose_check=array();
$purpose_icon=array();
$purpose_check_list="";
$purpose_icon_list="";
if(($purpose_of & 4)==4){
	$purpose_check[3]='<span class="marginlr2">検定</span>';
	$purpose_icon[3]='<img src="./share/icons/item_kentei_2.gif" alt="" /> ';
	$purpose_of-=4;
}
if(($purpose_of & 2)==2){
	$purpose_check[2]='<span class="marginlr2">補修</span>';
	$purpose_icon[2]='<img src="./share/icons/item_hoshu_2.gif" alt="" />　';
	$purpose_of-=2;
}
if(($purpose_of & 1)==1){
	$purpose_check[1]='<span class="marginlr2">受験</span>';
	$purpose_icon[1]='<img src="./share/icons/item_juken_2.gif" alt="" />　';
	$purpose_of-=1;
}
if(count($purpose_check)){
	ksort($purpose_check);
	foreach($purpose_check as $key3=>$val3){
		$purpose_check_list.=$val3;
	}
}else{
	$purpose_check_list="−";
}
if(count($purpose_icon)){
	ksort($purpose_icon);
	foreach($purpose_icon as $key4=>$val4){
		$purpose_icon_list.=$val4;
	}
}else{
	$purpose_icon_list="−";
}

$start_time=substr($obj_course->coursedat[0]['cs_start'],0,5);
$end_time=substr($obj_course->coursedat[0]['cs_end'],0,5);

if($start_time !="" || $end_time !="" ){
	$execution_time=ltrim($start_time,"0")." 〜 ".ltrim($end_time,"0");
}else{
	$execution_time="−";
}

if($obj_course->coursedat[0]['cs_jtitle']){
	$cs_jtitle=htmlspecialchars($obj_course->coursedat[0]['cs_jtitle']);
}else{
	$cs_jtitle="−";
}

if($obj_course->coursedat[0]['cs_shisetsu']){
	$cs_shisetsu=htmlspecialchars($obj_course->coursedat[0]['cs_shisetsu']);
}else{
	$cs_shisetsu="−";
}

if($obj_course->coursedat[0]['cs_week']){
	$cs_week=htmlspecialchars($obj_course->coursedat[0]['cs_week']);
}else{
	$cs_week="−";
}
if($obj_course->coursedat[0]['cs_textfee']){
	$cs_textfee=htmlspecialchars($obj_course->coursedat[0]['cs_textfee']);
}else{
	$cs_textfee="−";
}

if( $obj_course->coursedat[0]['cs_organize'] ) {
	$sc_organize=htmlspecialchars($obj_course->coursedat[0]['cs_organize']);
}else{
	$sc_organize="−";
}

$cs_pr=htmlspecialchars($obj_course->coursedat[0]['cs_pr']);
$cs_pr=html_replace($cs_pr);
$cs_pr=htmlspecialchars_decode($cs_pr);
$cs_pr=nl2br($cs_pr);
			
			//<a href="#">'.$obj_course->coursedat[0]['cs_title'].'</a>　（<a href="'._BLOG_SITE_URL_BASE.'course-list/p-0/cs-'.$obj_category1->categorydat[0]['cg_id'].'/">'.$obj_category1->categorydat[0]['cg_stitle'].'</a>）
$course_list.='
<div class="box"><!--box start-->
	<h3><span class="white">'.htmlspecialchars($obj_course->coursedat[0]['cs_title']).'</span></h3>
	<table>
		<tr>
			'.$img_path.'
			<td class="td3b nopadding">
				<table>
					<tr>
						<td class="borderblue">
							<table class="widthauto">
								<tr>
									<td>
										<p class="marginr1">'.$age_icon_list.'
										</p>
									</td>
									<td>
										<p class="marginr1">'.$school_icon_list.'</p>
									</td>
									<td>
										<p><span class="blue2"><em>'.htmlspecialchars($obj_course->coursedat[0]['cs_jtitle']).'</em></span></p>
									</td>
								</tr>
							</table>
						</td>
					</tr>
					<tr>
						<td>
							<p>'.$cs_pr.'</p>
						</td>
					</tr>
				</table>
			</td>
		</tr>
	</table>
				
	<table class="margint2">
		<tr>
			<td class="td6a center middle bggray">
				<p><em>レベル</em></p></td>
			<td class="td6b paddinglr1 bordergraydotted">
				<p>'.$level_icon_list.'</p>
			</td>
			<td class="td6a center middle bggray">
				<p><em>目　的</em></p>
			</td>
			<td class="td6b middle paddinglr1 bordergraydotted">
				<p>'.$purpose_icon_list.'</p>
			</td>
		</tr>
		<tr>
			<td class="td6a center middle bggray">
				<p><em>対　象</em></p></td>
			<td class="td6b paddinglr1 bordergraydotted">
				<p>'.$age_check_list.'</p>
			</td>
			<td class="td6a center middle bggray">
				<p><em>科　目</em></p>
			</td>
			<td class="td6b middle paddinglr1 bordergraydotted">
				<p><span class="marginlr2">'.$cs_jtitle.'</span></p>
			</td>
		</tr>
		<tr>
			<td class="td6a center middle bggray">
				<p><em>期　間</em></p></td>
			<td class="td6b paddinglr1 bordergraydotted">
				<p><span class="marginlr2">'.nl2br($cs_shisetsu).'</span></p>
			</td>
			<td class="td6a center middle bggray">
				<p><em>授業形態</em></p>
			</td>
			<td class="td6b middle paddinglr1 bordergraydotted">
				<p>'.$school_check_list.'</p>
			</td>
		</tr>
		<tr>
			<td class="td6a center middle bggray">
				<p><em>実施曜日</em></p>
			</td>
			<td class="td6b middle paddinglr1 bordergraydotted">
				<p><span class="marginlr2">'.$cs_week.'</span></p>
			</td>
			<td class="td6a center middle bggray">
				<p><em>実施時間</em></p></td>
			<td class="td6b paddinglr1 bordergraydotted">
				<p><span class="marginlr2">'.$execution_time.'</span></p>
			</td>
		</tr>
		<tr>
			<td class="td6a center middle bggray">
				<p><em>クラス編成</em></p></td>
			<td class="td6b paddinglr1 bordergraydotted">
				<p><span class="marginlr2">'.nl2br($sc_organize).'</span></p>
			</td>
			<td class="td6a center middle bggray">
				<p><em>教材</em></p>
			</td>
			<td class="td6b middle paddinglr1 bordergraydotted">
				<p><span class="marginlr2">'.nl2br($cs_textfee).'</span></p>
			</td>
		</tr>
	</table>
</div><!--box end-->
';

$obj_category= new basedb_CategoryClassTblAccess;
$obj_category->conn = $obj_conn->conn;
$obj_category->jyoken=array();
$obj_category->jyoken["cg_clid"]=$obj_course->coursedat[0]['cs_id'];
$obj_category->jyoken["cg_type"]=7;
$obj_category->jyoken["cg_stat"]=1;
$obj_category->jyoken["cg_deldate"] = 1;
$obj_category->sort["cg_dispno"] = 2;

$obj_category->categorydat=array();
list( $intCnt_category , $intTotal_category ) = $obj_category->basedb_GetCategory ( 1 , -1 );

$dispcnt="";
$dispcnt=count($obj_category->categorydat)-1;
if($dispcnt>=0){
	foreach($obj_category->categorydat as $key1=>$va1){
	
		$obj_csarticle = new basedb_CsarticleClassTblAccess;
		$obj_csarticle->conn = $obj_conn->conn;
		$obj_csarticle->jyoken=array();
		$obj_csarticle->jyoken["csa_csid"]=$obj_category->categorydat[$key1]['cg_id'];
		$obj_csarticle->jyoken["csa_stat"]=1;
		$obj_csarticle->jyoken["csa_deldate"]=1;
		$obj_csarticle->sort["csa_dispno"] = 1;
		
		$obj_csarticle->csarticledat=array();
		list( $intCnt_csarticle , $intTotal_csarticle ) = $obj_csarticle->basedb_GetCsarticle ( 1 , -1 );
		
		$dispcnt="";
		$dispcnt=count($obj_csarticle->csarticledat)-1;
		if($dispcnt>=0){
			foreach($obj_csarticle->csarticledat as $key2=>$va2){
				if($key2==0){
					$course_list.='
<div class="boxlittle"><!--box start-->
	<h4><span class="white">'.htmlspecialchars($obj_category->categorydat[$key1]['cg_stitle']).'</span></h4>
';
				}
				
				$csa_contents=$obj_csarticle->csarticledat[$key2]['csa_contents'];
				
				$img_path="";
				if($obj_csarticle->csarticledat[$key2]['csa_img']){
					$img_path='
<td class="nopadding">
	<p class="marginr1">
			<a href="'.$param_csarticle_img_path.$obj_csarticle->csarticledat[$key2]['csa_img'].'" class="highslide" onclick="return hs.expand(this)" onkeypress="return hs.expand(this)"><img src="./img_thumbnail.php?w=150&h=120&dir='.$param_csarticle_img_path.'&nm='.$obj_csarticle->csarticledat[$key2]['csa_img'].'" alt="" /></a>	</p>
</td>';
				}else{
					$img_path='';
				}
						
				if($obj_csarticle->csarticledat[$key2]['csa_img']){
					$course_list.='
									<table class="margint2">
										<tr>
											'.$img_path.'
											<td class="td3b nopadding">
												<table>
													<tr>
														<td class="borderblue">
															<p><span class="blue2"><em>'.htmlspecialchars($obj_csarticle->csarticledat[$key2]['csa_title']).'</em></span></p>
														</td>
													</tr>
													<tr>
														<td>
															<div style="color:#333333;font-family:\'ＭＳ Ｐゴシック\',Osaka;font-size:12px;font-style:normal;font-weight:normal;line-height:1.5;";>'.nl2br($csa_contents).'</div>
														</td>
													</tr>
												</table>
											
											</td>
										</tr>
									</table>
';
				}else{
							$course_list.='					                  
									<table>
										<tr>
											<td class="borderblue">
												<p><span class="blue2"><em>'.htmlspecialchars($obj_csarticle->csarticledat[$key2]['csa_title']).'</em></span></p>
											</td>
										</tr>
										<tr>
											<td>
												<div style="color:#333333;font-family:\'ＭＳ Ｐゴシック\',Osaka;font-size:12px;font-style:normal;font-weight:normal;line-height:1.5;";>'.nl2br($csa_contents).'</div>
											</td>
										</tr>
									</table>
';
				}
			}
		$course_list.='</div><!--boxlittle end-->';
		}else{
			$course_list.='
<div class="boxlittle"><!--box start-->
	<h4><span class="white">'.htmlspecialchars($obj_category->categorydat[$key1]['cg_stitle']).'</span></h4>
</div><!--boxlittle end-->';
		}
	}
}

// メール内に記載する詳細ページURL 20090828
$url="";
//$url=_BLOG_SITE_URL_BASE.'course-detail-'.$csid.'/';
if( $obj_login->clientdat[0]["cl_dokuji_flg"] == 1 && $obj_login->clientdat[0]["cl_dokuji_domain"] != "" ) {
	// 独自ドメインの場合
	$url=$obj_login->clientdat[0]["cl_dokuji_domain"].'course-detail-'.$csid.'/';
} else {
//	$url=$param_base_blog_addr_url.'/course-detail-'.$csid.'/';
	$url=$param_base_blog_addr_url.'/'.$obj_login->clientdat[0]["cl_urlcd"].'/course-detail-'.$csid.'/';
}

?>
