<?
//=====================================================================
//campaignlist �ǻȤ��ѿ�
//case_numbera
//campaign_list
//strViewPageMove_list
//strViewPageMove_before
//strViewPageMove_after
//=====================================================================

//=====================================================================
//�ؿ��ɲ�(htmltag���� �Ѵ�)
require"taglist.php";
function strip_between_tag( $str, $tag=array() ) {
foreach( $tag as $val){
$pattern = "/<{$val}.*?>.*?<\/{$val}>/ims";
$str = preg_replace( $pattern , '[ ����ɽ���Բ� ]', $str);
}
return $str;
}
//=====================================================================


if($_GET['cpid']){
		  $cpid=$_GET['cpid'];
}else{
		  $cpid="0";
}
if($_GET['page']){
		  $page=$_GET['page']-1;
}else{
		  $page="0";
}
$obj_category->jyoken=array();
$obj_category->jyoken["cg_clid"]   = $obj_login->clientdat[0]['cl_id'];
$obj_category->jyoken["cg_stat"]   = 1;
$obj_category->jyoken["cg_id"]     = $cpid;
$obj_category->jyoken["cg_type"]   = 6;
$obj_category->jyoken["cg_deldate"]= 1;
$obj_category->sort["cg_dispno"]   = 2;

$obj_category->categorydat=array();
//�����ܤ��� �����ܤޤǽ��äƤ���
list( $intCnt_category , $intTotal_category ) = $obj_category->basedb_GetCategory ( 1 , -1 );

$start=$page * 10;
$start=$start+1;
$timestamp='(timestamp \''.date("Y").'-'.date("m").'-'.date("d").' 00:00:00\')';
$obj_campaign = new basedb_CampainClassTblAccess;
$obj_campaign->conn = $obj_conn->conn;
$obj_campaign->jyoken["cp_clid"]        = $obj_login->clientdat[0]['cl_id'];
$obj_campaign->jyoken["cp_stat"]        = 1;
$obj_campaign->jyoken["cp_cgid"]        = $cpid;
$obj_campaign->jyoken["cp_deldate"]     = 1;
$obj_campaign->jyoken["cp_publishstart"]= $timestamp;
$obj_campaign->jyoken["cp_publishend"]  = $timestamp;
$obj_campaign->sort["cp_upddate"]       = 2;
$obj_campaign->campaindat=array();
list( $intCnt_campaign , $intTotal_campaign ) = $obj_campaign->basedb_GetCampain ( $start , 10 );
$intTotal_campaign2 = ($intTotal_campaign / 10);
$intTotal_campaign2 = ceil($intTotal_campaign2);
$intTotal_campaign2 = $intTotal_campaign2-2;

$pagemax=$intTotal_campaign;
$pagedown="";
$pageup="";
$pagea = $start+$intCnt_campaign;

if($pagea > $intTotal_campaign){

		  $start1 =$start;
		  $case_numbera='(	  
					 '.$start1.' �� 
					 '.($intTotal_campaign)." ���
					 $intTotal_campaign ��)
					 <br />
					 ";


}else{

		  $start1 =$start;
		  //    $case_number=$intTotal_campaign.' �� '.$start.' �� '.($start+$intCnt_campaign-1)." ���ܤ�ɽ��";
		  $case_numbera='(	  
					 '.$start1.' �� 
					 '.($start+$intCnt_campaign-1)." ���
					 $intTotal_campaign ��)
					 <br />
					 ";
}


