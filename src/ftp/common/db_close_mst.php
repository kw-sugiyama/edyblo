<?
/*----------------------------------------------------------
  ฃฤฃยภฺรว
----------------------------------------------------------*/
$ret_db_mst = $obj_conn_mst->dbcom_DbDisconnectMst ();
if ( $ret_db_mst == -1 ) {
	basecom_ErrmsgJmp ( "login.php" , $syserr_msg , $obj_conn_mst->php_error );
	exit;
}

?>