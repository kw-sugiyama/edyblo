<?
/******************************************************************************
<< ��ư���֥���Ver.1.O.0 >>
    Name: client_upd.php
    Version: 1.0.0
    Function: ���饤�������Ͽ�������������Ͽ
    Author: Click inc
    Date of creation: 2007/02
    History of modification:
    Copyright (C)2007 Click, inc. All Rights Reserverd.
******************************************************************************/
/*----------------------------------------------------------
  ɬ�ץե�����ƤӽФ�
----------------------------------------------------------*/
require_once ( "../ini_sets_2.php" );
require_once ( SYS_PATH."dbif/dbcom_DBconnectClass.php" );
require_once ( SYS_PATH."dbif/basedb_AdminClass.php" );
require_once ( SYS_PATH."dbif/basedb_ClientClass.php" );
require_once ( SYS_PATH."dbif/basedb_BlogClass.php" );
require_once ( SYS_PATH."dbif/basedb_MenuClass.php" );
require_once ( SYS_PATH."dbif/basedb_LeftmenuClass.php" );
require_once ( SYS_PATH."dbif/basedb_AreaClass.php" );
require_once ( SYS_PATH."dbif/basedb_SchoolClass.php" );
require_once ( SYS_PATH."dbif/basedb_CategoryClass.php" );
require_once ( SYS_PATH."dbif/basedb_EnsenClass.php" );
require_once ( SYS_PATH."common/error.class.php" );
require_once ( SYS_PATH."common/sys_common.php" );
require_once ( SYS_PATH."configs/param_file.conf" );
/*----------------------------------------------------------
  ���å������Ͽ����
----------------------------------------------------------*/
session_start();
/*----------------------------------------------------------
  ���顼���饹 - ���󥹥���
----------------------------------------------------------*/
$obj_error = new DispErrMessage();
/*----------------------------------------------------------
  �ģ���³
----------------------------------------------------------*/
require_once( SYS_PATH."common/db_connect.php" );
/*----------------------------------------------------------
  �������������å�
----------------------------------------------------------*/
require_once("../login_chk.php");
/*----------------------------------------------------------
  ���顼��HIDDEN������
----------------------------------------------------------*/
$strErrHidden = "";
$strErrHidden .= "<INPUT type=\"hidden\" name=\"err_mode\" value=\"ERR\">\n";
FOREACH( $_POST as $key => $val ){

    $arrPostView[$key] = htmlspecialchars( stripslashes( $val ) );

    $buffData_err = "";
    $buffData_err = htmlspecialchars( stripslashes( $val ) );
    $strErrHidden .= "<INPUT type=\"hidden\" name=\"{$key}\" value=\"{$buffData_err}\">\n";
}
/*----------------------------------------------------------
  ���饤����Ȱ�������
----------------------------------------------------------*/
$obj2 = new basedb_ClientClassTblAccess;
$obj2->conn = $obj_conn->conn;
$obj2->jyoken["cl_deldate"] = 0;	// del_date���̵��
list( $intCnt , $intTotal ) = $obj2->basedb_GetClient( 1 , -1 );
if( $intCnt == -1 ){
    $obj_error->ViewErrMessage( "SYSTEM" , "ALL" , SITE_PATH."blank.php" , NULL );
    exit;
}

/*----------------------------------------------------------*/ 
//�ȼ��ɥᥤ�󡡽�����htaceess����
//�ȼ��ɥᥤ�����������Ѥ���ʤ��褦�˥����Ȥ˥������������
//�������������å��ե�����ʣУȣС�client_check.php �����Ѥ���
/*----------------------------------------------------------*/ 

