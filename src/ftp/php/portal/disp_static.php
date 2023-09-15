<?php
/*==============================================================
    静的ページ表示内容生成ファイル
==============================================================*/


SWITCH( $_GET["tpl_flg"] ){
	// サイトマップ
	Case "sitemap":
		//title
		$view_header_title = "";
		$view_header_title = 'サイトマップ｜学習塾・進学塾・塾探しのポータルサイト「塾タウン」';
		//keywords
		$view_header_keywoeds = "";
		$view_header_keywoeds = "学習塾,進学塾,個別指導,中学受験,塾タウン,小学校,中学校,高校,中高一貫,サイトマップ";
		//description
		$view_header_description = "";
		$view_header_description = "塾タウンのサイトマップです。塾タウンは学習塾・進学塾探しのポータルサイトです。地域や目的（受験対策・補修）、";
		$view_header_description .= '指導形式（個別指導・少人数指導・集団指導）、対象（小学校・中学校・高校・大学）などから簡単に塾を検索できます。';
		break;
	// サイト規約
	Case "kiyaku":
		//title
		$view_header_title = "";
		$view_header_title = 'サイト規約｜学習塾・進学塾・塾探しのポータルサイト「塾タウン」';
		//keywords
		$view_header_keywoeds = "";
		$view_header_keywoeds = "学習塾,進学塾,個別指導,中学受験,塾タウン,小学校,中学校,高校,サイト規約";
		//description
		$view_header_description = "";
		$view_header_description = "塾タウンのサイト規約です。塾タウンは学習塾・進学塾探しのポータルサイトです。地域や目的（受験対策・補修）、";
		$view_header_description .= '指導形式（個別指導・少人数指導・集団指導）、対象（小学校・中学校・高校・大学）などから簡単に塾を検索できます。';
		break;
	// 運営会社
	Case "com":
		//title
		$view_header_title = "";
		$view_header_title = '運営会社｜学習塾・進学塾・塾探しのポータルサイト「塾タウン」';
		//keywords
		$view_header_keywoeds = "";
		$view_header_keywoeds = "学習塾,進学塾,個別指導,中学受験,塾タウン,小学校,中学校,高校,運営会社";
		//description
		$view_header_description = "";
		$view_header_description = "塾タウンの運営会社情報ページです。塾タウンは学習塾・進学塾探しのポータルサイトです。地域や目的（受験対策・補修）、";
		$view_header_description .= '指導形式（個別指導・少人数指導・集団指導）、対象（小学校・中学校・高校・大学）などから簡単に塾を検索できます。';
		break;
	// 個人情報保護方針
	Case "privacy":
		//title
		$view_header_title = "";
		$view_header_title = '個人情報保護方針｜学習塾・進学塾・塾探しのポータルサイト「塾タウン」';
		//keywords
		$view_header_keywoeds = "";
		$view_header_keywoeds = "学習塾,進学塾,個別指導,中学受験,塾タウン,小学校,中学校,高校,個人情報保護方針";
		//description
		$view_header_description = "";
		$view_header_description = "塾タウンの個人情報保護方針のページです。塾タウンは学習塾・進学塾探しのポータルサイトです。地域や目的（受験対策・補修）、";
		$view_header_description .= '指導形式（個別指導・少人数指導・集団指導）、対象（小学校・中学校・高校・大学）などから簡単に塾を検索できます。';
		break;
	// お問い合わせ
	Case "inquiry":
		//title
		$view_header_title = "";
		$view_header_title = 'お問合せ｜学習塾・進学塾・塾探しのポータルサイト「塾タウン」';
		//keywords
		$view_header_keywoeds = "";
		$view_header_keywoeds = "学習塾,進学塾,個別指導,中学受験,塾タウン,小学校,中学校,高校,中高一貫,公立,私立,お問合せ";
		//description
		$view_header_description = "";
		$view_header_description = "塾タウンの問合せページです。塾タウンは学習塾・進学塾探しのポータルサイトです。地域や目的（受験対策・補修）、";
		$view_header_description .= '指導形式（個別指導・少人数指導・集団指導）、対象（小学校・中学校・高校・大学）などから簡単に塾を検索できます。';
		break;
}


?>