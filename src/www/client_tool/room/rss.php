<?php
/******************************************************************************
<< 不動産ブログ　Ver.1.O.0 >>
	Name: room_upd.php
	Version: 1.0.0
	Function: 建物情報 登録／修正／削除
	Author: Click inc
	Date of creation: 2007/02
	History of modification:

	Copyright (C)2007 Click, inc. All Rights Reserverd.
******************************************************************************/


/*----------------------------------------------------------
  必要ファイル呼び出し
----------------------------------------------------------*/
require_once ( "../ini_sets_2.php" );
require_once ( "../html_delete.php" );
require_once ( SYS_PATH."dbif/dbcom_DBconnectClass.php" );
require_once ( SYS_PATH."dbif/basedb_AdminClass.php" );
require_once ( SYS_PATH."dbif/basedb_RoomClass.php" );
require_once ( SYS_PATH."dbif/basedb_ClientClass.php" );
require_once ( SYS_PATH."dbif/basedb_DiaryClass.php" );
require_once ( SYS_PATH."dbif/viewdb_DiaryClass.php" );
require_once ( SYS_PATH."dbif/viewdb_BuildClass.php" );
require_once ( SYS_PATH."dbif/viewdb_ClientClass.php" );
require_once ( SYS_PATH."common/base_common.php" );
require_once ( SYS_PATH."common/sys_common.php" );
include_once ( SYS_PATH."common/error.class.php" );
require_once ( SYS_PATH."common/ImageControl.class.php" );
require_once ( SYS_PATH."common/common_ping.php" );
require_once ( SYS_PATH."configs/param_base.conf" );
require_once ( SYS_PATH."configs/param_file.conf" );
require_once ( SYS_PATH."configs/param_room.conf" );
require_once ( SYS_PATH."configs/param_ping.conf" );


/*----------------------------------------------------------
	エラークラス - インスタンス
----------------------------------------------------------*/
$obj_error = new DispErrMessage();


/*----------------------------------------------------------
  ＤＢ接続
----------------------------------------------------------*/
require_once( SYS_PATH."common/db_connect.php" );


//クライアントIDをセット
$_SESSION['_cl_id'] = $_GET['id'];

//modeをセット
$_POST["mode"] = $_GET['mode'];

define( '_BLOG_SITE_URL_BASE' , $_GET['base'] );

$param_base_blog_addr_url = $_GET['addr_url'];

$param_base_blog_addr = $_GET['addr'];

//---------------------------
//会社・ブログ基本情報抽出
$obj_cl_blog = new viewdb_ClientClassTblAccess;
$obj_cl_blog->conn = $obj_conn->conn;
$obj_cl_blog->jyoken["cl_del_date"] = 1;
$obj_cl_blog->jyoken["blog_del_date"] = 1;
$obj_cl_blog->jyoken["cl_id"] = $_SESSION['_cl_id'];
list( $rssCnt , $rssTotal ) = $obj_cl_blog->viewdb_GetClient ( 1 , -1 );

//---------------------------
//建物ＲＳＳ生成

//建物+部屋情報抽出
$obj_rev_rss = new viewdb_BuildClassTblAccess;
$obj_rev_rss->conn = $obj_conn->conn;
$obj_rev_rss->jyoken["build_del_date"] = 1;
$obj_rev_rss->jyoken["room_del_date"] = 1;
$obj_rev_rss->jyoken["room_vacant"] = 2;				// 部屋状態が「空き」のもの
$obj_rev_rss->jyoken["build_cl_id"] = $_SESSION['_cl_id'];
$obj_rev_rss->sort["room_upd_date"] = 2;				// 並び順 - 部屋情報最終更新日時で降順
list( $rssCnt , $rssTotal ) = $obj_rev_rss->viewdb_GetBuild ( 1 , -1 );

