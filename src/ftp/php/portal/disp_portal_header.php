<?php

/*===================================================
    アドレス設定
===================================================*/
define( "_BLOG_SITE_URL_BASE" , $param_base_blog_addr_url );


//-------------------------------------------------------------------
// <HEAD> タグ内情報
//-------------------------------------------------------------------
$arrMetaHeader = Array();

// <TITLE> タグ部分 - ブログタイトル
$arrMetaHeader["title"] = $arrHeaderView["blog_title"];

// <TITLE> タグ部分 - 会社名
$arrMetaHeader["title_corp"] = $arrHeaderView["cl_name"].$arrHeaderView["cl_shiten"];

// HTMLキーワード
$arrMetaHeader["keyword"] = str_replace( "-" , "," , $arrHeaderView["blog_keyword"] );

// サイト説明文
$arrMetaHeader["description"] = str_replace( "\n" , "" , str_replace( "\r" , "\n" , $arrHeaderView["blog_discription"] ) );



//-------------------------------------------------------------------
// 画面上部情報
//-------------------------------------------------------------------

// 表示用会社ロゴ - IMGタグ生成
IF( $arrHeaderView["blog_cl_logo"] != "" ){
	$arrHeaderView["blog_cl_logo"] = "<IMG src=\"./img_thumbnail.php?w=200&h=60&dir={$param_cl_logo_path}&nm={$arrHeaderView["blog_cl_logo"]}\" alt=\"{$arrHeaderView["cl_name"]} {$arrHeaderView["cl_shiten"]}\">";
}

// ブログ説明文の改行処理
IF( $arrHeaderView["blog_discription"] != "" ){
	$arrHeaderView["blog_discription"] = nl2br( $arrHeaderView["blog_discription"] );
}



//-------------------------------------------------------------------
// エラー戻り時のMETA/HEADER値をメンバー変数へ
//-------------------------------------------------------------------
$arrErr["meta"] = $arrMetaHeader;
$arrErr["header"] = $arrHeaderView;


?>