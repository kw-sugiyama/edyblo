<?php

/*=======================================================
    �ظ����ѽ���
=======================================================*/

// �����̵꤬�����ϥ��顼
IF( count( $_GET["ar"] ) == 0 && count( $_POST["ar"] ) == 0 ){
	$arrErr['ath_comment'] = "<input type=\"hidden\" name=\"fa\" value=\"{$_GET['fa']}\">\n";
	$arrErr['ath_comment'] .= $hddnVal;
	$obj_error->ViewErrMessage( "NO_AREA_SITEI" , "PORTAL-USER" , _BLOG_SITE_URL_BASE."/psearch-arealine/" , $arrErr );
	exit;
}
// �������̵꤬�����ϥ��顼
IF( count( $_GET["ln"] ) == 0 && count( $_POST["ln"] ) == 0 ){
	$arrErr['ath_comment'] = "<input type=\"hidden\" name=\"fa\" value=\"{$_GET['fa']}\">\n";
	$arrErr['ath_comment'] .= $hddnVal;
	$obj_error->ViewErrMessage( "NO_LINE_SITEI" , "PORTAL-USER" , _BLOG_SITE_URL_BASE."/psearch-arealine/" , $arrErr );
	exit;
}


$ln_data = array();
$ln_pref = array();
$ln_cd = array();
foreach( $_GET['ln'] as $ln_key => $ln_val ){
	$ln_data = explode( "/", $ln_val );
	$ln_pref[] = pg_escape_string($ln_data[0]);
	$ln_cd[]= pg_escape_string($ln_data[1]);
}

//print_r ($ln_cd);


// viewdb_SearchLineClass.php
/*=======================================================
   ������������
=======================================================*/
$obj_sline = new viewdb_SLineClassTblAccess;
$obj_sline->conn = $obj_conn->conn;
$obj_sline->jyoken = array();
$obj_sline->jyoken["es_linecd_list"] = $ln_cd;  // ���������ɤ����
$obj_sline->jyoken["st_prefcd_list"] = $ln_pref;  // ���������ɤ����
$obj_sline->jyoken["sc_stat"] = 1;              // �֥����ܾ�������Ѥߥե饰��ͭ�����ɤ���
$obj_sline->jyoken["cl_stat"] = 1;              // �֥��Ǻܥե饰��ͭ�����ɤ���
$obj_sline->jyoken["cl_pstat"] = 1;             // �ݡ�����Ǻܥե饰��ͭ�����ɤ���
$obj_sline->jyoken["cl_start"] = 1;             // �֥��Ǻܳ��������������������ɤ���
$obj_sline->jyoken["cl_end"] = 1;               // �֥��Ǻܽ�λ�����������ʹߤ��ɤ���
$obj_sline->jyoken["cl_deldate"] = 1;           // ���饤����Ⱦ��󤬺������Ƥ��ʤ�
$obj_sline->sort["sta"] = 1;                    // �¤ӽ� - �إ����ɽ�
list( $intCnt , $intTotal ) = $obj_sline->viewdb_GetSLine( 1 , -1 );
//IF( $intCnt == -1 ){
//	$obj_error->ViewErrMessage( "NO_LINE_SITEI" , "PORTAL-USER" , _BLOG_SITE_URL_BASE . "/psearch-arealine/" , $arrErr );
//	exit;
//}
foreach( $obj_sline->slinedat as $key => $val ){
	foreach( $val as $key2 => $val2 ){
		if( is_numeric( $key2 ) ) {
			unset( $obj_sline->slinedat[$key][$key2] );
		} else {
			$view_stationdat[$key][$key2] = $obj_sline->slinedat[$key][$key2];
		}
	}
}
unset($key,$key2,$val,$val2,$obj_sline->slinedat);