//各アイテム（物件情報）XMLタグ生成
$rssBuildItemValue = "";
$sitemapBuildItemValue = "";
for($rssX=0;$rssX<$rssCnt;$rssX++){
	// timestamp形をRFC822形式へ変更
	$bufDate1 = explode( "." , $obj_rev_rss->builddat[$rssX]["room_upd_date"] );	// マイクロ秒を切り捨てる
	$bufDate2 = explode( " " , $bufDate1[0] );			// 日付と時間を分ける
	$bufDate3_1 = explode( "-" , $bufDate2[0] );			// 年月日を分ける
	$bufDate3_2 = explode( ":" , $bufDate2[1] );			// 時分秒を分ける
	$bufTimeUnix = mktime( $bufDate3_2[0] , $bufDate3_2[1] , $bufDate3_2[2] , $bufDate3_1[1] , $bufDate3_1[2] , $bufDate3_1[0] );
	$strSemiUpdate = date( "r" , $bufTimeUnix );

	$rssBuildItemValue .= "    <item>\n";
	$rssBuildItemValue .= "      <title>";
	$rssBuildItemValue .= $obj_rev_rss->builddat[$rssX]['build_line_name_1'].$obj_rev_rss->builddat[$rssX]['build_sta_name_1']."駅から徒歩".$obj_rev_rss->builddat[$rssX]['build_move_1']."分";
	if($obj_rev_rss->builddat[$rssX]['build_move_bus_1']!="")$rssBuildItemValue .= " バス".$obj_rev_rss->builddat[$rssX]['build_move_bus_1']."分";

	//間取り表示内容生成
	asort( $param_room_floor["disp_no"] );
	FOREACH( $param_room_floor["disp_no"] as $key => $val ){
		if($param_room_floor['id'][$key] == $obj_rev_rss->builddat[$rssX]['room_madori'])$rssBuildItemValue .= " ".$param_room_floor['val'][$key];
	}
	$rssBuildItemValue .= " 家賃".number_format($obj_rev_rss->builddat[$rssX]['room_price'])."円</title>\n";
	$rssBuildItemValue .= "      <link>"._BLOG_SITE_URL_BASE."room-".$obj_rev_rss->builddat[$rssX]['room_id']."/</link>\n";
//	$rssRoomUpdDate = substr($obj_rev_rss->builddat[$rssX]['room_upd_date'],"20","7");
	$rssBuildItemValue .= "      <guid>"._BLOG_SITE_URL_BASE."room-".$obj_rev_rss->builddat[$rssX]['room_id']."/</guid>\n";
	$rssBuildItemValue .= "      <description>".$obj_rev_rss->builddat[$rssX]['room_pr']."</description>\n";
	$rssBuildItemValue .= "      <pubDate>".$strSemiUpdate."</pubDate>\n";
	$rssBuildItemValue .= "    </item>\n";

	$sitemapBuildItemValue .= "    <url>\n";
	$sitemapBuildItemValue .= "    <loc>"._BLOG_SITE_URL_BASE."room-".$obj_rev_rss->builddat[$rssX]['room_id']."/</loc>\n";
	$sitemapBuildItemValue .= "    <priority>1.0</priority>\n";
	$sitemapBuildItemValue .= "    <changefreq>always</changefreq>\n";
	$sitemapBuildItemValue .= "    <lastmod>".$strSemiUpdate."</lastmod>\n";
	$sitemapBuildItemValue .= "    </url>\n";
}
//echo(_BLOG_SITE_URL_BASE);
//RSSファイル生成
$buildRssTmp = fopen(RSS_BLOG_PATH."rss_build_".$_SESSION['_cl_id'].".tmp","w");
if($buildRssTmp===flase)exit("ファイルオープン失敗");
flock($buildRssTmp,LOCK_EX);
$rssBuildValue = "<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n";
$rssBuildValue .= "<?xml-stylesheet type=\"text/css\" href=\"rss.css\"?>\n";
$rssBuildValue .= "<rss version=\"2.0\">\n";
$rssBuildValue .= "  <channel>\n";
$rssBuildValue .= "    <title>".$obj_cl_blog->clientdat[0]['blog_title']."</title>\n";
$rssBuildValue .= "    <link>"._BLOG_SITE_URL_BASE.$login_val['cl_url_cd']."</link>\n";
$rssBuildValue .= "    <copyright>".$obj_cl_blog->clientdat[0]['cl_name'].$obj_cl_blog->clientdat[0]['cl_shiten']."</copyright>\n";
$rssBuildValue .= "    <description>".$obj_cl_blog->clientdat[0]['blog_discription']."</description>\n";
$rssBuildValue .= $rssBuildItemValue;
$rssBuildValue .= "  </channel>\n";
$rssBuildValue .= "</rss>\n";

$buildSitemapTmp = fopen(RSS_BLOG_PATH."sitemap_build_".$_SESSION['_cl_id'].".tmp","w");
if($buildSitemapTmp===flase)exit("ファイルオープン失敗");
flock($buildSitemapTmp,LOCK_EX);
$sitemapBuildValue = "<?xml version=\"1.0\" encoding=\"UTF-8\" ?>\n";
$sitemapBuildValue .= "<urlset xmlns=\"http://www.google.com/schemas/sitemap/0.84\">\n";
$sitemapBuildValue .= $sitemapBuildItemValue;
$sitemapBuildValue .= "</urlset>\n";

asort( $rss );
$countrss = count($rss);
FOREACH( $rss as $key => $val ){
	$rssBuildValue = str_replace($val,"",$rssBuildValue);
}

