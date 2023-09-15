<?php
/*==============================================================

    ��¦�ξ���ɽ����ʬ�ν���

==============================================================*/

/*==============================================================
    �������ɤ��顢���ꥢ�̤θ������ɷ����Ѵ�
	
==============================================================*/
//�����Υ��ꥢ����Ȱ��פ������Τߤ�ɽ�����뤿��˸����������������
$area_pref_list = array();
if( is_array( $_GET['ar'] ) && count( $_GET['ar'] ) >0 ){
	foreach( $_GET['ar'] as $key => $val ){
		//�������ɤ��饨�ꥢ�θ������ɷ���
		switch( true ){
			case ( $val == 1 ):
				array_push( $area_pref_list, 1);
				break;
			case ( $val >= 2 && $val <= 7 ):
				array_push( $area_pref_list, 2,3,4,5,6,7 );   
				break;
			case ( $val >= 8 && $val <= 14 ):
				array_push( $area_pref_list, 8,9,10,11,12,13,14 );
				break;
			case ( $val >= 15 && $val <= 20 ):
				array_push( $area_pref_list, 15,16,17,18,19,20 );
				break;
			case ( $val >= 21 && $val <= 24 ):
				array_push( $area_pref_list, 21,22,23,24 );
				break;
			case ( $val >= 25 && $val <= 30 ):
				array_push( $area_pref_list, 25,26,27,28,29,30 );
				break;
			case ( $val >= 31 && $val <= 39 ):
				array_push( $area_pref_list, 31,32,33,34,35,36,37,38,39 );
				break;
			case ( $val >= 40 && $val <= 47 ):
				array_push( $area_pref_list, 40,41,42,43,44,45,46,47 );
				break;
			default :
				break;
		}
	}
	//��ʣ���븩�����ɤκ��
	$area_pref_list = array_unique( $area_pref_list );
	
}elseif( isset( $_GET['ar_flg'] ) && $_GET['ar_flg'] != "" ){
	switch( true ){
		case ( $_GET['ar_flg'] == 1 ):
			$area_pref_list = array( 1 );
			break;
		case ( $_GET['ar_flg'] == 2 ):
			$area_pref_list = array( 2,3,4,5,6,7 );
			break;
		case ( $_GET['ar_flg'] == 3 ):
			$area_pref_list = array( 8,9,10,11,12,13,14 );
			break;
		case ( $_GET['ar_flg'] == 4 ):
			$area_pref_list = array( 15,16,17,18,19,20 );
			break;
		case ( $_GET['ar_flg'] == 5 ):
			$area_pref_list = array( 21,22,23,24 );
			break;
		case ( $_GET['ar_flg'] == 6 ):
			$area_pref_list = array( 25,26,27,28,29,30 );
			break;
		case ( $_GET['ar_flg'] == 7 ):
			$area_pref_list = array( 31,32,33,34,35,36,37,38,39 );
			break;
		case ( $_GET['ar_flg'] == 8 ):
			$area_pref_list = array( 40,41,42,43,44,45,46,47 );
			break;
		default :
			break;
	}
}

/*==============================================================
    �����ڡ���ǿ��������
==============================================================*/
$obj_campaign = new viewdb_CampainClassTblAccess;
$obj_campaign->jyoken = array();
$obj_campaign->conn = $obj_conn->conn;
$obj_campaign->jyoken["cp_stat"] = 1;       // ���٥�Ȥ�ͭ�����ɤ���
$obj_campaign->jyoken["cp_deldate"] = 1;	// �����ڡ�����󤬺������Ƥ��ʤ�
$obj_campaign->jyoken["cp_start"] = 1;      // ���٥�ȷǺܳ��������������������ɤ���
$obj_campaign->jyoken["cp_end"] = 1;        // ���٥�ȷǺܽ�λ�����������ʹߤ��ɤ���
$obj_campaign->jyoken["cl_stat"] = 1;       // �֥��Ǻܥե饰��ͭ�����ɤ���
$obj_campaign->jyoken["cl_pstat"] = 1;      // �ݡ�����Ǻܥե饰��ͭ�����ɤ���
$obj_campaign->jyoken["cl_start"] = 1;      // �֥��Ǻܳ��������������������ɤ���
$obj_campaign->jyoken["cl_end"] = 1;        // �֥��Ǻܽ�λ�����������ʹߤ��ɤ���
$obj_campaign->jyoken["cl_deldate"] = 1;    // �����ڡ�����󤬺������Ƥ��ʤ�
$obj_campaign->jyoken["ar_prefcd_list"] = $area_pref_list;    // ���ꥢ�˳������븩�����ɤ�����
$obj_campaign->sort["cp_upddate"] = 2;      // �¤ӽ� - �ǽ����������߽�
list( $intCnt_cam , $intTotal_cam ) = $obj_campaign->viewdb_GetCampain( 1 , 10 );
if( is_array( $obj_campaign->campaindat ) ){
	foreach( $obj_campaign->campaindat as $key => $val ){
		foreach( $val as $key2 => $val2 ){
			if( is_numeric( $key2 ) ){
				unset( $obj_campaign->campaindat[$key][$key2] );
			}else{
				$view_campaigndat[$key][$key2] = htmlspecialchars( $obj_campaign->campaindat[$key][$key2] );
			}
		}
	}
	unset($key,$key2,$val,$val2);
}


