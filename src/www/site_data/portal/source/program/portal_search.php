<?php
/****************************************************
  塾ブログ - 各種検索画面
****************************************************/

/*----------------------------------------------------------
  必要ファイル呼び出し
----------------------------------------------------------*/
require_once ( "./ini_sets_1.php" );
require_once ( SYS_PATH."dbif/dbcom_DBconnectClass.php" );
require_once ( SYS_PATH."dbif/viewdb_CampainClass.php" );
require_once ( SYS_PATH."dbif/viewdb_DiaryClass.php" );
require_once ( SYS_PATH."dbif/viewdb_SearchCtiyClass.php" );
require_once ( SYS_PATH."dbif/viewdb_SearchLineClass.php" );
require_once ( SYS_PATH."dbif/viewdb_SearchPrefClass.php" );
require_once ( SYS_PATH."dbif/mstdb_LineClass.php" );

require_once ( SYS_PATH."common/base_common.php" );
require_once ( SYS_PATH."common/error.class.php" );

require_once ( SYS_PATH."configs/param_base.conf" );
require_once ( SYS_PATH."configs/param_file.conf" );


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


// 右メニュー内容生成
require_once( SYS_PATH."php/portal/disp_portal_right_menu.php" );


// 検索画面コントロール処理
//    ・各画面に表示する処理内容の振り分け
//    ・表示テンプレート呼び出し
require_once( SYS_PATH."php/portal/search/portal_search_control.php" );

/*----------------------------------------------------------
  ＤＢ切断
----------------------------------------------------------*/
require_once( SYS_PATH."common/db_close.php" );


?>
