<?php
/****************************************************
  不動産ブログ - 各クライアント別TOPページ
****************************************************/

/*----------------------------------------------------------
  必要ファイル呼び出し
----------------------------------------------------------*/
require_once ( "./ini_sets_1.php" );
require_once ( "./html_replace.php" );
require_once ( SYS_PATH."dbif/dbcom_DBconnectClass.php" );
require_once ( SYS_PATH."dbif/basedb_ClientClass.php" );
require_once ( SYS_PATH."dbif/basedb_RoomClass.php" );
require_once ( SYS_PATH."dbif/basedb_CategoryClass.php" );
require_once ( SYS_PATH."dbif/basedb_BlogClass.php" );
require_once ( SYS_PATH."dbif/basedb_DiaryClass.php" );
require_once ( SYS_PATH."dbif/viewdb_ClientClass.php" );
require_once ( SYS_PATH."dbif/viewdb_BuildClass.php" );
require_once ( SYS_PATH."common/base_common.php" );
require_once ( SYS_PATH."common/sys_common.php" );
require_once ( SYS_PATH."common/form_common.php" );
require_once ( SYS_PATH."common/error.class.php" );
require_once ( SYS_PATH."configs/param_base.conf" );
require_once ( SYS_PATH."configs/param_room.conf" );
require_once ( SYS_PATH."configs/param_file.conf" );
require_once ( SYS_PATH."configs/param_map.conf" );


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

// クライアントチェック＆レイアウト指定
//    => $obj_login に指定クライアント情報格納済
//    => SESSION["_cl_id"]に指定クライアントID保持
//    => レイアウト情報は、定数"_SITE_LAYOUT"に保持
require_once( SYS_PATH."php/portal/portal_client_check.php" );


// 右メニュー内容生成
require_once( SYS_PATH."php/portal/disp_portal_left_menu.php" );

/*----------------------------------------------------------
  ＤＢ切断
----------------------------------------------------------*/
require_once( SYS_PATH."common/db_close.php" );


/*-------------------------------------------
   テンプレート表示
-------------------------------------------*/
require_once( SYS_PATH."templates/portal/portal_error.tpl" );

?>