$rssBuildValue = mb_convert_encoding($rssBuildValue,"UTF-8","EUC-JP");
fputs($buildRssTmp,$rssBuildValue);
flock($buildRssTmp,LOCK_UN);
fclose($buildRssTmp);
$cpBuildRss = copy(RSS_BLOG_PATH."rss_build_".$_SESSION['_cl_id'].".tmp", RSS_BLOG_PATH."rss_build_".$_SESSION['_cl_id'].".xml");
//$rnBuildRss = rename(RSS_BLOG_PATH."rss_build_".$_SESSION['_cl_id'].".tmp", RSS_BLOG_PATH."rss_build_".$_SESSION['_cl_id'].".xml");
if($cpBuildRss===flase)exit("ファイルコピー失敗");

$exBuildRss = file_exists(RSS_BLOG_PATH."rss_build_".$_SESSION['_cl_id'].".xml");
if($exBuildRss !== FALSE){
	$dlBuildRss = unlink(RSS_BLOG_PATH."rss_build_".$_SESSION['_cl_id'].".tmp");
	if($dlBuildRss===flase)exit("ファイル削除失敗");
}

$sitemapBuildValue = mb_convert_encoding($sitemapBuildValue,"UTF-8","EUC-JP");
fputs($buildSitemapTmp,$sitemapBuildValue);
flock($buildSitemapTmp,LOCK_UN);
fclose($buildSitemapTmp);
$cpBuildSitemap = copy(RSS_BLOG_PATH."sitemap_build_".$_SESSION['_cl_id'].".tmp", RSS_BLOG_PATH."sitemap_build_".$_SESSION['_cl_id'].".xml");
//$rnBuildRss = rename(RSS_BLOG_PATH."sitemap_build_".$_SESSION['_cl_id'].".tmp", RSS_BLOG_PATH."sitemap_build_".$_SESSION['_cl_id'].".xml");
if($cpBuildSitemap===flase)exit("ファイルコピー失敗");

$exBuildSitemap = file_exists(RSS_BLOG_PATH."sitemap_build_".$_SESSION['_cl_id'].".xml");
if($exBuildSitemap !== FALSE){
	$dlBuildSitemap = unlink(RSS_BLOG_PATH."sitemap_build_".$_SESSION['_cl_id'].".tmp");
	if($dlBuildSitemap===flase)exit("ファイル削除失敗");
}

//---------------------------
//スタッフ日記ＲＳＳ生成

//建物+部屋情報抽出
$obj_rss_diary_blog = new basedb_DiaryClassTblAccess;
$obj_rss_diary_blog->conn = $obj_conn->conn;
$obj_rss_diary_blog->jyoken["diary_del_date"] = 1;
$obj_rss_diary_blog->jyoken["diary_cl_id"] = $_SESSION['_cl_id'];
$obj_rss_diary_blog->sort["diary_upd_date"] = 2;				// 並び順 - 部屋情報最終更新日時で降順
list( $rssDiaryBlogCnt , $rssDiaryBlogTotal ) = $obj_rss_diary_blog->basedb_GetDiary ( 1 , -1 );

//各アイテム（スタッフ日記情報）XMLタグ生成
$rssDiaryItemValue = "";
$rssDiaryItemValue .= $rssBuildItemValue;
$sitemapDiaryItemValue = "";
$sitemapDiaryItemValue .= $sitemapBuildItemValue;
for($rssX=0;$rssX<$rssDiaryBlogCnt;$rssX++){
	// timestamp形をRFC822形式へ変更
	$bufDate1 = explode( "." , $obj_rss_diary_blog->diarydat[$rssX]["diary_upd_date"] );	// マイクロ秒を切り捨てる
	$bufDate2 = explode( " " , $bufDate1[0] );			// 日付と時間を分ける
	$bufDate3_1 = explode( "-" , $bufDate2[0] );			// 年月日を分ける
	$bufDate3_2 = explode( ":" , $bufDate2[1] );			// 時分秒を分ける
	$bufTimeUnix = mktime( $bufDate3_2[0] , $bufDate3_2[1] , $bufDate3_2[2] , $bufDate3_1[1] , $bufDate3_1[2] , $bufDate3_1[0] );
	$strSemiUpdate = date( "r" , $bufTimeUnix );

	$rssDiaryItemValue .= "    <item>\n";
	$rssDiaryItemValue .= "      <title>".$obj_rss_diary_blog->diarydat[$rssX]['diary_title']."</title>\n";
	$rssDiaryItemValue .= "      <link>"._BLOG_SITE_URL_BASE."diary-detail-".$obj_rss_diary_blog->diarydat[$rssX]['diary_id']."/</link>\n";
	$rssDiaryItemValue .= "      <guid>"._BLOG_SITE_URL_BASE."diary-detail-".$obj_rss_diary_blog->diarydat[$rssX]['diary_id']."/</guid>\n";
	$rssDiaryItemValue .= "      <description>".$obj_rss_diary_blog->diarydat[$rssX]['diary_contents']."</description>\n";
	$rssDiaryItemValue .= "      <pubDate>".$strSemiUpdate."</pubDate>\n";
	$rssDiaryItemValue .= "    </item>\n";

	$sitemapDiaryItemValue .= "    <url>\n";
	$sitemapDiaryItemValue .= "    <loc>"._BLOG_SITE_URL_BASE."diary-detail-".$obj_rss_diary_blog->diarydat[$rssX]['diary_id']."/</loc>\n";
	$sitemapDiaryItemValue .= "    <priority>1.0</priority>\n";
	$sitemapDiaryItemValue .= "    <changefreq>always</changefreq>\n";
	$sitemapDiaryItemValue .= "    <lastmod>".$strSemiUpdate."</lastmod>\n";
	$sitemapDiaryItemValue .= "    </url>\n";
}

