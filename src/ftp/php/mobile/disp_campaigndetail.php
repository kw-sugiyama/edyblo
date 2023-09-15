<?
//装飾変数==========================
$mark ='<font color="#FFC000">*</font>';
//=====================================================================
if($_GET['cpid']){
  $cpid=$_GET['cpid'];
}else{
  $cpid="error";
}
//=====================================================================
//関数追加(htmltag除去 変換)
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
$timestamp='(timestamp \''.date("Y").'-'.date("m").'-'.date("d").' 00:00:00\')';
$obj_campaign                            = new basedb_CampainClassTblAccess;
$obj_campaign->conn                      = $obj_conn->conn;
$obj_campaign->jyoken                    = array();
$obj_campaign->jyoken["cp_clid"]         = $obj_login->clientdat[0]['cl_id'];
$obj_campaign->jyoken["cp_stat"]         = 1;
$obj_campaign->jyoken["cp_id"]           = $cpid;
$obj_campaign->jyoken["cp_deldate"]      = 1;
$obj_campaign->jyoken["cp_publishstart"] = $timestamp;
$obj_campaign->jyoken["cp_publishend"]   = $timestamp;
$obj_campaign->campaindat=array();
list( $intCnt_campaign , $intTotal_campaign ) = $obj_campaign->basedb_GetCampain ( 1 , -1 );

$title = $obj_campaign->campaindat[0][0];

if($intTotal_campaign==0){
  require_once( SYS_PATH."templates/mobile/error_all.tpl" );
  exit;
}
$obj_category1                       = new basedb_CategoryClassTblAccess;
$obj_category1->conn                 = $obj_conn->conn;
$obj_category1->jyoken               = array();
$obj_category1->jyoken["cg_clid"]    = $obj_login->clientdat[0]['cl_id'];
$obj_category->jyoken["cg_type"]=8;
$obj_category1->jyoken["cg_stat"]    = 1;
$obj_category1->jyoken["cg_id"]      = $obj_campaign->campaindat[0]['cp_cgid'];
$obj_category1->jyoken["cg_deldate"] = 1;

$obj_category1->categorydat=array();
list( $intCnt_category1 , $intTotal_category1 ) = $obj_category1->basedb_GetCategory ( 1 , -1 );

$obj_teacher                       = new basedb_TeacherClassTblAccess;
$obj_teacher->conn                 = $obj_conn->conn;
$obj_teacher->jyoken               = array();
$obj_teacher->jyoken["tc_id"]      = $obj_campaign->campaindat[0]['cp_tcid'];
$obj_teacher->jyoken["tc_deldate"] = 1;
$obj_teacher->teacherdat           = array();
$tc_box="";
$img_path="";
if($obj_campaign->campaindat[0]['cp_tcid']){
  list( $intCnt_teacher , $intTotal_teacher ) = $obj_teacher->basedb_GetTeacher ( 1 , -1 );

  if($obj_teacher->teacherdat[0]['tc_img']){
    $img_path='<img src="./img_thumbnail.php?w=84&h=100&dir='.$param_tc_img_path.'&nm='.$obj_teacher->teacherdat[0]['tc_img'].'" alt=""   />';
  }
  if($obj_teacher->teacherdat[0]['tc_comment']){
    $tc_comment=htmlspecialchars($obj_campaign->campaindat[0]['cp_tccomment']);
	 $tc_comment=strip_between_tag($tc_comment,$srr_tag);
	 //$tc_comment=strip_tags($tc_comment);
    $tc_comment=html_replace($tc_comment);
  }
  $tc_comment='
    <div>
    <div>
    コメント・メッセージ<br>
    <br><font size="1">'.nl2br($tc_comment).'
    </div>
    </div>
    <div></div>
    ';	
  $tc_box='
    <div><!--box start--><center>
    <br><font size="1">'.$img_path.'</center>
    <br><font size="1">'.htmlspecialchars($obj_teacher->teacherdat[0]['tc_name']).'
    '.$tc_comment.'
    </div><!--box end-->
    ';
}
$campaign_list="";
$img_path="";

if($obj_campaign->campaindat[0]['cp_img1']){
	 $img_path='<br><img src="./img_thumbnail.php?w=160&h=120&dir='.$param_cp_img1_path.'&nm='.$obj_campaign->campaindat[0]['cp_img1'].'" alt=""  />
		  
		  </a>';
}else{
  $img_path='';
}