// viewdb_SearchLineClass.php
/*=======================================================
    �����������н���
=======================================================*/
$obj_slinecnt = new viewdb_SLineClassTblAccess;
$obj_slinecnt->conn = $obj_conn->conn;
$obj_slinecnt->jyoken = array();
$obj_slinecnt->jyoken["sc_stat"] = 1;			// �֥����ܾ�������Ѥߥե饰��ͭ�����ɤ���
$obj_slinecnt->jyoken["cl_stat"] = 1;			// �֥��Ǻܥե饰��ͭ�����ɤ���
$obj_slinecnt->jyoken["cl_pstat"] = 1;			// �ݡ�����Ǻܥե饰��ͭ�����ɤ���
$obj_slinecnt->jyoken["cl_start"] = 1;			// �֥��Ǻܳ��������������������ɤ���
$obj_slinecnt->jyoken["cl_end"] = 1;			// �֥��Ǻܽ�λ�����������ʹߤ��ɤ���
$obj_slinecnt->jyoken["cl_deldate"] = 1;		// ���饤����Ⱦ��󤬺������Ƥ��ʤ�

$view_exp_stationdat = array();
$Cnt = 0;
// �Ǵ�����(����å���Ƕ��ڤ��Ƥ���)�ο������Ԥ�ʣ��
// ����_GET���ϤäƤ��Ƥ�������Τ�
FOREACH( $view_stationdat as $key => $val){
	// �Ǵ�����(����å���Ƕ��ڤ��Ƥ���)��Х餹
	$buf_arr_cd = explode("/",$val["es_linecd"]);
	$buf_arr_nm = explode("/",$val["es_linecdname"]);
	$arr_cd = array();
	$arr_nm = array();

	// ����ǽ�ȺǸ�˶��äݤ����äƤ��ޤ��ΤǺ��
	FOREACH( $buf_arr_cd as $buf_key => $buf_val ){
		if ($buf_val != "") $arr_cd[] = $buf_val;
	}
	FOREACH( $buf_arr_nm as $buf_key => $buf_val ){
		if ($buf_val != "") $arr_nm[] = $buf_val;
	}

	FOREACH( $arr_cd as $expkey => $expval ){
		// �����оݤα����Ǥ���Х쥳���ɤ���� ����ʳ��α����ϥ��롼
		if ( in_array($expval,$ln_cd) ) {
			$view_exp_stationdat[$Cnt]["es_linecd"]	= $expval;		// ����������
			$view_exp_stationdat[$Cnt]["es_line"]	= $arr_nm[$expkey];	// ����̾
			$view_exp_stationdat[$Cnt]["st_stacd"]	= $val["st_stacd"];	// �إ�����
			$view_exp_stationdat[$Cnt]["st_sta"]	= $val["st_sta"];	// ��̾

			// ���αؤη�������
			$obj_slinecnt->jyoken["st_stacd_list"] = array( $val["st_stacd"] );	// �إ����ɤ����
			$ret = $obj_slinecnt->viewdb_CntSLine( 1 , -1);
			if( is_array( $obj_slinecnt->slinedat ) ){
				foreach( $obj_slinecnt->slinedat as $cnt_key => $cnt_val ){
					foreach( $cnt_val as $cnt_key2 => $cnt_val2 ){
						if( is_numeric( $cnt_key2 ) ) {
							unset( $obj_slinecnt->slinedat[$cnt_key][$cnt_key2] );
						}
					}
				}
			}
			$view_exp_stationdat[$Cnt]["count"]	= $obj_slinecnt->slinedat[0]["count"];		// ���αؤη��
			unset($cnt_key,$cnt_key2,$cnt_val,$cnt_val2);

			$Cnt++;
		}
	}
	$Cnt++;
}
//print_r($view_exp_stationdat);

// ��̥쥳���ɤν�ʣ�쥳���ɤ���
$tmp = array();
FOREACH($view_exp_stationdat as $key => $val ){
	if(!in_array($val,$tmp)){
		$tmp[] = $val;
	}
}
$view_exp_stationdat = $tmp;

