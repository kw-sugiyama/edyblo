<?

$obj_category->jyoken=array();
$obj_category->jyoken["cg_clid"]=$obj_login->clientdat[0]['cl_id'];
$obj_category->jyoken["cg_stat"]=1;
$obj_category->jyoken["cg_type"]=2;
$obj_category->jyoken["cg_deldate"]=1;
$obj_category->sort["cg_dispno"] = 2;

$obj_category->categorydat=array();
list( $intCnt_category , $intTotal_category ) = $obj_category->basedb_GetCategory ( 1 , -1 );

$obj_menu->jyoken["mn_clid"]=$obj_login->clientdat[0]['cl_id'];
$obj_menu->jyoken["mn_lstat"]=1;
$obj_menu->jyoken["mn_deldate"]=1;
$obj_menu->jyoken["mn_flg"] = 3;

$obj_menu->menudat=array();
list( $intCnt_menu , $intTotal_menu ) = $obj_menu->basedb_GetMenu ( 1 , -1 );



$obj_admission =new basedb_AdmissionClassTblAccess;
$obj_admission->conn = $obj_conn->conn;


$dispcnt="";
$dispcnt=count($obj_category->categorydat)-1;
$admission_list="";
if($dispcnt>=0){
	foreach($obj_category->categorydat as $key1=>$val1){
		
		$obj_admission->jyoken=array();
		$obj_admission->jyoken["as_clid"]=$obj_login->clientdat[0]['cl_id'];
		$obj_admission->jyoken["as_stat"]=1;
		$obj_admission->jyoken["as_type"]=2;
		$obj_admission->jyoken["as_deldate"]=1;
		$obj_admission->jyoken["as_cgid"]=$obj_category->categorydat[$key1]['cg_id'];
		$obj_admission->sort["as_dispno"] = 3;
		
		$obj_admission->admissiondat=array();
		list( $intCnt_admission , $intTotal_admission ) = $obj_admission->basedb_GetAdmission ( 1 , -1 );

		$img_path="";
		$dispcnt="";
		$dispcnt=count($obj_admission->admissiondat)-1;
		if($dispcnt>=0){
			foreach($obj_admission->admissiondat as $key2=>$val2){

				if($obj_admission->admissiondat[$key2]['as_img']){
					$img_path='<p class="marginr1"><img src="./img_thumbnail.php?w=160&h=120&dir='.$param_admission_img_path.'&nm='.$obj_admission->admissiondat[$key2]['as_img'].'" alt="" /></p>';
				}else{
					$img_path='';
				}
				
				$as_contents=$obj_admission->admissiondat[$key2]['as_contents'];
				
				if($key1>=1 && $key2==0){//やじるし付加
					$admission_list.='
<div class="boxlittlenomargin"><!--box start-->                      
	<p class="marginb1 center"><img src="share/images/item_allowbig.gif" alt="" /></p>
</div><!--boxlittle end-->
';
				}
				if($key2==0){
					$admission_list.='
<div class="boxlittle"><!--box start-->                      
	<h4><span class="white">'.htmlspecialchars($obj_category->categorydat[$key1]['cg_stitle']).'</span></h4>
';
				}else{
					$admission_list.='
<div class="boxlittle"><!--box start-->                      
';
				}
				if( $img_path != "" ){
				$admission_list.='
	<table>
		<tr>
			<td class="nopadding">
				'.$img_path.'
			</td>
			<td class="td3b nopadding">
			<table>
				<tr>
					<td class="borderblue">
						<p><span class="blue2"><em>'.htmlspecialchars($obj_admission->admissiondat[$key2]['as_title']).'</em></span></p>
					</td>
				</tr>
				<tr>
					<td>
						<p>'.nl2br($as_contents).'</p>
					</td>
				</tr>
			</table>
			</td>
		</tr>
	</table>
</div><!--boxlittle end-->
';
				}else{
				$admission_list.='
	<table>
		<tr>
			<td class="td3b nopadding">
			<table>
				<tr>
					<td class="borderblue">
						<p><span class="blue2"><em>'.htmlspecialchars($obj_admission->admissiondat[$key2]['as_title']).'</em></span></p>
					</td>
				</tr>
				<tr>
					<td>
						<p>'.nl2br($as_contents).'</p>
					</td>
				</tr>
			</table>
			</td>
		</tr>
	</table>
</div><!--boxlittle end-->
';
				}
			}
		}else{
		if($key1>=1){
			$admission_list.='
<div class="boxlittlenomargin"><!--box start-->                      
	<p class="marginb1 center"><img src="share/images/item_allowbig.gif" alt="" /></p>
</div><!--boxlittle end-->
';
		}
		$admission_list.='
<div class="boxlittle"><!--box start-->                      
	<h4><span class="white">'.htmlspecialchars($obj_category->categorydat[$key1]['cg_stitle']).'</span></h4>
</div><!--boxlittle end-->
';
		}
	}
}

$school_box_title=htmlspecialchars($obj_menu->menudat[0]['mn_lname']);
$school_box_contents=htmlspecialchars($obj_login->clientdat[0]['sc_addmission']);
$school_box_contents=nl2br($school_box_contents);
if($obj_login->clientdat[0]['sc_topimg']){
	$school_box_img='<img src="./img_thumbnail.php?w=200&h=160&dir='.$param_cl_photo_path.'&nm='.$obj_login->clientdat[0]['sc_topimg'].'" alt="" />';
}else{
	$school_box_img="";
}
$school_box='
<div class="box"><!--box start-->
<h3><span class="white">'.$school_box_title.'</span></h3>
<table>
	<tr>
		<td class="nopadding">
			<p class="marginr1">'.$school_box_img.'</p></td>
		<td class="nopadding">
		<table>
			<tr>
				<td>
					<p>'.$school_box_contents.'</p>
				</td>
			</tr>
		</table>
		</td>
	</tr>
</table>

</div><!--box end-->
';
?>
