<?php
/****************************************************
		物件一覧ページ
****************************************************/


require_once ( "./ini_sets_1.php" );
require_once ( "./html_replace.php" );
require_once ( SYS_PATH."/dbif/dbcom_DBconnectClass.php" );
require_once ( SYS_PATH."/dbif/basedb_RoomClass.php" );
require_once ( SYS_PATH."/dbif/viewdb_BuildClass.php" );
require_once ( SYS_PATH."/dbif/viewdb_ClientClass.php" );
require_once ( SYS_PATH."/dbif/basedb_CategoryClass.php" );
require_once ( SYS_PATH."/dbif/basedb_BlogClass.php" );
require_once ( SYS_PATH."/common/base_common.php" );
require_once ( SYS_PATH."/common/sys_common.php" );
require_once ( SYS_PATH."/common/form_common.php" );
require_once ( SYS_PATH."/common/error.class.php" );
require_once ( SYS_PATH."/configs/param_base.conf" );
require_once ( SYS_PATH."/configs/param_build.conf" );
require_once ( SYS_PATH."/configs/param_file.conf" );
require_once ( SYS_PATH."/configs/param_map.conf" );
require_once ( SYS_PATH."/configs/param_room.conf" );
require_once ( SYS_PATH."/configs/param_search.conf" );


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


// TOPページ内容生成
//    => TOPページ用表示内容を生成
//    => 生成値は $arrViewIndex に格納
require_once( SYS_PATH."php/disp_build_list.php" );

// ログファイルへ書き込み処理
//    => 指定ログディレクトリにあるファイルへ書き込み
//    => アドレスは ○○ に格納
require_once( SYS_PATH."php/disp_log_write.php" );


/*----------------------------------------------------------
  ＤＢ切断
----------------------------------------------------------*/
require_once( SYS_PATH."common/db_close.php" );


/*-------------------------------------------
   ベーステンプレート表示
-------------------------------------------*/
include( SYS_PATH."templates/build_list.tpl" );

?>
