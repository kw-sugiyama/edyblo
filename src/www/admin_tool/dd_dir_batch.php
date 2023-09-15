<?
/******************************************************************************
<< 不動産ブログ　Ver.1.O.0 >>
	Name: client_main.php
	Version: 1.0.0
	Function: クライアント一覧
	Author: Click inc
	Date of creation: 2007/02
	History of modification:

	Copyright (C)2007 Click, inc. All Rights Reserverd.
******************************************************************************/

/*----------------------------------------------------------
  必要ファイル呼び出し
----------------------------------------------------------*/
require_once ( "./ini_sets_1.php" );
require_once ( SYS_PATH."dbif/dbcom_DBconnectClass.php" );
require_once ( SYS_PATH."dbif/basedb_AdminClass.php" );
require_once ( SYS_PATH."dbif/basedb_ClientadminClass.php" );
require_once ( SYS_PATH."common/error.class.php" );
require_once ( SYS_PATH."common/sys_common.php" );
require_once ( SYS_PATH."common/base_common.php" );
require_once ( SYS_PATH."configs/param_base.conf" );
require_once ( SYS_PATH."configs/param_file.conf" );


/*----------------------------------------------------------
  セッション登録開始
----------------------------------------------------------*/
session_start();


/*----------------------------------------------------------
  エラークラス - インスタンス
----------------------------------------------------------*/
$obj_error = new DispErrMessage();


/*----------------------------------------------------------
  ＤＢ接続
----------------------------------------------------------*/
require_once( SYS_PATH."common/db_connect.php" );


/*--------------------------------------------------------
	処理部分
--------------------------------------------------------*/
$obj2 = new basedb_ClientClassTblAccess;
$obj2->conn = $obj_conn->conn;
$obj2->jyoken["cl_deldate"] = 1;
$obj2->sort["cl_upddate"] = 1;
list( $intCnt , $intTotal ) = $obj2->basedb_GetClient( 1 , -1 );
if( $intCnt == -1 ){
        $obj_error->ViewErrMessage( "SYSTEM" , "ALL" , SITE_PATH."blank.php" , NULL );
        exit;
}


/*----------------------------------------------------------
  ＤＢ切断
----------------------------------------------------------*/
require_once( SYS_PATH."common/db_close.php" );