$view_campaign_list = "";
if( $intCnt_cam < 1 ){
	$view_campaign_list = '
<div class="eventtext">
<p>���ߡ��ǿ��Υ��٥�ȤϤ���ޤ���</p>
</div>
';
}else{


	foreach( $view_campaigndat as $key => $val ){
	
		$remake_upddate = substr( $view_campaigndat[$key]['cp_upddate'] ,0 ,10);
		
		//��̾������̾
		$view_school_name = "";
		if( $view_campaigndat[$key]['cl_kname'] != "" ){
			$view_school_name = $view_campaigndat[$key]['cl_jname']."��".$view_campaigndat[$key]['cl_kname'];
		}else{
			$view_school_name = $view_campaigndat[$key]['cl_jname'];
		}
		
		//�ȼ��ɥᥤ��ξ��
		if( $view_campaigndat[$key]['cl_dokuji_flg']  == 1 ){

		$campaign_url = $view_campaigndat[$key]['cl_dokuji_domain'].'campaign-detail-'.$view_campaigndat[$key]['cp_id'].'/';
	
		$view_campaign_list .= '
<div class="eventtext">
<p><a href="'.$campaign_url.'" target="_blank">'.$remake_upddate.'<br>'.$view_campaigndat[$key]['cp_title'].'('.$view_school_name.')</a></p>
</div>
';
	
		//�ȼ��ɥᥤ��Ǥʤ����
		}else{
	
		$campaign_url = _BLOG_SITE_URL_BASE.'/'.$view_campaigndat[$key]['cl_urlcd'].'/campaign-detail-'.$view_campaigndat[$key]['cp_id'].'/';
	
		$view_campaign_list .= '
<div class="eventtext">
<p><a href="'.$campaign_url.'" target="_blank">'.$remake_upddate.'<br>'.$view_campaigndat[$key]['cp_title'].'('.$view_school_name.')</a></p>
</div>
';
		}
	}
}


/*==============================================================
    �����å������ǿ��������
==============================================================*/

$obj_diary = new viewdb_DiaryClassTblAccess;
$obj_diary->conn = $obj_conn->conn;
$obj_diary->jyoken = array();
$obj_diary->jyoken["dr_deldate"] = 1;     // �������󤬺������Ƥ��ʤ�
$obj_diary->jyoken["cl_stat"] = 1;        // �֥��Ǻܥե饰��ͭ�����ɤ���
$obj_diary->jyoken["cl_pstat"] = 1;       // �ݡ�����Ǻܥե饰��ͭ�����ɤ���
$obj_diary->jyoken["cl_start"] = 1;       // �֥��Ǻܳ��������������������ɤ���
$obj_diary->jyoken["cl_end"] = 1;         // �֥��Ǻܽ�λ�����������ʹߤ��ɤ���
$obj_diary->jyoken["cl_deldate"] = 1;     // �������󤬺������Ƥ��ʤ�
if( ( is_array( $_GET['ar'] ) && count( $_GET['ar'] ) >0 ) || ( isset( $_GET['ar_flg'] ) && $_GET['ar_flg'] != "" ) ){
	$obj_diary->jyoken["ar_prefcd_list"] = $area_pref_list;    // ���ꥢ�˳������븩�����ɤ�����
}
$obj_diary->sort["dr_upddate"] = 2;       // �¤ӽ� - �ǽ����������߽�

list( $intCnt_dia , $intTotal_dia ) = $obj_diary->viewdb_GetDiary( 1 , 10 );

if( is_array( $obj_diary->diarydat ) ){
	foreach( $obj_diary->diarydat as $key => $val ){
		foreach( $val as $key2 => $val2 ){
			if( is_numeric( $key2 ) ){
				unset( $obj_diary->diarydat[$key][$key2] );
			}else{
				$view_infodat[$key][$key2] = htmlspecialchars( $obj_diary->diarydat[$key][$key2] );
			}
		}
	}
	unset($key,$key2,$val,$val2);
}

$view_info_list = "";
if( $intCnt_dia < 1 ){
	$view_info_list = '
<div class="eventtext">
<p>���ߡ����Τ餻�Ϥ���ޤ���</p>
</div>
';
}else{
	
	foreach( $view_infodat as $key => $val ){

		$remake_upddate = substr( $view_infodat[$key]['dr_upddate'] ,0 ,10);
		
		//��̾������̾
		$view_school_name = "";
		if( $view_infodat[$key]['cl_kname'] != "" ){
			$view_school_name = $view_infodat[$key]['cl_jname']."��".$view_infodat[$key]['cl_kname'];
		}else{
			$view_school_name = $view_infodat[$key]['cl_jname'];
		}

		//�ȼ��ɥᥤ��ξ��
		if( $view_infodat[$key]['cl_dokuji_flg']  == 1 ){

		$blog_url = $view_infodat[$key]['cl_dokuji_domain'].'blog-'.$view_infodat[$key]['dr_id'].'/';
	
		$view_info_list .= '
<div class="eventtext">
<p><a href="'.$blog_url.'" target="_blank">'.$remake_upddate.'<br>'.$view_infodat[$key]['dr_title'].'('.$view_school_name.')</a></p>
</div>
';
	
		//�ȼ��ɥᥤ��Ǥʤ����
		}else{
	
		$blog_url = _BLOG_SITE_URL_BASE.'/'.$view_infodat[$key]['cl_urlcd'].'/blog-'.$view_infodat[$key]['dr_id'].'/';
	
		$view_info_list .= '
<div class="eventtext">
<p><a href="'.$blog_url.'" target="_blank">'.$remake_upddate.'<br>'.$view_infodat[$key]['dr_title'].'('.$view_school_name.')</a></p>
</div>
';
		}
	}
}

unset( $obj_campaign, $obj_diary, $view_campaigndat, $view_infodat );

?>