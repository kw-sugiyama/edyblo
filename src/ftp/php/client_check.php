<?php
/**************************************************************************

	クライアント情報チェック
		＆
	レイアウト指定チェック
		＆
	アドレスベース設定

**************************************************************************/


// $_GET["cl"] の値が設定されていなければエラー

IF( $_GET["cl"] == "" ){
	$obj_error->ViewErrMessage( "MENT" , "USER-ALL" , "#" , NULL );
	echo "error";
	exit;
}

/*
//メンテナンス処理
if( $_GET['dd'] == 1 ){
	header("HTTP/1.1 503 Service Temporarily Unavailable");
	header("Location: ".$param_base_blog_addr_url."/".$_GET["cl"]."/");
}
//*/

// 本日の日付を取得する
$today = date("Y-m-d");

// 検索設定／処理
$obj_login = new viewdb_ClientClassTblAccess;
$obj_login->conn = $obj_conn->conn;
$obj_login->jyoken["cl_urlcd"] = $_GET['cl'];	// URL用コードが$_GET["cl"]のもの
$obj_login->jyoken["cl_stat"] = 1;			// クライアントが"有効"
$obj_login->jyoken["cl_deldate"] = 1;			// クライアント情報が削除されていない
$obj_login->jyoken["cl_start"] = $today;		// アカウント開始が本日より前 or 無期限
$obj_login->jyoken["cl_end"] = $today;		// アカウント終了が本日より後 or 無期限
$obj_login->jyoken["sc_stat"] = 1;			// ブログ基本情報が設定されている



list( $intCnt_login , $intTotal_login ) = $obj_login->viewdb_GetClient ( 1 , -1 );
IF( $intCnt_login != 1 ){
	$obj_error->ViewErrMessage( "MENT" , "USER-ALL" , "#" , NULL );
	exit;
}

// クライアントの有効期限が設定に外れていたらエラー
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

// クライアント情報 or ブログ基本情報 が削除されていたらエラー
if( $obj_login->clientdat[0]["cl_deldate"] != "" || $obj_login->clientdat[0]["sc_deldate"] != "" ){
	$obj_error->ViewErrMessage( "MENT" , "USER-ALL" , "#" , NULL );
//	echo "ok2";
	exit;
}

// "クライアントが有効でない" or "ブログ基本情報が設定されていない場合" はエラー
if( $obj_login->clientdat[0]["cl_stat"] != 1 || $obj_login->clientdat[0]["sc_stat"] != 1 ){
	$obj_error->ViewErrMessage( "MENT" , "USER-ALL" , "#" , NULL );
	echo "error";
	echo $obj_login->clientdat[0]["cl_stat"];
	echo "<br />";
//echo $obj_login->clientdat[0]["sc_stat"];
	exit;
}

// 独自フラグが不可なのに独自ドメインで接続したらエラー
if( $obj_login->clientdat[0]["cl_dokuji_flg"] != 1 && $_GET['dd']==1 ){
	$obj_error->ViewErrMessage( "MENT" , "USER-ALL" , "#" , NULL );
//	echo "ok3";
	exit;
}


// 定数に指定クライアントIDを保持
define( "_cl_id" , $obj_login->clientdat[0]["cl_id"] );


/*===================================================
    指定レイアウト確認
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
    独自ドメイン用GoogleMapApiKey差替え処理
===================================================*/
if($obj_login->clientdat[0]["cl_googlemap_key"]!="" && $obj_login->clientdat[0]["cl_dokuji_flg"]==1 && $obj_login->clientdat[0]["cl_dokuji_domain"]!="" && $_GET['dd']==1 ){
	$param_api_key = $obj_login->clientdat[0]["cl_googlemap_key"];
}


/*===================================================
    アドレス設定
===================================================*/

if($_GET['dd']!=1){
	define( "_BLOG_SITE_URL_BASE" , $param_base_blog_addr.$_GET["cl"]."/" );
}else if($_GET['dd']==1){
	define( "_BLOG_SITE_URL_BASE" , $param_base_blog_addr );
}


// 「独自フラグが可」で「独自ドメインじゃない接続」だったら
// 独自ドメインURLに飛ばす
// 例 独自ドメインオンになっている http://reblo.sp-jobnet.co.jp/sample/search-result/page-1.html にアクセスした時
//    http://tsubaki.sp-jobnet.co.jp/search-result/page-1.html にリダイレクト
if( $obj_login->clientdat[0]["cl_dokuji_flg"] == 1 && $obj_login->clientdat[0]["cl_dokuji_domain"] != "" && $_GET['dd']!=1 ){

	// 例 $_SERVER['REQUEST_URI'](指定されたURI) → /sample/search-result/page-1.html

	$arr_url = array();
	$str_url = "";
	// /sample/search-result/page-1.html をスラッシュで分解
	// $arr_url[0] → ""
	// $arr_url[1] → "sample"
	// $arr_url[2] → "search-result"
	// $arr_url[3] → "page-1.html"
	$arr_url = explode("/" , $_SERVER['REQUEST_URI']);

	// $arr_url[0]、$arr_url[1] を削除して配列を詰める
	unset($arr_url[0],$arr_url[1]);
	// $arr_urlをスラッシュで連結
	$str_url = join("/", $arr_url);
	// $str_url → search-result/page-1.html
	// 独自ドメインのURLと合体

	// http 301 Moved Permanently
	// 今度からずっとこっちを見るんだよ、みたいな意味。
	// パーマネントリー (Permanently) は「永久・永久・恒久的」
	header("HTTP/1.1 301 Moved Permanently");
	header("Location: {$obj_login->clientdat[0]["cl_dokuji_domain"]}{$str_url}");
	exit;
}

/*----------------------------------------------------------
 携帯リダイレクト処理
----------------------------------------------------------*/

/*
//20091204 コメントアウト
//携帯が有効の場合には携帯サイトにリダイレクト
if( $obj_login->clientdat[0][cl_mobile_flg] == 1 ){
	
	$agent = $_SERVER['HTTP_USER_AGENT']; 
	$linkurl='/'.$_GET["cl"].'/';
	if(preg_match("/^DoCoMo/i", $agent) || preg_match("/^(J\-PHONE|Vodafone|MOT\-[CV]|SoftBank)/i", $agent) || preg_match("/^KDDI\-/i", $agent) || preg_match("/UP\.Browser/i", $agent) ){
	  header('Location:'.$param_base_mobile_blog_addr_url.$linkurl);
	  exit;
	}
	
	//google携帯プロキシリ ダイレクトタグ
	$alternate_tag ='<link rel="alternate" media="handheld" href="'.$param_base_mobile_blog_addr_url.$linkurl.'" />';
}

*/

// ------------------------------------------------------------------
// スマフォ版への誘導画像設定
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

