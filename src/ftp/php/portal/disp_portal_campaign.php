<?php

/*==============================================================
    ���٥�Ȱ���
==============================================================*/
// 1�ڡ����������ɽ�����
define( 'DATACOUNT',10);

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

$obj_campaign->sort["cp_upddate"] = 2;      // �¤ӽ� - �ǽ����������߽�

list( $intCnt_cam , $intTotal_cam ) = $obj_campaign->viewdb_GetCampain( ($_GET["p"] - 1) * DATACOUNT + 1 , DATACOUNT );
$ret = $obj_campaign->viewdb_CntCampain( 0,0 );
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

// ���Τη��
$total_campaign_cnt = $intTotal_cam;


$view_campaign_main_list = "";
if( $intCnt_cam < 1 ){
	$view_campaign_main_list = '
<div class="box2">
<p>���ߡ����٥�ȤϤ���ޤ���</p>
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
			$campaign_url = $view_campaigndat[$key]['cl_dokuji_domain'].'campaign-detail-'.$view_campaigndat[$key]['cp_id']."/";
		//�ȼ��ɥᥤ��Ǥʤ����
		}else{
			$campaign_url = _BLOG_SITE_URL_BASE.'/'.$view_campaigndat[$key]['cl_urlcd'].'/campaign-detail-'.$view_campaigndat[$key]['cp_id'].'/';
		}

		$view_campaign_main_list .= '
<div class="box2">
<p class="arrow"><strong><a href="'.$campaign_url.'" target="_blank">'.$remake_upddate.'&nbsp;'.$view_campaigndat[$key]['cp_title'].'('.$view_school_name.')'.'</a></strong></p>'
.'<p class="margint1">' . html_delete($view_campaigndat[$key]['cp_contents']) .'</p>
</div>';
	}
}

//�ѥ󥯥�������
$view_pan_list = '<p class="topicpath"><strong><a href="/">HOME</a></strong><span class="paddinglr1">&gt;</span><strong>���٥�Ȱ���</strong></p>';
		