//RSSファイル生成
$diaryRssTmp = fopen(RSS_BLOG_PATH."rss_".$_SESSION['_cl_id'].".tmp","w");
if($diaryRssTmp===flase)exit("ファイルオープン失敗");
flock($diaryRssTmp,LOCK_EX);
$rssDiaryValue = "<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n";
$rssDiaryValue .= "<?xml-stylesheet type=\"text/css\" href=\"rss.css\"?>\n";
$rssDiaryValue .= "<rss version=\"2.0\">\n";
$rssDiaryValue .= "  <channel>\n";
$rssDiaryValue .= "    <title>".$obj_cl_blog->clientdat[0]['blog_title']."</title>\n";
$rssDiaryValue .= "    <link>"._BLOG_SITE_URL_BASE.$login_val['cl_url_cd']."</link>\n";
$rssDiaryValue .= "    <copyright>".$obj_cl_blog->clientdat[0]['cl_name'].$obj_cl_blog->clientdat[0]['cl_shiten']."</copyright>\n";
$rssDiaryValue .= "    <description>".$obj_cl_blog->clientdat[0]['blog_discription']."</description>\n";
$rssDiaryValue .= $rssDiaryItemValue;
$rssDiaryValue .= "  </channel>\n";
$rssDiaryValue .= "</rss>\n";
$rssDiaryValue = html_delete($rssDiaryValue);

$diarySitemapTmp = fopen(RSS_BLOG_PATH."sitemap_".$_SESSION['_cl_id'].".tmp","w");
if($diarySitemapTmp===flase)exit("ファイルオープン失敗");
flock($diarySitemapTmp,LOCK_EX);
$sitemapDiaryValue = "<?xml version=\"1.0\" encoding=\"UTF-8\" ?>\n";
$sitemapDiaryValue .= "<urlset xmlns=\"http://www.google.com/schemas/sitemap/0.84\">\n";
$sitemapDiaryValue .= $sitemapDiaryItemValue;
$sitemapDiaryValue .= "</urlset>\n";

asort( $rss );
$countrss = count($rss);
FOREACH( $rss as $key => $val ){
	$rssDiaryValue = str_replace($val,"",$rssDiaryValue);
}

$rssDiaryValue = mb_convert_encoding($rssDiaryValue,"UTF-8","EUC-JP");
fputs($diaryRssTmp,$rssDiaryValue);
flock($diaryRssTmp,LOCK_UN);
fclose($diaryRssTmp);
$cpBuildRss = copy(RSS_BLOG_PATH."rss_".$_SESSION['_cl_id'].".tmp", RSS_BLOG_PATH."rss_".$_SESSION['_cl_id'].".xml");
//$rnBuildRss = rename(RSS_BLOG_PATH."rss_".$_SESSION['_cl_id'].".tmp", RSS_BLOG_PATH."rss_".$_SESSION['_cl_id'].".xml");
if($cpBuildRss===flase)exit("ファイルコピー失敗");

$exBuildRss = file_exists(RSS_BLOG_PATH."rss_".$_SESSION['_cl_id'].".xml");
if($exBuildRss !== FALSE){
	$dlBuildRss = unlink(RSS_BLOG_PATH."rss_".$_SESSION['_cl_id'].".tmp");
	if($dlBuildRss===flase)exit("ファイル削除失敗");
}

