<?
/*----------------------------------------------------------
  ฃฤฃยภฺรว
----------------------------------------------------------*/
$ret_db = $obj_conn->dbcom_DbDisconnect ();
if ( $ret_db == -1 ) {
	basecom_ErrmsgJmp ( "login.php",$syserr_msg,$obj_conn->php_error );
	exit;
}

?>