<?php
/**************************************************************************

	���饤����Ⱦ�������å�
		��
	�쥤�����Ȼ�������å�
		��
	���ɥ쥹�١�������

**************************************************************************/


// $_GET["cl"] ���ͤ����ꤵ��Ƥ��ʤ���Х��顼

IF( $_GET["cl"] == "" ){
	$obj_error->ViewErrMessage( "MENT" , "USER-ALL" , "#" , NULL );
	echo "error";
	exit;
}

/*
//���ƥʥ󥹽���
if( $_GET['dd'] == 1 ){
	header("HTTP/1.1 503 Service Temporarily Unavailable");
	header("Location: ".$param_base_blog_addr_url."/".$_GET["cl"]."/");
}
//*/

// ���������դ��������
$today = date("Y-m-d");

// �������꡿����
$obj_login = new viewdb_ClientClassTblAccess;
$obj_login->conn = $obj_conn->conn;
$obj_login->jyoken["cl_urlcd"] = $_GET['cl'];	// URL�ѥ����ɤ�$_GET["cl"]�Τ��
$obj_login->jyoken["cl_stat"] = 1;			// ���饤����Ȥ�"ͭ��"
$obj_login->jyoken["cl_deldate"] = 1;			// ���饤����Ⱦ��󤬺������Ƥ��ʤ�
$obj_login->jyoken["cl_start"] = $today;		// ��������ȳ��Ϥ���������� or ̵����
$obj_login->jyoken["cl_end"] = $today;		// ��������Ƚ�λ���������� or ̵����
$obj_login->jyoken["sc_stat"] = 1;			// �֥����ܾ������ꤵ��Ƥ���



list( $intCnt_login , $intTotal_login ) = $obj_login->viewdb_GetClient ( 1 , -1 );
IF( $intCnt_login != 1 ){
	$obj_error->ViewErrMessage( "MENT" , "USER-ALL" , "#" , NULL );
	exit;
}

// ���饤����Ȥ�ͭ�����¤�����˳���Ƥ����饨�顼
$today = date("Y-m-d");
IF( $obj_login->clientdat[0]["cl_start"] != "" ){
	if( $obj_login->clientdat[0]["cl_start"] > $today ){
		$obj_error->ViewErrMessage( "MENT" , "USER-ALL" , "#" , NULL );
//	echo "ok";
		exit;
	}
}
IF( $obj_login->clientdat[0]["cl_end"] != "" ){
	if( $obj_login->clientdat[0]["cl_end"] < $today ){
		$obj_error->ViewErrMessage( "MENT" , "USER-ALL" , "#" , NULL );
//	echo "ok1";
		exit;
	}
}

// ���饤����Ⱦ��� or �֥����ܾ��� ���������Ƥ����饨�顼
if( $obj_login->clientdat[0]["cl_deldate"] != "" || $obj_login->clientdat[0]["sc_deldate"] != "" ){
	$obj_error->ViewErrMessage( "MENT" , "USER-ALL" , "#" , NULL );
//	echo "ok2";
	exit;
}

// "���饤����Ȥ�ͭ���Ǥʤ�" or "�֥����ܾ������ꤵ��Ƥ��ʤ����" �ϥ��顼
if( $obj_login->clientdat[0]["cl_stat"] != 1 || $obj_login->clientdat[0]["sc_stat"] != 1 ){
	$obj_error->ViewErrMessage( "MENT" , "USER-ALL" , "#" , NULL );
	echo "error";
	echo $obj_login->clientdat[0]["cl_stat"];
	echo "<br />";
//echo $obj_login->clientdat[0]["sc_stat"];
	exit;
}

// �ȼ��ե饰���ԲĤʤΤ��ȼ��ɥᥤ�����³�����饨�顼
if( $obj_login->clientdat[0]["cl_dokuji_flg"] != 1 && $_GET['dd']==1 ){
	$obj_error->ViewErrMessage( "MENT" , "USER-ALL" , "#" , NULL );
//	echo "ok3";
	exit;
}


// ����˻��ꥯ�饤�����ID���ݻ�
define( "_cl_id" , $obj_login->clientdat[0]["cl_id"] );


/*===================================================
    ����쥤�����ȳ�ǧ
===================================================*/
IF( $obj_login->clientdat[0]["sc_clr"] == "" ){
	$obj_error->ViewErrMessage( "MENT" , "USER-ALL" , "#" , NULL );
	echo "ok4";
	exit;
}ELSE{
	$buffSiteLayout = "css".$obj_login->clientdat[0]["blog_layout"];
	define( "_SITE_LAYOUT" , $buffSiteLayout );
	$buffSiteTemplate = "template".$obj_login->clientdat[0]["blog_layout"];
	define( "_SITE_TEMPLATE" , $buffSiteTemplate );
}


