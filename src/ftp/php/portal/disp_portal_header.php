<?php

/*===================================================
    ���ɥ쥹����
===================================================*/
define( "_BLOG_SITE_URL_BASE" , $param_base_blog_addr_url );


//-------------------------------------------------------------------
// <HEAD> ���������
//-------------------------------------------------------------------
$arrMetaHeader = Array();

// <TITLE> ������ʬ - �֥������ȥ�
$arrMetaHeader["title"] = $arrHeaderView["blog_title"];

// <TITLE> ������ʬ - ���̾
$arrMetaHeader["title_corp"] = $arrHeaderView["cl_name"].$arrHeaderView["cl_shiten"];

// HTML�������
$arrMetaHeader["keyword"] = str_replace( "-" , "," , $arrHeaderView["blog_keyword"] );

// ����������ʸ
$arrMetaHeader["description"] = str_replace( "\n" , "" , str_replace( "\r" , "\n" , $arrHeaderView["blog_discription"] ) );



//-------------------------------------------------------------------
// ���̾�������
//-------------------------------------------------------------------

// ɽ���Ѳ�ҥ� - IMG��������
IF( $arrHeaderView["blog_cl_logo"] != "" ){
	$arrHeaderView["blog_cl_logo"] = "<IMG src=\"./img_thumbnail.php?w=200&h=60&dir={$param_cl_logo_path}&nm={$arrHeaderView["blog_cl_logo"]}\" alt=\"{$arrHeaderView["cl_name"]} {$arrHeaderView["cl_shiten"]}\">";
}

// �֥�����ʸ�β��Խ���
IF( $arrHeaderView["blog_discription"] != "" ){
	$arrHeaderView["blog_discription"] = nl2br( $arrHeaderView["blog_discription"] );
}



//-------------------------------------------------------------------
// ���顼������META/HEADER�ͤ���С��ѿ���
//-------------------------------------------------------------------
$arrErr["meta"] = $arrMetaHeader;
$arrErr["header"] = $arrHeaderView;


?>