$sitemapDiaryValue = mb_convert_encoding($sitemapDiaryValue,"UTF-8","EUC-JP");
fputs($diarySitemapTmp,$sitemapDiaryValue);
flock($diarySitemapTmp,LOCK_UN);
fclose($diarySitemapTmp);
$cpDiarySitemap = copy(RSS_BLOG_PATH."sitemap_".$_SESSION['_cl_id'].".tmp", RSS_BLOG_PATH."sitemap_".$_SESSION['_cl_id'].".xml");
//$rnBuildRss = rename(RSS_BLOG_PATH."sitemap_".$_SESSION['_cl_id'].".tmp", RSS_BLOG_PATH."sitemap_".$_SESSION['_cl_id'].".xml");
if($cpDiarySitemap===flase)exit("ファイルコピー失敗");

$exBuildSitemap = file_exists(RSS_BLOG_PATH."sitemap_".$_SESSION['_cl_id'].".xml");
if($exBuildSitemap !== FALSE){
	$dlBuildSitemap = unlink(RSS_BLOG_PATH."sitemap_".$_SESSION['_cl_id'].".tmp");
	if($dlBuildSitemap===flase)exit("ファイル削除失敗");
}


// リフレッシュ
$obj_rev_rss->builddat = array();
$obj_rss_diary_blog->diarydat = array();


//---------------------------
//建物ＲＳＳ生成

//建物+部屋情報抽出
$obj_rss_buidP = new viewdb_BuildClassTblAccess;
$obj_rss_buidP->conn = $obj_conn->conn;
$obj_rss_buidP->jyoken["build_del_date"] = 1;
$obj_rss_buidP->jyoken["room_del_date"] = 1;
$obj_rss_buidP->jyoken["room_vacant"] = 2;				// 部屋状態が「空き」のもの
$obj_rss_buidP->sort["room_upd_date"] = 2;				// 並び順 - 部屋情報最終更新日時で降順
list( $rssCnt , $rssTotal ) = $obj_rss_buidP->viewdb_GetBuild ( 1 , 50 );

//各アイテム（物件情報）XMLタグ生成

$rssBuildItemValue = "";
$sitemapBuildItemValue = "";
for($rssX=0;$rssX<$rssCnt;$rssX++){

//	$obj_rss_buidPURLcode = new viewdb_ClientClassTblAccess;
//	$obj_rss_buidPURLcode->conn = $obj_conn->conn;
//	$obj_rss_buidPURLcode->jyoken["cl_id"] = $obj_rss_buidP->builddat[$rssX]["build_cl_id"];
//	list( $rssUcCnt , $rssUcTotal ) = $obj_rss_buidPURLcode->viewdb_GetClient ( 1 , -1 );

	// timestamp形をRFC822形式へ変更
	$bufDate1 = explode( "." , $obj_rss_buidP->builddat[$rssX]["room_upd_date"] );	// マイクロ秒を切り捨てる
	$bufDate2 = explode( " " , $bufDate1[0] );			// 日付と時間を分ける
	$bufDate3_1 = explode( "-" , $bufDate2[0] );			// 年月日を分ける
	$bufDate3_2 = explode( ":" , $bufDate2[1] );			// 時分秒を分ける
	$bufTimeUnix = mktime( $bufDate3_2[0] , $bufDate3_2[1] , $bufDate3_2[2] , $bufDate3_1[1] , $bufDate3_1[2] , $bufDate3_1[0] );
	$strSemiUpdate = date( "r" , $bufTimeUnix );

	$rssBuildItemValue .= "    <item>\n";
	$rssBuildItemValue .= "      <title>";
	$rssBuildItemValue .= $obj_rss_buidP->builddat[$rssX]['build_line_name_1'].$obj_rss_buidP->builddat[$rssX]['build_sta_name_1']."駅から徒歩".$obj_rss_buidP->builddat[$rssX]['build_move_1']."分";
	if($obj_rss_buidP->builddat[$rssX]['build_move_bus_1']!="")$rssBuildItemValue .= " バス".$obj_rss_buidP->builddat[$rssX]['build_move_bus_1']."分";

	//間取り表示内容生成
	asort( $param_room_floor["disp_no"] );
	FOREACH( $param_room_floor["disp_no"] as $key => $val ){
		if($param_room_floor['id'][$key] == $obj_rss_buidP->builddat[$rssX]['room_madori'])$rssBuildItemValue .= " ".$param_room_floor['val'][$key];
	}
	$rssBuildItemValue .= " 家賃".number_format($obj_rss_buidP->builddat[$rssX]['room_price'])."円</title>\n";
	$rssBuildItemValue .= "      <link>".$param_base_blog_addr_url.$param_base_blog_addr.$obj_rss_buidP->builddat[$rssX]['cl_url_code']."/room-".$obj_rss_buidP->builddat[$rssX]['room_id']."/</link>\n";
	$rssBuildItemValue .= "      <guid>".$param_base_blog_addr_url.$param_base_blog_addr.$obj_rss_buidP->builddat[$rssX]['cl_url_code']."/room-".$obj_rss_buidP->builddat[$rssX]['room_id']."/</guid>\n";
	$rssBuildItemValue .= "      <description></description>\n";
	$rssBuildItemValue .= "      <pubDate>".$strSemiUpdate."</pubDate>\n";
	$rssBuildItemValue .= "    </item>\n";

	$sitemapBuildItemValue .= "    <url>\n";
	$sitemapBuildItemValue .= "    <loc>".$param_base_blog_addr_url.$param_base_blog_addr.$obj_rss_buidP->builddat[$rssX]['cl_url_code']."/room-".$obj_rss_buidP->builddat[$rssX]['room_id']."/</loc>\n";
	$sitemapBuildItemValue .= "    <priority>1.0</priority>\n";
	$sitemapBuildItemValue .= "    <changefreq>always</changefreq>\n";
	$sitemapBuildItemValue .= "    <lastmod>".$strSemiUpdate."</lastmod>\n";
	$sitemapBuildItemValue .= "    </url>\n";
}

