<?
/******************************************************************************
<< 不動産ブログ　Ver.1.O.0 >>
	Name: master_line_upd.php
	Version: 1.0.0
	Function: 沿線駅マスタＵＰ処理
	Author: Click inc
	Date of creation: 2007/02
	History of modification:

	Copyright (C)2007 Click, inc. All Rights Reserverd.
******************************************************************************/

// fgetcsvの文字化け回避に 2010/06/14大塚
setlocale(LC_ALL,'ja_JP');

/*----------------------------------------------------------
  必要ファイル呼び出し
----------------------------------------------------------*/
require_once ( "../ini_sets_2.php" );
require_once ( SYS_PATH."dbif/dbcom_DBconnectClass.php" );
require_once ( SYS_PATH."dbif/dbcom_DBconnectMstClass.php" );
require_once ( SYS_PATH."dbif/basedb_AdminClass.php" );
require_once ( SYS_PATH."dbif/mstdb_LineClass.php" );
require_once ( SYS_PATH."common/error.class.php" );
require_once ( SYS_PATH."common/sys_common.php" );
require_once ( SYS_PATH."configs/param_file.conf" );


/*----------------------------------------------------------
  セッション登録開始
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
require_once( SYS_PATH."common/db_connect_mst.php" );


/*----------------------------------------------------------
  ログイン情報チェック
----------------------------------------------------------*/
require_once("../login_chk.php");
if( $login_val["ad_auth"] != "0" ){
	$obj_error->ViewErrMessage( "ACCESS" , "ALL" , SITE_PATH."blank.php" , NULL );
	exit;
}


/*--------------------------------------------------------
  ＵＰファイル確認
--------------------------------------------------------*/
mt_srand(microtime()*100000);
$strRand = md5( uniqid( mt_rand() , 1 ) );

$strFileName = "";
if ( is_uploaded_file( $_FILES['line_master']['tmp_name'] ) ) {
	$strFileName = "mst_line_".$strRand.".csv";
	move_uploaded_file( $_FILES['line_master']['tmp_name'] , $param_mst_file_path.$strFileName );
	chmod( $param_mst_file_path.$strFileName , 0600 );
} else {
	$obj_error->ViewErrMessage( "SYSTEM" , "ALL" , "master_main.php" , NULL );
	exit;
}
if ( ! ( $fp = fopen( $param_mst_file_path.$strFileName ,"r" ) ) ) {
	$obj_error->ViewErrMessage( "SYSTEM" , "ALL" , "master_main.php" , NULL );
	exit;
}


/*--------------------------------------------------------
  文字コード変換後ファイル生成
--------------------------------------------------------*/
$strChangeFile = "mst_line_insert_".$strRand.".csv";
if ( ! ( $fp2 = fopen( $param_mst_file_path.$strChangeFile , "w" ) ) ) {
	$obj_error->ViewErrMessage( "SYSTEM" , "ALL" , "master_main.php" , NULL );
	unlink( $param_mst_file_path.$strFileName );
	exit;
}
$iX= 0;
WHILE( $arrBuffLine = fgetcsv ( $fp , 4096 , "\t" ) ) {
	$strBuffCsv = "";
	$strBuffCsv .= "{$arrBuffLine[0]}	";	// エリア番号
	$strBuffCsv .= "{$arrBuffLine[1]}	";	// エリア名
	$strBuffCsv .= "{$arrBuffLine[2]}	";	// 県コード
	$strBuffCsv .= "{$arrBuffLine[3]}	";	// 県名
	$strBuffCsv .= "{$arrBuffLine[4]}	";	// 沿線コード
	$strBuffCsv .= "{$arrBuffLine[5]}	";	// 沿線名
	$strBuffCsv .= "{$arrBuffLine[6]}	";	// 沿線名（かな）
	$strBuffCsv .= "{$arrBuffLine[7]}	";	// 駅コード
	$strBuffCsv .= "{$arrBuffLine[8]}	";	// 駅名
	$strBuffCsv .= "{$arrBuffLine[9]}";		// 駅名（かな）
	$strBuffCsv .= "\n";
	
// EUCのファイルをそのままアップロードするように変更 2010/06/14大塚	$strCsv = mb_convert_encoding( $strBuffCsv , "EUC" , "SJIS" );
	
	//fwrite( $fp2 , $strCsv );
	fwrite( $fp2 , $strBuffCsv );
	
	$iX++;
}
fclose( $fp2 );
fclose( $fp );


