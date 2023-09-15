<?
/******************************************************************************
<< 不動産ブログ　Ver.1.O.0 >>
    Name: client_upd.php
    Version: 1.0.0
    Function: クライアント登録／修正／削除登録
    Author: Click inc
    Date of creation: 2007/02
    History of modification:

    Copyright (C)2007 Click, inc. All Rights Reserverd.
******************************************************************************/

/*---------------------------------------------------------
    フリーワード用情報生成
    &が着いているのは参照渡し
---------------------------------------------------------*/
function fn_create_freeword( $p_conn , $p_cl_id , &$p_cl_yobi1) {
    $p_cl_yobi1 = '';

    // 教室情報を取得
    //  ブログ基本情報登録
    $obj_blog = new basedb_SchoolClassTblAccess;
    $obj_blog->conn = $p_conn;
    $obj_blog->jyoken["sc_clid"] = $p_cl_id;		// クライアントID
    list( $intCnt , $intTotal ) = $obj_blog->basedb_GetSchool( 0 , -1 );
    if( $intCnt == -1 ){
        $arrOther["ath_comment"] = "";
        $arrOther["ath_comment"] .= "<INPUT TYPE=\"hidden\" NAME=\"stpos\" VALUE=\"{$_POST['stpos']}\">";
        $arrOther["ath_comment"] .= $athComment;
        $obj_error->ViewErrMessage( "SYSTEM" , "ALL" , "client_mnt.php" , $arrOther );
        exit;
    }

    // エリア情報を取得
    $obj_area = new basedb_AreaClassTblAccess;
    $obj_area->conn = $p_conn;
    $obj_area->jyoken["ar_clid"]	= $p_cl_id;	// クライアントID
    $obj_area->sort['ar_flg']	= 2;			// 対象エリア順
    list( $intCnt , $intTotal ) = $obj_area->basedb_GetArea( 0 , -1 );
    if( $intCnt == -1 ){
        $arrOther["ath_comment"] = "";
        $arrOther["ath_comment"] .= "<INPUT TYPE=\"hidden\" NAME=\"stpos\" VALUE=\"{$_POST['stpos']}\">";
        $arrOther["ath_comment"] .= $athComment;
        $obj_error->ViewErrMessage( "SYSTEM" , "ALL" , "client_mnt.php" , $arrOther );
        exit;
    }

    // 沿線情報を取得
    $obj_ensen = new basedb_EnsenClassTblAccess;
    $obj_ensen->conn = $p_conn;
    //$obj_ensen->jyoken["es_cd"]	= $obj_blog->blogdat[0]['sc_id'];	// 教室ID
    $obj_ensen->jyoken["es_cd"]	= $p_cl_id;	// クライアントID
    $obj_ensen->jyoken["es_dispno"]	= 1;					// 表示順=1
    list( $intCnt , $intTotal ) = $obj_ensen->basedb_GetEnsen( 0 , -1 );

    // 塾名
    $str = $_POST["cl_jname"];
    if($str!="")$p_cl_yobi1 .= $str . '/';

    // 教室名
    $str = $_POST["cl_kname"];
    if($str!="")$p_cl_yobi1 .= $str . '/';

    // 塾名+教室名
    $str = $_POST["cl_jname"] . $_POST["cl_kname"];
    if($str!="")$p_cl_yobi1 .= $str . '/';

    // エリア情報 $obj_area->areadatに教室住所、エリア1〜3の4レコード返ってくる
    FOREACH($obj_area->areadat as $key => $val ){

        // 郵便番号 空レコードにハイフンが入ってるので回避
        $str = $val["ar_zip"];
        if($str!="" and $str!="-")$p_cl_yobi1 .= $str . '/';
        // 都道府県名
        $str = $val["ar_pref"];
        if($str!="")$p_cl_yobi1 .= $str . '/';
        // 市区町村名
        $str = $val["ar_city"];
        if($str!="")$p_cl_yobi1 .= $str . '/';

        // $key=0(最初のレコード)=塾の住所 の場合のみ 番地 建物名
        if ($key == 0) {
            // 番地
            $str = $val["ar_add"];
            if($str!="")$p_cl_yobi1 .= $str . '/';
            // 建物名
            $str = $val["ar_estate"];
            if($str!="")$p_cl_yobi1 .= $str . '/';

            // 都道府県名+市区町村名+番地+建物名
            $buff_add_str = '';
            $buff_add_str = $val["ar_pref"] . $val["ar_city"] . $val["ar_add"] . $val["ar_estate"];
        } else {
            // 都道府県名+市区町村名
            $buff_add_str = '';
            $buff_add_str = $val["ar_pref"] . $val["ar_city"];
        }
        if($buff_add_str!="") $p_cl_yobi1 .= $buff_add_str . '/';
    }

    // ブログ紹介文
    $str = $obj_blog->blogdat[0]["sc_introduce"];
    if($str!="")$p_cl_yobi1 .= $str . '/';

    // 運営会社
    $str = $obj_blog->blogdat[0]["sc_company"];
    if($str!="")$p_cl_yobi1 .= $str . '/';

    // TOPウインドウタイトル
    $str = $obj_blog->blogdat[0]["sc_topwindowtitle"];
    if($str!="")$p_cl_yobi1 .= $str . '/';

    // ヘッダー用タイトル
    $str = $obj_blog->blogdat[0]["sc_headertitle"];
    if($str!="")$p_cl_yobi1 .= $str . '/';

    // TOP教室情報タイトル
    $str = $obj_blog->blogdat[0]["sc_toptitle"];
    if($str!="")$p_cl_yobi1 .= $str . '/';

    // TOP教室情報サブタイトル
    $str = $obj_blog->blogdat[0]["sc_topsubtitle"];
    if($str!="")$p_cl_yobi1 .= $str . '/';

    // TOPキャンペーンイベント
    $str = $obj_blog->blogdat[0]["sc_campaintitle"];
    if($str!="")$p_cl_yobi1 .= $str . '/';

    // TOPコース情報タイトル
    $str = $obj_blog->blogdat[0]["sc_coursetitle"];
    if($str!="")$p_cl_yobi1 .= $str . '/';

    // TOP日記情報タイトル
    $str = $obj_blog->blogdat[0]["sc_diarytitle"];
    if($str!="")$p_cl_yobi1 .= $str . '/';

    // 入塾説明文
    $str = $obj_blog->blogdat[0]["sc_addmission"];
    if($str!="")$p_cl_yobi1 .= $str . '/';

    // 対象学年
    $sc_age = htmlspecialchars ($obj_blog->blogdat[0]["sc_age"]);
    if(($sc_age & 64) == 64 ){
        $p_cl_yobi1 .= "社会人" . '/';
        $sc_age -= 64;
    }
    if(($sc_age & 32) == 32 ){
        $p_cl_yobi1 .= "大学生" . '/';
        $sc_age -= 32;
    }
    if(($sc_age & 16) == 16 ){
        $p_cl_yobi1 .= "浪人生" . '/';
        $sc_age -= 16;
    }
    if(($sc_age & 8) == 8 ){
        $p_cl_yobi1 .= "高校生" . '/';
        $sc_age -= 8;
    }
    if(($sc_age & 4) == 4 ){
        $p_cl_yobi1 .= "中学生" . '/';
        $sc_age -= 4;
    }
    if(($sc_age & 2) == 2 ){
        $p_cl_yobi1 .= "小学生" . '/';
        $sc_age -= 2;
    }
    if(($sc_age & 1) == 1 ){
        $p_cl_yobi1 .= "幼児" . '/';
        $sc_age -= 1;
    }

    // 授業形態
    $sc_classform = htmlspecialchars ($obj_blog->blogdat[0]["sc_classform"]);
    if(($sc_classform & 4) == 4 ){
        $p_cl_yobi1 .= "個別" . '/';
        $sc_classform -= 4;
    }
    if(($sc_classform & 2) == 2 ){
        $p_cl_yobi1 .= "少人数" . '/';
        $sc_classform -= 2;
    }
    if(($sc_classform & 1) == 1 ){
        $p_cl_yobi1 .= "集団" . '/';
        $sc_age -= 1;
    }

    // 最寄沿線名
    $str = $obj_ensen->ensendat[0]["es_line"];
    if($str!="")$p_cl_yobi1 .= $str . '/';

    // 最寄駅名
    $str = $obj_ensen->ensendat[0]["es_sta"];
    if($str!="")$p_cl_yobi1 .= $str . '駅' . '/';

    // 徒歩
    $str = $obj_ensen->ensendat[0]["es_walk"];
    if($str!="")$p_cl_yobi1 .= '徒歩' . $str . '分' . '/';

    // バス
    $str = $obj_ensen->ensendat[0]["es_bus"];
    if($str!="")$p_cl_yobi1 .= 'バス' . $str . '分' . '/';

    // 教室PR文
    $str = $obj_blog->blogdat[0]["sc_pr"];
    if($str!="")$p_cl_yobi1 .= $str . '/';

    // 最後に頭にスラッシュをつける (空じゃなければ)
    if ($p_cl_yobi1 != "") $p_cl_yobi1 = '/' . $p_cl_yobi1;

}
// フリーワード用情報生成--END


/*----------------------------------------------------------
  必要ファイル呼び出し
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


/*----------------------------------------------------------
  ログイン情報チェック
----------------------------------------------------------*/
require_once("../login_chk.php");



//echo("#".$_POST["cl_upddate"]."#");
/*----------------------------------------------------------
  エラー用HIDDEN値生成
----------------------------------------------------------*/
$strErrHidden = "";
$strErrHidden .= "<INPUT type=\"hidden\" name=\"err_mode\" value=\"ERR\">\n";
FOREACH( $_POST as $key => $val ){

    $arrPostView[$key] = htmlspecialchars( stripslashes( $val ) );

    $buffData_err = "";
    $buffData_err = htmlspecialchars( stripslashes( $val ) );
    $strErrHidden .= "<INPUT type=\"hidden\" name=\"{$key}\" value=\"{$buffData_err}\">\n";
}


/*---------------------------------------------------------
    処理部分
---------------------------------------------------------*/
$zip = $_POST['ar_zip1']."-".$_POST['ar_zip2'];
$zip1 = $_POST['ar_zip1_1']."-".$_POST['ar_zip1_2'];
$zip2 = $_POST['ar_zip2_1']."-".$_POST['ar_zip2_2'];
$zip3 = $_POST['ar_zip3_1']."-".$_POST['ar_zip3_2'];