//RSSファイル生成
$buildPRssTmp = fopen(RSS_PORTAL_PATH."rss_build.tmp","w");
if($buildPRssTmp===flase)exit("ファイルオープン失敗");
flock($buildPRssTmp,LOCK_EX);
$rssBuildValue = "<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n";
$rssBuildValue .= "<?xml-stylesheet type=\"text/css\" href=\"rss.css\"?>\n";
$rssBuildValue .= "<rss version=\"2.0\">\n";
$rssBuildValue .= "  <channel>\n";
$rssBuildValue .= "    <title>賃貸マンション、アパートの検索ならReBlo[リブロ]全国の物件がじっくり探せる賃貸物件情報検索サイト！</title>\n";
$rssBuildValue .= "    <link>".$param_base_blog_addr_url.$param_base_blog_addr."</link>\n";
$rssBuildValue .= "    <copyright>powered by SLASH</copyright>\n";
$rssBuildValue .= "    <description></description>\n";
$rssBuildValue .= $rssBuildItemValue;
$rssBuildValue .= "  </channel>\n";
$rssBuildValue .= "</rss>\n";

$buildPSitemapTmp = fopen(RSS_PORTAL_PATH."sitemap_build.tmp","w");
if($buildPSitemapTmp===flase)exit("ファイルオープン失敗");
flock($buildPSitemapTmp,LOCK_EX);
$sitemapBuildValue = "<?xml version=\"1.0\" encoding=\"UTF-8\" ?>\n";
$sitemapBuildValue .= "<urlset xmlns=\"http://www.google.com/schemas/sitemap/0.84\">\n";
$sitemapBuildValue .= $sitemapBuildItemValue;
$sitemapBuildValue .= "</urlset>\n";

asort( $rss );
$countrss = count($rss);
FOREACH( $rss as $key => $val ){
	$rssBuildValue = str_replace($val,"",$rssBuildValue);
}

$rssBuildValue = mb_convert_encoding($rssBuildValue,"UTF-8","EUC-JP");
fputs($buildPRssTmp,$rssBuildValue);
flock($buildPRssTmp,LOCK_UN);
fclose($buildPRssTmp);
$cpBuildRss = copy(RSS_PORTAL_PATH."rss_build.tmp", RSS_PORTAL_PATH."rss_build.xml");
if($cpBuildRss===false)exit("ファイルコピー失敗");

$exBuildRss = file_exists(RSS_PORTAL_PATH."rss_build.xml");
if($exBuildRss !== FALSE){
	$dlBuildRss = unlink(RSS_PORTAL_PATH."rss_build.tmp");
	if($dlBuildRss===flase)exit("ファイル削除失敗");
}


$sitemapBuildValue = mb_convert_encoding($sitemapBuildValue,"UTF-8","EUC-JP");
fputs($buildPSitemapTmp,$sitemapBuildValue);
flock($buildPSitemapTmp,LOCK_UN);
fclose($buildPSitemapTmp);
$cpBuildSite = copy(RSS_PORTAL_PATH."sitemap_build.tmp", RSS_PORTAL_PATH."sitemap_build.xml");
if($cpBuildSite===false)exit("ファイルコピー失敗");

$exBuildSitemap = file_exists(RSS_PORTAL_PATH."sitemap_build.xml");
if($exBuildSitemap !== FALSE){
	$dlBuildSitemap = unlink(RSS_PORTAL_PATH."sitemap_build.tmp");
	if($dlBuildSitemap===flase)exit("ファイル削除失敗");
}

//---------------------------
//スタッフ日記ＲＳＳ生成