/* ＥＵＣコード変換ＣＳＶファイルオープン */
if ( ! ( $fp3 = fopen( $param_mst_file_path.$strChangeFile , "r" ) ) ) {
	$obj_error->ViewErrMessage( "SYSTEM" , "ALL" , "master_main.php" , NULL );
	unlink( $param_mst_file_path.$strFileName );
	unlink( $param_mst_file_path.$strChangeFile );
	exit;
}


/*--------------------------------------------------------
  処理部分
--------------------------------------------------------*/
$obj_line = new mstdb_LineClassTblAccess;
$obj_line->conn = $obj_conn_mst->conn;
$iY = 0;
WHILE( $arrBuffLine2 = fgetcsv( $fp3 , 4096 , "\t" ) ) {
	$obj_line->linedat[$iY]["st_areacd"] = $arrBuffLine2[0];
	$obj_line->linedat[$iY]["st_area"] = $arrBuffLine2[1];
	$obj_line->linedat[$iY]["st_prefcd"] = $arrBuffLine2[2];
	$obj_line->linedat[$iY]["st_pref"] = $arrBuffLine2[3];
	$obj_line->linedat[$iY]["st_linecd"] = $arrBuffLine2[4];
	$obj_line->linedat[$iY]["st_line"] = $arrBuffLine2[5];
	$obj_line->linedat[$iY]["st_linekana"] = $arrBuffLine2[6];
	$obj_line->linedat[$iY]["st_stacd"] = $arrBuffLine2[7];
	$obj_line->linedat[$iY]["st_sta"] = $arrBuffLine2[8];
	$obj_line->linedat[$iY]["st_stakana"] = $arrBuffLine2[9];
	$iY++;
}
list( $ret , $intInsCnt ) = $obj_line->mstdb_InsLineAll();
IF( $ret == "-1" ){
	$obj_error->ViewErrMessage( "SYSTEM" , "ALL" , "master_main.php" , NULL );
	exit;
}ELSEIF( $ret == 1 ){
	$viewComment = "既存のデータが存在しているため、登録処理を行いませんでした。<br />一度削除をしてから登録処理を行って下さい。";
}ELSE{
	$viewComment = $intInsCnt."件の沿線駅情報が登録されました。";
}

// ファイル削除
unlink( $param_mst_file_path.$strFileName );
unlink( $param_mst_file_path.$strChangeFile );


/*----------------------------------------------------------
  ＤＢ切断
----------------------------------------------------------*/
require_once( SYS_PATH."common/db_close.php" );
require_once( SYS_PATH."common/db_close_mst.php" );


/*----------------------------------------------------------
  ＨＴＭＬ生成
----------------------------------------------------------*/
?>
<HTML>
  <HEAD>
    <TITLE>不動産ブログ - アカウント管理ツール</TITLE>
    <META http-equiv="Content-Type" content="text/html;charset=EUC-JP" />
    <META http-equiv="Content-Style-Type" content="text/css" />
    <META http-equiv="Content-Script-Type" content="text/javascript" />
    <LINK rel="stylesheet" type="text/css" href="./share/css/master.css" />
    <NOSCRIPT><META http-equiv="Refresh" content="1;URL=./jserror.html"></NOSCRIPT>
  </HEAD>
  <BODY>
    <div align="center">
      <table width="400" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td align="center">
            <br /><br /><br /><br /><br />
            <font size="3" color="#FF6600"><?=$viewComment?></font>
            <br /><br /><br />
          </td>
        </tr>
      </table>
      <form name="form1" method="POST" action="master_main.php"> 
        <input type="submit" value=" 戻 る " class="btn" />
      </form>
    </div>
  </BODY>
</HTML>
