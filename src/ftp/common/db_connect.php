<?
/*----------------------------------------------------------
  DBÀÜÂ³
----------------------------------------------------------*/

$obj_conn = new dbcom_DBconnectClass;
$ret_db = $obj_conn->dbcom_DbConnect ();
if ( $ret_db == -1 ) {
	basecom_ErrmsgJmp ( "" , $syserr_msg , $obj_conn->php_error );
	exit;
}

?>