/*---------------------------------------------------------
    �ڡ����������ʺ���
	$strViewPageNowCount    ... ����ɽ�����Ƥ�����������
	$strViewPageMove        ... �ڡ������ܥ��
	$strViewPageMove_before ... �����ء�
	$strViewPageMove_after  ... �ָ�ء�
	$_GET["p"]              ... ���ߤΥڡ���
	DATACOUNT               ... ɽ�����(���)
					(��ˤƻ���Ѥ�)
	$total_campaign_cnt     ... �����о����ο�
---------------------------------------------------------*/
IF( $intCnt_cam > 0 ){
	$strBuffStartCnt = ( DATACOUNT * ( $_GET["p"] - 1 ) ) + 1;
	$strBuffEndCnt = ( DATACOUNT * ( $_GET["p"] - 1 ) ) + $intCnt_cam;

	$intBuffMove = $total_campaign_cnt / DATACOUNT;
	IF( is_int($intBuffMove) === FALSE ){
		$intBuffMove = ceil($intBuffMove);
	}

	$link_URL1 = "<a href=\"" . _BLOG_SITE_URL_BASE."/campaign-";
	$link_URL2 = ".html\" target=\"_self\" >";

	// 2�ڡ����ʾ夢����Τ�ľ�ܥ�󥯤����
	if ($intBuffMove > 1){
		// ���ڡ���
		$strViewPageMove_before = "";
		IF( $_GET["p"] != 1 && $intBuffMove != 1 ){
			$intBuffCnt_be = $_GET["p"] - 1;
			$strViewPageMove_before .= $link_URL1 . $intBuffCnt_be . $link_URL2 . "����" . DATACOUNT . "��</A>\n";
		}

		// ���ڡ���
		$strViewPageMove_after = "";
		IF( $intBuffMove > $_GET["p"] ){
			// �Ĥ�����ɽ��
			// DATACOUNT��ʾ夢�ä��� ����DATACOUNT��
			$next_cnt = $total_campaign_cnt - $strBuffEndCnt;
			IF($next_cnt >= DATACOUNT){
				$next_cnt = DATACOUNT;
			}
			$intBuffCnt_af = $_GET["p"] + 1;
			$strViewPageMove_after .= $link_URL1 . $intBuffCnt_af . $link_URL2 . "����{$next_cnt}��</a>\n";
		}

		// �ڡ����ؤ�ľ�ܥ����ץ�󥯺���
		$strViewPageMove_Cnt = "";
		$strViewPageMove_Cnt_more_before = "";
		$strViewPageMove_Cnt_more_after = "";
		$intCnt = 5;
		FOR( $iX=1; $iX<=$intBuffMove; $iX++ ){
			// ���ߤ���ڡ���������XX�鷺�Ĥ�ɽ��
			IF ($iX < $_GET["p"] - $intCnt) {
				// �Ϥ߽Ф�������...�Ǿ�ά
				$strViewPageMove_Cnt_more_before = "...";
			} ELSE IF ($iX > $_GET["p"] + $intCnt) {
				// �Ϥ߽Ф�������...�Ǿ�ά
				$strViewPageMove_Cnt_more_after = "...";
			} ELSE IF ($iX == $_GET["p"]) {
				// ���ߤ���ڡ����ϥ��̵��
				$strViewPageMove_Cnt .= "<b>". $iX . "</b>\n";
			} ELSE {
				$strViewPageMove_Cnt .= $link_URL1 . $iX . $link_URL2 . $iX . "</A>\n";
			}
		}
		// ...3 4 5 6 7 8 9 10 11 12 13... �ߤ����ʴ���
		//$strViewPageMove_Cnt = $strViewPageMove_Cnt_more_before . $strViewPageMove_Cnt . $strViewPageMove_Cnt_more_after;
		// 3 4 5 6 7 8 9 10 11 12 13 �ߤ����ʴ���
		$strViewPageMove_Cnt = $strViewPageMove_Cnt;

	}

	$view_page_list='<div class="pagenavi">
<p class="pagenavileft">��'.$total_campaign_cnt.'��&nbsp;&nbsp;'.$strBuffStartCnt.'-'.$strBuffEndCnt.'���ɽ����</p>
<p class="pagenaviright">'.$strViewPageMove_before.$strViewPageMove_Cnt.$strViewPageMove_after.'</p><br class="clear">
</div>
';
}

unset( $obj_campaign, $view_campaigndat );

/*==============================================================
    TOP�ڡ���ɽ�����������ե�����
==============================================================*/

//title
$view_header_title = '';
$view_header_title = '���奤�٥�Ⱦ�������óؽ��Ρ��ʳؽΡ���õ���Υݡ����륵���ȡֽΥ������';
//keywords
$view_header_keywoeds = '';
$view_header_keywoeds = '�ؽ���,�ʳؽ�,���̻�Ƴ,��ؼ���,�Υ�����,���ع�,��ع�,�⹻,�ƴ��ֽ�,�ߴ��ֽ�,̵���θ�����,���٥��';
//description
$view_header_description = '';
$view_header_description = '�Υ�����ο��奤�٥�Ȱ����ڡ����Ǥ����ƴ��ֽ����ߴ��ֽ���̵���θ����ȤʤɤγƼ磻�٥�Ȥ�Ǻܡ�';
$view_header_description .= '�Υ�����ϳؽ��Ρ��ʳؽ�õ���Υݡ����륵���ȤǤ����ϰ����Ū�ʼ����к����佤�ˡ���Ƴ�����ʸ��̻�Ƴ�����Ϳ���Ƴ�����Ļ�Ƴ�ˡ��оݡʾ��ع�����ع����⹻����ءˤʤɤ����ñ�˽Τ򸡺��Ǥ��ޤ���';

?>