//建物+部屋情報抽出
$obj_rss_diary_blog = new viewdb_DiaryClassTblAccess;
$obj_rss_diary_blog->conn = $obj_conn->conn;
$obj_rss_diary_blog->jyoken["diary_del_date"] = 1;
$obj_rss_diary_blog->sort["diary_upd_date"] = 2;				// 並び順 - 部屋情報最終更新日時で降順
list( $rssDiaryBlogCnt , $rssDiaryBlogTotal ) = $obj_rss_diary_blog->viewdb_GetDiary ( 1 , 50 );

//各アイテム（スタッフ日記情報）XMLタグ生成
$rssDiaryItemValue = "";
$rssDiaryItemValue .= $rssBuildItemValue;
$sitemapDiaryItemValue = "";
$sitemapDiaryItemValue .= $sitemapBuildItemValue;
for($rssX=0;$rssX<$rssDiaryBlogCnt;$rssX++){

//	$obj_rss_diary_blogURLcode = new viewdb_ClientClassTblAccess;
//	$obj_rss_diary_blogURLcode->conn = $obj_conn->conn;
//	$obj_rss_diary_blogURLcode->jyoken["cl_id"] = $obj_rss_diary_blog->diarydat[$rssX]["diary_cl_id"];
//	list( $rssUcCnt , $rssUcTotal ) = $obj_rss_diary_blogURLcode->viewdb_GetClient ( 1 , -1 );

	// timestamp形をRFC822形式へ変更
	$bufDate1 = explode( "." , $obj_rss_diary_blog->diarydat[$rssX]["diary_upd_date"] );	// マイクロ秒を切り捨てる
	$bufDate2 = explode( " " , $bufDate1[0] );			// 日付と時間を分ける
	$bufDate3_1 = explode( "-" , $bufDate2[0] );			// 年月日を分ける
	$bufDate3_2 = explode( ":" , $bufDate2[1] );			// 時分秒を分ける
	$bufTimeUnix = mktime( $bufDate3_2[0] , $bufDate3_2[1] , $bufDate3_2[2] , $bufDate3_1[1] , $bufDate3_1[2] , $bufDate3_1[0] );
	$strSemiUpdate = date( "r" , $bufTimeUnix );

	$rssDiaryItemValue .= "    <item>\n";
	$rssDiaryItemValue .= "      <title>".$obj_rss_diary_blog->diarydat[$rssX]['diary_title']."</title>\n";
	$rssDiaryItemValue .= "      <link>".$param_base_blog_addr_url.$param_base_blog_addr.$obj_rss_diary_blog->diarydat[$rssX]['cl_url_code']."/diary-detail-".$obj_rss_diary_blog->diarydat[$rssX]['diary_id']."/</link>\n";
	$rssDiaryItemValue .= "      <guid>".$param_base_blog_addr_url.$param_base_blog_addr.$obj_rss_diary_blog->diarydat[$rssX]['cl_url_code']."/diary-detail-".$obj_rss_diary_blog->diarydat[$rssX]['diary_id']."/</guid>\n";
	$rssDiaryItemValue .= "      <description></description>\n";
	$rssDiaryItemValue .= "      <pubDate>".$strSemiUpdate."</pubDate>\n";
	$rssDiaryItemValue .= "    </item>\n";

	$sitemapDiaryItemValue .= "    <url>\n";
	$sitemapDiaryItemValue .= "    <loc>".$param_base_blog_addr_url.$param_base_blog_addr.$obj_rss_diary_blog->diarydat[$rssX]['cl_url_code']."/diary-detail-".$obj_rss_diary_blog->diarydat[$rssX]['diary_id']."/</loc>\n";
	$sitemapDiaryItemValue .= "    <priority>1.0</priority>\n";
	$sitemapDiaryItemValue .= "    <changefreq>always</changefreq>\n";
	$sitemapDiaryItemValue .= "    <lastmod>".$strSemiUpdate."</lastmod>\n";
	$sitemapDiaryItemValue .= "    </url>\n";
}

//RSSファイル生成
$diaryRssTmp = fopen(RSS_PORTAL_PATH."rss.tmp","w");
if($diaryRssTmp===flase)exit("ファイルオープン失敗");
flock($diaryRssTmp,LOCK_EX);
$rssDiaryValue = "<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n";
$rssDiaryValue .= "<?xml-stylesheet type=\"text/css\" href=\"rss.css\"?>\n";
$rssDiaryValue .= "<rss version=\"2.0\">\n";
$rssDiaryValue .= "  <channel>\n";
$rssDiaryValue .= "    <title>賃貸マンション、アパートの検索ならReBlo[リブロ]全国の物件がじっくり探せる賃貸物件情報検索サイト！</title>\n";
$rssDiaryValue .= "    <link>".$param_base_blog_addr_url.$param_base_blog_addr."</link>\n";
$rssDiaryValue .= "    <copyright>powered by SLASH</copyright>\n";
$rssDiaryValue .= "    <description></description>\n";
$rssDiaryValue .= $rssDiaryItemValue;
$rssDiaryValue .= "  </channel>\n";
$rssDiaryValue .= "</rss>\n";
$rssDiaryValue = html_delete($rssDiaryValue);

