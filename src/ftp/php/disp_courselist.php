<?

if($_GET['csid']){
	$csid=$_GET['csid'];
}else{
	$csid="0";
}
if($_GET['page']){
	$page=$_GET['page'];
}else{
	$page="0";
}

$obj_category->jyoken=array();
$obj_category->jyoken["cg_clid"]=$obj_login->clientdat[0]['cl_id'];
$obj_category->jyoken["cg_stat"]=1;
$obj_category->jyoken["cg_id"]=$csid;
$obj_category->jyoken["cg_type"]=3;
$obj_category->jyoken["cg_deldate"]=1;
$obj_category->sort["cg_dispno"] = 2;
$obj_category->categorydat=array();
list( $intCnt_category , $intTotal_category ) = $obj_category->basedb_GetCategory ( 1 , -1 );


$start=$page*5 + 1;
$end=$start+4;
// 1ページあたり表示件数 ページ遷移バグ修正 2009/12/02 大塚
$get_cnt = 5;

$obj_course = new basedb_CourseClassTblAccess;
$obj_course->conn = $obj_conn->conn;
$obj_course->jyoken=array();
$obj_course->jyoken["cs_clid"]=$obj_login->clientdat[0]['cl_id'];
$obj_course->jyoken["cs_stat"]=1;
$obj_course->jyoken["cs_cgid"]=$csid;
$obj_course->jyoken["cs_deldate"]=1;
$obj_course->sort["cs_upddate"] = 2;
$obj_course->coursedat=array();
// ページ遷移バグ修正 2009/12/02 大塚	list( $intCnt_course , $intTotal_course ) = $obj_course->basedb_GetCourse ( $start , $end );
list( $intCnt_course , $intTotal_course ) = $obj_course->basedb_GetCourse ( $start , $get_cnt );

if($intTotal_course>0){
	if($start==($start+$intCnt_course-1)){
		$case_number=$intTotal_course.' 件中 '.$start." 件目を表示";
	}else{
		$case_number=$intTotal_course.' 件中 '.$start.' 〜 '.($start+$intCnt_course-1)." 件目を表示";
	}
}else{
	$case_number="";
}

$pagemax="";
$pagedown="";
$pageup="";
if($page>=1){
	$pagedown='<p class="search"><a href="'._BLOG_SITE_URL_BASE.'course-list/p-'.($page-1).'/cs-'.$csid.'/">前の5件を表示</a></p>';
}
if(($intTotal_course/5)-($page+1)>0){
	$pageup='<p class="search"><a href="'._BLOG_SITE_URL_BASE.'course-list/p-'.($page+1).'/cs-'.$csid.'/">次の5件を表示</a></p>';
}