switch( $_POST["mode"] ){
case 'NEW':
    $obj_new = new basedb_ClientClassTblAccess;
    $obj_new->conn = $obj_conn->conn;
    $obj_new->clientdat[0]["cl_stat"] = pg_escape_string($_POST["cl_stat"]);
    $obj_new->clientdat[0]["cl_dokuji_flg"] = pg_escape_string($_POST["cl_dokuji_flg"]);
    $obj_new->clientdat[0]["cl_googlemap_key"] = pg_escape_string($_POST["cl_googlemap_key"]);
    $obj_new->clientdat[0]["cl_dokuji_domain"] = pg_escape_string($_POST["cl_dokuji_domain"]);
    $obj_new->clientdat[0]["cl_advertisement_flg"] = pg_escape_string($_POST["cl_advertisement_flg"]);
    $obj_new->clientdat[0]["cl_advertisement_tag"] = pg_escape_string($_POST["cl_advertisement_tag"]);
    $obj_new->clientdat[0]["cl_mobile_flg"] = pg_escape_string($_POST["cl_mobile_flg"]);
    $obj_new->clientdat[0]["cl_mobile_dokuji_flg"] = pg_escape_string($_POST["cl_mobile_dokuji_flg"]);
    $obj_new->clientdat[0]["cl_mobile_googlemap_key"] = pg_escape_string($_POST["cl_mobile_googlemap_key"]);
    $obj_new->clientdat[0]["cl_mobile_dokuji_domain"] = pg_escape_string($_POST["cl_mobile_dokuji_domain"]);
    $obj_new->clientdat[0]["cl_smartphone_flg"] = pg_escape_string($_POST["cl_smartphone_flg"]);

    $obj_new->clientdat[0]["cl_jname"] = pg_escape_string($_POST["cl_jname"]);
    $obj_new->clientdat[0]["cl_kname"] = pg_escape_string($_POST["cl_kname"]);
    $obj_new->clientdat[0]["cl_agent"] = pg_escape_string($_POST["cl_agent"]);
    $obj_new->clientdat[0]["cl_phone"] = pg_escape_string($_POST["cl_phone"]);
    $obj_new->clientdat[0]["cl_fax"] = pg_escape_string($_POST["cl_fax"]);
    $obj_new->clientdat[0]["cl_mail"] = pg_escape_string($_POST["cl_mail"]);
    $obj_new->clientdat[0]["cl_loginid"] = pg_escape_string($_POST["cl_loginid"]);
    $obj_new->clientdat[0]["cl_passwd"] = pg_escape_string($_POST["cl_passwd"]);
    $obj_new->clientdat[0]["cl_logincd"] = pg_escape_string(sha1($_POST["cl_loginid"]));
    $obj_new->clientdat[0]["cl_passcd"] = pg_escape_string(sha1($_POST["cl_passwd"]));
    $obj_new->clientdat[0]["cl_urlcd"] = pg_escape_string($_POST["cl_urlcd"]);
    IF( $_POST["cl_end_y"] != "" && $_POST["cl_end_m"] != "" && $_POST["cl_end_d"] != "" ) {
        $obj_new->clientdat[0]["cl_limit_date"] = pg_escape_string($_POST["cl_end_y"])."-".pg_escape_string($_POST["cl_end_m"])."-".pg_escape_string($_POST["cl_end_d"]);
    }
    IF( $_POST["cl_start_y"] != "" && $_POST["cl_start_m"] != "" && $_POST["cl_start_d"] != "" ) {
        $obj_new->clientdat[0]["cl_start_date"] = pg_escape_string($_POST["cl_start_y"])."-".pg_escape_string($_POST["cl_start_m"])."-".pg_escape_string($_POST["cl_start_d"]);
    }
    $obj_new->clientdat[0]["cl_biko"] = pg_escape_string($_POST['cl_biko']);
    $obj_new->clientdat[0]["cl_pstat"] = pg_escape_string($_POST["cl_pstat"]);
    $obj_new->clientdat[0]["cl_makeid"] = pg_escape_string($_SESSION['ad_id']);
    $suc = $obj_new->basedb_InsClient();
    switch( $suc ){
    case "-1":
        $arrErr["ath_comment"] = $strErrHidden;
        $obj_error->ViewErrMessage( "INS_ERROR" , "ALL" , "client_mnt.php" , $arrErr );
        exit;
    case "4":
        $arrErr["ath_comment"] = $strErrHidden;
        $obj_error->ViewErrMessage( "LOGIN_ID" , "ALL" , "client_mnt.php" , $arrErr );
        exit;
    case "3":
        $arrErr["ath_comment"] = $strErrHidden;
        $obj_error->ViewErrMessage( "URL_CODE" , "ALL" , "client_mnt.php" , $arrErr );
        exit;
    }

    //  ブログ基本情報登録
    $obj_blog = new basedb_SchoolClassTblAccess;
    $obj_blog->conn = $obj_conn->conn;
    $obj_blog->blogdat[0]["sc_clid"] = $obj_new->clientdat[0]["cl_id"];
    $obj_blog->blogdat[0]["sc_stat"] = "9";
    $obj_blog->blogdat[0]["sc_adminid"] = $_SESSION["ad_id"];
    $ret_blog = $obj_blog->basedb_InsSchool();
    IF( $ret_blog != 0 ) {
        //echo("ret_blog...".$ret_blog);
        $arrErr["ath_comment"] = $strErrHidden;
        $obj_error->ViewErrMessage( "CLIENT_NO_BLOG" , "ALL" , "client_main.php" , $arrErr );
        exit;
    }

    //  基本メニュー情報登録
    $obj_menu1 = new basedb_MenuClassTblAccess;
    $obj_menu1->conn = $obj_conn->conn;
    $obj_menu1->menudat[0]["mn_clid"] = $obj_new->clientdat[0]["cl_id"];
    $obj_menu1->menudat[0]["mn_lstat"] = 1;
    $obj_menu1->menudat[0]["mn_lname"] = "教室のご案内";
    $obj_menu1->menudat[0]["mn_ldispno"] = 1;
    $obj_menu1->menudat[0]["mn_hstat"] = 1;
    $obj_menu1->menudat[0]["mn_flg"] = 1;
    $obj_menu1->menudat[0]["mn_hname"] = "教室のご案内";
    $obj_menu1->menudat[0]["mn_hdispno"] = 1;
    $obj_menu1->menudat[0]["mn_adminid"] = $_SESSION["ad_id"];
    $ret_menu1 = $obj_menu1->basedb_InsMenu();
    IF( $ret_menu1 != 0 ) {
        //echo("ret_menu1...".$ret_menu1);
        $arrErr["ath_comment"] = $strErrHidden;
        $obj_error->ViewErrMessage( "CLIENT_NO_BLOG" , "ALL" , "client_main.php" , $arrErr );
        exit;
    }

    //  基本メニュー情報登録
    $obj_menu2 = new basedb_MenuClassTblAccess;
    $obj_menu2->conn = $obj_conn->conn;
    $obj_menu2->menudat[0]["mn_clid"] = $obj_new->clientdat[0]["cl_id"];
    $obj_menu2->menudat[0]["mn_lstat"] = 1;
    $obj_menu2->menudat[0]["mn_lname"] = "よくある質問";
    $obj_menu2->menudat[0]["mn_ldispno"] = 2;
    $obj_menu2->menudat[0]["mn_flg"] = 2;
    $obj_menu2->menudat[0]["mn_hstat"] = 1;
    $obj_menu2->menudat[0]["mn_hname"] = "よくある質問";
    $obj_menu2->menudat[0]["mn_hdispno"] = 2;
    $obj_menu2->menudat[0]["mn_adminid"] = $_SESSION["ad_id"];
    $ret_menu2 = $obj_menu2->basedb_InsMenu();
    IF( $ret_menu2 != 0 ) {
        //echo("ret_menu2...".$ret_menu2);
        $arrErr["ath_comment"] = $strErrHidden;
        $obj_error->ViewErrMessage( "CLIENT_NO_BLOG" , "ALL" , "client_main.php" , $arrErr );
        exit;
    }

    //  基本メニュー情報登録
    $obj_menu3 = new basedb_MenuClassTblAccess;
    $obj_menu3->conn = $obj_conn->conn;
    $obj_menu3->menudat[0]["mn_clid"] = $obj_new->clientdat[0]["cl_id"];
    $obj_menu3->menudat[0]["mn_lstat"] = 1;
    $obj_menu3->menudat[0]["mn_lname"] = "入塾までの流れ";
    $obj_menu3->menudat[0]["mn_ldispno"] = 3;
    $obj_menu3->menudat[0]["mn_flg"] = 3;
    $obj_menu3->menudat[0]["mn_hname"] = "入塾までの流れ";
    $obj_menu3->menudat[0]["mn_hstat"] = 1;
    $obj_menu3->menudat[0]["mn_hdispno"] = 3;
    $obj_menu3->menudat[0]["mn_adminid"] = $_SESSION["ad_id"];
    $ret_menu3 = $obj_menu3->basedb_InsMenu();
    IF( $ret_menu3 != 0 ) {
        //echo("ret_menu3...".$ret_menu3);
        $arrErr["ath_comment"] = $strErrHidden;
        $obj_error->ViewErrMessage( "CLIENT_NO_BLOG" , "ALL" , "client_main.php" , $arrErr );
        exit;
    }

    //  基本メニュー情報登録
    $obj_menu4 = new basedb_MenuClassTblAccess;
    $obj_menu4->conn = $obj_conn->conn;
    $obj_menu4->menudat[0]["mn_clid"] = $obj_new->clientdat[0]["cl_id"];
    $obj_menu4->menudat[0]["mn_lstat"] = 1;
    $obj_menu4->menudat[0]["mn_lname"] = "お問い合わせ";
    $obj_menu4->menudat[0]["mn_ldispno"] = 4;
    $obj_menu4->menudat[0]["mn_flg"] = 4;
    $obj_menu4->menudat[0]["mn_hname"] = "お問い合わせ";
    $obj_menu4->menudat[0]["mn_hstat"] = 1;
    $obj_menu4->menudat[0]["mn_hdispno"] = 4;
    $obj_menu4->menudat[0]["mn_adminid"] = $_SESSION["ad_id"];
    $ret_menu4 = $obj_menu4->basedb_InsMenu();
    IF( $ret_menu4 != 0 ) {
        //echo("ret_menu4...".$ret_menu4);
        $arrErr["ath_comment"] = $strErrHidden;
        $obj_error->ViewErrMessage( "CLIENT_NO_BLOG" , "ALL" , "client_main.php" , $arrErr );
        exit;
    }
    //  エリア情報登録
    $obj_area = new basedb_AreaClassTblAccess;
    $obj_area->conn = $obj_conn->conn;
    $obj_area->areadat[0]["ar_clid"] = $obj_new->clientdat[0]["cl_id"];
    $obj_area->areadat[0]["ar_flg"] = 1;
    $obj_area->areadat[0]["ar_zip"] = $zip;
    $obj_area->areadat[0]["ar_pref"] = $_POST["ar_pref"];
    $obj_area->areadat[0]["ar_prefcd"] = $_POST["ar_prefcd"];
    $obj_area->areadat[0]["ar_city"] = $_POST["ar_city"];
    $obj_area->areadat[0]["ar_citycd"] = $_POST["ar_citycd"];
    $obj_area->areadat[0]["ar_add"] = $_POST["ar_add"];
    $obj_area->areadat[0]["ar_estate"] = $_POST["ar_estate"];
    $ret_area = $obj_area->basedb_InsArea();
    IF( $ret_area != 0 ) {
        //echo("ret_area...".$ret_area);
        $arrErr["ath_comment"] = $strErrHidden;
        $obj_error->ViewErrMessage( "CLIENT_NO_BLOG" , "ALL" , "client_main.php" , $arrErr );
        exit;
    }

    //  エリア情報登録
    $obj_area1 = new basedb_AreaClassTblAccess;
    $obj_area1->conn = $obj_conn->conn;
    $obj_area1->areadat[0]["ar_clid"] = $obj_new->clientdat[0]["cl_id"];
    $obj_area1->areadat[0]["ar_flg"] = 2;
    $obj_area1->areadat[0]["ar_zip"] = $zip1;
    $obj_area1->areadat[0]["ar_pref"] = $_POST["ar_pref1"];
    $obj_area1->areadat[0]["ar_prefcd"] = $_POST["ar_prefcd1"];
    $obj_area1->areadat[0]["ar_city"] = $_POST["ar_city1"];
    $obj_area1->areadat[0]["ar_citycd"] = $_POST["ar_citycd1"];
    $obj_area1->areadat[0]["ar_add"] = $_POST["ar_add1"];
    $obj_area1->areadat[0]["ar_estate"] = $_POST["ar_estate1"];
    $ret_area1 = $obj_area1->basedb_InsArea();
    IF( $ret_area1 != 0 ) {
        //echo("ret_area1...".$ret_area1);
        $arrErr["ath_comment"] = $strErrHidden;
        $obj_error->ViewErrMessage( "CLIENT_NO_BLOG" , "ALL" , "client_main.php" , $arrErr );
        exit;
    }

    //  エリア情報登録
    $obj_area2 = new basedb_AreaClassTblAccess;
    $obj_area2->conn = $obj_conn->conn;
    $obj_area2->areadat[0]["ar_clid"] = $obj_new->clientdat[0]["cl_id"];
    $obj_area2->areadat[0]["ar_flg"] = 3;
    $obj_area2->areadat[0]["ar_zip"] = $zip2;
    $obj_area2->areadat[0]["ar_pref"] = $_POST["ar_pref2"];
    $obj_area2->areadat[0]["ar_prefcd"] = $_POST["ar_prefcd2"];
    $obj_area2->areadat[0]["ar_city"] = $_POST["ar_city2"];
    $obj_area2->areadat[0]["ar_citycd"] = $_POST["ar_citycd2"];
    $obj_area2->areadat[0]["ar_add"] = $_POST["ar_add2"];
    $obj_area2->areadat[0]["ar_estate"] = $_POST["ar_estate2"];
    $ret_area2 = $obj_area2->basedb_InsArea();
    IF( $ret_area2 != 0 ) {
        //echo("ret_area2...".$ret_area2);
        $arrErr["ath_comment"] = $strErrHidden;
        $obj_error->ViewErrMessage( "CLIENT_NO_BLOG" , "ALL" , "client_main.php" , $arrErr );
        exit;
    }

    //  エリア情報登録
    $obj_area3 = new basedb_AreaClassTblAccess;
    $obj_area3->conn = $obj_conn->conn;
    $obj_area3->areadat[0]["ar_clid"] = $obj_new->clientdat[0]["cl_id"];
    $obj_area3->areadat[0]["ar_flg"] = 4;
    $obj_area3->areadat[0]["ar_zip"] = $zip3;
    $obj_area3->areadat[0]["ar_pref"] = $_POST["ar_pref3"];
    $obj_area3->areadat[0]["ar_prefcd"] = $_POST["ar_prefcd3"];
    $obj_area3->areadat[0]["ar_city"] = $_POST["ar_city3"];
    $obj_area3->areadat[0]["ar_citycd"] = $_POST["ar_citycd3"];
    $obj_area3->areadat[0]["ar_add"] = $_POST["ar_add3"];
    $obj_area3->areadat[0]["ar_estate"] = $_POST["ar_estate3"];
    $ret_area3 = $obj_area3->basedb_InsArea();
    IF( $ret_area3 != 0 ) {
        //echo("ret_area3...".$ret_area3);
        $arrErr["ath_comment"] = $strErrHidden;
        $obj_error->ViewErrMessage( "CLIENT_NO_BLOG" , "ALL" , "client_main.php" , $arrErr );
        exit;
    }

    //  左メニュー見出し
    $obj_leftmenu2 = new basedb_LeftmenuClassTblAccess;
    $obj_leftmenu2->conn = $obj_conn->conn;
    $obj_leftmenu2->leftmenudat[0]["lm_clid"] = $obj_new->clientdat[0]["cl_id"];
    $obj_leftmenu2->leftmenudat[0]["lm_stat"] = 1;
    $obj_leftmenu2->leftmenudat[0]["lm_type"] = 2;
    $obj_leftmenu2->leftmenudat[0]["lm_title"] = "キャンペーン情報";
    $obj_leftmenu2->leftmenudat[0]["lm_dispno"] = 1;
    $obj_leftmenu2 = $obj_leftmenu2->basedb_InsLeftmenu();
    IF( $ret_leftmenu2 != 0 ) {
        //echo("ret_leftmenu2...".$ret_leftmenu2);
        $arrErr["ath_comment"] = $strErrHidden;
        $obj_error->ViewErrMessage( "CLIENT_NO_BLOG" , "ALL" , "client_main.php" , $arrErr );
        exit;
    }

    //  左メニュー見出し
    $obj_leftmenu3 = new basedb_LeftmenuClassTblAccess;
    $obj_leftmenu3->conn = $obj_conn->conn;
    $obj_leftmenu3->leftmenudat[0]["lm_clid"] = $obj_new->clientdat[0]["cl_id"];
    $obj_leftmenu3->leftmenudat[0]["lm_stat"] = 1;
    $obj_leftmenu3->leftmenudat[0]["lm_type"] = 3;
    $obj_leftmenu3->leftmenudat[0]["lm_title"] = "ブログ情報";
    $obj_leftmenu3->leftmenudat[0]["lm_dispno"] = 1;
    $obj_leftmenu3 = $obj_leftmenu3->basedb_InsLeftmenu();
    IF( $ret_leftmenu3 != 0 ) {
        //echo("ret_leftmenu3...".$ret_leftmenu3);
        $arrErr["ath_comment"] = $strErrHidden;
        $obj_error->ViewErrMessage( "CLIENT_NO_BLOG" , "ALL" , "client_main.php" , $arrErr );
        exit;
    }

    //  左メニュー見出し
    $obj_leftmenu4 = new basedb_LeftmenuClassTblAccess;
    $obj_leftmenu4->conn = $obj_conn->conn;
    $obj_leftmenu4->leftmenudat[0]["lm_clid"] = $obj_new->clientdat[0]["cl_id"];
    $obj_leftmenu4->leftmenudat[0]["lm_stat"] = 1;
    $obj_leftmenu4->leftmenudat[0]["lm_type"] = 4;
    $obj_leftmenu4->leftmenudat[0]["lm_title"] = "基本メニュー";
    $obj_leftmenu4->leftmenudat[0]["lm_dispno"] = 1;
    $obj_leftmenu4 = $obj_leftmenu4->basedb_InsLeftmenu();
    IF( $ret_leftmenu4 != 0 ) {
        //echo("ret_leftmenu4...".$ret_leftmenu4);
        $arrErr["ath_comment"] = $strErrHidden;
        $obj_error->ViewErrMessage( "CLIENT_NO_BLOG" , "ALL" , "client_main.php" , $arrErr );
        exit;
    }

    // クライアント情報のフリーワード検索用フィールドを更新
    // フリーワード検索用文字列を生成
    fn_create_freeword($obj_conn->conn , $obj_new->clientdat[0]["cl_id"] , $cl_yobi1);
    $obj_rev = new basedb_ClientClassTblAccess;
    $obj_rev->conn = $obj_conn->conn;
    $obj_rev->clientdat[0]["cl_id"] = $obj_new->clientdat[0]["cl_id"];
    $obj_rev->clientdat[0]["cl_upddate"] = $obj_new->clientdat[0]["cl_upddate"];
    $obj_rev->clientdat[0]["cl_yobi1"] = $cl_yobi1;
    $obj_rev->clientdat[0]["ins_yobi1"] = 1;	// 新規登録後のUPDATE時は1 余計なUPDATEをしない
    $suc = $obj_rev->basedb_UpdClient();
    switch( $suc ){
    case "-1":
        $arrErr["ath_comment"] = $strErrHidden;
        $obj_error->ViewErrMessage( "UPD_ERROR" , "ALL" , "client_mnt.php" , $arrErr );
        exit;
    case "1":
        $arrErr["ath_comment"] = $strErrHidden;
        $obj_error->ViewErrMessage( "DOUBLE_UPD" , "ALL" , "client_mnt.php" , $arrErr );
        exit;
    case "4":
        $arrErr["ath_comment"] = $strErrHidden;
        $obj_error->ViewErrMessage( "LOGIN_ID" , "ALL" , "client_mnt.php" , $arrErr );
        exit;
    case "3":
        $arrErr["ath_comment"] = $strErrHidden;
        $obj_error->ViewErrMessage( "URL_CODE" , "ALL" , "client_mnt.php" , $arrErr );
        exit;
    }

    // カテゴリー情報(建物／日記)登録
    $obj_cate = NULL;
    FOR( $iY=1; $iY<3; $iY++ ){

        $cate_kind = $iY;
        IF( $iY == 1 ){
            $cate_name = "おすすめ物件";
            $cate_top_flg = 1;
            $cate_top_name = "おすすめ物件情報";
        }ELSE{
            $cate_name = "お知らせ";
            $cate_top_flg = 9;
            $cate_top_name = "";
        }

/*
            $obj_cate = new basedb_CategoryClassTblAccess;
            $obj_cate->conn = $obj_conn->conn;
            $obj_cate->categorydat[0]["cate_cl_id"] = $obj_new->clientdat[0]["cl_id"];
            $obj_cate->categorydat[0]["cate_kind"] = $cate_kind;
            $obj_cate->categorydat[0]["cate_flg"] = 1;
            $obj_cate->categorydat[0]["cate_name"] = $cate_name;
            $obj_cate->categorydat[0]["cate_disp_no"] = 1;
            $obj_cate->categorydat[0]["cate_top_flg"] = $cate_top_flg;
            $obj_cate->categorydat[0]["cate_top_name"] = $cate_top_name;
            $obj_cate->categorydat[0]["cate_admin_id"] = $_SESSION["_kanri_id"];
            $ret_cate = $obj_cate->basedb_InsCategory();
            IF( $ret_cate != 0 ){
                $arrErr["ath_comment"] = $strErrHidden;
                $obj_error->ViewErrMessage( "CLIENT_NO_BLOG" , "ALL" , "client_main.php" , $arrErr );
                exit;
            }
 */
    }

    $message = "クライアントを登録しました。";


    // 独自ドメイン用ディレクトリ生成
    @mkdir( $param_dokuji_path.$_POST["cl_urlcd"] , 0755);

    // 独自ドメイン用.htaccessファイル生成
    $buildRssTmp = fopen($param_dokuji_path.$_POST["cl_urlcd"]."/.htaccess","w");
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
    $rssBuildValue .= "#RewriteRule   ^kiyaku/([a-z]{1}.*)$                                                   program/{$_POST["cl_urlcd"]}?%{QUERY_STRING} [L]\n";
    $rssBuildValue .= "#RewriteRule   ^sitemap/$                                                              program/portal_tpl_control.php?tpl_flg=sitemap%{QUERY_STRING} [L]\n";
    $rssBuildValue .= "#RewriteRule   ^sitemap/([a-z]{1}.*)$                                                  program/{$_POST["cl_urlcd"]}?%{QUERY_STRING} [L]\n";
    $rssBuildValue .= "#RewriteRule   ^privacy/$                                                              program/portal_tpl_control.php?tpl_flg=privacy%{QUERY_STRING} [L]\n";
    $rssBuildValue .= "#RewriteRule   ^privacy/([a-z]{1}.*)$                                                  program/{$_POST["cl_urlcd"]}?%{QUERY_STRING} [L]\n";
    $rssBuildValue .= "#RewriteRule   ^com-pro/$                                                              program/portal_tpl_control.php?tpl_flg=com-pro%{QUERY_STRING} [L]\n";
    $rssBuildValue .= "#RewriteRule   ^com-pro/([a-z]{1}.*)$                                                  program/{$_POST["cl_urlcd"]}?%{QUERY_STRING} [L]\n";
    $rssBuildValue .= "#RewriteRule   ^forcom/$                                                               program/portal_tpl_control.php?tpl_flg=forcom%{QUERY_STRING} [L]\n";
    $rssBuildValue .= "#RewriteRule   ^forcom/([a-z]{1}.*)$                                                   program/{$_POST["cl_urlcd"]}?%{QUERY_STRING} [L]\n";
    $rssBuildValue .= "\n";
    $rssBuildValue .= "# diary\n";
    $rssBuildValue .= "#RewriteRule   ^diary/$                                                                program/portal_diary.php?%{QUERY_STRING} [L]\n";
    $rssBuildValue .= "#RewriteRule   ^diary/([a-z]{1}.*)$                                                    program/{$_POST["cl_urlcd"]}?%{QUERY_STRING} [L]\n";
    $rssBuildValue .= "\n";
    $rssBuildValue .= "# inquiry\n";
    $rssBuildValue .= "#RewriteRule   ^inquiry/([a-z]{1}.*)$                                                  program/{$_POST["cl_urlcd"]}?%{QUERY_STRING} [L]\n";
    $rssBuildValue .= "#RewriteRule   ^inquiry/$                                                              program/portal_inquiry.php?%{QUERY_STRING} [L]\n";
    $rssBuildValue .= "\n";
    $rssBuildValue .= "# search result\n";
    $rssBuildValue .= "#RewriteRule   ^psearch-result/page-([0-9]+)\.html$                                    program/portal_build_list.php?p={$_POST["cl_urlcd"]}&%{QUERY_STRING} [L]\n";
    $rssBuildValue .= "#RewriteRule   ^psearch-result/([a-z]{1}.*)$                                           program/{$_POST["cl_urlcd"]}?%{QUERY_STRING} [L]\n";
    $rssBuildValue .= "\n";
    $rssBuildValue .= "# search map pages\n";
    $rssBuildValue .= "#RewriteRule   ^psearch-map/$                                                          program/portal_search_map.php?%{QUERY_STRING} [L]\n";
    $rssBuildValue .= "#RewriteRule   ^psearch-map/([a-z]{1}.*)$                                              program/{$_POST["cl_urlcd"]}?%{QUERY_STRING} [L]\n";
    $rssBuildValue .= "\n";
    $rssBuildValue .= "# search pages\n";
    $rssBuildValue .= "#RewriteRule   ^psearch-com-([a-z]+)/([a-z]{1}.*)$                                     program/$1?page_flg={$_POST["cl_urlcd"]}&%{QUERY_STRING} [L]\n";
    $rssBuildValue .= "#RewriteRule   ^psearch-com-([a-z]+)/$                                                 program/portal_search_com.php?page_flg={$_POST["cl_urlcd"]}&%{QUERY_STRING} [L]\n";
    $rssBuildValue .= "\n";
    $rssBuildValue .= "# search pages\n";
    $rssBuildValue .= "#RewriteRule   ^psearch-([a-z]+)/([a-z]{1}.*)$                                         program/$1?page_flg={$_POST["cl_urlcd"]}&%{QUERY_STRING} [L]\n";
    $rssBuildValue .= "#RewriteRule   ^psearch-([a-z]+)/$                                                     program/portal_search.php?page_flg={$_POST["cl_urlcd"]}&%{QUERY_STRING} [L]\n";
    $rssBuildValue .= "\n";
    $rssBuildValue .= "# company pages\n";
    $rssBuildValue .= "#RewriteRule   ^pcompany-list/page-([0-9]+)\.html$                                     program/portal_company_list.php?p={$_POST["cl_urlcd"]}&%{QUERY_STRING} [L]\n";
    $rssBuildValue .= "#RewriteRule   ^pcompany-list/([a-z]{1}.*)$                                            program/{$_POST["cl_urlcd"]}?%{QUERY_STRING} [L]\n";
    $rssBuildValue .= "\n";
    $rssBuildValue .= "# index\n";
    $rssBuildValue .= "#RewriteRule   ^share/(.*)$                                                            program/share/{$_POST["cl_urlcd"]}?%{QUERY_STRING} [L]\n";
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
    $rssBuildValue .= "RewriteRule   ^diary-rss-([0-9]+)/([a-z]{1}.*)$                           program/$2?cl={$_POST["cl_urlcd"]}&dd=1&%{QUERY_STRING} [L]\n";
    $rssBuildValue .= "RewriteRule   ^diary-rss-([0-9]+)/$                                       program/rss/rss_diary_$1.xml?cl={$_POST["cl_urlcd"]}&dd=1&%{QUERY_STRING} [L]\n";
    $rssBuildValue .= "\n";
    $rssBuildValue .= "# コースRSS\n";
    $rssBuildValue .= "RewriteRule   ^course-rss-([0-9]+)/([a-z]{1}.*)$                          program/$2?cl={$_POST["cl_urlcd"]}&dd=1&%{QUERY_STRING} [L]\n";
    $rssBuildValue .= "RewriteRule   ^course-rss-([0-9]+)/$                                      program/rss/rss_course_$1.xml?cl={$_POST["cl_urlcd"]}&dd=1&%{QUERY_STRING} [L]\n";
    $rssBuildValue .= "\n";
    $rssBuildValue .= "# コース＋日記RSS\n";
    $rssBuildValue .= "RewriteRule   ^rss-([0-9]+)/([a-z]{1}.*)$                                 program/$2?cl={$_POST["cl_urlcd"]}&dd=1&%{QUERY_STRING} [L]\n";
    $rssBuildValue .= "RewriteRule   ^rss-([0-9]+)/$                                             program/rss/rss_$1.xml?cl={$_POST["cl_urlcd"]}&dd=1&%{QUERY_STRING} [L]\n";
    $rssBuildValue .= "\n";
    $rssBuildValue .= "# 日記詳細\n";
    $rssBuildValue .= "RewriteRule   ^blog-([0-9]+)/([a-z]{1}.*)$                                program/$2?cl={$_POST["cl_urlcd"]}&dd=1&drid=$1&%{QUERY_STRING} [L]\n";
    $rssBuildValue .= "RewriteRule   ^blog-([0-9]+)/$                                            program/blog.php?cl={$_POST["cl_urlcd"]}&dd=1&drid=$1&%{QUERY_STRING} [L]\n";
    $rssBuildValue .= "\n";
    $rssBuildValue .= "# キャンペーン詳細\n";
    $rssBuildValue .= "RewriteRule   ^campaign-detail-([0-9]+)/([a-z]{1}.*)$                     program/$2?cl={$_POST["cl_urlcd"]}&dd=1&cpid=$1&%{QUERY_STRING} [L]\n";
    $rssBuildValue .= "RewriteRule   ^campaign-detail-([0-9]+)/$                                 program/campaigndetail.php?cl={$_POST["cl_urlcd"]}&dd=1&cpid=$1&%{QUERY_STRING} [L]\n";
    $rssBuildValue .= "\n";
    $rssBuildValue .= "# コース詳細\n";
    $rssBuildValue .= "RewriteRule   ^course-detail-([0-9]+)/([a-z]{1}.*)$                       program/$2?cl={$_POST["cl_urlcd"]}&dd=1&csid=$1&%{QUERY_STRING} [L]\n";
    $rssBuildValue .= "RewriteRule   ^course-detail-([0-9]+)/$                                   program/coursedetail.php?cl={$_POST["cl_urlcd"]}&dd=1&csid=$1&%{QUERY_STRING} [L]\n";
    $rssBuildValue .= "\n";
    $rssBuildValue .= "# 入塾までの流れ\n";
    $rssBuildValue .= "RewriteRule   ^flow/([a-z]{1}.*)$                                         program/$1?cl={$_POST["cl_urlcd"]}&dd=1&%{QUERY_STRING} [L]\n";
    $rssBuildValue .= "RewriteRule   ^flow/$                                                     program/flow.php?cl={$_POST["cl_urlcd"]}&dd=1&%{QUERY_STRING} [L]\n";
    $rssBuildValue .= "\n";
    $rssBuildValue .= "# キャンペーンお申し込みフォーム\n";
    $rssBuildValue .= "RewriteRule   ^campaign-apply/([a-z]{1}.*)$                               program/$1?cl={$_POST["cl_urlcd"]}&dd=1&%{QUERY_STRING} [L]\n";
    $rssBuildValue .= "RewriteRule   ^campaign-apply/$                                           program/campaignapply.php?cl={$_POST["cl_urlcd"]}&dd=1&%{QUERY_STRING} [L]\n";
    $rssBuildValue .= "\n";
    $rssBuildValue .= "# キャンペーンお申し込み確認ページ\n";
    $rssBuildValue .= "RewriteRule   ^campaign-apply-confirm/([a-z]{1}.*)$                       program/$1?cl={$_POST["cl_urlcd"]}&dd=1&%{QUERY_STRING} [L]\n";
    $rssBuildValue .= "RewriteRule   ^campaign-apply-confirm/$                                   program/campaignapplyconfirm.php?cl={$_POST["cl_urlcd"]}&dd=1&%{QUERY_STRING} [L]\n";
    $rssBuildValue .= "\n";
    $rssBuildValue .= "# キャンペーンお問い合わせフォーム\n";
    $rssBuildValue .= "RewriteRule   ^campaign-inq/([a-z]{1}.*)$                                 program/$1?cl={$_POST["cl_urlcd"]}&dd=1&%{QUERY_STRING} [L]\n";
    $rssBuildValue .= "RewriteRule   ^campaign-inq/$                                             program/campaigninq.php?cl={$_POST["cl_urlcd"]}&dd=1&%{QUERY_STRING} [L]\n";
    $rssBuildValue .= "\n";
    $rssBuildValue .= "# キャンペーンお問い合わせ確認ページ\n";
    $rssBuildValue .= "RewriteRule   ^campaign-inq-confirm/([a-z]{1}.*)$                         program/$1?cl={$_POST["cl_urlcd"]}&dd=1&%{QUERY_STRING} [L]\n";
    $rssBuildValue .= "RewriteRule   ^campaign-inq-confirm/$                                     program/campconfirm.php?cl={$_POST["cl_urlcd"]}&dd=1&%{QUERY_STRING} [L]\n";
    $rssBuildValue .= "\n";
    $rssBuildValue .= "# コースお問い合わせフォーム\n";
    $rssBuildValue .= "RewriteRule   ^course-inq/([a-z]{1}.*)$                                   program/$1?cl={$_POST["cl_urlcd"]}&dd=1&%{QUERY_STRING} [L]\n";
    $rssBuildValue .= "RewriteRule   ^course-inq/$                                               program/courseinq.php?cl={$_POST["cl_urlcd"]}&dd=1&%{QUERY_STRING} [L]\n";
    $rssBuildValue .= "\n";
    $rssBuildValue .= "# コースお問い合わせ確認ページ\n";
    $rssBuildValue .= "RewriteRule   ^course-inq-confirm/([a-z]{1}.*)$                           program/$1?cl={$_POST["cl_urlcd"]}&dd=1&%{QUERY_STRING} [L]\n";
    $rssBuildValue .= "RewriteRule   ^course-inq-confirm/$                                       program/courseinqconfirm.php?cl={$_POST["cl_urlcd"]}&dd=1&%{QUERY_STRING} [L]\n";
    $rssBuildValue .= "\n";
    $rssBuildValue .= "# コース資料請求フォーム\n";
    $rssBuildValue .= "RewriteRule   ^course-req/([a-z]{1}.*)$                                   program/$1?cl={$_POST["cl_urlcd"]}&dd=1&%{QUERY_STRING} [L]\n";
    $rssBuildValue .= "RewriteRule   ^course-req/$                                               program/coursereq.php?cl={$_POST["cl_urlcd"]}&dd=1&%{QUERY_STRING} [L]\n";
    $rssBuildValue .= "\n";
    $rssBuildValue .= "# コース資料請求確認ページ\n";
    $rssBuildValue .= "RewriteRule   ^course-req-confirm/([a-z]{1}.*)$                           program/$1?cl={$_POST["cl_urlcd"]}&dd=1&%{QUERY_STRING} [L]\n";
    $rssBuildValue .= "RewriteRule   ^course-req-confirm/$                                       program/coursereqconfirm.php?cl={$_POST["cl_urlcd"]}&dd=1&%{QUERY_STRING} [L]\n";
    $rssBuildValue .= "\n";
    $rssBuildValue .= "# 資料請求フォーム\n";
    $rssBuildValue .= "RewriteRule   ^req/([a-z]{1}.*)$                                          program/$1?cl={$_POST["cl_urlcd"]}&dd=1&%{QUERY_STRING} [L]\n";
    $rssBuildValue .= "RewriteRule   ^req/$                                                      program/req.php?cl={$_POST["cl_urlcd"]}&dd=1&%{QUERY_STRING} [L]\n";
    $rssBuildValue .= "\n";
    $rssBuildValue .= "# 資料請求確認ページ\n";
    $rssBuildValue .= "RewriteRule   ^req-confirm/([a-z]{1}.*)$                                  program/$1?cl={$_POST["cl_urlcd"]}&dd=1&%{QUERY_STRING} [L]\n";
    $rssBuildValue .= "RewriteRule   ^req-confirm/$                                              program/reqconfirm.php?cl={$_POST["cl_urlcd"]}&dd=1&%{QUERY_STRING} [L]\n";
    $rssBuildValue .= "\n";
    $rssBuildValue .= "# お問い合わせフォーム\n";
    $rssBuildValue .= "RewriteRule   ^inquire/([a-z]{1}.*)$                                      program/$1?cl={$_POST["cl_urlcd"]}&dd=1&%{QUERY_STRING} [L]\n";
    $rssBuildValue .= "RewriteRule   ^inquire/$                                                  program/inquire.php?cl={$_POST["cl_urlcd"]}&dd=1&%{QUERY_STRING} [L]\n";
    $rssBuildValue .= "\n";
    $rssBuildValue .= "# お問い合わせ確認ページ\n";
    $rssBuildValue .= "RewriteRule   ^inq-confirm/([a-z]{1}.*)$                                  program/$1?cl={$_POST["cl_urlcd"]}&dd=1&%{QUERY_STRING} [L]\n";
    $rssBuildValue .= "RewriteRule   ^inq-confirm/$                                              program/inqconfirm.php?cl={$_POST["cl_urlcd"]}&dd=1&%{QUERY_STRING} [L]\n";
    $rssBuildValue .= "\n";
    $rssBuildValue .= "# 各種サンキューページ\n";
    $rssBuildValue .= "RewriteRule   ^complete/([a-z]{1}.*)$                                     program/$1?cl={$_POST["cl_urlcd"]}&dd=1&%{QUERY_STRING} [L]\n";
    $rssBuildValue .= "RewriteRule   ^complete/$                                                 program/complete.php?cl={$_POST["cl_urlcd"]}&dd=1&%{QUERY_STRING} [L]\n";
    $rssBuildValue .= "\n";
    $rssBuildValue .= "# 教室案内\n";
    $rssBuildValue .= "RewriteRule   ^school/([a-z]{1}.*)$                                       program/$1?cl={$_POST["cl_urlcd"]}&dd=1&%{QUERY_STRING} [L]\n";
    $rssBuildValue .= "RewriteRule   ^school/$                                                   program/school.php?cl={$_POST["cl_urlcd"]}&dd=1&%{QUERY_STRING} [L]\n";
    $rssBuildValue .= "\n";
    $rssBuildValue .= "# コース一覧\n";
    $rssBuildValue .= "RewriteRule   ^course-list/p-([0-9]+)/cs-([0-9]+)/([a-z]{1}.*)$           program/$3?cl={$_POST["cl_urlcd"]}&dd=1&page=$1&csid=$2&%{QUERY_STRING} [L]\n";
    $rssBuildValue .= "RewriteRule   ^course-list/p-([0-9]+)/cs-([0-9]+)/$                       program/courselist.php?cl={$_POST["cl_urlcd"]}&dd=1&page=$1&csid=$2&%{QUERY_STRING} [L]\n";
    $rssBuildValue .= "\n";
    $rssBuildValue .= "# キャンペーン一覧\n";
    $rssBuildValue .= "RewriteRule   ^campain-list/p-([0-9]+)/cp-([0-9]+)/([a-z]{1}.*)$          program/$3?cl={$_POST["cl_urlcd"]}&dd=1&page=$1&cpid=$2&%{QUERY_STRING} [L]\n";
    $rssBuildValue .= "RewriteRule   ^campain-list/p-([0-9]+)/cp-([0-9]+)/$                      program/campaignlist.php?cl={$_POST["cl_urlcd"]}&dd=1&page=$1&cpid=$2&%{QUERY_STRING} [L]\n";
    $rssBuildValue .= "\n";
    $rssBuildValue .= "# 日記一覧\n";
    $rssBuildValue .= "RewriteRule   ^diary-list/p-([0-9]+)/dr-([0-9]+)/([a-z]{1}.*)$            program/$3?cl={$_POST["cl_urlcd"]}&dd=1&page=$1&drid=$2&%{QUERY_STRING} [L]\n";
    $rssBuildValue .= "RewriteRule   ^diary-list/p-([0-9]+)/dr-([0-9]+)/$                        program/bloglist.php?cl={$_POST["cl_urlcd"]}&dd=1&page=$1&drid=$2&%{QUERY_STRING} [L]\n";
    $rssBuildValue .= "\n";
    $rssBuildValue .= "# 個人情報保護方針\n";
    $rssBuildValue .= "RewriteRule   ^kojin/([a-z]{1}.*)$                                        program/$1?cl={$_POST["cl_urlcd"]}&dd=1&%{QUERY_STRING} [L]\n";
    $rssBuildValue .= "RewriteRule   ^kojin/$                                                    program/privacy.php?cl={$_POST["cl_urlcd"]}&dd=1&%{QUERY_STRING} [L]\n";
    $rssBuildValue .= "\n";
    $rssBuildValue .= "# Q&A\n";
    $rssBuildValue .= "RewriteRule   ^qa/([a-z]{1}.*)$                                           program/$1?cl={$_POST["cl_urlcd"]}&dd=1&%{QUERY_STRING} [L]\n";
    $rssBuildValue .= "RewriteRule   ^qa/$                                                       program/QA.php?cl={$_POST["cl_urlcd"]}&dd=1&%{QUERY_STRING} [L]\n";
    $rssBuildValue .= "\n";
    $rssBuildValue .= "# index\n";
    $rssBuildValue .= "RewriteRule   ^img_thumbnail.php$                                         program/img_thumbnail.php?cl={$_POST["cl_urlcd"]}&dd=1&%{QUERY_STRING} [L]\n";
    $rssBuildValue .= "RewriteRule   ^cl_img/(.*)$                                               program/cl_img/$1?cl={$_POST["cl_urlcd"]}&dd=1&%{QUERY_STRING} [L]\n";
    $rssBuildValue .= "RewriteRule   ^share/(.*)$                                                program/share/$1?cl={$_POST["cl_urlcd"]}&dd=1&%{QUERY_STRING} [L]\n";
    $rssBuildValue .= "RewriteRule   ^$                                                          program/index.php?cl={$_POST["cl_urlcd"]}&dd=1 [L]\n";
    $rssBuildValue .= "\n";
    $rssBuildValue .= "# フリーページ\n";
    $rssBuildValue .= "RewriteRule   ^free-([0-9]+)/([a-z]{1}.*)$                                program/$2?cl={$_POST["cl_urlcd"]}&dd=1&drid=$1&%{QUERY_STRING} [L]\n";
    $rssBuildValue .= "RewriteRule   ^free-([0-9]+)/$                                            program/free.php?cl={$_POST["cl_urlcd"]}&dd=1&drid=$1&%{QUERY_STRING} [L]\n";
    $rssBuildValue .= "\n";

    fputs($buildRssTmp,$rssBuildValue);
    flock($buildRssTmp,LOCK_UN);
    fclose($buildRssTmp);

    // 独自ドメイン用シンボリックリンク生成
    @symlink( $param_dokuji_path."source/program" , $param_dokuji_path.$_POST["cl_urlcd"]."/program" );



    //20091021追加///////////////////////////////////////////////////////////////////////////////////////////
    //携帯独自ドメイン用ファイルの作成
    /////////////////////////////////////////////////////////////////////////////////////////////////////////
    // 携帯独自ドメイン用ディレクトリ生成
    @mkdir( $param_mobile_dokuji_path.$_POST["cl_urlcd"] , 0755);

    // 携帯独自ドメイン用.htaccessファイル生成
    $mobile_htaccess_fp = fopen($param_mobile_dokuji_path.$_POST["cl_urlcd"]."/.htaccess","w");
    if($mobile_htaccess_fp===flase)exit("ファイルオープン失敗");
    flock($mobile_htaccess_fp,LOCK_EX);
    $mobile_htaccess_str = "#############################################################\n";
    $mobile_htaccess_str .= "\n";
    $mobile_htaccess_str .= "# php setting - site_data\n";
    $mobile_htaccess_str .= "\n";
    $mobile_htaccess_str .= "#############################################################\n";
    $mobile_htaccess_str .= "\n";
    $mobile_htaccess_str .= "\n";
    $mobile_htaccess_str .= "# base setting\n";
    $mobile_htaccess_str .= "\n";
    $mobile_htaccess_str .= "php_flag register_globals off\n";
    $mobile_htaccess_str .= "php_flag magic_quotes_gpc on\n";
    $mobile_htaccess_str .= "php_flag display_errors on\n";
    $mobile_htaccess_str .= "php_flag magic_quotes_sybase off\n";
    $mobile_htaccess_str .= "\n";
    $mobile_htaccess_str .= "\n";
    $mobile_htaccess_str .= "# mbstring setting\n";
    $mobile_htaccess_str .= "\n";
    $mobile_htaccess_str .= "php_value mbstring.language Japanese\n";
    $mobile_htaccess_str .= "php_value mbstring.internal_encoding EUC-JP\n";
    $mobile_htaccess_str .= "php_value mbstring.http_input pass\n";
    $mobile_htaccess_str .= "php_flag  mbstring.encoding_translation on\n";
    $mobile_htaccess_str .= "php_value mbstring.substitute_character none\n";
    $mobile_htaccess_str .= "php_value mbstring.detect_order ASCII,EUC-JP,JIS,UTF-8,SJIS\n";
    $mobile_htaccess_str .= "php_value mbstring.func_overload 0\n";
    $mobile_htaccess_str .= "\n";
    $mobile_htaccess_str .= "\n";
    $mobile_htaccess_str .= "# session setting\n";
    $mobile_htaccess_str .= "\n";
    $mobile_htaccess_str .= "php_value session.name \"edyblo_mobile_blog_site_sess\"\n";
    $mobile_htaccess_str .= "php_flag  session.use_only_cookies on\n";
    $mobile_htaccess_str .= "php_value session.cache_limiter \"nocache\"\n";
    $mobile_htaccess_str .= "\n";
    $mobile_htaccess_str .= "\n";
    $mobile_htaccess_str .= "#############################################################\n";
    $mobile_htaccess_str .= "\n";
    $mobile_htaccess_str .= "# basic setting\n";
    $mobile_htaccess_str .= "\n";
    $mobile_htaccess_str .= "#############################################################\n";
    $mobile_htaccess_str .= "#AuthUserFile /home/jukutown.com/www/.htpasswd\n";
    $mobile_htaccess_str .= "#AuthGroupFile /dev/null\n";
    $mobile_htaccess_str .= "#AuthName \"Slash Area\"\n";
    $mobile_htaccess_str .= "#AuthType Basic\n";
    $mobile_htaccess_str .= "\n";
    $mobile_htaccess_str .= "#require valid-user\n";
    $mobile_htaccess_str .= "\n";
    $mobile_htaccess_str .= "#<Files ~ \"^.(htpasswd|htaccess)$\">\n";
    $mobile_htaccess_str .= "#    deny from all\n";
    $mobile_htaccess_str .= "#</Files> \n";
    $mobile_htaccess_str .= "\n";
    $mobile_htaccess_str .= "\n";
    $mobile_htaccess_str .= "############################################################\n";
    $mobile_htaccess_str .= "\n";
    $mobile_htaccess_str .= "# re-direct\n";
    $mobile_htaccess_str .= "\n";
    $mobile_htaccess_str .= "###########################################################\n";
    $mobile_htaccess_str .= "\n";
    $mobile_htaccess_str .= "#redirect permanent /dev/slash/estate/www/slash/ http://219.163.62.35/dev/slash/estate/www/click/ \n";
    $mobile_htaccess_str .= "\n";
    $mobile_htaccess_str .= "\n";
    $mobile_htaccess_str .= "\n";
    $mobile_htaccess_str .= "#############################################################\n";
    $mobile_htaccess_str .= "\n";
    $mobile_htaccess_str .= "# mod_rewrite setting - site_data\n";
    $mobile_htaccess_str .= "\n";
    $mobile_htaccess_str .= "#############################################################\n";
    $mobile_htaccess_str .= "\n";
    $mobile_htaccess_str .= "RewriteEngine On\n";
    $mobile_htaccess_str .= "RewriteBase   /\n";
    $mobile_htaccess_str .= "RewriteCond   %{REQUEST_FILENAME} !-f\n";
    $mobile_htaccess_str .= "RewriteCond   %{REQUEST_FILENAME} !-d\n";
    $mobile_htaccess_str .= "\n";
    $mobile_htaccess_str .= "\n";
    $mobile_htaccess_str .= "#####################################################################################################################\n";
    $mobile_htaccess_str .= "\n";
    $mobile_htaccess_str .= "# blog setting\n";
    $mobile_htaccess_str .= "\n";

    //			$mobile_htaccess_str .= "# 日記詳細1\n";
    //			$mobile_htaccess_str .= "RewriteRule   ^blog-([0-9]+)/([a-z]{1}.*)$                          program/$2?cl={$_POST["cl_urlcd"]}&dd=1&drid=$1 [QSA,L]\n";
    //			$mobile_htaccess_str .= "RewriteRule   ^blog-([0-9]+)/$                                      program/blog.php?cl={$_POST["cl_urlcd"]}&dd=1&drid=$1 [QSA,L]\n";
    //			$mobile_htaccess_str .= "\n";

    $mobile_htaccess_str .= "# 日記詳細1\n";
    $mobile_htaccess_str .= "RewriteRule   ^blog-([0-9]+)/$                                      program/blog.php?cl={$_POST["cl_urlcd"]}&dd=1&drid=$1 [QSA,L]\n";
    $mobile_htaccess_str .= "RewriteRule   ^blog-([0-9]+)/img([0-9]+)/([a-z]{1}.*)$              program/$3?cl={$_POST["cl_urlcd"]}&dd=1&drid=$1&img=$2 [QSA,L]\n";
    $mobile_htaccess_str .= "RewriteRule   ^blog-([0-9]+)/img([0-9]+)/$                          program/blog.php?cl={$_POST["cl_urlcd"]}&dd=1&drid=$1&img=$2 [QSA,L]\n";
    $mobile_htaccess_str .= "\n";

    $mobile_htaccess_str .= "# 日記詳細2\n";
    $mobile_htaccess_str .= "RewriteRule   ^blogd-([0-9]+)/([a-z]{1}.*)$                         program/$2?cl={$_POST["cl_urlcd"]}&dd=1&drid=$1 [QSA,L]\n";
    $mobile_htaccess_str .= "RewriteRule   ^blogd-([0-9]+)/$                                     program/blog_detail.php?cl={$_POST["cl_urlcd"]}&dd=1&drid=$1 [QSA,L]\n";
    $mobile_htaccess_str .= "\n";
    $mobile_htaccess_str .= "# 日記詳細3(画像)\n";
    $mobile_htaccess_str .= "RewriteRule   ^blog-img([0-9]+)/([a-z]{1}.*)$                       program/$2?cl={$_POST["cl_urlcd"]}&dd=1&drid=$1 [QSA,L]\n";
    $mobile_htaccess_str .= "RewriteRule   ^blog-img([0-9]+)/$                                   program/blog_img.php?cl={$_POST["cl_urlcd"]}&dd=1&drid=$1 [QSA,L]\n";
    $mobile_htaccess_str .= "\n";
    $mobile_htaccess_str .= "# キャンペーン詳細1\n";
    $mobile_htaccess_str .= "RewriteRule   ^campaign-detail-([0-9]+)/([a-z]{1}.*)$               program/$2?cl={$_POST["cl_urlcd"]}&dd=1&cpid=$1 [QSA,L]\n";
    $mobile_htaccess_str .= "RewriteRule   ^campaign-detail-([0-9]+)/$                           program/campaigndetail.php?cl={$_POST["cl_urlcd"]}&dd=1&cpid=$1 [QSA,L]\n";
    $mobile_htaccess_str .= "\n";
    $mobile_htaccess_str .= "# キャンペーン詳細2\n";
    $mobile_htaccess_str .= "RewriteRule   ^campaign-detaild-([0-9]+)/([a-z]{1}.*)$              program/$2?cl={$_POST["cl_urlcd"]}&dd=1&caid=$1 [QSA,L]\n";
    $mobile_htaccess_str .= "RewriteRule   ^campaign-detaild-([0-9]+)/$                          program/campaigndetaild.php?cl={$_POST["cl_urlcd"]}&dd=1&caid=$1 [QSA,L]\n";
    $mobile_htaccess_str .= "\n";
    $mobile_htaccess_str .= "# 資料請求フォーム\n";
    $mobile_htaccess_str .= "RewriteRule   ^req/([a-z]{1}.*)$                                    program/$1?cl={$_POST["cl_urlcd"]}&dd=1 [QSA,L]\n";
    $mobile_htaccess_str .= "RewriteRule   ^req/$                                                program/req.php?cl={$_POST["cl_urlcd"]}&dd=1 [QSA,L]\n";
    $mobile_htaccess_str .= "\n";
    $mobile_htaccess_str .= "# 資料請求確認ページ\n";
    $mobile_htaccess_str .= "RewriteRule   ^req-confirm/([a-z]{1}.*)$                            program/$1?cl={$_POST["cl_urlcd"]}&dd=1 [QSA,L]\n";
    $mobile_htaccess_str .= "RewriteRule   ^req-confirm/$                                        program/reqconfirm.php?cl={$_POST["cl_urlcd"]}&dd=1 [QSA,L]\n";
    $mobile_htaccess_str .= "\n";
    $mobile_htaccess_str .= "# お問い合わせフォーム\n";
    $mobile_htaccess_str .= "RewriteRule   ^inquire/([a-z]{1}.*)$                                program/$1?cl={$_POST["cl_urlcd"]}&dd=1 [QSA,L]\n";
    $mobile_htaccess_str .= "RewriteRule   ^inquire/$                                            program/inquire.php?cl={$_POST["cl_urlcd"]}&dd=1 [QSA,L]\n";
    $mobile_htaccess_str .= "\n";
    $mobile_htaccess_str .= "# お問い合わせ確認ページ\n";
    $mobile_htaccess_str .= "RewriteRule   ^inq-confirm/([a-z]{1}.*)$                            program/$1?cl={$_POST["cl_urlcd"]}&dd=1 [QSA,L]\n";
    $mobile_htaccess_str .= "RewriteRule   ^inq-confirm/$                                        program/inqconfirm.php?cl={$_POST["cl_urlcd"]}&dd=1 [QSA,L]\n";
    $mobile_htaccess_str .= "\n";
    $mobile_htaccess_str .= "# 資料請求メール送信ページ\n";
    $mobile_htaccess_str .= "RewriteRule   ^req_finish/([a-z]{1}.*)$                             program/$1?cl={$_POST["cl_urlcd"]}&dd=1 [QSA,L]\n";
    $mobile_htaccess_str .= "RewriteRule   ^req_finish/$                                         program/req_finish.php?cl={$_POST["cl_urlcd"]}&dd=1 [QSA,L]\n";
    $mobile_htaccess_str .= "\n";
    $mobile_htaccess_str .= "# お問い合わせメール送信ページ\n";
    $mobile_htaccess_str .= "RewriteRule   ^inq_finish/([a-z]{1}.*)$                             program/$1?cl={$_POST["cl_urlcd"]}&dd=1 [QSA,L]\n";
    $mobile_htaccess_str .= "RewriteRule   ^inq_finish/$                                         program/inq_finish.php?cl={$_POST["cl_urlcd"]}&dd=1 [QSA,L]\n";
    $mobile_htaccess_str .= "\n";
    $mobile_htaccess_str .= "# 資料請求サンキューページ\n";
    $mobile_htaccess_str .= "RewriteRule   ^req_end/([a-z]{1}.*)$                                program/$1?cl={$_POST["cl_urlcd"]}&dd=1 [QSA,L]\n";
    $mobile_htaccess_str .= "RewriteRule   ^req_end/$                                            program/req_end.php?cl={$_POST["cl_urlcd"]}&dd=1 [QSA,L]\n";
    $mobile_htaccess_str .= "\n";
    $mobile_htaccess_str .= "# お問い合わせサンキューページ\n";
    $mobile_htaccess_str .= "RewriteRule   ^inq_end/([a-z]{1}.*)$                                program/$1?cl={$_POST["cl_urlcd"]}&dd=1 [QSA,L]\n";
    $mobile_htaccess_str .= "RewriteRule   ^inq_end/$                                            program/inq_end.php?cl={$_POST["cl_urlcd"]}&dd=1 [QSA,L]\n";
    $mobile_htaccess_str .= "\n";
    $mobile_htaccess_str .= "# 教室案内\n";
    $mobile_htaccess_str .= "RewriteRule   ^school/([a-z]{1}.*)$                                 program/$1?cl={$_POST["cl_urlcd"]}&dd=1 [QSA,L]\n";
    $mobile_htaccess_str .= "RewriteRule   ^school/$                                             program/school.php?cl={$_POST["cl_urlcd"]}&dd=1 [QSA,L]\n";
    $mobile_htaccess_str .= "\n";
    $mobile_htaccess_str .= "# 教室案内(教室詳細1)\n";
    $mobile_htaccess_str .= "RewriteRule   ^school_detail/([a-z]{1}.*)$                          program/$1?cl={$_POST["cl_urlcd"]}&dd=1 [QSA,L]\n";
    $mobile_htaccess_str .= "RewriteRule   ^school_detail/$                                      program/school_detail.php?cl={$_POST["cl_urlcd"]}&dd=1 [QSA,L]\n";
    $mobile_htaccess_str .= "\n";

    //			$mobile_htaccess_str .= "# 教室案内(教室詳細2)\n";
    //			$mobile_htaccess_str .= "RewriteRule   ^school_detaild/([a-z]{1}.*)$                         program/$1?cl={$_POST["cl_urlcd"]}&dd=1 [QSA,L]\n";
    //			$mobile_htaccess_str .= "RewriteRule   ^school_detaild/$                                     program/school_detaild.php?cl={$_POST["cl_urlcd"]}&dd=1 [QSA,L]\n";
    //			$mobile_htaccess_str .= "\n";

    $mobile_htaccess_str .= "# 教室案内(教室詳細2)\n";
    $mobile_htaccess_str .= "RewriteRule   ^school_detaild/p([0-9]+)/([a-z]{1}.*)$               program/$2?cl={$_POST["cl_urlcd"]}&dd=1&get=$1 [QSA,L]\n";
    $mobile_htaccess_str .= "RewriteRule   ^school_detaild/p([0-9]+)/$                           program/school_detaild.php?cl={$_POST["cl_urlcd"]}&dd=1&get=$1 [QSA,L]\n";
    $mobile_htaccess_str .= "\n";
    $mobile_htaccess_str .= "# 教室案内(MAP表示)\n";
    $mobile_htaccess_str .= "RewriteRule   ^school_map/([a-z]{1}.*)$                             program/$1?cl={$_POST["cl_urlcd"]}&dd=1 [QSA,L]\n";
    $mobile_htaccess_str .= "RewriteRule   ^school_map/$                                         program/school_map.php?cl={$_POST["cl_urlcd"]}&dd=1 [QSA,L]\n";
    $mobile_htaccess_str .= "\n";
    $mobile_htaccess_str .= "# キャンペーン一覧\n";
    $mobile_htaccess_str .= "RewriteRule   ^campain-list/p-([0-9]+)/cp-([0-9]+)/([a-z]{1}.*)$    program/$3?cl={$_POST["cl_urlcd"]}&dd=1&page=$1&cpid=$2 [QSA,L]\n";
    $mobile_htaccess_str .= "RewriteRule   ^campain-list/p-([0-9]+)/cp-([0-9]+)/$                program/campaignlist.php?cl={$_POST["cl_urlcd"]}&dd=1&page=$1&cpid=$2 [QSA,L]\n";
    $mobile_htaccess_str .= "\n";
    $mobile_htaccess_str .= "# 日記一覧\n";
    $mobile_htaccess_str .= "RewriteRule   ^diary-list/p-([0-9]+)/dr-([0-9]+)/([a-z]{1}.*)$      program/$3?cl={$_POST["cl_urlcd"]}&dd=1&page=$1&drid=$2 [QSA,L]\n";
    $mobile_htaccess_str .= "RewriteRule   ^diary-list/p-([0-9]+)/dr-([0-9]+)/$                  program/bloglist.php?cl={$_POST["cl_urlcd"]}&dd=1&page=$1&drid=$2 [QSA,L]\n";
    $mobile_htaccess_str .= "\n";
    $mobile_htaccess_str .= "# 個人情報保護方針\n";
    $mobile_htaccess_str .= "RewriteRule   ^kojin/([a-z]{1}.*)$                                  program/$1?cl={$_POST["cl_urlcd"]}&dd=1 [QSA,L]\n";
    $mobile_htaccess_str .= "RewriteRule   ^kojin/$                                              program/privacy.php?cl={$_POST["cl_urlcd"]}&dd=1 [QSA,L]\n";
    $mobile_htaccess_str .= "\n";
    $mobile_htaccess_str .= "# Q&A\n";
    $mobile_htaccess_str .= "RewriteRule   ^qa/([a-z]{1}.*)$                                     program/$1?cl={$_POST["cl_urlcd"]}&dd=1 [QSA,L]\n";
    $mobile_htaccess_str .= "RewriteRule   ^qa/$                                                 program/QA.php?cl={$_POST["cl_urlcd"]}&dd=1 [QSA,L]\n";
    $mobile_htaccess_str .= "\n";
    $mobile_htaccess_str .= "# index\n";
    $mobile_htaccess_str .= "RewriteRule   ^img_thumbnail.php$                                   program/img_thumbnail.php?cl={$_POST["cl_urlcd"]}&dd=1 [QSA,L]\n";
    $mobile_htaccess_str .= "RewriteRule   ^cl_img/(.*)$                                         program/cl_img/$1?cl={$_POST["cl_urlcd"]}&dd=1 [QSA,L]\n";
    $mobile_htaccess_str .= "RewriteRule   ^share/(.*)$                                          program/share/$1?cl={$_POST["cl_urlcd"]}&dd=1 [QSA,L]\n";
    $mobile_htaccess_str .= "RewriteRule   ^$                                                    program/index.php?cl={$_POST["cl_urlcd"]}&dd=1 [QSA,L]\n";
    $mobile_htaccess_str .= "\n";
    $mobile_htaccess_str .= "# フリーページ\n";
    $mobile_htaccess_str .= "RewriteRule   ^free-([0-9]+)/([a-z]{1}.*)$                                program/$2?cl={$_POST["cl_urlcd"]}&dd=1&drid=$1&%{QUERY_STRING} [L]\n";
    $mobile_htaccess_str .= "RewriteRule   ^free-([0-9]+)/$                                            program/free.php?cl={$_POST["cl_urlcd"]}&dd=1&drid=$1&%{QUERY_STRING} [L]\n";
    $mobile_htaccess_str .= "\n";

    fputs($mobile_htaccess_fp,$mobile_htaccess_str);
    flock($mobile_htaccess_fp,LOCK_UN);
    fclose($mobile_htaccess_fp);

    // 携帯独自ドメイン用シンボリックリンク生成
    @symlink( $param_mobile_dokuji_path."source/program" , $param_mobile_dokuji_path.$_POST["cl_urlcd"]."/program" );

    break;


case 'EDIT':
    //echo("%%3%%");
    // フリーワード検索用文字列を生成
    fn_create_freeword( $obj_conn->conn , $_POST["cl_id"] , $cl_yobi1);

    $obj_rev = new basedb_ClientClassTblAccess;
    $obj_rev->conn = $obj_conn->conn;
    $obj_rev->clientdat[0]["cl_id"] = pg_escape_string($_POST["cl_id"]);
    $obj_rev->clientdat[0]["cl_stat"] = pg_escape_string($_POST["cl_stat"]);
    $obj_rev->clientdat[0]["cl_dokuji_flg"] = pg_escape_string($_POST["cl_dokuji_flg"]);
    $obj_rev->clientdat[0]["cl_googlemap_key"] = pg_escape_string($_POST["cl_googlemap_key"]);
    $obj_rev->clientdat[0]["cl_dokuji_domain"] = pg_escape_string($_POST["cl_dokuji_domain"]);
    $obj_rev->clientdat[0]["cl_advertisement_flg"] = pg_escape_string($_POST["cl_advertisement_flg"]);
    $obj_rev->clientdat[0]["cl_advertisement_tag"] = pg_escape_string($_POST["cl_advertisement_tag"]);
    $obj_rev->clientdat[0]["cl_mobile_flg"] = pg_escape_string($_POST["cl_mobile_flg"]);
    $obj_rev->clientdat[0]["cl_mobile_dokuji_flg"] = pg_escape_string($_POST["cl_mobile_dokuji_flg"]);
    $obj_rev->clientdat[0]["cl_mobile_googlemap_key"] = pg_escape_string($_POST["cl_mobile_googlemap_key"]);
    $obj_rev->clientdat[0]["cl_mobile_dokuji_domain"] = pg_escape_string($_POST["cl_mobile_dokuji_domain"]);
    $obj_rev->clientdat[0]["cl_smartphone_flg"] = pg_escape_string($_POST["cl_smartphone_flg"]);
    $obj_rev->clientdat[0]["cl_jname"] = pg_escape_string($_POST["cl_jname"]);
    $obj_rev->clientdat[0]["cl_kname"] = pg_escape_string($_POST["cl_kname"]);
    $obj_rev->clientdat[0]["cl_agent"] = pg_escape_string($_POST["cl_agent"]);
    $obj_rev->clientdat[0]["cl_phone"] = pg_escape_string($_POST["cl_phone"]);
    $obj_rev->clientdat[0]["cl_fax"] = pg_escape_string($_POST["cl_fax"]);
    $obj_rev->clientdat[0]["cl_mail"] = pg_escape_string($_POST["cl_mail"]);
    $obj_rev->clientdat[0]["cl_loginid"] = pg_escape_string($_POST["cl_loginid"]);
    $obj_rev->clientdat[0]["cl_passwd"] = pg_escape_string($_POST["cl_passwd"]);
    $obj_rev->clientdat[0]["cl_logincd"] = pg_escape_string(sha1($_POST["cl_loginid"]));
    $obj_rev->clientdat[0]["cl_passcd"] = pg_escape_string(sha1($_POST["cl_passwd"]));
    if($_POST["cl_urlcd"]!="" || $_POST["cl_dokuji_flg"]!=1){
        $obj_rev->clientdat[0]["cl_urlcd"] = pg_escape_string($_POST["cl_urlcd"]);
    }
    IF( $_POST["cl_end_y"] != "" && $_POST["cl_end_m"] != "" && $_POST["cl_end_d"] != "" ) {
        $obj_rev->clientdat[0]["cl_end"] = pg_escape_string($_POST["cl_end_y"])."-".pg_escape_string($_POST["cl_end_m"])."-".pg_escape_string($_POST["cl_end_d"]);
    }
    IF( $_POST["cl_start_y"] != "" && $_POST["cl_start_m"] != "" && $_POST["cl_start_d"] != "" ) {
        $obj_rev->clientdat[0]["cl_start"] = pg_escape_string($_POST["cl_start_y"])."-".pg_escape_string($_POST["cl_start_m"])."-".pg_escape_string($_POST["cl_start_d"]);
    }
    $obj_rev->clientdat[0]["cl_biko"] = pg_escape_string($_POST['cl_biko']);
    $obj_rev->clientdat[0]["cl_pstat"] = pg_escape_string($_POST["cl_pstat"]);
    $obj_rev->clientdat[0]["cl_makeid"] = pg_escape_string($_SESSION['ad_id']);
    $obj_rev->clientdat[0]["cl_upddate"] = pg_escape_string($_POST["cl_upddate"]);
    $obj_rev->clientdat[0]["cl_yobi1"] = pg_escape_string($cl_yobi1);
    $suc = $obj_rev->basedb_UpdClient();
    switch( $suc ){
    case "-1":
        //echo("%%2%%");
        $arrErr["ath_comment"] = $strErrHidden;
        $obj_error->ViewErrMessage( "UPD_ERROR" , "ALL" , "client_mnt.php" , $arrErr );
        exit;
    case "1":
        $arrErr["ath_comment"] = $strErrHidden;
        $obj_error->ViewErrMessage( "DOUBLE_UPD" , "ALL" , "client_mnt.php" , $arrErr );
        exit;
    case "4":
        $arrErr["ath_comment"] = $strErrHidden;
        $obj_error->ViewErrMessage( "LOGIN_ID" , "ALL" , "client_mnt.php" , $arrErr );
        exit;
    case "3":
        $arrErr["ath_comment"] = $strErrHidden;
        $obj_error->ViewErrMessage( "URL_CODE" , "ALL" , "client_mnt.php" , $arrErr );
        exit;
    }

    //echo("%%1%%");
    //  エリア情報登録
    $obj_area_upd = new basedb_AreaClassTblAccess;
    $obj_area_upd->conn = $obj_conn->conn;
    $obj_area_upd->areadat[0]["ar_id"] = $_POST["ar_id"];
    $obj_area_upd->areadat[0]["ar_clid"] = $_POST["cl_id"];
    $obj_area_upd->areadat[0]["ar_flg"] = 1;
    $obj_area_upd->areadat[0]["ar_zip"] = $zip;
    $obj_area_upd->areadat[0]["ar_pref"] = $_POST["ar_pref"];
    $obj_area_upd->areadat[0]["ar_prefcd"] = $_POST["ar_prefcd"];
    $obj_area_upd->areadat[0]["ar_city"] = $_POST["ar_city"];
    $obj_area_upd->areadat[0]["ar_citycd"] = $_POST["ar_citycd"];
    $obj_area_upd->areadat[0]["ar_add"] = $_POST["ar_add"];
    $obj_area_upd->areadat[0]["ar_estate"] = $_POST["ar_estate"];
    $obj_area_upd->areadat[0]["ar_upddate"] = $_POST["ar_upddate"];
    $ret_area_upd = $obj_area_upd->basedb_UpdArea();
    IF( $ret_area_upd != 0 ) {
        //echo("ret_area_upd...".$ret_area_upd);
        $arrErr["ath_comment"] = $strErrHidden;
        $obj_error->ViewErrMessage( "CLIENT_NO_BLOG" , "ALL" , "client_main.php" , $arrErr );
        exit;
    }

    //  エリア情報登録
    $obj_area_upd1 = new basedb_AreaClassTblAccess;
    $obj_area_upd1->conn = $obj_conn->conn;
    $obj_area_upd1->areadat[0]["ar_id"] = $_POST["ar_id1"];
    $obj_area_upd1->areadat[0]["ar_clid"] = $_POST["cl_id"];
    $obj_area_upd1->areadat[0]["ar_flg"] = 2;
    $obj_area_upd1->areadat[0]["ar_zip"] = $zip1;
    $obj_area_upd1->areadat[0]["ar_pref"] = $_POST["ar_pref1"];
    $obj_area_upd1->areadat[0]["ar_prefcd"] = $_POST["ar_prefcd1"];
    $obj_area_upd1->areadat[0]["ar_city"] = $_POST["ar_city1"];
    $obj_area_upd1->areadat[0]["ar_citycd"] = $_POST["ar_citycd1"];
    $obj_area_upd1->areadat[0]["ar_add"] = $_POST["ar_add1"];
    $obj_area_upd1->areadat[0]["ar_estate"] = $_POST["ar_estate1"];
    $obj_area_upd1->areadat[0]["ar_upddate"] = $_POST["ar_upddate1"];
    $ret_area_upd1 = $obj_area_upd1->basedb_UpdArea();
    IF( $ret_area_upd1 != 0 ) {
        //echo("ret_area_upd1...".$ret_area_upd1);
        $arrErr["ath_comment"] = $strErrHidden;
        $obj_error->ViewErrMessage( "CLIENT_NO_BLOG" , "ALL" , "client_main.php" , $arrErr );
        exit;
    }

    //  エリア情報登録
    $obj_area_upd2 = new basedb_AreaClassTblAccess;
    $obj_area_upd2->conn = $obj_conn->conn;
    $obj_area_upd2->areadat[0]["ar_id"] = $_POST["ar_id2"];
    $obj_area_upd2->areadat[0]["ar_clid"] = $_POST["cl_id"];
    $obj_area_upd2->areadat[0]["ar_flg"] = 3;
    $obj_area_upd2->areadat[0]["ar_zip"] = $zip2;
    $obj_area_upd2->areadat[0]["ar_pref"] = $_POST["ar_pref2"];
    $obj_area_upd2->areadat[0]["ar_prefcd"] = $_POST["ar_prefcd2"];
    $obj_area_upd2->areadat[0]["ar_city"] = $_POST["ar_city2"];
    $obj_area_upd2->areadat[0]["ar_citycd"] = $_POST["ar_citycd2"];
    $obj_area_upd2->areadat[0]["ar_add"] = $_POST["ar_add2"];
    $obj_area_upd2->areadat[0]["ar_estate"] = $_POST["ar_estate2"];
    $obj_area_upd2->areadat[0]["ar_upddate"] = $_POST["ar_upddate2"];
    $ret_area_upd2 = $obj_area_upd2->basedb_UpdArea();
    IF( $ret_area_upd2 != 0 ) {
        //echo("ret_area_upd2...".$ret_area_upd2);
        $arrErr["ath_comment"] = $strErrHidden;
        $obj_error->ViewErrMessage( "CLIENT_NO_BLOG" , "ALL" , "client_main.php" , $arrErr );
        exit;
    }

    //  エリア情報登録
    $obj_area_upd3 = new basedb_AreaClassTblAccess;
    $obj_area_upd3->conn = $obj_conn->conn;
    $obj_area_upd3->areadat[0]["ar_id"] = $_POST["ar_id3"];
    $obj_area_upd3->areadat[0]["ar_clid"] = $_POST["cl_id"];
    $obj_area_upd3->areadat[0]["ar_flg"] = 4;
    $obj_area_upd3->areadat[0]["ar_zip"] = $zip3;
    $obj_area_upd3->areadat[0]["ar_pref"] = $_POST["ar_pref3"];
    $obj_area_upd3->areadat[0]["ar_prefcd"] = $_POST["ar_prefcd3"];
    $obj_area_upd3->areadat[0]["ar_city"] = $_POST["ar_city3"];
    $obj_area_upd3->areadat[0]["ar_citycd"] = $_POST["ar_citycd3"];
    $obj_area_upd3->areadat[0]["ar_add"] = $_POST["ar_add3"];
    $obj_area_upd3->areadat[0]["ar_estate"] = $_POST["ar_estate3"];
    $obj_area_upd3->areadat[0]["ar_upddate"] = $_POST["ar_upddate3"];
    $ret_area_upd3 = $obj_area_upd3->basedb_UpdArea();
    IF( $ret_area_upd3 != 0 ) {
        //echo("ret_area_upd3...".$ret_area_upd3);
        $arrErr["ath_comment"] = $strErrHidden;
        $obj_error->ViewErrMessage( "CLIENT_NO_BLOG" , "ALL" , "client_main.php" , $arrErr );
        exit;
    }

    $message = "クライアント情報を修正しました。";
    if (!file_exists($param_dokuji_path.$_POST["cl_urlcd"])) {	// 独自ドメイン用ディレクトリがまだ存在しない場合のみ作成
        // 独自ドメイン用ディレクトリ生成
        @mkdir( $param_dokuji_path.$_POST["cl_urlcd"] , 0755);

        // 独自ドメイン用.htaccessファイル生成
        $buildRssTmp = fopen($param_dokuji_path.$_POST["cl_urlcd"]."/.htaccess","w");
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
        $rssBuildValue .= "#RewriteRule   ^kiyaku/([a-z]{1}.*)$                                                   program/{$_POST["cl_urlcd"]}?%{QUERY_STRING} [L]\n";
        $rssBuildValue .= "#RewriteRule   ^sitemap/$                                                              program/portal_tpl_control.php?tpl_flg=sitemap%{QUERY_STRING} [L]\n";
        $rssBuildValue .= "#RewriteRule   ^sitemap/([a-z]{1}.*)$                                                  program/{$_POST["cl_urlcd"]}?%{QUERY_STRING} [L]\n";
        $rssBuildValue .= "#RewriteRule   ^privacy/$                                                              program/portal_tpl_control.php?tpl_flg=privacy%{QUERY_STRING} [L]\n";
        $rssBuildValue .= "#RewriteRule   ^privacy/([a-z]{1}.*)$                                                  program/{$_POST["cl_urlcd"]}?%{QUERY_STRING} [L]\n";
        $rssBuildValue .= "#RewriteRule   ^com-pro/$                                                              program/portal_tpl_control.php?tpl_flg=com-pro%{QUERY_STRING} [L]\n";
        $rssBuildValue .= "#RewriteRule   ^com-pro/([a-z]{1}.*)$                                                  program/{$_POST["cl_urlcd"]}?%{QUERY_STRING} [L]\n";
        $rssBuildValue .= "#RewriteRule   ^forcom/$                                                               program/portal_tpl_control.php?tpl_flg=forcom%{QUERY_STRING} [L]\n";
        $rssBuildValue .= "#RewriteRule   ^forcom/([a-z]{1}.*)$                                                   program/{$_POST["cl_urlcd"]}?%{QUERY_STRING} [L]\n";
        $rssBuildValue .= "\n";
        $rssBuildValue .= "# diary\n";
        $rssBuildValue .= "#RewriteRule   ^diary/$                                                                program/portal_diary.php?%{QUERY_STRING} [L]\n";
        $rssBuildValue .= "#RewriteRule   ^diary/([a-z]{1}.*)$                                                    program/{$_POST["cl_urlcd"]}?%{QUERY_STRING} [L]\n";
        $rssBuildValue .= "\n";
        $rssBuildValue .= "# inquiry\n";
        $rssBuildValue .= "#RewriteRule   ^inquiry/([a-z]{1}.*)$                                                  program/{$_POST["cl_urlcd"]}?%{QUERY_STRING} [L]\n";
        $rssBuildValue .= "#RewriteRule   ^inquiry/$                                                              program/portal_inquiry.php?%{QUERY_STRING} [L]\n";
        $rssBuildValue .= "\n";
        $rssBuildValue .= "# search result\n";
        $rssBuildValue .= "#RewriteRule   ^psearch-result/page-([0-9]+)\.html$                                    program/portal_build_list.php?p={$_POST["cl_urlcd"]}&%{QUERY_STRING} [L]\n";
        $rssBuildValue .= "#RewriteRule   ^psearch-result/([a-z]{1}.*)$                                           program/{$_POST["cl_urlcd"]}?%{QUERY_STRING} [L]\n";
        $rssBuildValue .= "\n";
        $rssBuildValue .= "# search map pages\n";
        $rssBuildValue .= "#RewriteRule   ^psearch-map/$                                                          program/portal_search_map.php?%{QUERY_STRING} [L]\n";
        $rssBuildValue .= "#RewriteRule   ^psearch-map/([a-z]{1}.*)$                                              program/{$_POST["cl_urlcd"]}?%{QUERY_STRING} [L]\n";
        $rssBuildValue .= "\n";
        $rssBuildValue .= "# search pages\n";
        $rssBuildValue .= "#RewriteRule   ^psearch-com-([a-z]+)/([a-z]{1}.*)$                                     program/$1?page_flg={$_POST["cl_urlcd"]}&%{QUERY_STRING} [L]\n";
        $rssBuildValue .= "#RewriteRule   ^psearch-com-([a-z]+)/$                                                 program/portal_search_com.php?page_flg={$_POST["cl_urlcd"]}&%{QUERY_STRING} [L]\n";
        $rssBuildValue .= "\n";
        $rssBuildValue .= "# search pages\n";
        $rssBuildValue .= "#RewriteRule   ^psearch-([a-z]+)/([a-z]{1}.*)$                                         program/$1?page_flg={$_POST["cl_urlcd"]}&%{QUERY_STRING} [L]\n";
        $rssBuildValue .= "#RewriteRule   ^psearch-([a-z]+)/$                                                     program/portal_search.php?page_flg={$_POST["cl_urlcd"]}&%{QUERY_STRING} [L]\n";
        $rssBuildValue .= "\n";
        $rssBuildValue .= "# company pages\n";
        $rssBuildValue .= "#RewriteRule   ^pcompany-list/page-([0-9]+)\.html$                                     program/portal_company_list.php?p={$_POST["cl_urlcd"]}&%{QUERY_STRING} [L]\n";
        $rssBuildValue .= "#RewriteRule   ^pcompany-list/([a-z]{1}.*)$                                            program/{$_POST["cl_urlcd"]}?%{QUERY_STRING} [L]\n";
        $rssBuildValue .= "\n";
        $rssBuildValue .= "# index\n";
        $rssBuildValue .= "#RewriteRule   ^share/(.*)$                                                            program/share/{$_POST["cl_urlcd"]}?%{QUERY_STRING} [L]\n";
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
        $rssBuildValue .= "RewriteRule   ^diary-rss-([0-9]+)/([a-z]{1}.*)$                           program/$2?cl={$_POST["cl_urlcd"]}&dd=1&%{QUERY_STRING} [L]\n";
        $rssBuildValue .= "RewriteRule   ^diary-rss-([0-9]+)/$                                       program/rss/rss_diary_$1.xml?cl={$_POST["cl_urlcd"]}&dd=1&%{QUERY_STRING} [L]\n";
        $rssBuildValue .= "\n";
        $rssBuildValue .= "# コースRSS\n";
        $rssBuildValue .= "RewriteRule   ^course-rss-([0-9]+)/([a-z]{1}.*)$                          program/$2?cl={$_POST["cl_urlcd"]}&dd=1&%{QUERY_STRING} [L]\n";
        $rssBuildValue .= "RewriteRule   ^course-rss-([0-9]+)/$                                      program/rss/rss_course_$1.xml?cl={$_POST["cl_urlcd"]}&dd=1&%{QUERY_STRING} [L]\n";
        $rssBuildValue .= "\n";
        $rssBuildValue .= "# コース＋日記RSS\n";
        $rssBuildValue .= "RewriteRule   ^rss-([0-9]+)/([a-z]{1}.*)$                                 program/$2?cl={$_POST["cl_urlcd"]}&dd=1&%{QUERY_STRING} [L]\n";
        $rssBuildValue .= "RewriteRule   ^rss-([0-9]+)/$                                             program/rss/rss_$1.xml?cl={$_POST["cl_urlcd"]}&dd=1&%{QUERY_STRING} [L]\n";
        $rssBuildValue .= "\n";
        $rssBuildValue .= "# 日記詳細\n";
        $rssBuildValue .= "RewriteRule   ^blog-([0-9]+)/([a-z]{1}.*)$                                program/$2?cl={$_POST["cl_urlcd"]}&dd=1&drid=$1&%{QUERY_STRING} [L]\n";
        $rssBuildValue .= "RewriteRule   ^blog-([0-9]+)/$                                            program/blog.php?cl={$_POST["cl_urlcd"]}&dd=1&drid=$1&%{QUERY_STRING} [L]\n";
        $rssBuildValue .= "\n";
        $rssBuildValue .= "# キャンペーン詳細\n";
        $rssBuildValue .= "RewriteRule   ^campaign-detail-([0-9]+)/([a-z]{1}.*)$                     program/$2?cl={$_POST["cl_urlcd"]}&dd=1&cpid=$1&%{QUERY_STRING} [L]\n";
        $rssBuildValue .= "RewriteRule   ^campaign-detail-([0-9]+)/$                                 program/campaigndetail.php?cl={$_POST["cl_urlcd"]}&dd=1&cpid=$1&%{QUERY_STRING} [L]\n";
        $rssBuildValue .= "\n";
        $rssBuildValue .= "# コース詳細\n";
        $rssBuildValue .= "RewriteRule   ^course-detail-([0-9]+)/([a-z]{1}.*)$                       program/$2?cl={$_POST["cl_urlcd"]}&dd=1&csid=$1&%{QUERY_STRING} [L]\n";
        $rssBuildValue .= "RewriteRule   ^course-detail-([0-9]+)/$                                   program/coursedetail.php?cl={$_POST["cl_urlcd"]}&dd=1&csid=$1&%{QUERY_STRING} [L]\n";
        $rssBuildValue .= "\n";
        $rssBuildValue .= "# 入塾までの流れ\n";
        $rssBuildValue .= "RewriteRule   ^flow/([a-z]{1}.*)$                                         program/$1?cl={$_POST["cl_urlcd"]}&dd=1&%{QUERY_STRING} [L]\n";
        $rssBuildValue .= "RewriteRule   ^flow/$                                                     program/flow.php?cl={$_POST["cl_urlcd"]}&dd=1&%{QUERY_STRING} [L]\n";
        $rssBuildValue .= "\n";
        $rssBuildValue .= "# キャンペーンお申し込みフォーム\n";
        $rssBuildValue .= "RewriteRule   ^campaign-apply/([a-z]{1}.*)$                               program/$1?cl={$_POST["cl_urlcd"]}&dd=1&%{QUERY_STRING} [L]\n";
        $rssBuildValue .= "RewriteRule   ^campaign-apply/$                                           program/campaignapply.php?cl={$_POST["cl_urlcd"]}&dd=1&%{QUERY_STRING} [L]\n";
        $rssBuildValue .= "\n";
        $rssBuildValue .= "# キャンペーンお申し込み確認ページ\n";
        $rssBuildValue .= "RewriteRule   ^campaign-apply-confirm/([a-z]{1}.*)$                       program/$1?cl={$_POST["cl_urlcd"]}&dd=1&%{QUERY_STRING} [L]\n";
        $rssBuildValue .= "RewriteRule   ^campaign-apply-confirm/$                                   program/campaignapplyconfirm.php?cl={$_POST["cl_urlcd"]}&dd=1&%{QUERY_STRING} [L]\n";
        $rssBuildValue .= "\n";
        $rssBuildValue .= "# キャンペーンお問い合わせフォーム\n";
        $rssBuildValue .= "RewriteRule   ^campaign-inq/([a-z]{1}.*)$                                 program/$1?cl={$_POST["cl_urlcd"]}&dd=1&%{QUERY_STRING} [L]\n";
        $rssBuildValue .= "RewriteRule   ^campaign-inq/$                                             program/campaigninq.php?cl={$_POST["cl_urlcd"]}&dd=1&%{QUERY_STRING} [L]\n";
        $rssBuildValue .= "\n";
        $rssBuildValue .= "# キャンペーンお問い合わせ確認ページ\n";
        $rssBuildValue .= "RewriteRule   ^campaign-inq-confirm/([a-z]{1}.*)$                         program/$1?cl={$_POST["cl_urlcd"]}&dd=1&%{QUERY_STRING} [L]\n";
        $rssBuildValue .= "RewriteRule   ^campaign-inq-confirm/$                                     program/campconfirm.php?cl={$_POST["cl_urlcd"]}&dd=1&%{QUERY_STRING} [L]\n";
        $rssBuildValue .= "\n";
        $rssBuildValue .= "# コースお問い合わせフォーム\n";
        $rssBuildValue .= "RewriteRule   ^course-inq/([a-z]{1}.*)$                                   program/$1?cl={$_POST["cl_urlcd"]}&dd=1&%{QUERY_STRING} [L]\n";
        $rssBuildValue .= "RewriteRule   ^course-inq/$                                               program/courseinq.php?cl={$_POST["cl_urlcd"]}&dd=1&%{QUERY_STRING} [L]\n";
        $rssBuildValue .= "\n";
        $rssBuildValue .= "# コースお問い合わせ確認ページ\n";
        $rssBuildValue .= "RewriteRule   ^course-inq-confirm/([a-z]{1}.*)$                           program/$1?cl={$_POST["cl_urlcd"]}&dd=1&%{QUERY_STRING} [L]\n";
        $rssBuildValue .= "RewriteRule   ^course-inq-confirm/$                                       program/courseinqconfirm.php?cl={$_POST["cl_urlcd"]}&dd=1&%{QUERY_STRING} [L]\n";
        $rssBuildValue .= "\n";
        $rssBuildValue .= "# コース資料請求フォーム\n";
        $rssBuildValue .= "RewriteRule   ^course-req/([a-z]{1}.*)$                                   program/$1?cl={$_POST["cl_urlcd"]}&dd=1&%{QUERY_STRING} [L]\n";
        $rssBuildValue .= "RewriteRule   ^course-req/$                                               program/coursereq.php?cl={$_POST["cl_urlcd"]}&dd=1&%{QUERY_STRING} [L]\n";
        $rssBuildValue .= "\n";
        $rssBuildValue .= "# コース資料請求確認ページ\n";
        $rssBuildValue .= "RewriteRule   ^course-req-confirm/([a-z]{1}.*)$                           program/$1?cl={$_POST["cl_urlcd"]}&dd=1&%{QUERY_STRING} [L]\n";
        $rssBuildValue .= "RewriteRule   ^course-req-confirm/$                                       program/coursereqconfirm.php?cl={$_POST["cl_urlcd"]}&dd=1&%{QUERY_STRING} [L]\n";
        $rssBuildValue .= "\n";
        $rssBuildValue .= "# 資料請求フォーム\n";
        $rssBuildValue .= "RewriteRule   ^req/([a-z]{1}.*)$                                          program/$1?cl={$_POST["cl_urlcd"]}&dd=1&%{QUERY_STRING} [L]\n";
        $rssBuildValue .= "RewriteRule   ^req/$                                                      program/req.php?cl={$_POST["cl_urlcd"]}&dd=1&%{QUERY_STRING} [L]\n";
        $rssBuildValue .= "\n";
        $rssBuildValue .= "# 資料請求確認ページ\n";
        $rssBuildValue .= "RewriteRule   ^req-confirm/([a-z]{1}.*)$                                  program/$1?cl={$_POST["cl_urlcd"]}&dd=1&%{QUERY_STRING} [L]\n";
        $rssBuildValue .= "RewriteRule   ^req-confirm/$                                              program/reqconfirm.php?cl={$_POST["cl_urlcd"]}&dd=1&%{QUERY_STRING} [L]\n";
        $rssBuildValue .= "\n";
        $rssBuildValue .= "# お問い合わせフォーム\n";
        $rssBuildValue .= "RewriteRule   ^inquire/([a-z]{1}.*)$                                      program/$1?cl={$_POST["cl_urlcd"]}&dd=1&%{QUERY_STRING} [L]\n";
        $rssBuildValue .= "RewriteRule   ^inquire/$                                                  program/inquire.php?cl={$_POST["cl_urlcd"]}&dd=1&%{QUERY_STRING} [L]\n";
        $rssBuildValue .= "\n";
        $rssBuildValue .= "# お問い合わせ確認ページ\n";
        $rssBuildValue .= "RewriteRule   ^inq-confirm/([a-z]{1}.*)$                                  program/$1?cl={$_POST["cl_urlcd"]}&dd=1&%{QUERY_STRING} [L]\n";
        $rssBuildValue .= "RewriteRule   ^inq-confirm/$                                              program/inqconfirm.php?cl={$_POST["cl_urlcd"]}&dd=1&%{QUERY_STRING} [L]\n";
        $rssBuildValue .= "\n";
        $rssBuildValue .= "# 各種サンキューページ\n";
        $rssBuildValue .= "RewriteRule   ^complete/([a-z]{1}.*)$                                     program/$1?cl={$_POST["cl_urlcd"]}&dd=1&%{QUERY_STRING} [L]\n";
        $rssBuildValue .= "RewriteRule   ^complete/$                                                 program/complete.php?cl={$_POST["cl_urlcd"]}&dd=1&%{QUERY_STRING} [L]\n";
        $rssBuildValue .= "\n";
        $rssBuildValue .= "# 教室案内\n";
        $rssBuildValue .= "RewriteRule   ^school/([a-z]{1}.*)$                                       program/$1?cl={$_POST["cl_urlcd"]}&dd=1&%{QUERY_STRING} [L]\n";
        $rssBuildValue .= "RewriteRule   ^school/$                                                   program/school.php?cl={$_POST["cl_urlcd"]}&dd=1&%{QUERY_STRING} [L]\n";
        $rssBuildValue .= "\n";
        $rssBuildValue .= "# コース一覧\n";
        $rssBuildValue .= "RewriteRule   ^course-list/p-([0-9]+)/cs-([0-9]+)/([a-z]{1}.*)$           program/$3?cl={$_POST["cl_urlcd"]}&dd=1&page=$1&csid=$2&%{QUERY_STRING} [L]\n";
        $rssBuildValue .= "RewriteRule   ^course-list/p-([0-9]+)/cs-([0-9]+)/$                       program/courselist.php?cl={$_POST["cl_urlcd"]}&dd=1&page=$1&csid=$2&%{QUERY_STRING} [L]\n";
        $rssBuildValue .= "\n";
        $rssBuildValue .= "# キャンペーン一覧\n";
        $rssBuildValue .= "RewriteRule   ^campain-list/p-([0-9]+)/cp-([0-9]+)/([a-z]{1}.*)$          program/$3?cl={$_POST["cl_urlcd"]}&dd=1&page=$1&cpid=$2&%{QUERY_STRING} [L]\n";
        $rssBuildValue .= "RewriteRule   ^campain-list/p-([0-9]+)/cp-([0-9]+)/$                      program/campaignlist.php?cl={$_POST["cl_urlcd"]}&dd=1&page=$1&cpid=$2&%{QUERY_STRING} [L]\n";
        $rssBuildValue .= "\n";
        $rssBuildValue .= "# 日記一覧\n";
        $rssBuildValue .= "RewriteRule   ^diary-list/p-([0-9]+)/dr-([0-9]+)/([a-z]{1}.*)$            program/$3?cl={$_POST["cl_urlcd"]}&dd=1&page=$1&drid=$2&%{QUERY_STRING} [L]\n";
        $rssBuildValue .= "RewriteRule   ^diary-list/p-([0-9]+)/dr-([0-9]+)/$                        program/bloglist.php?cl={$_POST["cl_urlcd"]}&dd=1&page=$1&drid=$2&%{QUERY_STRING} [L]\n";
        $rssBuildValue .= "\n";
        $rssBuildValue .= "# 個人情報保護方針\n";
        $rssBuildValue .= "RewriteRule   ^kojin/([a-z]{1}.*)$                                        program/$1?cl={$_POST["cl_urlcd"]}&dd=1&%{QUERY_STRING} [L]\n";
        $rssBuildValue .= "RewriteRule   ^kojin/$                                                    program/privacy.php?cl={$_POST["cl_urlcd"]}&dd=1&%{QUERY_STRING} [L]\n";
        $rssBuildValue .= "\n";
        $rssBuildValue .= "# Q&A\n";
        $rssBuildValue .= "RewriteRule   ^qa/([a-z]{1}.*)$                                           program/$1?cl={$_POST["cl_urlcd"]}&dd=1&%{QUERY_STRING} [L]\n";
        $rssBuildValue .= "RewriteRule   ^qa/$                                                       program/QA.php?cl={$_POST["cl_urlcd"]}&dd=1&%{QUERY_STRING} [L]\n";
        $rssBuildValue .= "\n";
        $rssBuildValue .= "# index\n";
        $rssBuildValue .= "RewriteRule   ^img_thumbnail.php$                                         program/img_thumbnail.php?cl={$_POST["cl_urlcd"]}&dd=1&%{QUERY_STRING} [L]\n";
        $rssBuildValue .= "RewriteRule   ^cl_img/(.*)$                                               program/cl_img/$1?cl={$_POST["cl_urlcd"]}&dd=1&%{QUERY_STRING} [L]\n";
        $rssBuildValue .= "RewriteRule   ^share/(.*)$                                                program/share/$1?cl={$_POST["cl_urlcd"]}&dd=1&%{QUERY_STRING} [L]\n";
        $rssBuildValue .= "RewriteRule   ^$                                                          program/index.php?cl={$_POST["cl_urlcd"]}&dd=1 [L]\n";
        $rssBuildValue .= "\n";
        $rssBuildValue .= "# フリーページ\n";
        $rssBuildValue .= "RewriteRule   ^free-([0-9]+)/([a-z]{1}.*)$                                program/$2?cl={$_POST["cl_urlcd"]}&dd=1&drid=$1&%{QUERY_STRING} [L]\n";
        $rssBuildValue .= "RewriteRule   ^free-([0-9]+)/$                                            program/free.php?cl={$_POST["cl_urlcd"]}&dd=1&drid=$1&%{QUERY_STRING} [L]\n";
        $rssBuildValue .= "\n";

        fputs($buildRssTmp,$rssBuildValue);
        flock($buildRssTmp,LOCK_UN);
        fclose($buildRssTmp);

        // 独自ドメイン用シンボリックリンク生成
        @symlink( $param_dokuji_path."source/program" , $param_dokuji_path.$_POST["cl_urlcd"]."/program" );
    }







    //20091021追加///////////////////////////////////////////////////////////////////////////////////////////
    //携帯独自ドメイン用ファイルの作成
    /////////////////////////////////////////////////////////////////////////////////////////////////////////

    if (!file_exists($param_mobile_dokuji_path.$_POST["cl_urlcd"])) {	// 携帯独自ドメイン用ディレクトリがまだ存在しない場合のみ作成
        // 携帯独自ドメイン用ディレクトリ生成
        @mkdir( $param_mobile_dokuji_path.$_POST["cl_urlcd"] , 0755);

        // 携帯独自ドメイン用.htaccessファイル生成
        $mobile_htaccess_fp = fopen($param_mobile_dokuji_path.$_POST["cl_urlcd"]."/.htaccess","w");
        if($mobile_htaccess_fp===flase)exit("ファイルオープン失敗");
        flock($mobile_htaccess_fp,LOCK_EX);
        $mobile_htaccess_str = "#############################################################\n";
        $mobile_htaccess_str .= "\n";
        $mobile_htaccess_str .= "# php setting - site_data\n";
        $mobile_htaccess_str .= "\n";
        $mobile_htaccess_str .= "#############################################################\n";
        $mobile_htaccess_str .= "\n";
        $mobile_htaccess_str .= "\n";
        $mobile_htaccess_str .= "# base setting\n";
        $mobile_htaccess_str .= "\n";
        $mobile_htaccess_str .= "php_flag register_globals off\n";
        $mobile_htaccess_str .= "php_flag magic_quotes_gpc on\n";
        $mobile_htaccess_str .= "php_flag display_errors on\n";
        $mobile_htaccess_str .= "php_flag magic_quotes_sybase off\n";
        $mobile_htaccess_str .= "\n";
        $mobile_htaccess_str .= "\n";
        $mobile_htaccess_str .= "# mbstring setting\n";
        $mobile_htaccess_str .= "\n";
        $mobile_htaccess_str .= "php_value mbstring.language Japanese\n";
        $mobile_htaccess_str .= "php_value mbstring.internal_encoding EUC-JP\n";
        $mobile_htaccess_str .= "php_value mbstring.http_input pass\n";
        $mobile_htaccess_str .= "php_flag  mbstring.encoding_translation on\n";
        $mobile_htaccess_str .= "php_value mbstring.substitute_character none\n";
        $mobile_htaccess_str .= "php_value mbstring.detect_order ASCII,EUC-JP,JIS,UTF-8,SJIS\n";
        $mobile_htaccess_str .= "php_value mbstring.func_overload 0\n";
        $mobile_htaccess_str .= "\n";
        $mobile_htaccess_str .= "\n";
        $mobile_htaccess_str .= "# session setting\n";
        $mobile_htaccess_str .= "\n";
        $mobile_htaccess_str .= "php_value session.name \"edyblo_mobile_blog_site_sess\"\n";
        $mobile_htaccess_str .= "php_flag  session.use_only_cookies on\n";
        $mobile_htaccess_str .= "php_value session.cache_limiter \"nocache\"\n";
        $mobile_htaccess_str .= "\n";
        $mobile_htaccess_str .= "\n";
        $mobile_htaccess_str .= "#############################################################\n";
        $mobile_htaccess_str .= "\n";
        $mobile_htaccess_str .= "# basic setting\n";
        $mobile_htaccess_str .= "\n";
        $mobile_htaccess_str .= "#############################################################\n";
        $mobile_htaccess_str .= "#AuthUserFile /home/jukutown.com/www/.htpasswd\n";
        $mobile_htaccess_str .= "#AuthGroupFile /dev/null\n";
        $mobile_htaccess_str .= "#AuthName \"Slash Area\"\n";
        $mobile_htaccess_str .= "#AuthType Basic\n";
        $mobile_htaccess_str .= "\n";
        $mobile_htaccess_str .= "#require valid-user\n";
        $mobile_htaccess_str .= "\n";
        $mobile_htaccess_str .= "#<Files ~ \"^.(htpasswd|htaccess)$\">\n";
        $mobile_htaccess_str .= "#    deny from all\n";
        $mobile_htaccess_str .= "#</Files> \n";
        $mobile_htaccess_str .= "\n";
        $mobile_htaccess_str .= "\n";
        $mobile_htaccess_str .= "############################################################\n";
        $mobile_htaccess_str .= "\n";
        $mobile_htaccess_str .= "# re-direct\n";
        $mobile_htaccess_str .= "\n";
        $mobile_htaccess_str .= "###########################################################\n";
        $mobile_htaccess_str .= "\n";
        $mobile_htaccess_str .= "#redirect permanent /dev/slash/estate/www/slash/ http://219.163.62.35/dev/slash/estate/www/click/ \n";
        $mobile_htaccess_str .= "\n";
        $mobile_htaccess_str .= "\n";
        $mobile_htaccess_str .= "\n";
        $mobile_htaccess_str .= "#############################################################\n";
        $mobile_htaccess_str .= "\n";
        $mobile_htaccess_str .= "# mod_rewrite setting - site_data\n";
        $mobile_htaccess_str .= "\n";
        $mobile_htaccess_str .= "#############################################################\n";
        $mobile_htaccess_str .= "\n";
        $mobile_htaccess_str .= "RewriteEngine On\n";
        $mobile_htaccess_str .= "RewriteBase   /\n";
        $mobile_htaccess_str .= "RewriteCond   %{REQUEST_FILENAME} !-f\n";
        $mobile_htaccess_str .= "RewriteCond   %{REQUEST_FILENAME} !-d\n";
        $mobile_htaccess_str .= "\n";
        $mobile_htaccess_str .= "\n";
        $mobile_htaccess_str .= "#####################################################################################################################\n";
        $mobile_htaccess_str .= "\n";
        $mobile_htaccess_str .= "# blog setting\n";
        $mobile_htaccess_str .= "\n";

        //			$mobile_htaccess_str .= "# 日記詳細1\n";
        //			$mobile_htaccess_str .= "RewriteRule   ^blog-([0-9]+)/([a-z]{1}.*)$                          program/$2?cl={$_POST["cl_urlcd"]}&dd=1&drid=$1 [QSA,L]\n";
        //			$mobile_htaccess_str .= "RewriteRule   ^blog-([0-9]+)/$                                      program/blog.php?cl={$_POST["cl_urlcd"]}&dd=1&drid=$1 [QSA,L]\n";
        //			$mobile_htaccess_str .= "\n";

        $mobile_htaccess_str .= "# 日記詳細1\n";
        $mobile_htaccess_str .= "RewriteRule   ^blog-([0-9]+)/$                                      program/blog.php?cl={$_POST["cl_urlcd"]}&dd=1&drid=$1 [QSA,L]\n";
        $mobile_htaccess_str .= "RewriteRule   ^blog-([0-9]+)/img([0-9]+)/([a-z]{1}.*)$              program/$3?cl={$_POST["cl_urlcd"]}&dd=1&drid=$1&img=$2 [QSA,L]\n";
        $mobile_htaccess_str .= "RewriteRule   ^blog-([0-9]+)/img([0-9]+)/$                          program/blog.php?cl={$_POST["cl_urlcd"]}&dd=1&drid=$1&img=$2 [QSA,L]\n";
        $mobile_htaccess_str .= "\n";

        $mobile_htaccess_str .= "# 日記詳細2\n";
        $mobile_htaccess_str .= "RewriteRule   ^blogd-([0-9]+)/([a-z]{1}.*)$                         program/$2?cl={$_POST["cl_urlcd"]}&dd=1&drid=$1 [QSA,L]\n";
        $mobile_htaccess_str .= "RewriteRule   ^blogd-([0-9]+)/$                                     program/blog_detail.php?cl={$_POST["cl_urlcd"]}&dd=1&drid=$1 [QSA,L]\n";
        $mobile_htaccess_str .= "\n";
        $mobile_htaccess_str .= "# 日記詳細3(画像)\n";
        $mobile_htaccess_str .= "RewriteRule   ^blog-img([0-9]+)/([a-z]{1}.*)$                       program/$2?cl={$_POST["cl_urlcd"]}&dd=1&drid=$1 [QSA,L]\n";
        $mobile_htaccess_str .= "RewriteRule   ^blog-img([0-9]+)/$                                   program/blog_img.php?cl={$_POST["cl_urlcd"]}&dd=1&drid=$1 [QSA,L]\n";
        $mobile_htaccess_str .= "\n";
        $mobile_htaccess_str .= "# キャンペーン詳細1\n";
        $mobile_htaccess_str .= "RewriteRule   ^campaign-detail-([0-9]+)/([a-z]{1}.*)$               program/$2?cl={$_POST["cl_urlcd"]}&dd=1&cpid=$1 [QSA,L]\n";
        $mobile_htaccess_str .= "RewriteRule   ^campaign-detail-([0-9]+)/$                           program/campaigndetail.php?cl={$_POST["cl_urlcd"]}&dd=1&cpid=$1 [QSA,L]\n";
        $mobile_htaccess_str .= "\n";
        $mobile_htaccess_str .= "# キャンペーン詳細2\n";
        $mobile_htaccess_str .= "RewriteRule   ^campaign-detaild-([0-9]+)/([a-z]{1}.*)$              program/$2?cl={$_POST["cl_urlcd"]}&dd=1&caid=$1 [QSA,L]\n";
        $mobile_htaccess_str .= "RewriteRule   ^campaign-detaild-([0-9]+)/$                          program/campaigndetaild.php?cl={$_POST["cl_urlcd"]}&dd=1&caid=$1 [QSA,L]\n";
        $mobile_htaccess_str .= "\n";
        $mobile_htaccess_str .= "# 資料請求フォーム\n";
        $mobile_htaccess_str .= "RewriteRule   ^req/([a-z]{1}.*)$                                    program/$1?cl={$_POST["cl_urlcd"]}&dd=1 [QSA,L]\n";
        $mobile_htaccess_str .= "RewriteRule   ^req/$                                                program/req.php?cl={$_POST["cl_urlcd"]}&dd=1 [QSA,L]\n";
        $mobile_htaccess_str .= "\n";
        $mobile_htaccess_str .= "# 資料請求確認ページ\n";
        $mobile_htaccess_str .= "RewriteRule   ^req-confirm/([a-z]{1}.*)$                            program/$1?cl={$_POST["cl_urlcd"]}&dd=1 [QSA,L]\n";
        $mobile_htaccess_str .= "RewriteRule   ^req-confirm/$                                        program/reqconfirm.php?cl={$_POST["cl_urlcd"]}&dd=1 [QSA,L]\n";
        $mobile_htaccess_str .= "\n";
        $mobile_htaccess_str .= "# お問い合わせフォーム\n";
        $mobile_htaccess_str .= "RewriteRule   ^inquire/([a-z]{1}.*)$                                program/$1?cl={$_POST["cl_urlcd"]}&dd=1 [QSA,L]\n";
        $mobile_htaccess_str .= "RewriteRule   ^inquire/$                                            program/inquire.php?cl={$_POST["cl_urlcd"]}&dd=1 [QSA,L]\n";
        $mobile_htaccess_str .= "\n";
        $mobile_htaccess_str .= "# お問い合わせ確認ページ\n";
        $mobile_htaccess_str .= "RewriteRule   ^inq-confirm/([a-z]{1}.*)$                            program/$1?cl={$_POST["cl_urlcd"]}&dd=1 [QSA,L]\n";
        $mobile_htaccess_str .= "RewriteRule   ^inq-confirm/$                                        program/inqconfirm.php?cl={$_POST["cl_urlcd"]}&dd=1 [QSA,L]\n";
        $mobile_htaccess_str .= "\n";
        $mobile_htaccess_str .= "# 資料請求メール送信ページ\n";
        $mobile_htaccess_str .= "RewriteRule   ^req_finish/([a-z]{1}.*)$                             program/$1?cl={$_POST["cl_urlcd"]}&dd=1 [QSA,L]\n";
        $mobile_htaccess_str .= "RewriteRule   ^req_finish/$                                         program/req_finish.php?cl={$_POST["cl_urlcd"]}&dd=1 [QSA,L]\n";
        $mobile_htaccess_str .= "\n";
        $mobile_htaccess_str .= "# お問い合わせメール送信ページ\n";
        $mobile_htaccess_str .= "RewriteRule   ^inq_finish/([a-z]{1}.*)$                             program/$1?cl={$_POST["cl_urlcd"]}&dd=1 [QSA,L]\n";
        $mobile_htaccess_str .= "RewriteRule   ^inq_finish/$                                         program/inq_finish.php?cl={$_POST["cl_urlcd"]}&dd=1 [QSA,L]\n";
        $mobile_htaccess_str .= "\n";
        $mobile_htaccess_str .= "# 資料請求サンキューページ\n";
        $mobile_htaccess_str .= "RewriteRule   ^req_end/([a-z]{1}.*)$                                program/$1?cl={$_POST["cl_urlcd"]}&dd=1 [QSA,L]\n";
        $mobile_htaccess_str .= "RewriteRule   ^req_end/$                                            program/req_end.php?cl={$_POST["cl_urlcd"]}&dd=1 [QSA,L]\n";
        $mobile_htaccess_str .= "\n";
        $mobile_htaccess_str .= "# お問い合わせサンキューページ\n";
        $mobile_htaccess_str .= "RewriteRule   ^inq_end/([a-z]{1}.*)$                                program/$1?cl={$_POST["cl_urlcd"]}&dd=1 [QSA,L]\n";
        $mobile_htaccess_str .= "RewriteRule   ^inq_end/$                                            program/inq_end.php?cl={$_POST["cl_urlcd"]}&dd=1 [QSA,L]\n";
        $mobile_htaccess_str .= "\n";
        $mobile_htaccess_str .= "# 教室案内\n";
        $mobile_htaccess_str .= "RewriteRule   ^school/([a-z]{1}.*)$                                 program/$1?cl={$_POST["cl_urlcd"]}&dd=1 [QSA,L]\n";
        $mobile_htaccess_str .= "RewriteRule   ^school/$                                             program/school.php?cl={$_POST["cl_urlcd"]}&dd=1 [QSA,L]\n";
        $mobile_htaccess_str .= "\n";
        $mobile_htaccess_str .= "# 教室案内(教室詳細1)\n";
        $mobile_htaccess_str .= "RewriteRule   ^school_detail/([a-z]{1}.*)$                          program/$1?cl={$_POST["cl_urlcd"]}&dd=1 [QSA,L]\n";
        $mobile_htaccess_str .= "RewriteRule   ^school_detail/$                                      program/school_detail.php?cl={$_POST["cl_urlcd"]}&dd=1 [QSA,L]\n";
        $mobile_htaccess_str .= "\n";

        //			$mobile_htaccess_str .= "# 教室案内(教室詳細2)\n";
        //			$mobile_htaccess_str .= "RewriteRule   ^school_detaild/([a-z]{1}.*)$                         program/$1?cl={$_POST["cl_urlcd"]}&dd=1 [QSA,L]\n";
        //			$mobile_htaccess_str .= "RewriteRule   ^school_detaild/$                                     program/school_detaild.php?cl={$_POST["cl_urlcd"]}&dd=1 [QSA,L]\n";
        //			$mobile_htaccess_str .= "\n";

        $mobile_htaccess_str .= "# 教室案内(教室詳細2)\n";
        $mobile_htaccess_str .= "RewriteRule   ^school_detaild/p([0-9]+)/([a-z]{1}.*)$               program/$2?cl={$_POST["cl_urlcd"]}&dd=1&get=$1 [QSA,L]\n";
        $mobile_htaccess_str .= "RewriteRule   ^school_detaild/p([0-9]+)/$                           program/school_detaild.php?cl={$_POST["cl_urlcd"]}&dd=1&get=$1 [QSA,L]\n";
        $mobile_htaccess_str .= "\n";

        $mobile_htaccess_str .= "# 教室案内(MAP表示)\n";
        $mobile_htaccess_str .= "RewriteRule   ^school_map/([a-z]{1}.*)$                             program/$1?cl={$_POST["cl_urlcd"]}&dd=1 [QSA,L]\n";
        $mobile_htaccess_str .= "RewriteRule   ^school_map/$                                         program/school_map.php?cl={$_POST["cl_urlcd"]}&dd=1 [QSA,L]\n";
        $mobile_htaccess_str .= "\n";
        $mobile_htaccess_str .= "# キャンペーン一覧\n";
        $mobile_htaccess_str .= "RewriteRule   ^campain-list/p-([0-9]+)/cp-([0-9]+)/([a-z]{1}.*)$    program/$3?cl={$_POST["cl_urlcd"]}&dd=1&page=$1&cpid=$2 [QSA,L]\n";
        $mobile_htaccess_str .= "RewriteRule   ^campain-list/p-([0-9]+)/cp-([0-9]+)/$                program/campaignlist.php?cl={$_POST["cl_urlcd"]}&dd=1&page=$1&cpid=$2 [QSA,L]\n";
        $mobile_htaccess_str .= "\n";
        $mobile_htaccess_str .= "# 日記一覧\n";
        $mobile_htaccess_str .= "RewriteRule   ^diary-list/p-([0-9]+)/dr-([0-9]+)/([a-z]{1}.*)$      program/$3?cl={$_POST["cl_urlcd"]}&dd=1&page=$1&drid=$2 [QSA,L]\n";
        $mobile_htaccess_str .= "RewriteRule   ^diary-list/p-([0-9]+)/dr-([0-9]+)/$                  program/bloglist.php?cl={$_POST["cl_urlcd"]}&dd=1&page=$1&drid=$2 [QSA,L]\n";
        $mobile_htaccess_str .= "\n";
        $mobile_htaccess_str .= "# 個人情報保護方針\n";
        $mobile_htaccess_str .= "RewriteRule   ^kojin/([a-z]{1}.*)$                                  program/$1?cl={$_POST["cl_urlcd"]}&dd=1 [QSA,L]\n";
        $mobile_htaccess_str .= "RewriteRule   ^kojin/$                                              program/privacy.php?cl={$_POST["cl_urlcd"]}&dd=1 [QSA,L]\n";
        $mobile_htaccess_str .= "\n";
        $mobile_htaccess_str .= "# Q&A\n";
        $mobile_htaccess_str .= "RewriteRule   ^qa/([a-z]{1}.*)$                                     program/$1?cl={$_POST["cl_urlcd"]}&dd=1 [QSA,L]\n";
        $mobile_htaccess_str .= "RewriteRule   ^qa/$                                                 program/QA.php?cl={$_POST["cl_urlcd"]}&dd=1 [QSA,L]\n";
        $mobile_htaccess_str .= "\n";
        $mobile_htaccess_str .= "# index\n";
        $mobile_htaccess_str .= "RewriteRule   ^img_thumbnail.php$                                   program/img_thumbnail.php?cl={$_POST["cl_urlcd"]}&dd=1 [QSA,L]\n";
        $mobile_htaccess_str .= "RewriteRule   ^cl_img/(.*)$                                         program/cl_img/$1?cl={$_POST["cl_urlcd"]}&dd=1 [QSA,L]\n";
        $mobile_htaccess_str .= "RewriteRule   ^share/(.*)$                                          program/share/$1?cl={$_POST["cl_urlcd"]}&dd=1 [QSA,L]\n";
        $mobile_htaccess_str .= "RewriteRule   ^$                                                    program/index.php?cl={$_POST["cl_urlcd"]}&dd=1 [QSA,L]\n";
        $mobile_htaccess_str .= "\n";
        $mobile_htaccess_str .= "# フリーページ\n";
        $mobile_htaccess_str .= "RewriteRule   ^free-([0-9]+)/([a-z]{1}.*)$                                program/$2?cl={$_POST["cl_urlcd"]}&dd=1&drid=$1&%{QUERY_STRING} [L]\n";
        $mobile_htaccess_str .= "RewriteRule   ^free-([0-9]+)/$                                            program/free.php?cl={$_POST["cl_urlcd"]}&dd=1&drid=$1&%{QUERY_STRING} [L]\n";
        $mobile_htaccess_str .= "\n";

        fputs($mobile_htaccess_fp,$mobile_htaccess_str);
        flock($mobile_htaccess_fp,LOCK_UN);
        fclose($mobile_htaccess_fp);

        // 携帯独自ドメイン用シンボリックリンク生成
        @symlink( $param_mobile_dokuji_path."source/program" , $param_mobile_dokuji_path.$_POST["cl_urlcd"]."/program" );
    }

    break;


    case 'DEL':
        $_POST['stpos']="";
        $obj_del = new basedb_ClientClassTblAccess;
        $obj_del->conn = $obj_conn->conn;
        $obj_del->clientdat[0]["cl_id"] = $_POST["cl_id"];
        $obj_del->clientdat[0]["cl_upddate"] = $_POST["cl_upddate"];
        $suc = $obj_del->basedb_DelClient(0);
        if( $suc != 0 ){
            $arrErr["ath_comment"] = $strErrHidden;
            $obj_error->ViewErrMessage( "SYSTEM" , "ALL" , "client_mnt.php" , $arrErr );
            exit;
        }
        $message = "指定されたクライアント情報を削除しました。";
        break;

}


