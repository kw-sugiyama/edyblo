<?
/*----------------------------------------------------------
  アカウント管理ツール用 - ログイン情報チェック
----------------------------------------------------------*/
function syscom_LoginChk_CL( $conn , $login_id , $login_pass , $adminid ){
	
	$obj_loginchk = new basedb_AdminClassTblAccess;
	$obj_loginchk->conn = $conn;
	$obj_loginchk->admindat[0]["ad_logincd"] = $login_id;
	$obj_loginchk->admindat[0]["ad_passcd"] = $login_pass;
	$ret = $obj_loginchk->basedb_CheckAdmin ();
	$val["ad_auth"] = $obj_loginchk->admindat[0]["ad_auth"];
	if ( $ret != "0" ) {
		return Array( -1 , NULL );
	}
	if ( $obj_loginchk->admindat[0]["ad_id"] != $adminid ) {
		return Array( -1 , NULL );
	}

	return Array( 0 , $val );

}


/*----------------------------------------------------------
  クライアント管理ツール用 - ログイン情報チェック
----------------------------------------------------------*/
function syscom_LoginChk_Client( $conn , $cl_id , $login_id , $login_pass , $limit_date ){
	
	$obj_loginchk_cl = new basedb_ClientClassTblAccess;
	$obj_loginchk_cl->conn = $conn;
	$obj_loginchk_cl->clientdat[0]["cl_logincd"] = sha1($login_id);
	$obj_loginchk_cl->clientdat[0]["cl_passcd"] = sha1($login_pass);
	$ret = $obj_loginchk_cl->basedb_CheckClient ();
	if ( $ret != "0" ) {
		return Array( $ret , NULL );
	}
	$arrVal = $obj_loginchk_cl->clientdat[0];
	
	return Array( 0 , $arrVal );

}


?>