for($i=0;$i<$intCnt;$i++){

	// 独自ドメイン用ディレクトリ生成
	mkdir( $param_dokuji_path.$obj2->clientdat[$i]["cl_urlcd"] , 0755);

	// 独自ドメイン用.htaccessファイル生成
	$buildRssTmp = fopen($param_dokuji_path.$obj2->clientdat[$i]["cl_urlcd"]."/.htaccess","w");
	if($buildRssTmp===flase)exit("ファイルオープン失敗");
	flock($buildRssTmp,LOCK_EX);
		$rssBuildValue = "#############################################################\n";
		$rssBuildValue .= "\n";
		$rssBuildValue .= "# php setting - site_data\n";
		$rssBuildValue .= "\n";
		$rssBuildValue .= "#############################################################\n";
		$rssBuildValue .= "\n";
		$rssBuildValue .= "\n";
		$rssBuildValue .= "# base setting\n";
		$rssBuildValue .= "\n";
		$rssBuildValue .= "php_flag register_globals off\n";
		$rssBuildValue .= "php_flag magic_quotes_gpc on\n";
		$rssBuildValue .= "php_flag display_errors on\n";
		$rssBuildValue .= "php_flag magic_quotes_sybase off\n";
		$rssBuildValue .= "\n";
		$rssBuildValue .= "\n";
		$rssBuildValue .= "# mbstring setting\n";
		$rssBuildValue .= "\n";
		$rssBuildValue .= "php_value mbstring.language Japanese\n";
		$rssBuildValue .= "php_value mbstring.internal_encoding EUC-JP\n";
		$rssBuildValue .= "php_value mbstring.http_input pass\n";
		$rssBuildValue .= "php_flag  mbstring.encoding_translation on\n";
		$rssBuildValue .= "php_value mbstring.substitute_character none\n";
		$rssBuildValue .= "php_value mbstring.detect_order ASCII,EUC-JP,JIS,UTF-8,SJIS\n";
		$rssBuildValue .= "php_value mbstring.func_overload 0\n";
		$rssBuildValue .= "\n";
		$rssBuildValue .= "\n";
		$rssBuildValue .= "# session setting\n";
		$rssBuildValue .= "\n";
		$rssBuildValue .= "php_value session.name \"estate_blog_site_sess\"\n";
		$rssBuildValue .= "php_flag  session.use_only_cookies on\n";
		$rssBuildValue .= "php_value session.cache_limiter \"nocache\"\n";
		$rssBuildValue .= "\n";
		$rssBuildValue .= "\n";
		$rssBuildValue .= "#############################################################\n";
		$rssBuildValue .= "\n";
		$rssBuildValue .= "# basic setting\n";
		$rssBuildValue .= "\n";
		$rssBuildValue .= "#############################################################\n";
		$rssBuildValue .= "#AuthUserFile /home/jukutown.com/www/.htpasswd\n";
		$rssBuildValue .= "#AuthGroupFile /dev/null\n";
		$rssBuildValue .= "#AuthName \"Slash Area\"\n";
		$rssBuildValue .= "#AuthType Basic\n";
		$rssBuildValue .= "\n";
		$rssBuildValue .= "#require valid-user\n";
		$rssBuildValue .= "\n";
		$rssBuildValue .= "#<Files ~ \"^.(htpasswd|htaccess)$\">\n";
		$rssBuildValue .= "#    deny from all\n";
		$rssBuildValue .= "#</Files> \n";
		$rssBuildValue .= "\n";
		$rssBuildValue .= "\n";
		$rssBuildValue .= "############################################################\n";
		$rssBuildValue .= "\n";
		$rssBuildValue .= "# re-direct\n";
		$rssBuildValue .= "\n";
		$rssBuildValue .= "###########################################################\n";
		$rssBuildValue .= "\n";
		$rssBuildValue .= "#redirect permanent /dev/slash/estate/www/slash/ http://219.163.62.35/dev/slash/estate/www/click/ \n";
		$rssBuildValue .= "\n";
		$rssBuildValue .= "\n";
		$rssBuildValue .= "\n";
		$rssBuildValue .= "#############################################################\n";
		$rssBuildValue .= "\n";
		$rssBuildValue .= "# mod_rewrite setting - site_data\n";
		$rssBuildValue .= "\n";
		$rssBuildValue .= "#############################################################\n";
		$rssBuildValue .= "\n";
		$rssBuildValue .= "RewriteEngine On\n";
		$rssBuildValue .= "RewriteBase   /\n";
		$rssBuildValue .= "RewriteCond   %{REQUEST_FILENAME} !-f\n";
		$rssBuildValue .= "RewriteCond   %{REQUEST_FILENAME} !-d\n";
		$rssBuildValue .= "\n";
		$rssBuildValue .= "\n";
		$rssBuildValue .= "########################################################################################################\n";
		$rssBuildValue .= "# portal setting\n";
		$rssBuildValue .= "\n";
		$rssBuildValue .= "# maintenance\n";
		$rssBuildValue .= "#RewriteRule   ^client_tool/$                                       maintenance.html%{QUERY_STRING} [L]\n";
		$rssBuildValue .= "#RewriteRule   ^client_tool/(.*)$                                   maintenance.html%{QUERY_STRING} [L]\n";
		$rssBuildValue .= "\n";
		$rssBuildValue .= "# sitemap.xml\n";
		$rssBuildValue .= "#RewriteRule   ^sitemap.xml$                                         sitemap.xml%{QUERY_STRING} [L]\n";
		$rssBuildValue .= "\n";
		$rssBuildValue .= "# search result\n";
		$rssBuildValue .= "#RewriteRule   ^phpinfo/$                                                              program/phpinfo.php%{QUERY_STRING} [L]\n";
		$rssBuildValue .= "\n";
		$rssBuildValue .= "# search result\n";
		$rssBuildValue .= "#RewriteRule   ^kiyaku/$                                                               program/portal_tpl_control.php?tpl_flg=kiyaku%{QUERY_STRING} [L]\n";
		$rssBuildValue .= "#RewriteRule   ^kiyaku/([a-z]{1}.*)$                                                   program/{$obj2->clientdat[$i]["cl_urlcd"]}?%{QUERY_STRING} [L]\n";
		$rssBuildValue .= "#RewriteRule   ^sitemap/$                                                              program/portal_tpl_control.php?tpl_flg=sitemap%{QUERY_STRING} [L]\n";
		$rssBuildValue .= "#RewriteRule   ^sitemap/([a-z]{1}.*)$                                                  program/{$obj2->clientdat[$i]["cl_urlcd"]}?%{QUERY_STRING} [L]\n";
		$rssBuildValue .= "#RewriteRule   ^privacy/$                                                              program/portal_tpl_control.php?tpl_flg=privacy%{QUERY_STRING} [L]\n";
		$rssBuildValue .= "#RewriteRule   ^privacy/([a-z]{1}.*)$                                                  program/{$obj2->clientdat[$i]["cl_urlcd"]}?%{QUERY_STRING} [L]\n";
		$rssBuildValue .= "#RewriteRule   ^com-pro/$                                                              program/portal_tpl_control.php?tpl_flg=com-pro%{QUERY_STRING} [L]\n";
		$rssBuildValue .= "#RewriteRule   ^com-pro/([a-z]{1}.*)$                                                  program/{$obj2->clientdat[$i]["cl_urlcd"]}?%{QUERY_STRING} [L]\n";
		$rssBuildValue .= "#RewriteRule   ^forcom/$                                                               program/portal_tpl_control.php?tpl_flg=forcom%{QUERY_STRING} [L]\n";
		$rssBuildValue .= "#RewriteRule   ^forcom/([a-z]{1}.*)$                                                   program/{$obj2->clientdat[$i]["cl_urlcd"]}?%{QUERY_STRING} [L]\n";
		$rssBuildValue .= "\n";
		$rssBuildValue .= "# diary\n";
		$rssBuildValue .= "#RewriteRule   ^diary/$                                                                program/portal_diary.php?%{QUERY_STRING} [L]\n";
		$rssBuildValue .= "#RewriteRule   ^diary/([a-z]{1}.*)$                                                    program/{$obj2->clientdat[$i]["cl_urlcd"]}?%{QUERY_STRING} [L]\n";
		$rssBuildValue .= "\n";
		$rssBuildValue .= "# inquiry\n";
		$rssBuildValue .= "#RewriteRule   ^inquiry/([a-z]{1}.*)$                                                  program/{$obj2->clientdat[$i]["cl_urlcd"]}?%{QUERY_STRING} [L]\n";
		$rssBuildValue .= "#RewriteRule   ^inquiry/$                                                              program/portal_inquiry.php?%{QUERY_STRING} [L]\n";
		$rssBuildValue .= "\n";
		$rssBuildValue .= "# search result\n";
		$rssBuildValue .= "#RewriteRule   ^psearch-result/page-([0-9]+)\.html$                                    program/portal_build_list.php?p={$obj2->clientdat[$i]["cl_urlcd"]}&%{QUERY_STRING} [L]\n";
		$rssBuildValue .= "#RewriteRule   ^psearch-result/([a-z]{1}.*)$                                           program/{$obj2->clientdat[$i]["cl_urlcd"]}?%{QUERY_STRING} [L]\n";
		$rssBuildValue .= "\n";
		$rssBuildValue .= "# search map pages\n";
		$rssBuildValue .= "#RewriteRule   ^psearch-map/$                                                          program/portal_search_map.php?%{QUERY_STRING} [L]\n";
		$rssBuildValue .= "#RewriteRule   ^psearch-map/([a-z]{1}.*)$                                              program/{$obj2->clientdat[$i]["cl_urlcd"]}?%{QUERY_STRING} [L]\n";
		$rssBuildValue .= "\n";
		$rssBuildValue .= "# search pages\n";
		$rssBuildValue .= "#RewriteRule   ^psearch-com-([a-z]+)/([a-z]{1}.*)$                                     program/$1?page_flg={$obj2->clientdat[$i]["cl_urlcd"]}&%{QUERY_STRING} [L]\n";
		$rssBuildValue .= "#RewriteRule   ^psearch-com-([a-z]+)/$                                                 program/portal_search_com.php?page_flg={$obj2->clientdat[$i]["cl_urlcd"]}&%{QUERY_STRING} [L]\n";
		$rssBuildValue .= "\n";
		$rssBuildValue .= "# search pages\n";
		$rssBuildValue .= "#RewriteRule   ^psearch-([a-z]+)/([a-z]{1}.*)$                                         program/$1?page_flg={$obj2->clientdat[$i]["cl_urlcd"]}&%{QUERY_STRING} [L]\n";
		$rssBuildValue .= "#RewriteRule   ^psearch-([a-z]+)/$                                                     program/portal_search.php?page_flg={$obj2->clientdat[$i]["cl_urlcd"]}&%{QUERY_STRING} [L]\n";
		$rssBuildValue .= "\n";
		$rssBuildValue .= "# company pages\n";
		$rssBuildValue .= "#RewriteRule   ^pcompany-list/page-([0-9]+)\.html$                                     program/portal_company_list.php?p={$obj2->clientdat[$i]["cl_urlcd"]}&%{QUERY_STRING} [L]\n";
		$rssBuildValue .= "#RewriteRule   ^pcompany-list/([a-z]{1}.*)$                                            program/{$obj2->clientdat[$i]["cl_urlcd"]}?%{QUERY_STRING} [L]\n";
		$rssBuildValue .= "\n";
		$rssBuildValue .= "# index\n";
		$rssBuildValue .= "#RewriteRule   ^share/(.*)$                                                            program/share/{$obj2->clientdat[$i]["cl_urlcd"]}?%{QUERY_STRING} [L]\n";
		$rssBuildValue .= "#RewriteRule   ^$                                                                      program/portal_index.php?%{QUERY_STRING} [L]\n";
		$rssBuildValue .= "\n";
		$rssBuildValue .= "#####################################################################################################################\n";
		$rssBuildValue .= "\n";
		$rssBuildValue .= "# blog setting\n";
		$rssBuildValue .= "\n";
		$rssBuildValue .= "# MapTest\n";
		$rssBuildValue .= "#RewriteRule  ^MapTest.php$                                               program/MapTest.php?%{QUERY_STRING} [L]\n";
		$rssBuildValue .= "\n";
		$rssBuildValue .= "# 日記RSS\n";
		$rssBuildValue .= "RewriteRule   ^diary-rss-([0-9]+)/([a-z]{1}.*)$                           program/$2?cl={$obj2->clientdat[$i]["cl_urlcd"]}&dd=1&%{QUERY_STRING} [L]\n";
		$rssBuildValue .= "RewriteRule   ^diary-rss-([0-9]+)/$                                       program/rss/rss_diary_$1.xml?cl={$obj2->clientdat[$i]["cl_urlcd"]}&dd=1&%{QUERY_STRING} [L]\n";
		$rssBuildValue .= "\n";
		$rssBuildValue .= "# コースRSS\n";
		$rssBuildValue .= "RewriteRule   ^course-rss-([0-9]+)/([a-z]{1}.*)$                          program/$2?cl={$obj2->clientdat[$i]["cl_urlcd"]}&dd=1&%{QUERY_STRING} [L]\n";
		$rssBuildValue .= "RewriteRule   ^course-rss-([0-9]+)/$                                      program/rss/rss_course_$1.xml?cl={$obj2->clientdat[$i]["cl_urlcd"]}&dd=1&%{QUERY_STRING} [L]\n";
		$rssBuildValue .= "\n";
		$rssBuildValue .= "# コース＋日記RSS\n";
		$rssBuildValue .= "RewriteRule   ^rss-([0-9]+)/([a-z]{1}.*)$                                 program/$2?cl={$obj2->clientdat[$i]["cl_urlcd"]}&dd=1&%{QUERY_STRING} [L]\n";
		$rssBuildValue .= "RewriteRule   ^rss-([0-9]+)/$                                             program/rss/rss_$1.xml?cl={$obj2->clientdat[$i]["cl_urlcd"]}&dd=1&%{QUERY_STRING} [L]\n";
		$rssBuildValue .= "\n";
		$rssBuildValue .= "# 日記詳細\n";
		$rssBuildValue .= "RewriteRule   ^blog-([0-9]+)/([a-z]{1}.*)$                                program/$2?cl={$obj2->clientdat[$i]["cl_urlcd"]}&dd=1&drid=$1&%{QUERY_STRING} [L]\n";
		$rssBuildValue .= "RewriteRule   ^blog-([0-9]+)/$                                            program/blog.php?cl={$obj2->clientdat[$i]["cl_urlcd"]}&dd=1&drid=$1&%{QUERY_STRING} [L]\n";
		$rssBuildValue .= "\n";
		$rssBuildValue .= "# キャンペーン詳細\n";
		$rssBuildValue .= "RewriteRule   ^campaign-detail-([0-9]+)/([a-z]{1}.*)$                     program/$2?cl={$obj2->clientdat[$i]["cl_urlcd"]}&dd=1&cpid=$1&%{QUERY_STRING} [L]\n";
		$rssBuildValue .= "RewriteRule   ^campaign-detail-([0-9]+)/$                                 program/campaigndetail.php?cl={$obj2->clientdat[$i]["cl_urlcd"]}&dd=1&cpid=$1&%{QUERY_STRING} [L]\n";
		$rssBuildValue .= "\n";
		$rssBuildValue .= "# コース詳細\n";
		$rssBuildValue .= "RewriteRule   ^course-detail-([0-9]+)/([a-z]{1}.*)$                       program/$2?cl={$obj2->clientdat[$i]["cl_urlcd"]}&dd=1&csid=$1&%{QUERY_STRING} [L]\n";
		$rssBuildValue .= "RewriteRule   ^course-detail-([0-9]+)/$                                   program/coursedetail.php?cl={$obj2->clientdat[$i]["cl_urlcd"]}&dd=1&csid=$1&%{QUERY_STRING} [L]\n";
		$rssBuildValue .= "\n";
		$rssBuildValue .= "# 入塾までの流れ\n";
		$rssBuildValue .= "RewriteRule   ^flow/([a-z]{1}.*)$                                         program/$1?cl={$obj2->clientdat[$i]["cl_urlcd"]}&dd=1&%{QUERY_STRING} [L]\n";
		$rssBuildValue .= "RewriteRule   ^flow/$                                                     program/flow.php?cl={$obj2->clientdat[$i]["cl_urlcd"]}&dd=1&%{QUERY_STRING} [L]\n";
		$rssBuildValue .= "\n";
		$rssBuildValue .= "# キャンペーンお申し込みフォーム\n";
		$rssBuildValue .= "RewriteRule   ^campaign-apply/([a-z]{1}.*)$                               program/$1?cl={$obj2->clientdat[$i]["cl_urlcd"]}&dd=1&%{QUERY_STRING} [L]\n";
		$rssBuildValue .= "RewriteRule   ^campaign-apply/$                                           program/campaignapply.php?cl={$obj2->clientdat[$i]["cl_urlcd"]}&dd=1&%{QUERY_STRING} [L]\n";
		$rssBuildValue .= "\n";
		$rssBuildValue .= "# キャンペーンお申し込み確認ページ\n";
		$rssBuildValue .= "RewriteRule   ^campaign-apply-confirm/([a-z]{1}.*)$                       program/$1?cl={$obj2->clientdat[$i]["cl_urlcd"]}&dd=1&%{QUERY_STRING} [L]\n";
		$rssBuildValue .= "RewriteRule   ^campaign-apply-confirm/$                                   program/campaignapplyconfirm.php?cl={$obj2->clientdat[$i]["cl_urlcd"]}&dd=1&%{QUERY_STRING} [L]\n";
		$rssBuildValue .= "\n";
		$rssBuildValue .= "# キャンペーンお問い合わせフォーム\n";
		$rssBuildValue .= "RewriteRule   ^campaign-inq/([a-z]{1}.*)$                                 program/$1?cl={$obj2->clientdat[$i]["cl_urlcd"]}&dd=1&%{QUERY_STRING} [L]\n";
		$rssBuildValue .= "RewriteRule   ^campaign-inq/$                                             program/campaigninq.php?cl={$obj2->clientdat[$i]["cl_urlcd"]}&dd=1&%{QUERY_STRING} [L]\n";
		$rssBuildValue .= "\n";
		$rssBuildValue .= "# キャンペーンお問い合わせ確認ページ\n";
		$rssBuildValue .= "RewriteRule   ^campaign-inq-confirm/([a-z]{1}.*)$                         program/$1?cl={$obj2->clientdat[$i]["cl_urlcd"]}&dd=1&%{QUERY_STRING} [L]\n";
		$rssBuildValue .= "RewriteRule   ^campaign-inq-confirm/$                                     program/campconfirm.php?cl={$obj2->clientdat[$i]["cl_urlcd"]}&dd=1&%{QUERY_STRING} [L]\n";
		$rssBuildValue .= "\n";
		$rssBuildValue .= "# コースお問い合わせフォーム\n";
		$rssBuildValue .= "RewriteRule   ^course-inq/([a-z]{1}.*)$                                   program/$1?cl={$obj2->clientdat[$i]["cl_urlcd"]}&dd=1&%{QUERY_STRING} [L]\n";
		$rssBuildValue .= "RewriteRule   ^course-inq/$                                               program/courseinq.php?cl={$obj2->clientdat[$i]["cl_urlcd"]}&dd=1&%{QUERY_STRING} [L]\n";
		$rssBuildValue .= "\n";
		$rssBuildValue .= "# コースお問い合わせ確認ページ\n";
		$rssBuildValue .= "RewriteRule   ^course-inq-confirm/([a-z]{1}.*)$                           program/$1?cl={$obj2->clientdat[$i]["cl_urlcd"]}&dd=1&%{QUERY_STRING} [L]\n";
		$rssBuildValue .= "RewriteRule   ^course-inq-confirm/$                                       program/courseinqconfirm.php?cl={$obj2->clientdat[$i]["cl_urlcd"]}&dd=1&%{QUERY_STRING} [L]\n";
		$rssBuildValue .= "\n";
		$rssBuildValue .= "# コース資料請求フォーム\n";
		$rssBuildValue .= "RewriteRule   ^course-req/([a-z]{1}.*)$                                   program/$1?cl={$obj2->clientdat[$i]["cl_urlcd"]}&dd=1&%{QUERY_STRING} [L]\n";
		$rssBuildValue .= "RewriteRule   ^course-req/$                                               program/coursereq.php?cl={$obj2->clientdat[$i]["cl_urlcd"]}&dd=1&%{QUERY_STRING} [L]\n";
		$rssBuildValue .= "\n";
		$rssBuildValue .= "# コース資料請求確認ページ\n";
		$rssBuildValue .= "RewriteRule   ^course-req-confirm/([a-z]{1}.*)$                           program/$1?cl={$obj2->clientdat[$i]["cl_urlcd"]}&dd=1&%{QUERY_STRING} [L]\n";
		$rssBuildValue .= "RewriteRule   ^course-req-confirm/$                                       program/coursereqconfirm.php?cl={$obj2->clientdat[$i]["cl_urlcd"]}&dd=1&%{QUERY_STRING} [L]\n";
		$rssBuildValue .= "\n";
		$rssBuildValue .= "# 資料請求フォーム\n";
		$rssBuildValue .= "RewriteRule   ^req/([a-z]{1}.*)$                                          program/$1?cl={$obj2->clientdat[$i]["cl_urlcd"]}&dd=1&%{QUERY_STRING} [L]\n";
		$rssBuildValue .= "RewriteRule   ^req/$                                                      program/req.php?cl={$obj2->clientdat[$i]["cl_urlcd"]}&dd=1&%{QUERY_STRING} [L]\n";
		$rssBuildValue .= "\n";
		$rssBuildValue .= "# 資料請求確認ページ\n";
		$rssBuildValue .= "RewriteRule   ^req-confirm/([a-z]{1}.*)$                                  program/$1?cl={$obj2->clientdat[$i]["cl_urlcd"]}&dd=1&%{QUERY_STRING} [L]\n";
		$rssBuildValue .= "RewriteRule   ^req-confirm/$                                              program/reqconfirm.php?cl={$obj2->clientdat[$i]["cl_urlcd"]}&dd=1&%{QUERY_STRING} [L]\n";
		$rssBuildValue .= "\n";
		$rssBuildValue .= "# お問い合わせフォーム\n";
		$rssBuildValue .= "RewriteRule   ^inquire/([a-z]{1}.*)$                                      program/$1?cl={$obj2->clientdat[$i]["cl_urlcd"]}&dd=1&%{QUERY_STRING} [L]\n";
		$rssBuildValue .= "RewriteRule   ^inquire/$                                                  program/inquire.php?cl={$obj2->clientdat[$i]["cl_urlcd"]}&dd=1&%{QUERY_STRING} [L]\n";
		$rssBuildValue .= "\n";
		$rssBuildValue .= "# お問い合わせ確認ページ\n";
		$rssBuildValue .= "RewriteRule   ^inq-confirm/([a-z]{1}.*)$                                  program/$1?cl={$obj2->clientdat[$i]["cl_urlcd"]}&dd=1&%{QUERY_STRING} [L]\n";
		$rssBuildValue .= "RewriteRule   ^inq-confirm/$                                              program/inqconfirm.php?cl={$obj2->clientdat[$i]["cl_urlcd"]}&dd=1&%{QUERY_STRING} [L]\n";
		$rssBuildValue .= "\n";
		$rssBuildValue .= "# 各種サンキューページ\n";
		$rssBuildValue .= "RewriteRule   ^complete/([a-z]{1}.*)$                                     program/$1?cl={$obj2->clientdat[$i]["cl_urlcd"]}&dd=1&%{QUERY_STRING} [L]\n";
		$rssBuildValue .= "RewriteRule   ^complete/$                                                 program/complete.php?cl={$obj2->clientdat[$i]["cl_urlcd"]}&dd=1&%{QUERY_STRING} [L]\n";
		$rssBuildValue .= "\n";
		$rssBuildValue .= "# 教室案内\n";
		$rssBuildValue .= "RewriteRule   ^school/([a-z]{1}.*)$                                       program/$1?cl={$obj2->clientdat[$i]["cl_urlcd"]}&dd=1&%{QUERY_STRING} [L]\n";
		$rssBuildValue .= "RewriteRule   ^school/$                                                   program/school.php?cl={$obj2->clientdat[$i]["cl_urlcd"]}&dd=1&%{QUERY_STRING} [L]\n";
		$rssBuildValue .= "\n";
		$rssBuildValue .= "# コース一覧\n";
		$rssBuildValue .= "RewriteRule   ^course-list/p-([0-9]+)/cs-([0-9]+)/([a-z]{1}.*)$           program/$3?cl={$obj2->clientdat[$i]["cl_urlcd"]}&dd=1&page=$1&csid=$2&%{QUERY_STRING} [L]\n";
		$rssBuildValue .= "RewriteRule   ^course-list/p-([0-9]+)/cs-([0-9]+)/$                       program/courselist.php?cl={$obj2->clientdat[$i]["cl_urlcd"]}&dd=1&page=$1&csid=$2&%{QUERY_STRING} [L]\n";
		$rssBuildValue .= "\n";
		$rssBuildValue .= "# キャンペーン一覧\n";
		$rssBuildValue .= "RewriteRule   ^campain-list/p-([0-9]+)/cp-([0-9]+)/([a-z]{1}.*)$          program/$3?cl={$obj2->clientdat[$i]["cl_urlcd"]}&dd=1&page=$1&cpid=$2&%{QUERY_STRING} [L]\n";
		$rssBuildValue .= "RewriteRule   ^campain-list/p-([0-9]+)/cp-([0-9]+)/$                      program/campaignlist.php?cl={$obj2->clientdat[$i]["cl_urlcd"]}&dd=1&page=$1&cpid=$2&%{QUERY_STRING} [L]\n";
		$rssBuildValue .= "\n";
		$rssBuildValue .= "# 日記一覧\n";
		$rssBuildValue .= "RewriteRule   ^diary-list/p-([0-9]+)/dr-([0-9]+)/([a-z]{1}.*)$            program/$3?cl={$obj2->clientdat[$i]["cl_urlcd"]}&dd=1&page=$1&drid=$2&%{QUERY_STRING} [L]\n";
		$rssBuildValue .= "RewriteRule   ^diary-list/p-([0-9]+)/dr-([0-9]+)/$                        program/bloglist.php?cl={$obj2->clientdat[$i]["cl_urlcd"]}&dd=1&page=$1&drid=$2&%{QUERY_STRING} [L]\n";
		$rssBuildValue .= "\n";
		$rssBuildValue .= "# 個人情報保護方針\n";
		$rssBuildValue .= "RewriteRule   ^kojin/([a-z]{1}.*)$                                        program/$1?cl={$obj2->clientdat[$i]["cl_urlcd"]}&dd=1&%{QUERY_STRING} [L]\n";
		$rssBuildValue .= "RewriteRule   ^kojin/$                                                    program/privacy.php?cl={$obj2->clientdat[$i]["cl_urlcd"]}&dd=1&%{QUERY_STRING} [L]\n";
		$rssBuildValue .= "\n";
		$rssBuildValue .= "# Q&A\n";
		$rssBuildValue .= "RewriteRule   ^qa/([a-z]{1}.*)$                                           program/$1?cl={$obj2->clientdat[$i]["cl_urlcd"]}&dd=1&%{QUERY_STRING} [L]\n";
		$rssBuildValue .= "RewriteRule   ^qa/$                                                       program/QA.php?cl={$obj2->clientdat[$i]["cl_urlcd"]}&dd=1&%{QUERY_STRING} [L]\n";
		$rssBuildValue .= "\n";
		$rssBuildValue .= "# index\n";
		$rssBuildValue .= "RewriteRule   ^img_thumbnail.php$                                         program/img_thumbnail.php?cl={$obj2->clientdat[$i]["cl_urlcd"]}&dd=1&%{QUERY_STRING} [L]\n";
		$rssBuildValue .= "RewriteRule   ^share/(.*)$                                                program/share/$1?cl={$obj2->clientdat[$i]["cl_urlcd"]}&dd=1&%{QUERY_STRING} [L]\n";
		$rssBuildValue .= "RewriteRule   ^$                                                          program/index.php?cl={$obj2->clientdat[$i]["cl_urlcd"]}&dd=1 [L]\n";
		$rssBuildValue .= "\n";

	fputs($buildRssTmp,$rssBuildValue);
	flock($buildRssTmp,LOCK_UN);
	fclose($buildRssTmp);

	// 独自ドメイン用シンボリックリンク生成
	symlink( $param_dokuji_path."source/program" , $param_dokuji_path.$obj2->clientdat[$i]["cl_urlcd"]."/program" );

}

echo("作成完了！");
?>
