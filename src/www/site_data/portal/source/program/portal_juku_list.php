<?php
/****************************************************
  塾ブログ - 塾一覧ページ
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
require_once ( SYS_PATH."dbif/basedb_AreaClass.php" );

require_once ( SYS_PATH."common/base_common.php" );
require_once ( SYS_PATH."common/error.class.php" );

require_once ( SYS_PATH."configs/param_base.conf" );
require_once ( SYS_PATH."configs/param_file.conf" );


/*-------------------------------------------
   セッションスタート
-------------------------------------------*/
session_start();


/*-------------------------------------------
	エラークラス - インスタンス
-------------------------------------------*/
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


// TOPページ内容生成
//    => TOPページ用表示内容を生成
//    => 生成値は $arrViewIndex に格納
require_once( SYS_PATH."php/portal/disp_portal_juku_list.php" );


// 条件検索用ボックス生成
require_once( SYS_PATH."php/portal/disp_portal_search_jyokenbox.php" );


// 右メニュー内容生成
require_once( SYS_PATH."php/portal/disp_portal_right_menu.php" );

/*----------------------------------------------------------
  ＤＢ切断
----------------------------------------------------------*/
require_once( SYS_PATH."common/db_close.php" );


/*-------------------------------------------
   テンプレート表示
-------------------------------------------*/
require_once( SYS_PATH."templates/portal/portal_juku_list.tpl" );


?>