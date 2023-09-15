#!/usr/local/bin/php-cgi-4.4.2
<?

########################################################################


# バックアップ用基盤ディレクトリ
#$base_dir = "/usr/local/apache2/htdocs/slash";		// CL-テストサーバー用
#$base_dir = "/home/httpd/html/dev/slash/estate";	// CL-WWWサーバー用
$base_dir = "/usr/home/p1097003";			// 本環境用


# バックアップ処理ログファイルディレクトリ指定
$backup_log_dir = $base_dir."/ftp/backup/log/";
$backup_log_file = "backup_log";
$backup_log_kaku = ".txt";

# ログファイルのファイルサイズの最大値
#    1MBとして設定 ==>  1MB = 1024KB = 1048576B
$backup_log_size = 1048576;


# バックアップファイルを残す日数
#    3日分を残す ==> 3
$backup_file_save = 3;


# データベース接続情報設定
require_once( $base_dir."/ftp/configs/param_connect.conf" );
# データベースバックアップディレクトリ指定
$db_backup_dir = $base_dir."/ftp/backup/db/";


# 画像バックアップ元ディレクトリ
$img_backup_dir_before = $base_dir."/html/client_tool/cl_img";
# 画像バックアップ先ディレクトリ
$img_backup_dir_after = $base_dir."/ftp/backup/img/";


# アクセスログバックアップ元ディレクトリ
$log_backup_dir_before = $base_dir."/html/site_data/blog/access_log";
# アクセスログバックアップ先ディレクトリ
$log_backup_dir_after = $base_dir."/ftp/backup/access_log/";


########################################################################


// 保管期間の過ぎたファイルを削除する関数
function limit_file_delete( $strDirName , $intLimitDate ) {
	
	$dir = dir( $strDirName );
	while ( ($strName = $dir->read()) !== false ) {
		if ( $strName != "." && $strName != ".." ) {
			$intLimitTime = filectime( $strDirName.$strName ) + ( 86400 * $intLimitDate );
			if ( time() > $intLimitTime ) {
				unlink( $strDirName.$strName );
			}
		}
	}
	unset( $dir );
	
}




/*======================================================================
    ログファイル作成・開く
	ログファイルが10M以上であれば、新ログファイル作成
	（古いファイルは圧縮して保管）
======================================================================*/
if ( file_exists( $backup_log_dir.$backup_log_file.$backup_log_kaku ) === false ) {
	// ログファイルが存在しない
	//    ==> 新規ログファイル作成
	touch( $backup_log_dir.$backup_log_file.$backup_log_kaku );
} else {
	// ログファイルが存在する
	//    ==> ファイルサイズ確認
	$intLogFileSize = filesize( $backup_log_dir.$backup_log_file.$backup_log_kaku );
	if ( $intLogFileSize > $backup_log_size ) {
		// 指定ファイルサイズを超えている
		//    ==> 既存ログファイル名称変更、新ログファイル作成
		$iX = 0;
		while ( true ) {
			$iX++;
			if ( file_exists( $backup_log_dir.$backup_log_file.$iX.$backup_log_kaku ) === false ) {
				rename( $backup_log_dir.$backup_log_file.$backup_log_kaku , $backup_log_dir.$backup_log_file.$iX.$backup_log_kaku );
				touch( $backup_log_dir.$backup_log_file.$backup_log_kaku );
				break;
			}
		}
	} else {
		// 指定ファイルサイズを超えていない
		//    ==> 既存のログファイルを使用する
	}
}
$fp = fopen( $backup_log_dir.$backup_log_file.$backup_log_kaku , "a" );
$strLogWrite = "";
$strLogWrite .= "//=================================================\n";
$strLogWrite .= "// ".date("Y-m-d H:i:s")." BackUp start!\n";




	/*======================================================
	    vaccum_db の実行
	======================================================*/
	$strCommand = "/usr/local/pgsql7/bin/vacuumdb -f -z -U ".$param_db_connect["db_user"]." -W ".$param_db_connect["db_name"];
	exec( $strCommand , $out , $ret );
	if ( $ret != 0 ) {
		$strLogWrite .= "//     vaccum_db NG!\n";
		fwrite( $fp , $strLogWrite );
		fclose( $fp );
		exit;
	}


$strLogWrite .= "//     vaccum_db OK!\n";


	/*======================================================
	    期限切れバックアップファイルの削除
	     ＆
	    slash-db のバックアップ
	======================================================*/
	limit_file_delete( $db_backup_dir , $backup_file_save );
	$strCommand = "/usr/local/pgsql7/bin/pg_dump -U ".$param_db_connect["db_user"]." -W ".$param_db_connect["db_pwd"]." ".$param_db_connect["db_name"]." > ".$db_backup_dir."slash-db_".date("Ymd").".dmp";
	exec( $strCommand , $out , $ret );
	if ( $ret != 0 ) {
		$strLogWrite .= "//     slash-db pg_dump NG!\n";
		fwrite( $fp , $strLogWrite );
		fclose( $fp );
		exit;
	}


$strLogWrite .= "//     slash-db pg_dump OK!\n";


	/*======================================================
	    期限切れバックアップファイルの削除
	     ＆
	    画像ファイル のバックアップ
	======================================================*/
	limit_file_delete( $img_backup_dir_after , $backup_file_save );
	$strCommand = "/usr/bin/tar czvf ".$img_backup_dir_after."img_back".date("Ymd").".tar.gz ".$img_backup_dir_before;
	exec( $strCommand , $out , $ret );
	if ( $ret != 0 ) {
		$strLogWrite .= "//     image directory backup NG!\n";
		fwrite( $fp , $strLogWrite );
		fclose( $fp );
		exit;
	}


$strLogWrite .= "//     image directory backup OK!\n";


	/*======================================================
	    アクセスログファイル のバックアップ
	======================================================*/
	limit_file_delete( $log_backup_dir_after , $backup_file_save );
	$strCommand = "/usr/bin/tar czvf ".$log_backup_dir_after."access_log_back".date("Ymd").".tar.gz ".$log_backup_dir_before;
	exec( $strCommand , $out , $ret );
	if ( $ret != 0 ) {
		$strLogWrite .= "//     access_log directory backup NG!\n";
		fwrite( $fp , $strLogWrite );
		fclose( $fp );
		exit;
	}
	

$strLogWrite .= "//     access_log directory backup OK!\n";
$strLogWrite .= "//         all backup complete!!\n\n";

fwrite( $fp , $strLogWrite );
fclose( $fp );


?>
