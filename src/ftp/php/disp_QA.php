<?

if($_GET['qa']){
	$qacategory=$_GET['qa'];
}else{
	$qacategory=0;
}

$obj_category->jyoken=array();
$obj_category->jyoken["cg_clid"]=$obj_login->clientdat[0]['cl_id'];
$obj_category->jyoken["cg_stat"]=1;
$obj_category->jyoken["cg_type"]=4;
$obj_category->jyoken["cg_deldate"]=1;
$obj_category->sort["cg_dispno"] = 2;

$obj_category->categorydat=array();
list( $intCnt_category , $intTotal_category ) = $obj_category->basedb_GetCategory ( 1 , -1 );

$obj_menu->jyoken["mn_clid"]=$obj_login->clientdat[0]['cl_id'];
$obj_menu->jyoken["mn_lstat"]=1;
$obj_menu->jyoken["mn_deldate"]=1;
$obj_menu->jyoken["mn_flg"] = 2;

$obj_menu->menudat=array();
list( $intCnt_menu , $intTotal_menu ) = $obj_menu->basedb_GetMenu ( 1 , -1 );

$obj_qa =new basedb_QaClassTblAccess;
$obj_qa->conn = $obj_conn->conn;

$dispcnt="";
$cnt=0;
$dispcnt=count($obj_category->categorydat)-1;
if($dispcnt>=0){
	foreach($obj_category->categorydat as $key1=>$val1){

		$obj_qa->jyoken=array();
		$obj_qa->jyoken["qa_clid"]=$obj_login->clientdat[0]['cl_id'];
		$obj_qa->jyoken["qa_stat"]=1;
		$obj_qa->jyoken["qa_deldate"]=1;
		$obj_qa->jyoken["qa_cgid"]=$obj_category->categorydat[$key1]['cg_id'];
		$obj_qa->sort["qa_dispno"] = 1;
		
		$obj_qa->qadat=array();
		list( $intCnt_qa , $intTotal_qa ) = $obj_qa->basedb_GetQa ( 1 , -1 );

		$img_path="";
		$dispcnt="";
		$dispcnt=count($obj_qa->qadat)-1;
		
		if($dispcnt>=0){
		
			foreach($obj_qa->qadat as $key2=>$val2){
			
				if($key2==0){
				$qa_title='<a name="link'.$obj_category->categorydat[$key1]['cg_id'].'"> '.htmlspecialchars($obj_category->categorydat[$key1]['cg_stitle']).'</a>';
			
				}else{
				$qa_title=htmlspecialchars($obj_category->categorydat[$key1]['cg_stitle']);
				}
			
				if($key2==0){
					if($key1>=1){
						$qa_link.=' / <a href="#link'.$obj_category->categorydat[$key1]['cg_id'].'">'.htmlspecialchars($obj_category->categorydat[$key1]['cg_stitle']).'</a>';
					}else{
						$qa_link.='<a href="#link'.$obj_category->categorydat[$key1]['cg_id'].'">'.htmlspecialchars($obj_category->categorydat[$key1]['cg_stitle']).'</a>';
					}
				}
				
				$qa_question=$obj_qa->qadat[$key2]['qa_question'];
				$qa_answer=$obj_qa->qadat[$key2]['qa_answer'];
				
				if($key2==0){
					$qa_list.='
	<div class="boxlittle"><!--box start-->                      
		<h4><span class="white">'.$qa_title.'</span></h4>
		<table>
			<tr>
				<td  class="borderblue">
					<p class="orange"><em>Ｑ．</em><em>'.nl2br($qa_question).'</em></p>
				</td>
			</tr>
			<tr>
				<td>
					<p><em>Ａ．</em>'.nl2br($qa_answer).'</p>
				</td>
			</tr>
		</table>
		<p class="pagetop"><span class="marginl1"><a href="#pagetop">ページトップへ</a></span><br /></p><br class="clear" /><!--to pagetop--> 
	</div><!--boxlittle end-->
	';
				}elseif($key2!=0){
					$qa_list.='
	<div class="boxlittle"><!--box start-->                      
		<table>
			<tr>
				<td  class="borderblue">
					<p class="orange"><em>Ｑ．</em><em>'.nl2br($qa_question).'</em></p>
				</td>
			</tr>
			<tr>
				<td>
					<p><em>Ａ．</em>'.nl2br($qa_answer).'</p>
				</td>
			</tr>
		</table>
		<p class="pagetop"><span class="marginl1"><a href="#pagetop">ページトップへ</a></span><br /></p><br class="clear" /><!--to pagetop--> 

	</div><!--boxlittle end-->
	';
				}/*elseif($key2==count($obj_qa->qadat)-1){
					$qa_list.='
	<div class="boxlittle"><!--box start-->                      
		<table>
			<tr>
				<td  class="borderblue">
					<p class="orange"><em>Ｑ．</em><em>'.nl2br($obj_qa->qadat[$key2]['qa_question']).'</em></p>
				</td>
			</tr>
			<tr>
				<td>
					<p><em>Ａ．</em>'.nl2br($obj_qa->qadat[$key2]['qa_answer']).'</p>
				</td>
			</tr>
		</table>
		<p class="pagetop margint2"><img src="share/images/item_arrow.gif" alt="" /><a href="#pagetop">ページトップへ</a></p>
	</div><!--boxlittle end-->
	';
				}*/
			}
		}else{
			$qa_title='<a name="link'.$obj_category->categorydat[$key1]['cg_id'].'"> '.htmlspecialchars($obj_category->categorydat[$key1]['cg_stitle']).'</a>';
			
			if($key1>=1){
				$qa_link.=' / <a href="#link'.$obj_category->categorydat[$key1]['cg_id'].'">'.htmlspecialchars($obj_category->categorydat[$key1]['cg_stitle']).'</a>';
			}else{
				$qa_link.='<a href="#link'.$obj_category->categorydat[$key1]['cg_id'].'">'.htmlspecialchars($obj_category->categorydat[$key1]['cg_stitle']).'</a>';
			}
			
			$qa_list.='
	<div class="boxlittle"><!--box start-->                      
		<h4><span class="white">'.$qa_title.'</span></h4>
		<p class="pagetop"><span class="marginl1"><a href="#pagetop">ページトップへ</a></span><br /></p><br class="clear" /><!--to pagetop--> 
	</div><!--boxlittle end-->
';                   
		}
	}
}	

?>
