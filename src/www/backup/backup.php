#!/usr/local/bin/php-cgi-4.4.2
<?

########################################################################


# �Хå����å��Ѵ��ץǥ��쥯�ȥ�
#$base_dir = "/usr/local/apache2/htdocs/slash";		// CL-�ƥ��ȥ����С���
#$base_dir = "/home/httpd/html/dev/slash/estate";	// CL-WWW�����С���
$base_dir = "/usr/home/p1097003";			// �ܴĶ���


# �Хå����å׽������ե�����ǥ��쥯�ȥ����
$backup_log_dir = $base_dir."/ftp/backup/log/";
$backup_log_file = "backup_log";
$backup_log_kaku = ".txt";

# ���ե�����Υե����륵�����κ�����
#    1MB�Ȥ������� ==>  1MB = 1024KB = 1048576B
$backup_log_size = 1048576;


# �Хå����åץե������Ĥ�����
#    3��ʬ��Ĥ� ==> 3
$backup_file_save = 3;


# �ǡ����١�����³��������
require_once( $base_dir."/ftp/configs/param_connect.conf" );
# �ǡ����١����Хå����åץǥ��쥯�ȥ����
$db_backup_dir = $base_dir."/ftp/backup/db/";


# �����Хå����å׸��ǥ��쥯�ȥ�
$img_backup_dir_before = $base_dir."/html/client_tool/cl_img";
# �����Хå����å���ǥ��쥯�ȥ�
$img_backup_dir_after = $base_dir."/ftp/backup/img/";


# �����������Хå����å׸��ǥ��쥯�ȥ�
$log_backup_dir_before = $base_dir."/html/site_data/blog/access_log";
# �����������Хå����å���ǥ��쥯�ȥ�
$log_backup_dir_after = $base_dir."/ftp/backup/access_log/";


########################################################################


// �ݴɴ��֤β᤮���ե������������ؿ�
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
    ���ե��������������
	���ե����뤬10M�ʾ�Ǥ���С������ե��������
	�ʸŤ��ե�����ϰ��̤����ݴɡ�
======================================================================*/
if ( file_exists( $backup_log_dir.$backup_log_file.$backup_log_kaku ) === false ) {
	// ���ե����뤬¸�ߤ��ʤ�
	//    ==> �������ե��������
	touch( $backup_log_dir.$backup_log_file.$backup_log_kaku );
} else {
	// ���ե����뤬¸�ߤ���
	//    ==> �ե����륵������ǧ
	$intLogFileSize = filesize( $backup_log_dir.$backup_log_file.$backup_log_kaku );
	if ( $intLogFileSize > $backup_log_size ) {
		// ����ե����륵������Ķ���Ƥ���
		//    ==> ��¸���ե�����̾���ѹ��������ե��������
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
		// ����ե����륵������Ķ���Ƥ��ʤ�
		//    ==> ��¸�Υ��ե��������Ѥ���
	}
}
$fp = fopen( $backup_log_dir.$backup_log_file.$backup_log_kaku , "a" );
$strLogWrite = "";
$strLogWrite .= "//=================================================\n";
$strLogWrite .= "// ".date("Y-m-d H:i:s")." BackUp start!\n";




	/*======================================================
	    vaccum_db �μ¹�
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
	    �����ڤ�Хå����åץե�����κ��
	     ��
	    slash-db �ΥХå����å�
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
	    �����ڤ�Хå����åץե�����κ��
	     ��
	    �����ե����� �ΥХå����å�
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
	    �����������ե����� �ΥХå����å�
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