/*===================================================
    �ȼ��ɥᥤ����GoogleMapApiKey���ؤ�����
===================================================*/
if($obj_login->clientdat[0]["cl_googlemap_key"]!="" && $obj_login->clientdat[0]["cl_dokuji_flg"]==1 && $obj_login->clientdat[0]["cl_dokuji_domain"]!="" && $_GET['dd']==1 ){
	$param_api_key = $obj_login->clientdat[0]["cl_googlemap_key"];
}


/*===================================================
    ���ɥ쥹����
===================================================*/

if($_GET['dd']!=1){
	define( "_BLOG_SITE_URL_BASE" , $param_base_blog_addr.$_GET["cl"]."/" );
}else if($_GET['dd']==1){
	define( "_BLOG_SITE_URL_BASE" , $param_base_blog_addr );
}


// ���ȼ��ե饰���ġפǡ��ȼ��ɥᥤ�󤸤�ʤ���³�פ��ä���
// �ȼ��ɥᥤ��URL�����Ф�
// �� �ȼ��ɥᥤ�󥪥�ˤʤäƤ��� http://reblo.sp-jobnet.co.jp/sample/search-result/page-1.html �˥�������������
//    http://tsubaki.sp-jobnet.co.jp/search-result/page-1.html �˥�����쥯��
if( $obj_login->clientdat[0]["cl_dokuji_flg"] == 1 && $obj_login->clientdat[0]["cl_dokuji_domain"] != "" && $_GET['dd']!=1 ){

	// �� $_SERVER['REQUEST_URI'](���ꤵ�줿URI) �� /sample/search-result/page-1.html

	$arr_url = array();
	$str_url = "";
	// /sample/search-result/page-1.html �򥹥�å����ʬ��
	// $arr_url[0] �� ""
	// $arr_url[1] �� "sample"
	// $arr_url[2] �� "search-result"
	// $arr_url[3] �� "page-1.html"
	$arr_url = explode("/" , $_SERVER['REQUEST_URI']);

	// $arr_url[0]��$arr_url[1] �������������ͤ��
	unset($arr_url[0],$arr_url[1]);
	// $arr_url�򥹥�å����Ϣ��
	$str_url = join("/", $arr_url);
	// $str_url �� search-result/page-1.html
	// �ȼ��ɥᥤ���URL�ȹ���

	// http 301 Moved Permanently
	// ���٤��餺�äȤ��ä��򸫤����衢�ߤ����ʰ�̣��
	// �ѡ��ޥͥ�ȥ꡼ (Permanently) �ϡֱʵס��ʵס�����Ū��
	header("HTTP/1.1 301 Moved Permanently");
	header("Location: {$obj_login->clientdat[0]["cl_dokuji_domain"]}{$str_url}");
	exit;
}

/*----------------------------------------------------------
 ���ӥ�����쥯�Ƚ���
----------------------------------------------------------*/

/*
//20091204 �����ȥ�����
//���Ӥ�ͭ���ξ��ˤϷ��ӥ����Ȥ˥�����쥯��
if( $obj_login->clientdat[0][cl_mobile_flg] == 1 ){
	
	$agent = $_SERVER['HTTP_USER_AGENT']; 
	$linkurl='/'.$_GET["cl"].'/';
	if(preg_match("/^DoCoMo/i", $agent) || preg_match("/^(J\-PHONE|Vodafone|MOT\-[CV]|SoftBank)/i", $agent) || preg_match("/^KDDI\-/i", $agent) || preg_match("/UP\.Browser/i", $agent) ){
	  header('Location:'.$param_base_mobile_blog_addr_url.$linkurl);
	  exit;
	}
	
	//google���ӥץ����� �����쥯�ȥ���
	$alternate_tag ='<link rel="alternate" media="handheld" href="'.$param_base_mobile_blog_addr_url.$linkurl.'" />';
}

*/

// ------------------------------------------------------------------
// ���ޥե��Ǥؤ�ͶƳ��������
// -----------------------------------------------------------------
$sp_button_disp_flag = false;
$ua = $_SERVER["HTTP_USER_AGENT"];
if ( $obj_login->clientdat[0]["cl_smartphone_flg"] == 1 ) {
	if ( (strpos($ua, 'iPhone') !== false) || 
	     (strpos($ua, 'iPod') !== false) || 
	     (strpos($ua, 'Android') !== false) && (strpos($ua, 'Mobile') !== false) 
	   ) {
		$sp_button_disp_flag = true;
		$sp_button_link_url  = "http://sp.jukutown.com/". $obj_login->clientdat[0]["cl_urlcd"]."/";
	}
}


?>