$diarySitemapTmp = fopen(RSS_PORTAL_PATH."sitemap.tmp","w");
if($diarySitemapTmp===flase)exit("ファイルオープン失敗");
flock($diarySitemapTmp,LOCK_EX);
$sitemapDiaryValue = "<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n";
$sitemapDiaryValue .= "<urlset xmlns=\"http://www.google.com/schemas/sitemap/0.84\">\n";
$sitemapDiaryValue .= $sitemapDiaryItemValue;
$sitemapDiaryValue .= "</urlset>\n";

asort( $rss );
$countrss = count($rss);
FOREACH( $rss as $key => $val ){
	$rssDiaryValue = str_replace($val,"",$rssDiaryValue);
}

$rssDiaryValue = mb_convert_encoding($rssDiaryValue,"UTF-8","EUC-JP");
fputs($diaryRssTmp,$rssDiaryValue);
flock($diaryRssTmp,LOCK_UN);
fclose($diaryRssTmp);
$cpBuildRss = copy(RSS_PORTAL_PATH."rss.tmp", RSS_PORTAL_PATH."rss.xml");
//$rnBuildRss = rename(RSS_PORTAL_PATH."rss.tmp", RSS_PORTAL_PATH."rss.xml");
if($cpBuildRss===flase)exit("ファイルコピー失敗");

$exBuildRss = file_exists(RSS_PORTAL_PATH."rss.xml");
if($exBuildRss !== FALSE){
	$dlBuildRss = unlink(RSS_PORTAL_PATH."rss.tmp");
	if($dlBuildRss===flase)exit("ファイル削除失敗");
}

$sitemapDiaryValue = mb_convert_encoding($sitemapDiaryValue,"UTF-8","EUC-JP");
fputs($diarySitemapTmp,$sitemapDiaryValue);
flock($diarySitemapTmp,LOCK_UN);
fclose($diarySitemapTmp);
$cpBuildSitemap = copy(RSS_PORTAL_PATH."sitemap.tmp", RSS_PORTAL_PATH."sitemap.xml");
//$rnBuildRss = rename(RSS_PORTAL_PATH."sitemap.tmp", RSS_PORTAL_PATH."sitemap.xml");
if($cpBuildSitemap===flase)exit("ファイルコピー失敗");

$exBuildSitemap = file_exists(RSS_PORTAL_PATH."sitemap.xml");
if($exBuildSitemap !== FALSE){
	$dlBuildSitemap = unlink(RSS_PORTAL_PATH."sitemap.tmp");
	if($dlBuildSitemap===flase)exit("ファイル削除失敗");
}

/*----------------------------------------------------------
  ＤＢ切断
----------------------------------------------------------*/
require_once( SYS_PATH."common/db_close.php" );


/*----------------------------------------------------------
  更新Ping送信
----------------------------------------------------------*/
// 「更新Pingを送信する」に設定されている場合に処理

if ( $param_ping_send_flg == 1 ) {
	// 処理が「新規登録」または「修正登録」の場合に送信
	if ( $_POST["mode"] == "NEW" || $_POST["mode"] == "EDIT" ) {
		
		// サイト情報を配列に格納
		$arrSiteData = Array();
		$arrSiteData["title"] = $obj_cl_blog->clientdat[0]['blog_title'];
		$arrSiteData["url"] = _BLOG_SITE_URL_BASE;
		if ( $_POST["mode"] == "NEW" ) {
			$arrSiteData["up_url"] = _BLOG_SITE_URL_BASE."room-".$obj_new->roomdat[0]["room_id"]."/";
		} else if ( $_POST["mode"] == "EDIT" ) {
			$arrSiteData["up_url"] = _BLOG_SITE_URL_BASE."room-".$obj_rev->roomdat[0]["room_id"]."/";
		}
		$arrSiteData["rss"] = RSS_BLOG_PATH."rss_build_".$_SESSION['_cl_id'].".xml";
		
		// 更新Ping送信実行
		list( $ret , $arrMess ) = SendUpdatePing( $param_ping_send , $arrSiteData , NULL );
		$test = "<input type=\"hidden\" name=\"test\" value=\"{$ret}<>{$arrMess}\">";
	}
}
?>