$dispcnt="";
$dispcnt=count($obj_course->coursedat)-1;
if($dispcnt>=0){
	foreach($obj_course->coursedat as $key1=>$val1){
		if($obj_course->coursedat[$key1]['cs_img1']){
			$img_path='
<td class="nopadding">
	<p class="marginr1">
		<img src="./img_thumbnail.php?w=160&h=120&dir='.$param_cs_img1_path.'&nm='.$obj_course->coursedat[$key1]['cs_img1'].'" alt="" />
	</p>
</td>
';
			$cs_pr="";
			$cs_pr=html_delete($obj_course->coursedat[$key1]['cs_pr']);
	//		$cs_pr=htmlspecialchars($cs_pr);
			$cs_pr=strip_tags($cs_pr);
			$cs_pr=mb_substr($cs_pr,0,112,"EUC-JP").'．．．<a href="'._BLOG_SITE_URL_BASE.'course-detail-'.$obj_course->coursedat[$key1]['cs_id'].'/">（詳細はこちら）</a>';
		}else{
			$img_path='';
			$cs_pr="";
			$cs_pr=html_delete($obj_course->coursedat[$key1]['cs_pr']);
	//		$cs_pr=htmlspecialchars($cs_pr);
			$cs_pr=strip_tags($cs_pr);
			$cs_pr=mb_substr($cs_pr,0,168,"EUC-JP").'．．．<a href="'._BLOG_SITE_URL_BASE.'course-detail-'.$obj_course->coursedat[$key1]['cs_id'].'/">（詳細はこちら）</a>';
		}
		
		//対象
		$age_of=$obj_course->coursedat[$key1]['cs_age'];
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
		}
		
		//授業形態
		$school_of=$obj_course->coursedat[$key1]['cs_classform'];
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
		$level_of=$obj_course->coursedat[$key1]['cs_purpose'];
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
		$purpose_of=$obj_course->coursedat[$key1]['cs_purpose'];
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
		
		$start_time=substr($obj_course->coursedat[$key1]['cs_start'],0,5);
		$end_time=substr($obj_course->coursedat[$key1]['cs_end'],0,5);
		$execution_time=ltrim($start_time,"0")." 〜 ".ltrim($end_time,"0");
		
		if($obj_course->coursedat[$key1]['cs_jtitle']){
			$cs_jtitle=htmlspecialchars($obj_course->coursedat[$key1]['cs_jtitle']);
		}else{
			$cs_jtitle="−";
		}
		if($obj_course->coursedat[$key1]['cs_shisetsu']){
			$cs_shisetsu=htmlspecialchars($obj_course->coursedat[$key1]['cs_shisetsu']);
		}else{
			$cs_shisetsu="−";
		}
		
		if($key1==0){
			$course_list='
<div class="box"><!--box start-->
	<h3><span class="white">'.htmlspecialchars($obj_category->categorydat[0]['cg_stitle']).'</span></h3>
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
		
		$course_list.='
<div class="boxlittle"><!--box start-->
	<table class="tableforh4noback">
		<tr>
			<td class="nopadding">            
				<h4 class="h4noback white"><a href="'._BLOG_SITE_URL_BASE.'course-detail-'.$obj_course->coursedat[$key1]['cs_id'].'/">'.htmlspecialchars($obj_course->coursedat[$key1]['cs_title']).'</a></h4>
			</td>
			<td class="right paddingt2"> 
				<span class="small white paddingr1"><em><a href="'._BLOG_SITE_URL_BASE.'course-detail-'.$obj_course->coursedat[$key1]['cs_id'].'/">詳細</a></em></span>
			</td>
		</tr>
	</table>
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
										<p class="marginr1">'.$age_icon_list.'</p>
									</td>
									<td>
										<p class="marginr1">'.$school_icon_list.'</p>
									</td>
									<td>
										<p><span class="blue2"><em>'.htmlspecialchars($obj_course->coursedat[$key1]['cs_jtitle']).'</em></span></p>
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
					<p><em>目　的</em></p>
				</td>
				<td class="td6b middle paddinglr1 bordergraydotted">
					<p>'.$purpose_icon_list.'</p>
				</td>
				<td class="td6a center middle bggray">
					<p><em>対　象</em></p></td>
				<td class="td6b paddinglr1 bordergraydotted">
					'.$age_check_list.'
				</td>
			</tr>
			<tr>
				<td class="td6a center middle bggray">
					<p><em>科　目</em></p>
				</td>
				<td class="td6b middle paddinglr1 bordergraydotted">
					<p><span class="marginlr2">'.$cs_jtitle.'</span></p>
				</td>
				<td class="td6a center middle bggray">
					<p><em>期　間</em></p></td>
				<td class="td6b paddinglr1 bordergraydotted">
					<p><span class="marginlr2">'.$cs_shisetsu.'</span></p>
				</td>
			</tr>
		</table>
	<p class="detail margint2"><a href="'._BLOG_SITE_URL_BASE.'course-detail-'.$obj_course->coursedat[$key1]['cs_id'].'/">　　</a></p><br class="clear" />
</div><!--box end-->
';
	}
}

$course_list.='
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
</div><!--box end-->';
?>
