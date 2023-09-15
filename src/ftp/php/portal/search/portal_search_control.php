<?php
/****************************************************
  不動産ブログ - 各種検索画面 - 処理内容コントロール
****************************************************/


// ---------------- ここから個別処理 -----------------//


	//----------------------------------------------
	// $_GET["page_flg"] ... 現在読み込んだページ
	//    "area"     : エリア検索画面
	//    "line"     : 沿線検索画面
	//    "sta-line" : 駅検索 - 沿線絞込み画面
	//    "sta"      : 駅検索画面
	//----------------------------------------------
	SWITCH( $_GET["page_flg"] ){
		// エリア検索画面読み込み
		Case "pref":
			// エリア検索画面表示内容処理
			require_once( SYS_PATH."php/portal/search/disp_portal_search_pref.php" );
			
			// 表示テンプレート呼び出し
			require_once( SYS_PATH."templates/portal/search/portal_search_pref.tpl" );
			
			break;
		
		Case "area":
			// エリア検索画面表示内容処理
			require_once( SYS_PATH."php/portal/search/disp_portal_search_area.php" );
			
			// 表示テンプレート呼び出し
			require_once( SYS_PATH."templates/portal/search/portal_search_area.tpl" );
			
			break;

		Case "arealine":
			// エリア検索画面表示内容処理
			require_once( SYS_PATH."php/portal/search/disp_portal_search_area.php" );
			
			// 表示テンプレート呼び出し
			require_once( SYS_PATH."templates/portal/search/portal_search_arealine.tpl" );
			
			break;

		Case "line":
			// エリア検索画面表示内容処理
			require_once( SYS_PATH."php/portal/search/disp_portal_search_line.php" );
			
			// 表示テンプレート呼び出し
			require_once( SYS_PATH."templates/portal/search/portal_search_line.tpl" );
			
			break;
		
		Case "staline":
			
			// エリア検索画面表示内容処理
			require_once( SYS_PATH."php/portal/search/disp_portal_search_line.php" );
			
			// 表示テンプレート呼び出し
			require_once( SYS_PATH."templates/portal/search/portal_search_station_line.tpl" );
			
			break;
		
		Case "sta":
			
			// エリア検索画面表示内容処理
			require_once( SYS_PATH."php/portal/search/disp_portal_search_station.php" );
			
			// 表示テンプレート呼び出し
			require_once( SYS_PATH."templates/portal/search/portal_search_station.tpl" );
			
			break;
		
		
		
		
		
		// 指定無しエラー
		default:
			$obj_error->ViewErrMessage( "MENT" , "PORTAL-USER" , _BLOG_SITE_URL_BASE , $arrErr );
			exit;
	}





?>