<?php
/****************************************************
  塾ブログ - ポータル静的ページ
****************************************************/

/*----------------------------------------------------------
  必要ファイル呼び出し
----------------------------------------------------------*/
require_once ( "./ini_sets_1.php" );
require_once ( "./html_replace.php" );
require_once ( SYS_PATH."dbif/dbcom_DBconnectClass.php" );
require_once ( SYS_PATH."dbif/viewdb_CampainClass.php" );
require_once ( SYS_PATH."dbif/viewdb_DiaryClass.php" );
require_once ( SYS_PATH."dbif/viewdb_SearchCtiyClass.php" );
require_once ( SYS_PATH."dbif/viewdb_SearchLineClass.php" );
require_once ( SYS_PATH."dbif/viewdb_SearchPrefClass.php" );

require_once ( SYS_PATH."common/base_common.php" );
require_once ( SYS_PATH."common/error.class.php" );

require_once ( SYS_PATH."configs/param_base.conf" );
require_once ( SYS_PATH."configs/param_file.conf" );
require_once ( SYS_PATH."configs/param_mail.conf" );

/*----------------------------------------------------------
    セッションスタート
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
    処理ファイル呼び出し
----------------------------------------------------------*/

// ヘッダー情報生成
//    => 画面上の表示内容を生成
//    => 生成値は $arrHeaderView 又は $arrMetaHeader に格納
require_once( SYS_PATH."php/portal/disp_portal_header.php" );

require_once( SYS_PATH."php/portal/disp_static.php" );

// 右メニュー内容生成
require_once( SYS_PATH."php/portal/disp_portal_right_menu.php" );

/*----------------------------------------------------------
  ＤＢ切断
----------------------------------------------------------*/
require_once( SYS_PATH."common/db_close.php" );

/*-------------------------------------------
	表示テンプレート呼び出し
-------------------------------------------*/
	SWITCH( $_GET["tpl_flg"] ){
		// サイトマップ
		Case "sitemap":
			require_once( SYS_PATH."templates/portal/portal_sitemap.tpl" );
			break;
		// サイト規約
		Case "kiyaku":
			require_once( SYS_PATH."templates/portal/portal_kiyaku.tpl" );
			break;
		// 運営会社
		Case "com":
			require_once( SYS_PATH."templates/portal/portal_com.tpl" );
			break;
		// 個人情報保護方針
		Case "privacy":
			require_once( SYS_PATH."templates/portal/portal_privacy.tpl" );
			break;
		// お問い合わせ
		Case "inquiry":
			require_once( SYS_PATH."templates/portal/portal_inquiry.tpl" );
			break;
		// 指定無しエラー
		default:
			$obj_error->ViewErrMessage( "MENT" , "PORTAL-USER" , "/" , $arrErr );
			exit;
	}

?>
