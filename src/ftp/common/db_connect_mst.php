<?
/*----------------------------------------------------------
  Ž£ŽÄŽ£ŽÂŽÀŽÜŽÂŽ³
----------------------------------------------------------*/

$obj_conn_mst = new dbcom_DBconnectMstClass;
$ret_db_mst = $obj_conn_mst->dbcom_DbConnectMst ();
if ( $ret_db_mst == -1 ) {
	basecom_ErrmsgJmp ( "" , $syserr_msg , $obj_conn_mst->php_error );
	exit;
}

?>