//print_r($view_exp_stationdat);

// ����������(es_linecd)���إ�����(st_stacd) �ǥ�����
// �����������������
foreach ($view_exp_stationdat as $key => $row) {
	$es_linecd[$key]	= $row['es_linecd'];
	$st_stacd[$key]		= $row['st_stacd'];
}

// �ǡ����� st_stacd �ι߽硢st_stacd �ξ���˥����Ȥ��롣
// $data ��Ǹ�Υѥ�᡼���Ȥ����Ϥ���Ʊ�������ǥ����Ȥ��롣
array_multisort($es_linecd, SORT_ASC, $st_stacd, SORT_ASC, $view_exp_stationdat);

//print_r($view_exp_stationdat);

//------------------------------------------------------------------------------
// ɽ���ͤμ���������
//------------------------------------------------------------------------------
$arrBuffList = Array();
$Cnt = 0;
FOREACH( $view_exp_stationdat as $key => $val){

	// $arrBuffList[��������][���󥫥����(����)][�ե������̾]

	// ����ȱ��������ɤ��Ѥ�ä��� ���󥫥���Ȥ�0��
	// Select��̤�st_prefcd��Order����
	if ($prefcd != $val["es_linecd"]){
		$Cnt = 0;
	}

	$ix = $val["es_linecd"];
	$arrBuffList[$ix][$Cnt]["es_linecd"]	= $val["es_linecd"];		// ����������
	$arrBuffList[$ix][$Cnt]["es_line"]	= $val["es_line"];		// ����̾
	$arrBuffList[$ix][$Cnt]["st_stacd"]	= $val["st_stacd"];		// �إ�����
	$arrBuffList[$ix][$Cnt]["st_sta"]	= $val["st_sta"];		// ��̾
	$arrBuffList[$ix][$Cnt]["count"]	= $val["count"];		// �ؤ�ʪ���

	// ����α��������ɤ���¸
	$prefcd	= $val["es_linecd"];
	$Cnt++;
}

//print_r($arrBuffList);

// GET�ͺ��� ar
// hidden����
FOREACH($_GET["ar"] as $key => $val){
	if ($get_str_ar == ''){
		$get_str_ar .= '?';
	} else {
		$get_str_ar .= '&';
	}
	$hidden_str .= '<input type="hidden" name="ar[]" value="' . $val . '">' . "\n";
	$get_str_ar .= 'ar[]=' . $val;
}
FOREACH($ln_cd as $key => $val){
	if ($get_str_ar == ''){
		$get_str_ar .= '?';
	} else {
		$get_str_ar .= '&';
	}
	$hidden_str .= '<input type="hidden" name="ln[]" value="' . $val . '">' . "\n";
	$get_str_ar .= 'ln[]=' . $val;
}
// ��������ѥ⡼�� 'ln' or 'st'
$hidden_str .= '<input type="hidden" name="mode" value="st">' . "\n";

// ���򤷤�������
$view_select_line .= '<h3 class="orange">���򤷤�����</h3>' . "\n";
$view_select_line .= '<div class="box">' . "\n";
$view_select_line .= '    <table class="search1">' . "\n";
$view_select_line .= '        <tr>' . "\n";
$view_select_line .= '            <td><div class="area">' . "\n";

$line_name_list1 = '';
$line_name_list2 = '';	

