<?php

/*=======================================================
    ���������ѽ���

    �ϤäƤ���ar[](��)�򸵤ˡ��إޥ���m_station����
    ���θ��ˤ�����������Ƽ���
    ������v_search_line��es_linecd(����å�����ڤ�ǳ�Ǽ����Ƥ���)��like����
    ȯ���Τ�������Τ߰���ɽ������

=======================================================*/

// �����̵꤬�����ϥ��顼
IF( count( $_GET["ar"] ) == 0 && count( $_POST["ar"] ) == 0 ){
	$arrErr['ath_comment'] = "<input type=\"hidden\" name=\"fa\" value=\"{$_GET['fa']}\">\n";
	$arrErr['ath_comment'] .= $hddnVal;
	$obj_error->ViewErrMessage( "NO_AREA_SITEI" , "PORTAL-USER" , _BLOG_SITE_URL_BASE."/psearch-arealine/" , $arrErr );
	exit;
}

// GET�ͺ��� ar
// hidden����
FOREACH($_GET["ar"] as $key => $val){
	if ($get_str == ''){
		$get_str .= '?';
	} else {
		$get_str .= '&';
	}
	$hidden_str .= '<input type="hidden" name="ar[]" value="' . $val . '">' . "\n";
	$get_str .= 'ar[]=' . $val;
}

// ��������ѥ⡼�� 'ln' or 'st'
// javascript��name,value���å�
$hidden_str .= '<input type="hidden" name="dummy" id="mode" value="">' . "\n";


//���Ф�ɽ����������
$view_select_pref .= '<h3 class="orange">���򤷤���</h3>'."\n";
$view_select_pref .= '<div class="box">'."\n";
$view_select_pref .= '<table class="search1">'."\n";
$view_select_pref .= '<tr>'."\n";
$view_select_pref .= '<td><div class="area">'."\n";

foreach( $_GET['ar'] as $ar_val ){
	$view_select_pref .= '<div class="areatext"><p><a href="#'.$ar_val.'">'.$psel[$ar_val].'</a></p></div>'."\n";
}
unset($key, $key2, $val, $val2, $obj_sprefcnt->sprefdat,$view_prefdat);

$view_select_pref .= '</div></td>'."\n";
$view_select_pref .= '</tr>'."\n";
$view_select_pref .= '</table>'."\n";
$view_select_pref .= '</div>'."\n";
$view_select_pref .= '<br>'."\n";

/*=======================================================
   ��������ν���
=======================================================*/
$line_cd_list = array();
foreach( $_GET['ar'] as $ar_key => $ar_val ){
	$line_cd[$ar_val] = array();
	//�����ǡ�����н���
	// viewdb_SearchLineClass.php
	/*=======================================================
	    ��������н���
	=======================================================*/
	
	//�������ɤ���
	$obj_sline = new viewdb_SLineClassTblAccess;
	$obj_sline->conn = $obj_conn->conn;
	$obj_sline->jyoken = array(); 
	$obj_sline->jyoken["st_prefcd"] = $ar_val;
	$obj_sline->jyoken["sc_stat"] = 1;
	$obj_sline->jyoken["cl_stat"] = 1;
	$obj_sline->jyoken["cl_pstat"] = 1;
	$obj_sline->jyoken["cl_start"] = 1;
	$obj_sline->jyoken["cl_end"] = 1;
	$obj_sline->jyoken["cl_deldate"] = 1;
	$obj_sline->sort['line'] = 1;
	$ret = $obj_sline->viewdb_GetSLinecd( 1 , -1);
	foreach( $obj_sline->slinedat as $key => $val ){
		foreach( $val as $key2 => $val2 ){
			if( is_numeric( $key2 ) ){
				unset( $obj_sline->slinedat[$key][$key2] );
			}else{
				$view_slilne[$ar_val][$key][$key2] = $obj_sline->slinedat[$key][$key2];
				array_push($line_cd[$ar_val], explode( "/", $obj_sline->slinedat[$key]['es_linecd'] ) );
			}
		}
	}
	
	
	//�������ɤ��鸡�������Τα��������ɤ����
	foreach( $line_cd[$ar_val] as $cd_key => $cd_val ){
		foreach( $cd_val as $cd_key2 => $cd_val2 ){
			if( $cd_val2 == "" ){
				unset( $line_cd[$ar_val][$cd_key][$cd_key2] );
			}else{
				$line_cd_list[$ar_val][] = intval( $line_cd[$ar_val][$cd_key][$cd_key2] );
			}
		}
		//���������ɽ�˥�����
		sort( $line_cd_list[$ar_val] );
	}
	//��ʣ������������ɤ���
	$line_cd_list[$ar_val] = array_unique( $line_cd_list[$ar_val] );
}