$age_of         = $obj_campaign->campaindat[0]['cp_age'];
$age_check      = array();
$age_icon       = array() ;
$age_check_list = "";
$age_icon_list  = "" ;
if(($age_of & 64)==64){
  $age_check[7]='社会人　';
  $age_icon[7]='<img src="./share/icons/item_syakaijin_5.gif" alt="" width="45" height="30" />';
  $age_of-=64;
}
if(($age_of & 32)==32){
  $age_check[6]='大学生　';
  $age_icon[6]='<img src="./share/icons/item_daigaku_5.gif" alt="" width="45" height="30" />　';
  $age_of-=32;
}
if(($age_of & 16)==16){
  $age_check[5]='浪人生　';
  $age_icon[5]='<img src="./share/icons/item_ronin_5.gif" alt="" width="45" height="30" />　';
  $age_of-=16;
}
if(($age_of & 8)==8){
  $age_check[4]='高校生　';
  $age_icon[4]='<img src="./share/icons/item_koukou_5.gif" alt="" width="45" height="30" />　';
  $age_of-=8;
}
if(($age_of & 4)==4){
  $age_check[3]='中学生　';
  $age_icon[3]='<img src="./share/icons/item_chugaku_5.gif" alt="" width="45" height="30" />　';
  $age_of-=4;
}
if(($age_of & 2)==2){
  $age_check[2]='小学生　';
  $age_icon[2]='<img src="./share/icons/item_shougaku_5.gif" alt="" width="45" height="30" />　';
  $age_of-=2;
}
if(($age_of & 1)==1){
  $age_check[1]='幼児　';
  $age_icon[1]='<img src="./share/icons/item_youji_5.gif" alt="" width="45" height="30" />　';
  $age_of-=1;
}