$cnt = 0;
FOREACH( $arrBuffList as $key => $val){

	//����޶��ڤ����̾�ꥹ��
	$line_name_list1 .= ','.$val[0]["es_line"];

	//�����ڤ����̾�ꥹ��
	if( $line_name_list2 != '' ) $line_name_list2 .= '��';
	$line_name_list2 .= $val[0]["es_line"];

	//$view_select_line .= '                <div class="areatext"><p><a href="#'.$key.'">'.$val[0]["es_line"].'��'.count($val).'���</a></p></div>'."\n";

	$cnt++;
	// ����̾��Ĺ������5�Ĥ���Ϥ߽Ф��㤦��
	//if( $cnt%5 == 0 ){
	if( $cnt%3 == 0 ){
		$view_select_line .= '                <div class="areatext2"><p><a href="#'.$key.'">'.$val[0]["es_line"].'</a></p></div>'."\n";
//		$view_select_line .= '                <div class="clear"></div>'."\n";
	}else{
		$view_select_line .= '                <div class="areatext2"><p><a href="#'.$key.'">'.$val[0]["es_line"].'</a></p></div>'."\n";
	}

	// ��������
	$view_station_list .= '<a name="'.$key.'"></a>';
	$view_station_list .= '<h3>' . $val[0]["es_line"] . '</h3>' . "\n";
	$view_station_list .= '<div class="box">' . "\n";
	$view_station_list .= '    <table class="search1">' . "\n";
	$view_station_list .= '        <tr>' . "\n";
	$view_station_list .= '            <td><p class="area">' . "\n";

	$cnt_br = 0;
	FOREACH( $val as $key2 => $val2){
		$view_station_list .= '                <label class="pl">';
		$view_station_list .= '<input type="checkbox" name="st[]" value="' . $val2["st_stacd"] . '">';
		$view_station_list .= ' <a href="/psearch-result/page-1.html' . $get_str_ar . '&st[]=' . $val2["st_stacd"] . '&mode=st' . '">' . $val2["st_sta"] . '�ء�' . $val2["count"] . '���</a></label>' . "\n";
		$cnt_br++;
		if( $cnt_br%3 == 0 ){
//			$view_station_list .= '                <br>'."\n";
		}
	}

	$view_station_list .= '            </p></td>' . "\n";
	$view_station_list .= '        </tr>' . "\n";
	$view_station_list .= '    </table>' . "\n";
	$view_station_list .= '</div>' . "\n";

}
$view_select_line .= '            </div></td>' . "\n";
$view_select_line .= '        </tr>' . "\n";
$view_select_line .= '    </table>' . "\n";
$view_select_line .= '</div>' . "\n";

//�����������title,keywords,description�����
//����̾����������

//title
$view_header_title = '';
$view_header_title = $line_name_list2.'�����γؽ��Τ�õ���óؽ��Ρ��ʳؽΡ���õ���Υݡ����륵���ȡֽΥ������';
//keywords
$view_header_keywoeds = '';
$view_header_keywoeds = '�ؽ���,�ʳؽ�,���̻�Ƴ,��ؼ���,�Υ�����,���ع�,��ع�,�⹻'.$line_name_list1;
//description
$view_header_description = '';
$view_header_description = '�Υ�����α�������̾���鸡���ڡ�����'.$line_name_list2.'�ˤǤ����Υ�����ϳؽ��Ρ��ʳؽ�õ���Υݡ����륵���ȤǤ���';
$view_header_description .= '�ϰ����Ū�ʼ����к����佤�ˡ���Ƴ���֡ʸ��̻�Ƴ�����Ϳ���Ƴ�����Ļ�Ƴ�ˡ��оݡʾ��ع�����ع����⹻����ءˤʤɤ����ñ�˽Τ򸡺��Ǥ��ޤ���';


//�ѥ󥯥�������
$query_str = "";
foreach( $_GET['ar'] as $key => $val ){
	if( $key == 0 ){
		$query_str .= "?ar[]=".$val;
	}else{
		$query_str .= "&ar[]=".$val;
	}
}
$view_pan_list = '<p class="topicpath"><strong><a href="/">HOME</a></strong><span class="paddinglr1">&gt;</span><strong><a href="/psearch-arealine/">��������̾����</a></strong><span class="paddinglr1">&gt;</span><strong><a href="/psearch-line/'.$query_str.'">���̱�������</a></strong><span class="paddinglr1">&gt;</span><strong>�ذ���</strong></p>';

?>