foreach( $line_cd_list as $ar_key => $ar_val ){
	foreach( $ar_val as $cd_key => $cd_val ){
		$obj_mline = new mstdb_LineClassTblAccess;
		$obj_mline->conn = $obj_conn->conn;
		$obj_mline->jyoken = array();
		$obj_mline->jyoken["st_linecd"] = $cd_val;
		$obj_mline->mstdb_GetLine( 5 );
		$line_name_list[$ar_key][$cd_key] = $obj_mline->linedat[0]['st_line'];
	}
}

foreach( $_GET['ar'] as $ar_key => $ar_val ){

	if( is_array( $view_slilne[$ar_val] ) && count( $view_slilne[$ar_val] ) > 0 ){
		
		foreach( $line_cd_list[$ar_val] as $cd_key => $cd_val ){
		
			if( $cd_key == 0 ){
				$view_line_list .= '<a name="'.$ar_val.'"></a>'."\n";
				$view_line_list .= '<h3>'.$psel[$ar_val].'</h3>'."\n";
				$view_line_list .= '<div class="box">'."\n";
				$view_line_list .= '<table class="search1">'."\n";
				$view_line_list .= '<tr>';
				$view_line_list .= '<td><p class="area">'."\n";
			}
			
			//������(���򤷤����ܱ����Ǥη��)
			$obj_slinecnt = new viewdb_SLineClassTblAccess;
			$obj_slinecnt->conn = $obj_conn->conn;
			$obj_slinecnt->jyoken = array(); 
			$obj_slinecnt->jyoken["st_prefcd"] = $ar_val;
			$obj_slinecnt->jyoken["es_linecd"] = $cd_val;
			$ret = $obj_slinecnt->viewdb_CntSLLine( 1 , -1);
			

			$view_line_list .= '<label class="pl"><input type="checkbox" name="ln[]" value="'.$ar_val."/".$cd_val.'"> <a href="/psearch-result/page-1.html'.$get_str.'&ln[]='.$ar_val."/".$cd_val.'&mode=ln">'.$line_name_list[$ar_val][$cd_key].'��'.$obj_slinecnt->slinedat[0]['count'].'���</a></label>';
		}
		
		$view_line_list .= '</p></td>'."\n";
		$view_line_list .= '</tr>'."\n";
		$view_line_list .= '</table>'."\n";
		$view_line_list .= '</div>'."\n";
		
	}else{
		$view_line_list .= '<a name="'.$ar_val.'"></a>'."\n";
		$view_line_list .= '<h3>'.$psel[$ar_val].'</h3>'."\n";
		$view_line_list .= '<div class="box">'."\n";
		$view_line_list .= '<table class="search1">'."\n";
		$view_line_list .= '<tr>'."\n";
		$view_line_list .= '<td><p class="area">'."\n";
		$view_line_list .= '<br>'."\n";
		$view_line_list .= '</p></td>'."\n";
		$view_line_list .= '</tr>'."\n";
		$view_line_list .= '</table>'."\n";
		$view_line_list .= '</div>'."\n";
	}
}



//���������title,keywords,description�����
//��̾����������
$pref_name_list1 = '';
$pref_name_list2 = '';	
foreach( $_GET['ar'] as $ar_key => $ar_val){
//����޶��ڤ긩̾�ꥹ��
$pref_name_list1 .= ','.$psel[$ar_val];

//�����ڤ긩̾�ꥹ��
if( $pref_name_list2 != '' ) $pref_name_list2 .= '��';
$pref_name_list2 .= $psel[$ar_val];
}

//title
$view_header_title = '';
$view_header_title = $pref_name_list2.'�γؽ��Τ��������̾����õ���óؽ��Ρ��ʳؽΡ���õ���Υݡ����륵���ȡֽΥ������';
//keywords
$view_header_keywoeds = '';
$view_header_keywoeds = '�ؽ���,�ʳؽ�,���̻�Ƴ,��ؼ���,�Υ�����,���ع�,��ع�,�⹻'.$pref_name_list1;
//description
$view_header_description = '';
$view_header_description = '�Υ�����α�������̾���鸡���ڡ�����'.$pref_name_list2.'�ˤǤ����Υ�����ϳؽ��Ρ��ʳؽ�õ���Υݡ����륵���ȤǤ���';
$view_header_description .= '�ϰ����Ū�ʼ����к����佤�ˡ���Ƴ���֡ʸ��̻�Ƴ�����Ϳ���Ƴ�����Ļ�Ƴ�ˡ��оݡʾ��ع�����ع����⹻����ءˤʤɤ����ñ�˽Τ򸡺��Ǥ��ޤ���';

?>