if($dispcnt>=0){
		  foreach($obj_campaign->campaindat as $key1=>$val1){
					 if($obj_campaign->campaindat[$key1]['cp_img1']){
								$img_path='';
								$cp_contents = "";
								$cp_contents = strip_between_tag($obj_campaign->campaindat[$key1]['cp_contents'],$srr_tag) ;
								$cp_contents = strip_tags($cp_contents);
								$cp_contents = htmlspecialchars($cp_contents);
								$cp_contents = mb_substr($cp_contents,0,30,"EUC-JP").'������<a href="'._BLOG_SITE_URL_BASE.'campaign-detail-'.$obj_campaign->campaindat[$key1]['cp_id'].'/">
<font color="#666666">
									 �ʾܺ٤Ϥ������
</a>
</font>
';
					 }else{
								$img_path = '';

								$cp_contents = "";
								$cp_contents = strip_between_tag($obj_campaign->campaindat[$key1]['cp_contents'],$srr_tag) ;
								$cp_contents = strip_tags($cp_contents);
								$cp_contents = htmlspecialchars($cp_contents);
								$cp_contents = mb_substr($cp_contents,0,30,"EUC-JP").'������<a href="'._BLOG_SITE_URL_BASE.'campaign-detail-'.$obj_campaign->campaindat[$key1]['cp_id'].'/">
<font color="#666666">
									 �ʾܺ٤Ϥ������
</a>
</font>
';
					 }

					 $campaign_list.='
								<!--box start-->
								<font size="1" color="#00B0F0">��</font><font size="1"><a href="'._BLOG_SITE_URL_BASE.'campaign-detail-'.$obj_campaign->campaindat[$key1]['cp_id'].'/">
<font size="1" color="#666666">
								'.htmlspecialchars($obj_campaign->campaindat[$key1]['cp_title']).'
</font>
</a>
								<br><a href="'._BLOG_SITE_URL_BASE.'campaign-detail-'.$obj_campaign->campaindat[$key1]['cp_id'].'/"></a>
								'.$img_path.'
								<font size="1">'.$cp_contents.'<br>
';
$age_of         = $obj_campaign->campaindat[$key1]['cp_age'];
$age_check      = array();
$age_icon       = array() ;
$age_check_list = "";
$age_icon_list  = "" ;
if(($age_of & 64)==64){
	   $age_check[7]='�Ҳ�͡�';
		  $age_icon[7]='<img src="./share/icons/item_syakaijin_5.gif" alt="" width="45" height="30" />';
		  $age_of-=64;
}
if(($age_of & 32)==32){
	   $age_check[6]='�������';
		  $age_icon[6]='<img src="./share/icons/item_daigaku_5.gif" alt="" width="45" height="30" />��';
		  $age_of-=32;
}
if(($age_of & 16)==16){
	   $age_check[5]='ϲ������';
		  $age_icon[5]='<img src="./share/icons/item_ronin_5.gif" alt="" width="45" height="30" />��';
		  $age_of-=16;
}
if(($age_of & 8)==8){
	   $age_check[4]='�⹻����';
		  $age_icon[4]='<img src="./share/icons/item_koukou_5.gif" alt="" width="45" height="30" />��';
		  $age_of-=8;
}
if(($age_of & 4)==4){
	   $age_check[3]='�������';
		  $age_icon[3]='<img src="./share/icons/item_chugaku_5.gif" alt="" width="45" height="30" />��';
		  $age_of-=4;
}
if(($age_of & 2)==2){
	   $age_check[2]='��������';
		  $age_icon[2]='<img src="./share/icons/item_shougaku_5.gif" alt="" width="45" height="30" />��';
		  $age_of-=2;
}
if(($age_of & 1)==1){
	   $age_check[1]='�Ļ���';
		  $age_icon[1]='<img src="./share/icons/item_youji_5.gif" alt="" width="45" height="30" />��';
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
	   $age_check_list="��";
}

if($age_check_list=="��"){}else{
$campaign_list.='
  <font size="1"><font color="#FFC000">*</font><font size="1" color="#538ED5">�С���</font><br>
  <font size="1">��'.$age_check_list.'<br>
  ';
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
if($obj_campaign->campaindat[$key1]['cp_camstart'] || $obj_campaign->campaindat[$key1]['cp_camend'])
{
$start_year  = substr($obj_campaign->campaindat[$key1]['cp_camstart'],0,4);
$start_month = substr($obj_campaign->campaindat[$key1]['cp_camstart'],5,2);
$start_day   = substr($obj_campaign->campaindat[$key1]['cp_camstart'],8,2);

$start_date  = $start_year.'ǯ'.$start_month.'��'.$start_day.'��';

$end_year    = substr($obj_campaign->campaindat[$key1]['cp_camend'],0,4);
$end_month   = substr($obj_campaign->campaindat[$key1]['cp_camend'],5,2);
$end_day     = substr($obj_campaign->campaindat[$key1]['cp_camend'],8,2);

$end_date    = $end_year.'ǯ'.$end_month.'��'.$end_day.'��';

				  $publishing_period=ltrim($start_date,"0")." �� ".ltrim($end_date,"0");
}else{
	   $publishing_period="��";
}




if($publishing_period=="��"){}else{
	
	
$campaign_list.='
  <font size="1"><font color="#FFC000">*</font><font size="1" color="#538ED5">�»�����</font><br>
  <font size="1">��'.$publishing_period.'<br>
  </div><!--box end-->
  ';
}

$campaign_list.='<HR color="#FFC000" size="1">';

		  }

}






$campaign_list.='
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
$strBuffBuildStartCnt = ( $intMaxViewCnt * ( $_GET["page"] - 1 ) ) + 1;
$strBuffBuildEndCnt   = ( $intMaxViewCnt * ( $_GET["page"] - 1 ) ) + $buildCnt;
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


if($pagea > $intTotal_campaign){

	$last =$pagemax / 10;

	$last =floor($last);
	if($last==0){
	$last=1;
	}



// �̾����(�ꥹ��)
for($cnt=$start;$cnt<=$end;$cnt++){
	if($cnt==$_GET['page']){
			  $strViewPageMove_list.='<td><font size="1">['.$cnt."]</td>\n";
	}else{
			  if($cnt>$last){
			  }else{
						 $strViewPageMove_list.=
'<td><font size="1"><A href="'._BLOG_SITE_URL_BASE.'campain-list/p-'.($start-1).'/cp-'.$cpid.'/?page='.$cnt.''.$strGetSearch_lay.'" target="_self">
<font size="1" color="#666666">['.$cnt."]</font></td></a>\n";

			  }
	}
}


	$strViewPageMove_before = "";
	if($page_category!=1){
		$intBuffCnt_be=$last;
		$strViewPageMove_before .=
		'<A href="'._BLOG_SITE_URL_BASE.'campain-list/p-'.($start-1).'/cp-'.$cpid.'/'.$strGetSearch_lay.'" target="_self">
<font size="1" color="#666666">
		���Υڡ���
</font>
		</A>'."\n";
	}

}else{

	$last =$pagemax / 10;

	$last =ceil($last);
	if($last==0){
	$last=1;
	}

	if($last ==1){
	}else{


//�̾����(�ꥹ��)
			  for($cnt=$start;$cnt<=$end;$cnt++){
				if($cnt==$_GET['page']){
					$strViewPageMove_list.='<td><font size="1">['.$cnt."]</td>\n";
				}else{
 if($cnt>$last){

							}else{

		$strViewPageMove_list.=

		'
<td>		
<A href="'._BLOG_SITE_URL_BASE.'campain-list/p-'.($cnt).'/cp-'.$cpid.'/'.$strGetSearch_lay.'" target="_self">
<font size="1" color="#666666">
		['.$cnt."]
</td>
</font></a>
		 \n";

							}
				}
			  }



 $strViewPageMove_after = "";
if($end+1 <=$last){
		$intBuffCnt_af=$start+5;
		$strViewPageMove_after .='<A href="'._BLOG_SITE_URL_BASE.'campain-list/p-'.($end+1).'/cp-'.$cpid.'/'.$strGetSearch_lay.'" target="_self">
<font color="#666666">
		���Υڡ���
</a>
</font>
		'."\n";
}


	$strViewPageMove_before = "";
	if($page_category!=1){
		$intBuffCnt_be=$start-1;
		$strViewPageMove_before .=
		'<A href="'._BLOG_SITE_URL_BASE.'campain-list/p-'.($start-1).'/cp-'.$cpid.'/'.$strGetSearch_lay.'" target="_self">
<font color="#666666">
		���Υڡ���
</a></font>
		'."\n";
	}

}

//�ܥ���
if($strViewPageMove_before && !$strViewPageMove_after){
$strViewCategoryPageMove = "		".$strViewPageMove_before."\n";
}elseif($strViewPageMove_before && $strViewPageMove_after){
$strViewCategoryPageMove .= "		".$strViewPageMove_before."��".$strViewPageMove_after."\n";
}else{
$strViewCategoryPageMove = "		".$strViewPageMove_after."\n";
}
}
?>
