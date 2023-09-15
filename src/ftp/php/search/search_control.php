<?php
/****************************************************
  不動産ブログ - 各種検索画面 - 処理内容コントロール
****************************************************/


// ---------------- ここから共通処理 -----------------//


// クライアントチェック＆レイアウト指定
//    => $obj_login に指定クライアント情報格納済
//    => SESSION["_cl_id"]に指定クライアントID保持
//    => レイアウト情報は、定数"_SITE_LAYOUT"に保持
require_once( SYS_PATH."php/client_check.php" );


// ヘッダー情報生成
//    => 画面上の表示内容を生成
//    => 生成値は $arrHeaderView 又は $arrMetaHeader に格納
require_once( SYS_PATH."php/disp_header.php" );


// カテゴリー一覧情報生成
//    => 画面中央左の表示内容を生成
//    => 生成値は $arrViewLeft に格納
require_once( SYS_PATH."php/disp_left.php" );


// ログファイルへ書き込み処理
//    => 指定ログディレクトリにあるファイルへ書き込み
//    => アドレスは ○○ に格納
require_once( SYS_PATH."php/disp_log_write.php" );



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
		Case "area":
			
			// エリア検索画面表示内容処理
			require_once( SYS_PATH."php/search/disp_search_area.php" );
			
			// 表示テンプレート呼び出し
			require_once( SYS_PATH."templates/search/search_area.tpl" );
			
			break;
		
		Case "line":
			
			// エリア検索画面表示内容処理
			require_once( SYS_PATH."php/search/disp_search_line.php" );
			
			// 表示テンプレート呼び出し
			require_once( SYS_PATH."templates/search/search_line.tpl" );
			
			break;
		
		Case "staline":
			
			// エリア検索画面表示内容処理
			require_once( SYS_PATH."php/search/disp_search_line.php" );
			
			// 表示テンプレート呼び出し
			require_once( SYS_PATH."templates/search/search_station_line.tpl" );
			
			break;
		
		Case "sta":
			
			// エリア検索画面表示内容処理
			require_once( SYS_PATH."php/search/disp_search_station.php" );
			
			// 表示テンプレート呼び出し
			require_once( SYS_PATH."templates/search/search_station.tpl" );
			
			break;
		
		
		
		
		// 指定無しエラー
		default:
			$obj_error->ViewErrMessage( "MENT" , "USER" , _BLOG_SITE_URL_BASE , $arrErr );
			exit;
	}





?>