/*----------------------------------------------------------
  ＤＢ切断
----------------------------------------------------------*/
require_once( SYS_PATH."common/db_close.php" );


/*----------------------------------------------------------
  ＨＴＭＬ生成
----------------------------------------------------------*/
?>
<HTML>
  <HEAD>
    <TITLE>塾ブログ - アカウント管理ツール</title>
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
      <form name="form1" action="client_main.php" method="POST"> 
        <INPUT type="hidden" name="stpos" value="<?=$arrPostView['stpos']?>" />
        <INPUT type="hidden" name="sea_cl_name_like" value="<?=$arrPostView['sea_cl_name_like']?>" />
        <INPUT type="hidden" name="sea_cl_pref" value="<?=$arrPostView['sea_cl_pref']?>" />
        <INPUT type="hidden" name="sea_cl_stat" value="<?=$arrPostView['sea_cl_stat']?>" />
        <INPUT type="hidden" name="sea_cl_dokuji_flg" value="<?=$arrPostView['sea_cl_dokuji_flg']?>" />
        <INPUT type="hidden" name="sea_cl_advertisement_flg" value="<?=$arrPostView['sea_cl_advertisement_flg']?>" />
        <INPUT type="hidden" name="sea_cl_start_date_s_y" value="<?=$arrPostView['sea_cl_start_date_s_y']?>" />
        <INPUT type="hidden" name="sea_cl_start_date_s_m" value="<?=$arrPostView['sea_cl_start_date_s_m']?>" />
        <INPUT type="hidden" name="sea_cl_start_date_s_d" value="<?=$arrPostView['sea_cl_start_date_s_d']?>" />
        <INPUT type="hidden" name="sea_cl_start_date_e_y" value="<?=$arrPostView['sea_cl_start_date_e_y']?>" />
        <INPUT type="hidden" name="sea_cl_start_date_e_m" value="<?=$arrPostView['sea_cl_start_date_e_m']?>" />
        <INPUT type="hidden" name="sea_cl_start_date_e_d" value="<?=$arrPostView['sea_cl_start_date_e_d']?>" />
        <INPUT type="hidden" name="sea_cl_limit_date_s_y" value="<?=$arrPostView['sea_cl_limit_date_s_y']?>" />
        <INPUT type="hidden" name="sea_cl_limit_date_s_m" value="<?=$arrPostView['sea_cl_limit_date_s_m']?>" />
        <INPUT type="hidden" name="sea_cl_limit_date_s_d" value="<?=$arrPostView['sea_cl_limit_date_s_d']?>" />
        <INPUT type="hidden" name="sea_cl_limit_date_e_y" value="<?=$arrPostView['sea_cl_limit_date_e_y']?>" />
        <INPUT type="hidden" name="sea_cl_limit_date_e_m" value="<?=$arrPostView['sea_cl_limit_date_e_m']?>" />
        <INPUT type="hidden" name="sea_cl_limit_date_e_d" value="<?=$arrPostView['sea_cl_limit_date_e_d']?>" />
    <INPUT type="hidden" name="search_flg" value="<?=$arrPostView['search_flg']?>" />
        <input type="submit" value=" 戻 る " class="btn" />
      </form>
    </div>
  </body>
</html>