/*----------------------------------------------------------
  �ģ�����
----------------------------------------------------------*/
require_once( SYS_PATH."common/db_close.php" );
//--------------------------------------------------------------------
// �ȼ��ɥᥤ���ѥǥ��쥯�ȥꡢhtaccess����
//--------------------------------------------------------------------
$intCount = 0;
FOREACH( $obj2->clientdat as $key => $val ) {
    // cl_urlcd��̤����ʤ饹�롼
    if ($val["cl_urlcd"] == "") continue;
    /////////////////////////////////////////////////////////////////////////////////////////////////////////
    //�ȼ��ɥᥤ���ѥե�����κ���
    /////////////////////////////////////////////////////////////////////////////////////////////////////////
    // �ȼ��ɥᥤ���ѥǥ��쥯�ȥ�����
    @mkdir( $param_dokuji_path.$val["cl_urlcd"] , 0755);
    // �ȼ��ɥᥤ����.htaccess�ե���������
    $pc_htaccess_fp = fopen($param_dokuji_path.$val["cl_urlcd"]."/.htaccess","w");
    if($pc_htaccess_fp===flase)exit("�ե����륪���ץ���");
    flock($pc_htaccess_fp,LOCK_EX);
    $htaccess_str = "";

    $htaccess_str .= "#############################################################\n";
    $htaccess_str .= "\n";
    $htaccess_str .= "# php setting - site_data\n";
    $htaccess_str .= "\n";
    $htaccess_str .= "#############################################################\n";
    $htaccess_str .= "\n";
    $htaccess_str .= "\n";
    $htaccess_str .= "# base setting\n";
    $htaccess_str .= "\n";
    $htaccess_str .= "php_flag register_globals off\n";
    $htaccess_str .= "php_flag magic_quotes_gpc on\n";
    $htaccess_str .= "php_flag display_errors on\n";
    $htaccess_str .= "php_flag magic_quotes_sybase off\n";
    $htaccess_str .= "\n";
    $htaccess_str .= "\n";
    $htaccess_str .= "# mbstring setting\n";
    $htaccess_str .= "\n";
    $htaccess_str .= "php_value mbstring.language Japanese\n";
    $htaccess_str .= "php_value mbstring.internal_encoding EUC-JP\n";
    $htaccess_str .= "php_value mbstring.http_input pass\n";
    $htaccess_str .= "php_flag  mbstring.encoding_translation on\n";
    $htaccess_str .= "php_value mbstring.substitute_character none\n";
    $htaccess_str .= "php_value mbstring.detect_order ASCII,EUC-JP,JIS,UTF-8,SJIS\n";
    $htaccess_str .= "php_value mbstring.func_overload 0\n";
    $htaccess_str .= "\n";
    $htaccess_str .= "\n";
    $htaccess_str .= "# session setting\n";
    $htaccess_str .= "\n";
    $htaccess_str .= "php_value session.name \"estate_blog_site_sess\"\n";
    $htaccess_str .= "php_flag  session.use_only_cookies on\n";
    $htaccess_str .= "php_value session.cache_limiter \"nocache\"\n";
    $htaccess_str .= "\n";
    $htaccess_str .= "\n";
    $htaccess_str .= "#############################################################\n";
    $htaccess_str .= "\n";
    $htaccess_str .= "# basic setting\n";
    $htaccess_str .= "\n";
    $htaccess_str .= "#############################################################\n";
    $htaccess_str .= "#AuthUserFile /home/jukutown.com/www/.htpasswd\n";
    $htaccess_str .= "#AuthGroupFile /dev/null\n";
    $htaccess_str .= "#AuthName \"Slash Area\"\n";
    $htaccess_str .= "#AuthType Basic\n";
    $htaccess_str .= "\n";
    $htaccess_str .= "#require valid-user\n";
    $htaccess_str .= "\n";
    $htaccess_str .= "#<Files ~ \"^.(htpasswd|htaccess)$\">\n";
    $htaccess_str .= "#    deny from all\n";
    $htaccess_str .= "#</Files> \n";
    $htaccess_str .= "\n";
    $htaccess_str .= "\n";
    $htaccess_str .= "############################################################\n";
    $htaccess_str .= "\n";
    $htaccess_str .= "# re-direct\n";
    $htaccess_str .= "\n";
    $htaccess_str .= "###########################################################\n";
    $htaccess_str .= "\n";
    $htaccess_str .= "#redirect permanent /dev/slash/estate/www/slash/ http://219.163.62.35/dev/slash/estate/www/click/ \n";
    $htaccess_str .= "\n";
    $htaccess_str .= "\n";
    $htaccess_str .= "\n";
    $htaccess_str .= "#############################################################\n";
    $htaccess_str .= "\n";
    $htaccess_str .= "# mod_rewrite setting - site_data\n";
    $htaccess_str .= "\n";
    $htaccess_str .= "#############################################################\n";
    $htaccess_str .= "\n";
    $htaccess_str .= "RewriteEngine On\n";
    $htaccess_str .= "RewriteBase   /\n";
    $htaccess_str .= "RewriteCond   %{REQUEST_FILENAME} !-f\n";
    $htaccess_str .= "RewriteCond   %{REQUEST_FILENAME} !-d\n";
    $htaccess_str .= "\n";
    $htaccess_str .= "\n";
    $htaccess_str .= "########################################################################################################\n";
    $htaccess_str .= "# portal setting\n";
    $htaccess_str .= "\n";
    $htaccess_str .= "# maintenance\n";
    $htaccess_str .= "#RewriteRule   ^client_tool/$                                       maintenance.html%{QUERY_STRING} [L]\n";
    $htaccess_str .= "#RewriteRule   ^client_tool/(.*)$                                   maintenance.html%{QUERY_STRING} [L]\n";
    $htaccess_str .= "\n";
    $htaccess_str .= "# sitemap.xml\n";
    $htaccess_str .= "#RewriteRule   ^sitemap.xml$                                         sitemap.xml%{QUERY_STRING} [L]\n";
    $htaccess_str .= "\n";
    $htaccess_str .= "# search result\n";
    $htaccess_str .= "#RewriteRule   ^phpinfo/$                                                              program/phpinfo.php%{QUERY_STRING} [L]\n";
    $htaccess_str .= "\n";
    $htaccess_str .= "# search result\n";
    $htaccess_str .= "#RewriteRule   ^kiyaku/$                                                               program/portal_tpl_control.php?tpl_flg=kiyaku%{QUERY_STRING} [L]\n";
    $htaccess_str .= "#RewriteRule   ^kiyaku/([a-z]{1}.*)$                                                   program/{$val["cl_urlcd"]}?%{QUERY_STRING} [L]\n";
    $htaccess_str .= "#RewriteRule   ^sitemap/$                                                              program/portal_tpl_control.php?tpl_flg=sitemap%{QUERY_STRING} [L]\n";
    $htaccess_str .= "#RewriteRule   ^sitemap/([a-z]{1}.*)$                                                  program/{$val["cl_urlcd"]}?%{QUERY_STRING} [L]\n";
    $htaccess_str .= "#RewriteRule   ^privacy/$                                                              program/portal_tpl_control.php?tpl_flg=privacy%{QUERY_STRING} [L]\n";
    $htaccess_str .= "#RewriteRule   ^privacy/([a-z]{1}.*)$                                                  program/{$val["cl_urlcd"]}?%{QUERY_STRING} [L]\n";
    $htaccess_str .= "#RewriteRule   ^com-pro/$                                                              program/portal_tpl_control.php?tpl_flg=com-pro%{QUERY_STRING} [L]\n";
    $htaccess_str .= "#RewriteRule   ^com-pro/([a-z]{1}.*)$                                                  program/{$val["cl_urlcd"]}?%{QUERY_STRING} [L]\n";
    $htaccess_str .= "#RewriteRule   ^forcom/$                                                               program/portal_tpl_control.php?tpl_flg=forcom%{QUERY_STRING} [L]\n";
    $htaccess_str .= "#RewriteRule   ^forcom/([a-z]{1}.*)$                                                   program/{$val["cl_urlcd"]}?%{QUERY_STRING} [L]\n";
    $htaccess_str .= "\n";
    $htaccess_str .= "# diary\n";
    $htaccess_str .= "#RewriteRule   ^diary/$                                                                program/portal_diary.php?%{QUERY_STRING} [L]\n";
    $htaccess_str .= "#RewriteRule   ^diary/([a-z]{1}.*)$                                                    program/{$val["cl_urlcd"]}?%{QUERY_STRING} [L]\n";
    $htaccess_str .= "\n";
    $htaccess_str .= "# inquiry\n";
    $htaccess_str .= "#RewriteRule   ^inquiry/([a-z]{1}.*)$                                                  program/{$val["cl_urlcd"]}?%{QUERY_STRING} [L]\n";
    $htaccess_str .= "#RewriteRule   ^inquiry/$                                                              program/portal_inquiry.php?%{QUERY_STRING} [L]\n";
    $htaccess_str .= "\n";
    $htaccess_str .= "# search result\n";
    $htaccess_str .= "#RewriteRule   ^psearch-result/page-([0-9]+)\.html$                                    program/portal_build_list.php?p={$val["cl_urlcd"]}&%{QUERY_STRING} [L]\n";
    $htaccess_str .= "#RewriteRule   ^psearch-result/([a-z]{1}.*)$                                           program/{$val["cl_urlcd"]}?%{QUERY_STRING} [L]\n";
    $htaccess_str .= "\n";
    $htaccess_str .= "# search map pages\n";
    $htaccess_str .= "#RewriteRule   ^psearch-map/$                                                          program/portal_search_map.php?%{QUERY_STRING} [L]\n";
    $htaccess_str .= "#RewriteRule   ^psearch-map/([a-z]{1}.*)$                                              program/{$val["cl_urlcd"]}?%{QUERY_STRING} [L]\n";
    $htaccess_str .= "\n";
    $htaccess_str .= "# search pages\n";
    $htaccess_str .= "#RewriteRule   ^psearch-com-([a-z]+)/([a-z]{1}.*)$                                     program/$1?page_flg={$val["cl_urlcd"]}&%{QUERY_STRING} [L]\n";
    $htaccess_str .= "#RewriteRule   ^psearch-com-([a-z]+)/$                                                 program/portal_search_com.php?page_flg={$val["cl_urlcd"]}&%{QUERY_STRING} [L]\n";
    $htaccess_str .= "\n";
    $htaccess_str .= "# search pages\n";
    $htaccess_str .= "#RewriteRule   ^psearch-([a-z]+)/([a-z]{1}.*)$                                         program/$1?page_flg={$val["cl_urlcd"]}&%{QUERY_STRING} [L]\n";
    $htaccess_str .= "#RewriteRule   ^psearch-([a-z]+)/$                                                     program/portal_search.php?page_flg={$val["cl_urlcd"]}&%{QUERY_STRING} [L]\n";
    $htaccess_str .= "\n";
    $htaccess_str .= "# company pages\n";
    $htaccess_str .= "#RewriteRule   ^pcompany-list/page-([0-9]+)\.html$                                     program/portal_company_list.php?p={$val["cl_urlcd"]}&%{QUERY_STRING} [L]\n";
    $htaccess_str .= "#RewriteRule   ^pcompany-list/([a-z]{1}.*)$                                            program/{$val["cl_urlcd"]}?%{QUERY_STRING} [L]\n";
    $htaccess_str .= "\n";
    $htaccess_str .= "# index\n";
    $htaccess_str .= "#RewriteRule   ^share/(.*)$                                                            program/share/{$val["cl_urlcd"]}?%{QUERY_STRING} [L]\n";
    $htaccess_str .= "#RewriteRule   ^$                                                                      program/portal_index.php?%{QUERY_STRING} [L]\n";
    $htaccess_str .= "\n";
    $htaccess_str .= "#####################################################################################################################\n";
    $htaccess_str .= "\n";
    $htaccess_str .= "# blog setting\n";
    $htaccess_str .= "\n";
    $htaccess_str .= "# MapTest\n";
    $htaccess_str .= "#RewriteRule  ^MapTest.php$                                               program/MapTest.php?%{QUERY_STRING} [L]\n";
    $htaccess_str .= "\n";
    $htaccess_str .= "# ����RSS\n";
    $htaccess_str .= "RewriteRule   ^diary-rss-([0-9]+)/([a-z]{1}.*)$                           program/$2?cl={$val["cl_urlcd"]}&dd=1&%{QUERY_STRING} [L]\n";
    $htaccess_str .= "RewriteRule   ^diary-rss-([0-9]+)/$                                       program/rss/rss_diary_$1.xml?cl={$val["cl_urlcd"]}&dd=1&%{QUERY_STRING} [L]\n";
    $htaccess_str .= "\n";
    $htaccess_str .= "# ������RSS\n";
    $htaccess_str .= "RewriteRule   ^course-rss-([0-9]+)/([a-z]{1}.*)$                          program/$2?cl={$val["cl_urlcd"]}&dd=1&%{QUERY_STRING} [L]\n";
    $htaccess_str .= "RewriteRule   ^course-rss-([0-9]+)/$                                      program/rss/rss_course_$1.xml?cl={$val["cl_urlcd"]}&dd=1&%{QUERY_STRING} [L]\n";
    $htaccess_str .= "\n";
    $htaccess_str .= "# ������������RSS\n";
    $htaccess_str .= "RewriteRule   ^rss-([0-9]+)/([a-z]{1}.*)$                                 program/$2?cl={$val["cl_urlcd"]}&dd=1&%{QUERY_STRING} [L]\n";
    $htaccess_str .= "RewriteRule   ^rss-([0-9]+)/$                                             program/rss/rss_$1.xml?cl={$val["cl_urlcd"]}&dd=1&%{QUERY_STRING} [L]\n";
    $htaccess_str .= "\n";
    $htaccess_str .= "# �����ܺ�\n";
    $htaccess_str .= "RewriteRule   ^blog-([0-9]+)/([a-z]{1}.*)$                                program/$2?cl={$val["cl_urlcd"]}&dd=1&drid=$1&%{QUERY_STRING} [L]\n";
    $htaccess_str .= "RewriteRule   ^blog-([0-9]+)/$                                            program/blog.php?cl={$val["cl_urlcd"]}&dd=1&drid=$1&%{QUERY_STRING} [L]\n";
    $htaccess_str .= "\n";
    $htaccess_str .= "# �����ڡ���ܺ�\n";
    $htaccess_str .= "RewriteRule   ^campaign-detail-([0-9]+)/([a-z]{1}.*)$                     program/$2?cl={$val["cl_urlcd"]}&dd=1&cpid=$1&%{QUERY_STRING} [L]\n";
    $htaccess_str .= "RewriteRule   ^campaign-detail-([0-9]+)/$                                 program/campaigndetail.php?cl={$val["cl_urlcd"]}&dd=1&cpid=$1&%{QUERY_STRING} [L]\n";
    $htaccess_str .= "\n";
    $htaccess_str .= "# �������ܺ�\n";
    $htaccess_str .= "RewriteRule   ^course-detail-([0-9]+)/([a-z]{1}.*)$                       program/$2?cl={$val["cl_urlcd"]}&dd=1&csid=$1&%{QUERY_STRING} [L]\n";
    $htaccess_str .= "RewriteRule   ^course-detail-([0-9]+)/$                                   program/coursedetail.php?cl={$val["cl_urlcd"]}&dd=1&csid=$1&%{QUERY_STRING} [L]\n";
    $htaccess_str .= "\n";
    $htaccess_str .= "# ���ΤޤǤ�ή��\n";
    $htaccess_str .= "RewriteRule   ^flow/([a-z]{1}.*)$                                         program/$1?cl={$val["cl_urlcd"]}&dd=1&%{QUERY_STRING} [L]\n";
    $htaccess_str .= "RewriteRule   ^flow/$                                                     program/flow.php?cl={$val["cl_urlcd"]}&dd=1&%{QUERY_STRING} [L]\n";
    $htaccess_str .= "\n";
    $htaccess_str .= "# �����ڡ��󤪿������ߥե�����\n";
    $htaccess_str .= "RewriteRule   ^campaign-apply/([a-z]{1}.*)$                               program/$1?cl={$val["cl_urlcd"]}&dd=1&%{QUERY_STRING} [L]\n";
    $htaccess_str .= "RewriteRule   ^campaign-apply/$                                           program/campaignapply.php?cl={$val["cl_urlcd"]}&dd=1&%{QUERY_STRING} [L]\n";
    $htaccess_str .= "\n";
    $htaccess_str .= "# �����ڡ��󤪿������߳�ǧ�ڡ���\n";
    $htaccess_str .= "RewriteRule   ^campaign-apply-confirm/([a-z]{1}.*)$                       program/$1?cl={$val["cl_urlcd"]}&dd=1&%{QUERY_STRING} [L]\n";
    $htaccess_str .= "RewriteRule   ^campaign-apply-confirm/$                                   program/campaignapplyconfirm.php?cl={$val["cl_urlcd"]}&dd=1&%{QUERY_STRING} [L]\n";
    $htaccess_str .= "\n";
    $htaccess_str .= "# �����ڡ����䤤��碌�ե�����\n";
    $htaccess_str .= "RewriteRule   ^campaign-inq/([a-z]{1}.*)$                                 program/$1?cl={$val["cl_urlcd"]}&dd=1&%{QUERY_STRING} [L]\n";
    $htaccess_str .= "RewriteRule   ^campaign-inq/$                                             program/campaigninq.php?cl={$val["cl_urlcd"]}&dd=1&%{QUERY_STRING} [L]\n";
    $htaccess_str .= "\n";
    $htaccess_str .= "# �����ڡ����䤤��碌��ǧ�ڡ���\n";
    $htaccess_str .= "RewriteRule   ^campaign-inq-confirm/([a-z]{1}.*)$                         program/$1?cl={$val["cl_urlcd"]}&dd=1&%{QUERY_STRING} [L]\n";
    $htaccess_str .= "RewriteRule   ^campaign-inq-confirm/$                                     program/campconfirm.php?cl={$val["cl_urlcd"]}&dd=1&%{QUERY_STRING} [L]\n";
    $htaccess_str .= "\n";
    $htaccess_str .= "# ���������䤤��碌�ե�����\n";
    $htaccess_str .= "RewriteRule   ^course-inq/([a-z]{1}.*)$                                   program/$1?cl={$val["cl_urlcd"]}&dd=1&%{QUERY_STRING} [L]\n";
    $htaccess_str .= "RewriteRule   ^course-inq/$                                               program/courseinq.php?cl={$val["cl_urlcd"]}&dd=1&%{QUERY_STRING} [L]\n";
    $htaccess_str .= "\n";
    $htaccess_str .= "# ���������䤤��碌��ǧ�ڡ���\n";
    $htaccess_str .= "RewriteRule   ^course-inq-confirm/([a-z]{1}.*)$                           program/$1?cl={$val["cl_urlcd"]}&dd=1&%{QUERY_STRING} [L]\n";
    $htaccess_str .= "RewriteRule   ^course-inq-confirm/$                                       program/courseinqconfirm.php?cl={$val["cl_urlcd"]}&dd=1&%{QUERY_STRING} [L]\n";
    $htaccess_str .= "\n";
    $htaccess_str .= "# ��������������ե�����\n";
    $htaccess_str .= "RewriteRule   ^course-req/([a-z]{1}.*)$                                   program/$1?cl={$val["cl_urlcd"]}&dd=1&%{QUERY_STRING} [L]\n";
    $htaccess_str .= "RewriteRule   ^course-req/$                                               program/coursereq.php?cl={$val["cl_urlcd"]}&dd=1&%{QUERY_STRING} [L]\n";
    $htaccess_str .= "\n";
    $htaccess_str .= "# ���������������ǧ�ڡ���\n";
    $htaccess_str .= "RewriteRule   ^course-req-confirm/([a-z]{1}.*)$                           program/$1?cl={$val["cl_urlcd"]}&dd=1&%{QUERY_STRING} [L]\n";
    $htaccess_str .= "RewriteRule   ^course-req-confirm/$                                       program/coursereqconfirm.php?cl={$val["cl_urlcd"]}&dd=1&%{QUERY_STRING} [L]\n";
    $htaccess_str .= "\n";
    $htaccess_str .= "# ��������ե�����\n";
    $htaccess_str .= "RewriteRule   ^req/([a-z]{1}.*)$                                          program/$1?cl={$val["cl_urlcd"]}&dd=1&%{QUERY_STRING} [L]\n";
    $htaccess_str .= "RewriteRule   ^req/$                                                      program/req.php?cl={$val["cl_urlcd"]}&dd=1&%{QUERY_STRING} [L]\n";
    $htaccess_str .= "\n";
    $htaccess_str .= "# ���������ǧ�ڡ���\n";
    $htaccess_str .= "RewriteRule   ^req-confirm/([a-z]{1}.*)$                                  program/$1?cl={$val["cl_urlcd"]}&dd=1&%{QUERY_STRING} [L]\n";
    $htaccess_str .= "RewriteRule   ^req-confirm/$                                              program/reqconfirm.php?cl={$val["cl_urlcd"]}&dd=1&%{QUERY_STRING} [L]\n";
    $htaccess_str .= "\n";
    $htaccess_str .= "# ���䤤��碌�ե�����\n";
    $htaccess_str .= "RewriteRule   ^inquire/([a-z]{1}.*)$                                      program/$1?cl={$val["cl_urlcd"]}&dd=1&%{QUERY_STRING} [L]\n";
    $htaccess_str .= "RewriteRule   ^inquire/$                                                  program/inquire.php?cl={$val["cl_urlcd"]}&dd=1&%{QUERY_STRING} [L]\n";
    $htaccess_str .= "\n";
    $htaccess_str .= "# ���䤤��碌��ǧ�ڡ���\n";
    $htaccess_str .= "RewriteRule   ^inq-confirm/([a-z]{1}.*)$                                  program/$1?cl={$val["cl_urlcd"]}&dd=1&%{QUERY_STRING} [L]\n";
    $htaccess_str .= "RewriteRule   ^inq-confirm/$                                              program/inqconfirm.php?cl={$val["cl_urlcd"]}&dd=1&%{QUERY_STRING} [L]\n";
    $htaccess_str .= "\n";
    $htaccess_str .= "# �Ƽ掠�󥭥塼�ڡ���\n";
    $htaccess_str .= "RewriteRule   ^complete/([a-z]{1}.*)$                                     program/$1?cl={$val["cl_urlcd"]}&dd=1&%{QUERY_STRING} [L]\n";
    $htaccess_str .= "RewriteRule   ^complete/$                                                 program/complete.php?cl={$val["cl_urlcd"]}&dd=1&%{QUERY_STRING} [L]\n";
    $htaccess_str .= "\n";
    $htaccess_str .= "# ��������\n";
    $htaccess_str .= "RewriteRule   ^school/([a-z]{1}.*)$                                       program/$1?cl={$val["cl_urlcd"]}&dd=1&%{QUERY_STRING} [L]\n";
    $htaccess_str .= "RewriteRule   ^school/$                                                   program/school.php?cl={$val["cl_urlcd"]}&dd=1&%{QUERY_STRING} [L]\n";
    $htaccess_str .= "\n";
    $htaccess_str .= "# ����������\n";
    $htaccess_str .= "RewriteRule   ^course-list/p-([0-9]+)/cs-([0-9]+)/([a-z]{1}.*)$           program/$3?cl={$val["cl_urlcd"]}&dd=1&page=$1&csid=$2&%{QUERY_STRING} [L]\n";
    $htaccess_str .= "RewriteRule   ^course-list/p-([0-9]+)/cs-([0-9]+)/$                       program/courselist.php?cl={$val["cl_urlcd"]}&dd=1&page=$1&csid=$2&%{QUERY_STRING} [L]\n";
    $htaccess_str .= "\n";
    $htaccess_str .= "# �����ڡ������\n";
    $htaccess_str .= "RewriteRule   ^campain-list/p-([0-9]+)/cp-([0-9]+)/([a-z]{1}.*)$          program/$3?cl={$val["cl_urlcd"]}&dd=1&page=$1&cpid=$2&%{QUERY_STRING} [L]\n";
    $htaccess_str .= "RewriteRule   ^campain-list/p-([0-9]+)/cp-([0-9]+)/$                      program/campaignlist.php?cl={$val["cl_urlcd"]}&dd=1&page=$1&cpid=$2&%{QUERY_STRING} [L]\n";
    $htaccess_str .= "\n";
    $htaccess_str .= "# ��������\n";
    $htaccess_str .= "RewriteRule   ^diary-list/p-([0-9]+)/dr-([0-9]+)/([a-z]{1}.*)$            program/$3?cl={$val["cl_urlcd"]}&dd=1&page=$1&drid=$2&%{QUERY_STRING} [L]\n";
    $htaccess_str .= "RewriteRule   ^diary-list/p-([0-9]+)/dr-([0-9]+)/$                        program/bloglist.php?cl={$val["cl_urlcd"]}&dd=1&page=$1&drid=$2&%{QUERY_STRING} [L]\n";
    $htaccess_str .= "\n";
    $htaccess_str .= "# �Ŀ;����ݸ�����\n";
    $htaccess_str .= "RewriteRule   ^kojin/([a-z]{1}.*)$                                        program/$1?cl={$val["cl_urlcd"]}&dd=1&%{QUERY_STRING} [L]\n";
    $htaccess_str .= "RewriteRule   ^kojin/$                                                    program/privacy.php?cl={$val["cl_urlcd"]}&dd=1&%{QUERY_STRING} [L]\n";
    $htaccess_str .= "\n";
    $htaccess_str .= "# Q&A\n";
    $htaccess_str .= "RewriteRule   ^qa/([a-z]{1}.*)$                                           program/$1?cl={$val["cl_urlcd"]}&dd=1&%{QUERY_STRING} [L]\n";
    $htaccess_str .= "RewriteRule   ^qa/$                                                       program/QA.php?cl={$val["cl_urlcd"]}&dd=1&%{QUERY_STRING} [L]\n";
    $htaccess_str .= "\n";
    $htaccess_str .= "# index\n";
    $htaccess_str .= "RewriteRule   ^img_thumbnail.php$                                         program/img_thumbnail.php?cl={$val["cl_urlcd"]}&dd=1&%{QUERY_STRING} [L]\n";
    $htaccess_str .= "RewriteRule   ^cl_img/(.*)$                                               program/cl_img/$1?cl={$val["cl_urlcd"]}&dd=1&%{QUERY_STRING} [L]\n";
    $htaccess_str .= "RewriteRule   ^share/(.*)$                                                program/share/$1?cl={$val["cl_urlcd"]}&dd=1&%{QUERY_STRING} [L]\n";
    $htaccess_str .= "RewriteRule   ^$                                                          program/index.php?cl={$val["cl_urlcd"]}&dd=1 [L]\n";
    $htaccess_str .= "\n";
    $htaccess_str .= "# �ե꡼�ڡ���\n";
    $htaccess_str .= "RewriteRule   ^free-([0-9]+)/([a-z]{1}.*)$                                program/$2?cl={$val["cl_urlcd"]}&dd=1&drid=$1&%{QUERY_STRING} [L]\n";
    $htaccess_str .= "RewriteRule   ^free-([0-9]+)/$                                            program/free.php?cl={$val["cl_urlcd"]}&dd=1&drid=$1&%{QUERY_STRING} [L]\n";
    $htaccess_str .= "\n";
    fputs($pc_htaccess_fp,$htaccess_str);
    flock($pc_htaccess_fp,LOCK_UN);
    fclose($pc_htaccess_fp);
    // �ȼ��ɥᥤ���ѥ���ܥ�å��������
    @symlink( $param_dokuji_path."source/program" , $param_dokuji_path.$val["cl_urlcd"]."/program" );
    // ����������
    $intCount++;
}
$message = "�ȼ��ɥᥤ���ѥǥ��쥯�ȥꡢ<br>�ե���������Хå�������λ��<br>{$intCount}��";
/*----------------------------------------------------------
  �ģ�����
----------------------------------------------------------*/
require_once( SYS_PATH."common/db_close.php" );
/*----------------------------------------------------------
  �ȣԣͣ�����
----------------------------------------------------------*/
?>
    <HTML>
    <HEAD>
    <TITLE>�Υ֥� - ��������ȴ����ġ���</title>
    <META http-equiv="Content-Type" content="text/html;charset=EUC-JP" />
    <META http-equiv="Content-Style-Type" content="text/css" />
    <META http-equiv="Content-Script-Type" content="text/javascript" />
    <LINK rel="stylesheet" href="../share/css/client.css" type="text/css" />
    <NOSCRIPT><META http-equiv="Refresh" content="1;URL=../jserror.html"></NOSCRIPT>
    </HEAD>
    <BODY>
    <div align="center">
    <input type="hidden" name="stpos" value="1">
    <table width="400" border="0" cellspacing="0" cellpadding="0">
    <tr>
    <td align="center">
    <br /><br /><br /><br /><br />
    <font size="3" color="#FF6600"><?=$message?></font>
    <br /><br /><br />
    </td>
    </tr>
    </table>
    </div>
    </body>
    </html>