if(count($age_check)){
  ksort($age_check) ;
  $age_check_list="";
  foreach($age_check as $key3=>$val3){
    $age_check_list.=$val3;
  }
  $age_check_list.="" ;
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

$start_year ="";
$start_month="";
$start_day  ="";
$start_date ="";
$end_year   ="";
$end_month  ="";
$end_day    ="";
$end_date   ="";
$publishing_period="";

if($obj_campaign->campaindat[0]['cp_camstart'] || $obj_campaign->campaindat[0]['cp_camend']){
  $start_year  = substr($obj_campaign->campaindat[0]['cp_camstart'],0,4);
  $start_month = substr($obj_campaign->campaindat[0]['cp_camstart'],5,2);
  $start_day   = substr($obj_campaign->campaindat[0]['cp_camstart'],8,2);
  $start_date  = $start_year.'年'.$start_month.'月'.$start_day.'日';
  $end_year    = substr($obj_campaign->campaindat[0]['cp_camend'],0,4);
  $end_month   = substr($obj_campaign->campaindat[0]['cp_camend'],5,2);
  $end_day     = substr($obj_campaign->campaindat[0]['cp_camend'],8,2);
  $end_date    = $end_year.'年'.$end_month.'月'.$end_day.'日';

  $publishing_period=ltrim($start_date,"0")." 〜 ".ltrim($end_date,"0");
}else{
  $publishing_period="−";
}


$cp_contents =strip_between_tag($obj_campaign->campaindat[0]['cp_contents'],$srr_tag);
$cp_contents =strip_tags($cp_contents);
$cp_contents =htmlspecialchars($cp_contents);

$campaign_listA='
  <div><!--box start-->
  <font size="1">'.htmlspecialchars($obj_campaign->campaindat[0]['cp_title']).'

  ';
$campaign_listB='
 <center> '.$img_path.'<br /></center>
  <font size="1">'.nl2br($cp_contents).'<br>
  ';


if($age_check_list=="−"){}else{
$campaign_listB.='
<font size="1">'.$mark.'<font size="1" color="#538ED5">対　象</font><br>
<font size="1">　'.$age_check_list.'<br>
';
}

if($publishing_period=="−"){}else{
$campaign_listB.='
<font size="1">'.$mark.'<font size="1" color="#538ED5">実施日時</font><br>
<font size="1">　'.$publishing_period.'<br>
</div><!--box end-->
';
}

$obj_category= new basedb_CategoryClassTblAccess;
$obj_category->conn = $obj_conn->conn;
$obj_category->jyoken=array();
$obj_category->jyoken["cg_clid"]    = $obj_campaign->campaindat[0]['cp_id'];
$obj_category->jyoken["cg_type"]    = 8;
$obj_category->jyoken["cg_deldate"] = 1;
$obj_category->sort["cg_dispno"]    = 2;
$obj_category->categorydat=array();
list( $intCnt_category , $intTotal_category ) = $obj_category->basedb_GetCategory ( 1 , -1 );

$dispcnt="";
$dispcnt=count($obj_category->categorydat)-1;


if($dispcnt>=0){
  foreach($obj_category->categorydat as $key1=>$val1){

    $obj_camarticle = new basedb_CamarticleClassTblAccess;
    $obj_camarticle->conn = $obj_conn->conn;
    $obj_camarticle->jyoken=array();
    $obj_camarticle->jyoken["ca_cpid"]=$obj_category->categorydat[$key1]['cg_id'];
    $obj_camarticle->jyoken["ca_stat"]=1;
    $obj_camarticle->jyoken["ca_deldate"]=1;
    $obj_camarticle->sort["ca_dispno"] = 1;
    $obj_camarticle->camarticledat=array();
    list( $intCnt_camarticle , $intTotal_camarticle ) = $obj_camarticle->basedb_GetCamarticle ( 1 , -1 );
	$dispcnt="";
    $dispcnt=count($obj_camarticle->camarticledat)-1;
    
	if($dispcnt>=0){
	
      foreach($obj_camarticle->camarticledat as $key2=>$va2){
	  
// 重要
$caid =$obj_camarticle->camarticledat[$key2][ca_id];

$url=_BLOG_SITE_URL_BASE.'campaign-detaild-'.$caid.'/?page='.$title.'';
//一番最初の行に実行する
	if($key2==0){
//授業内容
$campaign_list.='
	    <div><!--box start-->
	    <font size="1">'.$mark.'<font size="1" color="#538ED5">'.htmlspecialchars($obj_category->categorydat[$key1]['cg_stitle']).'</font>
	    ';
}
//タイトルイメージ
	$ca_contents=htmlspecialchars($obj_camarticle->camarticledat[$key2]['ca_contents']);
//パラメーターでキーをもってきて生成する(画像）
	if($obj_camarticle->camarticledat[$key2][ca_img]){
	  $img_path='
	    <!--<p>
		 <a href="'.$param_camarticle_img_path.$obj_camarticle->camarticledat[$key2]['ca_img'].'" onclick="return hs.expand(this)" onkeypress="return hs.expand(this)"><img src="./img_thumbnail.php?w=150&h=120&dir='.$param_camarticle_img_path.'&nm='.$obj_camarticle->camarticledat[$key2]['ca_img'].'" alt=""  />

</a>
	    </p>-->	
';
	}else{
	  $img_path='
	    ';
	}
//小見出し
	if($obj_camarticle->camarticledat[$key2]['ca_img']){

			  //echo $dispcnt;
			  //echo $key2;
			  if($key2==$dispcnt){
		  $campaign_list.='
				<center>
	    '.$img_path.'
	 </center>
		 </font></a><font size="1">　<a href="'.$url.'"	>
<font color="#666666">
'.htmlspecialchars($obj_camarticle->camarticledat[$key2]['ca_title']).'
	    <!--<p><font size="1">'.nl2br($ca_contents).'</p>-->
		 ';		  
			  }else{
	  $campaign_list.='
			<center>
	    '.$img_path.'
		 </center>
	  </font>
		</a><font size="1">　<a href="'.$url.'"	>
<font color="#666666">
'.htmlspecialchars($obj_camarticle->camarticledat[$key2]['ca_title']).'
	    <!--<p><font size="1">'.nl2br($ca_contents).'</p>-->
		 ';
			  }
	}else{



if($key2==$dispcnt){

	  $campaign_list.='
</font>
</a><br><font size="1">　<a href="'.$url.'">
<font color="#666666">
'.htmlspecialchars($obj_camarticle->camarticledat[$key2]['ca_title']).'
</a></font>
	 ';
	  $campaign_lista.='
			    <br><font size="1">'.nl2br($ca_contents).'
				 ';
}else{
	  $campaign_list.='
	 </font>
	</a><br><font size="1">　<a href="'.$url.'">
<font color="#666666">
'.htmlspecialchars($obj_camarticle->camarticledat[$key2]['ca_title']).'
</font>
</a>';
		
		
	  $campaign_lista.='
			    <br><font size="1">'.nl2br($ca_contents).'
				 ';

}

		
	}
	      }
	  
      $campaign_list.='</div><!--boxlittle end-->';
    }else{
      $campaign_list.='
	<div><!--box start-->
	<font size="1">'.htmlspecialchars($obj_category->categorydat[$key1]['cg_stitle']).'</div><!--boxlittle end-->';
    }
  }

}

$url="";
$url=_BLOG_SITE_URL_BASE.'campaign-detaild-'.$caid.'/';



